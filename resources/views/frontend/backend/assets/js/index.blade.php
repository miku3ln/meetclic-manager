<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=array();
@endphp
@include('partials.mangerVueJS',$managerOptions)
@include('partials.plugins.resourcesJs',['bootgrid'=>true])

@if ($configPartial['typeManager'] === 'managerTemplateAboutUs' ||$configPartial['typeManager'] ==="managerTemplateServices" ||$configPartial['typeManager'] ==="managerTemplatePolicies" ||$configPartial['typeManager'] ==="managerTemplatePayments")
    <script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>
@elseif($configPartial['typeManager'] === 'managerTemplateSlider'    ||$configPartial['typeManager']=='managerActivitiesGamification' ||$configPartial['typeManager']=='managerRewardsGamification' )
    <script src="{{ asset($resourcePathServer.'assets/libs/nestable2/nestable2.min.js')}}"></script>
@elseif($configPartial['typeManager'] === 'managerTemplateContactUs' )

    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/geoxml3/geoxml3.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/blitz-gmap-editor/blitz-gmap-editor.min.js')}}"></script>

    <script
        src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/googleMaps.js') }}"
        type="text/javascript"></script>
@endif
<script src="{{ asset($resourcePathServer.'libs/vue-datetimepicker/vue-datetimepicker.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-date-picker/DateTimePicker.umd.min.js')}}"></script>

<script src="{{ asset($resourcePathServer.'libs/vue2-timepicker/vue2-timepicker.min.js')}}"></script>

{{--scripts GESTION--}}
<script type="text/javascript">

    var $modelDataManager = <?php echo json_encode($modelDataManager)?>;
    var $configPartial = <?php echo json_encode($configPartial)?>;

</script>
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templateVue";
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)

@if ($configPartial['typeManager'] === 'managerTemplateSlider'    ||$configPartial['typeManager']=='managerActivitiesGamification' ||$configPartial['typeManager']=='managerRewardsGamification')
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/language/LanguageTemplateSliderByImages.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateSlider/TemplateSliderByImages.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateSlider/TemplateSlider.js') }}"
            type="text/javascript"></script>


@elseif($configPartial['typeManager']=='managerTemplateAboutUs' )
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateAboutUs/TemplateAboutUsByData.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/language/LanguageTemplateAboutUsByData.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/language/LanguageTemplateAboutUs.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateAboutUs/TemplateAboutUs.js') }}"
            type="text/javascript"></script>
@elseif($configPartial['typeManager']=='managerTemplatePolicies' )
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/language/LanguageTemplatePolicies.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplatePolicies.js') }}"
            type="text/javascript"></script>
@elseif($configPartial['typeManager']=='managerTemplateServices' )

    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateServices/TemplateServicesByData.js') }}"
            type="text/javascript"></script>


    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/language/LanguageTemplateServices.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/language/LanguageTemplateServicesByData.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateServices/TemplateServices.js') }}"
            type="text/javascript"></script>

@elseif($configPartial['typeManager']=='managerTemplateNews' )
<script src="{{ asset($resourcePathServer.'assets/libs/summernote/summernote.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateNews/TemplateNewsByData.js') }}"
            type="text/javascript"></script>


    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateNews/TemplateNews.js') }}"
            type="text/javascript"></script>



@elseif($configPartial['typeManager']=='managerTemplateConfigMailing' )

@elseif($configPartial['typeManager']=='managerTemplateContactUs' )
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/Map.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateContactUs/Business.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateContactUs/TemplateConfigMailingByEmails.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateContactUs/InformationSocialNetwork.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateContactUs/InformationSocialNetwork.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateContactUs/TemplateChatApi.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateContactUs/TemplateContactUs.js') }}"
            type="text/javascript"></script>
@elseif($configPartial['typeManager']=='managerTemplateBySource' )
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateBySource/SourceLogoMain.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateBySource/SourceFavicon.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplateBySource/TemplateBySource.js') }}"
            type="text/javascript"></script>
@elseif($configPartial['typeManager']=='managerTemplatePayments' )
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/frontend/TemplatePayments.js') }}"
            type="text/javascript"></script>

@endif



<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>


<script src="{{ asset($resourcePathServer.'js/' .$pathCurrent.'/App.js') }}" type="text/javascript"></script>
