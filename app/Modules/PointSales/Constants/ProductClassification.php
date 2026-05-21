<?php

namespace App\Modules\PointSales\Constants;

class ProductClassification
{
    /*
    |--------------------------------------------------------------------------
    | PRODUCT TYPES
    |--------------------------------------------------------------------------
    */

    public const TYPE_MEASURABLE = 'MEASURABLE';
    public const TYPE_UNIT = 'UNIT';
    public const TYPE_MIXED = 'MIXED';

    /*
    |--------------------------------------------------------------------------
    | INVENTORY TYPES
    |--------------------------------------------------------------------------
    */

    public const INVENTORY_RAW = 'RAW';
    public const INVENTORY_PROCESSED = 'PROCESSED';
    public const INVENTORY_FOR_SALE = 'FOR_SALE';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONAL TYPES
    |--------------------------------------------------------------------------
    */

    public const RAW_MEASURABLE = 'RAW_MEASURABLE';

    public const RAW_UNIT = 'RAW_UNIT';

    public const PROCESSED_MEASURABLE = 'PROCESSED_MEASURABLE';

    public const PROCESSED_UNIT = 'PROCESSED_UNIT';

    public const FOR_SALE_MEASURABLE = 'FOR_SALE_MEASURABLE';

    public const FOR_SALE_UNIT = 'FOR_SALE_UNIT';

    public const FOR_SALE_MIXED = 'FOR_SALE_MIXED';
}
