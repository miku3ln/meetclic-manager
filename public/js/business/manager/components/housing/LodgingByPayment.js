var componentThisLodgingByPayment;
Vue.component('lodging-by-payment-component', {

    template: '#lodging-by-payment-template',
    directives: {},
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
        componentThisLodgingByPayment = this;
        this.initCurrentComponent();
        removeClassNotView();
    },

    validations: function () {
        var attributes = {
            way_to_pay: {required},
            type_credit_card: {required}
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
            payment_made: false,
            /*  ----MANAGER ENTITY---*/
            labelsConfig: {
                "title": "Huespedes Pago",
                process: {
                    "payment": "Pagos"
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
            tabCurrentSelector: '#modal-lodging-by-payment',
            processName: "Cobro Huespe.",
            formConfig: {
                nameSelector: "#business-by-lodging-form",
                url: $('#action_lodging_by_payment_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + this.processName,
                successMessage: 'Se guardo correctamente.',
                nameModel: "LodgingByPayment"
            },
            gridConfig: {
                selectorCurrent: "#lodging-grid",
            },
            typeCreditCardOptions: [{
                id: 0, text: "Diners", value: 0,
            }, {
                id: 1, text: "Visa", value: 1
            }, {
                id: 2, text: "Mastercard", value: 2
            }, {
                id: 3, text: "Otras", value: 3
            }],
            wayToPayOptions: [
                {id: 0, text: "Efectivo", value: 0},
                {id: 1, text: "Tarjeta de Credito", value: 1},
                {id: 2, text: "Cheque", value: 2}
            ],
            hasPayment: true
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refLodgingByPaymentModal.show();
        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            var totalLodgingSpan = '<span class="badge badge--size-large  badge-primary">' + (rowCurrent.total_value) + '</span>';
            this.labelsConfig.title = "Pago Total Hospedaje: " + totalLodgingSpan;
            this.lodging_id = rowCurrent.id;
            var payment_made = rowCurrent.payment_made;
            this.payment_made = false;
            if (payment_made) {
                this.payment_made = true;

                var lodgingByPaymentData = rowCurrent["LodgingByPayment"];
                var way_to_payData = [];
                var type_credit_cardData = [];
                $.each(lodgingByPaymentData, function (indexRow, valueRow) {
                    var way_to_pay = valueRow.way_to_pay;
                    way_to_payData.push(way_to_pay);
                    if (way_to_pay == 1) {
                        var lodgingByPaymentCreditCardData = valueRow["LodgingByPaymentCreditCard"];
                        $.each(lodgingByPaymentCreditCardData, function (indexRowLBPCCD, valueRowLBPCCD) {
                            var type_credit_card = valueRowLBPCCD.type_credit_card;
                            type_credit_cardData.push(type_credit_card);
                        });
                    }
                });
                this.model.attributes.way_to_pay = way_to_payData;
                if (Object.keys(type_credit_cardData).length > 0) {
                    this.model.attributes.type_credit_card = type_credit_cardData;
                }
            }
        },
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
        /*  EVENTS*/
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.lodging_id = this.configParams.data.id;
                this.initDataModal();
                this.$refs.refLodgingByPaymentModal.show();

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
                way_to_pay: {
                    id: "way_to_pay",
                    name: "way_to_pay",
                    label: "Forma de Pago",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                type_credit_card: {
                    id: "type_credit_card",
                    name: "type_credit_card",
                    label: "Tarjetas de Credito",
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
                way_to_pay: [],
                type_credit_card: [],
            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        setValueForm: function (name, value, position = null, model = null) {
            /*  way_to_pay: null,
                  type_credit_card: null*/
            var attributeCurrent;
            if (name == "payment_made") {
                if (value) {// not-has
                    attributeCurrent = "way_to_pay";
                    this.$v.model.attributes[attributeCurrent].$model = null;
                    this.model.attributes[attributeCurrent] = null;
                    this.$v["model"]["attributes"][attributeCurrent].$reset();
                    attributeCurrent = "type_credit_card";
                    this.$v.model.attributes[attributeCurrent].$model = null;
                    this.model.attributes[attributeCurrent] = null;
                    this.$v["model"]["attributes"][attributeCurrent].$reset();
                }
            } else if (name == "way_to_pay") {
                attributeCurrent = "way_to_pay";
                var allowViewCreditCard = false;
                $.each(this.$v.model["attributes"][attributeCurrent].$model, function (indexRow, valueRow) {
                    if (valueRow == 1) {
                        allowViewCreditCard = true;
                    }

                });
                if (!allowViewCreditCard) {
                    attributeCurrent = "type_credit_card";
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
            var LodgingByPayment = [];
            var way_to_payData = this.$v.model.attributes.way_to_pay.$model;
            var type_credit_cardData = this.$v.model.attributes.type_credit_card.$model;
            var lodging_id = this.lodging_id;
            $.each(way_to_payData, function (indexRow, valueRow) {
                var way_to_pay = valueRow;
                var setPush = {
                    way_to_pay: way_to_pay,
                    lodging_id: lodging_id
                };
                if (valueRow == 1) {//credit card
                    var LodgingByPaymentCreditCard = [];
                    $.each(type_credit_cardData, function (indexRowCC, valueRowCC) {
                        var type_credit_card = valueRowCC;
                        var setPushCC = {
                            type_credit_card: type_credit_card,
                            lodging_id: lodging_id
                        };
                        LodgingByPaymentCreditCard.push(setPushCC);
                    });
                    setPush = {
                        way_to_pay: way_to_pay,
                        lodging_id: lodging_id,
                        LodgingByPaymentCreditCard: LodgingByPaymentCreditCard
                    };
                }
                LodgingByPayment.push(setPush);
            });


            var result = {LodgingByPayment: LodgingByPayment, lodging_id: lodging_id};

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
            var $invalidWayToPay = false;
            var $invalidTypeCreditCard = false;
            var errors = [];

            var allowViewCreditCard = false;
            attributeCurrent = "way_to_pay";
            $invalidWayToPay = this.$v.model["attributes"][attributeCurrent]["$invalid"];
            $.each(this.$v.model["attributes"][attributeCurrent].$model, function (indexRow, valueRow) {
                if (valueRow == 1) {
                    allowViewCreditCard = true;
                }
            });
            if (allowViewCreditCard) {
                attributeCurrent = "type_credit_card";
                $invalidTypeCreditCard = this.$v.model["attributes"][attributeCurrent]["$invalid"];
            }
            if (

                $invalidWayToPay ||
                $invalidTypeCreditCard

            ) {

                if ($invalidWayToPay) {
                    errors.push({
                        "type": "payment", "fields": ["way_to_pay"]
                    });
                }
                if ($invalidTypeCreditCard) {
                    errors.push({
                        "type": "paymentCreditCard", "fields": ["type_credit_card"]
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
        /*---PAYMENT---*/
        getViewTypeCreditCard: function (hasPayment, modelCurrent) {
            var result = false;
            if (hasPayment) {
                if (modelCurrent.$model) {
                    $.each(modelCurrent.$model, function (indexRow, valueRow) {
                        if (valueRow == 1) {
                            result = true;
                        }

                    });
                }
            }
            return result;
        },
        /*modal*/
        _showModal: function () {
            if (!this.payment_made) {

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
            this.$refs.refLodgingByPaymentModal.hide();

        }


    }
})
;

