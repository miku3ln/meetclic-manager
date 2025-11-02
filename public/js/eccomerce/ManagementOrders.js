//STEP 1
var selectorGrid = '#product-grid';
var configElementOrders = {
    managerItems: {
        one: '.minicart-wrapper__items',
        two: '.management-orders__manager-list',
    },
    managerItem: {
        one: '.minicart-wrapper__items__single',
        two: '.management-orders__manager-item',
    },
    empty: '.empty-items',
    'amount': '.management-orders__information-data-amount-em',
    results: {
        one: '.subtotal',
        two: '.management-orders__manager-results-total-val',
    },
    'update': {
        'row-item': {
            one: 'span.count',
            two: '.management-orders__manager-qty',

        }

    }

};
var notClass = [
    //management-orders
    'administration-cart cart-link',
    'fa fa-shopping-basket',
    'management-orders__head',
    'management-orders__manager-list',
    'empty-items',
    'administration-cart cart-link btn--link',
    'management-orders__manager-results-total-val',
    "management-orders__manager-results-total",
    "theme-button theme-button--alt theme-button--minicart-button theme-button--minicart-button--alt mb-0",
    "theme-button theme-button--minicart-button",
    "management-orders__manager-items",
    ('administration-cart'),
    'a-cart-basket__item-count',
    "item-count item-count--shopping-basket",
    'cart-link administration-cart', 'fa fa-shopping-bag',
    'cart-count',
    'fa fa-times'
];

function getItemsShop() {
    var result = [];
    var shopData = localStorage.getItem('shop');
    shopData = JSON.parse(shopData);
    $.each(shopData, function (index, value) {
        result.push(value);
    });

    return result;
}

function verifyAdministrationCart() {
    if (!$('html').hasClass('cart-show')) {
        $('html').addClass('cart-show');
    } else {
        $('html').removeClass('cart-show');

    }
}

function _cart() {
    $('.administration-cart').on('click', function (e) {
        verifyAdministrationCart();

    });

    $('body').click(function (e) {
        var needleFound = $.inArray(e.target.className, notClass);
        if (needleFound == -1) {
            if ($('html').hasClass('cart-show')) {
                $('html').removeClass('cart-show');
            }
        }

    });
}

$(function () {
    _cart();
    initViewDataLocalStorage();
    _managerItemsOrders();
});

function initViewDataLocalStorage() {
    if ($cookiesManager['init_cart'] == 'allow' || $cookiesManager['init_cart'] == null) {
        if (!localStorage.getItem('shop')) {
            var managerData = [];
            localStorage.setItem('shop', JSON.stringify(managerData));
        }

        if (!localStorage.getItem('businessManagement')) {
            var managerData = [];
            localStorage.setItem('businessManagement', JSON.stringify(managerData));
        }
    } else {
        localStorage.removeItem('shop');
        localStorage.removeItem('businessManagement');

    }
    viewDataShop();
}


function validateGetValues(params) {
    var typeSet = params['typeSet'];
    var amount = params['amount'];
    var product = params['product'];
    var typeManagement = null;
    var typeManagementName = '';
    var success = true;
    var data = [];
    var msg = 'Error';
    var errors = [];
    var allowColor = product['colors'].length ? true : false;
    var allowSize = product['sizes'].length ? true : false;
    if (amount == 0) {
        errors.push({
            'msg': 'Cantidad debe ser mayor a 0', 'field': 'amount'

        });
    }
    if (typeSet == 'add-cart--product-details') {

        if (allowColor) {
            var hasErrorColor = true;
            var colorId = null;
            var colorName = null;

            $.each($('.color-manager'), function (index, value) {
                var itemColorObject = $(value).find('a.active');
                if (itemColorObject.length) {
                    hasErrorColor = false;
                    var managerIdData = $(value).attr('id').split('-');
                    colorId = managerIdData[1];
                    colorName = itemColorObject.attr('data-tippy');
                }
            });
            if (hasErrorColor) {
                errors.push({
                    'msg': 'Seleccione por lo menos un tamaño.', 'field': 'color'

                });

            } else {
                data['product_color'] = colorName;
                data['product_color_id'] = colorId;
            }

        }
        if (allowSize) {
            if ($('#product-size__select').val() == '' || $('#product-size__select').val() == null || $('#product-size__select').val() == undefined) {
                errors.push({
                    'msg': 'Seleccione por lo menos un tamaño.', 'field': 'size'
                });
            } else {
                data['product_sizes'] = $("#product-size__select option:selected").text();
                data['product_sizes_id'] = $("#product-size__select").val();

            }

        }

    } else if (typeSet == 'add-cart-preview') {//preview
        if (allowColor) {
            var hasErrorColor = true;
            var colorId = null;
            var colorName = null;

            $.each($('.color-manager-quick-view'), function (index, value) {
                var itemColorObject = $(value).find('a.active');
                if (itemColorObject.length) {
                    hasErrorColor = false;
                    var managerIdData = $(value).attr('id').split('-');
                    colorId = managerIdData[1];
                    colorName = itemColorObject.attr('data-tippy');
                }
            });
            if (hasErrorColor) {
                errors.push({
                    'msg': 'Seleccione por lo menos un tamaño.', 'field': 'color'

                });

            } else {
                data['product_color'] = colorName;
                data['product_color_id'] = colorId;
            }

        }
        if (allowSize) {
            if ($('.product-size__items').val() == '' || $('.product-size__items').val() == null || $('.product-size__items').val() == undefined) {
                errors.push({
                    'msg': 'Seleccione por lo menos un tamaño.', 'field': 'size'
                });
            } else {
                data['product_sizes'] = $(".product-size__items option:selected").text();
                data['product_sizes_id'] = $(".product-size__items").val();

            }

        }


    } else if (typeSet == 'add-cart-manager') {//grid row
        if (allowColor || allowSize) {
            typeManagement = 3;
            errors.push({
                'msg': 'Gestion de Preview Product Tipo Color o Medidas', 'field': 'size'

            });
        } else if (allowColor == false || allowSize == false) {
            if (allowColor == false && allowSize == false) {
                typeManagement = 6;
                typeManagementName = typeSet + '-' + typeManagement;

            } else if (allowColor == false && allowSize == true) {
                typeManagement = 7;
                typeManagementName = typeSet + '-' + typeManagement;

            } else if (allowColor == true && allowSize == false) {
                typeManagement = 8;
                typeManagementName = typeSet + '-' + typeManagement;

            }
        }

    } else if (typeSet == 'add-cart-manager-outlets') {//grid row
        if (allowColor || allowSize) {
            typeManagement = 4;
            errors.push({
                'msg': 'Gestion de Preview Product Tipo Color o Medidas', 'field': 'size'

            });
        } else if (allowColor == false || allowSize == false) {
            if (allowColor == false && allowSize == false) {
                typeManagement = 9;
                typeManagementName = typeSet + '-' + typeManagement;

            } else if (allowColor == false && allowSize == true) {
                typeManagement = 10;
                typeManagementName = typeSet + '-' + typeManagement;

            } else if (allowColor == true && allowSize == false) {
                typeManagement = 11;
                typeManagementName = typeSet + '-' + typeManagement;

            }
        }

    } else if (typeSet == 'add-cart-manager-balances') {//grid row
        if (allowColor || allowSize) {
            typeManagement = 5;
            errors.push({
                'msg': 'Gestion de Preview Product Tipo Color o Medidas', 'field': 'size'

            });
        } else if (allowColor == false || allowSize == false) {
            if (allowColor == false && allowSize == false) {
                typeManagement = 12;
                typeManagementName = typeSet + '-' + typeManagement;

            } else if (allowColor == false && allowSize == true) {
                typeManagement = 13;
                typeManagementName = typeSet + '-' + typeManagement;

            } else if (allowColor == true && allowSize == false) {
                typeManagement = 14;
                typeManagementName = typeSet + '-' + typeManagement;

            }
        }

    }
    success = errors.length > 0 ? false : true;
    if (!success) {
        var errorsView = [];
        $.each(errors, function (index, value) {
            errorsView.push('-' + value.msg + '<br>');
        });
        errorsView = errorsView.join('');
        msg = errorsView;
    }
    var result = {
        success: success,
        data: data,
        msg: msg,
        typeManagement: typeManagement,
        'typeManagementName': typeManagementName
    };
    return result;
}


