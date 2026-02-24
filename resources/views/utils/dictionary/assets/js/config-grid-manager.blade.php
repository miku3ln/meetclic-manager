<script>


    /**
     * DictionaryPronunciationPlugin.js
     * ============================================
     * Usa el payload que sale de PronunciationPayloadUtil::buildPayload()
     * y genera:
     *  - custom (normalizado)
     *  - lectura
     *  - ipa (base fonémico)
     *  - ipa_contextual (asimilación / sonorización / excepciones WORD)
     *  - silabificación + estructura (CV/VC/CVC por sílaba)
     *  - variantes (opcional, por reglas is_optional y/o por región)
     *
     * NOTA: Este plugin asume que:
     *  - payload.phonology_rules[].items[] ya trae match_scope y toponym_abbr (como ya lo ajustaste)
     *  - payload.phonemes está ordenado (token_priority + largo desc) como tú lo haces en SQL
     *  - Las reglas importantes existen por code:
     *      CONVENTIONAL_SIGNS_TO_READING (rule_id=1)
     *      READING_TO_CONVENTIONAL_SIGNS (rule_id=2)
     *      IPA_PHONEMIC_BASE (rule_id=3)
     *      NASAL_ASSIMILATION_CONTEXT (rule_id=4)
     *      VOICING_AFTER_NASAL (rule_id=9)
     *      SPORADIC_PHENOMENA (rule_id=7) (WORD)
     *      OPTIONAL_ALTERNATIONS_BY_ZONE (rule_id=10) (is_optional=1)
     *
     * Uso:
     *  const plugin = DictionaryPronunciationPlugin(payload);
     *  const res = plugin.generate("tantachiy", { toponym_abbr: "sc", include_variants: true });
     *  console.log(res);
     */
    function DictionaryPronunciationPlugin(payload) {
        if (!payload || typeof payload !== "object") {
            throw new Error("payload inválido");
        }

        // ---------- Indexación rápida ----------
        const ruleByCode = new Map();
        const ruleById = new Map();
        (payload.phonology_rules || []).forEach((r) => {
            ruleById.set(Number(r.id), r);
            ruleByCode.set(String(r.code), r);
        });

        // phonemes ya vienen ordenados desde DB (token_priority desc, length desc)
        const phonemes = (payload.phonemes || []).map((p) => ({
            ...p,
            phoneme: String(p.phoneme),
            category: String(p.category),
        }));

        // Para silabificación: vocales y semivocales
        const VOWELS = new Set(["a", "i", "u"]);
        const SEMIVOWELS = new Set(["w", "y"]);

        // ---------- Helpers ----------
        function toStr(x) {
            return (x ?? "").toString();
        }

        function clone(obj) {
            return JSON.parse(JSON.stringify(obj));
        }

        function normalizeInputWord(word) {
            // Normalización mínima: trim + lower, pero respeta letras especiales (č, š, ž, ŋ, R, ly)
            // Ojo: R es mayúscula (convención), así que NO lowercases todo ciegamente.
            // Estrategia: trim + normalizar espacios
            return toStr(word).trim().replace(/\s+/g, "");
        }

        // Aplica reemplazos tipo string global (sin regex) con prioridad por sort_order, y match_scope GLOBAL
        function applyGlobalStringRules(text, items) {
            let out = text;
            // items ya vienen ordenados en payload (sort_order,id)
            for (const it of items) {
                const pat = toStr(it.pattern);
                const rep = toStr(it.replacement);
                if (!pat) continue;

                // match_scope GLOBAL: reemplazo simple global (split/join para evitar regex)
                out = out.split(pat).join(rep);
            }
            return out;
        }

        // WORD rules: pattern se trata como regex string del SQL (ej ^tanta$)
        // Solo se aplican si match exacto (por regex), y match_scope WORD
        function applyWordRules(word, items, opts) {
            // prioridad items (sort_order,id)
            let out = word;
            const applied = [];
            for (const it of items) {
                const pat = toStr(it.pattern);
                const rep = toStr(it.replacement);
                if (!pat) continue;

                // filtros de región para WORD opcionales (si quieres)
                if (!passesToponymFilter(it, opts)) continue;

                let re;
                try {
                    re = new RegExp(pat, "u"); // unicode
                } catch {
                    // si no es regex válido, ignorar
                    continue;
                }

                if (re.test(out)) {
                    const next = out.replace(re, rep);
                    if (next !== out) {
                        applied.push({
                            rule_item_id: Number(it.id),
                            pattern: pat,
                            replacement: rep,
                            before: out,
                            after: next,
                            is_optional: !!it.is_optional,
                            weight: Number(it.weight ?? 100),
                            toponym_abbr: it.toponym_abbr ?? null,
                        });
                        out = next;
                    }
                }
            }
            return {value: out, applied};
        }

        // Tokenizador greedy por phonemes (ya ordenados por prioridad + largo)
        function tokenizeCustom(wordCustom) {
            const s = wordCustom;
            const tokens = [];
            let i = 0;

            while (i < s.length) {
                let matched = null;

                for (const ph of phonemes) {
                    const p = ph.phoneme;
                    if (!p) continue;
                    if (s.startsWith(p, i)) {
                        matched = p;
                        break; // greedy: el primero ya es el de mayor prioridad/largo
                    }
                }

                if (!matched) {
                    // si no calza con ningún fonema, tomamos un char como "unknown"
                    tokens.push({t: s[i], category: "UNKNOWN", unknown: true});
                    i += 1;
                    continue;
                }

                // buscar categoría del phoneme
                const phObj = phonemes.find((x) => x.phoneme === matched);
                tokens.push({
                    t: matched,
                    category: phObj?.category || "UNKNOWN",
                    unknown: false,
                });
                i += matched.length;
            }
            return tokens;
        }

        // Aplica TOKEN rules con contexto apply_when_before/after sobre lista de tokens
        // match_scope TOKEN
        function applyTokenRules(tokens, items, opts) {
            const out = tokens.map((x) => ({...x}));
            const applied = [];

            for (const it of items) {
                if (toStr(it.match_scope) !== "TOKEN") continue;
                if (!passesToponymFilter(it, opts)) continue;

                const pat = toStr(it.pattern);
                const rep = toStr(it.replacement);
                if (!pat) continue;

                const beforeCond = it.apply_when_before ? new RegExp(`^(?:${it.apply_when_before})$`, "u") : null;
                const afterCond = it.apply_when_after ? new RegExp(`^(?:${it.apply_when_after})$`, "u") : null;

                for (let idx = 0; idx < out.length; idx++) {
                    const cur = out[idx]?.t;

                    if (cur !== pat) continue;

                    const prev = idx > 0 ? out[idx - 1].t : null;
                    const next = idx < out.length - 1 ? out[idx + 1].t : null;

                    if (beforeCond && !beforeCond.test(toStr(prev))) continue;
                    if (afterCond && !afterCond.test(toStr(next))) continue;

                    // aplica reemplazo en el token actual
                    out[idx] = {...out[idx], t: rep};

                    applied.push({
                        rule_item_id: Number(it.id),
                        pattern: pat,
                        replacement: rep,
                        index: idx,
                        context_prev: prev,
                        context_next: next,
                        is_optional: !!it.is_optional,
                        weight: Number(it.weight ?? 100),
                        toponym_abbr: it.toponym_abbr ?? null,
                    });
                }
            }

            return {tokens: out, applied};
        }

        // Mapea tokens custom -> IPA base (rule_id=3 items TOKEN)
        // En tu DB rule_id=3 ya mapea token->ipa (t͡ʃ, ʃ, ɲ, ʎ, ɾ, etc.)
        function mapTokensWithRuleItems(tokens, items, opts) {
            const map = new Map();
            for (const it of items) {
                if (toStr(it.match_scope) !== "TOKEN") continue;
                if (!passesToponymFilter(it, opts)) continue;
                map.set(toStr(it.pattern), toStr(it.replacement));
            }

            const out = tokens.map((tk) => {
                const repl = map.get(toStr(tk.t));
                if (repl == null) return {...tk, out: toStr(tk.t), unmapped: true};
                return {...tk, out: repl, unmapped: false};
            });

            return out;
        }

        // Filtrado de reglas por región:
        // - si opts.toponym_abbr existe:
        //    - acepta items con toponym_abbr null (genérico) + items con ese abbr
        //    - si hay conflicto, tu motor puede priorizar el específico por weight/sort_order
        // - si no hay toponym_abbr:
        //    - solo items con toponym_abbr null
        function passesToponymFilter(item, opts) {
            const itemTop = item.toponym_abbr ?? null;
            const wantTop = opts?.toponym_abbr ?? null;

            if (!wantTop) return itemTop == null; // sin región => solo genérico
            return itemTop == null || String(itemTop) === String(wantTop);
        }

        // Silabificación simple para Kichwa (a,i,u + semivocales y,w)
        // Devuelve sílabas con estructura V/CV/VC/CVC
        function syllabifyFromTokens(tokens) {
            // tokens son custom (no IPA), con category CONSONANT/SEMIVOWEL/VOWEL
            const tks = tokens.map((x) => x.t);

            // helper: vocal?
            const isVowel = (tok) => VOWELS.has(tok);
            const isSemi = (tok) => SEMIVOWELS.has(tok);
            const isCons = (tok) => !isVowel(tok) && !isSemi(tok);

            const syllables = [];
            let i = 0;

            while (i < tks.length) {
                // Estrategia:
                // - Encuentra núcleo vocálico (V)
                // - Construye onset (C opcional) + nucleus (V) + coda (C opcional) según lookahead
                // Kichwa suele CV/CVC/VC/V; evitamos clusters complicados.

                // Si inicia con vocal => onset vacío
                let onset = [];
                let nucleus = null;
                let coda = [];

                // onset: 0..1 consonante (si hay)
                if (i < tks.length && isCons(tks[i]) && !isVowel(tks[i])) {
                    onset.push(tks[i]);
                    i++;
                }

                // nucleus: debe ser vocal; si no hay, rompe por seguridad
                if (i < tks.length && isVowel(tks[i])) {
                    nucleus = tks[i];
                    i++;
                } else if (i < tks.length && isSemi(tks[i])) {
                    // semivocal sin vocal inmediata (caso raro) => la tratamos como consonante para no perderla
                    onset.push(tks[i]);
                    i++;
                    continue;
                } else {
                    // token desconocido o consonante sin vocal: sílaba de arrastre
                    const stray = tks[i];
                    syllables.push({syl: stray, structure: "C", tokens: [stray]});
                    i++;
                    continue;
                }

                // coda: opcional 1 consonante si:
                // - al final, o
                // - la siguiente es consonante y después hay vocal (para formar CVC + CV)
                if (i < tks.length && isCons(tks[i])) {
                    const nextC = tks[i];
                    const after = tks[i + 1] ?? null;

                    // si después del C viene vocal => preferimos dejar la consonante como onset de la siguiente sílaba
                    if (after && isVowel(after)) {
                        // no coda
                    } else {
                        coda.push(nextC);
                        i++;
                    }
                }

                const tokensSyl = [...onset, nucleus, ...coda];
                const syl = tokensSyl.join("");

                const structure =
                    (onset.length ? "C" : "") +
                    "V" +
                    (coda.length ? "C" : "");

                syllables.push({syl, structure, tokens: tokensSyl});
            }

            // Normaliza estructuras para que solo sean V/CV/VC/CVC cuando aplique
            return syllables.map((s) => {
                let code = s.structure;
                if (code === "V") return s;
                if (code === "CV") return s;
                if (code === "VC") return s;
                if (code === "CVC") return s;
                // fallback
                return {...s, structure: code};
            });
        }

        function joinIpa(mappedTokens) {
            // IPA se devuelve concatenado sin espacios
            return mappedTokens.map((x) => x.out).join("");
        }

        // Obtiene rule por code (si no existe, devuelve null)
        function getRule(code) {
            return ruleByCode.get(code) || null;
        }

        // Obtiene items de una rule y filtra activos y por scope
        function getRuleItems(rule, scope /* optional */) {
            if (!rule) return [];
            const items = Array.isArray(rule.items) ? rule.items : [];
            if (!scope) return items;
            return items.filter((it) => toStr(it.match_scope) === scope);
        }

        // Genera variantes por reglas opcionales (is_optional=1) en GLOBAL o TOKEN
        function generateOptionalVariants(baseCustom, opts) {
            const variantsOut = [];

            // Reglas opcionales: típicamente rule_id=10 (OPTIONAL_ALTERNATIONS_BY_ZONE)
            // También podrías usar items con is_optional=1 de otras rules.
            const allOptionalItems = [];
            for (const r of (payload.phonology_rules || [])) {
                for (const it of (r.items || [])) {
                    if (!it.is_optional) continue;
                    // filtro por región
                    if (!passesToponymFilter(it, opts)) continue;
                    allOptionalItems.push({rule_code: r.code, rule_id: r.id, item: it});
                }
            }

            // Para no explotar combinatoriamente:
            // Genera variantes de "1 cambio" (single-step), suficiente para UI.
            for (const pack of allOptionalItems) {
                const it = pack.item;
                const scope = toStr(it.match_scope);

                if (scope === "GLOBAL") {
                    const pat = toStr(it.pattern);
                    const rep = toStr(it.replacement);
                    if (!pat) continue;

                    const changed = baseCustom.includes(pat) ? baseCustom.split(pat).join(rep) : baseCustom;
                    if (changed === baseCustom) continue;

                    variantsOut.push({
                        type: "optional_rule",
                        rule_code: pack.rule_code,
                        rule_id: Number(pack.rule_id),
                        rule_item_id: Number(it.id),
                        toponym_abbr: it.toponym_abbr ?? null,
                        weight: Number(it.weight ?? 100),
                        scope: "GLOBAL",
                        result_custom: changed,
                    });
                }

                if (scope === "WORD") {
                    // WORD opcional (si tuvieras) => regex
                    const pat = toStr(it.pattern);
                    const rep = toStr(it.replacement);
                    let re;
                    try {
                        re = new RegExp(pat, "u");
                    } catch {
                        continue;
                    }
                    if (!re.test(baseCustom)) continue;
                    const changed = baseCustom.replace(re, rep);
                    if (changed === baseCustom) continue;

                    variantsOut.push({
                        type: "optional_rule",
                        rule_code: pack.rule_code,
                        rule_id: Number(pack.rule_id),
                        rule_item_id: Number(it.id),
                        toponym_abbr: it.toponym_abbr ?? null,
                        weight: Number(it.weight ?? 100),
                        scope: "WORD",
                        result_custom: changed,
                    });
                }

                if (scope === "TOKEN") {
                    const toks = tokenizeCustom(baseCustom);
                    const {tokens: t2} = applyTokenRules(toks, [it], opts);
                    const changed = t2.map((x) => x.t).join("");
                    if (changed === baseCustom) continue;

                    variantsOut.push({
                        type: "optional_rule",
                        rule_code: pack.rule_code,
                        rule_id: Number(pack.rule_id),
                        rule_item_id: Number(it.id),
                        toponym_abbr: it.toponym_abbr ?? null,
                        weight: Number(it.weight ?? 100),
                        scope: "TOKEN",
                        result_custom: changed,
                    });
                }
            }

            // orden por peso desc, luego rule_item_id
            variantsOut.sort((a, b) => (b.weight - a.weight) || (a.rule_item_id - b.rule_item_id));
            return variantsOut;
        }

        // ---------- Núcleo: generate(word, opts) ----------
        function generate(word, opts = {}) {
            const options = {
                toponym_abbr: opts.toponym_abbr ?? null,
                include_variants: !!opts.include_variants,
            };

            const input = normalizeInputWord(word);

            // 0) BaseCustom = input (se asume viene en "lectura" o "custom", no sabemos)
            //    Primero normalizamos "lectura -> custom" (rule 2).
            const ruleReadingToCustom = getRule("READING_TO_CONVENTIONAL_SIGNS");
            const readingToCustomItems = (ruleReadingToCustom?.items || []).filter((it) => toStr(it.match_scope) === "GLOBAL");
            const customNormalized = applyGlobalStringRules(input, readingToCustomItems);

            // 1) Excepciones WORD (SPORADIC_PHENOMENA) sobre custom
            const ruleSporadic = getRule("SPORADIC_PHENOMENA");
            const sporadicWordItems = (ruleSporadic?.items || []).filter((it) => toStr(it.match_scope) === "WORD");
            const sporadicRes = applyWordRules(customNormalized, sporadicWordItems, options);
            const customAfterWord = sporadicRes.value;

            // 2) Lectura: custom -> lectura (rule 1)
            const ruleCustomToReading = getRule("CONVENTIONAL_SIGNS_TO_READING");
            const customToReadingItems = (ruleCustomToReading?.items || []).filter((it) => toStr(it.match_scope) === "GLOBAL");
            const lectura = applyGlobalStringRules(customAfterWord, customToReadingItems);

            // 3) IPA base: tokenizar custom y mapear por IPA_PHONEMIC_BASE (rule 3)
            const ruleIpaBase = getRule("IPA_PHONEMIC_BASE");
            const ipaBaseItems = (ruleIpaBase?.items || []).filter((it) => toStr(it.match_scope) === "TOKEN");
            const tokensCustom = tokenizeCustom(customAfterWord);
            const mappedBase = mapTokensWithRuleItems(tokensCustom, ipaBaseItems, options);
            const ipa = joinIpa(mappedBase);

            // 4) IPA contextual:
            //    a) aplicar NASAL_ASSIMILATION_CONTEXT (rule 4) en tokens custom
            //    b) aplicar VOICING_AFTER_NASAL (rule 9) en tokens custom
            //    c) volver a mapear a IPA base (rule 3)
            const ruleAssim = getRule("NASAL_ASSIMILATION_CONTEXT");
            const assimItems = (ruleAssim?.items || []).filter((it) => toStr(it.match_scope) === "TOKEN");

            const ruleVoicing = getRule("VOICING_AFTER_NASAL");
            const voicingItems = (ruleVoicing?.items || []).filter((it) => toStr(it.match_scope) === "TOKEN");

            let tokensCtx = tokenizeCustom(customAfterWord);
            const assimApplied = applyTokenRules(tokensCtx, assimItems, options);
            tokensCtx = assimApplied.tokens;

            const voicingApplied = applyTokenRules(tokensCtx, voicingItems, options);
            tokensCtx = voicingApplied.tokens;

            const mappedCtx = mapTokensWithRuleItems(tokensCtx, ipaBaseItems, options);
            const ipa_contextual = joinIpa(mappedCtx);

            // 5) Silabificación + estructura usando tokens custom (post WORD, pre context)
            const syllables = syllabifyFromTokens(tokensCustom);

            // 6) Variantes opcionales (single-step)
            let variants = [];
            if (options.include_variants) {
                const baseVariants = generateOptionalVariants(customAfterWord, options);

                // Enriquecer cada variante con lectura/ipa/ipa_contextual/syllables también
                variants = baseVariants.map((v) => {
                    const vCustom = v.result_custom;

                    // lectura
                    const vLectura = applyGlobalStringRules(vCustom, customToReadingItems);

                    // IPA base
                    const vTokens = tokenizeCustom(vCustom);
                    const vMappedBase = mapTokensWithRuleItems(vTokens, ipaBaseItems, options);
                    const vIpa = joinIpa(vMappedBase);

                    // IPA contextual
                    let vTokensCtx = tokenizeCustom(vCustom);
                    vTokensCtx = applyTokenRules(vTokensCtx, assimItems, options).tokens;
                    vTokensCtx = applyTokenRules(vTokensCtx, voicingItems, options).tokens;
                    const vMappedCtx = mapTokensWithRuleItems(vTokensCtx, ipaBaseItems, options);
                    const vIpaCtx = joinIpa(vMappedCtx);

                    // syllables
                    const vSyll = syllabifyFromTokens(vTokens);

                    return {
                        ...v,
                        result_lectura: vLectura,
                        result_ipa: vIpa,
                        result_ipa_contextual: vIpaCtx,
                        syllables: vSyll,
                    };
                });
            }

            return {
                input,
                options: clone(options),

                // ✅ lo que pediste:
                custom: customAfterWord,
                lectura,
                ipa,
                ipa_contextual,

                syllables, // [{syl, structure, tokens}]
                variants,

                // info técnica opcional (útil para debug)
                debug: {
                    word_rules_applied: sporadicRes.applied,
                    tokenization_custom: tokensCustom.map((t) => t.t),
                    contextual_rules_applied: {
                        assimilation: assimApplied.applied,
                        voicing: voicingApplied.applied,
                    },
                },
            };
        }

        return {
            generate,
            // expone payload por si quieres inspeccionar
            payload,
        };
    }

    function buildPronunciationsFromResult(r1) {
        const items = [];

        // prioridad (primero el que "lee la gente")
        if (r1.reading_natural) items.push({
            phonetic_value: r1.reading_natural,
            notation_type: 'reading_natural',
            isMain: true
        });
        if (r1.lectura) items.push({phonetic_value: r1.lectura, notation_type: 'lectura', isMain: false});
        if (r1.ipa_contextual) items.push({
            phonetic_value: r1.ipa_contextual,
            notation_type: 'ipa_contextual',
            isMain: false
        });
        if (r1.ipa) items.push({phonetic_value: r1.ipa, notation_type: 'ipa', isMain: false});
        if (r1.custom) items.push({phonetic_value: r1.custom, notation_type: 'custom', isMain: false});

        // quitar duplicados por valor (ej: reading_natural == lectura)
        const seen = new Set();
        items.filter(x => {
            const v = String(x.phonetic_value ?? '').trim();
            if (!v) return false;
            if (seen.has(v)) return false;
            seen.add(v);
            return true;
        })

        var result = items;
        console.log(result);
        return result;
    }

    function initConvertLanguage() {
        return DictionaryPronunciationPlugin($pronunciationPayManagement);
    }

    function toReadingNatural(text) {
        if (text == null) return text;
        let s = String(text).trim();
        if (!s) return s;

        // Normaliza ligaduras IPA: t͡ʃ / t͜ʃ / tʃ
        s = s.replace(/t[͜͡]?ʃ/g, "ch");
        s = s.replace(/d[͜͡]?ʒ/g, "zh");
        s = s.replace(/t[͜͡]?s/g, "ts");

        // Consonantes IPA -> lectura
        s = s.replace(/ʃ/g, "sh")
            .replace(/ʒ/g, "zh")
            .replace(/ɲ/g, "ñ")
            .replace(/ʎ/g, "ll")
            .replace(/j/g, "y")
            .replace(/w/g, "w");

        // ŋ contextual:
        // - antes de k/g/q => "ng"
        // - antes de d/t => "n" (para que taŋda => tanda)
        // - caso general => "n"
        s = s.replace(/ŋ(?=[kgq])/g, "ng");
        s = s.replace(/ŋ(?=[dt])/g, "n");
        s = s.replace(/ŋ/g, "n");

        // Vocales raras IPA -> vocal simple
        s = s.replace(/ɐ/g, "a")
            .replace(/ə/g, "a");

        // Quitar diacríticos combinantes y marcas IPA
        s = s.replace(/[\u0300-\u036f]/g, "");
        s = s.replace(/[ˈˌːʰˑʲ]/g, "");
        s = s.replace(/[\[\]]/g, "");
        s = s.replace(/\s+/g, " ").trim();

        return s;
    }

    var ICON_CONFIG = {
        "bs5": {
            ICON_BASE: "bi ",
            ICON_AUDIO_PLAY: " bi-volume-up",
            ICON_DROPDOWN_OPEN: "bi-chevron-down",
            ICON_DROPDOWN_CLOSE: "bi-chevron-up",
            ICON_CONTENT_BOOK: "bi-book",
            ICON_INFO: "bi-info-circle",
            ICON_COMMENT: "bi-chat-dots",
            ICON_CHEVRON_UP: "bi-chevron-up",
            ICON_CHEVRON_DOWN: "bi-chevron-down",

        },
        "bs": {
            ICON_BASE: "glyphicon ",
            ICON_AUDIO_PLAY: "  glyphicon-volume-up",
            ICON_DROPDOWN_OPEN: "glyphicon-volume-up",
            ICON_DROPDOWN_CLOSE: "glyphicon-volume-down",
            ICON_CONTENT_BOOK: "glyphicon-book",
            ICON_INFO: "glyphicon-info-sign",
            ICON_COMMENT: "glyphicon-comment",
            ICON_CHEVRON_UP: "glyphicon-chevron-up",
            ICON_CHEVRON_DOWN: "glyphicon-chevron-down",

        }


    };

    function getValueConvert(params) {
        const r1 = serviceConverLanguage.generate(params);
        r1.reading_natural = toReadingNatural(r1.ipa_contextual);
        return r1;
    }

    function initGridManagementDictionary(params) {

        var {$scope, gridName, urlCurrent, typeBS} = params;


        var configIcons = null;
        if (typeBS == "bs5") {
            configIcons = ICON_CONFIG.bs5;
        } else {
            configIcons = ICON_CONFIG.bs;

        }
        var vmCurrent = $scope;
        var formatters = formattersGridDictionary({$scope: $scope, typeBS: typeBS});
        var paramsFilters = $scope.getTypeDictionary();
        var overWritePost = function (request) {
            var paramsFilters = $scope.getTypeDictionary();
            var result = {filters: paramsFilters};
            return result;
        };

        var iconRefresh = 'glyphicon glyphicon-refresh adad';
        var labels = {search: 'Busque una palabra '};

        if (typeBS == "bs5") {
            iconRefresh = "bi bi-arrow-clockwise";

        }
        let gridInit = initGridManager({
            typeBS: typeBS,
            gridNameSelector: gridName,
            paramsFilters: paramsFilters,
            formatters: formatters,
            'urlCurrent': urlCurrent,
            'iconRefresh': iconRefresh,
            'labels': labels,
            overWritePost: overWritePost

        });
        gridInit.on("loaded.rs.jquery.bootgrid", function () {
            vmCurrent._resetManagerGrid();
            vmCurrent._gridManager(gridInit);
            var fieldsViewObject = $('.actions.btn-group').find('.dropdown')[1];
            $(fieldsViewObject).hide();
            $('.btn--manager-sound').off('click');

            $('.btn--manager-sound').on('click', function () {
                console.log('--------------------------------------');
                var audioPlayerId = $(this).attr('audio-player');
                var selectorCurrent = 'audioPlayer' + audioPlayerId;
                var audio = document.getElementById(selectorCurrent);
                managerAudio({audio: audio});
            });

            $(".word-card__item--main").on("click", function () {
                var id = $(this).attr("id");
                console.log(this, id);
                var setIcon = configIcons.ICON_CHEVRON_DOWN;
                var selectorItemsSetClass = "not-view";
                var selectorItems = "." + id;
                if ($(this).find("i").hasClass(configIcons.ICON_CHEVRON_DOWN)) {
                    setIcon = configIcons.ICON_CHEVRON_UP;
                    $(selectorItems).removeClass("not-view");
                    $(this).find("i").removeClass(configIcons.ICON_CHEVRON_DOWN);
                    selectorItemsSetClass = "";
                } else {
                    $(this).find("i").removeClass(configIcons.ICON_CHEVRON_UP);

                }
                console.log("aadad");
                $(this).find("i").addClass(setIcon);
                $(selectorItems).addClass(selectorItemsSetClass);

            });
        });
    }

    function formattersGridDictionary(params) {
        var {$scope, typeBS} = params;

        var configIcons = null;
        if (typeBS == "bs5") {
            configIcons = ICON_CONFIG.bs5;
        } else {
            configIcons = ICON_CONFIG.bs;

        }

        return {
            'value': function (column, row) {
                var classStatus = "badge-success";
                if (row.status == "INACTIVE") {
                    classStatus = "badge-warning"
                }
                var photosData = [];
                if (row.photos) {
                    photosData.push("<div class='content-description__photos'>");
                    $.each(row.photos, function (i, v) {
                        var sourceCurrent = $publicAsset + v.source;
                        var photoCurrent = [

                            '<img  class=" content-description__photos--img" src="' + sourceCurrent + '" alt="">'

                        ];
                        photosData.push(photoCurrent.join(""));
                    });

                    photosData.push("</div>");

                }

                var audioData = [];
                var allowPlayMain = false;
                var idPlayMain = false;
                var playStructure = [];
                var allowListen = false;
                console.log("row.audios", row.audios);
                var dataAudio=null;
                if (row.audios) {
                    audioData.push("<div class='content-description__audios'>");
                    var countMain = 0;
                    $.each(row.audios, function (i, v) {
                        if (countMain == 0) {

                            allowPlayMain = true;
                            playStructure = [
                                '  <a  class="btn btn-default btn-sm btn--manager-sound " audio-player="' + v.id + '">',
                                ' <span class="' + configIcons.ICON_BASE + "" + configIcons.ICON_AUDIO_PLAY + '"></span>',
                                'Play ', '</a>'
                            ];
                            allowListen = true;
                            dataAudio={
                                id:v.id,
                                data:v,

                            };
                        }
                        var sourceCurrent = $publicAsset + v.source;
                        var setCurrent = [

                            '<audio id="audioPlayer' + v.id + '" controls  class="not-view">',
                            '<source src="' + sourceCurrent + '" type="audio/mpeg">',
                            '</audio>',


                        ];
                        audioData.push(setCurrent.join(""));
                        countMain++;
                    });

                    audioData.push("</div>");

                }

                let itemsExamples = [];
                let languageRoot = "";
                let languageTo = "";
                const resultado = $scope.dataTypeDictionary.find(item => item.id === $scope.modelFilters.typeDictionary);
                const languages = resultado["text"].split("-");
                languageRoot = languages[0];
                languageTo = languages[1];


                var word = row.value;
                var resultData = getValueConvert(word);
                console.log("getValueConvert", resultData)
                // var pronunciations = buildPronunciationsFromResult(resultData);
                var pronunciations = row.pronunciations;
                $.each(row.examples, function (i, v) {
                    var value = v.value;
                    var description = v.description;
                    var setValue = [

                        '      <li class="word-card__item ">',
                        '        <strong>' + languageRoot + ':</strong> ' + value + '.<br/>',
                        '        <strong>' + languageTo + ':</strong> ' + description,
                        '      </li>',
                    ];
                    itemsExamples.push(setValue.join(""));
                });
                let exampleData = itemsExamples.length > 0 ? [
                    '  <div class="word-card__section word-card__section--examples">',
                    '    <h3 class="word-card__subtitle"><i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_COMMENT + '"></i> Ejemplos</h3>',
                    '    <ul class="word-card__list">',
                    itemsExamples.join(""),
                    '    </ul>',
                    '  </div>'

                ] : [];

                let itemsPhonetic = [];
                var mainPronunciation = null;
                if (pronunciations && pronunciations.length > 0) {
                    mainPronunciation = pronunciations[0];
                }
                $.each(pronunciations, function (i, v) {
                    var phoneticValue = v.phonetic_value;
                    var notationType = v.notation_type;
                    var clasWord = v.isMain ? "word-card__phonetic--main" : "";
                    if (!v.isMain) {
                        var setValue = [

                            '      <li class="word-card__item not-view word-card-list-li-' + row.id + '"" >',
                            '        <span class="word-card__phonetic ' + clasWord + '">' + phoneticValue + '</span>',
                            '        <span class="word-card__notation">(' + notationType + ')</span>',
                            '      </li>',
                        ];
                        itemsPhonetic.push(setValue.join(""));
                    }

                });
                let itemsGrammaticalClass = [];
                itemsGrammaticalClass.push([
                    '      <li class="word-card__item">' + row.dictionary_grammatical_class_name + '</li>',
                ]);
                var clasWord = mainPronunciation ? (mainPronunciation.isMain ? "word-card__phonetic--main" : "") : "";



                var htmlPlaying = allowListen ? [
                    '    <h3 class="word-card__subtitle"> Pronuciacion',
                    playStructure.join(""),
                    ' </h3>',

                ].join("") : '';
                let phoneticData = itemsPhonetic.length > 0 ? [
                    '  <div class="word-card__section word-card__section--pronunciations">',
                    htmlPlaying,
                    '    <h4 class="word-card__subtitle">Variantes </h4>',

                    '    <ul class="word-card__list" id="word-card-list-' + row.id + '">',
                    '      <li class="word-card__item word-card__item--main " id="word-card-list-li-' + row.id + '">',
                    '        <span class="word-card__phonetic ' + clasWord + '">' + mainPronunciation.phonetic_value + '</span>',
                    '        <span class="word-card__notation">(' + mainPronunciation.notation_type + ')</span>',
                    '<i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_CHEVRON_DOWN + '  word-card__expand-ico"></i>',
                    '      </li>',
                    itemsPhonetic.join(""),
                    '    </ul>',
                    '  </div>'

                ] : [];


                let grammaticalData = itemsGrammaticalClass.length > 0 ? [
                    '  <div class="word-card__section word-card__section--grammar">',
                    '    <h3 class="word-card__subtitle"><i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_CONTENT_BOOK + '"></i>Clases Gramaticales</h3>',
                    '    <ul class="word-card__list">',
                    itemsGrammaticalClass.join(""),
                    '    </ul>',
                    '  </div>'

                ] : [];

                var result = [
                    '<div class="word-card">',
                    '  <div class="word-card__header">',
                    '    <h2 class="word-card__base">' + row.value + '</h2>',
                    '    <span class="word-card__translation">' + row.translation_value + '</span>',
                    '  </div>',
                    phoneticData.join(""),
                    grammaticalData.join(""),
                    exampleData.join(""),
                    '  <div class="word-card__section word-card__section--detail">',
                    '    <h3 class="word-card__subtitle"><i class="' + configIcons.ICON_BASE + "" + configIcons.ICON_INFO + '"></i>Detalles Adicionales</h3>',
                    '    <p class="word-card__text">',
                    row.description, " <br>" + row.usage_context,
                    '    </p>',
                    '  </div>',
                    audioData.join(""),
                    '</div>'
                ];


                return result.join("");
            }
        };
    }
</script>
