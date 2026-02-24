<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\File;

class MediaUploadService
{
    /**
     * Cuando save_to = storage se usa este disk.
     */
    private string $defaultDisk = 'public';

    private array $typeRules = [
        'audio' => ['mime_prefix' => 'audio/', 'ext' => ['mp3','wav','ogg','m4a','aac','flac','webm']],
        'image' => ['mime_prefix' => 'image/', 'ext' => ['jpg','jpeg','png','gif','webp','svg']],
        'video' => ['mime_prefix' => 'video/', 'ext' => ['mp4','webm','mov','mkv']],
        'doc'   => ['mime_prefix' => null,     'ext' => ['pdf','doc','docx','xls','xlsx','ppt','pptx','txt','csv','zip','rar']],
    ];

    /**
     * @param UploadedFile[] $files
     * @param array $opts
     * required:
     * - type: audio|image|video|doc
     * - dir:  string   ej: dictionary/audio/pronunciation
     * - insert: callable(array $payload): int
     *
     * optional:
     * - save_to: 'public'|'storage'   ✅ default public
     * - disk: string (solo si save_to=storage)
     * - buildMeta: callable(array $baseMeta): array
     */
    public function uploadMany(array $files, array $opts): array
    {
        $opts = $this->normalizeOptions($opts);
        $this->assertOptions($opts);

        $stored = []; // para cleanup: [{save_to, path, disk?}]

        try {
            return DB::transaction(function () use ($files, $opts, &$stored) {
                $uploaded = [];

                foreach ($files as $file) {
                    $this->assertAllowedByType($file, $opts['type']);

                    $originalName = $file->getClientOriginalName();
                    $mime = $file->getClientMimeType() ?? $file->getMimeType() ?? null;
                    $size = (int) $file->getSize();

                    // 1) guardar archivo (según save_to)
                    $saved = $this->storeFile($file, $opts, $originalName);
                    $stored[] = $saved['stored_ref'];

                    // 2) meta base
                    $meta = [
                        'type' => $opts['type'],
                        'mime' => $mime,
                        'size' => $size,
                        'original_name' => $originalName,
                        'stored_path' => $saved['stored_path'],
                        'url' => $saved['url'],
                        'save_to' => $opts['save_to'],           // public|storage
                        'disk' => $saved['disk'],                // null o disk name
                    ];

                    // meta extendida (opcional)
                    if (!empty($opts['buildMeta']) && is_callable($opts['buildMeta'])) {
                        $extra = ($opts['buildMeta'])($meta);
                        if (is_array($extra)) $meta = array_merge($meta, $extra);
                    }

                    $payload = [
                        'value' =>$originalName,
                        'description' => $this->toJson($meta),
                        'source' => $saved['url'],

                    ];

                    $id = ($opts['insert'])($payload);

                    $uploaded[] = [
                        'id' => $id,
                        'name' => $originalName,
                        'url' => $saved['url'],
                        'mime' => $mime,
                        'size' => $size,
                    ];
                }

                return [
                    'uploaded' => $uploaded,
                ];
            });
        } catch (Throwable $e) {
            $this->safeDeleteMany($stored);
            throw $e;
        }
    }

    /**
     * Borra un archivo por referencia (save_to + path + disk opcional)
     * Útil en catch / rollback.
     */
    public function deleteStoredRef(array $storedRef): void
    {
        $saveTo = $storedRef['save_to'] ?? null;
        $path   = $storedRef['path'] ?? null;

        if (!$saveTo || !$path) return;

        if ($saveTo === 'storage') {
            $disk = $storedRef['disk'] ?? $this->defaultDisk;
            Storage::disk($disk)->delete($path);
            return;
        }

        // public físico
        $abs = public_path($path);
        if ($abs && file_exists($abs)) @unlink($abs);
    }

    // ----------------- helpers -----------------

    private function normalizeOptions(array $opts): array
    {
        // ✅ default: PUBLIC físico (lo que pediste)
        $opts['save_to'] = $opts['save_to'] ?? 'public'; // public|storage

        // si usan storage, disk opcional
        $opts['disk'] = $opts['disk'] ?? $this->defaultDisk;

        // limpia dir
        $opts['dir'] = trim($opts['dir'] ?? '', '/');

        return $opts;
    }

