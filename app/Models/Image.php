<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    public $timestamps = true;

    protected $fillable = [
        'file_name',
        'position',
        'product_id',
        'base64'
    ];


    /**
     * Generate url for image
     */
    public function getUrlAttribute()
    {
        $site_url = Parameter::where('name', '=',
            'site_url')->first()->value;
        $folder = "/uploads/";
        switch (true) {
            case ($this->product_id != null):
                $folder = $folder . 'products/';
                break;
        }
        $url = $site_url . "/api/img" . $folder . $this->filename;
        return $url;
    }



}