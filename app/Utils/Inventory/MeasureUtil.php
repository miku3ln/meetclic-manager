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

    /*
  |--------------------------------------------------------------------------
  | NUEVO
  |--------------------------------------------------------------------------
  |
  | Encuentra:
  |
  | - unidad
  | - tipo de medida al que pertenece
  |
  | Esto evita depender de product_measure_type_id
  | dentro de la unidad.
  |
  |--------------------------------------------------------------------------
  */

    public static function findUnitContextBySymbol(
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

                    return [

                        'measure_type' =>
                            $measureType,

                        'unit' =>
                            $unit,
                    ];
                }
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | NUEVO
    |--------------------------------------------------------------------------
    |
    | Busca una conversión:
    |
    | unidad origen -> unidad destino
    |
    |--------------------------------------------------------------------------
    */

    public static function findConversion(
        array $unit,
        int $toUnitId
    ): ?array {

        foreach (
            $unit['conversions'] ?? []
            as $conversion
        ) {

            if (
                ($conversion['to_unit']['id'] ?? null)
                ==
                $toUnitId
            ) {

                return $conversion;
            }
        }

        return null;
    }
}
