<?php

namespace App\Services\Inventory;

use App\Utils\Inventory\MeasureUtil;
use Illuminate\Support\Facades\DB;

class MeasureResolverService
{
    public function __construct(
        private MeasureCatalogService $catalogService,
        private MeasurementConversionService $conversionService
    ) {
    }

public function resolveConversion(
    string $measureType,
    string $from,
    ?string $to = null,
    string $businessId = '0'
): array {

    /*
    |--------------------------------------------------------------------------
    | NORMALIZAR
    |--------------------------------------------------------------------------
    */

    $measureType = mb_strtoupper(
        trim($measureType)
    );

    $from = trim(
        mb_strtolower($from)
    );

    $to = $to
        ? trim(mb_strtolower($to))
        : null;

    /*
    |--------------------------------------------------------------------------
    | PARSE INPUT
    |--------------------------------------------------------------------------
    |
    | EJ:
    |
    | 5kg
    | 2.5lb
    | 10cm
    |
    |--------------------------------------------------------------------------
    */

    preg_match(
        '/^([\d]+(?:\.[\d]+)?)\s*([a-z0-9_]+)$/iu',
        $from,
        $matches
    );

    if (!isset($matches[1])) {

        return [

            'success' => false,

            'message' =>
                'Formato inválido'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | VALUES
    |--------------------------------------------------------------------------
    */

    $quantity =
        (float)$matches[1];

    $fromSymbol =
        trim($matches[2]);

    /*
    |--------------------------------------------------------------------------
    | FROM UNIT
    |--------------------------------------------------------------------------
    */

    $fromUnit = DB::table('unit_measure as um')

        ->join(
            'product_measure_type as pmt',
            'pmt.id',
            '=',
            'um.product_measure_type_id'
        )

        ->whereRaw(
            'LOWER(um.symbol) = ?',
            [$fromSymbol]
        )

        ->whereRaw(
            'UPPER(pmt.value) = ?',
            [$measureType]
        )

        ->first([
            'um.*',
            'pmt.value as measure_type'
        ]);

    if (!$fromUnit) {

        return [

            'success' => false,

            'message' =>
                'Unidad origen inválida'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | TO UNIT
    |--------------------------------------------------------------------------
    */

    if (!$to) {

        $toUnit = DB::table('unit_measure')

            ->where(
                'product_measure_type_id',
                $fromUnit->product_measure_type_id
            )

            ->where(
                'is_base',
                1
            )

            ->first();

    } else {

        $toUnit = DB::table('unit_measure')

            ->whereRaw(
                'LOWER(symbol) = ?',
                [$to]
            )

            ->first();
    }

    if (!$toUnit) {

        return [

            'success' => false,

            'message' =>
                'Unidad destino inválida'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR TIPO
    |--------------------------------------------------------------------------
    */

    if (

        $fromUnit->product_measure_type_id
        !=
        $toUnit->product_measure_type_id

    ) {

        return [

            'success' => false,

            'message' =>
                'Tipos incompatibles'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | CONVERSION
    |--------------------------------------------------------------------------
    */

    $conversion = DB::table('measure_conversion')

        ->where(
            'from_unit_measure_id',
            $fromUnit->id
        )

        ->where(
            'to_unit_measure_id',
            $toUnit->id
        )

        ->whereIn(
            'business_id',
            [0, $businessId]
        )

        ->where('state', 1)

        ->orderByDesc('business_id')

        ->first();

    if (!$conversion) {

        return [

            'success' => false,

            'message' =>
                'Conversión no encontrada'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RESULT
    |--------------------------------------------------------------------------
    */

    $result =
        $quantity
        *
        (float)$conversion->factor;

    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

    return [

        'success' => true,

        'data' => [

            'measure_type' =>
                $measureType,

            'input' => [

                'quantity' =>
                    $quantity,

                'unit_measure' => [

                    'id' =>
                        $fromUnit->id,

                    'name' =>
                        $fromUnit->name,

                    'symbol' =>
                        $fromUnit->symbol,
                ],
            ],

            'conversion' => [

                'id' =>
                    $conversion->id,

                'factor' =>
                    (float)$conversion->factor,

                'type' =>
                    $conversion->conversion_type,

                'description' =>
                    $conversion->description,
            ],

            'output' => [

                'quantity' =>
                    round(
                        $result,
                        $toUnit->decimal_precision
                    ),

                'unit_measure' => [

                    'id' =>
                        $toUnit->id,

                    'name' =>
                        $toUnit->name,

                    'symbol' =>
                        $toUnit->symbol,
                ],
            ],
        ]
    ];
}


    public function getCatalog( int $businessId = 0){
   return
        $this->catalogService
            ->getCatalog($businessId);
}
    public function normalizeToBase(
        string $value,
        int $businessId = 0
    ): array {

        $parsed =
            $this->parseMeasurement($value);

        $catalog =
            $this->catalogService
                ->getCatalog($businessId);

        $unit =
            MeasureUtil::findUnitBySymbol(
                $catalog,
                $parsed['symbol']
            );

        if (!$unit) {

            return [
                'success' => false,
                'message' => 'Unidad inválida'
            ];
        }

        $measureType =
            MeasureUtil::findMeasureType(
                $catalog,
                $unit['product_measure_type_id']
            );

        $baseUnit =
            $measureType['base_unit'];

        $quantityBase =
            $this->conversionService
                ->convert(
                    $parsed['quantity'],
                    $unit,
                    $baseUnit
                );

        return [

            'success' => true,

            'data' => [

                'input' => [

                    'quantity' =>
                        $parsed['quantity'],

                    'unit_measure_id' =>
                        $unit['id'],

                    'symbol' =>
                        $unit['symbol'],
                ],

                'output' => [

                    'quantity' =>
                        $quantityBase,

                    'unit_measure_id' =>
                        $baseUnit['id'],

                    'symbol' =>
                        $baseUnit['symbol'],
                ],

                'conversion' => [

                    'factor' =>
                        $unit['factor_to_base']
                ]
            ]
        ];
    }

    public function parseMeasurement(
        string $value
    ): array {

        $value = trim(
            mb_strtolower($value)
        );

        preg_match(
            '/^([\d]+(?:\.[\d]+)?)\s*([a-z0-9_]+)$/iu',
            $value,
            $matches
        );

        if (!isset($matches[1])) {

            throw new \Exception(
                'Formato inválido'
            );
        }

        return [

            'quantity' =>
                (float)$matches[1],

            'symbol' =>
                trim($matches[2]),
        ];
    }
}

