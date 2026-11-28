{{--  CMS-TEMPLATE --}}
<?php

$managementNameProcess = "shopPage";
$params = ["id" => -1];
$urlRouteBusiness = route('businessDetails', app()->getLocale(), -1);
$urlRouteGamesBusiness = route('businessPullkay', ["id" => -1, "language" => "es"]);
$urlRouteRewardsBusiness = route('rewards-business', $params);
$urlRouteRateBusiness = route('rate-register-business', $params);

?>

@php

    $counterConfigs = [

        1 => [
            'class' => 'gradient-bg',
            'items' => [
                [
                    'icon' => 'fa fa-building',
                    'number' => 45,
                    'label' => __('frontend.business-details.counter.five')
                ],
                [
                    'icon' => 'fa fa-male',
                    'number' => 2557,
                    'label' => __('frontend.business-details.counter.six')
                ],
                [
                    'icon' => 'fa fa-cutlery',
                    'number' => 5,
                    'label' => __('frontend.business-details.counter.seven')
                ],
            ]
        ],

        2 => [
            'class' => 'gradient-bg gradient-bg--counters-profile-business',
            'items' => [
                [
                    'icon' => 'fa fa-male',
                    'number' => $dataManagerPage['counters']['weekVisit']['count'] ?? 0,
                    'label' => __('frontend.business-details.counter.one')
                ],
                [
                    'icon' => 'fa fa-hand-peace-o',
                    'number' => $dataManagerPage['counters']['customersSatisfied']['count'] ?? 0,
                    'label' => __('frontend.business-details.counter.two')
                ],
                [
                    'icon' => 'fa fa-trophy',
                    'number' => $dataManagerPage['counters']['awards']['count'] ?? 0,
                    'label' => __('frontend.business-details.counter.three')
                ],
            ]
        ],

        4 => [
            'class' => 'gradient-bg',
            'items' => [
                [
                    'icon' => 'fa fa-male',
                    'number' => 154,
                    'label' => __('frontend.business-details.counter.one')
                ],
                [
                    'icon' => 'fa fa-hand-peace-o',
                    'number' => 12168,
                    'label' => __('frontend.business-details.counter.six')
                ],
                [
                    'icon' => 'fa fa-trophy',
                    'number' => 72,
                    'label' => __('frontend.business-details.counter.three')
                ],
            ]
        ],

    ];

     $currentCounter = $counterConfigs[2] ?? null;
