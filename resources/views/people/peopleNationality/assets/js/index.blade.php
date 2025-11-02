<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@php
    $managerOptions=array();
@endphp
@include('partials.mangerVueJS',$managerOptions)
@include('partials.plugins.resourcesJs',['bootgrid'=>true])


<script src="{{ asset($resourcePathServer.'libs/vue-select/vue-select.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/vue-datetimepicker/vue-datetimepicker.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-date-picker/DateTimePicker.umd.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/vue2-timepicker/vue2-timepicker.min.js')}}"></script>
{{--scripts GESTION--}}
<script type="text/javascript">
    var model_entity = "{{$model_entity}}";
    var model_entity = "{{$model_entity}}";

</script>
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templateVue";

$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)


<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/peopleNationality/PeopleNationality.js') }}"
        type="text/javascript"></script>


<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>
