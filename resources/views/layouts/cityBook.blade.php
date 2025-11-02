<!DOCTYPE HTML>
<html
    <?php echo $pageSectionsConfig['contactTop']['language']['view'] ? ' lang="' . $dataManagerPage['languageHeader']['language'] . '"   xml:lang="' . $dataManagerPage['languageHeader']['language'] . '"' : '' ?>>
<head id="template__web-head">
    <?php
    $nameRoute = Route::currentRouteName();

    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/cityBookHtml/';
    ?>
            <!--=============== basic  ===============-->
    @include('layouts.partials.headMeta')
    @include('layouts.cityBook.typeHtml.styles')
    <style>
        li.menu-top__li-points span {
            margin-left: 4%;
        }

        li.menu-top__li-points {
            text-align: left;
        }

        /* 🌐 Extra Grande (Pantallas grandes de escritorio, TVs) */
        @media only screen and (min-width: 1441px) {
            /* Estilos para 2K, monitores grandes */
        }

        /* 🖥️ Desktop grande */
        @media only screen and (min-width: 1201px) and (max-width: 1440px) {
            /* Escritorios grandes */
        }

        /* 💻 Desktop / Laptop estándar */
        @media only screen and (min-width: 992px) and (max-width: 1200px) {
            /* Laptops y tablets en horizontal */
        }

        /* 📲 Tablet (modo horizontal o landscape) */
        @media only screen and (min-width: 768px) and (max-width: 991px) {
            /* Tablets grandes */
        }

        /* 📱 Tablet (modo vertical) / Móviles grandes */
        @media only screen and (min-width: 541px) and (max-width: 767px) {
            /* Teléfonos grandes (iPhone Plus, Pixel XL) */
        }

        /* 📱 Mobile (estándar) */
        @media only screen and (max-width: 540px) {
            /* Móviles normales (iPhone, Samsung S) */
            /* header MENU*/
            .show-reg-form--login {
                top: 66px !important;
                margin-right: -13% !important;
            }
            .nav-button-wrap--menu-mobiles {
                top: 45px !important;
                margin-right: -109px !important;
            }
        }

        /* 📱 Mobile pequeño (muy reducidos) */
        @media only screen and (max-width: 375px) {
            /* Teléfonos muy pequeños */
        }




        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .not-view {
            display: none;
        }

        footer.main-footer.dark-footer {
            padding: 0px;
            background: #24324f;
        }

        span.title-logo {
            font-size: 31px;
            color: #4db7fe;
            font-weight: 800;
        }

        span.title-logo i {
            color: #ffff;
            animation: pulse 5s infinite;
        }

        @keyframes pulse {

            0% {
                color: #ffffff6b;
            }

            100% {
                color: #ffff;
            }
        }

        .about-widget {
            text-align: left;
        }

        span.title-logo-footer {
            font-size: 18px;
            color: #4db7fe;
            font-weight: 800;
        }

        span.title-logo-footer i {
            color: #ffff;
            animation: pulse 5s infinite;
        }

        .header-search-input-item input {

            font-size: 9.3px;
        }

        .content-name-business {
            font-size: 30px;
            font-weight: 500;
            color: #fff;
        }

        .menusb a.act-link {
            color: #FACC39 !important;
        }

        .menusb li a i {
            color: #445EF2 !important;
        }

        .menusb a.back:before {
            color: #445EF2 !important;
        }

        .logo-holder {
            float: left;
            position: relative;
            top: 0px !important;
            height: 81px!important;
        }
    </style>
    @if(env('allowCustomerCss'))
        <link href="{{ asset($resourcePathServer.'templates/webion/StyleWebion.css') }}" rel="stylesheet"
              type="text/css">
        <link href="http://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">

    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Extra+Condensed:ital,wght@0,1;0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,1;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap"
            rel="stylesheet">

</head>
<body>
<!--loader-->
<div class="loader-wrap">
    <div class="pin"></div>
    <div class="pulse"></div>
</div>
<!--loader end-->
<!-- Main  -->

<?php

$urlManagerPage = '';
if (env('allowAllInOne')) {
  //  $urlManagerPage = route('urlBase');
} else {
    $urlManagerPage = route('homeIndexFrontendWeb', app()->getLocale());

}

