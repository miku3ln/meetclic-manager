<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByMenuManagementFrontend;
use Auth;
use Hash;
use Illuminate\Support\Facades\Request;
use Lang;
use League\Flysystem\Exception;
use Mail;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class BusinessByMenuManagementFrontendController extends MyBaseController
{



    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new BusinessByMenuManagementFrontend();
        $result = $model->getAdminData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new BusinessByMenuManagementFrontend();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }
    public function getListBusinessByMenuManagementFrontendParent()
    {

        $attributesPost = Request::all();
        $model = new BusinessByMenuManagementFrontend();
        $result = $model->getListBusinessByMenuManagementFrontendParent($attributesPost);
        return Response::json($result);
    }

    public function getListActionsParent(){
        $attributesPost = Request::all();
        $model = new BusinessByMenuManagementFrontend();
        $result = $model->getListActionsParent($attributesPost);
        return Response::json($result);
    }

}
