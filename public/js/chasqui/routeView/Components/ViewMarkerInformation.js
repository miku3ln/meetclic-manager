Vue.component('view-marker-information-component', {
    template: '#view-marker-information-template',
    mounted: function () {
        console.log('view-marker-information:', this);
        /*  this.initPanorama();*/
    },

    data: function () {

        var dataManager = {
                dataCurrent: {},
                'parentData': Object
            }
        ;

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        configDataManager: function (response) {
            this.dataCurrent = response;

        }
    },
    props: {

        paramsData: {
            type: Object,
        },


    },
    beforeMount: function () {
        this.parentData = this.paramsData;
        this.configDataManager(this.parentData);
    }
});
