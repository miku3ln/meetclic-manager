<style>

    /* ============================================
       BUSINESS MAP MARKER
       BEM COMPONENT
       ============================================ */

    .business-map-marker-container {
        background: transparent !important;
        border: none !important;
    }

    /* BLOCK */
    .business-map-marker {
        --marker-size: 56px;
        --marker-border: 3px;
        --marker-color: #435cf0;

        position: relative;

        width: 100%;
        height: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: transparent;


        border: var(--marker-border) solid #ffffff;
        border-radius: 50%;

        box-shadow:
            0 3px 8px rgba(0, 0, 0, 0.20),
            0 1px 3px rgba(0, 0, 0, 0.12);

        box-sizing: border-box;

        cursor: pointer;

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            border-color 0.2s ease;
    }

    /* ELEMENT: IMAGE */
    .business-map-marker__image {
        display: block;

        width: 100% !important;
        height: 100% !important;

        min-width: 0;
        min-height: 0;

        max-width: none !important;
        max-height: none !important;

        object-fit: cover !important;
        object-position: center;

        border-radius: 50%;

        user-select: none;
        pointer-events: none;
    }

    /* ELEMENT: FALLBACK */
    .business-map-marker__fallback {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
        height: 100%;

        font-size: 25px;

        border-radius: 50%;

        background: #f2f4ff;
        color: #435cf0;

        pointer-events: none;
    }

    .business-map-marker__fallback[hidden],
    .business-map-marker__image[hidden] {
        display: none !important;
    }

    /* ELEMENT: COUNT */
    .business-map-marker__count {
        position: absolute;

        top: -8px;
        right: -8px;

        min-width: 24px;
        height: 24px;

        padding: 0 5px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #435cf0;
        color: #ffffff;

        border: 2px solid #ffffff;
        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;
        line-height: 1;

        box-sizing: border-box;

        z-index: 2;
        pointer-events: none;
    }

    /* MODIFIER: GROUPED */
    .business-map-marker--grouped {
        border-color: #435cf0;
    }

    /* HOVER */
    .business-map-marker-container:hover
    .business-map-marker {
        transform: scale(1.12);

        border-color: #435cf0;

        box-shadow:
            0 5px 14px rgba(0, 0, 0, 0.25);
    }

    /* ACCESSIBILITY */
    .business-map-marker-container:focus-visible
    .business-map-marker {
        outline: 3px solid #435cf0;
        outline-offset: 3px;
    }

    /* MOBILE */
    @media (max-width: 576px) {

        .business-map-marker__count {
            min-width: 21px;
            height: 21px;
            font-size: 10px;
        }

    }

    @media (prefers-reduced-motion: reduce) {

        .business-map-marker {
            transition: none;
        }

    }




    /* ==========================================
       MAP LAYOUT
       ========================================== */

    .business-map-layout {
        position: relative;
        width: 100%;
        height: 650px;
        overflow: hidden;
    }

    .business-map-layout__map {
        width: 100%;
        height: 100%;
    }

    /* ==========================================
       ASIDE BLOCK
       ========================================== */

    .business-map-aside {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;

        width: min(420px, 100%);

        background: #ffffff;

        box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);

        z-index: 1000;

        transform: translateX(105%);
        visibility: hidden;
        pointer-events: none;

        transition:
            transform 0.3s ease,
            visibility 0.3s ease;

        display: flex;
        flex-direction: column;
    }

    /* OPEN MODIFIER */

    .business-map-aside--open {
        transform: translateX(0);
        visibility: visible;
        pointer-events: auto;
    }

    /* DETAIL MODIFIER */

    .business-map-aside--detail {
        width: min(460px, 100%);
    }

    /* GROUP MODIFIER */

    .business-map-aside--group {
        width: min(380px, 100%);
    }

    /* CONTENT */

    .business-map-aside__content {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    /* CLOSE BUTTON */

    .business-map-aside__close {
        position: absolute;
        top: 12px;
        right: 12px;

        width: 36px;
        height: 36px;

        border: none;
        border-radius: 50%;

        background: #ffffff;
        color: #333333;

        font-size: 25px;
        line-height: 1;

        cursor: pointer;
        z-index: 5;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .business-map-aside__close:hover {
        background: #f1f2f6;
    }

    /* ==========================================
       RESPONSIVE
       ========================================== */

    @media (max-width: 767.98px) {

        .business-map-layout {
            height: 75dvh;
            min-height: 400px;
        }

        .business-map-aside,
        .business-map-aside--detail,
        .business-map-aside--group {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .business-map-aside {
            transition: none;
        }
    }

</style>

<style>

    /* =========================================================
       MASKANA - BUSINESS DETAILS UI / UX
       Mobile First
       ========================================================= */

    .business-map-layout {
        isolation: isolate;
    }

    .business-map-layout__map {
        position: relative;
        z-index: 1;
    }

    .business-map-aside {
        --bm-primary: #435cf0;
        --bm-primary-soft: #eef1ff;
        --bm-text: #1f2937;
        --bm-muted: #64748b;
        --bm-border: #e5eaf1;
        --bm-surface: #f7f9fc;

        color: var(--bm-text);
        font-family: inherit;
        font-size: 14px;
        line-height: 1.5;
    }

    .business-map-aside *,
    .business-map-aside *::before,
    .business-map-aside *::after {
        box-sizing: border-box;
    }

    .business-map-aside__content {
        background: #fff;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    .business-map-aside__close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        padding: 0;
        background: rgba(255,255,255,.96);
        color: #263246;
        border: 1px solid rgba(15,23,42,.08);
        border-radius: 50%;
        font-size: 25px;
        font-weight: 400;
        line-height: 1;
        z-index: 20;
        cursor: pointer;
        box-shadow: 0 3px 14px rgba(15,23,42,.14);
    }

    .business-map-aside__close:hover {
        background: #eef1ff;
        color: var(--bm-primary);
    }

    .business-map-aside :focus-visible {
        outline: 3px solid var(--bm-primary);
        outline-offset: 2px;
    }

    /* =========================================================
       DETAIL - HERO / HEADER
       ========================================================= */

    .business-detail {
        width: 100%;
        min-width: 0;
        background: #fff;
    }



    .business-detail__body {
        padding: 0 16px 28px;
    }

    .business-detail__header {
        padding: 20px 0 18px;
        border-bottom: 1px solid var(--bm-border);
    }


    .business-detail__title {
        margin: 0 0 10px;
        color: #172033;
        font-size: clamp(20px, 5vw, 25px);
        line-height: 1.22;
        font-weight: 750;
        letter-spacing: -.025em;
        overflow-wrap: anywhere;
    }



    /* =========================================================
       DETAIL - SECTIONS
       ========================================================= */

    .business-detail__section {
        padding: 20px 0;
        border-bottom: 1px solid var(--bm-border);
    }

    .business-detail__section:last-child {
        border-bottom: 0;
    }

    .business-detail__section-title {
        margin: 0 0 13px;
        color: #202d42;
        font-size: 15px;
        line-height: 1.35;
        font-weight: 750;
        letter-spacing: -.01em;
    }

    .business-detail__description,
    .business-detail__address {
        margin: 0;
        color: #526174;
        font-size: 13px;
        line-height: 1.75;
        overflow-wrap: anywhere;
        white-space: normal;
    }

    .business-detail__empty {
        margin: 0;
        padding: 13px 14px;
        background: var(--bm-surface);
        border: 1px dashed var(--bm-border);
        border-radius: 10px;
        color: var(--bm-muted);
        font-size: 12px;
    }

    /* =========================================================
       DETAIL - ACTION BUTTONS
       ========================================================= */

    .business-detail__actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 16px;
    }

    .business-detail__button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100%;
        min-height: 46px;
        padding: 11px 14px;
        border: 1px solid transparent;
        border-radius: 11px;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.3;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition:
            background .2s ease,
            border-color .2s ease,
            transform .2s ease;
    }

    .business-detail__button--primary {
        background: var(--bm-primary);
        border-color: var(--bm-primary);
        color: #fff;
    }

    .business-detail__button--primary:hover {
        background: #324bd4;
        color: #fff;
    }

    .business-detail__button--outline {
        background: #fff;
        color: var(--bm-primary);
        border-color: #cbd4ff;
    }

    .business-detail__button--outline:hover {
        background: var(--bm-primary-soft);
        color: #324bd4;
    }

    /* =========================================================
       DETAIL - CONTACT / SOCIAL
       ========================================================= */

    .business-detail__contact {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .business-detail__contact-link {
        display: flex;
        align-items: center;
        min-height: 46px;
        padding: 11px 13px;
        border: 1px solid var(--bm-border);
        border-radius: 11px;
        background: #fff;
        color: #34455e;
        font-size: 13px;
        font-weight: 550;
        line-height: 1.45;
        text-decoration: none;
        overflow-wrap: anywhere;
    }

    .business-detail__contact-link:hover {
        background: var(--bm-primary-soft);
        border-color: #cbd4ff;
        color: var(--bm-primary);
    }

    .business-detail__socials {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
    }

    .business-detail__social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 9px 14px;
        border: 1px solid #dce3ef;
        border-radius: 10px;
        background: var(--bm-surface);
        color: #34455e;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        overflow-wrap: anywhere;
    }

    .business-detail__social-link:hover {
        background: var(--bm-primary-soft);
        color: var(--bm-primary);
        border-color: #cbd4ff;
    }

    /* =========================================================
       DETAIL - BUSINESS HOURS
       ========================================================= */

    .business-detail__schedules {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid var(--bm-border);
        border-radius: 12px;
        background: #fff;
    }

    .business-detail__schedule {
        display: grid;
        grid-template-columns: minmax(75px, .8fr) minmax(0, 1.2fr);
        align-items: center;
        gap: 10px;
        min-height: 45px;
        padding: 11px 12px;
        border-bottom: 1px solid #edf0f5;
    }

    .business-detail__schedule:nth-child(even) {
        background: #f9faff;
    }

    .business-detail__schedule:last-child {
        border-bottom: none;
    }

    .business-detail__schedule-day {
        color: #334155;
        font-size: 12px;
        font-weight: 700;
    }

    .business-detail__schedule-time {
        color: #344bc6;
        font-size: 12px;
        font-weight: 650;
        line-height: 1.45;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .business-detail__schedule-time--empty {
        color: #94a3b8;
        font-weight: 450;
    }

    /* =========================================================
       DETAIL - COMMUNITY METRICS
       ========================================================= */

    .business-detail__community {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
    }

    .business-detail__community-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-width: 0;
        min-height: 86px;
        padding: 12px 6px;
        border: 1px solid #e2e8ff;
        border-radius: 12px;
        background: #f5f7ff;
        text-align: center;
    }

    .business-detail__community-value {
        color: #344bc6;
        font-size: clamp(17px, 4vw, 23px);
        font-weight: 800;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .business-detail__community-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 550;
        line-height: 1.3;
    }

    /* =========================================================
       GROUP - HEADER
       ========================================================= */

    .business-group {
        min-width: 0;
        padding-bottom: 22px;
    }

    .business-group__header {
        padding: 24px 18px 17px;
        background: #f7f9ff;
        border-bottom: 1px solid var(--bm-border);
    }

    .business-group__title {
        margin: 0 46px 7px 0;
        color: #172033;
        font-size: 19px;
        font-weight: 750;
        line-height: 1.3;
        letter-spacing: -.02em;
    }

    .business-group__subtitle {
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .business-group__list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 14px;
    }

    .business-group__empty {
        margin: 16px;
        padding: 16px;
        border: 1px dashed var(--bm-border);
        border-radius: 12px;
        background: var(--bm-surface);
        color: var(--bm-muted);
        font-size: 13px;
    }

    /* =========================================================
       GROUP - BUSINESS CARDS
       ========================================================= */

    .business-group__card {
        display: grid;
        grid-template-columns: 64px minmax(0, 1fr) 14px;
        align-items: center;
        gap: 11px;
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid var(--bm-border);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(15,23,42,.035);
        font: inherit;
        text-align: left;
        cursor: pointer;
        transition:
            border-color .2s ease,
            box-shadow .2s ease,
            transform .2s ease;
    }

    .business-group__card:hover {
        border-color: #b9c5ff;
        box-shadow: 0 5px 18px rgba(67,92,240,.10);
    }

    .business-group__card:active {
        transform: scale(.99);
    }

    .business-group__card-image {
        width: 64px;
        height: 64px;
        overflow: hidden;
        border-radius: 11px;
        background: #eef1ff;
    }

    .business-group__card-image img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .business-group__card-image img[hidden],
    .business-group__card-fallback[hidden] {
        display: none !important;
    }

    .business-group__card-fallback {
        display: grid;
        place-items: center;
        width: 100%;
        height: 100%;
        color: #435cf0;
        font-size: 27px;
    }

    .business-group__card-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
        min-width: 0;
    }

    .business-group__card-category {
        color: #435cf0;
        font-size: 10px;
        font-weight: 750;
        letter-spacing: .03em;
        text-transform: uppercase;
        overflow-wrap: anywhere;
    }

    .business-group__card-title {
        width: 100%;
        margin: 0;
        color: #1f2937;
        font-size: 14px;
        font-weight: 750;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .business-group__card-address {
        width: 100%;
        margin: 0;
        color: #64748b;
        font-size: 11px;
        line-height: 1.45;
        overflow-wrap: anywhere;
    }

    .business-group__card-rating {
        color: #a16207;
        font-size: 11px;
        font-weight: 650;
    }

    .business-group__card-arrow {
        color: #64748b;
        font-size: 23px;
        font-weight: 400;
        line-height: 1;
    }

    /* =========================================================
       SMALL MOBILE: UP TO 359px
       ========================================================= */

    @media (max-width: 359.98px) {

        .business-detail__body {
            padding-left: 12px;
            padding-right: 12px;
        }

        .business-detail__hero {
            height: 155px;
        }



        .business-detail__community {
            gap: 5px;
        }

        .business-detail__community-item {
            padding: 10px 4px;
        }

        .business-group__list {
            padding: 10px;
        }

        .business-group__card {
            grid-template-columns: 54px minmax(0, 1fr) 12px;
            gap: 8px;
            padding: 9px;
        }

        .business-group__card-image {
            width: 54px;
            height: 54px;
        }
    }

    /* =========================================================
       MOBILE: 360px - 767px
       ========================================================= */

    @media (min-width: 360px) and (max-width: 767.98px) {

        .business-detail__hero {
            height: clamp(170px, 26vh, 225px);
        }

        .business-detail__body {
            padding-left: 18px;
            padding-right: 18px;
        }

        .business-group__list {
            padding: 16px;
        }
    }

    /* =========================================================
       TABLET: 768px - 1199px
       ========================================================= */

    @media (min-width: 768px) and (max-width: 1199.98px) {

        .business-map-aside--detail {
            width: min(460px, 65%);
        }

        .business-map-aside--group {
            width: min(400px, 60%);
        }

        .business-detail__body {
            padding-left: 22px;
            padding-right: 22px;
        }

        .business-detail__hero {
            height: 230px;
        }

        .business-detail__actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .business-group__list {
            padding: 18px;
        }
    }

    /* =========================================================
       DESKTOP: 1200px+
       ========================================================= */

    @media (min-width: 1200px) {

        .business-map-aside--detail {
            width: 460px;
        }

        .business-map-aside--group {
            width: 400px;
        }

        .business-detail__body {
            padding-left: 24px;
            padding-right: 24px;
        }

        .business-detail__actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .business-detail__hero {
            height: 235px;
        }

        .business-group__list {
            padding: 18px;
        }
    }

    /* =========================================================
       ACCESSIBILITY
       ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .business-detail__button,
        .business-group__card {
            transition: none;
        }
    }





</style>
<style>

    /* ==========================================
       MANAGER MAP - FULL SCREEN
    ========================================== */

    html,
    body {
        margin: 0;
        min-height: 100%;
    }

    .manager-map {
        position: relative;
        width: 100%;
        height: 84.6dvh;
        overflow: hidden;
        padding: 0;
        margin: 0;
    }

    .manager-map .business-map-layout {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 0;
        overflow: hidden;
    }

    .manager-map .business-map-layout__map {
        position: absolute;
        inset: 0;

        width: 100%;
        height: 100%;

        z-index: 1;

        touch-action: none;
    }



    .manager-map__counter {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 11px 16px;
        background: #ffffff;
        border-radius: 50px;

        box-shadow: 0 5px 22px rgba(0, 0, 0, .12);

        font-size: 14px;
        color: #24372f;
        pointer-events: auto;
    }



    /* ==========================================
       BODY / CAMPOS
    ========================================== */

    .manager-filters__body {
        flex: 1;
        min-height: 0;

        padding: 22px;

        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .manager-filters__field {
        margin-bottom: 22px;
        text-align: left;
    }

    .manager-filters__label {
        display: block;

        margin-bottom: 9px;

        font-size: 13px;
        font-weight: 600;
        color: #33483b;
    }

    .manager-filters__input-wrap {
        position: relative;
    }

    .manager-filters__input-wrap > i {
        position: absolute;
        top: 50%;
        left: 15px;

        transform: translateY(-50%);

        color: #819087;
        pointer-events: none;
    }

    .manager-filters__input {
        display: block;
        width: 100%;
        min-height: 46px;

        padding: 11px 14px 11px 42px;

        border: 1px solid #dce4df;
        border-radius: 12px;

        background: #ffffff;
        color: #24382c;

        outline: none;
    }

    .manager-filters__input:focus {
        border-color: #287c5b;
        box-shadow: 0 0 0 3px rgba(40, 124, 91, .12);
    }

    .manager-filters__select {
        width: 100%;
    }

    /* ==========================================
       SELECT2 PERSONALIZADO
    ========================================== */

    .manager-filters .select2-container {
        width: 100% !important;
    }

    .manager-filters .select2-container
    .select2-selection--single {
        height: 46px;

        display: flex;
        align-items: center;

        border: 1px solid #dce4df;
        border-radius: 12px;
    }

    .manager-filters .select2-container
    .select2-selection__rendered {
        padding-left: 14px;
        padding-right: 32px;
        line-height: normal;
    }

    .manager-filters .select2-container
    .select2-selection__arrow {
        height: 44px;
        right: 8px;
    }

    /* ==========================================
       FOOTER
    ========================================== */

    .manager-filters__footer {
        display: flex;
        gap: 12px;

        padding: 18px 22px;

        border-top: 1px solid #e8ece9;
        background: #ffffff;
    }

    .manager-filters__reset,
    .manager-filters__apply {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        min-height: 46px;
        padding: 12px 16px;

        border-radius: 12px;

        font-size: 13px;
        font-weight: 600;

        cursor: pointer;
    }

    .manager-filters__reset {

        margin-left: 9%;
        width: 50%;
        border: 1px solid #dce4df;
        background: #ffcd02;
    }

    .manager-filters__apply {
        flex: 1;

        border: 0;
        background: #287c5b;
        color: #ffffff;
    }

    .manager-filters__apply:hover {
        background: #1c6045;
    }

    /* ==========================================
       MENSAJES Y LOADING
    ========================================== */

    .manager-map__message {
        position: absolute;
        top: 33%;
        left: 50%;

        transform: translateX(-50%);

        z-index: 700;
        max-width: min(500px, calc(100% - 32px));
    }

    .manager-map__loading {
        position: absolute;
        top: 50%;
        left: 50%;

        transform: translate(-50%, -50%);

        z-index: 1100;
    }

    @media (max-width: 767px) {
        .header-user-menu {
            right: 0px !important;
            top: 46px !important;
            margin-left: 219px;
            width: 124px;
    }

    .leaflet-top {
        top: 64% !important;
    }



    .manager-map__counter {
        padding: 9px 12px;
        font-size: 12px;
        left: 69%;
        position: absolute;
        top: 8px;
    }


    .manager-filters {
        top: auto;
        left: 0;
        right: 0;
        bottom: -29px;

        width: 100%;
        height: min(80dvh, 680px);

        border-radius: 22px 22px 0 0;

        transform: translateY(105%);
    }

    .manager-filters--open {
        transform: translateY(0);
    }

    .manager-filters__header {
        padding: 18px;
    }

    .manager-filters__body {
        padding: 18px;
    }

    .manager-filters__footer {
        padding: 14px 18px
        calc(31px + env(safe-area-inset-bottom));
    }

    .chat-widget-button {
        bottom: 138px!important;
        left: 10px !important;
    }
}

.content {
    padding-top: 16px!important;
}

#wrapper {

    padding-top: -1px !important;
}
footer.main-footer.dark-footer {
    display: none;
}
</style>
<style>

    /* ============================================
       RESPONSE DATA - BEM
    ============================================ */

    .response-data {
        width: 100%;
        margin-bottom: 1rem;
    }

    .response-data__content {
        width: 100%;
        min-height: 76px;
        padding: 14px 16px;
        border: 1px solid transparent;
        border-radius: 14px;
        transition: background-color 0.2s ease;
    }

    /* SUCCESS */

    .response-data__content--success {
        background-color: #edf8f1;
        border-color: #c8e9d3;
    }

    .response-data__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        font-size: 1.25rem;
    }

    .response-data__icon--success {
        color: #198754;
        background-color: #d6f0df;
    }

    .response-data__count {
        color: #146c43;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .response-data__message {
        color: #64748b;
        font-size: 0.82rem;
        line-height: 1.4;
        margin-top: 3px;
    }

    .response-data__status-icon {
        color: #198754;
        font-size: 1.1rem;
    }

    /* EMPTY */

    .response-data__content--empty {
        background-color: #fff8eb;
        border-color: #f4dfb8;
    }

    .response-data__icon--empty {
        color: #b7791f;
        background-color: #fff0cf;
    }

    .response-data__title {
        color: #92400e;
        font-size: 0.9rem;
        font-weight: 600;
        line-height: 1.3;
    }

    /* MOBILE */

    @media (max-width: 575.98px) {

        .response-data__content {
            min-height: 68px;
            padding: 12px;
            gap: 10px !important;
        }

        .response-data__icon {
            width: 38px;
            height: 38px;
            font-size: 1.1rem;
        }

        .response-data__count {
            font-size: 1.3rem;
        }

        .response-data__message {
            font-size: 0.78rem;
        }
    }

    /* ============================================
       RESPONSE DATA - MAP HINT
    ============================================ */

    .response-data__hint {
        width: 100%;
        padding: 12px 14px;
        background-color: #f0f7ff;
        border: 1px solid #d7e8fc;
        border-radius: 12px;
    }

    .response-data__hint-icon {
        color: #0d6efd;
        font-size: 1rem;
        line-height: 1.4;
    }

    .response-data__hint-info {
        flex: 1;
        min-width: 0;
    }

    .response-data__hint-title {
        color: #1d4e89;
        font-size: 0.85rem;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 4px;
    }

    .response-data__hint-message {
        color: #526579;
        font-size: 0.8rem;
        line-height: 1.5;
    }

    @media (max-width: 575.98px) {
        .response-data__hint {
            padding: 10px 12px;
        }

        .response-data__hint-title {
            font-size: 0.82rem;
        }

        .response-data__hint-message {
            font-size: 0.77rem;
        }


    }

