<?php

namespace App\Models\Products;

use App\Models\ModelManager;

class ProductRecipeYield extends ModelManager
{
    protected $table = 'product_recipe_yield';

    protected $fillable = [
        'product_id',
        'yield_quantity',
        'unit_measure_id',
    ];

    public $timestamps = true;

    protected $field_main = 'product_id';

    protected $attributesData = [
        [
            'column' => 'product_id',
            'type' => 'integer',
            'required' => 'true'
        ],
        [
            'column' => 'yield_quantity',
            'type' => 'decimal',
            'required' => 'true'
        ],
        [
            'column' => 'unit_measure_id',
            'type' => 'integer',
            'required' => 'false'
        ]
    ];

    /**
     * Reglas de validación.
     */
    public static function getRulesModel()
    {
        return [
            'product_id' => 'required|numeric',
            'yield_quantity' => 'required|numeric|min:0.000001',
            'unit_measure_id' => 'nullable|numeric',
        ];
    }

    /**
     * Construye los atributos del modelo.
     */
    public function buildAttributes(array $data): array
    {
        return [
            'product_id' =>
                $data['product_id'] ?? null,

            'yield_quantity' =>
                $data['yield_quantity'] ?? 1,

            'unit_measure_id' =>
                $data['unit_measure_id'] ?? null,
        ];
    }

    /**
     * Verifica si ya existe configuración
     * de rendimiento para el producto.
     */
    public static function existsByProductId(
        int $productId
    ): bool {
        return self::where(
            'product_id',
            $productId
        )->exists();
    }

    /**
     * Obtiene el rendimiento configurado
     * para un producto.
     */
    public static function findByProductId(
        int $productId
    ): ?self {
        return self::where(
            'product_id',
            $productId
        )->first();
    }

    /**
     * Obtiene solamente yield_quantity.
     *
     * Si el producto no tiene configuración,
     * devuelve 1 como rendimiento por defecto.
     */
    public static function getYieldQuantity(
        int $productId
    ): float {
        $value = self::where(
            'product_id',
            $productId
        )->value('yield_quantity');

        if ($value === null) {
            return 1;
        }

        $value = (float) $value;

        return $value > 0
            ? $value
            : 1;
    }

    /**
     * Crear o actualizar usando product_id.
     *
     * Como product_id es UNIQUE,
     * solo existirá una configuración
     * de rendimiento por producto.
     */
    public static function saveByProductId(
        int $productId,
        array $data
    ): self {

        $yield = self::where(
            'product_id',
            $productId
        )->first();

        if (!$yield) {

            $yield = new self();

            $yield->product_id =
                $productId;
        }

        if (
            array_key_exists(
                'yield_quantity',
                $data
            )
        ) {
            $yield->yield_quantity =
                $data['yield_quantity'];
        }

        if (
            array_key_exists(
                'unit_measure_id',
                $data
            )
        ) {
            $yield->unit_measure_id =
                $data['unit_measure_id'];
        }

        $yield->save();

        return $yield;
    }

    /**
     * Actualiza únicamente el rendimiento
     * de un producto.
     */
    public static function updateYieldQuantity(
        int $productId,
        float $yieldQuantity
    ): ?self {

        $yield = self::findByProductId(
            $productId
        );

        if (!$yield) {
            return null;
        }

        $yield->yield_quantity =
            $yieldQuantity;

        $yield->save();

        return $yield;
    }

    /**
     * Elimina la configuración asociada
     * al producto.
     */
    public static function deleteByProductId(
        int $productId
    ): bool {

        return self::where(
                'product_id',
                $productId
            )->delete() > 0;
    }
}
