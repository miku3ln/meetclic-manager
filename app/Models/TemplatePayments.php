<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class TemplatePayments extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'template_payments';
    const TYPE_PAYMENT_PAYPAL = 0;
    const TYPE_PAYMENT_CREDIT_CARDS = 1;
    const TYPE_PAYMENT_BANK_DEPOSIT = 2;
    const TYPE_PAYMENT_PAY_PHONE = 3;
    const TYPE_PAYMENT_PAYMENT_AGAINST_DELIVERY = 4;

    protected $fillable = array(
        'type_payment',//*
        'status',//*
        'template_information_id',//*
        'type_manager',//*
        'user',
        'password',
        'test_id',
        'test_secret',
        'live_id',
        'live_secret',
        'msj_to_customer',
        'manager_type_modal'

    );
    protected $attributesData = [
        ['column' => 'type_payment', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'template_information_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_manager', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'user', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'password', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'test_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'test_secret', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'live_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'live_secret', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'msj_to_customer', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'manager_type_modal', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'status';

    public static function getRulesModel()
    {
        $rules = ["type_payment" => "required|numeric",
            "status" => "required",
            "template_information_id" => "required|numeric",
            "type_manager" => "required|numeric",
            "manager_type_modal" => "required|numeric",
            "user" => "max:150",
            "password" => "max:150"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $template_information_id = $params['filters']['template_information_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.type_payment,$this->table.status,template_information.value as template_information,
template_information.id as template_information_id,$this->table.manager_type_modal,
$this->table.type_manager,$this->table.user,$this->table.password,$this->table.test_id,$this->table.test_secret,$this->table.live_id,$this->table.live_secret,$this->table.msj_to_customer";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where($this->table . '.type_payment', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_manager', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.password', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.test_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.test_secret', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.live_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.live_secret', 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . '.template_information_id', '=', $template_information_id);

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
            $modelName = 'TemplatePayments';
            $model = new TemplatePayments();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TemplatePayments::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $templatePaymentsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templatePaymentsData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            $template_information_id = $attributesSet["template_information_id"];

            if ($success) {

                $type_payment = $attributesSet['type_payment'];
                if ($attributesSet['status'] == 'ACTIVE') {
                    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                        $idCurrent = $attributesPost[$modelName]["id"];
                        TemplatePayments::where('status', 'ACTIVE')
                            ->where('template_information_id', '=', $template_information_id)
                            ->where('type_payment', '=', $type_payment)
                            ->whereNotIn('id', [$idCurrent])
                            ->update(['status' => 'INACTIVE']);
                    } else {
                        TemplatePayments::where('status', 'ACTIVE')
                            ->where('template_information_id', '=', $template_information_id)
                            ->where('type_payment', '=', $type_payment)
                            ->update(['status' => 'INACTIVE']);
                    }
                }

                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  TemplatePayments.";
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
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_payment', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type_manager', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.password', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.test_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.test_secret', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.live_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.live_secret', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getTypesPayments($params)
    {
        $template_information_id = isset($params['filters']['template_information_id']) ? $params['filters']['template_information_id'] : null;
        $result = null;

        if ($template_information_id) {
            $query = DB::table($this->table);
            $selectString = "$this->table.id,$this->table.type_payment,$this->table.status,template_information.value as template_information,
template_information.id as template_information_id,$this->table.manager_type_modal,
$this->table.type_manager,$this->table.user,$this->table.password,$this->table.test_id,$this->table.test_secret,$this->table.live_id,$this->table.live_secret,$this->table.msj_to_customer";
            $select = DB::raw($selectString);
            $query->select($select);
            $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
            $status = isset($params['filters']['status']) ? $params['filters']['status'] : null;
            $type_payment = $params['filters']['type_payment'];
            $query->where($this->table . '.template_information_id', '=', $template_information_id);
            $query->where($this->table . '.type_payment', '=', $type_payment);
            if ($status) {

                $query->where($this->table . '.status', '=', $status);
            }
            $result = $query->first();
        }
        return $result;

    }

    public function getTypesPaymentsData($params)
    {
        $result = [];
        $paramsCurrent = $params;

        $paramsCurrent['filters']['type_payment'] = self::TYPE_PAYMENT_PAYPAL;
        $resultData = $this->getTypesPayments($paramsCurrent);
        $result['pay-pal'] = $resultData;
        $paramsCurrent['filters']['type_payment'] = self::TYPE_PAYMENT_BANK_DEPOSIT;
        $resultData = $this->getTypesPayments($paramsCurrent);
        $result['bank-deposit'] = $resultData;
        $paramsCurrent['filters']['type_payment'] = self::TYPE_PAYMENT_CREDIT_CARDS;
        $resultData = $this->getTypesPayments($paramsCurrent);
        $result['api-credit-cards'] = $resultData;
        $paramsCurrent['filters']['type_payment'] = self::TYPE_PAYMENT_PAY_PHONE;
        $resultData = $this->getTypesPayments($paramsCurrent);
        $result['pay-phone'] = $resultData;
        return $result;

    }
}
