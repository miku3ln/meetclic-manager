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
<?php

?>
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
                            <div class="container not-view">
                                <div class="intro-item fl-wrap">
                                    <h2 class="intro-item__title"> {{$dataManagerPage['dataPage']['parent']->value}}</h2>
                                    <h3 class="intro-item__subtitle"> {{$dataManagerPage['dataPage']['parent']->subtitle}}</h3>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="header-sec-link not-view">
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

            <section id="sec2" class="pamela">
                <div class="container">

                    @if(isset($dataManagerPage['dataPage']['children']) && count($dataManagerPage['dataPage']['children'])>0)

                        <div class="about-wrap">
                            <?php $allowButtonTeam = true; ?>
                            <div class="row">
                                @foreach ($dataManagerPage['dataPage']['children'] as $child)

                                    <div class="col-md-6">
                                        <div class="list-single-main-item-title fl-wrap">
                                            <h3>{{$child['title']}}</h3>

                                        </div>
                                        {!! $child['description'] !!}

                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif
                    @include('layouts.partials.cityBook.support')
                </div>
            </section>
            <section class="parallax-section" data-scrollax-parent="true">
                <div class="bg par-elem " data-bg="{{ $dataManagerPage['backgroundAboutUsImage']}}"
                     data-scrollax="properties: { translateY: '30%' }"></div>
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
            <section class="about-services">
                <div class="container">


                    <div class="row">
                        <img src="{{$dataManagerPage['servicesImage']}}" alt="" class="about-services">

                    </div>
                </div>

            </section>
            <section class="about-team">
                <div class="container">
                    <h2 class="about-team__title ">{{__('page.aboutUs.variants.aboutTem.title')}}</h2>
                    <p class="about-team__description ">{{__('page.aboutUs.variants.aboutTem.description')}}</p>

                    <div class="row">
                        <img src="{{$dataManagerPage['teamOneImage']}}" alt="" class="about-team__img">

                        <img src="{{$dataManagerPage['teamTwoImage']}}" alt="" class="about-team__img">

                        <img src="{{$dataManagerPage['teamThreeImage']}}" alt="" class="about-team__img">

                        <img src="{{$dataManagerPage['teamFourImage']}}" alt="" class="about-team__img">
                    </div>
                </div>

            </section>
        @else
            @include('layouts.partials.cityBook.errors.warning',['title'=>'Advertencia!','description'=>'No Existe Gestion de esta seccion Quienes Somos'])
        @endif


    </div>
@endsection
