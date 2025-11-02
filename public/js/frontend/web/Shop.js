

function InitGridManager() {
    console.log('shop ');

    var gridName = selectorGrid;
    var urlCurrent = $managerProductBusiness;


    var paramsFilters = {
        business_id: 1,
        'language': $language
    };

    console.log(paramsFilters);
    var formatters = {
        'description': function (column, row) {
            var resultHtml = getViewsRowProduct({data: row, type: 1});
            return resultHtml;
        }
    };

    let gridInit = GridManager({
        gridNameSelector: gridName,
        paramsFilters: paramsFilters,
        formatters: formatters,
        'urlCurrent': urlCurrent
    });

    gridInit.on("loaded.rs.jquery.bootgrid", function () {
        if (!$("#loading-data").hasClass('not-view')) {
            $("#loading-data").addClass('not-view');
        }
        if ($("#content-products").addClass('not-view')) {
            $("#content-products").removeClass('not-view');
        }
        if ($("#row-products").addClass('not-view')) {
            $("#row-products").removeClass('not-view');
        }

        $('#view-list').click();
        $(".add-cart").unbind('click');
        _managerItemsOrdersQuickView();
        _managerItemsOrders();
        initEventWhishList();
        $('.shop-content-wrapper-loading').hide();
        $('.shop-content-wrapper').show();

    });
    if ($paramsRequest.hasOwnProperty('search') && $paramsRequest.search != 'null') {
        $(selectorGrid).bootgrid("search", $paramsRequest.search);
    }


}


$(function () {

    $('#view-list').click();
    InitGridManager();
    initEventsFilters();
    if (!$dataManagerPageShopConfig['allowViewProducts']) {
        $('#init-loading').addClass('not-view');
        $("#row-products").removeClass('not-view');
    }
    _managerItemsOrders();
    if ($paramsRequest.hasOwnProperty('categoryId') && $paramsRequest.categoryId != '-1') {

        $('.li-category[category='+$paramsRequest.categoryId+']').children().first().click();
    }
});

