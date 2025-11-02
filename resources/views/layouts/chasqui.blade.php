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
$classTop = 'header-area header-area--default header-area--default--white header-sticky';

if ($nameRoute == 'home') {
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

} elseif ($nameRoute == 'shop' || $nameRoute == 'productDetails' || $nameRoute == 'checkout' || $nameRoute == 'cart') {

    $activeShop = 'active';

}


?>


<html
    class="no-js" <?php echo $pageSectionsConfig['contactTop']['language']['view'] ? ' lang="' . $dataManagerPage['languageHeader']['language'] . '"   xml:lang="' . $dataManagerPage['languageHeader']['language'] . '"' : ''?>>


<head>
    <meta charset="utf-8"/>

    @if(isset($pageSectionsConfig['head'])&& $pageSectionsConfig['head']['metaData']['view'])
        {!!  $pageSectionsConfig['head']['metaData']['html']!!}
    @else

        <title>{{(isset($pageSectionsConfig['head']['business'])&&$pageSectionsConfig['head']['business']['view'] )?$pageSectionsConfig['head']['business']['data']->title:env('APP_NAME_FRONTEND')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @if(isset($pageSectionsConfig['head']['business'])&&$pageSectionsConfig['head']['business']['view'] )
            <meta name='title'
                  content='{{$pageSectionsConfig['head']['business']['data']->title}}'/>
            @if($pageSectionsConfig['head']['business']['data']->description!='')
                <meta name='description'
                      content='{{$pageSectionsConfig['head']['business']['data']->description}}'/>
            @else
                <meta content="{{env('APP_NAME_FRONTEND_CONTENT')}}" name="description"/>
            @endif
            @if($pageSectionsConfig['head']['business']['data']->source!='')
                <meta property='og:image' content='{{$pageSectionsConfig['head']['business']['data']->source}}'/>
                <meta property='og:image:width' content='400'/>
                <meta property='og:image:height' content='400'/>
                <meta property='og:image:alt' content='{{$pageSectionsConfig['head']['business']['data']->title}}'/>

            @endif
        @endif
        <meta content="{{env('APP_NAME_FRONTEND_AUTHOR')}}" name="author"/>

    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.chasqui.styles',['dataManagerPage'=>$dataManagerPage,
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
<div class="{{$classTop}}">

    <!--=======  header navigation wrapper  =======-->
    <div class="header-navigation-top">

    </div>
    <div class="header-navigation-area  d-none d-lg-block">
    </div>

    <!--=======  End of header navigation wrapper  =======-->

    <!--=======  mobile navigation area  =======-->

    <div class="header-mobile-navigation d-block d-lg-none">

    </div>

    <!--=======  End of mobile navigation area  =======-->
</div>

<!--====================  End of call to action area  ====================-->
<div class="content-manager-render">
    @yield('content')
</div>

@include('layouts.chasqui.scripts',['dataManagerPage'=>$dataManagerPage,
'pageSectionsConfig'=>$pageSectionsConfig])

</body>

</html>
