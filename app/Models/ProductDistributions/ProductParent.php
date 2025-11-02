<?php

namespace App\Models\ProductDistributions;

use App\Models\BusinessByDiscounts;
use App\Models\Exception;
use App\Models\ModelManager;
use App\Models\Multimedia;
use Auth;
use Illuminate\Support\Facades\DB;

//Variants


class ProductParent extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const VIEW_ONLINE = 1;

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_parent';

    protected $fillable = array(
        'code',//*
        'name',//*
        'state',//*
        'product_category_id',//*
        'product_subcategory_id',//*
        'source',
        'description',
        'has_tax',//*
        'is_service',//*
        'user_id',//*
        'product_measure_type_id',//*
        'tax_id',//*


    );
    protected $attributesData = [
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'product_category_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_subcategory_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'has_tax', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'is_service', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_measure_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'tax_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'name';


    public static function getRulesModel()
    {
        $rules = [
            "code" => "required|max:64",
            "name" => "required",
            "state" => "required",
            "product_category_id" => "required|numeric",
            "product_subcategory_id" => "required|numeric",
            "source" => "max:250",
            "has_tax" => "required|numeric",
            "is_service" => "required|numeric",
            "user_id" => "required|numeric",
            "product_measure_type_id" => "required|numeric",
            "tax_id" => "required|numeric",

        ];
        return $rules;
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
            if ($field == 'code_name') {
                $field = 'name';
            }
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,tax.value tax_value,tax.percentage tax_percentage,tax.id tax_id
,business_by_products_parent.id business_by_products_parent_id,business_by_products_parent.business_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products_parent', 'product_parent.id', '=', 'business_by_products_parent.product_parent_id');


        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');

        $query->join('tax', 'tax.id', '=', 'product_parent.tax_id');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.code', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');

        }

        $query->where('business_by_products_parent.business_id', '=', $business_id);
        $is_service = 0;
        $query->where('product_parent.is_service', '=', $is_service);
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

        $modelPrices = new ProductParentByPrices();
        $modelPackage = new ProductParentByPackageParams();


        foreach ($result['rows'] as $key => $row) {

            if (is_array($row)) {
                $row = (object)$row;
            }
            $dataRow = $row;

            $setPush = $dataRow;
            $dataPrices = $modelPrices->getDataByProductParent(['filters' => ['product_parent_id' => $row->id]]);
            $setPush->product_parent_by_prices_data = $dataPrices;
            $dataPackage = $modelPackage->getDataByProductParent(['filters' => ['product_parent_id' => $row->id]]);
            $setPush->product_parent_by_package_params_data = $dataPackage;
            $result['rows'][$key] = $setPush;


        }
        return $result;

    }

    public function getAdminProductParentData($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $id = $params['filters']['id'];

        $selectString = "$this->table.id,$this->table.code,$this->table.name,$this->table.state,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
$this->table.source,$this->table.description,$this->table.has_tax,$this->table.is_service,$this->table.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,tax.value tax_value,tax.percentage tax_percentage,tax.id tax_id
,business_by_products_parent.id business_by_products_parent_id,business_by_products_parent.business_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_products_parent', 'product_parent.id', '=', 'business_by_products_parent.product_parent_id');

        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', $this->table . '.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');

        $query->join('tax', 'tax.id', '=', 'product_parent.tax_id');


        $query->where('business_by_products_parent.business_id', '=', $business_id);
        $is_service = 0;
        $query->where('product_parent.is_service', '=', $is_service);
        $query->where($this->table . '.id', '=', $id);

        $query->orderBy($field, $sort);
        $data = $query->get()->first();

        return $data;
    }

    public function getAdminProductParent($params)
    {
        $resultData = $this->getAdminProductParentData($params);

        $modelPrices = new ProductParentByPrices();
        $modelPackage = new ProductParentByPackageParams();


        $dataRow = $resultData;
        $setPush = $dataRow;
        $dataPrices = $modelPrices->getDataByProductParent(['filters' => ['product_parent_id' => $dataRow->id]]);
        $setPush->product_parent_by_prices_data = $dataPrices;
        $dataPackage = $modelPackage->getDataByProductParent(['filters' => ['product_parent_id' => $dataRow->id]]);
        $setPush->product_parent_by_package_params_data = $dataPackage;
        $result = $setPush;


        return $result;

    }

    public function saveData($params)
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
            $model = new ProductParent();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            $modelInventory = null;
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = ProductParent::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;


            } else {
                $createUpdate = true;

            }
            $user = Auth::user();

            $productData = $attributesPost;
            $source = $productData["source"];
            $pathSet = "/uploads/products/product";
            $change = isset($productData["change"]) ? $productData["change"] : '';
            if (false) {

                $successMultimediaModel = $modelMultimedia->managerUploadModel(
                    array(
                        'createUpdate' => $createUpdate,
                        'source' => $source,
                        'pathSet' => $pathSet,
                        'change' => $change,
                        'auxResource' => $auxResource
                    )
                );
            }
            $successMultimedia = true;
            $business_id = $attributesPost['business_id'];
            $tax_id = $attributesPost['tax_id'];
            $has_tax = $attributesPost['has_tax'];
            $description = $attributesPost['description'];
            if ($successMultimedia) {

                $source = '';
                $productData['source'] = $source;
                $productData['tax_id'] = $tax_id;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productData, 'attributesData' => $this->attributesData));


                $attributesSet['user_id'] = $user->id;
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];


                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                    $data['ProductParent'] = $model->attributes;
                    $data['ProductParent']['product_trademark_id'] = isset($attributesPost['product_trademark_id']) ? $attributesPost['product_trademark_id'] : 1;//nothing in update
                    $data['ProductParent']['view_online'] = isset($attributesPost['view_online']) ? $attributesPost['view_online'] : 1;//nothing in update
                    $data['ProductParent']['business_id'] = $attributesPost['business_id'];
                    $data['ProductParent']['location_details'] = isset($attributesPost['location_details']) ? $attributesPost['location_details'] : "";//nothing in update
                    $data['ProductParent']['stock_control'] = isset($attributesPost['stock_control']) ? $attributesPost['stock_control'] : 1;//nothing in update
                    $data['ProductParent']['ice_control'] = isset($attributesPost['ice_control']) ? $attributesPost['ice_control'] : 1;//nothing in update
                    $data['ProductParent']['initial_stock_control'] = isset($attributesPost['initial_stock_control']) ? $attributesPost['initial_stock_control'] : 1;//nothing in update
                    $data['ProductParent']['product_by_sizes_data'] = isset($attributesPost['product_by_sizes_data']) ? $attributesPost['product_by_sizes_data'] : [];//nothing in update
                    $data['ProductParent']['product_by_color_data'] = isset($attributesPost['product_by_color_data']) ? $attributesPost['product_by_color_data'] : [];//nothing in update
                    $data['ProductParent']['product_details_shipping_fee_id'] = isset($attributesPost['product_details_shipping_fee_id']) ? $attributesPost['product_details_shipping_fee_id'] : 1;//nothing in update
                    $data['ProductParent']['height'] = isset($attributesPost['height']) ? $attributesPost['height'] : 0;//nothing in update
                    $data['ProductParent']['length'] = isset($attributesPost['length']) ? $attributesPost['length'] : 0;//nothing in update
                    $data['ProductParent']['width'] = isset($attributesPost['width']) ? $attributesPost['width'] : 0;//nothing in update
                    $data['ProductParent']['weight'] = isset($attributesPost['weight']) ? $attributesPost['weight'] : 0;//nothing in update
                    $data['ProductParent']['quantity_units'] = isset($attributesPost['quantity_units']) ? $attributesPost['quantity_units'] : 0;//nothing in update


                    $product_id = $model->id;
                    $modelBBP = new BusinessByProductParent();
                    $business_by_products_parent_id = null;
                    if ($createUpdate) {

                        $modelBBP->business_id = $business_id;
                        $modelBBP->product_parent_id = $product_id;
                        $success = $modelBBP->save();
                        $business_by_products_parent_id = $modelBBP->id;

                        $data['BusinessByProductParent'] = $modelBBP->attributes;

                    } else {
                        $modelBBP = BusinessByProductParent::find($attributesPost['business_by_products_parent_id']);
                        $modelBBP->business_id = $business_id;
                        $modelBBP->product_parent_id = $product_id;
                        $success = $modelBBP->save();
                        $business_by_products_parent_id = $modelBBP->id;
                        $data['BusinessByProductParent'] = $modelBBP->attributes;
                    }
                    $data['ProductParent']['business_by_products_parent_id'] = $business_by_products_parent_id;


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
                    "success" => $success,
                    'data' => $data
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

}
