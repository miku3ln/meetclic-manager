<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
?>

<html lang="es-CO" class=" no-svg js csstransitions">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <title>Listing – Bee</title>
    <link rel="dns-prefetch" href="//maps.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//s.w.org">
    <link href="https://fonts.gstatic.com" crossorigin="" rel="preconnect">
    <link rel="alternate" type="application/rss+xml" title="Bee » Feed"
          href="http://citybook.meetclic.com/index.php/feed/">
    <link rel="alternate" type="application/rss+xml" title="Bee » RSS de los comentarios"
          href="http://citybook.meetclic.com/index.php/comments/feed/">
    <link rel="alternate" type="application/rss+xml" title="Bee » Listing Feed"
          href="http://citybook.meetclic.com/index.php/listing/feed/">

    @include('layouts.cityBook.head')

    <link rel="stylesheet" id="litespeed-cache-css"
          href="http://citybook.meetclic.com/wp-content/plugins/litespeed-cache/css/litespeed.css?ver=2.9.9.2"
          type="text/css" media="all">
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-includes/js/jquery/jquery.js?ver=1.12.4-wp"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/plugins/miniorange-login-openid/includes/js/jquery.cookie.min.js?ver=5.4"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/plugins/miniorange-login-openid/includes/js/social_login.js?ver=5.4"></script>
    <script type="text/javascript"
            src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/Scrollax.js?ver=1"></script>

    <link rel="https://api.w.org/" href="http://citybook.meetclic.com/index.php/wp-json/">
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://citybook.meetclic.com/xmlrpc.php?rsd">
    <link rel="wlwmanifest" type="application/wlwmanifest+xml"
          href="http://citybook.meetclic.com/wp-includes/wlwmanifest.xml">


    {{--INIT GOOGLE--}}
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy7FfEU_fOeVTrJKxENPLxAor4cL6_d88&amp;libraries=places&amp;ver=5.4"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/common.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/util.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/controls.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/places_impl.js"></script>

    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/map.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/marker.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/overlay.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/stats.js"></script>
    <script type="text/javascript" charset="UTF-8"
            src="https://maps.googleapis.com/maps-api-v3/api/js/40/10/onion.js"></script>
    <style type="text/css">@-webkit-keyframes _gm6743 {
                               0% {
                                   -webkit-transform: translate3d(0px, -500px, 0);
                                   -webkit-animation-timing-function: ease-in;
                               }
                               50% {
                                   -webkit-transform: translate3d(0px, 0px, 0);
                                   -webkit-animation-timing-function: ease-out;
                               }
                               75% {
                                   -webkit-transform: translate3d(0px, -20px, 0);
                                   -webkit-animation-timing-function: ease-in;
                               }
                               100% {
                                   -webkit-transform: translate3d(0px, 0px, 0);
                                   -webkit-animation-timing-function: ease-out;
                               }
                           }
    </style>
</head>
<?php
$nameRoute = Route::currentRouteName();
$classBody = 'home page-template page-template-home-fullscreen page-template-home-fullscreen-php page page-id-545 theme-citybook body-citybook woocommerce-js folio-archive- citybook-front-page elementor-default elementor-kit-6078 elementor-page elementor-page-545';


if ($nameRoute == 'search') {
    $classBody = 'archive post-type-archive post-type-archive-listing logged-in theme-citybook body-citybook woocommerce-js folio-archive- hfeed elementor-default customize-support';

}
?>
<body
    class="archive post-type-archive post-type-archive-listing logged-in theme-citybook body-citybook woocommerce-js folio-archive- hfeed elementor-default customize-support"
    cz-shortcut-listen="true">
<!--loader-->
<div class="loader-wrap">
    <div class="loader-inner">
        <div class="pin"></div>
        <div class="pulse"></div>
    </div>
</div>
<!--loader end-->
<div id="main-theme">

    <!-- header-->
    <header id="masthead" class="citybook-header main-header dark-header fs-header sticky">

        <div class="header-inner">
            <div class="logo-holder">
                <a class="custom-logo-link logo-text" href="http://citybook.meetclic.com/"><h2>Bee</h2></a></div>


            <div class="header-search vis-header-search">
                <form role="search" method="get" action="http://citybook.meetclic.com/" class="list-search-header-form">

                    <div
                        class="azp_element azp-element-jsl7tywc5 azp_row_section azp_row_section-default azp_row_section-0-gap">

                        <div class="azp_container">
                            <div class="azp_row azp_row-wrap">
                                <div class="azp_element azp-element-jsl7tywcm azp_col azp-col-33">
                                    <div class="azp_element azp_filter_destination azp-element-jsl7u3ler">
                                        <div class="header-search-input-item">
                                            <input name="search_term" id="hero_search_loc" type="text" class="search"
                                                   placeholder="Keywords" value="">

                                        </div>
                                    </div>
                                </div>
                                <div class="azp_element azp-element-jsl7tzwlv azp_col azp-col-33">


                                    <div class="azp_element azp_filter_category azp-element-jsl7u7q5m">
                                        <div class="header-search-select-item">
                                            <select id="search_lcats-5ea4b1d656ffa" data-placeholder="All Categories"
                                                    class="search_lcats chosen-select" name="lcats[]"
                                            >
                                                <option value="">All Categories</option>
                                                <option value="36">Cars</option>
                                                <option value="47">Events</option>
                                                <option value="48">Fitness</option>
                                                <option value="60">Hotels</option>
                                                <option value="81">Restaurants</option>
                                                <option value="89">Shops</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="azp_element azp-element-jsl7u08hw azp_col azp-col-33">
                                    <div class="azp_element azp_filter_button azp-element-jsl7uhlsn">
                                        <button class="header-search-button" type="submit">Search</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- <input type="hidden" name="post_type" value="listing"> -->
                </form>
            </div>
            <div class="show-search-button"><i class="fa fa-search"></i> <span>Search</span></div>
            @if(Auth::check())
                <a href="http://citybook.meetclic.com/index.php/submit-listing/" class="add-list">Add Listing <span><i
                            class="fa fa-plus"></i></span></a>
                <div class="header-user-menu user-menu-two">
                    <div class="header-user-name user-name-two">
                    <span class="au-avatar">
                        <img alt="leonel_lema"
                             srcset="http://2.gravatar.com/avatar/5840e3cad2bb1daa95c081908423565f?s=160&amp;d=https%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D80&amp;r=g 2x"
                             class="avatar avatar-80 photo lazy loaded" height="80" width="80"
                             data-src="http://2.gravatar.com/avatar/5840e3cad2bb1daa95c081908423565f?s=80&amp;d=https%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D80&amp;r=g"
                             data-lazy="http://2.gravatar.com/avatar/5840e3cad2bb1daa95c081908423565f?s=80&amp;d=https%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D80&amp;r=g"
                             src="http://2.gravatar.com/avatar/5840e3cad2bb1daa95c081908423565f?s=80&amp;d=https%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D80&amp;r=g"
                             data-was-processed="true">
                    </span>
                    </div>
                    <ul class="head-user-menu">
                        <li class="user-menu-details">
                            <div class="au-name-li">
                                <h2 class="au-name">Hello , leonel_lema</h2>
                                <div class="au-role">Administrator</div>
                                <div class="au-earning"><a
                                        href="http://citybook.meetclic.com/index.php/dashboard/?dashboard=withdrawals">Earning:
                                        $&nbsp;0.00</a></div>
                            </div>
                        </li>
                        <li class="user-menu-dashboard"><a href="http://citybook.meetclic.com/index.php/dashboard/">Dashboard</a>
                        </li>
                        <li class="user-menu-addlisting"><a
                                href="http://citybook.meetclic.com/index.php/submit-listing/">Add
                                Listing</a></li>
                        <li class="user-menu-bookings"><a
                                href="http://citybook.meetclic.com/index.php/dashboard/?dashboard=bookings">Bookings</a>
                        </li>
                        <li class="user-menu-reviews"><a
                                href="http://citybook.meetclic.com/index.php/dashboard/?dashboard=reviews">Reviews</a>
                        </li>
                        <li class="user-menu-logout"><a
                                href="http://citybook.meetclic.com/wp-login.php?action=logout&amp;redirect_to=http%3A%2F%2Fcitybook.meetclic.com%3Fsearch_term%26location_search%26nearby%3Doff%26address_lat%26address_lng%26distance%3D5%26lcats%255B%255D%3D&amp;_wpnonce=6003c6420a">Log
                                Out</a></li>
                    </ul>
                </div>
            @else



                <a href="#" class="add-list logreg-modal-open" data-message="You must be logged in to add listings.">
                    Add Listing <span><i class="fa fa-plus"></i></span>
                </a>
                <div class="show-reg-form logreg-modal-open"><i class="fa fa-sign-in"></i>Sign In</div>
            @endif

            <!-- nav-button-wrap-->
            <div class="nav-button-wrap color-bg">
                <div class="nav-button">
                    <span></span><span></span><span></span>
                </div>
            </div>
            <!-- nav-button-wrap end-->
            <div class="attr-nav">
                <ul>
                    <li>
                        <a href="#" class="cart-link">
                            <i class="fa fa-shopping-bag"></i>
                            <span class="cart-count">0</span>
                        </a>
                        <ul class="cart-list">
                            <li>
                                <div class="widget_shopping_cart_content">

                                    <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>


                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </header>
    <!--  header end -->
    <!--  wrapper  -->
    <div id="wrapper">
        <!-- Content-->
        <div class="content">
            @yield('content')

        </div>
        <!-- Content end -->
    </div>
    <!-- wrapper end -->
    <!--footer -->
    <footer class="citybook-footer main-footer dark-footer  ">

        <div class="sub-footer fl-wrap no-fwids">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <div class="copyright">
                            <span class="ft-copy">© CityBook 2019.  All rights reserved.</span></div>
                    </div>
                    <div class="col-md-4 subfooter-right">
                        <div class="footer-social">
                            <ul id="menu-social-links-menu" class="social-links-menu">
                                <li id="menu-item-23"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-23"><a
                                        target="_blank" rel="noopener noreferrer"
                                        href="https://www.facebook.com/wordpress"><i class="fa fa-facebook"
                                                                                     aria-hidden="true"></i><span
                                            class="social-title">Facebook</span></a></li>
                                <li id="menu-item-24"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-24"><a
                                        target="_blank" rel="noopener noreferrer"
                                        href="https://twitter.com/wordpress"><i class="fa fa-twitter"
                                                                                aria-hidden="true"></i><span
                                            class="social-title">Twitter</span></a></li>
                                <li id="menu-item-25"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-25"><a
                                        target="_blank" rel="noopener noreferrer"
                                        href="https://www.instagram.com/explore/tags/wordcamp/"><i
                                            class="fa fa-instagram" aria-hidden="true"></i><span class="social-title">Instagram</span></a>
                                </li>
                                <li id="menu-item-22"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-22"><a
                                        target="_blank" rel="noopener noreferrer" href="https://www.pinterest.com"><i
                                            class="fa fa-pinterest-p" aria-hidden="true"></i><span class="social-title">pinterest</span></a>
                                </li>
                                <li id="menu-item-26"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-26"><a
                                        target="_blank" rel="noopener noreferrer" href="http://tumblr.com"><i
                                            class="fa fa-tumblr" aria-hidden="true"></i><span class="social-title">tumblr</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="currencies-wrap">
                            <div class="show-currency-tooltip"><i class="currency-symbol">$</i><span>USD<i
                                        class="fa fa-caret-down"></i></span></div>
                            <ul class="currency-tooltip currency-switcher">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer end  -->


    <a class="to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>
