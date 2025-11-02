<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class DiscountByProducts extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'discount_by_products';

    protected $fillable = array();
    protected $attributesData = [

    ];
    public $timestamps = false;

    protected $field_main = 'business_by_discount_id';

    public static function getRulesModel()
    {
        $rules = ["business_by_discount_id" => "required|numeric",
            "product_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "business_by_discount.code as business_by_discount,
business_by_discount.id as business_by_discount_id,
product.code as product,
product.id as product_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_discount', 'business_by_discount.id', '=', $this->table . '.business_by_discount_id');
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere("business_by_discount.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');;

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


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'DiscountByProducts';
            $model = new DiscountByProducts();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = DiscountByProducts::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $discountByProductsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $discountByProductsData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  DiscountByProducts.";
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
        $query->join('business_by_discount', 'business_by_discount.id', '=', $this->table . '.business_by_discount_id');
        $query->join('product', 'product.id', '=', $this->table . '.product_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere("business_by_discount.code", 'like', '%' . $likeSet . '%');
            $query->orWhere("product.code", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getAdminProducts($params)
    {
        $sort = 'asc';
        $field = 'product.name';
        $query = DB::table('product');
        $business_id = $params['filters']['business_id'];
        $business_by_discount_id = isset($params['filters']['business_by_discount_id']) ? ($params['filters']['business_by_discount_id']) : null;

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "product.id,product.view_online,product.code,product.name,product.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
product.source,product.description,product.code_provider,product.code_product,product.has_tax,product.is_service,product.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.sale_price,product_inventory.id product_inventory_id
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
";
        if ($business_by_discount_id && $business_by_discount_id != '') {
            $selectString .= ',discount_by_products.business_by_discount_id';
        }
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('business_by_products', 'business_by_products.products_id', '=', 'product.id');
        $query->join('product_trademark', 'product_trademark.id', '=', 'product.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', 'product.id');
        $query->join('product_category', 'product_category.id', '=', 'product.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', 'product.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', 'product.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', 'product.id');
        $query->where('business_by_products.business_id', '=', $business_id);
        $query->where('product.is_service', '=', 0);

        if ($business_by_discount_id && $business_by_discount_id != '') {

            $query->leftJoin('discount_by_products', function ($join) use ($business_by_discount_id) {
                $join->on('discount_by_products.product_id', '=', 'product.id')
                    ->where('discount_by_products.business_by_discount_id', '=', $business_by_discount_id);

            });
        }
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where('product.code', 'like', '%' . $likeSet . '%');
            $query->orWhere('product.name', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_trademark.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_subcategory.value", 'like', '%' . $likeSet . '%');
            $query->orWhere('product.description', 'like', '%' . $likeSet . '%');
            $query->orWhere('product.user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');;

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

    public function getDetailsProducts($params)
    {
        $sort = 'asc';
        $field = 'product.name';
        $query = DB::table('product');
        $business_id = $params['filters']['business_id'];
        $business_by_discount_id = isset($params['filters']['business_by_discount_id']) ? ($params['filters']['business_by_discount_id']) : null;


        $selectString = "product.id,product.view_online,product.code,product.name,product.state,product_trademark.value as product_trademark,
product_trademark.id as product_trademark_id,
product_category.value as product_category,
product_category.id as product_category_id,
product_subcategory.value as product_subcategory,
product_subcategory.id as product_subcategory_id,
product.source,product.description,product.code_provider,product.code_product,product.has_tax,product.is_service,product.user_id,product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id
,product_inventory.sale_price,product_inventory.id product_inventory_id
,product_details_shipping_fee.id product_details_shipping_fee_id,product_details_shipping_fee.height,product_details_shipping_fee.length,product_details_shipping_fee.width,product_details_shipping_fee.weight
";

        $selectString .= ',discount_by_products.business_by_discount_id';

        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('business_by_products', 'business_by_products.products_id', '=', 'product.id');
        $query->join('product_trademark', 'product_trademark.id', '=', 'product.product_trademark_id');
        $query->leftJoin('product_details_shipping_fee', 'product_details_shipping_fee.product_id', '=', 'product.id');
        $query->join('product_category', 'product_category.id', '=', 'product.product_category_id');
        $query->join('product_subcategory', 'product_subcategory.id', '=', 'product.product_subcategory_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', 'product.product_measure_type_id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', 'product.id');
        $query->where('business_by_products.business_id', '=', $business_id);
        $query->where('product.is_service', '=', 0);


        $query->join('discount_by_products', function ($join) use ($business_by_discount_id) {
            $join->on('discount_by_products.product_id', '=', 'product.id')
                ->where('discount_by_products.business_by_discount_id', '=', $business_by_discount_id);

        });


        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);

        $discountByProducts = $query->get()->toArray();
        $result['total'] = $total;
        $result['DiscountByProducts'] = $discountByProducts;



        return $result;
    }
}
