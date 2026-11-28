<!-- ==================================================
     SHOP BUSINESS ASIDE
=================================================== -->

<aside
    id="shop-business-aside"
    class="offcanvas offcanvas-end shop-business-aside"
    tabindex="-1"
    aria-labelledby="shop-business-aside-title"
    data-bs-backdrop="true"
    data-bs-keyboard="true"
    v-cloak
>

    <!-- CLOSE -->

    <div class="shop-business-aside__toolbar">

        <button
            type="button"
            class="shop-business-aside__close"
            v-on:click="closeShopBusinessAside()"
            aria-label="Cerrar"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>

    <div
        class="offcanvas-body shop-business-aside__body"
        v-if="shopManager.businessAside.data"
    >

        <!-- ======================================
             BUSINESS PROFILE
        ======================================= -->

        <section class="shop-business-aside__profile">

            <div class="shop-business-aside__logo-wrapper">

                <img
                    class="shop-business-aside__logo"
                    v-bind:src="shopManager.businessAside.data.business.logo"
                    v-bind:alt="shopManager.businessAside.data.business.name"
                >

            </div>

            <div class="shop-business-aside__information">

                <h2
                    id="shop-business-aside-title"
                    class="shop-business-aside__name"
                    v-text="shopManager.businessAside.data.business.name"
                ></h2>

                <div class="shop-business-aside__category">

                    <span
                        v-text="shopManager.businessAside.data.business.category"
                    ></span>

                    <span> / </span>

                    <span
                        v-text="shopManager.businessAside.data.business.subcategory"
                    ></span>

                </div>

                <!-- RATING -->

                <div class="shop-business-aside__rating">

                    <div class="shop-business-aside__stars">

                        <i
                            v-for="star in 5"
                            v-bind:key="star"
                            v-bind:class="getShopAsideStarClass(
                                star,
                                shopManager.businessAside.data.reviews.rating
                            )"
                        ></i>

                    </div>

                    <strong
                        class="shop-business-aside__rating-value"
                        v-text="shopManager.businessAside.data.reviews.rating.toFixed(1)"
                    ></strong>

                    <span
                        class="shop-business-aside__rating-count"
                        v-text="'(' + shopManager.businessAside.data.reviews.total + ' reseñas)'"
                    ></span>

                </div>

            </div>

        </section>


        <!-- ======================================
             BUSINESS DETAILS
        ======================================= -->

        <section class="shop-business-aside__details">


            <!-- SCHEDULE -->

            <!-- HORARIOS -->
            <div
                class="shop-business-aside__schedule"
                v-if="shopManager.businessAside.config.showSchedule"
                :class="{
        'shop-business-aside__schedule--expanded':
            shopManager.businessAside.state.scheduleExpanded
    }"
            >

                <!-- ACCORDION HEADER -->
                <button
                    type="button"
                    class="shop-business-aside__item
               shop-business-aside__schedule-trigger"
                    @click="toggleBusinessAsideSchedule"
                    :aria-expanded="
            shopManager.businessAside.state.scheduleExpanded
        "
                >

                    <div class="shop-business-aside__item-icon">

                        <i class="bi bi-clock"></i>

                    </div>

                    <div class="shop-business-aside__item-content">

            <span
                class="shop-business-aside__item-title"
                v-text="shopManager.businessAside.translations.schedule"
            ></span>

                        <span
                            class="shop-business-aside__item-description"
                            v-text="
                    shopManager.businessAside.data.schedule.text ||
                    shopManager.businessAside.data.schedule.label
                "
                        ></span>

                    </div>

                    <!-- CHEVRON -->
                    <div class="shop-business-aside__schedule-arrow">

                        <i class="bi bi-chevron-down"></i>

                    </div>

                </button>

                <!-- ACCORDION CONTENT -->
                <transition name="shop-schedule">

                    <div
                        class="shop-business-aside__schedule-content"
                        v-if="shopManager.businessAside.state.scheduleExpanded"
                    >

                        <!-- ESTADO ACTUAL -->
                        <div class="shop-business-aside__schedule-header">

                <span class="shop-business-aside__schedule-heading">
                    Horario de atención
                </span>

                            <span
                                class="shop-business-aside__schedule-status"
                                :class="
                        'shop-business-aside__schedule-status--' +
                        shopManager.businessAside.data.schedule.status.toLowerCase()
                    "
                            >

                    <i class="bi bi-circle-fill"></i>

                    <span
                        v-text="shopManager.businessAside.data.schedule.label"
                    ></span>

                </span>

                        </div>

                        <!-- LISTADO DE HORARIOS -->
                        <div
                            class="shop-business-aside__schedule-list"
                            v-if="shopManager.businessAside.data.schedule.data.length"
                        >

                            <div
                                class="shop-business-aside__schedule-day"
                                v-for="day in shopManager.businessAside.data.schedule.data"
                                :key="day.id"
                                :class="{
                        'shop-business-aside__schedule-day--today':
                            day.is_today,

                        'shop-business-aside__schedule-day--closed':
                            !day.intervals.length
                    }"
                            >

                                <!-- DÍA -->
                                <div class="shop-business-aside__schedule-day-name">

                                    <span v-text="day.day"></span>

                                    <small v-if="day.is_today">
                                        (Hoy)
                                    </small>

                                </div>

                                <!-- HORARIO -->
                                <span
                                    class="shop-business-aside__schedule-day-time"
                                    v-text="day.text"
                                ></span>

                            </div>

                        </div>

                        <!-- SIN HORARIOS -->
                        <div
                            class="shop-business-aside__schedule-empty"
                            v-else
                        >

                            <i class="bi bi-calendar-x"></i>

                            <span>
                    El negocio aún no ha configurado sus horarios.
                </span>

                        </div>

                    </div>

                </transition>

            </div>


            <!-- LOCATION -->

            <button
                type="button"
                class="shop-business-aside__item"
                v-if="shopManager.businessAside.config.showLocation"
                v-on:click="onShopBusinessAsideAction('location')"
                v-bind:disabled="!shopManager.businessAside.data.location.mapsUrl"
            >

                <span class="shop-business-aside__item-icon">

                    <i class="bi bi-geo-alt"></i>

                </span>

                <span class="shop-business-aside__item-content">

                    <span
                        class="shop-business-aside__item-title"
                        v-text="shopManager.businessAside.translations.location"
                    ></span>

                    <span
                        class="shop-business-aside__item-description"
                        v-text="shopManager.businessAside.data.location.address"
                    ></span>

                </span>

                <span class="shop-business-aside__item-action">

                    <i class="bi bi-box-arrow-up-right"></i>

                </span>

            </button>


            <!-- CONTACT -->

            <button
                type="button"
                class="
        shop-business-aside__item
        shop-business-aside__item--whatsapp
    "
                v-if="shopManager.businessAside.config.showContact"
                v-on:click="onShopBusinessAsideAction('whatsapp')"
                v-bind:disabled="!orderWhatsAppNumber"
            >

    <span class="
        shop-business-aside__item-icon
        shop-business-aside__item-icon--whatsapp
    ">

        <i class="bi bi-whatsapp"></i>

    </span>

                <span class="shop-business-aside__item-content">

        <span
            class="shop-business-aside__item-title"
            v-text="shopManager.businessAside.translations.whatsapp"
        ></span>

        <span
            class="shop-business-aside__item-description"
            v-text="
                orderWhatsAppNumber
                    ? '+' + orderWhatsAppNumber
                    : shopManager.businessAside.translations.noContact
            "
        ></span>

        <span
            class="shop-business-aside__item-helper"
            v-if="orderWhatsAppNumber"
            v-text="
                shopManager.businessAside.translations.whatsappDescription
            "
        ></span>

    </span>

                <span class="
        shop-business-aside__item-action
        shop-business-aside__item-action--whatsapp
    ">

        <i class="bi bi-chevron-right"></i>

    </span>

            </button>
            <!-- SHARE WHATSAPP -->

            <button
                type="button"
                class="
        shop-business-aside__item
        shop-business-aside__item--share
    "
                v-if="shopManager.businessAside.config.showShare"
                v-on:click="onShopBusinessAsideAction('share-whatsapp')"
            >

    <span class="
        shop-business-aside__item-icon
        shop-business-aside__item-icon--whatsapp
    ">

        <i class="bi bi-whatsapp"></i>

    </span>

                <span class="shop-business-aside__item-content">

        <span
            class="shop-business-aside__item-title"
            v-text="shopManager.businessAside.translations.share"
        ></span>

        <span
            class="shop-business-aside__item-description"
            v-text="shopManager.businessAside.translations.shareDescription"
        ></span>

    </span>

                <span class="
        shop-business-aside__item-action
        shop-business-aside__item-action--whatsapp
    ">

        <i class="bi bi-share"></i>

    </span>

            </button>
            <!-- REVIEWS -->

            <button
                type="button"
                class="shop-business-aside__item"
                v-if="shopManager.businessAside.config.showReviews"
                v-on:click="onShopBusinessAsideAction('reviews')"
            >

                <span class="
                    shop-business-aside__item-icon
                    shop-business-aside__item-icon--rating
                ">

                    <i class="bi bi-star"></i>

                </span>

                <span class="shop-business-aside__item-content">

                    <span class="shop-business-aside__item-title">

                        <span
                            v-text="shopManager.businessAside.translations.reviews"
                        ></span>

                        <span
                            class="shop-business-aside__item-count"
                            v-text="'(' + shopManager.businessAside.data.reviews.total + ')'"
                        ></span>

                    </span>

                    <span class="shop-business-aside__rating">

                        <strong
                            class="shop-business-aside__rating-value"
                            v-text="shopManager.businessAside.data.reviews.rating.toFixed(1)"
                        ></strong>

                        <span class="shop-business-aside__stars">

                            <i
                                v-for="star in 5"
                                v-bind:key="star"
                                v-bind:class="getShopAsideStarClass(
                                    star,
                                    shopManager.businessAside.data.reviews.rating
                                )"
                            ></i>

                        </span>

                    </span>

                </span>

                <span class="shop-business-aside__item-action">

                    <i class="bi bi-chevron-right"></i>

                </span>

            </button>

        </section>


        <!-- ======================================
             PROMOTIONS
        ======================================= -->

        <section
            class="
                shop-business-aside__section
                shop-business-aside__section--promotions
            "
            v-if="shopManager.businessAside.config.showPromotions"
        >

            <div class="shop-business-aside__section-header">

                <i class="bi bi-gift-fill"></i>

                <h3
                    class="shop-business-aside__section-title"
                    v-text="shopManager.businessAside.translations.promotions"
                ></h3>

                <span class="shop-business-aside__section-badge">

                    <i class="bi bi-percent"></i>

                </span>

            </div>

            <div class="shop-business-aside__promotions">

                <button
                    type="button"
                    class="shop-business-aside__promotion"
                    v-for="promotion in shopManager.businessAside.data.promotions"
                    v-bind:key="promotion.id"
                    v-on:click="onShopBusinessAsideAction('promotion', promotion)"
                >

                    <img
                        class="shop-business-aside__promotion-image"
                        v-bind:src="promotion.image"
                        v-bind:alt="promotion.name"
                    >

                    <span class="shop-business-aside__promotion-content">

                        <strong
                            class="shop-business-aside__promotion-name"
                            v-text="promotion.name"
                        ></strong>

                        <span
                            class="shop-business-aside__promotion-description"
                            v-text="promotion.description"
                        ></span>

                        <span
                            class="shop-business-aside__promotion-price"
                            v-text="'$' + Number(promotion.price).toFixed(2)"
                        ></span>

                        <small
                            v-if="promotion.isMock"
                            class="shop-business-aside__mock"
                            v-text="shopManager.businessAside.translations.mock"
                        ></small>

                    </span>

                    <i class="
                        bi bi-chevron-right
                        shop-business-aside__promotion-action
                    "></i>

                </button>

                <div
                    class="shop-business-aside__empty"
                    v-if="!shopManager.businessAside.data.promotions.length"
                    v-text="shopManager.businessAside.translations.noPromotions"
                ></div>

            </div>

        </section>


        <!-- ======================================
             YAPITA BENEFITS
        ======================================= -->

        <section
            class="
                shop-business-aside__section
                shop-business-aside__section--benefits
            "
            v-if="shopManager.businessAside.config.showBenefits"
        >

            <div class="shop-business-aside__section-header">

                <i class="bi bi-coin"></i>

                <h3
                    class="shop-business-aside__section-title"
                    v-text="shopManager.businessAside.translations.benefits"
                ></h3>

            </div>

            <div class="shop-business-aside__benefits">

                <button
                    type="button"
                    class="shop-business-aside__benefit"
                    v-for="benefit in shopManager.businessAside.data.benefits"
                    v-bind:key="benefit.id"
                    v-on:click="onShopBusinessAsideAction('benefit', benefit)"
                >

                    <span class="shop-business-aside__benefit-icon">

                        <i class="bi bi-check-lg"></i>

                    </span>

                    <span
                        class="shop-business-aside__benefit-title"
                        v-text="benefit.title"
                    ></span>

                    <i class="
                        bi bi-chevron-right
                        shop-business-aside__benefit-action
                    "></i>

                </button>

            </div>

        </section>

    </div>

</aside>
