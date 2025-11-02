<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class PeopleTypeIdentification extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    protected $table = 'people_type_identification';
    const TYPE_IDENTIFICATION_RUC = 1;
    const TYPE_IDENTIFICATION_CARD = 2;//CEDULA
    const TYPE_IDENTIFICATION_OTHERS = 3;
    const TYPE_IDENTIFICATION_PASSPORT = 4;
    const TYPE_IDENTIFICATION_FINAL_CONSUMER = 5;
    const TYPE_IDENTIFICATION_PL = 6;
    protected $fillable = array(
        "name",//*
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "status",//*
        "code"
    );
    public $attributesData = array(
        "name",//*
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "status",//*
        "code"

    );
    public $timestamps = true;

    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',


        ];
        return $rules;
    }

    const TYPE_RUC_ID = 1;
    const TYPE_CEDULA_ID = 2;
    const TYPE_OTHERS_ID = 3;
    const TYPE_PASSPORT_ID = 4;
    const TYPE_FINAL_CONSUMER_ID = 5;


    public static function getAllIdentification()
    {

        $result = array(
            self::TYPE_RUC_ID => 'RUC',
            self::TYPE_CEDULA_ID => 'CEDULA',
            self::TYPE_PASSPORT_ID => 'PASAPORTE',
            self::TYPE_FINAL_CONSUMER_ID => 'CONSUMIDOR FINAL',
            self::TYPE_OTHERS_ID => 'OTROS',


        );
        return $result;
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
        $selectString = "$this->table.id ,$this->table.name ,$this->table.description,$this->table.status,$this->table.code
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

            $model = new PeopleTypeIdentification();
            $createUpdate = true;
            if (isset($attributesPost["PeopleTypeIdentification"]["id"]) && $attributesPost["PeopleTypeIdentification"]["id"] != "null" && $attributesPost["PeopleTypeIdentification"]["id"] != "-1") {
                $model = PeopleTypeIdentification::find($attributesPost["PeopleTypeIdentification"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["PeopleTypeIdentification"];
            $attributesSet = array(
                "name" => $postData["name"],
                "description" => isset($postData["description"]) ? $postData["description"] : "",
                "code" => isset($postData["code"]) ? $postData["code"] : "",

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

    public function getDataListAll($params = array())
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'name';
        $selectString = $this->table . ".id value,$this->table.name text";
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }
}
