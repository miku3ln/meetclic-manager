<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\BusinessBaseController;

use App\Models\HumanResources\HumanResourcesDepartmentByOrganizationalChartArea;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;



class HumanResourcesDepartmentByOrganizationalChartAreaController extends BusinessBaseController
{
    public function getDataByChartArea()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesDepartmentByOrganizationalChartArea();
        $result = $model->getDataByChartArea($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesDepartmentByOrganizationalChartArea();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

}



