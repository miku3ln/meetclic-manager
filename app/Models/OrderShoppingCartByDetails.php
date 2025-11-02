<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class OrderShoppingCartByDetails extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'order_shopping_cart_by_details';

    protected $fillable = array(
        'product_id',//*
        'quantity',//*
        'measure_id',
        'measure',
        'price',
        'price_before',
        'price_discount',
        'allow_discount',//*
        'promotion_id',
        'name',
        'order_shopping_cart_id',//*
        'product_color',
        'product_color_id',
        'product_sizes_id',
        'product_sizes',
        'type_variant',

    );
    protected $attributesData = [
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'quantity', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'measure_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'measure', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'price', 'type' => 'double', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'price_before', 'type' => 'double', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'price_discount', 'type' => 'double', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'allow_discount', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'promotion_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'order_shopping_cart_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_color', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_color_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_sizes_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_sizes', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'type_variant', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],


    ];
    public $timestamps = false;

    protected $field_main = 'measure_id';

    public static function getRulesModel()
    {
        $rules = ["product_id" => "required|numeric",
            "quantity" => "required|numeric",
            "measure_id" => "max:45",
            "measure" => "max:45",
            "price" => "numeric",
            "price_before" => "numeric",
            "price_discount" => "numeric",
            "allow_discount" => "required|numeric",
            "promotion_id" => "numeric",
            "name" => "max:350",
            "order_shopping_cart_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.product_id,$this->table.quantity,$this->table.measure_id,$this->table.measure,$this->table.price,$this->table.price_before,$this->table.price_discount,$this->table.allow_discount,$this->table.promotion_id,$this->table.name,order_shopping_cart.state as order_shopping_cart,
order_shopping_cart.id as order_shopping_cart_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('order_shopping_cart', 'order_shopping_cart.id', '=', $this->table . '.order_shopping_cart_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.product_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.quantity', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.measure_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.measure', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price_before', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price_discount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_discount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.promotion_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_shopping_cart.state", 'like', '%' . $likeSet . '%');;

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


    public function saveDataOrderShipping($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";

        $result = array();
        $attributesPost = $params;
        $errors = array();

        try {
            $modelName = 'OrderShoppingCartByDetails';
            $model = new OrderShoppingCartByDetails();
            $createUpdate = true;

            $orderShoppingCartByDetailsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderShoppingCartByDetailsData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  OrderShoppingCartByDetails.";
                $errors = $validateResult["errors"];
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
        $query->join('order_shopping_cart', 'order_shopping_cart.id', '=', $this->table . '.order_shopping_cart_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.product_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.quantity', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.measure_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.measure', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price_before', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price_discount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_discount', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.promotion_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
            $query->orWhere("order_shopping_cart.state", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataDetails($params)
    {
        $order_shopping_cart_id = $params['filters']['order_shopping_cart_id'];
        $textValue = $this->table . '.id';
        $order = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.product_id,$this->table.quantity,$this->table.measure_id,$this->table.measure,$this->table.price,$this->table.price_before,$this->table.price_discount,$this->table.allow_discount,$this->table.promotion_id,$this->table.name, $this->table.type_variant,$this->table.product_color,$this->table.product_color_id,$this->table.product_sizes_id,$this->table.product_sizes";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.order_shopping_cart_id', '=', $order_shopping_cart_id);
        $query->orderBy($order, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function saveDataOrderShippingEvents($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";

        $result = array();
        $attributesPost = $params;
        $errors = array();
        $model = null;
        try {
            $modelName = 'OrderShoppingCartByDetails';
            $model = new OrderShoppingCartByDetails();
            $createUpdate = true;

            $orderShoppingCartByDetailsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderShoppingCartByDetailsData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  OrderShoppingCartByDetails.";
                $errors = $validateResult["errors"];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'model' => $model
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'model' => $model
            );
            return ($result);
        }

    }
}
