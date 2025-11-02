<?php

namespace App\Http\Controllers\Mailing;

use App\Http\Controllers\MyBaseController;
use App\Models\MailingByDataSend;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class MailingByDataSendController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new MailingByDataSend();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveDataSend()
    {

        $attributesPost = Request::all();
        $model = new MailingByDataSend();
        $result = $model->saveDataSend(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function saveDataSendData()
    {

        $attributesPost = Request::all();
        $model = new MailingByDataSend();
        $result = $model->saveDataSendData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  MailingByDataSend();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
