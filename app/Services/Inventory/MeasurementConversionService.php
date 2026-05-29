<?php

namespace App\Services\Inventory;

class MeasurementConversionService
{
    public function convert(
        float $quantity,
        array $fromUnit,
        array $toUnit
    ): float
    {

        $baseValue =
            $quantity *
            $fromUnit['factor_to_base'];

        return
            $baseValue /
            $toUnit['factor_to_base'];
    }

    public function toBase(
        float $quantity,
        array $unit
    ): float
    {

        return
            $quantity *
            $unit['factor_to_base'];
    }

    public function fromBase(
        float $quantity,
        array $unit
    ): float
    {

        return
            $quantity /
            $unit['factor_to_base'];
    }
}
