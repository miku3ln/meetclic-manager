<?php

namespace App\Http\Controllers\PointSales;

use App\Http\Controllers\PointSalesBaseController;

use App\Models\Cash\CashManager;
use App\Models\Cash\CashMovement;
use Illuminate\Http\Request;


class ManagementCashController extends PointSalesBaseController
{


    public function __construct()
    {
    }

    public function getUserPointOfSaleCash(Request $request)
    {
        $payload = $request->json()->all();
        $userId = isset($payload['user_id'])
            ? (int)$payload['user_id']
            : 0;

        $businessId = isset($payload['business_id'])
            ? (int)$payload['business_id']
            : 0;
        $cashManager = new CashManager();

        $result = $cashManager->getUserPointOfSaleCash(
            $userId,
            $businessId
        );
        $this->user = $request->get('auth_user');

        return response()->json($result);
    }

    public function openPointOfSaleCash(Request $request)
    {
        $payload = $request->json()->all();

        $userId = isset($payload['user_id'])
            ? (int)$payload['user_id']
            : 0;

        $businessId = isset($payload['business_id'])
            ? (int)$payload['business_id']
            : 0;
        $openingAmount = isset($payload['opening_amount'])
            ? (int)$payload['opening_amount']
            : 0;

        $openingDetails = $payload['opening_details'] ?? "";
        $cashManager = new CashManager();
        $result = $cashManager->openPointOfSaleCash(
            $userId,
            $businessId,
            $openingAmount,
            $openingDetails
        );
        $this->user = $request->get('auth_user');

        return response()->json($result);
    }
    public function closePointOfSaleCash(Request $request)
    {
        $payload = $request->json()->all();

        $userId = isset($payload['user_id'])
            ? (int)$payload['user_id']
            : 0;

        $businessId = isset($payload['business_id'])
            ? (int)$payload['business_id']
            : 0;
        $closingAmount = isset($payload['closing_amount'])
            ? (int)$payload['closing_amount']
            : 0;

        $details = $payload['closing_details'] ?? "";
        $cashManager = new CashManager();
        $result = $cashManager->closePointOfSaleCash(
            $userId,
            $businessId,
            $closingAmount,
            $details
        );
        $this->user = $request->get('auth_user');

        return response()->json($result);
    }
    public function getPointOfSaleCashCloseSummary(Request $request)
    {
        $payload = $request->json()->all();

        $userId = isset($payload['user_id'])
            ? (int)$payload['user_id']
            : 0;

        $businessId = isset($payload['business_id'])
            ? (int)$payload['business_id']
            : 0;
        $cashManager = new CashManager();
        $result = $cashManager->getPointOfSaleCashCloseSummary(
            $userId,
            $businessId,

        );
        $this->user = $request->get('auth_user');

        return response()->json($result);
    }
    public function getCashMovements(Request $request)
    {
        $params =
            $request->all();

        $filters = [
            'searchPhrase' =>
                $params['searchPhrase'] ?? '',

            'current' =>
                $params['current'] ?? 1,

            'rowCount' =>
                $params['rowCount'] ?? 10,

            'filters' => [
                'user_id' =>
                    $params['user_id'] ?? null,

                'business_id' =>
                    $params['business_id'] ?? null,

                'cash_id' =>
                    $params['cash_id'] ?? null,

                'cash_session_id' =>
                    $params['cash_session_id'] ?? null,

                'movement_type' =>
                    $params['movement_type'] ?? null,

                'cash_reason_id' =>
                    $params['cash_reason_id'] ?? null,

                'state' =>
                    $params['state'] ?? null,

                'date_from' =>
                    $params['date_from'] ?? null,

                'date_to' =>
                    $params['date_to'] ?? null
            ]
        ];

        $cashMovementModel =
            new CashMovement();

        $data =
            $cashMovementModel->getAdmin(
                $filters
            );
        $this->user = $request->get('auth_user');

        return response()->json(
            $data
        );
    }
}
