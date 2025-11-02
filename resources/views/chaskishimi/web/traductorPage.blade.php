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

        @media screen and (min-width: 300px) and (max-width: 768px) {
            .content {
                height: 549px;

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
@section('content')
    <section class="section--full-img" id="arawi">
        <img class="img-svg-full-coming-soon" src="{{ URL::asset($assetsRoot.'/coming-soon.jpg')}}" alt="">

    </section>
@endsection

