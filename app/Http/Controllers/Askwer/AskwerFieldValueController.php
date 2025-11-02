<?php

namespace App\Http\Controllers\Askwer;

use App\Http\Controllers\MyBaseController;
use App\Models\AskwerFieldValue;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AskwerFieldValueController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new AskwerFieldValue();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new AskwerFieldValue();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  AskwerFieldValue();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function getDataAskwerResults()
    {

        $attributesPost =Request::all();
        $model = new  AskwerFieldValue();
        $result = $model->getDataAskwerResults($attributesPost);
        return Response::json($result);
    }
}