</div>
<!-- Main end -->
<div id="chat-app">
    <div>
        <div class="chat-widget-button"><i class="fa fa-comments"></i><span>Chat With Owner</span></div>
        <div class="chat-widget_wrap">
            <div>
                <div class="chat-widget_header color-bg">
                    <div class="chats-title"><h3 class="tit-hidden">Conversation list</h3></div>
                    <div class="chats-desc">
                        <div class="chatbox-desc">We are here to help. Please ask us anything or share your feedback
                        </div>
                        <svg viewBox="0 0 500 120" preserveAspectRatio="none">
                            <path d="M0,50 C200,95 320, 12 500,65 L500,200 L00,200 Z"></path>
                        </svg>
                    </div>
                </div>
                <div class="chat-contacts-wrap">
                    <div class="chat-contacts fl-wrap"><a class="contact-item active" href="#">
                            <div class="contact-avatar"><img alt="leonel_lema" class="avatar avatar-150 photo"
                                                             height="150" width="150"
                                                             src="http://2.gravatar.com/avatar/5840e3cad2bb1daa95c081908423565f?s=150&amp;d=https%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D150&amp;r=g">
                            </div>
                            <div class="contact-content"><h4 class="display_name">leonel_lema</h4><span
                                    class="contact-date">24 abril, 2020</span>
                                <div class="contact-reply-text">Hello, I am the site admin.<br>May I help you?</div>
                            </div>
                        </a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.cityBook.templatesReact')


<!-- end reset password modal -->

<!--ajax-modal-container-->
<div class="ajax-modal-overlay"></div>
<div class="ajax-modal-container">
    <!--ajax-modal -->
    <div class="ajax-loader">
        <div class="ajax-loader-cirle"></div>
    </div>
    <div id="ajax-modal" class="fl-wrap">

    </div><!--#ajax-modal end -->
</div>


<!--ajax-modal-container-->
<div class="ajax-modal-overlay"></div>
<div class="ajax-modal-container">
    <!--ajax-modal -->
    <div class="ajax-loader">
        <div class="ajax-loader-cirle"></div>
    </div>
    <div id="ajax-modal" class="fl-wrap"></div><!--#ajax-modal end -->
</div>
<!--ajax-modal-container end -->
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/hoverintent-js.min.js?ver=2.2.1"></script>
<script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/admin-bar.min.js?ver=5.4"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/plugins.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/moment.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/select2.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/jquery.mousewheel.js"></script>

