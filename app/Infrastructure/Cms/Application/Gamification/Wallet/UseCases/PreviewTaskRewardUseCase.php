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

    public function execute(TaskPreviewInputDTO $dto): TaskPreviewResultDTO
    {
        $tz = 'America/Guayaquil';

        if ($dto->processId <= 0) return TaskPreviewResultDTO::fail("process_id inválido.");
        if ($dto->userId <= 0) return TaskPreviewResultDTO::fail("user_id inválido.");
        if ($dto->nowEpochSeconds <= 0) return TaskPreviewResultDTO::fail("now_epoch_seconds inválido.");

        $process = $this->processRead->findProcessWithPointsAndBusiness($dto->processId);
        if (!$process) return TaskPreviewResultDTO::fail("Proceso no existe o no tiene puntos/negocio asociado.");

        $state = strtoupper((string)($process['state'] ?? ''));
        if ($state !== 'ACTIVE') return TaskPreviewResultDTO::fail("Proceso INACTIVO.");

        // ✅ NOW con TZ
        $now = Carbon::createFromTimestamp($dto->nowEpochSeconds, $tz);

        $validFrom = $process['valid_from'] ?? null;
        $validUntil = $process['valid_until'] ?? null;

        if ($validFrom) {
            $from = Carbon::parse($validFrom, $tz);
            if ($now->lt($from)) return TaskPreviewResultDTO::fail("Aún no disponible. Desde: ".$from->toDateTimeString());
        }

        if ($validUntil) {
            $until = Carbon::parse($validUntil, $tz);
            if ($now->gt($until)) return TaskPreviewResultDTO::fail("Caducado. Hasta: ".$until->toDateTimeString());
        }

        if ($dto->referenceCode) {
            $exists = $this->tracking->existsReferenceCode($dto->userId, $dto->processId, $dto->referenceCode);
            if ($exists) return TaskPreviewResultDTO::fail("Reintento detectado: reference_code ya registrado.");
        }

        $limitType = strtoupper((string)($process['frequency_limit_type'] ?? ''));
        $limitValueRaw = $process['frequency_limit_value'] ?? null;

        if ($limitType === 'ONCE' && (int)$limitValueRaw <= 0) $limitValueRaw = 1;
        $limitValue = (int)($limitValueRaw ?? 0);

        if ($limitValue > 0) {
            // ✅ resolve con TZ
            [$from, $to, $mode] = FrequencyWindow::resolve($limitType, $dto->nowEpochSeconds, $tz);

            $count = 0;
            if ($mode === 'WINDOW') {
                $count = $this->tracking->countUserProcessInWindow($dto->userId, $dto->processId, $from, $to);
            } elseif ($mode === 'TOTAL') {
                $count = $this->tracking->countUserProcessTotal($dto->userId, $dto->processId);
            }

            if ($count >= $limitValue) {
                return TaskPreviewResultDTO::fail("Límite alcanzado ({$limitType}). Máximo: {$limitValue}.");
            }
        }

        return TaskPreviewResultDTO::ok("OK: permitido.", [
            'user_id' => $dto->userId,
            'process_id' => $dto->processId,
            'now_epoch_seconds' => $dto->nowEpochSeconds,
            'allowed' => true,
            'amount' => (float)($process['points'] ?? 0),
            'business_id' => $process['business_id'] ?? null,
            'business_name' => $process['business_name'] ?? null,
            'process' => $process,
        ]);
    }

}
