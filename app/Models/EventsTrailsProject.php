<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Utils\Util;
use App\Models\Multimedia;
use DateTime;

class EventsTrailsProject extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'events_trails_project';

    protected $fillable = array(
        'value',//*
        'description',
        'status',//*
        'date_init_project',//*
        'date_end_project',//*
        'business_id',//*
        'events_trails_types_id',//*
        'source'
    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'date_init_project', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'date_end_project', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'events_trails_types_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required|max:250",
            "source" => "required|max:350",
            "status" => "required",
            "date_init_project" => "required",
            "date_end_project" => "required",
            "business_id" => "required|numeric",
            "events_trails_types_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getAdminFrontend($params)
    {
        $result = $this->getAdminManageFrontend($params);
        $business_id = $params['filters']['business_id'];

        $modelTeams = new \App\Models\EventsTrailsTypeTeams();
        $modelCategories = new \App\Models\EventsTrailsTypeOfCategories();
        $modelDistances = new \App\Models\EventsTrailsDistances();
        $modelKits = new \App\Models\EventsTrailsByKit();
        foreach ($result['rows'] as $key => $row) {
            $events_trails_project_id = $row->id;
            $paramsData = [
                'filters' => [
                    'events_trails_project_id' => $events_trails_project_id,
                    'business_id' => $business_id
                ]
            ];
            $teams = $modelTeams->getTeamsByEvents($paramsData);
            $categories = $modelCategories->getCategoriesByEvent($paramsData);
            $distances = $modelDistances->getDistancesByEvent($paramsData);
            $kits = $modelKits->getKitsByEvent($paramsData);
            $dataRow = (array)$row;
            $result['rows'][$key] = $dataRow;
            $result['rows'][$key]['teams'] = $teams;
            $result['rows'][$key]['categories'] = $categories;
            $result['rows'][$key]['distances'] = $distances;
            $result['rows'][$key]['kits'] = $kits;


        }


        return $result;
    }

    public function getAdminManageFrontend($params)
    {


        $sort = 'desc';
        $field = 'date_end_project';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;

        $selectString = "$this->table.id,$this->table.source,$this->table.value,$this->table.value name,$this->table.description,$this->table.status,$this->table.date_init_project,$this->table.date_end_project,business.title as business,
business.id as business_id,
events_trails_types.value as events_trails_types,
events_trails_types.id as events_trails_types_id
,DATE_FORMAT($this->table.date_init_project,'%d/%m/%Y') date_init_project,DATE_FORMAT($this->table.date_end_project,'%d/%m/%Y') date_end_project
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('events_trails_types', 'events_trails_types.id', '=', $this->table . '.events_trails_types_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.date_end_project', 'like', '%' . $likeSet . '%');

            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_types.value", 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . '.business_id', '=', $business_id);
        $dateCurrent = new DateTime();
        $dateCurrent->format('d/m/Y');
        $query->whereDate($this->table . ".date_end_project", '>=', $dateCurrent);
        $category = isset($params['filters']['category']) && $params['filters']['category'] != -1 ? $params['filters']['category'] : null;
        if ($category) {

            $query->where($this->table . '.events_trails_types_id', '=', $category);
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

        $selectString = "$this->table.id,$this->table.source,$this->table.value,$this->table.description,$this->table.status,$this->table.date_init_project,business.title as business,
business.id as business_id,
events_trails_types.value as events_trails_types,
events_trails_types.id as events_trails_types_id
,DATE_FORMAT($this->table.date_init_project,'%d/%m/%Y') date_init_project,DATE_FORMAT($this->table.date_end_project,'%d/%m/%Y') date_end_project
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('events_trails_types', 'events_trails_types.id', '=', $this->table . '.events_trails_types_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.date_init_project', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.date_end_project', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_types.value", 'like', '%' . $likeSet . '%');;

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
            $modelName = 'EventsTrailsProject';
            $model = new EventsTrailsProject();
            $modelMultimedia = new Multimedia;
            $createUpdate = true;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = EventsTrailsProject::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source;

            } else {
                $createUpdate = true;

            }

            $eventsTrailsProjectData = $attributesPost;
            $source = $eventsTrailsProjectData["source"];
            $pathSet = "/uploads/events/eventsTrailsProject";
            $change = $eventsTrailsProjectData["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {
                $currentResource = '';

                $source = $currentResource . $successMultimediaModel['source'];

                $eventsTrailsProjectData['source'] = $source;
                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsProjectData, 'attributesData' => $this->attributesData));
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
                    $msj = "Problemas al guardar  EventsTrailsProject.";
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('events_trails_types', 'events_trails_types.id', '=', $this->table . '.events_trails_types_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.date_init_project', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.date_end_project', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_types.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getManagerDataById($params)
    {


        $selectString = "$this->table.source ,$this->table.id,$this->table.value,$this->table.value name,$this->table.description,$this->table.status,$this->table.date_init_project,$this->table.date_end_project,business.title as business,
business.id as business_id,DATE_FORMAT($this->table.date_init_project,'%d/%m/%Y') date_init_project,DATE_FORMAT($this->table.date_end_project,'%d/%m/%Y') date_end_project
,events_trails_types.value as events_trails_types,
events_trails_types.id as events_trails_types_id
";
        $id = $params["id"];
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('events_trails_types', 'events_trails_types.id', '=', $this->table . '.events_trails_types_id');
        $query->where($this->table . ".id", '=', $id);

        $data = $query->get()->first();

        return $data;

    }

    public function getManagerData($params)
    {
        $id = $params['id'];

        $model = $this->getManagerDataById(array("id" => $id));
        $success = false;
        if ($model) {
            $success = true;
        }

        $dateCurrentData = array("format" => Util::DateCurrent(), "not-format" => Util::DateCurrent(null, "H:i:s d/m/Y"));
        $result = array(
            "model" => $model,
            "success" => $success,
            "dateCurrentData" => $dateCurrentData,

        );

        return $result;
    }

    public function getManagerDataDetails($params)
    {
        $id = $params['id'];
        $language = $params['language'];
        $business_id = $params['business_id'];
        $model = $this->getManagerDataById(array("id" => $id));
        $events_trails_project_id = $id;
        $modelTeams = new \App\Models\EventsTrailsTypeTeams();
        $modelCategories = new \App\Models\EventsTrailsTypeOfCategories();
        $modelDistances = new \App\Models\EventsTrailsDistances();
        $modelKits = new \App\Models\EventsTrailsByKit();
        $paramsData = [
            'filters' => [
                'events_trails_project_id' => $events_trails_project_id,
                'business_id' => $business_id
            ]
        ];
        $teams = $modelTeams->getTeamsByEvents($paramsData);
        $categories = $modelCategories->getCategoriesByEvent($paramsData);
        $distances = $modelDistances->getDistancesByEvent($paramsData);
        $kits = $modelKits->getKitsByEvent($paramsData);

        $success = false;
        if ($model) {
            $success = true;
        }
        $multimedia = [];
        $result = array(
            "data" => $model,
            'teams' => $teams,
            'categories' => $categories,
            'distances' => $distances,
            'kits' => $kits,
            "success" => $success,
            'language' => $language,
            'multimedia' => $multimedia,
            'resourcePathServer' => $params['resourcePathServer']

        );

        return $result;
    }

    public function getEventsRoutesHome($params)
    {
        $sort = 'desc';
        $field = 'date_end_project';
        $query = DB::table($this->table);

        $business_id = $params['filters']['business_id'];


        $selectString = "$this->table.id,$this->table.source,$this->table.value,$this->table.value name,$this->table.description,$this->table.status,$this->table.date_init_project,$this->table.date_end_project,business.title as business,
business.id as business_id,DATE_FORMAT($this->table.date_init_project,'%d/%m/%Y') as date_init_project,DATE_FORMAT($this->table.date_end_project,'%d/%m/%Y') as date_end_project
,events_trails_types.value as events_trails_types,
events_trails_types.id as events_trails_types_id
";
        $dateCurrent = new DateTime();
        $dateCurrent->format('d/m/Y');

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('events_trails_types', 'events_trails_types.id', '=', $this->table . '.events_trails_types_id');
        $query->where($this->table . ".business_id", '=', $business_id);
        $query->where($this->table . ".status", '=', self::STATE_ACTIVE);
        $query->whereDate($this->table . ".date_end_project", '>=', $dateCurrent);

        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();
        $result = $data;




        $modelTeams = new \App\Models\EventsTrailsTypeTeams();
        $modelCategories = new \App\Models\EventsTrailsTypeOfCategories();
        $modelDistances = new \App\Models\EventsTrailsDistances();
        $modelKits = new \App\Models\EventsTrailsByKit();

        foreach ($result as $key => $row) {
            $events_trails_project_id = $row->id;
            $paramsData = [
                'filters' => [
                    'events_trails_project_id' => $events_trails_project_id,
                    'business_id' => $business_id
                ]
            ];
            $teams = $modelTeams->getTeamsByEvents($paramsData);
            $categories = $modelCategories->getCategoriesByEvent($paramsData);
            $distances = $modelDistances->getDistancesByEvent($paramsData);
            $kits = $modelKits->getKitsByEvent($paramsData);
            $dataRow = (array)$row;
            $result[$key] = $dataRow;
            $result[$key]['teams'] = $teams;
            $result[$key]['categories'] = $categories;
            $result[$key]['distances'] = $distances;
            $result[$key]['kits'] = $kits;


        }


        return $result;
    }

}
