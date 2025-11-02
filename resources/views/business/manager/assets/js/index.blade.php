{{-- CPP-006--}}
{{-- BUSINESS-MANAGER-IMPORT-JS--}}

@php
    $managerOptions=array();
    $managerOptionsPlugins=array();
    $managerOptionsPluginsVue=array();
$managerOptionsPlugins['bootgrid']=true;

@endphp
<?php
$assetsTemplateMintonUpdate='templates/minton/';
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
<?php
$url_path_plugins = "libs/";
$imgExample = asset($resourcePathServer . 'images/backend/sections/panorama/01.jpg');
$dataPanorama = array(
    array("src" => $imgExample)
);
$dateCurrentData = $modelDataManager["dateCurrentData"];
?>
{{-- INIT CONFIG GET JS-PROCESS  VM-006 --}}

{{--scripts GESTION--}}
<script type="text/javascript">
    var $wulpyme_user_id ={{($user->id)}};
    var model_entity = "{{$model_entity}}";
    var $modelDataManager = <?php echo json_encode($modelDataManager)?>;
    var $dataPanorama = <?php echo json_encode($dataPanorama)?>;
    var $dateCurrentData = <?php echo json_encode($dateCurrentData)?>;
    var $configPartial = <?php echo json_encode($configPartial)?>;
    var $dataManagerPage = <?php echo json_encode($dataManagerPage)?>;

    var dateStringCurrent = $dateCurrentData["format"].split(" ")[0];
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    var eventsDate = [{
        date: tomorrow,
        status: 'full'
    }];
    var $businessManager=<?php echo (isset($modelDataManager["business"]) && count($modelDataManager["business"])>0) ?json_encode($modelDataManager["business"][0]):[]?>;

</script>

