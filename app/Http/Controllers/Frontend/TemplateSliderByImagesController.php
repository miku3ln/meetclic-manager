<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateSliderByImages;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TemplateSliderByImagesController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new TemplateSliderByImages();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new TemplateSliderByImages();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  TemplateSliderByImages();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function getAdminActivitiesGamification()
    {
        $dataPost = Request::all();
        $model = new TemplateSliderByImages();
        $result = $model->getAdminActivitiesGamification($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataActivitiesGamification()
    {

        $attributesPost = Request::all();
        $model = new TemplateSliderByImages();
        $result = $model->saveDataActivitiesGamification(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getAdminRewardsGamification()
    {
        $dataPost = Request::all();
        $model = new TemplateSliderByImages();
        $result = $model->getAdminRewardsGamification($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataRewardsGamification()
    {

        $attributesPost = Request::all();
        $model = new TemplateSliderByImages();
        $result = $model->saveDataRewardsGamification(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
