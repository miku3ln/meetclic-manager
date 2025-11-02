<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use App\Models\LodgingByPayment;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\View;

class LodgingByPaymentController extends MyBaseController
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

    public function savePayment()
    {

        $attributesPost =Request::all();
        $model = new LodgingByPayment();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

    public function updateBusiness()
    {


    }
}
