<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@extends('layouts.cityBook')

@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/eccomerce/product.css')}}">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/eccomerce/vendor.css')}}">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'plugins/jquery-confirm/jquery-confirm.min.css')}}">
    <!--CONFIRM-->
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
    @include('partials.plugins.resourcesCss',['toast'=>true])
    <style>

        .lg-actions .lg-next:before {
            margin-top: -17%;
            position: absolute;
            margin-left: 16%;
        }
    </style>
@endsection

@section('additional-scripts')
    <!--CONFIRM-->
    <script src="{{ asset($resourcePathServer . 'plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>

    <script>
        function initSlick(){
            var $window = $(window),
                $html = $('html'),
                $body = $('body'),
                $headerSticky = $('.header-sticky');
            var $themeSlickSlider = $('.theme-slick-slider');

            /*For RTL*/
            if ($html.attr("dir") == "rtl" || $body.attr("dir") == "rtl") {
                $themeSlickSlider.attr("dir", "rtl");
            }

            $themeSlickSlider.each(function () {

                /*Setting Variables*/
                var $this = $(this),
                    $setting = $this.data('slick-setting'),
                    $autoPlay = $setting.autoplay ? $setting.autoplay : false,
                    $autoPlaySpeed = parseInt($setting.autoplaySpeed, 10) || 2000,
                    $speed = parseInt($setting.speed, 10) || 2000,
                    $asNavFor = $setting.asNavFor ? $setting.asNavFor : null,
                    $appendArrows = $setting.appendArrows ? $setting.appendArrows : $this,
                    $appendDots = $setting.appendDots ? $setting.appendDots : $this,
                    $arrows = $setting.arrows ? $setting.arrows : false,
                    $prevArrow = $setting.prevArrow ? '<button class="' + $setting.prevArrow.buttonClass + '"><i class="' + $setting.prevArrow.iconClass + '"></i></button>' : '<button class="slick-prev">previous</button>',
                    $nextArrow = $setting.nextArrow ? '<button class="' + $setting.nextArrow.buttonClass + '"><i class="' + $setting.nextArrow.iconClass + '"></i></button>' : '<button class="slick-next">next</button>',
                    $centerMode = $setting.centerMode ? $setting.centerMode : false,
                    $centerPadding = $setting.centerPadding ? $setting.centerPadding : '50px',
                    $dots = $setting.dots ? $setting.dots : false,
                    $fade = $setting.fade ? $setting.fade : false,
                    $focusOnSelect = $setting.focusOnSelect ? $setting.focusOnSelect : false,
                    $infinite = $setting.infinite ? $setting.infinite : true,
                    $pauseOnHover = $setting.pauseOnHover ? $setting.pauseOnHover : true,
                    $rows = parseInt($setting.rows, 10) || 1,
                    $slidesToShow = parseInt($setting.slidesToShow, 10) || 1,
                    $slidesToScroll = parseInt($setting.slidesToScroll, 10) || 1,
                    $swipe = $setting.swipe ? $setting.swipe : true,
                    $swipeToSlide = $setting.swipeToSlide ? $setting.swipeToSlide : false,
                    $variableWidth = $setting.variableWidth ? $setting.variableWidth : false,
                    $vertical = $setting.vertical ? $setting.vertical : false,
                    $verticalSwiping = $setting.verticalSwiping ? $setting.verticalSwiping : false,
                    $rtl = $setting.rtl || $html.attr('dir="rtl"') || $body.attr('dir="rtl"') ? true : false;

                /*Responsive Variable, Array & Loops*/
                var $responsiveSetting = typeof $this.data('slick-responsive') !== 'undefined' ? $this.data('slick-responsive') : '',
                    $responsiveSettingLength = $responsiveSetting.length,
                    $responsiveArray = [];
                for (var i = 0; i < $responsiveSettingLength; i++) {
                    $responsiveArray[i] = $responsiveSetting[i];

                }

                /*Slider Start*/
                $this.slick({
                    autoplay: $autoPlay,
                    autoplaySpeed: $autoPlaySpeed,
                    speed: $speed,
                    asNavFor: $asNavFor,
                    appendArrows: $appendArrows,
                    appendDots: $appendDots,
                    arrows: $arrows,
                    dots: $dots,
                    centerMode: $centerMode,
                    centerPadding: $centerPadding,
                    fade: $fade,
                    focusOnSelect: $focusOnSelect,
                    infinite: $infinite,
                    pauseOnHover: $pauseOnHover,
                    rows: $rows,
                    slidesToShow: $slidesToShow,
                    slidesToScroll: $slidesToScroll,
                    swipe: $swipe,
                    swipeToSlide: $swipeToSlide,
                    variableWidth: $variableWidth,
                    vertical: $vertical,
                    verticalSwiping: $verticalSwiping,
                    rtl: $rtl,
                    prevArrow: $prevArrow,
                    nextArrow: $nextArrow,
                    responsive: $responsiveArray
                });

            });

        }
        function zoomInit() {
            /*=============================================
           =            zoom and light gallery active            =
           =============================================*/

            $('.product-details-big-image-slider-wrapper .single-image').zoom();

            //lightgallery
            var productThumb = $(".product-details-big-image-slider-wrapper .single-image img"),
                imageSrcLength = productThumb.length,
                images = [];
            for (var i = 0; i < imageSrcLength; i++) {
                images[i] = {"src": productThumb[i].src};
            }

            $('.btn-zoom-popup').on('click', function () {
                $(this).lightGallery({
                    thumbnail: false,
                    dynamic: true,
                    autoplayControls: false,
                    download: false,
                    actualSize: false,
                    share: false,
                    hash: false,
                    index: 0,
                    dynamicEl: images
                });
            });

            /*=====  End of zoom active  ======*/
        }
    </script>
    <script src="{{ asset($resourcePathServer.'plugins/zoom/jquery.zoom.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'plugins/slick/slick.js')}}"></script>
    <script src="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.js") }}"></script>
    <script src="{{ URL::asset($resourcePathServer . 'assets/js/pages/toastr.init.js') }}"></script>

    {{-- BOOTGRID--}}
    <script>
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
        var $productDetails = {};
            @if(isset($dataManagerPage['productDetails']))
        var $productDetails = <?php
            $dataManagerPage['productData']['url']=route('productDetails', app()->getLocale()) . "/" . $dataManagerPage['productData']['product']->id;
            echo json_encode($dataManagerPage['productData'])?>;
            @else
        var $productDetails = {};
        @endif
    </script>
    <script src="{{ asset($resourcePathServer.'js/frontend/web/ProductDetails.js')}}"></script>
    <script>

    </script>
@endsection
@section('content')
    <div id="app-management">
        <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <!--=======  breadcrumb wrapper  =======-->

                        <div class="breadcrumb-wrapper">
                            <h2 class="page-title">
                                @if(isset( $dataManagerPage['header']['title']))
                                    {{ $dataManagerPage['header']['title']}}

                                @endif
                            </h2>
                            <ul class="breadcrumb-list">
                                {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}

                                <li class="active">
                                    @if(isset( $dataManagerPage['header']['breadCrumb']['active']))
                                        {{$dataManagerPage['header']['breadCrumb']['active']}}

                                    @endif
                                </li>
                            </ul>
                        </div>

                        <!--=======  End of breadcrumb wrapper  =======-->
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content-wrapper">
            <!--=======  shop page area  =======-->
            @if(isset($dataManagerPage['productDetails']))
                {{$dataManagerPage['productDetails']}}

            @else
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="empty-data warning">
                                <h1><span>  {{__('messages.errors.warning')}}</span> {{__('messages.not-manager')}}</h1>
                            </div>
                        </div>
                    </div>

                </div>

        @endif
        <!--=======  End of shop page area  =======-->
        </div>
    </div>
@endsection
