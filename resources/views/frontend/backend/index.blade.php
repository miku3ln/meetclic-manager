{{--CMS-BACKEND--VIEW-MAIN --}}
@php


$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';


@endphp
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
@extends('layouts.masterMinton')
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
 <style id="style-additional">
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

    <div class="content-management-process" id="app-management"
         process-name-{{$configPartial['typeManager']}}
    >
<?php echo "<h1 class='not-view'>ALEX {{businessCreate}} {{configModulesAllow}}</h1>" ?>
        @if($configPartial['typeManager']=='managerTemplateSlider' ||$configPartial['typeManager']=='managerActivitiesGamification' ||$configPartial['typeManager']=='managerRewardsGamification' )
            @if($configPartial['typeManager']=='managerActivitiesGamification' )
                <div class="manager-process not-view" id="tab-activities-gamification"
                     v-if="businessCreate && configModulesAllow.activitiesGamification.allow && configModulesAllow.activitiesGamification.active ">
                    @include($partials.'.wizards.templateSlider',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerTemplateSlider' )
                <div class="manager-process not-view" id="tab-template-slider"
                     v-if="businessCreate && configModulesAllow.templateSlider.allow && configModulesAllow.templateSlider.active ">
                    @include($partials.'.wizards.templateSlider',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerRewardsGamification' )
                <div class="manager-process not-view" id="tab-rewards-gamification"
                     v-if="businessCreate && configModulesAllow.rewardsGamification.allow && configModulesAllow.rewardsGamification.active ">
                    @include($partials.'.wizards.templateSlider',[
                    ])

                </div>
            @endif

        @elseif($configPartial['typeManager']=='managerTemplateAboutUs' )
            <div class="manager-process not-view" id="tab-template-about-us"
                 v-if="businessCreate && configModulesAllow.templateAboutUs.allow && configModulesAllow.templateAboutUs.active ">
                @include($partials.'.wizards.templateAboutUs',[
                ])

            </div>
        @elseif($configPartial['typeManager']=='managerTemplatePolicies' )
            <div class="manager-process not-view" id="tab-template-policies"
                 v-if="businessCreate && configModulesAllow.templatePolicies.allow && configModulesAllow.templatePolicies.active ">
                @include($partials.'.wizards.templatePolicies',[
                ])

            </div>
        @elseif($configPartial['typeManager']=='managerTemplateServices' )
            <div class="manager-process not-view" id="tab-template-services"
                 v-if="businessCreate && configModulesAllow.templateServices.allow && configModulesAllow.templateServices.active ">
                @include($partials.'.wizards.templateServices',[
                ])

            </div>

         @elseif($configPartial['typeManager']=='managerTemplateNews' )
            <div class="manager-process not-view" id="tab-template-news"
                 v-if="businessCreate && configModulesAllow.templateNews.allow && configModulesAllow.templateNews.active ">
                @include($partials.'.wizards.templateNews',[
                ])

            </div>
        @elseif($configPartial['typeManager']=='managerTemplateContactUs' )

            <div class="manager-process not-view" id="tab-template-contact-us"
                 v-if="businessCreate && configModulesAllow.templateContactUs.allow && configModulesAllow.templateContactUs.active ">
                @include($partials.'.wizards.templateContactUs',[
                ])

            </div>
        @elseif($configPartial['typeManager']=='managerTemplateConfigMailing' )
            <div>
                hola mailing
            </div>

        @elseif($configPartial['typeManager']=='managerTemplateBySource' )

            <div class="manager-process not-view" id="tab-template-by-source"
                 v-if="businessCreate && configModulesAllow.templateBySource.allow && configModulesAllow.templateBySource.active ">
                @include($partials.'.wizards.templateBySource',[
                ])

            </div>
        @elseif($configPartial['typeManager']=='managerTemplatePayments' )

            <div class="manager-process not-view" id="tab-template-payments"
                 v-if="businessCreate && configModulesAllow.templatePayments.allow && configModulesAllow.templatePayments.active ">
                @include($partials.'.wizards.templatePayments',[
                ])

            </div>
        @endif


    </div>
    @include( $partials . '.actions',[
        'title'=>'Administración de productos'

        ])
@endsection
@section('after-additional-scripts')
    <script id="script-additional">

        $configModulesAllow={
            configModulesAllow:{
                "templateSlider":{
                    active:false,
                    allow:true
                },
                "activitiesGamification":{
                    active:false, allow:true
                },
                "rewardsGamification":{
                    active:false
                    , allow:true
                },
                "templateAboutUs":{
                    active:false
                    , allow:true
                },
                "templatePolicies":{
                    active:false
                    , allow:true
                },
                "templateServices":{
                    active:false
                    , allow:true
                },
                "templateNews":{
                    active:false
                    , allow:true
                },
                "templateContactUs":{
                    active:false
                    , allow:true
                },
                "templateBySource":{
                    active:false
                    , allow:true
                },    "templatePayments":{
                    active:false
                    , allow:true
                },
            },

        };

    </script>
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
