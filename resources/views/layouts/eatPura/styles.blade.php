<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$pathTemplate = $resourcePathServer . 'templates/citybook/';
?>
<style id="kirki-inline-styles">
    body {
        font-family: Quicksand;
    }

    .custom-form input::-webkit-input-placeholder, .custom-form textarea::-webkit-input-placeholder {
        font-family: Quicksand;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: Quicksand;
    }

    p {
        font-family: Quicksand;
    }

    .main-register h3 span, .images-collage-title, .footer-menu li a, .error-wrap h2, .cs-countdown-item span {
        font-family: Montserrat;
    }

    blockquote p, .price-num-desc, .testimonilas-text p, .testimonilas-text li a, .footer-widget .about-widget h4, .video-item p {
        font-family: Georgia;
        font-weight: 400;
        font-style: italic;
    }

    /* vietnamese */
    @font-face {
        font-family: 'Quicksand';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url({{asset($pathTemplate.'wp-content/fonts/quicksand/6xK-dSZaM9iE8KbpRA_LJ3z8mH9BOJvgkP8o58m-xDwxUD2GF9Zc.woff')}}) format('woff');
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Quicksand';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url({{asset($pathTemplate.'wp-content/fonts/quicksand/6xK-dSZaM9iE8KbpRA_LJ3z8mH9BOJvgkP8o58i-xDwxUD2GF9Zc.woff')}}) format('woff');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Quicksand';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url({{asset($pathTemplate.'wp-content/fonts/quicksand/6xK-dSZaM9iE8KbpRA_LJ3z8mH9BOJvgkP8o58a-xDwxUD2GFw.woff')}}) format('woff');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* cyrillic-ext */
    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url({{asset($pathTemplate.'wp-content/fonts/montserrat/JTUSjIg1_i6t8kCHKm459WRhzSTh89ZNpQ.woff')}}) format('woff');
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
    }

    /* cyrillic */
    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url({{asset($pathTemplate.'wp-content/fonts/montserrat/JTUSjIg1_i6t8kCHKm459W1hzSTh89ZNpQ.woff')}}) format('woff');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }

    /* vietnamese */
    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url({{asset($pathTemplate.'wp-content/fonts/montserrat/JTUSjIg1_i6t8kCHKm459WZhzSTh89ZNpQ.woff')}}) format('woff');
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url({{asset($pathTemplate.'wp-content/fonts/montserrat/JTUSjIg1_i6t8kCHKm459WdhzSTh89ZNpQ.woff')}}) format('woff');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url({{asset($pathTemplate.'wp-content/fonts/montserrat/JTUSjIg1_i6t8kCHKm459WlhzSTh89Y.woff')}}) format('woff');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
</style>
<!-- Favicon -->
@if(isset($dataManagerPage['favicon']))
    {{$dataManagerPage['favicon']}}
@else
    <link rel="icon" href="{{asset($resourcePathServer.'templates/citybook/assets/img/favicon.ico')}}">
@endif
<style>
    @keyframes beginBrowserAutofill {
        0% {
        }
        to {
        }
    }

    @keyframes endBrowserAutofill {
        0% {
        }
        to {
        }
    }

    .pac-container {
        background-color: #fff;
        position: absolute !important;
        z-index: 1000;
        border-radius: 2px;
        border-top: 1px solid #d9d9d9;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        overflow: hidden
    }

    .pac-logo:after {
        content: "";
        padding: 1px 1px 1px 0;
        height: 18px;
        box-sizing: border-box;
        text-align: right;
        display: block;
        background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3.png);
        background-position: right;
        background-repeat: no-repeat;
        background-size: 120px 14px
    }

    .hdpi.pac-logo:after {
        background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3_hdpi.png)
    }

    .pac-item {
        cursor: default;
        padding: 0 4px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        line-height: 30px;
        text-align: left;
        border-top: 1px solid #e6e6e6;
        font-size: 11px;
        color: #999
    }

    .pac-item:hover {
        background-color: #fafafa
    }

    .pac-item-selected, .pac-item-selected:hover {
        background-color: #ebf2fe
    }

    .pac-matched {
        font-weight: 700
    }

    .pac-item-query {
        font-size: 13px;
        padding-right: 3px;
        color: #000
    }

    .pac-icon {
        width: 15px;
        height: 20px;
        margin-right: 7px;
        margin-top: 6px;
        display: inline-block;
        vertical-align: top;
        background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/autocomplete-icons.png);
        background-size: 34px
    }

    .hdpi .pac-icon {
        background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/autocomplete-icons_hdpi.png)
    }

    .pac-icon-search {
        background-position: -1px -1px
    }

    .pac-item-selected .pac-icon-search {
        background-position: -18px -1px
    }

    .pac-icon-marker {
        background-position: -1px -161px
    }

    .pac-item-selected .pac-icon-marker {
        background-position: -18px -161px
    }

    .pac-placeholder {
        color: gray
    }

    .pac-target-input:-webkit-autofill {
        animation-name: beginBrowserAutofill
    }

    .pac-target-input:not(:-webkit-autofill) {
        animation-name: endBrowserAutofill
    }
