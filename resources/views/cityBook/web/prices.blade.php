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
@section('content')
    <div id="app-management">
        <!--  section  -->
        <section class="parallax-section" data-scrollax-parent="true" id="sec1">
            <div class="bg par-elem " data-bg="{{URL::asset($themePath.'images/bg/26.jpg')}}"
                 data-scrollax="properties: { translateY: '30%' }"></div>
            <div class="overlay"></div>
            <div class="container">
                <div class="section-title center-align">
                    <h2><span>{{__('frontend.plans.slider.title')}}</span></h2>
                    <div class="breadcrumbs fl-wrap"><a href="{{route('homePage',app()->getLocale())}}">{{__('frontend.plans.slider.breadcrumb.main')}}</a><span>{{__('frontend.plans.slider.breadcrumb.current')}} </span></div>
                    <span class="section-separator"></span>
                </div>
            </div>
            <div class="header-sec-link">
                <div class="container"><a href="#sec2" class="custom-scroll-link">{{__('frontend.plans.slider.button')}}</a></div>
            </div>
        </section>
        <!--  section end -->
        <!--  section   -->
    @include('layouts.partials.cityBook.plans')
    <!--  section end -->
        <!--  section  -->
    @if(!Auth::check())
        @include('layouts.partials.cityBook.join')

    @endif
        <!--  section end -->
        <div class="limit-box"></div>
    </div>

@endsection
