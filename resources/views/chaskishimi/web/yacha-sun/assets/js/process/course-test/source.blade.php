<script>
    (function () {
        window.MC = window.MC || {};
        const { normStr } = MC.utils;
        const { APP } = MC.state;

        function resolveSource(step, exPayload) {
            const base = normStr(APP.data?.meta?.base_media_url || "");
            const stepSource = normStr(step?.source || "");
            const pSource = normStr(exPayload?.source_url || exPayload?.source || "");

            let src = stepSource || pSource || "";
            if (base && src && !src.startsWith("http") && !src.startsWith("data:")) {
                if (base.endsWith("/") && src.startsWith("/")) src = base.slice(0, -1) + src;
                else if (!base.endsWith("/") && !src.startsWith("/")) src = base + "/" + src;
                else src = base + src;
            }
            return src;
        }

        MC.source = { resolveSource };
    })();

</script>
