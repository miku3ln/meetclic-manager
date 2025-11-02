<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\MyBaseController;
use App\Models\LanguageProductSubcategory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LanguageProductSubcategoryController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LanguageProductSubcategory();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new LanguageProductSubcategory();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  LanguageProductSubcategory();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function setDelete()
    {

        $attributesPost = Request::all();

        $model = new  LanguageProductSubcategory();
        $result = $model->setDelete($attributesPost);
        return Response::json($result);
    }
}
