<?php

namespace App\Models\Appointment;


use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;



class AppointmentScheduleUsers extends ModelManager
{


    protected $table = 'appointment_schedule_users';


    protected $primaryKey = 'id';


    public $timestamps = true;


    public $modelName = 'AppointmentScheduleUsers';



    protected $fillable = array(

        "id",

        "schedule_id",

        "user_id",

        "is_primary",

        "is_available",

        "created_at",

        "updated_at"

    );



    public $attributesData = array(

        "id",

        "schedule_id",

        "user_id",

        "is_primary",

        "is_available",

        "created_at",

        "updated_at"

    );



    public $fieldsCurrentSelect = '';




    public static function getRulesModel()
    {

        return [


            "schedule_id" =>
                'required|integer',


            "user_id" =>
                'required|integer',


            "is_primary" =>
                'required|in:0,1',


            "is_available" =>
                'required|in:0,1'


        ];

    }




    /* =========================================================================
     * Relaciones
     * ========================================================================= */



    public function schedule()
    {

        return $this->belongsTo(

            AppointmentSchedules::class,

            'schedule_id'

        );

    }



    public function user()
    {

        return $this->belongsTo(

            \App\Models\User::class,

            'user_id'

        );

    }


}
