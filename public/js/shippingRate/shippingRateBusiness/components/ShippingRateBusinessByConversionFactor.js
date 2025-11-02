var componentThisShippingRateBusinessByConversionFactor;
Vue.component('shipping-rate-business-by-conversion-factor-component', {
    template: '#shipping-rate-business-by-conversion-factor-template',
    directives: {
        initS2ShippingRateServices: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ShippingRateServices({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ShippingRateKindsOfWay: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ShippingRateKindsOfWay({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ProductMeasureType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductMeasureType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;

    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisShippingRateBusinessByConversionFactor = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "shipping_rate_services_id_data": {required},
            "shipping_rate_kinds_of_way_id_data": {required},
            "product_measure_type_id_data": {required},

            "type_local": {},
            "value_factor": {required}
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
            manager_id: null,
            manager_key_name: 'shipping_rate_business_id',
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
            labelsConfig: {
                "title": "Administracion de Informacion",
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#modal-shipping-rate-business-by-conversion-factor',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#shipping-rate-business-by-conversion-factor-form",
                url: $('#action-shipping-rate-business-by-conversion-factor-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ShippingRateBusinessByConversionFactor.',
                successMessage: 'El ShippingRateBusinessByConversionFactor se guardo correctamente.',
                nameModel: "ShippingRateBusinessByConversionFactor"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#shipping-rate-business-by-conversion-factor-grid",
                url: $("#action-shipping-rate-business-by-conversion-factor-getAdmin").val()
            },
            showManager: false,
            managerType: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.id;
            this.initGridManager(this);
            this.initDataModal();
            this.$refs.refShippingRateBusinessByConversionFactorModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalShippingRateBusinessByConversionFactor'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refShippingRateBusinessByConversionFactorModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;

                this.initDataModal();
                this.$refs.refShippingRateBusinessByConversionFactorModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
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
        getMenuConfig: getMenuConfig,
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
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
                this.model.attributes.shipping_rate_services_id_data = {
                    id: rowCurrent.shipping_rate_services_id,
                    text: rowCurrent.shipping_rate_services
                };
                this.model.attributes.shipping_rate_kinds_of_way_id_data = {
                    id: rowCurrent.shipping_rate_kinds_of_way_id,
                    text: rowCurrent.shipping_rate_kinds_of_way
                };
                this.model.attributes.product_measure_type_id_data = {
                    id: rowCurrent.product_measure_type_id,
                    text: rowCurrent.product_measure_type
                };
                this.model.attributes.type_local = rowCurrent.type_local == 1 ? true : false;
                this.model.attributes.value_factor = parseFloat(rowCurrent.value_factor);

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.manager_id;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var formatters = {
                'description': function (column, row) {

                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.shipping_rate_services_id_data.label + ":</span><span class='content-description__value'>" + row.shipping_rate_services + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.shipping_rate_kinds_of_way_id_data.label + ":</span><span class='content-description__value'>" + row.shipping_rate_kinds_of_way + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_measure_type_id_data.label + ":</span><span class='content-description__value'>" + row.product_measure_type + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_local.label + ":</span><span class='content-description__value'>" +( row.type_local==1?'SI':'NO') + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.value_factor.label + ":</span><span class='content-description__value'>" + row.value_factor + "</span>",
                        "</div>"
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
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
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
                "shipping_rate_services_id_data": {
                    "id": "shipping_rate_services_id_data",
                    "name": "shipping_rate_services_id_data",
                    "label": "Servicios",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "shipping_rate_kinds_of_way_id_data": {
                    "id": "shipping_rate_kinds_of_way_id_data",
                    "name": "shipping_rate_kinds_of_way_id_data",
                    "label": "Formas de Envio",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "product_measure_type_id_data": {
                    "id": "product_measure_type_id_data",
                    "name": "product_measure_type_id_data",
                    "label": "Medida",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "type_local": {
                    "id": "type_local",
                    "name": "type_local",
                    "label": "Internacional?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "value_factor":
                    {
                        "id": "value_factor",
                        "name": "value_factor",
                        "label": "factor",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "shipping_rate_services_id_data": null,
                "shipping_rate_kinds_of_way_id_data": null,
                "product_measure_type_id_data": null,
                "type_local": null,
                "value_factor": null
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
                ShippingRateBusinessByConversionFactor:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "shipping_rate_services_id": this.$v.model.attributes.shipping_rate_services_id_data.$model.id,
                        "shipping_rate_kinds_of_way_id": this.$v.model.attributes.shipping_rate_kinds_of_way_id_data.$model.id,
                        "product_measure_type_id": this.$v.model.attributes.product_measure_type_id_data.$model.id,
                        "shipping_rate_business_id": this.manager_id,
                        "type_local": this.$v.model.attributes.type_local.$model == null ? 0 : (this.$v.model.attributes.type_local.$model ? 1 : 0),
                        "value_factor": this.$v.model.attributes.value_factor.$model

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
        _managerS2ShippingRateServices: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            var paramsFilters = {
                filters: {
                    search_value: '',
                    shipping_rate_business_id: this.manager_id
                }
            };
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.shipping_rate_services_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-shipping-rate-services-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        paramsFilters.filters.search_value = term;
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        console.log('processResults');

                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.shipping_rate_services_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.shipping_rate_services_id_data = null;
                _this._setValueForm('shipping_rate_services_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        }, _managerS2ShippingRateKindsOfWay: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.shipping_rate_kinds_of_way_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-shipping-rate-kinds-of-way-getListSelect2").val(),
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
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.shipping_rate_kinds_of_way_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.shipping_rate_kinds_of_way_id_data = null;
                _this._setValueForm('shipping_rate_kinds_of_way_id_data', null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        }, _managerS2ProductMeasureType: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.product_measure_type_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
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
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.product_measure_type_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.product_measure_type_id_data = null;
                _this._setValueForm('product_measure_type_id_data', null);
            });
        }

    }
})
;




