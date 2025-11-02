var componentThisBusinessByInventoryManagement;
Vue.component('business-by-inventory-management-component', {
    template: '#business-by-inventory-management-template',
    directives: {
        'init-data-picker': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var data = paramsInput['data'];
                var initMethod = paramsInput['initMethod'];
                initMethod({
                    el: el,
                    data: data
                });

            }
        },
    }
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
        componentThisBusinessByInventoryManagement = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "header_content_background_color_subcategories": {},
            "type": {required},

        };
        if (this.model.attributes.type == 1) {

            attributes['header_content_background_color_subcategories'] = {
                required
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
                "title": "Configuracion de Tienda- Diseño y Estructura",
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
            tabCurrentSelector: '#modal-business-by-inventory-management',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-by-inventory-management-form",
                url: $('#action-business-by-inventory-management-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar la configuracion.',
                successMessage: 'El producto se actualizo correctamente.',
                nameModel: "BusinessByInventoryManagement"
            },
//Grid config
            submitStatus: "no",
            showManager: true,
            managerType: null,
            rowCurrent: null,
            allowReload: false,
            business_id: null
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refBusinessByInventoryManagementModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalBusinessByInventoryManagement',
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
            this.$refs.refBusinessByInventoryManagementModal.hide();
            this._resetComponent();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.model_id = rowCurrent.id;
            this.business_id = rowCurrent.business_id;

            if (this.model_id) {
                this.model.attributes['id'] = this.model_id;
                this.model.attributes['type'] = rowCurrent['data']['type'];
                this.rowCurrent = rowCurrent['data'];
                if (rowCurrent['data']['type'] == 1) {//customize
                    var header_content_background_color_subcategories = '';
                    var config_management_inventory = rowCurrent['data']['config_management_inventory'];
                    if (config_management_inventory == "'{}'") {//someone error
                        header_content_background_color_subcategories = '#facc39';
                    } else {
                        config_management_inventory = jQuery.parseJSON(config_management_inventory);
                        header_content_background_color_subcategories = config_management_inventory['header_subcategories']['content']['styles']['background_color'];
                    }
                    this.model.attributes['header_content_background_color_subcategories'] = header_content_background_color_subcategories;
                }

            }
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refBusinessByInventoryManagementModal.show();

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
                header_content_background_color_subcategories: {
                    id: "header_content_background_color_subcategories",
                    name: "header_content_background_color_subcategories",
                    label: "Background Color Header Subcategorias",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                "type": {
                    id: "type",
                    name: "type",
                    label: "Tipo ",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": 0, "text": "Default"}, {"value": 1, "text": "Menu de Comidas"}]
                },


            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "header_content_background_color_subcategories": '#facc39',
                "type": 0,

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
            var config_management_inventory = {};
            if (this.$v.model.attributes['type'].$model == 1) {
                config_management_inventory = {
                    'header_subcategories': {
                        content: {
                            styles: {
                                background_color: this.$v.model.attributes.header_content_background_color_subcategories.$model
                            }

                        }
                    }
                };
            }
            config_management_inventory = JSON.stringify(config_management_inventory);
            var result = {
                BusinessByInventoryManagement:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "config_management_inventory": config_management_inventory,
                        "type": this.$v.model.attributes['type'].$model,
                        "business_id": this.business_id

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

                            $scope.allowReload = true;
                            $scope.model.attributes['id'] = response.data['id'];

                        }
                    }
                });

            }

        },
        resetForm: function () {
            if (!this.model.attributes['id']) {

                this.$v.$reset();
                this.model = {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm()
                };
                this.model.attributes.id = null;
            }
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            var successForm = currentAllow.success;


            var result = successForm;
            return result;
        },

        getValidateForm: getValidateForm,
//others functions
        initDataPicker: function (params) {
            console.log(params);
            var elementCurrent = params['el'];
            var $scope = this;
            $(elementCurrent).colorpicker({
                disabled: true,
            }).on('change', function (e) {

                var currentValue = $(this).val();
                $scope.model.attributes.header_content_background_color_subcategories = currentValue;
            }).on('colorpickerCreate', function (e) {
                console.log('colorpickerCreate', e);
            }).on('colorpickerChange', function (e) {
                console.log('colorpickerCreate', e);
            })
        }

    }
})
;




