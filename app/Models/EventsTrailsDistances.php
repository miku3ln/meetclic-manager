<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EventsTrailsDistances extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'events_trails_distances';

    protected $fillable = array(
        'value',//*
        'value_distance',//*
        'description',
        'status',//*
        'events_trails_project_id',//*
        'events_trails_type_teams_id',//*

        'price',//*
        'type'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'value_distance', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'events_trails_project_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'events_trails_type_teams_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],

        ['column' => 'price', 'type' => 'double', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'string', 'defaultValue' => 'SINGLE', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:250",
            "value_distance" => "required|numeric",
            "status" => "required",
            "events_trails_project_id" => "required|numeric",
            "events_trails_type_teams_id" => "required|numeric",

            "price" => "required|numeric",
            "type" => "required"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $events_trails_project_id=$params['filters']['events_trails_project_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.events_trails_type_teams_id,$this->table.value,$this->table.value_distance,$this->table.description,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id,
events_trails_type_teams.value events_trails_type_teams,
$this->table.price,$this->table.type";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join('events_trails_type_teams', 'events_trails_type_teams.id', '=', $this->table . '.events_trails_type_teams_id');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value_distance', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');

            $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);

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
            $modelName = 'EventsTrailsDistances';
            $model = new EventsTrailsDistances();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EventsTrailsDistances::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $eventsTrailsDistancesData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsDistancesData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  EventsTrailsDistances.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value_distance', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.price', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
    public function getDistancesByEvent($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $events_trails_project_id=$params['filters']['events_trails_project_id'];


        $selectString = "$this->table.id,$this->table.events_trails_type_teams_id,$this->table.value,$this->table.value_distance,$this->table.description,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id,
events_trails_type_teams.value events_trails_type_teams,
$this->table.price,$this->table.type";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join('events_trails_type_teams', 'events_trails_type_teams.id', '=', $this->table . '.events_trails_type_teams_id');

        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);


// sort
        $query->orderBy($field, $sort);

        $result = $query->get()->toArray();



        return $result;
    }

}
