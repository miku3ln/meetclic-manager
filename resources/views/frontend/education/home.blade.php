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
    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img
                src="{{asset($resourcePathServer.'templates/education')}}/images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820"
                alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
    </div>
    <div class="preloader">
        <div class="preloader-body">
            <div class="cssload-container">
                <div class="cssload-speeding-wheel"></div>
            </div>
            <p>Loading...</p>
        </div>
    </div>
    <!-- Page-->
    <div class="page text-center">
        <!-- Page Header-->
        <header class="page-head" style="position:absolute; left:0; right:0;top:0">
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
                            <div class="rd-navbar-brand"><a class="d-inline-block" href="index.html">
                                    <div class="unit align-items-sm-center unit-lg flex-xl-row unit-spacing-xxs">
                                        <div class="unit-left">
                                            <div class="wrap"><img width='170' height='172' src='{{asset($resourcePathServer.'templates/education')}}/images/logo-170x172.png'
                                                                   alt=''/>
                                            </div>
                                        </div>
                                        <div class="unit-body text-xl-left">
                                            <div class="rd-navbar-brand-title">Jonathan Carroll</div>
                                            <div class="rd-navbar-brand-slogan text-light">University</div>
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
                                    <ul class="rd-navbar-nav">
                                        <li class="active"><a href="index.html">Home</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="home-1.html">Home 1</a>
                                                </li>
                                                <li><a href="home-2.html">Home 2</a>
                                                </li>
                                                <li><a href="home-3.html">Home 3</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Elements</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="grid.html">Grid</a>
                                                </li>
                                                <li><a href="icons.html">Icons</a>
                                                </li>
                                                <li><a href="tables.html">Tables</a>
                                                </li>
                                                <li><a href="progress-bars.html">Progress bars</a>
                                                </li>
                                                <li><a href="tabs-and-accordions.html">Tabs &amp; Accordions</a>
                                                </li>
                                                <li><a href="forms.html">Forms</a>
                                                </li>
                                                <li><a href="buttons.html">Buttons</a>
                                                </li>
                                                <li><a href="typography.html">Typography</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Pages</a>
                                            <div class="rd-navbar-megamenu">
                                                <div class="row section-relative">
                                                    <ul class="col-xl-3">
                                                        <li>
                                                            <h6>Programs</h6>
                                                            <ul class="list-unstyled offset-lg-top-20">
                                                                <li><a href="academics.html">Academics</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                    <ul class="col-xl-3">
                                                        <li>
                                                            <h6>Pages</h6>
                                                            <ul class="list-unstyled offset-lg-top-20">
                                                                <li><a href="404.html">404</a></li>
                                                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                                                <li><a href="maintenance.html">Maintenance</a></li>
                                                                <li><a href="login-register.html">Login/Register</a></li>
                                                                <li><a href="coming-soon.html">Coming Soon</a></li>
                                                                <li><a href="search-results.html">Search Results</a></li>
                                                                <li><a href="apply.html">Apply</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                    <ul class="col-xl-3">
                                                        <li>
                                                            <h6>Layouts</h6>
                                                            <ul class="list-unstyled offset-lg-top-20">
                                                                <li><a href="header-transparent.html">Header Transparent</a>
                                                                </li>
                                                                <li><a href="header-center.html">Header Center, Footer
                                                                        Center</a></li>
                                                                <li><a href="header-minimal.html">Header Minimal, Footer
                                                                        Center</a></li>
                                                                <li><a href="header-corporate.html">Header Corporate</a>
                                                                </li>
                                                                <li><a href="header-hamburger-menu.html">Header Hamburger
                                                                        Menu</a></li>
                                                                <li><a href="footer-minimal.html">Footer Minimal</a></li>
                                                                <li><a href="footer-widget.html">Footer Widget</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                    <ul class="col-xl-3">
                                                        <li>
                                                            <h6>About</h6>
                                                            <ul class="list-unstyled offset-lg-top-20">
                                                                <li><a href="history.html">History</a></li>
                                                                <li><a href="people.html">People</a></li>
                                                                <li><a href="team-member-profile.html">Team Member
                                                                        Profile</a></li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <h6>Event Calendar</h6>
                                                            <ul class="list-unstyled offset-lg-top-20">
                                                                <li><a href="calendar.html">Calendar</a></li>
                                                                <li><a href="day-event.html">Day Event</a></li>
                                                                <li><a href="event-page.html">Event Page</a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li><a href="#">News</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="classic-news.html">Classic news</a>
                                                </li>
                                                <li><a href="grid-news.html">Grid News</a>
                                                </li>
                                                <li><a href="masonry-news.html">Masonry News</a>
                                                </li>
                                                <li><a href="grid-news-3-columns.html">3 Column Grid News</a>
                                                </li>
                                                <li><a href="modern-news.html">Modern News</a>
                                                </li>
                                                <li><a href="news-post-page.html">News Post Page</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Campus</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="grid-gallery.html">Grid Gallery</a>
                                                </li>
                                                <li><a href="grid-without-padding-gallery.html">Grid Without Padding
                                                        Gallery</a>
                                                </li>
                                                <li><a href="masonry-gallery.html">Masonry Gallery</a>
                                                </li>
                                                <li><a href="cobbles-gallery.html">Cobbles Gallery</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Shop</a>
                                            <ul class="rd-navbar-dropdown">
                                                <li><a href="product-catalog.html">Product Catalog</a>
                                                </li>
                                                <li><a href="single-product.html">Single Product</a>
                                                </li>
                                                <li><a href="shopping-cart.html">Shopping Cart</a>
                                                </li>
                                                <li><a href="checkout.html">Checkout</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="donate.html">Donate</a>
                                        </li>
                                        <li><a href="contacts.html">Contacts</a>
                                        </li>
                                        <li class="d-lg-none"><a href="shopping-cart.html">Shopping Cart (2)</a></li>
                                    </ul>
                                    <!--RD Navbar Mobile Search-->
                                    <div class="rd-navbar-search-mobile" id="rd-navbar-search-mobile">
                                        <form class="rd-navbar-search-form search-form-icon-right rd-search"
                                              action="search-results.html" method="GET">
                                            <div class="form-wrap">
                                                <label class="form-label"
                                                       for="rd-navbar-mobile-search-form-input">Search...</label>
                                                <input class="rd-navbar-search-form-input form-input form-input-gray-lightest"
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
        <section>
            <!-- Swiper-->
            <div class="swiper-container swiper-slider swiper-slider-3" data-autoplay="true" data-height="100vh"
                 data-loop="true" data-dragable="false" data-min-height="480px" data-slide-effect="true">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" data-slide-bg="{{asset($resourcePathServer.'templates/education')}}/images/slide-03-1920x810.jpg"
                         style="background-position: 80% center">
                        <div class="swiper-slide-caption header-transparent-slide-caption">
                            <div class="container">
                                <div class="row justify-content-sm-center justify-content-xl-start no-gutters">
                                    <div class="col-lg-6 text-lg-left col-sm-10">
                                        <div data-caption-animate="fadeInUp" data-caption-delay="100"
                                             data-caption-duration="1700">
                                            <h1 class="font-weight-bold">Inspiration, Innovation and Discovery.</h1>
                                        </div>
                                        <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"
                                             data-caption-animate="fadeInUp" data-caption-delay="150"
                                             data-caption-duration="1700">
                                            <h5 class="text-regular font-default">Any successful career starts with good
                                                education. Together with us you will have deeper knowledge of the subjects
                                                that will be especially useful for you when climbing the career ladder.</h5>
                                        </div>
                                        <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"
                                             data-caption-delay="400" data-caption-duration="1700"><a
                                                class="btn button-madison btn-ellipse" href="login-register.html">Sign Up
                                                for Excursion</a>
                                            <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                    class="btn button-primary btn-ellipse d-none d-xl-inline-block"
                                                    href="academics.html">Learn More</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" data-slide-bg="{{asset($resourcePathServer.'templates/education')}}/images/slide-02-1920x810.jpg"
                         style="background-position: 80% center">
                        <div class="swiper-slide-caption header-transparent-slide-caption">
                            <div class="container">
                                <div class="row justify-content-sm-center justify-content-xl-start no-gutters">
                                    <div class="col-lg-6 text-lg-left col-sm-10">
                                        <div data-caption-animate="fadeInUp" data-caption-delay="100"
                                             data-caption-duration="1700">
                                            <h1 class="font-weight-bold">Investing in Knowledge.</h1>
                                        </div>
                                        <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"
                                             data-caption-animate="fadeInUp" data-caption-delay="150"
                                             data-caption-duration="1700">
                                            <h5 class="text-regular font-default">At Jonathan Carroll University, you can
                                                succeed in lots of research areas and benefit from investing in your
                                                education and knowledge that will help you in becoming an experienced
                                                specialist.</h5>
                                        </div>
                                        <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"
                                             data-caption-delay="400" data-caption-duration="1700"><a
                                                class="btn btn-ellipse button-madison" href="login-register.html">Sign Up
                                                for Excursion</a>
                                            <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                    class="btn btn-ellipse button-primary d-none d-xl-inline-block"
                                                    href="academics.html">Learn More</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" data-slide-bg="{{asset($resourcePathServer.'templates/education')}}/images/slide-01-1920x810.jpg"
                         style="background-position: 80% center">
                        <div class="swiper-slide-caption header-transparent-slide-caption">
                            <div class="container">
                                <div class="row justify-content-sm-center justify-content-xl-start no-gutters">
                                    <div class="col-lg-6 text-lg-left col-sm-10">
                                        <div data-caption-animate="fadeInUp" data-caption-delay="100"
                                             data-caption-duration="1700">
                                            <h1 class="font-weight-bold">Open Minds. <br class="d-none d-lg-inline-block">
                                                Creating Future.</h1>
                                        </div>
                                        <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"
                                             data-caption-animate="fadeInUp" data-caption-delay="150"
                                             data-caption-duration="1700">
                                            <h5 class="text-regular font-default">Build your future with us! The educational
                                                programs of our University will give you necessary skills, training, and
                                                knowledge to make everything you learned here work for you in the
                                                future.</h5>
                                        </div>
                                        <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"
                                             data-caption-delay="400" data-caption-duration="1700"><a
                                                class="btn btn-ellipse button-madison" href="login-register.html">Sign Up
                                                for Excursion</a>
                                            <div class="inset-sm-left-30 d-xl-inline-block"><a
                                                    class="btn btn-ellipse button-primary d-none d-xl-inline-block"
                                                    href="academics.html">Learn More</a></div>
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
        <section class="section section-xl bg-default">
            <div class="container">
                <div class="row row-50 text-lg-left justify-content-md-between">
                    <div class="col-lg-7 view-animate fadeInRightSm delay-04">
                        <div class="img-wrap-2">
                            <figure><a class="icon mdi mdi-play-circle-outline" data-lightgallery="item"
                                       href="https://www.youtube.com/embed/-AhmuMqZB0s"></a><img
                                    class="img-responsive d-inline-block" src="{{asset($resourcePathServer.'templates/education')}}/images/home-01-620-350.jpg" width="620"
                                    height="350" alt=""></figure>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <h2 class="home-headings-custom font-weight-bold view-animate fadeInLeftSm delay-06"><span
                                class="first-word">About</span> Our University</h2>
                        <div class="offset-top-35 offset-lg-top-60 view-animate fadeInLeftSm delay-08">
                            <p>One of the world's premier academic and research institutions, the Jonathan Carroll
                                University has driven new ways of thinking since our 1876 founding. Today, JCU is an
                                intellectual destination that draws inspired scholars to our Hyde Park and international
                                campuses, keeping JCU at the nexus of ideas that challenge and change the world.</p>
                        </div>
                        <div class="offset-top-30 view-animate fadeInLeftSm delay-1"><a
                                class="btn btn-ellipse btn-icon btn-icon-right button-default" href="history.html"><span
                                    class="icon fa fa-arrow-right"></span><span>Learn More</span></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!--Our Featured Courses-->
        <section class="section bg-madison section-xl text-center">
            <div class="container">
                <h2 class="font-weight-bold text-white view-animate fadeInUpSmall delay-04">Our Programs</h2>
                <div class="offset-top-35 offset-lg-top-60 text-white view-animate fadeInUpSmall delay-06">Our Featured
                    Programs are selected through a rigorous process and uniquely created for each semester.
                </div>
                <div class="row row-30 justify-content-sm-center offset-top-60 text-md-left">
                    <div class="col-md-6 col-lg-4 view-animate fadeInRightSm delay-1">
                        <article class="post-news bg-default"><a href="news-post-page.html"><img class="img-responsive"
                                                                                                 src="{{asset($resourcePathServer.'templates/education')}}/images/home-02-370x240.jpg"
                                                                                                 width="370" height="240"
                                                                                                 alt=""></a>
                            <div class="post-news-body-variant-1">
                                <div class="post-news-meta">
                                    <time class="text-middle font-italic" datetime="2019">June 3, 2019</time>
                                </div>
                                <h6><a href="news-post-page.html">Arts Programs</a></h6>
                                <div class="offset-top-9">
                                    <p class="text-base">Charles Banks</p>
                                </div>
                                <div class="offset-top-9">
                                    <ul class="list-inline list-unstyled list-inline-primary">
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-timer-sand"
                                                  data-toggle="tooltip" data-placement="top" title="Part time"></span></li>
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-star" data-toggle="tooltip"
                                                  data-placement="top" title="Certified"></span></li>
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-laptop-chromebook"
                                                  data-toggle="tooltip" data-placement="top" title="Online Course"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4 view-animate fadeInUpSmall delay-08">
                        <article class="post-news bg-default"><a href="news-post-page.html"><img class="img-responsive"
                                                                                                 src="{{asset($resourcePathServer.'templates/education')}}/images/home-03-370x240.jpg"
                                                                                                 width="370" height="240"
                                                                                                 alt=""></a>
                            <div class="post-news-body-variant-1">
                                <div class="post-news-meta">
                                    <time class="text-middle font-italic" datetime="2019">June 3, 2019</time>
                                </div>
                                <h6><a href="news-post-page.html">Foreign Language Programs</a></h6>
                                <div class="offset-top-9">
                                    <p class="text-base">Maria Howard</p>
                                </div>
                                <div class="offset-top-9">
                                    <ul class="list-inline list-unstyled list-inline-primary">
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-timer-sand"
                                                  data-toggle="tooltip" data-placement="top" title="Part time"></span></li>
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-star" data-toggle="tooltip"
                                                  data-placement="top" title="Certified"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4 view-animate fadeInLeftSm delay-1">
                        <article class="post-news bg-default"><a href="news-post-page.html"><img class="img-responsive"
                                                                                                 src="{{asset($resourcePathServer.'templates/education')}}/images/home-04-370x240.jpg"
                                                                                                 width="370" height="240"
                                                                                                 alt=""></a>
                            <div class="post-news-body-variant-1">
                                <div class="post-news-meta">
                                    <time class="text-middle font-italic" datetime="2019">June 3, 2019</time>
                                </div>
                                <h6><a href="news-post-page.html">Sports Programs</a></h6>
                                <div class="offset-top-9">
                                    <p class="text-base">Steven Carter</p>
                                </div>
                                <div class="offset-top-9">
                                    <ul class="list-inline list-unstyled list-inline-primary">
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-timer-sand"
                                                  data-toggle="tooltip" data-placement="top" title="Part time"></span></li>
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-star" data-toggle="tooltip"
                                                  data-placement="top" title="Certified"></span></li>
                                        <li><span class="text-hover-custom icon icon-xxs mdi mdi-laptop-chromebook"
                                                  data-toggle="tooltip" data-placement="top" title="Online Course"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="offset-top-35 offset-xl-top-70 view-animate fadeInUpSmall"><a
                        class="btn btn-ellipse button-primary" href="login-register.html">View All Programs</a></div>
            </div>
        </section>
        <!-- Counters-->
        <section class="section text-center bg-default">
            <div class="container">
                <div class="row justify-content-sm-center justify-content-md-start offset-top-0">
                    <div class="col-sm-10 col-md-7 section-image-aside section-image-aside-right">
                        <div class="section-image-aside-img d-none d-md-block view-animate zoomInSmall delay-04"
                             style="background-image: url({{asset($resourcePathServer.'templates/education')}}/images/home-01-846x1002.jpg)"></div>
                        <div class="section-image-aside-body section-xl inset-lg-right-70 inset-xl-right-110">
                            <h2 class="home-headings-custom font-weight-bold view-animate fadeInLeftSm delay-04"><span
                                    class="first-word">Our</span> Features</h2>
                            <div class="offset-top-35 offset-md-top-60 view-animate fadeInLeftSm delay-06">Jonathan Carroll
                                University was founded on the principle that by pursuing big ideas and sharing what we
                                learn, we make the world a better place. For more than 135 years, we haven’t strayed from
                                that vision.
                            </div>
                            <div class="text-center text-sm-left">
                                <div class="row row-65 justify-content-sm-center justify-content-lg-start offset-top-65 counters">
                                    <div class="col-sm-6 view-animate fadeInLeftSm delay-08">
                                        <!-- Counter type 1-->
                                        <div class="unit flex-column flex-sm-row unit-responsive-md counter-type-2">
                                            <div class="unit-left"><span
                                                    class="icon icon-md text-madison mdi mdi-school"></span></div>
                                            <div class="unit-body">
                                                <div class="h3 font-weight-bold text-primary"><span class="counter"
                                                                                                    data-speed="1300">15</span><span></span>
                                                </div>
                                                <div class="offset-top-3">
                                                    <h6 class="text-black font-accent font-weight-bold">Awards</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 view-animate fadeInLeftSm delay-04">
                                        <!-- Counter type 1-->
                                        <div class="unit flex-column flex-sm-row unit-responsive-md counter-type-2">
                                            <div class="unit-left"><span
                                                    class="icon icon-md text-madison mdi mdi-wallet-travel"></span></div>
                                            <div class="unit-body">
                                                <div class="h3 font-weight-bold text-primary"><span class="counter"
                                                                                                    data-speed="1250">30</span><span>+</span>
                                                </div>
                                                <div class="offset-top-3">
                                                    <h6 class="text-black font-accent font-weight-bold">Certified
                                                        Teachers</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 view-animate fadeInLeftSm delay-1">
                                        <!-- Counter type 1-->
                                        <div class="unit flex-column flex-sm-row unit-responsive-md counter-type-2">
                                            <div class="unit-left"><span
                                                    class="icon icon-md text-madison mdi mdi-domain"></span></div>
                                            <div class="unit-body">
                                                <div class="h3 font-weight-bold text-primary offset-top-5"><span
                                                        class="counter" data-step="500">10</span></div>
                                                <div class="offset-top-3">
                                                    <h6 class="text-black font-accent font-weight-bold">Featured
                                                        Programs </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 view-animate fadeInLeftSm delay-06">
                                        <!-- Counter type 1-->
                                        <div class="unit flex-column flex-sm-row unit-responsive-md counter-type-2">
                                            <div class="unit-left"><span
                                                    class="icon icon-md text-madison mdi mdi-account-multiple-outline"></span>
                                            </div>
                                            <div class="unit-body">
                                                <div class="h3 font-weight-bold text-primary offset-top-5"><span
                                                        class="counter" data-step="1500">6510</span></div>
                                                <div class="offset-top-3">
                                                    <h6 class="text-black font-accent font-weight-bold">Students</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section bg-catskill section-xl">
            <div class="container container-wide">
                <h2 class="font-weight-bold">Events</h2>
                <hr class="divider bg-madison">
                <div class="row row-50 offset-top-60 justify-content-sm-center">
                    <div class="col-md-6 col-lg-5 col-xxl-3">
                        <article class="post-event">
                            <div class="post-event-img-overlay"><img class="img-responsive"
                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/blog/events-01-420x420.jpg" width="420"
                                                                     height="420" alt="">
                                <div class="post-event-overlay context-dark"><a class="btn button-primary"
                                                                                href="apply.html">Book Now</a>
                                    <div class="offset-top-20"><a class="btn button-default" href="event-page.html">Learn
                                            More</a></div>
                                </div>
                            </div>
                            <div class="unit unit-lg flex-column flex-xl-row">
                                <div class="unit-left">
                                    <div class="post-event-meta text-center">
                                        <div class="h3 font-weight-bold d-inline-block d-xl-block">31</div>
                                        <p class="d-inline-block d-xl-block">September</p><span
                                            class="font-weight-bold d-inline-block d-xl-block inset-left-10 inset-xl-left-0">5:00pm</span>
                                    </div>
                                </div>
                                <div class="unit-body">
                                    <div class="post-event-body text-xl-left">
                                        <h6><a href="event-page.html">Spacewalking Conference</a></h6>
                                        <ul class="list-inline list-inline-xs">
                                            <li><a href="team-member-profile.html"><span
                                                        class="icon icon-xxs mdi mdi-account-outline text-middle"></span><span
                                                        class="inset-left-10 text-dark text-middle">Walter Stanley</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-5 col-xxl-3">
                        <article class="post-event">
                            <div class="post-event-img-overlay"><img class="img-responsive"
                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/blog/events-02-420x420.jpg" width="420"
                                                                     height="420" alt="">
                                <div class="post-event-overlay context-dark"><a class="btn button-primary"
                                                                                href="apply.html">Book Now</a>
                                    <div class="offset-top-20"><a class="btn button-default" href="event-page.html">Learn
                                            More</a></div>
                                </div>
                            </div>
                            <div class="unit unit-lg flex-column flex-xl-row">
                                <div class="unit-left">
                                    <div class="post-event-meta text-center">
                                        <div class="h3 font-weight-bold d-inline-block d-xl-block">5</div>
                                        <p class="d-inline-block d-xl-block">July</p><span
                                            class="font-weight-bold d-inline-block d-xl-block inset-left-10 inset-xl-left-0">5:00pm</span>
                                    </div>
                                </div>
                                <div class="unit-body">
                                    <div class="post-event-body text-xl-left">
                                        <h6><a href="event-page.html">International Conference on Biomolecular
                                                Engineering</a></h6>
                                        <ul class="list-inline list-inline-xs">
                                            <li><a href="team-member-profile.html"><span
                                                        class="icon icon-xxs mdi mdi-account-outline text-middle"></span><span
                                                        class="inset-left-10 text-dark text-middle">Raymond Salazar</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-5 col-xxl-3">
                        <article class="post-event">
                            <div class="post-event-img-overlay"><img class="img-responsive"
                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/blog/events-03-420x420.jpg" width="420"
                                                                     height="420" alt="">
                                <div class="post-event-overlay context-dark"><a class="btn button-primary"
                                                                                href="apply.html">Book Now</a>
                                    <div class="offset-top-20"><a class="btn button-default" href="event-page.html">Learn
                                            More</a></div>
                                </div>
                            </div>
                            <div class="unit unit-lg flex-column flex-xl-row">
                                <div class="unit-left">
                                    <div class="post-event-meta text-center">
                                        <div class="h3 font-weight-bold d-inline-block d-xl-block">15</div>
                                        <p class="d-inline-block d-xl-block">May</p><span
                                            class="font-weight-bold d-inline-block d-xl-block inset-left-10 inset-xl-left-0">5:00pm</span>
                                    </div>
                                </div>
                                <div class="unit-body">
                                    <div class="post-event-body text-xl-left">
                                        <h6><a href="event-page.html">Graphic Design Workshop</a></h6>
                                        <ul class="list-inline list-inline-xs">
                                            <li><a href="team-member-profile.html"><span
                                                        class="icon icon-xxs mdi mdi-account-outline text-middle"></span><span
                                                        class="inset-left-10 text-dark text-middle">Bruce Hawkins</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-5 col-xxl-3">
                        <article class="post-event">
                            <div class="post-event-img-overlay"><img class="img-responsive"
                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/blog/events-04-420x420.jpg" width="420"
                                                                     height="420" alt="">
                                <div class="post-event-overlay context-dark"><a class="btn button-primary"
                                                                                href="apply.html">Book Now</a>
                                    <div class="offset-top-20"><a class="btn button-default" href="event-page.html">Learn
                                            More</a></div>
                                </div>
                            </div>
                            <div class="unit unit-lg flex-column flex-xl-row">
                                <div class="unit-left">
                                    <div class="post-event-meta text-center">
                                        <div class="h3 font-weight-bold d-inline-block d-xl-block">5</div>
                                        <p class="d-inline-block d-xl-block">May</p><span
                                            class="font-weight-bold d-inline-block d-xl-block inset-left-10 inset-xl-left-0">5:00pm</span>
                                    </div>
                                </div>
                                <div class="unit-body">
                                    <div class="post-event-body text-xl-left">
                                        <h6><a href="event-page.html">History of Art</a></h6>
                                        <ul class="list-inline list-inline-xs">
                                            <li><a href="team-member-profile.html"><span
                                                        class="icon icon-xxs mdi mdi-account-outline text-middle"></span><span
                                                        class="inset-left-10 text-dark text-middle">Danielle Garza</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="offset-top-50 offset-lg-top-56"><a
                        class="btn btn-ellipse btn-icon btn-icon-right button-primary" href="calendar.html"><span
                            class="icon fa fa-arrow-right"></span><span>View Event Calendar</span></a></div>
            </div>
        </section>
        <!-- Testimonials-->
        <section class="section context-dark parallax-container position-relative"
                 data-parallax-img="{{asset($resourcePathServer.'templates/education')}}/images/parallax-03.jpg">
            <div class="parallax-content">
                <div class="container">
                    <div class="owl-carousel owl-carousel-default carousel-type-1 owl-carousel-nav-xl" data-items="1"
                         data-md-items="2" data-nav="true" data-dots="true" data-margin="30" data-loop="true"
                         data-nav-class="[&quot;owl-prev fa fa-angle-left&quot;, &quot;owl-next fa fa-angle-right&quot;]">
                        <div class="section-xl">
                            <div class="quote-classic-boxed text-left">
                                <div class="quote-body">
                                    <q>I have completed my post-graduation from School of Business Studies at Jonathan
                                        Carroll University, and I am grateful to all the faculties and staff for making me a
                                        true business expert.</q>
                                    <div class="offset-top-30 text-left">
                                        <div class="unit flex-row">
                                            <div class="unit-left"><img class="img-responsive d-inline-block rounded-circle"
                                                                        src="{{asset($resourcePathServer.'templates/education')}}/images/users/user-debra-banks-230x230.jpg"
                                                                        width="80" height="80" alt=""></div>
                                            <div class="unit-body">
                                                <cite class="font-accent">Debra Banks</cite>
                                                <div class="offset-top-5">
                                                    <p class="text-dark font-italic">Business Studies Graduate (MBA)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section-xl">
                            <div class="quote-classic-boxed text-left">
                                <div class="quote-body">
                                    <q> Studying computer science at Jonathan Carroll University has widened my perspective
                                        and has given me a better understanding of my future. Moreover, their campus has a
                                        lot of activities for all students.</q>
                                    <div class="offset-top-30 text-left">
                                        <div class="unit flex-row">
                                            <div class="unit-left"><img class="img-responsive d-inline-block rounded-circle"
                                                                        src="{{asset($resourcePathServer.'templates/education')}}/images/users/user-steven-alvarez-230x230.jpg"
                                                                        width="80" height="80" alt=""></div>
                                            <div class="unit-body">
                                                <cite class="font-accent">Steven Alvarez</cite>
                                                <div class="offset-top-5">
                                                    <p class="text-dark font-italic">Computer Science Graduate (BSc)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section-xl">
                            <div class="quote-classic-boxed text-left">
                                <div class="quote-body">
                                    <q>I have completed my post-graduation from School of Business Studies at Jonathan
                                        Carroll University, and I am grateful to all the faculties and staff for making me a
                                        true business expert.</q>
                                    <div class="offset-top-30 text-left">
                                        <div class="unit flex-row">
                                            <div class="unit-left"><img class="img-responsive d-inline-block rounded-circle"
                                                                        src="{{asset($resourcePathServer.'templates/education')}}/images/users/user-debra-banks-230x230.jpg"
                                                                        width="80" height="80" alt=""></div>
                                            <div class="unit-body">
                                                <cite class="font-accent">Debra Banks</cite>
                                                <div class="offset-top-5">
                                                    <p class="text-dark font-italic">Business Studies Graduate (MBA)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section-xl">
                            <div class="quote-classic-boxed text-left">
                                <div class="quote-body">
                                    <q> Studying computer science at Jonathan Carroll University has widened my perspective
                                        and has given me a better understanding of my future. Moreover, their campus has a
                                        lot of activities for all students.</q>
                                    <div class="offset-top-30 text-left">
                                        <div class="unit flex-row">
                                            <div class="unit-left"><img class="img-responsive d-inline-block rounded-circle"
                                                                        src="{{asset($resourcePathServer.'templates/education')}}/images/users/user-steven-alvarez-230x230.jpg"
                                                                        width="80" height="80" alt=""></div>
                                            <div class="unit-body">
                                                <cite class="font-accent">Steven Alvarez</cite>
                                                <div class="offset-top-5">
                                                    <p class="text-dark font-italic">Computer Science Graduate (BSc)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Latest news-->
        <section class="section bg-catskill section-xl">
            <div class="container container-wide">
                <h2 class="home-headings-custom font-weight-bold view-animate fadeInUpSmall delay-06">Latest News</h2>
                <div class="row row-30 offset-top-60 text-left justify-content-sm-center">
                    <div class="col-md-6 col-lg-3">
                        <article class="post-news post-news-mod-1 view-animate fadeInLeftSm delay-04"><a
                                href="news-post-page.html"><img class="img-responsive img-fullwidth"
                                                                src="{{asset($resourcePathServer.'templates/education')}}/images/blog/news-01-370x240.jpg" width="370"
                                                                height="240" alt=""></a>
                            <div class="post-news-body">
                                <h6><a href="news-post-page.html">Liberal Arts Colleges Rankings</a></h6>
                                <div class="offset-top-20">
                                    <p>Liberal Arts Colleges emphasize undergraduate education. These institutions award at
                                        least half of their degrees in the arts and sciences, which is…</p>
                                </div>
                                <div class="post-news-meta offset-top-20"><span
                                        class="icon icon-xs mdi mdi-calendar-clock text-middle text-madison"></span><span
                                        class="text-middle inset-left-10 font-italic text-black">2 days ago</span></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="post-news post-news-mod-1 view-animate fadeInLeftSm delay-06"><a
                                href="news-post-page.html"><img class="img-responsive img-fullwidth"
                                                                src="{{asset($resourcePathServer.'templates/education')}}/images/blog/news-04-370x240.jpg" width="370"
                                                                height="240" alt=""></a>
                            <div class="post-news-body">
                                <h6><a href="news-post-page.html">Studying in the United States</a></h6>
                                <div class="offset-top-20">
                                    <p>International students increasingly want to come to the United States for college or
                                        graduate school. According to the US Educational System…</p>
                                </div>
                                <div class="post-news-meta offset-top-20"><span
                                        class="icon icon-xs mdi mdi-calendar-clock text-middle text-madison"></span><span
                                        class="text-middle inset-left-10 font-italic text-black">2 days ago</span></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="post-news post-news-mod-1 view-animate fadeInLeftSm delay-08"><a
                                href="news-post-page.html"><img class="img-responsive img-fullwidth"
                                                                src="{{asset($resourcePathServer.'templates/education')}}/images/blog/news-02-370x240.jpg" width="370"
                                                                height="240" alt=""></a>
                            <div class="post-news-body">
                                <h6><a href="news-post-page.html">Paying for Community College</a></h6>
                                <div class="offset-top-20">
                                    <p>Many community colleges offer promise programs, which offer tuition-free awards to
                                        eligible students – mainly to students with Pell grant eligibility...</p>
                                </div>
                                <div class="post-news-meta offset-top-20"><span
                                        class="icon icon-xs mdi mdi-calendar-clock text-middle text-madison"></span><span
                                        class="text-middle inset-left-10 font-italic text-black">2 days ago</span></div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="post-news post-news-mod-1 view-animate fadeInLeftSm delay-1"><a
                                href="news-post-page.html"><img class="img-responsive img-fullwidth"
                                                                src="{{asset($resourcePathServer.'templates/education')}}/images/blog/news-05-370x240.jpg" width="370"
                                                                height="240" alt=""></a>
                            <div class="post-news-body">
                                <h6><a href="news-post-page.html">Summer Prep MBA Programs</a></h6>
                                <div class="offset-top-20">
                                    <p>Summer preparatory programs offered through schools allow students to get a head
                                        start on making connections and building skills…</p>
                                </div>
                                <div class="post-news-meta offset-top-20"><span
                                        class="icon icon-xs mdi mdi-calendar-clock text-middle text-madison"></span><span
                                        class="text-middle inset-left-10 font-italic text-black">2 days ago</span></div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="offset-top-50 view-animate fadeInUpSmall"><a class="btn btn-ellipse button-primary"
                                                                         href="modern-news.html">View All News Posts</a>
                </div>
            </div>
        </section>
        <!-- Gallery Simple-->
        <!-- Gallery-->
        <section class="section">
            <div class="owl-carousel flickr owl-carousel-fullheight" data-items="2" data-sm-items="2" data-autoplay="true"
                 data-md-items="4" data-xxl-items="6" data-nav="false" data-dots="false" data-mouse-drag="true"
                 data-lightgallery="group" data-stage-padding="0" data-xl-stage-padding="0"><a class="thumbnail-default"
                                                                                               data-lightgallery="item"
                                                                                               href="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-1-677x677.jpg"><img
                        width="320" height="320" data-title="alt" src="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-1-677x677.jpg" alt=""><span
                        class="icon fa fa-search-plus"></span></a><a class="thumbnail-default" data-lightgallery="item"
                                                                     href="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-2-677x677.jpg"><img width="320"
                                                                                                                     height="320"
                                                                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-2-677x677.jpg"
                                                                                                                     alt=""><span
                        class="icon fa fa-search-plus"></span></a><a class="thumbnail-default" data-lightgallery="item"
                                                                     href="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-3-677x677.jpg"><img width="320"
                                                                                                                     height="320"
                                                                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-3-677x677.jpg"
                                                                                                                     alt=""><span
                        class="icon fa fa-search-plus"></span></a><a class="thumbnail-default" data-lightgallery="item"
                                                                     href="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-4-677x677.jpg"><img width="320"
                                                                                                                     height="320"
                                                                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-4-677x677.jpg"
                                                                                                                     alt=""><span
                        class="icon fa fa-search-plus"></span></a><a class="thumbnail-default" data-lightgallery="item"
                                                                     href="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-5-677x677.jpg"><img width="320"
                                                                                                                     height="320"
                                                                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-5-677x677.jpg"
                                                                                                                     alt=""><span
                        class="icon fa fa-search-plus"></span></a><a class="thumbnail-default" data-lightgallery="item"
                                                                     href="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-6-677x677.jpg"><img width="320"
                                                                                                                     height="320"
                                                                                                                     src="{{asset($resourcePathServer.'templates/education')}}/images/gallery-simple-6-677x677.jpg"
                                                                                                                     alt=""><span
                        class="icon fa fa-search-plus"></span></a></div>
        </section>
        <!-- Contact info-->
        <section class="section section-xs">
            <div class="container">
                <div class="row row-30 justify-content-sm-center features-list">
                    <div class="col-md-4">
                        <div class="unit flex-column unit-responsive-md section-45">
                            <div class="unit-left"><span class="icon icon-contact-sm text-madison mdi mdi-phone"></span>
                            </div>
                            <div class="unit-body"><a class="h6 text-regular" href="tel:#">1-800-1234-567</a></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="unit flex-column unit-responsive-md section-45">
                            <div class="unit-left"><span
                                    class="icon icon-contact-sm text-madison mdi mdi-map-marker"></span></div>
                            <div class="unit-body"><a class="h6 text-regular" href="#">2130 Fulton Street San Diego, <br
                                        class="d-none d-xl-inline"> CA 94117-1080 USA</a></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="unit flex-column unit-responsive-md section-45">
                            <div class="unit-left"><span
                                    class="icon icon-contact-sm text-madison mdi mdi-email-open"></span></div>
                            <div class="unit-body"><a class="h6 text-regular" href="mailto:#">mail@demolink.org</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Google Map-->
        <!--Google Map-->
        <section class="section">
            <!--Please, add the data attribute data-key="YOUR_API_KEY" in order to insert your own API key for the Google map.-->
            <!--Please note that YOUR_API_KEY should replaced with your key.-->
            <!--Example: <div class="google-map-container" data-key="YOUR_API_KEY">-->
            <div class="google-map-container" data-center="9870 St Vincent Place, Glasgow, DC 45 Fr 45." data-zoom="5"
                 data-icon="images/gmap_marker.png" data-icon-active="images/gmap_marker_active.png"
                 data-styles="[{&quot;featureType&quot;:&quot;landscape&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:-100},{&quot;lightness&quot;:60}]},{&quot;featureType&quot;:&quot;road.local&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:-100},{&quot;lightness&quot;:40},{&quot;visibility&quot;:&quot;on&quot;}]},{&quot;featureType&quot;:&quot;transit&quot;,&quot;stylers&quot;:[{&quot;saturation&quot;:-100},{&quot;visibility&quot;:&quot;simplified&quot;}]},{&quot;featureType&quot;:&quot;administrative.province&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;water&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;on&quot;},{&quot;lightness&quot;:30}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#ef8c25&quot;},{&quot;lightness&quot;:40}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;elementType&quot;:&quot;geometry.stroke&quot;,&quot;stylers&quot;:[{&quot;visibility&quot;:&quot;off&quot;}]},{&quot;featureType&quot;:&quot;poi.park&quot;,&quot;elementType&quot;:&quot;geometry.fill&quot;,&quot;stylers&quot;:[{&quot;color&quot;:&quot;#b6c54c&quot;},{&quot;lightness&quot;:40},{&quot;saturation&quot;:-40}]},{}]">
                <div class="google-map"></div>
                <ul class="google-map-markers">
                    <li data-location="9870 St Vincent Place, Glasgow, DC 45 Fr 45."
                        data-description="9870 St Vincent Place, Glasgow"></li>
                </ul>
            </div>
        </section>
        <!-- Corporate footer-->
        <footer class="page-footer">
            <div class="container section-xs section-bottom-20">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-3 col-xl-2">
                        <!--Footer brand--><a class="d-inline-block view-animate zoomInSmall delay-06"
                                              href="index.html"><img width="65" height="65" src="{{asset($resourcePathServer.'templates/education')}}/images/logo-170x172.png"
                                                                     alt="">
                            <div>
                                <h6 class="barnd-name font-weight-bold offset-top-12">Jonathan Carroll</h6>
                            </div>
                            <div>
                                <p class="brand-slogan text-gray font-italic font-accent">University</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 offset-top-15 offset-sm-top-40 text-center">
                        <ul class="list-inline list-inline-xs list-inline-madison">
                            <li>
                                <a class="icon novi-icon icon-xxs fa fa-facebook icon-circle icon-gray-light-filled view-animate zoomInSmall delay-04"
                                   href="#"></a></li>
                            <li>
                                <a class="icon novi-icon icon-xxs fa fa-twitter icon-circle icon-gray-light-filled view-animate zoomInSmall delay-06"
                                   href="#"></a></li>
                            <li>
                                <a class="icon novi-icon icon-xxs fa fa-google icon-circle icon-gray-light-filled view-animate zoomInSmall delay-08"
                                   href="#"></a></li>
                            <li>
                                <a class="icon novi-icon icon-xxs fa fa-instagram icon-circle icon-gray-light-filled view-animate zoomInSmall delay-1"
                                   href="#"></a></li>
                        </ul>
                    </div>
                    <div class="col-sm-12 text-center offset-top-20 offset-sm-top-45">
                        <p class="rights"><span>&copy;&nbsp;</span><span
                                class="copyright-year"></span><span>&nbsp;</span><span>Jonathan Carroll</span><span>.&nbsp;</span><a
                                class="text-dark" href="privacy-policy.html">Privacy Policy</a>. Design&nbsp;by&nbsp;<a
                                class="text-dark" href="https://zemez.io/">Zemez</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Java script-->

@endsection
