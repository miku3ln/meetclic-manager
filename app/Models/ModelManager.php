<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ModelManager extends Model
{
    public function getAttributesData()
    {
        return $this->attributesData;
    }

    public function getStringSelect($params)
    {
        $viewTableIndex = false;
        $viewTableName = "";

        if (isset($params["viewTableIndex"])) {
            $viewTableIndex = true;
            $viewTableName = $params["alias"];

        }

        $table = $this->getTable(); // 'FINA_PRODUCTOS'

        $selectFields = array_map(function ($field) use ($table, $viewTableIndex, $viewTableName) {
            if ($viewTableIndex) {
                $valueReturn="";
                if ($viewTableName)
                    if ($viewTableName == "") {
                        $valueReturn="{$table}.{$field}";
                    } else {
                        $valueReturn="{$viewTableName}.{$field} AS $field";

                    }
                return $valueReturn;
            } else {
                return $field;
            }
        }, $this->fillable);

        return implode(', ', $selectFields);
    }

    function removeDuplicateFields($inputString)
    {
        // 1. Convertir la cadena en array y eliminar espacios
        $fields = array_map('trim', explode(',', $inputString));

        // 2. Eliminar duplicados
        $uniqueFields = array_unique($fields);

        // 3. Devolver como string separado por coma
        return implode(', ', $uniqueFields);
    }

    public function generateEntityNames()
    {

        $tableName = $this->table;

        // Convert to camel case (SecretaryProcessesByCustomerPresentation)
        $model = str_replace(' ', '', ucwords(str_replace('_', ' ', $tableName)));

        // Lowercase the first character for model variable ($model)
        $camelCase = lcfirst($model);

        // Convert to kebab case (secretary-processes-by-customer-presentation)
        $kebabCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $camelCase));

        // Convert to snake case (secretary_processes_by_customer_presentation)
        $snakeCase = strtolower($tableName);

        return [
            "model" => $model,
            "entityCamel" => $camelCase,
            "entity-process" => $kebabCase,
            "entity-process-down" => $snakeCase,
        ];
    }

    public static function validateModel($params)
    {
        $messages = [
            'same' => env('validation.same'),
            'size' => env('validation.size'),
            'between' => env('validation.between'),
            'in' => env('validation.in'),
            'required' => env('validation.required'),
            'unique' => env('validation.unique'),
            'email' => env('validation.email'),

        ];

        $modelAttributes = [];
        $rules = [];
        if (!isset($params['inputs']) && !isset($params['modelAttributes'])) {
            $modelAttributes = $params;
        } else if (isset($params['modelAttributes'])) {
            $modelAttributes = $params['modelAttributes'];
        } else if (isset($params['inputs'])) {
            $modelAttributes = $params['inputs'];
        }

        if (isset($params['rules'])) {
            $rules = $params['rules'];
        } else {
            $rules = self::getRulesModel();

        }

        $validation = Validator::make($modelAttributes, $rules, $messages);
        $success = $validation->passes();
        $errors = [];
        $errorsFields = [];
        if (!$success) {
            $errors = $validation->errors()->all();
            $errorsObject = $validation->errors();
            foreach ($errorsObject->messages() as $error => $value) {
                $errorsFields[$error] = $value;
            }
        }
        $result = array("success" => $success, "errors" => $errors, 'errorsFields' => $errorsFields);


        return $result;
    }

    public static function getValuesModel($params)
    {
        $valuesFillAble = $params['fillAble'];
        $valuesHaystack = $params['haystack'];//this post
        $valuesAttributesData = $params['attributesData'];//this post
        $type = isset($params['type']) ? $params['type'] : null;//this post
        $result = array();

        foreach ($valuesFillAble as $key => $value) {


            $allowAdd = isset($valuesHaystack[$value]);

            if ($allowAdd) {
                $needle = $value;
                $resultAdd = self::getManagerValuesDefault(array(
                    'haystack' => $valuesAttributesData,
                    'needle' => $needle,

                ));
                if ($resultAdd['currentRequired']) {
                    $keyAttributes = $value;
                    $valueAttributes = $valuesHaystack[$value];
                    $result[$keyAttributes] = $valueAttributes;


                } else {
                    $keyAttributes = $value;
                    $valueAttributes = $valuesHaystack[$value];
                    $result[$keyAttributes] = $valueAttributes;
                }

            }
        }

        return $result;
    }

    public static function getManagerValuesDefault($params)
    {
        $haystack = $params['haystack'];
        $needle = $params['needle'];
        $currentValueDefault = null;
        $currentRequired = false;
        foreach ($haystack as $key => $value) {
            $column = $value['column'];
            $type = $value['type'];
            $required = $value['required'];

            $defaultValue = $value['defaultValue'] ?? "";

            if ($column == $needle) {
                $currentRequired = $required == 'true' ? true : false;
                if ($type != self::TYPE_IS_NOT_NUMBER) {
                    if (!$currentRequired) {
                        if ($defaultValue == '') {
                            $currentValueDefault = self::NUMBER_NOT_DEFAULT;
                        }
                    }
                }

                break;
            }
        }
        $result = array(
            'currentRequired' => $currentRequired,
            'currentValueDefault' => $currentValueDefault,

        );
        return $result;
    }

    const NUMBER_NOT_DEFAULT = 0;
    const STRING_NOT_DEFAULT = 0;
    const TYPE_IS_NOT_NUMBER = 'string';

    public function findByAttribute($attribute, $value, $columns = array('*'))
    {

        $result = DB::table($this->table)
            ->select($columns)
            ->where($attribute, "=", $value)
            ->first();


        return $result;
    }

    public function findByAttributes($arrayParams, $params = [])
    {
        $selectString = isset($params['columnsSelect']) ? $params['columnsSelect'] : '*';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);
        foreach ($arrayParams as $key => $value) {
            $query->where($key, "=", $value);
        }

        $result = $query->first();
        return $result;
    }

    public function findByPk($id)
    {
        $selectString = isset($params['columnsSelect']) ? $params['columnsSelect'] : '*';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);
        $query->where('id', "=", $id);


        $result = $query->first();
        return $result;
    }

    public function validate($params = [])
    {

        $attributesSet = $this->attributes;

        $rulesCurrent = $this->getRulesModel();
        $paramsValidate = array(
            'inputs' => $attributesSet,
            'rules' => $rulesCurrent,

        );
        $result = $this->validateModel($paramsValidate);
        return $result;
    }

    public function getDataValuesModel($params = [])
    {

        $result = $this->attributes;
        return $result;
    }

    public function getAttributesDataCurrent()
    {
        $columns = $this->getFillable();
        // Another option is to get all columns for the table like so:
        // $columns = \Schema::getColumnListing($this->table);
        // but it's safer to just get the fillable fields

        $attributes = $this->getAttributes();

        foreach ($columns as $column) {
            if (!array_key_exists($column, $attributes)) {
                $attributes[$column] = null;
            }
        }
        return $attributes;
    }

    public function findAllByAttributes($arrayParams, $params = [])
    {
        $typeObject = isset($params['typeObject']) ? $params['typeObject'] : false;
        $selectString = isset($params['columnsSelect']) ? $params['columnsSelect'] : '*';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);

        foreach ($arrayParams as $key => $value) {

            $query->where($key, "=", $value);
        }
        if ($typeObject) {

            $result = $query->get();
        } else {
            $result = $query->get()->toArray();

        }

        return $result;
    }

    public $fieldsSetCustom = [
        "created_at", "updated_at", "deleted_at"
    ];

    public function getValuesByPost($postData, $type = false)
    {

        $result = array();
        $fillableCurrent = $this->fillable;

        foreach ($fillableCurrent as $key => $value) {

            if (isset($postData[$value])) {
                if ($postData[$value] != -1 && $postData[$value] != '-1') {

                    $result [$value] = $postData[$value];
                }


            } else {
                $dateCustomAllow = in_array($value, $this->fieldsSetCustom);

                if ($value != "id") {

                    if ($dateCustomAllow) {
                        $valueManager = null;
                        switch ($value) {
                            case ("created_at"):


                                if ($type) {

                                    $timestamp = time();
                                    $dateSet = date("Y-m-d H:i:s", $timestamp);
                                    $valueManager = $dateSet;
                                }
                                break;
                            case ("updated_at"):
                                if (!$type) {

                                    $timestamp = time();
                                    $dateSet = date("Y-m-d H:i:s", $timestamp);
                                    $valueManager = $dateSet;
                                }
                                break;
                        }

                        $result [$value] = $valueManager;

                    } else {

                        $result [$value] = -1;
                    }
                }
            }
        }

        return $result;
    }

    public function setFilterQueryAdmin($query, $fieldOrder, $typeOrder, $params)
    {
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
        // sort
        $query->orderBy($fieldOrder, $typeOrder);
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
        return [
            'total' => $total,
            'current_page' => $current_page,
            'data' => $data
        ];
    }

    public function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $this->modelNameEntity . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $this->modelNameEntity . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $this->modelNameEntity . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity . "s";
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->getCamelCase();
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }

    public function getCamelCase()
    {

        return lcfirst($this->getUpperCaseTable($this->table));
    }

    public function getFieldsCurrentModel($params = [])
    {
        $nameTableCurrent = $this->table;
        if (isset($params['nameTable'])) {
            $nameTableCurrent = $params['nameTable'];
        }
        $dataFields = $this->fillable;
        $result = '';
        $countData = count($dataFields);
        $countAux = 0;
        foreach ($dataFields as $key => $value) {
            $result .= $nameTableCurrent . '.' . $value;
            if ($countAux == $countData - 1) {
                $result .= '';
            } else {
                $result .= ',';

            }
            $countAux++;
        }
        return $result;
    }
}