function getAllowProcessVariant(product) {
    var colorAndSizeSearch = product['sizes'].length > 0 && product['colors'].length > 0;
    var colorSearch = product['sizes'].length == 0 && product['colors'].length > 0;
    var sizeSearch = product['sizes'].length > 0 && product['colors'].length == 0;
    var anyOneVariant = product['sizes'].length == 0 && product['colors'].length == 0;
    var managerVariants = {
        anyOneVariant: anyOneVariant,
        sizeSearch: sizeSearch,
        colorSearch: colorSearch,
        colorAndSizeSearch: colorAndSizeSearch,

    };

    return managerVariants;
}

function managementBusinessCart(params) {
    var typeManagement = params['typeManagement'];
    var product = params['product'];
    var itemBusiness = localStorage.getItem('businessManagement');
    var itemBusinessInfo = JSON.parse(itemBusiness);
    var success = false;
    var typeName = '';
    var type = '';

    if (Object.keys(itemBusinessInfo).length == 0) {//is new
        success = true;
        setDataBusinessLocale({
            'product': product
        });
        typeName = 'New Management';
        type = 0;
    } else {//is new
        if (product['business_id'] == itemBusinessInfo[0]['id']) {
            success = true;
            typeName = 'Update Management';
            type = 1;
        } else {
            success = false;
            typeName = 'Change  Management Business';
            type = 2;
        }
    }
    var result = {
        success: success,
        'type': type,
        'typeName': typeName
    };
    return result;
}

function _managementProduct(params) {
    var allowPush = params['allowPush'];
    var allowPushManager = params['allowPushManager'];
    var product = params['product'];
    var $this = params['this'];
    var rowData = params['rowData'];
    var amount = params['amount'];

    var allowViewPush = false;
    var quickView = false;
    var rowManagerGrid = false;
    var detailsView = false;
    var allowVariant = false;
    var textManager = 'Se Agrego un producto al carrito.';
    if (allowPush) {
        var dataVariants = allowPushManager['data'];
        product = Object.assign(product, dataVariants);
        var managerVariants = getAllowProcessVariant(product);
        if (managerVariants.sizeSearch) {
            product['type_variant'] = 1;

        } else if (managerVariants.colorSearch) {
            product['type_variant'] = 2;

        } else if (managerVariants.colorAndSizeSearch) {
            product['type_variant'] = 3;
        } else if (managerVariants.anyOneVariant) {
            product['type_variant'] = 0;
        }

        if ($($this).hasClass('add-cart--product-details')) {
            allowViewPush = true;
            detailsView = true;
            product['count'] = amount;
            var price_before = null;
            var price_discount = null;
            var allow_discount = 0;
            var promotion_id = null;
            var priceCurrent = 0;
            var measure_id = -1;
            var measure = "";

            if (product.business_by_discount_id) {
                var valueCurrent = parseFloat(product['sale_price']);
                var business_by_discount_value = parseFloat(product.business_by_discount_value);
                var valueWithoutDiscount = valueCurrent;
                var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
                price_before = valueWithoutDiscount;
                price_discount = valueWithDiscount;
                allow_discount = 1;
                promotion_id = product.business_by_discount_id;
                priceCurrent = price_discount;
            } else {
                priceCurrent = parseFloat(product['sale_price']);
            }
            product['price'] = priceCurrent;
            product['measure_id'] = measure_id;
            product['measure'] = measure;
            product['price_before'] = price_before;
            product['price_discount'] = price_discount;
            product['allow_discount'] = allow_discount;
            product['promotion_id'] = promotion_id;
            _setItemShop(product);
        } else if ($($this).hasClass('management-outlets')) {
            if (rowData) {
                product['count'] = amount;
                var price_before = null;
                var price_discount = null;
                var allow_discount = 0;
                var promotion_id = null;
                var priceCurrent = 0;
                var measure_id = -1;
                var measure = "";
                if (product.business_by_discount_id) {
                    var valueCurrent = parseFloat(product['sale_price']);
                    var business_by_discount_value = parseFloat(product.business_by_discount_value);
                    var valueWithoutDiscount = valueCurrent;
                    var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
                    price_before = valueWithoutDiscount;
                    price_discount = valueWithDiscount;
                    allow_discount = 1;
                    promotion_id = product.business_by_discount_id;
                    priceCurrent = price_discount;

                } else {
                    priceCurrent = parseFloat(product['sale_price']);
                }
                product['price'] = priceCurrent;
                product['measure_id'] = measure_id;
                product['measure'] = measure;
                product['price_before'] = price_before;
                product['price_discount'] = price_discount;
                product['allow_discount'] = allow_discount;
                product['promotion_id'] = promotion_id;

                _setItemShop(product);
            }
        } else if ($($this).hasClass('management-balances')) {
            if (rowData) {
                product['count'] = amount;
                var price_before = null;
                var price_discount = null;
                var allow_discount = 0;
                var promotion_id = null;
                var priceCurrent = 0;
                var measure_id = -1;
                var measure = "";

                if (product.business_by_discount_id) {
                    var valueCurrent = parseFloat(product['sale_price']);
                    var business_by_discount_value = parseFloat(product.business_by_discount_value);
                    var valueWithoutDiscount = valueCurrent;
                    var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
                    price_before = valueWithoutDiscount;
                    price_discount = valueWithDiscount;
                    allow_discount = 1;
                    promotion_id = product.business_by_discount_id;
                    priceCurrent = price_discount;

                } else {
                    priceCurrent = parseFloat(product['sale_price']);
                }
                product['price'] = priceCurrent;
                product['measure_id'] = measure_id;
                product['measure'] = measure;
                product['price_before'] = price_before;
                product['price_discount'] = price_discount;
                product['allow_discount'] = allow_discount;
                product['promotion_id'] = promotion_id;

                _setItemShop(product);
            }
        } else if ($($this).hasClass('add-cart--shop') || $($this).hasClass('single-icon--add-to-cart')) {//Shop Manager Grid

            if ($($this).attr('id') == 'add-cart-preview') {
                quickView = true;
                if (rowData) {
                    product['count'] = amount;
                    var price_before = null;
                    var price_discount = null;
                    var allow_discount = 0;
                    var promotion_id = null;
                    var priceCurrent = 0;
                    var measure_id = -1;
                    var measure = "";
                    if (product.business_by_discount_id) {

                        var valueCurrent = parseFloat(product['sale_price']);
                        var business_by_discount_value = parseFloat(product.business_by_discount_value);
                        var valueWithoutDiscount = valueCurrent;
                        var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
                        price_before = valueWithoutDiscount;
                        price_discount = valueWithDiscount;
                        allow_discount = 1;
                        promotion_id = product.business_by_discount_id;
                        priceCurrent = price_discount;

                    } else {
                        priceCurrent = parseFloat(product['sale_price']);
                    }
                    product['price'] = priceCurrent;
                    product['measure_id'] = measure_id;
                    product['measure'] = measure;
                    product['price_before'] = price_before;
                    product['price_discount'] = price_discount;
                    product['allow_discount'] = allow_discount;
                    product['promotion_id'] = promotion_id;

                    _setItemShop(product);
                }
            } else {
                allowViewPush = true;
                rowManagerGrid = true;
                if (managerVariants.anyOneVariant) {
                    if (rowData) {
                        product['count'] = amount;

                        var price_before = null;
                        var price_discount = null;
                        var allow_discount = 0;
                        var promotion_id = null;
                        var priceCurrent = 0;
                        var measure_id = -1;
                        var measure = "";
                        if (product.business_by_discount_id) {

                            var valueCurrent = parseFloat(product['sale_price']);
                            var business_by_discount_value = parseFloat(product.business_by_discount_value);
                            var valueWithoutDiscount = valueCurrent;
                            var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
                            price_before = valueWithoutDiscount;
                            price_discount = valueWithDiscount;
                            allow_discount = 1;
                            promotion_id = product.business_by_discount_id;
                            priceCurrent = price_discount;

                        } else {
                            priceCurrent = parseFloat(product['sale_price']);
                        }
                        product['price'] = priceCurrent;
                        product['measure_id'] = measure_id;
                        product['measure'] = measure;
                        product['price_before'] = price_before;
                        product['price_discount'] = price_discount;
                        product['allow_discount'] = allow_discount;
                        product['promotion_id'] = promotion_id;
                        _setItemShop(product);
                    }
                } else {
                    allowVariant = true;
                    var selectorCurrent = '#row-' + product['id'] + '.cd-trigger--manager-quick-view';

                    $(selectorCurrent).click();
                }

            }
        }
        var managerTypesEvent = {
            'quickView': quickView,
            'rowManagerGrid': rowManagerGrid,
            'detailsView': detailsView,
            'allowVariant': allowVariant,
        };
        if (!allowVariant) {

            $.NotificationApp.send({
                heading: "Informacion!",
                text: textManager,
                position: 'bottom-left',
                loaderBg: '#53BF82',
                icon: 'success',
                hideAfter: 5000

            });
            updateAllCheckout();

        }
    } else {
        var selectorCurrent = '';
        var msg = allowPushManager.msg;
        var typeManagement = allowPushManager.typeManagement;
        if (typeManagement == null) {
            $.NotificationApp.send({
                heading: "Advertencia!",
                text: msg,
                position: 'bottom-left',
                loaderBg: '#bf7100',
                icon: 'warning',
                hideAfter: 5000
            });
        } else if (typeManagement == 3) {//GRID SHOP
            selectorCurrent = '#row-' + product['id'] + '.cd-trigger--manager-quick-view';
            $(selectorCurrent).click();
        } else if (typeManagement == 4) {
            selectorCurrent = '#row-outlet-' + product['id'] + ' span.single-icon--quick-view a.cd-trigger--manager-quick-view-home';
            $(selectorCurrent).click();
        } else if (typeManagement == 5) {
            selectorCurrent = '#row-balance-' + product['id'] + ' span.single-icon--quick-view a.cd-trigger--manager-quick-view-home';
            $(selectorCurrent).click();
        }
    }
    if (allowViewPush) {
        _viewOrderCart();
    }
}

