<?php

namespace App\Models\Events;

use App\Models\ModelManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use RuntimeException;
use Throwable;

class EventBusinessPrizeWinner extends ModelManager
{
    protected $table = 'event_business_prize_winner';

    protected $fillable = [
        'event_id',
        'event_business_prize_id',
        'user_id',
        'prize_code',

        // Estado de asignacion
        'state',

        // Gestion de notificacion
        'notification_status',
        'notification_attempts',
        'notification_email',
        'notification_error',
        'notification_sent_at',
        'notification_attempted_at',

        // Gestion de entrega
        'delivery_status',
        'delivery_at',
        'delivery_checked_at',
        'delivery_observation',
        'delivery_evidence',

        // Responsables
        'created_by',
        'delivery_checked_by',
    ];

    public $timestamps = true;

    protected $field_main = 'prize_code';

    // ==========================================
    // ESTADOS DE ASIGNACION
    // ==========================================

    const STATE_ACTIVE = 'ACTIVE';
    const STATE_CANCELLED = 'CANCELLED';

    // ==========================================
    // ESTADOS DE NOTIFICACION
    // ==========================================

    const NOTIFICATION_PENDING = 'PENDING';
    const NOTIFICATION_PROCESSING = 'PROCESSING';
    const NOTIFICATION_SENT = 'SENT';
    const NOTIFICATION_FAILED = 'FAILED';

    // ==========================================
    // ESTADOS DE ENTREGA
    // ==========================================

    const DELIVERY_PENDING = 'PENDING';
    const DELIVERY_DELIVERED = 'DELIVERED';
    const DELIVERY_NOT_DELIVERED = 'NOT_DELIVERED';
    const DELIVERY_EXPIRED = 'EXPIRED';

    // ==========================================
    // CONFIGURACIONES
    // ==========================================

    const TIMEZONE = 'America/Guayaquil';

    // ==========================================
    // VALORES PREDETERMINADOS
    // ==========================================

    protected $attributes = [
        'state' => self::STATE_ACTIVE,
        'notification_status' => self::NOTIFICATION_PENDING,
        'notification_attempts' => 0,
        'delivery_status' => self::DELIVERY_PENDING,
    ];

    // ==========================================
    // CONVERSION DE TIPOS
    // ==========================================

