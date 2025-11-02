<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$allowModalPaymentez = false;

?>
<?php

$managerNamePayPal = 'sandbox';
$managerNamePaymente = 'sandbox';

$allowPaymentsData = [];
$allowPayPal = false;
$configPayments = [
    'api-credit-cards' => [
        'env' => 'stg',
        'id' => '',
        'secret' => '',
        'managerTypeModal' => false,
        'allow' => false,


    ],
    'pay-pal' => [
        'env' => 'stg',
        'id' => '',
        'secret' => '',
        'managerTypeModal' => false,
        'allow' => false,
    ],

];
if ($dataManagerPage['shopConfig']['allow']) {

    if ($dataManagerPage['shopConfig']['data']['pay-pal'] != false) {
        $managerNamePayPal = $dataManagerPage['shopConfig']['data']['pay-pal']->type_manager == 1 ? 'production' : 'sandbox';
        $id = $dataManagerPage['shopConfig']['data']['pay-pal']->type_manager == 1 ? $dataManagerPage['shopConfig']['data']['pay-pal']->live_id : $dataManagerPage['shopConfig']['data']['pay-pal']->test_id;
        $secret = $dataManagerPage['shopConfig']['data']['pay-pal']->type_manager == 1 ? $dataManagerPage['shopConfig']['data']['pay-pal']->live_secret : $dataManagerPage['shopConfig']['data']['pay-pal']->test_secret;
        $manager_type_modal = $dataManagerPage['shopConfig']['data']['pay-pal']->manager_type_modal == 1 ? true : false;
        $allowPaymentsData['pay-pal'] = true;
        $configPayments['pay-pal'] = [
            'env' => $managerNamePayPal,
            'id' => $id,
            'secret' => $secret,
            'allow' => true,
            'managerTypeModal' => $manager_type_modal,
            'messages' => [
                'onAuthorize' => [
                    'success' => __('checkout.paypal.on-authorize.success')
                ],
                'onError' => [
                    'error' => __('checkout.paypal.on-authorize.error')


                ],

            ]
        ];
    }
    if ($dataManagerPage['shopConfig']['data']['bank-deposit'] != false) {
        $allowPaymentsData['bank-deposit'] = true;

    }
    if ($dataManagerPage['shopConfig']['data']['api-credit-cards'] != false) {
        $allowPaymentsData['api-credit-cards'] = true;
        $manager_type_modal = $dataManagerPage['shopConfig']['data']['api-credit-cards']->manager_type_modal == 1 ? true : false;
        $managerNamePayPal = $dataManagerPage['shopConfig']['data']['api-credit-cards']->type_manager == 1 ? 'prod' : 'stg';
        $id = $dataManagerPage['shopConfig']['data']['api-credit-cards']->live_id;
        $secret = $dataManagerPage['shopConfig']['data']['api-credit-cards']->live_secret;
        $configPayments['api-credit-cards'] = [
            'env' => $managerNamePayPal,
            'id' => $id,
            'secret' => $secret,
            'allow' => true,
            'managerTypeModal' => $manager_type_modal
        ];
        $allowModalPaymentez = $manager_type_modal;
    }
}


?>
@extends('layouts.frontend')
@section('additional-styles')
    <link href="{{ URL::asset($resourcePathServer.'libs/toast/jquery.toast.min.css') }}" rel="stylesheet"
          type="text/css">
    <style>

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


    </style>
    <link rel="stylesheet" href="{{asset($resourcePathServer.'frontend/assets/css/web/Customers.css')}}">

    @if($dataManagerPage['shopConfig']['allow'] &&  $dataManagerPage['shopConfig']['data']['api-credit-cards']!=false)
        @if(!$allowModalPaymentez)
            @if(  $dataManagerPage['shopConfig']['data']['pay-pal']->type_manager == 1)
                <link href="https://cdn.paymentez.com/js/1.0.1/paymentez.min.css" rel="stylesheet" type="text/css"/>
            @else
                <link href="https://cdn.paymentez.com/js/ccapi/stg/paymentez.min.css" rel="stylesheet" type="text/css"/>
            @endif
        @endif

    @endif

@endsection

