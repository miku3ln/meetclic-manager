<?php

namespace App\Http\Controllers\EventsTrails;

use App\Http\Controllers\MyBaseController;
use App\Models\EventsTrailsRegistrationPaymentsByBusiness;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class EventsTrailsRegistrationPaymentsByBusinessController extends MyBaseController
{





    public function getDataPaymentsManagement()
    {

        $attributesPost = Request::all();
        $model = new  EventsTrailsRegistrationPaymentsByBusiness();
        $result = $model->getDataPaymentsManagement($attributesPost);
        return Response::json($result);
    }
}
