<?php

namespace App\Utils\Product;


use App\Models\InvoiceSales\InventoryMovement;
use App\Models\Products\ProductStock;
use Illuminate\Support\Facades\DB;
use Throwable;

class InventoryRecipeProcessManager
{
    private string $currentStep = '';

    /**
     * Ejecuta el proceso completo:
     *
     * 1. Validar product_stock calculado.
     * 2. Actualizar product_stock.
     * 3. Insertar inventory_movement.
     *
     * Todo dentro de una sola transacción.
     */
    public function execute(
        array $productStockManager,
        array $inventoryMovementData
    ): array
    {

        $this->currentStep =
            'INVENTORY_RECIPE_PROCESS';

        try {

            /**
             * =====================================================
             * 1. VALIDAR RESULTADO DE PRODUCT STOCK
             * =====================================================
             */
            $validation =
                $this->validateProductStockManager(
                    $productStockManager
                );



            /**
             * =====================================================
             * 2. VALIDAR MOVIMIENTOS
             * =====================================================
             */
            if (empty($inventoryMovementData)) {

                return [
                    'success' =>
                        false,

                    'step' =>
                        $this->currentStep,

                    'action' =>
                        null,

                    'data' =>
                        null,

                    'errors' => [
                        'inventory_movement' =>
                            'No existen movimientos para registrar.'
                    ],

                    'msj' =>
                        'No existen movimientos de inventario.',
                ];
            }

            /**
             * =====================================================
             * 4. ACTUALIZAR PRODUCT STOCK
             * =====================================================
             */
            $updatedStocks =
                $this->updateProductsStock(
                    $productStockManager['data']
                );

            /**
             * =====================================================
             * 5. REGISTRAR INVENTORY MOVEMENT
             * =====================================================
             */
            $createdMovements =
                $this->createInventoryMovements(
                    $inventoryMovementData
                );


            /**
             * =====================================================
             * 7. RESULTADO
             * =====================================================
             */
            return [
                'success' =>
                    true,

                'step' =>
                    $this->currentStep,

                'action' =>
                    'UPDATE_STOCK_AND_CREATE_MOVEMENT',

                'data' => [

                    'product_stock' =>
                        $updatedStocks,

                    'inventory_movement' =>
                        $createdMovements,
                ],

                'errors' =>
                    [],

                'msj' =>
                    'Inventario actualizado correctamente.',
            ];

        } catch (Throwable $e) {

            DB::rollBack();

            return [
                'success' =>
                    false,

                'step' =>
                    $this->currentStep,

                'action' =>
                    null,

                'data' =>
                    null,

                'errors' => [

                    'message' =>
                        $e->getMessage(),

                    'line' =>
                        $e->getLine(),

                    'file' =>
                        $e->getFile(),
                ],

                'msj' =>
                    $e->getMessage(),
            ];
        }
    }
    private function createInventoryMovement(
        array $movementData
    ): InventoryMovement {

        $model =
            new InventoryMovement();

        $model->product_id =
            $movementData['product_id'];

        $model->movement_type =
            $movementData['movement_type'];

        $model->quantity =
            $movementData['quantity'];

        $model->unit_measure_id =
            $movementData['unit_measure_id'];

        $model->quantity_input =
            $movementData['quantity_input']
            ?? null;

        $model->unit_input_id =
            $movementData['unit_input_id']
            ?? null;

        $model->conversion_factor =
            $movementData['conversion_factor']
            ?? null;

        $model->reference_type =
            $movementData['reference_type']
            ?? null;

        $model->reference_id =
            $movementData['reference_id']
            ?? null;

        $model->description =
            $movementData['description']
            ?? null;

        $model->save();

        return $model;
    }
    public function executeProductMovement(
        array $payload
    ): array {

        $this->currentStep =
            'INVENTORY_PRODUCT_MOVEMENT';



        try {

            /**
             * =====================================================
             * 1. OBTENER DATA
             * =====================================================
             */
            $productStockData =
                $payload['product_stock']
                ?? [];

            $inventoryMovementData =
                $payload['inventory_movement']
                ?? [];

            /**
             * =====================================================
             * 2. VALIDAR PRODUCT STOCK
             * =====================================================
             */
            if (empty($productStockData)) {



                return [
                    'success' => false,
                    'step' => $this->currentStep,
                    'action' => null,
                    'data' => null,
                    'errors' => [
                        'product_stock' =>
                            'No existe información para actualizar product_stock.'
                    ],
                    'msj' =>
                        'No existe información de stock.'
                ];
            }

            /**
             * =====================================================
             * 3. VALIDAR INVENTORY MOVEMENT
             * =====================================================
             */
            if (empty($inventoryMovementData)) {



                return [
                    'success' => false,
                    'step' => $this->currentStep,
                    'action' => null,
                    'data' => null,
                    'errors' => [
                        'inventory_movement' =>
                            'No existe información para registrar el movimiento.'
                    ],
                    'msj' =>
                        'No existe información de movimiento.'
                ];
            }

            /**
             * =====================================================
             * 4. ACTUALIZAR PRODUCT STOCK
             * =====================================================
             */
            $updatedStock =
                $this->updateProductStock(
                    $productStockData
                );

            /**
             * =====================================================
             * 5. CREAR INVENTORY MOVEMENT
             * =====================================================
             */
            $createdMovement =
                $this->createInventoryMovement(
                    $inventoryMovementData
                );

            /**
             * =====================================================
             * 6. CONFIRMAR TRANSACCIÓN
             * =====================================================
             */

            /**
             * =====================================================
             * 7. RESULTADO
             * =====================================================
             */
            return [
                'success' => true,

                'step' =>
                    $this->currentStep,

                'action' =>
                    'UPDATE_STOCK_AND_CREATE_MOVEMENT',

                'data' => [

                    'product_stock' =>
                        $updatedStock,

                    'inventory_movement' =>
                        $createdMovement,
                ],

                'errors' =>
                    [],

                'msj' =>
                    'Inventario actualizado correctamente.'
            ];

        } catch (Throwable $e) {
            return [
                'success' => false,

                'step' =>
                    $this->currentStep,

                'action' =>
                    null,

                'data' =>
                    null,

                'errors' => [

                    'message' =>
                        $e->getMessage(),

                    'line' =>
                        $e->getLine(),

                    'file' =>
                        $e->getFile()
                ],

                'msj' =>
                    $e->getMessage()
            ];
        }
    }
    /**
     * =============================================================
     * VALIDAR PRODUCT STOCK MANAGER
     * =============================================================
     */
    private function validateProductStockManager(
        array $productStockManager
    ): array
    {



        $items =
            $productStockManager['data']
            ?? [];

        if (empty($items)) {

            return [
                'success' =>
                    false,

                'message' =>
                    'No existen productos de receta para actualizar.',

                'errors' => [
                    'product_stock' =>
                        'No existen registros.'
                ],
            ];
        }

        /**
         * Validación individual.
         */
        foreach ($items as $item) {

            $managerProcess =
                $item['manager_process']
                ?? [];

            if (
                !($managerProcess['success'] ?? false)
            ) {

                return [
                    'success' =>
                        false,

                    'message' =>
                        $managerProcess['message']
                        ?? 'No se puede actualizar el inventario.',

                    'errors' => [

                        'type_error' =>
                            $managerProcess['type_error']
                            ?? 'INVENTORY_PROCESS_ERROR',

                        'product_id' =>
                            data_get(
                                $item,
                                'product_stock.product_id'
                            ),
                    ],
                ];
            }
        }

        return [
            'success' =>
                true,

            'message' =>
                '',

            'errors' =>
                [],
        ];
    }
    private function updateProductStock(
        array $stockData
    ): ProductStock
    {
        $id =
            (int)($stockData['id'] ?? 0);

        $productId =
            (int)($stockData['product_id'] ?? 0);

        $model =
            ProductStock::where(
                'id',
                $id
            )
                ->where(
                    'product_id',
                    $productId
                )
                ->first();

        if (!$model) {

            throw new \Exception(
                'No existe product_stock para product_id: '
                . $productId
            );
        }

        $model->quantity =
            $stockData['quantity'];

        $model->quantity_base =
            $stockData['quantity_base'];

        $model->save();

        return $model;
    }
    /**
     * =============================================================
     * ACTUALIZAR PRODUCT STOCK
     * =============================================================
     */
    private function updateProductsStock(
        array $items
    ): array
    {
        $result = [];

        foreach ($items as $item) {

            $stockData =
                $item['product_stock']
                ?? [];

            $model =
                $this->updateProductStock(
                    $stockData
                );

            $result[] =
                $model;
        }

        return $result;
    }
    /**
     * =============================================================
     * CREAR INVENTORY MOVEMENTS
     * =============================================================
     */
    private function createInventoryMovements(
        array $inventoryMovementData
    ): array
    {

        $result = [];

        foreach ($inventoryMovementData as $movementData) {

            $model =
                new InventoryMovement();

            $model->product_id =
                $movementData['product_id'];

            $model->movement_type =
                $movementData['movement_type'];

            $model->quantity =
                $movementData['quantity'];

            $model->unit_measure_id =
                $movementData['unit_measure_id'];

            $model->quantity_input =
                $movementData['quantity_input']
                ?? null;

            $model->unit_input_id =
                $movementData['unit_input_id']
                ?? null;

            $model->conversion_factor =
                $movementData['conversion_factor']
                ?? null;

            $model->reference_type =
                $movementData['reference_type']
                ?? null;

            $model->reference_id =
                $movementData['reference_id']
                ?? null;

            $model->description =
                $movementData['description']
                ?? null;

            $model->save();

            $result[] =
                $model;
        }

        return $result;
    }

