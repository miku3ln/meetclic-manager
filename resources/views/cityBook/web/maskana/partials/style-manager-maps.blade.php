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
