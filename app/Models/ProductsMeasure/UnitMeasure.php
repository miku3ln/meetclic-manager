<?php

namespace App\Models\ProductsMeasure;

use App\Models\ModelManager;

class UnitMeasure extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    protected $table = 'unit_measure';

    protected $fillable = [
        'product_measure_type_id',
        'name',
        'symbol',
        'factor_to_base',
        'is_base',
        'decimal_precision',
        'state'
    ];

    protected $attributesData = [
        ['column' => 'product_measure_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'symbol', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'factor_to_base', 'type' => 'double', 'defaultValue' => 1, 'required' => 'true'],
        ['column' => 'is_base', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'false'],
        ['column' => 'decimal_precision', 'type' => 'integer', 'defaultValue' => 2, 'required' => 'false'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => self::STATE_ACTIVE, 'required' => 'false']
    ];

    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        return [
            'product_measure_type_id' => 'required|numeric',
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:100',
            'factor_to_base' => 'required|numeric',
            'is_base' => 'numeric',
            'decimal_precision' => 'numeric'
        ];
    }
}
