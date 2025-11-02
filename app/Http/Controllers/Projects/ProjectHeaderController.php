<?php
//CPP-011
namespace App\Http\Controllers\Projects;

use App\Http\Controllers\BusinessBaseController;

use App\Models\Projects\ProjectHeader;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class ProjectHeaderController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ProjectHeader();
        $result= $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProjectHeader();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListData()
    {

        $attributesPost = Request::all();
        $model = new ProjectHeader();
        $result = $model->getListData($attributesPost);
        return Response::json($result);
    }

}
