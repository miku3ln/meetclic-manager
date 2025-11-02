<?php

namespace App\Http\Controllers\EventsTrails;

use App\Http\Controllers\MyBaseController;
use App\Models\EventsTrailsRegistrationPoints;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class EventsTrailsRegistrationPointsController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new EventsTrailsRegistrationPoints();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }
    public function deletePointSale()
    {
        $dataPost = Request::all();
        $model = new EventsTrailsRegistrationPoints();
        $result = $model->deletePointSale($dataPost);

        return Response::json(
            $result
        );
    }
    public function adminBusiness($language)
    {
        $dataPost = Request::all();
        $model = new EventsTrailsRegistrationPoints();
        $result = $model->adminBusiness($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new EventsTrailsRegistrationPoints();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  EventsTrailsRegistrationPoints();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
