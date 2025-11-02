<?php

namespace App\Http\Controllers\Askwer;

use App\Http\Controllers\MyBaseController;
use App\Models\AskwerForm;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AskwerFormController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new AskwerForm();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new AskwerForm();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  AskwerForm();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function saveAskwer()
    {

        $attributesPost = Request::all();
        $model = new AskwerForm();
        $result = $model->saveAskwer(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getDataSolutionsAskwer()
    {

        $attributesPost = Request::all();
        $model = new AskwerForm();
        $result = $model->getDataSolutionsAskwer(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
