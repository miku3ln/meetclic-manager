<?php

namespace App\Models\MaritimeOperationsManagement;

use App\Models\ModelManager;

use Illuminate\Support\Facades\DB;

class MaritimeDeparturesCustomers extends ModelManager
{


    protected $table = 'maritime_departures_customers';
    protected $modelNameEntity = 'MaritimeDeparturesCustomers';

    protected $fillable = array('maritime_departures_id', "type", 'age', 'customer_id');

    public $timestamps = true;
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }
    public static function getRulesModel()
    {
        $rules = [
            "maritime_departures_id" => "required",
            "type" => "required",
            "age" => "required",
            "customer_id" => "required"];
        return $rules;
    }


}
