<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\MyBaseController;
use App\Models\PeopleNationality;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class PeopleNationalityController extends MyBaseController
{


    public function getManager()
    {

        $model = new PeopleNationality();

        $moduleMain = 'people';
        $moduleResource = 'peopleNationality';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();
        $model_entity = "peopleNationality";
        $modelName = "PeopleNationality";
        $modelNameAction = "people-nationality";
        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
                "dataCatalogue" => $dataCatalogue,
                "modelCamelCase" => $moduleResource,
                "modelName" => $modelName,
                "modelNameAction" => $modelNameAction,
            ),
            "rootView" => $rootView,
            'model' => $model,
            "pathCurrent" => $pathCurrent,
            "model_entity" => $model_entity,
            "modelName" => $modelName,
            "modelNameAction" => $modelNameAction,
        ];

        $this->layout->content = View::make($renderView, $paramsSend);
    }

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new PeopleNationality();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new PeopleNationality();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

}