<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/infobox.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/markerclusterer.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/oms.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill.min.js?ver=7.4.4"></script>
<script type="text/javascript">
    ('fetch' in window) || document.write('<script src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill-fetch.min.js?ver=3.0.0"></scr' + 'ipt>');
    (document.contains) || document.write('<script src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill-node-contains.min.js?ver=3.42.0"></scr' + 'ipt>');
    (window.DOMRect) || document.write('<script src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill-dom-rect.min.js?ver=3.42.0"></scr' + 'ipt>');
    (window.URL && window.URL.prototype && window.URLSearchParams) || document.write('<script src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill-url.min.js?ver=3.6.4"></scr' + 'ipt>');
    (window.FormData && window.FormData.prototype.keys) || document.write('<script src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill-formdata.min.js?ver=3.0.12"></scr' + 'ipt>');
    (Element.prototype.matches && Element.prototype.closest) || document.write('<script src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/wp-polyfill-element-closest.min.js?ver=2.0.2"></scr' + 'ipt>');
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/dist/i18n.min.js?ver=cced130522e86c87a37cd7b8397b882c"></script>
<script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/underscore.min.js?ver=1.8.3"></script>
<script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/imagesloaded.min.js?ver=3.2.0"></script>
<script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/masonry.min.js?ver=3.3.2"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/widget.min.js?ver=1.11.4"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/mouse.min.js?ver=1.11.4"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/sortable.min.js?ver=1.11.4"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var _citybook_add_ons = {
        "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin-ajax.php",
        "nonce": "cf46735336",
        "posted_on": "Posted on ",
        "reply": "Reply",
        "retweet": "Retweet",
        "favorite": "Favorite",
        "pl_w": "Please wait...",
        "like": "Like",
        "unlike": "Unlike",
        "marker": "http:\/\/citybook.meetclic.com\/wp-content\/plugins\/citybook-add-ons\/assets\/images\/marker.png",
        "center_lat": "40.7",
        "center_lng": "-73.87",
        "map_zoom": "10",
        "socials": {
            "facebook": "Facebook",
            "twitter": "Twitter",
            "youtube": "Youtube",
            "vimeo": "Vimeo",
            "instagram": "Instagram",
            "vk": "Vkontakte",
            "reddit": "Reddit",
            "pinterest": "Pinterest",
            "vine": "Vine Camera",
            "tumblr": "Tumblr",
            "flickr": "Flickr",
            "google-plus-g": "Google+",
            "linkedin": "LinkedIn",
            "whatsapp": "Whatsapp",
            "meetup": "Meetup",
            "custom_icon": "Custom"
        },
        "gmap_type": "ROADMAP",
        "login_delay": "5000",
        "files": {
            "category": [{"id": 36, "name": "Cars", "level": 0}, {
                "id": 47,
                "name": "Events",
                "level": 0
            }, {"id": 48, "name": "Fitness", "level": 0}, {"id": 60, "name": "Hotels", "level": 0}, {
                "id": 81,
                "name": "Restaurants",
                "level": 0
            }, {"id": 89, "name": "Shops", "level": 0}],
            "location": [{"value": 106, "label": "Albany"}, {"value": 107, "label": "Astoria"}, {
                "value": 108,
                "label": "Bronx"
            }, {"value": 109, "label": "Brooklyn"}, {"value": 110, "label": "Manhattan"}, {
                "value": 111,
                "label": "Melville"
            }, {"value": 112, "label": "New Jersey"}, {"value": 113, "label": "New York"}, {
                "value": 114,
                "label": "Passaic"
            }, {"value": 115, "label": "Ridgewood"}, {"value": 98, "label": "United States"}]
        },
        "features": [{"name": "Accepts Credit Cards", "id": 24}, {"name": "Accessories", "id": 25}, {
            "name": "Alcohol",
            "id": 30
        }, {"name": "Bike Parking", "id": 33}, {"name": "Electronics", "id": 44}, {
            "name": "Elevator in building",
            "id": 45
        }, {"name": "Friendly workspace", "id": 52}, {"name": "Good for Kids", "id": 53}, {
            "name": "Instant Book",
            "id": 62
        }, {"name": "Men Clothing", "id": 71}, {"name": "Parking street", "id": 76}, {
            "name": "Reservations",
            "id": 79
        }, {"name": "Smoking Allowed", "id": 91}, {"name": "Sporting Goods", "id": 94}, {
            "name": "Wheelchair Accesible",
            "id": 99
        }, {"name": "Wireless Internet", "id": 101}, {"name": "Women Clothing", "id": 103}],
        "listing_type_opts": [],
        "chatbox_message": "",
        "submit_timezone_hide": "no",
        "working_days": {
            "Monday": "Monday",
            "Tuesday": "Tuesday",
            "Wednesday": "Wednesday",
            "Thursday": "Thursday",
            "Friday": "Friday",
            "Saturday": "Saturday",
            "Sunday": "Sunday"
        },
        "working_hours": {
            "0:00": "00:00",
            "0:30": "00:30",
            "1:00": "01:00",
            "1:30": "01:30",
            "2:00": "02:00",
            "2:30": "02:30",
            "3:00": "03:00",
            "3:30": "03:30",
            "4:00": "04:00",
            "4:30": "04:30",
            "5:00": "05:00",
            "5:30": "05:30",
            "6:00": "06:00",
            "6:30": "06:30",
            "7:00": "07:00",
            "7:30": "07:30",
            "8:00": "08:00",
            "8:30": "08:30",
            "9:00": "09:00",
            "9:30": "09:30",
            "10:00": "10:00",
            "10:30": "10:30",
            "11:00": "11:00",
            "11:30": "11:30",
            "12:00": "12:00",
            "12:30": "12:30",
            "13:00": "13:00",
            "13:30": "13:30",
            "14:00": "14:00",
            "14:30": "14:30",
            "15:00": "15:00",
            "15:30": "15:30",
            "16:00": "16:00",
            "16:30": "16:30",
            "17:00": "17:00",
            "17:30": "17:30",
            "18:00": "18:00",
            "18:30": "18:30",
            "19:00": "19:00",
            "19:30": "19:30",
            "20:00": "20:00",
            "20:30": "20:30",
            "21:00": "21:00",
            "21:30": "21:30",
            "22:00": "22:00",
            "22:30": "22:30",
            "23:00": "23:00",
            "23:30": "23:30",
            "24:00": "24:00"
        },
        "timezones": {
            "Pacific\/Pago_Pago": "(UTC-11:00) Pacific\/Pago_Pago",
            "Pacific\/Midway": "(UTC-11:00) Pacific\/Midway",
            "Pacific\/Niue": "(UTC-11:00) Pacific\/Niue",
            "Pacific\/Honolulu": "(UTC-10:00) Pacific\/Honolulu",
            "Pacific\/Tahiti": "(UTC-10:00) Pacific\/Tahiti",
            "Pacific\/Rarotonga": "(UTC-10:00) Pacific\/Rarotonga",
            "Pacific\/Marquesas": "(UTC-09:30) Pacific\/Marquesas",
            "America\/Adak": "(UTC-09:00) America\/Adak",
            "Pacific\/Gambier": "(UTC-09:00) Pacific\/Gambier",
            "America\/Anchorage": "(UTC-08:00) America\/Anchorage",
            "America\/Nome": "(UTC-08:00) America\/Nome",
            "America\/Sitka": "(UTC-08:00) America\/Sitka",
            "America\/Yakutat": "(UTC-08:00) America\/Yakutat",
            "America\/Metlakatla": "(UTC-08:00) America\/Metlakatla",
            "America\/Juneau": "(UTC-08:00) America\/Juneau",
            "Pacific\/Pitcairn": "(UTC-08:00) Pacific\/Pitcairn",
            "America\/Phoenix": "(UTC-07:00) America\/Phoenix",
            "America\/Creston": "(UTC-07:00) America\/Creston",
            "America\/Dawson": "(UTC-07:00) America\/Dawson",
            "America\/Los_Angeles": "(UTC-07:00) America\/Los_Angeles",
            "America\/Dawson_Creek": "(UTC-07:00) America\/Dawson_Creek",
            "America\/Whitehorse": "(UTC-07:00) America\/Whitehorse",
            "America\/Hermosillo": "(UTC-07:00) America\/Hermosillo",
            "America\/Fort_Nelson": "(UTC-07:00) America\/Fort_Nelson",
            "America\/Tijuana": "(UTC-07:00) America\/Tijuana",
            "America\/Vancouver": "(UTC-07:00) America\/Vancouver",
            "America\/Chihuahua": "(UTC-06:00) America\/Chihuahua",
            "America\/Cambridge_Bay": "(UTC-06:00) America\/Cambridge_Bay",
            "America\/Boise": "(UTC-06:00) America\/Boise",
            "America\/Denver": "(UTC-06:00) America\/Denver",
            "America\/El_Salvador": "(UTC-06:00) America\/El_Salvador",
            "America\/Costa_Rica": "(UTC-06:00) America\/Costa_Rica",
            "America\/Mazatlan": "(UTC-06:00) America\/Mazatlan",
            "America\/Ojinaga": "(UTC-06:00) America\/Ojinaga",
            "America\/Guatemala": "(UTC-06:00) America\/Guatemala",
            "America\/Edmonton": "(UTC-06:00) America\/Edmonton",
            "America\/Inuvik": "(UTC-06:00) America\/Inuvik",
            "America\/Belize": "(UTC-06:00) America\/Belize",
            "America\/Managua": "(UTC-06:00) America\/Managua",
            "America\/Regina": "(UTC-06:00) America\/Regina",
            "America\/Tegucigalpa": "(UTC-06:00) America\/Tegucigalpa",
            "Pacific\/Easter": "(UTC-06:00) Pacific\/Easter",
            "Pacific\/Galapagos": "(UTC-06:00) Pacific\/Galapagos",
            "America\/Yellowknife": "(UTC-06:00) America\/Yellowknife",
            "America\/Swift_Current": "(UTC-06:00) America\/Swift_Current",
            "America\/Monterrey": "(UTC-05:00) America\/Monterrey",
            "America\/Bahia_Banderas": "(UTC-05:00) America\/Bahia_Banderas",
            "America\/Bogota": "(UTC-05:00) America\/Bogota",
            "America\/Cancun": "(UTC-05:00) America\/Cancun",
            "America\/Merida": "(UTC-05:00) America\/Merida",
            "America\/Chicago": "(UTC-05:00) America\/Chicago",
            "America\/Winnipeg": "(UTC-05:00) America\/Winnipeg",
            "America\/Menominee": "(UTC-05:00) America\/Menominee",
            "America\/Eirunepe": "(UTC-05:00) America\/Eirunepe",
            "America\/Atikokan": "(UTC-05:00) America\/Atikokan",
            "America\/Matamoros": "(UTC-05:00) America\/Matamoros",
            "America\/Guayaquil": "(UTC-05:00) America\/Guayaquil",
            "America\/Indiana\/Knox": "(UTC-05:00) America\/Indiana\/Knox",
            "America\/Indiana\/Tell_City": "(UTC-05:00) America\/Indiana\/Tell_City",
            "America\/Jamaica": "(UTC-05:00) America\/Jamaica",
            "America\/Lima": "(UTC-05:00) America\/Lima",
            "America\/Mexico_City": "(UTC-05:00) America\/Mexico_City",
            "America\/Cayman": "(UTC-05:00) America\/Cayman",
            "America\/Rainy_River": "(UTC-05:00) America\/Rainy_River",
            "America\/Rankin_Inlet": "(UTC-05:00) America\/Rankin_Inlet",
            "America\/Rio_Branco": "(UTC-05:00) America\/Rio_Branco",
            "America\/North_Dakota\/Center": "(UTC-05:00) America\/North_Dakota\/Center",
            "America\/Panama": "(UTC-05:00) America\/Panama",
            "America\/Resolute": "(UTC-05:00) America\/Resolute",
            "America\/North_Dakota\/New_Salem": "(UTC-05:00) America\/North_Dakota\/New_Salem",
            "America\/North_Dakota\/Beulah": "(UTC-05:00) America\/North_Dakota\/Beulah",
            "America\/New_York": "(UTC-04:00) America\/New_York",
            "America\/Puerto_Rico": "(UTC-04:00) America\/Puerto_Rico",
            "America\/Porto_Velho": "(UTC-04:00) America\/Porto_Velho",
            "America\/Grand_Turk": "(UTC-04:00) America\/Grand_Turk",
            "America\/Guadeloupe": "(UTC-04:00) America\/Guadeloupe",
            "America\/Grenada": "(UTC-04:00) America\/Grenada",
            "America\/Marigot": "(UTC-04:00) America\/Marigot",
            "America\/Martinique": "(UTC-04:00) America\/Martinique",
            "America\/Port_of_Spain": "(UTC-04:00) America\/Port_of_Spain",
            "America\/Port-au-Prince": "(UTC-04:00) America\/Port-au-Prince",
            "America\/Guyana": "(UTC-04:00) America\/Guyana",
            "America\/Indiana\/Indianapolis": "(UTC-04:00) America\/Indiana\/Indianapolis",
            "America\/Manaus": "(UTC-04:00) America\/Manaus",
            "America\/Havana": "(UTC-04:00) America\/Havana",
            "America\/Tortola": "(UTC-04:00) America\/Tortola",
            "America\/Indiana\/Marengo": "(UTC-04:00) America\/Indiana\/Marengo",
            "America\/Indiana\/Petersburg": "(UTC-04:00) America\/Indiana\/Petersburg",
            "America\/Indiana\/Vevay": "(UTC-04:00) America\/Indiana\/Vevay",
            "America\/Indiana\/Vincennes": "(UTC-04:00) America\/Indiana\/Vincennes",
            "America\/Indiana\/Winamac": "(UTC-04:00) America\/Indiana\/Winamac",
            "America\/Iqaluit": "(UTC-04:00) America\/Iqaluit",
            "America\/Kentucky\/Louisville": "(UTC-04:00) America\/Kentucky\/Louisville",
            "America\/Kentucky\/Monticello": "(UTC-04:00) America\/Kentucky\/Monticello",
            "America\/Kralendijk": "(UTC-04:00) America\/Kralendijk",
            "America\/La_Paz": "(UTC-04:00) America\/La_Paz",
            "America\/Pangnirtung": "(UTC-04:00) America\/Pangnirtung",
            "America\/Dominica": "(UTC-04:00) America\/Dominica",
            "America\/Nassau": "(UTC-04:00) America\/Nassau",
            "America\/Campo_Grande": "(UTC-04:00) America\/Campo_Grande",
            "America\/Montserrat": "(UTC-04:00) America\/Montserrat",
            "America\/Lower_Princes": "(UTC-04:00) America\/Lower_Princes",
            "America\/Aruba": "(UTC-04:00) America\/Aruba",
            "America\/Asuncion": "(UTC-04:00) America\/Asuncion",
            "America\/Nipigon": "(UTC-04:00) America\/Nipigon",
            "America\/Barbados": "(UTC-04:00) America\/Barbados",
            "America\/St_Barthelemy": "(UTC-04:00) America\/St_Barthelemy",
            "America\/St_Kitts": "(UTC-04:00) America\/St_Kitts",
            "America\/Blanc-Sablon": "(UTC-04:00) America\/Blanc-Sablon",
            "America\/Boa_Vista": "(UTC-04:00) America\/Boa_Vista",
            "America\/Detroit": "(UTC-04:00) America\/Detroit",
            "America\/St_Thomas": "(UTC-04:00) America\/St_Thomas",
            "America\/St_Lucia": "(UTC-04:00) America\/St_Lucia",
            "America\/Caracas": "(UTC-04:00) America\/Caracas",
            "America\/Thunder_Bay": "(UTC-04:00) America\/Thunder_Bay",
            "America\/Toronto": "(UTC-04:00) America\/Toronto",
            "America\/Antigua": "(UTC-04:00) America\/Antigua",
            "America\/St_Vincent": "(UTC-04:00) America\/St_Vincent",
            "America\/Anguilla": "(UTC-04:00) America\/Anguilla",
            "America\/Santiago": "(UTC-04:00) America\/Santiago",
            "America\/Cuiaba": "(UTC-04:00) America\/Cuiaba",
            "America\/Curacao": "(UTC-04:00) America\/Curacao",
            "America\/Santo_Domingo": "(UTC-04:00) America\/Santo_Domingo",
            "America\/Montevideo": "(UTC-03:00) America\/Montevideo",
            "America\/Paramaribo": "(UTC-03:00) America\/Paramaribo",
            "America\/Moncton": "(UTC-03:00) America\/Moncton",
            "America\/Sao_Paulo": "(UTC-03:00) America\/Sao_Paulo",
            "Atlantic\/Stanley": "(UTC-03:00) Atlantic\/Stanley",
            "America\/Thule": "(UTC-03:00) America\/Thule",
            "America\/Santarem": "(UTC-03:00) America\/Santarem",
            "Antarctica\/Rothera": "(UTC-03:00) Antarctica\/Rothera",
            "America\/Punta_Arenas": "(UTC-03:00) America\/Punta_Arenas",
            "Antarctica\/Palmer": "(UTC-03:00) Antarctica\/Palmer",
            "America\/Recife": "(UTC-03:00) America\/Recife",
            "Atlantic\/Bermuda": "(UTC-03:00) Atlantic\/Bermuda",
            "America\/Maceio": "(UTC-03:00) America\/Maceio",
            "America\/Argentina\/Ushuaia": "(UTC-03:00) America\/Argentina\/Ushuaia",
            "America\/Argentina\/Jujuy": "(UTC-03:00) America\/Argentina\/Jujuy",
            "America\/Argentina\/Buenos_Aires": "(UTC-03:00) America\/Argentina\/Buenos_Aires",
            "America\/Argentina\/La_Rioja": "(UTC-03:00) America\/Argentina\/La_Rioja",
            "America\/Argentina\/Mendoza": "(UTC-03:00) America\/Argentina\/Mendoza",
            "America\/Argentina\/Rio_Gallegos": "(UTC-03:00) America\/Argentina\/Rio_Gallegos",
            "America\/Argentina\/Salta": "(UTC-03:00) America\/Argentina\/Salta",
            "America\/Argentina\/San_Juan": "(UTC-03:00) America\/Argentina\/San_Juan",
            "America\/Argentina\/San_Luis": "(UTC-03:00) America\/Argentina\/San_Luis",
            "America\/Argentina\/Tucuman": "(UTC-03:00) America\/Argentina\/Tucuman",
            "America\/Araguaina": "(UTC-03:00) America\/Araguaina",
            "America\/Argentina\/Catamarca": "(UTC-03:00) America\/Argentina\/Catamarca",
            "America\/Bahia": "(UTC-03:00) America\/Bahia",
            "America\/Belem": "(UTC-03:00) America\/Belem",
            "America\/Cayenne": "(UTC-03:00) America\/Cayenne",
            "America\/Fortaleza": "(UTC-03:00) America\/Fortaleza",
            "America\/Glace_Bay": "(UTC-03:00) America\/Glace_Bay",
            "America\/Goose_Bay": "(UTC-03:00) America\/Goose_Bay",
            "America\/Halifax": "(UTC-03:00) America\/Halifax",
            "America\/Argentina\/Cordoba": "(UTC-03:00) America\/Argentina\/Cordoba",
            "America\/St_Johns": "(UTC-02:30) America\/St_Johns",
            "Atlantic\/South_Georgia": "(UTC-02:00) Atlantic\/South_Georgia",
            "America\/Noronha": "(UTC-02:00) America\/Noronha",
            "America\/Miquelon": "(UTC-02:00) America\/Miquelon",
            "America\/Godthab": "(UTC-02:00) America\/Godthab",
            "Atlantic\/Cape_Verde": "(UTC-01:00) Atlantic\/Cape_Verde",
            "Africa\/Lome": "(UTC+00:00) Africa\/Lome",
            "Africa\/Casablanca": "(UTC+00:00) Africa\/Casablanca",
            "Africa\/Freetown": "(UTC+00:00) Africa\/Freetown",
            "Africa\/El_Aaiun": "(UTC+00:00) Africa\/El_Aaiun",
            "Africa\/Dakar": "(UTC+00:00) Africa\/Dakar",
            "Africa\/Conakry": "(UTC+00:00) Africa\/Conakry",
            "Africa\/Banjul": "(UTC+00:00) Africa\/Banjul",
            "Africa\/Bissau": "(UTC+00:00) Africa\/Bissau",
            "Atlantic\/Azores": "(UTC+00:00) Atlantic\/Azores",
            "Africa\/Bamako": "(UTC+00:00) Africa\/Bamako",
            "Africa\/Accra": "(UTC+00:00) Africa\/Accra",
            "Atlantic\/St_Helena": "(UTC+00:00) Atlantic\/St_Helena",
            "Atlantic\/Reykjavik": "(UTC+00:00) Atlantic\/Reykjavik",
            "America\/Scoresbysund": "(UTC+00:00) America\/Scoresbysund",
            "Africa\/Abidjan": "(UTC+00:00) Africa\/Abidjan",
            "Africa\/Nouakchott": "(UTC+00:00) Africa\/Nouakchott",
            "Africa\/Monrovia": "(UTC+00:00) Africa\/Monrovia",
            "Africa\/Sao_Tome": "(UTC+00:00) Africa\/Sao_Tome",
            "America\/Danmarkshavn": "(UTC+00:00) America\/Danmarkshavn",
            "Africa\/Ouagadougou": "(UTC+00:00) Africa\/Ouagadougou",
            "Europe\/London": "(UTC+01:00) Europe\/London",
            "Europe\/Lisbon": "(UTC+01:00) Europe\/Lisbon",
            "Europe\/Jersey": "(UTC+01:00) Europe\/Jersey",
            "Europe\/Isle_of_Man": "(UTC+01:00) Europe\/Isle_of_Man",
            "Europe\/Guernsey": "(UTC+01:00) Europe\/Guernsey",
            "Europe\/Dublin": "(UTC+01:00) Europe\/Dublin",
            "Africa\/Porto-Novo": "(UTC+01:00) Africa\/Porto-Novo",
            "Africa\/Bangui": "(UTC+01:00) Africa\/Bangui",
            "Africa\/Niamey": "(UTC+01:00) Africa\/Niamey",
            "Africa\/Brazzaville": "(UTC+01:00) Africa\/Brazzaville",
            "Africa\/Ndjamena": "(UTC+01:00) Africa\/Ndjamena",
            "Africa\/Luanda": "(UTC+01:00) Africa\/Luanda",
            "Africa\/Kinshasa": "(UTC+01:00) Africa\/Kinshasa",
            "Africa\/Tunis": "(UTC+01:00) Africa\/Tunis",
            "Atlantic\/Faroe": "(UTC+01:00) Atlantic\/Faroe",
            "Africa\/Lagos": "(UTC+01:00) Africa\/Lagos",
            "Africa\/Douala": "(UTC+01:00) Africa\/Douala",
            "Atlantic\/Madeira": "(UTC+01:00) Atlantic\/Madeira",
            "Africa\/Algiers": "(UTC+01:00) Africa\/Algiers",
            "Africa\/Libreville": "(UTC+01:00) Africa\/Libreville",
            "Africa\/Malabo": "(UTC+01:00) Africa\/Malabo",
            "Atlantic\/Canary": "(UTC+01:00) Atlantic\/Canary",
            "Europe\/Kaliningrad": "(UTC+02:00) Europe\/Kaliningrad",
            "Europe\/Andorra": "(UTC+02:00) Europe\/Andorra",
            "Europe\/Ljubljana": "(UTC+02:00) Europe\/Ljubljana",
            "Europe\/Madrid": "(UTC+02:00) Europe\/Madrid",
            "Europe\/Malta": "(UTC+02:00) Europe\/Malta",
            "Europe\/Monaco": "(UTC+02:00) Europe\/Monaco",
            "Europe\/Oslo": "(UTC+02:00) Europe\/Oslo",
            "Europe\/Paris": "(UTC+02:00) Europe\/Paris",
            "Europe\/Luxembourg": "(UTC+02:00) Europe\/Luxembourg",
            "Europe\/Gibraltar": "(UTC+02:00) Europe\/Gibraltar",
            "Europe\/Amsterdam": "(UTC+02:00) Europe\/Amsterdam",
            "Europe\/Copenhagen": "(UTC+02:00) Europe\/Copenhagen",
            "Europe\/Busingen": "(UTC+02:00) Europe\/Busingen",
            "Africa\/Windhoek": "(UTC+02:00) Africa\/Windhoek",
            "Africa\/Tripoli": "(UTC+02:00) Africa\/Tripoli",
            "Europe\/Budapest": "(UTC+02:00) Europe\/Budapest",
            "Europe\/Brussels": "(UTC+02:00) Europe\/Brussels",
            "Europe\/Prague": "(UTC+02:00) Europe\/Prague",
            "Europe\/Bratislava": "(UTC+02:00) Europe\/Bratislava",
            "Europe\/Berlin": "(UTC+02:00) Europe\/Berlin",
            "Europe\/Belgrade": "(UTC+02:00) Europe\/Belgrade",
            "Europe\/Podgorica": "(UTC+02:00) Europe\/Podgorica",
            "Europe\/San_Marino": "(UTC+02:00) Europe\/San_Marino",
            "Europe\/Zagreb": "(UTC+02:00) Europe\/Zagreb",
            "Africa\/Maseru": "(UTC+02:00) Africa\/Maseru",
            "Africa\/Blantyre": "(UTC+02:00) Africa\/Blantyre",
            "Antarctica\/Troll": "(UTC+02:00) Antarctica\/Troll",
            "Africa\/Bujumbura": "(UTC+02:00) Africa\/Bujumbura",
            "Europe\/Rome": "(UTC+02:00) Europe\/Rome",
            "Europe\/Warsaw": "(UTC+02:00) Europe\/Warsaw",
            "Africa\/Cairo": "(UTC+02:00) Africa\/Cairo",
            "Africa\/Ceuta": "(UTC+02:00) Africa\/Ceuta",
            "Europe\/Vienna": "(UTC+02:00) Europe\/Vienna",
            "Europe\/Vatican": "(UTC+02:00) Europe\/Vatican",
            "Africa\/Mbabane": "(UTC+02:00) Africa\/Mbabane",
            "Europe\/Vaduz": "(UTC+02:00) Europe\/Vaduz",
            "Africa\/Maputo": "(UTC+02:00) Africa\/Maputo",
            "Europe\/Tirane": "(UTC+02:00) Europe\/Tirane",
            "Africa\/Gaborone": "(UTC+02:00) Africa\/Gaborone",
            "Europe\/Stockholm": "(UTC+02:00) Europe\/Stockholm",
            "Africa\/Harare": "(UTC+02:00) Africa\/Harare",
            "Africa\/Johannesburg": "(UTC+02:00) Africa\/Johannesburg",
            "Africa\/Khartoum": "(UTC+02:00) Africa\/Khartoum",
            "Europe\/Skopje": "(UTC+02:00) Europe\/Skopje",
            "Africa\/Kigali": "(UTC+02:00) Africa\/Kigali",
            "Africa\/Lusaka": "(UTC+02:00) Africa\/Lusaka",
            "Europe\/Sarajevo": "(UTC+02:00) Europe\/Sarajevo",
            "Africa\/Lubumbashi": "(UTC+02:00) Africa\/Lubumbashi",
            "Europe\/Zurich": "(UTC+02:00) Europe\/Zurich",
            "Indian\/Mayotte": "(UTC+03:00) Indian\/Mayotte",
            "Europe\/Athens": "(UTC+03:00) Europe\/Athens",
            "Europe\/Riga": "(UTC+03:00) Europe\/Riga",
            "Europe\/Bucharest": "(UTC+03:00) Europe\/Bucharest",
            "Europe\/Uzhgorod": "(UTC+03:00) Europe\/Uzhgorod",
            "Europe\/Simferopol": "(UTC+03:00) Europe\/Simferopol",
            "Europe\/Moscow": "(UTC+03:00) Europe\/Moscow",
            "Europe\/Minsk": "(UTC+03:00) Europe\/Minsk",
            "Europe\/Mariehamn": "(UTC+03:00) Europe\/Mariehamn",
            "Europe\/Sofia": "(UTC+03:00) Europe\/Sofia",
            "Europe\/Tallinn": "(UTC+03:00) Europe\/Tallinn",
            "Europe\/Kirov": "(UTC+03:00) Europe\/Kirov",
            "Indian\/Comoro": "(UTC+03:00) Indian\/Comoro",
            "Europe\/Kiev": "(UTC+03:00) Europe\/Kiev",
            "Europe\/Istanbul": "(UTC+03:00) Europe\/Istanbul",
            "Europe\/Vilnius": "(UTC+03:00) Europe\/Vilnius",
            "Europe\/Helsinki": "(UTC+03:00) Europe\/Helsinki",
            "Europe\/Zaporozhye": "(UTC+03:00) Europe\/Zaporozhye",
            "Europe\/Chisinau": "(UTC+03:00) Europe\/Chisinau",
            "Indian\/Antananarivo": "(UTC+03:00) Indian\/Antananarivo",
            "Asia\/Amman": "(UTC+03:00) Asia\/Amman",
            "Asia\/Aden": "(UTC+03:00) Asia\/Aden",
            "Africa\/Mogadishu": "(UTC+03:00) Africa\/Mogadishu",
            "Asia\/Kuwait": "(UTC+03:00) Asia\/Kuwait",
            "Asia\/Nicosia": "(UTC+03:00) Asia\/Nicosia",
            "Asia\/Baghdad": "(UTC+03:00) Asia\/Baghdad",
            "Antarctica\/Syowa": "(UTC+03:00) Antarctica\/Syowa",
            "Asia\/Jerusalem": "(UTC+03:00) Asia\/Jerusalem",
            "Asia\/Bahrain": "(UTC+03:00) Asia\/Bahrain",
            "Asia\/Gaza": "(UTC+03:00) Asia\/Gaza",
            "Asia\/Qatar": "(UTC+03:00) Asia\/Qatar",
            "Asia\/Famagusta": "(UTC+03:00) Asia\/Famagusta",
            "Asia\/Riyadh": "(UTC+03:00) Asia\/Riyadh",
            "Africa\/Nairobi": "(UTC+03:00) Africa\/Nairobi",
            "Asia\/Hebron": "(UTC+03:00) Asia\/Hebron",
            "Africa\/Kampala": "(UTC+03:00) Africa\/Kampala",
            "Asia\/Damascus": "(UTC+03:00) Asia\/Damascus",
            "Asia\/Beirut": "(UTC+03:00) Asia\/Beirut",
            "Africa\/Dar_es_Salaam": "(UTC+03:00) Africa\/Dar_es_Salaam",
            "Africa\/Djibouti": "(UTC+03:00) Africa\/Djibouti",
            "Africa\/Asmara": "(UTC+03:00) Africa\/Asmara",
            "Africa\/Addis_Ababa": "(UTC+03:00) Africa\/Addis_Ababa",
            "Africa\/Juba": "(UTC+03:00) Africa\/Juba",
            "Indian\/Mauritius": "(UTC+04:00) Indian\/Mauritius",
            "Asia\/Tbilisi": "(UTC+04:00) Asia\/Tbilisi",
            "Europe\/Saratov": "(UTC+04:00) Europe\/Saratov",
            "Asia\/Dubai": "(UTC+04:00) Asia\/Dubai",
            "Europe\/Astrakhan": "(UTC+04:00) Europe\/Astrakhan",
            "Indian\/Mahe": "(UTC+04:00) Indian\/Mahe",
            "Europe\/Ulyanovsk": "(UTC+04:00) Europe\/Ulyanovsk",
            "Asia\/Baku": "(UTC+04:00) Asia\/Baku",
            "Indian\/Reunion": "(UTC+04:00) Indian\/Reunion",
            "Europe\/Samara": "(UTC+04:00) Europe\/Samara",
            "Asia\/Muscat": "(UTC+04:00) Asia\/Muscat",
            "Asia\/Yerevan": "(UTC+04:00) Asia\/Yerevan",
            "Europe\/Volgograd": "(UTC+04:00) Europe\/Volgograd",
            "Asia\/Kabul": "(UTC+04:30) Asia\/Kabul",
            "Asia\/Tehran": "(UTC+04:30) Asia\/Tehran",
            "Asia\/Aqtobe": "(UTC+05:00) Asia\/Aqtobe",
            "Asia\/Aqtau": "(UTC+05:00) Asia\/Aqtau",
            "Asia\/Karachi": "(UTC+05:00) Asia\/Karachi",
            "Antarctica\/Mawson": "(UTC+05:00) Antarctica\/Mawson",
            "Asia\/Oral": "(UTC+05:00) Asia\/Oral",
            "Asia\/Tashkent": "(UTC+05:00) Asia\/Tashkent",
            "Indian\/Kerguelen": "(UTC+05:00) Indian\/Kerguelen",
            "Indian\/Maldives": "(UTC+05:00) Indian\/Maldives",
            "Asia\/Atyrau": "(UTC+05:00) Asia\/Atyrau",
            "Asia\/Qyzylorda": "(UTC+05:00) Asia\/Qyzylorda",
            "Asia\/Dushanbe": "(UTC+05:00) Asia\/Dushanbe",
            "Asia\/Samarkand": "(UTC+05:00) Asia\/Samarkand",
            "Asia\/Yekaterinburg": "(UTC+05:00) Asia\/Yekaterinburg",
            "Asia\/Ashgabat": "(UTC+05:00) Asia\/Ashgabat",
            "Asia\/Colombo": "(UTC+05:30) Asia\/Colombo",
            "Asia\/Kolkata": "(UTC+05:30) Asia\/Kolkata",
            "Asia\/Kathmandu": "(UTC+05:45) Asia\/Kathmandu",
            "Asia\/Dhaka": "(UTC+06:00) Asia\/Dhaka",
            "Asia\/Bishkek": "(UTC+06:00) Asia\/Bishkek",
            "Asia\/Thimphu": "(UTC+06:00) Asia\/Thimphu",
            "Asia\/Omsk": "(UTC+06:00) Asia\/Omsk",
            "Antarctica\/Vostok": "(UTC+06:00) Antarctica\/Vostok",
            "Indian\/Chagos": "(UTC+06:00) Indian\/Chagos",
            "Asia\/Urumqi": "(UTC+06:00) Asia\/Urumqi",
            "Asia\/Almaty": "(UTC+06:00) Asia\/Almaty",
            "Asia\/Qostanay": "(UTC+06:00) Asia\/Qostanay",
            "Indian\/Cocos": "(UTC+06:30) Indian\/Cocos",
            "Asia\/Yangon": "(UTC+06:30) Asia\/Yangon",
            "Antarctica\/Davis": "(UTC+07:00) Antarctica\/Davis",
            "Asia\/Tomsk": "(UTC+07:00) Asia\/Tomsk",
            "Asia\/Vientiane": "(UTC+07:00) Asia\/Vientiane",
            "Asia\/Barnaul": "(UTC+07:00) Asia\/Barnaul",
            "Asia\/Krasnoyarsk": "(UTC+07:00) Asia\/Krasnoyarsk",
            "Asia\/Pontianak": "(UTC+07:00) Asia\/Pontianak",
            "Asia\/Ho_Chi_Minh": "(UTC+07:00) Asia\/Ho_Chi_Minh",
            "Asia\/Hovd": "(UTC+07:00) Asia\/Hovd",
            "Asia\/Phnom_Penh": "(UTC+07:00) Asia\/Phnom_Penh",
            "Asia\/Jakarta": "(UTC+07:00) Asia\/Jakarta",
            "Indian\/Christmas": "(UTC+07:00) Indian\/Christmas",
            "Asia\/Novosibirsk": "(UTC+07:00) Asia\/Novosibirsk",
            "Asia\/Novokuznetsk": "(UTC+07:00) Asia\/Novokuznetsk",
            "Asia\/Bangkok": "(UTC+07:00) Asia\/Bangkok",
            "Antarctica\/Casey": "(UTC+08:00) Antarctica\/Casey",
            "Asia\/Shanghai": "(UTC+08:00) Asia\/Shanghai",
            "Asia\/Brunei": "(UTC+08:00) Asia\/Brunei",
            "Asia\/Kuala_Lumpur": "(UTC+08:00) Asia\/Kuala_Lumpur",
            "Australia\/Perth": "(UTC+08:00) Australia\/Perth",
            "Asia\/Manila": "(UTC+08:00) Asia\/Manila",
            "Asia\/Ulaanbaatar": "(UTC+08:00) Asia\/Ulaanbaatar",
            "Asia\/Macau": "(UTC+08:00) Asia\/Macau",
            "Asia\/Kuching": "(UTC+08:00) Asia\/Kuching",
            "Asia\/Makassar": "(UTC+08:00) Asia\/Makassar",
            "Asia\/Taipei": "(UTC+08:00) Asia\/Taipei",
            "Asia\/Choibalsan": "(UTC+08:00) Asia\/Choibalsan",
            "Asia\/Irkutsk": "(UTC+08:00) Asia\/Irkutsk",
            "Asia\/Hong_Kong": "(UTC+08:00) Asia\/Hong_Kong",
            "Asia\/Singapore": "(UTC+08:00) Asia\/Singapore",
            "Australia\/Eucla": "(UTC+08:45) Australia\/Eucla",
            "Asia\/Chita": "(UTC+09:00) Asia\/Chita",
            "Asia\/Tokyo": "(UTC+09:00) Asia\/Tokyo",
            "Pacific\/Palau": "(UTC+09:00) Pacific\/Palau",
            "Asia\/Khandyga": "(UTC+09:00) Asia\/Khandyga",
            "Asia\/Yakutsk": "(UTC+09:00) Asia\/Yakutsk",
            "Asia\/Seoul": "(UTC+09:00) Asia\/Seoul",
            "Asia\/Dili": "(UTC+09:00) Asia\/Dili",
            "Asia\/Jayapura": "(UTC+09:00) Asia\/Jayapura",
            "Asia\/Pyongyang": "(UTC+09:00) Asia\/Pyongyang",
            "Australia\/Adelaide": "(UTC+09:30) Australia\/Adelaide",
            "Australia\/Darwin": "(UTC+09:30) Australia\/Darwin",
            "Australia\/Broken_Hill": "(UTC+09:30) Australia\/Broken_Hill",
            "Pacific\/Guam": "(UTC+10:00) Pacific\/Guam",
            "Pacific\/Port_Moresby": "(UTC+10:00) Pacific\/Port_Moresby",
            "Antarctica\/DumontDUrville": "(UTC+10:00) Antarctica\/DumontDUrville",
            "Pacific\/Chuuk": "(UTC+10:00) Pacific\/Chuuk",
            "Australia\/Currie": "(UTC+10:00) Australia\/Currie",
            "Pacific\/Saipan": "(UTC+10:00) Pacific\/Saipan",
            "Australia\/Hobart": "(UTC+10:00) Australia\/Hobart",
            "Australia\/Sydney": "(UTC+10:00) Australia\/Sydney",
            "Australia\/Lindeman": "(UTC+10:00) Australia\/Lindeman",
            "Australia\/Melbourne": "(UTC+10:00) Australia\/Melbourne",
            "Asia\/Ust-Nera": "(UTC+10:00) Asia\/Ust-Nera",
            "Asia\/Vladivostok": "(UTC+10:00) Asia\/Vladivostok",
            "Australia\/Brisbane": "(UTC+10:00) Australia\/Brisbane",
            "Australia\/Lord_Howe": "(UTC+10:30) Australia\/Lord_Howe",
            "Pacific\/Pohnpei": "(UTC+11:00) Pacific\/Pohnpei",
            "Asia\/Srednekolymsk": "(UTC+11:00) Asia\/Srednekolymsk",
            "Antarctica\/Macquarie": "(UTC+11:00) Antarctica\/Macquarie",
            "Asia\/Sakhalin": "(UTC+11:00) Asia\/Sakhalin",
            "Pacific\/Efate": "(UTC+11:00) Pacific\/Efate",
            "Pacific\/Bougainville": "(UTC+11:00) Pacific\/Bougainville",
            "Asia\/Magadan": "(UTC+11:00) Asia\/Magadan",
            "Pacific\/Kosrae": "(UTC+11:00) Pacific\/Kosrae",
            "Pacific\/Noumea": "(UTC+11:00) Pacific\/Noumea",
            "Pacific\/Norfolk": "(UTC+11:00) Pacific\/Norfolk",
            "Pacific\/Guadalcanal": "(UTC+11:00) Pacific\/Guadalcanal",
            "Pacific\/Tarawa": "(UTC+12:00) Pacific\/Tarawa",
            "Pacific\/Wake": "(UTC+12:00) Pacific\/Wake",
            "Pacific\/Wallis": "(UTC+12:00) Pacific\/Wallis",
            "Pacific\/Nauru": "(UTC+12:00) Pacific\/Nauru",
            "Pacific\/Majuro": "(UTC+12:00) Pacific\/Majuro",
            "Pacific\/Kwajalein": "(UTC+12:00) Pacific\/Kwajalein",
            "Pacific\/Funafuti": "(UTC+12:00) Pacific\/Funafuti",
            "Pacific\/Fiji": "(UTC+12:00) Pacific\/Fiji",
            "Pacific\/Auckland": "(UTC+12:00) Pacific\/Auckland",
            "Antarctica\/McMurdo": "(UTC+12:00) Antarctica\/McMurdo",
            "Asia\/Anadyr": "(UTC+12:00) Asia\/Anadyr",
            "Asia\/Kamchatka": "(UTC+12:00) Asia\/Kamchatka",
            "Pacific\/Chatham": "(UTC+12:45) Pacific\/Chatham",
            "Pacific\/Fakaofo": "(UTC+13:00) Pacific\/Fakaofo",
            "Pacific\/Enderbury": "(UTC+13:00) Pacific\/Enderbury",
            "Pacific\/Apia": "(UTC+13:00) Pacific\/Apia",
            "Pacific\/Tongatapu": "(UTC+13:00) Pacific\/Tongatapu",
            "Pacific\/Kiritimati": "(UTC+14:00) Pacific\/Kiritimati"
        },
        "timezone": "",
        "post_id": "545",
        "ckot_url": "http:\/\/citybook.meetclic.com\/index.php\/listing-checkout\/",
        "location_type": "administrative_area_level_1",
        "address_format": ["formatted_address"],
        "country_restrictions": "",
        "place_lng": "",
        "disable_bubble": "no",
        "lb_approved": "Approved",
        "lb_24h": "1",
        "td_color": "#4DB7FE",
        "lb_delay": "3000",
        "md_limit": "3",
        "md_limit_msg": "Max upload files is 3",
        "md_limit_size": "2",
        "md_limit_size_msg": "Max upload file size is 2 MB",
        "search": "Search...",
        "gcaptcha": "",
        "gcaptcha_key": "",
        "location_show_state": "",
        "payment": [],
        "weather_strings": {
            "days": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "min": "Min",
            "max": "Max",
            "direction": ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"]
        },
        "i18n": {
            "share_on": "Share this on {SOCIAL}",
            "del-listing": "Are you sure want to delete <?php  echo "{{listing_title}}" ?>listing and its data?\nThe listing is permanently deleted.",
            "cancel-booking": "Are you sure want to cancel <?php  echo "{{booking_title}}" ?> booking?",
            "approve-booking": "Are you sure want to approve <?php  echo "{{booking_title}}" ?> booking?",
            "del-booking": "Are you sure want to delete <?php  echo "{{booking_title}} " ?>booking and its data?\nThe booking is permanently deleted.",
            "del-message": "Are you sure want to cancel <?php  echo "{{message_title}}" ?> message?",
            "cancel-package": "Are you sure want to cancel this subscription?",
            "chats_h3": "Inbox",
            "chat_fr_owner": "Chat With Owner",
            "chat_fr_login": "Login to chat",
            "chat_fr_cwith": "You is chatting with  ",
            "chat_fr_conver": "Conversation list",
            "change_pas_h3": " Change Password",
            "change_pas_lb_CP": "Current Password",
            "change_pas_lb_NP": "New Password",
            "change_pas_lb_CNP": "Confirm New Password",
            "inner_chat_op_W": "Week",
            "inner_chat_op_M": "Month",
            "inner_chat_op_Y": "Year",
            "inner_listing_li_E": "Edit ",
            "inner_listing_li_D": "Delete ",
            "author_review_h3": "Reviews for your listings",
            "likebtn": "Like Button",
            "welcome": "Welcome",
            "listings": "Listings",
            "bookings": "Bookings",
            "reviews": "Reviews",
            "log_out": "Log Out ",
            "add_hour": "Add Hour",
            "timezone": "Timezone",
            "book_dates": "Dates",
            "book_services": "Extra Services",
            "book_ad": "ADULTS",
            "book_chi": "CHILDREN",
            "book_avr": "Available Rooms",
            "book_ts": "Total Cost",
            "book_chev": "Check availability",
            "book_bn": "Book Now",
            "checkout_can": "Cancel",
            "checkout_app": "Apply",
            "roomsl_avai": "Available:",
            "roomsl_maxg": "Max Guests: ",
            "roomsl_quan": "Quantity",
            "btn_save": "Save Change",
            "btn_save_c": "Save Changes",
            "btn_close": "Close me",
            "btn_send": "Send",
            "btn_add_F": "Add Fact +",
            "fact_title": "Fact Title",
            "fact_number": "Fact Number",
            "fact_icon": "Fact Icon",
            "location_country": "Country",
            "location_state": "State",
            "location_city": "City",
            "faq_title": "Question",
            "faq_content": "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "btn_add_Faq": "Add FAQ",
            "btn_add_S": "Add Social +",
            "btn_add_R": "Add Room +",
            "image_upload": " Click here to upload",
            "th_mount": "Amount",
            "th_method": "Method",
            "th_to": "To",
            "th_date": "Date Submitted",
            "th_status": "Status",
            "calendar_dis_number": "Select the number of months displayed.",
            "calendar_number_one": "One Months",
            "calendar_number_two": "Two Months",
            "calendar_number_three": "Three Months",
            "calendar_number_four": "Four Months",
            "calendar_number_five": "Five Months",
            "calendar_number_six": "Six Months",
            "calendar_number_seven": "Seven Months",
            "coupon_code": "Coupon code",
            "coupon_discount": "Discount type",
            "coupon_percentage": "Percentage discount",
            "coupon_fix_cart": "Fixed cart discount",
            "coupon_desc": "Description",
            "coupon_show": "Display content in widget banner?",
            "coupon_amount": "Discount amount",
            "coupon_qtt": "Coupon quantity",
            "coupon_expiry": "Coupon expiry date",
            "coupon_format": "Format:YY-mm-dd HH:ii:ss",
            "bt_coupon": "Add Coupon",
            "bt_services": "Add Service",
            "services_name": "Service Name",
            "services_desc": "Description",
            "services_price": "Service Price",
            "bt_member": "Add Member",
            "member_name": "Name: ",
            "member_job": "Job or Position: ",
            "member_desc": "Description",
            "member_img": "Image",
            "memeber_social": "Socials",
            "days": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            "months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            "earnings_title": "Your Earnings",
            "th_date_": "Date",
            "th_total_": "Total",
            "th_fee_": "Author Fee",
            "th_earning_": "Earning",
            "th_order_": "Order",
            "go_back": "Go back",
            "no_earning": "You have no earning.",
            "cancel": "Cancel",
            "submit": "Submit",
            "ltype_title": "Listing type",
            "ltype_desc": "Listing type description",
            "wkh_enter": "Enter Hours",
            "wkh_open": "Open all day",
            "wkh_close": "Close all day",
            "calen_lock": "Lock this month",
            "calen_unlock": "Unlock this month",
            "smwdtitle": "Submit a withdrawal request",
            "wdfunds": "Withdraw funds",
            "goearnings": "View Earnings",
            "chat_type_msg": "Type Message",
            "save": "Save",
            "cal_event_start": "Event start time: ",
            "cal_event_end": "Event end date: ",
            "cal_opts": "Options",
            "wth_payments": "PayPal \/ Stripe Email",
            "wth_amount": "Amount ",
            "wth_plh_email": "email@gmail.com",
            "wth_acount_balance": "Account Balance",
            "wth_will_process": "Your request will be processed on ",
            "wth_no_request": "You have no withdrawal request",
            "bt_slots": "Add Time Slot",
            "slot_time": "Time",
            "slot_guests": "Guests",
            "slot_available": "Available slots",
            "nights": "Nights",
            "raselect_placeholder": "Select",
            "raselect_nooptions": "No options",
            "slots_add": "Add Slot",
            "slots_guests": "Max Guests",
            "slots_start": "Start time",
            "slots_end": "End time",
            "slots_price": "Price",
            "cal_bulkedit": "Bulk Edit",
            "save_bulkedit": "Save",
            "cancel_bulkedit": "Cancel",
            "adults": "Adults",
            "children": "Children",
            "AM": "AM",
            "PM": "PM"
        },
        "distance_df": "5",
        "curr_user": {
            "id": 0,
            "display_name": "",
            "avatar": "",
            "can_upload": false,
            "role": false,
            "is_author": false
        },
        "free_map": "",
        "currency": {
            "currency": "USD",
            "symbol": "$",
            "rate": "1",
            "sb_pos": "left",
            "decimal": "2",
            "ths_sep": ",",
            "dec_sep": "."
        },
        "base_currency": {
            "currency": "USD",
            "symbol": "$",
            "rate": "1",
            "sb_pos": "left",
            "decimal": "2",
            "ths_sep": ",",
            "dec_sep": "."
        },
        "wpml": null
    };
    /* ]]> */
