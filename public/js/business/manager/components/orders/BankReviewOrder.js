var componentThisBankReview;
Vue.component('bank-review-order-component', {
    template: '#bank-review-order-template',
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
        componentThisBankReview = this;
        this.initCurrentComponent();
    },
    data: function () {

        var dataManager = {

            configParams: {},
            labelsConfig: {
                "title": "Revision de Documento de Deposito.",
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
            tabCurrentSelector: '#modal-bank-review-order',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#bank-review-order-form",
                url: $('#action-order-payments-manager-changeStateBankOrder').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar.',
                successMessage: 'Se guardo correctamente.',
                nameModel: "OrderPaymentsManager"
            },
            submitStatus: "no",
            showManager: true,
            managerType: null,
            managerId: null,
            rowCurrent: null,
            manager_state_data: [
                {value: 1, text: 'Por Entregar'},
                {value: 3, text: 'Anulado'},

            ],
            model: {
                attributes: {manager_state: 1}

            }
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {

            this.initDataModal();
            this.$refs.refBankReviewOrderModal.show();
        },

        /*modal events*/
        _showModal: function () {


        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalBankReviewOrder'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refBankReviewOrderModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
            var managerId = rowCurrent.id;
            this.managerId = managerId;
            this.rowCurrent = rowCurrent;
            this.initViewDetailsOrder(rowCurrent);
        },
        initViewDetailsOrder: function (rowCurrent) {

            this.labelsConfig.title = this.labelsConfig.title + ' : ' + rowCurrent.id;
        },
        getItems: function () {
            var resultHtml = getViewOrderManager({rowCurrent: this.rowCurrent});
            var detailsOrder = resultHtml['detailsOrder'];
            return detailsOrder;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refBankReviewOrderModal.show();
            }
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

        _submitForm: function (e) {
            console.log(e);
        },
        getValuesSave: function () {

            var result = {
                    'OrderPaymentsManager': {
                        manager_state: this.model.attributes.manager_state,
                        id: this.managerId
                    }

                }
            ;

            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            ajaxRequest(this.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: vCurrent.formConfig.loadingMessage,
                error_message: vCurrent.formConfig.errorMessage,
                success_message: vCurrent.formConfig.successMessage,
                success_callback: function (response) {

                    if (response.success) {
                        vCurrent._emitToParent({
                            type: 'rebootGrid'
                        });
                        vCurrent._cancel();
                    }
                }
            });


        },

    }
})
;




