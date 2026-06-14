<style>


    /* ====== Layout general ====== */
    .mc-elements {
        width: 28vw;
        margin: 0px auto;
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 0px;
    }
    button.btn.btn-default.dropdown-toggle {
        display: none;
    }
    /* Tablet */
    @media (max-width: 992px) {
        .mc-elements {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .mc-element__stack {
            margin-top: 0px !important;
            gap: 0px !important;
        }

        .mc-element__head {

        }
        .mc-elements {
            width: 100%;
            margin-right: 0px;
            margin-left: 0px !important;
            grid-template-columns: 1fr;
        }
        .mc-panel {
            width: 77% !important;
            margin-left: 12% !important;
        }
        .mc-steps{
            margin-top: 1px !important;
        }
        /* BUTTONS MANAGER */
        .mc-ex__controls {
            width: 70%;
            bottom: 1%;
        }
        .container--manager-dictionary{
            padding: 0 0% 0 0% !important;
        }

    }


    /* Mobile: cada sección hacia abajo */
    @media (max-width: 560px) {
        .content {
            padding-top: 4% !important;

        }

        .mc-elements {
            width: 100%;
            margin-right: 0px;
            margin-left: 0px !important;
            grid-template-columns: 1fr;
        }

        .mc-element__stack {

            gap: 0px !important;
        }

        .mc-element__head {
            margin-top: 2% !important;
            text-align: left !important;
            margin-left: 7% !important;
            margin-bottom: -39px !important;
        }
    }

    /* ====== Section (Elemento) ====== */
    .mc-element {
        padding-top: 34px;
        width: 100%;
        height: calc((100dvh - var(--mc-nav-h)) * 1);

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

    }

    .mc-element__title {
        font-weight: 900;
        font-size: clamp(22px, 2.6vw, 40px);
        margin: 0;
        /*color: #f1872e;*/
        color: #f1872e00;


    }

    .mc-element__subtitle {
        margin-top: 4px;
        font-size: 14px;
        opacity: .75;

        font-weight: bold;
        /*color: #ffffff;*/
        color: #f1872e00;
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

    .mc-wheel__center.mc-wheel__center--exam {
        background: none !important;
        width: 100px !important;
        height: 100px !important;

    }

    img.mc-wheel__center-img.mc-wheel__center-img--exam {
        width: 100px !important;
        height: 100px !important;
        border-radius: 0px !important;
    }

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
    .mc-wheel__sector.is-active {
        //animation: mcSectorPulse 1.2s ease-in-out infinite;
    }
    .mc-wheel__svg.is-pulsing .mc-wheel__sector {
        animation: mcSectorPulse 1.2s ease-in-out infinite;
    }
    @keyframes mcSectorPulse {
        0% {
            filter: brightness(1);
        }
        50% {
            filter: brightness(1.25);
        }
        100% {
            filter: brightness(1);
        }
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
<style id="management-config-tools">
    div#content-body-canvas {

        padding-bottom: 18px;
        margin-bottom: 18px;
    }

    .mc-hub {
        max-width: 520px;
        margin: 0 auto;
    }

    .mc-pill-left {
        border-radius: 999px 0 0 999px;
    }

    .mc-pill-mid {
        border-radius: 0;
    }

    .mc-pill-right {
        border-radius: 0 999px 999px 0;
    }

    .mc-hub__search .form-control:focus {
        box-shadow: none;
    }

    .mc-hub__tabs .nav-link {
        color: #6c757d;
    }

    .mc-hub__tabs .nav-link.active {
        color: #dc3545;
    }

    /* rojo */

    .mc-card {
        border: 0;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
        background: #fff;
        padding: 0;
    }

    .mc-card:active {
        transform: scale(.99);
    }

    .mc-card__icon img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        display: block;
    }

    .mc-card__title {
        font-weight: 700;
        font-size: 16px;
    }

    .mc-card__sub {
        font-size: 10px;
    }

    .mc-bookmark {
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #f8f9fa;
        color: #adb5bd;
    }

    .mc-bookmark--on {
        color: #dc3545;
    }

    #content-body-canvas {
        height: 100dvh; /* o max-height: 90dvh si quieres que pueda ser menor */

    }

    div#other-data {
        height: 150px;
    }

    button#btn-return-process {
        left: -8px;
        z-index: 1500;
        top: -11px;
        position: fixed;
        font-size: 31px;
        border-color: #ffffff00;
        width: 60px;
        background-color: #ffffff00;
    }

    h1.mc-offcanvas-header__title {
        margin-left: 36px;
        font-weight: bold;
    }

    button#btn-return-process-grid {
        display: block !important;
        left: 2px;
        top: 9%;
        position: fixed;
        font-size: 21px;
        border-color: #ffffff;
        width: 54px;
        background-color: #ffffff;
    }

    .form-view-header .btn-close {
        right: 20px !important;
        top: 0% !important;
        position: fixed !important;
    }


    h1.mc-offcanvas-header__title {
        font-size: 21px;
        color: var(--secondary-color);
    }
</style>
<style id="number-convert-kichwa">
    .container--manager-number-convert {
        margin-left: 0% !important;

        margin-right: 0% !important;
    }

    @media (max-width: 560px) {
        .mc-panel {
            width: 400px !important;
            margin-left: 0% !important;
        }

        .mc-dict__card-head {
            display: block !important;
        }
    }
