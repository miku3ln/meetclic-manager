<!-- =====================================================
     SHOP PRODUCT ASIDE
====================================================== -->

<aside
    id="shop-product-aside"
    class="offcanvas offcanvas-end shop-product-aside"
    tabindex="-1"
    aria-labelledby="shop-product-aside-title"
    data-bs-backdrop="true"
    data-bs-keyboard="true"
    data-bs-scroll="false"
    v-cloak
>

    <!-- ==============================================
         HEADER
    =============================================== -->

    <div class="shop-product-aside__header">

        <div class="shop-product-aside__heading">

            <i class="bi bi-box-seam"></i>

            <h2
                id="shop-product-aside-title"
                class="shop-product-aside__title"
                v-text="productAsideTranslations.title"
            ></h2>

        </div>

        <button
            type="button"
            class="shop-product-aside__close"
            v-on:click="closeShopProductAside()"
            v-bind:aria-label="productAsideTranslations.close"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>


    <!-- ==============================================
         SCROLLABLE BODY
    =============================================== -->

    <div
        class="shop-product-aside__body"
        v-if="productAsideData"
    >

        <!-- ==========================================
             PRODUCT GALLERY
        =========================================== -->

        <div
            class="shop-product-aside__gallery"
            v-if="productAsideConfig.showGallery"
        >

            <div class="shop-product-aside__media">

                <img
                    class="shop-product-aside__image"
                    v-bind:src="productAsideActiveImage"
                    v-bind:alt="productAsideData.name"
                >

                <!-- DISCOUNT -->

                <span
                    class="shop-product-aside__discount"
                    v-if="
                        productAsideConfig.showDiscount &&
                        productAsideData.price.hasDiscount
                    "
                    v-text="'-' + productAsideData.price.discount + '%'"
                ></span>


                <!-- GALLERY NAVIGATION -->

                <template
                    v-if="productAsideData.gallery.length > 1"
                >

                    <button
                        type="button"
                        class="
                            shop-product-aside__gallery-arrow
                            shop-product-aside__gallery-arrow--previous
                        "
                        v-on:click="previousShopProductImage()"
                        v-bind:aria-label="
                            productAsideTranslations.previousImage
                        "
                    >

                        <i class="bi bi-chevron-left"></i>

                    </button>

                    <button
                        type="button"
                        class="
                            shop-product-aside__gallery-arrow
                            shop-product-aside__gallery-arrow--next
                        "
                        v-on:click="nextShopProductImage()"
                        v-bind:aria-label="
                            productAsideTranslations.nextImage
                        "
                    >

                        <i class="bi bi-chevron-right"></i>

                    </button>

                    <span
                        class="shop-product-aside__gallery-counter"
                        v-text="
                            (productAsideState.activeImageIndex + 1) +
                            ' / ' +
                            productAsideData.gallery.length
                        "
                    ></span>

                </template>

            </div>


            <!-- THUMBNAILS -->

            <div
                class="shop-product-aside__thumbnails"
                v-if="productAsideData.gallery.length > 1"
            >

                <button
                    type="button"
                    class="shop-product-aside__thumbnail"
                    v-for="(image, index) in productAsideData.gallery"
                    v-bind:key="image.id"
                    v-bind:class="{
                        'shop-product-aside__thumbnail--active':
                            productAsideState.activeImageIndex === index
                    }"
                    v-bind:aria-label="'Ver imagen ' + (index + 1)"
                    v-bind:aria-pressed="
                        productAsideState.activeImageIndex === index
                    "
                    v-on:click="setShopProductImage(index)"
                >

                    <img
                        class="shop-product-aside__thumbnail-image"
                        v-bind:src="image.source"
                        v-bind:alt="productAsideData.name"
                    >

                </button>

            </div>

        </div>


        <!-- ==========================================
             PRODUCT INFORMATION
        =========================================== -->

        <div class="shop-product-aside__information">

            <!-- CATEGORY AND SUBCATEGORY -->

            <div class="shop-product-aside__categories">

                <span
                    class="shop-product-aside__category"
                    v-if="
                        productAsideConfig.showCategory &&
                        productAsideData.category
                    "
                    v-text="productAsideData.category"
                ></span>

                <i
                    class="bi bi-chevron-right"
                    v-if="
                        productAsideConfig.showCategory &&
                        productAsideData.category &&
                        productAsideConfig.showSubcategory &&
                        productAsideData.subcategory
                    "
                ></i>

                <span
                    class="shop-product-aside__subcategory"
                    v-if="
                        productAsideConfig.showSubcategory &&
                        productAsideData.subcategory
                    "
                    v-text="productAsideData.subcategory"
                ></span>

            </div>


            <!-- NAME AND ACTIONS -->

            <div class="shop-product-aside__name-row">

                <h3
                    class="shop-product-aside__name"
                    v-text="productAsideData.name"
                ></h3>

                <div class="shop-product-aside__actions">

                    <!-- FAVORITE -->

                    <button
                        type="button"
                        class="
                            shop-product-aside__action
                            shop-product-aside__action--favorite
                        "
                        v-if="productAsideConfig.showFavorite"
                        v-bind:class="{
                            'shop-product-aside__action--favorite-active':
                                productAsideIsFavorite
                        }"
                        v-bind:aria-pressed="productAsideIsFavorite"
                        v-bind:aria-label="
                            productAsideIsFavorite
                                ? productAsideTranslations.removeFavorite
                                : productAsideTranslations.favorite
                        "
                        v-on:click="toggleShopProductFavorite()"
                    >

                        <i
                            v-bind:class="
                                productAsideIsFavorite
                                    ? 'bi bi-heart-fill'
                                    : 'bi bi-heart'
                            "
                        ></i>

                    </button>


                    <!-- SHARE -->

                    <button
                        type="button"
                        class="
                            shop-product-aside__action
                            shop-product-aside__action--share
                        "
                        v-if="productAsideConfig.showShare"
                        v-bind:aria-label="productAsideTranslations.share"
                        v-on:click="onShareShopProductClick()"
                    >

                        <i class="bi bi-share"></i>

                    </button>

                </div>

            </div>


            <!-- PRODUCT CODE -->

            <div
                class="shop-product-aside__code"
                v-if="
                    productAsideConfig.showCode &&
                    productAsideData.code
                "
                v-text="
                    productAsideTranslations.code +
                    ': ' +
                    productAsideData.code
                "
            ></div>


            <!-- PRICE -->

            <div
                class="shop-product-aside__pricing"
                v-if="productAsideConfig.showPrice"
            >

                <div class="shop-product-aside__prices">

                    <strong
                        class="shop-product-aside__price"
                        v-bind:class="
                            'shop-product-aside__price--' +
                            productAsideData.tax.modifier
                        "
                        v-text="productAsideData.price.currentText"
                    ></strong>

                    <del
                        class="shop-product-aside__old-price"
                        v-if="
                            productAsideConfig.showOldPrice &&
                            productAsideData.price.hasDiscount
                        "
                        v-text="productAsideData.price.oldText"
                    ></del>

                    <span
                        class="shop-product-aside__discount-label"
                        v-if="
                            productAsideConfig.showDiscount &&
                            productAsideData.price.hasDiscount
                        "
                        v-text="
                            '-' +
                            productAsideData.price.discount +
                            '%'
                        "
                    ></span>

                </div>


                <!-- SAVINGS AND TAX -->

                <div class="shop-product-aside__price-details">

                    <span
                        class="shop-product-aside__savings"
                        v-if="
                            productAsideConfig.showDiscount &&
                            productAsideData.price.hasDiscount
                        "
                        v-text="
                            productAsideTranslations.savings +
                            ' ' +
                            formatCartMoney(
                                productAsideData.price.discountCents
                            ) +
                            ' ' +
                            productAsideTranslations.perUnit
                        "
                    ></span>

                    <span
                        class="shop-product-aside__tax"
                        v-if="productAsideConfig.showTax"
                        v-bind:class="
                            'shop-product-aside__tax--' +
                            productAsideData.tax.modifier
                        "
                        v-text="productAsideData.tax.detail"
                    ></span>

                </div>

            </div>


            <!-- STOCK -->

            <div
                class="shop-product-aside__stock"
                v-if="
                    productAsideConfig.showStock &&
                    productAsideData.stock.quantity !== null
                "
            >

                <i class="bi bi-boxes"></i>

                <span
                    v-text="
                        productAsideTranslations.stock +
                        ': ' +
                        productAsideData.stock.quantity +
                        ' ' +
                        productAsideData.stock.unit
                    "
                ></span>

            </div>

        </div>


        <!-- ==========================================
             YAPITAS REWARDS
        =========================================== -->

        <div
            class="shop-product-aside__reward"
            v-if="
                productAsideConfig.showPoints &&
                productAsideData.points > 0
            "
        >

            <span class="shop-product-aside__reward-icon">

                <i class="bi bi-coin"></i>

            </span>

            <div class="shop-product-aside__reward-content">

                <strong
                    class="shop-product-aside__reward-title"
                    v-text="
                        productAsideTranslations.earnPoints +
                        ' ' +
                        productAsideData.points +
                        ' ' +
                        productAsideTranslations.points
                    "
                ></strong>

                <span
                    class="shop-product-aside__reward-description"
                    v-text="
                        productAsideTranslations.pointsDescription
                    "
                ></span>

            </div>

            <i class="
                bi bi-stars
                shop-product-aside__reward-decoration
            "></i>

        </div>


        <!-- ==========================================
             DESCRIPTION
        =========================================== -->

        <div
            class="shop-product-aside__description"
            v-if="
                productAsideConfig.showDescription &&
                productAsideData.description
            "
        >

            <h4
                class="shop-product-aside__section-title"
                v-text="productAsideTranslations.description"
            ></h4>

            <p
                class="shop-product-aside__description-text"
                v-text="productAsideData.description"
            ></p>

        </div>


        <!-- ==========================================
             PROMOTIONS ACCORDION
        =========================================== -->

        <div
            class="shop-product-aside__promotions"
            v-if="
                productAsideConfig.showPromotions &&
                productAsideData.promotions.length
            "
        >

            <button
                type="button"
                class="shop-product-aside__promotions-header"
                v-on:click="toggleShopProductPromotions()"
                v-bind:aria-expanded="
                    productAsideState.promotionsExpanded
                "
                aria-controls="shop-product-promotions-list"
            >

                <span class="shop-product-aside__promotions-icon">

                    <i class="bi bi-gift-fill"></i>

                </span>

                <span class="shop-product-aside__promotions-heading">

                    <strong
                        v-text="productAsideTranslations.promotions"
                    ></strong>

                    <small
                        v-text="
                            productAsideTranslations.promotionsDescription
                        "
                    ></small>

                </span>

                <span
                    class="shop-product-aside__promotions-count"
                    v-text="productAsideData.promotions.length"
                ></span>

                <i
                    v-bind:class="
                        productAsideState.promotionsExpanded
                            ? 'bi bi-chevron-up'
                            : 'bi bi-chevron-down'
                    "
                ></i>

            </button>


            <!-- PROMOTIONS LIST -->

            <div
                id="shop-product-promotions-list"
                class="shop-product-aside__promotions-list"
                v-show="productAsideState.promotionsExpanded"
            >

                <button
                    type="button"
                    class="shop-product-aside__promotion"
                    v-for="promotion in productAsideData.promotions"
                    v-bind:key="promotion.id"
                    v-on:click="onShopProductPromotionClick(promotion)"
                >

                    <img
                        class="shop-product-aside__promotion-image"
                        v-if="promotion.image"
                        v-bind:src="
                            getProductImage(
                                promotion.image,
                                productAsideData.image
                            )
                        "
                        v-bind:alt="promotion.name"
                    >

                    <span class="shop-product-aside__promotion-content">

                        <strong
                            class="shop-product-aside__promotion-name"
                            v-text="promotion.name"
                        ></strong>

                        <span
                            class="shop-product-aside__promotion-description"
                            v-text="promotion.description"
                        ></span>

                        <strong
                            class="shop-product-aside__promotion-price"
                            v-if="promotion.priceCents !== null"
                            v-text="
                                formatCartMoney(promotion.priceCents)
                            "
                        ></strong>

                        <small
                            class="shop-product-aside__mock"
                            v-if="promotion.isMock"
                        >
                            Demostración
                        </small>

                    </span>

                    <i class="bi bi-chevron-right"></i>

                </button>

            </div>

        </div>


        <!-- ==========================================
             BUSINESS INFORMATION
        =========================================== -->

        <button
            type="button"
            class="shop-product-aside__business"
            v-if="productAsideConfig.showBusiness"
            v-on:click="onShopProductBusinessClick()"
        >

            <img
                class="shop-product-aside__business-logo"
                v-bind:src="productAsideData.business.logo"
                v-bind:alt="productAsideData.business.name"
            >

            <span class="shop-product-aside__business-information">

                <span
                    class="shop-product-aside__business-label"
                    v-text="productAsideTranslations.soldBy"
                ></span>

                <strong
                    class="shop-product-aside__business-name"
                    v-text="productAsideData.business.name"
                ></strong>

                <span
                    class="shop-product-aside__business-category"
                    v-text="productAsideData.business.subcategory"
                ></span>

            </span>

            <i class="bi bi-chevron-right"></i>

        </button>

    </div>


    <!-- ==============================================
         FIXED FOOTER
    =============================================== -->

    <!-- ==============================================
         PRODUCT CART FOOTER
    =============================================== -->

    <div
        class="shop-product-aside__footer"
        v-if="
        productAsideData &&
        productAsideConfig.showAdd &&
        shopManager.cart.config.enabled
    "
    >

        <!-- FEEDBACK -->

        <transition name="shop-product-feedback">

            <div
                class="shop-product-aside__feedback"
                v-if="productAsideState.feedback.visible"
                v-bind:class="
                'shop-product-aside__feedback--' +
                productAsideState.feedback.type
            "
                role="status"
                aria-live="polite"
            >

                <i
                    v-bind:class="
                    productAsideState.feedback.type === 'success'
                        ? 'bi bi-check-circle-fill'
                        : 'bi bi-info-circle'
                "
                ></i>

                <span
                    class="shop-product-aside__feedback-message"
                    v-text="productAsideState.feedback.message"
                ></span>

            </div>

        </transition>


        <!-- QUANTITY CONTROLLER -->

        <div
            class="shop-product-aside__quantity-row"
            v-if="
            productAsideConfig.showQuantity &&
            productAsideData.price.hasPrice
        "
        >

            <div class="shop-product-aside__quantity-information">

                <strong
                    class="shop-product-aside__quantity-label"
                    v-text="productAsideTranslations.cartQuantity"
                ></strong>

                <span
                    class="shop-product-aside__quantity-description"
                    v-text="
                    productAsideQuantity > 0
                        ? productAsideQuantity + ' × ' +
                          formatCartMoney(
                              productAsideCartItem.unitPriceCents
                          )
                        : productAsideTranslations.cartEmpty
                "
                ></span>

            </div>


            <div class="shop-product-aside__quantity">

                <!-- DECREASE -->

                <button
                    type="button"
                    class="
                    shop-product-aside__quantity-button
                    shop-product-aside__quantity-button--decrease
                "
                    v-on:click="decreaseShopProductQuantity()"
                    v-bind:disabled="!canRemoveProductAsideFromCart"
                    v-bind:aria-label="productAsideTranslations.decrease"
                >

                    <i class="bi bi-dash-lg"></i>

                </button>


                <!-- QUANTITY -->

                <span
                    class="shop-product-aside__quantity-value"
                    v-text="productAsideQuantity"
                    aria-live="polite"
                ></span>


                <!-- INCREASE -->

                <button
                    type="button"
                    class="
                    shop-product-aside__quantity-button
                    shop-product-aside__quantity-button--increase
                "
                    v-on:click="increaseShopProductQuantity()"
                    v-bind:disabled="!canAddProductAsideToCart"
                    v-bind:aria-label="productAsideTranslations.increase"
                >

                    <i class="bi bi-plus-lg"></i>

                </button>

            </div>

        </div>


        <!-- CART SUMMARY -->

        <div
            class="shop-product-aside__cart-summary"
            v-if="productAsideData.price.hasPrice"
            v-bind:class="{
            'shop-product-aside__cart-summary--active':
                productAsideQuantity > 0,

            'shop-product-aside__cart-summary--empty':
                productAsideQuantity === 0
        }"
        >

        <span class="shop-product-aside__cart-summary-icon">

            <i
                v-bind:class="
                    productAsideQuantity > 0
                        ? 'bi bi-cart-check'
                        : 'bi bi-cart3'
                "
            ></i>

        </span>


            <div class="shop-product-aside__cart-summary-information">

                <strong
                    class="shop-product-aside__cart-summary-title"
                    v-text="productAsideTranslations.cartSubtotal"
                ></strong>

                <span
                    class="shop-product-aside__cart-summary-description"
                    v-text="productAsideData.name"
                ></span>


                <!-- YAPITAS -->

                <span
                    class="shop-product-aside__quantity-points"
                    v-if="
                    productAsideConfig.showPoints &&
                    productAsideTotalPoints > 0
                "
                >

                <i class="bi bi-coin"></i>

                <span
                    v-text="
                        '+' +
                        productAsideTotalPoints +
                        ' ' +
                        productAsideTranslations.estimatedPoints
                    "
                ></span>

            </span>


                <!-- SAVINGS -->

                <span
                    class="shop-product-aside__quantity-savings"
                    v-if="
                    productAsideConfig.showDiscount &&
                    productAsideDiscountCents > 0
                "
                    v-text="
                    productAsideTranslations.savings +
                    ' ' +
                    formatCartMoney(productAsideDiscountCents)
                "
                ></span>

            </div>


            <strong
                class="shop-product-aside__cart-summary-price"
                v-text="formatCartMoney(productAsideTotalCents)"
                aria-live="polite"
            ></strong>

        </div>


        <!-- UNAVAILABLE PRICE -->

        <div
            class="shop-product-aside__error"
            v-if="!productAsideData.price.hasPrice"
            v-text="productAsideTranslations.unavailablePrice"
        ></div>


        <!-- ERROR -->

        <div
            class="shop-product-aside__error"
            v-if="productAsideState.error"
            v-text="productAsideState.error"
            role="alert"
        ></div>

    </div>
</aside>
