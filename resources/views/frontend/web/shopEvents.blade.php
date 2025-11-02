<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>


@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    {{-----BOOTGRID PLUGIN--}}
    <link href="{{ asset($resourcePathServer."libs/bootgrid1.3.1/bootgrid1.3.1.min.css") }}" rel="stylesheet"
          type="text/css">

    <link href="{{ asset($resourcePathServer."frontend/assets/css/grid-manager.css") }}" rel="stylesheet"
          type="text/css">
    @include('partials.plugins.resourcesCss',['toast'=>true])
    <style>
        .li-category i {
            display: none !important;
        }
    </style>
    <link href="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset($resourcePathServer.'css/frontend/web/ManagementFormEvent.css')}}">
@endsection
@section('script-bootgrid-init')
    <script src="{{ URL::asset($resourcePathServer.'frontend/assets/libs/poper/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{ URL::asset($resourcePathServer.'frontend/assets/libs/poper/popper.min.js')}}"></script>

@endsection

@php
    $allowShop=0;

        if($dataManagerPage['shopConfig']['allow']){
         $allowShop=1;
      }
@endphp
@section('additional-scripts')
    {{-- BOOTGRID--}}
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
        var $allowShop = '{{$allowShop}}';
        var $dataManagerPageShopConfig = <?php echo json_encode($dataManagerPage['shopConfig'])?>;
        var $paramsRequest = <?php echo json_encode(isset($paramsRequest) ? $paramsRequest : [])?>;
    </script>
    <script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>




    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>

    <script src="{{ asset($resourcePathServer.'js/frontend/web/ManagementFormEvent.js') }}"
            type="text/javascript"></script>
    @include('layouts.partials.managementFormEvent',array())
    <script src="{{ asset($resourcePathServer.'js/frontend/web/ShopEvents.js')}}"></script>

