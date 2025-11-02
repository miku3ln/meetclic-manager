<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$resourceRoot = URl(env('APP_IS_SERVER') ? "public" : '');
?>
<script>


    var $resourceRoot = "<?php echo(isset($resourceRoot) ? $resourceRoot : '')?>";
</script>
<script src="{{ asset($resourcePathServer.'js/app.js') }}"></script>
<!-- JAVASCRIPT FILES -->
<script type="text/javascript">var plugin_path = '{{asset($resourcePathServer.'wulpy/assets/plugins')}}/';</script>
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript"
        src="{{asset($resourcePathServer.'wulpy/assets/plugins/jquery/jquery-2.1.4.min.js')}}"></script>

<script type="text/javascript" src="{{asset($resourcePathServer.'wulpy/assets/js/scripts.js')}}"></script>
<script type="text/javascript">var $resourcesCustom = '{{asset('images')}}/';</script>

<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js') }}" type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'wulpy/js/App.js') }}" type="text/javascript"></script>

<script type="text/javascript"
        src="{{asset($resourcePathServer.'wulpy/plugins/MarkerClusterer/MarkerClusterer.js')}}"></script>
<script
    src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}&ext=.js"></script>


<script src="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/vue-select/vue-select.js')}}"></script>

{{-- BOOTGRID--}}
<script src="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.fa.js')}}"></script>

