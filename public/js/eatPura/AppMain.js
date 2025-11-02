var appInit = new Vue(
    {

        mounted: function () {
            this.initCurrentComponent();
            appThis = this;
            this.initManagement();
        },

        el: '#app-management',
        created: function () {

        },
        data: {
            ...$dataParent,
            ...$dataConfigMain,
            dataManagerEvent: {
                init: false,
            },
            dataManagerSubcategory: [],
            dataManagerProductsShopCart: {
                items: 0,
                data: [],
                result: {
                    total: 0,
                    tax: 0,
                },

            },
            dataManagerProducts: {
                manager: {
                    rows: []
                },
                filters: {
                    filters: {
                        business_id: 1,
                        category_id: null,
                        sub_category_id: null,
                        searchPhrase: "",
                    },
                    current: 1,
                    rowCount: 10,
                    searchPhrase: "",
                    allData: 0,

                }
            },
            managerCheckout: {
                isAllow: false,
                type: null,
                data: {}
            },
            configDataTemplatePayments: {
                title: "TemplatePayments",
                data: [],
                titleEvent: "",
                model_id: null
            },
            typePayment: null,

        },
        methods: {
            ...$methodsShopPage,
            ...$methodsShopCartPage,
            getUrlResource: function (rootResource) {
                var result = $uriAsset + rootResource;
                return result;
            },
            getFiltersShop: function () {
                return getFiltersShop({this: this});
            },
            initCurrentComponent: function () {
                if ($currentPage == 'shopPage') {
                    initCurrentComponent({this: this});
                } else if ($currentPage == 'userAccount') {
                    this.initCurrentComponentUserAccount();
                }
                this.initCurrentComponentShopCart();
            },
            initManagementSet: function (response) {

                initManagementSet({this: this, response: response});

            },
            initManagementDataShop: function () {
                initManagementDataShop({this: this});

            },
            initManagement: function () {
                $(".loading-resources").removeClass("loading-resources--view");
                $(".loading-resources").addClass("loading-resources--not-view");

                $("#app-management").removeClass("app-management--not-view");

                $this = this;
                if ($currentPage == 'shopPage') {
                    this.initManagementDataShop();
                } else if ($currentPage == 'checkoutPage') {
                    this.onInitDataCheckoutPage();
                }
            },
            onFilterCategoryMenu: function (params) {

                onFilterCategoryMenu({this: this, params: params});

            },
            onFilterSubCategoryMenu: function (params) {

                onFilterSubCategoryMenu({this: this, params: params});

            },

            onFilterCategoryShopTopMenu: function (params) {

                onFilterCategoryShopTopMenu({this: this, params: params});

            },
            onSearchProductBusiness: function (params) {
                if (params.type == "onScanSuccess") {
                    this.dataManagerProducts.filters.searchPhrase = params.value;
                    this.onSearchDataProduct();
                }
            },
            onFilterSubCategoryShopTopMenu: function (params) {

                onFilterSubCategoryShopTopMenu({this: this, params: params});

            },
            onFilterCategoryShopLeftMenu: function (params) {

                onFilterCategoryShopLeftMenu({this: this, params: params});
            },
            onFilterSubCategoryShopLeftTopMenu: function (params) {
                onFilterSubCategoryShopLeftTopMenu({this: this, params: params});
            },
            onReceiveShopEvents: function (params) {
                console.log("onReceiveShopEvents", params);
                onReceiveShopEvents({this: this, params: params});
            },
            onReceiveCheckoutEvents: function (params) {
                console.log("onReceiveCheckoutEvents", params);
                onReceiveCheckoutEvents({this: this, params: params});
            },
            onPaymentCheckout: function (params) {
                console.log("onReceiveCheckoutEvents", params);
                onPaymentCheckout({this: this, params: params});
            },
            viewShop: function () {
            },
            getClassCheckout: function () {
                let isAllowSale = this.dataManagerProductsShopCart.data.length > 0 && this.managerCheckout.isAllow;
                let result = isAllowSale ? '' : 'disabled-button-link';
                console.log(result);
                return result;
            },
            onReceiveCheckoutByChildren: function (params) {
                console.log("onReceiveCheckoutByChildren", params);
                if (params.type == "validForm") {
                    this.managerCheckout.isAllow = false;
                    if (params.data.success) {
                        this.managerCheckout.isAllow = true;
                        this.typePayment = params.type;
                    }
                }

            },
            onSaveCheckout: function (params) {

                var offcanvasElement = $('#orderconfirm')[0]; // Selecciona el elemento DOM del offcanvas
                var offcanvasInstance = new bootstrap.Offcanvas(offcanvasElement); // Crea la instancia
                this.$refs.refTemplatePayments.managerSaveCheckout({
                    'typePayment': this.typePayment,
                    'instance': offcanvasInstance
                });


                // Abre el offcanvas
                //offcanvasInstance.show();

            },
            _submitFormCheckout: function () {

            },
            _updateParentByChildren: function (params) {
                console.log(params);
            },

        }
    })
;

