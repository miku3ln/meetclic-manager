<?php
//CPP-011
namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\BusinessBaseController;

use App\Models\Helpdesk\HelpdeskTypes;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class HelpdeskTypesController extends BusinessBaseController
{


    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new HelpdeskTypes();
        $resultData = $model->getAdmin($dataPost);
        $result = $resultData;
        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new HelpdeskTypes();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }



}
