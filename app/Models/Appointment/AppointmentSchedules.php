<?php

namespace App\Models\Appointment;


use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;


class AppointmentSchedules extends ModelManager
{


    protected $table = 'appointment_schedules';


    protected $primaryKey = 'id';


    public $timestamps = true;


    public $modelName = 'AppointmentSchedules';



    protected $fillable = array(

        "id",

        "business_id",

        "day_week",

        "start_time",

        "end_time",

        "period",

        "duration_minutes",

        "interval_minutes",

        "is_available",

        "status",

        "created_at",

        "updated_at"

    );



    public $attributesData = array(

        "id",

        "business_id",

        "day_week",

        "start_time",

        "end_time",

        "period",

        "duration_minutes",

        "interval_minutes",

        "is_available",

        "status",

        "created_at",

        "updated_at"

    );



    public $fieldsCurrentSelect = '';



    public static function getRulesModel()
    {

        return [


            "business_id" =>
                'required|integer',


            "day_week" =>
                'required|integer|min:1|max:7',


            "start_time" =>
                'required',


            "end_time" =>
                'required',


            "period" =>
                'required|in:MORNING,AFTERNOON,NIGHT',


            "duration_minutes" =>
                'nullable|integer|min:1',


            "interval_minutes" =>
                'nullable|integer|min:1',


            "is_available" =>
                'required|in:0,1',


            "status" =>
                'required|in:0,1'


        ];

    }






    /* =========================================================================
     * Relaciones
     * ========================================================================= */



    public function business()
    {

        return $this->belongsTo(

            \App\Models\Business::class,

            'business_id'

        );

    }



    public function users()
    {

        return $this->hasMany(

            AppointmentScheduleUsers::class,

            'schedule_id'

        );

    }

    public function assignedUsers()
    {

        return $this->hasMany(

            AppointmentScheduleUsers::class,

            'schedule_id'

        )
            ->where('is_available',1);

    }

}
