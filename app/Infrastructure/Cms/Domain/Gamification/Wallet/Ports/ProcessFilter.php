<?php

namespace App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports;

final class ProcessFilter
{
    public function __construct(
        public readonly int $businessId,
        public readonly int $trackingSourceId,
        public readonly int $trackingClickTypeId,
        public readonly ?string $campaignCode = null,
        public readonly string $codeProcess ,

    ) {}
}
