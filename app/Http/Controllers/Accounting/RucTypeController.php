<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\MyBaseController;
use App\Models\RucType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class RucTypeController extends MyBaseController
{



    public function getManager()
    {

        $model = new RucType();
        $moduleMain = "accounting";
        $moduleResource = "rucType";
        $moduleFolder = "rucType";
        $renderView = "$moduleMain.$moduleFolder.index";
        $model_entity = "rucType";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;

        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
            ),
            "rootView" => $rootView,
            "model_entity" => $model_entity,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];


        $this->layout->content = View::make($renderView, $paramsSend);
    }
    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new RucType();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new RucType();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

}
