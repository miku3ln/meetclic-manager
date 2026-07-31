<?php

namespace App\Modules\PointSales\Repositories ;

use Illuminate\Support\Facades\DB;
class ProductRepository
{
    public function getProductById($id)
    {



        return DB::table('product as p')
            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')
            ->where('p.id', $id)
            ->select([
                'p.id',
                'p.code',
                'p.name',
                'p.product_type',
                'p.inventory_type',
                'p.description',
                'p.product_measure_type_id',
                'pmt.value as product_measure_type_value',

            ])
            ->first();
    }
    public function getProductWithStock($id)
    {
        return DB::table('product as p')
            ->join('product_stock as ps', 'ps.product_id', '=', 'p.id')
            ->leftJoin('unit_measure as um_stock', 'um_stock.id', '=', 'ps.unit_measure_id')
            ->leftJoin('unit_measure as um_base', function ($join) {
                $join->on('um_base.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('um_base.is_base', 1);
            })
            ->where('p.id', $id)
            ->select([
                'p.id',
                'p.product_type',

                'ps.quantity',
                'ps.quantity_base',
                'um_base.symbol',

                'um_stock.id as stock_unit_id',
                'um_base.id as base_unit_id'
            ])
            ->first();
    }
    public function getRecipesByProducts(array $productIds)
    {
        return DB::table('product_recipe as pr')

            ->join('product as p', 'p.id', '=', 'pr.component_product_id')

            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')

            ->leftJoin('unit_measure as um_base', function ($join) {
                $join->on('um_base.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('um_base.is_base', 1);
            })

            ->leftJoin('product_stock as ps', 'ps.product_id', '=', 'p.id')

            ->whereIn('pr.product_id', $productIds)

            ->select([

                'pr.id',

                'pr.product_id as parent_product_id',

                'pr.component_product_id',

                'p.name as component_name',

                'p.product_type as component_type',

                'pr.quantity as recipe_quantity',

                'um_base.symbol as base_unit',

                'ps.quantity as stock_quantity',

                'ps.quantity_base as stock_quantity_base',

            ])

            ->get();
    }
    public function getRecipe($productId)
    {

        return DB::table('product_recipe as pr')

            ->join('product as p', 'p.id', '=', 'pr.product_id')
            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')
            ->leftJoin('unit_measure as um_base', function ($join) {
                $join->on('um_base.product_measure_type_id', '=', 'p.product_measure_type_id')
                    ->where('um_base.is_base', 1);
            })

            ->leftJoin('product_stock as ps', 'ps.product_id', '=', 'p.id')
            ->leftJoin('unit_measure as um_base_input', function ($join) {
                $join->on('um_base_input.id', '=', 'pr.unit_input_id');
            })
            ->where('pr.component_product_id', $productId)
            ->select([
                'pr.id',
                'pr.product_id',

                'pr.component_product_id as parent_product_id',
                'pr.product_id',
                'p.name',
                'p.inventory_type',
                'p.name as component_name',
                'p.inventory_type as component_name',
                'p.inventory_type as component_name',

                'p.product_type as component_type',
                'p.product_measure_type_id',
                'pr.quantity_input as quantity',
                'pr.quantity_base as recipe_quantity',

                'pr.quantity_base',
                'pr.quantity_input',
                'pr.unit_input_id',
                'pr.base_unit_measure_id',
                'pmt.value as product_measure_type_name',
                'pr.quantity_input as um_base_input_quantity_input',

                'um_base.id as um_base_id',
                'um_base.name as um_base_name',
                'um_base.factor_to_base as um_base_factor_to_base',
                'um_base.symbol as um_base_symbol',
                'pr.quantity_base as um_base_quantity',


                'um_base_input.id as um_base_input_id',
                'um_base_input.name as um_base_input_name',
                'um_base_input.factor_to_base as um_base_input_factor_to_base',
                'um_base_input.symbol as um_base_input_symbol',
                'pr.quantity_input as um_base_input_quantity',



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

                'um_stock.id as stock_unit_id',
                'um_stock.symbol as stock_unit',

                'um_base.id as base_unit_id',
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
                    'unit_id' => $row->stock_unit_id,   // ✅ CLAVE
                    'type' => 'UNIT'
                ];

            case 'MEASURABLE':
            case 'MIXED':
                return [
                    'value' => (float) $row->quantity_base,
                    'unit' => $row->base_unit ?? 'base',
                    'unit_id' => $row->base_unit_id,   // ✅ CLAVE
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