@section('additional-scripts')
    <script src="{{ asset($resourcePathServer.'js/Utils.js')}}" type='text/javascript'></script>

    <script>

        function managerCheckoutDetails(params) {
            var dataResponse = params['data'];
            var ManagerCheckout = dataResponse['ManagerCheckout'];
            var OrderShoppingCart = ManagerCheckout['OrderShoppingCart'];
            var checkoutId = OrderShoppingCart['id'];
            var locationCheckout = "{{ route("checkoutDetails", app()->getLocale()) }}" + '/' + checkoutId + '/true';
            $(location).attr('href', locationCheckout);
        }

        var $dataCountriesManager = <?php echo json_encode(isset($dataManagerPage['dataCountriesManager']) ? $dataManagerPage['dataCountriesManager'] : [])?>;
        var $formConfig = {
            "payment_bank": "{{__('checkout.form.payment_bank')}}",
            "payment_payoneer": "{{__('checkout.form.payment_payoneer')}}",
            "payment_paypal": "{{__('checkout.form.payment_paypal')}}",
            "first_name": "{{__('checkout.form.first_name')}}",
            "last_name": "{{__('checkout.form.last_name')}}",
            "payer_email": "{{__('checkout.form.payer_email')}}",
            "phone": "{{__('checkout.form.phone')}}",
            "company": "{{__('checkout.form.company')}}",
            "address_main": "{{__('checkout.form.address_main')}}",
            "address_secondary": "{{__('checkout.form.address_secondary')}}",
            "state_province_id": "{{__('checkout.form.state_province_id')}}",
            "city": "{{__('checkout.form.city')}}",
            "zipcode": "{{__('checkout.form.zipcode')}}",
            "document": "{{__('checkout.form.document')}}",


            "billing_first_name": "{{__('checkout.form.billing_first_name')}}",
            "billing_last_name": "{{__('checkout.form.billing_last_name')}}",
            "billing_payer_email": "{{__('checkout.form.billing_payer_email')}}",
            "billing_phone": "{{__('checkout.form.billing_phone')}}",
            "billing_company": "{{__('checkout.form.billing_company')}}",
            "billing_address_main": "{{__('checkout.form.billing_address_main')}}",
            "billing_address_secondary": "{{__('checkout.form.billing_address_secondary')}}",
            "billing_state_province_id": "{{__('checkout.form.billing_state_province_id')}}",
            "billing_city": "{{__('checkout.form.billing_city')}}",
            "billing_zipcode": "{{__('checkout.form.billing_zipcode')}}",
            "billing_document": "{{__('checkout.form.billing_document')}}",
            create_account: "{{__('checkout.form.create-account')}}",
            //user create account
            email: "{{__('checkout.form.create-account.email')}}",
            //other address
            same_billing_address: "{{__('checkout.form.same_billing_address')}}",
        };
        var $configPayments = <?php echo json_encode($configPayments)?>;
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined')?>;
        var $allowPaymentsData = <?php echo json_encode($allowPaymentsData)?>;
        var $customerData = <?php echo json_encode($dataManagerPage['profileConfig']['success'] ? [
            'Customer' => [
                'manager_id' => $dataManagerPage['profileConfig']['data']['user']->id,
                'first_name' => isset($dataManagerPage['profileConfig']['data']['Profile']->first_name) ? $dataManagerPage['profileConfig']['data']['Profile']->first_name : '',
                'payer_email' => isset($dataManagerPage['profileConfig']['data']['Profile']->email) ? $dataManagerPage['profileConfig']['data']['Profile']->email : $dataManagerPage['profileConfig']['data']['user']->email,
                'last_name' => isset($dataManagerPage['profileConfig']['data']['Profile']->last_name) ? $dataManagerPage['profileConfig']['data']['Profile']->last_name : ''
            ]
        ] : []) ?>;
        var $managerUtils = {};
        var $utilCustomer = null;

    </script>
    <script src="{{ asset($resourcePathServer.'libs/vue/axios/axios.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>
    <script type="module">
        import * as UtilPaymentez
            from '{{ asset($resourcePathServer.'js/frontend/web/utils/Paymentez.js')}}'

        $managerUtils['UtilPaymentez'] = UtilPaymentez;
        import UtilCustomer
            from '{{ asset($resourcePathServer.'js/frontend/web/utils/Customer.js')}}'

        $managerUtils['UtilCustomer'] = UtilCustomer;
    </script>


    @if($dataManagerPage['shopConfig']['allow'] && $dataManagerPage['shopConfig']['data']['pay-pal']!=false)
        <script src="{{ asset($resourcePathServer.'js/frontend/web/utils/PaypalEvents.js')}}"></script>
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    @endif
    @if($dataManagerPage['shopConfig']['allow'] && $dataManagerPage['shopConfig']['data']['api-credit-cards']!=false)
        @if($allowModalPaymentez)
            <script src="https://cdn.paymentez.com/checkout/1.0.1/paymentez-checkout.min.js"></script>
        @else
            @if(  $dataManagerPage['shopConfig']['data']['pay-pal']->type_manager == 1)
                <script src="https://cdn.paymentez.com/js/1.0.1/paymentez.min.js" charset="UTF-8"></script>
            @else
                <script src="https://cdn.paymentez.com/js/ccapi/stg/paymentez.min.js" charset="UTF-8"></script>
            @endif
        @endif
    @endif

    <script>


        @if($dataManagerPage['shopConfig']['allow'] && $dataManagerPage['shopConfig']['data']['api-credit-cards'])

        @if(!$allowModalPaymentez)
        Paymentez.init($configPayments['api-credit-cards']['env'], $configPayments['api-credit-cards']['id'], $configPayments['api-credit-cards']['code']);

        @endif

        @endif


    </script>

    <script src="{{ asset($resourcePathServer.'js/frontend/web/CheckoutEvent.js')}}"></script>



