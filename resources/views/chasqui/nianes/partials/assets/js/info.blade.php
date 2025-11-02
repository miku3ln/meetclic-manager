<?php
$url_path_plugins = "libs/";
?>

<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".partials.assets.js.templateVue";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user
];
?>
@include($wizards_route,$paramsWizard)
<script
    src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
<script
    src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

<script src="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-select/vue-select.js')}}"></script>

<script src="{{ asset($resourcePathServer.$url_path_plugins."bootgrid1.3.1/bootgrid1.3.1.min.js") }}" type="text/javascript"></script>

<script type="text/javascript">
        <?php
        $name_manager = "wulpy";
        ?>
    var model_entity = "{{$model_entity}}";
    var name_manager = "{{$name_manager}}";
    var $dataBusiness = <?php echo json_encode($dataBusiness)?>;
    var $dataCategories = <?php echo json_encode($categories)?>;

</script>
<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/SearchManager.js') }}"
        type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/googleMaps.js') }}" type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/app.js') }}" type="text/javascript"></script>
