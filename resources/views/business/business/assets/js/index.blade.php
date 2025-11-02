@php
    $managerOptions=array();
@endphp
<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@include('partials.mangerVueJS',$managerOptions)
@include('partials.plugins.resourcesJs',['bootgrid'=>true])

<script type="text/javascript">var plugin_path = '{{asset($resourcePathServer.'wulpy/assets/plugins')}}/';</script>
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
{{--scripts GESTION--}}
<script type="text/javascript">
    var model_entity = "{{$model_entity}}";
    var $configPartial = <?php echo json_encode($configPartial)?>;
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


<script src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/googleMaps.js') }}" type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/business/Business.js') }}"
        type="text/javascript"></script>


<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>
