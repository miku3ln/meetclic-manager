<script>
    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr, shuffle } = MC.utils;

        MC.exercises["DRAG_MATCH"] = function renderDragMatch(container, payload) {
            const pairs = payload.pairs || [];
            const leftItems = shuffle(pairs.map(p => p.left));

            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Emparejar (arrastra)</div>
      <div class="mc-grid2">
        <div>
          <div class="mc-dropzone__label">Kichwa (arrastra)</div>
          <ul class="mc-tokenList" id="mcDmLeft"></ul>
        </div>
        <div>
          <div class="mc-dropzone__label">Español (suelta)</div>
          <div class="mc-options" id="mcDmZones"></div>
        </div>
      </div>
    `;

            const $left = $("#mcDmLeft").empty();
            const $zones = $("#mcDmZones").empty();

            leftItems.forEach(txt => {
                $left.append(`<li class="mc-tokenList__item" data-value="${normStr(txt)}">${normStr(txt)}</li>`);
            });

            pairs.forEach(p => {
                $zones.append(`
        <div class="mc-dropzone">
          <div class="mc-dropzone__label">${normStr(p.right)}</div>
          <ul class="mc-tokenList mc-tokenList--zone mc-dropzone__label-answer" data-expected="${normStr(p.left)}" style="min-height:44px;"></ul>
        </div>
      `);
            });

            Sortable.create(document.getElementById("mcDmLeft"), {
                group: { name: "dm", pull: "clone", put: false },
                sort: false,
                animation: 150
            });

            $(".mc-tokenList--zone").each(function () {
                Sortable.create(this, {
                    group: { name: "dm", pull: true, put: true },
                    animation: 150,
                    onAdd: (evt) => {
                        const zone = evt.to;
                        if (zone.children.length > 1) {
                            document.getElementById("mcDmLeft").appendChild(zone.children[0]);
                        }
                    }
                });
            });

            return {
                getAnswer() {
                    const answers = [];
                    $(".mc-tokenList--zone").each(function () {
                        const expected = $(this).data("expected");
                        const got = $(this).find(".mc-tokenList__item").first().data("value") || null;
                        answers.push({ expected, got });
                    });
                    return { answers };
                },
                setAnswer(saved) {
                    const answers = saved?.answers || [];
                    if (!Array.isArray(answers) || !answers.length) return;

                    $(".mc-tokenList--zone").each(function () { $(this).empty(); });

                    answers.forEach(row => {
                        const expected = normStr(row.expected);
                        const got = row.got == null ? "" : normStr(row.got);
                        if (!got) return;
                        const $zone = $(`.mc-tokenList--zone[data-expected="${expected}"]`);
                        if (!$zone.length) return;
                        $zone.append(`<li class="mc-tokenList__item" data-value="${got}">${got}</li>`);
                    });
                },
                check() {
                    const a = this.getAnswer();
                    const ok = a.answers.every(x => x.got === x.expected);
                    return { ok, msg: ok ? "Emparejaste todo correctamente." : "Hay emparejamientos incorrectos o vacíos." };
                }
            };
        };
    })();

</script>