</style>


<style type="text/css">
    img.wp-smiley,
    img.emoji {
        display: inline !important;
        border: none !important;
        box-shadow: none !important;
        height: 1em !important;
        width: 1em !important;
        margin: 0 .07em !important;
        vertical-align: -0.1em !important;
        background: none !important;
        padding: 0 !important;
    }
</style>
<link rel="stylesheet" id="mo_openid_admin_settings_style-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/miniorange-login-openid/includes/css/mo_openid_style.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="mo_openid_admin_settings_phone_style-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/miniorange-login-openid/includes/css/phone.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="mo-wp-bootstrap-social-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/miniorange-login-openid/includes/css/bootstrap-social.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="mo-wp-bootstrap-main-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/miniorange-login-openid/includes/css/bootstrap.min-preview.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="mo-openid-sl-wp-font-awesome-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/miniorange-login-openid/includes/css/mo-font-awesome.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="bootstrap_style_ass-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/miniorange-login-openid/includes/css/mo_openid_bootstrap-tour-standalone.css')}}"
      type="text/css" media="all">




@if(isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' )
    <link rel="stylesheet" id="bootstrap_style_ass-css"
          href="http://citybook.meetclic.com/wp-content/plugins/miniorange-login-openid/includes/css/mo_openid_bootstrap-tour-standalone.css?version=5.1.4&amp;ver=5.4"
          type="text/css" media="all">
    <link rel="stylesheet" id="dashicons-css"
          href="http://citybook.meetclic.com/wp-includes/css/dashicons.min.css?ver=5.4" type="text/css" media="all">
    <link rel="stylesheet" id="admin-bar-css"
          href="http://citybook.meetclic.com/wp-includes/css/admin-bar.min.css?ver=5.4" type="text/css" media="all">
    <link rel="stylesheet" id="elementor-common-css"
          href="http://citybook.meetclic.com/wp-content/plugins/elementor/assets/css/common.min.css?ver=2.9.8"
          type="text/css" media="all">

    <style
        type="text/css">
        .scrollax-performance, .scrollax-performance *, .scrollax-performance *:before, .scrollax-performance *:after {
            pointer-events: none !important;
            -webkit-animation-play-state: paused !important;
            animation-play-state: paused !important;
        }

    </style>
@endif


<link rel="stylesheet" id="wp-block-library-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-includes/css/dist/block-library/style.min.css')}}"
      type="text/css"
      media="all">


<link rel="stylesheet" id="select2-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/css/select2.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="citybook-addons-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/citybook-add-ons/assets/css/citybook-add-ons.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="listing_types-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/uploads/azp/css/listing_types.css')}}"
      type="text/css"
      media="all">
<link rel="stylesheet" id="contact-form-7-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/contact-form-7/includes/css/styles.css')}}"
      type="text/css" media="all">
@if(false)
    <link rel="stylesheet" id="wc-block-style-css"
          href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/packages/woocommerce-blocks/build/style.css')}}"
          type="text/css" media="all">
    <link rel="stylesheet" id="woocommerce-layout-css"
          href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/css/woocommerce-layout.css')}}"
          type="text/css" media="all">
    <link rel="stylesheet" id="woocommerce-smallscreen-css"
          href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/css/woocommerce-smallscreen.css')}}"
          type="text/css" media="only screen and (max-width: 768px)">
    <link rel="stylesheet" id="woocommerce-general-css"
          href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/woocommerce/assets/css/woocommerce.css')}}"
          type="text/css" media="all">
@endif
<style id="woocommerce-inline-inline-css" type="text/css">
    .woocommerce form .form-row .required {
        visibility: visible;
    }
</style>
<link rel="stylesheet" id="citybook-fonts-css"
      href="https://fonts.googleapis.com/css?family=Montserrat%3A400%2C500%2C600%2C700%2C800%2C800i%2C900%7CQuicksand%3A300%2C400%2C500%2C700&amp;subset=cyrillic%2Ccyrillic-ext%2Clatin-ext%2Cvietnamese"
      type="text/css" media="all">
<link rel="stylesheet" id="font-awesome-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/font-awesome/css/font-awesome.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="lightgallery-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/css/lightgallery.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="slick-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/css/slick.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="citybook-plugins-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/css/plugins.css')}}"
      type="text/css"
      media="all">
<link rel="stylesheet" id="citybook-style-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/style.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="citybook-color-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/themes/citybook/assets/css/color.min.css')}}"
      type="text/css"
      media="all">
<link rel="stylesheet" id="elementor-icons-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="elementor-animations-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/lib/animations/animations.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="elementor-frontend-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/plugins/elementor/assets/css/frontend.min.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="elementor-global-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/uploads/elementor/css/global.css')}}"
      type="text/css"
      media="all">
<link rel="stylesheet" id="elementor-post-545-css"
      href="{{ URL::asset($resourcePathServer.'templates/citybook/wp-content/uploads/elementor/css/post-545.css')}}"
      type="text/css" media="all">
<link rel="stylesheet" id="google-fonts-1-css"
      href="https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;ver=5.4"
      type="text/css" media="all">

<style type="text/css">
    .scrollax-performance, .scrollax-performance *, .scrollax-performance *:before, .scrollax-performance *:after {
        pointer-events: none !important;
        -webkit-animation-play-state: paused !important;
        animation-play-state: paused !important;
    }

</style>
<noscript>
    <style>
        .woocommerce-product-gallery {
            opacity: 1 !important;
        }
    </style>
</noscript>
<style type="text/css">
    .recentcomments a {
        display: inline !important;
        padding: 0 !important;
        margin: 0 !important;
    }
</style>

<style type="text/css" id="notify-bootstrap">.notifyjs-bootstrap-base {
        font-weight: bold;
        padding: 8px 15px 8px 14px;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
        background-color: #fcf8e3;
        border: 1px solid #fbeed5;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        white-space: nowrap;
        padding-left: 25px;
        background-repeat: no-repeat;
        background-position: 3px 7px;
    }

    .notifyjs-bootstrap-error {
        color: #B94A48;
        background-color: #F2DEDE;
        border-color: #EED3D7;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAtRJREFUeNqkVc1u00AQHq+dOD+0poIQfkIjalW0SEGqRMuRnHos3DjwAH0ArlyQeANOOSMeAA5VjyBxKBQhgSpVUKKQNGloFdw4cWw2jtfMOna6JOUArDTazXi/b3dm55socPqQhFka++aHBsI8GsopRJERNFlY88FCEk9Yiwf8RhgRyaHFQpPHCDmZG5oX2ui2yilkcTT1AcDsbYC1NMAyOi7zTX2Agx7A9luAl88BauiiQ/cJaZQfIpAlngDcvZZMrl8vFPK5+XktrWlx3/ehZ5r9+t6e+WVnp1pxnNIjgBe4/6dAysQc8dsmHwPcW9C0h3fW1hans1ltwJhy0GxK7XZbUlMp5Ww2eyan6+ft/f2FAqXGK4CvQk5HueFz7D6GOZtIrK+srupdx1GRBBqNBtzc2AiMr7nPplRdKhb1q6q6zjFhrklEFOUutoQ50xcX86ZlqaZpQrfbBdu2R6/G19zX6XSgh6RX5ubyHCM8nqSID6ICrGiZjGYYxojEsiw4PDwMSL5VKsC8Yf4VRYFzMzMaxwjlJSlCyAQ9l0CW44PBADzXhe7xMdi9HtTrdYjFYkDQL0cn4Xdq2/EAE+InCnvADTf2eah4Sx9vExQjkqXT6aAERICMewd/UAp/IeYANM2joxt+q5VI+ieq2i0Wg3l6DNzHwTERPgo1ko7XBXj3vdlsT2F+UuhIhYkp7u7CarkcrFOCtR3H5JiwbAIeImjT/YQKKBtGjRFCU5IUgFRe7fF4cCNVIPMYo3VKqxwjyNAXNepuopyqnld602qVsfRpEkkz+GFL1wPj6ySXBpJtWVa5xlhpcyhBNwpZHmtX8AGgfIExo0ZpzkWVTBGiXCSEaHh62/PoR0p/vHaczxXGnj4bSo+G78lELU80h1uogBwWLf5YlsPmgDEd4M236xjm+8nm4IuE/9u+/PH2JXZfbwz4zw1WbO+SQPpXfwG/BBgAhCNZiSb/pOQAAAAASUVORK5CYII=);
    }

    .notifyjs-bootstrap-success {
        color: #468847;
        background-color: #DFF0D8;
        border-color: #D6E9C6;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAutJREFUeNq0lctPE0Ecx38zu/RFS1EryqtgJFA08YCiMZIAQQ4eRG8eDGdPJiYeTIwHTfwPiAcvXIwXLwoXPaDxkWgQ6islKlJLSQWLUraPLTv7Gme32zoF9KSTfLO7v53vZ3d/M7/fIth+IO6INt2jjoA7bjHCJoAlzCRw59YwHYjBnfMPqAKWQYKjGkfCJqAF0xwZjipQtA3MxeSG87VhOOYegVrUCy7UZM9S6TLIdAamySTclZdYhFhRHloGYg7mgZv1Zzztvgud7V1tbQ2twYA34LJmF4p5dXF1KTufnE+SxeJtuCZNsLDCQU0+RyKTF27Unw101l8e6hns3u0PBalORVVVkcaEKBJDgV3+cGM4tKKmI+ohlIGnygKX00rSBfszz/n2uXv81wd6+rt1orsZCHRdr1Imk2F2Kob3hutSxW8thsd8AXNaln9D7CTfA6O+0UgkMuwVvEFFUbbAcrkcTA8+AtOk8E6KiQiDmMFSDqZItAzEVQviRkdDdaFgPp8HSZKAEAL5Qh7Sq2lIJBJwv2scUqkUnKoZgNhcDKhKg5aH+1IkcouCAdFGAQsuWZYhOjwFHQ96oagWgRoUov1T9kRBEODAwxM2QtEUl+Wp+Ln9VRo6BcMw4ErHRYjH4/B26AlQoQQTRdHWwcd9AH57+UAXddvDD37DmrBBV34WfqiXPl61g+vr6xA9zsGeM9gOdsNXkgpEtTwVvwOklXLKm6+/p5ezwk4B+j6droBs2CsGa/gNs6RIxazl4Tc25mpTgw/apPR1LYlNRFAzgsOxkyXYLIM1V8NMwyAkJSctD1eGVKiq5wWjSPdjmeTkiKvVW4f2YPHWl3GAVq6ymcyCTgovM3FzyRiDe2TaKcEKsLpJvNHjZgPNqEtyi6mZIm4SRFyLMUsONSSdkPeFtY1n0mczoY3BHTLhwPRy9/lzcziCw9ACI+yql0VLzcGAZbYSM5CCSZg1/9oc/nn7+i8N9p/8An4JMADxhH+xHfuiKwAAAABJRU5ErkJggg==);
    }

    .notifyjs-bootstrap-info {
        color: #3A87AD;
        background-color: #D9EDF7;
        border-color: #BCE8F1;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QYFAhkSsdes/QAAA8dJREFUOMvVlGtMW2UYx//POaWHXg6lLaW0ypAtw1UCgbniNOLcVOLmAjHZolOYlxmTGXVZdAnRfXQm+7SoU4mXaOaiZsEpC9FkiQs6Z6bdCnNYruM6KNBw6YWewzl9z+sHImEWv+vz7XmT95f/+3/+7wP814v+efDOV3/SoX3lHAA+6ODeUFfMfjOWMADgdk+eEKz0pF7aQdMAcOKLLjrcVMVX3xdWN29/GhYP7SvnP0cWfS8caSkfHZsPE9Fgnt02JNutQ0QYHB2dDz9/pKX8QjjuO9xUxd/66HdxTeCHZ3rojQObGQBcuNjfplkD3b19Y/6MrimSaKgSMmpGU5WevmE/swa6Oy73tQHA0Rdr2Mmv/6A1n9w9suQ7097Z9lM4FlTgTDrzZTu4StXVfpiI48rVcUDM5cmEksrFnHxfpTtU/3BFQzCQF/2bYVoNbH7zmItbSoMj40JSzmMyX5qDvriA7QdrIIpA+3cdsMpu0nXI8cV0MtKXCPZev+gCEM1S2NHPvWfP/hL+7FSr3+0p5RBEyhEN5JCKYr8XnASMT0xBNyzQGQeI8fjsGD39RMPk7se2bd5ZtTyoFYXftF6y37gx7NeUtJJOTFlAHDZLDuILU3j3+H5oOrD3yWbIztugaAzgnBKJuBLpGfQrS8wO4FZgV+c1IxaLgWVU0tMLEETCos4xMzEIv9cJXQcyagIwigDGwJgOAtHAwAhisQUjy0ORGERiELgG4iakkzo4MYAxcM5hAMi1WWG1yYCJIcMUaBkVRLdGeSU2995TLWzcUAzONJ7J6FBVBYIggMzmFbvdBV44Corg8vjhzC+EJEl8U1kJtgYrhCzgc/vvTwXKSib1paRFVRVORDAJAsw5FuTaJEhWM2SHB3mOAlhkNxwuLzeJsGwqWzf5TFNdKgtY5qHp6ZFf67Y/sAVadCaVY5YACDDb3Oi4NIjLnWMw2QthCBIsVhsUTU9tvXsjeq9+X1d75/KEs4LNOfcdf/+HthMnvwxOD0wmHaXr7ZItn2wuH2SnBzbZAbPJwpPx+VQuzcm7dgRCB57a1uBzUDRL4bfnI0RE0eaXd9W89mpjqHZnUI5Hh2l2dkZZUhOqpi2qSmpOmZ64Tuu9qlz/SEXo6MEHa3wOip46F1n7633eekV8ds8Wxjn37Wl63VVa+ej5oeEZ/82ZBETJjpJ1Rbij2D3Z/1trXUvLsblCK0XfOx0SX2kMsn9dX+d+7Kf6h8o4AIykuffjT8L20LU+w4AZd5VvEPY+XpWqLV327HR7DzXuDnD8r+ovkBehJ8i+y8YAAAAASUVORK5CYII=);
    }

    .notifyjs-bootstrap-warn {
        color: #C09853;
        background-color: #FCF8E3;
        border-color: #FBEED5;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAABJlBMVEXr6eb/2oD/wi7/xjr/0mP/ykf/tQD/vBj/3o7/uQ//vyL/twebhgD/4pzX1K3z8e349vK6tHCilCWbiQymn0jGworr6dXQza3HxcKkn1vWvV/5uRfk4dXZ1bD18+/52YebiAmyr5S9mhCzrWq5t6ufjRH54aLs0oS+qD751XqPhAybhwXsujG3sm+Zk0PTwG6Shg+PhhObhwOPgQL4zV2nlyrf27uLfgCPhRHu7OmLgAafkyiWkD3l49ibiAfTs0C+lgCniwD4sgDJxqOilzDWowWFfAH08uebig6qpFHBvH/aw26FfQTQzsvy8OyEfz20r3jAvaKbhgG9q0nc2LbZxXanoUu/u5WSggCtp1anpJKdmFz/zlX/1nGJiYmuq5Dx7+sAAADoPUZSAAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfdBgUBGhh4aah5AAAAlklEQVQY02NgoBIIE8EUcwn1FkIXM1Tj5dDUQhPU502Mi7XXQxGz5uVIjGOJUUUW81HnYEyMi2HVcUOICQZzMMYmxrEyMylJwgUt5BljWRLjmJm4pI1hYp5SQLGYxDgmLnZOVxuooClIDKgXKMbN5ggV1ACLJcaBxNgcoiGCBiZwdWxOETBDrTyEFey0jYJ4eHjMGWgEAIpRFRCUt08qAAAAAElFTkSuQmCC);
    }
</style>
<style type="text/css" id="core-notify">
    .notifyjs-corner {
        position: fixed;
        margin: 5px;
        z-index: 1050;
    }

    .notifyjs-corner .notifyjs-wrapper,
    .notifyjs-corner .notifyjs-container {
        position: relative;
        display: block;
        height: inherit;
        width: inherit;
        margin: 3px;
    }

    .notifyjs-wrapper {
        z-index: 1;
        position: absolute;
        display: inline-block;
        height: 0;
        width: 0;
    }

    .notifyjs-container {
        display: none;
        z-index: 1;
        position: absolute;
    }

    .notifyjs-hidable {
        cursor: pointer;
    }

    [data-notify-text], [data-notify-html] {
        position: relative;
    }

    .notifyjs-arrow {
        position: absolute;
        z-index: 2;
        width: 0;
        height: 0;
    }

    .fa--position-icon {
        margin-top: 33%;
    }
</style>
@if(isset($dataManagerPage['currentPage'])&& $dataManagerPage['currentPage']=='search' )
    <style>
        .gm-control-active > img {
            box-sizing: content-box;
            display: none;
            left: 50%;
            pointer-events: none;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%)
        }

        .gm-control-active > img:nth-child(1) {
            display: block
        }

        .gm-control-active:hover > img:nth-child(1), .gm-control-active:active > img:nth-child(1) {
            display: none
        }

        .gm-control-active:hover > img:nth-child(2), .gm-control-active:active > img:nth-child(3) {
            display: block
        }
    </style>
    <link type="text/css" rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Google+Sans:400,500,700">
    <style>.gm-ui-hover-effect {
            opacity: .6
        }

        .gm-ui-hover-effect:hover {
            opacity: 1
        }
    </style>
    <style>.gm-style .gm-style-cc span, .gm-style .gm-style-cc a, .gm-style .gm-style-mtc div {
            font-size: 10px;
            box-sizing: border-box
        }
    </style>
    <style>@media print {
            .gm-style .gmnoprint, .gmnoprint {
                display: none
            }
        }

        @media screen {
            .gm-style .gmnoscreen, .gmnoscreen {
                display: none
            }
        }</style>
    <style>.gm-style-pbc {
            transition: opacity ease-in-out;
            background-color: rgba(0, 0, 0, 0.45);
            text-align: center
        }

        .gm-style-pbt {
            font-size: 22px;
            color: white;
            font-family: Roboto, Arial, sans-serif;
            position: relative;
            margin: 0;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%)
        }
    </style>
    <style>.gm-style img {
            max-width: none;
        }

        .gm-style {
            font: 400 11px Roboto, Arial, sans-serif;
            text-decoration: none;
        }</style>
    <style>
        @keyframes beginBrowserAutofill {
            0% {
            }
            to {
            }
        }

        @keyframes endBrowserAutofill {
            0% {
            }
            to {
            }
        }

        .pac-container {
            background-color: #fff;
            position: absolute !important;
            z-index: 1000;
            border-radius: 2px;
            border-top: 1px solid #d9d9d9;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            overflow: hidden
        }

        .pac-logo:after {
            content: "";
            padding: 1px 1px 1px 0;
            height: 18px;
            box-sizing: border-box;
            text-align: right;
            display: block;
            background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3.png);
            background-position: right;
            background-repeat: no-repeat;
            background-size: 120px 14px
        }

        .hdpi.pac-logo:after {
            background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3_hdpi.png)
        }

        .pac-item {
            cursor: default;
            padding: 0 4px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            line-height: 30px;
            text-align: left;
            border-top: 1px solid #e6e6e6;
            font-size: 11px;
            color: #999
        }

        .pac-item:hover {
            background-color: #fafafa
        }

        .pac-item-selected, .pac-item-selected:hover {
            background-color: #ebf2fe
        }

        .pac-matched {
            font-weight: 700
        }

        .pac-item-query {
            font-size: 13px;
            padding-right: 3px;
            color: #000
        }

        .pac-icon {
            width: 15px;
            height: 20px;
            margin-right: 7px;
            margin-top: 6px;
            display: inline-block;
            vertical-align: top;
            background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/autocomplete-icons.png);
            background-size: 34px
        }

        .hdpi .pac-icon {
            background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/autocomplete-icons_hdpi.png)
        }

        .pac-icon-search {
            background-position: -1px -1px
        }

        .pac-item-selected .pac-icon-search {
            background-position: -18px -1px
        }

        .pac-icon-marker {
            background-position: -1px -161px
        }

        .pac-item-selected .pac-icon-marker {
            background-position: -18px -161px
        }

        .pac-placeholder {
            color: gray
        }

        .pac-target-input:-webkit-autofill {
            animation-name: beginBrowserAutofill
        }

        .pac-target-input:not(:-webkit-autofill) {
            animation-name: endBrowserAutofill
        }
    </style>


    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <style id="citybook-addons-inline-css" type="text/css">
        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsjrlk9fu {
                width: 66.66%;
            }

            .body-citybook .azp-element-jsjrlmj98 {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsk77s8g6 {
                margin-top: 15px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                padding-top: 15px;
                padding-right: 0px;
                padding-bottom: 15px;
                padding-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-top-width: 1px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-color: #eeeeee;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-style: solid;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7rvlcg {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rwlyd {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rx0nl {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rxu0v {
                width: 10%;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsjrlk9fu {
                width: 66.66%;
            }

            .body-citybook .azp-element-jsjrlmj98 {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsk77s8g6 {
                margin-top: 15px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                padding-top: 15px;
                padding-right: 0px;
                padding-bottom: 15px;
                padding-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-top-width: 1px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-color: #eeeeee;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-style: solid;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7pamdd {
                padding-top: 0px;
                padding-right: 5px;
                padding-bottom: 0px;
                padding-left: 5px;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 35%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 40%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 25%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 35%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 40%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 25%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 35%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 40%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 25%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7rvlcg {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rwlyd {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rx0nl {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rxu0v {
                width: 10%;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsjrlk9fu {
                width: 66.66%;
            }

            .body-citybook .azp-element-jsjrlmj98 {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsk77s8g6 {
                margin-top: 15px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                padding-top: 15px;
                padding-right: 0px;
                padding-bottom: 15px;
                padding-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-top-width: 1px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-color: #eeeeee;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-style: solid;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7rvlcg {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rwlyd {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rx0nl {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rxu0v {
                width: 10%;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsjrlk9fu {
                width: 66.66%;
            }

            .body-citybook .azp-element-jsjrlmj98 {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsk77s8g6 {
                margin-top: 15px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                padding-top: 15px;
                padding-right: 0px;
                padding-bottom: 15px;
                padding-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-top-width: 1px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-color: #eeeeee;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-style: solid;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7rvlcg {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rwlyd {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rx0nl {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rxu0v {
                width: 10%;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsjrlk9fu {
                width: 66.66%;
            }

            .body-citybook .azp-element-jsjrlmj98 {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsk77s8g6 {
                margin-top: 15px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                padding-top: 15px;
                padding-right: 0px;
                padding-bottom: 15px;
                padding-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-top-width: 1px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-color: #eeeeee;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-style: solid;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7rvlcg {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rwlyd {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rx0nl {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rxu0v {
                width: 10%;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jrbjigyl7 {
                width: 40%;
            }

            .body-citybook .azp-element-jrbjiiz3o {
                width: 60%;
            }

            .body-citybook .azp-element-jrbjjq07j {
                width: 50%;
            }

            .body-citybook .azp-element-jrbjjqeyl {
                width: 50%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jrbjiiz3o {
                margin-top: 20px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jrbjjq07j {
                width: 50%;
            }

            .body-citybook .azp-element-jrbjjqeyl {
                width: 50%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jrbjiiz3o {
                margin-top: 20px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jrbjjq07j {
                width: 100%;
            }

            .body-citybook .azp-element-jrbjjqeyl {
                width: 100%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsjrlk9fu {
                width: 66.66%;
            }

            .body-citybook .azp-element-jsjrlmj98 {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsk77s8g6 {
                margin-top: 15px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                padding-top: 15px;
                padding-right: 0px;
                padding-bottom: 15px;
                padding-left: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-top-width: 1px;
                border-right-width: 0px;
                border-bottom-width: 0px;
                border-left-width: 0px;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-color: #eeeeee;
            }

            .body-citybook .azp-element-jsk77s8g6 {
                border-style: solid;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 1024px) and (min-width: 768px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (max-width: 767px) {
            .body-citybook .azp-element-jsl7tywcm {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7tzwlv {
                width: 33.33%;
            }

            .body-citybook .azp-element-jsl7u08hw {
                width: 33.33%;
            }
        }

        @media screen and (min-width: 1024px) {
            .body-citybook .azp-element-jsl7rvlcg {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rwlyd {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rx0nl {
                width: 30%;
            }

            .body-citybook .azp-element-jsl7rxu0v {
                width: 10%;
            }
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }

        @media screen and (min-width: 1024px) {
        }
    </style>



    <style type="text/css" media="screen">
        html {
            margin-top: 32px !important;
        }

        * html body {
            margin-top: 32px !important;
        }

        @media screen and ( max-width: 782px ) {
            html {
                margin-top: 46px !important;
            }

            * html body {
                margin-top: 46px !important;
            }
        }
    </style>

    <style>
        #td-clock-0 .td-clock {
            color: #555;
            background: #FFF;
            box-shadow: 0 0 0 1px #4DB7FE, 0 0 0 8px rgba(0, 0, 0, 0.05);
        }

        #td-clock-0 .td-clock .td-time span.on {
            color: #4DB7FE
        }

        #td-clock-0 .td-clock:before {
            border-color: #4DB7FE
        }

        #td-clock-0 .td-select:after {
            box-shadow: 0 0 0 1px #4DB7FE
        }

        #td-clock-0 .td-clock:before, #td-clock-0 .td-select:after {
            background: #FFF;
        }

        #td-clock-0 .td-lancette {
            border: 2px solid #4DB7FE;
            opacity: 0.1
        }

        #td-clock-0 .td-lancette div:after {
            background: #4DB7FE;
        }

        #td-clock-0 .td-bulletpoint div:after {
            background: #4DB7FE;
            opacity: 0.1
        }
    </style>

    <style type="text/css">

        .iw-contextMenu {
            box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.10) !important;
            border: 1px solid #c8c7cc !important;
            border-radius: 11px !important;
            display: none;
            z-index: 1000000132;
            max-width: 300px !important;
            width: auto !important;
        }

        .dark-mode .iw-contextMenu,
        .TnITTtw-dark-mode.iw-contextMenu,
        .TnITTtw-dark-mode .iw-contextMenu {
            border-color: #747473 !important;
        }

        .iw-cm-menu {
            background: #fff !important;
            color: #000 !important;
            margin: 0px !important;
            padding: 0px !important;
            overflow: visible !important;
        }

        .dark-mode .iw-cm-menu,
        .TnITTtw-dark-mode.iw-cm-menu,
        .TnITTtw-dark-mode .iw-cm-menu {
            background: #525251 !important;
            color: #FFF !important;
        }

        .iw-curMenu {
        }

        .iw-cm-menu li {
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Helvetica, Arial, Ubuntu, sans-serif !important;
            list-style: none !important;
            padding: 10px !important;
            padding-right: 20px !important;
            border-bottom: 1px solid #c8c7cc !important;
            font-weight: 400 !important;
            cursor: pointer !important;
            position: relative !important;
            font-size: 14px !important;
            margin: 0 !important;
            line-height: inherit !important;
            border-radius: 0 !important;
            display: block !important;
        }

        .dark-mode .iw-cm-menu li, .TnITTtw-dark-mode .iw-cm-menu li {
            border-bottom-color: #747473 !important;
        }

        .iw-cm-menu li:first-child {
            border-top-left-radius: 11px !important;
            border-top-right-radius: 11px !important;
        }

        .iw-cm-menu li:last-child {
            border-bottom-left-radius: 11px !important;
            border-bottom-right-radius: 11px !important;
            border-bottom: none !important;
        }

        .iw-mOverlay {
            position: absolute !important;
            width: 100% !important;
            height: 100% !important;
            top: 0px !important;
            left: 0px !important;
            background: #FFF !important;
            opacity: .5 !important;
        }

        .iw-contextMenu li.iw-mDisable {
            opacity: 0.3 !important;
            cursor: default !important;
        }

        .iw-mSelected {
            background-color: #F6F6F6 !important;
        }

        .dark-mode .iw-mSelected, .TnITTtw-dark-mode .iw-mSelected {
            background-color: #676766 !important;
        }

        .iw-cm-arrow-right {
            width: 0 !important;
            height: 0 !important;
            border-top: 5px solid transparent !important;
            border-bottom: 5px solid transparent !important;
            border-left: 5px solid #000 !important;
            position: absolute !important;
            right: 5px !important;
            top: 50% !important;
            margin-top: -5px !important;
        }

        .dark-mode .iw-cm-arrow-right, .TnITTtw-dark-mode .iw-cm-arrow-right {
            border-left-color: #FFF !important;
        }

        .iw-mSelected > .iw-cm-arrow-right {
        }

        /*context menu css end */</style>
    <style type="text/css">@-webkit-keyframes load4 {
                               0%,
                               100% {
                                   box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
                               }
                               12.5% {
                                   box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
                               }
                               25% {
                                   box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
                               }
                               37.5% {
                                   box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
                               }
                               50% {
                                   box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
                               }
                               62.5% {
                                   box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
                               }
                               75% {
                                   box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
                               }
                               87.5% {
                                   box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
                               }
                           }

        @keyframes load4 {
            0%,
            100% {
                box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
            }
            12.5% {
                box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
            }
            25% {
                box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
            }
            37.5% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
            }
            50% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
            }
            62.5% {
                box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
            }
            75% {
                box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
            }
            87.5% {
                box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
            }
        }</style>
@endif
@yield('css')
@yield('additional-styles')

