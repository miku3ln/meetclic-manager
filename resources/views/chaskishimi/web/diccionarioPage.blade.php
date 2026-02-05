{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $assetsRoot = $resourcePathServer . 'assets/chaskishimi/';

@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    <style id="number-convert">
        .container--manager-number-convert {
            margin-left: 9%;
            margin-top: 5%;
            margin-right: 9%;
        }

        .mc-dict {
            font-family: Arial, sans-serif;
            max-width: 520px;
            margin: 0 auto;
        }

        .mc-dict__bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .mc-dict__bar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mc-dict__badge-icon {
            font-size: 22px;
        }

        .mc-dict__title {
            font-weight: 700;
            font-size: 16px;
            color: #1f2937;
        }

        .mc-dict__subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .mc-dict__toggle {
            display: flex;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .mc-dict__toggle-btn {
            padding: 8px 10px;
            border: 0;
            background: transparent;
            cursor: pointer;
            font-size: 12px;
            color: #374151;
        }

        .mc-dict__toggle-btn--active {
            background: #111827;
            color: #fff;
        }

        .mc-dict__row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 12px;
        }

        .mc-dict__inputwrap {
            flex: 1;
        }

        .mc-dict__input {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 12px;
            outline: none;
            font-size: 14px;
        }

        .mc-dict__btn {
            border: 0;
            border-radius: 12px;
            padding: 12px 14px;
            cursor: pointer;
            background: #ff7a00;
            color: #fff;
            font-weight: 700;
            font-size: 13px;
        }

        .mc-dict__btn:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .mc-dict__alert {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 10px 12px;
            border-radius: 12px;
            margin: 10px 0 14px 0;
        }

        .mc-dict__alert--error {
            border: 1px solid #fecaca;
            background: #fff1f2;
            color: #7f1d1d;
        }

        .mc-dict__alert-ico {
            font-size: 16px;
        }

        .mc-dict__alert-text {
            font-size: 13px;
        }

        .mc-dict__card {
            border: 2px solid #ff7a00;
            border-radius: 14px;
            padding: 14px;
            background: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
        }

        .mc-dict__card-head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .mc-dict__card-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #e0f2fe;
            font-size: 18px;
        }

        .mc-dict__card-titlebox {
            flex: 1;
        }

        .mc-dict__word {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
            line-height: 1.1;
        }

        .mc-dict__word-sub {
            margin-top: 6px;
        }

        .mc-dict__chip {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #374151;
            font-size: 12px;
        }

        .mc-dict__card-input {
            min-width: 160px;
        }

        .mc-dict__miniinput {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 10px;
            font-size: 13px;
            color: #111827;
            background: #fff;
        }

        .mc-dict__divider {
            height: 1px;
            background: #e5e7eb;
            margin: 12px 0;
        }

        .mc-dict__section {
            padding: 8px 0;
        }

        .mc-dict__section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 8px;
        }

        .mc-dict__section-ico {
            font-size: 16px;
        }

        .mc-dict__list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mc-dict__list-item {
            font-size: 13px;
            color: #111827;
        }

        .mc-dict__linklike {
            color: #2563eb;
            font-weight: 700;
        }

        .mc-dict__muted {
            color: #6b7280;
            margin-left: 6px;
            font-size: 12px;
        }

        .mc-dict__muted--block {
            display: block;
            margin-left: 0;
            margin-top: 2px;
        }

        .mc-dict__text {
            font-size: 13px;
            color: #111827;
        }

        .mc-dict__kv {
            margin-bottom: 6px;
        }

        .mc-dict__kv-k {
            color: #6b7280;
            font-weight: 700;
            margin-right: 6px;
        }

        .mc-dict__kv-v {
            color: #111827;
        }

    </style>
    <style>

        .section--full-img {
            padding: 0 0;
        }

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        img.img-svg-full {
            width: 88%;
        }


        .btn-sm {
            padding: 5px 10px !important;
            font-size: 12px !important;;
            line-height: 1.5 !important;;
            border-radius: 3px !important;;
        }

        img.content-description__photos--img {
            height: 140px;
            width: 140px;
        }

        .content-description {
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .btn {
            color: #f08124 !important;
        }

        .text-left {

            font-size: 26px;
            text-align: left;
        }

        .text-left a {
            color: #4d4c4c !important;
        }

        .form-group {
            text-align: left;

        }

        select#typeDictionary {
            font-size: 21px;
        }

        label.form__label {
            color: #225278;
            font-size: 24px;
        }

        .bootgrid-footer--fixed {
            padding-right: 7% !important;
            padding-left: 6% !important;
            width: 80%;
            position: fixed;
            top: 77%;
        }

        ul.pagination li {
            cursor: pointer;
        }

        a {

            text-decoration: none !important;
        }

        .content-description__information {
            /* display: flex; /* Hace que los elementos hijos se muestren en línea horizontalmente */
            align-items: center; /* Alinea los elementos verticalmente */
        }

        .content-description__title {
            margin-right: 10px; /* Espacio entre el título y el contenido */
        }

        .word--description {
            /*  display: flex; /* Para que el contenido dentro también se muestre en línea horizontal */
            align-items: center; /* Alinea el contenido verticalmente */
        }

        .word--fonetic {
            margin-right: 5px; /* Espacio entre el fonético y el texto */
        }

        .word--description p {
            margin: 0; /* Elimina el margen predeterminado del párrafo */
        }

        span.content-description__title {
            color: #4d4c4c;
            font-size: 22px;
            font-weight: bold;
        }

        span.word--fonetic {
            color: #f08124;
        }


        .search {
            width: 45% !important;;
        }

        .container--manager-dictionary {

            width: 100%;
            padding: 0 10% 0 10%;
            position: relative;
            z-index: 5;
        }

        .custom-scroll-admin-grid {
            height: 450px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .input-group-addon {
            font-size: 26px !important;
            color: #fff !important;;
            background-color: #f08124 !important;
            border: 0 solid #f08124 !important;;
            border-radius: 0 !important;;
        }


        .word-card:hover {
            box-shadow: 0 -5px 2px rgb(240 129 36);
            transform: translateY(-4px);
        }

        /* Identificador visual */
        .word-card__header h2::before {
            content: "📘 ";
        }

        .word-card {
            background: #fff;
            border: 2px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            max-width: 100%;
            font-family: 'Segoe UI', sans-serif;
            margin: 20px auto;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .word-card__header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            border-bottom: 1px solid #e2e2e2;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .word-card__base {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }

        .word-card__translation {
            display: inline-block;
            margin-left: 12px;
            padding: 2px 8px;
            font-size: 23px;
            font-weight: 600;
            color: #2a2a2a;
            background-color: #f0f8ff; /* color suave */
            border-left: 4px solid #3b82f6; /* azul destacado */
            border-radius: 4px;
            transition: background-color 0.3s;

        }

        .word-card:hover .word-card__translation {
            background-color: #e0f2ff;
        }

        .word-card__section {
            margin-bottom: 18px;
        }

        .word-card__subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .word-card__list {
            list-style: none;
            padding-left: 0;
        }

        .word-card__item {
            padding: 6px 0;
            font-size: 15px;
            color: #2c3e50;
        }

        .word-card__phonetic {
            font-weight: 500;
            margin-right: 6px;
            color: #2980b9;
        }

        .word-card__notation {
            font-style: italic;
            color: #7f8c8d;
        }

        .word-card__text {
            color: #444;
            font-size: 15px;
            line-height: 1.6;
        }

        table#dictionary_by_words-grid {
            width: 100%;
        }

        /* Aplica SOLO al tbody */
        #dictionary_by_words-grid > tbody {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); /* 3 columnas en PC, 1 columna móvil */
            gap: 20px;
            padding: 20px;
        }

        /* Los tr deben "desaparecer" como filas */
        #dictionary_by_words-grid > tbody > tr {
            display: contents; /* Para que los <td> (las word-card) floten directamente como ítems del grid */
        }

        /* Aseguramos que el td se comporte como bloque libre */
        #dictionary_by_words-grid > tbody > tr > td {
            margin: 0;
            padding: 0;
        }
    </style>


    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.css") }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.css") }}" rel="stylesheet"
          type="text/css">
