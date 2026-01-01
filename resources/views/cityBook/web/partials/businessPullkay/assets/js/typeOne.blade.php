
<?php
$urlRouteBusiness= route('businessDetails', app()->getLocale());
?>
<script>
    var $paramsRequest = <?php echo json_encode($paramsRequest); ?>;
    var $dataManagerPage = <?php echo json_encode($dataManagerPage); ?>;
    var $business_id = <?php echo $dataManagerPage['business_id']; ?>;
    var $currentApp;
    var  $urlRouteBusiness = " <?php echo $urlRouteBusiness; ?>";

</script>

<script>
    function initEventsFilters() {
        $('#sort-by').on('change', function () {
            var sortConfig = new Object;
            var sortCurrent = 'asc';
            var sortId = $('#sort-by').val();
            var selectorCurrent = null;
            var nameKey = '';
            var titleOption = '';
            if (sortId == 0) {
                selectorCurrent = '#nameSort';
                sortCurrent = $(selectorCurrent).attr('order');
                titleOption = 'Nombre ';
                nameKey = 'name';
            } else if (sortId == 1) {
                selectorCurrent = '#codeSort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'code';
                titleOption = 'Codigo ';

            } else if (sortId == 2) {
                selectorCurrent = '#categorySort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'product_category';
                titleOption = 'Categoria ';

            } else if (sortId == 3) {
                selectorCurrent = '#subcategorySort';
                sortCurrent = $(selectorCurrent).attr('order');
                nameKey = 'product_subcategory';
                titleOption = 'Subcategoria ';

            }
            if (sortCurrent == 'asc') {
                titleOption += ' ASC';

                $(selectorCurrent).attr('order', 'desc');
            } else {
                titleOption += ' DESC';
            }
            sortConfig[nameKey] = sortCurrent;
            $(selectorCurrent).html('');
            $(selectorCurrent).html(titleOption);

            $(selectorGrid).bootgrid("sort", sortConfig);

            $('.chosen-select').niceSelect('update');
        });
        $('.a-subcategory').on('click', function () {

            var categoryCurrent = $(this).attr('category');
            console.log('hoalada')
            $.each($('.li-subcategory.mm-active'), function (index, value) {

                if ($(value).attr('category') != categoryCurrent) {
                    $(value).removeClass('mm-active');
                }
            });
            $('.a-subcategory.mm-active').removeClass('mm-active');
            $(this).addClass('mm-active');
            $('#category').val($(this).attr('category'));
            $('#subcategory').val($(this).attr('subcategory'));
            $(selectorGrid).bootgrid("reload");
            if ($('.content-filter').hasClass('not-view')) {

                $('.content-filter').removeClass('not-view');
            }
        });
        $('.content-filter').on('click', function () {

            $('.menu-manager-categories__li.mm-active').removeClass('mm-active');
            $('.li-subcategory.mm-active').removeClass('mm-active');
            $('.content-filter').addClass('not-view');
            $('#category').val('');
            $('#subcategory').val('');
            $(selectorGrid).bootgrid("reload");
        });

    }

    //ECCOMERCE-001
    // GRID DETAILS BUSINESS
    function getViewsRowProduct(params) {
        console.log(params);

        // ✅ Imagen obligatoria
        // FIX: si source existe => arma URL, si no => null
        var coverImageUrl = params.source ? ($publicAsset + "/" + params.source) : null;

        // Nuevo campo: físico/digital (ajusta el nombre si es otro)
        var executionModeRaw = (params.execution_channel).toString().toUpperCase();
        var isPhysical = executionModeRaw === "PHYSICAL" || executionModeRaw === "FISICO";
        var isDigital = executionModeRaw === "DIGITAL";

        // Fallback si no viene
        var executionModeLabel = isPhysical ? "PHYSICAL" : (isDigital ? "DIGITAL" : "DIGITAL");
        var executionModeText = isPhysical ? "Physical" : "Digital";
        var executionModeIcon = isPhysical ? "📍" : "💻"; // simple, claro

        const task = {
            coverUrl: coverImageUrl, // obligatorio según tu regla (deberías asegurar en data)
            businessUrl:$urlRouteBusiness+'/'+params.business_name,
            categoryText: "Commerce / Establishments",
            businessName: params.business_name,

            code: params.unique_code,
            title: params.title,
            subtitle: params.subtitle,
            description: params.description,
            points: params.points,

            // Status
            isActive: params.state === "ACTIVE",

            // Nuevo
            executionMode: executionModeLabel, // PHYSICAL | DIGITAL
            executionModeText: executionModeText,
            executionModeIcon: executionModeIcon,

            // Tipo opcional
            taskType: params.entity === "0" ? "business" : "product",
            url_manager:params.url_manager
        };

        // ✅ Labels (BS3)
        var statusLabel = task.isActive
            ? '<span class="label label-success pullkay__label-status">Available</span>'
            : '<span class="label label-default pullkay__label-status">Not available</span>';

        // Mode label (Physical/Digital)
        var modeLabelClass = (task.executionMode === "PHYSICAL")
            ? "label-warning"
            : "label-primary";

        var modeLabel =
            '<span class="label ' + modeLabelClass + ' pullkay__label-mode">' +
            '<span class="pullkay__label-mode-icon">' + task.executionModeIcon + '</span>' +
            task.executionModeText +
            '</span>';

        // Code label (si quieres mostrarlo; recomendado: solo admin, pero te lo dejo)
        var codeLabel = task.code
            ? '<span class="label label-info pullkay__code">' + task.code + '</span>'
            : "";

        // ✅ Reward (lo más importante para UX)
        // Se entiende instantáneo: "Ganas +100 Yapitas"
        var rewardHtml =
            '<div class="pullkay__reward">' +
            '<span class="pullkay__reward-text">You earn</span>' +
            '<span class="pullkay__reward-value">+' + (task.points != null ? task.points : 0) + '</span>' +
            '<span class="pullkay__reward-unit">Yapitas</span>' +
            '</div>';

        // ✅ CTA claro (sin esto el usuario duda)
        var ctaHtml = '';

        if (task.url_manager) {
            ctaHtml = ['<a class="btn btn-xs pullkay__cta" href="' + (task.url_manager || "#") + '">' +
            'Do it now <span class="pullkay__cta-arrow">→</span>' +
            '</a>'];
            ctaHtml=ctaHtml.join('');
        }
        var pullkay__actions = [
            // CTA
            '<div class="pullkay__actions">',
            ctaHtml,
            '</div>'
        ];

        // ✅ Imagen (obligatoria)
        var coverHtml =
            '<div class="media-left">' +
            '<a href="' + (task.businessUrl || "#") + '" class="pullkay__cover-link">' +
            '<img class="media-object pullkay__cover" src="' + task.coverUrl + '" alt="Task cover">' +
            '</a>' +
            '</div>';

        var subtitleHtml = task.subtitle
            ? '<p class="pullkay__subtitle">' + task.subtitle + '</p>'
            : "";

        var descHtml = task.description
            ? '<p class="pullkay__desc">' + task.description + '</p>'
            : "";

        // Wrapper (joined usa list-group-item; separated igual te sirve por ahora)
        var listItemClass = "pullkay-item list-group-item";

        return [
            '<div class="' + listItemClass + '" data-state="' + (task.isActive ? "active" : "inactive") + '">',

            // Reward arriba derecha (más visible que badge simple)
            rewardHtml,

            '<div class="pullkay media">',
            coverHtml,

            '<div class="media-body">',

            '<div class="pullkay__top-row clearfix">',
            '<small class="text-muted pullkay__category">' + (task.categoryText || "") + '</small>',
            '</div>',

            '<h4 class="media-heading pullkay__business">',
            '<a href="' + (task.businessUrl || "#") + '">' + (task.businessName || "") + '</a>',
            '</h4>',

            // Meta: status + physical/digital + code
            '<div class="pullkay__meta">',
            statusLabel,
            modeLabel,
            codeLabel,
            '</div>',

            '<div class="pullkay__title">',
            '<strong><a href="' + (task.businessUrl || "#") + '">' + (task.title || "") + '</a></strong>',
            '</div>',

            subtitleHtml,
            descHtml,

            pullkay__actions.join(''),
            '</div>',
            '</div>',
            '</div>'
        ].join("");
    }

    function getFilters() {

        var result = {
            business_id: $business_id,
            category: $('#category').val() ? $('#category').val() : -1,
            subcategory: $('#subcategory').val() ? $('#subcategory').val() : -1,
            'language': $language
        };
        return result;
    }

    //typeTwo
    var selectorGrid = '#product-grid';

    function InitGridManager() {
        var gridName = selectorGrid;
        var urlCurrent = $('#action-manager-business-gamification').val();
        var paramsFilters = {
            business_id: $business_id,
            'language': $language
        };
        var formatters = {
            'description': function (column, row) {
                let resultHtml = getViewsRowProduct(row);
                return resultHtml;
            }
        };

        let gridInit = GridManager({
            gridNameSelector: gridName,
            paramsFilters: paramsFilters,
            formatters: formatters,
            'urlCurrent': urlCurrent
        });

        gridInit.on("loaded.rs.jquery.bootgrid", function () {
            if (!$("#loading-data").hasClass('not-view')) {
                $("#loading-data").addClass('not-view');
            }
            if ($("#content-products").addClass('not-view')) {
                $("#content-products").removeClass('not-view');
            }
            if ($("#content-manager-products-services").addClass('not-view')) {
                $("#content-manager-products-services").removeClass('not-view');
            }

            $('#view-list').click();
            $(".add-cart").unbind('click');
            /*    initQuickView();*/
            _managerItemsOrders();
            //add new
            _managerItemsOrdersQuickView();
            /*   initEventWhishList();*/
            $('.shop-content-wrapper-loading').hide();
            $('.shop-content-wrapper').show();
            $("#content-manager-products-services").removeClass('not-view');
            $('#init-loading').addClass('not-view');
        });
    }

