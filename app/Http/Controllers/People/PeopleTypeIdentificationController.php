<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\MyBaseController;
use App\Models\PeopleTypeIdentification;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class PeopleTypeIdentificationController extends MyBaseController
{


    public function getManager()
    {
        $model = new PeopleTypeIdentification();
        $moduleMain = 'people';
        $moduleResource = 'peopleTypeIdentification';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();
        $modelElement="people-type-identification";
        $modelName = "PeopleTypeIdentification";
        $modelNameAction="people-type-identification";
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
            'modelElement' => $modelElement,
            "pathCurrent" => $pathCurrent,

        ];

        $this->layout->content = View::make($renderView, $paramsSend);
    }
    public function getAdmin()
    {
        $dataPost =Request::all();
        $model = new PeopleTypeIdentification();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new PeopleTypeIdentification();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

}
