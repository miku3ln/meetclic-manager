<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>



<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/fonts/stylesheet.e9dc714d.css" />
<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/css/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/css/aos.css" />
<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/css/jquery.mCustomScrollbar.css" />
<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/css/style.default.db81a5a2.css" id="theme-stylesheet" />
<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/css/custom.0a822280.css" />

@if(isset($dataManagerPage['favicon']))
    {{$dataManagerPage['favicon']}}
@else
    <link rel="icon" href="{{asset($resourcePathServer.$resourcesTemplateInit.'favicon.png')}}">
@endif
<link rel="stylesheet" href="{{asset($resourcePathServer.$resourcesTemplateInit)}}/css/all.css" />
