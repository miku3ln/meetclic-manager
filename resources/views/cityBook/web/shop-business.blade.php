@extends('layouts.cityBook')
@section('data-header')
    <div class="yapita-header-discovery">
    <span class="yapita-header-discovery__text">
        {{ __('frontend.menu.business.discovery') }}
    </span>
    </div>
@endsection
@section('data-modal')
    @include('cityBook.web.shop-business.partials.yapita.register.modal')

@endsection
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >
    @include('cityBook.web.shop-business.partials.style-manager-maps')
    @include('partials.custom.map-business.assets.css.marker-manager')

    @include('cityBook.web.shop-business.partials.filters.assets.css.style')
    @include('cityBook.web.shop-business.partials.filters.assets.css.yapita-business-filter-aside')

@endsection
@section('additional-scripts')
    @include('cityBook.web.shop-business.partials.yapita.register.assets.util-social-network-authentication')


    @php
        $maskanaTranslations = [
            'frontend.maskana.filter.title' => __('frontend.maskana.filter.title'),
            'frontend.maskana.filter.subtitle' => __('frontend.maskana.filter.subtitle'),
            'frontend.maskana.filter.businesses_found' => __('frontend.maskana.filter.businesses_found'),
            'frontend.maskana.filter.view_map_question' => __('frontend.maskana.filter.view_map_question'),
            'frontend.maskana.filter.view_map_description' => __('frontend.maskana.filter.view_map_description'),
            'frontend.maskana.filter.category_subcategory' => __('frontend.maskana.filter.category_subcategory'),
            'frontend.maskana.filter.search_business' => __('frontend.maskana.filter.search_business'),
            'frontend.maskana.filter.clear' => __('frontend.maskana.filter.clear'),
            'frontend.maskana.filter.businesses' => __('frontend.maskana.filter.businesses'),
            'frontend.maskana.filter.toggle' => __('frontend.maskana.filter.toggle'),
            'frontend.maskana.filter.apply' => __('frontend.maskana.filter.apply'),
            'frontend.maskana.business.loading' => __('frontend.maskana.business.loading'),
            'frontend.maskana.business.detail' => __('frontend.maskana.business.detail'),
            'frontend.maskana.business.close_detail' => __('frontend.maskana.business.close_detail'),
            'frontend.maskana.businesses.at_location' => __('frontend.maskana.businesses.at_location'),
            'frontend.maskana.businesses.close_list' => __('frontend.maskana.businesses.close_list'),



            'frontend.maskana.business.no_information' => __('frontend.maskana.business.no_information'),
            'frontend.maskana.business.try_changing_filters' => __('frontend.maskana.business.try_changing_filters'),
            'frontend.maskana.map.marker_unavailable' => __('frontend.maskana.map.marker_unavailable'),
            'frontend.maskana.filter.business_found' => __('frontend.maskana.filter.business_found'),


        ];
    @endphp
    <script>
        var $categories = <?php echo json_encode($categories) ?>;

        var $isLoggedIn = @json(auth()->check());

    </script>
    <script>
        const YapitaMapConfig = {

            // ==========================================
            // CONFIGURACIÓN DEL MAPA
            // ==========================================

            map: {

                zoom: 13,
                maxZoom: 19,
                focusZoom: 17,
                singleBusinessZoom: 16,
                fitMaxZoom: 16,
                fitPadding: [70, 70],
                fitOnRender: true

            },

            // ==========================================
            // MARCADORES DE EMPRESAS
            // ==========================================

            businessMarker: {

                size: 56,

                fallbackIcon: '🏪',

                fallbackImage: '',

                // ======================================
                // APARIENCIA
                // ======================================

                appearance: {

                    background: '#ffffff',

                    color: '#4354eb',

                    borderColor: '#ffffff',

                    borderWidth: 3,

                    borderRadius: '50%',

                    shadow: '0 3px 10px rgba(0,0,0,.25)',

                    fallbackFontSize: 26,

                    objectFit: 'cover'

                },

                // ======================================
                // ZOOM DINÁMICO
                // ======================================

                zoom: {

                    enabled: true,

                    baseZoom: 17,

                    minSize: 18,

                    maxSize: 68,

                    step: 7

                },

                // ======================================
                // REBOTE
                // ======================================

                bounce: {

                    enabled: true,

                    condition: [
                        'promotions',
                        'games'
                    ],

                    duration: 1500,

                    height: 8,

                    timingFunction: 'ease-in-out',

                    allowGrouped: false

                },

                // ======================================
                // ONDAS DE PULSO
                // ======================================

                pulse: {

                    enabled: true,

                    condition: [
                        'promotions',
                        'games'
                    ],

                    color: '#8b24dc',

                    duration: 2000,

                    scale: 1.7,

                    delay: 1000,

                    waves: 2,

                    borderWidth: 2,

                    opacity: 0.65,

                    timingFunction: 'ease-out',

                    allowGrouped: false,

                    // NUEVO:
                    // Color según la actividad de la empresa.

                    colors: {

                        promotion: '#8b24dc',

                        game: '#e6a000',

                        event: '#168b56',

                        advertisement: '#4354eb',

                        route: '#f97316'

                    },

                    priority: [
                        'game',
                        'promotion',
                        'event',
                        'advertisement',
                        'route'
                    ]

                },

                // ======================================
                // DISTINTIVOS
                // ======================================

                badge: {

                    enabled: true,

                    allowGrouped: false,

                    priority: [

                        'game',

                        'promotion',

                        'event',

                        'advertisement',

                        'route'

                    ],

                    color: '#4354eb',

                    textColor: '#ffffff',

                    size: 28,

                    fontSize: 14,

                    borderColor: '#ffffff',

                    borderWidth: 3,

                    top: -9,

                    right: -9,

                    // ----------------------------------
                    // JUEGOS DE GAMIFICACIÓN
                    // ----------------------------------

                    game: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-controller',

                        title: 'Juega y gana Yapitas',

                        color: '#e6a000'

                    },

                    // ----------------------------------
                    // PROMOCIONES
                    // ----------------------------------

                    promotion: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-percent',

                        title: 'Promociones disponibles',

                        color: '#8b24dc'

                    },

                    // ----------------------------------
                    // EVENTOS
                    // ----------------------------------

                    event: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-calendar-event-fill',

                        title: 'Eventos disponibles',

                        color: '#168b56'

                    },

                    // ----------------------------------
                    // PUBLICIDAD
                    // ----------------------------------

                    advertisement: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-megaphone-fill',

                        title: 'Descubre sus novedades',

                        color: '#4354eb'

                    },

                    // ----------------------------------
                    // MASKANA - COMPATIBILIDAD
                    // ----------------------------------

                    route: {

                        enabled: false,

                        isIcon: false,

                        icon: '🎃',

                        title: 'Dulce o Truco',

                        color: '#f97316'

                    }

                },

                // ======================================
                // CONTADOR DE EMPRESAS AGRUPADAS
                // ======================================

                counter: {

                    enabled: true,

                    background: '#4354eb',

                    color: '#ffffff',

                    borderColor: '#ffffff',

                    borderWidth: 2,

                    size: 24,

                    fontSize: 12,

                    bottom: -5,

                    right: -5

                }

            },

            // ==========================================
            // CHASKI - UBICACIÓN DEL USUARIO
            // ==========================================

            userLocation: {

                zoom: 17,

                // Mantener por compatibilidad.
                buttonId: 'maskana-location-button',

                marker: {

                    size: 64,

                    // ----------------------------------
                    // TIPO DE ICONO
                    // ----------------------------------
                    // image     = Imagen personalizada
                    // bootstrap = Bootstrap Icons
                    // emoji     = Emoji

                    iconType: 'image',

                    // Compatibilidad anterior.
                    isIcon: false,

                    icon: '🏃',

                    // Ruta propuesta para Chaski.
                    image: '/images/characters/chaski.png',

                    fallbackIcon: '🏃',

                    iconSize: 48,

                    color: '#4354eb',

                    zIndexOffset: 1000,

                    // ----------------------------------
                    // APARIENCIA DE CHASKI
                    // ----------------------------------

                    appearance: {

                        background: '#4354eb',

                        borderColor: '#ffcc00',

                        borderWidth: 3,

                        borderRadius: '50%',

                        shadow: '0 3px 10px rgba(0,0,0,.25)',

                        objectFit: 'contain'

                    },

                    // ----------------------------------
                    // ETIQUETA
                    // ----------------------------------

                    label: {

                        enabled: true,

                        text: 'Estás aquí',

                        background: '#4354eb',

                        color: '#ffffff',

                        fontSize: 11,

                        fontWeight: 600,

                        padding: '4px 12px',

                        borderRadius: '20px',

                        shadow: '0 2px 8px rgba(0,0,0,.15)'

                    },

                    // ----------------------------------
                    // REBOTE DE CHASKI
                    // ----------------------------------

                    bounce: {

                        enabled: true,

                        duration: 1800,

                        height: 5,

                        timingFunction: 'ease-in-out'

                    },

                    // ----------------------------------
                    // ONDAS DE CHASKI
                    // ----------------------------------

                    pulse: {

                        enabled: true,

                        color: '#ffcc00',

                        duration: 2200,

                        scale: 1.8,

                        waves: 2,

                        delay: 1100,

                        borderWidth: 2,

                        opacity: 0.65,

                        timingFunction: 'ease-out'

                    },

                    // ----------------------------------
                    // POPUP
                    // ----------------------------------

                    popup: {

                        enabled: true,

                        title: '¡Hola! Soy Chaski',

                        description:
                            'Explora tu comunidad, descubre promociones, participa en juegos y gana Yapitas.'

                    }

                },

                // ======================================
                // PRECISIÓN GPS
                // ======================================

                accuracy: {

                    enabled: true,

                    color: '#4354eb',

                    weight: 1,

                    opacity: 0.65,

                    fillColor: '#4354eb',

                    fillOpacity: 0.08

                },

                // ======================================
                // TEXTOS
                // ======================================

                texts: {

                    denied: 'Ubicación bloqueada',

                    granted: 'Ver mi ubicación',

                    pending: 'Permitir ubicación',

                    unavailable: 'Ubicación no disponible'

                }

            }

        };
    </script>
    <script>
        window.MaskanaTranslations = {{ Illuminate\Support\Js::from($maskanaTranslations) }};
    </script>
    @include('cityBook.web.shop-business.partials.filters.assets.js.yapita-business-filter')

    <script>
        window.SocialNetworkConfig = {
            google: {
                enabled: true,
                clientId: @json(config('services.google_modal_register.client_id')),
                endpoint: @json(url('/auth/google/modal'))
            },

            facebook: {
                enabled: false, // Activar cuando configuremos Meta
                appId: null,
                apiVersion: null,
                endpoint: null
            },
            server: {
                enabled: true, // Activar cuando configuremos Meta
                endpoint: @json(url('/auth/server/modal'))
            }
        };
    </script>

    <script src="https://accounts.google.com/gsi/client"
            async defer></script>

    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.js') }}"
            type='text/javascript'></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    @include('cityBook.web.shop-business.partials.util-whatsapp')

    @include('partials.custom.map-business.map-manager')
    @include('cityBook.web.shop-business.partials.yapita.register.assets.yapita-register-modal')

    @include('cityBook.web.shop-business.partials.business-response-data')
    @include('partials.custom.map-business.maskana-map-location-controller')
    @include('partials.custom.map-business.business-map-controller')
    @include('cityBook.web.shop-business.partials.assets.bottom-sheet-tabs-util')
    @include('cityBook.web.shop-business.partials.assets.prizes-util')

    @include('cityBook.web.shop-business.partials.filters-manager')

    @include('cityBook.web.shop-business.partials.init-process-manager')

