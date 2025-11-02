<?php

namespace App\Services;

use GeoIp2\Database\Reader;

class GeoIpLocalService
{
    protected Reader $reader;

    public function __construct()
    {
        $this->reader = new Reader(storage_path('app/geolite2/GeoLite2-City.mmdb'));
    }

    public function locate(string $ip): ?array
    {
        try {
            $record = $this->reader->city($ip);

            return [
                'ip' => $ip,
                'countryName' => $record->country->name,
                'regionName' => $record->mostSpecificSubdivision->name,
                'cityName' => $record->city->name,
                'latitude' => $record->location->latitude,
                'longitude' => $record->location->longitude,
                'timezone' => $record->location->timeZone,
            ];
        } catch (\Exception $e) {

            return null;
        }
    }
}
