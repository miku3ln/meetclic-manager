var componentThisAllowProcessesThreads;
var $configCurrentManagement = {
    'processName': 'allow-processes-threads',
    'modelName': 'AllowProcessesThreads',
    'objectThis': null,
    'events': {
        'parentName': '_updateParentByChildren'
    },
    formConfig: {
        "nameSelector": "#allow-processes-threads-form",
        "url": $('#action-allow-processes-threads-saveData').val(),
        "loadingMessage": 'Guardando...',
        "errorMessage": 'Error al guardar el AllowProcessesThreads.',
        "successMessage": 'El AllowProcessesThreads se guardo correctamente.',
        "nameModel": 'AllowProcessesThreads'
    },
    gridConfig: {
        selectorCurrent: "#allow-processes-threads-grid",
        url: $("#action-allow-processes-threads-getAdmin").val()
    },
    tabCurrentSelector: '#tab-allow-processes-threads'

};

Vue.component($configCurrentManagement['processName'] + '-component', {


    template: '#' + $configCurrentManagement['processName'] + '-template',
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on($configCurrentManagement['events']['parentName'], function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        $configCurrentManagement['objectThis'] = this;
        this.initCurrentComponent();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "name_process": {required},
            "thread_name": {required},
            "allow": {required},
            "entity_plans_id": {required}
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
            manager_key_name: 'change_key',
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
            tabCurrentSelector: $configCurrentManagement['tabCurrentSelector'],
            processName: "Registro Acción.",
            formConfig: $configCurrentManagement['formConfig'],
//Grid config
            gridConfig: $configCurrentManagement['gridConfig'],
            showManager: false,
            managerType: null,
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
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.resetForm();
                this._viewManager(3, rowId);
                this.managerMenuConfig.view = false;

                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.name_process = rowCurrent.name_process;
                this.model.attributes.thread_name = rowCurrent.thread_name;
                this.model.attributes.allow = rowCurrent.allow;
                this.model.attributes.entity_plans_id = rowCurrent.entity_plans_id;


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

                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name_process.label + ":</span><span class='content-description__value'>" + row.name_process + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.thread_name.label + ":</span><span class='content-description__value'>" + row.thread_name + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.allow.label + ":</span><span class='content-description__value'>" + row.allow + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.entity_plans_id.label + ":</span><span class='content-description__value'>" + row.entity_plans_id + "</span>",
                        "</div>"
                        , "</div>"];

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
                "name_process": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "name_process"
                    },
                    "id": "name_process",
                    "name": "name_process",
                    "label": "name process",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "thread_name": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "thread_name"
                    },
                    "id": "thread_name",
                    "name": "thread_name",
                    "label": "thread name",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "allow": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "allow"
                    },
                    "id": "allow",
                    "name": "allow",
                    "label": "allow",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "entity_plans_id":
                    {
                        "field-options": {
                            "elementType": 6,
                            "elementTypeText": "Input Number",
                            "min": 0,
                            "required": true,
                            "name": "entity_plans_id"
                        },
                        "id": "entity_plans_id",
                        "name": "entity_plans_id",
                        "label": "entity plans id",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "name_process": null, "thread_name": null, "allow": null, "entity_plans_id": null
            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,


        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {

            var result = {
                AllowProcessesThreads:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "name_process": this.$v.model.attributes.name_process.$model,
                        "thread_name": this.$v.model.attributes.thread_name.$model,
                        "allow": this.$v.model.attributes.allow.$model,
                        "entity_plans_id": this.$v.model.attributes.entity_plans_id.$model

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
//others functions


    }
})
;



