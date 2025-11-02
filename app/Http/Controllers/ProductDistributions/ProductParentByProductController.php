<?php

namespace App\Http\Controllers\ProductDistributions;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductDistributions\ProductParentByProduct;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductParentByProductController extends MyBaseController
{




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new Product();
        $result = $model->saveDataByParent(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ProductParentByProduct();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

}
