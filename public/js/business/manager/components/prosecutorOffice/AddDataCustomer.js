var componentConfigAddDataCustomer;
Vue.component('add-data-customer-component', {
    template: '#add-data-customer-template',
    components: {
        DateTimePicker: DateTimePicker
    },
    directives: {

        ...$directivesCustomer
    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {

        console.log(this.params);
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id = $businessManager.id;
    },
    mounted: function () {
        componentConfigAddDataCustomer = this;
        //$configManagerProcessCurrent = $configPartial.resultProcess.data;
        this.initCurrentComponent();

    },
    validations: validationsCustomer,
    data: function () {

        var dataManager = {
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                refModalName: 'refAddDataCustomerModal'
            },
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
            model: {//CUSTOMER-CREATE
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            formConfig: {//CUSTOMER-CREATE
                nameSelector: "#customer-form",
                url: $('#action-customer-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Cliente.',
                successMessage: 'El cliente se guardo correctamente.',
                nameModel: "Customer"
            },
            dataManagerSave: {
                data: null,
                isSave: false
            },
            business_id: null,
            ...$dataManagerFieldsCustomer,//CUSTOMER-CREATE
        };
        console.log(dataManager);

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        ...$methodsManagerProcess,

        /*FORM CUSTOMER-CREATE*/
        getViewErrorForm: function (objValidate) {
            var result = false
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }

            return result;
        },
        _submitForm: function (e) {// CUSTOMER-CREATE
            console.log(e);
        },
        ...$methodsCustomer,//CUSTOMER-CREATE
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            var blockElement = '#modal-add-data-customer';
            vCurrent.dataManagerSave.isSave = false;
            if (!validateCurrent) {
                vCurrent.submitStatus = 'error';

            } else {
                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: blockElement,//opcional: es para bloquear el elemento
                    loading_message: vCurrent.formConfig.loadingMessage,
                    error_message: vCurrent.formConfig.errorMessage,
                    success_message: vCurrent.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            console.log(response.data['CustomerManager']);
                            vCurrent.dataManagerSave.data = response.data;
                            vCurrent.dataManagerSave.isSave = true;

                            vCurrent._emitToParent({
                                type: '_saveModel',
                                'componentName': 'configModalAddDataCustomer',
                                'data': vCurrent.dataManagerSave
                            });
                        }
                    }
                });
            }
        },// CUSTOMER-CREATE
        _resetModel: function (model) {// CUSTOMER-CREATE
            model.$reset();

        },
        ...$managerGoogleMaps,// CUSTOMER-CREATE

        initCurrentComponent: function () {

            this.initDataModal();
            //this.$refs[this.configModelEntity.refModalName].show();
            this.$refs.refAddDataCustomerModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalAddDataCustomer'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refMailingByDataSendModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            var managerId = rowCurrent.id;
            this.managerId = managerId;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs[this.configModelEntity.refModalName].show();
            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },


    }
})
;




