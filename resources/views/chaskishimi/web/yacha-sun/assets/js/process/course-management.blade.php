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

        function buildWheel($root, options) {
            console.log("hola entro", options, $root);

            const cfg = $.extend(true, {
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
            $svg.toggleClass("is-pulsing", cfg.enabled && cfg.pulse);

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
                        description: s.description ?? ""
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
                        .attr("fill", s.color)
                        .attr("data-color", s.color)
                        .attr("data-hover", s.hover)
                        .attr("data-id", s.id)
                        .addClass("mc-wheel__sector mc-wheel__hit-gap")
                        .toggleClass("is-disabled", !s.enabled);

                    $path.on("mouseenter", function () {
                        if (!cfg.enabled || !s.enabled) return;
                        $(this).attr("fill", $(this).data("hover"));
                    });

                    $path.on("mouseleave", function () {
                        $(this).attr("fill", $(this).data("color"));
                    });

                    $path.on("click", function () {
                        if (!cfg.enabled || !s.enabled) return;
                        $root.find(".mc-wheel__sector").removeClass("is-active");
                        $(this).addClass("is-active");
                        cfg.onClick(s, i, cfg);
                    });

                    $g.append($path);
                });


                $root.data("mcWheelCfg", cfg);

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

    function findBlockByUnitAndSection(blocks, language_course_unit_id, language_course_unit_section_id) {
        const found = blocks.find(b =>
            b.language_course_unit_id === language_course_unit_id &&
            b.language_course_unit_section_id === language_course_unit_section_id
        );
        return found ?? null;
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
                    console.log(valueData);
                    var web_config = valueData.ui_ux.web_config;
                    var palettes = web_config.palettes;
                    var setData = {
                        id: valueData.id,
                        enabled: true,
                        color: palettes.main,
                        hover: palettes.hover,
                        item_kind: valueData.item_kind,
                        subtitle: valueData.subtitle,
                        weight: valueData.weight,
                        item: valueData
                    };
                    sectors.push(setData);
                });
                var web_config = valueSection.ui_ux.web_config;
                var palettes = web_config.palettes;

                var viewBox = web_config.svgConfig.viewBox;
                var setPushItems = {
                    id: valueSection.id,
                    section: valueSection,
                    enabled: true,
                    centerEnabled: true,
                    size: 100,
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
                    weight: valueSection.weight
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
                key: value.id, title: value.value, kichwa: value.subtitle, enabled: true,
                background: background,
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
                $stack.append(`
        <div class="mc-wheel" id="${wheel.id}">
          <svg class="mc-wheel__svg" id="mc-wheel__svg-${wheel.id}"><g class="mc-wheel__sectors"></g></svg>
          <div class="mc-wheel__center">
            <img class="mc-wheel__center-img" alt="icon"/>
          </div>
        </div>
      `);

                const finalWheelEnabled = section.enabled && wheel.enabled;

                $("#" + wheel.id).mcWheel({
                    section: wheel.section,
                    id: wheel.id,
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
                        console.log("adad", this);
                        var dataSection = this;
                        var section = dataSection["section"];
                        var language_course_unit_id = section.language_course_unit_id;
                        var language_course_unit_section_id = section.id;
                        var $blocks = $dataManagerPage.exercisePayload["blocks"];
                        var resultBlock = findBlockByUnitAndSection($blocks, language_course_unit_id, language_course_unit_section_id);

                        console.log("resultBlock", resultBlock);
                        if (resultBlock) {
                            function modalTemplate() {
                                return `
      <div class="modal-header">
   <div class="mc-steps" id="mcStepsList"></div>
        <h5 class="modal-title">Prueba de Conocimiento</h5>

        <button class="btn-close not-view" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-0">
        <div id="stepsHost" class="p-3">Cargando…</div>
      </div>
    `;
                            }

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


                                        // helper: layout de tu app dentro del modal
                                        function mountStepsLayout() {
                                            const host = document.getElementById("stepsHost");
                                            if (!host) return;

                                            host.innerHTML = `
      <main class="mc-panel">

        <div class="mc-panel__head">
          <div class="management-information">
            <h2> Resuelve los ejercicios :</h2>
            <div class="mc-panel__hint">
              Presiona <strong>“Verificar”</strong>.
              ✅ Correcto: PASSED y avanza.
              ❌ Incorrecto: suma intento. A los 3 intentos: FAILED y avanza.
            </div>
          </div>
          <div class="mc-chip mc-chip--info" id="mcChipActive">Step: —</div>
        </div>
        <div class="mc-panel__body">
          <div class="mc-ex" id="mcExerciseRoot">
            <div class="mc-chip">Cargando…</div>
          </div>

        </div>
      </main>
    `;
                                        }

                                        // 1) inyecta UI
                                        mountStepsLayout();

                                        // 2) carga data directa (sin botones)

                                        var jsonCurrent = SAMPLE_JSON;
                                        if (resultBlock) {
                                            jsonCurrent.steps = resultBlock.steps;
                                            bootstrapFromJSON(jsonCurrent);
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
                                    }
                                });

                        } else {
                            mcToastShow({
                                type: "warning",
                                icon: "⚠️ ",
                                title: "No existe un Test en esta Seccion.!",
                                msg: "No se ha configurado un test para esta seccion."
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
</script>