function _managerItemsOrders() {
    $(".add-cart,.single-icon--add-to-cart").on('click', function () {

        var product = {};
        var typeSet = 'none';
        var amount = 0;
        if ($(this).hasClass('add-cart--product-details')) {//details product
            typeSet = 'add-cart--product-details';
            amount = ($('#product-amount').val());
            product = $productDetails['product'];
            product['sizes'] = $productDetails['sizes'];
            product['colors'] = $productDetails['colors'];

        } else if ($(this).hasClass('management-outlets')) {
            typeSet = 'add-cart-manager-outlets';
            var selectorId = $(this).attr('id').split('-')[2];
            var rowData = $('#row-' + selectorId).attr('data');
            rowData = JSON.parse(rowData);
            $productCurrent = rowData;
            product = rowData;
            amount = 1;

        } else if ($(this).hasClass('management-balances')) {
            typeSet = 'add-cart-manager-balances';
            var selectorId = $(this).attr('id').split('-')[2];
            var rowData = $('#row-' + selectorId).attr('data');
            rowData = JSON.parse(rowData);
            $productCurrent = rowData;
            product = rowData;
            amount = 1;
        } else {
            selectorId = $(this).attr('product-id');
            if ($(this).hasClass('add-cart--shop-preview')) {
                typeSet = 'add-cart-preview';
                product = $productCurrent;
                amount = ($('#product-amount-preview').val());
                rowData = $productCurrent;
            } else if ($(this).attr('id') == 'add-cart-preview') {
                typeSet = 'add-cart-preview';
                amount = ($('#product-amount-preview').val());
                var rowData = getValueCurrentRow({
                    currentId: selectorId
                });
                product = rowData[0];
            } else {
                //businessDetails-Grid-typeView Menu
                typeSet = 'add-cart-manager';
                var rowData = getValueCurrentRow({
                    currentId: selectorId
                });
                amount = 1;
                product = rowData[0];
            }
        }

        var allowPushManager = validateGetValues({
            typeSet: typeSet,
            'product': product,
            'amount': amount,
        });
        var allowPush = allowPushManager['success'];
        var typeManagement = allowPushManager['typeManagement'];
        var managementBusinessCartResult = managementBusinessCart({
            'typeManagement': typeManagement,
            'product': product
        });
        var paramsSetManagementProduct = {
            allowPush: allowPush,
            allowPushManager: allowPushManager,
            product: product,
            this: this,
            rowData: rowData,
            'amount': amount,
            typeSet: typeSet
        };
        if (managementBusinessCartResult.success) {
            _managementProduct(paramsSetManagementProduct);
        } else {
            $.confirm({
                title: 'Informacion!',
                content: 'Si desea comprar de otra empresa se borraran los items de la anterior Empresa!',
                buttons: {
                    cancel: function () {

                    },
                    confirm: {
                        text: 'Confirm',
                        btnClass: 'btn btn-orange',
                        action: function () {
                            resetAll();
                            _managementProduct(paramsSetManagementProduct);
                        }
                    }
                }
            });
        }

        return false;
    });
}

function _viewOrderCart() {
    $('html').addClass('cart-show');
}

function setDataBusinessLocale(params) {
    var product = params['product'];
    var managerData = [];
    if (product) {
        managerData = [
            {
                'id': product['business_id'],
                'title': product['business_title']
            }
        ];
    }
    localStorage.setItem('businessManagement', JSON.stringify(managerData));
}

/*STEP 1*/
function viewDataShop() {
    var dataManagerShopping = allowManagerShopping();
    itemsShop = [];
    if (dataManagerShopping.success) {
        var itemsShop = dataManagerShopping.data;
        var allowBusiness = false;
        $.each(itemsShop, function (index, value) {
            if (!allowBusiness) {
                allowBusiness = true;
                setDataBusinessLocale({
                    product: value
                });
            }
            setItemsShopInit(index, value);

        });
        $(configElementOrders.empty).addClass('not-view');
    } else {
        $(configElementOrders.managerItem.one).remove();
        $(configElementOrders.managerItem.two).remove();
        $(configElementOrders.empty).removeClass('not-view');

        setDataBusinessLocale({
            product: null
        });
    }
    updateShopTotal();
    notViewManagerButtonsBasket({
        view: !itemsShop.length == 0
    });
}

function setItemsShopInit(index, data) {
    var itemShop = getItemShop(index, data);//yes
    $(configElementOrders.managerItems.one).append(itemShop);
    itemShop = getItemShop(index, data, true);//yes
    $(configElementOrders.managerItems.two).append(itemShop);

}


