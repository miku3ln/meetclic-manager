<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Services\BusinessAppService;
use App\Http\Controllers\Controller;


class BusinessAppController extends Controller
{
    protected $serviceBusiness;

    public function __construct(BusinessAppService $service)
    {
        $this->serviceUser = $service;
    }


    public function searchNearbyBusinesses(Request $request)
    {
        try {
            $type = -1;
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $radiusKm = $request->input('radius_km', 200); // Por defecto 10 km
            $subcategoryIds = $request->input('subcategory_ids', []); // Array o vacío

            $data = $this->serviceUser->searchNearbyBusinesses($latitude, $longitude, $radiusKm, $subcategoryIds);
            return Response::json([
                "type" => $type,
                'success' => true,
                'message' => 'Inicio de sesión correcto.',
                'data' => $data,
            ]);


        } catch (\Throwable $e) {
            return Response::json([
                "type" => $type,
                'success' => false,
                "data" => [
                    "errors" => $e->getMessage()
                ],
                'message' => 'Error interno del servidor.',
            ], 500);
        }
    }

    public function businessDetails(Request $request)
    {
        try {
            $type = -1;
            $businessId = $request->input('businessId');
            $data = $this->serviceUser->businessDetails($businessId);
            return Response::json([
                "type" => $type,
                'success' => true,
                'message' => 'Inicio de sesión correcto.',
                'data' => $data,
            ]);


        } catch (\Throwable $e) {
            return Response::json([
                "type" => $type,
                'success' => false,
                "data" => [
                    "errors" => $e->getMessage()
                ],
                'message' => 'Error interno del servidor.',
            ], 500);
        }
    }

    public function getDeparturesWithCustomers(Request $request)
    {
        try {
            $type = -1;
            $businessId = $request->input('businessId');

            $data = $this->serviceUser->getDeparturesWithCustomers($businessId, null, null);
            return Response::json([
                "type" => $type,
                'success' => true,
                'message' => 'Inicio de sesión correcto.',
                'data' => $data,
            ]);


        } catch (\Throwable $e) {
            return Response::json([
                "type" => $type,
                'success' => false,
                "data" => [
                    "errors" => $e->getMessage()
                ],
                'message' => 'Error interno del servidor.',
            ], 500);
        }
    }
}
