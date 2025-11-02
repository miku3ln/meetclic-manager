<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CustomerByInformation extends Model
{

    protected $table = 'customer_by_information';

    protected $fillable = array(
        "customer_id",//*
        "people_nationality_id",//*
        "people_profession_id",//*

    );
    public $attributesData = array(
        "customer_id",//*
        "people_nationality_id",//*
        "people_profession_id",//*

    );
    public $timestamps = false;
    const MESSAGES = [
        'people_nationality_id.required' => 'Nacionalidad es requerido.',
        'people_profession_id.required' => 'Profesion es requerido.',
        'customer_id.required' => 'Cliente es requerido.'

    ];

    public static function getRulesModel()
    {
        $rules = [
            "customer_id" => 'required',
            "people_nationality_id" => 'required',
            "people_profession_id" => 'required',
        ];
        return $rules;
    }


    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules, CustomerByInformation::MESSAGES);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

}
