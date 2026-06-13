<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class FacturaSriDocumento extends ModelManager
{
    protected $table = 'factura_sri_documentos';

    protected $fillable = [
        'factura_sri_cabecera_id',
        'path_xml_generado',
        'path_xml_firmado',
        'path_xml_autorizado',
        'path_pdf_ride'
    ];

    protected $attributesData = [
        ['column' => 'factura_sri_cabecera_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'path_xml_generado', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'path_xml_firmado', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'path_xml_autorizado', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'path_pdf_ride', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'factura_sri_cabecera_id';

    public static function getRulesModel()
    {
        return [
            "factura_sri_cabecera_id" => "required|integer",
            "path_xml_generado" => "nullable|max:255",
            "path_xml_firmado" => "nullable|max:255",
            "path_xml_autorizado" => "nullable|max:255",
            "path_pdf_ride" => "nullable|max:255"
        ];
    }
}
