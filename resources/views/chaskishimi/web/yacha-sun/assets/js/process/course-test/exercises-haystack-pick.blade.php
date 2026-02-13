<script>
    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr, deepEqualSorted } = MC.utils;

        MC.exercises["HAYSTACK_PICK"] = function renderHaystackPick(container, payload) {
            const haystack = payload.haystack || [];
            const correct = payload.correct || [];
            let picked = new Set();

            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Escoger del haystack</div>
      <div class="mc-dropzone" style="border-style:solid; margin-bottom:10px;">
        <div class="mc-dropzone__label">Palabra:</div>
        <div style="font-weight:900; font-size:15px; color:var(--mc-blue)">
          ${normStr(payload.question?.es)}  <span class="mc-dropzone__label--answer" style="color:var(--mc-blue)">${normStr(payload.question?.ki || "?")}</span>
        </div>
      </div>
      <div class="mc-hay" id="mcHayBox"></div>
    `;

            const $hay = $("#mcHayBox").empty();
            haystack.forEach(item => {
                const $btn = $(`<button type="button" class="mc-hay__btn" data-value="${normStr(item)}">${normStr(item)}</button>`);
                $btn.on("click", function () {
                    const val = normStr($(this).data("value"));
                    if (picked.has(val)) { picked.delete(val); $(this).removeClass("is-picked"); }
                    else { picked.add(val); $(this).addClass("is-picked"); }
                });
                $hay.append($btn);
            });

            return {
                getAnswer() { return { picked: Array.from(picked) }; },
                setAnswer(saved) {
                    picked = new Set((saved?.picked || []).map(normStr));
                    $("#mcHayBox .mc-hay__btn").each(function () {
                        const v = normStr($(this).data("value"));
                        $(this).toggleClass("is-picked", picked.has(v));
                    });
                },
                check() {
                    const user = this.getAnswer().picked;
                    const ok = deepEqualSorted(user, correct);
                    return { ok, msg: ok ? "Correcto." : ("Incorrecto. Correcta(s): " + correct.join(", ")) };
                }
            };
        };
    })();

</script>