@endsection
@section('additional-scripts')
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/bootstrap.min.js") }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer."plugins/bootgrid-2024/jquery.bootgrid.min.js") }}"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
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

            // -------------------------
            // Build kichwa word from number
            // (hasta 999999 para evitar exceso)
            // -------------------------
            DictionaryCountsNumbersService.prototype._buildKichwaNumberWord = function (n) {
                var direct = this._getNumberByValue(n);
                if (direct) {
                    return this._ok("OK", {word: direct.kichwa_word, parts: [this._partFromNumber(direct)]});
                }

                if (n > 999999) return this._fail("Número demasiado grande (máx recomendado 999999).");

                var parts = [];

                var thousands = Math.floor(n / 1000);
                var remainder = n % 1000;

                if (thousands > 0) {
                    if (thousands === 1) {
                        parts.push(this._partFromValue(1000)); // waranka
                    } else {
                        var th = this._buildUnder1000(thousands);
                        if (!th.success) return th;

                        parts = parts.concat(th.data.parts);
                        parts.push(this._partFromValue(1000)); // waranka
                    }
                }

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
                        parts.push(this._partFromValue(100));
                    } else {
                        var h = this._getNumberByValue(hundreds);
                        if (!h) return this._fail("Falta base para centenas: " + hundreds);
                        parts.push(this._partFromNumber(h));
                        parts.push(this._partFromValue(100));
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

                // 11..19 -> "chunka shuk" etc (regla genérica)
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

                return this._ok("OK", {parts: [this._partFromNumber(small)]});
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
    <script>
        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {

            $('.header-search').show();
        })
    </script>
    <script>

        var $currentApp;
        var $dictionaryCountsNumbersManagement = $dataManagerPage.dictionaryCountsNumbersManagement;
        var service = new DictionaryCountsNumbersService($dictionaryCountsNumbersManagement);
        const app = new Vue(
            {
                directives: {
                    'init-listing-items': {
                        mounted: function () {
                            componentThisLanguage = this;
                            this.initCurrentComponent();
                        },
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            var initMethod = paramsInput['initMethod'];
                            initMethod({
                                elementInit: el,
                                params: paramsInput
                            });
                        }
                    },


                },
                el: '#app-management',
                created: function () {
                    $currentApp = this;
                    var $scope = this;

                    $(function () {
                        $scope.initManagement();
                    });
                },
                computed: {
                    placeholderText: function () {
                        return (this.modelChange.type === "numeric")
                            ? "Ej: 235"
                            : "Ej: ishkay pachak kimsa chunka pichka";
                    },
                    cardTitleWord: function () {
                        console.log("cardTitleWord",this.lastResponse);
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var d = this.lastResponse.data;

                        // si entró numeric -> mostrar palabra kichwa
                        if (d.input.type === "numeric") return d.result.kichwa_word;

                        // si entró kichwa -> mostrar la misma palabra
                        return d.result.number_value;
                    },
                    cardSubInfo: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var d = this.lastResponse.data;

                        if (d.input.type === "numeric") return "resultado en kichwa";
                        return "resultado en número";
                    },
                    cardResultText: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var d = this.lastResponse.data;

                        if (d.input.type === "numeric") return "Número: " + d.result.number_value;
                        return "Número: " + d.result.number_value;
                    },
                    pronunciations: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return [];
                        return (this.lastResponse.data.pronunciations || []);
                    },
                    didacticText: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        return (this.lastResponse.data.didactic && this.lastResponse.data.didactic.explanation) ? this.lastResponse.data.didactic.explanation : "—";
                    },
                    didacticScopeText: function () {
                        if (!this.lastResponse || !this.lastResponse.success) return "";
                        var s = (this.lastResponse.data.didactic && this.lastResponse.data.didactic.scope) ? this.lastResponse.data.didactic.scope : null;
                        if (!s) return "—";
                        return s.title_es + " (" + s.code + ")";
                    }
                },
                mounted: function () {

                    this.initCurrentComponent();
                },
                data: function () {
                    return {
                        configModelEntity: {
                            "buttonsManagements": [
                                {
                                    "title": "Actualizar",
                                    "data-placement": "top",
                                    "i-class": " fas fa-pencil-alt",
                                    "managerType": "updateEntity"
                                }
                            ]
                        },
                        model: {
                            attributes: this.getAttributesForm(),
                            structure: this.getStructureForm(),
                        },
                        gridConfig: {
                            selectorCurrent: "#dictionary_by_words-grid",
                            url: $("#action-dictionary_by_words-getAdmin").val()
                        },
                        managerMenuConfig: {
                            view: false,
                            menuCurrent: [],
                            rowId: null
                        },
                        dataTypeDictionary: [{
                            id: 1, text: 'Kichwa - Castellano'
                        },
                            {
                                id: 2, text: 'Castellano - Kichwa'
                            }
                        ],
                        modelFilters: {
                            typeDictionary: 1
                        },
                        modelChange: {value: "", type: "numeric"},
                        isLoading: false,
                        lastResponse: null
                    };
                },
                methods: {
                    ...$methodsFormValid,
                    ...$shareManager,
                    getAttributesForm: function () {
                        var result = {
                            "id": null,
                            "value": null,
                            "description": null,
                            "status": "ACTIVE",
                            "diccionary_language_id": null,
                            "letters_of_the_alphabet": null,

                        };
                        return result;
                    },
                    getStructureForm: function () {
                        var result = {
                            value: {
                                id: "value",
                                name: "value",
                                label: "Palabra",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            description: {
                                id: "description",
                                name: "description",
                                label: "Palabra",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            status: {
                                id: "status",
                                name: "status",
                                label: "Estado",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            diccionary_language_id: {
                                id: "diccionary_language_id",
                                name: "diccionary_language_id",
                                label: "Estado",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                            dictionary_language_text: {
                                id: "dictionary_language_text",
                                name: "dictionary_language_text",
                                label: "Diccionario Tipo",
                                required: {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                                maxLength: {
                                    msj: "# Carecteres Excedidos a 150.",
                                },
                            },
                        };
                        return result;
                    },
                    getMenuConfig: getMenuConfig,

                    initManagement: function () {
                    },
                    _element: function (e) {
                        console.log(e);
                    },
                    _resetManagerGrid: function () {
                        this.managerMenuConfig = {
                            view: false,
                            menuCurrent: [],
                            rowId: null
                        };
                    },
                    _gridManager: function (elementSelect) {
                        var vmCurrent = this;
                        var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
                        _gridManagerRows({
                            thisCurrent: vmCurrent,
                            elementSelect: elementSelect,

                        });
                    },
                    initCurrentComponent: function () {

                        this.initGridManager(this);
                    },
                    getTypeDictionary: function () {
                        var entity_manager_id = this.modelFilters.typeDictionary;
                        return {
                            entity_manager_id: entity_manager_id
                        };
                    },
                    initGridManager: function (vmCurrent) {
                        var gridName = this.gridConfig.selectorCurrent;
                        var urlCurrent = this.gridConfig.url;
                        var $scope = this;
                        var structure = vmCurrent.model.structure;

                        var formatters = {
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
                                if (row.audios) {
                                    audioData.push("<div class='content-description__audios'>");
                                    var countMain = 0;
                                    $.each(row.audios, function (i, v) {
                                        if (countMain == 0) {

                                            allowPlayMain = true;
                                            playStructure = [
                                                '  <a  class="btn btn-default btn-sm btn--manager-sound" audio-player="' + v.id + '">',
                                                ' <span class="glyphicon glyphicon-play"></span>',
                                                'Play ', '</a>'
                                            ];
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

                                console.log("resultado", resultado)
                                $.each(row.examples, function (i, v) {
                                    var value = v.value;
                                    var description = v.description;
                                    var setValue = [

                                        '      <li class="word-card__item">',
                                        '        <strong>' + languageRoot + ':</strong> ' + value + '.<br/>',
                                        '        <strong>' + languageTo + ':</strong> ' + description,
                                        '      </li>',
                                    ];
                                    itemsExamples.push(setValue.join(""));
                                });
                                let exampleData = itemsExamples.length > 0 ? [
                                    '  <div class="word-card__section word-card__section--examples">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-comment"></i> Ejemplos</h3>',
                                    '    <ul class="word-card__list">',
                                    itemsExamples.join(""),
                                    '    </ul>',
                                    '  </div>'

                                ] : [];

                                let itemsPhonetic = [];
                                $.each(row.pronunciations, function (i, v) {
                                    var phoneticValue = v.phonetic_value;
                                    var notationType = v.notation_type;
                                    var setValue = [

                                        '      <li class="word-card__item">',
                                        '        <span class="word-card__phonetic">' + phoneticValue + '</span>',
                                        '        <span class="word-card__notation">(' + notationType + ')</span>',
                                        '      </li>',
                                    ];
                                    itemsPhonetic.push(setValue.join(""));
                                });
                                let itemsGrammaticalClass = [];
                                itemsGrammaticalClass.push([
                                    '      <li class="word-card__item">' + row.dictionary_grammatical_class_name + '</li>',
                                ]);

                                let phoneticData = itemsPhonetic.length > 0 ? [
                                    '  <div class="word-card__section word-card__section--pronunciations">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-volume-up"></i> Pronuciación</h3>',
                                    '    <ul class="word-card__list">',
                                    itemsPhonetic.join(""),
                                    '    </ul>',
                                    '  </div>'

                                ] : [];


                                let grammaticalData = itemsGrammaticalClass.length > 0 ? [
                                    '  <div class="word-card__section word-card__section--grammar">',
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-book"></i>Clases Gramaticales</h3>',
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
                                    '    <h3 class="word-card__subtitle"><i class="glyphicon glyphicon-info-sign"></i>Detalles Adicionales</h3>',
                                    '    <p class="word-card__text">',
                                    row.description, " <br>" + row.usage_context,
                                    '    </p>',
                                    '  </div>',
                                    '</div>'
                                ];


                                return result.join("");
                            }
                        };
                        var $scope = this;
                        var paramsFilters = $scope.getTypeDictionary();
                        var overWritePost = function (request) {

                            var paramsFilters = $scope.getTypeDictionary();
                            request.filters = paramsFilters;
                            return request;
                        };
                        let gridInit = initGridManager({
                            gridNameSelector: gridName,
                            paramsFilters: paramsFilters,
                            formatters: formatters,
                            'urlCurrent': urlCurrent,
                            'iconRefresh': 'glyphicon glyphicon-refresh',
                            'labels': {search: 'Buscar'},
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
                                audio.play();
                            });
                        });
                    },
                    onSetValuesForm: function (type, value) {
                        $(this.gridConfig.selectorCurrent).bootgrid("reload");

                    },


                    setType: function (type) {
                        this.modelChange.type = type;
                        this.lastResponse = null; // limpia card al cambiar modo
                    },
                    onConvert: function () {
                        var value = String(this.modelChange.value || "").trim().toLowerCase();
                        if (!value) {
                            this.lastResponse = {
                                success: false,
                                message: "Ingresa un valor para convertir.",
                                data: null
                            };
                            return;
                        }

                        this.isLoading = true;

                        try {
                            // ✅ Contrato final: (string, "numeric" | "kichwa")
                            var resp = service.convert(value, this.modelChange.type);
                            this.lastResponse = resp;
                        } catch (e) {
                            this.lastResponse = {
                                success: false,
                                message: (e && e.message) ? e.message : "Error inesperado.",
                                data: null
                            };
                        } finally {
                            this.isLoading = false;
                        }
                    }

                }
            })
        ;

    </script>
@endsection
@section('content')

    <div id="app-management">
        <input id="action-dictionary_by_words-getAdmin" type="hidden"
               value="{{route('getDictionaryKichwaToCastilianAdmin',app()->getLocale())}}"/>
        <section id="sec2">
            <div class="container--manager-dictionary">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form__label "
                            >
                                Diccionario
                            </label>

                            <div class="content-element-form">
                                <select
                                    v-model.trim="modelFilters.typeDictionary"
                                    id="typeDictionary"
                                    name="typeDictionary"
                                    class="form-control m-input form-select"
                                    @change="onSetValuesForm('typeDictionary', modelFilters.typeDictionary)"
                                >
                                    <option
                                        v-for="(row,index) in dataTypeDictionary"
                                        v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="content-manager-grid">

                        <div class="custom-scroll-admin-grid table-responsive">
                            <table id="dictionary_by_words-grid"
                                   class=""

                            >
                                <thead>
                                <tr>
                                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                    <th data-column-id="value" data-formatter="value">Palabras</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container--manager-number-convert">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mc-dict__bar">
                            <div class="mc-dict__bar-left">
                                <span class="mc-dict__badge-icon">🔢</span>
                                <div class="mc-dict__titlebox">
                                    <div class="mc-dict__title">Convertidor Kichwa ↔ Número</div>
                                    <div class="mc-dict__subtitle">Ingresa un valor y obtén palabra, pronunciación y
                                        didáctica.
                                    </div>
                                </div>
                            </div>

                            <!-- Toggle -->
                            <div class="mc-dict__bar-right">
                                <div class="mc-dict__toggle" role="group" aria-label="Tipo de entrada">
                                    <button
                                        type="button"
                                        class="mc-dict__toggle-btn"
                                        :class="{ 'mc-dict__toggle-btn--active': modelChange.type === 'numeric' }"
                                        @click="setType('numeric')"
                                    >
                                        Números
                                    </button>
                                    <button
                                        type="button"
                                        class="mc-dict__toggle-btn"
                                        :class="{ 'mc-dict__toggle-btn--active': modelChange.type === 'kichwa' }"
                                        @click="setType('kichwa')"
                                    >
                                        Kichwa
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Input row -->
                        <div class="mc-dict__row">
                            <div class="mc-dict__inputwrap">
                                <input
                                    class="mc-dict__input"
                                    type="text"
                                    v-model.trim="modelChange.value"
                                    :placeholder="placeholderText"
                                    @keyup.enter="onConvert()"
                                />
                            </div>

                            <button class="mc-dict__btn" type="button" @click="onConvert()" :disabled="isLoading">
                                <span v-if="!isLoading">Convertir</span>
                                <span v-else>Cargando...</span>
                            </button>
                        </div>

                    </div>

                    <div class="col-md-6">


                        <!-- Error message (solo si falla) -->
                        <div v-if="lastResponse && !lastResponse.success" class="mc-dict__alert mc-dict__alert--error">
                            <span class="mc-dict__alert-ico">⚠️</span>
                            <span class="mc-dict__alert-text"><?php echo '{{ lastResponse.message}}' ?></span>
                        </div>

                        <!-- Card (solo si ok) -->
                        <div v-if="lastResponse && lastResponse.success" class="mc-dict__card">
                            <!-- header -->
                            <div class="mc-dict__card-head">
                                <div class="mc-dict__card-icon">📘</div>

                                <div class="mc-dict__card-titlebox">
                                    <div class="mc-dict__word">
                                        <?php echo '{{ cardTitleWord }}' ?>
                                    </div>
                                    <div class="mc-dict__word-sub">
          <span class="mc-dict__chip">
           <?php echo '  {{ cardSubInfo }}' ?>
          </span>
                                    </div>
                                </div>

                                <div class="mc-dict__card-input">
                                    <input class="mc-dict__miniinput" type="text" :value="modelChange.value" disabled/>
                                </div>
                            </div>

                            <div class="mc-dict__divider"></div>

                            <!-- Pronunciación -->
                            <div class="mc-dict__section">
                                <div class="mc-dict__section-title">
                                    <span class="mc-dict__section-ico">🔊</span>
                                    <span>Pronunciación</span>
                                </div>

                                <div class="mc-dict__list">
                                    <div
                                        v-for="(p, idx) in pronunciations"
                                        :key="'p-'+idx"
                                        class="mc-dict__list-item"
                                    >
                                        <span class="mc-dict__linklike"> <?php echo '{{ p.value }}' ?></span>
                                        <span class="mc-dict__muted">( <?php echo '{{ p.type }}' ?>)</span>
                                        <span
                                            class="mc-dict__muted mc-dict__muted--block"> <?php echo '{{ p.descripcion }}' ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Didáctica -->
                            <div class="mc-dict__section">
                                <div class="mc-dict__section-title">
                                    <span class="mc-dict__section-ico">📌</span>
                                    <span>Didáctica</span>
                                </div>

                                <div class="mc-dict__text">
                                    <div class="mc-dict__kv">
                                        <span class="mc-dict__kv-k">Scope:</span>
                                        <span class="mc-dict__kv-v"> <?php echo '{{ didacticScopeText }}' ?></span>
                                    </div>
                                    <div class="mc-dict__kv">
                                        <span class="mc-dict__kv-k">Uso:</span>
                                        <span class="mc-dict__kv-v"> <?php echo '{{ didacticText }}' ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles adicionales -->
                            <div class="mc-dict__section not-view">
                                <div class="mc-dict__section-title">
                                    <span class="mc-dict__section-ico">ℹ️</span>
                                    <span>Detalles adicionales</span>
                                </div>

                                <div class="mc-dict__text">
                                    <div class="mc-dict__kv">
                                        <span class="mc-dict__kv-k">Entrada:</span>
                                        <span
                                            class="mc-dict__kv-v"> <?php echo '{{ lastResponse.data.input.type }}' ?></span>
                                    </div>
                                    <div class="mc-dict__kv">
                                        <span class="mc-dict__kv-k">Resultado:</span>
                                        <span class="mc-dict__kv-v"> <?php echo '{{ cardResultText }}' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

