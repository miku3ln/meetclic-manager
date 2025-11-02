@extends('layouts.masterMinton')
@php
    $managerOptions=[
    'pageTitle'=>'Contabilidad',
    'menuParentName'=>'Contabilidad',
    'menuName'=>'Cuentas',
    'grid'=>[
    'renderView'=>'partials.adminViewVue',
    'managerData'=>[
    'title'=>'Cuentas',
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
        "modelEntity" => $modelEntity,
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
    <div id='app-management'>
        <div id="tab-caja-tipo-billete">
            @include($partials.".wizards.componentMain",[  "model"=>$model,
                            ])


        </div>
    </div>

    @include( $partials . ".actions",[        ])
@endsection
@section('script')
    <?php
    $jsPartial = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.index";

    $paramsWizard = [
        "pathCurrent" => $pathCurrent,
        "configPartial" => $configPartial

    ];
    ?>

    @include( $jsPartial,$paramsWizard)
@endsection
