<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use App\Models\LodgingByArrived;
use App\Models\LodgingByPayment;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\View;

class LodgingByArrivedController extends MyBaseController
{


    public function getAdminBusiness()
    {
        $dataPost = Request::all();
        $model = new Lodging();
        $result = $model->getAdminBusinessData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveArrived()
    {

        $attributesPost = Request::all();
        $model = new LodgingByArrived();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

    public function updateBusiness()
    {


    }
}
