<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class BusinessLocation extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_location';

    protected $fillable = array(
        'business_id',//*

        'zones_id'//*

    );
    protected $attributesData = [
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'zones_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["business_id" => "required|numeric",

            "zones_id" => "required|numeric"
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

        $selectString = "$this->table.id,business.title as business,
business.id as business_id,
countries.name as countries,
countries.id as countries_id,
provinces.name as provinces,
provinces.id as provinces_id,
cities.name as cities,
cities.id as cities_id,
zones.name as zones,
zones.id as zones_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('countries', 'countries.id', '=', $this->table . '.countries_id');
        $query->join('provinces', 'provinces.id', '=', $this->table . '.provinces_id');
        $query->join('cities', 'cities.id', '=', $this->table . '.cities_id');
        $query->join('zones', 'zones.id', '=', $this->table . '.zones_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere("countries.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("provinces.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("cities.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("zones.name", 'like', '%' . $likeSet . '%');
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
            $modelName = 'BusinessLocation';
            $model = new BusinessLocation();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessLocation::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $businessLocationData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessLocationData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  BusinessLocation.";
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('countries', 'countries.id', '=', $this->table . '.countries_id');
        $query->join('provinces', 'provinces.id', '=', $this->table . '.provinces_id');
        $query->join('cities', 'cities.id', '=', $this->table . '.cities_id');
        $query->join('zones', 'zones.id', '=', $this->table . '.zones_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere("countries.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("provinces.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("cities.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("zones.name", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
