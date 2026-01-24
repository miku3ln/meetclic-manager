<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>


@include('partials.bootstrap-05',["allowCss"=>true])
<style>
    div#listing-items {
        margin-top: 2%;
    }
    footer.main-footer{
        z-index: 0 !important;
    }
    /* =========================
   BEM: filters-sheet
   Solo lo que BS5 no cubre
==========================*/
    .filters-sheet {
        width: 42vw;
        max-width: 42vw;
        min-width: 320px;
        background: #fff;
    }

    .filters-sheet__title {
        color: #4C4CFF;
        font-weight: 700;
        font-size: 2rem;
        line-height: 1;
    }

    .filters-sheet__reset {
        color: #4C4CFF;
        font-weight: 600;
        text-decoration: none;
    }

    .filters-sheet__card {
        border: 2px solid #cfd3ef;
        border-radius: 18px;
        box-shadow: 0 6px 18px rgba(25, 25, 60, .10);
    }

    .filters-sheet__icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        background: #EEF0FF;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4C4CFF;
        flex: 0 0 auto;
    }

    .filters-sheet__section-title {
        color: #4C4CFF;
        font-weight: 800;
        font-size: 1.75rem;
        margin: 1.25rem 0 .25rem;
    }

    .filters-sheet__help {
        color: #8a8aa0;
        margin: 0 0 .75rem;
    }

    .filters-sheet__badge-km {
        background: #EEF0FF;
        color: #4C4CFF;
        font-weight: 800;
        border-radius: 14px;
        padding: .6rem 1.1rem;
        display: inline-block;
        min-width: 90px;
        text-align: center;
    }

    /* Checkbox cuadrado más grande (en la captura se ve así) */
    .filters-sheet__check {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 2px solid #2f2f2f;
    }

    /* List item spacing similar a la captura */
    .filters-sheet__item {
        padding: 1.1rem 0;
        border: 0;
    }

    /* Range thumb (BS5 no controla el thumb visual) */
    .filters-sheet__range::-webkit-slider-thumb {
        background: #4C4CFF;
    }

    .filters-sheet__range::-moz-range-thumb {
        background: #4C4CFF;
    }
    button.button__category {
        color: #445ef2;
    }

    .filters-sheet__sublist.mt-3 {
        padding-left: 4%;
    }
    ul.manager-ul a ,.listing-geodir-category,.map-item{
        text-decoration: none !important;
    }

    .view-label {
        color: #ffc700;
    }
    .view-value {
        color: #445ef2 !important;
    }
    .filters__item-subcategory {
        padding-bottom: 13px;
    }
    .chat-widget-button-content{
        display:none;
    }
</style>

