<?php

namespace App\Models\Dictionary;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class DictionaryGrammaticalClass extends ModelManager
{
    protected $table = 'dictionary_grammatical_class';
    protected $modelNameEntity = 'DictionaryGrammaticalClass';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public $timestamps = false;

    public static function getRulesModel(?int $id = null): array
    {
        // Si tu validateModel soporta rules dinámicas, esto te permite unique por name en update
        $uniqueName = 'unique:dictionary_grammatical_class,name';
        if ($id && $id > 0) {
            $uniqueName .= ',' . $id . ',id';
        }

        return [
            'name' => ['required', 'string', 'max:50', $uniqueName],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:ACTIVE,INACTIVE'],
        ];
    }

    /**
     * Guarda:
     * - UPDATE si viene id válido
     * - CREATE si no viene id
     * - (Modo seguro) si name ya existe, retorna ese registro y no duplica
     * Nota: tu tabla NO autoincrement → usa ensureIdForCreate
     */
    public function saveData($params): array
    {
        try {
            $payload = $this->resolvePayload($params);
            $attributes = $this->buildAttributes($payload);

            // defaults
            if (!isset($attributes['status']) || trim((string)$attributes['status']) === '') {
                $attributes['status'] = 'ACTIVE';
            }

            $id = (int)($payload['id'] ?? 0);

            $validation = self::validateModel([
                'inputs' => $attributes,
                'rules' => self::getRulesModel($id > 0 ? $id : null),
            ]);

            if (!$validation['success']) {
                return $this->failResponse(
                    "Problemas al guardar DictionaryGrammaticalClass.",
                    $validation['errors'],
                    null,
                    ['errorsFields' => $validation['errorsFields']]
                );
            }

            $result = DB::transaction(function () use ($payload, $attributes, $id) {

                // 1) UPDATE
                if ($this->isValidExistingId($id)) {
                    [$model, $isUpdate] = $this->findOrNewModel($payload, self::class);

                    $model->fill($attributes);
                    $model->save();

                    return [
                        'model' => $model,
                        'type' => 'update',
                    ];
                }

                // 2) CREATE → evitar duplicado por name (case/trim safe)
                $name = trim((string)$attributes['name']);

                $existing = DB::table($this->table)
                    ->where('name', '=', $name)
                    ->first();

                if ($existing) {
                    return [
                        'model' => $existing,
                        'type' => 'exists',
                    ];
                }

                // 3) Crear nuevo
                $model = new self();

                // tabla NO autoincrement → asignar id
                $this->ensureIdForCreate($model, $payload, $this->table);

                $model->fill($attributes);
                $model->save();

                return [
                    'model' => $model,
                    'type' => 'create',
                ];
            });

            $type = $result['type'];
            $msj = match ($type) {
                'update' => 'Actualizado con éxito.',
                'exists' => 'Ya existía la clase (no se duplicó).',
                default  => 'Creado con éxito.',
            };

            return $this->successResponse($msj, $result['model'], ['type' => $type]);

        } catch (\Throwable $e) {
            return $this->failResponse($e->getMessage(), [$e->getMessage()]);
        }
    }

    /**
     * Listar activas (útil para combos)
     */
    public function getActive(): array
    {
        return DB::table($this->table)
            ->select(['id', 'name', 'description', 'status'])
            ->where('status', '=', 'ACTIVE')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }
    public function grammaticalClassList($params = [])
    {
        $q = trim((string)($params['filters']["search_value"]["term"] ?? ''));

        return DB::table($this->table)
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")

                        ->orWhere('category', 'like', "%{$q}%")

                    ;
                });
            })
            ->where('status', '=', 'ACTIVE') // recomendado para combos
            ->orderBy('name', 'asc')
            ->limit(30)
            ->get(['id',     DB::raw("CONCAT(name, ' (', category,')') as text")])
            ->toArray();
    }
}
