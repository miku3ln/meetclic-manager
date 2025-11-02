<?php
//CPP-010
namespace App\Models\PayRoll;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class HumanResourcesEmployeePermissionByDetails extends ModelManager
{

    protected $table = 'human_resources_employee_permission_by_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $modelName = 'HumanResourcesEmployeePermissionByDetails';
    protected $fillable = array(
        "id",//*
        "human_resources_permission_type_id",//*
        "human_resources_employee_profile_by_permission_id",//*
        "hours",//*
        "created_at",//*
        "year",//*
        "hours_since",//*
        "hours_until",//*
        "note",//*
        "day_name",//*


    );
    public $attributesData = array(
        "id",//*
        "human_resources_permission_type_id",//*
        "human_resources_employee_profile_by_permission_id",//*
        "hours",//*
        "created_at",//*
        "year",//*
        "hours_since",//*
        "hours_until",//*
        "note",//*
        "day_name",//*

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
        return [


            "human_resources_permission_type_id" => 'required',
            "human_resources_employee_profile_by_permission_id" => 'required',
            "hours" => 'required',
            "created_at" => 'required',
            "year" => 'required',
            "hours_since" => 'required',
            "hours_until" => 'required',//*
            "note" => 'required',
            "day_name" => 'required',
        ];
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
        $relationOne = 'human_resources_permission_type';
        $relationTwo = 'human_resources_employee_profile_by_permission';


        $selectString = $this->fieldsCurrentSelect;
        $selectString .= "," . $relationOne . ".name " . $relationOne . "_name" . "," . $relationOne . ".code " . $relationOne . "_code";


        $query->join($relationOne, $this->table . '.human_resources_permission_type_id', '=', $relationOne . '.id');
        $query->join($relationTwo, $this->table . '.human_resources_employee_profile_by_permission_id', '=', $relationTwo . '.id');

        $select = DB::raw($selectString);
        $query->select($select);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet,
                $relationOne,
                $relationTwo
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($relationOne . '.name', 'like', $likeSet)
                    ->orWhere($relationOne . '.cod', 'like', $likeSet);

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
        return $this->getAdmin($params);

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

            $model = new HumanResourcesEmployeePermissionByDetails();
            $createUpdate = true;
            if (isset($attributesPost[$this->modelName]["id"]) && $attributesPost[$this->modelName]["id"] != "null" && $attributesPost[$this->modelName]["id"] != "-1") {
                $model = HumanResourcesEmployeePermissionByDetails::find($attributesPost[$this->modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }
            $postData = $attributesPost[$this->modelName];
            $year = date("Y");
            $postData['year'] = $year;
            $attributes = $model->getValuesByPost($postData, $createUpdate);
            $model->attributes = $attributes;
            $validateResult = $model->validate();
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributes);
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



