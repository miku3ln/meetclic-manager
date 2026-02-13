<script>
    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr } = MC.utils;

        MC.exercises["FILL_BLANK"] = function renderFillBlank(container, payload) {
            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Completar</div>
      <div class="mc-dropzone" style="border-style:solid;">
        <div class="mc-dropzone__label">Frase</div>
        <div style="font-weight:900; font-size:15px; margin-bottom:10px;">${normStr(payload.text)}</div>
        <input class="mc-input" id="mcFillInput" placeholder="Escribe aquí..." answer='${payload.answer}' >
        <div class="mc-panel__hint" style="margin-top:8px;">Tip: respeta tildes si aplica. (Puedes activar ignoreCase en JSON).</div>
      </div>
    `;

            return {
                getAnswer() { return { value: $("#mcFillInput").val() }; },
                setAnswer(saved) { $("#mcFillInput").val(normStr(saved?.value ?? "")); },
                check() {
                    let user = normStr($("#mcFillInput").val());
                    let ans = normStr(payload.answer);

                    if (payload.trim) { user = user.trim(); ans = ans.trim(); }
                    if (payload.ignoreCase) { user = user.toLowerCase(); ans = ans.toLowerCase(); }

                    const ok = user === ans;
                    return { ok, msg: ok ? "Bien hecho." : "Revisa tu respuesta." };
                }
            };
        };
    })();

</script>
