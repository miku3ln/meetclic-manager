<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\MyBaseController;
use App\Models\LanguageProductColor;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class LanguageProductColorController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LanguageProductColor();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new LanguageProductColor();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  LanguageProductColor();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function setDelete()
    {

        $attributesPost = Request::all();

        $model = new  LanguageProductColor();
        $result = $model->setDelete($attributesPost);
        return Response::json($result);
    }
}
