@extends('layouts.masterMinton')
@php
    $managerOptions=[
    'pageTitle'=>'Contabilidad',
    'menuParentName'=>'Contabilidad',
    'menuName'=>'Modulos',
    'grid'=>[
    'renderView'=>'partials.adminViewVue',
    'managerData'=>[
    'title'=>'Modulos',
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
   <div id='app-management'>
      <div id="tab-accounting-config-modules-account-by-account">
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
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "configPartial" => $configPartial

    ];
    ?>

 @include( $jsPartial,$paramsWizard)
 @endsection
