var componentThisBusinessByDiscount;
Vue.component('business-by-discount-component', {

    template: '#business-by-discount-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var vmCurrent = this;

        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });

    },
    beforeMount: function () {

        this.configParams = this.params;
        this.business_id =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        componentThisBusinessByDiscount = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "code": {},
            "name": {required},
            "type": {},
            "type_apply": {},
            "value": {required},
            "has_limit": {},
            "has_limit_end": {},
            "limit_init": {},
            "limit_end": {},
            "business_id_data": {},
            "minimum_requirements": {required},
            "apply_amount_min_products": {},
            "amount_min_use": {},
            "type_add_customers": {},
            "state": {required},
            "products_id_data": {required},
            "products_id_data_aux": {},

            "change_model": {},

        };
        if (this.model.attributes['has_limit']) {
            attributes['limit_init'] = {
                required
            };
            if (this.model.attributes['has_limit_end']) {
                attributes['limit_end'] = {
                    required
                };
            }

        }
        if (this.allowManagerProcess.fields.code) {
            attributes['code'] = {
                required, maxLength: Validators.maxLength(150)
            };
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
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    }
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '.content',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-by-discount-form",
                url: $('#action-business-by-discount-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el BusinessByDiscount.',
                successMessage: 'El BusinessByDiscount se guardo correctamente.',
                nameModel: "BusinessByDiscount"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#business-by-discount-grid",
                url: $("#action-business-by-discount-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            dataManagerProcess: $configPartial['dataManagerProcess'],
            configDataDiscountByProducts: {},
            configProcess: {},
            allowManagerProcess: {
                has_limit: false,
                fields: {
                    code: false
                }
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {

            this.initGridManager(this);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "changeValuesGridProductsDiscount") {

                this._setValuesProduct(emitValues.data);

            }
        },
        _setValuesProduct(params) {
            console.log(params.rowsDataManager);
            var rowsDataManager = params.rowsDataManager;
            if (this.model.attributes.id == null) {//create
                var rowsKeysData = rowsDataManager.rowsKeysData;
                if (rowsKeysData.length > 0) {
                    this._setValueForm('products_id_data', rowsKeysData.toString());
                } else {
                    this._setValueForm('products_id_data', null);
                }
            } else {

            }

        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: getMenuConfig,
        _gridManager: function (elementSelect) {
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: vmCurrent,
                elementSelect: elementSelect,

            });
        },
        _managerRowGrid: function (params) {
            var $scope = this;
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var dataSend = {filters: {business_by_discount_id: params.row.id, business_id: $scope.business_id}};
                ajaxRequest($('#action-discount-by-products-detailsProducts').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: 'Gestionando......',
                    error_message: 'Error en el sistema.',
                    success_message: 'Informacion obtenida',
                    success_callback: function (response) {

                        console.log(response);

                        initDataDiscounts(response);

                    }
                });

                function initDataDiscounts(response) {
                    var dataCurrent = response['DiscountByProducts'];
                    var products_id_data = [];
                    var products_id_data_aux = [];

                    $.each(dataCurrent, function (key, value) {
                        products_id_data_aux.push(value.id);
                        products_id_data.push(value.id);

                    });
                    $scope.model.attributes.products_id_data_aux =products_id_data_aux;

                    var elementDestroy = ("#a-menu-" + $scope.managerMenuConfig.rowId);
                    $scope._destroyTooltip(elementDestroy);
                    $scope.managerMenuConfig.view = false;
                    $scope.resetForm();
                    $scope.model.attributes.id = rowCurrent.id;
                    $scope.model.attributes.code = rowCurrent.code;
                    $scope.model.attributes.name = rowCurrent.name;
                    $scope.model.attributes.type = rowCurrent.type == 1 ? true : false;
                    $scope.model.attributes.type_apply = rowCurrent.type_apply == 1 ? true : false;
                    $scope.model.attributes.value = parseFloat(rowCurrent.value);
                    $scope.model.attributes.has_limit = rowCurrent.has_limit == 1 ? true : false;
                    $scope.model.attributes.has_limit_end = rowCurrent.has_limit_end == 1 ? true : false;
                    $scope.model.attributes.limit_init = rowCurrent.limit_init;
                    $scope.model.attributes.limit_end = rowCurrent.limit_end;
                    $scope.model.attributes.business_id_data = {id: rowCurrent.business_id, text: rowCurrent.business};
                    $scope.model.attributes.minimum_requirements = rowCurrent.minimum_requirements == 1 ? true : false;
                    $scope.model.attributes.apply_amount_min_products = rowCurrent.apply_amount_min_products;
                    $scope.model.attributes.amount_min_use = rowCurrent.amount_min_use;
                    $scope.model.attributes.type_add_customers = rowCurrent.type_add_customers == 1 ? true : false;
                    $scope.model.attributes.products_id_data = products_id_data;
                    $scope.model.attributes.state = rowCurrent.state;


                    $scope.configDataDiscountByProducts = {
                        view: true,
                        business_id: $scope.business_id,
                        business_by_discount_id: rowCurrent.id,
                        row: rowCurrent,
                        managerProcess:{
                            DiscountByProducts:dataCurrent,
                            rowsKeysData:products_id_data,

                        }
                    };
                    $scope._viewManager(3, rowId);
                }

            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {};
            var structure = vmCurrent.model.structure;


            var formatters = {
                'description': function (column, row) {
                    const TYPE_PERCENTAGE = 0;
                    const TYPE_AMOUNT_FIX = 1;
                    const TYPE_FREE_SHIPPING = 2;
                    const TYPE_BUY_X_GET_Y = 3;

                    const TYPE_APPLY_COMPLETE_ORDER = 1;
                    const TYPE_ADD_CUSTOMERS_NONE = 0;
                    const TYPE_ADD_SELECT_CUSTOMERS = 1;
                    const TYPE_ADD_SELECT_GROUP_CUSTOMERS = 1;

                    const TYPE_APPLY_PRODUCTS = 0;
                    const HAS_LIMIT_NOT = 0;
                    const HAS_LIMIT_YES = 1;
                    const HAS_LIMIT_END_NOT = 0;
                    const HAS_LIMIT_END_YES = 1;

                    const MINIMUM_REQUIREMENTS_NONE = 0;//NONE
                    const MINIMUM_REQUIREMENTS_MPA = 1;//Minimum purchase amount
                    const MINIMUM_REQUIREMENTS_MQOA = 2;//Minimum quantity of articles

                    const AMOUNT_MIN_USE_FOREVER = 0;//FOREVER USES
                    const AMOUNT_MIN_USE_LIMIT = 1;//LIMIT USE


                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning"
                    }
                    var typeDetails = null;
                    //1=Complete order /Customers
                    // 0=Products
                    var type = row.type;
                    /*  1=Complete order /Customers
                      0=Products*/
                    var type_apply = row.type_apply;
                    /*  0=not has limit days
                      1=has*/
                    var has_limit = row.has_limit;
                    /*  0=NOT HAS
                      1=HAS*/
                    var has_limit_end = row.has_limit_end;
                    //0=None
                    // 1=Minimum purchase amount
                    // 2=Minimum quantity of articles
                    var minimum_requirements = row.minimum_requirements;
                    //0=None
                    // 1=Apply
                    var apply_amount_min_products = row.apply_amount_min_products;
                    /* 0=ANY ONE
                     1=SELECT CUSTOMERS
                     2= GROUPS CUSTOMERS*/
                    var type_add_customers = row.apply_amount_min_products;
                    /*    0=FOREVER
                        1=LIMIT USE*/
                    var amount_min_use = row.amount_min_use;
                    var requirementsView = minimum_requirements ? ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.minimum_requirements.label + ":</span><span class='content-description__value'>" + row.minimum_requirements + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.apply_amount_min_products.label + ":</span><span class='content-description__value'>" + row.apply_amount_min_products + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.amount_min_use.label + ":</span><span class='content-description__value'>" + row.amount_min_use + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_add_customers.label + ":</span><span class='content-description__value'>" + row.type_add_customers + "</span>",
                        "</div>"] : [];
                    var dateView = has_limit ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.has_limit.label + ":</span><span class='content-description__value'>" + row.has_limit + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.has_limit_end.label + ":</span><span class='content-description__value'>" + row.has_limit_end + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.limit_init.label + ":</span><span class='content-description__value'>" + row.limit_init + "</span>",
                        "</div>",

                        has_limit_end ? ("<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.limit_end.label + ":</span><span class='content-description__value'>" + row.limit_end + "</span>",
                            "</div>") : '',

                    ] : [];
                    dateView = dateView.join("");
                    var result = [
                        "<div class='content-description'>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + "'>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code.label + ":</span><span class='content-description__value'>" + row.code + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type.label + ":</span><span class='content-description__value'>" + (row.type == TYPE_PERCENTAGE ? 'Porcentage' : row.type == TYPE_AMOUNT_FIX ? "Valor" : "") + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_apply.label + " a :</span><span class='content-description__value'>" + (row.type_apply == TYPE_APPLY_PRODUCTS ? 'Productos.' : row.type_apply == TYPE_APPLY_COMPLETE_ORDER ? "Orden Completa" : "") + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + (row.type == TYPE_PERCENTAGE ? ' % ' : row.type == TYPE_AMOUNT_FIX ? " $ " : "") + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>Total :</span><span class='content-description__value'><span class='badge badge--size-large badge-info'>" + row.total + "</span></span>",
                        "</div>",
                        dateView,
                        requirementsView,

                        , "</div>"];

                    return result.join("");
                }
            };

            let gridInit = initGridManager({
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                'urlCurrent': urlCurrent
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create

                this.showManager = true;
                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.resetForm();
                this.managerType = 1;
                this.business_id = $businessManager.id;// this.configParams.business_id;
                this.business_by_discount_id = this.configParams.business_by_discount_id;
                this.configDataDiscountByProducts = {
                    view: true,
                    business_id: this.business_id,
                    business_by_discount_id: null,
                    row: null
                };
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;

                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: false,
                });
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
                this.configDataDiscountByProducts.view = false;
            } else if (typeView == 3) {//update
                this.showManager = true;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }

        },
