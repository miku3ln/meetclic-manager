<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
<?php
$url_path_plugins = "libs/";
?>
@if(isset($vueDateTimePicker))
    <script src="{{ asset($resourcePathServer.'libs/vue-datetimepicker/vue-datetimepicker.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'plugins/vue-date-picker/DateTimePicker.umd.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/vue2-timepicker/vue2-timepicker.min.js')}}"></script>
@elseif(isset($vueRating))
    <script src="{{ asset($resourcePathServer.'libs/vue-rating/vue-rating.min.js')}}"></script>
@elseif(isset($utilsVue))
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>



@elseif(isset($dateTimePicker))
    <script src="{{ asset($resourcePathServer.'libs/date-time-picker/locale/es.js')}}" type='text/javascript'></script>

    <script src="{{ asset($resourcePathServer.'libs/date-time-picker/bootstrap-datetimepicker.js')}}" type='text/javascript'></script>


@endif

