<script id="management-tasks">

    function pushIf(arr, cond, html) {
        if (cond) arr.push(html);
    }

    function getActionType(task) {
        var url = String(task.url_manager || "");
        var code = String(task.code || "").toUpperCase();
        if (url.indexOf("whatsapp") >= 0 || code.indexOf("WHATSAPP") >= 0) return "WHATSAPP";
        if (url.indexOf("qr_") >= 0 || code.indexOf("QR") >= 0) return "QR";
        if (code.indexOf("FORM") >= 0 || url.indexOf("register") >= 0) return "FORM";
        if (Number(task.is_url) === 1) return "CLICK";
        return "IN_APP";
    }

    // ✅ usa t.action
    function actionLabel(t, task) {
        var type = getActionType(task);
        if (type === "WHATSAPP") return {icon: "fa-whatsapp", text: t.action.open_whatsapp};
        if (type === "QR") return {icon: "fa-qrcode", text: t.action.scan_qr};
        if (type === "FORM") return {icon: "fa-pencil-square-o", text: t.action.open_form};
        if (type === "CLICK") return {icon: "fa-external-link", text: t.action.open};
        return {icon: "fa-check", text: t.action.complete};
    }

    function escapeHtml(s) {
        return String(s || "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function safeJsonParse(str) {
        try {
            if (!str) return null;
            if (typeof str === "object") return str;
            return JSON.parse(str);
        } catch (e) {
            return null;
        }
    }


    function sanitizeUrl(url) {
        url = String(url || "").trim();
        if (!url) return "";
        if (url.indexOf("/") === 0) return url;
        if (/^https?:\/\//i.test(url)) return url;
        return "";
    }

    function safeDomId(s) {
        return String(s || "")
            .replace(/[^a-zA-Z0-9_-]/g, "_")
            .slice(0, 80);
    }

    function buildList(items) {
        if (!items || !items.length) return "";
        var li = items.map(function (x) {
            return "<li>" + escapeHtml(x) + "</li>";
        }).join("");
        return '<ul class="mc-list">' + li + '</ul>';
    }

    function limitLabel(p, t) {
        var type = String(p.frequency_limit_type || "").toUpperCase();
        var vRaw = p.frequency_limit_value;

        // Normaliza: si viene null/undefined => 1
        var v = Number(vRaw);
        if (isNaN(v) || v <= 0) v = 1;

        // Helper: reemplaza :value o {value}
        function applyValue(template, value) {
            template = String(template || "");
            return template
                .replace(/:value/g, String(value))
                .replace(/\{value\}/g, String(value));
        }

        // Si no está definido el tipo
        if (!type) {
            return (t.limit && t.limit.not_defined) ? t.limit.not_defined : "Not defined";
        }

        // Tipos directos
        if (type === "UNLIMITED") return (t.limit && t.limit.unlimited) ? t.limit.unlimited : "Unlimited";
        if (type === "ONCE") return (t.limit && t.limit.only_once) ? t.limit.only_once : "Only once";

        // Plantillas con placeholder (ya NO concatenamos)
        if (type === "DAILY") {
            return applyValue((t.limit && t.limit.per_day) ? t.limit.per_day : ":value use per day", v);
        }
        if (type === "WEEKLY") {
            return applyValue((t.limit && t.limit.per_week) ? t.limit.per_week : ":value use per week", v);
        }
        if (type === "MONTHLY") {
            return applyValue((t.limit && t.limit.per_month) ? t.limit.per_month : ":value use per month", v);
        }
        if (type === "TOTAL_LIMIT") {
            return applyValue((t.limit && t.limit.total_limit) ? t.limit.total_limit : ":value use in total", v);
        }

        // Fallback final
        return (t.limit && t.limit.not_defined) ? t.limit.not_defined : "Not defined";
    }

    function validityLabel(p, t) {
        var vf = p.valid_from;
        var vu = p.valid_until;

        if (!vf && !vu) return (t.validity && t.validity.always) ? t.validity.always : "Always available";
        if (vf && !vu) return ((t.validity && t.validity.from) ? t.validity.from : "Available from") + " " + vf;
        if (!vf && vu) return ((t.validity && t.validity.until) ? t.validity.until : "Available until") + " " + vu;

        return ((t.validity && t.validity.between) ? t.validity.between : "Available between") + " " + vf + " - " + vu;

    }
</script>

<script id="app-script">

    function getTaskText() {
        return {

// dentro de t.fallback:
            category: "Sin categoría",
            section: {
                yapitas_use_title: "{{ __("gamification.yapitas_use_title") }}",
                yapitas_use_text: "{{ __("gamification.yapitas_use_text") }}",
                steps: '{{ __("gamification.what_to_do") }}',
                tips: '{{ __("gamification.tip") }}',
                validation: '{{ __("gamification.validation") }}',
                rules: '{{ __("gamification.rules") }}',
                tech: '{{ __("tech") }}'
            },
            action: {
                details: '{{ __("details") }}',
                open: '{{ __("frontend.actions.open") }}',
                complete: '{{ __("complete") }}',
                open_whatsapp: '{{ __("open_whatsapp") }}',
                scan_qr: '{{ __("scan_qr") }}',
                open_form: '{{ __("open_form") }}',
                explore: '{{ __("gamification.explore") }}'
            },
            label: {
                state: '{{ __("state") }}',
                unique: '{{ __("unique") }}',
                channel: '{{ __("channel") }}',
                tracking: '{{ __("tracking") }}'
            },
            execution: {
                physical: '{{ __("gamification.physical") }}',
                digital: '{{ __("gamification.digital") }}'
            },
            location: {
                find_here: '{{ __("location.find_here") }}'
            },
            badge: {
                points_suffix: 'Yapitas'
            },
            fallback: {
                no_steps: '{{ __("messages.empty") }}'
            },

            // ✅ NUEVO: textos de limitaciones (existen en tu JSON)
            limit: {
                unlimited: '{{ __("gamification.unlimited") }}',
                only_once: '{{ __("gamification.only_once") }}',
                per_day: '{{ __("gamification.per_day") }}',
                per_week: '{{ __("gamification.per_week") }}',
                per_month: '{{ __("gamification.per_month") }}',
                total_limit: '{{ __("gamification.total_limit") }}',
                not_defined: '{{ __("gamification.not_defined") }}'
            },

            // ✅ NUEVO: textos de vigencia (existen en tu JSON)
            validity: {
                always: '{{ __("gamification.always_available") }}',
                from: '{{ __("gamification.available_from") }}',
                until: '{{ __("gamification.available_until") }}',
                between: '{{ __("gamification.available_between") }}'
            }
        };
    }

    var defaultLatLng = [0.229376, -78.2569127];

    function buildOneDescription(params) {
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
            business_id: params.business_id,
            coverUrl: coverImageUrl, // obligatorio según tu regla (deberías asegurar en data)
            businessUrl: $urlRouteBusiness + '/' + params.business_id,
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
                urlCurrent = $urlRouteBusiness + "/" + task.business_id;
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
        var informationBusiness = params.business_name + (" - " + params.business_subcategories_name + "");
        const buildBusiness = () => [
            '<h4 class="by-business">',
            `  <a href="${$urlRouteBusiness + "/" + task.business_id}">${informationBusiness}</a>`,
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
    }

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
                            this.isFiltersOpen = false;
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

                    // ✅ Textos (según idioma)
                    var t = getTaskText();

                    // ===== Base =====
                    var coverImageUrl = params.source ? ($publicAsset + "/" + params.source) : null;
                    var avatarImgUser = params.avatarImgUser ? ($publicAsset + "/" + params.avatarImgUser) : null;

                    var executionModeRaw = (params.execution_channel || "").toString().toUpperCase();
                    var isPhysical = executionModeRaw === "PHYSICAL" || executionModeRaw === "FISICO";
                    var isDigital = executionModeRaw === "DIGITAL";

                    var executionModeLabel = isPhysical ? "PHYSICAL" : (isDigital ? "DIGITAL" : "DIGITAL");
                    var executionModeText = isPhysical ? t.execution.physical : t.execution.digital;

                    // Ubicación (string)
                    var locationLabel = t.location.find_here + ": "
                        + (params["zones_name"] || "") + ", "
                        + (params["business_street_one"] || "") + ", "
                        + (params["business_street_two"] || "") + ", "
                        + (params["cities_name"] || "") + ", "
                        + (params["provinces_name"] || "");

                    // Empresa - categoría (fallback)
                    var businessCategory = params.business_category_name || params.category_name || t.fallback.category;
                    var locationBtn = [];

                    var task = {
                        id: params.id,
                        business_id: params.business_id,
                        coverUrl: coverImageUrl,
                        businessUrl: $urlRouteBusiness + '/' + params.business_id,
                        businessName: params.business_name,
                        businessCategory: businessCategory,
                        business_lat: params.business_lat,
                        business_lng: params.business_lng,

                        user_id: params.user_id,
                        user_name: params.user_name,
                        avatarImgUser: avatarImgUser,

                        code: params.unique_code,
                        title: params.title,
                        subtitle: params.subtitle,
                        description: params.description,

                        points: Number(params.points || 0),
                        isActive: params.state === "ACTIVE",

                        executionMode: executionModeLabel,
                        executionModeText: executionModeText,

                        entityProcessId: params.product_id,
                        entityProcessName: params.product_name,
                        taskType: params.entity === "0" ? "business" : "product",

                        url_manager: params.url_manager,
                        is_url: params.is_url,

                        tracking_type_code_view: params.tracking_type_code_view,
                        tracking_source_code_view: params.tracking_source_code_view,

                        locationLabel: locationLabel,
                        business_subcategories_name: params.business_subcategories_name,

                    };

                    // ===== Parse description JSON =====
                    var desc = safeJsonParse(task.description) || {};
                    var stepsHtml = buildList(desc.steps);
                    var helpersHtml = (desc.helpers && desc.helpers.length) ? ('<div class="mc-note">' + buildList(desc.helpers) + '</div>') : "";
                    var validationHtml = desc.validation ? ('<div class="mc-validation">' + escapeHtml(desc.validation) + '</div>') : "";
                    var rulesHtml = buildList(desc.rules);

                    // ===== Badges =====
                    var badgePoints = task.points > 0
                        ? '<span class="mc-badge mc-badge--points"><i class="fa fa-trophy"></i> +' + escapeHtml(task.points) + ' ' + escapeHtml(t.badge.points_suffix) + '</span>'
                        : '';

                    var badgeChannel = (task.executionMode === "PHYSICAL")
                        ? '<span class="mc-badge mc-badge--physical"><i class="fa fa-map-marker"></i> ' + escapeHtml(task.executionModeText) + '</span>'
                        : '<span class="mc-badge mc-badge--digital"><i class="fa fa-globe"></i> ' + escapeHtml(task.executionModeText) + '</span>';

                    // ===== Limitaciones =====
                    var paramsLimitations = {
                        frequency_limit_type: params.frequency_limit_type,
                        frequency_limit_value: params.frequency_limit_value,
                        valid_from: params.valid_from,
                        valid_until: params.valid_until
                    };

                    var badgeLimit =
                        '<span class="mc-badge mc-badge--limit"><i class="fa fa-repeat"></i> ' +
                        escapeHtml(limitLabel(paramsLimitations, t)) +
                        '</span>';

                    var badgeValidity =
                        '<span class="mc-badge"><i class="fa fa-calendar"></i> ' +
                        escapeHtml(validityLabel(paramsLimitations, t)) +
                        '</span>';

                    // ===== Acción principal =====
                    var safeUrl = sanitizeUrl(task.url_manager);
                    var collapseId = "mcMore_" + safeDomId((task.id + "_" + task.business_id));
                    var act = actionLabel(t, task);

                    // Botón detalles a la derecha con chevron (▼/▲)
                    var idIcon = "id='" + "mc-icon_" + (task.id + "_" + task.business_id) + "'";
                    var detailsBtn = [

                        '<div class="icon-current">',
                        '      <i class="fa fa-chevron-down mc-ico-chevron" ', idIcon, '></i> ',
                        '</div>',


                    ].join("");


                    // ===== Media =====
                    var mediaHtml = task.coverUrl
                        ? [
                            '<img src="', escapeHtml(task.coverUrl), '" alt="', escapeHtml(task.title), '" ',
                            'onerror="this.style.display=\'none\'; this.parentNode.innerHTML=\'<i class=\\\'fa fa-bolt\\\'></i>\';" />'
                        ].join("")
                        : '<i class="fa fa-bolt"></i>';

                    // ===== Meta visible =====
                    var categoryLine = '<span class="mc-task__cat">' + escapeHtml(task.business_subcategories_name) + '</span>';
                    var businessLine = task.businessName
                        ? '<h3 class="mc-task__biz"><i class="fa fa-building"></i> ' + escapeHtml(task.businessName) + "-" + categoryLine + '</h3>'
                        : '';


                    // ===== Visible: Qué hacer + Qué haces con Yapitas =====
                    var bodyVisibleParts = [];

                    bodyVisibleParts.push(
                        '<div class="mc-section">',
                        '    <h4 class="mc-section__title">🟢 ', escapeHtml(t.section.steps), (badgePoints ? badgePoints : ''), '</h4>',
                        (stepsHtml || ('<div class="mc-note">' + escapeHtml(t.fallback.no_steps)  , '</div>')),
                        '</div>'
                    );
                    // ===== Badges HTML =====
                    var badgesHtml = [
                        badgeChannel,
                        badgeLimit,
                        badgeValidity
                    ].join("");
                    bodyVisibleParts.push(
                        '  <div class="mc-task__badges">', badgesHtml, '</div>',
                    );
                    var optionCollapse = 'data-target="#' + collapseId + '"';
                    bodyVisibleParts.push(
                        '<div class="mc-section mc-section--to-make-yapitas">',
                        '   <h4 class="mc-section__title">🟢 ', escapeHtml(t.section.yapitas_use_title), '</h4>',
                        '   <div class="mc-note mc-note--details"', optionCollapse, ' >', escapeHtml(t.section.yapitas_use_text), detailsBtn, '</div>',
                        '</div>'
                    );

                    var bodyVisibleHtml = bodyVisibleParts.join("");

                    // ===== Collapse: Tip + Validación + Reglas + Tech + Ubicación larga =====
                    var showLocationInsideCollapse = (task.executionMode === "PHYSICAL" && task.locationLabel && String(task.locationLabel).length > 65);
                    var locationAttrs = ' data-lat="' + escapeHtml(task.business_lat) + '" data-lng="' + escapeHtml(task.business_lng) + '" ';

                    var collapseParts = [];
                    collapseParts.push('<div id="', escapeHtml(collapseId), '" class="collapse">');
                    collapseParts.push('<div class="mc-task__collapseBody">');

                    pushIf(collapseParts, !!helpersHtml,
                        '<div class="mc-section">' +
                        '<h4 class="mc-section__title">💡 ' + escapeHtml(t.section.tips) + '</h4>' +
                        helpersHtml +
                        '</div>'
                    );

                    pushIf(collapseParts, !!validationHtml,
                        '<div class="mc-section">' +
                        '<h4 class="mc-section__title">⚙️ ' + escapeHtml(t.section.validation) + '</h4>' +
                        validationHtml +
                        '</div>'
                    );

                    pushIf(collapseParts, !!rulesHtml,
                        '<div class="mc-section">' +
                        '<h4 class="mc-section__title">✅ ' + escapeHtml(t.section.rules) + '</h4>' +
                        rulesHtml +
                        '</div>'
                    );

                    // Tech siempre dentro
                    collapseParts.push(
                        '<div class="mc-section">',
                        '<h4 class="mc-section__title">🧾 ', escapeHtml(t.section.tech), '</h4>',
                        '<ul class="mc-list">',
                        '<li><b>', escapeHtml(t.label.unique), ':</b> ', escapeHtml(task.code), '</li>',
                        '<li><b>', escapeHtml(t.label.channel), ':</b> ', escapeHtml(task.executionMode), '</li>',
                        '<li><b>', escapeHtml(t.label.tracking), ':</b> ',
                        escapeHtml((task.tracking_source_code_view || "") + " / " + (task.tracking_type_code_view || "")),
                        '</li>',
                        '</ul>',
                        '</div>'
                    );

                    collapseParts.push('</div></div>'); // end collapse body + collapse wrapper
                    var collapseHtml = collapseParts.join("");

                    var urlSetNavigation = $urlRouteBusiness + "/" + task.business_id;
                    var primaryBtn = "";

                    console.log("safeUrl", safeUrl, urlSetNavigation)

                    if (Number(task.is_url) === 1 && safeUrl) {
                        console.log("btn ok", task.tracking_source_code_view, "isPhysical", isPhysical);
                        if (isPhysical) {
                            if (["qr_ticket"].includes(task.tracking_source_code_view)) {
                                primaryBtn = [
                                    '<a  ',
                                    locationAttrs,
                                    ' class="btn btn-sm mc-btn mc-btn--primary mc-btn--location" rel="noopener">',
                                    '  <i class="bi bi-geo-fill"></i> ', t.location.find_here,
                                    '</a>'
                                ].join("");
                            }

                        } else {
                            if (["qr_ticket"].includes(task.tracking_source_code_view)) {
                                primaryBtn = [
                                    '<a  ',
                                    locationAttrs,
                                    ' class="btn btn-sm mc-btn mc-btn--primary mc-btn--location" rel="noopener">',
                                    '  <i class="bi bi-geo-fill"></i> ', t.location.find_here,
                                    '</a>'
                                ].join("");
                            } else if (["meetclick", "whatsapp"].includes(task.tracking_source_code_view)) {
                                if (safeUrl.includes('/business-details/')) {
                                    urlSetNavigation = safeUrl;
                                }
                                primaryBtn = [
                                    '<a class="btn btn-sm mc-btn mc-btn--primary" href="', escapeHtml(urlSetNavigation), '" target="_blank" rel="noopener">',
                                    '  <i class="fa fa-external-link "></i> ', t.action.explore,
                                    '</a>'
                                ].join("");
                            } else {

                            }

                        }
                    } else {
                        console.log("btn not ok", task.tracking_source_code_view);


                        if (["meetclick"].includes(task.tracking_source_code_view)) {
                            if (safeUrl.includes('/business-details/')) {
                                urlSetNavigation = safeUrl;
                            }
                            primaryBtn = [
                                '<a class="btn btn-sm mc-btn mc-btn--primary" href="', escapeHtml(urlSetNavigation), '" target="_blank" rel="noopener">',
                                '  <i class="fa fa-external-link "></i> ', t.action.explore,
                                '</a>'
                            ].join("");
                        }
                    }
                    // ===== Actions bottom =====
                    var actionsHtml = [
                        '<div class="mc-task__actionsInner">',
                        '  <div class="mc-task__btns">',

                        '  </div>',
                        '   <div class="mc-task__rightActions">',
                        primaryBtn,
                        '   </div>',
                        '</div>',
                        '<div class="mc-task__state not-view">', escapeHtml(t.label.state), ': ', escapeHtml(params.state || "—"), '</div>'
                    ].join("");
                    // ===== FINAL LAYOUT =====
                    var htmlParts = [];
                    htmlParts.push(
                        '<article class="mc-task" data-channel="', escapeHtml(task.executionMode), '" data-action="', escapeHtml(getActionType(task)), '">'
                    );

                    // Row 1
                    htmlParts.push('<div class="mc-task__row-1">');

                    // Left (imagen + badges)
                    htmlParts.push(
                        '<div class="mc-task__left">',
                        '<div class="mc-task__media">', mediaHtml, '</div>',
                        '</div>'
                    );

                    // Right (meta + visible body + collapse)
                    htmlParts.push(
                        '<div class="mc-task__right">',
                        '<div class="mc-task__meta">',
                        '<h3 class="mc-task__title">', escapeHtml(task.title), '</h3>',
                        '<p class="mc-task__subtitle">', escapeHtml(task.subtitle), '</p>',
                        businessLine,
                        // Si es PHYSICAL pero NO es larga, la puedes mostrar aquí como línea corta (opcional)
                        (!showLocationInsideCollapse && task.executionMode === "PHYSICAL" && task.locationLabel
                                ? ('<div ' + locationAttrs + ' class="mc-task__locShort"><i class="fa fa-map-marker"></i> ' + escapeHtml(task.locationLabel) + '</div>')
                                : ''
                        ),
                        '</div>',
                        '<div class="mc-task__body">', bodyVisibleHtml, '</div>',
                        collapseHtml,
                        '</div>'
                    );

                    htmlParts.push('</div>'); // row-1

                    // Row 2
                    htmlParts.push(
                        '<div class="mc-task__row-2">',
                        '  <div class="mc-task__actions">', actionsHtml, '</div>',
                        '</div>'
                    );

                    htmlParts.push('</article>');

                    return htmlParts.join("");
                },

                _managerDataItemsMap: function (params) {
                    console.log("_managerDataItemsMap", params);
                    var cr2 = $(".card-popup-rainingvis");
                    cr2.each(function (cr) {
                        var starcount2 = $(this).attr("data-starrating2");
                        $("<i class='fa fa-star'></i>").duplicate(starcount2).prependTo(this);
                    });
                    $('.map-item').off('click');
                    $('.mc-btn--view-details').off('click');
                    $(".mc-btn--location").off('click');
                    $(".mc-note--details").off('click');
                    $(".mc-btn--location").click(function (e) {
                        var lat = parseFloat($(this).attr('data-lat'));
                        var lng = parseFloat($(this).attr('data-lng'));
                        openGoogleMaps({lat: lat, lng: lng}, {zoom: 21});
                    });

                    $('.mc-note--details').click(function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var idContainerData = $(this).data("target");
                        var setIconBtn = "fa-chevron-down";
                        if ($(idContainerData).hasClass("collapse")) {
                            setIconBtn = "fa-chevron-up";
                            $(idContainerData).removeClass("collapse");
                            $(idContainerData).addClass("collapsed");
                        } else {
                            setIconBtn = "fa-chevron-down";
                            $(idContainerData).removeClass("collapsed");
                            $(idContainerData).addClass("collapse");
                        }
                        var iconCurrent = idContainerData.split("mcMore");
                        console.log(iconCurrent)
                        var $btn = $('#mc-icon' + iconCurrent[1]);
                        $btn.removeClass("fa-chevron-down");
                        $btn.removeClass("fa-chevron-up");
                        $btn.addClass(setIconBtn);

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
