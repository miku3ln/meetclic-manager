<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Util;

use DB;

class DentalPieceByOdontogram extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_piece_by_odontogram';

    protected $fillable = array("status", "created_at", 'update_at', "delete_at", "dental_piece_id", "reference_piece_position_id", "reference_piece_id", "odontogram_by_patient_id", 'type');

    public $timestamps = true;
    public $util_component;
    protected $attributesData = [
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'date', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'dental_piece_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'reference_piece_position_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'reference_piece_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'odontogram_by_patient_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],


    ];
    public static function getRulesModel()
    {
        $rules = [
            "status" => "required",
            "dental_piece_id" => "required|numeric",
            "reference_piece_position_id" => "required|numeric",
            "reference_piece_id" => "required|numeric",
            "odontogram_by_patient_id" => "required|numeric",
            "type" => "required",

        ];
        return $rules;
    }
    public function __construct()
    {

        $this->util_component = new Util();
    }

    public function getActionsManager()
    {
        $model_entity = $this->util_component->getUpperCaseTable($this->table);
        $action_get_form = "Odontogram" . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = "Odontogram" . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = "Odontogram" . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity . "s";
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

    public function getDataDentalPieceByOdontogramId($params)
    {
        $odontogram_by_patient_id = $params["odontogram_by_patient_id"];
        $state = isset($params["state"]) ? $params["state"] : null;

        $query = DB::table($this->table)
            ->select(
                $this->table . '.dental_piece_id', $this->table . '.reference_piece_position_id', $this->table . '.reference_piece_id', $this->table . '.description', $this->table . '.status', $this->table . '.created_at', $this->table . '.id', $this->table . ".type",
                DB::raw('dental_piece.name as dental_piece_name'), DB::raw('dental_piece.piece as dental_piece_piece'), DB::raw('dental_piece.dentition as dental_piece_dentition'),
                DB::raw('reference_piece_position.position as reference_piece_position_position'),
                DB::raw('reference_piece.name as reference_piece_name'), DB::raw('reference_piece.type as reference_piece_type'),
                DB::raw('reference_piece_type.color as reference_piece_color'), DB::raw('reference_piece_type.name as reference_piece_name')

            )
            ->join('dental_piece', 'dental_piece.id', '=', $this->table . '.dental_piece_id')
            ->join('reference_piece_position', 'reference_piece_position.id', '=', $this->table . '.reference_piece_position_id')
            ->join('reference_piece', 'reference_piece.id', '=', $this->table . '.reference_piece_id')
            ->join('reference_piece_type', 'reference_piece_type.id', '=', 'reference_piece.reference_type_id');

        $query->where("dental_piece_by_odontogram.odontogram_by_patient_id", "=", $odontogram_by_patient_id);
        if ($state) {
            $query->where("t.state", "=", $state);
        }
        $query->orderBy('reference_piece.type', "desc");
        return $query->get();
    }
}
