<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class AntecedentByHistoryClinic extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'antecedent_by_history_clinic';

    protected $fillable = array(
        'history_clinic_id',//*
        'antecedent_id',//*
        'description'

    );
    protected $attributesData = [
        ['column' => 'history_clinic_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'antecedent_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        $rules = ["history_clinic_id" => "required|numeric",
            "antecedent_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'antecedent.name';
        $query = DB::table($this->table);
        $selectString = "$this->table.id,history_clinic.status as history_clinic,
history_clinic.id as history_clinic_id,
antecedent.name as antecedent,
antecedent.id as antecedent_id,
$this->table.description";
        $history_clinic_id = $params['history_clinic_id'];
        $select = DB::raw($selectString);
        $query->select($select);
        $query->rightJoin('history_clinic', function ($join) use ($history_clinic_id) {
            $join->on('antecedent_by_history_clinic.history_clinic_id', '=', 'history_clinic.id');
            $join->where('antecedent_by_history_clinic.history_clinic_id', '=', $history_clinic_id);

        });
        $query->rightJoin('antecedent', 'antecedent.id', '=', $this->table . '.antecedent_id');

// sort
        $query->orderBy($field, $sort);
        $result = ['data' => $query->get()->toArray(), 'success' => true];

        return $result;
    }


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];

        DB::beginTransaction();
        try {
            $modelName = 'AntecedentByHistoryClinic';

            $createUpdate = true;

            $dataManagement = $attributesPost['data'];
            $history_clinic_id = $attributesPost['history_clinic_id'];
            $success = true;
            foreach ($dataManagement as $key => $attributes) {

                if ($attributes['isNew'] == 'true' && $attributes['selected'] == 'true') {
                    $model = new AntecedentByHistoryClinic();
                    $attributesSet = $attributes;
                    $attributesSet['history_clinic_id'] = $history_clinic_id;
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
                        $msj = "Problemas al guardar  AntecedentByHistoryClinic.";
                        $errors = $validateResult["errors"];

                    }
                } else {
                    if ($attributes['isNew'] =='false') {//no selecionado
                        if ($attributes['delete'] == 'true') {
                            $model = AntecedentByHistoryClinic::find($attributes['id']);
                            if ($model) {
                                $model->delete();
                            }
                        }
                    }


                }
            }


            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
                $data = [
                    'antecedents' => $this->getAdmin([
                        'history_clinic_id' => $history_clinic_id
                    ])
                ];
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
        $query->join('antecedent', 'antecedent.id', '=', $this->table . '.antecedent_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("history_clinic.status", 'like', '%' . $likeSet . '%');
                $query->orWhere("antecedent.name", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
    public function getLogHistoryClinic($params)
    {
        $sort = 'asc';
        $field = 'antecedent.name';
        $query = DB::table($this->table);
        $selectString = "$this->table.id,history_clinic.status as history_clinic,
history_clinic.id as history_clinic_id,
antecedent.name as antecedent,
antecedent.id as antecedent_id,
$this->table.description";
        $history_clinic_id = $params['history_clinic_id'];
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('history_clinic', function ($join) use ($history_clinic_id) {
            $join->on('antecedent_by_history_clinic.history_clinic_id', '=', 'history_clinic.id');
            $join->where('antecedent_by_history_clinic.history_clinic_id', '=', $history_clinic_id);

        });
        $query->join('antecedent', 'antecedent.id', '=', $this->table . '.antecedent_id');

// sort
        $query->orderBy($field, $sort);
        $result =$query->get()->toArray();

        return $result;
    }
}
