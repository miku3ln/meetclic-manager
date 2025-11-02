<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panorama extends Model
{

    protected $table = 'panorama';
    const typePanoramaNormal = 0;
    const typePanoramaImageResume = 1;
    const pointsAllowNotBreakDown = 0;
    const pointsAllowBreakDown = 1;
    const typeBreakdownParent = 0;
    const typeBreakdownChildren = 1;

    protected $fillable = array(
        'title',//*
        'subtitle',
        'description',
        'type_panorama',//*
        'points_allow',//*
        'src',//*
        'type_breakdown'//*
    );
    public $timestamps = false;
    public $attributesData = array(
        'title',//*
        'subtitle',
        'description',
        'type_panorama',//*
        'points_allow',//*
        'src',//*
        'type_breakdown'//*
    );

}
