<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\HistoryClinic;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class HistoryClinicController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HistoryClinic();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HistoryClinic();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new HistoryClinic();
        $moduleMain = 'hospital';
        $moduleResource = 'historyClinic';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();

        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
                "dataCatalogue" => $dataCatalogue
            ),
            "rootView" => $rootView,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];

        $this->layout->content = View::make($renderView, $paramsSend);

    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  HistoryClinic();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function saveDataProfilePatient()
    {

        $attributesPost = Request::all();
        $model = new \App\Models\Customer();
        $result = $model->saveDataProfilePatient(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function getDataHistoryClinicLog()
    {

        $attributesPost = Request::all();
        $model = new \App\Models\HistoryClinic();
        $resultData = $model->getDataHistoryClinicLog($attributesPost);
        $result=[
            'success'=>true,
            'data'=>$resultData
        ];
        return Response::json($result);
    }
}
