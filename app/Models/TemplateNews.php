<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Multimedia;

class TemplateNews extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'template_news';

    protected $fillable = array(
        'value', //*
        'description',
        'status', //*
        'template_information_id', //*
        'source',
        'allow_source', //*
        'subtitle',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'template_information_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => 'nothing', 'required' => 'false'],
        ['column' => 'allow_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required|max:150",
            "status" => "required",
            "template_information_id" => "required|numeric",
            "source" => "max:350",
            "user_id" => "required|numeric",

            "allow_source" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'status';

        $query = DB::table($this->table);
        $template_information_id = $params['filters']['template_information_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.status,template_information.value as template_information,
template_information.id as template_information_id,
$this->table.source,$this->table.allow_source,$this->table.subtitle";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');


            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');;
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
            $modelName = 'TemplateNews';
            $model = new TemplateNews();
            $createUpdate = true;
            $auxResource = "";
            $modelMultimedia = new Multimedia;

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = TemplateNews::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }
            $user = Auth::user();
            $user_id = $user->id;
            $attributesPost['user_id']=$user_id;
            $templateNewsData = $attributesPost;
            $template_information_id = $attributesPost["template_information_id"];
            $allow_source = $attributesPost["allow_source"];
            $successMultimediaModel = array();
            if ($allow_source == 1) {
                $source = $attributesPost["source"];
                $pathSet = "/uploads/web/news/images";
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

                $source = $allow_source == 1 ? $currentResource . $successMultimediaModel['source'] : $templateNewsData['source'];


                $templateNewsData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateNewsData, 'attributesData' => $this->attributesData));
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    if (false) {

                        if ($attributesSet['status'] == 'ACTIVE') {
                            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                                $idCurrent = $attributesPost["id"];
                                TemplateNews::where('status', 'ACTIVE')
                                    ->where('template_information_id', '=', $template_information_id)
                                    ->whereNotIn('id', [$idCurrent])
                                    ->update(['status' => 'INACTIVE']);
                            } else {
                                TemplateNews::where('status', 'ACTIVE')
                                    ->where('template_information_id', '=', $template_information_id)
                                    ->update(['status' => 'INACTIVE']);
                            }
                        }
                    }
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  TemplateNews.";
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
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');;
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getServiceFrontend($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $template_information_id = $params['filters']['template_information_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;

        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,$this->table.description,$this->table.source,$this->table.allow_source,$this->table.subtitle ";
        $relationLanguage = 'language_template_services';
        $relationLanguageId = 'template_services_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.value value_lang,' . $relationLanguage . '.description description_lang,' . $relationLanguage . '.subtitle subtitle_lang
           ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
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
        $query->where($this->table . '.template_information_id', '=', $template_information_id);

        $result = $query->first();
        return $result;
    }

    public function getDataFrontend($params)
    {
        $sort = 'asc';
        $field = 'created_at';

        $query = DB::table($this->table);
        $template_information_id = $params['filters']['template_information_id'];
        $selectString = "$this->table.id,$this->table.created_at,$this->table.value,$this->table.description,$this->table.status,template_information.value as template_information,
template_information.id as template_information_id,
$this->table.source,$this->table.allow_source,$this->table.subtitle";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        $query->where($this->table . '.template_information_id', '=', $template_information_id);
        $status = 'ACTIVE';
        $query->where($this->table . '.status', '=', $status);

        $query->orderBy($field, $sort);

        if (!isset($params['perpage'])) {
            $perpage = 4;
            $query->limit((int)$perpage);
        } else {
            $perpage = $params['perpage'];
            $query->limit((int)$perpage);
        }

        $result = $query->get()->toArray();


        return $result;
    }

    public function getFreshFrontend($params)
    {
        $sort = 'asc';
        $field = 'created_at';

        $query = DB::table($this->table);
        $template_information_id = $params['filters']['template_information_id'];
        $selectString = "$this->table.id,$this->table.created_at,$this->table.value,$this->table.description,$this->table.status,template_information.value as template_information,
template_information.id as template_information_id,
$this->table.source,$this->table.allow_source,$this->table.subtitle";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        $query->where($this->table . '.template_information_id', '=', $template_information_id);
        $status = 'ACTIVE';
        $query->where($this->table . '.status', '=', $status);

        $query->orderBy($field, $sort);

        if (!isset($params['perpage'])) {
            $perpage = 4;
            $query->limit((int)$perpage);
        } else {
            $perpage = $params['perpage'];
            $query->limit((int)$perpage);
        }

        $result = $query->get()->toArray();


        return $result;
    }

    public function getManagementFrontend($params)
    {

        $resultData = $this->getFrontend($params);
        $success = $resultData ? true : false;
        $data = [];
        if ($success) {
            $data['parent'] = $resultData;


            $freshData = $this->getFreshFrontend($params);
            if (count($freshData)) {
                $data['fresh-data'] = $freshData;
            }
        }

        $result = [
            'success' => $success,
            'data' => $data
        ];
        return $result;
    }

    public function getFrontend($params)
    {
        $sort = 'asc';
        $field = 'created_at';
        $query = DB::table($this->table);
        $id = $params['filters']['id'];
        $selectString = "$this->table.id,$this->table.created_at,$this->table.value,$this->table.description,$this->table.status,template_information.value as template_information,
template_information.id as template_information_id,
$this->table.source,$this->table.allow_source,$this->table.subtitle";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        $query->where($this->table . '.id', '=', $id);
        $query->orderBy($field, $sort);
        $result = $query->first();


        return $result;
    }
}
