<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\MyBaseController;
use App\Models\TypesPaymentsByAccount;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TypesPaymentsByAccountController extends MyBaseController
{


    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new TypesPaymentsByAccount();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getAccountingPaymentsS2()
    {

        $attributesPost = Request::all();
        $result = [];
        if ($attributesPost['tipo_pago'] > 0) {
            $model = new  TypesPaymentsByAccount();
            $result = $model->getAccountingPaymentsS2($attributesPost);
        }
        return Response::json($result);
    }
}
