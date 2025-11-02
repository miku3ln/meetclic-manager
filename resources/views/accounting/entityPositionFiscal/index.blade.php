
@extends('layouts.masterMinton')
@section('breadcrumb')   @include('partials.breadcrumb',$managerOptions)@endsection
@section('additional-styles') 
 @include('partials.mangerVueCss',$managerOptions) @include('partials.plugins.resourcesCss',['bootgrid'=>true])
  <?php 
 $resourcePathServer = env('APP_IS_SERVER') ? 'public/' : '';
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
      <div id="tab-entity-position-fiscal">
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