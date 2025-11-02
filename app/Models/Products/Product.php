<?php

namespace App\Models\Products;

use App\Models\BusinessByDiscounts;
use App\Models\BusinessByProduct;
use App\Models\Exception;
use App\Models\ModelManager;
use App\Models\Multimedia;
use App\Models\ProductByColor;
use App\Models\ProductByDetails;
use App\Models\ProductByMultimedia;
use App\Models\ProductBySizes;
use App\Models\ProductDetailsShippingFee;
use App\Models\ProductDistributions\ProductByMetaData;
use App\Models\ProductDistributions\ProductParent;
use App\Models\ProductDistributions\ProductParentByProduct;
use App\Models\ProductInventory;
use Auth;
use Illuminate\Support\Facades\DB;

//Variants


class Product extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const VIEW_ONLINE = 1;

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product';

    protected $fillable = array(
        'code',//*
        'name',//*
        'state',//*
        'product_trademark_id',//*
        'product_category_id',//*
        'product_subcategory_id',//*
        'source',
        'description',
        'code_provider',
        'code_product',
        'has_tax',//*
        'is_service',//*
        'user_id',//*
        'product_measure_type_id',//*
        'view_online',//*

    );
    protected $attributesData = [
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'product_trademark_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_category_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_subcategory_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'code_provider', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'code_product', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'has_tax', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'is_service', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'view_online', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_measure_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'name';

    function generateStructureCode($codigo, $numero, $maxLength = 20)
    {
        // Longitud máxima permitida, incluyendo el código y el padding del número


        // Longitud del código
        $codeLength = strlen($codigo);

        // Longitud máxima permitida para el número, incluyendo el padding
        $numberMaxLength = $maxLength - $codeLength;

        // Convertir el número a una cadena de dígitos
        $numeroStr = (string)$numero;

        // Si el número es demasiado grande para el padding, ajustar
        if ($numero > str_repeat(9, $numberMaxLength)) {
            $numeroStr = (string)(int)substr(str_repeat(9, $numberMaxLength), 1) + 1;
        }

        // Agregar ceros antes del número
        $paddedNumber = str_pad($numeroStr, $numberMaxLength, "0", STR_PAD_LEFT);

        // Combinar el código y el número
        $result = $codigo . $paddedNumber;

        return $result;
    }

    public function saveDataByParent($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $modelName = 'Product';
            $model = new Product();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            $modelInventory = null;
            $product_details_shipping_fee_id = $attributesPost["product_details_shipping_fee_id"];
            $product_by_details_id = $attributesPost["product_by_details_id"];
            $product_by_meta_data_id = $attributesPost["product_by_meta_data_id"];
            $product_parent_by_product_id = $attributesPost["product_parent_by_product_id"];
            $business_by_products_id = $attributesPost["business_by_products_id"];
            $product_inventory_id = $attributesPost["product_inventory_id"];
            $isCreateProduct = true;
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = Product::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source;
                $modelInventory = ProductInventory::find($product_inventory_id);
                $isCreateProduct = false;
                $isCreateInventory = false;

            } else {
                $createUpdate = true;
                $modelInventory = new   ProductInventory();
                $isCreateProduct = true;
                $isCreateInventory = true;

            }
            $user = Auth::user();

            $productData = $attributesPost;
            $source = $productData["source"];
            $pathSet = "/uploads/products/product";
            $change = $productData["change"];
            $allowImage = false;
            if ($allowImage) {


                $successMultimediaModel = $modelMultimedia->managerUploadModel(
                    array(
                        'createUpdate' => $createUpdate,
                        'source' => $source,
                        'pathSet' => $pathSet,
                        'change' => $change,
                        'auxResource' => $auxResource
                    )
                );
                $successMultimedia = $successMultimediaModel['success'];
            } else {
                $successMultimedia = true;

            }

            if ($successMultimedia) {

                $source = $allowImage ? $successMultimediaModel['sourceServer'] : 'none';
                $productData['source'] = $source;
                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productData, 'attributesData' => $this->attributesData));
                $attributesSet['user_id'] = $user->id;
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                $business_id = $attributesPost['business_id'];
                $tax_id = $attributesPost['tax_id'];
                $has_tax = $attributesPost['has_tax'];
                $sale_price = $attributesPost['sale_price'];
                $quantity_units = isset($attributesPost['quantity_units']) ? $attributesPost['quantity_units'] : 0;
                $description = $attributesPost['description'];
                $location_details = isset($attributesPost['location_details']) ? $attributesPost['location_details'] : "";
                $stock_control = isset($attributesPost['stock_control']) ? $attributesPost['stock_control'] : 0;
                $ice_control = isset($attributesPost['ice_control']) ? $attributesPost['ice_control'] : 0;
                $initial_stock_control = isset($attributesPost['initial_stock_control']) ? $attributesPost['initial_stock_control'] : 0;

                if ($success) {
                    $model->fill($attributesSet);

                    $success = $model->save();
                    $product_id = $model->id;


                    $isCreateCurrent = false;
                    $isCreateInventory = false;
                    if ($business_by_products_id == 'null' || $business_by_products_id == null || $business_by_products_id == 'undefined') {
                        $modelBBP = new BusinessByProduct();
                        $isCreateCurrent = true;

                    } else {
                        $modelBBP = BusinessByProduct::find($business_by_products_id);
                        $isCreateCurrent = false;

                    }


                    $modelBBP->business_id = $business_id;
                    $modelBBP->products_id = $product_id;
                    $success = $modelBBP->save();
                    $data['BusinessByProduct'] = $modelBBP->attributes;
                    $data['BusinessByProduct']['isCreate'] = $isCreateCurrent;
                    $modelBBD = null;
                    $isCreateCurrent = false;
                    if ($product_by_details_id == 'null' || $product_by_details_id == null || $product_by_details_id == 'undefined') {
                        $modelBBD = new ProductByDetails();
                        $isCreateCurrent = true;
                    } else {
                        $modelBBD = ProductByDetails::find($product_by_details_id);
                        $isCreateCurrent = false;
                    }

                    $modelBBD->product_id = $product_id;
                    $modelBBD->tax_id = $tax_id;
                    $modelBBD->location_details = $location_details;
                    $modelBBD->stock_control = $stock_control;
                    $modelBBD->ice_control = $ice_control;
                    $modelBBD->initial_stock_control = $initial_stock_control;
                    $success = $modelBBD->save();
                    $data['ProductByDetails'] = $modelBBD->attributes;
                    $data['ProductByDetails']['isCreate'] = $isCreateCurrent;
                    //inventory

                    $avarage_kardex_value = 0;
                    $tax = $has_tax == 0 ? 'NO' : 'SI';
                    $quantity_units = $quantity_units;
                    $total_price = 0;
                    $profit = 0;//
                    $profit_type = 0;//percentage
                    $note = $description;
                    $sale_price2 = $sale_price;
                    $sale_price3 = $sale_price;
                    $sale_price4 = $sale_price;

                    $attributesSet = [
                        'business_id' => $business_id,
                        'avarage_kardex_value' => $avarage_kardex_value,
                        'tax' => $tax,
                        'quantity_units' => $quantity_units,
                        'sale_price' => $sale_price,
                        'total_price' => $total_price,
                        'product_id' => $product_id,
                        'tax_id' => $tax_id,
                        'profit' => $profit,
                        'profit_type' => $profit_type,
                        'note' => $note,
                        'sale_price2' => $sale_price2,
                        'sale_price3' => $sale_price3,
                        'sale_price4' => $sale_price4,

                    ];
                    $modelInventory->fill($attributesSet);
                    $success = $modelInventory->save();
//variants
                    $data['ProductInventory'] = $modelInventory->attributes;
                    $data['ProductInventory']['isCreate'] = $isCreateInventory;
                    $keys_manager = $attributesPost['product_by_color_data'];
                    $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                    $model->colors()->sync($keys_manager);

                    $keys_manager = $attributesPost['product_by_sizes_data'];
                    $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                    $model->sizes()->sync($keys_manager);


                    $keys_manager = $attributesPost['product_by_package_data'];
                    $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                    $model->packages()->sync($keys_manager);
                    //details shipping manager
                    $modelPDSF = null;
                    $isCreateCurrent = false;

                    if ($product_details_shipping_fee_id == 'null' || $product_details_shipping_fee_id == null || $product_details_shipping_fee_id == 'undefined') {
                        $modelPDSF = new ProductDetailsShippingFee();
                        $isCreateCurrent = true;

                    } else {
                        $modelPDSF = ProductDetailsShippingFee::find($product_details_shipping_fee_id);
                        $isCreateCurrent = false;

                    }
                    $attributesSet = [
                        'weight' => $attributesPost['weight'],
                        'width' => $attributesPost['width'],
                        'length' => $attributesPost['length'],
                        'height' => $attributesPost['height'],
                        'product_id' => $product_id,

                    ];

                    $modelPDSF->fill($attributesSet);
                    $success = $modelPDSF->save();
                    $data['ProductDetailsShippingFee'] = $modelPDSF->attributes;
                    $data['ProductDetailsShippingFee']['isCreate'] = $isCreateCurrent;

                    $isCreateCurrent = false;

                    if ($product_parent_by_product_id == 'null' || $product_parent_by_product_id == null || $product_parent_by_product_id == 'undefined') {
                        $modelPPBP = new ProductParentByProduct();
                        $isCreateCurrent = true;
                    } else {
                        $modelPPBP = ProductParentByProduct::find($product_parent_by_product_id);
                        $isCreateCurrent = false;
                    }
                    $product_parent_id = $attributesPost['product_parent_id'];
                    $attributesSet = [
                        'product_parent_id' => $product_parent_id,
                        'product_id' => $product_id,


                    ];


                    //change data code unic
                    $modelProduct = Product::find($product_id);
                    $modelProductParent = ProductParent::find($product_parent_id);
                    $codeUniqueProduct = $this->generateStructureCode($modelProductParent->code, $modelProduct->id, 20);
                    $modelProduct->code_product = $codeUniqueProduct;
                    $modelProduct->save();
                    $data['Product'] = $modelProduct->attributes;
                    $data['Product']['id'] = $product_id;
                    $data['Product']['isCreate'] = $isCreateProduct;
                    $modelPPBP->fill($attributesSet);
                    $success = $modelPPBP->save();
                    $data['ProductParentByProduct'] = $modelPPBP->attributes;
                    $data['ProductParentByProduct']['isCreate'] = $isCreateCurrent;
                    $isCreateCurrent = false;

                    if ($product_by_meta_data_id == 'null' || $product_by_meta_data_id == null || $product_by_meta_data_id == 'undefined') {
                        $modelPBMD = new ProductByMetaData();
                        $isCreateCurrent = true;

                    } else {
                        $modelPBMD = ProductByMetaData::find($product_by_meta_data_id);
                        $isCreateCurrent = false;

                    }

                    $attributesSet = [
                        'product_id' => $product_id,
                        'title' => $attributesPost['title'],
                        'keyword' => $attributesPost['keyword'],
                        'description' => $attributesPost['description_meta'],
                    ];

                    $modelPBMD->fill($attributesSet);
                    $success = $modelPBMD->save();
                    $data['ProductByMetaData'] = $modelPBMD->attributes;
                    $data['ProductByMetaData']['isCreate'] = $isCreateCurrent;


                } else {
                    $success = false;
                    $msj = "Problemas al guardar  Product.";
                    $errors = $validateResult["errors"];
                }


            } else {
                $msj = "Problemas al guardar la imagen.";

            }

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data
            ];
            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                "data" => []
            );
            DB::rollBack();
            return ($result);
        }

    }

    public static function configManagementProductServiceDefault()
    {

        $modelTradeMark = [
            'success' => false
        ];
        $modelCurrent = new \App\Models\ProductTrademark();
        $modelData = $modelCurrent::find($modelCurrent::DEFAULT_ID);
        if ($modelData) {
            $modelTradeMark['success'] = true;
            $modelTradeMark['data'] = $modelData;

        }
        $modelCategory = [
            'success' => false
        ];
        $modelCurrent = new \App\Models\ProductCategory();
        $modelData = $modelCurrent::find($modelCurrent::DEFAULT_ID);
        if ($modelData) {
            $modelCategory['success'] = true;
            $modelCategory['data'] = $modelData;

        }
        $modelSubcategory = [
            'success' => false
        ];
        $modelCurrent = new \App\Models\ProductSubcategory();
        $modelData = $modelCurrent::find($modelCurrent::DEFAULT_ID);
        if ($modelData) {
            $modelSubcategory['success'] = true;
            $modelSubcategory['data'] = $modelData;

        }
        $modelMeasureType = [
            'success' => false
        ];
        $modelCurrent = new \App\Models\ProductMeasureType();
        $modelData = $modelCurrent::find($modelCurrent::DEFAULT_ID);
        if ($modelData) {
            $modelMeasureType['success'] = true;
            $modelMeasureType['data'] = $modelData;

        }
        $result = [

            'tradeMark' => $modelTradeMark,
            'category' => $modelCategory,
            'subcategory' => $modelSubcategory,
            'measureType' => $modelMeasureType,

        ];
        return $result;
    }

    public static function getRulesModel()
    {
        $rules = ["code" => "required|max:64",
            "name" => "required",
            "state" => "required",
            "product_trademark_id" => "required|numeric",
            "product_category_id" => "required|numeric",
            "product_subcategory_id" => "required|numeric",
            "source" => "max:250",
            "code_provider" => "max:80",
            "code_product" => "max:80",
            "has_tax" => "required|numeric",
            "is_service" => "required|numeric",
            "view_online" => "required|numeric",
            "user_id" => "required|numeric",
            "product_measure_type_id" => "required|numeric"
        ];
        return $rules;
    }

