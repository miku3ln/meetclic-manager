<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\MyBaseController;
use App\Models\PeopleGender;
use Illuminate\Support\Facades\Request;
use Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class PeopleGenderController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost =Request::all();
        $model = new PeopleGender();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new PeopleGender();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new PeopleGender();

        $moduleMain = 'people';
        $moduleResource = 'peopleGender';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();
        $modelName = "PeopleGender";
        $modelNameAction="people-gender";
        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
                "dataCatalogue" => $dataCatalogue,
                "modelCamelCase" => $moduleResource,
                "modelName" => $modelName,
                "modelNameAction" => $modelNameAction
            ),
            "rootView" => $rootView,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];

        $this->layout->content = View::make($renderView, $paramsSend);

    }


    public function getListSelect2()
    {

        $attributesPost =Request::all();
        $model = new  PeopleGender();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
