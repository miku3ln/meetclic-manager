<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases;

use Carbon\Carbon;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\TaskPreviewInputDTO;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\TaskPreviewResultDTO;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessReadPort;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessTrackingPort;
use App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Sql\FrequencyWindow;

class PreviewTaskRewardUseCase
{
    public function __construct(
        private readonly ProcessReadPort $processRead,
        private readonly ProcessTrackingPort $tracking
    ) {}

    const FREQUENCY_LIMIT_TYPE_NONE = "NONE";
    const FREQUENCY_LIMIT_TYPE_ONCE = "ONCE";
    const FREQUENCY_LIMIT_TYPE_DAILY = "DAILY";
    const FREQUENCY_LIMIT_TYPE_WEEKLY = "WEEKLY";
    const FREQUENCY_LIMIT_TYPE_MONTHLY = "MONTHLY";
    const FREQUENCY_LIMIT_TYPE_TOTAL_LIMIT = "TOTAL_LIMIT";

    public function execute(TaskPreviewInputDTO $dto): TaskPreviewResultDTO
    {
        $tz = 'America/Guayaquil';

        // 🔹 Validaciones básicas
        if ($dto->processId <= 0) return TaskPreviewResultDTO::fail("process_id inválido.");
        if ($dto->userId <= 0) return TaskPreviewResultDTO::fail("user_id inválido.");
        if ($dto->nowEpochSeconds <= 0) return TaskPreviewResultDTO::fail("now_epoch_seconds inválido.");

        $process = $this->processRead->findProcessWithPointsAndBusiness($dto->processId);

        if (!$process) {
            return TaskPreviewResultDTO::fail("Proceso no existe o no tiene puntos/negocio asociado.");
        }

        // 🔹 Estado
        if (strtoupper((string)$process['state']) !== 'ACTIVE') {
            return TaskPreviewResultDTO::fail("Proceso INACTIVO.");
        }

        $now = Carbon::createFromTimestamp($dto->nowEpochSeconds, $tz);

        // 🔹 Vigencia
        if (!empty($process['valid_from'])) {
            $from = Carbon::parse($process['valid_from'], $tz);
            if ($now->lt($from)) {
                return TaskPreviewResultDTO::fail("Aún no disponible.");
            }
        }

        if (!empty($process['valid_until'])) {
            $until = Carbon::parse($process['valid_until'], $tz);
            if ($now->gt($until)) {
                return TaskPreviewResultDTO::fail("Caducado.");
            }
        }

        // 🔹 Anti duplicado
        if (!empty(trim((string)$dto->referenceCode))) {
            $exists = $this->tracking->existsReferenceCode(
                $dto->userId,
                $dto->processId,
                trim($dto->referenceCode)
            );

            if ($exists) {
                return TaskPreviewResultDTO::fail("Reintento detectado.");
            }
        }

        // 🔥 NORMALIZAR FRECUENCIA
        $limitType = strtoupper(trim((string)($process['frequency_limit_type'] ?? '')));
        $limitValueRaw = $process['frequency_limit_value'] ?? null;

        switch ($limitType) {

            case self::FREQUENCY_LIMIT_TYPE_ONCE:
                $limitValue = 1;
                break;

            case self::FREQUENCY_LIMIT_TYPE_DAILY:
            case self::FREQUENCY_LIMIT_TYPE_WEEKLY:
            case self::FREQUENCY_LIMIT_TYPE_MONTHLY:
                $limitValue = !empty($limitValueRaw) ? (int)$limitValueRaw : 1;
                break;

            case self::FREQUENCY_LIMIT_TYPE_TOTAL_LIMIT:
                $limitValue = (int)($limitValueRaw ?? 0);
                break;

            case self::FREQUENCY_LIMIT_TYPE_NONE:
            default:
                $limitValue = 0;
                break;
        }

        // 🔥 VALIDACIÓN DE LÍMITE
        if ($limitValue > 0) {

            [$from, $to, $mode] = FrequencyWindow::resolve(
                $limitType,
                $dto->nowEpochSeconds,
                $tz
            );

            $count = 0;

            if ($mode === 'WINDOW') {

                // 🔥 Convertir a UTC (IMPORTANTE)
                $fromUtc = Carbon::parse($from, $tz)->utc()->toDateTimeString();
                $toUtc = Carbon::parse($to, $tz)->utc()->toDateTimeString();

                $count = $this->tracking->countUserProcessInWindow(
                    $dto->userId,
                    $dto->processId,
                    $fromUtc,
                    $toUtc
                );

            } elseif ($mode === 'TOTAL') {

                $count = $this->tracking->countUserProcessTotal(
                    $dto->userId,
                    $dto->processId
                );
            }

            if ($count >= $limitValue) {
                $message = match ($limitType) {
                    self::FREQUENCY_LIMIT_TYPE_ONCE =>
                    "Esta tarea solo se puede realizar una vez y ya fue completada.",

                    self::FREQUENCY_LIMIT_TYPE_DAILY =>
                    "Ya realizaste esta tarea hoy. Vuelve a intentarlo mañana.",

                    self::FREQUENCY_LIMIT_TYPE_WEEKLY =>
                    "Ya completaste esta tarea esta semana. Intenta nuevamente la próxima semana.",

                    self::FREQUENCY_LIMIT_TYPE_MONTHLY =>
                    "Ya completaste esta tarea este mes. Podrás realizarla nuevamente el próximo mes.",

                    self::FREQUENCY_LIMIT_TYPE_TOTAL_LIMIT =>
                    "Has alcanzado el número máximo permitido para esta tarea.",

                    default =>
                    "No puedes realizar esta tarea en este momento.",
                };

                return TaskPreviewResultDTO::fail($message);

            }
        }

        // ✅ OK
        return TaskPreviewResultDTO::ok("OK: permitido.", [
            'allowed' => true,
            'amount' => (float)($process['points'] ?? 0),
            'business_id' => $process['business_id'] ?? null,
            'business_name' => $process['business_name'] ?? null,
            'process_id' => $dto->processId,
        ]);
    }
}
