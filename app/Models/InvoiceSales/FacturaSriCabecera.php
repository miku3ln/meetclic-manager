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
}
