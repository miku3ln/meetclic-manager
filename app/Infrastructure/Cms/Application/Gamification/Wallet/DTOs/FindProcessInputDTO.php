<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs;

final class FindProcessInputDTO
{
    public function __construct(
        public readonly int $businessId,
        public readonly int $trackingSourceId,
        public readonly int $trackingClickTypeId,
        public readonly ?string $campaignCode = null,
        public readonly string $codeProcess

    ) {}
}
