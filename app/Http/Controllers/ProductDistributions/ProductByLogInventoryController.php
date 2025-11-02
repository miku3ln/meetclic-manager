<?php

namespace App\Http\Controllers\ProductDistributions;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductDistributions\ProductByLogInventory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductByLogInventoryController extends MyBaseController
{




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductByLogInventory();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


}
