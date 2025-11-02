<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use App\Models\LodgingRoomFeatures;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LodgingRoomFeaturesController extends MyBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LodgingRoomFeatures();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new LodgingRoomFeatures();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function update()
    {


    }

    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new LodgingRoomFeatures();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

}
