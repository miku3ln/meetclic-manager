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

        background: #ffffff;

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

    .business-detail__hero {
        position: relative;
        width: 100%;
        height: clamp(165px, 28vh, 240px);
        overflow: hidden;
        background: linear-gradient(
            135deg,
            #edf0ff,
            #dfe8ff
        );
    }

    .business-detail__hero-image {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .business-detail__hero-image[hidden],
    .business-detail__hero-fallback[hidden] {
        display: none !important;
    }

    .business-detail__hero-fallback {
        width: 100%;
        height: 100%;
        display: grid;
        place-items: center;
        font-size: 58px;
    }

    .business-detail__body {
        padding: 0 16px 28px;
    }

    .business-detail__header {
        padding: 20px 0 18px;
        border-bottom: 1px solid var(--bm-border);
    }

    .business-detail__category {
        display: inline-flex;
        align-items: center;
        max-width: 100%;
        padding: 5px 11px;
        margin-bottom: 11px;
        border-radius: 999px;
        background: var(--bm-primary-soft);
        color: #344bc6;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.4;
        letter-spacing: .035em;
        text-transform: uppercase;
        overflow-wrap: anywhere;
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

    .business-detail__rating {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin: 0;
        color: #a16207;
        font-size: 13px;
        font-weight: 650;
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

        .business-detail__title {
            font-size: 20px;
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

    /* ==========================================
       TOOLBAR FLOTANTE
    ========================================== */

    .manager-map__toolbar {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        z-index: 500;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;
        pointer-events: none;
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

    .manager-map__brand {
        padding-left: 13px;
        font-weight: 700;
    }

    .manager-map__brand i {
        color: #287c5b;
        font-size: 19px;
    }

    .manager-map__counter i {
        color: #287c5b;
    }

    /* ==========================================
       BOTONES FLOTANTES
    ========================================== */

    .manager-map__actions {
        position: absolute;
        right: 2%;
        top: 10%;
        z-index: 600;
    }

    .manager-filters__toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        border: 0;
        border-radius: 50px;

        padding: 14px 22px;

        background: #287c5b;
        color: #ffffff;

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;

        box-shadow: 0 8px 25px rgba(0, 0, 0, .22);
        transition: transform .2s, background .2s;
    }

    .manager-filters__toggle:hover {
        background: #1c6045;
        transform: translateY(-2px);
    }

    .manager-filters__toggle:focus-visible,
    .manager-filters__close:focus-visible,
    .manager-filters__apply:focus-visible,
    .manager-filters__reset:focus-visible {
        outline: 3px solid #86c7ad;
        outline-offset: 3px;
    }

    /* ==========================================
       FONDO OSCURO DEL PANEL
    ========================================== */

    .manager-filters__backdrop {
        position: absolute;
        inset: 0;
        z-index: 1190;

        background: rgba(12, 22, 19, .42);

        opacity: 0;
        visibility: hidden;
        pointer-events: none;

        transition: opacity .25s, visibility .25s;
    }

    .manager-filters__backdrop--visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    /* ==========================================
       PANEL DE FILTROS
    ========================================== */

    .manager-filters {
        position: absolute;
        top: 20px;
        right: 20px;
        bottom: 20px;

        width: min(390px, calc(100% - 40px));

        z-index: 1200;

        display: flex;
        flex-direction: column;

        background: #ffffff;
        border-radius: 20px;

        box-shadow: 0 15px 50px rgba(0, 0, 0, .22);

        overflow: hidden;

        transform: translateX(calc(100% + 40px));
        visibility: hidden;
        pointer-events: none;

        transition: transform .3s ease, visibility .3s;
    }

    .manager-filters--open {
        padding: 1px 0;
        transform: translateX(0);
        visibility: visible;
        pointer-events: auto;
    }

    /* ==========================================
       HEADER
    ========================================== */

    .manager-filters__header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;
        padding: 22px;

        border-bottom: 1px solid #e8ece9;
    }

    .manager-filters__heading {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .manager-filters__icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 42px;
        height: 42px;

        border-radius: 12px;

        background: #e5f3ec;
        color: #287c5b;

        font-size: 19px;
    }

    .manager-filters__title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #203b30;
    }

    .manager-filters__subtitle {
        margin: 4px 0 0;
        font-size: 12px;
        color: #7c8981;
    }

    .manager-filters__close {
        width: 36px;
        height: 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 0;
        border-radius: 50%;

        background: #f1f3f2;
        color: #33453a;

        cursor: pointer;
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
        border: 1px solid #dce4df;
        background: #ffffff;
        color: #52665a;
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

    /* ==========================================
       MOBILE / TABLET
    ========================================== */
    img.manager-map__brand-logo {
        width: 64px;
        height: 75px;
        object-fit: cover;
        object-position: center;
    }
    @media (max-width: 767px) {
        .header-user-menu {
            right: 0px !important;
            top: 46px !important;
            margin-left: 219px;
            width: 124px;
    }
    .manager-map__toolbar {
        width: 92%!important;
        top: 12px!important;
        left: 3px!important;
        right: 0px!important;
    }
    .leaflet-top {
        top: 72% !important;
    }
    .manager-map__actions {
        top: 13% !important;
    }
    .manager-map__toolbar {
        top: 12px;
        left: 58px;
        right: 12px;
    }


    .manager-map__counter {
        padding: 9px 12px;
        font-size: 12px;
    }

    .manager-map__actions {
        right: 15px;
    }

    .manager-filters {
        top: auto;
        left: 0;
        right: 0;
        bottom: 0;

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
        calc(14px + env(safe-area-inset-bottom));
    }

    .chat-widget-button {
        bottom: 20px!important;
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
