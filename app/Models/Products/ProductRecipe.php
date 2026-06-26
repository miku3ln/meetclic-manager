<?php

namespace App\Models\Products;

use App\Models\ModelManager;

class ProductRecipe extends ModelManager
{
    protected $table = 'product_recipe';

    protected $fillable = [
        'product_id',
        'component_product_id',
        'quantity_base',
        'base_unit_measure_id',
        'quantity_input',
        'unit_input_id',
        'conversion_factor',
    ];

    public $timestamps = false;

    protected $field_main = 'product_id';

    protected $attributesData = [
        [
            'column' => 'product_id',
            'type' => 'integer',
            'required' => 'true'
        ],
        [
            'column' => 'component_product_id',
            'type' => 'integer',
            'required' => 'true'
        ],
        [
            'column' => 'quantity_base',
            'type' => 'decimal',
            'required' => 'true'
        ],
        [
            'column' => 'base_unit_measure_id',
            'type' => 'integer',
            'required' => 'true'
        ],
        [
            'column' => 'quantity_input',
            'type' => 'decimal',
            'required' => 'true'
        ],
        [
            'column' => 'unit_input_id',
            'type' => 'integer',
            'required' => 'true'
        ],
        [
            'column' => 'conversion_factor',
            'type' => 'decimal',
            'required' => 'true'
        ]
    ];

    public static function getRulesModel()
    {
        return [
            'product_id' => 'required|numeric',
            'component_product_id' => 'required|numeric',
            'quantity_base' => 'required|numeric',
            'base_unit_measure_id' => 'required|numeric',
            'quantity_input' => 'required|numeric',
            'unit_input_id' => 'required|numeric',
            'conversion_factor' => 'required|numeric',
        ];
    }
    public function buildAttributes(array $data): array
    {
        return [
            'product_id' => $data['product_id'] ?? null,
            'component_product_id' => $data['component_product_id'] ?? null,

            'quantity_base' => $data['quantity_base'] ?? 0,
            'base_unit_measure_id' => $data['base_unit_measure_id'] ?? null,

            'quantity_input' => $data['quantity_input'] ?? 0,
            'unit_input_id' => $data['unit_input_id'] ?? null,

            'conversion_factor' => $data['conversion_factor'] ?? 1,
        ];
    }
    public static function existsComponentProduct(int $componentProductId): bool
    {
        return self::where(
            'component_product_id',
            $componentProductId
        )->exists();
    }
}
