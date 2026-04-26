<?php

namespace App\Http\Controllers\PointSales;

use App\Http\Controllers\PointSalesBaseController;

use App\Modules\PointSales\Services\ProductSalesService;
use App\Modules\PointSales\Services\StockDiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends PointSalesBaseController
{


    public function __construct(ProductSalesService $service, StockDiscountService $serviceStock)
    {
        $this->service = $service;
        $this->stockDiscountService = $serviceStock;

    }

    public function getProductsSales(Request $request)
    {

        $params = $request->all();
        $data = $this->service->getProducts($params);
        $this->user= $request->get('auth_user');
        return response()->json($data);
    }

    public function generateTicket(Request $request)
    {
        $payload = $request->json()->all();

        // 👇 Si NO viene body → simulamos
        $type = "mixed_unit_ok";
        if (!isset($payload['body']) || empty($payload['body'])) {


            $payload['body'] = $this->getMockData($type);
        }

        $calculated = $this->stockDiscountService->process($payload['body']);

        // 2. validar inventario
        $validated = $this->stockDiscountService->validateStock($calculated);

        return response()->json([
            'success' => true,
            'data' => $validated
        ]);

    }

    private function getMockData($type)
    {
        switch ($type) {

            // =========================================
            // 1) MIXED + UNIT (OK)
            // =========================================
            case 'mixed_unit_ok':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 10],
                    ["id" => 8, "type" => "MIXED", "amount" => 2]
                ];

            // =========================================
            // 2) SOLO MIXED (OK)
            // =========================================
            case 'mixed_ok':
                return [
                    ["id" => 8, "type" => "MIXED", "amount" => 2],
                    ["id" => 9, "type" => "MIXED", "amount" => 1]
                ];

            // =========================================
            // 3) SOLO MIXED (INSUFFICIENT)
            // =========================================
            case 'mixed_fail':
                return [
                    ["id" => 8, "type" => "MIXED", "amount" => 50]
                ];

            // =========================================
            // 4) SOLO UNIT (OK)
            // =========================================
            case 'unit_ok':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 10],
                    ["id" => 6, "type" => "UNIT", "amount" => 20]
                ];

            // =========================================
            // 5) SOLO UNIT (UNO FALLA)
            // =========================================
            case 'unit_partial_fail':
                return [
                    ["id" => 6, "type" => "UNIT", "amount" => 200], // OK
                    ["id" => 7, "type" => "UNIT", "amount" => 200]  // FAIL
                ];

            // =========================================
            // 6) SOLO UNIT (TODO FALLA)
            // =========================================
            case 'unit_fail_all':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 1000],
                    ["id" => 7, "type" => "UNIT", "amount" => 500]
                ];

            // =========================================
            // 7) MIXED + UNIT (UNO FALLA)
            // =========================================
            case 'mixed_unit_partial_fail':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 10],   // OK
                    ["id" => 8, "type" => "MIXED", "amount" => 50]  // FAIL
                ];

            // =========================================
            // 8) MIXED SIN RECETA (ERROR)
            // =========================================
            case 'mixed_no_recipe':
                return [
                    ["id" => 30, "type" => "MIXED", "amount" => 1] // suponiendo sin receta
                ];

            // =========================================
            // 9) PRODUCTO INEXISTENTE
            // =========================================
            case 'product_not_found':
                return [
                    ["id" => 9999, "type" => "UNIT", "amount" => 1]
                ];

            // =========================================
            // 10) AMOUNT = 0 (EDGE CASE)
            // =========================================
            case 'zero_amount':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 0]
                ];

            // =========================================
            // 11) AMOUNT NEGATIVO (ERROR)
            // =========================================
            case 'negative_amount':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => -5]
                ];

            // =========================================
            // 12) MIXED CON MÚLTIPLES COMPONENTES
            // =========================================
            case 'mixed_complex':
                return [
                    ["id" => 17, "type" => "MIXED", "amount" => 3] // choripapa
                ];

            // =========================================
            // 13) COMBINACIÓN GRANDE (SIMULACIÓN POS REAL)
            // =========================================
            case 'full_order':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 5],
                    ["id" => 6, "type" => "UNIT", "amount" => 10],
                    ["id" => 8, "type" => "MIXED", "amount" => 3],
                    ["id" => 17, "type" => "MIXED", "amount" => 2],
                    ["id" => 15, "type" => "MIXED", "amount" => 1]
                ];

            // =========================================
            // 14) DUPLICADOS (MISMO PRODUCTO)
            // =========================================
            case 'duplicates':
                return [
                    ["id" => 5, "type" => "UNIT", "amount" => 10],
                    ["id" => 5, "type" => "UNIT", "amount" => 15]
                ];

            // =========================================
            // 15) SIN DATA
            // =========================================
            case 'empty':
                return [];

            default:
                return [];
        }
    }
}
