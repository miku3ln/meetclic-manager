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
    @include('cityBook.web.maskana.partials.util-whatsapp')

    @include('cityBook.web.maskana.partials.map-manager')
    @include('cityBook.web.maskana.partials.yapita.register.assets.yapita-register-modal')

    @include('cityBook.web.maskana.partials.business-response-data')
    @include('cityBook.web.maskana.partials.maskana-map-location-controller')
    @include('cityBook.web.maskana.partials.business-map-controller')
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
