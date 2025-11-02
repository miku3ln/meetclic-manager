<?php
namespace App\Http\Controllers\Business ;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessLocation;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class BusinessLocationController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new BusinessLocation();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost =Request::all();
$model = new BusinessLocation();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}
public function getManager()
                 {    $model = new BusinessLocation();
    $moduleMain= 'business';
    $moduleResource= 'businessLocation';
    $moduleFolder= $moduleResource;
    $renderView= "$moduleMain.$moduleFolder.index";
    $pathCurrent = "$moduleMain/$moduleFolder";
    $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
    $dataCatalogue = array(
    );

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
$model = new  BusinessLocation();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
