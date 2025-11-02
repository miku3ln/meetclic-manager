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
    "theme-button theme-button--alt theme-button--minicart-button theme-button--minicart-button--alt mb-0", "theme-button theme-button--minicart-button", "management-orders__manager-items", ('administration-cart'), 'a-cart-basket__item-count', "item-count item-count--shopping-basket"
    , 'cart-link administration-cart', 'fa fa-shopping-bag', 'cart-count'
    , 'fa fa-times'
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
    initViewDataLocalStorage();
    _cart();
    _managerItemsOrders();
});

function initViewDataLocalStorage() {
    if ($cookiesManager['init_cart'] == 'allow' || $cookiesManager['init_cart'] == null) {
        if (!localStorage.getItem('shop')) {
            var managerData = [];
            localStorage.setItem('shop', JSON.stringify(managerData));
        }
    } else {
        localStorage.removeItem('shop');
    }
    viewDataShop();
}


function _managerItemsOrders() {

}

function _viewOrderCart() {
    $('html').addClass('cart-show');
}

/*STEP 1*/
function viewDataShop() {
    var dataManagerShopping = allowManagerShopping();
    itemsShop = [];
    if (dataManagerShopping.success) {
        var itemsShop = dataManagerShopping.data;
        $.each(itemsShop, function (index, value) {
            setItemsShopInit(index, value);
        });
        $(configElementOrders.empty).addClass('not-view');
    } else {
        $(configElementOrders.managerItem.one).remove();
        $(configElementOrders.managerItem.two).remove();
        $(configElementOrders.empty).removeClass('not-view');

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
        if (false) {
            $.each(itemsShopCurrent, function (index, value) {
                if (value.id == currentId) {
                    newData = false;
                    countCurrent = parseInt(countCurrent) + parseInt(itemsShopCurrent[index]['count']);
                    itemsShopCurrent[index]['count'] = countCurrent;
                    indexCurrent = index;
                    return;
                }
            });
        }
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


    nameProduct = nameProduct;

    var result = [];
    var currentUrl = $rootUrl + '/eventDetails/' + data.id;
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
            '           <span class="price"> $' + data.price + '</span>',
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
            '       <span class="management-orders__items-attributes management-orders__manager-team">  Team:' + data.team + '</span>',
            '       <span class="management-orders__items-attributes management-orders__manager-distance">  Distancia:' + data.distance + '</span>',
            '       <span class="management-orders__items-attributes management-orders__manager-qty">  Cant:' + data.count + '</span>',
            '       <span class="management-orders__items-attributes management-orders__manager-price"> $' + data.price + '</span>',
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
