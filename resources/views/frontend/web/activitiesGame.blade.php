<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('additional-scripts')
    <!-- Map JS -->
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;

    </script>

@endsection
@section('content')

    @include('layouts.frontend.slider',array('dataSliderHtml'=>$dataSliderHtml,'typeSliderManager'=>'index-6'))


    @if(isset($dataManagerPage['dataSliderHorizontal']['main']))
        <div class="brand-logo-slider-area">
            <div class="container wide">
                <div class="row">
                    <div class="col-lg-12">
                        {!! $dataManagerPage['dataSliderHorizontal']['main'] !!}
                    </div>
                </div>
            </div>
        </div>

    @endif

    @if(isset($dataManagerPage['banner-two-column']['main']))
        <div class="banner-area section-space">
            <div class="container wide">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="banner-two-column-wrapper">
                            <div class="row">
                                <div class="col-lg-12">
                                    {!! $dataManagerPage['banner-two-column']['main']!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif

@endsection
