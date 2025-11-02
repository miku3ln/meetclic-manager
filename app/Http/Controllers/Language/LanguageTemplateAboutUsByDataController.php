<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\MyBaseController;
use App\Models\LanguageTemplateAboutUsByData;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class LanguageTemplateAboutUsByDataController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LanguageTemplateAboutUsByData();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new LanguageTemplateAboutUsByData();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  LanguageTemplateAboutUsByData();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function setDelete()
    {

        $attributesPost = Request::all();

        $model = new  LanguageTemplateAboutUsByData();
        $result = $model->setDelete($attributesPost);
        return Response::json($result);
    }
}
