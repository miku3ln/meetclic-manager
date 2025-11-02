<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class CustomerProfileByLocation extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'customer_profile_by_location';

    protected $fillable = array(
        'zones_id',//*
        'customer_by_profile_id'//*

    );
    protected $attributesData = [
        ['column' => 'zones_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'customer_by_profile_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["zones_id" => "required|numeric",
            "customer_by_profile_id" => "required|numeric"
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

        $selectString = "$this->table.id,zones.name as zones,
zones.id as zones_id,
customer_by_profile.id as customer_by_profile,
customer_by_profile.id as customer_by_profile_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('zones', 'zones.id', '=', $this->table . '.zones_id');
        $query->join('customer_by_profile', 'customer_by_profile.id', '=', $this->table . '.customer_by_profile_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("zones.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("customer_by_profile.id", 'like', '%' . $likeSet . '%');
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
            $modelName = 'CustomerProfileByLocation';
            $model = new CustomerProfileByLocation();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = CustomerProfileByLocation::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $customerProfileByLocationData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $customerProfileByLocationData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  CustomerProfileByLocation.";
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

    public function getInformation($params)
    {


        $query = DB::table($this->table);
        $customer_by_profile_id = isset($params['filters']['customer_by_profile_id']) ? $params['filters']['customer_by_profile_id'] : null;
        $selectString = "$this->table.id customer_profile_by_location_id
        ,countries.name countries
        ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('zones', 'zones.id', '=', $this->table . '.zones_id');
        $query->join('cities', "zones.city_id", '=', 'cities.id');
        $query->join('provinces', "cities.province_id", '=', 'provinces.id');
        $query->join('countries', "provinces.country_id", '=', 'countries.id');

        if ($customer_by_profile_id) {
            $query->where($this->table . '.customer_by_profile_id', "provinces.=", $customer_by_profile_id);

        }
        $result = $query->first();
        return $result;

    }

}
