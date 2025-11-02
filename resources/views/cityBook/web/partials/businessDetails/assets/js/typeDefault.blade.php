
{{-- BUSINESS DETAILS--JS  --}}
<script>
    var $paramsRequest = <?php echo json_encode($paramsRequest); ?>;
    var $dataManagerPage = <?php echo json_encode($dataManagerPage); ?>;
    var $business_id = <?php echo $dataManagerPage['business_id']; ?>;
    var $currentApp;

</script>

<script>
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

            $('.chosen-select').niceSelect('update');
        });
        $('.a-subcategory').on('click', function () {

            var categoryCurrent = $(this).attr('category');
            console.log('hoalada')
            $.each($('.li-subcategory.mm-active'), function (index, value) {

                if ($(value).attr('category') != categoryCurrent) {
                    $(value).removeClass('mm-active');
                }
            });
            $('.a-subcategory.mm-active').removeClass('mm-active');
            $(this).addClass('mm-active');
            $('#category').val($(this).attr('category'));
            $('#subcategory').val($(this).attr('subcategory'));
            $(selectorGrid).bootgrid("reload");
            if ($('.content-filter').hasClass('not-view')) {

                $('.content-filter').removeClass('not-view');
            }
        });
        $('.content-filter').on('click', function () {

            $('.menu-manager-categories__li.mm-active').removeClass('mm-active');
            $('.li-subcategory.mm-active').removeClass('mm-active');
            $('.content-filter').addClass('not-view');
            $('#category').val('');
            $('#subcategory').val('');
            $(selectorGrid).bootgrid("reload");
        });

    }

    //ECCOMERCE-001
    //GRID DETAILS BUSINESS
    function getViewsRowProduct($params) {

        $languageCurrent = $language == 'es' ? null : $language;
        var type = $params['type'];
        var data = $params['data'];
        var result;
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
                '<span class="main-price discounted">$' + valueWithoutDiscount +
                '</span> <span class="discounted-price">$' + valueWithDiscount + '</span>',
                '      </div>'
            ];
            business_by_discount_value = '-' + business_by_discount_value + ' %';
            discountImageHtml = [
                ' <div class="product-badge-wrapper">',
                '<span class="onsale">' + business_by_discount_value + '</span>',
                ' <span class="hot">Hot</span>',
                '</div>'
            ]

        } else {
            valueCurrentHtml = [
                '         <div class="price  price--grid-manager"><span class="main-price">$' + valueCurrent +
                '</span></div>'
            ];

        }
        valueCurrentHtml = valueCurrentHtml.join('');
        discountImageHtml = discountImageHtml.join('');
        var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data[
            'name_lang'] ? data['name_lang'] : data['name']);
        nameProduct = nameProduct + (' - ' + data.code);
        var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty(
            'description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);

        var currentUrl = $productDetailsRoute.replace("change", data.id);
        var allowHref = "{{env('allowProcessDetailsProduct')?1:0}}";
        var currentHref = allowHref == "0" ? "" : "href='" + currentUrl + "'";

        var allowHref = "{{env('allowProcessDetailsProduct')?1:0}}";
        var currentHref = allowHref == "0" ? "" : "href='" + currentUrl + "'";
        var buttonsConfigLabels = {
            one: $labelsData['business']['e-ccomerce']['buttons'][0],
            two:$labelsData['business']['e-ccomerce']['buttons'][1]
        };

        var allowViewButtonStock = false;
        var textTypeProduct = 'Servicio';
        var stockHtml = "";
        var productPointsHtml = [];//PRODUCT-004
        if (data['gamification_by_points_points']) {
            var pointsCurrent = parseFloat(data['gamification_by_points_points']);
            var titleMain = $labelsData['business']['product'][0];
            var titleMainSecond =$labelsData['business']['product'][1];
            var titleMainThird = $labelsData['business']['product'][2] +(pointsCurrent>0?'s':"");
            productPointsHtml = [
                '<h3 > <span class="product-information__title-main">' + titleMain + '</span> '+titleMainSecond+' <span class="badge product-information__badge-points">' + pointsCurrent + '</span> '+titleMainThird+'</h3>'
            ];
        }
        productPointsHtml = productPointsHtml.join('');

        var classType='management-other-information__type-product';
        if (data['is_service'] == 0) {//PRODUCT-003
            var quantityCurrent = getValueCustomer(data['quantity_units']);
            if (quantityCurrent > 0) {
                allowViewButtonStock = true;
                stockHtml = '<h2>Stock<span class="badge management-other-information__stock management-other-information__stock--exist">' + quantityCurrent + '</span></h3>'
            } else {
                stockHtml = '<h2> Stock <span class="badge management-other-information__stock management-other-information__stock--empty">' + quantityCurrent + '</span></h3>'

            }
            textTypeProduct = 'Producto';

        } else {
            allowViewButtonStock = true;
            classType='management-other-information__type-service';
            stockHtml = "";
        }
        var managementOtherInformation = [
            '<div class="management-other-information">',
            '<h3> <span class="badge '+classType+'">' + textTypeProduct, '</span></h3>',
            stockHtml,
            productPointsHtml,

            '</div>'
        ];
        managementOtherInformation = managementOtherInformation.join('');
var allowClassViewSearch=$allowShop == 1?'':'single-icon--add-to-cart--not-shop';
        var shoppingButton = $allowShop == 1 && allowViewButtonStock ? [
            '             <span class="single-icon single-icon--add-to-cart   "+allowClassViewSearch+" " product-id="' + data.id + '">',
            '                  <a  product-id="' + data.id +
            '"   class="add-cart add-cart--shop" href="javascript:void(0)" data-tippy="' + buttonsConfigLabels.one +
            '"',
            '                    data-tippy-inertia="true"',
            '                     data-tippy-animation="shift-away"',
            '                     data-tippy-delay="50" ',
            '                      data-tippy-arrow="true"',
            '                     data-tippy-theme="sharpborder"> ',
            '                      <i class="fa fa-shopping-basket"></i>',
            '                        <span>' + buttonsConfigLabels.two + '</span>',
            '                  </a> ',
            '             </span> '
        ] : [];
        shoppingButton = shoppingButton.join('');

        var viewButtonProduct = $allowShop == 1 ? [
            '              <span class="single-icon single-icon--quick-view" row-id="row-' + data.id + '"> ',
            '                    <a  id="row-' + data.id +
            '" class="cd-trigger cd-trigger--manager-quick-view" data-tippy="Quick View" ',
            '                        data-tippy-inertia="true"',
            '                        data-tippy-animation="shift-away"',
            '                       data-tippy-delay="50" ',
            '                       data-tippy-arrow="true"',
            '                       data-tippy-theme="sharpborder">',
            '                      <i class="fa fa-search"></i> ',
            '                    </a> ',
            '              </span>',
        ] : [
            '              <span class="single-icon single-icon--quick-view single-icon--quick-view--not-basket"   row-id="row-' +
            data.id + '"> ',
            '                    <a  id="row-' + data.id +
            '" class="cd-trigger cd-trigger--manager-quick-view" data-tippy="Quick View" ',
            '                        data-tippy-inertia="true"',
            '                        data-tippy-animation="shift-away"',
            '                       data-tippy-delay="50" ',
            '                       data-tippy-arrow="true"',
            '                       data-tippy-theme="sharpborder">',
            '                      <i class="fa fa-search"></i> ',
            '                            Ver Producto',
            '                    </a> ',
            '              </span>',

        ];
        viewButtonProduct = viewButtonProduct.join('');


        if (type == 1) { //grid
            result = [
                ' <div class="col-12">',
                '   <div class="single-list-product">',
                '       <div class="single-list-product__image">',
                '        <a product-id="' + data.id + '" href="javascript:void(0)" class="favorite-icon ' + (data
                    .product_id_whishlist ? 'favorite-icon-active' : '') + '" data-tippy="Add to Wishlist"',
                '            data-tippy-inertia="true" data-tippy-animation="shift-away"',
                '             data-tippy-delay="50" data-tippy-arrow="true"',
                '             data-tippy-theme="sharpborder" data-tippy-placement="left">',
                '             <i class="fa fa-heart-o add-wish-list add-wish-list--admin"></i>',
                '              <i class="fa fa-heart"></i>',
                '        </a>',
                discountImageHtml,
                '        <a  ' + currentHref + ' class="image-wrap">',
                '           <img src="' + $publicAsset + data.source + '" class="img-fluid" alt="">',
                '        </a> ',
                '      </div>',
                '     <div class="single-list-product__content">',
                managementOtherInformation,
                valueCurrentHtml,
                '         <h3 class="title"><a   ' + currentHref + ' >' + nameProduct + '</a></h3>',
                '         <p class="product-short-desc">' + descriptionProduct,
                '         </p>',
                '         <div class="product-hover-icon-wrapper">',
                viewButtonProduct,
                shoppingButton,

                '         </div>',
                '   </div>',
                '</div>',

            ];
        }

        result = result.join('');
        return result;
    }

    function getFilters() {

        var result = {
            business_id: $business_id,
            category: $('#category').val() ? $('#category').val() : -1,
            subcategory: $('#subcategory').val() ? $('#subcategory').val() : -1,
            'language': $language
        };
        return result;
    }

    var selectorGrid = '#product-grid';
    //typeThree
    function InitGridManager() {
        var gridName = selectorGrid;
        var urlCurrent = $('#action-manager-business').val();
        var paramsFilters = {
            business_id: $business_id,
            'language': $language
        };
        var formatters = {
            'description': function (column, row) {
                var resultHtml = getViewsRowProduct({
                    data: row,
                    type: 1
                });
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
            if ($("#content-manager-products-services").addClass('not-view')) {
                $("#content-manager-products-services").removeClass('not-view');
            }

            $('#view-list').click();
            $(".add-cart").unbind('click');
            /*    _managerItemsOrdersQuickView();*/
            _managerItemsOrders();
            //add new
            _managerItemsOrdersQuickView();
            /*   initEventWhishList();*/
            $('.shop-content-wrapper-loading').hide();
            $('.shop-content-wrapper').show();
            $("#content-manager-products-services").removeClass('not-view');
            $('#init-loading').addClass('not-view');
        });
    }

