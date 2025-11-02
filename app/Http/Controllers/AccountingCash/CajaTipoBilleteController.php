<?php

namespace App\Http\Controllers\AccountingCash;

use App\Http\Controllers\MyBaseController;
use App\Models\CajaTipoBillete;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class CajaTipoBilleteController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new CajaTipoBillete();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new CajaTipoBillete();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new CajaTipoBillete();
        $moduleMain = 'accountingCash';
        $moduleResource = 'cajaTipoBillete';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();
        $modelEntity = $moduleResource;

        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
                "dataCatalogue" => $dataCatalogue
            ),
            "rootView" => $rootView,
            "modelEntity" => $modelEntity,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];
/*dd('sds','model_entity ');*/

        $this->layout->content = View::make($renderView, $paramsSend);

    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  CajaTipoBillete();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
