var componentThisMikrotikRateLimit;
var $configCurrentManagement = {
    'processName': 'mikrotik-rate-limit',
    'modelName': 'MikrotikRateLimit',
    'objectThis': null,
    'events': {
        'parentName': '_updateParentByChildren'
    },
    formConfig: {
        "nameSelector": "#mikrotik-rate-limit-form",
        "url": $('#action-mikrotik-rate-limit-saveData').val(),
        "loadingMessage": 'Guardando...',
        "errorMessage": 'Error al guardar el MikrotikRateLimit.',
        "successMessage": 'El MikrotikRateLimit se guardo correctamente.',
        "nameModel": 'MikrotikRateLimit'
    },
    gridConfig: {
        selectorCurrent: "#mikrotik-rate-limit-grid",
        url: $("#action-mikrotik-rate-limit-getAdmin").val()
    },
    tabCurrentSelector: '#tab-mikrotik-rate-limit'

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

        this.business_id =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        $configCurrentManagement['objectThis'] = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "name": {required, maxLength: Validators.maxLength(200)},

            "state": {required}
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
            this.manager_id = this.business_id;
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
                this.model.attributes.name = rowCurrent.name;

                this.model.attributes.state = rowCurrent.state;


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
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + "'>" + row.state + "</span></span>",
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
                "name": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "name"
                    },
                    "id": "name",
                    "name": "name",
                    "label": "Rate/Limit",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "state":
                    {
                        "field-options": {
                            "elementType": 3,
                            "elementTypeText": "Select",
                            "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                                "value": "INACTIVE",
                                "text": "INACTIVE"
                            }],
                            "required": true,
                            "name": "state"
                        },
                        "id": "state",
                        "name": "state",
                        "label": "Estado",
                        "required": {
                            "allow": true,
                            "msj": "Campo requerido.",
                            "error": false
                        },
                        "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                    }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "name": null, "state": "ACTIVE"
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
                MikrotikRateLimit:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "name": this.$v.model.attributes.name.$model,
                        "business_id": this.business_id,
                        "state": this.$v.model.attributes.state.$model

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



