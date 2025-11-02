<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    @include('partials.plugins.resourcesCss',['toast'=>true])

@endsection

@section('additional-scripts')
    {{-- BOOTGRID--}}
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;


        var $productDetails = {};
            @if(isset($dataManagerPage['productDetails']))

        var $productDetails = <?php
            $dataManagerPage['productData']['url']=route('productDetails', app()->getLocale()) . "/" . $dataManagerPage['productData']['product']->id;
            echo json_encode($dataManagerPage['productData'])?>;
            @else
        var $productDetails = {};
        @endif
    </script>
    <script src="{{ asset($resourcePathServer.'js/frontend/web/ProductDetails.js')}}"></script>
    <script>

    </script>
@endsection
@section('content')
    <div id="app-management">


        <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <!--=======  breadcrumb wrapper  =======-->

                        <div class="breadcrumb-wrapper">
                            <h2 class="page-title">
                                @if(isset( $dataManagerPage['header']['title']))
                                    {{ $dataManagerPage['header']['title']}}

                                @endif
                            </h2>
                            <ul class="breadcrumb-list">
                                {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                                <li class="active">
                                    @if(isset( $dataManagerPage['header']['breadCrumb']['active']))
                                        {{$dataManagerPage['header']['breadCrumb']['active']}}

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
            <!--=======  shop page area  =======-->
            @if(isset($dataManagerPage['productDetails']))
                {{$dataManagerPage['productDetails']}}

            @else
                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="empty-data warning">
                                <h1><span>  {{__('messages.errors.warning')}}</span> {{__('messages.not-manager')}}</h1>
                            </div>
                        </div>
                    </div>

                </div>

        @endif
        <!--=======  End of shop page area  =======-->
        </div>
    </div>
@endsection
