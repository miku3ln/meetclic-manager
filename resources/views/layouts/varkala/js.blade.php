<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$publicAsset = asset(env('APP_IS_SERVER') ? "public" : '');
$allowProcessVue = [
    'eventDetails',
    'checkout',
    'productDetails',
    'refundCreditCard',
    'home','shop',
    'checkoutDetails'

];
$rootPage = '';
?>


    <!-- JavaScript files-->
<script>
    // ------------------------------------------------------- //
    //   Inject SVG Sprite -
    //   see more here
    //   https://css-tricks.com/ajaxing-svg-sprite/
    // ------------------------------------------------------ //
    function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function (e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }

    // this is set to Bootstrapious website as you cannot
    // inject local SVG sprite (using only 'icons/orion-svg-sprite.3f375885.svg' path)
    // while using file:// protocol
    // pls don't forget to change to your domain :)
    injectSvgSprite('https://demo.bootstrapious.com/varkala/1-1/icons/orion-svg-sprite.svg');
    injectSvgSprite('https://demo.bootstrapious.com/varkala/1-1/icons/varkala-clothes.svg');
    injectSvgSprite('https://demo.bootstrapious.com/varkala/1-1/img/shape/blob-sprite.svg');

</script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/jquery.min.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/bootstrap.bundle.min.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/swiper-bundle.min.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/bootstrap-select.min.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/aos.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/custom-scrollbar-init.f148089f.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/smooth-scroll.polyfills.min.js"></script>
<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/ofi.min.js"></script>

<script src="{{asset($resourcePathServer.$resourcesTemplateInit)}}/js/countdown.782bfd78.js"></script>
<script>
    var deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000);
    var countdown = new Countdown('countdown', deadline);

</script>
<!-- Some theme config-->
<script>
    var options = {
        navbarExpandPx: 992
    }

</script>

@yield('additional-scripts')
@yield('script')
@yield('script-bottom')
@yield('script-bootgrid-init')
<script id="layout-frontend">
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

    var $routeRoot = "{{route('urlBase', app()->getLocale())}}";
    var $managerProductBusiness = "{{route('managerProductBusiness', app()->getLocale())}}";
    var $managerProductBusinessBalances = "{{route('shopBalances', app()->getLocale())}}";
    var $managerProductBusinessOutlets = "{{route('shopOutlets', app()->getLocale())}}";
    var $rootPage = "{{asset($rootPage)}}";
    var $rootUrl='{{URL('').'/'.app()->getLocale()}}';

    var $buttonsConfig = {
        "names": {
            "one": "{{__('config.buttons.one')}}",
            "two": "{{__('config.buttons.two')}}",
            "three": "{{__('config.buttons.three')}}",
            "four": "{{__('config.buttons.four')}}",
            "five": "{{__('config.buttons.five')}}",

        },
    };

</script>
@if(env('allow_firebase'))
    <script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
    <script>
        var config = {
            apiKey: "{{env('apiKey')}}",
            authDomain: "{{env('authDomain')}}",
            databaseURL: "{{env('databaseURL')}}",
            projectId: "{{env('projectId')}}",
            storageBucket: "{{env('storageBucket')}}",
            messagingSenderId: "{{env('messagingSenderId')}}"
        };
        firebase.initializeApp(config);
    </script>
    <script src="{{ asset($resourcePathServer.'js/frontend/web/CountPages.js') }}" type="text/javascript"></script>
    <script>
        if (Object.keys($dataManagerPage).length > 0) {

            managerCountsPage('{{csrf_token()}}', $dataManagerPage['currentPage']);
        }
    </script>
@endif
<script>
    $allow_firebase = "{{env('allow_firebase')}}";
</script>
{{--TOAST--}}
<script src="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer."assets/js/pages/toastr.init.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
<script src="{{ asset($resourcePathServer.'js/developersUtil.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/common_code.js') }}" type="text/javascript"></script>
@if(env('allowRoutes'))
    <script src="{{ asset($resourcePathServer.'js/eccomerce/OrdersRoutes.js') }}" type="text/javascript"></script>
@else
    <script src="{{ asset($resourcePathServer.'js/eccomerce/Orders.js') }}" type="text/javascript"></script>

@endif
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
