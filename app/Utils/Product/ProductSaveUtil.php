<?php

namespace App\Utils\Product;

use App\Models\BusinessByProduct;
use App\Models\ProductByStock;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\InvoiceSales\InventoryMovement;
use App\Models\ProductInventory;
use App\Models\Products\Product;
use App\Models\Products\ProductRecipe;
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
    private const REFERENCE_TYPE_OUT = 'INVENTARIO_DISCOUNT_BY_CREATE';

    private const DESCRIPTION = 'Carga inicial';
    private const DESCRIPTION_OUT = 'Descuento por Registro de Receta by';

    private array $saveLog = [];

    private function addLog(
        string $key,
        mixed  $data
    ): void
    {
        $this->saveLog[$key] = $data;
    }
    public function setSubCategoryByBusinessSave(array $payload): array
    {
        DB::beginTransaction();
        try {
            $keyCurrentManagement = "product_category";
            $modelSubCategory = $this->saveSubCategoryByBusiness(
                $payload[$keyCurrentManagement]
            );
            $this->saveSourceByEntity([
                'payload' => $payload,
                'modelCurrent' => $modelSubCategory,
                'folderSaveSource' => "product-subcategory",
                'keyManagement' => 'product_subcategory_image'
            ]);
            $this->addLog(
                $keyCurrentManagement,
                $modelSubCategory->toArray()
            );
            DB::commit();
            return [
                'success' => true,
                'step' => 'FINISH',
                'saved' => $this->saveLog
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'success' => false,
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
    public function setSubCategoryByBusinessUpdate(array $payload): array
    {
        DB::beginTransaction();
        try {
            $keyCurrentManagement = "product_subcategory";
            $modelSubCategory = $this->saveSubCategoryByBusiness(
                $payload[$keyCurrentManagement]
            );
            $this->saveSourceByEntity([
                'payload' => $payload,
                'modelCurrent' => $modelSubCategory,
                'folderSaveSource' => "product-subcategory",
                'keyManagement' => 'product_subcategory_image'
            ]);
            $this->addLog(
                $keyCurrentManagement,
                $modelSubCategory->toArray()
            );
            DB::commit();
            return [
                'success' => true,
                'step' => 'FINISH',
                'saved' => $this->saveLog
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'success' => false,
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
    public function setCategoryByBusinessSave(array $payload): array
    {
        DB::beginTransaction();
        try {
            $keyCurrentManagement = "product_category";
            $modelCategory = $this->saveCategoryByBusiness(
                $payload[$keyCurrentManagement]
            );
            $this->saveSourceByEntity([
                'payload' => $payload,
                'modelCurrent' => $modelCategory,
                'folderSaveSource' => "product-category",
                'keyManagement' => 'product_category_image'
            ]);
            $this->addLog(
                'IMAGE',
                $payload
            );
            $this->addLog(
                $keyCurrentManagement,
                $modelCategory->toArray()
            );
            DB::commit();
            return [
                'success' => true,
                'step' => 'FINISH',
                'saved' => $this->saveLog
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'success' => false,
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
    public function setCategoryByBusinessUpdate(array $payload): array
    {
        DB::beginTransaction();
        try {
            $keyCurrentManagement = "product_category";
            $modelCategory = $this->saveCategoryByBusiness(
                $payload[$keyCurrentManagement]
            );
            $this->saveSourceByEntity([
                'payload' => $payload,
                'modelCurrent' => $modelCategory,
                'folderSaveSource' => "product-category",
                'keyManagement' => 'product_category_image'
            ]);
            $this->addLog(
                $keyCurrentManagement,
                $modelCategory->toArray()
            );
            DB::commit();
            return [
                'success' => true,
                'step' => 'FINISH',
                'saved' => $this->saveLog
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'success' => false,
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
    public function setProductTypeSave(array $payload): array
    {
        DB::beginTransaction();

        try {

            $this->validatePayload($payload);
            $productModelSave = $this->saveProductEntity(
                $payload['product']
            );
            $this->saveSourceByEntity([
                'payload' => $payload,
                'modelCurrent' => $productModelSave,
                'folderSaveSource' => "products/",
                'keyManagement' => 'product_image'
            ]);
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


    public function saveFile(
        UploadedFile $file,
        string       $folder,
        string       $type = 'file'
    ): array
    {
        try {

            $basePath = public_path('uploads/' . trim($folder, '/'));

            if (!File::exists($basePath)) {
                File::makeDirectory($basePath, 0755, true);
            }

            // Obtener toda la información ANTES de mover el archivo
            $extension = $file->getClientOriginalExtension();
            $mime = $file->getMimeType();
            $size = $file->getSize();

            $fileName = Str::uuid() . '.' . $extension;

            $file->move($basePath, $fileName);

            return [
                'success' => true,
                'message' => 'Archivo guardado correctamente.',
                'data' => [
                    'name' => $fileName,
                    'extension' => $extension,
                    'mime' => $mime,
                    'size' => $size,
                    'path' => 'uploads/' . trim($folder, '/') . '/' . $fileName,
                    'type' => $type,
                ],
            ];

        } catch (Throwable $e) {

            return [
                'success' => false,
                'message' => 'No fue posible guardar el archivo.',
                'data' => null,
                'error' => [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ],
            ];

        }
    }

    public function saveSourceByEntity($params)
    {
        $payload = $params['payload'];
        $modelCurrent = $params['modelCurrent'];
        $folderSaveSource = $params['folderSaveSource'];
        $keyManagement = $params['keyManagement'];

        if (isset($payload['image'])) {
            $idSource = $modelCurrent->id;
            $result = $this->saveFile(
                $payload['image'],
                $folderSaveSource . "/$idSource",
                "image"
            );
            $this->addLog(
                $keyManagement,
                $result
            );
            if (!$result['success']) {

            } else {
                $imagePath = $result['data']['path'];
                $modelCurrent->source = $imagePath;
                $modelCurrent->save();
            }


        }
    }

    public function setProductTypeUpdate(array $payload): array
    {
        DB::beginTransaction();

        try {


            $this->validatePayload($payload);
            $productModelSave = $this->saveProductEntity(
                $payload['product']
            );
            $this->saveSourceByEntity([
                'payload' => $payload,
                'modelCurrent' => $productModelSave,
                'folderSaveSource' => "products",
                'keyManagement' => 'product_image'
            ]);
            if (isset($payload['image'])) {
                $idProduct = $productModelSave->id;
                $result = $this->saveFile(
                    $payload['image'],
                    "products/$idProduct",
                    "image"
                );
                $this->addLog(
                    'product_image',
                    $result
                );
                if (!$result['success']) {

                } else {
                    $imagePath = $result['data']['path'];
                    $productModelSave->source = $imagePath;
                    $productModelSave->save();
                }


            }
            $this->addLog(
                'product',
                $productModelSave->toArray()
            );

            $this->processInventoryTypeUpdate(
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
        int               $productId,
        InventoryMovement $movement
    ): ProductStock
    {
        $this->currentStep = 'PRODUCT_STOCK';

        $model = new ProductStock();

        $attributes = $model->buildAttributes([
            'product_id' => $productId,
            'quantity' => $movement->quantity,
            'quantity_base' => $movement->quantity,
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
    private function saveCategoryByBusiness(array $data): ProductCategory
    {
        $this->currentStep = 'PRODUCT_CATEGORY';
        $key_process = "product_category";
        $isUpdate = isset($data['id']) && !empty($data['id']);
        $rules = ProductCategory::getRulesModel();
        if ($isUpdate) {
            $model = ProductCategory::find($data['id']);
            $rules = ProductCategory::getRulesModel();
            if (!$model) {
                throw new Exception(
                    json_encode([
                        'table' => $key_process,
                        'errors' => [
                            $this->currentStep . " not found with ID: {$data['id']}"
                        ]
                    ])
                );
            } else {
                $data['source'] = $model->source;
            }
        } else {
            $model = new ProductCategory();
        }
        $attributes = $model->buildAttributes($data);
        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => $rules// opcional
        ]);
        if (!$validate['success']) {
            throw new Exception(json_encode([
                'table' => $key_process,
                'errors' => $validate['errorsFields']
            ]));
        }

        $model->fill($attributes);
        $model->save();
        return $model;
    }
    private function saveSubCategoryByBusiness(array $data): ProductSubCategory
    {
        $this->currentStep = 'PRODUCT_SUBCATEGORY';
        $key_process = "product_subcategory";
        $isUpdate = isset($data['id']) && !empty($data['id']);
        $rules = ProductSubCategory::getRulesModel();
        if ($isUpdate) {
            $model = ProductSubCategory::find($data['id']);
            $rules = ProductSubCategory::getRulesModel();
            if (!$model) {
                throw new Exception(
                    json_encode([
                        'table' => $key_process,
                        'errors' => [
                            $this->currentStep . " not found with ID: {$data['id']}"
                        ]
                    ])
                );
            } else {
                $data['source'] = $model->source;
            }
        } else {
            $model = new ProductSubCategory();
        }
        $attributes = $model->buildAttributes($data);
        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => $rules// opcional
        ]);
        if (!$validate['success']) {
            throw new Exception(json_encode([
                'table' => $key_process,
                'errors' => $validate['errorsFields']
            ]));
        }

        $model->fill($attributes);
        $model->save();
        return $model;
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCT
    |--------------------------------------------------------------------------
    */

    private function saveProductEntity(array $data): Product
    {
        $this->currentStep = 'PRODUCT';

        $isUpdate = isset($data['id']) && !empty($data['id']);
        $rules = Product::getRulesModel();
        if ($isUpdate) {
            $model = Product::find($data['id']);
            $rules = Product::getRulesModel($data['id']);
            if (!$model) {
                throw new Exception(
                    json_encode([
                        'table' => 'product',
                        'errors' => [
                            "Product not found with ID: {$data['id']}"
                        ]
                    ])
                );
            } else {
                $data['source'] = $model->source;
            }
        } else {
            $model = new Product();
        }

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => $rules// opcional
        ]);

        if (!$validate['success']) {
            throw new Exception(json_encode([
                'table' => 'product',
                'errors' => $validate['errorsFields']
            ]));
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
        $this->allManagementProduct($product, $payload);

    }

    private function processForSaleProductUpdate(
        Product $product,
        array   $payload
    ): void
    {
        $this->allManagementProductUpdate($product, $payload);

    }

    private function processProcessedProduct(
        Product $product,
        array   $payload
    ): void
    {
        $this->allManagementProduct($product, $payload);

    }

    private function processProcessedProductUpdate(
        Product $product,
        array   $payload
    ): void
    {
        $this->allManagementProductUpdate($product, $payload);

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

    private function saveBusinessProductByStock(
        int   $productId,
        array $data,
        int   $typeCrud
    ): ProductByStock
    {
        $this->currentStep = 'PRODUCT_BY_STOCK';
        $data['product_id'] = $productId;
        $model = null;
        $isUpdate = !($typeCrud == 0);
        $rules = ProductByStock::getRulesModel();
        if ($isUpdate) {
            $model = ProductByStock::where('product_id', $productId)->first();
            $rules = ProductByStock::getRulesModel();
            if (!$model) {
                $model = new ProductByStock();
            }
        } else {
            $model = new ProductByStock();
        }

        $attributes = $model->buildAttributes($data);
        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => $rules
        ]);

        if (!$validate['success']) {

            throw new Exception(
                json_encode([
                    'table' => $model->getTable(),
                    'errors' => $validate['errorsFields'],
                    'product_id' => $productId
                ])
            );
        }
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    private function allManagementProduct(
        Product $product,
        array   $payload)
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

        $keyManager = 'product_by_stock';
        $stockManager = $this->saveBusinessProductByStock(
            $product->id,
            $payload[$keyManager], 0
        );
        $this->addLog(
            $keyManager,
            $stockManager->toArray()
        );


        $inventory_movement = $payload['inventory_movement'];
        $inventory_movement['movement_type'] = InventoryMovement::TYPE_IN;
        $inventory_movement['reference_type'] = self::REFERENCE_TYPE;
        $inventory_movement['description'] = self::DESCRIPTION;
        $movement = $this->saveInventoryMovement(
            $product->id,
            $inventory_movement
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

    private function allManagementProductUpdate(
        Product $product,
        array   $payload)
    {


        $inventory = $this->saveProductInventoryUpdate(
            $product->id,
            $payload['product_inventory']
        );

        $this->addLog(
            'product_inventory',
            $inventory->toArray()
        );

        $sellConfig = $this->saveProductSellConfigUpdate(
            $product->id,
            $payload['product_sell_config']
        );

        $this->addLog(
            'product_sell_config',
            $sellConfig->toArray()
        );

        $keyManager = 'product_by_stock';
        $stockManager = $this->saveBusinessProductByStock(
            $product->id,
            $payload[$keyManager], 1
        );
        $this->addLog(
            $keyManager,
            $stockManager->toArray()
        );
        $this->addLog(
            $keyManager . "_set",
            $payload[$keyManager]
        );
        if (false) {

            $inventory_movement = $payload['inventory_movement'];
            $inventory_movement['movement_type'] = InventoryMovement::TYPE_IN;
            $inventory_movement['reference_type'] = self::REFERENCE_TYPE;
            $inventory_movement['description'] = self::DESCRIPTION;
            $movement = $this->saveInventoryMovement(
                $product->id,
                $inventory_movement
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


    }

    private function processRawProductUpdate(
        Product $product,
        array   $payload
    ): void
    {
        $this->allManagementProductUpdate($product, $payload);
    }

    private function processRawProduct(
        Product $product,
        array   $payload
    ): void
    {
        $this->allManagementProduct($product, $payload);
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

    private function processInventoryTypeUpdate(
        Product $product,
        array   $payload
    ): void
    {
        $inventoryType = $product->inventory_type;

        match ($inventoryType) {

            ProductClassification::INVENTORY_RAW
            => $this->processRawProductUpdate(
                $product,
                $payload
            ),

            ProductClassification::INVENTORY_PROCESSED
            => $this->processProcessedProductUpdate(
                $product,
                $payload
            ),
            ProductClassification::INVENTORY_FOR_SALE
            => $this->processForSaleProductUpdate(
                $product,
                $payload
            ),
            default
            => throw new Exception(
                "Inventory type {$inventoryType} no soportado"
            )
        };
    }

    private function saveProductInventoryUpdate(
        int   $productId,
        array $data
    ): ProductInventory
    {
        $this->currentStep = 'PRODUCT_INVENTORY';
        $data['product_id'] = $productId;
        $model = ProductInventory::where('product_id', $productId)->first();

        if (!$model) {
            $model = new ProductInventory();
        }

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => ProductInventory::getRulesModel()
        ]);

        if (!$validate['success']) {
            throw new Exception(json_encode([
                'table' => 'product_inventory',
                'errors' => $validate['errorsFields']
            ]));
        }

        $model->fill($attributes);
        $model->save();

        return $model;
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

    private function saveProductSellConfigUpdate(
        int   $productId,
        array $data
    ): ProductSellConfig
    {
        $this->currentStep = 'PRODUCT_SELL_CONFIG';

        $model = ProductSellConfig::where('product_id', $productId)->first();
        $data['product_id'] = $productId;

        if (!$model) {
            $model = new ProductSellConfig();
        }

        $attributes = $model->buildAttributes($data);

        $validate = $model->validateModel([
            'modelAttributes' => $attributes,
            'rules' => ProductSellConfig::getRulesModel()
        ]);

        if (!$validate['success']) {
            throw new Exception(json_encode([
                'table' => 'product_sell_config',
                'errors' => $validate['errorsFields']
            ]));
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

        } else {
            $model->fill($attributes);
            $model->save();
        }


        return $model;
    }


    private function saveRecipeProduct(
        array $data
    ): array
    {
        $this->currentStep = 'PRODUCT_RECIPE';

        try {
            $model = new ProductRecipe();

            $attributes = $model->buildAttributes($data);

            $validation = $model->validateModel([
                'modelAttributes' => $attributes,
                'rules' => ProductRecipe::getRulesModel()
            ]);

            if (!$validation['success']) {
                return [
                    'success' => false,
                    'errors' => [
                        'table' => $model->getTable(),
                        'fields' => $validation['errorsFields']
                    ],
                    'model' => null
                ];
            }

            $model->fill($attributes);

            return [
                'success' => true,
                'errors' => [],
                'model' => $model
            ];

        } catch (Exception $e) {

            return [
                'success' => false,
                'errors' => [
                    'message' => $e->getMessage(),
                    'step' => $this->currentStep
                ],
                'model' => null
            ];
        }
    }

    public function setProductItemRecipeSave(array $payload): array
    {
        DB::beginTransaction();

        $this->currentStep = 'START';


        try {

            $product_id = $payload['product_id'];
            $component_product_id = $payload['component_product_id'];

            $inventory_type = 9;
            /**
             * 1. Guardar receta producto
             */
            $productRecipeSave = $this->saveRecipeProduct(
                $payload
            );


            if (!$productRecipeSave['success']) {

                throw new Exception(
                    json_encode([
                        'step' => 'PRODUCT_RECIPE',
                        'error' => $productRecipeSave['errors']
                    ])
                );

            }

            $this->addLog(
                'product_recipe',
                $productRecipeSave['model']->toArray()
            );

            /**
             * 2. Guardar movimiento inventario
             */
            if (false) {

                $inventory_movement = $payload['inventory_movement'];
                $inventory_movement['movement_type'] = InventoryMovement::TYPE_OUT;
                $inventory_movement['reference_type'] = self::REFERENCE_TYPE_OUT;
                $inventory_movement['description'] = self::DESCRIPTION_OUT . " : " . $inventory_type;
                $movement = $this->saveInventoryMovement(
                    $product_id,
                    $inventory_movement
                );
                $this->addLog(
                    'inventory_movement',
                    $movement->toArray()
                );
            }

            DB::commit();

            return [
                'success' => true,
                'inventory_type' => $inventory_type,
                'step' => 'FINISH',
                'saved' => $this->saveLog,
                'msj' => 'Agregado Item Correctamente.!'
            ];

        } catch (Throwable $e) {


            DB::rollBack();


            return [
                'success' => false,
                'inventory_type' => $inventory_type,
                'step' => $this->currentStep,

                'saved_until_error' => $this->saveLog,
                'msj' => $e->getMessage(),
                'error' => [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ];
        }
    }


}
