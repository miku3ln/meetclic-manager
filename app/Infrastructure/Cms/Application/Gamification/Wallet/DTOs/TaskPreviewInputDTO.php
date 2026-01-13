<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs;

class TaskPreviewInputDTO
{
    public function __construct(
        public int $processId,
        public int $nowEpochSeconds,
        public int $userId,
        public ?string $referenceCode = null
    ) {}
}
