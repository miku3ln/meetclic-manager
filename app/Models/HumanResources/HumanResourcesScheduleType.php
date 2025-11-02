<?php
//CPP-010
namespace App\Models\HumanResources;

use App\Models\Exception;
use App\Models\ModelManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HumanResourcesScheduleType extends ModelManager
{

    protected $nameModel = 'HumanResourcesScheduleType';

    protected $table = 'human_resources_schedule_type';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';
    /*
     * this parameter add or remove timestamps columns depending its status
     */
    public $timestamps = false;

    protected $fillable = array(
        "id",//*
        "name",//*
        "code",
        "description",//
        "created_at",//*
        "updated_at",//*
        "deleted_at",//*
        "status",//*
        "predetermined",//*
        "rotary",//*

        "business_id",

    );
    public $attributesData = array(
        "id",//*
        "name",//*
        "code",
        "description",//
        "created_at",//*
        "updated_at",//*
        "deleted_at",//*
        "status",//*
        "predetermined",//*
        "rotary",//*
        "business_id",

    );


    public static function getRulesModel()
    {
        $rules = [

            "name" => 'required',//*
            "code" => 'required',
            "description" => 'required',//

            "status" => 'required',//*
            "predetermined" => 'required',//*
            "rotary" => 'required',//*
            "business_id" => 'required',

        ];
        return $rules;
    }

    public static $selection = 'name,code,description,status,predetermined,rotary,business_id';
    public static $selectTwo = 'CONCAT(code," " ,name)';

    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getAdmin($params)
    {
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
        $selectString = HumanResourcesScheduleType::$selection;


        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($this->table . '.code', 'like', $likeSet)
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

    public function getActionParent($params)
    {
        $parent_id = $params["parent_id"];
        $query = DB::table($this->table);
        $selectString = "*";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("id", '=', $parent_id);
        $data = $query->get()->first();
        return $data;
    }

    public function getAdminData($params)
    {
        $result = $this->getAdmin($params);

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

            $model = new HumanResourcesScheduleType();
            $createUpdate = true;
            if (isset($attributesPost[$nameModel]["id"]) && $attributesPost[$nameModel]["id"] != "null" && $attributesPost[$nameModel]["id"] != "-1") {
                $model = HumanResourcesScheduleType::find($attributesPost[$nameModel]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost[$nameModel];
            $attributesSet = array(
                "name" => $postData["name"],
                "parent_id" => $postData["parent_id"],
                "weight" => $postData["weight"],
                "icon" => $postData["icon"],
                "type" => $postData["type"],
                "type_item" => $postData["type_item"],
                "description" => $postData["description"],
                "business_id" => $postData["business_id"],
            );


            $validateResult = HumanResourcesScheduleType::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar .";
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

        $business_id = ($params['filters']["business_id"]);
        $type = 2;

        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->where('name', 'like', '%' . $like . '%');
        }
        $query->where('business_id', '=', $business_id);


        $query->limit(10)->orderBy('id', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }



}



