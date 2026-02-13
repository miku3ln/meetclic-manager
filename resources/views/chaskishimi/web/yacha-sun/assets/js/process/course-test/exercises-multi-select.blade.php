<script>

    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr, deepEqualSorted } = MC.utils;

        MC.exercises["MULTI_SELECT"] = function renderMultiSelect(container, payload) {
            const options = payload.options || [];
            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Seleccionar (multi)</div>
      <div class="mc-options" id="mcMsBox"></div>
    `;
            const correct = payload.correctIds ;

            const $box = $("#mcMsBox").empty();
            options.forEach(o => {
                const ok = correct.includes(o.id);
                console.log("multi-select",o);
                $box.append(`
        <label class="mc-option" anskwer='${ok}'>
          <input type="checkbox" value="${normStr(o.id)}" anskwer='${ok}'>
          <span class="mc-option__text">${normStr(o.text)}</span>
        </label>
      `);
            });

            return {
                getAnswer() {
                    const picked = $("#mcMsBox input:checked").map((_, el) => $(el).val()).get();
                    return { picked };
                },
                setAnswer(saved) {
                    const set = new Set((saved?.picked || []).map(normStr));
                    $("#mcMsBox input[type='checkbox']").each(function () {
                        $(this).prop("checked", set.has(normStr($(this).val())));
                    });
                },
                check() {
                    const picked = this.getAnswer().picked;
                    const correct = payload.correctIds || [];
                    const ok = deepEqualSorted(picked, correct);
                    return { ok, msg: ok ? "Selección correcta." : "Selección incorrecta. Revisa cuántas deben ser." };
                }
            };
        };
    })();

</script>
