<?php

namespace App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports;

interface ProcessReadPort
{
    public function findProcessWithPointsAndBusiness(int $processId): ?array;

    public function findProcessByBusinessAndTracking(ProcessFilter $filter):  ?array;
}