function getTypesVariant(dataProduct) {
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

function _setItemShop(data) {
    var currentId = data.id;
    var countCurrent = data.count;

    var itemsShopCurrent = getItemsShop();
    var indexCurrent = null;
    var newData = true;
    if (itemsShopCurrent.length == 0) {//all new
        var managerData = [];
        managerData.push(data);
        localStorage.setItem('shop', JSON.stringify(managerData));
        $(configElementOrders.empty).addClass('not-view');
    } else {//exist data
        var managerVariants = getTypesVariant(data);
        $.each(itemsShopCurrent, function (index, value) {
            if (managerVariants.anyOneVariant) {

                if (value.id == currentId) {
                    newData = false;
                    countCurrent = parseInt(countCurrent) + parseInt(itemsShopCurrent[index]['count']);
                    itemsShopCurrent[index]['count'] = countCurrent;
                    indexCurrent = index;
                    return;
                }
            } else if (managerVariants.sizeSearch) {

                if (value.id == currentId && value.product_sizes_id == data.product_sizes_id) {
                    newData = false;
                    countCurrent = parseInt(countCurrent) + parseInt(itemsShopCurrent[index]['count']);
                    itemsShopCurrent[index]['count'] = countCurrent;
                    indexCurrent = index;

                    return;
                }
            } else if (managerVariants.colorSearch) {

                if (value.id == currentId && value.product_color_id == data.product_color_id) {
                    newData = false;
                    countCurrent = parseInt(countCurrent) + parseInt(itemsShopCurrent[index]['count']);
                    itemsShopCurrent[index]['count'] = countCurrent;
                    indexCurrent = index;

                    return;
                }
            } else if (managerVariants.colorAndSizeSearch) {

                if (value.id == currentId && value.product_color_id == data.product_color_id && value.product_sizes_id == data.product_sizes_id) {
                    newData = false;
                    countCurrent = parseInt(countCurrent) + parseInt(itemsShopCurrent[index]['count']);
                    itemsShopCurrent[index]['count'] = countCurrent;
                    indexCurrent = index;

                    return;
                }
            }
        });
        if (newData) {
            itemsShopCurrent.push(data);

        }
        managerData = itemsShopCurrent;
        localStorage.setItem('shop', JSON.stringify(managerData));
    }
    if (newData) {//empty registers and new in registers
        var auxCount = 0;
        $.map(managerData, function (val, i) {
            if (managerData.length - 1 == auxCount) {
                indexCurrent = i;
            }
            auxCount++;
        });
        setItemsShopInit(indexCurrent, data);

    } else {
        $('#product-' + indexCurrent + ' ' + configElementOrders.update["row-item"].one).html(countCurrent);
        countCurrent = 'Cant:' + countCurrent;
        $('#product-' + indexCurrent + ' ' + configElementOrders.update["row-item"].two).html(countCurrent);

    }
    updateShopTotal();
}

function updateShopTotal() {
    var itemsShopCurrent = getItemsShop();
    var resultShop = getItemsResultShop(itemsShopCurrent);
    $('.item-count--shopping-basket').html('');
    $('.item-count--shopping-basket').html(resultShop.totalItems);

    $('#subtotal').html('');
    $('#subtotal').html('$' + resultShop.subtotal);

    $(configElementOrders.amount).html('');
    $(configElementOrders.amount).html(resultShop.totalItems);

    $(configElementOrders.results.one).html('');
    $(configElementOrders.results.one).html('$' + resultShop.subtotal);
    $(configElementOrders.results.two).html('');
    $(configElementOrders.results.two).html('$' + resultShop.subtotal);

}

function getItemsResultShop(data) {
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
        var managerProduct = getTotalManagerProduct(value);
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

function getItemShop(index, data, typeStructure = null) {

    $languageCurrent = $language == 'es' ? null : $language;

    var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);


    var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);

    var managerVariants = getTypesVariant(data);

    if (managerVariants.anyOneVariant) {
        nameProduct = nameProduct + (' - ' + data.code);
    } else if (managerVariants.colorAndSizeSearch) {
        nameProduct = nameProduct + (' - ' + data.product_color) + (' - ' + data.product_sizes);
    } else if (managerVariants.colorSearch) {
        nameProduct = nameProduct + (' - ' + data.product_color);
    } else if (managerVariants.sizeSearch) {
        nameProduct = nameProduct + (' - ' + data.product_sizes);
    }
    var result = [];
    var currentUrl = $rootUrl + '/productDetails/' + data.id;
  var priceCurrent=getValueCustomer(data.price);

    if (typeStructure == null) {
        result = [
            '<div class="minicart-wrapper__items__single" id="product-' + index + '">',
            '   <a href="javascript:deleteItem(' + index + ')" class="close-icon"><i class="pe-7s-close"></i></a>',
            '   <div class="image">',
            '        <a href="' + currentUrl + '">',
            '        <img src="' + $resourceManagementRoot + data.source + '" class="img-fluid" alt="">',
            '           </a>',
            '   </div>',
            '   <div class="content">',
            '       <p class="product-title">',
            '           <a href="/productDetails/' + data.id + '">' + nameProduct + '</a>',
            '        </p>',
            '       <p class="product-calculation"><span class="count">' + data.count + '</span> x',
            '           <span class="price"> $' + priceCurrent + '</span>',
            '       </p>',
            '   </div>',
            ' </div>',

        ];
    } else {
        result = [
            '<div class="management-orders__manager-item" id="product-' + index + '">',
            '  <a class="management-orders__manager-link" href="' + currentUrl + '">',
            '       <span class="management-orders__manager-img">',
            '          <img src="' + $resourceManagementRoot + data.source + '" class="img-fluid" alt="">',
            '       </span> ',
            '       <span class="management-orders__items-attributes management-orders__manager-name"> ' + nameProduct + '</span>',
            '       <span class="management-orders__items-attributes management-orders__manager-qty">  Cant:' + data.count + '</span>',
            '       <span class="management-orders__items-attributes management-orders__manager-price"> $' + priceCurrent + '</span>',
            '  </a>',
            '  <a href="javascript:deleteItem(' + index + ')" class="management-orders__manager-rm btn--link"><i class="fa fa-times" aria-hidden="true"></i></a>',
            ' </div>',

        ];
    }


    return result.join('');

}

function deleteItem(currentId) {
    var itemsShopCurrent = getItemsShop();
    var managerData = [];
    $.each(itemsShopCurrent, function (index, value) {
        if (index != currentId) {
            managerData.push(value);
            return;
        }
    });

    $(configElementOrders.managerItem.one).remove();
    $(configElementOrders.managerItem.two).remove();

    localStorage.setItem('shop', JSON.stringify(managerData));
    if ($currentPage == 'checkout') {

        deleteRowCartCheckout({
            rowId: currentId,
            deleteCart: true
        });

    }

    viewDataShop();

}

function resetAll() {

    localStorage.clear();
    initViewDataLocalStorage();
    var itemsShop = getItemsShop();
    if ($currentPage == 'checkout') {
        viewCartPage(itemsShop);
    }
    updateAllCheckout();
}

function notViewManagerButtonsBasket(params) {
    var viewButtons = params.view;
    if (viewButtons) {
        $('#btn-view-checkout').removeClass('not-view');
    } else {
        $('#btn-view-checkout').addClass('not-view');

    }
}

/*STEP 1 a)*/
function allowManagerShopping() {

    var itemsShop = getItemsShop();

    var result = {
        success: itemsShop.length == 0 ? false : true,
        data: itemsShop
    };

    return result;
}

