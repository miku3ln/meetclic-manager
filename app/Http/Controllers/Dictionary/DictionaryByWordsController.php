<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\MyBaseController;
use App\Models\Dictionary\DictionaryByWords;
use App\Services\MediaUploadService;
use App\Support\ApiResponse;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
class DictionaryByWordsController extends MyBaseController
{


    public function getDictionaryData(Request $request)
    {
        $dataPost = $request->all();
        $model = new DictionaryByWords();
        $result = $model->getDictionaryData($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveWord(Request $request)
    {
        $dataPost = $request->all();

        $model = new DictionaryByWords();
        $result = $model->saveData(["attributesPost" => $dataPost]);
        return Response::json(
            $result
        );
    }


    public function dictionaryPronunciationUpload(Request $request, MediaUploadService $svc)
    {

        try {
           /* dd([
                // ✅ todo lo que NO es file
                'all' => $request->all(),

                // ✅ tu data[...] (si la enviaste como data[word_id], data[group])
                'data_array' => $request->input('data'),          // ← aquí verás el array

                // ✅ si a veces mandas data como JSON string (por si acaso)
                'data_raw' => $request->get('data'),

                // ✅ archivos (si envías files[])
                'files' => $request->file('files'),               // ← array de UploadedFile

                // ✅ nombres del input file (para confirmar)
                'file_keys' => array_keys($request->allFiles()),

                // ✅ headers útiles
                'content_type' => $request->header('content-type'),
            ]);*/
            $validated = $request->validate([
                'files' => ['required', 'array', 'min:1'],
                'files.*' => ['file', 'max:51200'],
                'data' => ['nullable', 'array'],
                'data.dictionary_by_words_id' => ['required', 'integer'],
                'data.group' => ['nullable', 'string', 'max:30'],
                'data.source' => ['nullable', 'string', 'max:2000'],
                'data.note' => ['nullable', 'string', 'max:5000'],
            ]);
            $data = $validated['data'] ?? [];

            $wordId = (int)$data['dictionary_by_words_id'];
            $group = $data['group'] ?? 'pronunciation';
            $source = $data['source'] ?? 'USER_UPLOAD';
            $note = $data['note'] ?? null;

            $dir = "uploads/dictionary/audio/{$group}/word_{$wordId}";
            $files = $request->file('files', []);

            $result = $svc->uploadMany($files, [
                'type' => 'audio,video',
                'dir'  => $dir,
                'insert' => function (array $payload) use ($wordId, $source) {
                    return DB::table('dictionary_words_by_audio')->insertGetId([
                        'value' => $payload['value'],
                        'description' => $payload['description'],
                        'status' => 'ACTIVE',
                        'dictionary_by_words_id' => $wordId,
                        'source' => "/". $payload['source'],
                    ]);
                },

                'buildMeta' => function (array $baseMeta) use ($group, $note, $wordId) {
                    return [
                        'tag' => 'pronunciation',
                        'group' => $group,
                        'dictionary_by_words_id' => $wordId,
                        'note' => $note,
                    ];
                },
            ]);

            return ApiResponse::ok('Archivos subidos correctamente', [
                'uploaded' => $result['uploaded'],
                'dictionary_by_words_id' => $wordId,
                'group' => $group,
            ]);

        } catch (Throwable $e) {
            return ApiResponse::fail('Error al subir archivos', $e, 500);
        }
    }

    public function dictionaryPronunciationDelete(Request $request, int $id, MediaUploadService $svc)
    {
        try {
            $validated = $request->validate([
                'data' => ['nullable', 'array'],
                'data.dictionary_by_words_id' => ['nullable', 'integer'],
            ]);

            $row = DB::table('dictionary_words_by_audio')->where('id', $id)->first();
            if (!$row) return ApiResponse::fail('Archivo no encontrado', null, 404);

            // seguridad opcional
            $wordId = $validated['data']['dictionary_by_words_id'] ?? null;
            if ($wordId && (int)$row->dictionary_by_words_id !== (int)$wordId) {
                return ApiResponse::fail('No autorizado', null, 403);
            }

            $meta = [];
            if (!empty($row->description)) {
                $decoded = json_decode($row->description, true);
                if (is_array($decoded)) $meta = $decoded;
            }

            $storedPath = $meta['stored_path'] ?? null;
            $saveTo     = $meta['save_to'] ?? 'public';  // ✅ default public
            $disk       = $meta['disk'] ?? 'public';

            DB::transaction(function () use ($id, $storedPath, $saveTo, $disk, $svc) {

                // ✅ 1) borrar recurso físico primero
                $svc->deletePhysical($storedPath, $saveTo, $disk);

                // ✅ 2) borrar DB
                DB::table('dictionary_words_by_audio')->where('id', $id)->delete();
            });

            return ApiResponse::ok('Archivo eliminado', ['id' => $id]);

        } catch (Throwable $e) {
            return ApiResponse::fail('Error al eliminar archivo', $e, 500);
        }
    }
}
