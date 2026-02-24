<?php

namespace App\Models\Dictionary;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class DictionaryWordsByAudio extends ModelManager
{
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    protected $table = 'dictionary_words_by_audio';
    protected $modelNameEntity = 'DictionaryWordsByAudio';

    protected $fillable = [
        'value',
        'description',
        'status',
        'dictionary_by_words_id',
        'source',
    ];

    // Tu tabla NO tiene created_at/updated_at
    public $timestamps = false;

    public static function getRulesModel(): array
    {
        return [
            'value' => 'required|string',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'dictionary_by_words_id' => 'required|numeric',
            'source' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Guardar (CREATE o UPDATE) con estructura limpia.
     * Espera: $params['attributesPost']['DictionaryWordsByAudio'] = [...]
     */
    public function saveData($params): array
    {
        $errors = [];
        $data = null;

        try {
            $payload = $this->resolvePayload($params);

            // Validar
            $attributes = $this->buildAttributes($payload);

            $validation = $this->validateModel([
                'inputs' => $attributes,
                'rules'  => self::getRulesModel(),
            ]);

            if (!$validation['success']) {
                return $this->failResponse(
                    "Problemas al guardar DictionaryWordsByAudio.",
                    $validation['errors'],
                    null
                );
            }

            // Transacción
            $result = DB::transaction(function () use ($payload, $attributes) {

                [$model, $isUpdate] = $this->findOrNewModel($payload);

                // Si es CREATE y tu tabla NO es autoincrement: generar ID
                if (!$isUpdate) {
                    $this->ensureIdForCreate($model, $payload);
                }

                $model->fill($attributes);
                $model->save();

                return [
                    'model' => $model,
                    'is_update' => $isUpdate,
                ];
            });

            $data = $result['model'];

            return $this->successResponse(
                $result['is_update'] ? "Actualizado con éxito." : "Creado con éxito.",
                $data
            );

        } catch (\Throwable $e) {
            $errors[] = $e->getMessage();

            return $this->failResponse(
                $e->getMessage(),
                $errors,
                $data
            );
        }
    }

    /**
     * Listado simple por palabra (igual a tu getDataAudio pero limpio)
     */
    public function getByWordId(array $params): array
    {
        $wordId = (int)($params['dictionary_by_words_id'] ?? 0);
        if ($wordId <= 0) {
            return [];
        }

        return DB::table($this->table)
            ->select([
                "{$this->table}.id",
                "{$this->table}.value",
                "{$this->table}.description",
                "{$this->table}.status",
                "{$this->table}.dictionary_by_words_id",
                "{$this->table}.source",
            ])
            ->where("{$this->table}.dictionary_by_words_id", '=', $wordId)
            ->where("{$this->table}.status", '=', self::STATUS_ACTIVE)
            ->orderBy("{$this->table}.id", 'asc')
            ->get()
            ->toArray();
    }

}
