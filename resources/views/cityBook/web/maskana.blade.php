
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

@endsection
@section('additional-scripts')


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

    @include('cityBook.web.maskana.partials.map-manager')
    @include('cityBook.web.maskana.partials.yapita.register.assets.yapita-register-modal')

    @include('cityBook.web.maskana.partials.business-response-data')
    @include('cityBook.web.maskana.partials.maskana-map-location-controller')
    @include('cityBook.web.maskana.partials.business-map-controller')



@endsection

@section('content')


    <div id="app-management" class="manager-map">

        <!-- ==========================================
             RUTAS API
        ========================================== -->

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

            <!-- ======================================
                 BARRA SUPERIOR FLOTANTE
            ====================================== -->

            <div class="manager-map__toolbar">

                <div class="manager-map__brand">
                    <img src="{{$zoneManager['source']}}"  class="manager-map__brand-logo" alt="{{$zoneManager['title']}}"/>
                    <span class="manager-map__brand-title" id="title-route" >{{$zoneManager['title']}}</span>
                </div>

                <div class="manager-map__counter">
                    <i class="bi bi-shop"></i>

                    <strong id="business-total">0</strong>

                    <span>empresas</span>
                </div>

            </div>

            <!-- ======================================
                 ACCIONES FLOTANTES
            ====================================== -->

            <div class="manager-map__actions">

                <button
                    type="button"
                    id="manager-filters-toggle"
                    class="manager-filters__toggle"
                    aria-label="Mostrar filtros"
                    aria-controls="manager-filters-panel"
                    aria-expanded="false"
                    style="background: {{''.$zoneManager['color_hex']}} !important; "
                >
                    <i class="bi bi-sliders2"></i>
                    <span>{{ __('frontend.maskana.filter.toggle') }}</span>
                </button>

            </div>

            <!-- ======================================
                 PANEL FLOTANTE DE FILTROS
            ====================================== -->

            <div
                id="manager-filters-backdrop"
                class="manager-filters__backdrop"
                aria-hidden="true"
            ></div>

            <section
                id="manager-filters-panel"
                class="manager-filters"
                role="dialog"
                aria-modal="true"
                aria-labelledby="manager-filters-title"
                aria-hidden="true"
                inert
            >

                <div class="manager-filters__header">

                    <div class="manager-filters__heading">

                        <div class="manager-filters__icon">
                            <i class="bi bi-sliders2"></i>
                        </div>

                        <div>
                            <h2
                                id="manager-filters-title"
                                class="manager-filters__title"
                            >
                                {{ __('frontend.maskana.filter.title') }}
                            </h2>

                            <p class="manager-filters__subtitle">
                                {{ __('frontend.maskana.filter.subtitle') }}
                            </p>
                        </div>

                    </div>

                    <button
                        type="button"
                        id="manager-filters-close"
                        class="manager-filters__close"
                        aria-label="Cerrar filtros"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                </div>

                <!-- CONTENIDO -->

                <div class="manager-filters__body">
                    <div
                        id="business-response-data"
                        class="response-data"
                        role="status"
                        aria-live="polite"
                        aria-atomic="true"
                    >
                    </div>
                    <div class="yapita-register">
                        <div class="yapita-register__icon">
                            <i class="bi bi-gift-fill"></i>
                        </div>

                        <div class="yapita-register__content">
                            <h3 class="yapita-register__title">
                                ¡Regístrate en Yapita!
                            </h3>

                            <p class="yapita-register__description">
                                Participa por premios de las empresas
                                de Maskana y descubre promociones.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="yapita-register__action"
                            aria-label="Registrarse en Yapita"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                    <div class="manager-filters__field">

                        <label
                            for="business-category-filter"
                            class="manager-filters__label"
                        >
                            {{ __('frontend.maskana.filter.category_subcategory') }}

                        </label>
                    <div class="routes-container">

                        @foreach ($zonesManager as $zone)

                            @php
                                $isActive = (string) $typeId === (string) $zone['id'];
                                $zoneColor = $zone['color_hex'] ?? '#445EF2';
                            @endphp

                            <button
                                type="button"
                                class="routes-container__item {{ $isActive ? 'routes-container__item--active' : '' }}"
                                data-zone-id="{{ $zone['id'] }}"
                                data-zone-code="{{ $zone['code'] }}"
                                data-zone-title="{{ $zone['title'] }}"
                                data-zone-source="{{ $zone['source'] }}"
                                style="--route-color: {{ $zoneColor }};"
                                aria-pressed="{{ $isActive ? 'true' : 'false' }}"
                            >
            <span class="routes-container__image-wrapper">
                <img
                    src="{{ $zone['source'] }}"
                    alt="{{ $zone['title'] }}"
                    class="routes-container__image"
                    loading="lazy"
                >
            </span>

                                <span class="routes-container__title">
                {{ $zone['title'] }}
            </span>

                                @if ($isActive)
                                    <span class="routes-container__check" aria-hidden="true">
        <i class="bi bi-check-circle-fill"></i>
    </span>
                                @endif

                            </button>

                        @endforeach

                      </div>


                    </div>


                    <div class="manager-filters__field">

                        <label
                            for="business-category-filter"
                            class="manager-filters__label"
                        >
                            {{ __('frontend.maskana.filter.category_subcategory') }}

                        </label>

                        <select
                            id="business-category-filter"
                            class="manager-filters__select"
                            style="width: 100%;"
                        >
                            <option value="all">
                                {{ __('frontend.maskana.filter.category_subcategory') }}

                            </option>
                        </select>

                    </div>
                    <div class="manager-filters__field">

                        <label
                            for="business-search"
                            class="manager-filters__label"
                        >
                            {{ __('frontend.maskana.filter.search_business') }}

                        </label>

                        <div class="manager-filters__input-wrap">

                            <i class="bi bi-search"></i>

                            <input
                                type="search"
                                id="business-search"
                                class="manager-filters__input"
                                placeholder="Nombre de la empresa..."
                                autocomplete="off"
                            >

                        </div>

                    </div>



                </div>

                <!-- ACCIONES -->

                <div class="manager-filters__footer">

                    <button
                        type="button"
                        id="business-reset-filters"
                        class="manager-filters__reset"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        {{ __('frontend.maskana.filter.clear') }}

                    </button>

                    <button
                        type="button"
                        id="manager-filters-apply"
                        class="manager-filters__apply not-view"
                    >
                        <i class="bi bi-check2"></i>
                        {{ __('frontend.maskana.filter.apply') }}
                    </button>

                </div>

            </section>

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
