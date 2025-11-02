<?php
namespace App\Http\Controllers\Askwer ;

use App\Http\Controllers\MyBaseController;
use App\Models\AskwerSection;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class AskwerSectionController extends  MyBaseController
{

public function getAdmin()
{
$dataPost =Request::all();
$model = new AskwerSection();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost = Request::all();
$model = new AskwerSection();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}


public function getListSelect2()
{

$attributesPost =Request::all();
$model = new  AskwerSection();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
