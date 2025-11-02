<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BusinessScheduleByBreakdown extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
const TYPE_24HOURS=0;
    const TYPE_BREAKDOWN=1;

    protected $table = 'business_schedule_by_breakdown';

    protected $fillable = array(
        "start_time",//*
        "status",//*
        "business_by_schedule_id",//*
        "end_time"//*
    );
    public $attributesData = array(
        "start_time",//*
        "status",//*
        "business_by_schedule_id",//*
        "end_time"//*

    );
    public $timestamps = false;

    public function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity;
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->getCamelCase();
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }

    public function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public function getCamelCase()
    {

        return lcfirst($this->getUpperCaseTable($this->table));
    }

    public function findAllByAttributes($attributes = array(), $values = array(), $columns = array('*'))
    {
        $response = DB::table($this->table)
            ->select($columns);
        if (!is_array($attributes) || !is_array($values)) {
            throw new Exception('$attributes and $values should be array.');
        }
        if (count($attributes) < 1 || count($values) < 1) {
            throw new Exception('$attributes and $values can not be empty.');
        }
        if (count($attributes) != count($values)) {
            throw new Exception('$attributes and $values must have the same length.');
        }
        foreach ($attributes as $key => $attribute) {
            $response->where($attribute, "=", $values[$key]);
        }
        return $response->get();
    }


    public function getBreakdownSchedule($params)
    {

        $sort = isset($params['sort']) ? $params['sort'] : 'asc';

        $columns = "*";
        $business_by_schedule_id = $params["business_by_schedule_id"];
        $query = DB::table($this->table)
            ->select($columns);
        $query->where("business_by_schedule_id", $business_by_schedule_id);
        $result = $query->get();

        return $result;
    }

    public function getBreakdownScheduleStructure($params)
    {
        $result = array();
        $haystack = $params["haystack"];
        foreach ($haystack as $key => $row) {
            // your code
            $modelStartTime = $row->start_time;
            $modelEndTime = $row->end_time;
            $setPush = array(
                "start_time" => array("id" => $row->id, "modelBreakdown" => $modelStartTime, "error" => true, "msj" => "", "init" => true),
                "end_time" => array("id" => $row->id, "modelBreakdown" => $modelEndTime, "error" => true, "msj" => "", "init" => true),

            );
            array_push($result, $setPush);
        }


        return $result;
    }
}
