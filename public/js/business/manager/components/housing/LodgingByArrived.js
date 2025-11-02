var componentThisLodgingByArrived;
Vue.component('lodging-by-arrived-component', {

    template: '#lodging-by-arrived-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                console.log(paramsInput);
            },
            bind: function (el, binding, vnode, vm, arg) {


            }
        }
    },
    props: {
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
        componentThisLodgingByArrived = this;
        this.initCurrentComponent();
        removeClassNotView();
    },

    validations: function () {
        var attributes = {
            way_to_contact: {required},
            type_social_networks: {required},
            type_reasons: {required},

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
            lodging_id: null,
            arrived_made: false,
            /*  ----MANAGER ENTITY---*/
            labelsConfig: {
                "title": "Huespedes Pago",
                process: {
                    "payment": "Como se enteraron del Lugar."
                },
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            configParams: {},
            tabCurrentSelector: '#modal-lodging-by-arrived',
            processName: "Obener informacion Huespe.",
            formConfig: {
                nameSelector: "#business-by-lodging-form",
                url: $('#action_lodging_by_arrived_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + this.processName,
                successMessage: 'Se guardo correctamente.',
                nameModel: "LodgingByArrived"
            },
            gridConfig: {
                selectorCurrent: "#lodging-grid",
            },
            typeSocialNetworksOptions: [{
                id: 0, text: "Facebook", value: 0,
            }, {
                id: 1, text: "Instagram", value: 1
            }, {
                id: 2, text: "Twitter", value: 2
            }, {
                id: 3, text: "Youtube", value: 3
            }, {
                id: 4, text: "Spotify", value: 4
            }
            ],
            wayToContactOptions: [
                {id: 0, text: "Redes Sociales", value: 0},
                {id: 1, text: "Comercio", value: 1},
                {id: 2, text: "Recomendaciones-Personas", value: 2},
                {id: 3, text: "Otros", value: 3}

            ],
            hasSocialNetworks: true,
            typeReasonsArrivedData: [
                {
                    id: 4, text: "Sin Especificar", value: 4
                },
                {
                    id: 0, text: "Por Trabajo", value: 0,
                }, {
                    id: 1, text: "Vacaciones", value: 1
                }, {
                    id: 2, text: "Pasar la noche", value: 2
                }, {
                    id: 3, text: "Otros", value: 3
                }
            ],
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refLodgingByArrivedModal.show();
        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            this.labelsConfig.title = "Como llegaron al lugar.! ";
            this.lodging_id = rowCurrent.id;
            var arrived_made = rowCurrent.arrived_made;
            this.arrived_made = false;
            if (arrived_made) {
                this.arrived_made = true;
                var lodgingByArrivedData = rowCurrent["LodgingByArrived"];

                var way_to_contact = lodgingByArrivedData.way_to_contact;
                var type_reasons = rowCurrent["LodgingByReasons"];

                if (way_to_contact == 0) {
                    var lodgingArrivedBySocialNetworksData = lodgingByArrivedData["LodgingArrivedBySocialNetworks"];
                    this.model.attributes.type_social_networks = lodgingArrivedBySocialNetworksData.type_social_networks;
                }
                this.model.attributes.way_to_contact = way_to_contact;
                this.model.attributes.type_reasons = type_reasons.reason;


            }
        },
        //MANAGER PROCESS
        /*  EVENTS*/
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.lodging_id = this.configParams.data.id;
                this.initDataModal();
                this.$refs.refLodgingByArrivedModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },
        /*FORM*/
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
            e.preventDefault();
        },
        getStructureForm: function () {
            var result = {
                //payment
                way_to_contact: {
                    id: "way_to_contact",
                    name: "way_to_contact",
                    label: "Porque medio?.",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                type_social_networks: {
                    id: "type_social_networks",
                    name: "type_social_networks",
                    label: "Redes Sociales",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                }, type_reasons: {
                    id: "type_reasons",
                    name: "type_reasons",
                    label: "Motivo de Visita",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                }
            };

            return result;
        },
        getAttributesForm: function () {
            var result = {
                //payment
                way_to_contact: null,
                type_social_networks: null,
                type_reasons: 4
            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, value, position = null, model = null) {
            /*  way_to_contact: null,
                  type_social_networks: null*/
            var attributeCurrent;
            if (name == "way_to_contact") {
                attributeCurrent = "way_to_contact";
                var allowViewCreditCard = false;
                var valueRow = this.$v.model["attributes"][attributeCurrent].$model;
                if (valueRow == 0) {
                    allowViewCreditCard = true;
                }
                if (!allowViewCreditCard) {
                    attributeCurrent = "type_social_networks";
                    this.$v.model.attributes[attributeCurrent].$model = null;
                    this.model.attributes[attributeCurrent] = null;
                    this.$v["model"]["attributes"][attributeCurrent].$reset();
                }
            }
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
        getErrorHas: function (model, type) {
            var result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            var result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {
            var LodgingByArrived = [];
            var way_to_contactData = this.$v.model.attributes.way_to_contact.$model;
            var type_reasons = this.$v.model.attributes.type_reasons.$model;

            var type_social_networksData = this.$v.model.attributes.type_social_networks.$model;
            var lodging_id = this.lodging_id;

            var way_to_contact = way_to_contactData;
            var setPush = {
                way_to_contact: way_to_contact,
                lodging_id: lodging_id,
                type_reasons: type_reasons
            };
            var valueRow = way_to_contact;
            if (valueRow == 0) {//credit card
                var LodgingArrivedBySocialNetworks = [];
                var type_social_networks = type_social_networksData;
                var setPushCC = {
                    type_social_networks: type_social_networks,
                    lodging_id: lodging_id
                };
                LodgingArrivedBySocialNetworks.push(setPushCC);
                setPush = {
                    way_to_contact: way_to_contact,
                    lodging_id: lodging_id,
                    type_reasons: type_reasons,
                    LodgingArrivedBySocialNetworks: LodgingArrivedBySocialNetworks
                };
            }
            LodgingByArrived.push(setPush);


            var result = {LodgingByArrived: LodgingByArrived, lodging_id: lodging_id};

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
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
                            vCurrent.resetForm();
                            vCurrent._emitToParent({type: "rebootGrid"});
                            vCurrent._cancel();
                        }
                    }
                });
            }
        },
        resetForm: function () {


            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };

            this.$v.model.attributes.$reset();
            this.$v.$reset();

        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getValidateForm: function () {
            var success = true;
            var attributeCurrent = "";
            var $invalidArrived = false;
            var $invalidSocialNetworks = false;
            var errors = [];

            var allowViewCreditCard = false;
            attributeCurrent = "way_to_contact";
            $invalidArrived = this.$v.model["attributes"][attributeCurrent]["$invalid"];
            var valueRow = this.$v.model["attributes"][attributeCurrent].$model;
            if (valueRow == 0) {
                allowViewCreditCard = true;
            }

            if (allowViewCreditCard) {
                attributeCurrent = "type_social_networks";
                $invalidSocialNetworks = this.$v.model["attributes"][attributeCurrent]["$invalid"];
            }
            if (

                $invalidArrived ||
                $invalidSocialNetworks

            ) {

                if ($invalidArrived) {
                    errors.push({
                        "type": "payment", "fields": ["way_to_contact"]
                    });
                }
                if ($invalidSocialNetworks) {
                    errors.push({
                        "type": "invalidSocialNetworks", "fields": ["type_social_networks"]
                    });
                }
                success = false;

            }
            var result = {
                success: success,
                errors: errors
            };
            return result;
        },
        /*---Social Networks---*/
        getViewTypeSocialNetworks: function (hasSocialNetworks, modelCurrent) {
            var result = false;
            if (hasSocialNetworks) {
                if (modelCurrent.$model != null) {
                    var valueRow = modelCurrent.$model;
                    if (valueRow == 0) {
                        result = true;
                    }


                }
            }
            return result;
        },
        /*modal*/
        _showModal: function () {
            if (!this.arrived_made) {

                this.resetForm();
            }
        },
        _hideModal: function () {

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refLodgingByArrivedModal.hide();

        }


    }
})
;

