<?php

namespace App\Modules\PointSales\Services;

use App\Modules\PointSales\Constants\ProductClassification;
use App\Modules\PointSales\Repositories\ProductSalesRepository;

class ProductSalesService
{
    protected $repo;

    public function __construct(ProductSalesRepository $repo)
    {
        $this->repo = $repo;
    }

    /*
       |--------------------------------------------------------------------------
       | TRANSFORM SINGLE PRODUCT
       |--------------------------------------------------------------------------
       */

    /*
    |--------------------------------------------------------------------------
    | TRANSFORM COLLECTION
    |--------------------------------------------------------------------------
    */

    private function transformProducts(array $result): array
    {
        $publicAsset = URL("") . "/public";

        $rows = collect($result['rows'])
            ->map(fn($item) =>
            $this->transformProductRow($item, $publicAsset)
            );

        return [
            'total' => $result['total'],
            'rows' => $rows,
            'current' => $result['current'],
            'rowCount' => $result['rowCount'],
        ];
    }
    private function transformProductRow($item, string $publicAsset): array
    {
        $source = $publicAsset . (
            $item->source == null
                ? "/images/default/not-image-product-point-sales.png"
                : $item->source
            );

        $functionalType = $this->resolveFunctionalType($item);

        return [
            'id' => $item->product_id,
            'code' => $item->code,
            'name' => $item->name,
            'type' => $item->product_type,
            'source' => $source,

            'product_category_id' => $item->product_category_id,
            'product_subcategory_id' => $item->product_subcategory_id,

            'stock' => [
                'quantity' => $item->quantity_display,
                'unit' => $item->default_symbol ?? $item->stock_symbol ?? 'u'
            ],
            'tax' => [
                'id' => $item->tax_id,

                'has_tax' => $item->has_tax,
                'value_text' => $item->tax_value,
                'value_percentage' => $item->tax_percentage,

            ],
            'price' => [
                'pv' => $item->sale_price,
                'pv_two' => $item->sale_price3,
                'pv_three' => $item->sale_price4,
                'pc' => $item->sale_price2,


            ],
            'category' => $item->category,
            'subcategory' => $item->subcategory,
            /*
            |--------------------------------------------------------------------------
            | NEW CLASSIFICATION
            |--------------------------------------------------------------------------
            */
            'measure_type_management' => [
                'id'=>$item->measure_type_id,
                'value'=>$item->measure_type,

            ],
            'classification' => [
                'product_type' => $item->product_type,
                'inventory_type' => $item->inventory_type,
                'structure_type' => $item->product_type,


                'functional_type' => $functionalType,

                'is_virtual' => $item->product_type === ProductClassification::TYPE_MIXED,

                'stock_managed' =>
                    $item->product_type !== ProductClassification::TYPE_MIXED,

                'is_sellable' =>
                    $item->inventory_type === ProductClassification::INVENTORY_FOR_SALE,

                'is_produced' =>
                    $item->inventory_type === ProductClassification::INVENTORY_PROCESSED,
            ],

        ];
    }
    public function setProductTypeSave($params)
    {

        return $this->repo->setProductTypeSave($params);
    }
    public function getProducts($params)
    {

        $result = $this->repo->getProductsShopPage($params);

        return $this->transformProducts($result);
    }

    public function getProductsShopPage($params)
    {

        $result = $this->repo->getProductsShopPage($params);

        return $this->transformProducts($result);
    }

    private function resolveFunctionalType($item): ?string
    {
        if (
            $item->product_type === ProductClassification::TYPE_MEASURABLE &&
            $item->inventory_type === ProductClassification::INVENTORY_RAW
        ) {
            return ProductClassification::RAW_MEASURABLE;
        }

        if (
            $item->product_type === ProductClassification::TYPE_UNIT &&
            $item->inventory_type === ProductClassification::INVENTORY_RAW
        ) {
            return ProductClassification::RAW_UNIT;
        }

        if (
            $item->product_type === ProductClassification::TYPE_MEASURABLE &&
            $item->inventory_type === ProductClassification::INVENTORY_PROCESSED
        ) {
            return ProductClassification::PROCESSED_MEASURABLE;
        }

        if (
            $item->product_type === ProductClassification::TYPE_UNIT &&
            $item->inventory_type === ProductClassification::INVENTORY_PROCESSED
        ) {
            return ProductClassification::PROCESSED_UNIT;
        }

        if (
            $item->product_type === ProductClassification::TYPE_MEASURABLE &&
            $item->inventory_type === ProductClassification::INVENTORY_FOR_SALE
        ) {
            return ProductClassification::FOR_SALE_MEASURABLE;
        }

        if (
            $item->product_type === ProductClassification::TYPE_UNIT &&
            $item->inventory_type === ProductClassification::INVENTORY_FOR_SALE
        ) {
            return ProductClassification::FOR_SALE_UNIT;
        }

        if (
            $item->product_type === ProductClassification::TYPE_MIXED &&
            $item->inventory_type === ProductClassification::INVENTORY_FOR_SALE
        ) {
            return ProductClassification::FOR_SALE_MIXED;
        }

        return null;
    }
}
