<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class AllowProcessesThreads extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'allow_processes_threads';
    const PROCESO_VENTAS_INVENTARIO = "VENTAS INVENTARIO";
    const SUBPROCESO_VENTAS_INVENTARIO_RETENCIONES = "RETENCIONES";
    const SUBPROCESO_VENTAS_INVENTARIO_DESCUENTOS = "DESCUENTOS";
    const SUBPROCESO_VENTAS_INVENTARIO_ESTABLECIMIENTO_CODIGO = "ESTABLECIMIENTO CODIGO";
    const SUBPROCESO_VENTAS_INVENTARIO_FECHA = "FECHA";
    const SUBPROCESO_VENTAS_INVENTARIO_FORMAS_PAGO = "FORMAS PAGOS";
    const ventas_establecimiento = false;
    const ventas_descuento = false;
    const ventas_fecha = false;
//    COMPRAS INVENTARIO--
    const PROCESO_COMPRAS_INVENTARIO = "COMPRAS INVENTARIO";
    const SUBPROCESO_COMPRAS_INVENTARIO_RETENCIONES = "RETENCIONES";
    const SUBPROCESO_COMPRAS_INVENTARIO_DESCUENTOS = "DESCUENTOS";
    const SUBPROCESO_COMPRAS_INVENTARIO_ESTABLECIMIENTO_CODIGO = "ESTABLECIMIENTO CODIGO";
    const SUBPROCESO_COMPRAS_INVENTARIO_FECHA = "FECHA";
    const SUBPROCESO_COMPRAS_INVENTARIO_FORMAS_PAGO = "FORMAS PAGOS";
    const compras_establecimiento = false;
    const  compras_descuento = false;
    const  compras_fecha = false;
    protected $fillable = array(
        'name_process',//*
        'thread_name',//*
        'allow',//*
        'entity_plans_id'//*

    );
    protected $attributesData = [
        ['column' => 'name_process', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'thread_name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'allow', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'entity_plans_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'name_process';

    public static function getRulesModel()
    {
        $rules = ["name_process" => "required",
            "thread_name" => "required",
            "allow" => "required|numeric",
            "entity_plans_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.name_process,$this->table.thread_name,$this->table.allow,$this->table.entity_plans_id";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.name_process', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.thread_name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.allow', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_plans_id', 'like', '%' . $likeSet . '%');
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
            $modelName = 'AllowProcessesThreads';
            $model = new AllowProcessesThreads();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AllowProcessesThreads::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $allowProcessesThreadsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $allowProcessesThreadsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AllowProcessesThreads.";
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

    public function findByAttributesByProcessBusiness($params)
    {
        $selectString = isset($params['columnsSelect']) ? $params['columnsSelect'] : '*';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);
        $query->join('business', $this->table . '.entity_plans_id', '=', 'business.entity_plans_id');
        $query->join('entity_plans', 'business.entity_plans_id', '=', 'entity_plans.id');
        foreach ($params['filters'] as $key => $value) {
            $query->where($key, "=", $value);
        }

        $result = $query->first();
        return $result;
    }

}
