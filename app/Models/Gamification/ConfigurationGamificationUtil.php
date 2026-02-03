<?php

namespace App\Models;

namespace App\Models\Gamification;



class ConfigurationGamificationUtil
{
// --------------------------------------------------
    // tracking_sources (31)
    // --------------------------------------------------
    public const TRACKING_SOURCE_SRC_DEFAULT = 1; // default | Fuente de tráfico no identificada
    public const TRACKING_SOURCE_SRC_FACEBOOK = 2; // facebook | Desde Facebook (publicación, historia o anuncio)
    public const TRACKING_SOURCE_SRC_INSTAGRAM = 3; // instagram | Desde Instagram (bio, historia o reels)
    public const TRACKING_SOURCE_SRC_TIKTOK = 4; // tiktok | Desde TikTok (video o perfil)
    public const TRACKING_SOURCE_SRC_WHATSAPP = 5; // whatsapp | Enlace compartido por WhatsApp
    public const TRACKING_SOURCE_SRC_TELEGRAM = 6; // telegram | Desde canal o grupo de Telegram
    public const TRACKING_SOURCE_SRC_EMAIL = 7; // email | Enlace desde correo electrónico
    public const TRACKING_SOURCE_SRC_GOOGLE = 8; // google | Desde Google Search o Google Ads
    public const TRACKING_SOURCE_SRC_EXTERNAL_SITE = 9; // external_site | Desde un sitio web externo no identificado
    public const TRACKING_SOURCE_SRC_BANNER_WEB = 10; // banner_web | Desde banner en sitio web externo
    public const TRACKING_SOURCE_SRC_DIRECT = 11; // direct | Acceso directo (sin referer / url escrita)
    public const TRACKING_SOURCE_SRC_QR_TICKET = 12; // qr_ticket | QR impreso en ticket/factura
    public const TRACKING_SOURCE_SRC_WEB_INTERNAL = 13; // web_internal | Navegación interna web MeetClic
    public const TRACKING_SOURCE_SRC_APP_INTERNAL = 14; // app_internal | Navegación interna app MeetClic
    public const TRACKING_SOURCE_SRC_PUSH_NOTIFICATION = 15; // push_notification | Desde notificación push enviada por el sistema
    public const TRACKING_SOURCE_SRC_SMS = 16; // sms | Enlace desde SMS
    public const TRACKING_SOURCE_SRC_REFERRAL = 17; // referral | Enlace de referido o invitación
    public const TRACKING_SOURCE_SRC_QR_TOTEM = 18; // qr_totem | QR escaneado desde tótem físico (local)
    public const TRACKING_SOURCE_SRC_QR_PRODUCT = 19; // qr_product | QR impreso en producto o empaque
    public const TRACKING_SOURCE_SRC_QR_EVENT = 20; // qr_event | QR en evento o entrada física
    public const TRACKING_SOURCE_SRC_QR_STICKER = 21; // qr_sticker | QR en sticker/afiche
    public const TRACKING_SOURCE_SRC_QR_CARD = 22; // qr_card | QR en tarjeta de presentación
    public const TRACKING_SOURCE_SRC_INSTAGRAM_BIO = 23; // instagram_bio | Link desde bio Instagram
    public const TRACKING_SOURCE_SRC_FACEBOOK_PAGE = 24; // facebook_page | Link desde página de Facebook
    public const TRACKING_SOURCE_SRC_TIKTOK_BIO = 25; // tiktok_bio | Link desde bio TikTok
    public const TRACKING_SOURCE_SRC_YOUTUBE = 26; // youtube | Link desde YouTube
    public const TRACKING_SOURCE_SRC_GOOGLE_MAPS = 27; // google_maps | Link desde Google Maps / business profile
    public const TRACKING_SOURCE_SRC_PARTNER = 28; // partner | Link desde aliado/partner
    public const TRACKING_SOURCE_SRC_INFLUENCER = 29; // influencer | Link desde influencer/creador
    public const TRACKING_SOURCE_SRC_ADS = 30; // ads | Enlace desde campaña publicitaria paga
    public const TRACKING_SOURCE_SRC_OTHER = 31; // other | Otra fuente de tráfico no clasificada

