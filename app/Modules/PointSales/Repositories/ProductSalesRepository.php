<?php

namespace App\Modules\PointSales\Repositories ;



use App\Core\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductSalesRepository extends BaseRepository
{
    public function getProducts($params)
    {

        $business_id = $params["business_id"];

        $query = DB::table('product_stock as ps')
            ->join('product as p', 'p.id', '=', 'ps.product_id')
            ->join('business_by_products as bp', 'p.id', '=', 'bp.products_id')
            ->join('product_inventory as pi', 'p.id', '=', 'pi.product_id')
            ->join('tax as tx', 'pi.tax_id', '=', 'tx.id')

            ->leftJoin('product_category as pc', 'pc.id', '=', 'p.product_category_id')
            ->leftJoin('product_subcategory as psc', 'psc.id', '=', 'p.product_subcategory_id')
            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')

            ->leftJoin('unit_measure as um_stock', 'um_stock.id', '=', 'ps.unit_measure_id')

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

            ->where('bp.business_id', $business_id)
            ->where('p.state', 'ACTIVE')

            ->select([
                'p.id as product_id',
                'p.code',
                'p.name',
                'p.product_type',
                'p.inventory_type',
                'p.state',
                'p.source',

                'pc.value as category',
                'psc.value as subcategory',
                'pmt.value as measure_type',

                'ps.quantity',
                'ps.quantity_base',

                'p.product_category_id',
                'p.product_subcategory_id',
                'p.product_subcategory_id',
                'pi.tax_id',
                'tx.value as tax_value',
                'tx.percentage as tax_percentage',
                'pi.sale_price',
                'pi.sale_price2',
                'pi.sale_price3',
                'pi.sale_price4',
                'pi.tax as has_tax',

                DB::raw("
                    CASE
                        WHEN p.product_type = 'MIXED' THEN ps.quantity
                        WHEN p.product_type = 'UNIT' THEN ps.quantity
                        WHEN um_default.factor_to_base > 0
                            THEN ROUND(ps.quantity_base / um_default.factor_to_base, 2)
                        ELSE ps.quantity_base
                    END as quantity_display
                "),

                'um_stock.name as stock_unit',
                'um_stock.symbol as stock_symbol',

                'um_base.name as base_unit',
                'um_base.symbol as base_symbol',

                'um_default.name as default_unit',
                'um_default.symbol as default_symbol',
            ]);

        // 🔍 SEARCH (sin romper nada)
        $this->applySearch($query, $params['searchPhrase'] ?? null, [
            'p.name',
            'p.code',
            'pc.value',
            'psc.value'
        ]);

        // 📦 PAGINACIÓN + SORT (genérico)
        return $this->paginate($query, $params, 'p.id');
    }
    public function getProductsShopPage($params)
    {

        $business_id = $params["filters"]["business_id"];

        $query = DB::table('product_stock as ps')
            ->join('product as p', 'p.id', '=', 'ps.product_id')
            ->join('business_by_products as bp', 'p.id', '=', 'bp.products_id')
            ->join('product_inventory as pi', 'p.id', '=', 'pi.product_id')
            ->join('tax as tx', 'pi.tax_id', '=', 'tx.id')

            ->leftJoin('product_category as pc', 'pc.id', '=', 'p.product_category_id')
            ->leftJoin('product_subcategory as psc', 'psc.id', '=', 'p.product_subcategory_id')
            ->leftJoin('product_measure_type as pmt', 'pmt.id', '=', 'p.product_measure_type_id')

            ->leftJoin('unit_measure as um_stock', 'um_stock.id', '=', 'ps.unit_measure_id')

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

            ->where('bp.business_id', $business_id)
            ->where('p.state', 'ACTIVE')

            ->select([
                'p.id as product_id',
                'p.code',
                'p.name',
                'p.product_type',
                'p.inventory_type',
                'p.state',
                'p.source',

                'pc.value as category',
                'psc.value as subcategory',
                'pmt.value as measure_type',

                'ps.quantity',
                'ps.quantity_base',

                'p.product_category_id',
                'p.product_subcategory_id',
                'p.product_subcategory_id',
                'pi.tax_id',
                'tx.value as tax_value',
                'tx.percentage as tax_percentage',
                'pi.sale_price',
                'pi.sale_price2',
                'pi.sale_price3',
                'pi.sale_price4',
                'pi.tax as has_tax',

                DB::raw("
                    CASE
                        WHEN p.product_type = 'MIXED' THEN ps.quantity
                        WHEN p.product_type = 'UNIT' THEN ps.quantity
                        WHEN um_default.factor_to_base > 0
                            THEN ROUND(ps.quantity_base / um_default.factor_to_base, 2)
                        ELSE ps.quantity_base
                    END as quantity_display
                "),

                'um_stock.name as stock_unit',
                'um_stock.symbol as stock_symbol',

                'um_base.name as base_unit',
                'um_base.symbol as base_symbol',

                'um_default.name as default_unit',
                'um_default.symbol as default_symbol',
            ]);

        // 🔍 SEARCH (sin romper nada)
        $this->applySearch($query, $params['searchPhrase'] ?? null, [
            'p.name',
            'p.code',
            'pc.value',
            'psc.value'
        ]);

        // 📦 PAGINACIÓN + SORT (genérico)
        return $this->paginate($query, $params, 'p.id');
    }
}
