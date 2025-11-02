var componentThisMikrotikDhcpServer;
var $configCurrentManagement = {
    'processName': 'mikrotik-dhcp-server',
    'modelName': 'MikrotikDhcpServer',
    'objectThis': null,
    'events': {
        'parentName': '_updateParentByChildren'
    },
    formConfig: {
        "nameSelector": "#mikrotik-dhcp-server-form",
        "url": $('#action-mikrotik-dhcp-server-saveData').val(),
        "loadingMessage": 'Guardando...',
        "errorMessage": 'Error al guardar el MikrotikDhcpServer.',
        "successMessage": 'El MikrotikDhcpServer se guardo correctamente.',
        "nameModel": 'MikrotikDhcpServer'
    },
    gridConfig: {
        selectorCurrent: "#mikrotik-dhcp-server-grid",
        url: $("#action-mikrotik-dhcp-server-getAdmin").val()
    },
    tabCurrentSelector: '#tab-mikrotik-dhcp-server'

};

Vue.component($configCurrentManagement['processName'] + '-component', {


    template: '#' + $configCurrentManagement['processName'] + '-template',
    directives: {
        initS2MikrotikTypeConection: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2MikrotikTypeConection({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }
    }
    , props: {
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
            "interface": {required, maxLength: Validators.maxLength(200)},
            "addres_pool": {required, maxLength: Validators.maxLength(200)},
            "address": {required, maxLength: Validators.maxLength(200)},
            "state": {required},
            "mikrotik_type_conection_id_data": {required}
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
                this.model.attributes.interface = rowCurrent.interface;
                this.model.attributes.addres_pool = rowCurrent.addres_pool;
                this.model.attributes.address = rowCurrent.address;
                this.model.attributes.business_id = rowCurrent.business_id;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.mikrotik_type_conection_id_data = {
                    id: rowCurrent.mikrotik_type_conection_id,
                    text: rowCurrent.mikrotik_type_conection
                };


            }
        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = new Object();
            var filters = new Object();
            filters[this.manager_key_name] = this.business_id;
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
                        "   <span class='content-description__title'>" + structure.interface.label + ":</span><span class='content-description__value'>" + row.interface + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.addres_pool.label + ":</span><span class='content-description__value'>" + row.addres_pool + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.address.label + ":</span><span class='content-description__value'>" + row.address + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span   elementType='11'  class='content-description__title'>" + structure.mikrotik_type_conection_id_data.label + ":</span><span class='content-description__value'>" + row.mikrotik_type_conection + "</span>",
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
                    "label": "Name",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "interface": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "interface"
                    },
                    "id": "interface",
                    "name": "interface",
                    "label": "Interface",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "addres_pool": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "addres_pool"
                    },
                    "id": "addres_pool",
                    "name": "addres_pool",
                    "label": "Address pool",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "address": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "address"
                    },
                    "id": "address",
                    "name": "address",
                    "label": "Address",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },

                "state": {
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
                },
                "mikrotik_type_conection_id_data":
                    {
                        "field-options": {
                            "elementType": 1,
                            "elementTypeText": "Select 2",
                            "required": true,
                            "name": "mikrotik_type_conection_id_data"
                        },
                        "id": "mikrotik_type_conection_id_data",
                        "name": "mikrotik_type_conection_id_data",
                        "label": "Tipo Conexion",
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
                "name": null,
                "interface": null,
                "addres_pool": null,
                "address": null,
                "state": "ACTIVE",
                "mikrotik_type_conection_id_data": null
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
                MikrotikDhcpServer:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "name": this.$v.model.attributes.name.$model,
                        "interface": this.$v.model.attributes.interface.$model,
                        "addres_pool": this.$v.model.attributes.addres_pool.$model,
                        "address": this.$v.model.attributes.address.$model,
                        "business_id": this.business_id,
                        "state": this.$v.model.attributes.state.$model,
                        "mikrotik_type_conection_id": this.$v.model.attributes.mikrotik_type_conection_id_data.$model.id

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
        _managerS2MikrotikTypeConection: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.mikrotik_type_conection_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-mikrotik-type-conection-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.mikrotik_type_conection_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.mikrotik_type_conection_id_data = null;
                _this._setValueForm('mikrotik_type_conection_id_data', null);
            });
        },

    }
})
;



