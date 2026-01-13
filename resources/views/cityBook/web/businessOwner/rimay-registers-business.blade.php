@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $sourcesRoot = $resourcePathServer . 'frontend/businessOwner/mikuy-yachak';
 $leftRightMove   = URL::asset( $resourcePathServer."simi-rura/ui-totems/left-right.png");
    $upDownMove   = URL::asset( $resourcePathServer."simi-rura/ui-totems/up-down.png");
    $tile="Sugerencias Registros.!"
@endphp
@extends('layouts.bootstrap5')
@section('additional-styles')

    @include('cityBook.web.businessOwner.rimay-manager.partials.css.source')

    @include('cityBook.partials.meetclic.partials.css.source')
@endsection
@section('additional-scripts')
    @include('cityBook.web.businessOwner.rimay-manager.partials.js.source')
    @include('cityBook.partials.meetclic.partials.js.source')

@endsection
@section('content')

    @include('cityBook.partials.meetclic.coming_soon')


@endsection