</style>
<style id="score">
    div#content-data {
        margin-top: 5px;
    }

    button.trophy.manager-score__item {
        border-left: 4px solid #ffffff !important;
        border-right: 4px solid #ffffff !important;
    }

    /* Contenedor: 2 columnas (4 ítems => 2x2) */
    .manager-score {

        background: #f08124;
        display: grid;
        grid-template-columns: repeat(3, 1fr);

    }

    /* Botón item: 3 elementos en columna */
    .manager-score__item {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 0;
        background: transparent;
        border-radius: 0px;
        cursor: pointer;
        text-align: center;
    }

    /* Imagen */
    .manager-score__img {
        width: 84px;
        height: 84px;
        object-fit: contain;
        display: block;
    }

    /* Título debajo del ícono */
    .manager-score__badge--title {
        color: #ffffff;
        display: block;
        max-width: 120px; /* ajusta según tu diseño */
        font-size: 18px;
        font-weight: 600;
        line-height: 1.1;

        /* ✅ evita que se rompa feo */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Cantidad al final */
    .manager-score__badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        min-width: 28px;
        height: 20px;
        padding: 0 8px;
        border-radius: 999px;

        min-width: 28px;
        font-weight: 700;
        line-height: 20px;
    }

    .manager-score__item {
        min-height: 110px;
    }
</style>
<style id="grid">
    .btn-close--modal.btn-close {
        background: none !important;
    }

    :root {
        --primary-color: #445EF2;
        --secondary-color: #f08124;
        --third-color: #225278;
        --font-size: 16px;
    }

    .pagination > .active > a {
        color: #e4e4e4;
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
    }

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
        color: var(--secondary-color) !important;
    }

    .text-left {

        font-size: 26px;
        text-align: left;
    }

    .text-left a {
        color: var(--third-color) !important;
        font-size: 28px;
        font-weight: bold;
    }

    .form-group {
        text-align: left;

    }

    select#typeDictionary {
        font-size: 21px;
    }

    label.form__label {
        color: var(--third-color);
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
        overflow-x: hidden !important;
    }

    .input-group-addon {
        font-size: 26px !important;
        color: #fff !important;
        background-color: var(--secondary-color) !important;
        border: 0 solid var(--secondary-color) !important;;
        border-radius: 0 !important;;
    }


    img.content-description__photos--img-row {
        margin-top: 69px;
        height: 130px;
        width: 100%;
    }

    .content-description__information-img {
        width: 8% !important;
    }

    .img-full {
        width: 70%;
    }


    .form-view-header {
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(.3rem - 1px);
        border-top-right-radius: calc(.3rem - 1px);
    }

    .form-view-title {
        margin-bottom: 0;
        line-height: 1.5;
    }

    .form-view-header .btn-close {
        padding: .5rem .5rem;
        margin: -.5rem -.5rem -.5rem auto;
    }

    .btn-close {
        box-sizing: content-box;
        width: 4em;
        height: 4em;
        padding: .25em .25em;
        color: #000;
        border: 0;
        border-radius: .25rem;
        opacity: .5;
    }

    span.btn-close__icon {
        color: var(--secondary-color);
        font-size: 35px;
        font-weight: bold;
    }

    .form-view-title {
        color: var(--secondary-color);
        font-weight: bold;
        font-size: 25px;
        margin-bottom: 0;
        line-height: 1.5;
    }


    .text-left {
        padding-bottom: 19px;

    }

    table#dictionary_by_words-grid {
        width: 100%;
    }

    table.manager-information {
        width: 100%;
    }

    tr.manager-information__tr {
        width: 100%;
    }

    .manager-information__td-information-title {
        font-size: 20px;
        font-weight: bold;
        color: #707070;
    }

    .manager-information__td-information-description {
        font-size: 14px;

        color: #8A8A8A;
    }

    td.manager-information__td-img {
        width: 9%;
    }

    td.manager-information__td-information {
        border-bottom: 2px solid #C8C8C8;
        padding-bottom: 1%;
    }

    @media screen and (min-width: 300px) and (max-width: 768px) {
        .table-responsive {

            border: 0 solid #ddd !important;
            overflow-y: unset !important;
        }

        .search {
            width: 100% !important;
        }

        .bootgrid-footer .search, .bootgrid-header .search {
            margin: 0 20px 13px 0 !important;
        }

        .intro-item.fl-wrap {
            padding-top: 35% !important;
        }

        .infoBar {
            margin-top: 54px !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            position: initial !important;
        }

        .pagination a {
            width: 30px !important;
            height: 30px !important;
            line-height: 16px !important;
        }

        .manager-information__td-information-title {
            font-size: 14px;
        }

        .manager-information__td-information-description {
            font-size: 10px;

        }

        img.content-description__photos--img-row {
            margin-top: 28px;
        }

        .img-full {
            width: 100%;
        }

        .form-view-title {

            font-size: 18px;
        }


    }

    .section-grid {
        padding: 0px 0;
    }

    .input-group span {
        padding: 6px 12px;
    }

    @media (max-width: 560px) {
        .container--manager-dictionary {

            padding: 0 0% 0 0% !important;

        }

        div#content-all-process {
            padding: 0rem !important;
        }

        .pagination a {
            line-height: 16px !important;
        }
    }

    .card-body {
        height: 297px;
    }
</style>

<style>
    .word-card__base.word-card__base--apuntes {
        font-size: 20px;
    }
    .word-card__icon {
        gap: 10px;
        display: flex;
        align-items: end;
        justify-content: end;
    }
    .word-card__icon {
        gap: 10px;
        display: flex;
        align-items: end;
        justify-content: end;
    }
    i.word-card__icon-i {
        transform: rotate(270deg);
        transition: transform 0.3s ease;
        font-size: 28px;
    }
</style>
