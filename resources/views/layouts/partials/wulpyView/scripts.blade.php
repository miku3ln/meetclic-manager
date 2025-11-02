<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$resourceRoot = URl(env('APP_IS_SERVER') ? "public" : '');
$publicAsset = URl(env('APP_IS_SERVER') ? "public" : '');

?>
<script>


    var $resourceRoot = "<?php echo(isset($resourceRoot) ? $resourceRoot : '')?>";
    var $resourceManagementRoot = "{{URL::asset($publicAsset)}}";

</script>

<script src="{{ asset($resourcePathServer.'js/app.js') }}"></script>

<!-- JAVASCRIPT FILES -->
<script type="text/javascript">var plugin_path = '{{asset($resourcePathServer.'wulpy/assets/plugins')}}/';</script>
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript" src="{{asset($resourcePathServer.'wulpy/assets/plugins/jquery/jquery-2.1.4.min.js')}}"></script>

<script type="text/javascript" src="{{asset($resourcePathServer.'wulpy/assets/js/scripts.js')}}"></script>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>
<!-- REVOLUTION SLIDER -->
{{--<script type="text/javascript"
        src="{{asset('wulpy/assets/plugins/slider.revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript"
        src="{{ asset('wulpy/assets/plugins/slider.revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('wulpy/assets/js/view/demo.revolution_slider.js')}}"></script>
<!--TOAST---->
<script type="text/javascript" src="{{ asset('metronic/demo/default/custom/components/base/toastr.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>--}}

<!-- JAVASCRIPT FILES -->

<!--begin::Base Scripts -->
<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js') }}" type="text/javascript"></script>

<script src="{{ asset($resourcePathServer.'wulpy/js/App.js') }}" type="text/javascript"></script>
<!-- ADD NEW -->
<!-------Plugins Firebase ---->
<script src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

<script type="text/javascript">var $themeBase = '{{asset($resourcePathServer.'/wulpy')}}/';</script>

{{--OTHERS--}}


<script src="{{ asset($resourcePathServer.'plugins/vue-bootstrap/bootstrap-vue.min.js')}}"></script>
{{-- BOOTGRID--}}
<script src="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.js')}}"></script>
<script src="{{ asset($resourcePathServer.'plugins/bootgrid1.3.1/jquery.bootgrid.fa.js')}}"></script>
