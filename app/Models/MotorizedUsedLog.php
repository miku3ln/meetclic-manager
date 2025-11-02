<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorizedUsedLog extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'motorized_used_log';

    public $timestamps = false;

    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMen::class, 'delivery_men_id');
    }

}