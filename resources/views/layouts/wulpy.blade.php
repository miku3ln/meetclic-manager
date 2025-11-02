<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>
    @include('layouts.partials.wulpy.styles')
</head>
<style>
    .content__image-business img {
        width: 100%;
    }
    .content__image-business {
        width: 9%;
        position: fixed;
        top: 2%;
        left: 2%;
    }
</style>
<!--
    AVAILABLE BODY CLASSES:

    smoothscroll 			= create a browser smooth scroll
    enable-animation		= enable WOW animations

    bg-grey					= grey background
    grain-grey				= grey grain background
    grain-blue				= blue grain background
    grain-green				= green grain background
    grain-blue				= blue grain background
    grain-orange			= orange grain background
    grain-yellow			= yellow grain background

    boxed 					= boxed layout
    pattern1 ... patern11	= pattern background
    menu-vertical-hide		= hidden, open on click

    BACKGROUND IMAGE [together with .boxed class]
    data-background="assets/images/boxed_background/1.jpg"
-->
<body class="smoothscroll enable-animation">

<!-- SLIDE TOP -->
<div id="slidetop">

    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <h6><i class="icon-heart"></i> <?php echo "{{why.title}}" ?></h6>
                <p> <?php echo "{{why.content}}" ?></p>
            </div>


            <div class="col-md-6">
                <div v-html="contactHtml">

                </div>

            </div>

        </div>

    </div>

    <a class="slidetop-toggle" href="#"><!-- toggle button --></a>

</div>
<!-- /SLIDE TOP -->


<!-- wrapper -->
<div id="wrapper">


    @yield('subheader')
    <div class="content-manager-layer" id="app">

        @yield('content')

    </div>
    <!-- /WELCOME -->


    <!-- /FOOTER -->

</div>
<div class="content__image-business">

    <img alt="" src="https://www.meistertask.com/embed/at/8558696/large/94ee8830399669e47fd0ae6438e36870adb3c550.png">
</div>
<!-- SCROLL TO TOP -->
<a href="#" id="toTop"></a>

<!-- PRELOADER -->
<div id="preloader">
    <div class="inner">
        <span class="loader"></span>
    </div>
</div><!-- /PRELOADER -->

@include('layouts.partials.wulpy.scripts')
@yield('additional-scripts')
<div class="management-apis wulpy">
    <div class="google-api"
         source="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}">

    </div>
    <div class="google-api-markers"
         source="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">

    </div>
</div>
</body>
</html>
