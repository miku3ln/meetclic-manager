<?php

namespace App\Infrastructure\Cms\Domains\Gamification\Movement\Repositories;

interface MovementRepositoryInterface
{
    public function create(array $data): int;
}
