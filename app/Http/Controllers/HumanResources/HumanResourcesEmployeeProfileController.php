<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\BusinessBaseController;
use App\Models\HumanResourcesEmployeeProfile;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class HumanResourcesEmployeeProfileController extends BusinessBaseController
{



    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesEmployeeProfile();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesEmployeeProfile();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }
    public function getFullNameListDataAreaAll()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesEmployeeProfile();
        $result = $model->getFullNameListDataAreaAll($attributesPost);
        return Response::json($result);
    }
    public function getFullNameListDataDepartmentAll()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesEmployeeProfile();
        $result = $model->getFullNameListDataDepartmentAll($attributesPost);
        return Response::json($result);
    }
}