</script>


<script>
    const app = new Vue({
        directives: {
            'init-listing-item listing-item--pullkays': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            },
            'init-menu-shop': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            },
            'init-bootgrid': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            },
            'categories-items': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            },
            'nice-select': {
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
        mounted: function () {
            console.log('69')
            var allowConfig = this.allowInitSelect();
            var $scope = this;
            $(function () {
                $scope.niceConfigAllow.subcategories = allowConfig.subcategories;
            });
        },
        created: function () {
            console.log('6adadad9')


            $currentApp = this;
            var $scope = this;
            $(function () {
                initShareWhatsapp($scope);

                $scope.initManagement();
                $('.show-search-button').show();
                $('#management-product-details').on('click', function () {
                    $scope._managementProductDetails();
                });


            });

            this.$root.$on("_productRowGrid", function (emitValue) {
                $scope._managerTypes(emitValue);

            });
            this.initDataConfigGrid();

        },
        data: function () {
            var result = getDataStructure({type: 1})
            return result;
        },
        methods: {
            onListenElementsForm: onListenElementsForm,

            //EVENTS OF CHILDREN
            _managerTypes: function (emitValues) {
                if (emitValues.type == "resetComponent") {
                    this[emitValues.componentName] = {
                        viewAllow: false,
                        data: {}
                    };

                }
            },

            initMenuShop: function (params) {
                var elementInit = params.elementInit;
                $(elementInit).metisMenu({
                    toggle: true
                });
            },
            initGridShop: initGridShop,
            _searchData: _searchData,
            initManagement: function () {

                this._eventsProfile();
            },
            _eventsProfile: _eventsProfile,
            getUrlContact: getUrlContact,
            _element: function (e) {
                console.log(e);
            },

            _eventsMapCurrent: function () {

            },
            _managerDataItemsMap: function (params) {
            },
            getDataShare: function () {
                return getDataShare();
            },
            _shareType: _shareType,
            //MODAL
            _managementProductDetails: _managementProductDetails,


            initDataConfigGrid: function () {
                $scope = this;
                if (Object.keys($dataManagerPage['categories']).length > 0) {
                    $('#category').val($dataManagerPage['categories'][0]['id']);
                    if (Object.keys($dataManagerPage['categories'][0]['data']).length > 0) {
                        var dataCurrent = $dataManagerPage['categories'][0]['data'][0];

                        var structureSubcategories = this.structureSubcategories({
                            haystack: $dataManagerPage['categories'][0]['data']
                        });
                        this.filtersData.subcategories = structureSubcategories;
                        $scope.setConfigSubcategory({
                            'data': dataCurrent
                        });

                    }
                }
            },
            allowInitSelect: function () {
                var subcategories = false;
                var categories = false;

                if (Object.keys($dataManagerPage['categories']).length > 0) {
                    categories = true;

                    if (Object.keys($dataManagerPage['categories'][0]['data']).length > 0) {

                        subcategories = true;
                    }
                }
                var result = {
                    subcategories: subcategories,
                    categories: categories,

                };

                return result;
            },
            setCurrentFilters: function (params) {
                var category_id = params['category_id'];
                var subcategory_id = params['subcategory_id'];
                $('#category').val(category_id);
                $('#subcategory').val(subcategory_id);
            },
            structureSubcategories: function (params) {
                var haystack = params['haystack'];
                var result = [];
                $.each(haystack, function (index, value) {
                    var setData = value;
                    setData['text'] = value['value'];
                    result.push(setData);
                });

                return result;

            },
            searchSubcategories: function (params) {
                var categoryId = params['id'];
                var haystack = $dataManagerPage['categories'];
                var subcategories = [];
                $.each(haystack, function (index, value) {
                    if (value.id == categoryId) {
                        subcategories = value['data'];


                        return subcategories;
                    }
                });

                return subcategories;

            },
            setManagementFilters: function (params) {
                console.log(params);
                $scope = this;
                var subcategories = this.searchSubcategories(params);
                var categoryId = params['id'];
                this.filtersData.subcategories = [];
                var elementInit = $('#sort-by-subcategories');
                elementInit.select2('destroy');
                elementInit.html("");
                var structureSubcategories = [];
                this.niceConfigAllow.subcategories = false;
                this.niceConfigAllow.subcategoryImage = false;
                if (Object.keys(subcategories).length > 0) {

                    var structureSubcategories = this.structureSubcategories({
                        haystack: subcategories
                    });
                    this.filtersData.subcategories = structureSubcategories;
                    var dataCurrent = subcategories[0];
                    $scope.setConfigSubcategory({
                        'data': dataCurrent
                    });

                    $scope.niceConfigAllow.subcategories = true;
                }

                $('#category').val(categoryId);
                elementInit.select2({
                    data: structureSubcategories
                });
                elementInit.on("change", function (e) {
                    var dataCurrent = elementInit.select2('data');
                    var subcategory_id = null;
                    $scope.niceConfigAllow.subcategoryImage = false;
                    $scope.configFilters.subcatetory.img = null;
                    if (dataCurrent.length != 0) {
                        subcategory_id = dataCurrent[0]['id'];

                        $scope.setConfigSubcategory({
                            'data': dataCurrent[0]
                        });
                    }

                    $(selectorGrid).bootgrid("reload");
                });


                $(selectorGrid).bootgrid("reload");

            },
            initNice: function (params) {
                var structureSubcategories = this.filtersData.subcategories;
                $(params.elementInit).select2({
                    data: structureSubcategories
                });
            },
            getInitNice: function (data) {
                if (Object.keys(data).length > 0) {
                    return true;

                }

                return false;
            }
        }
    });

</script>
<script>
    $(function () {

        $('.show-search-button').show();
    })

</script>
