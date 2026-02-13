<script>
    (function () {
        window.MC = window.MC || {};
        const { CONFIG } = MC;
        const { getSessionId, loadProgressRaw, saveProgressRaw } = MC.storage;

        const SESSION_ID = getSessionId();

        // Estado global app (solo datos)
        const APP = {
            data: null,
            activeIndex: 0,
            progress: {},
            api: null
        };

        function loadProgress() {
            APP.progress = loadProgressRaw();
        }

        function saveProgress() {
            saveProgressRaw(APP.progress);
        }

        function resetProgress() {
            APP.progress = {};
            APP.activeIndex = 0;
            saveProgress();
        }

        function ensureStepProgress(step) {
            const sid = step.step_id;
            if (!APP.progress[sid]) {
                APP.progress[sid] = {
                    session_id: SESSION_ID,
                    status: "IN_PROGRESS", // IN_PROGRESS | PASSED | FAILED
                    attempts: 0,
                    attemptsMax: CONFIG.DEFAULT_ATTEMPTS_MAX,
                    verifiedCount: 0,
                    openedCount: 0,
                    lastAnswer: null,
                    lastResult: null,
                    history: []
                };
                saveProgress();
            }
            return APP.progress[sid];
        }

        function isStepDone(step) {
            const st = ensureStepProgress(step).status;
            return st === "PASSED" || st === "FAILED";
        }
        function isStepPassed(step) { return ensureStepProgress(step).status === "PASSED"; }
        function isStepFailed(step) { return ensureStepProgress(step).status === "FAILED"; }

        function getGateIndex() {
            if (!APP.data?.steps?.length) return 0;
            for (let i = 0; i < APP.data.steps.length; i++) {
                if (!isStepDone(APP.data.steps[i])) return i;
            }
            return APP.data.steps.length - 1;
        }

        function canOpenStep(index) {
            if (!APP.data?.steps?.length) return false;
            const step = APP.data.steps[index];
            if (isStepDone(step)) return true;
            return index === getGateIndex();
        }

        MC.state = {
            APP,
            SESSION_ID,
            loadProgress,
            saveProgress,
            resetProgress,
            ensureStepProgress,
            isStepDone,
            isStepPassed,
            isStepFailed,
            getGateIndex,
            canOpenStep
        };
    })();

</script>
