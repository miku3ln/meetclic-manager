<?php
namespace App\Http\Controllers\Information ;

use App\Http\Controllers\MyBaseController;
use App\Models\InformationPhoneType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class InformationPhoneTypeController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new InformationPhoneType();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost = Request::all();
$model = new InformationPhoneType();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}
public function getManager()
                 {    $model = new InformationPhoneType();
    $moduleMain= 'information';
    $moduleResource= 'informationPhoneType';
    $moduleFolder= $moduleResource;
    $renderView= "$moduleMain.$moduleFolder.index";
    $model_entity= $moduleResource;
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
    "model_entity" => $model_entity,
    'model' => $model,
    "pathCurrent" => $pathCurrent,

    ];

    $this->layout->content = View::make($renderView, $paramsSend);

    }


public function getListSelect2()
{

$attributesPost = Request::all();
$model = new  InformationPhoneType();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
