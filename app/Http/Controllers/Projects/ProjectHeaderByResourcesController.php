<?php
//CPP-011
namespace App\Http\Controllers\Projects;

use App\Http\Controllers\BusinessBaseController;

use App\Models\Projects\ProjectHeaderByResources;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class ProjectHeaderByResourcesController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ProjectHeaderByResources();
        $result = $model->getAdmin($dataPost);


        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProjectHeaderByResources();
        $result = $model->saveData(array("attributesPost" => ['ProjectHeaderByResources' => $attributesPost]));
        return Response::json($result);
    }


    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new ProjectHeaderByResources();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }
}
