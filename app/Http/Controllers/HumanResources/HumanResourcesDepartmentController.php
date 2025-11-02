<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\BusinessBaseController;
use App\Models\HumanResourcesDepartment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class HumanResourcesDepartmentController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HumanResourcesDepartment();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesDepartment();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListAll()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesDepartment();
        $result = $model->getListAll($attributesPost);
        return Response::json($result);
    }

    public function getListAllArea()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesDepartment();

        $result = $model->getListAllArea($attributesPost);
        return Response::json($result);
    }

    public function getListByAreaAll()
    {

        $attributesPost = Request::all();
        $model = new HumanResourcesDepartment();
        $result = [];
        if (isset($attributesPost['filters']["parent_manager_id"]) && $attributesPost['filters']["parent_manager_id"] > 0) {
            $result = $model->getListByAreaAll($attributesPost);
        }


        return Response::json($result);
    }
}
