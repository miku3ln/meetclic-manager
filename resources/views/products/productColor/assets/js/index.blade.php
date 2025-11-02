<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
@include('partials.mangerVueJS',['utilsVue'=>true])
{{-- BOOTGRID--}}
<script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/vue/color/vue-color.min.js')}}"></script>





{{--scripts MANAGER--}}
<script type="text/javascript">
    var $configPartial =<?php echo json_encode($configPartial)?>
</script>
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templateVue";
$paramsWizard = [
    "pathCurrent" => $pathCurrent,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/Main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/language/LanguageProductColor.js')}}"
        type='text/javascript'></script>

<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js')}}" type='text/javascript'></script>
