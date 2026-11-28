<!-- =====================================================
     SHOP CART FOOTER
====================================================== -->

<footer
    id="shop-cart-footer"
    class="shop-cart-footer"
    v-show="cartFooterVisible"
    v-bind:class="{
        'shop-cart-footer--active': cartSummary.hasItems,
        'shop-cart-footer--empty': !cartSummary.hasItems
    }"
    v-cloak
>

    <button
        type="button"
        class="shop-cart-footer__button"
        v-on:click="onShopCartFooterClick($event)"
        v-bind:disabled="!cartSummary.hasItems"
        aria-label="Ver mi pedido"
    >

        <!-- CART ICON -->

        <span class="shop-cart-footer__icon-wrapper">

            <i class="bi bi-cart3"></i>

            <span
                class="shop-cart-footer__count"
                v-if="cartSummary.hasItems"
                v-text="cartSummary.quantity"
            ></span>

        </span>

        <!-- INFORMATION -->

        <span class="shop-cart-footer__information">

            <span
                class="shop-cart-footer__title"
                v-text="shopManager.cart.translations.title"
            ></span>

            <span
                class="shop-cart-footer__description"
                v-text="cartSummary.hasItems
                    ? cartQuantityText
                    : shopManager.cart.translations.empty"
            ></span>

            <span
                class="shop-cart-footer__points"
                v-if="
                    shopManager.cart.config.showPoints &&
                    cartSummary.hasPoints
                "
            >

                <i class="bi bi-coin"></i>

                <span
                    v-text="'+' + cartSummary.points + ' Yapitas'"
                ></span>

            </span>

        </span>

        <!-- TOTAL -->

        <span
            class="shop-cart-footer__total"
            v-if="cartSummary.hasItems"
        >

            <span
                class="shop-cart-footer__savings"
                v-if="
                    shopManager.cart.config.showDiscounts &&
                    cartSummary.hasDiscount
                "
                v-text="'Ahorras ' + formatCartMoney(
                    cartSummary.discountCents
                )"
            ></span>

            <strong
                class="shop-cart-footer__price"
                v-text="formatCartMoney(
                    cartSummary.totalCents
                )"
            ></strong>

        </span>

        <!-- VISUAL CTA -->

        <span class="shop-cart-footer__cta">

            <span
                v-text="shopManager.cart.translations.viewOrder"
            ></span>

            <i class="bi bi-chevron-right"></i>

        </span>

    </button>

</footer>
