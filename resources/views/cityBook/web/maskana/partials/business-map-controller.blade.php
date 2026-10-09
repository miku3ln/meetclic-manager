<script>

    /**
     * MASKANA BUSINESS MAP MANAGER
     *
     * Laravel API + jQuery AJAX + Leaflet + Bootstrap 5
     *
     * Backend:
     * POST /business/searchNearbyBusinesses
     *
     * BusinessMapController:
     * init(data)
     * setBusinesses(data)
     * selectBusiness(id)
     * flyTo(id)
     * destroy()
     */

    let mapController = null;
    let businessRequest = null;
    let businessMapInitialized = false;
    let businessRequestSequence = 0;

    const businessFilters = {
        latitude: 0.2343,
        longitude: -78.2625,
        radiusKm: 10,

        // null = todas las subcategorías
        subcategoryIds: null,

        onlyWithRedeemableRewards: null,
        onlyWithGamesActive: null,
        onlyAlliedCompanies: null,

        searchQuery: ''
    };

    /**
     * Inicializar administrador.
     */

    function initManager() {

        if (mapController) {
            console.warn('El mapa ya está inicializado.');
            return;
        }

        if (typeof BusinessMapController === 'undefined') {
            console.error(
                'BusinessMapController no está cargado.'
            );
            return;
        }

        if (typeof BusinessMapHtmlUtil === 'undefined') {
            console.error(
                'BusinessMapHtmlUtil no está cargado.'
            );
            return;
        }

        mapController = new BusinessMapController({
            containerId: 'business-map',

            detailAsideId: 'businessDetailAside',
            groupAsideId: 'businessGroupAside',

            position: [
                businessFilters.latitude,
                businessFilters.longitude
            ],

            zoom: 13,
            focusZoom: 17,
            maxZoom: 19,

            fitOnRender: true,
            openDetailsOnClick: true,
            fallbackImage: ''
        });

        registerBusinessMapEvents();
        registerBusinessFilterEvents();

        loadBusinesses();
    }


    /**
     * Registrar eventos del mapa.
     */
    function registerBusinessMapEvents() {

        mapController.on('map:init', ({map, count}) => {
            console.log('Mapa inicializado:', count);
        });

        mapController.on('marker:click', ({
                                              marker,
                                              businesses,
                                              business
                                          }) => {
            console.log('Marcador seleccionado:', {
                marker,
                businesses,
                business
            });
        });

        mapController.on('marker:group', ({businesses}) => {
            console.log('Empresas agrupadas:', businesses);
        });

        mapController.on('business:selected', ({business}) => {
            console.log('Empresa seleccionada:', business);
        });

        mapController.on('business:details:open', ({business}) => {
            console.log('Detalle abierto:', business);
        });

        mapController.on('business:details:close', ({business}) => {
            console.log('Detalle cerrado:', business);
        });

        mapController.on('businesses:rendered', ({
                                                     total,
                                                     locations
                                                 }) => {
            console.log('Empresas:', total);
            console.log('Ubicaciones:', locations);

            $('#business-total').text(total);
        });

        mapController.on('map:moveend', ({
                                             center,
                                             zoom
                                         }) => {
            console.log('Mapa movido:', center, zoom);
        });
    }

    /**
     * Construir parámetros exactos del backend.
     */
    function buildBusinessRequestParams() {

        return {
            latitude: businessFilters.latitude,
            longitude: businessFilters.longitude,
            radiusKm: businessFilters.radiusKm,

            subcategoryIds: businessFilters.subcategoryIds,

            onlyWithRedeemableRewards:
            businessFilters.onlyWithRedeemableRewards,

            onlyWithGamesActive:
            businessFilters.onlyWithGamesActive,

            onlyAlliedCompanies:
            businessFilters.onlyAlliedCompanies,

            searchQuery: businessFilters.searchQuery
        };
    }

    /**
     * Consultar empresas por AJAX POST.
     */
    function loadBusinesses() {

        const url = $('#route-business-action').val();

        if (!url) {
            console.error(
                'No existe #route-business-action'
            );
            return null;
        }

        const params = buildBusinessRequestParams();

        const requestId = ++businessRequestSequence;

        if (
            businessRequest &&
            businessRequest.readyState !== 4
        ) {
            businessRequest.abort();
        }

        businessRequest = $.ajax({

            url: url,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',

            data: JSON.stringify(params),

            timeout: 30000,

            headers: {
                Accept: 'application/json'
            },

            beforeSend: function () {

                setBusinessLoading(true);

                console.log(
                    'Consultando empresas:',
                    params
                );
            },

            success: function (response) {

                if (requestId !== businessRequestSequence) {
                    return;
                }

                if (!response || response.success !== true) {

                    showBusinessMessage(
                        response?.message ||
                        'No fue posible obtener empresas.',
                        'warning'
                    );

                    return;
                }

                const businesses =
                    Array.isArray(response.data)
                        ? response.data
                        : [];

                console.log(
                    'Empresas obtenidas:',
                    businesses
                );

                if (!businessMapInitialized) {

                    mapController.init(businesses);

                    businessMapInitialized = true;

                } else {

                    mapController.setBusinesses(businesses);

                }

                if (businesses.length === 0) {

                    showBusinessMessage(
                        'No se encontraron empresas.',
                        'info'
                    );

                } else {

                    clearBusinessMessage();

                }

                document.dispatchEvent(
                    new CustomEvent(
                        'business-manager:loaded',
                        {
                            detail: {
                                businesses,
                                total: businesses.length,
                                filters: {...businessFilters}
                            }
                        }
                    )
                );
            },

            error: function (xhr, status, error) {

                if (
                    status === 'abort' ||
                    requestId !== businessRequestSequence
                ) {
                    return;
                }

                console.error('Error API:', {
                    status: xhr.status,
                    error,
                    response: xhr.responseJSON
                });

                showBusinessMessage(
                    xhr.responseJSON?.message ||
                    'Error al consultar empresas.',
                    'danger'
                );
            },

            complete: function () {

                if (requestId !== businessRequestSequence) {
                    return;
                }

                businessRequest = null;

                setBusinessLoading(false);
            }
        });

        return businessRequest;
    }

    /**
     * Actualizar filtros y consultar.
     */
    function updateBusinessFilters(filters = {}) {

        Object.assign(
            businessFilters,
            filters
        );

        return loadBusinesses();
    }

    /**
     * Filtrar por una o varias subcategorías.
     *
     * Ejemplos:
     * setBusinessSubcategories([76]);
     * setBusinessSubcategories([76, 80, 95]);
     * setBusinessSubcategories(null);
     */
    function setBusinessSubcategories(ids = null) {

        let subcategoryIds = null;

        if (Array.isArray(ids) && ids.length > 0) {
            subcategoryIds = ids
                .map(Number)
                .filter(Number.isInteger);
        }

        if (subcategoryIds?.length === 0) {
            subcategoryIds = null;
        }

        return updateBusinessFilters({
            subcategoryIds
        });
    }

    /**
     * Filtrar empresas por texto.
     */
    function searchBusinesses(searchQuery = '') {

        return updateBusinessFilters({
            searchQuery: String(searchQuery).trim()
        });
    }

    /**
     * Filtrar por recompensas canjeables.
     */
    function filterRedeemableRewards(enabled = null) {

        return updateBusinessFilters({
            onlyWithRedeemableRewards: enabled
        });
    }

    /**
     * Filtrar empresas con juegos activos.
     */
    function filterGamesActive(enabled = null) {

        return updateBusinessFilters({
            onlyWithGamesActive: enabled
        });
    }

    /**
     * Filtrar empresas aliadas.
     */
    function filterAlliedCompanies(enabled = null) {

        return updateBusinessFilters({
            onlyAlliedCompanies: enabled
        });
    }

    /**
     * Buscar alrededor de una ubicación.
     */
    function searchBusinessesNearby(
        latitude,
        longitude,
        radiusKm = 10
    ) {

        const lat = Number(latitude);
        const lng = Number(longitude);
        const radius = Number(radiusKm);

        if (
            !Number.isFinite(lat) ||
            !Number.isFinite(lng) ||
            Math.abs(lat) > 90 ||
            Math.abs(lng) > 180 ||
            !Number.isFinite(radius) ||
            radius <= 0
        ) {
            console.error('Ubicación o radio inválidos.');
            return null;
        }

        return updateBusinessFilters({
            latitude: lat,
            longitude: lng,
            radiusKm: radius
        });
    }

    /**
     * Registrar eventos de filtros HTML.
     */
    function registerBusinessFilterEvents() {

        $(document)
            .off(
                'change.businessMap',
                '#business-subcategory-filter'
            )
            .on(
                'change.businessMap',
                '#business-subcategory-filter',
                function () {

                    const selected = $(this).val();

                    if (
                        !selected ||
                        selected === 'all'
                    ) {
                        setBusinessSubcategories(null);
                        return;
                    }

                    const ids = Array.isArray(selected)
                        ? selected
                        : [selected];

                    setBusinessSubcategories(ids);
                }
            );

        let searchTimer = null;

        $(document)
            .off(
                'input.businessMap',
                '#business-search'
            )
            .on(
                'input.businessMap',
                '#business-search',
                function () {

                    const value = $(this).val();

                    clearTimeout(searchTimer);

                    searchTimer = setTimeout(() => {
                        searchBusinesses(value);
                    }, 450);
                }
            );

        $(document)
            .off(
                'change.businessMap',
                '#business-rewards-filter'
            )
            .on(
                'change.businessMap',
                '#business-rewards-filter',
                function () {

                    filterRedeemableRewards(
                        this.checked ? true : null
                    );
                }
            );

        $(document)
            .off(
                'change.businessMap',
                '#business-games-filter'
            )
            .on(
                'change.businessMap',
                '#business-games-filter',
                function () {

                    filterGamesActive(
                        this.checked ? true : null
                    );
                }
            );

        $(document)
            .off(
                'change.businessMap',
                '#business-allied-filter'
            )
            .on(
                'change.businessMap',
                '#business-allied-filter',
                function () {

                    filterAlliedCompanies(
                        this.checked ? true : null
                    );
                }
            );

        $(document)
            .off(
                'click.businessMap',
                '#business-reset-filters'
            )
            .on(
                'click.businessMap',
                '#business-reset-filters',
                function (event) {

                    event.preventDefault();

                    resetBusinessFilters();
                }
            );
    }

    /**
     * Restaurar filtros iniciales.
     */
    function resetBusinessFilters() {

        Object.assign(businessFilters, {
            latitude: 0.2343,
            longitude: -78.2625,
            radiusKm: 10,

            subcategoryIds: null,

            onlyWithRedeemableRewards: null,
            onlyWithGamesActive: null,
            onlyAlliedCompanies: null,

            searchQuery: ''
        });

        $('#business-subcategory-filter').val('all');
        $('#business-search').val('');

        $('#business-rewards-filter').prop('checked', false);
        $('#business-games-filter').prop('checked', false);
        $('#business-allied-filter').prop('checked', false);

        return loadBusinesses();
    }

    /**
     * Seleccionar una empresa.
     */
    function selectBusinessOnMap(id) {

        if (!businessMapInitialized) {
            return false;
        }

        return mapController.selectBusiness(id, {
            openDetails: true,
            fly: true,
            zoom: 17
        });
    }

    /**
     * Centrar una empresa.
     */
    function centerBusinessOnMap(id) {

        if (!businessMapInitialized) {
            return false;
        }

        return mapController.flyTo(id, 17);
    }

    /**
     * Mostrar indicador de carga.
     */
    function setBusinessLoading(isLoading) {

        $('#business-map-loading')
            .toggleClass('d-none', !isLoading);
    }

    /**
     * Mostrar mensajes.
     */
    function showBusinessMessage(message, type = 'info') {

        const allowedTypes = [
            'success',
            'info',
            'warning',
            'danger'
        ];

        const safeType = allowedTypes.includes(type)
            ? type
            : 'info';

        $('#business-map-message')
            .removeClass(
                'alert-success alert-info alert-warning alert-danger'
            )
            .addClass(`alert alert-${safeType}`)
            .text(message)
            .removeClass('d-none');
    }

    /**
     * Ocultar mensajes.
     */
    function clearBusinessMessage() {

        $('#business-map-message')
            .text('')
            .addClass('d-none');
    }

    /**
     * Recargar empresas.
     */
    function reloadBusinesses() {

        return loadBusinesses();
    }

    /**
     * Destruir administrador.
     */
    function destroyBusinessManager() {

        businessRequestSequence++;

        if (
            businessRequest &&
            businessRequest.readyState !== 4
        ) {
            businessRequest.abort();
        }

        businessRequest = null;

        $(document).off('.businessMap');

        mapController?.destroy();

        mapController = null;
        businessMapInitialized = false;

        setBusinessLoading(false);
    }

    /**
     * Inicialización automática.
     */
    $(document).ready(function () {

        initManager();
        initBusinessCategoriesSelect2();
    });




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
                // ==================================
                // RECARGAR NEGOCIOS DEL MAPA
                // ==================================

                // Aquí debes invocar la función existente
                // que realiza la consulta de negocios.
                //
                // Ejemplo, si tu función se llama
                // loadBusinesses():
                //
                // loadBusinesses();
                //
                // No creamos otro AJAX porque ya tienes
                // la consulta implementada en map-manager.

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



</script>
