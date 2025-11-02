<?php

namespace App\Http\Controllers\Mikrotik;

use App\Http\Controllers\MyBaseController;
use App\Models\MikrotikByCustomerEngagement;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;

class MikrotikByCustomerEngagementController extends MyBaseController
{

    public function getAdmin(Request $request)
    {

        $dataPost = $request->all();
        $model = new MikrotikByCustomerEngagement();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData(Request $request)
    {

        $attributesPost = $request->all();
        $model = new MikrotikByCustomerEngagement();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2(Request $request)
    {

        $attributesPost = $request->all();
        $model = new  MikrotikByCustomerEngagement();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function managerDisabledEnabledCustomer(Request $request)
    {


        $attributesPost = $request->all();

        $model = new  MikrotikByCustomerEngagement();
        $result = $model->managerDisabledEnabledCustomer($attributesPost);
        return Response::json($result);
    }


}
