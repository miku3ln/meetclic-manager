<?php

namespace App\Http\Controllers\ProductsMeasure;

use App\Http\Controllers\MyBaseController;

use App\Models\BusinessByHistory;
use App\Models\ProductsMeasure\UnitMeasure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class UnitMeasureController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new UnitMeasure();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new UnitMeasure();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }



    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  UnitMeasure();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
