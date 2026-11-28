<style id="show-card-product">
    /* =====================================================
SHOP PRODUCT CARD - CART CONTROLS
===================================================== */

    .shop-product-card--in-cart {

        border-color: #aebaff;

    }


    /* QUANTITY CONTAINER */

    .shop-product-card__quantity {

        display: inline-flex;

        align-items: center;
        justify-content: space-between;

        min-height: 34px;

        border: 1px solid #b9bffc;
        border-radius: 9px;

        background: #ffffff;

        overflow: hidden;

        flex-shrink: 0;

    }


    /* QUANTITY BUTTON */

    .shop-product-card__quantity-button {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 27px;
        height: 34px;

        flex-shrink: 0;

        padding: 0;
        margin: 0;

        border: 0;

        background: transparent;

        color: var(--spc-primary, #4455e9);

        font-size: 13px;

        cursor: pointer;

        touch-action: manipulation;

    }


    .shop-product-card__quantity-button:active {

        background: #eef0ff;

    }


    .shop-product-card__quantity-button:disabled {

        opacity: .4;

        cursor: not-allowed;

    }


    .shop-product-card__quantity-button i {

        pointer-events: none;

    }


    /* VALUE */

    .shop-product-card__quantity-value {

        min-width: 17px;

        padding: 0 2px;

        color: var(--spc-text, #151644);

        font-size: 13px;
        font-weight: 800;

        text-align: center;

        font-variant-numeric: tabular-nums;

    }


    /* TABLET AND DESKTOP */

    @media (min-width: 768px) {

        .shop-product-card__quantity-button {

            width: 35px;
            height: 38px;

            font-size: 16px;

        }

        .shop-product-card__quantity-value {

            min-width: 25px;

            font-size: 15px;

        }

    }
</style>
