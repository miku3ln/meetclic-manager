<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class CashReason extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'cash_reason';

    const MOVEMENT_INPUT = 0;
    const MOVEMENT_OUTPUT = 1;

    const INPUT_MIN_ID = 1;
    const INPUT_MAX_ID = 13;

    const OUTPUT_MIN_ID = 14;
    const OUTPUT_MAX_ID = 34;


    /*
 * =====================================================
 * CASH REASON - INPUT
 * =====================================================
 */

    const REASON_CASH_SALE = 1;
    const REASON_CUSTOMER_COLLECTION = 2;
    const REASON_CUSTOMER_PAYMENT = 3;
    const REASON_OWNER_CONTRIBUTION = 4;
    const REASON_CASH_FUND = 5;
    const REASON_CASH_REPLENISHMENT = 6;
    const REASON_SUPPLIER_REFUND = 7;
    const REASON_REFUND_RECEIVED = 8;
    const REASON_LOAN_RECEIVED = 9;
    const REASON_CASH_TRANSFER_INPUT = 10;
    const REASON_BANK_WITHDRAWAL_TO_CASH = 11;
    const REASON_SERVICE_INCOME = 12;
    const REASON_OTHER_INPUT = 13;


    /*
     * =====================================================
     * CASH REASON - OUTPUT
     * =====================================================
     */

    const REASON_SUPPLIER_PURCHASE = 14;
    const REASON_SUPPLIER_PAYMENT = 15;
    const REASON_SUPPLIER_PARTIAL_PAYMENT = 16;
    const REASON_SUPPLIES_PURCHASE = 17;
    const REASON_TRANSPORT_EXPENSE = 18;
    const REASON_UTILITY_PAYMENT = 19;
    const REASON_RENT_PAYMENT = 20;
    const REASON_EMPLOYEE_PAYMENT = 21;
    const REASON_EMPLOYEE_ADVANCE = 22;
    const REASON_FOOD_EXPENSE = 23;
    const REASON_CLEANING_EXPENSE = 24;
    const REASON_OFFICE_EXPENSE = 25;
    const REASON_MAINTENANCE_REPAIR = 26;
    const REASON_CUSTOMER_REFUND = 27;
    const REASON_BANK_DEPOSIT = 28;
    const REASON_CASH_TRANSFER_OUTPUT = 29;
    const REASON_OWNER_WITHDRAWAL = 30;
    const REASON_LOAN_PAYMENT = 31;
    const REASON_TAX_PAYMENT = 32;
    const REASON_MINOR_EXPENSE = 33;
    const REASON_OTHER_OUTPUT = 34;

    protected $fillable = array(
        'value',//*
        'description',
        'state'//*

    );

    public function getActive()
    {
        return self::where('state', self::STATE_ACTIVE)
            ->orderBy('id')
            ->get();
    }

    public function getByMovementType($movementType)
    {
        $query = self::where(
            'state',
            self::STATE_ACTIVE
        );

        if ((int)$movementType === self::MOVEMENT_INPUT) {
            $query->whereBetween(
                'id',
                [
                    self::INPUT_MIN_ID,
                    self::INPUT_MAX_ID
                ]
            );
        }

        if ((int)$movementType === self::MOVEMENT_OUTPUT) {
            $query->whereBetween(
                'id',
                [
                    self::OUTPUT_MIN_ID,
                    self::OUTPUT_MAX_ID
                ]
            );
        }

        return $query
            ->orderBy('id')
            ->get();
    }

    public function belongsToMovementType(
        $cashReasonId,
        $movementType
    )
    {
        if ((int)$movementType === self::MOVEMENT_INPUT) {
            return $cashReasonId >= self::INPUT_MIN_ID
                && $cashReasonId <= self::INPUT_MAX_ID;
        }

        if ((int)$movementType === self::MOVEMENT_OUTPUT) {
            return $cashReasonId >= self::OUTPUT_MIN_ID
                && $cashReasonId <= self::OUTPUT_MAX_ID;
        }

        return false;
    }

    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:150",
            "state" => "required"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.state";

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
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
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
            $modelName = 'CashReason';
            $model = new CashReason();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = CashReason::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $cashReasonData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $cashReasonData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  CashReason.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
