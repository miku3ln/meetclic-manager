<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>
<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html> <!--<![endif]-->
<head>
    <?php

    $managerView=[
        'url'=>[
            'home'=>route('urlBase')
        ]

    ];
    ?>
    @include('layouts.partials.wulpyView.styles')

    <script type="text/javascript">

        var $managerView = <?php echo json_encode($managerView)?>;


    </script>
</head>

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
<div class="content__image-business" id="manager-content">
    <a v-bind:href="managerUrlMain">
        <img v-bind:src="logoMain">
    </a>
</div>
<!-- SCROLL TO TOP -->
<a href="#" id="toTop"></a>

<!-- PRELOADER -->
<div id="preloader">
    <div class="inner">
        <span class="loader"></span>
    </div>
</div><!-- /PRELOADER -->

@include('layouts.partials.wulpyView.scripts')
@yield('script')

</body>
</html>
