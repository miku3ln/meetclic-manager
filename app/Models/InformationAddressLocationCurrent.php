<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InformationAddressLocationCurrent extends Model
{


    protected $table = 'information_address_location_current';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';
    /*
     * this parameter add or remove timestamps columns depending its status
     */
    public $timestamps = false;

    protected $fillable = array(
        "country_code_id",//*
        "administrative_area_level_2",//*google code types Ciudad
        "administrative_area_level_1",//*google code types Provincia
        "administrative_area_level_3",//google code types parroquia ,comunidad
        "options_map",//*google code types parroquia ,comunidad
        "entity_id",//*
        "entity_type",//*

    );
    protected $attributesData =[
        ['column'=>'country_code_id','type'=>'string','defaultValue'=>'','required'=>'true'],
        ['column'=>'administrative_area_level_2','type'=>'string','defaultValue'=>'','required'=>'true'],
        ['column'=>'administrative_area_level_1','type'=>'string','defaultValue'=>'','required'=>'false'],
        ['column'=>'administrative_area_level_3','type'=>'string','defaultValue'=>'','required'=>'false'],
        ['column'=>'options_map','type'=>'string','defaultValue'=>'','required'=>'true'],
        ['column'=>'entity_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
        ['column'=>'entity_type','type'=>'integer','defaultValue'=>'0','required'=>'true']

    ];


    public static function getRulesModel()
    {
        $rules = ["country_code_id" => "required|max:250",
            "administrative_area_level_2" => "required|max:250",
            "administrative_area_level_1" => "max:250",
            "administrative_area_level_3" => "max:250",
            "options_map" => "required",
            "entity_id" => "required|numeric",
            "entity_type" => "required|numeric"
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

    public function getEntityByParams($params)
    {
        $entity_id = $params['entity_id'];
        $entity_type = $params['entity_type'];

        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.country_code_id,$this->table.administrative_area_level_2,$this->table.administrative_area_level_1,$this->table.administrative_area_level_3,$this->table.options_map,$this->table.entity_id,$this->table.entity_type";

        $select = DB::raw($selectString);

        $query->select($select);
        $query->where($this->table . '.entity_id', '=', $entity_id);
        $query->where($this->table . '.entity_type', '=', $entity_type);
        $result = $query->get()->toArray();
        return $result;
    }

}
