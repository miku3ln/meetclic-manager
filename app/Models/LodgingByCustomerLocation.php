<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingByCustomerLocation extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lodging_by_customer_location';

    protected $fillable = array(
        "information_address_id",//*
        "lodging_by_customer_id"//*
    );
    public $attributesData = array(

        "information_address_id",//*
        "lodging_by_customer_id"//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "information_address_id" => 'required',
            "lodging_by_customer_id" => 'required',

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
    public function getLodgingCustomerLocation($params)
    {


        $lodging_by_customer_id = $params["lodging_by_customer_id"];
        $query = DB::table($this->table);
        $selectString = "$this->table.information_address_id,$this->table.id lodging_by_customer_location_id ,$this->table.lodging_by_customer_id
        ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3,information_address.options_map,information_address.id information_address_location_current_id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_address', $this->table . '.information_address_id', '=', 'information_address.id');
        $query->where("lodging_by_customer_id", '=', $lodging_by_customer_id);
        $data = $query->first();

        return $data;
    }

    public static function getModelByLodgingByCustomerId($lodging_by_customer_id)
    {



        $query = DB::table("lodging_by_customer_location");
        $selectString = "*";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_by_customer_id", '=', $lodging_by_customer_id);
        $data = $query->first();
        return $data;
    }
}
