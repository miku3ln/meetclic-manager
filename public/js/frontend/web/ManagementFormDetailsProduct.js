var componentThisManagementFormDetailsProduct;
/*ECCOMERCE-001*/
Vue.component('management-form-details-product-component', {
    template: '#management-form-details-product-template',
    directives: {
        'initSlickPreview': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.method({
                    objSelector: el, data: paramsInput.data
                });
            }
        }
    }, props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        this.initDataComponent(this.params);
    },
    beforeMount: function () {
        console.log('beforeMount');

    },
    mounted: function () {
        console.log('mounted');
        componentThisManagementFormDetailsProduct = this;
        this.initCurrentComponent();
        $scope = this;
        var selectorMultimedia = '#management-multimedia';

        $scope.initSlickPreview({
            'objSelector': selectorMultimedia
        });

    },
    validations: function () {
        var attributes = {
            "amount": {required},
            "size_id": {},
            "color_id": {},
            allowColor: {},
            allowSize: {},
        };
        if (this.model.attributes['allowColor']) {
            attributes['color_id'] = {required};
        }
        if (this.model.attributes['allowSize']) {

            attributes['size_id'] = {required};
        }
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        var dataManager = {
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configParams: {},
            labelsConfig: {
                "title": "Formulario de Registro",
                "event": "",

                buttons: {
                    return: "Regresar",
                    verify: "Verificar",
                    manager: "Agregar al Carrito."
                },
                msg: {
                    'loading': "Cargando....."
                }
            },
            tabCurrentSelector: '#modal-management-form-details-product',
            processName: "Registro Acción.",
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },

            optionsSizes: [],
            optionsColors: [],
            modelAux: [],
            modelView: [],
            managementViews: {
                previewLoading: true,
                managementForm: false,
                managementType: 0,
                data: {},
                sliderProductMultimedia: {
                    emptyHtml: "<h1>Cargando...</h1>",
                    show: false
                }, buttons: {
                    addCart: {
                        view: false
                    }
                }
            },


        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initDataComponent: function (params) {
            //GRID DETAILS BUSINESS
            this.modelAux = params;
            this.configParams = params;
            var dataCurrent = params['data'];
            var dataManagement = dataCurrent;
            var allowColor = dataCurrent['colors'].length ? true : false;
            var allowSize = dataCurrent['sizes'].length ? true : false;
            var allowVariants = allowColor || allowSize;
            this.optionsSizes = [];
            this.optionsColors = [];
            this.model.structure['size_id']['options'] = [];
            this.model.structure['color_id']['options'] = [];
            this.model.attributes['allowColor'] = false;
            this.model.attributes['allowSize'] = false;

            if (allowColor) {

                this.optionsColors = dataCurrent['colors'];
                this.model.structure['color_id']['options'] = dataCurrent['colors'];
                this.model.attributes['allowColor'] = allowColor;
            }
            if (allowSize) {
                this.optionsSizes = dataCurrent['sizes'];
                this.model.structure['size_id']['options'] = dataCurrent['sizes'];
                this.model.attributes['allowSize'] = allowSize;

            }
            var is_service = dataCurrent['is_service'];//0=product,1=service
            var product_by_route_map_id = dataCurrent['product_by_route_map_id'] == null;
            var managementType = null;
            $languageCurrent = $language == 'es' ? null : $language;

            var price = 0;
            var hasTax = false;
            var tax = 0;
            var priceDiscount = 0;
            var name = $languageCurrent == null ? dataCurrent['name'] : (dataCurrent.hasOwnProperty('name_lang') && dataCurrent['name_lang'] ? dataCurrent['name_lang'] : dataCurrent['name']);
            var description = $languageCurrent == null ? dataCurrent['description'] : (dataCurrent.hasOwnProperty('description_lang') && dataCurrent['description_lang'] ? dataCurrent['description_lang'] : dataCurrent['description']);
            var code = dataCurrent['code'];
            var categories = "";
            var allowDiscount = false;
            var allowUser = false;
            var allowWish = false;
            var activeWish = false;
            var multimedia = [];
            var valueCurrent = dataCurrent.hasOwnProperty('sale') ? dataCurrent['price'] : (dataCurrent.hasOwnProperty('sale_price') ? parseFloat(dataCurrent['sale_price']) : 0);
            if (dataCurrent.business_by_discount_id) {
                var business_by_discount_value = parseFloat(dataCurrent.business_by_discount_value);
                var valueWithoutDiscount = valueCurrent;
                price = valueWithoutDiscount;
                var valueWithDiscount = valueCurrent - (valueCurrent * business_by_discount_value) / 100;
                price_before = valueWithoutDiscount;
                price_discount = valueWithDiscount;

                allowDiscount = true;
                promotion_id = dataCurrent.business_by_discount_id;
                priceCurrent = price_discount;
                priceCurrent = getValueCustomer(priceCurrent);

                allowDiscount = true;
                priceDiscount = priceCurrent;
            } else {
                priceCurrent = dataCurrent.hasOwnProperty('sale') ? dataCurrent['price'] : (dataCurrent.hasOwnProperty('sale_price') ? parseFloat(dataCurrent['sale_price']) : 0)
                price = priceCurrent;
            }

            var dataProduct = {
                price: price,
                hasTax: hasTax,
                tax: tax,
                priceDiscount: priceDiscount,
                name: name,
                description: description,
                code: code,
                categories: categories,
                allowDiscount: allowDiscount,
                allowUser: allowUser,
                allowWish: allowWish,
                activeWish: activeWish,
                "multimedia": multimedia,
                allowColor: allowColor,
                allowSize: allowSize,
                dataManagement: dataManagement
            };
            //0 =product normal inventory
            // 1=product variants inventory
            // 2 =product normal inventory route
            // 3=product variants inventory route
            // 4=product service
            // 5=product service route
            if (allowVariants == false && is_service == 0 && product_by_route_map_id == false) {
                managementType = 0;
            } else if (allowVariants && is_service == 0 && product_by_route_map_id == false) {
                managementType = 1;
            } else if (allowVariants == false && is_service == 0 && product_by_route_map_id) {
                managementType = 2;
            } else if (allowVariants && is_service == 0 && product_by_route_map_id) {
                managementType = 3;
            } else if (allowVariants && is_service == 1 && product_by_route_map_id == false) {
                managementType = 4;
            } else if (allowVariants && is_service == 1 && product_by_route_map_id) {
                managementType = 5;
            }
            console.log(params);
            this.managementViews.managementType = managementType;

            this.managementViews.data = dataProduct;

            var multimedia = [];
            var setPushMultimedia = {
                title: name,
                description: description,
                src: $publicAsset + dataCurrent.source
            };
            multimedia.push(setPushMultimedia);
            var multimediaManagement = dataCurrent['multimedia'];
            if (Object.keys(multimediaManagement).length) {
                multimediaManagement = this.getDataStructureMultimedia({
                    keyTitle: "title",
                    keyDescription: "description",
                    keySource: "source",
                    data: multimediaManagement,

                });
                multimedia = $.merge(multimedia, multimediaManagement);
            }
            this.managementViews.data.multimediaHmtl = this.getHtmlMultimedia({
                data: multimedia
            });

            var allowViewButtonStock = false;
            if (is_service == 0) {
                var quantityCurrent = getValueCustomer(dataCurrent['quantity_units']);
                if (quantityCurrent > 0) {
                    allowViewButtonStock = true;
                }
            } else {
                allowViewButtonStock = true;
            }

            this.managementViews.buttons.addCart.view = allowViewButtonStock && $allowShop == 1;
        },

        getDataStructureMultimedia: function (params) {
            var data = params.data;
            var keyTitle = params.keyTitle;
            var keyDescription = params.keyDescription;
            var keySource = params.keySource;

            var result = [];
            $.each(data, function (key, setPush) {
                var title = setPush[keyTitle];
                var description = setPush[keyDescription] == 'null' ? "" : setPush[keyDescription];
                var source = $publicAsset + setPush[keySource];
                var setPushCurrent = {
                    'title': title,
                    'description': description,
                    'src': source,

                };

                result.push(setPushCurrent);

            });
            return result;
        },
        getHtmlMultimedia: function (params) {
            var data = params.data;

            var result = [];
            $.each(data, function (key, setPush) {
                var title = setPush['title'];
                var description = setPush['description'];
                var source = setPush['src'];
                var setPushCurrent = [

                    '<div class="content-wrapper-card">',
                    '  <img data-lazy="' + source + '"',
                    'data-srcset="' + source + '"',
                    ' >',
                    '<h1 class="content-wrapper-card__title not-view">' + title + '</h1>',
                    '<p class="content-wrapper-card__description not-view">' + description + '</p>',
                    '</div>',
                ];
                setPushCurrent = setPushCurrent.join('');
                result.push(setPushCurrent);

            });
            return result.join('');
        },
        initSlickPreview: function (params) {
            console.log('initSlickPreview');
            $scope = this;
            $scope.managementViews.sliderProductMultimedia.show = true;
            var objSelector = params.objSelector;
            $(objSelector).slick({
                lazyLoad: 'ondemand', // ondemand progressive anticipated
                infinite: true,
                dots: true,
                autoplay: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                /*  arrows: false,*/
            });

            var allowReload = false;

            // On swipe event
            $(objSelector).on('swipe', function (event, slick, direction) {
                console.log('swipe');
                // left
            });

// On edge hit
            $(objSelector).on('edge', function (event, slick, direction) {
                console.log('edge was hit');
            });

// On before slide change
            $(objSelector).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                console.log('beforeChange');
            });

            $(objSelector).on('init', function (event, slick) {
                console.log('init');
            }).on('lazyLoaded', function (event, slick) {
                console.log('lazyLoaded');
                if (!allowReload) {

                    allowReload = true;
                    $(objSelector).slick('slickSetOption', 'speed', 500, true);

                    if ($allowShop == 0) {
                        $('.manager-basket-inputs').addClass('not-view');
                        $('.manager-basket-inputs').remove();

                    }
                }

            }).on('lazyLoadError', function (event, slick) {
                console.log('lazyLoadError');
            }).on('reInit', function (event, slick) {
                console.log('reInit');


            });
        },
        initCurrentComponent: function () {

            this.initDataModal();
            this.$refs.refManagementFormDetailsProductModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalManagementFormDetailsProduct'
            });
        }
        ,
        _showModal: function () {
            /*    this.resetForm();*/

        }
        ,
        _hideModal: function () {
            this._resetComponent();

        }
        ,

        _cancel: function () {
            this.$refs.refManagementFormDetailsProductModal.hide();
            this._resetComponent();

        }
        ,
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            var managementType = this.managementViews.managementType;

            var previewLoading = false;
            var managementForm = true;
            if (managementType == 0) {

            } else if (managementType == 1) {
            } else if (managementType == 2) {//route

            } else if (managementType == 3) {//route

            } else if (managementType == 4) {

            } else if (managementType == 5) {//route

            }
            this.managementViews.previewLoading = previewLoading;
            this.managementViews.managementForm = managementForm;

        }
        ,
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refManagementFormDetailsProductModal.show();

            }
        }
        ,
        _emitToParent: function (params) {
            this.$root.$emit('_productRowGrid', params);
        }
        ,

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {


            }
        }
        ,

        managementData: function (params) {

        }
        ,