@endsection

@section('content')

    <div id="app-management" class="manager-map">


        <input
            type="hidden"
            id="route-business-action"
            value="{{ route('searchNearbyBusinesses') }}"
        >
        <input
            type="hidden"
            id="update-location-business-maskana-action"
            value="{{ route('updateLocationBusinessMaskana') }}"
        >

        <!-- ==========================================
             MAPA PRINCIPAL
        ========================================== -->

        <div class="business-map-layout">
            @include('cityBook.web.shop-business.partials.filters.business-filter-aside')
            @include('cityBook.web.shop-business.partials.filters.business-filter')
            <button
                type="button"
                id="maskana-location-button"
                class="maskana-location-button"
                title="Ver mi ubicación"
                aria-label="Ver mi ubicación"
                disabled
            >
                <i class="bi bi-geo-alt"></i>
            </button>
            <div
                id="business-map"
                class="business-map-layout__map"
                aria-label="Mapa de ubicación de empresas"
            ></div>



            <!-- ======================================
                 MENSAJES DEL SISTEMA
            ====================================== -->

            <div
                id="business-map-message"
                class="manager-map__message alert alert-info d-none"
                role="status"
                aria-live="polite"
            ></div>

            <!-- ======================================
                 LOADING
            ====================================== -->

            <div
                id="business-map-loading"
                class="manager-map__loading d-none"
            >
                <div
                    class="spinner-border text-primary"
                    role="status"
                >
                <span class="visually-hidden">
                                         {{ __('frontend.maskana.business.loading') }}...
                </span>
                </div>
            </div>

            <!-- ======================================
                 DETALLE DE EMPRESA
            ====================================== -->

            <aside
                id="businessDetailAside"
                class="business-map-aside business-map-aside--detail"
                aria-label=" {{ __('frontend.maskana.business.detail') }}"
                aria-hidden="true"
                inert
            >

                <button
                    type="button"
                    class="business-map-aside__close"
                    data-business-aside-close
                    aria-label="{{ __('frontend.maskana.business.close_detail') }}"
                >
                    &times;
                </button>

                <div
                    class="business-map-aside__content"
                    data-business-detail-content
                ></div>

            </aside>

            <!-- ======================================
                 EMPRESAS AGRUPADAS
            ====================================== -->

            <aside
                id="businessGroupAside"
                class="business-map-aside business-map-aside--group"
                aria-label="{{ __('frontend.maskana.businesses.at_location') }}"
                aria-hidden="true"
                inert
            >

                <button
                    type="button"
                    class="business-map-aside__close"
                    data-business-aside-close
                    aria-label="{{ __('frontend.maskana.businesses.close_list') }}"
                >
                    &times;
                </button>

                <div
                    class="business-map-aside__content"
                    data-business-group-content
                ></div>

            </aside>

        </div>

    </div>

@endsection
