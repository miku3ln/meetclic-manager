<?php

namespace App\Http\Controllers\EventsTrails;

use App\Http\Controllers\MyBaseController;
use App\Models\EventsTrailsByKit;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;



class EventsTrailsByKitController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new EventsTrailsByKit();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new EventsTrailsByKit();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  EventsTrailsByKit();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getListSelect2PiecesClothes()
    {

        $attributesPost = Request::all();
        $modelManagerGet = null;
        if ($attributesPost['filters']['entity_type'] == '0') {

        } else {


        }

        $result = [];
        return Response::json($result);
    }
}
