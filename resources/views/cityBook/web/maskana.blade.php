
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
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >
    @include('cityBook.web.maskana.partials.style-manager-maps')

@endsection
@section('additional-scripts')
    <script>
        var $zoneManager = <?php echo json_encode($zoneManager) ?>;
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
                    <i class="bi bi-geo-alt-fill"></i>
                    <span id="title-route">{{$zoneManager['title']}}</span>
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
                >
                    <i class="bi bi-sliders2"></i>
                    <span>Filtros</span>
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
                                Filtrar empresas
                            </h2>

                            <p class="manager-filters__subtitle">
                                Encuentra lo que necesitas
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
                    <!-- RESULTADOS DE EMPRESAS -->
                    <div
                        id="business-response-data"
                        class="response-data"
                        role="status"
                        aria-live="polite"
                        aria-atomic="true"
                    >
                    </div>
                    <div class="manager-filters__field">

                        <label
                            for="business-category-filter"
                            class="manager-filters__label"
                        >
                            Categoría o subcategoría
                        </label>

                        <select
                            id="business-category-filter"
                            class="manager-filters__select"
                            style="width: 100%;"
                        >
                            <option value="all">
                                Todas las categorías
                            </option>
                        </select>

                    </div>
                    <div class="manager-filters__field">

                        <label
                            for="business-search"
                            class="manager-filters__label"
                        >
                            Buscar empresa
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
                        Limpiar
                    </button>

                    <button
                        type="button"
                        id="manager-filters-apply"
                        class="manager-filters__apply not-view"
                    >
                        <i class="bi bi-check2"></i>
                        Aplicar filtros
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
                    Cargando empresas...
                </span>
                </div>
            </div>

            <!-- ======================================
                 DETALLE DE EMPRESA
            ====================================== -->

            <aside
                id="businessDetailAside"
                class="business-map-aside business-map-aside--detail"
                aria-label="Detalle de empresa"
                aria-hidden="true"
                inert
            >

                <button
                    type="button"
                    class="business-map-aside__close"
                    data-business-aside-close
                    aria-label="Cerrar detalle de empresa"
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
                aria-label="Empresas en esta ubicación"
                aria-hidden="true"
                inert
            >

                <button
                    type="button"
                    class="business-map-aside__close"
                    data-business-aside-close
                    aria-label="Cerrar listado de empresas"
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
