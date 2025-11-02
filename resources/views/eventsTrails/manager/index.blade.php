<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';

?>
@php
    $managerOptions=[
    'pageTitle'=>'Administracion',
             'menuParentName'=>'Administracion',
           'menuName'=>'Recepcion',
                      'menuName'=>'Recepcion',
'title'=>'Recepcion',
 'icon'=>'<i class="flaticon-cogwheel-2"></i>',
    'id_table'=>'user_table',
    'action_buttons'=>[
        [
        'label'=>'Crear',
        'icon'=>'<i class="la la-plus"></i>',
        'handler_js'=>'newUser()',
        'color'=>'btn-primary'
        ],
      ],
      'modal'=>[
    'title'=>'Crear Usuario',
    'id'=>'modal',
    'size'=>'modal-lg',
    'action_buttons'=>[
        [
        'id'=>'btn_save',
        'label'=>'Guardar',
        'handler_js'=>'saveUser()',
        'color'=>'btn-primary'
        ],
     ]
    ]
   ];
@endphp
@extends('layouts.eventsTrailsBackend')
@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection
@section('menuCurrent')
    @php
        echo $configPartial['menuHtml'];
    @endphp
@endsection

@section('additional-styles')
    <?php
    $partials = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".partials";
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.css.info";
    $paramsWizard = [
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "configPartial" => $configPartial
    ];


    ?>
    @include($wizards_route,$paramsWizard)
    <link href="{{ asset($resourcePathServer.'css/'.$pathCurrent.'/manager.css') }}" rel="stylesheet"
          type="text/css">
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

    <div class="content-management-process" id="app-management">

        @if($configPartial['typeManager']=='managerEventsTrailsTypeOfCategories' )

            <div class="manager-process not-view" id="tab-events-trails-type-of-categories"
                 v-if="businessCreate && configModulesAllow.eventsTrailsTypeOfCategories.allow && configModulesAllow.eventsTrailsTypeOfCategories.active ">
                @include($partials.'.wizards.eventsTrailsTypeOfCategories',[
                ])

            </div>


        @elseif ($configPartial['typeManager'] === 'managerEventsTrailsDistances')
            <div class="manager-process not-view" id="tab-events-trails-distances"
                 v-if="businessCreate && configModulesAllow.eventsTrailsDistances.allow && configModulesAllow.eventsTrailsDistances.active ">
                @include($partials.'.wizards.eventsTrailsDistances',[
                ])

            </div>
        @elseif ($configPartial['typeManager'] === 'managerEventsTrailsTypeTeams')

            <div class="manager-process not-view" id="tab-events-trails-type-teams"
                 v-if="businessCreate && configModulesAllow.eventsTrailsTypeTeams.allow && configModulesAllow.eventsTrailsTypeTeams.active ">
                @include($partials.'.wizards.eventsTrailsTypeTeams',[
                ])

            </div>

        @elseif ($configPartial['typeManager'] === 'managerEventsTrailsByKit')
            <div class="manager-process not-view" id="tab-events-trails-by-kit"
                 v-if="businessCreate && configModulesAllow.eventsTrailsByKit.allow && configModulesAllow.eventsTrailsByKit.active ">
                @include($partials.'.wizards.eventsTrailsByKit',[
                ])

            </div>
        @elseif ($configPartial['typeManager'] === 'managerDashboard')
            <div class="manager-process " id="tab-dashboard"
                 v-if="businessCreate && configModulesAllow.dashboard.allow && configModulesAllow.dashboard.active ">
                DASHBOARD

            </div>
        @elseif ($configPartial['typeManager'] === 'managerEventsTrailsRegistrationPoints')

            {{-- 2)Tab Render Component --}}
            <div class="manager-process not-view" id="tab-events-trails-registration-points"
                 v-if="businessCreate && configModulesAllow.eventsTrailsRegistrationPoints.allow && configModulesAllow.eventsTrailsRegistrationPoints.active ">
                @include($partials.'.wizards.eventsTrailsRegistrationPoints',[
                ])

            </div>


        @endif


    </div>
    @include( $partials . '.actions',[
        'title'=>'Administración de productos'

        ])
@endsection
@section('script')


    <?php

    $jsPartial = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.index";

    $paramsWizard = [
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "modelDataManager" => $modelDataManager,
        "configPartial" => $configPartial

    ];
    ?>
    @include( $jsPartial,$paramsWizard)
@endsection
