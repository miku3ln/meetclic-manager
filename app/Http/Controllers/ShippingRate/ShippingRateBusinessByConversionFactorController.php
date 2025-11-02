<?php
namespace App\Http\Controllers\ShippingRate ;

use App\Http\Controllers\MyBaseController;
use App\Models\ShippingRateBusinessByConversionFactor;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
class ShippingRateBusinessByConversionFactorController extends  MyBaseController
{

public function getAdmin()
{
$dataPost = Request::all();
$model = new ShippingRateBusinessByConversionFactor();
$result = $model->getAdmin($dataPost);

return Response::json(
$result
);
}

public function saveData()
{

$attributesPost = Request::all();
$model = new ShippingRateBusinessByConversionFactor();
$result = $model->saveData(array("attributesPost" => $attributesPost));
return Response::json($result);
}


public function getListSelect2()
{

$attributesPost = Request::all();
$model = new  ShippingRateBusinessByConversionFactor();
$result = $model->getListSelect2($attributesPost);
return Response::json($result);
}
}
