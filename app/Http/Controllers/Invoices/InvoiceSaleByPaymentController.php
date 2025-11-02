<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\MyBaseController;
use App\Models\InvoiceSaleByPayment;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class InvoiceSaleByPaymentController extends MyBaseController
{

    public function getAdminPayments()
    {
        $dataPost = Request::all();
        $model = new InvoiceSaleByPayment();
        $result = $model->getAdminPayments($dataPost);

        return Response::json(
            $result
        );
    }

    public function savePaymentInvoiceDebit()
    {

        $attributesPost = Request::all();
        $model = new InvoiceSaleByPayment();
        $result = $model->savePayment(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


}
