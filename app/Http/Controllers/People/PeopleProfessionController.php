<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\MyBaseController;
use App\Models\PeopleProfession;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class PeopleProfessionController extends MyBaseController
{


    public function getManager()
    {
        $model = new PeopleProfession();


        $moduleMain = 'people';
        $moduleResource = 'peopleProfession';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();
        $modelName = "PeopleProfession";
        $modelNameAction="people-profession";
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

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new PeopleProfession();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new PeopleProfession();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

}
