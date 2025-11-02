@extends('layouts.cityBook')
@section('additional-styles')

@endsection
@section('additional-scripts')
<script>
    $(function () {

    $('.show-search-button').show();
    })
    </script>
@endsection


@section('content-manager')

    <div class="content full-height fs-slider-wrap">
        <!--section -->
        <section class="hero-section no-dadding full-height {{"hero-section--item" }}" id="sec1">
            <div class="slider-container-wrap full-height fs-slider fl-wrap">
                <div class="slider-container">


                    <div class="slider-item fl-wrap">
                        <div class="bg"
                             data-bg="{{ URL::asset($themePath.'images/bg/41.png')}}"></div>
                        <div class="overlay"></div>
                        <div class="hero-section-wrap fl-wrap">
                            <div class="container">
                                <div class="intro-item fl-wrap">
                                    <h2 class="intro-item__title"> {{__('frontend.how-it-works.slider.title')}} </h2>
                                    <h3 class="intro-item__subtitle not-view"> {{__('frontend.how-it-works.slider.title')}} </h3>
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
                    <a href="#sec2" class="custom-scroll-link">{{__('page.initSection.button')}}</a>
                </div>
            </div>
        </section>

    </div>

@endsection

@section('content')
    <div id="app-management">

        <section id="sec2">
            <div class="container">
                <div class="section-title">
                    <h2>{{__('frontend.menu.home.how-it-works.business.title')}}</h2>
                    <div class="section-subtitle">Preguntas Frecuentes</div>
                    <span class="section-separator"></span>
                    <p>{{__('frontend.how-it-works.content.title')}}</p>
                </div>
                <div class="time-line-wrap fl-wrap">

                    <div class="time-line-container">
                        <div class="step-item">{{__('frontend.how-it-works.content.item.faq')}} 1</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">01 . </span>
                            <div class="time-line-icon">
                                <i class="fa fa-map-o"></i>
                            </div>
                            <h3 class="tl-text--title">


                                <a href="{{route('business', app()->getLocale())}}">{{__('frontend.menu.home.how-it-works.business.one.title')}}</a>

                            </h3>
                            <p>{{__('frontend.menu.home.how-it-works.business.one.description')}}</p>
                        </div>
                        <div class="time-line-box tl-media tl-right">
                            <img src="{{ URL::asset($themePath.'images/bg/42.png')}}" alt="">
                        </div>
                    </div>
                    <div class="time-line-container lf-im">
                        <div class="step-item">{{__('frontend.how-it-works.content.item.faq')}} 2</div>
                        <div class="time-line-box tl-text tl-right">
                            <span class="process-count">02  </span>
                            <div class="time-line-icon">
                                <i class="fa fa-gears"></i>
                            </div>
                            <h3 class="tl-text--title">{{__('frontend.menu.home.how-it-works.business.two.title')}}</h3>
                            <p>{{__('frontend.menu.home.how-it-works.business.two.description')}}</p>
                        </div>
                        <div class="time-line-box tl-media tl-left">
                            <img src="{{ URL::asset($themePath.'images/bg/43.png')}}" alt="">
                        </div>
                    </div>

                    <div class="time-line-container">
                        <div class="step-item">{{__('frontend.how-it-works.content.item.faq')}} 3</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">03 . </span>
                            <div class="time-line-icon">
                                <i class="fa fa-hand-peace-o"></i>
                            </div>
                            <h3 class="tl-text--title">{{__('frontend.menu.home.how-it-works.business.three.title')}}</h3>
                            <p>{{__('frontend.menu.home.how-it-works.business.three.description')}}</p>
                        </div>
                        <div class="time-line-box tl-media tl-right">
                            <img src="{{ URL::asset($themePath.'images/bg/44.png')}}" alt="">
                        </div>
                    </div>
                    <!--  time-line-container -->
                    <div class="timeline-end"><i class="fa fa-check"></i></div>
                </div>
            </div>
        </section>
        <section id="section-customers">
            <div class="container">
                <div class="section-title">
                    <h2>{{__('frontend.menu.home.how-it-works.customers.title')}}</h2>
                    <div class="section-subtitle">Preguntas Frecuentes</div>
                    <span class="section-separator"></span>
                    <p>{{__('frontend.how-it-works.content.title')}}</p>
                </div>
                <div class="time-line-wrap fl-wrap">

                    <div class="time-line-container">
                        <div class="step-item">{{__('frontend.how-it-works.content.item.faq')}} 1</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">01 . </span>
                            <div class="time-line-icon">
                                <i class="fa fa-map-o"></i>
                            </div>
                            <h3 class="tl-text--title">{{__('frontend.menu.home.how-it-works.customers.one.title')}}</h3>
                            <p>{{__('frontend.menu.home.how-it-works.customers.one.description')}}</p>
                        </div>
                        <div class="time-line-box tl-media tl-right">
                            <img src="{{ URL::asset($themePath.'images/bg/45.png')}}" alt="">
                        </div>
                    </div>
                    <div class="time-line-container lf-im">
                        <div class="step-item">{{__('frontend.how-it-works.content.item.faq')}} 2</div>
                        <div class="time-line-box tl-text tl-right">
                            <span class="process-count">02 . </span>
                            <div class="time-line-icon">
                                <i class="fa fa-handshake-o"></i>
                            </div>
                            <h3 class="tl-text--title">{{__('frontend.menu.home.how-it-works.customers.two.title')}}</h3>
                            <p>{{__('frontend.menu.home.how-it-works.customers.two.description')}}</p>
                        </div>
                        <div class="time-line-box tl-media tl-left">
                            <img src="{{ URL::asset($themePath.'images/bg/46.png')}}" alt="">
                        </div>
                    </div>

                    <div class="time-line-container">
                        <div class="step-item">{{__('frontend.how-it-works.content.item.faq')}} 3</div>
                        <div class="time-line-box tl-text tl-left">
                            <span class="process-count">03 . </span>
                            <div class="time-line-icon">
                                <i class="fa fa-trophy"></i>
                            </div>
                            <h3 class="tl-text--title">{{__('frontend.menu.home.how-it-works.customers.three.title')}}</h3>
                            <p>{{__('frontend.menu.home.how-it-works.customers.three.description')}}</p>
                        </div>
                        <div class="time-line-box tl-media tl-right">
                            <img src="{{ URL::asset($themePath.'images/bg/47.png')}}" alt="">
                        </div>
                    </div>
                    <!--  time-line-container -->
                    <div class="timeline-end"><i class="fa fa-check"></i></div>
                </div>
            </div>
        </section>
        <!-- section end -->
        <!--section -->
        <section class="color-bg color-bg--one" id="sec3">
            <div class="shapes-bg-big"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="video-box fl-wrap">
                            <img src="{{ URL::asset($themePath.'images/all/19.jpg')}}" alt="">
                            <a class="video-box-btn image-popup" href="https://www.youtube.com/watch?v=ih34WPFvAK8"><i
                                    class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="color-bg-text">
                            <h3 class="tl-text--title">{{__('frontend.how-it-works.item.faq.video.one.title')}} </h3>
                            <p>{{__('frontend.how-it-works.item.faq.video.one.description')}} </p>
                            <a href="https://www.youtube.com/watch?v=ih34WPFvAK8" target="_blank" class="color-bg-link">{{__('frontend.how-it-works.item.faq.video.one.button')}} </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- section end -->
        <!--section -->
        <section class="gray-bg" id="sec4">
            <div class="container">
                <div class="section-title">
                    <h2> {{__('frontend.how-it-works.faq.title.title')}} </h2>
                    <div class="section-subtitle">popular questions</div>
                    <span class="section-separator"></span>
                    <p>  {{__('frontend.how-it-works.faq.title.subtitle')}}</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="accordion">
                            <a class="toggle act-accordion" href="#">  {{__('frontend.how-it-works.item.faq.text.one.title')}}<i
                                    class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner visible">
                                <p>{{__('frontend.how-it-works.item.faq.text.one.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.two.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.two.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.three.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.three.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.four.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.four.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.four.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.four.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.five.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.five.description')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion">
                            <a class="toggle" href="#">  {{__('frontend.how-it-works.item.faq.text.six.title')}}<i
                                    class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner visible">
                                <p>{{__('frontend.how-it-works.item.faq.text.six.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.seven.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.seven.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.eight.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.eight.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.nine.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.nine.description')}}</p>
                            </div>
                            <a class="toggle" href="#"> {{__('frontend.how-it-works.item.faq.text.ten.title')}} <i class="fa fa-angle-down"></i></a>
                            <div class="accordion-inner">
                                <p>{{__('frontend.how-it-works.item.faq.text.ten.description')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- section end -->
        <!--section -->
        @if(!Auth::check())
            @include('layouts.partials.cityBook.join')
        @endif
        <div class="limit-box"></div>

    </div>
@endsection
