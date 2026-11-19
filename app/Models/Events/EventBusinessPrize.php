<?php

namespace App\Models\Events;

use App\Models\ModelManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public static function getUser(int $userId): array
    {
        if ($userId <= 0) {
            return [];
        }

        $user = DB::table('users as u')
            ->select([
                'u.id as code',
                'u.name',
                'u.email',
                'u.provider',
                'u.avatar',
            ])
            ->where('u.id', $userId)
            ->first();

        return $user ? (array) $user : [];
    }
    public static function getUsersEvent(int $eventId,$canManage=false): array
    {
        if ($eventId <= 0) {
            return [];
        }

        // ==========================================
        // 1. PERMISOS DE ADMINISTRACION
        // ==========================================
        // ==========================================
        // 2. CONSULTA BASE DE PARTICIPANTES
        // ==========================================

        $query = DB::table('users as u')

            ->whereDate(
                'u.created_at',
                '>=',
                '2026-10-26'
            )

            ->select([

                'u.id as code',
                'u.name as name',
                'u.provider as provider',
                'u.avatar as avatar',

            ]);

        // ==========================================
        // 3. INFORMACION PRIVADA DE PREMIOS
        // ==========================================

        if ($canManage) {

            $query

                ->leftJoin(
                    'event_business_prize_winner as w',
                    function ($join) use ($eventId) {

                        $join->on(
                            'w.user_id',
                            '=',
                            'u.id'
                        );

                        $join->where(
                            'w.event_id',
                            '=',
                            $eventId
                        );
                    }
                )

                ->leftJoin(
                    'event_business_prize as ep',
                    'ep.id',
                    '=',
                    'w.event_business_prize_id'
                )

                ->leftJoin(
                    'event_business as eb',
                    'eb.id',
                    '=',
                    'ep.event_business_id'
                )

                ->leftJoin(
                    'business as b',
                    'b.id',
                    '=',
                    'eb.business_id'
                )

                ->addSelect([

                    // INFORMACION DEL USUARIO

                    'u.email as email',

                    // ASIGNACION DEL PREMIO

                    'w.id as winner_id',
                    'w.event_id',
                    'w.event_business_prize_id',
                    'w.prize_code',
                    'w.state as assignment_state',

                    'w.created_at as assigned_at',
                    'w.updated_at as assignment_updated_at',
                    'w.created_by',

                    // NOTIFICACION

                    'w.notification_status',
                    'w.notification_attempts',
                    'w.notification_email',
                    'w.notification_error',
                    'w.notification_sent_at',
                    'w.notification_attempted_at',

                    // ENTREGA

                    'w.delivery_status',
                    'w.delivery_at',
                    'w.delivery_checked_at',
                    'w.delivery_observation',
                    'w.delivery_evidence',
                    'w.delivery_checked_by',

                    // PREMIO

                    'ep.name as prize_name',
                    'ep.description as prize_description',
                    'ep.source as prize_source',

                    'ep.start_at as prize_start_at',
                    'ep.end_at as prize_end_at',

                    'ep.state as prize_state',

                    // EMPRESA

                    'b.id as business_id',
                    'b.title as business_name',
                    'b.source as business_logo',

                    'b.phone_value as business_phone',
                    'b.street_1 as business_street_1',
                    'b.street_2 as business_street_2',

                ]);
        }

        // ==========================================
        // 4. EJECUTAR UNA SOLA CONSULTA
        // ==========================================

        $rows = $query
            ->orderBy('u.id', 'asc')
            ->get();

        // ==========================================
        // 5. AGRUPAR POR PARTICIPANTE
        // ==========================================

        return $rows

            ->groupBy('code')

            ->map(function ($userRows) use (
                $canManage,
                $eventId
            ) {

                $row = $userRows->first();

                // ==================================
                // 6. AVATAR
                // ==================================

                $avatar = '';

                if ($row->provider === 'google') {

                    $avatar = $row->avatar ?? '';

                } elseif ($row->provider === 'server') {

                    $avatar = '';
                }

                // ==================================
                // 7. INFORMACION BASE DEL USUARIO
                // ==================================

                $user = [

                    'code' => (int) $row->code,

                    'name' => $row->name,

                    'avatar' => $avatar,

                    'email' => $canManage
                        ? ($row->email ?? '')
                        : '',

                    'provider' => $row->provider,

                    'can_manage_prizes' => $canManage,

                ];

                // ==================================
                // 8. INTERFAZ PUBLICA
                // ==================================

                if (!$canManage) {

                    return $user;
                }

                // ==================================
                // 9. CONSTRUIR PREMIOS DEL USUARIO
                // ==================================

                $prizes = $userRows

                    ->filter(function ($item) {

                        return $item->winner_id !== null;

                    })

                    ->map(function ($item) {

                        $isActive =
                            $item->assignment_state ===
                            EventBusinessPrizeWinner::STATE_ACTIVE;

                        $isCancelled =
                            $item->assignment_state ===
                            EventBusinessPrizeWinner::STATE_CANCELLED;

                        $isNotified =
                            $item->notification_status ===
                            EventBusinessPrizeWinner::NOTIFICATION_SENT;

                        $isProcessing =
                            $item->notification_status ===
                            EventBusinessPrizeWinner::NOTIFICATION_PROCESSING;

                        $isDelivered =
                            $item->delivery_status ===
                            EventBusinessPrizeWinner::DELIVERY_DELIVERED;

                        $isExpired = $item->prize_end_at
                            && now('America/Guayaquil')->gt(
                                \Carbon\Carbon::parse(
                                    $item->prize_end_at,
                                    'America/Guayaquil'
                                )
                            );

                        // ==========================
                        // IMAGENES
                        // ==========================

                        $prizeSource = !empty(
                        $item->prize_source
                        )
                            ? self::getUploadUrl(
                                $item->prize_source
                            )
                            : null;

                        $businessLogo = !empty(
                        $item->business_logo
                        )
                            ? self::getUploadUrl(
                                $item->business_logo
                            )
                            : null;

                        // ==========================
                        // INFORMACION CONSOLIDADA
                        // ==========================

                        return [

                            'id' => (int) $item->winner_id,

                            'event_id' => (int) $item->event_id,

                            'event_business_prize_id' =>
                                (int) $item->event_business_prize_id,

                            'prize_code' => $item->prize_code,

                            'state' => $item->assignment_state,

                            // ASIGNACION

                            'assignment' => [

                                'status' =>
                                    $item->assignment_state,

                                'is_assigned' => $isActive,

                                'is_cancelled' => $isCancelled,

                                'assigned_at' => $item->assigned_at,

                                'updated_at' =>
                                    $item->assignment_updated_at,

                                'created_by' => $item->created_by
                                    ? (int) $item->created_by
                                    : null,

                            ],

                            // NOTIFICACION

                            'notification' => [

                                'status' =>
                                    $item->notification_status,

                                'is_sent' => $isNotified,

                                'is_processing' => $isProcessing,

                                'attempts' =>
                                    (int) $item->notification_attempts,

                                'email' =>
                                    $item->notification_email,

                                'error' =>
                                    $item->notification_error,

                                'sent_at' =>
                                    $item->notification_sent_at,

                                'attempted_at' =>
                                    $item->notification_attempted_at,

                            ],

                            // ENTREGA

                            'delivery' => [

                                'status' =>
                                    $item->delivery_status,

                                'is_delivered' => $isDelivered,

                                'delivered_at' =>
                                    $item->delivery_at,

                                'checked_at' =>
                                    $item->delivery_checked_at,

                                'observation' =>
                                    $item->delivery_observation,

                                'evidence' =>
                                    $item->delivery_evidence,

                                'checked_by' =>
                                    $item->delivery_checked_by
                                        ? (int) $item->delivery_checked_by
                                        : null,

                            ],

                            // PREMIO

                            'prize' => [

                                'id' =>
                                    (int) $item->event_business_prize_id,

                                'name' => $item->prize_name,

                                'description' =>
                                    $item->prize_description,

                                'source' => $prizeSource,

                                'start_at' => $item->prize_start_at,

                                'end_at' => $item->prize_end_at,

                                'state' => $item->prize_state,

                                'is_expired' => (bool) $isExpired,

                            ],

                            // EMPRESA

                            'business' => [

                                'id' => $item->business_id
                                    ? (int) $item->business_id
                                    : null,

                                'name' => $item->business_name,

                                'logo' => $businessLogo,

                                'phone' => $item->business_phone,

                                'address' => implode(
                                    ' - ',
                                    array_filter([
                                        $item->business_street_1,
                                        $item->business_street_2,
                                    ])
                                ),

                            ],

                            // ACCIONES DISPONIBLES

                            'actions' => [

                                'can_send_notification' =>

                                    $isActive &&

                                    !$isDelivered &&

                                    $item->prize_state === 'ACTIVE' &&

                                    $item->delivery_status ===
                                    EventBusinessPrizeWinner::DELIVERY_PENDING &&

                                    in_array(
                                        $item->notification_status,
                                        [
                                            EventBusinessPrizeWinner::NOTIFICATION_PENDING,
                                            EventBusinessPrizeWinner::NOTIFICATION_FAILED,
                                        ],
                                        true
                                    ),

                                'can_manage_delivery' =>

                                    $isActive &&
                                    !$isDelivered &&
                                    !$isProcessing,

                                'can_cancel' =>

                                    $isActive &&
                                    !$isDelivered &&
                                    !$isProcessing,

                                'can_view_details' => true,

                            ],

                        ];

                    })

                    ->values();

                // ==================================
                // 10. PREMIOS ACTIVOS Y CANCELADOS
                // ==================================

                $activePrizes = $prizes->where(
                    'state',
                    EventBusinessPrizeWinner::STATE_ACTIVE
                );

                $cancelledPrizes = $prizes->where(
                    'state',
                    EventBusinessPrizeWinner::STATE_CANCELLED
                );

                // ==================================
                // 11. RESUMEN POR PARTICIPANTE
                // ==================================

                $totalAssigned = $activePrizes->count();

                $totalNotified = $activePrizes

                    ->where(
                        'notification.status',
                        EventBusinessPrizeWinner::NOTIFICATION_SENT
                    )

                    ->count();

                $totalDelivered = $activePrizes

                    ->where(
                        'delivery.status',
                        EventBusinessPrizeWinner::DELIVERY_DELIVERED
                    )

                    ->count();

                $totalFailed = $activePrizes

                    ->where(
                        'notification.status',
                        EventBusinessPrizeWinner::NOTIFICATION_FAILED
                    )

                    ->count();

                // ==================================
                // 12. ESTADO GENERAL
                // ==================================

                $hasPrize = $totalAssigned > 0;

                $allNotified = $hasPrize &&
                    $totalAssigned === $totalNotified;

                $allDelivered = $hasPrize &&
                    $totalAssigned === $totalDelivered;

                // ==================================
                // 13. RESULTADO ADMINISTRATIVO
                // ==================================

                $user['prize_management'] = [

                    'event_id' => $eventId,

                    'user_id' => (int) $row->code,

                    'has_prize' => $hasPrize,

                    'has_notification' => $totalNotified > 0,

                    'has_delivery' => $totalDelivered > 0,

                    'all_notified' => $allNotified,

                    'all_delivered' => $allDelivered,

                    'assignment_status' => $hasPrize
                        ? 'ACTIVE'
                        : (
                        $cancelledPrizes->isNotEmpty()
                            ? 'CANCELLED'
                            : 'NOT_ASSIGNED'
                        ),

                    // RESUMEN

                    'summary' => [

                        'total_assigned' => $totalAssigned,

                        'total_cancelled' =>
                            $cancelledPrizes->count(),

                        'total_notified' => $totalNotified,

                        'total_not_notified' =>
                            $totalAssigned - $totalNotified,

                        'total_notification_failed' =>
                            $totalFailed,

                        'total_delivered' => $totalDelivered,

                        'total_not_delivered' =>
                            $totalAssigned - $totalDelivered,

                    ],

                    // ACCIONES GENERALES

                    'actions' => [

                        'can_assign_prize' => true,

                        'can_send_notification' =>

                            $activePrizes->contains(
                                'actions.can_send_notification',
                                true
                            ),

                        'can_manage_delivery' =>

                            $activePrizes->contains(
                                'actions.can_manage_delivery',
                                true
                            ),

                        'can_view_details' =>
                            $prizes->isNotEmpty(),

                    ],

                    // LISTADO DE PREMIOS

                    'prizes' => $prizes->all(),

                ];

                return $user;

            })

            ->values()

            ->all();
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
                'b.phone_value as business_phone',
                'b.street_1 as business_street_1',
                'b.street_2 as business_street_2',
                'b.street_lat as business_street_lat',
                'b.street_lng as  business_street_lng',
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
                'business_phone' =>$row->business_phone,
                'business_street_1' =>$row->business_street_1,
                'business_street_2' =>$row->business_street_2,
                'business_street_lat' =>$row->business_street_lat,
                'business_street_lng' =>$row->business_street_lng,
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
    public static function getPrizeByEventId(
        int $eventId,
        ?int $eventBusinessPrizeId = null
    ): array {

        // ==========================================
        // 1. VALIDAR IDENTIFICADORES
        // ==========================================

        if ($eventId <= 0) {
            return [];
        }

        if (
            $eventBusinessPrizeId !== null
            && $eventBusinessPrizeId <= 0
        ) {
            return [];
        }

        // ==========================================
        // 2. CONSULTAR PREMIOS Y EMPRESAS
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

            // ======================================
            // FILTRO OPCIONAL POR PREMIO
            // ======================================

            ->when(
                $eventBusinessPrizeId !== null,
                function ($query) use ($eventBusinessPrizeId) {

                    $query->where(
                        'ep.id',
                        $eventBusinessPrizeId
                    );

                }
            )

            ->whereIn('eb.participation_type', [
                'SPONSOR',
                'BOTH',
            ])

            ->where('eb.state', 'ACTIVE')
            ->where('ep.state', 'ACTIVE')
            ->where('b.status', 'ACTIVE')
            ->whereNull('b.deleted_at')

            ->select([

                // ==================================
                // IDENTIFICADORES
                // ==================================

                'ep.id',
                'eb.event_id',
                'eb.business_id',

                // ==================================
                // INFORMACIÓN DE LA EMPRESA
                // ==================================

                'b.title as business_name',
                'b.source as business_logo',
                'b.phone_value as business_phone',
                'b.street_1 as business_street_1',
                'b.street_2 as business_street_2',
                'b.street_lat as business_street_lat',
                'b.street_lng as business_street_lng',

                // ==================================
                // INFORMACIÓN DEL PREMIO
                // ==================================

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
        // 3. CONFIGURAR ZONA HORARIA
        // ==========================================

        $timezone = 'America/Guayaquil';

        $now = Carbon::now($timezone);

        // ==========================================
        // 4. FORMATEAR PREMIOS
        // ==========================================

        $prizes = $rows->map(
            function ($row) use ($timezone, $now) {

                $startAt = Carbon::parse(
                    $row->start_at,
                    $timezone
                );

                $endAt = Carbon::parse(
                    $row->end_at,
                    $timezone
                );

                // ==================================
                // ESTADO SEGÚN VIGENCIA
                // ==================================

                if ($now->lt($startAt)) {

                    $status = 'UPCOMING';

                } elseif ($now->gt($endAt)) {

                    $status = 'EXPIRED';

                } else {

                    $status = 'ACTIVE';

                }

                // ==================================
                // ESTRUCTURA ORIGINAL
                // ==================================

                return [

                    'id' => (int) $row->id,

                    'event_id' => (int) $row->event_id,

                    'business_id' => (int) $row->business_id,

                    'business_name' => $row->business_name,

                    'business_logo' => self::getUploadUrl(
                        $row->business_logo
                    ),

                    'business_phone' =>
                        $row->business_phone,

                    'business_street_1' =>
                        $row->business_street_1,

                    'business_street_2' =>
                        $row->business_street_2,

                    'business_street_lat' =>
                        $row->business_street_lat,

                    'business_street_lng' =>
                        $row->business_street_lng,

                    'name' => $row->name,

                    'description' => $row->description,

                    'source' => self::getUploadUrl(
                        $row->source
                    ),

                    'start_at' => $startAt,

                    'end_at' => $endAt,

                    'status' => $status,
                ];
            }
        );

        // ==========================================
        // 5. RETORNAR RESULTADO
        // ==========================================

        if ($eventBusinessPrizeId !== null) {

            return $prizes->first() ?? [];

        }

        return $prizes->all();
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
