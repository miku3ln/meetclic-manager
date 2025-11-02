<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class EventsTrailsTypeTeams extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'events_trails_type_teams';

    protected $fillable = array(
        'value',//*
        'description',
        'status',//*
        'events_trails_project_id',//*
        'quantity'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'quantity', 'type' => 'integer', 'defaultValue' => 1, 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'events_trails_project_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required|max:250",
            "status" => "required",
            "events_trails_project_id" => "required|numeric",
            "quantity" => "required|numeric"

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

        $selectString = "$this->table.id,$this->table.quantity,$this->table.value,$this->table.description,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id
";
        $events_trails_project_id=$params['filters']['events_trails_project_id'];

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');;

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
            $modelName = 'EventsTrailsTypeTeams';
            $model = new EventsTrailsTypeTeams();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EventsTrailsTypeTeams::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $eventsTrailsTypeTeamsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsTypeTeamsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  EventsTrailsTypeTeams.";
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
        $events_trails_project_id=$params['filters']['events_trails_project_id'];
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("events_trails_project.value", 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . '.events_trails_project_id', '=',  $events_trails_project_id );

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getTeamsByEvents($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);


        $selectString = "$this->table.id,$this->table.quantity,$this->table.value,$this->table.description,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id
";
        $events_trails_project_id=$params['filters']['events_trails_project_id'];
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');

        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;
    }
}
