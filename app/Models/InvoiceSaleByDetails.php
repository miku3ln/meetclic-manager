<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSaleByDetails extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale_by_details';

    protected $fillable = array(
        'product_id',//*
        'quantity',
        'quantity_unit',
        'discount_percentage',
        'discount_percentage_unit',
        'discount_value',
        'discount_value_unit',
        'unit_price',
        'unit_price_unit',
        'management_type',
        'tax_percentage',
        'subtotal',//*
        'total',//*
        'description',
        'product_type',
        'invoice_sale_id'//*

    );
    protected $attributesData = [
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'quantity', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'quantity_unit', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'discount_percentage', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'discount_percentage_unit', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'discount_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'discount_value_unit', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'unit_price', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'unit_price_unit', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'management_type', 'type' => 'string', 'defaultValue' => 'U', 'required' => 'false'],
        ['column' => 'tax_percentage', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'subtotal', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'total', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_type', 'type' => 'string', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'subtotal';

    public static function getRulesModel()
    {
        $rules = ["product_id" => "required|numeric",
            "quantity" => "numeric",
            "quantity_unit" => "numeric",
            "discount_percentage" => "numeric",
            "discount_percentage_unit" => "numeric",
            "discount_value" => "numeric",
            "discount_value_unit" => "numeric",
            "unit_price" => "numeric",
            "unit_price_unit" => "numeric",
            "tax_percentage" => "numeric",
            "subtotal" => "required|numeric",
            "total" => "required|numeric",
            "product_type" => "max:45",
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

        $selectString = "$this->table.id,$this->table.product_id,$this->table.quantity,$this->table.quantity_unit,$this->table.discount_percentage,$this->table.discount_percentage_unit,$this->table.discount_value,$this->table.discount_value_unit,$this->table.unit_price,$this->table.unit_price_unit,$this->table.management_type,$this->table.tax_percentage,$this->table.subtotal,$this->table.total,$this->table.description,$this->table.product_type,invoice_sale.invoice_code as invoice_sale,
invoice_sale.id as invoice_sale_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.product_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.quantity', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.quantity_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_percentage_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_value_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unit_price', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unit_price_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.management_type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.tax_percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.product_type', 'like', '%' . $likeSet . '%');
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
            $modelName = 'InvoiceSaleByDetails';
            $model = new InvoiceSaleByDetails();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InvoiceSaleByDetails::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $invoiceSaleByDetailsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $invoiceSaleByDetailsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  InvoiceSaleByDetails.";
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
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.product_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.quantity', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.quantity_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_percentage_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_value_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unit_price', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.unit_price_unit', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.management_type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.tax_percentage', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.product_type', 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
