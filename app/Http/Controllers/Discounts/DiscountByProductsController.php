<?php

namespace App\Http\Controllers\Discounts;

use App\Http\Controllers\MyBaseController;
use App\Models\DiscountByProducts;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class DiscountByProductsController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new DiscountByProducts();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new DiscountByProducts();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  DiscountByProducts();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getAdminProducts()
    {

        $attributesPost = Request::all();
        $model = new  DiscountByProducts();
        $result = $model->getAdminProducts($attributesPost);
        return Response::json($result);
    }

    public function getDetailsProducts()
    {

        $attributesPost = Request::all();
        $model = new  DiscountByProducts();
        $result = $model->getDetailsProducts($attributesPost);
        return Response::json($result);
    }
}
