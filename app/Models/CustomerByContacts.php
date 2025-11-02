<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class CustomerByContacts extends ModelManager
{

    protected $table = 'customer_by_contacts';

    protected $fillable = array(
        "customer_id",//*
        "customer_contact_id",//*


    );
    public $attributesData = array(
        "customer_id",//*
        "customer_contact_id",//*


    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "customer_id" => 'required',
            "customer_contact_id" => 'required',

        ];
        return $rules;
    }




}
