<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class FacturaSriCabecera extends ModelManager
{
    protected $table = 'factura_sri_cabecera';

    // Constantes de estados de procesamiento del SRI
    const ESTADO_PENDIENTE = 'PENDIENTE';
    const ESTADO_AUTORIZADO = 'AUTORIZADO';
    const ESTADO_DEVUELTA = 'DEVUELTA';
    const ESTADO_RECHAZADO = 'RECHAZADO';
    const ESTADO_FALLO_SISTEMA = 'FALLO_SISTEMA';

    protected $fillable = [
        'factura_id',
        'clave_acceso',
        'numero_autorizacion',
        'fecha_autorizacion',
        'estado_actual',
        'total_intentos',
        'ultimo_intento_at'
    ];

    protected $attributesData = [
        ['column' => 'factura_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'clave_acceso', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'numero_autorizacion', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'fecha_autorizacion', 'type' => 'datetime', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'estado_actual', 'type' => 'string', 'defaultValue' => 'PENDIENTE', 'required' => 'false'],
        ['column' => 'total_intentos', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'ultimo_intento_at', 'type' => 'datetime', 'defaultValue' => null, 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'clave_acceso';

    public static function getRulesModel()
    {
        return [
            "factura_id" => "required|integer",
            "clave_acceso" => "required|size:49",
            "numero_autorizacion" => "nullable|max:49",
            "fecha_autorizacion" => "nullable|date_format:Y-m-d H:i:s",
            "estado_actual" => "required|max:30",
            "total_intentos" => "nullable|integer"
        ];
    }

    // Buscar cabecera de rastreo por el ID de la factura de venta local
    public static function getByFacturaId($facturaId)
    {
        return DB::table('factura_sri_cabecera')->where('factura_id', $facturaId)->first();
    }
    public static function obtenerConsolidadoSriPorFactura($facturaId)
    {
        // 1. Obtener la cabecera única del SRI
        $cabecera = DB::table('factura_sri_cabecera')
            ->where('factura_id', $facturaId)
            ->first();

        if (!$cabecera) {
            return [
                'success' => false,
                'message' => 'No existen registros de procesamiento en el SRI para la factura especificada.'
            ];
        }

        // 2. Obtener el historial cronológico de logs/intentos
        $logs = DB::table('factura_sri_detalles_logs')
            ->where('factura_id', $facturaId)
            ->orderBy('intentado_at', 'desc')
            ->get()
            ->toArray();

        // 3. Obtener los paths de los documentos físicos
        $documentos = DB::table('factura_sri_documentos')
            ->where('factura_sri_cabecera_id', $cabecera->id)
            ->first();

        // 🔗 GENERACIÓN DE URLs PÚBLICAS PARA EL USUARIO
        // Si usas rutas controladas por un endpoint en tu api o web, es la mejor práctica para el SRI
        $clave = $cabecera->clave_acceso;
        $urlsDescarga = null;

        if ($documentos) {
            $urlsDescarga = [
                // Rutas internas del servidor (Útiles para tu backend)
                "path_xml_generado"   => $documentos->path_xml_generado,
                "path_xml_firmado"    => $documentos->path_xml_firmado,
                "path_xml_autorizado" => $documentos->path_xml_autorizado,
                "path_pdf_ride"       => $documentos->path_pdf_ride,

                // 🌐 URLs dinámicas listas para que el usuario les dé clic en el navegador
                "url_xml_generado"   => $documentos->path_xml_generado ? ("https://invoice-sign.meetclic.com/api/v1/facturacion/xml/{$clave}?tipo=generado") : null,
                "url_xml_firmado"    => $documentos->path_xml_firmado ? ("https://invoice-sign.meetclic.com/api/v1/facturacion/xml/{$clave}?tipo=firmado") : null,
                "url_xml_autorizado" => $documentos->path_xml_autorizado ? ("https://invoice-sign.meetclic.com/api/v1/facturacion/xml/{$clave}?tipo=autorizado") : null,
                "url_pdf_ride"       => $documentos->path_pdf_ride ? ("https://invoice-sign.meetclic.com/api/v1/facturacion/ride/{$clave}") : null,
            ];
        }

        // 4. Armar la respuesta estructurada final
        return [
            'success' => true,
            'data' => [
                // --- POSICIÓN 1: CABECERA ---
                "cabecera" => [
                    "factura_id"          => $cabecera->factura_id,
                    "clave_acceso"        => $cabecera->clave_acceso,
                    "numero_autorizacion" => $cabecera->numero_autorizacion,
                    "fecha_autorizacion"  => $cabecera->fecha_autorizacion,
                    "estado_actual"       => $cabecera->estado_actual,
                    "total_intentos"      => $cabecera->total_intentos,
                    "ultimo_intento_at"   => $cabecera->ultimo_intento_at,
                    "documentos"          => $urlsDescarga // Documentos y links inyectados aquí
                ],

                // --- POSICIÓN 2: LOG ANIDADO ---
                "historial_logs" => array_map(function($log) {
                    return [
                        "log_id"                       => $log->id,
                        "clave_acceso_intento"         => $log->clave_acceso_intento,
                        "numero_autorizacion_obtenido" => $log->numero_autorizacion_obtenido,
                        "step_error"                   => $log->step_error,
                        "estado_respuesta"             => $log->estado_respuesta,
                        "identificador_sri"            => $log->identificador_sri,
                        "mensaje_sri"                  => $log->mensaje_sri,
                        "informacion_adicional"        => $log->informacion_adicional,
                        "intentado_at"                 => $log->intentado_at,
                    ];
                }, $logs)
            ]
        ];
    }
}
