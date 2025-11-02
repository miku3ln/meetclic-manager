var componentThisRetentionTaxSubType;
var $configCurrentManagement = {
    'processName': 'retention-tax-sub-type',
    'modelName': 'RetentionTaxSubType',
    'objectThis': null,
    'events': {
        'parentName': '_updateParentByChildren'
    },
    formConfig: {
        "nameSelector": "#retention-tax-sub-type-form",
        "url": $('#action-retention-tax-sub-type-saveData').val(),
        "loadingMessage": 'Guardando...',
        "errorMessage": 'Error al guardar el RetentionTaxSubType.',
        "successMessage": 'El RetentionTaxSubType se guardo correctamente.',
        "nameModel": 'RetentionTaxSubType'
    },
    gridConfig: {
        selectorCurrent: "#retention-tax-sub-type-grid",
        url: $("#action-retention-tax-sub-type-getAdmin").val()
    },
    tabCurrentSelector: '#tab-retention-tax-sub-type'

};

Vue.component($configCurrentManagement['processName'] + '-component', {


    template: '#' + $configCurrentManagement['processName'] + '-template',
    directives: {
        initS2RetentionTaxType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2RetentionTaxType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2AccountingAccount: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2AccountingAccount({
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
        this.$root.$on($configCurrentManagement['events']['parentName'], function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        $configCurrentManagement['objectThis'] = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(250)},
            "description": {},
            "status": {required},
            "type": {required},
            "retention_tax_type_id_data": {required},
            "percentage": {required},
            "accounting_account_id_data": {required}
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
            manager_key_name: 'change_key',
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
            tabCurrentSelector: $configCurrentManagement['tabCurrentSelector'],
            processName: "Registro Acción.",
            formConfig: $configCurrentManagement['formConfig'],
//Grid config
            gridConfig: $configCurrentManagement['gridConfig'],
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
                this.resetForm();
                this._viewManager(3, rowId);
                this.managerMenuConfig.view = false;

                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.type = rowCurrent.type;
                this.model.attributes.retention_tax_type_id_data = {
                    id: rowCurrent.retention_tax_type_id,
                    text: rowCurrent.retention_tax_type
                };
                this.model.attributes.percentage = parseFloat(rowCurrent.percentage);
                this.model.attributes.accounting_account_id_data = {
                    id: rowCurrent.accounting_account_id,
                    text: rowCurrent.accounting_account
                };


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
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type.label + ":</span><span class='content-description__value'>" + row.type + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.retention_tax_type_id_data.label + ":</span><span class='content-description__value'>" + row.retention_tax_type + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.percentage.label + ":</span><span class='content-description__value'>" + row.percentage + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span   elementType='11'  class='content-description__title'>" + structure.accounting_account_id_data.label + ":</span><span class='content-description__value'>" + row.accounting_account + "</span>",
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
                "value": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 250,
                        "required": true,
                        "name": "value"
                    },
                    "id": "value",
                    "name": "value",
                    "label": "value",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 250.",
                    },
                },
                "description": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "description"
                    },
                    "id": "description",
                    "name": "description",
                    "label": "description",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "status": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }],
                        "required": true,
                        "name": "status"
                    },
                    "id": "status",
                    "name": "status",
                    "label": "status",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "type": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "type"
                    },
                    "id": "type",
                    "name": "type",
                    "label": "type",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "retention_tax_type_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "retention_tax_type_id_data"
                    },
                    "id": "retention_tax_type_id_data",
                    "name": "retention_tax_type_id_data",
                    "label": "retention tax type id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "percentage": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "percentage"
                    },
                    "id": "percentage",
                    "name": "percentage",
                    "label": "percentage",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "accounting_account_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "accounting_account_id_data"
                        },
                        "id": "accounting_account_id_data",
                        "name": "accounting_account_id_data",
                        "label": "accounting account id",
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
                "value": null,
                "description": null,
                "status": "ACTIVE",
                "type": null,
                "retention_tax_type_id_data": null,
                "percentage": null,
                "accounting_account_id_data": null
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
                RetentionTaxSubType:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "value": this.$v.model.attributes.value.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "status": this.$v.model.attributes.status.$model,
                        "type": this.$v.model.attributes.type.$model,
                        "retention_tax_type_id": this.$v.model.attributes.retention_tax_type_id_data.$model.id,
                        "percentage": this.$v.model.attributes.percentage.$model,
                        "accounting_account_id": this.$v.model.attributes.accounting_account_id_data.$model.id

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
        _managerS2RetentionTaxType: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.retention_tax_type_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-retention-tax-type-getListSelect2").val(),
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
                _this.model.attributes.retention_tax_type_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.retention_tax_type_id_data = null;
                _this._setValueForm('retention_tax_type_id_data', null);
            });
        }, _managerS2AccountingAccount: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.accounting_account_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-accounting-account-getListSelect2").val(),
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
                _this.model.attributes.accounting_account_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.accounting_account_id_data = null;
                _this._setValueForm('accounting_account_id_data', null);
            });
        },

    }
})
;