function getTotalManagerProduct(value) {
    var subtotal = 0;
    var subtotal_no_tax = 0;
    var subtotal_tax = 0;
    var total = 0;
    var total_tax = 0;
    var has_tax = false;
    var allow_discount = value.allow_discount == 0 ? false : true;
    var price = allow_discount == false ? parseFloat(value.sale_not_tax) : parseFloat(value.price_discount);
    var sale_price = 0;
    var amount = parseInt(value.count);
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

function Generator() {
};

Generator.prototype.rand = Math.floor(Math.random() * 26) + Date.now();
Generator.prototype.getId = function () {
    return this.rand++;
};

function updateAllCheckout() {
    var itemsShop = getItemsShop();
    notViewManagerButtonsBasket({
        view: !itemsShop.length == 0
    });
}

function initEventWhishList() {
    $(".add-wish-list").unbind("click");
    $('.add-wish-list').on('click', function () {
        var product_id = $(this).parent().attr('product-id');
        if ($(this).hasClass('add-wish-list--view-quick') || $(this).hasClass('add-wish-list-view-details')) {
            product_id = $(this).attr('product-id')
        }

        if ($allowUser == 1) {
            addWhishList({
                data: {
                    'TemplateWishListByUser': {
                        product_id: product_id
                    }
                },
                type: 'POST'
            });
        } else {
            alert('Registrate para poder agregar a la lista');
        }
    });
}

function addWhishList(params) {
    var tokenInformation = $('meta[name="csrf-token"]').attr('content');
    var type = params.hasOwnProperty("type") ? params.type : 'GET';
    var data = params.hasOwnProperty("data") ? params.data : [];
    var contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
    var url = '/addWishListProduct';
    var configAjax = {
        url: url,
        type: type,
        dataType: 'json',
        data: data,
        contentType: contentType,
        headers: {
            'X-CSRF-TOKEN': tokenInformation
        },
        beforeSend: function (jqXHR, settings) {
            console.log('beforeSend');

        },
        error: function (response) {
            console.log('error', response);

        },
        success: function (response) {
            console.log('success', response);
            var countWishList = response.data.countWishList;
            updateWishListCount({
                response: response.data,
                data: data,


            })
        },
        complete: function () {
            console.log('complete');

        }
    };
    $.ajax(configAjax);
}

function updateWishListCount(params) {
    var countWishList = params.response.countWishList;
    var allowDelete = params.response.allowDelete;

    var product_id = params['data']['TemplateWishListByUser']['product_id'];

    if (allowDelete) {
        var selector = "a.favorite-icon-active[product-id='" + product_id + "']";
        $(selector).removeClass('favorite-icon-active');
        $('.add-wish-list--view-quick').attr("change", 'true');

    } else {

        var selector = "a[product-id='" + product_id + "']";
        $(selector).addClass('favorite-icon-active');
        $('.add-wish-list--view-quick').attr("change", 'false');
    }
    $(".item-count--whish").html(countWishList);


}

function getValueCurrentRow(params) {
    var row = null;
    var currentId = params.currentId;
    var rows = $(selectorGrid).bootgrid("getCurrentRows");
    var row = rows.filter(function (value, index) {
        if (value.id == currentId) {
            return value;
        }
    });

    return row;
}

function initQty() {
    $('#product-amount-preview').val(0);
    $('.qty-btn').unbind();
    $('.qty-btn').on('click', function (e) {
        e.preventDefault();
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });
}

function getFilters() {
    $paramsRequest.hasOwnProperty('categoryId')
    var result = {
        business_id: 1,
        category: $('#category').val() ? $('#category').val() : -1,
        subcategory: $('#subcategory').val() ? $('#subcategory').val() : -1,
        'language': $language
    };

    return result;
}

function GridManager(params) {
    var allowFilters = false;
    if ($paramsRequest.hasOwnProperty('categoryId') && $paramsRequest.categoryId != '-1') {
        $('#category').val($paramsRequest.categoryId);
        allowFilters = true;

    }
    if ($paramsRequest.hasOwnProperty('subCategoryId') && $paramsRequest.subCategoryId != '-1') {
        allowFilters = true;
        $('#subcategory').val($paramsRequest.subCategoryId);
    }
    if (allowFilters) {

        if ($('.content-filter').hasClass('not-view')) {

            $('.content-filter').removeClass('not-view');
        }
    }
    var gridNameSelector = params['gridNameSelector'];
    let gridInit = $(gridNameSelector);

    let method = params.hasOwnProperty("ajaxSettings").hasOwnProperty('method') ? params['ajaxSettings']['method'] : "POST";
    let urlCurrent = params['urlCurrent'];
    //labels
    let loadingHtml = params.hasOwnProperty("labels").hasOwnProperty('loading') ? params['labels']['loading'] : "Cargando...";
    let noResultsHtml = params.hasOwnProperty("labels").hasOwnProperty('noResults') ? params['labels']['noResults'] : "Sin Resultados!";
    let infosHtml = params.hasOwnProperty("labels").hasOwnProperty('infos') ? params['labels']['infos'] : 'Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados';
    //css
    let headerCSS = params.hasOwnProperty("css").hasOwnProperty('header') ? params['css']['header'] : "bootgrid-header";
    let tableCSS = params.hasOwnProperty("css").hasOwnProperty('table') ? params['css']['table'] : "xywer-tbl-admin";
    let formattersCurrent = params.hasOwnProperty("formatters") ? params['formatters'] : {
        'default': function (column, row) {
            console.log(row);
        }
    };
    var footer_bst2 =
        "<div id='data-pagination'  id=\"{{ctx.id}}\" class=\"{{css.footer}}\">\n\
                        <div class='col-md-6'>\n\
                            <div  class='pagination'>\n\
                                <p class=\"{{css.pagination}}\"></p>\n\
                            </div>\n\
                        </div>\n\
                        <div class=\"col-md-6\">\n\
                            <p class=\"{{css.infos}}\"></p>\n\
                        </div>\n\
        </div>";
    var templates = {
        footer: footer_bst2
    };


    gridInit.bootgrid({
        ajaxSettings: {
            method: method
        },
        ajax: true,
        requestHandler: function (request) {
            request.filters = getFilters();
            return request;
        },
        url: urlCurrent,
        labels: {
            loading: loadingHtml,
            noResults: noResultsHtml,
            infos: infosHtml
        },
        css: {
            header: headerCSS,
            table: tableCSS,
            footer: 'pagination-wrapper'
        },
        templates: templates,
        formatters: formattersCurrent
    });

    return gridInit;

}

function getViewsRowProduct($params) {

    initDataShopping();

    $languageCurrent = $language == 'es' ? null : $language;
    var type = $params['type'];
    var data = $params['data'];
    var result=[];
    var valueCurrent = parseFloat(data.sale_price);
    var valueCurrentNotTax = parseFloat(data.sale_not_tax);

    var allowDiscount = data.business_by_discount_id != null ? true : false;
    var valueCurrentHtml = [];
    var discountImageHtml = [];
    if (allowDiscount) {
        var business_by_discount_value = parseFloat(data.business_by_discount_value);
        var valueWithoutDiscount = valueCurrent;
        var valueWithDiscount = valueCurrentNotTax - (valueCurrentNotTax * business_by_discount_value) / 100;

        valueWithDiscount=getValueCustomer(valueWithDiscount);
        valueCurrentHtml = [
            '<div class="price price--grid-manager">',
            '<span class="main-price discounted">$' + valueWithoutDiscount + '</span> <span class="discounted-price">$' + valueWithDiscount + '</span>',
            '      </div>'
        ];
        business_by_discount_value = '-' + business_by_discount_value + ' %';
        discountImageHtml = [
            ' <div class="product-badge-wrapper">',
            '<span class="onsale">' + business_by_discount_value + '</span>',
            ' <span class="hot not-view">Hot</span>',
            '</div>'
        ]

    } else {
        valueCurrentHtml = [
            '         <div class="price  price--grid-manager"><span class="main-price">$' + valueCurrent + '</span></div>'
        ];

    }
    valueCurrentHtml = valueCurrentHtml.join('');
    discountImageHtml = discountImageHtml.join('');
    var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
    nameProduct = nameProduct + (' - ' + data.code);
    var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);
    ;
    var currentUrl = $rootUrl + '/productDetails/' + data.id;

    var shoppingButton = $allowShop == 1 ? ['             <span class="single-icon single-icon--add-to-cart">',
        '                  <a  product-id="' + data.id + '"   class="add-cart add-cart--shop" href="javascript:void(0)" data-tippy="' + $buttonsConfig.names['one'] + '"',
        '                    data-tippy-inertia="true"',
        '                     data-tippy-animation="shift-away"',
        '                     data-tippy-delay="50" ',
        '                      data-tippy-arrow="true"',
        '                     data-tippy-theme="sharpborder"> ',
        '                      <i class="fa fa-shopping-basket"></i>',
        '                        <span>' + $buttonsConfig.names['one'] + '</span>',
        '                  </a> ',
        '             </span> '] : [];
    shoppingButton = shoppingButton.join('');

    var viewButtonProduct = $allowShop == 1 ?
        [
            '              <span class="single-icon single-icon--quick-view"> ',
            '                    <a  id="row-' + data.id + '" class="cd-trigger cd-trigger--manager-quick-view" href="#qv-1" data-tippy="Quick View" ',
            '                        data-tippy-inertia="true"',
            '                        data-tippy-animation="shift-away"',
            '                       data-tippy-delay="50" ',
            '                       data-tippy-arrow="true"',
            '                       data-tippy-theme="sharpborder">',
            '                      <i class="fa fa-search"></i> ',
            '                    </a> ',
            '              </span>',
        ] : [
            '              <span class="single-icon single-icon--quick-view single-icon--quick-view--not-basket"> ',
            '                    <a  id="row-' + data.id + '" class="cd-trigger cd-trigger--manager-quick-view" href="#qv-1" data-tippy="Quick View" ',
            '                        data-tippy-inertia="true"',
            '                        data-tippy-animation="shift-away"',
            '                       data-tippy-delay="50" ',
            '                       data-tippy-arrow="true"',
            '                       data-tippy-theme="sharpborder">',
            '                      <i class="fa fa-search"></i> ',
            '                            ' + $buttonsConfig.names['five'] + '',
            '                    </a> ',
            '              </span>',

        ];
    viewButtonProduct = viewButtonProduct.join('');

    var compareHtml = [

        '           <span class="single-icon single-icon--compare">',
        '                 <a href="javascript:void(0)"',
        '                     data-tippy="Compare" ',
        '                      data-tippy-inertia="true"',
        '                        data-tippy-animation="shift-away"',
        '                         data-tippy-delay="50"',
        '                         data-tippy-arrow="true"',
        '                       data-tippy-theme="sharpborder">',
        '                                   <i class="fa fa-exchange"></i>',
        '                    </a>',
        '          </span>',
    ];
    if (type == 1) {//grid
        result = [
            ' <div class="col-lg-4 col-md-6 col-sm-6 col-custom-sm-6 col-12">',
            '   <div class="single-list-product">',
            '       <div class="single-list-product__image">',
            '        <a product-id="' + data.id + '" href="javascript:void(0)" class="favorite-icon ' + (data.product_id_whishlist ? 'favorite-icon-active' : '') + '" data-tippy="' + $buttonsConfig.names['four'] + '"',
            '            data-tippy-inertia="true" data-tippy-animation="shift-away"',
            '             data-tippy-delay="50" data-tippy-arrow="true"',
            '             data-tippy-theme="sharpborder" data-tippy-placement="left">',
            '             <i class="fa fa-heart-o add-wish-list add-wish-list--admin"></i>',
            '              <i class="fa fa-heart"></i>',
            '        </a>',
            discountImageHtml,
            '        <a href="' + currentUrl + '" class="image-wrap">',
            '           <img src="' + $resourceRoot + data.source + '" class="img-fluid" alt="">',
            '        </a> ',
            '      </div>',
            '     <div class="single-list-product__content">',
            '         <h3 class="title"><a href="' + currentUrl + '">' + nameProduct + '</a></h3>',
            valueCurrentHtml,
            '         <p class="product-short-desc">' + descriptionProduct,
            '         </p>',
            '         <div class="product-hover-icon-wrapper">',
            viewButtonProduct,
            shoppingButton,

            '    </div>',
            '   </div>',
            '</div>',

        ];
    }

    result = result.join('');
    return result;
}

