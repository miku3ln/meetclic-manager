<script>
    function finishSectionData(params){
        console.log("finishSectionData",params)
    }
    window.MC = window.MC || {};
    const {safeParseJSON, nowISO} = MC.utils;
    const {logEvent} = MC.logger;
    const {updateTopChips} = MC.uiChips;
    const {renderStepsList} = MC.uiStepsList;
    const {renderExercise} = MC.uiExerciseView;
    const {APP, loadProgress, resetProgress, ensureStepProgress, getGateIndex, canOpenStep} = MC.state;
    const SAMPLE_JSON = {
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