?>
<div id="main" nameRoute="{{$nameRoute}}">
    <div signPdf="{{ route('signPdf', app()->getLocale())}}"
         signPdfLocal="{{ route('signPdfLocal', app()->getLocale())}}">

    </div>
    <!-- header-->
    <header class="main-header dark-header fs-header sticky">
        <div class="header-inner">
            <div class="logo-holder ">
                <a href="
                 {{$urlManagerPage}} ">
                    @if(false)
                        <img src="{{ URL::asset($themePath.'images/logo.png')}}" alt="">
                    @else
                        @if(env('allowAllInOne'))
                            @if(env('allowCustomerLogo') && isset($dataManagerPage["logoMain"]) &&  $dataManagerPage["logoMain"]!=null)
                                {{$dataManagerPage["logoMain"]}}
                            @else
                                @if(false)
                                    <img src="{{ URL::asset($themePath.'images/logo-light.png')}}" alt="">
                                @else
                                    <div class="content-name-business ">{{env('userNameFirst')}}<span
                                                class="content-name-business__second">{{env('userNameSecond')}}</span>
                                    </div>
                                @endif

                            @endif
                        @else

                        @endif
                    @endif
                </a>
            </div>
            @if(env("allowCustomerSearchTop"))
                <div class="header-search vis-header-search not-view">
                    <form role="search" method="get" action="{{route('search',app()->getLocale())}}"
                          class="list-search-header-form">

                        <div class="header-search-input-item">
                            <input name="keywords" id="hero_search_loc" type="text"
                                   placeholder="{{__('frontend.menu.home.filters.keywords')}}" value=""/>
                        </div>
                        @if(isset($dataManagerPage['categoriesBusiness']))
                            <div class="header-search-select-item not-view header-search__categories">
                                <select name="category" id="category_list"
                                        data-placeholder="All Categories" class="chosen-select">
                                    <option val="0">{{__('frontend.menu.home.filters.category')}}</option>
                                    @foreach ($dataManagerPage['categoriesBusiness'] as $row)
                                        <option val="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button class="header-search-button"
                                type="submit">{{__('frontend.menu.home.filters.button')}} <i class="fa fa-search"></i>
                        </button>
                    </form>

                </div>
            @endif

            @include('layouts.cityBook.typeHtml.buttonsManager',['type'=>'managerUserTop'])
            <!--  navigation -->

            <div class="nav-holder main-menu main-manager-current">
                <nav>
                    <?php

                    //CMS-TEMPLATE-MENU
                    //MENU ITEMS SEND MISINIT
                    $classWrapper = '';
                    $activeHome = 'not-active';
                    $activeAboutUs = 'not-active';
                    $activeServices = 'not-active';
                    $activeContactUs = 'not-active';
                    $activeShop = 'not-active';
                    $activePages = 'not-active';
                    $activeDictionary = 'not-active';
                    $dictionaryKichwaToCastilian = '';
                    $chaskishimi= '';

                    $dictionaryCastilianToKichwa = '';

                    $activeRewards = 'not-active';
                    $activeActivities = 'not-active';
                    $activeSearch = 'not-active';
                    $activeHive = 'not-active';
                    $activeCart = 'not-active';
                    $activeCheckout = 'not-active';
                    $activeProductDetails = 'not-active';
                    $activeShop = 'not-active';

                    $activeAuthorSingle = 'not-active';
                    $activeSearch = 'not-active';
                    $activeBusinessDetails = 'not-active';
                    $activeHowItWorks = '';
                    $activeBackLine = 'not-active';


                    $activePrices = 'not-active';
                    $activeProfile = 'not-active';

                    $activeFAQ = 'not-active';

                    $activeProducts = 'not-active';
                    $activeProductFlowers = 'not-active';
                    $activeProductFrozen = 'not-active';
                    $activeProductFruits = 'not-active';
                    $activeProductBox = 'not-active';
                    $activeProductProducts = 'not-active';

                    if ($nameRoute == 'homePage') {
                        $activeHome = 'act-link';
                        $classWrapper = '';
                        if ($dataManagerPage['type'] == 1) {
                            $classWrapper = 'no-padding';
                        }
                    }  else if ($nameRoute == 'dictionaryType') {//CMS-TEMPLATE-MENU---KICHWA-CASTILIAN
                        $activeDictionary= 'act-link';
                        if($paramsRequest['type']==1){
                            $dictionaryKichwaToCastilian = 'act-link';
                        }else{
                            $dictionaryCastilianToKichwa = 'act-link';
                        }

                    }else if ($nameRoute == 'shopBee') {
                        $activeShop = 'act-link';

                    } else if ($nameRoute == 'aboutUs') {
                        $activeAboutUs = 'act-link';
                        $activePages = 'act-link';

                    } elseif ($nameRoute == 'howItWorks') {

                        $activePages = 'act-link';
                        $activeHowItWorks = 'act-link';

                    }elseif ($nameRoute == 'homeBackLine') {

                        $activePages = 'act-link';
                        $activeBackLine= 'act-link';

                    } elseif ($nameRoute == 'contactUs') {
                        $activeContactUs = 'act-link';


                    } elseif ($nameRoute == 'ourServicesBee') {
                        $activeServices = 'act-link';
                        $activePages = 'act-link';

                    } elseif ($nameRoute == 'pricesBee') {
                        $activePrices = 'act-link';
                        $activeHive = 'act-link';

                    } elseif ($nameRoute == 'listingsQueen' || $nameRoute == 'reviewsTo' || $nameRoute == 'business' || $nameRoute == 'bee' || $nameRoute == 'password' || $nameRoute == 'suggestionsMailBox' || $nameRoute == 'myProfile' || $nameRoute == 'account' || $nameRoute == 'businessDetails' || $nameRoute == 'search' || $nameRoute == 'authorSingle' || $nameRoute == 'productDetails' || $nameRoute == 'checkout' || $nameRoute == 'cart' || $nameRoute == 'checkoutDetails') {

                        $activeHive = 'act-link';
                        if ($nameRoute == 'businessDetails') {
                            $activeBusinessDetails = 'act-link';

                        } else if ($nameRoute == 'profileBee') {
                            $activeProfile = 'act-link';

                        } else if ($nameRoute == 'search') {
                            $activeSearch = 'act-link';

                        } else if ($nameRoute == 'authorSingle') {
                            $activeAuthorSingle = 'act-link';

                        } else if ($nameRoute == 'productDetails') {
                            $activeProductDetails = 'act-link';

                        } else if ($nameRoute == 'checkout') {
                            $activeCheckout = 'act-link';

                        } else if ($nameRoute == 'cart') {
                            $activeCart = 'act-link';

                        } else if ($nameRoute == 'checkoutDetails') {
                            $activeCart = 'act-link';

                        }

                    } elseif ($nameRoute == 'rewards') {
                        $activeRewards = 'act-link';


                    } elseif ($nameRoute == 'activities') {
                        $activeActivities = 'act-link';
                        $activeActivities = 'act-link';

                    } elseif ($nameRoute == 'productProducts' || $nameRoute == 'productFlowers' || $nameRoute == 'productFrozen' || $nameRoute == 'productFruits' || $nameRoute == 'productBox') {

                        $activeProducts = 'act-link';
                        if ($nameRoute == 'productFlowers') {
                            $activeProductFlowers = 'act-link';

                        } else if ($nameRoute == 'productFrozen') {
                            $activeProductFrozen = 'act-link';

                        } else if ($nameRoute == 'productFruits') {
                            $activeProductFruits = 'act-link';

                        } else if ($nameRoute == 'productBox') {
                            $activeProductBox = 'act-link';

                        } else if ($nameRoute == 'productProducts') {
                            $activeProductProducts = 'act-link';

                        }


                    } elseif ($nameRoute == 'FAQ') {

                        $activeFAQ = 'act-link';


                    }


                    $paramsMenu = [
                        'typeMenu' => 1,
                        'activeHome' => $activeHome,
                        'activeAboutUs' => $activeAboutUs,
                        'activeServices' => $activeServices,
                        'activeContactUs' => $activeContactUs,
                        'activeActivities' => $activeActivities,
                        'activeRewards' => $activeRewards,
                        'activeShop' => $activeShop,
                        'activePages' => $activePages,
                        'activeBackLine' => $activeBackLine,


                    ];
                    ?>

                    @include('layouts.cityBook.typeHtml.menu',$paramsMenu)

                </nav>
            </div>
            <!-- navigation  end -->
        </div>
    </header>
    <!--  header end -->
    @yield('content-manager')
    <!--  wrapper  -->
    <div id="wrapper" class="{{$classWrapper}}">
        <!-- Content-->
        <div class="content content-render-process">
            @yield('content')

        </div>
        <!-- Content end -->
    </div>
    <!-- wrapper end -->
    <!--footer -->
    <footer class="main-footer dark-footer  ">

        @if(env("allowCustomerFooter"))
            <div class="row" id="row-manager-logo-footer">
                <div class="col-md-12">

                    @if(isset($dataManagerPage["logoMainFooter"]) &&  $dataManagerPage["logoMainFooter"]!=null)
                        {{$dataManagerPage["logoMainFooter"]}}
                    @else
                        @if(false)
                            <img src="{{ URL::asset($themePath.'images/logo.png')}}" alt="">
                        @else
                            @if(env('allowAllInOne'))
                                @if(false)
                                    <img src="{{ URL::asset($themePath.'images/logo-light.png')}}" alt="">

                                @else
                                    <div class="content-name-business ">{{env('userNameFirst')}}<span
                                                class="content-name-business__second">{{env('userNameSecond')}}</span>
                                    </div>
                                @endif
                            @else

                                <img
                                        src="{{ URL::asset($resourcePathServer.'uploads/web/backend-profile/sections/logo-header-backend.png')}}"
                                        alt="">

                            @endif
                        @endif
                    @endif


                </div>
            </div>
            <div class="sub-footer fl-wrap">
                <div class="container">
                    <div class="row">


                        <div class="col-md-12">

                            <div class="footer-social">
                                <ul>
                                    <li><a href="{{env('footerCopyRightFacebook')}}" target="_blank"><i
                                                    class="fa fa-facebook-official"></i></a></li>
                                    <li><a id="manager-whatsapp-copy-right" href="#" target="_blank"><i
                                                    class="fa fa-whatsapp"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="copyright"> &#169;<a class="a--link" href="{{env('footerCopyRightPage')}}"
                                                             target="_blank"> {{env('footerCopyRightName')}} </a>{{ date('Y') }}  {{env('footerCopyRightRight')}}
                                .
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if($dataManagerPage['shopConfig']['allow'])
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="footer-widget__title">ACEPTAMOS ESTAS FORMAS DE
                                            PAGO------------------------></h4>
                                        <img src="{{ $dataManagerPage['shopConfig']['source']}}"
                                             class="img-fluid"
                                             alt="">


                                    </div>

                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="sub-footer fl-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="about-widget">
                                @if(false)
                                    <img src="{{ URL::asset($themePath.'images/logo.png')}}" alt="">
                                @else
                                    @if(env('allowAllInOne'))
                                        @if(false)
                                            <img src="{{ URL::asset($themePath.'images/logo-light.png')}}" alt="">

                                        @else
                                            <div class="content-name-business ">{{env("userNameFirst")}}<span
                                                        class="content-name-business__second">{{env("userNameSecond")}}</span>
                                            </div>
                                        @endif
                                    @else

                                        <img
                                                src="{{ URL::asset($resourcePathServer.'uploads/web/backend-profile/sections/logo-header-backend.png')}}"
                                                alt="">

                                    @endif
                                @endif

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="copyright"> &#169;<a class="a--link" href="{{env('footerCopyRightPage')}}"
                                                             target="_blank"> {{env('footerCopyRightName')}} </a>{{ date('Y') }}  {{env('footerCopyRightRight')}}
                                .
                            </div>
                            <div class="footer-social">
                                <ul>
                                    <li><a href="{{env('footerCopyRightFacebook')}}" target="_blank"><i
                                                    class="fa fa-facebook-official"></i></a></li>

                                    @if($businessMainInformation['allow'])
                                        <!--CMS-TEMPLATE-WHATSAPP-SEND-TEMPLATE -->
                                        <li><a id="manager-whatsapp-copy-right" target="_blank"><i
                                                        class="fa fa-whatsapp"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-5">
                            @if($dataManagerPage['shopConfig']['allow'])
                                <!---CMS-TEMPLATE-SHOPPING-CONFIG-TEMPLATE--->
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="footer-widget__title">ACEPTAMOS ESTAS FORMAS DE PAGO</h4>
                                        <img src="{{ $dataManagerPage['shopConfig']['source']}}"
                                             class="img-fluid"
                                             alt="">


                                    </div>

                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

        @endif
    </footer>
    <!--footer end  -->
    <!--register form -->
    <div class="main-register-wrap modal">
        <div class="main-overlay"></div>
        <div class="main-register-holder">
            <div class="main-register fl-wrap">
                <div class="close-reg"><i class="fa fa-times"></i></div>
                <h3>Sign In <span>City<strong>Book</strong></span></h3>
                <div class="soc-log fl-wrap">
                    <p>For faster login or register use your social account.</p>
                    <a href="#" class="facebook-log"><i class="fa fa-facebook-official"></i>Log in with Facebook</a>
                    <a href="#" class="twitter-log"><i class="fa fa-twitter"></i> Log in with Twitter</a>
                </div>
                <div class="log-separator fl-wrap"><span>or</span></div>
                <div id="tabs-container">
                    <ul class="tabs-menu">
                        <li class="current"><a href="#tab-1">Login</a></li>
                        <li><a href="#tab-2">Register</a></li>
                    </ul>
                    <div class="tab">
                        <div id="tab-1" class="tab-content">
                            <div class="custom-form">
                                <form method="post" name="registerform">
                                    <label>Username or Email Address * </label>
                                    <input name="email" type="text" onClick="this.select()" value="">
                                    <label>Password * </label>
                                    <input name="password" type="password" onClick="this.select()" value="">
                                    <button type="submit" class="log-submit-btn"><span>Log In</span></button>
                                    <div class="clearfix"></div>
                                    <div class="filter-tags">
                                        <input id="check-a" type="checkbox" name="check">
                                        <label for="check-a">Remember me</label>
                                    </div>
                                </form>
                                <div class="lost_password">
                                    <a href="#">Lost Your Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div id="tab-2" class="tab-content">
                                <div class="custom-form">
                                    <form method="post" name="registerform" class="main-register-form"
                                          id="main-register-form2">
                                        <label>First Name * </label>
                                        <input name="name" type="text" onClick="this.select()" value="">
                                        <label>Second Name *</label>
                                        <input name="name2" type="text" onClick="this.select()" value="">
                                        <label>Email Address *</label>
                                        <input name="email" type="text" onClick="this.select()" value="">
                                        <label>Password *</label>
                                        <input name="password" type="password" onClick="this.select()" value="">
                                        <button type="submit" class="log-submit-btn"><span>Register</span></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--register form end -->
    <a class="to-top to-top--bee"><i class="fa fa-angle-up"></i></a>

    @if($businessMainInformation['allow'])
        <!--CMS-TEMPLATE-WHATSAPP-SEND-TEMPLATE-->
        <a class=" to-top--contact-whatsapp chat-widget-button-content" target="_blank" id="manager-contact-whatsapp-main">
            <div class="chat-widget-button chat-widget-button--bee">
                <i class="fa fa-whatsapp"></i>

            </div>
        </a>
    @endif
    @yield('buttonsManagerFooter')
    <input id="action-business-categoriesSearchBee" type="hidden"
           value="{{ route("categoriesSearchBee",app()->getLocale()) }}"/>
