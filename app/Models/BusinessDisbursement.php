<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class BusinessDisbursement extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_disbursement';

    protected $fillable = array(
        'business_id',//*
        'bank_id',//*
        'account_number',//*
        'type_account'//*

    );
    protected $attributesData = [
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'bank_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'account_number', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_account', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'account_number';

    public static function getRulesModel()
    {
        $rules = ["business_id" => "required|numeric",
            "bank_id" => "required|numeric",
            "account_number" => "required|max:150",
            "type_account" => "required|numeric"
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

        $selectString = "$this->table.id,business.title as business,
business.id as business_id,
bank.value as bank,
bank.id as bank_id,
$this->table.account_number,$this->table.type_account";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('bank', 'bank.id', '=', $this->table . '.bank_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere("bank.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.account_number', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_account', 'like', '%' . $likeSet . '%');
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
            $modelName = 'BusinessDisbursement';
            $model = new BusinessDisbursement();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessDisbursement::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $businessDisbursementData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessDisbursementData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  BusinessDisbursement.";
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('bank', 'bank.id', '=', $this->table . '.bank_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
                $query->orWhere("bank.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.account_number', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_account', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
