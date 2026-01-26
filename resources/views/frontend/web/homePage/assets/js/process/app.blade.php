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
                    var once = {
                        lat: defaultLatLng[0],
                        lng: defaultLatLng[1]
                    };
                    this.configDataMapManager.data.latLng = [once.lat, once.lng];
                    this.model.attributes.location = {
                        ...this.model.attributes.location,
                        lat: once.lat,
                        lng: once.lng,
                    };
                    this.configDataFiltersCategories.data.latLng = [defaultLatLng[0], defaultLatLng[1]];
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
                            'location': {lat: defaultLatLng[0], lng: defaultLatLng[1]},
                            'country_id': null,
                            'subCategoryIdsString': null,
                            'distance': 2,
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
                            distanceKm: 2,
                            locationCheck: false,
                            categories: $dataManagerPage.categoriesData
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
                        } else if (params.child == 'filters-categories') {
                            if (["resetAll", "applyFilters"].includes(params.action)) {
                                this.isFiltersOpen=false;
                                var dataSend = params.data;
                                this.model.attributes.check = dataSend.locationCheck;
                                this.model.attributes.distance = dataSend.distance;
                                this.model.attributes.location = {
                                    ...this.model.attributes.location,
                                    lat: dataSend.lat,
                                    lng: dataSend.lng
                                };
                                this.model.attributes.subCategoryIdsString = dataSend.subCategoryIdsString;
                                this.paginationState = {
                                    ...this.paginationState,
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
                                };
                                this.configDataMapManager.allow = false;
                                this.configDataMapManager.data = {
                                    ...this.configDataMapManager.data,
                                    data: {
                                        tasks: [],

                                    }
                                };
                                this.configGridAdmin.data = [];
                                this.configGridAdmin.isEmpty = true;
                                this.onInfiniteScroll(true);
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
                        const buildBusiness = () => [
                            '<h4 class="by-business">',
                            `  <a href="${$urlRouteBusiness + "/" + task.businessName}">${params.business_name}</a>`,
                            '</h4>',
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
                            buildBusiness(),

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
                            var lng = parseFloat($(this).attr('lng'));
                            console.log("lat", lat)
                            openGoogleMaps({lat: lat, lng: lng}, {zoom: 21});
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
                            var country_id = $this.model.attributes.country_id;
                            var subCategoryIdsString = $this.model.attributes.subCategoryIdsString;

                            var dataSend = {
                                searchPhrase: searchPhrase,
                                current: current,
                                filters: {
                                    lat: $this.model.attributes.location.lat,
                                    lng: $this.model.attributes.location.lng,
                                    check: check,
                                    distance: distance,
                                    country_id: country_id,
                                    subCategoryIdsString: subCategoryIdsString,

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
