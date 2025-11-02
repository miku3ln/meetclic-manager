const Validator = SimpleVueValidation.Validator;
//http://simple-vue-validator.magictek.cn/
var scheduleCurrent;
Vue.component('schedules-component', {
        template: '#schedules-template',
        mounted() {
            removeClassNotView();
        },
        created: function () {

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
                configScheduleOfDay: {
                    start_time: {HH: '', mm: '', id: null, model: ""},
                    end_time: {HH: '', mm: '', id: null, model: ""},

                }
                , formAllow: false
            };

            return dataManager;
        },

        methods: {
            ...$methodsFormValid,

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

                        this.configparams.schedules[indexParent]["configTypeSchedule"]["data"][indexChildren][nameElement]["msj"] = msj;
                        this.configparams.schedules[indexParent]["configTypeSchedule"]["data"][indexChildren][nameElement]["error"] = hasError;
                        this.configparams.schedules[indexParent]["configTypeSchedule"]["data"][indexChildren][nameElement]["init"] = false;

                        break;
                }

                return !hasError;
            },
            validateForm: function () {
                var currentAllow = true;
                $scope = this;
                $.each(this.configparams.schedules, function (key, schedule) {
                    if (schedule) {

                        var modelCurrent = schedule["modelDay"];
                        if (modelCurrent) {//open
                            var configTypeScheduleCurrent = schedule["configTypeSchedule"];

                            if (configTypeScheduleCurrent["type"]) {//horarios
                                currentAllow = $scope.allowDataScheduleDay(configTypeScheduleCurrent["data"]);
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
                    start_time: {modelBreakdown: "", error: true, msj: "", init: true, create: true},
                    end_time: {modelBreakdown: "", error: true, msj: "", init: true, create: true},
                };
                this.configparams.schedules[index].configTypeSchedule["data"].push(currentConfig);
            }
            ,
            _typeSchedule: function (type, index) {
                this.configparams.schedules[index].configTypeSchedule["data"] = [];
                this.addDataSchedule(index);
            }
            ,
            _addSchedule: function (index) {
                this.addDataSchedule(index);

            },
            _removeSchedule: function (indexParent, indexChildren) {
                var dataCurrent = this.configparams.schedules[indexParent].configTypeSchedule["data"];

                if (dataCurrent[indexChildren].start_time.hasOwnProperty('create')) {

                    dataCurrent.splice(indexChildren, 2);
                } else {
                    var business_id =$businessManager.id;
                    var dataSend = {
                        id: dataCurrent[indexChildren].start_time.id,
                        business_id: business_id
                    };
                    ajaxRequest($('#action_business_schedule_by_breakdown_delete').val(), {
                        type: 'POST',
                        data: dataSend,
                        blockElement: '.no-touch',//opcional: es para bloquear el elemento
                        loading_message: 'Eliminando...',
                        error_message: 'Error al eliminar el horario ',
                        success_message: 'Se elimino correctamente. ',
                        success_callback: function (response) {
                            if (response.success) {
                                dataCurrent.splice(indexChildren, 2);
                            }
                        }
                    });
                }

            }
            ,
            _daySchedule: function (daySchedule, index) {

                this.configparams.schedules[index]["configTypeSchedule"]["type"] = false;
            },
            _closeModal: function () {
                closeModal();
            },
            _saveSchedules: function () {

                var dataManagerForm = this.configparams.schedules;
                var business_id = $businessManager.id;//this.configparams.business_id;
                var dataSend = {

                    dataSchedules: dataManagerForm,
                    business_id: business_id
                };
                var name_manager = "Horarios.";
                var $scope = this;
                ajaxRequest($('#action_business_by_schedule_save').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: '.content',//opcional: es para bloquear el elemento
                    loading_message: 'Guardando...',
                    error_message: 'Error al guardar el ' + name_manager,
                    success_message: 'El ' + name_manager + ' se guardo correctamente',
                    success_callback: function (response) {
                        if (response.success) {
                            $scope.configparams.schedules = response.data;

                        }
                    }
                });
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
            this.childData = this.parentData; // save props data to itself's data and deal with it
            this.configparams = this.configparams;
            scheduleCurrent = this.configparams;

        }
    }
)
;
