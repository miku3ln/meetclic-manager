<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

<!-- Favicon -->
@if(isset($dataManagerPage['favicon']))
    {{$dataManagerPage['favicon']}}
@else
    <link rel="icon" href="{{asset($resourcePathServer.'frontend/assets/img/favicon.ico')}}">
@endif


<!--=============================================
=            CSS  files       =
=============================================-->

<!-- Vendor CSS -->
<link href="{{ URL::asset($resourcePathServer.'frontend/assets/css/vendors.css')}}" rel="stylesheet">
<!-- Main CSS -->
<link href="{{ URL::asset($resourcePathServer.'frontend/assets/css/style.css')}}" rel="stylesheet">

@if(isset($dataManagerPage['pluginsAllow'])&& isset($dataManagerPage['pluginsAllow']['slider'])&& ($dataManagerPage['pluginsAllow']['slider']['allow']))

    <!-- Revolution Slider CSS -->
    <link href="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/css/settings.css')}}" rel="stylesheet">
    <link href="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/css/navigation.css')}}" rel="stylesheet">
    <link href="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/custom-setting.css')}}" rel="stylesheet">

    <link href="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.css") }}" rel="stylesheet"
          type="text/css"/>


@endif
<link href="{{ asset($resourcePathServer.'css/eccomerce/cart.css') }}" rel="stylesheet" type="text/css"/>

@if(env('allowBusinessOwner'))
    <link href="{{ asset($resourcePathServer.'css/frontend/web/CustomArquitechos.css') }}" rel="stylesheet"
          type="text/css"/>
@endif

@yield('css')
@yield('additional-styles')
<style>
    .scroll-top {

        bottom: 105px !important;
    }

    .jq-toast-wrap {

        z-index: 10000 !important;
    }

</style>
