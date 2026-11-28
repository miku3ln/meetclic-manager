<style id="shop-product-aside-style">

    /* =====================================================
       SHOP PRODUCT ASIDE - BASE
    ===================================================== */

    #shop-product-aside {

        --spa-primary: var(--mc-azulClic, #4455e9);
        --spa-yellow: var(--mc-amarilloVital, #ffcc00);

        --spa-text: #151644;
        --spa-muted: #64748b;
        --spa-border: #e1e5ef;

        --spa-green: #15803d;
        --spa-danger: #dc2626;
        --spa-purple: #5535c9;

        --spa-background: #f7f8fc;
        --spa-surface: #ffffff;

        --spa-width: 100%;
        --spa-padding: 14px;

        --bs-offcanvas-width: var(--spa-width);

        position: fixed !important;
        inset: 0 0 0 auto !important;

        display: grid !important;

        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto minmax(0, 1fr) auto;

        width: var(--spa-width) !important;
        max-width: 100vw;

        height: 100vh !important;
        height: 100dvh !important;

        min-height: 0 !important;

        max-height: 100vh !important;
        max-height: 100dvh !important;

        margin: 0 !important;
        padding: 0 !important;

        border: 0;

        background: var(--spa-surface);
        color: var(--spa-text);

        font-family: inherit;
        text-align: left;

        overflow: hidden !important;

        box-sizing: border-box;

        box-shadow: -5px 0 30px rgba(0, 0, 0, .12);

        z-index: 11001 !important;

    }

    #shop-product-aside[v-cloak] {
        display: none !important;
    }

    .shop-product-aside * {
        box-sizing: border-box;
    }

    .shop-product-aside button {
        font-family: inherit;
        touch-action: manipulation;
    }


    /* =====================================================
       HEADER
    ===================================================== */

    #shop-product-aside > .shop-product-aside__header {

        grid-row: 1;

        position: relative !important;

        inset: auto !important;

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 10px;

        width: 100%;

        margin: 0;
        padding: 10px var(--spa-padding);

        background: var(--spa-surface);

        border-bottom: 1px solid var(--spa-border);

    }

    .shop-product-aside__heading {

        display: flex;
        align-items: center;

        gap: 9px;

        min-width: 0;

    }

    .shop-product-aside__heading > i {

        color: var(--spa-primary);
        font-size: 22px;

    }

    .shop-product-aside__title {

        margin: 0;
        padding: 0;

        color: var(--spa-text);

        font-family: inherit;
        font-size: 19px;
        font-weight: 800;

        line-height: 1.3;
        text-align: left;

    }

    .shop-product-aside__close {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 42px;
        height: 42px;

        flex-shrink: 0;

        padding: 0;

        border: 0;
        border-radius: 10px;

        background: transparent;
        color: var(--spa-primary);

        font-size: 18px;

        cursor: pointer;

    }


    /* =====================================================
       BODY - INDEPENDENT SCROLL
    ===================================================== */

    #shop-product-aside > .shop-product-aside__body {

        grid-row: 2;

        position: relative !important;

        inset: auto !important;

        display: flex !important;
        flex-direction: column !important;

        align-items: stretch;
        justify-content: flex-start;

        gap: 16px;

        width: 100% !important;
        height: auto !important;

        min-width: 0 !important;
        min-height: 0 !important;

        max-height: none !important;

        padding: var(--spa-padding);
        margin: 0 !important;

        overflow-x: hidden !important;
        overflow-y: auto !important;

        overscroll-behavior-y: contain;

        touch-action: pan-y;

        -webkit-overflow-scrolling: touch;

        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;

        float: none !important;

    }

    #shop-product-aside > .shop-product-aside__body > * {

        flex-shrink: 0 !important;

        width: 100%;
        min-width: 0;

    }


    /* =====================================================
       PRODUCT GALLERY
    ===================================================== */

    .shop-product-aside__gallery {

        display: flex;
        flex-direction: column;

        gap: 9px;

    }

    .shop-product-aside__media {

        position: relative;

        width: 100%;

        aspect-ratio: 16 / 10;

        overflow: hidden;

        border-radius: 15px;

        background: #f1f5f9;

    }

    .shop-product-aside__image {

        display: block;

        width: 100%;
        height: 100%;

        object-fit: cover;

    }

    .shop-product-aside__discount {

        position: absolute;

        top: 12px;
        left: 12px;

        z-index: 2;

        padding: 5px 10px;

        border-radius: 7px;

        background: var(--spa-danger);
        color: #ffffff;

        font-size: 13px;
        font-weight: 800;

    }


    /* GALLERY ARROWS */

    .shop-product-aside__gallery-arrow {

        position: absolute;

        top: 50%;

        transform: translateY(-50%);

        z-index: 2;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 34px;
        height: 34px;

        padding: 0;

        border: 0;
        border-radius: 50%;

        background: rgba(255, 255, 255, .94);

        color: var(--spa-primary);

        box-shadow: 0 2px 10px rgba(0, 0, 0, .14);

        cursor: pointer;

    }

    .shop-product-aside__gallery-arrow--previous {
        left: 8px;
    }

    .shop-product-aside__gallery-arrow--next {
        right: 8px;
    }

    .shop-product-aside__gallery-counter {

        position: absolute;

        bottom: 9px;
        left: 50%;

        transform: translateX(-50%);

        padding: 4px 10px;

        border-radius: 20px;

        background: rgba(0, 0, 0, .65);

        color: #ffffff;

        font-size: 11px;

    }


    /* THUMBNAILS */

    .shop-product-aside__thumbnails {

        display: flex;

        align-items: center;

        gap: 7px;

        padding: 2px;

        overflow-x: auto;
        overflow-y: hidden;

        scrollbar-width: thin;

        overscroll-behavior-x: contain;

    }

    .shop-product-aside__thumbnail {

        display: block;

        width: 56px;
        height: 56px;

        flex-shrink: 0;

        padding: 2px;

        border: 2px solid var(--spa-border);
        border-radius: 10px;

        background: #ffffff;

        overflow: hidden;

        cursor: pointer;

    }

    .shop-product-aside__thumbnail--active {

        border-color: var(--spa-primary);

    }

    .shop-product-aside__thumbnail-image {

        display: block;

        width: 100%;
        height: 100%;

        border-radius: 5px;

        object-fit: cover;

    }


    /* =====================================================
       PRODUCT INFORMATION
    ===================================================== */

    .shop-product-aside__information {

        display: flex;
        flex-direction: column;

        gap: 9px;

    }

    .shop-product-aside__categories {

        display: flex;

        align-items: center;
        flex-wrap: wrap;

        gap: 6px;

        font-size: 11px;

    }

    .shop-product-aside__category {

        padding: 4px 8px;

        border-radius: 6px;

        background: #eef2ff;

        color: var(--spa-primary);

        font-weight: 700;

    }

    .shop-product-aside__categories > i {

        color: #94a3b8;
        font-size: 9px;

    }

    .shop-product-aside__subcategory {

        color: var(--spa-muted);

        font-weight: 500;

    }

    .shop-product-aside__name-row {

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 10px;

    }

    .shop-product-aside__name {

        flex: 1;

        min-width: 0;

        margin: 0;
        padding: 0;

        color: var(--spa-text);

        font-family: inherit;
        font-size: 27px;
        font-weight: 800;

        line-height: 1.2;

        text-align: left;
        overflow-wrap: anywhere;

    }

    .shop-product-aside__code {

        color: var(--spa-muted);

        font-size: 11px;

    }


    /* =====================================================
       FAVORITE AND SHARE
    ===================================================== */

    .shop-product-aside__actions {

        display: flex;

        align-items: center;

        flex-shrink: 0;

        gap: 7px;

    }

    .shop-product-aside__action {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 42px;
        height: 42px;

        padding: 0;

        border: 1px solid var(--spa-border);
        border-radius: 12px;

        background: #ffffff;
        color: var(--spa-primary);

        font-size: 19px;

        cursor: pointer;

    }

    .shop-product-aside__action--favorite {

        color: #e11d48;

    }

    .shop-product-aside__action--favorite-active {

        border-color: #fecdd3;

        background: #fff1f2;

        color: #e11d48;

    }


    /* =====================================================
       PRICE INFORMATION
    ===================================================== */

    .shop-product-aside__pricing {

        display: flex;
        flex-direction: column;

        gap: 7px;

    }

    .shop-product-aside__prices {

        display: flex;

        align-items: center;
        flex-wrap: wrap;

        gap: 10px;

    }

    .shop-product-aside__price {

        display: inline-flex;
        align-items: center;

        padding: 3px 10px;

        border-radius: 8px;

        color: var(--spa-text);

        font-size: 29px;
        font-weight: 900;

        line-height: 1.3;

        font-variant-numeric: tabular-nums;

    }

    .shop-product-aside__price--without-tax {

        background: #fff0a6;

    }

    .shop-product-aside__price--with-tax {

        background: #dcfce7;

        color: #166534;

    }

    .shop-product-aside__price--unknown-tax {

        background: #f1f5f9;

    }

    .shop-product-aside__old-price {

        color: #94a3b8;

        font-size: 15px;

        text-decoration: line-through;

    }

    .shop-product-aside__discount-label {

        padding: 4px 7px;

        border-radius: 7px;

        background: #fee2e2;

        color: #b91c1c;

        font-size: 12px;
        font-weight: 800;

    }


    /* SAVINGS AND TAX */

    .shop-product-aside__price-details {

        display: flex;

        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

    }

    .shop-product-aside__savings {

        color: var(--spa-green);

        font-size: 11px;
        font-weight: 600;

    }

    .shop-product-aside__tax {

        margin-left: auto;

        padding: 4px 8px;

        border-radius: 6px;

        font-size: 10px;
        font-weight: 600;

        color: var(--spa-muted);

        background: #f1f5f9;

    }

    .shop-product-aside__tax--with-tax {

        color: #166534;
        background: #dcfce7;

    }

    .shop-product-aside__tax--without-tax {

        color: #854d0e;
        background: #fff4cc;

    }

    .shop-product-aside__stock {

        display: flex;

        align-items: center;

        gap: 6px;

        color: var(--spa-muted);

        font-size: 12px;

    }


    /* =====================================================
       YAPITAS REWARD
    ===================================================== */

    .shop-product-aside__reward {

        display: flex;

        align-items: center;

        gap: 11px;

        padding: 13px;

        border: 1px solid #e7dcff;
        border-radius: 14px;

        background: linear-gradient(
            135deg,
            #f5efff,
            #eee8ff
        );

        color: var(--spa-purple);

    }

    .shop-product-aside__reward-icon {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 42px;
        height: 42px;

        flex-shrink: 0;

        border-radius: 50%;

        background: var(--spa-yellow);

        color: #956500;

        font-size: 24px;

    }

    .shop-product-aside__reward-content {

        display: flex;
        flex-direction: column;

        flex: 1;

        min-width: 0;

        gap: 4px;

    }

    .shop-product-aside__reward-title {

        font-size: 17px;
        font-weight: 800;

        line-height: 1.2;

    }

    .shop-product-aside__reward-description {

        font-size: 11px;

        line-height: 1.4;

    }

    .shop-product-aside__reward-decoration {

        font-size: 21px;

        flex-shrink: 0;

    }


    /* =====================================================
       DESCRIPTION
    ===================================================== */

    .shop-product-aside__description {

        display: flex;
        flex-direction: column;

        gap: 7px;

    }

    .shop-product-aside__section-title {

        margin: 0;
        padding: 0;

        color: var(--spa-text);

        font-family: inherit;

        font-size: 16px;
        font-weight: 800;

        text-align: left;

    }

    .shop-product-aside__description-text {

        margin: 0;
        padding: 0;

        color: var(--spa-muted);

        font-size: 13px;

        line-height: 1.65;

        text-align: left;

        white-space: pre-line;

        overflow-wrap: anywhere;

    }


    /* =====================================================
       PROMOTIONS
    ===================================================== */

    .shop-product-aside__promotions {

        display: flex;
        flex-direction: column;

        gap: 10px;

        padding: 11px;

        border: 1px solid #f8e0b0;
        border-radius: 14px;

        background: #fff7e8;

        color: #92400e;

    }

    .shop-product-aside__promotions-header {

        display: flex;

        align-items: center;

        gap: 9px;

        width: 100%;

        padding: 2px;

        border: 0;

        background: transparent;
        color: inherit;

        text-align: left;

        cursor: pointer;

    }

    .shop-product-aside__promotions-icon {

        flex-shrink: 0;

        font-size: 25px;

        color: #d97706;

    }

    .shop-product-aside__promotions-heading {

        display: flex;
        flex-direction: column;

        gap: 4px;

        flex: 1;

        min-width: 0;

    }

    .shop-product-aside__promotions-heading > strong {

        font-size: 13px;

        font-weight: 800;

    }

    .shop-product-aside__promotions-heading > small {

        font-size: 10px;

        line-height: 1.4;

    }

    .shop-product-aside__promotions-count {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 23px;
        height: 23px;

        padding: 0 5px;

        border-radius: 50%;

        background: #ffdfa1;

        font-size: 11px;
        font-weight: 800;

    }


    /* PROMOTIONS LIST */

    .shop-product-aside__promotions-list {

        display: flex;
        flex-direction: column;

        gap: 7px;

    }

    .shop-product-aside__promotion {

        display: flex;

        align-items: center;

        gap: 9px;

        width: 100%;

        padding: 8px;

        border: 0;
        border-radius: 10px;

        background: #ffffff;
        color: var(--spa-text);

        text-align: left;

        cursor: pointer;

    }

    .shop-product-aside__promotion-image {

        display: block;

        width: 65px;
        height: 65px;

        flex-shrink: 0;

        object-fit: cover;

        border-radius: 8px;

    }

    .shop-product-aside__promotion-content {

        display: flex;
        flex-direction: column;

        flex: 1;

        min-width: 0;

        gap: 4px;

    }

    .shop-product-aside__promotion-name {

        font-size: 13px;

        font-weight: 800;

    }

    .shop-product-aside__promotion-description {

        color: var(--spa-muted);

        font-size: 11px;

        line-height: 1.4;

        overflow-wrap: anywhere;

    }

    .shop-product-aside__promotion-price {

        align-self: flex-start;

        padding: 3px 7px;

        border-radius: 6px;

        background: var(--spa-yellow);

        color: var(--spa-text);

        font-size: 14px;

        font-weight: 800;

    }

    .shop-product-aside__mock {

        font-size: 10px;

        color: var(--spa-muted);

    }


    /* =====================================================
       BUSINESS INFORMATION
    ===================================================== */

    .shop-product-aside__business {

        display: flex;

        align-items: center;

        gap: 11px;

        width: 100%;

        padding: 10px;

        border: 1px solid var(--spa-border);
        border-radius: 13px;

        background: var(--spa-surface);

        color: var(--spa-text);

        text-align: left;

        cursor: pointer;

    }

    .shop-product-aside__business-logo {

        display: block;

        width: 47px;
        height: 47px;

        flex-shrink: 0;

        border-radius: 50%;

        object-fit: cover;

    }

    .shop-product-aside__business-information {

        display: flex;
        flex-direction: column;

        flex: 1;

        min-width: 0;

        gap: 3px;

    }

    .shop-product-aside__business-label {

        color: var(--spa-muted);

        font-size: 10px;

    }

    .shop-product-aside__business-name {

        font-size: 14px;
        font-weight: 800;

    }

    .shop-product-aside__business-category {

        font-size: 11px;

        color: var(--spa-muted);

    }

    .shop-product-aside__business > i {

        color: var(--spa-primary);

        font-size: 16px;

    }
    /* =====================================================
       PRODUCT ASIDE - FIXED FOOTER
    ===================================================== */

    .shop-product-aside__footer {

        grid-row: 3;

        position: relative !important;

        inset: auto !important;

        display: flex !important;

        flex-direction: column;

        align-items: stretch;

        gap: 12px;

        width: 100% !important;

        min-width: 0;

        height: auto !important;

        min-height: 0;

        margin: 0 !important;

        padding: 14px var(--spa-padding, 14px);

        padding-bottom: calc(
            14px + env(safe-area-inset-bottom, 0px)
        );

        overflow: visible !important;

        background: var(--spa-surface, #ffffff);

        border-top: 1px solid var(--spa-border, #e1e5ef);

        box-shadow: 0 -5px 20px rgba(0, 0, 0, .06);

        box-sizing: border-box;

        float: none !important;

        z-index: 5;

    }


    /* =====================================================
       QUANTITY ROW
    ===================================================== */

    .shop-product-aside__quantity-row {

        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 12px;

        width: 100%;

        min-width: 0;

        margin: 0;

        padding: 0;

    }


    /* =====================================================
       QUANTITY INFORMATION
    ===================================================== */

    .shop-product-aside__quantity-information {

        display: flex;

        flex-direction: column;

        align-items: flex-start;

        flex: 1;

        min-width: 0;

        gap: 4px;

        text-align: left;

    }

    .shop-product-aside__quantity-label {

        display: block;

        color: var(--spa-text, #151644);

        font-size: 14px;

        font-weight: 700;

        line-height: 1.3;

        text-align: left;

    }

    .shop-product-aside__quantity-description {

        display: block;

        color: var(--spa-muted, #64748b);

        font-size: 12px;

        font-weight: 400;

        line-height: 1.4;

        text-align: left;

    }


    /* =====================================================
       QUANTITY CONTROLLER
    ===================================================== */

    .shop-product-aside__quantity {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        gap: 0;

        min-height: 44px;

        padding: 0;

        border: 1px solid #c3c9ff;

        border-radius: 11px;

        background: #ffffff;

        overflow: hidden;

        box-sizing: border-box;

    }


    /* =====================================================
       QUANTITY BUTTONS
    ===================================================== */

    .shop-product-aside__quantity-button {

        display: inline-flex !important;

        align-items: center;
        justify-content: center;

        width: 44px;
        height: 44px;

        min-width: 44px;

        flex-shrink: 0;

        padding: 0 !important;
        margin: 0 !important;

        border: 0 !important;

        border-radius: 0;

        background: transparent;

        color: var(--spa-primary, #4455e9);

        font-size: 18px;

        line-height: 1;

        cursor: pointer;

        touch-action: manipulation;

        user-select: none;

        box-shadow: none;

        transition:

            background .15s ease,

            opacity .15s ease;

    }


    /* DECREASE */

    .shop-product-aside__quantity-button--decrease {

        background: #ffffff;

        color: var(--spa-primary, #4455e9);

    }


    /* INCREASE */

    .shop-product-aside__quantity-button--increase {

        background: var(--spa-primary, #4455e9);

        color: #ffffff;

    }


    /* DISABLED */

    .shop-product-aside__quantity-button:disabled {

        background: #f8fafc;

        color: #94a3b8;

        opacity: .5;

        cursor: not-allowed;

    }


    /* ACTIVE */

    .shop-product-aside__quantity-button--decrease:active:not(:disabled) {

        background: #eef2ff;

    }

    .shop-product-aside__quantity-button--increase:active:not(:disabled) {

        filter: brightness(.85);

    }


    /* =====================================================
       QUANTITY VALUE
    ===================================================== */

    .shop-product-aside__quantity-value {

        display: flex;

        align-items: center;
        justify-content: center;

        min-width: 36px;

        min-height: 44px;

        padding: 0 6px;

        color: var(--spa-text, #151644);

        font-size: 16px;

        font-weight: 800;

        line-height: 1;

        text-align: center;

        font-variant-numeric: tabular-nums;

        user-select: none;

    }


    /* =====================================================
       CART SUMMARY
    ===================================================== */

    .shop-product-aside__cart-summary {

        position: relative;

        display: flex !important;

        align-items: center;

        gap: 10px;

        width: 100%;

        min-width: 0;

        min-height: 68px;

        padding: 12px;

        margin: 0;

        box-sizing: border-box;

        border: 1px solid #dfe4ff;

        border-radius: 13px;

        background: #eef2ff;

        text-align: left;

        cursor: default;

        transition:

            background .2s ease,

            border-color .2s ease;

    }


    /* =====================================================
       CART SUMMARY - ACTIVE STATE
    ===================================================== */

    .shop-product-aside__cart-summary--active {

        background: #eef2ff;

        border-color: #c3c9ff;

    }


    /* =====================================================
       CART SUMMARY - EMPTY STATE
    ===================================================== */

    .shop-product-aside__cart-summary--empty {

        background: #f7f8fc;

        border-color: #e1e5ef;

    }

    .shop-product-aside__cart-summary--empty
    .shop-product-aside__cart-summary-price {

        color: #94a3b8;

    }

    .shop-product-aside__cart-summary--empty
    .shop-product-aside__cart-summary-icon {

        color: #94a3b8;

    }


    /* =====================================================
       CART SUMMARY - ICON
    ===================================================== */

    .shop-product-aside__cart-summary-icon {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        width: 42px;
        height: 42px;

        border-radius: 11px;

        background: #ffffff;

        color: var(--spa-primary, #4455e9);

        font-size: 23px;

        line-height: 1;

    }


    /* =====================================================
       CART SUMMARY - INFORMATION
    ===================================================== */

    .shop-product-aside__cart-summary-information {

        display: flex !important;

        flex-direction: column;

        align-items: flex-start;

        flex: 1;

        min-width: 0;

        gap: 4px;

        text-align: left;

    }

    .shop-product-aside__cart-summary-title {

        display: block;

        color: var(--spa-text, #151644);

        font-size: 13px;

        font-weight: 800;

        line-height: 1.35;

        text-align: left;

    }

    .shop-product-aside__cart-summary-description {

        display: block;

        color: var(--spa-muted, #64748b);

        font-size: 12px;

        font-weight: 400;

        line-height: 1.4;

        text-align: left;

        overflow-wrap: anywhere;

    }


    /* =====================================================
       CART SUMMARY - PRICE
    ===================================================== */

    .shop-product-aside__cart-summary-price {

        display: block;

        flex-shrink: 0;

        margin-left: auto;

        color: var(--spa-primary, #4455e9);

        font-size: 25px;

        font-weight: 900;

        line-height: 1.2;

        text-align: right;

        white-space: nowrap;

        font-variant-numeric: tabular-nums;

    }


    /* =====================================================
       YAPITAS ESTIMATED
    ===================================================== */

    .shop-product-aside__quantity-points {

        display: inline-flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 4px;

        color: var(--spa-purple, #5535c9);

        font-size: 11px;

        font-weight: 700;

        line-height: 1.4;

    }


    /* =====================================================
       DISCOUNT SAVINGS
    ===================================================== */

    .shop-product-aside__quantity-savings {

        display: block;

        color: var(--spa-green, #15803d);

        font-size: 11px;

        font-weight: 700;

        line-height: 1.4;

    }


    /* =====================================================
       FLOATING FEEDBACK
    ===================================================== */

    .shop-product-aside__feedback {

        position: absolute;

        top: auto;

        bottom: calc(100% + 10px);

        left: var(--spa-padding, 14px);
        right: var(--spa-padding, 14px);

        z-index: 10;

        display: flex !important;

        align-items: center;

        gap: 8px;

        width: auto;

        min-height: 42px;

        padding: 10px 12px;

        margin: 0;

        border-radius: 11px;

        box-sizing: border-box;

        font-size: 12px;

        font-weight: 700;

        line-height: 1.4;

        text-align: left;

        box-shadow: 0 4px 16px rgba(0, 0, 0, .10);

        pointer-events: none;

    }


    /* SUCCESS */

    .shop-product-aside__feedback--success {

        background: #dcfce7;

        color: #15803d;

        border: 1px solid #bbf7d0;

    }


    /* INFORMATION */

    .shop-product-aside__feedback--info {

        background: #f1f5f9;

        color: #475569;

        border: 1px solid #e2e8f0;

    }


    /* FEEDBACK MESSAGE */

    .shop-product-aside__feedback-message {

        display: block;

        flex: 1;

        min-width: 0;

        text-align: left;

        overflow-wrap: anywhere;

    }


    /* =====================================================
       ERROR MESSAGE
    ===================================================== */

    .shop-product-aside__error {

        display: block;

        width: 100%;

        padding: 9px 12px;

        border: 1px solid #fecaca;

        border-radius: 9px;

        background: #fee2e2;

        color: #b91c1c;

        font-size: 12px;

        line-height: 1.4;

        text-align: left;

        overflow-wrap: anywhere;

    }


    /* =====================================================
       FEEDBACK TRANSITIONS - VUE 2
    ===================================================== */

    .shop-product-feedback-enter-active,
    .shop-product-feedback-leave-active {

        transition:

            opacity .2s ease,

            transform .2s ease;

    }

    .shop-product-feedback-enter,
    .shop-product-feedback-leave-to {

        opacity: 0;

        transform: translateY(6px);

    }


    /* =====================================================
       HOVER INTERACTIONS
    ===================================================== */

    @media (hover: hover) {

        .shop-product-aside__quantity-button--decrease:hover:not(:disabled) {

            background: #eef2ff;

        }

        .shop-product-aside__quantity-button--increase:hover:not(:disabled) {

            background: var(--spa-primary, #4455e9);

            filter: brightness(.92);

        }

    }


    /* =====================================================
       SMALL MOBILE
    ===================================================== */

    @media (max-width: 359.98px) {

        .shop-product-aside__footer {

            gap: 9px;

        }

        .shop-product-aside__quantity-row {

            gap: 8px;

        }

        .shop-product-aside__quantity-button {

            width: 38px;

            min-width: 38px;

        }

        .shop-product-aside__quantity-value {

            min-width: 28px;

        }

        .shop-product-aside__quantity-label {

            font-size: 12px;

        }

        .shop-product-aside__quantity-description {

            font-size: 10px;

        }

        .shop-product-aside__cart-summary {

            gap: 8px;

            padding: 9px;

        }

        .shop-product-aside__cart-summary-icon {

            width: 34px;
            height: 34px;

            font-size: 19px;

        }

        .shop-product-aside__cart-summary-price {

            font-size: 21px;

        }

        .shop-product-aside__cart-summary-title {

            font-size: 12px;

        }

    }


    /* =====================================================
       TABLET
    ===================================================== */

    @media (min-width: 768px) and (max-width: 1199.98px) {

        .shop-product-aside__cart-summary {

            min-height: 74px;

        }

    }


    /* =====================================================
       DESKTOP
    ===================================================== */

    @media (min-width: 1200px) {

        .shop-product-aside__cart-summary {

            min-height: 78px;

            padding: 14px;

        }

        .shop-product-aside__cart-summary-price {

            font-size: 28px;

        }

    }


    /* =====================================================
       REDUCED MOTION
    ===================================================== */

    @media (prefers-reduced-motion: reduce) {

        .shop-product-feedback-enter-active,
        .shop-product-feedback-leave-active,
        .shop-product-aside__cart-summary,
        .shop-product-aside__quantity-button {

            transition: none;

        }

    }
    a.to-top.to-top--bee {
        right: 23px;
        bottom: 10%;
    }
</style>
