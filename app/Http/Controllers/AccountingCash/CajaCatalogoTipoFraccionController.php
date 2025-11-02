<?php
namespace App\Http\Controllers\AccountingCash ;

use App\Http\Controllers\MyBaseController;
use App\Models\CajaCatalogoTipoFraccion;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class CajaCatalogoTipoFraccionController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new CajaCatalogoTipoFraccion();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost = Request::all();
$model = new CajaCatalogoTipoFraccion();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}
public function getManager()
                 {    $model = new CajaCatalogoTipoFraccion();
    $moduleMain= 'accountingCash';
    $moduleResource= 'cajaCatalogoTipoFraccion';
    $moduleFolder= $moduleResource;
    $renderView= "$moduleMain.$moduleFolder.index";
    $pathCurrent = "$moduleMain/$moduleFolder";
    $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
    $dataCatalogue = array(
    );
    $modelEntity = $moduleResource;

    $managerOptions=[
    'pageTitle'=>'Title Page',
    'menuParentName'=>'Parent Name',
    'menuName'=>'Name',
    'grid'=>[
    'renderView'=>'partials.adminViewVue',
    'managerData'=>[
    'title'=>'ready',
    'body'=>''
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
"managerOptions"=>$managerOptions
    ];

    $this->layout->content = View::make($renderView, $paramsSend);

    }


public function getListSelect2()
{

$attributesPost = Request::all();
$model = new  CajaCatalogoTipoFraccion();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
