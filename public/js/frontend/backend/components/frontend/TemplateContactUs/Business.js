var componentThisBusiness;
Vue.component('business-information-component', {
    template: '#business-information-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    validations: function () {
        var attributes = {
            "id": {},
            "street_lng": {required},
            "street_lat": {required},
            "email": {required, email: Validators.email},
            "phone_value": {required},
            "street_1": {required},
            "street_2": {required},
            "options_map": {},

        };
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    created: function () {


    },
    beforeMount: function () {
console.log('BUSINESS COMPONENT');
        this.setManagerCurrent({data: this.params});
    },
    mounted: function () {
        componentThisBusiness = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    data: function () {

        var dataManager = {
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
            tabCurrentSelector: '#tab-template-contact-us',

            processName: "Registro Acción.",
            popoverShow: false,
            modelView: null,
            formConfig: {
                nameSelector: "#template-about-us-form",
                url: $('#action-business-saveDataFrontend').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Red Social.',
                successMessage: 'El TemplateAboutUs se guardo correctamente.',
                nameModel: "Business"
            },
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            template_information_id: null,
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        setManagerCurrent: function (params) {

            var dataModel = params.data.hasOwnProperty('model') ? params.data.model.attributes : (params.data.hasOwnProperty('business') ? params.data.business : params.data);
            this.modelView = dataModel;
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            };
            this.model['attributes'] = params.data.hasOwnProperty('model') ? params.data.model.attributes : (params.data.hasOwnProperty('business') ? params.data.business : params.data);
            console.log('setManagerCurrent COMPONENT',   this.model['attributes']);
            this.configParams = dataModel;
            this.template_information_id = params.data.template_information_id;
        },
        getStructureForm: function () {
            var result = {
                street_lng: {
                    id: "street_lng",
                    name: "street_lng",
                    label: "Longitud",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },

                street_1: {
                    id: "street_1",
                    name: "street_1",
                    label: "Calle Principal",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                street_2: {
                    id: "street_2",
                    name: "street_2",
                    label: "Calle Secundaria",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                phone_value: {
                    id: "phone_value",
                    name: "phone_value",
                    label: "Telefono",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                street_lat: {
                    id: "street_lat",
                    name: "street_lat",
                    label: "Latitud",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_map: {
                    id: "options_map",
                    name: "options_map",
                    label: "Options Map",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                email: {
                    id: "email",
                    name: "email",
                    label: "Email",
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
                "options_map": null,
                "street_lat": null,
                "phone_value": null,
                "street_2": null,
                "street_1": null,
                "street_lng": null,
                "email": null,

            };
            return result;
        },
        _setManagerMap(params) {
            var latLng = params.latLng;
            var options_map = params.options_map;
            options_map = JSON.stringify(options_map);
            this.$v.model.attributes.street_lat.$model = latLng.lat;
            this.$v.model.attributes.street_lng.$model = latLng.lng;
            this.$v.model.attributes.options_map.$model = options_map;
            this.model.attributes.street_lat = latLng.lat;
            this.model.attributes.street_lng = latLng.lng;
            this.model.attributes.options_map = options_map;
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
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm: getValidateForm,
        onClose() {
            this.popoverShow = false
        },
        onOk() {

        },
        onShow() {
            // This is called just before the popover is shown
            // Reset our popover form variables
            this.setManagerCurrent({
                data: {model: {attributes: this.configParams}, template_information_id: this.template_information_id}
            });
        },
        onShown() {
            // Called just after the popover has been shown
            // Transfer focus to the first input

        },
        onHidden() {


        },


        initCurrentComponent: function () {


        },
//MANAGER PROCESS
        /*---------GRID--------*/
        _saveModel: function () {
            var dataSendResult = {

                "Business": {
                    id: this.model.attributes.id,
                    email: this.model.attributes.email,
                    phone_value: this.model.attributes.phone_value,
                    street_1: this.model.attributes.street_1,
                    street_2: this.model.attributes.street_2,
                    street_lat: this.model.attributes.street_lat,
                    street_lng: this.model.attributes.street_lng,
                    template_information_id: this.template_information_id,


                }
            };
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                vCurrent.submitStatus = 'error';

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
                            var dataSave = response['data'];
                            var business = dataSave['business'];
                            vCurrent.configParams = dataSave;
                            vCurrent.setManagerCurrent({
                                data: {
                                    model: {attributes: business},
                                    template_information_id: vCurrent.template_information_id
                                }
                            });
                            vCurrent.popoverShow = false;
                        }
                    }
                });
            }
        },

    }
})
;




