<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@extends('layouts.cityBook')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/eccomerce/vendor.css')}}">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    <!--CONFIRM-->
    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/jquery-confirm/jquery-confirm.min.css')}}">

@endsection

@section('additional-scripts')
    <!--CONFIRM-->
    <script src="{{ asset($resourcePathServer . 'plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>

    {{-- BOOTGRID--}}
    <script src="{{ asset($resourcePathServer.'js/frontend/web/checkoutDetails.js')}}"></script>
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
        @if(isset($dataManagerPage['checkoutDetails']))
            {!! $dataManagerPage['checkoutDetails'] !!}
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

@endsection
