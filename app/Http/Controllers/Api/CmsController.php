<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\BusinessBaseController;

use App\Models\ApiRest\GetDataModel;
use App\Models\Business;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
class CmsController extends BusinessBaseController
{

    public function __construct()
    {


    }
    public function getDataListBusiness()
    {
        $data = Request::all();
        $modelBusiness= new GetDataModel();
        $result = $modelBusiness->getDataManagerBusiness($data);

        return Response::json(
            $result
        );

    }
    public function getDataToken()
    {
        $data = Request::all();
        $modelBusiness= new GetDataModel();
        $result = $modelBusiness->getDataManagerBusiness($data);

        return Response::json(
            $result
        );

    }

}
