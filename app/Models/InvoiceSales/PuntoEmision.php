<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class PuntoEmision extends ModelManager
{
    protected $table = 'puntos_emision';

    protected $fillable = [
        'emisor_id',
        'establecimiento',
        'punto_emision',
        'factura_inicial',
        'nota_credito_inicial',
        'nota_debito_inicial',
        'comprobante_retencion_inicial',
        'liquidacion_compra_inicial',
        'guia_remision_inicial',
        'factura_actual',
        'nota_credito_actual',
        'nota_debito_actual',
        'comprobante_retencion_actual',
        'liquidacion_compra_actual',
        'guia_remision_actual',
        'informacion_adicional',
        'estado'
    ];

    protected $attributesData = [
        ['column' => 'emisor_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'establecimiento', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'punto_emision', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'factura_inicial', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'nota_credito_inicial', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'nota_debito_inicial', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'comprobante_retencion_inicial', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'liquidacion_compra_inicial', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'guia_remision_inicial', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'factura_actual', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'nota_credito_actual', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'nota_debito_actual', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'comprobante_retencion_actual', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'liquidacion_compra_actual', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'guia_remision_actual', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'informacion_adicional', 'type' => 'string', 'defaultValue' => null, 'required' => 'false'],
        ['column' => 'estado', 'type' => 'string', 'defaultValue' => 'ACTIVO', 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'punto_emision';

    public static function getRulesModel()
    {
        return [
            "emisor_id" => "required|integer",
            "establecimiento" => "required|size:3",
            "punto_emision" => "required|size:3",
            "factura_inicial" => "nullable|integer|min:0",
            "factura_actual" => "nullable|integer|min:0",
            "estado" => "required|in:ACTIVO,INACTIVO"
        ];
    }

    // Incrementar secuencial de factura una vez autorizada con éxito
    public static function incrementarFactura($idPunto, $nuevoValor)
    {
        return DB::table('puntos_emision')
            ->where('id', $idPunto)
            ->update(['factura_actual' => $nuevoValor]);
    }
}
