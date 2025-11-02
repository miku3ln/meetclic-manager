<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\MyBaseController;
use App\Models\InvoiceSaleByBreakdownPayment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class InvoiceSaleByBreakdownPaymentController extends MyBaseController
{



    public function getPaymentsCurrentS2()
    {

        $attributesPost = Request::all();
        $model = new  InvoiceSaleByBreakdownPayment();
        $result = $model->getPaymentsCurrentS2($attributesPost);
        return Response::json($result);
    }
}
