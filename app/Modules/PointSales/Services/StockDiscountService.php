<?php

namespace App\Modules\PointSales\Services;

use App\Models\Products\ProductRecipeYield;
use App\Models\ProductsMeasure\UnitMeasure;
use App\Modules\PointSales\Repositories\ProductRepository;
use App\Services\Inventory\MeasureResolverService;
use App\Utils\Product\InventoryRecipeProcessManager;
use Illuminate\Support\Facades\DB;
use Throwable;

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

    public function generateMovementProduct($params)
    {
        $dataProduct = $this->getDataProductMovement($params);
        return $dataProduct;
    }

    private function buildRecipeProductStockData(
        array $dataRecipeManager,
        int   $typeMovement
    ): array
    {

        $isIngredientOut =
            $typeMovement === 1;

        $items = collect($dataRecipeManager)
            ->groupBy(function ($item) {

                return data_get(
                    $item,
                    'transform.product_id'
                );
            })
            ->map(function ($items, $productId) use (
                $isIngredientOut
            ) {

                $first =
                    $items->first();

                $transform =
                    data_get(
                        $first,
                        'transform',
                        []
                    );

                $inventoryCurrent =
                    data_get(
                        $first,
                        'inventoryCurrent',
                        []
                    );

                /*
                 * =====================================================
                 * CANTIDAD TOTAL DEL MOVIMIENTO
                 * =====================================================
                 *
                 * input_manager.amount
                 *      Cantidad expresada en la unidad ingresada.
                 *
                 * base_manager.amount
                 *      Cantidad convertida a la unidad base.
                 */
                $movementQuantity =
                    $items->sum(function ($item) {

                        return (float)data_get(
                            $item,
                            'transform.input_manager.amount',
                            0
                        );
                    });

                $movementQuantityBase =
                    $items->sum(function ($item) {

                        return (float)data_get(
                            $item,
                            'transform.base_manager.amount',
                            0
                        );
                    });

                /*
                 * =====================================================
                 * STOCK ACTUAL
                 * =====================================================
                 */
                $currentQuantity =
                    (float)data_get(
                        $inventoryCurrent,
                        'quantity',
                        0
                    );

                $currentQuantityBase =
                    (float)data_get(
                        $inventoryCurrent,
                        'quantity_base',
                        0
                    );

                /*
                 * =====================================================
                 * NUEVO STOCK
                 * =====================================================
                 */
                $quantityBase =
                    $isIngredientOut
                        ? $currentQuantityBase - $movementQuantityBase
                        : $currentQuantityBase + $movementQuantityBase;

                /*
                 * Como product_stock actualmente está almacenado
                 * en su unidad de stock/base, quantity debe seguir
                 * esa misma representación.
                 */
                $quantity =
                    $quantityBase;

                /*
                 * =====================================================
                 * MANAGER PROCESS
                 * =====================================================
                 */
                $managerProcess = [
                    'success' => true,
                    'message' => '',
                    'type_error' => null,
                ];

                /*
                 * Registro de stock inexistente.
                 */
                $managerRegisterId =
                    data_get(
                        $inventoryCurrent,
                        'manager_register_id'
                    );

                if (empty($managerRegisterId)) {

                    $managerProcess = [
                        'success' => false,
                        'message' =>
                            'No existe registro de inventario para '
                            . data_get(
                                $transform,
                                'name',
                                'el producto'
                            )
                            . '.',
                        'type_error' =>
                            'STOCK_NOT_FOUND',
                    ];
                } /*
                 * Stock insuficiente.
                 */
                elseif (
                    $isIngredientOut &&
                    $quantityBase < 0
                ) {

                    $managerProcess = [
                        'success' => false,

                        'message' =>
                            'Stock insuficiente para '
                            . data_get(
                                $transform,
                                'name',
                                'el producto'
                            )
                            . '. Disponible: '
                            . round(
                                $currentQuantityBase,
                                6
                            )
                            . ', requerido: '
                            . round(
                                $movementQuantityBase,
                                6
                            )
                            . '.',

                        'type_error' =>
                            'INSUFFICIENT_STOCK',
                    ];
                }

                /*
                 * =====================================================
                 * DATA PRODUCT_STOCK
                 * =====================================================
                 */
                $productStock = [

                    'id' =>
                        $managerRegisterId,

                    'product_id' =>
                        (int)$productId,

                    'quantity' =>
                        round(
                            $quantity,
                            6
                        ),

                    'quantity_base' =>
                        round(
                            $quantityBase,
                            6
                        ),

                    'unit_measure_id' =>
                        data_get(
                            $inventoryCurrent,
                            'stock_unit_id'
                        ),
                ];

                return [

                    'product_stock' =>
                        $productStock,

                    'manager_process' =>
                        $managerProcess,
                ];
            })
            ->values();

        /*
         * =============================================================
         * RESULTADO GENERAL DEL PROCESO
         * =============================================================
         */
        $failed =
            $items->first(function ($item) {

                return !data_get(
                    $item,
                    'manager_process.success',
                    false
                );
            });

        $success =
            $failed === null;

        return [

            'success' =>
                $success,

            'message' =>
                $success
                    ? ''
                    : data_get(
                    $failed,
                    'manager_process.message',
                    'No se puede actualizar el inventario.'
                ),

            'data' =>
                $items->toArray(),
        ];
    }

    private function managerRecipeByYield(
        $recipe,
        float $yieldQuantity,
        float $amountYield
    ): array
    {

        if ($yieldQuantity <= 0) {
            throw new \Exception(
                'Recipe yield must be greater than zero.'
            );
        }

        if ($amountYield <= 0) {
            throw new \Exception(
                'Amount yield must be greater than zero.'
            );
        }

        $factor = $amountYield / $yieldQuantity;

        return collect($recipe)
            ->map(function ($item) use ($factor) {
                $product_id = $item->product_id;
                $inventoryCurrent = $this->repo->getProductWithStock($product_id);
                $amountConversion = "";
                $inputAmount = round(
                    (float)$item->quantity_input * $factor,
                    6
                );
                $symbolInput = $item->um_base_input_symbol;
                $symbolBase = $item->um_base_symbol;
                $from = $inputAmount . "" . $symbolInput;
                $to = $symbolBase;

                $conversionData = $this->measureResolverService->resolveSymbolConversion($from, $to);
                $amountBase = -1;

                if ($conversionData["success"]) {
                    $amountBase = $conversionData["data"]["output"]["quantity"];
                }
                $transform = [
                    'name' => $item->name,
                    'recipe_id' => $item->id,
                    "product_measure_type_name" => $item->product_measure_type_name,
                    "input_manager" => [
                        "id" => $item->um_base_input_id,
                        "name" => $item->um_base_input_name,
                        "factor_to_base" => $item->um_base_input_factor_to_base,
                        'amount' => $inputAmount,
                        'symbol' => $symbolInput
                    ],
                    "base_manager" => [
                        "conversion" => $conversionData,
                        "id" => $item->um_base_id,
                        "name" => $item->um_base_name,
                        "factor_to_base" => $item->um_base_factor_to_base,
                        'amount' => $amountBase,
                        'symbol' => $symbolBase
                    ],
                    "um_base_input_id" => $item->um_base_input_id,
                    "um_base_input_name" => $item->um_base_input_name,
                    "um_base_input_factor_to_base" => $item->um_base_input_factor_to_base,
                    "um_base_id" => $item->um_base_id,
                    "um_base_name" => $item->um_base_name,
                    "um_base_quantity" => $item->um_base_quantity,
                    'product_id' => $item->product_id,
                    'parent_product_id' => $item->parent_product_id,
                    'quantity_input' =>
                        (float)$item->quantity_input,
                    'quantity_base' =>
                        (float)$item->quantity_base,
                    'unit_input_id' =>
                        $item->unit_input_id,
                    'base_unit_measure_id' =>
                        $item->base_unit_measure_id,
                    'yield_factor' =>
                        round($factor, 6),
                    'calculated_quantity_input' =>
                        round(
                            (float)$item->quantity_input * $factor,
                            6
                        ),

                    'calculated_quantity_base' =>
                        round(
                            (float)$item->quantity_base * $factor,
                            6
                        )];
                return [
                    "transform" => $transform,
                    "data" => $item,
                    "inventoryCurrent" => $inventoryCurrent,

                ];
            })
            ->values()
            ->toArray();
    }

    private function buildRecipeInventoryMovementData(
        array $dataRecipeManager,
        int   $typeMovement,
        array $options = []
    ): array
    {

        $movementType =
            $typeMovement === 1
                ? 'OUT'
                : 'IN';

        /*
         * Valores por defecto del proceso.
         * Si vienen dentro de $options, se reemplazan.
         */
        $referenceType =
            $options['reference_type']
            ?? 'INVENTORY_RECIPE_MOVEMENT';

        $description =
            $options['description']
            ?? (
        $typeMovement === 1
            ? 'Salida de inventario por consumo de receta'
            : 'Entrada de inventario por reverso de receta'
        );

        return collect($dataRecipeManager)
            ->map(function ($item) use (
                $movementType,
                $referenceType,
                $description,
                $options
            ) {

                $transform =
                    data_get($item, 'transform', []);
                $input_manager = $transform["input_manager"];
                $base_manager = $transform["base_manager"];

                return [

                    'product_id' =>
                        $transform['product_id'],

                    'movement_type' =>
                        $movementType,
                    /*
                     * Cantidad final calculada
                     * en unidad base.
                     */
                    'unit_measure_id' => $base_manager['id'],
                    'quantity' => $base_manager['amount'],
                    /*
                     * Cantidad final calculada
                     * en unidad de entrada.
                     */
                    'unit_input_id' => $input_manager['id'],
                    'quantity_input' => $input_manager['amount'],
                    'conversion_factor' => $input_manager['factor_to_base'],

                    /*
                     * Referencia general del proceso.
                     */
                    'reference_type' =>
                        $referenceType,

                    /*
                     * Si el proceso manda reference_id,
                     * usamos ese.
                     *
                     * Caso contrario usamos recipe_id.
                     */
                    'reference_id' =>
                        $options['reference_id']
                        ?? $transform['recipe_id'],

                    'description' =>
                        $description,
                ];
            })
            ->values()
            ->toArray();
    }
    public function getDataProductMovement(
        array $params
    ): array {

        DB::beginTransaction();

        try {

            /**
             * =====================================================
             * 1. DATOS PRINCIPALES
             * =====================================================
             */
            $productId =
                (int)($params['product_id'] ?? 0);

            $typeMovement =
                (int)($params['type_movement'] ?? 0);

            $amount =
                (float)($params['amount'] ?? 0);

            $unitMeasureId =
                (int)($params['unit_measure_id'] ?? 0);

            $product =
                $this->repo->getProductById(
                    $productId
                );

            if (!$product) {

                throw new \Exception(
                    'No existe el producto solicitado.'
                );
            }

            $productManager = [];

            $utilSaveMovement =
                new InventoryRecipeProcessManager();

            /**
             * =====================================================
             * 2. UNIDAD DE ENTRADA
             * =====================================================
             */
            $modelMeasure =
                new UnitMeasure();

            $dataMeasure =
                $modelMeasure->findByAttribute(
                    'id',
                    $unitMeasureId
                );

            if (!$dataMeasure) {

                throw new \Exception(
                    'No existe la unidad de medida seleccionada.'
                );
            }

            /**
             * =====================================================
             * 3. STOCK ACTUAL PRODUCTO PADRE
             * =====================================================
             */
            $measureBase =
                $this->repo->getProductWithStock(
                    $productId
                );

            if (!$measureBase) {

                throw new \Exception(
                    'No existe información de stock para el producto.'
                );
            }

            /**
             * =====================================================
             * 4. CONVERSIÓN A UNIDAD BASE
             * =====================================================
             */
            $symbolInput =
                $dataMeasure->symbol;

            $symbolBase =
                $measureBase->symbol;

            $conversionFactor =
                (float)$dataMeasure->factor_to_base;

            $unitBaseMeasureId =
                (int)$measureBase->base_unit_id;

            $from =
                $amount . $symbolInput;

            $to =
                $symbolBase;

            $conversionData =
                $this->measureResolverService
                    ->resolveSymbolConversion(
                        $from,
                        $to
                    );

            if (
                !($conversionData['success'] ?? false)
            ) {

                throw new \Exception(
                    $conversionData['message']
                    ?? 'No se pudo realizar la conversión de unidades.'
                );
            }

            $amountBase =
                (float)data_get(
                    $conversionData,
                    'data.output.quantity',
                    0
                );

            /**
             * =====================================================
             * 5. PREPARAR PRODUCTO PADRE
             * =====================================================
             */
            $parentProductManager =
                $utilSaveMovement
                    ->buildParentProductStockData(
                        $product,
                        $measureBase,
                        $amount,
                        $unitMeasureId,
                        $amountBase,
                        $unitBaseMeasureId,
                        $conversionFactor,
                        $typeMovement
                    );

            if (
                !($parentProductManager['success'] ?? false)
            ) {

                throw new \Exception(
                    $parentProductManager['message']
                    ?? 'No se puede procesar el inventario del producto.'
                );
            }

            $productManager[
            'parentProductManager'
            ] = $parentProductManager;

            /**
             * =====================================================
             * 6. GUARDAR STOCK + MOVIMIENTO DEL PADRE
             * =====================================================
             */
            $payloadSave =
                $parentProductManager['data']
                ?? [];

            $managerProductMovement =
                $utilSaveMovement
                    ->executeProductMovement(
                        $payloadSave
                    );

            $productManager[
            'parentProductSave'
            ] = $managerProductMovement;

            if (
                !($managerProductMovement['success'] ?? false)
            ) {

                throw new \Exception(
                    $managerProductMovement['msj']
                    ?? 'No se pudo guardar el movimiento del producto.'
                );
            }

            /**
             * =====================================================
             * 7. PROCESAR SEGÚN INVENTORY TYPE
             * =====================================================
             */
            switch ($product->inventory_type) {

                case 'FOR_SALE':
                case 'PROCESSED':

                    /**
                     * =============================================
                     * 7.1 OBTENER RENDIMIENTO
                     * =============================================
                     */
                    $modelYield =
                        ProductRecipeYield::findByProductId(
                            $productId
                        );

                    if (!$modelYield) {

                        throw new \Exception(
                            'No existe configuración de rendimiento para el producto.'
                        );
                    }

                    $amountYield =
                        (float)($params['amount_yield'] ?? 0);

                    $yieldQuantity =
                        (float)$modelYield->yield_quantity;

                    /**
                     * =============================================
                     * 7.2 OBTENER RECETA
                     * =============================================
                     */
                    $recipe =
                        $this->repo->getRecipe(
                            $productId
                        );

                    if (
                        !$recipe ||
                        $recipe->isEmpty()
                    ) {

                        throw new \Exception(
                            'El producto no tiene componentes de receta configurados.'
                        );
                    }

                    $productManager['isRecipe'] =
                        true;

                    $productManager['dataYield'] =
                        $modelYield->toArray();

                    $productManager['dataRecipe'] =
                        $recipe;

                    /**
                     * =============================================
                     * 7.3 CALCULAR RECETA
                     * =============================================
                     */
                    $dataRecipeManager =
                        $this->managerRecipeByYield(
                            $recipe,
                            $yieldQuantity,
                            $amountYield
                        );

                    $productManager[
                    'dataRecipeManager'
                    ] = $dataRecipeManager;

                    /**
                     * =============================================
                     * 7.4 MOVIMIENTOS DE INGREDIENTES
                     * =============================================
                     */
                    $inventoryMovementData =
                        $this->buildRecipeInventoryMovementData(
                            $dataRecipeManager,
                            $typeMovement
                        );

                    $productManager[
                    'buildRecipeInventoryMovementData'
                    ] = $inventoryMovementData;

                    /**
                     * =============================================
                     * 7.5 STOCK DE INGREDIENTES
                     * =============================================
                     */
                    $recipeProductStockData =
                        $this->buildRecipeProductStockData(
                            $dataRecipeManager,
                            $typeMovement
                        );

                    $productManager[
                    'recipeProductStockData'
                    ] = $recipeProductStockData;

                    $productManager[
                    'measure_base'
                    ] = $measureBase;

                    /**
                     * =============================================
                     * 7.6 GUARDAR INGREDIENTES
                     * =============================================
                     */
                    if (
                        $product->inventory_type ===
                        'PROCESSED'
                    ) {

                        $inventoryProcess =
                            $utilSaveMovement
                                ->execute(
                                    $recipeProductStockData,
                                    $inventoryMovementData
                                );

                        $productManager[
                        'manager_save'
                        ] = $inventoryProcess;

                        if (
                            !($inventoryProcess['success'] ?? false)
                        ) {

                            throw new \Exception(
                                $inventoryProcess['msj']
                                ?? 'No se pudo procesar el inventario de la receta.'
                            );
                        }
                    }

                    break;

                case 'RAW':
                case 'UNIT':

                    $productManager['isRecipe'] =
                        false;

                    $productManager[
                    'measure_base'
                    ] = $measureBase;

                    break;

                default:

                    throw new \Exception(
                        'Tipo de inventario no soportado: '
                        . $product->inventory_type
                    );
            }

            /**
             * =====================================================
             * 8. TODO CORRECTO
             * =====================================================
             */
            DB::commit();

            return [
                'success' =>
                    true,

                'data' => [

                    'product' =>
                        $product,

                    'productManager' =>
                        $productManager,
                ],

                'msj' =>
                    'Movimiento de inventario procesado correctamente.'
            ];

        } catch (Throwable $e) {

            /**
             * =====================================================
             * ERROR EN CUALQUIER PUNTO = REVERTIR TODO
             * =====================================================
             */
            DB::rollBack();

            return [
                'success' =>
                    false,

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
    public function getDataProductMovement2($params)
    {
        $product_id = $params['product_id'];
        $product = $this->repo->getProductById($product_id);

        $utilSaveMovement = new InventoryRecipeProcessManager();
        $type_movement = $params['type_movement'];
        $amount = $params['amount'];
        $unit_measure_id = $params['unit_measure_id'];
        $modelMeasure = new UnitMeasure();
        $dataMeasure = $modelMeasure->findByAttribute(
            "id", $unit_measure_id
        );
        $measure_base = $this->repo->getProductWithStock($product_id);
        $symbolInput = $dataMeasure->symbol;
        $conversion_factor = $dataMeasure->factor_to_base;
        $unit_base_measure_id = $measure_base->base_unit_id;
        $inputAmount = $amount;
        $symbolBase = $measure_base->symbol;
        $from = $inputAmount . "" . $symbolInput;
        $to = $symbolBase;
        $conversionData = $this->measureResolverService->resolveSymbolConversion($from, $to);
        $amountBase = -1;
        if ($conversionData['success']) {
            $amountBase = $conversionData["data"]["output"]["quantity"];
        }
        $parentProductManager =
            $utilSaveMovement->buildParentProductStockData(
                $product,
                $measure_base,
                (float)$amount,
                $unit_measure_id,
                $amountBase,
                $unit_base_measure_id,
                $conversion_factor,
                (int)$type_movement

            );
        $payloadSave = $parentProductManager["data"];
        $managerProductMovement = $utilSaveMovement->executeProductMovement($payloadSave);
        $productManager['parentProductManager'] = $parentProductManager;
        $productManager = null;
        $allowSave = false;
        $message = "";
        if ($managerProductMovement['success']) {
            $allowSave = true;
            switch ($product->inventory_type) {
                case 'FOR_SALE'://MENU
                case 'PROCESSED':
                    $modelYield =
                        ProductRecipeYield::findByProductId(
                            $product_id
                        );
                    $amountYield = $params['amount_yield'];
                    $yieldQuantity = $modelYield->yield_quantity;
                    $recipe = $this->repo->getRecipe($product_id);
                    $productManager["isRecipe"] = true;
                    $productManager["dataYield"] = $modelYield->toArray();;
                    $productManager["dataRecipe"] = $recipe;
                    $dataRecipeManager = $this->managerRecipeByYield(
                        $recipe,
                        $yieldQuantity,
                        $amountYield);
                    $buildRecipeInventoryMovementData = $this->buildRecipeInventoryMovementData($dataRecipeManager,
                        $type_movement);
                    $productManager["dataRecipeManager"] = $dataRecipeManager;
                    $productManager["buildRecipeInventoryMovementData"] = $buildRecipeInventoryMovementData;
                    $recipeProductStockData = $this->buildRecipeProductStockData($dataRecipeManager,
                        $type_movement);
                    $productManager["recipeProductStockData"] = $recipeProductStockData;
                    $productManager["measure_base"] = $measure_base;
                    if ($product->inventory_type == "PROCESSED") {
                        $inventoryProcess =
                            $utilSaveMovement
                                ->execute(
                                    $recipeProductStockData,
                                    $buildRecipeInventoryMovementData
                                );
                        $productManager["manager_save"] = $inventoryProcess;
                        if (!$inventoryProcess["success"]) {
                            $allowSave = false;
                            $message=$inventoryProcess["msj"];
                            //GENERAR TRY
                        }else{
                            $allowSave = true;
                        }
                    }
                    break;
                case 'RAW':
                case 'UNIT':

                    break;
            }


        }else{
            $allowSave = false;
            $message=$managerProductMovement["msj"];
            //GENERAR TRY
        }
        $data = [
            'product' => $product,
            'productManager' => $productManager

        ];


        $result = [
            'success' =>$allowSave,
            "data" => $data,
            "msj"=>$message
        ];
        return $result;
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
                $movement["quantity"] = $amount;
                $movement["unit_measure_id"] = $conversion["um_base_input_id"];
                $movement["quantity_input"] = $quantityInput;
                $movement["unit_input_id"] = $stock["unit_id"];
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
                    []
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