</script>


<script>
    const app = new Vue({
        directives: {
            'init-listing-items': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            },
            'init-menu-shop': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            },
            'init-bootgrid': {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    var initMethod = paramsInput['initMethod'];
                    initMethod({
                        elementInit: el,
                        params: paramsInput
                    });
                }
            }
        },
        el: '#app-management',
        created: function () {

            initApisSocialNetworks();
            $currentApp = this;
            var $scope = this;
            $(function () {
                initShareWhatsapp($scope)
                $scope.initManagement();
                $('.show-search-button').show();
                $('#management-product-details').on('click', function () {
                    $scope._managementProductDetails();
                });
            });

            this.$root.$on("_productRowGrid", function (emitValue) {
                $scope._managerTypes(emitValue);

            });
        },
        data: function () {
            var result = getDataStructure({type: 0})
            return result;
        },
        methods: {
            onListenElementsForm:onListenElementsForm,

            //EVENTS OF CHILDREN
            _managerTypes: function (emitValues) {
                if (emitValues.type == "resetComponent") {
                    this[emitValues.componentName] = {
                        viewAllow: false,
                        data: {}
                    };

                }
            },

            initMenuShop: function (params) {
                var elementInit = params.elementInit;
                $(elementInit).metisMenu({
                    toggle: true
                });
            },
            initGridShop: initGridShop,
            _searchData: _searchData,
            initManagement: function () {
                this.initMapCurrent();
                this._eventsProfile();
            },
            _eventsProfile: _eventsProfile,
            getUrlContact: getUrlContact,
            _element: function (e) {
                console.log(e);
            },
            initMapCurrent: initMapCurrent,
            _eventsMapCurrent: function () {

            },
            _managerDataItemsMap: function (params) {
            },
            getDataShare: function () {
                return getDataShare();
            },
            _shareType: _shareType,
            //MODAL
            _managementProductDetails: _managementProductDetails,

        }
    });

</script>
<script>
    $(function () {

        $('.show-search-button').show();
    })

</script>