function _managerItemsOrdersQuickView() {
    initDataShopping();
    var sliderFinalWidth = 400,
        maxQuickWidth = 900;


    //manager view
    $('.cd-trigger--manager-quick-view,.single-icon--quick-view').on('click', function (event) {

        var isContentMain = $(this).hasClass('single-icon--quick-view') ? true : false;
        var selectorId = null;
        if (!isContentMain) {
            selectorId = $(this).attr('id').split('-')[1];
        } else {
            selectorId = $(this).attr('row-id').split('-')[1];

        }
        var rowData = getValueCurrentRow({
            currentId: selectorId
        });
        var product = rowData[0];
        if (typeof ($allowAllInOne) == 'undefined') {
            updateViewQuick({
                data: rowData ? rowData[0] : null
            });

            event.preventDefault();
            var selectedImage = $(this).closest('.single-grid-product, .single-list-product').find('.single-grid-product__image .image-wrap, .single-list-product__image .image-wrap').children('img').eq(0),
                id = $(this).attr('href'),
                slectedImageUrl = selectedImage.attr('src');

            $('body').addClass('overlay-layer');
            animateQuickViewManager(id, selectedImage, sliderFinalWidth, maxQuickWidth, 'open');
            initQty();
        } else {
            if ($allowAllInOne == '1') {
                var rowDataString = JSON.stringify(product);//mike
                $('#management-product-details').attr('row-data', rowDataString);
                $('#management-product-details').click();

            }
        }
        if ($allowShop == 0) {
            $('.manager-basket-inputs').addClass('not-view');
            $('.manager-basket-inputs').remove();

        }

    });
}

/*Open Quick View*/
function animateQuickViewManager(id, image, finalWidth, maxQuickWidth, animationType) {
    //store some image data (width, top position, ...)
    //store window data to calculate quick view panel position
    var parentListItem = image.parent('.image-wrap'),
        topSelected = image.offset().top - $(window).scrollTop(),
        leftSelected = image.offset().left,
        widthSelected = image.width(),
        heightSelected = image.height(),
        windowWidth = $(window).width(),
        windowHeight = $(window).height(),
        finalLeft = (windowWidth - finalWidth) / 2,
        finalHeight = finalWidth * heightSelected / widthSelected,
        finalTop = (windowHeight - finalHeight) / 2,
        quickViewWidth = (windowWidth * .8 < maxQuickWidth) ? windowWidth * .8 : maxQuickWidth,
        quickViewLeft = (windowWidth - quickViewWidth) / 2;

    if (animationType == 'open') {
        //hide the image in the gallery
        parentListItem.addClass('empty-box');
        //place the quick view over the image gallery and give it the dimension of the gallery image
        $(id).css({
            "top": topSelected,
            "left": leftSelected,
            "width": widthSelected,
        }).velocity({
            //animate the quick view: animate its width and center it in the viewport
            //during this animation, only the slider image is visible
            'top': finalTop + 'px',
            'left': finalLeft + 'px',
            'width': finalWidth + 'px',
        }, 1000, [400, 20], function () {
            //animate the quick view: animate its width to the final value
            $(id).addClass('animate-width').velocity({
                'left': quickViewLeft + 'px',
                'width': quickViewWidth + 'px',
            }, 300, 'ease', function () {
                //show quick view content
                $(id).addClass('add-content');
            });
        }).addClass('is-visible');
    } else {
        //close the quick view reverting the animation
        $(id).removeClass('add-content').velocity({
            'top': finalTop + 'px',
            'left': finalLeft + 'px',
            'width': finalWidth + 'px',
        }, 300, 'ease', function () {
            $('body').removeClass('overlay-layer');
            $(id).removeClass('animate-width').velocity({
                "top": topSelected,
                "left": leftSelected,
                "width": widthSelected,
            }, 500, 'ease', function () {
                $(id).removeClass('is-visible');
                parentListItem.removeClass('empty-box');
            });
        });
    }
}

