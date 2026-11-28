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

<script>
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
</script>
