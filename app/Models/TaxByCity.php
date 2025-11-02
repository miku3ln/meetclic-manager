<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxByCity extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'taxes_by_cities';

    protected $fillable = array('city_id', 'tax_id');

    public $timestamps = false;

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }
}
