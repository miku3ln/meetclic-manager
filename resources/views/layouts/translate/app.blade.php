<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>


    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ URL::asset($resourcePathServer.'frontend/assets/js/vendors.js')}}"></script>
    <script src="{{ URL::asset($resourcePathServer.'assets/js/vendor/frontend.min.js') }}"></script>
    <script src="{{ URL::asset($resourcePathServer.'js/compiled/AppInit.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset($resourcePathServer.'css/app.css') }}" rel="stylesheet">
    @yield('stylesViews')

</head>
<body>
<div id="app">
    <div class="container">


        @yield('content')

    </div>
</div>
@yield('scriptsViews')

</body>
</html>
