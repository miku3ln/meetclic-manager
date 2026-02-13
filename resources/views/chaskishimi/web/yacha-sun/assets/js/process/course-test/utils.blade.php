<script>
    (function () {
        window.MC = window.MC || {};

        function safeParseJSON(txt) {
            try { return JSON.parse(txt); } catch (e) { return null; }
        }

        function normStr(s) {
            return (s ?? "").toString();
        }

        function nowISO() {
            return new Date().toISOString();
        }

        function deepEqualSorted(a, b) {
            const aa = [...(a || [])].map(normStr).sort();
            const bb = [...(b || [])].map(normStr).sort();
            return aa.length === bb.length && aa.every((v, i) => v === bb[i]);
        }

        function shuffle(arr) {
            const a = [...(arr || [])];
            for (let i = a.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [a[i], a[j]] = [a[j], a[i]];
            }
            return a;
        }

        MC.utils = { safeParseJSON, normStr, nowISO, deepEqualSorted, shuffle };
    })();

</script>
