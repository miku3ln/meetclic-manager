<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
<link href="{{ asset($resourcePathServer.$url_path_plugins."bootgrid1.3.1/bootgrid1.3.1.min.css") }}" rel="stylesheet"
      type="text/css">
@if(isset($toogle))
<link type="text/css"
rel="stylesheet"
href="{{ asset($resourcePathServer.'libs/angular1.5/libs/switch/angular-toggle-switch-bootstrap-3.css')}}"/>
<link type="text/css"
rel="stylesheet"
href="{{ asset($resourcePathServer.'libs/angular1.5/libs/angular-switcher-master/dist/angular-switcher.min.css')}}"/>

@endif

@if(isset($s2Angular))
<link type="text/css"
rel="stylesheet"
href="{{ asset($resourcePathServer.'libs/angular1.5/libs/ui-select2/select2/select2.css')}}"/>


@endif

@if(isset($uiGrid))
<link type="text/css"
rel="stylesheet"
href="{{ asset($resourcePathServer.'libs/angular1.5/libs/ng-grid/ui-grid.min.css')}}"/>


@endif
