var componentThisTemplateChatApi;

Vue.component('template-chat-api-component', {
    template: '#template-chat-api-template'
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.initCurrentComponent();
    },
    mounted: function () {
        componentThisTemplateChatApi = this;


    },
    validations: function () {
        var attributes = {
            "id": {},
            "type": {},
            page_id: {required},
            allow: {},
            logged_in_greeting: {required},
            logged_out_greeting: {required},
            'theme_color': {required}
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
            configParams: {},
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#template-chat-api-manager',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#template-chat-api-form",
                url: $('#action-template-chat-api-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar.',
                successMessage: 'Se guardo correctamente.',
                nameModel: "TemplateChatApi"
            },
            model_id: null,
            rowCurrent: null,
            source_type: 0,
            business_id: null,
            labelProcess: 'Creación',
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {
            var dataImages = this.configParams.data;//all images
            var filters = this.configParams.filters;//all images
            var rowCurrent = dataImages['facebook'];
            if (rowCurrent) {

                var attributes = this.getAttributesOptions(rowCurrent);
                this.labelProcess = 'Actualización';
                this.model.attributes = attributes;
            } else {

            }
            this.model_id = filters.model_id;
            this.business_id = filters.business_id;
            this.rowCurrent = rowCurrent;

        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
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
                type: {
                    id: "type",
                    name: "type",
                    label: "Tipo Api",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": 0, "text": "Facebook Messenger"}]

                },
                logged_in_greeting: {
                    id: "logged_in_greeting",
                    name: "logged_in_greeting",
                    label: "Saludo Login",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                logged_out_greeting: {
                    id: "logged_out_greeting",
                    name: "logged_out_greeting",
                    label: "Saludo Logout",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                theme_color: {
                    id: "theme_color",
                    name: "theme_color",
                    label: "Color Boton",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                page_id: {
                    id: "page_id",
                    name: "page_id",
                    label: "Id Facebook",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                allow: {
                    id: "allow",
                    name: "allow",
                    label: "Habilitar",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "type": 0,//facebook
                "page_id": null,
                "logged_in_greeting": "Hola como estas, como te podemos ayudar.",
                theme_color: "#44bec7",
                logged_out_greeting: "Hola como estas, como te podemos ayudar.",
                allow: true,
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
        getViewError: function (model) {
            var result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getAttributesOptions: function (rowCurrent) {
            var optionsString = rowCurrent.options;
            var optionsObj = JSON.parse(optionsString);
            var attributes = {
                "id": rowCurrent.id,
                "type": rowCurrent.type,//facebook
                "page_id": rowCurrent.page_id,
                "logged_in_greeting": optionsObj.logged_in_greeting,
                theme_color: optionsObj.theme_color,
                logged_out_greeting: optionsObj.logged_out_greeting,
                allow: rowCurrent.allow == 1 ? true : false,
            };

            return attributes;
        },
        getValuesSave: function () {
            var options = {
                'attribution': 'setup_tool',
                'logged_in_greeting': this.model.attributes.logged_in_greeting ,
                'theme_color': this.model.attributes.theme_color ,
                'logged_out_greeting': this.model.attributes.logged_out_greeting
            };
            var options = JSON.stringify(options);
            var result = {
                TemplateChatApi: {
                    "id": this.model.attributes.id ? this.model.attributes.id : -1,
                    "type": this.model.attributes.type,
                    "options": options,
                    "page_id": this.model.attributes.page_id,
                    "allow": this.model.attributes.allow ? 1 : 0,
                    "template_information_id": this.model_id,
                    business_id: this.business_id
                }
            };
            return result;
        },
        _saveModel: function () {
            var updateCreate = this.$v.model.attributes.id.$model ? true : false;

            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                alert('Error en el formulario.');

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
                            var attributes = response.data.attributes;
                            vCurrent.resetForm();
                            var attributes = vCurrent.getAttributesOptions(attributes);
                            vCurrent.model.attributes = attributes;
                            vCurrent.labelProcess='Actualización';

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

        getValidateForm:getValidateForm,


    }
})
;