//relations
    public function colors()
    {
        $parentKeyCurrent = 'product_id';
        $childrenKeyCurrent = 'product_color_id';
        $childrenClass = ProductByColor::class;
        $childrenTable = 'product_by_color';
        return $this->belongsToMany($childrenClass, $childrenTable, $parentKeyCurrent, $childrenKeyCurrent);
    }

    public function sizes()
    {
        $parentKeyCurrent = 'product_id';
        $childrenKeyCurrent = 'product_sizes_id';
        $childrenClass = ProductBySizes::class;
        $childrenTable = 'product_by_sizes';
        return $this->belongsToMany($childrenClass, $childrenTable, $parentKeyCurrent, $childrenKeyCurrent);
    }

    public function packages()
    {
        $parentKeyCurrent = 'product_id';
        $childrenKeyCurrent = 'product_parent_by_package_params_id';
        $childrenClass = ProductByPackage::class;
        $childrenTable = 'product_by_package';
        return $this->belongsToMany($childrenClass, $childrenTable, $parentKeyCurrent, $childrenKeyCurrent);
    }

    /*MANAGER MAINS*/
    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id,ROUND(product_inventory.quantity_units,2) quantity_units
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
,tax.value tax_value,tax.percentage tax_percentage";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $this->table . '.id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere('product_inventory.note', 'like', '%' . $likeSet . '%');

            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

        }

        $query->where('business_by_products.business_id', '=', $business_id);
        $is_service = 0;
        $query->where('product.is_service', '=', $is_service);
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }

    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();

        foreach ($result['rows'] as $key => $row) {
            $dataRow = (array)$row;
            $product_id = $row->id;
            $result['rows'][$key] = $dataRow;
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result['rows'][$key]['colors'] = $colors;
            $result['rows'][$key]['sizes'] = $sizes;

        }
        return $result;

    }

    public function saveDataInputOutput($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'ProductSaveDataInputOutput';
            $model = new Product();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            $modelInventory = null;

            $model = Product::find($attributesPost[$modelName]['product_id']);
            $createUpdate = false;
            $auxResource = $model->source;
            $modelInventory = ProductInventory::find($attributesPost[$modelName]['product_inventory_id']);

            $user = Auth::user();
            $productData = $attributesPost[$modelName];
            $product_id = $model->id;

            $modelBBD = new ProductByDetails();
            $modelBBDData = $modelBBD->getDetailsProduct([
                'filters' => ['product_id' => $product_id]
            ]);
            if ($modelBBDData != false) {

                $modelBBD = ProductByDetails::find($modelBBDData->id);
            }
            $type_input = $productData['type_input'];
            //inventory
            $avarage_kardex_value = $modelInventory->avarage_kardex_value;
            $tax = $modelInventory->tax;
            $quantity_units = $attributesPost[$modelName]['quantity_units'];
            $quantity_units_manager = $attributesPost[$modelName]['quantity_units'];

            $allowInputOutput = true;
            if ($type_input == 1) {
                $codigo_documento = 'I-';

                $quantity_units = $modelInventory->quantity_units + $quantity_units;
            } else {
                if ($quantity_units > $modelInventory->quantity_units) {
                    $allowInputOutput = false;
                }
                $quantity_units = $modelInventory->quantity_units - $quantity_units;
                $codigo_documento = 'O-';

            }
            $total_price = $modelInventory->total_price;
            $profit = $modelInventory->profit;//
            $profit_type = 0;//percentage
            $note = $modelInventory->note;
            $sale_price2 = $modelInventory->sale_price2;
            $sale_price = $modelInventory->sale_price;
            $tax_id = $modelInventory->tax_id;

            $sale_price3 = $modelInventory->sale_price3;
            $sale_price4 = $modelInventory->sale_price4;
            $business_id = $modelInventory->business_id;

            $attributesSet = [
                'business_id' => $business_id,
                'avarage_kardex_value' => $avarage_kardex_value,
                'tax' => $tax,
                'quantity_units' => $quantity_units,
                'sale_price' => $sale_price,
                'total_price' => $total_price,
                'product_id' => $product_id,
                'tax_id' => $tax_id,
                'profit' => $profit,
                'profit_type' => $profit_type,
                'note' => $note,
                'sale_price2' => $sale_price2,
                'sale_price3' => $sale_price3,
                'sale_price4' => $sale_price4,

            ];
            if ($allowInputOutput) {

                $modelAK = new \App\Models\AverageKardex();
                $producto_id = $product_id;
                $entidad_data_id = $business_id;
                $managerParamsCurrent = array("product_id" => $producto_id, "entidad_data_id" => $entidad_data_id);
                $currentKardexProduct = $modelAK->getCurrentKardexProduct($managerParamsCurrent);
                $codigo_documento .= '' . $producto_id;
                $entidad_id = $product_id;
                $entidad = "product";
                $cantidad = $quantity_units_manager;
                $porcentaje_descuento = 0;
                $precio_venta = $sale_price;
                $type = '';
                $fecha_factura = \App\Utils\Util::DateCurrent();
                $detailsTransaction = '';
                if ($type_input == 1) {
                    $detailsTransaction = ("Ingreso de Producto por Inventario " . $codigo_documento);
                } else if ($type_input == 0) {
                    $detailsTransaction = ("Egreso de Producto por Inventario " . $codigo_documento);

                }

                $resultKardex = $modelAK->managementInputsOutputsInventory(array(
                    "dataKardexCurrent" => $currentKardexProduct,
                    "cantidad" => $cantidad,
                    "descuento" => $porcentaje_descuento,
                    "precio" => $precio_venta,
                    "type" => $type,
                    "producto_id" => $producto_id,
                    "entidad_data_id" => $entidad_data_id,
                    "entidad_id" => $entidad_id,
                    "entidad" => $entidad,
                    "entidad_fecha" => $fecha_factura,
                    "documentInformation" => $codigo_documento,
                    'income_type' => true,
                    'detailsTransaction' => $detailsTransaction

                ));
                $success = $resultKardex["success"];
                $allowInputOutput = $success;
                if ($success) {

                    $rowKardex = $modelAK->getValuesInputsOutputsInventory($resultKardex);
                    $attributesData = array_merge($rowKardex, $modelInventory->attributes);
                    $modelInventory->attributes = $attributesData;
                    $modelInventory->fill($attributesSet);
                    $success = $modelInventory->save();
                    $allowInputOutput = $success;

                } else {
                    $msj = 'No se pudo guardar en el kardex del inventario.';

                }
            } else {
                $msj = 'No se puede debitar del inventario.';
                $success = $allowInputOutput;

            }


            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msg" => $msj,
                "msj" => $msj,

                "success" => $success
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'Product';
            $model = new Product();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            $modelInventory = null;
            $product_details_shipping_fee_id = $attributesPost["product_details_shipping_fee_id"];
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = Product::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
                $modelInventory = ProductInventory::find($attributesPost['product_inventory_id']);

            } else {
                $createUpdate = true;
                $modelInventory = new   ProductInventory();
            }
            $user = Auth::user();

            $productData = $attributesPost;
            $source = $productData["source"];

            $pathSet = "/uploads/products/product";
            $change = $productData["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {

                $source = $successMultimediaModel['sourceServer'];
                $productData['source'] = $source;
                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productData, 'attributesData' => $this->attributesData));
                $attributesSet['user_id'] = $user->id;
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                $business_id = $attributesPost['business_id'];
                $tax_id = $attributesPost['tax_id'];
                $has_tax = $attributesPost['has_tax'];
                $sale_price = $attributesPost['sale_price'];
                $quantity_units = isset($attributesPost['quantity_units']) ? $attributesPost['quantity_units'] : 0;

                $description = $attributesPost['description'];

                $location_details = isset($attributesPost['location_details']) ? $attributesPost['location_details'] : "";
                $stock_control = isset($attributesPost['stock_control']) ? $attributesPost['stock_control'] : 0;
                $ice_control = isset($attributesPost['ice_control']) ? $attributesPost['ice_control'] : 0;
                $initial_stock_control = isset($attributesPost['initial_stock_control']) ? $attributesPost['initial_stock_control'] : 0;

                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                    $product_id = $model->id;
                    if ($createUpdate) {

                        $modelBBP = new BusinessByProduct();
                        $modelBBP->business_id = $business_id;
                        $modelBBP->products_id = $product_id;
                        $success = $modelBBP->save();
                    } else {
                        /* $modelInventory = new    ProductInventory();*/

                    }

                    $modelBBD = new ProductByDetails();
                    $modelBBDData = $modelBBD->getDetailsProduct([
                        'filters' => ['product_id' => $product_id]
                    ]);
                    if ($modelBBDData != false) {

                        $modelBBD = ProductByDetails::find($modelBBDData->id);
                    }
                    $modelBBD->product_id = $product_id;
                    $modelBBD->tax_id = $tax_id;
                    $modelBBD->location_details = $location_details;
                    $modelBBD->stock_control = $stock_control;
                    $modelBBD->ice_control = $ice_control;
                    $modelBBD->initial_stock_control = $initial_stock_control;
                    $success = $modelBBD->save();

                    //inventory

                    $avarage_kardex_value = 0;
                    $tax = $has_tax == 0 ? 'NO' : 'SI';
                    $quantity_units = $quantity_units;
                    $total_price = 0;
                    $profit = 0;//
                    $profit_type = 0;//percentage
                    $note = $description;
                    $sale_price2 = $sale_price;
                    $sale_price3 = $sale_price;
                    $sale_price4 = $sale_price;

                    $attributesSet = [
                        'business_id' => $business_id,
                        'avarage_kardex_value' => $avarage_kardex_value,
                        'tax' => $tax,
                        'quantity_units' => $quantity_units,
                        'sale_price' => $sale_price,
                        'total_price' => $total_price,
                        'product_id' => $product_id,
                        'tax_id' => $tax_id,
                        'profit' => $profit,
                        'profit_type' => $profit_type,
                        'note' => $note,
                        'sale_price2' => $sale_price2,
                        'sale_price3' => $sale_price3,
                        'sale_price4' => $sale_price4,

                    ];
                    $modelInventory->fill($attributesSet);
                    $success = $modelInventory->save();
