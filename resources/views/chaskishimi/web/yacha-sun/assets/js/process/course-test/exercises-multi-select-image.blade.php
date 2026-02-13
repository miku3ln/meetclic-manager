<script>
    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr, deepEqualSorted } = MC.utils;

        MC.exercises["MULTI_SELECT_IMAGE"] = function renderMultiSelectImage(container, payload) {
            const options = payload.options || [];
            const img = normStr(payload.image || payload.image_url || "");
            const alt = normStr(payload.alt || "image");
            const showImageFirst = payload.showImageFirst !== false;

            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Seleccionar con imagen (multi)</div>
      <div class="mc-msi">
        ${img && showImageFirst ? `<div class="mc-msi__imgBox"><img class="mc-msi__img" src="${img}" alt="${alt}"></div>` : ``}
        <div class="mc-options" id="mcMsiBox"></div>
        ${img && !showImageFirst ? `<div class="mc-msi__imgBox"><img class="mc-msi__img" src="${img}" alt="${alt}"></div>` : ``}
      </div>
    `;

            const $box = $("#mcMsiBox").empty();
            options.forEach(o => {
                console.log("multi-select-image",o);

                $box.append(`
        <label class="mc-option">
          <input type="checkbox" value="${normStr(o.id)}">
          <span class="mc-option__text">${normStr(o.text)}</span>
        </label>
      `);
            });

            return {
                getAnswer() {
                    const picked = $("#mcMsiBox input:checked").map((_, el) => $(el).val()).get();
                    return { picked };
                },
                setAnswer(saved) {
                    const set = new Set((saved?.picked || []).map(normStr));
                    $("#mcMsiBox input[type='checkbox']").each(function () {
                        $(this).prop("checked", set.has(normStr($(this).val())));
                    });
                },
                check() {
                    const picked = this.getAnswer().picked;
                    const correct = payload.correctIds || [];
                    const ok = deepEqualSorted(picked, correct);
                    return { ok, msg: ok ? "Selección correcta (imagen)." : "Selección incorrecta (imagen)." };
                }
            };
        };
    })();

</script>