    private function assertOptions(array $opts): void
    {
        foreach (['type','dir','insert','save_to'] as $k) {
            if (!array_key_exists($k, $opts) || $opts[$k] === null || $opts[$k] === '') {
                throw new \InvalidArgumentException("MediaUploadService: falta opción requerida: {$k}");
            }
        }

        // Normaliza types: "audio,video" -> ["audio","video"]
        $types = $opts['type'];
        if (is_string($types)) {
            $types = array_filter(array_map('trim', explode(',', $types)));
        } elseif (!is_array($types)) {
            throw new \InvalidArgumentException("MediaUploadService: type debe ser string CSV o array");
        }

        if (empty($types)) {
            throw new \InvalidArgumentException("MediaUploadService: type vacío");
        }

        // Valida que cada type exista en rules
        foreach ($types as $t) {
            if (!isset($this->typeRules[$t])) {
                throw new \InvalidArgumentException("MediaUploadService: type inválido: {$t}");
            }
        }

        // (Opcional) guarda normalizado para que el resto del servicio lo use consistente
        $opts['type'] = $types; // si quieres, retorna $opts o guárdalo en una propiedad

        if (!in_array($opts['save_to'], ['public','storage'], true)) {
            throw new \InvalidArgumentException("MediaUploadService: save_to inválido: {$opts['save_to']}");
        }

        if (!is_callable($opts['insert'])) {
            throw new \InvalidArgumentException("MediaUploadService: insert debe ser callable");
        }
    }

    private function assertAllowedByType(UploadedFile $file, string|array $types): void
    {
        // Normaliza: "audio,video" -> ["audio","video"]
        if (is_string($types)) {
            $types = array_filter(array_map('trim', explode(',', $types)));
        }

        $mime = strtolower($file->getClientMimeType() ?? $file->getMimeType() ?? '');
        $ext  = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: '');

        $errors = [];

        foreach ($types as $type) {
            if (!isset($this->typeRules[$type])) {
                $errors[] = "Tipo no soportado: {$type}";
                continue;
            }

            $rule = $this->typeRules[$type];

            $extOk = $ext ? in_array($ext, $rule['ext'], true) : false;

            if (!empty($rule['mime_prefix'])) {
                $mimeOk = str_starts_with($mime, $rule['mime_prefix']); // o Str::startsWith
                if ($mimeOk && $extOk) {
                    return; // ✅ válido por este tipo
                }
                $errors[] = "No cumple {$type}: mime={$mime}, ext={$ext}";
                continue;
            }

            if ($extOk) {
                return; // ✅ válido por este tipo (solo por extensión)
            }

            $errors[] = "No cumple {$type}: ext={$ext}";
        }

        // ❌ si no pasó por ningún tipo
        throw new \RuntimeException("Archivo inválido para tipos [" . implode(',', $types) . "]. " . implode(' | ', $errors));
    }

    private function storeFile(UploadedFile $file, array $opts, string $originalName): array
    {
        $dir = $opts['dir'];
        $storedName = $this->makeStoredName($file, $originalName);

        // ✅ 1) PUBLIC físico
        if ($opts['save_to'] === 'public') {
            $targetDir = public_path($dir);
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0775, true);
            }

            $file->move($targetDir, $storedName);

            $relPath = $dir . '/' . $storedName;  // relativo a /public
            return [
                'stored_path' => $relPath,
                'url' => ($relPath),
                'disk' => null,
                'stored_ref' => [
                    'save_to' => 'public',
                    'path' => $relPath,
                ],
            ];
        }

        // ✅ 2) STORAGE (disk)
        $disk = $opts['disk'] ?? $this->defaultDisk;

        // guarda en storage/app/{disk}/{dir}
        $path = $file->storeAs($dir, $storedName, $disk);
        $url  = Storage::disk($disk)->url($path);

        return [
            'stored_path' => $path,
            'url' => $url,
            'disk' => $disk,
            'stored_ref' => [
                'save_to' => 'storage',
                'disk' => $disk,
                'path' => $path,
            ],
        ];
    }

    private function makeStoredName(UploadedFile $file, string $originalName): string
    {
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: '');
        $base = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        return $base . '-' . Str::random(10) . ($ext ? ".{$ext}" : '');
    }

    private function toJson(array $meta): string
    {
        $clean = array_filter($meta, fn($v) => $v !== null && $v !== '');
        return json_encode($clean, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function safeDeleteMany(array $storedRefs): void
    {
        foreach ($storedRefs as $ref) {
            try {
                $this->deleteStoredRef($ref);
            } catch (Throwable $e) {
                // opcional: log
            }
        }
    }
    public function deletePhysical(?string $storedPath, string $saveTo = 'public', string $disk = 'public'): void
    {
        if (!$storedPath) return;

        // normaliza
        $storedPath = preg_replace('#^https?://[^/]+/#', '', $storedPath);
        $storedPath = ltrim($storedPath, '/');

        if ($saveTo === 'storage') {
            Storage::disk($disk)->delete($storedPath);
            return;
        }

        // ✅ default: public físico
        $full = public_path($storedPath);
        if (File::exists($full)) {
            File::delete($full);
        }
    }
}
