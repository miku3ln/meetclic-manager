<?php

namespace App\Http\Controllers\EventsCustomer;

use App\Http\Controllers\MyBaseController;
use App\Models\EventByAssistance;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class EventByAssistanceController extends MyBaseController
{

    public function getAdminAssistance()
    {
        $dataPost = Request::all();
        $model = new EventByAssistance();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new EventByAssistance();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }



}
