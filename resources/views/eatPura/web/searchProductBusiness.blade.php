{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

    $themePath = $resourcePathServer . 'templates/eatPura/';
        $assetsRoot = $resourcePathServer . 'assets/backline/';
        $sourceRoot=URL::asset($themePath );
$urlCurrentSearch=route('search',app()->getLocale());

@endphp
@extends('layouts.eatPura')
@section('additional-styles')
    <style>
        #limit-data {
            height: 10px;
        }

        span.details-units--title {
            font-weight: bold;
        }
    </style>
@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
            integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@endsection
@section('additional-init-script-vue')
    <script id="additional-sub-category-vue">

        function getProductManager(params) {
            const {searchPhrase} = params;
            return $.ajax({
                url: "{{ route('productManager') }}",
                method: "POST",
                data: JSON.stringify({searchPhrase}),
                contentType: "application/json",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        Vue.component(
            'product-manager-component',

            {
                directives: {
                    'init-grid-filters': {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            paramsInput.initMethod({
                                objSelector: el
                            });


                        },
                    },
                    'init-carousel-product': {
                        inserted: function (el, binding, vnode, vm, arg) {
                            var paramsInput = binding.value;
                            console.log("initCarouselProduct", el, binding, vnode, vm, arg)


                        },
                    },
                },
                props: {

                    dataManager: {
                        type: Object,
                    }

                },
                data() {
                    return {
                        dataManagerSubcategoryManager: [],
                        checked: false,
                        title: 'Marcarme', // Puedes usar esto si lo necesitas
                        productManager: {
                            view: false,
                            data: {
                                gallery: "",
                                classCurrent: "",
                                classCurrent: "",
                                "product-details": "",
                            }
                        }
                    }
                },
                created: function () {
                    console.log("created", this.dataManager, this.dataManagerSubcategoryManager);

                    this.dataManagerSubcategoryManager = this.dataManager.data;

                },
                beforeMount: function () {

                    console.log("beforeMount ----------------------------------------", this.dataManager, this.dataManagerSubcategoryManager);


                },
                mounted: function () {
                    console.log("mounted", this.dataManager, this.dataManagerSubcategoryManager);
                    let $this = this;
                    $(window).on('load', function () {

                        $this.initPluginLector();


                    });
                },
                template: '#product-details-template',

                methods: {

                    getProductManager: getProductManager,
                    initDetailsProduct: function (params) {
                        console.log(params);
                    },
                    initCarouselProduct: function (params) {
                        console.log(params);

                        $('.big-img').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                            autoplay: true,
                            arrows: true,
                            prevArrow: "<i class='lni lni-chevron-left osahan-arrow osahan-left'></i>",
                            nextArrow: "<i class='lni lni-chevron-right osahan-arrow osahan-right'></i>",
                            fade: true,
                            asNavFor: '.small-img'
                        });
                        $('.big-img').fadeIn();
                    },

                    getGallery() {


                    },
                    onSearchDataProduct: async function (params) {
                        let configBlockElement = {
                            "selector": "", msj: "Cargando....."
                        };
                        blockContainerManager(configBlockElement);
                        console.log("initDataProduct");
                        const data = await getProductManager({searchPhrase: params.searchPhrase});
                        console.log("initDataProduct", data);

                        this.productManager.view = false;
                        this.productManager.data["product-details"] = "";
                        let productDetails = null;
                        if (data.success) {
                            productDetails = this.getProductDetails(data.information);
                            this.productManager.data["product-details"] = productDetails;
                            this.productManager.view = true;
                        } else {

                        }
                        this.$nextTick(() => {
                            this.initCarouselProduct({objSelector: this.$refs.productDetailsRef});
                        });
                        unblockContainerManager(configBlockElement);
                        console.log(productDetails, this.productManager);
                    },
                    getProductDetails(params) {
                        let {codecs, historic, preciosPorUnidades, prodLista} = params;
                        let codecsHtml = [];
                        let preciosPorUnidadesHtml = [];
                        let prodExistenciaHtml = [];
                        let prodListaHtml = [];

                        prodExistenciaHtml.push(`<div class="mb-4">`);
                        prodExistenciaHtml.push(`      <h6 class="fw-bold">Cantidad Existentes</h6>`);
                        prodExistenciaHtml.push(`       <ul class="list-unstyled d-grid gap-1 text-muted">`);
                        prodExistenciaHtml.push(`         <li>${params.PROD_EXISTENCIATOTAL}</li>`);
                        prodExistenciaHtml.push(`</ul>`);
                        prodExistenciaHtml.push(`</div>`);


                        if (codecs.length > 0) {
                            codecsHtml.push(`<div class="mb-4">`);
                            codecsHtml.push(`      <h6 class="fw-bold">Códigos Vinculados</h6>`);
                            codecsHtml.push(`       <ul class="list-unstyled d-grid gap-1 text-muted">`);

                            codecs.forEach(function (item, index) {
                                codecsHtml.push(`         <li>${item.PRBA_CODIGO}</li>`);

                            });
                            codecsHtml.push(`</ul>`);

                            codecsHtml.push(`</div>`);

                        }
                        if (prodLista.length > 0) {
                            prodListaHtml.push(`<div class="mb-4">`);
                            prodListaHtml.push(`      <h6 class="fw-bold">Listas Precios</h6>`);
                            prodListaHtml.push(`       <ul class="list-unstyled d-grid gap-1 text-muted">`);

                            prodLista.forEach(function (item, index) {
                                let badge = [`<label class="btn btn-outline-secondary" >RD:${item.PROD_PRECIO}</label>`];
                                let allData = [
                                    '<div class="details-units">',
                                    `  <span class="details-units--title">Precio  </span><span class="details-units--value">${item.LIST_NOMBRE}</span>`,
                                    '</div>',
                                    badge.join("")
                                ]
                                prodListaHtml.push(`         <li>${allData.join("")}</li>`);

                            });
                            prodListaHtml.push(`</ul>`);
                            prodListaHtml.push(`</div>`);

                        }

                        if (preciosPorUnidades.length > 0) {
                            preciosPorUnidadesHtml.push(`<div class="mb-4">`);
                            preciosPorUnidadesHtml.push(`      <h6 class="fw-bold">Precios por Unidades</h6>`);
                            preciosPorUnidadesHtml.push(`       <ul class="list-unstyled d-grid gap-1 text-muted">`);

                            preciosPorUnidades.forEach(function (item, index) {
                                let badge = [`<label class="btn btn-outline-secondary" >RD:${item.PRUN_PRECIO}</label>`];
                                let allData = [
                                    '<div class="details-units">',
                                    `  <span class="details-units--title">Tipo: </span><span class="details-units--value">${item.UNID_NOMBRE}</span>`,
                                    `  <span class="details-units--title">Conv: </span><span class="details-units--value">${item.PRUN_CONVERSION}</span>`,
                                    '</div>',
                                    badge.join("")
                                ]
                                preciosPorUnidadesHtml.push(`         <li>${allData.join("")}</li>`);

                            });
                            preciosPorUnidadesHtml.push(`</ul>`);
                            preciosPorUnidadesHtml.push(`</div>`);

                        }
                        let result = [
                            ` <div class="mb-lg-5" v-init-carousel-product>`,
                            `    <div class="big-img overflow-hidden mb-3 mx-2">`,
                            `       <div class="big-img-1">`,
                            `           <img src="https://192.168.137.1:9443/eatpura/img/category-3.jpg" alt=""`,
                            `                class="img-fluid d-block mx-auto">`,
                            `       </div>`,
                            `    </div>`,
                            `    <div  class="px-lg-3">`,
                            `      <div class="small-img">`,
                            `         <div class="small-img-1 mx-2">`,
                            `           <img src="https://192.168.137.1:9443/eatpura/img/category-3.jpg" alt="" class="img-fluid border rounded-4">`,
                            `         </div>`,

                            `      </div>`,
                            `    </div>`,

                            ` </div>`,
                            ` <div class="product-details pt-4">`,

                            `     <h1 class="fw-bold">${params.PROD_NOMBRE}</h1>`,
                            `     <a href="#" class="fs-5">${params.DEPA_NOMBRE}-${params.CLAS_NOMBRE}<i class="icofont-rounded-right fs-6"></i></a>`,

                            `      <h4 class="fw-bold pb-3">Producto Detalle</h4>`,
                            prodListaHtml.join(""),
                            preciosPorUnidadesHtml.join(""),
                            codecsHtml.join(""),
                            prodExistenciaHtml.join(""),

                            ` </div>`,


                        ];

                        return result.join("");

                    },
                    initPluginLector() {
                        $this = this;
                        const config = {
                            fps: 20,
                            qrbox: { width: 380, height: 380 },
                            experimentalFeatures: {useBarCodeDetectorIfSupported: false},
                            // 🔹 Opcional: algunos dispositivos permiten esto
                            videoConstraints: {
                                facingMode: "environment", // cámara trasera (mejor calidad)
                                focusMode: "continuous",   // auto-focus permanente
                                advanced: [{ zoom: 2 }]    // aumenta la sensibilidad visual
                            },
                            aspectRatio: 1.5, // cámara se ajusta más al formato rectangular
                            // 🔹 Recordar cámara elegida entre sesiones
                            rememberLastUsedCamera: true,
                            // formatos a soportar (QR + los códigos de barras más comunes)
                            formatsToSupport: [
                                // --- QR clásico ---
                                Html5QrcodeSupportedFormats.QR_CODE,

                                // --- 1D más usados en retail/industria ---
                                Html5QrcodeSupportedFormats.EAN_13,
                                Html5QrcodeSupportedFormats.EAN_8,
                                Html5QrcodeSupportedFormats.UPC_A,
                                Html5QrcodeSupportedFormats.UPC_E,
                                Html5QrcodeSupportedFormats.CODE_128,
                                Html5QrcodeSupportedFormats.CODE_39,
                                Html5QrcodeSupportedFormats.CODE_93,
                                Html5QrcodeSupportedFormats.ITF,       // Interleaved 2 of 5
                                Html5QrcodeSupportedFormats.CODABAR,   // usado en logística, librerías

                                // --- 2D adicionales ---
                                Html5QrcodeSupportedFormats.PDF_417,   // boarding pass, gov. IDs
                                Html5QrcodeSupportedFormats.DATA_MATRIX, // medicina, manufactura
                                Html5QrcodeSupportedFormats.AZTEC      // transporte, tickets
                            ]
                        };
                        const html5QrcodeScanner = new Html5QrcodeScanner('qr-code-full-region', config);
                        html5QrcodeScanner.render($this.onScanSuccess);
                    },
                    onScanSuccess(decodedText, decodedResult) {
                        console.log('onScanSuccess:', decodedText, decodedResult);
                        let $this = this;
                        // toma siempre el string del código
                        const value =
                            decodedText ||
                            (decodedResult && decodedResult.decodedText) ||
                            String(decodedResult || '');

                        if (value && value !== lastResult) {
                            lastResult = value;
                            console.log('Scan result:', value, decodedResult);
                            $this.$emit('message-to-parent', {value: value, type: "onScanSuccess"});
                        }

                    },
                    onScanError(err) {
                        let value = "code-error";
                        $this.$emit('message-to-parent', {value: value, type: "onScanSuccess"});

                    },
                    messageByParent: async function (params) {
                        console.log(params);

                        if (params.type == "onSearchDataProduct") {
                            let {filters, searchPhrase} = params.value;

                            await this.onSearchDataProduct({searchPhrase: searchPhrase});
                        }
                    }
                }
            }
        );

    </script>
    <script type="text/x-template" id="product-details-template">
        <div>
            <div class="col-lg-6 col-12 py-3">
                <div id="qr-code-full-region"></div>
                <div class="" v-init-grid-filters="{initMethod:initDetailsProduct}"></div>
            </div>
            <div class="col-lg-6 col-12 py-3"
                 ref="productDetailsRef"
                 v-if="productManager.view"
                 v-html="productManager.data['product-details']">

            </div>
        </div>

    </script>
