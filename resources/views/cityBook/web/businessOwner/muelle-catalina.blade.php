@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';

@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
    <style>
        /* Estado oculto de elementos marcados */
        .not-view {
            display: none !important;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
            background: #111;
            color: #eee;
        }

        #map {
            position: fixed;
            inset: 0;
        }

        .not-view {
            display: none !important;
        }

        .d-none {
            display: none !important;
        }

        :root {
            --bg: #0a0a0a;
            --fg: #f5f5f5;
            --muted: #b9bcc4;
            --primary: #2ecc71;
            --ring: rgba(255, 255, 255, 0.9);
            --dot: rgba(255, 255, 255, 0.95);
        }

        .controls {
            position: fixed;
            inset: 0;
            pointer-events: none;
        }

        .controls .container--custom {
            height: 100%;
            pointer-events: none;
        }

        #fallback {
            pointer-events: auto;
            padding: 8px;
        }

        #hint {
            display: none;
            position: fixed;
            left: 12px;
            bottom: 5%;
            background: rgba(0, 0, 0, .65);
            color: #fff;
            padding: 8px 12px;
            border-radius: 10px;
            z-index: 10001;
            font-size: 14px;
        }

        /* Retícula */
        /* Loading transparente (no bloquea interacción) */
        .loading {
            position: fixed;
            inset: 0;
            background: transparent;
            pointer-events: none;
            display: grid;
            place-items: center;
            z-index: 9998;
        }

        .loading__center {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.25);
            border-top-color: rgba(255, 255, 255, 0.9);
            animation: spin 1s linear infinite;
        }

        .loading__text {
            margin-top: 10px;
            text-align: center;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .loading__text strong {
            display: block;
            margin-bottom: 4px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .reticle {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 4;
            pointer-events: auto;
        }

        .reticle.hidden {
            display: none;
        }

        .reticle__ring {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 4px solid var(--ring);
            box-shadow: 0 0 16px rgba(255, 255, 255, 0.35);
        }

        span.badge.bg-secondary.popup-card__subcategory {
            background-color: #445EF2 !important;
        }

        .reticle__dot {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--dot);
        }

        .reticle__hint {
            position: absolute;
            top: calc(50% + 110px);
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: var(--muted);
            background: rgba(0, 0, 0, 0.5);
            padding: 6px 8px;
            border-radius: 6px;
            backdrop-filter: blur(6px);
        }

        /* Botón volver */
        #btn-back-map {
            position: fixed;
            top: 12px;
            left: 12px;
            z-index: 10001;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            background: #222;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
        }

        #btn-back-map:hover {
            background: #2c2c2c;
        }

        /* Popup BEM */
        .popup-card {
            width: 280px;
            font-size: 14px;
            color: #222;
        }

        .popup-card__header {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .popup-card__img {
            width: 90px;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }

        .popup-card__titles {
            display: flex;
            flex-direction: column;
        }

        .popup-card__title {
            margin: 0;
            font-size: 16px;
        }

        .popup-card__subtitle {
            margin: 2px 0 0;
            font-size: 12px;
            color: #666;
        }

        .popup-card__body {
            margin-top: 8px;
            color: #333;
        }

        .popup-card__description {
            margin: 0;
        }

        .popup-card__footer {
            margin-top: 10px;
            display: flex;
            gap: 8px;
        }

        .popup-card__btn {
            padding: 8px 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .popup-card__btn--primary {
            background: #4c4cff;
            color: #fff;
        }

        .popup-card__btn--ghost {
            background: #f1f1f1;
            color: #333;
        }

        /* model-viewer */
        model-viewer {
            width: 100%;
            height: 70vh;
            background: #000;
            border-radius: 12px;
        }

        /* loader */
        .spinner-border {
            width: 4rem;
            height: 4rem;
            border: .35rem solid rgba(255, 255, 255, .25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #btn-capture {
            position: fixed;
            right: 12px;
            z-index: 10001;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            color: #000;
            cursor: pointer;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0%);
            font-weight: 600;
        }

        #btn-capture:hover {
            filter: brightness(0.95);
        }

        :root {
            --bg: #0a0a0a;
            --fg: #f5f5f5;
            --muted: #b9bcc4;
            --ring: rgba(255, 255, 255, 0.9);
            --dot: rgba(255, 255, 255, 0.95);
            --btn: #222;
            --btn-h: #2c2c2c;
            --accent: #2f8;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--bg);
            color: var(--fg);
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Helvetica Neue, Arial;
        }

        .hint {
            position: fixed;
            left: 12px;
            bottom: 12px;
            background: rgba(0, 0, 0, .65);
            color: #fff;
            padding: 8px 12px;
            border-radius: 10px;
            z-index: 10001;
            font-size: 14px;
        }

        .btn {
            position: fixed;
            z-index: 10001;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
        }

        #btn-back-map {
            top: 12px;
            left: 12px;
            background: var(--btn);
            color: #fff;
        }

        #btn-back-map:hover {
            background: var(--btn-h);
        }

        #btn-capture {
            font-size: 45px;
            bottom: 10%;
            right: 43%;
            color: #000;
        }

        #btn-capture:hover {
            filter: brightness(.95);
        }

        .map {
            position: fixed;
            inset: 0;
        }

        .not-view {
            display: none !important;
        }

        .d-none {
            display: none !important;
        }

        .container--custom {
            position: relative;
            z-index: 2;
        }

        /* Loading transparente */
        .loading {
            position: fixed;
            inset: 0;
            background: transparent;
            pointer-events: none;
            display: grid;
            place-items: center;
            z-index: 9998;
        }

        .loading__center {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .spinner {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, .25);
            border-top-color: rgba(255, 255, 255, .9);
            animation: spin 1s linear infinite;
        }

        .loading__text {
            margin-top: 10px;
            text-align: center;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .5);
        }

        .loading__text strong {
            display: block;
            margin-bottom: 4px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Retícula */
        .reticle {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            z-index: 4;
            pointer-events: auto;
        }

        .reticle.hidden {
            display: none;
        }

        .reticle__ring {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 4px solid var(--ring);
            box-shadow: 0 0 16px rgba(255, 255, 255, .35);
        }

        .reticle__dot {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--dot);
        }

        .reticle__hint {
            position: absolute;
            top: calc(50% + 110px);
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            color: var(--muted);
            background: rgba(0, 0, 0, .5);
            padding: 6px 8px;
            border-radius: 6px;
            backdrop-filter: blur(6px);
        }

        /* Popup (Leaflet) */
        .leaflet-container a {
            color: #1da1f2;
        }

        .popup-card {
            color: #111;
            font-family: inherit;
            width: 280px;
        }

        .popup-card__header {
            display: flex;
            gap: 10px;
            align-items: center;
        }


        .popup-card__title {
            margin: 0;
            font-size: 16px;
            color: #111;
        }

        .popup-card__subtitle {
            margin: 0;
            font-size: 12px;
            color: #444;
        }

        .popup-card__body {
            margin-top: 8px;
            color: #333;
        }

        .popup-card__footer {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .popup-card__btn {
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid #445EF2;
            background: #fff;
            cursor: pointer;
            text-decoration: none;
            color: #111;
        }

        .popup-card__btn--primary {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .popup-card__btn--ghost {
            background: #fff;
        }

        /* model-viewer */
        model-viewer {
            width: 100%;
            height: 70vh;
            background: #000;
            border-radius: 12px;
        }

        /* Oculto por defecto */
        .d-none {
            display: none;
        }

        /* Vista mini flotante opcional (quita d-none para previsualizar) */
        .snap-canvas {
            position: fixed;
            right: 12px;
            bottom: 12px;
            width: 240px; /* tamaño de vista previa; la resolución real la pone JS */
            height: 135px; /* relación 16:9; ajusta a gusto */
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 8px;
            background: transparent;
            z-index: 3; /* encima del mapa y debajo de UI si quieres */
            box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
        }


        #map {
            position: absolute;
            inset: 0;
        }

        /* Panel flotante */
        .company-panel {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 340px;
            max-height: 80vh;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            font-family: system-ui, sans-serif;
            z-index: 1000;
        }

        .company-panel__header {
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 12px 12px 8px;
            border-bottom: 1px solid #eee;
            gap: 8px;
        }

        .company-panel__logo img {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            object-fit: cover;
        }

        .company-panel__title h2 {
            color: #445EF2 !important;
            font-size: 16px;
            margin: 0;
        }

        .company-panel__title span {
            font-size: 12px;
            color: #ffc700;
        }

        .company-panel__toggle {
            margin-left: auto;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 18px;
            transform: rotate(0deg);
            transition: transform 0.2s;
        }

        .company-panel--collapsed .company-panel__toggle {
            transform: rotate(180deg);
        }

        .company-panel__body {
            padding: 10px 14px 14px;
            overflow-y: auto;
        }

        .company-panel__section {
            margin-bottom: 12px;
        }

        .company-panel__section h3 {
            font-size: 13px;
            margin: 0 0 4px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #555;
        }

        .company-panel__section p {
            font-size: 13px;
            margin: 0 0 4px;
            color: #333;
        }

        .link-button {
            font-size: 12px;
            border: none;
            background: none;
            color: #4c4cff; /* azulClic */
            cursor: pointer;
            padding: 0;
        }

        .primary-button {
            width: 100%;
            padding: 8px 10px;
            border-radius: 999px;
            background: #4c4cff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .contact-list a {
            display: inline-block;
            margin-right: 6px;
            margin-bottom: 4px;
            font-size: 12px;
            text-decoration: none;
            color: #4c4cff;
        }

        .social-icons a {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 999px;
            border: 1px solid #ddd;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            margin-bottom: 6px;
        }

        .stat {
            background: #f5f5ff;
            border-radius: 10px;
            padding: 4px 6px;
            text-align: center;
        }

        .stat__label {
            display: block;
            font-size: 10px;
            color: #555;
        }

        .stat__value {
            font-size: 14px;
            font-weight: 600;
            color: #ffc700;
        }

        .totems-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
            font-size: 12px;
        }

        .totems-list li {
            margin-bottom: 3px;
        }

        /* Responsivo móvil: panel como bottom sheet */
        @media (max-width: 768px) {
            .company-panel {
                right: 0;
                left: 0;
                top: auto;
                bottom: 0;
                transform: none;
                width: auto;
                max-height: 45vh;
                border-radius: 16px 16px 0 0;
            }
        }

        .color-primary--title {
            color: #445EF2 !important;
        }

        .color-secondary--title {
            color: #ffc700 !important;
        }

        div#companyDescription {
            color: #929290;
        }

        .btn-view-data-cam {
            bottom: 45% !important;
        }


    </style>
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    />

@endsection

