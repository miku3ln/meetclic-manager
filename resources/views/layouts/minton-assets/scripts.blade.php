<!-- BUSINESS-MANAGER-TEMPLATE-SCRIPTS -->

<?php
$mintonUpdate = true;
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$resourceRoot = URl(env('APP_IS_SERVER') ? "public" : '');
?>
<script id="manager_backend_js">

</script>
<div class="management-apis">
    <div class="google-api"
         source="https://maps.google.com/maps/api/js?key={{env('APP_GOOGLE_MAPS_KEY')}}&{{env('APP_GOOGLE_MAPS_BOOKSTORE')}}">

    </div>
    <div class="google-api-markers"
         source="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">

    </div>
    <div class="slick"
         source-one="{{ URL::asset($resourcePathServer.'libs/slick/slick.css') }}"
         source-two="{{ URL::asset($resourcePathServer.'libs/slick/slick-theme.css') }}"
         source-three="{{ URL::asset($resourcePathServer.'libs/slick/slick.js') }}">

    </div>


</div>
<script type="text/javascript">var $resourcesCustom = '{{asset($resourcePathServer.'images')}}/';</script>

<script id="layout-minton">
    var $resourceRoot = "<?php echo(isset($resourceRoot) ? $resourceRoot : '') ?>";
    var $publicAsset = "<?php echo(isset($resourceRoot) ? $resourceRoot : '') ?>";

    var $notImageUrl = "{{$resourceRoot.'/wulpy'}}/assets/images/not-image.png";
    var $urlBase = "<?php echo(route("urlBase")) ?>";
    var $allowPlugins = <?php echo json_encode(isset($allowPlugins)?$allowPlugins:[]) ?>;
    var $type = <?php echo json_encode($type) ?>;
</script>
<script type="text/javascript">var plugin_path = '{{asset($resourcePathServer.'wulpy/assets/plugins')}}/';</script>
<script type="text/javascript">var pathDevelopers = '{{asset($resourcePathServer.'wulpy/developers')}}/';</script>
@if($type==0)
    <script id="vendorBusiness-type-2" src="{{ URL::asset($resourcePathServer.'assets/js/vendor.min.js') }}"></script>
    @if(isset($allowPlugins) && isset($allowPlugins['bootstrap5']) && $allowPlugins['bootstrap5'])
        <script src="{{ URL::asset($resourcePathServer.'libs/bootstrapv5.0.2/bootstrapv5.3.0.min.js') }}"></script>
    @endif

@elseif($type==1)
    <script id="vendorBusiness-type-1"
            src="{{ URL::asset($resourcePathServer.'assets/js/vendorBusiness.min.js') }}"></script>

    <script src="{{ URL::asset($resourcePathServer.'libs/bootstrap3.3.1222/bootstrap.min.js') }}"></script>

@elseif($type==2)
    <script src="{{ URL::asset($resourcePathServer.'assets/js/vendorBusiness.min.js') }}"></script>

@endif
<script src="{{ URL::asset($resourcePathServer.'js/compiled/AppInit.js') }}"></script>

<script src="{{ URL::asset($resourcePathServer.'assets/js/app.min.js') }}"></script>
{{--TOAST--}}

@yield('additional-scripts')

<script src="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.js") }}"></script>
<script src="{{ URL::asset($resourcePathServer."assets/js/pages/toastr.init.js") }}"></script>


<script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
<script src="{{ URL::asset($resourcePathServer.'libs/customscrollbar/customscrollbar.min.js') }}"></script>


<script src="{{ URL::asset($resourcePathServer.'libs/jquery-validation/jquery-validation.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js') }}" type="text/javascript"></script>
<script src="{{ asset($resourcePathServer.'js/common_code.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>
<script src="{{ asset($resourcePathServer.'js/developersUtil.js') }}" type="text/javascript"></script>
<script id="scripts-after-scripts" src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>
@yield('after-additional-scripts')

@if($type==0)

@elseif($type==1 || $type==2)
    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-validation/jquery-validation.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/developers/UtilCustom.js') }}" type="text/javascript"></script>
    <script src="{{ asset($resourcePathServer.'js/common_code.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset($resourcePathServer.'libs/jquery-select2/jquery-select2.min.js') }}"></script>
    <script src="{{ asset($resourcePathServer.'js/developersUtil.js') }}" type="text/javascript"></script>
@endif
<script src="{{ asset($resourcePathServer.'js/compiled/plugins/plugin-zebra.js') }}" type="text/javascript"></script>

@yield('script-down')
<script>
    function _managerMenuGrid(index, menu) {
        var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
        this._managerRowGrid(params);
    }


    var now_url = window.location.href;
    var array = now_url.split("/");
    var my_item_index = array.length - 1;
    if (array[my_item_index] == 'layouts-sidebar-sm') {
        document.body.setAttribute('class', '');
        document.body.classList.add('left-side-menu-sm');
    } else if (array[my_item_index] == 'layouts-dark-sidebar') {
        document.body.setAttribute('class', '');
        document.body.classList.add('left-side-menu-dark');
    } else if (array[my_item_index] == 'layouts-light-topbar') {
        document.body.setAttribute('class', '');
        document.body.classList.add('left-side-menu-dark');
        document.body.classList.add('topbar-light');
    } else if (array[my_item_index] == 'layouts-sidebar-collapsed') {
        document.body.setAttribute('class', '');
        document.body.classList.add('enlarged');
    } else if (array[my_item_index] == 'layouts-boxed') {
        document.body.setAttribute('class', '');
        document.body.classList.add('enlarged');
        document.body.classList.add('boxed-layout');
    } else {

    }

    function preloader_fun() {
        document.getElementById("if_need_loader").style.display = "block";
        document.getElementById("preloader").style.display = "block";
        document.getElementById("status").style.display = "block";
        setTimeout(function () {
            document.getElementById("if_need_loader").style.display = "none";
        }, 1500);
    }
</script>

@yield('script-bottom')
