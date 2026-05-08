{{--  CMS-TEMPLATE --}}
<?php

$managementNameProcess = "shopPage";
?>
@extends('layouts.cityBook')
@section('additional-styles')
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    <style id="base-colors">
        /* =========================
 MC GRID - BASE
========================= */

        .mc-grid {
            --mc-bg: #ffffff;
            --mc-border: #e5e7eb;
            --mc-text: #1f2937;
            --mc-muted: #6b7280;
            --mc-primary: #445EF2;
            --mc-hover: #f9fafb;
            --mc-radius: 12px;
            --mc-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);

            background: var(--mc-bg);
            border-radius: var(--mc-radius);
        }
    </style>
    @include('frontend.web.'.$managementNameProcess.'.assets.css.index')


    <style>

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        .map-container {
            height: 500px;
            width: 100%;
        }

        @keyframes marker-bounce {
            0% {
                transform: scale(1);
            }
            /* Tamaño inicial */
            30% {
                transform: scale(1.1);
            }
            /* El marcador se agranda */
            50% {
                transform: scale(1);
            }
            /* El marcador vuelve a su tamaño original */
            70% {
                transform: scale(1.1);
            }
            /* El marcador se agranda otra vez */
            100% {
                transform: scale(1);
            }
            /* El marcador vuelve a su tamaño original */
        }

        /* Modificador de ícono del marcador con el rebote */
        .leaflet-marker-icon--bouncing {

        }
    </style>

    <style id="bootgrid-bs5">

        .mc-grid__header {
            padding: 12px 16px;

        }

        /* zonas */
        .mc-grid__left,
        .mc-grid__center,
        .mc-grid__right {

        }
        .mc-center.mc-grid__center{
            width: 31%;
        }
        .mc-grid__search-wrapper {
            width: 100%;

        }

        .mc-grid__search-group {
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid var(--mc-border);
            background: #fff;
        }

        .mc-grid__search-icon {
            background: transparent;
            border: none;
            color: var(--mc-muted);
        }

        .mc-grid__search-input {
            border: none;
            box-shadow: none;
            font-size: 13px;
        }

        .mc-grid__search-input:focus {
            outline: none;
            box-shadow: none;
        }

        .mc-grid__btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 6px 10px;
            transition: all 0.2s ease;
        }

        .mc-grid__btn--primary {
            background: var(--mc-azulClic);
            border: none;
            color: #fff;
        }

        .mc-grid__btn--primary span {

            color: #fff;
        }

        .mc-grid__btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--mc-shadow);
        }

        .mc-grid__dropdown {
            position: relative;
        }

        .mc-grid__dropdown-toggle {
            border-radius: 10px;
            font-size: 13px;
            transition: all 0.2s ease;
            background: var(--mc-azulClic);;
        }

        .mc-grid__dropdown-toggle:hover {
            background: var(--mc-hover);
        }

        /* menu */
        .mc-grid__dropdown-menu {
            border-radius: 12px;
            border: 1px solid var(--mc-border);
            box-shadow: var(--mc-shadow);
            padding: 6px;
            min-width: 140px;
        }

        /* item */
        .mc-grid__dropdown-item {
            border-radius: 8px;
            font-size: 13px;
            padding: 6px 10px;
            transition: all 0.2s ease;
        }

        .mc-grid__dropdown-item:hover {
            background: var(--mc-hover);
        }

        /* checkbox */
        .mc-grid__dropdown-item--checkbox {
            cursor: pointer;
        }

        .mc-grid__checkbox {
            cursor: pointer;
        }

        .mc-grid__card {
            display: grid;
            gap: 6px;
            padding: 10px;
        }

        .mc-grid__item {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 13px;
        }

        .mc-grid__label {
            color: var(--mc-muted);
            font-weight: 500;
        }

        .mc-grid__value {
            color: var(--mc-text);
            font-weight: 600;
        }

        @media (max-width: 768px) {

        }

        .content-manager-grid {
            margin-top: 3%;
        }

        .xywer-tbl-admin {
            width: 100%;
        }
    </style>

    <style>

        /* =========================================================
           ROOT
        ========================================================= */

        :root {

            --pc-primary: #6d28d9;
            --pc-primary-light: #8b5cf6;
            --pc-primary-soft: #f3e8ff;

            --pc-text: #111827;
            --pc-text-light: #6b7280;

            --pc-border: #e5e7eb;

            --pc-bg: #ffffff;

            --pc-success-bg: #dcfce7;
            --pc-success-text: #166534;

            --pc-muted-bg: #f1f5f9;
            --pc-muted-text: #475569;

            --pc-price-bg: #fef3c7;
            --pc-price-text: #92400e;

            --pc-danger-bg: #fee2e2;
            --pc-danger-text: #dc2626;

            --pc-shadow-sm: 0 2px 10px rgba(0, 0, 0, .06);
            --pc-shadow-md: 0 10px 25px rgba(0, 0, 0, .10);

            --pc-radius: 22px;

            --pc-transition: all .25s ease;
        }

        div.bootgrid-header {
            width: 100%;
        / / position: fixed;
            z-index: 15;
        }

        .category-item {
            display: flex;
            align-items: center;
            gap: 8px;

            padding: 10px 14px;

            border-radius: 12px;
            background: #fff;
            border: 1px solid #e5e7eb;

            white-space: nowrap;
            cursor: pointer;
        }

        .category-item i {
            font-size: 16px;
        }

        .category-item span {
            font-size: 14px;
            font-weight: 500;
        }

        .custom-scroll-admin-grid.table-responsive--fixed {
            margin-top: 4%;
        }

        /* =========================================================
           BOOTGRID GRID
        ========================================================= */

        .xywer-tbl-admin tbody {

            display: grid !important;

            grid-template-columns:
        repeat(4, minmax(0, 1fr));

            gap: 18px;

            width: 100%;
        }

        .xywer-tbl-admin tbody tr {

            display: block !important;

            width: 100%;
        }

        .xywer-tbl-admin tbody td {

            display: block !important;

            width: 100%;

            border: none !important;

            background: transparent !important;

            padding: 0 !important;
        }

        /* =========================================================
           PRODUCT CARD
        ========================================================= */

        .product-card {

            background: var(--pc-bg);

            border: 1px solid var(--pc-border);

            border-radius: var(--pc-radius);

            overflow: hidden;

            transition: var(--pc-transition);

            box-shadow: var(--pc-shadow-sm);

            height: 100%;

            display: flex;

            flex-direction: column;
        }

        .product-card:hover {

            transform: translateY(-4px);

            box-shadow: var(--pc-shadow-md);
        }

        /* =========================================================
           IMAGE SECTION
        ========================================================= */

        .product-card__media {
            position: relative;

            width: 100%;
            height: 240px;

            overflow: hidden;

            background: #f8fafc;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card__image {

            width: 100%;
            height: 100%;

            object-fit: contain;
            object-position: center;

            display: block;

            padding: 12px;
        }

        /* =========================================================
           TOP BAR OVER IMAGE
        ========================================================= */

        .product-card__top {

            position: absolute;

            top: 14px;
            left: 14px;
            right: 14px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            z-index: 2;
        }

        /* =========================================================
           SUBCATEGORY
        ========================================================= */

        .product-card__subcategory {

            background: rgba(255, 255, 255, .95);

            backdrop-filter: blur(10px);

            color: var(--pc-primary);

            padding: 8px 12px;

            border-radius: 999px;

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .5px;
        }

        /* =========================================================
           FAVORITE
        ========================================================= */

        .product-card__favorite {

            width: 42px;
            height: 42px;

            border: none;

            border-radius: 50%;

            background: rgba(255, 255, 255, .95);

            backdrop-filter: blur(10px);

            display: flex;

            justify-content: center;
            align-items: center;

            cursor: pointer;

            transition: var(--pc-transition);
        }

        .product-card__favorite i {

            font-size: 20px;

            color: #e11d48;
        }

        .product-card__favorite:hover {

            transform: scale(1.08);
        }

        /* =========================================================
           CONTENT
        ========================================================= */

        .product-card__content {

            padding: 18px;

            display: flex;

            flex-direction: column;

            gap: 14px;

            flex: 1;
        }

        /* =========================================================
           NAME
        ========================================================= */

        .product-card__name {

            margin: 0;
            text-align: left;
            font-size: 22px;

            font-weight: 800;

            line-height: 1.2;

            color: var(--pc-text);
        }

        /* =========================================================
           DESCRIPTION
        ========================================================= */

        .product-card__description {

            color: var(--pc-text-light);

            font-size: 14px;

            line-height: 1.5;

            display: flex;

            flex-wrap: wrap;

            gap: 6px;
        }

        /* =========================================================
           PRICES
        ========================================================= */

        .product-card__prices {

            display: flex;

            align-items: center;

            flex-wrap: wrap;

            gap: 10px;
        }

        /* CURRENT */

        .product-card__price {
            background: var(--mc-amarilloVital);

            color: var(--pc-price-text);

            padding: 10px 16px;

            border-radius: 12px;

            font-size: 22px;
            font-weight: 900;
        }

        /* OLD */

        .product-card__price-old {

            color: #94a3b8;

            text-decoration: line-through;

            font-size: 15px;

            font-weight: 700;
        }

        /* DISCOUNT */

        .product-card__discount {

            background: var(--pc-danger-bg);

            color: var(--pc-danger-text);

            padding: 6px 10px;

            border-radius: 10px;

            font-size: 12px;

            font-weight: 800;
        }

        /* =========================================================
           TAX
        ========================================================= */

        .product-card__taxes {

            display: flex;

            flex-wrap: wrap;

            gap: 8px;
        }

        .product-card__tax {

            padding: 6px 12px;

            border-radius: 999px;

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;
        }

        .product-card__tax--yes {

            background: var(--pc-success-bg);

            color: var(--pc-success-text);
        }

        .product-card__tax--no {

            background: var(--pc-muted-bg);

            color: var(--pc-muted-text);
        }

        /* =========================================================
           GAMIFICATION
        ========================================================= */

        .product-card__points {

            display: inline-flex;

            align-items: center;

            width: fit-content;

            padding: 8px 14px;

            border-radius: 999px;

            background: #eff6ff;

            color: var(--mc-azulClic);

            font-size: 13px;

            font-weight: 800;
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .product-card__actions {

            margin-top: auto;
        }

        .product-card__add {

            width: 100%;

            height: 52px;

            border: none;

            border-radius: 16px;

            background: #2563eb;

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            cursor: pointer;

            font-size: 15px;

            font-weight: 800;

            transition: var(--pc-transition);
        }

        .product-card__add i {

            font-size: 22px;
        }

        .product-card__add:hover {

            background: #1d4ed8;
        }

        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 1200px) {

            .xywer-tbl-admin tbody {

                grid-template-columns:
            repeat(3, minmax(0, 1fr));
            }

            .custom-scroll-admin-grid.table-responsive--fixed {
                margin-top: 5%;
            }
        }

        /* =========================================================
           SMALL TABLET
        ========================================================= */
        .mc-right.mc-grid__right {
            display: none;
        }
        .owl-nav {
            display: none !important;
        }
        tbody, td, tfoot, th, thead, tr {
            display: none !important;
        }
        @media (max-width: 992px) {

            .xywer-tbl-admin tbody {

                grid-template-columns:
            repeat(2, minmax(0, 1fr));
            }

            .product-card__media {

                height: 220px;
            }

            .content-manager-grid {
                margin-top: 12%;
            }

            .bootgrid-footer .search, .bootgrid-header .search {
                max-width: 100% !important;

            }
            .mc-center.mc-grid__center{
                width: 95% !important;
            }
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 768px) {

            .xywer-tbl-admin tbody {

                grid-template-columns:
            repeat(1, minmax(0, 1fr));
            }

            .product-card__media {

                height: 240px;
            }

            .product-card__content {

                padding: 16px;
            }

            .product-card__name {

                font-size: 20px;
            }

            .product-card__price {

                font-size: 20px;
            }


            .custom-action-bar {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
            }

            .mc-center.mc-grid__center{
                width: 95% !important;
            }

        }

        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 480px) {

            .product-card__media {

                height: 220px;
            }

            .product-card__name {

                font-size: 18px;
            }

            .product-card__description {

                font-size: 13px;
            }
            .mc-center.mc-grid__center{
                width: 95% !important;
            }
        }

    </style>

    <style>
        /*
|--------------------------------------------------------------------------
| WRAPPER
|--------------------------------------------------------------------------
*/

        .filters-sections {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | CAROUSEL CONTAINERS
        |--------------------------------------------------------------------------
        */

        .categories,
        .sub-categories {
            width: 100%;
            position: relative;
        }


        /*
        |--------------------------------------------------------------------------
        | OWL
        |--------------------------------------------------------------------------
        */

        .category-carousel,
        .sub-categories-carousel {
            width: 100%;
        }

        .category-carousel .owl-stage,
        .sub-categories-carousel .owl-stage {
            display: flex;
            align-items: stretch;
        }

        .category-carousel .item,
        .sub-categories-carousel .item {
            height: 100%;
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY CARD
        |--------------------------------------------------------------------------
        */

        .mc-category-card {
            display: flex;
            align-items: center;
            gap: 10px;

            min-height: 48px;

            padding: 10px 14px;

            background: #ffffff;
            border: 1px solid #e5e7eb;

            border-radius: 12px;

            cursor: pointer;

            transition: all .2s ease;

            user-select: none;

            white-space: nowrap;
        }

        .mc-category-card:hover {
            border-color: #445EF2;
            background: #f8faff;
        }

        .mc-category-card--active {
            background: #445EF2;
            border-color: #445EF2;
            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY ICON
        |--------------------------------------------------------------------------
        */

        .mc-category-card__icon {
            /*  display:flex;*/
            display: none;

            align-items: center;
            justify-content: center;

            width: 28px;
            height: 28px;

            font-size: 15px;

            border-radius: 8px;

            background: rgba(68, 94, 242, .08);

            color: #445EF2;

            flex-shrink: 0;
        }

        .mc-category-card--active .mc-category-card__icon {
            background: rgba(255, 255, 255, .18);
            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY CONTENT
        |--------------------------------------------------------------------------
        */

        .mc-category-card__content {
            display: flex;
            align-items: center;
        }

        .mc-category-card__title {
            font-size: 14px;
            font-weight: 600;

            line-height: 1.2;
        }


        /*
        |--------------------------------------------------------------------------
        | SUBCATEGORY CARD
        |--------------------------------------------------------------------------
        */

        .mc-subcategory-card {
            display: flex;
            align-items: center;
            gap: 8px;

            min-height: 42px;

            padding: 8px 12px;

            background: #f9fafb;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            cursor: pointer;

            transition: all .2s ease;

            white-space: nowrap;
        }

        .mc-subcategory-card:hover {
            border-color: #445EF2;
            background: #eef2ff;
        }

        .mc-subcategory-card--active {
            background: #111827;
            border-color: #111827;
            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | SUBCATEGORY ICON
        |--------------------------------------------------------------------------
        */

        .mc-subcategory-card__icon {
            /*  display:flex;*/
            display: none;
            align-items: center;
            justify-content: center;

            width: 24px;
            height: 24px;

            border-radius: 6px;

            background: rgba(68, 94, 242, .08);

            color: #445EF2;

            font-size: 13px;

            flex-shrink: 0;
        }

        .mc-subcategory-card--active .mc-subcategory-card__icon {
            background: rgba(255, 255, 255, .15);
            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | SUBCATEGORY CONTENT
        |--------------------------------------------------------------------------
        */

        .mc-subcategory-card__content {
            display: flex;
            align-items: center;
        }

        .mc-subcategory-card__title {
            font-size: 13px;
            font-weight: 500;
        }


        /*
        |--------------------------------------------------------------------------
        | OWL NAV
        |--------------------------------------------------------------------------
        */

        .owl-nav {
            display: flex;
            justify-content: flex-end;
            gap: 6px;

            margin-top: 10px;
        }

        .owl-nav button {
            width: 34px;
            height: 34px;

            border: none !important;

            border-radius: 10px !important;

            background: #ffffff !important;

            border: 1px solid #e5e7eb !important;

            transition: .2s;
        }

        .owl-nav button:hover {
            background: #445EF2 !important;
            color: #ffffff !important;
            border-color: #445EF2 !important;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .mc-category-card {
                padding: 10px 12px;
            }

            .mc-category-card__title {
                font-size: 13px;
            }

            .mc-subcategory-card {
                padding: 8px 10px;
            }

        }
    </style>
@endsection
@section('script')

@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>

    @include('frontend.web.'.$managementNameProcess.'.assets.js.index')


    <script>
        function managementButtons(allow) {
            if (!allow) {
                $("#view-expand a").click();
                $("#view-expand").addClass("not-view");
            } else {

            }

        }

        function initModePosition() {
            var isDesktop = isDesktopOnly();
            console.log(isDesktop);
            if (!isDesktop) {
                $("#manager-map").removeClass("right-pos-map");
                $("#manager-list").removeClass("left-list");
                $("#manager-map").addClass("left-pos-map");
                $("#manager-list").addClass("right-list");
            } else {
                $("#manager-map").removeClass("left-pos-map");
                $("#manager-list").removeClass("right-list");

                $("#manager-map").addClass("right-pos-map");
                $("#manager-list").addClass("left-list");
            }
        }

        $(function () {
            managementButtons(isDesktopOnly());
            $('.header-search').show();
            $(window).on('resize orientationchange', function () {
                //      initModePosition();
            });
        })
        var $dataManagerPageView = <?php echo json_encode($dataManagerPage) ?>;

        function generateCategoriesCarousel(params = {}) {

            const categories = params.categories || [];

            /*
            |--------------------------------------------------------------------------
            | SELECTORS
            |--------------------------------------------------------------------------
            */

            const $categoriesCarousel = $('.category-carousel');
            const $subCategoriesCarousel = $('.sub-categories-carousel');

            /*
            |--------------------------------------------------------------------------
            | RESET
            |--------------------------------------------------------------------------
            */

            destroyOwlCarousel($categoriesCarousel);
            destroyOwlCarousel($subCategoriesCarousel);

            $categoriesCarousel.html('');
            $subCategoriesCarousel.html('');

            /*
            |--------------------------------------------------------------------------
            | GENERATE CATEGORIES
            |--------------------------------------------------------------------------
            */

            let categoriesHtml = '';

            categories.forEach(category => {

                categoriesHtml += `
            <div class="item">

                <div
                    class="mc-category-card"

                    data-id="${category.id}"
                    data-title="${category.title}"
                    data-description="${category.description || ''}"
                >

                    <div class="mc-category-card__icon">
                        <i class="fa ${category.icon}"></i>
                    </div>

                    <div class="mc-category-card__content">

                        <div class="mc-category-card__title">
                            ${category.title}
                        </div>

                    </div>

                </div>

            </div>
        `;
            });

            $categoriesCarousel.html(categoriesHtml);

            /*
            |--------------------------------------------------------------------------
            | INIT CATEGORYS
            |--------------------------------------------------------------------------
            */

            initOwlCarousel($categoriesCarousel);

            /*
            |--------------------------------------------------------------------------
            | INIT SUBCATEGORYS
            |--------------------------------------------------------------------------
            */

            initOwlCarousel($subCategoriesCarousel);

            /*
            |--------------------------------------------------------------------------
            | CATEGORY CLICK
            |--------------------------------------------------------------------------
            */

            $categoriesCarousel.off('click');

            $categoriesCarousel.on('click', '.mc-category-card', function () {

                /*
                |--------------------------------------------------------------------------
                | ACTIVE
                |--------------------------------------------------------------------------
                */

                $('.mc-category-card')
                    .removeClass('mc-category-card--active');

                $(this)
                    .addClass('mc-category-card--active');

                /*
                |--------------------------------------------------------------------------
                | DATA
                |--------------------------------------------------------------------------
                */

                const categoryId = $(this).data('id');

                const category = categories.find(
                    item => item.id == categoryId
                );

                console.log('CATEGORY', category);

                /*
                |--------------------------------------------------------------------------
                | RENDER SUBCATEGORYS
                |--------------------------------------------------------------------------
                */

                renderSubCategories({
                    category,
                    $carousel: $subCategoriesCarousel
                });

            });

            /*
            |--------------------------------------------------------------------------
            | AUTO SELECT FIRST CATEGORY
            |--------------------------------------------------------------------------
            */

            if (categories.length > 0) {

                setTimeout(() => {

                    $categoriesCarousel
                        .find('.mc-category-card')
                        .first()
                        .trigger('click');

                }, 100);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SUBCATEGORYS
        |--------------------------------------------------------------------------
        */

        function renderSubCategories(params = {}) {

            const category = params.category || {};
            const $carousel = params.$carousel;

            const subcategories = category.subcategories || [];

            /*
            |--------------------------------------------------------------------------
            | RESET
            |--------------------------------------------------------------------------
            */

            destroyOwlCarousel($carousel);

            $carousel.html('');

            /*
            |--------------------------------------------------------------------------
            | HTML
            |--------------------------------------------------------------------------
            */

            let html = '';

            subcategories.forEach(subcategory => {

                html += `
            <div class="item">

                <div
                    class="mc-subcategory-card"

                    data-id="${subcategory.id}"
                    data-category-id="${category.id}"
                    data-title="${subcategory.title}"
                    data-description="${subcategory.description || ''}"
                >

                    <div class="mc-subcategory-card__icon">
                        <i class="fa ${subcategory.icon}"></i>
                    </div>

                    <div class="mc-subcategory-card__content">

                        <div class="mc-subcategory-card__title">
                            ${subcategory.title}
                        </div>

                    </div>

                </div>

            </div>
        `;
            });

            $carousel.html(html);

            /*
            |--------------------------------------------------------------------------
            | INIT
            |--------------------------------------------------------------------------
            */

            initOwlCarousel($carousel);

            /*
            |--------------------------------------------------------------------------
            | CLICK
            |--------------------------------------------------------------------------
            */

            $carousel.off('click');

            $carousel.on('click', '.mc-subcategory-card', function () {

                $('.mc-subcategory-card')
                    .removeClass('mc-subcategory-card--active');

                $(this)
                    .addClass('mc-subcategory-card--active');

                console.log('SUBCATEGORY', {
                    id: $(this).data('id'),
                    categoryId: $(this).data('category-id'),
                    title: $(this).data('title')
                });

            });

            /*
            |--------------------------------------------------------------------------
            | AUTO SELECT FIRST SUBCATEGORY
            |--------------------------------------------------------------------------
            */

            if (subcategories.length > 0) {

                setTimeout(() => {

                    $carousel
                        .find('.mc-subcategory-card')
                        .first()
                        .trigger('click');

                }, 100);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | OWL INIT
        |--------------------------------------------------------------------------
        */

        function initOwlCarousel($carousel, options = {}) {

            const config = {

                loop: false,
                nav: true,
                dots: false,
                margin: 10,
                autoWidth: true,

                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 4
                    },
                    960: {
                        items: 6
                    }
                },

                ...options
            };

            $carousel.owlCarousel(config);

            /*
            |--------------------------------------------------------------------------
            | MOUSE WHEEL
            |--------------------------------------------------------------------------
            */

            $carousel.off('mousewheel');

            $carousel.on('mousewheel', '.owl-stage', function (e) {

                if (e.originalEvent.deltaY > 0) {
                    $carousel.trigger('next.owl');
                } else {
                    $carousel.trigger('prev.owl');
                }

                e.preventDefault();
            });

        }


        /*
        |--------------------------------------------------------------------------
        | DESTROY OWL
        |--------------------------------------------------------------------------
        */

        function destroyOwlCarousel($carousel) {

            if ($carousel.hasClass('owl-loaded')) {
                $carousel.trigger('destroy.owl.carousel');
            }

        }
    </script>
    <script>
        $(function () {
            var categories = [

                /*
                |--------------------------------------------------------------------------
                | HAMBURGUESAS
                |--------------------------------------------------------------------------
                */
                {
                    id: -1,
                    title: 'TODOS',
                    description: 'Burgers artesanales',
                    icon: 'fa-burger',

                    subcategories: []
                },
                {
                    id: 1,
                    title: 'Hamburguesas',
                    description: 'Burgers artesanales',
                    icon: 'fa-burger',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 101,
                            title: 'Clásicas',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },

                        {
                            id: 102,
                            title: 'Dobles',
                            description: 'Doble carne',
                            icon: 'fa-layer-group'
                        },

                        {
                            id: 103,
                            title: 'Premium',
                            description: 'Especiales gourmet',
                            icon: 'fa-crown'
                        },

                        {
                            id: 104,
                            title: 'Picantes',
                            description: 'Con extra ají',
                            icon: 'fa-pepper-hot'
                        }

                    ]
                },

                /*
                |--------------------------------------------------------------------------
                | PIZZAS
                |--------------------------------------------------------------------------
                */

                {
                    id: 2,
                    title: 'Pizzas',
                    description: 'Pizzas calientes',
                    icon: 'fa-pizza-slice',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 201,
                            title: 'Personales',
                            description: 'Pizza individual',
                            icon: 'fa-user'
                        },

                        {
                            id: 202,
                            title: 'Familiares',
                            description: 'Pizza grande',
                            icon: 'fa-users'
                        },

                        {
                            id: 203,
                            title: 'Especiales',
                            description: 'Recetas premium',
                            icon: 'fa-fire'
                        },

                        {
                            id: 204,
                            title: 'Extra queso',
                            description: 'Mucho queso',
                            icon: 'fa-cheese'
                        }

                    ]
                },

                /*
                |--------------------------------------------------------------------------
                | POLLO
                |--------------------------------------------------------------------------
                */

                {
                    id: 3,
                    title: 'Pollo',
                    description: 'Pollo frito y broaster',
                    icon: 'fa-drumstick-bite',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 301,
                            title: 'Broaster',
                            description: 'Pollo crocante',
                            icon: 'fa-fire-flame-curved'
                        },

                        {
                            id: 302,
                            title: 'Alitas',
                            description: 'Wings BBQ',
                            icon: 'fa-wing'
                        },

                        {
                            id: 303,
                            title: 'Combos',
                            description: 'Pollo + papas + bebida',
                            icon: 'fa-box-open'
                        },

                        {
                            id: 304,
                            title: 'Picantes',
                            description: 'Hot chicken',
                            icon: 'fa-pepper-hot'
                        }

                    ]
                },

                /*
                |--------------------------------------------------------------------------
                | HOT DOGS
                |--------------------------------------------------------------------------
                */

                {
                    id: 4,
                    title: 'Hot Dogs',
                    description: 'Perros calientes',
                    icon: 'fa-hotdog',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 401,
                            title: 'Clásicos',
                            description: 'Hot dog tradicional',
                            icon: 'fa-star'
                        },

                        {
                            id: 402,
                            title: 'Gigantes',
                            description: 'Extra grandes',
                            icon: 'fa-maximize'
                        },

                        {
                            id: 403,
                            title: 'Con tocino',
                            description: 'Bacon lovers',
                            icon: 'fa-bacon'
                        },

                        {
                            id: 404,
                            title: 'Especiales',
                            description: 'Recetas premium',
                            icon: 'fa-crown'
                        }

                    ]
                },

                /*
                |--------------------------------------------------------------------------
                | PAPAS FRITAS
                |--------------------------------------------------------------------------
                */

                {
                    id: 5,
                    title: 'Papas',
                    description: 'French fries',
                    icon: 'fa-bowl-food',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 501,
                            title: 'Clásicas',
                            description: 'Papas normales',
                            icon: 'fa-potato'
                        },

                        {
                            id: 502,
                            title: 'Supremas',
                            description: 'Con queso y carne',
                            icon: 'fa-cheese'
                        },

                        {
                            id: 503,
                            title: 'Bacon Fries',
                            description: 'Con tocino',
                            icon: 'fa-bacon'
                        },

                        {
                            id: 504,
                            title: 'Familiares',
                            description: 'Porción grande',
                            icon: 'fa-users'
                        }

                    ]
                },

                /*
                |--------------------------------------------------------------------------
                | BEBIDAS
                |--------------------------------------------------------------------------
                */

                {
                    id: 6,
                    title: 'Bebidas',
                    description: 'Drinks y sodas',
                    icon: 'fa-glass-water',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 601,
                            title: 'Gaseosas',
                            description: 'Bebidas frías',
                            icon: 'fa-bottle-water'
                        },

                        {
                            id: 602,
                            title: 'Milkshakes',
                            description: 'Batidos',
                            icon: 'fa-blender'
                        },

                        {
                            id: 603,
                            title: 'Jugos',
                            description: 'Naturales',
                            icon: 'fa-lemon'
                        },

                        {
                            id: 604,
                            title: 'Energéticas',
                            description: 'Energy drinks',
                            icon: 'fa-bolt'
                        }

                    ]
                },

                /*
                |--------------------------------------------------------------------------
                | POSTRES
                |--------------------------------------------------------------------------
                */

                {
                    id: 7,
                    title: 'Postres',
                    description: 'Sweet desserts',
                    icon: 'fa-ice-cream',

                    subcategories: [
                        {
                            id: -1,
                            title: 'TODOS',
                            description: 'Hamburguesas tradicionales',
                            icon: 'fa-star'
                        },
                        {
                            id: 701,
                            title: 'Helados',
                            description: 'Ice cream',
                            icon: 'fa-ice-cream'
                        },

                        {
                            id: 702,
                            title: 'Brownies',
                            description: 'Chocolate lovers',
                            icon: 'fa-cookie'
                        },

                        {
                            id: 703,
                            title: 'Cheesecake',
                            description: 'Postres premium',
                            icon: 'fa-cake-candles'
                        },

                        {
                            id: 704,
                            title: 'Combos dulces',
                            description: 'Postre + bebida',
                            icon: 'fa-gift'
                        }

                    ]
                }

            ];


            generateCategoriesCarousel({categories: categories});
        })
    </script>
