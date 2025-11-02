<?php
$resourcePathServer = env('APP_IS_SERVER') ? 'public/' : ''; ?>
@extends('layouts.education')
@section('additional-styles')
    <link rel="stylesheet" href="{{ asset($resourcePathServer . 'frontend/assets/css/web/education/Alamos.css') }}">

@endsection
@section('additional-scripts')
@include('frontend.web.scripts.aboutUs')

@endsection
@section('content')
    @include('layouts.partials.education.contactUs')
@endsection
@include('layouts.partials.education.footer')
