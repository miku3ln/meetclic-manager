<script>
    /* ==========================================================
       ✅ UNA CLASE (jQuery) + soporta varios timeType
       - timeType puede ser:
         "PASADO" o "PRESENTE" o "FUTURO"
         o array: ["PASADO","PRESENTE","FUTURO"]
         o string: "PASADO,PRESENTE,FUTURO"
       ========================================================== */

    class MCConjugatorUI {
        constructor(opts = {}) {
            this.opts = Object.assign({
                containerClass: "mc-conj",
                tableClass: "mc-conj__grid",
                showFootnote: true,
                // Orden pronombres como tus tablas
                pronouns: [
                    { key: "N",  kw: "Ñuka",      es: "Yo" },
                    { key: "K",  kw: "Kan",       es: "Tú" },
                    { key: "P",  kw: "Pay",       es: "Él/Ella" },
                    { key: "NK", kw: "Ñukanchik", es: "Nosotros" },
                    { key: "KK", kw: "Kankuna",   es: "Ustedes" },
                    { key: "PK", kw: "Paykuna",   es: "Ellos" }
                ],
                // Terminaciones (alineadas a tus matrices)
                endings: {
                    PRESENTE: { N:"ni",   K:"nki",  P:"n",   NK:"nchik",  KK:"nkichik", PK:"nkuna" },
                    PASADO:   { N:"rkani",K:"rkanki",P:"rka", NK:"rkanchik",KK:"rkankichik",PK:"rka" },
                    FUTURO:   { N:"sha",  K:"nki",  P:"nka", NK:"shunchik",KK:"nkichik", PK:"nka" }
                },
                // Texto de modificación EXACTO
                modText: {
                    PRESENTE: (end)=>`(-na)+${end}`,
                    PASADO:   (end)=>`(-na)+${end}`,
                    FUTURO:   (end)=>`(-na)+${end}`
                },
                // Títulos por tiempo
                timeLabel: {
                    PRESENTE: "Kay Pacha – PRESENTE",
                    PASADO:   "Washa Pacha – PASADO",
                    FUTURO:   "Ñawpa Pacha – FUTURO"
                }
            }, opts);
        }

        normalizeTimes(timeType){
            if (Array.isArray(timeType)) return timeType.map(t=>this.normalizeOne(t)).filter(Boolean);
            const raw = String(timeType || "PRESENTE").trim();
            if (raw.includes(",")) return raw.split(",").map(s=>this.normalizeOne(s)).filter(Boolean);
            return [this.normalizeOne(raw)].filter(Boolean);
        }

        normalizeOne(t){
            const x = String(t || "").trim().toUpperCase();
            if (x === "PRESENTE" || x === "PASADO" || x === "FUTURO") return x;
            return null;
        }

        getRoot(inf){
            const v = String(inf || "").trim();
            if (!v) return "";
            return v.toLowerCase().endsWith("na") ? v.slice(0, -2) : v;
        }

        // ✅ Traducciones ES por persona/tiempo (simple pero correcto para ejemplos)
        // m = infinitivo español: "masticar", "comer", "comprar", etc.
        esConjugation(m, time, pronKey){
            const verb = String(m || "…").trim();
            // Si no es infinitivo, igual lo mostramos
            // Heurística simple para -ar/-er/-ir
            const isAR = verb.endsWith("ar");
            const isER = verb.endsWith("er");
            const isIR = verb.endsWith("ir");
            const stem = (isAR||isER||isIR) ? verb.slice(0,-2) : verb;

            const map = {
                PRESENTE: {
                    N: isAR ? stem+"o"   : isER ? stem+"o"   : isIR ? stem+"o" : verb,
                    K: isAR ? stem+"as"  : isER ? stem+"es"  : isIR ? stem+"es": verb,
                    P: isAR ? stem+"a"   : isER ? stem+"e"   : isIR ? stem+"e" : verb,
                    NK:isAR ? stem+"amos": isER ? stem+"emos": isIR ? stem+"imos": verb,
                    KK:isAR ? stem+"an"  : isER ? stem+"en"  : isIR ? stem+"en": verb,
                    PK:isAR ? stem+"an"  : isER ? stem+"en"  : isIR ? stem+"en": verb,
                },
                PASADO: {
                    N: isAR ? stem+"é"      : isER||isIR ? stem+"í"      : verb,
                    K: isAR ? stem+"aste"   : isER||isIR ? stem+"iste"   : verb,
                    P: isAR ? stem+"ó"      : isER||isIR ? stem+"ió"     : verb,
                    NK:isAR ? stem+"amos"   : isER||isIR ? stem+"imos"   : verb,
                    KK:isAR ? stem+"aron"   : isER||isIR ? stem+"ieron"  : verb,
                    PK:isAR ? stem+"aron"   : isER||isIR ? stem+"ieron"  : verb,
                },
                FUTURO: {
                    N:  verb + "é",
                    K:  verb + "ás",
                    P:  verb + "á",
                    NK: verb + "emos",
                    KK: verb + "án",
                    PK: verb + "án",
                }
            };

            return (map[time] && map[time][pronKey]) ? map[time][pronKey] : verb;
        }

        buildRows(word, time){
            const root = this.getRoot(word.value);
            const ends = this.opts.endings[time];

            return this.opts.pronouns.map(p=>{
                const end = ends[p.key];
                const verbo = root + end;
                const mod = this.opts.modText[time](end);

                const esVerb = this.esConjugation(word.translation_value, time, p.key);
                const exampleKw = `${p.kw} ${verbo}.`;
                const exampleEs = `(${p.es} ${esVerb}.)`;

                return {
                    pronombre: p.kw,
                    modificacion: mod,
                    verbo,
                    exampleKw,
                    exampleEs
                };
            });
        }
        formatModHtml(modText){
            const raw = String(modText || "").trim();

            // Caso estándar: "(-na)+xxxx"
            const m = raw.match(/^(\(-[^)]+\))\s*\+\s*(.+)$/);
            if (m) {
                const minus = this.escape(m[1]); // "(-na)"
                const plus  = this.escape(m[2]); // "nki" / "rkani" / "sha"
                return `
      <span class="mc-mod__minus">${minus}</span>
      <span class="mc-mod__sign">+</span>
      <span class="mc-mod__plus">${plus}</span>
    `.trim();
            }

            // Si por alguna razón no viene con +, lo mostramos completo
            return `<span class="mc-mod__plus">${this.escape(raw)}</span>`;
        }

        renderCard(word, time){
            const rows = this.buildRows(word, time);
            const title = `${this.opts.timeLabel[time]}  VERBO  ${word.value} – ${word.translation_value || ""}`;

            const trs = rows.map(r=>`
  <tr>
    <td class="mc-conj__pron">${this.escape(r.pronombre)}</td>
    <td class="mc-conj__mod">${this.formatModHtml(r.modificacion)}</td>
    <td class="mc-conj__verb">${this.escape(r.verbo)}</td>
    <td class="mc-conj__ex">
      <span class="mc-conj__ex-kw">${this.escape(r.exampleKw)}</span>
      <span class="mc-conj__ex-es">${this.escape(r.exampleEs)}</span>
    </td>
  </tr>
`).join("");

            const foot = this.opts.showFootnote ? `
        <div class="mc-conj__footnote">
          <b>Regla:</b> <span>(-na)</span> = se quita del verbo; <span>(+)</span> = se añade la terminación del tiempo y la persona.
        </div>
      ` : "";

            return `
        <section class="${this.opts.containerClass} ${this.opts.containerClass}--${time}">
          <header class="mc-conj__head">
            <div>
              <h3 class="mc-conj__title">
                <span class="mc-conj__dot"></span>
                ${this.escape(title)}
              </h3>
              <div class="mc-conj__subtitle">
                <b>Pronombre</b> • <b>Modificación Verbo</b> • <b>Verbo Modificado</b> • <b>Ejemplo</b>
              </div>
            </div>
            <div class="mc-conj__badge">
              <span><b>Clase:</b> ${this.escape(word.dictionary_grammatical_class_name || "Verbo")}</span>
            </div>
          </header>

          <table class="${this.opts.tableClass}">
            <thead>
              <tr>
                <th>Pronombre</th>
                <th>Modificación Verbo</th>
                <th>Verbo Modificado</th>
                <th>Ejemplo</th>
              </tr>
            </thead>
            <tbody>${trs}</tbody>
          </table>

          ${foot}
        </section>
      `;
        }

        render(payload, target){
            const word = payload?.word || {};
            const times = this.normalizeTimes(payload?.timeType);

            if (!word.value) {
                const err = `<div class="mc-conj"><b>Error:</b> falta <code>word.value</code></div>`;
                if (target) $(target).html(err);
                return { ok:false, error:"Falta word.value", html: err };
            }

            const w = {
                value: String(word.value).trim(),
                translation_value: String(word.translation_value || "").trim(),
                dictionary_grammatical_class_name: String(word.dictionary_grammatical_class_name || "").trim()
            };

            const html = times.map(t=>this.renderCard(w, t)).join("\n");
            if (target) $(target).html(html);

            return { ok:true, times, word: w, html };
        }

        escape(s){
            return String(s ?? "")
                .replaceAll("&","&amp;")
                .replaceAll("<","&lt;")
                .replaceAll(">","&gt;")
                .replaceAll('"',"&quot;")
                .replaceAll("'","&#039;");
        }
    }

    // ✅ jQuery helper
    (function($){
        $.mcConjugate = function(payload, targetSelector, options){
            const ui = new MCConjugatorUI(options || {});
            return ui.render(payload, targetSelector);
        };
    })(jQuery);

