<style id="checkout-manager">

    #paypal-button-container div div {

        position: absolute !important;
        right: 0 !important;
        width: 100% !important;
        /*    min-width: 100%!important;
            max-width: 100%!important;*/
    }

    .form-group input::-webkit-input-placeholder, .form-group select::-webkit-input-placeholder {
        color: #9b9b9b !important;
        font-weight: 100 !important;
        font-size: 10px !important;

    }

    .form-group input::-moz-placeholder, .form-group select::-moz-placeholder {
        color: #9b9b9b !important;
        font-weight: 100 !important;
        font-size: 10px !important;

    }

    .form-group input:-ms-input-placeholder, .form-group select:-ms-input-placeholder {
        color: #9b9b9b !important;
        font-weight: 100 !important;
        font-size: 10px !important;

    }

    .form-group input::-ms-input-placeholder, .form-group select::-ms-input-placeholder {
        color: #9b9b9b !important;
        font-weight: 100 !important;
        font-size: 10px !important;

    }

    .form-group input::placeholder, .form-group select::placeholder {
        color: #9b9b9b !important;
        font-weight: 100 !important;
        font-size: 10px !important;

    }

    .form-group--success::before {
        font-family: Arial, Helvetica, sans-serif;
        display: block;
        content: "✓";
        font-size: 20px;
        color: rgb(124, 199, 104);
        position: absolute;
        right: 5%;
        top: 22%;
        pointer-events: none;
    }

    .invalid-feedback::before {
        content: "↑";
        display: block;
        position: relative;
        left: 0px;
        top: 15px;
    }
    .invalid-feedback.d-block span {
        margin-left: 3%;
    }
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #fff;
        z-index: 9999; }

    #status {
        width: 80px;
        height: 80px;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -40px 0 0 -40px; }

    @-webkit-keyframes bouncing-loader {
        to {
            opacity: 0.1;
            -webkit-transform: translate3d(0, -16px, 0);
            transform: translate3d(0, -16px, 0); } }

    @keyframes bouncing-loader {
        to {
            opacity: 0.1;
            -webkit-transform: translate3d(0, -16px, 0);
            transform: translate3d(0, -16px, 0); } }

    .bouncingLoader {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center; }
    .bouncingLoader > div {
        width: 13px;
        height: 13px;
        margin: 32px 3px;
        background: #3bafda;
        border-radius: 50%;
        -webkit-animation: bouncing-loader 0.6s infinite alternate;
        animation: bouncing-loader 0.6s infinite alternate; }
    .bouncingLoader > div:nth-child(2) {
        -webkit-animation-delay: 0.2s;
        animation-delay: 0.2s;
        background: #f1556c; }
    .bouncingLoader > div:nth-child(3) {
        -webkit-animation-delay: 0.4s;
        animation-delay: 0.4s;
        background: #1abc9c; }
    .not-view{
        display:none !important;
    }
    .management-view-link {
        color: #d92523 !important;
    }


    .chat-widget-button {
        position: fixed;
        bottom: 159px;
        right: 30px;
        width: 40px;
        height: 40px;
        color: #fff;
        line-height: 40px;
        font-size: 17px;
        background: #25D366;
        z-index: 116;
        cursor: pointer;
        border-radius: 3px;
        box-shadow: 0px 0px 0px 7px rgba(255, 255, 255, 0.2);
        -webkit-transform: translate3d(0, 0, 0);
    }

    .chat-widget-button i {
        margin-left: 30%;
    }

    .chat-widget-button.closechat_btn i:before {
        content: "\f00d";
    }

    .chat-widget-button span {
        width: 150px;
        box-shadow: 0px 0px 0px 2px rgba(255, 255, 255, 0.2);
        position: absolute;
        left: -160px;
        top: 0;
        height: 40px;
        line-height: 40px;
        background: #25D366;
        color: #fff;
        border-radius: 3px;
        visibility: hidden;
        font-weight: 600;
        font-size: 12px;
        opacity: 0;
        -webkit-transition: all 0.2s ease-in-out;
        transition: all 0.2s ease-in-out;
        padding-left: 27%;
    }

    .chat-widget-button:hover span {
        visibility: visible;
        opacity: 1
    }

    .chat-widget_wrap {
        position: fixed;
        bottom: 180px;
        right: 50px;
        width: 300px;
        height: 400px;
        z-index: 116;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0px 0px 80px 0px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        display: none;
        -webkit-transform: translate3d(0, 0, 0);
    }

    .chat-widget_header {
        height: 50px;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        line-height: 50px;
        padding: 0 25px;
    }

    .chat-widget_header h3 {
        float: left;
        color: #fff;
        font-weight: 600;
        font-size: 12px;
    }

    .chat-widget_header h3 a {
        color: #fff;
        text-decoration: underline;
    }

    .chat-widget-button-content {
        position: absolute;
    }

    .img-responsive {
        height: auto;
        max-width: 100%;
        display: block;
    }





    .footer-navigation-area {
        padding-bottom: 0px !important;
        padding-top: 3% !important;
    }

    .footer-widget__navigation ul li a {

        line-height: 0px;
        padding: 0px 0;
    }


    .single-banner__image a img {

        height: 266px !important;
    }






    .content-box-image__preview {
        width: 100%;
        height: 170px;
    }


    .preview-manager {
        width: 100%;
        height: 180px;
    }
    .content-box-preview {
        background-position: center center;
        background-size: cover;
        perspective: 450px;
        position: relative;
    }

    .content-box-image {
        width: 300px;
        height: 170px;
        background: #eee;
        cursor: pointer;
        float: left;
        margin: 30px;
    }

    .form-group__input {
        padding: 6% 6% 2.5% 5%;
        transition: border-color .25s ease-in-out;
        color: rgb(51, 51, 51);
        border: 1px solid rgb(97, 94, 94);
        border-radius: 5px;
        background-color: transparent;
    }
    .form-group--float-label, .form-group__input {
        position: relative;
    }
    .form-group__input + .form-group__label {
        position: absolute;
        top: .75em;
        left: .75em;
        display: inline-block;
        width: auto;
        margin: 0;
        padding: .75em;
        transition: transform .25s, opacity .25s, padding .25s ease-in-out;
        transform-origin: 0 0;
        color: rgba(255, 255, 255, .5);
    }

    footer.main-footer {
        z-index: 1 !important;
    }

    /* Making the label break the flow */
    /* LABELS*/

    .form-group__label {
        position: absolute;
        top: 0;
        left: 0;
        user-select: none;
        z-index: 500;
    }

    .form-group__input + .form-group__label {
        z-index: 500;
    }

    .form-group__input + .form-group__label {
        transition: transform .25s, opacity .25s ease-in-out;
        transform-origin: 0 0;
        opacity: .5;
    }

    .form-group__input:focus + .form-group__label,
    .form-group__input:not(:placeholder-shown) + .form-group__label {
        transform: translate(.25em, -30%) scale(.8);
        opacity: .25;
    }

    .form-group__input + .form-group__label {
        position: absolute;
        top: .75em;
        left: .75em;
        display: inline-block;
        width: auto;
        margin: 0;
        padding: .75em;
        transition: transform .25s, opacity .25s, padding .25s ease-in-out;
        transform-origin: 0 0;
        color: rgba(255, 255, 255, .5);
    }

    .form-group__input:focus + .form-group__label,
    .form-group__input:not(:placeholder-shown) + .form-group__label {
        z-index: 500;
        padding-top: 8%;
        transform: translate(0, -2em) scale(.9);
        color: #666;
    }

    /*INPUTS*/
    /* Hide the browser-specific focus styles */
    .form-group--float-label .form-group__input:focus,
    .form-group--float-label .form-group__input:not(:placeholder-shown) {
        border-color: #666;
    }

    .form-group__input {
        color: rgba(44, 62, 80, .75);
        border-width: 0;
        z-index: 600;
    }

    .form-group__input:focus {
        outline: 0;
    }

    .form-group__input::placeholder {
        color: rgba(44, 62, 80, .5);
    }

    /* Make the label and field look identical on every browser */
    .form-group__label,
    .form-group__input {
        font: inherit;
        line-height: 1;
        display: block;
        width: 100%;
    }

    .form-group--float-label,
    .form-group__input {
        position: relative;
    }

    /* Input Style #1 */
    .form-group__input {
        transition: border-color .25s ease-in-out;
        border-bottom: 3px solid rgba(255, 255, 255, .05);
        background-color: transparent;
    }


    .form-group__input:focus,
    .form-group__input:not(:placeholder-shown) {
        border-color: rgba(255, 255, 255, .1);
    }

    .form-group__input {
        padding: 6% 6% 2.5% 5%;
        transition: border-color .25s ease-in-out;
        color: rgb(51, 51, 51);
        border: 1px solid rgb(97, 94, 94);
        border-radius: 5px;
        background-color: transparent;
    }


    /* Common Styles */
    /* Identical inputs on all browsers */
    .form-group--float-label.form-group__input:not(textarea),
    .form-group--float-label.form-group__input:not(textarea) {
        max-height: 4em;
    }

label{
        border: none;
        outline: 0;
        font-weight: inherit;
        font-style: inherit;
        font-size: 100%;

        vertical-align: baseline;
        text-decoration: none;
        margin: 0;
        padding: 0;
    }
    label {
        display: inline-block;
        margin-bottom: .5rem;
    }
    /*-- Checkout Cart Total --*/

    .checkout-cart-total {
        margin-bottom: 30px;
        padding: 45px;
        background-color: #f2f2f2;
    }

    .checkout-cart-total h4 {
        font-weight: 700;
        line-height: 23px;
        -webkit-flex-basis: 18px;
        -ms-flex-preferred-size: 18px;
        flex-basis: 18px;
    }

    .checkout-cart-total h4:first-child {
        margin-top: 0;
        margin-bottom: 25px;
    }

    .checkout-cart-total h4:last-child {
        margin-top: 15px;
        margin-bottom: 0;
    }

    .checkout-cart-total h4 span {
        display: block;
        float: right;
    }

    .checkout-cart-total ul {
        border-bottom: 1px solid #999;
    }

    .checkout-cart-total ul li {
        font-size: 14px;
        font-weight: 500;
        line-height: 23px;
        display: block;
        margin-bottom: 16px;
        color: #666;
    }

    .checkout-cart-total ul li span {
        float: right;
        color: #333;
    }

    .checkout-cart-total p {
        font-size: 14px;
        font-weight: 600;
        line-height: 30px;
        margin: 0;
        padding: 10px 0;
        color: #505050;
        border-bottom: 1px solid #999;
    }

    .checkout-cart-total p span {
        float: right;
    }

    /*-- Checkout Payment Method --*/

    .checkout-payment-method {
        padding: 45px;
        background-color: #f2f2f2;
    }

    /*-- Single Payment Method --*/

    .single-method {
        margin-bottom: 20px;
    }

    .single-method:last-child {
        margin-bottom: 0;
    }

    .single-method input[type='radio'] {
        display: none;
    }

    .single-method input[type='radio'] + label {
        font-size: 14px;
        font-weight: 400;
        line-height: 20px;
        position: relative;
        margin: 0;
        padding-left: 30px;
        color: #333;
    }

    .single-method input[type='radio'] + label::before {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 20px;
        height: 20px;
        content: '';
        -webkit-transition: all .3s ease 0s;
        transition: all .3s ease 0s;
        border: 2px solid #999;
    }

    .single-method input[type='radio'] + label::after {
        position: absolute;
        top: 5px;
        left: 5px;
        display: block;
        width: 10px;
        height: 10px;
        content: '';
        -webkit-transition: all .3s ease 0s;
        transition: all .3s ease 0s;
        text-align: center;
        opacity: 0;
        background-color: #333;
    }

    .single-method input[type='radio']:checked + label::before {
        border: 2px solid #333;
    }

    .single-method input[type='radio']:checked + label::after {
        opacity: 1;
    }

    .single-method input[type='checkbox'] {
        display: none;
    }

    .single-method input[type='checkbox'] + label {
        font-size: 14px;
        font-weight: 400;
        line-height: 20px;
        position: relative;
        margin: 0;
        padding-left: 30px;
        color: #666;
    }

    .single-method input[type='checkbox'] + label::before {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 16px;
        height: 16px;
        content: '';
        -webkit-transition: all .3s ease 0s;
        transition: all .3s ease 0s;
        border: 2px solid #999;
    }

    .single-method input[type='checkbox'] + label::after {
        position: absolute;
        top: 4px;
        left: 4px;
        display: block;
        width: 8px;
        height: 8px;
        content: '';
        -webkit-transition: all .3s ease 0s;
        transition: all .3s ease 0s;
        text-align: center;
        opacity: 0;
        background-color: #333;
    }

    .single-method input[type='checkbox']:checked + label::before {
        border: 2px solid #333;
    }

    .single-method input[type='checkbox']:checked + label::after {
        opacity: 1;
    }

    .single-method p {
        font-size: 14px;
        line-height: 23px;
        display: none;
        margin-top: 8px;
        color: #666;
    }

    /*-- Place Order --*/

    .place-order {
        font-weight: 400;
        line-height: 24px;
        float: left;
        width: 140px;
        height: 36px;
        margin-top: 40px;
        padding: 6px 20px;
        text-transform: uppercase;
        color: #fff;
        border: none;
        background-color: #333;
    }

    .place-order:hover {
        background-color: #fff;
    }

    .place-order-btn {
        margin-top: 15px;
    }

    /*=====  End of checkout  ======*/

    /*=============================================
        =            Responsive styles            =
        =============================================*/

    @media only screen and (min-width: 480px) and (max-width: 575px) {

        .col-custom-sm-6 {
            max-width: 50%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 50%;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }

    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {

        .header-sticky.is-sticky .header-icon__list__item > a {
            padding: 0;
        }

        .header-sticky.is-sticky .header-icon__list__item > a span.item-count {
            top: -10px;
        }

        .minicart-wrapper {
            display: none;
        }

        .footer-navigation-area {
            padding-bottom: 100px;
        }

        .footer-widget__title {
            margin-top: -5px;
        }

        .theme-button--banner {
            font-size: 12px;
            padding: 5px 15px;
        }

        .theme-button--banner--scale {
            border: none;
        }

        .theme-button--banner--scale:hover {
            color: #222;
            border-color: transparent;
            background: none;
        }

        .search-overlay .search-overlay-content .input-box form input {
            font-size: 40px;
        }

        .single-banner__image:after {
            display: none;
        }

        .single-banner__content {
            display: none;
        }

        .single-banner__content--overlay p.banner-small-text--end {
            font-size: 14px;
        }

        .single-banner__content--overlay p.banner-big-text {
            font-size: 22px;
        }

        .single-banner:hover .single-banner__content p.banner-small-text {
            line-height: 15px;
            margin-bottom: 0;
        }

        .single-banner:hover .single-banner__content p.banner-small-text--end {
            margin-bottom: 10px;
            padding-bottom: 10px;
        }

        .single-banner:hover .single-banner__content p.banner-big-text {
            margin-bottom: 0;
        }

        .single-banner--scale__image:after {
            visibility: visible;
            opacity: 1;
        }

        .single-banner--scale__content {
            left: 50%;
            width: 90%;
            max-width: 100%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .single-banner--scale__content .title {
            font-size: 24px;
            line-height: 24px;
        }

        .single-banner--scale__content .subtitle {
            margin-bottom: 5px;
        }

        .single-two-column-banner__image {
            margin-bottom: 30px;
        }

        .single-two-column-banner__content {
            padding: 60px 0;
        }

        .single-two-column-banner__content .content-wrapper {
            width: 95%;
        }

        .single-two-column-banner__content .content-wrapper .image {
            margin-bottom: 10px;
        }

        .single-two-column-banner__content .content-wrapper .content .title {
            font-size: 40px;
            line-height: 45px;
            margin-bottom: 15px;
        }

        .section-space--breadcrumb {
            padding-top: 100px;
            padding-bottom: 100px;
        }

        .cta-content--two .title {
            font-size: 60px;
            line-height: 110px;
            margin-top: -35px;
        }

        .cta-content--two .subtitle {
            width: 80%;
            max-width: 100%;
        }

        .deal-counter-wrapper__image {
            margin-bottom: 40px;
        }

        .deal-counter-wrapper {
            margin: 0;
        }

        .deal-counter-wrapper__content {
            padding: 0 30px;
        }

        .breadcrumb-wrapper {
            margin-bottom: 0;
        }

        .breadcrumb-wrapper .page-title {
            font-size: 50px;
            line-height: 60px;
            margin-top: -10px;
        }

        .theme-slick-slider .slick-arrow {
            visibility: visible;
            opacity: .6;
        }

        .product-slider-text-wrapper {
            margin: 0;
            padding: 65px 30px;
        }

        .product-slider-text-wrapper__text {
            margin-bottom: 30px;
        }

        .product-slider-text-wrapper__text .description {
            margin-bottom: 10px;
        }

        .product-widget-wrapper--element {
            margin-bottom: -50px;
        }

        .single-product-widget-wrapper {
            margin-bottom: 50px;
        }

        .group-map-container {
            flex-direction: column;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
        }

        .single-map {
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .footer-newsletter-text {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 25px;
            font-weight: 700;
            line-height: 30px;
            margin-bottom: 15px;
            color: #fff;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .footer-newsletter-form {
            margin: 0 auto;
        }

        .progress-bar-element__image {
            margin-bottom: 30px;
        }

        .about-us-brief-title {
            margin-bottom: 30px;
        }

        .video-background-area .video-area {
            height: 300px;
        }

        .shop-product-wrap--fullwidth .col-lg-is-6 {
            max-width: 33.33%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 33.33%;
            -ms-flex: 0 0 33.33%;
            flex: 0 0 33.33%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-5 {
            max-width: 33.33%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 33.33%;
            -ms-flex: 0 0 33.33%;
            flex: 0 0 33.33%;
        }

        .grid-view-changer {
            display: none;
        }

        .shop-sidebar-wrapper {
            margin-top: 50px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-text .text-wrapper {
            width: auto;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper {
            flex-direction: column;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper .review-comments {
            margin-bottom: 30px;
            padding-right: 0;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper .review-comment-form {
            padding-left: 0;
            border-left: 0;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .blog-sidebar-wrapper {
            margin-top: 50px;
        }

        .login-form {
            padding: 15px;
        }

        .login-form--extra-space {
            margin-bottom: 50px;
        }

        .cart-table thead {
            display: none;
        }

        .cart-table tr {
            position: relative;
            display: block;
            padding: 30px 0;
            text-align: center;
            border: 1px solid #ededed;
        }

        .cart-table td {
            display: block;
            width: 100% !important;
            margin: 0 auto;
            padding: 0 !important;
            text-align: center;
            border: none;
        }

        .cart-table td.product-name a {
            margin-top: 20px;
        }

        .cart-table td.product-name .product-variation {
            float: none;
            margin-bottom: 10px;
        }

        .cart-table td.product-price {
            margin-bottom: 15px;
        }

        .cart-table td.stock-status {
            margin-bottom: 15px;
        }

        .cart-table td.product-quantity {
            margin-bottom: 20px;
        }

        .cart-table td.product-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            width: auto !important;
        }

        .cart-table td.product-remove a i {
            line-height: 35px;
        }

        .cart-table td.product-remove a {
            width: auto;
            height: auto;
            border: none;
        }

        .coupon-form {
            margin-bottom: 30px;
        }

        .shipping-form {
            margin-bottom: 30px;
        }

    }

    @media only screen and (min-width: 768px) and (max-width: 991px), only screen and (max-width: 767px) {

        .product-slider-wrapper:hover .slick-arrow {
            visibility: visible;
            opacity: 1;
        }

        .product-slider-wrapper:hover .slick-arrow.slick-prev {
            left: -15px;
        }

        .product-slider-wrapper:hover .slick-arrow.slick-next {
            right: -15px;
        }

        .product-slider-wrapper .slick-arrow {
            visibility: visible;
            opacity: 1;
        }

        .product-slider-wrapper .slick-arrow.slick-prev {
            left: -15px;
        }

        .product-slider-wrapper .slick-arrow.slick-next {
            right: -15px;
        }

        .single-grid-product__image .product-hover-icon-wrapper .single-icon {
            visibility: visible;
            -webkit-transform: translateY(0);
            -ms-transform: translateY(0);
            transform: translateY(0);
            opacity: 1;
        }

        .single-grid-product__image .product-hover-icon-wrapper .single-icon--quick-view {
            display: none;
        }

        .single-grid-product__image .product-hover-icon-wrapper .single-icon--add-to-cart {
            width: 100%;
        }

        .single-grid-product__image .product-hover-icon-wrapper .single-icon--compare {
            display: none;
        }

        .single-grid-product--overlay .single-grid-product__image .product-hover-icon-wrapper .single-icon {
            visibility: hidden;
            opacity: 0;
        }

        .single-grid-product--overlay:hover .single-grid-product__image .product-hover-icon-wrapper .single-icon {
            visibility: visible;
            opacity: 1;
        }

        .single-list-product .product-hover-icon-wrapper .single-icon {
            visibility: visible;
            -webkit-transform: translateY(0);
            -ms-transform: translateY(0);
            transform: translateY(0);
            opacity: 1;
        }

        .single-list-product .product-hover-icon-wrapper .single-icon--quick-view {
            display: none;
        }

        .single-list-product .product-hover-icon-wrapper .single-icon--add-to-cart {
            width: 100%;
        }

        .single-list-product .product-hover-icon-wrapper .single-icon--compare {
            display: none;
        }

        .testimonial-content-wrapper .testimonial-image {
            padding-bottom: 60px;
            text-align: center;
            border-right: 0;
            border-bottom: 2px solid #eee;
        }

        .testimonial-content-wrapper .testimonial-image .icon {
            top: auto;
            bottom: -30px;
            left: 50%;
            -webkit-transform: translate(-50%, 0);
            -ms-transform: translate(-50%, 0);
            transform: translate(-50%, 0);
        }

        .testimonial-content-wrapper .testimonial-content {
            padding-top: 60px;
        }

        .mailchimp-form-content .icon {
            top: auto;
            bottom: -30px;
            left: 50%;
            -webkit-transform: translate(-50%, 0);
            -ms-transform: translate(-50%, 0);
            transform: translate(-50%, 0);
        }

        .mailchimp-form-bg {
            height: 600px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top {
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-image {
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-image-bg {
            height: 500px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-text {
            padding: 50px 30px;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

    }

    @media only screen and (min-width: 768px) {

        .cd-items {
            padding: 2em 0 0;
        }

        .cd-item {
            float: left;
            width: 48%;
            margin: 0 4% 2em 0;
        }

        .cd-item:nth-child(2n) {
            margin-right: 0;
        }

    }

    @media only screen and (min-width: 992px) and (max-width: 1199px), only screen and (min-width: 768px) and (max-width: 991px), only screen and (max-width: 767px) {

        .footer-newsletter-widget__form-wrapper input {
            margin-right: 0;
        }

    }

    @media only screen and (min-width: 992px) and (max-width: 1199px) {

        .header-info-wrapper--alt-style .header-logo {
            -webkit-flex-basis: 15%;
            -ms-flex-preferred-size: 15%;
            flex-basis: 15%;
        }

        .header-info-wrapper--alt-style .header-icon-area {
            -webkit-flex-basis: 30%;
            -ms-flex-preferred-size: 30%;
            flex-basis: 30%;
        }

        .header-navigation-wrapper nav > ul > li:last-child .submenu--column-3 {
            -webkit-transform: translate(-600px, 20px);
            -ms-transform: translate(-600px, 20px);
            transform: translate(-600px, 20px);
        }

        .header-navigation-wrapper nav > ul > li:last-child:hover .submenu--column-3 {
            -webkit-transform: translate(-600px, 0);
            -ms-transform: translate(-600px, 0);
            transform: translate(-600px, 0);
        }

        .header-navigation-wrapper nav > ul > li:hover .submenu--home-variation {
            -webkit-transform: translate(-100px, 0);
            -ms-transform: translate(-100px, 0);
            transform: translate(-100px, 0);
        }

        .header-navigation-wrapper nav > ul > li:hover .submenu--column-3 {
            -webkit-transform: translate(-350px, 0);
            -ms-transform: translate(-350px, 0);
            transform: translate(-350px, 0);
        }

        .submenu--home-variation {
            -webkit-transform: translate(-100px, 20px);
            -ms-transform: translate(-100px, 20px);
            transform: translate(-100px, 20px);
        }

        .submenu--column-1 {
            left: -80px;
        }

        .submenu--column-3 {
            -webkit-transform: translate(-350px, 20px);
            -ms-transform: translate(-350px, 20px);
            transform: translate(-350px, 20px);
        }

        .footer-navigation-area {
            padding-bottom: 100px;
        }

        .footer-widget__title {
            margin-top: -5px;
        }

        .d-lg3-none {
            display: none !important;
        }

        .theme-button--banner--two-column {
            padding: 10px 20px;
        }

        .single-banner:hover .single-banner__content p.banner-small-text--end {
            margin-bottom: 15px;
            padding-bottom: 15px;
        }

        .single-two-column-banner__image {
            min-height: 500px;
        }

        .single-two-column-banner__content .content-wrapper {
            width: 95%;
        }

        .single-two-column-banner__content .content-wrapper .image {
            width: 80px;
            margin-right: auto;
            margin-bottom: 10px;
            margin-left: auto;
        }

        .single-two-column-banner__content .content-wrapper .content .title {
            font-size: 25px;
            line-height: 35px;
            margin-bottom: 5px;
        }

        .single-two-column-banner__content .content-wrapper .content .price {
            margin-bottom: 10px;
        }

        .single-two-column-banner__content .content-wrapper .content .description {
            width: 100%;
            margin-bottom: 15px;
        }

        .cta-content-wrapper {
            padding: 60px 30px;
        }

        .cta-content--two .title {
            font-size: 70px;
            line-height: 120px;
            margin-top: -40px;
        }

        .cta-content--two .subtitle {
            width: 80%;
            max-width: 100%;
        }

        .cta-content .title {
            font-size: 30px;
            line-height: 37px;
        }

        .deal-counter-wrapper {
            margin: 0;
            padding: 65px 30px;
        }

        .breadcrumb-wrapper .page-title {
            font-size: 50px;
            line-height: 60px;
            margin-top: -10px;
        }

        .product-slider-text-wrapper {
            margin: 0;
            padding: 65px 30px;
        }

        .single-grid-product__image .product-hover-icon-wrapper {
            padding: 0 10px;
        }

        .quickview-item-info .item-title {
            font-size: 25px;
        }

        .quick-view-other-info .other-info-links a {
            font-size: 14px;
        }

        .single-testimonial__content .testimonial-text {
            width: 800px;
        }

        .testimonial-content-wrapper {
            padding: 60px 0;
        }

        .testimonial-content-wrapper .testimonial-image {
            padding: 0 60px;
        }

        .testimonial-content-wrapper .testimonial-content {
            padding: 0 60px;
        }

        .google-map {
            height: 400px;
        }

        .google-map--style-2 {
            height: 600px;
        }

        .footer-newsletter-text {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 25px;
            font-weight: 700;
            line-height: 30px;
            color: #fff;
        }

        .about-page-top-wrapper {
            margin-top: -5px;
        }

        .video-background-area .video-area {
            height: 500px;
        }

        .sidebar-price input {
            width: 69%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-6 {
            max-width: 25%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 25%;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-5 {
            max-width: 25%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 25%;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-text .text-wrapper {
            width: auto;
        }

        .product-details-description-wrapper .item-title {
            font-size: 25px;
        }

    }

    @media only screen and (min-width: 992px) {

        body.overlay-layer::after {
            visibility: visible;
            content: '';
            -webkit-transition: opacity .3s 0s, visibility 0s 0s;
            transition: opacity .3s 0s, visibility 0s 0s;
            opacity: 1;
        }

        .cd-items {
            padding: 4em 0 0;
        }

        .cd-item {
            float: left;
            width: 22%;
            margin: 0 4% 2.8em 0;
        }

        .cd-item:nth-child(2n) {
            margin-right: 4%;
        }

        .cd-item:nth-child(4n) {
            margin-right: 0;
        }

        .cd-item.empty-box::after { /* box visible as placeholder when the .cd-quick-view zooms in */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #392c3f;
        }

        .cd-quick-view {
            position: fixed;
            z-index: 1;
            display: block;
            visibility: hidden;
            max-width: 900px; /* Force Hardware Acceleration in WebKit */
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            will-change: left, top, width;
        }

        .cd-quick-view.is-visible { /* class added when user clicks on .cd-trigger */
            visibility: visible;
        }

        .cd-quick-view.animate-width { /* class added at the end of the first zoom-in animation */
            background-color: #fff;
            -webkit-box-shadow: 0 0 30px rgba(0, 0, 0, .2);
            box-shadow: 0 0 30px rgba(0, 0, 0, .2);
        }

    }

    @media (min-width: 1200px) {

        .container {
            max-width: 1200px;
        }

        .container.wide {
            max-width: 95%;
        }

        .container.full {
            max-width: 100%;
            padding: 0;
        }

    }

    @media only screen and (min-width: 1200px) and (max-width: 1499px) {

        .header-info-wrapper--alt-style .header-logo {
            -webkit-flex-basis: 15%;
            -ms-flex-preferred-size: 15%;
            flex-basis: 15%;
        }

        .header-info-wrapper--alt-style .header-icon-area {
            -webkit-flex-basis: 30%;
            -ms-flex-preferred-size: 30%;
            flex-basis: 30%;
        }

        .header-navigation-wrapper nav > ul > li:last-child .submenu--column-3 {
            -webkit-transform: translate(-500px, 20px);
            -ms-transform: translate(-500px, 20px);
            transform: translate(-500px, 20px);
        }

        .header-navigation-wrapper nav > ul > li:last-child:hover .submenu--column-3 {
            -webkit-transform: translate(-500px, 0);
            -ms-transform: translate(-500px, 0);
            transform: translate(-500px, 0);
        }

        .header-navigation-wrapper nav > ul > li:hover .submenu--column-3 {
            -webkit-transform: translate(-250px, 0);
            -ms-transform: translate(-250px, 0);
            transform: translate(-250px, 0);
        }

        .submenu--column-3 {
            -webkit-transform: translate(-250px, 20px);
            -ms-transform: translate(-250px, 20px);
            transform: translate(-250px, 20px);
        }

        .footer-navigation-area {
            padding-bottom: 100px;
        }

        .footer-widget__title {
            margin-top: -5px;
        }

        .col-custom-xl-6 {
            max-width: 50%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 50%;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }

        .d-lg2-none {
            display: none !important;
        }

        .theme-button--banner--two-column {
            padding: 10px 20px;
        }

        .single-two-column-banner__image {
            min-height: 500px;
        }

        .single-two-column-banner__content .content-wrapper {
            width: 95%;
        }

        .single-two-column-banner__content .content-wrapper .image {
            width: 100px;
            margin-right: auto;
            margin-bottom: 10px;
            margin-left: auto;
        }

        .single-two-column-banner__content .content-wrapper .content .title {
            font-size: 30px;
            line-height: 40px;
            margin-bottom: 10px;
        }

        .single-two-column-banner__content .content-wrapper .content .price {
            margin-bottom: 10px;
        }

        .single-two-column-banner__content .content-wrapper .content .description {
            width: 480px;
            margin-bottom: 15px;
        }

        .deal-counter-wrapper__image {
            text-align: left;
        }

        .deal-counter-wrapper {
            margin: 0;
        }

        .breadcrumb-wrapper .page-title {
            font-size: 50px;
            line-height: 60px;
            margin-top: -10px;
        }

        .theme-slick-slider .slick-arrow.slick-next {
            right: 0;
        }

        .theme-slick-slider .slick-arrow.slick-prev {
            left: 0;
        }

        .theme-slick-slider:hover .slick-arrow.slick-next {
            right: 0;
        }

        .theme-slick-slider:hover .slick-arrow.slick-prev {
            left: 0;
        }

        .product-slider-text-wrapper {
            margin: 0;
            padding: 65px 70px;
        }

        .single-testimonial__content .testimonial-text {
            width: 800px;
        }

        .google-map--style-3 {
            height: 300px;
        }

        .video-background-area .video-area {
            height: 600px;
        }

        .sidebar-price input {
            width: 69%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-6 {
            max-width: 25%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 25%;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-5 {
            max-width: 25%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 25%;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-text .text-wrapper {
            width: auto;
        }

    }

    @media only screen and (min-width: 1200px) and (max-width: 1499px), only screen and (min-width: 992px) and (max-width: 1199px) {

        .submenu--home-variation {
            padding: 40px 30px;
        }

        .submenu--home-variation__item:nth-child(1n+4) {
            margin-top: 15px;
        }

    }

    @media only screen and (min-width: 1200px) and (min-width: 1200px) and (max-width: 1499px) {

        .container.wide {
            max-width: 100%;
        }

    }

    @media (min-width: 1500px) {

        .product-row-wrapper .col-xl-custom-2 {
            max-width: 16.66667%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 16.66667%;
            -ms-flex: 0 0 16.66667%;
            flex: 0 0 16.66667%;
        }

        .product-fullpage-no-gutter-area .col-xl-custom-2 {
            max-width: 16.66667%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 16.66667%;
            -ms-flex: 0 0 16.66667%;
            flex: 0 0 16.66667%;
        }

    }

    @media only screen and (max-width: 767px) {

        .header-sticky.is-sticky .header-icon__list__item > a {
            padding: 0;
        }

        .header-sticky.is-sticky .header-icon__list__item > a span.item-count {
            top: -10px;
        }

        .minicart-wrapper {
            display: none;
        }

        .footer-navigation-area {
            padding-top: 70px;
            padding-bottom: 70px;
        }

        .copyright-text--two {
            margin-bottom: 20px;
        }

        .footer-newsletter-widget__title {
            font-size: 32px;
            line-height: 35px;
        }

        .theme-button--banner--scale {
            border: none;
        }

        .theme-button--banner--scale:hover {
            color: #222;
            border-color: transparent;
            background: none;
        }

        .theme-button--extra-large {
            font-size: 18px;
            padding: 15px 40px;
        }

        .search-overlay .search-close-icon a i {
            font-size: 25px;
        }

        .search-overlay .search-overlay-content .input-box form input {
            font-size: 40px;
        }

        .section-title {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 28px;
            font-weight: 700;
            line-height: 55px;
            color: #000;
        }

        .single-banner__image:after {
            display: none;
        }

        .single-banner__content {
            display: none;
        }

        .single-banner--scale__image:after {
            visibility: visible;
            opacity: 1;
        }

        .single-banner--scale__content {
            left: 50%;
            width: 90%;
            max-width: 100%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .single-banner--scale__content .title {
            font-size: 24px;
            line-height: 24px;
        }

        .single-banner--scale__content .subtitle {
            margin-bottom: 5px;
        }

        .single-two-column-banner__image {
            min-height: 400px;
            margin-bottom: 30px;
        }

        .single-two-column-banner__content {
            padding: 60px 0;
        }

        .single-two-column-banner__content .content-wrapper {
            width: 90%;
        }

        .single-two-column-banner__content .content-wrapper .image {
            margin-bottom: 10px;
        }

        .single-two-column-banner__content .content-wrapper .content .title {
            font-size: 25px;
            line-height: 35px;
            margin-bottom: 5px;
        }

        .single-two-column-banner__content .content-wrapper .content .description {
            width: 100%;
            margin-bottom: 15px;
        }

        .single-banner-segment__image {
            margin-bottom: 35px;
        }

        .section-space--breadcrumb {
            padding-top: 100px;
            padding-bottom: 100px;
        }

        .cta-area--three .cta-text {
            margin-top: -5px;
            margin-bottom: 25px;
        }

        .cta-content-wrapper {
            padding: 60px 30px;
        }

        .cta-content--two .title {
            font-size: 45px;
            line-height: 70px;
            margin-top: -20px;
        }

        .cta-content--two .subtitle {
            font-size: 16px;
            line-height: 26px;
            width: 100%;
            max-width: 100%;
        }

        .cta-content .title {
            font-size: 30px;
            line-height: 37px;
        }

        .deal-counter-wrapper__image {
            margin-bottom: 40px;
        }

        .deal-counter-wrapper {
            margin: 0;
        }

        .deal-counter-wrapper__content {
            padding: 0 30px;
        }

        .instagram-grid .col {
            width: 50%;
        }

        .breadcrumb-wrapper {
            margin-bottom: 0;
        }

        .breadcrumb-wrapper .page-title {
            font-size: 40px;
            line-height: 50px;
            margin-top: -10px;
        }

        .theme-slick-slider .slick-arrow {
            visibility: visible;
            opacity: .6;
        }

        .product-slider-text-wrapper {
            margin: 0;
            padding: 65px 30px;
        }

        .product-slider-text-wrapper__text {
            margin-bottom: 30px;
        }

        .product-slider-text-wrapper__text .title {
            font-size: 28px;
            line-height: 31px;
        }

        .product-slider-text-wrapper__text .description {
            margin-bottom: 10px;
        }

        .product-widget-wrapper--element {
            margin-bottom: -50px;
        }

        .single-product-widget-wrapper {
            margin-bottom: 50px;
        }

        .single-list-product__image {
            -webkit-flex-basis: 40%;
            -ms-flex-preferred-size: 40%;
            flex-basis: 40%;
        }

        .single-list-product__content {
            -webkit-flex-basis: 60%;
            -ms-flex-preferred-size: 60%;
            flex-basis: 60%;
        }

        .group-map-container {
            flex-direction: column;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
        }

        .single-map {
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .footer-newsletter-text {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 25px;
            font-weight: 700;
            line-height: 30px;
            margin-bottom: 15px;
            color: #fff;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .footer-newsletter-form {
            margin: 0 auto;
        }

        .mailchimp-form-content .mailchimp-form-wrapper {
            padding: 60px 15px;
            border: 0;
        }

        .progress-bar-element__image {
            margin-bottom: 30px;
        }

        .about-us-brief-title {
            margin-bottom: 30px;
        }

        .video-background-area .video-area {
            height: 300px;
        }

        .contact-form-content {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .view-mode-icons {
            display: none !important;
        }

        .shop-product-wrap--fullwidth .col-lg-is-6 {
            max-width: 50%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 50%;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-5 {
            max-width: 50%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 50%;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
        }

        .grid-view-changer {
            display: none;
        }

        .shop-sidebar-wrapper {
            margin-top: 50px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-text .text-wrapper {
            width: auto;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__bottom {
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__bottom .single-block-image {
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper {
            flex-direction: column;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper .review-comments {
            margin-bottom: 30px;
            padding-right: 0;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper .review-comment-form {
            padding-left: 0;
            border-left: 0;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .product-details-big-image-slider-wrapper--side-space {
            margin-bottom: 15px;
        }

        .product-details-small-image-slider-wrapper--vertical-space .single-image {
            padding: 0 5px;
        }

        .blog-sidebar-wrapper {
            margin-top: 50px;
        }

        .login-form--extra-space {
            margin-bottom: 50px;
        }

        .forget-pass-link {
            margin-bottom: 15px;
        }

        .cart-table thead {
            display: none;
        }

        .cart-table tr {
            position: relative;
            display: block;
            padding: 30px 0;
            text-align: center;
            border: 1px solid #ededed;
        }

        .cart-table td {
            display: block;
            width: 100% !important;
            margin: 0 auto;
            padding: 0 !important;
            text-align: center;
            border: none;
        }

        .cart-table td.product-name a {
            margin-top: 20px;
        }

        .cart-table td.product-name .product-variation {
            float: none;
            margin-bottom: 10px;
        }

        .cart-table td.product-price {
            margin-bottom: 15px;
        }

        .cart-table td.stock-status {
            margin-bottom: 15px;
        }

        .cart-table td.product-quantity {
            margin-bottom: 20px;
        }

        .cart-table td.product-remove {
            position: absolute;
            top: 0;
            right: 10px;
            width: auto !important;
        }

        .cart-table td.product-remove a i {
            line-height: 35px;
        }

        .cart-table td.product-remove a {
            width: auto;
            height: auto;
            border: none;
        }

        .coupon-form {
            margin-bottom: 30px;
        }

        .shipping-form {
            margin-bottom: 30px;
        }

    }

    @media only screen and (max-width: 575px) {

        .footer-newsletter-widget__title {
            font-size: 28px;
            line-height: 32px;
        }

        .search-overlay .search-overlay-content .input-box form input {
            font-size: 30px;
        }

        .cta-content--two .title {
            font-size: 40px;
            line-height: 60px;
            margin-top: -15px;
        }

        .deal-counter-wrapper__content .deal-countdown .single-countdown {
            width: 25%;
            padding: 10px;
        }

        .product-slider-wrapper:hover .slick-arrow.slick-prev {
            left: 0;
        }

        .product-slider-wrapper:hover .slick-arrow.slick-next {
            right: 0;
        }

        .product-slider-wrapper .slick-arrow.slick-prev {
            left: 0;
        }

        .product-slider-wrapper .slick-arrow.slick-next {
            right: 0;
        }

        .product-slider-text-wrapper .product-slider-wrapper .slick-arrow.slick-next {
            margin-right: -15px;
        }

        .product-slider-text-wrapper .product-slider-wrapper .slick-arrow.slick-prev {
            margin-left: -15px;
        }

        .single-list-product {
            flex-direction: column;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
        }

        .single-list-product__image {
            margin-bottom: 15px;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .single-list-product__content {
            padding-left: 0;
            -webkit-flex-basis: 100%;
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
        }

        .single-list-product .product-hover-icon-wrapper {
            margin: 0 auto;
        }

        .product-double-row-tab-wrapper .tab-product-navigation .nav-tabs .nav-item {
            font-size: 22px;
            line-height: 22px;
            margin: 0 15px;
        }

        .testimonial-content-wrapper .testimonial-image {
            padding: 0 30px;
            padding-bottom: 60px;
        }

        .testimonial-content-wrapper .testimonial-content {
            padding: 0 30px;
            padding-top: 60px;
        }

        .faq-title {
            font-size: 25px;
            line-height: 32px;
        }

        .single-faq .card-header h5 button {
            font-size: 18px;
            line-height: 26px;
        }

        .single-team-member {
            text-align: center;
        }

        .shop-product-wrap--fullwidth .col-lg-is-6 {
            max-width: 100%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 100%;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
        }

        .shop-product-wrap--fullwidth .col-lg-is-5 {
            max-width: 100%;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 100%;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
        }

        .sort-by-dropdown {
            margin-left: 0;
        }

        .sort-by-dropdown .nice-select {
            padding-left: 0;
        }

        .sort-by-dropdown .nice-select .list {
            right: auto;
            left: 0;
        }

        .description-tab-navigation .nav-tabs .nav-link {
            margin: 0 10px;
        }

        .blog-single-post-details-wrapper .post-title {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 25px;
            font-weight: 600;
            line-height: 35px;
            color: #111;
        }

        .order-tracking-wrapper {
            padding: 60px 30px;
        }

        .coupon-form input {
            margin-bottom: 15px;
        }

        .checkout-cart-total {
            padding: 30px;
        }

        .checkout-payment-method {
            padding: 30px;
        }

    }

    @media only screen and (max-width: 479px) {

        .offcanvas-widget-area {
            margin-bottom: 30px;
        }

        .offcanvas-mobile-menu {
            width: 300px;
        }

        .offcanvas-menu-close {
            font-size: 25px;
            line-height: 55px;
            left: 10px;
            width: 50px;
            height: 50px;
        }

        .offcanvas-mobile-search-area input {
            font-size: 14px;
            padding: 5px 15px;
        }

        .offcanvas-inner-content {
            padding: 70px 25px 0;
        }

        .offcanvas-naviagtion > ul > li > a {
            font-size: 16px;
            line-height: 20px;
        }

        .offcanvas-naviagtion ul.sub-menu > li > a {
            font-size: 14px;
            line-height: 18px;
        }

        .off-canvas-widget-social a {
            margin: 0 10px;
        }

        .footer-widget__newsletter-form {
            width: 100%;
        }

        .footer-widget__newsletter-form input {
            padding-right: 120px;
        }

        .footer-widget__newsletter-form button {
            font-size: 13px;
            padding: 0 10px;
        }

        .footer-newsletter-widget__title {
            font-size: 25px;
            line-height: 30px;
        }

        .theme-button--subscribe {
            font-size: 14px;
            padding: 8px 16px;
        }

        .theme-button--loadmore {
            font-size: 14px;
            padding: 8px 16px;
        }

        .theme-button--banner {
            font-size: 12px;
            padding: 5px 15px;
        }

        .theme-button--deal-counter {
            font-size: 14px;
            padding: 10px 20px;
        }

        .search-overlay .search-overlay-content .input-box form input {
            font-size: 20px;
        }

        .section-title {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 25px;
            font-weight: 700;
            line-height: 50px;
            padding-bottom: 10px;
            color: #000;
        }

        .section-title:after {
            width: 80px;
        }

        .single-banner__content--overlay p.banner-big-text {
            font-size: 22px;
        }

        .single-banner:hover .single-banner__content p.banner-small-text--end {
            margin-bottom: 10px;
            padding-bottom: 10px;
        }

        .cta-area--three .cta-text {
            font-size: 30px;
            line-height: 35px;
        }

        .cta-content--two .title {
            font-size: 28px;
            line-height: 40px;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .cta-content--two .subtitle {
            font-size: 16px;
            line-height: 22px;
        }

        .cta-content .title {
            font-size: 22px;
            line-height: 29px;
        }

        .deal-counter-wrapper__image {
            width: 90%;
            margin: 0 auto;
            margin-bottom: 30px;
        }

        .deal-counter-wrapper__content {
            padding: 0 10px;
        }

        .deal-counter-wrapper__content .title {
            font-size: 22px;
            line-height: 27px;
            margin-bottom: 15px;
        }

        .deal-counter-wrapper__content .description {
            margin-bottom: 15px;
        }

        .deal-counter-wrapper__content .deal-countdown {
            margin-bottom: 15px;
        }

        .deal-counter-wrapper__content .deal-countdown .single-countdown {
            width: 25%;
            padding: 10px 0;
            text-align: left;
            border: none;
        }

        .deal-counter-wrapper__content .deal-countdown .single-countdown:first-child {
            border: none;
        }

        .deal-counter-wrapper__content .deal-countdown .single-countdown__time {
            font-size: 25px;
            line-height: 30px;
        }

        .deal-counter-wrapper__content .deal-countdown .single-countdown__text {
            font-size: 14px;
            line-height: 14px;
        }

        .instagram-grid .col {
            width: 100%;
        }

        .breadcrumb-wrapper .page-title {
            font-size: 33px;
            line-height: 40px;
            margin-top: -5px;
        }

        .product-slider-text-wrapper {
            padding: 65px 15px;
        }

        .product-double-row-tab-wrapper .tab-product-navigation .nav-tabs {
            margin-bottom: 30px;
        }

        .product-double-row-tab-wrapper .tab-product-navigation .nav-tabs .nav-item {
            font-size: 20px;
            font-weight: 600;
            line-height: 20px;
            margin: 0 5px;
            padding-bottom: 10px;
        }

        .quick-view-other-info .other-info-links a {
            font-size: 15px;
        }

        .google-map {
            height: 300px;
        }

        .footer-newsletter-text {
            font-size: 20px;
            letter-spacing: 1px;
        }

        .mailchimp-form-content {
            padding: 30px 15px;
        }

        .mailchimp-form-content .mailchimp-form-wrapper {
            padding: 60px 0;
        }

        .mailchimp-form-bg {
            height: 400px;
        }

        .about-us-brief-title {
            font-size: 30px;
            line-height: 40px;
        }

        .single-service-text .title span {
            font-size: 70px;
            line-height: 76px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .description-content--extra__top .single-block-text p.big-text {
            font-size: 30px;
            line-height: 34px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper .review-comments .single-review-comment__content .review-time {
            margin-bottom: 5px;
        }

        .single-product-description-tab-content .tab-content .tab-pane .review-content-wrapper .review-comments .single-review-comment__content .rating {
            position: static;
        }

        .blog-comments-area .blog-comments-wrapper .single-blog-comment {
            margin-left: 40px;
            padding-left: 35px;
        }

        .blog-comments-area .blog-comments-wrapper .single-blog-comment__image {
            left: -30px;
            width: 60px;
            height: 60px;
        }

        .blog-comments-area .blog-comments-wrapper .single-blog-comment__content .comment-time {
            margin-bottom: 5px;
        }

        .blog-comments-area .blog-comments-wrapper .single-blog-comment--reply {
            margin-left: 70px;
        }

        .order-tracking-wrapper {
            padding: 40px 15px;
        }

    }


</style>
