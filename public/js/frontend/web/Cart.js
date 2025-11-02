
$(function () {
    viewCartPage(getItemsShop());
});

//STEP 2
function viewCartPage(itemsShop) {
    $('.cart-table tbody').html('');
    if (itemsShop.length > 0) {
        getViewsRowProduct({data: itemsShop});
        if (!$('#empty-products').hasClass('not-view')) {
            $('#empty-products').addClass('not-view');
        }
        $('#manager-shop-products').removeClass('not-view');
        $('#empty-products-loading').addClass('not-view');

        var itemsShopCurrent = getItemsShop();
        var resultShop = getItemsResultShop(itemsShopCurrent);

        $('.subtotal').html(resultShop.subtotal);
        var shipPrice = 0;
        var total = parseFloat(shipPrice) + parseFloat(resultShop.total);
        $('.total').html(total);

    } else {
        $('#empty-products').removeClass('not-view');
        if (!$('#manager-shop-products').hasClass('not-view')) {
            $('#manager-shop-products').addClass('not-view');
        }
        $('#empty-products-loading').addClass('not-view');
    }
}


//STEP 2 a)
function getViewsRowProduct($params) {
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
            var htmlRow = getRowCartProduct(index, value);
            $('.cart-table tbody').append(htmlRow);
            if (value.has_tax) {
                var managerProduct = getTotalManagerProduct(value);
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

function getRowCartProduct(index, data) {


    $languageCurrent = $language == 'es' ? null : $language;

    var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
    nameProduct = nameProduct + (' - ' + data.code);
    var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);
    ;

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
    var managerProduct = getTotalManagerProduct(data);
    var result = [
        '<tr id="tr-cart-' + index + '" product-id="' + index + '">',
        '   <td class="product-thumbnail">',
        '       <a href="productDetails/' + data.id + '">',
        '           <img src="' + $publicAsset + data.source + '" class="img-fluid" alt="' + nameProduct + '">',
        '       </a>',
        '   </td>',
        '   <td class="product-name">',
        '       <a href="#">' + nameProduct + ' </a>',
        data.color ? '<span class="product-variation">Color: ' + data.color + '</span> ' : '',
        '   </td>',
        '   <td class="product-price">',
        '     <span class="price">$' + managerProduct.sale_price + '</span>',
        '   </td>',
        '   <td class="product-quantity">',
        '      <div class="pro-qty d-inline-block mx-0">',
        '         <input disabled min="1" type="number" value="' + data.count + '">',
        '      </div>',
        '   </td>',
        '   <td class="total-price">',
        '     <span class="price">$' + (managerProduct.total) + '</span>',
        '   </td>',
        '   <td class="product-remove">',
        '       <a href="javascript:deleteRowCart({rowId:' + index + '})"><i class="fa fa-times"></i> </a>',

        '   </td>',

        '</tr>',

    ];
    result = result.join('');
    return result;
}


function deleteRowCart(params) {
    var rowId = params['rowId'];

    var selectorRow = $('#tr-cart-' + rowId);
    selectorRow.remove();
    deleteItem(rowId);
    var itemsShop = getItemsShop();
    viewCartPage(itemsShop);
}
