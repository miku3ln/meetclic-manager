<?php
//CPP-010
namespace App\Models\HumanResources;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HumanResourcesDepartmentByOrganizationalChartArea extends ModelManager
{
    protected $nameModel = 'HumanResourcesDepartmentByOrganizationalChartArea';


    protected $table = 'human_resources_department_by_organizational_chart_area';
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
        "human_resources_department_id",
        "human_resources_organizational_chart_area_id",//
    );
    public $attributesData = array(
        "id",//*
        "human_resources_department_id",
        "human_resources_organizational_chart_area_id",//
    );

    public static function getRulesModel()
    {
        $rules = [
            "human_resources_department_id" => 'required',
            "human_resources_organizational_chart_area_id" => 'required',
        ];
        return $rules;
    }

    public static $selection = 'id,human_resources_department_id,human_resources_organizational_chart_area_id';

    public function getDataByChartArea($params)
    {
        $parent_id = $params["id"];
        $query = DB::table($this->table);
        $joinOne = 'human_resources_organizational_chart_area';
        $joinTwo = 'human_resources_department';
        $selectString = "$this->table.id,$this->table.human_resources_organizational_chart_area_id,$this->table.human_resources_department_id
        ," . $joinOne . ".name " . $joinOne . "Name
        ," . $joinTwo . ".name " . $joinTwo . "Name
        ";
        $select = DB::raw($selectString);
        $query->select($select);

        $query->join($joinOne, $this->table . '.human_resources_organizational_chart_area_id', '=', $joinOne . '.id')
            ->join($joinTwo, $this->table . '.human_resources_department_id', '=', $joinTwo . '.id');
        $query->where($this->table . ".human_resources_organizational_chart_area_id", '=', $parent_id);
        $data = $query->get()->toArray();
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


            $modelParent = HumanResourcesOrganizationalChartArea::find($attributesPost[$this->nameModel]['human_resources_organizational_chart_area_id']);
            $modelParentRelation = new HumanResourcesOrganizationalChartArea();
            $modelParentRelation->id = $modelParent->id;
            $postData = $attributesPost[$this->nameModel];

            $dataRelations = $postData["departments"];
            $success = $modelParentRelation->departmentsAdd()->sync(
                explode(',',
                    $dataRelations
                )
            );

            $success = true;
            $msj = "Guardado Correctamente.!";
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



