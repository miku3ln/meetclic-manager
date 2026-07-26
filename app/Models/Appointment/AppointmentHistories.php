<?php

namespace App\Models\Appointment;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;


class AppointmentHistories extends ModelManager
{


    protected $table = 'appointment_histories';


    protected $primaryKey = 'id';


    public $timestamps = true;


    public $modelName = 'AppointmentHistories';



    protected $fillable = array(

        "id",
        "appointment_id",
        "status",
        "description",
        "created_at"

    );



    public $attributesData = array(

        "id",
        "appointment_id",
        "status",
        "description",
        "created_at"

    );



    public $fieldsCurrentSelect = '';



    public static function getRulesModel()
    {

        return [

            "appointment_id" =>
                'required|integer',


            "status" =>
                'required|in:PENDING,CONFIRMED,IN_PROGRESS,COMPLETED,CANCELLED,NO_SHOW',


            "description" =>
                'nullable|string'

        ];

    }




    /* =========================================================================
     * Relaciones
     * ========================================================================= */


}