    public const TRACKING_SOURCE_META_BY_ID = [
        1 => ['uid' => 'SRC_DEFAULT', 'code' => 'default', 'description' => 'Fuente de tráfico no identificada'],
        2 => ['uid' => 'SRC_FACEBOOK', 'code' => 'facebook', 'description' => 'Desde Facebook (publicación, historia o anuncio)'],
        3 => ['uid' => 'SRC_INSTAGRAM', 'code' => 'instagram', 'description' => 'Desde Instagram (bio, historia o reels)'],
        4 => ['uid' => 'SRC_TIKTOK', 'code' => 'tiktok', 'description' => 'Desde TikTok (video o perfil)'],
        5 => ['uid' => 'SRC_WHATSAPP', 'code' => 'whatsapp', 'description' => 'Enlace compartido por WhatsApp'],
        6 => ['uid' => 'SRC_TELEGRAM', 'code' => 'telegram', 'description' => 'Desde canal o grupo de Telegram'],
        7 => ['uid' => 'SRC_EMAIL', 'code' => 'email', 'description' => 'Enlace desde correo electrónico'],
        8 => ['uid' => 'SRC_GOOGLE', 'code' => 'google', 'description' => 'Desde Google Search o Google Ads'],
        9 => ['uid' => 'SRC_EXTERNAL_SITE', 'code' => 'external_site', 'description' => 'Desde un sitio web externo no identificado'],
        10 => ['uid' => 'SRC_BANNER_WEB', 'code' => 'banner_web', 'description' => 'Desde banner en sitio web externo'],
        11 => ['uid' => 'SRC_DIRECT', 'code' => 'direct', 'description' => 'Acceso directo (sin referer / url escrita)'],
        12 => ['uid' => 'SRC_QR_TICKET', 'code' => 'qr_ticket', 'description' => 'QR impreso en ticket/factura'],
        13 => ['uid' => 'SRC_WEB_INTERNAL', 'code' => 'web_internal', 'description' => 'Navegación interna web MeetClic'],
        14 => ['uid' => 'SRC_APP_INTERNAL', 'code' => 'app_internal', 'description' => 'Navegación interna app MeetClic'],
        15 => ['uid' => 'SRC_PUSH_NOTIFICATION', 'code' => 'push_notification', 'description' => 'Desde notificación push enviada por el sistema'],
        16 => ['uid' => 'SRC_SMS', 'code' => 'sms', 'description' => 'Enlace desde SMS'],
        17 => ['uid' => 'SRC_REFERRAL', 'code' => 'referral', 'description' => 'Enlace de referido o invitación'],
        18 => ['uid' => 'SRC_QR_TOTEM', 'code' => 'qr_totem', 'description' => 'QR escaneado desde tótem físico (local)'],
        19 => ['uid' => 'SRC_QR_PRODUCT', 'code' => 'qr_product', 'description' => 'QR impreso en producto o empaque'],
        20 => ['uid' => 'SRC_QR_EVENT', 'code' => 'qr_event', 'description' => 'QR en evento o entrada física'],
        21 => ['uid' => 'SRC_QR_STICKER', 'code' => 'qr_sticker', 'description' => 'QR en sticker/afiche'],
        22 => ['uid' => 'SRC_QR_CARD', 'code' => 'qr_card', 'description' => 'QR en tarjeta de presentación'],
        23 => ['uid' => 'SRC_INSTAGRAM_BIO', 'code' => 'instagram_bio', 'description' => 'Link desde bio Instagram'],
        24 => ['uid' => 'SRC_FACEBOOK_PAGE', 'code' => 'facebook_page', 'description' => 'Link desde página de Facebook'],
        25 => ['uid' => 'SRC_TIKTOK_BIO', 'code' => 'tiktok_bio', 'description' => 'Link desde bio TikTok'],
        26 => ['uid' => 'SRC_YOUTUBE', 'code' => 'youtube', 'description' => 'Link desde YouTube'],
        27 => ['uid' => 'SRC_GOOGLE_MAPS', 'code' => 'google_maps', 'description' => 'Link desde Google Maps / business profile'],
        28 => ['uid' => 'SRC_PARTNER', 'code' => 'partner', 'description' => 'Link desde aliado/partner'],
        29 => ['uid' => 'SRC_INFLUENCER', 'code' => 'influencer', 'description' => 'Link desde influencer/creador'],
        30 => ['uid' => 'SRC_ADS', 'code' => 'ads', 'description' => 'Enlace desde campaña publicitaria paga'],
        31 => ['uid' => 'SRC_OTHER', 'code' => 'other', 'description' => 'Otra fuente de tráfico no clasificada'],
    ];

