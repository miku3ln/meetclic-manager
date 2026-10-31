<?php

namespace App\Models\Events;

use App\Models\ModelManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventBusinessPrize extends ModelManager
{
    protected $table = 'event_business_prize';

    protected $fillable = [
        'event_business_id',
        'name',
        'description',
        'source',
        'start_at',
        'end_at',
        'state',
    ];

    public $timestamps = true;

    protected $field_main = 'name';

    public static function getUsersEvent(int $eventId): array
    {
        if ($eventId <= 0) {
            return [];
        }

        // ==========================================
        // 1. CONSULTAR PREMIOS Y EMPRESAS
        // ==========================================

        $rows = DB::table('users as u')
            ->whereDate('u.created_at', '>=', '2026-10-26')
            ->select([
                'u.id as code',
                'u.name as name',
                'u.email as email',
                'u.provider as provider',
                'u.avatar as avatar',

            ])
            ->get();
        $params=[];
        return $rows->map(function ($row) use ($params) {


            // ======================================
            // RETORNAR MISMA ESTRUCTURA DEL DEMO
            // ======================================
            $avatar = "";
            if ($row->provider == 'google') {
                $avatar = $row->avatar;
            } else if ($row->provider == 'server') {

                $avatar = "https://img.magnific.com/vector-gratis/ayuda-soporte-fondo-abstracto-signo-interrogacion_1017-61970.jpg?semt=ais_hybrid&w=740&q=80";

            }
            return [
                'code' => (int)$row->code,
                'name' => $row->name,
                'avatar' => $avatar,
                'email' => $row->email,

            ];

        })->all();


    }

    /**
     * Obtiene los premios de un evento.
     *
     * Retorna exactamente la estructura
     * utilizada por $maskanaPrizes en Blade.
     *
     * @param int $eventId
     * @return array
     */
    public static function getPrizesByEventId(int $eventId): array
    {
        if ($eventId <= 0) {
            return [];
        }

        // ==========================================
        // 1. CONSULTAR PREMIOS Y EMPRESAS
        // ==========================================

        $rows = DB::table('event_business_prize as ep')
            ->join(
                'event_business as eb',
                'eb.id',
                '=',
                'ep.event_business_id'
            )
            ->join(
                'business as b',
                'b.id',
                '=',
                'eb.business_id'
            )
            ->where('eb.event_id', $eventId)
            ->whereIn('eb.participation_type', [
                'SPONSOR',
                'BOTH',
            ])
            ->where('eb.state', 'ACTIVE')
            ->where('ep.state', 'ACTIVE')
            ->where('b.status', 'ACTIVE')
            ->whereNull('b.deleted_at')
            ->select([
                'ep.id',
                'eb.event_id',
                'eb.business_id',

                'b.title as business_name',
                'b.source as business_logo',

                'ep.name',
                'ep.description',
                'ep.source',

                'ep.start_at',
                'ep.end_at',

                'ep.state',
            ])
            ->orderBy('eb.business_id', 'asc')
            ->orderBy('ep.id', 'asc')
            ->get();

        // ==========================================
        // 2. FORMATEAR ESTRUCTURA PARA BLADE
        // ==========================================

        $timezone = 'America/Guayaquil';
        $now = Carbon::now($timezone);

        return $rows->map(function ($row) use ($timezone, $now) {

            $startAt = Carbon::parse(
                $row->start_at,
                $timezone
            );

            $endAt = Carbon::parse(
                $row->end_at,
                $timezone
            );

            // ======================================
            // STATUS CALCULADO POR VIGENCIA
            // ======================================

            if ($now->lt($startAt)) {

                $status = 'UPCOMING';

            } elseif ($now->gt($endAt)) {

                $status = 'EXPIRED';

            } else {

                $status = 'ACTIVE';
            }

            // ======================================
            // RETORNAR MISMA ESTRUCTURA DEL DEMO
            // ======================================

            return [
                'id' => (int)$row->id,
                'event_id' => (int)$row->event_id,
                'business_id' => (int)$row->business_id,
                'business_name' => $row->business_name,
                'business_logo' => self::getUploadUrl(
                    $row->business_logo
                ),

                'name' => $row->name,

                'description' => $row->description,

                'source' => self::getUploadUrl(
                    $row->source
                ),

                'start_at' => $startAt,

                'end_at' => $endAt,

                'status' => $status,
            ];

        })->all();
    }

    /**
     * Construye la URL pública de una imagen.
     *
     * Acepta:
     * - uploads/...
     * - /uploads/...
     * - public/uploads/...
     * - URLs absolutas
     */
    public static function getUploadUrl(?string $path): string
    {
        $path = ltrim($path ?? '', '/');
        $path = preg_replace('#^(?:public/)?uploads/#', '', $path);
        return asset('public/uploads/' . $path);
    }
}
