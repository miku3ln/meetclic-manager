<?php
$url_path_plugins = "libs/";
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';

?>

<link type="text/css" rel="stylesheet"
      href="{{ asset($resourcePathServer.'libs/date-time-picker/bootstrap-datetimepicker-standalone.css')}}"/>
<link type="text/css" rel="stylesheet"
      href="{{ asset($resourcePathServer.'libs/date-time-picker/bootstrap-datetimepicker.css')}}"/>
