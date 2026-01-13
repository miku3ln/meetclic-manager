<?php

namespace App\Infrastructure\Cms\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountGamificationModel extends Model
{
    use SoftDeletes;

    protected $table = 'account_gamification';

    protected $fillable = [
        'user_id',
        'business_id',
        'type_money',
        'state',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'business_id' => 'integer',
        'type_money' => 'integer',
    ];
}
