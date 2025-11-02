@section('additional-styles')
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
   {{-- @include($wizards_route,$paramsWizard) ;--}}

    @php
        $managerOptions=array();
    @endphp
    @include('partials.mangerVueCss',$managerOptions)
    @include('partials.plugins.resourcesCss',['bootgrid'=>true])


<style>
        div#container-data canvas {
            width: 100% !important;
            height: 100% !important;
        }
</style>
@endsection
@section('content')
   <div id='app-management'>
      <div id="tab-information-phone-operator">
    @include($partials.".wizards.componentMain",[  "model"=>$model,
                    ])


  </div>
 </div>

  @include( $partials . ".actions",[        ])
@endsection
@section('additional-scripts')
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
