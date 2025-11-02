<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@extends('layouts.cityBook')

@section('additional-styles')
    <!--CONFIRM-->
    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/jquery-confirm/jquery-confirm.min.css')}}">

    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('additional-scripts')
    <!--CONFIRM-->
    <script src="{{ asset($resourcePathServer . 'plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>

    {{-- BOOTGRID--}}
    @if(!env('allowRoutes'))
        <script src="{{ asset($resourcePathServer.'js/frontend/web/Cart.js')}}"></script>
    @else
        <script src="{{ asset($resourcePathServer.'js/frontend/web/CartEvent.js')}}"></script>

    @endif
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;

    </script>
@endsection
@section('content')
    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">
                            @if(isset($dataManagerPage['header']['title']))
                                {{$dataManagerPage['header']['title']}}
                            @else
                                {{__('frontend.menu.shop-cart')}}
                            @endif

                        </h2>
                        <ul class="breadcrumb-list">
                            {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                            <li class="active">
                                @if(isset($dataManagerPage['header']['breadCrumb']['active']))
                                    {{$dataManagerPage['header']['breadCrumb']['active']}}
                                @else
                                    {{__('frontend.menu.shop-cart')}}
                                @endif

                            </li>
                        </ul>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper">
        <div class="shopping-cart-area">
            <div class="container">
                <div class="row not-view" id="manager-shop-products">
                    <div class="col-lg-12">
                        <!--=======  cart table  =======-->

                        <div class="cart-table-container">
                            <table class="cart-table">
                                <thead>
                                <tr>
                                    <th class="product-name" colspan="2">{{__('shop-cart.product.title')}}</th>
                                    <th class="product-price">{{__('shop-cart.product.price')}}</th>
                                    <th class="product-quantity">{{__('shop-cart.product.quantity')}}</th>
                                    <th class="product-subtotal">{{__('shop-cart.product.sub-total')}}</th>
                                    <th class="product-remove">&nbsp;</th>
                                </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <!--=======  End of cart table  =======-->
                    </div>
                    @if(isset($dataManagerPage['coupon']))
                        <div class="col-lg-12">
                            <!--=======  coupon area  =======-->

                            <div class="cart-coupon-area">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <!--=======  coupon form  =======-->

                                        <div class="coupon-form">
                                            <form action="#">
                                                <div class="row row-5">
                                                    <div class="col-md-7 col-sm-7">
                                                        <input type="text" placeholder="Enter your coupon code">
                                                    </div>
                                                    <div class="col-md-5 col-sm-5">
                                                        <button class="theme-button theme-button--silver">APPLY COUPON
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!--=======  End of coupon form  =======-->
                                    </div>

                                </div>
                            </div>

                            <!--=======  End of coupon area  =======-->
                        </div>
                    @endif

                    <div class="col-lg-6 offset-lg-6">
                        <div class="cart-calculation-area">
                            <form action="{{route('checkout',app()->getLocale())}}">
                                <h2 class="cart-calculation-area__title">{{__('shop-cart.product.total')}}</h2>

                                <table class="cart-calculation-table">
                                    <tr class="not-view tr-tax">
                                        <th>{{__('shop-cart.product.tax')}}</th>
                                        <td class="tax-total">$0</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('shop-cart.product.sub-total-title')}}</th>
                                        <td class="subtotal">$0</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('shop-cart.product.total')}}</th>
                                        <td class="total">$0</td>
                                    </tr>
                                </table>

                                <div class="cart-calculation-button">
                                    <button class="theme-button theme-button--alt theme-button--checkout">
                                        {{__('shop-cart.button')}}
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="empty-data not-view col-md-12" id="empty-products">
                        {{__('shop-cart.empty')}}

                    </div>
                    <div class="empty-data  col-md-12" id="empty-products-loading">
                        {{__('messages.loading')}}

                    </div>
                </div>
            </div>
        </div>
        <!--=======  End of shop page area  =======-->
    </div>

@endsection
