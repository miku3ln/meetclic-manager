<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'doctor';

    protected $fillable = array(
        'name',
        'document_type',
        'document',
        'gender',
        'birthday_date',
        'address',
        'latitude',
        'longitude',
        'phone',
        'movil',
        'status');

    public $timestamps = true;

    public function scopeActive($query)
    {
        return $query->where('status', $this::STATUS_ACTIVE);
    }
}