@endsection
@section('content')
    <input id="action-users-emailUniqueCheckout" type="hidden"
           value="{{ action("Auth\ApiLoginController@getEmailUniqueCheckout") }}"/>

    <div class="breadcrumb-area section-space--breadcrumb section-space--manager-sisdep">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <!--=======  breadcrumb wrapper  =======-->

                    <div class="breadcrumb-wrapper">
                        <h2 class="page-title">
                            @if(isset($dataManagerPage['header']['title']))
                                {{$dataManagerPage['header']['title']}}
                            @endif
                        </h2>
                        <ul class="breadcrumb-list">
                            {!! $dataManagerPage['header']['breadCrumb']['inactive'] !!}
                            <li class="active">
                                @if(isset($dataManagerPage['header']['breadCrumb']['active']))
                                    {{$dataManagerPage['header']['breadCrumb']['active']}}
                                @endif


                            </li>
                        </ul>
                    </div>

                    <!--=======  End of breadcrumb wrapper  =======-->
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper" id='app-management'>
        <div class="checkout-page-wrapper">
            <div class="container--checkout">
                @if($dataManagerPage['shopConfig']['allow'])
                    <div class="not-view" id="manager-shop-products">

                        <b-form id="checkout-form" @submit="_submitForm">
                            <div class="row">
                                <!-- Checkout Form s-->
                                <input id="shop-subtotal" type="hidden" name="OrderShopping[subtotal]">
                                <input id="shop-description" type="hidden" name="OrderShopping[description]">
                                <input id="shop-shipping" type="hidden" name="OrderShopping[shipping]">
                                <input id="shop-data" type="hidden" name="OrderBillingDetails[data]">
                                <div class="col-lg-4 col-md-4 col-sm-12  mb-2 mb-lg-0">
                                    @include('frontend.web.checkoutSteps.step1',array())

                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-2 mb-lg-0">
                                    @include('frontend.web.checkoutSteps.step2',array())

                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12  mb-2 mb-sm-0">
                                    @include('frontend.web.checkoutSteps.step3',array())

                                </div>
                            </div>
                        </b-form>
                        <div class="row">
                            @include('frontend.web.checkoutSteps.buttons-manager',array())

                        </div>


                    </div>
                @endif
                <div class="row">
                    <div class="empty-data not-view col-md-12" id="empty-products">

                        {{__('messages.empty')}}
                    </div>
                    <div class="empty-data  col-md-12" id="empty-products-loading">
                        {{__('messages.loading')}}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
