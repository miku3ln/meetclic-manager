<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateBySource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TemplateBySourceController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new TemplateBySource();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new TemplateBySource();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  TemplateBySource();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function getSourcesTypesData()
    {

        $attributesPost = Request::all();
        $model = new  TemplateBySource();
        $result = $model->getSourcesTypesData($attributesPost);
        return Response::json($result);
    }
}
