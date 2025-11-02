<?php
//CPP-010
namespace App\Models\WorkPlanning;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Models\Multimedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkPlanningHeaderByResources extends ModelManager
{


    protected $table = 'work_planning_header_by_resources';
    protected $nameModel = 'WorkPlanningHeaderByResources';
    protected $primaryKey = 'id';

    public $timestamps = false;
    const TYPE_IMAGE_UPLOAD = 0;
    const TYPE_URL_OTHER_SERVER = 2;
    const TYPE_FILE = 1;


    protected $fillable = array(
        "id",
        "type_multimedia",//*
        "url",//*
        "description",
        "created_at",
        "status",//*
        "work_planning_header_id",//*

    );
    public $attributesData = array(
        "id",
        "type_multimedia",//*
        "url",//*
        "description",
        "created_at",
        "status",//*
        "work_planning_header_id",//*

    );


    public static function getRulesModel()
    {
        $rules = [

            "type_multimedia" => 'required',//*
            "url" => 'required',
            "description" => 'required',

            "status" => 'required',
            "work_planning_header_id" => 'required',

        ];
        return $rules;
    }

    public static $selection = 'url,type_multimedia,description,status,work_planning_header_id';
    public static $selectTwo = 'CONCAT(name," " ,"")';


    public function getAdmin($params)
    {


        $sort = 'asc';
        $field = 'id';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id,$this->table.url,$this->table.type_multimedia,$this->table.description,$this->table.status,$this->table.work_planning_header_id";
        $manager_parent_id = $params['filters']['manager_parent_id'];

        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }
        $query->where($this->table . '.work_planning_header_id', '=', $manager_parent_id);


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query
                    ->orWhere($this->table . '.description', 'like', $likeSet);

            });
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


    public function getAdminData($params)
    {
        $result = $this->getAdmin($params);

        return $result;

    }

    public function getDataModel($postData)
    {

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

            $model = new WorkPlanningHeaderByResources();
            $createUpdate = true;
            if (isset($attributesPost[$this->nameModel]["id"]) && $attributesPost[$this->nameModel]["id"] != "null" && $attributesPost[$this->nameModel]["id"] != "-1") {
                $model = WorkPlanningHeaderByResources::find($attributesPost[$this->nameModel]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost[$this->nameModel];
            $urlManager = $postData["url"];
            $url = "";

            $type_multimedia = $postData["type_multimedia"];
            $allowTypeDoc = false;
            $allowUpload = false;
            $type = '';

            if ($type_multimedia == WorkPlanningHeaderByResources::TYPE_IMAGE_UPLOAD) {
                $type = 'image';
                $allowUpload = true;
            } else if ($type_multimedia == WorkPlanningHeaderByResources::TYPE_URL_OTHER_SERVER) {
                $url = $urlManager;
                $allowUpload = false;
                $type = 'none';


            } else if ($type_multimedia == WorkPlanningHeaderByResources::TYPE_FILE) {
                $url = $urlManager;
                $allowUpload = true;
                $type = 'docs';


            }
            $successMultimedia = false;
            $successMultimediaModel = [];
            if ($allowUpload) {
                $auxResource = "";
                $modelMultimedia = new Multimedia;
                $source = $postData["url"];
                $pathSet = "/uploads/workPlanning/workPlanningHeaderByResources";
                $change = $postData["change"];
                $paramsSendUpload = array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource,
                    'type' => $type
                );
                $successMultimediaModel = $modelMultimedia->managerUploadModel(
                    $paramsSendUpload
                );
                $successMultimedia = $successMultimediaModel['success'];
            } else {
                $successMultimedia = true;
            }
            if ($successMultimedia) {
                $source = "";
                if ($type_multimedia == WorkPlanningHeaderByResources::TYPE_IMAGE_UPLOAD) {
                    $source = $successMultimediaModel['source'];
                } else if ($type_multimedia == WorkPlanningHeaderByResources::TYPE_URL_OTHER_SERVER) {
                    $source = $postData['url'];
                } else if ($type_multimedia == WorkPlanningHeaderByResources::TYPE_FILE) {
                    $source = $successMultimediaModel['source'];

                }
                $attributes = array(
                    "url" => $source,
                    "type_multimedia" => $postData["type_multimedia"],
                    "description" => $postData["description"],
                    "status" => $postData["status"],
                    "work_planning_header_id" => $postData["work_planning_header_id"],

                );
                $model->attributes = $attributes;
                $successManager = $model->validate();
                $success = $successManager['success'];

                if ($success) {
                    $model->fill($attributes);
                    $model->save();

                } else {
                    $success = false;
                    $msj = "Problemas al guardar .";
                    $errors = $successManager["errors"];
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar una imagen .";
                $errors = [
                    'source' => 'error al subir la imagen.'
                ];
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
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => false,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }
    }

    public function getListData($params)
    {

        $query = DB::table($this->table);

        $conditionText = "$this->table.name text";

        $selectString = "$this->table.id ,$this->table.name ,$conditionText ,$this->table.business_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $user = Auth::user();

        $business_id = ($params['filters']["business_id"]);
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->where('description', 'like', '%' . $like . '%');

        }
        $query->where('business_id', '=', $business_id);
        $query->where('user_id', '=', $user->id);


        $query->limit(10)->orderBy('id', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }


}



