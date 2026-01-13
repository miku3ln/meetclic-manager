<?php

namespace App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports;

interface ProcessTrackingPort
{
    public function countUserProcessInWindow(int $userId, int $processId, string $fromDateTime, string $toDateTime): int;

    public function countUserProcessTotal(int $userId, int $processId): int;

    public function existsReferenceCode(int $userId, int $processId, string $referenceCode): bool;
}
