<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\BusinessByLodgingByPrice;
class BusinessByLodgingByPriceController extends MyBaseController
{


    public function getListRooms()
    {

        $postValues = Request::all();
        $model = new BusinessByLodgingByPrice();
        $result = $model->getLitRooms($postValues);
        return Response::json($result);
    }

}
