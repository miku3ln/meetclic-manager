<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


use Auth;

class BusinessByInventoryManagementSubcategoryController extends MyBaseController
{

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new \App\Models\BusinessByInventoryManagementSubcategory();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new  \App\Models\ BusinessByInventoryManagementSubcategory();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }
}

