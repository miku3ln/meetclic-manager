<!-- assets/v5/js/app/ui.stepsList.js -->
<script>
    /**
     * Steps List + Progress Bar (VERTICAL / COMPACT)
     * - Calcula gateIndex correctamente (primer step NO terminado)
     * - Progreso en COMPACT: DONE/total (PASSED o FAILED) => 100% cuando todos terminados
     * - Refresca barra/dots en vivo con evento: $(document).trigger("mc:progress:changed")
     * - Exporta: MC.uiStepsList.renderStepsList / refresh / refreshCompactUI
     */
    (function () {
        window.MC = window.MC || {};
        const { APP, ensureStepProgress, isStepDone, getGateIndex, canOpenStep } = MC.state;
        const { normStr } = MC.utils;

        let _lastOnSelectStep = null;
        let _lastOpts = null;

        function renderVertical(onSelectStep) {
            const $list = $("#mcStepsList").empty();

            if (!APP.data?.steps?.length) {
                $list.append(`<div class="mc-chip">No hay steps.</div>`);
                return;
            }

            const gateIndex = getGateIndex();

            APP.data.steps.forEach((s, idx) => {
                const prog = ensureStepProgress(s);
                const passed = prog.status === "PASSED";
                const failed = prog.status === "FAILED";
                const locked = !isStepDone(s) && idx !== gateIndex;
                const isActive = idx === APP.activeIndex;

                let stateLabel = "Bloq.";
                let stateClass = "is-bad";
                if (passed) { stateLabel = "OK"; stateClass = "is-ok"; }
                else if (failed) { stateLabel = "NO"; stateClass = "is-bad"; }
                else if (idx === gateIndex) { stateLabel = "Ahora"; stateClass = "is-next"; }

                const $row = $(`
        <div class="mc-step ${isActive ? "is-active" : ""} ${locked ? "is-locked" : ""}" data-index="${idx}">
          <div class="mc-step__left">
            <div class="mc-step__kicker">
              ${normStr(s.activity)} • ${normStr(s.step_id)} • intentos: ${prog.attempts}/${prog.attemptsMax}
            </div>
            <div class="mc-step__title">${normStr(s.title)}</div>
          </div>
          <div class="mc-step__right">
            <div class="mc-step__badge">${idx + 1}</div>
            <div class="mc-step__state ${stateClass}">${stateLabel}</div>
          </div>
        </div>
      `);

                $row.on("click", function () {
                    const index = Number($(this).data("index"));
                    if (!canOpenStep(index)) return;
                    onSelectStep(index);
                });

                $list.append($row);
            });
        }

        function renderCompact(onSelectStep, opts = {}) {
            const $host = $("#mcStepsList").empty();

            if (!APP.data?.steps?.length) {
                $host.append(`<div class="mc-chip">No hay steps.</div>`);
                return;
            }

            const steps = APP.data.steps;
            const total = steps.length;

            // DONE = PASSED o FAILED (según tu isStepDone)
            const doneCount = steps.filter(s => isStepDone(s)).length;
            const passedCount = steps.filter(s => ensureStepProgress(s).status === "PASSED").length;
            const pct = total ? Math.round((doneCount / total) * 100) : 0;

            // gateIndex robusto: primer step NO done; si todos done => -1
            const computeGateIndex = () => {
                for (let i = 0; i < total; i++) {
                    if (!isStepDone(steps[i])) return i;
                }
                return -1;
            };
            const gateIndex = computeGateIndex();

            const iconUrl = MC.CONFIG?.STEPS_LIST_ICON_URL || "";

            const $wrap = $(`
      <div class="mc-stepsbar">
        <div class="mc-stepsbar__icon">
          ${iconUrl ? `<img src="${iconUrl}" alt="steps" />` : `<div class="mc-stepsbar__iconFallback">★</div>`}
        </div>

        <div class="mc-stepsbar__track" role="list" aria-label="Progreso steps">
          <div class="mc-stepsbar__fill" style="width:${pct}%"></div>
          <div class="mc-stepsbar__dots"></div>
        </div>

        <div class="mc-stepsbar__meta">
          <span class="mc-stepsbar__pct">${pct}%</span>
        </div>
      </div>
    `);

            const $dots = $wrap.find(".mc-stepsbar__dots");

            $wrap.find(".mc-stepsbar__icon").off("click").on("click", function (e) {
                if(opts){
                    if (typeof opts.onIconClick === "function") {
                        opts.onIconClick({
                            event: e,
                            steps,
                            total,
                            gateIndex,
                            passedCount,
                            doneCount,
                            pct,
                            activeIndex: APP.activeIndex
                        });
                    } else {
                        $(document).trigger("mc:stepsbar:iconClick", [{
                            steps, total, gateIndex, passedCount, doneCount, pct, activeIndex: APP.activeIndex
                        }]);
                    }
                }

            });

            steps.forEach((s, idx) => {
                const prog = ensureStepProgress(s);
                const passed = prog.status === "PASSED";
                const failed = prog.status === "FAILED";
                const done = isStepDone(s);

                // lock: si hay gateIndex, bloquea los que no son gate y no están done
                // si gateIndex = -1, ya todo terminado => no bloquea por gate
                const locked = (gateIndex !== -1) ? (!done && idx !== gateIndex) : false;

                const isActive = idx === APP.activeIndex;
                const isGate = (gateIndex !== -1) && (idx === gateIndex);

                const $dot = $(`
        <button
          type="button"
          class="mc-stepsbar__dot
            ${passed ? "is-ok" : ""}
            ${failed ? "is-bad" : ""}
            ${isGate ? "is-next" : ""}
            ${isActive ? "is-active" : ""}
            ${locked ? "is-locked" : ""}"
          data-index="${idx}"
          title="${normStr(s.title)} • ${normStr(s.step_id)}"
          aria-label="Step ${idx + 1}: ${normStr(s.step_id)}"
        ></button>
      `);

                $dot.on("click", function () {
                    const index = Number($(this).data("index"));
                    if (!canOpenStep(index)) return;
                    onSelectStep(index);
                });

                $dots.append($dot);
            });

            $host.append($wrap);
        }

        // refresca SOLO la UI compact (sin reconstruir todo)
        function refreshCompactUI() {
            const $wrap = $("#mcStepsList .mc-stepsbar");
            if (!$wrap.length) return;

            const steps = APP.data?.steps || [];
            const total = steps.length;
            if (!total) return;

            const doneCount = steps.filter(s => isStepDone(s)).length;
            const pct = Math.round((doneCount / total) * 100);

            $wrap.find(".mc-stepsbar__fill").css("width", pct + "%");
            $wrap.find(".mc-stepsbar__pct").text(pct + "%");

            const gateIndex = (() => {
                for (let i = 0; i < total; i++) {
                    if (!isStepDone(steps[i])) return i;
                }
                return -1;
            })();

            $wrap.find(".mc-stepsbar__dot").each(function () {
                const idx = Number($(this).data("index"));
                const s = steps[idx];
                if (!s) return;

                const prog = ensureStepProgress(s);
                const passed = prog.status === "PASSED";
                const failed = prog.status === "FAILED";
                const done = isStepDone(s);

                const locked = (gateIndex !== -1) ? (!done && idx !== gateIndex) : false;
                const isActive = idx === APP.activeIndex;
                const isGate = (gateIndex !== -1) && (idx === gateIndex);

                $(this)
                    .toggleClass("is-ok", passed)
                    .toggleClass("is-bad", failed)
                    .toggleClass("is-locked", locked)
                    .toggleClass("is-active", isActive)
                    .toggleClass("is-next", isGate);
            });
        }

        // escucha evento global de cambio de progreso
        $(document).off("mc:progress:changed").on("mc:progress:changed", function () {
            const mode = (MC.CONFIG?.STEPS_LIST_MODE || "VERTICAL").toUpperCase();
            if (mode === "COMPACT") refreshCompactUI();
            else if (typeof _lastOnSelectStep === "function") renderVertical(_lastOnSelectStep);
        });

        function renderStepsList(onSelectStep, opts) {
            _lastOnSelectStep = onSelectStep || _lastOnSelectStep;
            _lastOpts = opts || _lastOpts;

            const mode = (MC.CONFIG?.STEPS_LIST_MODE || "VERTICAL").toUpperCase();
            if (mode === "COMPACT") return renderCompact(_lastOnSelectStep, _lastOpts);
            return renderVertical(_lastOnSelectStep, _lastOpts);
        }

        MC.uiStepsList = {
            renderStepsList,
            refresh: function () {
                renderStepsList(_lastOnSelectStep, _lastOpts);
                refreshCompactUI();
            },
            refreshCompactUI
        };
    })();
</script>
