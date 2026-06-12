<?php

namespace App\Models\Products;

use App\Models\ModelManager;

class ProductStock extends ModelManager
{
    protected $table = 'product_stock';

    protected $fillable = [
        'product_id',
        'quantity',
        'quantity_base',
        'unit_measure_id',
    ];

    protected $attributesData = [
        [
            'column' => 'product_id',
            'type' => 'integer',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'quantity',
            'type' => 'decimal',
            'defaultValue' => '0',
                    'required' => 'true'
        ],
        [
            'column' => 'quantity_base',
            'type' => 'decimal',
            'defaultValue' => '0',
            'required' => 'true'
        ],
        [
            'column' => 'unit_measure_id',
            'type' => 'integer',
            'defaultValue' => '',
            'required' => 'true'
        ]
    ];

    public $timestamps = false;

    protected $field_main = 'product_id';

    public static function getRulesModel()
    {
        return [
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'quantity_base' => 'required|numeric',
            'unit_measure_id' => 'required|numeric',
        ];
    }
}
