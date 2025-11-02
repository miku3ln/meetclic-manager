<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByAcademicOfferingsInstitution;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class BusinessByAcademicOfferingsInstitutionController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new BusinessByAcademicOfferingsInstitution();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new BusinessByAcademicOfferingsInstitution();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

}
