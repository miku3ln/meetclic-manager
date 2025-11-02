<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class BusinessByRequirements extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_requirements';

    protected $fillable = array(
        'title', //*
        'description',
        'status', //*
        'business_id', //*
        'created_at',
        'updated_at',
        'deleted_at',


    );
    protected $attributesData = [
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],


    ];
    public $timestamps = true;

    protected $field_main = 'title';

    public static function getRulesModel()
    {
        $rules = [
            "title" => "required|max:150",
            "description" => "required",

            "status" => "required",
            "business_id" => "required|numeric",


        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'status';

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.title,$this->table.description,$this->table.status,business.title as business,
business.id as business_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
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
            $modelName = 'BusinessByRequirements';
            $model = new BusinessByRequirements();
            $createUpdate = true;

            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = BusinessByRequirements::find($attributesPost['id']);
                $createUpdate = false;

            } else {
                $createUpdate = true;
            }

            $BusinessByRequirementsData = $attributesPost;
            $business_id = $attributesPost["business_id"];



            $successMultimedia =  true;
            if ($successMultimedia) {



                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $BusinessByRequirementsData, 'attributesData' => $this->attributesData));
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
                    $msj = "Problemas al guardar  BusinessByRequirements.";
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
            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;
    }


    public function getDataFrontend($params)
    {
        $sort = 'asc';
        $field = 'id';

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];


        $selectString = "$this->table.id,$this->table.title,$this->table.description,$this->table.status,business.title as business,
        business.id as business_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->where($this->table . '.business_id', '=', $business_id);

        $status = 'ACTIVE';

        $query->where($this->table . '.status', '=', $status);

        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();




        return $result;
    }


}
