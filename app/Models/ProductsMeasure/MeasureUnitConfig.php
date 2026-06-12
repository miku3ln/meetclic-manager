<?php

namespace App\Models\ProductsMeasure;

use App\Models\ModelManager;

class MeasureUnitConfig extends ModelManager
{
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    protected $table = 'measure_unit_config';

    protected $fillable = [
        'measure_type_config_id',
        'unit_measure_id',
        'is_default',
        'state'
    ];

    protected $attributesData = [
        ['column' => 'measure_type_config_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'unit_measure_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'is_default', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'false'],
        ['column' => 'state', 'type' => 'integer', 'defaultValue' => 1, 'required' => 'false']
    ];

    public $timestamps = false;

    protected $field_main = 'unit_measure_id';

    public static function getRulesModel()
    {
        return [
            'measure_type_config_id' => 'required|numeric',
            'unit_measure_id' => 'required|numeric',
            'is_default' => 'numeric',
            'state' => 'numeric'
        ];
    }
}