<style>
    .label-warning.pullkay__label-mode {
        background: rgba(255, 204, 0, 0.93) !important;;
        color: #ffffff !important;
        border: 1px solid rgba(255, 204, 0, 0.35) !important;;
    }

    .label-primary.pullkay__label-mode {
        background: rgba(76, 76, 255, 0.99) !important;
        color: #ffffff !important;
        border: 1px solid rgba(76, 76, 255, 0.25);
    }

    .pullkay__cta.btn {
        border-radius: 999px;
        padding: 13px 31% !important;
        font-weight: 800;
        border: 1px solid rgba(76, 76, 255, 0.22);
        background: rgba(76, 76, 255, 0.10);
        color: var(--mc-azulClic);
    }

    .card-listing .geodir-category-img img {
        width: 439px !important;
        height: 439px !important;
    }

    .limitations {
        text-align: right;
        margin-top: 8px;
        padding: 8px 10px;
        border-radius: 6px;
    }

    .limitations__row {
        display: block;
        margin: 6px 0;
        line-height: 1.3;
    }

    .limitations__icon {
        margin-right: 8px;
        opacity: 0.85;
    }

    /* Badge base */
    .limitations__badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 12px;
        font-weight: 600;
        display: inline-block;
    }

    /* Modifiers */
    .limitations__badge--ok {
        background: #e8f7ee;
        color: #1d6b3a;
    }

    .limitations__badge--info {
        background: #eaf2ff;
        color: #1b4d9b;
    }

    .limitations__badge--warn {
        background: #fff5e6;
        color: #8a5a00;
    }

    .limitations__badge--danger {
        background: #ffe9e9;
        color: #8a1f1f;
    }

    /* =========================================================
       REWARD (You earn +100 Yapitas) - MAKE IT OBVIOUS
       ========================================================= */
    .pullkay__reward {
        position: absolute;
        top: 30px;
        right: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 999px;
        background: rgba(255, 204, 0, 0.92);
        color: var(--mc-grisOscuro);
        font-weight: 900;
        box-shadow: 0 10px 18px rgba(255, 204, 0, 0.28);
        user-select: none;
    }

    .pullkay__reward-text {
        font-size: 11px;
        opacity: 0.9;
    }

    .pullkay__reward-value {
        font-size: 14px;
        line-height: 1;
    }

    .pullkay__reward-unit {
        font-size: 11px;
        opacity: 0.9;
    }

    /* If inactive, reward becomes softer */
    .pullkay-item[data-state="inactive"] .pullkay__reward {
        background: rgba(255, 204, 0, 0.45);
        box-shadow: none;
    }

    .card-listing .geodir-category-location a.map-item:before {

        right: auto !important;
        top: 30px !important;
    }

    .card-listing .geodir-category-content h3 {
        margin-top: 44px;
    }

    .card-listing .geodir-category-content p {

        padding-bottom: 29px !important;
    }

    span.geodir-category-location__location {
        color: var(--mc-azulClic);
    }

    .map-container #map-main {
        height: 100vh !important;

    }

    .map-container {
        height: 100vh !important;
    }

    .avatar-tooltip {
        background: #445ef2a1 !important;
    }

    .avatar-tooltip strong {
        color: #ffffff !important;
    }

    .leaflet-top.leaflet-left {
        top: 56px !important;
        left: auto;
        right: 21px !important;;
    }

    .leaflet-left {
        top: 23px !important;
        left: auto;
        right: 21px !important;;
    }

    .leaflet-top {
        top: 23px !important;
        left: auto;
        right: 21px !important;
    }

    .listing-item.list-layout .listing-avatar {
        position: absolute !important;
        margin-top: 9% !important;
        left: 0 !important;
        top: -26px !important;
    }

    .listings-loader {
        width: 100%;
        text-align: center;
        padding: 25px 0;
    }

    .listings-loader .loader-text {
        margin-top: 10px;
        font-size: 14px;
        opacity: .85;
    }

    .end-results {
        width: 100%;
        text-align: center;
        padding: 18px 0 28px;
        font-size: 14px;
        opacity: .85;
    }

    #limit-box-wrap {
        height: 1px; /* sentinel invisible */
    }


