<!DOCTYPE HTML>
<html
    <?php echo $pageSectionsConfig['contactTop']['language']['view'] ? ' lang="' . $dataManagerPage['languageHeader']['language'] . '"   xml:lang="' . $dataManagerPage['languageHeader']['language'] . '"' : '' ?>>

<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <?php
    $isUser = Auth::check();
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/eatPura/';
    $logoSrc = URL::asset($themePath . '/img/logo.png');

    if (isset($dataManagerPage["logoMainData"]) && $dataManagerPage["logoMainData"] != null) {

        $logoSrc = URL::asset($resourcePathServer . $dataManagerPage["logoMainData"]->source);
    }
    ?>
        <!--=============== basic  ===============-->
    @include('layouts.partials.headMeta')
    @include('layouts.eatPura.typeHtml.styles')

    <style id="style-over-write">
        .menu-mobile-content {
            padding-top: .25rem !important;
            padding-bottom: 3.25rem !important;
        }

        .not-view {
            display: none;
        }
        .app-management--not-view{
            display: none;

        }
        .loading-resources--view{

        }
        .loading-resources--not-view{
            display: none;
        }


        .loading-resources.loading-resources--view {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 1000;
        }

        .loading-resources p {
            font-size: 24px;
            font-weight: bold;
        }

        .dots::after {
            content: '';
            animation: dots 1.5s steps(5, end) infinite;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column vh-100">


<?php

$urlManagerPage = route('homeEatPura', app()->getLocale());

$urlShopPage = route('shopPage', app()->getLocale());
$addClassManagerHeader = $nameRoute == 'homeEatPura' ? '' : 'dark-header--back-line';

?>
<div class="loading-resources loading-resources--view">
    <p>Cargando......</p>
</div>
<div class="homepage-navbar shadow mb-auto p-3 bg-primary">
    <div class="d-flex align-items-center">
        <a href="#" class="link-dark text-truncate d-flex align-items-center gap-2" data-bs-toggle="offcanvas"
           data-bs-target="#location" aria-controls="location">
            <i class="icofont-clock-time fs-2 text-white"></i>
            @if(isset($dataManagerPage['dataPage']['information']))

                <span>
                  <h6 class="fw-bold text-white mb-0">{{$dataManagerPage['dataPage']['information']['name']}}</h6>
                  <p class="text-white-50 text-truncate d-inline-block mb-0  align-bottom">
                      {{$dataManagerPage['dataPage']['information']['address']['primary'].','.$dataManagerPage['dataPage']['information']['address']['secondary']}}

                  </p>
               </span>
            @endif
        </a>
        <div class="d-flex align-items-center gap-2 ms-auto">
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#mycart" aria-controls="mycart"
               class="link-dark">
                <div class="bg-dark bg-opacity-75 rounded-circle user-icon"><i
                        class="bi bi-basket d-flex m-0 h5 text-white"></i></div>
            </a>
            <a class="toggle hc-nav-trigger hc-nav-1" href="#" type="button" data-bs-toggle="offcanvas"
               data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
               aria-label="Toggle navigation">
                <b class="bg-dark bg-opacity-75 rounded-circle user-icon">
                    <i class="bi bi-list d-flex m-0 h4 text-white"></i>
                </b>
            </a>
        </div>
    </div>
    <div class="pt-3">
        <!-- search -->
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#searchoffcanvas" aria-controls="searchoffcanvas">
            <div class="input-group bg-white rounded-3 shadow-sm py-1">
                <input type="text" class="form-control bg-transparent border-0 rounded-0 px-3"
                       placeholder="{{__('frontend.web.eatPura.frontend.menu.sixteen')}}"
                       aria-label="{{__('frontend.web.eatPura.frontend.menu.sixteen')}}" aria-describedby="search">
                <span class="input-group-text bg-transparent border-0 rounded-0 pe-3" id="search"><i
                        class="icofont-search-1"></i></span>
            </div>
        </a>
    </div>
</div>
<div class="vh-100 my-auto overflow-auto app-management--not-view" id="app-management" >
    <div class="homepage-one-header">
        <!-- Navbar -->
        <div class="homepage-nav-one-header">
            <nav
                class="navbar navbar-expand-lg navbar-light navbar-default bg-white osahan-second-nav py-0 shadow-sm">
                <div class="container px-0 px-xl-3">
                    <div class="offcanvas offcanvas-start p-4 p-lg-0" id="navbar-default">
                        <div class="d-flex justify-content-between align-items-center mb-2 d-block d-lg-none">
                            <a class="navbar-brand m-0 d-lg-block flex-shrink-0" href="{{$urlManagerPage}}">
                                <img src="{{ $logoSrc}}" alt=""
                                     class="img-fluid logo-img">
                            </a>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="d-block d-lg-none">
                            <form action="#">
                                <div
                                    class="input-group bg-white top-search-bar border rounded-pill align-items-center py-1 ps-2">
                                    <input type="text" class="form-control bg-transparent border-0 rounded-0"
                                           placeholder="{{__('frontend.web.eatPura.frontend.menu.two')}}"
                                           aria-label="{{__('frontend.web.eatPura.frontend.menu.two')}}">
                                    <a href="#" class="btn btn-danger rounded-pill me-1"><i
                                            class="icofont-search me-1"></i> {{__('frontend.web.eatPura.frontend.menu.two')}}
                                    </a>
                                </div>
                            </form>
                            <div class="mt-3 mb-4 not-view">


                                <a href="#"
                                   class="link-dark osahan-location text-decoration-none d-flex align-items-center gap-2 text-start flex-shrink-0 w-100"
                                   data-bs-toggle="offcanvas" data-bs-target="#location" aria-controls="location">
                                    <i class="lni lni-map-marker text-danger fs-5"></i>

                                    @if(isset($dataManagerPage['dataPage']['information']))
                                        <div class="lh-sm">
                                            <p class="fw-normal mb-0 small">{{$dataManagerPage['dataPage']['information']['name']}}</p>
                                            <p class="text-muted m-0 text-truncate d-inline-block mb-0 align-bottom">
                                                {{$dataManagerPage['dataPage']['information']['address']['primary'].','.$dataManagerPage['dataPage']['information']['address']['secondary']}}
                                            </p>
                                        </div>

                                    @endif

                                    <i class="lni lni-chevron-down ms-auto"></i>
                                </a>
                            </div>
                        </div>
                        <div class="d-block d-lg-none h-100" data-simplebar="">
                            <ul class="navbar-nav ">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        {{__('frontend.web.eatPura.frontend.menu.fifteen')}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{$urlManagerPage}}">{{__('frontend.web.eatPura.frontend.menu.one')}}</a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" role="button"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        {{__('frontend.web.eatPura.frontend.menu.four')}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{$urlShopPage}}">{{__('frontend.web.eatPura.frontend.menu.four')}}</a>
                                        </li>

                                    </ul>
                                </li>

                                @if(isset($dataManagerPage['categoriesByProducts']))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" role="button"
                                           data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            {{__('frontend.web.eatPura.frontend.menu.three')}}
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-submenu ">

                                                @foreach ($dataManagerPage['categoriesByProducts'] as $row)
                                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                                       href="#" manager-category-a-id="{{$row->id}}">
                                                        {{$row->value}}
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        @foreach ($row->sub_categories as $rowSubCategory)
                                                            <li manager-sub-category-li-id="{{$rowSubCategory['id']}}">
                                                                <a manager-sub-category-a-id="{{$rowSubCategory['id']}}"
                                                                   class="dropdown-item"
                                                                   @click="onFilterSubCategoryMenu({data:'{{ json_encode($rowSubCategory) }}',type:2})">
                                                                    {{$rowSubCategory['value']}}
                                                                </a>
                                                            </li>

                                                        @endforeach

                                                    </ul>
                                                @endforeach


                                            </li>

                                        </ul>
                                    </li>
                                @endif

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false">
                                        {{__('frontend.web.eatPura.frontend.menu.five')}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @if(!$isUser)
                                            <li><a class="dropdown-item" href="{{route('login',app()->getLocale())}}">
                                                    {{__('frontend.web.eatPura.frontend.menu.eleven')}}
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                   href="{{route('register',app()->getLocale())}}">
                                                    {{__('frontend.web.eatPura.frontend.menu.ten')}}
                                                </a>
                                            </li>

                                        @else

                                            <li><a class="dropdown-item"
                                                   href=" {{route('userAccount', app()->getLocale())}}">
                                                    {{__('frontend.web.eatPura.frontend.menu.fourth')}}</a>
                                            </li>

                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Body -->
    </div>

    <!--  header end -->
    <!--  wrapper  -->
    <div id="wrapper-content">
        @yield('content')
        @yield('content-manager')


    </div>

   <!-- Log In & Verify & Successfull Modal -->
    <div class="modal fade" id="login" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white border-0 overflow-hidden rounded-4">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-lg-4 d-none d-lg-block">
                            <div
                                class="p-4 d-flex bg-warning-subtle align-items-center flex-column text-center gap-4 justify-content-center h-100">
                                <img src="{{ $logoSrc}}" alt=""
                                     class="img-fluid mb-auto px-4">
                                <div>
                                    <h5 class="fw-bold">Welcome to Eatpura</h5>
                                    <p class="m-0">Download the app get free food &amp; <span
                                            class="fw-bold text-success">$50</span> off on your first order.</p>
                                </div>
                                <a href="#" class="btn btn-sm w-100 btn-warning mt-auto rounded-pill">Download
                                    App</a>
                            </div>
                        </div>
                        <div class="col-lg-8 p-4">
                            <button type="button" class="btn-close float-end shadow-none" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            <div class="mb-4 pe-5">
                                <h6 class="fw-bold text-danger mb-1">Phone Number Verification</h6>
                            </div>
                            <form>
                                <div class="text-start">
                                    <p class="lh-base pb-2 text-muted fs-6 mb-1">Enter your phone number to
                                        Login/Sign
                                        up</p>
                                    <div class="input-group bg-white shadow-sm rounded-3 border py-2 mb-4">
                                        <a href="#"
                                           class="input-group-text bg-transparent border-0 rounded-0 text-black px-3"><i
                                                class="lni lni-mobile me-1"></i> +91</a>
                                        <input type="number"
                                               class="form-control bg-transparent border-0 rounded-0 ps-0"
                                               placeholder="Type your number" value="">
                                    </div>
                                    <a href="#" class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow"
                                       data-bs-target="#verify" data-bs-toggle="modal">Next</a>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">By continuing, you agree to our</p>
                                        <span class="small">
                                    <a href="#" class="text-decoration-underline me-2">Terms of service</a>
                                    <a href="#" class="text-decoration-underline ">Privacy Policy</a>
                                    </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Verify -->
    <div class="modal fade" id="verify" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white border-0 overflow-hidden rounded-4">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-lg-4 d-none d-lg-block">
                            <div
                                class="p-4 d-flex bg-warning-subtle align-items-center flex-column text-center gap-4 justify-content-center h-100">
                                <img src="{{ $logoSrc}}" alt=""
                                     class="img-fluid mb-auto px-4">
                                <div>
                                    <h5 class="fw-bold">Welcome to Eatpura</h5>
                                    <p class="m-0">Download the app get free food &amp; <span
                                            class="fw-bold text-success">$50</span> off on your first order.</p>
                                </div>
                                <a href="#" class="btn btn-sm w-100 btn-warning mt-auto rounded-pill">Download
                                    App</a>
                            </div>
                        </div>
                        <div class="col-lg-8 p-4">
                            <div class="mb-4">
                                <h6 class="fw-bold d-flex align-items-center text-danger mb-1"><a class="me-3"
                                                                                                  href="#"
                                                                                                  data-bs-target="#login"
                                                                                                  data-bs-toggle="modal"><i
                                            class="lni lni-arrow-left fs-5 d-flex"></i></a> Phone Number
                                    Verification
                                </h6>
                            </div>
                            <form>
                                <div class="text-start">
                                    <p class="lh-base pb-2 text-muted fs-6 mb-1">Enter 4 digit code sent to your
                                        phone<br>+91-+91 1234 567890</p>
                                    <div class="row mb-4">
                                        <div class="col-3">
                                            <input type="text"
                                                   class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                                   value="5" maxlength="1">
                                        </div>
                                        <div class="col-3">
                                            <input type="text"
                                                   class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                                   value="2" maxlength="1">
                                        </div>
                                        <div class="col-3">
                                            <input type="text"
                                                   class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                                   value="8" maxlength="1">
                                        </div>
                                        <div class="col-3">
                                            <input type="text"
                                                   class="form-control text-center bg-white shadow-sm rounded-3 border py-2 fs-4"
                                                   value="1" maxlength="1">
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow"
                                       data-bs-toggle="modal" data-bs-target="#successfull">Next</a>
                                    <div class="mt-3">
                                    <span class="small d-flex justify-content-between">
                                    <a href="#" class="text-decoration-underline me-2">Resend Code</a>
                                    <small class="text-muted">Resend Code (in <b id="timer">60</b> secs)</small>
                                    </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Success full login Modal-->
    <div class="modal fade" id="successfull" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-white border-0 overflow-hidden rounded-4">
                <div class="modal-body border-0 rounded-3 text-center p-5">
                    <img src="{{ URL::asset($themePath.'')}}/img/successfull.png" alt="" class="img-fluid w-25">
                    <p class="fw-bold text-danger mb-0 mt-4">Welcome to Eatpura</p>
                    <h5 class="text-success mb-3 mt-1">Your Login is Successfull</h5>
                    <p class="mb-4">Download the app get free food &amp; <span
                            class="fw-bold text-success">$50</span>
                        off on your first order.</p>
                    <a href="listing.html" class="btn fw-bold py-2 px-4 btn-danger mt-auto rounded-pill">Shop
                        Now</a>
                </div>
            </div>
        </div>
    </div>

    @yield('additional-modal')

</div>


<div class="footer bg-white shadow mt-auto border-top">
    @if(isset($dataManagerPage['isUserMenu']) && !$dataManagerPage['isUserMenu'])
        <div
            class="d-flex align-items-center justify-content-between py-1 menu-mobile-content menu-mobile-content--user-menu">
            <a href="{{$urlManagerPage}}" class="link-dark text-center col py-2 p-1">
                <i class="bi bi-house h3 m-0"></i>
                <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.one')}}</p>
            </a>
            <a href="{{$urlShopPage}}" class="text-muted text-center col py-2 p-1">
                <i class="bi bi-shop h3 m-0"></i>
                <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.four')}}</p>
            </a>
            <a href="store-list.html" class="text-muted text-center col py-2 p-1 not-view">
                <i class="bi bi-geo-alt h3 m-0"></i>
                <p class="small m-0 pt-1">Stores</p>
            </a>
            <a href="shop-cart.html" class="text-muted text-center col py-2 p-1">
                <i class="bi bi-basket h3 m-0"></i>
                <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.third')}}</p>
            </a>
            @if(Auth::check())
                <a href="{{route('userAccount', app()->getLocale())}}" class="text-muted text-center col py-2 p-1">
                    <i class="bi bi-person h3 m-0"></i>
                    <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.fourth')}}</p>
                </a>
            @else
                <a href="{{route('login', app()->getLocale())}}" class="text-muted text-center col py-2 p-1">
                    <i class="bi bi-person h3 m-0"></i>
                    <p class="small m-0 pt-1">{{__('frontend.web.eatPura.frontend.menu.eleven')}}</p>
                </a>
            @endif
        </div>
    @else

    @endif
</div>


@include('layouts.eatPura.typeHtml.scripts')
<script>
    var $businessMainInformation = <?php echo json_encode($businessMainInformation) ?>;
    var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;

    var $nameRoute = '<?php echo($nameRoute) ?>';

    var $allowHome = <?php echo($nameRoute == 'homeEatPura' ? 1 : 0) ?>;
    var $urlMain = "<?php echo(route('homeEatPura', app()->getLocale())) ?>";


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
