<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\MyBaseController;
use App\Models\InvoiceSaleByIndebtednessPayingInit;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class InvoiceSaleByIndebtednessPayingInitController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new InvoiceSaleByIndebtednessPayingInit();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveIndebtedness()
    {

        $attributesPost = Request::all();
        $model = new InvoiceSaleByIndebtednessPayingInit();
        $result = $model->saveIndebtedness(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManager()
    {
        $model = new InvoiceSaleByIndebtednessPayingInit();
        $moduleMain = 'invoices';
        $moduleResource = 'invoiceSaleByIndebtednessPayingInit';
        $moduleFolder = $moduleResource;
        $renderView = "$moduleMain.$moduleFolder.index";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $dataCatalogue = array();
        $modelEntity = $moduleResource;

        $managerOptions = [
            'pageTitle' => 'Title Page',
            'menuParentName' => 'Parent Name',
            'menuName' => 'Name',
            'grid' => [
                'renderView' => 'partials.adminViewVue',
                'managerData' => [
                    'title' => 'ready',
                    'body' => ''
                ]
            ]
        ];


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
            "modelEntity" => $modelEntity,
            "managerOptions" => $managerOptions
        ];

        $this->layout->content = View::make($renderView, $paramsSend);

    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  InvoiceSaleByIndebtednessPayingInit();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
