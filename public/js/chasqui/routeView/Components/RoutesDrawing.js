Vue.component('routes-drawing-component', {
    template: '#routes-drawing-template',
    mounted: function () {
        console.log("routes");
    },
    beforeMount: function () {
        this.parentData = this.paramsData;
        this.configDataManager(this.parentData);
    },
    data: function () {

        var dataManager = {
                type: "",
                name: "",
                description: "",
                options_type: "",
                slide: 0,
                sliding: null,
                view: false,
                parentData: Object
            }
        ;

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        configDataManager: function (response) {
            this.name = response.data.title == "null" ? "No existe informacion." : response.data.title;
            var htmlData = response.data.content ? response.data.content : "";
            htmlData = replaceAll(htmlData, "&lt;", "<");
            htmlData = replaceAll(htmlData, '&gt;', '>');
            this.description = htmlData;
            this.view = response.view;
        },
        onSlideStart: function (slide) {
            this.sliding = true;
        },
        onSlideEnd: function (slide) {
            this.sliding = false;
        },
        _updateChildrenByParent: function (params) {

            if (params.nameComponent == "App") {

                if (params.nameEvent == "configDataManager") {
                    this.configDataManager(params.data);
                }
            }
        },
    },
    props: {
        paramsData: {
            type: Object,
        },


    }

});
