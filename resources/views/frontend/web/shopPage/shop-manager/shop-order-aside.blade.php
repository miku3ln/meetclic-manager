<!-- =====================================================
     SHOP ORDER ASIDE
====================================================== -->

<aside
    id="shop-order-aside"
    class="offcanvas offcanvas-end shop-order-aside"
    tabindex="-1"
    aria-labelledby="shop-order-aside-title"
    data-bs-backdrop="true"
    data-bs-keyboard="true"
    data-bs-scroll="false"
    v-cloak
>

    <!-- FIXED HEADER -->

    <div  class="shop-order-aside__header">

        <div class="shop-order-aside__heading">

            <i class="bi bi-cart3"></i>

            <h2
                id="shop-order-aside-title"
                class="shop-order-aside__title"
                v-text="shopManager.orderAside.translations.title"
            ></h2>

        </div>

        <button
            type="button"
            class="shop-order-aside__close"
            v-on:click="closeShopOrderAside()"
            aria-label="Cerrar pedido"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>


    <!-- SCROLLABLE BODY -->

    <div class="shop-order-aside__body">


        <!-- BUSINESS -->

        <section
            class="shop-order-aside__business"
            v-if="shopManager.orderAside.config.showBusiness"
        >

            <img
                class="shop-order-aside__business-logo"
                v-bind:src="businessInformation.information.source"
                v-bind:alt="businessInformation.information.title"
            >

            <div class="shop-order-aside__business-information">

                <strong
                    class="shop-order-aside__business-name"
                    v-text="businessInformation.information.title"
                ></strong>

                <span
                    class="shop-order-aside__business-category"
                    v-text="businessInformation.subcategory.title"
                ></span>

            </div>

            <i
                class="bi bi-whatsapp shop-order-aside__business-whatsapp"
                v-if="orderWhatsAppNumber"
            ></i>

        </section>


        <!-- PRODUCTS -->

        <section
            class="shop-order-aside__products"
            v-if="cartSummary.hasItems"
        >

            <div class="shop-order-aside__section-header">

                <h3
                    class="shop-order-aside__section-title"
                    v-text="'Productos (' + cartSummary.productCount + ')'"
                ></h3>

                <button
                    type="button"
                    class="shop-order-aside__clear"
                    v-on:click="clearShopCart()"
                >

                    <i class="bi bi-trash3"></i>

                    <span
                        v-text="shopManager.orderAside.translations.clear"
                    ></span>

                </button>

            </div>


            <!-- PRODUCT ITEM -->

            <article
                class="shop-order-aside__product"
                v-for="item in cartItems"
                v-bind:key="item.id"
            >

                <div class="shop-order-aside__product-main">

                    <img
                        class="shop-order-aside__product-image"
                        v-bind:src="item.image"
                        v-bind:alt="item.name"
                    >

                    <div class="shop-order-aside__product-information">

                        <strong
                            class="shop-order-aside__product-name"
                            v-text="item.name"
                        ></strong>


                        <!-- PRICE -->

                        <div class="shop-order-aside__product-prices">

                            <strong
                                class="shop-order-aside__product-price"
                                v-text="formatCartMoney(
                                    item.unitPriceCents
                                )"
                            ></strong>

                            <del
                                class="shop-order-aside__product-old-price"
                                v-if="
                                    item.hasDiscount &&
                                    shopManager.orderAside.config.showDiscounts
                                "
                                v-text="formatCartMoney(
                                    item.originalPriceCents
                                )"
                            ></del>

                            <span
                                class="shop-order-aside__discount"
                                v-if="
                                    item.hasDiscount &&
                                    shopManager.orderAside.config.showDiscounts
                                "
                                v-text="'-' + item.discountPercentage + '%'"
                            ></span>

                        </div>


                        <!-- YAPITAS -->

                        <span
                            class="shop-order-aside__points"
                            v-if="
                                item.points > 0 &&
                                shopManager.orderAside.config.showPoints
                            "
                        >

                            <i class="bi bi-coin"></i>

                            <span
                                v-text="'+' + getCartItemPoints(item) + ' Yapitas'"
                            ></span>

                        </span>

                    </div>


                    <!-- REMOVE -->

                    <button
                        type="button"
                        class="shop-order-aside__remove"
                        v-on:click="removeProductFromCart(item.id)"
                        v-bind:aria-label="'Eliminar ' + item.name"
                    >

                        <i class="bi bi-trash3"></i>

                    </button>

                </div>


                <!-- QUANTITY AND SUBTOTAL -->

                <div class="shop-order-aside__product-footer">

                    <div class="shop-order-aside__quantity">

                        <button
                            type="button"
                            class="shop-order-aside__quantity-button"
                            v-on:click="decreaseCartQuantity(item.id)"
                            v-bind:aria-label="'Disminuir cantidad de ' + item.name"
                        >

                            <i class="bi bi-dash-lg"></i>

                        </button>

                        <span
                            class="shop-order-aside__quantity-value"
                            v-text="item.quantity"
                            aria-live="polite"
                        ></span>

                        <button
                            type="button"
                            class="shop-order-aside__quantity-button"
                            v-on:click="increaseCartQuantity(item.id)"
                            v-bind:disabled="
                                item.quantity >=
                                shopManager.cart.config.maxQuantity
                            "
                            v-bind:aria-label="'Aumentar cantidad de ' + item.name"
                        >

                            <i class="bi bi-plus-lg"></i>

                        </button>

                    </div>

                    <strong
                        class="shop-order-aside__product-total"
                        v-text="formatCartMoney(
                            getCartItemTotal(item)
                        )"
                    ></strong>

                </div>

            </article>

        </section>


        <!-- EMPTY ORDER -->

        <section
            class="shop-order-aside__empty"
            v-if="!cartSummary.hasItems"
        >

            <i class="bi bi-cart-x"></i>

            <h3
                v-text="shopManager.orderAside.translations.emptyTitle"
            ></h3>

            <p
                v-text="shopManager.orderAside.translations.emptyDescription"
            ></p>

            <button
                type="button"
                class="shop-order-aside__continue"
                v-on:click="closeShopOrderAside()"
                v-text="shopManager.orderAside.translations.continueShopping"
            ></button>

        </section>


        <!-- NOTES -->

        <section
            class="shop-order-aside__notes"
            v-if="
                cartSummary.hasItems &&
                shopManager.orderAside.config.showNotes
            "
        >

            <label
                for="shop-order-notes"
                class="shop-order-aside__notes-label"
                v-text="shopManager.orderAside.translations.notes"
            ></label>

            <textarea
                id="shop-order-notes"
                class="shop-order-aside__notes-input"
                rows="3"
                maxlength="300"
                v-model.trim="shopManager.orderAside.notes"
                v-bind:placeholder="
                    shopManager.orderAside.translations.notesPlaceholder
                "
            ></textarea>

        </section>

    </div>


    <!-- FIXED ORDER FOOTER -->

    <div
        class="shop-order-aside__footer"
        v-if="cartSummary.hasItems"
    >

        <div class="shop-order-aside__summary">

            <!-- SUBTOTAL -->

            <div class="shop-order-aside__summary-row">

                <span
                    v-text="shopManager.orderAside.translations.subtotal"
                ></span>

                <strong
                    v-text="formatCartMoney(
                        cartSummary.subtotalCents
                    )"
                ></strong>

            </div>


            <!-- DISCOUNTS -->

            <div
                class="
                    shop-order-aside__summary-row
                    shop-order-aside__summary-row--discount
                "
                v-if="
                    shopManager.orderAside.config.showDiscounts &&
                    cartSummary.hasDiscount
                "
            >

                <span
                    v-text="shopManager.orderAside.translations.discounts"
                ></span>

                <strong
                    v-text="'-' + formatCartMoney(
                        cartSummary.discountCents
                    )"
                ></strong>

            </div>


            <!-- TOTAL -->

            <div
                class="
                    shop-order-aside__summary-row
                    shop-order-aside__summary-row--total
                "
            >

                <strong
                    v-text="shopManager.orderAside.translations.total"
                ></strong>

                <strong
                    class="shop-order-aside__total-value"
                    v-text="formatCartMoney(
                        cartSummary.totalCents
                    )"
                ></strong>

            </div>


            <!-- YAPITAS SUMMARY -->

            <div
                class="shop-order-aside__reward"
                v-if="
                    shopManager.orderAside.config.showPoints &&
                    cartSummary.hasPoints
                "
            >

                <i class="bi bi-coin"></i>

                <strong
                    v-text="
                        shopManager.orderAside.translations.earnPoints +
                        ' ' +
                        cartSummary.points +
                        ' Yapitas'
                    "
                ></strong>

            </div>

        </div>


        <!-- WHATSAPP -->

        <button
            type="button"
            class="shop-order-aside__send"
            v-on:click="onSendShopOrderClick($event)"
            v-bind:disabled="!canSendShopOrder"
        >

            <i class="bi bi-whatsapp"></i>

            <span
                v-text="shopManager.orderAside.translations.sendWhatsApp"
            ></span>

        </button>


        <!-- UNAVAILABLE PHONE -->

        <div
            class="shop-order-aside__error"
            v-if="!orderWhatsAppNumber"
            v-text="
                shopManager.orderAside.translations.unavailableWhatsApp
            "
        ></div>


        <!-- PROCESS ERROR -->

        <div
            class="shop-order-aside__error"
            v-if="shopManager.orderAside.error"
            v-text="shopManager.orderAside.error"
        ></div>


        <!-- INFORMATION -->

        <div class="shop-order-aside__confirmation">

            <i class="bi bi-info-circle"></i>

            <span
                v-text="shopManager.orderAside.translations.confirmation"
            ></span>

        </div>

    </div>

</aside>
