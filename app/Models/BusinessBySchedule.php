<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessScheduleByBreakdown;

class BusinessBySchedule extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const WEIGHT_DAY_MONDAY = 0;
    const WEIGHT_DAY_TUESDAY = 1;
    const WEIGHT_DAY_WEDNESDAY = 2;
    const WEIGHT_DAY_THURSDAY = 3;
    const WEIGHT_DAY_FRIDAY = 4;
    const WEIGHT_DAY_SATURDAY = 5;
    const WEIGHT_DAY_SUNDAY = 6;


    const ID_MONDAY = 1;
    const ID_TUESDAY = 2;
    const  ID_WEDNESDAY = 3;
    const  ID_THURSDAY = 4;
    const  ID_FRIDAY = 5;
    const  ID_SATURDAY = 6;
    const  ID_SUNDAY = 7;

    const OPEN = 1;
    const CLOSE = 0;
    const TYPE_24 = 0;
    const TYPE_BREAKDOWN = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_by_schedule';

    protected $fillable = array(
        "schedule_days_category_id",//*
        "type",//*
        "open",//*
        "business_id",//*
        "status",//*


    );
    public $attributesData = array(
        "schedule_days_category_id",//*
        "type",//*
        "open",//*
        "business_id",//*
        "status",//*

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


    public function getSchedulesByBusiness($params)
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'schedule_days_category.weight_day';
        $select = "$this->table.id,$this->table.open,$this->table.status,$this->table.schedule_days_category_id,$this->table.type,$this->table.business_id
        ,schedule_days_category.name schedule_days_category_day,schedule_days_category.name,schedule_days_category.weight_day,schedule_days_category.description schedule_days_category_description";
        $business_id = $params["business_id"];
        $select = DB::raw($select);
        $query = DB::table($this->table)
            ->select($select);
        $query->join('schedule_days_category', "$this->table.schedule_days_category_id", '=', 'schedule_days_category.id');
        $query->where("business_id", $business_id);
        $query->orderBy($field, $sort);
        return $query->get();
    }

    public function getSchedulesStructureInit($params)
    {
        $business_id = $params["business_id"];
        $result = array(
            array("schedule_days_category_id" => self::ID_MONDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
            array("schedule_days_category_id" => self::ID_TUESDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
            array("schedule_days_category_id" => self::ID_WEDNESDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
            array("schedule_days_category_id" => self::ID_THURSDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
            array("schedule_days_category_id" => self::ID_FRIDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
            array("schedule_days_category_id" => self::ID_SATURDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
            array("schedule_days_category_id" => self::ID_SUNDAY, "type" => self::TYPE_24, "open" => self::CLOSE, "status" => self::STATUS_ACTIVE, "business_id" => $business_id),
        );
        return $result;
    }

    public function getStructureSchedulesBusiness($params)
    {
        $business_id = $params["business_id"];
        $modelbsbb = new BusinessScheduleByBreakdown;
        $result = array();
        $schedules = $this->getSchedulesByBusiness(array("business_id" => $business_id));
        foreach ($schedules as $key => $row) {

            $business_by_schedule_id = $row->id;
            $dataBreakdownCurrent = $row->type == 1 ? $modelbsbb->getBreakdownScheduleStructure(array("haystack" => $modelbsbb->getBreakdownSchedule(array("business_by_schedule_id" => $business_by_schedule_id)))) : array();
            $setPush = array(
                "id" => $row->id,
                "name" => "element-" . $row->id,
                "text" => $row->name,//*
                "type" => $row->type,//*
                "modelDay" => $row->open == 1 ? true : false,//*
                "business_id" => $row->business_id,//*
                "status" => $row->status,//*
                "weight_day" => $row->weight_day,
                "configTypeSchedule" => array(
                    "type" => $row->type == 1 ? true : false,//*
                    "data" => $dataBreakdownCurrent
                )
            );

            array_push($result, $setPush);
        }

        return $result;

    }

    public function getModelScheduleById($params)
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'schedule_days_category.weight_day';
        $selectString = "$this->table.id,$this->table.type,$this->table.open,$this->table.business_id,$this->table.status
        ,schedule_days_category.id schedule_days_category_id,schedule_days_category.name schedule_days_category,schedule_days_category.weight_day,schedule_days_category.description";
        $select = DB::raw($selectString);

        $id = $params["id"];
        $query = DB::table($this->table)
            ->select($select);
        $query->join('schedule_days_category', "$this->table.schedule_days_category_id", '=', 'schedule_days_category.id');

        $query->where($this->table.".id", "=", $id);
        $query->orderBy($field, $sort);
        return $query->get();
    }
}