    public static function buildParentProductStockData(
        object $product,
        object $inventoryCurrent,
        float $amount,
        $unit_measure_id,
        float $amountBase,
        $unit_base_measure_id,
        $conversion_factor,
        int $typeMovement

    ): array {

        $managerProcess = [
            'success' => true,
            'message' => '',
            'type_error' => null,
        ];

        $managerRegisterId =
            $inventoryCurrent->manager_register_id
            ?? null;

        if (!$managerRegisterId) {

            return [
                'success' => false,

                'message' =>
                    'No existe registro de inventario para '
                    . $product->name
                    . '.',

                'data' => null,

                'manager_process' => [
                    'success' => false,
                    'message' =>
                        'No existe registro de inventario para '
                        . $product->name
                        . '.',
                    'type_error' =>
                        'STOCK_NOT_FOUND',
                ],
            ];
        }

        $currentQuantity =
            (float)$inventoryCurrent->quantity;

        $currentQuantityBase =
            (float)$inventoryCurrent->quantity_base;

        /*
         * typeMovement = 1
         * Entrada del producto procesado.
         *
         * typeMovement = 0
         * Reverso/salida del producto procesado.
         */
        if ($typeMovement === 1) {

            $quantity =
                $currentQuantity + $amount;

            $quantityBase =
                $currentQuantityBase + $amountBase;

            $movementType =
                'IN';

            $description =
                'Entrada de inventario por producción';

        } else {

            $quantity =
                $currentQuantity - $amount;

            $quantityBase =
                $currentQuantityBase - $amountBase;

            $movementType =
                'OUT';

            $description =
                'Salida de inventario por reverso de producción';
        }



        /*
         * =====================================================
         * PRODUCT STOCK
         * =====================================================
         */
        $productStock = [

            'id' =>
                (int)$managerRegisterId,

            'product_id' =>
                (int)$product->id,

            'quantity' =>
                round($quantity, 6),

            'quantity_base' =>
                round($quantityBase, 6),
        ];

        /*
         * =====================================================
         * INVENTORY MOVEMENT
         * =====================================================
         */
        $inventoryMovement = [

            'product_id' =>
                (int)$product->id,

            'movement_type' =>
                $movementType,

            'quantity' =>
                round($amount, 6),

            'unit_measure_id' =>
                (int)$inventoryCurrent->base_unit_id,

            'quantity_input' =>
                round($amountBase, 6),

            'unit_input_id' =>$unit_measure_id,

            'conversion_factor' =>
                $conversion_factor,

            'reference_type' =>
                'INVENTORY_PRODUCTION_MOVEMENT',

            'reference_id' =>
                null,

            'description' =>
                $description,
        ];

        return [

            'success' =>
                $managerProcess['success'],

            'message' =>
                $managerProcess['message'],

            'data' => [

                'product_stock' =>
                    $productStock,

                'inventory_movement' =>
                    $inventoryMovement,
            ],

            'manager_process' =>
                $managerProcess,
        ];
    }
}
