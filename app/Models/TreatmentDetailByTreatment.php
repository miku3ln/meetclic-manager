<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Util;

use DB;

class TreatmentDetailByTreatment extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'treatment_detail_by_treatment';

    protected $fillable = array(
        "treatment_id",
        "treatment_plan_by_patient_id",
        "status",
        "description",
        "price",
        "discount"
    );

    public $timestamps = true;
    public $util_component;

    public function __construct()
    {

        $this->util_component = new Util();
    }

    public function getActionsManager()
    {
        $model_entity = $this->util_component->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "s" . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity . "s";
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->util_component->getCamelCase($this->table);
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
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

    public function getDetailsTreatmentByTreatmentPlanByPatientId($treatment_plan_by_patient_id)
    {
        $status = "ACTIVE";
        $query = DB::table($this->table)
            ->select(
                $this->table . ".id",
                $this->table . ".treatment_id",
                $this->table . ".treatment_plan_by_patient_id",
                $this->table . ".status",
                $this->table . ".price",
                $this->table . ".discount",
                "treatment.name as treatment_name",
                "treatment.id as treatment_id"

            );
        $query->join("treatment", $this->getTable() . ".treatment_id", "=", "treatment.id");
        $query->where($this->table . ".treatment_plan_by_patient_id", "=", $treatment_plan_by_patient_id);
        $query->where($this->table . ".status", "=", $status);

        return $query->get();
    }

    public function getColumnsNameAdmin()
    {
        $result = array(
            array(
                "data-column-id" => "id",
                "data-identifier" => "true",
                "data-type" => "numeric",
                'data-visible' => "false",
                "text" => "Id"

            ),
            array(
                "data-column-id" => "treatment_name",
                "data-formatter" => "treatment_name",
                "text" => "Nombre",
            ),
            array(
                "data-column-id" => "doctor_name",
                "data-formatter" => "doctor_name",
                "text" => "Dr. Nombre",
            ),
            array(
                "data-column-id" => "tax",
                "data-formatter" => "tax",
                "text" => "Impuesto",
            ),
            array(
                "data-column-id" => "subtotal",
                "data-formatter" => "subtotal",
                "text" => "Subtotal",
            ),

            array(
                "data-column-id" => "discount",
                "data-formatter" => "discount",
                "text" => "Descuento",
            ),
            array(
                "data-column-id" => "total_price",
                "data-formatter" => "total_price",
                "text" => "Total",
            ),
            array(
                "data-column-id" => "status",
                "data-formatter" => "status",
                "text" => "Estado",
            ),

        );
        return $result;
    }

    public function getColumnsNameDetailsTreatment()
    {
        $result = array(
            array(
                "data-column-id" => "id",
                "data-identifier" => "true",
                "data-type" => "numeric",
                'data-visible' => "false",
                "text" => "Id"

            ),
            array(
                "data-column-id" => "treatment_name",
                "data-formatter" => "treatment_name",
                "text" => "Tratamiento",
            ),
            array(
                "data-column-id" => "treatment_id",
                "data-formatter" => "treatment_id",
                "text" => "Tratamiento Id",
                'data-visible' => "false",
            ),
            array(
                "data-column-id" => "discount",
                "data-formatter" => "discount",
                "text" => "Descuento",
                'data-visible' => "false",
            ),

            array(
                "data-column-id" => "price",
                "data-formatter" => "price",
                "text" => "Precio",
            ),
            array(
                "data-column-id" => "remove-item",
                "data-formatter" => "remove-item",
                "text" => "",
            ),


        );
        return $result;
    }


}