    // --------------------------------------------------
    // tracking_click_types (17)
    // --------------------------------------------------
    public const CLICK_TYPE_CLK_DEFAULT = 1; // default | Tipo de interacción no especificado
    public const CLICK_TYPE_CLK_CLICK = 2; // click | Clic directo en un enlace o botón
    public const CLICK_TYPE_CLK_VIEW = 3; // view | Visualización de página o componente
    public const CLICK_TYPE_CLK_SHARE = 4; // share | Contenido compartido por el usuario
    public const CLICK_TYPE_CLK_REFERRAL = 5; // referral | Acceso generado por recomendación
    public const CLICK_TYPE_CLK_QR_SCAN = 6; // qr_scan | Escaneo de un código QR físico
    public const CLICK_TYPE_CLK_WEB_TRACKING = 7; // web_tracking | Tracking automatizado desde la web
    public const CLICK_TYPE_CLK_BUTTON_PRESS = 8; // button_press | Presión sobre botón interactivo
    public const CLICK_TYPE_CLK_FORM_SUBMIT = 9; // form_submit | Envío de formulario (registro, sugerencia, calificación)
    public const CLICK_TYPE_CLK_REDEEM = 10; // redeem | Acción de canje de puntos o beneficio
    public const CLICK_TYPE_CLK_PURCHASE = 11; // purchase | Acción de compra o checkout
    public const CLICK_TYPE_CLK_ADD_TO_CART = 12; // add_to_cart | Agregar producto al carrito
    public const CLICK_TYPE_CLK_FOLLOW = 13; // follow | Seguir o suscribirse a empresa/perfil
    public const CLICK_TYPE_CLK_REVIEW = 14; // review | Dejar reseña, calificar o comentar
    public const CLICK_TYPE_CLK_LOCATION_VISIT = 15; // location_visit | Visita física detectada (check-in)
    public const CLICK_TYPE_CLK_SYSTEM_TRIGGER = 16; // system_trigger | Evento generado automáticamente por el sistema
    public const CLICK_TYPE_CLK_CUSTOM_ACTION = 17; // custom_action | Acción personalizada definida por el sistema

    public const CLICK_TYPE_META_BY_ID = [
        1 => ['uid' => 'CLK_DEFAULT', 'code' => 'default', 'description' => 'Tipo de interacción no especificado'],
        2 => ['uid' => 'CLK_CLICK', 'code' => 'click', 'description' => 'Clic directo en un enlace o botón'],
        3 => ['uid' => 'CLK_VIEW', 'code' => 'view', 'description' => 'Visualización de página o componente'],
        4 => ['uid' => 'CLK_SHARE', 'code' => 'share', 'description' => 'Contenido compartido por el usuario'],
        5 => ['uid' => 'CLK_REFERRAL', 'code' => 'referral', 'description' => 'Acceso generado por recomendación'],
        6 => ['uid' => 'CLK_QR_SCAN', 'code' => 'qr_scan', 'description' => 'Escaneo de un código QR físico'],
        7 => ['uid' => 'CLK_WEB_TRACKING', 'code' => 'web_tracking', 'description' => 'Tracking automatizado desde la web'],
        8 => ['uid' => 'CLK_BUTTON_PRESS', 'code' => 'button_press', 'description' => 'Presión sobre botón interactivo'],
        9 => ['uid' => 'CLK_FORM_SUBMIT', 'code' => 'form_submit', 'description' => 'Envío de formulario (registro, sugerencia, calificación)'],
        10 => ['uid' => 'CLK_REDEEM', 'code' => 'redeem', 'description' => 'Acción de canje de puntos o beneficio'],
        11 => ['uid' => 'CLK_PURCHASE', 'code' => 'purchase', 'description' => 'Acción de compra o checkout'],
        12 => ['uid' => 'CLK_ADD_TO_CART', 'code' => 'add_to_cart', 'description' => 'Agregar producto al carrito'],
        13 => ['uid' => 'CLK_FOLLOW', 'code' => 'follow', 'description' => 'Seguir o suscribirse a empresa/perfil'],
        14 => ['uid' => 'CLK_REVIEW', 'code' => 'review', 'description' => 'Dejar reseña, calificar o comentar'],
        15 => ['uid' => 'CLK_LOCATION_VISIT', 'code' => 'location_visit', 'description' => 'Visita física detectada (check-in)'],
        16 => ['uid' => 'CLK_SYSTEM_TRIGGER', 'code' => 'system_trigger', 'description' => 'Evento generado automáticamente por el sistema'],
        17 => ['uid' => 'CLK_CUSTOM_ACTION', 'code' => 'custom_action', 'description' => 'Acción personalizada definida por el sistema'],
    ];

    // --------------------------------------------------
    // gamification_type_activity (15)
    // --------------------------------------------------
    public const ACTIVITY_ECOMMERCE = 1; // Gestión de E-commerce | CLIENTE-EMPRESA
    public const ACTIVITY_BUSINESS_INSIGHT = 2; // Conocimiento de la Empresa | CLIENTE-EMPRESA
    public const ACTIVITY_CLIENT_PROFILE = 3; // Gestión de Datos del Cliente | CLIENTE-EMPRESA
    public const ACTIVITY_MARKETING_ENGAGEMENT = 4; // Participación en Marketing | CLIENTE-EMPRESA
    public const ACTIVITY_CUSTOMER_FEEDBACK = 5; // Retroalimentación del Cliente | CLIENTE-EMPRESA
    public const ACTIVITY_PHYSICAL_ENGAGEMENT = 6; // Interacción Presencial | CLIENTE-EMPRESA
    public const ACTIVITY_REFERRALS = 7; // Sistema de Referidos | CLIENTE-EMPRESA
    public const ACTIVITY_NEWS_UPDATES = 8; // Interacción con Contenido Empresarial | CLIENTE-EMPRESA
    public const ACTIVITY_CAMPAIGN_ENGAGEMENT = 9; // Participación en Campañas de Fidelización | CLIENTE-EMPRESA
    public const ACTIVITY_CROSS_DEPARTMENTS = 10; // Interacción Multidepartamental | CLIENTE-EMPRESA
    public const ACTIVITY_BRAND_PROMOTION = 11; // Promoción de Marca y Reputación | CLIENTE-EMPRESA
    public const ACTIVITY_CLIENT_TO_CLIENT = 12; // Cliente a Cliente | CLIENTE-CLIENTE
    public const ACTIVITY_CLIENT_TO_BUSINESS = 13; // Cliente a Empresa | CLIENTE-EMPRESA
    public const ACTIVITY_BUSINESS_TO_CLIENT = 14; // Empresa a Cliente | EMPRESA-CLIENTE
    public const ACTIVITY_BUSINESS_TO_BUSINESS = 15; // Empresa a Empresa | EMPRESA-EMPRESA

