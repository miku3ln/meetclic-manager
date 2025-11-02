{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/eatPura/';
        $assetsRoot = $resourcePathServer . 'assets/backline/';
$urlCurrentSearch=route('search',app()->getLocale());
$urlShopPage = route('shopPage', app()->getLocale());
@endphp
@extends('layouts.eatPura')
@section('additional-styles')
    <style>
        .grocery-banner--manager {

            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
@endsection

@section('additional-scripts-vue-before')
    <script id="additional-scripts-vue-before">
        function onSearchData() {
            var _this = this;
            console.log("onSearchData","_this",_this);

        }
        function onChangeSearchData() {
            var _this = this;
            console.log("onChangeSearchData","_this",_this);

        }
        $methodsShopPage.onSearchData = onSearchData;
        $methodsShopPage.onChangeSearchData = onChangeSearchData;

    </script>
@endsection
@section('additional-scripts')
    <script>


        // Hero Slider Homepage
        $(window).on('load', function () {
            var selector = '.hero-slider-home-top';
            $(selector).slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: true,
                autoplay: true

            });
            $(selector).fadeIn();


        });
    </script>
@endsection

@section('content-manager')
    @if(isset($dataManagerPage['sliderHomeTop']))
        <div class="hero-slider-main">
            <div class="hero-slider hero-slider-home-top mb-0">
                @foreach ($dataManagerPage['sliderHomeTop']["slider"]["data"] as $row)

                    <div class="hero-slider-{{$row['id']}}">
                        <div class="px-3">
                            <div class="row align-items-center justify-content-between g-0">
                                <div class="col-7">
                                    <h4 class="fw-bold text-success">

                                        {!! $row['title']!!}
                                    </h4>
                                    <p class="m-0 small"> {!!$row['subtitle']!!}</p>
                                    @if($row['type_button']==1)
                                        <a href="{{$row['options_button']["data"][0]['link']}}"
                                           class="btn btn-success btn-sm fw-bold mt-3 rounded-pill">
                                            {{$row['button_name']}}
                                            <i
                                                class="bi bi-arrow-right ms-1">

                                            </i>
                                        </a>

                                    @endif

                                </div>
                                <div class="col-5 pt-3">
                                    <img src="{{$row['source']}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>

    @endif
    <!-- Category -->
    @if(isset($dataManagerPage['categoriesByProducts']))
        <section class="py-3 bg-white">
            <div class="container px-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="m-0">Shop Popular Categories</h6>
                    <a href="{{$urlShopPage}}">View all<i class="icofont-rounded-right"></i></a>
                </div>
                <div class="row row-cols-xl-6 row-cols-lg-6 row-cols-md-4 row-cols-4 g-1 category">
                    @foreach ($dataManagerPage['categoriesByProducts'] as $row)

                        <div class="col">
                            <div class="card text-center rounded-4">
                                <div class="card-body">
                                    <img src="{{ URL::asset($resourcePathServer.$row->source)}}" class="img-fluid mb-1">
                                    <p class="card-text text-truncate mb-0 mt-2 small">{{$row->value}}</p>
                                    <a href="{{$urlShopPage.'?category='.$row->id}}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </section>
    @endif
    @if(isset($dataManagerPage['sliderHomeGrocery']))
        <section class="pb-3">
            <div class="container px-3">
                <div class="row g-3">
                    @foreach ($dataManagerPage['sliderHomeGrocery']["slider"]["data"] as $row)

                        <div class="col-lg-6 col-12">
                            <div class="grocery-banner--manager rounded-4 p-4"
                                 style="background-image:url({{$row['source']}}) !important;">
                                <h4 class="fw-bold mb-1">{!! $row['title'] !!}</h4>
                                <p>{!! $row['subtitle'] !!}</p>

                                @if($row['type_button']==1)
                                    <a href="{{$row['options_button']["data"][0]['link']}}"
                                       class="btn btn-danger btn-sm rounded-pill">
                                        {{$row['button_name']}}
                                        <i
                                            class="bi bi-arrow-right ms-1">

                                        </i>
                                    </a>

                                @endif

                            </div>
                        </div>

                    @endforeach

                </div>


            </div>
        </section>
    @endif
    @if(isset($dataManagerPage['recentProductsHome']) && $dataManagerPage['recentProductsHome']['total']>0 )
        <div class="container p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="m-0">Popular Products</h6>
                <a href="{{$urlShopPage}}">View all<i class="icofont-rounded-right"></i></a>
            </div>

            <div class="row row-cols-xl-5 row-cols-lg-5 row-cols-md-2 row-cols-2 g-3">
                @foreach ($dataManagerPage['recentProductsHome']['rows'] as $row)
                    <div class="product-item col">
                        <div class="card h-100 rounded-4 overflow-hidden osahan-card-list">
                            <a href="product-detail.html">
                                <img src="{{ URL::asset($resourcePathServer.$row->source)}}"
                                     alt=""
                                     class="card-img-top">
                            </a>
                            <div class="card-body pt-0">
                                <p class="card-text text-muted mb-1 small">{{$row->name}}</p>
                                <h6 class="card-title fw-bold text-truncate">{{$row->description}}</h6>
                                <p class="text-muted small m-0 not-view">400g</p>
                            </div>
                            <div
                                class="card-footer bg-transparent border-0 d-flex align-items-end justify-content-between pt-0 pb-3">
                                <h6 class="fw-bold m-0">
                                    <del class="text-muted small fw-normal not-view">$55</del>
                                    <br>${{$row->sale_price}}
                                </h6>
                                <a data-row="<?php echo htmlspecialchars(json_encode($row)); ?>"
                                   @click="onSetProductCart({type:0,row: $event.target.dataset.row })"
                                   data-bs-toggle="offcanvas" data-bs-target="#mycart" aria-controls="mycart" href="#"
                                   class="btn btn-outline-danger btn-sm rounded-3 fw-bold px-4 osahan-new-btn">ADD
                                </a>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

        </div>
    @endif
    @if(isset($dataManagerPage['sliderHomeAdver']))
        <div class="container px-3">
            <div class="row g-3">
                @foreach ($dataManagerPage['sliderHomeAdver']["slider"]["data"] as $row)
                    <div class="col-lg-4 col-12">
                        <div class="adver-banner-1 rounded-4 p-4"
                             style="background-image:url({{$row['source']}}) !important;">
                            <h3 class="fw-bold text-primary">
                                {!! $row['title']!!}
                            </h3>
                            <p class="text-muted fs-6">
                                {!! $row['subtitle']!!}
                            </p>
                            @if($row['type_button']==1)

                                <a href="{{$row['options_button']["data"][0]['link']}}"
                                   class="btn btn-primary rounded-pill">
                                    {{$row['button_name']}}
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endif

@endsection

