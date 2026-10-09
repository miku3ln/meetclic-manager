
@extends('layouts.cityBook')
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

    @include('cityBook.web.maskana.partials.style-manager-maps')

@endsection
@section('additional-scripts')
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
    @include('cityBook.web.maskana.partials.business-map-controller')



@endsection
@if(isset($dataManagerPage['dataPage']))

@section('content-manager')


@endsection
@endif
@section('content')

    <div id="app-management" class="container-fluid py-4">

        <!-- ============================================
             CONFIGURACIÓN API LARAVEL
        ============================================ -->

        <input
            type="hidden"
            id="route-business-action"
            value="{{ route('searchNearbyBusinesses') }}"
        >
        <input
            type="hidden"
            id="route-business-categories-action"
            value="{{ route('getCategoriesBusiness') }}"
        >

        <div class="container-fluid py-3">

            <!-- ============================================
                 FILTROS DE EMPRESAS
            ============================================ -->

            <div class="row g-3 mb-3">

                <!-- CATEGORÍAS -->
                <div class="col-md-3">

                    <select
                        id="business-category-filter"
                        class="form-select"
                    >
                        <option value="all">
                            Todas las categorías
                        </option>

                        <!-- Cargar categorías desde Laravel -->

                    </select>

                </div>



                <!-- BUSCADOR -->
                <div class="col-md-4">

                    <input
                        type="search"
                        id="business-search"
                        class="form-control"
                        placeholder="Buscar empresas..."
                        autocomplete="off"
                    >

                </div>

                <!-- LIMPIAR FILTROS -->
                <div class="col-md-2">

                    <button
                        type="button"
                        id="business-reset-filters"
                        class="btn btn-outline-secondary w-100"
                    >
                        Limpiar filtros
                    </button>

                </div>

            </div>

            <!-- ============================================
                 MENSAJES DEL SISTEMA
            ============================================ -->

            <div
                id="business-map-message"
                class="alert alert-info d-none"
                role="alert"
                aria-live="polite"
            ></div>

            <!-- ============================================
                 TOTAL DE EMPRESAS
            ============================================ -->

            <div class="mb-2">

                Empresas encontradas:

                <strong id="business-total">
                    0
                </strong>

            </div>

            <!-- ============================================
                 MAPA + ASIDES
            ============================================ -->

            <div class="business-map-layout">

                <!-- ========================================
                     INDICADOR DE CARGA
                ======================================== -->

                <div
                    id="business-map-loading"
                    class="position-absolute top-50 start-50 translate-middle d-none"
                    style="z-index: 1100;"
                >

                    <div
                        class="spinner-border text-primary"
                        role="status"
                    >

                    <span class="visually-hidden">
                        Cargando empresas...
                    </span>

                    </div>

                </div>

                <!-- ========================================
                     MAPA LEAFLET / OPENSTREETMAP
                ======================================== -->

                <div
                    id="business-map"
                    class="business-map-layout__map"
                    aria-label="Mapa de ubicación de empresas"
                ></div>

                <!-- ========================================
                     ASIDE 1: DETALLE DE EMPRESA
                ======================================== -->

                <aside
                    id="businessDetailAside"
                    class="business-map-aside business-map-aside--detail"
                    aria-label="Detalle de empresa"
                    aria-hidden="true"
                    inert
                >

                    <!-- BOTÓN CERRAR -->
                    <button
                        type="button"
                        class="business-map-aside__close"
                        data-business-aside-close
                        aria-label="Cerrar detalle de empresa"
                    >
                        &times;
                    </button>

                    <!-- CONTENIDO DINÁMICO -->
                    <div
                        class="business-map-aside__content"
                        data-business-detail-content
                    ></div>

                </aside>

                <!-- ========================================
                     ASIDE 2: EMPRESAS AGRUPADAS
                ======================================== -->

                <aside
                    id="businessGroupAside"
                    class="business-map-aside business-map-aside--group"
                    aria-label="Empresas en esta ubicación"
                    aria-hidden="true"
                    inert
                >

                    <!-- BOTÓN CERRAR -->
                    <button
                        type="button"
                        class="business-map-aside__close"
                        data-business-aside-close
                        aria-label="Cerrar listado de empresas"
                    >
                        &times;
                    </button>

                    <!-- CONTENIDO DINÁMICO -->
                    <div
                        class="business-map-aside__content"
                        data-business-group-content
                    ></div>

                </aside>

            </div>

        </div>

    </div>

@endsection
