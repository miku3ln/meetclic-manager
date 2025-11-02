<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class InvoiceSaleByTransactionalAnnex extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'invoice_sale_by_transactional_annex';

    protected $fillable = array(
        'management_livelihood_by_voucher_id',//*
        'invoice_sale_id'//*

    );
    protected $attributesData = [
        ['column' => 'management_livelihood_by_voucher_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_sale_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["management_livelihood_by_voucher_id" => "required|numeric",
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

        $selectString = "$this->table.id,management_livelihood_by_voucher.id as management_livelihood_by_voucher,
management_livelihood_by_voucher.id as management_livelihood_by_voucher_id,
invoice_sale.invoice_code as invoice_sale,
invoice_sale.id as invoice_sale_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('management_livelihood_by_voucher', 'management_livelihood_by_voucher.id', '=', $this->table . '.management_livelihood_by_voucher_id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("management_livelihood_by_voucher.id", 'like', '%' . $likeSet . '%');
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
            $modelName = 'InvoiceSaleByTransactionalAnnex';
            $model = new InvoiceSaleByTransactionalAnnex();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InvoiceSaleByTransactionalAnnex::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $invoiceSaleByTransactionalAnnexData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $invoiceSaleByTransactionalAnnexData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  InvoiceSaleByTransactionalAnnex.";
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
        $query->join('management_livelihood_by_voucher', 'management_livelihood_by_voucher.id', '=', $this->table . '.management_livelihood_by_voucher_id');
        $query->join('invoice_sale', 'invoice_sale.id', '=', $this->table . '.invoice_sale_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("management_livelihood_by_voucher.id", 'like', '%' . $likeSet . '%');
                $query->orWhere("invoice_sale.invoice_code", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