</div>
@include('layouts.partials.shop.cart',array('typeManagerButton'=>1))

@include('layouts.cityBook.typeHtml.scripts')
<script>
    function esMovil() {
        return /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
    }

    var $businessMainInformation = <?php echo json_encode($businessMainInformation) ?>;

    function initWhatsAppSend() {//CMS-TEMPLATE-WHATSAPP-SEND-JS
        console.log('initWhatsAppSend');
        if ($businessMainInformation.allow) {
            var informationBusiness = $businessMainInformation.data.information;
            var phoneCurrent = informationBusiness.phone_code + informationBusiness.phone_value;
            let params = {
                dataParams: {
                    phone: '+' + phoneCurrent,
                    text: 'Deseamos saber sobre el proceso de Meetclic.',
                }


            };
            let urlCurrent = getUrlWhatsApp() + 'send?' + getStringParamsGet(params);
            console.log('urlCurrent', urlCurrent);
            let result = urlCurrent;
            $('.chat-widget-button-content').attr('href', urlCurrent);
            $('#manager-whatsapp-copy-right').attr('href', urlCurrent);

        }
        console.log('initWhatsAppSend');

    }

    $(function () {
        $nameRoute = '{{$nameRoute}}';
        initWhatsAppSend();

        if ($nameRoute == 'cart') {
            if ($('#manager-shop-products').hasClass('not-view')) {
                var heightWrap = $('body').height() - $('header').height();
                $('#wrapper').css('height', heightWrap + 'px');
            }

        }
    });

    if (esMovil() && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Cookies (pueden leerse en Laravel)
            document.cookie = "lat=" + position.coords.latitude;
            document.cookie = "lon=" + position.coords.longitude;
            document.cookie = "device=movil";
            document.cookie = "navegador=" + navigator.userAgent;
            // Si deseas enviar vía query al siguiente request automático
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const urlConQuery = new URL(window.location.href);
            urlConQuery.searchParams.set('lat', lat);
            urlConQuery.searchParams.set('lon', lon);
            urlConQuery.searchParams.set('device', 'movil');

            // Redirecciona automáticamente con los parámetros
            window.location.href = urlConQuery.toString();
        });
    }
</script>
@yield('data-modal')
</body>
</html>
