<?php

namespace App\Http\Controllers\ProductDistributions;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductDistributions\ProductParentByPackageParams;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductParentByPackageParamsController extends MyBaseController
{




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductParentByPackageParams();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function saveDataDelete()
    {

        $attributesPost = Request::all();
        $model = new ProductParentByPackageParams();
        $result = $model->saveDataDelete(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
