<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class AccountGamification extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'account_gamification';

    protected $fillable = array(
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',//*
        'balance_available_bee',//*
        'balance_available_queen'//*

    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'balance_available_bee', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'balance_available_queen', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'created_at';

    public static function getRulesModel()
    {
        $rules = ["user_id" => "required|numeric",
            "balance_available_bee" => "required|numeric",
            "balance_available_queen" => "required|numeric"
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
        $selectString = "$this->table.id,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.user_id,$this->table.balance_available_bee
$this->table.balance_available_queen";

        $select = DB::raw($selectString);
        $query->select($select);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.balance_available_bee', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.balance_available_queen', 'like', '%' . $likeSet . '%');
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
            $modelName = 'AccountGamification';
            $model = new AccountGamification();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = AccountGamification::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $accountGamificationData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $accountGamificationData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  AccountGamification.";
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
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.balance_available_bee', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.balance_available_queen', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function managerUserRegister($params)
    {
        $success = false;
        $msj = '';
        $errors = [];
        $resultAllow = $this->getAllowAddMovementRegisterUser($params);
        if (!$resultAllow) {
            $resultMovement = $this->setAddMovementRegisterUser($params);
            if (!$resultMovement['success']) {
                $success = $resultMovement['success'];
                $msj = $resultMovement['msj'];
                $errors = $resultMovement['errors'];

            } else {
                $success = true;
                $msj = 'Account Ready.';

            }

        } else {
            $success = true;
            $msj = 'Account Ready.';

        }
        $result = [
            'success' => $success,
            'msj' => $msj,
            'errors' => $errors
        ];
        return $result;
    }

    public function getAllowAddMovementRegisterUser($params)
    {
        $user_id = $params['filters']['user_id'];
        $textValue = "$this->table.id," . $this->table . '.balance_available_bee,' . $this->table . '.balance_available_queen';
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.user_id', '=', $user_id);
        $result = $query->first();
        return $result;

    }


    public function setAddMovementRegisterUser($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $errors = array();
        $user_id = $params['filters']['user_id'];
        $byBusinessAdd = isset($params['filters']['byBusinessAdd']) ? $params['filters']['byBusinessAdd'] : false;
        DB::beginTransaction();
        try {
            $modelName = 'AccountGamification';
            $model = new AccountGamification();
            $modelMovement = new \App\Models\AccountGamificationByMovement();
            $codeOne = "CE-009";
            $codeTwo = "CE-010";
            $modelTaskGamification = new \App\Models\GamificationByProcess();
            $modelAGBMOne = $modelTaskGamification->findByAttribute("unique_code", $codeOne);
            $modelAGBMTwo = $modelTaskGamification->findByAttribute("unique_code", $codeTwo);


            $balance_available_bee = $modelMovement::AMOUNT_BEE_REGISTER;
            $balance_available_queen = $modelMovement::AMOUNT_QUEEN_REGISTER;

            $gamification_by_process_id_one = null;
            $gamification_by_process_id_two = null;

            if ($modelAGBMOne) {
                $gamification_by_process_id_one = $modelAGBMOne->id;

                $modelPoints = new \App\Models\GamificationByPoints();
                $modelPointsData = $modelPoints->findByAttribute("gamification_by_process_id", $gamification_by_process_id_one);
                if ($modelPointsData) {
                    $balance_available_bee = $modelPointsData->points;

                }
            }
            if ($modelAGBMTwo) {
                $gamification_by_process_id_two = $modelAGBMTwo->id;
                $modelPoints = new \App\Models\GamificationByPoints();
                $modelPointsData = $modelPoints->findByAttribute("gamification_by_process_id", $gamification_by_process_id_two);
                if ($modelPointsData) {
                    $balance_available_queen = $modelPointsData->points;

                }
            }
            $attributesSet = [
                'user_id' => $user_id,
                'balance_available_bee' => $balance_available_bee,
                'balance_available_queen' => $balance_available_queen,
            ];
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];

            if ($success) {
                $user_transaction_id = $modelMovement::USER_ID_MAIN;
                $model->fill($attributesSet);
                $success = $model->save();
                $account_gamification_id = $model->id;

                $business_id = $modelMovement::BUSINESS_MAIN_ID;
                $modelMovement = new \App\Models\AccountGamificationByMovement();
                $type_money = $modelMovement::TYPE_MONEY_BEE;
                $attributesSetOne = [
                    'amount' => $balance_available_bee,
                    'type' => $modelMovement::TYPE_CASH_CHECK_DEPOSIT,
                    'input_movement' => $modelMovement::REGISTER_INPUT,
                    'description' => $modelMovement::DESCRIPTION_REGISTER,
                    'user_transaction_id' => $user_transaction_id,
                    'type_money' => $type_money,
                    'account_gamification_id' => $account_gamification_id,
                    "gamification_by_process_id" => $gamification_by_process_id_one
                ];
                $paramsValidate = array(
                    'modelAttributes' => $attributesSetOne,
                    'rules' => $modelMovement::getRulesModel(),

                );
                $validateResult = $modelMovement->validateModel($paramsValidate);

                $success = $validateResult["success"];
                $modelMovementTwo = new \App\Models\AccountGamificationByMovement();
                $type_money = $modelMovement::TYPE_MONEY_QUEEN;
                $account_gamification_id = $model->id;
                $attributesSetTwo = [
                    'amount' => $balance_available_queen,
                    'type' => $modelMovement::TYPE_CASH_CHECK_DEPOSIT,
                    'input_movement' => $modelMovement::REGISTER_INPUT,
                    'description' => $modelMovement::DESCRIPTION_REGISTER,
                    'user_transaction_id' => $user_transaction_id,
                    'type_money' => $type_money,
                    'account_gamification_id' => $account_gamification_id,
                    "gamification_by_process_id" => $gamification_by_process_id_two
                ];
                $paramsValidate = array(
                    'modelAttributes' => $attributesSetTwo,
                    'rules' => $modelMovement::getRulesModel(),

                );
                $validateResult = $modelMovementTwo->validateModel($paramsValidate);

                $successTwo = $validateResult["success"];
                if ($success && $successTwo) {
                    $modelMovement->fill($attributesSetOne);
                    $success = $modelMovement->save();
                    $modelMovementTwo->fill($attributesSetTwo);
                    $successTwo = $modelMovementTwo->save();

                    $account_gamification_by_movement_id = $modelMovement->id;
                    $account_gamification_by_movement_idTwo = $modelMovementTwo->id;

                    if ($byBusinessAdd) {
                        $modelMovementBusiness = new \App\Models\AccountGamificationMovementByBusiness();
                        $attributesSetOne = [
                            'account_gamification_by_movement_id' => $account_gamification_by_movement_id,
                            'business_id' => $business_id,
                        ];
                        $paramsValidate = array(
                            'modelAttributes' => $attributesSetOne,
                            'rules' => $modelMovementBusiness::getRulesModel(),

                        );
                        $validateResult = $modelMovementBusiness->validateModel($paramsValidate);
                        $success = $validateResult["success"];


                        $modelMovementBusinessTwo = new \App\Models\AccountGamificationMovementByBusiness();
                        $attributesSetTwo = [
                            'account_gamification_by_movement_id' => $account_gamification_by_movement_idTwo,
                            'business_id' => $business_id,
                        ];
                        $paramsValidate = array(
                            'modelAttributes' => $attributesSetTwo,
                            'rules' => $modelMovementBusinessTwo::getRulesModel(),

                        );
                        $validateResult = $modelMovementBusinessTwo->validateModel($paramsValidate);
                        $successTwo = $validateResult["success"];

                        if ($success && $successTwo) {
                            $modelMovementBusiness->fill($attributesSetOne);
                            $success = $modelMovementBusiness->save();


                            $modelMovementBusinessTwo->fill($attributesSetTwo);
                            $successTwo = $modelMovementBusinessTwo->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar  Movimiento Bee Qulqui.";
                            $errors = $validateResult["errors"];
                            $result = array(
                                "success" => $success,
                                "msj" => $msj,
                                "errors" => $errors
                            );

                            return ($result);

                        }

                    }


                } else {
                    $success = false;
                    $msj = "Problemas al guardar  Movimiento Bee Qulqui.";
                    $errors = $validateResult["errors"];
                    $result = array(
                        "success" => $success,
                        "msj" => $msj,
                        "errors" => $errors
                    );
                    return ($result);


                }



            } else {
                $success = false;
                $msj = "Problemas al guardar  Cuenta Qulqui.";
                $errors = $validateResult["errors"];
                $result = array(
                    "success" => $success,
                    "msj" => $msj,
                    "errors" => $errors
                );
                return ($result);

            }

            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success
            ];
            if ($success) {
                DB::commit();
            } else {
                DB::rollback();
            }

            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            DB::rollback();
            return ($result);
        }

    }
}
