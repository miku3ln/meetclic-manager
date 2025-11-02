<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class TypesPayments extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'types_payments';//tipos_de_pagos
    static $efectivo_id = 1;
    static $tarjeta_credito_id = 2;
    static $cheque_id = 3;
    static $transferencias_bancarias_id = 4;
    static $dinero_electronico_id = 5;
    static $tarjeta_debito_id = 6;
    static $tarjeta_prepago_id = 7;

    const TYPE_PAYMENT_CASH = 0;
    const TYPE_PAYMENT_BANK = 1;
    const TYPE_PAYMENT_CREDIT_CARD = 2;
    const TYPE_PAYMENT_CASH_TEXT = "CAJA";
    const TYPE_PAYMENT_BANK_TEXT = "BANCOS";
    const TYPE_PAYMENT_CREDIT_CARD_TEXT = "TARJETAS";
    protected $fillable = array(
        'value',//*
        'description',
        'status',//*
        'code'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:250",
            "status" => "required",
            "code" => "required|max:6"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.status,$this->table.code";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.code', 'like', '%' . $likeSet . '%');
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
            $modelName = 'TypesPayments';
            $model = new TypesPayments();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TypesPayments::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $typesPaymentsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $typesPaymentsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  TypesPayments.";
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

    public function getDataPagos($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $query = DB::table($this->table);
        $state = 'ACTIVE';
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.status', '=', $state);
        $result = $query->get()->toArray();
        return $result;

    }
    public function getTypesPaymentsS2($params)
    {

        $search_value = isset($params["search_value"])?$params["search_value"]:null;

        $entidad_data_id = isset($params["search_entidadid"])?$params["search_entidadid"]:null;
        $compare = "IF($this->table.type_payment=".self::TYPE_PAYMENT_CASH.",'" . self::TYPE_PAYMENT_CASH_TEXT . "' ,IF($this->table.type_payment=".self::TYPE_PAYMENT_BANK.",'" . self::TYPE_PAYMENT_BANK_TEXT . "' ,IF($this->table.type_payment=".self::TYPE_PAYMENT_CREDIT_CARD.",'" . self::TYPE_PAYMENT_CREDIT_CARD_TEXT . "' ,'TIPO DE PAGO NO DEFINIDA')))";
        $select = ''.$this->table.'.id, CONCAT(' . $compare . '," - ",'.$this->table.'.code ," ",'.$this->table.'.value) text ,'.$this->table.'.type_payment,'.$this->table.'.status estado,'.$this->table.'.type_payment'.",$this->table.description";

        $textValue = $this->table . '.' . $this->field_main;
        $query = DB::table($this->table);
        $state = 'ACTIVE';
        $selectString =$select;
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.status', '=', $state);
        if ($search_value) {

            $likeSet =$search_value;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

            });;

        }
        $field='value';
        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();

        return $result;

    }
}
