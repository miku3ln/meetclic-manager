<?php
//CPP-010
namespace App\Models\WorkPlanning;

use App\Models\Exception;
use App\Models\ModelManager;

use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WorkPlanningHeader extends ModelManager
{


    protected $table = 'work_planning_header';
    protected $nameModel = 'WorkPlanningHeader';
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
        "hours",//*
        "business_id",
        "user_id",//*


    );
    public $attributesData = array(
        "id",
        "name",//*
        "description",
        "created_at",
        "status",//*
        "predetermined",
        "year",//*
        "hours",//*
        "business_id",
        "user_id",//*

    );

    public $fieldsCurrentSelect = '';

    public function __construct()
    {

        $this->fieldsCurrentSelect = $this->getFieldsSelectModel();

    }

    public function getFieldsSelectModel()
    {
        $fieldsArray = $this->fillable;
        return Util::getFieldsSelect(Util::getFieldsByAttributes($fieldsArray), $this->table);
    }

    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',
            "status" => 'required',
            "year" => 'required',
            "hours" => 'required',
            "business_id" => 'required',
            "user_id" => 'required',

        ];
        return $rules;
    }

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
        $selectString = "$this->fieldsCurrentSelect";
        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }
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
        $resultManager = $this->setFilterQueryAdmin($query, $field, $sort, $params);
        $total = $resultManager['total'];
        $result['total'] = $total;
        $result['rows'] = $resultManager['data'];
        $result['current'] = $resultManager['current_page'];
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

            $model = new WorkPlanningHeader();
            $createUpdate = true;
            if (isset($attributesPost[$this->nameModel]["id"]) && $attributesPost[$this->nameModel]["id"] != "null" && $attributesPost[$this->nameModel]["id"] != "-1") {
                $model = WorkPlanningHeader::find($attributesPost[$this->nameModel]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost[$this->nameModel];
            $user = Auth::user();
            $year = date("Y");
            $postData['year'] = $year;
            $postData['user_id'] = $user->id;
            $attributes = $model->getValuesByPost($postData, $createUpdate);

            $model->attributes = $attributes;
            $successManager = $model->validate();
            $success = $successManager['success'];

            if ($success) {
                $model->fill($attributes);
                $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar .";
                $errors = $successManager["errors"];
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



