{{-- NONE CMS-TEMPLATE --}}
@php
    $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
    $themePath = $resourcePathServer . 'templates/eatPura/';
        $assetsRoot = $resourcePathServer . 'assets/backline/';
$urlCurrentSearch=route('search',app()->getLocale());

@endphp
@extends('layouts.eatPura')
@section('additional-styles')
    <style>
        #limit-data {
            height: 10px;
        }


    </style>
@endsection
@section('additional-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>

@endsection
@section('additional-init-script-vue')
    <script id="additional-sub-category-vue">

        Vue.component(
            'sub-category-component',

            {
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
                    initSubcategorySlider();
                },
                template: '#sub-category-template',

                methods: {
                    onFilterSubCategoryShopTopMenu: function (params) {
                        var emitData = {
                            data: params,
                            type: "onFilterSubCategoryShopTopMenu"
                        }
                        console.log("onFilterSubCategoryShopTopMenu", params);
                        this.$emit('on-emmit-shop-events', emitData);

                    },
                    //...$methodsFormValid,
                    getUrlResource: function (rootResource) {
                        var result = $uriAsset + rootResource;
                        return result;
                    },
                    onSetProductCart:function (params) {
                        this.$emit('message-to-parent',params);
                    }
                }
            }
        );

    </script>
    <script type="text/x-template" id="sub-category-template">
        <div>
            <div class="col-12 ps-lg-1 pe-lg-3 ps-sm-1 pe-sm-3 pe-0">
                <div class="shop-category shop-sub-category-manager" v-if="dataManagerSubcategoryManager.length>0">

                    <div class="shop-item mx-2" v-for="(item, index) in dataManagerSubcategoryManager" :key="index">
                        <a @click="onFilterSubCategoryShopTopMenu({data:item,type:3})"
                           class="link-dark">
                            <div class="card bg-transparent border-0 text-center">
                                <img :src=" getUrlResource(item['source'])" alt=""
                                     class="card-img-top rounded-pill mb-2">
                                <div class="card-body p-0">
                                    <p class="card-title m-0">  <?php echo "{{item['value']}}" ?> </p>
                                </div>
                            </div>
                        </a>
                    </div>


                </div>
            </div>
        </div>

    </script>
