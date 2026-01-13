<?php

namespace App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Repositories;

use Illuminate\Support\Facades\DB;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessTrackingPort;

class DbProcessTrackingRepository implements ProcessTrackingPort
{
    public function countUserProcessInWindow(
        int $userId,
        int $processId,
        string $fromDateTime,
        string $toDateTime
    ): int {
        return (int) DB::table('gamification_by_process_tracking')
            ->where('user_id', $userId)
            ->where('gamification_by_process_id', $processId)
            ->whereBetween('assigned_at', [$fromDateTime, $toDateTime])
            ->count();
    }

    public function countUserProcessTotal(int $userId, int $processId): int
    {
        return (int) DB::table('gamification_by_process_tracking')
            ->where('user_id', $userId)
            ->where('gamification_by_process_id', $processId)
            ->count();
    }

    public function existsReferenceCode(int $userId, int $processId, string $referenceCode): bool
    {
        return DB::table('gamification_by_process_tracking')
            ->where('user_id', $userId)
            ->where('gamification_by_process_id', $processId)
            ->exists();
    }
}
