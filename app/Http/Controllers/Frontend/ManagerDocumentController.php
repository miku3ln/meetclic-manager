<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\FrontendBaseController;

use App;

use Auth;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use FPDI;

use UtilCustomProvider;


class ManagerDocumentController extends FrontendBaseController
{


    public function __construct()
    {

    }

    public function signPdf(Request $request)
    {
        $result = [
            "success" => false,
            "data" => [],

        ];
        // Validar entrada
        $request->validate([
            'pdf' => 'required|file|mimes:pdf',
            'certificate' => 'required|file|mimes:p12',
            'password' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        try {
            // Cargar PDF y certificado
            $pdfPath = $request->file('pdf')->getRealPath();
            $certPath = $request->file('certificate')->getRealPath();
            $password = $request->input('password');
            $reason = $request->input('reason', 'Document signed digitally');

            // Leer certificado P12
            $certData = file_get_contents($certPath);
            openssl_pkcs12_read($certData, $certs, $password);

            $privateKey = $certs['pkey'];
            $certificate = $certs['cert'];

            // Inicializar FPDI
            $pdf = new FPDI();
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Importar páginas
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }

            // Agregar la firma (simple, no visible en este caso)
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(10, 10);
            $pdf->Write(10, "Digitally signed: $reason");

            // Crear firma digital (resumen SHA256)
            $digest = hash('sha256', $pdf->Output('S'), true);
            $signature = '';

            openssl_sign($digest, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            // Guardar PDF firmado
            $signedPdfPath = 'signed_' . uniqid() . '.pdf';
            Storage::put($signedPdfPath, $pdf->Output('S'));

            // return response()->download(storage_path('app/' . $signedPdfPath));
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500);
        }
        return Response::json($result);
    }


    public function signPdfLocal1()
    {
        $result = [
            "success" => false,
            "data" => [],
            "typeError" => -2,
            "errors" => [],
        ];

        $typeError = -9;
        $errors = [];

        try {
            // Ruta del PDF a firmar
            $pdfName = "firma01.pdf";
            $pathProcess = "app/public/documents-manager/sign";
            $pdfPath = storage_path($pathProcess . '/pdf_files/' . $pdfName);

            // Verificar si el archivo existe
            if (!file_exists($pdfPath)) {
                $typeError = 1;
                array_push($errors, 'El archivo PDF no existe.');
                $result['errors'] = $errors;
                return response()->json($result, 400); // Retornar con error si no existe el archivo
            }

            // Inicializar FPDI
            $pdf = new FPDI();

            // Ruta del certificado
            $certPath = storage_path($pathProcess . '/certificates/1002954889.p12');
            $password = "St963852";
            $reason = "RAZON PARA FIRMAR";

            // Leer certificado P12
            $certData = file_get_contents($certPath);
            openssl_pkcs12_read($certData, $certs, $password);

            $privateKey = $certs['pkey'];
            $certificate = $certs['cert'];

            // Cargar el archivo PDF a firmar
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Importar todas las páginas del PDF original
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }

            // **Proceso de firma digital**

            // Crear el digest (hash SHA256) del contenido del PDF
            $digest = hash('sha256', $pdf->Output('S'), true);

            // Firmar el digest con la clave privada (firma digital real)
            $signature = '';
            $signSuccess = openssl_sign($digest, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            // Verificar si la firma se generó correctamente
            if (!$signSuccess) {
                array_push($errors, 'Error al generar la firma digital.');
                $result['errors'] = $errors;
                return response()->json($result, 500); // Retornar error si no se pudo firmar
            }

            // Agregar la firma al PDF (visible, en una ubicación específica)
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(10, 10); // Coordenadas de la firma visible
            $pdf->Write(10, "Digitally signed: $reason");

            // **Agregar la firma digital al archivo PDF (pero no visible)**
            // Insertamos la firma digital en el archivo PDF
            $pdf->SetSignature($certificate, $privateKey);

            // Generar un nombre único para el archivo firmado
            $signedPdfName = 'signed_' . uniqid() . '.pdf';
            $signedPdfPath = storage_path($pathProcess . '/signed_pdfs/' . $signedPdfName);

            // Guardar el archivo PDF firmado
            $pdfContent = $pdf->Output('S'); // Generar contenido PDF
            file_put_contents($signedPdfPath, $pdfContent); // Guardar en el sistema

            // Resultado exitoso
            $result['success'] = true;
            $result['data'] = [
                'signed_pdf_path' => $signedPdfPath,
                'signed_pdf_url' => url('storage/signed_pdfs/' . $signedPdfName),
            ];

        } catch (\Exception $e) {
            // Manejo de errores
            $errors[] = $e->getMessage();
            $result['errors'] = $errors;
            return response()->json($result, 500);
        }

        return response()->json($result);
    }

    public function signPdfLocal2()
    {
        $result = [
            "success" => false,
            "data" => [],
            "typeError" => -2,
            "errors" => [],
        ];

        $typeError = -9;
        $errors = [];

        try {
            // Ruta del PDF a firmar
            $pdfName = "firma01.pdf"; // Nombre del archivo PDF
            $pathProcess = "app/public/documents-manager/sign"; // Ruta del archivo en almacenamiento
            $pdfPath = storage_path($pathProcess . '/pdf_files/' . $pdfName); // Ruta completa al archivo

            // Verificar si el archivo existe
            if (!file_exists($pdfPath)) {
                $typeError = 1;
                array_push($errors, 'El archivo PDF no existe.');
                $result['errors'] = $errors;
                return response()->json($result, 400); // Retornar con error si no existe el archivo
            }

            // Inicializar FPDI
            $pdf = new FPDI(); // Crear una instancia de FPDI para trabajar con PDFs

            // Ruta del certificado
            $certPath = storage_path($pathProcess . '/certificates/1002954889.p12');
            $password = "St963852"; // Contraseña para el certificado
            $reason = "RAZON PARA FIRMAR"; // Razón de la firma

            // Leer certificado P12
            $certData = file_get_contents($certPath); // Cargar el archivo del certificado P12
            openssl_pkcs12_read($certData, $certs, $password); // Leer el contenido del archivo P12

            $privateKey = $certs['pkey']; // Clave privada del certificado
            $certificate = $certs['cert']; // Certificado

            // Cargar el archivo PDF a firmar
            $pageCount = $pdf->setSourceFile($pdfPath); // Contar las páginas del PDF

            // Importar todas las páginas del PDF original
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i); // Importar cada página
                $pdf->addPage(); // Agregar una nueva página al documento
                $pdf->useTemplate($tplIdx); // Usar la plantilla de la página importada
            }

            // **Proceso de firma digital**

            // Generar el digest (hash SHA256) del contenido del PDF
            $pdfContent = $pdf->Output('S'); // Obtener el contenido del PDF como cadena de bytes
            $digest = hash('sha256', $pdfContent, true); // Crear el hash SHA256 del PDF

            // Firmar el digest con la clave privada (firma digital real)
            $signature = '';
            $signSuccess = openssl_sign($digest, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            // Verificar si la firma se generó correctamente
            if (!$signSuccess) {
                array_push($errors, 'Error al generar la firma digital.');
                $result['errors'] = $errors;
                return response()->json($result, 500); // Retornar error si no se pudo firmar
            }

            // **Agregar la firma digital al archivo PDF (pero no visible)**
            // Establecer la firma digital en el archivo PDF
            $pdf->SetSignature($certificate, $privateKey); // Insertar la firma digital en el archivo PDF

            // **Agregar la firma visible al PDF**
            $pdf->SetFont('Helvetica', '', 10); // Definir la fuente para la firma visible
            $pdf->SetXY(10, 10); // Coordenadas de la firma visible en el PDF
            $pdf->Write(10, "Digitally signed: $reason"); // Escribir la firma visible

            // Generar un nombre único para el archivo firmado
            $signedPdfName = 'signed_' . uniqid() . '.pdf'; // Nombre único para el archivo firmado
            $signedPdfPath = storage_path($pathProcess . '/signed_pdfs/' . $signedPdfName); // Ruta para guardar el archivo firmado

            // Guardar el archivo PDF firmado
            file_put_contents($signedPdfPath, $pdf->Output('S')); // Guardar el contenido firmado en el archivo

            // Resultado exitoso
            $result['success'] = true;
            $result['data'] = [
                'signed_pdf_path' => $signedPdfPath, // Ruta del archivo firmado
                'signed_pdf_url' => url('storage/signed_pdfs/' . $signedPdfName), // URL del archivo firmado
            ];

        } catch (\Exception $e) {
            // Manejo de errores
            $errors[] = $e->getMessage();
            $result['errors'] = $errors;
            return response()->json($result, 500); // Retornar error si ocurre una excepción
        }

        return response()->json($result); // Retornar resultado exitoso
    }

