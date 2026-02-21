<script>

    function updateManagerItemSectionTest(params) {
        const APP_GLOBAL = MC.state.APP;
        const data = APP_GLOBAL.data;
        console.log("DATA COMPLETA:", data);
        var managementUnit = data["management-unit"];
        var {lvl_one_id, lvl_three_id, lvl_two_id} = managementUnit;
        var sector = CourseStore.getSector(lvl_one_id, lvl_two_id, lvl_three_id);
        console.log("sector antes de", sector);
        CourseStore.updateSector(lvl_one_id, lvl_two_id, lvl_three_id, {complete: true});
        sector = CourseStore.getSector(lvl_one_id, lvl_two_id, lvl_three_id);
        console.log("sector despues de", sector);
        console.log("lvl_one_id", lvl_one_id);
        console.log("lvl_three_id", lvl_three_id);
        console.log("lvl_two_id", lvl_two_id);

        console.log("STEPS:", data.steps);

        activateSector(lvl_three_id)
        configModal.configuration.instance.hide();
    }

    function getDataAnswers() {
        var APP = MC.state.APP;
        var results = APP.data.steps.map(step => {
            const progress = MC.state.ensureStepProgress(step);
            return {
                step: step,
                progress:progress,
                stepId: step.step_id,
                status: progress.status,
                attempts: progress.attempts,
                answer: progress.lastAnswer,
                result: progress.lastResult
            };
        });
        return results;
    }

    function initProcessTestForm(params) {
        var resultBlock=params["resultBlock"];
        return `
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
${initIntroLesson({numberLesson: resultBlock.length})}
          <div class="mc-ex not-view" id="mcExerciseRoot">
            <div class="mc-chip">Cargando…</div>
          </div>

        </div>
      </main>
    `;

    }

    /**
     * CourseStorePlugin — simple:
     * - Si NO existe unit => crea unit
     * - Si NO existe lvl2 dentro de unit => crea lvl2
     * - Si existe => actualiza (solo merge) y listo
     *
     * Uso:
     * CourseStore.addUnit(unitId, {sectors: itemsSet, complete:false, lvl_two_id:lvl_two_id});
     */
    (function (global) {
        "use strict";

        const LS = {
            get(key, fallback = null) {
                try {
                    const raw = global.localStorage.getItem(key);
                    return raw === null ? fallback : JSON.parse(raw);
                } catch (_) {
                    return fallback;
                }
            },
            set(key, value) {
                global.localStorage.setItem(key, JSON.stringify(value));
                return value;
            },
            del(key) {
                global.localStorage.removeItem(key);
            }
        };

        const Obj = {
            has(o, k) { return Object.prototype.hasOwnProperty.call(o, k); },
            isPlainObject(v) { return v !== null && typeof v === "object" && !Array.isArray(v); }
        };

        const CourseStore = {
            KEY: "mc_course",
            removeUnit(unitId) {
                const store = this.all();
                const k = String(unitId);
                if (!this.hasUnit(unitId)) return false;
                delete store.courseTest[k];
                this.save(store);
                return true;
            },

            removeLvl2(unitId, lvl_two_id) {
                const store = this.all();
                const unitKey = String(unitId);
                const lvl2Key = String(lvl_two_id);

                if (!this.hasUnit(unitId)) return false;
                if (!this.hasLvl2(unitId, lvl_two_id)) return false;

                delete store.courseTest[unitKey].lvl_two[lvl2Key];
                this.save(store);
                return true;
            },
            init() {
                const base = LS.get(this.KEY, null);
                if (!Obj.isPlainObject(base)) return LS.set(this.KEY, { courseTest: {} });

                if (!Obj.isPlainObject(base.courseTest)) {
                    base.courseTest = {};
                    return LS.set(this.KEY, base);
                }

                return base;
            },

            all() { return this.init(); },
            save(store) { return LS.set(this.KEY, store); },

            // -------------------------
            // ✅ PREGUNTAR
            // -------------------------
            hasUnit(unitId) {
                const store = this.all();
                return Obj.has(store.courseTest, String(unitId));
            },

            hasLvl2(unitId, lvl_two_id) {
                const unit = this.getUnit(unitId, null);
                if (!Obj.isPlainObject(unit) || !Obj.isPlainObject(unit.lvl_two)) return false;
                return Obj.has(unit.lvl_two, String(lvl_two_id));
            },

            // -------------------------
            // GET
            // -------------------------
            getUnit(unitId, fallback = null) {
                const store = this.all();
                return store.courseTest[String(unitId)] ?? fallback;
            },

            getLvl2(unitId, lvl_two_id, fallback = null) {
                const unit = this.getUnit(unitId, null);
                return unit?.lvl_two?.[String(lvl_two_id)] ?? fallback;
            },

            // -------------------------
            // ✅ CREAR (si no existe)
            // -------------------------
            ensureUnit(unitId) {
                const store = this.all();
                const k = String(unitId);

                if (!Obj.isPlainObject(store.courseTest[k])) {
                    store.courseTest[k] = { id: Number(unitId), lvl_two: {} };
                } else {
                    store.courseTest[k].id = Number(unitId);
                    if (!Obj.isPlainObject(store.courseTest[k].lvl_two)) store.courseTest[k].lvl_two = {};
                }

                this.save(store);
                return store.courseTest[k];
            },

            ensureLvl2(unitId, lvl_two_id) {
                const store = this.all();
                const unitKey = String(unitId);
                const lvl2Key = String(lvl_two_id);

                this.ensureUnit(unitId);

                const unit = store.courseTest[unitKey];
                if (!Obj.isPlainObject(unit.lvl_two)) unit.lvl_two = {};

                if (!Obj.isPlainObject(unit.lvl_two[lvl2Key])) {
                    unit.lvl_two[lvl2Key] = { lvl_two_id: Number(lvl_two_id), sectors: [], complete: false };
                } else {
                    unit.lvl_two[lvl2Key].lvl_two_id = Number(lvl_two_id);
                    if (!Array.isArray(unit.lvl_two[lvl2Key].sectors)) unit.lvl_two[lvl2Key].sectors = [];
                    if (typeof unit.lvl_two[lvl2Key].complete !== "boolean") unit.lvl_two[lvl2Key].complete = false;
                }

                this.save(store);
                return unit.lvl_two[lvl2Key];
            },

            // -------------------------
            // ✅ ACTUALIZAR (solo si existe)
            // -------------------------
            updateLvl2(unitId, lvl_two_id, patch = {}) {
                const store = this.all();
                const unitKey = String(unitId);
                const lvl2Key = String(lvl_two_id);

                if (!this.hasUnit(unitId)) return null;
                if (!this.hasLvl2(unitId, lvl_two_id)) return null;

                const unit = store.courseTest[unitKey];
                const prev = unit.lvl_two[lvl2Key];

                unit.lvl_two[lvl2Key] = { ...prev, ...(patch || {}), lvl_two_id: Number(lvl_two_id) };

                // normaliza sectors/complete
                if ("sectors" in (patch || {}) && !Array.isArray(unit.lvl_two[lvl2Key].sectors)) {
                    unit.lvl_two[lvl2Key].sectors = [];
                }
                if (!Array.isArray(unit.lvl_two[lvl2Key].sectors)) unit.lvl_two[lvl2Key].sectors = [];

                if ("complete" in (patch || {}) && typeof unit.lvl_two[lvl2Key].complete !== "boolean") {
                    unit.lvl_two[lvl2Key].complete = Boolean(patch.complete);
                }
                if (typeof unit.lvl_two[lvl2Key].complete !== "boolean") unit.lvl_two[lvl2Key].complete = false;

                this.save(store);
                return unit.lvl_two[lvl2Key];
            },
            updateSector(unitId, lvl_two_id, sectorId, patch = {}) {
                const store = this.all();
                const unitKey = String(unitId);
                const lvl2Key = String(lvl_two_id);

                if (!this.hasUnit(unitId)) return null;
                if (!this.hasLvl2(unitId, lvl_two_id)) return null;

                const unit = store.courseTest[unitKey];
                const lvl2 = unit.lvl_two[lvl2Key];

                if (!lvl2 || !Array.isArray(lvl2.sectors)) return null;

                const idx = lvl2.sectors.findIndex(s => String(s.id) === String(sectorId));
                if (idx === -1) return null;

                lvl2.sectors[idx] = { ...lvl2.sectors[idx], ...(patch || {}) };

                this.save(store);
                return lvl2.sectors[idx];
            },
            getLvl2Data(unitId, lvl_two_id, fallback = null) {
                const store = this.all();
                const unitKey = String(unitId);
                const lvl2Key = String(lvl_two_id);

                const unit = store.courseTest[unitKey];
                if (!unit || !unit.lvl_two) return fallback;

                return unit.lvl_two[lvl2Key] ?? fallback;
            },
            clearAndInit() {
                LS.del(this.KEY);
                return this.init();
            },
            getSector(unitId, lvl_two_id, sectorId, fallback = null) {
                const unit = this.getUnit(unitId, null);
                if (!unit || !unit.lvl_two) return fallback;

                const lvl2 = unit.lvl_two[String(lvl_two_id)];
                if (!lvl2 || !Array.isArray(lvl2.sectors)) return fallback;

                return lvl2.sectors.find(s => String(s.id) === String(sectorId)) ?? fallback;
            },
            // -------------------------
            // ✅ UPSERT SIMPLE (tu llamada)
            // crea si no existe / actualiza si existe
            // -------------------------
            addUnit(unitId, data = {}) {
                const lvl_two_id = data?.lvl_two_id;
                if (lvl_two_id == null) throw new Error("CourseStore.addUnit: falta data.lvl_two_id");

                const unitKey = String(unitId);
                const lvl2Key = String(lvl_two_id);

                // 1) asegurar que existan
                this.ensureUnit(unitId);
                this.ensureLvl2(unitId, lvl_two_id);

                // 2) 🔥 volver a leer el store ya actualizado
                const store = this.all();
                const unit = store.courseTest[unitKey];

                // seguridad extra
                if (!unit || !unit.lvl_two) throw new Error("CourseStore.addUnit: unit o lvl_two no existe después de ensure");

                const prev = unit.lvl_two[lvl2Key] || { lvl_two_id: Number(lvl_two_id), sectors: [], complete: false };

                const next = { ...prev, ...data, lvl_two_id: Number(lvl_two_id) };

                // normaliza sectors/complete
                if ("sectors" in (data || {}) && !Array.isArray(next.sectors)) next.sectors = [];
                if (!Array.isArray(next.sectors)) next.sectors = [];

                if ("complete" in (data || {}) && typeof next.complete !== "boolean") next.complete = Boolean(data.complete);
                if (typeof next.complete !== "boolean") next.complete = false;

                unit.lvl_two[lvl2Key] = next;

                // 3) guardar el store modificado
                this.save(store);

                return next;
            }
        };

        global.CourseStore = CourseStore;
    })(window);


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

    function initIntroLesson(params) {
        var numberLesson = params["numberLesson"];
        return ` <div class="mc-panel__body">
  <div class="lesson-intro" style="--lesson-banner:url('${$resources.gamification.intro}');">

    <main class="lesson-intro__stage">

      <div class="lesson-intro__bubble">
        <div class="lesson-intro__bubble-title">¡Pon tus sentidos en alerta!</div>
        <div class="lesson-intro__bubble-text">
          En esta práctica realizaras
          <span class="lesson-intro__bubble-number">${numberLesson}</span>
          ejercicios.
        </div>
      </div>
    </main>
    <!-- FOOTER CTA -->
    <footer class="lesson-intro__footer">
      <button class="lesson-intro__btn lesson-intro__btn--primary" type="button" id="init-lesson">
        CONTINUAR
      </button>

      <button class="lesson-intro__btn lesson-intro__btn--ghost" type="button" id="exit-lesson">
        <span>Salir</span> <i class="bi bi-box-arrow-right"></i>
      </button>
    </footer>
  </div>
</div>


                                               `;
    }

    var $finishLesson = ` <div class="lesson">
                                                <!-- IMAGEN -->
                                                <header class="lesson__hero">
                                                    <!-- Reemplaza src por tu imagen -->
                                                    <img
                                                        class="lesson__hero-img"
                                                        src="${$resources.gamification.congratulation_smile}"
                                                        alt="Celebracion"
                                                    />
                                                </header>

                                                <!-- TITULO -->
                                                <h1 class="lesson__title">¡Lección completada!</h1>

                                                <!-- CARDS -->
                                                <div class="lesson__stats" aria-label="Resumen de resultados">
                                                    <!-- Card 1 -->
                                                    <article class="stat-card stat-card--purple">
                                                        <div class="stat-card__title">TOTAL XP</div>
                                                        <div class="stat-card__content">
          <span class="stat-card__icon" aria-hidden="true">
            <!-- Icono rayo (SVG) -->
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none">
              <path d="M13 2L4 14h7l-1 8 10-14h-7l0-6z" stroke="white" stroke-width="2" stroke-linejoin="round"/>
            </svg>
          </span>
                                                            <span class="stat-card__value">40</span>
                                                        </div>
                                                    </article>
                                                    <article class="stat-card stat-card--green">
                                                        <div class="stat-card__title">Sorprendente</div>
                                                        <div class="stat-card__content">
          <span class="stat-card__icon" aria-hidden="true">

          </span>
                                                            <span class="stat-card__value">100%</span>
                                                        </div>
                                                    </article>
                                                    <article class="stat-card stat-card--blue">
                                                        <div class="stat-card__title">Tiempo</div>
                                                        <div class="stat-card__content">
          <span class="stat-card__icon" aria-hidden="true">
            <!-- Icono reloj (SVG) -->
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none">
              <path d="M12 22a10 10 0 1 1 10-10 10 10 0 0 1-10 10z" stroke="white" stroke-width="2"/>
              <path d="M12 6v6l4 2" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
                                                            <span class="stat-card__value">3:13</span>
                                                        </div>
                                                    </article>
                                                </div>

                                                <button class="lesson__cta" type="button" id="repeat-lesson">
                                                    <span class="icon-btn__title">Repetir</span> <i class="bi bi-repeat"></i>
                                                 </button>
                                                <button class="lesson__cta" type="button" id="review-lesson">
                                                 <span class="icon-btn__title">Revisar Respuestas</span>   <i class="bi bi-journal-text"></i>
                                                </button>
                                                <button class="lesson__cta" type="button" id="claim-lesson">
                                                    Reclamar
                                                </button>
                                            </div> `;


    var $dataSetConfig = null;

    function finishSectionData(params) {
        console.log("finishSectionData", params)
    }

    window.MC = window.MC || {};
    const {safeParseJSON, nowISO} = MC.utils;
    const {logEvent} = MC.logger;
    const {updateTopChips} = MC.uiChips;
    const {renderStepsList} = MC.uiStepsList;
    const {renderExercise} = MC.uiExerciseView;
    const {APP, loadProgress, resetProgress, ensureStepProgress, getGateIndex, canOpenStep} = MC.state;
    const SAMPLE_JSON = {
        "management-unit":null,
        "meta": {
            "schema": "riksichishun.exercise_set.v1",
            "compatible_with": ["SortableJS@1.15.2", "jquery.serializeJSON@3.2.1"],
            "base_media_url": ""
        },
        "steps": []
    };

    function bootstrapFromJSON(data) {
        APP.data = data;
        loadProgress();
        APP.data.steps.forEach(s => ensureStepProgress(s));
        APP.activeIndex = getGateIndex();
        updateTopChips();
        renderStepsList(setActiveStep);
        setActiveStep(APP.activeIndex);
    }

    function setActiveStep(index) {
        APP.activeIndex = index;
        const step = APP.data.steps[index];
        $("#mcChipActive").text("Step: " + step.step_id);
        const prog = ensureStepProgress(step);
        prog.openedCount += 1;
        logEvent(step, {action: "OPEN_STEP"});
        renderStepsList(setActiveStep);
        renderExercise(step, setActiveStep);
        updateTopChips();
    }

    (function () {

        $(document).on("click", "#exit-lesson", function (e) {
            configModal.configuration.instance.hide();
        });
        $(document).on("click", "#init-lesson", function (e) {
            bootstrapFromJSON($dataSetConfig);
            $(".lesson-intro").addClass("not-view");
            $("#mcExerciseRoot").removeClass("not-view");
        });
        $(document).on("click", "#review-lesson", function (e) {

        });
        $(document).on("click", "#repeat-lesson", function (e) {

        });

        $(document).on("click", "#mcStepsList .mc-stepsbar__icon", function (e) {
            console.log("ini stepsbar__icon");

            configModal.configuration.instance.hide()
        });

        // Buttons
        $("#mcBtnLoadSample").on("click", () => {
            // si ya lo tienes definido global SAMPLE_JSON, úsalo:
            if (SAMPLE_JSON) $("#mcJsonInput").val(JSON.stringify(SAMPLE_JSON, null, 2));
        });

        $("#mcBtnParse").on("click", () => {
            const txt = $("#mcJsonInput").val().trim();
            const data = safeParseJSON(txt);

            if (!data || !Array.isArray(data.steps)) {
                $("#mcChipState").removeClass("mc-chip--info").addClass("mc-chip--bad").text("JSON inválido");
                $("#mcExerciseRoot").html(`<div class="mc-chip mc-chip--bad">JSON inválido: debe incluir steps[]</div>`);
                $("#mcStepsList").empty();
                APP.data = null;
                updateTopChips();
                return;
            }

            $("#mcChipState").removeClass("mc-chip--bad").addClass("mc-chip--info").text("JSON cargado");
            bootstrapFromJSON(data);
        });

        $("#mcBtnReset").on("click", () => {
            resetProgress();
            if (APP.data) bootstrapFromJSON(APP.data);
            else $("#mcChipProgress").text("Progreso: 0%");
        });

        $("#mcBtnExport").on("click", () => {
            const dump = {
                exported_at: nowISO(),
                session_id: MC.state.SESSION_ID,
                storage_key: MC.CONFIG.STORAGE_KEY,
                progress: APP.progress
            };
            const blob = new Blob([JSON.stringify(dump, null, 2)], {type: "application/json"});
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = `riksichishun_progress_${MC.state.SESSION_ID}.json`;
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        });

        // Init UI (no data yet)
        updateTopChips();

        // UI only: compact header on scroll
        (function () {
            const $body = $("body");
            $(document).on("scroll", ".mc-panel__body", function () {
                const sc = this.scrollTop || 0;
                $body.toggleClass("mc-is-scrolling", sc > 10);
            });
        })();
    })();

</script>
