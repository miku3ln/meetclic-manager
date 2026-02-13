<script>
    (function () {
        window.MC = window.MC || {};
        MC.exercises = MC.exercises || {};
        const { normStr } = MC.utils;

        MC.exercises["ORDER_WORDS"] = function renderOrderWords(container, payload) {
            const items = payload.items || [];
            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Ordenar palabras</div>
      <ul class="mc-tokenList" id="mcOrderList"></ul>
    `;
            const $list = $("#mcOrderList").empty();

            items.forEach(w => {
                $list.append(`<li class="mc-tokenList__item" data-value="${normStr(w)}">${normStr(w)}</li>`);
            });

            Sortable.create(document.getElementById("mcOrderList"), { animation: 150 });

            return {
                getAnswer() {
                    return { order: $("#mcOrderList .mc-tokenList__item").map((_, el) => $(el).data("value")).get() };
                },
                setAnswer(saved) {
                    const order = saved?.order || [];
                    if (!Array.isArray(order) || !order.length) return;

                    const $list = $("#mcOrderList");
                    const map = new Map();
                    $list.find(".mc-tokenList__item").each(function () {
                        map.set(normStr($(this).data("value")), this);
                    });
                    order.forEach(v => {
                        const el = map.get(normStr(v));
                        if (el) $list.append(el);
                    });
                },
                check() {
                    const user = this.getAnswer().order;
                    const correct = payload.correctOrder || [];
                    const ok = user.length === correct.length && user.every((v, i) => v === correct[i]);
                    return { ok, msg: ok ? "Orden correcto." : "Orden incorrecto. Arrastra y reordena." };
                }
            };
        };
    })();

</script>
