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
<?php
    $urlManager=route('business', app()->getLocale());
    ?>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body
    class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-6"
         style="background-image: url({{URL::asset('images/error/bg6.jpg')}});">
        <div class="m-error_container">
            <div class="m-error_subtitle m--font-light">
                <h1 style="margin-bottom: 0px;">404</h1>
                <a href="{{$urlManager}}">Regresar</a>

                @if(isset($msg))
                    <h2>{!! ($msg) !!}</h2>
                @else
                    <h2>Página no encontrada.</h2>

                @endif
            </div>
        </div>
    </div>
</div>
</body>

</html>
