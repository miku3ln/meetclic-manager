var componentThisShippingRateBusiness;
Vue.component('shipping-rate-business-component', {
    template: '#shipping-rate-business-template',
    props: {
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

    },
    mounted: function () {
        componentThisShippingRateBusiness = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "title": {required, maxLength: Validators.maxLength(150)},
            "description": {},
            "state": {required},
            "value": {required}
        };
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
                    },
                    {
                        "title": "Administracion Servicios de Envio",
                        "data-placement": "top",
                        "i-class": " fas fa-bullhorn",
                        "managerType": "shippingRateServices"
                    },
                    {
                        "title": "Administracion Factor Conversion",
                        "data-placement": "top",
                        "i-class": " fas fa-exchange-alt",
                        "managerType": "shippingRateBusinessByConversionFactor"
                    },
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
            tabCurrentSelector: '#tab-shipping-rate-business',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#shipping-rate-business-form",
                url: $('#action-shipping-rate-business-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ShippingRateBusiness.',
                successMessage: 'El ShippingRateBusiness se guardo correctamente.',
                nameModel: "ShippingRateBusiness"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#shipping-rate-business-grid",
                url: $("#action-shipping-rate-business-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            configModalShippingRateServices: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalShippingRateBusinessByConversionFactor:{
                "title": "Title",
                "viewAllow": false,
                "data": []
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

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: function (params) {
            var result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value, rowId: params.rowId,
                    managerType: value["managerType"],
                    params: params,
                    isUrl: value["isUrl"],
                    url: value["url"],
                }
                result.push(setPush);
            });
            return result;
        },
        _gridManager: function (elementSelect) {
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: vmCurrent,
                elementSelect: elementSelect,

            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.title = rowCurrent.title;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.value = rowCurrent.value ? parseFloat(rowCurrent.value) : 0;
                this.model.attributes.shipping_rate_business_by_min_weight_id = (rowCurrent.shipping_rate_business_by_min_weight_id);

                this._viewManager(3, rowId);
            } else if (params.managerType == 'shippingRateServices') {
                this.configModalShippingRateServices.data = rowCurrent;
                if (this.configModalShippingRateServices.viewAllow) {
                    this.$refs.refShippingRateServices._setValueOfParent(
                        {type: "openModal", data: this.configModalShippingRateServices}
                    );
                } else {
                    this.configModalShippingRateServices.viewAllow = true;
                }
            }

            else if (params.managerType == 'shippingRateBusinessByConversionFactor') {
                this.configModalShippingRateBusinessByConversionFactor.data = rowCurrent;
                if (this.configModalShippingRateBusinessByConversionFactor.viewAllow) {
                    this.$refs.refShippingRateBusinessByConversionFactor._setValueOfParent(
                        {type: "openModal", data: this.configModalShippingRateBusinessByConversionFactor}
                    );
                } else {
                    this.configModalShippingRateBusinessByConversionFactor.viewAllow = true;
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

                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning"
                    }
                    ;var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + "'>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.title.label + ":</span><span class='content-description__value'>" + row.title + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",


                        "</div>"];

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
        _viewManager: _viewManager,
//FORM CONFIG
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                "title": {
                    "id": "title",
                    "name": "title",
                    "label": "Empresa de Entrega",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 150.",
                    },
                },
                "description": {
                    "id": "description",
                    "name": "description",
                    "label": "Descripcion",
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
                , "value":
                    {
                        "id": "value",
                        "name": "value",
                        "label": "Valor minimo Peso",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        }
                    }
            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "title": null, "description": null, "state": "ACTIVE", "value": null,
                'shipping_rate_business_by_min_weight_id': null
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,

        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {

            var result = {
                ShippingRateBusiness:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "title": this.$v.model.attributes.title.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "state": this.$v.model.attributes.state.$model,
                        "value": this.$v.model.attributes.value.$model,
                        "shipping_rate_business_by_min_weight_id": this.model.attributes.shipping_rate_business_by_min_weight_id,
                    }
            };

            return result;
        },
        _saveModel: _saveModel,
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,

        getValidateForm: getValidateForm,
//others functions


    }
})
;




