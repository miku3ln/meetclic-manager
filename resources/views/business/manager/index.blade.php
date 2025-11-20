{{--CONFIG VIEWS ALL -VM-008--}}

{{--BUSINESS-MANAGER-INIT-TEMPLATE-MANAGER--}}
<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

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
@extends('layouts.masterMinton')

@if($configPartial['typeManager']!='managerPointOfSale')
@section('breadcrumb')
    @include('partials.breadcrumb',$managerOptions)
@endsection
@endif

@section('menuCurrent')
    @php
        echo $configPartial['menuHtml'];
    @endphp
@endsection
@section('additional-libs-styles')

@endsection

@section('additional-styles')
    <?php
    $partials = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".partials";
    $model = $step1["model"];
    $frmId = $step1["frmId"];
    $subcategories = $step1["subcategories"];
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.css.index";
    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "configPartial" => $configPartial,
        'configProcess' => $configProcess

    ];
    ?>
    @include($wizards_route,$paramsWizard)
    <link href="{{ asset($resourcePathServer.'css/'.$pathCurrent.'/managerBusiness.css') }}" rel="stylesheet"
          type="text/css">
    <style>
        div#container-data canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .content-row-manager-buttons {

            top: 18% !important;
        }

        div#manager-container {
            margin-top: 7%;
        }

        .add-data-row {
            color: #fff !important;
            width: auto;
            background-color: #00AFF1 !important;
            border-color: #00AFF1 !important;
            position: absolute;
        }


        /*  ---CALENDAR ANGULAR---*/
        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .uib-title {

            color: #ccc !important;
        }

        .uib-months button {
            color: #ccc !important;

        }

        .uib-left {
            color: #ccc !important;
        }

        .uib-right {
            color: #ccc !important;
        }

        .uib-day span {
            color: #98a6ad;
        }


        /*  ---FORM INVOICE---*/
        .lbl-gestion-info {
            color: #666666;
        }

        .lbl-frm-factura {
            font-size: 10pt !important;
        }

        .input--invoice {
            height: 25px !important;
        }

        .input-group-btn--invoice {

            height: 25px !important;
            border-left: 0px solid #00AFF1 !important;
            border-right: 1px solid #00AFF1 !important;
            background: #00AFF1;
            color: #fff;
            width: 25px !important;
        }

        .input-group-btn--invoice button {
            height: 25px !important;
            width: 25px !important;
        }

        .input-group-btn--invoice button i {
            margin-left: -7px;
            margin-top: -7px;
            position: absolute;
        }

        #content-row-filters {
            padding-top: 1px;
            background: #CCCCCC;
            padding-bottom: 6px;
            margin-top: 1.50%;
            margin-bottom: 1.8%;
        }

        span.required {
            color: red;
        }

        .has-error {
            color: #c1272d !important;
        }

        .select-style--customer {
            width: 90% !important;
        }


        div#grid-data {
            width: 100%;
        }
    </style>
    <style>
        .preview-management__people {
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            padding-top: 2%;
            padding-bottom: 2%;
        }

        .management-data {
            height: 244px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
@endsection
@section('content')
    <div class="content-management-process class-content-all all-manager--invoice" id="app-management"
         ng-app='appModuleConfig' process-name-{{$configPartial['typeManager']}}>
        <div ng-controller="controllerManagement as ctrl" class="class-content-all">
            @if($configPartial['typeManager']=='managerRepair'||$configPartial['typeManager']=='managerPointOfSale')

                @include('partials.loading',[])
            @endif
            @if($configPartial['typeManager']=='managerInformation' )
                <div v-view-data class="manager-process not-view" id="tab-business"
                     v-if=" configModulesAllow.information.allow && configModulesAllow.information.active ">
                    @include($partials.'.wizards.information',[
                    "step1"=>$step1

                    ])
                </div>
            @elseif($configPartial['typeManager']=='managerProduct')
                @if($configPartial[$configPartial['typeManager']]['allow'])
                    <div class="manager-process not-view" id="tab-product"
                         v-if="businessCreate && configModulesAllow.product.allow && configModulesAllow.product.active ">
                        @include($partials.'.wizards.product',[
                        ])

                    </div>
                @else
                    @include($configPartial[$configPartial['typeManager']]['partial'],[
              "params"=>$configPartial[$configPartial['typeManager']]['params']
                    ])
                @endif
                {{--BUSINESS-MANAGER-INIT-TEMPLATE-MANAGER--PRODUCT-MANAGER--}}
            @elseif($configPartial['typeManager']=='managerProductManager')

                @if($configPartial[$configPartial['typeManager']]['allow'])
                    <div id="success-view">

                        <div class="manager-process not-view" id="tab-product-manager"
                             v-if="configModulesAllow['productManager'].active  && configModulesAllow['productManager'].allow">
                            @include($partials.'.wizards.productManager',[
        'configProcess'=>$configProcess,

                            ])

                        </div>
                    </div>

                @else
                    <div id="error-view">

                        @include($configPartial[$configPartial['typeManager']]['partial'],[
                  "params"=>$configPartial[$configPartial['typeManager']]['params']
                        ])
                    </div>

                @endif
            @elseif($configPartial['typeManager']=='managerProductService')
                @if($configPartial[$configPartial['typeManager']]['allow'])
                    <div class="manager-process not-view" id="tab-product-service"
                         v-if="businessCreate && configModulesAllow.productService.allow && configModulesAllow.productService.active ">
                        @include($partials.'.wizards.productService',[
                        ])

                    </div>
                @else
                    <div id="error-view">


                        @include($configPartial[$configPartial['typeManager']]['partial'],[
                  "params"=>$configPartial[$configPartial['typeManager']]['params']
                        ])
                    </div>
                @endif
            @elseif($configPartial['typeManager']=='managerBusinessBySchedule')
                <div class="manager-process not-view" id="tab-schedules"
                     v-if="businessCreate && configModulesAllow.businessBySchedule.allow && configModulesAllow.businessBySchedule.active ">

                    @include($partials.'.wizards.schedules',[
              "modelBBS"=>$modelBBS
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerGallery')
                <div class="manager-process not-view" id="tab-gallery"
                     v-if="businessCreate && configModulesAllow.gallery.allow && configModulesAllow.gallery.active ">

                    @include($partials.'.wizards.gallery',[
                     "model"=>$model,
                     "subcategories"=>$subcategories
                           ])

                </div>
            @elseif($configPartial['typeManager']=='managerRoutes')
                <div class="manager-process not-view" id="tab-routes"
                     v-if="businessCreate && configModulesAllow.routes.allow && configModulesAllow.routes.active ">
                    @include($partials.'.wizards.routes',[
                                "model"=>$model,
                                "subcategories"=>$subcategories
                                      ])

                </div>
            @elseif($configPartial['typeManager']=='managerLodging' )
                <div class="manager-process not-view" id="tab-lodging"
                     v-if="businessCreate && configModulesAllow.lodging.allow && configModulesAllow.lodging.active ">

                    @include($partials.'.wizards.lodging',[
        "model"=>$model,
           "subcategories"=>$subcategories

                 ])
                </div>
            @elseif($configPartial['typeManager']=='managerPanorama')
                <div class="manager-process not-view" id="tab-panorama"
                     v-if="businessCreate && configModulesAllow.panorama.allow && configModulesAllow.panorama.active ">

                    @include($partials.'.wizards.panorama',[
                      "model"=>$model,
                      "subcategories"=>$subcategories
                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerLodgingTypeOfRoom')
                <div class="manager-process not-view" id="tab-lodgingTypeOfRoom"
                     v-if="configModulesAllow.lodgingTypeOfRoom.allow && configModulesAllow.lodgingTypeOfRoom.active">

                    @include($partials.'.wizards.lodgingTypeOfRoom',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerLodgingRoomLevels')
                <div class="manager-process not-view" id="tab-lodgingRoomLevels"
                     v-if="configModulesAllow.lodgingRoomLevels.allow && configModulesAllow.lodgingRoomLevels.active">

                    @include($partials.'.wizards.lodgingRoomLevels',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerLodgingRoomFeatures')
                <div class="manager-process not-view" id="tab-lodgingRoomFeatures"
                     v-if="configModulesAllow.lodgingRoomFeatures.allow && configModulesAllow.lodgingRoomFeatures.active">

                    @include($partials.'.wizards.lodgingRoomFeatures',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerLodgingTypeOfRoomByPrice')

                <div class="manager-process not-view" id="tab-lodgingTypeOfRoomByPrice"
                     v-if="businessCreate && configModulesAllow.lodgingTypeOfRoomByPrice.allow && configModulesAllow.lodgingTypeOfRoomByPrice.active">

                    @include($partials.'.wizards.lodgingTypeOfRoomByPrice',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerLodgingStatisticalData')
                <div class="manager-process not-view" id="tab-lodgingStatisticalData"
                     v-if="businessCreate && configModulesAllow.lodgingStatisticalData.allow && configModulesAllow.lodgingStatisticalData.active">
                    @include($partials.'.wizards.lodgingStatisticalData',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerHumanResourcesDepartment')
                {{--HUMAN RESOURCES--}}
                <div class="manager-process not-view" id="tab-humanResourcesDepartment"
                     v-if="businessCreate && configModulesAllow.humanResourcesDepartment.allow && configModulesAllow.humanResourcesDepartment.active">
                    @include($partials.'.wizards.humanResourcesDepartment',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerHumanResourcesOrganizationalChartArea')
                {{--HUMAN RESOURCES--}}
                <div class="manager-process not-view" id="tab-humanResourcesOrganizationalChartArea"
                     v-if="businessCreate && configModulesAllow.humanResourcesOrganizationalChartArea.allow && configModulesAllow.humanResourcesOrganizationalChartArea.active">
                    @include($partials.'.wizards.humanResourcesOrganizationalChartArea',[
                      "model"=>$model,

                            ])
                </div>

            @elseif($configPartial['typeManager']=='managerHumanResourcesScheduleType')
                {{--HUMAN RESOURCES--}}
                <div class="manager-process not-view" id="tab-humanResourcesScheduleType"
                     v-if="businessCreate && configModulesAllow.humanResourcesScheduleType.allow && configModulesAllow.humanResourcesScheduleType.active">
                    @include($partials.'.wizards.payRoll.humanResourcesScheduleType',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerHumanResourcesPermissionType')
                {{--HUMAN RESOURCES--}}
                <div class="manager-process not-view" id="tab-humanResourcesPermissionType"
                     v-if="businessCreate && configModulesAllow.humanResourcesPermissionType.allow && configModulesAllow.humanResourcesPermissionType.active">
                    @include($partials.'.wizards.payRoll.humanResourcesPermissionType',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerWorkPlanningHeader')
                {{--HUMAN RESOURCES--}}
                <div class="manager-process not-view" id="tab-workPlanningHeader"
                     v-if="businessCreate && configModulesAllow.workPlanningHeader.allow && configModulesAllow.workPlanningHeader.active">
                    @include($partials.'.wizards.workPlanningHeader',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerProjectHeader')
                {{--HUMAN RESOURCES--}}
                <div class="manager-process not-view" id="tab-projectHeader"
                     v-if="businessCreate && configModulesAllow.projectHeader.allow && configModulesAllow.projectHeader.active">
                    @include($partials.'.wizards.projectHeader',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerHumanResourcesEmployeeProfile')

                <div class="manager-process not-view" id="tab-humanResourcesEmployeeProfile"
                     v-if="businessCreate && configModulesAllow.humanResourcesEmployeeProfile.allow && configModulesAllow.humanResourcesEmployeeProfile.active">
                    @include($partials.'.wizards.humanResourcesEmployeeProfile',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerCustomer')

                <div class="manager-process not-view" id="tab-customer"
                     v-if="businessCreate && configModulesAllow.customer.allow && configModulesAllow.customer.active">
                    @include($partials.'.wizards.customer',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerCustomerPresentation')

                <div class="manager-process not-view" id="tab-{{$configProcess['entityCamel']}}"
                     v-if="businessCreate && configModulesAllow.customerPresentation.allow && configModulesAllow.customerPresentation.active">
                    @include($partials.'.wizards.customerPresentation',[
                      "model"=>$model,
     "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "modelDataManager" => $modelDataManager,
        "configPartial" => $configPartial,
        'configProcess' => $configProcess
                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerCustomerData')

                <div class="manager-process not-view" id="tab-customer-data"
                     v-if="businessCreate && configModulesAllow.customerData.allow && configModulesAllow.customerData.active">
                    @include($partials.'.wizards.customerData',[
                      "model"=>$model,

                            ])
                </div>
            @elseif($configPartial['typeManager']=='managerEducationalInstitutionAskwerType')

                <div class="manager-process not-view" id="tab-educational-institution-askwer-type"
                     v-if="businessCreate && configModulesAllow.educationalInstitutionAskwerType.allow && configModulesAllow.educationalInstitutionAskwerType.active ">
                    @include($partials.'.wizards.educationalInstitutionAskwerType',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerEducationalInstitutionByBusiness')
                <div class="manager-process not-view" id="tab-educational-institution-by-business"
                     v-if="businessCreate && configModulesAllow.educationalInstitutionByBusiness.allow && configModulesAllow.educationalInstitutionByBusiness.active ">
                    @include($partials.'.wizards.educationalInstitutionByBusiness',[
                    'configPartial'=>$configPartial

                    ])
                </div>

            @elseif($configPartial['typeManager']=='managerEventsTrailsProject')

                <div class="manager-process not-view" id="tab-events-trails-project"
                     v-if="businessCreate && configModulesAllow.eventsTrailsProject.allow && configModulesAllow.eventsTrailsProject.active ">
                    @include($partials.'.wizards.eventsTrailsProject',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerTemplateInformation')
                <div class="manager-process not-view" id="tab-template-information"
                     v-if="businessCreate && configModulesAllow.templateInformation.allow && configModulesAllow.templateInformation.active ">
                    @include($partials.'.wizards.templateInformation',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerTaxByBusiness')

                <div class="manager-process not-view" id="tab-tax-by-business"
                     v-if="businessCreate && configModulesAllow.taxByBusiness.allow && configModulesAllow.taxByBusiness.active ">
                    @include($partials.'.wizards.taxByBusiness',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerBusinessByLanguage')

                <div class="manager-process not-view" id="tab-business-by-language"
                     v-if="businessCreate && configModulesAllow.businessByLanguage.allow && configModulesAllow.businessByLanguage.active ">
                    @include($partials.'.wizards.businessByLanguage',[
                    ])
                </div>
            @elseif($configPartial['typeManager']=='managerOrderPaymentsManager')

                <div class="manager-process not-view" id="tab-order-payments-manager"
                     v-if="configModulesAllow.orderPaymentsManager.allow && configModulesAllow.orderPaymentsManager.active ">
                    @include($partials.'.wizards.orderPaymentsManager',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerRepairProductByBusiness')
                <div class="manager-process not-view" id="tab-repair-product-by-business"
                     v-if="businessCreate && configModulesAllow.repairProductByBusiness.allow && configModulesAllow.repairProductByBusiness.active ">
                    @include($partials.'.wizards.repairProductByBusiness',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByDiscount')
                <div class="manager-process not-view" id="tab-business-by-discount"
                     v-if="businessCreate && configModulesAllow.businessByDiscount.allow && configModulesAllow.businessByDiscount.active ">
                    @include($partials.'.wizards.businessByDiscount',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerBusinessByShippingRate')
                <div class="manager-process not-view" id="tab-business-by-shipping-rate"
                     v-if="businessCreate && configModulesAllow.businessByShippingRate.allow && configModulesAllow.businessByShippingRate.active ">
                    @include($partials.'.wizards.businessByShippingRate',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByGamification')
                <div class="manager-process not-view" id="tab-business-by-gamification"
                     v-if="businessCreate && configModulesAllow.businessByGamification.allow && configModulesAllow.businessByGamification.active ">
                    @include($partials.'.wizards.businessByGamification',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerGamificationTypeActivity')
                <div class="manager-process not-view" id="tab-gamification-type-activity"
                     v-if="businessCreate && configModulesAllow.gamificationTypeActivity.allow && configModulesAllow.gamificationTypeActivity.active ">
                    @include($partials.'.wizards.gamificationTypeActivity',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerAllergies')
                <div class="manager-process not-view" id="tab-allergies"
                     v-if="businessCreate && configModulesAllow.allergies.allow && configModulesAllow.allergies.active ">
                    @include($partials.'.wizards.allergies',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerHabits')
                <div class="manager-process not-view" id="tab-habits"
                     v-if="businessCreate && configModulesAllow.habits.allow && configModulesAllow.habits.active ">
                    @include($partials.'.wizards.habits',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerPatient')
                <div class="manager-process not-view" id="tab-patient"
                     v-if="businessCreate && configModulesAllow.patient.allow && configModulesAllow.patient.active ">
                    @include($partials.'.wizards.patient',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerMailingTemplate')
                <div class="manager-process not-view" id="tab-mailing-template"
                     v-if="businessCreate && configModulesAllow.mailingTemplate.allow && configModulesAllow.mailingTemplate.active ">
                    @include($partials.'.wizards.mailingTemplate',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByHistory')
                <div class="manager-process not-view" id="tab-business-by-history"
                     v-if="businessCreate && configModulesAllow.businessByHistory.allow && configModulesAllow.businessByHistory.active ">
                    @include($partials.'.wizards.businessByHistory',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerBusinessByMenuManagementFrontend')
                <div class="manager-process not-view" id="tab-business-by-menu-management-frontend"
                     v-if="businessCreate && configModulesAllow.businessByMenuManagementFrontend.allow && configModulesAllow.businessByMenuManagementFrontend.active ">
                    @include($partials.'.wizards.businessByMenuManagementFrontend',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByAcademicOfferings')
                <div class="manager-process not-view" id="tab-business-by-academic-offerings"
                     v-if="businessCreate && configModulesAllow.businessByAcademicOfferings.allow && configModulesAllow.businessByAcademicOfferings.active ">
                    @include($partials.'.wizards.businessByAcademicOfferings',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByAcademicOfferingsInstitution')
                <div class="manager-process not-view" id="tab-business-by-academic-offerings-institution"
                     v-if="businessCreate && configModulesAllow.businessByAcademicOfferingsInstitution.allow && configModulesAllow.businessByAcademicOfferingsInstitution.active ">
                    @include($partials.'.wizards.businessByAcademicOfferingsInstitution',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByPartnerCompanies')
                <div class="manager-process not-view" id="tab-business-by-partner-companies"
                     v-if="businessCreate && configModulesAllow.businessByPartnerCompanies.allow && configModulesAllow.businessByPartnerCompanies.active ">
                    @include($partials.'.wizards.businessByPartnerCompanies',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByInformationCustom')
                <div class="manager-process not-view" id="tab-business-by-information-custom"
                     v-if="businessCreate && configModulesAllow.businessByInformationCustom.allow && configModulesAllow.businessByInformationCustom.active ">
                    @include($partials.'.wizards.businessByInformationCustom',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessCounterCustom')
                <div class="manager-process not-view" id="tab-business-counter-custom"
                     v-if="businessCreate && configModulesAllow.businessCounterCustom.allow && configModulesAllow.businessCounterCustom.active ">
                    @include($partials.'.wizards.businessCounterCustom',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByRequirements')
                <div class="manager-process not-view" id="tab-business-by-requirements"
                     v-if="businessCreate && configModulesAllow.businessByRequirements.allow && configModulesAllow.businessByRequirements.active ">
                    @include($partials.'.wizards.business.businessByRequirements',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerBusinessByFrequentQuestion')
                <div class="manager-process not-view" id="tab-business-by-frequent-question"
                     v-if="businessCreate && configModulesAllow.businessByFrequentQuestion.allow && configModulesAllow.businessByFrequentQuestion.active ">
                    @include($partials.'.wizards.business.businessByFrequentQuestion',[
                    ])

                </div>

            @elseif($configPartial['typeManager']=='managerRepair')
                <div class="manager-container not-view" id='manager-container'>
                    @include( $partials . '.wizards.repair',['configPartial'=>$configPartial,'partials'=>$partials])
                </div>
            @elseif($configPartial['typeManager']=='managerPointOfSale')
                <div class="manager-container not-view" id='manager-container'>
                    @include( $partials . '.wizards.sales.pointOfSale.manager',['configPartial'=>$configPartial,'partials'=>$partials])
                </div>
            @elseif($configPartial['typeManager']=='managerInvoiceSale')
                <div class="manager-container not-view" id='manager-container'>
                    @include( $partials . '.wizards.sales.invoice.manager',['configPartial'=>$configPartial,'partials'=>$partials])
                </div>
            @elseif($configPartial['typeManager']=='managerMikrotikRateLimit')
                <div class="manager-process not-view" id="tab-mikrotik-rate-limit"
                     v-if="businessCreate && configModulesAllow.mikrotikRateLimit.allow && configModulesAllow.mikrotikRateLimit.active ">
                    @include($partials.'.wizards.mikrotikRateLimit',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerMikrotikTypeConection')
                <div class="manager-process not-view" id="tab-mikrotik-type-conection"
                     v-if="businessCreate && configModulesAllow.mikrotikTypeConection.allow && configModulesAllow.mikrotikTypeConection.active ">
                    @include($partials.'.wizards.mikrotikTypeConection',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerMikrotikByCustomerEngagement')
                <div class="manager-process not-view" id="tab-mikrotik-by-customer-engagement"
                     v-if="businessCreate && configModulesAllow.mikrotikByCustomerEngagement.allow && configModulesAllow.mikrotikByCustomerEngagement.active ">
                    @include($partials.'.wizards.mikrotikByCustomerEngagement',[
                    ])

                </div>
            @elseif($configPartial['typeManager']=='managerMikrotikDhcpServer')
                <div class="manager-process not-view" id="tab-mikrotik-dhcp-server"
                     v-if="businessCreate && configModulesAllow.mikrotikDhcpServer.allow && configModulesAllow.mikrotikDhcpServer.active ">
                    @include($partials.'.wizards.mikrotikDhcpServer',[
                    ])

                </div>
                @elseif($configPartial['typeManager']=='managerDashboard' )

                    <div class="manager-process not-view" id="tab-template-manager-dashboard"
                    >
                        @include($partials.'.wizards.templateDashboard',[
                        ])

                    </div>
            @endif

        </div>
    </div>
    @include( $partials . '.actions',[
'configProcess'=> $configProcess,

        'title'=>'Administración de productos'

        ])
@endsection
@section('script-down')
    {{--scripts GESTION--}}
    <script>

        var $allowRoutes = '<?php echo env('allowRoutes') ?>';
        var $managerDefaultData =<?php echo json_encode($managerDefaultData) ?>;
        var $menuConfigManager =<?php echo json_encode($menuConfigByRole) ?>;

        var $configModulesAllow = $menuConfigManager.configModulesAllow;
        var $managerProcessBusiness = $menuConfigManager.managerProcessBusiness;
        var $configProcess =<?php echo json_encode($configProcess) ?>;

        var $subcategoriesTotemsDataHtml ='<?php echo isset($subcategoriesTotemsDataHtml)?$subcategoriesTotemsDataHtml:'' ?>';


    </script>

    <?php
    $jsPartial = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.index";
    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "modelDataManager" => $modelDataManager,
        "configPartial" => $configPartial,
        'configProcess' => $configProcess
    ];
    ?>
    @include( $jsPartial,$paramsWizard)
@endsection
