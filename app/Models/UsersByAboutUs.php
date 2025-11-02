<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class UsersByAboutUs extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'users_by_about_us';

    protected $fillable = array(
        'users_id',//*
        'description',//*
        'web'
    );
    protected $attributesData = [
        ['column' => 'users_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'web', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],

    ];
    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        $rules = ["users_id" => "required|numeric",
            "description" => "required",


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

        $selectString = "$this->table.id,users.name as users,
users.id as users_id,
$this->table.description";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('users', 'users.id', '=', $this->table . '.users_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("users.name", 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
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
            $modelName = 'UsersByAboutUs';
            $model = new UsersByAboutUs();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = UsersByAboutUs::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $usersByAboutUsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $usersByAboutUsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  UsersByAboutUs.";
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

    public function getInformation($params)
    {


        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.description,$this->table.web";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('users', 'users.id', '=', $this->table . '.users_id');
        $users_id = isset($params['filters']['users_id']) ? $params['filters']['users_id'] : null;
        if ($users_id) {
            $query->where($this->table . '.users_id', '=', $users_id);
        }

        $result = $query->first();
        return $result;

    }


}
