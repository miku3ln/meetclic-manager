<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Utils\Util;


class TreatmentByPatient extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'treatment_by_patient';

    protected $fillable = array(
        'customer_id',//*
        'invoice_code',//*
        'invoice_value',//*
        'discount_value',
        'status',//*
        'created_at',//*
        'user_id',//*
        'observations',
        'value_taxes',//*
        'subtotal',//*
        'authorization_number',//*
        'invoice_date',//*
        'establishment',//*
        'emission_point',//*
        'mixed_payment',//*
        'has_retention',//*
        'debt',//*
        'freight',//*
        'type_of_discount',//*
        'discount_type_invoice',//*
        'history_clinic_id'//*

    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'discount_value', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ISSUED', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'observations', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'value_taxes', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtotal', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'authorization_number', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'invoice_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'establishment', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'emission_point', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'mixed_payment', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'has_retention', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'debt', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'freight', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_of_discount', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'discount_type_invoice', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'history_clinic_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'invoice_code';

    public static function getRulesModel()
    {
        $rules = ["customer_id" => "required|numeric",
            "invoice_code" => "required|max:45",
            "invoice_value" => "required|numeric",
            "discount_value" => "numeric",
            "status" => "required",
            "created_at" => "required",
            "user_id" => "required|numeric",
            "value_taxes" => "required|numeric",
            "subtotal" => "required|numeric",
            "authorization_number" => "required|max:150",
            "invoice_date" => "required",
            "establishment" => "required|max:3",
            "emission_point" => "required|max:3",
            "mixed_payment" => "required|numeric",
            "has_retention" => "required|numeric",
            "debt" => "required|numeric",
            "freight" => "required|numeric",
            "type_of_discount" => "required|numeric",
            "discount_type_invoice" => "required|numeric",
            "history_clinic_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.customer_id,$this->table.invoice_code,$this->table.invoice_value,$this->table.discount_value,$this->table.status,$this->table.created_at,$this->table.user_id,$this->table.observations,$this->table.value_taxes,$this->table.subtotal,$this->table.authorization_number,$this->table.invoice_date,$this->table.establishment,$this->table.emission_point,$this->table.mixed_payment,$this->table.has_retention,$this->table.debt,$this->table.freight,$this->table.type_of_discount,$this->table.discount_type_invoice,history_clinic.status as history_clinic,
history_clinic.id as history_clinic_id
";
        $history_clinic_id = $params['filters']['history_clinic_id'];
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('history_clinic', 'history_clinic.id', '=', $this->table . '.history_clinic_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.customer_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.invoice_code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.invoice_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.observations', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value_taxes', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.authorization_number', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.invoice_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.establishment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.emission_point', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.mixed_payment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.has_retention', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.debt', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.freight', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_of_discount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_type_invoice', 'like', '%' . $likeSet . '%');
                $query->orWhere("history_clinic.status", 'like', '%' . $likeSet . '%');
            });;

        }
        $query->where("history_clinic.id", '=', $history_clinic_id);

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
        $creation_date = Util::DateCurrent();

        try {
            $modelName = 'TreatmentByPatient';
            $model = new TreatmentByPatient();
            $createUpdate = true;

            $treatmentByPatientData = $attributesPost[$modelName];
            $treatmentByPatientData['created_at'] = $creation_date;
            $treatmentByPatientData['user_id'] = $user->id;

            $attributesSet = $treatmentByPatientData;
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );

            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $treatment_by_patient_id = $model->id;

                $items = $attributesPost[$modelName]['items'];

                foreach ($items as $key => $modelItemRow) {
                    $modelItem = new \App\Models\TreatmentByDetails();
                    $setAttributes = $modelItemRow;
                    $setAttributes['treatment_by_patient_id'] = $treatment_by_patient_id;
                    $paramsValidate = array(
                        'modelAttributes' => $setAttributes,
                        'rules' => $modelItem::getRulesModel(),
                    );

                    $validateResult = $modelItem->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelItem->fill($setAttributes);
                        $modelItem->save();
                    } else {
                        $msj = 'Error al guardar tratamientos items.';

                        throw new \Exception($msj);

                    }
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  TreatmentByPatient.";
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
            DB::rollBack();
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
        $query->join('history_clinic', 'history_clinic.id', '=', $this->table . '.history_clinic_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.customer_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.invoice_code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.invoice_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.observations', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value_taxes', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.authorization_number', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.invoice_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.establishment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.emission_point', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.mixed_payment', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.has_retention', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.debt', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.freight', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_of_discount', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.discount_type_invoice', 'like', '%' . $likeSet . '%');
                $query->orWhere("history_clinic.status", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getLogHistoryClinic($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.customer_id,$this->table.invoice_code,$this->table.invoice_value,$this->table.discount_value,$this->table.status,$this->table.created_at,$this->table.user_id,$this->table.observations,$this->table.value_taxes,$this->table.subtotal,$this->table.authorization_number,$this->table.invoice_date,$this->table.establishment,$this->table.emission_point,$this->table.mixed_payment,$this->table.has_retention,$this->table.debt,$this->table.freight,$this->table.type_of_discount,$this->table.discount_type_invoice,history_clinic.status as history_clinic,
history_clinic.id as history_clinic_id
";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('history_clinic', 'history_clinic.id', '=', $this->table . '.history_clinic_id');
        $history_clinic_id = $params['history_clinic_id'];
        $query->where($this->table . '.history_clinic_id', '=', $history_clinic_id);
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;
    }
}
