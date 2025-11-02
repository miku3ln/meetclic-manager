<!DOCTYPE HTML>
<html
    <?php echo $pageSectionsConfig['contactTop']['language']['view'] ? ' lang="' . $dataManagerPage['languageHeader']['language'] . '"   xml:lang="' . $dataManagerPage['languageHeader']['language'] . '"' : '' ?>>

<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <?php
    $isUser = Auth::check();
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/eatPura/';
    $logoSrc = URL::asset($themePath . '/img/logo.png');

    if (isset($dataManagerPage["logoMainData"]) && $dataManagerPage["logoMainData"] != null) {

        $logoSrc = URL::asset($resourcePathServer . $dataManagerPage["logoMainData"]->source);
    }
    ?>
        <!--=============== basic  ===============-->
    @include('layouts.partials.headMeta')
    @include('layouts.eatPura.typeHtml.styles')

    <style id="style-over-write">
        .disabled-click {
            display: none;
            pointer-events: none; /* Deshabilita el clic */
            opacity: 0.6; /* Reduce la opacidad para indicar que está inhabilitado */
            cursor: not-allowed; /* Cambia el cursor para indicar que no se puede hacer clic */
        }
        .menu-mobile-content {
            padding-top: .25rem !important;
            padding-bottom: 3.25rem !important;
        }

        .not-view {
            display: none !important;
        }

        .app-management--not-view {
            display: none;

        }

        .loading-resources--view {

        }

        .loading-resources--not-view {
            display: none;
        }


        .loading-resources.loading-resources--view {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 1000;
        }

        .loading-resources p {
            font-size: 24px;
            font-weight: bold;
        }

        .dots::after {
            content: '';
            animation: dots 1.5s steps(5, end) infinite;
        }

        .floating-panel-manager {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        .floating-panel-manager__search {
            width: 580px;
        }

        .pac-container--view-modal {
            z-index: 10000;
        }

        .disabled-button-link {
            pointer-events: none; /* Desactiva los clics */
            opacity: 0.6; /* Opcional: disminuye la opacidad para mostrar que está deshabilitado */
        }
        .vh-100--view-data{
            height: 70vh !important;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column  vh-100--view-data">


<?php

$urlManagerPage = route('homeEatPura', app()->getLocale());

$urlShopPage = route('shopPage', app()->getLocale());
$addClassManagerHeader = $nameRoute == 'homeEatPura' ? '' : 'dark-header--back-line';

?>
<div class="loading-resources loading-resources--view">
    <p>Cargando......</p>
</div>
<div id="app-management" class="app-management--not-view">
    @if(isset($dataManagerPage['currentPage']))
        @if(($dataManagerPage['currentPage'])=="checkoutPage")
            <div class="d-flex align-items-center gap-3 p-3 bg-primary inner-page-heaer">
                <a href="{{$urlManagerPage}}" class="text-white"><i class="bi bi-arrow-left fs-5"></i></a>
                <div>
                    <h6 class="fw-bold text-white mb-0">Select Payment Method</h6>
                    <p class="text-white-50 small m-0">

                        @if(isset($dataManagerPage['dataPage']['information']))
                            {{$dataManagerPage['dataPage']['information']['name']}}
                        @else
                            Not Name
                        @endif

                    </p>
                </div>
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#mycart" aria-controls="mycart"
                       class="link-dark">
                        <div class="bg-dark bg-opacity-75 rounded-circle user-icon"><i
                                class="bi bi-basket d-flex m-0 h5 text-white"></i></div>
                    </a>
                    <a class="toggle hc-nav-trigger hc-nav-1" href="#" type="button" data-bs-toggle="offcanvas"
                       data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                       aria-label="Toggle navigation">
                        <b class="bg-dark bg-opacity-75 rounded-circle user-icon">
                            <i class="bi bi-list d-flex m-0 h4 text-white"></i>
                        </b>
                    </a>
                </div>
            </div>
        @else
            <div class="homepage-navbar shadow mb-auto p-3 bg-primary">
                <div class="d-flex align-items-center">
                    <a href="#" class="link-dark text-truncate d-flex align-items-center gap-2"
                       data-bs-toggle="offcanvas"
                       data-bs-target="#location" aria-controls="location">
                        <i class="icofont-clock-time fs-2 text-white"></i>
                        @if(isset($dataManagerPage['dataPage']['information']))

                            <span>
              <h6 class="fw-bold text-white mb-0">{{$dataManagerPage['dataPage']['information']['name']}}</h6>
              <p class="text-white-50 text-truncate d-inline-block mb-0  align-bottom">
                  {{$dataManagerPage['dataPage']['information']['address']['primary'].','.$dataManagerPage['dataPage']['information']['address']['secondary']}}

              </p>
           </span>
                        @endif
                    </a>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#mycart" aria-controls="mycart"
                           class="link-dark">
                            <div class="bg-dark bg-opacity-75 rounded-circle user-icon"><i
                                    class="bi bi-basket d-flex m-0 h5 text-white"></i></div>
                        </a>
                        <a class="toggle hc-nav-trigger hc-nav-1" href="#" type="button" data-bs-toggle="offcanvas"
                           data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                           aria-label="Toggle navigation">
                            <b class="bg-dark bg-opacity-75 rounded-circle user-icon">
                                <i class="bi bi-list d-flex m-0 h4 text-white"></i>
                            </b>
                        </a>
                    </div>
                </div>
                <div class="pt-3">
                    <!-- search -->
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#searchoffcanvas"
                       aria-controls="searchoffcanvas"
                       id="manager-search-page">
                        <div class="input-group bg-white rounded-3 shadow-sm py-1">
                            <input
                                v-model="dataManagerProducts.filters.searchPhrase"
                                @change="onChangeSearchData()"
id="input-data-product-search"
                                type="text" class="form-control bg-transparent border-0 rounded-0 px-3"
                                placeholder="{{__('frontend.web.eatPura.frontend.menu.sixteen')}}"
                                aria-label="{{__('frontend.web.eatPura.frontend.menu.sixteen')}}"
                                aria-describedby="search">
                            <span
                                @click="onSearchData()"
                                class="input-group-text bg-transparent border-0 rounded-0 pe-3" id="search"><i
                                    class="icofont-search-1"></i>
                </span>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    @endif
    <div class="vh-100 my-auto overflow-auto ">
        @if(isset($dataManagerPage['currentPage']))
            @if($dataManagerPage['currentPage']=="checkoutPage")
                @include('layouts.eatPura.menu.topHeader')
            @else
                <div class="homepage-one-header">
                    <!-- Navbar -->
                    <div class="homepage-nav-one-header">
                        @include('layouts.eatPura.menu.topHeader')


                    </div>
                    <!-- Body -->
                </div>
            @endif
        @endif

        <!--  header end -->
        <!--  wrapper  -->
        <div id="wrapper-content">

            @yield('content-manager')


        </div>
        @include('layouts.eatPura.modals-inits')
        @yield('additional-modal')

    </div>
    @yield('additional-button-checkout')
    @if(isset($dataManagerPage['allowFooterMenu']) && $dataManagerPage['allowFooterMenu']==true)
            @include('layouts.eatPura.menu.footer')
    @endif
</div>
<script id="manager-shop-function">
    var $methodsShopCartPage = {};
    var $methodsCheckoutPage = {};
    var $dataConfigMain = {

        cartManager: {
            "title": "Mis Compras",
            "empty": "No existe Productos en su Carrito de Compras.!",
            "toDo": "Proceder",
            "result":{
                "one":"items",
                "two":"$",

            },
        },

        addressManager: {
            "title": "Mis Direcciones",
            "empty": "No existe Direcciones",
            "addNew": "Agregar Nueva",
            "subTitle": "Seleccione Dirección de Entrega",
            "toDo": "Listo",

        },
        cartManagerAddress: {
            "title": "Mis Compras",
            "empty": "No existe Productos en su Carrito de Compras.!",
            "toDo":"Proceder Pago",
            "result":{
                "one":"items",
                "two":"$",
                "three":"Cambiar",

                "four":"Total",

            },
        },
    };


    $methodsShopCartPage.initCurrentComponentShopCart = initCurrentComponentShopCart;
    $methodsShopCartPage.onSetProductCart = onSetProductCart;
    $methodsShopCartPage.onDeleteProductCart = onDeleteProductCart;
    $methodsShopCartPage.getUrlResource = getUrlResource;
    $methodsShopCartPage.setMessageParentByChildren = setMessageParentByChildren;
    $methodsShopCartPage.setResultShopCart = setResultShopCart;
    $methodsShopCartPage.onManagerProductByModalCart = onManagerProductByModalCart;

    var $managerUtils = {};
    var $utilCustomer = null;

    function onManagerProductByModalCart(params) {


        let paramsSet = {
            managerAdd: params.type == 3 ? false : true,
            type: 1,
            row: params.row,
        };
        console.log("onManagerProductByModalCart");
        this.onSetProductCart(paramsSet);
    }

    function setMessageParentByChildren(params) {
        console.log(params);

        //   this.dataManagerProductsShopCart.result=result;
    }

    function initCurrentComponentShopCart() {
        console.log("initCurrentComponentShopCart");

        var dataManagerProductsShopCartData = localStorage.getItem('dataManagerProductsShopCartData');
        dataManagerProductsShopCartData = JSON.parse(dataManagerProductsShopCartData);
        var dataManagerProductsShopCartDataSet = [];
        if (dataManagerProductsShopCartData != null && dataManagerProductsShopCartData.length > 0) {
            dataManagerProductsShopCartDataSet = dataManagerProductsShopCartData;
        }
        this.dataManagerProductsShopCart.data = dataManagerProductsShopCartDataSet;
        this.setResultShopCart(dataManagerProductsShopCartDataSet);
    }

    function setResultShopCart(products) {
        var total = 0;
        if (false) {

            result = products.map(product => {
                const salePrice = parseFloat(product.sale_price) || 0;
                const amountSale = product.count || 0;
                return {
                    ...product,
                    totalPrice: (salePrice * amountSale).toFixed(2)  // Calcula el precio total y redondea
                };
            });
        }
        for (let i = 0; i < products.length; i++) {
            var product = products[i];
            const salePrice = parseFloat(product.sale_price) || 0;
            const amountSale = product.count || 0;
            var totalPrice = (salePrice * amountSale);
            total += totalPrice;

        }
        console.log("setResultShopCart");
        this.dataManagerProductsShopCart.result.total = total;
    }

    function onSetProductCart(params) {//SET PRODUCT MY SHOP

        var type = params.type;
        var rowObject;
        if (type == 1) {//TYPE DATA ROW
            rowObject = (params.row);
        } else {//TYPE DATA STRING
            rowObject = JSON.parse(params.row);
        }
        let addManager = true;
        if ('managerAdd' in params) {
            addManager = params.managerAdd;
        }
        var rowId = rowObject.id;
        var dataManagerProductsShopCartData = localStorage.getItem('dataManagerProductsShopCartData');
        dataManagerProductsShopCartData = JSON.parse(dataManagerProductsShopCartData);
        var dataManagerProductsShopCartDataSet = [];
        if (dataManagerProductsShopCartData != null && dataManagerProductsShopCartData.length == 0) {
            dataManagerProductsShopCartDataSet.push(rowObject);
        } else {
            var searchData = searchByIdWithIndex(dataManagerProductsShopCartData, rowId);
            if (searchData == null) {
                rowObject.count = 1;
                if (dataManagerProductsShopCartData == null) {
                    dataManagerProductsShopCartData = [];
                }
                dataManagerProductsShopCartData.push(rowObject);
            } else {

                var currentAmount = dataManagerProductsShopCartData[searchData.index].count;
                let currentManagerAdd = -1;
                if (addManager) {
                    currentManagerAdd = 1;
                } else {
                    currentManagerAdd = -1;
                }
                dataManagerProductsShopCartData[searchData.index].count = (currentAmount + currentManagerAdd);
            }
            dataManagerProductsShopCartDataSet = dataManagerProductsShopCartData;
        }
        localStorage.setItem('dataManagerProductsShopCartData', JSON.stringify(dataManagerProductsShopCartDataSet));
        localStorage.setItem('shop', JSON.stringify(dataManagerProductsShopCartDataSet));
        this.dataManagerProductsShopCart.data = dataManagerProductsShopCartDataSet;
        this.setResultShopCart(dataManagerProductsShopCartDataSet);
    }

    function getUrlResource(rootResource) {
        var result = $uriAsset + rootResource;
        return result;
    }

    function searchByIdWithIndex(jsonData, needleId) {
        if (jsonData == null) {
            return null;
        } else {
            const index = jsonData.findIndex(item => item.id === needleId);
            if (index !== -1) {
                return {index: index, item: jsonData[index]};
            }
        }

        return null; // Si no se encuentra, retorna null
    }

    function onDeleteProductCart(params) {
        console.log("onDeleteProductCart", params);
    }
</script>
@include('layouts.eatPura.typeHtml.scripts')
<script>

    var $businessMainInformation = <?php echo json_encode($businessMainInformation) ?>;
    var $dataManagerPage = <?php echo json_encode($dataManagerPage) ?>;

    var $nameRoute = '<?php echo($nameRoute) ?>';

    var $allowHome = <?php echo($nameRoute == 'homeEatPura' ? 1 : 0) ?>;
    var $urlMain = "<?php echo(route('homeEatPura', app()->getLocale())) ?>";


    function initWhatsAppSend() {//CMS-TEMPLATE-WHATSAPP-SEND-JS
        if ($businessMainInformation.allow) {
            var informationBusiness = $businessMainInformation.data.information;
            var phoneCurrent = informationBusiness.phone_code + informationBusiness.phone_value;
            let params = {
                dataParams: {
                    phone: '+' + phoneCurrent,
                    text: 'Deseamos saber sobre el proceso de Meetclic.',
                }


            };
            let urlCurrent = getUrlWhatsApp() + 'send?' + getStringParamsGet(params);
            console.log('urlCurrent', urlCurrent);
            let result = urlCurrent;
            $('.chat-widget-button-content').attr('href', urlCurrent);
            $('#manager-whatsapp-copy-right').attr('href', urlCurrent);

        }
        console.log('initWhatsAppSend');

    }


    $(document).ready(function () {

        $(window).scroll(function () {


        });


    });
</script>
@yield('data-modal')
</body>
</html>
