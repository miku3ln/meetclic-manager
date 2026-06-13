<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class FacturaSriDetalleLog extends ModelManager
{
    protected $table = 'factura_sri_detalles_logs';

    protected $fillable = [
        'factura_id',
        'clave_acceso_intento',
        'numero_autorizacion_obtenido',
        'step_error',
        'estado_respuesta',
        'identificador_sri',
        'mensaje_sri',
        'informacion_adicional'
    ];

    protected $attributesData = [
        ['column' => 'factura_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'clave_acceso_intento', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'numero_autorizacion_obtenido', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'step_error', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'estado_respuesta', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'identificador_sri', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'mensaje_sri', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'informacion_adicional', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'clave_acceso_intento';

    public static function getRulesModel()
    {
        return [
            "factura_id" => "required|integer",
            "clave_acceso_intento" => "required|size:49",
            "numero_autorizacion_obtenido" => "nullable|max:49",
            "step_error" => "required|max:50",
            "estado_respuesta" => "required|max:20",
            "identificador_sri" => "nullable|max:10",
            "mensaje_sri" => "required"
        ];
    }

    // Registrar un nuevo log rápido de respuesta del SRI de manera directa
    public static function registrarLog($dataLog)
    {
        return DB::table('factura_sri_detalles_logs')->insert($dataLog);
    }
}
