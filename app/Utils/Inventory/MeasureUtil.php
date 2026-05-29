<?php

namespace App\Utils\Inventory;

class MeasureUtil
{
    public static function findUnitBySymbol(
        array $catalog,
        string $symbol
    ): ?array {

        foreach ($catalog as $measureType) {

            foreach (
                $measureType['units']
                as $unit
            ) {

                if (
                    strtolower($unit['symbol'])
                    ===
                    strtolower($symbol)
                ) {

                    return $unit;
                }
            }
        }

        return null;
    }

    public static function findMeasureType(
        array $catalog,
        int $measureTypeId
    ): ?array {

        foreach ($catalog as $item) {

            if (
                $item['id']
                ==
                $measureTypeId
            ) {

                return $item;
            }
        }

        return null;
    }
}
