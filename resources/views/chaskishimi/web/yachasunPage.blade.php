{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$assetsRoot = $resourcePathServer . 'assets/chaskishimi/';
$resources=[
    'header'=>URL::asset($assetsRoot.'yachasun/header.svg'),
   'wayra'=>URL::asset($assetsRoot.'sections/wayra-ready.png'),
   'nina'=>URL::asset($assetsRoot.'sections/nina-ready.png'),
   'yaku'=>URL::asset($assetsRoot.'sections/yaku-ready.png'),
   'allpa'=>URL::asset($assetsRoot.'sections/allpa-ready.png'),

];
$url_path_plugins = "libs/";
@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    <style id="test-management-css">

        :root {
            --mc-blue: #4C4CFF;
            --mc-yellow: #FFCC00;
            --mc-purple: #5C5CFF;
            --mc-dark: #2C2C2C;
            --mc-bg: #F6F7FB;
            --mc-card: #FFFFFF;
            --mc-border: #E6E8F2;
            --mc-muted: #6B7280;
            --mc-ok: #14A44D;
            --mc-bad: #D32F2F;
            --mc-shadow: 0 10px 30px rgba(20, 22, 60, .08);
            --mc-radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue";
            background: var(--mc-bg);
            color: var(--mc-dark);
        }

        .mc-app {
            max-width: 1180px;
            margin: 0 auto;
            padding: 18px;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 14px;
        }

        .mc-header {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, rgba(76, 76, 255, .12), rgba(255, 204, 0, .10));
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            padding: 16px;
            box-shadow: var(--mc-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .mc-header__title {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .mc-header__title h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: .2px;
        }

        .mc-header__subtitle {
            font-size: 12px;
            color: var(--mc-muted);
            line-height: 1.35;
            max-width: 760px;
        }

        .mc-header__actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
        }

        .mc-btn {
            border: 1px solid var(--mc-border);
            background: var(--mc-card);
            color: var(--mc-dark);
            padding: 10px 12px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform .06s ease, border-color .12s ease, background .12s ease;
            user-select: none;
        }

        .mc-btn:active {
            transform: translateY(1px);
        }

        .mc-btn--primary {
            border-color: rgba(76, 76, 255, .35);
            background: rgba(76, 76, 255, .08);
            color: var(--mc-blue);
        }

        .mc-btn--danger {
            border-color: rgba(211, 47, 47, .35);
            background: rgba(211, 47, 47, .06);
            color: var(--mc-bad);
        }

        .mc-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
            transform: none;
        }

        .mc-panel {
            background: var(--mc-card);
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            box-shadow: var(--mc-shadow);
            overflow: hidden;
            min-height: 520px;
        }

        .mc-panel__head {
            padding: 14px 14px 10px;
            border-bottom: 1px solid var(--mc-border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .mc-panel__head h2 {
            margin: 0;
            font-size: 14px;
        }

        .mc-panel__hint {
            font-size: 12px;
            color: var(--mc-muted);
            margin-top: 4px;
            line-height: 1.35;
        }

        .mc-panel__body {
            padding: 14px;
        }

        /* Left: JSON loader + steps */
        .mc-loader__textarea {
            width: 100%;
            min-height: 170px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            padding: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 12px;
            line-height: 1.4;
            outline: none;
            background: #fff;
        }

        .mc-loader__row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
            align-items: center;
            justify-content: space-between;
        }

        .mc-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid var(--mc-border);
            background: #fff;
            color: var(--mc-muted);
            user-select: none;
            white-space: nowrap;
        }

        .mc-chip--ok {
            color: var(--mc-ok);
            border-color: rgba(20, 164, 77, .25);
            background: rgba(20, 164, 77, .06);
        }

        .mc-chip--bad {
            color: var(--mc-bad);
            border-color: rgba(211, 47, 47, .25);
            background: rgba(211, 47, 47, .06);
        }

        .mc-chip--info {
            color: var(--mc-blue);
            border-color: rgba(76, 76, 255, .25);
            background: rgba(76, 76, 255, .06);
        }

        .mc-steps {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mc-step {
            border: 1px solid var(--mc-border);
            background: #fff;
            border-radius: 14px;
            padding: 10px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            cursor: pointer;
            transition: border-color .12s ease, background .12s ease;
        }

        .mc-step:hover {
            border-color: rgba(76, 76, 255, .25);
        }

        .mc-step.is-active {
            border-color: rgba(76, 76, 255, .55);
            background: rgba(76, 76, 255, .06);
        }

        .mc-step.is-locked {
            opacity: .55;
            cursor: not-allowed;
        }

        .mc-step__left {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .mc-step__kicker {
            font-size: 11px;
            color: var(--mc-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mc-step__title {
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mc-step__right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .mc-step__badge {
            width: 26px;
            height: 26px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            border: 1px solid var(--mc-border);
            font-weight: 900;
            font-size: 12px;
            color: var(--mc-muted);
            background: #fff;
        }

        .mc-step__state {
            font-size: 12px;
            font-weight: 800;
            color: var(--mc-muted);
        }

        .mc-step__state.is-ok {
            color: var(--mc-ok);
        }

        .mc-step__state.is-bad {
            color: var(--mc-bad);
        }

        .mc-step__state.is-next {
            color: var(--mc-blue);
        }

        /* Right: exercise */
        .mc-ex {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mc-ex__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .mc-ex__meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 240px;
            flex: 1;
        }

        .mc-ex__metaTitle {
            font-size: 16px;
            font-weight: 900;
            margin: 0;
        }

        .mc-ex__metaSub {
            color: var(--mc-muted);
            font-size: 12px;
            line-height: 1.35;
        }

        .mc-ex__controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
        }

        .mc-ex__stage {
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            padding: 12px;
            background: #fff;
        }

        .mc-ex__prompt {
            font-weight: 800;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .mc-ex__result {
            margin-top: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid var(--mc-border);
            background: #fff;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.25;
        }

        .mc-ex__result.is-ok {
            border-color: rgba(20, 164, 77, .25);
            background: rgba(20, 164, 77, .06);
            color: var(--mc-ok);
        }

        .mc-ex__result.is-bad {
            border-color: rgba(211, 47, 47, .25);
            background: rgba(211, 47, 47, .06);
            color: var(--mc-bad);
        }

        /* Audio preview */
        .mc-audio {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .mc-audio__player {
            width: 100%;
            max-width: 520px;
        }

        .mc-audio__src {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 11px;
            color: var(--mc-muted);
            border: 1px dashed rgba(107, 114, 128, .45);
            background: rgba(246, 247, 251, .7);
            padding: 6px 8px;
            border-radius: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 520px;
        }

        /* Exercise primitives (BEM) */
        .mc-tokenList {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .mc-tokenList__item {
            padding: 10px 12px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            background: #fff;
            cursor: grab;
            font-weight: 800;
            font-size: 13px;
            user-select: none;
        }

        .mc-dropzone {
            border: 1px dashed rgba(107, 114, 128, .55);
            border-radius: 14px;
            padding: 10px;
            background: rgba(246, 247, 251, .6);
            min-height: 56px;
        }

        .mc-dropzone__label {
            font-size: 11px;
            color: var(--mc-muted);
            margin-bottom: 6px;
            font-weight: 800;
        }

        .mc-grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .mc-input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            outline: none;
            font-size: 14px;
            font-weight: 700;
        }

        .mc-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mc-option {
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
        }

        .mc-option__text {
            font-weight: 800;
            font-size: 13px;
        }

        .mc-hay {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mc-hay__btn {
            padding: 10px 12px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            background: #fff;
            cursor: pointer;
            font-weight: 900;
            font-size: 13px;
            transition: opacity .12s ease, border-color .12s ease, background .12s ease;
        }

        .mc-hay__btn.is-picked {
            opacity: .6;
            border-color: rgba(76, 76, 255, .35);
            background: rgba(76, 76, 255, .06);
        }

        /* ===== NEW: MULTI_SELECT_IMAGE ===== */
        .mc-msi {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mc-msi__imgBox {
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            overflow: hidden;
            background: #fff;
        }

        .mc-msi__img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ===== NEW: IMAGE_HOTSPOT_PICK ===== */
        .mc-hot {
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            overflow: hidden;
            background: #fff;
        }

        .mc-hot__frame {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        .mc-hot__img {
            width: 100%;
            height: auto;
            display: block;
        }

        .mc-hot__spot {
            position: absolute;
            transform: translate(-50%, -50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, .9);
            background: rgba(76, 76, 255, .85);
            box-shadow: 0 10px 20px rgba(20, 22, 60, .18);
            cursor: pointer;
            display: grid;
            place-items: center;
            user-select: none;
            transition: transform .08s ease, opacity .12s ease, background .12s ease;
        }

        .mc-hot__spot:active {
            transform: translate(-50%, -50%) scale(.98);
        }

        .mc-hot__spot.is-picked {
            background: rgba(20, 164, 77, .92);
        }

        .mc-hot__spot.is-wrong {
            background: rgba(211, 47, 47, .90);
        }

        .mc-hot__check {
            width: 20px;
            height: 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .92);
            display: grid;
            place-items: center;
            font-weight: 900;
            color: var(--mc-dark);
            font-size: 13px;
        }

        .mc-hot__label {
            position: absolute;
            transform: translate(-50%, calc(-50% - 26px));
            background: #fff;
            border: 1px solid var(--mc-border);
            border-radius: 12px;
            padding: 6px 8px;
            font-weight: 900;
            font-size: 12px;
            color: var(--mc-dark);
            white-space: nowrap;
            box-shadow: var(--mc-shadow);
            pointer-events: none;
        }

        .mc-hot__legend {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .mc-hot__legendItem {
            border: 1px solid var(--mc-border);
            background: #fff;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 900;
            color: var(--mc-muted);
        }

        .mc-hot__legendItem strong {
            color: var(--mc-dark);
        }

        @media (max-width: 980px) {
            .mc-app {
                grid-template-columns: 1fr;
            }
        }

        /* ==========================================================
           UI FIX: Layout tipo "app" con scroll interno (no gestión)
           ========================================================== */

        /* 1) Viewport-height layout */
        html, body {
            height: 100%;
        }

        body {
            overflow: hidden;
        }

        /* evita scroll global feo */

        .mc-app {
            height: 100vh;
            align-content: start;
        }

        /* 2) Header sticky */
        .mc-header {
            position: sticky;
            top: 12px;
            z-index: 20;
        }

        /* 3) Panels: ocupar altura disponible y permitir scroll interno */
        .mc-panel {
            min-height: 0; /* clave para grids + overflow */
            height: calc(100vh - 18px - 18px - 86px);
            /* 18+18 padding top/bottom de .mc-app, 86 aprox header */
            display: flex;
            flex-direction: column;
        }

        .mc-panel__body {
            flex: 1;
            min-height: 0;
            overflow: auto;
        }

        /* 4) Steps list: que no empuje el layout */
        .mc-steps {
            max-height: none;
        }

        /* 5) Ejercicio: evitar saltos visuales */
        .mc-ex__stage {
            position: relative;
        }

        .mc-ex__result {
            margin-top: 12px;
        }

        /* 6) Tokens/haystack: más “táctil” */
        .mc-tokenList__item,
        .mc-hay__btn,
        .mc-step,
        .mc-btn {
            -webkit-tap-highlight-color: transparent;
        }

        .mc-tokenList__item:active,
        .mc-hay__btn:active {
            transform: translateY(1px);
        }

        /* 7) Hotspots: labels menos invasivos */
        .mc-hot__label {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* 8) Responsive: en móvil permitir scroll global (porque sticky + 100vh en iOS a veces) */
        @media (max-width: 980px) {
            body {
                overflow: auto;
            }

            .mc-app {
                height: auto;
                padding: 12px;
            }

            .mc-header {
                position: relative;
                top: auto;
            }

            .mc-panel {
                height: auto;
            }

            /* Hotspot labels se esconden en móvil para no tapar imagen */
            .mc-hot__label {
                display: none;
            }

            .mc-header__subtitle {
                max-width: 100%;
            }
        }

        body.mc-is-scrolling .mc-header {
            padding: 12px;
            backdrop-filter: blur(8px);
        }

        body.mc-is-scrolling .mc-header__subtitle {
            display: none;
        }

    </style>
    <style>
        :root {
            --mc-nav-h: 64px; /* ajusta al alto real de tu navbar */
        }

        a.to-top--contact-whatsapp.chat-widget-button-content {
            display: none;
        }

        a.to-top.to-top--bee {
            display: none !important;
        }
    </style>
    <style>


        /* ====== Layout general ====== */
        .mc-elements {
            width: 100vw;
            margin: 0px auto;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0px;
        }

        /* Tablet */
        @media (max-width: 992px) {
            .mc-elements {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .mc-element__stack {

                gap: 0px !important;
            }
        }


        /* Mobile: cada sección hacia abajo */
        @media (max-width: 560px) {
            .mc-elements {
                width: 100%;
                margin-right: 0px;
                margin-left: 0px !important;
                grid-template-columns: 1fr;
            }

            .mc-element__stack {

                gap: 0px !important;
            }
        }

        /* ====== Section (Elemento) ====== */
        .mc-element {
            width: 100%;
            height: calc((95dvh - var(--mc-nav-h)) * 1);

            display: flex;
            flex-direction: column;

            background-image: var(--mc-banner);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* ✅ el banner es un pseudo-element */

        .mc-element__photo {
            width: 100%;
            height: 22%; /* ✅ parte del 80vh (ajusta: 20%–30%) */
            min-height: 140px; /* para que no se haga muy pequeño */
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .mc-element__head {
            margin-bottom: 12px;
            display: none;
        }

        .mc-element__title {
            font-weight: 900;
            font-size: clamp(22px, 2.6vw, 40px);
            margin: 0;
            color: #3c3c3c;
        }

        .mc-element__subtitle {
            margin-top: 4px;
            font-size: 14px;
            opacity: .75;
        }

        /* stack de wheels */
        .mc-element__stack {
            display: grid;
            gap: 18px;
            justify-items: center;
            align-items: center;
            overflow: inherit;
            overflow: inherit;
        }

        /* ====== Wheel ====== */
        .mc-wheel {
            position: relative;
            width: var(--mc-wheel-size, 120px);
            height: var(--mc-wheel-size, 120px);
            padding: 0px; /* espacio para sombra/glow */
            overflow: visible;
        }

        .mc-wheel__svg {
            display: block;
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        .mc-wheel__hit-gap {
            stroke: #fff;
            stroke-width: 2;
        }

        .mc-wheel__sector {
            cursor: pointer;
            transition: filter .18s ease, opacity .18s ease, transform .18s ease;
            transform-origin: 0 0;
        }

        .mc-wheel__sector:hover {
            filter: brightness(1.08);
        }

        .mc-wheel__sector.is-active {
            filter: brightness(1.14);
        }

        .mc-wheel.is-disabled {
            opacity: .45;
            filter: grayscale(.25);
        }

        .mc-wheel__sector.is-disabled {
            cursor: not-allowed;
            opacity: .45;
            filter: none;
        }

        .mc-wheel__sector.is-disabled:hover {
            filter: none;
        }

        /* ====== Center ====== */
        .mc-wheel__center {
            position: absolute;
            /*    left: 50%;*/
            top: 50%;
            transform: translate(-50%, -50%);
            width: var(--mc-center-size, 48px);
            height: var(--mc-center-size, 48px);
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 10px 22px rgba(0, 0, 0, .08);
            display: grid;
            place-items: center;
        }

        .mc-wheel__center-img {
            width: var(--mc-center-img-size, 34px);
            height: var(--mc-center-img-size, 34px);
            border-radius: 999px;
            object-fit: contain;
            display: block;
            max-width: none;
            transition: opacity .18s ease, filter .18s ease;
        }

        .mc-wheel__center-img.is-disabled {
            opacity: .35;
            filter: grayscale(1);
            pointer-events: none;
        }

        /* ====== Pulse seguro (NO scale) ====== */
        .mc-wheel__svg.is-pulsing {
            animation: mcWheelGlow var(--mc-pulse-ms, 1200ms) ease-in-out infinite;
            transform: none !important; /* blindaje */
        }

        @keyframes mcWheelGlow {
            0% {
                filter: drop-shadow(0 0 0 rgba(0, 0, 0, 0));
            }
            50% {
                filter: drop-shadow(0 10px 18px rgba(0, 0, 0, .12));
            }
            100% {
                filter: drop-shadow(0 0 0 rgba(0, 0, 0, 0));
            }
        }

        section.mc-element {
            display: block;
            unicode-bidi: isolate;
        }


    </style>

    <style id="not-allow-styles">
        a {

            text-decoration: none !important;
        }
    </style>
    @include('partials.bootstrap-05',["allowCss"=>true])

@endsection
@section('additional-scripts')
    @include('partials.bootstrap-05',["allowJs"=>true])
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        function placeCenterByViewBox(wheelId, viewBoxStr) {
            // viewBoxStr: "-90 -110 220 220"
            const [minX, minY, w, h] = viewBoxStr.split(/\s+/).map(Number);

            const leftPct = ((0 - minX) / w) * 100;
            const topPct = ((0 - minY) / h) * 100;

            const $wheel = $("#" + wheelId);
            $wheel.find(".mc-wheel__center").css({
                left: leftPct + "%",
                // top:  topPct + "%"
            });
        }

        (function ($) {
            function polarToCartesian(r, angleDeg) {
                const a = (angleDeg - 90) * Math.PI / 180;
                return {x: r * Math.cos(a), y: r * Math.sin(a)};
            }

            function describeSectorPath(rOuter, rInner, startAngle, endAngle) {
                const p1 = polarToCartesian(rOuter, endAngle);
                const p2 = polarToCartesian(rOuter, startAngle);
                const p3 = polarToCartesian(rInner, startAngle);
                const p4 = polarToCartesian(rInner, endAngle);
                const largeArc = (endAngle - startAngle) <= 180 ? "0" : "1";

                return [
                    `M ${p1.x} ${p1.y}`,
                    `A ${rOuter} ${rOuter} 0 ${largeArc} 0 ${p2.x} ${p2.y}`,
                    `L ${p3.x} ${p3.y}`,
                    `A ${rInner} ${rInner} 0 ${largeArc} 1 ${p4.x} ${p4.y}`,
                    "Z"
                ].join(" ");
            }

            function clampParts(n) {
                return Math.max(2, Math.min(6, n));
            }

            function setWheelEnabled($root, enabled) {
                $root.toggleClass("is-disabled", !enabled);
                $root.attr("aria-disabled", enabled ? "false" : "true");
                if (!enabled) $root.find(".mc-wheel__svg").removeClass("is-pulsing");
            }

            function setCenterEnabled($root, enabled) {
                $root.find(".mc-wheel__center-img").toggleClass("is-disabled", !enabled);
            }

            function buildWheel($root, options) {
                console.log("hola entro", options, $root);

                const cfg = $.extend(true, {
                    enabled: options.enabled,
                    pulse: true,
                    pulseMs: 1200,
                    centerEnabled: options.centerEnabled,
                    centerImageUrl: options.centerImageUrl,
                    size: options.size,
                    parts: options.parts,
                    rOuter: 80,
                    ringThickness: options.ringThickness,
                    startOffsetDeg: 0,
                    centerSize: 48,
                    centerImgSize: 34,
                    sectors: [],
                    onClick: function () {
                    },
                    onCenterClick: function () {
                    }
                }, options || {});
                const el = $root.get(0);
// si hay soporte de CSS variables
                if (window.CSS && CSS.supports && CSS.supports("color", "var(--x)")) {
                    el.style.setProperty("--mc-wheel-size", cfg.size + "px");
                    el.style.setProperty("--mc-center-size", cfg.centerSize + "px");
                    el.style.setProperty("--mc-center-img-size", cfg.centerImgSize + "px");
                } else {
                    // fallback directo
                    $root.css({width: cfg.size + "px", height: cfg.size + "px"});
                    $root.find(".mc-wheel__center").css({
                        width: cfg.centerSize + "px",
                        height: cfg.centerSize + "px"
                    });
                    $root.find(".mc-wheel__center-img").css({
                        width: cfg.centerImgSize + "px",
                        height: cfg.centerImgSize + "px"
                    });
                }

                var svgConfig = options.svgConfig;
                const $svg = $root.find(".mc-wheel__svg");
                $svg.attr("viewBox", svgConfig.viewBox);
                placeCenterByViewBox(options.id, svgConfig.viewBox)
                setWheelEnabled($root, cfg.enabled);
                $svg.toggleClass("is-pulsing", cfg.enabled && cfg.pulse);

                if (cfg.centerImageUrl) $root.find(".mc-wheel__center-img").attr("src", cfg.centerImageUrl);
                setCenterEnabled($root, cfg.centerEnabled);
                $root.find(".mc-wheel__center")
                    .off("click.mcWheelCenter")
                    .on("click.mcWheelCenter", function () {
                        if (!cfg.enabled) return;
                        if (!cfg.centerEnabled) return;
                        cfg.onCenterClick(cfg);
                    });
                if (cfg.parts > 0) {
                    cfg.parts = clampParts(options.parts);


                    const rInner = Math.max(5, cfg.rOuter - cfg.ringThickness);
                    const sectors = [];


                    for (let i = 0; i < cfg.parts; i++) {
                        const s = cfg.sectors[i] || {};
                        sectors.push({
                            id: s.id ?? `p${i + 1}`,
                            color: s.color ?? "#EAF0FF",
                            hover: s.hover ?? "#D7E2FF",
                            enabled: (s.enabled !== undefined) ? !!s.enabled : true,
                            title: s.title ?? `Sector ${i + 1}`,
                            subtitle: s.subtitle ?? "",
                            description: s.description ?? ""
                        });
                    }

                    const $g = $root.find(".mc-wheel__sectors").empty();
                    const step = 360 / cfg.parts;
                    sectors.forEach((s, i) => {
                        const start = cfg.startOffsetDeg + (i * step);
                        const end = cfg.startOffsetDeg + ((i + 1) * step);
                        const d = describeSectorPath(cfg.rOuter, rInner, start, end);

                        const $path = $(document.createElementNS("http://www.w3.org/2000/svg", "path"))
                            .attr("d", d)
                            .attr("fill", s.color)
                            .attr("data-color", s.color)
                            .attr("data-hover", s.hover)
                            .attr("data-id", s.id)
                            .addClass("mc-wheel__sector mc-wheel__hit-gap")
                            .toggleClass("is-disabled", !s.enabled);

                        $path.on("mouseenter", function () {
                            if (!cfg.enabled || !s.enabled) return;
                            $(this).attr("fill", $(this).data("hover"));
                        });

                        $path.on("mouseleave", function () {
                            $(this).attr("fill", $(this).data("color"));
                        });

                        $path.on("click", function () {
                            if (!cfg.enabled || !s.enabled) return;
                            $root.find(".mc-wheel__sector").removeClass("is-active");
                            $(this).addClass("is-active");
                            cfg.onClick(s, i, cfg);
                        });

                        $g.append($path);
                    });


                    $root.data("mcWheelCfg", cfg);

                }
            }

            $.fn.mcWheel = function (options) {
                return this.each(function () {
                    buildWheel($(this), options);
                });
            };
        })(jQuery);

        /* ====== DATA ====== */
        const ICONS = {
            viento: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4a8.svg",
            agua: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f4a7.svg",
            tierra: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1faa8.svg",
            fuego: "https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f525.svg"
        };

        const PALETTES = {
            viento: {a: "#DDF1FF", b: "#CBEAFF", h: "#BFE4FF"},
            agua: {a: "#1EA1E6", b: "#5BC0F3", h: "#0D8DD2"},
            tierra: {a: "#E6C27A", b: "#D9A94E", h: "#C99433"},
            fuego: {a: "#D9D9D9", b: "#BDBDBD", h: "#AFAFAF", hot: "#E53935"}
        };


        var ELEMENTS_DATA = [];

        function render() {
            const $app = $("#app").empty();
            var haystack = $dataManagerPage.languageCoursePayload.data;
            $.each(haystack.units, function (key, value) {
                var items = [];


                $.each(value.sections, function (keySection, valueSection) {
                    var sectors = [];
                    var parts = valueSection.items.length;
                    $.each(valueSection.items, function (keyData, valueData) {
                        console.log(valueData);
                        var web_config = valueData.ui_ux.web_config;
                        var palettes = web_config.palettes;
                        var setData = {
                            id: valueData.id,
                            enabled: true,
                            color: palettes.main,
                            hover: palettes.hover,
                            item_kind: valueData.item_kind,
                            subtitle: valueData.subtitle,
                            weight: valueData.weight
                        };
                        sectors.push(setData);
                    });
                    var web_config = valueSection.ui_ux.web_config;
                    var palettes = web_config.palettes;

                    var viewBox = web_config.svgConfig.viewBox;
                    var setPushItems = {
                        id: valueSection.id,
                        enabled: true,
                        centerEnabled: true,
                        size: 120,
                        parts: parts,
                        rOuter: 80,
                        ringThickness: 25,
                        svgConfig: {
                            viewBox: viewBox
                        },
                        centerImageUrl: web_config.icon.url_source,
                        sectors: sectors,
                        subtitle: valueSection.subtitle,
                        title: valueSection.title,
                        weight: valueSection.weight
                    };

                    items.push(setPushItems);
                });
                var background = null;


                if (value.id == 1) {
                    background = $resources.wayra;
                } else if (value.id == 2) {
                    background = $resources.yaku;

                } else if (value.id == 3) {
                    background = $resources.allpa;

                } else if (value.id == 4) {
                    background = $resources.nina;

                }
                var setPush = {
                    key: value.id, title: value.value, kichwa: value.subtitle, enabled: true,
                    background: background,
                    items: items.sort(function (a, b) {
                        return (parseInt(b.weight, 10) || 0) - (parseInt(a.weight, 10) || 0);
                    })
                };
                ELEMENTS_DATA.push(setPush);


            });
            // usa el que venga, fallback

            ELEMENTS_DATA.forEach(section => {
                const bannerUrl = section.background;
                const $col = $(`
      <div class="mc-element" data-key="${section.key}" style="--mc-banner: url('${bannerUrl}');">

        <div class="mc-element__head">
          <h2 class="mc-element__title">${section.title}</h2>
          <div class="mc-element__subtitle">${section.kichwa}</div>
        </div>
        <div class="mc-element__stack" id="stack_${section.key}"></div>
      </div>
    `);

                $app.append($col);

                const $stack = $col.find("#stack_" + section.key);

                section.items.forEach(wheel => {
                    $stack.append(`
        <div class="mc-wheel" id="${wheel.id}">
          <svg class="mc-wheel__svg" id="mc-wheel__svg-${wheel.id}"><g class="mc-wheel__sectors"></g></svg>
          <div class="mc-wheel__center">
            <img class="mc-wheel__center-img" alt="icon"/>
          </div>
        </div>
      `);

                    const finalWheelEnabled = section.enabled && wheel.enabled;

                    $("#" + wheel.id).mcWheel({
                        id: wheel.id,
                        enabled: finalWheelEnabled,
                        centerEnabled: finalWheelEnabled && wheel.centerEnabled,
                        size: wheel.size,
                        parts: wheel.parts,
                        rOuter: wheel.rOuter,
                        ringThickness: wheel.ringThickness,
                        startOffsetDeg: wheel.startOffsetDeg,
                        centerImageUrl: wheel.centerImageUrl,
                        centerSize: wheel.centerSize,
                        centerImgSize: wheel.centerImgSize,
                        pulse: (wheel.pulse),
                        pulseMs: wheel.pulseMs,
                        sectors: wheel.sectors,
                        svgConfig: wheel.svgConfig,
                        onClick: function (sector, idx) {
                            // alert(`section=${section.key} wheel=${wheel.id} sector=${sector.id} idx=${idx}`);
                        },
                        onCenterClick: function () {
                            function modalTemplate() {
                                return `
      <div class="modal-header">
        <h5 class="modal-title">Wizard Steps</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-0">
        <div id="stepsHost" class="p-3">Cargando…</div>
      </div>
    `;
                            }

                            openDynamicModal({
                                id: "dynamicModal", // 👈 importante si tu openDynamicModal soporta id
                                fullscreen: true,
                                options: {backdrop: "static", keyboard: false},

                                template: modalTemplate,

                                // OJO: mejor usar show.bs.modal para inyectar el HTML (antes del shown)
                                onShow: () => {
                                    // no obligatorio, pero recomendado
                                },

                                onShown: () => {


                                    // helper: layout de tu app dentro del modal
                                    function mountStepsLayout() {
                                        const host = document.getElementById("stepsHost");
                                        if (!host) return;

                                        host.innerHTML = `
      <main class="mc-panel">
        <div class="mc-panel__head">
          <div>
            <h2>2) Resuelve el ejercicio del step</h2>
            <div class="mc-panel__hint">
              Presiona <strong>“Verificar”</strong>.
              ✅ Correcto: PASSED y avanza.
              ❌ Incorrecto: suma intento. A los 3 intentos: FAILED y avanza.
            </div>
          </div>
          <div class="mc-chip mc-chip--info" id="mcChipActive">Step: —</div>
        </div>

        <div class="mc-panel__body">
          <div class="mc-steps" id="mcStepsList"></div>
          <div class="mc-ex" id="mcExerciseRoot">
            <div class="mc-chip">Cargando…</div>
          </div>
        </div>
      </main>
    `;
                                    }

                                    // 1) inyecta UI
                                    mountStepsLayout();

                                    // 2) carga data directa (sin botones)

                                    var jsonCurrent = SAMPLE_JSON;

                                    var random = Math.floor(Math.random() * 7);

                                    if (random == 0) {
                                        jsonCurrent.steps = BLOCK_1;
                                    } else if (random == 1) {
                                        jsonCurrent.steps = BLOCK_2_NAPAYKUN_SALUDOS;
                                    } else if (random == 2) {
                                        jsonCurrent.steps = BLOCK_3_TAPUYKUNA_SALUDOS;
                                    } else if (random == 3) {
                                        jsonCurrent.steps = BLOCK_4_MISHKIMURUKUNA_FRUTAS;
                                    } else if (random == 4) {
                                        jsonCurrent.steps = BLOCK_5_RUNAPA_UKKU_HOTSPOTS;
                                    } else if (random == 5) {
                                        jsonCurrent.steps = BLOCK_6_ALETORI;
                                    }
                                    bootstrapFromJSON(SAMPLE_JSON);
                                },

                                onHide: (ctx, ev) => {
                                    const saving = ctx.modalEl.dataset.saving === "1";
                                    if (saving) ev.preventDefault();
                                },

                                onHidePrevented: () => {
                                    console.log("Intentó cerrar, pero está bloqueado");
                                },

                                onHidden: () => {
                                    // opcional: limpiar UI (progreso queda en localStorage igual)
                                    const host = document.getElementById("stepsHost");
                                    if (host) host.innerHTML = "—";
                                    console.log("Cerrado: cleanup listo");
                                }
                            });

                        }
                    });
                });
            });
        }


    </script>
    <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/0-5-1/snap.svg-min.js") }}"
            type="text/javascript"></script>

    <script id="test-management-js">
        // ==========================================================
        // IMPORTANT:
        // - NO script id="sampler-json" (como pediste).
        // - SOURCE genérico: usa step.source y/o payload.source_url
        // - Persistencia total: localStorage (progreso) + sessionId
        // ==========================================================

        // ---------------------------
        // Storage + Session
        // ---------------------------
        const STORAGE_KEY = "mc_steps_progress_v3";
        const DEFAULT_ATTEMPTS_MAX = 3;

        const SESSION_KEY = "mc_steps_session_id_v1";
        const SESSION_ID = (function () {
            const existing = localStorage.getItem(SESSION_KEY);
            if (existing) return existing;
            const id = "sess_" + Date.now() + "_" + Math.random().toString(16).slice(2);
            localStorage.setItem(SESSION_KEY, id);
            return id;
        })();

        // ---------------------------
        // App State
        // ---------------------------
        let APP = {
            data: null,
            activeIndex: 0,
            progress: {},    // step_id -> progress state
            api: null
        };

        // ---------------------------
        // Utilities
        // ---------------------------
        function safeParseJSON(txt) {
            try {
                return JSON.parse(txt);
            } catch (e) {
                return null;
            }
        }

        function normStr(s) {
            return (s ?? "").toString();
        }

        function deepEqualSorted(a, b) {
            const aa = [...a].sort();
            const bb = [...b].sort();
            return aa.length === bb.length && aa.every((v, i) => v === bb[i]);
        }

        function shuffle(arr) {
            const a = [...arr];
            for (let i = a.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [a[i], a[j]] = [a[j], a[i]];
            }
            return a;
        }

        function nowISO() {
            return new Date().toISOString();
        }

        function loadProgress() {
            const raw = localStorage.getItem(STORAGE_KEY);
            APP.progress = raw ? (safeParseJSON(raw) || {}) : {};
        }

        function saveProgress() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(APP.progress));
        }

        function resetProgress() {
            APP.progress = {};
            APP.activeIndex = 0;
            saveProgress();
        }

        // ---------------------------
        // Progress model per step
        // ---------------------------
        function getStepProgress(step) {
            const sid = step.step_id;
            if (!APP.progress[sid]) {
                APP.progress[sid] = {
                    session_id: SESSION_ID,
                    status: "IN_PROGRESS",     // IN_PROGRESS | PASSED | FAILED
                    attempts: 0,
                    attemptsMax: DEFAULT_ATTEMPTS_MAX,
                    verifiedCount: 0,
                    openedCount: 0,
                    lastAnswer: null,
                    lastResult: null,
                    history: [] // capped
                };
                saveProgress();
            }
            return APP.progress[sid];
        }

        function isStepPassed(step) {
            return getStepProgress(step).status === "PASSED";
        }

        function isStepFailed(step) {
            return getStepProgress(step).status === "FAILED";
        }

        function isStepDone(step) {
            const st = getStepProgress(step).status;
            return st === "PASSED" || st === "FAILED";
        }

        function getGateIndex() {
            if (!APP.data?.steps?.length) return 0;
            for (let i = 0; i < APP.data.steps.length; i++) {
                if (!isStepDone(APP.data.steps[i])) return i;
            }
            return APP.data.steps.length - 1;
        }

        function canOpenStep(index) {
            if (!APP.data?.steps?.length) return false;
            const step = APP.data.steps[index];
            if (isStepDone(step)) return true;
            return index === getGateIndex();
        }

        function logEvent(step, payload) {
            const p = getStepProgress(step);
            p.history.push({
                ts: nowISO(),
                session_id: SESSION_ID,
                step_id: step.step_id,
                unidad_id: step.unidad_id ?? null,
                unidad_seccion_id: step.unidad_seccion_id ?? null,
                configuracion_ui_ux_id: step.configuracion_ui_ux_id ?? null,
                exercise_id: step.exercise?.exercise_id || null,
                type: step.exercise?.type || null,
                ...payload
            });
            if (p.history.length > 250) p.history = p.history.slice(-250);
            saveProgress();
        }

        // ---------------------------
        // Generic "source" resolver
        // ---------------------------
        function resolveSource(step, exPayload) {
            // Prioridad:
            // 1) step.source (tu JSON ya lo tiene)
            // 2) payload.source_url / payload.source
            // 3) meta.base_media_url + step.source
            const base = normStr(APP.data?.meta?.base_media_url || "");
            const stepSource = normStr(step?.source || "");
            const pSource = normStr(exPayload?.source_url || exPayload?.source || "");

            let src = stepSource || pSource || "";
            if (base && src && !src.startsWith("http") && !src.startsWith("data:")) {
                // evitar doble slash
                if (base.endsWith("/") && src.startsWith("/")) src = base.slice(0, -1) + src;
                else if (!base.endsWith("/") && !src.startsWith("/")) src = base + "/";
                else if (!base.endsWith("/") && src.startsWith("/")) src = base + src;
                else src = base + src;
            }
            return src;
        }

        // ---------------------------
        // Chips
        // ---------------------------
        function updateTopChips() {
            const total = APP.data?.steps?.length || 0;
            $("#mcChipTotal").text("Steps: " + total);

            const passedCount = total ? APP.data.steps.filter(s => isStepPassed(s)).length : 0;
            const pct = total ? Math.round((passedCount / total) * 100) : 0;
            $("#mcChipProgress").text("Progreso: " + pct + "%");

            const gateIndex = total ? getGateIndex() : 0;
            const gateStep = total ? APP.data.steps[gateIndex] : null;
            $("#mcChipGate")
                .removeClass("mc-chip--bad mc-chip--ok mc-chip--info")
                .addClass(gateStep ? "mc-chip--info" : "mc-chip--bad")
                .text("Gate: " + (gateStep ? gateStep.step_id : "—"));

            const state = APP.data ? "JSON cargado" : "Sin cargar";
            $("#mcChipState")
                .toggleClass("mc-chip--info", !!APP.data)
                .toggleClass("mc-chip--bad", !APP.data)
                .text(state);

            $("#mcChipSession").text("Session: " + SESSION_ID);
        }

        // ---------------------------
        // Steps list
        // ---------------------------
        function renderStepsList() {
            const $list = $("#mcStepsList").empty();
            if (!APP.data?.steps?.length) {
                $list.append(`<div class="mc-chip">No hay steps.</div>`);
                return;
            }

            const gateIndex = getGateIndex();

            APP.data.steps.forEach((s, idx) => {
                const prog = getStepProgress(s);
                const passed = prog.status === "PASSED";
                const failed = prog.status === "FAILED";
                const locked = !isStepDone(s) && idx !== gateIndex;
                const isActive = idx === APP.activeIndex;

                let stateLabel = "Bloq.";
                let stateClass = "is-bad";
                if (passed) {
                    stateLabel = "OK";
                    stateClass = "is-ok";
                } else if (failed) {
                    stateLabel = "NO";
                    stateClass = "is-bad";
                } else if (idx === gateIndex) {
                    stateLabel = "Ahora";
                    stateClass = "is-next";
                }

                const $row = $(`
        <div class="mc-step ${isActive ? "is-active" : ""} ${locked ? "is-locked" : ""}" data-index="${idx}">
          <div class="mc-step__left">
            <div class="mc-step__kicker">
              ${normStr(s.activity)} • ${normStr(s.step_id)} • intentos: ${prog.attempts}/${prog.attemptsMax}
            </div>
            <div class="mc-step__title">${normStr(s.title)}</div>
          </div>
          <div class="mc-step__right">
            <div class="mc-step__badge">${idx + 1}</div>
            <div class="mc-step__state ${stateClass}">${stateLabel}</div>
          </div>
        </div>
      `);

                $row.on("click", function () {
                    const index = Number($(this).data("index"));
                    if (!canOpenStep(index)) return;
                    setActiveStep(index);
                });

                $list.append($row);
            });
        }

        // ---------------------------
        // Exercise view
        // ---------------------------
        function setActiveStep(index) {
            APP.activeIndex = index;
            const step = APP.data.steps[index];
            $("#mcChipActive").text("Step: " + step.step_id);

            const prog = getStepProgress(step);
            prog.openedCount += 1;
            logEvent(step, {action: "OPEN_STEP"});

            renderStepsList();
            renderExercise(step);
            updateTopChips();
        }

        function renderExercise(step) {
            const root = document.getElementById("mcExerciseRoot");
            root.innerHTML = "";

            const ex = step.exercise;
            if (!ex || !ex.type) {
                root.innerHTML = `<div class="mc-chip mc-chip--bad">Este step no tiene exercise definido.</div>`;
                APP.api = null;
                return;
            }

            const prog = getStepProgress(step);
            const exPayload = ex.payload || {};
            const sourceResolved = resolveSource(step, exPayload);

            // Header
            const top = document.createElement("div");
            top.className = "mc-ex__top";
            top.innerHTML = `
      <div class="mc-ex__meta">
        <h3 class="mc-ex__metaTitle">${normStr(step.title)}</h3>
        <div class="mc-ex__metaSub">
          <div><strong>${normStr(step.activity)}</strong></div>
          <div>${normStr(step.description)}</div>
          <div style="margin-top:6px;">
            <span class="mc-chip mc-chip--info">Tipo: <strong>${normStr(ex.type)}</strong></span>
            <span class="mc-chip">Intentos: <strong>${prog.attempts}/${prog.attemptsMax}</strong></span>
          </div>

          ${sourceResolved ? `
            <div class="mc-audio">
              <audio class="mc-audio__player" controls preload="none" src="${sourceResolved}"></audio>
              <div class="mc-audio__src" title="${sourceResolved}">${sourceResolved}</div>
            </div>
          ` : ``}
        </div>
      </div>
      <div class="mc-ex__controls">
        <button class="mc-btn mc-btn--primary" id="mcBtnVerify">✅ Verificar</button>
        <button class="mc-btn" id="mcBtnShowAnswer">🧾 Ver respuesta (JSON)</button>
        <button class="mc-btn" id="mcBtnShowHistory">📜 Historial step</button>
      </div>
    `;
            root.appendChild(top);

            // Stage
            const stage = document.createElement("div");
            stage.className = "mc-ex__stage";
            stage.innerHTML = `
      <div class="mc-ex__prompt">${normStr(ex.prompt || "Resuelve:")}</div>
      <div id="mcExStage"></div>
      <div id="mcExResult" class="mc-ex__result" style="display:none;"></div>
    `;
            root.appendChild(stage);

            // Answer box
            const ansBox = document.createElement("div");
            ansBox.className = "mc-ex__stage";
            ansBox.style.display = "none";
            ansBox.innerHTML = `
      <div class="mc-ex__prompt">Respuesta del usuario (JSON)</div>
      <textarea class="mc-loader__textarea" id="mcUserAnswerBox" style="min-height:130px;"></textarea>
    `;
            root.appendChild(ansBox);

            // History box
            const histBox = document.createElement("div");
            histBox.className = "mc-ex__stage";
            histBox.style.display = "none";
            histBox.innerHTML = `
      <div class="mc-ex__prompt">Historial del step (máx. 250 eventos)</div>
      <textarea class="mc-loader__textarea" id="mcUserHistoryBox" style="min-height:150px;"></textarea>
    `;
            root.appendChild(histBox);

            // Mount exercise
            const mount = document.getElementById("mcExStage");
            APP.api = mountExercise(mount, ex);

            // ✅ UI restore: mostrar lo último elegido por el usuario (si ya existe lastAnswer)
            try {
                if (APP.api && typeof APP.api.setAnswer === "function" && prog.lastAnswer) {
                    APP.api.setAnswer(prog.lastAnswer);
                }
            } catch (e) {
                // solo UI restore, no debe romper la app
                console.warn("UI restore failed:", e);
            }

            // Bind buttons
            $("#mcBtnShowAnswer").off("click").on("click", () => {
                if (!APP.api) return;
                const ans = APP.api.getAnswer();
                ansBox.style.display = ansBox.style.display === "none" ? "block" : "none";
                $("#mcUserAnswerBox").val(JSON.stringify(ans, null, 2));
            });

            $("#mcBtnShowHistory").off("click").on("click", () => {
                const p = getStepProgress(step);
                histBox.style.display = histBox.style.display === "none" ? "block" : "none";
                $("#mcUserHistoryBox").val(JSON.stringify(p.history || [], null, 2));
            });

            // Verify (Duolingo-like)
            $("#mcBtnVerify").off("click").on("click", () => {
                if (!APP.api) return;

                const prog = getStepProgress(step);

                // If already resolved, do not re-check
                if (prog.status !== "IN_PROGRESS") {
                    const msg = prog.status === "PASSED"
                        ? "Este step ya está aprobado ✅."
                        : `Este step ya está marcado como NO PASADO ❌ (${prog.attemptsMax} intentos).`;
                    $("#mcExResult").show()
                        .removeClass("is-ok is-bad")
                        .addClass(prog.status === "PASSED" ? "is-ok" : "is-bad")
                        .text(msg);

                    logEvent(step, {action: "VERIFY_BLOCKED_ALREADY_DONE"});
                    return;
                }

                const answer = APP.api.getAnswer();
                const result = APP.api.check();

                prog.verifiedCount += 1;
                prog.lastAnswer = answer;
                prog.lastResult = result;

                logEvent(step, {action: "VERIFY", ok: !!result.ok, answer, result});

                const $res = $("#mcExResult");
                $res.show()
                    .toggleClass("is-ok", !!result.ok)
                    .toggleClass("is-bad", !result.ok);

                if (result.ok) {
                    prog.status = "PASSED";
                    saveProgress();

                    $res.text("✅ Correcto. Pasas al siguiente.");
                    logEvent(step, {action: "STEP_PASSED"});

                    renderStepsList();
                    updateTopChips();

                    const nextGate = getGateIndex();
                    if (nextGate !== APP.activeIndex) setActiveStep(nextGate);
                    return;
                }

                // Incorrect
                prog.attempts += 1;
                const left = Math.max(0, prog.attemptsMax - prog.attempts);

                if (prog.attempts >= prog.attemptsMax) {
                    prog.status = "FAILED";
                    saveProgress();

                    $res.text(`❌ Incorrecto. Llegaste a ${prog.attemptsMax} intentos. Este step queda NO PASADO y puedes continuar.`);
                    logEvent(step, {action: "STEP_FAILED_MAX_ATTEMPTS"});

                    renderStepsList();
                    updateTopChips();

                    const nextGate = getGateIndex();
                    if (nextGate !== APP.activeIndex) setActiveStep(nextGate);
                    return;
                }

                saveProgress();
                $res.text(`❌ Incorrecto. Te quedan ${left} intento(s).`);
                logEvent(step, {action: "STEP_ATTEMPT_FAILED", attempts: prog.attempts, left});

                renderStepsList();
                updateTopChips();
            });

            // If previously done, show status immediately
            if (prog.status === "PASSED") {
                $("#mcExResult").show().removeClass("is-bad").addClass("is-ok").text("✅ Este step ya está aprobado.");
            } else if (prog.status === "FAILED") {
                $("#mcExResult").show().removeClass("is-ok").addClass("is-bad").text("❌ Este step quedó NO PASADO (3 intentos). Puedes continuar.");
            }
        }

        // ---------------------------
        // Exercise router
        // ---------------------------
        function mountExercise(container, ex) {
            const type = ex.type;
            const payload = ex.payload || {};

            if (type === "FILL_BLANK") return renderFillBlank(container, payload);
            if (type === "ORDER_WORDS") return renderOrderWords(container, payload);
            if (type === "DRAG_MATCH") return renderDragMatch(container, payload);
            if (type === "MULTI_SELECT") return renderMultiSelect(container, payload);
            if (type === "HAYSTACK_PICK") return renderHaystackPick(container, payload);

            // NEW (2)
            if (type === "MULTI_SELECT_IMAGE") return renderMultiSelectImage(container, payload);
            if (type === "IMAGE_HOTSPOT_PICK") return renderImageHotspotPick(container, payload);

            container.innerHTML = `<div class="mc-chip mc-chip--bad">Tipo no soportado: ${normStr(type)}</div>`;
            return null;
        }

        // ---------------------------
        // Exercises (existing)
        // ---------------------------

        // FILL_BLANK
        function renderFillBlank(container, payload) {
            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Completar</div>
      <div class="mc-dropzone" style="border-style:solid;">
        <div class="mc-dropzone__label">Frase</div>
        <div style="font-weight:900; font-size:15px; margin-bottom:10px;">${normStr(payload.text)}</div>
        <input class="mc-input" id="mcFillInput" placeholder="Escribe aquí...">
        <div class="mc-panel__hint" style="margin-top:8px;">Tip: respeta tildes si aplica. (Puedes activar ignoreCase en JSON).</div>
      </div>
    `;

            return {
                getAnswer() {
                    return {value: $("#mcFillInput").val()};
                },
                // ✅ restore
                setAnswer(saved) {
                    if (!saved) return;
                    $("#mcFillInput").val(normStr(saved.value ?? ""));
                },
                check() {
                    let user = normStr($("#mcFillInput").val());
                    let ans = normStr(payload.answer);

                    if (payload.trim) {
                        user = user.trim();
                        ans = ans.trim();
                    }
                    if (payload.ignoreCase) {
                        user = user.toLowerCase();
                        ans = ans.toLowerCase();
                    }

                    const ok = user === ans;
                    return {ok, msg: ok ? "Bien hecho." : "Revisa tu respuesta."};
                }
            };
        }

        // ORDER_WORDS (Sortable)
        function renderOrderWords(container, payload) {
            const items = payload.items || [];
            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Ordenar palabras</div>
      <ul class="mc-tokenList" id="mcOrderList"></ul>
    `;
            const $list = $("#mcOrderList").empty();

            items.forEach(w => {
                $list.append(`<li class="mc-tokenList__item" data-value="${normStr(w)}">${normStr(w)}</li>`);
            });

            Sortable.create(document.getElementById("mcOrderList"), {animation: 150});

            return {
                getAnswer() {
                    return {order: $("#mcOrderList .mc-tokenList__item").map((_, el) => $(el).data("value")).get()};
                },
                // ✅ restore
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
                    return {ok, msg: ok ? "Orden correcto." : "Orden incorrecto. Arrastra y reordena."};
                }
            };
        }

        // DRAG_MATCH (Sortable with zones)
        function renderDragMatch(container, payload) {
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
          <ul class="mc-tokenList mc-tokenList--zone" data-expected="${normStr(p.left)}" style="min-height:44px;"></ul>
        </div>
      `);
            });

            // Source: clones
            Sortable.create(document.getElementById("mcDmLeft"), {
                group: {name: "dm", pull: "clone", put: false},
                sort: false,
                animation: 150
            });

            // Zones: accept, 1 max
            $(".mc-tokenList--zone").each(function () {
                Sortable.create(this, {
                    group: {name: "dm", pull: true, put: true},
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
                        answers.push({expected, got});
                    });
                    return {answers};
                },
                // ✅ restore
                setAnswer(saved) {
                    const answers = saved?.answers || [];
                    if (!Array.isArray(answers) || !answers.length) return;

                    // limpiar zonas
                    $(".mc-tokenList--zone").each(function () {
                        $(this).empty();
                    });

                    // recrear UI en cada zona
                    answers.forEach(row => {
                        const expected = normStr(row.expected);
                        const got = row.got == null ? "" : normStr(row.got);
                        if (!got) return;

                        const $zone = $(`.mc-tokenList--zone[data-expected="${expected}"]`);
                        if (!$zone.length) return;

                        const $token = $(`<li class="mc-tokenList__item" data-value="${got}">${got}</li>`);
                        $zone.append($token);
                    });
                },
                check() {
                    const a = this.getAnswer();
                    const ok = a.answers.every(x => x.got === x.expected);
                    return {
                        ok,
                        msg: ok ? "Emparejaste todo correctamente." : "Hay emparejamientos incorrectos o vacíos."
                    };
                }
            };
        }

        // MULTI_SELECT
        function renderMultiSelect(container, payload) {
            const options = payload.options || [];
            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Seleccionar (multi)</div>
      <div class="mc-options" id="mcMsBox"></div>
    `;

            const $box = $("#mcMsBox").empty();
            options.forEach(o => {
                $box.append(`
        <label class="mc-option">
          <input type="checkbox" value="${normStr(o.id)}">
          <span class="mc-option__text">${normStr(o.text)}</span>
        </label>
      `);
            });

            return {
                getAnswer() {
                    const picked = $("#mcMsBox input:checked").map((_, el) => $(el).val()).get();
                    return {picked};
                },
                // ✅ restore
                setAnswer(saved) {
                    const picked = new Set((saved?.picked || []).map(normStr));
                    $("#mcMsBox input[type='checkbox']").each(function () {
                        $(this).prop("checked", picked.has(normStr($(this).val())));
                    });
                },
                check() {
                    const picked = this.getAnswer().picked;
                    const correct = payload.correctIds || [];
                    const ok = deepEqualSorted(picked, correct);
                    return {ok, msg: ok ? "Selección correcta." : "Selección incorrecta. Revisa cuántas deben ser."};
                }
            };
        }

        // HAYSTACK_PICK
        function renderHaystackPick(container, payload) {
            const haystack = payload.haystack || [];
            const correct = payload.correct || [];
            let picked = new Set(); // ✅ let para rehidratar

            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Escoger del haystack</div>
      <div class="mc-dropzone" style="border-style:solid; margin-bottom:10px;">
        <div class="mc-dropzone__label">Pregunta</div>
        <div style="font-weight:900; font-size:15px;">
          ${normStr(payload.question?.es)} → <span style="color:var(--mc-blue)">${normStr(payload.question?.ki || "?")}</span>
        </div>
      </div>
      <div class="mc-hay" id="mcHayBox"></div>
    `;

            const $hay = $("#mcHayBox").empty();
            haystack.forEach(item => {
                const $btn = $(`<button type="button" class="mc-hay__btn" data-value="${normStr(item)}">${normStr(item)}</button>`);
                $btn.on("click", function () {
                    const val = $(this).data("value");
                    if (picked.has(val)) {
                        picked.delete(val);
                        $(this).removeClass("is-picked");
                    } else {
                        picked.add(val);
                        $(this).addClass("is-picked");
                    }
                });
                $hay.append($btn);
            });

            return {
                getAnswer() {
                    return {picked: Array.from(picked)};
                },
                // ✅ restore
                setAnswer(saved) {
                    picked = new Set((saved?.picked || []).map(normStr));
                    $("#mcHayBox .mc-hay__btn").each(function () {
                        const val = normStr($(this).data("value"));
                        $(this).toggleClass("is-picked", picked.has(val));
                    });
                },
                check() {
                    const user = this.getAnswer().picked;
                    const ok = deepEqualSorted(user, correct);
                    return {ok, msg: ok ? "Correcto." : ("Incorrecto. Correcta(s): " + correct.join(", "))};
                }
            };
        }

        // ---------------------------
        // NEW 1: MULTI_SELECT_IMAGE
        // ---------------------------
        // payload:
        // {
        //   image: "/img/...",
        //   options: [{id,text}], correctIds:[...],
        //   alt, showImageFirst:true
        // }
        function renderMultiSelectImage(container, payload) {
            const options = payload.options || [];
            const img = normStr(payload.image || payload.image_url || "");
            const alt = normStr(payload.alt || "image");
            const showImageFirst = payload.showImageFirst !== false;

            container.innerHTML = `
      <div class="mc-chip mc-chip--info" style="margin-bottom:10px;">Seleccionar con imagen (multi)</div>
      <div class="mc-msi">
        ${img && showImageFirst ? `
          <div class="mc-msi__imgBox">
            <img class="mc-msi__img" src="${img}" alt="${alt}">
          </div>
        ` : ``}
        <div class="mc-options" id="mcMsiBox"></div>
        ${img && !showImageFirst ? `
          <div class="mc-msi__imgBox">
            <img class="mc-msi__img" src="${img}" alt="${alt}">
          </div>
        ` : ``}
      </div>
    `;

            const $box = $("#mcMsiBox").empty();
            options.forEach(o => {
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
                    return {picked};
                },
                // ✅ restore
                setAnswer(saved) {
                    const picked = new Set((saved?.picked || []).map(normStr));
                    $("#mcMsiBox input[type='checkbox']").each(function () {
                        $(this).prop("checked", picked.has(normStr($(this).val())));
                    });
                },
                check() {
                    const picked = this.getAnswer().picked;
                    const correct = payload.correctIds || [];
                    const ok = deepEqualSorted(picked, correct);
                    return {ok, msg: ok ? "Selección correcta (imagen)." : "Selección incorrecta (imagen)."};
                }
            };
        }

        // ---------------------------
        // NEW 2: IMAGE_HOTSPOT_PICK
        // ---------------------------
        // payload:
        // {
        //   image: "/img/body.png",
        //   mode: "MULTI"|"SINGLE",
        //   maxPick: 3,
        //   showLabels: true/false,
        //   hotspots: [{id,xPct,yPct,label,isCorrect}]
        // }
        function renderImageHotspotPick(container, payload) {
            const image = normStr(payload.image || payload.image_url || "");
            const hotspots = Array.isArray(payload.hotspots) ? payload.hotspots : [];
            const mode = normStr(payload.mode || "MULTI"); // MULTI | SINGLE
            const maxPick = Number.isFinite(payload.maxPick) ? payload.maxPick : null;
            const showLabels = payload.showLabels !== false;

            let picked = new Set(); // ✅ let para rehidratar

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
                const id = normStr(h.id);
                const x = Number(h.xPct);
                const y = Number(h.yPct);
                const label = normStr(h.label);

                const spotHtml = `
        <div class="mc-hot__spot" data-id="${id}" style="left:${x}%; top:${y}%;">
          <div class="mc-hot__check">✓</div>
          ${showLabels ? `<div class="mc-hot__label">${label}</div>` : ``}
        </div>
      `;
                $frame.append(spotHtml);
            });

            // Delegación (1 listener)
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

                // MULTI
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
                getAnswer() {
                    return {picked: Array.from(picked)};
                },
                // ✅ restore
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

                    // feedback visual
                    $(".mc-hot__spot").removeClass("is-wrong");
                    user.forEach(id => {
                        if (!correctIds.includes(id)) {
                            $(`.mc-hot__spot[data-id="${id}"]`).addClass("is-wrong");
                        }
                    });

                    return {
                        ok,
                        msg: ok ? "Correcto: marcaste los puntos exactos." : "Incorrecto: revisa los puntos marcados."
                    };
                }
            };
        }

        // ---------------------------
        // SAMPLE JSON inline (sin id sampler-json)
        // - Incluye los 2 tipos nuevos para probar rápido
        // ---------------------------


        const BLOCK_1 = [
            {
                "step_id": "PRE_DRAG_MATCH_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • DRAG_MATCH • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja Kichwa con Español (Presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_DRAG_MATCH_01_EX",
                    "type": "DRAG_MATCH",
                    "title": "Presentación (Emparejar) 01",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Ñuka", "right": "Yo"},
                            {"left": "shuti", "right": "nombre"},
                            {"left": "kan", "right": "soy/eres"},
                            {"left": "Killa", "right": "Killa (nombre)"}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_DRAG_MATCH_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • DRAG_MATCH • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja Kichwa con Español (Presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_DRAG_MATCH_02_EX",
                    "type": "DRAG_MATCH",
                    "title": "Presentación (Emparejar) 02",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Imanalla", "right": "¿Cómo estás?"},
                            {"left": "Allillachu", "right": "Estoy bien"},
                            {"left": "Yupay", "right": "Gracias"},
                            {"left": "Ñuka", "right": "Yo"}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_DRAG_MATCH_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • DRAG_MATCH • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja Kichwa con Español (Presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_DRAG_MATCH_03_EX",
                    "type": "DRAG_MATCH",
                    "title": "Presentación (Emparejar) 03",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Alli puncha", "right": "Buenos días"},
                            {"left": "Alli tuta", "right": "Buenas noches"},
                            {"left": "Napaykuna", "right": "Saludos"},
                            {"left": "Yupay", "right": "Gracias"}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_DRAG_MATCH_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • DRAG_MATCH • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja Kichwa con Español (Presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_DRAG_MATCH_04_EX",
                    "type": "DRAG_MATCH",
                    "title": "Presentación (Emparejar) 04",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Wasi", "right": "Casa"},
                            {"left": "Maki", "right": "Mano"},
                            {"left": "Ñawi", "right": "Ojo"},
                            {"left": "Simi", "right": "Boca"}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_DRAG_MATCH_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • DRAG_MATCH • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja Kichwa con Español (Presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_DRAG_MATCH_05_EX",
                    "type": "DRAG_MATCH",
                    "title": "Presentación (Emparejar) 05",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Inti", "right": "Sol"},
                            {"left": "Killa", "right": "Luna"},
                            {"left": "Yaku", "right": "Agua"},
                            {"left": "Rumi", "right": "Piedra"}
                        ]
                    }
                }
            },

            {
                "step_id": "PRE_FILL_BLANK_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • FILL_BLANK • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Completa la frase de presentación.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_FILL_BLANK_01_EX",
                    "type": "FILL_BLANK",
                    "title": "Presentación (Completar) 01",
                    "prompt": "Completa la frase:",
                    "payload": {
                        "text": "Ñuka ____ Killa kan.",
                        "answer": "shuti",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "PRE_FILL_BLANK_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • FILL_BLANK • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Completa la frase de presentación.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_FILL_BLANK_02_EX",
                    "type": "FILL_BLANK",
                    "title": "Presentación (Completar) 02",
                    "prompt": "Completa la frase:",
                    "payload": {
                        "text": "Ñuka ____ kan.",
                        "answer": "Killa",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "PRE_FILL_BLANK_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • FILL_BLANK • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Completa la frase de presentación.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_FILL_BLANK_03_EX",
                    "type": "FILL_BLANK",
                    "title": "Presentación (Completar) 03",
                    "prompt": "Completa la frase:",
                    "payload": {
                        "text": "____ shuti Killa kan.",
                        "answer": "Ñuka",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "PRE_FILL_BLANK_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • FILL_BLANK • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Completa la frase de presentación.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_FILL_BLANK_04_EX",
                    "type": "FILL_BLANK",
                    "title": "Presentación (Completar) 04",
                    "prompt": "Completa la frase:",
                    "payload": {
                        "text": "Ñuka shuti ____ kan.",
                        "answer": "Killa",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "PRE_FILL_BLANK_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • FILL_BLANK • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Completa la frase de presentación.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_FILL_BLANK_05_EX",
                    "type": "FILL_BLANK",
                    "title": "Presentación (Completar) 05",
                    "prompt": "Completa la frase:",
                    "payload": {
                        "text": "Ñuka shuti Killa ____.",
                        "answer": "kan",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },

            {
                "step_id": "PRE_HAYSTACK_PICK_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • HAYSTACK_PICK • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge la palabra correcta del haystack.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_HAYSTACK_PICK_01_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Presentación (Haystack) 01",
                    "prompt": "Selecciona la palabra correcta:",
                    "payload": {
                        "question": {"es": "¿Dónde?", "ki": "Maypi?"},
                        "haystack": ["Maypi?", "Ñuka", "shuti", "kan", "Killa", "Alli puncha", "Yupay", "Wasi", "Maki", "Yaku"],
                        "correct": ["Maypi?"]
                    }
                }
            },
            {
                "step_id": "PRE_HAYSTACK_PICK_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • HAYSTACK_PICK • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge la palabra correcta del haystack.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_HAYSTACK_PICK_02_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Presentación (Haystack) 02",
                    "prompt": "Selecciona la palabra correcta:",
                    "payload": {
                        "question": {"es": "Gracias", "ki": "Yupay"},
                        "haystack": ["Yupay", "Maypi?", "Ñuka", "shuti", "kan", "Alli puncha", "Wasi", "Maki", "Yaku", "Rumi"],
                        "correct": ["Yupay"]
                    }
                }
            },
            {
                "step_id": "PRE_HAYSTACK_PICK_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • HAYSTACK_PICK • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge la palabra correcta del haystack.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_HAYSTACK_PICK_03_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Presentación (Haystack) 03",
                    "prompt": "Selecciona la palabra correcta:",
                    "payload": {
                        "question": {"es": "Yo", "ki": "Ñuka"},
                        "haystack": ["Ñuka", "Yupay", "Maypi?", "shuti", "kan", "Killa", "Alli tuta", "Wasi", "Maki", "Inti"],
                        "correct": ["Ñuka"]
                    }
                }
            },
            {
                "step_id": "PRE_HAYSTACK_PICK_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • HAYSTACK_PICK • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge la palabra correcta del haystack.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_HAYSTACK_PICK_04_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Presentación (Haystack) 04",
                    "prompt": "Selecciona la palabra correcta:",
                    "payload": {
                        "question": {"es": "Nombre", "ki": "shuti"},
                        "haystack": ["shuti", "Ñuka", "kan", "Killa", "Yupay", "Maypi?", "Wasi", "Maki", "Yaku", "Rumi"],
                        "correct": ["shuti"]
                    }
                }
            },
            {
                "step_id": "PRE_HAYSTACK_PICK_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • HAYSTACK_PICK • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge la palabra correcta del haystack.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_HAYSTACK_PICK_05_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Presentación (Haystack) 05",
                    "prompt": "Selecciona la palabra correcta:",
                    "payload": {
                        "question": {"es": "Casa", "ki": "Wasi"},
                        "haystack": ["Wasi", "Maki", "Ñawi", "Simi", "Yaku", "Rumi", "Inti", "Killa", "Ñuka", "Yupay"],
                        "correct": ["Wasi"]
                    }
                }
            },

            {
                "step_id": "PRE_IMAGE_HOTSPOT_PICK_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • IMAGE_HOTSPOT_PICK • 01",
                "activity": "RIKSINA - Mirar",
                "description": "Marca puntos correctos en imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_IMAGE_HOTSPOT_PICK_01_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Presentación (Hotspots) 01",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_IMAGE_HOTSPOT_PICK_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • IMAGE_HOTSPOT_PICK • 02",
                "activity": "RIKSINA - Mirar",
                "description": "Marca puntos correctos en imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_IMAGE_HOTSPOT_PICK_02_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Presentación (Hotspots) 02",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "SINGLE",
                        "maxPick": 1,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_IMAGE_HOTSPOT_PICK_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • IMAGE_HOTSPOT_PICK • 03",
                "activity": "RIKSINA - Mirar",
                "description": "Marca puntos correctos en imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_IMAGE_HOTSPOT_PICK_03_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Presentación (Hotspots) 03",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 2,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_IMAGE_HOTSPOT_PICK_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • IMAGE_HOTSPOT_PICK • 04",
                "activity": "RIKSINA - Mirar",
                "description": "Marca puntos correctos en imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_IMAGE_HOTSPOT_PICK_04_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Presentación (Hotspots) 04",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": false,
                        "hotspots": [
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "PRE_IMAGE_HOTSPOT_PICK_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • IMAGE_HOTSPOT_PICK • 05",
                "activity": "RIKSINA - Mirar",
                "description": "Marca puntos correctos en imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_IMAGE_HOTSPOT_PICK_05_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Presentación (Hotspots) 05",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },

            {
                "step_id": "PRE_MULTI_SELECT_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona las opciones correctas.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_01_EX",
                    "type": "MULTI_SELECT",
                    "title": "Presentación (Multi) 01",
                    "prompt": "Selecciona (2 correctas):",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Ñuka"},
                            {"id": "b", "text": "shuti"},
                            {"id": "c", "text": "Wasi"},
                            {"id": "d", "text": "Rumi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona las opciones correctas.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_02_EX",
                    "type": "MULTI_SELECT",
                    "title": "Presentación (Multi) 02",
                    "prompt": "Selecciona SOLO 1 correcta:",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Yupay"},
                            {"id": "b", "text": "Maypi?"},
                            {"id": "c", "text": "Alli puncha"},
                            {"id": "d", "text": "Sacha"}
                        ],
                        "correctIds": ["a"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona las opciones correctas.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_03_EX",
                    "type": "MULTI_SELECT",
                    "title": "Presentación (Multi) 03",
                    "prompt": "Selecciona (2 correctas):",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Killa"},
                            {"id": "b", "text": "Inti"},
                            {"id": "c", "text": "Yaku"},
                            {"id": "d", "text": "Maki"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona las opciones correctas.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_04_EX",
                    "type": "MULTI_SELECT",
                    "title": "Presentación (Multi) 04",
                    "prompt": "Selecciona (2 correctas):",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Wasi"},
                            {"id": "b", "text": "Maki"},
                            {"id": "c", "text": "Rumi"},
                            {"id": "d", "text": "Simi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona las opciones correctas.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_05_EX",
                    "type": "MULTI_SELECT",
                    "title": "Presentación (Multi) 05",
                    "prompt": "Selecciona SOLO 1 correcta:",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "shuti"},
                            {"id": "b", "text": "maki"},
                            {"id": "c", "text": "rumi"},
                            {"id": "d", "text": "yaku"}
                        ],
                        "correctIds": ["a"]
                    }
                }
            },

            {
                "step_id": "PRE_MULTI_SELECT_IMAGE_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT_IMAGE • 01",
                "activity": "RIKSINA - Mirar",
                "description": "Selecciona mirando la imagen.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_IMAGE_01_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Presentación (Imagen Multi) 01",
                    "prompt": "Selecciona las frutas (2 correctas):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "palta"},
                            {"id": "c", "text": "wasi"},
                            {"id": "d", "text": "maki"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_IMAGE_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT_IMAGE • 02",
                "activity": "RIKSINA - Mirar",
                "description": "Selecciona mirando la imagen.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_IMAGE_02_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Presentación (Imagen Multi) 02",
                    "prompt": "Selecciona la fruta correcta (1 correcta):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "wasi"},
                            {"id": "c", "text": "rumi"},
                            {"id": "d", "text": "yaku"}
                        ],
                        "correctIds": ["a"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_IMAGE_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT_IMAGE • 03",
                "activity": "RIKSINA - Mirar",
                "description": "Selecciona mirando la imagen.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_IMAGE_03_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Presentación (Imagen Multi) 03",
                    "prompt": "Selecciona las frutas (2 correctas):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": false,
                        "options": [
                            {"id": "a", "text": "palta"},
                            {"id": "b", "text": "apil"},
                            {"id": "c", "text": "sacha"},
                            {"id": "d", "text": "wasi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_IMAGE_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT_IMAGE • 04",
                "activity": "RIKSINA - Mirar",
                "description": "Selecciona mirando la imagen.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_IMAGE_04_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Presentación (Imagen Multi) 04",
                    "prompt": "Selecciona 1 correcta:",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "wasi"},
                            {"id": "b", "text": "maki"},
                            {"id": "c", "text": "palta"},
                            {"id": "d", "text": "rumi"}
                        ],
                        "correctIds": ["c"]
                    }
                }
            },
            {
                "step_id": "PRE_MULTI_SELECT_IMAGE_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • MULTI_SELECT_IMAGE • 05",
                "activity": "RIKSINA - Mirar",
                "description": "Selecciona mirando la imagen.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_MULTI_SELECT_IMAGE_05_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Presentación (Imagen Multi) 05",
                    "prompt": "Selecciona las frutas (2 correctas):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "palta"},
                            {"id": "c", "text": "yaku"},
                            {"id": "d", "text": "simi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },

            {
                "step_id": "PRE_ORDER_WORDS_01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • ORDER_WORDS • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena palabras (presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_ORDER_WORDS_01_EX",
                    "type": "ORDER_WORDS",
                    "title": "Presentación (Ordenar) 01",
                    "prompt": "Ordena la frase en Kichwa:",
                    "payload": {
                        "correctOrder": ["Ñuka", "shuti", "Killa", "kan."],
                        "items": ["kan.", "Killa", "Ñuka", "shuti"]
                    }
                }
            },
            {
                "step_id": "PRE_ORDER_WORDS_02",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • ORDER_WORDS • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena palabras (presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_ORDER_WORDS_02_EX",
                    "type": "ORDER_WORDS",
                    "title": "Presentación (Ordenar) 02",
                    "prompt": "Ordena la frase en Kichwa:",
                    "payload": {
                        "correctOrder": ["Ñuka", "shuti", "Killa", "kan."],
                        "items": ["shuti", "Ñuka", "kan.", "Killa"]
                    }
                }
            },
            {
                "step_id": "PRE_ORDER_WORDS_03",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • ORDER_WORDS • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena palabras (presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_ORDER_WORDS_03_EX",
                    "type": "ORDER_WORDS",
                    "title": "Presentación (Ordenar) 03",
                    "prompt": "Ordena la frase en Kichwa:",
                    "payload": {
                        "correctOrder": ["Alli", "puncha"],
                        "items": ["puncha", "Alli"]
                    }
                }
            },
            {
                "step_id": "PRE_ORDER_WORDS_04",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • ORDER_WORDS • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena palabras (presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_ORDER_WORDS_04_EX",
                    "type": "ORDER_WORDS",
                    "title": "Presentación (Ordenar) 04",
                    "prompt": "Ordena la frase en Kichwa:",
                    "payload": {
                        "correctOrder": ["Yupay", "Killa"],
                        "items": ["Killa", "Yupay"]
                    }
                }
            },
            {
                "step_id": "PRE_ORDER_WORDS_05",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "RIKISIRISHUN-PRESENTACION • ORDER_WORDS • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena palabras (presentación).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "PRE_ORDER_WORDS_05_EX",
                    "type": "ORDER_WORDS",
                    "title": "Presentación (Ordenar) 05",
                    "prompt": "Ordena la frase en Kichwa:",
                    "payload": {
                        "correctOrder": ["Imanalla", "?"],
                        "items": ["?", "Imanalla"]
                    }
                }
            },
        ];
        const BLOCK_2_NAPAYKUN_SALUDOS = [
            // =========================================================
            // BLOQUE 2: NAPAYKUN - SALUDOS (35)
            // =========================================================

            // -------------------------
            // DRAG_MATCH (5)
            // -------------------------
            {
                step_id: "B2_SAL_DRAG_MATCH_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • DRAG_MATCH • 01",
                activity: "RIMAY - Hablar",
                description: "Empareja saludos Kichwa con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_DRAG_MATCH_01_EX",
                    type: "DRAG_MATCH",
                    title: "Saludos (Emparejar) 01",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Alli puncha", right: "Buenos días"},
                            {left: "Alli chishi", right: "Buenas tardes"},
                            {left: "Alli tuta", right: "Buenas noches"},
                            {left: "Napaykuna", right: "Saludos"}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_DRAG_MATCH_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • DRAG_MATCH • 02",
                activity: "RIMAY - Hablar",
                description: "Empareja expresiones comunes.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_DRAG_MATCH_02_EX",
                    type: "DRAG_MATCH",
                    title: "Saludos (Emparejar) 02",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Imanalla", right: "¿Cómo estás?"},
                            {left: "Allillachu", right: "Estoy bien"},
                            {left: "Yupay", right: "Gracias"},
                            {left: "Arí", right: "Sí"}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_DRAG_MATCH_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • DRAG_MATCH • 03",
                activity: "RIMAY - Hablar",
                description: "Empareja respuestas rápidas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_DRAG_MATCH_03_EX",
                    type: "DRAG_MATCH",
                    title: "Saludos (Emparejar) 03",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Mana", right: "No"},
                            {left: "Yupay", right: "Gracias"},
                            {left: "Allillachu", right: "Estoy bien"},
                            {left: "Imanalla", right: "¿Cómo estás?"}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_DRAG_MATCH_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • DRAG_MATCH • 04",
                activity: "RIMAY - Hablar",
                description: "Empareja saludos y cortesías.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_DRAG_MATCH_04_EX",
                    type: "DRAG_MATCH",
                    title: "Saludos (Emparejar) 04",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Napaykuna", right: "Saludos"},
                            {left: "Yupay", right: "Gracias"},
                            {left: "Alli puncha", right: "Buenos días"},
                            {left: "Alli tuta", right: "Buenas noches"}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_DRAG_MATCH_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • DRAG_MATCH • 05",
                activity: "RIMAY - Hablar",
                description: "Empareja saludos por momento del día.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_DRAG_MATCH_05_EX",
                    type: "DRAG_MATCH",
                    title: "Saludos (Emparejar) 05",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Alli puncha", right: "Buenos días"},
                            {left: "Alli chishi", right: "Buenas tardes"},
                            {left: "Alli tuta", right: "Buenas noches"},
                            {left: "Imanalla", right: "¿Cómo estás?"}
                        ]
                    }
                }
            },

            // -------------------------
            // FILL_BLANK (5)
            // -------------------------
            {
                step_id: "B2_SAL_FILL_BLANK_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • FILL_BLANK • 01",
                activity: "KILLKAY - Escribir",
                description: "Completa el saludo.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_FILL_BLANK_01_EX",
                    type: "FILL_BLANK",
                    title: "Saludos (Completar) 01",
                    prompt: "Completa:",
                    payload: {text: "Alli ____", answer: "puncha", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B2_SAL_FILL_BLANK_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • FILL_BLANK • 02",
                activity: "KILLKAY - Escribir",
                description: "Completa el saludo.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_FILL_BLANK_02_EX",
                    type: "FILL_BLANK",
                    title: "Saludos (Completar) 02",
                    prompt: "Completa:",
                    payload: {text: "Alli ____", answer: "chishi", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B2_SAL_FILL_BLANK_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • FILL_BLANK • 03",
                activity: "KILLKAY - Escribir",
                description: "Completa el saludo.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_FILL_BLANK_03_EX",
                    type: "FILL_BLANK",
                    title: "Saludos (Completar) 03",
                    prompt: "Completa:",
                    payload: {text: "Alli ____", answer: "tuta", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B2_SAL_FILL_BLANK_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • FILL_BLANK • 04",
                activity: "KILLKAY - Escribir",
                description: "Completa la cortesía.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_FILL_BLANK_04_EX",
                    type: "FILL_BLANK",
                    title: "Saludos (Completar) 04",
                    prompt: "Completa:",
                    payload: {text: "____", answer: "Yupay", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B2_SAL_FILL_BLANK_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • FILL_BLANK • 05",
                activity: "KILLKAY - Escribir",
                description: "Completa la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_FILL_BLANK_05_EX",
                    type: "FILL_BLANK",
                    title: "Saludos (Completar) 05",
                    prompt: "Completa:",
                    payload: {text: "____?", answer: "Imanalla", trim: true, ignoreCase: true}
                }
            },

            // -------------------------
            // HAYSTACK_PICK (5)
            // -------------------------
            {
                step_id: "B2_SAL_HAYSTACK_PICK_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 01",
                activity: "RIMAY - Hablar",
                description: "Selecciona el saludo correcto.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_HAYSTACK_PICK_01_EX",
                    type: "HAYSTACK_PICK",
                    title: "Saludos (Haystack) 01",
                    prompt: "Selecciona la respuesta correcta:",
                    payload: {
                        question: {es: "Buenos días", ki: "Alli puncha"},
                        haystack: ["Alli puncha", "Alli tuta", "Yupay", "Maypi?", "Ñuka", "shuti", "kan", "Wasi", "Maki", "Yaku"],
                        correct: ["Alli puncha"]
                    }
                }
            },
            {
                step_id: "B2_SAL_HAYSTACK_PICK_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 02",
                activity: "RIMAY - Hablar",
                description: "Selecciona la cortesía correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_HAYSTACK_PICK_02_EX",
                    type: "HAYSTACK_PICK",
                    title: "Saludos (Haystack) 02",
                    prompt: "Selecciona la respuesta correcta:",
                    payload: {
                        question: {es: "Gracias", ki: "Yupay"},
                        haystack: ["Yupay", "Alli puncha", "Alli tuta", "Maypi?", "Ñuka", "shuti", "kan", "Wasi", "Maki", "Rumi"],
                        correct: ["Yupay"]
                    }
                }
            },
            {
                step_id: "B2_SAL_HAYSTACK_PICK_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 03",
                activity: "RIMAY - Hablar",
                description: "Selecciona el saludo correcto.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_HAYSTACK_PICK_03_EX",
                    type: "HAYSTACK_PICK",
                    title: "Saludos (Haystack) 03",
                    prompt: "Selecciona la respuesta correcta:",
                    payload: {
                        question: {es: "Buenas noches", ki: "Alli tuta"},
                        haystack: ["Alli tuta", "Alli puncha", "Yupay", "Maypi?", "Wasi", "Maki", "Killa", "Inti", "Yaku", "Rumi"],
                        correct: ["Alli tuta"]
                    }
                }
            },
            {
                step_id: "B2_SAL_HAYSTACK_PICK_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 04",
                activity: "RIMAY - Hablar",
                description: "Selecciona el concepto correcto.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_HAYSTACK_PICK_04_EX",
                    type: "HAYSTACK_PICK",
                    title: "Saludos (Haystack) 04",
                    prompt: "Selecciona la respuesta correcta:",
                    payload: {
                        question: {es: "Saludos", ki: "Napaykuna"},
                        haystack: ["Napaykuna", "Alli tuta", "Alli puncha", "Yupay", "Maypi?", "Ñuka", "shuti", "kan", "Wasi", "Maki"],
                        correct: ["Napaykuna"]
                    }
                }
            },
            {
                step_id: "B2_SAL_HAYSTACK_PICK_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 05",
                activity: "RIMAY - Hablar",
                description: "Selecciona la pregunta correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_HAYSTACK_PICK_05_EX",
                    type: "HAYSTACK_PICK",
                    title: "Saludos (Haystack) 05",
                    prompt: "Selecciona la respuesta correcta:",
                    payload: {
                        question: {es: "¿Cómo estás?", ki: "Imanalla"},
                        haystack: ["Imanalla", "Allillachu", "Yupay", "Alli puncha", "Alli tuta", "Maypi?", "Ñuka", "shuti", "Wasi", "Maki"],
                        correct: ["Imanalla"]
                    }
                }
            },

            // -------------------------
            // IMAGE_HOTSPOT_PICK (5)
            // -------------------------
            {
                step_id: "B2_SAL_IMAGE_HOTSPOT_PICK_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 01",
                activity: "RIKSINA - Mirar",
                description: "Hotspots demo (rostro).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_IMAGE_HOTSPOT_PICK_01_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Saludos (Hotspots) 01",
                    prompt: "Marca SOLO las partes correctas (Kichwa):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 3,
                        showLabels: true,
                        hotspots: [
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: true},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: true},
                            {id: "yaku", xPct: 20, yPct: 20, label: "yaku", isCorrect: false},
                            {id: "rumi", xPct: 80, yPct: 85, label: "rumi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_IMAGE_HOTSPOT_PICK_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 02",
                activity: "RIKSINA - Mirar",
                description: "Hotspots demo (single).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_IMAGE_HOTSPOT_PICK_02_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Saludos (Hotspots) 02",
                    prompt: "Marca SOLO la parte correcta:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: true},
                            {id: "rumi", xPct: 80, yPct: 85, label: "rumi", isCorrect: false},
                            {id: "yaku", xPct: 20, yPct: 20, label: "yaku", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_IMAGE_HOTSPOT_PICK_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 03",
                activity: "RIKSINA - Mirar",
                description: "Hotspots demo (2 picks).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_IMAGE_HOTSPOT_PICK_03_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Saludos (Hotspots) 03",
                    prompt: "Marca SOLO 2 partes correctas:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 2,
                        showLabels: true,
                        hotspots: [
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: true},
                            {id: "rumi", xPct: 80, yPct: 85, label: "rumi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_IMAGE_HOTSPOT_PICK_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 04",
                activity: "RIKSINA - Mirar",
                description: "Hotspots demo (labels off).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_IMAGE_HOTSPOT_PICK_04_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Saludos (Hotspots) 04",
                    prompt: "Marca SOLO 3 partes correctas (sin labels):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 3,
                        showLabels: false,
                        hotspots: [
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: true},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: true},
                            {id: "yaku", xPct: 20, yPct: 20, label: "yaku", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B2_SAL_IMAGE_HOTSPOT_PICK_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 05",
                activity: "RIKSINA - Mirar",
                description: "Hotspots demo (3 picks).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_IMAGE_HOTSPOT_PICK_05_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Saludos (Hotspots) 05",
                    prompt: "Marca SOLO 3 partes correctas:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 3,
                        showLabels: true,
                        hotspots: [
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: true},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: true},
                            {id: "rumi", xPct: 80, yPct: 85, label: "rumi", isCorrect: false}
                        ]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT (5)
            // -------------------------
            {
                step_id: "B2_SAL_MULTI_SELECT_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT • 01",
                activity: "RIMAY - Hablar",
                description: "Selecciona los saludos.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_01_EX",
                    type: "MULTI_SELECT",
                    title: "Saludos (Multi) 01",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Alli puncha"},
                            {id: "b", text: "Alli tuta"},
                            {id: "c", text: "Wasi"},
                            {id: "d", text: "Rumi"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT • 02",
                activity: "RIMAY - Hablar",
                description: "Selecciona la cortesía correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_02_EX",
                    type: "MULTI_SELECT",
                    title: "Saludos (Multi) 02",
                    prompt: "Selecciona SOLO 1 correcta:",
                    payload: {
                        options: [
                            {id: "a", text: "Yupay"},
                            {id: "b", text: "Maypi?"},
                            {id: "c", text: "Sacha"},
                            {id: "d", text: "Rumi"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT • 03",
                activity: "RIMAY - Hablar",
                description: "Selecciona saludos/frases correctas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_03_EX",
                    type: "MULTI_SELECT",
                    title: "Saludos (Multi) 03",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Alli chishi"},
                            {id: "b", text: "Napaykuna"},
                            {id: "c", text: "Yaku"},
                            {id: "d", text: "Maki"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT • 04",
                activity: "RIMAY - Hablar",
                description: "Selecciona la respuesta correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_04_EX",
                    type: "MULTI_SELECT",
                    title: "Saludos (Multi) 04",
                    prompt: "Selecciona SOLO 1 correcta:",
                    payload: {
                        options: [
                            {id: "a", text: "Allillachu"},
                            {id: "b", text: "Rumi"},
                            {id: "c", text: "Wasi"},
                            {id: "d", text: "Yaku"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT • 05",
                activity: "RIMAY - Hablar",
                description: "Selecciona pregunta y cortesía.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_05_EX",
                    type: "MULTI_SELECT",
                    title: "Saludos (Multi) 05",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Imanalla"},
                            {id: "b", text: "Yupay"},
                            {id: "c", text: "Rumi"},
                            {id: "d", text: "Sacha"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT_IMAGE (5)
            // -------------------------
            {
                step_id: "B2_SAL_MULTI_SELECT_IMAGE_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 01",
                activity: "RIKSINA - Mirar",
                description: "Selección con imagen (demo).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_IMAGE_01_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Saludos (Imagen Multi) 01",
                    prompt: "Selecciona las frutas (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "palta"},
                            {id: "c", text: "wasi"},
                            {id: "d", text: "maki"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_IMAGE_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 02",
                activity: "RIKSINA - Mirar",
                description: "Selección con imagen (demo).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_IMAGE_02_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Saludos (Imagen Multi) 02",
                    prompt: "Selecciona 1 correcta:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "wasi"},
                            {id: "c", text: "rumi"},
                            {id: "d", text: "yaku"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_IMAGE_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 03",
                activity: "RIKSINA - Mirar",
                description: "Selección con imagen (demo).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_IMAGE_03_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Saludos (Imagen Multi) 03",
                    prompt: "Selecciona 2 correctas:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "palta"},
                            {id: "b", text: "apil"},
                            {id: "c", text: "sacha"},
                            {id: "d", text: "wasi"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_IMAGE_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 04",
                activity: "RIKSINA - Mirar",
                description: "Selección con imagen (demo).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_IMAGE_04_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Saludos (Imagen Multi) 04",
                    prompt: "Selecciona 1 correcta:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "wasi"},
                            {id: "b", text: "maki"},
                            {id: "c", text: "palta"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["c"]
                    }
                }
            },
            {
                step_id: "B2_SAL_MULTI_SELECT_IMAGE_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 05",
                activity: "RIKSINA - Mirar",
                description: "Selección con imagen (demo).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_MULTI_SELECT_IMAGE_05_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Saludos (Imagen Multi) 05",
                    prompt: "Selecciona 2 correctas:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "palta"},
                            {id: "c", text: "yaku"},
                            {id: "d", text: "simi"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },

            // -------------------------
            // ORDER_WORDS (5)
            // -------------------------
            {
                step_id: "B2_SAL_ORDER_WORDS_01",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • ORDER_WORDS • 01",
                activity: "KILLKAY - Escribir",
                description: "Ordena el saludo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_ORDER_WORDS_01_EX",
                    type: "ORDER_WORDS",
                    title: "Saludos (Ordenar) 01",
                    prompt: "Ordena:",
                    payload: {correctOrder: ["Alli", "puncha"], items: ["puncha", "Alli"]}
                }
            },
            {
                step_id: "B2_SAL_ORDER_WORDS_02",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • ORDER_WORDS • 02",
                activity: "KILLKAY - Escribir",
                description: "Ordena el saludo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_ORDER_WORDS_02_EX",
                    type: "ORDER_WORDS",
                    title: "Saludos (Ordenar) 02",
                    prompt: "Ordena:",
                    payload: {correctOrder: ["Alli", "chishi"], items: ["chishi", "Alli"]}
                }
            },
            {
                step_id: "B2_SAL_ORDER_WORDS_03",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • ORDER_WORDS • 03",
                activity: "KILLKAY - Escribir",
                description: "Ordena el saludo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_ORDER_WORDS_03_EX",
                    type: "ORDER_WORDS",
                    title: "Saludos (Ordenar) 03",
                    prompt: "Ordena:",
                    payload: {correctOrder: ["Alli", "tuta"], items: ["tuta", "Alli"]}
                }
            },
            {
                step_id: "B2_SAL_ORDER_WORDS_04",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • ORDER_WORDS • 04",
                activity: "KILLKAY - Escribir",
                description: "Ordena la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_ORDER_WORDS_04_EX",
                    type: "ORDER_WORDS",
                    title: "Saludos (Ordenar) 04",
                    prompt: "Ordena:",
                    payload: {correctOrder: ["Imanalla", "?"], items: ["?", "Imanalla"]}
                }
            },
            {
                step_id: "B2_SAL_ORDER_WORDS_05",
                unidad_seccion_id: 2,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "NAPAYKUN-SALUDOS • ORDER_WORDS • 05",
                activity: "KILLKAY - Escribir",
                description: "Ordena la cortesía.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B2_SAL_ORDER_WORDS_05_EX",
                    type: "ORDER_WORDS",
                    title: "Saludos (Ordenar) 05",
                    prompt: "Ordena:",
                    payload: {correctOrder: ["Yupay"], items: ["Yupay"]}
                }
            }
        ];
        const BLOCK_3_TAPUYKUNA_SALUDOS = [
            // =========================================================
            // BLOQUE 3: TAPUYKUNA - SALUDOS (35)
            // Tipos (5 c/u): DRAG_MATCH, FILL_BLANK, HAYSTACK_PICK,
            //                IMAGE_HOTSPOT_PICK, MULTI_SELECT,
            //                MULTI_SELECT_IMAGE, ORDER_WORDS
            // =========================================================

            // -------------------------
            // DRAG_MATCH (5)
            // -------------------------
            {
                step_id: "B3_TAP_DRAG_MATCH_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • DRAG_MATCH • 01",
                activity: "RIMAY - Hablar",
                description: "Empareja preguntas Kichwa con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_DRAG_MATCH_01_EX",
                    type: "DRAG_MATCH",
                    title: "Tapuykuna (Emparejar) 01",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Imanalla?", right: "¿Cómo estás?"},
                            {left: "Maypi?", right: "¿Dónde?"},
                            {left: "Imashina?", right: "¿Cómo?"},
                            {left: "Pita?", right: "¿Quién?"}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_DRAG_MATCH_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • DRAG_MATCH • 02",
                activity: "RIMAY - Hablar",
                description: "Empareja respuestas rápidas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_DRAG_MATCH_02_EX",
                    type: "DRAG_MATCH",
                    title: "Tapuykuna (Emparejar) 02",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Arí", right: "Sí"},
                            {left: "Mana", right: "No"},
                            {left: "Allillachu", right: "Estoy bien"},
                            {left: "Yupay", right: "Gracias"}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_DRAG_MATCH_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • DRAG_MATCH • 03",
                activity: "RIMAY - Hablar",
                description: "Empareja preguntas de identidad.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_DRAG_MATCH_03_EX",
                    type: "DRAG_MATCH",
                    title: "Tapuykuna (Emparejar) 03",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Iman shuti?", right: "¿Cuál es tu nombre?"},
                            {left: "Maymanta kanki?", right: "¿De dónde eres?"},
                            {left: "Pita kanki?", right: "¿Quién eres?"},
                            {left: "Imanalla kanki?", right: "¿Cómo estás tú?"}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_DRAG_MATCH_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • DRAG_MATCH • 04",
                activity: "RIMAY - Hablar",
                description: "Empareja respuestas para presentarse.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_DRAG_MATCH_04_EX",
                    type: "DRAG_MATCH",
                    title: "Tapuykuna (Emparejar) 04",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Ñuka shuti Killa", right: "Mi nombre es Killa"},
                            {left: "Ñuka shuti Inti", right: "Mi nombre es Inti"},
                            {left: "Ñuka shuti Sisa", right: "Mi nombre es Sisa"},
                            {left: "Ñuka shuti Nina", right: "Mi nombre es Nina"}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_DRAG_MATCH_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • DRAG_MATCH • 05",
                activity: "RIMAY - Hablar",
                description: "Empareja preguntas del día a día.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_DRAG_MATCH_05_EX",
                    type: "DRAG_MATCH",
                    title: "Tapuykuna (Emparejar) 05",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "Imatami munanki?", right: "¿Qué quieres?"},
                            {left: "Imata ruwanki?", right: "¿Qué haces?"},
                            {left: "Imata mikunki?", right: "¿Qué comes?"},
                            {left: "Mayman rinki?", right: "¿A dónde vas?"}
                        ]
                    }
                }
            },

            // -------------------------
            // FILL_BLANK (5)
            // -------------------------
            {
                step_id: "B3_TAP_FILL_BLANK_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • FILL_BLANK • 01",
                activity: "KILLKAY - Escribir",
                description: "Completa la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_FILL_BLANK_01_EX",
                    type: "FILL_BLANK",
                    title: "Tapuykuna (Completar) 01",
                    prompt: "Completa:",
                    payload: {text: "____?", answer: "Maypi", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B3_TAP_FILL_BLANK_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • FILL_BLANK • 02",
                activity: "KILLKAY - Escribir",
                description: "Completa la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_FILL_BLANK_02_EX",
                    type: "FILL_BLANK",
                    title: "Tapuykuna (Completar) 02",
                    prompt: "Completa:",
                    payload: {text: "____?", answer: "Pita", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B3_TAP_FILL_BLANK_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • FILL_BLANK • 03",
                activity: "KILLKAY - Escribir",
                description: "Completa la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_FILL_BLANK_03_EX",
                    type: "FILL_BLANK",
                    title: "Tapuykuna (Completar) 03",
                    prompt: "Completa:",
                    payload: {text: "____ shuti?", answer: "Iman", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B3_TAP_FILL_BLANK_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • FILL_BLANK • 04",
                activity: "KILLKAY - Escribir",
                description: "Completa la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_FILL_BLANK_04_EX",
                    type: "FILL_BLANK",
                    title: "Tapuykuna (Completar) 04",
                    prompt: "Completa:",
                    payload: {text: "____ kanki?", answer: "Imanalla", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B3_TAP_FILL_BLANK_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • FILL_BLANK • 05",
                activity: "KILLKAY - Escribir",
                description: "Completa la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_FILL_BLANK_05_EX",
                    type: "FILL_BLANK",
                    title: "Tapuykuna (Completar) 05",
                    prompt: "Completa:",
                    payload: {text: "Maymanta ____?", answer: "kanki", trim: true, ignoreCase: true}
                }
            },

            // -------------------------
            // HAYSTACK_PICK (5)
            // -------------------------
            {
                step_id: "B3_TAP_HAYSTACK_PICK_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • HAYSTACK_PICK • 01",
                activity: "RIMAY - Hablar",
                description: "Elige la pregunta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_HAYSTACK_PICK_01_EX",
                    type: "HAYSTACK_PICK",
                    title: "Tapuykuna (Haystack) 01",
                    prompt: "Selecciona en Kichwa:",
                    payload: {
                        question: {es: "¿Dónde?", ki: "Maypi?"},
                        haystack: ["Maypi?", "Imanalla?", "Pita?", "Alli puncha", "Yupay", "Wasi", "Maki", "Yaku", "Rumi", "Sacha"],
                        correct: ["Maypi?"]
                    }
                }
            },
            {
                step_id: "B3_TAP_HAYSTACK_PICK_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • HAYSTACK_PICK • 02",
                activity: "RIMAY - Hablar",
                description: "Elige la pregunta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_HAYSTACK_PICK_02_EX",
                    type: "HAYSTACK_PICK",
                    title: "Tapuykuna (Haystack) 02",
                    prompt: "Selecciona en Kichwa:",
                    payload: {
                        question: {es: "¿Quién?", ki: "Pita?"},
                        haystack: ["Maypi?", "Imanalla?", "Pita?", "Iman shuti?", "Alli tuta", "Yupay", "Arí", "Mana", "Wasi", "Maki"],
                        correct: ["Pita?"]
                    }
                }
            },
            {
                step_id: "B3_TAP_HAYSTACK_PICK_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • HAYSTACK_PICK • 03",
                activity: "RIMAY - Hablar",
                description: "Elige la pregunta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_HAYSTACK_PICK_03_EX",
                    type: "HAYSTACK_PICK",
                    title: "Tapuykuna (Haystack) 03",
                    prompt: "Selecciona en Kichwa:",
                    payload: {
                        question: {es: "¿Cómo estás?", ki: "Imanalla?"},
                        haystack: ["Imanalla?", "Maypi?", "Pita?", "Imashina?", "Allillachu", "Yupay", "Alli puncha", "Alli tuta", "Wasi", "Rumi"],
                        correct: ["Imanalla?"]
                    }
                }
            },
            {
                step_id: "B3_TAP_HAYSTACK_PICK_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • HAYSTACK_PICK • 04",
                activity: "RIMAY - Hablar",
                description: "Elige la pregunta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_HAYSTACK_PICK_04_EX",
                    type: "HAYSTACK_PICK",
                    title: "Tapuykuna (Haystack) 04",
                    prompt: "Selecciona en Kichwa:",
                    payload: {
                        question: {es: "¿Cuál es tu nombre?", ki: "Iman shuti?"},
                        haystack: ["Iman shuti?", "Imanalla?", "Maypi?", "Pita?", "Alli puncha", "Yupay", "Arí", "Mana", "Maki", "Yaku"],
                        correct: ["Iman shuti?"]
                    }
                }
            },
            {
                step_id: "B3_TAP_HAYSTACK_PICK_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • HAYSTACK_PICK • 05",
                activity: "RIMAY - Hablar",
                description: "Elige la pregunta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_HAYSTACK_PICK_05_EX",
                    type: "HAYSTACK_PICK",
                    title: "Tapuykuna (Haystack) 05",
                    prompt: "Selecciona en Kichwa:",
                    payload: {
                        question: {es: "¿A dónde vas?", ki: "Mayman rinki?"},
                        haystack: ["Mayman rinki?", "Maypi?", "Imanalla?", "Pita?", "Yupay", "Allillachu", "Alli tuta", "Wasi", "Maki", "Rumi"],
                        correct: ["Mayman rinki?"]
                    }
                }
            },

            // -------------------------
            // IMAGE_HOTSPOT_PICK (5)
            // Nota: aquí lo usamos como "selecciona la burbuja correcta"
            // en una imagen (demo). Sirve para UI, aunque el tema sea tapuykuna.
            // -------------------------
            {
                step_id: "B3_TAP_IMAGE_HOTSPOT_PICK_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • IMAGE_HOTSPOT_PICK • 01",
                activity: "RIKSINA - Mirar",
                description: "Marca la pregunta correcta (hotspot).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_IMAGE_HOTSPOT_PICK_01_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Tapuykuna (Hotspot) 01",
                    prompt: "Marca SOLO la pregunta “¿Dónde?” (Maypi?):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "maypi", xPct: 30, yPct: 30, label: "Maypi?", isCorrect: true},
                            {id: "imanalla", xPct: 60, yPct: 30, label: "Imanalla?", isCorrect: false},
                            {id: "pita", xPct: 45, yPct: 60, label: "Pita?", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_IMAGE_HOTSPOT_PICK_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • IMAGE_HOTSPOT_PICK • 02",
                activity: "RIKSINA - Mirar",
                description: "Marca la pregunta correcta (hotspot).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_IMAGE_HOTSPOT_PICK_02_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Tapuykuna (Hotspot) 02",
                    prompt: "Marca SOLO la pregunta “¿Quién?” (Pita?):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "pita", xPct: 50, yPct: 30, label: "Pita?", isCorrect: true},
                            {id: "maypi", xPct: 25, yPct: 55, label: "Maypi?", isCorrect: false},
                            {id: "imanalla", xPct: 70, yPct: 60, label: "Imanalla?", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_IMAGE_HOTSPOT_PICK_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • IMAGE_HOTSPOT_PICK • 03",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 2 preguntas correctas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_IMAGE_HOTSPOT_PICK_03_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Tapuykuna (Hotspot) 03",
                    prompt: "Marca SOLO 2 preguntas: Maypi? y Pita?",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 2,
                        showLabels: true,
                        hotspots: [
                            {id: "maypi", xPct: 25, yPct: 35, label: "Maypi?", isCorrect: true},
                            {id: "pita", xPct: 60, yPct: 35, label: "Pita?", isCorrect: true},
                            {id: "yupay", xPct: 40, yPct: 65, label: "Yupay", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_IMAGE_HOTSPOT_PICK_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • IMAGE_HOTSPOT_PICK • 04",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 1 pregunta correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_IMAGE_HOTSPOT_PICK_04_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Tapuykuna (Hotspot) 04",
                    prompt: "Marca SOLO “Imanalla?”",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "imanalla", xPct: 50, yPct: 50, label: "Imanalla?", isCorrect: true},
                            {id: "maypi", xPct: 20, yPct: 30, label: "Maypi?", isCorrect: false},
                            {id: "pita", xPct: 80, yPct: 30, label: "Pita?", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B3_TAP_IMAGE_HOTSPOT_PICK_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • IMAGE_HOTSPOT_PICK • 05",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 3 preguntas correctas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_IMAGE_HOTSPOT_PICK_05_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Tapuykuna (Hotspot) 05",
                    prompt: "Marca SOLO 3 preguntas: Maypi?, Pita?, Imanalla?",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 3,
                        showLabels: true,
                        hotspots: [
                            {id: "maypi", xPct: 25, yPct: 30, label: "Maypi?", isCorrect: true},
                            {id: "pita", xPct: 55, yPct: 30, label: "Pita?", isCorrect: true},
                            {id: "imanalla", xPct: 40, yPct: 65, label: "Imanalla?", isCorrect: true},
                            {id: "yupay", xPct: 75, yPct: 65, label: "Yupay", isCorrect: false}
                        ]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT (5)
            // -------------------------
            {
                step_id: "B3_TAP_MULTI_SELECT_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT • 01",
                activity: "RIMAY - Hablar",
                description: "Selecciona SOLO preguntas (tapuykuna).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_01_EX",
                    type: "MULTI_SELECT",
                    title: "Tapuykuna (Multi) 01",
                    prompt: "Selecciona las preguntas (3 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Maypi?"},
                            {id: "b", text: "Pita?"},
                            {id: "c", text: "Imanalla?"},
                            {id: "d", text: "Alli puncha"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT • 02",
                activity: "RIMAY - Hablar",
                description: "Selecciona SOLO respuestas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_02_EX",
                    type: "MULTI_SELECT",
                    title: "Tapuykuna (Multi) 02",
                    prompt: "Selecciona las respuestas (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Allillachu"},
                            {id: "b", text: "Arí"},
                            {id: "c", text: "Maypi?"},
                            {id: "d", text: "Pita?"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT • 03",
                activity: "RIMAY - Hablar",
                description: "Selecciona la pregunta de identidad.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_03_EX",
                    type: "MULTI_SELECT",
                    title: "Tapuykuna (Multi) 03",
                    prompt: "Selecciona SOLO 1 correcta:",
                    payload: {
                        options: [
                            {id: "a", text: "Iman shuti?"},
                            {id: "b", text: "Yupay"},
                            {id: "c", text: "Alli tuta"},
                            {id: "d", text: "Allillachu"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT • 04",
                activity: "RIMAY - Hablar",
                description: "Selecciona preguntas de acción.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_04_EX",
                    type: "MULTI_SELECT",
                    title: "Tapuykuna (Multi) 04",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Imata ruwanki?"},
                            {id: "b", text: "Mayman rinki?"},
                            {id: "c", text: "Yupay"},
                            {id: "d", text: "Alli puncha"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT • 05",
                activity: "RIMAY - Hablar",
                description: "Selecciona preguntas básicas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_05_EX",
                    type: "MULTI_SELECT",
                    title: "Tapuykuna (Multi) 05",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "Imashina?"},
                            {id: "b", text: "Maypi?"},
                            {id: "c", text: "Arí"},
                            {id: "d", text: "Mana"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT_IMAGE (5)
            // -------------------------
            {
                step_id: "B3_TAP_MULTI_SELECT_IMAGE_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT_IMAGE • 01",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO preguntas (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_IMAGE_01_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Tapuykuna (Imagen Multi) 01",
                    prompt: "Selecciona las preguntas (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        alt: "conversation",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "Maypi?"},
                            {id: "b", text: "Pita?"},
                            {id: "c", text: "Yupay"},
                            {id: "d", text: "Alli puncha"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_IMAGE_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT_IMAGE • 02",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO respuestas (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_IMAGE_02_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Tapuykuna (Imagen Multi) 02",
                    prompt: "Selecciona las respuestas (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        alt: "conversation",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "Arí"},
                            {id: "b", text: "Mana"},
                            {id: "c", text: "Maypi?"},
                            {id: "d", text: "Pita?"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_IMAGE_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT_IMAGE • 03",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO 1 pregunta (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_IMAGE_03_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Tapuykuna (Imagen Multi) 03",
                    prompt: "Selecciona SOLO 1 correcta:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        alt: "conversation",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "Iman shuti?"},
                            {id: "b", text: "Yupay"},
                            {id: "c", text: "Alli tuta"},
                            {id: "d", text: "Allillachu"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_IMAGE_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT_IMAGE • 04",
                activity: "RIKSINA - Mirar",
                description: "Selecciona preguntas de acción (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_IMAGE_04_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Tapuykuna (Imagen Multi) 04",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        alt: "conversation",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "Imata ruwanki?"},
                            {id: "b", text: "Mayman rinki?"},
                            {id: "c", text: "Yupay"},
                            {id: "d", text: "Alli puncha"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B3_TAP_MULTI_SELECT_IMAGE_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • MULTI_SELECT_IMAGE • 05",
                activity: "RIKSINA - Mirar",
                description: "Selecciona preguntas básicas (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_MULTI_SELECT_IMAGE_05_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Tapuykuna (Imagen Multi) 05",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1520975958225-79a7d8a9f2fd?auto=format&fit=crop&w=1200&q=60",
                        alt: "conversation",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "Imashina?"},
                            {id: "b", text: "Maypi?"},
                            {id: "c", text: "Arí"},
                            {id: "d", text: "Mana"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },

            // -------------------------
            // ORDER_WORDS (5)
            // -------------------------
            {
                step_id: "B3_TAP_ORDER_WORDS_01",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • ORDER_WORDS • 01",
                activity: "KILLKAY - Escribir",
                description: "Ordena la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_ORDER_WORDS_01_EX",
                    type: "ORDER_WORDS",
                    title: "Tapuykuna (Ordenar) 01",
                    prompt: "Ordena la pregunta:",
                    payload: {
                        correctOrder: ["Maypi", "?"],
                        items: ["?", "Maypi"]
                    }
                }
            },
            {
                step_id: "B3_TAP_ORDER_WORDS_02",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • ORDER_WORDS • 02",
                activity: "KILLKAY - Escribir",
                description: "Ordena la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_ORDER_WORDS_02_EX",
                    type: "ORDER_WORDS",
                    title: "Tapuykuna (Ordenar) 02",
                    prompt: "Ordena la pregunta:",
                    payload: {
                        correctOrder: ["Pita", "?"],
                        items: ["?", "Pita"]
                    }
                }
            },
            {
                step_id: "B3_TAP_ORDER_WORDS_03",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • ORDER_WORDS • 03",
                activity: "KILLKAY - Escribir",
                description: "Ordena la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_ORDER_WORDS_03_EX",
                    type: "ORDER_WORDS",
                    title: "Tapuykuna (Ordenar) 03",
                    prompt: "Ordena la pregunta:",
                    payload: {
                        correctOrder: ["Imanalla", "?"],
                        items: ["?", "Imanalla"]
                    }
                }
            },
            {
                step_id: "B3_TAP_ORDER_WORDS_04",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • ORDER_WORDS • 04",
                activity: "KILLKAY - Escribir",
                description: "Ordena la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_ORDER_WORDS_04_EX",
                    type: "ORDER_WORDS",
                    title: "Tapuykuna (Ordenar) 04",
                    prompt: "Ordena la pregunta:",
                    payload: {
                        correctOrder: ["Iman", "shuti", "?"],
                        items: ["shuti", "?", "Iman"]
                    }
                }
            },
            {
                step_id: "B3_TAP_ORDER_WORDS_05",
                unidad_seccion_id: 3,
                unidad_id: 1,
                configuracion_ui_ux_id: 1,
                title: "TAPUYKUNA-SALUDOS • ORDER_WORDS • 05",
                activity: "KILLKAY - Escribir",
                description: "Ordena la pregunta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B3_TAP_ORDER_WORDS_05_EX",
                    type: "ORDER_WORDS",
                    title: "Tapuykuna (Ordenar) 05",
                    prompt: "Ordena la pregunta:",
                    payload: {
                        correctOrder: ["Mayman", "rinki", "?"],
                        items: ["rinki", "?", "Mayman"]
                    }
                }
            }
        ];
        const BLOCK_4_MISHKIMURUKUNA_FRUTAS = [
            // =========================================================
            // BLOQUE 4: Mishkimurukuna - Frutas (35)
            // Tipos (5 c/u): DRAG_MATCH, FILL_BLANK, HAYSTACK_PICK,
            //                IMAGE_HOTSPOT_PICK, MULTI_SELECT,
            //                MULTI_SELECT_IMAGE, ORDER_WORDS
            // =========================================================

            // -------------------------
            // DRAG_MATCH (5)
            // -------------------------
            {
                step_id: "B4_FRU_DRAG_MATCH_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • DRAG_MATCH • 01",
                activity: "RIMAY - Hablar",
                description: "Empareja fruta (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_DRAG_MATCH_01_EX",
                    type: "DRAG_MATCH",
                    title: "Frutas (Emparejar) 01",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "palta", right: "aguacate"},
                            {left: "apil", right: "manzana"},
                            {left: "sara", right: "maíz"},
                            {left: "limun", right: "limón"}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_DRAG_MATCH_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • DRAG_MATCH • 02",
                activity: "RIMAY - Hablar",
                description: "Empareja fruta (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_DRAG_MATCH_02_EX",
                    type: "DRAG_MATCH",
                    title: "Frutas (Emparejar) 02",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "killu limun", right: "limón amarillo"},
                            {left: "puka apil", right: "manzana roja"},
                            {left: "wiru", right: "verde (fruta verde)"},
                            {left: "mishki", right: "dulce"}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_DRAG_MATCH_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • DRAG_MATCH • 03",
                activity: "RIMAY - Hablar",
                description: "Empareja fruta con su característica.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_DRAG_MATCH_03_EX",
                    type: "DRAG_MATCH",
                    title: "Frutas (Emparejar) 03",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "mishki", right: "dulce"},
                            {left: "killi", right: "amarillo"},
                            {left: "puka", right: "rojo"},
                            {left: "yaku", right: "agua"}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_DRAG_MATCH_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • DRAG_MATCH • 04",
                activity: "RIMAY - Hablar",
                description: "Empareja palabras útiles en la fruta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_DRAG_MATCH_04_EX",
                    type: "DRAG_MATCH",
                    title: "Frutas (Emparejar) 04",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "miku", right: "comer"},
                            {left: "mikuna", right: "comida"},
                            {left: "mishki", right: "dulce"},
                            {left: "ashka", right: "mucho"}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_DRAG_MATCH_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • DRAG_MATCH • 05",
                activity: "RIMAY - Hablar",
                description: "Empareja fruta (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_DRAG_MATCH_05_EX",
                    type: "DRAG_MATCH",
                    title: "Frutas (Emparejar) 05",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "muru", right: "semilla"},
                            {left: "sacha", right: "monte/bosque"},
                            {left: "puyu", right: "nube"},
                            {left: "inti", right: "sol"}
                        ]
                    }
                }
            },

            // -------------------------
            // FILL_BLANK (5)
            // -------------------------
            {
                step_id: "B4_FRU_FILL_BLANK_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • FILL_BLANK • 01",
                activity: "KILLKAY - Escribir",
                description: "Completa la palabra (fruta).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_FILL_BLANK_01_EX",
                    type: "FILL_BLANK",
                    title: "Frutas (Completar) 01",
                    prompt: "Completa:",
                    payload: {text: "La manzana (Kichwa) es ____", answer: "apil", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B4_FRU_FILL_BLANK_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • FILL_BLANK • 02",
                activity: "KILLKAY - Escribir",
                description: "Completa la palabra (fruta).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_FILL_BLANK_02_EX",
                    type: "FILL_BLANK",
                    title: "Frutas (Completar) 02",
                    prompt: "Completa:",
                    payload: {text: "El aguacate (Kichwa) es ____", answer: "palta", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B4_FRU_FILL_BLANK_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • FILL_BLANK • 03",
                activity: "KILLKAY - Escribir",
                description: "Completa la palabra (concepto).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_FILL_BLANK_03_EX",
                    type: "FILL_BLANK",
                    title: "Frutas (Completar) 03",
                    prompt: "Completa:",
                    payload: {text: "Dulce (Kichwa) es ____", answer: "mishki", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B4_FRU_FILL_BLANK_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • FILL_BLANK • 04",
                activity: "KILLKAY - Escribir",
                description: "Completa la palabra (concepto).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_FILL_BLANK_04_EX",
                    type: "FILL_BLANK",
                    title: "Frutas (Completar) 04",
                    prompt: "Completa:",
                    payload: {text: "Semilla (Kichwa) es ____", answer: "muru", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B4_FRU_FILL_BLANK_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • FILL_BLANK • 05",
                activity: "KILLKAY - Escribir",
                description: "Completa la palabra (acción).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_FILL_BLANK_05_EX",
                    type: "FILL_BLANK",
                    title: "Frutas (Completar) 05",
                    prompt: "Completa:",
                    payload: {text: "Comer (Kichwa) es ____", answer: "miku", trim: true, ignoreCase: true}
                }
            },

            // -------------------------
            // HAYSTACK_PICK (5)
            // -------------------------
            {
                step_id: "B4_FRU_HAYSTACK_PICK_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • HAYSTACK_PICK • 01",
                activity: "RIKSINA - Mirar",
                description: "Elige la fruta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_HAYSTACK_PICK_01_EX",
                    type: "HAYSTACK_PICK",
                    title: "Frutas (Haystack) 01",
                    prompt: "Selecciona la fruta correcta en Kichwa:",
                    payload: {
                        question: {es: "Manzana", ki: "apil"},
                        haystack: ["apil", "palta", "wasi", "maki", "rumi", "yaku", "sacha", "inti", "killa", "puyu"],
                        correct: ["apil"]
                    }
                }
            },
            {
                step_id: "B4_FRU_HAYSTACK_PICK_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • HAYSTACK_PICK • 02",
                activity: "RIKSINA - Mirar",
                description: "Elige la fruta correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_HAYSTACK_PICK_02_EX",
                    type: "HAYSTACK_PICK",
                    title: "Frutas (Haystack) 02",
                    prompt: "Selecciona la fruta correcta en Kichwa:",
                    payload: {
                        question: {es: "Aguacate", ki: "palta"},
                        haystack: ["palta", "apil", "mishki", "muru", "miku", "mikuna", "ashka", "inti", "killa", "puyu"],
                        correct: ["palta"]
                    }
                }
            },
            {
                step_id: "B4_FRU_HAYSTACK_PICK_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • HAYSTACK_PICK • 03",
                activity: "RIKSINA - Mirar",
                description: "Elige el concepto correcto.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_HAYSTACK_PICK_03_EX",
                    type: "HAYSTACK_PICK",
                    title: "Frutas (Haystack) 03",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Dulce", ki: "mishki"},
                        haystack: ["mishki", "muru", "miku", "wasi", "maki", "yaku", "rumi", "sacha", "inti", "puyu"],
                        correct: ["mishki"]
                    }
                }
            },
            {
                step_id: "B4_FRU_HAYSTACK_PICK_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • HAYSTACK_PICK • 04",
                activity: "RIKSINA - Mirar",
                description: "Elige el concepto correcto.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_HAYSTACK_PICK_04_EX",
                    type: "HAYSTACK_PICK",
                    title: "Frutas (Haystack) 04",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Semilla", ki: "muru"},
                        haystack: ["muru", "mishki", "palta", "apil", "miku", "mikuna", "yaku", "rumi", "sacha", "inti"],
                        correct: ["muru"]
                    }
                }
            },
            {
                step_id: "B4_FRU_HAYSTACK_PICK_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • HAYSTACK_PICK • 05",
                activity: "RIKSINA - Mirar",
                description: "Elige la acción correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_HAYSTACK_PICK_05_EX",
                    type: "HAYSTACK_PICK",
                    title: "Frutas (Haystack) 05",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Comer", ki: "miku"},
                        haystack: ["miku", "mikuna", "muru", "mishki", "apil", "palta", "yaku", "rumi", "sacha", "inti"],
                        correct: ["miku"]
                    }
                }
            },

            // -------------------------
            // IMAGE_HOTSPOT_PICK (5)
            // Nota: aquí sí lo usamos con "frutas en imagen"
            // -------------------------
            {
                step_id: "B4_FRU_IMAGE_HOTSPOT_PICK_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • IMAGE_HOTSPOT_PICK • 01",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO la fruta correcta en la imagen.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_IMAGE_HOTSPOT_PICK_01_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Frutas (Hotspot) 01",
                    prompt: "Marca SOLO “apil” (manzana):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "apil", xPct: 35, yPct: 55, label: "apil", isCorrect: true},
                            {id: "palta", xPct: 60, yPct: 55, label: "palta", isCorrect: false},
                            {id: "wasi", xPct: 50, yPct: 25, label: "wasi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_IMAGE_HOTSPOT_PICK_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • IMAGE_HOTSPOT_PICK • 02",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO la fruta correcta en la imagen.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_IMAGE_HOTSPOT_PICK_02_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Frutas (Hotspot) 02",
                    prompt: "Marca SOLO “palta” (aguacate):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "palta", xPct: 60, yPct: 55, label: "palta", isCorrect: true},
                            {id: "apil", xPct: 35, yPct: 55, label: "apil", isCorrect: false},
                            {id: "muru", xPct: 50, yPct: 25, label: "muru", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_IMAGE_HOTSPOT_PICK_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • IMAGE_HOTSPOT_PICK • 03",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 2 frutas correctas.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_IMAGE_HOTSPOT_PICK_03_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Frutas (Hotspot) 03",
                    prompt: "Marca SOLO 2: apil y palta",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 2,
                        showLabels: true,
                        hotspots: [
                            {id: "apil", xPct: 35, yPct: 55, label: "apil", isCorrect: true},
                            {id: "palta", xPct: 60, yPct: 55, label: "palta", isCorrect: true},
                            {id: "yaku", xPct: 50, yPct: 25, label: "yaku", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_IMAGE_HOTSPOT_PICK_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • IMAGE_HOTSPOT_PICK • 04",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 3 correctas (conceptos).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_IMAGE_HOTSPOT_PICK_04_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Frutas (Hotspot) 04",
                    prompt: "Marca SOLO 3: mishki, muru, miku",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 3,
                        showLabels: true,
                        hotspots: [
                            {id: "mishki", xPct: 25, yPct: 30, label: "mishki", isCorrect: true},
                            {id: "muru", xPct: 50, yPct: 30, label: "muru", isCorrect: true},
                            {id: "miku", xPct: 75, yPct: 30, label: "miku", isCorrect: true},
                            {id: "rumi", xPct: 50, yPct: 70, label: "rumi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B4_FRU_IMAGE_HOTSPOT_PICK_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • IMAGE_HOTSPOT_PICK • 05",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 1 concepto correcto.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_IMAGE_HOTSPOT_PICK_05_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Frutas (Hotspot) 05",
                    prompt: "Marca SOLO “mishki” (dulce):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "mishki", xPct: 25, yPct: 30, label: "mishki", isCorrect: true},
                            {id: "muru", xPct: 50, yPct: 30, label: "muru", isCorrect: false},
                            {id: "miku", xPct: 75, yPct: 30, label: "miku", isCorrect: false}
                        ]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT (5)
            // -------------------------
            {
                step_id: "B4_FRU_MULTI_SELECT_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT • 01",
                activity: "RIKSINA - Mirar",
                description: "Selecciona frutas (Kichwa).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_01_EX",
                    type: "MULTI_SELECT",
                    title: "Frutas (Multi) 01",
                    prompt: "Selecciona SOLO frutas (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "palta"},
                            {id: "c", text: "wasi"},
                            {id: "d", text: "maki"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT • 02",
                activity: "RIKSINA - Mirar",
                description: "Selecciona conceptos de fruta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_02_EX",
                    type: "MULTI_SELECT",
                    title: "Frutas (Multi) 02",
                    prompt: "Selecciona conceptos (3 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "mishki"},
                            {id: "b", text: "muru"},
                            {id: "c", text: "miku"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT • 03",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO 1 fruta correcta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_03_EX",
                    type: "MULTI_SELECT",
                    title: "Frutas (Multi) 03",
                    prompt: "Selecciona SOLO 1 fruta:",
                    payload: {
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "wasi"},
                            {id: "c", text: "maki"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT • 04",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO palabras NO-fruta.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_04_EX",
                    type: "MULTI_SELECT",
                    title: "Frutas (Multi) 04",
                    prompt: "Selecciona SOLO NO-fruta (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "wasi"},
                            {id: "b", text: "maki"},
                            {id: "c", text: "apil"},
                            {id: "d", text: "palta"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT • 05",
                activity: "RIKSINA - Mirar",
                description: "Selecciona solo conceptos correctos.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_05_EX",
                    type: "MULTI_SELECT",
                    title: "Frutas (Multi) 05",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        options: [
                            {id: "a", text: "mishki"},
                            {id: "b", text: "muru"},
                            {id: "c", text: "killa"},
                            {id: "d", text: "inti"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT_IMAGE (5)
            // -------------------------
            {
                step_id: "B4_FRU_MULTI_SELECT_IMAGE_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT_IMAGE • 01",
                activity: "RIKSINA - Mirar",
                description: "Selecciona frutas (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_IMAGE_01_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Frutas (Imagen Multi) 01",
                    prompt: "Selecciona las frutas (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "palta"},
                            {id: "c", text: "wasi"},
                            {id: "d", text: "maki"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_IMAGE_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT_IMAGE • 02",
                activity: "RIKSINA - Mirar",
                description: "Selecciona conceptos (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_IMAGE_02_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Frutas (Imagen Multi) 02",
                    prompt: "Selecciona conceptos (3 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "mishki"},
                            {id: "b", text: "muru"},
                            {id: "c", text: "miku"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_IMAGE_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT_IMAGE • 03",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO 1 fruta (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_IMAGE_03_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Frutas (Imagen Multi) 03",
                    prompt: "Selecciona SOLO 1 fruta:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "apil"},
                            {id: "b", text: "wasi"},
                            {id: "c", text: "maki"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_IMAGE_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT_IMAGE • 04",
                activity: "RIKSINA - Mirar",
                description: "Selecciona NO-fruta (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_IMAGE_04_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Frutas (Imagen Multi) 04",
                    prompt: "Selecciona SOLO NO-fruta (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "wasi"},
                            {id: "b", text: "maki"},
                            {id: "c", text: "apil"},
                            {id: "d", text: "palta"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B4_FRU_MULTI_SELECT_IMAGE_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • MULTI_SELECT_IMAGE • 05",
                activity: "RIKSINA - Mirar",
                description: "Selecciona conceptos (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_MULTI_SELECT_IMAGE_05_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Frutas (Imagen Multi) 05",
                    prompt: "Selecciona (2 correctas):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        alt: "frutas",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "mishki"},
                            {id: "b", text: "muru"},
                            {id: "c", text: "killa"},
                            {id: "d", text: "inti"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },

            // -------------------------
            // ORDER_WORDS (5)
            // -------------------------
            {
                step_id: "B4_FRU_ORDER_WORDS_01",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • ORDER_WORDS • 01",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_ORDER_WORDS_01_EX",
                    type: "ORDER_WORDS",
                    title: "Frutas (Ordenar) 01",
                    prompt: "Ordena la frase en Kichwa:",
                    payload: {
                        correctOrder: ["Ñuka", "miku", "apil", "."],
                        items: [".", "apil", "Ñuka", "miku"]
                    }
                }
            },
            {
                step_id: "B4_FRU_ORDER_WORDS_02",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • ORDER_WORDS • 02",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_ORDER_WORDS_02_EX",
                    type: "ORDER_WORDS",
                    title: "Frutas (Ordenar) 02",
                    prompt: "Ordena la frase en Kichwa:",
                    payload: {
                        correctOrder: ["Ñuka", "miku", "palta", "."],
                        items: ["miku", ".", "palta", "Ñuka"]
                    }
                }
            },
            {
                step_id: "B4_FRU_ORDER_WORDS_03",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • ORDER_WORDS • 03",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_ORDER_WORDS_03_EX",
                    type: "ORDER_WORDS",
                    title: "Frutas (Ordenar) 03",
                    prompt: "Ordena la frase en Kichwa:",
                    payload: {
                        correctOrder: ["Kay", "apil", "mishkimi", "kan", "."],
                        items: ["kan", "Kay", "mishkimi", ".", "apil"]
                    }
                }
            },
            {
                step_id: "B4_FRU_ORDER_WORDS_04",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • ORDER_WORDS • 04",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_ORDER_WORDS_04_EX",
                    type: "ORDER_WORDS",
                    title: "Frutas (Ordenar) 04",
                    prompt: "Ordena la frase en Kichwa:",
                    payload: {
                        correctOrder: ["Ñuka", "palta", "munani", "."],
                        items: [".", "munani", "palta", "Ñuka"]
                    }
                }
            },
            {
                step_id: "B4_FRU_ORDER_WORDS_05",
                unidad_seccion_id: 4,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Mishkimurukuna - Frutas • ORDER_WORDS • 05",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B4_FRU_ORDER_WORDS_05_EX",
                    type: "ORDER_WORDS",
                    title: "Frutas (Ordenar) 05",
                    prompt: "Ordena la frase en Kichwa:",
                    payload: {
                        correctOrder: ["Ñukanchik", "mikuna", "mishkimi", "kan", "."],
                        items: ["kan", "Ñukanchik", "mishkimi", ".", "mikuna"]
                    }
                }
            }
        ];
        const BLOCK_5_RUNAPA_UKKU_HOTSPOTS = [
            // =========================================================
            // BLOQUE 5: Runapa Ukku (hotspots) (35)
            // Tipos (5 c/u): DRAG_MATCH, FILL_BLANK, HAYSTACK_PICK,
            //                IMAGE_HOTSPOT_PICK, MULTI_SELECT,
            //                MULTI_SELECT_IMAGE, ORDER_WORDS
            // =========================================================

            // -------------------------
            // DRAG_MATCH (5)
            // -------------------------
            {
                step_id: "B5_UKKU_DRAG_MATCH_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • DRAG_MATCH • 01",
                activity: "RIMAY - Hablar",
                description: "Empareja parte del cuerpo (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_DRAG_MATCH_01_EX",
                    type: "DRAG_MATCH",
                    title: "Cuerpo (Emparejar) 01",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "ñawi", right: "ojo"},
                            {left: "simi", right: "boca"},
                            {left: "maki", right: "mano"},
                            {left: "chaki", right: "pie"}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_DRAG_MATCH_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • DRAG_MATCH • 02",
                activity: "RIMAY - Hablar",
                description: "Empareja parte del cuerpo (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_DRAG_MATCH_02_EX",
                    type: "DRAG_MATCH",
                    title: "Cuerpo (Emparejar) 02",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "ninri", right: "oreja"},
                            {left: "uma", right: "cabeza"},
                            {left: "kunka", right: "cuello"},
                            {left: "rikra", right: "brazo"}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_DRAG_MATCH_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • DRAG_MATCH • 03",
                activity: "RIMAY - Hablar",
                description: "Empareja parte del cuerpo (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_DRAG_MATCH_03_EX",
                    type: "DRAG_MATCH",
                    title: "Cuerpo (Emparejar) 03",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "wiksa", right: "barriga"},
                            {left: "wawa", right: "bebé/niño"},
                            {left: "sunka", right: "corazón"},
                            {left: "kunkur", right: "rodilla"}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_DRAG_MATCH_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • DRAG_MATCH • 04",
                activity: "RIMAY - Hablar",
                description: "Empareja parte del cuerpo (Kichwa) con Español.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_DRAG_MATCH_04_EX",
                    type: "DRAG_MATCH",
                    title: "Cuerpo (Emparejar) 04",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "sinqa", right: "nariz"},
                            {left: "kiru", right: "diente"},
                            {left: "akcha", right: "cabello"},
                            {left: "ñuka", right: "yo"}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_DRAG_MATCH_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • DRAG_MATCH • 05",
                activity: "RIMAY - Hablar",
                description: "Empareja verbos relacionados al cuerpo.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_DRAG_MATCH_05_EX",
                    type: "DRAG_MATCH",
                    title: "Cuerpo (Emparejar) 05",
                    prompt: "Empareja Kichwa con Español:",
                    payload: {
                        pairs: [
                            {left: "rikuni", right: "ver"},
                            {left: "uyani", right: "oír"},
                            {left: "rimani", right: "hablar"},
                            {left: "miku", right: "comer"}
                        ]
                    }
                }
            },

            // -------------------------
            // FILL_BLANK (5)
            // -------------------------
            {
                step_id: "B5_UKKU_FILL_BLANK_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • FILL_BLANK • 01",
                activity: "KILLKAY - Escribir",
                description: "Completa la parte del cuerpo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_FILL_BLANK_01_EX",
                    type: "FILL_BLANK",
                    title: "Cuerpo (Completar) 01",
                    prompt: "Completa:",
                    payload: {text: "Ojo (Kichwa) es ____", answer: "ñawi", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B5_UKKU_FILL_BLANK_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • FILL_BLANK • 02",
                activity: "KILLKAY - Escribir",
                description: "Completa la parte del cuerpo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_FILL_BLANK_02_EX",
                    type: "FILL_BLANK",
                    title: "Cuerpo (Completar) 02",
                    prompt: "Completa:",
                    payload: {text: "Boca (Kichwa) es ____", answer: "simi", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B5_UKKU_FILL_BLANK_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • FILL_BLANK • 03",
                activity: "KILLKAY - Escribir",
                description: "Completa la parte del cuerpo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_FILL_BLANK_03_EX",
                    type: "FILL_BLANK",
                    title: "Cuerpo (Completar) 03",
                    prompt: "Completa:",
                    payload: {text: "Mano (Kichwa) es ____", answer: "maki", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B5_UKKU_FILL_BLANK_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • FILL_BLANK • 04",
                activity: "KILLKAY - Escribir",
                description: "Completa la parte del cuerpo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_FILL_BLANK_04_EX",
                    type: "FILL_BLANK",
                    title: "Cuerpo (Completar) 04",
                    prompt: "Completa:",
                    payload: {text: "Cabeza (Kichwa) es ____", answer: "uma", trim: true, ignoreCase: true}
                }
            },
            {
                step_id: "B5_UKKU_FILL_BLANK_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • FILL_BLANK • 05",
                activity: "KILLKAY - Escribir",
                description: "Completa la parte del cuerpo en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_FILL_BLANK_05_EX",
                    type: "FILL_BLANK",
                    title: "Cuerpo (Completar) 05",
                    prompt: "Completa:",
                    payload: {text: "Pie (Kichwa) es ____", answer: "chaki", trim: true, ignoreCase: true}
                }
            },

            // -------------------------
            // HAYSTACK_PICK (5)
            // -------------------------
            {
                step_id: "B5_UKKU_HAYSTACK_PICK_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • HAYSTACK_PICK • 01",
                activity: "RIKSINA - Mirar",
                description: "Elige la palabra correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_HAYSTACK_PICK_01_EX",
                    type: "HAYSTACK_PICK",
                    title: "Cuerpo (Haystack) 01",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Ojo", ki: "ñawi"},
                        haystack: ["ñawi", "simi", "maki", "chaki", "wasi", "rumi", "yaku", "inti", "killa", "puyu"],
                        correct: ["ñawi"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_HAYSTACK_PICK_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • HAYSTACK_PICK • 02",
                activity: "RIKSINA - Mirar",
                description: "Elige la palabra correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_HAYSTACK_PICK_02_EX",
                    type: "HAYSTACK_PICK",
                    title: "Cuerpo (Haystack) 02",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Boca", ki: "simi"},
                        haystack: ["simi", "ñawi", "maki", "chaki", "uma", "kunka", "ninri", "rumi", "yaku", "inti"],
                        correct: ["simi"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_HAYSTACK_PICK_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • HAYSTACK_PICK • 03",
                activity: "RIKSINA - Mirar",
                description: "Elige la palabra correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_HAYSTACK_PICK_03_EX",
                    type: "HAYSTACK_PICK",
                    title: "Cuerpo (Haystack) 03",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Mano", ki: "maki"},
                        haystack: ["maki", "chaki", "uma", "kunka", "rikra", "ninri", "rumi", "yaku", "killa", "puyu"],
                        correct: ["maki"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_HAYSTACK_PICK_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • HAYSTACK_PICK • 04",
                activity: "RIKSINA - Mirar",
                description: "Elige la palabra correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_HAYSTACK_PICK_04_EX",
                    type: "HAYSTACK_PICK",
                    title: "Cuerpo (Haystack) 04",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Cabeza", ki: "uma"},
                        haystack: ["uma", "kunka", "ninri", "rikra", "maki", "chaki", "ñawi", "simi", "yaku", "inti"],
                        correct: ["uma"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_HAYSTACK_PICK_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • HAYSTACK_PICK • 05",
                activity: "RIKSINA - Mirar",
                description: "Elige la palabra correcta en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_HAYSTACK_PICK_05_EX",
                    type: "HAYSTACK_PICK",
                    title: "Cuerpo (Haystack) 05",
                    prompt: "Selecciona la palabra correcta en Kichwa:",
                    payload: {
                        question: {es: "Oreja", ki: "ninri"},
                        haystack: ["ninri", "uma", "kunka", "rikra", "maki", "chaki", "ñawi", "simi", "rumi", "puyu"],
                        correct: ["ninri"]
                    }
                }
            },

            // -------------------------
            // IMAGE_HOTSPOT_PICK (5)
            // -------------------------
            {
                step_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • IMAGE_HOTSPOT_PICK • 01",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO ojos y boca (2).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_01_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Cuerpo (Hotspots) 01",
                    prompt: "Marca SOLO: ñawi y simi",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 2,
                        showLabels: true,
                        hotspots: [
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: true},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: true},
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: false},
                            {id: "chaki", xPct: 55, yPct: 85, label: "chaki", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • IMAGE_HOTSPOT_PICK • 02",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO la mano (1).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_02_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Cuerpo (Hotspots) 02",
                    prompt: "Marca SOLO: maki",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: false},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • IMAGE_HOTSPOT_PICK • 03",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 3 (ñawi, simi, maki).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_03_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Cuerpo (Hotspots) 03",
                    prompt: "Marca SOLO 3: ñawi, simi, maki",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 3,
                        showLabels: true,
                        hotspots: [
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: true},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: true},
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "rumi", xPct: 20, yPct: 20, label: "rumi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • IMAGE_HOTSPOT_PICK • 04",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO el pie (1).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_04_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Cuerpo (Hotspots) 04",
                    prompt: "Marca SOLO: chaki",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "SINGLE",
                        maxPick: 1,
                        showLabels: true,
                        hotspots: [
                            {id: "chaki", xPct: 55, yPct: 85, label: "chaki", isCorrect: true},
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: false},
                            {id: "simi", xPct: 52, yPct: 30, label: "simi", isCorrect: false}
                        ]
                    }
                }
            },
            {
                step_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • IMAGE_HOTSPOT_PICK • 05",
                activity: "RIKSINA - Mirar",
                description: "Marca SOLO 2 (maki, chaki).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_IMAGE_HOTSPOT_PICK_05_EX",
                    type: "IMAGE_HOTSPOT_PICK",
                    title: "Cuerpo (Hotspots) 05",
                    prompt: "Marca SOLO: maki y chaki",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        mode: "MULTI",
                        maxPick: 2,
                        showLabels: true,
                        hotspots: [
                            {id: "maki", xPct: 70, yPct: 60, label: "maki", isCorrect: true},
                            {id: "chaki", xPct: 55, yPct: 85, label: "chaki", isCorrect: true},
                            {id: "ñawi", xPct: 52, yPct: 20, label: "ñawi", isCorrect: false}
                        ]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT (5)
            // -------------------------
            {
                step_id: "B5_UKKU_MULTI_SELECT_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT • 01",
                activity: "RIKSINA - Mirar",
                description: "Selecciona partes del cuerpo (2 correctas).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_01_EX",
                    type: "MULTI_SELECT",
                    title: "Cuerpo (Multi) 01",
                    prompt: "Selecciona SOLO partes del cuerpo (2):",
                    payload: {
                        options: [
                            {id: "a", text: "ñawi"},
                            {id: "b", text: "simi"},
                            {id: "c", text: "wasi"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT • 02",
                activity: "RIKSINA - Mirar",
                description: "Selecciona partes del cuerpo (3 correctas).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_02_EX",
                    type: "MULTI_SELECT",
                    title: "Cuerpo (Multi) 02",
                    prompt: "Selecciona SOLO partes del cuerpo (3):",
                    payload: {
                        options: [
                            {id: "a", text: "maki"},
                            {id: "b", text: "chaki"},
                            {id: "c", text: "uma"},
                            {id: "d", text: "yaku"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT • 03",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO 1 parte del cuerpo.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_03_EX",
                    type: "MULTI_SELECT",
                    title: "Cuerpo (Multi) 03",
                    prompt: "Selecciona SOLO 1 parte del cuerpo:",
                    payload: {
                        options: [
                            {id: "a", text: "ninri"},
                            {id: "b", text: "killa"},
                            {id: "c", text: "inti"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT • 04",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO NO-cuerpo (2 correctas).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_04_EX",
                    type: "MULTI_SELECT",
                    title: "Cuerpo (Multi) 04",
                    prompt: "Selecciona SOLO NO-cuerpo (2):",
                    payload: {
                        options: [
                            {id: "a", text: "wasi"},
                            {id: "b", text: "rumi"},
                            {id: "c", text: "maki"},
                            {id: "d", text: "chaki"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT • 05",
                activity: "RIKSINA - Mirar",
                description: "Selecciona sentidos / acciones (3 correctas).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_05_EX",
                    type: "MULTI_SELECT",
                    title: "Cuerpo (Multi) 05",
                    prompt: "Selecciona acciones correctas (3):",
                    payload: {
                        options: [
                            {id: "a", text: "rikuni"},
                            {id: "b", text: "uyani"},
                            {id: "c", text: "rimani"},
                            {id: "d", text: "puyu"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },

            // -------------------------
            // MULTI_SELECT_IMAGE (5)
            // -------------------------
            {
                step_id: "B5_UKKU_MULTI_SELECT_IMAGE_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT_IMAGE • 01",
                activity: "RIKSINA - Mirar",
                description: "Selecciona partes del cuerpo (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_IMAGE_01_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Cuerpo (Imagen Multi) 01",
                    prompt: "Selecciona SOLO partes del cuerpo (2):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        alt: "cuerpo",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "ñawi"},
                            {id: "b", text: "simi"},
                            {id: "c", text: "wasi"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_IMAGE_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT_IMAGE • 02",
                activity: "RIKSINA - Mirar",
                description: "Selecciona partes del cuerpo (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_IMAGE_02_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Cuerpo (Imagen Multi) 02",
                    prompt: "Selecciona SOLO partes del cuerpo (3):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        alt: "cuerpo",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "maki"},
                            {id: "b", text: "chaki"},
                            {id: "c", text: "uma"},
                            {id: "d", text: "yaku"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_IMAGE_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT_IMAGE • 03",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO 1 parte del cuerpo (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_IMAGE_03_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Cuerpo (Imagen Multi) 03",
                    prompt: "Selecciona SOLO 1 parte del cuerpo:",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        alt: "cuerpo",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "ninri"},
                            {id: "b", text: "killa"},
                            {id: "c", text: "inti"},
                            {id: "d", text: "rumi"}
                        ],
                        correctIds: ["a"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_IMAGE_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT_IMAGE • 04",
                activity: "RIKSINA - Mirar",
                description: "Selecciona SOLO NO-cuerpo (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_IMAGE_04_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Cuerpo (Imagen Multi) 04",
                    prompt: "Selecciona SOLO NO-cuerpo (2):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        alt: "cuerpo",
                        showImageFirst: true,
                        options: [
                            {id: "a", text: "wasi"},
                            {id: "b", text: "rumi"},
                            {id: "c", text: "maki"},
                            {id: "d", text: "chaki"}
                        ],
                        correctIds: ["a", "b"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_MULTI_SELECT_IMAGE_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • MULTI_SELECT_IMAGE • 05",
                activity: "RIKSINA - Mirar",
                description: "Selecciona acciones correctas (con imagen).",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_MULTI_SELECT_IMAGE_05_EX",
                    type: "MULTI_SELECT_IMAGE",
                    title: "Cuerpo (Imagen Multi) 05",
                    prompt: "Selecciona acciones correctas (3):",
                    payload: {
                        image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        alt: "cuerpo",
                        showImageFirst: false,
                        options: [
                            {id: "a", text: "rikuni"},
                            {id: "b", text: "uyani"},
                            {id: "c", text: "rimani"},
                            {id: "d", text: "puyu"}
                        ],
                        correctIds: ["a", "b", "c"]
                    }
                }
            },

            // -------------------------
            // ORDER_WORDS (5)
            // -------------------------
            {
                step_id: "B5_UKKU_ORDER_WORDS_01",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • ORDER_WORDS • 01",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_ORDER_WORDS_01_EX",
                    type: "ORDER_WORDS",
                    title: "Cuerpo (Ordenar) 01",
                    prompt: "Ordena la frase:",
                    payload: {
                        correctOrder: ["Ñuka", "ñawi", "kan", "."],
                        items: ["kan", "ñawi", "Ñuka", "."]
                    }
                }
            },
            {
                step_id: "B5_UKKU_ORDER_WORDS_02",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • ORDER_WORDS • 02",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_ORDER_WORDS_02_EX",
                    type: "ORDER_WORDS",
                    title: "Cuerpo (Ordenar) 02",
                    prompt: "Ordena la frase:",
                    payload: {
                        correctOrder: ["Ñuka", "simi", "kan", "."],
                        items: [".", "Ñuka", "kan", "simi"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_ORDER_WORDS_03",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • ORDER_WORDS • 03",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_ORDER_WORDS_03_EX",
                    type: "ORDER_WORDS",
                    title: "Cuerpo (Ordenar) 03",
                    prompt: "Ordena la frase:",
                    payload: {
                        correctOrder: ["Ñuka", "maki", "kan", "."],
                        items: ["maki", "Ñuka", ".", "kan"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_ORDER_WORDS_04",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • ORDER_WORDS • 04",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_ORDER_WORDS_04_EX",
                    type: "ORDER_WORDS",
                    title: "Cuerpo (Ordenar) 04",
                    prompt: "Ordena la frase:",
                    payload: {
                        correctOrder: ["Ñuka", "chaki", "kan", "."],
                        items: ["kan", "chaki", ".", "Ñuka"]
                    }
                }
            },
            {
                step_id: "B5_UKKU_ORDER_WORDS_05",
                unidad_seccion_id: 5,
                unidad_id: 2,
                configuracion_ui_ux_id: 2,
                title: "Runapa Ukku • ORDER_WORDS • 05",
                activity: "KILLKAY - Escribir",
                description: "Ordena la frase en Kichwa.",
                status: "ACTIVE",
                weight: 10,
                source: "",
                exercise: {
                    exercise_id: "B5_UKKU_ORDER_WORDS_05_EX",
                    type: "ORDER_WORDS",
                    title: "Cuerpo (Ordenar) 05",
                    prompt: "Ordena la frase:",
                    payload: {
                        correctOrder: ["Ñukanchik", "ukku", "kan", "."],
                        items: [".", "kan", "Ñukanchik", "ukku"]
                    }
                }
            }
        ];
        const BLOCK_6_ALETORI = [
            // =========================================================
            // BLOQUE 2: NAPAYKUN-SALUDOS (35)
            // (MISMA ESTRUCTURA: 5 por cada tipo)
            // =========================================================

            // ---- DRAG_MATCH (5)
            {
                "step_id": "SAL_DRAG_MATCH_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • DRAG_MATCH • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja saludos en Kichwa con Español.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_DRAG_MATCH_01_EX",
                    "type": "DRAG_MATCH",
                    "title": "Saludos (Emparejar) 01",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Alli puncha", "right": "Buenos días"},
                            {"left": "Alli chishi", "right": "Buenas tardes"},
                            {"left": "Alli tuta", "right": "Buenas noches"},
                            {"left": "Napaykuna", "right": "Saludos"}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_DRAG_MATCH_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • DRAG_MATCH • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja saludos en Kichwa con Español.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_DRAG_MATCH_02_EX",
                    "type": "DRAG_MATCH",
                    "title": "Saludos (Emparejar) 02",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Imanalla", "right": "¿Cómo estás?"},
                            {"left": "Allillachu", "right": "Estoy bien"},
                            {"left": "Yupay", "right": "Gracias"},
                            {"left": "Arí", "right": "Sí"}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_DRAG_MATCH_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • DRAG_MATCH • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja saludos en Kichwa con Español.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_DRAG_MATCH_03_EX",
                    "type": "DRAG_MATCH",
                    "title": "Saludos (Emparejar) 03",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Mana", "right": "No"},
                            {"left": "Yupay", "right": "Gracias"},
                            {"left": "Napaykuna", "right": "Saludos"},
                            {"left": "Imanalla", "right": "¿Cómo estás?"}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_DRAG_MATCH_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • DRAG_MATCH • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja saludos en Kichwa con Español.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_DRAG_MATCH_04_EX",
                    "type": "DRAG_MATCH",
                    "title": "Saludos (Emparejar) 04",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Alli puncha", "right": "Buenos días"},
                            {"left": "Yupay", "right": "Gracias"},
                            {"left": "Allillachu", "right": "Estoy bien"},
                            {"left": "Mana", "right": "No"}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_DRAG_MATCH_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • DRAG_MATCH • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja saludos en Kichwa con Español.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_DRAG_MATCH_05_EX",
                    "type": "DRAG_MATCH",
                    "title": "Saludos (Emparejar) 05",
                    "prompt": "Empareja Kichwa con Español:",
                    "payload": {
                        "pairs": [
                            {"left": "Alli tuta", "right": "Buenas noches"},
                            {"left": "Alli chishi", "right": "Buenas tardes"},
                            {"left": "Napaykuna", "right": "Saludos"},
                            {"left": "Yupay", "right": "Gracias"}
                        ]
                    }
                }
            },

            // ---- FILL_BLANK (5)
            {
                "step_id": "SAL_FILL_BLANK_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • FILL_BLANK • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Completa el saludo.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_FILL_BLANK_01_EX",
                    "type": "FILL_BLANK",
                    "title": "Saludos (Completar) 01",
                    "prompt": "Completa:",
                    "payload": {
                        "text": "Alli ____",
                        "answer": "puncha",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "SAL_FILL_BLANK_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • FILL_BLANK • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Completa el saludo.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_FILL_BLANK_02_EX",
                    "type": "FILL_BLANK",
                    "title": "Saludos (Completar) 02",
                    "prompt": "Completa:",
                    "payload": {
                        "text": "Alli ____",
                        "answer": "tuta",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "SAL_FILL_BLANK_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • FILL_BLANK • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Completa el saludo.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_FILL_BLANK_03_EX",
                    "type": "FILL_BLANK",
                    "title": "Saludos (Completar) 03",
                    "prompt": "Completa:",
                    "payload": {
                        "text": "____ killa",
                        "answer": "Alli",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "SAL_FILL_BLANK_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • FILL_BLANK • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Completa el saludo.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_FILL_BLANK_04_EX",
                    "type": "FILL_BLANK",
                    "title": "Saludos (Completar) 04",
                    "prompt": "Completa:",
                    "payload": {
                        "text": "____ puncha",
                        "answer": "Alli",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },
            {
                "step_id": "SAL_FILL_BLANK_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • FILL_BLANK • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Completa el saludo.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_FILL_BLANK_05_EX",
                    "type": "FILL_BLANK",
                    "title": "Saludos (Completar) 05",
                    "prompt": "Completa:",
                    "payload": {
                        "text": "Alli ____",
                        "answer": "chishi",
                        "trim": true,
                        "ignoreCase": true
                    }
                }
            },

            // ---- HAYSTACK_PICK (5)
            {
                "step_id": "SAL_HAYSTACK_PICK_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge el saludo correcto.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_HAYSTACK_PICK_01_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Saludos (Haystack) 01",
                    "prompt": "Selecciona la respuesta correcta:",
                    "payload": {
                        "question": {"es": "Buenos días", "ki": "Alli puncha"},
                        "haystack": ["Alli puncha", "Alli tuta", "Yupay", "Maypi?", "Ñuka", "shuti", "kan", "Wasi", "Maki", "Yaku"],
                        "correct": ["Alli puncha"]
                    }
                }
            },
            {
                "step_id": "SAL_HAYSTACK_PICK_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge el saludo correcto.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_HAYSTACK_PICK_02_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Saludos (Haystack) 02",
                    "prompt": "Selecciona la respuesta correcta:",
                    "payload": {
                        "question": {"es": "Gracias", "ki": "Yupay"},
                        "haystack": ["Yupay", "Alli puncha", "Alli tuta", "Maypi?", "Ñuka", "shuti", "kan", "Wasi", "Maki", "Rumi"],
                        "correct": ["Yupay"]
                    }
                }
            },
            {
                "step_id": "SAL_HAYSTACK_PICK_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge el saludo correcto.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_HAYSTACK_PICK_03_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Saludos (Haystack) 03",
                    "prompt": "Selecciona la respuesta correcta:",
                    "payload": {
                        "question": {"es": "Buenas noches", "ki": "Alli tuta"},
                        "haystack": ["Alli tuta", "Alli puncha", "Yupay", "Maypi?", "Wasi", "Maki", "Killa", "Inti", "Yaku", "Rumi"],
                        "correct": ["Alli tuta"]
                    }
                }
            },
            {
                "step_id": "SAL_HAYSTACK_PICK_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge el saludo correcto.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_HAYSTACK_PICK_04_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Saludos (Haystack) 04",
                    "prompt": "Selecciona la respuesta correcta:",
                    "payload": {
                        "question": {"es": "Saludos", "ki": "Napaykuna"},
                        "haystack": ["Napaykuna", "Alli tuta", "Alli puncha", "Yupay", "Maypi?", "Ñuka", "shuti", "kan", "Wasi", "Maki"],
                        "correct": ["Napaykuna"]
                    }
                }
            },
            {
                "step_id": "SAL_HAYSTACK_PICK_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • HAYSTACK_PICK • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Escoge el saludo correcto.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_HAYSTACK_PICK_05_EX",
                    "type": "HAYSTACK_PICK",
                    "title": "Saludos (Haystack) 05",
                    "prompt": "Selecciona la respuesta correcta:",
                    "payload": {
                        "question": {"es": "¿Cómo estás?", "ki": "Imanalla"},
                        "haystack": ["Imanalla", "Allillachu", "Yupay", "Alli puncha", "Alli tuta", "Maypi?", "Ñuka", "shuti", "Wasi", "Maki"],
                        "correct": ["Imanalla"]
                    }
                }
            },

            // ---- IMAGE_HOTSPOT_PICK (5)
            {
                "step_id": "SAL_IMAGE_HOTSPOT_PICK_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 01",
                "activity": "RIKSINA - Mirar",
                "description": "Hotspots demo (saludos).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_IMAGE_HOTSPOT_PICK_01_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Saludos (Hotspots) 01",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_IMAGE_HOTSPOT_PICK_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 02",
                "activity": "RIKSINA - Mirar",
                "description": "Hotspots demo (saludos).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_IMAGE_HOTSPOT_PICK_02_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Saludos (Hotspots) 02",
                    "prompt": "Marca SOLO la parte correcta:",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "SINGLE",
                        "maxPick": 1,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_IMAGE_HOTSPOT_PICK_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 03",
                "activity": "RIKSINA - Mirar",
                "description": "Hotspots demo (saludos).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_IMAGE_HOTSPOT_PICK_03_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Saludos (Hotspots) 03",
                    "prompt": "Marca SOLO las partes correctas (2):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 2,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_IMAGE_HOTSPOT_PICK_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 04",
                "activity": "RIKSINA - Mirar",
                "description": "Hotspots demo (saludos).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_IMAGE_HOTSPOT_PICK_04_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Saludos (Hotspots) 04",
                    "prompt": "Marca SOLO las partes correctas (labels off):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": false,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false}
                        ]
                    }
                }
            },
            {
                "step_id": "SAL_IMAGE_HOTSPOT_PICK_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • IMAGE_HOTSPOT_PICK • 05",
                "activity": "RIKSINA - Mirar",
                "description": "Hotspots demo (saludos).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_IMAGE_HOTSPOT_PICK_05_EX",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Saludos (Hotspots) 05",
                    "prompt": "Marca SOLO las partes correctas (3):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            },

            // ---- MULTI_SELECT (5)
            {
                "step_id": "SAL_MULTI_SELECT_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona los saludos.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_01_EX",
                    "type": "MULTI_SELECT",
                    "title": "Saludos (Multi) 01",
                    "prompt": "Selecciona (2 correctas):",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Alli puncha"},
                            {"id": "b", "text": "Alli tuta"},
                            {"id": "c", "text": "Wasi"},
                            {"id": "d", "text": "Rumi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona los saludos.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_02_EX",
                    "type": "MULTI_SELECT",
                    "title": "Saludos (Multi) 02",
                    "prompt": "Selecciona SOLO 1 correcta:",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Yupay"},
                            {"id": "b", "text": "Maypi?"},
                            {"id": "c", "text": "Sacha"},
                            {"id": "d", "text": "Rumi"}
                        ],
                        "correctIds": ["a"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona los saludos.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_03_EX",
                    "type": "MULTI_SELECT",
                    "title": "Saludos (Multi) 03",
                    "prompt": "Selecciona (2 correctas):",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Alli chishi"},
                            {"id": "b", "text": "Napaykuna"},
                            {"id": "c", "text": "Yaku"},
                            {"id": "d", "text": "Maki"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona los saludos.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_04_EX",
                    "type": "MULTI_SELECT",
                    "title": "Saludos (Multi) 04",
                    "prompt": "Selecciona SOLO 1 correcta:",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Allillachu"},
                            {"id": "b", "text": "Rumi"},
                            {"id": "c", "text": "Wasi"},
                            {"id": "d", "text": "Yaku"}
                        ],
                        "correctIds": ["a"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona los saludos.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_05_EX",
                    "type": "MULTI_SELECT",
                    "title": "Saludos (Multi) 05",
                    "prompt": "Selecciona (2 correctas):",
                    "payload": {
                        "options": [
                            {"id": "a", "text": "Imanalla"},
                            {"id": "b", "text": "Yupay"},
                            {"id": "c", "text": "Rumi"},
                            {"id": "d", "text": "Sacha"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },

            // ---- MULTI_SELECT_IMAGE (5)
            {
                "step_id": "SAL_MULTI_SELECT_IMAGE_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 01",
                "activity": "RIKSINA - Mirar",
                "description": "Multi select con imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_IMAGE_01_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Saludos (Imagen Multi) 01",
                    "prompt": "Selecciona las frutas (2 correctas):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "palta"},
                            {"id": "c", "text": "wasi"},
                            {"id": "d", "text": "maki"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_IMAGE_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 02",
                "activity": "RIKSINA - Mirar",
                "description": "Multi select con imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_IMAGE_02_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Saludos (Imagen Multi) 02",
                    "prompt": "Selecciona 1 correcta:",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "wasi"},
                            {"id": "c", "text": "rumi"},
                            {"id": "d", "text": "yaku"}
                        ],
                        "correctIds": ["a"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_IMAGE_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 03",
                "activity": "RIKSINA - Mirar",
                "description": "Multi select con imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_IMAGE_03_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Saludos (Imagen Multi) 03",
                    "prompt": "Selecciona 2 correctas:",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": false,
                        "options": [
                            {"id": "a", "text": "palta"},
                            {"id": "b", "text": "apil"},
                            {"id": "c", "text": "sacha"},
                            {"id": "d", "text": "wasi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_IMAGE_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 04",
                "activity": "RIKSINA - Mirar",
                "description": "Multi select con imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_IMAGE_04_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Saludos (Imagen Multi) 04",
                    "prompt": "Selecciona 1 correcta:",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "wasi"},
                            {"id": "b", "text": "maki"},
                            {"id": "c", "text": "palta"},
                            {"id": "d", "text": "rumi"}
                        ],
                        "correctIds": ["c"]
                    }
                }
            },
            {
                "step_id": "SAL_MULTI_SELECT_IMAGE_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • MULTI_SELECT_IMAGE • 05",
                "activity": "RIKSINA - Mirar",
                "description": "Multi select con imagen (demo).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_MULTI_SELECT_IMAGE_05_EX",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Saludos (Imagen Multi) 05",
                    "prompt": "Selecciona 2 correctas:",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "showImageFirst": true,
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "palta"},
                            {"id": "c", "text": "yaku"},
                            {"id": "d", "text": "simi"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },

            // ---- ORDER_WORDS (5)
            {
                "step_id": "SAL_ORDER_WORDS_01",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • ORDER_WORDS • 01",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena el saludo en Kichwa.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_ORDER_WORDS_01_EX",
                    "type": "ORDER_WORDS",
                    "title": "Saludos (Ordenar) 01",
                    "prompt": "Ordena:",
                    "payload": {
                        "correctOrder": ["Alli", "puncha"],
                        "items": ["puncha", "Alli"]
                    }
                }
            },
            {
                "step_id": "SAL_ORDER_WORDS_02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • ORDER_WORDS • 02",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena el saludo en Kichwa.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_ORDER_WORDS_02_EX",
                    "type": "ORDER_WORDS",
                    "title": "Saludos (Ordenar) 02",
                    "prompt": "Ordena:",
                    "payload": {
                        "correctOrder": ["Alli", "tuta"],
                        "items": ["tuta", "Alli"]
                    }
                }
            },
            {
                "step_id": "SAL_ORDER_WORDS_03",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • ORDER_WORDS • 03",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena el saludo en Kichwa.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_ORDER_WORDS_03_EX",
                    "type": "ORDER_WORDS",
                    "title": "Saludos (Ordenar) 03",
                    "prompt": "Ordena:",
                    "payload": {
                        "correctOrder": ["Napaykuna"],
                        "items": ["Napaykuna"]
                    }
                }
            },
            {
                "step_id": "SAL_ORDER_WORDS_04",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • ORDER_WORDS • 04",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena el saludo en Kichwa.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_ORDER_WORDS_04_EX",
                    "type": "ORDER_WORDS",
                    "title": "Saludos (Ordenar) 04",
                    "prompt": "Ordena:",
                    "payload": {
                        "correctOrder": ["Imanalla", "?"],
                        "items": ["?", "Imanalla"]
                    }
                }
            },
            {
                "step_id": "SAL_ORDER_WORDS_05",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "NAPAYKUN-SALUDOS • ORDER_WORDS • 05",
                "activity": "UYARINA - Escuchar",
                "description": "Ordena el saludo en Kichwa.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SAL_ORDER_WORDS_05_EX",
                    "type": "ORDER_WORDS",
                    "title": "Saludos (Ordenar) 05",
                    "prompt": "Ordena:",
                    "payload": {
                        "correctOrder": ["Allillachu"],
                        "items": ["Allillachu"]
                    }
                }
            },


            {
                "step_id": "SEC01",
                "unidad_seccion_id": 1,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "Riksirishun - Presentación",
                "activity": "UYARINA - Escuchar",
                "description": "👂 Uyarina - Escuchar: escucha 3 veces y reconoce frases de presentación.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SEC01_EX01",
                    "type": "ORDER_WORDS",
                    "title": "Riksirishun - Presentación",
                    "prompt": "Ordena la frase en Kichwa:",
                    "payload": {
                        "correctOrder": ["Ñuka", "shuti", "Killa", "kan."],
                        "items": ["kan.", "Killa", "Ñuka", "shuti"]
                    }
                }
            },
            {
                "step_id": "SEC02",
                "unidad_seccion_id": 2,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "Napaykuna - Saludos",
                "activity": "UYARINA - Escuchar",
                "description": "Empareja Kichwa con Español (arrastra).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SEC02_EX01",
                    "type": "DRAG_MATCH",
                    "title": "Napaykuna - Saludos",
                    "prompt": "Empareja Kichwa con Español (arrastra):",
                    "payload": {
                        "pairs": [
                            {"left": "Alli puncha", "right": "Buenos días"},
                            {"left": "Alli tuta", "right": "Buenas noches"},
                            {"left": "Yupay", "right": "Gracias"}
                        ]
                    }
                }
            },
            {
                "step_id": "SEC03",
                "unidad_seccion_id": 3,
                "unidad_id": 1,
                "configuracion_ui_ux_id": 1,
                "title": "Tapuykuna - Preguntas",
                "activity": "UYARINA - Escuchar",
                "description": "Selecciona la pregunta correcta.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SEC03_EX01",
                    "type": "HAYSTACK_PICK",
                    "title": "Tapuykuna - Preguntas",
                    "prompt": "Selecciona la pregunta correcta en Kichwa para “¿Dónde?”:",
                    "payload": {
                        "question": {"es": "¿Dónde?", "ki": "Maypi?"},
                        "haystack": ["Maypi?", "Alli puncha", "Yupay", "Wasi", "Maki", "Yaku", "Rumi", "Killa", "Inti", "Sacha"],
                        "correct": ["Maypi?"]
                    }
                }
            },
            {
                "step_id": "SEC04",
                "unidad_seccion_id": 4,
                "unidad_id": 2,
                "configuracion_ui_ux_id": 2,
                "title": "Mishkimurukuna - Frutas (con imagen)",
                "activity": "RIKSINA - Mirar",
                "description": "Selecciona las frutas mirando la imagen.",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SEC04_EX01",
                    "type": "MULTI_SELECT_IMAGE",
                    "title": "Frutas (imagen)",
                    "prompt": "Selecciona las frutas (2 correctas):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1547516508-918a2ad3a107?auto=format&fit=crop&w=1200&q=60",
                        "alt": "frutas",
                        "options": [
                            {"id": "a", "text": "apil"},
                            {"id": "b", "text": "palta"},
                            {"id": "c", "text": "wasi"},
                            {"id": "d", "text": "maki"}
                        ],
                        "correctIds": ["a", "b"]
                    }
                }
            },
            {
                "step_id": "SEC05",
                "unidad_seccion_id": 5,
                "unidad_id": 2,
                "configuracion_ui_ux_id": 2,
                "title": "Runapa Ukku (hotspots)",
                "activity": "RIKSINA - Mirar",
                "description": "Marca los puntos correctos en la imagen (Kichwa).",
                "status": "ACTIVE",
                "weight": 10,
                "source": "",
                "exercise": {
                    "exercise_id": "SEC05_EX01",
                    "type": "IMAGE_HOTSPOT_PICK",
                    "title": "Cuerpo humano",
                    "prompt": "Marca SOLO las partes correctas (Kichwa):",
                    "payload": {
                        "image": "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?auto=format&fit=crop&w=1200&q=60",
                        "mode": "MULTI",
                        "maxPick": 3,
                        "showLabels": true,
                        "hotspots": [
                            {"id": "maki", "xPct": 70, "yPct": 60, "label": "maki", "isCorrect": true},
                            {"id": "ñawi", "xPct": 52, "yPct": 20, "label": "ñawi", "isCorrect": true},
                            {"id": "simi", "xPct": 52, "yPct": 30, "label": "simi", "isCorrect": true},
                            {"id": "yaku", "xPct": 20, "yPct": 20, "label": "yaku", "isCorrect": false},
                            {"id": "rumi", "xPct": 80, "yPct": 85, "label": "rumi", "isCorrect": false}
                        ]
                    }
                }
            }
        ]
        const SAMPLE_JSON = {
            "meta": {
                "schema": "riksichishun.exercise_set.v1",
                "compatible_with": ["SortableJS@1.15.2", "jquery.serializeJSON@3.2.1"],
                "base_media_url": ""
            },
            "steps": []
        };

        // ---------------------------
        // Actions
        // ---------------------------
        function bootstrapFromJSON(data) {
            APP.data = data;
            loadProgress();

            // init step progress
            APP.data.steps.forEach(s => getStepProgress(s));

            APP.activeIndex = getGateIndex();

            updateTopChips();
            renderStepsList();
            setActiveStep(APP.activeIndex);
        }

        $("#mcBtnLoadSample").on("click", () => {
            $("#mcJsonInput").val(JSON.stringify(SAMPLE_JSON, null, 2));
        });

        $("#mcBtnParse").on("click", () => {
            const txt = $("#mcJsonInput").val().trim();
            const data = safeParseJSON(txt);

            if (!data || !Array.isArray(data.steps)) {
                $("#mcChipState").removeClass("mc-chip--info").addClass("mc-chip--bad").text("JSON inválido");
                $("#mcExerciseRoot").html(`<div class="mc-chip mc-chip--bad">JSON inválido: debe incluir steps[]</div>`);
                $("#mcStepsList").empty();
                APP.data = null;
                updateTopChips();
                return;
            }

            $("#mcChipState").removeClass("mc-chip--bad").addClass("mc-chip--info").text("JSON cargado");
            bootstrapFromJSON(data);
        });

        $("#mcBtnReset").on("click", () => {
            resetProgress();
            if (APP.data) {
                bootstrapFromJSON(APP.data);
            } else {
                $("#mcChipProgress").text("Progreso: 0%");
            }
        });

        $("#mcBtnExport").on("click", () => {
            const dump = {
                exported_at: nowISO(),
                session_id: SESSION_ID,
                storage_key: STORAGE_KEY,
                progress: APP.progress
            };
            const blob = new Blob([JSON.stringify(dump, null, 2)], {type: "application/json"});
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = `riksichishun_progress_${SESSION_ID}.json`;
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        });

        // Init UI (no data yet)
        updateTopChips();


    </script>
    <script>
        var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;
        var $resources = <?php echo json_encode($resources) ?>;
        var appThis = null;
        var appInit = new Vue(
            {

                mounted: function () {
                    this.initCurrentComponent();
                    appThis = this;
                    //this.initSVGManager();
                    $(function () {
                        $(render);
                    });
                },
                el: '#app-management',
                created: function () {

                },
                beforeMount: function () {
                    this.configParams = this.params;
                    var $scope = this;
                    $(window).resize(function () {
                        //     $scope.resizeSVG();
                    });

                },
                data: {
                    //MENU
                    levels: {
                        one: {
                            'title': 'Viento',
                            'subtitle': 'wayra',

                        },
                        two: {
                            'title': 'Agua',
                            'subtitle': 'yaku',

                        },
                        three: {
                            'title': 'Tierra',
                            'subtitle': 'allpa',

                        },
                        four: {
                            'title': 'Fuego',
                            'subtitle': 'nina',

                        },
                    },
                    managerHeader: {
                        data: null,
                        'selector': '#svg-full-width',
                        'manager-selector-container': '#section--full-img',
                        'source': $resources.header,

                    }

                },
                methods: {
                    initCurrentComponent: function () {

                    }, initManagement: function () {
                        console.log("init app");
                    },

                    initSVGManager: function () {

                        var elementCurrent = this.managerHeader.selector;
                        var selectorMain = Snap(elementCurrent);
                        var _this = this;
                        Snap.load(_this.managerHeader.source, function (f) {
                            selectorMain.append(f);
                        });
                    },
                    resizeSVG: function (params) {
                        adjustment();
                    }
                }
            })
        ;
        appInit.initManagement();

        function adjustment() {
            var contenedorAncho = document.getElementById("app-management").offsetWidth; // Obtener el ancho del contenedor
            var nuevoAncho = contenedorAncho * 0.96; // Reducir el ancho al 96% del ancho del contenedor
            var nuevoAlto = (nuevoAncho / 1840) * 750; // Calcular el nuevo alto manteniendo la proporción original

            // Asignar los nuevos valores de ancho y alto al elemento SVG
            document.getElementById("svg-full-width").setAttribute("width", nuevoAncho);
            document.getElementById("svg-full-width").setAttribute("height", nuevoAlto);
        }


    </script>
    <script id="modal">
        var modalEl;
        var configModal = {
            modalEl: null,
            modal: null,

        };

        function initModalEvents(params) {
            console.log("oini", params);
            modalEl = document.getElementById('dynamicModal')

            const modal = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });

            modalEl.addEventListener('show.bs.modal', (event) => {
                const content = modalEl.querySelector('.modal-content')

                content.innerHTML = `
    <div class="modal-header">
      <h5 class="modal-title">Modal dinámico</h5>
      <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
      <div id="dynamicBody">
        Cargando contenido…
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-secondary" data-bs-dismiss="modal">
        Cerrar
      </button>
    </div>
  `
            });

            modalEl.addEventListener('shown.bs.modal', () => {
                document.getElementById('dynamicBody').innerHTML = `
    <p>Contenido cargado por evento</p>
  `
            });
            modalEl.addEventListener('hidden.bs.modal', () => {
                modalEl.querySelector('.modal-content').innerHTML = ''
            });
            configModal.modalEl = modalEl;
            configModal.modal = modal;

        }

    </script>
    <script>
        $(function () {
            var widthManager = $('#app-management').width() - 80;
            var contenedorAncho = document.getElementById("app-management").offsetWidth; // Obtener el ancho del contenedor
            var nuevoAncho = contenedorAncho * 0.96; // Reducir el ancho al 96% del ancho del contenedor
            var nuevoAlto = (nuevoAncho / 1840) * 750; // Calcular el nuevo alto manteniendo la proporción original

            $('#svg-full-width').attr('width', widthManager);
            $('#svg-full-width').attr('height', nuevoAlto);


            $('.header-search').show();

            modalEl.querySelector('.modal-dialog')
                .classList.add('modal-fullscreen')
        });

        function openDynamicModal({
                                      id = "dynamicModal",
                                      fullscreen = true,
                                      options = {backdrop: "static", keyboard: false},
                                      template,
                                      onShow,
                                      onShown,
                                      onHide,
                                      onHidden,
                                      onHidePrevented
                                  } = {}) {
            const modalEl = document.getElementById(id);
            const dialogEl = modalEl.querySelector(".modal-dialog");
            const contentEl = modalEl.querySelector(".modal-content");

            dialogEl.className = "modal-dialog";
            if (fullscreen) dialogEl.classList.add("modal-fullscreen");

            // bind events (una sola vez por apertura)
            const once = (name, fn) => fn && modalEl.addEventListener(name, fn, {once: true});

            once("show.bs.modal", (ev) => {
                if (template) contentEl.innerHTML = template();
                onShow && onShow({modalEl, dialogEl, contentEl}, ev);
            });

            once("shown.bs.modal", (ev) => onShown && onShown({modalEl, dialogEl, contentEl}, ev));

            modalEl.addEventListener("hide.bs.modal", (ev) => {
                if (onHide) onHide({modalEl, dialogEl, contentEl}, ev);
            }, {once: true});

            once("hidden.bs.modal", (ev) => onHidden && onHidden({modalEl, dialogEl, contentEl}, ev));
            once("hidePrevented.bs.modal", (ev) => onHidePrevented && onHidePrevented({
                modalEl,
                dialogEl,
                contentEl
            }, ev));

            bootstrap.Modal.getOrCreateInstance(modalEl, options).show();
        }


    </script>
@endsection
@section('content')
    <div id="app-management">

        <div class="mc-elements" id="app"></div>

    </div>
@endsection
@section('data-modal')
    <div
        class="modal fade"
        id="dynamicModal"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- SE INYECTA TODO -->
            </div>
        </div>
    </div>
@endsection
