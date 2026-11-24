<!-- MANAGER-EMPRESAS(CMS)-BUSINESS-->
@extends('layouts.cityBook')
@section('additional-styles')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        #listing-submission-form #listing_cats, #nearby-checkbox:checked + #use-nearby-label, .accordion a.toggle.act-accordion, .add-list, .addfield, .author-social a, .available-cal-months .cal-date-checked, .available_counter, .back-to-filters, .back-to-filters span, .box-item a.gal-link, .box-widget-item .list-single-tags a, .btn-unlock-month, .btn.flat-btn, .btn.transparent-btn:hover, .card-btn, .card-btn:hover, .cart-count, .chat-counter, .chat-error-message, .chat-item:after, .chat-replies-lmore span, .chat-replies-loading span, .cluster div, .color-bg, .color-overlay, .count-select-ser, .cs-countdown-item:before, .cs-social li a, .ctb-modal-close, .cth-dropdown-options input[type=checkbox]:checked + label, .custom-form .log-submit-btn, .custom-form .nice-select, .custom-form .nice-select .list li.selected, .custom-form .nice-select .list li:hover, .custom-form .quantity input.qty, .custom-form .selectbox, .dashboard-listing-table-opt li a.del-btn, .del-btn, .error-wrap form .search-submit, .folio-counter, .footer-menu li:before, .footer-widget #subscribe-button, .fs-map-btn, .header-search-button, .header-search-select-item .nice-select .list li.selected, .header-search-select-item .nice-select .list li:hover, .header-sec-link a, .header-social li a:hover, .hs-nav .navslide-wrap.next-slide-wrap a, .infoBox-close, .irs-bar, .irs-bar-edge, .irs-slider, .jspDrag, .lfilter-submit, .lg-actions .lg-next, .lg-actions .lg-prev, .list-author-widget-socials a, .list-single-main-wrapper .breadcrumbs, .list-widget-social li a, .listing-carousel-wrap .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active, .listing-counter, .listing-verified, .listing-view-layout li a, .listsearch-input-item .nice-select, .listsearch-input-item .nice-select .list li.selected, .listsearch-input-item .nice-select .list li.selected.focus, .listsearch-input-item .nice-select .list li:hover, .listsearch-input-item .selectbox, .load-more-button, .loading-indicator span, .log-out-btn:hover, .main-search-button, .main-search-input-item .nice-select .list li.selected, .main-search-input-item .nice-select .list li:hover, .map-popup-category, .mapnavigation a:hover, .mapzoom-in, .mapzoom-out, .mb-btns-wrap, .mb-open-filter, .message-input button, .more-filter-option span, .more-photos-button, .nav-holder nav li.current-menu-ancestor > a:before, .nav-holder nav li.current-menu-item > a:before, .nav-holder nav li.current-menu-parent > a:before, .navslide-wrap, .ol-control button, .pac-item:hover, .pagination .nav-links > span.current, .pagination a.current-page, .pagination a:hover, .parallax-section .section-separator:before, .photoUpload, .pin, .price-head, .price-link, .profile-edit-page-header .breadcrumbs a:before, .protected-wrap input[type=submit], .rangeslider__fill, .remove-date-time:hover, .reply-time span:before, .reviews-comments-item-text .new-dashboard-item:hover, .scroll-nav-wrapper .scroll-nav li a:before, .section-separator:before, .section-title .breadcrumbs a:before, .section-title .woocommerce-breadcrumb a:before, .selectbox li:hover, .showshare, .slick-dots li.slick-active button, .slide-progress, .sp-cont:hover, .step-item, .submit-field-wkhour .addfieldssss, .submit-field-wkhour .chosen-tz, .submit-field-wkhour .tabs-menu .active, .subscribe-form .subscribe-button, .sw-btn, .sw-btn.swiper-button-next, .sw-btn.swiper-button-prev, .tabs-menu li.current a, .tabs-menu li a:hover, .tagcloud a, .testi-counter, .testimonials-carousel .slick-current .testimonilas-text, .time-line-container:before, .to-top, .tooltipwrap .tooltiptext, .trs-btn, .typing-indicator, .typing-indicator:after, .typing-indicator:before, .user-profile-menu li a span, .video-box-btn, .widget-posts-link span, .widget_search .search-submit, .your-reply .reply-text, nav li a.act-link:before {
            background: #4db7fe;
        }

        .to-top--bee {

            display: none !important;
        }

        .card-listing .geodir-category-location a.map-item:before {
            content: "Ver";
            left: 0px !important;
            top: 21px !important;
            right: 0px;
        }

        .select2-container {
            text-align: left;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            font-size: 26px;
        }

        .card-listing .geodir-category-img img {


            width: 100%;
            height: 194px !important;

        }
    </style>
    <style id="filters-manager">
        /* =========================================
   YAPITA BUSINESS FILTER
   ========================================= */

        .yapita-business-filter {
            --ybf-primary: #3558df;
            --ybf-secondary: #ffcc00;
            --ybf-text: #10194f;
            --ybf-muted: #68738a;
            --ybf-background: #ffffff;
            --ybf-surface: #f4f6fc;
            --ybf-border: #d9e1f2;
            --ybf-radius: 16px;
            --ybf-gap: 10px;
            --ybf-sticky-top: 0px;
            --ybf-z-index: 1020;

            position: relative;
            width: 100%;
            padding: 12px;
            color: var(--ybf-text);
            background: var(--ybf-background);
            border: 1px solid var(--ybf-border);
            border-radius: var(--ybf-radius);
            box-shadow: 0 4px 16px rgb(16 25 79 / 8%);
            box-sizing: border-box;
        }

        .yapita-business-filter [hidden] {
            display: none !important;
        }

        /* =========================================
           STICKY POSITION
           ========================================= */

        /* =========================================
     FILTER POSITION MANAGER
     ========================================= */

        .yapita-business-filter.yapita-business-filter--sticky {
            position: relative;
            width: 100%;
        }

        /* Estado fijo */

        .yapita-business-filter.yapita-business-filter--stuck {
            position: fixed;

            top: var(--ybf-sticky-top, 0px);
            left: var(--ybf-sticky-left, 0px);
            width: var(--ybf-sticky-width, 100%);

            z-index: var(--ybf-z-index, 1020);

            background: var(--ybf-background);
            border-radius: 0 0 12px 12px;
            box-shadow: 0 5px 15px rgb(16 25 79 / 14%);

            margin: 0;
        }

        /* Reserva el espacio original del filtro */

        .yapita-business-filter-placeholder {
            display: block;
            width: 100%;
            height: 0;
            padding: 0;
            margin: 0;
            border: 0;
            pointer-events: none;
            overflow-anchor: none;
        }
        /* Contenedor principal */

        .yapita-business-explorer {
            position: relative;
            overflow: visible;
            width: 100%;
        }

        /* =========================================
           SEARCH
           ========================================= */

        .yapita-business-filter__search {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 44px;
            padding: 0 14px;
            border: 1px solid var(--ybf-border);
            border-radius: 30px;
            background: var(--ybf-surface);
        }

        .yapita-business-filter__search > i {
            font-size: 19px;
        }

        .yapita-business-filter__search-input {
            width: 100%;
            min-width: 0;
            padding: 10px 0;
            border: 0;
            outline: none;
            background: transparent;
            color: var(--ybf-text);
            font-size: 16px;
        }

        .yapita-business-filter__search-input::placeholder {
            color: var(--ybf-muted);
            font-size: 13px;
        }

        .yapita-business-filter__search-input::-webkit-search-cancel-button {
            display: none;
        }

        .yapita-business-filter__search-clear {
            border: 0;
            padding: 4px;
            background: transparent;
            color: var(--ybf-muted);
        }

        .yapita-business-filter__search:focus-within {
            border-color: var(--ybf-primary);
            box-shadow: 0 0 0 3px rgb(53 88 223 / 10%);
        }

        /* =========================================
           MAIN CONTROLS
           ========================================= */

        .yapita-business-filter__controls {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: var(--ybf-gap);
            margin-top: 12px;
        }

        .yapita-business-filter__group {
            min-width: 0;
        }

        .yapita-business-filter__label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        /* =========================================
           BUSINESS TYPES
           ========================================= */

        .yapita-business-filter__types {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .yapita-business-filter__types::-webkit-scrollbar {
            display: none;
        }

        .yapita-business-filter__type {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1 0 auto;
            gap: 6px;
            min-height: 42px;
            padding: 8px 12px;
            border: 1px solid var(--ybf-border);
            border-radius: 24px;
            background: var(--ybf-surface);
            color: var(--ybf-text);
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            transition: background .2s, border-color .2s;
        }

        .yapita-business-filter__type i {
            font-size: 16px;
        }

        .yapita-business-filter__type--active {
            background: var(--ybf-secondary);
            border-color: var(--ybf-secondary);
            font-weight: 700;
        }

        /* =========================================
           CATEGORY
           ========================================= */

        .yapita-business-filter__select {
            min-height: 44px;
            border: 1px solid var(--ybf-border);
            border-radius: 24px;
            background-color: var(--ybf-surface);
            color: var(--ybf-text);
            font-size: 14px;
        }

        .yapita-business-filter__select:focus {
            border-color: var(--ybf-primary);
            box-shadow: 0 0 0 3px rgb(53 88 223 / 10%);
        }

        /* =========================================
           BUTTONS
           ========================================= */

        .yapita-business-filter__actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .yapita-business-filter__button {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 42px;
            padding: 8px 14px;
            border: 1px solid transparent;
            border-radius: 24px;
            color: var(--ybf-text);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .yapita-business-filter__button--more {
            flex: 1;
            background: #e7edff;
            color: var(--ybf-primary);
            border-color: #d4dfff;
        }

        .yapita-business-filter__button--clear {
            background: var(--ybf-surface);
        }

        .yapita-business-filter__button--apply {
            width: 100%;
            margin-top: 12px;
            background: var(--ybf-primary);
            color: #fff;
        }

        .yapita-business-filter__counter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            padding: 0 5px;
            border-radius: 50px;
            background: var(--ybf-primary);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
        }

        /* =========================================
           ACTIVE FILTERS
           ========================================= */

        .yapita-business-filter__active {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            padding: 8px;
            border-radius: 12px;
            background: var(--ybf-surface);
        }

        .yapita-business-filter__active-title {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
        }

        .yapita-business-filter__active-title i {
            color: var(--ybf-primary);
        }

        .yapita-business-filter__chips {
            display: flex;
            gap: 6px;
            min-width: 0;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .yapita-business-filter__chips::-webkit-scrollbar {
            display: none;
        }

        .yapita-business-filter__chip {
            display: inline-flex;
            align-items: center;
            flex-shrink: 0;
            gap: 7px;
            padding: 6px 10px;
            border-radius: 20px;
            background: #dce5ff;
            color: var(--ybf-text);
            font-size: 12px;
            white-space: nowrap;
        }

        .yapita-business-filter__chip-remove {
            padding: 2px;
            border: 0;
            background: transparent;
            color: inherit;
        }

        /* =========================================
           MORE FILTERS
           ========================================= */

        .yapita-business-filter__more-content {
            margin-top: 12px;
            padding: 14px;
            border: 1px solid var(--ybf-border);
            border-radius: 12px;
            background: var(--ybf-surface);
        }

        .yapita-business-filter__more-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .yapita-business-filter__more-fields {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 12px;
        }

        .yapita-business-filter__extra-field {
            min-width: 0;
        }

        /* =========================================
           ACCESSIBILITY
           ========================================= */

        .yapita-business-filter button:focus-visible {
            outline: 2px solid var(--ybf-primary);
            outline-offset: 2px;
        }

        /* =========================================
           TABLET >= 576px
           ========================================= */

        @media (min-width: 576px) {

            .yapita-business-filter__controls {
                grid-template-columns: 1fr 1fr;
            }

            .yapita-business-filter__group--types {
                grid-column: 1 / -1;
            }

            .yapita-business-filter__actions {
                align-self: end;
            }

            .yapita-business-filter__more-fields {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* =========================================
           DESKTOP >= 992px
           ========================================= */

        @media (min-width: 992px) {

            .yapita-business-filter {
                padding: 16px;
            }

            .yapita-business-filter__controls {
                grid-template-columns:
            minmax(0, 1.4fr)
            minmax(0, 1fr)
            auto;
                align-items: end;
                gap: 16px;
            }

            .yapita-business-filter__group--types {
                grid-column: auto;
            }

            .yapita-business-filter__type {
                font-size: 13px;
            }

            .yapita-business-filter__search-input::placeholder {
                font-size: 14px;
            }

            .yapita-business-filter__label {
                font-size: 14px;
            }
        }
    </style>
    @include('partials.bootstrap-05', ["allowCss" => true])
@endsection
@section('additional-scripts')
    @include('partials.bootstrap-05', ["allowJs" => true])
    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'libs/vue/pagination/index.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="{{URL::asset($resourcePathServer.'libs/geoxml3/geoxml3.js')}}"></script>
    <script id="filters-manager">
        const YapitaBusinessFilterConfig = {

            selector: '#yapita-business-filter',
            debounce: 400,
            sticky: {
                enabled: true,
                headerSelector: '.main-header',
                autoTop: true,
                forceHeaderHeight: true,
                offset: 0,
                top: 0,
                zIndex: 1020
            },

            features: {
                search: true,
                businessTypes: true,
                categories: true,
                moreFilters: true,
                activeFilters: true,
                clearButton: true
            },

            // =====================================
            // TEXTOS Y PLACEHOLDERS
            // =====================================

            texts: {
                searchPlaceholder:
                    'Buscar tiendas, productos o servicios...',

                typeLabel: '¿Qué buscas?',
                categoryLabel: 'Categoría',
                categoryPlaceholder: 'Todas las categorías',
                moreFilters: 'Más filtros',
                moreTitle: 'Filtros adicionales',
                activeFilters: 'Filtros activos',
                clear: 'Limpiar',
                apply: 'Ver resultados',
                searchLabel: 'Búsqueda',
                clearSearch: 'Limpiar búsqueda',
                removeFilter: 'Eliminar filtro',
                closeMore: 'Cerrar filtros'
            },

            // =====================================
            // VALORES INICIALES
            // =====================================

            defaults: {
                searchQuery: '',
                businessType: null,
                categoryId: null,
                subcategoryId: null,
                extra: {}
            },

            // Valores que no cuentan como filtros
            // y que se restauran al limpiar.

            emptyValues: {
                searchQuery: '',
                businessType: null,
                categoryId: null,
                subcategoryId: null,
                extra: {}
            },

            // =====================================
            // TIPOS DE EMPRESA
            // =====================================

            businessTypes: [
                {
                    id: 1,
                    value: 'PRODUCTS',
                    label: 'Productos',
                    icon: 'bi-cart3'
                },
                {
                    id: 2,
                    value: 'SERVICES',
                    label: 'Servicios',
                    icon: 'bi-wrench-adjustable'
                },
                {
                    id: 3,
                    value: 'BOTH',
                    label: 'Productos y servicios',
                    icon: 'bi-layers'
                }
            ],

            // =====================================
            // CATEGORIAS Y SUBCATEGORIAS
            // =====================================

            categories: [
                {
                    id: 1,
                    name: 'Comercios / Establecimientos',
                    icon: 'bi-shop',

                    subcategories: [
                        {id: 11, name: 'Abarrotes'},
                        {id: 12, name: 'Calzado'},
                        {id: 13, name: 'Estética y belleza'},
                        {id: 14, name: 'Otros'}
                    ]
                },
                {
                    id: 2,
                    name: 'Comida y Bebida',
                    icon: 'bi-cup-hot',

                    subcategories: [
                        {id: 21, name: 'Restaurantes'},
                        {id: 22, name: 'Cafeterías'},
                        {id: 23, name: 'Comida rápida'}
                    ]
                },
                {
                    id: 3,
                    name: 'Ocio / Turismo',
                    icon: 'bi-map',

                    subcategories: [
                        {id: 31, name: 'Hospedaje'},
                        {id: 32, name: 'Paseos turísticos'}
                    ]
                }
            ],

            // =====================================
            // FILTROS ADICIONALES
            // =====================================
            // Actualmente no tienes otros filtros.
            // Puedes dejar este arreglo vacío.

            extraFilters: [],

            // =====================================
            // EVENTOS
            // =====================================

            onChange: function (filters, metadata) {
                console.log('Filtros:', filters);
                console.log('Información:', metadata);
            }
        };
        const YapitaBusinessFilterUtils = {

            debounce(callback, delay = 400) {

                let timer = null;

                function debounced(...args) {
                    clearTimeout(timer);

                    timer = setTimeout(() => {
                        callback.apply(this, args);
                    }, delay);
                }

                debounced.cancel = function () {
                    clearTimeout(timer);
                };

                return debounced;
            },

            hasValue(value) {

                if (value === null || value === undefined) {
                    return false;
                }

                if (typeof value === 'string') {
                    return value.trim() !== '';
                }

                if (Array.isArray(value)) {
                    return value.length > 0;
                }

                return true;
            },

            sameValue(first, second) {

                if (first == null || second == null) {
                    return first == null && second == null;
                }

                return String(first) === String(second);
            },

            isActive(value, emptyValue = null) {

                if (!this.hasValue(value)) {
                    return false;
                }

                return !this.sameValue(value, emptyValue);
            },

            findById(items, id) {

                return (items || []).find(item =>
                    this.sameValue(item.id, id)
                ) || null;
            },

            findByValue(items, value) {

                return (items || []).find(item =>
                    this.sameValue(item.value, value)
                ) || null;
            },

            clone(data) {
                return JSON.parse(JSON.stringify(data));
            },

            createIcon(icon) {

                return $('<i>', {
                    class: 'bi ' + (icon || 'bi-tag'),
                    'aria-hidden': 'true'
                });
            },

            createOption(value, label) {

                return $('<option>', {
                    value: value,
                    text: label
                });
            },

            categoryValue(categoryId, subcategoryId) {

                if (this.hasValue(subcategoryId)) {
                    return `subcategory:${categoryId}:${subcategoryId}`;
                }

                if (this.hasValue(categoryId)) {
                    return `category:${categoryId}`;
                }

                return '';
            },

            parseCategoryValue(value) {

                const result = {
                    categoryId: null,
                    subcategoryId: null
                };

                if (!value) {
                    return result;
                }

                const [type, categoryId, subcategoryId] =
                    String(value).split(':');

                if (type === 'category') {
                    result.categoryId = categoryId;
                }

                if (type === 'subcategory') {
                    result.categoryId = categoryId;
                    result.subcategoryId = subcategoryId;
                }

                return result;
            }
        };

        class YapitaBusinessFilter {
            updateStickyPosition() {

                const sticky = this.config.sticky;
                const top = this.getStickyTop();

                this.$root.css({
                    '--ybf-sticky-top': `${top}px`,
                    '--ybf-z-index': sticky.zIndex
                });

                this.stickyObserver?.disconnect();

                if (!('IntersectionObserver' in window)) {
                    return;
                }

                this.stickyObserver = new IntersectionObserver(
                    entries => {

                        const entry = entries[0];

                        const isStuck =
                            !entry.isIntersecting &&
                            entry.boundingClientRect.bottom <= top;

                        this.$root.toggleClass(
                            'yapita-business-filter--stuck',
                            isStuck
                        );
                    },
                    {
                        root: null,
                        rootMargin: `-${top}px 0px 0px 0px`,
                        threshold: 0
                    }
                );

                if (this.$stickySentinel?.length) {

                    this.stickyObserver.observe(
                        this.$stickySentinel[0]
                    );
                }
            }
            getStickyTop() {

                const sticky = this.config.sticky;

                let top = Number(sticky.top) || 0;

                if (sticky.autoTop) {

                    const $header = $(sticky.headerSelector).first();

                    if ($header.length) {

                        const position = $header.css('position');

                        const isFixedHeader =
                            position === 'fixed' ||
                            position === 'sticky';

                        top = (
                            isFixedHeader ||
                            sticky.forceHeaderHeight
                        )
                            ? $header.outerHeight()
                            : 0;
                    }
                }

                return Math.max(
                    0,
                    top + (Number(sticky.offset) || 0)
                );
            }
            constructor(config) {

                this.config = $.extend(true, {}, config);
                this.utils = YapitaBusinessFilterUtils;

                this.$root = $(this.config.selector);

                if (this.$root.length !== 1) {
                    throw new Error(
                        'No se encontró un contenedor único para los filtros.'
                    );
                }

                this.state = this.utils.clone(
                    this.config.defaults
                );

                this.state.extra = this.state.extra || {};

                this.namespace = '.yapitaBusinessFilter';

                this.debouncedSearch = this.utils.debounce(
                    () => this.notify('search'),
                    this.config.debounce
                );

                this.stickyObserver = null;
                this.$stickySentinel = null;
                this.collapse = null;
            }

            // =====================================
            // INITIALIZATION
            // =====================================

            init(notify = true) {

                this.cacheElements();
                this.renderTexts();
                this.renderFeatures();
                this.renderBusinessTypes();
                this.renderCategories();
                this.renderExtraFilters();

                this.normalizeState();
                this.syncControls();

                this.initCollapse();
                this.initSticky();
                this.bindEvents();
                this.renderActiveFilters();

                if (notify) {
                    this.notify('init');
                }

                return this;
            }

            cacheElements() {

                this.$search = this.find('search');
                this.$types = this.find('business-types');
                this.$category = this.find('category');
                this.$extraFields = this.find('extra-fields');
                this.$morePanel = this.find('more-panel');
                this.$activeFilters = this.find('active-filters');
                this.$chips = this.find('chips');
                this.$filterCount = this.find('filter-count');
                this.$activeCount = this.find('active-count');
            }

            find(role) {
                return this.$root.find(`[data-role="${role}"]`);
            }

            action(action) {
                return this.$root.find(`[data-action="${action}"]`);
            }

            // =====================================
            // TEXTS
            // =====================================

            renderTexts() {

                const texts = this.config.texts;

                this.$root.find('[data-text]').each(function () {

                    const $element = $(this);
                    const key = $element.attr('data-text');

                    $element.text(texts[key] ?? '');
                });

                this.$search.attr({
                    placeholder: texts.searchPlaceholder,
                    'aria-label': texts.searchPlaceholder
                });

                this.action('clear-search')
                    .attr('aria-label', texts.clearSearch);

                this.action('close-more')
                    .attr('aria-label', texts.closeMore);
            }

            renderFeatures() {

                const features = this.config.features;

                this.$search.closest(
                    '.yapita-business-filter__search'
                ).prop('hidden', !features.search);

                this.$types.closest(
                    '.yapita-business-filter__group'
                ).prop('hidden', !features.businessTypes);

                this.$category.closest(
                    '.yapita-business-filter__group'
                ).prop('hidden', !features.categories);

                const hasExtraFilters =
                    this.config.extraFilters.length > 0;

                this.action('toggle-more').prop(
                    'hidden',
                    !features.moreFilters || !hasExtraFilters
                );

                this.action('clear-all').prop(
                    'hidden',
                    !features.clearButton
                );
            }

            // =====================================
            // BUSINESS TYPES
            // =====================================

            renderBusinessTypes() {

                this.$types.empty();

                this.config.businessTypes.forEach(type => {

                    const $button = $('<button>', {
                        type: 'button',
                        class: 'yapita-business-filter__type',
                        'data-action': 'select-type',
                        'data-value': type.value,
                        'aria-pressed': 'false'
                    });

                    $button.append(
                        this.utils.createIcon(type.icon),
                        $('<span>').text(type.label)
                    );

                    this.$types.append($button);
                });
            }

            // =====================================
            // CATEGORIES
            // =====================================

            renderCategories() {

                this.$category.empty();

                this.$category.append(
                    this.utils.createOption(
                        '',
                        this.config.texts.categoryPlaceholder
                    )
                );

                this.config.categories.forEach(category => {

                    // Permite seleccionar toda una categoría.
                    this.$category.append(
                        this.utils.createOption(
                            `category:${category.id}`,
                            category.name
                        )
                    );

                    const subcategories =
                        category.subcategories || [];

                    if (!subcategories.length) {
                        return;
                    }

                    const $group = $('<optgroup>', {
                        label: category.name
                    });

                    subcategories.forEach(subcategory => {

                        $group.append(
                            this.utils.createOption(
                                `subcategory:${category.id}:${subcategory.id}`,
                                subcategory.name
                            )
                        );
                    });

                    this.$category.append($group);
                });
            }

            // =====================================
            // EXTRA FILTERS
            // =====================================

            renderExtraFilters() {

                this.$extraFields.empty();

                this.config.extraFilters.forEach((field, index) => {

                    const fieldId = `ybf-extra-${index}`;

                    const $wrapper = $('<div>', {
                        class: 'yapita-business-filter__extra-field'
                    });

                    const $label = $('<label>', {
                        class: 'yapita-business-filter__label',
                        for: fieldId,
                        text: field.label
                    });

                    let $input;

                    switch (field.type) {

                        case 'checkbox':

                            $input = $('<input>', {
                                type: 'checkbox',
                                class: 'form-check-input'
                            });

                            $wrapper.addClass('form-check');

                            break;

                        case 'select':

                            $input = $('<select>', {
                                class: 'form-select ' +
                                    'yapita-business-filter__select'
                            });

                            $input.append(
                                this.utils.createOption(
                                    '',
                                    field.placeholder || 'Seleccionar'
                                )
                            );

                            (field.options || []).forEach(option => {

                                $input.append(
                                    this.utils.createOption(
                                        option.value,
                                        option.label
                                    )
                                );
                            });

                            break;

                        default:

                            $input = $('<input>', {
                                type: 'text',
                                class: 'form-control',
                                placeholder: field.placeholder || ''
                            });

                            break;
                    }

                    $input.attr({
                        id: fieldId,
                        'data-role': 'extra-input',
                        'data-key': field.key
                    });

                    if (field.type === 'checkbox') {
                        $wrapper.append($input, $label);
                    } else {
                        $wrapper.append($label, $input);
                    }

                    this.$extraFields.append($wrapper);
                });
            }

            // =====================================
            // STATE VALIDATION
            // =====================================

            normalizeState() {

                const state = this.state;
                const features = this.config.features;
                const empty = this.config.emptyValues;

                state.searchQuery = features.search
                    ? String(state.searchQuery || '')
                    : empty.searchQuery;

                const businessType = this.utils.findByValue(
                    this.config.businessTypes,
                    state.businessType
                );

                state.businessType =
                    features.businessTypes && businessType
                        ? businessType.value
                        : empty.businessType;

                const category = this.utils.findById(
                    this.config.categories,
                    state.categoryId
                );

                if (!features.categories || !category) {

                    state.categoryId = null;
                    state.subcategoryId = null;

                } else {

                    state.categoryId = category.id;

                    const subcategory = this.utils.findById(
                        category.subcategories,
                        state.subcategoryId
                    );

                    state.subcategoryId =
                        subcategory ? subcategory.id : null;
                }

                const extra = {};

                if (features.moreFilters) {

                    this.config.extraFilters.forEach(field => {

                        let value = state.extra[field.key]
                            ?? field.emptyValue
                            ?? null;

                        if (field.type === 'checkbox') {
                            value = value === true;
                        }

                        if (
                            field.type === 'select' &&
                            !this.utils.findByValue(
                                field.options,
                                value
                            )
                        ) {
                            value = field.emptyValue ?? null;
                        }

                        extra[field.key] = value;
                    });
                }

                state.extra = extra;
            }

            // =====================================
            // SYNCHRONIZE UI
            // =====================================

            syncControls() {

                this.$search.val(this.state.searchQuery);

                this.action('clear-search').prop(
                    'hidden',
                    !this.state.searchQuery
                );

                this.action('select-type').each((index, element) => {

                    const $button = $(element);

                    const active = this.utils.sameValue(
                        $button.attr('data-value'),
                        this.state.businessType
                    );

                    $button.toggleClass(
                        'yapita-business-filter__type--active',
                        active
                    );

                    $button.attr('aria-pressed', String(active));
                });

                this.$category.val(
                    this.utils.categoryValue(
                        this.state.categoryId,
                        this.state.subcategoryId
                    )
                );

                this.$extraFields
                    .find('[data-role="extra-input"]')
                    .each((index, element) => {

                        const $input = $(element);
                        const key = $input.attr('data-key');
                        const value = this.state.extra[key];

                        if ($input.is(':checkbox')) {
                            $input.prop('checked', value === true);
                        } else {
                            $input.val(value ?? '');
                        }
                    });
            }

            // =====================================
            // EVENTS
            // =====================================

            bindEvents() {

                const ns = this.namespace;

                this.$root.off(ns);

                // Búsqueda con debounce.
                this.$root.on(
                    'input' + ns,
                    '[data-role="search"]',
                    event => {

                        this.state.searchQuery =
                            $(event.currentTarget).val();

                        this.action('clear-search').prop(
                            'hidden',
                            !this.state.searchQuery
                        );

                        this.renderActiveFilters();
                        this.debouncedSearch();
                    }
                );

                // Tipo de empresa.
                this.$root.on(
                    'click' + ns,
                    '[data-action="select-type"]',
                    event => {

                        const value = $(event.currentTarget)
                            .attr('data-value');

                        const current = this.state.businessType;

                        this.state.businessType =
                            this.utils.sameValue(current, value)
                                ? this.config.emptyValues.businessType
                                : value;

                        this.commit('businessType');
                    }
                );

                // Categorías y subcategorías.
                this.$root.on(
                    'change' + ns,
                    '[data-role="category"]',
                    event => {

                        const value = $(event.currentTarget).val();

                        const category =
                            this.utils.parseCategoryValue(value);

                        this.state.categoryId =
                            category.categoryId;

                        this.state.subcategoryId =
                            category.subcategoryId;

                        this.commit('category');
                    }
                );

                // Filtros adicionales.
                this.$root.on(
                    'change' + ns,
                    '[data-role="extra-input"]',
                    event => {

                        const $input = $(event.currentTarget);
                        const key = $input.attr('data-key');

                        this.state.extra[key] =
                            $input.is(':checkbox')
                                ? $input.is(':checked')
                                : $input.val();

                        this.commit('extra');
                    }
                );

                // Eliminar búsqueda.
                this.$root.on(
                    'click' + ns,
                    '[data-action="clear-search"]',
                    () => this.removeFilter('searchQuery')
                );

                // Eliminar filtro individual.
                this.$root.on(
                    'click' + ns,
                    '[data-action="remove-filter"]',
                    event => {

                        const key = $(event.currentTarget)
                            .attr('data-key');

                        this.removeFilter(key);
                    }
                );

                // Limpiar todos.
                this.$root.on(
                    'click' + ns,
                    '[data-action="clear-all"]',
                    () => this.clear()
                );

                // Mostrar filtros adicionales.
                this.$root.on(
                    'click' + ns,
                    '[data-action="toggle-more"]',
                    () => this.collapse.toggle()
                );

                this.$root.on(
                    'click' + ns,
                    '[data-action="close-more"]',
                    () => this.collapse.hide()
                );

                this.$morePanel.on(
                    'shown.bs.collapse' + ns,
                    () => this.action('toggle-more')
                        .attr('aria-expanded', 'true')
                );

                this.$morePanel.on(
                    'hidden.bs.collapse' + ns,
                    () => this.action('toggle-more')
                        .attr('aria-expanded', 'false')
                );
            }

            // =====================================
            // ACTIVE FILTERS
            // =====================================

            getActiveFilters() {

                const result = [];
                const state = this.state;
                const empty = this.config.emptyValues;

                // Búsqueda.
                if (
                    this.utils.isActive(
                        state.searchQuery,
                        empty.searchQuery
                    )
                ) {
                    result.push({
                        key: 'searchQuery',
                        label: state.searchQuery.trim(),
                        icon: 'bi-search'
                    });
                }

                // Tipo de empresa.
                const type = this.utils.findByValue(
                    this.config.businessTypes,
                    state.businessType
                );

                if (
                    type &&
                    this.utils.isActive(
                        state.businessType,
                        empty.businessType
                    )
                ) {
                    result.push({
                        key: 'businessType',
                        label: type.label,
                        icon: type.icon
                    });
                }

                // Categoría o subcategoría.
                const category = this.utils.findById(
                    this.config.categories,
                    state.categoryId
                );

                if (category) {

                    const subcategory = this.utils.findById(
                        category.subcategories,
                        state.subcategoryId
                    );

                    const categoryChanged =
                        this.utils.isActive(
                            state.categoryId,
                            empty.categoryId
                        );

                    const subcategoryChanged =
                        this.utils.isActive(
                            state.subcategoryId,
                            empty.subcategoryId
                        );

                    if (categoryChanged || subcategoryChanged) {

                        result.push({
                            key: 'category',
                            label: subcategory
                                ? `${category.name} / ${subcategory.name}`
                                : category.name,
                            icon: category.icon || 'bi-tag'
                        });
                    }
                }

                // Filtros adicionales.
                this.config.extraFilters.forEach(field => {

                    const value = state.extra[field.key];

                    const emptyValue = field.emptyValue
                        ?? (field.type === 'checkbox' ? false : null);

                    if (!this.utils.isActive(value, emptyValue)) {
                        return;
                    }

                    const option = this.utils.findByValue(
                        field.options,
                        value
                    );

                    const label = field.type === 'checkbox'
                        ? field.label
                        : `${field.label}: ${option?.label ?? value}`;

                    result.push({
                        key: `extra.${field.key}`,
                        label: label,
                        icon: field.icon || 'bi-sliders'
                    });
                });

                return result;
            }

            renderActiveFilters() {

                const filters = this.getActiveFilters();
                const count = filters.length;

                this.$chips.empty();

                filters.forEach(filter => {

                    const $chip = $('<span>', {
                        class: 'yapita-business-filter__chip'
                    });

                    const $remove = $('<button>', {
                        type: 'button',
                        class: 'yapita-business-filter__chip-remove',
                        'data-action': 'remove-filter',
                        'data-key': filter.key,
                        'aria-label':
                            `${this.config.texts.removeFilter}: ${filter.label}`
                    });

                    $remove.append(
                        this.utils.createIcon('bi-x-lg')
                    );

                    $chip.append(
                        this.utils.createIcon(filter.icon),
                        $('<span>').text(filter.label),
                        $remove
                    );

                    this.$chips.append($chip);
                });

                this.$activeCount.text(count);

                this.$filterCount
                    .text(count)
                    .prop('hidden', count === 0);

                this.$activeFilters.prop(
                    'hidden',
                    count === 0 ||
                    !this.config.features.activeFilters
                );
            }

            // =====================================
            // REMOVE FILTER
            // =====================================

            removeFilter(key) {

                const empty = this.config.emptyValues;

                switch (key) {

                    case 'searchQuery':

                        this.state.searchQuery =
                            empty.searchQuery;

                        break;

                    case 'businessType':

                        this.state.businessType =
                            empty.businessType;

                        break;

                    case 'category':

                        this.state.categoryId =
                            empty.categoryId;

                        this.state.subcategoryId =
                            empty.subcategoryId;

                        break;

                    default:

                        if (key.startsWith('extra.')) {

                            const fieldKey = key.substring(6);

                            const field =
                                this.config.extraFilters.find(
                                    item => item.key === fieldKey
                                );

                            if (field) {

                                this.state.extra[fieldKey] =
                                    field.emptyValue
                                    ?? (
                                        field.type === 'checkbox'
                                            ? false
                                            : null
                                    );
                            }
                        }

                        break;
                }

                this.commit('remove');
            }

            // =====================================
            // BOOTSTRAP COLLAPSE
            // =====================================

            initCollapse() {

                this.collapse = bootstrap.Collapse
                    .getOrCreateInstance(
                        this.$morePanel[0],
                        {toggle: false}
                    );
            }

            // =====================================
            // STICKY
            // =====================================

            initSticky() {

                const sticky = this.config.sticky;

                if (!sticky.enabled) {
                    return;
                }

                this.$root.addClass(
                    'yapita-business-filter--sticky'
                );

                // Elemento de referencia para detectar el scroll.

                this.$stickySentinel = $('<div>', {
                    'aria-hidden': 'true'
                }).css({
                    height: '1px',
                    pointerEvents: 'none'
                });

                this.$root.before(this.$stickySentinel);

                // Calcular posición inicial.

                this.updateStickyPosition();

                // Actualizar al cambiar las dimensiones
                // de la ventana.

                this.stickyResizeHandler = this.utils.debounce(
                    () => this.updateStickyPosition(),
                    100
                );

                $(window).on(
                    'resize' + this.namespace,
                    this.stickyResizeHandler
                );

                // Detectar cambios de altura del header.

                const header = $(sticky.headerSelector)[0];

                if (header && 'ResizeObserver' in window) {

                    this.headerResizeObserver = new ResizeObserver(
                        () => this.stickyResizeHandler()
                    );

                    this.headerResizeObserver.observe(header);
                }
            }

            // =====================================
            // PUBLIC METHODS
            // =====================================

            getFilters() {

                const state = this.utils.clone(this.state);

                state.searchQuery = state.searchQuery.trim();

                return state;
            }

            setFilters(values, notify = true) {

                this.state = {
                    ...this.state,
                    ...values,

                    extra: {
                        ...this.state.extra,
                        ...(values.extra || {})
                    }
                };

                this.commit('setFilters', notify);

                return this;
            }

            clear(notify = true) {

                this.state = this.utils.clone(
                    this.config.emptyValues
                );

                this.commit('clear', notify);

                return this;
            }

            reset(notify = true) {

                this.state = this.utils.clone(
                    this.config.defaults
                );

                this.commit('reset', notify);

                return this;
            }

            setCategories(categories, notify = true) {

                this.config.categories = categories || [];

                this.renderCategories();
                this.commit('categories', notify);

                return this;
            }

            setBusinessTypes(types, notify = true) {

                this.config.businessTypes = types || [];

                this.renderBusinessTypes();
                this.commit('businessTypes', notify);

                return this;
            }

            commit(reason, notify = true) {

                this.debouncedSearch.cancel();

                this.normalizeState();
                this.syncControls();
                this.renderActiveFilters();

                if (notify) {
                    this.notify(reason);
                }
            }

            notify(reason) {

                const filters = this.getFilters();
                const activeFilters = this.getActiveFilters();

                const metadata = {
                    reason: reason,
                    count: activeFilters.length,
                    activeFilters: activeFilters
                };

                if (typeof this.config.onChange === 'function') {

                    this.config.onChange(filters, metadata);
                }

                this.$root.trigger(
                    'yapita:filters:change',
                    [filters, metadata]
                );
            }

            destroy() {

                this.debouncedSearch.cancel();

                this.$root.off(this.namespace);
                this.$morePanel.off(this.namespace);

                // Eliminar eventos de la ventana.
                $(window).off(
                    'resize' + this.namespace,
                    this.stickyResizeHandler
                );

                this.stickyResizeHandler?.cancel();

                // Eliminar observadores.
                this.headerResizeObserver?.disconnect();
                this.stickyObserver?.disconnect();

                // Eliminar elementos auxiliares.
                this.$stickySentinel?.remove();
                this.collapse?.dispose();

                // Restaurar clases.
                this.$root.removeClass(
                    'yapita-business-filter--sticky ' +
                    'yapita-business-filter--stuck'
                );

                // Restaurar variables CSS.
                this.$root.css({
                    '--ybf-sticky-top': '',
                    '--ybf-z-index': ''
                });
            }
        }

        let businessFilterManager = null;
        const businessCategories = [
            {
                id: 1,
                name: 'Comercios / Establecimientos',
                icon: 'bi-shop',
                subcategories: [
                    {id: 11, name: 'Abarrotes'},
                    {id: 12, name: 'Calzado'},
                    {id: 13, name: 'Estética y belleza'},
                    {id: 14, name: 'Ropa y accesorios'},
                    {id: 15, name: 'Tecnología'},
                    {id: 16, name: 'Otros'}
                ]
            },
            {
                id: 2,
                name: 'Comida y Bebida',
                icon: 'bi-cup-hot',
                subcategories: [
                    {id: 21, name: 'Restaurantes'},
                    {id: 22, name: 'Cafeterías'},
                    {id: 23, name: 'Comida rápida'},
                    {id: 24, name: 'Panaderías y pastelerías'},
                    {id: 25, name: 'Bebidas'}
                ]
            },
            {
                id: 3,
                name: 'Ocio / Turismo',
                icon: 'bi-map',
                subcategories: [
                    {id: 31, name: 'Hospedaje'},
                    {id: 32, name: 'Paseos turísticos'},
                    {id: 33, name: 'Entretenimiento'},
                    {id: 34, name: 'Turismo comunitario'}
                ]
            },
            {
                id: 4,
                name: 'Salud y Bienestar',
                icon: 'bi-heart-pulse',
                subcategories: [
                    {id: 41, name: 'Farmacias'},
                    {id: 42, name: 'Centros médicos'},
                    {id: 43, name: 'Medicina natural'},
                    {id: 44, name: 'Gimnasios'}
                ]
            },
            {
                id: 5,
                name: 'Servicios Profesionales',
                icon: 'bi-briefcase',
                subcategories: [
                    {id: 51, name: 'Servicios tecnológicos'},
                    {id: 52, name: 'Servicios legales'},
                    {id: 53, name: 'Servicios contables'},
                    {id: 54, name: 'Diseño y publicidad'}
                ]
            },
            {
                id: 6,
                name: 'Arte y Cultura',
                icon: 'bi-palette',
                subcategories: [
                    {id: 61, name: 'Artesanías'},
                    {id: 62, name: 'Textiles'},
                    {id: 63, name: 'Música'},
                    {id: 64, name: 'Arte y pintura'}
                ]
            }
        ];
        const businessTypes = [
            {
                id: 1,
                value: 'PRODUCTS',
                label: 'Productos',
                icon: 'bi-cart3'
            },
            {
                id: 2,
                value: 'SERVICES',
                label: 'Servicios',
                icon: 'bi-wrench-adjustable'
            },
            {
                id: 3,
                value: 'BOTH',
                label: 'Productos y servicios',
                icon: 'bi-layers'
            }
        ];
        const defaultFilters = {
            searchQuery: '',
            businessType: null,
            categoryId: null,
            subcategoryId: null,
            extra: {}
        };

        $(function () {

            const config = {
                ...YapitaBusinessFilterConfig,

                categories: businessCategories,

                businessTypes: businessTypes,

                defaults: {
                    ...YapitaBusinessFilterConfig.defaults,
                    ...defaultFilters
                },

                onChange: function (filters, metadata) {

                    console.log(filters);
                    console.log(metadata);

                    // Actualizar mapa.
                    // Actualizar listado.
                    // Actualizar total de resultados.
                }
            };

            businessFilterManager =
                new YapitaBusinessFilter(config);

            businessFilterManager.init();
        });
    </script>

    <script>

        var $paramsRequest = <?php echo json_encode($paramsRequest) ?>;
        var markerIcon = {
            anchor: new google.maps.Point(22, 16),
            url: $resourceRoot + 'images/marker.png',
        };
        var $rootPageSingle = '{{route('listingSingle',app()->getLocale())}}';
        var $dataManagerPage =<?php echo json_encode($dataManagerPage) ?>;
        var $boundsCurrent = null;
        var $configManagerMap = {
            markers: [],
            managerCluster: null,
        };
    </script>
    <script>
        var initMarkerIndex = null;
        Vue.component('paginate', VuejsPaginate);
        var $currentApp;
        const app = new Vue(
            {
                directives: {
                    'init-listing-items': {
                        inserted: function (el, binding, vnode, vm, arg) {

                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },
                    'init-select': {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    }


                },
                el: '#app-management',
                created: function () {
                    $currentApp = this;
                    var $scope = this;
                    this.model.attributes.keywords = $dataManagerPage.paramsRequestCurrent.searchPhrase;
                    this.model.attributes.category = $dataManagerPage.paramsRequestCurrent.hasOwnProperty('categoryData') && $dataManagerPage.paramsRequestCurrent.categoryData.hasOwnProperty('id') ? $dataManagerPage.paramsRequestCurrent.categoryData : null;
                    $(function () {

                        if ($scope.model.attributes.category) {

                            $('.more-filter-option').click();
                        }
                        $scope.initManagement();

                    });
                },
                data: function () {
                    return {
                        managerLoading: {
                            map: {
                                view: true
                            },
                            data: {
                                view: true
                            },
                            page: {
                                view: true
                            }
                        },
                        businessData: [],
                        configGridAdmin: {
                            html: '',
                            isEmpty: false,
                            msj: {
                                empty: '<h1>No existe Datos</h1>',
                            }
                        },
                        configPagination: {
                            items: [],
                            itemActive: 0,
                            totalData: 0,
                            rowCountPerPage: 0,
                            currentPage: 0,
                            html: '',
                            view: {
                                init: 0,
                                to: 0,

                            }
                        },
                        model: {
                            attributes: {
                                'keywords': null,
                                'address-google': null,
                                'country': null,
                                'category': null,
                                'distance': 0,
                                'check': false,
                                currentPage: 0
                            }
                        }
                    };
                },
                methods: {
                    onListenElementsForm: onListenElementsForm,
                    initManagement: function () {

                        this._managerGrid($dataManagerPage.items);
                        this._eventsMapCurrent();
                        this.initMapCurrent();

                    },
                    getDataBusiness: function () {
                        var current = this.model.attributes.currentPage;
                        var searchPhrase = this.model.attributes.keywords;
                        var distance = this.model.attributes.distance;
                        var check = this.model.attributes.check;
                        var country_id = this.model.attributes.country;
                        var category_id = this.model.attributes.category;
                        var addressGoogleCountry = this.model.attributes['address-google'];
                        var dataSend = {
                            searchPhrase: searchPhrase,
                            current: current,
                            filters: {
                                check: check,
                                distance: distance,
                                country_id: country_id,
                                category_id: category_id,
                                addressGoogleCountry: addressGoogleCountry
                            }
                        };
                        $scope = this;
                        var url = $('#action-business-searchBusinessBee').val();
                        /*  $configManagerMap.markers*/
                        getAjaxRequest({
                            type: 'POST',
                            'url': url,
                            data: dataSend,
                            successCallback: function (response) {
                                $scope._managerGrid(response.items);
                                $scope.managerLoading.data.view = false;
                                $scope._resetManagerMaps(response.items);
                            },
                            beforeSend: function () {
                                $scope.managerLoading.data.view = true;

                            },

                        });
                    },
                    _resetManagerMaps: function (items) {
                        this._resetValuesMaps();
                        var locations = items.locationsItems;
                        var map = this.map;
                        managerMarkers({
                            map: map,
                            locations: locations,

                        });
                    },
                    _element: function (e) {
                        console.log(e);
                    },
                    getManagerPagination: function (listingManager) {
                        var totalData = listingManager.total;
                        var rowCountPerPage = listingManager.rowCount;
                        var currentPage = listingManager.current + 1;
                        var initialPage = listingManager.current == 0 ? listingManager.current : listingManager.current - 1;
                        var totalPages = totalData / rowCountPerPage;
                        var isMultiple = totalPages % 2;
                        if (isMultiple != 0) {
                            var resultPage = Math.floor(totalData / rowCountPerPage);
                            var resultCurrentData = resultPage * rowCountPerPage;
                            if (totalData > resultCurrentData) {
                                totalPages = resultPage + 1;

                            }
                        }

                        var configPagination = {
                            items: [],
                            itemActive: currentPage,
                            totalData: totalData,
                            rowCountPerPage: rowCountPerPage,
                            currentPage: currentPage,
                            totalPages: totalPages,
                            initialPage: initialPage
                        }

                        var viewPage = {
                            to: this.getViewDataTo(configPagination),
                            init: this.getViewDataInit(configPagination),
                        };
                        configPagination.view = viewPage;
                        return configPagination;
                    },
                    getViewDataInit: function (configPagination) {
                        var result = 1;
                        if (parseFloat(configPagination.initialPage) > 0) {
                            result = parseFloat(configPagination.initialPage) * parseFloat(configPagination.rowCountPerPage);
                        }

                        return result;
                    },
                    getViewDataTo: function (configPagination) {
                        var result = parseFloat(configPagination.rowCountPerPage);
                        if (parseFloat(configPagination.initialPage) > 0) {
                            result = parseFloat(configPagination.initialPage) * parseFloat(configPagination.rowCountPerPage);
                        }

                        return result;
                    },
                    _managerGrid: function (items) {
                        this.configGridAdmin.isEmpty = items['allow-data'] ? false : true;
                        this.configGridAdmin.html = '';
                        this.configPagination = this.getManagerPagination(items.listing);
                        this.configGridAdmin.html = items.listingHtml;

                    },
                    initMapCurrent: function () {
                        $scope = this;
                        $boundsCurrent = new google.maps.LatLngBounds();

                        function mainMap(params) {
                            var locations = params['dataCurrent']
                            var map = new google.maps.Map(document.getElementById('map-main'), {
                                zoom: 9,
                                scrollwheel: false,
                                center: new google.maps.LatLng(40.7, -73.87),
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                zoomControl: false,
                                mapTypeControl: false,
                                scaleControl: true,//
                                streetViewControl: false,
                                overviewMapControl: false,
                                panControl: false,
                                fullscreenControl: true,
                                navigationControl: false,
                                streetViewControl: false,
                                animation: google.maps.Animation.BOUNCE,
                                gestureHandling: 'cooperative',
                                styles: [{
                                    "featureType": "administrative",
                                    "elementType": "labels.text.fill",
                                    "stylers": [{
                                        "color": "#444444"
                                    }]
                                }]
                            });
                            var greyStyleMap = new google.maps.StyledMapType($greyscale_style, {
                                name: "Greyscale"
                            });
                            map.mapTypes.set('greyscale_style', greyStyleMap);
                            map.setMapTypeId('greyscale_style');
                            managerMarkers({
                                map: map,
                                locations: locations,

                            });

                            var scrollEnabling = $('.scrollContorl');

                            $(scrollEnabling).click(function (e) {
                                e.preventDefault();
                                $(this).toggleClass("enabledsroll");

                                if ($(this).is(".enabledsroll")) {
                                    map.setOptions({'scrollwheel': true});
                                } else {
                                    map.setOptions({'scrollwheel': false});
                                }
                            });
                            var zoomControlDiv = document.createElement('div');
                            var zoomControl = new ZoomControl(zoomControlDiv, map);

                            function ZoomControl(controlDiv, map) {
                                zoomControlDiv.index = 1;
                                map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
                                controlDiv.style.padding = '5px';
                                var controlWrapper = document.createElement('div');
                                controlDiv.appendChild(controlWrapper);
                                var zoomInButton = document.createElement('div');
                                zoomInButton.className = "mapzoom-in";
                                controlWrapper.appendChild(zoomInButton);
                                var zoomOutButton = document.createElement('div');
                                zoomOutButton.className = "mapzoom-out";
                                controlWrapper.appendChild(zoomOutButton);
                                google.maps.event.addDomListener(zoomInButton, 'click', function () {
                                    map.setZoom(map.getZoom() + 1);
                                });
                                google.maps.event.addDomListener(zoomOutButton, 'click', function () {
                                    map.setZoom(map.getZoom() - 1);
                                });
                            }

                            var m = map;
                            window.listingsMap = m;
                            var y = new CustomEvent("listingsMapInit", {detail: "mapInit"});
                            window.dispatchEvent(y)
                        }

                        var map = document.getElementById('map-main');
                        if (typeof (map) != 'undefined' && map != null) {
                            var locations = $dataManagerPage.items.locationsItems;

                            google.maps.event.addDomListener(window, 'load', mainMap({dataCurrent: locations}));

                        }
                    },
                    _resetValuesMaps: function () {

                        if ($configManagerMap.markers.length) {
                            $configManagerMap.markers.map(function (value, key) {
                                value.setMap(null);
                            });
                            $configManagerMap.managerCluster.clearMarkers();
                            $configManagerMap.markers = [];
                            $configManagerMap.managerCluster = [];
                        }
                    },
                    _eventsMapCurrent: function () {
                        $scope = this;
                        $scope.managerLoading.page.view = false;
                        $('.manager-page__data-page').show();
                        window.addEventListener('listingsMapInit', function (e) {
                            console.log('init listingsMapInit');
                            var scrollEnabling = $('.scrollContorl');
                            $(scrollEnabling).click();
                            $('.manager-page_map').show();
                            $scope.map = window.listingsMap;
                            $scope.map.fitBounds($boundsCurrent);
                            var configParamsDrawing = {
                                map: $scope.map,
                                'kmlGetType': 1,
                                source: "{{URL::asset($resourcePathServer.'assets/maps/ecuador/imbabura_province.kml')}}",
                                '_eventManager': $scope._initDrawingKmlGoogleMaps,
                                _hoverLay: $scope._hoverLayMap,
                                _clickLay: $scope._clickLayMap,

                            };

                            $scope.initDrawingKmlGoogleMaps(configParamsDrawing);

                            $scope.managerLoading.map.view = false;
                            $scope.managerLoading.data.view = false;
                        });
                    },
                    _initEventsMapSearch: function (params) {
                        console.log(params);
                    },
                    _initAutoCompleteGoogleMaps: function (params) {
                        console.log(params);
                    },
                    _codeAddressGoogleMaps: function (params) {
                        console.log(params);

                    },
                    _initDrawingKmlGoogleMaps: function (params) {
                        console.log(params);
                        this.map.fitBounds(params.bounds);

                    },
                    _hoverLayMap: function (params) {
                        console.log(params);
                        /*    overlay.title + '</h3>' + overlay.content +
                            var content =
                                '<div id="' + mapContainerId + '_dirContainer" style="bottom:0;padding-top:3px; font-size:13px;font-family:arial">'
                                + '<div  style="border-top:1px dotted #999;">'
                                + '<style>.BlitzMap_Menu:hover{text-decoration:underline; }</style>'
                                + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;" onclick="BlitzMap.getDirections()">Directions</span>'
                                + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Search nearby</span>'
                                + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Save to map</span>'
                                + '</div></div>';
                            return "";*/
                    },
                    _clickLayMap: function (params) {
                        console.log(params);

                    },
                    initDrawingKmlGoogleMaps: initDrawingKmlGoogleMaps,
                    initAutoCompleteGoogleMaps: initAutoCompleteGoogleMaps,
                    codeAddressGoogleMaps: codeAddressGoogleMaps,
                    _managerDataItemsMap: function (params) {
                        var cr2 = $(".card-popup-rainingvis");
                        cr2.each(function (cr) {
                            var starcount2 = $(this).attr("data-starrating2");
                            $("<i class='fa fa-star'></i>").duplicate(starcount2).prependTo(this);
                        });
                        var map = this.map;
                        $('.map-item').click(function (e) {
                            e.preventDefault();
                            map.setZoom(15);
                            var marker_index = parseInt($(this).attr('href').split('#')[1], 10);
                            google.maps.event.trigger($configManagerMap.markers[marker_index], "click");
                            if ($(this).hasClass("scroll-top-map")) {
                                $('html, body').animate({
                                    scrollTop: $(".map-container").offset().top + "-80px"
                                }, 500)
                            } else if ($(window).width() < 1064) {
                                $('html, body').animate({
                                    scrollTop: $(".map-container").offset().top + "-80px"
                                }, 500)
                            }
                        });

                        var markers = $configManagerMap.markers;
                        var r = markers;
                        $('#listing-items').on("mouseover", ".listing-item", function (e) {

                            var marker_index = parseInt($(this).attr('key-manager').split('#')[1], 10);
                            var t = marker_index;
                            initMarkerIndex = t;
                            r[t].setAnimation(google.maps.Animation.BOUNCE);
                        }).on("mouseout", ".listing-item", function (e) {
                            var marker_index = parseInt($(this).attr('key-manager').split('#')[1], 10);
                            var t = marker_index;
                            r[t].setAnimation();
                        });


                    },
                    _pageCurrent: function (pageNum) {
                        this.model.attributes.currentPage = pageNum;
                        this.getDataBusiness();
                        $("html,body").animate({
                            scrollTop: 0
                        }, {
                            queue: false,
                            duration: 1200,
                            easing: "easeInOutExpo"
                        });
                    },
                    initCategories: function (params) {
                        var el = params.elementInit
                        var dataCurrent = [];

                        if (this.model.attributes.category) {
                            dataCurrent = [
                                {
                                    'id': this.model.attributes.category.id,
                                    'text': this.model.attributes.category.text

                                }
                            ];


                        }
                        var $scope = this
                        var elementInit = $(el).select2({
                            allow: true,
                            placeholder: "Seleccione",
                            data: dataCurrent,
                            ajax: {
                                url: $("#action-business-categoriesSearchBee").val(),
                                type: 'get',
                                dataType: 'json',
                                data: function (term, page) {

                                    var paramsFilters = {
                                        filters: {
                                            search_value: term,
                                        }
                                    };
                                    return paramsFilters;
                                },
                                processResults: function (data, page) {
                                    return {results: data};
                                }
                            },
                            allowClear: true,
                            multiple: false,
                            width: '100%'
                        });

                        elementInit.on('select2:select', function (e) {
                            var data = e.params.data;
                            $scope.model.attributes.category = data.id;
                        }).on("select2:unselecting", function (e) {
                            $scope.model.attributes.category = null;


                        });
                    }
                }
            })
        ;

        function managerMarkers(params) {

            var markerCluster, marker, i;
            var map = params.map;
            var locations = params.locations;

            var clusterStyles = [{
                textColor: 'white',
                url: '',
                height: 50,
                width: 50
            }];

            function locationData(data) {
                locationURL = data.url, locationCategory = data.category, locationImg = data.img, locationTitle = data.title, locationAddress = data.address, locationPhone = data.phone, locationStarRating = data.rating, locationRevievsCounter = data.reviewCount;
                return ('<div class="map-popup-wrap"><div class="map-popup"><div class="infoBox-close"><i class="fa fa-times"></i></div><div class="map-popup-category">' + locationCategory + '</div><a href="' + locationURL + '" class="listing-img-content fl-wrap"><img src="' + locationImg + '" alt=""></a> <div class="listing-content fl-wrap"><div class="card-popup-raining map-card-rainting" data-staRrating="' + locationStarRating + '"><span class="map-popup-reviews-count">( ' + locationRevievsCounter + ' reviews )</span></div><div class="listing-title fl-wrap"><h4><a href=' + locationURL + '>' + locationTitle + '</a></h4><span class="map-popup-location-info"><i class="fa fa-map-marker"></i>' + locationAddress + '</span><span class="map-popup-location-phone"><i class="fa fa-phone"></i>' + locationPhone + '</span></div></div></div></div>')
            }

            for (i = 0; i < locations.length; i++) {
                var positionCurrent = locations[i].location;
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(positionCurrent.lat, positionCurrent.lng),
                    icon: markerIcon,
                    id: i
                });
                $boundsCurrent.extend(marker.position);
                $configManagerMap.markers.push(marker);
                var ib = new InfoBox();
                google.maps.event.addListener(ib, "domready", function () {
                    cardRaining();
                });
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        var positionCurrentMarker = locations[i].location;
                        ib.setOptions(boxOptions);
                        boxText.innerHTML = locationData(locations[i]);
                        ib.close();
                        ib.open(map, marker);
                        currentInfobox = marker.id;
                        var latLng = new google.maps.LatLng(positionCurrentMarker.lat, positionCurrentMarker.lng);
                        map.panTo(latLng);
                        map.panBy(0, -180);
                        google.maps.event.addListener(ib, 'domready', function () {
                            $('.infoBox-close').click(function (e) {
                                e.preventDefault();
                                ib.close();
                            });
                        });
                    }
                })(marker, i));
            }
            var options = {
                imagePath: $resourceRoot + "images/cluster",
                styles: clusterStyles,
                minClusterSize: 2
            };


            var mcOptions = {

                //imagePath: pathDevelopers + "assets/images/cluster/",
                styles: [{
                    height: 53,
                    url: $resourceRoot + "images/cluster/1.png",
                    width: 53,
                    fontFamily: "comic sans ms",
                    textSize: 15,
                    textColor: "red",
                    //color: #00FF00,
                },
                    {
                        height: 56,
                        url: $resourceRoot + "images/cluster/2.png",
                        width: 56,
                        fontFamily: "comic sans ms",
                        textSize: 15,
                        textColor: "red",
                        color: "#00FF00",
                    },
                    {
                        height: 66,
                        url: $resourceRoot + "images/cluster/3.png",
                        width: 66
                    },
                    {
                        height: 78,
                        url: $resourceRoot + "images/cluster/4.png",
                        width: 78
                    },
                    {
                        height: 90,
                        url: $resourceRoot + "images/cluster/5.png",
                        width: 90
                    }]

            }

            markerCluster = new MarkerClusterer(map, $configManagerMap.markers, options);
            $configManagerMap.managerCluster = markerCluster;
            google.maps.event.addDomListener(window, "resize", function () {
                var center = map.getCenter();
                google.maps.event.trigger(map, "resize");
                map.setCenter(center);
            });
            var boxText = document.createElement("div");
            boxText.className = 'map-box'
            var currentInfobox;
            var boxOptions = {
                content: boxText,
                disableAutoPan: true,
                alignBottom: true,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-145, -45),
                zIndex: null,
                boxStyle: {
                    width: "260px"
                },
                closeBoxMargin: "0",
                closeBoxURL: "",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false,
            };

            $('.nextmap-nav').click(function (e) {
                e.preventDefault();
                map.setZoom(15);
                var index = currentInfobox;
                if (index + 1 < $configManagerMap.markers.length) {
                    google.maps.event.trigger($configManagerMap.markers[index + 1], 'click');
                } else {
                    google.maps.event.trigger($configManagerMap.markers[0], 'click');
                }
            });
            $('.prevmap-nav').click(function (e) {
                e.preventDefault();
                map.setZoom(15);
                if (typeof (currentInfobox) == "undefined") {
                    google.maps.event.trigger($configManagerMap.markers[$configManagerMap.markers.length - 1], 'click');
                } else {
                    var index = currentInfobox;
                    if (index - 1 < 0) {
                        google.maps.event.trigger($configManagerMap.markers[$configManagerMap.markers.length - 1], 'click');
                    } else {
                        google.maps.event.trigger($configManagerMap.markers[index - 1], 'click');
                    }
                }
            });

            // Scroll enabling button
        }
    </script>

