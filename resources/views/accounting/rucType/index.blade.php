@extends('layouts.masterMinton')
@php
    $managerOptions=[
    'pageTitle'=>'Contabilidad',
    'menuParentName'=>'Contabilidad',
    'menuName'=>'Ruc Tipos',
    'grid'=>[
    'renderView'=>'partials.adminViewVue',
    'managerData'=>[
    'title'=>'Ruc Tipos',
    'body'=>''
    ]
    ]
   ];
@endphp
@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection
@section('additional-styles')
    @php
        $managerOptions=array();
    @endphp
    @include('partials.mangerVueCss',$managerOptions)
    @include('partials.plugins.resourcesCss',['bootgrid'=>true])

    <?php
    $partials = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".partials";
    $resources = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.css.info";
    $wizards_route = $resources;
    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "configPartial" => $configPartial
    ];
    ?>

    <style>
        div#container-data canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
@endsection
@section('content')
    {{--
        STEPS MENU Create
        1) Resource Component
        2)Tab Render Component
        3)Partials/Wizards
        4)Render Template  Partials/assets/js/templateVue.blade
        5)Create Template  Partials/assets/js/templates/process/typeProcess
        6)Config Menu  App Main
            6.1) configModulesAllow
            6.2) initMenuCurrent
             6.3) Config Params Variables send to components
            6.4)Events(Click) Config Params Variables send to components [setValuesModelBusiness]
       7)Import Resource Partials/assets/js/index.php
        --}}
    <div id="app-management">
        <div id="tab-rucType">

            @include($partials.'.wizards.rucType',[
              "model"=>$model,

                    ])


        </div>
    </div>


    @include( $partials . '.actions',[


        ])
@endsection
@section('script')

    <?php

    $jsPartial = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.index";

    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "configPartial" => $configPartial

    ];
    ?>
    @include( $jsPartial,$paramsWizard)
@endsection
