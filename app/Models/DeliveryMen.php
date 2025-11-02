<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DeliveryMen extends Authenticatable
{

    use HasApiTokens, Notifiable;

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    const TOKEN_TYPE_DELIVERY = 'delivery_men_api';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'delivery_men';

    protected $guard = 'delivery_men_api';

    protected $primaryKey = 'id';

    protected $hidden = [
        'password',
    ];

    protected $fillable = array(
        'name',
        'document_type',
        'document',
        'delivery_status',
        'status',
        'email',
        'password'
    );

    public $timestamps = true;

}
