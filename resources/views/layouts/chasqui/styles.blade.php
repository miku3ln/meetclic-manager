

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
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


<!-- Revolution Slider CSS -->
<link href="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/css/settings.css')}}" rel="stylesheet">
<link href="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/css/navigation.css')}}" rel="stylesheet">
<link href="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/custom-setting.css')}}" rel="stylesheet">

<link href="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.css") }}" rel="stylesheet" type="text/css"/>


@yield('css')
@yield('additional-styles')
<style>
    .scroll-top {

        bottom: 105px !important;
    }
</style>
