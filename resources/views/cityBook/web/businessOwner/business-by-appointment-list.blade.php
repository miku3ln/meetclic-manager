@php

    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';
@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')
    @include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.css.root')
@endsection

@section('additional-scripts')
   @include('cityBook.web.businessOwner.business-by-appointment-list.partials.assets.js.root')

@endsection
@section('content')
    <div class="container--custom">
        <div class="row">
            <div id="scheduleConfiguration"></div>
        </div>
        <div class="container mt-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    Calendario de Eventos
                </div>

                <div class="card-body">

                    <div id="calendar"></div>

                </div>

            </div>

        </div>
    </div>
@endsection
@section('content-modals')

    @include('cityBook.web.businessOwner.business-by-appointment-list.partials.modals.root')

@endsection
@section('content-navbar')

    @php
        $menu=    app(\App\Services\MenuService::class)->getMenu();

    @endphp
    @include('components.navbar', [
        'menu' => $menu
    ])

@endsection