@endsection

@section('content')
    @include('frontend.web.'.$managementNameProcess.'.actions')

    <div id="app-management" class="page-home-init" dataManagerPageType="{{$dataManagerPage['type']}}">
        <aside class="filters-drawer filters-drawer--right"
               :class="{ 'filters-drawer--open': isFiltersOpen }"
               aria-label="Panel de filtros">
            <div class="filters-drawer__header">
                <h4 class="filters-drawer__title">{{ __('filters.titleEarnYapitas') }}</h4>
                <button type="button" class="filters-drawer__close" @click="isFiltersOpen = false">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>

            <div class="filters-drawer__body">
                <filters-categories-component
                    v-if="configDataFiltersCategories.allow"
                    ref="refFiltersCategories"
                    :params="configDataFiltersCategories"
                    v-on:_actions-emit="_updateParentByChildren($event)"
                >

                </filters-categories-component>

            </div>
        </aside>
        <section class="listsearch">
            <header class="listsearch__subheader" role="region" aria-label="Filtros y título">
                <h3 class="listsearch__title">
                    <span class="listsearch__title-text">{{ __('play_learn_and_earn_yapitas') }}</span>
                </h3>

                <div class="listsearch__subheader-actions" v-if="configDataFiltersCategories.allow">
                    <div class="listing-view-layout not-view ">
                        <ul>
                            <li id="view-grid"><a class="grid" href="#"><i class="fa fa-th-large"></i></a></li>
                            <li id="view-list"><a class="list " href="#"><i class="fa fa-list-ul"></i></a></li>
                            <li id="view-2"><a href="#" class="expand-listing-view active"><i class="fa fa-expand"></i></a>
                            </li>
                        </ul>
                    </div>
                    <button type="button" class="listsearch__filter-btn"
                            @click="isFiltersOpen = true"
                    >
                        <i class="fa fa-sliders listsearch__filter-icon" aria-hidden="true"></i>
                        <span class="listsearch__filter-text">Filtros</span>
                    </button>
                </div>
            </header>

        </section>
        <div class="data-page  manager-page__data-page">


            <div class="content-manager-grid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="custom-scroll-admin-grid table-responsive table-responsive--fixed">
                            <div class="filters-sections">
                                <div class="categories">
                                    <div class="owl-carousel category-carousel">


                                    </div>

                                </div>
                                <div class="sub-categories">
                                    <div class="owl-carousel sub-categories-carousel">


                                    </div>

                                </div>
                            </div>

                            <table id="grid-registers-grid"
                                   class="dictionary-data"

                            >
                                <thead>
                                <tr>
                                    <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                    <th data-column-id="description" data-formatter="description">Descripción</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
