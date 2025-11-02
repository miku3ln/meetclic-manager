<?php
$resourcePathServer=env('APP_IS_SERVER')?"public/":'';
?>
@extends('layouts.education')
@section('additional-styles')
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">
@endsection
@section('additional-scripts')

@endsection
@section('content')

    <!-- Page Header-->
    <header class="page-head header-panel-absolute">
        <!-- RD Navbar Transparent-->
        <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-default" data-md-device-layout="rd-navbar-static"
                 data-lg-device-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static"
                 data-stick-up-offset="210" data-xl-stick-up-offset="85" data-lg-auto-height="true"
                 data-auto-height="false" data-md-layout="rd-navbar-static" data-lg-layout="rd-navbar-static"
                 data-lg-stick-up="true">
                <div class="rd-navbar-inner">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-nav-wrap">
                            <span></span></button>
                        <h4 class="panel-title d-lg-none">Home</h4>
                        <!-- RD Navbar Right Side Toggle-->
                        <button class="rd-navbar-top-panel-toggle d-lg-none"
                                data-rd-navbar-toggle=".rd-navbar-top-panel"><span></span></button>
                        <div class="rd-navbar-top-panel">
                            <div class="rd-navbar-top-panel-left-part">
                                <ul class="list-unstyled">
                                    <li>
                                        <div class="unit flex-row align-items-center unit-spacing-xs">
                                            <div class="unit-left"><span class="icon mdi mdi-phone text-middle"></span>
                                            </div>
                                            <div class="unit-body"><a href="tel:#">1-800-1234-567,</a> <a
                                                    class="d-block d-lg-inline-block" href="tel:#">1-800-6547-321</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="unit flex-row align-items-center unit-spacing-xs">
                                            <div class="unit-left"><span
                                                    class="icon mdi mdi-map-marker text-middle"></span></div>
                                            <div class="unit-body"><a href="#">2130 Fulton Street San Diego, CA
                                                    94117-1080 USA</a></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="unit flex-row align-items-center unit-spacing-xs">
                                            <div class="unit-left"><span
                                                    class="icon mdi mdi-email-open text-middle"></span></div>
                                            <div class="unit-body"><a href="mailto:#">info@demolink.org</a></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="rd-navbar-top-panel-right-part">
                                <div class="rd-navbar-top-panel-left-part">
                                    <div class="unit flex-row align-items-center unit-spacing-xs">
                                        <div class="unit-left"><span class="icon mdi mdi-login text-middle"></span>
                                        </div>
                                        <div class="unit-body"><a href="login-register.html">Login/Register</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rd-navbar-menu-wrap clearfix">
                        <!--Navbar Brand-->
                        <div class="rd-navbar-brand"><a class="d-inline-block" href="index.html">
                                <div
                                    class="unit align-items-sm-center unit-xl flex-column flex-xxl-row unit-spacing-custom">
                                    <div class="unit-left"><img width='170' height='172' src='{{asset($resourcePathServer.'templates/education')}}/images/logo-170x172.png'
                                                                alt=''/>
                                    </div>
                                    <div class="unit-body text-xxl-left">
                                        <div class="rd-navbar-brand-title">Jonathan Carroll</div>
                                        <div class="rd-navbar-brand-slogan">University</div>
                                    </div>
                                </div>
                            </a></div>
                        <div class="rd-navbar-nav-wrap">
                            <div class="rd-navbar-mobile-scroll">
                                <div class="rd-navbar-mobile-header-wrap">
                                    <!--Navbar Brand Mobile-->
                                    <div class="rd-navbar-mobile-brand"><a href="index.html"><img width='136'
                                                                                                  height='138'
                                                                                                  src='{{asset($resourcePathServer.'templates/education')}}/images/logo-170x172.png'
                                                                                                  alt=''/></a></div>
                                </div>
                                <!-- RD Navbar Nav-->
                            @include('layouts.partials.education.menu')

                            <!--RD Navbar Mobile Search-->
                                <div class="rd-navbar-search-mobile" id="rd-navbar-search-mobile">
                                    <form class="rd-navbar-search-form search-form-icon-right rd-search"
                                          action="search-results.html" method="GET">
                                        <div class="form-wrap">
                                            <label class="form-label"
                                                   for="rd-navbar-mobile-search-form-input">Search...</label>
                                            <input
                                                class="rd-navbar-search-form-input form-input form-input-gray-lightest"
                                                id="rd-navbar-mobile-search-form-input" type="text" name="s"
                                                autocomplete="off"/>
                                        </div>
                                        <button class="icon fa fa-search rd-navbar-search-button"
                                                type="submit"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--RD Navbar Search-->
                        <div class="rd-navbar-search"><a class="rd-navbar-search-toggle mdi"
                                                         data-rd-navbar-toggle=".rd-navbar-search"
                                                         href="#"><span></span></a>
                            <form class="rd-navbar-search-form search-form-icon-right rd-search"
                                  action="search-results.html" data-search-live="rd-search-results-live" method="GET">
                                <div class="form-wrap">
                                    <label class="form-label" for="rd-navbar-search-form-input">Search</label>
                                    <input class="rd-navbar-search-form-input form-input form-input-gray-lightest"
                                           id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off"/>
                                    <div class="rd-search-results-live" id="rd-search-results-live"></div>
                                </div>
                            </form>
                        </div>
                        <!--RD Navbar shop-->
                        <div class="rd-navbar-cart"><span class="icon fa fa-shopping-cart"></span><a
                                class="inset-left-10" href="shopping-cart.html">2</a></div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <section class="section">
        <!-- Swiper-->
        <div class="swiper-container swiper-slider swiper-slider-modern" data-autoplay="true" data-height="42.1875%"
             data-loop="true" data-dragable="false" data-min-height="480px" data-slide-effect="fade">
            <div class="swiper-wrapper">
                <div class="swiper-slide" data-slide-bg="{{asset($resourcePathServer.'templates/education')}}/images/slide-04-1920x810.jpg"
                     style="background-position: 80% center">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-9 col-sm-10">
                                    <div data-caption-animate="fadeInUp" data-caption-delay="100">
                                        <h1 class="font-weight-bold">Providing Higher Education</h1>
                                    </div>
                                    <div class="offset-top-20 offset-xs-top-40 offset-xl-top-45"
                                         data-caption-animate="fadeInUp" data-caption-delay="150">
                                        <h5>Any successful career starts with advanced higher education. At our
                                            university, you will have a deeper knowledge of the subjects that will be
                                            particularly useful when climbing the career ladder.</h5>
                                    </div>
                                    <div class="offset-top-20 offset-xl-top-30" data-caption-animate="fadeInUp"
                                         data-caption-delay="400"><a class="btn button-primary" href="#">Start a
                                            Journey</a>
                                        <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                class="btn button-default d-none d-xl-inline-block"
                                                href="https://www.templatemonster.com/website-templates/responsive-website-template-59029.html"
                                                target="_blank">Get Template Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" data-slide-bg="{{asset($resourcePathServer.'templates/education')}}/images/slide-02-1920x810.jpg"
                     style="background-position: 80% center">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <div class="row justify-content-sm-center">
                                <div class="col-lg-9 col-sm-10">
                                    <div data-caption-animate="fadeInUp" data-caption-delay="100">
                                        <h1 class="font-weight-bold">Creating Your Future</h1>
                                    </div>
                                    <div class="offset-top-20 offset-xs-top-40 offset-xl-top-45"
                                         data-caption-animate="fadeInUp" data-caption-delay="150">
                                        <h5>Together with our university's professors and academics, you can create the
                                            future for yourself. It means obtaining necessary skills and knowledge to
                                            make everything you learned here work for you in the future.</h5>
                                    </div>
                                    <div class="offset-top-20 offset-xl-top-30" data-caption-animate="fadeInUp"
                                         data-caption-delay="400"><a class="btn button-primary" href="#">Start a
                                            Journey</a>
                                        <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                class="btn button-default d-none d-xl-inline-block"
                                                href="https://www.templatemonster.com/website-templates/responsive-website-template-59029.html"
                                                target="_blank">Get Template Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" data-slide-bg="{{asset($resourcePathServer.'templates/education')}}/images/slide-03-1920x810.jpg"
                     style="background-position: 80% center">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <div class="row justify-content-sm-center">
                                <div class="col-lg-9 col-sm-10">
                                    <div data-caption-animate="fadeInUp" data-caption-delay="100">
                                        <h1 class="font-weight-bold">More Than Just Studying</h1>
                                    </div>
                                    <div class="offset-top-20 offset-xs-top-40 offset-xl-top-45"
                                         data-caption-animate="fadeInUp" data-caption-delay="150">
                                        <h5>Besides providing you with new knowledge and training in chosen disciplines,
                                            our university also gives you an opportunity to benefit from spending your
                                            free time by playing sports, taking part in conferences, and enjoying
                                            student life.</h5>
                                    </div>
                                    <div class="offset-top-20 offset-xl-top-30" data-caption-animate="fadeInUp"
                                         data-caption-delay="400"><a class="btn button-primary" href="#">Start a
                                            Journey</a>
                                        <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                class="btn button-default d-none d-xl-inline-block"
                                                href="https://www.templatemonster.com/website-templates/responsive-website-template-59029.html"
                                                target="_blank">Get Template Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Swiper Pagination-->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- A Few Words About the University-->
    <section class="section section-xl">
        <div class="container container-wide">
            <h2 class="text-center">Check out other themes</h2>
            <hr class="divider bg-madison">
            <div class="row row-30 text-md-left align-items-md-center justify-content-md-between">
                <div class="col-md-6 col-lg-4"><a class="thumbnail-modern thumbnail-variant-4" href="home-1.html">
                        <figure class="thumbnail-figure">
                            <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-1-550x420.jpg" alt="" width="550"
                                                                   height="420"></div>
                        </figure>
                        <div class="caption">
                            <h4 class="caption-header"><span>Home 1</span></h4>
                        </div>
                    </a></div>
                <div class="col-md-6 col-lg-4"><a class="thumbnail-modern thumbnail-variant-4" href="home-2.html">
                        <figure class="thumbnail-figure">
                            <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-2-550x420.jpg" alt="" width="550"
                                                                   height="420"></div>
                        </figure>
                        <div class="caption">
                            <h4 class="caption-header"><span>Home 2</span></h4>
                        </div>
                    </a></div>
                <div class="col-md-6 col-lg-4"><a class="thumbnail-modern thumbnail-variant-4" href="home-3.html">
                        <figure class="thumbnail-figure">
                            <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-3-550x420.jpg" alt="" width="550"
                                                                   height="420"></div>
                        </figure>
                        <div class="caption">
                            <h4 class="caption-header"><span>Home 3</span></h4>
                        </div>
                    </a></div>
            </div>
        </div>
    </section>
    <section class="section bg-catskill section-lg">
        <div class="container">
            <div class="row row-65 justify-content-sm-center justify-content-lg-start counters">
                <div class="col-md-6 col-lg-3">
                    <!-- Counter type 1-->
                    <div class="counter-type-1"><span
                            class="icon icon-lg icon-outlined text-madison mdi mdi-file-document"></span>
                        <div class="h3 font-weight-bold text-primary offset-top-15"><span class="counter"
                                                                                          data-step="1300">49</span>
                        </div>
                        <hr class="divider bg-gray-light divider-sm"/>
                        <div class="offset-top-21">
                            <h6 class="text-black font-accent">HTML Pages</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!-- Counter type 1-->
                    <div class="counter-type-1"><span
                            class="icon icon-lg icon-outlined text-madison mdi mdi-wallet-travel"></span>
                        <div class="h3 font-weight-bold text-primary offset-top-15"><span class="counter"
                                                                                          data-speed="1250">12</span><span>+</span>
                        </div>
                        <hr class="divider bg-gray-light divider-sm"/>
                        <div class="offset-top-21">
                            <h6 class="text-black font-accent">Years of Experience</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!-- Counter type 1-->
                    <div class="counter-type-1"><span
                            class="icon icon-lg icon-outlined text-madison mdi mdi-compare"></span>
                        <div class="h3 font-weight-bold text-primary offset-top-15"><span class="counter"
                                                                                          data-step="1500">5</span>
                        </div>
                        <hr class="divider bg-gray-light divider-sm"/>
                        <div class="offset-top-21">
                            <h6 class="text-black font-accent">Different Layouts</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!-- Counter type 1-->
                    <div class="counter-type-1"><span
                            class="icon icon-lg icon-outlined text-madison mdi mdi-content-copy"></span>
                        <div class="h3 font-weight-bold text-primary offset-top-15"><span class="counter"
                                                                                          data-step="500">40</span>
                        </div>
                        <hr class="divider bg-gray-light divider-sm"/>
                        <div class="offset-top-21">
                            <h6 class="text-black font-accent">PSD Files</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg">
        <div class="container container-wide">
            <div class="row row-30 align-items-lg-center">
                <div class="col-lg-6 col-xl-7"><img class="img-responsive" src="{{asset($resourcePathServer.'templates/education')}}/images/landing-3.png" alt=""></div>
                <div class="col-lg-6 col-xl-5 text-left">
                    <h2>Home Layouts and Demos</h2>
                    <hr class="divider bg-madison divider-md-0">
                    <p>Choose from our wide range of predefined Homepage layouts and demos to create your Own Amazing
                        Experience.</p>
                    <div class="offset-top-50"><a class="btn button-primary"
                                                  href="https://www.templatemonster.com/website-templates/responsive-website-template-59029.html"
                                                  target="_blank">Get Template!</a></div>
                </div>
            </div>
            <div class="offset-top-60">
                <div class="row row-30 isotope-wrap">
                    <!-- Isotope Filters-->
                    <div class="col-xl-12">
                        <div class="isotope-filters isotope-filters-horizontal">
                            <button class="isotope-filters-toggle btn button-primary"
                                    data-custom-toggle="#isotope-filters" data-custom-toggle-disable-on-blur="true"
                                    data-custom-toggle-hide-on-blur="true">Filter<span class="caret"></span></button>
                            <ul class="isotope-filters-modern isotope-filters-list" id="isotope-filters">
                                <li><a class="active" data-isotope-filter="*" href="#">All</a></li>
                                <li><a data-isotope-filter="Home" href="#">Home</a></li>
                                <li><a data-isotope-filter="News" href="#">News</a></li>
                                <li><a data-isotope-filter="Shop" href="#">Shop</a></li>
                                <li><a data-isotope-filter="Campus" href="#">Campus</a></li>
                                <li><a data-isotope-filter="Elements" href="#">Elements</a></li>
                                <li><a data-isotope-filter="Pages" href="#">Pages</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Isotope Content-->
                    <div class="col-xl-12">
                        <div class="row row-30 isotope">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Home"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="home-1.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-1-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Home 1</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Home"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="home-2.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-2-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Home 2</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Home"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="home-3.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-3-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Home 3</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="News"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="masonry-news.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-4-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Masonry News</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="News"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="grid-news.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-5-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Grid News</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="News"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="grid-news-3-columns.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-6-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>3 Column Grid News</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="News"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="classic-news.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-7-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Classic news</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="News"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="modern-news.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-8-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Modern News</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="News"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="news-post-page.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-9-550x420.jpg" alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>News Post Page</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Shop"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="product-catalog.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-10-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Product Catalog</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Shop"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="single-product.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-11-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Single Product</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Shop"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="shopping-cart.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-12-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Shopping Cart</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Shop"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="checkout.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-13-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Checkout</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Campus"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="grid-gallery.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-14-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Grid Gallery</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Campus"><a
                                    class="thumbnail-modern thumbnail-variant-4"
                                    href="grid-without-padding-gallery.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-15-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Grid Without Padding Gallery</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Campus"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="masonry-gallery.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-16-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Masonry Gallery</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Campus"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="cobbles-gallery.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-17-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Cobbles Gallery</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="grid.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-18-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Grid</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="icons.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-19-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Icons</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="tables.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-20-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Tables</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="progress-bars.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-21-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Progress bars</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="tabs-and-accordions.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-22-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Tabs & Accordions</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="forms.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-23-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Forms</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="buttons.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-24-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Buttons</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Elements"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="typography.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-25-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Typography</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="privacy-policy.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-26-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Terms of Use</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="404.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-27-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>404</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="maintenance.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-28-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Maintenance</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="coming-soon.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-29-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Coming Soon</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="login-register.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-30-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Login/Register</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="search-results.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-31-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Search Results</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="history.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-32-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>History</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="people.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-33-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>People</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="contacts.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-34-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Contacts</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="team-member-profile.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-35-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Team Member Profile</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="calendar.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-36-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Calendar</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="event-page.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-37-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Event Page</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="day-event.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-38-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Day Event</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="donate.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-39-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Donate</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="apply.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-40-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Apply</span></h5>
                                    </div>
                                </a></div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3 isotope-item" data-filter="Pages"><a
                                    class="thumbnail-modern thumbnail-variant-4" href="academics.html">
                                    <figure class="thumbnail-figure">
                                        <div class="thumbnail-image-wrap"><img src="{{asset($resourcePathServer.'templates/education')}}/images/landing-41-550x420.jpg"
                                                                               alt=""
                                                                               width="550" height="420"></div>
                                    </figure>
                                    <div class="caption">
                                        <h5 class="caption-header"><span>Academics</span></h5>
                                    </div>
                                </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section context-dark text-center parallax-container" data-parallax-img="{{asset($resourcePathServer.'templates/education')}}/images/parallax-03.jpg">
        <div class="parallax-content">
            <div class="section-60 section-md-100">
                <div class="container text-center">
                    <h2>Different Header and Footer Variations</h2>
                    <hr class="divider bg-default">
                    <div class="row row-30">
                        <div class="col-sm-6 col-lg-4"><img src="{{asset($resourcePathServer.'templates/education')}}/images/layout-1-210x124.png" alt="" width="210"
                                                            height="124">
                            <h5>Minimal Header</h5>
                        </div>
                        <div class="col-sm-6 col-lg-4"><img src="{{asset($resourcePathServer.'templates/education')}}/images/layout-2-210x124.png" alt="" width="210"
                                                            height="124">
                            <h5>Corporate Header</h5>
                        </div>
                        <div class="col-sm-6 col-lg-4"><img src="{{asset($resourcePathServer.'templates/education')}}/images/layout-3-210x124.png" alt="" width="210"
                                                            height="124">
                            <h5>Corporate Header Light</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg bg-catskill">
        <div class="container">
            <div class="row row-30 align-items-lg-center">
                <div class="col-lg-6 col-xl-5 text-left">
                    <h2>Extremely Responsive and Retina Ready</h2>
                    <hr class="divider bg-madison divider-md-0">
                    <p>Due to its responsiveness and Retina display support, our template perfectly fits any modern
                        device, from PC to smartphone.</p>
                    <div class="offset-top-50"><a class="btn button-primary"
                                                  href="https://www.templatemonster.com/website-templates/responsive-website-template-59029.html"
                                                  target="_blank">Get Template!</a></div>
                </div>
                <div class="col-lg-6 col-xl-7"><img class="img-responsive" src="{{asset($resourcePathServer.'templates/education')}}/images/landing-4.png" alt=""></div>
            </div>
        </div>
    </section>
    <section class="section text-center parallax-container" data-parallax-img="{{asset($resourcePathServer.'templates/education')}}/images/parallax-06.jpg">
        <div class="parallax-content">
            <div class="section-155">
                <div class="container">
                    <h1>Free Bonus</h1>
                    <p>Save more than $35 on awesome premium images included in demo</p>
                    <h2>40 PSD and Demo Images Included</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-catskill section-lg">
        <div class="container">
            <h2>Social integration</h2>
            <hr class="divider bg-madison">
            <div class="row justify-content-md-center">
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <p>Get instant feedback from your visitors with social widgets that are built in this template to
                        provide the best possible user experience.</p>
                    <div class="offset-top-35">
                        <ul class="list-inline list-inline-sm list-inline-madison">
                            <li><a class="icon icon-xxs fa fa-facebook icon-rect icon-gray-light-filled" href="#"></a>
                            </li>
                            <li><a class="icon icon-xxs fa fa-twitter icon-rect icon-gray-light-filled" href="#"></a>
                            </li>
                            <li><a class="icon icon-xxs fa fa-google icon-rect icon-gray-light-filled" href="#"></a>
                            </li>
                            <li><a class="icon icon-xxs fa fa-instagram icon-rect icon-gray-light-filled" href="#"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section text-center parallax-container" data-parallax-img="{{asset($resourcePathServer.'templates/education')}}/images/parallax-05.jpg">
        <div class="parallax-content">
            <div class="section-lg">
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-md-10 col-lg-7 col-xl-6">
                            <h2>Dedicated 24/7 Support</h2>
                            <hr class="divider bg-default">
                            <p>Our Support Service is always available 24 hours a day, 7 days a week to help you create
                                your own business solution.</p>
                            <div class="offset-top-50"><a class="btn button-primary"
                                                          href="https://www.templatemonster.com/website-templates/responsive-website-template-59029.html"
                                                          target="_blank">Get Template!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
