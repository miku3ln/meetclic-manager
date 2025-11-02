{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $assetsRoot = $resourcePathServer . 'assets/chaskishimi/';

@endphp
@extends('layouts.chaskishimi')
@section('additional-styles')
    <style>
        .section--full-img {
            padding: 0 0;
        }

        h1.title {
            float: left;
            width: 100%;
            text-align: center;
            color: #4db7fe;
            font-size: 34px;
            font-weight: 700;
        }

        img.img-svg-full {
            width: 88%;
        }

        .hero-section .intro-item h2 {
            font-size: 55px ;
            color: #aacbe0;
        }

        @media screen and (min-width: 300px) and (max-width: 768px) {
            img.img-svg-full {
                width: 100%;
            }

            .intro-item h3 {

                font-size: 17px !important;

            }
            .hero-section .intro-item h2 {
                padding-top: 14%;
                font-size: 29px;

            }
            .slider-container-wrap.fs-slider .hero-section-wrap{
                top: 23% !important;
            }
            #wrapper{
                padding-top: 0;
            }

        }

    </style>
@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>

    <script>
        $(function () {

            $('.header-search').show();
        })
    </script>
@endsection
@section('content-manager')
    @if(isset($dataManagerPage['sliderMainManager']))
        @include('chaskishimi.web.partials.home.sliderMain')

    @endif

    <section class="section--full-img" id="kichwa">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/kichwa-section.svg')}}" alt="">

    </section>
    <section class="section--full-img" id="elements">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/elements-section.svg')}}" alt="">

    </section>
    <section class="section--full-img" id="arawi">
        <img class="img-svg-full" src="{{ URL::asset($assetsRoot.'home/arawi-section.svg')}}" alt="">

    </section>
@endsection

