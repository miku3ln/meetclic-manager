<script id="owl-manager">

    function generateCategoriesCarousel(params = {}) {

        const categories = params.categories || [];
        var $scope = params.$scope;

        /*
        |--------------------------------------------------------------------------
        | SELECTORS
        |--------------------------------------------------------------------------
        */

        const $categoriesCarousel = $('.category-carousel');
        const $subCategoriesCarousel = $('.sub-categories-carousel');

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        destroyOwlCarousel($categoriesCarousel);
        destroyOwlCarousel($subCategoriesCarousel);

        $categoriesCarousel.html('');
        $subCategoriesCarousel.html('');

        /*
        |--------------------------------------------------------------------------
        | GENERATE CATEGORIES
        |--------------------------------------------------------------------------
        */

        let categoriesHtml = '';

        categories.forEach(category => {

            categoriesHtml += `
            <div class="item">

                <div
                    class="mc-category-card"

                    data-id="${category.id}"
                    data-title="${category.title}"
                    data-description="${category.description || ''}"
                >

                    <div class="mc-category-card__icon">
                        <i class="fa ${category.icon}"></i>
                    </div>

                    <div class="mc-category-card__content">

                        <div class="mc-category-card__title">
                            ${category.title}
                        </div>

                    </div>

                </div>

            </div>
        `;
        });

        $categoriesCarousel.html(categoriesHtml);

        /*
        |--------------------------------------------------------------------------
        | INIT CATEGORYS
        |--------------------------------------------------------------------------
        */

        initOwlCarousel($categoriesCarousel);

        /*
        |--------------------------------------------------------------------------
        | INIT SUBCATEGORYS
        |--------------------------------------------------------------------------
        */

        initOwlCarousel($subCategoriesCarousel);

        /*
        |--------------------------------------------------------------------------
        | CATEGORY CLICK
        |--------------------------------------------------------------------------
        */

        $categoriesCarousel.off('click');

        $categoriesCarousel.on('click', '.mc-category-card', function () {

            /*
            |--------------------------------------------------------------------------
            | ACTIVE
            |--------------------------------------------------------------------------
            */

            $('.mc-category-card')
                .removeClass('mc-category-card--active');

            $(this)
                .addClass('mc-category-card--active');

            /*
            |--------------------------------------------------------------------------
            | DATA
            |--------------------------------------------------------------------------
            */

            const categoryId = $(this).data('id');

            const category = categories.find(
                item => item.id == categoryId
            );

            console.log('CATEGORY', category);
            $scope.onCategorySelect(category);
            /*
            |--------------------------------------------------------------------------
            | RENDER SUBCATEGORYS
            |--------------------------------------------------------------------------
            */

            renderSubCategories({
                category,
                $carousel: $subCategoriesCarousel,
                $scope: $scope
            });

        });

        /*
        |--------------------------------------------------------------------------
        | AUTO SELECT FIRST CATEGORY
        |--------------------------------------------------------------------------
        */

        if (categories.length > 0) {

            setTimeout(() => {

                $categoriesCarousel
                    .find('.mc-category-card')
                    .first()
                    .trigger('click');

            }, 100);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SUBCATEGORYS
    |--------------------------------------------------------------------------
    */

    function renderSubCategories(params = {}) {

        const category = params.category || {};
        const $carousel = params.$carousel;

        const subcategories = category.subcategories || [];
        var $scope = params.$scope;

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        destroyOwlCarousel($carousel);

        $carousel.html('');

        /*
        |--------------------------------------------------------------------------
        | HTML
        |--------------------------------------------------------------------------
        */

        let html = '';

        subcategories.forEach(subcategory => {

            html += `
            <div class="item">

                <div
                    class="mc-subcategory-card"

                    data-id="${subcategory.id}"
                    data-category-id="${category.id}"
                    data-title="${subcategory.title}"
                    data-description="${subcategory.description || ''}"
                >

                    <div class="mc-subcategory-card__icon">
                        <i class="fa ${subcategory.icon}"></i>
                    </div>

                    <div class="mc-subcategory-card__content">

                        <div class="mc-subcategory-card__title">
                            ${subcategory.title}
                        </div>

                    </div>

                </div>

            </div>
        `;
        });

        $carousel.html(html);

        /*
        |--------------------------------------------------------------------------
        | INIT
        |--------------------------------------------------------------------------
        */

        initOwlCarousel($carousel);

        /*
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */

        $carousel.off('click');

        $carousel.on('click', '.mc-subcategory-card', function () {

            $('.mc-subcategory-card')
                .removeClass('mc-subcategory-card--active');

            $(this)
                .addClass('mc-subcategory-card--active');
            var subCategoryData = {
                id: $(this).data('id'),
                categoryId: $(this).data('category-id'),
                title: $(this).data('title')
            };
            console.log('SUBCATEGORY', subCategoryData);
            $scope.onSubCategorySelect({category: category, subCategory: subCategoryData});


        });

        /*
        |--------------------------------------------------------------------------
        | AUTO SELECT FIRST SUBCATEGORY
        |--------------------------------------------------------------------------
        */

        if (subcategories.length > 0) {

            setTimeout(() => {

                $carousel
                    .find('.mc-subcategory-card')
                    .first()
                    .trigger('click');

            }, 100);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | OWL INIT
    |--------------------------------------------------------------------------
    */

    function initOwlCarousel($carousel, options = {}) {

        const config = {

            loop: false,
            nav: true,
            dots: false,
            margin: 10,
            autoWidth: true,

            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                960: {
                    items: 6
                }
            },

            ...options
        };

        $carousel.owlCarousel(config);

        /*
        |--------------------------------------------------------------------------
        | MOUSE WHEEL
        |--------------------------------------------------------------------------
        */

        $carousel.off('mousewheel');

        $carousel.on('mousewheel', '.owl-stage', function (e) {

            if (e.originalEvent.deltaY > 0) {
                $carousel.trigger('next.owl');
            } else {
                $carousel.trigger('prev.owl');
            }

            e.preventDefault();
        });

    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY OWL
    |--------------------------------------------------------------------------
    */

    function destroyOwlCarousel($carousel) {

        if ($carousel.hasClass('owl-loaded')) {
            $carousel.trigger('destroy.owl.carousel');
        }

    }
</script>
<script id="management-tasks">
    function getCustomTemplatesBS5() {

        let templates = $.extend(true, {}, $.fn.bootgrid.Constructor.defaults.templates);

        // ✅ HEADER
        templates.header = `
<div id="@{{ctx.id}}" class="@{{css.header}} mc-grid--manager">
    <div class="row">
        <div class="col-12 actionBar custom-action-bar mc-grid__header d-flex justify-content-between align-items-center">

            <div class="mc-left mc-grid__left"></div>

            <div class="mc-center mc-grid__center">
                <p class="@{{css.search}} mc-grid__search mb-0"></p>
            </div>

            <div class="mc-right mc-grid__right">
                <p class="@{{css.actions}} mc-grid__actions mb-0 d-flex gap-2"></p>
            </div>

        </div>
    </div>
</div>
`;

        // ✅ BOTÓN
        templates.actionButton = `
<button class="btn btn-sm btn-primary mc-btn mc-grid__btn mc-grid__btn--primary"
        type="button"
        title="@{{ctx.text}}">
    @{{ctx.content}}
</button>
`;

        // ✅ DROPDOWN (BS5)
        templates.actionDropDown = `
<div class="@{{css.dropDownMenu}} mc-grid__dropdown">
    <button class="btn btn-sm btn-light dropdown-toggle mc-grid__dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">

        <span class="@{{css.dropDownMenuText}} mc-grid__dropdown-text">
            @{{ctx.content}}
        </span>
    </button>

    <ul class="@{{css.dropDownMenuItems}} mc-grid__dropdown-menu"></ul>
</div>
`;

        // ✅ ITEM DROPDOWN
        templates.actionDropDownItem = `
<li class="mc-grid__dropdown-item-wrapper">
    <a href="#"
       data-action="@{{ctx.action}}"
       class="@{{css.dropDownItem}} @{{css.dropDownItemButton}} mc-grid__dropdown-item">
        @{{ctx.text}}
    </a>
</li>
`;

        // ✅ CHECKBOX ITEM
        templates.actionDropDownCheckboxItem = `
<li class="mc-grid__dropdown-item-wrapper">
    <label class="dropdown-item d-flex align-items-center gap-2 mc-grid__dropdown-item mc-grid__dropdown-item--checkbox">
        <input name="@{{ctx.name}}"
               type="checkbox"
               class="form-check-input mc-grid__checkbox"
               @{{ctx.checked}} />
        <span class="mc-grid__label">@{{ctx.label}}</span>
    </label>
</li>
`;

        // ✅ SEARCH (más moderno)
        templates.search = `
<div class="@{{css.search}} mc-search mc-grid__search-wrapper">
    <div class="input-group input-group-sm mc-grid__search-group">
        <span class="input-group-text mc-grid__search-icon">
            <i class="fa fa-search"></i>
        </span>
        <input type="text"
               class="@{{css.searchField}} form-control mc-grid__search-input"
               placeholder="@{{lbl.search}}">
    </div>
</div>
`;

        return templates;
    }

    function customActionBar(grid) {

        let header = grid.closest('.bootgrid-header');

        // ejemplo: modificar botón refresh
        header.find('.btn').each(function () {

            let btn = $(this);

            // ejemplo: agregar tooltip
            btn.attr('data-bs-toggle', 'tooltip');

            // ejemplo: cambiar estilo
            btn.addClass('btn-sm');

        });

        // ejemplo: agregar botón custom
        if (header.find('.btn-custom-export').length === 0) {

            let customBtn = `
            <button class="btn btn-primary btn-sm btn-custom-export">
                <i class="ri-download-line"></i> Exportar
            </button>
        `;

            header.find('.actions').append(customBtn);
        }

        // Inicializar dropdowns BS5
        header.find('.dropdown-toggle').each(function () {
            new bootstrap.Dropdown(this);
        });
    }

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

                isFiltersOpen: false,
                gridConfig: {
                    selectorCurrent: "#grid-registers-grid",
                    url: $("#action-manager-getAdminShopPageByBusiness").val()
                },
                managerMenuConfig: {
                    view: false,
                    menuCurrent: [],
                    rowId: null
                },
                filters:{
                    categoryId:-1,
                    subcategoryId:-1,

                }
            },
            methods: {
                _destroyTooltip: _destroyTooltip,
                _resetManagerGrid: _resetManagerGrid,
                _managerMenuGrid: _managerMenuGrid,
                _gridManager: _gridManager,
                onSubCategorySelect: function (params) {

                   var subCategory= params.subCategory;
                    this.filters.subcategoryId=subCategory.id;
                    this.filters.categoryId=subCategory.categoryId;

                    this.setFiltersGrid();
                },
                onCategorySelect: function (params) {

                    var category= params;
                    this.filters.categoryId=category.id;


                },
                initFiltersGrid: function () {
                    var categories = $dataManagerPage.categoriesShop.categories;
                    generateCategoriesCarousel({categories: categories, $scope: this});

                },
                setFiltersGrid:function(){
                    var gridName = this.gridConfig.selectorCurrent;
                    let gridInit = $(gridName);
                    gridInit.bootgrid("reload");
                },
                getFiltersGrid: function () {
                    var gridName = this.gridConfig.selectorCurrent;
                    var business_id = -1;
                    var dataBusinessInformation = $dataManagerPage.dataBusinessInformation;
                    var business = dataBusinessInformation.business[0];

                    var business_id = business.id;

                    var paramsFilters = {
                        business_id: business_id,
                        subcategoryId:  this.filters.subcategoryId,
                        categoryId:  this.filters.categoryId,

                    };
                    var result={
                        grid_id: gridName,
                        filters: paramsFilters,

                    };
                    return result ;

                },
                initGridManager: function (vmCurrent) {
                    var gridName = this.gridConfig.selectorCurrent;
                    var urlCurrent = this.gridConfig.url;

                    var cssConfig = {
                        header: "bootgrid-header",
                        table: "xywer-tbl-admin",
                        iconRefresh: "fa fa-refresh",
                        iconDown: "fa-sort-down",
                        iconUp: "fa-sort-up",
                        dropDownMenu: "dropdown",
                        dropDownMenuItems: "dropdown-menu dropdown-menu-end",
                        dropDownItem: "dropdown-item",
                        dropDownItemButton: "dropdown-item",

                    };
                    $this=this;
                    let gridInit = $(gridName);
                    gridInit.bootgrid({
                        ajaxSettings: {
                            method: "POST"
                        },
                        ajax: true,
                        requestHandler: function (request) {
                            request = $this.getFiltersGrid();
                            return request;
                        },

                        url: urlCurrent,
                        labels: $labelsGridConfigDefault,
                        css: cssConfig,
                        templates: getCustomTemplatesBS5(), // 👈 AQUI ESTÁ LA CLAVE
                        formatters: {

                            'description': function (column, row) {

                                const image =
                                    row.source ||
                                    "/images/default-product.png";

                                const name =
                                    row.name || "Sin nombre";

                                const category =
                                    row.category || "";

                                const code =
                                    row.code || "";

                                const stock =
                                    row.stock
                                        ? `${row.stock.quantity} ${row.stock.unit}`
                                        : "0";

                                const subcategory =
                                    row.subcategory || "";

                                const hasTax =
                                    row.tax?.has_tax === "SI";

                                const taxPercentage =
                                    row.tax?.value_percentage || 0;

                                const priceCurrent =
                                    Number(row.price?.pv || 0);

                                const priceCurrentText =
                                    priceCurrent.toFixed(2);

                                const priceOld =
                                    row.price?.pv_old
                                        ? Number(row.price.pv_old)
                                        : null;

                                let discountHTML = ``;

                                if (priceOld) {

                                    const discount =
                                        Math.round(
                                            ((priceOld - priceCurrent) / priceOld) * 100
                                        );

                                    discountHTML = `
                <span class="
                    product-card__discount
                ">
                    -${discount}%
                </span>
            `;
                                }

                                const taxHTML = hasTax
                                    ? `
                <span class="
                    product-card__tax
                    product-card__tax--yes
                ">
                    IVA ${taxPercentage}%
                </span>
            `
                                    : `
                <span class="
                    product-card__tax
                    product-card__tax--no
                ">
                    SIN IVA
                </span>
            `;

                                return `

            <article class="product-card">

                <!-- IMAGE -->

                <div class="product-card__media">

                    <img
                        src="${image}"
                        alt="${name}"
                        class="product-card__image"
                    >

                    <!-- TOP -->

                    <div class="product-card__top">

                        <span class="
                            product-card__subcategory
                        ">
                            ${subcategory}
                        </span>

                        <button class="
                            product-card__favorite
                        ">
                            <i class="fa fa-heart"></i>
                        </button>

                    </div>

                </div>

                <!-- CONTENT -->

                <div class="product-card__content">

                    <!-- NAME -->

                    <h3 class="
                        product-card__name
                    ">
                        ${name}
                    </h3>

                    <!-- DESCRIPTION -->

                    <div class="
                        product-card__description
                    ">
                        ${category}
                        ·
                        ${code}
                        ·
                        Stock: ${stock}
                    </div>

                    <!-- PRICES -->

                    <div class="
                        product-card__prices
                    ">

                        <span class="
                            product-card__price
                        ">
                            $${priceCurrentText}
                        </span>

                        ${
                                    priceOld
                                        ? `
                                    <span class="
                                        product-card__price-old
                                    ">
                                        $${priceOld.toFixed(2)}
                                    </span>
                                `
                                        : ``
                                }

                        ${discountHTML}

                    </div>

                    <!-- TAX -->

                    <div class="
                        product-card__taxes
                    ">
                        ${taxHTML}
                    </div>

                    <!-- YAPITAS -->

                    <div class="product-card__points">
<i class="fa fa-trophy"></i>
                        +5 Yapitas
                    </div>

                    <!-- ACTIONS -->

                    <div class="
                        product-card__actions
                    ">

                        <button class="
                            product-card__add
                        ">
                            <i class="ri-add-line"></i>
                            Agregar
                        </button>

                    </div>

                </div>

            </article>

        `;
                            }

                        }
                    }).on("loaded.rs.jquery.bootgrid", function () {
                        vmCurrent._resetManagerGrid();
                        vmCurrent._gridManager(gridInit);
                        customActionBar(gridInit);
                    });

                    this.initFiltersGrid();
                },
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
                    this.initGridManager(this);
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


                _resetManagerMaps: function (items) {

                },


            }
        })
    ;
</script>
