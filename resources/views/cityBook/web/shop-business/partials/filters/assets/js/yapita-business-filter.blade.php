<script>
    const YapitaBusinessFilterConfigVersion = {
        select2: {
            enabled: true,
            category: {
                enabled: true,
                allowClear: true,
                minimumResultsForSearch: 0
            },
            subcategory: {
                enabled: true,
                multiple: true,
                allowClear: true,
                closeOnSelect: false,
                maximumSelectionLength: 0
            }
        },
        selector: '#yapita-business-filter',
        debounce: 400,
        initialResults: 0,
        emitOnInit: true,
        // =========================================
        // FIXED / STICKY
        // =========================================
        sticky: {
            enabled: true,
            headerSelector: '.main-header',
            autoTop: true,
            forceHeaderHeight: true,
            offset: 0,
            top: 0,
            zIndex: 1020
        },
        // =========================================
        // CHILD / ASIDE
        // =========================================
        aside: {
            selector: '#yapita-business-filter-aside',
            backdrop: true,
            keyboard: true,
            scroll: false
        },
        // =========================================
        // FEATURES
        // =========================================
        features: {
            search: true,
            businessTypes: true,
            categories: true,
            moreFilters: true,
            activeFilters: true,
            clearButton: true
        },
        // =========================================
        // TEXTS
        // =========================================
        texts: {
            subcategoryLabel: 'Subcategorías',
            subcategoryPlaceholder: 'Seleccionar subcategorías',
            subcategoryHelp: 'Puedes seleccionar varias subcategorías.',
            subcategoryEmptyHelp: 'Selecciona primero una categoría.',
            subcategoryNoResults: 'No existen subcategorías disponibles.',
            subcategorySelected: 'seleccionadas',
            selectNoResults: 'No se encontraron resultados',
            selectSearching: 'Buscando...',
            distancePrefix: 'Hasta',
            diameterLabel: 'Diámetro',
            distanceDescription: 'Encuentra negocios dentro de este radio.',
            // Parent
            searchPlaceholder: 'Buscar tiendas, productos o servicios...',
            searchLabel: 'Buscar negocios',
            clearSearch: 'Limpiar búsqueda',
            moreFilters: 'Filtros',
            activeFilters: 'Filtros activos',
            resultsLabel: 'No. empresas:',
            clearAll: 'Eliminar todos los filtros',
            removeFilter: 'Eliminar filtro',
            // Child
            moreTitle: 'Filtros',
            moreDescription: 'Encuentra negocios según lo que necesitas.',
            typeLabel: '¿Qué buscas?',
            categoryLabel: 'Categoría',
            categoryPlaceholder: 'Todas las categorías',
            clear: 'Limpiar',
            apply: 'Ver resultados',
            closeMore: 'Cerrar filtros'
        },
        // =========================================
        // DEFAULT VALUES
        // =========================================
        defaults: {
            searchQuery: '',
            businessType: null,
            categoryId: null,
            subcategoryIds: [],
            extra: {
                onlyPromotions: false,
                radius: 6
            }
        },
        emptyValues: {
            searchQuery: '',
            businessType: null,
            categoryId: null,
            subcategoryIds: [],
            extra: {
                onlyPromotions: false,
                radius: 6
            }
        },
        // =========================================
        // BUSINESS TYPES
        // =========================================
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
        // =========================================
        // CATEGORIES / SUBCATEGORIES
        // =========================================
        categories: $categories,
        // =========================================
        // EXTRA FILTERS
        // =========================================
        extraFilters: [
            // PROMOCIONES
            {
                key: 'onlyPromotions',
                type: 'switch',
                label: 'Con promociones',
                activeLabel: 'Promociones',
                description: 'Promociones vigentes',
                icon: 'bi-percent',
                defaultValue: false,
                emptyValue: false,
                enabled: true
            },
            // DISTANCIA
            {
                key: 'radius',
                type: 'range',
                label: 'Radio de búsqueda',
                description: 'Distancia desde el centro de búsqueda.',
                icon: 'bi-geo-alt',
                unit: 'km',
                min: 1,
                max: 20,
                step: 1,
                marks: [1, 5, 10, 15, 20],
                defaultValue: 6,
                emptyValue: 6,
                enabled: true
            }
        ],
        // =========================================
        // EVENTS
        // =========================================
        onChange: function (filters, metadata) {

            const self = this;



                // Ignore outdated filters
                if (
                    self.isDestroyed ||
                    metadata.revision !== self.revision
                ) {
                    return;
                }

                console.log('ACTION:', metadata.action);

                console.log('FILTERS:', filters);

                console.log('METADATA:', metadata);

                // =============================================
                // DATA FOR BACKEND
                // =============================================

                const params = {

                    searchQuery: filters.searchQuery,

                    businessType: filters.businessType,

                    categoryId: filters.categoryId,

                    subcategoryIds: filters.subcategoryIds,

                    onlyPromotions: filters.extra.onlyPromotions,

                    radius: filters.extra.radius
                };

                console.log('PARAMS:', params);

                // =============================================
                // LEAFLET INFORMATION
                // =============================================

                const radiusKm = filters.extra.radius;

                const radiusMeters = radiusKm * 1000;

                const diameterKm = radiusKm * 2;

                const diameterMeters = radiusMeters * 2;

                console.log({
                    radiusKm,
                    radiusMeters,
                    diameterKm,
                    diameterMeters
                });

                // =============================================
                // YOUR BUSINESS REQUEST
                // =============================================

                // searchNearbyBusinesses(params);

                // After receiving results:
                // self.setResults(total, metadata.revision);


        }
    };
    // =========================================================
    // YAPITA BUSINESS FILTER - CONFIGURATION
    // =========================================================
    // =========================================================
    // YAPITA BUSINESS FILTER - CORE
    // =========================================================
    class YapitaBusinessFilter {
        // =====================================================
// LIVE FILTERS - APPLY WITHOUT CLOSING ASIDE
// =====================================================

        applyLiveFilters(action = 'live-filter') {

            if (!this.draft || this.isDestroyed) {
                return this;
            }

            this.cancelSearchTimer();

            const nextState = this.clone(this.draft);

            // Preserve parent search
            nextState.searchQuery = this.state.searchQuery;

            // Normalize new state
            const normalizedState = this.normalizeState(nextState);

            // Prevent duplicate events
            const hasChanges =
                JSON.stringify(this.state) !==
                JSON.stringify(normalizedState);

            if (!hasChanges) {
                return this;
            }

            // Update main state
            this.state = normalizedState;

            // Synchronize child state
            this.draft = this.clone(this.state);

            // Update parent: chips, badge, clear button
            this.render();

            // Update child actions
            this.renderDraftActions();

            // Notify external components
            this.emitChange(action);

            return this;
        }
        constructor(config) {
            this.config = config;
            this.namespace = '.yapitaBusinessFilter';
            // PARENT
            this.$root = $(config.selector);
            this.$anchor = this.$root.closest(
                '.yapita-business-filter-anchor'
            );
            // CHILD
            this.$aside = $(config.aside.selector);
            // HEADER
            this.$header = $(config.sticky.headerSelector);
            // VALIDATIONS
            if (!this.$root.length) {
                throw new Error(
                    'YapitaBusinessFilter: parent not found.'
                );
            }
            if (!this.$aside.length) {
                throw new Error(
                    'YapitaBusinessFilter: aside not found.'
                );
            }
            if (typeof bootstrap === 'undefined') {
                throw new Error(
                    'YapitaBusinessFilter: Bootstrap JS is required.'
                );
            }
            // INTERNAL PROPERTIES
            this.searchTimer = null;
            this.stickyFrame = null;
            this.resizeObserver = null;
            this.handleDocumentScroll = null;
            this.offcanvas = null;
            this.isStuck = false;
            this.isAsideOpen = false;
            this.isDestroyed = false;
            this.revision = 0;
            this.totalResults = Math.max(
                0,
                Number(config.initialResults) || 0
            );
            // EMPTY VALUES
            this.emptyValues = this.buildEmptyValues();
            // MAIN STATE
            this.state = this.normalizeState(
                $.extend(
                    true,
                    {},
                    this.emptyValues,
                    config.defaults
                )
            );
            // CHILD TEMPORARY STATE
            this.draft = null;
            // INITIALIZATION
            this.init();
        }

        // =====================================================
        // INITIALIZATION
        // =====================================================
        init() {
            this.cacheElements();
            this.initTexts();
            this.initFeatures();
            this.initAside();
            this.initSelect2();
            this.bindParentEvents();
            this.bindChildEvents();
            this.initSticky();
            this.render();
            if (this.config.emitOnInit !== false) {
                this.emitChange('init');
            }
            return this;
        }

        // =====================================================
        // HELPERS
        // =====================================================
        clone(value) {
            return JSON.parse(JSON.stringify(value));
        }

        hasProperty(object, key) {
            return Object.prototype.hasOwnProperty.call(
                object,
                key
            );
        }

        getExtraFilters() {
            return (this.config.extraFilters || [])
                .filter(filter => filter.enabled !== false);
        }

        getCategory(categoryId) {
            return (this.config.categories || [])
                .find(category =>
                    String(category.id) === String(categoryId)
                ) || null;
        }

        getBusinessType(value) {
            return (this.config.businessTypes || [])
                .find(type => type.value === value) || null;
        }

        getExtraFilter(key) {
            return this.getExtraFilters()
                .find(filter => filter.key === key) || null;
        }

        getSubcategory(categoryId, subcategoryId) {
            const category = this.getCategory(categoryId);
            return (category?.subcategories || [])
                .find(subcategory =>
                    String(subcategory.id) ===
                    String(subcategoryId)
                ) || null;
        }

        buildEmptyValues() {
            const values = $.extend(true, {
                searchQuery: '',
                businessType: null,
                categoryId: null,
                subcategoryIds: [],
                extra: {}
            }, this.config.emptyValues);
            this.getExtraFilters().forEach(filter => {
                if (this.hasProperty(filter, 'emptyValue')) {
                    values.extra[filter.key] =
                        filter.emptyValue;
                } else if (
                    !this.hasProperty(values.extra, filter.key)
                ) {
                    values.extra[filter.key] =
                        filter.defaultValue ?? null;
                }
            });
            return values;
        }

        // =====================================================
        // CACHE DOM ELEMENTS
        // =====================================================
        cacheElements() {
            const parent = role =>
                this.$root.find(`[data-role="${role}"]`);
            const child = role =>
                this.$aside.find(`[data-role="${role}"]`);
            // PARENT ELEMENTS
            this.parent = {
                searchContainer: parent('search-container'),
                search: parent('search'),
                clearSearch: parent('clear-search'),
                openMore: parent('open-more'),
                filterLabel: parent('filter-label'),
                filterCount: parent('filter-count'),
                results: parent('results'),
                resultsLabel: parent('results-label'),
                resultsCount: parent('results-count'),
                activeFilters: parent('active-filters'),
                clearAll: parent('clear-all')
            };
            // CHILD ELEMENTS
            this.child = {
                subcategoryCount: child('subcategory-count'),
                subcategoryHelp: child('subcategory-help'),
                title: child('aside-title'),
                description: child('aside-description'),
                close: child('close-more'),
                typesSection: child('business-types-section'),
                types: child('business-types'),
                typeLabel: child('type-label'),
                categorySection: child('category-section'),
                category: child('category'),
                categoryLabel: child('category-label'),
                subcategorySection: child('subcategory-section'),
                subcategory: child('subcategory'),
                subcategoryLabel: child('subcategory-label'),
                extraFilters: child('extra-filters'),
                clear: child('clear-draft'),
                clearLabel: child('clear-label'),
                apply: child('apply'),
                applyLabel: child('apply-label')
            };
        }

        // =====================================================
        // TEXTS
        // =====================================================
        initTexts() {
            const texts = this.config.texts;
            // PARENT
            this.parent.search.attr({
                placeholder: texts.searchPlaceholder,
                'aria-label': texts.searchLabel
            });
            this.parent.clearSearch.attr({
                title: texts.clearSearch,
                'aria-label': texts.clearSearch
            });
            this.parent.filterLabel.text(
                texts.moreFilters
            );
            this.parent.resultsLabel.text(
                texts.resultsLabel
            );
            this.parent.activeFilters.attr(
                'aria-label',
                texts.activeFilters
            );
            this.parent.clearAll.attr({
                title: texts.clearAll,
                'aria-label': texts.clearAll
            });
            // CHILD
            this.child.title.text(
                texts.moreTitle
            );
            this.child.description.text(
                texts.moreDescription
            );
            this.child.typeLabel.text(
                texts.typeLabel
            );
            this.child.categoryLabel.text(
                texts.categoryLabel
            );
            this.child.subcategoryLabel.text(
                texts.subcategoryLabel
            );
            this.child.clearLabel.text(
                texts.clear
            );
            this.child.applyLabel.text(
                texts.apply
            );
            this.child.close.attr({
                title: texts.closeMore,
                'aria-label': texts.closeMore
            });
        }

        // =====================================================
        // FEATURES
        // =====================================================
        initFeatures() {
            const features = this.config.features;
            this.parent.searchContainer.prop(
                'hidden',
                !features.search
            );
            this.parent.openMore.prop(
                'hidden',
                !features.moreFilters
            );
            this.child.typesSection.prop(
                'hidden',
                !features.businessTypes
            );
            this.child.categorySection.prop(
                'hidden',
                !features.categories
            );
            this.child.extraFilters.prop(
                'hidden',
                this.getExtraFilters().length === 0
            );
        }

        // =====================================================
        // STATE NORMALIZATION
        // =====================================================
        normalizeState(input) {
            const features = this.config.features;
            const result = {
                ...this.clone(this.emptyValues), ...this.clone(input),
                extra: {...this.emptyValues.extra, ...(input.extra || {})}
            };
            // SEARCH
            result.searchQuery = features.search
                ? String(result.searchQuery ?? '').trim()
                : '';
            // BUSINESS TYPE
            const type = this.getBusinessType(
                result.businessType
            );
            result.businessType = features.businessTypes && type
                ? type.value
                : null;
            // CATEGORY
            const category = this.getCategory(
                result.categoryId
            );
            if (!features.categories || !category) {
                result.categoryId = null;
                result.subcategoryIds = [];
            } else {
                result.categoryId = category.id;
                const ids = Array.isArray(result.subcategoryIds) ? result.subcategoryIds : [];
                result.subcategoryIds = (category.subcategories || [])
                    .filter(item => ids.some(id => String(id) === String(item.id)))
                    .map(item => item.id);
            }
            // EXTRA FILTERS
            const extra = {};
            this.getExtraFilters().forEach(filter => {
                let value = result.extra?.[filter.key];
                if (value === undefined || value === null) {
                    value = this.emptyValues.extra[filter.key];
                }
                switch (filter.type) {
                    case 'switch':
                        value = (
                            value === true ||
                            value === 1 ||
                            value === '1' ||
                            value === 'true'
                        );
                        break;
                    case 'range':
                        value = Number(value);
                        if (!Number.isFinite(value)) {
                            value = Number(
                                filter.defaultValue ?? filter.min
                            );
                        }
                        value = Math.min(
                            filter.max,
                            Math.max(filter.min, value)
                        );
                        const step = Number(filter.step) || 1;
                        value = filter.min + Math.round(
                            (value - filter.min) / step
                        ) * step;
                        value = Math.min(
                            filter.max,
                            Math.max(filter.min, value)
                        );
                        value = Number(value.toFixed(8));
                        break;
                }
                extra[filter.key] = value;
            });
            delete result.subcategoryId;
            result.extra = extra;
            return result;
        }

        // =====================================================
        // GETTERS
        // =====================================================
        getFilters() {
            return this.clone(this.state);
        }

        getDraft() {
            return this.draft
                ? this.clone(this.draft)
                : null;
        }

        // =====================================================
        // SET FILTERS
        // =====================================================
        setFilters(filters, action = 'external') {
            this.cancelSearchTimer();
            const next = {
                ...this.getFilters(), ...this.clone(filters),
                extra: {...this.state.extra, ...(filters.extra || {})}
            };
            if (this.hasProperty(filters, 'categoryId') &&
                String(filters.categoryId) !== String(this.state.categoryId) &&
                !this.hasProperty(filters, 'subcategoryIds')) next.subcategoryIds = [];
            this.state = this.normalizeState(next);
            if (this.draft !== null || this.isAsideOpen) {
                this.draft = this.getFilters();
                this.renderAside();
            }
            this.render();
            return this.emitChange(action);
        }

        // =====================================================
        // CLEAR ALL FILTERS
        // =====================================================
        // =====================================================
// CLEAR ALL FILTERS - PARENT AND CHILD
// =====================================================
        clearFilters(action = 'clear-all') {
            // Cancelar búsquedas pendientes
            this.cancelSearchTimer();
            // Restaurar estado principal
            this.state = this.normalizeState(
                this.clone(this.emptyValues)
            );
            // Sincronizar estado temporal del aside
            if (this.isAsideOpen || this.draft !== null) {
                this.draft = this.clone(this.state);
                this.renderAside();
            }
            // Actualizar completamente el parent
            this.render();
            // Notificar una sola vez
            this.emitChange(action);
            return this;
        }

        // =====================================================
        // REMOVE INDIVIDUAL FILTER
        // =====================================================
        removeFilter(key) {
            const nextState = this.getFilters();
            if (key.startsWith('subcategoryIds.')) {
                const id = key.slice('subcategoryIds.'.length);
                nextState.subcategoryIds = nextState.subcategoryIds.filter(v => String(v) !== id);
                return this.setFilters(nextState, 'remove-filter');
            }
            switch (key) {
                case 'searchQuery':
                    nextState.searchQuery = '';
                    break;
                case 'businessType':
                    nextState.businessType = null;
                    break;
                case 'categoryId':
                    nextState.categoryId = null;
                    nextState.subcategoryIds = [];
                    break;
                case 'subcategoryIds':
                    nextState.subcategoryIds = [];
                    break;
                default:
                    if (!key.startsWith('extra.')) {
                        return this;
                    }
                    const extraKey = key.substring(6);
                    const filter = this.getExtraFilter(extraKey);
                    if (!filter) {
                        return this;
                    }
                    nextState.extra[extraKey] =
                        this.emptyValues.extra[extraKey];
                    break;
            }
            return this.setFilters(
                nextState,
                'remove-filter'
            );
        }

        // =====================================================
        // ACTIVE FILTERS
        // =====================================================
        getActiveFilters(state = this.state) {
            const active = [];
            // BUSINESS TYPE
            const type = this.getBusinessType(
                state.businessType
            );
            if (type) {
                active.push({
                    key: 'businessType',
                    value: type.value,
                    label: type.label,
                    icon: type.icon
                });
            }
            // CATEGORY
            const category = this.getCategory(
                state.categoryId
            );
            if (category) {
                active.push({
                    key: 'categoryId',
                    value: category.id,
                    label: category.name,
                    icon: category.icon
                });
                (state.subcategoryIds || []).forEach(id => {
                    const item = this.getSubcategory(category.id, id);
                    if (item) active.push({
                        key: `subcategoryIds.${item.id}`, value: item.id,
                        label: item.name, icon: 'bi-tags'
                    });
                });
            }
            // EXTRA FILTERS
            this.getExtraFilters().forEach(filter => {
                const value = state.extra[filter.key];
                const emptyValue =
                    this.emptyValues.extra[filter.key];
                if (value === emptyValue) {
                    return;
                }
                let label = filter.activeLabel || filter.label;
                if (filter.type === 'range') {
                    label = `${value} ${filter.unit || ''}`.trim();
                }
                active.push({
                    key: `extra.${filter.key}`,
                    value: value,
                    label: label,
                    icon: filter.icon
                });
            });
            return active;
        }

        // =====================================================
        // METADATA
        // =====================================================
        getMetadata(action = 'change') {
            const activeFilters = this.getActiveFilters();
            const hasSearch = this.state.searchQuery.length > 0;
            return {
                action: action,
                revision: this.revision,
                activeCount: activeFilters.length,
                hasActiveFilters: activeFilters.length > 0,
                hasSearch: hasSearch,
                hasChanges: (
                    hasSearch ||
                    activeFilters.length > 0
                ),
                activeFilters: activeFilters,
                radiusKm: this.state.extra.radius,
                radiusMeters: this.state.extra.radius * 1000,
                diameterKm: this.state.extra.radius * 2,
                diameterMeters: this.state.extra.radius * 2000,
                totalResults: this.totalResults
            };
        }

        // =====================================================
        // RENDER PARENT
        // =====================================================
        render(options = {}) {
            const metadata = this.getMetadata();
            const features = this.config.features;
            // SEARCH
            if (options.syncSearch !== false) {
                if (
                    this.parent.search.val() !==
                    this.state.searchQuery
                ) {
                    this.parent.search.val(
                        this.state.searchQuery
                    );
                }
            }
            this.parent.clearSearch.prop(
                'hidden',
                !metadata.hasSearch
            );
            // FILTER BUTTON
            this.parent.openMore.toggleClass(
                'yapita-business-filter__filter-button--active',
                metadata.hasActiveFilters
            );
            // BADGE
            this.parent.filterCount
                .text(metadata.activeCount)
                .prop(
                    'hidden',
                    !metadata.hasActiveFilters
                );
            // ACTIVE FILTERS
            this.renderActiveFilters(
                metadata.activeFilters
            );
            this.parent.activeFilters.prop(
                'hidden',
                !features.activeFilters ||
                !metadata.hasActiveFilters
            );
            // CLEAR ALL
            this.parent.clearAll.prop(
                'hidden',
                !features.clearButton ||
                !metadata.hasChanges
            );
            // TOTAL RESULTS
            this.parent.resultsCount.text(
                this.totalResults
            );
            // FIXED
            this.scheduleSticky();
            return this;
        }

        // =====================================================
        // RENDER ACTIVE FILTER CHIPS
        // =====================================================
        renderActiveFilters(filters) {
            const $container = this.parent.activeFilters;
            const previousScroll = $container.scrollLeft();
            $container.empty();
            if (!this.config.features.activeFilters) {
                return;
            }
            filters.forEach(filter => {
                const $chip = $('<div>', {
                    class: 'yapita-business-filter__chip',
                    'data-filter-key': filter.key
                });
                const $label = $('<span>', {
                    class: 'yapita-business-filter__chip-label',
                    text: filter.label
                });
                const removeLabel =
                    `${this.config.texts.removeFilter}: ${filter.label}`;
                const $remove = $('<button>', {
                    type: 'button',
                    class: 'yapita-business-filter__chip-remove',
                    'data-role': 'remove-filter',
                    'data-filter-key': filter.key,
                    'aria-label': removeLabel,
                    title: removeLabel
                });
                $remove.append(
                    $('<i>', {
                        class: 'bi bi-x-lg',
                        'aria-hidden': 'true'
                    })
                );
                $chip.append(
                    $label,
                    $remove
                );
                $container.append($chip);
            });
            $container.scrollLeft(previousScroll);
        }

        // =====================================================
        // RESULTS MANAGEMENT
        // =====================================================
        setResults(total, revision = null) {
            if (this.isDestroyed) {
                return this;
            }
            // IGNORE OLD API RESPONSES
            if (
                revision !== null &&
                revision !== this.revision
            ) {
                return this;
            }
            const value = Number(total);
            this.totalResults = Number.isFinite(value)
                ? Math.max(0, Math.trunc(value))
                : 0;
            this.parent.resultsCount.text(
                this.totalResults
            );
            this.scheduleSticky();
            return this;
        }

        // =====================================================
        // PARENT EVENTS
        // =====================================================
        bindParentEvents() {
            const self = this;
            const ns = this.namespace;
            this.$root.off(ns);
            // SEARCH INPUT
            this.$root.on(
                `input${ns}`,
                '[data-role="search"]',
                function (event) {
                    if (event.originalEvent?.isComposing) {
                        return;
                    }
                    self.handleSearchInput($(this).val());
                }
            );
            // IME COMPOSITION END
            this.$root.on(
                `compositionend${ns}`,
                '[data-role="search"]',
                function () {
                    self.handleSearchInput($(this).val());
                }
            );
            // ENTER
            this.$root.on(
                `keydown${ns}`,
                '[data-role="search"]',
                function (event) {
                    if (
                        event.key !== 'Enter' ||
                        event.originalEvent?.isComposing
                    ) {
                        return;
                    }
                    event.preventDefault();
                    self.cancelSearchTimer();
                    self.state.searchQuery =
                        String($(this).val() || '').trim();
                    self.render();
                    self.emitChange('search');
                }
            );
            // CLEAR SEARCH
            this.$root.on(
                `click${ns}`,
                '[data-role="clear-search"]',
                function () {
                    self.removeFilter('searchQuery');
                    self.parent.search.trigger('focus');
                }
            );
            // OPEN CHILD
            this.$root.on(
                `click${ns}`,
                '[data-role="open-more"]',
                function () {
                    self.openAside();
                }
            );
            // REMOVE CHIP
            this.$root.on(
                `click${ns}`,
                '[data-role="remove-filter"]',
                function () {
                    const key = $(this).attr(
                        'data-filter-key'
                    );
                    if (key) {
                        self.removeFilter(key);
                    }
                }
            );
            // CLEAR ALL
            this.$root.on(
                `click${ns}`,
                '[data-role="clear-all"]',
                function () {
                    self.clearFilters();
                }
            );
        }

        // =====================================================
        // SEARCH MANAGEMENT
        // =====================================================
        handleSearchInput(value) {
            const query = String(value || '').trim();
            if (query === this.state.searchQuery) {
                return;
            }
            this.state.searchQuery = query;
            // INVALIDATE PREVIOUS REQUESTS IMMEDIATELY
            this.revision++;
            if (this.draft) {
                this.draft.searchQuery = query;
            }
            this.render({
                syncSearch: false
            });
            this.cancelSearchTimer();
            this.searchTimer = setTimeout(() => {
                this.searchTimer = null;
                this.emitChange('search');
            }, this.config.debounce ?? 400);
        }

        cancelSearchTimer() {
            if (this.searchTimer !== null) {
                clearTimeout(this.searchTimer);
                this.searchTimer = null;
            }
        }

        flushSearch() {
            if (this.searchTimer !== null) {
                this.cancelSearchTimer();
                this.emitChange('search');
            }
        }

        // =====================================================
        // CHILD / ASIDE INITIALIZATION
        // =====================================================
        initAside() {
            this.offcanvas =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.$aside[0],
                    {
                        backdrop: this.config.aside.backdrop,
                        keyboard: this.config.aside.keyboard,
                        scroll: this.config.aside.scroll
                    }
                );
        }

        // =====================================================
        // OPEN ASIDE
        // =====================================================
        openAside() {
            if (
                !this.config.features.moreFilters ||
                this.isAsideOpen ||
                this.isDestroyed
            ) {
                return this;
            }
            this.flushSearch();
            this.draft = this.clone(this.state);
            this.renderAside();
            this.offcanvas.show(
                this.parent.openMore[0]
            );
            return this;
        }

        // =====================================================
        // CLOSE ASIDE
        // =====================================================
        closeAside() {
            this.offcanvas?.hide();
            return this;
        }

        // =====================================================
        // APPLY DRAFT
        // =====================================================
        applyDraft() {
            if (!this.draft) {
                return this;
            }
            this.cancelSearchTimer();
            const nextState = this.clone(this.draft);
            // SEARCH BELONGS TO PARENT
            nextState.searchQuery = this.state.searchQuery;
            this.state = this.normalizeState(nextState);
            this.render();
            this.closeAside();
            this.emitChange('apply');
            return this;
        }

        // =====================================================
        // CLEAR DRAFT
        // =====================================================
        // =====================================================
