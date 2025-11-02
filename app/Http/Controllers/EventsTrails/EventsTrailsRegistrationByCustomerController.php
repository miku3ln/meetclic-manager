<?php
namespace App\Http\Controllers\EventsTrails ;

use App\Http\Controllers\MyBaseController;
use App\Models\EventsTrailsRegistrationByCustomer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class EventsTrailsRegistrationByCustomerController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new EventsTrailsRegistrationByCustomer();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost = Request::all();
$model = new EventsTrailsRegistrationByCustomer();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}
public function getManager()
                 {    $model = new EventsTrailsRegistrationByCustomer();
    $moduleMain= 'eventsTrails';
    $moduleResource= 'eventsTrailsRegistrationByCustomer';
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
$model = new  EventsTrailsRegistrationByCustomer();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
