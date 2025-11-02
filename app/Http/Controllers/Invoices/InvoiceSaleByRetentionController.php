<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\MyBaseController;
use App\Models\InvoiceSaleByRetention;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class InvoiceSaleByRetentionController extends MyBaseController
{


    public function getValidateInvoiceExist()
    {

        $result = array();
        $result['success'] = false;
        $result['msj'] = "";
        $numero_retencion = $_GET["numero_retencion"];
        $establecimiento = $_GET["establecimiento"];
        $punto_emision = $_GET["punto_emision"];

        $attributesParams = array(
            "number_retention" => $numero_retencion,
            "establishment" => $establecimiento,
            "emission_point" => $punto_emision
        );
        $attributesPost = Request::all();
        $model = new   InvoiceSaleByRetention();
        $result = $model->findByAttributes($attributesParams);
        $success = false;
        if ($result) {
            $success = true;

        }

        $result['success'] = $success;
        return Response::json($result);
    }
}
