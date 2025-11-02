<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSaleByBreakdownPayment extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale_by_breakdown_payment';

    protected $fillable = array(
        'date_agreement',//*
        'payment_value',//*
        'state_payment',//*
        'user_id',//*
        'invoice_sale_by_indebtedness_paying_init_id'//*

    );
    protected $attributesData = [
        ['column' => 'date_agreement', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'payment_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state_payment', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_by_indebtedness_paying_init_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'date_agreement';

    public static function getRulesModel()
    {
        $rules = ["date_agreement" => "required",
            "payment_value" => "required|numeric",
            "state_payment" => "required|numeric",
            "user_id" => "required|numeric",
            "invoice_sale_by_indebtedness_paying_init_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.date_agreement,$this->table.payment_value,$this->table.state_payment,$this->table.user_id,invoice_sale_by_indebtedness_paying_init.id as invoice_sale_by_indebtedness_paying_init,
invoice_sale_by_indebtedness_paying_init.id as invoice_sale_by_indebtedness_paying_init_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('invoice_sale_by_indebtedness_paying_init', 'invoice_sale_by_indebtedness_paying_init.id', '=', $this->table . '.invoice_sale_by_indebtedness_paying_init_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.date_agreement', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.payment_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state_payment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale_by_indebtedness_paying_init.id", 'like', '%' . $likeSet . '%');
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
            $modelName = 'InvoiceSaleByBreakdownPayment';
            $model = new InvoiceSaleByBreakdownPayment();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InvoiceSaleByBreakdownPayment::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $invoiceSaleByBreakdownPaymentData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $invoiceSaleByBreakdownPaymentData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  InvoiceSaleByBreakdownPayment.";
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

    public function getPaymentsCurrentS2($params)
    {
        $keyId = "invoice_sale_by_indebtedness_paying_init_id";
        $keyIdRelationPayment = "invoice_sale_by_breakdown_payment_id ";
        $tableRelationPayment = "invoice_sale_by_payment";
        $relationId = $params['invoice_sales_indebtedness_paying_init_id'];
        $modelISBP= new InvoiceSaleByPayment;
        $resultNotIn = $modelISBP->getListAllSaleByInit(['invoice_sale_by_indebtedness_paying_init_id'=>$relationId]);


        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = $this->table .'.invoice_sale_by_indebtedness_paying_init_id,' . $this->table . '.id as id,CONCAT(DATE_FORMAT(' . $this->table . '.date_agreement,"%d/%m/%Y"), " ","$",ROUND(' . $this->table . '.payment_value, 2) )as text ,' . $this->table . '.payment_value pago_cantidad,DATE_FORMAT(' . $this->table . '.date_agreement, "%d/%m/%Y") fecha_pago_acuerdo';
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('invoice_sale_by_indebtedness_paying_init', 'invoice_sale_by_indebtedness_paying_init.id', '=', $this->table . '.invoice_sale_by_indebtedness_paying_init_id');
     $query->where($this->table . '.invoice_sale_by_indebtedness_paying_init_id' , '=', $relationId);
        $query->whereNotIn($this->table . '.id',  $resultNotIn);

        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
