Vue.component('product_parent-component', {

    components: {}, template: '#product_parent-template', directives: {
        initS2ProductTrademark: {

            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                console.log('initS2ProductTrademark');
                paramsInput._managerS2ProductTrademark({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ProductCategory: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductCategory({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ProductSubcategory: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductSubcategory({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }, initS2ProductMeasureType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductMeasureType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var nameMethod = paramsInput.nameMethod;
                var rowId = paramsInput.rowId;

                nameMethod({
                    objSelector: el, rowId: paramsInput.rowId, modelId: rowId
                });
            }
        }, initFormWizard: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var nameMethod = paramsInput.nameMethod;
                var rowId = paramsInput.rowId;

                nameMethod({
                    objSelector: el, rowId: paramsInput.rowId, modelId: rowId
                });
            }
        }
    }, props: {
        params: {
            type: Object,
        }
    }, created: function () {
        componentProductParent = this;

        this.initEmmitFromComponents();

    }, beforeMount: function () {


    }, mounted: function () {
        this.allowForm = true;
    }, beforeDestroy: function () {
        this.destroyEmmitFromComponents();
    }, validations: function () {
        var attributes = {
            "id": {},
            "change": {},
            "code": {required, maxLength: Validators.maxLength(64)},//oki
            "name": {required},//oki
            "state": {required},//oki
            "product_trademark_id_data": {},
            "product_category_id_data": {required},//oki
            "product_subcategory_id_data": {required},//oki
            "source": {},
            "description": {},
            "has_tax": {},
            "tax_id_data": {required},
            "is_service": {},
            "sale_price": {},
            "view_online": {},
            "product_measure_type_id_data": {required},
            "product_details_shipping_fee_id": {},
            "height": {},
            "length": {},
            "width": {},
            "weight": {},
            'quantity_units': {},
            "product_by_sizes_data": {},
            "product_by_color_data": {},
            "business_by_products_parent_id": {}

        };

        if (this.model.attributes['view_online']) {

        }
        console.log('validations');
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    }, data: function () {

        var dataManager = {
            allowForm: false,...$staticsVariables, business_id
    :
        null, /*  ----MANAGER ENTITY---*/
            configModelEntity
    :
        {
            "buttonsManagements"
        :
            []
        }
    ,
        managerMenuConfig: {
            view: false, menuCurrent
        :
            [], rowId
        :
            null
        }
    ,
        configParams: {
        }
    ,
        labelsConfig: {
            buttons: {
                'create'
            :
                'Crear', 'update'
            :
                'Actualizar'
            }
        }
    ,

//form config
        model: {
            attributes: this.getAttributesForm(), structure
        :
            this.getStructureForm(),
        }
    ,
        tabCurrentSelector: '.content', processName
    :
        "Registro Acción.", formConfig
    :
        {
            nameSelector: "#" + $configProcess['entity-process'] + "-form",
                url
        :
            $('#action-product-saveData').val(),
                loadingMessage
        :
            'Guardando...',
                errorMessage
        :
            'Error al guardar el Product.',
                successMessage
        :
            'El Product se guardo correctamente.',
                nameModel
        :
            $configProcess['model']
        }
    , //Grid config
        gridConfig: {
            selectorCurrent: "#" + $configProcess['entity-process'] + "-grid",
                url
        :
            $("#action-" + $configProcess['entity-process'] + "-getAdmin").val()
        }
    ,
        submitStatus: "no", showManager
    :
        false,

            managerType
    :
        null, configModalProductByMultimedia
    :
        {
            "title"
        :
            "Title", "viewAllow"
        :
            false, "data"
        :
            []
        }
    ,
        configModalLanguageProduct: {
            "title"
        :
            "Title", "viewAllow"
        :
            false, "data"
        :
            []
        }
    ,
        configModalProductSaveDataInputOutput: {
            "title"
        :
            "Title", "viewAllow"
        :
            false, "data"
        :
            []
        }
    ,
        configProcess: {
            'inventory'
        :
            {
                'title'
            :
                'Inventario',
                    'msg'
            :
                'Se usa para calcular las tarifas de envío al momento del pago y los precios de las etiquetas de envío durante la preparación.',

            }
        ,
            'shipping'
        :
            {
                'title'
            :
                'Configuracion Envios',
                    'msg'
            :
                'Se usa para calcular las tarifas de envío al momento del pago y los precios de las etiquetas de envío durante la preparación.',

            }
        ,
            'variants'
        :
            {
                'title'
            :
                'Variantes',
                    'msg'
            :
                'Este producto tiene múltiples opciones, así como diferentes tamaños o colores',
            }
        ,

        }
    ,
        configModalProductByRouteMap: {
            "title"
        :
            "Title", "viewAllow"
        :
            false, "data"
        :
            []
        }
    ,
        browserPrint: null, printManager
    :
        {
            allowViewAmount: false, amountPrint
        :
            1, product
        :
            {
                nombre: "Alex", ubicacion
            :
                "Sistemas", cantidad
            :
                22, unidad_medida
            :
                "MD", codigo
            :
                "ALEX",
            }
        ,

        }
    ,
        managerProcess: {
            configDataProductParentByPrices: {
                title: 'Hola'
            }
        }
    ,
        process_table: 'product_parent',

    }
        ;


        return dataManager;
    }, methods: {
        initEmmitFromComponents: function () {
            this.$parent.$on('message-to-' + this.process_table, this.handleMessageFromParent);
        },
        destroyEmmitFromComponents: function () {
            this.$parent.$off('message-to-' + this.process_table, this.handleMessageFromParent);
        },
        getValuesModelByCrud: function (params) {
            var result = {};
            var product_trademark_id_data = null;
            if ($configPartial['valuesDefaultForm']['tradeMark']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['tradeMark']['data'];
                product_trademark_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
            }

            var product_category_id_data = null;
            if ($configPartial['valuesDefaultForm']['category']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['category']['data'];
                product_category_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
            }
            var product_subcategory_id_data = null;
            if ($configPartial['valuesDefaultForm']['subcategory']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['subcategory']['data'];
                product_subcategory_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
            }
            var product_measure_type_id_data = null;

            if ($configPartial['valuesDefaultForm']['measureType']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['measureType']['data'];
                product_measure_type_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
            }
            var tax_id_data = $configPartial.managerProductManager.data.taxCurrent.id;
            if (params.isCreate) {
                result = {
                    "id": null,
                    "change": false,
                    "code": null,
                    "name": null,
                    "state": "ACTIVE",
                    "view_online": false,
                    "product_trademark_id_data": product_trademark_id_data,
                    "product_category_id_data": product_category_id_data,
                    "product_subcategory_id_data": product_subcategory_id_data,
                    "source": null,
                    "description": 'S/N',
                    "code_provider": null,
                    "code_product": null,
                    "has_tax": null,
                    "is_service": null,
                    "sale_price": 0,
                    "product_measure_type_id_data": product_measure_type_id_data,
                    "product_by_color_data": null,
                    "product_by_sizes_data": null, //product_details_shipping_fee
                    "product_details_shipping_fee_id": null,
                    "height": 0,
                    "length": 0,
                    "width": 0,
                    "weight": 0,
                    "quantity_units": 0,
                    tax_id_data: tax_id_data,
                    'business_by_products_parent_id': null
                };
            } else {
                var rowCurrent = params['ProductParent'];
                result.id = rowCurrent.id;
                result.change = false;
                result.code = rowCurrent.code;
                result.name = rowCurrent.name;
                result.state = rowCurrent.state;
                result.view_online = false;
                result.product_trademark_id_data = product_trademark_id_data;
                result.product_category_id_data = {
                    id: rowCurrent.product_category_id,
                    text: rowCurrent.product_category
                };
                result.product_subcategory_id_data = {
                    id: rowCurrent.product_subcategory_id,
                    text: rowCurrent.product_subcategory
                };
                result.source = null;
                result.description = (rowCurrent.description != null || rowCurrent.description != "null") ? rowCurrent.description : "";
                result.code_provider = null;
                result.code_product = null;
                result.has_tax = rowCurrent.has_tax == 1 ? true : false;
                result.is_service = rowCurrent.is_service == 1 ? true : false;
                result.sale_price = 0;
                result.product_measure_type_id_data = {
                    id: rowCurrent.product_measure_type_id,
                    text: rowCurrent.product_measure_type
                };
                result.product_by_color_data = [];
                result.product_by_sizes_data = [];
                result.product_details_shipping_fee_id = null;
                result.height = 0;
                result.length = 0;
                result.width = 0;
                result.weight = 0;
                result.quantity_units = 0;
                result.tax_id_data = rowCurrent.tax_id;
                result.business_id = rowCurrent.business_id;


                result.business_by_products_parent_id = rowCurrent.business_by_products_parent_id;
            }
            return result;
        },
        handleMessageFromParent: function (params) {

            if (params.type == 'onSaveModelComponent') {
                this.product_parent_id = params.data.information['ProductParent'].id;
                this.model.attributes.id = params.data.information['ProductParent'].id;
                this.model.attributes.business_by_products_parent_id = params.data.information['BusinessByProductParent'].id;

            } else if (params.type == 'onClickUpdateRegister') {
                var rowCurrent = params.data.information['ProductParent'];
                var resultValues = this.getValuesModelByCrud({
                    isCreate: false,
                    'ProductParent': rowCurrent
                });

                this.product_parent_id = params.data.information['ProductParent'].id;
                this.model.attributes = resultValues;
            }
        },
        ...$methodsFormValid,

//EVENTS OF CHILDREN
    /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
  //MANAGER PROCESS
//FORM CONFIG
    getViewErrorForm: function (objValidate) {
        var result = false;
        if (!objValidate.$dirty) {
            result = objValidate.$dirty ? (!objValidate.$error) : false;
        } else {
            result = objValidate.$error;
        }
        return result;
    }, _submitForm: function (e) {
        console.log(e);
    }, getStructureForm: function () {
        var result = {
            code: {
                id: "code", name: "code", label: "Codigo", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 64.",
                },
            }, quantity_units: {
                id: "quantity_units", name: "quantity_units", label: "Cantidad Existente", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 64.",
                },
            },

            name: {
                id: "name", name: "name", label: "Nombre", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, state: {
                id: "state", name: "state", label: "Estado", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, options: [{"value": "ACTIVE", "text": "ACTIVE"}, {
                    "value": "INACTIVE", "text": "INACTIVE"
                }, {"value": "ERASER", "text": "BORRADOR"}]
            }, tax_id_data: {
                id: "tax_id_data", name: "tax_id_data", label: "Iva", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, options: $configPartial.managerProductManager.allTax
            }, product_trademark_id_data: {
                id: "product_trademark_id_data", name: "product_trademark_id_data", label: "Marca", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, product_category_id_data: {
                id: "product_category_id_data", name: "product_category_id_data", label: "Categoria", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, product_subcategory_id_data: {
                id: "product_subcategory_id_data",
                name: "product_subcategory_id_data",
                label: "Subcategoria",
                required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, source: {
                id: "source", name: "source", label: "Imagen", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, description: {
                id: "description", name: "description", label: "Descripcion", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, code_provider: {
                id: "code_provider", name: "code_provider", label: "Codigo Proveedor", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 80.",
                },
            }, code_product: {
                id: "code_product", name: "code_product", label: "Codigo Producto", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 80.",
                },
            }, has_tax: {
                id: "has_tax", name: "has_tax", label: "Tiene Iva?", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, is_service: {
                id: "is_service", name: "is_service", label: "is service", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, view_online: {
                id: "view_online", name: "view_online", label: "Ver Tienda Online?", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, product_measure_type_id_data: {
                id: "product_measure_type_id_data",
                name: "product_measure_type_id_data",
                label: "Medida",
                required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, sale_price: {
                id: "sale_price", name: "sale_price", label: "Precio Sin Iva", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, product_by_color_data: {
                id: "product_by_color_data", name: "product_by_color_data", label: "Colores", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, product_by_sizes_data: {
                id: "product_by_sizes_data", name: "product_by_sizes_data", label: "Tamaño", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, height: {
                id: "height", name: "height", label: "Alto(cm)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, length: {
                id: "length", name: "length", label: "Largo(cm)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, width: {
                id: "width", name: "width", label: "Ancho(cm)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, weight: {
                id: "weight", name: "weight", label: "Peso(kg)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            },
        };
        return result;
    }, getAttributesForm: function () {
        var isCreate = this.params.data.process.data == null;
        var result;
        if (isCreate) {
            result = this.getValuesModelByCrud({
                isCreate: true
            });
        } else {
            result = this.getValuesModelByCrud({
                isCreate: false,
                'ProductParent': this.params.data.process.data
            });
        }

        return result;
    }, getNameAttribute: getNameAttribute, getLabelForm: viewGetLabelForm,
    _setValueForm: function (name, value) {
        this.model.attributes[name] = value;
        this.$v["model"]["attributes"][name].$model = value;
        this.$v["model"]["attributes"][name].$touch();
        this.validateForm();
    }, getClassErrorForm: getClassErrorForm, // ...$methodsFormManager
//Manager Model
    getValuesSave: function () {
        var dataCurrentKeys = [];
        var dataCurrentGet = this.$v.model.attributes.product_by_sizes_data.$model;
        $.each(dataCurrentGet, function (key, value) {
            var setPush = value.id;
            dataCurrentKeys.push(setPush);
        });
        dataCurrentKeys = dataCurrentKeys.join(',');
        var product_by_sizes_data = dataCurrentKeys;

        dataCurrentKeys = [];
        dataCurrentGet = this.$v.model.attributes.product_by_color_data.$model;
        $.each(dataCurrentGet, function (key, value) {
            var setPush = value.id;
            dataCurrentKeys.push(setPush);
        });
        dataCurrentKeys = dataCurrentKeys.join(',');
        var product_by_color_data = dataCurrentKeys;
        var taxIdZero = $configPartial.managerProductManager.data.taxCurrentZero.id;
        var taxIdCurrent = $configPartial.managerProductManager.data.taxCurrent.id;
        var tax_id = this.$v.model.attributes.has_tax.$model == null ? taxIdZero : (this.$v.model.attributes.has_tax.$model == true ? taxIdCurrent : taxIdZero);
        var product_category_id = null;
        var product_subcategory_id = null;
        if (this.$v.model.attributes.product_category_id_data.$model) {
            product_category_id = this.$v.model.attributes.product_category_id_data.$model.id;
        }
        if (this.$v.model.attributes.product_subcategory_id_data.$model) {
            product_subcategory_id = this.$v.model.attributes.product_subcategory_id_data.$model.id;
        }
        var result = {
            "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
            change: this.$v.model.attributes.change.$model,
            "code": this.$v.model.attributes.code.$model,
            "name": this.$v.model.attributes.name.$model,
            "state": this.$v.model.attributes.state.$model,
            "product_trademark_id": this.$v.model.attributes.product_trademark_id_data.$model.id,
            "product_category_id": product_category_id,
            "product_subcategory_id": product_subcategory_id,
            "source": this.$v.model.attributes.source.$model,
            "description": this.$v.model.attributes.description.$model,
            "has_tax": this.$v.model.attributes.has_tax.$model == null ? 0 : (this.$v.model.attributes.has_tax.$model ? 1 : 0),
            "is_service": 0,
            "view_online": this.$v.model.attributes.view_online.$model == null ? 0 : (this.$v.model.attributes.view_online.$model ? 1 : 0),
            "product_measure_type_id": this.$v.model.attributes.product_measure_type_id_data.$model.id,
            business_id: $businessManager.id,
            tax_id: tax_id,
            location_details: 'none',
            stock_control: 0,
            ice_control: 0,
            initial_stock_control: 0,
            "product_inventory_id": this.model.attributes.product_inventory_id,
            "product_by_sizes_data": product_by_sizes_data,
            "product_by_color_data": product_by_color_data,
            "product_details_shipping_fee_id": this.$v.model.attributes.product_details_shipping_fee_id.$model,
            "height": this.$v.model.attributes.height.$model,
            "length": this.$v.model.attributes.length.$model,
            "width": this.$v.model.attributes.width.$model,
            "weight": this.$v.model.attributes.weight.$model,
            "quantity_units": this.$v.model.attributes.quantity_units.$model,
            "business_by_products_parent_id": this.$v.model.attributes.business_by_products_parent_id.$model ? this.$v.model.attributes.business_by_products_parent_id.$model : -1,

        };

        return result;
    }, resetForm: function () {
        this.$v.$reset();
        this.model = {
            attributes: this.getAttributesForm(), structure: this.getStructureForm()
        };
        this.model.attributes.id = null;
    },

    validateForm: function () {
        var currentAllow = this.getValidateForm();
        var dataSendResult = this.getValuesSave();
        this.onSendEventsParent({
            'type': 'validateForm', 'process': 'product_parent', 'data': {
                validate: currentAllow, getValuesSave: dataSendResult
            }
        });
        return currentAllow.success;
    }, getValidateForm: getValidateForm, //others functions
    _managerS2ProductTrademark: function (params) {

        var el = params.objSelector;
        var valueCurrentRowId = params.rowId;
        var dataCurrent = [];
        if (this.model.attributes.product_trademark_id_data.hasOwnProperty('id')) {

            dataCurrent = [this.model.attributes.product_trademark_id_data];
        }
        var $scope = this;

        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", data: dataCurrent, ajax: {
                url: $("#action-product-trademark-getListSelect2").val(),
                type: 'get',
                dataType: 'json',
                data: function (term, page) {

                    var paramsFilters = {
                        filters: {
                            search_value: term,
                        }
                    };
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }, allowClear: true, multiple: false, width: '100%'
        });

        elementInit.on('select2:select', function (e) {
            var data = e.params.data;
            $scope.model.attributes.product_trademark_id_data = data;
        }).on("select2:unselecting", function (e) {
            $scope.model.attributes.product_trademark_id_data = null;
            $scope._setValueForm('product_trademark_id_data', null);
        });
    }, _managerS2ProductCategory: function (params) {
        var el = params.objSelector;
        var valueCurrentRowId = params.rowId;
        var dataCurrent = [];

        if (this.model.attributes.product_category_id_data.hasOwnProperty('id')) {

            dataCurrent = [this.model.attributes.product_category_id_data];
        }
        var $scope = this;
        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", data: dataCurrent, ajax: {
                url: $("#action-product-category-getListSelect2").val(),
                type: 'get',
                dataType: 'json',
                data: function (term, page) {

                    var paramsFilters = {
                        filters: {
                            search_value: term,
                        }
                    };
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }, allowClear: true, multiple: false, width: '100%'
        });

        elementInit.on('select2:select', function (e) {
            var data = e.params.data;
            $scope.model.attributes.product_category_id_data = data;
            $("#product_subcategory_id_data").val('').trigger('change');
            $scope._setValueForm('product_category_id_data', data);
            $scope.model.attributes.product_subcategory_id_data = null;
            $scope._setValueForm('product_subcategory_id_data', null);


        }).on("select2:unselecting", function (e) {
            $scope.model.attributes.product_category_id_data = null;
            $scope._setValueForm('product_category_id_data', null);
            $scope.model.attributes.product_subcategory_id_data = null;


        });
    }, _managerS2ProductSubcategory: function (params) {
        var el = params.objSelector;
        var valueCurrentRowId = params.rowId;
        var allowDataSubcategory = false;
        var dataCurrent = [];
        if (this.model.attributes.product_subcategory_id_data) {
            allowDataSubcategory = true;
            if (this.model.attributes.product_subcategory_id_data.hasOwnProperty('id')) {

                dataCurrent = [this.model.attributes.product_subcategory_id_data];
            }
        }
        var $scope = this;
function getParams(term){
   return {
       filters: {
           search_value: term,
           product_category_id: $scope.model.attributes.product_category_id_data.id
       }}  ;
}


        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", data: dataCurrent, ajax: {
                url: $("#action-product-subcategory-getListSelect2").val(),
                type: 'get',
                dataType: 'json',
                data: function (term, page) {

                    var paramsFilters = getParams(term);
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }, allowClear: true, multiple: false, width: '100%'
        });

        elementInit.on('select2:select', function (e) {
            var data = e.params.data;
            $scope.model.attributes.product_subcategory_id_data = data;
            $scope._setValueForm('product_subcategory_id_data', data);
        }).on("select2:unselecting", function (e) {
            $scope.model.attributes.product_subcategory_id_data = null;
            $scope._setValueForm('product_subcategory_id_data', null);
        });
    }, _managerS2ProductMeasureType: function (params) {
        var el = params.objSelector;
        var valueCurrentRowId = params.rowId;
        var dataCurrent = [];
        if (this.model.attributes.product_measure_type_id_data.hasOwnProperty('id')) {

            dataCurrent = [this.model.attributes.product_measure_type_id_data];
        }
        var $scope = this;
        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", data: dataCurrent, ajax: {
                url: $("#action-product-measure-type-getListSelect2").val(),
                type: 'get',
                dataType: 'json',
                data: function (term, page) {

                    var paramsFilters = {
                        filters: {
                            search_value: term,
                        }
                    };
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }, allowClear: true, multiple: false, width: '100%'
        });

        elementInit.on('select2:select', function (e) {
            var data = e.params.data;
            $scope.model.attributes.product_measure_type_id_data = data;
        }).on("select2:unselecting", function (e) {
            $scope.model.attributes.product_measure_type_id_data = null;
            $scope._setValueForm('product_measure_type_id_data', null);
        });
    }, _managerS2Colors: function (params) {
        var el = params.objSelector;
        var modelId = params.modelId;
        var dataCurrent = [];
        var $scope = this;
        var businessId = null;
        var attributeModel = 'product_by_color_data';
        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                url: $("#action-product-color-listSelect2").val(),
                type: "get",
                dataType: 'json',
                data: function (term, page) {
                    var paramsFilters = {
                        filters: {
                            search_value: term, business_id: businessId
                        }
                    };
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }, allowClear: true, multiple: true, width: '100%',


        });
        elementInit.on("change", function (e) {
            var dataCurrent = elementInit.select2('data');
            if (dataCurrent.length != 0) {
                $scope.model.attributes[attributeModel] = dataCurrent;
            } else {
                $scope.model.attributes[attributeModel] = null;
                $scope._setValueForm(attributeModel, null);

            }
        });

        if (modelId) {
            $scope.setValuesS2Multiple({
                valueCurrent: modelId, elementS2: $(el), attributeModel: attributeModel, 'types': 'colors'
            });
        }
    }, _managerS2Sizes: function (params) {
        var el = params.objSelector;
        var modelId = params.modelId;
        var dataCurrent = [];
        var $scope = this;
        var businessId = null;
        var attributeModel = 'product_by_sizes_data';

        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                url: $("#action-product-sizes-listSelect2").val(),
                type: "get",
                dataType: 'json',
                data: function (term, page) {
                    var paramsFilters = {
                        filters: {
                            search_value: term, business_id: businessId
                        }
                    };
                    return paramsFilters;
                },
                processResults: function (data, page) {
                    return {results: data};
                }
            }, allowClear: true, multiple: true, width: '100%',


        });
        elementInit.on("change", function (e) {
            var dataCurrent = elementInit.select2('data');
            if (dataCurrent.length != 0) {
                $scope.model.attributes[attributeModel] = dataCurrent;
            } else {
                $scope.model.attributes[attributeModel] = null;
                $scope._setValueForm(attributeModel, null);
            }
        });

        if (modelId) {
            $scope.setValuesS2Multiple({
                modelId: modelId, elementS2: $(el), attributeModel: attributeModel, 'types': 'sizes'
            });
        }

    }, setValuesS2Multiple: function (params) {
        var modelId = params['modelId'];//id
        var elementS2 = params['elementS2'];
        var attributeModel = params['attributeModel'];
        var modelData = this.model.attributes[attributeModel];
        if (modelData.length) {
            dataCurrent = modelData;
            $.each(dataCurrent, function (key, value) {
                var option = new Option(value.text, value.id, true, true);
                elementS2.append(option).trigger('change');
            });
            var dataCurrent = elementS2.select2('data');
            this.model.attributes[attributeModel] = dataCurrent;
        }

    }, //uploads methods
    _uploadDataImage: function (eventSelector) {
        var selectorFile = $.UploadUtil.getSelectorElementUploadFile({
            toElement: eventSelector.toElement
        });
        selectorFile = '#file-' + selectorFile;
        $(selectorFile).click();
        eventSelector.stopPropagation();
    }, getAttributesManagerUpload: function (params) {
        var nameField = params['nameField'];
        var modelCurrent = params['modelCurrent'];

        var result = {};
        if (nameField == 'source') {
            result = {
                'selectorUpload': '#file-' + nameField,
                'selectorPreview': '#preview-' + nameField,
                'modelCurrent': modelCurrent,
                'modelAttributeName': nameField,
            };
        }
        return result;
    }, _managerEventsUpload: function (params) {
        var selectorUpload = params['selectorUpload'];
        var selectorPreview = params['selectorPreview'];
        var modelCurrent = params['modelCurrent'];
        $.UploadUtil.managerUploadModel(params);
    }, onSendEventsParent: function (params) {

        this.$emit('on-send-events-by-component-to-parent', params);
    }
}
})
;
