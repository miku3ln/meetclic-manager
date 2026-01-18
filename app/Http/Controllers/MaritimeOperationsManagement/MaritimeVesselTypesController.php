<?php

namespace App\Http\Controllers\MaritimeOperationsManagement;
use App\Http\Controllers\MyBaseController;

use App\Models\MaritimeOperationsManagement\MaritimeVesselTypes;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class MaritimeVesselTypesController extends MyBaseController
{


    public function vesselTypesList()
    {
        $dataPost = Request::all();
        $model = new MaritimeVesselTypes();
        $result = $model->getDataTypes($dataPost);

        return Response::json(
            $result
        );
    }
}
