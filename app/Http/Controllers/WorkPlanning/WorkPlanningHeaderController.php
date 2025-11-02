<?php
//CPP-011
namespace App\Http\Controllers\WorkPlanning;

use App\Http\Controllers\BusinessBaseController;

use App\Models\WorkPlanning\WorkPlanningHeader;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class WorkPlanningHeaderController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new WorkPlanningHeader();
        $result= $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new WorkPlanningHeader();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new WorkPlanningHeader();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }

}
