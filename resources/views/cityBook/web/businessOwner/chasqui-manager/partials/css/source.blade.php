<style>
    .stats__header {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .stats__header i {
        font-size: 1.1rem;
    }
    .stats__header {
        font-weight: bold;
        color: #6e7171;
        padding-bottom: 14px;
    }
    /* Estado oculto de elementos marcados */
    .not-view {
        display: none !important;
    }
    .route-type--turismo {
        --route-pastel: #D7CCC8;
        --route-dark: #5D4037;
    }

    .route-type--educativo {
        --route-pastel: #D1C4E9;
        --route-dark: #512DA8;
    }

    .route-type--medico {
        --route-pastel: #FFCDD2;
        --route-dark: #C62828;
    }

    /* =========================================================
   ACTIVIDADES DE RUTA
   ========================================================= */
    .adventure-carousel {
        width: 100%;
        position: relative;
    }

    .adventure-carousel__slide {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 35px;
    }

    .adventure-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 7px 11px;
        border-radius: 50px;

        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    }

    .adventure-tag__icon {
        font-size: 14px;
    }

    .adventure-tag__label {
        line-height: 1;
    }

    .adventure-carousel__control {
        width: 28px;
        height: 28px;

        top: 50%;
        transform: translateY(-50%);

        opacity: 1;

        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .12);

        color: #495057;
    }

    .adventure-carousel__control:hover {
        color: #212529;
    }

    .adventure-carousel__control i {
        font-size: 14px;
    }

    .adventure-carousel__control.carousel-control-prev {
        left: 0;
    }

    .adventure-carousel__control.carousel-control-next {
        right: 0;
    }
    .route-activity--apnea {
        --activity-pastel: #B3E5FC;
        --activity-dark: #0277BD;
    }

    .route-activity--cicloturismo {
        --activity-pastel: #C8E6C9;
        --activity-dark: #2E7D32;
    }

    .route-activity--bungee {
        --activity-pastel: #FFCDD2;
        --activity-dark: #C62828;
    }

    .route-activity--rafting {
        --activity-pastel: #B2EBF2;
        --activity-dark: #00838F;
    }

    .route-activity--cabalgata {
        --activity-pastel: #D7CCC8;
        --activity-dark: #6D4C41;
    }

    .route-activity--montanismo {
        --activity-pastel: #CFD8DC;
        --activity-dark: #455A64;
    }

    .route-activity--senderismo {
        --activity-pastel: #DCEDC8;
        --activity-dark: #558B2F;
    }

    .route-activity--ciclismo-montana {
        --activity-pastel: #DCE775;
        --activity-dark: #827717;
    }

    .route-activity--escalada {
        --activity-pastel: #FFE0B2;
        --activity-dark: #EF6C00;
    }

    .route-activity--canopy {
        --activity-pastel: #FFF9C4;
        --activity-dark: #F9A825;
    }

    .route-activity--tirolesas {
        --activity-pastel: #FFECB3;
        --activity-dark: #FF8F00;
    }

    .route-activity--overlanding {
        --activity-pastel: #EFEBE9;
        --activity-dark: #5D4037;
    }

    .route-activity--rapel {
        --activity-pastel: #FFCCBC;
        --activity-dark: #D84315;
    }

    .route-activity--vias-ferratas {
        --activity-pastel: #B0BEC5;
        --activity-dark: #546E7A;
    }

    .route-activity--barranquismo {
        --activity-pastel: #B2DFDB;
        --activity-dark: #00796B;
    }

    .route-activity--parapente {
        --activity-pastel: #D1C4E9;
        --activity-dark: #5E35B1;
    }
    /* =========================================================
       TÓTEMS EN LA RUTA
       ========================================================= */

    .stat.senderismo {
        background: #E8F5E9!important;
    }
    .stat__label.senderismo {
        color: #2E7D32 !important;
    }
    .stat__value.senderismo {
        color: #2E7D32 !important;
    }


    .route-totem--trekking {
        --totem-pastel: #F1F8E9;
        --totem-dark: #558B2F;
    }
    .stat.trekking {
        background: #F1F8E9!important;
    }
    .stat__label.trekking {
        color: #558B2F !important;
    }
    .stat__value.trekking {
        color: #558B2F !important;
    }



    .route-totem--cultural {
        --totem-pastel: #FFF3E0;
        --totem-dark: #E65100;
    }
    .stat.cultural {
        background: #FFF3E0!important;
    }
    .stat__label.cultural {
        color: #E65100 !important;
    }
    .stat__value.cultural {
        color: #E65100 !important;
    }


    .route-totem--andino-apu {
        --totem-pastel: #E0E0E0;
        --totem-dark: #424242;
    }
    .stat.andino_apu {
        background: #E0E0E0!important;
    }
    .stat__label.andino_apu {
        color: #424242 !important;
    }
    .stat__value.andino_apu {
        color: #424242 !important;
    }


    .stat.andino_agua {
        background: #E1F5FE!important;
    }

    .stat__label.andino_agua {
        color: #0277BD !important;
    }
    .stat__value.andino_agua {
        color: #0277BD !important;
    }


    .route-totem--andino-arbol {
        --totem-pastel: #E8F5E9;
        --totem-dark: #33691E;
    }

    .stat.andino_arbol {
        background: #E8F5E9!important;
    }

    .stat__label.andino_arbol {
        color: #33691E !important;
    }
    .stat__value.andino_arbol {
        color: #33691E !important;
    }


    .route-totem--andino-espiritual {
        --totem-pastel: #F3E5F5;
        --totem-dark: #6A1B9A;
    }

    .stat.andino_espiritual {
        background: #F3E5F5!important;
    }
    .stat__label.andino_espiritual {
        color: #6A1B9A !important;
    }
    .stat__value.andino_espiritual {
        color: #6A1B9A !important;
    }



    .route-totem--medico-general {
        --totem-pastel: #FFEBEE;
        --totem-dark: #C62828;
    }
    .stat.medico_general {
        background: #FFEBEE!important;
    }
    .stat__label.medico_general {
        color: #C62828 !important;
    }
    .stat__value.medico_general {
        color: #C62828 !important;
    }



    body {
        margin: 0;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
        color: #eee;
    }

    .leaflet-top.leaflet-left {
        top: 15%;
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

    #btn-up-down {
        bottom: 10%;
        right: 26%;
        position: fixed;
        box-shadow: 0 0px 0px rgba(0, 0, 0, .35) !important;
    }

    #btn-right-left {
        position: fixed;
        bottom: 10%;
        right: 62%;
        box-shadow: 0 0px 0px rgba(0, 0, 0, .35) !important;
    }

    img.btn-up-down__img {
        width: 45px;
        height: 51px;
    }

    img.btn-right-left__img {
        width: 67px;
        height: 51px;
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
        bottom: 11.6%;
        color: #000;
    }

    .btn-view-data-cam-joystick-zone {
        bottom: 45% !important;
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

        align-items: center;
        padding: 12px 12px 8px;
        border-bottom: 1px solid #eee;
        gap: 8px;
    }

    .company-panel__logo img {
        width: 320px;
        height: 140px;

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
        display: none;
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
        padding: 1px 1px;
        text-align: center;
    }

    .stat.senderismo {
        background: #DCEDC8 !important;
    }

    .stat__label.senderismo {
        color: #33691E !important;
    }
    .stat__value.senderismo {
        color: #33691E !important;
    }




    .stat__label {
        display: block;
        font-size: 10px;
        color: #555;
    }

    .stat__value {
        font-size: 14px;
        font-weight: 600;

    }

    .stat__value {
        font-size: 14px;
        font-weight: 600;

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
            max-height: 89vh;
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
        bottom: 48% !important;
    }


</style>
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
/>
<style>
    #joystick-zone {
        position: fixed; /* o absolute dentro de tu contenedor AR */
        bottom: 84px; /* súbelo un poco para no pisar la tarjeta de ruta */
        left: 50%;
        transform: translateX(-50%);
        width: 140px;
        height: 140px;
        z-index: 9999;
    }

    #joystick-zone.joystick--disabled {
        opacity: 0;
        pointer-events: none;
    }

    #joystick-zone.joystick--enabled {
        opacity: 1;
        pointer-events: auto;
    }
</style>
