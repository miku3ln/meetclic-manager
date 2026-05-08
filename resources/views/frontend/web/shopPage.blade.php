{{--  CMS-TEMPLATE --}}
<?php

$managementNameProcess = "shopPage";
?>
@extends('layouts.cityBook')
@section('additional-styles')
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
            border-bottom: 1px solid var(--mc-border);
        }

        /* zonas */
        .mc-grid__left,
        .mc-grid__center,
        .mc-grid__right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mc-grid__search-wrapper {
            width: 100%;
            max-width: 320px;
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
            position: fixed;
            z-index: 15;
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
        }

        .product-card__image {

            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
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
                margin-top: 18%;
            }
        }

        /* =========================================================
           SMALL TABLET
        ========================================================= */

        @media (max-width: 992px) {

            .xywer-tbl-admin tbody {

                grid-template-columns:
            repeat(2, minmax(0, 1fr));
            }

            .product-card__media {

                height: 220px;
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

        }

    </style>
@endsection
@section('script')

@endsection
@section('additional-scripts')
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
