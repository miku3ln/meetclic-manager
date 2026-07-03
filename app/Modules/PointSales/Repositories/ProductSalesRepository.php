<?php

namespace App\Modules\PointSales\Repositories;


use App\Core\Repositories\BaseRepository;
use App\Utils\Product\ProductSaveUtil;
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
                'pi.id pi_id',

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

    public function setProductTypeSave($params)
    {
        $util = new ProductSaveUtil();
        return
            $util->setProductTypeSave(
                $params
            );
    }
    public function setProductTypeUpdate($params)
    {
        $util = new ProductSaveUtil();
        return
            $util->setProductTypeUpdate(
                $params
            );
    }

    public function setProductItemRecipeSave($params)
    {
        $util = new ProductSaveUtil();
        return
            $util->setProductItemRecipeSave(
                $params
            );
    }

    public function getProductsRecipeShopPage($params)
    {
        $business_id = $params["filters"]["business_id"];
        $component_product_id = $params["filters"]["component_product_id"];

        $query = DB::table('product_recipe as pr')
            ->join(
                'product as p',
                'p.id',
                '=',
                'pr.product_id'
            )
            ->join(
                'business_by_products as bp',
                'bp.products_id',
                '=',
                'p.id'
            )
            ->leftJoin(
                'product_category as pc',
                'pc.id',
                '=',
                'p.product_category_id'
            )
            ->leftJoin(
                'product_subcategory as psc',
                'psc.id',
                '=',
                'p.product_subcategory_id'
            )
            ->leftJoin(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'p.product_measure_type_id'
            )
            /*
            |--------------------------------------------------------------------------
            | Unidad ingresada
            |--------------------------------------------------------------------------
            */
            ->leftJoin(
                'unit_measure as um_input',
                'um_input.id',
                '=',
                'pr.unit_input_id'
            )
            /*
            |--------------------------------------------------------------------------
            | Unidad base
            |--------------------------------------------------------------------------
            */
            ->leftJoin(
                'unit_measure as um_base',
                'um_base.id',
                '=',
                'pr.base_unit_measure_id'
            )
            ->where(
                'bp.business_id',
                $business_id
            )
            ->where(
                'pr.component_product_id',
                $component_product_id
            )
            ->where(
                'p.state',
                'ACTIVE'
            )
            ->select([

                /*
                |--------------------------------------------------------------------------
                | PRODUCTO INGREDIENTE
                |--------------------------------------------------------------------------
                */
                'p.id as product_id',
                'p.name',
                'p.code',
                'p.product_type',
                'p.inventory_type',

                /*
                |--------------------------------------------------------------------------
                | CATEGORY
                |--------------------------------------------------------------------------
                */
                'pc.value as category',
                'psc.value as subcategory',

                /*
                |--------------------------------------------------------------------------
                | RECIPE
                |--------------------------------------------------------------------------
                */
                'pr.id as recipe_id',

                'pr.quantity_input',
                'pr.quantity_base',

                'pr.conversion_factor',

                'pr.unit_input_id',
                'pr.base_unit_measure_id',

                /*
                |--------------------------------------------------------------------------
                | INPUT UNIT
                |--------------------------------------------------------------------------
                */
                'um_input.name as input_unit_name',
                'um_input.symbol as input_unit_symbol',

                /*
                |--------------------------------------------------------------------------
                | BASE UNIT
                |--------------------------------------------------------------------------
                */
                'um_base.name as base_unit_name',
                'um_base.symbol as base_unit_symbol',

                /*
                |--------------------------------------------------------------------------
                | DETAILS
                |--------------------------------------------------------------------------
                */
                DB::raw("
                JSON_OBJECT(

                    'recipe',
                    JSON_OBJECT(
                        'id', pr.id,
                        'product_id', pr.product_id,
                        'component_product_id', pr.component_product_id,
                        'quantity_input', pr.quantity_input,
                        'unit_input_id', pr.unit_input_id,
                        'quantity_base', pr.quantity_base,
                        'base_unit_measure_id', pr.base_unit_measure_id,
                        'conversion_factor', pr.conversion_factor
                    ),

                    'product',
                    JSON_OBJECT(
                        'id', p.id,
                        'name', p.name,
                        'code', p.code,
                        'product_type', p.product_type,
                        'inventory_type', p.inventory_type
                    ),

                    'input_unit',
                    JSON_OBJECT(
                        'id', um_input.id,
                        'name', um_input.name,
                        'symbol', um_input.symbol,
                        'factor_to_base', um_input.factor_to_base
                    ),

                    'base_unit',
                    JSON_OBJECT(
                        'id', um_base.id,
                        'name', um_base.name,
                        'symbol', um_base.symbol,
                        'factor_to_base', um_base.factor_to_base
                    ),
                        'product_measure_type',
    JSON_OBJECT(
        'id', pmt.id,
        'value', pmt.value,
        'description', pmt.description,
        'abbreviation', pmt.abbreviation,
        'unit', pmt.unit,
        'number_of_units', pmt.number_of_units,
        'prefix', pmt.prefix,
        'symbol', pmt.symbol
    )

                ) as details_all
            ")
            ]);

        $this->applySearch(
            $query,
            $params['searchPhrase'] ?? null,
            [
                'p.name',
                'p.code',
                'pc.value',
                'psc.value'
            ]
        );

        $query->orderBy('pr.id', 'desc');

        return $this->paginate(
            $query,
            $params,
            'pr.id'
        );
    }

    public function getProductsShopPage($params)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        $business_id = $params["filters"]["business_id"];
        $subcategoryId = null;
        if (isset($params["filters"]["subcategoryId"])) {
            $subcategoryId = $params["filters"]["subcategoryId"] == -1
                ? null
                : $params["filters"]["subcategoryId"];
        }
        $categoryId = null;

        if (isset($params["filters"]["categoryId"])) {
            $categoryId =
                $params["filters"]["categoryId"] == -1
                    ? null
                    : $params["filters"]["categoryId"];
        }


        /*
        |--------------------------------------------------------------------------
        | OPTIONAL CHANNEL TYPE
        |--------------------------------------------------------------------------
        */

        $type = isset($params["filters"]['type'])
            ? strtoupper($params["filters"]['type'])
            : null;

        $channelColumn = null;
        $state = ['ACTIVE'];

        if ($type === 'POS') {

            $channelColumn = 'pscfg.allow_pos';

        } elseif ($type === 'SHOP') {

            $channelColumn = 'pscfg.allow_shop';

        } elseif ($type === 'DELIVERY') {

            $channelColumn = 'pscfg.allow_delivery';
        } elseif ($type === 'MANAGEMENT') {
            $state = ['ACTIVE', 'INACTIVE'];
        }

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = DB::table('product_stock as ps')
            /*
            |--------------------------------------------------------------------------
            | MAIN TABLES
            |--------------------------------------------------------------------------
            */

            ->join('product as p', 'p.id', '=', 'ps.product_id')
            ->join('business_by_products as bp', 'p.id', '=', 'bp.products_id')
            ->join('product_inventory as pi', 'p.id', '=', 'pi.product_id')
            ->join(
                'product_sell_config as pscfg',
                'pscfg.product_id',
                '=',
                'p.id'
            )
            ->join('tax as tx', 'pi.tax_id', '=', 'tx.id')
            ->join('tax_by_business as txbb', function ($join) use ($business_id) {

                $join->on('tx.id', '=', 'txbb.tax_id')
                    ->where('txbb.business_id', '=', $business_id);

            })
            /*
            |--------------------------------------------------------------------------
            | OPTIONAL TABLES
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'product_category as pc',
                'pc.id',
                '=',
                'p.product_category_id'
            )
            ->leftJoin(
                'product_subcategory as psc',
                'psc.id',
                '=',
                'p.product_subcategory_id'
            )
            ->leftJoin(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'p.product_measure_type_id'
            )
            ->leftJoin(
                'unit_measure as um_stock',
                'um_stock.id',
                '=',
                'ps.unit_measure_id'
            )
            ->leftJoin('unit_measure as um_base', function ($join) {

                $join->on(
                    'um_base.product_measure_type_id',
                    '=',
                    'p.product_measure_type_id'
                )
                    ->where('um_base.is_base', 1);
            })
            ->leftJoin('measure_type_config as mtc', function ($join) {

                $join->on(
                    'mtc.product_measure_type_id',
                    '=',
                    'p.product_measure_type_id'
                )
                    ->where('mtc.state', 1);
            })
            ->leftJoin('measure_unit_config as muc', function ($join) {

                $join->on(
                    'muc.measure_type_config_id',
                    '=',
                    'mtc.id'
                )
                    ->where('muc.is_default', 1)
                    ->where('muc.state', 1);
            })
            ->leftJoin(
                'unit_measure as um_default',
                'um_default.id',
                '=',
                'muc.unit_measure_id'
            )
            /*
            |--------------------------------------------------------------------------
            | MAIN FILTERS
            |--------------------------------------------------------------------------
            */

            ->where('bp.business_id', $business_id);
        $query->whereIn('p.state', $state)
            /*
            |--------------------------------------------------------------------------
            | SELL CONFIG
            |--------------------------------------------------------------------------
            */

            ->where('pscfg.visible', 1);
        /*
        |--------------------------------------------------------------------------
        | SELECT
        |--------------------------------------------------------------------------
        */
        $inventoryInitial=" ";
        $stockManager=" ";

        if ($type === 'MANAGEMENT') {

            $query->leftJoin(
                'product_by_stock as pbst',
                'p.id',
                '=',
                'pbst.product_id'
            );
            $inventoryInitial = DB::table('inventory_movement')
                ->select(
                    'product_id',
                    DB::raw('MAX(id) as inventory_movement_id')
                )
                ->where('movement_type', 'IN')
                ->where('reference_type', 'INVENTARIO_INICIAL')
                ->groupBy('product_id');

            $query->leftJoinSub(
                $inventoryInitial,
                'im',
                function ($join) {
                    $join->on('im.product_id', '=', 'p.id');
                }
            );

            $query->leftJoin(
                'inventory_movement as imd',
                'imd.id',
                '=',
                'im.inventory_movement_id'
            );

            /*
            |--------------------------------------------------------------------------
            | UNIT MEASURE
            |--------------------------------------------------------------------------
            */

            $query->leftJoin(
                'unit_measure as um_inventory',
                'um_inventory.id',
                '=',
                'imd.unit_measure_id'
            );

            $query->leftJoin(
                'product_measure_type as pmt_inventory',
                'pmt_inventory.id',
                '=',
                'um_inventory.product_measure_type_id'
            );

            $query->leftJoin(
                'measure_type_config as mtc_inventory',
                function ($join) {
                    $join->on(
                        'mtc_inventory.product_measure_type_id',
                        '=',
                        'um_inventory.product_measure_type_id'
                    )
                        ->where('mtc_inventory.state', 1);
                }
            );

            $query->leftJoin(
                'measure_unit_config as muc_inventory',
                function ($join) {
                    $join->on(
                        'muc_inventory.measure_type_config_id',
                        '=',
                        'mtc_inventory.id'
                    )
                        ->on(
                            'muc_inventory.unit_measure_id',
                            '=',
                            'um_inventory.id'
                        )
                        ->where('muc_inventory.state', 1);
                }
            );

            /*
            |--------------------------------------------------------------------------
            | UNIT INPUT
            |--------------------------------------------------------------------------
            */

            $query->leftJoin(
                'unit_measure as um_input',
                'um_input.id',
                '=',
                'imd.unit_input_id'
            );

            $query->leftJoin(
                'product_measure_type as pmt_input',
                'pmt_input.id',
                '=',
                'um_input.product_measure_type_id'
            );

            $query->leftJoin(
                'measure_type_config as mtc_input',
                function ($join) {
                    $join->on(
                        'mtc_input.product_measure_type_id',
                        '=',
                        'um_input.product_measure_type_id'
                    )
                        ->where('mtc_input.state', 1);
                }
            );

            $query->leftJoin(
                'measure_unit_config as muc_input',
                function ($join) {
                    $join->on(
                        'muc_input.measure_type_config_id',
                        '=',
                        'mtc_input.id'
                    )
                        ->on(
                            'muc_input.unit_measure_id',
                            '=',
                            'um_input.id'
                        )
                        ->where('muc_input.state', 1);
                }
            );

            $stockManager=" ,
'product_by_stock',
JSON_OBJECT(
    'id', pbst.id,
    'min', pbst.min,
    'max', pbst.max

)";

            $inventoryInitial = ",
'inventory_initial',
JSON_OBJECT(

    'id', imd.id,
    'product_id', imd.product_id,
    'movement_type', imd.movement_type,
    'quantity', imd.quantity,
    'quantity_input', imd.quantity_input,
    'conversion_factor', imd.conversion_factor,
    'reference_type', imd.reference_type,
    'reference_id', imd.reference_id,
    'description', imd.description,
    'created_at', imd.created_at,

    'unit_measure',
    JSON_OBJECT(

        'id', um_inventory.id,
        'product_measure_type_id', um_inventory.product_measure_type_id,
        'name', um_inventory.name,
        'symbol', um_inventory.symbol,
        'factor_to_base', um_inventory.factor_to_base,
        'is_base', um_inventory.is_base,
        'decimal_precision', um_inventory.decimal_precision,
        'state', um_inventory.state,

        'product_measure_type',
        JSON_OBJECT(
            'id', pmt_inventory.id,
            'value', pmt_inventory.value,
            'description', pmt_inventory.description,
            'abbreviation', pmt_inventory.abbreviation,
            'unit', pmt_inventory.unit,
            'number_of_units', pmt_inventory.number_of_units,
            'prefix', pmt_inventory.prefix,
            'symbol', pmt_inventory.symbol
        ),

        'measure_type_config',
        JSON_OBJECT(
            'id', mtc_inventory.id,
            'business_id', mtc_inventory.business_id,
            'product_measure_type_id', mtc_inventory.product_measure_type_id,
            'name', mtc_inventory.name,
            'state', mtc_inventory.state
        ),

        'measure_unit_config',
        JSON_OBJECT(
            'id', muc_inventory.id,
            'measure_type_config_id', muc_inventory.measure_type_config_id,
            'unit_measure_id', muc_inventory.unit_measure_id,
            'is_default', muc_inventory.is_default,
            'state', muc_inventory.state
        )

    ),

    'unit_input',
    JSON_OBJECT(

        'id', um_input.id,
        'product_measure_type_id', um_input.product_measure_type_id,
        'name', um_input.name,
        'symbol', um_input.symbol,
        'factor_to_base', um_input.factor_to_base,
        'is_base', um_input.is_base,
        'decimal_precision', um_input.decimal_precision,
        'state', um_input.state,

        'product_measure_type',
        JSON_OBJECT(
            'id', pmt_input.id,
            'value', pmt_input.value,
            'description', pmt_input.description,
            'abbreviation', pmt_input.abbreviation,
            'unit', pmt_input.unit,
            'number_of_units', pmt_input.number_of_units,
            'prefix', pmt_input.prefix,
            'symbol', pmt_input.symbol
        ),

        'measure_type_config',
        JSON_OBJECT(
            'id', mtc_input.id,
            'business_id', mtc_input.business_id,
            'product_measure_type_id', mtc_input.product_measure_type_id,
            'name', mtc_input.name,
            'state', mtc_input.state
        ),

        'measure_unit_config',
        JSON_OBJECT(
            'id', muc_input.id,
            'measure_type_config_id', muc_input.measure_type_config_id,
            'unit_measure_id', muc_input.unit_measure_id,
            'is_default', muc_input.is_default,
            'state', muc_input.state
        )

    )

)";

        }

        $detailsAll="
JSON_OBJECT(

    'product',
    JSON_OBJECT(
        'id', p.id,
        'name', p.name,
        'product_type', p.product_type,
        'inventory_type', p.inventory_type,
        'state', p.state,
        'product_trademark_id', p.product_trademark_id ,
        'product_category_id', p.product_category_id  ,
        'product_subcategory_id', p.product_subcategory_id   ,
        'source', p.source   ,
        'description', p.description   ,
        'code_provider', p.code_provider   ,
        'code_product', p.code_product   ,
        'has_tax', p.has_tax   ,
        'is_service', p.is_service   ,
        'product_measure_type_id', p.product_measure_type_id  ,
        'view_online', p.view_online

    ),

    'product_category',
    JSON_OBJECT(
        'id', pc.id,
        'value', pc.value
    ),

    'product_subcategory',
    JSON_OBJECT(
        'id', psc.id,
        'value', psc.value
    ),

    'product_measure_type',
    JSON_OBJECT(
        'id', pmt.id,
        'value', pmt.value,
        'description', pmt.description,
        'abbreviation', pmt.abbreviation,
        'unit', pmt.unit,
        'number_of_units', pmt.number_of_units,
        'prefix', pmt.prefix,
        'symbol', pmt.symbol
    ),

    'stock_unit_measure',
    JSON_OBJECT(
        'id', um_stock.id,
        'product_measure_type_id ', um_stock.product_measure_type_id ,
        'name', um_stock.name,
        'symbol', um_stock.symbol,
        'factor_to_base', um_stock.factor_to_base,
        'is_base', um_stock.is_base,
        'decimal_precision', um_stock.decimal_precision,
        'state', um_stock.state

    ),

    'base_unit_measure',
    JSON_OBJECT(
        'id', um_base.id,
        'product_measure_type_id ', um_base.product_measure_type_id ,
        'name', um_base.name,
        'symbol', um_base.symbol,
        'factor_to_base', um_base.factor_to_base,
        'is_base', um_base.is_base,
        'decimal_precision', um_base.decimal_precision,
        'state', um_base.state

    ),

    'default_unit_measure',
    JSON_OBJECT(
        'id', um_default.id,
        'product_measure_type_id ', um_default.product_measure_type_id ,
        'name', um_default.name,
        'symbol', um_default.symbol,
        'factor_to_base', um_default.factor_to_base,
        'is_base', um_default.is_base,
        'decimal_precision', um_default.decimal_precision,
        'state', um_default.state
    ),
    'tax',
    JSON_OBJECT(
        'id', tx.id,
        'value', tx.value,
        'percentage', tx.percentage,
        'priority', txbb.priority
    ),

    'business_by_products',
    JSON_OBJECT(
        'id', bp.id,
        'business_id', bp.business_id,
        'products_id', bp.products_id
    ),

    'product_inventory',
    JSON_OBJECT(
        'id', pi.id,
        'business_id', pi.business_id,
        'avarage_kardex_value', pi.avarage_kardex_value,
        'tax', pi.tax,
        'quantity_units', pi.quantity_units,
        'sale_price', pi.sale_price,
        'total_price', pi.total_price,
        'product_id', pi.product_id ,
        'tax_id', pi.tax_id  ,
        'profit', pi.profit  ,
        'profit_type', pi.profit_type  ,
        'note', pi.note  ,
        'pi_id', pi.id  ,
        'sale_price2', pi.sale_price2  ,
        'sale_price3', pi.sale_price3  ,
        'sale_price4', pi.sale_price4
    ),

    'product_sell_config',
    JSON_OBJECT(
        'id', pscfg.id,
        'product_id', pscfg.product_id,
        'allow_pos', pscfg.allow_pos,
        'allow_shop', pscfg.allow_shop,
        'allow_delivery', pscfg.allow_delivery,
        'visible', pscfg.visible
    ),

    'product_stock',
    JSON_OBJECT(
        'id', ps.id,
        'product_id', ps.product_id,
        'quantity', ps.quantity,
        'quantity_base', ps.quantity_base,
        'unit_measure_id', ps.unit_measure_id
    ) $inventoryInitial $stockManager

) as details_all
";
        $selectCurrent = [

            /*
            |--------------------------------------------------------------------------
            | PRODUCT
            |--------------------------------------------------------------------------
            */

            'p.id as product_id',

            'p.code',

            'p.name',

            'p.product_type',

            'p.inventory_type',

            'p.state',

            'p.source',

            /*
            |--------------------------------------------------------------------------
            | CATEGORY
            |--------------------------------------------------------------------------
            */

            'pc.value as category',

            'psc.value as subcategory',

            /*
            |--------------------------------------------------------------------------
            | MEASURE
            |--------------------------------------------------------------------------
            */

            'pmt.value as measure_type',
            'pmt.id as measure_type_id',

            /*
            |--------------------------------------------------------------------------
            | STOCK
            |--------------------------------------------------------------------------
            */

            'ps.quantity',

            'ps.quantity_base',

            /*
            |--------------------------------------------------------------------------
            | IDS
            |--------------------------------------------------------------------------
            */

            'p.product_category_id',

            'p.product_subcategory_id',

            /*
            |--------------------------------------------------------------------------
            | TAX
            |--------------------------------------------------------------------------
            */

            'pi.tax_id',

            'tx.value as tax_value',

            'tx.percentage as tax_percentage',

            'pi.tax as has_tax',

            /*
            |--------------------------------------------------------------------------
            | PRICES
            |--------------------------------------------------------------------------
            */

            'pi.sale_price',

            'pi.sale_price2',

            'pi.sale_price3',

            'pi.sale_price4',
            'pi.id as pi_id',

            /*
            |--------------------------------------------------------------------------
            | SELL CONFIG
            |--------------------------------------------------------------------------
            */

            'pscfg.allow_pos',

            'pscfg.allow_shop',

            'pscfg.allow_delivery',

            'pscfg.visible',

            /*
            |--------------------------------------------------------------------------
            | QUANTITY DISPLAY
            |--------------------------------------------------------------------------
            */

            DB::raw("
                CASE

                    WHEN p.product_type = 'MIXED'
                        THEN ps.quantity

                    WHEN p.product_type = 'UNIT'
                        THEN ps.quantity

                    WHEN um_default.factor_to_base > 0
                        THEN ROUND(
                            ps.quantity_base / um_default.factor_to_base,
                            2
                        )

                    ELSE ps.quantity_base

                END as quantity_display
            "),

            /*
            |--------------------------------------------------------------------------
            | STOCK UNIT
            |--------------------------------------------------------------------------
            */

            'um_stock.name as stock_unit',

            'um_stock.symbol as stock_symbol',

            /*
            |--------------------------------------------------------------------------
            | BASE UNIT
            |--------------------------------------------------------------------------
            */

            'um_base.name as base_unit',

            'um_base.symbol as base_symbol',

            /*
            |--------------------------------------------------------------------------
            | DEFAULT UNIT
            |--------------------------------------------------------------------------
            */

            'um_default.name as default_unit',

            'um_default.symbol as default_symbol'
        ];

        $selectCurrent[] = DB::raw($detailsAll);

        $query->select($selectCurrent);

        /*
        |--------------------------------------------------------------------------
        | OPTIONAL CHANNEL FILTER
        |--------------------------------------------------------------------------
        */

        if ($channelColumn) {

            $query->where($channelColumn, 1);
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        if ($categoryId) {

            $query->where(
                'p.product_category_id',
                $categoryId
            );

            if ($subcategoryId) {

                $query->where(
                    'p.product_subcategory_id',
                    $subcategoryId
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $this->applySearch(
            $query,
            $params['searchPhrase'] ?? null,
            [
                'p.name',
                'p.code',
                'pc.value',
                'psc.value'
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $query->orderBy('p.id', 'desc');
        $result = $this->paginate($query, $params, 'p.id');

        return $result;
    }

    public function getProductsManagement($params)
    {
        return $this->getProductsShopPage($params);
    }

    public function getProductsCategoriesByBusiness($params)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        $business_id = $params["filters"]["business_id"];


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = DB::table('product_subcategory as psc')
            /*
            |--------------------------------------------------------------------------
            | MAIN TABLES
            |--------------------------------------------------------------------------
            */
            ->join('product_category as pc', 'psc.product_category_id', '=', 'pc.id')
            ->whereIn('psc.business_id', [$business_id, 1])
            ->where('psc.state', 'ACTIVE')
            /*
            |--------------------------------------------------------------------------
            | SELECT
            |--------------------------------------------------------------------------
            */

            ->select([

                /*
                |--------------------------------------------------------------------------
                | PRODUCT
                |--------------------------------------------------------------------------
                */

                'psc.id as product_subcategory_id',
                'psc.value as product_subcategory',
                'psc.description as product_subcategory_description',
                'pc.id as product_category_id',
                'pc.value as product_category',
                'pc.description as product_category_description',
                'psc.business_id',


            ]);

        $this->applySearch(
            $query,
            $params['searchPhrase'] ?? null,
            [
                'pc.value',
                'psc.value'
            ]
        );

        $rows = $query
            ->orderBy('pc.value')
            ->orderBy('psc.value')
            ->get();
        $result = $rows
            ->groupBy('product_category_id')
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'product_category_id' => $first->product_category_id,
                    'product_category' => $first->product_category,
                    'product_category_description' => $first->product_category_description,
                    'business_id' => $first->business_id,

                    'subcategories' => $items->map(function ($item) {
                        return [
                            'product_category_id' => $item->product_category_id,
                            'product_subcategory_id' => $item->product_subcategory_id,
                            'product_subcategory' => $item->product_subcategory,
                            'product_subcategory_description' => $item->product_subcategory_description,
                        ];
                    })->values(),
                ];
            })
            ->values();

        return $result;
    }

    public function getProductsByTypeForRecipe($params)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        $business_id = $params["filters"]["business_id"];
        $componentProductId = $params["filters"]["componentProductId"];
        $inventory_type = $params["filters"]["inventory_type"];

        $inventoryTypeData = $inventory_type
            ? array_filter(array_map('trim', explode(',', $inventory_type)))
            : [];
        /*
        |--------------------------------------------------------------------------
        | OPTIONAL CHANNEL TYPE
        |--------------------------------------------------------------------------
        */

        $type = isset($params["filters"]['type'])
            ? strtoupper($params["filters"]['type'])
            : null;

        $channelColumn = null;

        if ($type === 'POS') {
            $channelColumn = 'pscfg.allow_pos';
        } elseif ($type === 'SHOP') {
            $channelColumn = 'pscfg.allow_shop';

        } elseif ($type === 'DELIVERY') {
            $channelColumn = 'pscfg.allow_delivery';
        }

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = DB::table('product_stock as ps')
            /*
            |--------------------------------------------------------------------------
            | MAIN TABLES
            |--------------------------------------------------------------------------
            */
            ->join('product as p', 'p.id', '=', 'ps.product_id')
            ->join('business_by_products as bp', 'p.id', '=', 'bp.products_id')
            ->join('product_inventory as pi', 'p.id', '=', 'pi.product_id')
            ->join(
                'product_sell_config as pscfg',
                'pscfg.product_id',
                '=',
                'p.id'
            )
            ->join('tax as tx', 'pi.tax_id', '=', 'tx.id')
            ->join('tax_by_business as txbb', function ($join) use ($business_id) {

                $join->on('tx.id', '=', 'txbb.tax_id')
                    ->where('txbb.business_id', '=', $business_id);

            })
            /*
            |--------------------------------------------------------------------------
            | OPTIONAL TABLES
            |--------------------------------------------------------------------------
            */

            ->leftJoin(
                'product_category as pc',
                'pc.id',
                '=',
                'p.product_category_id'
            )
            ->leftJoin(
                'product_subcategory as psc',
                'psc.id',
                '=',
                'p.product_subcategory_id'
            )
            ->leftJoin(
                'product_measure_type as pmt',
                'pmt.id',
                '=',
                'p.product_measure_type_id'
            )
            ->leftJoin(
                'unit_measure as um_stock',
                'um_stock.id',
                '=',
                'ps.unit_measure_id'
            )
            ->leftJoin('unit_measure as um_base', function ($join) {

                $join->on(
                    'um_base.product_measure_type_id',
                    '=',
                    'p.product_measure_type_id'
                )
                    ->where('um_base.is_base', 1);
            })
            ->leftJoin('measure_type_config as mtc', function ($join) {

                $join->on(
                    'mtc.product_measure_type_id',
                    '=',
                    'p.product_measure_type_id'
                )
                    ->where('mtc.state', 1);
            })
            ->leftJoin('measure_unit_config as muc', function ($join) {

                $join->on(
                    'muc.measure_type_config_id',
                    '=',
                    'mtc.id'
                )
                    ->where('muc.is_default', 1)
                    ->where('muc.state', 1);
            })
            ->leftJoin(
                'unit_measure as um_default',
                'um_default.id',
                '=',
                'muc.unit_measure_id'
            )
            /*
            |--------------------------------------------------------------------------
            | MAIN FILTERS
            |--------------------------------------------------------------------------
            */

            ->where('bp.business_id', $business_id)
            ->whereIn('p.inventory_type', $inventoryTypeData)
            ->where('p.state', 'ACTIVE')
            /*
            |--------------------------------------------------------------------------
            | SELL CONFIG
            |--------------------------------------------------------------------------
            */
            ->where('pscfg.visible', 1)
            /*
            |--------------------------------------------------------------------------
            | SELECT
            |--------------------------------------------------------------------------
            */

            ->select([

                /*
                |--------------------------------------------------------------------------
                | PRODUCT
                |--------------------------------------------------------------------------
                */

                'p.id as product_id',

                'p.code',

                'p.name',

                'p.product_type',

                'p.inventory_type',

                'p.state',

                'p.source',

                /*
                |--------------------------------------------------------------------------
                | CATEGORY
                |--------------------------------------------------------------------------
                */

                'pc.value as category',

                'psc.value as subcategory',

                /*
                |--------------------------------------------------------------------------
                | MEASURE
                |--------------------------------------------------------------------------
                */

                'pmt.value as measure_type',
                'pmt.id as measure_type_id',

                /*
                |--------------------------------------------------------------------------
                | STOCK
                |--------------------------------------------------------------------------
                */

                'ps.quantity',

                'ps.quantity_base',

                /*
                |--------------------------------------------------------------------------
                | IDS
                |--------------------------------------------------------------------------
                */

                'p.product_category_id',

                'p.product_subcategory_id',

                /*
                |--------------------------------------------------------------------------
                | TAX
                |--------------------------------------------------------------------------
                */

                'pi.tax_id',

                'tx.value as tax_value',

                'tx.percentage as tax_percentage',

                'pi.tax as has_tax',

                /*
                |--------------------------------------------------------------------------
                | PRICES
                |--------------------------------------------------------------------------
                */

                'pi.sale_price',

                'pi.sale_price2',

                'pi.sale_price3',

                'pi.sale_price4',
                'pi.id pi_id',

                /*
                |--------------------------------------------------------------------------
                | SELL CONFIG
                |--------------------------------------------------------------------------
                */

                'pscfg.allow_pos',

                'pscfg.allow_shop',

                'pscfg.allow_delivery',

                'pscfg.visible',

                /*
                |--------------------------------------------------------------------------
                | QUANTITY DISPLAY
                |--------------------------------------------------------------------------
                */

                DB::raw("
                CASE

                    WHEN p.product_type = 'MIXED'
                        THEN ps.quantity

                    WHEN p.product_type = 'UNIT'
                        THEN ps.quantity

                    WHEN um_default.factor_to_base > 0
                        THEN ROUND(
                            ps.quantity_base / um_default.factor_to_base,
                            2
                        )

                    ELSE ps.quantity_base

                END as quantity_display
            "),

                /*
                |--------------------------------------------------------------------------
                | STOCK UNIT
                |--------------------------------------------------------------------------
                */

                'um_stock.name as stock_unit',

                'um_stock.symbol as stock_symbol',

                /*
                |--------------------------------------------------------------------------
                | BASE UNIT
                |--------------------------------------------------------------------------
                */

                'um_base.name as base_unit',

                'um_base.symbol as base_symbol',

                /*
                |--------------------------------------------------------------------------
                | DEFAULT UNIT
                |--------------------------------------------------------------------------
                */

                'um_default.name as default_unit',

                'um_default.symbol as default_symbol',
                DB::raw("
JSON_OBJECT(

    'product',
    JSON_OBJECT(
        'id', p.id,
        'name', p.name,
        'product_type', p.product_type,
        'inventory_type', p.inventory_type,
        'state', p.state,
        'product_trademark_id', p.product_trademark_id ,
        'product_category_id', p.product_category_id  ,
        'product_subcategory_id', p.product_subcategory_id   ,
        'source', p.source   ,
        'description', p.description   ,
        'code_provider', p.code_provider   ,
        'code_product', p.code_product   ,
        'has_tax', p.has_tax   ,
        'is_service', p.is_service   ,
        'product_measure_type_id', p.product_measure_type_id  ,
        'view_online', p.view_online

    ),

    'product_category',
    JSON_OBJECT(
        'id', pc.id,
        'value', pc.value
    ),

    'product_subcategory',
    JSON_OBJECT(
        'id', psc.id,
        'value', psc.value
    ),

    'product_measure_type',
    JSON_OBJECT(
        'id', pmt.id,
        'value', pmt.value,
        'description', pmt.description,
        'abbreviation', pmt.abbreviation,
        'unit', pmt.unit,
        'number_of_units', pmt.number_of_units,
        'prefix', pmt.prefix,
        'symbol', pmt.symbol
    ),

    'stock_unit_measure',
    JSON_OBJECT(
        'id', um_stock.id,
        'product_measure_type_id ', um_stock.product_measure_type_id ,
        'name', um_stock.name,
        'symbol', um_stock.symbol,
        'factor_to_base', um_stock.factor_to_base,
        'is_base', um_stock.is_base,
        'decimal_precision', um_stock.decimal_precision,
        'state', um_stock.state

    ),

    'base_unit_measure',
    JSON_OBJECT(
        'id', um_base.id,
        'product_measure_type_id ', um_base.product_measure_type_id ,
        'name', um_base.name,
        'symbol', um_base.symbol,
        'factor_to_base', um_base.factor_to_base,
        'is_base', um_base.is_base,
        'decimal_precision', um_base.decimal_precision,
        'state', um_base.state

    ),

    'default_unit_measure',
    JSON_OBJECT(
        'id', um_default.id,
        'product_measure_type_id ', um_default.product_measure_type_id ,
        'name', um_default.name,
        'symbol', um_default.symbol,
        'factor_to_base', um_default.factor_to_base,
        'is_base', um_default.is_base,
        'decimal_precision', um_default.decimal_precision,
        'state', um_default.state
    ),

    'tax',
    JSON_OBJECT(
        'id', tx.id,
        'value', tx.value,
        'percentage', tx.percentage,
        'priority', txbb.priority
    ),

    'business_by_products',
    JSON_OBJECT(
        'id', bp.id,
        'business_id', bp.business_id,
        'products_id', bp.products_id
    ),

    'product_inventory',
    JSON_OBJECT(
        'id', pi.id,
        'business_id', pi.business_id,
        'avarage_kardex_value', pi.avarage_kardex_value,
        'tax', pi.tax,
        'quantity_units', pi.quantity_units,
        'sale_price', pi.sale_price,
        'total_price', pi.total_price,
        'product_id', pi.product_id ,
        'tax_id', pi.tax_id  ,
        'profit', pi.profit  ,
        'profit_type', pi.profit_type  ,
        'note', pi.note  ,
        'sale_price2', pi.sale_price2  ,
        'sale_price3', pi.sale_price3  ,
        'sale_price4', pi.sale_price4
    ),

    'product_sell_config',
    JSON_OBJECT(
        'id', pscfg.id,
        'product_id', pscfg.product_id,
        'allow_pos', pscfg.allow_pos,
        'allow_shop', pscfg.allow_shop,
        'allow_delivery', pscfg.allow_delivery,
        'visible', pscfg.visible
    ),

    'product_stock',
    JSON_OBJECT(
        'id', ps.id,
        'product_id', ps.product_id,
        'quantity', ps.quantity,
        'quantity_base', ps.quantity_base,
        'unit_measure_id', ps.unit_measure_id
    )

) as details_all
"),
            ]);

        /*
        |--------------------------------------------------------------------------
        | OPTIONAL CHANNEL FILTER
        |--------------------------------------------------------------------------
        */

        if ($channelColumn) {

            $query->where($channelColumn, 1);
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $this->applySearch(
            $query,
            $params['searchPhrase'] ?? null,
            [
                'p.name',
                'p.code',
                'pc.value',
                'psc.value'
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $query->orderBy('p.id', 'desc');
        return $this->paginate($query, $params, 'p.id');
    }
}
