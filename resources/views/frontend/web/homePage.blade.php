{{--  CMS-TEMPLATE --}}
<?php

$managementNameProcess = "homePage";
?>
@extends('layouts.cityBook')
@section('additional-styles')
    @include('frontend.web.'.$managementNameProcess.'.assets.css.index')
    <style>
        /* BEM component – self-contained and Bootstrap 5.0.2 friendly */
        .yapita-task-list {
            max-width: 1100px;
            margin: 0 auto;
        }

        .yapita-task {
            --yt-primary: #4058f4;
            --yt-ink: #14204a;
            --yt-muted: #64708a;
            background: #fff;
            border: 1px solid #e5e9f5;
            border-radius: 18px;
            box-shadow: 0 5px 18px rgba(31, 51, 113, .07);
            padding: 17px;
            margin-bottom: 14px;
            color: var(--yt-ink);
        }

        .yapita-task__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 13px;
        }

        .yapita-task__channel {
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .yapita-task__channel--digital {
            background: #e8f4ff;
            color: #1558b6;
        }

        .yapita-task__channel--physical {
            background: #f0e9ff;
            color: #7041cb;
        }

        .yapita-task__points {
            background: #fff1b8;
            color: #6c4800;
            border: 1px solid #ffe18a;
            border-radius: 100px;
            padding: 7px 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            white-space: nowrap;
        }

        .yapita-task__points strong {
            font-size: 18px;
            line-height: 1;
        }

        .yapita-task__content {
            display: flex;
            gap: 13px;
            align-items: flex-start;
            min-width: 0;
        }

        .yapita-task__media {
            flex: 0 0 100px;
            width: 100px;
            height: 105px;
            border-radius: 13px;
            overflow: hidden;
            background: #f3f5fe;
        }

        .yapita-task__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .yapita-task__information {
            flex: 1;
            min-width: 0;
        }

        .yapita-task__title {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.28;
            color: var(--yt-ink);
            margin: 0 0 9px;
            overflow-wrap: anywhere;
        }

        .yapita-task__business {
            display: flex;
            gap: 7px;
            align-items: flex-start;
            color: #253b70;
            margin-bottom: 7px;
            font-size: 13px;
        }

        .yapita-task__business > span {
            min-width: 0;
        }

        .yapita-task__business strong {
            display: block;
        }

        .yapita-task__business small {
            display: block;
            font-size: 11px;
            color: var(--yt-muted);
        }

        .yapita-task__description {
            font-size: 13px;
            color: #56627e;
            line-height: 1.5;
            margin: 0;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }

        .yapita-task__footer {
            border-top: 1px solid #edf0f7;
            margin-top: 15px;
            padding-top: 12px;
        }

        .yapita-task__meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .yapita-task__frequency {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #697591;
            font-size: 12px;
        }

        .yapita-task__details-toggle {
            background: transparent;
            border: 0;
            color: var(--yt-primary);
            font-weight: 700;
            font-size: 12px;
            padding: 6px 0 6px 8px;
            cursor: pointer;
        }

        .yapita-task__actions {
            display: flex;
            gap: 9px;
        }

        .yapita-task__button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            width: 100%;
            min-height: 46px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
        }

        .yapita-task__button--primary {
            background: var(--yt-primary);
            color: #fff;
        }

        .yapita-task__button--primary:hover {
            background: #2a42de;
            color: #fff;
        }

        .yapita-task__button--secondary {
            background: #ecf0ff;
            color: #2943c7;
        }

        .yapita-task__button--disabled {
            background: #f1f2f6;
            color: #8b92a5;
            cursor: not-allowed;
        }

        .yapita-task__details {
            margin-top: 14px;
            padding: 13px;
            border-radius: 12px;
            background: #f7f8ff;
            border: 1px solid #e9edff;
        }

        .yapita-task__details[hidden] {
            display: none !important;
        }

        .yapita-task__detail-section + .yapita-task__detail-section {
            border-top: 1px solid #e2e7f8;
            padding-top: 12px;
            margin-top: 12px;
        }

        .yapita-task__detail-section h4 {
            color: #25396f;
            font-size: 13px;
            font-weight: 800;
            margin: 0 0 7px;
        }

        .yapita-task__detail-section p, .yapita-task__list {
            font-size: 13px;
            color: #4a5571;
            line-height: 1.55;
            margin: 0;
        }

        .yapita-task__list {
            padding-left: 19px;
        }

        .yapita-task__list li + li {
            margin-top: 5px;
        }

        .yapita-task__details-toggle:focus-visible, .yapita-task__button:focus-visible {
            outline: 3px solid #f6c940;
            outline-offset: 2px;
        }

        .yapita-task-intro {
            border-radius: 18px;
            padding: 18px;
            background: linear-gradient(110deg, #ebf0ff, #fff8dd);
            border: 1px solid #dce5ff;
            margin-bottom: 18px;
        }

        .yapita-task-intro__eyebrow {
            color: #3450c5;
            font-size: 12px;
            font-weight: 800;
            margin: 0 0 5px;
        }

        .yapita-task-intro__title {
            color: #152463;
            font-size: 19px;
            font-weight: 850;
            margin: 0 0 7px;
        }

        .yapita-task-intro__text {
            color: #526080;
            font-size: 13px;
            line-height: 1.55;
            margin: 0 0 10px;
        }

        .yapita-task-intro__steps {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .yapita-task-intro__steps span {
            color: #304dbe;
            background: #fff;
            border: 1px solid #e0e6ff;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 99px;
        }

        @media (max-width: 575.98px) {
            .yapita-task {
                padding: 12px;
                border-radius: 15px;
            }

            .yapita-task__media {
                flex-basis: 78px;
                width: 78px;
                height: 92px;
            }

            .yapita-task__title {
                font-size: 15px;
            }

            .yapita-task__points {
                padding: 6px 9px;
            }

            .yapita-task__points strong {
                font-size: 16px;
            }

            .yapita-task__description {
                -webkit-line-clamp: 2;
            }
        }

        @media (max-width: 340px) {
            .yapita-task__media {
                display: none;
            }

            .yapita-task__points span {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .yapita-task * {
                transition: none !important;
            }
        }

    </style>
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
@endsection
@section('script')

@endsection
@section('additional-scripts')
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

            <div class="col-list-wrap expanded " id="manager-list2">
                <div class="list-main-wrap fl-wrap card-listing">
                    <a class="custom-scroll-link back-to-filters btf-l" href="#lisfw"><i
                            class="fa fa-angle-double-up"></i><span>{{__('frontend.menu.search.filters.button.back')}}</span></a>
                    <div class="container" id="listing-items" v-if="!configGridAdmin.isEmpty"
                    >
                        <div v-for="(rowTask, index) in configGridAdmin.data"
                             :key="rowTask.id + '-' + index"
                             v-html="getRowGameTaskHtml(rowTask)"
                             v-init-listing-items="{initMethod:_managerDataItemsMap}">
                        </div>
                    </div>
                    <div v-if="(configGridAdmin.isEmpty && configGridAdmin.data.length==0) && (!paginationState.loading && !paginationState.hasMore)" class="listing-items__empty">
                        <div v-html="configGridAdmin.msj.empty"></div>
                    </div>
                    <div class="listings-loader"
                         v-if="paginationState.loading && paginationState.hasMore">
                        <i class="fa fa-spinner fa-pulse fa-3x"></i>
                        <div class="loader-text">{{ __("loading_data") }}</div>
                    </div>
                    <div class="end-results"
                         v-if="!paginationState.hasMore && configGridAdmin.data.length > 0">
                        <span>✅ {{ __("gamification.rules") }}.</span>
                    </div>


                </div>
            </div>
        </div>
        <div class="limit-box fl-wrap" id="limit-box-wrap"></div>
    </div>

@endsection
