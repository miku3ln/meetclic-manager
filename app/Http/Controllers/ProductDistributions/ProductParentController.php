<?php

namespace App\Http\Controllers\ProductDistributions;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductDistributions\ProductParent;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ProductParentController extends MyBaseController
{



    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ProductParent();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }




    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductParent();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


}
