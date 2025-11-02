Vue.component('adventure-type-component', {
    template: '#adventure-type-template',
    mounted: function () {
        console.log('content-adventure-type:', this);

    },

    data: function () {

        var dataManager = {
                dataAdventureType: [],
                allowView: false,
                parentData: Object,
            }
        ;

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        onListenElementsForm:onListenElementsForm,
        configDataManager: function (params) {

            var $dataCurrent = params.data;
            $.each($dataCurrent, function (key, value) {
                var adventureType = getAdventureTypeById(value["adventure_type"]);
                $dataCurrent[key]["src"] = adventureType["src"];

            });
            $dataCurrent = getRowsColsStructure({haystack: $dataCurrent, columnsDiv: 5});
            this.data = $dataCurrent;
            this.title = params.title;
            this.allowView = getObjectLength($dataCurrent) ? true : false;


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
