var init_map = false;
var map;
var markers_opens = [];
var myLatlng = {lat: 0.2314799, lng: -78.271874};
var zoom = 15;
var markers = [];
var appThis = null;
var currentWulpy = new WulpyMapUtil();
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
            //MENU
            menuCurrent: [],
            configDataBusiness: {
                title: "Registro de Habitaciones",
                data: [],
                titleEvent: "",
                business_id: null
            },

        },
        methods: {
            ...$methodsFormValid,

            /*FORM*/
            _submitForm: function (e) {
                console.log(e);
            },
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
