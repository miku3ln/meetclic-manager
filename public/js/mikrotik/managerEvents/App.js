function getValidateForm(params) {
    var success = true;
    var errors = [];
    var notValidate = [
        '$model', "$invalid", '$dirty', '$anyDirty', '$error', "$anyError", '$pending', '$params'

    ];
    var modelAttributes = {};
    if (typeof (params) != 'undefined') {

        if (params.hasOwnProperty('model')) {
            modelAttributes = params.model.attributes;
        }

    } else {
        if (typeof (this.$v.model.attributes) == 'object') {
            modelAttributes = this.$v.model.attributes;
        }
    }

    $.each(modelAttributes, function (key, value) {
        var allowValidate = $.inArray(key, notValidate) == 0 ? false : true;
        if (allowValidate) {
            if (value.$invalid) {

                errors.push(
                    {
                        'field': value,
                        'name': key
                    }
                );
                success = false;
            }
        }
    });

    var result = {
        success: success,
        errors: errors
    };
    return result;
}

var $typeEventData = [];
var $mikrotikData = [];
var $mikrotikData = $managerViewData['mikrotikData'];
$typeEventData = $mikrotikData['typeEventData'];
$mikrotikData = $mikrotikData['mikrotikData'];
var componentThisMikrotikManagerEvents;
Vue.component('mikrotik-manager-events-component', {
    template: '#mikrotik-manager-events-template',
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisMikrotikManagerEvents = this;
        this.initCurrentComponent();
    },

    validations: function () {
        var attributes = {
            id: {},
            type_event: {
                required
            },
            mikrotik: {
                required
            },
            mikrotik_code: {},
            customer_full_name: {},
            customer_target: {},
            customer_download: {},
            customer_segment: {},

        };
        if (this.model.attributes.type_event == 4 || this.model.attributes.type_event == 5) {
            attributes['mikrotik_code'] = {required};
        }
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        var dataManager = {
//**Modal*
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    }
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {},
            lblBtnSave: "Generar",
            lblBtnClose: "Cerrar",
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-MikrotikManagerEvents',
            processName: "Registro Ruc.",
            formConfig: {
                nameSelector: "#MikrotikManagerEvents-form",
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el tipo de Ruc.',
                successMessage: 'El tipo de Ruc se guardo correctamente.',
                nameModel: "MikrotikManagerEvents",
                'url': $('#action-mikrotik-manager-events-managerEventResultsMikrotik').val()
            },

            submitStatus: "no",
            showManager: false,
            managerType: null,
            writingResult: {
                view: false,
                viewSuccess: false,
                viewOthers: false,
                'html': '',
                images: []
            }
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,


        //EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {


            }
        },
        __select: function (event, name) {
            var selectedJobTitle = event.target.options[event.target.options.selectedIndex];
            console.log(selectedJobTitle, name);

            this._setValueForm(name, selectedJobTitle.value);
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        initCurrentComponent: function () {


        },
//MANAGER PROCESS
        /*---------GRID--------*/

        /*  EVENTS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin

            } else if (typeView == 3) {//update
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
        },
        /*FORM*/
        getViewErrorForm: function (objValidate) {
            var result = false;
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? (!objValidate.$error) : false;
            } else {
                result = objValidate.$error;
            }

            return result;
        },
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                mikrotik_code: {
                    id: "mikrotik_code",
                    name: "mikrotik_code",
                    label: "Comando Mikrotik",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                },
                mikrotik: {
                    id: "mikrotik",
                    name: "mikrotik",
                    label: "Mikrotik Informacion",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                    data: $mikrotikData
                }, type_event: {
                    id: "type_event",
                    name: "type_event",
                    label: "Evento",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        },
                    data: $typeEventData
                },
                customer_full_name: {
                    id: "customer_full_name",
                    name: "customer_full_name",
                    label: "Nombre Cliente",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                customer_target: {
                    id: "customer_target",
                    name: "customer_target",
                    label: "Dirección IP",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                customer_download: {
                    id: "customer_download",
                    name: "customer_download",
                    label: "Velocidad Descarga",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                customer_segment: {
                    id: "customer_segment",
                    name: "customer_segment",
                    label: "Segmento",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
            };

            return result;
        },
        getAttributesForm: function () {
            var result = {
                id: null,
                type_event: 1,
                mikrotik: null,
                mikrotik_code: null,
                customer_full_name: null,
                customer_target: null,
                customer_download: null,
                customer_segment: null,

            };

            return result;
        }
        ,
        getNameAttributePeople: function (index, name) {
            var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
            return result;
        }
        ,
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        }
        ,
        getLabelForm: viewGetLabelForm,


        _setValueForm: function (name, value) {
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        }
        ,
        getClassErrorForm: function (nameElement, objValidate) {

            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        },
        getErrorHas: function (model, type) {

            var result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            var result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {
            var result = {
                MikrotikManagerEvents: {
                    mikrotik: this.$v.model.attributes.mikrotik.$model,
                    mikrotik_code: this.$v.model.attributes.mikrotik_code.$model,
                    type_event: this.$v.model.attributes.type_event.$model,

                }

            };


            return result;
        }
        ,
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();


            var $scope = this;
            this.writingResult.viewSuccess = false;
            $scope.writingResult.viewOthers = false;
            $scope.writingResult.view = false;
            var dataSend = dataSendResult;
            ajaxRequest(this.formConfig.url, {
                type: 'POST',
                data: dataSend,
                blockElement: $scope.tabCurrentSelector,//opcional: es para bloquear el elemento
                loading_message: $scope.formConfig.loadingMessage,
                error_message: $scope.formConfig.errorMessage,
                success_message: $scope.formConfig.successMessage,
                success_callback: function (response) {
                    if (response.success) {
                        $scope.writingResult.viewSuccess = true;
                        $scope.writingResult.view = true;
                        $scope.writingResult.html = response.data.html;
                    }
                }
            });

        },
        searchGlyph: function (params) {
            var typeSearch = params['typeSearch'];
            var needle = params['needle'];

            var haystack = $semioticsSymbolicInterpretation;
            var result = null;
            $.each(haystack, function (index, value) {
                if (typeSearch == 1 && value[6] == 'ACTIVE' && needle == value[1]) {
                    result = value;
                    return result;
                }
            });
            return result;
        }
        ,
        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
        }
        ,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        }
        ,
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        }
        ,
        getValidateForm: getValidateForm,
        _resetModel
:

function (model) {
    model.$reset();

}

,

}
})
;


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
            //MENU
            menuCurrent: [],
            configDataMikrotikManagerEvents: {
                title: "Registro de Habitaciones",
                data: [],
                titleEvent: "",
                business_id: null
            },

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