</script>
<script>
    /**
     * MorphemeGlossaryPlugin (refactor)
     * Flujo:
     * 1) initPayload(payload)
     * 2) generateData(word)
     * 3) generateHtml(data)
     * (opcional) render(word)
     */
    (function (global) {
        "use strict";

        // ---------------------------
        // Utils
        // ---------------------------
        const Str = {
            norm(s) { return String(s ?? "").trim(); },
            lower(s) { return Str.norm(s).toLowerCase(); },
            stripHyphens(morphemeForm) { return Str.norm(morphemeForm).replace(/-/g, ""); },
        };

        const Arr = {
            groupBy(list, keyFn) {
                return (list || []).reduce((acc, item) => {
                    const k = keyFn(item);
                    (acc[k] ||= []).push(item);
                    return acc;
                }, {});
            },
            sortBy(list, cmpFn) { return [...(list || [])].sort(cmpFn); },
        };

        function escapeHtml(s) {
            return String(s ?? "")
                .replaceAll("&", "&amp;")
                .replaceAll("<", "&lt;")
                .replaceAll(">", "&gt;")
                .replaceAll('"', "&quot;")
                .replaceAll("'", "&#039;");
        }

        // ---------------------------
        // Index Builder
        // ---------------------------
        function buildIndex(items, { includeInactive = false } = {}) {
            const filtered = (items || []).filter((x) => {
                if (includeInactive) return true;
                return String(x?.status || "ACTIVE") === "ACTIVE";
            });

            const byForm = Arr.groupBy(filtered, (x) => Str.norm(x.morpheme_form));
            const forms = Object.keys(byForm);

            const suffixForms = forms
                .filter((f) => f.startsWith("-") && !f.endsWith("-"))
                .sort((a, b) => Str.stripHyphens(b).length - Str.stripHyphens(a).length);

            const infixForms = forms
                .filter((f) => f.startsWith("-") && f.endsWith("-"))
                .sort((a, b) => Str.stripHyphens(b).length - Str.stripHyphens(a).length);

            return { byForm, suffixForms, infixForms };
        }

        // ---------------------------
        // Function selector (morfema ambiguo)
        // ---------------------------
        function pickFunction(functionList, opts, morphemeForm) {
            const list = functionList || [];
            if (!list.length) return null;

            // 1) preferencia explícita por morfema
            const preferred = opts.preferFunctionCode || {};
            const targetCode = preferred[morphemeForm];
            if (targetCode) {
                const hit = list.find((x) => x.function_code === targetCode);
                if (hit) return hit;
            }

            // 2) display_order menor primero, luego id
            return Arr.sortBy(list, (a, b) => {
                const da = Number(a.display_order ?? 9999);
                const db = Number(b.display_order ?? 9999);
                if (da !== db) return da - db;
                return Number(a.id ?? 0) - Number(b.id ?? 0);
            })[0];
        }

        // ---------------------------
        // Core parser helpers
        // ---------------------------
        function findSuffixMatch(remainingWord, suffixForms) {
            for (const form of suffixForms) {
                const surface = Str.stripHyphens(form);
                if (!surface) continue;
                if (remainingWord.endsWith(surface)) return { morpheme_form: form, surface };
            }
            return null;
        }

        function detectInfixes(wordLower, index, opts) {
            if (!opts.detectInfixes) return [];
            const out = [];

            for (const infixForm of index.infixForms) {
                const surface = Str.stripHyphens(infixForm);
                if (!surface) continue;

                // Detección simple: contiene la secuencia
                if (wordLower.includes(surface)) {
                    const fn = pickFunction(index.byForm[infixForm], opts, infixForm);
                    if (fn) {
                        out.push({
                            morpheme_form: infixForm,
                            surface,
                            function: fn,
                            position: "INFIX",
                        });
                    }
                }
            }
            return out;
        }

        // ---------------------------
        // Public API: initPayload / generateData / generateHtml
        // ---------------------------
        class MorphemeGlossaryPlugin {
            constructor(options = {}) {
                this.opts = {
                    includeInactive: false,
                    detectInfixes: true,
                    preferFunctionCode: {}, // { "-chu": "INTERROGATIVE_YN" }
                    ...options,
                };

                this.payload = [];
                this.index = buildIndex([], { includeInactive: this.opts.includeInactive });

                // estilos opcionales (puedes desactivarlo)
                if (this.opts.injectStyles !== false) this.injectDefaultStylesOnce();
            }

            // 1) INIT PAYLOAD
            initPayload(payloadArray) {
                this.payload = payloadArray || [];
                this.index = buildIndex(this.payload, { includeInactive: this.opts.includeInactive });
                return this;
            }

            // 2) GENERATE DATA (solo JSON)
            generateData(wordRaw) {
                const word = Str.norm(wordRaw);
                const w = Str.lower(word);

                const data = {
                    word,
                    root: word,
                    morphemes: [],     // morfemas detectados con card
                    unknownTail: "",   // reservado por si luego metes reglas
                };

                if (!word) return data;

                // a) infijos (ej -wa-)
                const infixes = detectInfixes(w, this.index, this.opts);

                // b) sufijos desde el final
                let remaining = w;
                const foundSuffixes = [];

                while (true) {
                    const match = findSuffixMatch(remaining, this.index.suffixForms);
                    if (!match) break;
                    foundSuffixes.push(match);
                    remaining = remaining.slice(0, remaining.length - match.surface.length);
                    if (!remaining) break;
                }

                foundSuffixes.reverse();

                const suffixes = foundSuffixes
                    .map((m) => {
                        const fn = pickFunction(this.index.byForm[m.morpheme_form], this.opts, m.morpheme_form);
                        if (!fn) return null;
                        return {
                            morpheme_form: m.morpheme_form,
                            surface: m.surface,
                            function: fn,
                            position: "SUFFIX_OR_ENCLITIC",
                        };
                    })
                    .filter(Boolean);

                data.root = remaining || "";
                data.morphemes = [...infixes, ...suffixes];

                // Si quieres mantener el orden “solo sufijos primero” o “orden real”, aquí decides.
                // Por defecto: infijos primero, luego sufijos.

                return data;
            }

            // 3) GENERATE HTML (solo string)

            generateHtml(data) {
                const rows = (data.morphemes || [])
                    .filter((x) => x.function && x.function.card)
                    .map((x) => {
                        const c = x.function.card || {};
                        return {
                            morpheme_form: x.morpheme_form,
                            what_is_es: c.what_is_es || "",
                            for_what_es: c.for_what_es || "",
                            formula_es: c.formula_es || "",
                            use_es: c.use_es || "",
                        };
                    });

                // sin filas
                if (!rows.length) {
                    return `
      <div class="mg">
        <table class="mg__table">
          <tr>
            <th class="mg__th mg__th--label">Palabra</th>
            <td class="mg__td mg__td--word" colspan="5">${escapeHtml(data.word)}</td>
          </tr>

          <tr>
            <th class="mg__th">Morfema</th>
            <th class="mg__th">🔎 ¿Qué es?</th>
            <th class="mg__th">🎯 ¿Para qué sirve?</th>
            <th class="mg__th">🧠 Fórmula</th>
            <th class="mg__th">📌 Uso</th>
            <th class="mg__th">Raíz</th>
          </tr>

          <tr>
            <td class="mg__cell" colspan="6">No se detectaron morfemas (o no están en tu dataset).</td>
          </tr>
        </table>
      </div>
    `;
                }

                const rowspan = rows.length;

                const rowsHtml = rows.map((r, i) => {
                    const rootTd = (i === 0)
                        ? `<td class="mg__cell mg__cell--root" rowspan="${rowspan}">${escapeHtml(data.root)}</td>`
                        : "";

                    return `
      <tr class="mg__row">
        <td class="mg__cell mg__cell--morpheme">${escapeHtml(r.morpheme_form)}</td>
        <td class="mg__cell">${escapeHtml(r.what_is_es)}</td>
        <td class="mg__cell">${escapeHtml(r.for_what_es)}</td>
        <td class="mg__cell">${escapeHtml(r.formula_es)}</td>
        <td class="mg__cell">${escapeHtml(r.use_es)}</td>
        ${rootTd}
      </tr>
    `;
                }).join("");

                return `
    <div class="mg">
      <table class="mg__table">
        <tr>
          <th class="mg__th mg__th--label">Palabra</th>
          <td class="mg__td mg__td--word" colspan="5">${escapeHtml(data.word)}</td>
        </tr>

        <!-- Opcional: header como tu imagen -->
        <tr>
          <th class="mg__th"></th>
          <th class="mg__th mg__th--section" colspan="4">Función/Estructural</th>
          <th class="mg__th"></th>
        </tr>

        <tr>
          <th class="mg__th">Morfema</th>
          <th class="mg__th">🔎 ¿Qué es?</th>
          <th class="mg__th">🎯 ¿Para qué sirve?</th>
          <th class="mg__th">🧠 Fórmula</th>
          <th class="mg__th">📌 Uso</th>
          <th class="mg__th">Raíz</th>
        </tr>

        ${rowsHtml}
      </table>
    </div>
  `;
            }

            // (opcional) helper: render completo en un contenedor
            renderTo(container, word) {
                const el = typeof container === "string" ? document.querySelector(container) : container;
                if (!el) throw new Error("renderTo: container no encontrado.");
                const data = this.generateData(word);
                const html = this.generateHtml(data);
                el.innerHTML = html;
                return { data, html };
            }

            // ---------------------------
            // Styles
            // ---------------------------
            injectDefaultStylesOnce() {
                if (document.getElementById("mgStyles")) return;
                const style = document.createElement("style");
                style.id = "mgStyles";
                style.textContent = `
        .mg{ width:100%; }
        .mg__table{ width:100%; border-collapse:collapse; font-family:system-ui,Segoe UI,Roboto,Arial; }
        .mg__th,.mg__cell,.mg__td{ border:1px solid #222; padding:10px; vertical-align:top; }
        .mg__th{ background:#f7f7f7; font-weight:800; }
        .mg__th--label{ width:140px; }
        .mg__td--word{ font-weight:800; color:#198754; }
        .mg__cell--morpheme{ width:120px; font-weight:800; }
        .mg__cell--root{ width:140px; font-weight:800; color:#198754; }
      `;
                document.head.appendChild(style);
            }
        }

        // Export
        global.MorphemeGlossaryPlugin = MorphemeGlossaryPlugin;
    })(window);

</script>
