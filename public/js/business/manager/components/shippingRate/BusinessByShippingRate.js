var componentThisBusinessByShippingRate;
Vue.component('business-by-shipping-rate-component', {
    template: '#business-by-shipping-rate-template',
    directives: {
        initS2ShippingRateBusiness: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ShippingRateBusiness({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2Business: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2Business({
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
        this.business_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        componentThisBusinessByShippingRate = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "shipping_rate_business_id_data": {required},
            "state": {required}
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
            manager_key_name: 'business_id',
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
            tabCurrentSelector: '#tab-business-by-shipping-rate',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-by-shipping-rate-form",
                url: $('#action-business-by-shipping-rate-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el BusinessByShippingRate.',
                successMessage: 'El BusinessByShippingRate se guardo correctamente.',
                nameModel: "BusinessByShippingRate"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#business-by-shipping-rate-grid",
                url: $("#action-business-by-shipping-rate-getAdmin").val()
            },
            showManager: false,
            managerType: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = $businessManager.id;// this.configParams.business_id;
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
                this.model.attributes.shipping_rate_business_id_data = {
                    id: rowCurrent.shipping_rate_business_id,
                    text: rowCurrent.shipping_rate_business
                };
                this.model.attributes.business_id_data = {id: rowCurrent.business_id, text: rowCurrent.business};
                this.model.attributes.state = rowCurrent.state;

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

                    var classStatus = "badge-success";
                    if (row.state == "INACTIVE") {
                        classStatus = "badge-warning"
                    }
                    ;var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.shipping_rate_business_id_data.label + ":</span><span class='content-description__value'>" + row.shipping_rate_business + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + "'>" + row.state + "</span></span>",
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
                "shipping_rate_business_id_data": {
                    "id": "shipping_rate_business_id_data",
                    "name": "shipping_rate_business_id_data",
                    "label": "Empresa de Envio",
                    "required": {
                        "allow": true,
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
            var result = {
                "id": null,
                "shipping_rate_business_id_data": null, "state": "ACTIVE"
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
                BusinessByShippingRate:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "shipping_rate_business_id": this.$v.model.attributes.shipping_rate_business_id_data.$model.id,
                        "business_id": this.manager_id,
                        "state": this.$v.model.attributes.state.$model

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
        _managerS2ShippingRateBusiness: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.shipping_rate_business_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-shipping-rate-business-getListSelect2").val(),
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
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.shipping_rate_business_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.shipping_rate_business_id_data = null;
                _this._setValueForm('shipping_rate_business_id_data', null);
            });
        }
    }
})
;




