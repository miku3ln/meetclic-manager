<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>
    <!DOCTYPE html>
<?php
$nameRoute = Route::currentRouteName();
$activeHome = 'not-active';
$activeAboutUs = 'not-active';
$activeServices = 'not-active';
$activeContactUs = 'not-active';
$activeShop = 'not-active';
$activePages = 'not-active';
$activeActivities = 'not-active';
$activeRewards = 'not-active';
$classTop = 'header-area header-area--default header-area--default--white header-sticky';

if ($nameRoute == 'home' || $nameRoute == 'urlBase') {
    $activeHome = 'active';
    $classTop = 'header-area header-area--default header-area--default--transparent header-sticky';

} else if ($nameRoute == 'aboutUs') {
    $activeAboutUs = 'active';
    $activePages = 'active';

} elseif ($nameRoute == 'contactUs') {
    $activeContactUs = 'active';
    $activePages = 'active';

} elseif ($nameRoute == 'services') {
    $activeServices = 'active';
    $activePages = 'active';

} elseif ($nameRoute == 'shop' || $nameRoute == 'productDetails' || $nameRoute == 'eventDetails' || $nameRoute == 'checkout' || $nameRoute == 'cart') {

    $activeShop = 'active';

} elseif ($nameRoute == 'activities') {

    $activeActivities = 'active';
    $classTop = 'header-area header-area--default header-area--default--transparent header-sticky';


} elseif ($nameRoute == 'rewards') {

    $activeRewards = 'active';
    $classTop = 'header-area header-area--default header-area--default--transparent header-sticky';

}
?>


<html
    class="no-js" <?php echo $pageSectionsConfig['contactTop']['language']['view'] ? ' lang="' . $dataManagerPage['languageHeader']['language'] . '"   xml:lang="' . $dataManagerPage['languageHeader']['language'] . '"' : ''?>>

@include('layouts.partials.headMeta')
<head>

    @include('layouts.chaskishimi.styles',['dataManagerPage'=>$dataManagerPage,
'pageSectionsConfig'=>$pageSectionsConfig])

</head>

<body>

<!--====================  header area ====================-->
<!-- Pre-loader -->
<div id="preloader">
    <div id="status">
        <div class="bouncingLoader">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
@include('layouts.partials.menuTop')

<!--====================  End of call to action area  ====================-->
<div class="content-manager-render">
    @yield('content')
</div>
@if(isset($dataManagerPage['chat']))
    {{$dataManagerPage['chat']}}
@endif
<!--====================  footer ====================-->
@if(isset($dataFooter))
    @include('layouts.chaskishimi.footer-area',['dataFooter'=>$dataFooter,'dataManagerPage'=>$dataManagerPage,'activeHome'=>$activeHome,
'activePages'=>$activePages,
'activeAboutUs'=>$activeAboutUs,
'activeContactUs'=>$activeContactUs,
'activeServices'=>$activeServices,
'activeShop'=>$activeShop,
'activeActivities'=>$activeActivities,
'activeRewards'=>$activeRewards,
'pageSectionsConfig'=>$pageSectionsConfig
])
@else
    @include('layouts.chaskishimi.footer-area',['dataManagerPage'=>$dataManagerPage,'activeHome'=>$activeHome,
'activePages'=>$activePages,
'activeAboutUs'=>$activeAboutUs,
'activeContactUs'=>$activeContactUs,
'activeServices'=>$activeServices,
'activeShop'=>$activeShop,
'activeActivities'=>$activeActivities,
'activeRewards'=>$activeRewards,
'pageSectionsConfig'=>$pageSectionsConfig
])

@endif

<!--====================  End of footer  ====================-->
<!--====================  offcanvas items ====================-->

<!--=======  offcanvas mobile menu  =======-->
@include('layouts.partials.menuMobile')

<!--=======  End of offcanvas mobile menu  =======-->

<!--====================  End of offcanvas items  ====================-->
<!--=======  search overlay  =======-->

<div class="search-overlay" id="search-overlay" style="display: none">

    <!--=======  close icon  =======-->

    <span class="close-icon search-close-icon">
        <a href="javascript:void(0)" id="search-close-icon">
            <i class="pe-7s-close"></i>
        </a>
    </span>

    <!--=======  End of close icon  =======-->

    <!--=======  search overlay content  =======-->

    <div class="search-overlay-content">
        <div class="input-box">
            <form id="search-data-form" action="{{URL(app()->getLocale().'/'.'shop')}}">
                <input id="needle" type="search" placeholder="{{__('frontend.home.search.product.place-holder')}}">
            </form>
        </div>
        <div class="search-hint">
            <span>{{__('frontend.home.search.product.search-hint')}}</span>
        </div>
    </div>

    <!--=======  End of search overlay content  =======-->
</div>

<!--=======  End of search overlay  =======-->
<!--=============================================
=            quick view         =
=============================================-->
@include('layouts.partials.quick-view-product',['dataMenu'=>$dataMenu,
'pageSectionsConfig'=>$pageSectionsConfig])

<!--=====  End of quick view  ======-->
<!-- scroll to top  -->
<button class="scroll-top">
    <i class="fa fa-angle-up"></i>
</button>

@include('layouts.partials.shop.cart',array('typeManagerButton'=>1))
@include('layouts.chaskishimi.scripts',['dataManagerPage'=>$dataManagerPage,
'pageSectionsConfig'=>$pageSectionsConfig])

<div class="modal fade" id="modal-data-preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div></div>

@if($pageSectionsConfig['business']['view'])

    <a id="whatsapp-contact__a" target="blank"  class="chat-widget-button-content"
       data="{{json_encode($pageSectionsConfig['business']['data'])}}" text="{{env('textMsgButtonWhatsApp')}}">
        <div class="chat-widget-button chat-widget-button--bee" id="whatsapp-contact"><i
                class="fa fa-whatsapp"></i>
            <span>Compra por Whatsapp
        </span>
        </div>
    </a>
@endif
@yield('script-modal')
</body>

</html>
