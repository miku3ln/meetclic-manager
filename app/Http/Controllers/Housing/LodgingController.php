<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use App\Models\Lodging;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class LodgingController extends MyBaseController
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

    public function saveBusiness()//BUSINESS-LODGING-RECEPTION-SAVE
    {

        $attributesPost = Request::all();
        $model = new Lodging();
        $result = $model->saveBusiness(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

    public function updateBusiness()
    {


    }
    public function delivery()
    {

        $attributesPost =Request::all();
        $model = new Lodging();
        $result = $model->delivery(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }
    public function results()
    {

        $attributesPost = Request::all();
        $model = new Lodging();
        $result =$model->results(array("attributesPost"=>$attributesPost));

        return Response::json($result);
    }
}
