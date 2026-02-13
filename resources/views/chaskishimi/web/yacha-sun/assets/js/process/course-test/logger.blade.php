<script>
    (function () {
        window.MC = window.MC || {};
        const { nowISO } = MC.utils;
        const { SESSION_ID, ensureStepProgress, saveProgress } = MC.state;

        function logEvent(step, payload) {
            const p = ensureStepProgress(step);
            p.history.push({
                ts: nowISO(),
                session_id: SESSION_ID,
                step_id: step.step_id,
                unidad_id: step.unidad_id ?? null,
                unidad_seccion_id: step.unidad_seccion_id ?? null,
                configuracion_ui_ux_id: step.configuracion_ui_ux_id ?? null,
                exercise_id: step.exercise?.exercise_id || null,
                type: step.exercise?.type || null,
                ...payload
            });
            if (p.history.length > 250) p.history = p.history.slice(-250);
            saveProgress();
        }

        MC.logger = { logEvent };
    })();

</script>