<script src="{{ asset($resourcePathServer.'js/' .$pathCurrent.'/UtilCustom.js') }}" type="text/javascript"></script>
@if (!in_array($configPartial['typeManager'] ,$allowProcessAngular) )
    @include('partials.mangerVueJS')
    @include('partials.plugins.resourcesJs',$managerOptionsPlugins)

    {{--frameworks VUE JS PLUGINS--}}
    @if ($configPartial['typeManager'] != 'managerEducationalInstitutionByBusiness' && $configPartial['typeManager'] != 'managerBusinessByDiscount')
        @include('partials.pluginsVue.resourcesJs',['vueDateTimePicker'=>true])
    @endif

    @if ($configPartial['typeManager'] === 'managerEducationalInstitutionByBusiness')

    @endif

    @if ( $configPartial['typeManager'] === 'managerCustomerPresentation' ||$configPartial['typeManager'] === 'managerInformation'|| $configPartial['typeManager'] === 'managerRoutes'|| $configPartial['typeManager'] === 'managerCustomer'   || $configPartial['typeManager'] === 'managerCustomerData'  || $configPartial['typeManager'] ===  'managerLodging'|| $configPartial['typeManager'] ==null)
        @include('partials.plugins.resourcesJs',['googleMaps'=>true])

        @if ($configPartial['typeManager'] === 'managerRoutes')
            @include('partials.plugins.resourcesJs',['geoxml3'=>true])
        @endif
        @if ($configPartial['typeManager'] === 'managerInformation' ||$configPartial['typeManager'] === 'managerRoutes' )
            <script
                src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/googleMaps.js') }}"
                type="text/javascript"></script>
        @endif
        {{--highcharts--}}
    @elseif ($configPartial['typeManager'] === 'managerLodgingStatisticalData')
        @include('partials.plugins.resourcesJs',['highcharts'=>true])
    @elseif ($configPartial['typeManager'] === 'managerPanorama')
        @include('partials.plugins.resourcesJs',['threeJs'=>true])

    @endif
    @include('partials.plugins.resourcesJs',['sweetAlert'=>true])
    {{--ALERTS--}}
    <?php
    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templateVue";
    $paramsWizard = [
        "model_entity" => $model_entity,
        "pathCurrent" => $pathCurrent,
        "user" => $user,
        "configPartial" => $configPartial,
        'configProcess'=> $configProcess
    ];
    ?>
    @include($wizards_route,$paramsWizard)
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    {{--RESOURCES BY MANAGER TYPE--}}
    @if ($configPartial['typeManager'] === 'managerRoutes')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/Routes.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerBusinessBySchedule')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessBySchedule.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerPanorama')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/Panorama.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerGallery')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/Gallery.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerLodging' || $configPartial['typeManager'] ==null)
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingByTypeOfRoom.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingByPayment.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingByArrived.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingDelivery.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingRoomsState.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/Lodging.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerLodgingStatisticalData')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingStatisticalData.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerLodgingRoomLevels')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingRoomLevels.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerLodgingRoomFeatures')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingRoomFeatures.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerLodgingTypeOfRoomByPrice')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingTypeOfRoomByPrice.js') }}"
            type="text/javascript"></script>

    @elseif ($configPartial['typeManager'] === 'managerLodgingTypeOfRoom')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/housing/LodgingTypeOfRoom.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerHumanResourcesDepartment')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesDepartment.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesDepartmentByManager.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerHumanResourcesOrganizationalChartArea')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesDepartmentByOrganizationalChartArea.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesOrganizationalChartArea.js') }}"
            type="text/javascript"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesOrganizationChartAreaByManager.js') }}"
            type="text/javascript"></script>

    @elseif ($configPartial['typeManager'] === 'managerHumanResourcesEmployeeProfile')
        @include('partials.plugins.resourcesJs',['axios'=>true])
        @include('partials.plugins.resourcesJs',['googleMaps'=>true])
        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationAddress.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationPhone.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationMail.js') }}"
                type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationSocialNetwork.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/BusinessByEmployeeProfile.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesEmployeeProfile.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/humanResources/HumanResourcesDepartmentByOrganizationalChartArea.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerWorkPlanningHeader')
        @include('partials.plugins.resourcesJs',['axios'=>true])


        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/workPlanning/WorkPlanningHeader.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/workPlanning/WorkPlanningHeaderByResources.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerProjectHeader')
        @include('partials.plugins.resourcesJs',['axios'=>true])


        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/projects/ProjectHeader.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/projects/ProjectHeaderByResources.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerCustomer')
        @include('partials.plugins.resourcesJs',['axios'=>true])

        {{--BUSINESS-MANAGER-CRM-DELIVERY-JS--}}
        <script src="{{ asset($resourcePathServer.'plugins/code-bar/jquery-barcode.js') }}" type="text/javascript"></script>

        <script src="{{ asset($resourcePathServer.'plugins/printjs/demo/jquery.PrintArea.js') }}" type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/deliveryByBusinessManager/deliveryByBusinessManager.js') }}"
            type="text/javascript"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationAddress.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationPhone.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationMail.js') }}"
                type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationSocialNetwork.js') }}"
            type="text/javascript"></script>
        {{--CRM--}}
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/crm/MailingByDataSend.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/crm/Customer.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerCustomerPresentation')
        @include('partials.plugins.resourcesJs',['axios'=>true])

        {{--BUSINESS-MANAGER-CRM-CUSTOMER-PRESENTATION-JS--}}
        <script src="{{ asset($resourcePathServer.'plugins/code-bar/jquery-barcode.js') }}" type="text/javascript"></script>

        <script src="{{ asset($resourcePathServer.'plugins/printjs/demo/jquery.PrintArea.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/prosecutorOffice/AddDataCustomer.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/prosecutorOffice/CustomerPresentation.js') }}"
                type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerCustomerData')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationAddress.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationPhone.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationMail.js') }}"
                type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/information/InformationSocialNetwork.js') }}"
            type="text/javascript"></script>
        {{--CRM--}}
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/crm/MailingByDataSend.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/crm/EventByAssistance.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/crm/CustomerData.js') }}"
                type="text/javascript"></script>

    @elseif ($configPartial['typeManager'] === 'managerEducationalInstitutionAskwerType')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/EducationalInstitutionAskwerType.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerEducationalInstitutionByBusiness')

        @include('partials.pluginsVue.resourcesJs',['vueRating'=>true])
        <script src="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/jquery-ui.min.js')}}"></script>
        <script src="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/jquery-confirm.min.js')}}"></script>
        <script>

            jQuery.browser = {};
            (function () {
                jQuery.browser.msie = false;
                jQuery.browser.version = 0;
                if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                    jQuery.browser.msie = true;
                    jQuery.browser.version = RegExp.$1;
                }
            })();
        </script>
        {{--<script src="{{ asset($resourcePathServer.'angular1.5/libs/switch/angular-toggle-switch.min.js')}}"></script>--}}
        {{--knockout--}}
        <script src="{{ asset($resourcePathServer.'libs/askwer/Knockout/framework/knockout-3.0.0.js')}}"></script>
        <script src="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/bootstrap-editable.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'libs/askwer/Knockout/framework/knockout.x-editable.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'libs/askwer/Knockout/framework/knockout-sortable.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'libs/askwer/Knockout/framework/knockout.validation.min.js')}}"></script>
        <script src="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/jquery.autosize.min.js')}}"></script>
        <script src="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/jquery.validate.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/fancybox/jquery.fancybox-1.3.4.pack.js')}}"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/educationalInstitutionByBusiness/formAskwer.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/educationalInstitutionByBusiness/option.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/educationalInstitutionByBusiness/field.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/educationalInstitutionByBusiness/section.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/educationalInstitutionByBusiness/askwer.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/educationalInstitution/educationalInstitutionByBusiness/EducationalInstitutionByBusiness.js') }}"
            type="text/javascript"></script>

    @elseif($configPartial['typeManager'] === 'managerEventsTrailsProject')
        {{--EVENTS TRAILS--}}
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsProject.js') }}"
            type="text/javascript"></script>

    @elseif($configPartial['typeManager'] === 'managerTemplateInformation')
        {{--EVENTS TRAILS--}}
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateInformation.js') }}"
                type="text/javascript"></script>

    @elseif($configPartial['typeManager'] === 'managerTaxByBusiness')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/tax/TaxByBusiness.js') }}"
                type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByLanguage')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/language/BusinessByLanguage.js') }}"
                type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByHistory')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByHistory/BusinessHistoryByData.js') }}"
            type="text/javascript"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByHistory/BusinessByHistory.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByAcademicOfferings')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByAcademicOfferings/BusinessAcademicOfferingsByData.js') }}"
            type="text/javascript"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByAcademicOfferings/BusinessAcademicOfferingsDataByInformation.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByAcademicOfferings/BusinessByAcademicOfferings.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByAcademicOfferingsInstitution')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByAcademicOfferingsInstitution/BusinessByAcademicOfferingsInstitution.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByMenuManagementFrontend')

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByMenuManagementFrontend.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByPartnerCompanies')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByPartnerCompanies.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByInformationCustom')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByInformationCustom.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessCounterCustom')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessCounterCustom/BusinessCounterCustomByData.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessCounterCustom/BusinessCounterCustom.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByFrequentQuestion')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByFrequentQuestion.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByRequirements')

        <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/BusinessByRequirements.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerProduct')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/products/ProductByRouteMap.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/products/ProductByMultimedia.js') }}"
                type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/products/language/LanguageProduct.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/products/ProductSaveDataInputOutput.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/products/Product.js') }}"
                type="text/javascript"></script>

    @elseif($configPartial['typeManager'] === 'managerProductManager')
        <!--BUSINESS-MANAGER-IMPORT-JS--PRODUCT-MANAGER-->

        <script src="{{ asset($resourcePathServer.'/templates/minton/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>

        <script src="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate.'assets/libs/quill/quill.min.js')}}"></script>
        <script src="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate.'assets/libs/dropzone/dropzone.js')}}"></script>
        <script src="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate.'assets/js/pages/form-fileuploads.init.js')}}"></script>

        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/BusinessByProductsParent.js') }}"
                type="text/javascript"></script>

        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductParent.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductParentByPackageParams.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductParentByPrices.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductByMetaData.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductManager.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductByLogInventory.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductParentByProduct.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductByRouteMap.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductByMultimedia.js') }}"
                type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/language/LanguageProduct.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/ProductSaveDataInputOutput.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productManager/Product.js') }}"
                type="text/javascript"></script>

    @elseif($configPartial['typeManager'] === 'managerProductService')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/productsService/Product.js') }}"
                type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerOrderPaymentsManager')

        @include('partials.plugins.resourcesJs',['bootstrapColorpicker'=>true])

        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/orders/ViewOrder.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/orders/BankReviewOrder.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/orders/DeliverOrder.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/orders/OrderPaymentsManager.js') }}"
                type="text/javascript"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/orders/BusinessByInventoryManagement.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/orders/BusinessByInventoryManagementSubcategory.js') }}"
            type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerRepairProductByBusiness')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/fix/RepairProductByBusiness.js') }}"
                type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerBusinessByDiscount')

        @include('partials.pluginsVue.resourcesJs',['dateTimePicker'=>true])
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/discounts/BusinessByDiscount/DiscountByProducts.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/discounts/BusinessByDiscount.js') }}"
                type="text/javascript"></script>

    @elseif ($configPartial['typeManager'] === 'managerBusinessByShippingRate')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/shippingRate/BusinessByShippingRate.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerBusinessByGamification')

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/gamification/GamificationByRewards.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/gamification/GamificationByProcess.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/gamification/BusinessByGamification.js') }}"
            type="text/javascript"></script>


    @elseif ($configPartial['typeManager'] === 'managerGamificationTypeActivity')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/gamification/GamificationTypeActivity.js') }}"
            type="text/javascript"></script>
        {{--
        HOSPITAL--}}
    @elseif ($configPartial['typeManager'] === 'managerAllergies')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/Allergies.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerHabits')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/Habits.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerPatient')

        <script src="{{ asset($resourcePathServer.'libs/pdfmaker/pdfmake.min.js')}}"></script>
        <script src="{{ asset($resourcePathServer.'libs/pdfmaker/vfs_fonts.js')}}"></script>

        <script src="{{ asset($resourcePathServer.$url_path_plugins."snap-svg/snap-svg.js") }}"
                type="text/javascript"></script>
        @include('partials.plugins.resourcesJs',['googleMaps'=>true])
        @include('partials.plugins.resourcesJs',['googleMapsCluster'=>true])
        @include('partials.plugins.resourcesJs',['croppie'=>true])


        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/antecedents/AntecedentByHistoryClinic.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/paymentTreatments/TreatmentPayment.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/paymentTreatments/TreatmentByIndebtednessPayingInit.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/MedicalConsultationByPatient.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/TreatmentByPatient.js') }}"
            type="text/javascript"></script>

        <!--ODONTOGRAM-->
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/odontogram/OdontogramApi.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/OdontogramByPatient.js') }}"
            type="text/javascript"></script>

        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/documents/Certificate.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/hospital/Patient.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerMailingTemplate')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/mailing/MailingTemplate.js') }}"
                type="text/javascript"></script>

    @elseif ($configPartial['typeManager'] === 'managerMikrotikRateLimit')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/mikrotik/MikrotikRateLimit.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerMikrotikTypeConection')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/mikrotik/MikrotikTypeConection.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerMikrotikDhcpServer')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/mikrotik/MikrotikDhcpServer.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerMikrotikByCustomerEngagement')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/mikrotik/MikrotikByCustomerEngagement.js') }}"
            type="text/javascript"></script>

    @elseif ($configPartial['typeManager'] === 'managerHumanResourcesScheduleType')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/payRoll/HumanResourcesScheduleType.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerHumanResourcesPermissionType')
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/payRoll/HumanResourcesPermissionType.js') }}"
            type="text/javascript"></script>
    @elseif ($configPartial['typeManager'] === 'managerDashboard')
        <script
            src="{{ asset($resourcePathServer.'plugins/higcharts-2024/highcharts.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/data.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/annotations.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/exporting.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/export-data.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'plugins/higcharts-2024/modules/accessibility.js') }}"
            type="text/javascript"></script>
        <script
            src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/dashboard/Dashboard.js') }}"
            type="text/javascript"></script>
    @endif



    <script src="{{ asset($resourcePathServer.'js/' .$pathCurrent.'/Util.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/' .$pathCurrent.'/App.js') }}" type="text/javascript"></script>
    {{-- END CONFIG GET JS-PROCESS  VM-006 --}}