//variants

                    $keys_manager = $attributesPost['product_by_color_data'];
                    $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                    $model->colors()->sync($keys_manager);

                    $keys_manager = $attributesPost['product_by_sizes_data'];
                    $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                    $model->sizes()->sync($keys_manager);

                    //details shipping manager
                    $modelPDSF = null;
                    if ($product_details_shipping_fee_id == 'null' || $product_details_shipping_fee_id == null || $product_details_shipping_fee_id == 'undefined') {
                        $modelPDSF = new ProductDetailsShippingFee();
                    } else {
                        $modelPDSF = ProductDetailsShippingFee::find($product_details_shipping_fee_id);

                    }
                    $attributesSet = [
                        'weight' => $attributesPost['weight'],
                        'width' => $attributesPost['width'],
                        'length' => $attributesPost['length'],
                        'height' => $attributesPost['height'],
                        'product_id' => $product_id,

                    ];

                    $modelPDSF->fill($attributesSet);
                    $success = $modelPDSF->save();

                } else {
                    $success = false;
                    $msj = "Problemas al guardar  Product.";
                    $errors = $validateResult["errors"];
                }
                if (!$success) {
                    DB::rollBack();

                } else {
                    DB::commit();
                }
                $result = [
                    "errors" => $errors,
                    "msj" => $msj,
                    "success" => $success
                ];


            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

    public function getAdminService($params)
    {
        $result = $this->getAdminDataService($params);

        return $result;

    }

    public function getAdminDataService($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';

        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,$sale_prices_manager,product_inventory.id product_inventory_id
,tax.value tax_value,tax.percentage tax_percentage";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');;

        }
        $query->where('business_by_products.business_id', '=', $business_id);
        $is_service = 1;
        $query->where('product.is_service', '=', $is_service);

        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }

    public function saveDataService($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'Product';
            $model = new Product();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            $modelInventory = null;

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = Product::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
                $modelInventory = ProductInventory::find($attributesPost['product_inventory_id']);

            } else {
                $createUpdate = true;
                $modelInventory = new   ProductInventory();
            }
            $user = Auth::user();

            $productData = $attributesPost;
            $source = $productData["source"];
            $pathSet = "/uploads/products/product";
            $change = $productData["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {

                $source = $successMultimediaModel['sourceServer'];
                $productData['source'] = $source;
                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productData, 'attributesData' => $this->attributesData));
                $attributesSet['user_id'] = $user->id;
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                $business_id = $attributesPost['business_id'];
                $tax_id = $attributesPost['tax_id'];
                $has_tax = $attributesPost['has_tax'];
                $sale_price = $attributesPost['sale_price'];
                $description = $attributesPost['description'];

                $location_details = isset($attributesPost['location_details']) ? $attributesPost['location_details'] : "";
                $stock_control = isset($attributesPost['stock_control']) ? $attributesPost['stock_control'] : 0;
                $ice_control = isset($attributesPost['ice_control']) ? $attributesPost['ice_control'] : 0;
                $initial_stock_control = isset($attributesPost['initial_stock_control']) ? $attributesPost['initial_stock_control'] : 0;

                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                    $product_id = $model->id;
                    if ($createUpdate) {

                        $modelBBP = new BusinessByProduct();
                        $modelBBP->business_id = $business_id;
                        $modelBBP->products_id = $product_id;
                        $success = $modelBBP->save();
                    } else {
                        /* $modelInventory = new    ProductInventory();*/

                    }

                    $modelBBD = new ProductByDetails();
                    $modelBBDData = $modelBBD->getDetailsProduct([
                        'filters' => ['product_id' => $product_id]
                    ]);
                    if ($modelBBDData != false) {

                        $modelBBD = ProductByDetails::find($modelBBDData->id);
                    }
                    $modelBBD->product_id = $product_id;
                    $modelBBD->tax_id = $tax_id;
                    $modelBBD->location_details = $location_details;
                    $modelBBD->stock_control = $stock_control;
                    $modelBBD->ice_control = $ice_control;
                    $modelBBD->initial_stock_control = $initial_stock_control;
                    $success = $modelBBD->save();

                    //inventory

                    $avarage_kardex_value = 0;
                    $tax = $has_tax == 0 ? 'NO' : 'SI';
                    $quantity_units = 0;
                    $total_price = 0;
                    $profit = 0;//
                    $profit_type = 0;//percentage
                    $note = $description;
                    $sale_price2 = $sale_price;
                    $sale_price3 = $sale_price;
                    $sale_price4 = $sale_price;

                    $attributesSet = [
                        'business_id' => $business_id,
                        'avarage_kardex_value' => $avarage_kardex_value,
                        'tax' => $tax,
                        'quantity_units' => $quantity_units,
                        'sale_price' => $sale_price,
                        'total_price' => $total_price,
                        'product_id' => $product_id,
                        'tax_id' => $tax_id,
                        'profit' => $profit,
                        'profit_type' => $profit_type,
                        'note' => $note,
                        'sale_price2' => $sale_price2,
                        'sale_price3' => $sale_price3,
                        'sale_price4' => $sale_price4,

                    ];
                    $modelInventory->fill($attributesSet);
                    $success = $modelInventory->save();


                } else {
                    $success = false;
                    $msj = "Problemas al guardar  Product.";
                    $errors = $validateResult["errors"];
                }
                if (!$success) {
                    DB::rollBack();

                } else {
                    DB::commit();
                }
                $result = [
                    "errors" => $errors,
                    "msj" => $msj,
                    "success" => $success
                ];


            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }
    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getAdminOutletsManageFrontend($params)
    {

        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;


        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }
        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,$this->table.view_online,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
