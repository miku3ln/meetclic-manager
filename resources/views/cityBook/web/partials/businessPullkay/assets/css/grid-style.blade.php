<style>


    .container__full-page {
        margin-left: 6%;
        margin-right: 6%;
    }



    /* Container wrapper */
    .pullkay-list {
        width: 100%;
    }

    /* Base item */
    .pullkay-item.list-group-item {
        border-color: var(--mc-border);
        border-radius: 0; /* joined will set first/last */
        padding: 14px 14px 14px 14px;
        position: relative;
        background: var(--mc-blanco);
    }

    .pullkay-item.list-group-item:hover {
        background: var(--mc-soft-bg);
    }

    /* Layout */
    .pullkay.media {
        margin-top: 0;
    }

    .pullkay .media-body {
        width: 100% !important;
    }

    /* Cover image (OBLIGATORY) */
    .pullkay__cover {
        width: 257px;
        height: 257px;
        border-radius: 14px;
        object-fit: cover;
        display: block;
        border: 1px solid var(--mc-border);
        background: var(--mc-blanco);
    }

    .pullkay-item .media-left {
        padding-right: 14px;
    }

    .pullkay__cover-link {
        display: inline-block;
    }

    /* Category */
    .pullkay__category {
        font-size: 12px;
        color: var(--mc-muted);
    }

    /* Business name */
    .pullkay__business {
        margin: 6px 0 6px;
        font-size: 28px;
        font-weight: 800;
    }

    .pullkay__business a {
        color: var(--mc-grisOscuro);
        text-decoration: none;
    }

    .pullkay__business a:hover {
        color: var(--mc-azulClic);
    }

    /* Meta row (status + mode + code) */
    .pullkay__meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin: 6px 0 8px;
    }

    /* Labels tuned to MeetClic (override BS3 inside pullkay) */
    .pullkay-item .label {
        border-radius: 999px;
        padding: 4px 10px;
        font-weight: 800;
        font-size: 11px;
        line-height: 1.4;
    }

    /* Status */
    .pullkay-item .label-success.pullkay__label-status {
        background: var(--mc-azulClic);
        color: var(--mc-blanco);
    }

    /* Inactive */
    .pullkay-item .label-default.pullkay__label-status {
        background: rgba(44, 44, 44, 0.16);
        color: var(--mc-grisOscuro);
    }

    /* Mode */
    .pullkay__label-mode {
        display: inline-flex;
        gap: 6px;
        align-items: center;
    }

    .pullkay__label-mode-icon {
        font-size: 12px;
        line-height: 1;
    }

    /* DIGITAL (primary) */
    .pullkay-item .label-primary.pullkay__label-mode {
        background: rgba(76, 76, 255, 0.12);
        color: var(--mc-azulClic);
        border: 1px solid rgba(76, 76, 255, 0.25);
    }

    /* PHYSICAL (warning using brand yellow) */
    .pullkay-item .label-warning.pullkay__label-mode {
        background: rgba(255, 204, 0, 0.18);
        color: var(--mc-grisOscuro);
        border: 1px solid rgba(255, 204, 0, 0.35);
    }

    /* Code label (info) */
    .pullkay-item .label-info.pullkay__code {
        background: rgba(92, 92, 255, 0.12);
        color: var(--mc-moradoSuave);
        border: 1px solid rgba(92, 92, 255, 0.25);
        letter-spacing: 0.2px;
    }

    /* Title */
    .pullkay__title {
        font-size: 22px;
        margin: 0 0 4px;
        line-height: 1.25;
    }

    .pullkay__title a {
        color: var(--mc-azulClic);
        text-decoration: none;
    }

    .pullkay__title a:hover {
        color: var(--mc-moradoSuave);
        text-decoration: underline;
    }

    /* Subtitle & description */
    .pullkay__subtitle {
        margin: 6px 0 0;
        font-size: 19px;
        color: var(--mc-muted);
    }

    .pullkay__desc {
        margin: 10px 0 0;
        font-size: 19px;
        line-height: 1.35;
        color: rgba(44, 44, 44, 0.82);
        max-width: 980px;
    }

    /* Actions */
    .pullkay__actions {
        margin-top: 10px;
    }

    /* CTA button (MeetClic style) */
    .pullkay__cta.btn {
        border-radius: 999px;
        padding: 6px 12px;
        font-weight: 800;
        border: 1px solid rgba(76, 76, 255, 0.22);
        background: rgba(76, 76, 255, 0.10);
        color: var(--mc-azulClic);
    }

    .pullkay__cta.btn:hover {
        background: rgba(76, 76, 255, 0.16);
        border-color: rgba(76, 76, 255, 0.30);
        color: var(--mc-moradoSuave);
    }

    .pullkay__cta-arrow {
        font-weight: 900;
    }

    /* =========================================================
       REWARD (You earn +100 Yapitas) - MAKE IT OBVIOUS
       ========================================================= */
    .pullkay__reward {
        position: absolute;
        top: 10px;
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

    /* =========================================================
       MODE A: JOINED (items unidos)
       Wrapper: <div class="pullkay-list pullkay-list--joined list-group">
       ========================================================= */
    .pullkay-list--joined.list-group {
        margin-bottom: 0;
    }

    .pullkay-list--joined .pullkay-item.list-group-item {
        border-left: 1px solid var(--mc-border);
        border-right: 1px solid var(--mc-border);
    }

    .pullkay-list--joined .pullkay-item.list-group-item + .pullkay-item.list-group-item {
        border-top: 0; /* avoid double border */
    }

    .pullkay-list--joined .pullkay-item.list-group-item:first-child {
        border-top-left-radius: var(--mc-radius);
        border-top-right-radius: var(--mc-radius);
    }

    .pullkay-list--joined .pullkay-item.list-group-item:last-child {
        border-bottom-left-radius: var(--mc-radius);
        border-bottom-right-radius: var(--mc-radius);
    }

    /* =========================================================
       MODE B: SEPARATED (item x item separado)
       Wrapper: <div class="pullkay-list pullkay-list--separated">
       ========================================================= */
    .pullkay-list--separated .pullkay-item {
        border: 1px solid var(--mc-border);
        border-radius: var(--mc-radius);
        margin-bottom: 12px;
        box-shadow: var(--mc-shadow);
    }

    .pullkay-list--separated .pullkay-item:hover {
        box-shadow: 0 12px 22px rgba(44, 44, 44, 0.10);
    }

    .pullkay-list--separated .pullkay-item:last-child {
        margin-bottom: 0;
    }

    /* =========================================================
       RESPONSIVE (Bootstrap 3 xs)
       ========================================================= */
    @media (max-width: 767px) {
        .pullkay-item.list-group-item {
            padding-top: 54px; /* reward pill space */
            width: 75%;

        }

        .pullkay__reward {
            top: 10px;
            right: 10px;
            left: 10px;
            justify-content: center;
        }

        .pullkay-item .media-left {
            display: block;
            margin-bottom: 10px;

            text-align: center;
            padding-left: 13%;
            padding-right: 13%;
        }

        .pullkay__cover {
            width: 100%;
            height: 160px;
            border-radius: 14px;
        }

        .limitations__icon {

            font-size: 19px;
        }
        .pullkay__business {

            font-size: 22px;

        }
        .pullkay-item .label{
            font-size: 8px;

        }
        .pullkay__title {
            font-size: 16px;
        }
        .pullkay__subtitle {

            font-size: 15px;

        }
        .pullkay__desc {

            font-size: 14px;

        }
    }
    .pagination > .active > a {
        color: #e4e4e4;
        background-color: var(--mc-azulClic) !important;
        border-color: var(--mc-azulClic) !important;
    }
</style>