</style>
<style>
    .maskana-map-wrapper {
        position: relative;
    }

    .maskana-location-button {
        position: absolute;
        right: 16px;
        bottom: 100px;
        z-index: 1000;

        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #e2e8f0;
        border-radius: 50%;

        background: #ffffff;
        color: #2563eb;

        font-size: 22px;
        cursor: pointer;

        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);

        transition: transform .2s, background .2s;
    }

    .maskana-location-button:hover:not(:disabled) {
        transform: scale(1.06);
    }

    .maskana-location-button.is-denied {
        color: #dc2626;
        background: #fef2f2;
        cursor: not-allowed;
        opacity: .85;
    }

    .maskana-location-button.is-pending {
        color: #64748b;
    }

    .maskana-location-button.is-granted {
        color: #2563eb;
    }

    .maskana-location-button.is-loading {
        cursor: wait;
        opacity: .65;
    }

    .maskana-user-location-marker {
        background: transparent;
        border: none;
    }

    .maskana-user-location-dot {
        display: block;
        width: 18px;
        height: 18px;
        background: #2563eb;
        border: 3px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 0 0 5px rgba(37, 99, 235, .18);
    }





    /* ==========================================
       MASKANA - USER PUMPKIN MARKER
    ========================================== */

    .maskana-user-location-marker {
        background: transparent !important;
        border: none !important;
    }

    .maskana-user-pumpkin {
        position: relative;
        width: 64px;
        height: 64px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .maskana-user-pumpkin__emoji {
        position: relative;
        z-index: 2;

        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #fff;
        border: 3px solid #f97316;
        border-radius: 50%;

        font-size: 29px;

        box-shadow: 0 4px 14px rgba(0, 0, 0, .22);

        animation: maskana-pumpkin-float 2s ease-in-out infinite;
    }

    .maskana-user-pumpkin__pulse {
        position: absolute;
        inset: 2px;

        background: rgba(249, 115, 22, .2);
        border: 2px solid rgba(249, 115, 22, .5);
        border-radius: 50%;

        animation: maskana-pumpkin-pulse 2.4s ease-out infinite;
    }

    .maskana-user-pumpkin__label {
        position: absolute;
        top: 57px;
        left: 50%;
        transform: translateX(-50%);

        white-space: nowrap;

        background: #fff;
        color: #1f2937;

        padding: 5px 10px;
        border-radius: 20px;

        font-size: 11px;
        font-weight: 700;

        box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    }

    /* Movimiento suave de la calabaza */
    @keyframes maskana-pumpkin-float {
        0%, 100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    /* Halo de ubicación */
    @keyframes maskana-pumpkin-pulse {
        0% {
            transform: scale(.6);
            opacity: .8;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .maskana-user-pumpkin__emoji,
        .maskana-user-pumpkin__pulse {
            animation: none;
        }
    }

</style>


<style id="new-details-business">

    /* ============================================
       YAPITA - BUSINESS DETAIL
       ============================================ */

    .business-detail {
        --bd-primary: #3264ff;
        --bd-dark: #111f44;
        --bd-muted: #77849d;
        --bd-card: #f5f7ff;
        --bd-border: #e1e8f7;

        width: 100%;
        background: #fff;
        color: var(--bd-dark);
        font-family: inherit;
    }

    .business-detail *,
    .business-detail *::before,
    .business-detail *::after {
        box-sizing: border-box;
    }

    /* HERO */

    .business-detail__hero {
        width: 100%;
        height: clamp(180px, 34vw, 300px);
        background: #edf1fa;
        overflow: hidden;
    }

    .business-detail__hero-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .business-detail__hero-fallback {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        font-size: 64px;
        color: var(--bd-primary);
    }

    .business-detail__hero-fallback[hidden] {
        display: none;
    }

    .business-detail__body {
        padding: 0 24px 24px;
    }

    /* IDENTIDAD */

    .business-detail__header {
        padding: 0 4px 14px;
    }

    .business-detail__category {
        display: inline-block;
        position: relative;
        margin-top: -15px;
        padding: 8px 15px;
        background: #e8edff;
        border-radius: 24px;
        color: var(--bd-primary);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .business-detail__title {
        margin: 12px 0 6px;
        font-size: clamp(24px, 4vw, 32px);
        font-weight: 750;
        color: var(--bd-dark);
    }

    .business-detail__rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: #aa6508;
        font-size: 14px;
        font-weight: 600;
    }

    /* CONTACTOS */

    .business-detail__contacts {
        display: flex;
        align-items: flex-start;
        justify-content: space-around;
        gap: 8px;
        padding: 12px 0 22px;
    }

    .business-detail__contact-item {
        display: flex;
        flex: 1;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        min-width: 0;
        color: var(--bd-dark);
        text-decoration: none;
    }

    .business-detail__contact-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        color: #fff;
        font-size: 25px;
        box-shadow: 0 4px 12px #263b6c1c;
        transition: transform .2s;
    }

    .business-detail__contact-item:hover .business-detail__contact-icon {
        transform: translateY(-3px);
    }

    .business-detail__contact-item--whatsapp .business-detail__contact-icon {
        background: #19c66b;
    }

    .business-detail__contact-item--phone .business-detail__contact-icon {
        background: #3068ff;
    }

    .business-detail__contact-item--email .business-detail__contact-icon {
        background: #ff416d;
    }

    .business-detail__contact-item--website .business-detail__contact-icon {
        background: #9854f5;
    }

    .business-detail__contact-label {
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }

    /* DIRECCIÓN */

    .business-detail__location {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px;
        margin-bottom: 18px;
        background: var(--bd-card);
        border-radius: 18px;
    }

    .business-detail__location-info {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .business-detail__location-icon {
        color: var(--bd-primary);
        font-size: 28px;
    }

    .business-detail__location-text {
        min-width: 0;
    }

    .business-detail__location-text h3 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
    }

    .business-detail__location-text p {
        margin: 0;
        color: var(--bd-muted);
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .business-detail__map-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-shrink: 0;
        padding: 12px 16px;
        background: var(--bd-primary);
        color: #fff;
        border: 0;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 650;
        cursor: pointer;
    }

    .business-detail__map-button:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    /* TABS */

    .business-detail__tabs {
        display: flex;
        gap: 3px;
        width: 100%;
        margin-bottom: 18px;
        border-bottom: 1px solid var(--bd-border);
        overflow-x: auto;
        scrollbar-width: none;
    }

    .business-detail__tabs::-webkit-scrollbar {
        display: none;
    }

    .business-detail__tab {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        flex: 1 0 auto;
        min-height: 46px;
        padding: 12px 10px;
        background: transparent;
        color: var(--bd-muted);
        border: 0;
        border-bottom: 3px solid transparent;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
    }

    .business-detail__tab i {
        font-size: 17px;
    }

    .business-detail__tab--active {
        color: var(--bd-primary);
        border-bottom-color: var(--bd-primary);
    }

    .business-detail__panel[hidden] {
        display: none !important;
    }

    .business-detail__panel-header {
        margin-bottom: 16px;
    }

    .business-detail__panel-header h3 {
        margin: 0 0 4px;
        font-size: 20px;
        font-weight: 750;
    }

    .business-detail__panel-header p {
        margin: 0;
        color: var(--bd-muted);
        font-size: 14px;
    }

    /* TARJETAS DE INFORMACIÓN */

    .business-detail__card {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 20px;
        margin-bottom: 14px;
        background: var(--bd-card);
        border-radius: 18px;
    }

    .business-detail__card-icon {
        flex-shrink: 0;
        color: var(--bd-primary);
        font-size: 24px;
    }

    .business-detail__card-content {
        flex: 1;
        min-width: 0;
    }

    .business-detail__card-content h3 {
        margin: 0 0 8px;
        font-size: 17px;
        font-weight: 700;
    }

    .business-detail__card-content p {
        margin: 0;
        color: var(--bd-muted);
        font-size: 14px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .business-detail__socials {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .business-detail__social-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--bd-primary);
        font-size: 13px;
        text-decoration: none;
    }

    /* COMUNIDAD */

    .business-detail__community-card {
        padding: 20px;
        background: var(--bd-card);
        border-radius: 18px;
    }

    .business-detail__community-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 18px;
        font-size: 17px;
        font-weight: 700;
    }

    .business-detail__community-title i {
        color: var(--bd-primary);
        font-size: 23px;
    }

    .business-detail__community {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .business-detail__community-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 8px;
        border-right: 1px solid var(--bd-border);
    }

    .business-detail__community-item:last-child {
        border-right: 0;
    }

    .business-detail__community-item > i {
        font-size: 24px;
    }

    .business-detail__community-item strong,
    .business-detail__community-item span {
        display: block;
    }

    .business-detail__community-item strong {
        font-size: 20px;
    }

    .business-detail__community-item span {
        color: var(--bd-muted);
        font-size: 12px;
    }

    .business-detail__community-icon--heart {
        color: #ff3976;
    }

    .business-detail__community-icon--eye {
        color: #3472ff;
    }

    .business-detail__community-icon--trophy {
        color: #f5b400;
    }

    /* PROMOCIONES */

    .business-detail__promotions {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .business-detail__promotion {
        width: 100%;
        border: 1px solid var(--bd-border);
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
    }

    .business-detail__promotion-action {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        padding: 10px;
        background: transparent;
        border: 0;
        color: inherit;
        text-align: left;
        cursor: pointer;
    }

    .business-detail__promotion-action:hover {
        background: #f8faff;
    }

    .business-detail__promotion-image-wrap {
        display: block;
        flex: 0 0 36%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        border-radius: 12px;
        background: #eef2fa;
    }

    .business-detail__promotion-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .business-detail__promotion-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: var(--bd-muted);
        font-size: 28px;
    }

    .business-detail__promotion-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .business-detail__promotion-name {
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        font-size: 15px;
        line-height: 1.35;
        font-weight: 700;
    }

    .business-detail__promotion-description {
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        color: var(--bd-muted);
        font-size: 12px;
        line-height: 1.4;
    }

    .business-detail__promotion-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 650;
    }

    .business-detail__promotion-status i {
        font-size: 9px;
    }

    .business-detail__promotion-status--active {
        color: #11a85c;
    }

    .business-detail__promotion-status--inactive {
        color: #8993a4;
    }

    .business-detail__promotion-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--bd-muted);
        font-size: 11px;
    }

    .business-detail__promotion-arrow {
        color: #8c96aa;
        font-size: 20px;
    }

    /* VISOR DE PUBLICIDAD */

    .business-detail__viewer {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(8, 15, 32, .82);
    }

    .business-detail__viewer-container {
        position: relative;
        display: flex;
        flex-direction: column;
        width: min(100%, 680px);
        max-height: 95dvh;
        padding: 16px;
        background: #fff;
        border-radius: 18px;
        overflow-y: auto;
    }

    .business-detail__viewer-close {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        border: 0;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 12px #0002;
        cursor: pointer;
    }

    .business-detail__viewer-content {
        display: flex;
        justify-content: center;
        min-height: 0;
    }

    .business-detail__viewer-image {
        display: block;
        width: auto;
        max-width: 100%;
        max-height: 72dvh;
        object-fit: contain;
        border-radius: 10px;
    }

    .business-detail__viewer-information {
        padding: 16px 4px 4px;
    }

    .business-detail__viewer-information h3 {
        margin: 0 0 6px;
        font-size: 20px;
        font-weight: 700;
    }

    .business-detail__viewer-information p {
        margin: 0;
        color: var(--bd-muted, #77849d);
        font-size: 14px;
        line-height: 1.5;
    }

    /* RESPONSIVE */

    @media (max-width: 575.98px) {
        .business-detail__hero {
            height: 200px;
        }

        .business-detail__body {
            padding: 0 14px 20px;
        }

        .business-detail__contact-icon {
            width: 48px;
            height: 48px;
            font-size: 22px;
        }

        .business-detail__contacts {
            gap: 4px;
        }

        .business-detail__location {
            gap: 10px;
            padding: 12px;
        }

        .business-detail__location-icon {
            font-size: 22px;
        }

        .business-detail__location-text h3 {
            font-size: 14px;
        }

        .business-detail__location-text p {
            font-size: 12px;
        }

        .business-detail__map-button {
            padding: 11px 9px;
            font-size: 11px;
        }

        .business-detail__tab {
            gap: 5px;
            padding: 12px 9px;
            font-size: 12px;
        }

        .business-detail__tab i {
            font-size: 15px;
        }

        .business-detail__promotion-action {
            gap: 9px;
        }

        .business-detail__promotion-image-wrap {
            flex-basis: 38%;
        }

        .business-detail__promotion-name {
            font-size: 13px;
        }

        .business-detail__promotion-arrow {
            font-size: 15px;
        }

        .business-detail__community-card {
            padding: 14px 8px;
        }

        .business-detail__community-item {
            gap: 6px;
            padding: 5px;
        }

        .business-detail__community-item > i {
            font-size: 20px;
        }
    }



</style>

<style>
    <style>
        /* ================================================
           MASKANA - ANIMACIÓN REBOTE + PULSO
           ================================================ */

        /* ================================================
           1. CONTENEDOR PRINCIPAL
           ================================================ */

    .business-map-marker {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: visible;
        background: transparent;
    }

    .business-map-marker__bounce-content {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: visible;
        background: transparent;
    }

    /* ================================================
       2. SALTO DEL MARCADOR COMPLETO
       ================================================ */

    /*
     * El contenedor principal controla el salto.
     * Todo su contenido se mueve junto:
     * - Imagen
     * - Halo
     * - Ondas
     * - Badge
     */

    .business-map-marker--pumpkin-bounce {
        transform-origin: center bottom;

        animation:
            business-map-marker-jump
            2.8s
            ease-in-out
            infinite;
    }

    @keyframes business-map-marker-jump {

        0%,
        10%,
        55%,
        80%,
        100% {
            transform: translateY(0);
        }

        25% {
            transform: translateY(-12px);
        }

        38% {
            transform: translateY(-17px);
        }

        67% {
            transform: translateY(-5px);
        }
    }

    /* ================================================
       3. COMPRESIÓN Y ESTIRAMIENTO
       ================================================ */

    /*
     * El contenido NO vuelve a saltar.
     * Únicamente cambia ligeramente su escala.
     */

    .business-map-marker--pumpkin-bounce
    .business-map-marker__bounce-content {

        transform-origin: center bottom;

        animation:
            business-map-marker-squash
            2.8s
            ease-in-out
            infinite;
    }

    @keyframes business-map-marker-squash {

        0%,
        100% {
            transform: scale(1, 1);
        }

        10% {
            transform: scale(1.06, .94);
        }

        25% {
            transform: scale(.97, 1.03);
        }

        38% {
            transform: scale(1, 1);
        }

        55% {
            transform: scale(1.07, .93);
        }

        67% {
            transform: scale(.99, 1.01);
        }

        80% {
            transform: scale(1, 1);
        }
    }

    /* ================================================
       4. ONDAS DE PULSO
       ================================================ */

    .business-map-marker__pulse-wave {

        position: absolute;
        inset: 0;

        width: 100%;
        height: 100%;

        border-radius: 50%;

        border: 3px solid rgba(131, 54, 232, .7);

        background: rgba(131, 54, 232, .13);

        pointer-events: none;

        z-index: 0;

        opacity: 0;

        box-sizing: border-box;

        animation:
            business-map-marker-pulse
            2.8s
            ease-out
            infinite;
    }

    /* Segunda onda */

    .business-map-marker__pulse-wave--delayed {
        animation-delay: 1.4s;
    }

    /* Expansión radial */

    @keyframes business-map-marker-pulse {

        0% {
            transform: scale(.85);
            opacity: .75;
        }

        65% {
            opacity: .25;
        }

        100% {
            transform: scale(2.1);
            opacity: 0;
        }
    }

    /* ================================================
       5. ORDEN VISUAL
       ================================================ */

    .business-map-marker--pumpkin-bounce
    .business-map-marker__image,

    .business-map-marker--pumpkin-bounce
    .business-map-marker__fallback {

        position: relative;
        z-index: 1;
    }

    /* Badge por encima */

    .business-map-marker--pumpkin-bounce
    .business-map-marker__news {
        z-index: 3;
    }

    /* ================================================
       6. INTERACCIONES
       ================================================ */

    /*
     * Pausar todas las animaciones juntas.
     */

    .business-map-marker-container:hover
    .business-map-marker--pumpkin-bounce,

    .business-map-marker-container:hover
    .business-map-marker__bounce-content,

    .business-map-marker-container:hover
    .business-map-marker__pulse-wave {

        animation-play-state: paused;
    }

    /* ================================================
       7. LEAFLET
       ================================================ */

    .business-map-marker-container {
        background: transparent !important;
        border: none;
        overflow: visible !important;
    }

    /* ================================================
       8. ACCESIBILIDAD
       ================================================ */

    @media (prefers-reduced-motion: reduce) {

        .business-map-marker--pumpkin-bounce,

        .business-map-marker--pumpkin-bounce
        .business-map-marker__bounce-content {

            animation: none;
        }

        .business-map-marker__pulse-wave {
            animation: none;
            display: none;
        }
    }
</style>
</style>
<style id="filters-content">
    /* ========================================
    CONTENEDOR DE RUTAS
 ======================================== */

    .routes-container {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 6px;

        width: 100%;
        min-width: 0;
        box-sizing: border-box;

        padding: 8px 0;

        overflow: visible;
    }

    /* ========================================
       TARJETA
    ======================================== */

    .routes-container__item {
        position: relative;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        width: 100%;
        min-width: 0;
        min-height: 82px;

        gap: 5px;
        padding: 8px 3px;

        box-sizing: border-box;

        background: #ffffff;

        border: 1px solid color-mix(
            in srgb,
            var(--route-color) 35%,
            white
        );

        border-radius: 13px;

        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);

        cursor: pointer;
        transition: border-color .2s, background .2s;
    }

    /* ========================================
       IMAGEN
    ======================================== */

    .routes-container__image-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 43px;
        height: 43px;

        flex-shrink: 0;
        padding: 2px;
        box-sizing: border-box;

        border: 2px solid var(--route-color);
        border-radius: 50%;
        background: #ffffff;
    }

    .routes-container__image {
        width: 100%;
        height: 100%;

        display: block;
        object-fit: cover;
        border-radius: 50%;
    }

    /* ========================================
       TÍTULO
    ======================================== */

    .routes-container__title {
        display: -webkit-box;
        width: 100%;

        font-size: 10px;
        font-weight: 600;
        line-height: 12px;
        text-align: center;

        color: #374151;

        white-space: normal;
        overflow: hidden;
        overflow-wrap: anywhere;

        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
    }

    /* ========================================
       SELECCIONADO
    ======================================== */

    .routes-container__item--active {
        border: 2px solid var(--route-color);

        background: color-mix(
            in srgb,
            var(--route-color) 5%,
            white
        );
    }

    .routes-container__item--active .routes-container__title {
        color: var(--route-color);
        font-weight: 700;
    }

    .routes-container__indicator {
        position: absolute;
        bottom: 0;
        left: 50%;

        transform: translateX(-50%);

        width: 25px;
        height: 3px;

        background: var(--route-color);
        border-radius: 3px 3px 0 0;
    }

    /* ========================================
       ESCRITORIO
    ======================================== */

    @media (min-width: 768px) {
        .routes-container {
            gap: 10px;
        }

        .routes-container__item {
            min-height: 94px;
            padding: 10px 6px;
        }

        .routes-container__image-wrapper {
            width: 50px;
            height: 50px;
        }

        .routes-container__title {
            font-size: 11px;
            line-height: 14px;
        }
    }
    /* ========================================
   CHECK DE RUTA SELECCIONADA
======================================== */

    .routes-container__check {
        position: absolute;
        top: -7px;
        right: -7px;
        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 25px;
        height: 25px;

        background: var(--route-color);
        color: #ffffff;

        border: 3px solid #ffffff;
        border-radius: 50%;

        box-sizing: border-box;

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.20);

        pointer-events: none;
    }

    .routes-container__check i {
        font-size: 11px;
        line-height: 1;
    }

    /* ========================================
   YAPITA REGISTER BANNER
======================================== */

    .yapita-register {
        z-index: 2;
        top: 0;
        position: absolute;
        display: flex;
        align-items: center;
        gap: 12px;

        width: 100%;
        min-width: 0;
        box-sizing: border-box;

        padding: 14px 16px;

        background: #fce7f3;
        border: 1px solid #fce7f3;
        border-radius: 16px;
    }

    /* ========================================
       ICONO REGALO
    ======================================== */

    .yapita-register__icon {
        display: flex;
        align-items: center;
        justify-content: center;

        flex: 0 0 54px;
        width: 54px;
        height: 54px;

        color: #e11d48;
        font-size: 42px;
        line-height: 1;
    }

    /* ========================================
       CONTENIDO
    ======================================== */

    .yapita-register__content {
        flex: 1;
        min-width: 0;
    }

    .yapita-register__title {
        margin: 0 0 3px;

        color: #be123c;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.3;
    }

    .yapita-register__description {
        margin: 0;

        color: #64748b;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.4;
    }

    /* ========================================
       BOTÓN ACCIÓN
    ======================================== */

    .yapita-register__action {
        display: flex;
        align-items: center;
        justify-content: center;

        flex: 0 0 36px;
        width: 36px;
        height: 36px;

        padding: 0;

        color: #db2777;
        background: #fbcfe8;

        border: none;
        border-radius: 50%;

        font-size: 20px;
        cursor: pointer;

        transition:
            background .2s ease,
            transform .2s ease;
    }

    .yapita-register__action:hover {
        background: #f9a8d4;
        transform: translateX(2px);
    }

    .yapita-register__action:focus-visible {
        outline: 2px solid #be185d;
        outline-offset: 3px;
    }

    /* ========================================
       MÓVIL
    ======================================== */

    @media (max-width: 480px) {

        .yapita-register {
            gap: 4px;
            padding: 0 0;
            border-radius: 0;
        }

        .yapita-register__icon {
            flex-basis: 42px;
            width: 42px;
            height: 42px;
            font-size: 35px;
        }

        .yapita-register__title {
            font-size: 13px;
        }

        .yapita-register__description {
            font-size: 11px;
            line-height: 1.4;
        }

        .yapita-register__action {
            flex-basis: 30px;
            width: 30px;
            height: 30px;
            font-size: 16px;
        }
    }
