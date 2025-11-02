function getFilters() {
    var result = {
        business_id: 1,
        category: $('#category').val() ? $('#category').val() : -1,
        'language': $language
    };
    if ($paramsRequest.hasOwnProperty('categoryId') && $paramsRequest.categoryId != '-1') {

    }
    return result;
}

function GridManager(params) {
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


function InitGridManager() {
    console.log('shop events');

    var gridName = selectorGrid;
    var urlCurrent = $rootUrl + '/eventsTrailsProject/adminFrontend';


    var paramsFilters = {
        business_id: 1,
        'language': $language
    };


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
        $('.shop-content-wrapper-loading').hide();
        $('.shop-content-wrapper').show();
        initCurrentTakePart();
    });
    if ($paramsRequest.hasOwnProperty('search') && $paramsRequest.search != 'null') {
        $(selectorGrid).bootgrid("search", $paramsRequest.search);
    }


}


function getViewsRowProduct($params) {


    $languageCurrent = $language == 'es' ? null : $language;
    var type = $params['type'];
    var data = $params['data'];
    var result;
    var valueCurrent = parseFloat(data.sale_price ? data.sale_price : 0);
    var allowDiscount = data.business_by_discount_id != null ? true : false;
    var valueCurrentHtml = [];
    var discountImageHtml = [];

    valueCurrentHtml = [
        '         <div class="price  price--grid-manager not-view"><span class="main-price">$' + valueCurrent + '</span></div>'
    ];

    valueCurrentHtml = valueCurrentHtml.join('');
    discountImageHtml = discountImageHtml.join('');
    var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
    nameProduct = nameProduct + (' - ' + data.id);
    var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);

    var currentUrl = $rootUrl + '/eventDetails/' + data.id;

    var shoppingButton = $allowShop == 1 ? ['             <span class="single-icon single-icon--add-to-cart">',
        '                  <a   product-id="' + data.id + '"   class="add-cart add-cart--shop" href="javascript:void(0)" data-tippy="' + $buttonsConfig.names['three'] + '"',
        '                    data-tippy-inertia="true"',
        '                     data-tippy-animation="shift-away"',
        '                     data-tippy-delay="50" ',
        '                      data-tippy-arrow="true"',
        '                     data-tippy-theme="sharpborder"> ',
        '                      <i class="fa fa-shopping-basket"></i>',
        '                        <span>' + $buttonsConfig.names['three'] + '</span>',
        '                  </a> ',
        '             </span> '] : [];
    shoppingButton = shoppingButton.join('');

    var viewButtonProduct = $allowShop == 1 ?
        [
            '              <span class="single-icon single-icon--quick-view"> ',
            '                    <a  id="row-' + data.id + '" class="cd-trigger cd-trigger--manager-quick-view" href="#qv-1" data-tippy="' + $buttonsConfig.names['two'] + '" ',
            '                        data-tippy-inertia="true"',
            '                        data-tippy-animation="shift-away"',
            '                       data-tippy-delay="50" ',
            '                       data-tippy-arrow="true"',
            '                       data-tippy-theme="sharpborder">',
            '                      <i class="fa fa-search"></i> ',
            '                    </a> ',
            '              </span>',
        ] : [];
    viewButtonProduct = viewButtonProduct.join('');

    if (type == 1) {//grid
        result = [
            ' <div class="col-lg-4 col-md-6 col-sm-6 col-custom-sm-6 col-12">',
            '   <div class="single-list-product">',
            '      <div class="product-badge-wrapper">' ,
            '        <span class="onsale">'+data.business+'</span>' ,
            '       </div>',
            '       <div class="single-list-product__image">',
            '        <a product-id="' + data.id + '" href="javascript:void(0)" class="favorite-icon ' + (data.product_id_whishlist ? 'favorite-icon-active' : '') + '" data-tippy="Add to Wishlist"',
            '            data-tippy-inertia="true" data-tippy-animation="shift-away"',
            '             data-tippy-delay="50" data-tippy-arrow="true"',
            '             data-tippy-theme="sharpborder" data-tippy-placement="left">',
            '             <i class="fa fa-heart-o add-wish-list add-wish-list--admin not-view"></i>',
            '              <i class="fa fa-heart"></i>',
            '        </a>',
            discountImageHtml,
            '        <a href="' + currentUrl + '" class="image-wrap">',
            '           <img src="' + $resourceRoot + data.source + '" class="img-fluid" alt="">',
            '        </a> ',
            '      </div>',
            '     <div class="single-list-product__content">',
            '         <h3 class="title"><a href="' + currentUrl + '">' + nameProduct + '</a></h3>',
            '         <h5 class="subttitle">Fecha maximo inscripcion:' + data['date_end_project'] + '</h5>',

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
    var sliderFinalWidth = 400,
        maxQuickWidth = 900;
    if ($allowShop == 0) {
        $('.manager-basket-inputs').remove();
    }
    //manager view
    initManagementEvents({
        type: "shopEvents"
    });
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
        var categoryCurrent = $(this).parent().attr('category');
        $('.li-category.active').removeClass('active');
        $('.li-category a.active').removeClass('active');

        $('#category').val(categoryCurrent);
        if ($('.content-filter').hasClass('not-view')) {

            $('.content-filter').removeClass('not-view');
        }
        $(this).addClass('active');
        $(selectorGrid).bootgrid("reload");


    });

    $('.content-filter').on('click', function () {

        $('.li-category.active').removeClass('active');
        $('.li-category a.active').removeClass('active');
        $('.content-filter').addClass('not-view');
        $('#category').val('');
        $('#subcategory').val('');
        $(selectorGrid).bootgrid("reload");
    });

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

});

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
var appThisComponent = null;
var appInit = new Vue(
    {
        el: '#management-take-part',
        created: function () {
            var $scope = this;
            this.$root.$on("_carouselEvents", function (emitValue) {
                $scope._managerTypes(emitValue);
            });
            appThisComponent=$scope;
        },
        mounted: function () {
            var $scope = this;

        },

        data: function () {
            var result = {
                loadPage: false,
                configModalManagementFormEvent: {
                    viewAllow: false
                }
            };

            return result;
        },
        methods: {
            ...$methodsFormValid,
            _managementTakePart: function (params) {

                var selectorId = params['id'];
                var rowData = getValueCurrentRow({
                    currentId: selectorId
                });
                this.configModalManagementFormEvent.data = rowData[0];
                this.configModalManagementFormEvent.viewAllow = true;

            },
            _managerTypes: function (emitValues) {
                if (emitValues.type == "resetComponent") {
                    this.configModalManagementFormEvent.viewAllow = false


                }
            },
        },

    })
;
function initCurrentTakePart(){
    $('.add-cart--shop').on('click', function (event) {

        var selectorId = $(this).attr('product-id');
        appThisComponent._managementTakePart({
            id:selectorId,
        });

    });
}
