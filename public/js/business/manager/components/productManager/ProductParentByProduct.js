Vue.component(CONFIG_PRODUCT.process + '-component', {
    template: '#' + CONFIG_PRODUCT.process + '-template',
    directives: {
        initUploadImages: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var nameMethod = paramsInput.initMethod;
                nameMethod({
                    objSelector: el
                });
            }
        },
        initS2Packages: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var nameMethod = paramsInput.nameMethod;
                nameMethod({
                    objSelector: el
                });
            }
        },
        initS2ProductTrademark: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
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
                var paramsInput = binding.value;
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

        this.business_id = $businessManager.id;//this.configParams.business_id;
        this.product_parent_id = this.params.managerSteps.process.parent_id;
        const isCreate = this.params.managerStepsParent.process.parent_id == null;
        if (!isCreate) {
            var rowCurrent = this.params.managerStepsParent.process.data;
            this.product_id = rowCurrent.id;

        }

    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        this.initCurrentComponent();

        componentThisProductManager = this;
        const isCreate = this.params.managerStepsParent.process.parent_id == null;
        if (isCreate) {

            this.labelsConfig.buttons.managerSave = 'Crear';
        } else {

            this.labelsConfig.buttons.managerSave = 'Actualizar';
        }

    },
    validations: function () {
        var attributes = {
            "id": {},
            "change": {},
            "code": {required, maxLength: Validators.maxLength(64)},
            "name": {required},
            "state": {required},
            "product_trademark_id_data": {required},
            "product_category_id_data": {required},
            "product_subcategory_id_data": {required},
            "source": {},
            "description": {required},
            "code_provider": {maxLength: Validators.maxLength(80)},
            "code_product": {maxLength: Validators.maxLength(80)},
            "has_tax": {},
            "tax_id_data": {},
            "is_service": {},
            "sale_price": {required},
            "view_online": {},
            "product_measure_type_id_data": {required}, //product_details_shipping_fee
            "product_details_shipping_fee_id": {},
            "height": {required},
            "length": {required},
            "width": {required},
            "weight": {required},
            'quantity_units': {}, //product_by_stock
            /*   "min": {required},
               "max": {},*/
            "product_by_sizes_data": {},
            "product_by_color_data": {},
            "title": {required},
            "keyword": {required},
            "description_meta": {},
            product_by_details_id: {},
            product_by_meta_data_id: {},
            product_parent_by_product_id: {},
            business_by_products_id: {},
            product_inventory_id: {},
            "product_by_package_data": {required},


        };

        if (this.model.attributes['view_online']) {

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
                ...$staticsVariables, /*  ----MANAGER ENTITY---*/
            configModelEntity
    :
        {
            "buttonsManagements"
        :
            [{
                "title": "Actualizar",
                "data-placement": "top",
                "i-class": " fas fa-pencil-alt",
                "managerType": "updateEntity"
            }, {
                "title": "Inventario Administracion",
                "data-placement": "top",
                "i-class": " fas fa-tags",
                "managerType": "productSaveDataInputOutput"
            }
            ]
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
                'managerSave'
            :
                'Crear', 'update'
            :
                'Actualizar'
            }
        }
    ,

//form config
        model: {
            attributes: this.getAttributesForm(),
                structure
        :
            this.getStructureForm(),
        }
    ,
        tabCurrentSelector: '.content',
            processName
    :
        "Registro Acción.",
            formConfig
    :
        {
            nameSelector: "#" + CONFIG_PRODUCT.process + "-form",
                url
        :
            $('#action-' + CONFIG_PRODUCT.process + '-saveData').val(),
                loadingMessage
        :
            'Guardando...',
                errorMessage
        :
            'Error al guardar el Product.',
                successMessage
        :
            'El Producto se ',
                nameModel
        :
            CONFIG_PRODUCT.model
        }
    , //Grid config
        gridConfig: {
            selectorCurrent: "#" + CONFIG_PRODUCT.process + "-grid",
                url
        :
            $("#action-" + CONFIG_PRODUCT.process + "-getAdmin").val()
        }
    ,
        submitStatus: "no",
            showManager
    :
        false,
            managerType
    :
        null,
            configModalProductByMultimedia
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
        process_table: CONFIG_PRODUCT.process,
            product_parent_id
    :
        null, business_id
    :
        null,
            product_id
    :
        null,

            managerViewProductParent
    :
        {
        }
    ,
        managerReload: {
            type: [],
                allow
        :
            false
        }

    }
        ;


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
    initEmmitFromComponents: function () {
        this.$parent.$on('message-to-' + this.process_table, this.handleMessageFromParent);
    },
    destroyEmmitFromComponents: function () {
        this.$parent.$off('message-to-' + this.process_table, this.handleMessageFromParent);
    },
    handleMessageFromParent: function (params) {

        if (params.type == 'onSaveModelComponent') {
            this.product_parent_id = params.data.information['ProductParent'].id;
        }
    },
    resetAllProcessData: function () {
        this.managerSteps = this.getDataManagerSteps();
    }, initCurrentComponent: function () {

    },
    /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
    makeToast: function (params) {

    }, //MANAGER PROCESS
    /*Manager FORMS-AND VIEWS*/
    _viewManager: function (typeView, rowId) {

        if (typeView == 1) {//create


        } else if (typeView == 2) {//admin
            var type = '_viewManager';
            var isCreate = this.params.managerStepsParent.process.parent_id == null;
            if (!isCreate) {
                type = '_viewManagerUpdate';
            }
            this.onSendEventsParent({
                'type': type,
                'process': CONFIG_PRODUCT.process,
                'data': {
                    typeView: typeView,
                    managerReload: this.managerReload
                }
            });
        } else if (typeView == 3) {//update


        }
    }, //FORM CONFIG
    getViewErrorForm: function (objValidate) {
        var result = false;
        if (!objValidate.$dirty) {
            result = objValidate.$dirty ? (!objValidate.$error) : false;
        } else {
            result = objValidate.$error;
        }
        return result;
    },
    _submitForm: function (e) {
        console.log(e);
    },
    getStructureForm: function () {

        return CONFIG_PRODUCT_PARENT_BY_PRODUCT.product.getStructureForm;
    }, getAttributesForm: function () {
        return this.getValuesModelByCrud();
    },
    getValuesModelByCrud: function () {
        var id = null;
        var change = false;
        var code = null;
        var name = null;
        var state = "ACTIVE";
        var view_online = false;
        var product_trademark_id_data = null;
        var product_category_id_data = null;
        var product_subcategory_id_data = null;
        var source = null;
        var description = "S/N";
        var code_provider = "S/N";
        var code_product = "S/N";
        var has_tax = null;
        var is_service = null;
        var sale_price = 0;
        var product_measure_type_id_data = null;
        var product_by_color_data = null;
        var product_by_package_data = null;
        var product_by_sizes_data = null;
        var product_details_shipping_fee_id = null;
        var height = 0;
        var length = 0;
        var width = 0;
        var weight = 0;
        var quantity_units = 0;
        var tax_id_data = null;
        var title = 'Titulo Producto Meta S/N';
        var keyword = 'keyword Producto Meta S/N';
        var description_meta = 'Descripcion Producto Meta S/N';
        var product_by_details_id = null;
        var product_by_meta_data_id = null;
        var product_parent_by_product_id = null;
        var business_by_products_id = null;
        var product_inventory_id = null;
        var isCreate = this.params.managerStepsParent.process.parent_id == null;

        var params = {
            isCreate: isCreate
        };
        if (params.isCreate) {
            var managerParent = this.params.managerSteps.process.data;


            has_tax = (managerParent.tax_percentage == $configPartial.managerProductManager.data.taxCurrentZero.percentage) ? false : true;
            tax_id_data = {
                id: managerParent.tax_id,
                text: managerParent.tax_value,
            };

            if ($configPartial['valuesDefaultForm']['tradeMark']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['tradeMark']['data'];
                product_trademark_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
            }

            product_category_id_data = null;

            if ($configPartial['valuesDefaultForm']['category']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['category']['data'];
                product_category_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
                product_category_id_data = {
                    id: managerParent.product_category_id,
                    text: managerParent.product_category,
                };
            } else {
                product_category_id_data = {
                    id: managerParent.product_category_id,
                    text: managerParent.product_category,
                };
            }
            product_subcategory_id_data = null;
            if ($configPartial['valuesDefaultForm']['subcategory']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['subcategory']['data'];
                product_subcategory_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
                product_subcategory_id_data = {
                    id: managerParent.product_subcategory_id,
                    text: managerParent.product_subcategory,
                };
            } else {
                product_subcategory_id_data = {
                    id: managerParent.product_subcategory_id,
                    text: managerParent.product_subcategory,
                };
            }
            product_measure_type_id_data = null;

            if ($configPartial['valuesDefaultForm']['measureType']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['measureType']['data'];
                product_measure_type_id_data = {
                    id: dataCurrent.id, text: dataCurrent.value,
                };
            }

        } else {

            var rowCurrent = this.params.managerStepsParent.process.data;
            id = rowCurrent.id;
            code = rowCurrent.code;
            name = rowCurrent.name;
            state = rowCurrent.state;
            product_details_shipping_fee_id = rowCurrent.product_details_shipping_fee_id;
            height = parseFloat(rowCurrent.height != null ? rowCurrent.height : 0);
            length = parseFloat(rowCurrent.length != null ? rowCurrent.length : 0);
            width = parseFloat(rowCurrent.width != null ? rowCurrent.width : 0);
            weight = parseFloat(rowCurrent.weight != null ? rowCurrent.weight : 0);
            quantity_units = parseFloat(rowCurrent.quantity_units != null ? rowCurrent.quantity_units : 0);

            tax_id_data = {
                id: rowCurrent.tax_id,
                text: rowCurrent.tax_value,
            };
            product_trademark_id_data = {
                id: rowCurrent.product_trademark_id, text: rowCurrent.product_trademark
            };
            product_category_id_data = {
                id: rowCurrent.product_category_id, text: rowCurrent.product_category
            };
            product_subcategory_id_data = {
                id: rowCurrent.product_subcategory_id, text: rowCurrent.product_subcategory
            };
            source = rowCurrent.source;
            description = (rowCurrent.description != null || rowCurrent.description != "null") ? rowCurrent.description : "";
            code_provider = (rowCurrent.code_provider != null || rowCurrent.code_provider != "null") ? rowCurrent.code_provider : "";
            code_product = (rowCurrent.code_product != null || rowCurrent.code_product != "null") ? rowCurrent.code_product : "";
            has_tax = rowCurrent.has_tax == 1 ? true : false;
            is_service = rowCurrent.is_service == 1 ? true : false;
            view_online = rowCurrent.view_online == 1 ? true : false;

            product_measure_type_id_data = {
                id: rowCurrent.product_measure_type_id, text: rowCurrent.product_measure_type
            };
            sale_price = parseFloat(rowCurrent.sale_not_tax);
            product_inventory_id = (rowCurrent.product_inventory_id);
            product_by_color_data = rowCurrent['colors'];
            product_by_sizes_data = rowCurrent['sizes'];
            product_by_package_data = rowCurrent['packages'];
            business_by_products_id = rowCurrent['business_by_products_id'];
            product_by_details_id = rowCurrent['product_by_details_id'];

            product_inventory_id = rowCurrent['product_inventory_id'];

            var product_by_meta_data = rowCurrent.product_by_meta_data;
            var rowMeta = product_by_meta_data[0];
            title = rowMeta['title'];
            keyword = rowMeta['keyword'];
            description_meta = rowMeta['description'];
            product_by_meta_data_id = rowMeta['id'];
            product_parent_by_product_id = rowCurrent['product_parent_by_product_id'];
        }

        return {
            "id": id,
            "change": change,
            "code": code,
            "name": name,
            "state": state,
            "view_online": view_online,
            "product_trademark_id_data": product_trademark_id_data,
            "product_category_id_data": product_category_id_data,
            "product_subcategory_id_data": product_subcategory_id_data,
            "source": source,
            "description": description,
            "code_provider": code_provider,
            "code_product": code_product,
            "has_tax": has_tax,
            "tax_id_data": tax_id_data,
            "is_service": is_service,
            "sale_price": sale_price,
            "product_measure_type_id_data": product_measure_type_id_data,
            "product_by_color_data": product_by_color_data,
            "product_by_sizes_data": product_by_sizes_data, //product_details_shipping_fee
            "product_details_shipping_fee_id": product_details_shipping_fee_id,
            "height": height,
            "length": length,
            "width": width,
            "weight": weight,
            "quantity_units": quantity_units,
            "title": title,
            "keyword": keyword,
            "description_meta": description_meta,

            business_by_products_id: business_by_products_id,
            product_by_details_id: product_by_details_id,
            product_by_meta_data_id: product_by_meta_data_id,
            product_parent_by_product_id: product_parent_by_product_id,
            product_inventory_id: product_inventory_id,
            "product_by_package_data": product_by_package_data,


        };

    },
    getNameAttribute: function (name) {
        var result = this.formConfig.nameModel + "[" + name + "]";
        return result;
    },
    getLabelForm: viewGetLabelForm,
    _setValueForm: function (name, value) {
        this.model.attributes[name] = value;
        this.$v["model"]["attributes"][name].$model = value;
        this.$v["model"]["attributes"][name].$touch();
    },//parent-app
    getClassErrorForm: function (nameElement, objValidate) {
        var result = null;
        result = {
            "form-group--error": objValidate.$error,
            'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
        };

        return result;
    }, //Manager Model
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


        dataCurrentKeys = [];
        dataCurrentGet = this.$v.model.attributes.product_by_package_data.$model;
        $.each(dataCurrentGet, function (key, value) {
            var setPush = value.id;
            dataCurrentKeys.push(setPush);
        });
        dataCurrentKeys = dataCurrentKeys.join(',');
        var product_by_package_data = dataCurrentKeys;
        var result = {
            "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
            change: this.$v.model.attributes.change.$model,
            "code": this.$v.model.attributes.code.$model,
            "name": this.$v.model.attributes.name.$model,
            "state": this.$v.model.attributes.state.$model,
            "product_trademark_id": this.$v.model.attributes.product_trademark_id_data.$model.id,
            "product_category_id": this.$v.model.attributes.product_category_id_data.$model.id,
            "product_subcategory_id": this.$v.model.attributes.product_subcategory_id_data.$model.id,
            "source": this.$v.model.attributes.source.$model,
            "description": this.$v.model.attributes.description.$model,
            "code_provider": this.$v.model.attributes.code_provider.$model,
            "code_product": this.$v.model.attributes.code_product.$model,
            "has_tax": this.$v.model.attributes.has_tax.$model == null ? 0 : (this.$v.model.attributes.has_tax.$model ? 1 : 0),
            "is_service": 0,
            "view_online": this.$v.model.attributes.view_online.$model == null ? 0 : (this.$v.model.attributes.view_online.$model ? 1 : 0),
            "product_measure_type_id": this.$v.model.attributes.product_measure_type_id_data.$model.id,
            business_id: this.business_id,
            tax_id: this.$v.model.attributes.tax_id_data.$model.id,
            location_details: 'none',
            stock_control: 0,
            ice_control: 0,
            initial_stock_control: 0,
            "sale_price": this.$v.model.attributes.sale_price.$model,
            "product_by_sizes_data": product_by_sizes_data,
            "product_by_color_data": product_by_color_data,
            "product_details_shipping_fee_id": this.$v.model.attributes.product_details_shipping_fee_id.$model,
            "height": this.$v.model.attributes.height.$model,
            "length": this.$v.model.attributes.length.$model,
            "width": this.$v.model.attributes.width.$model,
            "weight": this.$v.model.attributes.weight.$model,
            "quantity_units": this.$v.model.attributes.quantity_units.$model,
            "title": this.$v.model.attributes.title.$model,
            "keyword": this.$v.model.attributes.keyword.$model,
            "description_meta": this.$v.model.attributes.description_meta.$model,
            "product_parent_id": this.product_parent_id,
            "business_by_products_id": this.$v.model.attributes.business_by_products_id.$model,
            "product_by_details_id": this.$v.model.attributes.product_by_details_id.$model,
            "product_by_meta_data_id": this.$v.model.attributes.product_by_meta_data_id.$model,
            "product_parent_by_product_id": this.$v.model.attributes.product_parent_by_product_id.$model,
            "product_inventory_id": this.$v.model.attributes.product_inventory_id.$model,
            "product_by_package_data": product_by_package_data,

        };


        return result;
    },
    setManagerProcess: function (params) {
        var dataCurrent = params.data;
        this.$v.model.attributes.id.$model = dataCurrent['Product']['id'];

        this.product_id = dataCurrent['Product']['id'];
        this.$v.model.attributes.business_by_products_id.$model = dataCurrent['BusinessByProduct']['id'];
        this.$v.model.attributes.product_by_details_id.$model = dataCurrent['ProductByDetails']['id'];
        this.$v.model.attributes.product_by_meta_data_id.$model = dataCurrent['ProductByMetaData']['id'];
        this.$v.model.attributes.product_parent_by_product_id.$model = dataCurrent['ProductParentByProduct']['id'];
        this.$v.model.attributes.product_inventory_id.$model = dataCurrent['ProductInventory']['id'];
        this.$v.model.attributes.product_details_shipping_fee_id.$model = dataCurrent['ProductDetailsShippingFee']['id'];


        this.onSendEventsParent({
            'type': 'setManagerProcessSave',
            'process': CONFIG_PRODUCT.process,
            'data': {
                getValuesSave: this.getValuesSave(),
                type: params.type
            }
        });

        this.managerReload.type.push(params.type);
        this.managerReload.allow = true;
    },
    _saveModel: function () {
        var dataSendResult = this.getValuesSave();
        var dataSend = dataSendResult;
        var vCurrent = this;
        vCurrent.$v.$touch();
        var validateCurrent = this.validateForm();
        var isCreate = dataSendResult.id == -1;
        var typeProcess = 'createRegister';
        var success_message = vCurrent.formConfig.successMessage;
        if (isCreate) {

            success_message += ' se a creado correctamente!.';
        } else {
            typeProcess = 'updateRegister';
            success_message += ' se a actualizado correctamente!.';

        }
        if (!validateCurrent) {
            vCurrent.submitStatus = 'error';

        } else {

            ajaxRequest(this.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: vCurrent.formConfig.loadingMessage,
                error_message: vCurrent.formConfig.errorMessage,
                success_message: success_message,
                success_callback: function (response) {

                    if (response.success) {
                        vCurrent.setManagerProcess({
                            data: response.data,
                            type: typeProcess,
                            process: vCurrent.process_table
                        });

                        if (isCreate) {
                            vCurrent.labelsConfig.buttons.managerSave = 'Actualizar';
                        }
                    }
                }
            }, true);


        }

    },
    resetForm: function () {

        this.$v.$reset();
        this.model = {
            attributes: this.getAttributesForm(), structure: this.getStructureForm()
        };
        this.model.attributes.id = null;
        this.resetAllProcessData();
    },
    _valuesForm: function (event) {
        this.model.init = false;
        this.validateForm();
    },
    validateForm: function () {
        var currentAllow = this.getValidateForm();
        return currentAllow.success;
    },
    getValidateForm: getValidateForm, //others functions

    initUploadImages: function (params) {
        var $scope = this;
        $.FileUpload.init({

            "currentController": $scope,
            "selectorCurrentPlugin": "#myAwesomeDropzone",
        });
        if (this.configParams.managerStepsParent.process.parent_id != null) {
            console.log('update', this.configParams.managerStepsParent.three.body.data);//
            var haystack = this.configParams.managerStepsParent.three.body.data;

            $.each(haystack, function (key, value) {
                var productMultimedia = JSON.stringify(value);
                var cardClass = 'dz-processing dz-image-preview dz-success dz-complete manager-row-' + value.id;
                var srcCurrent = $resourceRoot + value.source;
                var template = [
                    '<div class="card mt-1 mb-0 shadow-none border ' + cardClass + ' " >',
                    '   <div class="p-2">',
                    '       <div class="row align-items-center">',
                    '           <div class="col-auto">',
                    '                <img data-dz-thumbnail src="' + srcCurrent + '" class="avatar-sm rounded bg-light" alt="' + value.title + '">',
                    '           </div>',
                    '           <div class="col ps-0">',
                    '                <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name>' + value.title + '</a>',
                    '                  <p class="mb-0" data-dz-size></p>',
                    '           </div>',
                    '           <div class="col-auto">',
                    '               <a  data-row="' + value.id + '" class="btn btn-link btn-lg text-muted btn-remove-multimedia" data-dz-remove data-update="true">',
                    '                <i class="fe-x"></i>',
                    '                </a>',
                    '           </div>',
                    '       </div>',
                    '   </div>',
                    ' </div>'];
                $('#file-previews').append(template.join(""));
            });
            $('.btn-remove-multimedia').on('click', function (e) {
                $scope.removeItemMultimedia({
                    type: 'custom',
                    product_by_multimedia_id: $(e.currentTarget).attr('data-row')
                });
            });

        } else {
            console.log('create');
        }

        var selector = '#file-previews';
    },
    emitRemoveMultimedia: function (params) {
        this.onSendEventsParent({
            'type': 'emitRemoveMultimedia',
            'process': CONFIG_PRODUCT.process,
            'data': {
                type: params.type
            }
        });

        this.managerReload.type.push(params.type);
        this.managerReload.allow = true;
    },
    onSendEventsByPlugin: function (params) {
        this.onSendEventsParent({
            'type': 'onSendEventsByPlugin',
            'process': CONFIG_PRODUCT.process,
            'data': {type: params.type}
        });
        this.managerReload.type.push(params.type);
        this.managerReload.allow = true;
    },
    removeItemMultimedia: function (params) {
        var allowDeleteResource = false;//limit not has
        var type = params.type;
        if (type == 'custom') {
            allowDeleteResource = true;
        } else {
            if (params.file.status === 'error') {
                allowDeleteResource = false;
            } else if (params.file.status === 'success') {
                allowDeleteResource = true;
            }
        }

        var allowCustom = false;
        var dataSend = {};
        var tabCurrentSelector;
        var file = null;
        if (allowDeleteResource) {
            var urlManager = $("#action-product_by_multimedia-removeMultimedia").val();
            if (type == 'custom') {
                allowCustom = true;
                dataSend = {
                    product_by_multimedia_id: params.product_by_multimedia_id
                };
                tabCurrentSelector = "." + 'manager-row-' + params.product_by_multimedia_id;
            } else {
                file = params.file;
                var managerPost = JSON.parse(file.xhr.response);
                var managerPostData = managerPost['data'];
                var ProductByMultimedia = managerPostData['ProductByMultimedia'];
                var currentId = 'manager-row-' + ProductByMultimedia.id;
                $(file.previewElement).addClass(currentId);

                dataSend = {
                    product_by_multimedia_id: ProductByMultimedia.id
                };
                tabCurrentSelector = "." + currentId;
            }
            var $scope = this;
            ajaxRequest(urlManager, {
                type: 'POST',
                data: dataSend,
                blockElement: tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: 'Eliminando ........',
                error_message: 'No se elimino el archivo.',
                success_message: 'Eliminado Correctamente.!',
                success_callback: function (response) {
                    if (response.success) {
                        if (allowCustom) {
                            $(tabCurrentSelector).remove();

                        } else {
                            if (file.previewElement != null && file.previewElement.parentNode != null) {
                                file.previewElement.parentNode.removeChild(file.previewElement);
                            }
                        }
                        $scope.emitRemoveMultimedia({
                            type: type,
                        });
                    }
                }
            });
        } else {
            file = params.file;
            if (file.previewElement != null && file.previewElement.parentNode != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }
        }

    },
    initS2Packages: function (params) {
        var el = params.objSelector;
        var modelId = params.modelId;
        var dataCurrent = [];
        var $scope = this;
        var businessId = null;
        var attributeModel = 'product_by_package_data';
        var hasystack = this.params.managerSteps.two.body.tabs.two.table.data;
        var dataCurrent = [];
        var selectedIds = [];

        if (this.$v.model.attributes.product_by_package_data.$model != null && this.$v.model.attributes.product_by_package_data.$model.length > 0) {
            selectedIds = this.$v.model.attributes.product_by_package_data.$model;
        }
        $.each(hasystack, function (key, value) {
            var setPush = value;
            setPush.text = value.name;
            setPush.selected = false;
            dataCurrent.push(setPush);
        });

        if (selectedIds.length > 0) {
            $.each(selectedIds, function (key, valueSelect) {


                $.each(dataCurrent, function (key, value) {
                    var allow = value.id == valueSelect.id;
                    if (allow) {

                        dataCurrent[key].selected = true;
                    }
                });

            });
        }
        var elementInit = $(el).select2({
            data: dataCurrent,
            allow: true,
            placeholder: "Seleccione",
            allowClear: true,
            multiple: true,
            width: '100%',

        });
        elementInit.on("change", function (e) {
            var dataCurrent = elementInit.select2('data');
            if (dataCurrent.length != 0) {
                $scope.model.attributes[attributeModel] = dataCurrent;
            } else {
                $scope.model.attributes[attributeModel] = null;
                $scope._setValueForm(attributeModel, null);

            }
        }).on("select2:open", function (e) {
            /*
            var $select2 = $(this);
            var $dropdown = $select2.data('select2').$dropdown;
            // Desactivar cualquier selección actual
            $dropdown.find('.select2-results__option[aria-selected=true]').attr('aria-selected', false);
            // Seleccionar los elementos inicialmente seleccionados
            $.each(selectedIds, function(index, id) {
                $dropdown.find('.select2-results__option[data-select2-id="' + id + '"]').attr('aria-selected', true);
            });
            // Actualizar Select2
            $select2.val(selectedIds).trigger('change.select2');*/
        });

    },
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
    },
    _managerS2ProductCategory: function (params) {
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
            $scope.model.attributes.product_subcategory_id_data = null;
        }).on("select2:unselecting", function (e) {
            $scope.model.attributes.product_category_id_data = null;
            $scope._setValueForm('product_category_id_data', null);
            $scope.model.attributes.product_subcategory_id_data = null;


        });
    },
    _managerS2ProductSubcategory: function (params) {
        var el = params.objSelector;
        var valueCurrentRowId = params.rowId;
        var dataCurrent = [];
        if (this.model.attributes.product_subcategory_id_data.hasOwnProperty('id')) {

            dataCurrent = [this.model.attributes.product_subcategory_id_data];
        }
        var $scope = this;
        var elementInit = $(el).select2({
            allow: true, placeholder: "Seleccione", data: dataCurrent, ajax: {
                url: $("#action-product-subcategory-getListSelect2").val(),
                type: 'get',
                dataType: 'json',
                data: function (term, page) {

                    var paramsFilters = {
                        filters: {
                            search_value: term,
                            product_category_id: $scope.model.attributes.product_category_id_data.id
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
            $scope.model.attributes.product_subcategory_id_data = data;
        }).on("select2:unselecting", function (e) {
            $scope.model.attributes.product_subcategory_id_data = null;
            $scope._setValueForm('product_subcategory_id_data', null);
        });
    },
    _managerS2ProductMeasureType: function (params) {
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
    },
    _managerS2Colors: function (params) {
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
    },
    _managerS2Sizes: function (params) {
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

    },
    setValuesS2Multiple: function (params) {
        var modelId = params['modelId'];//id
        var elementS2 = params['elementS2'];
        var attributeModel = params['attributeModel'];
        var modelData = this.model.attributes[attributeModel];
        var types = params['types'];
        if (modelData.length) {
            dataCurrent = modelData;
            $.each(dataCurrent, function (key, value) {

                var option = new Option(value.text, value.id, true, true);
                elementS2.append(option).trigger('change');


            });
            var dataCurrent = elementS2.select2('data');
            this.model.attributes[attributeModel] = dataCurrent;
        }

    },

    //uploads methods
    _uploadDataImage: function (eventSelector) {
        var selectorFile = $.UploadUtil.getSelectorElementUploadFile({
            toElement: eventSelector.toElement
        });
        selectorFile = '#file-' + selectorFile;
        $(selectorFile).click();
        eventSelector.stopPropagation();
    },
    getAttributesManagerUpload: function (params) {
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
    },
    _managerEventsUpload: function (params) {
        var selectorUpload = params['selectorUpload'];
        var selectorPreview = params['selectorPreview'];
        var modelCurrent = params['modelCurrent'];
        $.UploadUtil.managerUploadModel(params);
    },

    onSendEventsParent: function (params) {

        this.$emit('on-send-events-by-component-to-parent', params);//BUSINESS-MANAGER-COMPONENT-JS-SEND-PARENT-DATA--ProductParentByPrices
    },
    getUrlCurrentUploadProductByImages: function () {

        var result = $('#action-product_by_multimedia-addMultimedia').val() + '/' + this.product_id;
        return result;
    }
}
})
;
(function ($) {
    "use strict";
//https://docs.dropzone.dev/configuration/tutorials/combine-form-data-with-files
    // Definición de la clase FileUploader
    function FileUploader() {
        // Selecciona el elemento 'body' y lo guarda en la propiedad '$body'
        this.$body = $("body");
    }


    // Método 'init' de la clase FileUploader
    FileUploader.prototype.init = function (params) {
        var currentController = params.currentController;
        var selectorCurrentPlugin = params.selectorCurrentPlugin;

        function addedfileCustom(file) {
            var _this2 = this;

            if (this.element === this.previewsContainer) {
                this.element.classList.add("dz-started");
            }

            if (this.previewsContainer) {
                file.previewElement = Dropzone.createElement(this.options.previewTemplate.trim());
                file.previewTemplate = file.previewElement; // Backwards compatibility

                this.previewsContainer.appendChild(file.previewElement);
                var _iteratorNormalCompletion3 = true;
                var _didIteratorError3 = false;
                var _iteratorError3 = undefined;

                try {
                    for (var _iterator3 = file.previewElement.querySelectorAll("[data-dz-name]")[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                        var node = _step3.value;
                        node.textContent = file.name;
                    }
                } catch (err) {
                    _didIteratorError3 = true;
                    _iteratorError3 = err;
                } finally {
                    try {
                        if (!_iteratorNormalCompletion3 && _iterator3["return"] != null) {
                            _iterator3["return"]();
                        }
                    } finally {
                        if (_didIteratorError3) {
                            throw _iteratorError3;
                        }
                    }
                }

                var _iteratorNormalCompletion4 = true;
                var _didIteratorError4 = false;
                var _iteratorError4 = undefined;

                try {
                    for (var _iterator4 = file.previewElement.querySelectorAll("[data-dz-size]")[Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
                        node = _step4.value;
                        node.innerHTML = this.filesize(file.size);
                    }
                } catch (err) {
                    _didIteratorError4 = true;
                    _iteratorError4 = err;
                } finally {
                    try {
                        if (!_iteratorNormalCompletion4 && _iterator4["return"] != null) {
                            _iterator4["return"]();
                        }
                    } finally {
                        if (_didIteratorError4) {
                            throw _iteratorError4;
                        }
                    }
                }

                if (this.options.addRemoveLinks) {
                    file._removeLink = Dropzone.createElement("<a class=\"dz-remove\" href=\"javascript:undefined;\" data-dz-remove>".concat(this.options.dictRemoveFile, "</a>"));
                    file.previewElement.appendChild(file._removeLink);
                }

                var removeFileEvent = function removeFileEvent(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (file.status === Dropzone.UPLOADING) {
                        return Dropzone.confirm(_this2.options.dictCancelUploadConfirmation, function () {
                            return _this2.removeFile(file);
                        });
                    } else {
                        if (_this2.options.dictRemoveFileConfirmation) {
                            return Dropzone.confirm(_this2.options.dictRemoveFileConfirmation, function () {
                                return _this2.removeFile(file);
                            });
                        } else {
                            return _this2.removeFile(file);
                        }
                    }
                };

                var _iteratorNormalCompletion5 = true;
                var _didIteratorError5 = false;
                var _iteratorError5 = undefined;

                try {
                    for (var _iterator5 = file.previewElement.querySelectorAll("[data-dz-remove]")[Symbol.iterator](), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
                        var removeLink = _step5.value;
                        removeLink.addEventListener("click", removeFileEvent);
                    }
                } catch (err) {
                    _didIteratorError5 = true;
                    _iteratorError5 = err;
                } finally {
                    try {
                        if (!_iteratorNormalCompletion5 && _iterator5["return"] != null) {
                            _iterator5["return"]();
                        }
                    } finally {
                        if (_didIteratorError5) {
                            throw _iteratorError5;
                        }
                    }
                }
            }
            currentController.onSendEventsByPlugin({type: 'addedfileCustom'});

        }

        // Desactiva la auto-detección de Dropzone
        Dropzone.autoDiscover = false;
        var thisOut = this;
        // Para cada elemento con el atributo 'data-plugin="dropzone"'
        $(selectorCurrentPlugin).each(function () {
            var templateCustom = [];
            // Obtiene la URL de destino de la acción del formulario
            var url = $(this).attr("action");

            // Obtiene el contenedor de previsualizaciones de archivos
            var previewsContainer = $(this).data("previewsContainer");
            var objectCurrent;
            // Configura las opciones para Dropzone
            var options = {
                url: url,
                maxFiles: 5,
                addedfile: addedfileCustom,
                removedfile: function (file) {
                    currentController.removeItemMultimedia({
                        type: 'plugin', file: file
                    })


                }
            };

            // Si se proporciona un contenedor de previsualización, agrégalo a las opciones
            if (previewsContainer) {
                options.previewsContainer = previewsContainer;
            }

            // Obtiene y asigna una plantilla de previsualización de carga de archivos
            var uploadPreviewTemplate = $(this).data("uploadPreviewTemplate");
            if (uploadPreviewTemplate) {
                options.previewTemplate = $(uploadPreviewTemplate).html();
            }
            objectCurrent = $(this).dropzone(options);

        });
    };

    // Crea una instancia de la clase FileUploader y la asigna a '$.FileUpload'
    $.FileUpload = new FileUploader();

})(window.jQuery);
