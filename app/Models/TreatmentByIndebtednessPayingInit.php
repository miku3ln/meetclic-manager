<?php

namespace App\Models;

use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Auth;


class TreatmentByIndebtednessPayingInit extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'treatment_by_indebtedness_paying_init';

    protected $fillable = array(
        'number_payments',//*
        'user_id',//*
        'treatment_by_patient_id'//*

    );
    protected $attributesData = [
        ['column' => 'number_payments', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'treatment_by_patient_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["number_payments" => "required|numeric",
            "user_id" => "required|numeric",
            "treatment_by_patient_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.number_payments,$this->table.user_id,treatment_by_patient.invoice_code as treatment_by_patient,
treatment_by_patient.id as treatment_by_patient_id
,treatment_by_breakdown_payment.id treatment_by_breakdown_payment,treatment_by_breakdown_payment.date_agreement ,treatment_by_breakdown_payment.payment_value,treatment_by_breakdown_payment.state_payment
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('treatment_by_patient', 'treatment_by_patient.id', '=', $this->table . '.treatment_by_patient_id');
        $query->join('treatment_by_breakdown_payment', $this->table . '.id', '=', 'treatment_by_breakdown_payment.treatment_by_indebtedness_paying_init_id');

        $treatment_by_indebtedness_paying_init_id = ($params['filters']['treatment_by_patient_id']);
        $query->where('treatment_by_patient.id', '=', $treatment_by_indebtedness_paying_init_id);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

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
        $user = Auth::user();
        $creation_date = Util::DateCurrent();
        $data = [];
        try {
            $modelName = 'TreatmentByIndebtednessPayingInit';
            $model = new TreatmentByIndebtednessPayingInit();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TreatmentByIndebtednessPayingInit::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }
            $user_id = $user->id;
            $treatmentByIndebtednessPayingInitData = $attributesPost[$modelName];
            $treatment_by_patient_id = $treatmentByIndebtednessPayingInitData['treatment_by_patient_id'];

            $attributesSet = $treatmentByIndebtednessPayingInitData;
            $attributesSet['user_id'] = $user_id;
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $treatment_by_indebtedness_paying_init_id = $model->id;
                $items = $attributesPost[$modelName]['items'];
                foreach ($items as $key => $modelItemRow) {
                    $modelItem = new \App\Models\TreatmentByBreakdownPayment();
                    $setAttributes = $modelItemRow;
                    $setAttributes['treatment_by_indebtedness_paying_init_id'] = $treatment_by_indebtedness_paying_init_id;
                    $setAttributes['user_id'] = $user_id;
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
                        $msj = 'Error al guardar fechas de pagos.';
                        throw new \Exception($msj);

                    }
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar  TreatmentByIndebtednessPayingInit.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $model = new TreatmentByIndebtednessPayingInit();
                $data['TreatmentByIndebtednessPayingInit'] = $model->getManagement([
                    'filters' => [
                        'treatment_by_patient_id' => $treatment_by_patient_id
                    ]
                ]);
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
            DB::rollBack();
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
        $query->join('treatment_by_patient', 'treatment_by_patient.id', '=', $this->table . '.treatment_by_patient_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.number_payments', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("treatment_by_patient.invoice_code", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getManagement($params)
    {
        $treatment_by_patient_id = $params['filters']['treatment_by_patient_id'];
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.number_payments,$this->table.id as treatment_by_indebtedness_paying_init_id,$this->table.treatment_by_patient_id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.treatment_by_patient_id', '=', $treatment_by_patient_id);
        $result = $query->get()->first();
        return $result;

    }

}