</style>
<style>


    /* Ajusta este valor a la altura real del header principal */
    :root {
        --main-header-height: 64px; /* ejemplo */
    }

    .back-to-filters.btf-l {
        top: 143px !important;
    }

    .listsearch {

        z-index: 15;
        position: relative;
        padding-bottom: 0;
        padding-top: 0;
    }

    /* Subheader secundario (no invasivo) */
    .listsearch__subheader {
        position: fixed;
        top: 7.99%;
        z-index: 90;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0.7% 14px;
        background: rgb(250 204 57 / 8%);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }


    /* Título */
    .listsearch__title {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.2;
    }

    .listsearch__title-text {
        display: inline-block;
    }

    /* Acciones */
    .listsearch__subheader-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Botón filtros */
    .listsearch__filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 8px 10px;

        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 10px;

        background: #ffffff;
        cursor: pointer;

        font-size: 13px;
        font-weight: 600;
    }

    .listsearch__filter-btn:hover {
        border-color: rgba(0, 0, 0, 0.22);
    }

    .listsearch__filter-icon {
        font-size: 14px;
    }

    .listsearch__filter-text {
        line-height: 1;
    }

    /* Contenido */
    .listsearch__content {
        padding: 10px 14px;
    }

    #app-management {
        scroll-padding-top: calc(var(--main-header-height) + 56px);
    }


    :root {
        --main-header-height: 64px; /* ajusta a tu header principal */
        --drawer-width: 100%;
    }

    /* Drawer */
    .filters-drawer {
        position: fixed;
        top: var(--main-header-height);
        bottom: 0;
        background: #fff;
        z-index: 1200;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .18);
        transform: translateX(110%);
        transition: transform .22s ease;
        display: flex;
        flex-direction: column;

        width: 46vw;
        max-width: 46vw;
        min-width: 320px;
    }

    .filters-drawer--right {
        right: 0;
    }

    .filters-drawer--left {
        left: 0;
        transform: translateX(-110%);
    }

    .filters-drawer--open.filters-drawer--right {
        transform: translateX(0);
    }

    .filters-drawer--open.filters-drawer--left {
        transform: translateX(0);
    }

    /* Header del drawer */
    .filters-drawer__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;

        padding: 12px 14px;
        border-bottom: 1px solid rgba(0, 0, 0, .08);
    }

    .filters-drawer__title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .filters-drawer__close {
        border: 0;
        background: transparent;
        cursor: pointer;
        font-size: 18px;
    }

    /* Body */
    .filters-drawer__body {
        padding: 12px 14px;
        overflow: auto;
        flex: 1;
    }

    .filters-drawer__section {
        margin-bottom: 12px;
    }

    .filters-drawer__label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    /* Backdrop */
    .filters-drawer__backdrop {
        position: fixed;
        top: var(--main-header-height);
        left: 0;
        right: 0;
        bottom: 0;

        z-index: 1190;
        background: rgba(0, 0, 0, .35);

        opacity: 0;
        pointer-events: none;
        transition: opacity .22s ease;
    }

    .filters-drawer__backdrop--open {
        opacity: 1;
        pointer-events: auto;
    }
</style>

<style>
    @media screen and (max-width: 1000px) {
        .card-listing .geodir-category-img img {
            width: 100% !important;
            height: 338px !important;
        }

        .geodir-category-content.fl-wrap {
            padding-top: 50px !important;
        }

        .pullkay__actions {
            padding-top: 14px ! important;
            padding-bottom: 14px ! important;
        }

        .pullkay__actions {
            margin-top: 21px !important;

        }

        .listing-item.list-layout .listing-avatar {
            top: -117px !important;
            margin-top: 0px !important;
            margin-right: 0px !important;
            right: 0 !important;
        }

        .listing-item.list-layout .listing-geodir-category {
            left: -3% !important;;
            margin-left: 20px !important;;
            top: -50px !important;;

        }

        .listing-item.list-layout .geodir-category-img, .listing-item.list-layout .geodir-category-content {
            width: 100% !important;

        }

        .pullkay__cta.btn {

            padding: 13px 38% !important;

        }

        .card-listing .geodir-category-location a.map-item:before {

            top: 54px !important;
        }

        .card-listing .geodir-category-content h3 {
            margin-top: 10px !important;
        }

        .pullkay__reward {

            top: 6px !important;
        }

        .card-listing .geodir-category-content h3 {

            font-size: 14.5px !important;
        }

        .map-container.column-map.right-pos-map {
            right: 0 !important;
            left: auto !important;
        }

        .map-container {
            float: right !important;
        }

        .left-list {
            float: left !important;
        }

        .listing-item.list-layout .listing-avatar {

            margin-top: 6% !important;

            top: -23px !important;
        }

        .avatar-tooltip {
            top: -29px !important;
            right: -194px !important;
        }

        .avatar-tooltip:after {
            top: 100%;
            right: 184px !important;
        }

        card-listing .listing-avatar:hover .avatar-tooltip {
            margin-top: 31px !important;
        }

        .listsearch__subheader {
            top: 9.99% !important;
            padding: 3% 14px !important;
        }

        .filters-drawer {
            top: 10% !important;
        }

        .filters-drawer{
            width: 100vw!important;
            max-width: 100vw!important;

        }
        .filters-sheet{
            margin-left: 12px;
            width: 100vw!important;
            max-width: 92vw!important;
        }
    }
</style>