</script>
<script type="text/javascript">
    (function (domain, translations) {
        var localeData = translations.locale_data[domain] || translations.locale_data.messages;
        localeData[""].domain = domain;
        wp.i18n.setLocaleData(localeData, domain);
    })("citybook-add-ons", {"locale_data": {"messages": {"": {}}}});
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/citybook-add-ons.min.js"></script>
<div class="datedropper  primary picker-fxs picker-lg" id="datedropper-0">
    <div class="picker">
        <ul class="pick pick-m" data-k="m">
            <li value="1" class="pick-bfr">Jan</li>
            <li value="2" class="pick-bfr">Feb</li>
            <li value="3" class="pick-bfr">Mar</li>
            <li value="4" class="pick-sl">Apr</li>
            <li value="5" class="pick-afr">May</li>
            <li value="6" class="pick-afr">June</li>
            <li value="7" class="pick-afr">July</li>
            <li value="8" class="pick-afr">Aug</li>
            <li value="9" class="pick-afr">Sept</li>
            <li value="10" class="pick-afr">Oct</li>
            <li value="11" class="pick-afr">Nov</li>
            <li value="12" class="pick-afr">Dec</li>
            <div class="pick-arw pick-arw-s1 pick-arw-l"><i class="pick-i-l"></i></div>
            <div class="pick-arw pick-arw-s1 pick-arw-r"><i class="pick-i-r"></i></div>
        </ul>
        <div class="pick-lg">
            <ul class="pick-lg-h">
                <li>S</li>
                <li>M</li>
                <li>T</li>
                <li>W</li>
                <li>T</li>
                <li>F</li>
                <li>S</li>
            </ul>
            <ul class="pick-lg-b">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <ul class="pick pick-d" data-k="d">
            <li value="1" class="pick-bfr">1<span></span></li>
            <li value="2" class="pick-bfr">2<span></span></li>
            <li value="3" class="pick-bfr">3<span></span></li>
            <li value="4" class="pick-bfr">4<span></span></li>
            <li value="5" class="pick-bfr">5<span></span></li>
            <li value="6" class="pick-bfr">6<span></span></li>
            <li value="7" class="pick-bfr">7<span></span></li>
            <li value="8" class="pick-bfr">8<span></span></li>
            <li value="9" class="pick-bfr">9<span></span></li>
            <li value="10" class="pick-bfr">10<span></span></li>
            <li value="11" class="pick-bfr">11<span></span></li>
            <li value="12" class="pick-bfr">12<span></span></li>
            <li value="13" class="pick-bfr">13<span></span></li>
            <li value="14" class="pick-bfr">14<span></span></li>
            <li value="15" class="pick-bfr">15<span></span></li>
            <li value="16" class="pick-bfr">16<span></span></li>
            <li value="17" class="pick-bfr">17<span></span></li>
            <li value="18" class="pick-bfr">18<span></span></li>
            <li value="19" class="pick-bfr">19<span></span></li>
            <li value="20" class="pick-bfr">20<span></span></li>
            <li value="21" class="pick-bfr">21<span></span></li>
            <li value="22" class="pick-bfr">22<span></span></li>
            <li value="23" class="pick-bfr">23<span></span></li>
            <li value="24" class="pick-bfr">24<span></span></li>
            <li value="25" class="pick-sl">25<span></span></li>
            <li value="26" class="pick-afr">26<span></span></li>
            <li value="27" class="pick-afr">27<span></span></li>
            <li value="28" class="pick-afr">28<span></span></li>
            <li value="29" class="pick-afr">29<span></span></li>
            <li value="30" class="pick-afr">30<span></span></li>
            <li value="31" class="pick-afr">31<span></span></li>
            <div class="pick-arw pick-arw-s1 pick-arw-l"><i class="pick-i-l"></i></div>
            <div class="pick-arw pick-arw-s1 pick-arw-r"><i class="pick-i-r"></i></div>
        </ul>
        <ul class="pick pick-y" data-k="y">
            <li value="2016" class="pick-bfr">2016</li>
            <li value="2017" class="pick-bfr">2017</li>
            <li value="2018" class="pick-bfr">2018</li>
            <li value="2019" class="pick-bfr">2019</li>
            <li value="2020" class="pick-sl">2020</li>
            <li value="2021" class="pick-afr">2021</li>
            <li value="2022" class="pick-afr">2022</li>
            <li value="2023" class="pick-afr">2023</li>
            <li value="2024" class="pick-afr">2024</li>
            <li value="2025" class="pick-afr">2025</li>
            <li value="2026" class="pick-afr">2026</li>
            <li value="2027" class="pick-afr">2027</li>
            <li value="2028" class="pick-afr">2028</li>
            <li value="2029" class="pick-afr">2029</li>
            <li value="2030" class="pick-afr">2030</li>
            <li value="2031" class="pick-afr">2031</li>
            <li value="2032" class="pick-afr">2032</li>
            <li value="2033" class="pick-afr">2033</li>
            <li value="2034" class="pick-afr">2034</li>
            <li value="2035" class="pick-afr">2035</li>
            <li value="2036" class="pick-afr">2036</li>
            <li value="2037" class="pick-afr">2037</li>
            <li value="2038" class="pick-afr">2038</li>
            <li value="2039" class="pick-afr">2039</li>
            <li value="2040" class="pick-afr">2040</li>
            <li value="2041" class="pick-afr">2041</li>
            <li value="2042" class="pick-afr">2042</li>
            <li value="2043" class="pick-afr">2043</li>
            <li value="2044" class="pick-afr">2044</li>
            <li value="2045" class="pick-afr">2045</li>
            <li value="2046" class="pick-afr">2046</li>
            <li value="2047" class="pick-afr">2047</li>
            <li value="2048" class="pick-afr">2048</li>
            <li value="2049" class="pick-afr">2049</li>
            <li value="2050" class="pick-afr">2050</li>
            <div class="pick-arw pick-arw-s1 pick-arw-l"><i class="pick-i-l"></i></div>
            <div class="pick-arw pick-arw-s1 pick-arw-r"><i class="pick-i-r"></i></div>
            <div class="pick-arw pick-arw-s2 pick-arw-l"><i class="pick-i-l"></i></div>
            <div class="pick-arw pick-arw-s2 pick-arw-r"><i class="pick-i-r"></i></div>
        </ul>
        <ul class="pick pick-l" data-k="l">
            <li value="21" class="pick-bfr">Tiếng việt</li>
            <li value="0" class="pick-sl">English</li>
            <li value="1" class="pick-afr">Georgian</li>
            <li value="2" class="pick-afr">Italiano</li>
            <li value="3" class="pick-afr">Français</li>
            <li value="4" class="pick-afr">中文</li>
            <li value="5" class="pick-afr">العَرَبِيَّة</li>
            <li value="6" class="pick-afr">فارسی</li>
            <li value="7" class="pick-afr">Hungarian</li>
            <li value="8" class="pick-afr">Ελληνικά</li>
            <li value="9" class="pick-afr">Español</li>
            <li value="10" class="pick-afr">Dansk</li>
            <li value="11" class="pick-afr">Deutsch</li>
            <li value="12" class="pick-afr">Nederlands</li>
            <li value="13" class="pick-afr">język polski</li>
            <li value="14" class="pick-afr">Português</li>
            <li value="15" class="pick-afr">Slovenščina</li>
            <li value="16" class="pick-afr">українська мова</li>
            <li value="17" class="pick-afr">русский язык</li>
            <li value="18" class="pick-afr">Türkçe</li>
            <li value="19" class="pick-afr">조선말</li>
            <li value="20" class="pick-afr">suomen kieli</li>
            <div class="pick-arw pick-arw-s1 pick-arw-l"><i class="pick-i-l"></i></div>
            <div class="pick-arw pick-arw-s1 pick-arw-r"><i class="pick-i-r"></i></div>
        </ul>
        <div class="pick-btns">
            <div class="pick-submit"></div>
            <div class="pick-btn pick-btn-sz"></div>
        </div>
    </div>
