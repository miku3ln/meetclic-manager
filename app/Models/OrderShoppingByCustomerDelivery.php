<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\People;

class OrderShoppingByCustomerDelivery extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'order_shopping_by_customer_delivery';

    protected $fillable = array(
        'people_id',//*
        'payer_email',//*
        'company',
        'address_secondary',//*
        'address_main',//*
        'city',//*
        'state_province_id',
        'zipcode',//*
        'country_id',//*
        'phone',//*
        'user_id',
        'document',

    );
    protected $attributesData = [
        ['column' => 'people_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'payer_email', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'phone', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'company', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'address_main', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'address_secondary', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'city', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state_province_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'zipcode', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'country_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'document', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'payer_email';

    public static function getRulesModel()
    {
        $rules = ["people_id" => "required|numeric",
            "payer_email" => "required|max:350",
            "company" => "max:150",
            "address_main" => "required",
            "address_secondary" => "required",
            "city" => "required|max:150",
            "state_province_id" => "numeric",
            "zipcode" => "required|max:80",
            "country_id" => "required|numeric",
            "user_id" => "numeric",
            "document" => "required",

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

        $selectString = "$this->table.id,people.last_name as people,
people.id as people_id,
$this->table.payer_email,$this->table.company,$this->table.addres,$this->table.city,$this->table.state_province_id,$this->table.zipcode,$this->table.country_id,$this->table.user_id,,$this->table.document";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people', 'people.id', '=', $this->table . '.people_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where("people.last_name", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.payer_email', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.company', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.addres', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.city', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state_province_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.zipcode', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.country_id', 'like', '%' . $likeSet . '%');


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
            $modelName = 'OrderShoppingByCustomerDelivery';
            $model = new OrderShoppingByCustomerDelivery();
            $orderShoppingByCustomerDeliveryData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderShoppingByCustomerDeliveryData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  OrderShoppingByCustomerDelivery.";
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

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people', 'people.id', '=', $this->table . '.people_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->where("people.last_name", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.payer_email', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.company', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.addres', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.city', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state_province_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.zipcode', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.country_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
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

        try {
            $modelName = 'OrderShoppingByCustomerDelivery';
            $model = new OrderShoppingByCustomerDelivery();
            $orderShoppingByCustomerDeliveryData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderShoppingByCustomerDeliveryData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  OrderShoppingByCustomerDelivery.";
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
