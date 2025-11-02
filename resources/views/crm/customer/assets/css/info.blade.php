<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
<?php
$url_path_plugins = "metronic/plugins/";
?>
{{-----BOOTGRID PLUGIN--}}
<link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/css/jquery.bootgrid.css") }}" rel="stylesheet"
      type="text/css">

<link href="{{ asset($resourcePathServer."plugins/vue-date-picker/DateTimePicker.css") }}" rel="stylesheet"
      type="text/css">
