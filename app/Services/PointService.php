<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
class PointService
{
    public $latitude;
    public $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toSql()
    {
        return "ST_GeomFromText('POINT($this->longitude $this->latitude)')";
    }

    public  function latLngToPoint($latitude, $longitude)
    {
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return null;
        }

        return DB::raw("ST_GeomFromText('POINT($longitude $latitude)')");
    }
}
