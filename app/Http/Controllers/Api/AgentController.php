<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\JsonResponse;

class AgentController extends Controller
{

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