@endsection
@section('content')
    <div id="app-management">
        <section
            id="yapita-business-filter"
            class="yapita-business-filter not-view"
        >
            <!-- BUSCADOR -->
            <div class="yapita-business-filter__search">
                <i class="bi bi-search"></i>

                <input
                    type="search"
                    class="yapita-business-filter__search-input"
                    data-role="search"
                    autocomplete="off"
                >

                <button
                    type="button"
                    class="yapita-business-filter__search-clear"
                    data-action="clear-search"
                    aria-label="Limpiar búsqueda"
                    hidden
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- FILTROS PRINCIPALES -->
            <div class="yapita-business-filter__controls">

                <!-- TIPOS DE EMPRESA -->
                <div class="yapita-business-filter__group
                    yapita-business-filter__group--types">

                    <label
                        class="yapita-business-filter__label"
                        data-text="typeLabel"
                    ></label>

                    <div
                        class="yapita-business-filter__types"
                        data-role="business-types"
                    ></div>
                </div>

                <!-- CATEGORIAS Y SUBCATEGORIAS -->
                <div class="yapita-business-filter__group
                    yapita-business-filter__group--category">

                    <label
                        class="yapita-business-filter__label"
                        data-text="categoryLabel"
                        for="ybf-category"
                    ></label>

                    <select
                        id="ybf-category"
                        class="form-select yapita-business-filter__select"
                        data-role="category"
                    ></select>
                </div>

                <!-- ACCIONES -->
                <div class="yapita-business-filter__actions">

                    <button
                        type="button"
                        class="yapita-business-filter__button
                       yapita-business-filter__button--more"
                        data-action="toggle-more"
                        aria-expanded="false"
                        aria-controls="ybf-more"
                    >
                        <i class="bi bi-sliders"></i>

                        <span data-text="moreFilters"></span>

                        <span
                            class="yapita-business-filter__counter"
                            data-role="filter-count"
                            hidden
                        >0</span>
                    </button>

                    <button
                        type="button"
                        class="yapita-business-filter__button
                       yapita-business-filter__button--clear"
                        data-action="clear-all"
                    >
                        <i class="bi bi-x-lg"></i>
                        <span data-text="clear"></span>
                    </button>
                </div>
            </div>

            <!-- FILTROS ADICIONALES -->
            <div
                id="ybf-more"
                class="collapse yapita-business-filter__more"
                data-role="more-panel"
            >
                <div class="yapita-business-filter__more-content">

                    <div class="yapita-business-filter__more-header">
                        <strong data-text="moreTitle"></strong>

                        <button
                            type="button"
                            class="btn-close"
                            data-action="close-more"
                            aria-label="Cerrar filtros"
                        ></button>
                    </div>

                    <div
                        class="yapita-business-filter__more-fields"
                        data-role="extra-fields"
                    ></div>

                    <button
                        type="button"
                        class="yapita-business-filter__button
                       yapita-business-filter__button--apply"
                        data-action="close-more"
                        data-text="apply"
                    ></button>

                </div>
            </div>

            <!-- FILTROS ACTIVOS -->
            <div
                class="yapita-business-filter__active"
                data-role="active-filters"
                hidden
            >
                <div class="yapita-business-filter__active-title">
                    <i class="bi bi-funnel-fill"></i>
                    <span data-text="activeFilters"></span>
                    (<span data-role="active-count">0</span>)
                </div>

                <div
                    class="yapita-business-filter__chips"
                    data-role="chips"
                ></div>
            </div>

        </section>

        <div class="loading-page" v-if="managerLoading.page.view">
            <div class="listings-loader"><i class="fa fa-spinner fa-pulse fa-3x"></i></div>

        </div>
        <div class="data-page not-view manager-page__data-page">
            <!-- Map -->
            <div class="map-container column-map right-pos-map">
                <div class="loading-page manager-page__loading-map" v-if="managerLoading.map.view">
                    <div class="listings-loader"><i class="fa fa-spinner fa-pulse fa-3x"></i></div>

                </div>
                <div class="not-view manager-page_map">

                    <div id="map-main"></div>
                    <ul class="mapnavigation">
                        <li><a href="#" class="prevmap-nav">{{__('frontend.menu.search.pagination.prev')}}</a></li>
                        <li><a href="#" class="nextmap-nav">{{__('frontend.menu.search.pagination.next')}}</a></li>
                    </ul>
                    <div class="scrollContorl mapnavbtn" title="Enable Scrolling"><span><i
                                class="fa fa-lock"></i></span>
                    </div>
                </div>
            </div>
            <!-- Map end -->
            <!--col-list-wrap -->
            <div class="col-list-wrap left-list">
                <div class="listsearch-options fl-wrap" id="lisfw">
                    <div class="container">
                        <div class="listsearch-header fl-wrap">
                            <h3>{{__('frontend.menu.search.filters.title')}}
                                <span>{{__('gamification.your_search')}} </span></h3>
                            <div class="listing-view-layout">
                                <ul>
                                    <li><a class="grid active" href="#"><i class="fa fa-th-large"></i></a></li>
                                    <li><a class="list" href="#"><i class="fa fa-list-ul"></i></a></li>
                                    <li><a href="#" class="expand-listing-view"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- listsearch-input-wrap  -->
                        <div class="listsearch-input-wrap fl-wrap">
                            <div class="listsearch-input-text">
                                <label><i class="mbri-map-pin"></i> {{__('frontend.menu.search.filters.keywords')}}
                                </label>
                                <i class="mbri-key single-i"></i>
                                <input type="text" id="keywords"
                                       placeholder="{{__('frontend.menu.home.filters.keywords')}}"
                                       name="keywords"
                                       v-model.trim="model.attributes.keywords"/>
                            </div>

                            <div class="listsearch-input-text not-view" id="autocomplete-container">
                                <label><i class="mbri-map-pin"></i> {{__('frontend.menu.search.filters.location')}}
                                </label>
                                <input type="text"
                                       placeholder="{{__('frontend.menu.search.filters.location')}}  , Area , Street"
                                       id="autocomplete-input"
                                       class="qodef-archive-places-search" name="address-google"
                                       v-model.trim="model.attributes['address-google']" value=""/>
                                <a href="#" class="loc-act qodef-archive-current-location"><i
                                        class="fa fa-dot-circle-o"></i></a>
                            </div>
                            <!-- hidden-listing-filter -->
                            <div class="hidden-listing-filter fl-wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select
                                            v-init-select="{initMethod:initCategories}"
                                            id="initCategories"
                                            name="category"
                                            v-model.trim="model.attributes.category"
                                            data-placeholder="{{__('frontend.menu.search.filters.category')}} "
                                            class="">
                                        </select>
                                    </div>
                                </div>


                                <div class="distance-input fl-wrap not-view">
                                    <div class="distance-title"> Radius around selected destination <span></span> km
                                    </div>
                                    <div class="distance-radius-wrap fl-wrap">
                                        <input name="distance"
                                               v-model.trim="model.attributes.distance"
                                               class="distance-radius rangeslider--horizontal" type="range" min="1"
                                               max="100" step="1" value="1"
                                               v-on:change="_element"
                                               data-title="Radius around selected destination">
                                    </div>
                                </div>
                                <!-- Checkboxes -->
                                <div class=" fl-wrap filter-tags not-view">
                                    <h4>Filter by Tags</h4>
                                    <input v-on:change="_element" id="check-aa" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-aa">Elevator in building</label>
                                    <input v-on:change="_element" id="check-b" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-b">Friendly workspace</label>
                                    <input v-on:change="_element" id="check-c" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-c">Instant Book</label>
                                    <input v-on:change="_element" id="check-d" type="checkbox" name="check"
                                           v-model.trim="model.attributes.check">
                                    <label for="check-d">Wireless Internet</label>
                                </div>
                            </div>
                            <!-- hidden-listing-filter end -->
                            <button class="button fs-map-btn"
                                    v-on:click="getDataBusiness">{{__('frontend.menu.search.filters.button')}}</button>
                            <div class="more-filter-option">{{__('frontend.menu.search.filters.more-filters')}}
                                <span>

                                </span>
                            </div>
                        </div>
                        <!-- listsearch-input-wrap end -->
                    </div>
                </div>
                <!-- list-main-wrap-->
                <div class="list-main-wrap fl-wrap card-listing">
                    <a class="custom-scroll-link back-to-filters btf-l" href="#lisfw"><i
                            class="fa fa-angle-double-up"></i><span>{{__('frontend.menu.search.filters.button.back')}}</span></a>

                    <!-- end col-md-8 -->
                    <div class="listings-loader" v-if="managerLoading.data.view"><i
                            class="fa fa-spinner fa-pulse fa-3x"></i></div>

                    <div class="container" id="listing-items"
                         v-if="!managerLoading.data.view && !configGridAdmin.isEmpty"
                         v-init-listing-items="{initMethod:_managerDataItemsMap}"
                         v-html="configGridAdmin.html"
                    >
                    </div>
                    <div class="class" v-if="!managerLoading.data.view && configGridAdmin.isEmpty"
                         v-html="configGridAdmin.msj.empty">

                    </div>
                    <div class="listings-pagination-wrap" v-if="!managerLoading.data.view && !configGridAdmin.isEmpty">
                        <span class="section-separator"></span>
                        <div class="row">
                            <div class="col-sm-6">
                                <paginate
                                    :page-count="configPagination.totalPages"
                                    :page-range="3"
                                    :initial-page="configPagination.initialPage"
                                    :margin-pages="2"
                                    :click-handler="_pageCurrent"
                                    :prev-text="'Prev'"
                                    :next-text="'Next'"
                                    :container-class="'pagination pagination--custom'"
                                    :page-class="'page-item'">
                                </paginate>
                            </div>
                            <div class="col-sm-6 infoBar">

                                <div
                                    class="infos">{{__('gamification.showing')}} <?php echo '{{configPagination.view.init}}' ?>
                                    - <?php echo '{{configPagination.view.to}}' ?>
                                    de <?php echo '{{configPagination.totalData}}' ?> </div>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- list-main-wrap end-->

            </div>


            <!--col-list-wrap -->


            <div class="limit-box fl-wrap"></div>
            <!--section -->
            @if(!Auth::check())
                @include('layouts.partials.cityBook.join')

            @endif
        </div>


    </div>
    <input id="action-business-searchBusinessBee" type="hidden"
           value="{{ route("searchBusinessBee",app()->getLocale()) }}"/>
@endsection
