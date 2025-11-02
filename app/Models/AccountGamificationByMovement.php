<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class AccountGamificationByMovement extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'account_gamification_by_movement';

    const AMOUNT_BEE_REGISTER = 1500;
    const AMOUNT_QUEEN_REGISTER = 150;
    const BUSINESS_MAIN_ID = 1;
    const USER_ID_MAIN = 1;
    const TYPE_MONEY_BEE = 0;
    const TYPE_MONEY_QUEEN = 1;
    const DESCRIPTION_REGISTER = 'Unirse a la comunidad Tukuykuna.';
    const REGISTER_INPUT = 1;
    const TYPE_CASH_CHECK_DEPOSIT = 0;
    const TYPE_COLLECTION_OF_CARD_COUPONS = 1;
    const TYPE_NEGOTIATED_CHECKS = 1;

    const REGISTER_OUTPUT = 0;
    const TYPE_CASH_WITHDRAWAL = 1;
    const TYPE_BANKING_EXPENSES = 1;
    protected $fillable = array(
        'created_at',
        'updated_at',
        'deleted_at',
        'account_gamification_id',//*
        'amount',//*
        'type',//*
        'input_movement',//*
        'description',//*
        'user_transaction_id',//*
        'type_money',//*
        'gamification_by_process_id'//*

    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'account_gamification_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'amount', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'input_movement', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_transaction_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_money', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'gamification_by_process_id', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],

    ];
    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        $rules = ["account_gamification_id" => "required|numeric",
            "amount" => "required|numeric",
            "type" => "required|numeric",
            "input_movement" => "required|numeric",
            "description" => "required",
            "user_transaction_id" => "required|numeric",
            "type_money" => "required|numeric",
            "gamification_by_process_id" => "required|numeric",

        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getAdminData($params)
    {
        $resultData = $this->getAdmin($params);
        $result = [];
        if ($resultData['total'] > 0) {

            foreach ($resultData['rows'] as $key => $value) {

            }
            $result = $resultData;
        } else {

        }
        return $result;
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $user = Auth::user();
        $user_id = $user->id;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,account_gamification.created_at as account_gamification,
account_gamification.id as account_gamification_id,
$this->table.amount,$this->table.type,$this->table.input_movement,$this->table.description,$this->table.user_transaction_id,$this->table.type_money
,gamification_by_process.icon_class icon_class
,business.id business_id ,business.title business_name
,users.id user_id ,users.name user_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('account_gamification', 'account_gamification.id', '=', $this->table . '.account_gamification_id');
        $query->join('gamification_by_process', 'gamification_by_process.id', '=', $this->table . '.gamification_by_process_id');

        $query->leftJoin(
            'account_gamification_movement_by_business',
            'account_gamification_by_movement.id',
            '=',
            'account_gamification_movement_by_business.account_gamification_by_movement_id'
        );
        $query->leftJoin(
            'business',
            'account_gamification_movement_by_business.business_id',
            '=',
            'business.id'
        );

        $query->leftJoin(
            'users',
            'account_gamification_by_movement.user_transaction_id',
            '=',
            'users.id'
        );

        $query->where('account_gamification.user_id', '=', $user_id);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.amount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.input_movement', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_money', 'like', '%' . $likeSet . '%');
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
            $modelName = 'AccountGamificationByMovement';
            $model = new AccountGamificationByMovement();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AccountGamificationByMovement::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $accountGamificationByMovementData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $accountGamificationByMovementData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AccountGamificationByMovement.";
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
        $query->join('account_gamification', 'account_gamification.id', '=', $this->table . '.account_gamification_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere("account_gamification.created_at", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.amount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.input_movement', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_transaction_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_money', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
