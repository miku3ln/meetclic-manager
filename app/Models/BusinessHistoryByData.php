<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Multimedia;

class BusinessHistoryByData extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_history_by_data';

    protected $fillable = array(
        'title',//*
        'description',//*
        'status',//*
        'source',
        'allow_source',//*
        'business_by_history_id',//*
        'title_icon'

    );
    protected $attributesData = [
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'false'],
        ['column' => 'allow_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'business_by_history_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'title_icon', 'type' => 'string', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'title';

    public static function getRulesModel()
    {
        $rules = ["title" => "required",
            "description" => "required",
            "status" => "required",
            "source" => "max:350",
            "allow_source" => "required|numeric",
            "business_by_history_id" => "required|numeric",
            "title_icon" => "max:15"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $business_by_history_id = $params['filters']['business_by_history_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.title,$this->table.description,$this->table.status,$this->table.source,$this->table.allow_source,business_by_history.value as business_by_history,
business_by_history.id as business_by_history_id,
$this->table.title_icon";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_history', 'business_by_history.id', '=', $this->table . '.business_by_history_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');


            $query->orWhere("business_by_history.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title_icon', 'like', '%' . $likeSet . '%');

        }
        $query->where($this->table . '.business_by_history_id', '=', $business_by_history_id);

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
            $modelName = 'BusinessHistoryByData';
            $model = new BusinessHistoryByData();
            $createUpdate = true;
            $auxResource = "";

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = BusinessHistoryByData::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source;

            } else {
                $createUpdate = true;

            }

            $BusinessHistoryByDataData = $attributesPost;


            $modelMultimedia = new Multimedia;
            $business_by_history_id = $attributesPost["business_by_history_id"];
            $allow_source = $attributesPost["allow_source"];
            $successMultimediaModel = array();
            $change = null;
            if ($allow_source == 1) {
                $source = $attributesPost["source"];
                $pathSet = "/uploads/web/news-data/images";
                $change = $attributesPost["change"];

                $successMultimediaModel = $modelMultimedia->managerUploadModel(
                    array(
                        'createUpdate' => $createUpdate,
                        'source' => $source,
                        'pathSet' => $pathSet,
                        'change' => $change,
                        'auxResource' => $auxResource
                    )
                );
            } else {
                if (!$createUpdate) {
                    $modelMultimedia->deleteResource(array("path" => $auxResource));
                }
            }

            $successMultimedia = $allow_source == 1 ? $successMultimediaModel['success'] : true;
            if ($successMultimedia) {
                $currentResource = '';

                $source = $allow_source == 1 ? $currentResource . $successMultimediaModel['source'] : $BusinessHistoryByDataData['source'];

                $BusinessHistoryByDataData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $BusinessHistoryByDataData, 'attributesData' => $this->attributesData));
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  BusinessHistoryByData.";
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
            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


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
        $query->join('business_by_history', 'business_by_history.id', '=', $this->table . '.business_by_history_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_source', 'like', '%' . $likeSet . '%');
            $query->orWhere("business_by_history.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title_icon', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getServiceDataFrontend($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $business_by_history_id = $params['filters']['business_by_history_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,$this->table.description,$this->table.source,$this->table.allow_source";

        $relationLanguage = 'language_business_by_history_by_data';
        $relationLanguageId = 'business_by_history_by_data_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.title title_lang,' . $relationLanguage . '.description description_lang
           ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.status', '=', $state);
                $query->where('language.initials', '=', $language);
            });
        }
        $query->where($this->table . '.status', '=', 'ACTIVE');
        $query->where($this->table . '.business_by_history_id', '=', $business_by_history_id);

        $resultData = $query->get()->toArray();
        $result = [];
        foreach ($resultData as $key => $value) {
            $setPush = json_decode(json_encode($value), true);
            $result[] = $setPush;
        }
        return $result;

    }
    public function getDataById($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $business_by_history_id = $params['filters']['business_by_history_id'];


        $selectString = "$this->table.id,$this->table.title,$this->table.description,$this->table.status,$this->table.source,$this->table.allow_source,business_by_history.value as business_by_history,
business_by_history.id as business_by_history_id,
$this->table.title_icon";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_by_history', 'business_by_history.id', '=', $this->table . '.business_by_history_id');

        $query->where($this->table . '.business_by_history_id', '=', $business_by_history_id);


// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data

        $result = $query->get()->toArray();

 

        return $result;
    }
}
