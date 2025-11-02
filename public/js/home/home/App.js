
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
            events: [
                {
                    title  : 'event1',
                    start  : '2010-01-01',
                },
                {
                    title  : 'event2',
                    start  : '2010-01-05',
                    end    : '2010-01-07',
                },
                {
                    title  : 'event3',
                    start  : '2010-01-09T12:30:00',
                    allDay : false,
                },
            ]
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
