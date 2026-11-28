<style id="shop-order-aside-style">

    /* =====================================================
       SHOP ORDER ASIDE - BASE
       YAPITA - MOBILE FIRST
    ===================================================== */

    #shop-order-aside {

        --soa-primary: var(--mc-azulClic, #4455e9);
        --soa-yellow: var(--mc-amarilloVital, #ffcc00);

        --soa-text: #151644;
        --soa-muted: #64748b;
        --soa-border: #e1e5ef;

        --soa-green: #15803d;
        --soa-danger: #dc2626;

        --soa-background: #f7f8fc;
        --soa-surface: #ffffff;

        --soa-padding: 14px;
        --soa-width: 100%;

        --bs-offcanvas-width: var(--soa-width);

        position: fixed !important;

        inset: 0 0 0 auto !important;

        display: grid !important;

        grid-template-columns: minmax(0, 1fr);

        grid-template-rows: auto minmax(0, 1fr) auto;

        width: var(--soa-width) !important;

        min-width: 0;
        max-width: 100vw;

        height: 100vh !important;
        height: 100dvh !important;

        min-height: 0 !important;

        max-height: 100vh !important;
        max-height: 100dvh !important;

        margin: 0 !important;
        padding: 0 !important;

        border: 0;

        background: var(--soa-background);

        color: var(--soa-text);

        font-family: inherit;

        text-align: left;

        box-sizing: border-box;

        overflow: hidden !important;

        overscroll-behavior: contain;

        box-shadow: -5px 0 30px rgba(0, 0, 0, .12);

        z-index: 11001 !important;

    }


    #shop-order-aside[v-cloak] {

        display: none !important;

    }


    .shop-order-aside * {

        box-sizing: border-box;

    }


    /* =====================================================
       HEADER - FIXED TOP AREA
    ===================================================== */

    #shop-order-aside > .shop-order-aside__header {

        grid-row: 1;

        position: relative !important;

        inset: auto !important;

        display: flex !important;

        align-items: center;
        justify-content: space-between;

        gap: 10px;

        width: 100% !important;
        height: auto !important;

        min-height: 0;

        margin: 0 !important;

        padding: 12px var(--soa-padding);

        background: var(--soa-surface);

        border-bottom: 1px solid var(--soa-border);

        float: none !important;

    }


    .shop-order-aside__heading {

        display: flex;

        align-items: center;

        gap: 10px;

        min-width: 0;

    }


    .shop-order-aside__heading > i {

        font-size: 25px;

        color: var(--soa-primary);

    }


    .shop-order-aside__title {

        margin: 0;
        padding: 0;

        font-family: inherit;

        font-size: 23px;
        font-weight: 800;

        line-height: 1.3;

        color: var(--soa-text);

        text-align: left;

    }


    .shop-order-aside__close {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 40px;
        height: 40px;

        flex-shrink: 0;

        margin: 0;
        padding: 0;

        border: 0;
        border-radius: 9px;

        background: transparent;

        color: var(--soa-primary);

        font-size: 18px;

        cursor: pointer;

        touch-action: manipulation;

    }


    /* =====================================================
       BODY - SCROLLABLE AREA
    ===================================================== */

    #shop-order-aside > .shop-order-aside__body {

        grid-row: 2;

        position: relative !important;

        inset: auto !important;

        display: flex !important;

        flex-direction: column !important;

        align-items: stretch;
        justify-content: flex-start;

        gap: 14px;

        width: 100% !important;

        height: auto !important;

        min-width: 0 !important;
        min-height: 0 !important;

        max-height: none !important;

        margin: 0 !important;

        padding: var(--soa-padding);

        overflow-x: hidden !important;
        overflow-y: auto !important;

        overscroll-behavior-y: contain;

        touch-action: pan-y;

        -webkit-overflow-scrolling: touch;

        pointer-events: auto;

        float: none !important;

        scrollbar-width: thin;

        scrollbar-color: #cbd5e1 transparent;

    }


    /* PREVENT BODY CHILDREN SHRINKING */

    #shop-order-aside > .shop-order-aside__body > * {

        flex-shrink: 0 !important;

        width: 100%;

        min-width: 0;

        margin: 0;

        float: none;

    }


    /* =====================================================
       BUSINESS INFORMATION
    ===================================================== */

    .shop-order-aside__business {

        position: relative;

        display: flex;

        align-items: center;

        gap: 12px;

        padding: 12px;

        background: var(--soa-surface);

        border: 1px solid var(--soa-border);

        border-radius: 14px;

    }


    .shop-order-aside__business-logo {

        display: block;

        width: 48px;
        height: 48px;

        object-fit: cover;

        border-radius: 50%;

        background: #f1f5f9;

        flex-shrink: 0;

    }


    .shop-order-aside__business-information {

        display: flex;

        flex-direction: column;

        flex: 1;

        min-width: 0;

        gap: 4px;

    }


    .shop-order-aside__business-name {

        font-size: 16px;
        font-weight: 800;

        line-height: 1.3;

        overflow-wrap: anywhere;

    }


    .shop-order-aside__business-category {

        color: var(--soa-muted);

        font-size: 12px;

        line-height: 1.3;

    }


    .shop-order-aside__business-whatsapp {

        color: #16a34a;

        font-size: 23px;

        flex-shrink: 0;

    }


    /* =====================================================
       SECTION HEADER
    ===================================================== */

    .shop-order-aside__section-header {

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 8px;

        margin-bottom: 5px;

    }


    .shop-order-aside__section-title {

        margin: 0;
        padding: 0;

        color: var(--soa-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 800;

        line-height: 1.3;

        text-align: left;

    }


    .shop-order-aside__clear {

        display: inline-flex;

        align-items: center;

        gap: 5px;

        min-height: 34px;

        margin: 0;
        padding: 4px 7px;

        border: 0;
        border-radius: 7px;

        background: transparent;

        color: var(--soa-danger);

        font-family: inherit;

        font-size: 11px;

        cursor: pointer;

        touch-action: manipulation;

    }


    /* =====================================================
       PRODUCTS CONTAINER
    ===================================================== */

    .shop-order-aside__products {

        position: relative;

        display: flex;

        flex-direction: column;

        gap: 9px;

        width: 100%;

        min-width: 0;

        padding: 0;

    }


    /* =====================================================
       PRODUCT ITEM
    ===================================================== */

    .shop-order-aside__product {

        position: relative;

        display: flex;

        flex-direction: column;

        gap: 10px;

        width: 100%;

        min-width: 0;

        flex-shrink: 0;

        margin: 0;

        padding: 10px;

        background: var(--soa-surface);

        border: 1px solid var(--soa-border);

        border-radius: 14px;

        float: none;

    }


    .shop-order-aside__product-main {

        display: flex;

        align-items: flex-start;

        gap: 10px;

        width: 100%;

        min-width: 0;

    }


    .shop-order-aside__product-image {

        display: block;

        width: 65px;
        height: 65px;

        object-fit: cover;

        border-radius: 9px;

        background: #f1f5f9;

        flex-shrink: 0;

    }


    .shop-order-aside__product-information {

        display: flex;

        flex-direction: column;

        gap: 5px;

        flex: 1;

        min-width: 0;

        text-align: left;

    }


    .shop-order-aside__product-name {

        color: var(--soa-text);

        font-size: 14px;

        font-weight: 800;

        line-height: 1.3;

        overflow-wrap: anywhere;

    }


    /* =====================================================
       PRODUCT PRICES
    ===================================================== */

    .shop-order-aside__product-prices {

        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 6px;

    }


    .shop-order-aside__product-price {

        color: var(--soa-green);

        font-size: 15px;

        font-weight: 800;

        white-space: nowrap;

        font-variant-numeric: tabular-nums;

    }


    .shop-order-aside__product-old-price {

        color: var(--soa-muted);

        font-size: 11px;

        text-decoration: line-through;

        white-space: nowrap;

    }


    /* =====================================================
       DISCOUNTS
    ===================================================== */

    .shop-order-aside__discount {

        display: inline-flex;

        align-items: center;

        padding: 3px 6px;

        border-radius: 6px;

        background: #fee2e2;

        color: #b91c1c;

        font-size: 10px;

        font-weight: 800;

        line-height: 1.2;

        white-space: nowrap;

    }


    /* =====================================================
       YAPITAS
    ===================================================== */

    .shop-order-aside__points {

        display: inline-flex;

        align-items: center;

        align-self: flex-start;

        gap: 4px;

        padding: 4px 7px;

        border-radius: 20px;

        background: #f0eaff;

        color: #5535c9;

        font-size: 10px;
        font-weight: 700;

        line-height: 1.3;

    }


    .shop-order-aside__points i {

        color: #d69e00;

        font-size: 13px;

    }


    /* =====================================================
       REMOVE PRODUCT
    ===================================================== */

    .shop-order-aside__remove {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 38px;
        height: 38px;

        flex-shrink: 0;

        margin: 0;
        padding: 0;

        border: 0;
        border-radius: 8px;

        background: #fff1f2;

        color: var(--soa-danger);

        font-size: 16px;

        cursor: pointer;

        touch-action: manipulation;

    }


    /* =====================================================
       PRODUCT FOOTER
    ===================================================== */

    .shop-order-aside__product-footer {

        position: relative;

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 10px;

        width: 100%;

    }


    .shop-order-aside__product-total {

        color: var(--soa-text);

        font-size: 17px;

        font-weight: 800;

        font-variant-numeric: tabular-nums;

        white-space: nowrap;

    }


    /* =====================================================
       QUANTITY CONTROLLER
    ===================================================== */

    .shop-order-aside__quantity {

        display: inline-flex;

        align-items: center;

        flex-shrink: 0;

        border: 1px solid #c3c9ff;

        border-radius: 9px;

        background: #ffffff;

        overflow: hidden;

    }


    .shop-order-aside__quantity-button {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 44px;
        height: 40px;

        flex-shrink: 0;

        margin: 0;
        padding: 0;

        border: 0;

        background: #ffffff;

        color: var(--soa-primary);

        font-size: 15px;

        cursor: pointer;

        touch-action: manipulation;

    }


    .shop-order-aside__quantity-button:active {

        background: #eef0ff;

    }


    .shop-order-aside__quantity-button:disabled {

        opacity: .4;

        cursor: not-allowed;

    }


    .shop-order-aside__quantity-button i {

        pointer-events: none;

    }


    .shop-order-aside__quantity-value {

        min-width: 28px;

        padding: 0 3px;

        color: var(--soa-text);

        font-size: 14px;

        font-weight: 800;

        text-align: center;

        font-variant-numeric: tabular-nums;

    }


    /* =====================================================
       ORDER NOTES
    ===================================================== */

    .shop-order-aside__notes {

        position: relative;

        display: flex;

        flex-direction: column;

        gap: 7px;

        width: 100%;

        padding: 0;

    }


    .shop-order-aside__notes-label {

        color: var(--soa-text);

        font-size: 13px;

        font-weight: 700;

        text-align: left;

    }


    .shop-order-aside__notes-input {

        display: block;

        width: 100%;

        min-height: 80px;

        margin: 0;

        padding: 10px;

        border: 1px solid var(--soa-border);

        border-radius: 11px;

        background: #ffffff;

        color: var(--soa-text);

        font-family: inherit;

        font-size: 16px;

        line-height: 1.4;

        resize: vertical;

    }


    .shop-order-aside__notes-input:focus {

        outline: none;

        border-color: var(--soa-primary);

        box-shadow: 0 0 0 2px rgba(68, 85, 233, .10);

    }


    .shop-order-aside__notes-input::placeholder {

        color: var(--soa-muted);

        opacity: .8;

    }


    /* =====================================================
       EMPTY ORDER
    ===================================================== */

    .shop-order-aside__empty {

        position: relative;

        display: flex;

        flex-direction: column;

        align-items: center;
        justify-content: center;

        gap: 12px;

        padding: 35px 15px;

        text-align: center;

    }


    .shop-order-aside__empty > i {

        color: #a8b5d0;

        font-size: 48px;

    }


    .shop-order-aside__empty h3 {

        margin: 0;
        padding: 0;

        color: var(--soa-text);

        font-size: 18px;

        font-weight: 800;

    }


    .shop-order-aside__empty p {

        margin: 0;

        color: var(--soa-muted);

        font-size: 13px;

        line-height: 1.5;

    }


    .shop-order-aside__continue {

        min-height: 44px;

        padding: 12px 20px;

        border: 0;
        border-radius: 10px;

        background: var(--soa-primary);

        color: #ffffff;

        font-family: inherit;

        font-size: 13px;

        font-weight: 700;

        cursor: pointer;

    }


    /* =====================================================
       ORDER FOOTER - FIXED BOTTOM AREA
    ===================================================== */

    #shop-order-aside > .shop-order-aside__footer {

        grid-row: 3;

        position: relative !important;

        inset: auto !important;

        display: flex !important;

        flex-direction: column !important;

        gap: 10px;

        width: 100% !important;

        height: auto !important;

        min-width: 0;
        min-height: 0 !important;

        max-height: 50vh;
        max-height: 50dvh;

        margin: 0 !important;

        padding: 12px var(--soa-padding);

        padding-bottom: calc(
            12px + env(safe-area-inset-bottom, 0px)
        );

        overflow-x: hidden !important;
        overflow-y: auto !important;

        overscroll-behavior-y: contain;

        touch-action: pan-y;

        background: var(--soa-surface);

        border-top: 1px solid var(--soa-border);

        box-shadow: 0 -5px 20px rgba(0, 0, 0, .06);

        float: none !important;

        scrollbar-width: thin;

    }


    #shop-order-aside > .shop-order-aside__footer > * {

        flex-shrink: 0;

    }


    /* =====================================================
       ORDER SUMMARY
    ===================================================== */

    .shop-order-aside__summary {

        display: flex;

        flex-direction: column;

        gap: 8px;

        width: 100%;

    }


    .shop-order-aside__summary-row {

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 8px;

        color: var(--soa-text);

        font-size: 13px;

        line-height: 1.4;

    }


    .shop-order-aside__summary-row > strong {

        font-variant-numeric: tabular-nums;

        white-space: nowrap;

    }


    /* DISCOUNT SUMMARY */

    .shop-order-aside__summary-row--discount {

        color: var(--soa-green);

    }


    /* TOTAL SUMMARY */

    .shop-order-aside__summary-row--total {

        padding: 11px;

        border-radius: 10px;

        background: #fff4cc;

        color: var(--soa-text);

        font-size: 16px;

    }


    .shop-order-aside__total-value {

        font-size: 24px;

        font-weight: 900;

        line-height: 1.2;

        font-variant-numeric: tabular-nums;

        white-space: nowrap;

    }


    /* =====================================================
       YAPITAS REWARD SUMMARY
    ===================================================== */

    .shop-order-aside__reward {

        display: flex;

        align-items: center;

        gap: 8px;

        padding: 9px 12px;

        background: #eee8ff;

        border-radius: 10px;

        color: #5535c9;

        font-size: 13px;

        line-height: 1.4;

    }


    .shop-order-aside__reward i {

        color: #d69e00;

        font-size: 21px;

        flex-shrink: 0;

    }


    /* =====================================================
       SEND ORDER - WHATSAPP
    ===================================================== */

    .shop-order-aside__send {

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 9px;

        width: 100%;

        min-height: 50px;

        margin: 0;

        padding: 12px;

        border: 0;
        border-radius: 12px;

        background: #16a34a;

        color: #ffffff;

        font-family: inherit;

        font-size: 14px;

        font-weight: 800;

        line-height: 1.3;

        text-align: center;

        cursor: pointer;

        touch-action: manipulation;

    }


    .shop-order-aside__send i {

        font-size: 23px;

        flex-shrink: 0;

    }


    .shop-order-aside__send:active:not(:disabled) {

        background: #15803d;

    }


    .shop-order-aside__send:disabled {

        background: #cbd5e1;

        color: #64748b;

        cursor: not-allowed;

    }


    /* =====================================================
       CONFIRMATION MESSAGE
    ===================================================== */

    .shop-order-aside__confirmation {

        display: flex;

        align-items: flex-start;

        gap: 7px;

        padding: 8px;

        border-radius: 9px;

        background: #eef2ff;

        color: #475569;

        font-size: 11px;

        line-height: 1.4;

        text-align: left;

    }


    .shop-order-aside__confirmation i {

        color: var(--soa-primary);

        flex-shrink: 0;

        font-size: 13px;

    }


    /* =====================================================
       ERROR MESSAGE
    ===================================================== */

    .shop-order-aside__error {

        padding: 8px;

        border-radius: 8px;

        background: #fee2e2;

        color: #b91c1c;

        font-size: 12px;

        line-height: 1.4;

        overflow-wrap: anywhere;

    }


    /* =====================================================
       INTERNAL SCROLLBAR
    ===================================================== */

    #shop-order-aside
    .shop-order-aside__body::-webkit-scrollbar,

    #shop-order-aside
    .shop-order-aside__footer::-webkit-scrollbar {

        width: 5px;

    }


    #shop-order-aside
    .shop-order-aside__body::-webkit-scrollbar-track,

    #shop-order-aside
    .shop-order-aside__footer::-webkit-scrollbar-track {

        background: transparent;

    }


    #shop-order-aside
    .shop-order-aside__body::-webkit-scrollbar-thumb,

    #shop-order-aside
    .shop-order-aside__footer::-webkit-scrollbar-thumb {

        background: #cbd5e1;

        border-radius: 10px;

    }


    /* =====================================================
       BACKDROP
    ===================================================== */

    .offcanvas-backdrop.shop-order-aside-backdrop {

        position: fixed !important;

        inset: 0;

        z-index: 11000 !important;

        overscroll-behavior: none;

        touch-action: none;

    }


    /* =====================================================
       ACCESSIBILITY
    ===================================================== */

    .shop-order-aside button:focus-visible {

        outline: 2px solid var(--soa-primary);

        outline-offset: -2px;

    }


    /* =====================================================
       HOVER INTERACTIONS
    ===================================================== */

    @media (hover: hover) {

        .shop-order-aside__close:hover {

            background: #eef2ff;

        }


        .shop-order-aside__remove:hover {

            background: #fee2e2;

        }


        .shop-order-aside__clear:hover {

            background: #fff1f2;

        }


        .shop-order-aside__quantity-button:hover:not(:disabled) {

            background: #eef0ff;

        }


        .shop-order-aside__send:hover:not(:disabled) {

            background: #15803d;

        }

    }


    /* =====================================================
       SMALL MOBILE
    ===================================================== */

    @media (max-width: 359.98px) {

        #shop-order-aside {

            --soa-padding: 10px;

        }


        .shop-order-aside__title {

            font-size: 21px;

        }


        .shop-order-aside__product-image {

            width: 55px;
            height: 55px;

        }


        .shop-order-aside__quantity-button {

            width: 38px;
            height: 38px;

        }


        .shop-order-aside__total-value {

            font-size: 21px;

        }


        .shop-order-aside__send {

            font-size: 12px;

        }

    }


    /* =====================================================
       MOBILE
       360px - 767.98px
    ===================================================== */

    @media (min-width: 360px) and (max-width: 767.98px) {

        #shop-order-aside {

            --soa-width: 100%;

            --soa-padding: 14px;

        }

    }


    /* =====================================================
       TABLET
       768px - 1199.98px
    ===================================================== */

    @media (min-width: 768px) and (max-width: 1199.98px) {

        #shop-order-aside {

            --soa-width: 420px;

            --soa-padding: 18px;

        }


        .shop-order-aside__product-image {

            width: 70px;
            height: 70px;

        }

    }


    /* =====================================================
       DESKTOP
       1200px+
    ===================================================== */

    @media (min-width: 1200px) {

        #shop-order-aside {

            --soa-width: 460px;

            --soa-padding: 20px;

        }


        .shop-order-aside__product-image {

            width: 75px;
            height: 75px;

        }


        .shop-order-aside__product {

            padding: 12px;

        }


        .shop-order-aside__product-name {

            font-size: 15px;

        }

    }

</style>
