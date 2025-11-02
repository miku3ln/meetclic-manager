var componentThisTreatmentByPayment;
Vue.component('treatment-by-payment-component', {

    template: '#treatment-by-payment-template',
    directives: {
        initS2TypesPaymentsByAccount: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2TypesPaymentsByAccount({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2TreatmentByBreakdownPayment: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2TreatmentByBreakdownPayment({
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
        componentThisTreatmentByPayment = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "payment_date": {},
            "payment_date_current": {},

            "state_payment": {},
            "details": {},
            "types_payments_by_account_id_data": {},
            "accounting_account_id": {},
            "user_id": {},
            "treatment_by_breakdown_payment_id_data": {required},
            "treatment_by_indebtedness_paying_init_id_data": {}
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
            manager_key_name: 'treatment_by_indebtedness_paying_init_id',
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": []
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
            tabCurrentSelector: '.modal-dialog',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#treatment-by-payment-form",
                url: $('#action-treatment-by-payment-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Pago del Tratamiento.',
                successMessage: 'El Pago del Tratamiento se guardo correctamente.',
                nameModel: "TreatmentByPayment"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#treatment-by-payment-grid",
                url: $("#action-treatment-by-payment-getAdmin").val()
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

        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalTreatmentByPayment'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },

        initDataModal: function () {
            var rowCurrent = this.configParams.data;
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
                this.model.attributes.payment_date = rowCurrent.payment_date;
                this.model.attributes.state_payment = rowCurrent.state_payment == 1 ? true : false;
                this.model.attributes.details = rowCurrent.details;
                this.model.attributes.types_payments_by_account_id_data = {
                    id: rowCurrent.types_payments_by_account_id,
                    text: rowCurrent.types_payments_by_account
                };
                this.model.attributes.accounting_account_id = rowCurrent.accounting_account_id;
                this.model.attributes.user_id = rowCurrent.user_id;
                this.model.attributes.treatment_by_breakdown_payment_id_data = {
                    id: rowCurrent.treatment_by_breakdown_payment_id,
                    text: rowCurrent.treatment_by_breakdown_payment
                };
                this.model.attributes.treatment_by_indebtedness_paying_init_id_data = {
                    id: rowCurrent.treatment_by_indebtedness_paying_init_id,
                    text: rowCurrent.treatment_by_indebtedness_paying_init
                };

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.configParams.data.id;
            ;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var formatters = {
                'description': function (column, row) {
                    var classStatePayment = "badge-warning";
                    var rowStatePayment = 'PAGO INPUNTUAL';
                    if (row.state_payment == 1) {
                        rowStatePayment = 'PAGO PUNTUAL';
                        classStatePayment = "badge-success";
                    }

                    var result = [
                        "<div class='content-description'>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.treatment_by_breakdown_payment_id_data.label + ":</span><span class='content-description__value'>" + row.treatment_by_breakdown_payment + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state_payment.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatePayment + " '>" + rowStatePayment + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.payment_date.label + ":</span><span class='content-description__value'>" + row.payment_date + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.details.label + ":</span><span class='content-description__value'>" + row.details + "</span>",
                        "</div>",

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
                "payment_date": {
                    "field-options": {
                        "elementType": 4,
                        "elementTypeText": "Date",
                        "required": true,
                        "name": "payment_date"
                    },
                    "id": "payment_date",
                    "name": "payment_date",
                    "label": "Fecha de Pago",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "payment_date_current": {
                    "field-options": {
                        "elementType": 4,
                        "elementTypeText": "Date",
                        "required": true,
                        "name": "payment_date_current"
                    },
                    "id": "payment_date_current",
                    "name": "payment_date_current",
                    "label": "Fecha Cobro",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "state_payment": {
                    "field-options": {
                        "elementType": 2,
                        "elementTypeText": "CheckBox",
                        "required": false,
                        "name": "state_payment"
                    },
                    "id": "state_payment",
                    "name": "state_payment",
                    "label": "Pago Puntualmente?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "details": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "details"
                    },
                    "id": "details",
                    "name": "details",
                    "label": "Observaciones",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "types_payments_by_account_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "types_payments_by_account_id_data"
                    },
                    "id": "types_payments_by_account_id_data",
                    "name": "types_payments_by_account_id_data",
                    "label": "Formas de Pago",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "accounting_account_id": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "accounting_account_id"
                    },
                    "id": "accounting_account_id",
                    "name": "accounting_account_id",
                    "label": "accounting account id",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "user_id": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "user_id"
                    },
                    "id": "user_id",
                    "name": "user_id",
                    "label": "Usuario",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "treatment_by_breakdown_payment_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "treatment_by_breakdown_payment_id_data"
                    },
                    "id": "treatment_by_breakdown_payment_id_data",
                    "name": "treatment_by_breakdown_payment_id_data",
                    "label": "Pago #",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "treatment_by_indebtedness_paying_init_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "treatment_by_indebtedness_paying_init_id_data"
                        },
                        "id": "treatment_by_indebtedness_paying_init_id_data",
                        "name": "treatment_by_indebtedness_paying_init_id_data",
                        "label": "treatment by indebtedness paying init id",
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
            var dateCurrent = new Date();
            dateCurrent = dateCurrent.toInputFormat()
            var result = {
                "id": null,
                "payment_date": null,
                "payment_date_current": dateCurrent,
                "state_payment": null,
                "details": null,
                "types_payments_by_account_id_data": null,
                "accounting_account_id": null,
                "user_id": null,
                "treatment_by_breakdown_payment_id_data": null,
                "treatment_by_indebtedness_paying_init_id_data": null
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
                TreatmentByPayment:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "payment_date": this.$v.model.attributes.payment_date.$model,
                        "state_payment": this.$v.model.attributes.state_payment.$model == null ? 0 : (this.$v.model.attributes.state_payment.$model ? 1 : 0),
                        "details": this.$v.model.attributes.details.$model,
                        "types_payments_by_account_id": 1,
                        "accounting_account_id": 1,
                        "user_id": null,
                        "treatment_by_breakdown_payment_id": this.$v.model.attributes.treatment_by_breakdown_payment_id_data.$model.id,
                        "treatment_by_indebtedness_paying_init_id": this.manager_id

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
        _initGridCurrent: function () {
            this.initGridManager(this);
        }, _managerS2TreatmentByBreakdownPayment: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.treatment_by_breakdown_payment_id_data];
            }
            var $scope = this;
            var treatment_by_indebtedness_paying_init_id = this.manager_id;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-treatment-by-breakdown-payment-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                treatment_by_indebtedness_paying_init_id: treatment_by_indebtedness_paying_init_id
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
                $scope.model.attributes.treatment_by_breakdown_payment_id_data = data;
                $scope.model.attributes.payment_date = data.date_agreement_set;

            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.treatment_by_breakdown_payment_id_data = null;
                $scope._setValueForm('treatment_by_breakdown_payment_id_data', null);
                $scope.model.attributes.payment_date = null;

            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        }

    }
})
;




