<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class People extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    protected $table = 'people';

    protected $fillable = array(
        "last_name",//*
        "name",
        "birthdate",
        "age",//*
        "gender"
    );
    public $attributesData = array(
        "last_name",//*
        "name",//*,
        "birthdate",
        "age",//*
        "gender"
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "last_name" => 'required',
            "name" => 'required',
            "age" => 'required',
            "gender" => 'required',

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
    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}"; // ajusta según tus columnas reales
    }

    public function saveDataOrderShipping($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        try {
            $modelName = 'People';
            $model = new People();
            $dataManager = $attributesPost[$modelName];

            $validateResult = $this->validateModel($dataManager);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($dataManager);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  Persona.";
                $errors = $validateResult["errors"];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'model'=>$model
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
    public function saveDataOrderShippingEvents($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params;
        $errors = array();
        try {
            $modelName = 'People';
            $model = new People();
            $dataManager = $attributesPost[$modelName];

            $validateResult = $this->validateModel($dataManager);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($dataManager);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  Persona.";
                $errors = $validateResult["errors"];
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'model'=>$model
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
    public function findByAttributes($arrayParams, $params = [])
    {
        $selectString = isset($params['columnsSelect']) ? $params['columnsSelect'] : '*';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);
        foreach ($arrayParams as $key => $value) {
            $query->where($key, "=", $value);
        }

        $result=   $query->first();
        return $result;
    }
}
