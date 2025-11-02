var payPalButton = null;
var myCard;
var $allowTaxManager = false;

function initUtilsManager() {
    var $UtilCustomer = $managerUtils['UtilCustomer'];
    $utilCustomer = new $UtilCustomer($customerData);
}

function managerPayment(typePayment) {
    var result = false;
    $.each($allowPaymentsData, function (index, value) {
        if (index == typePayment) {
            result = true;
            return result;
        }

    });

    return result;
}

function getOrderBillingCustomer() {
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
        type_payment_customer: getCheckedTypePayment(),
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

function getUser() {
    var create_account = $('#create_account').prop("checked") == undefined ? false : $('#create_account').prop("checked");
    var result = {
        create_account: create_account,
        email: create_account ? $('#email').val() : 'none',
        'id': $utilCustomer.getCustomer.manager_id
    };
    return result;
}

function getDataShopExecute(params) {
    var typeManager = params['typeManager'];
    var result = billingStructure();
    if (typeManager == 'payPal') {
        var dataPayment = params['data'];
        result['Payment'] = {
            id: dataPayment.paymentID,
            payerID: dataPayment.payerID
        };
    } else if (typeManager == 'paymentez') {
        result['Payment'] = params['data'];
    }
    console.log('getDataShopExecute', result);

    return result;

}

function billingStructure() {
    var itemsShopCurrent = getItemsShop();
    var resultShop = getItemsResultShop(itemsShopCurrent);

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
    var OrderBillingCustomer = getOrderBillingCustomer();
    var User = getUser();
    var result = {
        User: User,
        OrderShopping: OrderShopping,
        OrderBillingDetails: OrderBillingDetails,
        OrderBillingCustomer: OrderBillingCustomer,

    };
    return result;
}

function getDataShopExecuteString(params) {
    var typeManager = params['typeManager'];
    if (typeManager == 'payPal') {
    } else if (typeManager == 'paymentez') {

    }
    return JSON.stringify(getDataShopExecute(params));
}

function getDataShop() {

    var result = billingStructure();
    return JSON.stringify(result);
}

function getCheckedTypePayment() {
    var typesPaymentSelectors = [
        '#payment_bank',
        '#payment_payoneer',
        '#payment_paypal',
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

            }
        }
    });
    return result;
}


function viewCartPage(itemsShop) {
    if (itemsShop.length > 0) {
        getViewsRowProduct({data: itemsShop})
        if (!$('#empty-products').hasClass('not-view')) {
            $('#empty-products').addClass('not-view');
        }
        $('#manager-shop-products').removeClass('not-view');
        $('#empty-products-loading').addClass('not-view');

        var itemsShopCurrent = getItemsShop();
        var resultShop = getItemsResultShop(itemsShopCurrent);

        $('.subtotal').html(resultShop.subtotal);
        var shipPrice = 0;
        var total = parseFloat(shipPrice) + parseFloat(resultShop.subtotal);
        $('.total').html('$' + total);
        $('.shipping').html('$' + shipPrice);

        var shopData = JSON.stringify(itemsShop);
        $('#shop-subtotal').val(resultShop.subtotal);
        var shopDescription = 'Pago de Productos de Carrito de Compras';
        $('#shop-description').val(shopDescription);
        $('#shop-shipping').val(shipPrice);
        $('#shop-data').val(shopData);

    } else {
        $('#empty-products').removeClass('not-view');
        if (!$('#manager-shop-products').hasClass('not-view')) {
            $('#manager-shop-products').addClass('not-view');
        }
        $('#empty-products-loading').addClass('not-view');
    }
}

function getRowCartProduct(data) {
    $languageCurrent = $language == 'es' ? null : $language;

    var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
    nameProduct = nameProduct ;



    var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);
    var nameProductDetails = nameProduct + ' X ' + data.count;
    var result = [
        '<li id="li-cart-' + data.id + '" product-id="' + data.id + '">',
        nameProductDetails,
        '<span>$' + data.price + '</span>',
        '</li>'
    ];
    result = result.join('');
    return result;
}

