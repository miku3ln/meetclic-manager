<?php

namespace App\Models\ProductsMeasure;

use App\Models\ModelManager;

class MeasureTypeConfig extends ModelManager
{
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    protected $table = 'measure_type_config';

    protected $fillable = [
        'business_id',
        'product_measure_type_id',
        'name',
        'state'
    ];

    protected $attributesData = [
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => 0, 'required' => 'true'],
        ['column' => 'product_measure_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'state', 'type' => 'integer', 'defaultValue' => 1, 'required' => 'false']
    ];

    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        return [
            'business_id' => 'required|numeric',
            'product_measure_type_id' => 'required|numeric',
            'state' => 'numeric'
        ];
    }
}
