Vue.component('legend-information-component', {
    template: '#legend-information-template',
    mounted: function () {
        console.log('content-legend-information:', this);

    },

    data: function () {

        var dataManager = {
                dataLegend: [],
                title: "Nothing",
                'parentData': Object,
            }
        ;

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        configDataManager: function (data) {
            this.dataLegend = data.dataLegend;
            this.title = data.title;
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
