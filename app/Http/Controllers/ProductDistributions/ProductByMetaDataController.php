<?php

namespace App\Http\Controllers\ProductDistributions;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductDistributions\ProductByMetaData;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductByMetaDataController extends MyBaseController
{




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductByMetaData();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


}
