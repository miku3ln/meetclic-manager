<?php

namespace App\Modules\PointSales\Services;

use App\Modules\PointSales\Repositories\ProductRepository;
use App\Services\Inventory\MeasureResolverService;

class StockDiscountService
{
    protected $repo;
    private MeasureResolverService $measureResolverService;

    public function __construct(ProductRepository $repo, MeasureResolverService $measureResolverService)
    {
        $this->measureResolverService =
            $measureResolverService;
        $this->repo = $repo;
    }

    public function process($params)
    {
        $response = [];
        $items = $params["items"];


        foreach ($items as $item) {
            $product = $this->repo->getProductById($item['id']);


            if (!$product) continue;
            $amount = (float)$item['amount'];
            $setPush = $item;
            $setPush["inventory_type"] = $product->inventory_type;
            switch ($product->inventory_type) {
                case 'FOR_SALE'://MENU
                case 'PROCESSED':
                    $dataRecipe = $this->handleMixed($product->id, $amount);
                    $setPush["isRecipe"] = true;
                    $setPush["dataRecipe"] = $dataRecipe;
                    if ($product->inventory_type == "FOR_SALE") {
                        $measure_base = $this->repo->getProductWithStock($item['id']);
                        $setPush["measure_base"] = $measure_base;
                    } else {
                        $measure_base = $this->repo->getProductWithStock($item['id']);
                        $setPush["measure_base"] = $measure_base;
                    }
                    $response[] = $setPush;
                    break;
                case 'RAW':
                case 'UNIT':
                    $measure_base = $this->repo->getProductWithStock($item['id']);
                    $setPush["measure_base"] = $measure_base;
                    $setPush["isRecipe"] = false;
                    $response[] = $setPush;
                    break;
            }
        }

        return $response;
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
        $UNIT_MEASURE_ID = 5;//UNIT
        $PRODUCT_MEASURE_TYPE_UNIT = 35;
        foreach ($recipe as $component) {

            $measureType = $component->product_measure_type_name;


            $measure_base = $this->repo->getProductWithStock($component->product_id);
            $base_unit_measure_id = $component->base_unit_measure_id;
            $total_amount = 0;
            $recipe_quantity = 0;
            if ($PRODUCT_MEASURE_TYPE_UNIT == $component->product_measure_type_id) {
                $total_amount = ($amount * $component->quantity);
                $recipe_quantity = $component->quantity_input;
            } else {
                $quantityInput = $component->um_base_input_quantity_input * $amount;
                $quantityInput = number_format((float)$quantityInput, 4, '.', '');
                $total_amount = $quantityInput;
                $recipe_quantity = $total_amount;
            }

            $response[] = [
                'id' => $component->product_id,
                'name' => $component->name,
                'type' => $component->component_type,
                'discount_quantity' => $amount,
                'recipe_quantity' => $recipe_quantity,
                'total_amount' => $total_amount,
                'measure_base' => $measure_base,
                'quantity_component' => $component->quantity,
                'component_quantity_input' => $component->quantity,
                'component_recipe_quantity' => $component->recipe_quantity,
                "conversion" => [
                    "um_base_id" => $component->um_base_id,
                    "um_base_name" => $component->um_base_name,
                    "um_base_factor_to_base" => $component->um_base_factor_to_base,
                    "um_base_symbol" => $component->um_base_symbol,
                    "um_base_quantity" => $component->um_base_quantity,
                    "um_base_input_id" => $component->um_base_input_id,
                    "um_base_input_name" => $component->um_base_input_name,
                    "um_base_input_factor_to_base" => $component->um_base_input_factor_to_base,
                    "um_base_input_symbol" => $component->um_base_input_symbol,
                    "um_base_input_quantity" => $component->um_base_input_quantity,
                ]


            ];


        }

        return $response;
    }

