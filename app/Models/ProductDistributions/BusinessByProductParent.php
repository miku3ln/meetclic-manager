<?php

namespace App\Models\ProductDistributions;

use Illuminate\Database\Eloquent\Model;

class BusinessByProductParent extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_by_products_parent';

    protected $fillable = array('business_id', 'products_id');

    public $timestamps = false;




}
