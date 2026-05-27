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

            .content-manager-grid {
                margin-top: 12%;
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

        .listsearch__subheader {
            display: none !important;
        }
    </style>

    <style id="business-information">

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
@endsection
@section('script')

@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>
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
                <div class="row" id="business-information">
                    <div class="col-md-12">
                        <div class="business-card">

                            <div class="row g-4 align-items-stretch">

                                <!-- ROW 1 - COL 1 -->
                                <div class="col-xl-4">

                                    <div class="business-profile h-100">

                                        <div class="d-flex gap-4 align-items-start">

                                            <img

                                                v-bind:src="businessInformation.information.source"
                                                alt=""
                                                class="business-logo">

                                            <div class="flex-grow-1">
                                                <div class="business-title">

                                                    <a v-bind:href="businessInformation.information.url"> <?php echo "{{businessInformation.information.title}}" ?></a>
                                                </div>

                                                <div class="business-category mb-3">
                                                    <?php echo "{{businessInformation.subcategory.title}}" ?>
                                                </div>
                                                <div v-html="generateStars(businessInformation.starManagement)"></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- ROW 1 - COL 2 -->
                                <div class="col-xl-6">

                                    <div class="stats-wrapper h-100">

                                        <div class="row g-3 h-100">
                                            @foreach($currentCounter['items'] as $item)
                                                <div class="col-md-4">

                                                    <div class="stat-card">

                                                        <div class="stat-icon bg-primary-soft">
                                                            <i class="{{$item['icon']}}"></i>
                                                        </div>

                                                        <div class="stat-number">
                                                            {{$item['number']}}
                                                        </div>

                                                        <div class="stat-title">
                                                            {{$item['label']}}
                                                        </div>

                                                    </div>

                                                </div>
                                            @endforeach


                                        </div>

                                    </div>

                                </div>

                                <!-- ROW 1 - COL 3 -->
                                <div class="col-xl-2 not-view">

                                    <div class="yapitas-card h-100">

                                        <div class="yapitas-icon">
                                            <i class="bi bi-coin"></i>
                                        </div>

                                        <div class="yapitas-value">
                                            1,250
                                        </div>

                                        <div class="yapitas-label">
                                            Yapitas disponibles
                                        </div>

                                        <a href="#"
                                           class="btn-yapitas">
                                            Ver Yapitas
                                        </a>

                                    </div>

                                </div>

                            </div>

                            <!-- ROW 2 -->
                            <div class="row g-3 mt-4" id="manager-process-business-gamification">

                                <div class="col-md-3" v-for="(row, key) in businessInformation.linksManagement"
                                     v-on:click="onProcessBusiness(row)">
                                    <div class="manager-process-business-gamification__icon-go"><i
                                            class="bi bi-chevron-down "></i>
                                    </div>
                                    <div class="manager-process-business-gamification__card" v-bind:link="row.link">

                                        <div class="manager-process-business-gamification__icon">
                                            <i v-bind:class="row.icon"></i>
                                        </div>

                                        <div class="manager-process-business-gamification__content">
                                            <div class="manager-process-business-gamification__title">
                                                <?php echo "{{row.title}}" ?>
                                            </div>

                                            <div class="manager-process-business-gamification__description">
                                                <?php echo "{{row.description}}" ?>

                                                <ul class="manager-process-business-gamification__checklist list-unstyled mb-0">

                                                    <li class="manager-process-business-gamification__check-item d-flex align-items-center mb-2"
                                                        v-for="(option, keyOption) in row.options">
                                                        <div class="manager-process-business-gamification__check-icon">
                                                            <i class="bi bi-check"></i>
                                                        </div>

                                                        <span class="manager-process-business-gamification__check-text">
         <?php echo "{{option}}" ?>
        </span>
                                                    </li>


                                                </ul>
                                            </div>
                                            <div class="manager-process-business-gamification__actions">
                                                <button class="manager-process-business-gamification__button">
                                                    Agregar
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>
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
