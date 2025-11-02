<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$themePath = $resourcePathServer . 'templates/eatPura/';
$assetsRoot = $resourcePathServer . 'assets/backline/';
$urlCurrentSearch = route('search', app()->getLocale());
$sourceNotPayment = URL::asset($resourcePathServer . 'frontend/meetclic/notPayment/empty.png');
$sourceSuccess = URL::asset($themePath . 'img/successfull.png');
$sourceSuccessOther = URL::asset($themePath);
$activeCreditCards = '';
$activePayPal = '';
$activeBankDeposit = '';
$activeCreditCardsContent = '';
$activePayPalShowContent = '';
$activeBankDepositContent = '';

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


    $shopConfigData = $dataManagerPage['shopConfig']["data"];

    // Contamos cuántos métodos de pago están disponibles
    $availableMethods = [
        'creditCards' => $shopConfigData["api-credit-cards"] !== null,
        'payPal' => $shopConfigData["pay-pal"] !== null,
        'bankDeposit' => $shopConfigData["bank-deposit"] !== null
    ];


    // Verificamos la cantidad de métodos disponibles
    $availableCount = array_sum($availableMethods);

    // Activamos el método de pago según la disponibilidad y prioridad
    if ($availableCount === 1) {
        // Si solo uno está disponible, activamos el correspondiente
        if ($availableMethods['creditCards']) {
            $activeCreditCards = 'active';
            $activeCreditCardsContent = 'active show';

        } elseif ($availableMethods['payPal']) {
            $activePayPal = 'active';
            $activePayPalShowContent = 'active show';

        } elseif ($availableMethods['bankDeposit']) {
            $activeBankDeposit = 'active';
            $activeBankDepositContent = 'active show';

        }
    } elseif ($availableCount > 1) {
        // Si hay más de uno disponible, activamos uno con prioridad
        if ($availableMethods['creditCards']) {
            $activeCreditCards = 'active'; // Prioridad 1
            $activeCreditCardsContent = 'active show';

        } elseif ($availableMethods['payPal']) {
            $activePayPal = 'active'; // Prioridad 2
            $activePayPalShowContent = 'active show';

        } elseif ($availableMethods['bankDeposit']) {
            $activeBankDeposit = 'active'; // Prioridad 3
            $activeBankDepositContent = 'active show';

        }
    } else {
        // Si ninguno está disponible, mostramos un mensaje de error
        echo "Error: No hay métodos de pago disponibles.";
    }

} else {


}


