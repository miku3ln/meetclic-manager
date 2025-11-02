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


<head>
    <!-- Site Title-->

    @if(!isset($dataManagerPage['head']['meta']))

        <title>Home</title>
        <meta charset="utf-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport"
              content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="keywords" content="intense web design multipurpose template">
        <meta name="date" content="Dec 26">
    @else
        <title>{{ $dataManagerPage['head']['meta']['title'] }}</title>
        <meta charset="utf-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport"
              content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="{{ $dataManagerPage['head']['meta']['one']['name'] }}"
              content="{{$dataManagerPage['head']['meta']['one']['content']}}">
        <meta name="date" content="Dec 26">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @if(isset($dataManagerPage['favicon']))
        {{$dataManagerPage['favicon']}}
    @else
        <link id='empty' rel="icon" href="{{asset($resourcePathServer.'templates/education')}}/images/favicon.ico"
              type="image/x-icon">
    @endif

<!-- Stylesheets-->
    <link rel="stylesheet" type="text/css"
          href="//fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700%7CMerriweather:400,300,300italic,400italic,700,700italic">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'templates/education')}}/css/bootstrap.css">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'templates/education')}}/css/fonts.css">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'templates/education')}}/css/style.css">
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/education/')}}/SocialNetwork.css">

    @if(isset($dataManagerPage['allowStyle']))
        <link rel="stylesheet" href="{{asset($resourcePathServer.'templates/education')}}/css/fonts-page.css">
    @endif
    <style>
        .ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {
            display: block;
        }

        .rd-navbar-transparent.rd-navbar-static .rd-navbar-dropdown li.active > a {
            color: #fff;
            padding-left: 20px;
        }

        .rd-navbar-transparent.rd-navbar-static .rd-navbar-dropdown li.active > a:before {
            opacity: 1;
            left: 0;
        }
    </style>

    @yield('additional-styles')

</head>

<body>

<div class="preloader">
    <div class="preloader-body">
        <div class="cssload-container">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <p>{{ env('loadingMsg') }}</p>
    </div>
</div>
<!-- Page-->
<div class="page text-center">

    <!-- Page Header-->
    <header class="page-head">
        <!-- RD Navbar Transparent-->
        <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-transparent" data-md-device-layout="rd-navbar-fixed"
                 data-lg-device-layout="rd-navbar-static" data-stick-up-offset="40" data-lg-auto-height="true"
                 data-auto-height="false" data-md-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
                 data-lg-stick-up="true" data-md-focus-on-hover="false">
                <div class="rd-navbar-inner">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-nav-wrap">
                            <span></span></button>
                        <h4 class="panel-title d-xl-none">Home</h4>
                    </div>
                    <div class="rd-navbar-menu-wrap clearfix">
                        <!--Navbar Brand-->
                        <div class="rd-navbar-brand"><a class="d-inline-block"
                                                        href="{{ $dataManagerPage['rootPageCurrent'] }}">
                                <div class="unit align-items-sm-center unit-lg flex-xl-row unit-spacing-xxs">


                                    <div class="unit-left">

                                        @if (isset($dataManagerPage['logoMain']))
                                            {{ $dataManagerPage['logoMain'] }}
                                        @else
                                            <div class="wrap">
                                                <img width='170' height='172'
                                                     src='{{ asset($resourcePathServer . 'templates/education') }}/images/logo-170x172.png'
                                                     alt=''/>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="unit-body text-xl-left">
                                        <div class="rd-navbar-brand-title">
                                            {{ $business['title'] }}
                                        </div>
                                        <div class="rd-navbar-brand-slogan text-light">{{ $business['slogan'] }}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="rd-navbar-nav-wrap">
                            <div class="rd-navbar-mobile-scroll">
                                <div class="rd-navbar-mobile-header-wrap">
                                    <!--Navbar Brand Mobile-->
                                    <div class="rd-navbar-mobile-brand">
                                        <a href="{{ route('urlBase', app()->getLocale()) }}">
                                            @if (isset($dataManagerPage['logoMainMobile']))
                                                {{ $dataManagerPage['logoMainMobile'] }}
                                            @else
                                                <img width='136' height='138'
                                                     src='{{ asset($resourcePathServer . 'templates/education') }}/images/logo-170x172.png'
                                                     alt=''/>
                                            @endif

                                        </a>
                                    </div>
                                </div>
                                <!-- RD Navbar Nav-->

                                @if(false)
                                    <ul class="rd-navbar-nav">
                                        @if (isset($menuCurrent))

                                            @foreach ($menuCurrent as $key => $value)
                                                <li class="{{ $value['active'] ? 'active' : '' }}">
                                                    @if ($value['isParent'])

                                                        @if($value['type'] == 3)
                                                            <a
                                                                href="{{ $value['link'] }}">{{ $value['title'] }}
                                                            </a>

                                                            <ul class="rd-navbar-dropdown">
                                                                @foreach ($value['data']  as $keyChildren => $valueChild)
                                                                    <li class="{{ $valueChild['active'] ? 'active' : '' }}">

                                                                        @if ($valueChild['type'] == 1)
                                                                            <a href="{{ $valueChild['link'] }}">{{ $valueChild['title'] }}</a>

                                                                        @elseif($valueChild['type'] == 2)
                                                                            <a target="_blank"
                                                                               href="{{ $valueChild['link'] }}">{{ $valueChild['title'] }}</a>

                                                                        @endif
                                                                    </li>

                                                                @endforeach


                                                            </ul>
                                                        @endif

                                                    @else
                                                        @if ($value['type'] == 1)
                                                            <a href="{{ $value['link'] }}">{{ $value['title'] }}</a>

                                                        @elseif($value['type'] == 2)
                                                            <a target="_blank"
                                                               href="{{ $value['link'] }}">{{ $value['title'] }}</a>

                                                        @endif
                                                    @endif

                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                @endif
                                @if( isset($menuCurrentHtml))

                                    {!! $menuCurrentHtml !!}

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    @yield('content')
    @yield('footer')


</div>

<div class="snackbars" id="form-output-global"></div>
<!-- Java script-->
<script src="{{asset($resourcePathServer.'templates/education')}}/js/core.min.js"></script>
<script src="{{asset($resourcePathServer.'templates/education')}}/js/script.js"></script>
<script src="{{asset($resourcePathServer.'js')}}/developers/UtilCustom.js"></script>
<script src="{{asset($resourcePathServer.'js')}}/frontend/web/education/SocialNetwork.js"></script>

@yield('additional-scripts')

@if($pageSectionsConfig['business']['view'])

    <a id="whatsapp-contact__a" target="blank" class="chat-widget-button-content"
       data="{{json_encode($pageSectionsConfig['business']['data'])}}"
       text="{{$pageSectionsConfig['business']['textInformation']}}">
        <div class="chat-widget-button chat-widget-button--bee" id="whatsapp-contact"><i
                class="fa fa-whatsapp"></i>
            <span class="chat-widget-button-content__text">
        </span>
        </div>
    </a>
@endif
</body>

</html>
