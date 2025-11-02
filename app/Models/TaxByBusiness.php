<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class TaxByBusiness extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'tax_by_business';

    protected $fillable = array(
        'tax_id',//*
        'state',//*
        'business_id'//*

    );
    protected $attributesData = [
        ['column' => 'tax_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'state';

    public static function getRulesModel()
    {
        $rules = ["tax_id" => "required|numeric",
            "state" => "required",
            "business_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,tax.value as tax,
tax.id as tax_id,
$this->table.state,business.title as business,
business.id as business_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('tax', 'tax.id', '=', $this->table . '.tax_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where("tax.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . ".business_id", '=', $business_id);


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
            $modelName = 'TaxByBusiness';
            $model = new TaxByBusiness();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TaxByBusiness::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $taxByBusinessData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $taxByBusinessData, 'attributesData' => $this->attributesData));
            $business_id = $attributesSet['business_id'];
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {

                if ($attributesSet['state'] == 'ACTIVE') {
                    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                        $idCurrent = $attributesPost[$modelName]["id"];
                        TaxByBusiness::where('state', 'ACTIVE')
                            ->where('business_id', '=', $business_id)
                            ->whereNotIn('id', [$idCurrent])
                            ->update(['state' => 'INACTIVE']);
                    } else {
                        TaxByBusiness::where('state', 'ACTIVE')
                            ->where('business_id', '=', $business_id)
                            ->update(['state' => 'INACTIVE']);
                    }
                }
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  TaxByBusiness.";
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
        $query->join('tax', 'tax.id', '=', $this->table . '.tax_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("tax.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getBusinessTax($params)
    {


        $business_id = $params['filters']['business_id'];
        $taxConfig = isset($params['filters']['taxConfig']) ? $params['filters']['taxConfig'] : null;
        $tableConfig = $this->table;
        if (!$taxConfig) {
            $tableConfig = 'tax';
        }
        $query = DB::table($tableConfig);
        $selectString = "tax.id,tax.percentage,tax.value";
        $select = DB::raw($selectString);

        $query->select($select);
        if ($taxConfig) {//config business tax current
            $query->where($this->table . '.state', '=', 'ACTIVE');
            $query->join('tax', 'tax.id', '=', $this->table . '.tax_id');
            $query->where('tax.percentage', '>', 0);
            $query->where($this->table . '.business_id', '=', $business_id);
        } else {
            $query->where('tax.percentage', '=', 0);
            $query->where('tax.percentage', '=', 'ACTIVE');

        }

        $result = $query->first();

        return $result;

    }

    public function getBusinessTaxAll($params)
    {


        $business_id = $params['filters']['business_id'];
        $taxConfig = isset($params['filters']['taxConfig']) ? $params['filters']['taxConfig'] : null;
        $tableConfig = $this->table;

        $query = DB::table($tableConfig);
        $selectString = "tax.id,tax.percentage,tax.value";
        $select = DB::raw($selectString);

        $query->select($select);
        $query->join('tax', 'tax.id', '=', $this->table . '.tax_id');
        $query->where($this->table . '.business_id', '=', $business_id);


        $result = $query->get()->toArray();

        return $result;

    }

    public function getAllowManagementTax($params)
    {


        $business_id = $params['filters']['business_id'];
        $modelTax = $this;
        $typeError = null;
        $taxConfig = $modelTax->getBusinessTax(
            ['filters' =>
                [
                    'business_id' => $business_id,
                    'taxConfig' => true

                ]
            ]
        );
        $paramsConfigTax = [];
        $taxConfiguration = [];
        $errors = [];
        $allowTaxZero = false;
        $allowTaxCurrent = false;
        if ($taxConfig != false) {
            $allowTaxCurrent = true;
            $taxConfiguration['taxCurrent'] = $taxConfig;

        } else {

            $allowTaxCurrent = false;

        }

        $taxCurrentZero = $modelTax->getBusinessTax(
            ['filters' =>
                [
                    'business_id' => $business_id
                ]
            ]
        );

        if ($taxCurrentZero != false) {
            $allowTaxZero = true;
            $taxConfiguration['taxCurrentZero'] = $taxCurrentZero;

        } else {
            $allowTaxZero = false;
            $paramsConfigTax = [
                'title' => 'Advertencia.!',
                'description' => 'Iva Tarifa 0 NO configurado para el sistema.',
            ];
        }
        $typeError = -1;

        if (!$allowTaxZero && !$allowTaxCurrent) {// TAX NO EXISTE O Y CONFIGURACION
            $typeError = 1;
            $errors = [
                'title' => 'Advertencia.!',
                'description' => 'Error 001 : Configuracion de Iva 0 y empresarial no configurado.',
            ];
        } elseif (!$allowTaxZero && $allowTaxCurrent) {//TAX NO EXISTE O Y CONFIGURACION si
            $typeError = 2;
            $errors = [
                'title' => 'Advertencia.!',
                'description' => 'Error 002 : Iva 0 no configurado para el sistema .',
            ];
        } elseif ($allowTaxZero && !$allowTaxCurrent) {//TAX  EXISTE O Y CONFIGURACION no
            $typeError = 3;
            $errors = [
                'title' => 'Advertencia.!',
                'description' => 'Error 003 : Iva no configurado para el sistema .',
            ];
        }
        $result = [

            'params' => $paramsConfigTax,
            'data' => $taxConfiguration,
            'errors' => $errors,
            'typeError' => $typeError,
            'success' => ($typeError == -1)//ok

        ];


        return $result;

    }

    const CONFIG_TAX_PERCENTAGE_BUSINESS = 12;

    public function getEntidadIvaConfiguracion($params)
    {
        $business_id = $params["filters"]["business_id"];
        $percentage = isset($params["filters"]["porcentaje"]) ? $params["filters"]["porcentaje"] : self::CONFIG_TAX_PERCENTAGE_BUSINESS;


        $selectString = 'tax.id, tax.percentage porcentaje';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);
        $query->join('tax', $this->table . '.tax_id', '=', 'tax.id');
        $query->where($this->table . '.business_id', '=', $business_id);
        $query->where('tax.percentage', '=', $percentage);
        $query->where($this->table . '.state', '=', 'ACTIVE');

        $result = $query->get()->toArray();
        return $result;
    }
}
