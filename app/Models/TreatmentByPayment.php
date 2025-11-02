<?php

namespace App\Models;

use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Auth;


class TreatmentByPayment extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'treatment_by_payment';

    protected $fillable = array(
        'payment_date',//*
        'state_payment',//*
        'details',
        'types_payments_by_account_id',//*
        'accounting_account_id',
        'user_id',//*
        'treatment_by_breakdown_payment_id',//*
        'treatment_by_indebtedness_paying_init_id'//*

    );
    protected $attributesData = [
        ['column' => 'payment_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state_payment', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'details', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'types_payments_by_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'accounting_account_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'treatment_by_breakdown_payment_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'treatment_by_indebtedness_paying_init_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'payment_date';

    public static function getRulesModel()
    {
        $rules = ["payment_date" => "required",
            "state_payment" => "required|numeric",
            "types_payments_by_account_id" => "required|numeric",
            "accounting_account_id" => "numeric",
            "user_id" => "required|numeric",
            "treatment_by_breakdown_payment_id" => "required|numeric",
            "treatment_by_indebtedness_paying_init_id" => "required|numeric"
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
        $formatDate = '"%d/%m/%Y"';

        $selectString = "$this->table.id,DATE_FORMAT($this->table.payment_date,$formatDate) payment_date ,$this->table.state_payment,$this->table.details,types_payments_by_account.id as types_payments_by_account,
types_payments_by_account.id as types_payments_by_account_id,
$this->table.accounting_account_id,$this->table.user_id,DATE_FORMAT(treatment_by_breakdown_payment.date_agreement,$formatDate) as treatment_by_breakdown_payment,
treatment_by_breakdown_payment.id as treatment_by_breakdown_payment_id,
treatment_by_indebtedness_paying_init.id as treatment_by_indebtedness_paying_init,
treatment_by_indebtedness_paying_init.id as treatment_by_indebtedness_paying_init_id
";
        $treatment_by_indebtedness_paying_init_id = $params['filters']['treatment_by_indebtedness_paying_init_id'];

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('types_payments_by_account', 'types_payments_by_account.id', '=', $this->table . '.types_payments_by_account_id');
        $query->join('treatment_by_breakdown_payment', 'treatment_by_breakdown_payment.id', '=', $this->table . '.treatment_by_breakdown_payment_id');
        $query->join('treatment_by_indebtedness_paying_init', 'treatment_by_indebtedness_paying_init.id', '=', $this->table . '.treatment_by_indebtedness_paying_init_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->where($this->table . '.payment_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.details', 'like', '%' . $likeSet . '%');

            });;

        }
        $query->where($this->table . '.treatment_by_indebtedness_paying_init_id', '=', $treatment_by_indebtedness_paying_init_id);

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
        $user = Auth::user();
        $creation_date = Util::DateCurrent('America/Guayaquil', "Y-m-d");
        $data = [];
        try {
            $modelName = 'TreatmentByPayment';
            $model = new TreatmentByPayment();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TreatmentByPayment::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $treatmentByPaymentData = $attributesPost[$modelName];
            $payment_date_management = $treatmentByPaymentData['payment_date'];
            $attributesSet = $treatmentByPaymentData;
            $user_id = $user->id;
            $attributesSet['user_id'] = $user_id;
            $attributesSet['payment_date'] = $creation_date;
            $treatment_by_breakdown_payment_id = $treatmentByPaymentData['treatment_by_breakdown_payment_id'];
            $treatment_by_indebtedness_paying_init_id = $treatmentByPaymentData['treatment_by_indebtedness_paying_init_id'];
            $state_payment = 1;//
            $dateOne = strtotime($creation_date);
            $dateTwo = strtotime($payment_date_management);


            if ($dateOne >= $dateTwo) {
                $state_payment = 0;//
            } else {
                $state_payment = 1;//

            }
            $attributesSet['state_payment'] = $state_payment;

            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);

            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $modelBreakdown = \App\Models\TreatmentByBreakdownPayment::find($treatment_by_breakdown_payment_id);
                $modelBreakdown->state_payment = 0;
                $modelBreakdown->save();
                $modelBreakdown = new \App\Models\TreatmentByBreakdownPayment();
                $existPaymentsManagement = $modelBreakdown->getExistPayments([
                    'filters' => [
                        'treatment_by_indebtedness_paying_init_id' => $treatment_by_indebtedness_paying_init_id
                    ]]);

                $modelTreatmentInit = \App\Models\TreatmentByIndebtednessPayingInit::find($treatment_by_indebtedness_paying_init_id);
                $treatment_by_patient_id = $modelTreatmentInit->treatment_by_patient_id;
                $number_payments = $modelTreatmentInit->number_payments;
                $allowUpdate = $number_payments == $existPaymentsManagement['numberPayments'];
                $existPaymentsManagement['success'] = false;
                if ($allowUpdate) {
                    $existPaymentsManagement['success'] = true;
                    $modelTreatment = \App\Models\TreatmentByPatient::find($treatment_by_patient_id);
                    $modelTreatment->status = 'ISSUED';
                    $modelTreatment->save();
                }
                $data['PaymentsManagement'] = $existPaymentsManagement;
            } else {
                $success = false;
                $msj = "Problemas al guardar  el pago.";
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
                "success" => $success,
                'data' => $data
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
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
        $query->join('types_payments_by_account', 'types_payments_by_account.id', '=', $this->table . '.types_payments_by_account_id');
        $query->join('treatment_by_breakdown_payment', 'treatment_by_breakdown_payment.id', '=', $this->table . '.treatment_by_breakdown_payment_id');
        $query->join('treatment_by_indebtedness_paying_init', 'treatment_by_indebtedness_paying_init.id', '=', $this->table . '.treatment_by_indebtedness_paying_init_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.payment_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state_payment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.details', 'like', '%' . $likeSet . '%');
                $query->orWhere("types_payments_by_account.id", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.accounting_account_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("treatment_by_breakdown_payment.date_agreement", 'like', '%' . $likeSet . '%');
                $query->orWhere("treatment_by_indebtedness_paying_init.id", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
