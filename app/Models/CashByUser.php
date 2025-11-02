<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class CashByUser extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'cash_by_user';

    protected $fillable = array(
        'user_id',//*
        'business_by_cash_id',//*
        'owner_id',//*
        'entidad_data_id'//*

    );
    protected $attributesData = [
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_by_cash_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'owner_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entidad_data_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public $allowViewPaymentTypeRoles = array(
        "ROL_VENDEDOR","Business"
    );
    public $roleNameCash = "ROL_VENDEDOR";
    public function __construct(array $attributes = [])
    {
        $modelR=new \App\Models\Role();
        $this->allowViewPaymentTypeRoles=array(

            $modelR::ROL_BUSINESS_MANAGER,
            $modelR::ROL_CUSTOMER_MANAGER,
            $modelR::ROL_EMPLOYER_MANAGER,
            $modelR::ROL_RECEPTIONIST_MANAGER,
           'ROL_VENDEDOR',


        );
    }
    public static function getRulesModel()
    {
        $rules = ["user_id" => "required|numeric",
            "business_by_cash_id" => "required|numeric",
            "owner_id" => "required|numeric",
            "entidad_data_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.user_id,$this->table.business_by_cash_id,$this->table.owner_id,$this->table.entidad_data_id";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_by_cash_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.owner_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entidad_data_id', 'like', '%' . $likeSet . '%');
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
            $modelName = 'CashByUser';
            $model = new CashByUser();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = CashByUser::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $cashByUserData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $cashByUserData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  CashByUser.";
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


    public function getAllowProcessByRole($params)
    {
        $success = false;
        $data = array();
        $isSuperAdmin = false;
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();
        if (!$dataUserManager['isSuperAdmin']) {

            $roles = $dataUserManager['roles'];
            $haystack = array();
            if ($params["processName"] == "typeOfPaymentsMixed") {
                $haystack = $this->allowViewPaymentTypeRoles;
            }

            foreach ($roles as $key => $role) {
                if (in_array($role->name, $haystack)) {
                    $success = true;
                    array_push($data, $role);
                }
            }
        } else {
            $success = true;
            $isSuperAdmin = true;
        }
        $result = array(
            "success" => $success,
            "isSuperAdmin" => $isSuperAdmin,
            "data" => $data

        );
        return $result;
    }

    public function getCashUserByCurrent($params)
    {

        $user_id = $params['user_id']; //user MANAGEMENT
        $entidad_data_id = $params["entidad_data_id"];
        $getSelectBeeString = 'users.id  as id,CONCAT(people.name," ",people.last_name,"-",human_resources_employee_profile.identification_document,"-",users.username)as text,users.username,cash.name cash,cash.id cash_id,cash.accounting_account_id
        ,cash_by_user.id cash_by_user_id,cash_by_user.business_by_cash_id';
        $select = DB::raw($getSelectBeeString);
        $query = DB::table('users');
        $query->select($select);
        $query->join('business_by_employee_profile', "users.id", '=', 'business_by_employee_profile.user_id');
        $query->rightJoin('cash_by_user', "users.id", '=', 'cash_by_user.user_id')
            ->join('human_resources_employee_profile', "business_by_employee_profile.human_resources_employee_profile_id", '=', 'human_resources_employee_profile.id')
            ->join('people', "human_resources_employee_profile.people_id", '=', 'people.id')
            ->join('business_by_cash', "cash_by_user.business_by_cash_id", '=', 'business_by_cash.id')
            ->join('cash', "business_by_cash.cash_id", '=', 'cash.id');
        $query->where("cash_by_user.entidad_data_id", '=', $entidad_data_id);
        $query->where("cash_by_user.user_id", '=', $user_id);
        $state = 'ACTIVE';
        $query->where("cash.state", '=', $state);
        $rows = $query->first();
        $result = $rows==null  ? null : $rows;
        return $result;
    }

}