    protected $casts = [
        'id' => 'integer',
        'event_id' => 'integer',
        'event_business_prize_id' => 'integer',
        'user_id' => 'integer',

        'notification_attempts' => 'integer',
        'notification_sent_at' => 'datetime',
        'notification_attempted_at' => 'datetime',

        'delivery_at' => 'datetime',
        'delivery_checked_at' => 'datetime',

        'created_by' => 'integer',
        'delivery_checked_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==========================================
    // 1. RESPUESTA ESTANDAR
    // ==========================================

    private static function buildWinnerResponse(
        bool $success,
        string $message,
        string $step = 'COMPLETED',
        $data = null
    ): array {

        return [
            'success' => $success,
            'message' => $message,
            'step' => $step,
            'data' => $data,
        ];
    }

    // ==========================================
    // 2. GENERAR CODIGO DEL PREMIO
    // ==========================================

    private static function generatePrizeCode(
        int $eventId
    ): string {

        do {

            $code = sprintf(
                'YAP-PRZ-%04d-%s',
                $eventId,
                strtoupper(Str::random(12))
            );

            $exists = self::query()
                ->where('prize_code', $code)
                ->exists();

        } while ($exists);

        return $code;
    }

    // ==========================================
    // 3. CONSULTA BASE DE PREMIOS
    // ==========================================

    private static function getPrizeQuery()
    {
        return DB::table('event_business_prize as ep')

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

            ->whereIn('eb.participation_type', [
                'SPONSOR',
                'BOTH',
            ])

            ->where('eb.state', 'ACTIVE')
            ->where('ep.state', 'ACTIVE')
            ->where('b.status', 'ACTIVE')
            ->whereNull('b.deleted_at');
    }

    // ==========================================
    // 4. REGISTRAR GANADOR - PROCESO INTERNO
    // ==========================================

    private static function registerWinner(
        array $params,
        string &$step
    ): self {

        // ======================================
        // VALIDAR PARAMETROS
        // ======================================

        $step = 'VALIDATE_PARAMS';

        $eventId = (int) (
            $params['event_id'] ?? 0
        );

        $prizeId = (int) (
            $params['event_business_prize_id'] ?? 0
        );

        $userId = (int) (
            $params['user_id'] ?? 0
        );

        if (
            $eventId <= 0 ||
            $prizeId <= 0 ||
            $userId <= 0
        ) {
            throw new RuntimeException(
                'Los parámetros del ganador son incorrectos.'
            );
        }

        // ======================================
        // VALIDAR PREMIO Y EVENTO
        // ======================================

        $step = 'VALIDATE_PRIZE';

        $prize = self::getPrizeQuery()

            ->where('ep.id', $prizeId)
            ->where('eb.event_id', $eventId)

            ->select([
                'ep.id',
                'ep.name',
                'ep.start_at',
                'ep.end_at',
                'eb.event_id',
                'eb.business_id',
            ])

            ->lockForUpdate()
            ->first();

        if (!$prize) {

            throw new RuntimeException(
                'El premio no existe, no está activo '
                . 'o no pertenece al evento.'
            );
        }

        // ======================================
        // VALIDAR USUARIO
        // ======================================

        $step = 'VALIDATE_USER';

        $user = DB::table('users')
            ->where('id', $userId)
            ->select([
                'id',
                'name',
                'email',
            ])
            ->first();

        if (!$user) {

            throw new RuntimeException(
                'El usuario seleccionado no existe.'
            );
        }

        // ======================================
        // VALIDAR ASIGNACION EXISTENTE
        // ======================================

        $step = 'VALIDATE_ASSIGNMENT';

        $existingWinner = self::query()

            ->where(
                'event_business_prize_id',
                $prizeId
            )

            ->lockForUpdate()
            ->first();

        if ($existingWinner) {

            // Permitir reintentos de la misma asignacion

            if (
                (int) $existingWinner->event_id === $eventId &&
                (int) $existingWinner->user_id === $userId &&
                $existingWinner->state === self::STATE_ACTIVE
            ) {
                return $existingWinner;
            }

            throw new RuntimeException(
                'El premio ya tiene una asignación registrada.'
            );
        }

        // ======================================
        // GENERAR CODIGO
        // ======================================

        $step = 'GENERATE_PRIZE_CODE';

        $prizeCode = self::generatePrizeCode(
            $eventId
        );

        // ======================================
        // GUARDAR GANADOR
        // ======================================

        $step = 'REGISTER_WINNER';

        return self::query()->create([

            'event_id' => $eventId,

            'event_business_prize_id' => $prizeId,

            'user_id' => $userId,

            'prize_code' => $prizeCode,

            'state' => self::STATE_ACTIVE,

            'notification_status' =>
                self::NOTIFICATION_PENDING,

            'notification_attempts' => 0,

            'notification_email' => $user->email,

            'delivery_status' =>
                self::DELIVERY_PENDING,

            'created_by' => Auth::id(),

        ]);
    }

    // ==========================================
    // 5. REGISTRAR GANADOR INDIVIDUAL
    // ==========================================

    public static function saveWinner(
        array $params
    ): array {

        $step = 'INITIALIZATION';

        try {

            $winner = DB::transaction(
                function () use ($params, &$step) {

                    return self::registerWinner(
                        $params,
                        $step
                    );

                },
                3
            );

            return self::buildWinnerResponse(
                true,
                'Ganador registrado correctamente.',
                'COMPLETED',
                $winner->toArray()
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step
            );
        }
    }

    // ==========================================
    // 6. REGISTRAR GANADORES MASIVAMENTE
    // ==========================================

    public static function saveWinners(
        array $params
    ): array {

        $step = 'INITIALIZATION';

        $currentIndex = null;

        try {

            $step = 'VALIDATE_PARAMS';

            $eventId = (int) (
                $params['event_id'] ?? 0
            );

            $winners = $params['winners'] ?? [];

            if (
                $eventId <= 0 ||
                !is_array($winners) ||
                empty($winners)
            ) {

                throw new RuntimeException(
                    'No existen ganadores para registrar.'
                );
            }

            // ==================================
            // VALIDAR PREMIOS DUPLICADOS
            // ==================================

            $step = 'VALIDATE_DUPLICATED_PRIZES';

            $prizeIds = [];

            foreach ($winners as $index => $item) {

                $currentIndex = $index;

                if (!is_array($item)) {

                    throw new RuntimeException(
                        'La estructura de los ganadores '
                        . 'es incorrecta.'
                    );
                }

                $prizeIds[] = (int) (
                    $item['event_business_prize_id'] ?? 0
                );
            }

            if (
                count($prizeIds) !==
                count(array_unique($prizeIds))
            ) {

                throw new RuntimeException(
                    'Existen premios duplicados en la solicitud.'
                );
            }

            // ==================================
            // REGISTRAR TODOS LOS GANADORES
            // ==================================

            $data = DB::transaction(
                function () use (
                    $eventId,
                    $winners,
                    &$step,
                    &$currentIndex
                ) {

                    $registered = [];

                    foreach ($winners as $index => $item) {

                        $currentIndex = $index;

                        $winner = self::registerWinner([

                            'event_id' => $eventId,

                            'event_business_prize_id' =>
                                $item['event_business_prize_id'] ?? 0,

                            'user_id' =>
                                $item['user_id'] ?? 0,

                        ], $step);

                        $registered[] = $winner->toArray();
                    }

                    return $registered;

                },
                3
            );

            return self::buildWinnerResponse(
                true,
                'Ganadores registrados correctamente.',
                'COMPLETED',
                [
                    'event_id' => $eventId,
                    'total' => count($data),
                    'winners' => $data,
                ]
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step,
                [
                    'failed_index' => $currentIndex,
                ]
            );
        }
    }

    // ==========================================
    // 7. CONSULTA BASE DE GANADORES
    // ==========================================

    private static function getWinnerQuery()
    {
        return DB::table(
            'event_business_prize_winner as w'
        )

            ->join(
                'users as u',
                'u.id',
                '=',
                'w.user_id'
            )

            ->join(
                'event_business_prize as ep',
                'ep.id',
                '=',
                'w.event_business_prize_id'
            )

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

            ->join(
                'event as e',
                'e.id',
                '=',
                'w.event_id'
            )

            ->whereColumn(
                'w.event_id',
                'eb.event_id'
            )

            ->select([

                // Ganador

                'w.*',

                'e.name as event_name',

                'u.name as user_name',
                'u.email as user_email',
                'u.avatar as user_avatar',
                'u.provider as user_provider',

                // Premio

                'ep.name as prize_name',
                'ep.description as prize_description',
                'ep.source as prize_source',
                'ep.start_at as prize_start_at',
                'ep.end_at as prize_end_at',
                'ep.state as prize_state',

                // Empresa

                'b.id as business_id',
                'b.title as business_name',
                'b.source as business_logo',
                'b.phone_value as business_phone',

                'b.street_1 as business_street_1',
                'b.street_2 as business_street_2',

                'b.street_lat as business_street_lat',
                'b.street_lng as business_street_lng',

            ]);
    }

    // ==========================================
    // 8. FORMATEAR INFORMACION DEL GANADOR
    // ==========================================

    private static function formatWinner(
        object $row
    ): array {

        $data = (array) $row;

        $data['id'] = (int) $row->id;

        $data['event_id'] = (int) $row->event_id;

        $data['user_id'] = (int) $row->user_id;

        $data['event_business_prize_id'] =
            (int) $row->event_business_prize_id;

        $data['business_id'] =
            (int) $row->business_id;

        $data['notification_attempts'] =
            (int) $row->notification_attempts;

        // ======================================
        // AVATAR
        // ======================================

        $data['user_avatar'] =
            $row->user_provider === 'google'
                ? ($row->user_avatar ?? '')
                : '';

        // ======================================
        // IMAGENES
        // ======================================

        $data['prize_source'] = $row->prize_source
            ? self::getUploadUrl($row->prize_source)
            : null;

        $data['business_logo'] = $row->business_logo
            ? self::getUploadUrl($row->business_logo)
            : null;

        // ======================================
        // DIRECCION
        // ======================================

        $address = array_filter([
            $row->business_street_1,
            $row->business_street_2,
        ]);

        $data['business_address'] = implode(
            ' - ',
            $address
        );

        // ======================================
        // GOOGLE MAPS
        // ======================================

        $data['business_maps_url'] = null;

        if (
            is_numeric($row->business_street_lat) &&
            is_numeric($row->business_street_lng) &&
            abs((float) $row->business_street_lat) <= 90 &&
            abs((float) $row->business_street_lng) <= 180
        ) {

            $coordinates = sprintf(
                '%s,%s',
                $row->business_street_lat,
                $row->business_street_lng
            );

            $data['business_maps_url'] =
                'https://www.google.com/maps/search/?api=1&query='
                . urlencode($coordinates);
        }

        // ======================================
        // VIGENCIA DEL PREMIO
        // ======================================

        $now = Carbon::now(self::TIMEZONE);

        $startAt = Carbon::parse(
            $row->prize_start_at,
            self::TIMEZONE
        );

        $endAt = Carbon::parse(
            $row->prize_end_at,
            self::TIMEZONE
        );

        if ($now->lt($startAt)) {

            $data['prize_status'] = 'UPCOMING';

        } elseif ($now->gt($endAt)) {

            $data['prize_status'] = 'EXPIRED';

        } else {

            $data['prize_status'] = 'ACTIVE';
        }

        // ======================================
        // ACCIONES DISPONIBLES
        // ======================================

        $isActive =
            $row->state === self::STATE_ACTIVE;

        $isProcessing =
            $row->notification_status ===
            self::NOTIFICATION_PROCESSING;

        $isDelivered =
            $row->delivery_status ===
            self::DELIVERY_DELIVERED;

        $data['can_send_notification'] =
            $isActive &&
            $row->delivery_status === self::DELIVERY_PENDING &&
            $row->prize_state === 'ACTIVE' &&
            $data['prize_status'] !== 'EXPIRED' &&
            in_array(
                $row->notification_status,
                [
                    self::NOTIFICATION_PENDING,
                    self::NOTIFICATION_FAILED,
                ],
                true
            );

        $data['can_manage_delivery'] =
            $isActive &&
            !$isDelivered &&
            !$isProcessing;

        $data['can_cancel'] =
            $isActive &&
            !$isDelivered &&
            !$isProcessing;

        $data['is_delivered'] = $isDelivered;

        $data['is_notified'] =
            $row->notification_status ===
            self::NOTIFICATION_SENT;

        return $data;
    }

    // ==========================================
    // 9. CONSULTAR GANADORES POR EVENTO
    // ==========================================

    public static function getWinnersByEventId(
        int $eventId,
        array $filters = []
    ): array {

        if ($eventId <= 0) {
            return [];
        }

        $query = self::getWinnerQuery()
            ->where('w.event_id', $eventId);

        // ======================================
        // FILTROS
        // ======================================

        $allowedFilters = [
            'state',
            'notification_status',
            'delivery_status',
            'user_id',
            'event_business_prize_id',
        ];

        foreach ($allowedFilters as $field) {

            if (
                isset($filters[$field]) &&
                $filters[$field] !== ''
            ) {

                $query->where(
                    'w.' . $field,
                    $filters[$field]
                );
            }
        }

        if (!empty($filters['business_id'])) {

            $query->where(
                'eb.business_id',
                (int) $filters['business_id']
            );
        }

        // ======================================
        // BUSQUEDA
        // ======================================

        $search = trim(
            $filters['search'] ?? ''
        );

        if ($search !== '') {

            $query->where(
                function ($q) use ($search) {

                    $value = '%' . $search . '%';

                    $q->where('u.name', 'like', $value)
                        ->orWhere('u.email', 'like', $value)
                        ->orWhere('ep.name', 'like', $value)
                        ->orWhere('b.title', 'like', $value)
                        ->orWhere('w.prize_code', 'like', $value);
                }
            );
        }

        return $query
            ->orderBy('w.id', 'desc')
            ->get()
            ->map(function ($row) {

                return self::formatWinner($row);

            })
            ->all();
    }

    // ==========================================
    // 10. CONSULTAR GANADOR POR ID
    // ==========================================

    public static function getWinnerById(
        int $winnerId
    ): ?array {

        if ($winnerId <= 0) {
            return null;
        }

        $row = self::getWinnerQuery()

            ->where('w.id', $winnerId)

            ->first();

        return $row
            ? self::formatWinner($row)
            : null;
    }

    // ==========================================
    // 11. CONSULTAR GANADOR POR CODIGO
    // ==========================================

    public static function getWinnerByPrizeCode(
        string $prizeCode
    ): ?array {

        $prizeCode = strtoupper(
            trim($prizeCode)
        );

        if ($prizeCode === '') {
            return null;
        }

        $row = self::getWinnerQuery()

            ->where('w.prize_code', $prizeCode)

            ->first();

        return $row
            ? self::formatWinner($row)
            : null;
    }

    // ==========================================
    // 12. CONSULTAR PREMIOS DISPONIBLES
    // ==========================================

    public static function getAvailablePrizesByEventId(
        int $eventId
    ): array {

        if ($eventId <= 0) {
            return [];
        }

        return self::getPrizeQuery()

            ->leftJoin(
                'event_business_prize_winner as w',
                'w.event_business_prize_id',
                '=',
                'ep.id'
            )

            ->where('eb.event_id', $eventId)

            ->whereNull('w.id')

            ->select([

                'ep.id',
                'eb.event_id',

                'ep.name',
                'ep.description',
                'ep.source',

                'ep.start_at',
                'ep.end_at',
                'ep.state',

                'b.id as business_id',
                'b.title as business_name',
                'b.source as business_logo',

            ])

            ->orderBy('b.title')
            ->orderBy('ep.id')

            ->get()

            ->map(function ($row) {

                $data = (array) $row;

                $data['id'] = (int) $row->id;

                $data['event_id'] =
                    (int) $row->event_id;

                $data['business_id'] =
                    (int) $row->business_id;

                $data['source'] = $row->source
                    ? self::getUploadUrl($row->source)
                    : null;

                $data['business_logo'] =
                    $row->business_logo
                        ? self::getUploadUrl($row->business_logo)
                        : null;

                $data['is_assigned'] = false;

                return $data;

            })->all();
    }

    // ==========================================
    // 13. CONSULTAR NOTIFICACIONES PENDIENTES
    // ==========================================

    public static function getPendingNotifications(
        int $eventId,
        int $limit = 30
    ): array {

        if ($eventId <= 0) {
            return [];
        }

        $limit = max(1, min($limit, 100));

        return self::getWinnerQuery()

            ->where('w.event_id', $eventId)

            ->where(
                'w.state',
                self::STATE_ACTIVE
            )

            ->where(
                'w.delivery_status',
                self::DELIVERY_PENDING
            )

            ->whereIn(
                'w.notification_status',
                [
                    self::NOTIFICATION_PENDING,
                    self::NOTIFICATION_FAILED,
                ]
            )

            ->where('ep.state', 'ACTIVE')

            ->where(
                'ep.end_at',
                '>=',
                Carbon::now(self::TIMEZONE)
                    ->toDateTimeString()
            )

            ->orderBy('w.id', 'asc')

            ->limit($limit)

            ->get()

            ->map(function ($row) {

                return self::formatWinner($row);

            })->all();
    }

    // ==========================================
    // 14. ACTUALIZAR CORREO DEL GANADOR
    // ==========================================

    public static function updateNotificationEmail(
        array $params
    ): array {

        $step = 'VALIDATE_PARAMS';

        try {

            $winnerId = (int) (
                $params['id'] ?? 0
            );

            $email = trim(
                $params['notification_email'] ?? ''
            );

            if (
                $winnerId <= 0 ||
                strlen($email) > 255 ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
            ) {

                throw new RuntimeException(
                    'El correo electrónico es incorrecto.'
                );
            }

            $data = DB::transaction(
                function () use (
                    $winnerId,
                    $email,
                    &$step
                ) {

                    $step = 'GET_WINNER';

                    $winner = self::query()

                        ->where('id', $winnerId)

                        ->lockForUpdate()
                        ->first();

                    if (
                        !$winner ||
                        $winner->state !== self::STATE_ACTIVE
                    ) {

                        throw new RuntimeException(
                            'La asignación no está disponible.'
                        );
                    }

                    if (
                        !in_array(
                            $winner->notification_status,
                            [
                                self::NOTIFICATION_PENDING,
                                self::NOTIFICATION_FAILED,
                            ],
                            true
                        )
                    ) {

                        throw new RuntimeException(
                            'No se puede modificar el correo '
                            . 'en el estado actual.'
                        );
                    }

                    $step = 'UPDATE_EMAIL';

                    $winner->update([

                        'notification_email' => $email,

                        'notification_status' =>
                            self::NOTIFICATION_PENDING,

                        'notification_error' => null,

                    ]);

                    return $winner->toArray();

                },
                3
            );

            return self::buildWinnerResponse(
                true,
                'Correo actualizado correctamente.',
                'COMPLETED',
                $data
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step
            );
        }
    }

    // ==========================================
    // 15. ENVIAR NOTIFICACION INDIVIDUAL
    // ==========================================

    public static function sendWinnerNotification(
        int $winnerId,
        callable $mailFactory
    ): array {

        $step = 'INITIALIZATION';

        $reserved = false;

        $transportAccepted = false;

        $attempt = null;

        try {

            if ($winnerId <= 0) {

                throw new RuntimeException(
                    'El identificador es incorrecto.'
                );
            }

            // El correo no debe enviarse dentro
            // de una transaccion externa.

            if (DB::transactionLevel() > 0) {

                throw new RuntimeException(
                    'El envío debe ejecutarse fuera '
                    . 'de una transacción externa.'
                );
            }

            // ==================================
            // RESERVAR PROCESO DE ENVIO
            // ==================================

            $step = 'RESERVE_NOTIFICATION';

            $reservation = DB::transaction(
                function () use ($winnerId) {

                    $winner = self::query()

                        ->where('id', $winnerId)

                        ->lockForUpdate()
                        ->first();

                    if (!$winner) {

                        throw new RuntimeException(
                            'El ganador no existe.'
                        );
                    }

                    if (
                        $winner->state !== self::STATE_ACTIVE
                    ) {

                        throw new RuntimeException(
                            'La asignación está cancelada.'
                        );
                    }

                    if (
                        $winner->notification_status ===
                        self::NOTIFICATION_SENT
                    ) {

                        return [
                            'already_sent' => true,
                            'data' => $winner->toArray(),
                        ];
                    }

                    if (
                        $winner->notification_status ===
                        self::NOTIFICATION_PROCESSING
                    ) {

                        throw new RuntimeException(
                            'El correo se está procesando.'
                        );
                    }

                    $data = self::getWinnerById(
                        $winnerId
                    );

                    if (
                        !$data ||
                        !$data['can_send_notification']
                    ) {

                        throw new RuntimeException(
                            'No se puede notificar este premio '
                            . 'en el estado actual.'
                        );
                    }

                    $email = trim(
                        $winner->notification_email ?? ''
                    );

                    if (
                        !filter_var(
                            $email,
                            FILTER_VALIDATE_EMAIL
                        )
                    ) {

                        throw new RuntimeException(
                            'El ganador no tiene un correo válido.'
                        );
                    }

                    $attempt =
                        $winner->notification_attempts + 1;

                    $winner->update([

                        'notification_status' =>
                            self::NOTIFICATION_PROCESSING,

                        'notification_attempts' => $attempt,

                        'notification_attempted_at' => now(),

                        'notification_error' => null,

                    ]);

                    return [
                        'already_sent' => false,
                        'email' => $email,
                        'attempt' => $attempt,
                        'data' => $data,
                    ];

                },
                3
            );

            if ($reservation['already_sent']) {

                return self::buildWinnerResponse(
                    true,
                    'El ganador ya fue notificado.',
                    'ALREADY_SENT',
                    $reservation['data']
                );
            }

            $reserved = true;

            $attempt = $reservation['attempt'];

            // ==================================
            // CONSTRUIR MAIL
            // ==================================

            $step = 'BUILD_MAIL';

            $mail = $mailFactory(
                $reservation['data']
            );

            if (!$mail instanceof Mailable) {

                throw new RuntimeException(
                    'La función debe retornar un Mailable.'
                );
            }

            // ==================================
            // ENVIAR CORREO SIN TRANSACCION
            // ==================================

            $step = 'SEND_MAIL';

            $sentMessage = Mail::to(
                $reservation['email']
            )->sendNow($mail);

            if ($sentMessage === null) {

                throw new RuntimeException(
                    'El transporte no confirmó el envío.'
                );
            }

            $transportAccepted = true;

            // ==================================
            // CONFIRMAR RESULTADO DEL ENVIO
            // ==================================

            $step = 'UPDATE_NOTIFICATION_STATUS';

            $updated = self::query()

                ->where('id', $winnerId)

                ->where(
                    'notification_status',
                    self::NOTIFICATION_PROCESSING
                )

                ->where(
                    'notification_attempts',
                    $attempt
                )

                ->update([

                    'notification_status' =>
                        self::NOTIFICATION_SENT,

                    'notification_sent_at' => now(),

                    'notification_error' => null,

                ]);

            if ($updated !== 1) {

                throw new RuntimeException(
                    'No se pudo confirmar el estado del envío.'
                );
            }

            return self::buildWinnerResponse(
                true,
                'Correo aceptado por el transporte correctamente.',
                'COMPLETED',
                [
                    'id' => $winnerId,
                    'notification_status' =>
                        self::NOTIFICATION_SENT,
                    'notification_attempts' => $attempt,
                ]
            );

        } catch (Throwable $e) {

            // Si el transporte ya acepto el correo,
            // no marcar FAILED automaticamente.
            // Evita un reenvio inmediato duplicado.

            if ($transportAccepted) {

                return self::buildWinnerResponse(
                    false,
                    'El transporte aceptó el correo, pero '
                    . 'no se pudo confirmar el registro del envío.',
                    $step,
                    [
                        'id' => $winnerId,
                        'requires_review' => true,
                        'transport_accepted' => true,
                    ]
                );
            }

            if ($reserved) {

                try {

                    self::query()

                        ->where('id', $winnerId)

                        ->where(
                            'notification_status',
                            self::NOTIFICATION_PROCESSING
                        )

                        ->where(
                            'notification_attempts',
                            $attempt
                        )

                        ->update([

                            'notification_status' =>
                                self::NOTIFICATION_FAILED,

                            'notification_error' =>
                                Str::limit(
                                    $e->getMessage(),
                                    4000,
                                    ''
                                ),

                        ]);

                } catch (Throwable $updateException) {

                    return self::buildWinnerResponse(
                        false,
                        'No se pudo guardar el error del envío.',
                        'SAVE_NOTIFICATION_ERROR',
                        [
                            'id' => $winnerId,
                            'requires_review' => true,
                        ]
                    );
                }
            }

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step,
                [
                    'id' => $winnerId,
                ]
            );
        }
    }

