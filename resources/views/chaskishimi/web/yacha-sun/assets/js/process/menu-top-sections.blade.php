<script>
    const MC_STICKY_CONFIG = {
        "section-1": {
            meta: "SECTION 1, UNIT 1",
            title: "WAYRA • Wayra - Viento",
            bg: "#7BD3FF",                  // 🌬️ cielo/aire (NO verde)
            textColor: "#0B1B2B",
            rightBg: "rgba(11,27,43,.10)",
            iconUrl: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4a8.svg",
            onLeftClick: ({ sectionId }) => console.log("LEFT CLICK", sectionId),
            onRightClick: ({ sectionId }) => console.log("RIGHT CLICK", sectionId),
            onEnter: ({ sectionId }) => console.log("ENTER EXTRA", sectionId),
        },

        "section-2": {
            meta: "SECTION 2, UNIT 1",
            title: "YAKU • Yaku - Agua",
            bg: "#1EA1E6",                  // 💧 agua intenso
            textColor: "#FFFFFF",
            rightBg: "rgba(255,255,255,.18)",
            iconUrl: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4a7.svg",
            onLeftClick: ({ sectionId }) => console.log("LEFT CLICK", sectionId),
            onRightClick: ({ sectionId }) => console.log("RIGHT CLICK", sectionId),
            onEnter: ({ sectionId }) => console.log("ENTER EXTRA", sectionId),
        },

        "section-3": {
            meta: "SECTION 3, UNIT 1",
            title: "ALLPA • Allpa - Tierra",
            bg: "#C99433",                 // ✅ ALLPA fijo
            textColor: "#FFFFFF",
            rightBg: "rgba(255,255,255,.18)",
            iconUrl: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1faa8.svg", // 🪨
            onLeftClick: ({ sectionId }) => console.log("LEFT CLICK", sectionId),
            onRightClick: ({ sectionId }) => console.log("RIGHT CLICK", sectionId),
            onEnter: ({ sectionId }) => console.log("ENTER EXTRA", sectionId),
        },

        "section-4": {
            meta: "SECTION 4, UNIT 1",
            title: "NINA • Nina - Fuego",
            bg: "#E53935",                 // ✅ NINA fijo
            textColor: "#FFFFFF",
            rightBg: "rgba(255,255,255,.18)",
            iconUrl: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f525.svg", // 🔥
            onLeftClick: ({ sectionId }) => console.log("LEFT CLICK", sectionId),
            onRightClick: ({ sectionId }) => console.log("RIGHT CLICK", sectionId),
            onEnter: ({ sectionId }) => console.log("ENTER EXTRA", sectionId),
        },
    };

    window.MCStickyHeader = (function () {
        let CONFIG = {};
        let els = [];
        let io = null;
        let currentSectionId = null;
        let scrollFallbackBound = false;
        let ticking = false;

        // UI refs
        let cardEl, metaEl, titleEl, iconEl, leftBtn, rightBtn;

        function ensureFixedCard() {
            let card = document.getElementById("mcFixedCard");
            if (card) return;

            const style = document.createElement("style");
            style.textContent = `
        .mc-fixedCard{position:fixed;top:10px;left:0;right:0;z-index:9999;pointer-events:none;padding:0 12px}
        .mc-fixedCard__inner{pointer-events:auto;margin:0 auto;max-width:980px;display:grid;grid-template-columns:1fr 58px;min-height:64px;border-radius:14px;overflow:hidden;background:var(--mc-fixedCard-bg,#33b300);color:var(--mc-fixedCard-text,#fff);box-shadow:0 12px 30px rgba(0,0,0,.22)}
        .mc-fixedCard__col{border:0;background:transparent;color:inherit;cursor:pointer;padding:0}
        .mc-fixedCard__col--left{text-align:left;padding:10px 14px;min-width:0}
        .mc-fixedCard__meta{font-weight:900;font-size:12px;letter-spacing:.6px;text-transform:uppercase;opacity:.95;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .mc-fixedCard__title{margin-top:3px;font-weight:800;font-size:16px;line-height:1.1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .mc-fixedCard__col--right{display:flex;align-items:center;justify-content:center;background:var(--mc-fixedCard-rightBg,rgba(255,255,255,.18))}
        .mc-fixedCard__iconBox{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.08)}
        .mc-fixedCard__icon{width:24px;height:24px;display:block}
        /* evita que tape tu content */
        .content{padding-top:92px}
      `;
            document.head.appendChild(style);

            card = document.createElement("div");
            card.className = "mc-fixedCard";
            card.id = "mcFixedCard";
            card.innerHTML = `
        <div class="mc-fixedCard__inner">
          <button class="mc-fixedCard__col mc-fixedCard__col--left" id="mcFixedCardLeft" type="button">
            <div class="mc-fixedCard__meta" id="mcFixedCardMeta">SECTION —, UNIT —</div>
            <div class="mc-fixedCard__title" id="mcFixedCardTitle">—</div>
          </button>
          <button class="mc-fixedCard__col mc-fixedCard__col--right" id="mcFixedCardRight" type="button" aria-label="Open actions">
            <span class="mc-fixedCard__iconBox">
              <img class="mc-fixedCard__icon" id="mcFixedCardIcon" alt="icon">
            </span>
          </button>
        </div>
      `;
            document.body.appendChild(card);
        }

        function bindUIRefs() {
            cardEl = document.getElementById("mcFixedCard");
            metaEl = document.getElementById("mcFixedCardMeta");
            titleEl = document.getElementById("mcFixedCardTitle");
            iconEl = document.getElementById("mcFixedCardIcon");
            leftBtn = document.getElementById("mcFixedCardLeft");
            rightBtn = document.getElementById("mcFixedCardRight");

            const missing = [];
            if (!cardEl) missing.push("#mcFixedCard");
            if (!metaEl) missing.push("#mcFixedCardMeta");
            if (!titleEl) missing.push("#mcFixedCardTitle");
            if (!iconEl) missing.push("#mcFixedCardIcon");
            if (!leftBtn) missing.push("#mcFixedCardLeft");
            if (!rightBtn) missing.push("#mcFixedCardRight");

            if (missing.length) {
                console.warn("MCStickyHeader: missing UI:", missing.join(", "));
                return false;
            }
            return true;
        }

        function applySection(sectionId) {
            const cfg = CONFIG[sectionId];
            if (!cfg) return;

            currentSectionId = sectionId;

            metaEl.textContent = cfg.meta ?? "SECTION —, UNIT —";
            titleEl.textContent = cfg.title ?? "—";
            iconEl.src = cfg.iconUrl ?? "";

            cardEl.style.setProperty("--mc-fixedCard-bg", cfg.bg ?? "#33b300");
            cardEl.style.setProperty("--mc-fixedCard-text", cfg.textColor ?? "#FFFFFF");
            cardEl.style.setProperty("--mc-fixedCard-rightBg", cfg.rightBg ?? "rgba(255,255,255,.18)");
        }

        function enterSection(sectionId) {
            if (!sectionId || sectionId === currentSectionId) return;
            const cfg = CONFIG[sectionId];
            if (!cfg) return;

            applySection(sectionId);
            cfg.onEnter?.({ sectionId, cfg });
        }

        function attachClicksOnce() {
            // evita duplicar listeners si reinicias
            leftBtn.onclick = () => {
                if (!currentSectionId) return;
                CONFIG[currentSectionId]?.onLeftClick?.({ sectionId: currentSectionId, cfg: CONFIG[currentSectionId] });
            };
            rightBtn.onclick = () => {
                if (!currentSectionId) return;
                CONFIG[currentSectionId]?.onRightClick?.({ sectionId: currentSectionId, cfg: CONFIG[currentSectionId] });
            };
        }

        function initFirst() {
            if (!els.length) return;
            let best = els[0];
            let bestScore = Infinity;

            for (const el of els) {
                const r = el.getBoundingClientRect();
                const score = Math.abs(r.top - 92);
                if (score < bestScore) { bestScore = score; best = el; }
            }
            enterSection(best.id);
        }

        function initObserver({ root = null } = {}) {
            if (!("IntersectionObserver" in window)) return false;

            io = new IntersectionObserver((entries) => {
                const visible = entries
                    .filter((e) => e.isIntersecting)
                    .sort((a, b) => (b.intersectionRatio ?? 0) - (a.intersectionRatio ?? 0))[0];
                if (!visible) return;
                enterSection(visible.target.id);
            }, {
                root,
                rootMargin: "-92px 0px -55% 0px",
                threshold: [0.2, 0.35, 0.5, 0.7],
            });

            els.forEach((el) => io.observe(el));
            return true;
        }

        function initScrollFallback({ root = window } = {}) {
            if (scrollFallbackBound) return;
            scrollFallbackBound = true;

            const pickBest = () => {
                let bestId = null;
                let bestScore = Infinity;

                for (const el of els) {
                    const r = el.getBoundingClientRect();
                    if (r.bottom < 92 || r.top > window.innerHeight * 0.7) continue;
                    const score = Math.abs(r.top - 92);
                    if (score < bestScore) { bestScore = score; bestId = el.id; }
                }
                return bestId;
            };

            const onScroll = () => {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(() => {
                    ticking = false;
                    const id = pickBest();
                    if (id) enterSection(id);
                });
            };

            (root === window ? window : root).addEventListener("scroll", onScroll, { passive: true });
            window.addEventListener("resize", onScroll);
            onScroll();
        }

        // =========================
        // PUBLIC API
        // =========================
        function setConfig(payload) {
            CONFIG = payload || {};
            return CONFIG;
        }

        /**
         * init()
         * - Llamas DESPUÉS de generar tus sections en el DOM.
         * - options.rootSelector: si el scroll está en un div, pásalo aquí.
         */
        function init(options = {}) {
            const { rootSelector = null } = options;
            $("#mcFixedCard").removeClass("not-view");
            // limpia prev si existía
            destroy();

            ensureFixedCard();
            if (!bindUIRefs()) return;

            attachClicksOnce();

            // busca sections
            const ids = Object.keys(CONFIG);
            els = ids.map((id) => document.getElementById(id)).filter(Boolean);

            console.log("MCStickyHeader.init sections:", els.map(e => e.id));

            if (!els.length) {
                console.warn("MCStickyHeader: no encontró sections. Ejecuta init() DESPUÉS de renderizar #section-1..#section-4");
                return;
            }

            initFirst();

            // root scroll (si tu scroll está en un contenedor)
            const rootEl = rootSelector ? document.querySelector(rootSelector) : null;

            const ok = initObserver({ root: rootEl || null });
            if (!ok) initScrollFallback({ root: rootEl || window });
        }

        function destroy() {
            // desconecta observer
            if (io) {
                try { io.disconnect(); } catch (e) {}
                io = null;
            }
            els = [];
            currentSectionId = null;
            // scroll fallback: lo dejamos una sola vez para no duplicar; si quieres full reset, me dices y lo implemento.
        }

        // debug helpers
        function enter(sectionId) { enterSection(sectionId); }
        function apply(sectionId) { applySection(sectionId); }

        return { setConfig, init, destroy, enter, apply };
    })();
</script>
