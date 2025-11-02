<?php
//CPP-011
namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\BusinessBaseController;

use App\Models\PayRoll\HumanResourcesShift;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class HumanResourcesShiftController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesShift();
        $result = $model->getAdmin($dataPost);


        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesShift();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesShift();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }
}
