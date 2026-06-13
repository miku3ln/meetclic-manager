<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class Emisor extends ModelManager
{
    protected $table = 'emisores';

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'dir_matriz',
        'obligado_contabilidad',
        'es_rimpe',
        'es_negocio_popular',
        'es_contribuyente_especial',
        'es_agente_retencion',
        'path_logo',
        'path_certificado_p12',
        'clave_certificado_p12',
        'fecha_vigencia_firma',
        'propietario_certificado',
        'ambiente',
        'email_notificaciones',
        'telefono'
    ];

    protected $attributesData = [
        ['column' => 'ruc', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'razon_social', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'nombre_comercial', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'dir_matriz', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'obligado_contabilidad', 'type' => 'string', 'defaultValue' => 'NO', 'required' => 'false'],
        ['column' => 'es_rimpe', 'type' => 'boolean', 'defaultValue' => 'false', 'required' => 'false'],
        ['column' => 'es_negocio_popular', 'type' => 'boolean', 'defaultValue' => 'false', 'required' => 'false'],
        ['column' => 'es_contribuyente_especial', 'type' => 'boolean', 'defaultValue' => 'false', 'required' => 'false'],
        ['column' => 'es_agente_retencion', 'type' => 'boolean', 'defaultValue' => 'false', 'required' => 'false'],
        ['column' => 'path_logo', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'path_certificado_p12', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'clave_certificado_p12', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'fecha_vigencia_firma', 'type' => 'date', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'propietario_certificado', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'ambiente', 'type' => 'string', 'defaultValue' => '1', 'required' => 'false'],
        ['column' => 'email_notificaciones', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'telefono', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
    ];

    public $timestamps = false; // Gestionado por base de datos via DEFAULT CURRENT_TIMESTAMP

    protected $field_main = 'ruc';

    public static function getRulesModel()
    {
        return [
            "ruc" => "required|max:13",
            "razon_social" => "required|max:300",
            "nombre_comercial" => "nullable|max:150",
            "dir_matriz" => "required",
            "obligado_contabilidad" => "required|in:SI,NO",
            "es_rimpe" => "boolean",
            "es_negocio_popular" => "boolean",
            "es_contribuyente_especial" => "boolean",
            "es_agente_retencion" => "boolean",
            "path_logo" => "nullable|max:255",
            "path_certificado_p12" => "required|max:255",
            "clave_certificado_p12" => "required|max:255",
            "fecha_vigencia_firma" => "nullable|date",
            "propietario_certificado" => "nullable|max:255",
            "ambiente" => "required|in:1,2",
            "email_notificaciones" => "required|email|max:150",
            "telefono" => "nullable|max:20"
        ];
    }

    // Obtener los datos del emisor por su RUC
    public static function getByRuc($ruc)
    {
        return DB::table('emisores')->where('ruc', $ruc)->first();
    }
}
