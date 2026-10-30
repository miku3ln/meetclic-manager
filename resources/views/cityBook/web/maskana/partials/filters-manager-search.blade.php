@php
    $maskanaPrizes = $rewards;
@endphp


<section
    id="maskana-bottom-sheet"
    class="maskana-sheet maskana-sheet--collapsed"
    role="region"
    aria-labelledby="maskana-sheet-title"
    data-state="collapsed"
>
    <!-- HEADER -->
    <header class="maskana-sheet__header">


        <img
            id="maskana-sheet-image"
            class="maskana-sheet__image"
            src="{{$zoneManager['source']}}"
            alt="{{$zoneManager['title']}}"
        >

        <div class="maskana-sheet__information">

            <h2
                id="maskana-sheet-title"
                class="maskana-sheet__title"
            >
                <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                <span id="maskana-sheet-title__value">{{$zoneManager['title']}}</span>
            </h2>

            <div
                id="maskana-sheet-business-count"
                class="maskana-sheet__count"
            >
                            <span id="manager-data">
                                     <i class="bi bi-shop"></i>

                    <strong id="business-total">0</strong>

                    <span>{{ __('frontend.maskana.filter.businesses') }}</span>
                            </span>
            </div>

        </div>

        <button
            type="button"
            id="maskana-sheet-toggle"
            class="maskana-sheet__toggle"
            aria-expanded="false"
            aria-controls="maskana-sheet-content"
            aria-label="Mostrar filtros"
        >
            <i class="bi bi-chevron-up" aria-hidden="true"></i>
        </button>

    </header>

    <!-- BODY + FOOTER -->

    <!-- ==========================================
         MASKANA SHEET - CONTENT
    ========================================== -->

    <div
        id="maskana-sheet-content"
        class="maskana-sheet__content"
        aria-hidden="true"
        inert
    >

        <!-- ======================================
             TABS
        ======================================= -->

        <div
            class="maskana-sheet__tabs"
            role="tablist"
            aria-label="Secciones de Maskana"
        >

            <!-- TAB FILTROS -->
            <button
                type="button"
                id="maskana-sheet-tab-filters"
                class="maskana-sheet__tab maskana-sheet__tab--active"
                role="tab"
                aria-selected="true"
                aria-controls="maskana-sheet-panel-filters"
                tabindex="0"
                data-maskana-tab="filters"
            >
                <i class="bi bi-sliders2" aria-hidden="true"></i>
                <span>Filtros</span>
            </button>

            <!-- TAB PREMIOS -->
            <button
                type="button"
                id="maskana-sheet-tab-prizes"
                class="maskana-sheet__tab"
                role="tab"
                aria-selected="false"
                aria-controls="maskana-sheet-panel-prizes"
                tabindex="-1"
                data-maskana-tab="prizes"
            >
                <i class="bi bi-gift" aria-hidden="true"></i>
                <span>Premios</span>
            </button>

        </div>

        <!-- ======================================
             BODY
        ======================================= -->

        <div class="maskana-sheet__body">

            <!-- ==================================
                 PANEL FILTROS
            =================================== -->

            <div
                id="maskana-sheet-panel-filters"
                class="maskana-sheet__panel maskana-sheet__panel--active"
                role="tabpanel"
                aria-labelledby="maskana-sheet-tab-filters"
                data-maskana-panel="filters"
            >

                <!-- SELECTOR DE RUTAS -->
                <div class="manager-filters__field">

                    <label class="manager-filters__label">
                        {{ __('frontend.yapita.register_halloween.banner.select_route') }}
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
                                    <span
                                        class="routes-container__check"
                                        aria-hidden="true"
                                    >
                                    <i class="bi bi-check-circle-fill"></i>
                                </span>
                                @endif

                            </button>

                        @endforeach

                    </div>

                </div>

                <!-- CATEGORÍA / SUBCATEGORÍA -->
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

                <!-- BUSCADOR -->
                <div class="manager-filters__field">

                    <label
                        for="business-search"
                        class="manager-filters__label"
                    >
                        {{ __('frontend.maskana.filter.search_business') }}
                    </label>

                    <div class="manager-filters__input-wrap">

                        <i class="bi bi-search" aria-hidden="true"></i>

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

            <!-- ==================================
                 PANEL PREMIOS
            =================================== -->


            <!-- ================================================
                 MASKANA - SPONSOR PRIZES
            ================================================ -->

            <div
                id="maskana-sheet-panel-prizes"
                class="maskana-sheet__panel"
                role="tabpanel"
                aria-labelledby="maskana-sheet-tab-prizes"
                data-maskana-panel="prizes"
                hidden
            >

                <section
                    class="maskana-prizes"
                    aria-label="Premios de auspiciantes"
                >

                    <!-- HEADER -->
                    <header class="maskana-prizes__header">

                        <div class="maskana-prizes__heading">

                            <h3 class="maskana-prizes__title">
                                <i class="bi bi-gift-fill" aria-hidden="true"></i>
                                Premios de auspiciantes
                            </h3>

                            <p class="maskana-prizes__subtitle">
                                Descubre los premios de Maskana.
                            </p>

                        </div>

                        <span class="maskana-prizes__total">
                {{ count($maskanaPrizes) }} premios
            </span>

                    </header>

                    <!-- SCROLLABLE GRID -->
                    <div class="maskana-prizes__grid">

                        @foreach($maskanaPrizes as $prize)

                            <article
                                class="maskana-prizes__card {{ $prize['status'] === 'EXPIRED' ? 'maskana-prizes__card--expired' : '' }}"
                                data-prize-id="{{ $prize['id'] }}"
                            >

                                <!-- IMAGE -->
                                <div class="maskana-prizes__media">

                                    <img
                                        src="{{ $prize['source'] }}"
                                        alt="{{ $prize['name'] }}"
                                        class="maskana-prizes__image"
                                        loading="lazy"
                                    >

                                    <span
                                        class="maskana-prizes__status maskana-prizes__status--{{ strtolower($prize['status']) }}"
                                    >
                            @switch($prize['status'])
                                            @case('ACTIVE')
                                                Vigente
                                                @break

                                            @case('UPCOMING')
                                                Próximamente
                                                @break

                                            @default
                                                Vencido
                                        @endswitch
                        </span>

                                </div>

                                <!-- CONTENT -->
                                <div class="maskana-prizes__content">

                                    <!-- BUSINESS -->
                                    <div class="maskana-prizes__business">

                                        <div class="maskana-prizes__business-avatar">
                                            @if($prize['business_logo'])
                                                <img
                                                    src="{{ $prize['business_logo'] }}"
                                                    alt=""
                                                    class="maskana-prizes__business-logo"
                                                    loading="lazy"
                                                >
                                            @else
                                                <i
                                                    class="bi bi-shop"
                                                    aria-hidden="true"
                                                ></i>
                                            @endif
                                        </div>

                                        <span class="maskana-prizes__business-name">
                                {{ $prize['business_name'] }}
                            </span>

                                    </div>

                                    <!-- PRIZE -->
                                    <h4 class="maskana-prizes__name">
                                        {{ $prize['name'] }}
                                    </h4>

                                    <p class="maskana-prizes__description">
                                        {{ $prize['description'] }}
                                    </p>

                                    <!-- EXPIRATION -->
                                    <div class="maskana-prizes__expiration">

                                        <i
                                            class="bi bi-calendar-event"
                                            aria-hidden="true"
                                        ></i>

                                        <span>
                                Vence:
                                <strong>
                                    {{ $prize['end_at']->format('d/m/Y') }}
                                </strong>
                            </span>

                                    </div>

                                    <!-- VIEW DETAIL -->
                                    <button
                                        type="button"
                                        class="maskana-prizes__view"
                                        data-maskana-prize-view
                                        data-prize-id="{{ $prize['id'] }}"
                                        data-prize-name="{{ $prize['name'] }}"
                                        data-prize-business="{{ $prize['business_name'] }}"
                                        data-prize-description="{{ $prize['description'] }}"
                                        data-prize-image="{{ $prize['source'] }}"
                                        data-prize-start="{{ $prize['start_at']->format('d/m/Y') }}"
                                        data-prize-end="{{ $prize['end_at']->format('d/m/Y') }}"
                                        data-prize-status="{{ $prize['status'] }}"
                                    >
                                        <i
                                            class="bi bi-arrows-fullscreen"
                                            aria-hidden="true"
                                        ></i>

                                        <span>Ver premio</span>
                                    </button>

                                </div>

                            </article>

                        @endforeach

                    </div>

                </section>

            </div>


        </div>

        <!-- ======================================
             FOOTER - SOLO PARA FILTROS
        ======================================= -->

        <footer
            id="maskana-sheet-footer"
            class="maskana-sheet__footer"
        >

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

        </footer>

    </div>

</section>
