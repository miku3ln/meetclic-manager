<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$resourcesPathCompiled = env('APP_IS_SERVER') ? "resources/" : '';

$themePath = $resourcePathServer . 'templates/eatPura/';
$publicAsset = asset(env('APP_IS_SERVER') ? "public" : '');
$rootPage = '';

$uriAsset = URL::asset($resourcePathServer);

?>
@php
    $allowShop=0;
        if($dataManagerPage['shopConfig']['allow']){
         $allowShop=1;
      }
@endphp
@yield('script-bootgrid-init')
<!-- Bootstrap Bundle Js -->
<script src="{{ URL::asset($themePath.'vender/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Jquery Js -->

<script src="{{ URL::asset($themePath.'vender/jquery/jquery.min.js') }}"></script>
<!-- Slick Slider Js -->

<script src="{{ URL::asset($themePath.'vender/slick/slick/slick.min.js') }}"></script>
<!-- Quantity Custom Js -->

<script src="{{ URL::asset($themePath.'js/quantity.js') }}"></script>
<!-- Custom Js -->

<script src="{{ URL::asset($themePath.'js/script.js') }}"></script>
<script src="{{ URL::asset($publicAsset.'/js/Utils/Manager.js') }}"></script>
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>




<script id="manager_frontend_js">

    function managerPayment(typePayment) {
        var result = false;
        $.each($allowPaymentsData, function (index, value) {
            if (index == typePayment) {
                result = true;
                return result;
            }

        });

        return result;
    }
    var $buttonsConfig = {
        "names": {
            "one": "{{__('config.buttons.one')}}",
            "two": "{{__('config.buttons.two')}}",
            "three": "{{__('config.buttons.three')}}",
            "four": "{{__('config.buttons.four')}}",
            "five": "{{__('config.buttons.five')}}",

        },
    };
    function initUtilsManager() {
        var $UtilCustomer = $managerUtils['UtilCustomer'];
        $utilCustomer = new $UtilCustomer($customerData);
    }

    var $shopConfig = <?php echo json_encode($dataManagerPage['shopConfig'])?>;
    function initDataShopping() {
        $allowShop=  $shopConfig['allow']?1:0;
    }
    function managerModalSelect2() {
        $('span.select2-container').removeClass('select2-container-modal');
        $('span.select2-container').addClass('select2-container-modal');
    }

    var latLngCurrent = {lat: 0.2314799, lng: -78.271874};
    var $greyscale_style = [
        {
            featureType: "road.highway",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "landscape",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "transit",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "poi",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "poi.park",
            stylers: [
                {
                    visibility: "on"
                }
            ]
        },
        {
            featureType: "poi.park",
            elementType: "labels",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "poi.park",
            elementType: "geometry.fill",
            stylers: [
                {
                    color: "#d3d3d3"
                },
                {
                    visibility: "on"
                }
            ]
        },
        {
            featureType: "poi.medical",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "poi.medical",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "road",
            elementType: "geometry.stroke",
            stylers: [
                {
                    color: "#cccccc"
                }
            ]
        },
        {
            featureType: "water",
            elementType: "geometry.fill",
            stylers: [
                {
                    visibility: "on"
                },
                {
                    color: "#cecece"
                }
            ]
        },
        {
            featureType: "road.local",
            elementType: "labels.text.fill",
            stylers: [
                {
                    visibility: "on"
                },
                {
                    color: "#808080"
                }
            ]
        },
        {
            featureType: "administrative",
            elementType: "labels.text.fill",
            stylers: [
                {
                    visibility: "on"
                },
                {
                    color: "#808080"
                }
            ]
        },
        {
            featureType: "road",
            elementType: "geometry.fill",
            stylers: [
                {
                    visibility: "on"
                },
                {
                    color: "#fdfdfd"
                }
            ]
        },
        {
            featureType: "road",
            elementType: "labels.icon",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "water",
            elementType: "labels",
            stylers: [
                {
                    visibility: "off"
                }
            ]
        },
        {
            featureType: "poi",
            elementType: "geometry.fill",
            stylers: [
                {
                    color: "#d2d2d2"
                }
            ]
        }
    ];
    var $methodsShopPage = {}
    var $dataParent = null;
    window.onload = function () {
        initElementsTemplate();
    };
    function initSearch(){
        console.log("$nameRoute",$nameRoute);
    }


    var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;
    var $nameRoute ='<?php echo Route::currentRouteName()?>';


    var $language = <?php echo json_encode(isset($dataManagerPage['language']) ? $dataManagerPage['language'] : 'none') ?>;
    var $allowUser = "{{isset($dataManagerPage['profileConfig']['success'])?$dataManagerPage['profileConfig']['success']:false}}";
    var $resourceRoot = "{{URL::asset($themePath)}}/";
    var $resourceManagementRoot = "{{URL::asset($publicAsset)}}";

    var $resourcePathServer = "<?php echo(isset($resourcePathServer) ? $resourcePathServer : '') ?>";
    var $publicAsset = "<?php echo($publicAsset) ?>";

    var $uriAsset = "<?php echo($uriAsset) ?>";
    var $cookiesManager = <?php echo json_encode(isset($pageSectionsConfig['cookies']) ? $pageSectionsConfig['cookies'] : []) ?>;
    var $routeRoot = "{{route('urlBase', app()->getLocale())}}";
    var $managerProductBusiness = "{{route('managerProductBusiness', app()->getLocale())}}";
    var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined') ?>;
    var $allowAllInOne = '{{env('allowAllInOne')}}';
    var $allowShop = '{{$allowShop}}';
    var $rootPage = "{{asset($rootPage)}}";
    var $rootUrl = '{{URL('').'/'.app()->getLocale()}}';

    var $formValidationsLabels = {
        "required": "{{__('validation.required',['attribute'=>''])}}",
        "url": "{{__('validation.url',['attribute'=>''])}}",
        "email": "{{__('validation.email',['attribute'=>''])}}",
        "unique": "{{__('validation.unique',['attribute'=>''])}}",


    };

    var $labelsData = {
        'business': {
            'product': [
                "{{__('labels.business-details.product.one')}}",
                "{{__('labels.business-details.product.two')}}",
                "{{__('labels.business-details.product.three')}}",
            ],
            'e-ccomerce': {
                'buttons': [
                    "{{ __('config.buttons.one') }}",
                    "{{ __('frontend.shop.manager.buttons.add') }}",
                ]
            }
        }
    };
    var $dataPage = <?php echo json_encode(isset($dataManagerPage['dataPage']) ? $dataManagerPage['dataPage'] : []) ?>;



    function ajaxRequest(url, params, hasFileUpload) {
        var type = params.hasOwnProperty("type") ? params.type : 'GET';
        var blockElement = params.hasOwnProperty("blockElement") ? params.blockElement : null;
        var data = params.hasOwnProperty("data") ? params.data : [];
        var error_message = params.hasOwnProperty("error_message") ? params.error_message : 'Ha ocurrido un error durante la petición, inténtelo nuevamente.';
        var loading_message = params.hasOwnProperty("loading_message") ? params.loading_message : 'Cargando...';
        var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        var processData = true;
        if (typeof hasFileUpload !== 'undefined' && hasFileUpload) {
            contentType = false;
            processData = false;

            var formData = new FormData();

            Object.entries(data).forEach(([key, value]) => {
                formData.append(key, value);
            });
            data = formData;
        }
        blockElement ? blockContainer(blockElement, loading_message) : blockPage(loading_message);
        var isUpload = (typeof hasFileUpload !== 'undefined' && hasFileUpload);
        var tokenInformation = $('meta[name="csrf-token"]').attr('content');
        var managerSendFunctions = {
            type: type,
            blockElement: blockElement,
            data: data,
            error_message: error_message,
            loading_message: loading_message,
            contentType: contentType,
            processData: processData,
            isUpload: isUpload,
            params: params
        };

        var paramsConfig = (isUpload) ? {
            url: url,
            type: type,
            // Form data
            //datos del formulario
            data: data,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: contentType,
            processData: processData,
            headers: {
                'X-CSRF-TOKEN': tokenInformation
            },
            beforeSend: function (jqXHR, settings) {
                if (params.hasOwnProperty("beforeSend")) {
                    params.beforeSend(jqXHR, settings);
                }
            },
            error: function (data) {
                blockElement ? unblockContainer(blockElement) : unblockPage();
                //Error messages from server
                if (data.hasOwnProperty('status') && data.hasOwnProperty('message')) {
                    showAlert(data.status, data.message);
                } else { //Error messages from frontend
                    showAlert('error', error_message);
                }
                if (params.hasOwnProperty("error_callback")) {
                    params.error_callback(data);
                }
            },
            success: function (data) {
                successFunctionResult(managerSendFunctions, data);
            },
            complete: function () {
                blockElement ? unblockContainer(blockElement) : unblockPage();
                if (params.hasOwnProperty("complete_callback")) {
                    params.complete_callback();
                }
            }
        } : {
            url: url,
            type: type,
            dataType: 'json',
            data: data,
            contentType: contentType,
            processData: processData,
            headers: {
                'X-CSRF-TOKEN': tokenInformation
            },
            beforeSend: function (jqXHR, settings) {
                if (params.hasOwnProperty("beforeSend")) {
                    params.beforeSend(jqXHR, settings);
                }
            },
            error: function (data) {
                blockElement ? unblockContainer(blockElement) : unblockPage();
                //Error messages from server
                if (data.hasOwnProperty('status') && data.hasOwnProperty('message')) {
                    showAlert(data.status, data.message);
                } else { //Error messages from frontend
                    showAlert('error', error_message);
                }
                if (params.hasOwnProperty("error_callback")) {
                    params.error_callback(data);
                }
            },
            success: function (data) {
                successFunctionResult(managerSendFunctions, data);
            },
            complete: function () {
                blockElement ? unblockContainer(blockElement) : unblockPage();
                if (params.hasOwnProperty("complete_callback")) {
                    params.complete_callback();
                }
            }
        };
        $.ajax(paramsConfig);
    }

    //util
    function blockContainer(el, label) {
        mApp.block(el, {
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            message: label
        });
    }
    function unblockPage() {
        mApp.unblockPage();
    }

    function unblockContainer(el) {
        mApp.unblock(el);
    }
    $(function(){
        initSearch();
    })
