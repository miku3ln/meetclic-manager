<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

@section('additional-styles')
    <?php

    $partials = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".partials";
    $wizards_route = $partials . ".assets.css.info";
    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "configPartial" => $configPartial
    ];
    ?>
    @include($wizards_route,$paramsWizard)
    <link href="{{ asset($resourcePathServer.'css/'.$pathCurrent.'/business.css') }}" rel="stylesheet"
          type="text/css">
@endsection


@section('content')
    <div id="app-management">

        @include($partials.'.wizards.search-manager',[

                                 ])
        <div id="map">

        </div>

    </div>


    @include( $partials . '.actions',[
      'title'=>'Administración de productos'

      ]);

@endsection
@section('additional-scripts')
    <?php

    $jsPartial = $partials . ".assets.js.info";

    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "configPartial" => $configPartial,
        "name_manager" => $name_manager,
        "categories" => $categories

    ];
    ?>
    @include( $jsPartial,$paramsWizard)

@endsection
