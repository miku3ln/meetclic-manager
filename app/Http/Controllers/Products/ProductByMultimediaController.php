<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\MyBaseController;
use App\Models\ProductByMultimedia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ProductByMultimediaController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new ProductByMultimedia();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new ProductByMultimedia();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  ProductByMultimedia();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
    public function addMultimedia($id=null)
    {

        $attributesPost = Request::all();
        $model = new  ProductByMultimedia();
        $setData=[
            'attributesPost'=>$attributesPost,
            'idParent'=>$id
        ];
        $result = $model->addMultimedia($setData);
        return Response::json($result);
    }
    public function removeMultimedia($id=null)
    {

        $attributesPost = Request::all();
        $model = new  ProductByMultimedia();
        $setData=[
            'attributesPost'=>$attributesPost,
        ];
        $result = $model->removeMultimedia($setData);
        return Response::json($result);
    }
}
