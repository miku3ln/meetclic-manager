@extends('layouts.cityBook')
@section('additional-styles')

@endsection
@section('additional-scripts')
    <script>
        $(function () {
            $('.show-search-button').show();
        });
    </script>

@endsection

@if(isset($dataManagerPage['dataPage']))

@section('content-manager')

    <div class="content full-height fs-slider-wrap">
        <!--section -->
        <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">


                    <div class="slider-item fl-wrap">
                        <div class="bg"
                             data-bg="{{URL::asset($publicAsset.$dataManagerPage['dataPage']['parent']->source)}}"></div>
                        <div class="overlay"></div>
                        <div class="hero-section-wrap fl-wrap">
                            <div class="container">
                                <div class="intro-item fl-wrap">
                                    <h2 class="intro-item__title"> {{$dataManagerPage['dataPage']['parent']->value}}</h2>
                                    <h3 class="intro-item__subtitle"> {{$dataManagerPage['dataPage']['parent']->subtitle}}</h3>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                @if(false)
                    <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
                    <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>
                @endif
            </div>
            <div class="header-sec-link">
                <div class="container">
                    <a href="#sec2" class="custom-scroll-link">{{__('frontend.menu.home.slider.button')}}</a>
                </div>
            </div>
        </section>

    </div>

@endsection
@endif
@section('content')
    <div id="app-management">
        @if(isset($dataManagerPage['dataPage']))

            <section id="sec2">
                <div class="container">
                    <div class="section-title">
                        <h2>{{__('page.aboutUs.variants.title')}}</h2>
                        <div class="section-subtitle">{{__('page.aboutUs.variants.subtitle')}}</div>
                        <span class="section-separator"></span>
                        <p>{{__('page.aboutUs.variants.description')}}</p>
                    </div>
                    @if(isset($dataManagerPage['dataPage']['children']) && count($dataManagerPage['dataPage']['children'])>0)

                        <div class="about-wrap">
                            <?php $allowButtonTeam = true; ?>
                            @foreach ($dataManagerPage['dataPage']['children'] as $child)
                                <div class="row">
                                    @if(isset($child['is_multimedia']))
                                        <div class="col-md-6">
                                            <div class="video-box fl-wrap">
                                                <img src="{{ URL::asset($themePath.'images/all/16.jpg')}}" alt="">
                                                <a class="video-box-btn image-popup" href="https://vimeo.com/264074381"><i
                                                        class="fa fa-play" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="video-box fl-wrap">
                                                <img src="{{ URL::asset($publicAsset.$child['source'])}}" alt="">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="list-single-main-item-title fl-wrap">
                                            <h3>{{$child['title']}}</h3>
                                            @if(isset($child['subtitle']))
                                                <h4>{{$child['subtitle']}}</h4>
                                            @endif
                                            <span class="section-separator fl-sec-sep"></span>
                                        </div>
                                        {!! $child['description'] !!}
                                        @if($allowButtonTeam)
                                            <a href="#sec3"
                                               class="btn transparent-btn float-btn custom-scroll-link btn--about-us">
                                                {{__('page.ourTeam.variants.button')}}<i class="fa fa-users"></i></a>
                                        @else
                                            <?php $allowButtonTeam = false;?>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                    <span class="fw-separator"></span>
                    @include('layouts.partials.cityBook.support')
                </div>
            </section>
            @include('layouts.partials.cityBook.counterViews')
            @if(isset($dataManagerPage['dataPage']['teamHtml']))
                @include('layouts.partials.cityBook.ourTeam')
            @endif

            <section class="parallax-section" data-scrollax-parent="true">
                <div class="bg par-elem " data-bg="{{ URL::asset($themePath.'images/bg/26.jpg')}}"
                     data-scrollax="properties: { translateY: '30%' }"></div>
                <div class="overlay co lor-overlay"></div>
                <div class="container">
                    <div class="intro-item fl-wrap">
                        <h2>{{__('page.aboutUs.variants.background.title')}}</h2>
                        <h3>{{__('page.aboutUs.variants.background.subtitle')}}</h3>
                        <a class="trs-btn"
                           href="{{route('contactUsBee',app()->getLocale())}}">{{__('page.aboutUs.variants.background.button')}}
                            + </a>
                    </div>
                </div>
            </section>
            @if(env('allowTestimonials'))
                <section id="sec5">
                    <div class="container">
                        <div class="section-title">
                            <h2>{{__('frontend.menu.home.testimonials.title')}}</h2>
                            <div class="section-subtitle">{{__('frontend.menu.home.testimonials.subtitle')}}</div>
                            <span class="section-separator"></span>
                            <p>{{__('frontend.menu.home.testimonials.description')}}</p>
                        </div>
                    </div>

                    @include('layouts.partials.cityBook.testimonials')
                </section>
            @endif

            @if(env('allowCustomersBusiness'))

                @include('layouts.partials.cityBook.customers')
            @endif
            @if(!Auth::check())
                @include('layouts.partials.cityBook.join')
            @endif
            <div class="limit-box"></div>
        @else
            @include('layouts.partials.cityBook.errors.warning',['title'=>'Advertencia!','description'=>'No Existe Gestion de esta seccion Quienes Somos'])
        @endif


    </div>
@endsection
