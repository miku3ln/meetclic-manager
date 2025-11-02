<?php

namespace App\Http\Controllers\EducationalInstitution;

use App\Http\Controllers\MyBaseController;
use App\Models\EducationalInstitutionAskwerType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class EducationalInstitutionAskwerTypeController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new EducationalInstitutionAskwerType();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new EducationalInstitutionAskwerType();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  EducationalInstitutionAskwerType();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
