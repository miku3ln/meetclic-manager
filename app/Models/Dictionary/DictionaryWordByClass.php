<?php

namespace App\Models\Dictionary;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class DictionaryWordByClass extends ModelManager
{
    protected $table = 'dictionary_word_by_class';
    protected $modelNameEntity = 'DictionaryWordByClass';

    protected $fillable = [
        'dictionary_by_words_id',
        'dictionary_grammatical_class_id',
    ];

    public $timestamps = false;

    public static function getRulesModel(): array
    {
        return [
            'dictionary_by_words_id' => 'required|numeric',
            'dictionary_grammatical_class_id' => 'required|numeric',
        ];
    }

    /**
     * Guarda pivot:
     * - UPDATE si viene id válido
     * - CREATE si no viene id
     * - (Modo seguro) si el par ya existe, retorna ese registro sin duplicar
     */
    public function saveData($params): array
    {
        try {
            $payload = $this->resolvePayload($params);
            $attributes = $this->buildAttributes($payload);

            $validation = self::validateModel([
                'inputs' => $attributes,
                'rules' => self::getRulesModel(),
            ]);

            if (!$validation['success']) {
                return $this->failResponse(
                    "Problemas al guardar DictionaryWordByClass.",
                    $validation['errors'],
                    null,
                    ['errorsFields' => $validation['errorsFields']]
                );
            }

            $result = DB::transaction(function () use ($payload, $attributes) {

                // 1) Si es UPDATE (id válido) → update normal
                if ($this->isValidExistingId($payload['id'] ?? null)) {
                    [$model, $isUpdate] = $this->findOrNewModel($payload, self::class);

                    $model->fill($attributes);
                    $model->save();

                    return [
                        'model' => $model,
                        'type' => 'update',
                    ];
                }

                // 2) Si es CREATE → evitar duplicado del par (word_id + class_id)
                $existing = DB::table($this->table)
                    ->where('dictionary_by_words_id', '=', (int)$attributes['dictionary_by_words_id'])
                    ->where('dictionary_grammatical_class_id', '=', (int)$attributes['dictionary_grammatical_class_id'])
                    ->first();

                if ($existing) {
                    // ya existe el vínculo, no creamos otro
                    return [
                        'model' => $existing,
                        'type' => 'exists',
                    ];
                }

                // 3) Crear nuevo registro
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
                'exists' => 'Ya existía el vínculo (no se duplicó).',
                default  => 'Creado con éxito.',
            };

            return $this->successResponse($msj, $result['model'], ['type' => $type]);

        } catch (\Throwable $e) {
            return $this->failResponse($e->getMessage(), [$e->getMessage()]);
        }
    }

    /**
     * Listar clases por palabra
     */
    public function getByWordId(array $params): array
    {
        $wordId = (int)($params['dictionary_by_words_id'] ?? 0);
        if ($wordId <= 0) return [];

        return DB::table($this->table)
            ->select([
                "{$this->table}.id",
                "{$this->table}.dictionary_by_words_id",
                "{$this->table}.dictionary_grammatical_class_id",
            ])
            ->where("{$this->table}.dictionary_by_words_id", '=', $wordId)
            ->orderBy("{$this->table}.id", 'asc')
            ->get()
            ->toArray();
    }

    /**
     * (Opcional) Borrar vínculo por par (word_id + class_id)
     */
    public function deleteByPair(int $wordId, int $classId): int
    {
        return DB::table($this->table)
            ->where('dictionary_by_words_id', '=', $wordId)
            ->where('dictionary_grammatical_class_id', '=', $classId)
            ->delete();
    }
    /**
     * Sincroniza las clases gramaticales de una palabra:
     * - Inserta nuevas (si no existen)
     * - Borra las que ya no vienen en el array
     * - Mantiene las que siguen viniendo
     *
     * Input esperado:
     * [
     *   'dictionary_by_words_id' => 10,
     *   'dictionary_grammatical_class_ids' => [1, 2, 5]
     * ]
     */
    public function syncByWordId(array $params): array
    {
        try {
            $wordId = (int)($params['dictionary_by_words_id'] ?? 0);
            $classIds = $params['dictionary_grammatical_class_ids'] ?? [];

            if ($wordId <= 0) {
                return $this->failResponse("dictionary_by_words_id inválido.", ["dictionary_by_words_id inválido."]);
            }

            if (!is_array($classIds)) {
                return $this->failResponse("dictionary_grammatical_class_ids debe ser array.", ["dictionary_grammatical_class_ids debe ser array."]);
            }



            $result = DB::transaction(function () use ($wordId, $classIds) {

                // 1) Borrar los que NO vienen (si el array viene vacío, borra todos)
                $deleteQuery = DB::table($this->table)->where('dictionary_by_words_id', $wordId);
                if (!empty($classIds)) {
                    $deleteQuery->whereNotIn('dictionary_grammatical_class_id', $classIds);
                }
                $deletedCount = $deleteQuery->delete();

                // 2) Insertar faltantes (upsert ignora duplicados por unique)
                $rows = [];
                foreach ($classIds as $classId) {
                    $rows[] = [
                        'dictionary_by_words_id' => $wordId,
                        'dictionary_grammatical_class_id' => (int)$classId,
                    ];
                }

                // upsert: si ya existe el par, no hace nada (no necesitas update)
                // Laravel exige "uniqueBy" con las columnas del unique
                if (!empty($rows)) {
                    DB::table($this->table)->upsert(
                        $rows,
                        ['dictionary_by_words_id', 'dictionary_grammatical_class_id'],
                        [] // no update fields
                    );
                }

                // 3) Traer estado final (opcional)
                $final = DB::table($this->table)
                    ->select(['id', 'dictionary_by_words_id', 'dictionary_grammatical_class_id'])
                    ->where('dictionary_by_words_id', $wordId)
                    ->orderBy('id', 'asc')
                    ->get()
                    ->toArray();

                return [
                    'word_id' => $wordId,
                    'requested' => $classIds,
                    'deleted_count' => $deletedCount,
                    'final' => $final,
                ];
            });

            return $this->successResponse("Sincronización realizada con éxito.", $result);

        } catch (\Throwable $e) {
            return $this->failResponse($e->getMessage(), [$e->getMessage()]);
        }
    }
}
