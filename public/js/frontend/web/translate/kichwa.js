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


var componentThisRucType;
Vue.component('ruc-type-component', {

    template: '#rucType-template',
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
        componentThisRucType = this;
        this.initCurrentComponent();
    },

    validations: function () {
        var attributes = {
            id: {},
            name: {required},//


        };
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
            tabCurrentSelector: '#tab-rucType',
            processName: "Registro Ruc.",
            formConfig: {
                nameSelector: "#rucType-form",
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el tipo de Ruc.',
                successMessage: 'El tipo de Ruc se guardo correctamente.',
                nameModel: "RucType"
            },

            submitStatus: "no",
            showManager: false,
            managerType: null,
            writingResult: {
                view: false,
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
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        initCurrentComponent: function () {


        },
        /*---MODAL CURRENT--*/
        _closeModal: function () {
            closeModal();
        },
        makeToast: function (params) {
            var $msjCurrent = params.msj;
            var $titleCurrent = params.title;
            var $typeCurrent = params.type;

            this.$notify({
                type: $typeCurrent,
                title: $titleCurrent,
                duration: 0,
                content: $msjCurrent,

            }).then(() => {
                // resolve after dismissed
                console.log('dismissed');
            });
        },
        //MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: function (selector) {
            $(selector).tooltip('hide');
        },
        _resetManagerGrid: function () {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null
            };
        },

        getMenuConfig: function (params) {
            var result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value, rowId: params.rowId,
                    managerType: value["managerType"],
                    params: params
                }
                result.push(setPush);
            });
            return result;
        },
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
        },
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
            var result = false
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

                name: {
                    id: "name",
                    name: "name",
                    label: "Nombre",
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
                name: null,

            };

            return result;
        },
        getNameAttributePeople: function (index, name) {
            var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, value) {
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
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
                RucType: {
                    id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    name: this.$v.model.attributes.name.$model,


                }

            };


            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var resArray = dataSend['RucType']['name'].split("");
            this.writingResult.view = false;
            this.writingResult.images = [];
            var view = false;
            var images = [];
            var countPhrase = Object.keys(resArray).length;
            if (countPhrase == 1) {
                var resultGlyph = this.searchGlyph({
                    typeSearch: 1,
                    'needle':resArray['0'].toLowerCase()
                });
                if (resultGlyph) {
                    images.push({
                        img: resultGlyph[2]
                    });
                    view = true;
                }
            } else if (countPhrase > 1) {

            }
            console.log(resArray);

            this.writingResult.view = view;
            this.writingResult.images = images;
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
        },
        resetForm: function () {

            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
        },
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getValidateForm: getValidateForm,
        _resetModel: function (model) {
            model.$reset();

        },

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
            configDataRucType: {
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
