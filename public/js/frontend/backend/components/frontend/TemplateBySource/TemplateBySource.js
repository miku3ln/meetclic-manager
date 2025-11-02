var componentThisTemplateBySource;
Vue.component('template-by-source-component', {
    template: '#template-by-source-template'
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.model_id = this.configParams.model_id;
        this.business_id = $modelDataManager.business_id;
        this.getInitDataManager();

    },
    mounted: function () {
        componentThisTemplateBySource = this;
        this.initCurrentComponent();
        removeClassNotView();
    },

    data: function () {

        var dataManager = {
            model_id: null,
            configParams: {},
            showManager: false,
            managerType: null,
            initManager: false,
            sourcesConfig: {data:null,filters:null},
            model_id:null
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        initCurrentComponent: function () {

        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        getInitDataManager: function () {

            var dataSend = {
                filters: {
                    business_id: this.business_id,
                    template_information_id: this.model_id,
                }
            };
            var urlCurrent = $('#action-template-by-source-getSourcesTypesData').val();
            $this = this;
            ajaxRequest(urlCurrent, {
                type: 'POST',
                data: dataSend,
                blockElement: ('#tab-template-by-source'),//opcional: es para bloquear el elemento
                loading_message: '',
                error_message: 'Error al obtener Informacion.',
                success_message: '',
                success_callback: function (response) {
                    $this.setValuesManager(response);
                    $this.initManager = true;
                }
            });
        },
        setValuesManager: function (response) {

            this.sourcesConfig['data'] = response;
            this.sourcesConfig['filters'] = {
                business_id: this.business_id,
                model_id: this.model_id,
            };

        }
    }
})
;




