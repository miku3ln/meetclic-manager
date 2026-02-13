<script>
    (function () {
        window.MC = window.MC || {};
        const { normStr } = MC.utils;

        function mountExercise(container, ex) {
            const type = ex.type;
            const payload = ex.payload || {};

            const registry = MC.exercises || {};
            const render = registry[type];

            if (!render) {
                container.innerHTML = `<div class="mc-chip mc-chip--bad">Tipo no soportado: ${normStr(type)}</div>`;
                return null;
            }
            return render(container, payload);
        }

        MC.router = { mountExercise };
    })();

</script>
