<script>
    function adjustment() {
        var contenedorAncho = document.getElementById("app-management").offsetWidth; // Obtener el ancho del contenedor
        var nuevoAncho = contenedorAncho * 0.96; // Reducir el ancho al 96% del ancho del contenedor
        var nuevoAlto = (nuevoAncho / 1840) * 750; // Calcular el nuevo alto manteniendo la proporción original

        // Asignar los nuevos valores de ancho y alto al elemento SVG
        document.getElementById("svg-full-width").setAttribute("width", nuevoAncho);
        document.getElementById("svg-full-width").setAttribute("height", nuevoAlto);
    }

    function placeCenterByViewBox(wheelId, viewBoxStr) {
        // viewBoxStr: "-90 -110 220 220"
        const [minX, minY, w, h] = viewBoxStr.split(/\s+/).map(Number);

        const leftPct = ((0 - minX) / w) * 100;
        const topPct = ((0 - minY) / h) * 100;

        const $wheel = $("#" + wheelId);
        $wheel.find(".mc-wheel__center").css({
            left: leftPct + "%",
            // top:  topPct + "%"
        });
    }
    function activateSector(sectorId, active = true) {

        const $sector = $("#sector-" + sectorId);
        if (!$sector.length) return;

        if (active) {
            $sector.addClass("is-active");

            // usar hover como estado activo
            $sector.attr("fill", $sector.data("hover"));

        } else {
            $sector.removeClass("is-active");

            // volver al color base
            $sector.attr("fill", $sector.data("color"));
        }
    }
    (function ($) {
        function polarToCartesian(r, angleDeg) {
            const a = (angleDeg - 90) * Math.PI / 180;
            return {x: r * Math.cos(a), y: r * Math.sin(a)};
        }

        function describeSectorPath(rOuter, rInner, startAngle, endAngle) {
            const p1 = polarToCartesian(rOuter, endAngle);
            const p2 = polarToCartesian(rOuter, startAngle);
            const p3 = polarToCartesian(rInner, startAngle);
            const p4 = polarToCartesian(rInner, endAngle);
            const largeArc = (endAngle - startAngle) <= 180 ? "0" : "1";

            return [
                `M ${p1.x} ${p1.y}`,
                `A ${rOuter} ${rOuter} 0 ${largeArc} 0 ${p2.x} ${p2.y}`,
                `L ${p3.x} ${p3.y}`,
                `A ${rInner} ${rInner} 0 ${largeArc} 1 ${p4.x} ${p4.y}`,
                "Z"
            ].join(" ");
        }

        function clampParts(n) {
            return Math.max(2, Math.min(6, n));
        }

        function setWheelEnabled($root, enabled) {
            $root.toggleClass("is-disabled", !enabled);
            $root.attr("aria-disabled", enabled ? "false" : "true");
            if (!enabled) $root.find(".mc-wheel__svg").removeClass("is-pulsing");
        }

        function setCenterEnabled($root, enabled) {
            $root.find(".mc-wheel__center-img").toggleClass("is-disabled", !enabled);
        }

        function generateSector(params) {
            var {cfg, options,$root} = params;

            cfg.parts = clampParts(options.parts);
            const rInner = Math.max(5, cfg.rOuter - cfg.ringThickness);
            const sectors = [];
            for (let i = 0; i < cfg.parts; i++) {
                const s = cfg.sectors[i] || {};
                sectors.push({
                    item: s.item,
                    id: s.id ?? `p${i + 1}`,
                    color: s.color ?? "#EAF0FF",
                    hover: s.hover ?? "#D7E2FF",
                    enabled: (s.enabled !== undefined) ? !!s.enabled : true,
                    title: s.title ?? `Sector ${i + 1}`,
                    subtitle: s.subtitle ?? "",
                    description: s.description ?? "",
                    activeFill: s.activeFill ?? (cfg.activeFill ?? "#BFD1FF"),
                    activeStroke: s.activeStroke ?? (cfg.activeStroke ?? "#4C4CFF"),
                    activeStrokeWidth: (s.activeStrokeWidth ?? cfg.activeStrokeWidth ?? 0),


                });
            }

            const $g = $root.find(".mc-wheel__sectors").empty();
            const step = 360 / cfg.parts;
            sectors.forEach((s, i) => {
                const start = cfg.startOffsetDeg + (i * step);
                const end = cfg.startOffsetDeg + ((i + 1) * step);
                const d = describeSectorPath(cfg.rOuter, rInner, start, end);

                const $path = $(document.createElementNS("http://www.w3.org/2000/svg", "path"))
                    .attr("d", d)
                    .attr("id", "sector-" + s.id)
                    .attr("fill", s.color)
                    .attr("data-color", s.color)
                    .attr("data-hover", s.hover)
                    .attr("data-id", s.id)
                    .addClass("mc-wheel__sector mc-wheel__hit-gap")
                    .toggleClass("is-disabled", !s.enabled)
                    //active
                    .attr("data-active-fill", s.activeFill)
                    .attr("data-active-stroke", s.activeStroke)
                    .attr("data-active-stroke-width", s.activeStrokeWidth)

                ;

                $path.on("mouseenter", function () {
                    if (!cfg.enabled || !s.enabled) return;
                    $(this).attr("fill", $(this).data("hover"));
                });

                $path.on("mouseleave", function () {
                    const $t = $(this);
                    if ($t.hasClass("is-active")) {
                        // mantiene el hover como activo
                        $t.attr("fill", $t.data("hover"));
                    } else {
                        $t.attr("fill", $t.data("color"));
                    }
                });

                $path.on("click", function () {
                    if (!cfg.enabled || !s.enabled) return;
                    $root.find(".mc-wheel__sector").removeClass("is-active");
                    $(this).addClass("is-active");
                    cfg.onClick(s, i, cfg);
                });

                $g.append($path);
            });

            return cfg;


        }

        function buildWheel($root, options) {

            const cfg = $.extend(true, {
                lvl_one: options.lvl_one,
                lvl_one_id: options.lvl_one_id,
                lvl_two: options.lvl_two,
                lvl_two_id: options.lvl_two_id,
                enabled: options.enabled,
                pulse: true,
                pulseMs: 1200,
                centerEnabled: options.centerEnabled,
                centerImageUrl: options.centerImageUrl,
                size: options.size,
                parts: options.parts,
                rOuter: 80,
                ringThickness: options.ringThickness,
                startOffsetDeg: 0,
                centerSize: 48,
                centerImgSize: 34,
                sectors: [],
                section: options.section,
                onClick: function () {
                },
                onCenterClick: function () {
                }
            }, options || {});
            const el = $root.get(0);
// si hay soporte de CSS variables
            if (window.CSS && CSS.supports && CSS.supports("color", "var(--x)")) {
                el.style.setProperty("--mc-wheel-size", cfg.size + "px");
                el.style.setProperty("--mc-center-size", cfg.centerSize + "px");
                el.style.setProperty("--mc-center-img-size", cfg.centerImgSize + "px");
            } else {
                // fallback directo
                $root.css({width: cfg.size + "px", height: cfg.size + "px"});
                $root.find(".mc-wheel__center").css({
                    width: cfg.centerSize + "px",
                    height: cfg.centerSize + "px"
                });
                $root.find(".mc-wheel__center-img").css({
                    width: cfg.centerImgSize + "px",
                    height: cfg.centerImgSize + "px"
                });
            }

            var svgConfig = options.svgConfig;
            const $svg = $root.find(".mc-wheel__svg");
            $svg.attr("viewBox", svgConfig.viewBox);
            placeCenterByViewBox(options.id, svgConfig.viewBox)
            setWheelEnabled($root, cfg.enabled);
           // $svg.toggleClass("is-pulsing", cfg.enabled && cfg.pulse);

            if (cfg.centerImageUrl) $root.find(".mc-wheel__center-img").attr("src", cfg.centerImageUrl);
            setCenterEnabled($root, cfg.centerEnabled);
            $root.find(".mc-wheel__center")
                .off("click.mcWheelCenter")
                .on("click.mcWheelCenter", function () {
                    if (!cfg.enabled) return;
                    if (!cfg.centerEnabled) return;
                    cfg.onCenterClick(cfg);
                });
            if (cfg.parts > 0) {


                $root.data("mcWheelCfg",  generateSector({cfg: cfg,options:options,$root:$root}));
            }
        }

        $.fn.mcWheel = function (options) {
            return this.each(function () {
                buildWheel($(this), options);
            });
        };
    })(jQuery);

    /* ====== DATA ====== */
    const ICONS = {
        viento: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4a8.svg",
        agua: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4a7.svg",
        tierra: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1faa8.svg",
        fuego: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f525.svg"
    };

    const PALETTES = {
        viento: {a: "#DDF1FF", b: "#CBEAFF", h: "#BFE4FF"},
        agua: {a: "#1EA1E6", b: "#5BC0F3", h: "#0D8DD2"},
        tierra: {a: "#E6C27A", b: "#D9A94E", h: "#C99433"},
        fuego: {a: "#D9D9D9", b: "#BDBDBD", h: "#AFAFAF", hot: "#E53935"}
    };


    var ELEMENTS_DATA = [];

    //TODO DATA TEST
    function findBlockByUnitAndSection(params) {
        var {blocks, lvl_one_id, lvl_two_id, lvl_three_id} = params;

        var dataUnitGroup = findBlockByLevelOneGroupByTwo(params);

        var result = [];
        $.each(dataUnitGroup, function (key, value) {
            if (value.unit_lvl_two_id == lvl_two_id) {
                $.each(value.steps, function (keySteps, valueStep) {
                    if (valueStep["unit_lvl_three_id"] == lvl_three_id) {
                        result.push(valueStep);
                    }
                });
            }


        });

        return result;
    }

    function findBlockByLevelOneGroupByTwo(params) {
        var blocks = params.blocks || [];
        var lvl_one_id = params.lvl_one_id;
        var grouped = {};

        $.each(blocks, function (_, block) {
            if (block.unit_lvl_one_id !== lvl_one_id) return;

            $.each(block.steps || [], function (_, step) {
                var lvl2 = step.unit_lvl_two_id;
                if (lvl2 == null) return;

                if (!grouped[lvl2]) {
                    grouped[lvl2] = {
                        unit_lvl_one_id: lvl_one_id,
                        unit_lvl_one: step.unit_lvl_one || block.unit_lvl_one || null,
                        unit_lvl_two_id: lvl2,
                        unit_lvl_two: step.unit_lvl_two || null,
                        steps: []
                    };
                }

                grouped[lvl2].steps.push(step);
            });
        });

        return grouped;
    }

    function render() {
        const $app = $("#app").empty();
        var haystack = $dataManagerPage.languageCoursePayload.data;
        $.each(haystack.units, function (key, value) {
            var items = [];
            $.each(value.sections, function (keySection, valueSection) {
                var sectors = [];
                var parts = valueSection.items.length;
                $.each(valueSection.items, function (keyData, valueData) {

                    var web_config = valueData.ui_ux.web_config;
                    var palettes = web_config.palettes;
                    var item = valueData;
                    item = {
                        ...item, lvl_three_id: valueData.id,
                        lvl_three: valueData.title,
                    };
                    var setData = {
                        id: valueData.id,
                        enabled: true,
                        color: palettes.main,
                        hover: palettes.hover,
                        activeFill: "#BFD1FF",
                        activeStroke: "#4C4CFF",
                        activeStrokeWidth: 0,
                        rememberActive: true,
                        autoActiveFirstEnabled: false,
                        item_kind: valueData.item_kind,
                        subtitle: valueData.subtitle,
                        weight: valueData.weight,
                        item: item,
                        state: "IN_PROCESS",
                        keyId: keyData,
                        lvl_three_id: valueData.id,
                        lvl_three: valueData.title,
                        lvl_one_id: value.id,
                        lvl_one: value.value,
                        lvl_two_id: valueSection.id,
                        lvl_two: valueSection.title,
                    };
                    sectors.push(setData);
                });
                var web_config = valueSection.ui_ux.web_config;
                var palettes = web_config.palettes;
                var viewBox = web_config.svgConfig.viewBox;
                var sectionCurrent = valueSection;


                sectionCurrent = {
                    ...sectionCurrent,
                    lvl_two_id: sectionCurrent.id,
                    lvl_two: sectionCurrent.title,
                    lvl_one_id: value.id,
                    lvl_one: value.value,

                };
                var setPushItems = {

                    id: valueSection.id,
                    section: sectionCurrent,
                    enabled: true,
                    state: "IN_PROCESS",
                    centerEnabled: true,
                    size: 90,
                    parts: parts,
                    rOuter: 80,
                    ringThickness: 25,
                    svgConfig: {
                        viewBox: viewBox
                    },
                    centerImageUrl: web_config.icon.url_source,
                    sectors: sectors,
                    subtitle: valueSection.subtitle,
                    title: valueSection.title,
                    weight: valueSection.weight,
                    keyId: keySection,
                    lvl_two_id: valueSection.id,
                    lvl_two: valueSection.title,
                    lvl_one_id: value.id,
                    lvl_one: value.value,
                };

                items.push(setPushItems);
            });
            var background = null;
            if (value.id == 1) {
                background = $resources.wayra;
            } else if (value.id == 2) {
                background = $resources.yaku;
            } else if (value.id == 3) {
                background = $resources.allpa;
            } else if (value.id == 4) {
                background = $resources.nina;
            }
            var setPush = {
                lvl_one_id: value.id,
                lvl_one: value.value,
                key: value.id,
                title: value.value,
                kichwa: value.subtitle,
                enabled: true,
                background: background,
                state: "IN_PROCESS",
                keyId: key,
                items: items.sort(function (a, b) {
                    return (parseInt(b.weight, 10) || 0) - (parseInt(a.weight, 10) || 0);
                })
            };
            ELEMENTS_DATA.push(setPush);
        });
        // usa el que venga, fallback

        ELEMENTS_DATA.forEach(section => {
            const bannerUrl = section.background;
            const $col = $(`
      <div id="section-${section.key}" class="mc-element" data-key="${section.key}" style="--mc-banner: url('${bannerUrl}');" >

        <div class="mc-element__head">
          <h2 class="mc-element__title">${section.title}</h2>
          <div class="mc-element__subtitle">${section.kichwa}</div>
        </div>
        <div class="mc-element__stack" id="stack_${section.key}"></div>
      </div>
    `);

            $app.append($col);
            const $stack = $col.find("#stack_" + section.key);

            section.items.forEach(wheel => {
                var sectionCurrent = wheel.section;
                var configuracion_ui_ux_id = sectionCurrent.configuracion_ui_ux_id;
                var classImage = "mc-wheel__center-img" + (sectionCurrent.section_type == "FINAL_EXAM" ? " mc-wheel__center-img--exam" : "");
                var classContentImage = "mc-wheel__center" + (sectionCurrent.section_type == "FINAL_EXAM" ? " mc-wheel__center--exam" : "");

                $stack.append(`
        <div class="mc-wheel" id="${wheel.id}" ui_ux_id="${configuracion_ui_ux_id}">
          <svg class="mc-wheel__svg" id="mc-wheel__svg-${wheel.id}"><g class="mc-wheel__sectors"></g></svg>
          <div class="${classContentImage}">
            <img class="${classImage}" alt="icon"/>
          </div>
        </div>
      `);

                const finalWheelEnabled = section.enabled && wheel.enabled;

                $("#" + wheel.id).mcWheel({
                    state: wheel.state,
                    keyId: wheel.keyId,
                    section: wheel.section,
                    id: wheel.id,
                    lvl_one: section.lvl_one,
                    lvl_one_id: section.lvl_one_id,
                    lvl_two: wheel.lvl_two,
                    lvl_two_id: wheel.lvl_two_id,
                    enabled: finalWheelEnabled,
                    centerEnabled: finalWheelEnabled && wheel.centerEnabled,
                    size: wheel.size,
                    parts: wheel.parts,
                    rOuter: wheel.rOuter,
                    ringThickness: wheel.ringThickness,
                    startOffsetDeg: wheel.startOffsetDeg,
                    centerImageUrl: wheel.centerImageUrl,
                    centerSize: wheel.centerSize,
                    centerImgSize: wheel.centerImgSize,
                    pulse: (wheel.pulse),
                    pulseMs: wheel.pulseMs,
                    sectors: wheel.sectors,
                    svgConfig: wheel.svgConfig,
                    onClick: function (sector, idx) {
                        // alert(`section=${section.key} wheel=${wheel.id} sector=${sector.id} idx=${idx}`);
                    },
                    onCenterClick: function () {
                        var messageData = {
                            title: "", description: ""
                        };
                        var dataSection = this;
                        var sectors = dataSection.sectors;
                        var section = dataSection.section;
                        console.log("dataSectors", sectors);
                        var allowProcess = sectors.length > 0;
                        console.log("dataSection", section);

                        function getDataInitLvls(itemsSet) {
                            unit_lvl_three_id = itemsSet[0].id;
                            return unit_lvl_three_id;
                        }

                        if (allowProcess) {
                            var lvl_one_id = section.lvl_one_id;
                            var lvl_one = section.lvl_one;
                            var lvl_two_id = section.lvl_two_id;
                            var lvl_two = section.lvl_two;

                            console.log("lvl_two", lvl_two, lvl_two_id);
                            console.log("lvl_one", lvl_one, lvl_one_id);
                            var $blocks = $exercisesData;
                            const unitId = lvl_one_id;
                            var itemsCurrent = section.items;
                            var itemsSet = [];
                            $.each(itemsCurrent, function (key, value) {
                                var setPush = value;
                                setPush = {...setPush, complete: false};
                                itemsSet.push(setPush);
                            });
                            var unit_lvl_three_id = -1;
                            var allowTestUnit = false;

                            if (CourseStore.hasUnit(unitId)) {
                                if (CourseStore.hasLvl2(unitId, lvl_two_id)) {
                                    const lvl2 = CourseStore.getLvl2(unitId, lvl_two_id, null);
                                    const sectors = lvl2 ? (lvl2.sectors || []) : [];
                                    var itemsCurrentUnit = sectors;
                                    var unit_lvl_data = null;
                                    var count = 0;
                                    $.each(itemsCurrentUnit, function (key, value) {
                                        if (value["complete"] == false && count == 0) {
                                            unit_lvl_data = value;
                                            count++;
                                        }
                                    });
                                    if (unit_lvl_data) {
                                        allowTestUnit = true;
                                        unit_lvl_three_id = unit_lvl_data.id;
                                    } else {
                                        allowTestUnit = false;
                                        messageData.title = "Advertencia!";
                                        messageData.description = "Todas las pruebas de esta secciòn estan realizadas.";

                                    }

                                    //CourseStore.updateLvl2(unitId, lvl_two_id, {sectors: itemsSet, complete: false});
                                } else {
                                    allowTestUnit = true;
                                    CourseStore.ensureLvl2(unitId, lvl_two_id);
                                    CourseStore.updateLvl2(unitId, lvl_two_id, {sectors: itemsSet, complete: false});
                                    unit_lvl_three_id = getDataInitLvls(itemsSet);

                                }
                            } else {
                                CourseStore.addUnit(unitId, {
                                    sectors: itemsSet,
                                    complete: false,
                                    lvl_two_id: lvl_two_id
                                });
                                if (itemsSet.length > 0) {
                                    unit_lvl_three_id = getDataInitLvls(itemsSet);
                                }
                                allowTestUnit = true;
                            }

                            if (allowTestUnit) {
                                var paramsSearch = {
                                    blocks: $blocks,
                                    lvl_one_id: lvl_one_id,
                                    lvl_two_id: lvl_two_id,
                                    lvl_three_id: unit_lvl_three_id
                                };

                                var resultBlock = findBlockByUnitAndSection(paramsSearch);
                                console.log(paramsSearch, resultBlock);
                                if (resultBlock.length) {
                                    MC.state.resetProgress();
                                    configModal.configuration =
                                        openDynamicModal({
                                            id: "dynamicModal", // 👈 importante si tu openDynamicModal soporta id
                                            fullscreen: true,
                                            options: {backdrop: "static", keyboard: false},
                                            template: modalTemplate,
                                            // OJO: mejor usar show.bs.modal para inyectar el HTML (antes del shown)
                                            onShow: () => {
                                                // no obligatorio, pero recomendado
                                                MC.state.resetProgress();
                                            },
                                            onShown: () => {
                                                viewManagerScroll({"selector": "html.js.csstransitions", allow: false});

                                                function mountStepsLayout() {
                                                    const host = document.getElementById("stepsHost");
                                                    if (!host) return;
                                                    host.innerHTML = initProcessTestForm({resultBlock: resultBlock})

                                                }

                                                mountStepsLayout();
                                                // 2) carga data directa (sin botones)
                                                var jsonCurrent = SAMPLE_JSON;
                                                if (resultBlock) {
                                                    var managementUnitSection = {
                                                        lvl_one_id: lvl_one_id,
                                                        lvl_two_id: lvl_two_id,
                                                        lvl_three_id: unit_lvl_three_id
                                                    };
                                                    jsonCurrent["management-unit"] = managementUnitSection;
                                                    SAMPLE_JSON["management-unit"] = managementUnitSection;
                                                    jsonCurrent.steps = resultBlock;
                                                    $dataSetConfig = jsonCurrent;
                                                }

                                            },

                                            onHide: (ctx, ev) => {
                                                const saving = ctx.modalEl.dataset.saving === "1";
                                                if (saving) ev.preventDefault();
                                            },

                                            onHidePrevented: () => {
                                                console.log("Intentó cerrar, pero está bloqueado");
                                            },

                                            onHidden: () => {
                                                // opcional: limpiar UI (progreso queda en localStorage igual)
                                                const host = document.getElementById("stepsHost");
                                                if (host) host.innerHTML = "—";
                                                console.log("Cerrado: cleanup listo");
                                                viewManagerScroll({"selector": "html.js.csstransitions", allow: true});

                                            }
                                        });
                                } else {
                                    mcToastShow({
                                        type: "warning",
                                        icon: "⚠️ ",
                                        title: "Advertencia!",
                                        msg: "No existen tests para este para este proceso.!"
                                    });
                                }
                            } else {
                                mcToastShow({
                                    type: "warning",
                                    icon: "⚠️ ",
                                    title: messageData.title,
                                    msg: messageData.description
                                });
                            }

                        } else {
                            mcToastShow({
                                type: "warning",
                                icon: "⚠️ ",
                                title: "Advertencia!",
                                msg: "No existen tests para este modulo.!"
                            });
                        }

                    }
                });
            });
        });

        initStickyFromElementsData();
    }

    function initStickyFromElementsData() {
        MCStickyHeader.destroy();
        MCStickyHeader.setConfig(MC_STICKY_CONFIG);

        // si tu scroll es window:
        MCStickyHeader.init();
    }

    var $exercisesData = $dataManagerPage.exercisePayload["blocks"];

    function initCourseData() {
        var $blocks = $exercisesData;
        $.each($blocks, function (key, value) {
            $blocks[key]["complete"] = false;

        });

        $exercisesData = $blocks;
    }

    $(function () {
        initCourseData();
    });
</script>
