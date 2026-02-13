<script>
    (function () {
        window.MC = window.MC || {};
        const { CONFIG } = MC;
        const { safeParseJSON } = MC.utils;

        function getSessionId() {
            const existing = localStorage.getItem(CONFIG.SESSION_KEY);
            if (existing) return existing;
            const id = "sess_" + Date.now() + "_" + Math.random().toString(16).slice(2);
            localStorage.setItem(CONFIG.SESSION_KEY, id);
            return id;
        }

        function loadProgressRaw() {
            const raw = localStorage.getItem(CONFIG.STORAGE_KEY);
            return raw ? (safeParseJSON(raw) || {}) : {};
        }

        function saveProgressRaw(progress) {
            localStorage.setItem(CONFIG.STORAGE_KEY, JSON.stringify(progress || {}));
        }

        function resetProgressRaw() {
            saveProgressRaw({});
        }

        MC.storage = { getSessionId, loadProgressRaw, saveProgressRaw, resetProgressRaw };
    })();

</script>
