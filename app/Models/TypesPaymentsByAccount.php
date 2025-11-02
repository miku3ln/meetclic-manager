<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class TypesPaymentsByAccount extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'types_payments_by_account';//typos_de_pagos_has_cuenta_entidad

    protected $fillable = array(
        'accounting_account_id',//*
        'types_payments_id',//*
        'business_id'//*

    );
    protected $attributesData = [
        ['column' => 'accounting_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'types_payments_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["accounting_account_id" => "required|numeric",
            "types_payments_id" => "required|numeric",
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

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,accounting_account.value as accounting_account,
accounting_account.id as accounting_account_id,
types_payments.value as types_payments,
types_payments.id as types_payments_id,
business.title as business,
business.id as business_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        $query->join('types_payments', 'types_payments.id', '=', $this->table . '.types_payments_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("types_payments.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
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
            $modelName = 'TypesPaymentsByAccount';
            $model = new TypesPaymentsByAccount();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TypesPaymentsByAccount::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $typesPaymentsByAccountData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $typesPaymentsByAccountData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  TypesPaymentsByAccount.";
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

    public function actionGetContCuePagosS2()
    {

        $params["filters"]["search_value"] = $_GET['search_value'];
        $params["filters"]["search_entidadid"] = $_GET['search_entidadid'];
        $entity_id = $_GET['search_entidadid'];
        $params["filters"]["tipo_pago"] = $_GET['tipo_pago'];
        $result = array();
        if ($_GET['tipo_pago'] > 0) {
            $type_payment_id = $_GET['tipo_pago'];
            $allow_cash_and_banks = $_GET["allow_cash_and_banks"];
            if ($allow_cash_and_banks) {
                $types_payment_data = $_GET["types_payment_data"];
                $type_payment = $types_payment_data["type_payment"];
                $tipo_de_pago_id = $types_payment_data["id"];

                $typeProcess = isset($_GET["typeProcess"]) ? $_GET["typeProcess"] : null;
                if ($type_payment == TiposDePagos::TYPE_PAYMENT_CASH) {
                    $modelTransaction = new CashByTransactionManagement();
                    $result = $modelTransaction->accountData(array("filters" => array(
                            "entity_id" => $entity_id,
                            "search_value" => $_GET['search_value'],
                            "type_payment_id" => $type_payment_id,
                            "type_payment" => $type_payment,
                            "tipo_de_pago_id" => $tipo_de_pago_id,
                            "typeProcess" => $typeProcess

                        ))
                    );
                } else if ($type_payment == TiposDePagos::TYPE_PAYMENT_BANK) {
                    $modelTransaction = new BankByTransactionManagement();
                    $result = $modelTransaction->accountData(array("filters" => array(
                            "entity_id" => $entity_id,
                            "search_value" => $_GET['search_value'],
                            "type_payment_id" => $type_payment_id,
                            "type_payment" => $type_payment,
                            "tipo_de_pago_id" => $tipo_de_pago_id,
                            "typeProcess" => $typeProcess

                        ))
                    );
                } else if ($type_payment == TiposDePagos::TYPE_PAYMENT_CREDIT_CARD) {
                    $modelTransaction = new BankByTransactionManagement();
                    $result = $modelTransaction->accountData(array("filters" => array(
                            "entity_id" => $entity_id,
                            "search_value" => $_GET['search_value'],
                            "type_payment_id" => $type_payment_id,
                            "type_payment" => $type_payment,
                            "tipo_de_pago_id" => $tipo_de_pago_id,
                            "typeProcess" => $typeProcess

                        ))
                    );
                }

            } else {

                $result = TyposDePagosHasCuentaEntidad::model()->getCuentasContPagos($params);
            }


        }
        echo json_encode($result);


    }


    public function getAccountingPaymentsS2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $business_id = $params['search_entidadid'];
        $types_payments_id = $params['tipo_pago'];

        $search_value = $params['search_value']==''?null: $params['search_value'];

        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = '' . $this->table . '.accounting_account_id as id, CONCAT(accounting_account.value," ",accounting_account.description) as text ,'.  $this->table .'.id types_payments_by_account_id ';
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        $query->join('types_payments', 'types_payments.id', '=', $this->table . '.types_payments_id');
        $query->orWhere($this->table . ".business_id", '=', $business_id);
        $query->orWhere($this->table . ".types_payments_id", '=', $types_payments_id);

        if ($search_value) {

            $likeSet = $search_value;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');

            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
