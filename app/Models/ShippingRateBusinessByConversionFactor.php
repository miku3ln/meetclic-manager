<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ShippingRateBusinessByConversionFactor extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'shipping_rate_business_by_conversion_factor';

    protected $fillable = array(
        'shipping_rate_services_id',//*
        'shipping_rate_kinds_of_way_id',//*
        'product_measure_type_id',//*
        'shipping_rate_business_id',//*
        'type_local',//*
        'value_factor'//*

    );
    protected $attributesData = [
        ['column' => 'shipping_rate_services_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'shipping_rate_kinds_of_way_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_measure_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'shipping_rate_business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_local', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'value_factor', 'type' => 'double', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["shipping_rate_services_id" => "required|numeric",
            "shipping_rate_kinds_of_way_id" => "required|numeric",
            "product_measure_type_id" => "required|numeric",
            "shipping_rate_business_id" => "required|numeric",

            "type_local" => "required|numeric",
            "value_factor" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $shipping_rate_business_id = $params['filters']['shipping_rate_business_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,shipping_rate_services.value as shipping_rate_services,
shipping_rate_services.id as shipping_rate_services_id,
shipping_rate_kinds_of_way.value as shipping_rate_kinds_of_way,
shipping_rate_kinds_of_way.id as shipping_rate_kinds_of_way_id,
product_measure_type.value as product_measure_type,
product_measure_type.id as product_measure_type_id,
shipping_rate_business.title as shipping_rate_business,
shipping_rate_business.id as shipping_rate_business_id,$this->table.type_local,$this->table.value_factor";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('shipping_rate_services', 'shipping_rate_services.id', '=', $this->table . '.shipping_rate_services_id');
        $query->join('shipping_rate_kinds_of_way', 'shipping_rate_kinds_of_way.id', '=', $this->table . '.shipping_rate_kinds_of_way_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('shipping_rate_business', 'shipping_rate_business.id', '=', $this->table . '.shipping_rate_business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where("shipping_rate_services.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("shipping_rate_kinds_of_way.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_local', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value_factor', 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . ".shipping_rate_business_id", 'like', $shipping_rate_business_id);


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
            $modelName = 'ShippingRateBusinessByConversionFactor';
            $model = new ShippingRateBusinessByConversionFactor();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = ShippingRateBusinessByConversionFactor::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $shippingRateBusinessByConversionFactorData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $shippingRateBusinessByConversionFactorData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  ShippingRateBusinessByConversionFactor.";
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
        $query->join('shipping_rate_services', 'shipping_rate_services.id', '=', $this->table . '.shipping_rate_services_id');
        $query->join('shipping_rate_kinds_of_way', 'shipping_rate_kinds_of_way.id', '=', $this->table . '.shipping_rate_kinds_of_way_id');
        $query->join('product_measure_type', 'product_measure_type.id', '=', $this->table . '.product_measure_type_id');
        $query->join('shipping_rate_business', 'shipping_rate_business.id', '=', $this->table . '.shipping_rate_business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->where("shipping_rate_services.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("shipping_rate_kinds_of_way.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_measure_type.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_local', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value_factor', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
