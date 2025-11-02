var componentThisInformationSocialNetwork;
Vue.component('information-social-network-component', {
    template: '#information-social-network-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(150),url:Validators.url},
            "information_social_network_type_id": {required},

        };
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.setManagerCurrent({
            data: this.configParams
        });
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
            'model': null,
            modelView: null,
            socialNetworkTypeFacebook: 1,
            socialNetworkTypeFacebookIcon: 'fab fa-facebook-f',
            socialNetworkTypeInstagram: 2,
            socialNetworkTypeInstagramIcon: 'fab fa-instagram',
            socialNetworkTypeTwitter: 3,
            socialNetworkTypeTwitterIcon: ' fab fa-twitter',

            socialNetworkLinkedin: 4,
            socialNetworkLinkedinIcon: ' fab fa-linkedin-in',

            socialNetworkYoutube: 5,
            socialNetworkYoutubeIcon: 'fab fa-youtube',
            socialNetworkTypeWhatsApp: 6,
            socialNetworkTypeWhatsAppIcon: 'fab fa-whatsapp',
            dataInformationSocialNetworkType: [],
            dataInformationSocialNetwork: [],

            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            model_id: null,
            business_id: null,
            formConfig: {
                nameSelector: "#template-about-us-form",
                url: $('#action-information-social-network-saveDataFrontend').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Red Social.',
                successMessage: 'El TemplateAboutUs se guardo correctamente.',
                nameModel: "InformationSocialNetwork"
            },
            rowManager: null,
            template_information_id: null
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        setManagerCurrent: function (params) {

            var dataCurrent = params.data;
            this.model_id = dataCurrent.model_id;
            this.business_id = dataCurrent.business_id;
            this.configParams = dataCurrent;

            this.dataInformationSocialNetwork = [];
            var dataInformationSocialNetwork = [];
            this.dataInformationSocialNetworkTypes = [];
            this.dataInformationSocialNetwork = [];
            var $this = this;
            var dataInformationSocialNetworkTypes = [];

            if (dataCurrent['facebook']) {

                var setPush = {
                    value: dataCurrent['facebook']["value"],
                    id: dataCurrent['facebook']["id"],
                    icon: $this.socialNetworkTypeFacebookIcon,
                    "state": dataCurrent['facebook']["state"],
                    entity_id: dataCurrent['facebook']["entity_id"],
                    entity_type: dataCurrent['facebook']['entity_type'],
                    information_social_network_type_id: dataCurrent['facebook']['information_social_network_type_id'],

                };
                dataInformationSocialNetwork.push(setPush);
            } else {
                var setPush = {
                    id: $this.socialNetworkTypeFacebook,
                    icon: $this.socialNetworkTypeFacebookIcon,
                    text: 'Facebook',

                }
                dataInformationSocialNetworkTypes.push(setPush);

            }

            if (dataCurrent['whatsapp']) {

                var setPush = {
                    value: dataCurrent['whatsapp']["value"],
                    id: dataCurrent['whatsapp']["id"],
                    icon: $this.socialNetworkTypeWhatsAppIcon,
                    "state": dataCurrent['whatsapp']["state"],
                    entity_id: dataCurrent['whatsapp']["entity_id"],
                    entity_type: dataCurrent['whatsapp']['entity_type'],
                    information_social_network_type_id: dataCurrent['whatsapp']['information_social_network_type_id'],

                };
                dataInformationSocialNetwork.push(setPush);
            } else {
                var setPush = {
                    id: $this.socialNetworkTypeWhatsApp,
                    icon: $this.socialNetworkTypeWhatsAppIcon,
                    text: 'Whatsapp',

                }
                dataInformationSocialNetworkTypes.push(setPush);
            }
            if (dataCurrent['instagram']) {

                var setPush = {
                    value: dataCurrent['instagram']["value"],
                    id: dataCurrent['instagram']["id"],
                    icon: $this.socialNetworkTypeInstagramIcon,
                    "state": dataCurrent['instagram']["state"],
                    entity_id: dataCurrent['instagram']["entity_id"],
                    entity_type: dataCurrent['instagram']['entity_type'],
                    information_social_network_type_id: dataCurrent['instagram']['information_social_network_type_id'],

                };
                dataInformationSocialNetwork.push(setPush);
            } else {
                var setPush = {
                    id: $this.socialNetworkTypeInstagram,
                    icon: $this.socialNetworkTypeInstagramIcon,
                    text: 'Instagram',

                }
                dataInformationSocialNetworkTypes.push(setPush);
            }
            if (dataCurrent['twitter']) {
                var setPush = {
                    value: dataCurrent['twitter']["value"],
                    id: dataCurrent['twitter']["id"],
                    icon: $this.socialNetworkTypeTwitterIcon,
                    "state": dataCurrent['twitter']["state"],
                    entity_id: dataCurrent['twitter']["entity_id"],
                    entity_type: dataCurrent['twitter']['entity_type'],
                    information_social_network_type_id: dataCurrent['twitter']['information_social_network_type_id'],

                };
                dataInformationSocialNetwork.push(setPush);
            } else {
                var setPush = {
                    id: $this.socialNetworkTypeTwitter,
                    icon: $this.socialNetworkTypeTwitterIcon,
                    text: 'Twitter',

                }
                dataInformationSocialNetworkTypes.push(setPush);
            }
            if (dataCurrent['youtube']) {
                var setPush = {
                    value: dataCurrent['youtube']["value"],
                    id: dataCurrent['youtube']["id"],
                    icon: $this.socialNetworkYoutubeIcon,
                    "state": dataCurrent['youtube']["state"],
                    entity_id: dataCurrent['youtube']["entity_id"],
                    entity_type: dataCurrent['youtube']['entity_type'],
                    information_social_network_type_id: dataCurrent['youtube']['information_social_network_type_id'],

                };
                dataInformationSocialNetwork.push(setPush);
            } else {
                var setPush = {
                    id: $this.socialNetworkYoutube,
                    icon: $this.socialNetworkYoutubeIcon,
                    text: 'Youtube',

                }
                dataInformationSocialNetworkTypes.push(setPush);
            }


            this.dataInformationSocialNetworkTypes = dataInformationSocialNetworkTypes;
            this.dataInformationSocialNetworkTypesAux = dataInformationSocialNetworkTypes;
            this.dataInformationSocialNetwork = dataInformationSocialNetwork;

            componentThisInformationSocialNetwork = this;

            if (this.model.attributes.id) {
                var socialNetwork = this.model.attributes;
                var allowPush = true;
                var information_social_network_type_id = socialNetwork['information_social_network_type_id'];

                $.each(this.dataInformationSocialNetworkTypes, function (key, value) {
                    if (value.id == information_social_network_type_id) {
                        allowPush = false;
                    }
                });

                if (allowPush) {
                    var setPush = {};
                    if (information_social_network_type_id == this.socialNetworkLinkedin) {
                        var setPush = {
                            id: this.socialNetworkLinkedin,
                            icon: $this.socialNetworkLinkedinIcon,
                            text: 'LinkedIn',

                        }
                        this.dataInformationSocialNetworkTypes.push(setPush);
                    }

                    if (information_social_network_type_id == this.socialNetworkTypeFacebook) {
                        var setPush = {
                            id: this.socialNetworkTypeFacebook,
                            icon: $this.socialNetworkTypeFacebookIcon,
                            text: 'Facebook',

                        }
                        this.dataInformationSocialNetworkTypes.push(setPush);
                    }
                    if (information_social_network_type_id == this.socialNetworkTypeTwitter) {
                        var setPush = {
                            id: this.socialNetworkTypeTwitter,
                            icon: $this.socialNetworkTypeTwitterIcon,
                            text: 'Twitter',

                        }
                        this.dataInformationSocialNetworkTypes.push(setPush);
                    }
                    if (information_social_network_type_id == this.socialNetworkTypeInstagram) {
                        var setPush = {
                            id: this.socialNetworkTypeInstagram,
                            icon: $this.socialNetworkTypeInstagramIcon,
                            text: 'Instagram',

                        }
                        this.dataInformationSocialNetworkTypes.push(setPush);
                    }
                    if (information_social_network_type_id == this.socialNetworkYoutube) {
                        var setPush = {
                            id: this.socialNetworkYoutube,
                            icon: $this.socialNetworkYoutubeIcon,
                            text: 'Youtube',

                        }
                        this.dataInformationSocialNetworkTypes.push(setPush);
                    }
                    if (information_social_network_type_id == this.socialNetworkTypeWhatsApp) {
                        var setPush = {
                            id: this.socialNetworkTypeWhatsApp,
                            icon: $this.socialNetworkTypeWhatsAppIcon,
                            text: 'Whataspp',

                        }
                        this.dataInformationSocialNetworkTypes.push(setPush);
                    }
                }
            } else {
                this.$v.$reset();
            }
        },
        getStructureForm: function () {
            var result = {
                value: {
                    id: "value",
                    name: "value",
                    label: "Link",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },

                information_social_network_type_id: {
                    id: "information_social_network_type_id",
                    name: "information_social_network_type_id",
                    label: "Red Social",
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
                "value": null,
                "information_social_network_type_id": null,
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
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm:getValidateForm,
        onClose() {
            this.popoverShow = false

        },
        onShow() {
            // This is called just before the popover is shown
            // Reset our popover form variables
            this.setManagerCurrent({
                data: this.configParams
            });
        },
        onShown() {
            // Called just after the popover has been shown
            // Transfer focus to the first input

        },
        onHidden() {

            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            };
            this.model_id = null;

        },


        initCurrentComponent: function () {


        },
        _deleteSocialNetwork: function (socialNetwork) {
            var dataSend = {
                "InformationSocialNetwork": {
                    id: socialNetwork.id,
                    value: socialNetwork.value,
                    information_social_network_type_id: socialNetwork.information_social_network_type_id,
                    state: 'ACTIVE',
                    main: 1,
                    entity_type: 4,
                    entity_id: this.business_id,
                    "template_information_id": this.model_id,
                    "business_id": this.business_id,

                }
            };
            var vCurrent = this;
            ajaxRequest($("#action-information-social-network-deleteFrontend").val(), {
                type: 'POST',
                data: dataSend,
                blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: vCurrent.formConfig.loadingMessage,
                error_message: vCurrent.formConfig.errorMessage,
                success_message: vCurrent.formConfig.successMessage,
                success_callback: function (response) {

                    if (response.success) {


                        var dataSave = response['data'];
                        vCurrent.configParams = dataSave;
                        vCurrent.$root.$emit("_updateInformationSocialNetwork", {
                            type: 'delete',
                            data: dataSave
                        });
                        vCurrent.popoverShow = false;
                    }
                }
            });

        },
        _editSocialNetwork: function (socialNetwork) {
            this.model.attributes = socialNetwork;
            this.$refs.refPopoverInformationSocialNetwork.$emit('open');
        },
//MANAGER PROCESS
        /*---------GRID--------*/
        _saveModel: function () {
            var dataSendResult = {
                "InformationSocialNetwork": {
                    id: this.model.attributes.id,
                    value: this.model.attributes.value,
                    information_social_network_type_id: this.model.attributes.information_social_network_type_id,
                    state: 'ACTIVE',
                    main: 1,
                    entity_type: 4,
                    entity_id: this.business_id,
                    "template_information_id": this.model_id,
                    "business_id": this.business_id,

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
                            vCurrent.$root.$emit("_updateInformationSocialNetwork", {
                                type: vCurrent.model.attributes.id == null ? 'saveNew' : 'update',
                                data: dataSave
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




