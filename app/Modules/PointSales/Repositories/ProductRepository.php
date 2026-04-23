<?php

namespace App\Modules\PointSales\Repositories ;

use Illuminate\Support\Facades\DB;
class ProductRepository
{
    public function getProductById($id)
    {
        return DB::table('product')
            ->where('id', $id)
            ->first();
    }

    public function getRecipe($productId)
    {
        return DB::table('product_recipe as pr')

            ->join('product as p', 'p.id', '=', 'pr.component_product_id')

            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')

            ->leftJoin('unit_measure as um_base', function ($join) {
                $join->on('um_base.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('um_base.is_base', 1);
            })

            ->leftJoin('product_stock as ps', 'ps.product_id', '=', 'p.id')

            ->where('pr.product_id', $productId)

            ->select([
                'pr.id',
                'pr.product_id',

                'pr.product_id as parent_product_id',
                'pr.component_product_id',
                'p.name',

                'p.name as component_name',
                'p.product_type as component_type',

                'pr.quantity as recipe_quantity',
                'pr.quantity',

                'um_base.symbol as base_unit',

                'ps.quantity as stock_quantity',
                'ps.quantity_base as stock_quantity_base',
            ])

            ->get();
    }
    public function getStock($productId)
    {
        $row = DB::table('product_stock as ps')
            ->join('product as p', 'p.id', '=', 'ps.product_id')
            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')
            ->leftJoin('unit_measure as um_base', function ($join) {
                $join->on('um_base.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('um_base.is_base', 1);
            })
            ->leftJoin('unit_measure as um_stock', 'um_stock.id', '=', 'ps.unit_measure_id')
            ->where('ps.product_id', $productId)
            ->select([
                'p.id',
                'p.product_type',

                'ps.quantity',
                'ps.quantity_base',

                'um_stock.symbol as stock_unit',
                'um_base.symbol as base_unit'
            ])
            ->first();

        if (!$row) {
            return [
                'value' => 0,
                'unit' => null,
                'type' => null
            ];
        }

        // 🔥 lógica central
        switch ($row->product_type) {

            case 'UNIT':
                return [
                    'value' => (float) $row->quantity,
                    'unit' => $row->stock_unit ?? 'u',
                    'type' => 'UNIT'
                ];

            case 'MEASURABLE':
            case 'MIXED':
                return [
                    'value' => (float) $row->quantity_base,
                    'unit' => $row->base_unit ?? 'base',
                    'type' => $row->product_type
                ];

            default:
                return [
                    'value' => 0,
                    'unit' => null,
                    'type' => null
                ];
        }
    }
    public function getProductWithUnits($productId)
    {
        return DB::table('product as p')
            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')

            ->leftJoin('unit_measure as um_base', function ($join) {
                $join->on('um_base.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('um_base.is_base', 1);
            })

            ->leftJoin('measure_type_config as mtc', function ($join) {
                $join->on('mtc.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('mtc.state', 1);
            })

            ->leftJoin('measure_unit_config as muc', function ($join) {
                $join->on('muc.measure_type_config_id', '=', 'mtc.id')
                    ->where('muc.is_default', 1)
                    ->where('muc.state', 1);
            })

            ->leftJoin('unit_measure as um_default', 'um_default.id', '=', 'muc.unit_measure_id')

            ->where('p.id', $productId)

            ->select([
                'p.id',
                'p.product_type',

                'um_base.symbol as base_symbol',

                'um_default.symbol as default_symbol',
                'um_default.factor_to_base as default_factor',

                DB::raw("'u' as stock_symbol") // opcional si no tienes
            ])
            ->first();
    }
}
