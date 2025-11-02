<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class MedicalConsultationByPatient extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'medical_consultation_by_patient';

    protected $fillable = array(
        'reason_consultation',
        'status',//*
        'created_at',
        'updated_at',
        'deleted_at',
        'history_clinic_id',//*
        'payment_state',//*
        'user_id',//*
        'prepayment',//*
        'price',
        'description'

    );
    protected $attributesData = [
        ['column' => 'reason_consultation', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'history_clinic_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'payment_state', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'prepayment', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'price', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = true;

    protected $field_main = 'status';

    public static function getRulesModel()
    {
        $rules = ["status" => "required",
            "history_clinic_id" => "required|numeric",
            "payment_state" => "required|numeric",
            "user_id" => "required|numeric",
            "prepayment" => "required|numeric",
            "price" => "required|numeric",
            "description" => "required",

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
        $history_clinic_id = $params['filters']['history_clinic_id'];
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.reason_consultation,$this->table.status,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,history_clinic.status as history_clinic,
history_clinic.id as history_clinic_id,
$this->table.payment_state,$this->table.user_id,$this->table.prepayment,$this->table.price,$this->table.description";
        $user = Auth::user();
        $user_id = $user->id;
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('history_clinic', 'history_clinic.id', '=', $this->table . '.history_clinic_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.reason_consultation', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');


            });;

        }
        $query->where($this->table . '.history_clinic_id', '=', $history_clinic_id);
        $query->where($this->table . '.user_id', '=', $user_id);

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

        try {
            $modelName = 'MedicalConsultationByPatient';
            $model = new MedicalConsultationByPatient();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = MedicalConsultationByPatient::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $medicalConsultationByPatientData = $attributesPost[$modelName];
            $attributesSet = $medicalConsultationByPatientData;
            $attributesSet['user_id'] = $user->id;
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
                $msj = "Problemas al guardar  MedicalConsultationByPatient.";
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
        $query->join('history_clinic', 'history_clinic.id', '=', $this->table . '.history_clinic_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.reason_consultation', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere("history_clinic.status", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.payment_state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
