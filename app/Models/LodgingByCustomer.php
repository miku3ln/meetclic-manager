<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingByCustomer extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lodging_by_customer';

    protected $fillable = array(
        "main",//*
        "customer_id",//*
        "lodging_id",//*
        "has_information_additional",
    );
    public $attributesData = array(
        "main",//*
        "customer_id",//*
        "lodging_id",//*
        "has_information_additional",

    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "main" => 'required',
            "lodging_id" => 'required',
            "customer_id" => 'required',
            "has_information_additional" => 'required',

        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = LodgingByCustomer::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getLodgingCustomers($params)
    {


        $lodging_id = $params["lodging_id"];
        $query = DB::table($this->table);
        $tbl = $this->table;
        $selectString = "$this->table.id lodging_by_customer_id ,$this->table.main,$this->table.lodging_id,$this->table.has_information_additional
       ,customer.identification_document document_number,customer.identification_document document_number,customer.people_id,customer.people_type_identification_id type_document,customer.id customer_id
     ,customer_by_information.people_nationality_id,customer_by_information.people_profession_id ,customer_by_information.id customer_by_information_id
       ,people.last_name ,people.name,people.name,people.birthdate,people.age,people.gender
       ,people_profession.name people_profession_text
        , people_nationality.name people_nationality_text
       ";
        $select = DB::raw($selectString);
        $query->select($select)
            ->join('customer', $tbl . '.customer_id', '=', 'customer.id')
            ->join('people',  'customer.people_id', '=', 'people.id')
            ->join('customer_by_information', 'customer.id', '=', 'customer_by_information.customer_id')
            ->join('people_profession',  'customer_by_information.people_profession_id', '=', 'people_profession.id')
            ->join('people_nationality',  'customer_by_information.people_nationality_id', '=', 'people_nationality.id');
        $query->where("lodging_id", '=', $lodging_id);
        $data = $query->get()->toArray();

        return $data;
    }

}
