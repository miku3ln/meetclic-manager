<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class InformationPhone extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'information_phone';
    const MAIN = 1;
    const NOT_MAIN = 0;

    const ENTITY_TYPE_CUSTOMER = 0;
    protected $fillable = array(
        'value',//*
        'state',//*
        'entity_id',//*
        'main',//*
        'entity_type',//*
        'information_phone_operator_id',//*
        'information_phone_type_id'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'main', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'entity_type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'information_phone_operator_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'information_phone_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getInformationByParams($params)
    {


        $information_phone_type_id = $params['information_phone_type_id'];
        $information_phone_operator_id = $params['information_phone_operator_id'];
        $entity_id = $params['entity_id'];
        $main = $params['main'];
        $entity_type = $params['entity_type'];

        $query = DB::table('information_phone');
        $selectString = "*";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where(
            [
                ["information_phone.information_phone_operator_id", '=', $information_phone_operator_id],
                ["information_phone.information_phone_type_id", '=', $information_phone_type_id],
                ["information_phone.entity_id", '=', $entity_id],
                ["information_phone.entity_type", '=', $entity_type],
                ["information_phone.main", '=', $main]]
        );


        $data = $query->first();
        return $data;
    }

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:150",
            "state" => "required",
            "entity_id" => "required|numeric",
            "main" => "required|numeric",
            "entity_type" => "required|numeric",
            "information_phone_operator_id" => "required|numeric",
            "information_phone_type_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'desc';
        $field = 'main';
        $query = DB::table($this->table);
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;


        if (isset($params['sort'])) {
            /*    $field = $column = array_keys($params['sort']);
                $field = $field[0];
                $sort = $params['sort'][$column[0]];*/
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,information_phone_operator.value as information_phone_operator,
information_phone_operator.id as information_phone_operator_id,
information_phone_type.value as information_phone_type,
information_phone_type.id as information_phone_type_id
";
        if ($entity_id != null && $entity_type != null) {

            $query->where(
                $this->table . '.entity_id', '=', $entity_id
            );
            $query->where(
                $this->table . '.entity_type', '=', $entity_type

            );
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', $this->table . '.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=', $this->table . '.information_phone_type_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.main', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_operator.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_type.value", 'like', '%' . $likeSet . '%');;

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
            $modelName = 'InformationPhone';
            $model = new InformationPhone();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InformationPhone::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $informationPhoneData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $informationPhoneData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {


                if (!$createUpdate) {

                    if ($attributesSet['main']) {

                        $entity_id = $attributesSet['entity_id'];
                        $information_phone_operator_id = $attributesSet['information_phone_operator_id'];
                        $information_phone_type_id = $attributesSet['information_phone_type_id'];
                        $entity_type = $attributesSet['entity_type'];
                        $dataInformation = InformationPhone::where('entity_type', $entity_type)
                            ->where('entity_id', $entity_id)
                            ->where('information_phone_operator_id', $information_phone_operator_id)
                            ->where('information_phone_type_id', $information_phone_type_id)
                            ->where('state', self::STATE_ACTIVE)
                            ->where('main', 1)->update(['main' => 0]);
                    }
                }
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  InformationPhone.";
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
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', $this->table . '.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=', $this->table . '.information_phone_type_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_operator.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_type.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getInformation($params)
    {
        $information_phone_operator_id = isset($params['filters']['information_phone_operator_id']) ? $params['filters']['information_phone_operator_id'] : null;
        $information_phone_type_id = isset($params['filters']['information_phone_type_id']) ? $params['filters']['information_phone_type_id'] : null;
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;

        $query = DB::table($this->table);
        $selectString = "$this->table.id information_phone_id,$this->table.value information_phone,$this->table.state information_phone_state
        ,information_phone_operator.id information_phone_operator_id,information_phone_operator.value information_phone_operator
        ,information_phone_type.id information_phone_type_id,information_phone_type.value information_phone_type  ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', $this->table . '.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=', $this->table . '.information_phone_type_id');
        if ($information_phone_operator_id) {
            $query->where('information_phone_operator_id', '=', $information_phone_operator_id);

        }
        if ($information_phone_type_id) {
            $query->where($this->table.'.information_phone_type_id', '=', $information_phone_type_id);

        }
        if ($entity_id) {
            $query->where($this->table.'.entity_id', '=', $entity_id);

        }
        if ($state) {
            $query->where($this->table.'.state', '=', $state);

        }
        if ($main) {
            $query->where($this->table.'.main', '=', $main);

        }
        if ($entity_type) {
            $query->where($this->table.'.entity_type', '=', $entity_type);

        }
        $result = $query->first();
        return $result;

    }
    public function getInformationData($params)
    {
        $information_phone_operator_id = isset($params['filters']['information_phone_operator_id']) ? $params['filters']['information_phone_operator_id'] : null;
        $information_phone_type_id = isset($params['filters']['information_phone_type_id']) ? $params['filters']['information_phone_type_id'] : null;
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;

        $query = DB::table($this->table);
        $selectString = "$this->table.id information_phone_id,$this->table.value information_phone,$this->table.state information_phone_state
        ,information_phone_operator.id information_phone_operator_id,information_phone_operator.value information_phone_operator
        ,information_phone_type.id information_phone_type_id,information_phone_type.value information_phone_type  ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', $this->table . '.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=', $this->table . '.information_phone_type_id');
        if ($information_phone_operator_id) {
            $query->where('information_phone_operator_id', '=', $information_phone_operator_id);

        }
        if ($information_phone_type_id) {
            $query->where($this->table.'.information_phone_type_id', '=', $information_phone_type_id);

        }
        if ($entity_id) {
            $query->where($this->table.'.entity_id', '=', $entity_id);

        }
        if ($state) {
            $query->where($this->table.'.state', '=', $state);

        }
        if ($main) {
            $query->where($this->table.'.main', '=', $main);

        }
        if ($entity_type) {
            $query->where($this->table.'.entity_type', '=', $entity_type);

        }
        $result = $query->get()->toArray();
        return $result;

    }
    public function getListDataEntity($params)
    {
        $information_phone_operator_id = isset($params['filters']['information_phone_operator_id']) ? $params['filters']['information_phone_operator_id'] : null;
        $information_phone_type_id = isset($params['filters']['information_phone_type_id']) ? $params['filters']['information_phone_type_id'] : null;
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;

        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id information_phone_id,$this->table.value information_phone,$this->table.state information_phone_state
        ,information_phone_operator.id information_phone_operator_id,information_phone_operator.value information_phone_operator
        ,information_phone_type.id information_phone_type_id,information_phone_type.value information_phone_type
          ,$this->table.id ,$this->table.value text";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', $this->table . '.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=', $this->table . '.information_phone_type_id');

        if ($information_phone_operator_id) {
            $query->where('information_phone_operator_id', '=', $information_phone_operator_id);

        }
        if ($information_phone_type_id) {
            $query->where($this->table.'.information_phone_type_id', '=', $information_phone_type_id);

        }
        if ($entity_id) {
            $query->where($this->table.'.entity_id', '=', $entity_id);

        }
        if ($state) {
            $query->where($this->table.'.state', '=', $state);

        }
        if ($main) {
            $query->where($this->table.'.main', '=', $main);

        }
        if ($entity_type) {
            $query->where($this->table.'.entity_type', '=', $entity_type);

        }
        if (isset($params["filters"]['search_value'])) {

            $likeSet = $params["filters"]['search_value'];

            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_operator.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_type.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
}
