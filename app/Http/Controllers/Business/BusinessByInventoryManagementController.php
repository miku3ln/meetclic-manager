<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


use Auth;

class BusinessByInventoryManagementController extends MyBaseController
{





    public function getDataProfileBusiness()
    {

        $attributesPost = Request::all();
        $model = new \App\Models\BusinessByInventoryManagement();
        $resultData = $model->getDataProfileBusiness($attributesPost);
        $result=[
            'success'=>true,
            'data'=>$resultData
        ];
        return Response::json($result);
    }
    public function getAdmin ()
    {

        $attributesPost = Request::all();
        $model = new \App\Models\BusinessByInventoryManagement();
        $resultData = $model->getDataProfileBusiness($attributesPost);
        $result=[
            'success'=>true,
            'data'=>$resultData
        ];
        return Response::json($result);
    }
    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new \App\Models\BusinessByInventoryManagement();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

}