@endsection
@section('content')

    <input id="action-users-listAllRoutes" type="hidden"
           value="{{route('listUsersRoutes',app()->getLocale())}}"/>
    <div id="management-take-part">
        <div v-if="configModalManagementFormEvent.viewAllow">

            <management-form-event-component
                ref="refManagementFormEvent"
                :params="configModalManagementFormEvent"

            ></management-form-event-component>
        </div>
    </div>

    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">{{$dataManagerPage['header']['title'] }}</h2>
                        <ul class="breadcrumb-list">
                            {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                            <li class="active"> {{$dataManagerPage['header']['breadCrumb']['active']}}</li>
                        </ul>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>
    <div class="page-content-wrapper">
        <!--=======  shop page area  =======-->

        <div class="shop-page-area">
            <div class="container">
                <div class="row " id="init-loading">
                    <div class="loading-data" id="loading-data">
                        {{__('messages.loading')}}
                    </div>
                </div>
                <div class="row not-view" id="row-products">
                    @if($dataManagerPage['allowViewProducts'])
                        <div class="col-md-3">
                            <!--=======  shop sidebar wrapper  =======-->

                            <div class="shop-sidebar-wrapper">

                                <!--=======  single sidebar widget  =======-->
                                @if(isset($dataManagerPage['allowFiltersByPrice']) && $dataManagerPage['allowFiltersByPrice'])
                                    <div class="single-sidebar-widget">
                                        <h2 class="single-sidebar-widget__title">Filtrar por precio</h2>
                                        <div class="sidebar-price">
                                            <div id="price-range"></div>
                                            <div class="output-wrapper">
                                                <input type="text" id="price-amount" class="price-amount" readonly>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                            <!--=======  End of single sidebar widget  =======-->

                                <!--=======  single sidebar widget  =======-->

                                <div class="single-sidebar-widget">

                                    {{$dataManagerPage['categoriesShop'] }}
                                </div>

                                <!--=======  End of single sidebar widget  =======-->
                            </div>

                            <!--=======  End of shop sidebar wrapper  =======-->
                        </div>

                        <div class="col-md-9">
                            <!--=======  shop content wrapper  =======-->
                            <div class="shop-content-wrapper-loading">
                                {{__('messages.loading')}}
                            </div>
                            <div class="shop-content-wrapper" style="display: none">

                                <!--=======  shop header wrapper  =======-->

                                <div class="shop-header">
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 col-12">
                                            <!--=======  header left content  =======-->

                                            <div class="shop-header__left not-view">
                                                <p class="result-text d-inline-block mb-0">Showing 1–9 of 50 results</p>
                                                <div class="view-mode-icons d-inline-block">
                                                    <a
                                                        id="view-grid"
                                                        href="javascript:void(0)" class="active" data-tippy="Grid"
                                                        data-target="grid" data-tippy-inertia="true"
                                                        data-tippy-animation="shift-away" data-tippy-delay="50"
                                                        data-tippy-arrow="true" data-tippy-theme="sharpborder"><i
                                                            class="fa fa-th"></i></a>
                                                    <a
                                                        id="view-list"
                                                        href="javascript:void(0)" data-target="list" data-tippy="List"
                                                        data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                        data-tippy-delay="50" data-tippy-arrow="true"
                                                        data-tippy-theme="sharpborder"><i class="fa fa-list"></i></a>
                                                </div>
                                            </div>

                                            <!--=======  End of header left content  =======-->
                                        </div>

                                        <div class="col-sm-6 col-12">

                                            <!--=======  header right content  =======-->

                                            <div
                                                class="shop-header__right d-flex justify-content-start justify-content-sm-end align-items-center">
                                                <div class="grid-view-changer" id="grid-view-changer">
                                                    <a href="javascript:void(0)" id="grid-view-change-trigger"
                                                       data-tippy="View Options" data-target="grid"
                                                       data-tippy-inertia="true" data-tippy-animation="shift-away"
                                                       data-tippy-delay="50" data-tippy-arrow="true"
                                                       data-tippy-theme="sharpborder">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <div class="grid-view-changer__menu" id="grid-view-changer__menu">
                                                        <a href="javascript:void(0)" data-target="two-column">2</a>
                                                        <a href="javascript:void(0)" data-target="three-column">3</a>
                                                        <a href="javascript:void(0)" data-target="four-column">4</a>
                                                        <a href="javascript:void(0)" id="grid-view-close-trigger"><i
                                                                class="fa fa-angle-right"></i></a>
                                                    </div>
                                                </div>
                                                <div class="sort-by-dropdown">
                                                    <select name="sort-by" id="sort-by" class="nice-select">
                                                        <option value="0" id="nameSort"
                                                                order="asc">{{__('shop.filters.field-1')}}</option>
                                                        <option value="1" id="codeSort"
                                                                order="asc">{{__('shop.filters.field-2')}}</option>
                                                        <option value="2" id="categorySort"
                                                                order="asc">{{__('shop.filters.field-3')}}
                                                        </option>


                                                    </select>
                                                </div>
                                            </div>

                                            <!--=======  End of header right content  =======-->

                                        </div>
                                    </div>
                                </div>

                                <!--=======  End of shop header wrapper  =======-->

                                <!--=======  shop product wrapper  =======-->

                                <div class="shop-product-wrap shop-product-wrap--with-sidebar row grid">
                                    <div class="col-lg-12 col-md-12 not-view" id="content-products">
                                        <div class=" custom-scroll-admin-grid table-responsive">
                                            <input type="hidden" id="category" value="">
                                            <input type="hidden" id="subcategory" value="">

                                            <table id="product-grid"


                                            >
                                                <thead>
                                                <tr>
                                                    <th data-visible="false" data-column-id="id" data-identifier="true">
                                                        {{__('shop.grid.field-1')}}
                                                    </th>
                                                    <th data-column-id="description" data-formatter="description">
                                                        {{__('shop.grid.field-2')}}
                                                    </th>

                                                </tr>
                                                </thead>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                            </div>

                            <!--=======  End of shop content wrapper  =======-->
                        </div>
                    @else
                        <div class="col-md-12">
                            <h1> {{__('messages.not-manager')}}</h1>
                        </div>
                    @endif

                </div>
            </div>
        </div>


    </div>

@endsection
