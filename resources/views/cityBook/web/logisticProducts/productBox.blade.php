@extends('layouts.cityBook')
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
    <style>
        section.section-one {
            padding-top: 1%;
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


    <script>

    </script>

@endsection


@section('content-manager')
    @if(false)
        <div class="content full-height fs-slider-wrap">
            <!--section -->
            <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
                <div class="slider-container-wrap full-height fs-slider fl-wrap">
                    <div class="slider-container">


                        <div class="slider-item fl-wrap">
                            <div class="bg"
                                 data-bg="{{ $dataManagerPage["sliderMainImage"]}}"></div>
                            <div class="overlay"></div>
                            <div class="hero-section-wrap fl-wrap">
                                <div class="container">
                                    <div class="intro-item fl-wrap">
                                        <h2 class="intro-item__title">THE CURIER </h2>
                                        <h3 class="intro-item__subtitle">Servicio de entrega de productos ecuatorianos
                                            como rosas;spray rosas;rosas tinturadas;rosas eternizadas;garden roses y
                                            todo tipo de flores. </h3>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="swiper-button-prev sw-btn not-view"><i class="fa fa-chevron-left"></i></div>
                    <div class="swiper-button-next sw-btn not-view"><i class="fa fa-chevron-right"></i></div>

                </div>
                <div class="header-sec-link not-view">
                    <div class="container">
                        <a href="#sec2" class="custom-scroll-link">{{__('page.initSection.button')}}</a>
                    </div>
                </div>
            </section>

        </div>
    @endif
@endsection
@section('content')

    <div id="app-management" class="manager-product-box">
        <section class="manager-product-box__one-section">
            <div class="container">
                <h1 class="manager-product-box__one-title">{{__("page.product.box.section.eight.title")}}</h1>

            </div>
        </section>
        @if(false)
        <section class="parallax-section parallax-section--background-custom not-view" data-scrollax-parent="true">
            <div class="bg par-elem " data-bg="{{ $dataManagerPage['backgroundOne']}}"
                 data-scrollax="properties: { translateY: '30%' }"></div>
            <div class="overlay co lor-overlay"></div>

        </section>

        <section class="parallax-section not-view" data-scrollax-parent="true">
            <div class="bg par-elem " data-bg="{{ $dataManagerPage['backgroundOne']}}"
                 data-scrollax="properties: { translateY: '100%' }"></div>
            <div class="overlay co lor-overlay"></div>
            <div class="container container--manager-background-color-white container-manager-background-text">
                <div class="intro-item fl-wrap">
                    <div class="row container-manager-background-text_row">
                        <div class="col-md-6 container-manager-background-text_col-one">
                            <h2 class="container-manager-background-text_title-col-one ">{{__('page.aboutUs.variants.aboutData.title')}}</h2>
                            <p class="container-manager-background-text_description-col-one text-align-justify">
                                {{__('page.aboutUs.variants.aboutData.columnOne')}}
                            </p>
                        </div>
                        <div class="col-md-6 container-manager-background-text_col-two">
                            <p class="container-manager-background-text_description-col-two text-align-justify">
                                {{__('page.aboutUs.variants.aboutData.columnTwo')}}
                            </p>
                        </div>


                    </div>

                </div>
            </div>
        </section>
        @endif
        <section class="section-one">
            <img src="{{$dataManagerPage['backgroundOne']}}" alt="" class="img-background-full">
        </section>
        <section class="manager-product-box__two-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="manager-product-box__two-section-title">{{__("page.product.box.section.nine.title")}}</h1>
                        <p class="manager-product-box__two-section-description">
                            {{__("page.product.box.section.nine.description")}}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h1 class="manager-product-box__two-section-title">{{__("page.product.box.section.ten.title")}}</h1>
                        <p class="manager-product-box__two-section-description">
                            {{__("page.product.box.section.ten.description")}}
                        </p>
                    </div>
                </div>


            </div>
        </section>
        <section class="manager-product-box__three-section">
            <div class="container">
                <h1 class="manager-product-box__three-section-title">{{__("page.product.box.section.eleven.title")}}</h1>
                <div class="row">
                    <img src="{{$dataManagerPage['processExportacion']}}" alt="">

                </div>
            </div>
        </section>
        <section class="manager-product-box__four-section">
            <div class="container">
                <h1 class="manager-product-box__four-section-title">{{__("page.product.box.section.twelve.title")}}</h1>
                <div class="row">
                    <img src="{{$dataManagerPage['processImportacion']}}" alt="">

                </div>
            </div>
        </section>
        <section>
            <img src="{{$dataManagerPage['backgroundTwo']}}" alt="" class="img-background-full">
        </section>
    </div>


@endsection
