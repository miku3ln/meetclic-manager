<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateSlider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TemplateSliderController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new TemplateSlider();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new TemplateSlider();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost =Request::all();
        $model = new  TemplateSlider();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }


    public function getAdminActivitiesGamification()
    {
        $dataPost = Request::all();
        $model = new TemplateSlider();
        $result = $model->getAdminActivitiesGamification($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataActivitiesGamification()
    {

        $attributesPost = Request::all();
        $model = new TemplateSlider();
        $result = $model->saveDataActivitiesGamification(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getAdminRewardsGamification()
    {
        $dataPost = Request::all();
        $model = new TemplateSlider();
        $result = $model->getAdminRewardsGamification($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataRewardsGamification()
    {

        $attributesPost = Request::all();
        $model = new TemplateSlider();
        $result = $model->saveDataRewardsGamification(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
