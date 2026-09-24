<?php

namespace App\Models\Cash;

use App\Core\Traits\RepositoryTrait;
use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class Cash extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    use RepositoryTrait;

    protected $table = 'cash';

    protected $fillable = [
        'accounting_account_id',
        'name',
        'details',
        'user_id',
        'state',
        'amount_current',
        'created_at',
        'update_at'
    ];

    protected $attributesData = [
        [
            'column' => 'accounting_account_id',
            'type' => 'integer',
            'defaultValue' => 0,
            'required' => 'true'
        ],
        [
            'column' => 'name',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'true'
        ],
        [
            'column' => 'details',
            'type' => 'string',
            'defaultValue' => '',
            'required' => 'false'
        ],
        [
            'column' => 'user_id',
            'type' => 'integer',
            'defaultValue' => 0,
            'required' => 'true'
        ],
        [
            'column' => 'state',
            'type' => 'string',
            'defaultValue' => self::STATE_ACTIVE,
            'required' => 'false'
        ],
        [
            'column' => 'amount_current',
            'type' => 'double',
            'defaultValue' => 0,
            'required' => 'false'
        ]
    ];

    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        return [
            'accounting_account_id' => 'required|numeric',
            'name' => 'required|string|max:120',
            'details' => 'nullable|string',
            'user_id' => 'required|numeric',
            'state' => 'required|in:ACTIVE,INACTIVE',
            'amount_current' => 'nullable|numeric'
        ];
    }

    /**
     * Obtener caja por ID.
     */
    public function getById($cashId)
    {
        return self::where('id', $cashId)
            ->first();
    }

    /**
     * Obtener cajas activas.
     */
    public function getActive()
    {
        return self::where('state', self::STATE_ACTIVE)
            ->orderBy('name')
            ->get();
    }

    /**
     * Obtener cajas de una empresa.
     */
    public function getByBusiness($businessId)
    {
        return DB::table('cash as c')
            ->join(
                'business_by_cash as bbc',
                'bbc.cash_id',
                '=',
                'c.id'
            )
            ->leftJoin(
                'cash_by_type as cbt',
                'cbt.cash_id',
                '=',
                'c.id'
            )
            ->leftJoin(
                'cash_type as ct',
                'ct.id',
                '=',
                'cbt.cash_type_id'
            )
            ->where('bbc.business_id', $businessId)
            ->where('c.state', self::STATE_ACTIVE)
            ->select([
                'c.*',
                'bbc.id as business_by_cash_id',
                'ct.id as cash_type_id',
                'ct.code as cash_type_code',
                'ct.value as cash_type'
            ])
            ->get();
    }

    /**
     * Obtener cajas POS de una empresa.
     */
    public function getPointOfSaleByBusiness($businessId)
    {
        return DB::table('cash as c')
            ->join(
                'business_by_cash as bbc',
                'bbc.cash_id',
                '=',
                'c.id'
            )
            ->join(
                'cash_by_type as cbt',
                'cbt.cash_id',
                '=',
                'c.id'
            )
            ->join(
                'cash_type as ct',
                'ct.id',
                '=',
                'cbt.cash_type_id'
            )
            ->where('bbc.business_id', $businessId)
            ->where('ct.code', CashType::TYPE_POINT_OF_SALE)
            ->where('c.state', self::STATE_ACTIVE)
            ->select([
                'c.*',
                'bbc.id as business_by_cash_id',
                'ct.id as cash_type_id',
                'ct.code as cash_type_code',
                'ct.value as cash_type'
            ])
            ->get();
    }
}
