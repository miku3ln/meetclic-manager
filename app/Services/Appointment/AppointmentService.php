<?php

namespace App\Services\Appointment;


use App\Models\Appointment\AppointmentScheduleUsers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;


use App\Models\Appointment\Appointments;
use App\Models\Appointment\AppointmentSettings;
use App\Models\Appointment\AppointmentSchedules;
use App\Models\Appointment\AppointmentUsers;
use App\Models\Appointment\AppointmentHistories;



class AppointmentService
{

    public function checkAvailability(
        $businessId,
        $date,
        $time
    )
    {

        $settings = $this->getAppointmentSettings($businessId);


        if(!$settings){

            return [

                "available"=>false,

                "code"=>"SETTINGS_NOT_FOUND",

                "message"=>"No existe configuración de citas para este negocio"

            ];

        }



        /*
        |--------------------------------------------------------------------------
        | Fecha solicitada
        |--------------------------------------------------------------------------
        */

        $startDateTime = Carbon::parse(
            $date.' '.$time
        );


        $dayWeek = $startDateTime->dayOfWeekIso;



        /*
        |--------------------------------------------------------------------------
        | Buscar horario configurado
        |--------------------------------------------------------------------------
        */


        $schedule = AppointmentSchedules::with(
            'assignedUsers'
        )
            ->where(
                'business_id',
                $businessId
            )
            ->where(
                'day_week',
                $dayWeek
            )
            ->where(
                'status',
                1
            )
            ->where(
                'is_available',
                1
            )
            ->whereTime(
                'start_time',
                '<=',
                $time
            )
            ->whereTime(
                'end_time',
                '>',
                $time
            )
            ->first();


        if(!$schedule){


            return [

                "available"=>false,

                "code"=>"SCHEDULE_NOT_FOUND",

                "message"=>"No existe horario configurado para esta fecha y hora",

                "data"=>[
                    "date"=>$date,
                    "time"=>$time
                ]

            ];

        }




        /*
        |--------------------------------------------------------------------------
        | Duración
        |--------------------------------------------------------------------------
        */


        $duration =
            $settings->default_duration_minutes;



        $endDateTime =
            $startDateTime->copy()
                ->addMinutes($duration);





        /*
        |--------------------------------------------------------------------------
        | Validar que no salga del horario
        |--------------------------------------------------------------------------
        */


        $scheduleEnd =
            Carbon::parse(
                $date.' '.$schedule->end_time
            );


        if($endDateTime->gt($scheduleEnd)){


            return [

                "available"=>false,

                "code"=>"OUTSIDE_SCHEDULE",

                "message"=>"El bloque seleccionado supera el horario disponible"

            ];

        }




        /*
        |--------------------------------------------------------------------------
        | Validar intervalo
        |--------------------------------------------------------------------------
        */


        $interval =
            $schedule->interval_minutes
            ??
            $settings->default_interval_minutes;



        if($interval){


            $scheduleStart =
                Carbon::parse(
                    $date.' '.$schedule->start_time
                );


            $diff =
                $scheduleStart->diffInMinutes(
                    $startDateTime
                );


            if($diff % $interval !=0){


                return [

                    "available"=>false,

                    "code"=>"INVALID_INTERVAL",

                    "message"=>"La hora seleccionada no corresponde a un bloque válido"

                ];


            }

        }





        /*
        |--------------------------------------------------------------------------
        | Capacidad
        |--------------------------------------------------------------------------
        */


        $capacity =
            $settings->resource_capacity;



        /*
        |--------------------------------------------------------------------------
        | Citas ocupadas
        |--------------------------------------------------------------------------
        */


        $occupied =
            Appointments::where(
                'business_id',
                $businessId
            )
                ->whereNotIn(
                    'status',
                    [
                        'CANCELLED',
                        'NO_SHOW'
                    ]
                )
                ->where(function($query) use(
                    $startDateTime,
                    $endDateTime
                ){

                    $query
                        ->where(
                            'start_datetime',
                            '<',
                            $endDateTime
                        )
                        ->where(
                            'end_datetime',
                            '>',
                            $startDateTime
                        );

                })
                ->count();



        $remaining =
            $capacity - $occupied;




        if($remaining <=0){


            return [

                "available"=>false,

                "code"=>"NO_CAPACITY",

                "message"=>"El horario seleccionado está lleno",

                "capacity"=>$capacity,

                "occupied"=>$occupied,

                "remaining"=>0

            ];


        }




        return [

            "available"=>true,

            "code"=>"AVAILABLE",

            "message"=>"Horario disponible",


            "schedule_id"=>$schedule->id,


            "schedule"=>$schedule,


            "duration"=>$duration,


            "slot"=>[

                "start"=>$startDateTime->format(
                    'Y-m-d H:i:s'
                ),

                "end"=>$endDateTime->format(
                    'Y-m-d H:i:s'
                )

            ],


            "capacity"=>$capacity,

            "occupied"=>$occupied,

            "remaining"=>$remaining


        ];

    }

