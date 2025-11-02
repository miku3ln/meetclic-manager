<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$themePath = $resourcePathServer . 'templates/cityBookHtml/';

?>

<!-- Favicon -->
@if(isset($dataManagerPage['favicon']))
    {{$dataManagerPage['favicon']}}
@else
    <link rel="icon" href="{{asset($resourcePathServer.'templates/citybook/assets/img/favicon.ico')}}">
@endif

<!--=============== css  ===============-->
<link href="{{ asset($resourcePathServer.'css/frontend/web/App.css') }}" rel="stylesheet" type="text/css"/>


<link type="text/css" rel="stylesheet" href="{{ URL::asset($themePath.'css/reset.css')}}">
<link type="text/css" rel="stylesheet" href="{{ URL::asset($themePath.'css/plugins.css')}}">

<link type="text/css" rel="stylesheet" href="{{ URL::asset($themePath.'css/color.css')}}">
<link type="text/css" rel="stylesheet" href="{{ URL::asset($themePath.'css/beeDesign.css')}}">

<link href="{{ asset($resourcePathServer.'css/eccomerce/menu.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset($resourcePathServer.'css/eccomerce/cart.css') }}" rel="stylesheet" type="text/css"/>
<!--CART-->
<link href="{{ asset($resourcePathServer.'css/forms.css') }}" rel="stylesheet" type="text/css"/>

<!--=============== favicons ===============-->
<link rel="shortcut icon" href="{{ URL::asset($themePath.'images/favicon.ico')}}">


<link href="{{ URL::asset($resourcePathServer.'css/shop.css') }}" rel="stylesheet"
      type="text/css">




@if(isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' )

@endif
@yield('css')


<link type="text/css" rel="stylesheet" href="{{ URL::asset($themePath.'css/style.css')}}">
<link href="{{ asset($resourcePathServer.'css/frontend/web/Chaskishimi.css') }}" rel="stylesheet" type="text/css"/>
@yield('additional-styles')
