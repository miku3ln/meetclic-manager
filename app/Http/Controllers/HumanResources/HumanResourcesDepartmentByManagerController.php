<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\BusinessBaseController;

use App\Models\HumanResources\HumanResourcesDepartmentByManager;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class HumanResourcesDepartmentByManagerController extends BusinessBaseController
{



    public function getResponsible()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesDepartmentByManager();
        $result = $model->getResponsible($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesDepartmentByManager();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

}



