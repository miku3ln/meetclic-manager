@extends('layouts.cityBook')
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
    <style>
        .gallery-item, .grid-sizer {
            width: 100% !important;
        }

        .col-md-3--gallery {
            padding-left: 0%;
            padding-right: 0%;
        }

        .grid-small-pad .grid-item-holder {
            padding: 10px 2px 10px 0 !important;
        }

        .list-single-gallery .box-item {
            border-radius: 0px !important;
        }

        .list-single-main-media {

            margin-bottom: 0px !important;
        }

        section#carousel-manager-one {
            padding: 0px 0 !important;
        / / padding-left: 20 % !important;
        / / padding-right: 20 % !important;
        }

        .slick-list.draggable {

        }

        .carousel-product {
            padding: 0px 0 !important;

        }

        .img-manager-home-products {
            width: 490px !important;
            height: 492px !important;
        }

        section#carousel-manager-two {
            padding: 0px 0 !important;
            padding-left: 20% !important;
            padding-right: 20% !important;
        }
        .md-view-carousel {
            padding-left: 12%;
            padding-right: 12%;
        }
        .sw-btn.swiper-button-next {
            right: 0px !important;
        }
        .sw-btn.swiper-button-prev {
            left:0px !important;
        }
    </style>
@endsection
@section('additional-scripts')

    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    <script src="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.js') }}"
            type='text/javascript'></script>

    <script type="text/javascript">
        var $carouselOneColOne =<?php echo json_encode($dataManagerPage['carouselOneColOne'])?>;
        var $carouselOneColTwo =<?php echo json_encode($dataManagerPage['carouselOneColTwo'])?>;
        var $carouselOneColThree =<?php echo json_encode($dataManagerPage['carouselOneColThree'])?>;
        var $carouselOneColFour =<?php echo json_encode($dataManagerPage['carouselOneColFour'])?>;


        var $carouselTwoColOne =<?php echo json_encode($dataManagerPage['carouselTwoColOne'])?>;
        var $carouselTwoColTwo =<?php echo json_encode($dataManagerPage['carouselTwoColTwo'])?>;
        var $carouselTwoColThree =<?php echo json_encode($dataManagerPage['carouselTwoColThree'])?>;
        var $carouselTwoColFour =<?php echo json_encode($dataManagerPage['carouselTwoColFour'])?>;


        var $carouselThreeColOne =<?php echo json_encode($dataManagerPage['carouselThreeColOne'])?>;
        var $carouselThreeColTwo =<?php echo json_encode($dataManagerPage['carouselThreeColTwo'])?>;
        var $carouselThreeColThree =<?php echo json_encode($dataManagerPage['carouselThreeColThree'])?>;
        var $carouselThreeColFour =<?php echo json_encode($dataManagerPage['carouselThreeColFour'])?>;
        var $carouselThreeColFive =<?php echo json_encode($dataManagerPage['carouselThreeColFive'])?>;
        var $carouselThreeColSix =<?php echo json_encode($dataManagerPage['carouselThreeColSix'])?>;


    </script>
    <script>
        function getGallery(dataString) {
            console.log("dataString", dataString);
        }

        function initSliderOne() {
            $('.single-slider-one').slick({
                infinite: true,
                slidesToShow: 1,
                dots: true,
                arrows: false,
                adaptiveHeight: true
            });
            var sbp = jQuery('.swiper-button-prev.sw-btn-one'),
                sbn = jQuery('.swiper-button-next.sw-btn-one');
            sbp.on("click", function () {
                $(this).closest(".single-slider-wrapper").find('.single-slider-one').slick('slickPrev');
            });
            sbn.on("click", function () {
                $(this).closest(".single-slider-wrapper").find('.single-slider-one').slick('slickNext');
            });
        }

        function initEventCovers() {


            initSliderOne();

            $(".cover-event").on("click", function () {
                console.log($(this).attr("nameCol"));
                var sliderOne = false;
                var sliderTwo = false;
                var resultItems = [];
                if ("carouselOneColTwo" == $(this).attr("nameCol")) {
                    sliderOne = true;

                    resultItems = [];

                    $.each($carouselOneColTwo, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });

                } else if ("carouselOneColOne" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderOne = true;

                    $.each($carouselOneColOne, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselOneColTwo" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderOne = true;

                    $.each($carouselOneColTwo, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselOneColThree" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderOne = true;

                    $.each($carouselOneColThree, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselOneColFour" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderOne = true;

                    $.each($carouselOneColFour, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselTwoColOne" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselTwoColOne, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselTwoColTwo" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselTwoColTwo, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });

                } else if ("carouselTwoColThree" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselTwoColThree, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselTwoColFour" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselTwoColFour, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });
                } else if ("carouselThreeColOne" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselThreeColOne, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselThreeColTwo" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselThreeColTwo, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });

                } else if ("carouselThreeColThree" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselThreeColThree, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });


                } else if ("carouselThreeColFour" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselThreeColFour, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });
                } else if ("carouselThreeColFive" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselThreeColFive, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });
                } else if ("carouselThreeColSix" == $(this).attr("nameCol")) {
                    resultItems = [];
                    sliderTwo = true;

                    $.each($carouselThreeColSix, function (index, value) {
                        if (!value.isCover) {
                            var result = [
                                "<div class=\"slick-slide-item\">",
                                '  <img class="img-manager-home-products" src="' + value.img + '" alt="">',
                                "</div>",
                            ];
                            resultItems.push(result.join(""));
                        }
                    });
                }
                $("#carousel-manager-one__single-slider").html("");
                $("#carousel-manager-one__single-slider").html(resultItems.join(""));
                $("#carousel-manager-one__single-slider").removeClass("slick-initialized");
                $("#carousel-manager-one__single-slider").removeClass("slick-slider");
                $("#carousel-manager-one__single-slider").removeClass("slick-dotted");
                initSliderOne();
            });
        }

        $(function () {
            initEventCovers();
            initGalleries();
        });

        function initGalleries() {
            var selectorCurrent = ".lightGalleryOneColOne";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });
            selectorCurrent = ".lightGalleryOneColTwo";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });

            selectorCurrent = ".lightGalleryOneColThree";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });
            selectorCurrent = ".lightGalleryOneColFour";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });

            selectorCurrent = ".lightGalleryTwoColOne";
            o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });
            selectorCurrent = ".lightGalleryTwoColTwo";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });

            selectorCurrent = ".lightGalleryTwoColThree";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });
            selectorCurrent = ".lightGalleryTwoColFour";
            var o = $(selectorCurrent),
                p = o.data("looped");
            o.lightGallery({
                selector: "" + selectorCurrent + " a.popup-image",
                cssEasing: "cubic-bezier(0.25, 0, 0.25, 1)",
                download: false,
                loop: false,
                counter: false
            });


        }

    </script>

