<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class RetentionTaxSubType extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'retention_tax_sub_type';

    protected $fillable = array(
        'value',//*
        'description',
        'status',//*
        'type',//*
        'retention_tax_type_id',//*
        'percentage',//*
        'accounting_account_id'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'retention_tax_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'percentage', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'accounting_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:250",
            "status" => "required",
            "type" => "required|numeric",
            "retention_tax_type_id" => "required|numeric",
            "percentage" => "required|numeric",
            "accounting_account_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.status,$this->table.type,retention_tax_type.value as retention_tax_type,
retention_tax_type.id as retention_tax_type_id,
$this->table.percentage,accounting_account.value as accounting_account,
accounting_account.id as accounting_account_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('retention_tax_type', 'retention_tax_type.id', '=', $this->table . '.retention_tax_type_id');
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere("retention_tax_type.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
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
            $modelName = 'RetentionTaxSubType';
            $model = new RetentionTaxSubType();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = RetentionTaxSubType::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $retentionTaxSubTypeData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $retentionTaxSubTypeData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  RetentionTaxSubType.";
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
        $query->join('retention_tax_type', 'retention_tax_type.id', '=', $this->table . '.retention_tax_type_id');
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere("retention_tax_type.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListSubTRI($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $tipo_retencion_impuesto_id = $params["filters"]['retention_tax_type_id'];

        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,CONCAT($textValue,' ',$this->table.description,' ',$this->table.percentage,'%') as text,$this->table.retention_tax_type_id tipo_retencion_impuesto_id,$this->table.accounting_account_id contabilidad_cuenta_id ,$this->table.description descripcion,$this->table.status estado ,$this->table.percentage porcentaje , $this->table.value
          ,accounting_account.value cc_code ,accounting_account.description cc_account";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('retention_tax_type', 'retention_tax_type.id', '=', $this->table . '.retention_tax_type_id');
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere("retention_tax_type.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
            });

        }
        $query->where($this->table . '.retention_tax_type_id', '=', $tipo_retencion_impuesto_id);


        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListSubTRIManager($params)
    {
        $result = [];

        $setParams = [
            'search_value' => [
                'term' => $params['search_value'],
            ],
            'filters' => [
                'retention_tax_type_id' => $params['tipo_retencion'],
            ]

        ];
        $resultData = $this->getListSubTRI($setParams);
        foreach ($resultData as $key => $value) {
            $valueCurrent=(array)$value;
            $result[$key] =$valueCurrent;
            $cuenta_contable_data = array("code" => $valueCurrent["cc_code"], "account" => $valueCurrent["cc_account"]);
            $result[$key]["cuenta_contable_data"] = $cuenta_contable_data;

        }

        return $result;

    }

}
