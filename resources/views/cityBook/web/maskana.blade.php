@extends('layouts.cityBook')

@section('data-modal')
    @include('cityBook.web.maskana.partials.yapita.register.modal')

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
    @include('cityBook.web.maskana.partials.style-manager-maps')
    @include('partials.custom.map-business.assets.css.marker-manager')

@endsection
@section('additional-scripts')
    @include('cityBook.web.maskana.partials.yapita.register.assets.util-social-network-authentication')


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
        window.MaskanaTranslations = {{ Illuminate\Support\Js::from($maskanaTranslations) }};
    </script>

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
    <script>
        var $zoneManager = <?php echo json_encode($zoneManager) ?>;
        var $zonesManager = <?php echo json_encode($zonesManager) ?>;

        var $isLoggedIn = @json(auth()->check());

    </script>
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

    <script>
        let businessCategoriesData = [];

        function initBusinessCategoriesSelect2() {

            const $category = $('#business-category-filter');
            const url = $('#route-business-categories-action').val();

            // ==========================================
            // VALIDACIONES INICIALES
            // ==========================================

            if (!$category.length) {
                console.error('No se encontró el selector de categorías.');
                return;
            }

            if (!url) {
                console.error('No se encontró la URL de categorías.');
                return;
            }

            if (!$.fn.select2) {
                console.error('Select2 no está cargado.');
                return;
            }

            // ==========================================
            // EVITAR INICIALIZACIÓN DUPLICADA
            // ==========================================

            if ($category.hasClass('select2-hidden-accessible')) {
                $category.select2('destroy');
            }

            // ==========================================
            // FORMATO VISUAL CON BOOTSTRAP ICONS
            // ==========================================

            function formatBusinessOption(item) {

                const $element = $('<span>');

                const icon = item.element?.dataset?.icon || '';

                const isGroup = Array.isArray(item.children);

                if (
                    typeof icon === 'string' &&
                    /^bi(?: bi-[a-z0-9-]+)+$/.test(icon)
                ) {
                    $('<i>')
                        .addClass(icon)
                        .css({
                            marginRight: '8px',
                            color: '#435cf0'
                        })
                        .appendTo($element);
                }

                $('<span>')
                    .text(item.text || '')
                    .css({
                        fontWeight: isGroup ? '600' : '400'
                    })
                    .appendTo($element);

                return $element;
            }

            // ==========================================
            // INICIALIZAR SELECT2
            // ==========================================

            $category.select2({
                width: '100%',
                placeholder: 'Todas las categorías',
                templateResult: formatBusinessOption,
                templateSelection: formatBusinessOption,
                language: {
                    noResults: () => 'No se encontraron resultados',
                    searching: () => 'Buscando...'
                }
            });

            // ==========================================
            // EVENTO CAMBIO DE SELECCIÓN
            // ==========================================

            $category
                .off('change.businessCategories')
                .on('change.businessCategories', function () {

                    const value = $(this).val() || 'all';

                    // ==================================
                    // ACTUALIZAR FILTRO EXISTENTE
                    // ==================================

                    businessFilters.subcategoryIds = value === 'all'
                        ? []
                        : [Number(value)];

                    console.log(
                        'Subcategorías seleccionadas:',
                        businessFilters.subcategoryIds
                    );

                    console.log(
                        'Parámetros para consultar el mapa:',
                        buildBusinessRequestParams()
                    );
                    setBusinessSubcategories(businessFilters.subcategoryIds);

                });

            // ==========================================
            // CONSULTA AJAX POST DE CATEGORÍAS
            // ==========================================

            $.ajax({

                url: url,
                type: 'POST',
                dataType: 'json',

                data: {
                    search: '',
                    category_id: 'all'
                },

                beforeSend: function () {

                    $category.prop('disabled', true);

                },

                success: function (response) {

                    // La API devuelve directamente un array.
                    // También se admite { data: [...] }.

                    const categories = Array.isArray(response)
                        ? response
                        : response?.data;

                    if (!Array.isArray(categories)) {

                        console.error(
                            'Respuesta de categorías no válida:',
                            response
                        );

                        return;
                    }

                    businessCategoriesData = categories;

                    // ==================================
                    // LIMPIAR SELECT
                    // ==================================

                    $category.empty();

                    $category.append(
                        new Option(
                            'Todas las categorías',
                            'all',
                            false,
                            true
                        )
                    );

                    // ==================================
                    // CATEGORÍAS COMO OPTGROUP
                    // SUBCATEGORÍAS COMO OPTION
                    // ==================================

                    businessCategoriesData.forEach(category => {

                        const group = document.createElement('optgroup');

                        group.label = category.text || '';
                        group.dataset.icon = category.icon || '';
                        group.dataset.categoryId = category.id;

                        (category.subcategories || []).forEach(subcategory => {

                            const option = new Option(
                                subcategory.text,
                                subcategory.id,
                                false,
                                false
                            );

                            option.dataset.icon = subcategory.icon || '';
                            option.dataset.categoryId = category.id;

                            group.appendChild(option);

                        });

                        // No mostrar categorías sin subcategorías.
                        if (group.children.length > 0) {
                            $category.append(group);
                        }

                    });

                    // ==================================
                    // RESTAURAR SELECCIÓN
                    // ==================================

                    const currentIds = businessFilters.subcategoryIds || [];

                    const selectedValue = currentIds.length === 1
                        ? String(currentIds[0])
                        : 'all';

                    const exists = $category
                        .find('option')
                        .toArray()
                        .some(option => option.value === selectedValue);

                    $category
                        .val(exists ? selectedValue : 'all')
                        .trigger('change.select2');

                    // Si la selección anterior ya no existe,
                    // limpiamos el filtro.
                    if (!exists) {
                        businessFilters.subcategoryIds = [];
                    }

                    console.log(
                        'Categorías y subcategorías cargadas:',
                        businessCategoriesData
                    );

                },

                error: function (xhr) {

                    console.error(
                        'Error al cargar categorías:',
                        xhr.status,
                        xhr.responseJSON || xhr.responseText
                    );

                },

                complete: function () {

                    $category.prop('disabled', false);

                }

            });
        }
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
                // APARIENCIA GENERAL - NUEVO
                // ======================================

                appearance: {

                    background: '#ffffff',

                    color: '#4354eb',

                    borderColor: '#ffffff',

                    borderWidth: 3,

                    borderRadius: '50%',

                    shadow: '0 3px 10px rgba(0, 0, 0, 0.25)',

                    fallbackFontSize: 26,

                    objectFit: 'cover'

                },

                // ======================================
                // TAMAÑO DINÁMICO SEGÚN ZOOM
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

                    condition: ['promotions', 'events'],

                    duration: 1200,

                    height: 10,

                    timingFunction: 'ease-in-out', // NUEVO

                    allowGrouped: false

                },

                // ======================================
                // ONDAS DE PULSO
                // ======================================

                pulse: {

                    enabled: true,

                    condition: 'promotions',

                    color: '#8b24dc',

                    duration: 1800,

                    scale: 1.6,

                    delay: 900,

                    waves: 2, // NUEVO

                    borderWidth: 2, // NUEVO

                    opacity: 0.65, // NUEVO

                    timingFunction: 'ease-out', // NUEVO

                    allowGrouped: false

                },

                // ======================================
                // DISTINTIVOS
                // ======================================

                badge: {

                    enabled: true,

                    allowGrouped: false,

                    // Prioridad cuando una empresa tiene
                    // varias novedades simultáneamente.

                    priority: [
                        'route',
                        'promotion',
                        'event',
                        'advertisement'
                    ],

                    // ----------------------------------
                    // APARIENCIA GENERAL DEL DISTINTIVO
                    // ----------------------------------

                    color: '#4354eb',

                    textColor: '#ffffff',

                    size: 28,

                    fontSize: 13,

                    borderColor: '#ffffff',

                    borderWidth: 3,

                    top: -9,

                    right: -9,

                    // ----------------------------------
                    // RUTA MASKANA
                    // ----------------------------------

                    route: {

                        enabled: true,

                        isIcon: false,

                        icon: '🎃',

                        title: 'Dulce o Truco',

                        color: '#f97316'

                    },

                    // ----------------------------------
                    // PROMOCIONES
                    // ----------------------------------

                    promotion: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-gift-fill',

                        title: 'Promoción disponible',

                        color: '#8b24dc'

                    },

                    // ----------------------------------
                    // EVENTOS - NUEVO
                    // ----------------------------------

                    event: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-calendar-event-fill',

                        title: 'Evento disponible',

                        color: '#168b56'

                    },

                    // ----------------------------------
                    // PUBLICIDAD - NUEVO
                    // ----------------------------------

                    advertisement: {

                        enabled: true,

                        isIcon: true,

                        icon: 'bi-megaphone-fill',

                        title: 'Publicidad disponible',

                        color: '#4354eb'

                    }

                },

                // ======================================
                // CONTADOR DE EMPRESAS AGRUPADAS - NUEVO
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
            // MARCADOR DE UBICACIÓN DEL USUARIO
            // ==========================================

            userLocation: {

                zoom: 17,

                buttonId: 'maskana-location-button',

                marker: {

                    size: 64,

                    isIcon: false,

                    icon: '🎃',

                    iconSize: 32,

                    color: '#f97316',

                    zIndexOffset: 1000,

                    // ----------------------------------
                    // ETIQUETA DE UBICACIÓN
                    // ----------------------------------

                    label: {

                        enabled: true,

                        text: 'Estás aquí',

                        background: '#ffffff',

                        color: '#172033'

                    },

                    // ----------------------------------
                    // REBOTE DEL USUARIO
                    // ----------------------------------

                    bounce: {

                        enabled: true,

                        duration: 1200,

                        height: 8

                    },

                    // ----------------------------------
                    // PULSO DEL USUARIO
                    // ----------------------------------

                    pulse: {

                        enabled: true,

                        color: '#f97316',

                        duration: 1800,

                        scale: 1.8

                    },

                    // ----------------------------------
                    // POPUP DEL USUARIO
                    // ----------------------------------

                    popup: {

                        enabled: true,

                        title: '🎃 ¡Estás aquí!',

                        description:
                            'Sigue explorando Maskana y descubre los dulces cercanos.'

                    }

                },

                // ======================================
                // PRECISIÓN DE UBICACIÓN GPS
                // ======================================

                accuracy: {

                    enabled: true,

                    color: '#f97316',

                    weight: 1,

                    opacity: 0.65,

                    fillColor: '#f97316',

                    fillOpacity: 0.08

                },

                // ======================================
                // TEXTOS DE PERMISOS
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
    @include('cityBook.web.maskana.partials.util-whatsapp')

    @include('partials.custom.map-business.map-manager')
    @include('cityBook.web.maskana.partials.yapita.register.assets.yapita-register-modal')

    @include('cityBook.web.maskana.partials.business-response-data')
    @include('partials.custom.map-business.maskana-map-location-controller')
    @include('partials.custom.map-business.business-map-controller')
    @include('cityBook.web.maskana.partials.assets.bottom-sheet-tabs-util')
    @include('cityBook.web.maskana.partials.assets.prizes-util')

    @include('cityBook.web.maskana.partials.filters-manager')

    @include('cityBook.web.maskana.partials.init-process-manager')

@endsection

@section('content')

    <div id="app-management" class="manager-map">
        @if(!Auth::check())
            <div class="yapita-register">
                <div class="yapita-register__icon">
                    <i class="bi bi-gift-fill"></i>
                </div>

                <div class="yapita-register__content">
                    <h3 class="yapita-register__title">
                        {{ __('frontend.yapita.register_halloween.banner.title') }}
                    </h3>

                    <p class="yapita-register__description">
                        {{ __('frontend.yapita.register_halloween.banner.description') }}
                    </p>
                </div>

                <button
                    type="button"
                    class="yapita-register__action"
                    aria-label="{{ __('frontend.yapita.register_halloween.banner.register_action') }}"
                >
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        @endif
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
        <input
            type="hidden"
            id="route-business-categories-action"
            value="{{ route('getCategoriesBusiness') }}"
        >

        <!-- ==========================================
             MAPA PRINCIPAL
        ========================================== -->

        <div class="business-map-layout">

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


            <div
                id="manager-filters-backdrop"
                class="manager-filters__backdrop"
                aria-hidden="true"
            ></div>
            @include('cityBook.web.maskana.partials.filters-manager-search')



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
