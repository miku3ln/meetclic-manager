<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class Caja extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'caja';

    protected $fillable = array(
        'owner_id',//*
        'fecha_apertura',//*
        'fecha_cierre',
        'estado',//*
        'caja_inicio',//*
        'caja_cierre_value',//*
        'caja_terminal_gestion_id',//*
        'fecha_creacion'//*

    );
    protected $attributesData = [
        ['column' => 'owner_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'fecha_apertura', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'fecha_cierre', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'estado', 'type' => 'string', 'defaultValue' => 'ABIERTA', 'required' => 'true'],
        ['column' => 'caja_inicio', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'caja_cierre_value', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'caja_terminal_gestion_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'fecha_creacion', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'fecha_apertura';

    public static function getRulesModel()
    {
        $rules = ["owner_id" => "required|numeric",
            "fecha_apertura" => "required",
            "estado" => "required",
            "caja_inicio" => "required|numeric",
            "caja_cierre_value" => "required|numeric",
            "caja_terminal_gestion_id" => "required|numeric",
            "fecha_creacion" => "required"
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

        $selectString = "$this->table.id,$this->table.owner_id,$this->table.fecha_apertura,$this->table.fecha_cierre,$this->table.estado,$this->table.caja_inicio,$this->table.caja_cierre_value,$this->table.caja_terminal_gestion_id,$this->table.fecha_creacion";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.owner_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.fecha_apertura', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.fecha_cierre', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.estado', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.caja_inicio', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.caja_cierre_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.caja_terminal_gestion_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.fecha_creacion', 'like', '%' . $likeSet . '%');
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
            $modelName = 'Caja';
            $model = new Caja();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = Caja::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $cajaData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $cajaData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  Caja.";
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

    public function getExistCashUserCurrent($params)
    {
        $estado = isset($params['filters']['state']) ? $params['filters']['state'] : 'ABIERTA';
        $dateInit = ($params['filters']['dateInit']);
        $dateEnd = ($params['filters']['dateEnd']);
        $getSelectBeeString = 'caja.id,caja.owner_id,caja.fecha_apertura,caja.fecha_cierre,caja.estado,caja.caja_inicio,caja.caja_cierre_value';
        $select = DB::raw($getSelectBeeString);
        $query = DB::table('caja_has_entidad');
        $owner_id = isset($params['filters']['user_id']) ? $params['filters']['user_id'] : null; //USUARIO QIEN GESTIONA
        if ($owner_id) {
            $entidad_data_id = $params['filters']['entidad_data_id'];

            $query->select($select);
            $query->join('caja', 'caja_has_entidad.caja_id', '=', "caja.id");
            $query->where("caja_has_entidad.business_id", $entidad_data_id);
            $query->where("caja.owner_id",'=',$owner_id);
            $query->where("caja.estado",'=',  $estado);

            $query->where('caja.fecha_apertura','>=',$dateInit);
            $query->where( 'caja.fecha_apertura','<=',$dateEnd);
            $result = $query->first();
        } else {
            $result = null;
        }

        return $result;

    }

    public function getAllowManagement($params)
    {

        $type = null;
        $case = null;
        $allow = null;

        $msg = '';
        $modelC = new Caja();
        $resultData = $modelC->getExistCashUserCurrent($params);
        if ($resultData == false) {
            $allow = false;
            $case = 1;
            $msg = '  Caja no asignada a Usuario';

        } else {
            $allow = true;
            $case = 0;
            $msg = '  Caja asignada a Usuario';
        }

        $result = [

            'type' => $type,
            'allow' => $allow,
            'case' => $case,
            'msg' => $msg,
            'data' => $resultData
        ];


        return $result;
    }

}
