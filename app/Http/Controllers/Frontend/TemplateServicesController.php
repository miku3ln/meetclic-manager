<?php
namespace App\Http\Controllers\Frontend ;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateServices;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class TemplateServicesController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new TemplateServices();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost = Request::all();
$model = new TemplateServices();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}


public function getListSelect2()
{

$attributesPost = Request::all();
$model = new  TemplateServices();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
