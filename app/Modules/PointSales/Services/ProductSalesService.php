<?php

namespace App\Modules\PointSales\Services;

use App\Modules\PointSales\Repositories\ProductSalesRepository;

class ProductSalesService
{
    protected $repo;

    public function __construct(ProductSalesRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getProducts($params)
    {

        $result = $this->repo->getProducts($params);
        $publicAsset = URL("") . "/public";

        $rows = collect($result['rows'])->map(function ($item) use ($publicAsset) {

;            $source = $publicAsset . (
                $item->source == null
                    ? "/images/default/not-image-product-point-sales.png"
                    : $item->source
                );

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
            ];
        });

        return [
            'total' => $result['total'],
            'rows' => $rows,
            'current' => $result['current'],
            'rowCount' => $result['rowCount'],
        ];
    }
}