function updateViewQuick(params) {

    var selectorsConfig = {
        'title': '#item-title',
        'price': {
            'main': '#main-price',
            'discount': '#discounted-price',
            'discount-wrapper': '#product-badge-wrapper',
            'discount-percentage': '#product-badge-wrapper__percentage',
            'discount-percentage-hot': '#product-badge-wrapper__wrapper__hot',

        },
        variants: {
            'color-content': '.product-color',
            'color-items': '.product-color__items',
            'size-content': '.product-size',
            'size-items': '.product-size__items',

        },
        'description': '#description',
        'category': '#quickview-value-category',
        'codec': '#quickview-value-codec',
        multimedia:
            {
                'data': '.cd-slider',
                slider: '.cd-slider-pagination'
            }

        , buttons: {
            'add-cart': '#add-cart-preview',
            'wish-list': '.add-wish-list--view-quick'
        }
    };
    var data = params.data;
    if (data) {

        $languageCurrent = $language == 'es' ? null : $language;

        var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
        nameProduct = nameProduct + (' - ' + data.code);
        var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);

        //price
        var allowDiscount = false;
        var price_before = null;
        var price_discount = null;
        var allow_discount = 0;
        var promotion_id = null;
        var priceCurrent = 0;
        var measure_id = -1;
        var measure = "";
        var product = data;
        var valueCurrent = data.hasOwnProperty('sale') ? data['price'] : (data.hasOwnProperty('sale_price') ? parseFloat(data['sale_price']) : 0);
        if (product.business_by_discount_id) {
            var business_by_discount_value = parseFloat(product.business_by_discount_value);
            var valueWithoutDiscount = valueCurrent;
            var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
            price_before = valueWithoutDiscount;
            price_discount = valueWithDiscount;
            allow_discount = 1;
            promotion_id = product.business_by_discount_id;
            priceCurrent = price_discount;
            allowDiscount = true;
        } else {
            priceCurrent = data.hasOwnProperty('sale') ? data['price'] : (data.hasOwnProperty('sale_price') ? parseFloat(data['sale_price']) : 0)
        }

        var price = valueCurrent;
        $(selectorsConfig.price.main).removeClass('discounted');
        $(selectorsConfig.price.main).html('$' + price);
        if (allowDiscount) {
            $(selectorsConfig.price.main).addClass('discounted');
            $(selectorsConfig.price.discount).removeClass('not-view');

            $(selectorsConfig.price['discount-wrapper']).removeClass('not-view');

            $(selectorsConfig.price.discount).html('$' + priceCurrent);
            var business_by_discount_value = "-" + parseFloat(product.business_by_discount_value) + ' %';
            $(selectorsConfig.price['discount-percentage']).html(business_by_discount_value);


        } else {
            $(selectorsConfig.price['discount-wrapper']).addClass('not-view');
            $(selectorsConfig.price.discount).addClass('not-view');
        }


        $(selectorsConfig.buttons['add-cart']).attr("product-id", data.id);
        $(selectorsConfig.buttons['wish-list']).attr("product-id", data.id);
        var wishListClass = data.product_id_whishlist ? 'favorite-icon-active' : '';
        if (!$(selectorsConfig.buttons['wish-list']).hasClass(wishListClass)) {

            $(selectorsConfig.buttons['wish-list']).addClass(wishListClass);
        }
        if ($(selectorsConfig.buttons['wish-list']).attr('change') == 'true') {
            $(selectorsConfig.buttons['wish-list']).removeClass('favorite-icon-active');
        } else if ($(selectorsConfig.buttons['wish-list']).attr('change') == 'false') {
            $(selectorsConfig.buttons['wish-list']).addClass('favorite-icon-active');
        }
        $(selectorsConfig.title).html("");

        $(selectorsConfig.title).html(nameProduct);

        $(selectorsConfig.description).html("");
        $(selectorsConfig.description).html(descriptionProduct);


        $(selectorsConfig.category).html("");
        $(selectorsConfig.category).html(data.product_subcategory);

        $(selectorsConfig.codec).html("");
        $(selectorsConfig.codec).html(data.code);

        var multimedia = data.hasOwnProperty('multimedia') ? data.multimedia : [];

        var multimediaHtmlData = [];
        var multimediaHtmlSlider = [];

        multimediaHtmlSlider.push(
            '<li class="active"><a href="#0">1</a></li>'
        );


        multimediaHtmlData.push(
            ' <li class="selected">'
        );
        multimediaHtmlData.push(
            '<img src="' + $resourceRoot + data.source + '" alt="' + data.name + '">'
        );
        multimediaHtmlData.push(
            '</li>'
        );
        $(selectorsConfig.multimedia.data).html("");
        /*$(selectorsConfig.multimedia.slider).html("");*/
        var count = 1;
        if (multimedia.length > 0) {
            $.each(multimedia, function (index, value) {

                multimediaHtmlData.push(
                    '<li>'
                );
                multimediaHtmlData.push(
                    '<img src="' + $resourceRoot + value.source + '" alt="' + value.title + '">'
                );

                multimediaHtmlData.push(
                    '</li>'
                );
                multimediaHtmlSlider.push(
                    '<li><a href="#' + count + '">' + (count + 1) + '</a></li>'
                );
                count++;
            });
        }
        multimediaHtmlData = multimediaHtmlData.join('');
        multimediaHtmlSlider = multimediaHtmlSlider.join('');

        $(selectorsConfig.multimedia.data).html(multimediaHtmlData);
        $(selectorsConfig.multimedia.slider).html(multimediaHtmlSlider);


        //VARIANT

        var managerVariants = getAllowProcessVariant(product);

        $(selectorsConfig.variants["color-content"]).hide();
        $(selectorsConfig.variants["size-content"]).hide();
        $(selectorsConfig.variants["color-items"]).html('');
        $(selectorsConfig.variants["size-items"]).html('');
        if (managerVariants.colorAndSizeSearch) {

            var colorHtml = [];

            var initActive = true;
            $.each(data['colors'], function (index, value) {
                var classCurrentActive = 'active';
                var $colorStyle = 'style="background-color:' + value['color'] + ';"';
                if (!initActive) {
                    classCurrentActive = '';
                } else {
                    initActive = false;
                }
                var buttonA = '<a class="' + classCurrentActive + '"  data-tippy="' + value.text + '" data-tippy-inertia="true"' + ' data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"' + ' data-tippy-theme="roundborder"><span class="color-picker" ' + $colorStyle + '></span></a>';
                var setPush = '<li class="color-manager-quick-view" id="color-' + value.id + '"  >' + buttonA + '</li>';
                colorHtml.push(setPush);

            });
            $(selectorsConfig.variants["color-items"]).html(colorHtml.join(''));


            var sizeHtml = [];
            $.each(data['sizes'], function (index, value) {
                var setPush = '<option value="' + value.id + '" >' + value.text + '</option>';
                sizeHtml.push(setPush);

            });
            $(selectorsConfig.variants["size-items"]).html(sizeHtml.join(''));

            $('.nice-select-quick-view').niceSelect('update');
            $(selectorsConfig.variants["color-content"]).show();
            $(selectorsConfig.variants["size-content"]).show();
            initEventsCurrentColor();
        } else if (managerVariants.colorSearch) {
            var colorHtml = [];

            var initActive = true;
            $.each(data['colors'], function (index, value) {
                var classCurrentActive = 'active';
                var $colorStyle = 'style="background-color:' + value['color'] + ';"';
                if (!initActive) {
                    classCurrentActive = '';
                } else {
                    initActive = false;
                }
                var buttonA = '<a class="' + classCurrentActive + '"  data-tippy="' + value.text + '" data-tippy-inertia="true"' + ' data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true"' + ' data-tippy-theme="roundborder"><span class="color-picker" ' + $colorStyle + '></span></a>';
                var setPush = '<li class="color-manager-quick-view" id="color-' + value.id + '"  >' + buttonA + '</li>';
                colorHtml.push(setPush);

            });
            $(selectorsConfig.variants["color-items"]).html(colorHtml.join(''));
            $(selectorsConfig.variants["color-content"]).show();
            initEventsCurrentColor();

        } else if (managerVariants.sizeSearch) {

            var sizeHtml = [];
            $.each(data['sizes'], function (index, value) {
                var setPush = '<option value="' + value.id + '" >' + value.text + '</option>';
                sizeHtml.push(setPush);

            });
            $(selectorsConfig.variants["size-items"]).html(sizeHtml.join(''));
            $('.nice-select-quick-view').niceSelect('update');
            $(selectorsConfig.variants["size-content"]).show();
        }
    }

}

