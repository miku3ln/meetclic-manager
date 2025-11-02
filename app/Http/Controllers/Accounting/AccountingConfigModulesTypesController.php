<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\MyBaseController;
use App\Models\AccountingConfigModulesTypes;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class AccountingConfigModulesTypesController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new AccountingConfigModulesTypes();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new AccountingConfigModulesTypes();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new AccountingConfigModulesTypes();
        $moduleMain = 'accounting';
        $moduleResource = 'accountingConfigModulesTypes';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $model_entity = $moduleResource;
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
            "model_entity" => $model_entity,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];

        $this->layout->content = View::make($renderView, $paramsSend);

    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  AccountingConfigModulesTypes();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
