<?php
//CPP-011
namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\BusinessBaseController;

use App\Models\PayRoll\HumanResourcesScheduleType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class HumanResourcesScheduleTypeController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesScheduleType();
        $result = $model->getAdmin($dataPost);


        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesScheduleType();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesScheduleType();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }
}
