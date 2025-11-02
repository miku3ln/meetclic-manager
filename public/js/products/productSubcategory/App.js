var appThis = null;
var appInit = new Vue(
    {
        mounted: function () {
            this.initCurrentComponent();
            appThis = this;
        },
        el: '#app-management',
        created: function () {

        },
        data: {
            configDataProductSubcategory: {
                title: "Registro de ProductSubcategory",
                data: [],

            }
        },
        methods: {
            ...$methodsFormValid,
            initCurrentComponent: function () {

            }, initManagement: function () {
                console.log("init app");
            },
            /*---EVENTS CHILDREN to Parent COMPONENTS----*/
            _updateParentByChildren: function (params) {
                console.log(params);
            },

        }
    })
;
appInit.initManagement();