</script>

<!-- Main end -->
<!--=============== scripts  ===============-->
@if( isset($dataManagerPage['allowServer']) &&  (!$dataManagerPage['allowServer']))

@else

@endif
<script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>
<script src="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer."assets/js/pages/toastr.init.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
<script src="{{ asset($resourcePathServer.'js/common_code.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/developersUtil.js') }}" type="text/javascript"></script>
@yield('additional-scripts-vue-before')
@if( isset($dataManagerPage['allowPlugins']['googleMaps']) && $dataManagerPage['allowPlugins']['googleMaps'])

    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>

    @if( isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' || $dataManagerPage['currentPage']=='listingSingle'|| $dataManagerPage['currentPage']=='contactUs')

        <script type="text/javascript" src="{{URL::asset($themePath.'js/map_infobox.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset($themePath.'js/markerclusterer.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset($themePath.'js/maps.js')}}"></script>
    @endif
@endif
@if(isset($dataManagerPage['allowVue']) && ($dataManagerPage['allowVue']))


    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="{{URL::asset($resourcePathServer.'js/mixImport/AppInitBundle.js')}}"></script>
    <script src="{{URL::asset($resourcePathServer.'js/mixImport/AppManagerImportBundle.js')}}"></script>
    @yield('additional-init-script-vue')
    <script src="{{URL::asset($resourcePathServer.'js/eatPura/AppMain.js')}}"></script>

@endif

@yield('additional-before-scripts-vue')
<script type="text/javascript" src="{{URL::asset($resourcePathServer.'js/Utils.js')}}"></script>


@yield('additional-scripts')
@yield('script')
@yield('script-bottom')
