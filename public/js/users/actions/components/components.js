const Validator = SimpleVueValidation.Validator;
var required = Validators.required;
var minLength = Validators.minLength;
var minValue = Validators.minValue;
var between = Validators.between;
var email = Validators.email;
/*https://flaviocopes.com/vue-components-communication/*/
// define the tree-item component
Vue.use(SimpleVueValidation);//https://bootstrap-vue.js.org/docs/reference/validation/
Vue.use(Vuelidate);//https://jsfiddle.net/sg2zd9mf/
Vue.use(Vuelidate.default);//https://vuelidate.netlify.com/#sub-without-v-model
Vue.component("v-select", VueSelect.VueSelect);
Vue.component('date-picker', VueBootstrapDatetimePicker);
Vue.use(VueTimepicker);//https://uiv.wxsm.space/getting-started

Vue.component('btn-create-component', {
    data: function () {
        return {
            count: 0
        }
    },
    template: getBtnCreate(),
    methods: {
        ...$methodsFormValid,

        newRegister() {
            newRegister();
        }
    }
});
Vue.component('modal', {
    template: '#modal-template',
    mounted() {

    },
});


var scheduleCurrent;
Vue.component('schedules-component', {
        template: '#schedules-template',
        mounted() {
            console.log('The props are also available in JS:', this);
        },
        created: function () {
            // `this` points to the vm instance
            console.log('a created: ' + this.perrin);

        }, update: function () {
            // `this` points to the vm instance
            console.log('a update: ' + this.perrin)
        },
        filters: {
            pretty: function (value) {
                var result = "";
                if (value) {
                    result = JSON.stringify(JSON.parse(value), null, 2);
                }
                return result;
            }
        },
        data: function () {
            var schedule = [];
            var dataManager = {
                perrin: "hoLA mundo VUE",
                optionsSchedule: [
                    {countryCode: "AU", countryName: "Australia"},
                    {countryCode: "CA", countryName: "Canada"},
                    {countryCode: "CN", countryName: "China"},
                    {countryCode: "DE", countryName: "Germany"},
                    {countryCode: "JP", countryName: "Japan"},
                    {countryCode: "MX", countryName: "Mexico"},
                    {countryCode: "CH", countryName: "Switzerland"},
                    {countryCode: "US", countryName: "United States"}
                ],
                configScheduleOfDay: {
                    start_time: {HH: '', mm: '', id: null, model: ""},
                    end_time: {HH: '', mm: '', id: null, model: ""},

                },
                name: '',
                gender: '',
                phone: '',
                age: '',
                form: {
                    name: ""
                }
                , formAllow: false,
                question: '',
                answer: 'I cannot give you an answer until you ask a question!'
            };

            return dataManager;
        },

        methods: {
            onListenElementsForm: onListenElementsForm,

            validationElement: function (type, value, indexParent, indexChildren, nameElement) {
                var msj = "";
                var hasError = false;

                switch (type) {
                    case 'schedule':

                        var validationResult = Validator.value(value.modelBreakdown).required();
                        msj = "";
                        if (Object.keys(validationResult["_messages"]).length) {
                            var msjCurrent = validationResult["_messages"];
                            msj = msjCurrent[0];
                            hasError = true;
                        } else {
                            hasError = false;
                        }
                        if (value.init) {
                            hasError = false;
                        }

                        this.configparams.schedule[indexParent]["configTypeSchedule"]["data"][indexChildren][nameElement]["msj"] = msj;
                        this.configparams.schedule[indexParent]["configTypeSchedule"]["data"][indexChildren][nameElement]["error"] = hasError;
                        this.configparams.schedule[indexParent]["configTypeSchedule"]["data"][indexChildren][nameElement]["init"] = false;

                        break;
                }

                return !hasError;
            },
            validateForm: function () {
                var currentAllow = true;
                _this = this;
                $.each(this.configparams.schedule, function (key, schedule) {
                    if (schedule) {

                        var modelCurrent = schedule["modelDay"];
                        if (modelCurrent) {//open
                            var configTypeScheduleCurrent = schedule["configTypeSchedule"];

                            if (configTypeScheduleCurrent["type"]) {//horarios
                                currentAllow = _this.allowDataScheduleDay(configTypeScheduleCurrent["data"]);
                            } else {//24 hours

                            }
                        } else {//close

                        }
                    }
                });

                this.formAllow = currentAllow;

                return currentAllow;
            },
            allowDataScheduleDay: function (haystack) {
                var hasError = false;
                var nextLoop = true;
                $.each(haystack, function (keyScheduleDay, scheduleDay) {
                    if (scheduleDay) {

                        if (scheduleDay["end_time"]["error"] && nextLoop || (scheduleDay["start_time"]["error"] && nextLoop)) {//no tiene
                            nextLoop = false;
                            hasError = true;
                        }
                    }
                });
                return !hasError;
            },
            submit: function () {
                this.$validate()
                    .then(function (success) {
                        if (success) {
                            alert('Validation succeeded!')
                        }
                    });
            }, reset: function () {

                this.name = '';
                this.gender = '';
                this.phone = '';
                this.age = '';
                this.validation.reset();
            },
            getKeyPicker: function (indexParent, indexChildren, type) {
                return (indexParent + "_" + indexChildren + "_" + type);
            }
            ,
            addDataSchedule: function (index) {
                var currentConfig = {
                    start_time: {modelBreakdown: "", error: true, msj: "", init: true},
                    end_time: {modelBreakdown: "", error: true, msj: "", init: true},
                };
                this.configparams.schedule[index].configTypeSchedule["data"].push(currentConfig);
            }
            ,
            _typeSchedule: function (type, index) {
                this.configparams.schedule[index].configTypeSchedule["data"] = [];
                this.addDataSchedule(index);
            }
            ,
            _addSchedule: function (index) {
                this.addDataSchedule(index);

            },
            _removeSchedule: function (indexParent, indexChildren) {
                this.configparams.schedule[indexParent].configTypeSchedule["data"].splice(indexChildren, 2);

            }
            ,
            _daySchedule: function (daySchedule, index) {

                this.configparams.schedule[index]["configTypeSchedule"]["type"] = false;
            },
            _closeModal: function () {
                closeModal();
            },
            _saveSchedules: function () {
//todo structure schedule
                form_manager = $("#business-by-schedule-form");
                var dataManagerForm = this.configparams.schedule;
                var business_id = $wulpymeData["business"][0]["id"];
                var dataSend = {

                    dataSchedules: dataManagerForm,
                    business_id: business_id
                };
                var name_manager = "Horarios.";
                var _this = this;
                ajaxRequest($('#action_business_by_schedule_save').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: '#tab-schedule',//opcional: es para bloquear el elemento
                    loading_message: 'Guardando...',
                    error_message: 'Error al guardar el ' + name_manager,
                    success_message: 'El ' + name_manager + ' se guardo correctamente',
                    success_callback: function (response) {
                        console.log("listo");
                        if (response.success) {

                            _this.configparams.schedule = response.data;

                        }
                    }
                });
            }
        },
        validators: {
            "form.name": function (value) {
                return Validator.value(value).required().regex('^[A-Za-z]*$', 'Must only contain alphabetic characters.');
            },
            gender: function (value) {
                return Validator.value(value).required();
            },
            phone: function (value) {
                return Validator.value(value).digit().length(10);
            },
            age: function (value) {
                return Validator.value(value).integer().greaterThan(12);
            }
        },
        props: {
            parentData: {
                type: String,
                default
                    () {
                    return ''
                }
            }
            ,
            title: {
                type: String
            }
            ,
            messageParent: {
                type: String
            }
            ,
            configparams: {
                type: Object,
            }
        }
        ,
        beforeMount() {
            this.childData = this.parentData // save props data to itself's data and deal with it
            this.configparams = this.configparams;
            this.alex = this.configparams["alex"];
            scheduleCurrent = this.configparams;
        }
    }
)
;
var dataTableProducts;
Vue.component('products-component', {
    template: '#products-template',
    mounted() {
        console.log('The props are also available in JS:', this);
        this.initGridManager();
    },

    data: function () {

        var dataManager = {
            message: 'hello!',
            formAllow: false,
            paramsGrid: {},
            gridProductsObj: null
        };

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        /*---------GRID--------*/
        initGridManager: function () {
            var gridName = "products-grid";
            var urlCurrent = $("#action_products_admin").val();
            gridId = $("#" + gridName);
            gridId.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                ajax: true,
                post: function () {
                    return {
                        grid_id: gridName,
                        filters: {}
                    };
                },
                url: urlCurrent,
                labels: {
                    loading: "Cargando...",
                    noResults: "Sin Resultados!",
                    infos: "Mostrando {{ctx.start}} - {{ctx.end}} de {{ctx.total}} resultados"
                },
                css: getCSSCurrentBootGrid(),
                formatters: {
                    'commands': function (column, row) {
                        return ' <a href="#" class="btn btn-danger btn-xs command-delete meet-btn-grid-delete a-meet-delete" data-toggle="tooltip" data-placement="top" title="Eliminar" data-row-id="' + row.id + '"><i class="fa fa-times"></i></a>';
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function () {

                gridId.find(".command-view").on("click", function (e) {

                }).end().find(".command-edit").on("click", function (e) {

                }).end().find(".command-delete").on("click", function (e) {
                    alert("ss");
                });
            });
        },
        validationElement: function (type, value, indexParent, indexChildren, nameElement) {
            var msj = "";
            var hasError = false;

            switch (type) {
                case 'schedule':

                    var validationResult = Validator.value(value.model).required();
                    msj = "";
                    if (Object.keys(validationResult["_messages"]).length) {
                        var msjCurrent = validationResult["_messages"];
                        msj = msjCurrent[0];
                        hasError = true;
                    } else {
                        hasError = false;
                    }
                    if (value.init) {
                        hasError = false;
                    }

                    break;
            }

            return !hasError;
        },
        validateForm: function () {
            var currentAllow = true;
            _this = this;
            $.each(this.configparams.schedule, function (key, schedule) {
                if (schedule) {

                    var modelCurrent = schedule["model"];
                    if (modelCurrent) {//open
                        var configTypeScheduleCurrent = schedule["configTypeSchedule"];

                        if (configTypeScheduleCurrent["type"]) {//horarios
                            currentAllow = _this.allowDataScheduleDay(configTypeScheduleCurrent["data"]);
                        } else {//24 hours

                        }
                    } else {//close

                    }
                }
            });

            this.formAllow = currentAllow;

            return currentAllow;
        },
        submit: function () {
            this.$validate()
                .then(function (success) {
                    if (success) {
                        alert('Validation succeeded!')
                    }
                });
        }, reset: function () {

            this.validation.reset();
        },
        _closeModal: function () {
            closeModal();
        }
    },
    validators: {
        "form.name": function (value) {
            return Validator.value(value).required().regex('^[A-Za-z]*$', 'Must only contain alphabetic characters.');
        },
        gender: function (value) {
            return Validator.value(value).required();
        },
        phone: function (value) {
            return Validator.value(value).digit().length(10);
        },
        age: function (value) {
            return Validator.value(value).integer().greaterThan(12);
        }
    },
    props: {
        parentData: {
            type: String,
            default
                () {
                return ''
            }
        }
        ,
        title: {
            type: String
        }
        ,
        messageParent: {
            type: String
        }
        ,
        configparams: {
            type: Object,
        }

    }
    ,
    beforeMount() {
        this.configparams = this.configparams;
        _this = this;
        var paramsFilters = {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
            user_id: _this.configparams.user.id,
        };
        var url = $("#action_load_products").val();
        var paramsConfigTable = {
            ajax: {
                url: url,
                method: 'GET'
            },
            pageSize: 10,
            columns: [
                {
                    field: "name",
                    title: "Nombre",
                    sortable: 'asc',
                    filterable: false,
                    width: 150
                },
                {
                    field: "status",
                    title: "Estado",
                    template: function (t) {
                        var e = {
                            'ACTIVE': {title: "Activo", class: "m-badge--primary"},
                            'INACTIVE': {title: "Inactivo", class: " m-badge--metal"},
                        };
                        return '<span class="m-badge ' + e[t.status].class + ' m-badge--wide">' + e[t.status].title + "</span>"
                    }
                },
                {
                    field: "",
                    width: 110,
                    title: "Acciones",
                    sortable: false,
                    overflow: "visible",
                    template: function (t) {
                        return '<a href="javascript:;" onclick="editProduct(' + t.id + ')" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Editar"><i class="la la-edit"></i></a>';
                    }
                }
            ]
        };
        this.paramsGrid = {
            columns: {},
            paramsConfigTable: paramsConfigTable
        }

    }
});

function getBtnCreate() {
    let result = '<li class="m-portlet__nav-item"><a  @click="newRegister()"href="#"  class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">';
    result += '<span>'
    result += '<i class="la la-plus"></i>'
    result += 'Crear'
    result += '</span>'
    result += '</a></li>';
    return result;
}


Vue.component("switch-button", {
    template: "#switch-button",
    model: {
        prop: "isEnabled",
        event: "toggle"
    },
    props: {
        isEnabled: Boolean,
        color: {
            type: String,
            required: false,
            default: "#4D4D4D"
        }
    },
    methods: {
        ...$methodsFormValid,

        toggle: function () {
            this.$emit("toggle", !this.isEnabled);
        }
    }
});
