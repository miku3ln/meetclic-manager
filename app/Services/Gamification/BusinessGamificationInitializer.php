<?php

namespace App\Services\Gamification;

use App\Models\Gamification;
use App\Models\BusinessByGamification;
use App\Models\Gamification\ConfigurationGamificationUtil;
use App\Models\GamificationByProcess;
use App\Models\GamificationByPoints;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BusinessGamificationInitializer
{
    private array $ctx = [
        'step' => null,
        'user_id' => null,

        'pack_index' => null,
        'business_id' => null,
        'business_name' => null,

        'gamification_id' => null,

        'process_index' => null,
        'process_id' => null,
        'unique_code' => null,

        // extras útiles cuando falle validate:
        'model' => null,
        'validation_errors' => null,
        'haystack_preview' => null,
    ];

    public function run(array $businessData, string $urlBase, int $userId): array
    {
        $errors = [];
        $dataGamificationData = [];

        // ✅ asegura user_id siempre en ctx
        $this->ctx['user_id'] = $userId;

        try {
            return DB::transaction(function () use ($businessData, $urlBase, $userId, &$dataGamificationData, &$errors) {

                $this->checkpoint('generate.packs.start');

                $dataGamificationData = ConfigurationGamificationUtil::generateManagementDataGamificationBusiness([
                    "businessData" => $businessData,
                    "urlBase" => $urlBase,
                    "user_id" => $userId,
                ]);

                $this->checkpoint('generate.packs.done', [
                    'packs_count' => count($dataGamificationData),
                ]);

                foreach ($dataGamificationData as $index => $gamificationData) {
                    $bbg = $gamificationData['business_by_gamification'] ?? [];

                    $this->checkpoint('pack.start', [
                        'pack_index' => $index,
                        'business_id' => $bbg['business_id'] ?? null,
                        'business_name' => $bbg['business_name'] ?? ($gamificationData['business_name'] ?? null),

                        // limpia contexto por pack
                        'gamification_id' => null,
                        'process_index' => null,
                        'process_id' => null,
                        'unique_code' => null,
                        'model' => null,
                        'validation_errors' => null,
                        'haystack_preview' => null,
                    ]);

                    try {
                        $this->persistOneGamificationPack($gamificationData);
                    } catch (QueryException $e) {
                        $errors[] = $this->formatQueryException($e, $this->ctx);
                        throw $e;
                    } catch (Throwable $e) {
                        $errors[] = $this->formatThrowable($e, $this->ctx);
                        throw $e;
                    }
                }

                return [
                    "success" => true,
                    "msj" => "",
                    "errors" => [],
                    "data" => $dataGamificationData,
                ];
            });
        } catch (Throwable $e) {
            return [
                "success" => false,
                "msj" => $e->getMessage(),
                "errors" => $errors ?: [$this->formatThrowable($e, $this->ctx)],
                "data" => $dataGamificationData,
            ];
        }
    }

    private function persistOneGamificationPack(array &$gamificationData): void
    {
        $bbg = $gamificationData['business_by_gamification'] ?? [];

        // 1) Gamification
        $this->checkpoint('gamification.save.start', [
            'business_id' => $bbg['business_id'] ?? null,
        ]);

        $gamification = $this->saveModelOrFail(
            new Gamification(),
            $gamificationData,
            'Problemas al guardar Gamification.'
        );

        $gamificationData['id'] = $gamification->id;

        $this->checkpoint('gamification.save.done', [
            'gamification_id' => $gamification->id,
        ]);

        // 2) BusinessByGamification
        $this->checkpoint('business_by_gamification.save.start', [
            'gamification_id' => $gamification->id,
            'business_id' => $bbg['business_id'] ?? null,
        ]);

        $bbg['gamification_id'] = $gamification->id;
        $this->saveModelOrFail(
            new BusinessByGamification(),
            $bbg,
            'Problemas al guardar BusinessByGamification.'
        );

        $this->checkpoint('business_by_gamification.save.done', [
            'gamification_id' => $gamification->id,
            'business_id' => $bbg['business_id'] ?? null,
        ]);

        // 3) GamificationByProcess + Points
        $processes = $gamificationData['gamification_by_process'];

        foreach ($processes as $i => $row) {
            $this->checkpoint('process.save.start', [
                'process_index' => $i,
                'unique_code' => $row['unique_code'] ?? null,
                'gamification_id' => $gamification->id,

                // limpia por proceso
                'process_id' => null,
                'model' => null,
                'validation_errors' => null,
                'haystack_preview' => null,
            ]);

            $row['gamification_id'] = $gamification->id;

            $pointsData = $row['gamification_by_points'] ?? null;
            unset($row['gamification_by_points']);

            $process = $this->saveModelOrFail(
                new GamificationByProcess(),
                $row,
                'Problemas al guardar GamificationByProcess.'
            );

            if ($process->id) {

                $url = $process->url_manager;
                if ($url == "not-url") {

                } else {
                    $setNew = "codeProcess=" . $process->id;
                    $urlNew = str_replace('codeProcess=69', $setNew, $url);
                    $gamificationData['gamification_by_process'][$i]['url_manager'] = $urlNew;
                    $process->url_manager = $urlNew;
                    $process->save();


                }



            }
            $gamificationData['gamification_by_process'][$i]['id'] = $process->id;

            $this->checkpoint('process.save.done', [
                'process_id' => $process->id,
                'unique_code' => $row['unique_code'] ?? null,
            ]);

            if (is_array($pointsData)) {
                $this->checkpoint('points.save.start', [
                    'process_id' => $process->id,
                    'unique_code' => $row['unique_code'] ?? null,
                    'model' => null,
                    'validation_errors' => null,
                    'haystack_preview' => null,
                ]);

                $pointsData['gamification_by_process_id'] = $process->id;

                $points = $this->saveModelOrFail(
                    new GamificationByPoints(),
                    $pointsData,
                    'Problemas al guardar GamificationByPoints.'
                );

                $gamificationData['gamification_by_process'][$i]['gamification_by_points']['id'] = $points->id;

                $this->checkpoint('points.save.done', [
                    'process_id' => $process->id,
                    'points_id' => $points->id,
                ]);
            }
        }

        $this->checkpoint('pack.done', [
            'gamification_id' => $gamification->id,
        ]);
    }

    /**
     * Guarda un modelo usando tus helpers getValuesModel + validateModel.
     * Si falla, registra ctx + validation_errors y lanza RuntimeException (sin clase extra).
     */
    private function saveModelOrFail(object $model, array $haystack, string $errorMessage): object
    {
        $this->checkpoint('model.prepare', [
            'model' => class_basename($model),
        ]);

        $attributesSet = $model->getValuesModel([
            'fillAble' => $model->getFillable(),
            'haystack' => $haystack,
            'attributesData' => $model->getAttributesData(),
        ]);

        $this->checkpoint('model.validate', [
            'model' => class_basename($model),
        ]);

        $validateResult = $model->validateModel([
            'modelAttributes' => $attributesSet,
            'rules' => $model::getRulesModel(),
        ]);

        if (!($validateResult['success'] ?? false)) {

            // ✅ aquí queda el tracking REAL del porqué falló
            $this->checkpoint('model.validate.failed', [
                'model' => class_basename($model),
                'validation_errors' => $validateResult['errors'] ?? [],
                'haystack_preview' => $this->safePreview($haystack),
            ]);

            // ✅ sin clase adicional
            throw new \RuntimeException($errorMessage);
        }

        $this->checkpoint('model.save', [
            'model' => class_basename($model),
        ]);

        $model->fill($attributesSet);
        $model->save();
        $this->checkpoint('model.save.done', [
            'model' => class_basename($model),
            'id' => $model->id ?? null,
        ]);

        return $model;
    }

    private function checkpoint(string $step, array $extra = []): void
    {
        $this->ctx['step'] = $step;
        foreach ($extra as $k => $v) {
            $this->ctx[$k] = $v;
        }

        Log::info('[BusinessGamificationInitializer]', $this->ctx);
    }

    private function safePreview(array $haystack): array
    {
        // Ajusta las keys según tu data real, esto es para no loguear "todo".
        $allow = [
            'id', 'business_id', 'gamification_id',
            'title', 'subtitle', 'description',
            'unique_code', 'state', 'value', 'value_unit',
            'tracking_click_type_id', 'tracking_source_id', 'gamification_type_activity_id',
        ];

        return array_intersect_key($haystack, array_flip($allow));
    }

    private function formatQueryException(QueryException $e, array $context = []): array
    {
        return [
            "message" => $e->getMessage(),
            "exception" => class_basename($e),
            "sql" => method_exists($e, 'getSql') ? $e->getSql() : null,
            "bindings" => method_exists($e, 'getBindings') ? $e->getBindings() : null,
            "context" => $context,
        ];
    }

    private function formatThrowable(Throwable $e, array $context = []): array
    {
        return [
            "message" => $e->getMessage(),
            "exception" => class_basename($e),
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "context" => $context,
        ];
    }
}
