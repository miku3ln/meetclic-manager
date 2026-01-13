<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases;

use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\FindProcessInputDTO;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\SimpleResultDTO;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessFilter;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessReadPort;

final class FindProcessForBusinessTrackingUseCase
{
    public function __construct(
        private readonly ProcessReadPort $processRead
    ) {}

    public function execute(FindProcessInputDTO $dto): SimpleResultDTO
    {
        if ($dto->businessId <= 0) return SimpleResultDTO::fail("business_id inválido.");
        if ($dto->trackingSourceId <= 0) return SimpleResultDTO::fail("tracking_source_id inválido.");
        if ($dto->trackingClickTypeId <= 0) return SimpleResultDTO::fail("tracking_click_type_id inválido.");
        if ($dto->campaignCode <= 0 ||$dto->campaignCode ==null) return SimpleResultDTO::fail("campaignCode inválido.");
        if ($dto->codeProcess <= 0 ||$dto->codeProcess ==null) return SimpleResultDTO::fail("codeProcess inválido.");


        $filter = new ProcessFilter(
            businessId: $dto->businessId,
            trackingSourceId: $dto->trackingSourceId,
            trackingClickTypeId: $dto->trackingClickTypeId,
            campaignCode: $dto->campaignCode,
            codeProcess:$dto->codeProcess
        );

        $row = $this->processRead->findProcessByBusinessAndTracking($filter);

        if (!$row) {
            return SimpleResultDTO::fail("No existe proceso con esos filtros.", [
                'business_id' => $dto->businessId,
                'tracking_source_id' => $dto->trackingSourceId,
                'tracking_click_type_id' => $dto->trackingClickTypeId,
                'campaign_code' => $dto->campaignCode,
            ]);
        }

        return SimpleResultDTO::ok("OK", [
            'row' => $row
        ]);
    }
}
