<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessSubcategories;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class BusinessSubcategoriesController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new BusinessSubcategories();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new BusinessSubcategories();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  BusinessSubcategories();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
