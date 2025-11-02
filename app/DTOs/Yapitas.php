<?php

namespace App\DTOs;

class Yapitas
{
    public float $totalInput;
    public float $totalOutput;
    public float $currentBalance;

    public function __construct(float $totalInput, float $totalOutput, float $currentBalance)
    {
        $this->totalInput = $totalInput;
        $this->totalOutput = $totalOutput;
        $this->currentBalance = $currentBalance;
    }

    public function toArray(): array
    {
        return [
            'total_input' => $this->totalInput,
            'total_output' => $this->totalOutput,
            'current_balance' => $this->currentBalance,
        ];
    }
}
