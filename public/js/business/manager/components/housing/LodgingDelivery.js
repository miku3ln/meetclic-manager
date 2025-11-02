var componentLodging;
Vue.component('lodging-delivery-component', {

    template: '#lodging-delivery-template',
    directives: {},
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {

        this.configParams = this.params;
        console.log('created');

    },
    beforeMount: function () {

        this.initCurrentComponent();
        console.log('beforeMount');
    },
    mounted: function () {
        componentLodging = this;
        this.$refs.refLodgingDeliveryModal.show();
        console.log('mounted');

    },

    validations: function () {
        var attributes = {
            lodging_type_of_room_by_price_id: {required}
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
            /*  ----MANAGER ENTITY---*/
            labelsConfig: {
                "title": "Huespedes Pago",
                buttons: {
                    save: "Entregar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            configParams: {},
            tabCurrentSelector: '#modal-lodging-delivery',
            processName: "Los cuartos  utilizados.",
            formConfig: {
                nameSelector: "#business-by-lodging-form",
                url: $('#action_lodging_delivery_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Los cuartos  utilizados.',
                successMessage: 'Se guardo correctamente.',
                nameModel: "Lodging"
            },
            gridConfig: {
                selectorCurrent: "#lodging-grid",
            },
            lodgingTypeOfRoomByPriceIdOptions: [],
            createUpdate: true,
            addRooms: false
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.initDataModal();

        },
        initDataModal: function () {
            var _this = this;
            var rowCurrent = this.configParams.data;
            this.resetForm();
            this.lodging_id = rowCurrent.id;
            this.createUpdate = rowCurrent.status_delivery ? false : true;
            var dataOptions = [];
            if (!this.createUpdate) {

                this.labelsConfig.title = "Alojamiento Finalizado! ";


            } else {
                this.model.attributes.lodging_type_of_room_by_price_id = null;
                this.labelsConfig.title = "Alojamiento por finalizar! ";
            }

            var LodgingByTypeOfRoomData = rowCurrent.LodgingByTypeOfRoom;
            var lodging_type_of_room_by_price_id = [];
            this.addRooms = LodgingByTypeOfRoomData.length == 0 ? false : true;
            $.each(LodgingByTypeOfRoomData, function (index, value) {
                var setPush = value["lodging_type_of_room_by_price_id"];
                lodging_type_of_room_by_price_id.push(setPush);
                var setPushOption = {
                    id: value["lodging_type_of_room_by_price_id"],
                    text: value["name"] + " #" + value["room_number"],
                    value: value["lodging_type_of_room_by_price_id"]
                };
                dataOptions.push(setPushOption);
            });
            this.lodgingTypeOfRoomByPriceIdOptions = dataOptions;
            this.model.attributes.lodging_type_of_room_by_price_id = lodging_type_of_room_by_price_id;

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
                this.$refs.refLodgingDeliveryModal.show();

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
                lodging_type_of_room_by_price_id: {
                    id: "lodging_type_of_room_by_price_id",
                    name: "lodging_type_of_room_by_price_id",
                    label: "Habitaciones",
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
                lodging_type_of_room_by_price_id: []
            };

            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, modelCurrent, valueCurrent) {

            modelCurrent.$touch();

        },
        allowPushLodgingTypeOfRoomByPrice: function (params) {
            var haystack = params.haystack;
            var needle = params.needle;
            haystack.filter(function (value) {
                return value.lodging_type_of_room_by_price_id == needle;
            });

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
            var LodgingByTypeOfRoom = [];
            var lodgingTypeOfRoomByPriceData = this.model.attributes.lodging_type_of_room_by_price_id;
            $.each(lodgingTypeOfRoomByPriceData, function (index, value) {
                var setPush = {
                    lodging_type_of_room_by_price_id: value,
                    lodging_id: lodging_id

                };
                LodgingByTypeOfRoom.push(setPush);
            });
            var lodging_id = this.lodging_id;
            var result = {LodgingByTypeOfRoom: LodgingByTypeOfRoom, lodging_id: lodging_id};

            return result;
        },
        deleteOptionsModel: function () {

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

            if (this.createUpdate) {

                this.model = {
                    attributes: this.getAttributesForm(),
                    structure: this.getStructureForm()
                };

                this.$v.model.attributes.$reset();
            }


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
            var attributeCurrent = "lodging_type_of_room_by_price_id";
            var errors = [];
            var $invalidRoom = this.$v.model["attributes"][attributeCurrent]["$invalid"];
            if (

                $invalidRoom

            ) {

                if ($invalidRoom) {
                    errors.push({
                        "type": "lodging_type_of_room_by_price_id", "fields": ["lodging_type_of_room_by_price_id"]
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
        /*modal*/
        _showModal: function () {
            if (this.$v.model.attributes.$dirty) {



            }

        },
        _hideModal: function () {

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
        },
        _cancel: function () {
            this.$refs.refLodgingDeliveryModal.hide();
        }


    }
})
;

