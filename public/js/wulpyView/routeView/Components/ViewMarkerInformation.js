Vue.component('view-marker-information-component', {
    template: '#view-marker-information-template',
    mounted: function () {
        console.log('view-marker-information:', this);
        /*  this.initPanorama();*/
    },

    data: function () {

        var dataManager = {
                dataCurrent: {}

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
        parentData: {
            type: String,
            default: function () {
                return '';
            }
        },
        title: {
            type: String
        },
        messageParent: {
            type: String
        },
        params: {
            type: Object,
        },
        titleEvent: {
            type: String
        }

    },
    beforeMount: function () {

        this.parentData = this.params;
        this.configDataManager(this.parentData);
    }
});
