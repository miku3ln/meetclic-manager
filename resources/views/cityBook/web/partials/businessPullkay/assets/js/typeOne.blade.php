
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
    /**
     * Reconoce íconos (🟢 🟡 🎁 etc.), los separa en items y devuelve HTML BS3.
     * - Soporta textos con saltos \n y/o <br>
     * - Mantiene el texto original, solo lo ordena en UI
     */
    function mcParseTaskDescriptionUI(descriptionText) {
        if (!descriptionText) return '';

        // Normaliza: convierte <br> a \n y limpia
        var raw = String(descriptionText)
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/\r/g, '')
            .trim();

        // Mapa de íconos reconocidos => etiqueta UI
        // (puedes agregar más sin romper nada)
        var iconMap = [
            { icon: '🟢', key: 'do',     label: '{{__('gamification.what_to_do')}}',       bs: 'label-success' },
            { icon: '🟡', key: 'why',    label:  '{{__('gamification.what_is_it_for')}}',  bs: 'label-warning' },
            { icon: '🎁', key: 'gain',   label: '{{__('gamification.what_you_get')}}',       bs: 'label-primary' },

            // Opcionales útiles
            { icon: '🔴', key: 'avoid',  label: '{{__('gamification.avoid')}}',           bs: 'label-danger' },
            { icon: '🔵', key: 'note',   label: '{{__('gamification.note')}}',            bs: 'label-info' },
            { icon: '🟣', key: 'tip',    label:  '{{__('gamification.tip')}}',             bs: 'label-info' },
            { icon: '⚠️', key: 'warn',   label: '{{__('gamification.important')}}',      bs: 'label-danger' }
        ];

        // Regex: captura "🟢 ...texto..." hasta antes del siguiente ícono o fin
        // Nota: armamos el grupo dinámico con los íconos definidos arriba
        var iconsPattern = iconMap
            .map(function(x){ return x.icon.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); })
            .join('|');

        var re = new RegExp('(^|\\n)(' + iconsPattern + ')\\s*([^\\n]*)([\\s\\S]*?)(?=(\\n(' + iconsPattern + ')\\s*)|$)', 'g');

        var items = [];
        var match;

        while ((match = re.exec(raw)) !== null) {
            var icon = match[2];
            var head = (match[3] || '').trim();
            var tail = (match[4] || '').trim();

            // Une cabecera + cola (por si el texto está en varias líneas)
            var content = (head + ' ' + tail)
                .replace(/\s+/g, ' ')
                .trim();

            // Limpia "Qué hacer:" / "Para qué sirve:" / "Qué ganas:" si ya vienen escritos
            content = content
                .replace(/^(qué\s*hacer|para\s*qué\s*sirve|qué\s*ganas)\s*:\s*/i, '')
                .trim();

            var meta = iconMap.find(function(x){ return x.icon === icon; }) || {
                icon: icon, label: 'Info', bs: 'label-default'
            };

            items.push({
                icon: meta.icon,
                label: meta.label,
                bs: meta.bs,
                text: content
            });
        }

        // Si NO encontró íconos, devuelve un bloque simple
        if (!items.length) {
            return [
                '',
                '',
                '' + mcEscapeHtml(raw) + '',
                ''
            ].join('');
        }

        // Construye HTML: un “row” por item + <br> entre items (como pediste)
        var html = '';
        items.forEach(function(it, idx){
            html += [
                '' + it.icon + ' ',
              mcEscapeHtml(it.label)+": ",
                '',
                '' + mcEscapeHtml(it.text) + '',
                ''
            ].join('');

            if (idx < items.length - 1) html += '<br>'; // <br> por cada uno
        });
        html += '</div>';

        return html;
    }

    /** Escape HTML (para evitar que se inyecte algo raro desde DB) */
    function mcEscapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

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
    /**
     * Build a "Limitations UI" as an HTML string (Bootstrap 3 + FontAwesome).
     * Params:
     * - frequency_limit_type: 'NONE'|'ONCE'|'DAILY'|'WEEKLY'|'MONTHLY'|'TOTAL_LIMIT'
     * - frequency_limit_value: number|null
     * - valid_from: string|null (YYYY-MM-DD or YYYY-MM-DD HH:mm:ss)
     * - valid_until: string|null (YYYY-MM-DD or YYYY-MM-DD HH:mm:ss)
     */
    function buildLimitationsBadgesUI(params) {
        params = params || {};

        var type = (params.frequency_limit_type || 'NONE').toUpperCase();
        var val = params.frequency_limit_value;

        var validFrom = params.valid_from || null;
        var validUntil = params.valid_until || null;

        function escHtml(str) {
            return String(str)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function toDateOnly(d) {
            if (!d) return null;
            // acepta "YYYY-MM-DD" o "YYYY-MM-DD HH:mm:ss"
            var s = String(d).trim();
            return s.split(' ')[0];
        }

        function isEmptyDate(d) {
            return d === null || d === undefined || String(d).trim() === '';
        }

        function normalizeValue(v) {
            // si no viene valor, por UX asumimos 1 cuando corresponde
            if (v === null || v === undefined || v === '') return 1;
            var n = parseInt(v, 10);
            return isNaN(n) || n <= 0 ? 1 : n;
        }

        // 1) Vigencia
        var vigText = '';
        var vigBadge = 'badge'; // BS3

        if (isEmptyDate(validFrom) && isEmptyDate(validUntil)) {
            vigText = ' {{__('gamification.always_available')}}';
            vigBadge += ' limitations__badge limitations__badge--ok';
        } else if (!isEmptyDate(validFrom) && isEmptyDate(validUntil)) {
            vigText = ' {{__('gamification.available_from')}}' + escHtml(toDateOnly(validFrom));
            vigBadge += ' limitations__badge limitations__badge--info';
        } else if (isEmptyDate(validFrom) && !isEmptyDate(validUntil)) {
            vigText = ' {{__('gamification.available_until')}}' + escHtml(toDateOnly(validUntil));
            vigBadge += ' limitations__badge limitations__badge--warn';
        } else {
            vigText =' {{__('gamification.available_between')}}' + escHtml(toDateOnly(validFrom)) + ' al ' + escHtml(toDateOnly(validUntil));
            vigBadge += ' limitations__badge limitations__badge--info';
        }

        // 2) Repetición / Cuántas veces
        var repText = '';
        var repBadge = 'badge';
        var repIcon = 'fa-refresh';

        if (type === 'NONE') {
            repText ='   {{__('gamification.unlimited')}}';
            repBadge += ' limitations__badge limitations__badge--ok';
            repIcon = 'fa-infinity'; // si no existe en tu FA, cambia a fa-refresh
        } else if (type === 'ONCE') {
            repText = '  {{__('gamification.only_once')}}';
            repBadge += ' limitations__badge limitations__badge--danger';
            repIcon = 'fa-lock';
        } else if (type === 'DAILY') {
            var v1 = normalizeValue(val);
            repText = v1 +'  {{__('gamification.per_day')}}';
            repBadge += ' limitations__badge limitations__badge--info';
            repIcon = 'fa-sun-o';
        } else if (type === 'WEEKLY') {
            var v2 = normalizeValue(val);
            repText = v2 + '  {{__('gamification.per_week')}}';
            repBadge += ' limitations__badge limitations__badge--info';
            repIcon = 'fa-calendar';
        } else if (type === 'MONTHLY') {
            var v3 = normalizeValue(val);
            repText = v3 + '  {{__('gamification.per_month')}}';
            repBadge += ' limitations__badge limitations__badge--info';
            repIcon = 'fa-calendar-o';
        } else if (type === 'TOTAL_LIMIT') {
            var v4 = normalizeValue(val);
            repText = 'Máximo ' + v4 + '  {{__('gamification.total_limit')}}';
            repBadge += ' limitations__badge limitations__badge--warn';
            repIcon = 'fa-flag-checkered';
        } else {
            repText = '  {{__('gamification.not_defined')}}';
            repBadge += ' limitations__badge limitations__badge--danger';
            repIcon = 'fa-exclamation-triangle';
        }

        // HTML final (BS3)
        var html = ''
            + '<div class="limitations">'
            + '  <div class="limitations__row">'
            + '    <i class="fa fa-calendar limitations__icon" aria-hidden="true"></i>'
            + '    <span class="' + vigBadge + '">' + escHtml(vigText) + '</span>'
            + '  </div>'
            + '  <div class="limitations__row">'
            + '    <i class="fa ' + escHtml(repIcon) + ' limitations__icon" aria-hidden="true"></i>'
            + '    <span class="' + repBadge + '">' + escHtml(repText) + '</span>'
            + '  </div>'
            + '</div>';

        return html;
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
        var executionModeText = isPhysical ? '{{__('gamification.physical')}}' : '{{__('gamification.digital')}}';
        var executionModeIcon = isPhysical ? "📍" : "💻"; // simple, claro

        const task = {
            coverUrl: coverImageUrl, // obligatorio según tu regla (deberías asegurar en data)
            businessUrl:$urlRouteBusiness+'/'+params.business_name,
            categoryText: "Commerce / Establishments",
            businessName: params.business_name,

            code: params.unique_code,
            title: params.title,
            subtitle: params.subtitle,
            description: mcParseTaskDescriptionUI(params.description),
            points: params.points,

            // Status
            isActive: params.state === "ACTIVE",

            // Nuevo
            executionMode: executionModeLabel, // PHYSICAL | DIGITAL
            executionModeText: executionModeText,
            executionModeIcon: executionModeIcon,

            // Tipo opcional
            taskType: params.entity === "0" ? "business" : "product",
            url_manager:params.url_manager,
            is_url:params.is_url,
            tracking_type_code_view:params.tracking_type_code_view,
            tracking_source_code_view:params.tracking_source_code_view
        };
var paramsLimitations={
    frequency_limit_type: params.frequency_limit_type,
    frequency_limit_value: params.frequency_limit_value,
    valid_from: params.valid_from,
    valid_until: params.valid_until
};
        // ✅ Labels (BS3)
        var statusLabel = task.isActive
            ? '<span class="label label-success pullkay__label-status not-view">ACTIVO</span>'
            : '<span class="label label-default pullkay__label-status not-view">INACTIVO</span>';

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
            '<span class="pullkay__reward-text">'+'  {{__('gamification.you_earn')}}'+'</span>' +
            '<span class="pullkay__reward-value">+' + (task.points != null ? task.points : 0) + '</span>' +
            '<span class="pullkay__reward-unit">Yapitas</span>' +
            '</div>';

        // ✅ CTA claro (sin esto el usuario duda)
        var ctaHtml = '';

        var urlCurrent = "#";
        var allowLink=false;
        if (task.is_url&&task.tracking_source_code_view  == "meetclick" && task.tracking_type_code_view== "click") {
            urlCurrent= task.url_manager;
            allowLink=true;
        }


        if (allowLink ) {

            ctaHtml = ['<a class="btn btn-xs pullkay__cta" href="' + (urlCurrent) + '">' +
            '  {{__('gamification.do_it_now')}}'+ ' <span class="pullkay__cta-arrow">→</span>' +
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
            buildLimitationsBadgesUI(paramsLimitations),
            '<div class="pullkay__top-row clearfix">',
            '<small class="text-muted pullkay__category not-view">' + (task.categoryText || "") + '</small>',
            '</div>',

            '<h4 class="media-heading pullkay__business not-view">',
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
