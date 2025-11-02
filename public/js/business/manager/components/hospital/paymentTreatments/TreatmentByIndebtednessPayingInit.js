var componentThisTreatmentByIndebtednessPayingInit;
Vue.component('treatment-by-indebtedness-paying-init-component', {
    template: '#treatment-by-indebtedness-paying-init-template'
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on("_treatmentByIndebtednessPayingInit", function (emitValue) {
            $scope._managerTypes(emitValue);
        });

    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisTreatmentByIndebtednessPayingInit = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "number_payments": {required},
            items: {
                required,
                minLength: minLength(1),
                $each: {
                    date_agreement: {
                        required
                    },
                    payment_value: {required},
                    state_payment: {},
                    treatment_by_indebtedness_paying_init_id: {},

                }
            }

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
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {},
            configParams: {},
            labelsConfig: {
                "title": "Gestion de Pagos",
                process: {
                    "payment": "Pagos"
                },
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
            tabCurrentSelector: '.modal-content',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#treatment-by-indebtedness-paying-init-form",
                url: $('#action-treatment-by-indebtedness-paying-init-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el TreatmentByIndebtednessPayingInit.',
                successMessage: 'El TreatmentByIndebtednessPayingInit se guardo correctamente.',
                nameModel: "TreatmentByIndebtednessPayingInit"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#treatment-by-indebtedness-paying-init-grid",
                url: $("#action-treatment-by-indebtedness-paying-init-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            managerId: null,
            rowManagement: null,
            rowManagementChildren: null,
            process: {
                'TreatmentByIndebtednessPayingInit': {
                    'title': 'Acuerdo Pagos',
                    allow: true,
                    data: [],
                    active: true,
                    createUpdate: true,
                },
                'TreatmentPayment': {
                    'title': 'Administracion Pagos',
                    allow: false,
                    data: [],
                    active: false,

                }
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refTreatmentByIndebtednessPayingInitModal.show();
        },

        /*modal events*/
        _showModal: function () {
            if (!this.managerId) {
                this.resetForm();
            }

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalTreatmentByIndebtednessPayingInit'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refTreatmentByIndebtednessPayingInitModal.hide();

        },
        initDataModal: function () {
            var TreatmentByPatient = this.configParams.data.TreatmentByPatient;
            var TreatmentByIndebtednessPayingInit = this.configParams.data.TreatmentByIndebtednessPayingInit;
            this.initValuesProcess({
                TreatmentByPatient: TreatmentByPatient,
                TreatmentByIndebtednessPayingInit: TreatmentByIndebtednessPayingInit
            });

        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refTreatmentByIndebtednessPayingInitModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_treatmentByPatient', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: function (params) {
            var $msjCurrent = params.msj;
            var $titleCurrent = params.title;
            var $typeCurrent = params.type;

            this.$notify({
                type: $typeCurrent,
                title: $titleCurrent,
                duration: 0,
                content: $msjCurrent,

            }).then(() => {
// resolve after dismissed
                console.log('dismissed');
            });
        },
//MANAGER PROCESS
        /*---------GRID--------*/
        _gridManager: function (elementSelect) {
            var vmCurrent = this;

        },
        _initGridCurrent: function () {
            this.initGridManager(this);
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                treatment_by_patient_id: this.managerId
            };
            var structure = vmCurrent.model.structure;

            var formatters = {
                'description': function (column, row) {
                    var classStatePayment = "badge-success";
                    var rowStatePayment = 'PAGADO';
                    if (row.state_payment == 1) {
                        rowStatePayment = 'POR PAGAR';
                        classStatePayment = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state_payment.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatePayment + " '>" + rowStatePayment + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.date_agreement.label + ":</span><span class='content-description__value'>" + row.date_agreement + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.payment_value.label + ":</span><span class='content-description__value'>" + row.payment_value + "</span>",
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


            });
        },

//FORM CONFIG
        getViewErrorForm: function (objValidate) {
            var result = false
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
            var result = {
                number_payments: {
                    id: "number_payments",
                    name: "number_payments",
                    label: "# Pagos",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 45.",
                    },
                },
                payment_value: {
                    id: "payment_value",
                    name: "payment_value",
                    label: "$ Valor Acordado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 45.",
                    },
                },
                date_agreement: {
                    id: "date_agreement",
                    name: "date_agreement",
                    label: "Fecha Acordada",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 45.",
                    },
                },
                state_payment: {
                    id: "state_payment",
                    name: "state_payment",
                    label: "Estado de Pago",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 45.",
                    },
                },
                items: {
                    id: "items",
                    name: "items",
                    label: "Fechas de Pagos.",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "items": [],
                "number_payments": 0,

            };
            return result;
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
        },
        getClassErrorForm: function (nameElement, objValidate) {
            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        },
//Manager Model

        getValuesSave: function () {
            var treatment_by_patient_id = this.managerId;
            var haystack = this.$v.model.attributes.items.$each.$iter;
            var items = [];
            $.each(haystack, function (indexRow, valueRow) {
                var date_agreement = valueRow['date_agreement']['$model'];
                var payment_value = valueRow['payment_value']['$model'];
                var state_payment = 1;
                var treatment_by_indebtedness_paying_init_id = -1;

                var setPush = {
                    date_agreement: date_agreement,
                    payment_value: payment_value,
                    state_payment: state_payment,
                    treatment_by_indebtedness_paying_init_id: treatment_by_indebtedness_paying_init_id
                };
                items.push(setPush);
            });
            var result = {
                    TreatmentByIndebtednessPayingInit: {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        number_payments: this.$v.model.attributes.number_payments.$model,
                        "items": items,
                        "treatment_by_patient_id": treatment_by_patient_id,

                    }
                }
            ;

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
                            var dataManagement = response.data;
                            var TreatmentByIndebtednessPayingInit = dataManagement.TreatmentByIndebtednessPayingInit;
                            $scope.initValuesProcess({
                                TreatmentByPatient: $scope.rowManagement,
                                TreatmentByIndebtednessPayingInit: TreatmentByIndebtednessPayingInit
                            });
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
            var currentAllowItems = this.getValidateFormItems();
            console.log(currentAllowItems);
            var result = false;
            result = currentAllow.success && currentAllowItems.success;
            return result;
        },

        getValidateForm: getValidateForm,
//process
        getValidateFormItems: function () {
            var success = true;
            var errors = [];
            var haystack = this.$v.model.attributes.items.$each.$iter;
            var TreatmentByPatient = this.configParams.data.TreatmentByPatient;
            var invoice_value = parseFloat(TreatmentByPatient.invoice_value);
            var invoice_value_management = 0;
            if (Object.keys(haystack).length > 0) {
                $.each(haystack, function (indexRow, valueRow) {
                    var payment_valueCurrent = (valueRow['payment_value']['$model'] == null || valueRow['payment_value']['$model'] == '') ? 0 : parseFloat(valueRow['payment_value']['$model']);
                    invoice_value_management += payment_valueCurrent;
                });

                if (invoice_value_management.toFixed(2) < invoice_value.toFixed(2) || invoice_value_management.toFixed(2) > invoice_value.toFixed(2)) {

                    if (invoice_value_management.toFixed(2) < invoice_value.toFixed(2)) {
                        errors.push({
                            'field': 'items',
                            'name': 'items',
                            'msg': 'El valor total de los pagos no coincide con el valor total del tratamiento : ' + invoice_value,

                        });
                    } else {
                        errors.push({
                            'field': 'item',
                            'name': 'item',
                            'msg': 'El valor total de los pagos excede  con el valor total del tratamiento : ' + invoice_value,

                        });
                    }
                    success = false;
                } else {
                    success = true;
                    console.log('bien ');
                }
            } else {
                success = false;
                errors.push({
                    'field': 'item', 'msg': 'No existe items agregados.'
                });
            }
            var result = {
                success: success,
                errors: errors
            };
            return result;
        },
        _managementProcess: function (process) {

            this.process.TreatmentPayment.active = false;
            this.process.TreatmentByIndebtednessPayingInit.active = false;
            if (process == 1) {
                this.process.TreatmentPayment.active = true;
                this.process.TreatmentPayment.data = this.rowManagementChildren;
            } else {
                this.process.TreatmentByIndebtednessPayingInit.active = true;


            }

        },
        initValuesProcess: function (params) {
            var TreatmentByIndebtednessPayingInit = params['TreatmentByIndebtednessPayingInit'];
            var TreatmentByPatient = params['TreatmentByPatient'];
            var managerId = TreatmentByPatient.id;
            this.managerId = managerId;
            this.process.TreatmentByIndebtednessPayingInit.createUpdate = true;
            if (TreatmentByIndebtednessPayingInit.hasOwnProperty('id')) {
                this.process.TreatmentByIndebtednessPayingInit.createUpdate = false;
                this.process.TreatmentPayment.allow = true;
                this.model.attributes = TreatmentByIndebtednessPayingInit;
            }
            this.rowManagement = TreatmentByPatient;
            this.rowManagementChildren = TreatmentByIndebtednessPayingInit;

            var invoice_value = parseFloat(TreatmentByPatient.invoice_value);
            this.labelsConfig.title = '';
            this.labelsConfig.title = 'Gestion de Pago:' + ' <span class="badge badge--size-large badge-info "> $ ' + invoice_value + '</span>';
        },
        getFormStateClassRowGridItem: function (params) {
            /*{'form-group--error': v.$error==true ,'form-group--success': v.$error==false  }*/
            console.log('getFormStateClassRowGridItem', params);
        },
        _setValueItemForm: function (params) {
            var indexCurrent = params['index'];
            var keyItemCurrent = params['keyItem'];
            var modelValue = params['model '];
            var haystack = this.$v.model.attributes.items.$each.$iter;

        },
        _deleteValueItemForm: function (params) {

            var indexCurrent = params['index'];
            var keyItemCurrent = params['keyItem'];
            var modelValue = params['model '];
            this.$v.model.attributes.items.$model.splice(indexCurrent, 1);
            var haystack = this.$v.model.attributes.items.$each.$iter;
        },
        _calculate: function () {
            var valueCurrent = parseFloat(this.rowManagement.invoice_value);
            var numberPayments = parseFloat(this.model.attributes.number_payments);
            var currentDate = new Date();
            var days = 30;
            var dataManagement = [];
            var payment_value = valueCurrent / numberPayments;
            payment_value = payment_value.toFixed(2);
            this.$v.model.attributes.items.$model = [];
            for (var i = 0; i < numberPayments; i++) {
                var dateCurrent = currentDate;
                dateCurrent.setDate(dateCurrent.getDate() + days);
                var date_agreement = dateCurrent.toInputFormat();
                var setPush = {
                    'date_agreement': date_agreement,
                    'payment_value': payment_value,

                };
                this.$v.model.attributes.items.$model.push(setPush);
            }


        }
    }
})
;

