<script>
    (function () {
        window.MC = window.MC || {};
        const { APP, SESSION_ID, isStepPassed, getGateIndex } = MC.state;

        function updateTopChips() {
            const total = APP.data?.steps?.length || 0;
            $("#mcChipTotal").text("Steps: " + total);

            const passedCount = total ? APP.data.steps.filter(s => isStepPassed(s)).length : 0;
            const pct = total ? Math.round((passedCount / total) * 100) : 0;
            $("#mcChipProgress").text("Progreso: " + pct + "%");

            const gateIndex = total ? getGateIndex() : 0;
            const gateStep = total ? APP.data.steps[gateIndex] : null;
            $("#mcChipGate")
                .removeClass("mc-chip--bad mc-chip--ok mc-chip--info")
                .addClass(gateStep ? "mc-chip--info" : "mc-chip--bad")
                .text("Gate: " + (gateStep ? gateStep.step_id : "—"));

            const state = APP.data ? "JSON cargado" : "Sin cargar";
            $("#mcChipState")
                .toggleClass("mc-chip--info", !!APP.data)
                .toggleClass("mc-chip--bad", !APP.data)
                .text(state);

            $("#mcChipSession").text("Session: " + SESSION_ID);
        }

        MC.uiChips = { updateTopChips };
    })();

</script>
