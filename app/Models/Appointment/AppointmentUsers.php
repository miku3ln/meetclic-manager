<?php

namespace App\Models\Appointment;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;


class AppointmentUsers extends ModelManager
{


    protected $table = 'appointment_users';


    protected $primaryKey = 'id';


    public $timestamps = true;


    public $modelName = 'AppointmentUsers';



    protected $fillable = array(

        "id",
        "appointment_id",
        "user_id",
        "is_primary",
        "assigned_at",
        "created_at",
        "updated_at"

    );



    public $attributesData = array(

        "id",
        "appointment_id",
        "user_id",
        "is_primary",
        "assigned_at",
        "created_at",
        "updated_at"

    );



    public $fieldsCurrentSelect = '';



    public static function getRulesModel()
    {

        return [

            "appointment_id" =>
                'required|integer',

            "user_id" =>
                'required|integer',

            "is_primary" =>
                'required|in:0,1'

        ];

    }






    /* =========================================================================
     * Relaciones
     * ========================================================================= */


}
