<script id="plugin-numbers">
    (function (global) {
        "use strict";

        /**
         * DictionaryCountsNumbersService
         * - inputType: "numeric" | "kichwa"
         * - inputValue: string (minúsculas) ej: "235" o "ishkay pachak kimsa chunka pichka"
         */
        function DictionaryCountsNumbersService(payload) {
            this._payload = payload || null;

            this._meta = {};
            this._scopesById = {};
            this._numbersByValue = {};
            this._numbersByWord = {}; // clave: kichwa_word exacto
            this._base = {};          // 0..10, 100, 1000
            this._tens = {};          // 20,30,...90

            this._init();
        }

        // -------------------------
        // Init / Indexes
        // -------------------------
        DictionaryCountsNumbersService.prototype._isSpecialDenominatorValue = function (n) {
            return Number(n) === 100 || Number(n) === 1000;
        };

        DictionaryCountsNumbersService.prototype._partsForOneHundred = function () {
            // 100 => shuk pachak
            return [this._partFromValue(1), this._partFromValue(100)];
        };

        DictionaryCountsNumbersService.prototype._partsForOneThousand = function () {
            // 1000 => shuk waranka
            return [this._partFromValue(1), this._partFromValue(1000)];
        };
        DictionaryCountsNumbersService.prototype._init = function () {
            if (!this._payload || !Array.isArray(this._payload.numbers)) {
                throw new Error("DictionaryCountsNumbersService: payload inválido (numbers requerido).");
            }

            this._meta = this._payload.meta || {};

            (this._payload.scopes || []).forEach((s) => {
                this._scopesById[String(s.id)] = s;
            });

            (this._payload.numbers || []).forEach((n) => {
                this._numbersByValue[String(n.number_value)] = n;

                var word = this._normalizeText(n.kichwa_word);
                this._numbersByWord[word] = n;

                // bases: 0..10, 100, 1000
                if (n.is_base === 1) {
                    this._base[String(n.number_value)] = n;
                }

                // decenas compuestas 20..90
                if (n.number_value >= 20 && n.number_value <= 90 && n.number_value % 10 === 0) {
                    this._tens[String(n.number_value)] = n;
                }
            });

            // validaciones mínimas
            if (!this._base["0"] || !this._base["10"] || !this._base["100"] || !this._base["1000"]) {
                throw new Error("Faltan bases mínimas: 0, 10, 100, 1000.");
            }
        };

        // -------------------------
        // Public API
        // -------------------------
        DictionaryCountsNumbersService.prototype.convert = function (inputValue, inputType) {
            var type = String(inputType || "").trim().toLowerCase();
            var raw = String(inputValue || "").trim().toLowerCase();

            if (!raw) return this._fail("inputValue vacío.");
            if (type !== "numeric" && type !== "kichwa") {
                return this._fail("inputType inválido. Usa: 'numeric' o 'kichwa'.");
            }

            if (type === "numeric") return this._convertNumericToKichwa(raw);
            return this._convertKichwaToNumeric(raw);
        };

        // -------------------------
        // numeric -> kichwa
        // -------------------------
        DictionaryCountsNumbersService.prototype._convertNumericToKichwa = function (raw) {
            var parsed = this._parseInteger(raw);
            if (!parsed.success) return parsed;

            var n = parsed.data.value;

            var scope = this._inferScopeByValue(n);
            if (!scope) return this._fail("No se pudo determinar scope para: " + n);

            var build = this._buildKichwaNumberWord(n);
            if (!build.success) return build;

            var fullWord = build.data.word;
            var pron = this._buildPronunciationsFromTokens(fullWord.split(/\s+/));

            return this._ok("Conversión exitosa (numeric → kichwa).", {
                input: {value: raw, type: "numeric"},
                result: {
                    number_value: n,
                    kichwa_word: fullWord
                },
                parts: build.data.parts,
                pronunciations: pron.data,
                didactic: this._buildDidacticNumeric(n, scope),
                meta: this._meta
            });
        };

        // -------------------------
        // kichwa -> numeric
        // -------------------------
        DictionaryCountsNumbersService.prototype._convertKichwaToNumeric = function (raw) {
            var normalized = this._normalizeText(raw);

            // tokens por espacio
            var tokens = normalized.split(/\s+/).filter(Boolean);
            if (tokens.length === 0) return this._fail("Texto kichwa vacío.");

            // 1) Validar tokens: cada token debe existir como número base (word exacta) O ser parte de una palabra compuesta en la data.
            //    Como tus palabras compuestas (ishkay chunka) están como una sola "kichwa_word", aquí soportamos:
            //    - entrada tokenizada: "ishkay chunka" (2 tokens) -> se detecta como bigrama existente
            //    - entrada exacta de token único si existiera.

            // 2) Convertir tokens a "valores" usando greedy bigram:
            //    ej: ["ishkay","chunka","pichka"] -> [20,5]
            var valuesRes = this._tokensToValuesGreedy(tokens);
            if (!valuesRes.success) return valuesRes;

            var values = valuesRes.data.values;         // lista de números: [1000, 200, 30, 5] etc
            var tokenGroups = valuesRes.data.groups;    // para pronunciaciones (palabras reales)

            // 3) Evaluar valores a número final
            var evalRes = this._evaluateValuesToNumber(values);
            if (!evalRes.success) return evalRes;

            var n = evalRes.data.number_value;
            var scope = this._inferScopeByValue(n);

            // 4) Pronunciaciones: desde los "groups" (cada group es una palabra kichwa existente)
            var pron = this._buildPronunciationsFromTokens(tokenGroups);

            return this._ok("Conversión exitosa (kichwa → numeric).", {
                input: {value: raw, type: "kichwa"},
                result: {
                    kichwa_word: normalized,
                    number_value: n
                },
                tokens: tokens,
                token_groups: tokenGroups,
                pronunciations: pron.data,
                didactic: this._buildDidacticKichwa(normalized, n, scope),
                meta: this._meta
            });
        };

        // -------------------------
        // Token grouping (greedy bigram)
        // -------------------------
        DictionaryCountsNumbersService.prototype._tokensToValuesGreedy = function (tokens) {
            var values = [];
            var groups = []; // words we matched (single or bigram)

            for (var i = 0; i < tokens.length; i++) {
                var t1 = tokens[i];
                var t2 = (i + 1 < tokens.length) ? tokens[i + 1] : null;

                // intentar bigrama "t1 t2"
                if (t2) {
                    var bigram = this._normalizeText(t1 + " " + t2);
                    var bigObj = this._numbersByWord[bigram];
                    if (bigObj) {
                        values.push(parseInt(bigObj.number_value, 10));
                        groups.push(bigram);
                        i++; // consumimos 2 tokens
                        continue;
                    }
                }

                // intentar unigram
                var uniObj = this._numbersByWord[t1];
                if (!uniObj) {
                    return this._fail("Token kichwa no reconocido: '" + t1 + "'");
                }

                values.push(parseInt(uniObj.number_value, 10));
                groups.push(t1);
            }

            return this._ok("OK", {values: values, groups: groups});
        };

        // -------------------------
        // Evaluate values list -> number
        // Supports:
        // - [1000] = 1000
        // - [2,1000] = 2000 (shuk is 1, but also supports 1*1000)
        // - [100, 20, 5] = 125
        // - [2,100, 30, 5] = 235
        // - [1000, 200, 30, 5] = 1235
        // Logic:
        // - use multiplicative markers: 1000, 100
        // - sum of segments
        // -------------------------
        DictionaryCountsNumbersService.prototype._evaluateValuesToNumber = function (values) {
            // valid base markers exist:
            var THOUSAND = 1000;
            var HUNDRED = 100;

            var total = 0;
            var current = 0;

            for (var i = 0; i < values.length; i++) {
                var v = values[i];

                if (v === THOUSAND) {
                    if (current === 0) current = 1; // "waranka" solo => 1000
                    current = current * THOUSAND;
                    total += current;
                    current = 0;
                    continue;
                }

                if (v === HUNDRED) {
                    if (current === 0) current = 1; // "pachak" solo => 100
                    current = current * HUNDRED;
                    continue;
                }

                // decenas/unidades
                current += v;
            }

            total += current;

            if (!Number.isFinite(total)) return this._fail("No se pudo evaluar el número.");
            if (total < 0) return this._fail("Resultado inválido.");

            return this._ok("OK", {number_value: total});
        };
        /**
         * Retorna matriz de números base (is_base=1) con pronunciaciones y didáctica.
         * Output: { success, message, data: { items: [...] } }
         */
        DictionaryCountsNumbersService.prototype.getBaseNumbersMatrix = function () {
            var numbers = (this._payload.numbers || []);

            var bases = numbers
                .filter((n) => Number(n.is_base) === 1)
                .sort((a, b) => Number(a.number_value) - Number(b.number_value));

            var items = bases.map((n) => {
                var nv = Number(n.number_value);

                // ✅ override para 100/1000 (no devolver pachak/waranka solos)
                var parts;
                if (nv === 100) parts = this._partsForOneHundred();
                else if (nv === 1000) parts = this._partsForOneThousand();
                else parts = [this._partFromNumber(n)];

                var word = parts.map(p => p.word).join(" ").trim();

                // pronunciaciones deben construirse por tokens existentes
                var tokenWords = parts.map(p => p.word);
                var pronList = this._buildPronunciationsFromTokens(tokenWords);

                return {
                    number_value: nv,
                    kichwa_word: word,
                    spanish_word: n.spanish_word || null,
                    pron: n.pron || {},
                    pronunciations: pronList.success ? pronList.data : [],
                    didactic: {
                        idea: "Número base (bloque de construcción)",
                        rule_es: (nv === 100 || nv === 1000)
                            ? "Regla: cuando es denominador (100/1000) se marca el 1: 'shuk pachak' / 'shuk waranka'."
                            : "Regla: número base directo.",
                        note: (n.notes || "")
                    }
                };
            });

            return this._ok("Matriz de números base generada.", {items: items});
        };

        // -------------------------
        // Build kichwa word from number
        // (hasta 999999 para evitar exceso)
        // -------------------------
        DictionaryCountsNumbersService.prototype._buildKichwaNumberWord = function (n) {
            // ✅ Regla especial: 100 y 1000 SIEMPRE con "shuk"
            if (n === 100) {
                var p100 = this._partsForOneHundred();
                return this._ok("OK", {word: p100.map(p => p.word).join(" "), parts: p100});
            }
            if (n === 1000) {
                var p1000 = this._partsForOneThousand();
                return this._ok("OK", {word: p1000.map(p => p.word).join(" "), parts: p1000});
            }

            // Directos (pero ya no dejamos que 100/1000 salgan directo)
            var direct = this._getNumberByValue(n);
            if (direct) {
                return this._ok("OK", {word: direct.kichwa_word, parts: [this._partFromNumber(direct)]});
            }

            if (n > 999999) return this._fail("Número demasiado grande (máx recomendado 999999).");

            var parts = [];

            var thousands = Math.floor(n / 1000);
            var remainder = n % 1000;

            // ---- miles ----
            if (thousands > 0) {
                if (thousands === 1) {
                    // ✅ 1000..1999 => shuk waranka ...
                    parts = parts.concat(this._partsForOneThousand());
                } else {
                    var th = this._buildUnder1000(thousands);
                    if (!th.success) return th;

                    parts = parts.concat(th.data.parts);
                    parts.push(this._partFromValue(1000)); // waranka
                }
            }

            // ---- resto ----
            if (remainder > 0) {
                var rest = this._buildUnder1000(remainder);
                if (!rest.success) return rest;

                parts = parts.concat(rest.data.parts);
            }

            if (parts.length === 0) {
                var zero = this._getNumberByValue(0);
                return this._ok("OK", {word: zero.kichwa_word, parts: [this._partFromNumber(zero)]});
            }

            return this._ok("OK", {
                word: parts.map(p => p.word).join(" ").trim(),
                parts: parts
            });
        };


        DictionaryCountsNumbersService.prototype._buildUnder1000 = function (n) {
            var direct = this._getNumberByValue(n);
            if (direct) return this._ok("OK", {parts: [this._partFromNumber(direct)]});

            var parts = [];

            if (n >= 100) {
                var hundreds = Math.floor(n / 100);
                var rest = n % 100;

                if (hundreds === 1) {
                    // ✅ 100..199 => shuk pachak ...
                    parts = parts.concat(this._partsForOneHundred());
                } else {
                    var h = this._getNumberByValue(hundreds);
                    if (!h) return this._fail("Falta base para centenas: " + hundreds);

                    parts.push(this._partFromNumber(h));
                    parts.push(this._partFromValue(100)); // pachak
                }

                if (rest === 0) return this._ok("OK", {parts: parts});
                n = rest;
            }

            if (n >= 20) {
                var tens = Math.floor(n / 10) * 10;
                var unit = n % 10;

                var t = this._getNumberByValue(tens);
                if (!t) return this._fail("Falta data para decena: " + tens);

                parts.push(this._partFromNumber(t));

                if (unit === 0) return this._ok("OK", {parts: parts});

                var u = this._getNumberByValue(unit);
                if (!u) return this._fail("Falta data para unidad: " + unit);

                parts.push(this._partFromNumber(u));
                return this._ok("OK", {parts: parts});
            }

            // 11..19 -> "chunka shuk" etc
            if (n >= 11 && n <= 19) {
                var ten = this._getNumberByValue(10);
                var u2 = this._getNumberByValue(n - 10);
                if (!ten || !u2) return this._fail("Falta data para 10 o unidades.");

                parts.push(this._partFromNumber(ten));
                parts.push(this._partFromNumber(u2));
                return this._ok("OK", {parts: parts});
            }

            var small = this._getNumberByValue(n);
            if (!small) return this._fail("Falta data para número: " + n);

            parts.push(this._partFromNumber(small));
            return this._ok("OK", {parts: parts});
        };

        // -------------------------
        // Pronunciations from tokens (each token is a kichwa_word key)
        // tokens can be bigrams (e.g. "ishkay chunka")
        // -------------------------
        DictionaryCountsNumbersService.prototype._buildPronunciationsFromTokens = function (tokensWords) {
            var typesOrder = [
                {type: "spanish_approx", desc: "Pronunciación aproximada (español)"},
                {type: "tts_hint", desc: "Sugerencia para TTS (ASCII)"},
                {type: "custom", desc: "Convención local (č, š)"},
                {type: "ipa", desc: "IPA (aproximado)"}
            ];

            var merged = {spanish_approx: [], tts_hint: [], custom: [], ipa: []};

            for (var i = 0; i < tokensWords.length; i++) {
                var w = this._normalizeText(tokensWords[i]);
                var obj = this._numbersByWord[w];

                // si el token es un bigrama y existe: ok
                // si no existe: fallback token literal
                Object.keys(merged).forEach((k) => {
                    if (obj && obj.pron && obj.pron[k]) merged[k].push(obj.pron[k]);
                    else merged[k].push(w);
                });
            }

            // palabra final para mostrar
            var palabra = tokensWords.map((t) => this._normalizeText(t)).join(" ").trim();

            return this._ok("OK", typesOrder.map(function (t) {
                return {
                    palabra: palabra,
                    type: t.type,
                    descripcion: t.desc,
                    value: merged[t.type].join(" ").trim()
                };
            }));
        };

        // -------------------------
        // Didactic
        // -------------------------
        DictionaryCountsNumbersService.prototype._buildDidacticNumeric = function (n, scope) {
            return {
                scope: this._scopeInfo(scope),
                explanation: "Entrada numérica → se descompone en miles/centenas/decenas/unidades y se arma la frase en kichwa."
            };
        };

        DictionaryCountsNumbersService.prototype._buildDidacticKichwa = function (kichwaText, n, scope) {
            return {
                scope: this._scopeInfo(scope),
                explanation: "Entrada kichwa → se tokeniza (incluye bigramas como 'ishkay chunka'), se evalúan multiplicadores (pachak/waranka) y se calcula el número."
            };
        };

        DictionaryCountsNumbersService.prototype._scopeInfo = function (scope) {
            if (!scope) return null;
            return {
                id: scope.id,
                code: scope.code,
                title_es: scope.title_es,
                description_es: scope.description_es,
                min_value: scope.min_value,
                max_value: scope.max_value
            };
        };

        // -------------------------
        // Scope infer
        // -------------------------
        DictionaryCountsNumbersService.prototype._inferScopeByValue = function (n) {
            var scopes = Object.values(this._scopesById);
            for (var i = 0; i < scopes.length; i++) {
                var s = scopes[i];
                var min = (s.min_value != null) ? parseInt(s.min_value, 10) : 0;
                var max = (s.max_value == null) ? null : parseInt(s.max_value, 10);
                if (n >= min && (max === null || n <= max)) return s;
            }
            return null;
        };

        // -------------------------
        // Helpers
        // -------------------------
        DictionaryCountsNumbersService.prototype._normalizeText = function (txt) {
            return String(txt || "").trim().toLowerCase().replace(/\s+/g, " ");
        };

        DictionaryCountsNumbersService.prototype._parseInteger = function (raw) {
            var s = String(raw).trim();
            if (s === "" || isNaN(s)) return this._fail("Número inválido.");
            var n = parseInt(s, 10);
            if (!Number.isFinite(n)) return this._fail("Número inválido.");
            if (n < 0) return this._fail("No se aceptan números negativos.");
            return this._ok("OK", {value: n});
        };

        DictionaryCountsNumbersService.prototype._getNumberByValue = function (n) {
            return this._numbersByValue[String(n)] || null;
        };

        DictionaryCountsNumbersService.prototype._partFromValue = function (n) {
            var obj = this._getNumberByValue(n);
            return obj ? this._partFromNumber(obj) : {
                number_value: n,
                word: String(n),
                pron: {},
                source: "fallback"
            };
        };

        DictionaryCountsNumbersService.prototype._partFromNumber = function (numberObj) {
            return {
                id: numberObj.id,
                number_value: numberObj.number_value,
                word: this._normalizeText(numberObj.kichwa_word),
                spanish: numberObj.spanish_word || null,
                is_base: numberObj.is_base,
                pron: numberObj.pron || {}
            };
        };

        DictionaryCountsNumbersService.prototype._ok = function (message, data) {
            return {success: true, message: message || "OK", data: data};
        };

        DictionaryCountsNumbersService.prototype._fail = function (message, data) {
            return {success: false, message: message || "Error", data: data || null};
        };

        global.DictionaryCountsNumbersService = DictionaryCountsNumbersService;

    })(window);

</script>
