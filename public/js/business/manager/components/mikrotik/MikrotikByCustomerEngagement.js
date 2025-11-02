var componentThisMikrotikByCustomerEngagement;
var $configCurrentManagement = {
    'processName': 'mikrotik-by-customer-engagement',
    'modelName': 'MikrotikByCustomerEngagement',
    'objectThis': null,
    'events': {
        'parentName': '_updateParentByChildren'
    },
    formConfig: {
        "nameSelector": "#mikrotik-by-customer-engagement-form",
        "url": $('#action-mikrotik-by-customer-engagement-saveData').val(),
        "loadingMessage": 'Guardando...',
        "errorMessage": 'Error al guardar el MikrotikByCustomerEngagement.',
        "successMessage": 'El MikrotikByCustomerEngagement se guardo correctamente.',
        "nameModel": 'MikrotikByCustomerEngagement'
    },
    gridConfig: {
        selectorCurrent: "#mikrotik-by-customer-engagement-grid",
        url: $("#action-mikrotik-by-customer-engagement-getAdmin").val()
    },
    tabCurrentSelector: '#tab-mikrotik-by-customer-engagement'

};

Vue.component($configCurrentManagement['processName'] + '-component', {
    template: '#' + $configCurrentManagement['processName'] + '-template',
    directives: {
        initS2Customer: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Customer({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2InvoiceSale: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2InvoiceSale({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2MikrotikRateLimit: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2MikrotikRateLimit({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2MikrotikDhcpServer: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2MikrotikDhcpServer({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2AntennaMikrotikDhcpServer: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2AntennaMikrotikDhcpServer({
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

        this.business_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        $configCurrentManagement['objectThis'] = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {},
            "customer_id_data": {required},
            "address": {required},
            "engagement_number": {required},
            "invoice_sale_id_data": {required},
            "type_ethernet": {required},
            "mikrotik_rate_limit_id_data": {required},
            "assigned_ip": {required, maxLength: Validators.maxLength(200)},
            "mac_computer": {required, maxLength: Validators.maxLength(200)},
            "computer_state": {required},
            "antenna_assigned_ip": {},
            "antenna_mac_computer": {},
            "antenna_state": {required},
            "mikrotik_dhcp_server_id_data": {required},
            "antenna_mikrotik_dhcp_server_id_data": {},

        };

        if (this.model.attributes.type_ethernet == 0) {
            attributes["antenna_assigned_ip"] = {
                required, maxLength: Validators.maxLength(200)
            };
            attributes["antenna_mac_computer"] = {
                required, maxLength: Validators.maxLength(200)
            };
            attributes["antenna_state"] = {
                required
            };
            attributes["antenna_mikrotik_dhcp_server_id_data"] = {
                required
            };
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
                    }, {
                        "title": "Inactivar",
                        "data-placement": "top",
                        "i-class": "fas fa-lock",
                        "managerType": "updateInactiveMikrotik"
                    }, {
                        "title": "Activar",
                        "data-placement": "top",
                        "i-class": "fas fa-lock-open",
                        "managerType": "updateActiveMikrotik"
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
            $scope = this;
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.resetForm();
                this._viewManager(3, rowId);
                this.managerMenuConfig.view = false;

                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.customer_id_data = {id: rowCurrent.customer_id, text: rowCurrent.customer};
                this.model.attributes.address = rowCurrent.address;
                this.model.attributes.engagement_number = rowCurrent.engagement_number;
                this.model.attributes.invoice_sale_id_data = {
                    id: rowCurrent.invoice_sale_id,
                    text: rowCurrent.invoice_sale
                };
                this.model.attributes.type_ethernet = rowCurrent.type_ethernet;
                this.model.attributes.mikrotik_rate_limit_id_data = {
                    id: rowCurrent.mikrotik_rate_limit_id,
                    text: rowCurrent.mikrotik_rate_limit
                };
                this.model.attributes.assigned_ip = rowCurrent.assigned_ip;
                this.model.attributes.mac_computer = rowCurrent.mac_computer;
                this.model.attributes.computer_state = rowCurrent.computer_state;
                this.model.attributes.antenna_assigned_ip = rowCurrent.antenna_assigned_ip;
                this.model.attributes.antenna_mac_computer = rowCurrent.antenna_mac_computer;
                this.model.attributes.antenna_state = rowCurrent.antenna_state;
                this.model.attributes.mikrotik_dhcp_server_id_data = {
                    id: rowCurrent.mikrotik_dhcp_server_id,
                    text: rowCurrent.mikrotik_dhcp_server
                };

                this.model.attributes.antenna_mikrotik_dhcp_server_id_data = {
                    id: rowCurrent.antenna_mikrotik_dhcp_server_id,
                    text: rowCurrent.antenna_mikrotik_dhcp_server
                };


            } else if(params.managerType =="updateActiveMikrotik") {
                var dataSend=rowCurrent;
                dataSend["active"]=true;
                var paramsAjax = {
                    url: $("#action-mikrotik-by-customer-engagement-managerDisabledEnabledCustomer").val(),
                    dataSend: dataSend,
                    "loadingMessage": "Realizando Gestion",

                };
                ajaxRequest(paramsAjax.url, {
                    type: 'POST',
                    data: paramsAjax.dataSend,
                    loading_message: paramsAjax.loadingMessage,

                    success_callback: function (response) {
                        if (response.success) {
                        }
                        console.log(response);
                    }
                });
            }else if(params.managerType =="updateInactiveMikrotik") {
                var dataSend=rowCurrent;
                dataSend["active"]=false;
                var paramsAjax = {
                    url: $("#action-mikrotik-by-customer-engagement-managerDisabledEnabledCustomer").val(),
                    dataSend: dataSend,
                    "loadingMessage": "Realizando Gestion",

                };
                ajaxRequest(paramsAjax.url, {
                    type: 'POST',
                    data: paramsAjax.dataSend,
                    loading_message: paramsAjax.loadingMessage,

                    success_callback: function (response) {
                        if (response.success) {
                        }
                        console.log(response);
                    }
                });
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
                    var resultAntenna = row.type_ethernet == 0 ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.antenna_assigned_ip.label + ":</span><span class='content-description__value'>" + row.antenna_assigned_ip + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.antenna_mac_computer.label + ":</span><span class='content-description__value'>" + row.antenna_mac_computer + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.antenna_state.label + ":</span><span class='content-description__value'>" + row.antenna_state + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.antenna_mikrotik_dhcp_server_id_data.label + ":</span><span class='content-description__value'>" + row.antenna_mikrotik_dhcp_server + "</span>",
                        "</div>"] : [];
                    resultAntenna = resultAntenna.join("");
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.customer_id_data.label + ":</span><span class='content-description__value'>" + row.customer + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.address.label + ":</span><span class='content-description__value'>" + row.address + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.engagement_number.label + ":</span><span class='content-description__value'>" + row.engagement_number + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.invoice_sale_id_data.label + ":</span><span class='content-description__value'>" + row.invoice_sale + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.type_ethernet.label + ":</span><span class='content-description__value'>" + row.type_ethernet + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.mikrotik_rate_limit_id_data.label + ":</span><span class='content-description__value'>" + row.mikrotik_rate_limit + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.assigned_ip.label + ":</span><span class='content-description__value'>" + row.assigned_ip + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.mac_computer.label + ":</span><span class='content-description__value'>" + row.mac_computer + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.computer_state.label + ":</span><span class='content-description__value'>" + row.computer_state + "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.mikrotik_dhcp_server_id_data.label + ":</span><span class='content-description__value'>" + row.mikrotik_dhcp_server + "</span>",
                        "</div>",
                        resultAntenna,
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
                "customer_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "customer_id_data"
                    },
                    "id": "customer_id_data",
                    "name": "customer_id_data",
                    "label": "Cliente",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "address": {
                    "field-options": {
                        "elementType": 5,
                        "elementTypeText": "Text Area",
                        "required": true,
                        "name": "address"
                    },
                    "id": "address",
                    "name": "address",
                    "label": "Direccion",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "engagement_number": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "engagement_number"
                    },
                    "id": "engagement_number",
                    "name": "engagement_number",
                    "label": "# Contrato",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "invoice_sale_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "invoice_sale_id_data"
                    },
                    "id": "invoice_sale_id_data",
                    "name": "invoice_sale_id_data",
                    "label": "# Factura",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "type_ethernet": {
                    "field-options": {
                        "elementType": 6,
                        "elementTypeText": "Input Number",
                        "min": 0,
                        "required": true,
                        "name": "type_ethernet"
                    },
                    "id": "type_ethernet",
                    "name": "type_ethernet",
                    "label": "Tipo de Contrato",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": 0, "text": "Banda Ancha"}, {"value": 1, "text": "Fibra Optica"}]

                },
                "mikrotik_rate_limit_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "mikrotik_rate_limit_id_data"
                    },
                    "id": "mikrotik_rate_limit_id_data",
                    "name": "mikrotik_rate_limit_id_data",
                    "label": "Tipo de Plan",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "assigned_ip": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "assigned_ip"
                    },
                    "id": "assigned_ip",
                    "name": "assigned_ip",
                    "label": "IP asignada Equipo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "mac_computer": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "mac_computer"
                    },
                    "id": "mac_computer",
                    "name": "mac_computer",
                    "label": "Mac del Equipo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "computer_state": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }],
                        "required": true,
                        "name": "computer_state"
                    },
                    "id": "computer_state",
                    "name": "computer_state",
                    "label": "Estado Equipo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                "mikrotik_dhcp_server_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "mikrotik_dhcp_server_id_data"
                    },
                    "id": "mikrotik_dhcp_server_id_data",
                    "name": "mikrotik_dhcp_server_id_data",
                    "label": "Servidor DHCP Equipo",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                },
                "antenna_assigned_ip": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "antenna_assigned_ip"
                    },
                    "id": "antenna_assigned_ip",
                    "name": "antenna_assigned_ip",
                    "label": "Antena Ip Asignada",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "antenna_mac_computer": {
                    "field-options": {
                        "elementType": 8,
                        "elementTypeText": "Input Size",
                        "maxLength": 200,
                        "required": true,
                        "name": "antenna_mac_computer"
                    },
                    "id": "antenna_mac_computer",
                    "name": "antenna_mac_computer",
                    "label": "Antena Mac",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "maxLength": {
                        "msj": "# Carecteres Excedidos a 200.",
                    },
                },
                "antenna_state": {
                    "field-options": {
                        "elementType": 3,
                        "elementTypeText": "Select",
                        "optionsData": [{"value": "ACTIVE", "text": "ACTIVE"}, {
                            "value": "INACTIVE",
                            "text": "INACTIVE"
                        }],
                        "required": true,
                        "name": "antenna_state"
                    },
                    "id": "antenna_state",
                    "name": "antenna_state",
                    "label": "Antena Estado",
                    "required": {
                        "allow": true,
                        "msj": "Campo requerido.",
                        "error": false
                    },
                    "options": [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },

                "antenna_mikrotik_dhcp_server_id_data": {
                    "field-options": {
                        "elementType": 1,
                        "elementTypeText": "Select 2",
                        "required": true,
                        "name": "antenna_mikrotik_dhcp_server_id_data"
                    },
                    "id": "antenna_mikrotik_dhcp_server_id_data",
                    "name": "antenna_mikrotik_dhcp_server_id_data",
                    "label": "Antena Servidor DHCP",
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
                "customer_id_data": null,
                "address": null,
                "engagement_number": null,
                "invoice_sale_id_data": null,
                "type_ethernet": 1,
                "mikrotik_rate_limit_id_data": null,
                "assigned_ip": null,
                "mac_computer": null,
                "computer_state": "ACTIVE",
                "antenna_assigned_ip": null,
                "antenna_mac_computer": null,
                "antenna_state": "ACTIVE",
                "mikrotik_dhcp_server_id_data": null,
                "antenna_mikrotik_dhcp_server_id_data": null,

            };
            return result;
        },

        getNameAttribute: getNameAttribute,
        getLabelForm: viewGetLabelForm,


        _setValueForm: _setValueForm,
        getClassErrorForm: getClassErrorForm,
//Manager Model

        getValuesSave: function () {
            var antenna_mikrotik_dhcp_server_id = null;
            var antenna_assigned_ip = null;
            var antenna_mac_computer = null;
            var antenna_state = "ACTIVE";
            if (this.$v.model.attributes.type_ethernet.$model == 0) {
                antenna_mikrotik_dhcp_server_id = this.$v.model.attributes.antenna_mikrotik_dhcp_server_id_data.$model.id;
                antenna_assigned_ip = this.$v.model.attributes.antenna_assigned_ip.$model;
                antenna_mac_computer = this.$v.model.attributes.antenna_mac_computer.$model;
                antenna_state = this.$v.model.attributes.antenna_state.$model;
            }
            var result = {
                MikrotikByCustomerEngagement:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "customer_id": this.$v.model.attributes.customer_id_data.$model.id,
                        "address": this.$v.model.attributes.address.$model,
                        "engagement_number": this.$v.model.attributes.engagement_number.$model,
                        "invoice_sale_id": this.$v.model.attributes.invoice_sale_id_data.$model.id,
                        "type_ethernet": this.$v.model.attributes.type_ethernet.$model,
                        "mikrotik_rate_limit_id": this.$v.model.attributes.mikrotik_rate_limit_id_data.$model.id,
                        "assigned_ip": this.$v.model.attributes.assigned_ip.$model,
                        "mac_computer": this.$v.model.attributes.mac_computer.$model,
                        "computer_state": this.$v.model.attributes.computer_state.$model,
                        "antenna_assigned_ip": antenna_assigned_ip,
                        "antenna_mac_computer": antenna_mac_computer,
                        "antenna_state": antenna_state,
                        "mikrotik_dhcp_server_id": this.$v.model.attributes.mikrotik_dhcp_server_id_data.$model.id,
                        "antenna_mikrotik_dhcp_server_id": antenna_mikrotik_dhcp_server_id,
                        "business_id": this.business_id

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
        _managerS2Customer: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.customer_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-customer-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            "search_entidadid": _this.business_id,
                            search_value: term,
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
                _this.model.attributes.customer_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.customer_id_data = null;
                _this._setValueForm('customer_id_data', null);
            });
        }, _managerS2InvoiceSale: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.invoice_sale_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-invoice-sale-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            search_value: term,
                            filters: {
                                search_value: term,
                                "entidad_data_id": _this.business_id,
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
                _this.model.attributes.invoice_sale_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.invoice_sale_id_data = null;
                _this._setValueForm('invoice_sale_id_data', null);
            });
        }, _managerS2MikrotikRateLimit: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.mikrotik_rate_limit_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-mikrotik-rate-limit-getListSelect2").val(),
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
                _this.model.attributes.mikrotik_rate_limit_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.mikrotik_rate_limit_id_data = null;
                _this._setValueForm('mikrotik_rate_limit_id_data', null);
            });
        }, _managerS2MikrotikDhcpServer: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.mikrotik_dhcp_server_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-mikrotik-dhcp-server-getListSelect2").val(),
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
                _this.model.attributes.mikrotik_dhcp_server_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.mikrotik_dhcp_server_id_data = null;
                _this._setValueForm('mikrotik_dhcp_server_id_data', null);
            });
        },
        _managerS2AntennaMikrotikDhcpServer: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.antenna_mikrotik_dhcp_server_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-mikrotik-dhcp-server-getListSelect2").val(),
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
                _this.model.attributes.antenna_mikrotik_dhcp_server_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.antenna_mikrotik_dhcp_server_id_data = null;
                _this._setValueForm('antenna_mikrotik_dhcp_server_id_data', null);
            });
        },
    }
})
;



