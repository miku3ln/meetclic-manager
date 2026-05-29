<?php

namespace App\Services\Inventory;

use Illuminate\Support\Facades\DB;
/*
 * product_measure_type
        |
        |
measure_type_config
        |
        |
measure_unit_config
        |
        |
unit_measure
        |
        |
measure_conversion
        |
        |
unit_measure (destino)
 */
class MeasureCatalogService
{
    public function getCatalog(
        int $businessId = 0
    ): array {

        $rows = DB::table('measure_type_config as mtc')

            ->join(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'mtc.product_measure_type_id'
            )

            ->join(
                'measure_unit_config as muc',
                'muc.measure_type_config_id',
                '=',
                'mtc.id'
            )

            ->join(
                'unit_measure as um',
                'um.id',
                '=',
                'muc.unit_measure_id'
            )

            /*
            |--------------------------------------------------------------------------
            | CONVERSIONES
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'measure_conversion as mc',
                'mc.from_unit_measure_id',
                '=',
                'um.id'
            )

            ->leftJoin(
                'unit_measure as um_to',
                'um_to.id',
                '=',
                'mc.to_unit_measure_id'
            )

            ->whereIn(
                'mtc.business_id',
                [0, $businessId]
            )

            ->where('mtc.state', 1)

            ->where('muc.state', 1)

            ->where('pmt.state', 'ACTIVE')

            ->where('um.state', 'ACTIVE')

            ->where(function ($query) {

                $query

                    ->whereNull('mc.id')

                    ->orWhere('mc.state', 1);
            })

            ->orderBy('pmt.id')

            ->orderByDesc('um.is_base')

            ->get([

                /*
                |--------------------------------------------------------------------------
                | MEASURE TYPE
                |--------------------------------------------------------------------------
                */

                'pmt.id as measure_type_id',

                'pmt.value as measure_type',

                'pmt.description',

                'pmt.prefix',

                'pmt.symbol as measure_symbol',

                /*
                |--------------------------------------------------------------------------
                | UNIT
                |--------------------------------------------------------------------------
                */

                'um.id as unit_measure_id',

                'um.name as unit_name',

                'um.symbol as unit_symbol',

                'um.factor_to_base',

                'um.is_base',

                'um.decimal_precision',

                'muc.is_default',

                /*
                |--------------------------------------------------------------------------
                | CONVERSION
                |--------------------------------------------------------------------------
                */

                'mc.id as conversion_id',

                'mc.factor as conversion_factor',

                'mc.conversion_type',

                'mc.description as conversion_description',

                'mc.product_id',

                'mc.to_unit_measure_id',

                /*
                |--------------------------------------------------------------------------
                | TO UNIT
                |--------------------------------------------------------------------------
                */

                'um_to.name as to_unit_name',

                'um_to.symbol as to_unit_symbol',
            ]);

        return $this->formatCatalogConversion(
            $rows->toArray()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT
    |--------------------------------------------------------------------------
    */

    private function formatCatalogConversion(
        array $rows
    ): array {

        $result = [];

        foreach ($rows as $row) {

            $typeId =
                $row->measure_type_id;

            /*
            |--------------------------------------------------------------------------
            | CREATE TYPE
            |--------------------------------------------------------------------------
            */

            if (
                !isset($result[$typeId])
            ) {

                $result[$typeId] = [

                    'id' => $typeId,

                    'name' =>
                        $row->measure_type,

                    'description' =>
                        $row->description,

                    'prefix' =>
                        $row->prefix,

                    'symbol' =>
                        $row->measure_symbol,

                    'base_unit' => null,

                    'units' => [],
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | CREATE UNIT
            |--------------------------------------------------------------------------
            */

            $unitId =
                $row->unit_measure_id;

            if (
                !isset(
                    $result[$typeId]
                    ['units'][$unitId]
                )
            ) {

                $result[$typeId]
                ['units'][$unitId] = [

                    'id' =>
                        $unitId,

                    'name' =>
                        $row->unit_name,

                    'symbol' =>
                        $row->unit_symbol,

                    'factor_to_base' =>
                        (float)
                        $row->factor_to_base,

                    'is_base' =>
                        (bool)
                        $row->is_base,

                    'is_default' =>
                        (bool)
                        $row->is_default,

                    'decimal_precision' =>
                        (int)
                        $row->decimal_precision,

                    /*
                    |--------------------------------------------------------------------------
                    | CONVERSIONS
                    |--------------------------------------------------------------------------
                    */

                    'conversions' => [],
                ];

                /*
                |--------------------------------------------------------------------------
                | BASE UNIT
                |--------------------------------------------------------------------------
                */

                if ($row->is_base) {

                    $result[$typeId]
                    ['base_unit'] =

                        $result[$typeId]
                        ['units'][$unitId];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | ADD CONVERSION
            |--------------------------------------------------------------------------
            */

            if ($row->conversion_id) {

                $conversionExists =
                    collect(
                        $result[$typeId]
                        ['units'][$unitId]
                        ['conversions']
                    )
                        ->contains(
                            'id',
                            $row->conversion_id
                        );

                if (!$conversionExists) {

                    $result[$typeId]
                    ['units'][$unitId]
                    ['conversions'][] = [

                        'id' =>
                            $row->conversion_id,

                        'factor' =>
                            (float)
                            $row->conversion_factor,

                        'conversion_type' =>
                            $row->conversion_type,

                        'description' =>
                            $row->conversion_description,

                        'product_id' =>
                            $row->product_id,

                        /*
                        |--------------------------------------------------------------------------
                        | TO UNIT
                        |--------------------------------------------------------------------------
                        */

                        'to_unit' => [

                            'id' =>
                                $row->to_unit_measure_id,

                            'name' =>
                                $row->to_unit_name,

                            'symbol' =>
                                $row->to_unit_symbol,
                        ],
                    ];
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | REINDEX UNITS
        |--------------------------------------------------------------------------
        */

        foreach ($result as &$measureType) {

            $measureType['units'] =
                array_values(
                    $measureType['units']
                );
        }

        return array_values($result);
    }
}
