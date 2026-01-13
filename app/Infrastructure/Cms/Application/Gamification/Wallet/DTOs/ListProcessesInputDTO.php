<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs;

final class ListProcessesInputDTO
{
    public function __construct(
        public readonly int $businessId,
        public readonly int $trackingSourceId,
        public readonly int $trackingClickTypeId,
        public readonly ?string $campaignCode = null
    ) {}
}
