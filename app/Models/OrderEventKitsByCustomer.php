<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class OrderEventKitsByCustomer extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'order_event_kits_by_customer';

    protected $fillable = array(
        'events_trails_registration_by_customer_id',//*
        'product_id',//*
        'size_id',
        'color_id',
        'delivery'//*

    );
    protected $attributesData = [
        ['column' => 'events_trails_registration_by_customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'size_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'color_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'delivery', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["events_trails_registration_by_customer_id" => "required|numeric",
            "product_id" => "required|numeric",
            "size_id" => "numeric",
            "color_id" => "numeric",
            "delivery" => "required|numeric"
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

        $selectString = "$this->table.id,events_trails_registration_by_customer.id as events_trails_registration_by_customer,
events_trails_registration_by_customer.id as events_trails_registration_by_customer_id,
$this->table.product_id,$this->table.size_id,$this->table.color_id,$this->table.delivery";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_registration_by_customer', 'events_trails_registration_by_customer.id', '=', $this->table . '.events_trails_registration_by_customer_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_registration_by_customer.id", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.product_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.size_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.color_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.delivery', 'like', '%' . $likeSet . '%');
            });;

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
            $modelName = 'OrderEventKitsByCustomer';
            $model = new OrderEventKitsByCustomer();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = OrderEventKitsByCustomer::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $orderEventKitsByCustomerData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $orderEventKitsByCustomerData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  OrderEventKitsByCustomer.";
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
        $query->join('events_trails_registration_by_customer', 'events_trails_registration_by_customer.id', '=', $this->table . '.events_trails_registration_by_customer_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_registration_by_customer.id", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.product_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.size_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.color_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.delivery', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function saveDataCustomerRegisterKit($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";

        $result = array();
        $attributesPost = $params;
        $errors = array();
        $modelSave = [];
        try {
            $modelName = 'OrderEventKitsByCustomer';
            $model = new OrderEventKitsByCustomer();
            $createUpdate = true;

            $eventsTrailsRegistrationByCustomer = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsRegistrationByCustomer, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $modelSave = $model;
            } else {
                $success = false;
                $msj = "Problemas al guardar  OrderEventKitsByCustomer.";
                $errors = $validateResult["errors"];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'model' => $modelSave

            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'model' => $modelSave
            );
            return ($result);
        }

    }



    public function getKitsByCustomerRegistration($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $events_trails_registration_by_customer_id = $params['filters']['events_trails_registration_by_customer_id'];

        $selectString = "$this->table.id,$this->table.events_trails_registration_by_customer_id,$this->table.product_id,$this->table.size_id,$this->table.color_id,$this->table.delivery
        ,product_sizes.value product_sizes
        ,product_color.value product_color
,product.name product
        ";
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('events_trails_registration_by_customer', 'events_trails_registration_by_customer.id', '=', $this->table . '.events_trails_registration_by_customer_id');
        $query->leftJoin('product', 'product.id', '=', $this->table . '.product_id');
        $query->orderBy($field, $sort);
        $anyone = null;
        $query->leftJoin('product_color', function ($query)
        use (

            $anyone
        ) {
            $query->on('product_color.id', '=', 'order_event_kits_by_customer.color_id');



        });
        $query->leftJoin('product_sizes', function ($query)
        use (

            $anyone
        ) {
            $query->on('product_sizes.id', '=', 'order_event_kits_by_customer.size_id');



        });
        $query->where($this->table . '.events_trails_registration_by_customer_id', '=', $events_trails_registration_by_customer_id);


        $data = $query->get()->toArray();

        $result = $data;


        return $result;
    }

}
