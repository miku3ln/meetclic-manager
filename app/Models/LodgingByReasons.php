<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingByReasons extends Model
{
    const reasonTypeJob = 0;
    const reasonTypeJobText = "Por Trabajo";

    const reasonTypeHoliday = 1;
    const reasonTypeHolidayText = "Vacaciones";

    const reasonTypeSpendTheNight = 2;
    const reasonTypeSpendTheNightText = "Pasar la noche";

    const reasonTypeOthers = 3;
    const reasonTypeOthersText = "Otros";

    const reasonTypeUnspecified = 4;
    const reasonTypeUnspecifiedText = "Sin Especificar";
    
    const typeSocialNetworksOthers = 5;
    const typeSocialNetworksOthersText = "Otras";
    protected $table = 'lodging_by_reasons';

    protected $fillable = array(
        "lodging_id",//*
        "reason",//*
    );
    public $attributesData = array(
        "lodging_id",//*
        "reason",//*
    );
    public $timestamps = false;
    public static function getRulesModel()
    {
        $rules = [
            "lodging_id" => 'required',
            "reason" => 'required'
        ];
        return $rules;
    }
    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getReasonByArrived($params)
    {


        $lodging_id = $params["lodging_id"];
        $query = DB::table($this->table);
        $compare = "IF($this->table.reason=" . self::reasonTypeJob . ",'" . self::reasonTypeJobText . "',IF($this->table.reason=" . self::reasonTypeHoliday . ",'" . self::reasonTypeHolidayText . "',IF($this->table.reason=" . self::reasonTypeSpendTheNight . ",'" . self::reasonTypeSpendTheNightText . "',IF($this->table.reason=" . self::reasonTypeOthers . ",'" . self::reasonTypeOthersText . "',IF($this->table.reason=" . self::reasonTypeUnspecified . ",'" . self::reasonTypeUnspecifiedText . "',IF($this->table.reason=" . self::typeSocialNetworksOthers . ",'" . self::typeSocialNetworksOthersText . "',2)))))) as reason_text";
        $selectString = "$this->table.id lodging_by_reasons_id ,$this->table.lodging_id,$compare,$this->table.reason";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_id", '=', $lodging_id);
        $data = $query->get()->first();
        return $data;
    }

}
