Vue.component('view-information-component', {
    template: '#view-information-template',
    mounted: function () {

    },

    data: function () {

        var dataManager = {

                title: "sada",
                description: "adad",
                configDataAdventureType: [],
                parentData: Object
            }
        ;

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        configDataManager: function (data) {
            this.title = data.title == "null" ? "No existe informacion." : data.title;
            var htmlData = data.description ? data.description : "";
            htmlData = replaceAll(htmlData, "&lt;", "<");
            htmlData = replaceAll(htmlData, '&gt;', '>');
            this.description = htmlData;

        }
    },
    props: {
        paramsData: {
            type: Object,
        },


    },
    beforeMount: function () {


        this.parentData = this.paramsData;
        this.configDataAdventureType = this.parentData.configDataAdventureType;
        this.configDataManager(this.parentData);
    }
});
