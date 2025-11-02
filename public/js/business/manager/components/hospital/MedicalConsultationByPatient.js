
var componentThisMedicalConsultationByPatient;
Vue.component('medical-consultation-by-patient-component', {
    template: '#medical-consultation-by-patient-template',
    directives: {},
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
    },
    mounted: function () {
        componentThisMedicalConsultationByPatient = this;
        this.initCurrentComponent();

    },
    validations: function () {
        var attributes = {
            "id": {},
            "reason_consultation": {required},
            "description": {required},
            "status": {required},
            "history_clinic_id_data": {},
            "payment_state": {},
            "prepayment": {},
            "price": {required},
            prepayment_allow: {}
        };
        if (this.model.attributes.prepayment_allow == 1 && this.model.attributes.payment_state == 0) {
            attributes['prepayment'] = {required};
        }
        if (this.model.attributes.payment_state == 1) {
            this.model.attributes.prepayment_allow = 0;
            this.model.attributes.prepayment = 0;

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
            manager_id: null,
            manager_key_name: 'history_clinic_id',
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
            tabCurrentSelector: '.tabs',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#medical-consultation-by-patient-form",
                url: $('#action-medical-consultation-by-patient-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el MedicalConsultationByPatient.',
                successMessage: 'El MedicalConsultationByPatient se guardo correctamente.',
                nameModel: "MedicalConsultationByPatient"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#medical-consultation-by-patient-grid",
                url: $("#action-medical-consultation-by-patient-getAdmin").val()
            },
            showManager: false,
            managerType: null,
            history_clinic_id: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.historyClinic.id;
            this.history_clinic_id = this.configParams.data.historyClinic.id;
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
                this._viewManager(3, rowId);
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.reason_consultation = rowCurrent.reason_consultation;
                this.model.attributes.description = rowCurrent.description;

                this.model.attributes.history_clinic_id_data = {
                    id: rowCurrent.history_clinic_id,
                    text: rowCurrent.history_clinic
                };
                this.model.attributes.payment_state = rowCurrent.payment_state;
                var prepayment = parseFloat(rowCurrent.prepayment);
                if (prepayment > 0) {
                    this.model.attributes.prepayment_allow = 1;
                } else {
                    this.model.attributes.prepayment_allow = 0;

                }
                this.model.attributes.prepayment = prepayment;

                this.model.attributes.price = parseFloat(rowCurrent.price);


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
                    var classStatusPayment = "badge-success";
                    if (row.payment_state == 0) {
                        classStatusPayment = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.payment_state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatusPayment + " '>" + (row.payment_state == 1 ? 'PAGADO' : 'DEUDA') + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.reason_consultation.label + ":</span><span class='content-description__value'>" + row.reason_consultation + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.prepayment.label + ":</span><span class='content-description__value'>" + row.prepayment + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.price.label + ":</span><span class='content-description__value'>" + row.price + "</span>",
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
                "reason_consultation": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "reason_consultation"
                    },
                    "id": "reason_consultation",
                    "name": "reason_consultation",
                    "label": "Procedimientos",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
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
                    "label": "Observaciones",
                    "required": {
                        "allow": true,
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
                    "label": "Estado",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "history_clinic_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "history_clinic_id_data"
                    },
                    "id": "history_clinic_id_data",
                    "name": "history_clinic_id_data",
                    "label": "history clinic id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "payment_state": {
                    "field-options": {
                        "elementType": 2,
                        "elementTypeText": "CheckBox",
                        "required": false,
                        "name": "payment_state"
                    },
                    "id": "payment_state",
                    "name": "payment_state",
                    "label": "Estado de Pago",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": 0, "text": "Deuda"}, {"value": 1, "text": "Pagado"}]

                },
                "prepayment_allow": {
                    "field-options": {
                        "elementType": 2,
                        "elementTypeText": "CheckBox",
                        "required": false,
                        "name": "prepayment_allow"
                    },
                    "id": "prepayment_allow",
                    "name": "prepayment_allow",
                    "label": "Abonar?",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": 1, "text": "SI"}, {"value": 0, "text": "NO"}]

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
                    "label": "user id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "prepayment": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "prepayment"
                    },
                    "id": "prepayment",
                    "name": "prepayment",
                    "label": "Abono $",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "price":
                    {
                        "field-options": {
                            "elementType": 6,
                            "elementTypeText": "Input Number",
                            "min": 0,
                            "required": true,
                            "name": "price"
                        },
                        "id": "price",
                        "name": "price",
                        "label": "Precio",
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
                "reason_consultation": null,
                "description": null,

                "status": "ACTIVE",
                "history_clinic_id_data": null,
                "payment_state": 1,
                "prepayment": null,
                "price": null,
                prepayment_allow: 0
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
                MedicalConsultationByPatient:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "reason_consultation": this.$v.model.attributes.reason_consultation.$model,
                        "description": this.$v.model.attributes.description.$model,

                        "status": this.$v.model.attributes.status.$model,
                        "history_clinic_id": this.manager_id,
                        "payment_state": this.$v.model.attributes.payment_state.$model,
                        "prepayment": this.$v.model.attributes.prepayment.$model == null ? 0 : this.$v.model.attributes.prepayment.$model,
                        "price": this.$v.model.attributes.price.$model

                    }
            };

            return result;
        },
        _saveModel: function () {

            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var $scope = this;
            $scope.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                $scope.submitStatus = 'error';
            } else {
                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: $scope.formConfig.loadingMessage,
                    error_message: $scope.formConfig.errorMessage,
                    success_message: $scope.formConfig.successMessage,
                    success_callback: function (response) {
                        if (response.success) {
                            $scope._resetManagerGrid();
                            $scope.resetForm();
                            $($scope.gridConfig.selectorCurrent).bootgrid("reload");
                            $scope._viewManager(2);

                        }
                    }
                });

            }


        },
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,

        getValidateForm: getValidateForm,


    }
})
;
