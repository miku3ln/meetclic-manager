<?php

namespace App\Models\Events;

use App\Models\ModelManager;

class BusinessMapZoneEvent extends ModelManager
{
    protected $table = 'business_map_zone_event';

    protected $fillable = [
        'business_id',
        'map_zone_event_id',
        'street_lat',
        'street_lng',
        'street_1',
        'street_2',

    ];

    public $timestamps = true;

    protected $field_main = 'business_id';

    protected $attributesData = [
        [
            'column' => 'business_id',
            'type' => 'integer',
            'required' => 'true'
        ],
        [
            'column' => 'map_zone_event_id',
            'type' => 'integer',
            'required' => 'true'
        ],
    ];

    /**
     * Reglas de validación.
     */
    public static function getRulesModel()
    {
        return [
            'business_id' => 'required|integer|exists:business,id',
            'map_zone_event_id' =>
                'required|integer|exists:map_zone_event,id',
        ];
    }

    /**
     * Construye los atributos del modelo.
     */
    public function buildAttributes(array $data): array
    {
        return [
            'business_id' => $data['business_id'] ?? null,
            'map_zone_event_id' => $data['map_zone_event_id'] ?? null,
        ];
    }

    /**
     * Verifica si una empresa pertenece a una zona.
     */
    public static function existsByBusinessAndZone(
        int $businessId,
        int $zoneId
    ): bool {

        return self::where('business_id', $businessId)
            ->where('map_zone_event_id', $zoneId)
            ->exists();
    }

    /**
     * Obtiene una relación por empresa y zona.
     */
    public static function findByBusinessAndZone(
        int $businessId,
        int $zoneId
    ): ?self {

        return self::where('business_id', $businessId)
            ->where('map_zone_event_id', $zoneId)
            ->first();
    }

    /**
     * Obtiene las zonas asignadas a una empresa.
     */
    public static function getZonesByBusinessId(int $businessId)
    {
        return self::where('business_id', $businessId)
            ->with('zone')
            ->get();
    }

    /**
     * Obtiene las empresas asignadas a una zona.
     */
    public static function getBusinessesByZoneId(int $zoneId)
    {
        return self::where('map_zone_event_id', $zoneId)
            ->get();
    }

    /**
     * Asigna una empresa a una zona.
     *
     * Evita duplicar la misma relación.
     */
    public static function saveByBusinessAndZone(
        int $businessId,
        int $zoneId
    ): self {

        return self::firstOrCreate([
            'business_id' => $businessId,
            'map_zone_event_id' => $zoneId,
        ]);
    }

    /**
     * Elimina una empresa de una zona.
     */
    public static function deleteByBusinessAndZone(
        int $businessId,
        int $zoneId
    ): bool {

        return self::where('business_id', $businessId)
                ->where('map_zone_event_id', $zoneId)
                ->delete() > 0;
    }

    /**
     * Elimina todas las zonas asignadas a una empresa.
     */
    public static function deleteByBusinessId(
        int $businessId
    ): bool {

        return self::where('business_id', $businessId)
                ->delete() > 0;
    }

    /**
     * Relación con la zona.
     */
    public function zone()
    {
        return $this->belongsTo(
            MapZoneEvent::class,
            'map_zone_event_id'
        );
    }
}