</div>
<div class="td-wrap td-n2" id="td-clock-0">
    <div class="td-overlay"></div>
    <div class="td-clock td-init">
        <div class="td-deg td-n">
            <div class="td-select">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px"
                     y="0px" viewBox="0 0 100 35.4" enable-background="new 0 0 100 35.4" xml:space="preserve"
                     style="stroke:#4DB7FE"><g>
                        <path fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                              stroke-miterlimit="10" d="M98.1,33C85.4,21.5,68.5,14.5,50,14.5S14.6,21.5,1.9,33"></path>
                        <line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                              stroke-miterlimit="10" x1="1.9" y1="33" x2="1.9" y2="28.6"></line>
                        <line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                              stroke-miterlimit="10" x1="1.9" y1="33" x2="6.3" y2="33"></line>
                        <line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                              stroke-miterlimit="10" x1="98.1" y1="33" x2="93.7" y2="33"></line>
                        <line fill="none" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"
                              stroke-miterlimit="10" x1="98.1" y1="33" x2="98.1" y2="28.6"></line>
                    </g></svg>
            </div>
        </div>
        <div class="td-medirian"><span class="td-icon-am td-n">AM</span><span class="td-icon-pm td-n">PM</span></div>
        <div class="td-lancette">
            <div style="transform: rotate(336deg);"></div>
            <div></div>
        </div>
        <div class="td-time"><span class="on" data-id="16">16</span>:<span data-id="55">55</span></div>
    </div>
