<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=array();
@endphp
@include('partials.mangerVueJS',$managerOptions)
@include('partials.plugins.resourcesJs',['bootgrid'=>true])

<script src="{{ asset($resourcePathServer.'libs/vue-datetimepicker/vue-datetimepicker.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-date-picker/DateTimePicker.umd.min.js')}}"></script>

<script src="{{ asset($resourcePathServer.'libs/vue2-timepicker/vue2-timepicker.min.js')}}"></script>

{{--scripts GESTION--}}
<script type="text/javascript">

    var $modelDataManager = <?php echo json_encode($modelDataManager)?>;
    var $configPartial = <?php echo json_encode($configPartial)?>;

</script>
<script src="{{ asset($resourcePathServer.'js/business/manager/Util.js') }}" type="text/javascript"></script>

<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templateVue";
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)

@if ($configPartial['typeManager'] === 'managerEventsTrailsTypeOfCategories')
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsTypeOfCategories.js') }}"
            type="text/javascript"></script>




@elseif ($configPartial['typeManager'] === 'managerEventsTrailsDistances')
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsDistances.js') }}"
            type="text/javascript"></script>

@elseif ($configPartial['typeManager'] === 'managerEventsTrailsTypeTeams')
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsTypeTeams.js') }}"
            type="text/javascript"></script>


@elseif ($configPartial['typeManager'] === 'managerEventsTrailsByKit')
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsByKit.js') }}"
            type="text/javascript"></script>

@elseif ($configPartial['typeManager'] === 'managerEventsTrailsRegistrationPoints')
    @include('partials.plugins.resourcesJs',['axios'=>true])
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsRegistrationPointsDashboard.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/ManagementFormEventDetails.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/eventsTrails/EventsTrailsRegistrationPoints.js') }}"
            type="text/javascript"></script>


@endif



<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>


<script src="{{ asset($resourcePathServer.'js/' .$pathCurrent.'/App.js') }}" type="text/javascript"></script>
