<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class MikrotikDhcpServer extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'mikrotik_dhcp_server';

    protected $fillable = array(
        'name',//*
        'interface',//*
        'addres_pool',//*
        'address',//*
        'business_id',//*
        'state',//*
        'mikrotik_type_conection_id'//*

    );
    protected $attributesData = [
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'interface', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'addres_pool', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'address', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'mikrotik_type_conection_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        $rules = ["name" => "required|max:200",
            "interface" => "required|max:200",
            "addres_pool" => "required|max:200",
            "address" => "required|max:200",
            "business_id" => "required|numeric",
            "state" => "required",
            "mikrotik_type_conection_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.name,$this->table.interface,$this->table.addres_pool,$this->table.address,$this->table.business_id,$this->table.state,mikrotik_type_conection.name as mikrotik_type_conection,
mikrotik_type_conection.id as mikrotik_type_conection_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('mikrotik_type_conection', 'mikrotik_type_conection.id', '=', $this->table . '.mikrotik_type_conection_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.interface', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.addres_pool', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.address', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere("mikrotik_type_conection.name", 'like', '%' . $likeSet . '%');
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
            $modelName = 'MikrotikDhcpServer';
            $model = new MikrotikDhcpServer();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = MikrotikDhcpServer::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $mikrotikDhcpServerData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $mikrotikDhcpServerData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  MikrotikDhcpServer.";
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
         $textValue = "$this->table.name";
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,"."CONCAT($this->table.interface,'-',$this->table.name)  text ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('mikrotik_type_conection', 'mikrotik_type_conection.id', '=', $this->table . '.mikrotik_type_conection_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.interface', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.addres_pool', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.address', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere("mikrotik_type_conection.name", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
