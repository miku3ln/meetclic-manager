<?php
//CPP-010
namespace App\Models\PayRoll;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class HumanResourcesDepartmentByRestDay extends ModelManager
{

    protected $table = 'human_resources_department_by_rest_day';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $modelName = 'HumanResourcesDepartmentByRestDay';
    protected $fillable = array(
        "id",//*
        "human_resources_department_id",//*
        "days",//*
        "status",//*
        "predetermined",//*


    );
    public $attributesData = array(
        "id",//*
        "human_resources_department_id",//*
        "days",//*
        "status",//*
        "predetermined",//*
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
            "human_resources_department_id" => 'required',
            "days" => 'required',
            "status" => 'required',
            "predetermined" => 'required',
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
        $relationOne = 'human_resources_department';


        $selectString = $this->fieldsCurrentSelect;
        $selectString .= "," . $relationOne . ".name " . $relationOne . "_name";
        $query->join($relationOne, $this->table . '.human_resources_department_id', '=', $relationOne . '.id');

        $select = DB::raw($selectString);
        $query->select($select);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet,
                $relationOne
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($relationOne . '.name', 'like', $likeSet);

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

            $model = new HumanResourcesDepartmentByRestDay();
            $createUpdate = true;
            if (isset($attributesPost[$this->modelName]["id"]) && $attributesPost[$this->modelName]["id"] != "null" && $attributesPost[$this->modelName]["id"] != "-1") {
                $model = HumanResourcesDepartmentByRestDay::find($attributesPost[$this->modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }
            $postData = $attributesPost[$this->modelName];
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

    public function getListData($params)
    {

        $query = DB::table($this->table);

        $conditionText = "$this->table.name text";

        $selectString = "$this->table.id ,$this->table.days ,$conditionText ,$this->table.business_id";

        $relationOne = 'human_resources_department';
        $selectString .= "," . $relationOne . ".name " . $relationOne . "_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join($relationOne, $this->table . '.human_resources_department_id', '=', $relationOne . '.id');

        $business_id = ($params['filters']["business_id"]);
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];
            $query->where($this->table . 'days', 'like', '%' . $like . '%')
                ->orWhere($relationOne . '.name', 'like', '%' . $like . '%')
                ->orWhere($relationOne . '.code', 'like', '%' . $like . '%');


        }
        $query->where('business_id', '=', $business_id);
        $query->where('status', '=', 'ACTIVE');


        $query->limit(10)->orderBy('id', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }


}



