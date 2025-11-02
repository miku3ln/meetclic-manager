<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\MyBaseController;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use PDF;

class ElectronicSignatureController extends MyBaseController
{


    public function generatePdf()
    {
        $pdf = \App::make('dompdf.wrapper');
        $html = '<h1>Pagina 1</h1>
<div class="page-break"></div>
<h1>Pagina 2</h1>';
        $pdf->loadHtml($html);
        $nameDocument = 'pdfSignature.pdf';
        $pdf->setPaper('a4', 'landscape');
        $pdf->save(storage_path('app/public/') . 'archivo.pdf');

        if (false) {

            return $pdf->download($nameDocument);
        }

    }

    public function loadView($data)
    {
        return PDF::loadView('documents.electronicSignature.loadView', $data)
            ->stream('archivo.pdf');

    }

    public function download()
    {
        $pdf = \App::make('dompdf.wrapper');
        $html = '<h1>Hola soy ale</h1>';
        $pdf->loadHtml($html);
        $nameDocument = 'pdfSignature.pdf';
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download($nameDocument);

    }
}
