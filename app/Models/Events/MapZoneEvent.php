<?php

namespace App\Models\Events;

use App\Models\ModelManager;

class MapZoneEvent extends ModelManager
{
    protected $table = 'map_zone_event';

    protected $fillable = [
        'title',
        'code',
        'description',
        'source',
        'color_hex',
        'status',
    ];

    public $timestamps = true;

    protected $field_main = 'code';

    protected $attributesData = [
        [
            'column' => 'title',
            'type' => 'string',
            'required' => 'true'
        ],
        [
            'column' => 'code',
            'type' => 'string',
            'required' => 'true'
        ],
        [
            'column' => 'description',
            'type' => 'string',
            'required' => 'false'
        ],
        [
            'column' => 'source',
            'type' => 'string',
            'required' => 'false'
        ],
        [
            'column' => 'color_hex',
            'type' => 'string',
            'required' => 'true'
        ],
        [
            'column' => 'status',
            'type' => 'string',
            'required' => 'true'
        ],
    ];

    /**
     * Reglas de validación.
     */
    public static function getRulesModel()
    {
        return [
            'title' => 'required|string|max:150',
            'code' => 'required|string|max:50|unique:map_zone_event,code',
            'description' => 'nullable|string',
            'source' => 'nullable|string|max:500',
            'color_hex' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],
            'status' => 'required|in:ACTIVE,INACTIVE',
        ];
    }

    /**
     * Construye los atributos del modelo.
     */
    public function buildAttributes(array $data): array
    {
        return [
            'title' => $data['title'] ?? null,
            'code' => $data['code'] ?? null,
            'description' => $data['description'] ?? null,
            'source' => $data['source'] ?? null,
            'color_hex' => $data['color_hex'] ?? '#2563EB',
            'status' => $data['status'] ?? 'ACTIVE',
        ];
    }

    /**
     * Verifica si existe una zona por código.
     */
    public static function existsByCode(string $code): bool
    {
        return self::where('code', $code)->exists();
    }

    /**
     * Obtiene una zona por su código.
     */
    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }

    /**
     * Obtiene las zonas activas.
     */
    public static function getActiveZones()
    {
        return self::where('status', 'ACTIVE')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Obtiene una zona activa por ID.
     */
    public static function findActiveById( $zoneId): array
    {
        $zone= self::where('id', $zoneId)
            ->where('status', 'ACTIVE')
            ->first();

        if($zone) {
            $zone->source=   asset('public') . $zone->source;
        }
        return $zone ? $zone->toArray() : [
            'id' => "all",
            'title' => "Todas las Zonas",
            'code' => "all",
            'description' => "Zona de dulce o truco",
            'source' => asset('public') ."/assets/events/halloween.jpeg",
            'color_hex' => "#445EF2",
            'status' => 'ACTIVE',

        ];
    }

    /**
     * Crea o actualiza una zona utilizando su código.
     */
    public static function saveByCode(
        string $code,
        array $data
    ): self {

        $zone = self::where('code', $code)->first();

        if (!$zone) {
            $zone = new self();
            $zone->code = $code;
        }

        $fields = [
            'title',
            'description',
            'source',
            'color_hex',
            'status',
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $zone->{$field} = $data[$field];
            }
        }

        if (!$zone->exists) {
            $zone->color_hex = $zone->color_hex ?? '#2563EB';
            $zone->status = $zone->status ?? 'ACTIVE';
        }

        $zone->save();

        return $zone;
    }

    /**
     * Actualiza únicamente el color de una zona.
     */
    public static function updateColor(
        int $zoneId,
        string $colorHex
    ): ?self {

        $zone = self::find($zoneId);

        if (!$zone) {
            return null;
        }

        $zone->color_hex = $colorHex;
        $zone->save();

        return $zone;
    }

    /**
     * Obtiene las empresas relacionadas con una zona.
     */
    public function businesses()
    {
        return $this->belongsToMany(
            \App\Models\Business::class,
            'business_map_zone_event',
            'map_zone_event_id',
            'business_id'
        )->withTimestamps();
    }

    /**
     * Obtiene las relaciones de empresas con la zona.
     */
    public function businessZoneRelations()
    {
        return $this->hasMany(
            BusinessMapZoneEvent::class,
            'map_zone_event_id'
        );
    }
}
