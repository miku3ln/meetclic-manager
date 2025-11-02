<?php

namespace App\Http\Controllers\Products;



use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FrontendDataController extends Controller
{
    public function getAdminFrontend($language="es")
    {
        $dataPost = \Illuminate\Support\Facades\Request::all();
        $model = new Product();

        $data = $model->getAdminFrontend($dataPost);
        $result=Response::json(
            $data
        );

        return $result;
    }
}
