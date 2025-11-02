@extends('layouts.cityBook')
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
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

    <div class="content full-height fs-slider-wrap">
        <!--section -->
        <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">

                    @foreach ($dataManagerPage['sliderMainImage'] ["data"] as $row)
                        <div class="slider-item fl-wrap">
                            <div class="bg"
                                 data-bg="{{$row}}"></div>
                            <div class="overlay"></div>
                            <div class="hero-section-wrap fl-wrap">
                                <div class="container ">
                                    <div class="intro-item fl-wrap">
                                        <h2 class="intro-item__title"> THE BEST PRODUCTS</h2>
                                        <h3 class="intro-item__subtitle"> Desde frutos del mar hasta productos textiles.
                                            Todo lo que imagines,cerca de ti. </h3>
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
        <section class="manager-product-products__one-section">
            <div class="container ">
                <h1 class="manager-product-products__one-title">{{__("page.product.products.section.one.title")}}</h1>

            </div>
        </section>

        <section>
            <img src="{{$dataManagerPage['backgroundOne']}}" alt="" class="img-background-full">
        </section>
        <section class="manager-product-products__two-section">
            <div class="container container--manager-information-fruits">
                <h1 class="manager-product-products__two-title">{{__("page.product.products.section.two.title")}}</h1>
                <p class="manager-product-products__two-description">{{__("page.product.products.section.two.description")}}</p>

            </div>
        </section>

        <section>
            <img src="{{$dataManagerPage['backgroundTwo']}}" alt="" class="img-background-full">
        </section>

        <section class="manager-product-products__three-section">
            <div class="container container--manager-information-products">
                <h1 class="manager-product-products__three-title">{{__("page.product.products.section.three.title")}}</h1>
                <p class="manager-product-products__three-description">{{__("page.product.products.section.three.description")}}</p>

            </div>
        </section>

        <section>
            <img src="{{$dataManagerPage['backgroundThree']}}" alt="" class="img-background-full">
        </section>

        <section class="manager-product-products__four-section">
            <div class="container container--manager-information-products">
                <h1 class="manager-product-products__four-title">{{__("page.product.products.section.four.title")}}</h1>
                <p class="manager-product-products__four-description">{{__("page.product.products.section.four.description")}}</p>

            </div>
        </section>

        <section>
            <img src="{{$dataManagerPage['backgroundFour']}}" alt="" class="img-background-full">
        </section>


    </div>


@endsection
