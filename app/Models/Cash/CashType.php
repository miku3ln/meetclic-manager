<?php

namespace App\Models\Cash;

use App\Core\Traits\RepositoryTrait;
use App\Models\ModelManager;

class CashType extends ModelManager
{
    const TYPE_GENERAL = 'GENERAL';
    const TYPE_POINT_OF_SALE = 'POINT_OF_SALE';
    const TYPE_PETTY_CASH = 'PETTY_CASH';
    const TYPE_COLLECTION = 'COLLECTION';
    const TYPE_OTHER = 'OTHER';

    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    use RepositoryTrait;

    protected $table = 'cash_type';

    protected $fillable = [
        'code',
        'value',
        'description',
        'requires_opening',
        'requires_closing',
        'state'
    ];

    protected $attributesData = [
        [
            'column' => 'code',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'value',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'description',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'false'
        ],
        [
            'column' => 'requires_opening',
            'type' => 'integer',
            'defaultValue' => 0,
            'required' => 'false'
        ],
        [
            'column' => 'requires_closing',
            'type' => 'integer',
            'defaultValue' => 0,
            'required' => 'false'
        ],
        [
            'column' => 'state',
            'type' => 'string',
            'defaultValue' => self::STATE_ACTIVE,
            'required' => 'false'
        ]
    ];

    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        return [
            'code' => 'required|string|max:30',
            'value' => 'required|string|max:150',
            'description' => 'nullable|string',
            'requires_opening' => 'required|in:0,1',
            'requires_closing' => 'required|in:0,1',
            'state' => 'required|in:ACTIVE,INACTIVE'
        ];
    }

    public function getActive()
    {
        return self::where('state', self::STATE_ACTIVE)
            ->orderBy('value')
            ->get();
    }

    public function getByCode($code)
    {
        return self::where('code', $code)
            ->where('state', self::STATE_ACTIVE)
            ->first();
    }
}
