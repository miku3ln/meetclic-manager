

<?php
$url_path_plugins = "wulpy/plugins/";
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
<script type="text/javascript">
        <?php
        $name_manager = "wulpy";
        ?>
    var model_entity = "{{$model_entity}}";
    var name_manager = "{{$name_manager}}";

</script>
<script type="text/javascript">


    var $dataBusiness = <?php echo json_encode($dataBusiness)?>;
    var $dataCategories= <?php echo json_encode($categories)?>;

</script>
<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/Components/SearchManager.js') }}" type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/googleMaps.js') }}" type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/app.js') }}" type="text/javascript"></script>
