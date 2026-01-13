<?php

namespace App\Infrastructure\Cms\Infrastructure\Persistence\Eloquent\Repositories;

use App\Infrastructure\Cms\Domains\Gamification\Movement\Repositories\MovementRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentMovementRepository implements MovementRepositoryInterface
{
    public function create(array $data): int
    {
        return (int) DB::table('account_gamification_by_movement')->insertGetId($data);
    }
}
