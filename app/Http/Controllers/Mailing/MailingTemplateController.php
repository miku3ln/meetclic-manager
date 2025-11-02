<?php

namespace App\Http\Controllers\Mailing;

use App\Http\Controllers\MyBaseController;
use App\Models\MailingTemplate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class MailingTemplateController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new MailingTemplate();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new MailingTemplate();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  MailingTemplate();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