</div>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/react.min.js?ver=16.9.0"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/dist/vendor/react-dom.min.js?ver=16.9.0"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/react-router-dom.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/redux.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/react-redux.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/redux-thunk.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/qs.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/axios.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/Sortable.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/react-sortable.min.js"></script>
<script type="text/javascript">
    (function (domain, translations) {
        var localeData = translations.locale_data[domain] || translations.locale_data.messages;
        localeData[""].domain = domain;
        wp.i18n.setLocaleData(localeData, domain);
    })("citybook-add-ons", {"locale_data": {"messages": {"": {}}}});
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/citybook-react-app.min.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/citybook-chat-app.min.js"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var wpcf7 = {
        "apiSettings": {
            "root": "http:\/\/citybook.meetclic.com\/index.php\/wp-json\/contact-form-7\/v1",
            "namespace": "contact-form-7\/v1"
        }, "cached": "1"
    };
    /* ]]> */
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.1.7"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var wc_add_to_cart_params = {
        "ajax_url": "\/wp-admin\/admin-ajax.php",
        "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
        "i18n_view_cart": "View cart",
        "cart_url": "http:\/\/citybook.meetclic.com",
        "is_cart": "",
        "cart_redirect_after_add": "no"
    };
    /* ]]> */
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min.js?ver=4.0.1"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var woocommerce_params = {"ajax_url": "\/wp-admin\/admin-ajax.php", "wc_ajax_url": "\/?wc-ajax=%%endpoint%%"};
    /* ]]> */
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=4.0.1"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    var wc_cart_fragments_params = {
        "ajax_url": "\/wp-admin\/admin-ajax.php",
        "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
        "cart_hash_key": "wc_cart_hash_391acb7c8e5b40a808c5fb3204e39147",
        "fragment_name": "wc_fragments_391acb7c8e5b40a808c5fb3204e39147",
        "request_timeout": "5000"
    };
    /* ]]> */
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=4.0.1"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/jquery.easing.min.js?ver=1.4.0"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/jquery.appear.js?ver=0.3.6"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/jquery.countTo.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/navigation.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/rangeslider.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/slick.min.js?ver=1.9.0"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/lightgallery.min.js?ver=1.2.13"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/themes/citybook/assets/js/scripts.js"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/draggable.min.js?ver=1.11.4"></script>
<script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/backbone.min.js?ver=1.4.0"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.marionette.min.js?ver=2.4.5"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/lib/backbone/backbone.radio.min.js?ver=1.0.4"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/js/common-modules.min.js?ver=2.9.8"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-includes/js/jquery/ui/position.min.js?ver=1.11.4"></script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/lib/dialog/dialog.min.js?ver=4.7.6"></script>
<script type="text/javascript">
    var elementorCommonConfig = {
        "version": "2.9.8",
        "isRTL": false,
        "isDebug": false,
        "activeModules": ["ajax", "finder", "connect"],
        "urls": {"assets": "http:\/\/citybook.meetclic.com\/wp-content\/plugins\/elementor\/assets\/"},
        "ajax": {"url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin-ajax.php", "nonce": "dd538f9f26"},
        "finder": {
            "data": {
                "edit": {"title": "Edit", "dynamic": true, "name": "edit"},
                "general": {
                    "title": "General",
                    "dynamic": false,
                    "items": {
                        "saved-templates": {
                            "title": "Saved Templates",
                            "icon": "library-save",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?post_type=elementor_library&tabs_group=library",
                            "keywords": ["template", "section", "page", "library"]
                        },
                        "system-info": {
                            "title": "System Info",
                            "icon": "info-circle-o",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-system-info",
                            "keywords": ["system", "info", "environment", "elementor"]
                        },
                        "role-manager": {
                            "title": "Role Manager",
                            "icon": "person",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-role-manager",
                            "keywords": ["role", "manager", "user", "elementor"]
                        },
                        "knowledge-base": {
                            "title": "Knowledge Base",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=go_knowledge_base_site",
                            "keywords": ["help", "knowledge", "docs", "elementor"]
                        }
                    },
                    "name": "general"
                },
                "create": {
                    "title": "Create",
                    "dynamic": false,
                    "items": {
                        "post": {
                            "title": "Add New Entrada",
                            "icon": "plus-circle-o",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=post&_wpnonce=5e3f73c2cb",
                            "keywords": ["post", "page", "template", "new", "create"]
                        },
                        "page": {
                            "title": "Add New P\u00e1gina",
                            "icon": "plus-circle-o",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?action=elementor_new_post&post_type=page&_wpnonce=5e3f73c2cb",
                            "keywords": ["post", "page", "template", "new", "create"]
                        },
                        "elementor_library": {
                            "title": "Add New Template",
                            "icon": "plus-circle-o",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/edit.php?post_type=elementor_library#add_new",
                            "keywords": ["post", "page", "template", "new", "create"]
                        }
                    },
                    "name": "create"
                },
                "site": {
                    "title": "Site", "dynamic": false, "items": {
                        "homepage": {
                            "title": "Homepage",
                            "url": "http:\/\/citybook.meetclic.com",
                            "icon": "home-heart",
                            "keywords": ["home", "page"]
                        },
                        "wordpress-dashboard": {
                            "title": "Dashboard",
                            "icon": "dashboard",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/",
                            "keywords": ["dashboard", "wordpress"]
                        },
                        "wordpress-menus": {
                            "title": "Menus",
                            "icon": "wordpress",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/nav-menus.php",
                            "keywords": ["menu", "wordpress"]
                        },
                        "wordpress-themes": {
                            "title": "Themes",
                            "icon": "wordpress",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/themes.php",
                            "keywords": ["themes", "wordpress"]
                        },
                        "wordpress-customizer": {
                            "title": "Customizer",
                            "icon": "wordpress",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/customize.php",
                            "keywords": ["customizer", "wordpress"]
                        },
                        "wordpress-plugins": {
                            "title": "Plugins",
                            "icon": "wordpress",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/plugins.php",
                            "keywords": ["plugins", "wordpress"]
                        },
                        "wordpress-users": {
                            "title": "Users",
                            "icon": "wordpress",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/users.php",
                            "keywords": ["users", "profile", "wordpress"]
                        }
                    }, "name": "site"
                },
                "settings": {
                    "title": "Settings",
                    "dynamic": false,
                    "items": {
                        "general-settings": {
                            "title": "General Settings",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor",
                            "keywords": ["general", "settings", "elementor"]
                        },
                        "style": {
                            "title": "Style",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor#tab-style",
                            "keywords": ["style", "settings", "elementor"]
                        },
                        "advanced": {
                            "title": "Advanced",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor#tab-advanced",
                            "keywords": ["advanced", "settings", "elementor"]
                        }
                    },
                    "name": "settings"
                },
                "tools": {
                    "title": "Tools",
                    "dynamic": false,
                    "items": {
                        "tools": {
                            "title": "Tools",
                            "icon": "tools",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools",
                            "keywords": ["tools", "regenerate css", "safe mode", "debug bar", "sync library", "elementor"]
                        },
                        "replace-url": {
                            "title": "Replace URL",
                            "icon": "tools",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools#tab-replace_url",
                            "keywords": ["tools", "replace url", "domain", "elementor"]
                        },
                        "version-control": {
                            "title": "Version Control",
                            "icon": "time-line",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools#tab-versions",
                            "keywords": ["tools", "version", "control", "rollback", "beta", "elementor"]
                        },
                        "maintenance-mode": {
                            "title": "Maintenance Mode",
                            "icon": "tools",
                            "url": "http:\/\/citybook.meetclic.com\/wp-admin\/admin.php?page=elementor-tools#tab-maintenance_mode",
                            "keywords": ["tools", "maintenance", "coming soon", "elementor"]
                        }
                    },
                    "name": "tools"
                }
            }, "i18n": {"finder": "Finder"}
        },
        "connect": []
    };