    // ==========================================
    // 16. ENVIAR NOTIFICACIONES MASIVAMENTE
    // ==========================================

    public static function sendPendingNotifications(
        int $eventId,
        callable $mailFactory,
        int $limit = 30
    ): array {

        $step = 'GET_PENDING_NOTIFICATIONS';

        try {

            $winners = self::getPendingNotifications(
                $eventId,
                $limit
            );

            $results = [];

            $sent = 0;

            $failed = 0;

            $skipped = 0;

            $step = 'SEND_NOTIFICATIONS';

            foreach ($winners as $winner) {

                $result = self::sendWinnerNotification(
                    (int) $winner['id'],
                    $mailFactory
                );

                if (
                    $result['success'] &&
                    $result['step'] === 'ALREADY_SENT'
                ) {

                    $skipped++;

                } elseif ($result['success']) {

                    $sent++;

                } else {

                    $failed++;
                }

                $results[] = [

                    'id' => $winner['id'],

                    'user_name' =>
                        $winner['user_name'],

                    'email' =>
                        $winner['notification_email'],

                    'prize_name' =>
                        $winner['prize_name'],

                    'result' => $result,

                ];
            }

            return self::buildWinnerResponse(
                $failed === 0,
                empty($winners)
                    ? 'No existen notificaciones pendientes.'
                    : 'Proceso de notificaciones finalizado.',
                'COMPLETED',
                [
                    'event_id' => $eventId,

                    'total' => count($winners),

                    'sent' => $sent,

                    'failed' => $failed,

                    'skipped' => $skipped,

                    'results' => $results,
                ]
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step
            );
        }
    }

