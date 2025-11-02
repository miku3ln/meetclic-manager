<?php
namespace App\Http\Controllers\Frontend ;

use App\Http\Controllers\MyBaseController;
use App\Models\TemplateAboutUsByData;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class TemplateAboutUsByDataController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new TemplateAboutUsByData();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost =Request::all();
$model = new TemplateAboutUsByData();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}


public function getListSelect2()
{

$attributesPost =Request::all();
$model = new  TemplateAboutUsByData();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
