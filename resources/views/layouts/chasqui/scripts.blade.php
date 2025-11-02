<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$resourceRoot = URl(env('APP_IS_SERVER') ? "public" : '');
$publicAsset = URl(env('APP_IS_SERVER') ? "public" : '');


?>

<!-- Vendor JS -->
<script id="layout-chasqui">

    var $allowUser = "{{isset($dataManagerPage['profileConfig']['success'])?$dataManagerPage['profileConfig']['success']:false}}";
    var $formValidationsLabels = {
        "required": "{{__('validation.required',['attribute'=>''])}}",
        "url": "{{__('validation.url',['attribute'=>''])}}",
        "email": "{{__('validation.email',['attribute'=>''])}}",
        "unique": "{{__('validation.unique',['attribute'=>''])}}",


    };
    var $dataManagerPage = <?php echo json_encode(isset($dataManagerPage) ? $dataManagerPage : [])?>;
    var $language = <?php echo json_encode(isset($dataManagerPage['language']) ? $dataManagerPage['language'] : 'none')?>;
    var $cookiesManager = <?php echo json_encode(isset($pageSectionsConfig['cookies']) ? $pageSectionsConfig['cookies'] : [])?>;
    var $resourceRoot = "<?php echo(isset($resourceRoot) ? $resourceRoot : '')?>";
    var $resourceManagementRoot = "{{URL::asset($publicAsset)}}";


</script>
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>

@yield('script-bootgrid-init')

@if(isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='chasqui'||$dataManagerPage['currentPage']=='routeView' )

    <script src="{{ URL::asset($resourcePathServer.'frontend/assets/js/vendors.js')}}"></script>
    <script src="{{ URL::asset($resourcePathServer.'assets/js/vendor/frontend.min.js') }}"></script>
    <script src="{{ URL::asset($resourcePathServer.'js/compiled/AppInit.js') }}"></script>
@else
    <script src="{{ URL::asset($resourcePathServer.'frontend/assets/js/vendors.js')}}"></script>
@endif
<script src="{{ URL::asset($resourcePathServer.'frontend/assets/js/active.js')}}"></script>

<!-- Active JS -->

<!--=====  End of JS files ======-->
<!-- Revolution Slider JS -->
@if(isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='home')
    <script
        src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
    <script
        src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/revolution-active.js')}}"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
    <script type="text/javascript"
            src="{{ URL::asset($resourcePathServer.'frontend/assets/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>

@endif

{{--TOAST--}}
<script src="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer."assets/js/pages/toastr.init.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
<script src="{{ asset($resourcePathServer.'js/developersUtil.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/common_code.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'frontend/assets/js/ManagerPages.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js') }}" type="text/javascript"></script>
@if(isset($dataManagerPage['chat']))
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v5.0'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endif
@yield('additional-scripts')
@yield('script')


@yield('script-bottom')
