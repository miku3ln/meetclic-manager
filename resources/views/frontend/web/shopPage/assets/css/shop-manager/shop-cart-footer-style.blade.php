<style id="shop-cart-footer-style">

    .shop-cart-footer {

        --scf-primary: var(--mc-azulClic, #4455e9);
        --scf-yellow: var(--mc-amarilloVital, #ffcc00);

        --scf-height: 76px;
        --scf-spacing: 10px;

        position: fixed;

        right: 0;
        bottom: 0;
        left: 0;

        z-index: 1030;

        padding: var(--scf-spacing);

        padding-bottom: calc(
            var(--scf-spacing) +
            env(safe-area-inset-bottom, 0px)
        );

        box-sizing: border-box;

        pointer-events: none;

    }


    .shop-cart-footer[v-cloak] {

        display: none !important;

    }


    /* MAIN BUTTON */

    .shop-cart-footer__button {

        display: flex;

        align-items: center;

        gap: 10px;

        width: 100%;
        min-height: var(--scf-height);

        max-width: 650px;

        margin: 0 auto;

        padding: 10px 12px;

        background: var(--scf-primary);

        border: 0;
        border-radius: 18px;

        box-shadow: 0 5px 24px rgba(44, 55, 150, .25);

        color: #ffffff;

        text-align: left;

        font-family: inherit;

        cursor: pointer;

        pointer-events: auto;

        touch-action: manipulation;

        box-sizing: border-box;

    }


    /* CART ICON */

    .shop-cart-footer__icon-wrapper {

        position: relative;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 34px;

        flex-shrink: 0;

        font-size: 28px;

    }


    .shop-cart-footer__count {

        position: absolute;

        top: -8px;
        right: -5px;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 20px;
        height: 20px;

        padding: 0 4px;

        border-radius: 999px;

        background: var(--scf-yellow);

        color: #172033;

        font-size: 11px;
        font-weight: 800;

    }


    /* INFORMATION */

    .shop-cart-footer__information {

        display: flex;

        flex-direction: column;

        flex: 1;

        min-width: 0;

        gap: 3px;

    }


    .shop-cart-footer__title {

        font-size: 14px;

        font-weight: 800;

        line-height: 1.2;

    }


    .shop-cart-footer__description {

        font-size: 11px;

        line-height: 1.2;

        opacity: .9;

    }


    /* YAPITAS */

    .shop-cart-footer__points {

        display: inline-flex;

        align-items: center;

        gap: 4px;

        color: #ffe36b;

        font-size: 10px;

        font-weight: 700;

        white-space: nowrap;

    }


    /* TOTAL */

    .shop-cart-footer__total {

        display: flex;

        flex-direction: column;

        align-items: flex-end;

        gap: 4px;

        flex-shrink: 0;

    }


    .shop-cart-footer__price {

        font-size: 20px;

        font-weight: 900;

        line-height: 1.1;

        font-variant-numeric: tabular-nums;

        white-space: nowrap;

    }


    .shop-cart-footer__savings {

        color: #bbf7d0;

        font-size: 10px;

        white-space: nowrap;

    }


    /* CTA */

    .shop-cart-footer__cta {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 5px;

        min-height: 40px;

        padding: 8px 10px;

        flex-shrink: 0;

        border-radius: 11px;

        background: var(--scf-yellow);

        color: #171a31;

        font-size: 11px;
        font-weight: 800;

        white-space: nowrap;

    }


    /* EMPTY STATE */

    .shop-cart-footer--empty
    .shop-cart-footer__button {

        background: #f1f5f9;

        color: #64748b;

        cursor: default;

    }


    .shop-cart-footer--empty
    .shop-cart-footer__cta {

        background: #cbd5e1;

        color: #64748b;

    }


    /* RESERVE SPACE IN CATALOG */

    #app-management.shop-manager--has-cart
    .manager-page__data-page {

        padding-bottom: calc(
            100px + env(safe-area-inset-bottom, 0px)
        ) !important;

    }


    /* SMALL MOBILE */

    @media (max-width: 359.98px) {

        .shop-cart-footer__button {

            gap: 7px;

            padding: 9px;

        }

        .shop-cart-footer__price {

            font-size: 17px;

        }

        .shop-cart-footer__cta {

            padding: 8px;

            font-size: 10px;

        }

        .shop-cart-footer__icon-wrapper {

            width: 28px;

            font-size: 24px;

        }

    }


    /* TABLET */

    @media (min-width: 768px) {

        .shop-cart-footer {

            bottom: 12px;

        }

        .shop-cart-footer__button {

            padding: 12px 20px;

            gap: 20px;

        }

        .shop-cart-footer__price {

            font-size: 25px;

        }

        .shop-cart-footer__cta {

            padding: 12px 20px;

            font-size: 14px;

        }

    }

</style>
