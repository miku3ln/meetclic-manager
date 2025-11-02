<?php
//CPP-011
namespace App\Http\Controllers\WorkPlanning;

use App\Http\Controllers\BusinessBaseController;

use App\Models\WorkPlanning\WorkPlanningHeaderByResources;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class WorkPlanningHeaderByResourcesController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new WorkPlanningHeaderByResources();
        $result = $model->getAdmin($dataPost);


        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new WorkPlanningHeaderByResources();
        $result = $model->saveData(array("attributesPost" => ['WorkPlanningHeaderByResources' => $attributesPost]));
        return Response::json($result);
    }


    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new WorkPlanningHeaderByResources();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }
}
