<script  type="text/javascript">
    var $routesManager={
        "businessDetails":"{{route('businessDetails', app()->getLocale())}}",
        "authorSingle":"{{route('authorSingle', app()->getLocale())}}",

    }


</script>
<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$resourcesPathCompiled = env('APP_IS_SERVER') ? "resources/" : '';

$themePath = $resourcePathServer . 'templates/cityBookHtml/';
$publicAsset = asset(env('APP_IS_SERVER') ? "public" : '');
$rootPage = '';

$allowShop="-1";

if($dataManagerPage['shopConfig']['allow']==false){
    $allowShop="0";
}else{
    $allowShop="1";
}
?>

@yield('script-bootgrid-init')

<script id="manager_frontend_js">

    var $dataManagerPage = <?php echo json_encode($dataManagerPage)?>;
var $allowShop;

    var $language = <?php echo json_encode(isset($dataManagerPage['language']) ? $dataManagerPage['language'] : 'none')?>;
    var $allowUser = "{{isset($dataManagerPage['profileConfig']['success'])?$dataManagerPage['profileConfig']['success']:false}}";
    var $resourceRoot = "{{URL::asset($themePath)}}/";
    var $resourceManagementRoot = "{{URL::asset($publicAsset)}}";

    var $resourcePathServer = "<?php echo(isset($resourcePathServer) ? $resourcePathServer : '')?>";
    var $publicAsset = "<?php echo($publicAsset)?>";

    var $cookiesManager = <?php echo json_encode(isset($pageSectionsConfig['cookies']) ? $pageSectionsConfig['cookies'] : [])?>;
    var $routeRoot = "{{route('urlBase', app()->getLocale())}}";
    var $managerProductBusiness = "{{route('managerProductBusiness', app()->getLocale())}}";
    var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
    var $allowAllInOne = '{{env('allowAllInOne')}}';

    var $shopConfig = <?php echo json_encode($dataManagerPage['shopConfig'])?>;

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

    function initDataShopping() {
        $allowShop=  $shopConfig['allow']?1:0;
    }
    initDataShopping();
</script>

<!-- Main end -->
<!--=============== scripts  ===============-->
@if( isset($dataManagerPage['allowServer']) &&  (!$dataManagerPage['allowServer']))
    <script type="text/javascript" src="{{URL::asset($themePath.'jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset($themePath.'js/plugins.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset($themePath.'js/scripts.js')}}"></script>
@else
    <script type="text/javascript" src="{{URL::asset($themePath.'jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset($themePath.'js/plugins.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset($themePath.'js/scripts.js')}}"></script>
@endif

@if(isset($dataManagerPage['allowVue']) && ($dataManagerPage['allowVue']))
    <script src="{{ URL::asset($resourcePathServer.'assets/js/vendorCityBookUnless.js') }}"></script>
    <script src="{{ URL::asset($resourcePathServer.'js/compiled/AppInit.js') }}"></script>
@endif
@if( isset($dataManagerPage['allowPlugins']['leafletMaps']))
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
@endif
@if( isset($dataManagerPage['allowPlugins']['googleMaps']))

    <script
        src="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}"></script>

    @if( isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' || $dataManagerPage['currentPage']=='listingSingle'|| $dataManagerPage['currentPage']=='contactUs')

        <script type="text/javascript" src="{{URL::asset($themePath.'js/map_infobox.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset($themePath.'js/markerclusterer.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset($themePath.'js/maps.js')}}"></script>
    @endif
@endif
<script type="text/javascript" src="{{URL::asset($resourcePathServer.'js/Utils.js')}}"></script>
<script src="{{ asset($resourcePathServer.'js/eccomerce/ManagementOrders.js') }}" type="text/javascript"></script>


@yield('additional-scripts')
@yield('script')
@yield('script-bottom')
