<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductByRouteMap;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ProductByRouteMapController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ProductByRouteMap();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductByRouteMap();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new ProductByRouteMap();
        $moduleMain = 'products';
        $moduleResource = 'productByRouteMap';
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
        $model = new  ProductByRouteMap();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function getRouteProduct()
    {

        $attributesPost = Request::all();
        $model = new  ProductByRouteMap();
        $result = $model->getRouteProduct($attributesPost);
        return Response::json($result);
    }
    public function deleteRouteProduct()
    {

        $attributesPost = Request::all();
        $model = new  ProductByRouteMap();
        $result = $model->deleteRouteProduct($attributesPost);
        return Response::json($result);
    }
}
