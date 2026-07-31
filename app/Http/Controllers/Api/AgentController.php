<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Services\Appointment\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected $appointmentService;

    public function __construct(
        AppointmentService $appointmentService
    )
    {

        $this->appointmentService =
            $appointmentService;

    }

    public function checkAvailabilityByBusiness(Request $request)
    {

        try {


            $result = $this->appointmentService->checkAvailability(

                $request->business_id,

                $request->date,

                $request->time

            );


            return response()->json([

                "success" => true,

                "data" => $result

            ]);


        } catch(\Exception $e){


            return response()->json([

                "success" => false,

                "message" => $e->getMessage()

            ],500);


        }

    }
    public function getAvailableByDate(Request $request)
    {

        try {


            $result = $this->appointmentService->getAvailableSlots(

                $request->business_id,

                $request->date

            );


            return response()->json([

                "success" => true,

                "data" => $result

            ]);


        } catch(\Exception $e){


            return response()->json([

                "success" => false,

                "message" => $e->getMessage()

            ],500);


        }

    }
    public function getBusinessDataAgent($id): JsonResponse
    {
        $model = new Business();

        $data = $model->getBusinessDataAgent([
            "id" => $id
        ]);

        if (!$data) {

            return response()->json([
                "success" => false,
                "message" => "Business not found."
            ],404);

        }

        return response()->json([
            "success" => true,
            "data" => $data
        ]);

    }

}
