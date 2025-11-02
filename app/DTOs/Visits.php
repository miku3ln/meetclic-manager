<?php

namespace App\DTOs;

class Visits
{
    public int $total;

    public function __construct(int $total = 0)
    {
        $this->total = $total;
    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
        ];
    }
}
