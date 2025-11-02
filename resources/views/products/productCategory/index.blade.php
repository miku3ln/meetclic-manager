<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@extends('layouts.masterMinton')
@section('css')
    <?php
     $partials = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".partials";
    $resources = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.css.info";
    $wizards_route = $resources;
    $paramsWizard = [

        "pathCurrent" => $pathCurrent,
        "configPartial" => $configPartial
    ];
    ?>
   {{-- @include($wizards_route,$paramsWizard) ;--}}
{{-----BOOTGRID PLUGIN--}}
<link href="{{ asset($resourcePathServer."libs/bootgrid1.3.1/bootgrid1.3.1.min.css") }}" rel="stylesheet"type="text/css">


<style>
        div#container-data canvas {
            width: 100% !important;
            height: 100% !important;
        }
</style>
@endsection
@section('content')
   <div id='app-management'>
      <div id="tab-product-category">
    @include($partials.".wizards.componentMain",[  "model"=>$model,
                    ])


  </div>
 </div>

  @include( $partials . ".actions",[        ])
@endsection
@section('after-additional-scripts')
<?php
    $jsPartial = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.index";

    $paramsWizard = [
        "pathCurrent" => $pathCurrent,
        "configPartial" => $configPartial

    ];
    ?>

 @include( $jsPartial,$paramsWizard)
 @endsection
