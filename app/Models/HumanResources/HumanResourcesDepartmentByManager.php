<?php
//CPP-010
namespace App\Models\HumanResources;

use App\Models\Exception;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;


class HumanResourcesDepartmentByManager extends ModelManager
{
    protected $nameModel = 'HumanResourcesDepartmentByManager';


    protected $table = 'human_resources_department_by_manager';
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
        "type_manager",//*
        "human_resources_employee_profile_id",
        "human_resources_department_id",//
        "range"
    );
    public $attributesData = array(
        "id",//*
        "type_manager",//*
        "human_resources_employee_profile_id",
        "human_resources_department_id",//
        "range"

    );


    public static function getRulesModel()
    {
        $rules = [


            "human_resources_employee_profile_id" => 'required',
            "human_resources_department_id" => 'required',
        ];
        return $rules;
    }

    public static $selection = 'human_resources_employee_profile_id,human_resources_department_id';
    public static $selectTwo = 'CONCAT(code," " ,name)';


    public function getResponsible($params)
    {
        $parent_id = $params["id"];
        $query = DB::table($this->table);
        $joinOne = 'human_resources_department';
        $joinTwo = 'human_resources_employee_profile';
        $joinThree = 'people';

        $selectString = "$this->table.id,$this->table.human_resources_department_id,$this->table.human_resources_employee_profile_id,$this->table.type_manager,$this->table.range
        ,".$joinOne.".name ".$joinOne."Name
        ,CONCAT(".$joinThree.".name ,' ',".$joinThree.".last_name) fullName";
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join($joinOne, $this->table . '.human_resources_department_id', '=', $joinOne . '.id')
            ->join($joinTwo, $this->table . '.human_resources_employee_profile_id', '=', $joinTwo . '.id')
            ->join($joinThree, $joinTwo . '.people_id', '=', $joinThree . '.id');
        $query->where($this->table.".human_resources_department_id", '=', $parent_id);
        $data = $query->get()->first();
        return $data;
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

            $model = new HumanResourcesDepartmentByManager();
            $createUpdate = true;
            if (isset($attributesPost[$this->nameModel]["id"]) && $attributesPost[$this->nameModel]["id"] != "null" && $attributesPost[$this->nameModel]["id"] != "-1") {
                $model = HumanResourcesDepartmentByManager::find($attributesPost[$this->nameModel]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost[$this->nameModel];
            $attributesSet = array(

                "type_manager" => 1,//*
                "human_resources_employee_profile_id" => $postData["human_resources_employee_profile_id"],
                "human_resources_department_id" => $postData["human_resources_department_id"],//
                "range" => 1

            );

            $model->attributes = $attributesSet;
            $validateResult = $model->validate();
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



