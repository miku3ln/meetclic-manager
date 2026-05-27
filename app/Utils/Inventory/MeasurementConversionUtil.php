<?php

namespace App\Utils\Inventory;

use Illuminate\Support\Facades\DB;

class MeasurementConversionUtil
{
    /*
    |--------------------------------------------------------------------------
    | GET BASE UNIT
    |--------------------------------------------------------------------------
    */
    public static function getConversionsToBaseUnit(
        string $measureType,
        int $businessId = 0
    ): array {

        $units = self::getAvailableUnits(
            $measureType,
            $businessId
        );

        $baseUnit = collect($units)

            ->firstWhere('is_base', 1);

        if (!$baseUnit) {

            throw new \Exception(
                'No existe unidad base.'
            );
        }

        $result = [];

        foreach ($units as $unit) {

            if (
                $unit->symbol ===
                $baseUnit->symbol
            ) {
                continue;
            }

            $result[] = [

                'from' => [

                    'id' => $unit->id,

                    'name' => $unit->name,

                    'symbol' => $unit->symbol,
                ],

                'to' => [

                    'id' => $baseUnit->id,

                    'name' => $baseUnit->name,

                    'symbol' => $baseUnit->symbol,
                ],

                'factor' =>
                    $unit->factor_to_base,
            ];
        }

        return [

            'measure_type' => $measureType,

            'base_unit' => [

                'id' => $baseUnit->id,

                'name' => $baseUnit->name,

                'symbol' => $baseUnit->symbol,
            ],

            'conversions' => $result,
        ];
    }
    public static function getBaseUnit(
        string $measureType
    ): ?object {

        return DB::table('unit_measure as um')

            ->join(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'um.product_measure_type_id'
            )

            ->where('pmt.value', $measureType)

            ->where('um.is_base', 1)

            ->where('um.state', 'ACTIVE')

            ->select([
                'um.id',
                'um.name',
                'um.symbol',
                'um.factor_to_base',
                'um.decimal_precision',
            ])

            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | GET DEFAULT UNIT
    |--------------------------------------------------------------------------
    */

    public static function getDefaultUnit(
        string $measureType,
        int $businessId = 0
    ): ?object {

        return DB::table('measure_unit_config as muc')

            ->join(
                'measure_type_config as mtc',
                'mtc.id',
                '=',
                'muc.measure_type_config_id'
            )

            ->join(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'mtc.product_measure_type_id'
            )

            ->join(
                'unit_measure as um',
                'um.id',
                '=',
                'muc.unit_measure_id'
            )

            ->where('pmt.value', $measureType)

            ->where('mtc.business_id', $businessId)

            ->where('muc.is_default', 1)

            ->where('muc.state', 1)

            ->where('um.state', 'ACTIVE')

            ->select([
                'um.id',
                'um.name',
                'um.symbol',
                'um.factor_to_base',
                'um.decimal_precision',
            ])

            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | GET AVAILABLE UNITS
    |--------------------------------------------------------------------------
    */

    public static function getAvailableUnits(
        string $measureType,
        int $businessId = 0
    ) {

        return DB::table('measure_unit_config as muc')

            ->join(
                'measure_type_config as mtc',
                'mtc.id',
                '=',
                'muc.measure_type_config_id'
            )

            ->join(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'mtc.product_measure_type_id'
            )

            ->join(
                'unit_measure as um',
                'um.id',
                '=',
                'muc.unit_measure_id'
            )

            ->where('pmt.value', $measureType)

            ->where('mtc.business_id', $businessId)

            ->where('muc.state', 1)

            ->where('um.state', 'ACTIVE')

            ->select([
                'um.id',
                'um.name',
                'um.symbol',
                'um.factor_to_base',
                'um.is_base',
                'um.decimal_precision',
                'muc.is_default',
            ])

            ->orderByDesc('um.factor_to_base')

            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | CONVERT
    |--------------------------------------------------------------------------
    */

    public static function convert(
        float $value,
        string $fromSymbol,
        string $toSymbol
    ): float {

        $units = DB::table('unit_measure')

            ->whereIn('symbol', [
                $fromSymbol,
                $toSymbol
            ])

            ->where('state', 'ACTIVE')

            ->select([
                'symbol',
                'factor_to_base',
            ])

            ->get()

            ->keyBy('symbol');

        if (
            !isset($units[$fromSymbol]) ||
            !isset($units[$toSymbol])
        ) {
            throw new \Exception(
                'Unidad inválida.'
            );
        }

        $from = $units[$fromSymbol];

        $to = $units[$toSymbol];

        return
            ($value * $from->factor_to_base)
            /
            $to->factor_to_base;
    }

    /*
    |--------------------------------------------------------------------------
    | GET CONVERSIONS BY TYPE
    |--------------------------------------------------------------------------
    */

    public static function getConversionsByType(
        string $measureType,
        int $businessId = 0
    ): array {

        $units = self::getAvailableUnits(
            $measureType,
            $businessId
        );

        $result = [];

        foreach ($units as $from) {

            foreach ($units as $to) {

                if ($from->symbol === $to->symbol) {
                    continue;
                }

                $result[] = [

                    'from' => [
                        'symbol' => $from->symbol,
                        'name' => $from->name,
                    ],

                    'to' => [
                        'symbol' => $to->symbol,
                        'name' => $to->name,
                    ],

                    'factor' =>
                        $from->factor_to_base
                        /
                        $to->factor_to_base,
                ];
            }
        }

        return $result;
    }
    private static function generateAliases(
        string $name,
        string $symbol
    ): array {

        $aliases = [

            strtolower($symbol),

            strtolower($name),
        ];

        /*
        |--------------------------------------------------------------------------
        | REMOVE ACCENTS
        |--------------------------------------------------------------------------
        */

        $normalizedName =
            str_replace(
                ['á','é','í','ó','ú'],
                ['a','e','i','o','u'],
                strtolower($name)
            );

        $aliases[] = $normalizedName;

        /*
        |--------------------------------------------------------------------------
        | SINGULAR / PLURAL
        |--------------------------------------------------------------------------
        */

        $aliases[] =
            rtrim($normalizedName, 's');

        $aliases[] =
            $normalizedName . 's';

        return array_unique($aliases);
    }
    public static function normalizeToBase(
        array $params
    ): array {

        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDATE PARAMS
            |--------------------------------------------------------------------------
            */

            if (
                empty($params['measureType'])
            ) {

                return [

                    'success' => false,

                    'message' =>
                        'El tipo de medida es requerido.',

                    'data' => null,
                ];
            }

            if (
                empty($params['value'])
            ) {

                return [

                    'success' => false,

                    'message' =>
                        'El valor es requerido.',

                    'data' => null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | FORMAT INPUT
            |--------------------------------------------------------------------------
            */

            $measureType =
                strtoupper(
                    trim($params['measureType'])
                );

            $value =
                trim($params['value']);

            /*
            |--------------------------------------------------------------------------
            | GET MEASURE TYPE
            |--------------------------------------------------------------------------
            */

            $productMeasureType =
                DB::table('product_measure_type')

                    ->whereRaw(
                        'LOWER(value) = ?',
                        [strtolower($measureType)]
                    )

                    ->where(
                        'state',
                        'ACTIVE'
                    )

                    ->first();

            if (!$productMeasureType) {

                return [

                    'success' => false,

                    'message' =>

                        "El tipo de medida "
                        .
                        "'{$measureType}' "
                        .
                        "no existe.",

                    'data' => null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | GET TYPE CONFIG
            |--------------------------------------------------------------------------
            */

            $measureTypeConfig =
                DB::table('measure_type_config')

                    ->where(
                        'product_measure_type_id',
                        $productMeasureType->id
                    )

                    ->where(
                        'state',
                        1
                    )

                    ->first();

            if (!$measureTypeConfig) {

                return [

                    'success' => false,

                    'message' =>

                        "No existe configuración "
                        .
                        "para '{$measureType}'.",

                    'data' => null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | EXTRACT QUANTITY + SYMBOL
            |--------------------------------------------------------------------------
            |
            | SI ES UNIDAD:
            | 225
            | 12
            |
            | SI ES MASA/LONGITUD/etc:
            | 15kg
            | 15 kg
            | 2 litros
            |
            |--------------------------------------------------------------------------
            */

            $quantityInput = 0;
            $symbol = null;

            if (
                strtoupper($productMeasureType->value)
                ===
                'UNIDAD'
            ) {

                preg_match(
                    '/^\s*([\d]+(?:\.[\d]+)?)\s*$/u',
                    $value,
                    $matches
                );

                if (
                    !isset($matches[1])
                ) {

                    return [

                        'success' => false,

                        'message' =>
                            'Formato inválido. Ejemplo válido: 225',

                        'data' => null,
                    ];
                }

                $quantityInput =
                    (float) $matches[1];

            } else {

                preg_match(
                    '/^\s*([\d]+(?:\.[\d]+)?)\s*([a-zA-ZáéíóúÁÉÍÓÚñÑ0-9_]+)\s*$/u',
                    $value,
                    $matches
                );

                if (
                    !isset($matches[1]) ||
                    !isset($matches[2])
                ) {

                    return [

                        'success' => false,

                        'message' =>
                            'Formato inválido. Ejemplo válido: 15kg',

                        'data' => null,
                    ];
                }

                $quantityInput =
                    (float) $matches[1];

                $symbol =
                    strtolower(
                        trim($matches[2])
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | GET ALLOWED UNITS
            |--------------------------------------------------------------------------
            */

            $units = DB::table('measure_unit_config as muc')

                ->join(
                    'unit_measure as um',
                    'um.id',
                    '=',
                    'muc.unit_measure_id'
                )

                ->where(
                    'muc.measure_type_config_id',
                    $measureTypeConfig->id
                )

                ->where(
                    'muc.state',
                    1
                )

                ->where(
                    'um.state',
                    'ACTIVE'
                )

                ->select([
                    'um.*',
                    'muc.is_default',
                ])

                ->get();

            /*
            |--------------------------------------------------------------------------
            | DETECT UNIT
            |--------------------------------------------------------------------------
            */

            $unit = null;

            if (
                strtoupper($productMeasureType->value)
                ===
                'UNIDAD'
            ) {

                /*
                |--------------------------------------------------------------------------
                | PARA UNIDAD USA DIRECTAMENTE
                | LA UNIDAD DEFAULT
                |--------------------------------------------------------------------------
                */

                foreach ($units as $item) {

                    if (
                        (int) $item->is_default === 1
                    ) {

                        $unit = $item;

                        break;
                    }
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | BUSCAR POR ALIASES
                |--------------------------------------------------------------------------
                */

                $symbolNormalized =
                    strtolower(
                        trim($symbol)
                    );

                foreach ($units as $item) {

                    $aliases =
                        self::generateAliases(
                            $item->name,
                            $item->symbol
                        );

                    if (
                        in_array(
                            $symbolNormalized,
                            $aliases
                        )
                    ) {

                        $unit = $item;

                        break;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | UNIT NOT FOUND
            |--------------------------------------------------------------------------
            */

            if (!$unit) {

                return [

                    'success' => false,

                    'message' =>

                        strtoupper($productMeasureType->value)
                        ===
                        'UNIDAD'

                            ?

                            "No existe unidad por defecto para '{$measureType}'."

                            :

                            "La unidad '{$symbol}' "
                            .
                            "no está permitida "
                            .
                            "para '{$measureType}'.",

                    'data' => [
                        'configuration' =>
                            $measureTypeConfig,
                    ],
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | GET BASE UNIT
            |--------------------------------------------------------------------------
            */

            $baseUnit =
                DB::table('measure_unit_config as muc')

                    ->join(
                        'unit_measure as um',
                        'um.id',
                        '=',
                        'muc.unit_measure_id'
                    )

                    ->where(
                        'muc.measure_type_config_id',
                        $measureTypeConfig->id
                    )

                    ->where(
                        'muc.is_default',
                        1
                    )

                    ->where(
                        'muc.state',
                        1
                    )

                    ->where(
                        'um.state',
                        'ACTIVE'
                    )

                    ->select([
                        'um.*'
                    ])

                    ->first();

            if (!$baseUnit) {

                return [

                    'success' => false,

                    'message' =>

                        "No existe unidad base "
                        .
                        "configurada para '{$measureType}'.",

                    'data' => [
                        'configuration' =>
                            $measureTypeConfig,

                        'unit' =>
                            $unit,
                    ],
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | CONVERT
            |--------------------------------------------------------------------------
            */

            $quantityBase =
                $quantityInput
                *
                $unit->factor_to_base;

            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return [

                'success' => true,

                'message' =>

                    "{$quantityInput}{$unit->symbol} "
                    .
                    "= "
                    .
                    round(
                        $quantityBase,
                        $baseUnit->decimal_precision
                    )
                    .
                    "{$baseUnit->symbol}",

                'data' => [

                    'measure_type' =>
                        $measureType,

                    'configuration_id' =>
                        $measureTypeConfig->id,

                    'input' => [

                        'raw_value' =>
                            $value,

                        'quantity' =>
                            $quantityInput,

                        'unit_measure_id' =>
                            $unit->id,

                        'unit_symbol' =>
                            $unit->symbol,

                        'unit_name' =>
                            $unit->name,
                    ],

                    'output' => [

                        'quantity' =>
                            round(
                                $quantityBase,
                                $baseUnit->decimal_precision
                            ),

                        'unit_measure_id' =>
                            $baseUnit->id,

                        'unit_symbol' =>
                            $baseUnit->symbol,

                        'unit_name' =>
                            $baseUnit->name,
                    ],

                    'conversion' => [

                        'factor' =>
                            $unit->factor_to_base,

                        'operation' =>
                            'TO_BASE_UNIT',
                    ],

                    'configuration' =>
                        $measureTypeConfig
                ],
            ];

        } catch (\Throwable $e) {

            return [

                'success' => false,

                'message' =>
                    $e->getMessage(),

                'data' => null,
            ];
        }
    }
    public static function normalizeToBase2(
        array $params
    ): array {

        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDATE PARAMS
            |--------------------------------------------------------------------------
            */

            if (
                empty($params['measureType'])
            ) {

                return [

                    'success' => false,

                    'message' =>
                        'El tipo de medida es requerido.',

                    'data' => null,
                ];
            }

            if (
                empty($params['value'])
            ) {

                return [

                    'success' => false,

                    'message' =>
                        'El valor es requerido.',

                    'data' => null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | FORMAT INPUT
            |--------------------------------------------------------------------------
            */

            $measureType =
                strtoupper(
                    trim($params['measureType'])
                );

            $value =
                trim($params['value']);

            /*
            |--------------------------------------------------------------------------
            | EXTRACT QUANTITY + SYMBOL
            |--------------------------------------------------------------------------
            */

            preg_match(
                '/^\s*([\d]+(?:\.[\d]+)?)\s*([a-zA-ZáéíóúÁÉÍÓÚñÑ0-9_]+)\s*$/u',
                $value,
                $matches
            );

            if (
                !isset($matches[1]) ||
                !isset($matches[2])
            ) {

                return [

                    'success' => false,

                    'message' =>
                        'Formato inválido. Ejemplo válido: 15kg',

                    'data' => null,
                ];
            }

            $quantityInput =
                (float) $matches[1];

            $symbol =
                strtolower(
                    trim($matches[2])
                );

            /*
            |--------------------------------------------------------------------------
            | GET MEASURE TYPE
            |--------------------------------------------------------------------------
            */

            $productMeasureType =
                DB::table('product_measure_type')

                    ->whereRaw(
                        'LOWER(value) = ?',
                        [strtolower($measureType)]
                    )

                    ->where(
                        'state',
                        'ACTIVE'
                    )

                    ->first();

            if (!$productMeasureType) {

                return [

                    'success' => false,

                    'message' =>

                        "El tipo de medida "
                        .
                        "'{$measureType}' "
                        .
                        "no existe.",

                    'data' => null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | GET TYPE CONFIG
            |--------------------------------------------------------------------------
            */

            $measureTypeConfig =
                DB::table('measure_type_config')

                    ->where(
                        'product_measure_type_id',
                        $productMeasureType->id
                    )

                    ->where(
                        'state',
                        1
                    )

                    ->first();

            if (!$measureTypeConfig) {

                return [

                    'success' => false,

                    'message' =>

                        "No existe configuración "
                        .
                        "para '{$measureType}'.",

                    'data' => null,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | GET ALLOWED UNIT
            |--------------------------------------------------------------------------
            */

            $units = DB::table('measure_unit_config as muc')

                ->join(
                    'unit_measure as um',
                    'um.id',
                    '=',
                    'muc.unit_measure_id'
                )

                ->where(
                    'muc.measure_type_config_id',
                    $measureTypeConfig->id
                )

                ->where(
                    'muc.state',
                    1
                )

                ->where(
                    'um.state',
                    'ACTIVE'
                )

                ->select([
                    'um.*',
                    'muc.is_default',
                ])

                ->get();

            /*
            |--------------------------------------------------------------------------
            | UNIT NOT ALLOWED
            |--------------------------------------------------------------------------
            */
            $unit = null;
            $symbolNormalized =
                strtolower(
                    trim($symbol)
                );
            foreach ($units as $item) {

                $aliases =
                    self::generateAliases(
                        $item->name,
                        $item->symbol
                    );

                if (
                    in_array(
                        $symbolNormalized,
                        $aliases
                    )
                ) {

                    $unit = $item;

                    break;
                }
            }
            if (!$unit) {

                return [
                    'success' => false,
                    'message' =>
                        "La unidad '{$symbol}' "
                        .
                        "no está permitida "
                        .
                        "para '{$measureType}'.",

                    'data' => [
                        'configuration'=>$measureTypeConfig,

                    ],
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | GET DEFAULT/BASE UNIT
            |--------------------------------------------------------------------------
            */

            $baseUnit =
                DB::table('measure_unit_config as muc')

                    ->join(
                        'unit_measure as um',
                        'um.id',
                        '=',
                        'muc.unit_measure_id'
                    )

                    ->where(
                        'muc.measure_type_config_id',
                        $measureTypeConfig->id
                    )

                    ->where(
                        'muc.is_default',
                        1
                    )

                    ->where(
                        'muc.state',
                        1
                    )

                    ->where(
                        'um.state',
                        'ACTIVE'
                    )

                    ->select([
                        'um.*'
                    ])

                    ->first();

            if (!$baseUnit) {

                return [

                    'success' => false,
                    'configuration'=>$measureTypeConfig,
                    'message' =>

                        "No existe unidad base "
                        .
                        "configurada para '{$measureType}'.",
                    'data' => [
                        'configuration'=>$measureTypeConfig,
                        'unit'=>$unit,

                    ],
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | CONVERT
            |--------------------------------------------------------------------------
            */

            $quantityBase =
                $quantityInput
                *
                $unit->factor_to_base;

            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return [

                'success' => true,

                'message' =>

                    "{$quantityInput}{$unit->symbol} "
                    .
                    "= "
                    .
                    round(
                        $quantityBase,
                        $baseUnit->decimal_precision
                    )
                    .
                    "{$baseUnit->symbol}",

                'data' => [

                    'measure_type' =>
                        $measureType,

                    'configuration_id' =>
                        $measureTypeConfig->id,

                    'input' => [

                        'raw_value' =>
                            $value,

                        'quantity' =>
                            $quantityInput,

                        'unit_measure_id' =>
                            $unit->id,

                        'unit_symbol' =>
                            $unit->symbol,

                        'unit_name' =>
                            $unit->name,
                    ],

                    'output' => [

                        'quantity' =>
                            round(
                                $quantityBase,
                                $baseUnit->decimal_precision
                            ),

                        'unit_measure_id' =>
                            $baseUnit->id,

                        'unit_symbol' =>
                            $baseUnit->symbol,

                        'unit_name' =>
                            $baseUnit->name,
                    ],

                    'conversion' => [

                        'factor' =>
                            $unit->factor_to_base,

                        'operation' =>
                            'TO_BASE_UNIT',
                    ],
                    'configuration'=>$measureTypeConfig
                ],
            ];

        } catch (\Throwable $e) {

            return [

                'success' => false,

                'message' =>
                    $e->getMessage(),

                'data' => null,
            ];
        }
    }
}
