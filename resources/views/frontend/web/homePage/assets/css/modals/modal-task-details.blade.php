<style>

    /* ============================================
       YAPITA TASK MODAL - VISUAL V2
       Diseño móvil aprobado
       Bootstrap 5.0.2
    ============================================ */

    .yapita-task-modal {
        --ytm-primary: #2154f5;
        --ytm-purple: #7043d9;
        --ytm-text: #111a45;
        --ytm-muted: #5b6681;
        --ytm-lavender: #eee9ff;
    }

    /* ============================================
       MODAL Y CONTENEDOR
    ============================================ */

    .yapita-task-modal .modal-dialog {
        width: calc(100% - 24px);
        max-width: 420px;
        margin: 12px auto;
    }

    .yapita-task-modal__content {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-height: calc(100dvh - 24px);
        overflow: hidden;
        background: #fff;
        border: none;
        border-radius: 26px;
    }

    .yapita-task-modal__header {
        position: relative;
        flex: 0 0 38px;
        min-height: 38px;
    }

    .yapita-task-modal__handle {
        width: 48px;
        height: 5px;
        top: 9px;
        background: #bbc1d4;
    }

    .yapita-task-modal__close {
        top: 8px;
        right: 12px;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f8fe;
        color: #131b43;
        box-shadow: 0 2px 9px rgba(30, 36, 83, .10);
    }

    /* Única sección desplazable */

    .yapita-task-modal__body {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
        padding: 4px 16px 16px;
    }

    /* ============================================
       IMAGEN + BADGES + TITULO
    ============================================ */

    .yapita-task-modal__overview {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin: 2px 0 13px;
        padding: 0 0;
    }

    .yapita-task-modal__media {
        flex: 0 0 108px;
        width: 108px;
        height: 108px;
        border-radius: 16px;
        overflow: hidden;
        background: #e9f1ff;
    }

    .yapita-task-modal__image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .yapita-task-modal__information {
        min-width: 0;
        flex: 1;
        padding-top: 6px;
    }

    .yapita-task-modal__badges {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: space-between;
        gap: 5px;
        margin-bottom: 9px;
    }

    .yapita-task-modal__channel,
    .yapita-task-modal__points {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        min-width: 0;
        border-radius: 30px;
        padding: 5px 7px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .yapita-task-modal__channel--physical {
        background: #efe7ff;
        color: #5c24ba;
        border: 1px solid #dfceff;
    }

    .yapita-task-modal__channel--digital {
        background: #e1f0ff;
        color: #1555bc;
        border: 1px solid #c9e4ff;
    }

    .yapita-task-modal__points {
        background: #ffedaa;
        color: #634000;
        border: 1px solid #ffda58;
    }

    .yapita-task-modal__title {
        font-size: 18px;
        font-weight: 800;
        line-height: 1.22;
        margin: 0;
        color: var(--ytm-text);
        overflow-wrap: anywhere;
    }

    /* ============================================
       EMPRESA DESTACADA
    ============================================ */

    .yapita-task-modal__business {
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 65px;
        padding: 10px 12px;
        margin: 0 0 12px;
        border-radius: 14px;
        background: linear-gradient(
            110deg,
            #f2eeff 0%,
            #e9e2ff 100%
        );
    }

    .yapita-task-modal__business-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 43px;
        width: 43px;
        height: 43px;
        font-size: 32px;
        color: #1949f2;
    }

    .yapita-task-modal__business-info {
        flex: 1;
        min-width: 0;
    }

    .yapita-task-modal__business-name {
        display: block;
        font-size: 21px;
        font-weight: 850;
        line-height: 1.15;
        color: #152ea8;
    }

    .yapita-task-modal__business-category {
        display: block;
        margin-top: 3px;
        font-size: 12px;
        line-height: 1.25;
        color: #3f4b70;
    }

    .yapita-task-modal__business-action {
        flex: 0 0 32px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        color: #4e40c9;
        border: 1px solid #e2dafa;
        box-shadow: 0 2px 7px rgba(53, 34, 128, .12);
    }

    /* ============================================
       DESCRIPCION
    ============================================ */

    .yapita-task-modal__description {
        font-size: 12.5px;
        font-weight: 500;
        line-height: 1.48;
        color: #26314e;
        margin: 0 0 12px;
    }

    /* ============================================
       PASOS
    ============================================ */

    .yapita-task-modal__steps {
        background: linear-gradient(
            120deg,
            #f3efff,
            #e8e1ff
        );
        border-radius: 14px;
        padding: 12px;
        margin-bottom: 12px;
    }

    .yapita-task-modal__section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 10px;
        font-size: 14px;
        font-weight: 800;
        color: #182eab;
        line-height: 1.3;
    }

    .yapita-task-modal__section-title i {
        font-size: 19px;
        flex-shrink: 0;
    }

    .yapita-task-modal__steps-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .yapita-task-modal__steps-list li {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 8px;
        font-size: 12px;
        line-height: 1.4;
        color: #182143;
    }

    .yapita-task-modal__steps-list li:last-child {
        margin-bottom: 0;
    }

    .yapita-task-modal__step-number {
        flex: 0 0 23px;
        width: 23px;
        height: 23px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #c6b4ff;
        color: #4224a5;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 800;
    }

    /* ============================================
       FRECUENCIA - VIGENCIA - ESTADO
    ============================================ */

    .yapita-task-modal__metadata {
        display: grid;
        grid-template-columns: 1fr 1.15fr 1fr;
        gap: 0;
        padding: 10px 4px;
        margin-bottom: 15px;
        background: #f4f5fc;
        border: 1px solid #e8eafa;
        border-radius: 14px;
    }

    .yapita-task-modal__metadata-item {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        min-width: 0;
        padding: 0 7px;
    }

    .yapita-task-modal__metadata-item +
    .yapita-task-modal__metadata-item {
        border-left: 1px solid #cbd1e9;
    }

    .yapita-task-modal__metadata-item > i {
        flex-shrink: 0;
        font-size: 16px;
        color: #6635d6;
    }

    .yapita-task-modal__metadata-item > div {
        min-width: 0;
    }

    .yapita-task-modal__metadata-item span {
        display: block;
        font-size: 10px;
        font-weight: 600;
        line-height: 1.2;
        color: #435072;
    }

    .yapita-task-modal__metadata-item strong {
        display: block;
        margin-top: 3px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.3;
        color: #17204a;
        overflow-wrap: anywhere;
    }

    .yapita-task-modal__status {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        padding: 4px 6px;
        border-radius: 20px;
        background: #e3f8ed;
        color: #157442 !important;
    }

    .yapita-task-modal__status--warning {
        background: #ff3b65;
        color: #fff !important;
    }

    .yapita-task-modal__status--inactive {
        background: #e0e3eb;
        color: #515d74 !important;
    }

    /* ============================================
       ACCIONES RAPIDAS
    ============================================ */

    .yapita-task-modal__quick {
        margin-top: 2px;
        padding: 0 0;
    }

    .yapita-task-modal__quick-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 7px;
    }

    .yapita-task-modal__quick-button {
        min-width: 0;
        min-height: 84px;
        padding: 10px 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: linear-gradient(145deg, #f2eeff, #e7eafd);
        border: 1px solid #e3e4f5;
        border-radius: 13px;
        box-shadow: 0 2px 5px rgba(35, 40, 100, .06);
        color: #1d244e;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.15;
        text-align: center;
    }

    .yapita-task-modal__quick-button > i {
        font-size: 24px;
        color: #6937d5;
        line-height: 1;
    }

    .yapita-task-modal__quick-button span {
        max-width: 78px;
    }

    .yapita-task-modal__quick-button:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    /* ============================================
       FOOTER FIJO
    ============================================ */

    .yapita-task-modal__footer {
        display: flex;
        flex: 0 0 auto;
        gap: 9px;
        padding: 12px 15px
        calc(15px + env(safe-area-inset-bottom, 0px));
        border-top: 1px solid #edf0fc;
        background: #fff;
    }

    .yapita-task-modal__button {
        display: inline-flex;
        flex: 1 1 0;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-width: 0;
        min-height: 43px;
        padding: 9px 10px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.15;
    }

    .yapita-task-modal__button--primary {
        border: 1px solid #2456f5;
        background: linear-gradient(90deg, #0870fc, #1547ef);
        color: #fff;
        box-shadow: 0 3px 9px rgba(36, 86, 245, .16);
    }

    .yapita-task-modal__button--secondary {
        border: 1.5px solid #2456f5;
        background: #fff;
        color: #2149d5;
    }

    .yapita-task-modal__button[hidden] {
        display: none !important;
    }

    /* ============================================
       MOBILE BOTTOM SHEET
    ============================================ */

    @media (max-width: 575.98px) {

        .yapita-task-modal {
            padding: 0 !important;
        }

        .yapita-task-modal .modal-dialog {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            max-width: none;
            min-height: 0;
            margin: 0;
            transform: translateY(100%);
        }

        .yapita-task-modal.show .modal-dialog {
            transform: translateY(0);
        }

        .yapita-task-modal__content {
            width: 100%;
            max-height: 92vh;
            max-height: 92dvh;
            border-radius: 26px 26px 0 0;
        }

        .yapita-task-modal__body {
            padding: 6px 14px 14px;
        }

        .yapita-task-modal__footer {
            padding-left: 14px;
            padding-right: 14px;
        }
    }

    /* ============================================
       PANTALLAS PEQUEÑAS
    ============================================ */

    @media (max-width: 370px) {

        .yapita-task-modal__media {
            flex-basis: 90px;
            width: 90px;
            height: 100px;
        }

        .yapita-task-modal__overview {
            gap: 9px;
        }

        .yapita-task-modal__title {
            font-size: 16px;
        }

        .yapita-task-modal__channel,
        .yapita-task-modal__points {
            font-size: 9px;
            padding: 4px 5px;
        }

        .yapita-task-modal__metadata-item {
            padding: 0 4px;
            gap: 3px;
        }

        .yapita-task-modal__metadata-item > i {
            font-size: 13px;
        }

        .yapita-task-modal__metadata-item strong {
            font-size: 9px;
        }
    }

    /* ============================================
       ACCESSIBILITY
    ============================================ */

    .yapita-task-modal button:focus-visible {
        outline: 3px solid #ffc62b;
        outline-offset: 2px;
    }

    @media (prefers-reduced-motion: reduce) {
        .yapita-task-modal * {
            transition: none !important;
            scroll-behavior: auto !important;
        }
    }

</style>
