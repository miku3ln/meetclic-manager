<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSaleByTransactions extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale_by_transactions';
    const documento_gestion_sudsf = 'SIN UTILIZACION DEL SISTEMA FINANCIERO';//EFECTIVO ktdp=4
    const anyOneDocumentConfig = 'anyOneDocumentConfig';

    const documento_gestion_tdc = 'TARJETA DE CREDITO'; //1   ktdp=2
    const documento_gestion_et = 'ENDOSO DE TITULO';//LETRA DE CAMBIO  ktdp=3 CHEQUE
    const documento_gestion_ocudsf = 'OTRO CON UTILIZACION DEL SISTEMA FINANCIERO';//LETRA DE CAMBIO  ktdp=1 TRANSFERENCIA BANCARIA
    const documento_gestion_de = 'DINERO ELECTRONICO'; //2 ktdp=5
    const documento_gestion_tdd = 'TARJETA DE DEBITO'; //2 ktdp=6
    const documento_gestion_tp = 'TARJETA PREPAGO'; //3 ktdp=7
    const documento_gestion_cdd = 'COMPENSACION DE DEUDAS';
    protected $fillable = array(
        'percentage_discount',
        'value_discount',
        'subtotal',//*
        'total',//*
        'account',
        'accounting_account_id',//*
        'way_to_pay',//*
        'type_payment_id',//*
        'invoice_sale_id'//*

    );
    protected $attributesData = [
        ['column' => 'percentage_discount', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'value_discount', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'subtotal', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'total', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'account', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'accounting_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'way_to_pay', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_payment_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'subtotal';

    public static function getRulesModel()
    {
        $rules = ["percentage_discount" => "numeric",
            "value_discount" => "numeric",
            "subtotal" => "required|numeric",
            "total" => "required|numeric",
            "account" => "max:45",
            "accounting_account_id" => "required|numeric",
            "way_to_pay" => "required|max:250",
            "type_payment_id" => "required|numeric",
            "invoice_sale_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.percentage_discount,$this->table.value_discount,$this->table.subtotal,$this->table.total,$this->table.account,accounting_account.value as accounting_account,
accounting_account.id as accounting_account_id,
$this->table.way_to_pay,$this->table.type_payment_id,invoice_sale.invoice_code as invoice_sale,
invoice_sale.id as invoice_sale_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.percentage_discount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value_discount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.account', 'like', '%' . $likeSet . '%');
                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.way_to_pay', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_payment_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
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
            $modelName = 'InvoiceSaleByTransactions';
            $model = new InvoiceSaleByTransactions();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InvoiceSaleByTransactions::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $invoiceSaleByTransactionsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $invoiceSaleByTransactionsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  InvoiceSaleByTransactions.";
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
        $query->join('accounting_account', 'accounting_account.id', '=', $this->table . '.accounting_account_id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.percentage_discount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value_discount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.account', 'like', '%' . $likeSet . '%');
                $query->orWhere("accounting_account.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.way_to_pay', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_payment_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
