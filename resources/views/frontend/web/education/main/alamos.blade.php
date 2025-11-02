<?php
$resourcePathServer = env('APP_IS_SERVER') ? 'public/' : ''; ?>
@extends('layouts.education')
@section('additional-styles')
    <link rel="stylesheet" href="{{ asset($resourcePathServer . 'frontend/assets/css/web/education/Alamos.css') }}">


@endsection
@section('additional-scripts')
    <script src="{{asset($resourcePathServer.'js')}}/frontend/web/education/Counters.js"></script>


@endsection
@section('content')
    <section>
        @if (isset($dataSliderHtml))
            {!! $dataSliderHtml !!}

        @else
            @include('frontend.education.sliderEmpty')
        @endif
    </section>
    @if (isset($dataManagerPage['dataHistoryMainHtml']))
        {!! $dataManagerPage['dataHistoryMainHtml'] !!}
    @endif
    @if (isset($dataManagerPage['dataAcademicsOfferingHtml']))
        {!! $dataManagerPage['dataAcademicsOfferingHtml'] !!}
    @endif
    @if (isset($dataManagerPage['dataCountersHtml']))
        {!! $dataManagerPage['dataCountersHtml'] !!}
    @endif

    @if (isset($dataManagerPage['dataProfilesHtml']))
        {!! $dataManagerPage['dataProfilesHtml'] !!}
    @endif
    @if (isset($dataManagerPage['dataNewsHtml']))
        {!! $dataManagerPage['dataNewsHtml'] !!}
    @endif
    @if (isset($dataManagerPage['dataPartnerCompaniesHtml']))
        {!! $dataManagerPage['dataPartnerCompaniesHtml'] !!}
    @endif

@endsection
@include('layouts.partials.education.footer')
