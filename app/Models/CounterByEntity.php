<?php

namespace App\Models;

use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Auth;


class CounterByEntity extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'counter_by_entity';

    protected $fillable = array(
        'business_by_counter_id',//*
        'created_at',
        'is_guess',//*
        'user_id',//*
        'token',//*
        'manager_click_type',//*
        'manager_click_id',//*
        'action_name',

        "source_origin",
        "referer_url",
        "campaign_code",
        "device_agent",
        "ip_address",
        "type_process",

    );
    protected $attributesData = [
        ['column' => 'business_by_counter_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'is_guess', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'token', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'manager_click_type', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'manager_click_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'action_name', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],

        ['column' => 'source_origin', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'referer_url', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'campaign_code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'device_agent', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'ip_address', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_process', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
    ];
    public $timestamps = true;

    protected $field_main = 'token';

    public static function getRulesModel()
    {
        $rules = ["business_by_counter_id" => "required|numeric",
            "is_guess" => "required|numeric",
            "user_id" => "required|numeric",
            "token" => "required|max:250"


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

        $selectString = "$this->table.id,business_by_counter.id as business_by_counter,
business_by_counter.id as business_by_counter_id,
$this->table.created_at,$this->table.is_guess,$this->table.user_id,$this->table.token";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_counter', 'business_by_counter.id', '=', $this->table . '.business_by_counter_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business_by_counter.id", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.is_guess', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.token', 'like', '%' . $likeSet . '%');
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
            $modelName = 'CounterByEntity';
            $model = new CounterByEntity();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = CounterByEntity::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $counterByEntityData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $counterByEntityData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  CounterByEntity.";
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
        $query->join('business_by_counter', 'business_by_counter.id', '=', $this->table . '.business_by_counter_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business_by_counter.id", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.is_guess', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.token', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getAllowCounter($params)
    {


        $query = DB::table($this->table);
        $user_id = $params['filters']['user_id'];
        $is_guess = $params['filters']['is_guess'];
        $token = $params['filters']['token'];
        $business_by_counter_id = $params['filters']['business_by_counter_id'];
        $action_name = $params['filters']['action_name'];
        $selectString = "$this->table.id,$this->table.user_id,$this->table.is_guess,$this->table.action_name";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.business_by_counter_id', '=', $business_by_counter_id);
        if ($is_guess == 1) {
            $query->where($this->table . '.token', '=', $token);
        } else {
            $query->where($this->table . '.user_id', '=', $user_id);
        }
        $query->where($this->table . '.action_name', '=', $action_name);
        $result = $query->first();
        return $result;

    }


}
