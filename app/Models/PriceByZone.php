<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceByZone extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prices_by_zones';

    protected $fillable = array('price','zone_id','product_id');

    public $timestamps = false;


}
