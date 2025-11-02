<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingCustomerAdditionalInformation extends Model
{

    protected $table = 'lodging_customer_additional_information';

    protected $fillable = array(
        "lodging_by_customer_id",//*
        "information_phone_id", "information_mobile_id", "postal_code","information_mail_id"
    );
    public $attributesData = array(
        "lodging_by_customer_id",//*
        "information_phone_id", "information_mobile_id", "mail", "postal_code","information_mail_id",

    );
    public $timestamps = false;
    public static function getRulesModel()
    {
        $rules = [
            "lodging_by_customer_id" => 'required',
            "information_mail_id" => 'required'

        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = LodgingCustomerAdditionalInformation::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }
    public function getLodgingCustomerInformation($params)
    {


        $lodging_by_customer_id = $params["lodging_by_customer_id"];
        $query = DB::table($this->table);
        $selectString = "$this->table.id lodging_customer_additional_information_id ,$this->table.information_phone_id,$this->table.information_mobile_id,$this->table.information_mail_id,$this->table.postal_code,$this->table.lodging_by_customer_id
        ,information_mail.value mail
        ,mobile_table.value mobile
        ,phone_table.value phone";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_mail', $this->table . '.information_mail_id', '=', 'information_mail.id');
        $query->leftJoin('information_phone as mobile_table', $this->table . '.information_mobile_id', '=', 'mobile_table.id');
        $query->leftJoin('information_phone as phone_table', $this->table . '.information_phone_id', '=', 'phone_table.id');

        $query->where("lodging_by_customer_id", '=', $lodging_by_customer_id);
        $data = $query->first();
        return $data;
    }
    public static function getModelByLodgingByCustomerId($lodging_by_customer_id)
    {



        $query = DB::table("lodging_customer_additional_information");
        $selectString = "*";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_by_customer_id", '=', $lodging_by_customer_id);
        $data = $query->first();
        return $data;
    }
}
