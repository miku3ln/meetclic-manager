<?php

namespace App\Http\Controllers\PointSales;

use App\Http\Controllers\PointSalesBaseController;

use App\Modules\PointSales\Services\TicketsSalesService;


use Illuminate\Http\Request;


class TicketManagerController extends PointSalesBaseController
{


    public function __construct(TicketsSalesService $service)
    {
        $this->service = $service;


    }

    public function getTicketsSales(Request $request)
    {

        $params = $request->all();
        $sortCurrent = $params['sortType'] ?? 'desc';
        $params['sortType'] = $sortCurrent;
        $data = $this->service->getTicketSales($params);
        $this->user = $request->get('auth_user');
        return response()->json($data);
    }
}
