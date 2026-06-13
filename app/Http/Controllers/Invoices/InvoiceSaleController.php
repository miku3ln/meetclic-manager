<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\MyBaseController;
use App\Models\InvoiceSale;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class InvoiceSaleController extends MyBaseController
{
    public function getValidateInvoiceExist()
    {
        $result = array();
        $result['success'] = false;
        $result['msj'] = "";
        $codigo_factura = $_GET["codigo_factura"];
        $establecimiento = $_GET["establecimiento"];
        $punto_emision = $_GET["punto_emision"];

        $attributesParams = array(
            "invoice_code" => $codigo_factura,
            "establishment" => $establecimiento,
            "emission_point" => $punto_emision
        );
        $attributesPost = Request::all();
        $model = new  InvoiceSale();
        $resultData = $model->findByAttributes($attributesParams);
        $success = false;

        if ($resultData == null) {
            $success = false;

        } else {
            $success = true;
        }

        $result['success'] = $success;
        return Response::json($result);

    }

    public function saveInvoicePointOfSales()
    {

        $attributesPost = Request::all();
        $model = new InvoiceSale();
        $result = $model->saveInvoicePointOfSales(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getInvoiceSaleAdmin()
    {
        $dataPost = Request::all();
        $model = new InvoiceSale();
        $result = $model->getInvoiceSaleAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function saveAnnulmentBilling()
    {

        $attributesPost = Request::all();
        $model = new InvoiceSale();
        $result = $model->saveAnnulmentBilling(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getInvoiceList()
    {
        $dataPost = Request::all();
        $model = new InvoiceSale();
        $result = $model->getInvoiceList($dataPost);
        return Response::json(
            $result
        );
    }

    public function emmitInvoiceByInvoice()
    {
        $dataPost = Request::all();

        $businessId = $dataPost['businessId'];
        $invoiceId = $dataPost['invoiceId'];
        $urlManager = 'https://invoice-sign.meetclic.com/api/v1/facturacion/sri/emmit-invoice-by-business';
        $response = Http::get(
            $urlManager,
            [
                'businessId' => $businessId,
                'invoiceId' => $invoiceId,
            ]
        );


        $dataResponse = $response->json();
        if (isset($dataResponse['success']) && $dataResponse['success']) {
            $attributesParams = array(
                "id" => $invoiceId
            );
            $model = new  InvoiceSale();
            $resultData = $model->findByAttributes($attributesParams);
            if ($resultData) {
                $resultData->authorization_number = 'INVOICE_SEND_EMMIT';
                $resultData->save();
            }
        }

        return Response::json(
            $dataResponse
        );


    }
}
