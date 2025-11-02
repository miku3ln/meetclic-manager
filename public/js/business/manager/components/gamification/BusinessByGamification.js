var componentThisBusinessByGamification;
Vue.component('business-by-gamification-component', {
    template: '#business-by-gamification-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on("_businessByGamification", function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        componentThisBusinessByGamification = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "allow_exchange": {},
            "allow_exchange_business": {},
            "state": {required},
            "value": {required},
            "description": {},
            "value_unit": {required},
            "gamification_id": {},

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
            manager_id: null,
            manager_key_name: 'business_id',
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        "managerType": "updateEntity"
                    },
                    {
                        "title": "Administracion de Puntos",
                        "data-placement": "top",
                        "i-class": " fas fa-gamepad",
                        "managerType": "gamificationByProcess"
                    },
                    {
                        "title": "Administracion Premios",
                        "data-placement": "top",
                        "i-class": " fas fa-award",
                        "managerType": "gamificationByRewards"
                    }
                ]
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {
                "title": "Administracion de Informacion",
                buttons: {
                    save: "Guardar",
                    update: "Actualizar",
                    cancel: "Cancelar"
                }
            },

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-business-by-gamification',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#business-by-gamification-form",
                url: $('#action-business-by-gamification-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el BusinessByGamification.',
                successMessage: 'El BusinessByGamification se guardo correctamente.',
                nameModel: "BusinessByGamification"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#business-by-gamification-grid",
                url: $("#action-business-by-gamification-getAdmin").val()
            },
            showManager: false,
            managerType: null,
            configModalGamificationByProcess: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalGamificationByRewards:{
                "title": "Title",
                "viewAllow": false,
                "data": []
            }

        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function () {
            this.manager_id = this.configParams.data.id;
            this.initGridManager(this);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: getMenuConfig,
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
                elementSelect: elementSelect,

            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                this._viewManager(3, rowId);
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.gamification_id = rowCurrent.gamification_id;
                this.model.attributes.allow_exchange = rowCurrent.allow_exchange == 1 ? true : false;
                this.model.attributes.allow_exchange_business = rowCurrent.allow_exchange_business == 1 ? true : false;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.description = rowCurrent.description == null || rowCurrent.description == 'null' ? '' : rowCurrent.description;
                this.model.attributes.value_unit = parseFloat(rowCurrent.value_unit);


            } else if (params.managerType == "gamificationByProcess") {
                this.configModalGamificationByProcess.data = rowCurrent;
                if (this.configModalGamificationByProcess.viewAllow) {
                    this.$refs.refGamificationByProcess._setValueOfParent(
                        {type: "openModal", data: this.configModalGamificationByProcess}
                    );
                } else {
                    this.configModalGamificationByProcess.viewAllow = true;
                }
            } else if (params.managerType == "gamificationByRewards") {
                this.configModalGamificationByRewards.data = rowCurrent;
                this.configModalGamificationByRewards.business_id = this.business_id;
                if (this.configModalGamificationByRewards.viewAllow) {
                    this.$refs.refGamificationByRewards._setValueOfParent(
                        {type: "openModal", data: this.configModalGamificationByRewards}
                    );
                } else {
                    this.configModalGamificationByRewards.viewAllow = true;
                }
            }


        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.manager_id;
            paramsFilters = filters;
            var structure = $scope.model.structure;
            var formatters = {
                'description': function (column, row) {

                    var classStatus = "badge-success";
                    if (row.state == "INACTIVE") {
                        classStatus = "badge-warning";
                    }

                    var classBadgeCashPoint = "badge-success";
                    var textBadgeCashPoint = "SI";

                    if (row.allow_exchange ==0) {
                        classBadgeCashPoint = "badge-warning";
                        textBadgeCashPoint = "NO";
                    }
                    var classBadgeCashPointBusiness = "badge-success";
                    var textBadgeCashPointBusiness = "SI";

                    if (row.allow_exchange_business ==0) {
                        classBadgeCashPointBusiness = "badge-warning";
                        textBadgeCashPointBusiness = "NO";
                    }
                    var hrefManagerMain = '<a class="content-description__task-main">' + row.value + '</a>';
                    var result = [

                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + "'>" + row.state + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + hrefManagerMain + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.value_unit.label + ":</span><span class='content-description__value'>" + row.value_unit + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.allow_exchange.label + ":</span><span class='content-description__value'>" +"<span class='badge badge--size-large "+classBadgeCashPoint+"'>  " +textBadgeCashPoint + "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.allow_exchange_business.label + ":</span><span class='content-description__value'>" +"<span class='badge badge--size-large "+classBadgeCashPointBusiness+"'>  " +textBadgeCashPointBusiness + "</span></span>",
                        "</div>",
                        "</div>"];

                    return result.join("");
                }
            };

            let gridInit = initGridManager({
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                'urlCurrent': urlCurrent
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: _viewManager,
//FORM CONFIG
        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {
                "gamification_id": {
                    "id": "gamification_id",
                    "name": "gamification_id",
                    "label": "gamification id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },

                "allow_exchange": {
                    "id": "allow_exchange",
                    "name": "allow_exchange",
                    "label": "Permitir Canjeo de Puntos",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "allow_exchange_business": {
                    "id": "allow_exchange_business",
                    "name": "allow_exchange_business",
                    "label": "Permitir Canjeo de Puntos de Otra Empresa.",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "state":
                    {
                        "id": "state",
                        "name": "state",
                        "label": "Estado",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                    },
                "value": {
                    "id": "value",
                    "name": "value",
                    "label": "Nombre",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "description": {
                    "id": "description",
                    "name": "description",
                    "label": "Descripcion",
                    "required": {
                        "allow": false,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "value_unit": {
                    "id": "value_unit",
                    "name": "value_unit",
                    "label": "Valor de Unidad Puntos.",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "gamification_id": null,
                "allow_exchange": null,
                "allow_exchange_business": null,
                "state": "ACTIVE",
                "value": "",
                "description": "",
                "value_unit": 0,


            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,


        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {
let business_id=$businessManager.id;
            var result = {
                BusinessByGamification:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "gamification_id": this.$v.model.attributes.gamification_id.$model,
                        "allow_exchange": this.$v.model.attributes.allow_exchange.$model == null ? 0 : (this.$v.model.attributes.allow_exchange.$model ? 1 : 0),
                        "allow_exchange_business": this.$v.model.attributes.allow_exchange_business.$model == null ? 0 : (this.$v.model.attributes.allow_exchange_business.$model ? 1 : 0),
                        "state": this.$v.model.attributes.state.$model,
                        "value": this.$v.model.attributes.value.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "value_unit": this.$v.model.attributes.value_unit.$model,
                        "business_id": business_id,


                    }
            };

            return result;
        },
        _saveModel: _saveModel,
        resetForm: resetForm,
        _valuesForm: function (event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: validateForm,
        getValidateForm: getValidateForm,

    }
})
;