</script>
<script type="text/javascript"
        src="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/js/common.min.js?ver=2.9.8"></script>
<script type="text/javascript" src="http://citybook.meetclic.com/wp-includes/js/wp-embed.min.js?ver=5.4"></script>
<script>
    function lazyListingsChanged() {
        // create new window event for listing change
        var evt = new CustomEvent('listingsChanged', {detail: 'lazy-load'});
        window.dispatchEvent(evt);
    }

    function lazyGalChanged(el) {
        // create new window event for listing change
        var evt = new CustomEvent('galChanged', {detail: el});
        window.dispatchEvent(evt);
    }

    // Set the options to make LazyLoad self-initialize
    window.lazyLoadOptions = {
        elements_selector: ".lazy",
        // ... more custom settings?
        callback_loaded: (el) => {
            // console.log("Loaded", el)

            if (window.listingItemsEle != null) {
                // console.log('has #listing-items');
                if (window.listingItemsEle.contains(el)) {
                    // console.log('el inside #listing-items');
                    lazyListingsChanged()
                }
            }

            lazyGalChanged(el)
        },
        callback_finish: () => {
            // console.log("Finish")
        },
    };
    // Listen to the initialization event and get the instance of LazyLoad
    window.addEventListener('LazyLoad::Initialized', function (event) {
        window.lazyLoadInstance = event.detail.instance;

        window.listingItemsEle = document.getElementById('listing-items')
    }, false);
</script>
<script async="" src="http://citybook.meetclic.com/wp-content/plugins/citybook-add-ons/assets/js/lazyload.js"></script>
<!--[if lte IE 8]>
<script type="text/javascript">
    document.body.className = document.body.className.replace(/(^|\s)(no-)?customize-support(?=\s|$)/, '') + ' no-customize-support';
</script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript">
    (function () {
        var request, b = document.body, c = 'className', cs = 'customize-support',
            rcs = new RegExp('(^|\\s+)(no-)?' + cs + '(\\s+|$)');

        request = true;

        b[c] = b[c].replace(rcs, ' ');
        // The customizer requires postMessage and CORS (if the site is cross domain).
        b[c] += (window.postMessage && request ? ' ' : ' no-') + cs;
    }());
</script>
<!--<![endif]-->


<!-- Page generated by LiteSpeed Cache 2.9.9.2 on 2020-04-25 16:55:34 -->
<div class="pac-container pac-logo" style="display: none;"></div>
</body>
</html>
