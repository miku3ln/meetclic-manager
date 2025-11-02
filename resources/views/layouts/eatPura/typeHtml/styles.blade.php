<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$themePath = $resourcePathServer . 'templates/eatPura/';

?>

    <!-- Favicon -->
@if(isset($dataManagerPage['favicon']))
    {{$dataManagerPage['favicon']}}
@else
    <!--   <link rel="icon" href="{{asset($resourcePathServer.'templates/citybook/assets/img/favicon.ico')}}">-->
@endif

<!-- Bootstrap Css -->
<link href="{{ asset($themePath.'vender/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- Icofont -->
<link href="{{ asset($themePath.'vender/icofont/icofont.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset($themePath.'css/lineicons.css') }}" rel="stylesheet"  rel="stylesheet" />
<!-- SLick Slider Css -->
<link href="{{ asset($themePath.'vender/icofont/icofont.min.css') }}" rel="stylesheet" type="text/css"/>

<!-- SLick Slider Css -->
<link rel="stylesheet" href="{{ URL::asset($themePath.'vender/slick/slick/slick.css')}}">
<link rel="stylesheet" href="{{ URL::asset($themePath.'vender/slick/slick/slick-theme.css')}}">
<!-- Custom Css -->
<link rel="stylesheet" href="{{ URL::asset($themePath.'css/style.css')}}">
<link href="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.css') }}" rel="stylesheet"/>
<style>
    .select2-container-modal {
        z-index: 1500;
    }
</style>
@include('eatPura.web.partials.assets.css-shop-checkout')
<link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
      type="text/css">
@if(isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' )

@endif
@yield('css')




@yield('additional-styles')