    /**
     * Crear cita validando disponibilidad
     */
    public function create(array $data)
    {

        return DB::transaction(function() use($data){


            $start =
                Carbon::parse(
                    $data['start_datetime']
                );



            $availability =
                $this->checkAvailability(

                    $data['business_id'],

                    $start->format('Y-m-d'),

                    $start->format('H:i')

                );





            if(!$availability['available']){


                throw new Exception(
                    json_encode([

                        "code"=>$availability['code'],

                        "message"=>$availability['message'],

                        "availability"=>$availability

                    ])
                );


            }




            $end =
                Carbon::parse(
                    $availability['slot']['end']
                );




            /*
            |--------------------------------------------------------------------------
            | Validar nuevamente citas
            |--------------------------------------------------------------------------
            */


            $this->validateAppointments(

                $data['business_id'],

                $start,

                $end,

                $this->getAppointmentSettings(
                    $data['business_id']
                )

            );






            $data['end_datetime'] =
                $end;



            $data['duration_minutes'] =
                $availability['duration'];





            $appointment =
                Appointments::create(
                    $data
                );





            $this->assignUsers(

                $appointment,

                $availability['schedule']

            );





            AppointmentHistories::create([

                "appointment_id"=>$appointment->id,

                "status"=>"PENDING",

                "description"=>"Cita creada"

            ]);






            return [

                "code"=>"APPOINTMENT_CREATED",

                "message"=>"Cita creada correctamente",

                "appointment"=>$appointment

            ];



        });


    }



    /**
     * Copiar responsables del horario
     */
    private function assignUsers(
        $appointment,
        $schedule
    ){


        foreach(
            $schedule->assignedUsers
            as $user
        ){


            AppointmentUsers::create([

                "appointment_id" =>
                    $appointment->id,

                "user_id" =>
                    $user->user_id,

                "is_primary" =>
                    $user->is_primary

            ]);


        }


    }


    /**
     * Buscar horario según día
     */
    private function getSchedule(
        $businessId,
        Carbon $date
    ){


        $day =
            $date->dayOfWeekIso;



        $schedules =
            AppointmentSchedules::where(
                'business_id',
                $businessId
            )
                ->where(
                    'day_week',
                    $day
                )
                ->where(
                    'status',
                    1
                )
                ->where(
                    'is_available',
                    1
                )
                ->with(
                    'assignedUsers'
                )
                ->get();



        foreach($schedules as $schedule){


            $start =
                Carbon::parse(
                    $date->format('Y-m-d')
                    .' '
                    .$schedule->start_time
                );


            $end =
                Carbon::parse(
                    $date->format('Y-m-d')
                    .' '
                    .$schedule->end_time
                );



            if(
                $date->between(
                    $start,
                    $end
                )
            ){

                return $schedule;

            }


        }



        throw new Exception(
            "No existe horario disponible para este día"
        );


    }





    /**
     * Obtener duración efectiva
     */
    private function getDuration(
        $data,
        $schedule,
        $settings
    ){


        if(
            isset($data['duration_minutes'])
            &&
            $data['duration_minutes']
        ){

            return $data['duration_minutes'];

        }



        if(
            $schedule->duration_minutes
        ){

            return $schedule->duration_minutes;

        }



        return $settings->default_duration_minutes;


    }







    /**
     * Validar rango horario
     */
    private function validateScheduleRange(
        Carbon $start,
        Carbon $end,
               $schedule
    ){


        $day =
            $start->format('Y-m-d');



        $scheduleStart =
            Carbon::parse(
                $day.' '.$schedule->start_time
            );


        $scheduleEnd =
            Carbon::parse(
                $day.' '.$schedule->end_time
            );



        if(
            !$start->gte($scheduleStart)
            ||
            !$end->lte($scheduleEnd)
        ){

            throw new Exception(
                "La cita está fuera del horario configurado"
            );

        }


    }






    /**
     * Validar intervalo
     */
    private function validateSlot(
        Carbon $start,
               $schedule,
               $settings
    ){


        $interval =
            $schedule->interval_minutes
            ??
            $settings->default_interval_minutes;



        $scheduleStart =
            Carbon::parse(
                $start->format('Y-m-d')
                .' '
                .$schedule->start_time
            );



        $minutes =
            $scheduleStart->diffInMinutes(
                $start
            );



        if(
            $minutes % $interval != 0
        ){

            throw new Exception(
                "La hora seleccionada no corresponde a un bloque disponible"
            );

        }


    }







