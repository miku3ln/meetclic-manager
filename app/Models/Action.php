<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Action extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    const typeManager = 0;//manager is link
    const typeMethod = 1;//method
    const typeRoot = 2;//init menu root

    protected $table = 'actions';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';
    /*
     * this parameter add or remove timestamps columns depending its status
     */
    public $timestamps = false;

    public function allowedActions()
    {
        return $this->hasMany(AllowedAction::class, 'action_id');
    }

    protected $fillable = array(
        "id",//*
        "name",//*
        "link",//*
        "parent_id",
        "weight",
        "icon",
        "type",//*
        "description",//
        "type_item",//*

    );
    public $attributesData = array(
        "id",//*
        "name",//*
        "link",//*
        "parent_id",
        "weight",
        "icon",
        "type",//*
        "description",//
        "type_item",//*

    );


    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',
            "link" => 'required',
            "type" => 'required',
            "description" => 'required',
            "type_item" => 'required'

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

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.name ,$this->table.type_item,$this->table.link,$this->table.parent_id,$this->table.weight,$this->table.icon,$this->table.type,$this->table.description
   ";

        $select = DB::raw($selectString);
        $query->select($select);


        if (isset($params['searchPhrase'] )) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($this->table . '.icon', 'like', $likeSet)
                    ->orWhere($this->table . '.link', 'like', $likeSet)
                    ->orWhere($this->table . '.weight', 'like', $likeSet);

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
        $model = new Action();
        foreach ($result["rows"] as $key => $row) {
            $parent_id = $row->parent_id;
            $setPush = json_decode(json_encode($row), true);
            $result["rows"][$key] = $setPush;
            $parent = "";
            if ($parent_id) {
                $resultParent = $model->getActionParent(array("parent_id" => $parent_id));
                $parent = $resultParent->name;
            }
            $result["rows"][$key]["parent"] = $parent;


        }


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

            $model = new Action();
            $createUpdate = true;
            if (isset($attributesPost["Actions"]["id"]) && $attributesPost["Actions"]["id"] != "null" && $attributesPost["Actions"]["id"] != "-1") {
                $model = Action::find($attributesPost["Actions"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["Actions"];
            $attributesSet = array(
                "name" => $postData["name"],
                "link" => $postData["type"] == self::typeRoot ? "#" : $postData["link"],
                "parent_id" => $postData["parent_id"],
                "weight" => $postData["weight"],
                "icon" => $postData["icon"],
                "type" => $postData["type"],
                "type_item" => $postData["type_item"],
                "description" => $postData["description"],

            );


            $validateResult = Action::validateModel($attributesSet);
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

    public function getListActionsParent($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name as text ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->where('type', '=', self::typeRoot);

        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->where('name', 'like', '%' . $like . '%');
        }

        $query->limit(10)->orderBy('name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}



