<?php
$resourcePathServer = env('APP_IS_SERVER') ? 'public/' : '';
?>

@extends('layouts.cityBook')
@section('additional-styles')
    <style>

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }
    </style>

@endsection
@section('additional-scripts')

    <script>
        $(function () {

            $('.header-search').show();
        })
    </script>
@endsection
@if(  $dataManagerPage['type']==1)
    @section('content-manager')
        @if(isset($dataManagerPage['sliderMainManager']))
            @include('cityBook.web.partials.home.sliderMain')
        @endif
    @endsection
    @section('content')
        <div class="row row--home">
            @if(isset($dataManagerPage['homeImageTwo']))
                <div class="col-md-12">
                    {{$dataManagerPage['homeImageTwo']}}
                </div>
            @endif
        </div>
        <section class="section-home">
            <div class="container">
                @include('cityBook.web.partials.home.work-it',[
        "titleCurrent"=>__('frontend.menu.homeTwo.title'),
        "subtitleCurrent"=>__('frontend.menu.homeTwo.subtitle'),
        "descriptionCurrent"=>__('frontend.menu.homeTwo.description'),

        ])
            </div>
        </section>

        @include('cityBook.web.partials.home.sliderTwo')


        <div class="row row--home">
            <div class="col-md-12">
                @if(isset($dataManagerPage['homeImageThree']))
                    {{$dataManagerPage['homeImageThree']}}
                @endif
            </div>
        </div>
        <section class="section-home">
            <div class="container">
                @include('cityBook.web.partials.home.work-it',[
        "titleCurrent"=>__('frontend.menu.homeThree.title'),
        "subtitleCurrent"=>__('frontend.menu.homeThree.subtitle'),
        "descriptionCurrent"=>__('frontend.menu.homeThree.description'),

        ])
            </div>
        </section>
        @include('cityBook.web.partials.home.sliderOne')
        <div class="row row--home-init">
            <div class="col-md-12">
                @if(isset($dataManagerPage['homeImageOne']))
                    {{$dataManagerPage['homeImageOne']}}
                @endif
            </div>
        </div>
        <section class="section-home">
            <div class="container">
                @include('cityBook.web.partials.home.work-it',[
        "titleCurrent"=>__('frontend.menu.homeOne.title'),
        "subtitleCurrent"=>__('frontend.menu.homeOne.subtitle'),
        "descriptionCurrent"=>__('frontend.menu.homeOne.description'),

        ])
            </div>
        </section>



        @include('cityBook.web.partials.home.sliderThree')

        <div class="row row--home">
            <div class="col-md-12">
                @if(isset($dataManagerPage['homeImageFour']))
                    {{$dataManagerPage['homeImageFour']}}
                @endif

            </div>
        </div>
        <section class="section-home">
            <div class="container">
                @include('cityBook.web.partials.home.work-it',[
        "titleCurrent"=>__('frontend.menu.homeFour.title'),
        "subtitleCurrent"=>__('frontend.menu.homeFour.subtitle'),
        "descriptionCurrent"=>__('frontend.menu.homeFour.description'),

        ])
            </div>
        </section>
    @endsection

@endif