    // ==========================================
    // 17. ACTUALIZAR ESTADO DE ENTREGA
    // ==========================================

    public static function updateDeliveryStatus(
        array $params
    ): array {

        $step = 'INITIALIZATION';

        try {

            $step = 'VALIDATE_PARAMS';

            $winnerId = (int) (
                $params['id'] ?? 0
            );

            $status = strtoupper(
                trim(
                    $params['delivery_status'] ?? ''
                )
            );

            $observation = trim(
                $params['delivery_observation'] ?? ''
            );

            $evidence =
                $params['delivery_evidence'] ?? null;

            $allowedStatuses = [

                self::DELIVERY_PENDING,

                self::DELIVERY_DELIVERED,

                self::DELIVERY_NOT_DELIVERED,

                self::DELIVERY_EXPIRED,

            ];

            if (
                $winnerId <= 0 ||
                !in_array(
                    $status,
                    $allowedStatuses,
                    true
                )
            ) {

                throw new RuntimeException(
                    'Los parámetros de entrega son incorrectos.'
                );
            }

            if (
                $evidence !== null &&
                (
                    !is_string($evidence) ||
                    mb_strlen($evidence) > 500
                )
            ) {

                throw new RuntimeException(
                    'La evidencia de entrega es incorrecta.'
                );
            }

            if (
                in_array(
                    $status,
                    [
                        self::DELIVERY_NOT_DELIVERED,
                        self::DELIVERY_EXPIRED,
                    ],
                    true
                ) &&
                $observation === ''
            ) {

                throw new RuntimeException(
                    'Debe ingresar una observación.'
                );
            }

            $data = DB::transaction(
                function () use (
                    $winnerId,
                    $status,
                    $observation,
                    $evidence,
                    &$step
                ) {

                    // ==========================
                    // CONSULTAR GANADOR
                    // ==========================

                    $step = 'GET_WINNER';

                    $winner = self::query()

                        ->where('id', $winnerId)

                        ->lockForUpdate()
                        ->first();

                    if (!$winner) {

                        throw new RuntimeException(
                            'El ganador no existe.'
                        );
                    }

                    if (
                        $winner->state !== self::STATE_ACTIVE
                    ) {

                        throw new RuntimeException(
                            'La asignación está cancelada.'
                        );
                    }

                    if (
                        $winner->notification_status ===
                        self::NOTIFICATION_PROCESSING
                    ) {

                        throw new RuntimeException(
                            'Existe una notificación en proceso.'
                        );
                    }

                    if (
                        $winner->delivery_status ===
                        self::DELIVERY_DELIVERED
                    ) {

                        if (
                            $status ===
                            self::DELIVERY_DELIVERED
                        ) {
                            return $winner->toArray();
                        }

                        throw new RuntimeException(
                            'El premio ya fue entregado.'
                        );
                    }

                    // ==========================
                    // VALIDAR VENCIMIENTO
                    // ==========================

                    if (
                        $status === self::DELIVERY_EXPIRED
                    ) {

                        $prize = DB::table(
                            'event_business_prize'
                        )
                            ->where(
                                'id',
                                $winner->event_business_prize_id
                            )
                            ->first();

                        if (
                            !$prize ||
                            !Carbon::now(self::TIMEZONE)->gt(
                                Carbon::parse(
                                    $prize->end_at,
                                    self::TIMEZONE
                                )
                            )
                        ) {

                            throw new RuntimeException(
                                'El premio todavía no ha vencido.'
                            );
                        }
                    }

                    // ==========================
                    // ACTUALIZAR ENTREGA
                    // ==========================

                    $step = 'UPDATE_DELIVERY_STATUS';

                    $winner->update([

                        'delivery_status' => $status,

                        'delivery_at' =>
                            $status === self::DELIVERY_DELIVERED
                                ? now()
                                : null,

                        'delivery_checked_at' => now(),

                        'delivery_observation' =>
                            $observation,

                        'delivery_evidence' =>
                            $evidence ?? $winner->delivery_evidence,

                        'delivery_checked_by' => Auth::id(),

                    ]);

                    return $winner->toArray();

                },
                3
            );

            return self::buildWinnerResponse(
                true,
                'Estado de entrega actualizado correctamente.',
                'COMPLETED',
                $data
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step
            );
        }
    }