    public function signPdfLocal33()
    {
        $result = [
            "success" => false,
            "data" => [],
            "typeError" => -2,
            "errors" => [],
        ];

        $typeError = -9;
        $errors = [];

        try {

            // Ruta del PDF a firmar
            $pdfName = "firma01.pdf";
            $pathProcess = "app/public/documents-manager/sign";
            $pdfPath = storage_path($pathProcess . '/pdf_files/' . $pdfName);

            // Verificar si el archivo existe
            if (!file_exists($pdfPath)) {
                $typeError = 1;
                array_push($errors, 'El archivo PDF no existe.');
                $result['errors'] = $errors;
                return response()->json($result, 400); // Retornar con error si no existe el archivo
            }

            // Inicializar FPDI para importar páginas de PDF
            $pdf = new \setasign\Fpdi\TcpdfFpdi(); // Usamos TCPDF con FPDI
            $pdf->setSourceFile($pdfPath); // Cargar el archivo PDF a firmar

            // Ruta del certificado P12
            $certPath = storage_path($pathProcess . '/certificates/1002954889.p12');
            $password = "St963852"; // Contraseña para el certificado
            $reason = "RAZON PARA FIRMAR"; // Razón de la firma

            // Leer certificado P12
            $certData = file_get_contents($certPath); // Cargar el archivo P12
            openssl_pkcs12_read($certData, $certs, $password); // Leer certificado P12

            $privateKey = $certs['pkey']; // Obtener la clave privada
            $certificate = $certs['cert']; // Obtener el certificado

            // Importar las páginas del PDF original
            $pageCount = $pdf->setSourceFile($pdfPath); // Contar las páginas
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i); // Importar cada página
                $pdf->addPage(); // Agregar una nueva página
                $pdf->useTemplate($tplIdx); // Usar la plantilla de la página importada
            }

            // **Proceso de firma digital**

            // Generar el digest (hash SHA256) del contenido del PDF
            $pdfContent = $pdf->Output('S'); // Obtener el contenido del PDF en memoria
            $digest = hash('sha256', $pdfContent, true); // Crear el hash SHA256 del PDF
            dd("DE AQUI PARA ABAJO NO SIGE EL CODIGO Y SOLO SE QUEDA ABIERTO EL DOCUMENTO");
            // Firmar el digest con la clave privada (firma digital real)
            $signature = '';
            $signSuccess = openssl_sign($digest, $signature, $privateKey, OPENSSL_ALGO_SHA256);

            // Verificar si la firma se generó correctamente
            if (!$signSuccess) {
                array_push($errors, 'Error al generar la firma digital.');
                $result['errors'] = $errors;
                return response()->json($result, 500); // Retornar error si no se pudo firmar
            }

            // **Agregar la firma digital al archivo PDF (no visible)**
            $pdf->setSignature($certificate, $privateKey); // Usar TCPDF para establecer la firma digital

            // **Agregar la firma visible al PDF**
            $pdf->SetFont('Helvetica', '', 10); // Definir la fuente para la firma visible
            $pdf->SetXY(10, 10); // Coordenadas de la firma visible
            $pdf->Write(10, "Digitally signed: $reason"); // Escribir la firma visible

            // Generar un nombre único para el archivo firmado
            $signedPdfName = 'signed_' . uniqid() . '.pdf';
            $signedPdfPath = storage_path($pathProcess . '/signed_pdfs/' . $signedPdfName); // Ruta para guardar el archivo firmado

