<?php

namespace App\Http\Controllers\MaritimeOperationsManagement;
use App\Http\Controllers\MyBaseController;


use App\Models\MaritimeOperationsManagement\MaritimeVesselResponsibles;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class MaritimeVesselResponsiblesController extends MyBaseController
{

    public function maritimeVesselsResposiblesAdmin()
    {
        $dataPost = Request::all();
        $model = new  MaritimeVesselResponsibles();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }
    public function saveMaritimeVesselResponsiblesApi()
    {

        $attributesPost = Request::all();
        $model = new MaritimeVesselResponsibles();

        $result = $model->saveMaritimeVesselResponsiblesApi($attributesPost);
        return Response::json($result);
    }

}
