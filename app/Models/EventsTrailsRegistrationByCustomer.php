<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class EventsTrailsRegistrationByCustomer extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    const TYPE_REGISTRATION_WEB = 0;
    const TYPE_REGISTRATION_POINT_SALE = 1;

    protected $table = 'events_trails_registration_by_customer';

    protected $fillable = array(
        'events_trails_project_id',//*
        'user_id',//*
        'events_trails_type_of_categories_id',//*
        'events_trails_distances_id',//*
        'type_registration',//*
        'manager_id'
    );
    protected $attributesData = [
        ['column' => 'events_trails_project_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'events_trails_type_of_categories_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'events_trails_distances_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_registration', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'manager_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["events_trails_project_id" => "required|numeric",
            "user_id" => "required|numeric",
            "events_trails_type_of_categories_id" => "required|numeric",
            "events_trails_distances_id" => "required|numeric",
            "type_registration" => "required|numeric",
            "manager_id" => "required|numeric",

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

        $selectString = "$this->table.id,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id,
$this->table.user_id,events_trails_type_of_categories.value as events_trails_type_of_categories,
events_trails_type_of_categories.id as events_trails_type_of_categories_id,
events_trails_distances.value as events_trails_distances,
events_trails_distances.id as events_trails_distances_id,
$this->table.type_registration";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join('events_trails_type_of_categories', 'events_trails_type_of_categories.id', '=', $this->table . '.events_trails_type_of_categories_id');
        $query->join('events_trails_distances', 'events_trails_distances.id', '=', $this->table . '.events_trails_distances_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_type_of_categories.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_distances.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_registration', 'like', '%' . $likeSet . '%');
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
        try {
            $modelName = 'EventsTrailsRegistrationByCustomer';
            $model = new EventsTrailsRegistrationByCustomer();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EventsTrailsRegistrationByCustomer::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $eventsTrailsRegistrationByCustomerData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsRegistrationByCustomerData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  EventsTrailsRegistrationByCustomer.";
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
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join('events_trails_type_of_categories', 'events_trails_type_of_categories.id', '=', $this->table . '.events_trails_type_of_categories_id');
        $query->join('events_trails_distances', 'events_trails_distances.id', '=', $this->table . '.events_trails_distances_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_type_of_categories.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_distances.value", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_registration', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function saveDataCustomerRegister($params)
    {
        $success = false;
        $msj = "Se guardo correctamente.";

        $result = array();
        $attributesPost = $params;
        $errors = array();
        $modelSave = [];
        try {
            $modelName = 'EventsTrailsRegistrationByCustomer';
            $model = new EventsTrailsRegistrationByCustomer();
            $createUpdate = true;

            $eventsTrailsRegistrationByCustomer = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsRegistrationByCustomer, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $modelSave = $model;
            } else {
                $success = false;
                $msj = "Problemas al guardar  EventsTrailsRegistrationByCustomer.";
                $errors = $validateResult["errors"];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'model' => $modelSave

            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'model' => $modelSave
            );
            return ($result);
        }

    }

    public function getDataFormRegister($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $manager_id = $params['filters']['manager_id'];
        $selectString = "$this->table.id,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id,
$this->table.user_id,events_trails_type_of_categories.value as events_trails_type_of_categories,
events_trails_type_of_categories.id as events_trails_type_of_categories_id,
events_trails_distances.value as events_trails_distances,
events_trails_distances.id as events_trails_distances_id,
events_trails_type_teams.value events_trails_type_teams,events_trails_type_teams.id events_trails_type_teams_id,events_trails_type_teams.quantity,
$this->table.type_registration
,users.name full_name,users.email,users.name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join('events_trails_type_of_categories', 'events_trails_type_of_categories.id', '=', $this->table . '.events_trails_type_of_categories_id');
        $query->join('events_trails_distances', 'events_trails_distances.id', '=', $this->table . '.events_trails_distances_id');
        $query->join('events_trails_type_teams', 'events_trails_distances.events_trails_type_teams_id', '=', 'events_trails_type_teams.id');
        $query->join('users', 'users.id', '=', $this->table . '.user_id');


        $query->orderBy($field, $sort);
        $query->where($this->table . '.manager_id', '=', $manager_id);


        $data = $query->get()->toArray();

        $result = $data;


        return $result;
    }

    public function getManagementFormRegister($params)
    {

        $data = $this->getDataFormRegister($params);
        $resultData = [];
        $modelKits = new \App\Models\OrderEventKitsByCustomer();
        $eventConfig = [];
        $team = [];
        $distance = [];
        $allowConfig = false;
        $event = [];
        foreach ($data as $key => $row) {

            $events_trails_registration_by_customer_id = $row->id;
            $dataChildren = $modelKits->getKitsByCustomerRegistration([
                'filters' => [
                    'events_trails_registration_by_customer_id' => $events_trails_registration_by_customer_id
                ]
            ]);
            if (!$allowConfig) {
                $allowConfig = true;
                $team = [
                    'id' => $row->events_trails_type_teams_id,
                    'events_trails_type_teams' => $row->events_trails_type_teams,


                ];
                $distance = [
                    'id' => $row->events_trails_distances_id,
                    'events_trails_distances' => $row->events_trails_distances,


                ];
                $event = [
                    'id' => $row->events_trails_project_id,
                    'events_trails_project' => $row->events_trails_project,


                ];
            }
            $setPush = (array)$row;
            $setPush['data'] = $dataChildren;
            $resultData[] = $setPush;

        }
        $eventConfig = ['team' => $team, 'distance' => $distance, 'event' => $event];
        $result = [
            'people' => $resultData,
            'eventConfig' => $eventConfig
        ];
        return $result;

    }
}
