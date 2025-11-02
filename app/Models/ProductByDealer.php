<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductByDealer extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products_by_dealers';

    protected $fillable = array('dealer_id', 'product_id');

    public $timestamps = false;


}
