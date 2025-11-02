<!DOCTYPE HTML>
<html
    <?php echo $pageSectionsConfig['contactTop']['language']['view'] ? ' lang="' . $dataManagerPage['languageHeader']['language'] . '"   xml:lang="' . $dataManagerPage['languageHeader']['language'] . '"' : '' ?>>
<head>
    <?php

    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/chaskishimiHtml/';
    ?>
        <!--=============== basic  ===============-->
    @include('layouts.partials.headMeta')
    @include('layouts.chaskishimi.typeHtml.styles')
    <style>
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

$urlManagerPage = route('homeChaski', app()->getLocale());
$addClassManagerHeader=$nameRoute == 'homeChaski'?'':'dark-header--chaski-shimi';

?>
<div id="main">
    <!-- header-->
    <header class="main-header dark-header fs-header sticky {{$addClassManagerHeader}} ">
        <div class="header-inner">
            <div class="logo-holder">
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
                                    <div class="content-name-business ">{{env('projectOneNameFirst')}}<span
                                            class="content-name-business__second">{{env('projectOneNameSecond')}}</span>
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

            @include('layouts.chaskishimi.typeHtml.buttonsManager',['type'=>'managerUserTop'])
            <!--  navigation -->

            <div class="nav-holder main-menu">
                <nav>
                    <?php

                    //CMS-TEMPLATE-MENU
                    //MENU ITEMS SEND MISINIT
                    $classWrapper = '';
                    $activePachamama = 'not-active';
                    $activeKichwa = 'not-active';
                    $activeElements = 'not-active';
                    $activeArawi = 'not-active';
                    $activeDictionary = 'not-active';
                    $dictionaryKichwaToCastilian = '';
                    $activeYachaSun = 'not-active';
                    $activeApuntes = 'not-active';
                    $activeDiccionario = 'not-active';
                    $activeTraductor = 'not-active';





                    if ($nameRoute == 'homeChaski') {

                        $activePachamama = 'act-link';

                    } else if ($nameRoute == 'yachaSun') {
                        $activeYachaSun = 'act-link';


                    } else if ($nameRoute == 'apuntes') {
                        $activeApuntes = 'act-link';


                    } else if ($nameRoute == 'diccionario') {

                        $activeDiccionario = 'act-link';

                    } else if ($nameRoute == 'traductor') {
                        $activeTraductor = 'act-link';


                    }


                    $paramsMenu = [
                        'typeMenu' => 1,
                        'activePachamama' => $activePachamama,
                        'activeYachaSun' => $activeYachaSun,
                        'activeApuntes' => $activeApuntes,
                        'activeDiccionario' => $activeDiccionario,
                        'activeTraductor' => $activeTraductor,
                    ];
                    ?>

                    @include('layouts.chaskishimi.typeHtml.menu',$paramsMenu)

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
        <div class="content">
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
                                    <div class="content-name-business ">{{env('projectOneNameFirst')}}<span
                                            class="content-name-business__second">{{env('projectOneNameSecond')}}</span>
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
                                            <div class="content-name-business ">{{env("projectOneNameFirst")}}<span
                                                    class="content-name-business__second">{{env("projectOneNameSecond")}}</span>
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
        <a class=" to-top--contact-whatsapp chat-widget-button-content" target="_blank">
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

@include('layouts.chaskishimi.typeHtml.scripts')
<script>

    var $businessMainInformation = <?php echo json_encode($businessMainInformation) ?>;

    var $allowHome = <?php echo($nameRoute == 'homeChaski' ? 1 : 0) ?>;
    var $urlMain = "<?php echo(route('homeChaski', app()->getLocale())) ?>";

    function activeMenuPachamama() {
        if ($allowHome) {
            $.each($('.menu__a--local'), function (key, value) {
                var selectorCurrentData = $(value).attr('href').split("#");
                var selectorCurrent = '';

                if (selectorCurrentData.length == 1) {
                    selectorCurrent = '.menu__pachamama';
                } else {
                    selectorCurrent = '.menu__' + selectorCurrentData[1];
                }
                var removeClass = "act-link";
                $(selectorCurrent).parent().removeClass("li-" + removeClass);
                $(selectorCurrent).removeClass(removeClass);


            });
            var scrollPosition = $(window).scrollTop();
            var currentSection = '';
            if (scrollPosition < $('#kichwa').offset().top - 67.5) {
                currentSection = 'menu__pachamama';
            } else if (scrollPosition >= $('#kichwa').offset().top - 79 && scrollPosition < $('#elements').offset().top - 76) {

                currentSection = 'menu__kichwa';
            } else if (scrollPosition >= $('#elements').offset().top - 76 && scrollPosition < $('#arawi').offset().top - 73) {
                currentSection = 'menu__elements';


            } else if (scrollPosition >= $('#arawi').offset().top - 73) {

                currentSection = 'menu__arawi';

            }

            var addClass = "act-link";
            var selectorCurrent = "." + currentSection;
            $(selectorCurrent).parent().addClass("li-" + addClass);
            $(selectorCurrent).addClass(addClass);
        }


    }

    function initWhatsAppSend() {//CMS-TEMPLATE-WHATSAPP-SEND-JS
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

    function getAllowHeaderBackground() {
        var result = false;
        if ($allowHome) {
            var scrollPosition = $(window).scrollTop();


            if (scrollPosition >= $('#kichwa').offset().top - 67.5) {
                result = true;

            } else {

                result = false;
            }
        } else {

        }

        return result;
    }

    function addAllowHeaderBackground(allow) {
        if ($allowHome) {
            if (allow) {
                if (!$('.main-header').hasClass('dark-header--background')) {
                    $('.main-header').addClass('dark-header--background');
                }
            } else {
                if (!$('.main-header').hasClass('dark-header--background-none')) {
                    $('.main-header').addClass('dark-header--background-none');
                }
            }
        } else {


        }
    }


    function removeClassHeader() {
        if ($allowHome) {
            $('.main-header').removeClass('dark-header');
            $('.main-header').removeClass('dark-header--background');
            $('.main-header').removeClass('dark-header--background-none');

        } else {

        }
    }

    removeClassHeader();
    addAllowHeaderBackground(getAllowHeaderBackground());
    $(document).ready(function () {

        $('.menu__a--local').on('click', function (event) {
            var selectorCurrentData = $(this).attr('href').split("#");
            event.preventDefault();
            if (selectorCurrentData.length == 1) {
                window.location.href = $(this).attr('href');
            } else {
                if ($allowHome) {

                    var target = $(this).attr('href');
                    $(window).scrollTo(target, 800);
                } else {
                    window.location.href = $urlMain;

                }
            }

        });
        $(window).scroll(function () {
            removeClassHeader();
            addAllowHeaderBackground(getAllowHeaderBackground());
            activeMenuPachamama();

        });


    });
</script>
@yield('data-modal')
</body>
</html>
