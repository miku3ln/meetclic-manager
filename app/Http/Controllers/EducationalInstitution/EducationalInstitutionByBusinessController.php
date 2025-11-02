<?php

namespace App\Http\Controllers\EducationalInstitution;

use App\Http\Controllers\MyBaseController;
use App\Models\EducationalInstitutionByBusiness;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class EducationalInstitutionByBusinessController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new EducationalInstitutionByBusiness();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new EducationalInstitutionByBusiness();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  EducationalInstitutionByBusiness();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getDataAskwer()
    {

        $attributesPost = Request::all();

        $model = new EducationalInstitutionByBusiness();
        $result = $model->getDataAskwer(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getDataAskwerForm()
    {

        $attributesPost = Request::all();

        $model = new EducationalInstitutionByBusiness();
        $result = $model->getDataAskwerForm(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