?>
@extends('layouts.eatPura')
@section('additional-styles')
    <style>
        #limit-data {
            height: 10px;
        }


        /* Estilos generales para la imagen */
        .img-full-manager {
            width: 100%; /* Hace que la imagen ocupe el 100% del ancho disponible */
            height: 100%; /* Hace que la imagen ocupe el 100% del alto disponible */
            object-fit: cover; /* Asegura que la imagen cubra todo el espacio sin distorsionarse */
            display: block; /* Elimina el espacio debajo de la imagen (por defecto) */
            margin: 0; /* Elimina márgenes */
            padding: 0; /* Elimina rellenos */
        }

        /* Asegurando que el body ocupe todo el espacio */
        .content-all {
            height: 100%; /* Asegura que el body y html ocupen el 100% de la altura de la pantalla */
            margin: 0; /* Elimina márgenes predeterminados */
            padding: 0; /* Elimina rellenos */
            overflow: hidden; /* Evita el scroll si la imagen es mayor que el tamaño de la ventana */
        }

        /* Media Queries para diferentes dispositivos */
        @media (max-width: 768px) {
            /* Para dispositivos móviles (orientación vertical y horizontal) */
            .img-full-manager {
                object-fit: cover;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            /* Para tablets (horizontal y vertical) */
            .img-full-manager {
                object-fit: cover;
            }
        }

        @media (min-width: 1025px) {
            /* Para pantallas grandes (escritorios) */
            .img-full-manager {
                object-fit: cover;
            }
        }

        /* VALIDATION  */
        .form-group__input {
            padding: 6% 6% 2.5% 5%;
            transition: border-color .25s ease-in-out;
            color: rgb(51, 51, 51);
            border: 1px solid rgb(97, 94, 94);
            border-radius: 5px;
            background-color: transparent;
        }

        .form-group--error input, .form-group--error textarea, .form-group--error input:focus, .form-group--error input:hover {
            border-color: #f79483;
        }

        .form-group--float-label, .form-group__input {
            position: relative;
        }
    </style>

@endsection
@section('additional-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
    @if($dataManagerPage['shopConfig']['allow'] &&  $dataManagerPage['shopConfig']['data']['pay-phone']!=false)
        <script>
            var $configManagerPayPhone = <?php echo json_encode(($dataManagerPage['shopConfig']['data']['pay-phone'])) ?>;
        </script>

    @endif
    <script>
        var $allowAllInOne = true;
    </script>
    <script src="{{ URL::asset($resourcePathServer.'libs/blockui/blockui.min.js') }}"></script>
    <script src="{{ URL::asset($resourcePathServer."assets/libs/jquery-toast/jquery-toast.min.js") }}"></script>
    <script src="{{ asset($resourcePathServer.'libs/vue/axios/axios.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/vue-bootstrap/vue-bootstrap.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'libs/uiv/uiv.min.js')}}"></script>
    <script src="{{ asset($resourcePathServer.'js/vue/directives/main.js')}}" type='text/javascript'></script>
    <script src="{{ asset($resourcePathServer.'js/vue/components/main.js')}}" type='text/javascript'></script>

    @if($dataManagerPage['shopConfig']['allow'] && $dataManagerPage['shopConfig']['data']['pay-pal']!=false)
        <script src="{{ asset($resourcePathServer.'js/frontend/web/utils/Paypal.js')}}"></script>
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    @endif
    @if($dataManagerPage['shopConfig']['allow'] && $dataManagerPage['shopConfig']['data']['api-credit-cards']!=false)
        @if($allowModalPaymentez)
            <script src="https://cdn.paymentez.com/checkout/1.0.1/paymentez-checkout.min.js"></script>
        @else
            @if(  $dataManagerPage['shopConfig']['data']['api-credit-cards']->type_manager == 1)
                <script src="https://cdn.paymentez.com/js/1.0.1/paymentez.min.js" charset="UTF-8"></script>
            @else
                <script src="https://cdn.paymentez.com/js/ccapi/stg/paymentez.min.js" charset="UTF-8"></script>
            @endif
        @endif
    @endif
    <script id="manager-init-payment">

        @if($dataManagerPage['shopConfig']['allow'] && $dataManagerPage['shopConfig']['data']['api-credit-cards'])

        @if(!$allowModalPaymentez)
        Paymentez.init($configPayments['api-credit-cards']['env'], $configPayments['api-credit-cards']['id'], $configPayments['api-credit-cards']['code']);

        @endif

        @endif
    </script>
    @if(!env('allowRoutes'))


    @else
        <script id="notAllowRoutes" src="{{ asset($resourcePathServer.'js/frontend/web/CheckoutEvent.js')}}"></script>

    @endif
@endsection
@section('additional-init-script-vue')
    <script id="manager-checkout">
        function getTotalManagerProductCurrent(value) {
            var subtotal = 0;
            var subtotal_no_tax = 0;
            var subtotal_tax = 0;
            var total = 0;
            var total_tax = 0;
            var has_tax = false;
            var allow_discount = value.allow_discount == 0 ? false : true;
            var price = allow_discount == false ? parseFloat(value.sale_not_tax) : parseFloat(value.price_discount);
            var sale_price = 0;
            var amount = parseInt(getCountProduct(value));
            var sale_not_tax = parseFloat(value.sale_not_tax);
            var taxPercentage = parseFloat(value.tax_percentage);
            var taxCurrent = 0;
            if (value.has_tax) {
                has_tax = true;
                taxCurrent = (sale_not_tax * taxPercentage) / 100;
                sale_price = sale_not_tax + taxCurrent;
                subtotal_tax = sale_price * amount;
                total_tax = ((sale_not_tax * amount) * taxPercentage) / 100;
                total = subtotal_tax;
            } else {
                sale_price = sale_not_tax;
                subtotal_no_tax = sale_price * amount;
                total = subtotal_no_tax;
            }
            subtotal = parseFloat(subtotal_tax) + parseFloat(subtotal_no_tax);
            var round = 2;
            sale_price = sale_price.toFixed(round);
            sale_not_tax = sale_not_tax.toFixed(round);
            subtotal_tax = subtotal_tax.toFixed(round);
            total = total.toFixed(round);
            total_tax = total_tax.toFixed(round);
            subtotal_no_tax = subtotal_no_tax.toFixed(round);
            subtotal = subtotal.toFixed(round);
            taxCurrent = taxCurrent.toFixed(round);
            var result = {
                has_tax: has_tax,
                sale_price: sale_price,
                sale_not_tax: sale_not_tax,
                taxPercentage: taxPercentage,
                amount: amount,
                subtotal_no_tax: subtotal_no_tax,//only not tax prices
                subtotal_tax: subtotal_tax,//only tax prices
                total_tax: total_tax,//tax total
                subtotal: subtotal,//all prices with tax not tax
                total: total,
                taxCurrent: taxCurrent
            };

            return result;
        }

        function getTypesVariantCurrent(dataProduct) {
            var colorAndSizeSearch = dataProduct.hasOwnProperty('product_sizes_id') && dataProduct.hasOwnProperty('product_color_id');
            var colorSearch = dataProduct.hasOwnProperty('product_color_id') && dataProduct.hasOwnProperty('product_sizes_id') == false;
            var sizeSearch = dataProduct.hasOwnProperty('product_color_id') == false && dataProduct.hasOwnProperty('product_sizes_id');
            var anyOneVariant = dataProduct.hasOwnProperty('product_color_id') == false && dataProduct.hasOwnProperty('product_sizes_id') == false;
            var result = {
                colorAndSizeSearch: colorAndSizeSearch,
                colorSearch: colorSearch,
                sizeSearch: sizeSearch,
                anyOneVariant: anyOneVariant
            };
            return result;
        }

        function getCountProduct(data) {
            let result = -1;
            if (data instanceof Object && data !== null) {
                if ('count' in data) {

                    result = data.count;
                } else if ('amountSale' in data) {

                    result = data.amountSale;

                }
            }

            return result;
        }

        function getPriceProduct(data) {
            let result = -1;
            if (data instanceof Object && data !== null) {
                if ('price' in data) {

                    result = data.price;
                } else if ('sale_price' in data) {

                    result = data.sale_price;

                }
            }

            return result;
        }

        function initViewDataLocalStorageCurrent() {
            if ($cookiesManager['init_cart'] == 'allow' || $cookiesManager['init_cart'] == null) {
                if (!localStorage.getItem('shop')) {
                    var managerData = [];
                    localStorage.setItem('shop', JSON.stringify(managerData));
                }
            } else {
                localStorage.removeItem('shop');
            }
            //viewDataShop();
        }

        function resetAllCurrent() {

            localStorage.clear();
            initViewDataLocalStorageCurrent();
            var itemsShop = getItemsShopCurrent();
            if ($currentPage == 'checkout') {

            }

        }

        function getRowCartProductCurrent(data) {
            $languageCurrent = $language == 'es' ? null : $language;
            console.log('getRowCartProductCurrent')
            var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
            nameProduct = nameProduct + (' - ' + data.code);

            var managerVariants = getTypesVariantCurrent(data);

            if (managerVariants.anyOneVariant) {
                nameProduct = nameProduct + (' - ' + data.code);
            } else if (managerVariants.colorAndSizeSearch) {
                nameProduct = nameProduct + (' - ' + data.product_color) + (' - ' + data.product_sizes);
            } else if (managerVariants.colorSearch) {
                nameProduct = nameProduct + (' - ' + data.product_color);
            } else if (managerVariants.sizeSearch) {
                nameProduct = nameProduct + (' - ' + data.product_sizes);
            }
            var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);
            let count = getCountProduct(data);
            var nameProductDetails = nameProduct + ' X ' + count;
            var result = [
                '<li id="li-cart-' + data.id + '" product-id="' + data.id + '">',
                nameProductDetails,
                '<span>$' + getPriceProduct(data) + '</span>',
                '</li>'
            ];
            result = result.join('');
            return result;
        }

        function getViewsRowProductCurrent($params) {
            var data = $params['data'];
            var result = [];
            var viewTax = false;
            var totalTax = 0;
            var subtotal = 0;
            if (!$('.tr-tax').hasClass('not-view')) {
                $('.tr-tax').addClass('not-view')
            }
            $.each(data, function (index, value) {
                var selectorAdd = $('#tr-cart-' + index).attr('product-id');
                if (!selectorAdd) {
                    var htmlRow = getRowCartProductCurrent(index, value);
                    $('.cart-table tbody').append(htmlRow);
                    if (value.has_tax) {
                        var managerProduct = getTotalManagerProductCurrent(value);
                        totalTax += parseFloat(managerProduct.total_tax);
                        viewTax = true;
                    }
                }
            });

            if (viewTax) {
                $('.tr-tax').removeClass('not-view');
                totalTax = totalTax.toFixed(2);

                $('.tax-total').html(totalTax);
            }
        }


        function getItemsShopCurrent() {
            var result = [];
            var shopData = localStorage.getItem('shop');
            shopData = JSON.parse(shopData);
            $.each(shopData, function (index, value) {
                result.push(value);
            });

            return result;
        }

        function getItemsResultShopCurrent(data) {
            var subtotal = 0;
            var totalItems = 0;
            var subtotal_no_tax = 0;
            var subtotal_tax_x_config = 0;
            var subtotal_tax_0_config = 0;

            var subtotal_tax = 0;
            var total = 0;
            var total_tax = 0;
            var has_tax = false;
            $.each(data, function (index, value) {

                var amount = parseInt(value.count);
                var managerProduct = getTotalManagerProductCurrent(value);
                if (value.has_tax) {
                    has_tax = true;
                    subtotal_tax_x_config += parseFloat(value.sale_not_tax) * amount;
                } else {
                    subtotal_tax_0_config += parseFloat(value.sale_not_tax) * amount;

                }
                subtotal += parseFloat(managerProduct.subtotal);
                subtotal_no_tax += parseFloat(managerProduct.subtotal_no_tax);
                subtotal_tax += parseFloat(managerProduct.subtotal_tax);
                total += parseFloat(managerProduct.total);
                total_tax += parseFloat(managerProduct.total_tax);
                totalItems += parseInt(value.count);
            });

            total = total.toFixed(2);
            subtotal_no_tax = subtotal_no_tax.toFixed(2);
            subtotal_tax = subtotal_tax.toFixed(2);
            total_tax = total_tax.toFixed(2);
            subtotal_tax_x = subtotal_tax_x_config.toFixed(2);
            subtotal_tax_0 = subtotal_tax_0_config.toFixed(2);
            subtotal = subtotal.toFixed(2);

            var result = {
                subtotal: subtotal,//all prices with tax not tax
                subtotal_no_tax: subtotal_no_tax,//only not tax prices
                subtotal_tax: subtotal_tax,//only tax prices
                total_tax: total_tax,//tax total
                total: total,
                has_tax: has_tax,
                totalItems: totalItems,
                subtotal_tax_x: subtotal_tax_x_config,
                subtotal_tax_0: subtotal_tax_0_config,

            };
            return result;
        }

    </script>
    <script>
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

        function initUtilsManagerCurrent() {
            var $UtilCustomer = $managerUtils['UtilCustomer'];
            $utilCustomer = new $UtilCustomer($customerData);
        }

        function getDataShopCurrent() {

            var result = billingStructureCurrent();
            return JSON.stringify(result);
        }

        function getCheckedTypePaymentCurrent() {
            var typesPaymentSelectors = [
                '#payment_bank',
                '#payment_payoneer',
                '#payment_paypal',
                '#payment_pay_phone',

            ];
            var paypal = 0;
            var payu = 1;
            var bank = 2;
            var result = -1;
            $.each(typesPaymentSelectors, function (index, value) {

                if ($(value).prop("checked")) {
                    if ('#payment_bank' == value) {
                        result = bank;
                    } else if ('#payment_payoneer' == value) {
                        result = payu;

                    } else if ('#payment_paypal' == value) {
                        result = paypal;

                    } else if ('#payment_pay_phone' == value) {
                        result = paypal;

                    }
                }
            });
            return result;
        }

        function getOrderBillingCustomerCurrent() {
            var result = {
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                payer_email: $('#payer_email').val(),
                phone: $('#phone').val(),
                company: $('#company').val(),
                address_main: $('#address_main').val(),
                address_secondary: $('#address_secondary').val(),
                country_id: $('#country_id').val(),
                state_province_id: $('#state_province_id').val(),
                city: $('#city').val(),
                zipcode: $('#zipcode').val(),
                type_payment_customer: getCheckedTypePaymentCurrent(),
                same_billing_address: $('#same_billing_address').prop("checked"),
                document: $('#document').val(),

            };
            if (!$('#same_billing_address').prop("checked")) {
                var keyBilling = 'billing_';
                result[keyBilling + 'first_name'] = $('#' + keyBilling + 'first_name').val();
                result[keyBilling + 'last_name'] = $('#' + keyBilling + 'last_name').val();
                result[keyBilling + 'payer_email'] = $('#' + keyBilling + 'payer_email').val();
                result[keyBilling + 'phone'] = $('#' + keyBilling + 'phone').val();
                result[keyBilling + 'company'] = $('#' + keyBilling + 'company').val();
                result[keyBilling + 'address_main'] = $('#' + keyBilling + 'address_main').val();
                result[keyBilling + 'address_secondary'] = $('#' + keyBilling + 'address_secondary').val();
                result[keyBilling + 'country_id'] = $('#country_id').val();
                result[keyBilling + 'state_province_id'] = $('#' + keyBilling + 'state_province_id').val();
                result[keyBilling + 'city'] = $('#' + keyBilling + 'city').val();
                result[keyBilling + 'zipcode'] = $('#' + keyBilling + 'zipcode').val();
                result[keyBilling + 'document'] = $('#' + keyBilling + 'document').val();

            }

            return result;
        }

        function getUserCurrent() {
            var create_account = $('#create_account').prop("checked") == undefined ? false : $('#create_account').prop("checked");
            var result = {
                create_account: create_account,
                email: create_account ? $('#email').val() : 'none',
                'id': $utilCustomer.getCustomer.manager_id
            };
            return result;
        }

        function billingStructureCurrent() {
            var itemsShopCurrent = getItemsShopCurrent();
            var resultShop = getItemsResultShopCurrent(itemsShopCurrent);

            var OrderShopping = {
                subtotal: resultShop.subtotal,
                total: resultShop.total,
                has_tax: resultShop.has_tax,
                subtotal_no_tax: resultShop.subtotal_no_tax,
                subtotal_tax: resultShop.subtotal_tax,
                total_tax: resultShop.total_tax,
                description: $('#shop-description').val(),
                subtotal_tax_x: resultShop.subtotal_tax_x,
                subtotal_tax_0: resultShop.subtotal_tax_0,
                shipping: 0,


            };
            var OrderBillingDetails = $('#shop-data').val();
            var OrderBillingCustomer = getOrderBillingCustomerCurrent();
            var User = getUserCurrent();
            var Business = localStorage.getItem('businessManagement');
            if (Business) {

                Business = JSON.parse(Business);
                Business = Business[0];
            }
            var result = {
                User: User,
                OrderShopping: OrderShopping,
                Business: Business,
                OrderBillingDetails: OrderBillingDetails,
                OrderBillingCustomer: OrderBillingCustomer,

            };
            return result;
        }
    </script>
    <script type="module" id="manager-modules">

        import * as UtilPaymentez
            from '{{ asset($resourcePathServer.'js/frontend/web/utils/Paymentez.js')}}'

        $managerUtils['UtilPaymentez'] = UtilPaymentez;
        import UtilCustomer
            from '{{ asset($resourcePathServer.'js/frontend/web/utils/Customer.js')}}'

        $managerUtils['UtilCustomer'] = UtilCustomer;
    </script>
    <script id="additional-payment-type-bank-deposit">

        var $methodsCheckout = {}
        $methodsCheckout.onInitManager = onInitManager;
        $methodsCheckout.initManagerElementsCheckout = initManagerElementsCheckout;

        function getDataCart() {

        }

        function onInitManager() {

        }

        function initManagerElementsCheckout() {
            let $scope = this;
            $(document).ready(function () {
                $('#manager-checkout-save').on("click", function () {
                    console.log('69');

                });
            });


        }

        function onReceiveCheckoutEvents(response) {
            var $scope = response.this;
            console.log("onReceiveCheckoutEvents", response);
            this.$emit('on-emmit-shop-events', emitData);
        }

        Vue.component(
            'payment-type-bank-deposit-component',

            {
                template: '#payment-type-bank-deposit-template',
                props: {

                    dataManager: {
                        type: Object,
                    }

                },
                data() {
                    return {
                        cartData: [],
                        allowData: false,

                    }
                },
                created: function () {
                    console.log(" payments-types-component created", this.dataManager);


                },
                beforeMount: function () {

                    console.log("beforeMount", this.dataManager);
                },
                mounted: function () {
                    console.log("mounted-------------------", this.dataManager);

                    this.initManagerElementsCheckout();
                    // Manipula elementos del DOM de los hijos aquí
                },


                methods: {
                    ...$methodsCheckout,

                }
            }
        );

    </script>
    <script id="manager-functions-checkout-page">

        function managerCheckoutDetails(params) {
            var dataResponse = params['data'];
            var ManagerCheckout = dataResponse['ManagerCheckout'];
            var OrderShoppingCart = ManagerCheckout['OrderShoppingCart'];
            var checkoutId = OrderShoppingCart['id'];
            var locationCheckout = "{{ route("checkoutDetails", app()->getLocale()) }}" + '/' + checkoutId + '/true';
            $(location).attr('href', locationCheckout);
        }

        var $dataCountriesManager = <?php echo json_encode(isset($dataManagerPage['dataCountriesManager']) ? $dataManagerPage['dataCountriesManager'] : []) ?>;
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
        var $configPayments = <?php echo json_encode($configPayments) ?>;
        var $currentPage = <?php echo json_encode(isset($dataManagerPage['currentPage']) ? $dataManagerPage['currentPage'] : 'not-defined') ?>;
        var $allowPaymentsData = <?php echo json_encode($allowPaymentsData) ?>;


    </script>
    @include('eatPura.web.partials.assets.js-validate')
    <script>
        Vue.directive('bgrid', {
            bind: function (el, binding, vnode) {
                /*      var configBootrid = binding.value.paramsConfigTable;*/
                /* dataTable = initDatableAjax($(el),configBootrid);*/
            }
        });
        Vue.directive('initGrid', {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMethod({
                    objSelector: el, model: paramsInput.model
                });
            },
        });
        Vue.directive('initMapPlugin', {

            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var methodInit = paramsInput['methodInit'];
                var elementSelector = paramsInput['elementSelector'];

                methodInit({
                    elementSelector: elementSelector,
                    objSelector: $(el)[0],
                    data: paramsInput
                });

            }
        });
        Vue.directive('initS2Plugin', {

            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var nameMethod = paramsInput.nameMethod;
                var rowId = paramsInput.rowId;
                nameMethod({
                    objSelector: el, rowId: paramsInput.rowId, modelId: rowId
                });


            }
        });
        Vue.directive('focus-select', {

            inserted: function (el, binding, vnode, vm, arg) {

            },
            bind: function (el, binding, vnode, vm, arg) {
                $(el).focus(function () {
                    $(this).select();
                });
            }
        });
        Vue.directive('reset-field', {

            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var fieldName = paramsInput['fieldName'];
                var form = paramsInput['form'];
                form[fieldName].$model = null;
                form[fieldName].$reset();


            }
        });
        Vue.directive('upload-data', {

            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }

        });
        Vue.directive('view-data', {
            bind: function (el, binding, vnode, vm, arg) {
                $(el).removeClass("not-view");

            }
        });
        Vue.directive('init-map', {

            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMapCurrent();
            },
        });
        Vue.directive('init-tool-tip', {

            bind: function (el, binding, vnode, vm, arg) {
                $(el).tooltip();
                $(el).hover(function () {
                    console.log('22');
                }, function () {
                    console.log('21');

                });
            }
        });
        Vue.directive('_upload-resource', {
            inserted: function (el, binding, vnode, vm, arg) {
                console.log("uploada------------->")
                let paramsInput = binding.value;
                paramsInput._initEventsUpload({
                    objSelector: el
                });

            }
        });
        Vue.directive('load-img', {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var source = paramsInput.source;
                source = source == null || source == '' ? $notImageUrl : getValueValidSource(source);
                $(el).attr('src', source);
            }
        });

        function getValueValidSource(source) {
            return $resourceRoot + source;
        }


        var emptyManagerImage = 'https://image.shutterstock.com/image-vector/picture-vector-icon-no-image-260nw-1350441335.jpg';
        Vue.component('template-payments-component', {
            props: {
                params: {
                    type: Object,

                },
            },
            template: '#template-payments-template',
            directives: {
                initPaymentez: {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value;
                        var initMethod = paramsInput['initMethod'];
                        initMethod({
                            elementInit: el
                        });
                    }
                },
                initPaypal: {
                    inserted: function (el, binding, vnode, vm, arg) {
                        var paramsInput = binding.value;
                        var initMethod = paramsInput['initMethod'];
                        initMethod({
                            elementInit: el
                        });
                    }
                }
            },
            created: function () {

                this.managerData.data = this.params.data;
                this.managerData.current = this.params;
                console.log(this.managerData.data);
                var country_id = '18';
                var stateProvincesData = this.getStateProvinces(country_id);
                var fieldName = 'state_province_id';
                this.model.structure[fieldName]['data'] = stateProvincesData;

            },
            mounted: function () {
                this.initCurrentComponent();
                appThisComponent = this;
                var $this = this;

                $(document).ready(function () {
                    $this.loadPage = true;
                    initUtilsManagerCurrent();
                    var $customerDataCurrent = $this.getUserCurrent();
                    $this.setCustomerManagerAttributes($customerDataCurrent);
                    var paypalConfig = $this.payment['pay-pal'];
                    if (managerPayment('pay-pal') && dataManagerShopping.success) {
                        var paramsConfig = {
                            configPayPal: getConfigPayPal(),
                            selector: paypalConfig.selector,
                            selectorId: paypalConfig.id,
                        };
                        initButtonPayPal(paramsConfig);
                    }
                    $('#empty-products-loading').addClass('not-view');
                });

                let managerValid = this.getAllowFormPayment();
                this.sendAllowStatus({
                    "type": "validForm",
                    'typePayment': this.model.attributes.type_payment,
                    "data": managerValid
                });
            },

            validations: function () {
                console.log("entra aqui   validations---------->")
                var attributes = {
                    "change": {},
                    "accept_terms": {required},
                    "payment_bank": {},
                    "payment_pay_phone": {},
                    "payment_payoneer": {},
                    "payment_paypal": {},
                    'type_payment': {required},
                    'first_name': {required},
                    'last_name': {required},
                    'payer_email': {required, email},
                    'phone': {required},
                    'company': {},
                    'address_main': {required},
                    'address_secondary': {required},
                    'city': {required},
                    'state_province_id': {required},
                    'country_id': {required},
                    'zipcode': {required},
                    'document': {required},
                    deposit: {},
                    //credit cards
                    cardNumber: {},
                    card: {},
                    cardType: {},
                    name: {},
                    expiry: {},
                    fiscalNumber: {},
                    cvc: {},
                    validationOption: {},
                    //loginInit
                    user_logged_in: {},
                    create_account: {},
                    //user create account
                    email: {},
                    //other address
                    same_billing_address: {},
                    'billing_first_name': {},
                    'billing_last_name': {},
                    'billing_payer_email': {},
                    'billing_phone': {},
                    'billing_company': {},
                    'billing_address_main': {},
                    'billing_address_secondary': {},
                    'billing_city': {},
                    'billing_state_province_id': {},
                    'billing_zipcode': {},
                    'billing_document': {},
                };
                if (this.model.attributes.type_payment == 'bank-deposit') {
                    attributes['deposit'] = {required};
                } else if (this.model.attributes.type_payment == 'api-credit-cards') {
                    if (!$configPayments['api-credit-cards']['managerTypeModal']) {
                        attributes['cardNumber'] = {required};
                        attributes['card'] = {};
                        attributes['cardType'] = {};
                        attributes['name'] = {required};
                        attributes['expiry'] = {required};
                        attributes['cvc'] = {required};
                        attributes['validationOption'] = {};
                    }

                }

                if (this.model.attributes.same_billing_address == false) {
                    attributes['billing_first_name'] = {required};
                    attributes['billing_last_name'] = {required};
                    attributes['billing_payer_email'] = {email, required};
                    attributes['billing_phone'] = {required};
                    attributes['billing_company'] = {};
                    attributes['billing_address_main'] = {required};
                    attributes['billing_address_secondary'] = {required};
                    attributes['billing_city'] = {required};
                    attributes['billing_state_province_id'] = {required};
                    attributes['billing_zipcode'] = {required};
                    attributes['billing_document'] = {required};
                }
                if (this.model.attributes.create_account) {
                    attributes['email'] = {
                        email,
                        required
                    };
                    if (this.managerInitGet.email.allow) {
                        attributes['email'] = {
                            email,
                            required,
                            isUnique(value) {

                                var urlValidate = $("#action-users-emailUniqueCheckout").val();
                                var params = {
                                    email: value
                                };
                                var user_id = this.model.attributes.user_id;
                                if (user_id) {
                                    params['id'] = user_id;
                                }
                                var paramsPost = {
                                    allow: this.managerInitGet.email.allow,
                                    value: value,
                                    paramsPost: params,
                                    urlValidate: urlValidate
                                };
                                var result = null;

                                if (value === '') {
                                    result = true;
                                } else {
                                    if (this.managerInitGet.email.allow) {
                                        result = getValuesPost(paramsPost);
                                    } else {
                                        result = true;
                                    }
                                }


                                return result;

                            }

                        }
                    }


                }
                var result = {
                    model: {//change
                        attributes: attributes
                    },
                };
                return result;

            },
            data: function () {
                var result = {
                    depositAux: null,
                    managerData: {
                        data: [],
                        current: {},
                        taxTotal: 0,
                        subTotal: 0,
                        shipping: 0,
                        total: 0,

                    },
                    titles: {typePayments: 'Metodos De Pago'},
                    model: {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm(),
                    },
                    typeName: 'main-deposit',
                    formConfig: {
                        nameSelector: "#source-logo-main-form",
                        url: $rootPage + 'executePaymentBank',
                        loadingMessage: 'Guardando...',
                        errorMessage: 'Error al guardar Imagen.',
                        successMessage: 'Se guardo correctamente.',
                        nameModel: "TemplateBySource"
                    },
                    payment: {
                        'api-credit-cards': {
                            selector: '#my-card',
                            typeManager: 'button',
                            objectButton: null,

                        },
                        'pay-pal': {
                            selector: '#paypal-button-container',
                            id: 'paypal-button-container',
                            typeManager: 'button',
                            objectButton: null,
                            'allowInit': false
                        },
                    },
                    managerInitAll: false,
                    managerInitGet: {
                        username: {
                            allow: false
                        },
                        password_old: {
                            allow: false
                        },
                        email: {
                            allow: false
                        },
                        policies: {
                            view: false
                        }
                    },
                    loadPage: false
                };

                return result;
            },
            methods: {

                getViewsRowProduct: function (data) {
                    let result = [];
                    var viewTax = false;
                    var totalTax = 0;
                    let managerResult = [];


                    $.each(data, function (index, value) {

                        var htmlRow = getRowCartProductCurrent(value);
                        result.push(htmlRow);
                        if (value.has_tax) {
                            var managerProduct = getTotalManagerProductCurrent(value);
                            managerResult.push(managerProduct);
                            totalTax += parseFloat(managerProduct.total_tax);
                            viewTax = true;
                        }
                    });
                    if (viewTax) {
                        //  $('.tr-tax').removeClass('not-view');
                        totalTax = totalTax.toFixed(2);
                        //$('.tax-total').html(totalTax);
                    }

                    var itemsShopCurrent = getItemsShopCurrent();
                    var resultShop = getItemsResultShopCurrent(itemsShopCurrent);
                    var shipPrice = 0;
                    var total = parseFloat(shipPrice) + parseFloat(resultShop.subtotal);
                    this.managerData.total = '$' + total;
                    this.managerData.taxTotal = '$' + totalTax;
                    this.managerData.shipping = '$' + shipPrice;
                    var shopData = JSON.stringify(itemsShopCurrent);
                    this.managerData.subTotal = '$' + resultShop.subtotal;
                    var shopDescription = 'Pago de Productos de Carrito de Compras';
                    $('#shop-description').val(shopDescription);
                    $('#shop-shipping').val(shipPrice);
                    $('#shop-data').val(shopData);
                    return result.join("");
                },
                ...$methodsFormValid,
                getUserCurrent: function () {
                    var result = this.loadPage ? $utilCustomer.getUserCurrentInformation : {
                        'Customer': {
                            first_name: '',
                            last_name: '',
                            payer_email: '',
                            manager_id: null
                        }, success: false
                    };
                    return result;
                },
                setCustomerManagerAttributes: function ($customerDataCurrent) {
                    var first_name = $customerDataCurrent['Customer']['first_name'];
                    var last_name = $customerDataCurrent['Customer']['last_name'];
                    var payer_email = $customerDataCurrent['Customer']['payer_email'];
                    var fieldName = 'first_name';
                    this.model.attributes[fieldName] = first_name;
                    fieldName = 'last_name';
                    this.model.attributes[fieldName] = last_name;
                    fieldName = 'payer_email';
                    this.model.attributes[fieldName] = payer_email;
                },
                /* FORM*/
                getAttributesForm: function () {
                    var $customerDataCurrent = this.getUserCurrent();
                    var first_name = $customerDataCurrent['Customer']['first_name'];
                    var last_name = $customerDataCurrent['Customer']['last_name'];
                    var payer_email = $customerDataCurrent['Customer']['payer_email'];
                    var resultPayment = this.initCheckPaymentDefault();
                    var type_payment = resultPayment.typePayment;
                    var phone = '';
                    var address_main = '';
                    var address_secondary = '';
                    var country_id = '18';
                    var result = {

                        "change": false,
                        "accept_terms": null,
                        "payment_bank": null,
                        "payment_pay_phone": null,

                        "payment_payoneer": null,
                        "payment_paypal": null,
                        type_payment: type_payment,
                        first_name: first_name,
                        last_name: last_name,
                        payer_email: payer_email,
                        phone: phone,
                        company: '',
                        address_main: address_main,
                        address_secondary: address_secondary,
                        country_id: country_id,
                        state_province_id: null,
                        city: '',
                        zipcode: '',
                        document: null,
                        deposit: null,
                        //credit cards
                        cardNumber: null,
                        card: null,
                        cardType: null,
                        name: null,
                        expiry: null,
                        fiscalNumber: null,
                        cvc: null,
                        validationOption: null,
                        //loginInit
                        user_logged_in: true,
                        create_account: null,
                        //user create account
                        email: null,
                        //other address
                        same_billing_address: true,
                        'billing_first_name': null,
                        'billing_last_name': null,
                        'billing_payer_email': null,
                        'billing_phone': null,
                        'billing_company': null,
                        'billing_address_main': null,
                        'billing_address_secondary': null,
                        'billing_city': null,
                        'billing_state_province_id': null,
                        'billing_zipcode': null,
                        'billing_document': null,
                    };
                    return result;
                },
                getStructureForm: function () {
                    var result = {
                        payment_bank: {
                            id: "payment_bank",
                            name: "payment_bank",
                            label: $formConfig.payment_bank,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                        },
                        payment_pay_phone: {
                            id: "payment_pay_phone",
                            name: "payment_pay_phone",
                            label: "Pay Phone",
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                        },
                        payment_payoneer: {
                            id: "payment_payoneer",
                            name: "payment_payoneer",
                            label: $formConfig.payment_payoneer,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        payment_paypal: {
                            id: "payment_paypal",
                            name: "payment_paypal",
                            label: $formConfig.payment_paypal,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        first_name: {
                            id: "first_name",
                            name: "first_name",
                            label: $formConfig.first_name,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        last_name: {
                            id: "last_name",
                            name: "last_name",
                            label: $formConfig.last_name,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        payer_email: {
                            id: "payer_email",
                            name: "payer_email",
                            label: $formConfig.payer_email,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,

                                error: false
                            },
                            email: {
                                allow: true,
                                msj: $formValidationsLabels.email,

                            },
                        },
                        phone: {
                            id: "phone",
                            name: "phone",
                            label: $formConfig.phone,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        company: {
                            id: "company",
                            name: "company",
                            label: $formConfig.company,
                            required: {
                                allow: false,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        address_main: {
                            id: "address_main",
                            name: "address_main",
                            label: $formConfig.address_main,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        address_secondary: {
                            id: "address_secondary",
                            name: "address_secondary",
                            label: $formConfig.address_secondary,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        state_province_id: {
                            id: "state_province_id",
                            name: "state_province_id",
                            label: $formConfig.state_province_id,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                            data: []

                        },
                        country_id: {
                            id: "country_id",
                            name: "country_id",
                            label: $formConfig.country_id,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        city: {
                            id: "city",
                            name: "city",
                            label: $formConfig.city,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        zipcode: {
                            id: "zipcode",
                            name: "zipcode",
                            label: $formConfig.zipcode,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        document: {
                            id: "document",
                            name: "document",
                            label: $formConfig.document,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                        },
                        billing_first_name: {
                            id: "billing_first_name",
                            name: "billing_first_name",
                            label: $formConfig.billing_first_name,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_last_name: {
                            id: "billing_last_name",
                            name: "billing_last_name",
                            label: $formConfig.billing_last_name,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_payer_email: {
                            id: "billing_payer_email",
                            name: "billing_payer_email",
                            label: $formConfig.billing_payer_email,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                            email: {
                                allow: true,
                                msj: $formValidationsLabels.email,

                            },
                        },
                        billing_phone: {
                            id: "billing_phone",
                            name: "billing_phone",
                            label: $formConfig.billing_phone,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_company: {
                            id: "billing_company",
                            name: "billing_company",
                            label: $formConfig.billing_company,
                            required: {
                                allow: false,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_address_main: {
                            id: "billing_address_main",
                            name: "billing_address_main",
                            label: $formConfig.billing_address_main,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_address_secondary: {
                            id: "billing_address_secondary",
                            name: "billing_address_secondary",
                            label: $formConfig.billing_address_secondary,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_state_province_id: {
                            id: "billing_state_province_id",
                            name: "billing_state_province_id",
                            label: $formConfig.billing_state_province_id,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                            data: []
                        },
                        billing_city: {
                            id: "billing_city",
                            name: "billing_city",
                            label: $formConfig.billing_city,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_zipcode: {
                            id: "billing_zipcode",
                            name: "billing_zipcode",
                            label: $formConfig.billing_zipcode,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        billing_document: {
                            id: "billing_document",
                            name: "billing_document",
                            label: $formConfig.billing_document,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                        },
                        create_account: {
                            id: "create_account",
                            name: "create_account",
                            label: $formConfig.create_account,
                            required: {
                                allow: false,
                                msj: $formValidationsLabels.required,
                                error: false
                            },

                        },
                        email: {
                            id: "email",
                            name: "email",
                            label: $formConfig.email,
                            required: {
                                allow: true,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                            email: {
                                allow: true,
                                msj: $formValidationsLabels.email,

                            },
                            unique: {
                                allow: true,
                                msj: $formValidationsLabels.unique,

                            },
                        },
                        same_billing_address: {
                            id: "same_billing_address",
                            name: "same_billing_address",
                            label: $formConfig.same_billing_address,
                            required: {
                                allow: false,
                                msj: $formValidationsLabels.required,
                                error: false
                            },
                        }
                    };
                    return result;
                },
                _setValueForm: function (name, value) {

                    if (name == "payment_bank"
                        || name == "payment_payoneer" ||
                        name == "payment_paypal" ||
                        name == "payment_pay_phone") {
                        this.model.attributes['type_payment'] = value;
                        $('.single-method div.payments-information').slideUp();
                        $('.single-method div.payments-information').children().slideUp();
                        $('.single-method div.payments-information').children().children().slideUp();
                        $('[data-method="' + name + '"]').slideDown();
                        $('[data-method="' + name + '"]').children().slideDown();
                        $('[data-method="' + name + '"]').children().children().slideDown();

                    } else if (name == 'accept_terms') {

                    } else if (name == 'email') {

                        if (this.$v.model.attributes.create_account.$model) {
                            if (!this.$v.model.attributes.email.$invalid) {

                                this.managerInitGet[name].allow = true;
                            } else {

                                this.managerInitGet[name].allow = false;
                            }
                        } else {

                            this.managerInitGet[name].allow = false;
                        }
                    } else if (name == 'same_billing_address') {
                        var country_id = this.model.attributes['country_id'];
                        var stateProvincesData = this.getStateProvinces(country_id);
                        var fieldName = 'billing_state_province_id';
                        this.model.structure[fieldName]['data'] = stateProvincesData;
                    }


                    this.model.attributes[name] = value;
                    this.$v["model"]["attributes"][name].$model = value;
                    this.$v["model"]["attributes"][name].$touch();
                    this.getValidateForm();

                    let managerValid = this.getAllowFormPayment();
                    this.sendAllowStatus({
                        "type": "validForm",
                        "data": managerValid
                    });
                },
                getClassErrorForm: function (nameElement, objValidate) {
                    var result = null;
                    result = {
                        "form-group--error": objValidate.$error,
                        'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
                    };
                    return result;
                },
                getClassPayPalManager: function (formSuccess) {
                    var result = '';
                    if (this.model.attributes.type_payment == 'pay-pal') {
                        result = formSuccess ? "disabled-container" : "enabled-container";
                    }
                    return result;
                },
                getValuesSave: function () {
                    var params = getDataShopCurrent();
                    var type_payment = this.$v.model.attributes.$model.type_payment;
                    var customerData = $utilCustomer.getUserCurrentInformation;
                    var result = {
                        params: params,
                        type_payment: type_payment,
                        manager_id: customerData['Customer']['manager_id']
                    };
                    if (type_payment == 'bank-deposit') {
                        result['source'] = this.$v.model.attributes.$model.deposit;
                        result['change'] = this.$v.model.attributes.$model.change;

                    }

                    return result;
                },
                _submitForm: function (e) {
                    console.log(e);
                },
                _resetForm: function (e) {
                    console.log(e);
                },
                _managerCountry: function (attribute, value) {
                    var fieldName = '';
                    var stateProvincesData = [];
                    var form = null;
                    form = this.$v.model.attributes;
                    stateProvincesData = this.getStateProvinces(value);
                    if (this.model.attributes.same_billing_address == false) {
                        fieldName = 'billing_state_province_id';
                        form[fieldName].$model = null;
                        this.model.structure[fieldName]['data'] = stateProvincesData;
                        form[fieldName].$reset();
                    }

                    fieldName = 'state_province_id';


                    form[fieldName].$model = null;
                    form[fieldName].$reset();
                    this.model.structure[fieldName]['data'] = stateProvincesData;
                    this._setValueForm(attribute, value);
                },
                getStateProvinces: function (countryId) {
                    var dataStateProvince = [];
                    $.each($dataCountriesManager, function (index, value) {
                        if (index == countryId) {
                            dataStateProvince = value['data'];
                        }
                    });
                    return dataStateProvince;
                },
                _saveModelPayPhone: function () {//PAY-PHONE SAVE
                    var $this = this;
                    $this.$v.$touch();
                    var validateCurrent = this.validateForm();
                    var configAjax = {
                        blockElement: '',
                        loading_message: 'Registrando Orden.......',
                        error_message: 'Existe Problemas al realizar orden.',
                        success_message: 'Se Realizo con exito la orden,se envio un correo electronico informativo de la orden.',

                    };
                    if (validateCurrent) {
                        var dataSendResult = this.getValuesSave();
                        var dataSend = dataSendResult;
                        dataSend = JSON.parse(dataSend.params);
                        var amount = 1;
                        var amountWithoutTax = dataSend.OrderShopping.subtotal_tax_x;
                        var amountWithTax = dataSend.OrderShopping.total;
                        var tax = 1;
                        var clientTransactionId = "Prueba transaciont 001";
                        var managerSet = {
                            amount: amount,
                            amountWithoutTax: amountWithoutTax,
                            amountWithTax: amountWithTax,
                            clientTransactionId: clientTransactionId,
                            /*     tax: tax,*/
                            responseUrl: $rootUrl + "/responsePayPhone",
                            cancellationUrl: $rootUrl + "/cancellPayPhone"
                        };
                        var urlCurrent = "https://pay.payphonetodoesposible.com/api/button/Prepare ";
                        var type = 'POST';
                        var configAjax = {
                            url: urlCurrent,
                            type: type,
                            dataType: 'json',
                            data: managerSet,
                            beforeSend: function (jqXHR, settings) {
                                jqXHR.setRequestHeader("Authorizacion", "Bearer " + $configManagerPayPhone.live_secret);
                            },
                            error: function (data) {
                                alert("Error en la llamada " + data);
                            },
                            success: function (data) {
                                location.href = data.payWithCard;
                            },
                            complete: function () {

                            }
                        };
                        $.ajax(configAjax);
                        console.log(dataSend, $allowAllInOne);
                    }
                },
                _saveModelBankDeposit: function () {

                    var $this = this;
                    $this.$v.$touch();
                    var validateCurrent = this.validateForm();
                    var configAjax = {
                        blockElement: '',
                        loading_message: 'Registrando Orden.......',
                        error_message: 'Existe Problemas al realizar orden.',
                        success_message: 'Se Realizo con exito la orden,se envio un correo electronico informativo de la orden.',

                    };
                    console.log('SAVE DEPOSIT');
                    if (validateCurrent) {
                        var dataSendResult = this.getValuesSave();
                        var dataSend = dataSendResult;
                        if (typeof ($allowAllInOne)) {
                            ajaxRequestManager(this.formConfig.url, {
                                type: 'POST',
                                data: dataSend,
                                blockElement: configAjax.blockElement,//opcional: es para bloquear el elemento
                                loading_message: configAjax.loading_message,
                                error_message: configAjax.error_message,
                                success_message: configAjax.success_message,
                                success_callback: function (response) {

                                    if (response.success) {
                                        $this.resetForm();

                                        resetAllCurrent();
                                        managerCheckoutDetails(response);
                                    }
                                }
                            }, true);
                        } else {
                            ajaxRequest(this.formConfig.url, {
                                type: 'POST',
                                data: dataSend,
                                blockElement: configAjax.blockElement,//opcional: es para bloquear el elemento
                                loading_message: configAjax.loading_message,
                                error_message: configAjax.error_message,
                                success_message: configAjax.success_message,
                                success_callback: function (response) {

                                    if (response.success) {
                                        $this.resetForm();

                                        resetAllCurrent();
                                        managerCheckoutDetails(response);
                                    }
                                }
                            }, true);
                        }

                    }

                },
                resetForm: function () {
                    this.$v.$reset();
                    this.model = {
                        attributes: this.getAttributesForm(),
                        structure: this.getStructureForm()
                    };
                    this.initManagement();
                    $('[data-method="accept_terms"]').slideUp();
                },
                initCurrentComponent: function () {
                    this.getValidateForm();
                    if ($configPayments.hasOwnProperty('api-credit-cards') && $configPayments['api-credit-cards']['allow'] && $configPayments['api-credit-cards']['managerTypeModal']) {
                        this.initModalPaymentez();
                    }
                }
                ,
                initManagement: function () {
                    $('.single-method div.payments-information').slideUp();
                    $('.single-method div.payments-information').children().slideUp();
                    $('.single-method div.payments-information').children().children().slideUp();

                    var resultPayment = this.initCheckPaymentDefault();
                    $(resultPayment.selectorCheck).prop("checked", true);
                    $('[data-method="' + resultPayment.method + '"]').slideDown();
                    $('[data-method="' + resultPayment.method + '"]').children().slideDown();
                    $('[data-method="' + resultPayment.method + '"]').children().children().slideDown();

                },
                initCheckPaymentDefault: function () {
                    var result = {};
                    var methodName;
                    var selectorCheck;
                    var typePayment;
                    $.each($allowPaymentsData, function (index, value) {
                        if (index == 'pay-pal') {
                            typePayment = 'pay-pal';
                            methodName = 'payment_paypal';
                            selectorCheck = '#payment_paypal';
                            return false;
                        } else if (index == 'bank-deposit') {

                            methodName = 'payment_bank';
                            typePayment = 'bank-deposit';
                            selectorCheck = '#payment_bank';
                            return false;
                        } else if (index == 'api-credit-cards') {

                            methodName = 'payment_payoneer';
                            typePayment = 'api-credit-cards';
                            selectorCheck = '#payment_payoneer';
                            return false;

                        } else if (index == 'pay-phone') {

                            methodName = 'payment_phone';
                            typePayment = 'api-pay-phone';
                            selectorCheck = '#payment_pay_phone';
                            return false;

                        }

                    });
                    result = {
                        'method': methodName,
                        'selectorCheck': selectorCheck,
                        'typePayment': typePayment,

                    }
                    console.log(result);
                    return result;
                }
                ,
                /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                _updateParentByChildren: function (params) {
                    console.log(params);
                }
                , validateForm: function () {
                    var currentAllow = this.getValidateForm();
                    if (this.model.attributes.type_payment == 'api-credit-cards') {
                        var currentAllowPaymentez = this.validatePaymentez();
                        currentAllow.success = currentAllow.success && currentAllowPaymentez.success;

                    }
                    return currentAllow.success;
                },
                _managerEventsUpload: function (params) {
                    var $this = this;
                    var selectorUpload = params['selectorUpload'];
                    var selectorPreview = params['selectorPreview'];
                    var modelCurrent = params['modelCurrent'];
                    var modelAttributeName = params['modelAttributeName'];

                    if (modelCurrent.attributes.id) {
                        var srcSource = modelCurrent.attributes.source;
                        $(selectorPreview).attr("src", srcSource);
                        console.log('_managerEventsUpload update', $this.model.attributes[modelAttributeName]);

                    } else {
                        if ($this.model.attributes[modelAttributeName] == null) {
                            var srcSource = emptyManagerImage;
                            $(selectorPreview).attr("src", srcSource);
                            console.log('_managerEventsUpload CREATE NULL', $this.model.attributes[modelAttributeName]);

                        } else {
                            console.log('_managerEventsUpload CREATE NOT NULL SELECT', $this.model.attributes[modelAttributeName]);

                            let file = $this.model.attributes[modelAttributeName];
                            var srcSourceManager = $.UploadUtil.upload({
                                typeUpload: 'image',
                                generateManager: 'generateImage',
                                'fileElement': file

                            });

                            if (srcSourceManager.success) {
                                let srcSource = srcSourceManager.result;
                                $(selectorPreview).attr("src", srcSource);

                            }

                        }

                    }
                    $(selectorUpload).change(function () {
                        console.log('entro ahora si load', $this.model.attributes[modelAttributeName]);
                        var file = $(this)[0].files[0];

                        var srcSourceManager = $.UploadUtil.upload({
                            typeUpload: 'image',
                            generateManager: 'generateImage',
                            'fileElement': $(this)[0].files
                        });

                        if (srcSourceManager.success) {
                            var srcSource = srcSourceManager.result;
                            $(selectorPreview).attr("src", srcSource);
                            if ($this.model.attributes.id) {
                                $this.model.attributes.change = true;
                            }
                            $this.model.attributes[modelAttributeName] = file;
                            let managerValid = $this.getAllowFormPayment();
                            $this.sendAllowStatus({
                                "type": "validForm",
                                'typePayment': $this.model.attributes.type_payment,
                                "data": managerValid
                            });


                            $this.depositAux = file;

                        }

                        return false;
                    });


                },
                getNameAttribute: function (name) {
                    var result = this.formConfig.nameModel + "[" + name + "]";
                    return result;
                },
                getLabelForm: viewGetLabelForm,
                //uploads methods
                _uploadDataImage: function (eventSelector) {

                    var selectorFile = '#file-' + 'deposit' + '-' + this.typeName;
                    $(selectorFile).click();
                    eventSelector.stopPropagation();
                },
                getAttributesManagerUpload: function (params) {
                    var nameField = params['nameField'];
                    var modelCurrent = params['modelCurrent'];

                    var result = {
                        'selectorUpload': '#file-' + nameField + '-' + this.typeName,
                        'selectorPreview': '#preview-' + nameField + '-' + this.typeName,
                        'modelCurrent': modelCurrent,
                        'modelAttributeName': nameField,
                    };

                    return result;
                },
                getIdManagerUploads: function (type) {
                    var result = '';
                    if (type == 0) {//preview
                        result = 'preview-deposit-' + this.typeName;
                    } else if (type == 1) {//input file
                        result = 'file-deposit-' + this.typeName;
                    } else if (type == 2) {//manager upload progress
                        result = 'progress-deposit-' + this.typeName;
                    }
                    return result;
                },
                getValidateForm: function () {
                    var success = true;
                    var attributeCurrent = "";

                    var errors = [];
                    if (
                        this.$v.model.attributes.accept_terms.$invalid ||
                        this.$v.model.attributes.payment_bank.$invalid ||
                        this.$v.model.attributes.payment_pay_phone.$invalid ||

                        this.$v.model.attributes.payment_payoneer.$invalid ||
                        this.$v.model.attributes.payment_paypal.$invalid ||
                        this.$v.model.attributes.accept_terms.$model == false ||
                        this.$v.model.attributes.type_payment.$invalid ||
                        this.$v.model.attributes.first_name.$invalid ||
                        this.$v.model.attributes.last_name.$invalid ||
                        this.$v.model.attributes.payer_email.$invalid ||
                        this.$v.model.attributes.phone.$invalid ||
                        this.$v.model.attributes.company.$invalid ||
                        this.$v.model.attributes.address_main.$invalid ||
                        this.$v.model.attributes.address_secondary.$invalid ||
                        this.$v.model.attributes.state_province_id.$invalid ||
                        this.$v.model.attributes.country_id.$invalid ||

                        this.$v.model.attributes.zipcode.$invalid ||
                        this.$v.model.attributes.city.$invalid ||
                        this.$v.model.attributes.document.$invalid ||
                        this.$v.model.attributes.deposit.$invalid ||

                        this.$v.model.attributes.billing_first_name.$invalid ||
                        this.$v.model.attributes.billing_last_name.$invalid ||
                        this.$v.model.attributes.billing_payer_email.$invalid ||
                        this.$v.model.attributes.billing_phone.$invalid ||
                        this.$v.model.attributes.billing_company.$invalid ||
                        this.$v.model.attributes.billing_address_main.$invalid ||
                        this.$v.model.attributes.billing_address_secondary.$invalid ||
                        this.$v.model.attributes.billing_state_province_id.$invalid ||
                        this.$v.model.attributes.billing_zipcode.$invalid ||
                        this.$v.model.attributes.billing_city.$invalid ||
                        this.$v.model.attributes.billing_document.$invalid ||
                        this.$v.model.attributes.email.$invalid

                    ) {
                        if (this.$v.model.attributes.accept_terms.$invalid || this.$v.model.attributes.accept_terms.$model == false) {
                            errors.push({
                                "fields": ["accept_terms"]
                            });
                        }
                        if (this.$v.model.attributes.deposit.$invalid) {
                            errors.push({
                                "fields": ["deposit"]
                            });
                        }
                        if (this.$v.model.attributes.payment_bank.$invalid) {
                            errors.push({
                                "fields": ["payment_bank"]
                            });
                        }
                        if (this.$v.model.attributes.payment_pay_phone.$invalid) {
                            errors.push({
                                "fields": ["payment_pay_phone"]
                            });
                        }
                        if (this.$v.model.attributes.payment_payoneer.$invalid) {
                            errors.push({
                                "fields": ["payment_payoneer"]
                            });
                        }
                        if (this.$v.model.attributes.payment_paypal.$invalid) {
                            errors.push({
                                "fields": ["payment_paypal"]
                            });
                        }
                        if (this.$v.model.attributes.type_payment.$invalid) {
                            errors.push({
                                "fields": ["type_payment"]
                            });
                        }
                        if (this.$v.model.attributes.zipcode.$invalid) {
                            errors.push({
                                "fields": ["zipcode"]
                            });
                        }
                        if (this.$v.model.attributes.state_province_id.$invalid) {
                            errors.push({
                                "fields": ["state_province_id"]
                            });
                        }
                        if (this.$v.model.attributes.country_id.$invalid) {
                            errors.push({
                                "fields": ["country_id"]
                            });
                        }
                        if (this.$v.model.attributes.address_secondary.$invalid) {
                            errors.push({
                                "fields": ["address_secondary"]
                            });
                        }
                        if (this.$v.model.attributes.city.$invalid) {
                            errors.push({
                                "fields": ["city"]
                            });
                        }
                        if (this.$v.model.attributes.address_main.$invalid) {
                            errors.push({
                                "fields": ["address_main"]
                            });
                        }
                        if (this.$v.model.attributes.company.$invalid) {
                            errors.push({
                                "fields": ["company"]
                            });
                        }
                        if (this.$v.model.attributes.phone.$invalid) {
                            errors.push({
                                "fields": ["phone"]
                            });
                        }
                        if (this.$v.model.attributes.payer_email.$invalid) {
                            errors.push({
                                "fields": ["payer_email"]
                            });
                        }
                        if (this.$v.model.attributes.last_name.$invalid) {
                            errors.push({
                                "fields": ["last_name"]
                            });
                        }
                        if (this.$v.model.attributes.first_name.$invalid) {
                            errors.push({
                                "fields": ["first_name"]
                            });
                        }
                        if (this.$v.model.attributes.document.$invalid) {
                            errors.push({
                                "fields": ["document"]
                            });
                        }

                        if (this.$v.model.attributes.billing_zipcode.$invalid) {
                            errors.push({
                                "fields": ["billing_zipcode"]
                            });
                        }
                        if (this.$v.model.attributes.billing_state_province_id.$invalid) {
                            errors.push({
                                "fields": ["billing_state_province_id"]
                            });
                        }
                        if (this.$v.model.attributes.billing_address_secondary.$invalid) {
                            errors.push({
                                "fields": ["billing_address_secondary"]
                            });
                        }
                        if (this.$v.model.attributes.billing_city.$invalid) {
                            errors.push({
                                "fields": ["billing_city"]
                            });
                        }
                        if (this.$v.model.attributes.billing_address_main.$invalid) {
                            errors.push({
                                "fields": ["billing_address_main"]
                            });
                        }
                        if (this.$v.model.attributes.billing_company.$invalid) {
                            errors.push({
                                "fields": ["billing_company"]
                            });
                        }
                        if (this.$v.model.attributes.billing_phone.$invalid) {
                            errors.push({
                                "fields": ["billing_phone"]
                            });
                        }
                        if (this.$v.model.attributes.billing_payer_email.$invalid) {
                            errors.push({
                                "fields": ["billing_payer_email"]
                            });
                        }
                        if (this.$v.model.attributes.billing_last_name.$invalid) {
                            errors.push({
                                "fields": ["billing_last_name"]
                            });
                        }
                        if (this.$v.model.attributes.billing_first_name.$invalid) {
                            errors.push({
                                "fields": ["billing_first_name"]
                            });
                        }
                        if (this.$v.model.attributes.billing_document.$invalid) {
                            errors.push({
                                "fields": ["billing_document"]
                            });
                        }
                        if (this.$v.model.attributes.email.$invalid) {
                            errors.push({
                                "fields": ["email"]
                            });

                        }


                        success = false;
                    }
                    var result = {
                        success: success,
                        errors: errors
                    };
                    return result;
                },
                getValuesPaymentez: function (params) {
                    var typGetData = params['typGetData'];
                    var idGen = new Generator();
                    var uid = "uid" + idGen.getId();

                    var result = {};
                    if (typGetData == 'modal') {
                        var customerData = $utilCustomer.getUserCurrentInformation;
                        var dataCart = {
                            params: getDataShopExecute({typeManager: 'paymentez'}),
                            manager_id: customerData['Customer'].manager_id
                        };
                        var totalCurrent = parseFloat(dataCart['params'].OrderShopping.total) + parseFloat(dataCart['params'].OrderShopping.shipping);
                        var order_reference = idGen.getId();

                        result = {
                            user_id: uid,
                            user_email: this.model.attributes.payer_email, //optional
                            user_phone: this.model.attributes.phone, //optional
                            order_description: dataCart['params'].OrderShopping.description,
                            order_amount: totalCurrent,
                            order_vat: 0,
                            order_reference: '#' + order_reference,
                            order_taxable_amount: 0
                        };


                        if (dataCart['params'].OrderShopping.has_tax) {
                            var tax_percentage = 12;
                            /*    subtotal_tax_x: resultShop.subtotal_tax_x,
                                    subtotal_tax_0:resultShop.subtotal_tax_0,*/
                            var order_vat = dataCart['params'].OrderShopping.total_tax;
                            var order_taxable_amount = parseFloat(dataCart['params'].OrderShopping.subtotal_tax_x);
                            result['order_vat'] = parseFloat(order_vat);
                            result['order_taxable_amount'] = parseFloat(order_taxable_amount);
                            result['order_tax_percentage'] = tax_percentage;
                        }

                    } else {
                        var session_id = Paymentez.getSessionId();
                        myCard = $(this.payment['api-credit-cards']['selector']);
                        var cardNumber = null;
                        var card = null;

                        var cardType = null
                        var name = null;
                        var expiryMonth = null;
                        var expiryYear = null;
                        var fiscalNumber = null;
                        var validationOption = null;

                        if (myCard.length) {
                            cardNumber = myCard.PaymentezForm('cardNumber');
                            card = myCard.PaymentezForm('card');
                            cardType = myCard.PaymentezForm('cardType');
                            name = myCard.PaymentezForm('name');
                            expiryMonth = myCard.PaymentezForm('expiryMonth');
                            expiryYear = myCard.PaymentezForm('expiryYear');
                            fiscalNumber = myCard.PaymentezForm('fiscalNumber');
                            validationOption = myCard.PaymentezForm('validationOption');
                        }

                        result = {
                            cardNumber: cardNumber,
                            card: card,
                            cardType: cardType,
                            name: name,
                            expiryMonth: expiryMonth,
                            expiryYear: expiryYear,
                            fiscalNumber: fiscalNumber,
                            validationOption: validationOption,
                            session_id: session_id,
                            email: this.model.attributes.payer_email,
                            uid: uid
                        };
                    }

                    return result;
                },
                validatePaymentez: function () {
                    var success = true;
                    var errors = [];
                    if (
                        this.$v.model.attributes.cardNumber.$invalid ||
                        this.$v.model.attributes.card.$invalid ||
                        this.$v.model.attributes.cardType.$invalid ||
                        this.$v.model.attributes.name.$invalid ||
                        this.$v.model.attributes.expiry.$invalid ||
                        this.$v.model.attributes.fiscalNumber.$invalid ||
                        this.$v.model.attributes.validationOption.$invalid ||
                        this.$v.model.attributes.cvc.$invalid

                    ) {
                        if (this.$v.model.attributes.cardNumber.$invalid) {
                            errors.push({
                                'field': 'cardNumber',
                            });
                        }
                        if (this.$v.model.attributes.card.$invalid) {
                            errors.push({
                                'field': 'card',
                            });
                        }
                        if (this.$v.model.attributes.cardType.$invalid) {
                            errors.push({
                                'field': 'cardType',
                            });
                        }
                        if (this.$v.model.attributes.name.$invalid) {
                            errors.push({
                                'field': 'name',
                            });
                        }
                        if (this.$v.model.attributes.expiry.$invalid) {
                            errors.push({
                                'field': 'expiry',
                            });
                        }

                        if (this.$v.model.attributes.fiscalNumber.$invalid) {
                            errors.push({
                                'field': 'fiscalNumber',
                            });
                        }
                        if (this.$v.model.attributes.validationOption.$invalid) {
                            errors.push({
                                'field': 'validationOption',
                            });
                        }
                        if (this.$v.model.attributes.cvc.$invalid) {
                            errors.push({
                                'field': 'cvc',
                            });
                        }

                        success = false;
                    }


                    var result = {success: success, errors: errors};
                    return result;

                },
                _saveModelPaymentez: function () {
                    if ($configPayments['api-credit-cards']['managerTypeModal']) {
                        var dataSend = this.getValuesPaymentez({
                            'typGetData': 'modal'
                        })
                        this.payment['api-credit-cards']['objectButton'].open(dataSend);
                    } else {
                        var cardData = this.getValuesPaymentez({
                            'typGetData': 'notModal'
                        });

                        Paymentez.addCard(cardData.uid, cardData.email, cardData.card, successHandler, errorHandler);
                        var successHandler = function (cardResponse) {
                            console.log(cardResponse.card);
                            if (cardResponse.card.status === 'valid') {
                                $('#messages').html('Card Successfully Added<br>' +
                                    'status: ' + cardResponse.card.status + '<br>' +
                                    "Card Token: " + cardResponse.card.token + "<br>" +
                                    "transaction_reference: " + cardResponse.card.transaction_reference
                                );
                            } else if (cardResponse.card.status === 'review') {
                                $('#messages').html('Card Under Review<br>' +
                                    'status: ' + cardResponse.card.status + '<br>' +
                                    "Card Token: " + cardResponse.card.token + "<br>" +
                                    "transaction_reference: " + cardResponse.card.transaction_reference
                                );
                            } else if (cardResponse.card.status === 'pending') {
                                $('#messages').html('Card Pending To Approve<br>' +
                                    'status: ' + cardResponse.card.status + '<br>' +
                                    "Card Token: " + cardResponse.card.token + "<br>" +
                                    "transaction_reference: " + cardResponse.card.transaction_reference
                                );
                            } else {
                                $('#messages').html('Error<br>' +
                                    'status: ' + cardResponse.card.status + '<br>' +
                                    "message Token: " + cardResponse.card.message + "<br>"
                                );
                            }
                        };

                        var errorHandler = function (err) {
                            console.log(err.error);
                            $('#messages').html(err.error.type);

                        };
                    }


                },
                initPaymentez: function (params) {
                    var elementInit = params['elementInit'];
                    $(elementInit).html("");
                    $(elementInit).not(".checkout").each(function (i, obj) {
                        $(obj).PaymentezForm()
                    });
                    var eventElement = this.payment['api-credit-cards']['selector'];
                    var $this = this;

                    $(eventElement).children().on('classChanged', function (event) {
                        $this._paymentezCreditCar(event);
                    });

                },
                _paymentezCreditCar: function (element) {
                    var classCurrent = '';
                    var keyModelName = '';
                    var allowExpiry = false;
                    var keyModelNameSecond = '';
                    var valueModelCurrent = null;
                    var hasError = $(element.currentTarget).hasClass('has-error');
                    var elementInput = $(element.currentTarget).find('input');
                    classCurrent = elementInput.attr('class');
                    if (classCurrent == 'name') {//name owner

                        keyModelName = 'name';
                        if (hasError == false) {
                            valueModelCurrent = elementInput.val();
                        }
                    } else if (classCurrent == 'card-number') {

                        keyModelName = 'cardNumber';
                        if (hasError == false) {
                            valueModelCurrent = elementInput.val();


                        }
                    } else if (classCurrent == 'expiry') {

                        keyModelName = 'expiry';
                        if (hasError == false) {
                            valueModelCurrent = elementInput.val();

                        }
                    } else if (classCurrent == 'cvc') {

                        keyModelName = 'cvc';
                        if (hasError == false) {
                            valueModelCurrent = elementInput.val();

                        }

                    }
                    this._setValueForm(keyModelName, valueModelCurrent);
                    this.validateForm();
                },
                initModalPaymentez: function () {
                    var $this = this;
                    var paymentezCheckout = new PaymentezCheckout.modal({
                        client_app_code: $configPayments['api-credit-cards']['id'], // Client Credentials Provied by Paymentez
                        client_app_key: $configPayments['api-credit-cards']['secret'], // Client Credentials Provied by Paymentez
                        locale: 'es', // User's preferred language (es, en, pt). English will be used by default.
                        env_mode: $configPayments['api-credit-cards']['env'], // `prod`, `stg` to change environment. Default is `stg`
                        onOpen: function () {
                            console.log('modal open');
                        },
                        onClose: function () {
                            console.log('modal closed');
                        },
                        onResponse: function (response) { // The callback to invoke when the Checkout process is completed
                            console.log(response);
                            /*
                              In Case of an error, this will be the response.
                              response = {
                                "error": {
                                  "type": "Server Error",
                                  "help": "Try Again Later",
                                  "description": "Sorry, there was a problem loading Checkout."
                                }
                              }

                              When the User completes all the Flow in the Checkout, this will be the response.
                              response = {
                                 "transaction": {
                                    "status": "success", // success, failure or pending
                                    "payment_date": "2017-09-26T21:03:04",
                                    "amount": 99.0,
                                    "authorization_code": "148177",
                                    "installments": 1,
                                    "dev_reference": "referencia",
                                    "message": "Operation Successful",
                                    "carrier_code": "6",
                                    "id": "CI-490", // transaction_id
                                    "status_detail": 3 // for the status detail please refer to: https://paymentez.github.io/api-doc/#status-details
                                 },
                                 "card": {
                                    "bin": "453254",
                                    "status": "valid",
                                    "token": "",
                                    "expiry_year": "2020",
                                    "expiry_month": "9",
                                    "transaction_reference": "CI-490",
                                    "type": "vi",
                                    "number": "8311"
                                }
                             }

                            */
                            console.log('modal response', response);

                            if (response.error) {
                                showAlert('warning', response.description);
                            } else if (response.transaction) {
                                if (response.transaction.status == 'success') {

                                    var validateCurrent = $this.validateForm();
                                    var configAjax = {
                                        blockElement: '',
                                        loading_message: 'Registrando Orden.......',
                                        error_message: 'Existe Problemas al realizar orden.',
                                        success_message: 'Se Realizo con exito la orden,se envio un correo electronico informativo de la orden.',
                                        'url': $rootPage + 'executePaymentCreditCards'
                                    };
                                    if (validateCurrent) {
                                        var dataSendResult = getDataShopExecuteString({
                                            typeManager: 'paymentez',
                                            'data': response
                                        });
                                        var dataSend = {'params': dataSendResult};
                                        ajaxRequest(configAjax.url, {
                                            type: 'POST',
                                            data: dataSend,
                                            blockElement: configAjax.blockElement,//opcional: es para bloquear el elemento
                                            loading_message: configAjax.loading_message,
                                            error_message: configAjax.error_message,
                                            success_message: configAjax.success_message,
                                            success_callback: function (response) {
                                                if (response.success) {
                                                    $this.resetForm();
                                                    resetAllCurrent();
                                                    managerCheckoutDetails(response);
                                                } else {
                                                    showAlert('warning', 'Fallo de Compra BACKEND.');
                                                }
                                            }
                                        });
                                    }
                                } else if (response.transaction.status == 'failure') {
                                    showAlert('warning', 'Fallo de Compra :' + response.transaction.message);
                                } else if (response.transaction.status == 'pending') {
                                    showAlert('warning', 'Pendiente la Compra:' + response.transaction.message);

                                } else {
                                    console.log(response);
                                    showAlert('warning', 'Error al realizar el pago.');

                                }

                            }

                        }
                    });
                    window.addEventListener('popstate', function () {
                        console.log('posttate');
                        paymentezCheckout.close();
                    });
                    this.payment['api-credit-cards']['objectButton'] = paymentezCheckout;
                },
                _viewPolicies: function () {
                    var value = $(".policies").attr('style');
                    if (value == 'display: none;') {
                        this.managerInitGet['policies']['view'] = true;

                        $('[data-method="accept_terms"]').children().slideDown();
                        $('[data-method="accept_terms"]').children().children().children().slideDown();
                    } else {
                        $('[data-method="accept_terms"]').children().slideUp();
                        $('[data-method="accept_terms"]').children().children().children().slideUp();
                        this.managerInitGet['policies']['view'] = false;
                    }
                }, labelPolicies: function () {
                    var result = '';
                    var value = this.managerInitGet['policies']['view'];
                    if (!value) {
                        result = 'Ver';
                    } else {
                        result = 'Ocultar';

                    }
                    return result;
                },
                initPaypal: function () {

                },
                getClassContainerPaypal: function () {
                    var managerPayPal = this.validateForm();
                    var result = {
                        "disabled-container": !managerPayPal,
                        "enabled-container": managerPayPal,

                    };
                    return result;

                },
                onReceiveCheckoutByChildrenOf: function (params) {
                    console.log(params);


                },
                sendAllowStatus(params) {
                    console.log('deposit verify si existe', this.model.attributes['deposit']);
                    if (this.depositAux != null && this.model.attributes['deposit'] == null) {
                        this.model.attributes['deposit']=this.depositAux;
                    }
                    this.$emit('update-checkout-status', params);
                },
                getAllowFormPayment: function () {
                    let result = {
                        success: false,
                        data: [],
                        errors: []
                    };

                    var currentAllow = this.getValidateForm();
                    if (this.model.attributes.type_payment == 'api-credit-cards') {
                        var currentAllowPaymentez = this.validatePaymentez();
                        currentAllow.success = currentAllow.success && currentAllowPaymentez.success;

                    }
                    result.success = currentAllow.success;
                    result.errors = currentAllow.errors;
                    return result;
                },
                managerSaveCheckout: function (params) {
                    if (this.model.attributes.type_payment == 'pay-pal') {

                    } else if (this.model.attributes.type_payment == 'bank-deposit') {
                        this._saveModelBankDeposit();
                    } else if (this.model.attributes.type_payment == 'payment_pay_phone') {
                        this._saveModelPayPhone();

                    } else if (this.model.attributes.type_payment == 'api-credit-cards-modal-paymentez') {
                        this._saveModelPaymentez();

                    }
                }

            },

        })
        ;


    </script>
    <script type="text/x-template" id="payment-type-bank-deposit-template">
        <div>
            <div>

            </div>
        </div>

    </script>
    <script type='text/x-template' id='template-payments-template'>
        <div>
            @if($dataManagerPage['shopConfig']['allow'])
                <div class="row g-0 " id="manager-shop-products" v-if="managerData.data.length>0">
                    <div class="col-lg-12 pe-lg-12">
                        <div class="row osahan-my-account-page border-secondary-subtle g-0 overflow-hidden">
                            <div class="col-lg-4 border-end">
                                <div class="nav my-account-pills w-100 border-bottom justify-content-center bg-white"
                                     id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    @if($dataManagerPage['shopConfig']["data"]["api-credit-cards"]!==null)
                                        <button class="nav-link {{$activeCreditCards}} d-flex flex-column small"
                                                id="v-pills-my-address-tab"
                                                data-bs-toggle="pill" data-bs-target="#v-pills-my-address" type="button"
                                                role="tab" aria-controls="v-pills-my-address" aria-selected="true"><i
                                                class="lni lni-wallet"></i> Wallets
                                        </button>
                                    @endif

                                    @if($dataManagerPage['shopConfig']["data"]["pay-pal"]!==null)
                                        <button class="nav-link {{$activePayPal}} d-flex flex-column small"
                                                id="v-pills-my-wallet-tab"
                                                data-bs-toggle="pill" data-bs-target="#v-pills-my-wallet" type="button"
                                                role="tab" aria-controls="v-pills-my-wallet" aria-selected="false"><i
                                                class="lni lni-world"></i> Pay Pal
                                        </button>
                                    @endif
                                    @if($dataManagerPage['shopConfig']["data"]["bank-deposit"]!==null)
                                        <button class="nav-link {{$activeBankDeposit}} d-flex flex-column small"
                                                id="v-pills-my-wallet-tab33"
                                                data-bs-toggle="pill" data-bs-target="#v-pills-my-wallettab33"
                                                type="button"
                                                role="tab" aria-controls="v-pills-my-wallettab33" aria-selected="false">
                                            <i
                                                class="lni lni-handshake"></i> Deposito Bancario
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8 bg-light">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <b-form id="checkout-form" @submit="_submitForm">

                                        <input id="shop-subtotal" type="hidden" name="OrderShopping[subtotal]">
                                        <input id="shop-description" type="hidden" name="OrderShopping[description]">
                                        <input id="shop-shipping" type="hidden" name="OrderShopping[shipping]">
                                        <input id="shop-data" type="hidden" name="OrderBillingDetails[data]">

                                        @if($dataManagerPage['shopConfig']["data"]["api-credit-cards"]!==null)
                                            <div class="p-3 tab-pane   {{$activeCreditCardsContent}} fade"
                                                 id="v-pills-my-order" role="tabpanel"
                                                 tabindex="0">
                                                <div
                                                    class="d-flex align-items-center justify-content-between w-100 mb-3">
                                                    <h5 class="m-0">Add Credit, Debit & Atm Cards</h5>
                                                </div>
                                                <div class="wallet-card">
                                                    <div class="d-flex align-items-center gap-2 mb-3">
                                                        <img src="{{$sourceSuccessOther}}img/svg/p5.svg" alt=""
                                                             class="img-fluid checkout-img">
                                                        <img src="{{$sourceSuccessOther}}svg/p8.svg" alt=""
                                                             class="img-fluid checkout-img">
                                                        <img src="{{$sourceSuccessOther}}svg/p4.svg" alt=""
                                                             class="img-fluid checkout-img">
                                                        <img src="{{$sourceSuccessOther}}svg/p3.svg" alt=""
                                                             class="img-fluid checkout-img">
                                                    </div>
                                                    <form>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control"
                                                                   placeholder="card name"
                                                                   value="Mastercard">
                                                            <label>Name on Card</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="number" class="form-control"
                                                                   placeholder="card number"
                                                                   value="34234769302">
                                                            <label>Card Number</label>
                                                        </div>
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-8">
                                                                <div class="form-floating">
                                                                    <input type="date" class="form-control">
                                                                    <label>Card Number</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-floating">
                                                                    <input type="number" class="form-control"
                                                                           placeholder="cvv"
                                                                           value="8643">
                                                                    <label>CVV</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control"
                                                                   placeholder="card nickmane"
                                                                   value="mr singh">
                                                            <label>Nickname for card</label>
                                                        </div>
                                                        <a href="#" class="btn btn-danger py-2 w-100">Checkout</a>
                                                    </form>
                                                    <p class="text-muted pt-3 m-0">We accept Credit and Debit Cards from
                                                        Visa,
                                                        Mastercard, American
                                                        Express, Diners, Rupay & Sodexo.
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($dataManagerPage['shopConfig']["data"]["pay-pal"]!==null)
                                            <div class="p-3 tab-pane  {{$activePayPalShowContent}} fade"
                                                 id="v-pills-my-wallet" role="tabpanel"
                                                 tabindex="0">
                                                <div
                                                    class="d-flex align-items-center justify-content-between w-100 mb-3">
                                                    <h5 class="m-0">Netbanking</h5>
                                                </div>
                                                <div
                                                    class="row row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-2 g-3">
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1g">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1g"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p8.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    HDFC <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1f">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1f"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p7.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    ICICI <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1d">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1d"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p6.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    AXIS <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1w">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1w"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p5.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    KOTAK <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1q">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1q"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p4.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    SBI <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1ff">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1ff"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p3.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    ICICI <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1df">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1df"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p2.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    AXIS <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1wd">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1wd"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p1.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    KOTAK <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div
                                                            class="form-check osahan-radio-box osahan-netbanking w-100 bg-white border p-3 rounded-4">
                                                            <input class="form-check-input" type="radio"
                                                                   name="flexRadioDefaultn"
                                                                   id="flexRadioDefault1qe">
                                                            <label class="form-check-label"
                                                                   for="flexRadioDefault1qe"></label>
                                                            <div class="osahan-radio-box-inner">
                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <img src="{{$sourceSuccessOther}}svg/p3.svg" alt=""
                                                                         class="img-fluid">
                                                                </div>
                                                                <p class="mb-0 d-flex align-items-center justify-content-between">
                                                                    SBI <i class="lni lni-arrow-right"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                        @if($dataManagerPage['shopConfig']["data"]["bank-deposit"]!==null)

                                            <div class="tab-pane  {{$activeBankDepositContent}} fade"
                                                 id="v-pills-my-wallettab33" role="tabpanel"
                                                 tabindex="0">

                                                <div
                                                    class="d-flex align-items-center justify-content-between w-100 mb-3">

                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12  mb-2 mb-lg-0">
                                                    @include('eatPura.web.checkoutSteps.step1',array())

                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2 mb-lg-0">
                                                    @include('eatPura.web.checkoutSteps.step2',array())

                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12  mb-2 mb-sm-0">
                                                    @include('eatPura.web.checkoutSteps.step3',array())

                                                </div>

                                                <img src="{{$sourceSuccessOther}}/img/cod.png" alt="" class="img-fluid">
                                            </div>

                                        @endif
                                    </b-form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row g-0">
                <div class="empty-data col-md-12" id="empty-products" v-if="managerData.data.length==0">

                    {{__('messages.empty')}}
                </div>
                <div class="empty-data  col-md-12" id="empty-products-loading">
                    {{__('messages.loading')}}
                </div>
            </div>
        </div>
    </script>
@endsection


@section('additional-scripts-vue-before')
    <script>
        $methodsShopPage.onInitDataCheckoutPage = onInitDataCheckoutPage;

        $(window).on('load', function () {

        });

        function onInitDataCheckoutPage() {

        }


    </script>

@endsection
@section('content-manager')
    <div class="actions">

        <input id="action_load_products_shop" type="hidden"
               value="{{ route('getProductShopAdmin',app()->getLocale()) }}"/>
        <input id="action-users-emailUniqueCheckout" type="hidden"
               value="{{ route('validateEmailCheckout',app()->getLocale()) }}"/>
    </div>

    @if($dataManagerPage['shopConfig']['allow'])
        <section class="py-0">
            <div class="container p-0">
                <template-payments-component
                    v-if="dataManagerProductsShopCart.data.length>0"
                    ref='refTemplatePayments'
                    :params='dataManagerProductsShopCart'
                    @update-checkout-status="onReceiveCheckoutByChildren"
                    v-on:_templatePayments-emit="_updateParentByChildren($event)"
                >

                </template-payments-component>
            </div>
        </section>
    @else
        <div class="content-all">

            <img class="img-full-manager" src="{{$sourceNotPayment}}">
        </div>

    @endif

@endsection
@section('additional-modal')
    <div class="offcanvas offcanvas-bottom border-0 h-100" tabindex="-1" id="orderconfirm">
        <div class="offcanvas-body d-flex align-items-center justify-content-center">
            <div class="text-center">
                <img src="{{ $sourceSuccess }}" alt="" class="img-fluid w-25">
                <h5 class="fw-bold pt-2 mb-4 lh-base">Your Order Is recived.<br>Delivery Soon</h5>
                <a href="{{ route("userAccount", app()->getLocale()) }}"
                   class="btn fw-bold py-2 px-4 btn-danger mt-auto rounded-pill">My Account</a>
            </div>
            <a href="{{ route("userAccount", app()->getLocale()) }}" class="stretched-link"></a>
        </div>
    </div>
@endsection
@if($dataManagerPage['shopConfig']['allow'])
    @section('additional-button-checkout')
        <div class="p-3 bg-white mt-auto">
            <a
                v-if="dataManagerProductsShopCart.data.length>0"
                id="manager-checkout-save"
                :class="getClassCheckout()"

                v-on:click="onSaveCheckout()"
                class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow"
            >Pay Now


            </a>
        </div>
    @endsection
@endif