@endsection


@section('content-manager')

    <div class="content full-height fs-slider-wrap">
        <!--section -->
        <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">
                    @foreach ($dataManagerPage['sliderMainImage'] ["data"] as $row)

                        <div class="slider-item fl-wrap">
                            <div class="bg"
                                 data-bg="{{ $row}}"></div>
                            <div class="overlay"></div>
                            <div class="hero-section-wrap fl-wrap">
                                <div class="container ">
                                    <div class="intro-item fl-wrap">
                                        <h2 class="intro-item__title"> THE BEST ROSE</h2>
                                        <h3 class="intro-item__subtitle">Reconocidas a nivel mundial por alcanzar altos
                                            estándares de belleza y calidad. </h3>
                                    </div>


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-button-prev sw-btn "><i class="fa fa-chevron-left"></i></div>
                <div class="swiper-button-next sw-btn "><i class="fa fa-chevron-right"></i></div>

            </div>
            <div class="header-sec-link not-view">
                <div class="container">
                    <a href="#sec2" class="custom-scroll-link">{{__('page.initSection.button')}}</a>
                </div>
            </div>
        </section>

    </div>

@endsection
@section('content')

    <div id="app-management" class="manager-product-box">
        <section class="manager-product-flowers__one-section">
            <div class="container ">
                <h1 class="manager-product-flowers__one-title">{{__("page.product.flowers.section.one.title")}}</h1>


            </div>
        </section>


        <section id="carousel-manager-one">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8 md-view-carousel">
                        <div class="list-single-main-media fl-wrap">
                            <div class="single-slider-wrapper fl-wrap">
                                <div class="single-slider-one fl-wrap" id="carousel-manager-one__single-slider">
                                    @foreach ($dataManagerPage['carouselOneColOne'] as $row)
                                        @if(!$row["isCover"])
                                            <div class="slick-slide-item">
                                                <img class="img-manager-home-products" src="{{$row['img']}}" alt=""
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @if(count($dataManagerPage['carouselOneColOne'])>0)
                                    <div class="swiper-button-prev sw-btn sw-btn-one"><i class="fa fa-chevron-left"></i></div>
                                    <div class="swiper-button-next sw-btn sw-btn-one"><i class="fa fa-chevron-right"></i></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
            </div>


        </section>


        <section class="carousel-product">
            <div class="container">

                <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryOneColOne">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselOneColOne'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselOneColOne">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryOneColTwo">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselOneColTwo'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselOneColTwo">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryOneColThree">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselOneColThree'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselOneColThree">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryOneColFour">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselOneColFour'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselOneColFour">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryTwoColOne">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselTwoColOne'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselTwoColOne">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>

                    <div class="col-md-1">

                    </div>
                </div>
            </div>

        </section>
        <section class="carousel-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryTwoColTwo">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselTwoColTwo'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselTwoColTwo">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryTwoColThree">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselTwoColThree'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselTwoColThree">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryTwoColFour">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselTwoColFour'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselTwoColFour">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryThreeColOne">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselThreeColOne'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselThreeColOne">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryThreeColTwo">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselThreeColTwo'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselThreeColTwo">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>

        </section>
        <section class="carousel-product">
            <div class="container">
                <div class="row">

                    <div class="col-md-1">

                    </div>

                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryThreeColThree">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselThreeColThree'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselThreeColThree">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryThreeColFour">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselThreeColFour'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselThreeColFour">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryThreeColFive">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselThreeColFive'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselThreeColFive">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-2 col-md-3--gallery">
                        <div
                            class="gallery-items grid-small-pad  list-single-gallery three-coulms lightGalleryThreeColSix">
                            <!-- 1 -->
                            @foreach ($dataManagerPage['carouselThreeColSix'] as $row)
                                @if($row["isCover"])
                                    <div class="gallery-item ">
                                        <div class="grid-item-holder">
                                            <div class="box-item cover-event"
                                                 nameCol="carouselThreeColSix">
                                                <img src="{{$row['img']}}" alt="">
                                                <a href="{{$row['img']}}"
                                                   class="gal-link popup-image not-view"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>
        </section>
        <section class="manager-product-flowers__two-section">
            <div class="container ">
                <h1 class="manager-product-flowers__two-title">{{__("page.product.flowers.section.two.title")}}</h1>
                <p class="manager-product-flowers__two-description">{{__("page.product.flowers.section.two.description")}}</p>

            </div>
        </section>

        <section class="manager-product-flowers__three-section">
            <div class="container ">
                <h1 class="manager-product-flowers__three-title">{{__("page.product.flowers.section.three.title")}}</h1>
                <p class="manager-product-flowers__three-description">{{__("page.product.flowers.section.three.description")}}</p>

            </div>
        </section>


        <section class="manager-product-flowers__four-section">
            <div class="container container--manager-information-flowers">
                <h1 class="manager-product-flowers__four-title">{{__("page.product.flowers.section.four.title")}}</h1>
                <p class="manager-product-flowers__four-description">{{__("page.product.flowers.section.four.description")}}</p>

            </div>
        </section>
        <section>
            <img src="{{$dataManagerPage['backgroundOne']}}" alt="" class="img-background-full">
        </section>
        <section class="manager-product-flowers__five-section">
            <div class="container container--manager-information-flowers">
                <h1 class="manager-product-flowers__five-title">{{__("page.product.flowers.section.five.title")}}</h1>
                <p class="manager-product-flowers__five-description">{{__("page.product.flowers.section.five.description")}}</p>

            </div>
        </section>

        <section class="manager-product-flowers__six-section">
            <div class="container container--manager-information-flowers">
                <h1 class="manager-product-flowers__six-title">{{__("page.product.flowers.section.six.title")}}</h1>
                <p class="manager-product-flowers__six-description">{{__("page.product.flowers.section.six.description")}}</p>

            </div>
        </section>
        <section class="manager-product-flowers__seven-section">
            <div class="container container--manager-information-flowers">
                <h1 class="manager-product-flowers__seven-title">{{__("page.product.flowers.section.seven.title")}}</h1>
                <p class="manager-product-flowers__seven-description">{{__("page.product.flowers.section.seven.description")}}</p>

            </div>
        </section>

        <section class="manager-product-flowers__eight-section">
            <div class="container container--manager-information-flowers">
                <h1 class="manager-product-flowers__eight-title">{{__("page.product.flowers.section.eight.title")}}</h1>

            </div>
        </section>


    </div>


@endsection