    private function buildMovement($productId, $amount, $measure_base, $allowValidateStock, $conversion)
    {
        $stock = $this->repo->getStock($productId);
        if ($allowValidateStock) {
            if ($amount > $stock["value"]) {
                $faltante = $amount - $stock["value"];
                return [
                    "success" => false,
                    "message" => "Stock insuficiente",
                    "error" => [
                        "requested" => $amount,
                        "available" => $stock["value"],
                        "missing" => $faltante,
                        "unit" => $stock["unit"],
                        "type" => $stock["type"]
                    ]
                ];
            }
        }
        $movement = [
            "product_id" => $productId,
            "movement_type" => "OUT",
            "reference_type" => "SALE",
            "reference_id" => -1,
            "description" => "Venta POS-Product"
        ];

        switch ($stock["type"]) {
            case "UNIT":

                $movement["quantity"] = $amount;
                $movement["unit_measure_id"] = $stock["unit_id"];
                $movement["quantity_input"] = $amount;
                $movement["unit_input_id"] = $stock["unit_id"];
                $movement["conversion_factor"] = 1;
                break;
            case "MEASURABLE":
            case "MIXED":
                $quantityInput = number_format((float)$amount * $conversion["um_base_input_factor_to_base"], 3, '.', '');
                $movement["quantity"] =  $amount;
                $movement["unit_measure_id"] =  $conversion["um_base_input_id"];
                $movement["quantity_input"] =$quantityInput;
                $movement["unit_input_id"] =$stock["unit_id"];
                $movement["conversion_factor"] = $conversion["um_base_input_factor_to_base"];

                break;
        }

        return [
            "success" => true,
            "data" => $movement,
            "message" => "Puede Realizar el debito del inventario!"
        ];
    }

    public function validateStock($params)
    {
        $items = $params['items'];
        $allowValidateStock = $params['allowValidateStock'];


        $result = [];
        foreach ($items as $item) {
            $setPush = [
                "success" => false,
                "message" => "",
                "data" => [],
                "errors" => []
            ];
            if ($item["isRecipe"]) {
                $inventory_movements = [];
                $countFails = 0;
                $message = "Algun Ingrediente no tiene Valores disponibles";
                $errorsItems = [];
                foreach ($item["dataRecipe"] as $recipeRow) {
                    $conversion = $recipeRow["conversion"];
                    $response = $this->buildMovement(
                        $recipeRow["id"],
                        $recipeRow["total_amount"],
                        $recipeRow["measure_base"], $allowValidateStock,
                        $conversion
                    );
                    if ($allowValidateStock) {
                        if (!$response["success"]) {
                            $countFails++;
                            array_push($errorsItems, $recipeRow);
                        } else {
                            array_push($inventory_movements, $response["data"]);
                        }
                    } else {
                        array_push($inventory_movements, $response["data"]);

                    }
                }
                if ($item["inventory_type"] == 'FOR_SALE' || $item["inventory_type"] == 'PROCESSED') {
                    if (isset($item["measure_base"])) {
                        $responseMovement = $this->buildMovement(
                            $item["id"],
                            $item["amount"],
                            $item["measure_base"], $allowValidateStock,
                            $conversion
                        );
                        array_push($inventory_movements, $responseMovement["data"]);
                    }

                }
                $item["inventory_movements"] = $inventory_movements;
                $setPush["success"] = $countFails == 0;
                $setPush["message"] = $countFails == 0 ? "Todo Ok" : $message;
                $setPush["errors"] = $errorsItems;
                $setPush["data"] = $item;

            } else {
                $response = $this->buildMovement(
                    $item["id"],
                    $item["amount"],
                    $item["measure_base"], $allowValidateStock,
                    $conversion
                );
                $setPush["success"] = $response["success"];
                $setPush["message"] = $response["message"];
                $item["inventory_movements"] = [$response["data"]];
            }
            $setPush["data"] = $item;
            array_push($result, $setPush);

        }

        return $result;
    }


}
