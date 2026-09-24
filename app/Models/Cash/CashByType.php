<?php

namespace App\Models\Cash;

use App\Models\ModelManager;

class CashByType extends ModelManager
{
    protected $table = 'cash_by_type';

    protected $fillable = [
        'cash_id',
        'cash_type_id',
        'created_at',
        'update_at'
    ];

    public $timestamps = false;

    public function getByCash($cashId)
    {
        return self::where('cash_id', $cashId)
            ->first();
    }

    public function setCashType($cashId, $cashTypeId)
    {
        $model = self::where('cash_id', $cashId)
            ->first();

        if (!$model) {
            $model = new self();
            $model->cash_id = $cashId;
            $model->created_at = now();
        }

        $model->cash_type_id = $cashTypeId;
        $model->update_at = now();

        return $model->save();
    }
}
