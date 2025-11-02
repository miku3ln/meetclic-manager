<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
<?php
$url_path_plugins = "metronic/plugins/";
?>
<link href="{{ asset($resourcePathServer.'metronic/plugins/wizard/wizard.css') }}" rel="stylesheet"
      type="text/css">
{{-----BOOTGRID PLUGIN--}}
<link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid/css/jquery.bootgrid.css") }}" rel="stylesheet"
      type="text/css">