//FORM CONFIG
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                "code": {
                    "id": "code",
                    "name": "code",
                    "label": "Codigo Cupon",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 150.",
                    },
                },
                "name": {
                    "id": "name",
                    "name": "name",
                    "label": "Nombre Descuento",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type": {
                    "id": "type",
                    "name": "type",
                    "label": "Tipo Descuento",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_apply": {
                    "id": "type_apply",
                    "name": "type_apply",
                    "label": "Aplicar Descuento",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "value": {
                    "id": "value",
                    "name": "value",
                    "label": "Valor",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "has_limit": {
                    "id": "has_limit",
                    "name": "has_limit",
                    "label": "Tiene Período de duración?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "has_limit_end": {
                    "id": "has_limit_end",
                    "name": "has_limit_end",
                    "label": "Fijar una fecha de finalización ?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "limit_init": {
                    "id": "limit_init",
                    "name": "limit_init",
                    "label": "Fecha Inicio",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "limit_end": {
                    "id": "limit_end",
                    "name": "limit_end",
                    "label": "Fecha Final",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "business_id_data": {
                    "id": "business_id_data",
                    "name": "business_id_data",
                    "label": "business id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "minimum_requirements": {
                    "id": "minimum_requirements",
                    "name": "minimum_requirements",
                    "label": "Requerimientos",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "apply_amount_min_products": {
                    "id": "apply_amount_min_products",
                    "name": "apply_amount_min_products",
                    "label": "apply amount min products",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "amount_min_use": {
                    "id": "amount_min_use",
                    "name": "amount_min_use",
                    "label": "amount min use",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_add_customers": {
                    "id": "type_add_customers",
                    "name": "type_add_customers",
                    "label": "type add customers",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "state":
                    {
                        "id": "state",
                        "name": "state",
                        "label": "Estado",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            this.dataManagerProcess = $configPartial['dataManagerProcess'];
            var type = this.dataManagerProcess['typesData'][0].id;
            var type_apply = this.dataManagerProcess['typesApplyData'][1].id;
            var NOT_HAS_LIMIT_DAYS = false;
            var HAS_LIMIT_DAYS = true;
            var has_limit = NOT_HAS_LIMIT_DAYS;
            var has_limit_end = false;
            var minimum_requirements = 0;
            var apply_amount_min_products = 0;
            var amount_min_use = 0;
            var type_add_customers = 0;
            var result = {
                "id": null,
                "code": null,
                "name": null,
                "type": type,
                "type_apply": type_apply,
                "value": null,
                "has_limit": has_limit,
                "has_limit_end": has_limit_end,
                "limit_init": null,
                "limit_end": null,
                "business_id_data": null,
                "minimum_requirements": minimum_requirements,
                "apply_amount_min_products": apply_amount_min_products,
                "amount_min_use": amount_min_use,
                "type_add_customers": type_add_customers,
                "state": "ACTIVE",
                "change_model": false,
                "products_id_data": null,
                "products_id_aux": [],


            };
            return result;
        },
        getNameAttribute: getNameAttribute,
        _managerDates: function (name, value) {

            console.log(name, value);
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {

            var result = {
                BusinessByDiscount:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "code": this.$v.model.attributes.code.$model,
                        "name": this.$v.model.attributes.name.$model,
                        "type": this.$v.model.attributes.type.$model == null ? 0 : (this.$v.model.attributes.type.$model ? 1 : 0),
                        "type_apply": this.$v.model.attributes.type_apply.$model == null ? 0 : (this.$v.model.attributes.type_apply.$model ? 1 : 0),
                        "value": this.$v.model.attributes.value.$model,
                        "has_limit": this.$v.model.attributes.has_limit.$model == null ? 0 : (this.$v.model.attributes.has_limit.$model ? 1 : 0),
                        "has_limit_end": this.$v.model.attributes.has_limit_end.$model == null ? 0 : (this.$v.model.attributes.has_limit_end.$model ? 1 : 0),
                        "limit_init": this.$v.model.attributes.limit_init.$model,
                        "limit_end": this.$v.model.attributes.limit_end.$model,
                        "business_id": this.business_id,
                        "minimum_requirements": this.$v.model.attributes.minimum_requirements.$model == null ? 0 : (this.$v.model.attributes.minimum_requirements.$model ? 1 : 0),
                        "apply_amount_min_products": this.$v.model.attributes.apply_amount_min_products.$model,
                        "amount_min_use": this.$v.model.attributes.amount_min_use.$model,
                        "type_add_customers": this.$v.model.attributes.type_add_customers.$model == null ? 0 : (this.$v.model.attributes.type_add_customers.$model ? 1 : 0),
                        "state": this.$v.model.attributes.state.$model,
                        "products_id_data": (typeof(this.$v.model.attributes.products_id_data.$model)=='string'?this.$v.model.attributes.products_id_data.$model:this.$v.model.attributes.products_id_data.$model.join(',') ),
                        "change_model": this.$v.model.attributes.change_model.$model,
                    }
            };

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                vCurrent.submitStatus = 'error';

            } else {

                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: vCurrent.formConfig.loadingMessage,
                    error_message: vCurrent.formConfig.errorMessage,
                    success_message: vCurrent.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            vCurrent._resetManagerGrid();
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent._viewManager(2);
                        }
                    }
                });

            }

        },
        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm: getValidateForm,
//others functions


    }
})
;
