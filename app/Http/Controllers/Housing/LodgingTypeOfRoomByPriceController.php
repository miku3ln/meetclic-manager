<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use App\Models\LodgingTypeOfRoomByPrice;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LodgingTypeOfRoomByPriceController extends MyBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LodgingTypeOfRoomByPrice();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function getAdminReception()
    {
        $dataPost =Request::all();
        $model = new LodgingTypeOfRoomByPrice();
        $result = $model->getAdminReception($dataPost);

        return Response::json(
            $result
        );
    }
    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new LodgingTypeOfRoomByPrice();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function saveDataReception()
    {

        $attributesPost = Request::all();
        $model = new LodgingTypeOfRoomByPrice();
        $result = $model->saveDataReception(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function update()
    {


    }

}
