<?php

namespace App\Models\Appointment;

use App\Models\Exception;
use App\Models\ModelManager;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;


class Appointments extends ModelManager
{

    protected $table = 'appointments';


    protected $primaryKey = 'id';


    public $timestamps = true;


    public $modelName = 'Appointments';



    protected $fillable = array(

        "id",
        "business_id",
        "appointment_type_id",
        "customer_id",
        "code",
        "title",
        "description",
        "start_datetime",
        "end_datetime",
        "duration_minutes",
        "all_day",
        "status",
        "location",
        "notes",
        "created_at",
        "updated_at"

    );



    public $attributesData = array(

        "id",
        "business_id",
        "appointment_type_id",
        "customer_id",
        "code",
        "title",
        "description",
        "start_datetime",
        "end_datetime",
        "duration_minutes",
        "all_day",
        "status",
        "location",
        "notes",
        "created_at",
        "updated_at"

    );



    public $fieldsCurrentSelect = '';



    public static function getRulesModel()
    {

        return [

            "business_id" =>
                'required|integer',

            "appointment_type_id" =>
                'required|integer',

            "customer_id" =>
                'required|integer',

            "code" =>
                'required|string|max:30',

            "title" =>
                'required|string|max:200',

            "description" =>
                'nullable|string',

            "start_datetime" =>
                'required|date',

            "end_datetime" =>
                'nullable|date',

            "duration_minutes" =>
                'nullable|integer',

            "all_day" =>
                'required|in:0,1',


            "status" =>
                'required|in:PENDING,CONFIRMED,IN_PROGRESS,COMPLETED,CANCELLED,NO_SHOW',


            "location" =>
                'nullable|string|max:255',


            "notes" =>
                'nullable|string'

        ];

    }



    /* =========================================================================
     * Relaciones
     * ========================================================================= */

    public static function getCalendarEvents(
        $businessId,
        $start,
        $end
    )
    {


        return self::select(

            'appointments.id',
            'appointments.code',
            'appointments.title',
            'appointments.start_datetime',
            'appointments.end_datetime',
            'appointments.status',
            'appointments.description',
            'appointments.location',
            'appointments.notes',

            'appointment_types.background_color',
            'appointment_types.border_color',
            'appointment_types.text_color',
            'customer.id as customer_id',
            'people.last_name as customer_last_name',
            'people.name as customer_name',
            'customer.identification_document as customer_document',
            'users.id as responsible_id',
            'users.name as responsible_name'


        )
            ->join(
                'appointment_types',
                'appointment_types.id',
                '=',
                'appointments.appointment_type_id'
            )
            ->join(
                'customer',
                'customer.id',
                '=',
                'appointments.customer_id'
            )
            ->join(
                'people',
                'customer.people_id',
                '=',
                'people.id'
            )

            /*
             * IMPORTANTE
             * LEFT JOIN porque puede no existir responsable
             */
            ->leftJoin(
                'appointment_users',
                function($join){

                    $join->on(
                        'appointment_users.appointment_id',
                        '=',
                        'appointments.id'
                    )
                        ->where(
                            'appointment_users.is_primary',
                            1
                        );

                }
            )


            ->leftJoin(
                'users',
                'users.id',
                '=',
                'appointment_users.user_id'
            )


            ->where(
                'appointments.business_id',
                $businessId
            )


            ->whereBetween(
                'appointments.start_datetime',
                [
                    $start,
                    $end
                ]
            )


            ->orderBy(
                'appointments.start_datetime'
            )


            ->get()

            ->map(function($item){


                return [

                    "id"=>$item->id,
                    "title"=>$item->title,
                    "code"=>$item->code,
                    "start"=>$item->start_datetime,
                    "end"=>$item->end_datetime,
                    "description"=>$item->description,
                    "location"=>$item->location,
                    "notes"=>$item->notes,
                    "backgroundColor"
                    =>$item->background_color,
                    "borderColor"
                    =>$item->border_color,


                    "textColor"
                    =>$item->text_color,


                    "extendedProps"=>[

                        "status"=>$item->status,
                        "customer_id"=>$item->customer_id,
                        "customer_name"=>$item->customer_name,
                        "customer_last_name"=>$item->customer_last_name,

                        // puede ser null
                        "responsible_id"=>$item->responsible_id,
                        "responsible_name"=>$item->responsible_name

                    ]

                ];

            });


    }

}
