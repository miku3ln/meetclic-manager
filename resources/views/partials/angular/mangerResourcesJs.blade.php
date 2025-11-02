

<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>

<script src="{{ asset($resourcePathServer.'assets/libs/moment/moment.min.js')}}"></script>
{{-- BOOTGRID--}}
<script src="{{ asset($resourcePathServer.'libs/bootgrid1.3.1/bootgrid1.3.1.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/framework/angular.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/angular-modal/angular-animate.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/angular-modal/angular-aria.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/angular-modal/angular-material.min.js')}}"></script>

<script src="{{ asset($resourcePathServer.'libs/angular1.5/framework/angular-touch.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/framework/angular-modal-service.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/sanitize/angular-sanitize.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/bs3/ui-bootstrap.js')}}"></script>
@if(isset($uiGrid))
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/ng-grid/ui-grid.min.js')}}"></script>
@endif

@if(isset($toogle))
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/switch/angular-toggle-switch.min.js')}}"></script>
@endif

@if(isset($s2Angular))
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/ui-select2/select2/select2.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/angular1.5/libs/ui-select2/angular-ui-select2/select2.js')}}"></script>

@endif
