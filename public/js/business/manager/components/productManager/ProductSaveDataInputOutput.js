var componentThisProductSaveDataInputOutput;
Vue.component('product-save-data-input-output-component', {
    template: '#product-save-data-input-output-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisProductSaveDataInputOutput = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "quantity_units": {required,  minValue: Validators.minValue(0)},
            "type_input": {required},

        };
        if (this.model.attributes.type_input == 0) {
            var maxValue = parseFloat(this.configParams.data.quantity_units);
            attributes['quantity_units'] = {
                required, maxValue: Validators.maxValue(maxValue),
                minValue: Validators.minValue(0),
            }
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
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },

                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion Inventario",
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
            tabCurrentSelector: '#modal-product-save-data-input-output',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#product-save-data-input-output-form",
                url: $('#action-product-save-data-input-output-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Producto.',
                successMessage: 'El producto se actualizo correctamente.',
                nameModel: "ProductSaveDataInputOutput"
            },
//Grid config
            submitStatus: "no",
            showManager: true,
            managerType: null,
            rowCurrent: null,
            allowReload: false
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refProductSaveDataInputOutputModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalProductSaveDataInputOutput',
                allowReload: this.allowReload
            });
        },
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._resetComponent();

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refProductSaveDataInputOutputModal.hide();
            this._resetComponent();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.model_id = rowCurrent.id;
            this.rowCurrent = rowCurrent;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refProductSaveDataInputOutputModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {


            }
        },

//MANAGER PROCESS
        allowViewButton: function () {
            var result = false;

            if (this.$v.model.attributes.quantity_units.$model > 0) {
                result = true;
            }
            return result;
        },
        getResultQuantityUnits: function () {
            var result = 0;
            var allowInputOutput = this.allowInputOutput();
            if (allowInputOutput) {
                var quantity_units_current = parseFloat(this.$v.model.attributes.quantity_units.$model?this.$v.model.attributes.quantity_units.$model:0);
                var quantity_units = parseFloat(this.configParams.data.quantity_units)
                if (this.$v.model.attributes['type_input'].$model == 0) {
                    result = quantity_units-quantity_units_current;
                } else {
                    result = quantity_units+quantity_units_current;

                }

            }

            return result;
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
                quantity_units: {
                    id: "quantity_units",
                    name: "quantity_units",
                    label: "Cantidad",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxValue: {
                        msj: "Los valores deben ser maximo :",
                    },

                },
                "type_input": {
                    id: "type_input",
                    name: "type_input",
                    label: "Tipo de Ingreso",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "0", "text": "Egreso"}, {"value": "1", "text": "Ingreso"}]
                },


            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "quantity_units": null,
                "type_input": 1,

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

            var result = {
                ProductSaveDataInputOutput:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "quantity_units": this.$v.model.attributes.quantity_units.$model,
                        "type_input": this.$v.model.attributes['type_input'].$model,
                        "product_id": this.model_id,
                        "product_inventory_id": this.configParams.data.product_inventory_id

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
                            $scope.resetForm();
                            $scope.allowReload = true;
                            $scope._hideModal();
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
            var successForm = currentAllow.success;

            var allowInputOutput = this.allowInputOutput();

            var result = successForm && allowInputOutput;
            return result;
        },
        allowInputOutput: function () {
            var result = true;
            var currentAllow = this.getValidateForm();
            var successForm = currentAllow.success;
            if (this.$v.model.attributes['type_input'].$model == 0) {
                if (successForm) {
                    var quantity_units = parseFloat(this.$v.model.attributes.quantity_units.$model);
                    if (quantity_units > parseFloat(this.configParams.data.quantity_units)) {
                        result = false;
                    }
                }
            }
            return result;
        },
        getValidateForm: getValidateForm,
//others functions


    }
})
;