@endsection
@section('additional-scripts-vue-before')
    <script>
        function onSearchDataProduct() {
            var _this = this;
            console.log("onSearchDataProduct", "_this", _this);

            this.$refs.lectorRef.messageByParent({
                type: "onSearchDataProduct",
                value: this.dataManagerProducts.filters

            });

        }

        function initCurrentComponent(params) {
            var $scope = params.this;
            console.log("initCurrentComponent MOUNTED", $scope);


        }

        function initManagementDataShop(params) {
            console.log("initManagementDataShop MOUNTED", params);

        }

        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;


        var $initByTypeGetData = 0;


        $(window).on('load', function () {


        });


        $(function () {
            // initQr();
        });

        function onChangeSearchData() {
            var _this = this;
            console.log("onChangeSearchData", "_this", _this);

        }

        $methodsShopPage.onSearchDataProduct = onSearchDataProduct;//SEARCH MAIN
        $methodsShopPage.onChangeSearchData = onChangeSearchData;//SEARCH MAIN
        $methodsShopPage.onSearchData = onSearchDataProduct;//SEARCH MAIN


    </script>

@endsection
@section('content-manager')

    <section class="border-bottom product-detail-page">
        <div class="container">
            <div class="actions">

                <input id="action_load_products_shop" type="hidden"
                       value="{{ route('getProductShopAdmin',app()->getLocale()) }}"/>
            </div>

            <div class="row">

                <product-manager-component
                    ref="lectorRef"

                    @search-product-business-events="onReceiveShopEvents"
                    @message-to-parent="onSearchProductBusiness"
                    :data-manager="{data:dataManagerSubcategory}"
                >

                </product-manager-component>


            </div>
        </div>
    </section>

@endsection

