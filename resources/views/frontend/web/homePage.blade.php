{{--  CMS-TEMPLATE --}}
<?php

$managementNameProcess = "homePage";
?>
@extends('layouts.cityBook')
@section('additional-styles')
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

            // initModePosition();
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
            <div class="filters-drawer__header" >
                <h4 class="filters-drawer__title">Filtros</h4>
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
                            <li  id="view-list"><a class="list " href="#"><i class="fa fa-list-ul"></i></a></li>
                            <li  id="view-2"><a href="#" class="expand-listing-view active"><i class="fa fa-expand"></i></a></li>
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
                        <!-- ✅ LOADER PARA INFINITE SCROLL -->
                        <div class="listings-loader"
                             v-if="paginationState.loading && paginationState.hasMore">
                            <i class="fa fa-spinner fa-pulse fa-3x"></i>
                            <div class="loader-text">Cargando más resultados...</div>
                        </div>

                        <!-- ✅ MENSAJE FIN -->
                        <div class="end-results"
                             v-if="!paginationState.hasMore && configGridAdmin.data.length > 0">
                            <span>✅ Ya no hay más resultados.</span>
                        </div>
                    </div>
                    <!-- ✅ EMPTY -->
                    <div class="class"
                         v-if="!managerLoading.data.view && configGridAdmin.isEmpty"
                         v-html="configGridAdmin.msj.empty">
                    </div>

                </div>
            </div>
        </div>
        <div class="limit-box fl-wrap" id="limit-box-wrap"></div>
    </div>

@endsection
