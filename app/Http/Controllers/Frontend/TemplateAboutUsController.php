<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\TemplateAboutUs;
class TemplateAboutUsController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new TemplateAboutUs();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new TemplateAboutUs();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  TemplateAboutUs();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
