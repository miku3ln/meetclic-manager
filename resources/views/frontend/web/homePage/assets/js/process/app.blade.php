<script id="app-script">


    var defaultLatLng = [0.229376, -78.2569127];

    var appInitCurrent = new Vue(
            {
                directives: {
                    'init-select': {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },
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
                },
                mounted: async function () {

                    const once = await GeoManager.getBrowserCoordinatesAsync({
                        enableHighAccuracy: true,
                        timeout: 15000,
                        fallbackLat: defaultLatLng[0],
                        fallbackLng: defaultLatLng[1]
                    });
                    this.configDataMapManager.data.latLng = [once.lat, once.lng];
                    console.log("once",once)
                    this.configDataFiltersCategories.data.latLng = [once.lat, once.lng];
                    this.configDataFiltersCategories.allow = true;
                    this.initCurrentComponent();
                    appThis = this;
                    this.initInfiniteScroll(); // ✅
                    window.addEventListener('keydown', this.onEscClose);

                },
                el: '#app-management',
                created: async function () {

                    $thisV = this;
                    $(window).on('resize orientationchange', function () {
                        $thisV.initViewProcess();
                    });
                    $(function () {
                        $thisV.initViewProcess();
                    });
                },
                beforeDestroy() {
                    window.removeEventListener('keydown', this.onEscClose);
                },
                data: {
                    //MENU
                    menuCurrent: [],
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
                    configGridAdmin: {
                        html: '',
                        data: [],
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
                    },
                    configDataMapManager: {
                        allow: false,
                        data: {
                            tasks: [],
                            latLng: defaultLatLng,

                        }
                    },
                    configDataFiltersCategories: {
                        allow: false,
                        data: {
                            latLng: defaultLatLng,
                            categories: [
                                {
                                    id: 1,
                                    text: "Comida y Bebida",
                                    icon: "bi bi-cup-straw",
                                    children: [
                                        {id: 1, text: "Restaurantes", icon: "bi bi-shop"},
                                        {id: 2, text: "Cafeterias", icon: "bi bi-cup-hot"},
                                        {id: 3, text: "Heladerias", icon: "bi bi-snow"},
                                        {id: 4, text: "Reposteria", icon: "bi bi-cake2"},
                                        {id: 5, text: "Bar", icon: "bi bi-cup-straw"},
                                        {id: 6, text: "Vegetariana", icon: "bi bi-flower1"},
                                        {id: 7, text: "Carnes al Carbon", icon: "bi bi-fire"},
                                        {id: 8, text: "Mariscos", icon: "bi bi-water"},
                                        {id: 9, text: "Italiana", icon: "bi bi-egg-fried"},
                                        {id: 10, text: "Peruana", icon: "bi bi-geo-alt"},
                                        {id: 11, text: "Francesas", icon: "bi bi-bag-heart"},
                                        {id: 12, text: "Mexicanas", icon: "bi bi-pepper-hot"},
                                        {id: 13, text: "Chifas", icon: "bi bi-bowl-hot"},
                                        {id: 14, text: "Fast Food", icon: "bi bi-lightning-charge"},
                                        {id: 15, text: "Arabe", icon: "bi bi-moon-stars"},
                                        {id: 16, text: "Otros", icon: "bi bi-three-dots"}
                                    ]
                                },
                                {
                                    id: 2,
                                    text: "Ocio",
                                    icon: "bi bi-emoji-laughing",
                                    children: [
                                        {id: 17, text: "Parques", icon: "bi bi-tree"},
                                        {id: 18, text: "Gimnasio", icon: "bi bi-heart-pulse"},
                                        {id: 19, text: "Galeria de Arte", icon: "bi bi-palette"},
                                        {id: 20, text: "Atracciones", icon: "bi bi-stars"},
                                        {id: 21, text: "Musica en Vivo", icon: "bi bi-music-note-beamed"},
                                        {id: 22, text: "Cine", icon: "bi bi-film"},
                                        {id: 23, text: "Museo", icon: "bi bi-bank"},
                                        {id: 24, text: "Naturaleza", icon: "bi bi-mountain"},
                                        {id: 25, text: "Bibliotecas", icon: "bi bi-book"},
                                        {id: 26, text: "Otros", icon: "bi bi-three-dots"},
                                        {id: 76, text: "Turismo Náutico", icon: "bi bi-sailboat"}
                                    ]
                                },
                                {
                                    id: 3,
                                    text: "Comercios / Establecimientos",
                                    icon: "bi bi-shop",
                                    children: [
                                        {id: 27, text: "Limpieza e higiene", icon: "bi bi-droplet"},
                                        {id: 28, text: "Estetica y belleza", icon: "bi bi-scissors"},
                                        {id: 29, text: "Tiendas y bazares", icon: "bi bi-bag"},
                                        {id: 30, text: "Papelerias", icon: "bi bi-journal-text"},
                                        {id: 31, text: "Supermercados", icon: "bi bi-cart4"},
                                        {id: 32, text: "Electrodomesticos", icon: "bi bi-plug"},
                                        {id: 33, text: "Mobiliario", icon: "bi bi-lamp"},
                                        {id: 34, text: "Abarrotes", icon: "bi bi-basket"},
                                        {id: 35, text: "Motos/Bicicletas", icon: "bi bi-bicycle"},
                                        {id: 36, text: "Automotriz", icon: "bi bi-car-front"},
                                        {id: 37, text: "Calzado", icon: "bi bi-boot"},
                                        {id: 38, text: "Agricultura", icon: "bi bi-seedling"},
                                        {id: 39, text: "Otros", icon: "bi bi-three-dots"},
                                        {id: 70, text: "Escuelas", icon: "bi bi-backpack"},
                                        {id: 71, text: "Colegios", icon: "bi bi-mortarboard-fill"},
                                        {id: 72, text: "Educacion Inicial", icon: "bi bi-emoji-smile"},
                                        {id: 73, text: "Educacion Inicial 2", icon: "bi bi-emoji-smile-fill"},
                                        {id: 74, text: "Universidades", icon: "bi bi-building"},
                                        {id: 75, text: "Universidad de 4 Nivel", icon: "bi bi-award"}
                                    ]
                                },
                                {
                                    id: 4,
                                    text: "Oficios / Servicios",
                                    icon: "bi bi-tools",
                                    children: [
                                        {id: 40, text: "Oficios", icon: "bi bi-tools"},
                                        {id: 41, text: "Hospedaje", icon: "bi bi-house-door"},
                                        {id: 42, text: "Servicios financieros", icon: "bi bi-cash-coin"},
                                        {id: 43, text: "Servicios profesionales", icon: "bi bi-briefcase"},
                                        {id: 44, text: "Servicios empresariales", icon: "bi bi-building"},
                                        {id: 45, text: "Logistica", icon: "bi bi-box-seam"},
                                        {id: 46, text: "Educacion", icon: "bi bi-mortarboard"},
                                        {id: 47, text: "Otros", icon: "bi bi-three-dots"}
                                    ]
                                },
                                {
                                    id: 5,
                                    text: "Salud",
                                    icon: "bi bi-heart-pulse",
                                    children: [
                                        {id: 48, text: "Hospitales", icon: "bi bi-hospital"},
                                        {id: 49, text: "Industria Farmaceutica", icon: "bi bi-capsule"},
                                        {id: 50, text: "Consultorio medico", icon: "bi bi-clipboard2-pulse"},
                                        {id: 51, text: "Clinicas", icon: "bi bi-hospital-fill"},
                                        {id: 52, text: "Veterinaria", icon: "bi bi-bug"},
                                        {id: 53, text: "Otros", icon: "bi bi-three-dots"}
                                    ]
                                },
                                {
                                    id: 6,
                                    text: "Construccion",
                                    icon: "bi bi-hammer",
                                    children: [
                                        {id: 54, text: "Ferreterias", icon: "bi bi-wrench"},
                                        {id: 55, text: "Materiales de construccion", icon: "bi bi-bricks"},
                                        {id: 56, text: "Maquinaria pesada", icon: "bi bi-truck"},
                                        {id: 57, text: "Constructoras", icon: "bi bi-building-gear"},
                                        {id: 58, text: "Otros", icon: "bi bi-three-dots"}
                                    ]
                                },
                                {
                                    id: 7,
                                    text: "Textil",
                                    icon: "bi bi-scissors",
                                    children: [
                                        {id: 59, text: "Empresa textil", icon: "bi bi-patch-check"},
                                        {id: 60, text: "Venta de ropa", icon: "bi bi-bag-check"},
                                        {id: 61, text: "Venta de telas", icon: "bi bi-layers"},
                                        {id: 62, text: "Boutique", icon: "bi bi-stars"},
                                        {id: 63, text: "Produccion textil", icon: "bi bi-gear"},
                                        {id: 64, text: "Ropa y complementos", icon: "bi bi-person"},
                                        {id: 65, text: "Otros", icon: "bi bi-three-dots"}
                                    ]
                                },
                                {
                                    id: 8,
                                    text: "Transporte",
                                    icon: "bi bi-bus-front",
                                    children: [
                                        {id: 66, text: "Terrestre", icon: "bi bi-truck-front"},
                                        {id: 67, text: "Aereo", icon: "bi bi-airplane"},
                                        {id: 68, text: "Acuatico", icon: "bi bi-water"},
                                        {id: 69, text: "Otros", icon: "bi bi-three-dots"}
                                    ]
                                }
                            ]
                        }
                    },
                    paginationState: {
                        // estado del api
                        total: 0,          // response.total
                        rowCount: 10,      // response.rowCount
                        current: 0,        // response.current (página actual que ya cargaste)

                        // control de infinito
                        loading: false,    // lock anti-paralelo
                        hasMore: true,     // cortar cuando ya no hay más
                        throttleMs: 300,   // anti overload
                        lastFireAt: 0,     // throttle timestamp

                        // control: cuántos items ya tengo en UI
                        loadedCount: 0     // this.configGridAdmin.data.length
                    },
                    isFiltersOpen: false
                },
                methods: {
                    onEscClose(e) {
                        if (e.key === 'Escape') this.isFiltersOpen = false;
                    },
                    initViewProcess: function () {
                        var isDesktop = isDesktopOnly();
                        console.log("isDesktop", isDesktop)
                        if (isDesktop) {
                            if ($("#view-expand a").hasClass("active")) {
                                $("#view-expand a").click();
                            }
                            $("#view-expand").addClass("not-view");
                        } else {
                            $("#view-expand a").click();
                            $("#view-expand").addClass("not-view");

                        }
                    },
                    ...$methodsFormValid,
                    _submitForm: function (e) {
                        console.log(e);
                    },
                    initCurrentComponent: function () {
                        // this.getDataBusinessGamesTask({this: this});
                        $(document).ready(function () {
                            $("#view-rows a").click();
                        });
                    }, initManagement: function () {
                        console.log("init app");
                    },
                    /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                    _updateParentByChildren: function (params) {
                        console.log(params);
                        if (params.child == 'map-manager') {
                            if (params.action == "whenReady") {
                                console.log("params", params)
                            }
                        }
                    },
                    sendDataChildren: function (params) {
                        var nameChild = params["nameChild"];
                        this.$root.$emit(nameChild, params);
                    },
                    _element: function (e) {
                        console.log(e);
                    },
                    getDataBusinessGamesTask: function (params) {
                        var $this = params["this"];
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
                        var url = $('#action-manager-business-gamification-home').val();
                        /*  $configManagerMap.markers*/
                        getAjaxRequest({
                            type: 'POST',
                            'url': url,
                            data: dataSend,
                            successCallback: function (response) {
                                $this._managerGrid(response);
                                $this.managerLoading.data.view = false;
                                $this.managerLoading.page.view = false;
                                // $scope._resetManagerMaps(response.items);
                            },
                            beforeSend: function () {
                                $this.managerLoading.data.view = true;
                                $this.managerLoading.page.view = true;
                            },

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
                    },
                    _managerGrid2: function (response) {
                        var rowsCurrent = response["rows"];
                        const rows = rowsCurrent;
                        this.configGridAdmin.data.push(...rows);
                        this.configGridAdmin.isEmpty = this.configGridAdmin.data.length === 0;
                        this.configDataMapManager.data.tasks.push(...rows);
                        var isDesktop = isDesktopOnly();
                        this.configDataMapManager.allow = isDesktop;
                    },
                    _managerGrid: function (response) {

                        var rows = response["rows"] || [];
                        var total = parseInt(response["total"] || 0, 10);

                        // ✅ dedupe por task id (evita repetir si se dispara doble)
                        var existing = new Set(this.configGridAdmin.data.map(x => x.id));
                        var cleanRows = [];

                        for (var i = 0; i < rows.length; i++) {
                            if (!existing.has(rows[i].id)) {
                                cleanRows.push(rows[i]);
                            }
                        }

                        // ✅ acumula
                        this.configGridAdmin.data.push(...cleanRows);

                        // ✅ empty
                        this.configGridAdmin.isEmpty = (this.configGridAdmin.data.length === 0);

                        // ✅ mapa: envía data acumulada (sin repetidos de empresas si quieres)
                        // si el mapa debe ser por empresa única:
                        this.configDataMapManager.data.tasks = uniqueBusinesses(this.configGridAdmin.data);

                        // desktop only
                        var isDesktop = isDesktopOnly();
                        this.configDataMapManager.allow = isDesktop;

                        // ✅ actualiza contador para detener cuando loaded >= total
                        this.paginationState.total = total;
                        this.paginationState.loadedCount = this.configGridAdmin.data.length;

                        if (this.paginationState.loadedCount >= total) {
                            this.paginationState.hasMore = false;
                        }

                        // ✅ notificar mapa para que agregue markers (si ya está creado)
                        this.sendDataChildren({
                            nameChild: 'map-manager',
                            type: 'addMarkers',
                            data: this.configDataMapManager.data
                        });
                    },

                    getRowGameTaskHtml: function (params) {
                        // ✅ Imagen obligatoria
                        // FIX: si source existe => arma URL, si no => null
                        var coverImageUrl = params.source ? ($publicAsset + "/" + params.source) : null;
                        var avatarImgUser = params.avatarImgUser ? ($publicAsset + "/" + params.avatarImgUser) : null;
                        // Nuevo campo: físico/digital (ajusta el nombre si es otro)
                        var executionModeRaw = (params.execution_channel).toString().toUpperCase();
                        var isPhysical = executionModeRaw === "PHYSICAL" || executionModeRaw === "FISICO";
                        var isDigital = executionModeRaw === "DIGITAL";

                        // Fallback si no viene
                        var executionModeLabel = isPhysical ? "PHYSICAL" : (isDigital ? "DIGITAL" : "DIGITAL");
                        var executionModeText = isPhysical ? '{{__('gamification.physical')}}' : '{{__('gamification.digital')}}';
                        var executionModeIcon = isPhysical ? "📍" : "💻"; // simple, claro
                        var locationLabel = '{{__('location.find_here')}}' + ": " + params["zones_name"] + "," + params["business_street_one"] + "," + params["business_street_two"] + "," + params["cities_name"] + "," + params["provinces_name"];
                        var currentIde = params.id + "-" + params.business_id;
                        var business_lng = params.business_lng;
                        var business_lat = params.business_lat;

                        const task = {
                            coverUrl: coverImageUrl, // obligatorio según tu regla (deberías asegurar en data)
                            businessUrl: $urlRouteBusiness + '/' + params.business_name,
                            categoryText: "Commerce / Establishments",
                            businessName: params.business_name,
                            user_id: params.user_id,
                            user_name: params.user_name,
                            code: params.unique_code,
                            title: params.title,
                            subtitle: params.subtitle,
                            description: mcParseTaskDescriptionUI(params.description),
                            points: params.points,
                            avatarImgUser: avatarImgUser,
                            // Status
                            isActive: params.state === "ACTIVE",

                            // Nuevo
                            executionMode: executionModeLabel, // PHYSICAL | DIGITAL
                            executionModeText: executionModeText,
                            executionModeIcon: executionModeIcon,
                            entityProcessId: params.product_id,
                            entityProcessName: params.product_name,

                            // Tipo opcional
                            taskType: params.entity === "0" ? "business" : "product",
                            url_manager: params.url_manager,
                            is_url: params.is_url,
                            tracking_type_code_view: params.tracking_type_code_view,
                            tracking_source_code_view: params.tracking_source_code_view,
                            locationLabel: locationLabel,
                            id: params.id
                        };
                        var modeLabelClass = (task.executionMode === "PHYSICAL")
                            ? "label-warning"
                            : "label-primary";
                        var paramsLimitations = {
                            frequency_limit_type: params.frequency_limit_type,
                            frequency_limit_value: params.frequency_limit_value,
                            valid_from: params.valid_from,
                            valid_until: params.valid_until
                        };
// 1) helpers (nodos)
                        var rewardHtml =
                            '<div class="pullkay__reward">' +
                            '<span class="pullkay__reward-text">' + '  {{__('gamification.you_earn')}}' + '</span>' +
                            '<span class="pullkay__reward-value">+' + (task.points != null ? task.points : 0) + '</span>' +
                            '<span class="pullkay__reward-unit">Yapitas</span>' +
                            '</div>';

                        var typeLayoutClass = "list-layout";
                        var ctaHtml = '';
                        var allowLink = false;
                        if (task.is_url && task.tracking_source_code_view == "meetclick" && task.tracking_type_code_view == "click") {
                            urlCurrent = task.url_manager;
                            allowLink = true;
                        } else {
                            if ([undefined, 'undefined', 'null', null, 0, -1, '-1', '0'].includes(task.entityProcessId) && !isPhysical) {
                                urlCurrent = $urlRouteBusiness + "/" + task.businessName;
                                allowLink = true;
                            }
                        }
                        if (allowLink) {
                            ctaHtml = ['<a class="btn btn-xs pullkay__cta" href="' + (urlCurrent) + '" target="_blank">' +
                            '  {{__('gamification.do_it_now')}}' + ' <span class="pullkay__cta-arrow">→</span>' +
                            '</a>'];
                            ctaHtml = ctaHtml.join('');
                        }
                        var pullkay__actions = [
                            // CTA
                            '<div class="pullkay__actions">',
                            ctaHtml,
                            '</div>'
                        ];
                        const buildImg = () => [
                            '<div class="geodir-category-img">',
                            `    <img src="${task.coverUrl}" alt="">`,
                            '    <div class="overlay"></div>',
                            '</div>',
                        ].join('');

                        const buildCategory = () => [
                            `<a class="listing-geodir-category ${modeLabelClass} pullkay__label-mode" >`,
                            ' <span class="pullkay__label-mode-icon">' + task.executionModeIcon + '</span>',
                            task.executionModeText,
                            `</a>`
                        ].join('');

                        const buildAvatar = () => [
                            `<div class="listing-avatar not-view">`,
                            `  <a href="${$urlRouteUser + "/" + task.user_id}" alt="">`,
                            `     <img src="${task.avatarImgUser}" alt="" server="">`,
                            `  </a>`,
                            `  <span class="avatar-tooltip"><strong>${params.user_name}</strong></span>`,
                            `</div>`,
                        ].join('');

                        const buildTitle = () => [
                            '<h3>',
                            `  <a >${params.title}</a>`,
                            '</h3>',
                        ].join('');

                        const buildDescription = () => [
                            '<p class="pullkay__desc">' + task.description + '</p>',
                        ].join('');

                        const locationData = isPhysical ? [
                            '<div class="geodir-category-options fl-wrap">',
                            '   <div class="geodir-category-location">',
                            `    <a class="map-item" href="#${currentIde}" lat="${business_lat}" lng="${business_lng}">`,
                            '     <i class="fa fa-map-marker" aria-hidden="true"></i> ',
                            '         <span class="geodir-category-location__location">' + `${task.locationLabel}`,
                            '          </span>',
                            `   </a>`,
                            '  </div>',
                            '</div>',
                        ].join('') : [].join("");

                        const buildLocation = () => locationData;

                        // 2) body como árbol (secciones)
                        const body = [
                            '<article class="geodir-category-listing fl-wrap">',
                            buildImg(),
                            '  <div class="geodir-category-content fl-wrap">',
                            buildCategory(),
                            buildAvatar(),
                            buildTitle(),
                            rewardHtml,
                            buildLimitationsBadgesUI(paramsLimitations),
                            buildDescription(),
                            pullkay__actions.join(''),
                            buildLocation(),
                            '  </div>',
                            '</article>',
                        ].join('');
                        // 3) wrapper final
                        return [
                            '<div class="listing-item listing-item-search ' + typeLayoutClass + '" ' + "" + ' key-manager="#' + currentIde + '" >',
                            body,
                            '</div>',
                        ].join('');
                    },
                    _managerDataItemsMap: function (params) {
                        console.log("_managerDataItemsMap", params);
                        var cr2 = $(".card-popup-rainingvis");
                        cr2.each(function (cr) {
                            var starcount2 = $(this).attr("data-starrating2");
                            $("<i class='fa fa-star'></i>").duplicate(starcount2).prependTo(this);
                        });
                        $('.map-item').off('click');
                        var $this = this;
                        $('.map-item').click(function (e) {
                            e.preventDefault();
                            //     map.setZoom(15);
                            var currentManagement = $(this).attr('href').split('#');
                            var taskBusinessData = currentManagement[1];
                            var taskBusinessInfo = taskBusinessData.split("-");
                            var businessId = taskBusinessInfo[1];
                            var lat = parseFloat($(this).attr('lat'));
                            var lng= parseFloat($(this).attr('lng'));
console.log("lat",lat)
                            openGoogleMaps({ lat: lat, lng:lng }, { zoom: 21 });
                            $this.sendDataChildren({
                                "nameChild": 'map-manager',
                                "type": 'click-map-item',
                                "data": {businessId: businessId}
                            });
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
                            if (r) {
                                //  r[t].setAnimation(google.maps.Animation.BOUNCE);
                            }
                        }).on("mouseout", ".listing-item", function (e) {
                            var marker_index = parseInt($(this).attr('key-manager').split('#')[1], 10);
                            var t = marker_index;
                            if (r) {
                                //  r[t].setAnimation();
                            }
                        });
                    },
                    _resetManagerMaps: function (items) {

                    },


                    getDataBusinessGamesTaskAsync: function (params) {
                        var $this = params["this"];

                        return new Promise(function (resolve, reject) {
                            var current = $this.model.attributes.currentPage;
                            var searchPhrase = $this.model.attributes.keywords;
                            var distance = $this.model.attributes.distance;
                            var check = $this.model.attributes.check;
                            var country_id = $this.model.attributes.country;
                            var category_id = $this.model.attributes.category;
                            var addressGoogleCountry = $this.model.attributes['address-google'];

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

                            var url = $('#action-manager-business-gamification-home').val();

                            getAjaxRequest({
                                type: 'POST',
                                url: url,
                                data: dataSend,
                                successCallback: function (response) {

                                    // ✅ tu grid actualiza y acumula
                                    $this._managerGrid(response);

                                    $this.managerLoading.data.view = false;
                                    $this.managerLoading.page.view = false;

                                    resolve(response);
                                },
                                beforeSend: function () {
                                    $this.managerLoading.data.view = true;
                                    $this.managerLoading.page.view = true;
                                },
                                errorCallback: function (err) {
                                    $this.managerLoading.data.view = false;
                                    $this.managerLoading.page.view = false;
                                    reject(err);
                                }
                            });

                        });
                    },

                    initInfiniteScroll: function () {
                        var $this = this;

                        // evita duplicar handlers
                        $(window).off('scroll.mcInfinite');
                        $(window).on('scroll.mcInfinite', function () {
                            $this.onInfiniteScroll();
                        });

                        // por si el contenido inicial no llena pantalla
                        setTimeout(function () {
                            $this.onInfiniteScroll(true);
                        }, 400);
                    },

                    onInfiniteScroll: function (force = false) {
                        // 1) si está cargando o ya no hay más => nada
                        if (this.paginationState.loading) return;
                        if (!this.paginationState.hasMore) return;

                        // 2) throttle (anti overload)
                        var now = Date.now();
                        if (!force && (now - this.paginationState.lastFireAt) < this.paginationState.throttleMs) return;
                        this.paginationState.lastFireAt = now;

                        // 3) detectar si ya llegó al final usando #limit-box-wrap
                        if (!force && !this.isNearLimitBoxWrap()) return;

                        // 4) pedir siguiente página
                        this.loadNextPage();
                    },

                    isNearLimitBoxWrap: function () {
                        var $limit = $('#limit-box-wrap');
                        if (!$limit.length) return false;

                        // posición del sentinel en el documento
                        var limitTop = $limit.offset().top;

                        // scroll actual + alto ventana
                        var scrollBottom = $(window).scrollTop() + $(window).height();

                        // margen para precargar antes de tocar el final
                        var threshold = 300;

                        return (scrollBottom + threshold) >= limitTop;
                    },

                    loadNextPage: async function () {
                        var $this = this;
                        // lock
                        if (this.paginationState.loading) return;
                        this.paginationState.loading = true;

                        try {
                            // siguiente página = current + 1
                            var next = (parseInt(this.paginationState.current || 0, 10) + 1);

                            // set en tu model (tú ya usas model.attributes.currentPage)
                            this.model.attributes.currentPage = next;

                            // request
                            var response = await this.getDataBusinessGamesTaskAsync({this: $this});

                            // actualizar estado
                            this.applyPaginationFromResponse(response);

                        } catch (e) {
                            console.error('InfiniteScroll loadNextPage error:', e);
                            // si falla, NO avances la página
                            // (tu model queda en next, pero tu state.current no se incrementa, así reintenta)
                        } finally {
                            this.paginationState.loading = false;
                        }
                    },

                    applyPaginationFromResponse: function (response) {
                        // response: { total, rows, current, rowCount }
                        var total = parseInt(response.total || 0, 10);
                        var rowCount = parseInt(response.rowCount || 10, 10);
                        var current = parseInt(response.current || 0, 10);
                        var rows = (response.rows || []);

                        this.paginationState.total = total;
                        this.paginationState.rowCount = rowCount;
                        this.paginationState.current = current;

                        // loadedCount = lo que ya tienes en UI
                        this.paginationState.loadedCount = this.configGridAdmin.data.length;

                        // regla stop:
                        // si loaded >= total => no hay más
                        // o si rows viene vacío => no hay más
                        if (rows.length === 0 || (this.paginationState.loadedCount >= this.paginationState.total)) {
                            this.paginationState.hasMore = false;
                        } else {
                            this.paginationState.hasMore = true;
                        }
                    },

                }
            })
    ;
</script>