    /**
     * Validar citas existentes
     */
    private function validateAppointments(
        $businessId,
        Carbon $start,
        Carbon $end,
        $settings
    ){


        $count =
            Appointments::where(
                'business_id',
                $businessId
            )
                ->whereNotIn(
                    'status',
                    [
                        'CANCELLED',
                        'NO_SHOW'
                    ]
                )
                ->where(function($q) use($start,$end){


                    $q->where(
                        'start_datetime',
                        '<',
                        $end
                    )
                        ->where(
                            'end_datetime',
                            '>',
                            $start
                        );


                })
                ->count();



        if(
            $count > 0
            &&
            !$settings->allow_multiple_appointments_same_time
        ){

            throw new Exception(
                "Ya existe una cita en ese horario"
            );

        }


    }

public  function getAppointmentSettings($businessId){
    $settings = AppointmentSettings::where(
        'business_id',
        $businessId
    )->first();
    return $settings;
}
    public function getAvailabilityByDate($businessId, $date)
    {
        $settings =$this-> getAppointmentSettings($businessId);

        $dayWeek = Carbon::parse($date)->dayOfWeekIso;

        $schedules = AppointmentSchedules::where(
            'business_id',
            $businessId
        )
            ->where('day_week', $dayWeek)
            ->where('status', 1)
            ->where('is_available', 1)
            ->orderBy('start_time')
            ->get();

        $duration = $settings->default_duration_minutes;
        $capacity = $settings->resource_capacity;
        $result = [];
        foreach ($schedules as $schedule) {

            $blockStart = Carbon::parse($date.' '.$schedule->start_time);
            $blockEnd   = Carbon::parse($date.' '.$schedule->end_time);

            $subBlocks = [];

            $totalCapacity = 0;
            $occupiedTotal = 0;

            while ($blockStart < $blockEnd) {

                $slotStart = $blockStart->copy();
                $slotEnd   = $slotStart->copy()->addMinutes($duration);

                $occupied = Appointments::where(
                    'business_id',
                    $businessId
                )
                    ->whereNotIn('status',[
                        'CANCELLED',
                        'NO_SHOW'
                    ])
                    ->where(function($q) use($slotStart,$slotEnd){

                        $q->where(
                            'start_datetime',
                            '<',
                            $slotEnd
                        )
                            ->where(
                                'end_datetime',
                                '>',
                                $slotStart
                            );

                    })
                    ->count();

                $remaining = max(0,$capacity-$occupied);

                if($occupied==0){
                    $state='EMPTY';
                }elseif($remaining==0){
                    $state='FULL';
                }else{
                    $state='AVAILABLE';
                }

                $subBlocks[]=[

                    "start_time"=>$slotStart->format('H:i'),
                    "end_time"=>$slotEnd->format('H:i'),
                    "capacity"=>$capacity,
                    "occupied"=>$occupied,
                    "remaining"=>$remaining,
                    "state"=>$state

                ];

                $totalCapacity += $capacity;
                $occupiedTotal += $occupied;

                $blockStart->addMinutes($duration);

            }

            $result[]=[
                "period"            => $this->getPeriod($schedule->start_time),
                "summary"           => $occupiedTotal."/".$totalCapacity,
                "state"             => $this->getBlockState(
                    $occupiedTotal,
                    $totalCapacity
                ),
                "schedule_id"=>$schedule->id,
                "name"=>$schedule->name,
                "start_time"=>$schedule->start_time,
                "end_time"=>$schedule->end_time,
                "duration_minutes"=>$duration,
                "capacity"=>$capacity,
                "total_capacity"=>$totalCapacity,
                "occupied"=>$occupiedTotal,
                "remaining"=>$totalCapacity-$occupiedTotal,
                "available"=>($totalCapacity-$occupiedTotal)>0,
                "sub_blocks"=>$subBlocks

            ];

        }

        return [

            "business_id"=>$businessId,
            "date"=>$date,
            "blocks"=>$result

        ];
    }
    private function getPeriod($time)
    {
        $hour = (int) substr($time,0,2);

        if($hour < 12){
            return "MORNING";
        }

        if($hour < 18){
            return "AFTERNOON";
        }

        return "NIGHT";
    }

    private function getBlockState($occupied,$capacity)
    {
        if($occupied==0){
            return "EMPTY";
        }

        if($occupied >= $capacity){
            return "FULL";
        }

        return "AVAILABLE";
    }


    public function getAvailableSlots($businessId, $date)
    {
        $availability = $this->getAvailabilityByDate(
            $businessId,
            $date
        );

        $result = [
            "business_id" => $businessId,
            "date" => $date,
            "morning" => [],
            "afternoon" => [],
            "night" => []
        ];

        foreach ($availability["blocks"] as $block) {

            foreach ($block["sub_blocks"] as $slot) {

                // Solo horarios con disponibilidad
                if ($slot["remaining"] <= 0) {
                    continue;
                }

                $item = [
                    "time" => $slot["start_time"],
                    "remaining" => $slot["remaining"]
                ];

                switch ($block["period"]) {

                    case "MORNING":
                        $result["morning"][] = $item;
                        break;

                    case "AFTERNOON":
                        $result["afternoon"][] = $item;
                        break;

                    default:
                        $result["night"][] = $item;
                        break;
                }
            }
        }

        return $result;
    }

}