    // ==========================================
    // 18. CANCELAR ASIGNACION
    // ==========================================

    public static function cancelWinner(
        array $params
    ): array {

        $step = 'VALIDATE_PARAMS';

        try {

            $winnerId = (int) (
                $params['id'] ?? 0
            );

            $observation = trim(
                $params['observation'] ?? ''
            );

            if (
                $winnerId <= 0 ||
                $observation === ''
            ) {

                throw new RuntimeException(
                    'Debe indicar el ganador y '
                    . 'el motivo de cancelación.'
                );
            }

            $data = DB::transaction(
                function () use (
                    $winnerId,
                    $observation,
                    &$step
                ) {

                    $step = 'GET_WINNER';

                    $winner = self::query()

                        ->where('id', $winnerId)

                        ->lockForUpdate()
                        ->first();

                    if (!$winner) {

                        throw new RuntimeException(
                            'El ganador no existe.'
                        );
                    }

                    if (
                        $winner->state === self::STATE_CANCELLED
                    ) {

                        return $winner->toArray();
                    }

                    if (
                        $winner->delivery_status ===
                        self::DELIVERY_DELIVERED
                    ) {

                        throw new RuntimeException(
                            'No se puede cancelar un premio entregado.'
                        );
                    }

                    if (
                        $winner->notification_status ===
                        self::NOTIFICATION_PROCESSING
                    ) {

                        throw new RuntimeException(
                            'Existe una notificación en proceso.'
                        );
                    }

                    $step = 'CANCEL_WINNER';

                    $previousObservation = trim(
                        $winner->delivery_observation ?? ''
                    );

                    $winner->update([

                        'state' => self::STATE_CANCELLED,

                        'delivery_observation' =>
                            trim(
                                $previousObservation
                                . "\nCANCELACIÓN: "
                                . $observation
                            ),

                        'delivery_checked_at' => now(),

                        'delivery_checked_by' => Auth::id(),

                    ]);

                    return $winner->toArray();

                },
                3
            );

            return self::buildWinnerResponse(
                true,
                'Asignación cancelada correctamente.',
                'COMPLETED',
                $data
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step
            );
        }
    }

