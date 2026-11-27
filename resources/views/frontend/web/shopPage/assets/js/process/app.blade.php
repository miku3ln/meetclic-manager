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
                var dataBusiness = $dataManagerPage.dataBusinessInformation.businessData;

                var configurationSchedule = this.mapperDataScheduleBusiness($dataManagerPage.dataBusinessInformation.dataSchedules);
                console.log("hola--------",configurationSchedule);
                this.businessInformation.information.title = dataBusiness["title"];
                var businessId = dataBusiness["id"];
                this.businessInformation.information.id = businessId;
                this.businessInformation.information.url = $urlRouteBusiness + "/" + businessId;
                this.businessInformation.information.source = $publicAsset + dataBusiness["source"];
                this.businessInformation.subcategory.title = dataBusiness["business_subcategories"];
                this.businessInformation.subcategory.id = dataBusiness["business_subcategories_id"];
                this.businessInformation.category.title = dataBusiness["business_categories"];
                this.businessInformation.category.id = dataBusiness["business_categories_id"];
                var linksManagement = [
                    {
                        id: -1,
                        title: '{{__('frontend.business-details.menu-top.six.title')}}',
                        icon: 'fa fa-gamepad',
                        link: $urlRouteGamesBusiness.replace('/-1', '') + "/" + businessId,
                        'description': '{{__('frontend.business-details.menu-top.six.option-description')}}',
                        'options': [
                            '{{__('frontend.business-details.menu-top.six.option-one')}}',
                            '{{__('frontend.business-details.menu-top.six.option-two')}}',

                        ]
                    },
                    {
                        id: -1,
                        title: '{{__('frontend.business-details.menu-top.seven.title')}}',
                        icon: 'fa fa-gift',
                        link: $urlRouteRewardsBusiness.replace('/-1', '') + "/" + businessId,
                        'description': '{{__('frontend.business-details.menu-top.seven.option-description')}}',
                        'options': [
                            '{{__('frontend.business-details.menu-top.seven.option-one')}}',
                            '{{__('frontend.business-details.menu-top.seven.option-two')}}',
                            '{{__('frontend.business-details.menu-top.seven.option-three')}}',
                        ]
                    },
                    {
                        id: -1,
                        title: '{{__('frontend.business-details.menu-top.eight.title')}}',
                        icon: 'fa fa-commenting',
                        link: $urlRouteRateBusiness.replace('/-1', '') + "/" + businessId,
                        'description': '{{__('frontend.business-details.menu-top.eight.option-description')}}',
                        'options': [
                            '{{__('frontend.business-details.menu-top.eight.option-one')}}',
                            '{{__('frontend.business-details.menu-top.eight.option-two')}}',
                            '{{__('frontend.business-details.menu-top.eight.option-three')}}',
                        ]
                    }
                ];
                this.businessInformation.linksManagement = linksManagement;
                this.$nextTick(() => {
                    this.mountShopBusinessAside();

                    this.initShopBusinessAsideEvents();

                });
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
                this.destroyShopBusinessAsideEvents();
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
                filters: {
                    categoryId: -1,
                    subcategoryId: -1,

                },
                businessInformation: {
                    information: {title: "", id: -1, source: "", url: ''},
                    category: {title: "", id: -1},
                    subcategory: {title: "", id: -1},
                    starManagement: {count: 0, numberStar: 5, numberPerson: 0},
                    linksManagement: [
                        {id: -1, title: '', icon: '', link: ''}
                    ],

                },
                shopManager: {

                    businessAside: {
                        state: {
                            scheduleExpanded: false
                        },

                        showSchedule: true,
                        visible: false,

                        data: null,

                        config: {
                            showShare: true,
                            showSchedule: true,
                            showLocation: true,
                            showContact: true,
                            showReviews: true,
                            showPromotions: true,
                            showBenefits: true,

                            // Permite mostrar datos de prueba.
                            useMockData: true

                        },

                        translations: {
                            share: 'Compartir',

                            shareDescription: 'Comparte esta tienda por WhatsApp',

                            shareTitle: 'Descubre {business} en Yapita',

                            shareMessage: 'Explora sus productos, promociones y beneficios.',
                            close: 'Cerrar',

                            schedule: 'Horarios',
                            location: 'Ubicación',
                            contact: 'Contacto',
                            reviews: 'Reseñas',
                            promotions: 'Promociones',
                            benefits: 'Beneficios Yapita',

                            noSchedule: 'Horario no disponible',
                            noLocation: 'Ubicación no disponible',
                            noContact: 'Contacto no disponible',
                            noReviews: 'Todavía no tiene reseñas',
                            noPromotions: 'No hay promociones disponibles',

                            copy: 'Copiar',
                            copied: 'Copiado',

                            viewLocation: 'Ver ubicación',
                            viewReviews: 'Ver reseñas',

                            mock: 'Demostración'

                        }

                    },
                    header: {

                        schedule: {
                            status: 'UNKNOWN',
                            label: 'Sin horario',
                            text: '',
                            data: []

                        },

                        translations: {

                            open: 'Abierto',

                            closed: 'Cerrado',

                            unknown: 'Sin horario',

                            more: 'Información del negocio'

                        }

                    },
                    catalog: {

                        card: {

                            showCategory: true,

                            showDescription: true,

                            showFavorite: false,

                            showAdd: true,

                            showPoints: false,

                            showDiscount: true,

                            showOldPrice: true,

                            showTaxLabel: false,

                            showStock: false,

                            showCode: false,

                            imageMode: 'cover',

                            fallbackImage: '/images/default-product.png'

                        },

                        translations: {

                            noName: 'Sin nombre',

                            add: 'Agregar',

                            favorite: 'Agregar a favoritos',

                            viewProduct: 'Ver producto',

                            withTax: 'Con IVA',

                            withoutTax: 'Sin IVA',

                            unknownTax: 'IVA no definido',

                            stock: 'Stock',

                            points: 'Yapitas',

                            unavailablePrice: 'Consultar precio'

                        }
                    }

                }
            },
            methods: {
                _destroyTooltip: _destroyTooltip,
                _resetManagerGrid: _resetManagerGrid,
                _managerMenuGrid: _managerMenuGrid,
                _gridManager: _gridManager,
                toggleBusinessAsideSchedule: function () {
console.log("toggleBusinessAsideSchedule");
                    const state = this.shopManager.businessAside.state;

                    state.scheduleExpanded = !state.scheduleExpanded;

                },

                resetBusinessAsideSchedule: function () {

                    this.shopManager.businessAside.state.scheduleExpanded = false;

                },
                mapperDataScheduleBusiness: function (data) {

                    const schedule = {
                        status: 'UNKNOWN',
                        label: 'Sin horario',
                        text: '',
                        data: []
                    };

                    // ==========================================
                    // 1. VALIDAR INFORMACIÓN
                    // ==========================================

                    if (!Array.isArray(data) || !data.length) {
                        this.shopManager.header.schedule = schedule;
                        return schedule;
                    }

                    // ==========================================
                    // 2. OBTENER DÍA Y HORA ACTUAL
                    // Zona horaria de Ecuador continental
                    // ==========================================

                    const now = new Date();

                    const parts = new Intl.DateTimeFormat('en-US', {
                        timeZone: 'America/Guayaquil',
                        weekday: 'short',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hourCycle: 'h23'
                    }).formatToParts(now);

                    const getPart = (type) => {
                        return parts.find(item => item.type === type)?.value;
                    };

                    const days = [
                        'Mon', 'Tue', 'Wed', 'Thu',
                        'Fri', 'Sat', 'Sun'
                    ];

                    const currentDay = days.indexOf(getPart('weekday'));

                    const currentTime = [
                        getPart('hour'),
                        getPart('minute'),
                        getPart('second')
                    ].join(':');

                    // ==========================================
                    // 3. FUNCIONES AUXILIARES
                    // ==========================================

                    const timeToSeconds = (time) => {
                        const [hours, minutes, seconds = 0] =
                            time.split(':').map(Number);

                        return hours * 3600 + minutes * 60 + seconds;
                    };

                    const formatTime = (time) => {
                        return time ? time.substring(0, 5) : '';
                    };

                    const isValidTime = (time) => {
                        return typeof time === 'string' &&
                            /^(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d$/.test(time);
                    };

                    const currentSeconds = timeToSeconds(currentTime);

                    // ==========================================
                    // 4. MAPEAR HORARIOS POR DÍA
                    // ==========================================

                    schedule.data = data.map(day => {

                        const isActive =
                            day.status === 'ACTIVE' &&
                            day.modelDay === true &&
                            day.configTypeSchedule?.type === true;

                        const rawIntervals = day.configTypeSchedule?.data;

                        const intervals = (
                            isActive && Array.isArray(rawIntervals)
                                ? rawIntervals
                                : []
                        )
                            .map(item => ({
                                start_time: item.start_time?.modelBreakdown,
                                end_time: item.end_time?.modelBreakdown
                            }))
                            .filter(item =>
                                isValidTime(item.start_time) &&
                                isValidTime(item.end_time) &&
                                item.start_time !== item.end_time
                            )
                            .sort((a, b) =>
                                a.start_time.localeCompare(b.start_time)
                            );

                        const startTime = intervals.length
                            ? intervals[0].start_time
                            : null;

                        // Considerar horarios que terminan al día siguiente.
                        const getEndSeconds = (interval) => {

                            const start = timeToSeconds(interval.start_time);
                            const end = timeToSeconds(interval.end_time);

                            return end < start ? end + 86400 : end;
                        };

                        const lastInterval = intervals.reduce(
                            (last, interval) => {
                                return !last ||
                                getEndSeconds(interval) > getEndSeconds(last)
                                    ? interval
                                    : last;
                            },
                            null
                        );

                        const endTime = lastInterval?.end_time || null;

                        return {
                            id: day.id,
                            day: day.text,
                            weight_day: Number(day.weight_day),

                            is_active: isActive,
                            is_today: Number(day.weight_day) === currentDay,

                            start_time: startTime,
                            end_time: endTime,

                            text: intervals.length
                                ? `${formatTime(startTime)} - ${formatTime(endTime)}`
                                : 'Cerrado',

                            intervals: intervals
                        };

                    }).sort((a, b) => a.weight_day - b.weight_day);

                    // ==========================================
                    // 5. OBTENER HORARIO DE HOY Y AYER
                    // ==========================================

                    const today = schedule.data.find(
                        day => day.weight_day === currentDay
                    );

                    const yesterday = schedule.data.find(
                        day => day.weight_day === (currentDay + 6) % 7
                    );

                    // ==========================================
                    // 6. VERIFICAR SI ESTÁ ABIERTO
                    // ==========================================

                    const isOpenToday = today?.intervals.some(interval => {

                        const start = timeToSeconds(interval.start_time);
                        const end = timeToSeconds(interval.end_time);

                        // Horario normal.
                        if (end > start) {
                            return currentSeconds >= start &&
                                currentSeconds < end;
                        }

                        // Horario que continúa después de medianoche.
                        return currentSeconds >= start;

                    }) || false;

                    const isOpenFromYesterday = yesterday?.intervals.some(interval => {

                        const start = timeToSeconds(interval.start_time);
                        const end = timeToSeconds(interval.end_time);

                        return end < start && currentSeconds < end;

                    }) || false;

                    const isOpen = isOpenToday || isOpenFromYesterday;

                    // ==========================================
                    // 7. CONFIGURAR ESTADO FINAL
                    // ==========================================

                    schedule.status = isOpen ? 'OPEN' : 'CLOSED';
                    schedule.label = isOpen ? 'Abierto' : 'Cerrado';

                    if (today?.intervals.length) {

                        schedule.text = `Hoy: ${today.text}`;

                    } else if (isOpenFromYesterday) {

                        const interval = yesterday.intervals.find(item => {
                            return timeToSeconds(item.end_time) <
                                timeToSeconds(item.start_time) &&
                                currentSeconds < timeToSeconds(item.end_time);
                        });

                        schedule.text = `Hasta las ${formatTime(interval.end_time)}`;

                    } else {

                        schedule.text = 'Hoy no atiende';

                    }

                    // ==========================================
                    // 8. ACTUALIZAR SHOP MANAGER
                    // ==========================================

                    this.shopManager.header.schedule = schedule;

                    return schedule;
                },
                mountShopBusinessAside: function () {

                    const element = document.getElementById(
                        'shop-business-aside'
                    );

                    if (!element) {

                        console.warn(
                            'ShopBusinessAside: element not found'
                        );

                        return;

                    }

                    if (element.parentElement !== document.body) {

                        document.body.appendChild(element);

                    }

                    console.log(
                        'ShopBusinessAside mounted:',
                        element
                    );

                },
                onProcessBusiness: function (params) {

                    window.open(params.link, '_blank');
                },
                generateStars: function (starManagement) {

                    let html = `
                    <div class="rating-stars  mb-3">
                `;

                    for (let i = 1; i <= starManagement.numberStar; i++) {

                        if (starManagement.count >= i) {

                            html += `<i class="bi bi-star-fill"></i>`;

                        } else if (starManagement.count >= (i - 0.5)) {

                            html += `<i class="bi bi-star-half"></i>`;

                        } else {

                            html += `<i class="bi bi-star"></i>`;

                        }

                    }

                    html += ` <div class="rating-info">
                                                      ${starManagement.count} <span>(0 reseñas)</span>
                                                    </div>
                    </div>
                `;

                    return html;

                },
                onSubCategorySelect: function (params) {

                    var subCategory = params.subCategory;
                    this.filters.subcategoryId = subCategory.id;
                    this.filters.categoryId = subCategory.categoryId;

                    this.setFiltersGrid();
                },
                onCategorySelect: function (params) {

                    var category = params;
                    this.filters.categoryId = category.id;
                    if (category.subcategories.length == 0) {
                        this.setFiltersGrid();

                    }

                },
                initFiltersGrid: function () {
                    var categories = $dataManagerPage.categoriesShop.categories;
                    generateCategoriesCarousel({categories: categories, $scope: this});

                },
                setFiltersGrid: function () {
                    var gridName = this.gridConfig.selectorCurrent;
                    let gridInit = $(gridName);
                    gridInit.bootgrid("reload");
                },
                closeShopBusinessAside: function () {

                    const element = document.getElementById(
                        'shop-business-aside'
                    );

                    if (!element) {
                        return;
                    }

                    const instance =
                        bootstrap.Offcanvas.getInstance(element);

                    if (instance) {

                        instance.hide();

                    }

                },
                destroyShopBusinessAsideEvents: function () {

                    $(document).off('.shopBusinessAside');

                    const element = document.getElementById(
                        'shop-business-aside'
                    );

                    if (!element) {
                        return;
                    }

                    $(element).off('.shopBusinessAside');

                    const instance =
                        bootstrap.Offcanvas.getInstance(element);

                    if (instance) {

                        instance.dispose();

                    }

                },
                setShopScrollLock: function (locked = true) {

                    const className = 'shop-manager--scroll-locked';

                    document.documentElement.classList.toggle(
                        className,
                        locked
                    );

                    document.body.classList.toggle(
                        className,
                        locked
                    );

                },
                initShopBusinessAsideEvents: function () {

                    const vm = this;

                    const namespace = '.shopBusinessAside';

                    const eventName = 'shop:header:business:click';

                    // ==========================================
                    // HEADER EVENT
                    // ==========================================

                    $(document)
                        .off(eventName + namespace)
                        .on(eventName + namespace, function (event) {

                            const payload = event.originalEvent?.detail || {};

                            vm.openShopBusinessAside(payload.aside);

                        });

                    // ==========================================
                    // ASIDE ELEMENT
                    // ==========================================

                    const element = document.getElementById(
                        'shop-business-aside'
                    );

                    if (!element) {
                        return;
                    }

                    const $aside = $(element);

                    $aside.off(namespace);

                    // ==========================================
                    // BEFORE OPEN
                    // ==========================================

                    $aside.on(
                        'show.bs.offcanvas' + namespace,
                        function () {

                            vm.setShopScrollLock(true);

                        }
                    );

                    // ==========================================
                    // AFTER OPEN
                    // ==========================================

                    $aside.on(
                        'shown.bs.offcanvas' + namespace,
                        function () {

                            vm.shopManager.businessAside.visible = true;

                            vm.emitShopEvent(
                                'aside:opened',
                                {
                                    component: 'businessAside',
                                    business: vm.shopManager.businessAside.data.business,
                                    data: vm.shopManager.businessAside.data
                                },
                                element
                            );

                        }
                    );

                    // ==========================================
                    // AFTER CLOSE
                    // ==========================================

                    $aside.on(
                        'hidden.bs.offcanvas' + namespace,
                        function () {

                            vm.setShopScrollLock(false);

                            vm.shopManager.businessAside.visible = false;

                            vm.emitShopEvent(
                                'aside:closed',
                                {
                                    component: 'businessAside',
                                    data: vm.shopManager.businessAside.data
                                },
                                element
                            );

                        }
                    );

                },
                onShopBusinessAsideAction: function (
                    action,
                    item = null
                ) {

                    const data = this.shopManager.businessAside.data;

                    if (!data) {
                        return;
                    }

                    const events = {

                        location: 'aside:location:click',

                        'copy-phone': 'aside:contact:copy',

                        whatsapp: 'aside:contact:whatsapp',
                        'share-whatsapp': 'aside:share:whatsapp',

                        reviews: 'aside:reviews:click',

                        promotion: 'aside:promotion:click',

                        benefit: 'aside:benefit:click'

                    };

                    const eventName = events[action];

                    if (!eventName) {
                        return;
                    }

                    const payload = {

                        component: 'businessAside',

                        action: action,

                        businessId: data.business.id,

                        business: data.business,

                        item: item,

                        data: data,
                        share: action === 'share-whatsapp'
                            ? this.getShopShareData()
                            : null

                    };

                    const target = document.getElementById(
                        'shop-business-aside'
                    );

                    this.emitShopEvent(
                        eventName,

                        payload,

                        target
                    );

                },
                getShopShareData: function () {

                    const business = this.businessInformation.information;

                    const translations =
                        this.shopManager.businessAside.translations;

                    const title = translations.shareTitle.replace(
                        '{business}',
                        business.title
                    );

                    return {

                        businessId: business.id,

                        title: title,

                        description: translations.shareMessage,

                        url: window.location.href

                    };

                },
                getShopAsideStarClass: function (star, rating) {

                    if (rating >= star) {

                        return 'bi bi-star-fill';

                    }

                    if (rating >= star - 0.5) {

                        return 'bi bi-star-half';

                    }

                    return 'bi bi-star';

                },
                openShopBusinessAside: function (data = null) {

                    const vm = this;

                    this.shopManager.businessAside.data =
                        data || this.getShopBusinessAsideData();

                    this.$nextTick(() => {

                        vm.mountShopBusinessAside();

                        const element = document.getElementById(
                            'shop-business-aside'
                        );

                        if (!element) {
                            return;
                        }

                        const instance =
                            bootstrap.Offcanvas.getOrCreateInstance(
                                element,
                                {
                                    backdrop: true,
                                    keyboard: true,
                                    scroll: false
                                }
                            );

                        instance.show();

                        const backdrops = document.querySelectorAll(
                            '.offcanvas-backdrop'
                        );

                        const backdrop = backdrops[backdrops.length - 1];

                        if (backdrop) {

                            backdrop.classList.add(
                                'shop-business-aside-backdrop'
                            );

                        }

                    });

                },
                onShopHeaderClick: function (event) {

                    const asideData = this.getShopBusinessAsideData();

                    const payload = {

                        component: 'header',

                        action: 'open-business',

                        business: this.businessInformation,

                        businessId: asideData.business.id,

                        schedule: {
                            ...this.shopManager.header.schedule
                        },

                        aside: asideData

                    };

                    this.emitShopEvent(
                        'header:business:click',

                        payload,

                        event.currentTarget
                    );

                },
                getShopBusinessAsideData: function () {

                    const businessInformation = this.businessInformation;

                    const businessData =
                        $dataManagerPage.dataBusinessInformation.businessData || {};

                    const schedule = this.shopManager.header.schedule;

                    const config = this.shopManager.businessAside.config;

                    const translations =
                        this.shopManager.businessAside.translations;

                    // ==========================================
                    // LOCATION
                    // ==========================================

                    const address = [

                        [
                            businessData.street_1,
                            businessData.street_2

                        ].filter(Boolean).join(' y '),

                        businessData.city,

                        businessData.province?.trim()

                    ].filter(Boolean).join(', ');

                    const latitude = Number(businessData.street_lat);

                    const longitude = Number(businessData.street_lng);

                    const hasLocation =

                        businessData.street_lat != null &&

                        businessData.street_lng != null &&

                        businessData.street_lat !== '' &&

                        businessData.street_lng !== '' &&

                        Number.isFinite(latitude) &&

                        Number.isFinite(longitude) &&

                        Math.abs(latitude) <= 90 &&

                        Math.abs(longitude) <= 180;

                    const mapsUrl = hasLocation

                        ? `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`

                        : null;

                    // ==========================================
                    // PHONE
                    // ==========================================

                    const phoneCode = String(
                        businessData.phone_code || ''
                    ).replace(/\D/g, '');

                    const phoneValue = String(
                        businessData.phone_value || ''
                    ).replace(/\D/g, '');

                    let internationalPhone = '';

                    if (phoneValue) {

                        internationalPhone = phoneCode

                            ? '+' + (
                            phoneValue.startsWith(phoneCode)
                                ? phoneValue
                                : phoneCode + phoneValue.replace(/^0+/, '')
                        )

                            : phoneValue;

                    }

                    // ==========================================
                    // REVIEWS
                    // ==========================================

                    const rating = Number(
                        businessInformation.starManagement?.count || 0
                    );

                    const totalReviews = Number(
                        businessInformation.starManagement?.numberPerson || 0
                    );

                    // ==========================================
                    // BUSINESS LINKS
                    // ==========================================

                    const links = businessInformation.linksManagement || [];

                    // ==========================================
                    // PROMOTIONS
                    // TODO: CONNECT REAL SERVICE
                    // ==========================================

                    let promotions = [];

                    if (config.useMockData) {

                        promotions = [

                            {
                                id: 'mock-1',

                                name: 'Combo Trece',

                                description:
                                    'Hamburguesa + Papas + Bebida',

                                image: businessInformation.information.source,

                                price: 5.00,

                                currency: 'USD',

                                isMock: true

                            }

                        ];

                    }

                    // ==========================================
                    // BENEFITS
                    // ==========================================

                    const benefits = [

                        {
                            id: 1,
                            icon: 'bi bi-controller',
                            title: 'Completa retos y gana Yapitas',
                            action: 'games',
                            url: links[0]?.link || null
                        },

                        {
                            id: 2,
                            icon: 'bi bi-ticket-perforated',
                            title: 'Canjea por descuentos',
                            action: 'rewards',
                            url: links[1]?.link || null
                        },

                        {
                            id: 3,
                            icon: 'bi bi-gift',
                            title: 'Participa en premios',
                            action: 'rewards',
                            url: links[1]?.link || null
                        }

                    ];

                    // ==========================================
                    // FINAL DATA
                    // ==========================================

                    return {

                        business: {

                            id: businessInformation.information.id,

                            name: businessInformation.information.title,

                            logo: businessInformation.information.source,

                            category: businessInformation.category.title,

                            subcategory: businessInformation.subcategory.title,

                            description: businessData.description || '',

                            url: businessInformation.information.url,

                            raw: businessData

                        },

                        schedule: {

                            status: schedule.status,

                            label: schedule.label,

                            text: schedule.text || translations.noSchedule,

                            data: schedule.data

                        },

                        location: {

                            address: address || translations.noLocation,

                            latitude: hasLocation ? latitude : null,

                            longitude: hasLocation ? longitude : null,

                            city: businessData.city || '',

                            province: businessData.province || '',

                            country: businessData.countries || '',

                            mapsUrl: mapsUrl

                        },

                        contact: {

                            phone: internationalPhone,

                            email: businessData.email || '',

                            whatsapp: phoneCode && internationalPhone

                                ? `https://wa.me/${internationalPhone.replace(/\D/g, '')}`

                                : null

                        },

                        reviews: {

                            rating: rating,

                            total: totalReviews,

                            max: 5,

                            url: links[2]?.link || null

                        },

                        promotions: promotions,

                        benefits: benefits,

                        links: links,

                        raw: {

                            businessInformation: businessInformation,

                            businessData: businessData

                        }

                    };

                },

                emitShopEvent(eventName, payload = {}, target = null) {

                    const element = target || this.$el;

                    const customEvent = new CustomEvent(
                        `shop:${eventName}`,

                        {

                            detail: payload,

                            bubbles: true

                        }
                    );

                    element.dispatchEvent(customEvent);
                    // DEBUG EVENT
                    console.group(`🟢 ShopManager: shop:${eventName}`);

                    console.log('Event:', customEvent.type);
                    console.log('Payload:', payload);
                    console.log('Target:', element);
                    console.log('CustomEvent:', customEvent);

                    console.groupEnd();
                },
                setShopHeaderSchedule(data = {}) {

                    const translations =
                        this.shopManager.header.translations;

                    const statusValue = String(
                        data.status || 'UNKNOWN'
                    ).toUpperCase();

                    const status = [
                        'OPEN',
                        'CLOSED'
                    ].includes(statusValue)
                        ? statusValue
                        : 'UNKNOWN';

                    const labels = {

                        OPEN: translations.open,

                        CLOSED: translations.closed,

                        UNKNOWN: translations.unknown

                    };

                    this.shopManager.header.schedule = {

                        status: status,

                        label: labels[status],

                        text: data.text || ''

                    };

                },
                getFiltersGrid: function (request) {
                    var gridName = this.gridConfig.selectorCurrent;
                    var business_id = -1;
                    var dataBusinessInformation = $dataManagerPage.dataBusinessInformation;
                    var business = dataBusinessInformation.business[0];

                    var business_id = business.id;

                    var paramsFilters = {
                        business_id: business_id,
                        subcategoryId: this.filters.subcategoryId,
                        categoryId: this.filters.categoryId,

                    };
                    var result = {
                        ...request,
                        grid_id: gridName,
                        filters: paramsFilters,

                    };
                    return result;

                },
                getProductCardConfig: function () {

                    return this.shopManager.catalog.card;

                },

                getProductImage: function (source, fallback) {

                    if (!source) {
                        return fallback;
                    }

                    try {

                        const url = new URL(
                            source,
                            document.baseURI
                        );

                        if (['http:', 'https:'].includes(url.protocol)) {

                            return url.href;

                        }

                    } catch (error) {

                        return fallback;

                    }

                    return fallback;

                },
                escapeProductHtml: function (value) {

                    const characters = {

                        '&': '&amp;',

                        '<': '&lt;',

                        '>': '&gt;',

                        '"': '&quot;',

                        "'": '&#039;'

                    };

                    return String(value ?? '').replace(
                        /[&<>"']/g,

                        character => characters[character]
                    );

                },
                getProductPriceInformation: function (price = {}) {

                    const rawCurrent = price?.pv;

                    const rawOld = price?.pv_old;

                    const current = Number(rawCurrent);

                    const old = Number(rawOld);

                    const hasPrice =

                        rawCurrent != null &&

                        rawCurrent !== '' &&

                        Number.isFinite(current) &&

                        current >= 0;

                    const hasDiscount =

                        hasPrice &&

                        rawOld != null &&

                        Number.isFinite(old) &&

                        old > 0 &&

                        old > current;

                    const discount = hasDiscount

                        ? Math.round(
                            ((old - current) / old) * 100
                        )

                        : 0;

                    return {

                        hasPrice,

                        current: hasPrice
                            ? current
                            : null,

                        currentText: hasPrice
                            ? `$${current.toFixed(2)}`
                            : this.shopManager.catalog.translations.unavailablePrice,

                        old: hasDiscount
                            ? old
                            : null,

                        oldText: hasDiscount
                            ? `$${old.toFixed(2)}`
                            : '',

                        hasDiscount,

                        discount

                    };

                },
                getProductTaxInformation: function (tax = null) {

                    const translations =
                        this.shopManager.catalog.translations;

                    const value = String(
                        tax?.has_tax ?? ''
                    ).trim().toUpperCase();

                    const rawPercentage = tax?.value_percentage;

                    const percentage = Number(rawPercentage);

                    const validPercentage =
                        rawPercentage != null &&
                        rawPercentage !== '' &&
                        Number.isFinite(percentage) &&
                        percentage >= 0;

                    const config = {

                        SI: {

                            hasTax: true,

                            modifier: 'with-tax',

                            label: translations.withTax

                        },

                        NO: {

                            hasTax: false,

                            modifier: 'without-tax',

                            label: translations.withoutTax

                        }

                    };

                    const current = config[value] || {

                        hasTax: null,

                        modifier: 'unknown-tax',

                        label: translations.unknownTax

                    };

                    return {

                        ...current,

                        percentage: validPercentage
                            ? percentage
                            : null,

                        detail: current.hasTax === true && validPercentage
                            ? `IVA ${percentage}%`
                            : current.label

                    };

                },
                initGridManager: function (vmCurrent) {
                    var shopFiltersStickyManager = new ShopFiltersStickyManager({
                        containerSelector: '.content-manager-grid',
                        gridHeaderSelector: '#grid-registers-grid-header',
                        filtersSelector: '.filters-sections',
                        productsSelector: '#grid-registers-grid',
                        headerSelector: '.main-header',
                        autoTop: true,
                        offset: 0,
                        zIndex: 1020,
                        enabled: true

                    });

                    const vm = this;
                    const gridName = this.gridConfig.selectorCurrent;
                    const urlCurrent = this.gridConfig.url;

                    const gridInit = $(gridName);

                    const cssConfig = {
                        header: "bootgrid-header",
                        table: "xywer-tbl-admin",
                        iconRefresh: "fa fa-refresh",
                        iconDown: "fa-sort-down",
                        iconUp: "fa-sort-up",
                        dropDownMenu: "dropdown",
                        dropDownMenuItems: "dropdown-menu dropdown-menu-end",
                        dropDownItem: "dropdown-item",
                        dropDownItemButton: "dropdown-item"
                    };

                    const labelsConfig = {
                        ...$labelsGridConfigDefault,
                        search: 'Buscar'
                    };

                    gridInit.on(
                        "loaded.rs.jquery.bootgrid",
                        function () {

                            vmCurrent._resetManagerGrid();

                            vmCurrent._gridManager(gridInit);

                            customActionBar(gridInit);
                            console.log("sadd");
                            // REGISTER PRODUCT EVENTS
                            vm.bindProductCardEvents(gridInit);

                            shopFiltersStickyManager.init();

                        }
                    );

                    gridInit.bootgrid({

                        ajaxSettings: {
                            method: "POST"
                        },

                        ajax: true,

                        requestHandler: function (request) {
                            return vm.getFiltersGrid(request);
                        },

                        url: urlCurrent,

                        labels: labelsConfig,

                        css: cssConfig,

                        templates: getCustomTemplatesBS5(),

                        formatters: {

                            description: function (column, row) {

                                return vm.renderProductCard(row);

                            }

                        }

                    });

                    this.initFiltersGrid();

                },
                renderProductCard: function (row) {//

                    // ==========================================
                    // CONFIG
                    // ==========================================

                    const config = this.getProductCardConfig();

                    const translations =
                        this.shopManager.catalog.translations;

                    const escape = value =>
                        this.escapeProductHtml(value);

                    // ==========================================
                    // PRODUCT INFORMATION
                    // ==========================================

                    const id = row.id ?? '';

                    const name =
                        row.name || translations.noName;

                    const image = this.getProductImage(
                        row.source,

                        config.fallbackImage
                    );

                    const category = row.category || '';

                    const subcategory = row.subcategory || '';

                    const code = row.code || '';

                    const description = row.description || '';

                    const stock = row.stock

                        ? `${row.stock.quantity ?? 0} ${row.stock.unit ?? ''}`

                        : '';

                    // ==========================================
                    // PRICE AND TAX
                    // ==========================================

                    const tax = this.getProductTaxInformation(
                        row.tax
                    );

                    const price = this.getProductPriceInformation(
                        row.price
                    );

                    // ==========================================
                    // DESCRIPTION
                    // ==========================================

                    const descriptionParts = [];

                    if (description) {

                        descriptionParts.push(description);

                    } else if (category) {

                        descriptionParts.push(category);

                    }

                    if (config.showCode && code) {

                        descriptionParts.push(code);

                    }

                    if (config.showStock && stock) {

                        descriptionParts.push(
                            `${translations.stock}: ${stock}`
                        );

                    }

                    const descriptionText =
                        descriptionParts.join(' · ');

                    // ==========================================
                    // BEM MODIFIERS
                    // ==========================================

                    const modifiers = [

                        'shop-product-card'

                    ];

                    if (config.imageMode === 'contain') {

                        modifiers.push(
                            'shop-product-card--contain'
                        );

                    }

                    if (price.hasDiscount && config.showDiscount) {

                        modifiers.push(
                            'shop-product-card--promotion'
                        );

                    }

                    if (config.showAdd) {

                        modifiers.push(
                            'shop-product-card--with-actions'
                        );

                    }

                    // ==========================================
                    // CATEGORY
                    // ==========================================

                    const categoryHTML =

                        config.showCategory && subcategory

                            ? `
                <span class="shop-product-card__subcategory">
                    ${escape(subcategory)}
                </span>
            `

                            : '';

                    // ==========================================
                    // FAVORITE
                    // ==========================================

                    const favoriteHTML = config.showFavorite

                        ? `
            <button
                type="button"
                class="shop-product-card__favorite"
                data-action="favorite"
                aria-label="${escape(translations.favorite)}"
                title="${escape(translations.favorite)}"
            >
                <i class="fa fa-heart" aria-hidden="true"></i>
            </button>
        `

                        : '';

                    // ==========================================
                    // DISCOUNT
                    // ==========================================

                    const discountHTML =

                        config.showDiscount && price.hasDiscount

                            ? `
                <span class="shop-product-card__discount">
                    -${price.discount}%
                </span>
            `

                            : '';

                    // ==========================================
                    // OLD PRICE
                    // ==========================================

                    const oldPriceHTML =

                        config.showOldPrice && price.hasDiscount

                            ? `
                <span class="shop-product-card__price-old">
                    ${escape(price.oldText)}
                </span>
            `

                            : '';

                    // ==========================================
                    // TAX LABEL - OPTIONAL
                    // ==========================================

                    const taxHTML = config.showTaxLabel

                        ? `
            <span class="
                shop-product-card__tax
                shop-product-card__tax--${tax.modifier}
            ">
                ${escape(tax.detail)}
            </span>
        `

                        : '';

                    // ==========================================
                    // DESCRIPTION - OPTIONAL
                    // ==========================================

                    const descriptionHTML =

                        config.showDescription && descriptionText

                            ? `
                <div class="shop-product-card__description">
                    ${escape(descriptionText)}
                </div>
            `

                            : '';

                    // ==========================================
                    // YAPITAS - OPTIONAL
                    // ==========================================

                    const points = Number(row.points);

                    const pointsHTML =

                        config.showPoints &&
                        Number.isFinite(points) &&
                        points > 0

                            ? `
                <div class="shop-product-card__points">

                    <i
                        class="fa fa-trophy"
                        aria-hidden="true"
                    ></i>

                    <span>
                        +${points}
                        ${escape(translations.points)}
                    </span>

                </div>
            `

                            : '';

                    // ==========================================
                    // ADD ACTION
                    // ==========================================

                    const actionsHTML = config.showAdd

                        ? `
            <div class="shop-product-card__actions">

                <button
                    type="button"
                    class="shop-product-card__add"
                    data-action="add"
                    aria-label="${escape(`${translations.add} ${name}`)}"
                    title="${escape(translations.add)}"
                >

                    <i
                        class="bi bi-plus-circle"
                        aria-hidden="true"
                    ></i>

                </button>

            </div>
        `

                        : '';

                    // ==========================================
                    // FINAL TEMPLATE
                    // ==========================================

                    return `

        <article
            class="${modifiers.join(' ')}"
            data-product-id="${escape(id)}"
        >

            <!-- MEDIA -->

            <div class="shop-product-card__media">

                <button
                    type="button"
                    class="shop-product-card__media-action"
                    data-action="view"
                    aria-label="${escape(`${translations.viewProduct}: ${name}`)}"
                >

                    <img
                        src="${escape(image)}"
                        alt="${escape(name)}"
                        class="shop-product-card__image"
                        loading="lazy"
                        decoding="async"
                    >

                </button>

                <!-- TOP -->

                <div class="shop-product-card__top">

                    ${categoryHTML}

                    ${favoriteHTML}

                </div>

                ${discountHTML}

            </div>

            <!-- CONTENT -->

            <div class="shop-product-card__content">

                <!-- NAME -->

                <h3 class="shop-product-card__name">

                    <button
                        type="button"
                        class="shop-product-card__name-action"
                        data-action="view"
                    >
                        ${escape(name)}
                    </button>

                </h3>

                ${descriptionHTML}

                ${pointsHTML}

                <!-- FOOTER -->

                <div class="shop-product-card__footer">

                    <div class="shop-product-card__prices">

                        ${oldPriceHTML}

                        <span
                            class="
                                shop-product-card__price
                                shop-product-card__price--${tax.modifier}
                            "
                            title="${escape(tax.detail)}"
                        >

                            ${escape(price.currentText)}

                            <span class="visually-hidden">
                                ${escape(tax.detail)}
                            </span>

                        </span>

                        ${taxHTML}

                    </div>

                    ${actionsHTML}

                </div>

            </div>

        </article>

    `;

                },
                bindProductCardEvents: function (gridInit) {

                    const vm = this;

                    const selector = '.shop-product-card [data-action]';

                    const $buttons = gridInit.find(selector);

                    const events = {
                        view: 'catalog:product:click',
                        add: 'catalog:product:add',
                        favorite: 'catalog:product:favorite'
                    };

                    console.log('ShopManager: Buttons found', $buttons.length);

                    $buttons
                        .off('click.shopProductCard')
                        .on('click.shopProductCard', function (event) {

                            event.preventDefault();
                            event.stopPropagation();

                            console.log('ShopManager: CLICK DETECTED');

                            const $button = $(this);

                            const $card = $button.closest(
                                '.shop-product-card'
                            );

                            const action = $button.attr('data-action');

                            const productId =
                                $card.attr('data-product-id') ||
                                $card.closest('tr').attr('data-row-id');

                            const eventName = events[action];

                            if (!eventName || !productId) {
                                return;
                            }

                            const rows = gridInit.bootgrid(
                                'getCurrentRows'
                            ) || [];

                            const product = Array.isArray(rows)
                                ? rows.find(
                                    row => String(row.id) === String(productId)
                                )
                                : null;

                            if (!product) {

                                console.warn(
                                    'ShopManager: Product not found',
                                    productId
                                );

                                return;

                            }

                            const payload = {

                                component: 'catalog',

                                action,

                                productId: product.id,

                                product,

                                business: vm.businessInformation

                            };

                            vm.emitShopEvent(
                                eventName,
                                payload,
                                $card[0]
                            );

                        });

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
