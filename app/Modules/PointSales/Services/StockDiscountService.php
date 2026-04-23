<?php
namespace App\Modules\PointSales\Services;

use App\Modules\PointSales\Repositories\ProductRepository;
class StockDiscountService
{
    protected $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    public function process($items)
    {
        $response = [];

        foreach ($items as $item) {

            $product = $this->repo->getProductById($item['id']);

            if (!$product) continue;

            $amount = (float) $item['amount'];
            if ($amount <= 0) continue;

            switch ($product->product_type) {

                case 'MIXED':
                    $dataRecipe = $this->handleMixed($product->id, $amount);

                    $response[] = [
                        "name"=> $product->name,
                        'product_id' => $product->id,
                        'type' => 'UNIT',
                        'discount_quantity' => $amount,
                        'unit' => 'u',
                        'isRecipe'=>true,
                        'data'=>$dataRecipe
                    ];
                    break;

                case 'UNIT':
                    $response[] = [
                        "name"=> $product->name,
                        'product_id' => $product->id,
                        'type' => 'UNIT',
                        'discount_quantity' => $amount,
                        'unit' => 'u',
                        'isRecipe'=>false,
                    ];
                    break;

                case 'MEASURABLE':
                    $response[] = [
                        "name"=> $product->name,
                        'product_id' => $product->id,
                        'type' => 'MEASURABLE',
                        'discount_quantity' => $amount,
                        'unit' => 'base',
                        'isRecipe'=>false,

                    ];
                    break;
            }
        }

        return $this->consolidate($response);
    }
    private function consolidate($items)
    {
        $grouped = [];

        foreach ($items as $item) {

            $key = $item['product_id'] . '_' . $item['unit'];

            if (!isset($grouped[$key])) {
                $grouped[$key] = $item;
            } else {
                $grouped[$key]['discount_quantity'] += $item['discount_quantity'];
            }
        }

        return array_values($grouped);
    }
    private function handleMixed($productId, $amount)
    {

        $recipe = $this->repo->getRecipe($productId);

        // ⚠️ aquí NO validamos nada
        if (!$recipe || count($recipe) === 0) {
            return [];
        }

        $response = [];

        foreach ($recipe as $component) {

            $required = $component->quantity ;

            $response[] = [
                'product_id' => $component->component_product_id,
                'name' => $component->name,
                'type' => 'MEASURABLE',
                'discount_quantity' => $required, // 🔥 FIX AQUÍ
                'unit' => 'base',
                'source_product_id' => $productId
            ];
        }

        return $response;
    }
    public function validateStock($items)
    {
        $errors = [];
        $validated = [];

        foreach ($items as $item) {

            $required = $item['discount_quantity'] ?? 0;
            $stock = $this->repo->getStock($item['product_id']);
            $availableFormatted = $this->formatQuantity($item['product_id'], $stock);
            $requiredFormatted  = $this->formatQuantity($item['product_id'], $required);
            // 🔥 validar
            if ($stock < $required) {



                $errors[] = [
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'error' => 'INSUFFICIENT_STOCK',
                    'available' => $availableFormatted['value'],
                    'available_unit' => $availableFormatted['unit'],
                    'required' => $requiredFormatted['value'],
                    'required_unit' => $requiredFormatted['unit']
                ];

                $validated[] = [
                    ...$item,
                    'validation' => [
                        'success' => false,
                        'message' => 'Stock insuficiente'
                    ]
                ];

            } else {

                $validated[] = [
                    ...$item,
                    'dataComparation'=>[
                        'available' => $availableFormatted['value'],
                        'available_unit' => $availableFormatted['unit'],
                    ],
                    'validation' => [
                        'success' => true,
                        'message' => 'OK'
                    ]
                ];
            }
        }

        return [
            'success' => empty($errors),
            'items' => $validated,
            'errors' => $errors
        ];
    }
    private function formatQuantity($productId, $quantityBase)
    {
        $product = $this->repo->getProductWithUnits($productId);

        if (!$product) {
            return [
                'value' => $quantityBase,
                'unit' => 'base'
            ];
        }
      
        // MIXED o UNIT → no convertir
        if ($product->product_type === 'MIXED' || $product->product_type === 'UNIT') {
            return [
                'value' => $quantityBase,
                'unit' => $product->stock_symbol ?? 'u'
            ];
        }

        // MEASURABLE → convertir a unidad default
        if ($product->default_factor > 0) {
            return [
                'value' => round($quantityBase / $product->default_factor, 2),
                'unit' => $product->default_symbol
            ];
        }

        return [
            'value' => $quantityBase,
            'unit' => $product->base_symbol ?? 'base'
        ];
    }
}