function initEventsFilters() {
    $('#sort-by').on('change', function () {

        var sortConfig = new Object;

        var sortCurrent = 'asc';
        var sortId = $('#sort-by').val();
        var selectorCurrent = null;
        var nameKey = '';
        var titleOption = '';
        if (sortId == 0) {
            selectorCurrent = '#nameSort';
            sortCurrent = $(selectorCurrent).attr('order');
            titleOption = 'Nombre ';
            nameKey = 'name';
        } else if (sortId == 1) {
            selectorCurrent = '#codeSort';
            sortCurrent = $(selectorCurrent).attr('order');
            nameKey = 'code';
            titleOption = 'Codigo ';

        } else if (sortId == 2) {
            selectorCurrent = '#categorySort';
            sortCurrent = $(selectorCurrent).attr('order');
            nameKey = 'product_category';
            titleOption = 'Categoria ';

        } else if (sortId == 3) {
            selectorCurrent = '#subcategorySort';
            sortCurrent = $(selectorCurrent).attr('order');
            nameKey = 'product_subcategory';
            titleOption = 'Subcategoria ';

        }
        if (sortCurrent == 'asc') {
            titleOption += ' ASC';

            $(selectorCurrent).attr('order', 'desc');
        } else {
            titleOption += ' DESC';
        }
        sortConfig[nameKey] = sortCurrent;
        $(selectorCurrent).html('');
        $(selectorCurrent).html(titleOption);

        $(selectorGrid).bootgrid("sort", sortConfig);
        $('.nice-select').niceSelect('update');
    });
    $('.a-category').on('click', function () {


        var elementCurrent = $(this).parent();
        var subMenu = elementCurrent.find("ul");
        if (subMenu.attr('style') == undefined || subMenu.attr('style') == 'display: none;') {
            elementCurrent.addClass('active');
        } else {
            elementCurrent.removeClass('active');
        }
        var arrowCurrent = elementCurrent.find("i");
        arrowCurrent.click();
    });
    $('.a-subcategory').on('click', function () {
        $('.a-category.active').removeClass('active');

        var categoryCurrent = $(this).attr('category');
        $.each($('.li-category.active'), function (index, value) {

            if ($(value).attr('category') != categoryCurrent) {
                $(value).removeClass('active');
            }
        });
        $('.a-subcategory.active').removeClass('active');
        $(this).addClass('active');
        var selectorCurrent = '.li-category[category=' + categoryCurrent + ']';
        $(selectorCurrent).addClass('active');
        $('#category').val($(this).attr('category'));
        $('#subcategory').val($(this).attr('subcategory'));
        $(selectorGrid).bootgrid("reload");
        if ($('.content-filter').hasClass('not-view')) {

            $('.content-filter').removeClass('not-view');
        }
    });
    $('.content-filter').on('click', function () {

        $('.li-category.active').removeClass('active');
        $('.a-subcategory.active').removeClass('active');
        $('.content-filter').addClass('not-view');
        $('.a-category.active').removeClass('active');
        $('#category').val('');
        $('#subcategory').val('');
        $(selectorGrid).bootgrid("reload");
    });

}

var $productCurrent = null;

function initEventsCurrentColor() {
    $(".color-manager-quick-view").unbind("click");
    $('.color-manager-quick-view').on('click', function () {
        var elementColor = $(this).find('a.active');
        if (elementColor.length == 0) {
            $('.color-manager-quick-view').find('a.active').removeClass('active');
            $(this).find('a').addClass('active');
        } else {

        }

    });
}

function _initOutletsSlider() {
    var sliderFinalWidth = 400,
        maxQuickWidth = 900;

    $('.cd-trigger--manager-quick-view-home').on('click', function () {
        $('#add-cart-preview').removeClass('add-cart--shop-preview');
        $('#add-cart-preview').addClass('add-cart--shop-preview');

        var selectorId = $(this).attr('id').split('-')[1];
        var rowData = $(this).attr('data');
        rowData = JSON.parse(rowData);
        $productCurrent = rowData;
        updateViewQuick({
            data: rowData
        });
        var selectedImage = $(this).closest('.single-grid-product, .single-list-product').find('.single-grid-product__image .image-wrap, .single-list-product__image .image-wrap').children('img').eq(0),
            id = '#qv-1',
            slectedImageUrl = selectedImage.attr('src');
        $('body').removeClass('overlay-layer');
        $('body').addClass('overlay-layer');
        animateQuickViewManager(id, selectedImage, sliderFinalWidth, maxQuickWidth, 'open');
        initQty();
        event.preventDefault();
    });
}

$(function () {
    $('#search-icon-input').click(function (event) {
        $('#needle').val($('#search-input--value').val());

        var currentUrl = $('#search-data-form').attr('action');
        var currentParams = $('#needle').val();
        currentUrl = currentUrl + '?search=' + currentParams;
        window.location.assign(currentUrl);
    });
    $('#search-input--value').keyup(function (event) {

        if (event.which == '13') {
            $('#needle').val($('#search-input--value').val());

            var currentUrl = $('#search-data-form').attr('action');
            var currentParams = $('#needle').val();
            currentUrl = currentUrl + '?search=' + currentParams;
            window.location.assign(currentUrl);

        }
    });

    $('#how-buy-link')
        .on('click', function () {
            $('#modal-data-preview').modal('show');
        });

    $('#modal-data-preview').on('show.bs.modal', function () {
        $('#modal-data-preview .modal-header').addClass('not-view');
        $('#modal-data-preview .modal-footer').addClass('not-view');
        $('#modal-data-preview .modal-body').addClass('modal-body--how-buy');

        $('#modal-data-preview .modal-body').html("");

        var urlCurrentInstructions = $resourceManagementRoot + '/templates/business/arquitechos/images/instructions-eccomerce.png';
        var modalBody = [
            '<img class="img-responsive" src="' + urlCurrentInstructions + '">'

        ];

        modalBody = modalBody.join('');
        $('#modal-data-preview .modal-body').html(modalBody);

    });
    $('#modal-data-preview').on('hidden.bs.modal', function () {
        $('#modal-data-preview .modal-header').removeClass('not-view');
        $('#modal-data-preview .modal-footer').removeClass('not-view');
        $('#modal-data-preview .modal-body').removeClass('modal-body--how-buy');


    });

    $('#whatsapp-contact__a').on('click', function () {
        var dataBusiness = $(this).attr('data');
        var text = $(this).attr('text');
        if (typeof (dataBusiness) != 'undefined') {

            dataBusiness = JSON.parse(dataBusiness);
            var phone = '+' + dataBusiness.phone_code + '' + dataBusiness.phone_value;
            var dataParams = {
                phone: phone,
                text: text,
            };
            $hrefCurrent = getUrlContactWhatsApp({dataParams: dataParams});
            window.open($hrefCurrent);
        }

    });
});
getUrlContactWhatsApp = function (params) {
    var urlCurrent = 'https://web.whatsapp.com/send?' + getStringParamsGet(params);
    var result = urlCurrent;
    /*      var result = 'https://web.whatsapp.com/send?phone=+593989351482&amp;text=Deseo%20m%C3%A1s%20informaci%C3%B3n%20de:%20%20https://cuponcity.ec/quito/belleza/renueva-imagen-y-luce-cambio-look-genia-retoque-mechas-1-corte-puntas-make-beauty';*/
    return result;
}

function getStringParamsGet(params) {
    var dataParams = params['dataParams'];
    var recursiveDecoded = decodeURIComponent($.param(dataParams));
    return recursiveDecoded;
}


function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
        return 'iOS';

    } else if (userAgent.match(/Android/i)) {

        return 'Android';
    } else {
        return 'unknown';
    }
}