            // Guardar el archivo PDF firmado
            file_put_contents($signedPdfPath, $pdf->Output('S')); // Guardar el contenido firmado en el archivo

            // Resultado exitoso
            $result['success'] = true;
            $result['data'] = [
                'signed_pdf_path' => $signedPdfPath, // Ruta del archivo firmado
                'signed_pdf_url' => url('storage/signed_pdfs/' . $signedPdfName), // URL del archivo firmado
            ];

        } catch (\Exception $e) {
            // Manejo de errores
            $errors[] = $e->getMessage();
            $result['errors'] = $errors;
            return response()->json($result, 500); // Retornar error si ocurre una excepción
        }

        return response()->json($result); // Retornar resultado exitoso
    }

    public function getPositionSign($wordToFind, $pages)
    {
        $result = ["x" => 50, "y" => 50, "page" => 1];
        // Buscar la palabra en cada página
        foreach ($pages as $pageNumber => $page) {
            $text = $page->getText();
            if (strpos($text, $wordToFind) !== false) {
                $found = true;

                // Obtener posición aproximada (requiere una biblioteca más avanzada para precisión)
                $x = 50; // Aproximar en base a análisis
                $y = 100 + ($pageNumber * 10); // Estimar posición vertical por página
                $result = ['page' => $pageNumber + 1, 'x' => $x, 'y' => $y];
                break;
            }
        }


        return $result;
    }

    public function signPdfLocal69()
    {
        $result = [
            "success" => false,
            "data" => [],
            "typeError" => -2,
            "errors" => [],
        ];

        try {
            // Ruta del archivo PDF a firmar
            $pdfName = "firma01.pdf";
            $pathProcess = "app/public/documents-manager/sign";
            $pdfPath = storage_path($pathProcess . '/pdf_files/' . $pdfName);

            // Verificar si el archivo existe
            if (!file_exists($pdfPath)) {
                $result['errors'] = ['El archivo PDF no existe.'];
                return response()->json($result, 400);
            }

            // Ruta y contraseña del certificado
            $certPath = storage_path($pathProcess . '/certificates/1002954889.p12');
            $password = "St963852";
            $reason = "Firma digital por [Tu Nombre]";

            // Leer el certificado P12
            $certData = file_get_contents($certPath);
            if (!openssl_pkcs12_read($certData, $certs, $password)) {
                $result['errors'] = ['No se pudo leer el certificado.'];
                return response()->json($result, 500);
            }

            $privateKey = $certs['pkey']; // Clave privada
            $certificate = $certs['cert']; // Certificado público

            // Inicializar FPDI para importar páginas del PDF
            $pdf = new \setasign\Fpdi\TcpdfFpdi();
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Importar páginas del PDF original
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }

            // Establecer la firma digital en el PDF
            $pdf->setSignature(
                $certificate,        // Certificado público
                $privateKey,         // Clave privada
                $password,           // Contraseña del certificado
                '',                  // Información adicional (vacío por defecto)
                2,                   // Método de hash (2 para SHA-256)
                [
                    'Name' => 'Tu Nombre',
                    'Location' => 'Tu Ubicación',
                    'Reason' => $reason,
                    'ContactInfo' => 'tu@email.com',
                ]
            );

            // Agregar firma visible al PDF
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(10, 10); // Coordenadas de la firma visible
            $pdf->Write(10, "Firmado digitalmente: $reason");

            // Generar un nombre único para el PDF firmado
            $signedPdfName = 'signed_' . uniqid() . '.pdf';
            $signedPdfPath = storage_path($pathProcess . '/signed_pdfs/' . $signedPdfName);

            // Guardar el archivo firmado en el almacenamiento
            $pdf->Output($signedPdfPath, 'F');

            // Configurar respuesta exitosa
            $result['success'] = true;
            $result['data'] = [
                'signed_pdf_path' => $signedPdfPath,
                'signed_pdf_url' => url('storage/signed_pdfs/' . $signedPdfName),
            ];
        } catch (\Exception $e) {
            // Manejo de errores
            $result['errors'] = [$e->getMessage()];
            return response()->json($result, 500);
        }

        return response()->json($result);
    }

    public function signPdfLocal()
    {
        $result = [
            "success" => false,
            "data" => [],
            "typeError" => -2,
            "errors" => [],
        ];

        try {
            // Ruta del archivo PDF a firmar
            $pdfName = "firma01.pdf";
            $pathProcess = "app/public/documents-manager/sign";
            $pdfPath = storage_path($pathProcess . '/pdf_files/' . $pdfName);

            // Verificar si el archivo existe
            if (!file_exists($pdfPath)) {
                $result['errors'] = ['El archivo PDF no existe.'];
                return response()->json($result, 400);
            }

            // Ruta y contraseña del certificado
            $certPath = storage_path($pathProcess . '/certificates/1002954889.p12');
            $password = "St963852";
            $reason = "Firma digital por ALEX ALBA";

            // Leer el certificado P12
            $certData = file_get_contents($certPath);
            if (!openssl_pkcs12_read($certData, $certs, $password)) {
                $result['errors'] = ['No se pudo leer el certificado.'];
                return response()->json($result, 500);
            }

            $privateKey = $certs['pkey']; // Clave privada
            $certificate = $certs['cert']; // Certificado público

            // Inicializar FPDI para importar páginas del PDF
            $pdf = new \setasign\Fpdi\TcpdfFpdi();
            $pageCount = $pdf->setSourceFile($pdfPath);

            // Importar páginas del PDF original
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }

            // Establecer la firma digital en el PDF
            $pdf->setSignature(
                $certificate,        // Certificado público
                $privateKey,         // Clave privada
                $password,           // Contraseña del certificado
                '',                  // Información adicional (vacío por defecto)
                2,                   // Método de hash (2 para SHA-256)
                [
                    'Name' => 'Alex Alba',
                    'Location' => 'Otavalo',
                    'Reason' => $reason,
                    'ContactInfo' => 'tu@email.com',
                ]
            );

            // Agregar firma visible al PDF
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->SetXY(10, 10); // Coordenadas de la firma visible
            $pdf->Write(10, "Firmada: $reason");

            // Generar un nombre único para el PDF firmado
            $signedPdfName = 'signed_' . uniqid() . '.pdf';
            $signedPdfPath = storage_path($pathProcess . '/signed_pdfs/' . $signedPdfName);

            // Guardar el archivo firmado en el almacenamiento
            $pdf->Output($signedPdfPath, 'F');

            // Configurar respuesta exitosa
            $result['success'] = true;
            $result['data'] = [
                'signed_pdf_path' => $signedPdfPath,
                'signed_pdf_url' => url('storage/signed_pdfs/' . $signedPdfName),
            ];
        } catch (\Exception $e) {
            // Manejo de errores
            $result['errors'] = [$e->getMessage()];
            return response()->json($result, 500);
        }

        return response()->json($result);
    }

    public function managementElectronicReceiptsGenerateInformation()
    {

        return view('sri.managementElectronicReceiptsGenerateInformation');
    }
    public function sendDataView(Request  $request)
    {
        return response()->json([
            'mensaje' => 'Datos recibidos correctamente',
            'recibido' => $request->all()
        ]);
    }

    public function kineticDisc()
    {

        return view('wow.kineticDisc');
    }

    public function generateRetentionsHtmlTable(array $retencionFiles): string
    {
        $html = '<div class="container px-2"><h2 class="mb-4 text-primary">🧾 Tabla de Retenciones</h2>';

        foreach ($retencionFiles as $item) {
            $xml = simplexml_load_file($item["source"]);
            $innerXml = simplexml_load_string($xml->comprobante);
            $filenameCurrent = $item["name"];

            $infoTributaria = $innerXml->infoTributaria;
            $razonSocial = (string)($infoTributaria->razonSocial ?? '');
            $nombreComercial = (string)($infoTributaria->nombreComercial ?? '');

            $html .= "<div class='mb-4'>";
            $html .= "<h5 class='fw-bold text-secondary'>📄 Documento: <span class='text-dark'>$filenameCurrent</span></h5>";
            $html .= "<p class='mb-2'>Empresa: <span class='fw-bold text-success'>$razonSocial</span> <br> Comercial: <span class='text-muted'>$nombreComercial</span></p>";

            $html .= '<div class="c-table-wrapper">';
            $html .= '<table class="table table-bordered table-hover table-striped table-sm c-table">';
            $html .= '<thead ><tr>
            <th>Código</th>
            <th>Nombre Comercial</th>
            <th>Código Retención</th>
            <th>Base Imponible</th>
            <th>% Retener</th>
            <th>Valor Retenido</th>
            <th>Doc. Sustento</th>
            <th>Fecha Doc.</th>
        </tr></thead><tbody>';

            $impuestos = $innerXml->impuestos->impuesto ?? [];

            foreach ($impuestos as $imp) {
                $codigo = (string)$imp->codigo;
                $codigoRetencion = (string)$imp->codigoRetencion;
                $baseImponible = (float)$imp->baseImponible;
                $porcentajeRetener = (float)$imp->porcentajeRetener;
                $valorRetenido = (float)$imp->valorRetenido;
                $numDocSustento = (string)$imp->numDocSustento;
                $fechaDoc = (string)$imp->fechaEmisionDocSustento;

                $html .= "<tr>
                <td><span class='badge bg-secondary'>$codigo</span></td>
                <td><span class='text-dark'>$razonSocial</span></td>
                <td><span class='badge bg-warning text-dark'>$codigoRetencion</span></td>
                <td><span class='badge bg-light text-dark'>\$" . number_format($baseImponible, 2) . "</span></td>
                <td><span class='badge bg-info text-dark'>" . number_format($porcentajeRetener, 2) . "%</span></td>
                <td><span class='badge bg-success'>\$" . number_format($valorRetenido, 2) . "</span></td>
                <td><code>$numDocSustento</code></td>
                <td><span class='text-muted'>$fechaDoc</span></td>
            </tr>";
            }

            $html .= '</tbody></table></div></div>';
        }

        $html .= '</div>';
        return $html;
    }
    public function generateRetentionsSummaryHtmlTable(array $retencionFiles): string
    {
        $html = '<div class="container px-2">';
        $groupedByPercent = [];

        foreach ($retencionFiles as $item) {
            $xml = simplexml_load_file($item["source"]);
            $innerXml = simplexml_load_string($xml->comprobante);
            $infoTributaria = $innerXml->infoTributaria ?? null;

            $razonSocial = (string)($infoTributaria->razonSocial ?? 'No definido');
            $nombreComercial = (string)($infoTributaria->nombreComercial ?? 'No definido');

            $impuestos = $innerXml->impuestos->impuesto ?? [];

            foreach ($impuestos as $imp) {
                $porcentajeRetener = (float)($imp->porcentajeRetener ?? 0);
                $valorRetenido = (float)($imp->valorRetenido ?? 0);

                if (!isset($groupedByPercent[$porcentajeRetener])) {
                    $groupedByPercent[$porcentajeRetener] = 0;
                }

                $groupedByPercent[$porcentajeRetener] += $valorRetenido;
            }
        }

        // Título principal
        $html .= '<h3 class="mt-4 text-primary">📊 Resumen agrupado por % de Retención</h3>';

        // Tabla Bootstrap
        $html .= '<div class="c-table-wrapper">';
        $html .= '<table class="table table-bordered table-hover table-striped table-sm c-table">';
        $html .= '<thead >
        <tr>
            <th scope="col">% Retención</th>
            <th scope="col">Total Valor Retenido</th>
        </tr>
    </thead><tbody>';
        $type=100;
        foreach ($groupedByPercent as $percent => $total) {
            $message="";
            if($type==$percent){
                $message="(Seccion 421-609     copiar <--617)";
            }
            $badgeColor = $percent >= 50 ? 'danger' : ($percent >= 10 ? 'warning text-dark' : 'info');
            $html .= "<tr>
            <td><span class='badge bg-{$badgeColor}'>" . number_format($percent, 2) . "%  $message</span></td>
            <td><span class='fw-semibold text-success'>\$" . number_format($total, 2) . "</span></td>
        </tr>";
        }

        $html .= '</tbody></table></div></div>';
        return $html;
    }

    public function generateFacturaPreviewHtmlTable(array $file): string
    {
        $html = '<div class="container px-2">';
        $path = $file["source"];
        $filename = $file["name"];

        if (!file_exists($path)) {
            return "<h4 class='text-danger'>❌ Archivo no encontrado: <code>{$filename}</code></h4>";
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $headerOriginal = str_getcsv(array_shift($lines), "\t");

        $ordenColumnas = [
            'RUC_EMISOR', 'RAZON_SOCIAL_EMISOR', 'TIPO_COMPROBANTE',
            'IDENTIFICACION_RECEPTOR', 'VALOR_SIN_IMPUESTOS', 'IVA',
            'IMPORTE_TOTAL', 'SERIE_COMPROBANTE', 'CLAVE_ACCESO',
            'FECHA_AUTORIZACION', 'FECHA_EMISION', 'NUMERO_DOCUMENTO_MODIFICADO'
        ];

        $indices = [];
        foreach ($ordenColumnas as $col) {
            $indices[$col] = array_search($col, $headerOriginal);
        }

        $sumSinIVA_total = 0;
        $sumConIVA_total = 0;
        $sumSinIVA_valor = 0;
        $sumConIVA_valor = 0;

        $html .= "<h4 class='text-primary mb-3'>📄 Archivo: <code>{$filename}</code></h4>";
        $html .= '<div class="c-table-wrapper">';
        $html .= '<table class="table table-bordered table-hover table-striped table-sm">';
        $html .= '<thead ><tr>';
        foreach ($ordenColumnas as $col) {
            $html .= "<th class='text-nowrap'>{$col}</th>";
        }
        $html .= "</tr></thead><tbody>";

        foreach ($lines as $line) {
            $fields = str_getcsv($line, "\t");
            $identificacion = trim($fields[$indices['IDENTIFICACION_RECEPTOR']]);
            $valor = (float)str_replace(',', '.', trim($fields[$indices['VALOR_SIN_IMPUESTOS']]));
            $iva = (float)str_replace(',', '.', trim($fields[$indices['IVA']]));
            $total = (float)str_replace(',', '.', trim($fields[$indices['IMPORTE_TOTAL']]));

            if (preg_match('/^\d{13}$/', $identificacion)) {
                $badgeTipo = "<span class='badge bg-success ms-1'>RUC 🏢</span>";
            } elseif (preg_match('/^\d{10}$/', $identificacion)) {
                $badgeTipo = "<span class='badge bg-primary ms-1'>Cédula 🎫</span>";
            } else {
                $badgeTipo = "<span class='badge bg-secondary ms-1'>Otro</span>";
            }

            $badgeColor = $iva == 0 ? "bg-secondary" : "bg-warning text-dark";
            $badgeImpuesto = "<span class='badge {$badgeColor} ms-1'>" . ($iva == 0 ? "Sin Impuestos" : "Con IVA") . "</span>";

            if (preg_match('/^\d{13}$/', $identificacion)) {
                if ($iva == 0) {
                    $sumSinIVA_total += $iva;
                    $sumSinIVA_valor += $valor;
                } else {
                    $sumConIVA_total += $iva;
                    $sumConIVA_valor += $valor;
                }
            }

            $html .= "<tr>";
            foreach ($ordenColumnas as $col) {
                $key = $indices[$col];
                $contenido = $fields[$key] ?? '';

                if ($col === 'IDENTIFICACION_RECEPTOR') {
                    $html .= "<td class='text-nowrap'>{$contenido} {$badgeTipo}</td>";
                } elseif (in_array($col, ['VALOR_SIN_IMPUESTOS', 'IVA'])) {
                    $html .= "<td class='text-nowrap'>" . number_format((float)$contenido, 2, '.', '') . " {$badgeImpuesto}</td>";
                } elseif ($col === 'IMPORTE_TOTAL') {
                    $html .= "<td class='text-nowrap'>" . number_format((float)$contenido, 2, '.', '') . "</td>";
                } else {
                    $html .= "<td class='text-nowrap'>{$contenido}</td>";
                }
            }
            $html .= "</tr>";
        }

        $html .= '</tbody></table></div><br>';

        $classCurrent = "table-success";
        $valuePercentageTaxCurrent = 0.15;
        $valuePercentageTax = $sumConIVA_valor * $valuePercentageTaxCurrent;
        $valueCero = 0;
        $valueTax = 0;
        $valueTaxPercentaje = $sumConIVA_total;

        if ($sumConIVA_total == $valuePercentageTax) {
            $classCurrent = "table-success";
        } elseif ($valuePercentageTax > $sumConIVA_total) {
            $classCurrent = "table-warning";
            $resultStepOne = $valueTaxPercentaje / $valuePercentageTaxCurrent;
            $resultStepTwo = $sumConIVA_valor - $resultStepOne;
            $valueCero = $sumSinIVA_valor + $resultStepTwo;
            $valueTax = $resultStepOne;
        } elseif ($valuePercentageTax < $sumConIVA_total) {
            $classCurrent = "table-danger";
        }

        $html .= "<h5 class='text-secondary mt-4'>📊 Resumen del archivo</h5>";
        $html .= '<div class="c-table-wrapper">';
        $html .= '    <table class="table table-bordered table-hover table-striped table-sm c-table" >';
        $html .= '     <thead ><tr><th class="text-nowrap">🗂 Categoría</th><th class="text-end">💰 Total</th></tr></thead>';
        $html .= '      <tbody>';
        $html .= "       <tr><td>SIN IVA <span class='badge bg-success ms-1'>RUC 🏢</span></td><td class='text-end'><span class='badge bg-secondary'>$" . number_format($sumSinIVA_total, 2, '.', '') . "</span></td></tr>";
        $html .= "       <tr><td>CON IVA<span class='badge bg-success ms-1'>RUC 🏢</span></td><td class='text-end'><span class='badge bg-warning text-dark'>$" . number_format($sumConIVA_total, 2, '.', '') . "</span></td></tr>";
        $html .= "       <tr><td>VALOR SIN IMPUESTOS - SIN IVA</td><td class='text-end text-muted'>$" . number_format($sumSinIVA_valor, 2, '.', '') . "</td></tr>";
        $html .= "       <tr><td>VALOR SIN IMPUESTOS - CON IVA</td><td class='text-end text-muted'>$" . number_format($sumConIVA_valor, 2, '.', '') . "</td></tr>";
        $html .= "       <tr class='{$classCurrent}'><td><strong>VALOR CON IVA * 0.15</strong></td><td class='text-end fw-bold'>$" . number_format($valuePercentageTax, 2, '.', '') . "</td></tr>";
        $html .= "       <tr><td>TARIFA 0% <small class='text-muted'>(Sección 507-517)</small></td><td class='text-end'>$" . number_format($valueCero, 2, '.', '') . "</td></tr>";
        $html .= "       <tr><td>TARIFA IVA <small class='text-muted'>(Sección 500-510)</small></td><td class='text-end'>$" . number_format($valueTax, 2, '.', '') . "</td></tr>";
        $html .= "       <tr class='{$classCurrent}'><td><strong>IVA</strong> <small class='text-muted'>(Sección 520-(564))</small></td><td class='text-end fw-semibold'>\$" . number_format($valueTaxPercentaje, 2, '.', '') . "</td></tr>";
        $html .= '    </tbody>';
        $html .= '    </table>';
        $html .= '</div>';

        return $html;
    }

    public function generatePreviewUpload($params)
    {


        $files = $params["files"];

        $htmlTables = [];

        foreach ($files as $type => $file) {
            $html = "";
            if ($type == "facturas") {
               $htmlFacturaPreview=$this-> generateFacturaPreviewHtmlTable($file);
                $html.=$htmlFacturaPreview;
            } else {
                $html .= "<h2>Tabla: Retenciones</h2>";
                $tablesRetenciones = $this->generateRetentionsHtmlTable($file);
                $html .=$tablesRetenciones;
                $groupedByPercent = [];
                foreach ($file as $item) {
                    $xml = simplexml_load_file($item["source"]);
                    $innerXml = simplexml_load_string($xml->comprobante);
                    $filenameCurrent = ($item["name"]);
                   $infoTributaria= $innerXml->children()->infoTributaria;
                   $razonSocial=(string)$infoTributaria->razonSocial;
                    $nombreComercial=(string)$infoTributaria->nombreComercial;
                    $impuestos = $innerXml->impuestos->impuesto ?? [];
                    foreach ($impuestos as $imp) {
                        $codigo = (string)$imp->codigo;
                        $codigoRetencion = (string)$imp->codigoRetencion;
                        $baseImponible = (float)$imp->baseImponible;
                        $porcentajeRetener = (float)$imp->porcentajeRetener;
                        $valorRetenido = (float)$imp->valorRetenido;
                        $numDocSustento = (string)$imp->numDocSustento;
                        $fechaDoc = (string)$imp->fechaEmisionDocSustento;

                        if (!isset($groupedByPercent[$porcentajeRetener])) {
                            $groupedByPercent[$porcentajeRetener] = 0;
                        }
                        $groupedByPercent[$porcentajeRetener] += $valorRetenido;
                    }
                }

                $tablesRetencionesSummary=$this->generateRetentionsSummaryHtmlTable( $file);
                $html .=$tablesRetencionesSummary;

            }


            $htmlTables[] = $html;
        }

        return $htmlTables;
    }

    public function generateInformationElectronic(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'facturas' => 'required|file|mimes:txt|max:10240',
                'retenciones' => 'required|array|min:1',
                'retenciones.*' => 'file|mimes:xml|max:10240', // cada archivo debe ser XML
            ]);
            $htmlTablesPreview = "";
            if ($validator->fails()) {
                $errores = $validator->errors()->toArray();

                $mensajes = [];
                foreach ($errores as $campo => $mensajesCampo) {
                    // Tomar solo el primer error por campo
                    $nombreArchivo = $campo === 'facturas' ? 'Archivo de facturas' : 'Archivo de retenciones';
                    $mensajes[] = "{$nombreArchivo}: {$mensajesCampo[0]}";
                }

                return response()->json([
                    'success' => false,
                    'message' => implode(' | ', $mensajes), // mensaje unificado
                    'errors' => $errores
                ], 422);
            } else {
                $rootSources = "public/documents-manager/sri";
                $retencionPaths = [];
                $rootSourceCurrent="app";
                $basePath = storage_path($rootSourceCurrent."/");
                $facturaPath = $request->file('facturas')->store($rootSources . '/facturas');


                // Guardar múltiples XML de retenciones

                foreach ($request->file('retenciones') as $retencionFile) {
                    $path = $retencionFile->store($rootSources . '/retenciones');
                    $retencionPaths[] = [
                        "source" => storage_path($rootSourceCurrent."/" . $path),
                        "name" => $retencionFile->getClientOriginalName(),
                    ];
                }

                $retencionPath=$retencionPaths;
                $files = [
                    'facturas' => ["source" => $basePath . $facturaPath, "name" => "Facturas"],
                    'retenciones' => $retencionPaths,
                ];

                $htmlTablesPreview = $this->generatePreviewUpload(["files" => $files]);
            }

            $htmlTables[] = mb_convert_encoding($htmlTablesPreview, 'UTF-8', 'auto');
            return response()->json([
                'success' => true,
                'message' => 'Documentos recibidos correctamente',
                "data" => [
                    'paths' => [
                        'factura' => $facturaPath,
                        'retencion' => $retencionPath,

                    ],
                    "html" => $htmlTables
                ]

            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar documentos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateElectronicReceiptsGenerateInformation()
    {
        try {
            $basePath = storage_path("app/public/documents-manager/sri/abril-2025");
            $basePathInit = storage_path("app/");

            $files = [
                'facturas' => '1002954889001_Recibidos-facturas-abril.txt',
                'retenciones' => '1002954889001_Recibidos-retenciones-abril.txt'
            ];

            $htmlTablesPreview = $this->generatePreview(["basePath" => $basePath, "files" => $files]);
            $htmlCurrentTablesPreview = implode("\n", $htmlTablesPreview);

            $htmlCurrent = $htmlCurrentTablesPreview;


            $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>Facturas y Retenciones</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                tr.equals-values-mayor {
    background: #c4760d;
}
            </style>
        </head>
        <body>
            " . $htmlCurrent . "
        </body>
        </html>";

            return response($htmlContent)->header('Content-Type', 'text/html');

        } catch (\Exception $e) {
            return response("<h2 style='color:red;'>Error: {$e->getMessage()}</h2>", 500)
                ->header('Content-Type', 'text/html');
        }
    }


    public function getCompanyTrafficSourcesReport($params): array
    {
        $results = [];
        $trackingData = $params["allData"];
        foreach ($trackingData as $record) {
            $companyName = $record->companyName ?? 'Unknown';
            $sourceCode = $record->tbs_code ?? 'unknown';

            $key = $companyName . '|' . $sourceCode;

            if (!isset($results[$key])) {
                $results[$key] = [
                    'companyName' => $companyName,
                    'sourceCode' => $sourceCode,
                    'totalVisits' => 0
                ];
            }

            $results[$key]['totalVisits'] += 1;
        }

        // Reindexar para Highcharts o frontend
        return array_values($results);
    }

//TODO UPLOAD
    public function getDataInteraction(Request $request)
    {

        $startDate = $request->input('start_date', now()->subMonth()->toDateString()) . " 00:00:00";
        $endDate = $request->input('end_date', now()->toDateString()) . " 23:59:59";
        // $dataCompanyInteractionsByLocation = $this->getCompanyInteractionsByLocation($startDate, $endDate);
        // $dataCompanyTrafficSources = $this->getCompanyTrafficSources($startDate, $endDate);
        // $dataDailyInteractionsByCompanyType = $this->getDailyInteractionsByCompanyType($startDate, $endDate);
        // $dataUserParticipationByCompany = $this->getUserParticipationByCompany($startDate, $endDate);
        //   $dataClickTypesByCompany = $this->getClickTypesByCompany($startDate, $endDate);

        $dataAllTracking = $this->getDataAllTracking([
            "startDate" => $startDate,
            "endDate" => $endDate,
        ]);
        $dataCompanyInteractionsByLocation = $this->getReportCompanyLocationInteractions(["allData" => $dataAllTracking]);
        $dataCompanyTrafficSources = $this->getCompanyTrafficSourcesReport(["allData" => $dataAllTracking]);
        $dataDailyInteractionsByCompanyType = $this->getDailyInteractionsByCompanyTypeReport(["allData" => $dataAllTracking]);
        $dataUserParticipationByCompany = $this->getUserParticipationByCompanyReport(["allData" => $dataAllTracking]);
        $dataClickTypesByCompany = $this->getClickTypesByCompanyReport(["allData" => $dataAllTracking]);
        $dataSourcesClickTypesPerDay = $this->getDailySourcesAndClickTypesByCompanyReport(["allData" => $dataAllTracking]);

        $result = [
            "dataCompanyInteractionsByLocation" => $dataCompanyInteractionsByLocation,
            "dataCompanyTrafficSources" => $dataCompanyTrafficSources,
            "dataDailyInteractionsByCompanyType" => $dataDailyInteractionsByCompanyType,
            "dataUserParticipationByCompany" => $dataUserParticipationByCompany,
            "dataClickTypesByCompany" => $dataClickTypesByCompany,
            "dataAllTracking" => $dataAllTracking,
            "dataSourcesClickTypesPerDay" => $dataSourcesClickTypesPerDay,

        ];
        return response()->json(
            $result
        );
    }

    public function getDailySourcesAndClickTypesByCompanyReport($params): array
    {
        $results = [];
        $trackingData = $params["allData"];

        foreach ($trackingData as $record) {
            $companyName = $record->companyName ?? 'Unknown';
            $sourceCode = $record->tbs_code ?? 'Unknown';
            $clickType = $record->tct_code ?? 'Unknown';
            $date = substr($record->created_at, 0, 10); // Formato YYYY-MM-DD

            $key = "{$companyName}|{$sourceCode}|{$clickType}|{$date}";

            if (!isset($results[$key])) {
                $results[$key] = [
                    'date' => $date,
                    'companyName' => $companyName,
                    'sourceCode' => $sourceCode,
                    'clickTypeCode' => $clickType,
                    'totalInteractions' => 0
                ];
            }

            $results[$key]['totalInteractions'] += 1;
        }

        return array_values($results);
    }

    public function getClickTypesByCompanyReport($params): array
    {
        $results = [];
        $trackingData = $params["allData"];

        foreach ($trackingData as $record) {
            $companyName = $record->companyName ?? 'Unknown';
            $clickType = $record->tct_code ?? 'Unknown';

            $key = $companyName . '|' . $clickType;

            if (!isset($results[$key])) {
                $results[$key] = [
                    'companyName' => $companyName,
                    'clickType' => $clickType,
                    'totalClicks' => 0
                ];
            }

            $results[$key]['totalClicks'] += 1;
        }

        return array_values($results);
    }

    public function getUserParticipationByCompanyReport($params): array
    {
        $results = [];
        $trackingData = $params["allData"];

        foreach ($trackingData as $record) {
            $companyName = $record->companyName ?? 'Unknown';
            $userType = (is_null($record->user_id) || $record->is_guest) ? 'Anonymous' : 'Registered';

            $key = $companyName . '|' . $userType;

            if (!isset($results[$key])) {
                $results[$key] = [
                    'companyName' => $companyName,
                    'userType' => $userType,
                    'totalSessions' => 0
                ];
            }

            $results[$key]['totalSessions'] += 1;
        }

        return array_values($results);
    }

    public function getDailyInteractionsByCompanyTypeReport($params): array
    {
        $results = [];
        $trackingData = $params["allData"];
        foreach ($trackingData as $record) {
            // Asegura formato correcto de fecha (día-mes-año)
            $date = date('Y-m-d', strtotime($record->created_at ?? 'now'));

            // Clasificación de tipo de empresa
            $companyType = (isset($record->companyName) && stripos($record->companyName, 'Meetclic') !== false)
                ? 'Meetclic'
                : 'External';

            $key = $date . '|' . $companyType;

            if (!isset($results[$key])) {
                $results[$key] = [
                    'date' => $date,
                    'companyType' => $companyType,
                    'totalInteractions' => 0
                ];
            }

            $results[$key]['totalInteractions'] += 1;
        }

        // Reindexar para enviar al frontend
        return array_values($results);
    }

    public function getReportTrafficSourcesByCompany($params)
    {
        $allData = $params["allData"];


        $grouped = [];

        foreach ($allData as $item) {
            $company = $item->companyName;
            $sourceCode = $item->tbs_code ?? 'unknown';

            $key = "{$company}|{$sourceCode}";

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'companyName' => $company,
                    'sourceCode' => $sourceCode,
                    'totalVisits' => 0,
                ];
            }

            $grouped[$key]['totalVisits']++;
        }

        return array_values($grouped);
    }

    public function getDataAllTracking($params)
    {
        $startDate = $params["startDate"];
        $endDate = $params["endDate"];
        $business_id = isset($params["business_id"]) ? $params["business_id"] : null;

        $selectString = "ts.id ts_id,ts.token,ts.user_id,ts.business_id,ts.is_guest ,ts.source_id,ts.referer_url,ts.campaign_code,ts.device_agent,ts.ip_address,ts.country,ts.region,ts.city,ts.latitude,ts.longitude,ts.created_at,DATE_FORMAT(ts.created_at, '%d/%m/%Y %H:%i:%s') as createdAtFormatted";
        $selectString .= ",te.click_type_id ,te.action_name,te.manager_click_type,te.url,te.section";
        $selectString .= ",b.title as companyName,b.business_subcategories_id";
        $selectString .= ",tct.uid tct_uid,tct.code tct_code";
        $selectString .= ",tbs.uid tbs_uid,tbs.code tbs_code";
        $select = DB::raw($selectString);
        $query = DB::table('tracking_sessions as ts')
            ->join('tracking_events as te', 'ts.id', '=', 'te.session_id')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->join('business_subcategories as bs', 'b.business_subcategories_id', '=', 'bs.id')
            ->join('tracking_sources as tbs', 'ts.source_id', '=', 'tbs.id')
            ->join('tracking_click_types as tct', 'te.click_type_id', '=', 'tct.id')
            ->select(
                $select
            )
            ->whereBetween('te.created_at', [$startDate, $endDate]);
        if ($business_id !== null) {
            $query->where('ts.business_id', '=', $business_id);

        }
        return $query->get()
            ->toArray();
    }

    public function getReportCompanyLocationInteractions($params)
    {
        $allData = $params["allData"];

        $grouped = [];

        foreach ($allData as $item) {
            $company = $item->companyName;
            $country = $item->country ?? 'Anonymous';
            $city = $item->city ?? 'Anonymous';

            $key = "{$company}|{$country}|{$city}";

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'companyName' => $company,
                    'country' => $country,
                    'city' => $city,
                    'totalInteractions' => 0,
                ];
            }

            $grouped[$key]['totalInteractions']++;
        }

        return array_values($grouped);
    }

    public function getCompanyInteractionsByLocation($startDate, $endDate)
    {
        return DB::table('tracking_sessions as ts')
            ->join('tracking_events as te', 'ts.id', '=', 'te.session_id')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->select(
                'b.title as companyName',
                DB::raw("IFNULL(ts.country, 'Anonymous') as country"),
                DB::raw("IFNULL(ts.city, 'Anonymous') as city"),
                DB::raw('COUNT(te.id) as totalInteractions')
            )
            ->where('te.section', 'businessDetails')
            ->whereBetween('te.created_at', [$startDate, $endDate])
            ->groupBy('companyName', 'country', 'city')
            ->orderByDesc('totalInteractions')
            ->get()
            ->toArray();
    }

    public function getCompanyTrafficSources($startDate, $endDate)
    {
        return DB::table('tracking_sessions as ts')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->join('tracking_sources as src', 'ts.source_id', '=', 'src.id')
            ->select(
                'b.title as companyName',
                'src.code as sourceCode',
                DB::raw('COUNT(ts.id) as totalVisits')
            )
            ->whereBetween('ts.created_at', [$startDate, $endDate])
            ->groupBy('b.title', 'src.code')
            ->orderBy('b.title')
            ->get()
            ->toArray();
    }

    public function getDailyInteractionsByCompanyType($startDate, $endDate)
    {
        return DB::table('tracking_events as te')
            ->join('tracking_sessions as ts', 'te.session_id', '=', 'ts.id')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->select(
                DB::raw('DATE(te.created_at) as date'),
                DB::raw("CASE
                        WHEN b.title LIKE '%Meetclic%' THEN 'Meetclic'
                        ELSE 'External'
                     END as companyType"),
                DB::raw('COUNT(te.id) as totalInteractions')
            )
            ->whereBetween('te.created_at', [$startDate, $endDate])
            ->groupBy('date', 'companyType')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    public function getUserParticipationByCompany($startDate, $endDate)
    {
        return DB::table('tracking_sessions as ts')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->select(
                'b.title as companyName',
                DB::raw("CASE
                        WHEN ts.user_id IS NULL THEN 'Anonymous'
                        ELSE 'Registered'
                     END as userType"),
                DB::raw('COUNT(ts.id) as totalSessions')
            )
            ->whereBetween('ts.created_at', [$startDate, $endDate])
            ->groupBy('b.title', 'userType')
            ->orderBy('b.title')
            ->get()
            ->toArray();
    }

    public function getClickTypesByCompany($startDate, $endDate)
    {
        return DB::table('tracking_events as te')
            ->join('tracking_sessions as ts', 'te.session_id', '=', 'ts.id')
            ->join('business as b', 'ts.business_id', '=', 'b.id')
            ->join('tracking_click_types as ct', 'te.click_type_id', '=', 'ct.id')
            ->select(
                'b.title as companyName',
                'ct.code as clickType',
                DB::raw('COUNT(te.id) as totalClicks')
            )
            ->whereBetween('te.created_at', [$startDate, $endDate])
            ->groupBy('b.title', 'ct.code')
            ->orderBy('b.title')
            ->get()
            ->toArray();
    }

}
