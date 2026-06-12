<?php

namespace App\Utils\Product;

use App\Models\BusinessByProduct;

use App\Models\InvoiceSales\InventoryMovement;
use App\Models\ProductInventory;
use App\Models\Products\Product;
use App\Models\Products\ProductSellConfig;
use App\Models\Products\ProductStock;
use App\Modules\PointSales\Constants\ProductClassification;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;

class ProductSaveUtil
{
    private string $currentStep = 'INIT';

    private const PRODUCT_STATE = 'ACTIVE';
    private const INVENTORY_TYPE = 'RAW';

    private const ALLOW_POS = 1;
    private const ALLOW_SHOP = 1;
    private const ALLOW_DELIVERY = 0;
    private const VISIBLE = 1;
    private const REFERENCE_TYPE = 'INVENTARIO_INICIAL';
    private const DESCRIPTION = 'Carga inicial';
    private array $saveLog = [];

    private function addLog(
        string $key,
        mixed  $data
    ): void
    {
        $this->saveLog[$key] = $data;
    }

    public function setProductTypeSave(array $payload): array
    {
        DB::beginTransaction();

        try {

            $this->validatePayload($payload);

            $productModelSave = $this->saveProductEntity(
                $payload['product']
            );

            $this->addLog(
                'product',
                $productModelSave->toArray()
            );

            $this->processInventoryType(
                $productModelSave,
                $payload
            );

            DB::commit();

            return [
                'success' => true,
                'inventory_type' => $productModelSave->inventory_type,
                'step' => 'FINISH',
                'saved' => $this->saveLog
            ];

        } catch (Throwable $e) {

            DB::rollBack();

            return [
                'success' => false,
                'inventory_type' => $payload['product']['inventory_type'] ?? null,
                'step' => $this->currentStep,
                'saved_until_error' => $this->saveLog,
                'error' => [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ];
        }
    }
    private function saveProductStock(
        int $productId,
        InventoryMovement $movement
    ): ProductStock
    {
        $this->currentStep = 'PRODUCT_STOCK';

        $model = new ProductStock();

        $attributes = $model->buildAttributes([
            'product_id'      => $productId,
            'quantity'        => $movement->quantity,
            'quantity_base'   => $movement->quantity,
            'unit_measure_id' => $movement->unit_measure_id,
        ]);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => ProductStock::getRulesModel()
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => 'product_stock',
                    'errors' => $validate['errorsFields']
                ])
            );
        }

        $model->fill($attributes);

        $model->save();

        return $model;
    }
    /*
    |--------------------------------------------------------------------------
    | VALIDATE ROOT PAYLOAD
    |--------------------------------------------------------------------------
    */

    private function validatePayload(array $payload): void
    {
        $requiredSections = [
            'product',
            'business_by_products',
            'product_inventory',
            'product_sell_config',
            'inventory_movement'
           // ,'product_stock'
        ];

        foreach ($requiredSections as $section) {

            if (!isset($payload[$section])) {

                throw new Exception(
                    "No existe la sección {$section}"
                );
            }

            if (!is_array($payload[$section])) {

                throw new Exception(
                    "La sección {$section} debe ser array"
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT
    |--------------------------------------------------------------------------
    */

    private function saveProductEntity(array $data): Product
    {
        $this->currentStep = 'PRODUCT';

        $data['state'] = self::PRODUCT_STATE;


        $model = new Product();

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => Product::getRulesModel()
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => 'product',
                    'errors' => $validate['errorsFields']
                ])
            );
        }

        $model->fill($attributes);

        $model->save();

        return $model;
    }

    private function processForSaleProduct(
        Product $product,
        array   $payload
    ): void
    {
        $business = $this->saveBusinessProduct(
            $product->id,
            $payload['business_by_products']
        );

        $this->addLog(
            'business_by_products',
            $business->toArray()
        );

        $inventory = $this->saveProductInventory(
            $product->id,
            $payload['product_inventory']
        );

        $this->addLog(
            'product_inventory',
            $inventory->toArray()
        );

        $sellConfig = $this->saveProductSellConfig(
            $product->id,
            $payload['product_sell_config']
        );

        $this->addLog(
            'product_sell_config',
            $sellConfig->toArray()
        );
    }

    private function processProcessedProduct(
        Product $product,
        array   $payload
    ): void
    {
        $business = $this->saveBusinessProduct(
            $product->id,
            $payload['business_by_products']
        );

        $this->addLog(
            'business_by_products',
            $business->toArray()
        );

        $inventory = $this->saveProductInventory(
            $product->id,
            $payload['product_inventory']
        );

        $this->addLog(
            'product_inventory',
            $inventory->toArray()
        );

        $sellConfig = $this->saveProductSellConfig(
            $product->id,
            $payload['product_sell_config']
        );

        $this->addLog(
            'product_sell_config',
            $sellConfig->toArray()
        );

        /*
        recipe
        */
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS_BY_PRODUCTS
    |--------------------------------------------------------------------------
    */

    private function saveBusinessProduct(
        int   $productId,
        array $data
    ): BusinessByProduct
    {
        $this->currentStep = 'BUSINESS_BY_PRODUCTS';
        $data['products_id'] = $productId;
        $model = new BusinessByProduct();
        $attributes = $model->buildAttributes($data);
        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => BusinessByProduct::getRulesModel()
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => 'business_by_products',
                    'errors' => $validate['errorsFields']
                ])
            );
        }

        $model->fill($attributes);

        $model->save();

        return $model;
    }

    private function processRawProduct(
        Product $product,
        array   $payload
    ): void
    {
        $business = $this->saveBusinessProduct(
            $product->id,
            $payload['business_by_products']
        );

        $this->addLog(
            'business_by_products',
            $business->toArray()
        );

        $inventory = $this->saveProductInventory(
            $product->id,
            $payload['product_inventory']
        );

        $this->addLog(
            'product_inventory',
            $inventory->toArray()
        );

        $sellConfig = $this->saveProductSellConfig(
            $product->id,
            $payload['product_sell_config']
        );

        $this->addLog(
            'product_sell_config',
            $sellConfig->toArray()
        );

        $movement = $this->saveInventoryMovement(
            $product->id,
            $payload['inventory_movement']
        );

        $this->addLog(
            'inventory_movement',
            $movement->toArray()
        );

        $productStock = $this->saveProductStock(
            $product->id,
            $movement
        );

        $this->addLog(
            'product_stock',
            $productStock->toArray()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT_INVENTORY
    |--------------------------------------------------------------------------
    */
    private function processInventoryType(
        Product $product,
        array   $payload
    ): void
    {
        $inventoryType = $product->inventory_type;

        match ($inventoryType) {

            ProductClassification::INVENTORY_RAW
            => $this->processRawProduct(
                $product,
                $payload
            ),

            ProductClassification::INVENTORY_PROCESSED
            => $this->processProcessedProduct(
                $product,
                $payload
            ),
            ProductClassification::INVENTORY_FOR_SALE
            => $this->processForSaleProduct(
                $product,
                $payload
            ),
            default
            => throw new Exception(
                "Inventory type {$inventoryType} no soportado"
            )
        };
    }

    private function saveProductInventory(
        int   $productId,
        array $data
    ): ProductInventory
    {
        $this->currentStep = 'PRODUCT_INVENTORY';

        $data['product_id'] = $productId;

        $model = new ProductInventory();

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => ProductInventory::getRulesModel()
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => 'product_inventory',
                    'errors' => $validate['errorsFields']
                ])
            );
        }

        $model->fill($attributes);

        $model->save();

        return $model;
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT_SELL_CONFIG
    |--------------------------------------------------------------------------
    */

    private function saveProductSellConfig(
        int   $productId,
        array $data
    ): ProductSellConfig
    {
        $this->currentStep = 'PRODUCT_SELL_CONFIG';

        $data['product_id'] = $productId;

        $data['allow_pos'] = self::ALLOW_POS;
        $data['allow_shop'] = self::ALLOW_SHOP;
        $data['allow_delivery'] = self::ALLOW_DELIVERY;
        $data['visible'] = self::VISIBLE;

        $model = new ProductSellConfig();

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => ProductSellConfig::getRulesModel()
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => 'product_sell_config',
                    'errors' => $validate['errorsFields']
                ])
            );
        }

        $model->fill($attributes);

        $model->save();

        return $model;
    }

    /*
    |--------------------------------------------------------------------------
    | INVENTORY_MOVEMENT
    |--------------------------------------------------------------------------
    */

    private function saveInventoryMovement(
        int   $productId,
        array $data
    ): InventoryMovement
    {
        $this->currentStep = 'INVENTORY_MOVEMENT';

        $data['product_id'] = $productId;

        $data['movement_type'] = InventoryMovement::TYPE_IN;
        $data['reference_type'] = self::REFERENCE_TYPE;
        $data['description'] = self::DESCRIPTION;

        $model = new InventoryMovement();

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => InventoryMovement::getRulesModel()
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => 'inventory_movement',
                    'errors' => $validate['errorsFields']
                ])
            );
        }

        $model->fill($attributes);

        $model->save();

        return $model;
    }
}
