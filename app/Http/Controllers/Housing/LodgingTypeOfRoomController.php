<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use App\Models\LodgingTypeOfRoom;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LodgingTypeOfRoomController extends MyBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LodgingTypeOfRoom();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new LodgingTypeOfRoom();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function update()
    {


    }

    public function getListSelect2()
    {

        $attributesPost =Request::all();
        $model = new LodgingTypeOfRoom();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

}