@section('additional-scripts')
    <script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

    <script>
        /* ============================================================================
    * Datos de ejemplo: itemsSources
    * ========================================================================== */

        let itemsSources = [
            {
                id: "taita",
                title: "Taita Imbabura – Abuelo que despierta las montañas",
                subtitle: "Ñawi Hatun Yaya – Yaku Kawsay Tukuy Kuna",
                description: "Padre volcán de Imbabura, sabio y vigilante. Desde sus laderas nacen vientos, manantiales y semillas que dan vida a la provincia. Sus aguas bajan hacia la laguna y alimentan chacras y comunidades. Taita Imbabura es guía y protector, un anciano vivo que recuerda a la gente su relación con la tierra y el agua.",
                position: {lat: 0.20477, lng: -78.20639},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/taita-imbabura.png'
                }
            },
            {
                id: "cerro-cusin",
                title: "Cerro Cusin – Guardián del paso fértil",
                subtitle: "Allpa Ñanpi Rikchar – Chacra Kamak",
                description: "Cusin es el cerro que cuida los caminos que unen comunidades. La neblina que lo envuelve baja hacia Yaku Mama, manteniendo húmeda y fértil la tierra. Protege a quienes caminan, trabajan y siembran, recordando que cada sendero y cada chacra dependen del agua y del respeto a la montaña.",
                position: {lat: 0.20435, lng: -78.20688},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/cusin.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcusin.png'
                }
            },
            {
                id: "mojanda",
                title: "Mojanda – Susurro del páramo y las lagunas",
                subtitle: "Sachayaku Mama – Uksha Yaku Tiyana",
                description: "En Mojanda el páramo respira y de él nacen lagunas frías y puras. Sus aguas limpian el espíritu y alimentan ríos que descienden hacia los valles. Es un apu que conversa con las nubes y trae la lluvia necesaria para la vida. Mojanda recuerda que la vida empieza donde nace el agua.",
                position: {lat: 0.20401, lng: -78.20723},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/mojanda.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/mojanda.png'
                }
            },
            {
                id: "mama-cotacachi",
                title: "Mama Cotacachi – Madre que abraza la Pachamama",
                subtitle: "Allpa Mama – Warmi Rasu",
                description: "Volcán madre que protege a las familias, a las semillas y a los tejidos de la vida diaria. Junto a Taita Imbabura equilibra los ciclos de clima, lluvia y fertilidad. Sus nubes y aguas sostienen a las comunidades. Mama Cotacachi representa cuidado, refugio y amor que sostiene la vida.",
                position: {lat: 0.20369, lng: -78.20759},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/mama-cotacachi.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/warmi-razu.png'
                }
            },
            {
                id: "coraza",
                title: "El Coraza – Espíritu de celebración y memoria",
                subtitle: "Kawsay Taki – Yuyay Ayllu",
                description: "El Coraza es el espíritu del danzante que une a la gente con los apus y las aguas. Su baile honra a Taita Imbabura, a Mama Cotacachi y a Yaku Mama. A través de la fiesta se agradece a la tierra y a los ancestros. Mantiene viva la memoria del pueblo y la fuerza de su identidad.",
                position: {lat: 0.20349, lng: -78.20779},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/coraza-one.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/elcoraza.png'
                }
            },
            {
                id: "lechero",
                title: "El Lechero – Árbol del encuentro y los deseos",
                subtitle: "Kawsay Ranti – Yaku Rikuna Sacha",
                description: "Árbol sagrado donde las personas dejan promesas, agradecimientos y recuerdos. Desde su altura contempla a los apus y a la laguna. Es un puente entre el corazón humano y la naturaleza. El Lechero recibe los deseos y los entrega al viento, conectándolos con el gran tejido de la vida.",
                position: {lat: 0.20316, lng: -78.20790},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lechero.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/lechero.png'
                }
            },
            {
                id: "lago-san-pablo",
                title: "Yaku Mama – La laguna viva de Imbabura",
                subtitle: "Yaku Mama – Kawsaycocha",
                description: "Laguna madre que recibe las aguas de Imbabura, Cusin, Mojanda y Cotacachi. Refleja a los apus y al cielo, y devuelve alimento, pesca y calma a las comunidades. Yaku Mama es un ser vivo que siente y escucha; su existencia recuerda que sin agua no hay vida ni memoria.",
                position: {lat: 0.20284, lng: -78.20802},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/lago-san-pablo.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/yaku-mama.png'
                }
            },
            {
                id: "ayahuma-pacha",
                title: "Ayahuma – Espíritu que escucha la tierra",
                subtitle: "Aya Huma – Yuyay Uma",
                description: "Espíritu que representa conciencia, equilibrio y claridad. Ayahuma ayuda a escuchar la voz profunda de la tierra y a entender que cada decisión humana tiene efecto en la Pachamama. Acompaña los procesos de cambio y protege la conexión entre los apus, el agua y las comunidades.",
                position: {lat: 0.20184, lng: -78.20902},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/ayahuma.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/images/ayahuma.jpeg'
                }
            },
            {
                id: "corazon-pacha",
                title: "Corazón Pacha – Nodo de energía y vida",
                subtitle: "Pacha Sonkoy – Kawsay Tinkuy",
                description: "Lugar simbólico donde se encuentran los caminos del agua, la montaña y el ser humano. Es el centro energético de la zona, un punto donde todo late al mismo tiempo. Corazón Pacha recuerda que los apus, la laguna y la gente forman una sola familia dentro de la tierra viva.",
                position: {lat: 0.20084, lng: -78.21002},
                sources: {
                    glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/corazon.glb',
                    img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/pacha/images/corazon.jpeg'
                }
            }
        ];
        var $dataManager = <?php echo json_encode($dataManager) ?>;
    </script>
    <script>

        function initWhatsapp() {

            if ($dataManager.business && $dataManager.business.dataPhoneWhatsapp && $dataManager.business.dataPhoneWhatsapp.urlWhatsapp != '') {
                var urlWhatsapp = getUrlWhatsApp()+$dataManager.business.dataPhoneWhatsapp.urlWhatsapp;
                console.log(urlWhatsapp);
                $("#companyWhatsapp").attr("href",urlWhatsapp);
            }
        }



        function hasUploadsPath(url) {
            let result = url.indexOf("/uploads/") !== -1;

            return result;
        }

        function pathTieneArchivo(path) {
            // Quita posibles "/" del final
            path = path.replace(/\/+$/, '');

            const partes = path.split('/');
            const ultimo = partes[partes.length - 1];

            // Si el último fragmento tiene un punto, asumimos que es archivo
            return ultimo.includes('.');
        }

        var $itemsOtherDraw = [];
        if ($dataManager.allow) {
            let dataItemsMap =
                getStructureRouteMap({
                    map: "",
                    haystack: $dataManager.dataRoute.routes_drawing_data,
                    typeGetData: true
                });
            let haystack = dataItemsMap.layers;
            let itemsSourcesAux = [];
            var defaultMarker = "/wulpy/developers/assets/images/markers/excursiones.png";
            $.each(haystack, function (key, value) {
                let isMarker = false;
                let setPush = {
                    id: value.id,
                    title: value.title,
                    subtitle: value.subtitle,
                    description: value.content,
                    position: null,
                    sources: null,
                    routes_map_id: value.routes_map_id,
                    totem_category_code: value.totem_category_code,
                    totem_category_id: value.totem_category_id,
                    totem_category_name: value.totem_category_name,
                    totem_subcategory_code: value.totem_subcategory_code,
                    totem_subcategory_id: value.totem_subcategory_id,
                    totem_subcategory_name: value.totem_subcategory_name,
                    totem_subcategory_real_id: value.totem_subcategory_real_id,
                };
                if (value.type == "marker") {
                    var srcCurrent = "";
                    let sources = {glb: null, img: null};
                    if (typeof value.dataSource.src_glb !== 'undefined') {
                        srcCurrent = value["dataSource"].src_glb;
                        let isManagerSystem = hasUploadsPath(srcCurrent);
                        if (isManagerSystem) {
                            let existData = pathTieneArchivo(srcCurrent);
                            if (!existData) {
                                srcCurrent = defaultMarker;
                            }
                            srcCurrent = window.$dataManagerPage?.['public-root'] + srcCurrent;
                        }
                        sources.glb = srcCurrent;
                    }
                    srcCurrent = value["dataSource"].src;
                    let isManagerSystem = hasUploadsPath(srcCurrent);
                    if (isManagerSystem) {
                        let existData = pathTieneArchivo(srcCurrent);
                        if (!existData) {
                            srcCurrent = defaultMarker;
                        }
                        srcCurrent = window.$dataManagerPage?.['public-root'] + srcCurrent;
                    }
                    sources.img = srcCurrent;
                    setPush.sources = sources;
                    setPush.position = value.position;

                    itemsSourcesAux.push(setPush);


                } else {

                    $itemsOtherDraw.push(value);
                }

            });
            console.log("DOMContentLoaded (jQuery ready)");
            if (itemsSourcesAux.length > 0) {
                itemsSources = [];
                itemsSources = itemsSourcesAux;

            }
        }

        function addRoutesDrawingToMap(map, drawings) {
            if (!Array.isArray(drawings)) {
                console.warn('drawings no es un array');
                return;
            }

            drawings.forEach(function (item) {
                var type = item.type; // "rectangle", "polygon", "polyline", etc.
                var layer = null;

                // Opciones comunes de estilo
                var strokeColor = item.strokeColor || '#000000';
                var strokeWeight = item.strokeWeight || 2;
                var strokeOpacity = (typeof item.strokeOpacity !== 'undefined') ? item.strokeOpacity : 1;
                var fillColor = item.fillColor || strokeColor;
                var fillOpacity = (typeof item.fillOpacity !== 'undefined') ? item.fillOpacity : 0.2;

                var baseOptions = {
                    color: strokeColor,
                    weight: strokeWeight,
                    opacity: strokeOpacity
                };

                // RECTÁNGULO
                if (type === 'rectangle' && item.bounds) {
                    var b = item.bounds;
                    // Leaflet espera [ [southLat, westLng], [northLat, eastLng] ]
                    var southWest = L.latLng(b.south, b.west);
                    var northEast = L.latLng(b.north, b.east);
                    var bounds = L.latLngBounds(southWest, northEast);

                    layer = L.rectangle(bounds, Object.assign({}, baseOptions, {
                        fillColor: fillColor,
                        fillOpacity: fillOpacity
                    }));
                }

                // POLÍGONO
                else if (type === 'polygon' && Array.isArray(item.paths)) {
                    var latLngsPolygon = item.paths.map(function (p) {
                        return L.latLng(parseFloat(p.lat), parseFloat(p.lng));
                    });

                    layer = L.polygon(latLngsPolygon, Object.assign({}, baseOptions, {
                        fillColor: fillColor,
                        fillOpacity: fillOpacity
                    }));
                }

                // POLILÍNEA
                else if (type === 'polyline' && Array.isArray(item.path)) {
                    var latLngsLine = item.path.map(function (p) {
                        return L.latLng(parseFloat(p.lat), parseFloat(p.lng));
                    });

                    layer = L.polyline(latLngsLine, baseOptions);
                }

                // Si no se reconoció el tipo o faltan datos, salimos
                if (!layer) {
                    console.warn('No se pudo crear layer para item id:', item.id, 'type:', type);
                    return;
                }

                // 👉 Opcional: guardar meta-datos dentro del layer
                layer._totemMeta = {
                    id: item.id,
                    rd_id: item.rd_id,
                    routes_drawing_id: item.routes_drawing_id,
                    routes_map_id: item.routes_map_id,
                    totem_category_code: item.totem_category_code,
                    totem_category_id: item.totem_category_id,
                    totem_category_name: item.totem_category_name,
                    totem_subcategory_code: item.totem_subcategory_code,
                    totem_subcategory_id: item.totem_subcategory_id,
                    totem_subcategory_name: item.totem_subcategory_name,
                    title: item.title,
                    subtitle: item.subtitle,
                    content: item.content
                };
                // 👉 Agregar al mapa
                layer.addTo(map);
            });
        }

        function getStructureRouteMap(params) {
            var latLngData = [];
            var dataLayers = [];
            var mapCurrentRoutes = params['map'];
            var optionsCenter = [];
            var haystack = params.haystack;
            var routeInformation = params.routeInformation;
            var typeGetData = params.typeGetData;//true=db,false=kml
            if (typeGetData) {//DB

                $.each(haystack, function (key, value) {
                    var typeLayer = value["rd_type"];
                    var id = value["id"];
                    var rd_name = value["rd_name"] ? value["rd_name"] : "";
                    var rd_description = value["rd_description"] ? value["rd_description"] : "";
                    var rd_id = value["rd_id"];
                    var routes_drawing_id = value["routes_drawing_id"];
                    var rd_subtitle = value["rd_subtitle"];
                    var routes_map_id = value["routes_map_id"];
                    var totem_category_code = value["totem_category_code"];

                    var totem_category_id = value["totem_category_id"];
                    var totem_category_name = value["totem_category_name"];
                    var totem_subcategory_code = value["totem_subcategory_code"];
                    var totem_subcategory_id = value["totem_subcategory_id"];
                    var totem_subcategory_name = value["totem_subcategory_name"];
                    var totem_subcategory_real_id = value["totem_subcategory_real_id"];

                    var setPush = null;
                    var options = jQuery.parseJSON(value["rd_options_type"]);
                    options = mergeObjects(options, {
                        title: rd_name,
                        type: typeLayer,
                        content: rd_description,
                        id: id,
                        rd_id: rd_id,
                        routes_drawing_id: routes_drawing_id,
                        subtitle: rd_subtitle,
                        routes_map_id: routes_map_id,
                        totem_category_code: totem_category_code,
                        totem_category_id: totem_category_id,
                        totem_category_name: totem_category_name,
                        totem_subcategory_code: totem_subcategory_code,
                        totem_subcategory_id: totem_subcategory_id,
                        totem_subcategory_name: totem_subcategory_name,
                        totem_subcategory_real_id: totem_subcategory_real_id,

                    });

                    var path = [];
                    switch (typeLayer) {
                        case "marker":
                            var data = value.hasOwnProperty('data') ? value["data"] : [];
                            path = options.position;
                            options['data'] = data;
                            options['dataSource'] = {};
                            if (value.rd_src == null) {
                                options['dataSource']["src"] = "https://meetclic.com/public/wulpy/developers/assets/images/markers/artesanias.png";
                            } else {
                                options['dataSource']["src"] = value.rd_src;
                            }
                            if (value.rd_src_glb == null) {
                            } else {
                                options['dataSource']["src_glb"] = value.rd_src_glb;
                            }
                            setPush = getConfigMarker({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;
                        case "polygon":
                            path = options.paths[0];//[]
                            options.paths = path;
                            setPush = getConfigPolygon({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;

                        case "polyline":
                            path = options.path;//[]
                            options.path = path;
                            setPush = getConfigPolyline({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;
                        case "rectangle":
                            path = options.bounds;//4 points ne,sw
                            setPush = getConfigRectangle({
                                options: options,
                                map: mapCurrentRoutes
                            });

                            break;
                        case "circle":
                            path = options.center;//lat-lng
                            setPush = getConfigCircle({
                                options: options,
                                map: mapCurrentRoutes
                            });
                            break;

                    }

                    if (setPush) {
//step 1
                        latLngData.push({
                            type: typeLayer,
                            haystack: path
                        });
                        dataLayers.push(setPush);

                        var setPushCenter = getCenterByType({
                            obj: setPush,
                            type: typeLayer,
                            path: path
                        });
                        optionsCenter.push(setPushCenter);
                    }
                });
            } else {
                $.each(haystack, function (key, layer) {
                    var setPush = null;
                    var path = [];
                    var typeLayer = layer.type;
                    console.log('KML READ', typeLayer);
                    if (typeLayer == "marker") {
                        setPush = getConfigMarker({
                            options: layer,
                            map: mapCurrentRoutes
                        });
                        path = layer.position;


                    } else if (typeLayer == "polyline") {
                        setPush = getConfigPolyline({
                            options: layer,
                            map: mapCurrentRoutes
                        });
                        path = layer.path;

                    }
                    if (setPush) {
//step 1
                        latLngData.push({
                            type: typeLayer,
                            haystack: path
                        });
                        dataLayers.push(setPush);

                        var setPushCenter = getCenterByType({
                            obj: setPush,
                            type: layer.type,
                            path: path
                        });
                        optionsCenter.push(setPushCenter);

                    }
                });
            }
            var result = {layers: dataLayers, latLngData: latLngData, optionsCenter: optionsCenter};
            return result;


        }
    </script>


    <script src="https://unpkg.com/three@0.147.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.147.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://unpkg.com/three@0.147.0/examples/js/loaders/GLTFLoader.js"></script>
    <!-- Fallback: model-viewer (para iOS/Safari o navegadores sin WebXR) -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>
    <script src="https://unpkg.com/html2canvas@1.4.1/dist/html2canvas.min.js" crossorigin="anonymous"></script>
    <script>
        /* ============================================================================
 * CameraOverlayComposer: captura frames de cámara + canvas3D opcional
 * ========================================================================== */
        class CameraOverlayComposer {
            constructor() {
                this.video = null;
                this.stream = null;
                this.canvas3D = null;
                this.composite = null;
                this.ctx = null;
                this._raf = 0;
                this._running = false;
                this._include3D = false;
            }

            async start({
                            canvas3D = null,
                            facingMode = 'environment',
                            width = 1280,
                            height = 720,
                            includeCanvas3D = false
                        } = {}) {
                if (this._running) return;
                this.canvas3D = canvas3D || null;
                this._include3D = !!includeCanvas3D;

                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: {facingMode, width, height},
                    audio: false
                });

                this.video = document.createElement('video');
                this.video.playsInline = true;
                this.video.muted = true;
                this.video.autoplay = true;
                this.video.srcObject = this.stream;

                Object.assign(this.video.style, {
                    position: 'fixed',
                    width: '1px',
                    height: '1px',
                    opacity: '0',
                    pointerEvents: 'none',
                    zIndex: '-1',
                    left: '0',
                    top: '0'
                });
                document.body.appendChild(this.video);

                await new Promise((res, rej) => {
                    const onMeta = () => {
                        cleanup();
                        res();
                    };
                    const onErr = (e) => {
                        cleanup();
                        rej(e);
                    };
                    const cleanup = () => {
                        this.video.removeEventListener('loadedmetadata', onMeta);
                        this.video.removeEventListener('error', onErr);
                    };
                    this.video.addEventListener('loadedmetadata', onMeta, {once: true});
                    this.video.addEventListener('error', onErr, {once: true});
                });

                try {
                    await this.video.play();
                } catch {
                }

                await new Promise((res) => {
                    if (this.video.videoWidth > 0 && this.video.videoHeight > 0) return res();
                    const onPlaying = () => {
                        cleanup();
                        res();
                    };
                    const onLoadedData = () => {
                        if (this.video.videoWidth > 0 && this.video.videoHeight > 0) {
                            cleanup();
                            res();
                        }
                    };
                    const cleanup = () => {
                        this.video.removeEventListener('playing', onPlaying);
                        this.video.removeEventListener('loadeddata', onLoadedData);
                    };
                    this.video.addEventListener('playing', onPlaying, {once: true});
                    this.video.addEventListener('loadeddata', onLoadedData);
                    setTimeout(() => {
                        cleanup();
                        res();
                    }, 500);
                });

                this.composite = document.createElement('canvas');
                this._resizeToVideo();
                this.ctx = this.composite.getContext('2d');
                this.composite.style.display = 'none';
                document.body.appendChild(this.composite);

                this._running = true;
                const tick = () => {
                    if (!this._running) return;

                    if (this.composite.width !== this.video.videoWidth ||
                        this.composite.height !== this.video.videoHeight) {
                        this._resizeToVideo();
                    }

                    this.ctx.drawImage(this.video, 0, 0, this.composite.width, this.composite.height);

                    if (this._include3D && this.canvas3D && this.canvas3D.width && this.canvas3D.height) {
                        this.ctx.drawImage(this.canvas3D, 0, 0, this.composite.width, this.composite.height);
                    }

                    this._raf = requestAnimationFrame(tick);
                };
                this._raf = requestAnimationFrame(tick);
            }

            _resizeToVideo() {
                const w = Math.max(1, this.video.videoWidth || 1280);
                const h = Math.max(1, this.video.videoHeight || 720);
                this.composite.width = w;
                this.composite.height = h;
            }

            async snapshotToBlob({type = 'image/jpeg', quality = 0.95} = {}) {
                if (!this.composite) return null;

                if (!this.video || this.video.videoWidth === 0 || this.video.videoHeight === 0) {
                    await new Promise(r => requestAnimationFrame(r));
                    await new Promise(r => requestAnimationFrame(r));
                    if (!this.video || this.video.videoWidth === 0 || this.video.videoHeight === 0) {
                        console.warn('[CameraOverlayComposer] video sin medidas aún');
                        return null;
                    }
                    this._resizeToVideo();
                }

                await new Promise(r => requestAnimationFrame(r));

                return await new Promise(res => this.composite.toBlob(res, type, quality));
            }

            async stop() {
                this._running = false;
                cancelAnimationFrame(this._raf);
                this._raf = 0;

                try {
                    this.stream?.getTracks()?.forEach(t => t.stop());
                } catch {
                }
                this.stream = null;

                if (this.video?.parentNode) this.video.parentNode.removeChild(this.video);
                if (this.composite?.parentNode) this.composite.parentNode.removeChild(this.composite);

                this.video = null;
                this.composite = null;
                this.ctx = null;
                this.canvas3D = null;
                this._include3D = false;
            }
        }

        /* ============================================================================
         * Plataforma + capacidades
         * ========================================================================== */
        const Platform = (function () {
            const ua = navigator.userAgent || navigator.vendor || "";
            const isAndroid = /Android/i.test(ua);
            const isIOS = /iPhone|iPad|iPod/i.test(ua) || (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
            const isSecure = location.protocol === "https:" || location.hostname === "localhost";
            return {isAndroid, isIOS, isSecure};
        })();

        async function canUseAR() {
            if (!Platform.isAndroid || !Platform.isSecure || !('xr' in navigator)) return false;
            try {
                return await navigator.xr.isSessionSupported('immersive-ar');
            } catch {
                return false;
            }
        }

        /* ============================================================================
         * UI Manager (jQuery-friendly)
         * ========================================================================== */
        const UI = (function () {
            let $refs = {};
            const pctText = p => (Math.max(0, Math.min(1, p || 0)) * 100).toFixed(0) + '%';

            function bind() {
                $refs.loading = document.getElementById('ar-loading');
                $refs.loadingPct = document.getElementById('ar-loading-percent');
                $refs.loadingLbl = document.getElementById('ar-loading-label');
                $refs.fallback = document.getElementById('fallback');
                $refs.mv = document.getElementById('mv');
                $refs.hint = document.getElementById('hint');
                $refs.container = document.querySelector('.container--custom');
                $refs.reticle = document.getElementById('reticle-overlay');
                $refs.retHint = $refs.reticle?.querySelector('.reticle__hint');
                $refs.map = document.getElementById('map');
                $refs.back = document.getElementById('btn-back-map');
                $refs.capture = document.getElementById('btn-capture');
            }

            const show = el => el && el.classList.remove('d-none');
            const hide = el => el && el.classList.add('d-none');

            return {
                bind,
                setHint(m) {
                    if ($refs.hint) $refs.hint.textContent = m || '';
                },
                setReticleText(m) {
                    if ($refs.retHint) $refs.retHint.textContent = m || '';
                },

                showLoading(label = 'Cargando:') {
                    if ($refs.loadingLbl) $refs.loadingLbl.textContent = label;
                    if ($refs.loadingPct) $refs.loadingPct.textContent = '0%';
                    show($refs.loading);
                },
                hideLoading() {
                    hide($refs.loading);
                },
                resetLoadingProgress(label = 'Cargando:') {
                    if ($refs.loadingLbl) $refs.loadingLbl.textContent = label;
                    if ($refs.loadingPct) $refs.loadingPct.textContent = '0%';
                },
                updateLoadingProgress(p) {
                    const t = pctText(p);
                    if ($refs.loadingPct) $refs.loadingPct.textContent = t;
                    if ($refs.loadingLbl) $refs.loadingLbl.textContent = `Cargando modelo:`;
                },
                finishLoadingProgress() {
                    if ($refs.loadingPct) $refs.loadingPct.textContent = '100%';
                    if ($refs.loadingLbl) $refs.loadingLbl.textContent = 'Modelo cargado.';
                },

                showFallback() {
                    show($refs.fallback);
                },
                hideFallback() {
                    hide($refs.fallback);
                },

                revealContainer() {
                    $refs.container?.classList.remove('not-view');
                },
                showReticle() {
                    $refs.reticle?.classList.remove('hidden');
                },
                hideReticle() {
                    $refs.reticle?.classList.add('hidden');
                },

                hideMap() {
                    $refs.map?.classList.add('not-view');
                    $refs.back?.classList.remove('d-none');
                },
                showMap() {
                    $refs.map?.classList.remove('not-view');
                    $refs.back?.classList.add('d-none');
                },

                showCapture() {
                    $refs.capture?.classList.remove('d-none');
                },
                hideCapture() {
                    $refs.capture?.classList.add('d-none');
                },

                get mv() {
                    return $refs.mv;
                },
                get $fallback() {
                    return $refs.fallback;
                },
                get $reticle() {
                    return $refs.reticle;
                },
                get $back() {
                    return $refs.back;
                },
                get $capture() {
                    return $refs.capture;
                }
            };
        })();

        /* ============================================================================
         * Utilidades
         * ========================================================================== */
        const DownloadUtils = {
            saveBlob(filename, blob) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            }
        };

        const StatsUtils = {
            compute(root) {
                if (!root) return null;
                const box = new THREE.Box3().setFromObject(root);
                const size = new THREE.Vector3();
                box.getSize(size);
                let meshes = 0, tris = 0;
                root.traverse(o => {
                    if (o.isMesh && o.geometry) {
                        meshes++;
                        const g = o.geometry;
                        const t = g.index ? (g.index.count / 3) :
                            (g.attributes?.position ? g.attributes.position.count / 3 : 0);
                        tris += Math.floor(t);
                    }
                });
                return {
                    meshes,
                    triangles: tris,
                    bbox: {x: +size.x.toFixed(4), y: +size.y.toFixed(4), z: +size.z.toFixed(4)}
                };
            }
        };

        /* ============================================================================
         * ModelViewerController (fallback <model-viewer>)
         * ========================================================================== */
        class ModelViewerController {
            constructor(mvEl, hooks = {}) {
                this.mv = mvEl;
                this.hooks = hooks;
                this._bound = false;

            }

            bindOnce() {
                if (this._bound || !this.mv) return;
                this._bound = true;

                this._onARStatus = ev => {
                    const st = ev?.detail?.status;
                    if (st === 'session-started') this.hooks.onEnter && this.hooks.onEnter({mode: 'ios/web-ar'});
                    if (st === 'not-presenting') this.hooks.onExit && this.hooks.onExit({
                        reason: 'ar-status',
                        status: st
                    });
                };
                this._onCameraChange = () => {
                    const o = this.mv.getCameraOrbit?.();
                    this.hooks.onRotate && this.hooks.onRotate({rotY: o?.theta ?? 0, rotX: o?.phi ?? 0});
                    this.hooks.onScale && this.hooks.onScale({scale: o?.radius ?? 0});
                };
                this._onLoad = () => {
                    UI.finishLoadingProgress();
                    UI.hideLoading();
                    UI.setHint('Modelo cargado en visor 3D.');
                };
                this._onError = () => {
                    UI.hideLoading();
                    UI.setHint('Error al cargar en visor 3D.');
                };
                this._onProgress = ev => {
                    const p = ev?.detail?.totalProgress;
                    if (typeof p === 'number') UI.updateLoadingProgress(p);
                };

                this.mv.addEventListener('ar-status', this._onARStatus);
                this.mv.addEventListener('camera-change', this._onCameraChange);
                this.mv.addEventListener('load', this._onLoad);
                this.mv.addEventListener('error', this._onError);
                this.mv.addEventListener('progress', this._onProgress);
            }

            async setSource({glbUrl, usdzUrl}) {
                if (!this.mv) return;

                UI.showFallback();
                UI.showLoading('Cargando modelo…');
                UI.resetLoadingProgress();

                const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl || '';
                this.mv.src = resolved;

                if (usdzUrl && !resolved.startsWith('blob:')) {
                    this.mv.setAttribute('ios-src', usdzUrl);
                } else {
                    this.mv.removeAttribute('ios-src');
                }

                await new Promise((res, rej) => {
                    const ok = () => {
                        this.mv.removeEventListener('load', ok);
                        res();
                    };
                    const er = () => {
                        this.mv.removeEventListener('error', er);
                        rej();
                    };
                    this.mv.addEventListener('load', ok, {once: true});
                    this.mv.addEventListener('error', er, {once: true});
                });
            }

            destroy() {
                if (!this.mv) return;
                this.mv.removeEventListener('ar-status', this._onARStatus);
                this.mv.removeEventListener('camera-change', this._onCameraChange);
                this.mv.removeEventListener('load', this._onLoad);
                this.mv.removeEventListener('error', this._onError);
                this.mv.removeEventListener('progress', this._onProgress);
                this.mv.src = '';
                this.mv.removeAttribute('ios-src');
                this._bound = false;
            }
        }

        /* ============================================================================
         * AndroidWebXRController
         * ========================================================================== */
        class AndroidWebXRController {
            constructor(hooks = {}) {
                this.hooks = hooks;
                this.renderer = null;
                this.scene = null;
                this.camera = null;
                this.session = null;
                this.model = null;
                this._refSpace = null;

                this._distanceMeters = 1.2;
                this._loop = this._onXRFrame.bind(this);
                this._onResize = this._handleResize.bind(this);

                this._firstFrameSeen = false;
                this._firstFrameResolve = null;
                this.ready = new Promise(res => (this._firstFrameResolve = res));

                this._onEnd = this._onVis = null;

                this._lightProbe = null;
                this._headlamp = null;

                this._snapCanvas = null;
                this._snapCtx = null;
                this._recorder = null;
                this._recChunks = [];
                this._recStream = null;

                this._mirrorRenderer = null;
                this._mirrorCam = null;
                this._mirrorEnabled = true;
                this._gesturesBound = false;

            }

            async startSessionFromGesture() {
                this.session = await navigator.xr.requestSession('immersive-ar', {
                    requiredFeatures: ['local'],
                    optionalFeatures: ['dom-overlay', 'light-estimation'],
                    domOverlay: {root: document.body}
                });

                this._setupRenderer();
                this._setupScene();
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(this.session);
                this._refSpace = this.renderer.xr.getReferenceSpace();

                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason: 'session-end'});
                this._onVis = () => {
                    const s = this.session?.visibilityState;
                    if (s === 'hidden' || s === 'visible-blurred') {
                        this.hooks.onExit && this.hooks.onExit({reason: 'visibility', state: s});
                    }
                };
                this.session.addEventListener('end', this._onEnd);
                this.session.addEventListener('visibilitychange', this._onVis);

                try {
                    if (this.session.requestLightProbe) {
                        this._lightProbe = await this.session.requestLightProbe({type: 'spherical-harmonics'});
                    }
                } catch {
                }

                this._bindGesturesMobile();
                this._ensureSnapCanvas();

                window.addEventListener('resize', this._onResize);
                this.hooks.onEnter && this.hooks.onEnter({mode: 'android-webxr'});
            }

            async loadModel(glbUrl) {
                await this._disposeModel();
                if (!glbUrl) return;

                const resolved = AssetPreloader.getBlobURL(glbUrl) || glbUrl;

                UI.showLoading('Cargando modelo…');
                UI.resetLoadingProgress();

                await new Promise((res, rej) => {
                    const loader = new THREE.GLTFLoader();

                    loader.load(
                        resolved,
                        (gltf) => {
                            this.model = gltf.scene;

                            const box = new THREE.Box3().setFromObject(this.model);
                            const size = new THREE.Vector3();
                            box.getSize(size);
                            const s = 1 / (Math.max(size.x, size.y, size.z) || 1);
                            this.model.scale.setScalar(s);

                            this.model.traverse(o => {
                                if (o.isMesh) {
                                    o.frustumCulled = false;
                                    const m = o.material;
                                    (Array.isArray(m) ? m : [m]).forEach(mm => {
                                        if (mm) {
                                            mm.side = THREE.DoubleSide;
                                            mm.needsUpdate = true;
                                        }
                                    });
                                }
                            });

                            UI.finishLoadingProgress();
                            UI.hideLoading();
                            res();
                        },
                        (xhr) => {
                            if (xhr && xhr.lengthComputable) {
                                const p = xhr.total ? (xhr.loaded / xhr.total) : 0;
                                UI.updateLoadingProgress(p);
                            }
                        },
                        (err) => {
                            UI.hideLoading();
                            UI.setHint('Error al cargar modelo.');
                            rej(err);
                        }
                    );
                });
            }

            placeInFront() {
                this._placeInFront();
            }

            async stop() {
                try {
                    window.removeEventListener('resize', this._onResize);
                } catch {
                }
                try {
                    this.renderer?.setAnimationLoop(null);
                } catch {
                }
                await this._disposeModel();

                try {
                    if (this._recorder && this._recorder.state !== 'inactive') this._recorder.stop();
                } catch {
                }
                this._recorder = null;
                this._recChunks = [];
                this._recStream = null;

                if (this.session) {
                    try {
                        await this.session.end();
                    } catch {
                    }
                    try {
                        this.session.removeEventListener('end', this._onEnd);
                        this.session.removeEventListener('visibilitychange', this._onVis);
                    } catch {
                    }
                }

                if (this.renderer?.domElement?.parentNode) this.renderer.domElement.parentNode.removeChild(this.renderer.domElement);
                try {
                    this.renderer?.dispose?.();
                } catch {
                }

                if (this._snapCanvas && this._snapCanvas.id !== 'snap-canvas' && this._snapCanvas.parentNode) {
                    this._snapCanvas.parentNode.removeChild(this._snapCanvas);
                }
                this._snapCanvas = null;
                this._snapCtx = null;

                try {
                    this._mirrorRenderer?.dispose?.();
                } catch {
                }
                this._mirrorRenderer = null;
                this._mirrorCam = null;

                this.renderer = this.scene = this.camera = this.session = this._refSpace = null;
                this._firstFrameSeen = false;
                this.ready = new Promise(res => (this._firstFrameResolve = res));
            }

            _setupRenderer() {
                if (this.renderer) return;

                this.renderer = new THREE.WebGLRenderer({
                    antialias: true,
                    alpha: true,
                    powerPreference: 'high-performance',
                    preserveDrawingBuffer: true
                });
                this.renderer.xr.enabled = true;
                this.renderer.outputEncoding = THREE.sRGBEncoding;
                this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
                this.renderer.toneMappingExposure = 1.2;
                this.renderer.physicallyCorrectLights = true;
                this.renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                this._handleResize();
                this.renderer.setClearAlpha(0);
                Object.assign(this.renderer.domElement.style, {
                    position: 'fixed',
                    inset: '0',
                    width: '100%',
                    height: '100%',
                    zIndex: '1',
                    touchAction: 'none'
                });
                document.body.appendChild(this.renderer.domElement);

                this._mirrorRenderer = new THREE.WebGLRenderer({
                    antialias: true,
                    alpha: true,
                    preserveDrawingBuffer: true
                });
                this._mirrorRenderer.setClearAlpha(0);
                this._mirrorRenderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

                this._mirrorCam = new THREE.PerspectiveCamera(60, 1, 0.01, 20);
            }

            _setupScene() {
                this.scene = new THREE.Scene();
                const aspect = Math.max(innerWidth, 1) / Math.max(innerHeight, 1);
                this.camera = new THREE.PerspectiveCamera(60, aspect, 0.01, 20);
                const hemi = new THREE.HemisphereLight(0xffffff, 0x404040, 0.8);
                const dir = new THREE.DirectionalLight(0xffffff, 0.8);
                dir.position.set(0, 1, -1);
                this._headlamp = new THREE.PointLight(0xffffff, 1.3, 12, 2.0);
                this.camera.add(this._headlamp);
                this.scene.add(this.camera, hemi, dir);
                this.renderer.setAnimationLoop(this._loop);
            }

            _onXRFrame(time, frame) {
                if (!frame || !this._refSpace) {
                    this.renderer.render(this.scene, this.camera);

                    if (this._mirrorEnabled) {
                        this._renderMirror(this.camera);
                        this._copyToSnapCanvasFrom(this._mirrorRenderer.domElement);
                    }
                    return;
                }

                const pose = frame.getViewerPose(this._refSpace);

                if (!this._firstFrameSeen && pose) {
                    this._firstFrameSeen = true;
                    try {
                        this._firstFrameResolve && this._firstFrameResolve();
                    } catch {
                    }
                    UI.setHint('Cámara lista. Toca la retícula para colocar el modelo.');
                    UI.setReticleText('Toca para colocar el modelo');
                    UI.showReticle();
                }

                if (this._lightProbe) {
                    try {
                        const est = frame.getLightEstimate(this._lightProbe);
                        if (est?.primaryLightIntensity) {
                            const i = Math.max(0.7, Math.min(2.0, est.primaryLightIntensity.x));
                            this._headlamp.intensity = i;
                        }
                    } catch {
                    }
                }

                this.renderer.render(this.scene, this.camera);

                if (this._mirrorEnabled) {
                    const xrCam = this.renderer.xr.getCamera(this.camera);
                    this._renderMirror(xrCam);
                    this._copyToSnapCanvasFrom(this._mirrorRenderer.domElement);
                }
            }

            _renderMirror(srcCam) {
                if (!this._mirrorRenderer || !this._mirrorCam) return;

                this._mirrorCam.matrixWorld.copy(srcCam.matrixWorld);
                this._mirrorCam.matrixWorldInverse.copy(srcCam.matrixWorldInverse);
                this._mirrorCam.projectionMatrix.copy(srcCam.projectionMatrix);
                if (srcCam.projectionMatrixInverse) {
                    this._mirrorCam.projectionMatrixInverse = srcCam.projectionMatrixInverse.clone();
                } else {
                    this._mirrorCam.projectionMatrixInverse = this._mirrorCam.projectionMatrix.clone().invert();
                }
                this._mirrorCam.position.setFromMatrixPosition(this._mirrorCam.matrixWorld);
                this._mirrorCam.quaternion.setFromRotationMatrix(this._mirrorCam.matrixWorld);
                this._mirrorCam.updateMatrixWorld(true);

                this._mirrorRenderer.render(this.scene, this._mirrorCam);
            }

            _copyToSnapCanvasFrom(srcCanvas) {
                if (!this._snapCanvas || !this._snapCtx || !srcCanvas) return;
                const w = srcCanvas.width, h = srcCanvas.height;
                if (!w || !h) return;

                if (this._snapCanvas.width !== w) this._snapCanvas.width = w;
                if (this._snapCanvas.height !== h) this._snapCanvas.height = h;

                this._snapCtx.clearRect(0, 0, w, h);
                this._snapCtx.drawImage(srcCanvas, 0, 0, w, h);
            }

            _handleResize() {
                if (!this.renderer) return;
                const w = Math.max(innerWidth, 1), h = Math.max(innerHeight, 1);
                this.renderer.setSize(w, h);
                if (this.camera && h > 0) {
                    this.camera.aspect = w / h;
                    this.camera.updateProjectionMatrix();
                }

                if (this._mirrorRenderer && this._mirrorCam) {
                    this._mirrorRenderer.setSize(w, h);
                    this._mirrorCam.aspect = w / h;
                    this._mirrorCam.updateProjectionMatrix();
                }

                if (this._snapCanvas) {
                    this._snapCanvas.width = w;
                    this._snapCanvas.height = h;
                }
            }

            _placeInFront() {
                if (!this.model || !this.camera) return;
                const fwd = new THREE.Vector3(0, 0, -1).applyQuaternion(this.camera.quaternion).normalize();
                const pos = new THREE.Vector3().copy(this.camera.position).add(fwd.multiplyScalar(this._distanceMeters));
                this.model.position.copy(pos);
                this.model.position.y -= 0.1;
                this.model.lookAt(this.camera.position.x, this.model.position.y, this.camera.position.z);
                if (!this.model.parent) this.scene.add(this.model);
                UI.setHint('Modelo colocado.');
            }

            async _disposeModel() {
                if (!this.model) return;
                this.scene?.remove(this.model);
                this.model.traverse(o => {
                    if (o.isMesh) {
                        o.geometry?.dispose?.();
                        const m = o.material;
                        (Array.isArray(m) ? m : [m]).forEach(mm => mm?.dispose?.());
                    }
                });
                this.model = null;
            }

            _pixelsToMetersAtDistance(d) {
                const h = 2 * Math.tan(THREE.MathUtils.degToRad(this.camera.fov * 0.5)) * d;
                return h / Math.max(1, this.renderer.getSize(new THREE.Vector2()).y);
            }

            _bindGesturesMobile() {
                const dom = this.renderer?.domElement;
                if (!dom) return;

                // Evitar registrar eventos más de una vez
                if (this._gesturesBound) return;
                this._gesturesBound = true;

                // Desactivar gestos por defecto del navegador (scroll, zoom, etc.)
                dom.style.touchAction = 'none';

                // ================== ESTADO DE GESTOS ==================
                const st = {
                    mode: 'none',   // 'one' | 'two'
                    lastX: 0,
                    lastY: 0,
                    lastDist: 0
                };

                const clampScale = (s) => THREE.MathUtils.clamp(s, 0.2, 3.0);

                let raf = null;
                let dZoom = 1;    // factor acumulado de zoom
                let panDX = 0;    // desplazamiento acumulado X (px)
                let panDY = 0;    // desplazamiento acumulado Y (px)

                // Para detectar doble tap
                let lastTapTime = 0;
                let lastTapX = 0;
                let lastTapY = 0;
                const DOUBLE_TAP_MS = 300;
                const DOUBLE_TAP_MAX_DIST = 25; // px

                const apply = () => {
                    raf = null;
                    if (!this.model || !this.camera) return;

                    // 1) Zoom (2 dedos)
                    if (dZoom !== 1) {
                        const newScale = clampScale(this.model.scale.x * dZoom);
                        this.model.scale.setScalar(newScale);
                        dZoom = 1;
                    }

                    // 2) Pan (1 dedo)
                    if (panDX || panDY) {
                        const dCam = this.camera.position.distanceTo(this.model.position);
                        const px2m = (typeof this._pixelsToMetersAtDistance === 'function')
                            ? this._pixelsToMetersAtDistance(Math.max(0.01, dCam))
                            : dCam * 0.001; // fallback

                        const right = new THREE.Vector3(1, 0, 0).applyQuaternion(this.camera.quaternion);
                        const up = new THREE.Vector3(0, 1, 0).applyQuaternion(this.camera.quaternion);

                        // izquierda/derecha/arriba/abajo
                        this.model.position.addScaledVector(right, panDX * px2m);
                        this.model.position.addScaledVector(up, -panDY * px2m);

                        panDX = 0;
                        panDY = 0;
                    }
                };

                const queue = () => {
                    if (!raf) raf = requestAnimationFrame(apply);
                };

                const onStart = (e) => {
                    if (!this.model) return;

                    const n = e.touches.length;

                    if (n === 1) {
                        // 1 dedo → MOVER
                        st.mode = 'one';
                        st.lastX = e.touches[0].clientX;
                        st.lastY = e.touches[0].clientY;

                    } else if (n === 2) {
                        // 2 dedos → ZOOM
                        st.mode = 'two';
                        const [a, b] = e.touches;
                        st.lastDist = Math.hypot(
                            a.clientX - b.clientX,
                            a.clientY - b.clientY
                        );
                    } else {
                        // 3+ dedos: ignoramos (sin giros)
                        st.mode = 'none';
                    }
                };

                const onMove = (e) => {
                    if (!this.model) return;

                    // Necesario para evitar scroll/zoom del navegador
                    e.preventDefault();

                    const n = e.touches.length;

                    // ===== 1 dedo: PAN =====
                    if (st.mode === 'one' && n === 1) {
                        const t = e.touches[0];
                        const dx = t.clientX - st.lastX;
                        const dy = t.clientY - st.lastY;

                        panDX += dx;
                        panDY += dy;

                        st.lastX = t.clientX;
                        st.lastY = t.clientY;

                        queue();
                        return;
                    }

                    // ===== 2 dedos: ZOOM =====
                    if (st.mode === 'two' && n >= 2) {
                        const [a, b] = e.touches;
                        const dist = Math.hypot(
                            a.clientX - b.clientX,
                            a.clientY - b.clientY
                        );

                        const ratio = dist / Math.max(1, st.lastDist);
                        dZoom *= ratio;
                        st.lastDist = dist;

                        queue();
                        return;
                    }
                };

                const resetPose = () => {
                    // Si tienes un método propio mejor usarlo:
                    if (typeof this.resetModelPose === 'function') {
                        this.resetModelPose();
                        return;
                    }

                    // Reset genérico: ajusta a tus defaults
                    this.model.position.set(0, 0, 0);
                    this.model.rotation.set(0, 0, 0);
                    this.model.scale.setScalar(1);
                };

                const onEnd = (e) => {
                    const now = performance.now();

                    // Detectar doble tap cuando se levanta el último dedo
                    if (e.touches.length === 0 && e.changedTouches.length === 1) {
                        const t = e.changedTouches[0];
                        const dt = now - lastTapTime;
                        const dist = Math.hypot(t.clientX - lastTapX, t.clientY - lastTapY);

                        if (dt < DOUBLE_TAP_MS && dist < DOUBLE_TAP_MAX_DIST) {
                            // Doble tap → resetear modelo
                            resetPose();
                            lastTapTime = 0;
                        } else {
                            lastTapTime = now;
                            lastTapX = t.clientX;
                            lastTapY = t.clientY;
                        }
                    }

                    st.mode = 'none';
                };

                dom.addEventListener('touchstart', onStart, {passive: true});
                dom.addEventListener('touchmove', onMove, {passive: false});
                dom.addEventListener('touchend', onEnd, {passive: true});
                dom.addEventListener('touchcancel', onEnd, {passive: true});
            }


            getCanvas() {
                return this.renderer?.domElement || null;
            }

            getModelStats() {
                return StatsUtils.compute(this.model) || {};
            }

            _ensureSnapCanvas() {
                if (this._snapCanvas) return;

                const external = document.getElementById('snap-canvas');

                if (external) {
                    // Usar canvas externo, pero SIEMPRE oculto
                    this._snapCanvas = external;
                } else {
                    // Crear uno nuevo, también oculto
                    this._snapCanvas = document.createElement('canvas');
                    document.body.appendChild(this._snapCanvas);
                }

                // 🔹 AQUI lo importante: SIEMPRE oculto
                Object.assign(this._snapCanvas.style, {
                    display: 'none',
                    position: 'fixed',
                    inset: '0',
                    pointerEvents: 'none',
                    opacity: '0',
                    zIndex: '-1'
                });

                this._snapCtx = this._snapCanvas.getContext('2d', {willReadFrequently: false});

                const w = Math.max(innerWidth, 1);
                const h = Math.max(innerHeight, 1);
                this._snapCanvas.width = w;
                this._snapCanvas.height = h;
            }


            _timestamp() {
                const p = (n, s = 2) => String(n).padStart(s, '0');
                const d = new Date();
                return `${d.getFullYear()}${p(d.getMonth() + 1)}${p(d.getDate())}-${p(d.getHours())}${p(d.getMinutes())}${p(d.getSeconds())}`;
            }

            async capture({
                              type = 'image/jpeg',
                              quality = 0.95,
                              background = '#ffffff',
                              filename,
                              download = true
                          } = {}) {
                if (!this._snapCanvas) this._ensureSnapCanvas();
                if (!this._snapCanvas || !this._snapCtx) throw new Error('Snap canvas no disponible');

                await new Promise(r => requestAnimationFrame(r));

                const src = this._mirrorRenderer?.domElement;
                if (!src || !src.width || !src.height) throw new Error('Espejo no disponible');

                if (this._snapCanvas.width !== src.width) this._snapCanvas.width = src.width;
                if (this._snapCanvas.height !== src.height) this._snapCanvas.height = src.height;

                const w = this._snapCanvas.width, h = this._snapCanvas.height;

                if (background) {
                    this._snapCtx.fillStyle = background;
                    this._snapCtx.fillRect(0, 0, w, h);
                } else {
                    this._snapCtx.clearRect(0, 0, w, h);
                }

                this._snapCtx.drawImage(src, 0, 0, w, h);

                await new Promise(r => requestAnimationFrame(r));

                const blob = await new Promise(res => this._snapCanvas.toBlob(res, type, quality));
                if (!blob) throw new Error('No se pudo generar la imagen');

                let url = null;
                if (download) {
                    url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    const ext = type === 'image/png' ? 'png' : (type === 'image/webp' ? 'webp' : 'jpg');
                    a.href = url;
                    a.download = filename || `ar-frame-${this._timestamp()}.${ext}`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    setTimeout(() => URL.revokeObjectURL(url), 1000);
                }

                return {blob, url};
            }


            async captureWithVideoTextureQuad({
                                                  facingMode = 'environment',
                                                  type = 'image/png',   // ⬅️ PNG por defecto para no degradar color
                                                  quality = 0.95,
                                                  download = true,
                                                  filename,
                                                  includeCamera = true
                                              } = {}) {
                const srcAR =
                    (this._mirrorRenderer && this._mirrorRenderer.domElement) ||
                    (this.renderer && this.renderer.domElement);

                if (!srcAR) {
                    console.warn('[captureWithVideoTextureQuad] No hay canvas AR disponible');
                    return null;
                }

                // Helper para descargar
                const getExtension = (mimeType) => {
                    if (mimeType === 'image/png') return 'png';
                    if (mimeType === 'image/webp') return 'webp';
                    return 'jpg';
                };

                const downloadBlob = (blob, prefix) => {
                    if (!blob || !download) return;

                    const ext = getExtension(type);
                    const label = prefix || 'capture';
                    const ts = (typeof this._timestamp === 'function')
                        ? (this._timestamp() || Date.now())
                        : Date.now();

                    const name = filename || `${label}-${ts}.${ext}`;
                    const url = URL.createObjectURL(blob);

                    const a = document.createElement('a');
                    a.href = url;
                    a.download = name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();

                    setTimeout(() => URL.revokeObjectURL(url), 1000);
                };

                // Asegurar un frame fresco del AR
                await new Promise((resolve) => requestAnimationFrame(resolve));

                // ================= SOLO AR (sin cámara extra) =================
                if (!includeCamera) {
                    const blob = await new Promise((resolve) =>
                        srcAR.toBlob(resolve, type, quality)
                    );
                    downloadBlob(blob, 'ar-only');
                    return blob || null;
                }

                // ================= CÁMARA + AR (composite) =================
                let stream = null;
                let video = null;

                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {facingMode, width: 1280, height: 720},
                        audio: false
                    });

                    video = document.createElement('video');
                    video.playsInline = true;
                    video.muted = true;
                    video.autoplay = true;
                    video.srcObject = stream;

                    Object.assign(video.style, {
                        position: 'fixed',
                        width: '1px',
                        height: '1px',
                        opacity: '0',
                        pointerEvents: 'none',
                        zIndex: '-1',
                        left: '0',
                        top: '0'
                    });

                    document.body.appendChild(video);

                    // Esperar metadata
                    await new Promise((resolve, reject) => {
                        const onLoadedMetadata = () => {
                            cleanup();
                            resolve();
                        };
                        const onError = (e) => {
                            cleanup();
                            reject(e);
                        };
                        const cleanup = () => {
                            video.removeEventListener('loadedmetadata', onLoadedMetadata);
                            video.removeEventListener('error', onError);
                        };
                        video.addEventListener('loadedmetadata', onLoadedMetadata, {once: true});
                        video.addEventListener('error', onError, {once: true});
                    });

                    try {
                        await video.play();
                    } catch (_) {
                    }
                    await new Promise((resolve) => setTimeout(resolve, 120));
                    await new Promise((resolve) => requestAnimationFrame(resolve));

                    const targetWidth = Math.max(1, srcAR.width);
                    const targetHeight = Math.max(1, srcAR.height);

                    // ⬅️ Intentamos forzar sRGB cuando el navegador lo soporte
                    const compositeCanvas = document.createElement('canvas');
                    compositeCanvas.width = targetWidth;
                    compositeCanvas.height = targetHeight;

                    const ctx = compositeCanvas.getContext('2d', {
                        willReadFrequently: false,
                        colorSpace: 'srgb'
                    }) || compositeCanvas.getContext('2d');

                    const videoWidth = video.videoWidth || 1280;
                    const videoHeight = video.videoHeight || 720;

                    const videoAspect = videoWidth / videoHeight;
                    const canvasAspect = targetWidth / targetHeight;

                    let sx, sy, sWidth, sHeight;

                    if (videoAspect > canvasAspect) {
                        sHeight = videoHeight;
                        sWidth = sHeight * canvasAspect;
                        sx = (videoWidth - sWidth) / 2;
                        sy = 0;
                    } else {
                        sWidth = videoWidth;
                        sHeight = sWidth / canvasAspect;
                        sx = 0;
                        sy = (videoHeight - sHeight) / 2;
                    }

                    // 1) Fondo: cámara (suave, con suavizado)
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.filter = 'none';
                    ctx.drawImage(
                        video,
                        sx, sy, sWidth, sHeight,
                        0, 0, targetWidth, targetHeight
                    );

                    // 2) AR encima 1:1, con un ligero ajuste para bajar saturación/brillo
                    //    (ajústalo si lo ves necesario: p.ej. 'saturate(0.9) brightness(0.95)')
                    ctx.imageSmoothingEnabled = false;
                    ctx.filter = 'saturate(0.9) brightness(0.97)';
                    ctx.drawImage(srcAR, 0, 0, targetWidth, targetHeight);
                    ctx.filter = 'none';

                    const blob = await new Promise((resolve) =>
                        compositeCanvas.toBlob(resolve, type, quality)
                    );

                    downloadBlob(blob, 'ar-composite');
                    return blob || null;

                } catch (error) {
                    console.error('[captureWithVideoTextureQuad] error', error);
                    return null;

                } finally {
                    try {
                        stream?.getTracks()?.forEach(track => track.stop());
                    } catch (_) {
                    }
                    if (video?.parentNode) {
                        video.parentNode.removeChild(video);
                    }
                }
            }


            async restartXRAfterCamera({rePlaceModel = true} = {}) {
                let prevDist = null;
                const hadModel = !!this.model;

                try {
                    if (this.model && this.camera) {
                        prevDist = this.camera.position.distanceTo(this.model.position);
                    }
                } catch {
                }

                // 1) Volver a crear la sesión XR
                await this._resumeXRSessionInternal();
                await this.afterResumeXR?.();

                // 2) Si queremos recolocar el modelo frente a la cámara (otros flujos)
                if (rePlaceModel && this.model && this.camera &&
                    typeof prevDist === 'number' && isFinite(prevDist) && prevDist > 0.05) {
                    try {
                        const fwd = new THREE.Vector3(0, 0, -1)
                            .applyQuaternion(this.camera.quaternion)
                            .normalize();
                        const pos = new THREE.Vector3()
                            .copy(this.camera.position)
                            .addScaledVector(fwd, prevDist);
                        this.model.position.copy(pos);
                        this.model.lookAt(
                            this.camera.position.x,
                            this.model.position.y,
                            this.camera.position.z
                        );
                        if (!this.model.parent) this.scene.add(this.model);
                    } catch {
                    }
                }

                // 3) Si YA había modelo, no queremos que se active el flow de "primer frame"
                if (hadModel && this.model) {
                    // Evita que _onXRFrame vuelva a mostrar la retícula y "Toca para colocar…"
                    this._firstFrameSeen = true;
                    try {
                        this._firstFrameResolve && this._firstFrameResolve();
                    } catch {
                    }

                    // Aseguramos que la UI quede en modo "modelo ya colocado"
                    UI.hideReticle();
                    UI.setHint('Modelo listo.');
                }

            }


            async _resumeXRSessionInternal() {
                try {
                    this.renderer?.setAnimationLoop(null);
                } catch {
                }

                this.session = await navigator.xr.requestSession('immersive-ar', {
                    requiredFeatures: ['local'],
                    optionalFeatures: ['dom-overlay', 'light-estimation'],
                    domOverlay: {root: document.body}
                });

                this.renderer.xr.enabled = true;
                this.renderer.xr.setReferenceSpaceType('local');
                await this.renderer.xr.setSession(this.session);
                this._refSpace = this.renderer.xr.getReferenceSpace();

                this._onEnd = () => this.hooks.onExit && this.hooks.onExit({reason: 'session-end'});
                this._onVis = () => {
                    const s = this.session?.visibilityState;
                    if (s === 'hidden' || s === 'visible-blurred') {
                        this.hooks.onExit && this.hooks.onExit({reason: 'visibility', state: s});
                    }
                };
                this.session.addEventListener('end', this._onEnd);
                this.session.addEventListener('visibilitychange', this._onVis);

                this._lightProbe = null;
                try {
                    if (this.session.requestLightProbe) {
                        this._lightProbe = await this.session.requestLightProbe({type: 'spherical-harmonics'});
                    }
                } catch {
                }

                this.renderer.setAnimationLoop(this._loop);

                this._firstFrameSeen = false;
                this.ready = new Promise(res => (this._firstFrameResolve = res));

                // 🔹 IMPORTANTE: re-asegurar gestos sobre el canvas
                this._bindGesturesMobile();
            }


            async afterResumeXR() {
                if (!this.renderer) return;

                try {
                    this._handleResize();
                } catch {
                }

                await new Promise(r => requestAnimationFrame(r));

                try {
                    if (this.session) this.renderer.setAnimationLoop(this._loop);
                } catch {
                }

                try {
                    this.renderer.render(this.scene, this.camera);
                } catch {
                }
                await new Promise(r => requestAnimationFrame(r));
                try {
                    this.renderer.render(this.scene, this.camera);
                } catch {
                }
            }

            async endXRButKeepScene() {
                if (!this.session) return;

                try {
                    this.session.removeEventListener('end', this._onEnd);
                    this.session.removeEventListener('visibilitychange', this._onVis);
                } catch {
                }
                this._onEnd = this._onVis = null;

                try {
                    this.renderer?.setAnimationLoop(null);
                } catch {
                }

                try {
                    await this.session.end();
                } catch {
                }

                this.session = null;
                this._refSpace = null;

                if (this.renderer) {
                    this.renderer.setClearAlpha(0);
                }
            }

            startRecording({fps = 30, mimeType = 'video/webm;codecs=vp9'} = {}) {
                if (!this._mirrorRenderer) return false;
                if (this._recorder && this._recorder.state === 'recording') return true;

                const canvas = this._mirrorRenderer.domElement;
                this._recStream = canvas.captureStream(fps);
                try {
                    this._recorder = new MediaRecorder(this._recStream, {mimeType});
                } catch {
                    this._recorder = new MediaRecorder(this._recStream);
                }

                this._recChunks = [];
                this._recorder.ondataavailable = e => {
                    if (e.data && e.data.size) this._recChunks.push(e.data);
                };
                this._recorder.onstop = () => {
                    this._recStream = null;
                };
                this._recorder.start();
                return true;
            }

            async stopRecordingAndGetBlob() {
                if (!this._recorder || this._recorder.state === 'inactive') return null;
                const done = new Promise(resolve => {
                    this._recorder.onstop = () => {
                        const blob = new Blob(this._recChunks, {type: this._recorder.mimeType || 'video/webm'});
                        this._recChunks = [];
                        this._recStream = null;
                        resolve(blob);
                    };
                });
                this._recorder.stop();
                return await done;
            }

            async stopRecordingAndDownload(filename = 'ar-capture.webm') {
                const blob = await this.stopRecordingAndGetBlob();
                if (!blob) return false;
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
                return true;
            }
        }

        /* ============================================================================
         * ViewerOrchestrator
         * ========================================================================== */
        class ViewerOrchestrator {
            constructor() {
                this._state = {
                    mode: null,
                    controller: null,
                    pendingGLB: null,
                    arReady: false,
                    lastSource: null
                };
            }

            get state() {
                return this._state;
            }

            isActive() {
                return !!this._state.controller;
            }

            async captureCameraFrameBlob() {
                const st = this._state;
                if (st.mode !== 'android-webxr' || !st.controller) {
                    UI.setHint('Cámara: no hay sesión AR activa.');
                    return null;
                }

                const composer = new CameraOverlayComposer();

                const hadModel = !!st.controller.model;
                const saved = hadModel ? {
                    pos: st.controller.model.position.clone(),
                    quat: st.controller.model.quaternion.clone(),
                    scl: st.controller.model.scale.clone()
                } : null;

                try {
                    await st.controller.endXRButKeepScene();

                    await composer.start({includeCanvas3D: false});
                    await new Promise(r => setTimeout(r, 250));

                    const camBlob = await composer.snapshotToBlob({type: 'image/jpeg', quality: 0.95});
                    console.log("camBlob", camBlob);
                    return camBlob || null;
                } catch (e) {
                    console.error('[captureCameraFrameBlob] error', e);
                    return null;
                } finally {
                    try {
                        await composer.stop();
                    } catch {
                    }
                    try {
                        await st.controller.restartXRAfterCamera({rePlaceModel: true});
                    } catch {
                    }
                    if (hadModel && saved) {
                        st.controller.model.position.copy(saved.pos);
                        st.controller.model.quaternion.copy(saved.quat);
                        st.controller.model.scale.copy(saved.scl);
                    }
                }
            }

            async captureModelFrameBlob() {
                const st = this._state;
                if (st.mode === 'android-webxr' && typeof st.controller?.capture === 'function') {
                    const {blob} = await st.controller.capture({
                        type: 'image/png',
                        quality: 1.0,
                        background: null,
                        download: false
                    });
                    return blob || null;
                }

                if (st.mode !== 'android-webxr' && UI.mv?.shadowRoot) {
                    const cnv = UI.mv.shadowRoot.querySelector('canvas');
                    if (cnv && cnv.width && cnv.height) {
                        const tmp = document.createElement('canvas');
                        tmp.width = cnv.width;
                        tmp.height = cnv.height;
                        const ctx = tmp.getContext('2d');
                        ctx.clearRect(0, 0, tmp.width, tmp.height);
                        ctx.drawImage(cnv, 0, 0);
                        const blob = await new Promise(res => tmp.toBlob(res, 'image/png', 1.0));
                        return blob || null;
                    }
                }
                return null;
            }

            async onCaptureGpu() {
                const st = this._state;
                const ctrl = st.controller;

                if (!ctrl || typeof ctrl.captureWithVideoTextureQuad !== 'function') {
                    UI.setHint('No hay sesión AR activa.');
                    return;
                }

                UI.setHint('Capturando…');

                try {
                    const blob = await ctrl.captureWithVideoTextureQuad({
                        facingMode: 'environment',
                        type: 'image/jpeg',
                        quality: 0.95,
                        download: true,
                        includeCamera: true // cámara + AR
                    });

                    UI.setHint(blob ? 'Captura guardada.' : 'No se pudo capturar.');
                } catch (error) {
                    console.error('[onCaptureGpu] Error al capturar', error);
                    UI.setHint('Ocurrió un error al capturar.');
                }
            }

            async captureScreenFrame({
                                         type = 'image/jpeg',
                                         quality = 0.95,
                                         download = true,
                                         filename
                                     } = {}) {
                const caps = canScreenCapture?.() || {ok: false, reason: 'desconocido'};
                if (!caps.ok) {
                    UI.setHint(`ScreenCapture no disponible: ${caps.reason || 'permiso/HTTPS'}`);
                    return null;
                }

                const st = this._state;
                const ctrl = st.controller;
                const wasXR = (st.mode === 'android-webxr');

                let stream = null;
                let video = null;

                const hadModel = !!ctrl?.model;
                const saved = hadModel ? {
                    pos: ctrl.model.position.clone(),
                    quat: ctrl.model.quaternion.clone(),
                    scl: ctrl.model.scale.clone()
                } : null;

                try {
                    UI.setHint('Selecciona la pantalla para capturar…');

                    stream = await navigator.mediaDevices.getDisplayMedia({
                        video: {frameRate: 30}, audio: false
                    });

                    video = document.createElement('video');
                    video.playsInline = true;
                    video.muted = true;
                    video.autoplay = true;
                    video.srcObject = stream;
                    Object.assign(video.style, {
                        position: 'fixed',
                        left: '-9999px',
                        top: '-9999px',
                        width: '1px',
                        height: '1px'
                    });
                    document.body.appendChild(video);

                    await new Promise((res, rej) => {
                        const ok = () => {
                            cleanup();
                            res();
                        };
                        const er = (e) => {
                            cleanup();
                            rej(e);
                        };
                        const cleanup = () => {
                            video.removeEventListener('loadedmetadata', ok);
                            video.removeEventListener('error', er);
                        };
                        video.addEventListener('loadedmetadata', ok, {once: true});
                        video.addEventListener('error', er, {once: true});
                    });
                    try {
                        await video.play();
                    } catch {
                    }

                    const w = Math.max(1, video.videoWidth || screen.width || 1280);
                    const h = Math.max(1, video.videoHeight || screen.height || 720);
                    const cnv = document.createElement('canvas');
                    cnv.width = w;
                    cnv.height = h;
                    const ctx = cnv.getContext('2d', {willReadFrequently: false});
                    ctx.drawImage(video, 0, 0, w, h);

                    const blob = await new Promise(res => cnv.toBlob(res, type, quality));
                    if (blob && download) {
                        const ext = (type === 'image/png') ? 'png' : (type === 'image/webp' ? 'webp' : 'jpg');
                        const id = st.lastSource?.id || 'screen';
                        const t = new Date();
                        const p = n => String(n).padStart(2, '0');
                        const name = filename || `${id}-${t.getFullYear()}${p(t.getMonth() + 1)}${p(t.getDate())}-${p(t.getHours())}${p(t.getMinutes())}${p(t.getSeconds())}.${ext}`;
                        DownloadUtils.saveBlob(name, blob);
                    }

                    UI.setHint('Captura de pantalla lista.');
                    return blob || null;

                } catch (e) {
                    console.error('[captureScreenFrame] error', e);
                    UI.setHint('No se pudo capturar la pantalla.');
                    return null;

                } finally {
                    try {
                        stream?.getTracks()?.forEach(t => t.stop());
                    } catch {
                    }
                    if (video?.parentNode) video.parentNode.removeChild(video);

                    if (wasXR && ctrl && typeof ctrl.restartXRAfterCamera === 'function') {
                        try {
                            await ctrl.restartXRAfterCamera({rePlaceModel: true});
                        } catch {
                        }
                        if (hadModel && saved) {
                            ctrl.model.position.copy(saved.pos);
                            ctrl.model.quaternion.copy(saved.quat);
                            ctrl.model.scale.copy(saved.scl);
                        }
                    }
                }
            }

            _fitRect(srcW, srcH, dstW, dstH, mode = 'cover') {
                const sr = srcW / srcH, dr = dstW / dstH;
                let w, h;
                if (mode === 'cover' ? (sr > dr) : (sr < dr)) {
                    h = dstH;
                    w = h * sr;
                } else {
                    w = dstW;
                    h = w / sr;
                }
                return {x: (dstW - w) * .5, y: (dstH - h) * .5, w, h};
            }

            async mergeCameraAndModelBlobs({
                                               cameraBlob, modelBlob,
                                               outType = 'image/jpeg', quality = 0.95,
                                               width, height,
                                               cameraMode = 'cover', modelMode = 'contain',
                                               modelOpacity = 1.0, background = '#ffffff'
                                           } = {}) {
                if (!cameraBlob || !modelBlob) throw new Error('merge: faltan blobs.');
                const camBmp = await createImageBitmap(cameraBlob, {imageOrientation: 'from-image'}).catch(() => null);
                const mdlBmp = await createImageBitmap(modelBlob, {imageOrientation: 'from-image'}).catch(() => null);
                if (!camBmp || !mdlBmp) throw new Error('merge: decode falló.');

                const W = width || camBmp.width || 1280;
                const H = height || camBmp.height || 720;
                const cnv = (typeof OffscreenCanvas !== 'undefined')
                    ? new OffscreenCanvas(W, H)
                    : Object.assign(document.createElement('canvas'), {width: W, height: H});
                if (!('width' in cnv)) {
                    cnv.width = W;
                    cnv.height = H;
                }
                const ctx = cnv.getContext('2d');

                if (background) {
                    ctx.fillStyle = background;
                    ctx.fillRect(0, 0, W, H);
                } else {
                    ctx.clearRect(0, 0, W, H);
                }

                const rc = this._fitRect(camBmp.width, camBmp.height, W, H, cameraMode);
                ctx.drawImage(camBmp, rc.x, rc.y, rc.w, rc.h);

                const rm = this._fitRect(mdlBmp.width, mdlBmp.height, W, H, modelMode);
                const prev = ctx.globalAlpha;
                ctx.globalAlpha = Math.max(0, Math.min(1, modelOpacity));
                ctx.drawImage(mdlBmp, rm.x, rm.y, rm.w, rm.h);
                ctx.globalAlpha = prev;

                const toBlob = (canvas, type, q) => new Promise(res => {
                    if (canvas.convertToBlob) canvas.convertToBlob({type, quality: q}).then(res).catch(() => res(null));
                    else canvas.toBlob(res, type, q);
                });
                const out = await toBlob(cnv, outType, quality);
                try {
                    camBmp.close?.();
                    mdlBmp.close?.();
                } catch {
                }
                return out;
            }

            async captureCameraPlusModelAndSave() {
                const st = this._state;
                if (!st.controller) {
                    UI.setHint('No hay sesión activa para capturar.');
                    return;
                }

                const id = st.lastSource?.id || 'snapshot';
                const t = new Date(), pad = n => String(n).padStart(2, '0');
                const filename = `${id}-${t.getFullYear()}${pad(t.getMonth() + 1)}${pad(t.getDate())}-${pad(t.getHours())}${pad(t.getMinutes())}${pad(t.getSeconds())}.jpg`;

                try {
                    let modelBlob = null;
                    let cameraBlob = null;

                    // cameraBlob = await this.captureCameraFrameBlob();
                    // modelBlob = await this.captureModelFrameBlob();
                    // De momento desactivado para no mezclar 2 flows pesados

                    if (!cameraBlob && !modelBlob) {
                        UI.setHint('No se pudo capturar cámara ni modelo.');
                        return;
                    }

                    console.log("cameraBlob", cameraBlob, "modelBlob", modelBlob);
                    const all = false;
                    if (cameraBlob && modelBlob && all) {
                        const merged = await this.mergeCameraAndModelBlobs({
                            cameraBlob,
                            modelBlob,
                            outType: 'image/jpeg',
                            quality: 0.95,
                            cameraMode: 'cover',
                            modelMode: 'contain',
                            modelOpacity: 1.0,
                            background: '#ffffff'
                        });
                        if (merged) {
                            DownloadUtils.saveBlob(filename, merged);
                            UI.setHint('Imagen (cámara+modelo) guardada.');
                            return;
                        }
                    }

                    if (cameraBlob) {
                        DownloadUtils.saveBlob(filename, cameraBlob);
                        UI.setHint('Imagen (solo cámara) guardada.');
                        return;
                    }
                    if (modelBlob) {
                        const namePNG = filename.replace(/\.jpg$/i, '.png');
                        DownloadUtils.saveBlob(namePNG, modelBlob);
                        UI.setHint('Imagen (solo modelo) guardada.');
                        return;
                    }
                } catch (e) {
                    console.error('[captureCameraPlusModelAndSave] error', e);
                    UI.setHint('Error al capturar.');
                }
            }

            async onMarkerSourceSelected(input) {
                let id = null;
                let raw = null;

                if (typeof input === 'string') {
                    raw = input;
                    const match = ItemsStore.getItems().find(i => i.sources?.glb === input);
                    id = match?.id ?? null;
                } else {
                    id = input?.id ?? null;
                    raw = input?.glbUrl ?? '';
                }

                // Siempre usamos el URL original como clave de caché
                const cachedBlobUrl = AssetPreloader.getBlobURL(raw);
                const cacheStatus = id ? ItemsStore.getCacheStatus(id) : (cachedBlobUrl ? 'hot' : 'cold');
                const isCached = !!cachedBlobUrl || cacheStatus === 'hot';
                const glbUrl = raw;

                const usdzUrl = (!glbUrl?.startsWith('blob:') && glbUrl?.endsWith?.('.glb'))
                    ? glbUrl.replace(/\.glb$/i, '.usdz')
                    : '';

                this._state.lastSource = {id, glb: glbUrl, usdz: usdzUrl};

                console.log('[ViewerOrchestrator] onMarkerSourceSelected cache', {
                    id,
                    glbUrl,
                    isCached,
                    cacheStatus
                });

                UI.revealContainer();
                UI.hideMap();
                UI.hideFallback();

                if (await canUseAR()) {
                    try {
                        UI.showLoading(isCached ? 'Abriendo cámara (modelo precargado)…' : 'Abriendo cámara…');
                        const ctrl = new AndroidWebXRController({
                            onEnter: () => UI.setHint('Cámara iniciada.'),
                            onExit: async ({reason}) => {
                                UI.setHint(`Sesión finalizada (${reason || 'desconocido'}).`);
                                await this.destroy();
                            }
                        });

                        await ctrl.startSessionFromGesture();
                        this._state.mode = 'android-webxr';
                        this._state.controller = ctrl;
                        this._state.pendingGLB = glbUrl;

                        await ctrl.ready;
                        UI.hideLoading();
                        UI.showReticle();
                        UI.setHint('Toca la retícula para colocar.');
                        UI.showCapture();
                        return;
                    } catch (e) {
                        console.warn('No se pudo iniciar WebXR, usando fallback', e);
                        // ⚠️ IMPORTANTE: si falla WebXR, ocultamos el loading que se quedó activo
                        UI.hideLoading();
                    }
                }

                // Fallback <model-viewer>
                const mvCtrl = new ModelViewerController(UI.mv, {
                    onEnter: ({mode}) => UI.setHint(`AR activo (${mode}).`)
                });
                mvCtrl.bindOnce();

                try {
                    await mvCtrl.setSource({glbUrl, usdzUrl});
                    this._state.mode = Platform.isIOS ? 'ios-quicklook' : 'web-fallback';
                    this._state.controller = mvCtrl;
                    this._state.pendingGLB = null;

                    UI.showCapture();
                } catch (err) {
                    console.error('Error en fallback model-viewer', err);
                    UI.setHint('No se pudo cargar el modelo en fallback.');
                }
            }

            async handleReticleTap() {
                if (this._state.mode !== 'android-webxr' || !this._state.controller) return;
                const glb = this._state.pendingGLB;
                if (!glb) {
                    UI.setHint('No hay modelo seleccionado.');
                    return;
                }

                UI.showLoading('Cargando modelo…');
                UI.resetLoadingProgress();
                try {
                    await this._state.controller.loadModel(glb);
                    this._state.controller.placeInFront();
                    UI.hideLoading();
                    UI.hideReticle();
                    UI.setHint('Modelo colocado.');
                    this._state.pendingGLB = null;
                } catch {
                    UI.hideLoading();
                    UI.setHint('Error al cargar el modelo.');
                }
            }

            async destroy() {
                try {
                    if (this._state.controller) {
                        if (this._state.mode === 'android-webxr') await this._state.controller.stop();
                        else this._state.controller.destroy();
                    }
                } catch {
                }
                this._state = {
                    mode: null,
                    controller: null,
                    pendingGLB: null,
                    arReady: false,
                    lastSource: this._state.lastSource
                };
                UI.hideFallback();
                UI.hideReticle();
                UI.hideCapture();
                UI.showMap();
                UI.setHint('');
            }
        }

        /* ============================================================================
         * Mapa (Leaflet)
         * ========================================================================== */
        class MapController {

            constructor(cfg) {
                this.cfg = Object.assign({
                    zoom: 19, maxZoom: 25, position: [0.20830, -78.22798],
                    tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    tileAttribution: '&copy; OpenStreetMap contribuyentes'
                }, cfg || {});
                this.map = null;
                this.layer = null;
                this.byId = {};
                this.appMapConfig = {
                    zoom: {
                        WORLD: 0,          // Vista del planeta
                        CONTINENT: 2,      // Vista continental
                        COUNTRY: 5,        // País / región
                        CITY: 10,          // Ciudad

                        CITY_DETAIL: 12,   // Ciudad con buenas calles
                        NEIGHBORHOOD: 14,  // Barrios
                        STREET: 16,        // Vista de calles
                        HOUSE: 17,         // Casas (zoom recomendado)
                        BUILDING: 18,      // Muy cerca
                        MAX: 19            // Máximo recomendado por OSM
                    },

                    flyOptions: {
                        FAST: {duration: 0.35},
                        NORMAL: {duration: 0.7},
                        SLOW: {duration: 1.2}
                    }
                };

            }

            initDrawOther(drawings) {
                let map = this.map;
                if (!Array.isArray(drawings)) {
                    console.warn('drawings no es un array');
                    return;
                }

                drawings.forEach(function (item) {
                    var type = item.type; // "rectangle", "polygon", "polyline", etc.
                    var layer = null;

                    // Opciones comunes de estilo
                    var strokeColor = item.strokeColor || '#000000';
                    var strokeWeight = item.strokeWeight || 2;
                    var strokeOpacity = (typeof item.strokeOpacity !== 'undefined') ? item.strokeOpacity : 1;
                    var fillColor = item.fillColor || strokeColor;
                    var fillOpacity = (typeof item.fillOpacity !== 'undefined') ? item.fillOpacity : 0.2;

                    var baseOptions = {
                        color: strokeColor,
                        weight: strokeWeight,
                        opacity: strokeOpacity
                    };

                    // RECTÁNGULO
                    if (type === 'rectangle' && item.bounds) {
                        var b = item.bounds;
                        // Leaflet espera [ [southLat, westLng], [northLat, eastLng] ]
                        var southWest = L.latLng(b.south, b.west);
                        var northEast = L.latLng(b.north, b.east);
                        var bounds = L.latLngBounds(southWest, northEast);

                        layer = L.rectangle(bounds, Object.assign({}, baseOptions, {
                            fillColor: fillColor,
                            fillOpacity: fillOpacity
                        }));
                    }

                    // POLÍGONO
                    else if (type === 'polygon' && Array.isArray(item.paths)) {
                        var latLngsPolygon = item.paths.map(function (p) {
                            return L.latLng(parseFloat(p.lat), parseFloat(p.lng));
                        });

                        layer = L.polygon(latLngsPolygon, Object.assign({}, baseOptions, {
                            fillColor: fillColor,
                            fillOpacity: fillOpacity
                        }));
                    }

                    // POLILÍNEA
                    else if (type === 'polyline' && Array.isArray(item.path)) {
                        var latLngsLine = item.path.map(function (p) {
                            return L.latLng(parseFloat(p.lat), parseFloat(p.lng));
                        });

                        layer = L.polyline(latLngsLine, baseOptions);
                    }

                    // Si no se reconoció el tipo o faltan datos, salimos
                    if (!layer) {
                        console.warn('No se pudo crear layer para item id:', item.id, 'type:', type);
                        return;
                    }

                    // 👉 Opcional: guardar meta-datos dentro del layer
                    layer._totemMeta = {
                        id: item.id,
                        rd_id: item.rd_id,
                        routes_drawing_id: item.routes_drawing_id,
                        routes_map_id: item.routes_map_id,
                        totem_category_code: item.totem_category_code,
                        totem_category_id: item.totem_category_id,
                        totem_category_name: item.totem_category_name,
                        totem_subcategory_code: item.totem_subcategory_code,
                        totem_subcategory_id: item.totem_subcategory_id,
                        totem_subcategory_name: item.totem_subcategory_name,
                        title: item.title,
                        subtitle: item.subtitle,
                        content: item.content
                    };

                    // 👉 Popup básico usando título, subcategoría y contenido
                    var popupHtml = '<strong>' + (item.title || '') + '</strong><br>' +
                        '<em>' + (item.subtitle || '') + '</em><br>' +
                        (item.totem_category_name ? ('<br><b>Categoria:</b> ' + item.totem_category_name) : '') +
                        (item.totem_subcategory_name ? ('<br><b>Subcategoria:</b> ' + item.totem_subcategory_name) : '') +
                        (item.content ? ('<br><br>' + item.content) : '');

                    //   layer.bindPopup(popupHtml);

                    // 👉 Agregar al mapa
                    layer.addTo(map);
                });
            }

            init(items) {
                this.map = L.map('map', {zoomControl: true}).setView(this.cfg.position, this.cfg.zoom);
                L.tileLayer(this.cfg.tileUrl, {
                    maxZoom: this.cfg.maxZoom,
                    attribution: this.cfg.tileAttribution
                }).addTo(this.map);
                this.layer = L.layerGroup().addTo(this.map);
                this.render(items);

                this.map.on('popupopen', (e) => {
                    this._bindPopup(e);
                    const mk = e.popup._source;
                    if (mk) {
                        console.log("popupopen");
                        requestAnimationFrame(() => this.map.flyTo(mk.getLatLng(), this.appMapConfig.zoom.BUILDING, {duration: 0.35}));
                    }
                });
            }

            render(items) {
                this.layer.clearLayers();
                this.byId = {};
                const bounds = [];
                items.forEach(it => {
                    const icon = L.icon({
                        iconUrl: it.sources.img,
                        iconSize: [60, 60],
                        iconAnchor: [60, 60],
                        popupAnchor: [0, -40]
                    });
                    const mk = L.marker([it.position.lat, it.position.lng], {icon, title: it.title})
                        .bindPopup(this._popupHTML(it), {maxWidth: 320, autoPan: true, keepInView: true});
                    mk.addTo(this.layer);
                    mk.on('click', () => {
                        let currentZoom = this.map.getZoom();
                        console.log("click mk", currentZoom);
                        let setZoom = this.appMapConfig.zoom.BUILDING;
                        this.map.flyTo(
                            mk.getLatLng(),
                            setZoom,   // usa el zoom actual del mapa
                            {duration: 0.35}    // segundo parámetro son las options
                        );
                        //    mk.openPopup();
                    });
                    this.byId[it.id] = mk;
                    bounds.push([it.position.lat, it.position.lng]);
                });
                if (bounds.length) this.map.fitBounds(bounds, {padding: [40, 40]});
            }

            _popupHTML(item) {
                console.log("_popupHTML", item);
                let clasViewGLB = "not-view";
                let allowViewGLB = !(item.sources.glb == null);
                if (allowViewGLB) {
                    clasViewGLB = "";
                }
                return `
<article class="popup-card" data-popup-id="${item.id}">
  <header class="popup-card__header">
    <img class="popup-card__img" src="${item.sources.img}" alt="${item.title}" loading="lazy">
    <div class="popup-card__titles ">
       <span class="badge bg-secondary popup-card__subcategory">Totem-${item.totem_subcategory_name}</span>
      <h4 class="popup-card__title color-primary--title">${item.title}</h4>
      <p class="popup-card__subtitle color-secondary--title">${item.subtitle}</p>
    </div>
  </header>
  <section class="popup-card__body"><p class="popup-card__description">${item.description}</p></section>
  <footer class="popup-card__footer">
    <button class="popup-card__btn popup-card__btn--primary not-view" data-action="center" data-id="${item.id}">Centrar aquí</button>
    <a class="popup-card__btn popup-card__btn--ghost color-secondary--title ${clasViewGLB}"
       data-action="view3d"
       data-id="${item.id}"
       rel="noopener noreferrer">Ver en 3D</a>
  </footer>
</article>`;
            }

            _bindPopup(e) {
                const root = e.popup.getElement();
                if (!root) return;

                L.DomEvent.disableClickPropagation(root);
                L.DomEvent.disableScrollPropagation(root);

                const centerBtn = root.querySelector('.popup-card__btn[data-action="center"]');
                centerBtn?.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    const id = centerBtn.getAttribute('data-id');
                    console.log("click centerBtn");

                    this.flyTo(id);
                }, {once: true});

                const idForWarm = root.querySelector('[data-action="view3d"]')?.dataset?.id;
                if (idForWarm) {
                    ItemsStore.warmById(idForWarm).catch(() => {
                    });
                }

                const onClick = (ev) => {
                    console.log("onClick");
                    const btn = ev.target.closest('[data-action="view3d"]');
                    if (!btn) return;
                    ev.preventDefault();
                    ev.stopPropagation();

                    const id = btn.dataset.id;
                    const best = ItemsStore.getBestGlbUrl(id)
                        || ItemsStore.getItemById(id)?.sources?.glb
                        || '';

                    if (!best) {
                        UI.setHint('No hay fuente GLB/USDZ.');
                        return;
                    }

                    setTimeout(() => window.Viewer.onMarkerSourceSelected({id, glbUrl: best}), 0);
                };

                root.addEventListener('click', onClick, {passive: false});
                this.map.once('popupclose', (evClose) => {
                    if (evClose.popup === e.popup) root.removeEventListener('click', onClick);
                });
            }

            flyTo(id, zoom = 17) {
                const mk = this.byId[id];
                if (!mk) return;
                const ll = mk.getLatLng();
                console.log("click flyTo");

                this.map.flyTo(ll, this.appMapConfig.zoom.BUILDING, {duration: 0.35});
                mk.openPopup();
            }
        }

        /* ============================================================================
         * Device events
         * ========================================================================== */
        class DeviceEvents {
            static attach() {
                document.addEventListener('visibilitychange', async () => {
                    if (document.hidden) {
                        await window.Viewer?.destroy();
                    }
                });
                window.addEventListener('pagehide', () => window.Viewer?.destroy());
                window.addEventListener('orientationchange', () => console.log('[orientationchange]'));
                window.addEventListener('resize', () => console.log('[resize]', innerWidth, innerHeight));
            }
        }

        /* ============================================================================
         * AssetPreloader (precache GLB) + Verificador de cache
         * ========================================================================== */
        /**
         * AssetPreloader (Clean Code + URL Normalization Fix)
         * ---------------------------------------------------
         * - Corrige el problema de que la URL cacheada no coincide con la URL solicitada.
         * - Normaliza todas las URLs para que siempre coincidan.
         * - Mantiene soporte para CacheStorage + memoria local.
         * - Añade verificador de caché para depurar y coordinar entre clases.
         */

        const AssetPreloader = (() => {

            /** =============================
             *  Normalización estable de URLs
             * ============================== */
            function normalizeUrl(url) {
                if (!url) return '';

                try {
                    const u = new URL(url, location.origin);
                    u.hash = '';                 // Sin hash
                    u.search = '';               // Sin querystring
                    return u.toString();
                } catch {
                    // Caso: rutas relativas locales
                    return url.replace(location.origin, '')
                        .replace(/#.*$/, '')
                        .replace(/\?.*$/, '');
                }
            }

            /** =============================
             *  Memoria interna
             * ============================== */
            const mem = new Map();   // normalizedUrl -> { buffer, blobUrl }
            const inflight = new Map();
            const CACHE_NAME = 'glb-precache-v1';
            const canCacheStorage = ('caches' in window);


            /** =============================
             *  Fetch directo
             * ============================== */
            async function _fetchToBuffer(urlN) {
                const r = await fetch(urlN, {credentials: 'omit', mode: 'cors'});
                if (!r.ok) throw new Error(`Fetch failed (${r.status}) ${urlN}`);
                return await r.arrayBuffer();
            }

            /** =============================
             *  CacheStorage: guardar
             * ============================== */
            async function _putInCache(urlN, buffer) {
                if (!canCacheStorage) return;

                try {
                    const cache = await caches.open(CACHE_NAME);
                    const resp = new Response(buffer, {
                        headers: {
                            'Content-Type': 'model/gltf-binary',
                            'Content-Length': String(buffer.byteLength)
                        }
                    });

                    await cache.put(urlN, resp);
                } catch {
                }
            }

            /** =============================
             *  CacheStorage: leer
             * ============================== */
            async function _fromCache(urlN) {
                if (!canCacheStorage) return null;

                try {
                    const cache = await caches.open(CACHE_NAME);
                    const resp = await cache.match(urlN);
                    if (!resp) return null;
                    return await resp.arrayBuffer();
                } catch {
                    return null;
                }
            }

            /** =============================
             *  Preload individual
             * ============================== */
            async function warm(url) {
                if (!url) return;

                const urlN = normalizeUrl(url);

                if (mem.has(urlN)) return;

                if (inflight.has(urlN)) {
                    await inflight.get(urlN);
                    return;
                }

                const job = (async () => {
                    let buf = await _fromCache(urlN);

                    if (!buf) {
                        const goodNet =
                            !('connection' in navigator) ||
                            ['wifi', 'ethernet', '4g']
                                .includes(navigator.connection.effectiveType || '4g');

                        if (!goodNet) return;

                        buf = await _fetchToBuffer(urlN);
                        _putInCache(urlN, buf).catch(() => {
                        });
                    }

                    if (buf && !mem.has(urlN)) {
                        const blobUrl = URL.createObjectURL(
                            new Blob([buf], {type: 'model/gltf-binary'})
                        );
                        mem.set(urlN, {buffer: buf, blobUrl});
                    }
                })().finally(() => inflight.delete(urlN));

                inflight.set(urlN, job);
                await job;
            }


            /** =============================
             *  Preload múltiple
             * ============================== */
            function warmMany(urls = [], {concurrency = 3} = {}) {
                const list = urls.map(u => normalizeUrl(u));
                let idx = 0, active = 0;

                return new Promise(resolve => {
                    const next = () => {
                        while (active < concurrency && idx < list.length) {
                            const urlN = list[idx++];
                            active++;

                            warm(urlN).finally(() => {
                                active--;
                                next();
                            });
                        }
                        if (active === 0 && idx >= list.length) resolve();
                    };
                    next();
                });
            }


            /** =============================
             *  Obtener blob: URL real
             * ============================== */
            function getBlobURL(url) {
                const urlN = normalizeUrl(url);
                return mem.get(urlN)?.blobUrl || null;
            }

            /** =============================
             *  Verificador simple de memoria
             * ============================== */
            function has(url) {
                const urlN = normalizeUrl(url);
                return mem.has(urlN);
            }

            function isWarming(url) {
                const urlN = normalizeUrl(url);
                return inflight.has(urlN);
            }

            /**
             * Verificador detallado: memoria + CacheStorage
             * Devuelve un objeto útil para debug/log:
             * {
             *   urlOriginal, urlNormalized,
             *   inMemory, inCacheStorage, hasBlobUrl
             * }
             */
            async function check(url) {
                const urlN = normalizeUrl(url);
                const inMemory = mem.has(urlN);
                const hasBlobUrl = !!mem.get(urlN)?.blobUrl;

                let inCacheStorage = false;
                if (canCacheStorage) {
                    try {
                        const cache = await caches.open(CACHE_NAME);
                        const resp = await cache.match(urlN);
                        inCacheStorage = !!resp;
                    } catch {
                        inCacheStorage = false;
                    }
                }

                return {
                    urlOriginal: url,
                    urlNormalized: urlN,
                    inMemory,
                    inCacheStorage,
                    hasBlobUrl
                };
            }

            /** =============================
             *  Liberar
             * ============================== */
            function dispose(url) {
                const urlN = normalizeUrl(url);
                const obj = mem.get(urlN);

                if (obj?.blobUrl) URL.revokeObjectURL(obj.blobUrl);

                mem.delete(urlN);
            }


            /** =============================
             *  API pública
             * ============================== */
            return {
                warm,
                warmMany,
                getBlobURL,
                dispose,
                normalizeUrl,
                has,
                isWarming,
                check
            };
        })();

        /* ============================================================================
         * ItemsStore + verificador de caché por item
         * ========================================================================== */
        const ItemsStore = (function () {
            let _items = [];

            function _withCacheShape(item) {
                return {
                    ...item,
                    dataCache: {
                        glbBlobUrl: item?.dataCache?.glbBlobUrl || null,
                        lastWarmAt: item?.dataCache?.lastWarmAt || null,
                        bytes: item?.dataCache?.bytes || null,
                    }
                };
            }

            function setItems(list) {
                _items = Array.isArray(list) ? list.map(_withCacheShape) : [];
            }

            function getItems() {
                return _items.map(i => ({...i, dataCache: {...i.dataCache}}));
            }

            function getItemById(id) {
                return _items.find(i => i.id == id) || null;
            }

            function updateItem(id, patch) {
                const idx = _items.findIndex(i => i.id === id);
                if (idx === -1) return false;
                const current = _items[idx];
                const next = _withCacheShape({...current, ...patch});
                if (!patch?.dataCache?.glbBlobUrl && current.dataCache?.glbBlobUrl) {
                    next.dataCache.glbBlobUrl = current.dataCache.glbBlobUrl;
                }
                _items[idx] = next;
                return true;
            }

            function replaceAll(newItems) {
                setItems(newItems);
                return getItems();
            }

            function markCache(id, {glbBlobUrl, bytes} = {}) {
                const it = getItemById(id);
                if (!it) return false;
                it.dataCache.glbBlobUrl = glbBlobUrl ?? it.dataCache.glbBlobUrl ?? null;
                it.dataCache.lastWarmAt = new Date().toISOString();
                if (typeof bytes === 'number') it.dataCache.bytes = bytes;
                return true;
            }

            function getBestGlbUrl(id) {
                const it = getItemById(id);
                if (!it) return null;
                return it.dataCache?.glbBlobUrl || it.sources?.glb || null;
            }

            async function warmById(id) {
                const it = getItemById(id);
                if (!it?.sources?.glb) return false;
                try {
                    await AssetPreloader.warm(it.sources.glb);
                    const blobUrl = AssetPreloader.getBlobURL(it.sources.glb);
                    if (blobUrl) {
                        markCache(id, {glbBlobUrl: blobUrl});
                        return true;
                    }
                } catch (e) {
                    console.warn('[ItemsStore] warmById error', id, e);
                }
                return false;
            }

            async function warmAll({ids = null, concurrency = 3} = {}) {
                const urls = (ids
                        ? _items.filter(i => ids.includes(i.id))
                        : _items
                ).map(i => i.sources?.glb).filter(Boolean);

                await AssetPreloader.warmMany(urls, {concurrency});

                for (const it of _items) {
                    const u = it.sources?.glb;
                    if (!u) continue;
                    const blob = AssetPreloader.getBlobURL(u);
                    if (blob) markCache(it.id, {glbBlobUrl: blob});
                }
            }

            /**
             * Estado resumido de caché de un ítem:
             * - "hot": en memoria con blob listo
             * - "warming": se está precargando
             * - "cold": sin precarga
             * - "missing": sin URL GLB
             */
            function getCacheStatus(id) {
                const it = getItemById(id);
                if (!it?.sources?.glb) return 'missing';
                const url = it.sources.glb;
                const hasMem = AssetPreloader.has(url);
                const warming = AssetPreloader.isWarming(url);
                if (hasMem) return 'hot';
                if (warming) return 'warming';
                return 'cold';
            }

            /**
             * Info detallada por item para depuración/log.
             */
            async function getCacheInfo(id) {
                const it = getItemById(id);
                if (!it?.sources?.glb) return null;
                const base = await AssetPreloader.check(it.sources.glb);
                return {
                    id: it.id,
                    title: it.title,
                    subtitle: it.subtitle,
                    ...base,
                    lastWarmAt: it.dataCache?.lastWarmAt || null,
                    bytes: it.dataCache?.bytes || null
                };
            }

            return {
                setItems, getItems, replaceAll, updateItem, getItemById,
                markCache, getBestGlbUrl,
                warmById, warmAll,
                getCacheStatus, getCacheInfo,
            };
        })();

        /* ============================================================================
         * canScreenCapture
         * ========================================================================== */
        function canScreenCapture() {
            const isSecure = location.protocol === 'https:' || location.hostname === 'localhost';
            const hasAPI = !!(navigator.mediaDevices?.getDisplayMedia || navigator.getDisplayMedia);
            const inIframe = window.self !== window.top;
            const isWV = /\bwv\b/i.test(navigator.userAgent);

            return {
                ok: isSecure && hasAPI && !isWV,
                reason: !isSecure ? 'No HTTPS' :
                    !hasAPI ? 'API no disponible' :
                        isWV ? 'WebView limita captura' :
                            inIframe ? 'Iframe sin permisos (display-capture)' :
                                'Desconocido',
                hasAPI, isSecure, inIframe, isWV
            };
        }

        /* ============================================================================
         * initPreCache
         * ========================================================================== */
        function initPreCache(params) {


            const MAP_CONFIG = Object.freeze({
                zoom: 14, maxZoom: 25,
                position: [0.20830, -78.22798],
                tileUrl: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                tileAttribution: '&copy; OpenStreetMap contrib.'
            });

            params.mapCtl.init(ItemsStore.getItems());

            const startWarm = async () => {
                try {
                    await ItemsStore.warmAll({concurrency: 3});
                    console.log('[preload] OK: blobs listos');
                } catch (e) {
                    console.warn('[preload] fallo o cancelado', e);
                }
            };

            const warmWhenVisible = () => {
                if (document.visibilityState !== 'visible') {
                    document.addEventListener('visibilitychange', function onVis() {
                        if (document.visibilityState === 'visible') {
                            document.removeEventListener('visibilitychange', onVis);
                            queueWarm();
                        }
                    });
                    return;
                }
                queueWarm();
            };

            const queueWarm = () => {
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(() => startWarm(), {timeout: 2000});
                } else {
                    setTimeout(() => startWarm(), 300);
                }
            };

            warmWhenVisible();
        }

        /* ============================================================================
         * Helpers de debug de cache (opcional)
         * ========================================================================== */
        window.CacheDebug = {
            async logAll() {
                const items = ItemsStore.getItems();
                for (const it of items) {
                    const info = await ItemsStore.getCacheInfo(it.id);
                    console.log('[CacheDebug] item', it.id, info);
                }
            },
            async logOne(id) {
                const info = await ItemsStore.getCacheInfo(id);
                console.log('[CacheDebug] item', id, info);
            }
        };

        /* ============================================================================
         * Bootstrap — usando jQuery
         * ========================================================================== */
        let itemsSourcesAux = [];
        $(function () {
            initWhatsapp();
                ItemsStore.setItems(itemsSources);
                /*   itemsSources = [
                       {
                           id: "taita",
                           title: "Taita Imbabura – Abuelo que despierta las montañas",
                           subtitle: "Ñawi Hatun Yaya – Yaku Kawsay Tukuy Kuna",
                           description: "Padre volcán de Imbabura, sabio y vigilante. Desde sus laderas nacen vientos, manantiales y semillas que dan vida a la provincia. Sus aguas bajan hacia la laguna y alimentan chacras y comunidades. Taita Imbabura es guía y protector, un anciano vivo que recuerda a la gente su relación con la tierra y el agua.",
                           position: {lat: 0.20477, lng: -78.20639},
                           sources: {
                               glb: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/taita-imbabura-toon-1.glb',
                               img: (window.$dataManagerPage?.['public-root'] || '') + '/simi-rura/muelle-catalina/images/taita-imbabura.png'
                           }
                       },
                   */


                UI.bind();
                window.Viewer = new ViewerOrchestrator();
                const mapCtl = new MapController({});
                initPreCache({mapCtl: mapCtl});
                mapCtl.initDrawOther($itemsOtherDraw);
                DeviceEvents.attach();

                UI.$reticle?.addEventListener('click', async () => {
                    await window.Viewer.handleReticleTap();
                });
                UI.$back?.addEventListener('click', async () => {
                    await window.Viewer.destroy();
                });

                UI.$capture?.addEventListener('click', async () => {
                    console.log("Captura pantalla");
                    // await window.Viewer.captureScreenFrame();
                    // Otras opciones:
                    // await window.Viewer.captureCameraPlusModelAndSave();
                    await window.Viewer.onCaptureGpu();
                });

                const companyPanel = document.getElementById('companyPanelHeader');
                const companyPanelToggle = document.querySelector('.company-panel__toggle');

                companyPanel.addEventListener('click', () => {
                    companyPanel.classList.toggle('company-panel--collapsed');
                    const body = document.querySelector('.company-panel__body');
                    $("#btn-capture").removeClass("btn-view-data-cam");
                    if (companyPanel.classList.contains('company-panel--collapsed')) {
                        body.style.display = 'none';
                        $("#btn-capture").removeClass("btn-view-data-cam");
                    } else {
                        body.style.display = 'block';
                        $("#btn-capture").addClass("btn-view-data-cam");

                    }
                });
                const btnMoreInfo = document.getElementById('btnMoreInfo');
                const companyDescriptionEl = document.getElementById('companyDescription');

                btnMoreInfo.addEventListener('click', () => {
                    const isExpanded = btnMoreInfo.dataset.expanded === 'true';
                    const full = companyDescriptionEl.dataset.full;
                    const short = companyDescriptionEl.dataset.short || full;

                    if (isExpanded) {
                        // Volver a descripción corta
                        //  companyDescriptionEl.textContent = short;
                        btnMoreInfo.textContent = 'Ver más';
                        btnMoreInfo.dataset.expanded = 'false';
                    } else {
                        // Mostrar descripción completa
                        //    companyDescriptionEl.textContent = full;
                        btnMoreInfo.textContent = 'Ver menos';
                        btnMoreInfo.dataset.expanded = 'true';
                    }
                });
                btnMoreInfo.click();
            }
        );


    </script>

