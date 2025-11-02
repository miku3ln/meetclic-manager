<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorized extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_MOTORIZED_AVAILABLE = 'AVAILABLE';
    const STATUS_MOTORIZED_BUSY = 'BUSY';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'motorized';

    protected $fillable = array('name','license','dealer_id','status_motorized');

    public $timestamps = true;

}