</style>
<style id="custom-template">
    .chat-widget-button {
        background: #FACC39!important;
    }
</style>

<style id="yapita-reguster-modal">
    section.yapita-register-hero {
        padding-top: 0px;
        padding-bottom: 0px;
    }

    /* =====================================================
       YAPITA REGISTER MODAL
       BEM / MOBILE FIRST / BOOTSTRAP 5.3.8
    ===================================================== */

    #yapitaRegisterModal {
        --yr-primary: #111b60;
        --yr-yellow: #ffd600;
        --yr-blue: #0866ff;
        --yr-border: #dce1e9;
        --yr-muted: #778299;
        --yr-radius: 20px;

        --bs-modal-width: 390px;

        padding: 0 !important;
        color: var(--yr-primary);
        font-family: inherit;
    }

    #yapitaRegisterModal *,
    #yapitaRegisterModal *::before,
    #yapitaRegisterModal *::after {
        box-sizing: border-box;
    }

    /* =====================================================
       MODAL CONTAINER
    ===================================================== */

    #yapitaRegisterModal .modal-dialog {
        width: calc(100% - 24px);
        max-width: 390px;
        margin: 12px auto;
    }

    #yapitaRegisterModal .yapita-register-modal__content {
        position: relative;
        display: flex;
        flex-direction: column;

        width: 100%;
        min-width: 0;
        max-height: calc(100dvh - 24px);

        padding: 0;
        margin: 0;

        background: #ffffff;
        border: 0;
        border-radius: 22px;

        overflow: hidden;
        box-shadow: 0 20px 65px rgba(12, 20, 60, .24);
    }

    #yapitaRegisterModal .yapita-register-modal__body {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-start;

        width: 100%;
        min-width: 0;
        min-height: 0;

        padding: 0 16px 20px;
        margin: 0;

        overflow-x: hidden;
        overflow-y: auto;
        overscroll-behavior: contain;
        scrollbar-width: thin;
    }

    #yapitaRegisterModal .yapita-register-modal__body > * {
        flex: 0 0 auto;
        width: 100%;
        min-width: 0;
        max-width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    /* CLOSE BUTTON */

    #yapitaRegisterModal .yapita-register-modal__close {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 36px;
        height: 36px;

        padding: 0;
        border: 0;
        border-radius: 50%;

        background: rgba(245, 247, 252, .96);
        color: #26334c;

        font-size: 18px;
        line-height: 1;
        cursor: pointer;

        transition: background .2s, transform .2s;
    }

    #yapitaRegisterModal .yapita-register-modal__close:hover {
        background: #e8edfa;
        transform: rotate(90deg);
    }

    /* =====================================================
       HERO
    ===================================================== */

    #yapitaRegisterModal .yapita-register-hero {
        display: block;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    #yapitaRegisterModal .yapita-register-hero__image-wrapper {
        position: relative;
        width: calc(100% + 32px);
        aspect-ratio: 16 / 7;

        margin: 0 -16px;
        overflow: hidden;

        background: #f1e8ff;
    }

    #yapitaRegisterModal .yapita-register-hero__image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    #yapitaRegisterModal .yapita-register-hero__content {
        width: 100%;
        padding: 12px 4px 0;
        margin: 0;
    }

    #yapitaRegisterModal .yapita-register-hero__title {
        display: block;
        margin: 0 0 5px;
        padding: 0;

        color: var(--yr-primary);
        font-size: 24px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.5px;
        text-align: center;
    }

    #yapitaRegisterModal .yapita-register-hero__description {
        margin: 0;
        padding: 0;

        color: var(--yr-primary);
        font-size: 13px;
        font-weight: 450;
        line-height: 1.45;
        text-align: center;
    }

    /* =====================================================
       BENEFITS
    ===================================================== */

    #yapitaRegisterModal .yapita-register-benefits {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;

        width: 100%;
        margin: 0;
        padding: 18px 0 17px;
    }

    #yapitaRegisterModal .yapita-register-benefits__item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        gap: 6px;

        min-width: 0;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    #yapitaRegisterModal .yapita-register-benefits__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 34px;
        height: 34px;

        font-size: 26px;
        line-height: 1;
    }

    #yapitaRegisterModal .yapita-register-benefits__icon--pink {
        color: #f72570;
    }

    #yapitaRegisterModal .yapita-register-benefits__icon--yellow {
        color: #f5a400;
    }

    #yapitaRegisterModal .yapita-register-benefits__icon--blue {
        color: #0866ff;
    }

    #yapitaRegisterModal .yapita-register-benefits__label {
        display: block;
        width: 100%;
        margin: 0;

        color: var(--yr-primary);
        font-size: 11px;
        font-weight: 650;
        line-height: 1.35;
        text-align: center;
    }

    /* =====================================================
       REGISTER FORM
    ===================================================== */

    #yapitaRegisterModal .yapita-register-form {
        display: flex;
        flex-direction: column;
        gap: 9px;

        width: 100%;
        padding: 0;
        margin: 0;
    }

    #yapitaRegisterModal .yapita-register-form__group {
        display: block;
        width: 100%;
        min-width: 0;
        padding: 0;
        margin: 0;
    }

    /* FIELD CONTAINER */

    #yapitaRegisterModal .yapita-register-form__field {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;

        width: 100%;
        min-width: 0;
        min-height: 55px;

        margin: 0;
        padding: 8px 12px;

        border: 1px solid var(--yr-border);
        border-radius: 12px;
        background: #ffffff;

        transition: border-color .2s, box-shadow .2s;
    }

    #yapitaRegisterModal .yapita-register-form__field:focus-within {
        border-color: #3264ff;
        box-shadow: 0 0 0 3px rgba(50, 100, 255, .10);
    }

    /* MAIN ICON */

    #yapitaRegisterModal .yapita-register-form__icon {
        display: flex;
        align-items: center;
        justify-content: center;

        flex: 0 0 22px;
        width: 22px;
        height: 24px;

        color: #344563;
        font-size: 20px;
        line-height: 1;
    }

    /* INPUT WRAPPER */

    #yapitaRegisterModal .yapita-register-form__input-wrapper {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: center;
        gap: 2px;

        flex: 1 1 auto;
        min-width: 0;
        width: auto;

        padding: 0;
        margin: 0;
    }

    /* LABEL */

    #yapitaRegisterModal .yapita-register-form__label {
        display: block;
        width: 100%;
        margin: 0;
        padding: 0;

        color: #344563;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.3;
        text-align: left;
    }

    /* INPUT */

    #yapitaRegisterModal .yapita-register-form__input {
        display: block;

        width: 100%;
        min-width: 0;
        height: 22px;
        min-height: 0;

        padding: 0;
        margin: 0;

        border: 0;
        border-radius: 0;
        outline: 0;

        background: transparent;
        box-shadow: none;

        color: #1e2c47;
        font-family: inherit;
        font-size: 12px;
        font-weight: 500;
        line-height: 22px;
        text-align: left;
    }

    #yapitaRegisterModal .yapita-register-form__input:focus {
        border: 0;
        outline: 0;
        box-shadow: none;
    }

    #yapitaRegisterModal .yapita-register-form__input::placeholder {
        color: #929bad;
        opacity: 1;
    }

    /* VALID ICON */

    #yapitaRegisterModal .yapita-register-form__valid-icon {
        display: none;
        flex: 0 0 auto;
        color: #16a34a;
        font-size: 16px;
    }

    #yapitaRegisterModal .yapita-register-form__group.is-valid
    .yapita-register-form__valid-icon {
        display: inline-flex;
    }

    #yapitaRegisterModal .yapita-register-form__group.is-invalid
    .yapita-register-form__field {
        border-color: #dc3545;
    }

    /* PASSWORD VISIBILITY */

    #yapitaRegisterModal .yapita-register-form__toggle-password {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex: 0 0 32px;
        width: 32px;
        height: 32px;

        padding: 0;
        margin: 0;

        border: 0;
        border-radius: 8px;
        background: transparent;

        color: #344563;
        font-size: 19px;
        line-height: 1;
        cursor: pointer;
    }

    #yapitaRegisterModal .yapita-register-form__toggle-password:hover {
        background: #f0f3fa;
    }

    /* VALIDATION ERRORS */

    #yapitaRegisterModal .yapita-register-form__error {
        display: block;
        margin: 0;
        padding: 0;

        color: #dc3545;
        font-size: 11px;
        line-height: 1.4;
    }

    #yapitaRegisterModal .yapita-register-form__error:empty {
        display: none;
    }

    /* SUBMIT */

    #yapitaRegisterModal .yapita-register-form__submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;

        width: 100%;
        min-height: 47px;

        margin: 2px 0 0;
        padding: 11px 14px;

        border: 0;
        border-radius: 12px;

        background: var(--yr-yellow);
        color: #161616;

        font-family: inherit;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.3;

        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    #yapitaRegisterModal .yapita-register-form__submit i {
        font-size: 19px;
    }

    #yapitaRegisterModal .yapita-register-form__submit:hover:not(:disabled) {
        background: #f2ca00;
        transform: translateY(-1px);
    }

    #yapitaRegisterModal .yapita-register-form__submit:disabled {
        background: #ffe56a;
        color: #6b5a17;
        opacity: .65;
        cursor: not-allowed;
    }

    /* FEEDBACK */

    #yapitaRegisterModal .yapita-register-form__feedback {
        margin: 0;
        padding: 0;

        font-size: 11px;
        line-height: 1.4;
        text-align: center;
    }

    #yapitaRegisterModal .yapita-register-form__feedback:empty {
        display: none;
    }

    /* =====================================================
       SOCIAL AUTHENTICATION
    ===================================================== */

    #yapitaRegisterModal .yapita-register-social {
        display: block;
        width: 100%;
        margin: 14px 0 0;
        padding: 0;
    }

    /* DIVIDER */

    #yapitaRegisterModal .yapita-register-social__divider {
        display: flex;
        align-items: center;
        gap: 10px;

        width: 100%;
        margin: 0 0 12px;

        color: #64748b;
        font-size: 12px;
        text-align: center;
    }

    #yapitaRegisterModal .yapita-register-social__divider::before,
    #yapitaRegisterModal .yapita-register-social__divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #d6dbe4;
    }

    #yapitaRegisterModal .yapita-register-social__divider span {
        flex: 0 0 auto;
        white-space: nowrap;
    }

    /* BUTTONS GRID */

    #yapitaRegisterModal .yapita-register-social__actions {

        width: 100%;
        margin: 0;
        padding: 0;
    }

    #yapitaRegisterModal .yapita-register-social__button {
        width: 100%;
        min-width: 0;
        height: 44px;
        min-height: 44px;
        margin: 0;
        padding: 8px 10px;

        border: 1px solid var(--yr-border);
        border-radius: 12px;
        background: #fff;
        color: var(--yr-primary);
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.2;

        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }

    #yapitaRegisterModal .yapita-register-social__button:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
    }

    /* FACEBOOK */

    #yapitaRegisterModal .yapita-register-social__button--facebook {
        background: var(--yr-blue);
        border-color: var(--yr-blue);
        color: #ffffff;
    }

    #yapitaRegisterModal .yapita-register-social__button--facebook i {
        flex: 0 0 auto;
        color: #fff;
        font-size: 20px;
        line-height: 1;
    }


    #yapitaRegisterModal .yapita-register-social__google-icon {
        display: block !important;

        flex: 0 0 20px !important;
        width: 20px !important;
        height: 20px !important;

        min-width: 20px !important;
        min-height: 20px !important;

        max-width: 20px !important;
        max-height: 20px !important;

        margin: 0 !important;
        padding: 0 !important;

        overflow: visible;
        vertical-align: middle;
    }

    /* =====================================================
       FOOTER
    ===================================================== */
    .row.row--manager-auth {
        padding-bottom: 15px;
    }
    div#yapita-google-login {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 44px;
        margin: 0 auto;
    }
    /* ==========================================
   SOCIAL LOGIN - LOADING
========================================== */

    [data-social-loading-target] {
        position: relative;
        isolation: isolate;
    }

    /* Bloquear interacciones mientras se autentica */
    [data-social-loading-target].is-social-loading {
        pointer-events: none;
        cursor: wait;
    }

    /* Capa sobre el botón */
    [data-social-loading-target].is-social-loading::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 20;
        background: rgba(255, 255, 255, 0.88);
        border-radius: inherit;
    }

    /* Spinner */
    [data-social-loading-target].is-social-loading::after {
        content: "";
        position: absolute;
        z-index: 21;

        width: 22px;
        height: 22px;

        top: 50%;
        left: 50%;

        border: 3px solid #dbe4ff;
        border-top-color: #435cf0;
        border-radius: 50%;

        animation: yapita-social-spin 0.75s linear infinite;
    }

    @keyframes yapita-social-spin {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }

        from {
            transform: translate(-50%, -50%) rotate(0deg);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        [data-social-loading-target].is-social-loading::after {
            animation-duration: 2s;
        }
    }
    #yapitaRegisterModal .yapita-register-footer {
        display: block;
        width: 100%;

        margin: 0;
        padding: 17px 0 0;
        text-align: center;
    }

    #yapitaRegisterModal .yapita-register-footer__login {
        margin: 0 0 12px;
        padding: 0;
        color: var(--yr-primary);
        font-size: 12px;
        font-weight: 500;
        line-height: 1.5;
    }

    #yapitaRegisterModal .yapita-register-footer__login-link,
    #yapitaRegisterModal .yapita-register-footer__link {
        color: #2459d9;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    #yapitaRegisterModal .yapita-register-footer__legal {
        margin: 0;
        padding: 0 5px;

        color: #697791;
        font-size: 10px;
        font-weight: 400;
        line-height: 1.5;
        text-align: center;
    }

    /* =====================================================
       MOBILE
    ===================================================== */

    @media (max-width: 480px) {
        #yapitaRegisterModal .modal-dialog {
            width: calc(100% - 16px);
            margin: 8px auto;
        }

        #yapitaRegisterModal .yapita-register-modal__content {
            max-height: calc(100dvh - 16px);
        }

        #yapitaRegisterModal .yapita-register-modal__body {
            padding-left: 15px;
            padding-right: 15px;
        }

        #yapitaRegisterModal .yapita-register-hero__image-wrapper {
            width: calc(100% + 30px);
            margin-left: -15px;
            margin-right: -15px;
        }

        #yapitaRegisterModal .yapita-register-hero__title {
            font-size: 22px;
        }

        #yapitaRegisterModal .yapita-register-hero__description {
            font-size: 12px;
        }
    }

    /* VERY SMALL SCREENS */

    @media (max-width: 350px) {
        #yapitaRegisterModal .yapita-register-benefits__label {
            font-size: 10px;
        }

        #yapitaRegisterModal .yapita-register-form__submit {
            font-size: 12px;
        }

        #yapitaRegisterModal .yapita-register-social__button {
            font-size: 11px;
        }
    }

    /* SHORT SCREENS */

    @media (max-height: 650px) {
        #yapitaRegisterModal .yapita-register-hero__image-wrapper {
            aspect-ratio: 16 / 6;
        }

        #yapitaRegisterModal .yapita-register-benefits {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }
    .nav-button-wrap.color-bg.nav-button-wrap--menu-mobiles {
        background: #ffcd02;
    }




    .business-detail__hero {
        position: relative;
    }

    .business-detail__route-badge {
        position: absolute;
        z-index: 3;
        bottom: 5px;
        left: 12px;

        display: flex;
        align-items: center;
        gap: 9px;

        max-width: calc(100% - 24px);
        padding: 9px 12px;

        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(245, 177, 39, 0.45);
        border-radius: 13px;

        box-shadow: 0 5px 18px rgba(24, 38, 80, 0.12);
        backdrop-filter: blur(8px);
    }

    .business-detail__route-badge-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 34px;
        height: 34px;
        flex-shrink: 0;

        background: #fff0c7;
        color: #db8b00;
        border-radius: 10px;
        font-size: 18px;
    }

    .business-detail__route-badge-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }

    .business-detail__route-badge-text strong {
        color: #654400;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.25;
    }

    .business-detail__route-badge-text small {
        color: #966300;
        font-size: 10px;
        font-weight: 500;
        line-height: 1.25;
    }

    .business-detail__route-badge-check {
        color: #e5a000;
        font-size: 17px;
        flex-shrink: 0;
    }