// CLEAR DRAFT - SYNCHRONIZE PARENT AND CHILD
// =====================================================
        clearDraft() {
            return this.clearFilters('clear-draft');
        }

        // =====================================================
        // RENDER CHILD
        // =====================================================
        renderAside() {
            if (!this.draft) {
                return;
            }
            this.renderBusinessTypes();
            this.renderCategories();
            this.renderSubcategories();
            this.renderExtraFilters();
            this.renderDraftActions();
        }

        // =====================================================
// RENDER DRAFT ACTIONS
// =====================================================
        renderDraftActions() {
            if (!this.draft) {
                return;
            }
            // Filtros temporales del aside
            const draftActiveCount = this.getActiveFilters(
                this.draft
            ).length;
            // Filtros aplicados del parent
            const stateActiveCount = this.getActiveFilters(
                this.state
            ).length;
            // Búsqueda del parent
            const hasSearch = this.state.searchQuery.length > 0;
            // Determinar si existe algo que limpiar
            const hasChanges = (
                draftActiveCount > 0 ||
                stateActiveCount > 0 ||
                hasSearch
            );
            // Estado del botón limpiar
            this.child.clear.prop(
                'disabled',
                !hasChanges
            );
            // Texto del botón aplicar
            this.child.applyLabel.text(
                this.config.texts.apply
            );
        }

        // =====================================================
        // RENDER BUSINESS TYPES
        // =====================================================
        renderBusinessTypes() {
            const $container = this.child.types;
            $container.empty();
            if (!this.config.features.businessTypes) {
                return;
            }
            this.config.businessTypes.forEach(type => {
                const active =
                    this.draft.businessType === type.value;
                const $button = $('<button>', {
                    type: 'button',
                    class: 'yapita-business-filter-aside__type',
                    'data-role': 'business-type',
                    'data-value': type.value,
                    'aria-pressed': active ? 'true' : 'false'
                });
                $button.toggleClass(
                    'yapita-business-filter-aside__type--active',
                    active
                );
                const $icon = $('<i>', {
                    class: [
                        'bi',
                        type.icon,
                        'yapita-business-filter-aside__type-icon'
                    ].join(' '),
                    'aria-hidden': 'true'
                });
                const $label = $('<span>', {
                    class: 'yapita-business-filter-aside__type-label',
                    text: type.label
                });
                const $check = $('<i>', {
                    class: [
                        'bi',
                        'bi-check-circle-fill',
                        'yapita-business-filter-aside__type-check'
                    ].join(' '),
                    'aria-hidden': 'true'
                });
                $button.append(
                    $icon,
                    $label,
                    $check
                );
                $container.append($button);
            });
        }

        // =====================================================
        // RENDER CATEGORIES
        // =====================================================
        renderCategories() {
            const $select = this.child.category.empty();
            $select.append($('<option>', {value: '', text: this.config.texts.categoryPlaceholder}));
            (this.config.categories || []).forEach(c => $select.append($('<option>', {value: c.id, text: c.name})));
            $select.val(this.draft.categoryId ?? '').trigger('change.select2');
        }

        initSelect2() {
            this.child.subcategory.prop('multiple', true);
            if (!this.config.select2?.enabled || typeof $.fn.select2 !== 'function') return;
            const common = {
                width: '100%', dropdownParent: this.$aside,
                language: {
                    noResults: () => this.config.texts.selectNoResults,
                    searching: () => this.config.texts.selectSearching
                }
            };
            for (const key of ['category', 'subcategory']) {
                const $el = this.child[key];
                const options = this.config.select2[key];
                if (options?.enabled && !$el.hasClass('select2-hidden-accessible')) {
                    $el.select2({...common, ...options, placeholder: this.config.texts[key + 'Placeholder']});
                }
            }
        }

        renderSubcategoryInfo() {
            const category = this.getCategory(this.draft.categoryId);
            const count = this.draft.subcategoryIds.length;
            const t = this.config.texts;
            this.child.subcategoryCount.text(`${count} ${t.subcategorySelected}`).prop('hidden', !count);
            this.child.subcategoryHelp.text(!category ? t.subcategoryEmptyHelp : !category.subcategories?.length ? t.subcategoryNoResults : t.subcategoryHelp);
        }

        // =====================================================
        // RENDER SUBCATEGORIES
        // =====================================================
        renderSubcategories() {
            const $select = this.child.subcategory;
            if ($select.hasClass('select2-hidden-accessible')) $select.select2('close');
            const category = this.getCategory(this.draft.categoryId);
            const items = category?.subcategories || [];
            this.child.subcategorySection.prop('hidden', !this.config.features.categories);
            $select.empty().prop('disabled', !items.length || !this.config.features.categories);
            items.forEach(item => $select.append($('<option>', {value: item.id, text: item.name})));
            this.draft.subcategoryIds = items.filter(item => (this.draft.subcategoryIds || []).some(id => String(id) === String(item.id))).map(item => item.id);
            $select.val(this.draft.subcategoryIds.map(String)).trigger('change.select2');
            this.renderSubcategoryInfo();
        }

        // =====================================================
        // RENDER EXTRA FILTERS
        // =====================================================
        renderExtraFilters() {
            const $container = this.child.extraFilters;
            const filters = this.getExtraFilters();
            $container.empty();
            $container.prop(
                'hidden',
                filters.length === 0
            );
            filters.forEach(filter => {
                let $element = null;
                switch (filter.type) {
                    case 'switch':
                        $element = this.buildSwitch(filter);
                        break;
                    case 'range':
                        $element = this.buildRange(filter);
                        break;
                }
                if ($element) {
                    $container.append($element);
                }
            });
        }

        // =====================================================
        // BUILD SWITCH
        // =====================================================
        buildSwitch(filter) {
            const active = Boolean(
                this.draft.extra[filter.key]
            );
            const $section = $('<section>', {
                class: 'yapita-business-filter-aside__section'
            });
            const $label = $('<label>', {
                class: 'yapita-business-filter-aside__switch'
            });
            $label.toggleClass(
                'yapita-business-filter-aside__switch--active',
                active
            );
            const $icon = $('<i>', {
                class: [
                    'bi',
                    filter.icon || 'bi-toggle-on',
                    'yapita-business-filter-aside__switch-icon'
                ].join(' '),
                'aria-hidden': 'true'
            });
            const $content = $('<span>', {
                class: 'yapita-business-filter-aside__switch-content'
            });
            $content.append(
                $('<span>', {
                    class: 'yapita-business-filter-aside__switch-label',
                    text: filter.label
                })
            );
            if (filter.description) {
                $content.append(
                    $('<span>', {
                        class: 'yapita-business-filter-aside__switch-description',
                        text: filter.description
                    })
                );
            }
            const $switch = $('<span>', {
                class: 'form-check form-switch p-0 m-0'
            });
            const $input = $('<input>', {
                type: 'checkbox',
                class: 'form-check-input',
                role: 'switch',
                'data-role': 'extra-switch',
                'data-key': filter.key,
                'aria-label': filter.label
            });
            $input.prop(
                'checked',
                active
            );
            $switch.append($input);
            $label.append(
                $icon,
                $content,
                $switch
            );
            $section.append($label);
            return $section;
        }

        // =====================================================
        // BUILD RANGE
        // =====================================================
        buildRange(filter) {
            const value = this.draft.extra[filter.key];
            const $section = $('<section>', {
                class: 'yapita-business-filter-aside__section',
                'data-range-key': filter.key
            });
            const $header = $('<div>', {
                class: 'yapita-business-filter-aside__range-header'
            });
            const $title = $('<label>', {
                class: 'yapita-business-filter-aside__section-title',
                for: `ybf-extra-${filter.key}`
            });
            $title.append(
                $('<i>', {
                    class: `bi ${filter.icon || 'bi-sliders'}`,
                    'aria-hidden': 'true'
                }),
                $('<span>', {
                    text: filter.label
                })
            );
            const $value = $('<span>', {
                class: 'yapita-business-filter-aside__range-value',
                'data-role': 'range-value',
                text: this.formatRangeValue(filter, value)
            });
            $header.append(
                $title,
                $value
            );
            const $range = $('<input>', {
                id: `ybf-extra-${filter.key}`,
                type: 'range',
                class: [
                    'form-range',
                    'yapita-business-filter-aside__range'
                ].join(' '),
                min: filter.min,
                max: filter.max,
                step: filter.step || 1,
                value: value,
                'data-role': 'extra-range',
                'data-key': filter.key,
                'aria-valuetext': this.formatRangeValue(
                    filter,
                    value
                )
            });
            const $marks = $('<div>', {
                class: 'yapita-business-filter-aside__range-marks'
            });
            (filter.marks || []).forEach(mark => {
                const percentage = filter.max > filter.min
                    ? (
                    (mark - filter.min) /
                    (filter.max - filter.min)
                ) * 100
                    : 0;
                const $mark = $('<span>', {
                    class: 'yapita-business-filter-aside__range-mark',
                    text: `${mark} ${filter.unit || ''}`.trim()
                });
                $mark.css(
                    'left',
                    `${percentage}%`
                );
                $marks.append($mark);
            });
            $section.append(
                $header,
                $('<p>', {class: 'yapita-business-filter-aside__range-description', text: filter.description || ''}),
                $range,
                $marks
            );
            if (filter.key === 'radius') $section.append($('<p>', {
                class: 'yapita-business-filter-aside__diameter',
                'data-role': 'diameter-value',
                text: `${this.config.texts.diameterLabel}: ${value * 2} km`
            }));
            this.updateRangeProgress($range, filter, value);
            return $section;
        }

        updateRangeProgress($input, filter, value) {
            const percent = filter.max > filter.min ? 100 * (value - filter.min) / (filter.max - filter.min) : 0;
            $input[0].style.setProperty('--ybfa-range-progress', `${Math.max(0, Math.min(100, percent))}%`);
            if (filter.key === 'radius') $input.closest('[data-range-key]').find('[data-role="diameter-value"]').text(`${this.config.texts.diameterLabel}: ${value * 2} km`);
        }

        formatRangeValue(filter, value) {
            const prefix = filter.key === 'radius'
                ? this.config.texts.distancePrefix
                : '';
            return [
                prefix,
                value,
                filter.unit || ''
            ].filter(item => item !== '').join(' ');
        }
