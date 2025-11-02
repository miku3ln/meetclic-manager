<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\MyBaseController;
use App\Models\InvoiceBuyByRetention;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class InvoiceBuyByRetentionController extends MyBaseController
{

    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  InvoiceBuyByRetention();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