    // ==========================================
    // 19. CONSULTAR ENVIOS INTERRUMPIDOS
    // ==========================================

    public static function getInterruptedNotifications(
        int $eventId,
        int $minutes = 15
    ): array {

        if ($eventId <= 0) {
            return [];
        }

        $minutes = max(1, $minutes);

        return self::getWinnerQuery()

            ->where('w.event_id', $eventId)

            ->where(
                'w.notification_status',
                self::NOTIFICATION_PROCESSING
            )

            ->where(
                'w.notification_attempted_at',
                '<=',
                now()->subMinutes($minutes)
            )

            ->orderBy('w.id')

            ->get()

            ->map(function ($row) {

                return self::formatWinner($row);

            })->all();
    }

    // ==========================================
    // 20. RESOLVER NOTIFICACION INTERRUMPIDA
    // ==========================================

    public static function resolveInterruptedNotification(
        array $params
    ): array {

        $step = 'VALIDATE_PARAMS';

        try {

            $winnerId = (int) (
                $params['id'] ?? 0
            );

            $status = strtoupper(
                $params['notification_status'] ?? ''
            );

            $observation = trim(
                $params['observation'] ?? ''
            );

            $confirmedStopped =
                ($params['confirmed_stopped'] ?? false) === true;

            if (
                $winnerId <= 0 ||
                !$confirmedStopped ||
                $observation === '' ||
                !in_array(
                    $status,
                    [
                        self::NOTIFICATION_SENT,
                        self::NOTIFICATION_FAILED,
                    ],
                    true
                )
            ) {

                throw new RuntimeException(
                    'Debe confirmar que el proceso terminó '
                    . 'e indicar el resultado de la revisión.'
                );
            }

            $data = DB::transaction(
                function () use (
                    $winnerId,
                    $status,
                    $observation,
                    &$step
                ) {

                    $step = 'GET_WINNER';

                    $winner = self::query()

                        ->where('id', $winnerId)

                        ->lockForUpdate()
                        ->first();

                    if (
                        !$winner ||
                        $winner->notification_status !==
                        self::NOTIFICATION_PROCESSING
                    ) {

                        throw new RuntimeException(
                            'No existe una notificación '
                            . 'en procesamiento.'
                        );
                    }

                    $step = 'RESOLVE_NOTIFICATION';

                    $winner->update([

                        'notification_status' => $status,

                        'notification_sent_at' =>
                            $status === self::NOTIFICATION_SENT
                                ? (
                                $winner->notification_sent_at
                                ?? $winner->notification_attempted_at
                            )
                                : null,

                        'notification_error' =>
                            'REVISIÓN MANUAL: ' . $observation,

                    ]);

                    return $winner->toArray();

                },
                3
            );

            return self::buildWinnerResponse(
                true,
                'Notificación revisada correctamente.',
                'COMPLETED',
                $data
            );

        } catch (Throwable $e) {

            return self::buildWinnerResponse(
                false,
                $e->getMessage(),
                $step
            );
        }
    }

