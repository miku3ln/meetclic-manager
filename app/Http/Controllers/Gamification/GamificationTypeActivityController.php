<?php

namespace App\Http\Controllers\Gamification;

use App\Http\Controllers\MyBaseController;
use App\Models\GamificationTypeActivity;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class GamificationTypeActivityController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new GamificationTypeActivity();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new GamificationTypeActivity();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  GamificationTypeActivity();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
