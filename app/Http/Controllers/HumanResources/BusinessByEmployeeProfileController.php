<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\BusinessBaseController;
use App\Models\BusinessByEmployeeProfile;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class BusinessByEmployeeProfileController extends BusinessBaseController
{




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new BusinessByEmployeeProfile();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

}