@endsection
@section('additional-scripts-vue-before')
    <script>

        function initLoadPageParams() {
            // Nueva categoría que deseas establecer
            var newCategory = 2; // Cambia este valor según sea necesario

            // Obtén la URL actual
            var url = new URL(window.location.href);

            // Cambia el valor del parámetro 'category'
            url.searchParams.set('category', newCategory);

            // Actualiza la URL en el navegador sin recargar la página
            window.history.pushState({}, '', url);

            // Para verificar que el cambio se realizó
            console.log('Nueva URL:', url.href);
        }

        $methodsShopPage.onInitDataShopPage = onInitDataShopPage;
        $methodsShopPage.onSearchData = onSearchData;
        $methodsShopPage.resetDataFiltersShop = resetDataFiltersShop;
        $methodsShopPage.onChangeSearchData = onChangeSearchData;
        $methodsShopPage.initManagementFilters = initManagementFilters;

        var initPosition = 780;

        function onChangeSearchData() {
            var _this = this;
            if (_this.dataManagerProducts.filters.searchPhrase.length == 0) {
                _this.dataManagerProducts.filters.current = 1;
                initPosition = 780;
                resetDataShop({
                    this: _this
                })
            }
        }

        function resetDataFiltersShop(params) {
            var _this = this;
            console.log("resetDataFiltersShop");
        }

        function onInitDataShopPage(params) {
            var _this = this;
            console.log("alex");
        }

        function onSearchData() {
            var _this = this;
            console.log("onSearchData", _this.dataManagerProducts.filters);
            resetDataShop({
                this: _this
            });
        }

        var $initByTypeGetData = 0;

        function initScrollManagerShop(params) {
            var $scope = params.this;
            console.log('initScrollManagerShop');

            $(window).on('load', function () {


                window.addEventListener("touchmove", function (event) {
                    console.log("move");
                    const miDiv = document.getElementById('limit-data'); // El elemento que deseas verificar
                    const rect = miDiv.getBoundingClientRect(); // Obtiene la posición del elemento

                    // Verifica si el elemento está dentro de la ventana visible
                    if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
                        var $allowLoad = false;
                        var totalCurrent = $scope.dataManagerProducts.filters.current * parseInt($scope.dataManagerProducts.filters.total);
                        if (totalCurrent <= parseInt($scope.dataManagerProducts.filters.total)) {
                            $allowLoad = true;
                        }
                        if ($allowLoad) {
                            var initGetData = $scope.dataManagerEvent.init;
                            if (!initGetData) {
                                $initByTypeGetData = 1;
                                $scope.dataManagerEvent.init = true;
                                if ($scope.dataManagerProducts.filters.current == 0) {
                                    $scope.dataManagerProducts.filters.current = 2;
                                } else {
                                    $scope.dataManagerProducts.filters.current++;
                                }

                                resetDataShop(params);

                            }

                        }
                    } else {
                        console.log('El elemento #limit-data NO está visible en el viewport.');
                    }


                });

                // Agrega un event listener para el evento scroll
                window.addEventListener('scroll', () => {
                    console.log('Scroll deón:',);

                });


            });

        }

        $(window).on('load', function () {


            $('.shop-category-manager').slick({
                infinite: true,
                slidesToShow: 10,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                prevArrow: "<i class='lni lni-chevron-left osahan-arrow osahan-left'></i>",
                nextArrow: "<i class='lni lni-chevron-right osahan-arrow osahan-right'></i>",
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4.1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 4.1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            $('.shop-category-manager').fadeIn();


        });

        function onReceiveShopEvents(response) {
            var $scope = response.this;
            console.log("onReceiveShopEvents", response);
            if (response.params.type == "onFilterSubCategoryShopTopMenu") {

                var data = response.params.data;
                $scope.onFilterSubCategoryShopTopMenu({this: $scope, params: data});
            }

        }

        function initSubcategorySlider() {
            $('.shop-sub-category-manager').slick({
                infinite: true,
                slidesToShow: 10,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                prevArrow: "<i class='lni lni-chevron-left osahan-arrow osahan-left'></i>",
                nextArrow: "<i class='lni lni-chevron-right osahan-arrow osahan-right'></i>",
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4.1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 4.1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            $('.shop-sub-category-manager').fadeIn();
        }

        function getFiltersShop(params) {
            //  $this.dataManagerProducts.filters
            var $scope = params.this;
            var result = $scope.dataManagerProducts.filters;
            var filters = result.filters;
            result.filters = filters;
            console.log("getFiltersShop", filters);
            return result;
        }

        function initManagementSet(params) {
            var $scope = params.this;
            var response = params.response;
            $scope.dataManagerProducts.filters.total = response.total;
            $scope.dataManagerProducts.manager.rows = $scope.dataManagerProducts.manager.rows.concat(response.rows);
        }


        function initCurrentComponent(params) {
            var $scope = params.this;
            console.log("initCurrentComponent MOUNTED");
            $scope.initManagementFilters();
            initScrollManagerShop(params);

        }

        function onFilterCategoryMenu(params) {

        }

        function onFilterSubCategoryMenu(params) {

        }

        function onFilterSubCategoryShopTopMenu(params) {
            var dataRow = (params.params.params.data);
            console.log(dataRow);
            var $scope = params.this;
            initPosition = 780;
            $scope.dataManagerProducts.filters.filters.sub_category_id = dataRow.id;
            $scope.dataManagerProducts.filters.current = 1;
            $scope.dataManagerProducts.filters.total = 0;
            resetDataShop(params);
        }

        function onFilterCategoryShopTopMenu(params) {
            initPosition = 780;
            var dataRow = JSON.parse(params.params.data);
            var $scope = params.this;
            $scope.dataManagerProducts.filters.filters.category_id = dataRow.id;
            $scope.dataManagerProducts.filters.current = 1;
            $scope.dataManagerProducts.filters.total = 0;

            $scope.dataManagerSubcategory = [];
            setTimeout(() => {
                $scope.dataManagerSubcategory = dataRow.sub_categories;
                console.log('Han pasado 1 segundos');
            }, 1000);

            resetDataShop(params);
        }

        function onFilterCategoryShopLeftMenu(params) {

        }

        function onFilterSubCategoryShopLeftTopMenu(params) {

        }

        function resetDataShop(params) {
            var $scope = params.this;
            var initGetData = $scope.dataManagerEvent.init;
            if (initGetData) {
            } else {
                $scope.dataManagerProducts.manager.rows = [];
            }
            $scope.initManagementDataShop();
        }

        function initManagementFilters() {
            if ($dataManagerPage.paramsRequest.category) {
                this.dataManagerProducts.filters.filters.category_id = $dataManagerPage.paramsRequest.category;

            }
        }

        function initManagementDataShop(params) {
            var $scope = params.this;
            var urlCurrent = $('#action_load_products_shop').val();
            var tokenInformation = $('meta[name="csrf-token"]').attr('content');
            var dataFilters = $scope.getFiltersShop();
            console.log("initManagementDataShop", $initByTypeGetData);
            var initGetData = $scope.dataManagerEvent.init;
            var allowAjax = true;

            if (allowAjax) {
                $.ajax({
                    async: false,
                    url: urlCurrent,
                    type: "POST",
                    // Form data
                    //datos del formulario
                    data: dataFilters,
                    //necesario para subir archivos via ajax
                    cache: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": tokenInformation
                    },
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    processData: true,
                    //una vez finalizado correctamente
                    success: function (response) {
                        $scope.initManagementSet(response);
                        if ($initByTypeGetData == 1) {
                            $scope.dataManagerEvent.init = false;
                        }

                    },
                    //si ha ocurrido un error
                    error: function () {
                        $("#limit-data-loading").addClass("not-view");


                    },
                    beforeSend: function (xhr, data) {
                        $("#limit-data-loading").removeClass("not-view");
                    },
                    complete: function (data) {
                        console.log(data);

                        $("#limit-data-loading").addClass("not-view");

                    },

                });
            }

        }


    </script>

@endsection
@section('content-manager')
    <div class="actions">

        <input id="action_load_products_shop" type="hidden"
               value="{{ route('getProductShopAdmin',app()->getLocale()) }}"/>
    </div>

    <div class="bg-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 ps-lg-1 pe-lg-3 ps-sm-1 pe-sm-3 pe-0">
                    <div class="shop-category shop-category-manager">
                        @if(isset($dataManagerPage['categoriesByProducts']))
                            @foreach ($dataManagerPage['categoriesByProducts'] as $row)

                                <div class="shop-item mx-2">
                                    <a @click="onFilterCategoryShopTopMenu({data:'{{ json_encode($row) }}',type:2})"
                                       class="link-dark">
                                        <div class="card bg-transparent border-0 text-center">
                                            <img src="{{ URL::asset($resourcePathServer.$row->source)}}" alt=""
                                                 class="card-img-top rounded-pill mb-2">
                                            <div class="card-body p-0">
                                                <p class="card-title m-0">   {{$row->value}}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @endforeach

                        @endif

                    </div>
                </div>
            </div>


            <div class="row" id="row-manager-sub-category">

                <sub-category-component @on-emmit-shop-events="onReceiveShopEvents"
                                        @message-to-parent="setMessageParentByChildren"
                                        :data-manager="{data:dataManagerSubcategory}"
                                        v-if="dataManagerSubcategory.length >0">

                </sub-category-component>

            </div>
        </div>
    </div>

    <section class="osahan-listing border-top ">
        <div class="container">
            <div class="row m-0">
                <div class="col-lg-9 p-0">
                    <div class="tab-content border-start bg-white" id="v-pills-tabContent">
                        <!-- snaks & munchies -->
                        <div id="v-pills-snaks" role="tabpanel" tabindex="0">
                            <div class="d-flex align-items-center justify-content-between p-3 border-bottom border-end">
                                <h5 class="fw-bold m-0">Productos</h5>
                                <div class="d-flex align-items-center gap-3 not-view">
                                    <a class="fs-6 text-muted" href="shop-list.html"><i
                                            class="bi bi-list-task d-flex"></i></a>
                                    <a class="fs-6 text-muted" href="listing.html"><i class="bi bi-grid d-flex"></i></a>
                                    <a class="fs-6" href="shop-grid-3-column.html"><i
                                            class="bi bi-grid-3x3-gap d-flex"></i></a>
                                </div>
                            </div>
                            <!-- chips -->
                            <div class="row row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-2 g-0"
                                 id="products-data">
                                <div v-if="dataManagerProducts.manager.rows.length === 0" class="col border-end border-bottom">

                                    <p></p>

                                    <div class="card bg-transparent border-0 rounded-0 h-100 osahan-card-list">
                                        <a href="#">
                                            <img src="{{ URL::asset($themePath)}}/img/list/1.jpeg" alt=""
                                                class="card-img-top"></a>
                                        <div class="card-body pt-0">
                                            <p class="card-text text-muted mb-2 small">
                                                No hay productos
                                            </p>
                                            <h6 class="card-title fw-bold text-truncate"> disponibles.
                                            </h6>
                                            <p class="text-muted small m-0 not-view"></p>
                                        </div>

                                    </div>
                                </div>
                                <div v-else class="col border-end border-bottom"
                                     v-for="(product, index) in dataManagerProducts.manager.rows" :key="index">
                                    <div class="card bg-transparent border-0 rounded-0 h-100 osahan-card-list">
                                        <a href="product-detail.html">
                                            <img
                                                :src="`{{ URL::asset($resourcePathServer)}}/${product.source}`" alt=""
                                                class="card-img-top"></a>
                                        <div class="card-body pt-0">
                                            <p class="card-text text-muted mb-1 small">
                                                <?php echo '{{product.name}}' ?>
                                            </p>
                                            <h6 class="card-title fw-bold text-truncate">  <?php echo '{{product.description}}' ?>
                                            </h6>
                                            <p class="text-muted small m-0">2 x 90g</p>
                                        </div>
                                        <div
                                            class="card-footer bg-transparent border-0 d-flex align-items-end justify-content-between pt-0 pb-3">
                                            <h6 class="fw-bold m-0">
                                                <del
                                                    class="text-muted small fw-normal">
                                                    $ <?php echo '{{product.sale_price}}' ?>
                                                </del>
                                                <br>$ <?php echo '{{product.sale_price}}' ?>
                                            </h6>

                                            <a data-bs-toggle="offcanvas" data-bs-target="#mycart"
                                             @click="onSetProductCart({type:1,row:product })"

                                               aria-controls="mycart" href="#"
                                               class="btn btn-outline-danger btn-sm rounded-3 fw-bold px-4 osahan-new-btn {{ !$dataManagerPage['shopConfig']['allow'] ? 'disabled-click' : '' }}">
                                                ADD
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="limit-data">

                            </div>
                        </div>
                    </div>
                    <!-- pagination -->
                    <div class="d-flex justify-content-center border-start border-end py-4 not-view"
                         id="limit-data-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

