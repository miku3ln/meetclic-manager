<?php

namespace App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs;

class TaskRewardInputDTO
{
    public function __construct(
        public int $userId,
        public array $process,      // gamification_by_process completo (array)
        public int $amount,
        public int $typeMoney = 0,  // 0=BEE, 1=QUEEN
        public ?string $referenceCode = null,
        public ?int $performedById = null
    ) {}
}
