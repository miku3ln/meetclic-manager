<?php

namespace App\Http\Controllers\Fix;

use App\Http\Controllers\MyBaseController;
use App\Models\Repair;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class RepairController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new Repair();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost =Request::all();
        $model = new Repair();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost =Request::all();
        $model = new  Repair();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function getResults()
    {
        $attributesPost = Request::all();
        $model = new  Repair();
        $result = $model->getResults($attributesPost);
        return Response::json($result);
    }
}
