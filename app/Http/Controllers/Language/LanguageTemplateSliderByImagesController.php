<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\MyBaseController;
use App\Models\LanguageTemplateSliderByImages;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class LanguageTemplateSliderByImagesController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new LanguageTemplateSliderByImages();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new LanguageTemplateSliderByImages();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getAdminActivitiesGamification()
    {
        $dataPost = Request::all();
        $model = new LanguageTemplateSliderByImages();
        $result = $model->getAdminActivitiesGamification($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataActivitiesGamification()
    {

        $attributesPost = Request::all();
        $model = new LanguageTemplateSliderByImages();
        $result = $model->saveDataActivitiesGamification(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getAdminRewardsGamification()
    {
        $dataPost = Request::all();
        $model = new LanguageTemplateSliderByImages();
        $result = $model->getAdminRewardsGamification($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataRewardsGamification()
    {

        $attributesPost = Request::all();
        $model = new LanguageTemplateSliderByImages();
        $result = $model->saveDataRewardsGamification(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  LanguageTemplateSliderByImages();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function setDelete()
    {

        $attributesPost = Request::all();

        $model = new  LanguageTemplateSliderByImages();
        $result = $model->setDelete($attributesPost);
        return Response::json($result);
    }
    public function setDeleteRewardsGamification()
    {

        $attributesPost = Request::all();

        $model = new  LanguageTemplateSliderByImages();
        $result = $model->setDeleteRewardsGamification($attributesPost);
        return Response::json($result);
    }
    public function setDeleteActivitiesGamification()
    {

        $attributesPost = Request::all();

        $model = new  LanguageTemplateSliderByImages();
        $result = $model->setDeleteActivitiesGamification($attributesPost);
        return Response::json($result);
    }
}
