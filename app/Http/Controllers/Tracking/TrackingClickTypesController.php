<?php

namespace App\Http\Controllers\Tracking;
use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Tracking\TrackingClickTypes;

class TrackingClickTypesController extends MyBaseController
{
    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  TrackingClickTypes();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

}

