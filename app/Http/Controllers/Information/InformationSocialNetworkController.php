<?php

namespace App\Http\Controllers\Information;

use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\InformationSocialNetwork;

class InformationSocialNetworkController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new InformationSocialNetwork();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new InformationSocialNetwork();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  InformationSocialNetwork();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function saveDataFrontend()
    {

        $attributesPost = Request::all();
        $model = new InformationSocialNetwork();
        $result = $model->saveDataFrontend(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function deleteFrontend()
    {

        $attributesPost = Request::all();
        $model = new InformationSocialNetwork();
        $result = $model->deleteFrontend(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
