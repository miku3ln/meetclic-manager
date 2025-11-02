<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$url_path_plugins = 'libs/';

$configPartial = $dataManagerPage['viewData']['configPartial'];
$partials = $configPartial['moduleMain'] . '.' . $configPartial['moduleFolder'] . '.partials';
$pathCurrent = $dataManagerPage['viewData']['pathCurrent'];
$user = $dataManagerPage['viewData']['user'];
$model_entit = $dataManagerPage['viewData']['model_entity'];
$categories = $dataManagerPage['viewData']['categories'];
$name_manager = $dataManagerPage['viewData']['name_manager'];
$model_entity = $dataManagerPage['viewData']['model_entity'];
$dataBusiness = $dataManagerPage['viewData']['dataBusiness'];

$wizards_route = $partials . ".assets.css.info";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "configPartial" => $configPartial,
    "dataBusiness" => $dataBusiness,
    "categories" => $categories,
    'resourcePathServer' => $resourcePathServer
];
?>
@extends('layouts.chasqui')

@section('additional-styles')



    @include($wizards_route,$paramsWizard)
    <link href="{{ asset($resourcePathServer.'css/'.$pathCurrent.'/business.css') }}" rel="stylesheet"
          type="text/css">

@endsection
@section('additional-scripts')


    <?php
    $jsPartial = $partials . ".assets.js.info";

    ?>
    @include( $jsPartial,$paramsWizard)
@endsection
@section('content')
    <div id="app-management" class="wide-layout-map section-space">

        @include($partials.'.wizards.search-manager',[])

        <div class="box-layout-map-container">
            <div class="google-map google-map--style-2" id="map"></div>
        </div>

    </div>
    <?php
    $partialCurrent = $partials . ".actions";

    ?>
    @include( $partialCurrent,$paramsWizard)
@endsection