    // ==========================================
    // 21. RESUMEN GENERAL DEL EVENTO
    // ==========================================

    public static function getEventWinnerSummary(
        int $eventId
    ): array {

        if ($eventId <= 0) {
            return [];
        }

        // ======================================
        // PREMIOS ACTIVOS DEL EVENTO
        // ======================================

        $totalPrizes = self::getPrizeQuery()

            ->where('eb.event_id', $eventId)

            ->count('ep.id');

        // ======================================
        // PREMIOS SIN ASIGNACION
        // ======================================

        $availablePrizes = self::getPrizeQuery()

            ->where('eb.event_id', $eventId)

            ->leftJoin(
                'event_business_prize_winner as w',
                'w.event_business_prize_id',
                '=',
                'ep.id'
            )

            ->whereNull('w.id')

            ->count('ep.id');

        // ======================================
        // GANADORES DEL EVENTO
        // ======================================

        $winners = self::query()

            ->where('event_id', $eventId)

            ->get();

        $active = $winners->where(
            'state',
            self::STATE_ACTIVE
        );

        $cancelled = $winners->where(
            'state',
            self::STATE_CANCELLED
        );

        $totalActive = $active->count();

        // ======================================
        // NOTIFICACIONES
        // ======================================

        $notificationPending = $active->where(
            'notification_status',
            self::NOTIFICATION_PENDING
        )->count();

        $notificationProcessing = $active->where(
            'notification_status',
            self::NOTIFICATION_PROCESSING
        )->count();

        $notificationSent = $active->where(
            'notification_status',
            self::NOTIFICATION_SENT
        )->count();

        $notificationFailed = $active->where(
            'notification_status',
            self::NOTIFICATION_FAILED
        )->count();

        // ======================================
        // ENTREGAS
        // ======================================

        $deliveryPending = $active->where(
            'delivery_status',
            self::DELIVERY_PENDING
        )->count();

        $deliveryDelivered = $active->where(
            'delivery_status',
            self::DELIVERY_DELIVERED
        )->count();

        $deliveryNotDelivered = $active->where(
            'delivery_status',
            self::DELIVERY_NOT_DELIVERED
        )->count();

        $deliveryExpired = $active->where(
            'delivery_status',
            self::DELIVERY_EXPIRED
        )->count();

        // ======================================
        // PORCENTAJES
        // ======================================

        $notificationPercentage = $totalActive > 0
            ? round(
                ($notificationSent / $totalActive) * 100,
                2
            )
            : 0;

        $deliveryPercentage = $totalActive > 0
            ? round(
                ($deliveryDelivered / $totalActive) * 100,
                2
            )
            : 0;

        // ======================================
        // RESULTADO GENERAL
        // ======================================

        return [

            'event_id' => $eventId,

            'prizes' => [

                'total' => $totalPrizes,

                'available' => $availablePrizes,

                'assigned' =>
                    $totalPrizes - $availablePrizes,

            ],

            'winners' => [

                'total' => $winners->count(),

                'active' => $totalActive,

                'cancelled' => $cancelled->count(),

                'unique_users' =>
                    $active->pluck('user_id')
                        ->unique()
                        ->count(),

            ],

            'notifications' => [

                'pending' => $notificationPending,

                'processing' => $notificationProcessing,

                'sent' => $notificationSent,

                'failed' => $notificationFailed,

                'percentage' => $notificationPercentage,

            ],

            'delivery' => [

                'pending' => $deliveryPending,

                'delivered' => $deliveryDelivered,

                'not_delivered' => $deliveryNotDelivered,

                'expired' => $deliveryExpired,

                'percentage' => $deliveryPercentage,

            ],

        ];
    }
    public static function updateNotificationStatus(
        array $params
    ): array {

        try {

            $eventId = (int) $params['event_id'];

            $eventBusinessPrizeId =
                (int) $params['event_business_prize_id'];

            $userId = (int) $params['user_id'];

            $notificationStatus = $params['notification_status'];

            $isSent = $notificationStatus === self::NOTIFICATION_SENT;

            // ==========================================
            // 1. VALIDAR ESTADO DE NOTIFICACION
            // ==========================================

            if (!in_array($notificationStatus, [
                self::NOTIFICATION_SENT,
                self::NOTIFICATION_FAILED,
            ], true)) {

                return [
                    'success' => false,
                    'message' => 'Estado de notificación inválido.',
                ];
            }

            $now = now('America/Guayaquil');

            // ==========================================
            // 2. ACTUALIZAR NOTIFICACION
            // ==========================================

            $updated = DB::table('event_business_prize_winner')

                ->where('event_id', $eventId)

                ->where(
                    'event_business_prize_id',
                    $eventBusinessPrizeId
                )

                ->where('user_id', $userId)

                ->where('state', self::STATE_ACTIVE)

                ->where('notification_status', '!=', self::NOTIFICATION_SENT)

                ->update([

                    'notification_status' =>
                        $notificationStatus,

                    'notification_attempts' =>
                        DB::raw('notification_attempts + 1'),

                    'notification_email' =>
                        $params['notification_email'] ?? null,

                    'notification_error' =>
                        $isSent
                            ? null
                            : ($params['notification_error'] ?? null),

                    'notification_sent_at' =>
                        $isSent ? $now : null,

                    'notification_attempted_at' =>
                        $now,

                    'updated_at' => $now,

                ]);

            // ==========================================
            // 3. RESPUESTA
            // ==========================================

            return [

                'success' => $updated > 0,

                'message' => $updated > 0

                    ? 'Notificación actualizada correctamente.'

                    : 'No existe una asignación disponible para actualizar.',

                'data' => [
                    'affected_rows' => $updated,
                    'notification_status' => $notificationStatus,
                ],

            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Error al actualizar la notificación.',
                'data' => null,
            ];
        }
    }

