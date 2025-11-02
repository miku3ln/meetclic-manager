var componentThisCajaCatalogoBillete;
var $configCurrentManagement = {
    'processName': 'caja-catalogo-billete',
    'modelName': 'CajaCatalogoBillete',
    'objectThis': null,
    'events': {
        'parentName': '_updateParentByChildren'
    },
    formConfig: {
        "nameSelector": "#caja-catalogo-billete-form",
        "url": $('#action-caja-catalogo-billete-saveData').val(),
        "loadingMessage": 'Guardando...',
        "errorMessage": 'Error al guardar el CajaCatalogoBillete.',
        "successMessage": 'El CajaCatalogoBillete se guardo correctamente.',
        "nameModel": 'CajaCatalogoBillete'
    },
    gridConfig: {
        selectorCurrent: "#caja-catalogo-billete-grid",
        url: $("#action-caja-catalogo-billete-getAdmin").val()
    },
    tabCurrentSelector: '#tab-caja-catalogo-billete'

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
            "caja_tipo_billete_id": {required},
            "value": {required, maxLength: Validators.maxLength(100)},
            "caja_catalogo_tipo_fraccion_id": {required},
            "valor": {}
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
                this.model.attributes.caja_tipo_billete_id = rowCurrent.caja_tipo_billete_id;
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.caja_catalogo_tipo_fraccion_id = rowCurrent.caja_catalogo_tipo_fraccion_id;
                this.model.attributes.valor = parseFloat(rowCurrent.valor);


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
                        "   <span class='content-description__title'>" + structure.caja_tipo_billete_id.label + ":</span><span class='content-description__value'>" + row.caja_tipo_billete_id + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.value.label + ":</span><span class='content-description__value'>" + row.value + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.caja_catalogo_tipo_fraccion_id.label + ":</span><span class='content-description__value'>" + row.caja_catalogo_tipo_fraccion_id + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span  class='content-description__title'>" + structure.valor.label + ":</span><span class='content-description__value'>" + row.valor + "</span>",
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
                "caja_tipo_billete_id": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "caja_tipo_billete_id"
                    },
                    "id": "caja_tipo_billete_id",
                    "name": "caja_tipo_billete_id",
                    "label": "caja tipo billete id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "value": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 100,
                        "required": true,
                        "name": "value"
                    },
                    "id": "value",
                    "name": "value",
                    "label": "value",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 100.",
                    },
                },
                "caja_catalogo_tipo_fraccion_id": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "caja_catalogo_tipo_fraccion_id"
                    },
                    "id": "caja_catalogo_tipo_fraccion_id",
                    "name": "caja_catalogo_tipo_fraccion_id",
                    "label": "caja catalogo tipo fraccion id",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "valor":
                    {
                        "field-options": {
                            "elementType": 6,
                            "elementTypeText": "Input Number",
                            "min": 0,
                            "required": true,
                            "name": "valor"
                        },
                        "id": "valor",
                        "name": "valor",
                        "label": "valor",
                        "required": {
                            "allow": false,
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
                "caja_tipo_billete_id": null, "value": null, "caja_catalogo_tipo_fraccion_id": null, "valor": null
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
                CajaCatalogoBillete:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "caja_tipo_billete_id": this.$v.model.attributes.caja_tipo_billete_id.$model,
                        "value": this.$v.model.attributes.value.$model,
                        "caja_catalogo_tipo_fraccion_id": this.$v.model.attributes.caja_catalogo_tipo_fraccion_id.$model,
                        "valor": this.$v.model.attributes.valor.$model

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



