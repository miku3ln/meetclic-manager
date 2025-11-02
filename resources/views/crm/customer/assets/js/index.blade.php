<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
<script src="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-select/vue-select.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-datetimepicker/vue-bootstrap-datetimepicker@5.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-date-picker/DateTimePicker.umd.min.js')}}"></script>



<script src="{{ asset($resourcePathServer.'plugins/vue2-timepicker/vue2-timepicker.js')}}"></script>
{{-- BOOTGRID--}}
<script src="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.fa.js')}}"></script>

{{--ALERTS--}}
<script src="{{ asset($resourcePathServer.'plugins/sweetalert/sweetalert.min.js')}}"></script>
{{--scripts MANAGER--}}
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


<script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/components/customer/Customer.js') }}"
        type="text/javascript"></script>


<script src="{{ asset($resourcePathServer.'js/'.$pathCurrent.'/App.js') }}" type="text/javascript"></script>










