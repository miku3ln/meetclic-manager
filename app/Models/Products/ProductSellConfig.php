<?php

namespace App\Models\Products;

use App\Models\ModelManager;


class ProductSellConfig extends ModelManager
{
    protected $table = 'product_sell_config';

    protected $fillable = [
        'product_id',
        'allow_pos',
        'allow_shop',
        'allow_delivery',
        'visible'
    ];

    protected $attributesData = [
        [
            'column' => 'product_id',
            'type' => 'integer',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'allow_pos',
            'type' => 'integer',
            'defaultValue' => '1',
            'required' => 'true'
        ],
        [
            'column' => 'allow_shop',
            'type' => 'integer',
            'defaultValue' => '1',
            'required' => 'true'
        ],
        [
            'column' => 'allow_delivery',
            'type' => 'integer',
            'defaultValue' => '0',
            'required' => 'true'
        ],
        [
            'column' => 'visible',
            'type' => 'integer',
            'defaultValue' => '1',
            'required' => 'true'
        ]
    ];

    public $timestamps = false;

    protected $field_main = 'product_id';

    public static function getRulesModel()
    {
        return [
            'product_id' => 'required|numeric',
            'allow_pos' => 'required|numeric',
            'allow_shop' => 'required|numeric',
            'allow_delivery' => 'required|numeric',
            'visible' => 'required|numeric',
        ];
    }
}
