<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ClinicalByHistoryClinic extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clinical_by_history_clinic';

    protected $fillable = array( "history_clinic_id","clinical_exam_id", 'pathology_description');

    public $timestamps = false;

    public function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity . "s";
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
}
