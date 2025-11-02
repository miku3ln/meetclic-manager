<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanoramaPoints extends Model
{

    protected $table = 'panorama_points';

    protected $fillable = array(
        'title',//*
        'subtitle',
        'description',
        'next_type',//*
        'coordinate_x',//*
        'coordinate_y',//*
    );
    public $timestamps = false;
    public $attributesData = array(
        'title',//*
        'subtitle',
        'description',
        'next_type',//*
        'coordinate_x',//*
        'coordinate_y',//*
    );

}
