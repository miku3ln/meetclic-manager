<?php

namespace App\Models\Appointment;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;


class AppointmentSettings extends ModelManager
{

    protected $table = 'appointment_settings';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $modelName = 'AppointmentSettings';


    protected $fillable = array(

        "id",
        "business_id",
        "default_duration_minutes",
        "default_interval_minutes",
        "allow_without_responsible",
        "allow_multiple_appointments_same_time",
        "status",
        "created_at",
        "updated_at"

    );


    public $attributesData = array(

        "id",
        "business_id",
        "default_duration_minutes",
        "default_interval_minutes",
        "allow_without_responsible",
        "allow_multiple_appointments_same_time",
        "status",
        "created_at",
        "updated_at"

    );


    public $fieldsCurrentSelect = '';


    public static function getRulesModel()
    {

        return [

            "business_id" => 'required|integer',

            "default_duration_minutes" => 'required|integer|min:1',

            "default_interval_minutes" => 'required|integer|min:1',

            "allow_without_responsible" => 'required|in:0,1',

            "allow_multiple_appointments_same_time" => 'required|in:0,1',

            "status" => 'required|in:0,1'

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

    public function schedules()
    {
        return $this->hasMany(
            AppointmentSchedules::class,
            'business_id',
            'business_id'
        )
            ->where('status',1);
    }
    public static function getBusinessConfiguration($businessId)
    {

        return self::with([

            'schedules' => function($query){

                $query->orderBy('day_week')
                    ->orderBy('start_time');

            },
            'schedules.assignedUsers.user'

        ])

            ->where(
                'business_id',
                $businessId
            )

            ->first();

    }
}