//MANAGER PROCESS

//FORM CONFIG
        getValuesSave: function () {

            var result = {

                    "amount": this.$v.model.attributes.amount.$model,


                }
            ;
            result = this.managementViews.data.dataManagement;
            result['count'] = this.$v.model.attributes.amount.$model;
            if (this.managementViews.data.allowColor) {
                var textCurrent = $(".product-color__items option:selected").text();
                var idCurrent = this.$v.model.attributes.color_id.$model;

                result['product_color'] = textCurrent;
                result['product_color_id'] = idCurrent;

            }
            if (this.managementViews.data.allowSize) {
                var textCurrent = $(".product-size__items option:selected").text();
                var idCurrent = this.$v.model.attributes.size_id.$model;


                result['product_sizes'] = textCurrent;
                result['product_sizes_id'] = idCurrent;

            }

            return result;
        },
        _incrementDecrement: function (type) {
            var result = 1;
            var amountCurrent = this.$v.model.attributes['amount'].$model;
            if (type == 1) {
                amountCurrent++;
                result = amountCurrent;

            } else {
                if (amountCurrent > 1) {

                    amountCurrent--;
                    result = amountCurrent;
                }
            }
            this._setValueForm('amount', result)
        },
        _setValueForm: _setValueForm,
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getValidateForm: getValidateForm,
        resetForm: resetForm,
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var product = dataSend;
            var validateCurrent = this.validateForm();

            function managerSetProduct() {
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
                updateAllCheckout();
            }

            if (!validateCurrent) {
                alert('error');
            } else {
                var typeManagement = 'quickViewModalProduct';
                var managementBusinessCartResult = managementBusinessCart({
                    'typeManagement': typeManagement,
                    'product': product
                });
                if (managementBusinessCartResult.success) {
                    managerSetProduct();
                    $scope._cancel();
                    var textManager = 'Se Agrego un producto al carrito.';
                    $.NotificationApp.send({
                        heading: "Informacion!",
                        text: textManager,
                        position: 'bottom-left',
                        loaderBg: '#53BF82',
                        icon: 'success',
                        hideAfter: 5000

                    });
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
                                    managerSetProduct();
                                    $scope._cancel();
                                }
                            }
                        }
                    });
                }

            }

        },
        getViewErrorForm: function (objValidate) {
            var result = false
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }
            return result;
        }
        ,
        _submitForm: function (e) {
            console.log(e);
        }
        ,
        getStructureForm: function () {
            var result = {

                color_id: {
                    id: "color_id",
                    name: "color_id",
                    label: "Color",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                    data: []
                },
                size_id: {
                    id: "size_id",
                    name: "size_id",
                    label: "Talla/Tamaño",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                "amount": {
                    id: "amount",
                    name: "amount",
                    label: "Cantidad",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },

                },

                allowColor: {
                    id: "allowColor",
                    name: "allowColor",
                    label: "",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },

                },
                allowSize: {
                    id: "allowSize",
                    name: "allowSize",
                    label: "",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                },

            };
            return result;
        }
        ,
        getAttributesForm: function () {
            var result = {
                "amount": 1,
                "size_id": null,
                "color_id": null,
                allowColor: false,
                allowSize: false,

            };
            return result;
        }
        ,

        getNameAttribute: function (name) {
            var result = name;
            return result;
        }
        ,
        getLabelForm: viewGetLabelForm,
        getClassErrorForm: function (nameElement, objValidate) {
            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        }
        ,
//Manager Model


//others functions


    }
})
;