    public const ACTIVITY_META_BY_ID = [
        1 => ['code' => 'ECOMMERCE', 'title' => 'Gestión de E-commerce', 'interaction_type' => 'CLIENTE-EMPRESA'],
        2 => ['code' => 'BUSINESS_INSIGHT', 'title' => 'Conocimiento de la Empresa', 'interaction_type' => 'CLIENTE-EMPRESA'],
        3 => ['code' => 'CLIENT_PROFILE', 'title' => 'Gestión de Datos del Cliente', 'interaction_type' => 'CLIENTE-EMPRESA'],
        4 => ['code' => 'MARKETING_ENGAGEMENT', 'title' => 'Participación en Marketing', 'interaction_type' => 'CLIENTE-EMPRESA'],
        5 => ['code' => 'CUSTOMER_FEEDBACK', 'title' => 'Retroalimentación del Cliente', 'interaction_type' => 'CLIENTE-EMPRESA'],
        6 => ['code' => 'PHYSICAL_ENGAGEMENT', 'title' => 'Interacción Presencial', 'interaction_type' => 'CLIENTE-EMPRESA'],
        7 => ['code' => 'REFERRALS', 'title' => 'Sistema de Referidos', 'interaction_type' => 'CLIENTE-EMPRESA'],
        8 => ['code' => 'NEWS_UPDATES', 'title' => 'Interacción con Contenido Empresarial', 'interaction_type' => 'CLIENTE-EMPRESA'],
        9 => ['code' => 'CAMPAIGN_ENGAGEMENT', 'title' => 'Participación en Campañas de Fidelización', 'interaction_type' => 'CLIENTE-EMPRESA'],
        10 => ['code' => 'CROSS_DEPARTMENTS', 'title' => 'Interacción Multidepartamental', 'interaction_type' => 'CLIENTE-EMPRESA'],
        11 => ['code' => 'BRAND_PROMOTION', 'title' => 'Promoción de Marca y Reputación', 'interaction_type' => 'CLIENTE-EMPRESA'],
        12 => ['code' => 'CLIENT_TO_CLIENT', 'title' => 'Cliente a Cliente', 'interaction_type' => 'CLIENTE-CLIENTE'],
        13 => ['code' => 'CLIENT_TO_BUSINESS', 'title' => 'Cliente a Empresa', 'interaction_type' => 'CLIENTE-EMPRESA'],
        14 => ['code' => 'BUSINESS_TO_CLIENT', 'title' => 'Empresa a Cliente', 'interaction_type' => 'EMPRESA-CLIENTE'],
        15 => ['code' => 'BUSINESS_TO_BUSINESS', 'title' => 'Empresa a Empresa', 'interaction_type' => 'EMPRESA-EMPRESA'],
    ];

    // --------------------------------------------------
    // Helpers
    // --------------------------------------------------
    public static function trackingSource(int $id): array
    {
        return self::TRACKING_SOURCE_META_BY_ID[$id] ?? ['uid' => null, 'code' => null, 'description' => null];
    }

    public static function clickType(int $id): array
    {
        return self::CLICK_TYPE_META_BY_ID[$id] ?? ['uid' => null, 'code' => null, 'description' => null];
    }

    public static function activity(int $id): array
    {
        return self::ACTIVITY_META_BY_ID[$id] ?? ['code' => null, 'title' => null, 'interaction_type' => null];
    }

    private const PROCESS_FIELDS_BY_UNIQUE_CODE = [

        // (1)
        'SHARE_PROFILE_WHATSAPP_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_FOLLOW,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WHATSAPP,
            'gamification_type_activity_id' => self::ACTIVITY_ECOMMERCE,
            'execution_channel' => 'DIGITAL',
        ],

        // (2)
        'VIEW_PROFILE_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],

