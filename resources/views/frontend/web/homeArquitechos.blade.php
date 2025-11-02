<?php
$resourcePathServer = env('APP_IS_SERVER') ? 'public/' : ''; ?>
@extends('layouts.frontend')
@section('additional-styles')
    <link rel="stylesheet" href="{{ asset($resourcePathServer . 'frontend/assets/css/web/Customers.css') }}">
@endsection
@section('additional-scripts')
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage[
            'currentPage'] : 'not-defined'); ?>;    var $dataManagerPage = <?php echo json_encode($dataOutlet); ?>;    $(function() {
                initSlickManager({'element':'.product-outlet-slider-wrapper'});
                initSlickManager({'element':'.product-balances-slider-wrapper'});


            _initOutletsSlider();
        });

    </script>
@endsection
@section('content')

    @include('layouts.frontend.slider',array('dataSliderHtml'=>$dataSliderHtml))

    @include('frontend.web.partials.outletCarousel')
    @include('frontend.web.partials.balancesCarousel')


@endsection