// =====================================================
// CHILD EVENTS - LIVE FILTERS
// =====================================================

        bindChildEvents() {

            const self = this;
            const ns = this.namespace;

            this.$aside.off(ns);

            // =================================================
            // ASIDE SHOW
            // =================================================

            this.$aside.on(
                `show.bs.offcanvas${ns}`,
                function () {

                    self.isAsideOpen = true;

                    if (!self.draft) {

                        self.draft = self.clone(self.state);

                        self.renderAside();
                    }

                    self.parent.openMore.attr(
                        'aria-expanded',
                        'true'
                    );
                }
            );

            // =================================================
            // ASIDE HIDDEN
            // =================================================

            this.$aside.on(
                `hidden.bs.offcanvas${ns}`,
                function () {

                    self.isAsideOpen = false;

                    self.draft = null;

                    self.parent.openMore.attr(
                        'aria-expanded',
                        'false'
                    );

                    if (!self.isDestroyed) {
                        self.parent.openMore.trigger('focus');
                    }
                }
            );

            // =================================================
            // CLOSE ASIDE
            // =================================================

            this.$aside.on(
                `click${ns}`,
                '[data-role="close-more"]',
                function () {

                    self.closeAside();
                }
            );

            // =================================================
            // BUSINESS TYPE
            // =================================================

            this.$aside.on(
                `click${ns}`,
                '[data-role="business-type"]',
                function () {

                    if (!self.draft) {
                        return;
                    }

                    const value = $(this).attr('data-value');

                    self.draft.businessType =
                        self.draft.businessType === value
                            ? null
                            : value;

                    // Update selected buttons
                    self.child.types
                        .find('[data-role="business-type"]')
                        .each(function () {

                            const $button = $(this);

                            const active =
                                $button.attr('data-value') ===
                                self.draft.businessType;

                            $button.toggleClass(
                                'yapita-business-filter-aside__type--active',
                                active
                            );

                            $button.attr(
                                'aria-pressed',
                                active ? 'true' : 'false'
                            );
                        });

                    // LIVE APPLY
                    self.applyLiveFilters('business-type');
                }
            );

            // =================================================
            // CATEGORY
            // =================================================

            this.$aside.on(
                `change${ns}`,
                '[data-role="category"]',
                function () {

                    if (!self.draft) {
                        return;
                    }

                    const category = self.getCategory(
                        $(this).val()
                    );

                    const categoryId = category?.id ?? null;

                    const changed =
                        String(self.draft.categoryId) !==
                        String(categoryId);

                    self.draft.categoryId = categoryId;

                    // Reset dependent subcategories
                    if (changed) {
                        self.draft.subcategoryIds = [];
                    }

                    // Load second level
                    self.renderSubcategories();

                    // LIVE APPLY
                    self.applyLiveFilters('category');
                }
            );

            // =================================================
            // MULTIPLE SUBCATEGORIES
            // =================================================

            this.$aside.on(
                `change${ns}`,
                '[data-role="subcategory"]',
                function () {

                    if (!self.draft) {
                        return;
                    }

                    const values = $(this).val() || [];

                    const category = self.getCategory(
                        self.draft.categoryId
                    );

                    const subcategories =
                        category?.subcategories || [];

                    self.draft.subcategoryIds = subcategories

                        .filter(subcategory =>
                            values.some(value =>
                                String(value) ===
                                String(subcategory.id)
                            )
                        )

                        .map(subcategory => subcategory.id);

                    // Update selection counter
                    self.renderSubcategoryInfo();

                    // LIVE APPLY
                    self.applyLiveFilters('subcategories');
                }
            );

            // =================================================
            // EXTRA FILTERS - SWITCH
            // =================================================

            this.$aside.on(
                `change${ns}`,
                '[data-role="extra-switch"]',
                function () {

                    if (!self.draft) {
                        return;
                    }

                    const $input = $(this);

                    const key = $input.attr('data-key');

                    const filter = self.getExtraFilter(key);

                    if (!filter || filter.type !== 'switch') {
                        return;
                    }

                    const value = $input.is(':checked');

                    self.draft.extra[key] = value;

                    // Update visual state
                    $input.closest(
                        '.yapita-business-filter-aside__switch'
                    ).toggleClass(
                        'yapita-business-filter-aside__switch--active',
                        value
                    );

                    // LIVE APPLY
                    self.applyLiveFilters(`extra.${key}`);
                }
            );

            // =================================================
            // EXTRA FILTERS - RANGE
            // =================================================

            this.$aside.on(
                `input${ns} change${ns}`,
                '[data-role="extra-range"]',
                function () {

                    if (!self.draft) {
                        return;
                    }

                    const $input = $(this);

                    const key = $input.attr('data-key');

                    const filter = self.getExtraFilter(key);

                    if (!filter || filter.type !== 'range') {
                        return;
                    }

                    const value = Number($input.val());

                    self.draft.extra[key] = value;

                    // Format current value
                    const formattedValue =
                        self.formatRangeValue(filter, value);

                    const $section = $input.closest(
                        '[data-range-key]'
                    );

                    // Update current radius label
                    $section.find(
                        '[data-role="range-value"]'
                    ).text(formattedValue);

                    // Update accessibility
                    $input.attr(
                        'aria-valuetext',
                        formattedValue
                    );

                    // Update range progress
                    self.updateRangeProgress(
                        $input,
                        filter,
                        value
                    );

                    // Update diameter if radius changes
                    if (key === 'radius') {

                        const diameter = value * 2;

                        $section.find(
                            '[data-role="diameter-value"]'
                        ).text(`${diameter} km`);
                    }

                    // LIVE APPLY
                    self.applyLiveFilters(`extra.${key}`);
                }
            );

            // =================================================
            // CLEAR FILTERS
            // Reserved for future footer activation
            // =================================================

            this.$aside.on(
                `click${ns}`,
                '[data-role="clear-draft"]',
                function () {

                    self.clearFilters('clear-draft');
                }
            );

            // =================================================
            // MANUAL APPLY
            // Reserved for future footer activation
            // =================================================

            this.$aside.on(
                `click${ns}`,
                '[data-role="apply"]',
                function () {

                    self.applyDraft();
                }
            );
        }
        // =====================================================
        // CHILD EVENTS
        // =====================================================
        bindChildEvents2() {
            const self = this;
            const ns = this.namespace;
            this.$aside.off(ns);
            // ASIDE SHOW
            this.$aside.on(
                `show.bs.offcanvas${ns}`,
                function () {
                    self.isAsideOpen = true;
                    if (!self.draft) {
                        self.draft = self.clone(self.state);
                        self.renderAside();
                    }
                    self.parent.openMore.attr(
                        'aria-expanded',
                        'true'
                    );
                }
            );
            // ASIDE HIDDEN
            this.$aside.on(
                `hidden.bs.offcanvas${ns}`,
                function () {
                    self.isAsideOpen = false;
                    self.draft = null;
                    self.parent.openMore.attr(
                        'aria-expanded',
                        'false'
                    );
                    if (!self.isDestroyed) {
                        self.parent.openMore.trigger('focus');
                    }
                }
            );
            // CLOSE
            this.$aside.on(
                `click${ns}`,
                '[data-role="close-more"]',
                function () {
                    self.closeAside();
                }
            );
            // BUSINESS TYPE
            this.$aside.on(
                `click${ns}`,
                '[data-role="business-type"]',
                function () {
                    if (!self.draft) {
                        return;
                    }
                    const value = $(this).attr('data-value');
                    self.draft.businessType =
                        self.draft.businessType === value
                            ? null
                            : value;
                    // UPDATE BUTTONS WITHOUT REBUILDING DOM
                    self.child.types
                        .find('[data-role="business-type"]')
                        .each(function () {
                            const $button = $(this);
                            const active =
                                $button.attr('data-value') ===
                                self.draft.businessType;
                            $button.toggleClass(
                                'yapita-business-filter-aside__type--active',
                                active
                            );
                            $button.attr(
                                'aria-pressed',
                                active ? 'true' : 'false'
                            );
                        });
                    self.renderDraftActions();
                }
            );
            // CATEGORY
            this.$aside.on(
                `change${ns}`,
                '[data-role="category"]',
                function () {
                    if (!self.draft) {
                        return;
                    }
                    const category = self.getCategory(
                        $(this).val()
                    );
                    self.draft.categoryId =
                        category?.id ?? null;
                    self.draft.subcategoryIds = [];
                    self.renderSubcategories();
                    self.renderDraftActions();
                }
            );
            // SUBCATEGORY
            this.$aside.on(
                `change${ns}`,
                '[data-role="subcategory"]',
                function () {
                    if (!self.draft) {
                        return;
                    }
                    const ids = $(this).val() || [];
                    const items = self.getCategory(self.draft.categoryId)?.subcategories || [];
                    self.draft.subcategoryIds = items.filter(item => ids.includes(String(item.id))).map(item => item.id);
                    self.renderSubcategoryInfo();
                    self.renderDraftActions();
                }
            );
            // SWITCH
            this.$aside.on(
                `change${ns}`,
                '[data-role="extra-switch"]',
                function () {
                    if (!self.draft) {
                        return;
                    }
                    const $input = $(this);
                    const key = $input.attr('data-key');
                    const filter = self.getExtraFilter(key);
                    if (!filter || filter.type !== 'switch') {
                        return;
                    }
                    const value = $input.is(':checked');
                    self.draft.extra[key] = value;
                    $input.closest(
                        '.yapita-business-filter-aside__switch'
                    ).toggleClass(
                        'yapita-business-filter-aside__switch--active',
                        value
                    );
                    self.renderDraftActions();
                }
            );
            // RANGE
            this.$aside.on(
                `input${ns} change${ns}`,
                '[data-role="extra-range"]',
                function () {
                    if (!self.draft) {
                        return;
                    }
                    const $input = $(this);
                    const key = $input.attr('data-key');
                    const filter = self.getExtraFilter(key);
                    if (!filter || filter.type !== 'range') {
                        return;
                    }
                    const value = Number($input.val());
                    self.draft.extra[key] = value;
                    const formattedValue =
                        self.formatRangeValue(filter, value);
                    $input.closest(
                        '[data-range-key]'
                    ).find(
                        '[data-role="range-value"]'
                    ).text(formattedValue);
                    $input.attr(
                        'aria-valuetext',
                        formattedValue
                    );
                    self.updateRangeProgress($input, filter, value);
                    self.renderDraftActions();
                }
            );
            // CLEAR DRAFT
            this.$aside.on(
                `click${ns}`,
                '[data-role="clear-draft"]',
                function () {
                    self.clearDraft();
                }
            );
            // APPLY
            this.$aside.on(
                `click${ns}`,
                '[data-role="apply"]',
                function () {
                    self.applyDraft();
                }
            );
        }

        // =====================================================
        // STICKY / FIXED INITIALIZATION
        // =====================================================
        initSticky() {
            const sticky = this.config.sticky;
            if (!sticky.enabled) {
                return;
            }
            if (!this.$anchor.length) {
                console.warn(
                    'YapitaBusinessFilter: sticky anchor not found.'
                );
                return;
            }
            this.$root.addClass(
                'yapita-business-filter--sticky'
            );
            this.$root[0].style.setProperty(
                '--ybf-z-index',
                sticky.zIndex ?? 1020
            );
            const self = this;
            const ns = this.namespace;
            // WINDOW EVENTS
            $(window).on(
                `scroll${ns} resize${ns} orientationchange${ns}`,
                function () {
                    self.scheduleSticky();
                }
            );
            // INTERNAL SCROLL CONTAINERS
            this.handleDocumentScroll = function () {
                self.scheduleSticky();
            };
            document.addEventListener(
                'scroll',
                this.handleDocumentScroll,
                {
                    capture: true,
                    passive: true
                }
            );
            // OBSERVE ELEMENT DIMENSIONS
            if (typeof ResizeObserver !== 'undefined') {
                this.resizeObserver = new ResizeObserver(
                    function () {
                        self.scheduleSticky();
                    }
                );
                this.resizeObserver.observe(
                    this.$root[0]
                );
                this.resizeObserver.observe(
                    this.$anchor[0]
                );
                if (this.$header.length) {
                    this.resizeObserver.observe(
                        this.$header[0]
                    );
                }
            }
            this.scheduleSticky();
        }

        // =====================================================
        // SCHEDULE STICKY
        // =====================================================
        scheduleSticky() {
            if (
                !this.config.sticky.enabled ||
                this.isDestroyed
            ) {
                return;
            }
            if (this.stickyFrame !== null) {
                return;
            }
            this.stickyFrame = requestAnimationFrame(() => {
                this.stickyFrame = null;
                this.updateSticky();
            });
        }

        // =====================================================
        // GET HEADER POSITION
        // =====================================================
        getStickyTop() {
            const sticky = this.config.sticky;
            const offset = Number(sticky.offset || 0);
            const configuredTop = Number(sticky.top || 0);
            if (
                !sticky.autoTop ||
                !this.$header.length
            ) {
                return configuredTop + offset;
            }
            const header = this.$header[0];
            const rect = header.getBoundingClientRect();
            if (sticky.forceHeaderHeight) {
                return Math.max(
                    configuredTop,
                    rect.height,
                    rect.bottom
                ) + offset;
            }
            return Math.max(
                configuredTop,
                rect.bottom,
                0
            ) + offset;
        }

        // =====================================================
        // UPDATE FIXED POSITION
        // =====================================================
        updateSticky() {
            if (
                !this.config.sticky.enabled ||
                !this.$anchor.length ||
                this.isDestroyed
            ) {
                return;
            }
            const anchor = this.$anchor[0];
            const element = this.$root[0];
            const anchorRect =
                anchor.getBoundingClientRect();
            const top = this.getStickyTop();
            if (anchorRect.width <= 0) {
                this.releaseSticky();
                return;
            }
            const shouldStick = anchorRect.top <= top;
            if (!shouldStick) {
                this.releaseSticky();
                return;
            }
            // PRESERVE ORIGINAL HEIGHT
            const height =
                element.getBoundingClientRect().height;
            this.$anchor.css(
                'height',
                `${height}px`
            );
            // CSS VARIABLES
            element.style.setProperty(
                '--ybf-top',
                `${top}px`
            );
            element.style.setProperty(
                '--ybf-left',
                `${anchorRect.left}px`
            );
            element.style.setProperty(
                '--ybf-width',
                `${anchorRect.width}px`
            );
            // FIXED MODIFIER
            this.$root.addClass(
                'yapita-business-filter--stuck'
            );
            this.isStuck = true;
            // ADJUST RESERVED HEIGHT AFTER WIDTH CHANGE
            const fixedHeight =
                element.getBoundingClientRect().height;
            if (Math.abs(fixedHeight - height) > 0.5) {
                this.$anchor.css(
                    'height',
                    `${fixedHeight}px`
                );
            }
        }

        // =====================================================
        // RELEASE FIXED POSITION
        // =====================================================
        releaseSticky() {
            if (!this.isStuck) {
                return;
            }
            this.$root.removeClass(
                'yapita-business-filter--stuck'
            );
            this.$anchor.css(
                'height',
                ''
            );
            this.isStuck = false;
        }

        // =====================================================
        // EMIT CHANGE
        // =====================================================
        emitChange(action = 'change') {
            if (this.isDestroyed) {
                return this;
            }
            this.revision++;
            const filters = this.getFilters();
            const metadata = this.getMetadata(action);
            // CONFIG CALLBACK
            if (typeof this.config.onChange === 'function') {
                this.config.onChange.call(
                    this,
                    filters,
                    metadata
                );
            }
            // CUSTOM EVENT
            this.$root.trigger(
                'yapita:filters:change',
                [
                    filters,
                    metadata
                ]
            );
            return this;
        }

        // =====================================================
        // REFRESH
        // =====================================================
        refresh() {
            this.state = this.normalizeState(
                this.state
            );
            this.initTexts();
            this.initFeatures();
            this.render();
            if (this.isAsideOpen) {
                this.draft = this.normalizeState(
                    this.draft || this.state
                );
                this.renderAside();
            }
            return this;
        }

        // =====================================================
        // DESTROY
        // =====================================================
        destroy() {
            if (this.isDestroyed) {
                return;
            }
            this.isDestroyed = true;
            if (typeof $.fn.select2 === 'function') {
                [this.child.category, this.child.subcategory].forEach($el => {
                    if ($el.hasClass('select2-hidden-accessible')) $el.select2('destroy');
                });
            }
            this.cancelSearchTimer();
            if (this.stickyFrame !== null) {
                cancelAnimationFrame(
                    this.stickyFrame
                );
                this.stickyFrame = null;
            }
            if (this.resizeObserver) {
                this.resizeObserver.disconnect();
                this.resizeObserver = null;
            }
            if (this.handleDocumentScroll) {
                document.removeEventListener(
                    'scroll',
                    this.handleDocumentScroll,
                    true
                );
            }
            this.$root.off(this.namespace);
            $(window).off(this.namespace);
            this.releaseSticky();
            this.$root.removeClass(
                'yapita-business-filter--sticky'
            );
            const disposeAside = () => {
                this.$aside.off(this.namespace);
                this.offcanvas?.dispose();
                this.offcanvas = null;
                this.isAsideOpen = false;
                this.draft = null;
                this.parent.openMore.attr(
                    'aria-expanded',
                    'false'
                );
            };
            if (!this.offcanvas) {
                disposeAside();
                return;
            }
            if (this.$aside.hasClass('showing')) {
                this.$aside.one(
                    'shown.bs.offcanvas',
                    () => {
                        this.$aside.one(
                            'hidden.bs.offcanvas',
                            disposeAside
                        );
                        this.offcanvas?.hide();
                    }
                );
            } else if (this.$aside.hasClass('hiding')) {
                this.$aside.one(
                    'hidden.bs.offcanvas',
                    disposeAside
                );
            } else if (this.$aside.hasClass('show')) {
                this.$aside.one(
                    'hidden.bs.offcanvas',
                    disposeAside
                );
                this.offcanvas.hide();
            } else {
                disposeAside();
            }
        }
    }

    // =========================================================
    // GLOBAL INSTANCE
    // =========================================================
    let yapitaBusinessFilter = null;
    // =========================================================
    // DOCUMENT READY
    // =========================================================
    $(document).ready(function () {
        yapitaBusinessFilter = new YapitaBusinessFilter(
            YapitaBusinessFilterConfigVersion
        );


        YapitaMapEvents.on(
            YapitaMapEventTypes.BUSINESSES_RENDERED,
            ({ detail }) => {

                const {
                    total,
                    locations,
                    totalData
                } = detail;

                console.log('Total empresas:', total);
                console.log('Total ubicaciones:', locations);
                console.log('Texto traducido:', totalData);

                yapitaBusinessFilter.setResults(total);

            }
        );
    });

</script>