@endsection
@section('content')

    <!-- Mensajes de estado -->
    <div id="hint" class="hint">Estado: listo</div>

    <!-- Controles principales -->
    <button id="btn-back-map" class="btn d-none">← Volver al mapa</button>
    <button id="btn-capture" class="btn d-none">📸</button>

    <!-- Contenedor de AR/Fallback -->
    <div class="container--custom not-view">
        <!-- Loading transparente con % -->
        <div id="ar-loading" class="loading d-none">
            <div class="loading__center">
                <div class="spinner"></div>
                <div class="loading__text">
                    <strong id="ar-loading-label">Cargando…</strong>
                    <span id="ar-loading-percent">0%</span>
                </div>
            </div>
        </div>

        <!-- Fallback: <model-viewer> -->
        <div id="fallback" class="d-none">
            <model-viewer id="mv"
                          ar ar-modes="scene-viewer quick-look webxr"
                          camera-controls
                          environment-image="neutral"
                          style="width:100%;height:60vh;background:#000">
            </model-viewer>
        </div>
    </div>

    <!-- Retícula (tap aquí para colocar) -->
    <div id="reticle-overlay" class="reticle hidden" aria-hidden="true">
        <div class="reticle__ring"></div>
        <div class="reticle__dot"></div>
        <div class="reticle__hint">Toca la retícula para colocar</div>
    </div>
    <?php

    $companyTagline = "Turismo · Deportes · Geología";
    $hrefCurrent = "https://meetclic.com/es/businessDetails/Muelle%20Catalina";
    $titleChaquiñan = "Vive la Vida";
    $descriptinoChaquiñan = "La Ruta Sagrada del Muelle Catalina es un recorrido temático, turístico y cultural que conecta los puntos más emblemáticos del territorio de Imbabura. En esta travesía, viajeros y familias se acercan a los espíritus protectores de la laguna y las montañas, descubriendo paisajes ancestrales, actividades deportivas, historias vivas y experiencias de contacto con la naturaleza.\r\n\r\nLa ruta integra montañismo, senderismo, fotografía, historia, espiritualidad andina y observación paisajística, guiando a los visitantes desde la serenidad del Muelle Catalina hasta la grandeza de Taita Imbabura, la magia de las lagunas y la fuerza ceremonial del Lechero.\r\n\r\nEs una experiencia diseñada para educar, inspirar y conectar, ideal para turistas, deportistas, familias y estudiantes.";
    $companyName = "Meetclic";
    $sourceChaquiñan = 'https://meetclic.com/public/uploads/frontend/templateBySource/1750454099_logo-one.png';
    $phone_value = "0985339457";

    // Asegúrate de que el número esté en formato internacional sin "+"
    $phone = preg_replace('/\D+/', '', $phone_value);

    // Mensaje por defecto
    $whatsappMessage = 'Hola, me interesa obtener más información sobre su empresa ,esta informacion es desde la ruta ';
    if ($dataManager["allow"]) {
        $sourceChaquiñanBusiness = URL::asset($resourcePathServer . $dataManager["business"]["business"][0]["source"]);
        $sourceChaquiñan = URL::asset($resourcePathServer . $dataManager["dataRoute"]["information"]["src"]);

        $companyName = $dataManager["business"]["business"][0]["business_name"];
        $phone_value = $dataManager["business"]["business"][0]["phone_value"];
        $whatsappMessage = "Hola, vi {$companyName} en MeetClic y me gustaría más información 🙌";

        $titleChaquiñan = $dataManager["dataRoute"]["information"]["name"];
        $descriptinoChaquiñan = $dataManager["dataRoute"]["information"]["description"];

        $companyTagline = "";
        $tags = [];
        $hrefCurrent = "https://meetclic.com/es/businessDetails/" . $dataManager["business"]["business"][0]["business_name"];
        foreach ($dataManager["dataRoute"]["adventure_type_data"] as $name => $value) {
            $tags[] = $value->adventure_adventure_type_text;

        }
        if (!empty($tags)) {
            $companyTagline = implode(' · ', $tags);
        }
    }

    ?>
        <!-- Mapa -->
    <div id="map" class="map"></div>
    <canvas id="snap-canvas" class="snap-canvas d-none"></canvas>
    <div class="company-panel company-panel--expanded" id="companyPanel">
        <div class="company-panel__header view-toogle-company company-panel__header--clickable" id="companyPanelHeader">
            <div class="company-panel__logo">
                <img
                    src="{{$sourceChaquiñan}}"
                    alt="Logo Empresa"
                    class="company-panel__logo-img"
                />
            </div>

            <div class="company-panel__title view-toogle-company">
                <h2 id="companyName" class="company-panel__name">{{$titleChaquiñan}}</h2>
                <span id="companyTagline" class="company-panel__tagline">{{$companyTagline}}</span>
            </div>

            <button
                class="company-panel__toggle view-toogle-company company-panel__toggle--right"
                id="companyPanelToggle"
            >
                ⟩
            </button>
        </div>

        <div class="company-panel__body">
            @if(    ($dataManager["allow"]))
                {!! $dataManager["dataRoute"]["routesDrawingGroupHtml"]!!}
            @else
                <div class="company-panel__section company-panel__section--stats">
                    <div class="stats company-panel__stats">
                        <div class="stat company-panel__stat">
                            <span class="stat__label company-panel__stat-label">Tótems turísticos</span>
                            <span class="stat__value company-panel__stat-value" id="statTourism">5</span>
                        </div>
                        <div class="stat company-panel__stat">
                            <span class="stat__label company-panel__stat-label">Tótems deportivos</span>
                            <span class="stat__value company-panel__stat-value" id="statSports">2</span>
                        </div>
                        <div class="stat company-panel__stat">
                            <span class="stat__label company-panel__stat-label">Tótems geológicos</span>
                            <span class="stat__value company-panel__stat-value" id="statGeo">3</span>
                        </div>
                    </div>
                </div>
            @endif


            <div class="company-panel__section company-panel__section--description">
                <h3 class="color-primary--title company-panel__subtitle">Descripción</h3>

                @if(!$dataManager["allow"])
                    <p id="companyDescription" class="company-panel__description">
                        {{$descriptinoChaquiñan}}
                    </p>
                @else
                    <div id="companyDescription" class="company-panel__description">
                        {!! $descriptinoChaquiñan !!}
                    </div>
                @endif

                <button
                    class="link-button not-view company-panel__more-link"
                    id="btnMoreInfo"
                >
                    Ver perfil completo
                </button>
            </div>

            <div class="company-panel__section company-panel__section--contacts">
                <h3 class="color-primary--title company-panel__subtitle">
                    {{$companyName}} - Contactanos
                </h3>

                <div class="contact-list company-panel__contacts">
                    <a class="color-secondary--title company-panel__contact-link"
                       id="companyEmail"
                       href="mailto:info@empresa.com">
                        📧 Email
                    </a>

                    <a class="color-secondary--title company-panel__contact-link"
                       id="companyWhatsapp"
                       href="https://wa.me/{{$phone}}?text={{urlencode($whatsappMessage) }}"
                       target="_blank">
                        💬 WhatsApp
                    </a>

                    <a class="color-secondary--title company-panel__contact-link"
                       id="companyWebsite"
                       href="{{ $hrefCurrent }}"
                       target="_blank">
                        🌐 Sitio web
                    </a>

                    <div class="social-icons company-panel__social">
                        <a class="color-secondary--title company-panel__social-link"
                           id="companyInstagram"
                           href="https://instagram.com/empresa"
                           target="_blank">
                            IG
                        </a>
                        <a class="color-secondary--title company-panel__social-link"
                           id="companyFacebook"
                           href="https://facebook.com/empresa"
                           target="_blank">
                            FB
                        </a>
                        <a class="color-secondary--title company-panel__social-link"
                           id="companyTiktok"
                           href="https://tiktok.com/@empresa"
                           target="_blank">
                            TT
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
