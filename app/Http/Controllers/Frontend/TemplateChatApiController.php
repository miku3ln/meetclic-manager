<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateChatApi;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TemplateChatApiController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new TemplateChatApi();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new TemplateChatApi();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost =Request::all();
        $model = new  TemplateChatApi();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function getChatsTypesData()
    {

        $attributesPost = Request::all();
        $model = new  TemplateChatApi();
        $result = $model->getChatsTypesData($attributesPost);
        return Response::json($result);
    }
}
