<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

<script src="{{ asset($resourcePathServer.'assets/libs/moment/moment.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>

@if(isset($utilsVue))
    @include('partials.pluginsVue.resourcesJs',['utilsVue'=>true])
@endif
