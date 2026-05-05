<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class InventoryMovement extends ModelManager
{
    protected $table = 'inventory_movement';

    // 🔥 CONSTANTES
    const TYPE_IN     = 'IN';
    const TYPE_OUT    = 'OUT';
    const TYPE_ADJUST = 'ADJUST';

    protected $fillable = [
        'product_id',
        'movement_type',
        'quantity',
        'unit_measure_id',
        'quantity_input',
        'unit_input_id',
        'conversion_factor',
        'reference_type',
        'reference_id',
        'description',
        'created_at'
    ];

    protected $attributesData = [
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'movement_type', 'type' => 'string', 'defaultValue' => 'IN', 'required' => 'true'],
        ['column' => 'quantity', 'type' => 'decimal', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'unit_measure_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'quantity_input', 'type' => 'decimal', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'unit_input_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'conversion_factor', 'type' => 'decimal', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'reference_type', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'reference_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
    ];

    public $timestamps = false;

    protected $field_main = 'id';

    // 🔒 VALIDACIONES
    public static function getRulesModel()
    {
        return [
            "product_id" => "required|numeric",
            "movement_type" => "required|in:IN,OUT,ADJUST",
            "quantity" => "required|numeric",
            "unit_measure_id" => "required|numeric",
            "quantity_input" => "nullable|numeric",
            "unit_input_id" => "nullable|numeric",
            "conversion_factor" => "nullable|numeric",
            "reference_type" => "max:50",
            "reference_id" => "nullable|numeric"
        ];
    }

    // 🔗 RELACIONES (opcionales pero recomendadas)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unitMeasure()
    {
        return $this->belongsTo(UnitMeasure::class, 'unit_measure_id');
    }

    public function unitInput()
    {
        return $this->belongsTo(UnitMeasure::class, 'unit_input_id');
    }

    // 🚀 HELPERS IMPORTANTES

    // Entrada de inventario
    public static function createIn($data)
    {
        $data['movement_type'] = self::TYPE_IN;
        return self::create($data);
    }

    // Salida de inventario
    public static function createOut($data)
    {
        $data['movement_type'] = self::TYPE_OUT;
        return self::create($data);
    }

    // Ajuste
    public static function createAdjust($data)
    {
        $data['movement_type'] = self::TYPE_ADJUST;
        return self::create($data);
    }
}