</style>
<style id="filters-manager">

    /* ==========================================
       MASKANA - BOTTOM SHEET
    ========================================== */

    .maskana-sheet {
        --sheet-primary: #435cf0;
        --sheet-radius: 26px;
        --sheet-header-height: 88px;
        padding: 6px;
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1050;

        display: flex;
        flex-direction: column;

        width: 100%;
        max-height: 85dvh;

        background: #ffffff;

        border-radius: var(--sheet-radius) var(--sheet-radius) 0 0;

        box-shadow: 0 -6px 28px rgba(20, 30, 70, 0.14);

        overflow: hidden;
    }

    /* ==========================================
       HEADER
    ========================================== */

    .maskana-sheet__header {
        position: relative;

        display: flex;
        align-items: center;
        gap: 12px;

        min-height: var(--sheet-header-height);

        padding: 16px 18px;

        flex-shrink: 0;
    }

    /* Drag handle visual */

    .maskana-sheet__header::before {
        content: "";

        position: absolute;
        top: 7px;
        left: 50%;

        width: 42px;
        height: 5px;

        transform: translateX(-50%);

        border-radius: 20px;
        background: #d2d5dc;
    }

    /* Route image */

    .maskana-sheet__image {
        width: 60px;
        height: 60px;

        flex-shrink: 0;

        object-fit: contain;

        background: #f4f8ff;
        border-radius: 16px;

        padding: 5px;
    }

    /* Text area */

    .maskana-sheet__information {
        display: flex;
        flex-direction: column;
        justify-content: center;

        flex: 1;
        min-width: 0;
        gap: 5px;
    }

    .maskana-sheet__title {
        margin: 0;

        font-size: 16px;
        font-weight: 700;
        line-height: 1.25;

        color: #16214c;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .maskana-sheet__count {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        width: fit-content;

        padding: 5px 10px;

        background: #eef5ff;
        border-radius: 20px;

        font-size: 12px;
        font-weight: 600;
        color: #263e78;
    }

    /* Expand / collapse button */

    .maskana-sheet__toggle {
        display: flex;
        justify-content: center;
        align-items: center;

        width: 42px;
        height: 42px;

        flex-shrink: 0;

        border: 0;
        border-radius: 50%;
        background: transparent;

        color: #19244a;
        cursor: pointer;

        transition: background .2s ease;
    }

    .maskana-sheet__toggle:hover {
        background: #f1f4ff;
    }

    .maskana-sheet__toggle i {
        font-size: 19px;
        transition: transform .25s ease;
    }

    /* ==========================================
       EXPANDABLE CONTENT
    ========================================== */

    .maskana-sheet__content {
        display: none;
        flex-direction: column;

        min-height: 0;
        overflow: hidden;

        border-top: 1px solid #edf0f6;
    }

    /* Expanded state */

    .maskana-sheet--expanded .maskana-sheet__content {
        display: flex;
    }

    .maskana-sheet--expanded .maskana-sheet__toggle i {
        transform: rotate(180deg);
    }

    /* ==========================================
       BODY
    ========================================== */

    .maskana-sheet__body {
        flex: 1;
        min-height: 0;

        overflow-y: auto;
        overscroll-behavior: contain;

        padding: 20px 18px;

        scrollbar-width: thin;
    }

    .maskana-sheet__section-title {
        margin: 0 0 14px;

        font-size: 16px;
        font-weight: 700;
        color: #17234c;
    }

    .maskana-sheet__placeholder {
        padding: 28px 14px;

        border: 1px dashed #cbd3ec;
        border-radius: 14px;

        background: #f8faff;

        text-align: center;
        font-size: 13px;
        color: #7b859e;
    }

    /* ==========================================
       FOOTER
    ========================================== */

    .maskana-sheet__footer {
        display: flex;
        gap: 12px;

        flex-shrink: 0;

        padding: 14px 18px calc(14px + env(safe-area-inset-bottom, 0px));

        background: #fff;
        border-top: 1px solid #edf0f6;
    }

    .maskana-sheet__button {
        flex: 1;
        min-height: 48px;

        border-radius: 12px;

        font-size: 14px;
        font-weight: 700;
    }

    .maskana-sheet__button--secondary {
        border: 1px solid #b9c9ff;
        background: #fff;
        color: var(--sheet-primary);
    }

    .maskana-sheet__button--primary {
        border: 1px solid var(--sheet-primary);
        background: var(--sheet-primary);
        color: #fff;
    }

    /* ==========================================
       STATES
    ========================================== */

    .maskana-sheet--collapsed {
        height: auto;
    }

    .maskana-sheet--expanded {
        height: min(510px, 85dvh);
    }

    /* ==========================================
       DESKTOP
    ========================================== */

    @media (min-width: 992px) {
        .maskana-sheet {
            left: auto;
            right: 20px;
            bottom: 20px;

            width: 390px;
            max-height: 80vh;

            border-radius: 20px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .maskana-sheet__toggle i {
            transition: none;
        }
    }

</style>
