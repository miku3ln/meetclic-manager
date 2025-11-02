<?php

namespace App\Utils\Meetclic;

use DOMDocument;
use DOMXPath;
class UtilApis
{
    public static function parseCedulaHtml(string $html): array
    {

        $fullname = "";

        $lastname = "";  // Primeros 2 palabras = Apellidos
        $name = "";
        $dni="";
        // Resto = Nombres
        if($html==''){

        }else{
            $document = new DOMDocument();
            libxml_use_internal_errors(true);

            $document->loadHTML($html);
            libxml_clear_errors();

            $xpath = new DOMXPath($document);

            // Extraer número de cédula (id="ci0")
            $dniNode = $xpath->query('//td[@id="ci0"]')->item(0);
            $dni = trim($dniNode ? $dniNode->nodeValue : '');

            // Extraer nombre completo (id="name0" -> <a> -> <strong>)
            $nameNode = $xpath->query('//td[@id="name0"]/a/strong')->item(0);
            $fullname = trim($nameNode ? $nameNode->nodeValue : '');

            // Dividir nombres y apellidos (Asumiendo formato: "Apellido1 Apellido2 Nombre1 Nombre2")
            $nameParts = preg_split('/\s+/', $fullname);

            $lastname = implode(' ', array_slice($nameParts, 0, 2));  // Primeros 2 palabras = Apellidos
            $name = implode(' ', array_slice($nameParts, 2));         // Resto = Nombres

        }

        return [
            'full_name' => $fullname,
            'last_name' => $lastname,
            'name'     => $name,
            'document'      => $dni
        ];
    }
}
