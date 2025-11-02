<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class MikrotikTypeConection extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'mikrotik_type_conection';

    protected $fillable = array(
        'name',//*
        'ip_conection',//*
        'business_id',//*
        'user',//*
        'password',//*

        'state'//*

    );
    protected $attributesData = [
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'ip_conection', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'user', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'password', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        $rules = ["name" => "required|max:200",
            "ip_conection" => "required|max:200",
            "business_id" => "required|numeric",
            "state" => "required",
            "user" => "required|max:100",
            "password" => "required|max:100",

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

        $selectString = "$this->table.id,$this->table.name,$this->table.ip_conection,$this->table.business_id,$this->table.state,$this->table.user,$this->table.password";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.ip_conection', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.password', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            });;

        }
        $business_id = ($params['filters']["business_id"]);
        $query->where($this->table.".business_id","=",$business_id);
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
            $modelName = 'MikrotikTypeConection';
            $model = new MikrotikTypeConection();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = MikrotikTypeConection::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $mikrotikTypeConectionData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $mikrotikTypeConectionData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  MikrotikTypeConection.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.ip_conection', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
