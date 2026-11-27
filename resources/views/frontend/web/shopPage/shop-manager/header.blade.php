<div class="row">
    <!-- SHOP MANAGER - HEADER -->
    <div class="col-12">

        <header class="shop-header">

            <button
                type="button"
                class="shop-header__card"
                v-on:click="onShopHeaderClick($event)"
                aria-label="Ver información del negocio"
            >

                <!-- LOGO -->
                <span class="shop-header__logo-wrapper">

                <img
                    class="shop-header__logo"
                    v-bind:src="businessInformation.information.source"
                    v-bind:alt="businessInformation.information.title"
                >

            </span>

                <!-- BUSINESS INFORMATION -->
                <span class="shop-header__information">

                <!-- NAME -->
                <span
                    class="shop-header__name"
                    v-text="businessInformation.information.title"
                ></span>

                    <!-- CATEGORY -->
                <span class="shop-header__category">

                    <i
                        class="bi bi-shop"
                        aria-hidden="true"
                    ></i>

                    <span
                        class="shop-header__category-name"
                        v-text="businessInformation.subcategory.title"
                    ></span>

                </span>

                    <!-- RATING -->
                <span
                    class="shop-header__rating"
                    v-html="generateStars(businessInformation.starManagement)"
                ></span>

            </span>

                <!-- SEPARATOR -->
                <span
                    class="shop-header__separator"
                    aria-hidden="true"
                ></span>

                <!-- SCHEDULE -->
                <span class="shop-header__schedule">

                <!-- STATUS -->
                <span
                    class="shop-header__status"
                    v-bind:class="{
                        'shop-header__status--open':
                            shopManager.header.schedule.status === 'OPEN',

                        'shop-header__status--closed':
                            shopManager.header.schedule.status === 'CLOSED',

                        'shop-header__status--unknown':
                            shopManager.header.schedule.status === 'UNKNOWN'
                    }"
                >

                    <span class="shop-header__status-dot"></span>

                    <span
                        class="shop-header__status-label"
                        v-text="shopManager.header.schedule.label"
                    ></span>

                </span>

                    <!-- SCHEDULE TEXT -->
                <span
                    class="shop-header__schedule-text"
                    v-text="shopManager.header.schedule.text"
                ></span>

                    <!-- MORE INFORMATION -->
                <span
                    class="shop-header__more"
                    v-text="shopManager.header.translations.more"
                ></span>

            </span>

                <!-- ACTION -->
                <span class="shop-header__action">

                <i
                    class="bi bi-chevron-right"
                    aria-hidden="true"
                ></i>

            </span>

            </button>

        </header>

    </div>
</div>
