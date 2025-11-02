var componentThisManagementFormEventDetails;
Vue.component('management-form-event-details-component', {
    template: '#management-form-event-details-template',
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
        console.log(this.configParams);

    },
    mounted: function () {
        componentThisManagementFormEventDetails = this;
        this.initCurrentComponent();
    },

    data: function () {

        var dataManager = {
            model_id: null,
            /*  ----MANAGER ENTITY---*/
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Pagos",
                "event": "",

                buttons: {
                    return: "Regresar",
                    verify: "Verificar",
                    manager: "Pagar."
                },
                msg: {
                    customers_user: "Si no aparece tu nombre de usuario,Registrate o registra a tus amigos para poder seguir con los pasos de inscripcion."
                }
            },

//form config

            tabCurrentSelector: '#modal-management-form-event-details',
            processName: "Registro Acción.",
            submitStatus: "no",
            showManager: false,
            managerType: null,
            managerCustomers: null,
            optionsTeams: [],
            optionsCategories: [],
            optionsSizes: [],
            optionsColors: [],
            optionsDistances: [],
            optionsManagementDistances: [],
            optionsManagementKits: [],
            modelAux: [],
            modelView: [],
            managementViews: {
                preview: false,
                management: true
            },
            preview: false
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {
            this.initDataModal();
            this.$refs.refManagementFormEventDetailsModal.show();
        },

        /*modal events*/
        _resetComponent: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalManagementFormEventDetails'
            });
        },
        _showModal: function () {


        },
        _hideModal: function () {
            this._resetComponent();

        },
        _saveModal: function (bvModalEvt) {
            var $scope = this;


            bvModalEvt.preventDefault();
        },
        _cancel: function () {
            this.$refs.refManagementFormEventDetailsModal.hide();
            this._resetComponent();

        },
        initDataModal: function () {
            console.log(this.configParams);
            var eventCurrent = this.configParams.data.event;
            var data = this.configParams.data.data;
            var titleOptions = [
                eventCurrent.name,
                '  <span class="data-title">Total Pagos:</span><span class="data-value">' + data.total + '</span>'
            ];
            titleOptions = titleOptions.join('');
            this.labelsConfig.event = titleOptions;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;
                this.initDataModal();
                this.$refs.refManagementFormEventDetailsModal.show();

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

        managementData: function (params) {

        },
//MANAGER PROCESS

//FORM CONFIG

        _submitForm: function (e) {
            console.log(e);
        }
    }
})
;