@else
    @if($configPartial['typeManager'] === 'managerRepair')

        @include('partials.plugins.resourcesJs',$managerOptionsPlugins)
        @include('partials.angular.mangerResourcesJs',[
            "uiGrid"=>true,
            "toogle"=>true,
            "s2Angular"=>true])

        <script src="{{ asset($resourcePathServer.'js/UtilInvoice.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/fix/CustomerManager.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/fix/InvoiceManager.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/fix/App.js') }}"
                type="text/javascript"></script>

    @elseif($configPartial['typeManager'] === 'managerPointOfSale')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/UtilManager.js') }}" type="text/javascript"></script>
        @include('partials.plugins.resourcesJs',$managerOptionsPlugins)
        @include('partials.angular.mangerResourcesJs',[
            "uiGrid"=>true,
            "toogle"=>true,
            "s2Angular"=>true])
        <script src="{{ asset($resourcePathServer.'plugins/printjs/demo/jquery.PrintArea.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/UtilInvoice.js') }}" type="text/javascript"></script>

        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/pointOfSale/Grids.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/pointOfSale/Modal.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/pointOfSale/Pdf.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/pointOfSale/Print.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/pointOfSale/S2.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/pointOfSale/App.js') }}"
                type="text/javascript"></script>
    @elseif($configPartial['typeManager'] === 'managerInvoiceSale')
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/UtilManager.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'plugins/ladda/js/spin.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'plugins/ladda/js/ladda.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'plugins/ladda/js/ladda.jquery.min.js') }}" type="text/javascript"></script>

        @include('partials.plugins.resourcesJs',$managerOptionsPlugins)
        @include('partials.angular.mangerResourcesJs',[
            "uiGrid"=>true,
            "toogle"=>true,
            "s2Angular"=>true])
        <script src="{{ asset($resourcePathServer.'plugins/printjs/demo/jquery.PrintArea.js') }}" type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/invoice/Bootgrid.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/invoice/Grids.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/invoice/S2.js') }}"
                type="text/javascript"></script>
        <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/sales/invoice/App.js') }}"
                type="text/javascript"></script>


    @endif

    <script src="{{ asset($resourcePathServer.'js/UtilAngular.js') }}" type="text/javascript"></script>

@endif