function deleteRowCartCheckout(params) {
    var rowId = params['rowId'];
    var selectorRow = $('#li-cart-' + rowId);
    selectorRow.remove();
    var itemsShop = getItemsShop();
    viewCartPage(itemsShop);
}

function getViewsRowProduct($params) {
    var data = $params['data'];
    var viewTax = false;
    var totalTax = 0;
    if (!$('.tr-tax').hasClass('not-view')) {
        $('.tr-tax').addClass('not-view')
    }
    $.each(data, function (index, value) {

        var htmlRow = getRowCartProduct(value);
        $('.products-list').append(htmlRow);
        if (value.has_tax) {
            var managerProduct = getTotalManagerProduct(value);
            totalTax += parseFloat(managerProduct.total_tax);
            viewTax = true;
        }
    });
    if (viewTax) {
        $('.tr-tax').removeClass('not-view');
        totalTax = totalTax.toFixed(2);
        $('.tax-total').html(totalTax);
    }
}

var emptyManagerImage = 'https://image.shutterstock.com/image-vector/picture-vector-icon-no-image-260nw-1350441335.jpg';
var appThisComponent = null;
var appInit = new Vue(
    {
        el: '#app-management',
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

                var dataManagerShopping = allowManagerShopping();
                var itemsShop = dataManagerShopping.data;
                viewCartPage(itemsShop);
                initUtilsManager();
                $this.loadPage = true;
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
            });
        },

        validations: function () {
            var attributes = {

                "accept_terms": {required},
                "payment_bank": {},
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
                titles: {typePayments: 'Metodos De Pago'},
                model: {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm(),
                },
                typeName: 'main-deposit',
                formConfig: {
                    nameSelector: "#source-logo-main-form",
                    url: '/executePaymentBankEvents',
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

                    "accept_terms": null,
                    "payment_bank": null,
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
                    name == "payment_paypal") {
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
                var params = getDataShop();
                var type_payment = this.$v.model.attributes.$model.type_payment;
                var customerData = $utilCustomer.getUserCurrentInformation;
                var result = {
                    params: params,
                    type_payment: type_payment,
                    manager_id: customerData['Customer']['manager_id']
                };
                if (type_payment == 'bank-deposit') {
                    result['source'] = this.$v.model.attributes.$model.deposit;
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
            resetForm: function () {
                this.$v.$reset();
                this.model = {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm()
                };
                this.initManagement();
                $('[data-method="accept_terms"]').slideUp();
            },
            _saveModel: function () {

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

                                resetAll();
                                managerCheckoutDetails(response);
                            }
                        }
                    }, true);
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

                    }

                });
                result = {
                    'method': methodName,
                    'selectorCheck': selectorCheck,
                    'typePayment': typePayment,

                }
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
                if (modelCurrent.attributes.id) {
                    var srcSource = modelCurrent.attributes.source;
                    $(selectorPreview).attr("src", srcSource);
                } else {
                    var srcSource = emptyManagerImage;
                    $(selectorPreview).attr("src", srcSource);
                }
                var modelAttributeName = params['modelAttributeName'];
                $(selectorUpload).change(function () {
                    var file = $(this)[0].files[0];

                    var srcSourceManager = $.UploadUtil.upload({
                        typeUpload: 'image',
                        generateManager: 'generateImage',
                        'fileElement': $(this)[0].files

                    });

                    if (srcSourceManager.success) {
                        var srcSource = srcSourceManager.result;
                        $(selectorPreview).attr("src", srcSource);
                        $this.model.attributes[modelAttributeName] = file;
                        if ($this.model.attributes.id) {
                            $this.model.attributes.change = true;

                        }
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
                                    'url': '/executePaymentCreditCardsEvents'
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
                                                resetAll();
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

            }

        },

    })
;
appInit.initManagement();

