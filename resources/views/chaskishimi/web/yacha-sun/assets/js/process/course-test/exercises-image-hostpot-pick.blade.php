<script>
    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr, deepEqualSorted } = MC.utils;

        MC.exercises["IMAGE_HOTSPOT_PICK"] = function renderImageHotspotPick(container, payload) {
            const image = normStr(payload.image || payload.image_url || "");
            const hotspots = Array.isArray(payload.hotspots) ? payload.hotspots : [];
            const mode = normStr(payload.mode || "MULTI");
            const maxPick = Number.isFinite(payload.maxPick) ? payload.maxPick : null;
            const showLabels = payload.showLabels !== false;

            let picked = new Set();

            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Imagen con puntos (hotspots)</div>
      <div class="mc-hot">
        <div class="mc-hot__frame" id="mcHotFrame">
          <img class="mc-hot__img" id="mcHotImg" src="${image}" alt="hotspot-image">
        </div>
      </div>
      <div class="mc-hot__legend" id="mcHotLegend"></div>
      <div class="mc-panel__hint" style="margin-top:10px;">
        Tip: los puntos están en % (xPct/yPct) para que escalen con la imagen.
      </div>
    `;

            const $frame = $("#mcHotFrame");
            const $legend = $("#mcHotLegend").empty();

            hotspots.forEach(h => {
                console.log(h);
                const id = normStr(h.id);
                const x = Number(h.xPct);
                const y = Number(h.yPct);
                const label = normStr(h.label);

                $frame.append(`
        <div class="mc-hot__spot" data-id="${id}" style="left:${x}%; top:${y}%;" is-correct="${h.isCorrect}">
          <div class="mc-hot__check">✓</div>
          ${showLabels ? `<div class="mc-hot__label">${label}</div>` : ``}
        </div>
      `);
            });

            $frame.off("click.mcHot").on("click.mcHot", function (e) {
                const $spot = $(e.target).closest(".mc-hot__spot");
                if (!$spot.length) return;

                const id = normStr($spot.data("id"));

                if (mode === "SINGLE") {
                    picked.clear();
                    $(".mc-hot__spot").removeClass("is-picked");
                    picked.add(id);
                    $spot.addClass("is-picked");
                    renderLegend();
                    return;
                }

                if (picked.has(id)) {
                    picked.delete(id);
                    $spot.removeClass("is-picked is-wrong");
                    renderLegend();
                    return;
                }

                if (maxPick && picked.size >= maxPick) return;

                picked.add(id);
                $spot.addClass("is-picked");
                renderLegend();
            });

            function renderLegend() {
                $legend.empty();
                if (!picked.size) {
                    $legend.append(`<div class="mc-hot__legendItem">Selecciona puntos en la imagen…</div>`);
                    return;
                }
                Array.from(picked).forEach(id => {
                    const h = hotspots.find(x => normStr(x.id) === id);
                    const label = h ? normStr(h.label) : id;
                    $legend.append(`<div class="mc-hot__legendItem"><strong>${label}</strong></div>`);
                });
            }

            renderLegend();

            return {
                getAnswer() { return { picked: Array.from(picked) }; },
                setAnswer(saved) {
                    picked = new Set((saved?.picked || []).map(normStr));
                    $(".mc-hot__spot").removeClass("is-picked is-wrong");
                    picked.forEach(id => {
                        $(`.mc-hot__spot[data-id="${id}"]`).addClass("is-picked");
                    });
                    renderLegend();
                },
                check() {
                    const correctIds = hotspots.filter(h => !!h.isCorrect).map(h => normStr(h.id));
                    const user = Array.from(picked);
                    const ok = deepEqualSorted(user, correctIds);

                    $(".mc-hot__spot").removeClass("is-wrong");
                    user.forEach(id => {
                        if (!correctIds.includes(id)) $(`.mc-hot__spot[data-id="${id}"]`).addClass("is-wrong");
                    });

                    return { ok, msg: ok ? "Correcto: marcaste los puntos exactos." : "Incorrecto: revisa los puntos marcados." };
                }
            };
        };
    })();

</script>
