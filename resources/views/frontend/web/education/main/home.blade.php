<?php
$resourcePathServer = env('APP_IS_SERVER') ? 'public/' : ''; ?>
@extends('layouts.education')
@section('additional-styles')
<link rel="stylesheet" href="{{ asset($resourcePathServer . 'frontend/assets/css/web/education/Main.css') }}">
<style>


  
</style>

@endsection
@section('additional-scripts')

@endsection
@section('content')
    <section>
        @if (isset($dataSliderHtml))
            {!! $dataSliderHtml !!}

        @else
            <div class="empty-management">
                <div class="swiper-container swiper-slider swiper-slider-3" data-autoplay="true" data-height="100vh"
                    data-loop="true" data-dragable="false" data-min-height="480px" data-slide-effect="true">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"
                            data-slide-bg="{{ asset($resourcePathServer . 'templates/education') }}/images/slide-03-1920x810.jpg"
                            style="background-position: 80% center">
                            <div class="swiper-slide-caption header-transparent-slide-caption">
                                <div class="container">
                                    <div class="row justify-content-sm-center justify-content-xl-start no-gutters">
                                        <div class="col-lg-6 text-lg-left col-sm-10">
                                            <div data-caption-animate="fadeInUp" data-caption-delay="100"
                                                data-caption-duration="1700">
                                                <h1 class="font-weight-bold">Inspiration, Innovation and Discovery.</h1>
                                            </div>
                                            <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"
                                                data-caption-animate="fadeInUp" data-caption-delay="150"
                                                data-caption-duration="1700">
                                                <h5 class="text-regular font-default">Any successful career starts with
                                                    good
                                                    education. Together with us you will have deeper knowledge of the
                                                    subjects
                                                    that will be especially useful for you when climbing the career
                                                    ladder.</h5>
                                            </div>
                                            <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"
                                                data-caption-delay="400" data-caption-duration="1700"><a
                                                    class="btn button-madison btn-ellipse" href="login-register.html">Sign
                                                    Up
                                                    for Excursion</a>
                                                <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                        class="btn button-primary btn-ellipse d-none d-xl-inline-block"
                                                        href="academics.html">Learn More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide"
                            data-slide-bg="{{ asset($resourcePathServer . 'templates/education') }}/images/slide-02-1920x810.jpg"
                            style="background-position: 80% center">
                            <div class="swiper-slide-caption header-transparent-slide-caption">
                                <div class="container">
                                    <div class="row justify-content-sm-center justify-content-xl-start no-gutters">
                                        <div class="col-lg-6 text-lg-left col-sm-10">
                                            <div data-caption-animate="fadeInUp" data-caption-delay="100"
                                                data-caption-duration="1700">
                                                <h1 class="font-weight-bold">Investing in Knowledge.</h1>
                                            </div>
                                            <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"
                                                data-caption-animate="fadeInUp" data-caption-delay="150"
                                                data-caption-duration="1700">
                                                <h5 class="text-regular font-default">At Jonathan Carroll University,
                                                    you
                                                    can
                                                    succeed in lots of research areas and benefit from investing in your
                                                    education and knowledge that will help you in becoming an
                                                    experienced
                                                    specialist.</h5>
                                            </div>
                                            <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"
                                                data-caption-delay="400" data-caption-duration="1700"><a
                                                    class="btn btn-ellipse button-madison" href="login-register.html">Sign
                                                    Up
                                                    for Excursion</a>
                                                <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                        class="btn btn-ellipse button-primary d-none d-xl-inline-block"
                                                        href="academics.html">Learn More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide"
                            data-slide-bg="{{ asset($resourcePathServer . 'templates/education') }}/images/slide-01-1920x810.jpg"
                            style="background-position: 80% center">
                            <div class="swiper-slide-caption header-transparent-slide-caption">
                                <div class="container">
                                    <div class="row justify-content-sm-center justify-content-xl-start no-gutters">
                                        <div class="col-lg-6 text-lg-left col-sm-10">
                                            <div data-caption-animate="fadeInUp" data-caption-delay="100"
                                                data-caption-duration="1700">
                                                <h1 class="font-weight-bold">Open Minds. <br
                                                        class="d-none d-lg-inline-block">
                                                    Creating Future.</h1>
                                            </div>
                                            <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"
                                                data-caption-animate="fadeInUp" data-caption-delay="150"
                                                data-caption-duration="1700">
                                                <h5 class="text-regular font-default">Build your future with us! The
                                                    educational
                                                    programs of our University will give you necessary skills, training,
                                                    and
                                                    knowledge to make everything you learned here work for you in the
                                                    future.</h5>
                                            </div>
                                            <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"
                                                data-caption-delay="400" data-caption-duration="1700"><a
                                                    class="btn btn-ellipse button-madison" href="login-register.html">Sign
                                                    Up
                                                    for Excursion</a>
                                                <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                        class="btn btn-ellipse button-primary d-none d-xl-inline-block"
                                                        href="academics.html">Learn More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Swiper Pagination-->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        @endif
    </section>


@endsection
