<!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>
        {{env('APP_NAME')}}
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<?php
$urlManager=route('business', app()->getLocale());
?>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-6"
         style="background-image: url({{asset('metronic/app/media/img/error/bg6.jpg')}});">
        <div class="m-error_container">
            <div class="m-error_subtitle m--font-light">
                <h1 style="margin-bottom: 0px;">401</h1>
                <h2>Acceso no autorizado.</h2>
                <a href="{{$urlManager}}">Regresar</a>
                <h1 style="margin-bottom: 0px;">{{__("frontend.menu.home.join.button")}}</h1>
                <a href="{{route('login', app()->getLocale())}}">{{__("frontend.menu.home.join.button")}}</a>
            </div>

        </div>
    </div>
</div>

</body>
<!-- end::Body -->
</html>
