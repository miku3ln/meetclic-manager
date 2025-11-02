<?php
$resourcePathServer = env('APP_IS_SERVER') ? 'public/' : ''; ?>
@extends('layouts.education')
@section('additional-styles')
<link rel="stylesheet" href="{{ asset($resourcePathServer . 'frontend/assets/css/web/education/Preescolar.css') }}">

@endsection
@section('additional-scripts')

@endsection
@section('content')
    @include('layouts.partials.education.academicOffering')
@endsection
@include('layouts.partials.education.footer')
