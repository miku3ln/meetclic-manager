<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class PeopleProfession extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    protected $table = 'people_profession';
    const TYPE_ANYONE = 1;

    protected $fillable = array(
        "name",//*
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "status",//*
    );
    public $attributesData = array(
        "name",//*
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "status",//*
    );
    public $timestamps = true;

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

    public function getDataListAll()
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id value ,$this->table.name text ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("$this->table.status", "ACTIVE");
        $query->orderBy("$this->table.name", "asc");
        $result = $query->get()->toArray();

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
        $selectString = "$this->table.id ,$this->table.name ,$this->table.description,$this->table.status
  ";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where($this->table . '.name', 'like', $likeSet)
                ->orWhere($this->table . '.description', 'like', $likeSet);
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

            $model = new PeopleProfession();
            $createUpdate = true;
            if (isset($attributesPost["PeopleProfession"]["id"]) && $attributesPost["PeopleProfession"]["id"] != "null" && $attributesPost["PeopleProfession"]["id"] != "-1") {
                $model = PeopleProfession::find($attributesPost["PeopleProfession"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["PeopleProfession"];
            $attributesSet = array(
                "name" => $postData["name"],
                "description" => isset($postData["description"]) ? $postData["description"] : ""
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
}
