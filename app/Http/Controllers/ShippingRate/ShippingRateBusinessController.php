<?php

namespace App\Http\Controllers\ShippingRate;

use App\Http\Controllers\MyBaseController;
use App\Models\ShippingRateBusiness;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ShippingRateBusinessController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ShippingRateBusiness();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ShippingRateBusiness();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new ShippingRateBusiness();
        $moduleMain = 'shippingRate';
        $moduleResource = 'shippingRateBusiness';
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
        $model = new  ShippingRateBusiness();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
