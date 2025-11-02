<?php

namespace App\Http\Controllers\ProsecutorOffice;

use App\Http\Controllers\MyBaseController;
use App\Models\ProsecutorOffice\SecretaryProcessesByCustomerPresentation;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class SecretaryProcessesByCustomerPresentationController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new SecretaryProcessesByCustomerPresentation();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new SecretaryProcessesByCustomerPresentation();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }



}
