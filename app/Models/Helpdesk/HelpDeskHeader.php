<?php
//CPP-010
namespace App\Models\Helpdesk;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class HelpDeskHeader extends ModelManager
{


    protected $table = 'help_desk_header';
    protected $nameModel = 'HelpDeskHeader';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = array(
        "id",
        "name",//*
        "description",
        "created_at",
        "status",//*
        "predetermined",
        "year",//*
        "business_id",
        "user_id",//*
        "type_manager_process",
        "help_desk_human_resources_employee_profile_id",
        "administrator_human_resources_employee_profile_id",
        "type_manager_process",
        "human_resources_department_id",
        "help_desk_types_id"

    );
    public $attributesData = array(
        "id",
        "name",//*
        "description",
        "created_at",
        "status",//*
        "predetermined",
        "year",//*
        "business_id",
        "user_id",//*
        "type_manager_process",
        "help_desk_human_resources_employee_profile_id",
        "administrator_human_resources_employee_profile_id",
        "type_manager_process",
        "human_resources_department_id",
        "help_desk_types_id"

    );


    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',
            "status" => 'required',
            "year" => 'required',
            "business_id" => 'required',
            "user_id" => 'required',
            "predetermined" => 'required',
            "help_desk_human_resources_employee_profile_id" => 'required',
            "administrator_human_resources_employee_profile_id" => 'required',
            "human_resources_department_id" => 'required',

            "help_desk_types_id" => 'required',


        ];
        return $rules;
    }

    public static $selection = 'name,description,status,predetermined,year,business_id,user_id,help_desk_human_resources_employee_profile_id,
    administrator_human_resources_employee_profile_id';
    public static $selectTwo = 'CONCAT(name," " ,"")';


    public function getAdmin($params)
    {
        $user = Auth::user();

        $sort = 'asc';
        $field = 'name';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id,$this->table.name,$this->table.description,$this->table.status,$this->table.predetermined,$this->table.year,$this->table.business_id,$this->table.user_id,$this->table.help_desk_human_resources_employee_profile_id
    ,$this->table.administrator_human_resources_employee_profile_id
    ,CONCAT(people.name , ' ',people.last_name) help_desk_human_resources_employee_profile_name
    ,CONCAT(people2.name , ' ',people2.last_name) administrator_human_resources_employee_profile_name
    ,human_resources_department.name human_resources_department_name,human_resources_department.id human_resources_department_id
    ,help_desk_types.name help_desk_types_name,help_desk_types.id help_desk_types_id,";
        $relationOne = "human_resources_employee_profile";
        $relationTwo = "people";
        $relationThree = "help_desk_types";

        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }
        $query->join($relationOne, $relationOne . '.id', '=', $this->table . '.help_desk_human_resources_employee_profile_id');
        $query->join($relationTwo, $relationOne . '.people_id', '=', $relationTwo . '.id');

        $query->join($relationOne . ' as administrator_human_resources_employee', 'administrator_human_resources_employee.id', '=', $this->table . '.administrator_human_resources_employee_profile_id');
        $query->join($relationTwo . " as people2", $relationOne . '.people_id', '=', 'people2.id');
        $query->join($relationThree, $this->table . '.help_desk_types_id', '=', $relationThree . '.id');

        $query->where($this->table . '.user_id', '=', $user->id);


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
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

            $model = new HelpDeskHeader();
            $createUpdate = true;
            if (isset($attributesPost[$this->nameModel]["id"]) && $attributesPost[$this->nameModel]["id"] != "null" && $attributesPost[$this->nameModel]["id"] != "-1") {
                $model = HelpDeskHeader::find($attributesPost[$this->nameModel]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost[$this->nameModel];
            $user = Auth::user();
            $year = date("Y");
            $attributes = array(
                "name" => $postData["name"],
                "description" => $postData["description"],
                "status" => $postData["status"],
                "predetermined" => $postData["predetermined"],
                "year" => $year,
                "business_id" => $postData["business_id"],
                "user_id" => $user->id,
                "help_desk_human_resources_employee_profile_id" => $postData["help_desk_human_resources_employee_profile_id"],
                "administrator_human_resources_employee_profile_id" => $postData["administrator_human_resources_employee_profile_id"],
                "help_desk_types_id" => $postData["help_desk_types_id"],
                "human_resources_department_id" => $postData["human_resources_department_id"],
                "type_manager_process" => 0,

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
                $errors = $attributes["errors"];
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
                "success" => $success,
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

            $query->where('name', 'like', '%' . $like . '%');
            $query->where('description', 'like', '%' . $like . '%');

        }
        $query->where('business_id', '=', $business_id);
        $query->where('user_id', '=', $user->id);


        $query->limit(10)->orderBy('id', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }


}



