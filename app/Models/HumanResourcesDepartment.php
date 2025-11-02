<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class HumanResourcesDepartment extends Model
{

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    protected $table = 'human_resources_department';

    protected $fillable = array(
        "name",//*
        "description",
        "status",//*
        "business_id"//*
    );
    public $attributesData = array(
        "name",//*
        "description",
        "status",//*
        "business_id"//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',

        ];
        return $rules;
    }


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
        $business_id = $params['filters']['business_id'];

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.name ,$this->table.description,$this->table.status,$this->table.business_id
  ";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->orWhere($this->table . '.name', 'like', $likeSet)
                ->orWhere($this->table . '.description', 'like', $likeSet);
        }
        $query->where($this->table . '.business_id', '=', $business_id);

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

            $model = new HumanResourcesDepartment();
            $createUpdate = true;
            if (isset($attributesPost["HumanResourcesDepartment"]["id"]) && $attributesPost["HumanResourcesDepartment"]["id"] != "null" && $attributesPost["HumanResourcesDepartment"]["id"] != "-1") {
                $model = HumanResourcesDepartment::find($attributesPost["HumanResourcesDepartment"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["HumanResourcesDepartment"];
            $attributesSet = array(
                "name" => $postData["name"],
                "description" => isset($postData["description"]) ? $postData["description"] : "",
                "business_id" => $postData["business_id"],
            );


            $validateResult = self::validateModel($attributesSet);

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


    public function getListAll($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name as text ";
        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = $params['filters']["business_id"];
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->orWhere($this->table . '.name', 'like', '%' . $like . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $like . '%');
        }
        $query->where($this->table . '.business_id', '=', $business_id);

        $query->limit(10)->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getListByAreaAll($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name as text
         ,human_resources_department_by_organizational_chart_area.human_resources_organizational_chart_area_id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('human_resources_department_by_organizational_chart_area', $this->table . '.id', '=', 'human_resources_department_by_organizational_chart_area.human_resources_department_id');
        $parent_manager_id = $params['filters']["parent_manager_id"];
        $business_id = $params['filters']["businessId"];
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->orWhere($this->table . '.name', 'like', '%' . $like . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $like . '%');
        }
        $query->where($this->table . '.business_id', '=', $business_id);
        $query->where('human_resources_department_by_organizational_chart_area.human_resources_organizational_chart_area_id', '=', $parent_manager_id);

        $query->limit(10)->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getListAllArea($params)
    {


        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name as text ";
        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = isset($params['filters']["business_id"]) ? $params['filters']["business_id"] : (
        isset($params['filters']["businessId"]) ? $params['filters']["businessId"] : null

        );
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->orWhere($this->table . '.name', 'like', '%' . $like . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $like . '%');
        }
        if ($business_id != null) {
            $query->where($this->table . '.business_id', '=', $business_id);

        }

        $query->limit(10)->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