    public static function updateNotificationStatus2(
        array $params
    ): array {

        $eventId = (int) ($params['event_id'] ?? 0);

        $eventBusinessPrizeId = (int) (
            $params['event_business_prize_id'] ?? 0
        );

        $userId = (int) ($params['user_id'] ?? 0);

        $status = $params['notification_status'] ?? null;

        // ==========================================
        // 1. VALIDAR PARAMETROS
        // ==========================================

        if (
            $eventId <= 0 ||
            $eventBusinessPrizeId <= 0 ||
            $userId <= 0
        ) {
            return [
                'success' => false,
                'message' => 'Identificadores inválidos.',
            ];
        }

        if (!in_array($status, [
            self::NOTIFICATION_PROCESSING,
            self::NOTIFICATION_SENT,
            self::NOTIFICATION_FAILED,
        ], true)) {

            return [
                'success' => false,
                'message' => 'Estado de notificación inválido.',
            ];
        }

        try {

            return DB::transaction(function () use (
                $eventId,
                $eventBusinessPrizeId,
                $userId,
                $status,
                $params
            ) {

                // ==================================
                // 2. CONSULTAR ASIGNACION
                // ==================================

                $winner = self::query()

                    ->where('event_id', $eventId)

                    ->where(
                        'event_business_prize_id',
                        $eventBusinessPrizeId
                    )

                    ->where('user_id', $userId)

                    ->where('state', self::STATE_ACTIVE)

                    ->lockForUpdate()

                    ->first();

                if (!$winner) {

                    return [
                        'success' => false,
                        'message' => 'No existe una asignación activa.',
                    ];
                }

                // ==================================
                // 3. CONFIGURAR FECHA
                // ==================================

                $now = now('America/Guayaquil');

                $currentStatus = $winner->notification_status;

                // ==================================
                // 4. PROCESAR ESTADO
                // ==================================

                switch ($status) {

                    case self::NOTIFICATION_PROCESSING:

                        if (!in_array($currentStatus, [
                            self::NOTIFICATION_PENDING,
                            self::NOTIFICATION_FAILED,
                        ], true)) {

                            return [
                                'success' => false,
                                'message' => 'La notificación ya fue enviada o está procesándose.',
                            ];
                        }

                        if (
                            $winner->delivery_status !==
                            self::DELIVERY_PENDING
                        ) {
                            return [
                                'success' => false,
                                'message' => 'El premio no está pendiente de entrega.',
                            ];
                        }

                        $email = trim(
                            (string) ($params['notification_email'] ?? '')
                        );

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                            return [
                                'success' => false,
                                'message' => 'Correo electrónico inválido.',
                            ];
                        }

                        $winner->notification_attempts =
                            (int) $winner->notification_attempts + 1;

                        $winner->notification_email = $email;

                        $winner->notification_attempted_at = $now;

                        $winner->notification_error = null;

                        break;

                    case self::NOTIFICATION_SENT:

                    case self::NOTIFICATION_FAILED:

                        if (
                            $currentStatus !== self::NOTIFICATION_PROCESSING ||
                            (int) ($params['notification_attempts'] ?? 0)
                            !== (int) $winner->notification_attempts
                        ) {

                            return [
                                'success' => false,
                                'message' => 'El intento de notificación no corresponde al proceso actual.',
                            ];
                        }

                        if ($status === self::NOTIFICATION_SENT) {

                            $winner->notification_sent_at = $now;

                            $winner->notification_error = null;

                        } else {

                            $winner->notification_error =
                                $params['notification_error']
                                ?? 'Error al enviar el correo.';
                        }

                        break;
                }

                // ==================================
                // 5. GUARDAR INFORMACION
                // ==================================

                $winner->notification_status = $status;

                $winner->updated_at = $now;

                $winner->save();

                // ==================================
                // 6. RESPUESTA
                // ==================================

                return [

                    'success' => true,

                    'message' =>
                        'Notificación actualizada correctamente.',

                    'data' => [

                        'id' => (int) $winner->id,

                        'event_id' =>
                            (int) $winner->event_id,

                        'event_business_prize_id' =>
                            (int) $winner->event_business_prize_id,

                        'user_id' =>
                            (int) $winner->user_id,

                        'notification_status' =>
                            $winner->notification_status,

                        'notification_attempts' =>
                            (int) $winner->notification_attempts,

                        'notification_email' =>
                            $winner->notification_email,

                        'notification_error' =>
                            $winner->notification_error,

                        'notification_sent_at' =>
                            $winner->notification_sent_at,

                        'notification_attempted_at' =>
                            $winner->notification_attempted_at,
                    ],
                ];

            }, 3);

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Error al actualizar la notificación.',
            ];
        }
    }
}
