<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\MyBaseController;
use App\Models\LanguageProductCategory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class LanguageProductCategoryController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LanguageProductCategory();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new LanguageProductCategory();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  LanguageProductCategory();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function setDelete()
    {

        $attributesPost = Request::all();

        $model = new  LanguageProductCategory();
        $result = $model->setDelete($attributesPost);
        return Response::json($result);
    }
}
