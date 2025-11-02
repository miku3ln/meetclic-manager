

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>


@extends('layouts.frontend')
@section('additional-styles')
    <link   rel="stylesheet"  href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('additional-scripts')
    <!-- Map JS -->
    <script>

    </script>

@endsection
@section('content')


    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->
                    <div class="breadcrumb-wrapper">
                        @if($pageSectionsConfig['policies']['view'])
                            <h2 class="page-title">{{$pageSectionsConfig['policies']['data']->value}}</h2>
                        @else
                            <h2 class="page-title">{{$dataManagerPage['header']['title']}}</h2>
                        @endif
                        <ul class="breadcrumb-list">
                            {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}
                            <li class="active">{{$dataManagerPage['header']['breadCrumb']['active']}}</li>
                        </ul>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

    <!--====================  End of breadcrumb area  ====================-->

    <!--====================  page content wrapper ====================-->

    <div class="page-content-wrapper">


        <div class="service-text-area section-space">
            <div class="container">
                <!--=======  about us brief wrapper  =======-->
                @if($pageSectionsConfig['policies']['view'])
                    <div class="row">
                        <div class="col-lg-12">


                            <div class="section-description-area">
                                <div class="section-description">{!!$pageSectionsConfig['policies']['data']->description!!}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="manager-empty"> {{__('messages.not-manager')}}</div>
                @endif

            </div>
        </div>
    </div>

@endsection