        // (3)
        'VIEW_PROFILE_QR_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'PHYSICAL',
        ],

        // (4)
        'REGISTER_PROFILE_FORM_SUBMIT_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_PURCHASE,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],

        // (5)
        'REGISTER_RATE_FORM_SUBMIT_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_PURCHASE,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'DIGITAL',
        ],

        // (6)
        'VIEW_RATE_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],

        // (7)
        'VIEW_RATE_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'PHYSICAL',
        ],

        // (8)
        'VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'DIGITAL',
        ],

        // (9)
        'REGISTER_SUGGESTION_SUBMIT_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_PURCHASE,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'DIGITAL',
        ],

        // (10)
        'VIEW_SUGGESTION_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'DIGITAL',
        ],

        // (11)
        'VIEW_SUGGESTION_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'PHYSICAL',
        ],

        // (12)
        'VIEW_REGISTERS_SUGGESTION_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'PHYSICAL',
        ],

        // (13)
        'VIEW_REGISTERS_SUGGESTION_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES,
            'execution_channel' => 'DIGITAL',
        ],

        // (14)
        'VIEW_REWARDS_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'PHYSICAL',
        ],

        // (15)
        'VIEW_REWARDS_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],

        // (16) OJO: en tu SQL viene execution_channel = 'DIGITAL' (aunque el título sea QR)
        'VIEW_TASK_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],

        // (17)
        'VIEW_TASK_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],

        // (18)
        'AYNI_KAWSAY_SHOP_QR_SCAN_TICKET_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'PHYSICAL',
        ],

        // (19)
        'AYNI_YACHAY_SHOP_WEB_MC' => [
            'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK,
            'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL,
            'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION,
            'execution_channel' => 'DIGITAL',
        ],
    ];

    public static function getProcessFieldsByUniqueCode(string $uniqueCode): array
    {
        $uniqueCode = trim($uniqueCode);

        $data = self::PROCESS_FIELDS_BY_UNIQUE_CODE[$uniqueCode] ?? null;

        if ($data === null) {
            // fallback seguro (no revienta)
            return [
                'tracking_click_type_id' => self::CLICK_TYPE_CLK_DEFAULT,
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_DEFAULT,
                'gamification_type_activity_id' => null,
                'execution_channel' => null,
                'unique_code' => $uniqueCode,
            ];
        }

        return [
            'tracking_click_type_id' => $data['tracking_click_type_id'],
            'tracking_source_id' => $data['tracking_source_id'],
            'gamification_type_activity_id' => $data['gamification_type_activity_id'],
            'execution_channel' => $data['execution_channel'],
            'unique_code' => $uniqueCode,
        ];
    }

    public static function getDataManagementSetBusiness($params)
    {

        $business = $params["business"];
        $urlBase = $params["urlBase"];
        $user_id = $params["user_id"];

        $business_by_gamification = [
            "id" => -1, "gamification_id" => -1,
            "business_id" => $business["id"],
            "allow_exchange" => 1,
            "allow_exchange_business" => 0,
            "state"=>"ACTIVE"
        ];
        $gamification = [
            "description" => "Configuracion",
            "value" => "Configuracion Inicial Gamificacion",
            "value_unit" => 0,
            "state" => "ACTIVE",
            "id" => null,
            "business_by_gamification" => $business_by_gamification,
            "gamification_by_process" => []
        ];

        $dataProcess = ConfigurationGamificationUtil::gamificationByProcessHaystack();
        $dataProcess = array_reverse($dataProcess);

        foreach ($dataProcess as &$process) {
            $channel = $process['execution_channel'] ?? null;
            $url = $process['url_manager'];
            if ($url == "not-url") {

            }else{

                $urlNew = str_replace('{urlProject}', $urlBase, $url);
                $process['url_manager'] = str_replace('MEETCLIC?', $business["id"] . "?", $urlNew);
            }

            $process['user_id'] = $user_id;

        }
        unset($process);
        $gamification["gamification_by_process"] = $dataProcess;
        return $gamification;
    }

    public static function generateManagementDataGamificationBusiness($params)
    {
        $businessData = $params["businessData"];
        $urlBase = $params["urlBase"];
        $user_id = $params["user_id"];
        $result = [];
        foreach ($businessData as $business) {
            $sendParams = array_merge(["business"=>$business], ["urlBase" => $urlBase, "user_id" => $user_id]);
            $setPush = ConfigurationGamificationUtil:: getDataManagementSetBusiness($sendParams);
            $result[] = $setPush;

        }
        return $result;

    }

    public static function gamificationByProcessHaystack(): array
    {
        return [

            // (1)
            [

                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/ayni-reciprocidad-04.png',
                'title' => '📲 Comparte este negocio por WhatsApp',
                'subtitle' => '📤 wakina (compartir) para yanapay (ayudar)',
                'description' => '{"steps":["🔎 Explora el perfil del negocio","🟢 Toca el botón WhatsApp.","📤 Comparte este perfil con una persona o grupo."],"helpers":["💡 Comparte desde el botón oficial del perfil para que se valide."],"validation":"Validación automática al completar la acción de compartir.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el perfil oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}es/business-details/MEETCLIC?typeProcess=whatsapp_click&sourceProcess=whatsapp&campaign_code=campaign-00-web-tracking&codeProcess=69',
                'tracking_click_type_id' => self::CLICK_TYPE_CLK_FOLLOW, // 13
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WHATSAPP, // 5
                'gamification_type_activity_id' => self::ACTIVITY_ECOMMERCE, // 1
                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'SHARE_PROFILE_WHATSAPP_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 20,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (2)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-07.png',
                'title' => '👤 Explora el perfil del negocio',
                'subtitle' => '👀 rikuy (mirar) y conocer lo que ofrece',
                'description' => '{"steps":["👤 Entra al perfil del negocio.","🖼️ Revisa fotos, horarios, ubicación y lo que ofrece.","👀 Explora lo que vende o brinda."],"helpers":["Mira horarios y ubicación antes de ir al local."],"validation":"Validación automática al ingresar y explorar el perfil.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el perfil oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}es/business-details/MEETCLIC?typeProcess=click&sourceProcess=meetclick&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK, // 2
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'VIEW_PROFILE_WEB_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (3)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-08.png',
                'title' => '📍 Escanea el QR del tótem y registra tu visita',
                'subtitle' => '🏪 kaypi (aquí) rikuy (registrar) presencia real',
                'description' => '{"steps":["🏪 Estando en el local, ubica el QR del tótem/stand.","📷 Escanea el QR con tu celular.","✅ Abre el enlace para registrar tu visita."],"helpers":["💡 Usa buena luz para escanear más rápido.","🔒 Escanea solo el QR autorizado del negocio."],"validation":"Validación automática al completar el escaneo del QR.","rules":["✅ Debes estar registrado en MeetClic.","📍 Debes estar físicamente en el local.","🔒 Debes escanear el QR autorizado del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}es/business-details/MEETCLIC?typeProcess=qr_scan&sourceProcess=qr_ticket&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN, // 6
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM, // 18
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'PHYSICAL',
                'unique_code' => 'VIEW_PROFILE_QR_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 40,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (4)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-03.png',
                'title' => '⭐ Agrega este negocio a tus Mashis',
                'subtitle' => '🤝 masichiy (hacerse cercano) con el negocio',
                'description' => '{"steps":["🔎 Explora el perfil del negocio","Busca el botton de agregar","🤝 Pulsa “Agregar a Mashis”.","✅ Verifica que quedó guardado en tu comunidad."],"helpers":["💡 Esto te ayuda a encontrar el negocio más rápido después."],"validation":"Validación automática al agregar el negocio a tus Mashis.","rules":["✅ Debes estar registrado en MeetClic.","⚠️ Esta acción se puede realizar una sola vez por negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'ONCE',
                'frequency_limit_value' => null,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => 'not-url',
                'tracking_click_type_id' => self::CLICK_TYPE_CLK_PURCHASE, // 11
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 0,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'REGISTER_PROFILE_FORM_SUBMIT_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 20,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (5)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/ayni-reciprocidad-02.png',
                'title' => '⭐ Califica tu experiencia (estrellas)',
                'subtitle' => '🌟 chanichiy (valorar) para mejorar calidad',
                'description' => '{"steps":["🔎 Explora el perfil del negocio","⭐ Entra a calificaciones del negocio.","Busca el formulario de registro","⭐ Elige de 1 a 5 estrellas según tu experiencia.","📨 Envía tu calificación."],"helpers":["💡 Calificar con sinceridad ayuda a mejorar la calidad del negocio."],"validation":"Validación automática al enviar tu calificación.","rules":["✅ Debes estar registrado en MeetClic.","⚠️ Solo se valida si envías la calificación de forma completa."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'TOTAL_LIMIT',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => 'not-url',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_PURCHASE, // 11
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES, // 8

                'is_url' => 0,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'REGISTER_RATE_FORM_SUBMIT_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 20,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (6)


            // (7)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-06.png',
                'title' => '🧾 Escanea el QR y Mira calificaciones y opiniones',
                'subtitle' => '📍 post-compra: ingreso validado por QR',
                'description' => '{"steps":["🏪 En el local del negocio, escanea el QR autorizado.","📊 Abre la sección de calificaciones y opiniones","👀 Revisa los aportes disponibles."],"helpers":["💡 El ticket debe ser válido y del negocio.","🔒 Escanea solo QR autorizado."],"validation":"Validación automática al completar el escaneo del QR del ticket.","rules":["✅ Debes estar registrado en MeetClic.","⚠️ Debes escanear un ticket válido del negocio (QR autorizado)."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => 'undefined',
                'url_manager' => '{urlProject}rate/register/business/MEETCLIC?typeProcess=qr_scan&sourceProcess=qr_ticket&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN, // 6
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM, // 18
                'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES, // 8

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'PHYSICAL',
                'unique_code' => 'VIEW_RATE_QR_SCAN_TICKET_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 40,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (8)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/sumka-kawsay-comunidad-invita-05.png',
                'title' => '⭐ Mira calificaciones y opiniones',
                'subtitle' => '🔍 rikuy (mirar) experiencias reales',
                'description' => '{"steps":["🔎 Explora el perfil del negocio","⭐ Entra a calificaciones del negocio.","🔍 Lee estrellas y comentarios de otros clientes."],"helpers":["💡 Busca patrones: atención, calidad, tiempos y precios."],"validation":"Validación automática al ingresar a la sección de calificaciones.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el enlace oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}rates/registers/business/MEETCLIC?typeProcess=click&sourceProcess=meetclick&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK, // 2
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES, // 8

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'VIEW_REGISTERS_RATE_QR_SCAN_TICKET_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (9)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/randi-dar-recibir-01.png',
                'title' => '💬 Escribe una sugerencia con respeto',
                'subtitle' => '🗣️ rimay (hablar) para mejorar juntos',
                'description' => '{"steps":["🔎 Explora el perfil del negocio","💬 Entra al Buzón de sugerencias","🗣️ Escribe una sugerencia clara y respetuosa.","📨 Envía tu sugerencia"],"helpers":["💡 Describe qué pasó y qué mejorarías.","🧠 Mientras más claro, más útil para el negocio."],"validation":"Validación automática al enviar la sugerencia.","rules":["✅ Debes estar registrado en MeetClic.","⚠️ Solo se valida si envías la sugerencia desde el formulario oficial."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'TOTAL_LIMIT',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => 'not-url',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_PURCHASE, // 11
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES, // 8

                'is_url' => 0,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'REGISTER_SUGGESTION_SUBMIT_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 40,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (10)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-05.png',
                'title' => '📝 Entra al buzón de sugerencias',
                'subtitle' => '🌐 yaykuy (ingresar) al formulario',
                'description' => '{"steps":["🔎 Explora el perfil del negocio.","💬 Entra al Buzón de sugerencias.","🔍 Revisa comentarios y opiniones."],"helpers":["💡 Si tu sugerencia es larga, primero escríbela en notas y luego pega."],"validation":"Validación automática al ingresar al buzón de sugerencias.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el enlace oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '3',
                'entity_id' => '1',
                'url_manager' => '{urlProject}rimay/registers/business/1?typeProcess=click&sourceProcess=meetclick&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK, // 2
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES, // 8

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'VIEW_SUGGESTION_WEB_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (11)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-05.png',
                'title' => '📍 (QR) Entra al buzón de sugerencias',
                'subtitle' => '🏪 desde el local: ingreso validado por QR',
                'description' => '{"steps":["🏪 En el local del negocio, ubica el QR autorizado.","📷 Escanea el QR con tu celular.","📝 Se abrirá el buzón de sugerencias."],"helpers":["🔒 Escanea únicamente el QR autorizado del negocio."],"validation":"Validación automática al completar el escaneo del QR.","rules":["✅ Debes estar registrado en MeetClic.","📍 Debes estar físicamente en el local.","🔒 Debes escanear el QR autorizado del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '3',
                'entity_id' => '1',
                'url_manager' => '{urlProject}rimay/registers/business/1?typeProcess=qr_scan&sourceProcess=qr_ticket&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN, // 6
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM, // 18
                'gamification_type_activity_id' => self::ACTIVITY_NEWS_UPDATES, // 8

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'PHYSICAL',
                'unique_code' => 'VIEW_SUGGESTION_QR_SCAN_TICKET_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 40,
                    "gamification_by_process_id" => null,
                ]
            ],


            // (14)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-14.png',
                'title' => '🎁 (QR) Descubre los premios y canjes del local',
                'subtitle' => '📍 descubrir beneficios estando aquí',
                'description' => '{"steps":["🏪 En el local del negocio, ubica el tótem/stand con QR.","📷 Escanea el QR con tu celular.","🎁 Revisa premios y canjes disponibles."],"helpers":["Mira qué puedes canjear con tus Yapitas antes de comprar."],"validation":"Validación automática al completar el escaneo del QR.","rules":["✅ Debes estar registrado en MeetClic.","📍 Debes estar físicamente en el local.","🔒 Debes escanear el QR autorizado del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}rewards/business/MEETCLIC?typeProcess=qr_scan&sourceProcess=qr_ticket&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN, // 6
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM, // 18
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'PHYSICAL',
                'unique_code' => 'VIEW_REWARDS_QR_SCAN_TICKET_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 40,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (15)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-13.png',
                'title' => '🎁 Descubre premios y canjes desde la web',
                'subtitle' => '🧭 rikuy (mirar) y planear tu canje',
                'description' => '{"steps":["🔎 Explora el perfil del negocio.","🎁 Entra a Premios / Canjes.","👀 Revisa qué puedes obtener con tus Yapitas.","🧭 Elige el premio que deseas canjear"],"helpers":["💡 Planifica tu canje antes de ir al local."],"validation":"Validación automática al ingresar a la sección de premios/canjes.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el enlace oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'WEEKLY',
                'frequency_limit_value' => 3,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}rewards/business/MEETCLIC?typeProcess=click&sourceProcess=meetclick&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK, // 2
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'VIEW_REWARDS_WEB_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (16)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-11.png',
                'title' => '📍 (QR) Descubre la lista de tareas del negocio',
                'subtitle' => '🧭 guía rápida para ganar YAPITAS',
                'description' => '{"steps":["🏪 En el local del negocio, ubica el QR autorizado.","📷 Escanea el QR con tu celular.","📋 Abre la lista de tareas disponibles."],"helpers":["💡 Úsalo como guía rápida para ganar Yapitas."],"validation":"Validación automática al completar el escaneo del QR.","rules":["✅ Debes estar registrado en MeetClic.","📍 Debes estar físicamente en el local.","🔒 Debes escanear el QR autorizado del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}es/business-pullkay/MEETCLIC?typeProcess=qr_scan&sourceProcess=qr_ticket&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN, // 6
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM, // 18
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL', // tu SQL dice DIGITAL
                'unique_code' => 'VIEW_TASK_QR_SCAN_TICKET_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (17)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-12.png',
                'title' => '🧭 Descubre las tareas y aprende cómo ganar YAPITAS',
                'subtitle' => '👀 rikuy (mirar) paso a paso',
                'description' => '{"steps":["🔎 Explora el perfil del negocio.","🎮 Entra a Tareas / Juegos.","✅ Elige una y complétala."],"helpers":["💡 Empieza por las tareas más fáciles para ganar rápido."],"validation":"Validación automática al ingresar a la lista de tareas.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el enlace oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}es/business-pullkay/MEETCLIC?typeProcess=click&sourceProcess=meetclick&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK, // 2
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'VIEW_TASK_WEB_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (18)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/yachay-aprender-07.png',
                'title' => '🏪 (QR) Entra a la tienda desde el local',
                'subtitle' => '📍 físico → digital: visita verificada',
                'description' => '{"steps":["🏪 En el local del negocio, ubica el QR autorizado.","📷 Escanea el QR con tu celular.","🛍️ Abre la tienda/catálogo del negocio."],"helpers":["💡 Ideal para ver el catálogo mientras estás en el local.","🔒 Escanea únicamente el QR autorizado del negocio."],"validation":"Validación automática al completar el escaneo del QR.","rules":["✅ Debes estar registrado en MeetClic.","📍 Debes estar físicamente en el local.","🔒 Debes escanear el QR autorizado del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}shop/business/MEETCLIC?typeProcess=qr_scan&sourceProcess=qr_ticket&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_QR_SCAN, // 6
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_QR_TOTEM, // 18
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'PHYSICAL',
                'unique_code' => 'AYNI_KAWSAY_SHOP_QR_SCAN_TICKET_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 40,
                    "gamification_by_process_id" => null,
                ]
            ],

            // (19)
            [
                "id" => -1, "gamification_id" => -1,
                "user_id" => -1,
                'source' => '/uploads/business/gamification/default/tinkuy-encuentro-08.png',
                'title' => '🛍️ Entra a la tienda y revisa el catálogo',
                'subtitle' => '🛒 rikuy (mirar) productos y servicios',
                'description' => '{"steps":["🏪 Explora el perfil del negocio y encuentra su tienda.","🛍️ Entra al catálogo de productos o servicios.","👀 Explora con calma lo que ofrece."],"helpers":["Mira precios y descripciones para elegir mejor."],"validation":"Validación automática al ingresar y navegar el catálogo.","rules":["✅ Debes estar registrado en MeetClic.","📌 La acción debe realizarse desde el enlace oficial del negocio."]}',
                'state' => 'ACTIVE',
                'valid_from' => null,
                'valid_until' => null,
                'frequency_limit_type' => 'DAILY',
                'frequency_limit_value' => 1,
                'has_source' => 1,
                'entity' => '0',
                'entity_id' => '0',
                'url_manager' => '{urlProject}shop/business/MEETCLIC?typeProcess=click&sourceProcess=meetclick&campaign_code=campaign-00-web-tracking&codeProcess=69',

                'tracking_click_type_id' => self::CLICK_TYPE_CLK_CLICK, // 2
                'tracking_source_id' => self::TRACKING_SOURCE_SRC_WEB_INTERNAL, // 13
                'gamification_type_activity_id' => self::ACTIVITY_BRAND_PROMOTION, // 11

                'is_url' => 1,
                'type_manager' => 0,
                'execution_channel' => 'DIGITAL',
                'unique_code' => 'AYNI_YACHAY_SHOP_WEB_MC',
                'allow_golden' => 1,
                'icon_class' => 'fa fa-data',
                'campaign_code_template' => 'campaign-00-web-tracking',
                'gamification_by_points' => ["id" => -1,
                    "points" => 10,
                    "gamification_by_process_id" => null,
                ]
            ],
        ];

    }
}