business_by_products.business_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
";


        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
              ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;

        $query->join('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        $query->where('product_inventory.quantity_units', '>', 0);

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });

        }


        $query->where($this->table . '.state', '=', self::STATE_ACTIVE);
        $query->where($this->table . '.view_online', '=', self::VIEW_ONLINE);
        $query->where('business_by_products.business_id', '=', $business_id);
        if (isset($params['filters']['category']) && $params['filters']['category'] != -1) {
            $fieldsCategory = explode(',', $params['filters']['category']);
            $fieldsSubCategory = explode(',', $params['filters']['subcategory']);
            $query->whereIn('product_category.id', $fieldsCategory);
            $query->whereIn('product_subcategory.id', $fieldsSubCategory);
        }
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            /*
               ;*/

            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });

        }
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }

    public function getAdminManageFrontend($params)
    {

        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;
        $selectBusiness = 'business.id business_id, business.title business_title,business.email business_email';


        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }
        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,$this->table.view_online,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
business_by_products.business_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
,product_by_route_map.id product_by_route_map_id
,ROUND(product_inventory.quantity_units,2) quantity_units,product_inventory.id product_inventory_id
," . $selectBusiness . '
,gamification_by_points.points gamification_by_points_points';


        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
              ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');
        $query->join('business', 'business_by_products.business_id', '=', 'business.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;

        $query->leftJoin('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });
        $joinNotNeed = 'product_by_route_map';
        $query->leftJoin($joinNotNeed, function ($query)
        use (
            $joinNotNeed
        ) {
            $query->on($joinNotNeed . '.product_id', '=', 'product.id');

        });

        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->leftJoin('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        /*$query->where('product_inventory.quantity_units', '>', 0);*/


        $joinNotNeed = 'gamification_by_process';
        $gamification_type_activity_id = \App\Models\GamificationTypeActivity::BUY_ID;
        $paramsSet = [
            'filters' => [
                'business_id' => $business_id,
                'gamification_type_activity_id' => $gamification_type_activity_id,

            ]
        ];

        $query->leftJoin($joinNotNeed, function ($query)
        use (
            $joinNotNeed, $paramsSet
        ) {
            $business_id = $paramsSet['filters']['business_id'];
            $gamification_type_activity_id = $paramsSet['filters']['gamification_type_activity_id'];
            $query->on($joinNotNeed . '.entity_id', '=', 'product.id');
            $query->join('gamification_by_points', $joinNotNeed . '.id', '=', 'gamification_by_points.gamification_by_process_id');
            $query->join('business_by_gamification', $joinNotNeed . '.gamification_id', '=', 'business_by_gamification.gamification_id');
            $query->leftJoin('gamification_type_activity', $joinNotNeed . '.gamification_type_activity_id', '=', 'gamification_type_activity.id');
            $query->where($joinNotNeed . '.entity', '=', 1);
            $query->where($joinNotNeed . '.gamification_type_activity_id', '=', $gamification_type_activity_id);


        });

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });

        }


        $query->where($this->table . '.state', '=', self::STATE_ACTIVE);
        $query->where($this->table . '.view_online', '=', self::VIEW_ONLINE);
        $query->where('business_by_products.business_id', '=', $business_id);
        if (isset($params['filters']['category']) && $params['filters']['category'] != -1) {
            $fieldsCategory = explode(',', $params['filters']['category']);
            $fieldsSubCategory = explode(',', $params['filters']['subcategory']);
            $query->whereIn('product_category.id', $fieldsCategory);
            $query->whereIn('product_subcategory.id', $fieldsSubCategory);
        }
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });

        }
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);


// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }

    public function getAdminBalancesManageFrontend($params)
    {

        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;


        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }
        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,$this->table.view_online,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
business_by_products.business_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
";


        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
              ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;

        $query->leftJoin('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        $query->where('product_inventory.quantity_units', '=', 1);

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });

        }


        $query->where($this->table . '.state', '=', self::STATE_ACTIVE);
        $query->where($this->table . '.view_online', '=', self::VIEW_ONLINE);
        $query->where('business_by_products.business_id', '=', $business_id);
        if (isset($params['filters']['category']) && $params['filters']['category'] != -1) {
            $fieldsCategory = explode(',', $params['filters']['category']);
            $fieldsSubCategory = explode(',', $params['filters']['subcategory']);
            $query->whereIn('product_category.id', $fieldsCategory);
            $query->whereIn('product_subcategory.id', $fieldsSubCategory);
        }
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            /*
               ;*/

            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });

        }
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
    }

//CODE ECCOMERCE-001
    public function getAdminFrontend($params)
    {

        $result = $this->getAdminManageFrontend($params);

        $modelPBM = new ProductByMultimedia();
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        foreach ($result['rows'] as $key => $row) {

            $product_id = $row->id;
            $setPush = (array)$row;
            $result['rows'][$key] = $setPush;

            $multimedia = $modelPBM->getDataProduct(
                [
                    'filters' => ['product_id' => $product_id]
                ]
            );
            $result['rows'][$key] ['multimedia'] = $multimedia;


            $product_id = $row->id;

            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result['rows'][$key]['colors'] = $colors;
            $result['rows'][$key]['sizes'] = $sizes;


        }

        return $result;
    }

    public function getAdminOutletsFrontend($params)
    {
        $result = $this->getAdminOutletsManageFrontend($params);

        $modelPBM = new ProductByMultimedia();
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        foreach ($result['rows'] as $key => $row) {

            $product_id = $row->id;
            $setPush = json_decode(json_encode($row), true);
            $result['rows'][$key] = $setPush;

            $multimedia = $modelPBM->getDataProduct(
                [
                    'filters' => ['product_id' => $product_id]
                ]
            );
            $result['rows'][$key] ['multimedia'] = $multimedia;


            $product_id = $row->id;

            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result['rows'][$key]['colors'] = $colors;
            $result['rows'][$key]['sizes'] = $sizes;


        }

        return $result;
    }


    public function getAdminBalancesFrontend($params)
    {
        $result = $this->getAdminBalancesManageFrontend($params);

        $modelPBM = new ProductByMultimedia();
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        foreach ($result['rows'] as $key => $row) {

            $product_id = $row->id;
            $setPush = json_decode(json_encode($row), true);
            $result['rows'][$key] = $setPush;

            $multimedia = $modelPBM->getDataProduct(
                [
                    'filters' => ['product_id' => $product_id]
                ]
            );
            $result['rows'][$key] ['multimedia'] = $multimedia;


            $product_id = $row->id;

            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result['rows'][$key]['colors'] = $colors;
            $result['rows'][$key]['sizes'] = $sizes;


        }

        return $result;
    }

    public function getProductDetailsFrontend($params)
    {
        $product_id = $params['filters']['product_id'];
        $language = $params['filters']['language'];

        $model = $this->getProduct($params);

        $modelPBM = new ProductByMultimedia();
        $success = false;
        $multimedia = [];
        $colors = [];
        $sizes = [];

        if ($model) {
            $modelColor = new ProductByColor();
            $modelSize = new ProductBySizes();
            $multimedia = $modelPBM->getDataProduct(
                [
                    'filters' => ['product_id' => $product_id]
                ]
            );
            $success = true;


            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);

        }
        $result = [
            'product' => $model,
            'multimedia' => $multimedia,
            'sizes' => $sizes,
            'colors' => $colors,

            'success' => $success,
            'language' => $language,
            'resourcePathServer' => $params['filters']['resourcePathServer']

        ];

        return $result;
    }

    public function getProduct($params)
    {
        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectBusiness = 'business.id business_id, business.title business_title,business.email business_email';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
," . $selectBusiness;
        if ($allowUser) {

            $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,template_wish_list_by_user.product_id product_id_whishlist
,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage," . $selectBusiness;
        }
        $product_id = $params['filters']['product_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;

        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
           ';
        }
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');
        $query->join('business', 'business_by_products.business_id', '=', 'business.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;

        $query->leftJoin('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });

        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');

        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });
            /* $table, $first, $operator = null, $second = null, $type = 'inner', $where = false*/
        }
        $query->where($this->table . '.id', '=', $product_id);

        $data = $query->first();

        return $data;
    }

    public function getProductDetailsById($params)
    {
        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectBusiness = 'business.id business_id, business.title business_title,business.email business_email';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
," . $selectBusiness;
        if ($allowUser) {

            $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,template_wish_list_by_user.product_id product_id_whishlist
,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage," . $selectBusiness;
        }
        $product_id = $params['filters']['product_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;

        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
           ';
        }
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');
        $query->join('business', 'business_by_products.business_id', '=', 'business.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;


        $query->leftJoin('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });

        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });
            /* $table, $first, $operator = null, $second = null, $type = 'inner', $where = false*/
        }
        $query->where($this->table . '.id', '=', $product_id);

        $data = $query->first();

        return $data;
    }

    public function getBusinessProductsListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name ,$this->table.name text,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.sale_price,product_inventory.id product_inventory_id
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $this->table . '.id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->where('business_by_products.business_id', '=', $business_id);
        $is_service = 0;
        $query->where('product.is_service', '=', $is_service);
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getBusinessProductsServicesListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name ,$this->table.name text,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.sale_price,product_inventory.id product_inventory_id
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', $this->table . '.id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->leftJoin('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->where('business_by_products.business_id', '=', $business_id);
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getBusinessServicesListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name ,$this->table.name text,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');

        $query->where('business_by_products.business_id', '=', $business_id);
        $is_service = 1;
        $query->where('product.is_service', '=', $is_service);
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getProductReward($params)
    {


        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.id product_inventory_id,product_inventory.sale_price
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
";

        $product_id = $params['filters']['product_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;
        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';

        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');

        $query->where($this->table . '.id', '=', $product_id);

        $data = $query->first();

        return $data;
    }

    public function getServiceReward($params)
    {


        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
";

        $product_id = $params['filters']['product_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;
        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;

        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->where($this->table . '.id', '=', $product_id);

        $data = $query->first();

        return $data;
    }

    public function getProductsServices($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $is_service = $params['filters']['is_service'];
        $pvp = 'ROUND((product_inventory.sale_price+(tax.percentage*product_inventory.sale_price) /100),2) sale_pvp';
        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name ,CONCAT('$' ,ROUND((product_inventory.sale_price+(tax.percentage*product_inventory.sale_price) /100),2),'-',$this->table.name)text,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,ROUND(product_inventory.sale_price,2) sale_price, ROUND(product_inventory.sale_price2,2)sale_price2,ROUND(product_inventory.sale_price3,2) sale_price3 ,ROUND(product_inventory.sale_price4,2)sale_price4
,tax.value tax_value,tax.percentage tax_percentage,$pvp";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        $query->where('business_by_products.business_id', '=', $business_id);

        $query->where('product.is_service', '=', $is_service);

        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getServices($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $pvp = 'ROUND((product_inventory.sale_price+(tax.percentage*product_inventory.sale_price) /100),2) sale_pvp';
        $selectString = "$this->table.id,$this->table.view_online,$this->table.code,$this->table.name ,CONCAT('$' ,ROUND((product_inventory.sale_price+(tax.percentage*product_inventory.sale_price) /100),2),'-',$this->table.name)text,$this->table.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,ROUND(product_inventory.sale_price,2) sale_price, ROUND(product_inventory.sale_price2,2)sale_price2,ROUND(product_inventory.sale_price3,2) sale_price3 ,ROUND(product_inventory.sale_price4,2)sale_price4
,tax.value tax_value,tax.percentage tax_percentage,$pvp";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        $query->where('business_by_products.business_id', '=', $business_id);
        $is_service = 1;
        $query->where('product.is_service', '=', $is_service);
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_provider', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code_product', 'like', '%' . $likeSet . '%');
                $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

            });
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataOutlet($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,$this->table.view_online,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
business_by_products.business_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
";


        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
              ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;

        $query->join('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');
        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');
        $query->where('product_inventory.quantity_units', '>', 0);

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });

        }


        $query->where($this->table . '.state', '=', self::STATE_ACTIVE);
        $query->where($this->table . '.view_online', '=', self::VIEW_ONLINE);
        $query->where('business_by_products.business_id', '=', $business_id);


        $query->limit(10)->orderBy($field, $sort);
        $resultData = $query->get()->toArray();


        $modelPBM = new ProductByMultimedia();
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        $result = [];
        foreach ($resultData as $key => $row) {

            $product_id = $row->id;
            $setPush = (array)$row;
            $result[$key] = $setPush;
            $multimedia = $modelPBM->getDataProduct(
                [
                    'filters' => ['product_id' => $product_id]
                ]
            );
            $result[$key] ['multimedia'] = $multimedia;
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result[$key]['colors'] = $colors;
            $result[$key]['sizes'] = $sizes;


        }

        return $result;
    }

    public function getDataBalances($params)
    {

        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $user = Auth::user();
        $user_id = null;
        $allowUser = false;
        if ($user) {
            $allowUser = true;
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $sale_prices_manager = 'ROUND(product_inventory.sale_price,2) sale_not_tax ,ROUND((product_inventory.sale_price+(product_inventory.sale_price*tax.percentage/100)),2) sale_price';
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,product_trademark.value as product_trademark,$this->table.view_online,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
business_by_products.business_id,
$this->table.source,$this->table.description,$this->table.code_provider,$this->table.code_product,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id,product_inventory.id product_inventory_id,$sale_prices_manager
,business_by_discount.id business_by_discount_id,business_by_discount.code business_by_discount_code,business_by_discount.name business_by_discount_name,business_by_discount.value business_by_discount_value
,tax.value tax_value,tax.percentage tax_percentage
";


        $relationLanguage = 'language_product';
        $relationLanguageId = 'product_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.name name_lang,' . $relationLanguage . '.description description_lang
              ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products', 'business_by_products.products_id', '=', $this->table . '.id');

        $type = BusinessByDiscounts::TYPE_PERCENTAGE;
        $type_apply = BusinessByDiscounts::TYPE_APPLY_PRODUCTS;
        $has_limit = BusinessByDiscounts::HAS_LIMIT_NOT;
        $has_limit_end = BusinessByDiscounts::HAS_LIMIT_END_NOT;
        $limit_init = null;
        $limit_end = null;
        $minimum_requirements = 0;
        $apply_amount_min_products = 0;
        $amount_min_use = 0;
        $type_add_customers = 0;

        $query->leftJoin('discount_by_products', function ($query)
        use (
            $type,
            $type_apply,
            $has_limit,
            $has_limit_end,
            $limit_init,
            $limit_end,
            $minimum_requirements,
            $apply_amount_min_products,
            $amount_min_use,
            $type_add_customers,
            $business_id
        ) {
            $query->on('discount_by_products.product_id', '=', 'business_by_products.products_id')
                ->join('business_by_discount', 'discount_by_products.business_by_discount_id', '=', 'business_by_discount.id')
                ->where('business_by_discount.state', '=', 'ACTIVE')
                ->where('business_by_discount.type', '=', $type)
                ->where('business_by_discount.type_apply', '=', $type_apply)
                ->where('business_by_discount.has_limit', '=', $has_limit)
                ->where('business_by_discount.minimum_requirements', '=', $minimum_requirements)
                ->where('business_by_discount.apply_amount_min_products', '=', $apply_amount_min_products)
                ->where('business_by_discount.amount_min_use', '=', $amount_min_use)
                ->where('business_by_discount.business_id', '=', $business_id)
                ->where('business_by_discount.type_add_customers', '=', $type_add_customers);

        });
        $query->join('product_trademark', 'product_trademark.id', '=', $this->table . '.product_trademark_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', $this->table . '.id');


        $query->join('tax', 'tax.id', '=', 'product_inventory.tax_id');

        $query->where('product_inventory.quantity_units', '=', 1);

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });

        }
        if ($user_id) {

            $query->leftJoin('template_wish_list_by_user', function ($join) use ($user_id) {
                $join->on('template_wish_list_by_user.product_id', '=', 'product.id')
                    ->where('template_wish_list_by_user.user_id', '=', $user_id);

            });

        }


        $query->where($this->table . '.state', '=', self::STATE_ACTIVE);
        $query->where($this->table . '.view_online', '=', self::VIEW_ONLINE);
        $query->where('business_by_products.business_id', '=', $business_id);


        $query->limit(10)->orderBy($field, $sort);
        $resultData = $query->get()->toArray();


        $modelPBM = new ProductByMultimedia();
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();
        $result = [];
        foreach ($resultData as $key => $row) {

            $product_id = $row->id;
            $setPush = (array)$row;
            $result[$key] = $setPush;
            $multimedia = $modelPBM->getDataProduct(
                [
                    'filters' => ['product_id' => $product_id]
                ]
            );
            $result[$key] ['multimedia'] = $multimedia;
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result[$key]['colors'] = $colors;
            $result[$key]['sizes'] = $sizes;


        }

        return $result;

    }
    public function getProductShopAdmin($params)
    {
        $result = $this->getAdminData($params);
        $modelColor = new ProductByColor();
        $modelSize = new ProductBySizes();

        foreach ($result['rows'] as $key => $row) {
            $dataRow = (array)$row;
            $product_id = $row->id;
            $result['rows'][$key] = $dataRow;
            $colors = $modelColor->getColorsProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $sizes = $modelSize->getSizesProduct([
                'filters' => [
                    'product_id' => $product_id
                ]
            ]);
            $result['rows'][$key]['colors'] = $colors;
            $result['rows'][$key]['sizes'] = $sizes;

        }
        return $result;

    }
}