@endphp

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

        .mc-center.mc-grid__center {
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

            color: var(--mc-azulClic);


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
            display: none;
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

            /* display: inline-flex;*/

            align-items: center;

            width: fit-content;

            padding: 8px 14px;

            border-radius: 999px;

            background: #eff6ff;

            color: var(--mc-azulClic);

            font-size: 13px;

            font-weight: 800;
            display: none !important;
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
            display: none;
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


            .bootgrid-footer .search, .bootgrid-header .search {
                max-width: 100% !important;

            }

            .mc-center.mc-grid__center {
                width: 95% !important;
            }
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 768px) {

            .xywer-tbl-admin tbody {

                grid-template-columns:
            repeat(2, minmax(0, 1fr));
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

            .mc-center.mc-grid__center {
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

            .mc-center.mc-grid__center {
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
            margin-bottom: 19px;
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
            border-color: var(--mc-azulClic);
            background: #f8faff;
        }

        .mc-category-card--active {
            background: var(--mc-azulClic) !important;
            border-color: var(--mc-azulClic) !important;
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

            color: var(--mc-azulClic);

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
            border-color: var(--mc-azulClic);
            background: #eef2ff;
        }

        .mc-subcategory-card--active {
            background: var(--mc-azulClic) !important;
            border-color: var(--mc-azulClic) !important;
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

            color: var(--mc-azulClic);

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
            background: var(--mc-azulClic) !important;
            color: #ffffff !important;
            border-color: var(--mc-azulClic) !important;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {
            .shop-filters #grid-registers-grid-header {
                height: 76px;
            }
            .mc-category-card {
                padding: 10px 12px;
                min-height: 36px;
            }

            .mc-category-card__title {
                font-size: 10px;
            }

            .mc-subcategory-card {
                padding: 8px 10px;
                min-height: 36px;
            }
            .mc-subcategory-card__title {
                font-size: 10px;
            }
        }

        .listsearch__subheader {
            display: none !important;
        }
    </style>

    <style id="business-information">
        /* =====================================================
           BUSINESS ASIDE - WHATSAPP CONTACT
        ===================================================== */

        .shop-business-aside__item--whatsapp {

            background: #f0fdf4;

            border: 1px solid #bbdfc5;

            transition:
                background .2s ease,
                border-color .2s ease;

        }


        /* WHATSAPP ICON */

        .shop-business-aside__item-icon--whatsapp {

            background: #dcfce7;

            color: #16a34a;

            font-size: 23px;

        }


        /* TITLE */

        .shop-business-aside__item--whatsapp
        .shop-business-aside__item-title {

            color: #166534;

            font-weight: 700;

        }


        /* HELPER TEXT */

        .shop-business-aside__item-helper {

            display: block;

            margin-top: 3px;

            color: #15803d;

            font-size: 10px;

            font-weight: 500;

            line-height: 1.4;

            text-align: left;

        }


        /* ACTION ICON */

        .shop-business-aside__item-action--whatsapp {

            color: #16a34a;

            flex-shrink: 0;

        }


        /* DISABLED STATE */

        .shop-business-aside__item--whatsapp:disabled {

            opacity: .5;

            cursor: not-allowed;

        }


        /* HOVER */

        @media (hover: hover) {

            .shop-business-aside__item--whatsapp:hover:not(:disabled) {

                background: #dcfce7;

                border-color: #25d366;

            }

        }


        /* ACTIVE STATE */

        .shop-business-aside__item--whatsapp:active:not(:disabled) {

            background: #d1fae5;

        }
        body {
            background: #f5f5f5;
            padding: 30px;
            font-family: sans-serif;
        }

        .business-card {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .business-logo {
            width: 150px;
            height: 150px;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        }

        .business-title {
            font-size: 40px;
            font-weight: 700;
            line-height: 1.1;
        }

        .business-title a {
            color: var(--mc-azulClic);
            text-decoration: none;
        }

        .business-category {
            font-size: 18px;
            color: #777;
        }

        .business-rating {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 20px;
        }

        .rating-info {
            font-size: 26px;
            font-weight: 700;
            color: #222;
        }

        .rating-info span {
            font-size: 15px;
            color: #888;
            font-weight: 400;
        }

        .business-actions {
            display: flex;
            gap: 12px;
        }

        .business-actions a {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            border: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--mc-azulClic);
            font-size: 20px;
            transition: .2s;
            text-decoration: none;
        }

        .business-actions a:hover {
            background: var(--mc-azulClic);
            color: #fff;
            transform: translateY(-2px);
        }

        .stat-card {
            background: #fff;
            border: 1px solid #efefef;
            border-radius: 22px;
            padding: 28px 20px;
            height: 100%;
            text-align: center;
            transition: .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .06);
        }

        .stat-icon {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            margin: auto auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .bg-primary-soft {
            background: rgba(87, 95, 255, .1);
            color: #575fff;
        }

        .bg-success-soft {
            background: rgba(82, 196, 26, .1);
            color: #52c41a;
        }

        .bg-warning-soft {
            background: rgba(250, 173, 20, .1);
            color: #faad14;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 10px;
            color: #575fff;
        }

        .stat-title {
            font-size: 16px;
            color: #555;
            line-height: 1.4;
        }

        .yapitas-card {
            background: linear-gradient(180deg, #faf7ff, #f5f0ff);
            border-radius: 24px;
            padding: 30px 20px;
            text-align: center;
            border: 1px solid #eee;
        }

        .yapitas-icon {
            font-size: 42px;
            color: #f7b500;
            margin-bottom: 15px;
        }

        .yapitas-value {
            font-size: 48px;
            font-weight: 700;
            color: #6a4cff;
            line-height: 1;
        }

        .yapitas-label {
            color: #777;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .btn-yapitas {
            display: block;
            width: 100%;
            background: linear-gradient(90deg, #6a4cff, #5a67ff);
            color: #fff;
            padding: 14px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 600;
        }

        .manager-process-business-gamification__card {
            background: #fff;
            border: 1px solid #efefef;
            border-radius: 20px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: .2s;
            cursor: pointer;
        }

        .manager-process-business-gamification__card:hover {

            box-shadow: 0 8px 18px rgba(0, 0, 0, .05);
        }

        .manager-process-business-gamification__icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: rgba(87, 95, 255, .08);
            color: var(--mc-azulClic);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        ul.manager-process-business-gamification__checklist {
            padding-top: 9%;
        }

        .manager-process-business-gamification__title {
            font-size: 18px;
            font-weight: 700;
            color: #222;
            text-align: left;
        }

        .manager-process-business-gamification__description {
            color: #777;
            font-size: 14px;
            text-align: justify;
            height: 150px;
        }

        .manager-process-business-gamification__icon-go {
            top: 39%;
            cursor: pointer;
            right: 33px;
            position: absolute;
            color: var(--mc-azulClic);
            transform: rotate(270deg);

            font-size: 28px;
        }
        .manager-process-business-gamification__actions{
            display: none;
        }
        @media (max-width: 991px) {

            .business-logo {
                width: 110px;
                height: 110px;
            }

            .business-title {
                font-size: 30px;
            }

        }

        /* =========================================================
   MOBILE
========================================================= */
        @media (max-width: 768px) {


            .business-title {
                font-size: 28px;
            }

            .business-category {
                font-size: 15px;
                margin-bottom: 12px !important;
            }

            .business-rating {
                justify-content: center;
                flex-direction: column;
                gap: 6px;
            }

            .rating-stars {
                font-size: 18px;
            }

            .rating-info {
                font-size: 20px;
            }

            .rating-info span {
                display: block;
                margin-top: 2px;
            }

            .business-actions {
                justify-content: center;
                margin-top: 15px;
                flex-wrap: wrap;
            }

            .business-actions a {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }

            /* STATS */
            .stats-wrapper {
                margin-top: 10px;
            }

            .stat-card {
                padding: 20px 15px;
                border-radius: 18px;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
                margin-bottom: 14px;
            }

            .stat-number {
                font-size: 34px;
            }

            .stat-title {
                font-size: 14px;
            }

            /* YAPITAS */
            .yapitas-card {
                padding: 24px 18px;
                border-radius: 18px;
                margin-top: 10px;
            }

            .yapitas-icon {
                font-size: 34px;
            }

            .yapitas-value {
                font-size: 36px;
            }

            .btn-yapitas {
                padding: 12px;
                border-radius: 14px;
                font-size: 15px;
            }

            /* MENU CARDS */
            .manager-process-business-gamification__card {
                padding: 18px;
                border-radius: 18px;
            }

            .manager-process-business-gamification__icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
                border-radius: 14px;
            }

            .manager-process-business-gamification__title {
                font-size: 16px;
            }

            .manager-process-business-gamification__description {
                font-size: 13px;
            }

        }

        /* =========================================================
           SMALL MOBILES
        ========================================================= */
        @media (max-width: 480px) {


            .rating-stars {
                font-size: 16px;
            }

            .rating-info {
                font-size: 18px;
            }

            .stat-number {
                font-size: 28px;
            }

            .yapitas-value {
                font-size: 30px;
            }

            .manager-process-business-gamification__card {
                gap: 12px;
            }

        }

        .content {
            padding-right: 4% !important;
            padding-left: 4% !important;

        }

        .manager-process-business-gamification__checklist li {
            gap: 12px;
        }

        .manager-process-business-gamification__check-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(98, 72, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--mc-azulClic);
            font-size: 14px;
            flex-shrink: 0;
        }

        .manager-process-business-gamification__check-text {
            font-size: 15px;
            color: #5d6472;
            font-weight: 500;
        }

        .manager-process-business-gamification__button {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 16px;
            background: var(--mc-azulClic);
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
        div#business-information {
            margin-bottom: 23px;
        }
    </style>
    <style id="row-grids-product">
        /* =====================================================
   SHOP PRODUCT CARD
   YAPITA - MOBILE FIRST
===================================================== */

        .shop-product-card {

            --spc-primary: var(--mc-azulClic, #4955e8);
            --spc-yellow: var(--mc-amarilloVital, #ffcc00);

            --spc-text: #111827;
            --spc-muted: #64748b;

            --spc-border: #e5e7eb;
            --spc-background: #ffffff;

            --spc-radius: 13px;
            --spc-media-radius: 9px;

            --spc-padding: 8px;
            --spc-content-gap: 5px;

            --spc-image-ratio: 2 / 1;

            --spc-action-size: 36px;

            --spc-tax-bg: #dcfce7;
            --spc-tax-text: #166534;

            --spc-promotion-bg: #7e22ce;

            box-sizing: border-box;

            position: relative;

            display: flex;
            flex-direction: column;

            width: 100%;
            min-width: 0;
            height: 100%;

            padding: 5px;

            background: var(--spc-background);

            border: 1px solid var(--spc-border);
            border-radius: var(--spc-radius);

            box-shadow: 0 2px 8px rgba(17, 24, 39, .06);

            overflow: hidden;

            font-family: inherit;

            text-align: left;

            transition:
                box-shadow .2s ease,
                border-color .2s ease;

        }

        .shop-product-card *,
        .shop-product-card *::before,
        .shop-product-card *::after {

            box-sizing: border-box;

        }


        /* =====================================================
           MEDIA
        ===================================================== */

        .shop-product-card__media {

            position: relative;

            width: 100%;

            aspect-ratio: var(--spc-image-ratio);

            flex-shrink: 0;

            background: #f1f5f9;

            border-radius: var(--spc-media-radius);

            overflow: hidden;

        }

        .shop-product-card__media-action {

            display: block;

            width: 100%;
            height: 100%;

            padding: 0;
            margin: 0;

            border: 0;

            background: transparent;

            cursor: pointer;

        }

        .shop-product-card__image {

            display: block;

            width: 100%;
            height: 100%;

            max-width: none;

            padding: 0;
            margin: 0;

            object-fit: cover;
            object-position: center;

        }


        /* =====================================================
           IMAGE MODIFIER
        ===================================================== */

        .shop-product-card--contain
        .shop-product-card__image {

            object-fit: contain;

            padding: 4px;

        }


        /* =====================================================
           TOP
        ===================================================== */

        .shop-product-card__top {

            position: absolute;

            top: 5px;
            left: 5px;
            right: 5px;

            display: flex;

            align-items: flex-start;
            justify-content: space-between;

            gap: 4px;

            pointer-events: none;

            z-index: 2;

        }


        /* =====================================================
           SUBCATEGORY
        ===================================================== */

        .shop-product-card__subcategory {

            display: -webkit-box;

            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;

            min-width: 0;
            max-width: 100%;

            padding: 4px 8px;

            background: rgba(255, 255, 255, .96);

            border-radius: 8px;

            color: var(--spc-primary);

            font-size: 9px;
            font-weight: 700;

            line-height: 1.25;

            letter-spacing: .1px;

            text-align: left;
            text-transform: uppercase;

            overflow: hidden;
            overflow-wrap: anywhere;

        }


        /* =====================================================
           FAVORITE
        ===================================================== */

        .shop-product-card__favorite {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 32px;
            height: 32px;

            padding: 0;
            margin-left: auto;

            flex-shrink: 0;

            border: 0;
            border-radius: 50%;

            background: rgba(255, 255, 255, .96);

            color: var(--spc-primary);

            box-shadow: 0 2px 6px rgba(0, 0, 0, .1);

            cursor: pointer;

            pointer-events: auto;

        }

        .shop-product-card__favorite i {

            font-size: 14px;

        }

        .shop-product-card__favorite--active {

            color: #e11d48;

            background: #fff1f2;

        }


        /* =====================================================
           PROMOTION
        ===================================================== */

        .shop-product-card__discount {

            position: absolute;

            bottom: 5px;
            right: 5px;

            display: inline-flex;

            align-items: center;

            padding: 4px 7px;

            border-radius: 7px;

            background: var(--spc-promotion-bg);

            color: #ffffff;

            font-size: 10px;
            font-weight: 700;

            line-height: 1.2;

            pointer-events: none;

            z-index: 2;

        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .shop-product-card__content {

            display: flex;
            flex-direction: column;

            flex: 1;

            min-width: 0;

            padding: var(--spc-padding);

            gap: var(--spc-content-gap);

            text-align: left;

        }


        /* =====================================================
           NAME
        ===================================================== */

        .shop-product-card__name {

            margin: 0;
            padding: 0;

            font-family: inherit;

            font-size: 14px;
            font-weight: 700;

            line-height: 1.3;

            color: var(--spc-text);

            text-align: left;

        }

        .shop-product-card__name-action {

            display: -webkit-box;

            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;

            width: 100%;

            padding: 0;
            margin: 0;

            border: 0;

            background: transparent;

            color: inherit;

            font: inherit;

            text-align: left;

            overflow: hidden;
            overflow-wrap: anywhere;

            cursor: pointer;

        }


        /* =====================================================
           DESCRIPTION
        ===================================================== */

        .shop-product-card__description {

            display: -webkit-box;

            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;

            color: var(--spc-muted);

            font-size: 11px;
            font-weight: 400;

            line-height: 1.4;

            text-align: left;

            overflow: hidden;
            overflow-wrap: anywhere;

        }


        /* =====================================================
           POINTS
        ===================================================== */

        .shop-product-card__points {

            display: inline-flex;

            align-items: center;

            gap: 4px;

            width: fit-content;

            padding: 3px 6px;

            background: #fff8db;
            color: #854d0e;

            border-radius: 6px;

            font-size: 10px;
            font-weight: 600;

        }

        .shop-product-card__points i {

            color: #b8860b;

            font-size: 11px;

        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .shop-product-card__footer {

            display: flex;

            align-items: flex-end;
            justify-content: space-between;

            gap: 5px;

            margin-top: auto;

            padding-top: 4px;

        }


        /* =====================================================
           PRICES
        ===================================================== */

        .shop-product-card__prices {

            display: flex;
            flex-direction: column;

            align-items: flex-start;

            gap: 3px;

            flex: 1;

            min-width: 0;

        }

        .shop-product-card__price {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: fit-content;

            max-width: 100%;

            padding: 5px 10px;

            border-radius: 8px;

            font-size: 16px;
            font-weight: 800;

            line-height: 1.3;

            font-variant-numeric: tabular-nums;

            overflow-wrap: anywhere;

        }


        /* WITHOUT TAX */

        .shop-product-card__price--without-tax {

            background: var(--spc-yellow);

            color: #713f12;

        }


        /* WITH TAX */

        .shop-product-card__price--with-tax {

            background: var(--spc-tax-bg);

            color: var(--spc-tax-text);

        }


        /* UNKNOWN TAX */

        .shop-product-card__price--unknown-tax {

            background: #f1f5f9;

            color: #475569;

        }


        /* OLD PRICE */

        .shop-product-card__price-old {

            color: var(--spc-muted);

            font-size: 11px;
            font-weight: 500;

            line-height: 1.2;

            text-decoration: line-through;

        }


        /* =====================================================
           TAX LABEL - OPTIONAL
        ===================================================== */

        .shop-product-card__tax {

            color: var(--spc-muted);

            font-size: 9px;

            line-height: 1.2;

        }

        .shop-product-card__tax--with-tax {

            color: var(--spc-tax-text);

        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .shop-product-card__actions {

            display: flex;

            align-items: center;
            justify-content: flex-end;

            flex-shrink: 0;

        }


        /* =====================================================
           ADD BUTTON
        ===================================================== */

        .shop-product-card__add {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: var(--spc-action-size);
            height: var(--spc-action-size);

            padding: 0;
            margin: 0;

            border: 1px solid #c7c9ff;

            border-radius: 9px;

            background: #ffffff;

            color: var(--spc-primary);

            cursor: pointer;

            touch-action: manipulation;

            transition:
                background-color .2s ease,
                color .2s ease,
                border-color .2s ease;

        }

        .shop-product-card__add i {

            display: block;

            font-size: 23px;

            font-weight: 600;

            line-height: 1;

        }

        .shop-product-card__add:active {

            background: #eef0ff;

        }

        .shop-product-card__add:disabled {

            opacity: .45;

            cursor: not-allowed;

        }


        /* =====================================================
           ACCESSIBILITY
        ===================================================== */

        .shop-product-card button:focus-visible {

            outline: 2px solid var(--spc-primary);

            outline-offset: -2px;

        }


        /* =====================================================
           HOVER
        ===================================================== */

        @media (hover: hover) {

            .shop-product-card:hover {

                border-color: #c7c9ff;

                box-shadow:
                    0 4px 12px rgba(17, 24, 39, .10);

            }

            .shop-product-card__add:hover:not(:disabled) {

                background: var(--spc-primary);

                border-color: var(--spc-primary);

                color: #ffffff;

            }

            .shop-product-card__name-action:hover {

                color: var(--spc-primary);

            }

        }


        /* =====================================================
           SMALL MOBILE
        ===================================================== */

        @media (max-width: 359.98px) {

            .shop-product-card {

                --spc-padding: 6px;
                --spc-action-size: 32px;

                padding: 4px;

            }

            .shop-product-card__name {

                font-size: 13px;

            }

            .shop-product-card__description {

                font-size: 10px;

            }

            .shop-product-card__price {

                font-size: 14px;

                padding: 5px 7px;

            }

            .shop-product-card__subcategory {

                font-size: 8px;

                padding: 4px 6px;

            }

        }


        /* =====================================================
           LARGE MOBILE - BS5 SM
        ===================================================== */

        @media (min-width: 576px) {

            .shop-product-card {

                --spc-padding: 10px;
                --spc-action-size: 40px;

                --spc-radius: 14px;
                --spc-media-radius: 10px;

                padding: 6px;

            }

            .shop-product-card__name {

                font-size: 16px;

            }

            .shop-product-card__description {

                font-size: 12px;

            }

            .shop-product-card__price {

                font-size: 17px;

            }

            .shop-product-card__subcategory {

                font-size: 10px;

            }

        }


        /* =====================================================
           TABLET - BS5 MD
        ===================================================== */

        @media (min-width: 768px) {

            .shop-product-card {

                --spc-image-ratio: 16 / 9;

                --spc-padding: 12px;
                --spc-action-size: 44px;

                --spc-radius: 15px;
                --spc-media-radius: 11px;

            }

            .shop-product-card__name {

                font-size: 17px;

            }

            .shop-product-card__description {

                font-size: 13px;

            }

            .shop-product-card__price {

                font-size: 18px;

            }

        }


        /* =====================================================
           DESKTOP - BS5 XL
        ===================================================== */

        @media (min-width: 1200px) {

            .shop-product-card {

                --spc-padding: 14px;

                --spc-image-ratio: 16 / 9;

            }

            .shop-product-card__name {

                font-size: 18px;

            }

            .shop-product-card__price {

                font-size: 20px;

            }

        }


        /* =====================================================
           REDUCED MOTION
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            .shop-product-card,

            .shop-product-card__add {

                transition: none;

            }

        }
    </style>
    <style id="header-manager">

        /* =====================================================
   SHOP HEADER
   MOBILE FIRST
===================================================== */

        .shop-header {

            --sh-primary: #4955e8;

            --sh-background: #f8f9fc;
            --sh-surface: #ffffff;

            --sh-text: #182033;
            --sh-muted: #70798c;
            --sh-border: #e3e6ef;

            --sh-warning: #ffb800;

            --sh-success: #16a34a;
            --sh-success-background: #dcfce7;

            --sh-danger: #dc2626;
            --sh-danger-background: #fee2e2;

            --sh-neutral: #64748b;
            --sh-neutral-background: #edf0f5;

            --sh-logo-size: 54px;
            --sh-radius: 16px;

            width: 100%;
            margin-bottom: 12px;
            border-bottom: 0 solid #eee!important;
        }

        #wrapper {
            top: 24px;
        }
        /* =====================================================
           CARD
        ===================================================== */

        .shop-header__card {

            display: grid;

            grid-template-columns:
        var(--sh-logo-size)
        minmax(0, 1fr)
        1px
        minmax(0, auto)
        14px;

            align-items: center;

            gap: 9px;

            width: 100%;
            padding: 10px;

            border: 1px solid var(--sh-border);
            border-radius: var(--sh-radius);

            background: var(--sh-background);

            box-shadow:
                0 3px 10px rgba(24, 32, 51, 0.05);

            font-family: inherit;
            text-align: left;
            cursor: pointer;

            transition:
                background-color 0.2s ease,
                box-shadow 0.2s ease,
                border-color 0.2s ease;

        }

        .shop-header__card:focus-visible {

            outline: 2px solid var(--sh-primary);
            outline-offset: 3px;

        }


        /* =====================================================
           LOGO
        ===================================================== */

        .shop-header__logo-wrapper {

            display: flex;

            align-items: center;
            justify-content: center;

            width: var(--sh-logo-size);
            height: var(--sh-logo-size);

            background: var(--sh-surface);

            border-radius: 50%;
            overflow: hidden;

            flex-shrink: 0;

        }

        .shop-header__logo {

            display: block;

            width: 100%;
            height: 100%;

            object-fit: contain;

            border-radius: inherit;

        }


        /* =====================================================
           BUSINESS INFORMATION
        ===================================================== */

        .shop-header__information {

            display: flex;

            flex-direction: column;
            justify-content: center;

            gap: 3px;

            min-width: 0;

        }

        .shop-header__name {

            display: block;

            color: var(--sh-text);

            font-size: 17px;
            font-weight: 700;
            line-height: 1.2;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

        }

        .shop-header__category {

            display: flex;

            align-items: center;

            gap: 5px;

            color: var(--sh-muted);

            font-size: 11px;
            line-height: 1.3;

            min-width: 0;

        }

        .shop-header__category i {

            flex-shrink: 0;

            font-size: 12px;

        }

        .shop-header__category-name {

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

        }


        /* =====================================================
           RATING
        ===================================================== */

        .shop-header__rating {

            display: flex;

            align-items: center;

            gap: 2px;

            min-width: 0;

            color: var(--sh-warning);

            font-size: 12px;
            line-height: 1.2;

        }

        .shop-header__rating i {

            color: var(--sh-warning);

            font-size: inherit;

        }


        /* =====================================================
           SEPARATOR
        ===================================================== */

        .shop-header__separator {

            display: block;

            width: 1px;
            height: 42px;

            background: #d5d9e4;

        }


        /* =====================================================
           SCHEDULE
        ===================================================== */

        .shop-header__schedule {

            display: flex;

            flex-direction: column;
            align-items: flex-start;
            justify-content: center;

            gap: 5px;

            min-width: 0;
            max-width: 115px;

        }

        .shop-header__status {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            max-width: 100%;

            padding: 5px 8px;

            border-radius: 20px;

            font-size: 11px;
            font-weight: 600;
            line-height: 1.2;

        }

        .shop-header__status-dot {

            display: inline-block;

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: currentColor;

            flex-shrink: 0;

        }

        .shop-header__status-label {

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

        }


        /* STATUS MODIFIERS */

        .shop-header__status--open {

            color: var(--sh-success);

            background: var(--sh-success-background);

        }

        .shop-header__status--closed {

            color: var(--sh-danger);

            background: var(--sh-danger-background);

        }

        .shop-header__status--unknown {

            color: var(--sh-neutral);

            background: var(--sh-neutral-background);

        }


        /* SCHEDULE TEXT */

        .shop-header__schedule-text {

            color: var(--sh-muted);

            font-size: 10px;
            line-height: 1.4;

            font-variant-numeric: tabular-nums;

        }

        .shop-header__schedule-text:empty {

            display: none;

        }

        .shop-header__more {

            display: none;

            color: var(--sh-primary);

            font-size: 12px;
            font-weight: 500;

        }


        /* =====================================================
           ACTION
        ===================================================== */

        .shop-header__action {

            display: flex;

            align-items: center;
            justify-content: center;

            color: var(--sh-muted);

            font-size: 14px;

        }


        /* =====================================================
           HOVER - DESKTOP
        ===================================================== */

        @media (hover: hover) {

            .shop-header__card:hover {

                background: var(--sh-surface);

                border-color: #c6ccef;

                box-shadow:
                    0 4px 14px rgba(24, 32, 51, 0.09);

            }

        }

        input.search-field.form-control {
            height: 54px !important;
        }
        /* =====================================================
           SMALL MOBILE
           320px - 359px
        ===================================================== */

        @media (max-width: 359.98px) {

            .shop-header {

                --sh-logo-size: 44px;
                --sh-radius: 12px;

            }

            .shop-header__card {

                gap: 6px;

                padding: 8px;

            }

            .shop-header__name {

                font-size: 15px;

            }

            .shop-header__category {

                font-size: 10px;

            }

            .shop-header__rating {

                font-size: 10px;

            }

            .shop-header__schedule {

                max-width: 90px;

            }

            .shop-header__schedule-text {

                font-size: 9px;

            }

            .shop-header__status {

                font-size: 10px;

                padding: 4px 6px;

            }

        }


        /* =====================================================
           LARGE MOBILE
           390px+
        ===================================================== */

        @media (min-width: 390px) {

            .shop-header {

                --sh-logo-size: 64px;

            }

            .shop-header__card {

                gap: 12px;

                padding: 12px;

            }

            .shop-header__name {

                font-size: 20px;

            }

            .shop-header__category {

                font-size: 12px;

            }

            .shop-header__rating {

                font-size: 14px;

            }

            .shop-header__schedule {

                max-width: 145px;

            }

            .shop-header__schedule-text {

                font-size: 11px;

            }

            .shop-header__status {

                font-size: 12px;

            }

        }


        /* =====================================================
           TABLET - BOOTSTRAP MD
           768px+
        ===================================================== */

        @media (min-width: 768px) {

            .shop-header {

                --sh-logo-size: 76px;
                --sh-radius: 18px;

                margin-bottom: 16px;

            }

            .shop-header__card {

                grid-template-columns:
            var(--sh-logo-size)
            minmax(0, 1fr)
            1px
            minmax(160px, auto)
            24px;

                gap: 20px;

                padding: 14px 18px;

            }

            .shop-header__name {

                font-size: 24px;

            }

            .shop-header__category {

                font-size: 14px;

            }

            .shop-header__category i {

                font-size: 15px;

            }

            .shop-header__rating {

                font-size: 16px;

            }

            .shop-header__separator {

                height: 58px;

            }

            .shop-header__schedule {

                max-width: none;

            }

            .shop-header__status {

                padding: 6px 12px;

                font-size: 13px;

            }

            .shop-header__schedule-text {

                font-size: 13px;

            }

            .shop-header__more {

                display: block;

            }

            .shop-header__action {

                font-size: 20px;

            }

        }


        /* =====================================================
           DESKTOP - BOOTSTRAP LG
           992px+
        ===================================================== */

        @media (min-width: 992px) {

            .shop-header {

                --sh-logo-size: 80px;

            }

            .shop-header__card {

                grid-template-columns:
            var(--sh-logo-size)
            minmax(0, 1fr)
            1px
            minmax(190px, auto)
            24px;

                gap: 24px;

                padding: 16px 22px;

            }

            .shop-header__name {

                font-size: 26px;

            }

        }
    </style>
    <style id="aside">
        /* =====================================================
   SHOP BUSINESS ASIDE
   YAPITA - MOBILE FIRST
===================================================== */

        .shop-business-aside {

            --sba-primary: var(--mc-azulClic, #354cff);
            --sba-yellow: var(--mc-amarilloVital, #ffcc00);

            --sba-text: #151644;
            --sba-muted: #59647c;

            --sba-background: #ffffff;
            --sba-border: #e0e3ef;

            --sba-radius: 15px;
            --sba-padding: 14px;

            --sba-logo-size: 78px;

            --bs-offcanvas-width: 100%;
            --bs-offcanvas-bg: var(--sba-background);

            --bs-offcanvas-border-width: 0;

            color: var(--sba-text);

            border-radius: 20px 0 0 20px;

            box-shadow:
                -6px 0 30px rgba(15, 23, 42, .12);

            overflow: hidden;

            text-align: left;

        }

        .shop-business-aside[v-cloak] {

            display: none;

        }

        .shop-business-aside * {

            box-sizing: border-box;

        }


        /* =====================================================
           TOOLBAR
        ===================================================== */

        .shop-business-aside__toolbar {

            display: flex;

            justify-content: flex-end;
            align-items: center;

            padding: 8px var(--sba-padding) 0;

            flex-shrink: 0;

        }

        .shop-business-aside__close {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 36px;
            height: 36px;

            padding: 0;

            border: 0;
            border-radius: 10px;

            background: transparent;

            color: var(--sba-text);

            font-size: 19px;

            cursor: pointer;

        }


        /* =====================================================
           BODY
        ===================================================== */

        .shop-business-aside__body {

            display: flex;

            flex-direction: column;

            gap: 14px;

            min-height: 0;

            padding: 0 var(--sba-padding) 24px;

            overflow-y: auto;

            overscroll-behavior: contain;

        }

        .shop-business-aside__body > section {

            flex-shrink: 0;

        }


        /* =====================================================
           PROFILE
        ===================================================== */

        .shop-business-aside__profile {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 0 3px 2px;

        }

        .shop-business-aside__logo-wrapper {

            display: flex;

            align-items: center;
            justify-content: center;

            width: var(--sba-logo-size);
            height: var(--sba-logo-size);

            flex-shrink: 0;

            border: 3px solid #ffffff;

            border-radius: 50%;

            background: #f1f5f9;

            box-shadow:
                0 2px 7px rgba(15, 23, 42, .18);

            overflow: hidden;

        }

        .shop-business-aside__logo {

            display: block;

            width: 100%;
            height: 100%;

            object-fit: contain;

            border-radius: inherit;

        }

        .shop-business-aside__information {

            display: flex;

            flex-direction: column;

            gap: 5px;

            flex: 1;

            min-width: 0;

        }

        .shop-business-aside__name {

            margin: 0;
            padding: 0;

            color: var(--sba-text);

            font-family: inherit;

            font-size: 23px;
            font-weight: 800;

            line-height: 1.2;

            text-align: left;

            overflow-wrap: anywhere;

        }

        .shop-business-aside__category {

            color: var(--sba-muted);

            font-size: 12px;

            line-height: 1.4;

        }


        /* =====================================================
           RATING
        ===================================================== */

        .shop-business-aside__rating {

            display: flex;

            align-items: center;
            flex-wrap: wrap;

            gap: 4px;

            line-height: 1.2;

        }

        .shop-business-aside__stars {

            display: inline-flex;

            align-items: center;

            gap: 2px;

            color: #ffb800;

            font-size: 13px;

        }

        .shop-business-aside__rating-value {

            color: var(--sba-text);

            font-size: 13px;
            font-weight: 800;

        }

        .shop-business-aside__rating-count {

            color: var(--sba-muted);

            font-size: 10px;

        }


        /* =====================================================
           DETAILS
        ===================================================== */

        .shop-business-aside__details {
            padding-top: 0px;
            padding-bottom: 0px;
            display: flex;
            flex-direction: column;

            gap: 7px;

        }


        /* =====================================================
           INFORMATION ITEM
        ===================================================== */

        .shop-business-aside__item {

            display: flex;

            align-items: center;

            gap: 10px;

            width: 100%;

            min-height: 48px;

            padding: 7px;

            border: 1px solid var(--sba-border);

            border-radius: 13px;

            background: #ffffff;

            color: var(--sba-text);

            font-family: inherit;

            text-align: left;

            transition:
                background-color .2s ease,
                border-color .2s ease;

        }

        button.shop-business-aside__item {

            cursor: pointer;

        }

        .shop-business-aside__item:disabled {

            cursor: default;

        }

        .shop-business-aside__item:disabled
        .shop-business-aside__item-action {

            display: none;

        }

        .shop-business-aside__item-icon {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 34px;
            height: 34px;

            flex-shrink: 0;

            border: 1px solid var(--sba-border);

            border-radius: 10px;

            background: #f7f9ff;

            color: var(--sba-primary);

            font-size: 20px;

        }

        .shop-business-aside__item-icon--rating {

            border: 0;

            background: transparent;

            color: #ffb800;

        }

        .shop-business-aside__item-content {

            display: flex;

            flex-direction: column;

            align-items: flex-start;

            gap: 3px;

            flex: 1;

            min-width: 0;

        }

        .shop-business-aside__item-title {

            color: var(--sba-text);

            font-size: 12px;
            font-weight: 700;

            line-height: 1.2;

        }

        .shop-business-aside__item-description {

            color: var(--sba-muted);

            font-size: 11px;

            line-height: 1.4;

            overflow-wrap: anywhere;

        }

        .shop-business-aside__item-count {

            color: var(--sba-muted);

            font-size: 11px;
            font-weight: 400;

        }

        .shop-business-aside__item-action {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 25px;

            flex-shrink: 0;

            color: var(--sba-primary);

            font-size: 16px;

        }


        /* =====================================================
           SECTION
        ===================================================== */

        .shop-business-aside__section {

            display: flex;

            flex-direction: column;

            gap: 10px;

            padding: 12px;

            border-radius: 17px;

        }

        .shop-business-aside__section-header {

            display: flex;

            align-items: center;

            gap: 9px;

        }

        .shop-business-aside__section-header > i {

            font-size: 23px;

            line-height: 1;

        }

        .shop-business-aside__section-title {

            flex: 1;

            margin: 0;
            padding: 0;

            font-family: inherit;

            font-size: 15px;
            font-weight: 800;

            text-align: left;

        }

        .shop-business-aside__section-badge {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 25px;
            height: 25px;

            border-radius: 50%;

            background: #a100e7;

            color: #ffffff;

            font-size: 14px;

        }


        /* =====================================================
           PROMOTIONS
        ===================================================== */

        .shop-business-aside__section--promotions {

            background: linear-gradient(
                135deg,
                #f9ecfa,
                #eee6fc
            );

            color: #5816a8;

        }

        .shop-business-aside__section--promotions
        .shop-business-aside__section-header > i {

            color: #ed168c;

        }

        .shop-business-aside__promotions {

            display: flex;

            flex-direction: column;

            gap: 7px;

        }

        .shop-business-aside__promotion {

            display: flex;

            align-items: center;

            gap: 9px;

            width: 100%;

            padding: 5px;

            border: 0;
            border-radius: 12px;

            background: rgba(255, 255, 255, .92);

            color: var(--sba-text);

            text-align: left;

            cursor: pointer;

        }

        .shop-business-aside__promotion-image {

            display: block;

            width: 82px;
            height: 72px;

            flex-shrink: 0;

            object-fit: cover;

            border-radius: 9px;

        }

        .shop-business-aside__promotion-content {

            display: flex;

            flex-direction: column;

            align-items: flex-start;

            flex: 1;

            gap: 4px;

            min-width: 0;

        }

        .shop-business-aside__promotion-name {

            color: var(--sba-text);

            font-size: 13px;
            font-weight: 800;

            line-height: 1.2;

        }

        .shop-business-aside__promotion-description {

            color: var(--sba-muted);

            font-size: 10px;

            line-height: 1.4;

            overflow-wrap: anywhere;

        }

        .shop-business-aside__promotion-price {

            display: inline-flex;

            align-items: center;

            padding: 4px 12px;

            border-radius: 7px;

            background: var(--sba-yellow);

            color: #1f2937;

            font-size: 15px;
            font-weight: 800;

            line-height: 1.2;

        }

        .shop-business-aside__promotion-action {

            color: var(--sba-primary);

            font-size: 15px;

            flex-shrink: 0;

        }

        .shop-business-aside__mock {

            color: var(--sba-muted);

            font-size: 10px;

        }


        /* =====================================================
           YAPITA BENEFITS
        ===================================================== */

        .shop-business-aside__section--benefits {

            background: linear-gradient(
                135deg,
                #edf2ff,
                #e0e9fc
            );

            color: #14279b;

        }

        .shop-business-aside__section--benefits
        .shop-business-aside__section-header > i {

            color: #ffb800;

        }

        .shop-business-aside__benefits {

            display: flex;

            flex-direction: column;

            gap: 3px;

        }

        .shop-business-aside__benefit {

            display: flex;

            align-items: center;

            gap: 10px;

            min-height: 30px;

            width: 100%;

            padding: 4px;

            border: 0;
            border-radius: 8px;

            background: transparent;

            color: var(--sba-text);

            text-align: left;

            cursor: pointer;

        }

        .shop-business-aside__benefit-icon {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 19px;
            height: 19px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #c6d4ff;

            color: var(--sba-primary);

            font-size: 12px;

        }

        .shop-business-aside__benefit-title {

            flex: 1;

            min-width: 0;

            font-size: 12px;

            line-height: 1.4;

        }

        .shop-business-aside__benefit-action {

            color: var(--sba-primary);

            font-size: 14px;

        }

        .shop-business-aside__empty {

            padding: 10px;

            color: var(--sba-muted);

            font-size: 12px;

            text-align: center;

        }


        /* =====================================================
           ACCESSIBILITY
        ===================================================== */

        .shop-business-aside button:focus-visible {

            outline: 2px solid var(--sba-primary);

            outline-offset: -2px;

        }


        /* =====================================================
           HOVER
        ===================================================== */

        @media (hover: hover) {

            .shop-business-aside__close:hover {

                background: #f1f5f9;

            }

            button.shop-business-aside__item:hover:not(:disabled) {

                background: #f7f9ff;

                border-color: #bcc9ff;

            }

            .shop-business-aside__benefit:hover {

                background: rgba(255, 255, 255, .45);

            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (min-width: 390px) {

            .shop-business-aside {

                --sba-padding: 18px;

                --sba-logo-size: 86px;

            }

            .shop-business-aside__name {

                font-size: 25px;

            }

            .shop-business-aside__item-title {

                font-size: 13px;

            }

            .shop-business-aside__item-description {

                font-size: 12px;

            }

        }


        /* =====================================================
           LARGE MOBILE - BS5 SM
        ===================================================== */

        @media (min-width: 576px) {

            .shop-business-aside {

                --bs-offcanvas-width: 400px;

            }

        }


        /* =====================================================
           TABLET - BS5 MD
        ===================================================== */

        @media (min-width: 768px) {

            .shop-business-aside {

                --bs-offcanvas-width: 420px;

                --sba-padding: 20px;

                --sba-logo-size: 90px;

            }

            .shop-business-aside__body {

                gap: 17px;

            }

            .shop-business-aside__section {

                padding: 15px;

            }

            .shop-business-aside__item {

                min-height: 54px;

            }

        }


        /* =====================================================
           DESKTOP - BS5 XL
        ===================================================== */

        @media (min-width: 1200px) {

            .shop-business-aside {

                --bs-offcanvas-width: 440px;

            }

        }
        /* =====================================================
       SHOP BUSINESS ASIDE - SCROLL MANAGEMENT
    ===================================================== */


        /* =====================================================
           1. LOCK BACKGROUND SCROLL
        ===================================================== */

        html.shop-manager--scroll-locked,
        body.shop-manager--scroll-locked {

            overflow: hidden !important;
            overscroll-behavior: none;

        }


        /* =====================================================
           2. BLOCK BACKGROUND CONTAINERS
        ===================================================== */

        body.shop-manager--scroll-locked .content,
        body.shop-manager--scroll-locked .content-render-process,
        body.shop-manager--scroll-locked .manager-page__data-page,
        body.shop-manager--scroll-locked .content-manager-grid {

            overflow: hidden !important;
            overscroll-behavior: none;

        }


        /* =====================================================
           3. ASIDE - MAIN CONTAINER
        ===================================================== */

        #shop-business-aside {

            position: fixed !important;

            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            left: auto !important;

            display: flex !important;
            flex-direction: column !important;

            height: 100vh !important;
            height: 100dvh !important;

            max-height: 100vh;
            max-height: 100dvh;

            max-width: 100vw;

            margin: 0 !important;
            padding: 0 !important;

            overflow: hidden !important;

            box-sizing: border-box;

            overscroll-behavior: contain;

        }


        /* =====================================================
           4. TOOLBAR - FIXED WITHOUT SCROLL
        ===================================================== */

        #shop-business-aside .shop-business-aside__toolbar {

            position: relative;

            flex: 0 0 auto;

            width: 100%;

            background: var(--sba-background, #ffffff);

        }


        /* =====================================================
           5. BODY - INTERNAL VERTICAL SCROLL
        ===================================================== */

        #shop-business-aside .shop-business-aside__body {

            position: relative;

            display: flex;
            flex-direction: column;

            flex: 1 1 0%;

            width: 100%;
            height: 0;

            min-width: 0;
            min-height: 0;

            overflow-x: hidden !important;
            overflow-y: auto !important;

            overscroll-behavior-y: contain;

            touch-action: pan-y;

            -webkit-overflow-scrolling: touch;

            pointer-events: auto;

        }


        /* =====================================================
           6. PREVENT CONTENT SHRINKING
        ===================================================== */

        #shop-business-aside .shop-business-aside__body > * {

            flex-shrink: 0;

        }


        /* =====================================================
           7. BACKDROP
        ===================================================== */

        body.shop-manager--scroll-locked .offcanvas-backdrop {

            overscroll-behavior: none;

            touch-action: none;

        }


        /* =====================================================
           8. SCROLLBAR DESIGN
        ===================================================== */

        #shop-business-aside .shop-business-aside__body {

            scrollbar-width: thin;

            scrollbar-color: #cbd5e1 transparent;

        }

        #shop-business-aside
        .shop-business-aside__body::-webkit-scrollbar {

            width: 5px;

        }

        #shop-business-aside
        .shop-business-aside__body::-webkit-scrollbar-track {

            background: transparent;

        }

        #shop-business-aside
        .shop-business-aside__body::-webkit-scrollbar-thumb {

            background: #cbd5e1;

            border-radius: 10px;

        }

        #shop-business-aside
        .shop-business-aside__body::-webkit-scrollbar-thumb:hover {

            background: var(--sba-primary, #354cff);

        }
        /* =====================================================
   SHOP BUSINESS ASIDE - SHARE WHATSAPP
===================================================== */

        .shop-business-aside__item--share {

            background: #f0fdf4;

            border-color: #bbdfc5;

        }

        .shop-business-aside__item-icon--whatsapp {

            background: #dcfce7;

            border-color: #bbdfc5;

            color: #16a34a;

        }

        .shop-business-aside__item-action--whatsapp {

            color: #16a34a;

        }

        @media (hover: hover) {

            button.shop-business-aside__item--share:hover {

                background: #dcfce7;

                border-color: #25d366;

            }

        }
        /* =====================================================
   SHOP BUSINESS ASIDE - SCHEDULE ACCORDION
===================================================== */

        .shop-business-aside__schedule {
            width: 100%;
            min-width: 0;
            border: 1px solid #dce1f2;
            border-radius: 12px;
            overflow: hidden;
        }

        /* ACCORDION TRIGGER */

        .shop-business-aside__schedule
        .shop-business-aside__schedule-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            border: 0;
            border-radius: 0;
            background: transparent;
            margin: 0;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            color: inherit;
        }

        /* ARROW */

        .shop-business-aside__schedule-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-left: auto;
            padding-left: 8px;
            color: #6558ff;
            font-size: 13px;
        }

        .shop-business-aside__schedule-arrow i {
            transition: transform 0.2s ease;
        }

        .shop-business-aside__schedule--expanded
        .shop-business-aside__schedule-arrow i {
            transform: rotate(180deg);
        }

        /* ACCORDION CONTENT */

        .shop-business-aside__schedule-content {
            padding: 0 10px 10px;
        }

        /* HEADER */

        .shop-business-aside__schedule-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
            padding: 10px 4px;
            border-top: 1px solid #e5e7f1;
        }

        .shop-business-aside__schedule-heading {
            font-size: 11px;
            color: #7c859e;
            font-weight: 500;
        }

        /* BUSINESS STATUS */

        .shop-business-aside__schedule-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
        }

        .shop-business-aside__schedule-status i {
            font-size: 7px;
        }

        .shop-business-aside__schedule-status--open {
            color: #168b56;
        }

        .shop-business-aside__schedule-status--closed {
            color: #dc3545;
        }

        .shop-business-aside__schedule-status--unknown {
            color: #7c859e;
        }

        /* SCHEDULE LIST */

        .shop-business-aside__schedule-list {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        /* SCHEDULE DAY */

        .shop-business-aside__schedule-day {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 7px 8px;
            border-radius: 7px;
            font-size: 11px;
        }

        .shop-business-aside__schedule-day-name {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
            color: #171749;
            font-weight: 500;
        }

        .shop-business-aside__schedule-day-name small {
            font-size: 10px;
        }

        .shop-business-aside__schedule-day-time {
            color: #7c859e;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        /* CURRENT DAY */

        .shop-business-aside__schedule-day--today {
            background: #eef1ff;
        }

        .shop-business-aside__schedule-day--today
        .shop-business-aside__schedule-day-name,

        .shop-business-aside__schedule-day--today
        .shop-business-aside__schedule-day-time {
            color: #3558df;
            font-weight: 600;
        }

        /* CLOSED DAY */

        .shop-business-aside__schedule-day--closed
        .shop-business-aside__schedule-day-time {
            color: #dc3545;
        }

        /* EMPTY STATE */

        .shop-business-aside__schedule-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 15px 8px;
            text-align: center;
            color: #7c859e;
            font-size: 11px;
        }

        .shop-business-aside__schedule-empty i {
            font-size: 20px;
        }

        /* TRANSITION - VUE 2 / VUE 3 */

        .shop-schedule-enter-active,
        .shop-schedule-leave-active {
            transition: opacity 0.2s ease,
            transform 0.2s ease;
        }

        .shop-schedule-enter,
        .shop-schedule-enter-from,
        .shop-schedule-leave-to {
            opacity: 0;
            transform: translateY(-5px);
        }
    </style>
    <style id="fix-manager">
        /* =====================================================
   SHOP FILTERS - STICKY MANAGEMENT
===================================================== */

        .shop-filters-anchor {
            position: relative;
            width: 100%;
            min-width: 0;
        }

        /* =====================================================
           FILTERS CONTAINER
        ===================================================== */

        .shop-filters {
            width: 100%;
            min-width: 0;

            display: flex;
            flex-direction: column;

            gap: 8px;
            padding: 8px 0 12px;

            background: #ffffff;
            box-sizing: border-box;
        }

        /* =====================================================
           STICKY ENABLED
        ===================================================== */

        .shop-filters--sticky {
            position: relative;
        }

        /* =====================================================
           STUCK STATE
        ===================================================== */

        .shop-filters--sticky.shop-filters--stuck {

            position: fixed !important;

            top: var(--shop-filters-top, 0px);
            left: var(--shop-filters-left, 0px);

            width: var(--shop-filters-width, 100%);

            z-index: 1020;

            background: #ffffff;

            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);

            border-bottom: 1px solid #e5e7eb;

            padding: 8px 10px 12px;
        }

        /* =====================================================
           BOOTGRID HEADER
        ===================================================== */

        .shop-filters #grid-registers-grid-header {

            position: relative !important;

            width: 100% !important;

            top: auto !important;
            left: auto !important;

            margin: 0 !important;
            padding: 0 !important;

            z-index: auto !important;
        }

        .shop-filters .mc-grid__header {

            margin: 0 !important;
            padding: 6px 0 !important;
        }

        /* =====================================================
           SEARCH
        ===================================================== */

        .shop-filters .mc-grid__center {

            flex: 1;

            width: auto !important;
            min-width: 0;
        }

        .shop-filters .mc-grid__search-wrapper {

            width: 100%;
            margin: 0;
        }

        /* =====================================================
           CATEGORIES AND SUBCATEGORIES
        ===================================================== */

        .shop-filters .filters-sections {

            position: relative;

            width: 100%;

            min-width: 0;

            margin: 0 !important;
            padding: 0 !important;

            display: flex;
            flex-direction: column;

            gap: 8px;
        }

        .shop-filters .categories,
        .shop-filters .sub-categories {

            width: 100%;
            min-width: 0;

            margin: 0;
            padding: 0;
        }

        .shop-filters .owl-carousel {
            width: 100%;
        }

        /* =====================================================
           PRODUCTS CONTAINER
        ===================================================== */

        #app-management .content-manager-grid
        .custom-scroll-admin-grid.table-responsive--fixed {

            margin-top: 0 !important;

            height: auto !important;
            max-height: none !important;
        }

        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 767.98px) {

            .shop-filters {
                gap: 6px;
                padding: 6px 0 10px;
            }

            .shop-filters--sticky.shop-filters--stuck {
                padding: 0 0 0;
            }

            .shop-filters .mc-grid__header {
                padding: 4px 0 !important;
            }

        }

        /* =====================================================
           TABLET
        ===================================================== */

        @media (min-width: 768px) and (max-width: 1199.98px) {

            .shop-filters {
                padding: 10px 0;
            }

        }

        /* =====================================================
           DESKTOP
        ===================================================== */

        @media (min-width: 1200px) {

            .shop-filters {
                padding: 12px 0;
            }

        }
    </style>
    @include('frontend.web.shopPage.assets.css.shop-manager.grid')
    @include('frontend.web.shopPage.assets.css.shop-manager.shop-cart-footer-style')
    @include('frontend.web.shopPage.assets.css.shop-manager.order.shop-order-aside-style')
    @include('frontend.web.shopPage.assets.css.shop-product-aside')


@endsection
@section('script')

@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>
    <script>
        class ShopFiltersStickyManager {

            constructor(options = {}) {

                this.config = $.extend({

                    containerSelector: '.content-manager-grid',

                    gridHeaderSelector: '#grid-registers-grid-header',

                    filtersSelector: '.filters-sections',

                    productsSelector: '#grid-registers-grid',

                    headerSelector: '.main-header',

                    anchorClass: 'shop-filters-anchor',

                    baseClass: 'shop-filters',

                    stickyClass: 'shop-filters--sticky',

                    stuckClass: 'shop-filters--stuck',

                    scrollContainer: window,

                    autoTop: true,

                    top: 0,

                    offset: 0,

                    enabled: true,

                    zIndex: 1020

                }, options);

                this.$container = $();
                this.$gridHeader = $();
                this.$filters = $();

                this.$anchor = $();
                this.$wrapper = $();

                this.$header = $();

                this.isInitialized = false;
                this.isStuck = false;

                this.frameId = null;
                this.resizeObserver = null;

                this.originalPositions = [];

                this.eventNamespace = '.shopFiltersSticky';

                this.boundUpdate = this.requestUpdate.bind(this);

            }

            /* =====================================================
               INIT
            ===================================================== */

            init() {

                if (this.isInitialized) {
                    this.refresh();
                    return this;
                }

                this.$container = $(this.config.containerSelector).first();

                this.$gridHeader = this.$container
                    .find(this.config.gridHeaderSelector)
                    .first();

                this.$filters = this.$container
                    .find(this.config.filtersSelector)
                    .first();

                this.$header = $(this.config.headerSelector).first();

                if (
                    !this.$container.length ||
                    !this.$gridHeader.length ||
                    !this.$filters.length
                ) {

                    console.warn(
                        '[ShopFiltersStickyManager] No se encontraron los elementos.'
                    );

                    return this;
                }

                this.buildStructure();

                this.isInitialized = true;

                this.bindEvents();

                this.initResizeObserver();

                this.refresh();

                return this;

            }

            /* =====================================================
               BUILD STRUCTURE
            ===================================================== */

            buildStructure() {

                // Guardar posiciones originales para destroy().
                this.originalPositions = [];

                [
                    this.$gridHeader,
                    this.$filters

                ].forEach($element => {

                    const placeholder = document.createComment(
                        'shop-filters-original-position'
                    );

                    $element[0].parentNode.insertBefore(
                        placeholder,
                        $element[0]
                    );

                    this.originalPositions.push({
                        element: $element,
                        placeholder: placeholder
                    });

                });

                this.$anchor = $('<div>', {

                    class: this.config.anchorClass

                });

                this.$wrapper = $('<div>', {

                    class: this.config.baseClass

                });

                this.$anchor.insertBefore(this.$gridHeader);

                this.$anchor.append(this.$wrapper);

                // Mover elementos originales sin eliminar sus eventos.
                this.$wrapper.append(this.$gridHeader.detach());

                this.$wrapper.append(this.$filters.detach());

                if (this.config.enabled) {

                    this.$wrapper.addClass(
                        this.config.stickyClass
                    );

                }

            }

            /* =====================================================
               GET HEADER TOP
            ===================================================== */

            getTop() {

                if (!this.config.autoTop) {

                    return this.config.top + this.config.offset;

                }

                if (!this.$header.length) {

                    return this.config.top + this.config.offset;

                }

                const rect = this.$header[0]
                    .getBoundingClientRect();

                return Math.max(0, rect.bottom) +
                    this.config.offset;

            }

            /* =====================================================
               BIND EVENTS
            ===================================================== */

            bindEvents() {

                $(this.config.scrollContainer).on(

                    'scroll' + this.eventNamespace,

                    this.boundUpdate

                );

                $(window).on(

                    'resize' + this.eventNamespace +
                    ' orientationchange' + this.eventNamespace,

                    this.boundUpdate

                );

            }

            /* =====================================================
               RESIZE OBSERVER
            ===================================================== */

            initResizeObserver() {

                if (typeof ResizeObserver === 'undefined') {
                    return;
                }

                this.resizeObserver = new ResizeObserver(() => {

                    this.requestUpdate();

                });

                this.resizeObserver.observe(
                    this.$wrapper[0]
                );

                this.resizeObserver.observe(
                    this.$anchor[0]
                );

                if (this.$header.length) {

                    this.resizeObserver.observe(
                        this.$header[0]
                    );

                }

            }

            /* =====================================================
               REQUEST UPDATE
            ===================================================== */

            requestUpdate() {

                if (!this.isInitialized) {
                    return;
                }

                if (this.frameId !== null) {
                    return;
                }

                this.frameId = requestAnimationFrame(() => {

                    this.frameId = null;

                    this.update();

                });

            }

            /* =====================================================
               UPDATE
            ===================================================== */

            update() {

                if (!this.isInitialized) {
                    return;
                }

                if (!this.config.enabled) {

                    this.unstick();

                    return;

                }

                const anchorRect = this.$anchor[0]
                    .getBoundingClientRect();

                const top = this.getTop();

                const shouldStick = anchorRect.top <= top;

                if (shouldStick) {

                    this.stick(top, anchorRect);

                } else {

                    this.unstick();

                }

            }

            /* =====================================================
               STICK
            ===================================================== */

            stick(top, anchorRect) {

                const wasStuck = this.isStuck;

                this.$wrapper[0].style.setProperty(

                    '--shop-filters-top',

                    `${top}px`

                );

                this.$wrapper[0].style.setProperty(

                    '--shop-filters-left',

                    `${anchorRect.left}px`

                );

                this.$wrapper[0].style.setProperty(

                    '--shop-filters-width',

                    `${anchorRect.width}px`

                );

                this.$wrapper.css(

                    'z-index',

                    this.config.zIndex

                );

                // Reservar espacio antes de aplicar position: fixed.
                if (!wasStuck) {

                    this.$anchor.height(
                        this.$wrapper.outerHeight()
                    );

                }

                this.$wrapper.addClass(
                    this.config.stuckClass
                );

                // Actualizar altura si aparecen subcategorías.
                const height = this.$wrapper.outerHeight();

                if (Math.abs(this.$anchor.height() - height) > 0.5) {

                    this.$anchor.height(height);

                }

                this.isStuck = true;

                if (!wasStuck) {

                    this.emit('shop:filters:stuck', {

                        isStuck: true,

                        top: top,

                        height: height

                    });

                }

            }

            /* =====================================================
               UNSTICK
            ===================================================== */

            unstick() {

                if (!this.$wrapper.length) {
                    return;
                }

                const wasStuck = this.isStuck;

                this.$wrapper.removeClass(
                    this.config.stuckClass
                );

                this.$wrapper.css('z-index', '');

                this.$anchor.css('height', '');

                this.isStuck = false;

                if (wasStuck) {

                    this.emit('shop:filters:unstuck', {

                        isStuck: false

                    });

                }

            }

            /* =====================================================
               REFRESH
            ===================================================== */

            refresh() {

                this.requestUpdate();

                return this;

            }

            /* =====================================================
               ENABLE
            ===================================================== */

            enable() {

                this.config.enabled = true;

                this.$wrapper.addClass(
                    this.config.stickyClass
                );

                this.refresh();

                return this;

            }

            /* =====================================================
               DISABLE
            ===================================================== */

            disable() {

                this.config.enabled = false;

                this.unstick();

                this.$wrapper.removeClass(
                    this.config.stickyClass
                );

                return this;

            }

            /* =====================================================
               EMIT EVENTS
            ===================================================== */

            emit(eventName, data = {}) {

                this.$container.trigger(

                    eventName,

                    [data]

                );

            }

            /* =====================================================
               DESTROY
            ===================================================== */

            destroy() {

                if (!this.isInitialized) {
                    return;
                }

                $(this.config.scrollContainer).off(
                    this.eventNamespace
                );

                $(window).off(
                    this.eventNamespace
                );

                if (this.resizeObserver) {

                    this.resizeObserver.disconnect();

                    this.resizeObserver = null;

                }

                if (this.frameId !== null) {

                    cancelAnimationFrame(this.frameId);

                    this.frameId = null;

                }

                this.unstick();

                // Restaurar los elementos a su posición original.
                this.originalPositions.forEach(item => {

                    if (item.placeholder.parentNode) {

                        item.element.detach();

                        item.placeholder.parentNode.insertBefore(

                            item.element[0],

                            item.placeholder

                        );

                        item.placeholder.remove();

                    }

                });

                this.$anchor.remove();

                this.originalPositions = [];

                this.isInitialized = false;

            }

        }
    </script>
    <script>
        var $urlRouteBusiness = '{{$urlRouteBusiness}}';


        var $urlRouteGamesBusiness = '{{$urlRouteGamesBusiness}}';
        var $urlRouteRewardsBusiness = '{{$urlRouteRewardsBusiness}}';
        var $urlRouteRateBusiness = '{{$urlRouteRateBusiness}}';
    </script>
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

    </script>
    <script>
        $(function () {
            $(document)

                .off('shop:aside:contact:whatsapp.shopBusinessContact')

                .on(

                    'shop:aside:contact:whatsapp.shopBusinessContact',

                    function (event) {

                        const payload = event.originalEvent?.detail;

                        const whatsapp = payload?.whatsapp;

                        if (!whatsapp?.url) {
                            return;
                        }

                        window.open(
                            whatsapp.url,
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }

                );
            $(document)

                .off('shop:aside:share:whatsapp.shopShare')

                .on(
                    'shop:aside:share:whatsapp.shopShare',
                    function (event) {

                        const payload = event.originalEvent.detail;

                        const share = payload.share;

                        if (!share) {
                            return;
                        }

                        const message = [

                            `*${share.title}*`,

                            share.description,

                            share.url

                        ].filter(Boolean).join('\n\n');

                        const whatsappUrl =
                            `https://wa.me/?text=${encodeURIComponent(message)}`;

                        window.open(
                            whatsappUrl,
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }
                );
            $(document).on(

                'shop:aside:location:click',

                function (event) {

                    const payload = event.originalEvent.detail;

                    const url = payload.data.location.mapsUrl;

                    if (url) {

                        window.open(
                            url,
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }

                }

            );
            $(document).on(

                'shop:aside:contact:copy',

                async function (event) {

                    const payload = event.originalEvent.detail;

                    const phone = payload.data.contact.phone;

                    if (!phone) {
                        return;
                    }

                    try {

                        await navigator.clipboard.writeText(phone);

                        console.log('Teléfono copiado:', phone);

                    } catch (error) {

                        console.error(
                            'No se pudo copiar el teléfono',
                            error
                        );

                    }

                }

            );
            $(document).on(

                'shop:aside:reviews:click',

                function (event) {

                    const payload = event.originalEvent.detail;

                    const url = payload.data.reviews.url;

                    if (url) {

                        window.open(
                            url,
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }

                }

            );
            $(document).on(

                'shop:aside:benefit:click',

                function (event) {

                    const payload = event.originalEvent.detail;

                    const benefit = payload.item;

                    console.log('Benefit:', benefit);

                    if (benefit.url) {

                        window.open(
                            benefit.url,
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }

                }

            );
            $(document).on(

                'shop:aside:benefit:click',

                function (event) {

                    const payload = event.originalEvent.detail;

                    const benefit = payload.item;

                    console.log('Benefit:', benefit);

                    if (benefit.url) {

                        window.open(
                            benefit.url,
                            '_blank',
                            'noopener,noreferrer'
                        );

                    }

                }

            );
        })
    </script>
@endsection

@section('content')
    @include('frontend.web.'.$managementNameProcess.'.actions')
    <div id="app-management" class="page-home-init" dataManagerPageType="{{$dataManagerPage['type']}}">
        @include('frontend.web.shopPage.shop-manager.shop-business-aside')
        @include('frontend.web.shopPage.shop-manager.shop-order-aside')
        @include('frontend.web.shopPage.shop-manager.shop-product-aside')
        <div class="data-page  manager-page__data-page">


            @include('frontend.web.shopPage.shop-manager.header')


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
        @include('frontend.web.shopPage.shop-manager.shop-cart-footer')
    </div>

@endsection
