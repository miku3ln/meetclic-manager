<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';

?>

<head>


    <meta charset="utf-8" />
    <title> {{env('APP_NAME_TITLE_SYSTEM')}} </title>

    <meta property="og:url"                content="http://wulpy.xywer.xyz/chaski" />
    <meta property="og:type"               content="noticias" />
    <meta property="og:title"              content="Ckakiñanes & Destinos" />
    <meta property="og:description"        content="Busca ,Encuentra y Sigue tu chakiñan.!" />
    <meta property="og:image"              content="{{ asset('logo.png')}}" />

    <meta name="keywords" content="ROUTES AND ATTRACTIONS" />
    <meta name="description" content="ROUTES AND ATTRACTIONS" />
    <meta name="Author" content="Migu3ln [https://www.facebook.com/miGu3ln]" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- WEB FONTS : use %7C instead of | (pipe) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />
    <!-- Add Bootstrap and Bootstrap-Vue CSS to the <head> section -->
    <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.css')}}"/>
    {{--BOOTGRID--}}
    <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.css')}}"/>
    <!-- CORE CSS -->
    <link href="{{ asset($resourcePathServer.'wulpy/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset($resourcePathServer.'wulpy/assets/css/essentials.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset($resourcePathServer.'wulpy/assets/css/layout.css')}}" rel="stylesheet" type="text/css" />

    <!-- PAGE LEVEL SCRIPTS -->
    <link href="{{ asset($resourcePathServer.'wulpy/assets/css/header-1.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset($resourcePathServer.'css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset($resourcePathServer.'wulpy/css/custom-page.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Base Styles -->
    @yield('additional-styles')
</head>
