<?php

namespace App\Http\Controllers\ProductDistributions;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductDistributions\ProductParentByPrices;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductParentByPricesController extends MyBaseController
{




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductParentByPrices();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function saveDataDelete()
    {

        $attributesPost = Request::all();
        $model = new ProductParentByPrices();
        $result = $model->saveDataDelete(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

}
