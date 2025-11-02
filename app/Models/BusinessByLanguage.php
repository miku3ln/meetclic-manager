<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Auth;


class BusinessByLanguage extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_language';

    protected $fillable = array(
        'language_id',//*
        'state',//*
        'main',//*
        'business_id'//*

    );
    protected $attributesData = [
        ['column' => 'language_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'main', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'state';

    public static function getRulesModel()
    {
        $rules = ["language_id" => "required|numeric",
            "state" => "required",
            "business_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,language.value as language,$this->table.main,
language.id as language_id,
$this->table.state,business.title as business,
business.id as business_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where("language.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . ".business_id", '=', $business_id);

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
            $modelName = 'BusinessByLanguage';
            $model = new BusinessByLanguage();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByLanguage::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $languageByBusinessData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $languageByBusinessData, 'attributesData' => $this->attributesData));
            $business_id = $attributesSet['business_id'];
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $language_id = $attributesPost[$modelName]["language_id"];
                if ($attributesSet['state'] == 'ACTIVE') {
                    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                        $idCurrent = $attributesPost[$modelName]["id"];
                        BusinessByLanguage::where('state', 'ACTIVE')
                            ->where('business_id', '=', $business_id)
                            ->where('language_id', '=', $language_id)
                            ->whereNotIn('id', [$idCurrent])
                            ->update(['state' => 'INACTIVE']);


                        if ($attributesPost[$modelName]['main'] == 1) {
                            BusinessByLanguage::
                            where('business_id', '=', $business_id)
                                ->whereNotIn('id', [$idCurrent])
                                ->update(['main' => 0]);
                        }
                    } else {
                        BusinessByLanguage::where('state', 'ACTIVE')
                            ->where('business_id', '=', $business_id)
                            ->where('language_id', '=', $language_id)
                            ->update(['state' => 'INACTIVE']);

                        if ($attributesPost[$modelName]['main'] == 1) {
                            BusinessByLanguage::
                            where('business_id', '=', $business_id)
                                ->update(['main' => 0]);

                        }
                    }
                }
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  BusinessByLanguage.";
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
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("language.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getBusinessTax($params)
    {


        $business_id = $params['filters']['business_id'];
        $languageConfig = isset($params['filters']['languageConfig']) ? $params['filters']['languageConfig'] : null;
        $tableConfig = $this->table;
        if (!$languageConfig) {
            $tableConfig = 'language';
        }
        $query = DB::table($tableConfig);
        $selectString = "language.id,language.percentage,language.value";
        $select = DB::raw($selectString);

        $query->select($select);
        if ($languageConfig) {//config business language current

            $query->where($this->table . '.state', '=', 'ACTIVE');
            $query->join('language', 'language.id', '=', $this->table . '.language_id');
            $query->where('language.percentage', '>', 0);
            $query->where($this->table . '.business_id', '=', $business_id);
        } else {
            $query->where('language.percentage', '=', 0);
            $query->where('language.percentage', '=', 'ACTIVE');

        }

        $result = $query->first();

        return $result;

    }

    public function getLanguageAllFrontend($params)
    {
        $textValue = 'language.value text';
        $business_id = $params['filters']['business_id'];
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,language.value,language.initials,language.description,language.state,$this->table.main";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->where($this->table . '.state', '=', 'ACTIVE');
        $query->where($this->table .'.business_id', '=', $business_id);
        $result = $query->get()->toArray();
        return $result;

    }

}
