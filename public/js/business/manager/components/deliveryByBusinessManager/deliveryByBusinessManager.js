//BUSINESS-MANAGER-CRM-DELIVERY-COMPONENT

var componentThisDeliveryByBusinessManager;
Vue.component('delivery-by-business-manager-component', {
    template: '#delivery-by-business-manager-template',
    directives: {
        initS2DeliveryByBusinessManagerCustomer: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._method({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2DeliveryByBusinessManagerAddress: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._method({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2DeliveryByBusinessManagerPhone: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._method({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initCodeBar: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._method({
                    objSelector: el, code: paramsInput.code
                });
            }
        }
    }, props: {
        params: {
            type: Object,
        }
    },
    created: function () {


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.entity_id = this.configParams.data.entity_id;
        this.entity_manager_id = this.configParams.data.entity_manager_id;
        this.entity_data = this.configParams.data.rowCurrent;
        this.labelsConfig.title = this.getTitleCurrent(2);

        this.entity_type = this.configParams.data.entity_type;

    },
    mounted: function () {
        componentThisDeliveryByBusinessManager = this;
        this.initCurrentComponent();
    },

    validations: function () {
        var attributes = {
            "id": {},
            "number_box": {required, minValue: minValue(1)},
            "description": {required},
            "address_id_data": {required},
            "phone_id_data": {required},
            "status": {required},
            "number_invoice": {
                required, isUnique(value) {
                    var urlValidate = $("#action-delivery-by-business-manager-getUniqueNumberInvoice").val();
                    var params = {
                        number_invoice: value
                    };
                    var managerId = this.model.attributes.id;
                    if (managerId) {
                        params['id'] = managerId;
                    }
                    var paramsPost = {
                        allow: this.managerInitGet.number_invoice.allow,
                        value: value,
                        paramsPost: params,
                        urlValidate: urlValidate
                    };
                    var result = null;
                    if (value === '') {
                        result = true;
                    } else {
                        if (this.managerInitGet.number_invoice.allow) {
                            result = getValuesPost(paramsPost);
                        } else {
                            result = true;

                        }
                    }
                    return result;

                }
            },


        };
        var result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {
//CHANGE INFORMATION BUSINESS PRINT CIBP
        var dataManager = {
            printLabelConfig: {
                numberPrint: 1,
                advice: "AVISO IMPORTATE<br>Inka Importadora se encarga de la verificación de los productos antes de empezar el empaque. / Todo pedido realizado se envía mediante empresas ajenas a nuestra institución. / Productos con avería deben ser notificados en las proximas 24 horas de su entrega caso contrario no nos hacemos responsables.",
                title: "Origen",
                business: "INKA IMPORTADORA",
                businessOne: "VILLACONSUELO",
                businessAddressOne: "Calle Hermanos Pinzon  #82<br> Casi esquina Manuela diez. ",
                titleInformationOne: "Telefonos ",
                phoneOne: "+18096818560 ",
                phoneTwo: "",
                titleInformationTwo: "Pagina Web",
                pageOne: "http://inkavillaconsuelo.com",
                titleBodyOne: "Destino",
                titleBodyTwo: "Observaciones",
                titleBodyThree: "Nro de Cajas",
                titleBodyFour: "Nro de Factura",
                titleBodyFive: "Nro de Orden",

                logoBusiness: $configManagerProcessCurrent.design.resources.logoBusiness
            },
            viewManagerPrint: {print: false},
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [
                    {
                        "title": "Actualizar",
                        "data-placement": "top",
                        "i-class": "fas fa-pencil-alt",
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
                "title": "Huespedes Pago",
                process: {
                    "payment": "Pagos"
                },
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
            tabCurrentSelector: '#delivery-by-business-manager-form',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#delivery-by-business-manager-form",
                url: $('#action-delivery-by-business-manager-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el DeliveryByBusinessManager.',
                successMessage: 'El DeliveryByBusinessManager se guardo correctamente.',
                nameModel: "DeliveryByBusinessManager"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#delivery-by-business-manager-grid",
                url: $("#action-delivery-by-business-manager-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            managerInitGet: {
                number_invoice: {
                    allow: false
                },

            },
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        getTitleCurrent: function (type) {
            var result = "";
            if (type == 0) {
                result = this.configParams.data.labelsConfig.title + " - " + "Creacion.";
            } else if (type == 1) {
                result = this.configParams.data.labelsConfig.title + " - " + "Actualizacion.";

            } else if (type == 2) {
                result = "Administracion " + this.configParams.data.labelsConfig.title + ".";

            }
            return result;
        },
        initCurrentComponent: function () {

            this.initGridManager(this);
            this.initDataModal();
            this.$refs.refDeliveryByBusinessManagerModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalDeliveryByBusinessManager'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refDeliveryByBusinessManagerModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;

                this.initDataModal();
                this.$refs.refDeliveryByBusinessManagerModal.show();

            }
        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },

//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
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
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
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
        _gridManager: function (elementSelect) {
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            elementSelect.find("tbody tr").on("click", function (e) {
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var selectorRow;
                if (dataRowId) {
                    var instance_data_rows = $(selectorGrid).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    elementSelect.find("tr.selected").removeClass("selected");
                    var newEventRow = false;
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        var removeRowId = vmCurrent.managerMenuConfig.rowId;
                        if (dataRowId == removeRowId) {
                            selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                            $(selectorRow).removeClass("selected");
                            vmCurrent._resetManagerGrid();
                        } else {

                            newEventRow = true;
                        }
                    } else {
                        newEventRow = true;
                    }
                    if (newEventRow) {
                        selectorRow = selectorGrid + " tr[data-row-id='" + dataRowId + "']";
                        $(selectorRow).addClass("selected");
                        vmCurrent.managerMenuConfig = {
                            view: true,
                            menuCurrent: vmCurrent.getMenuConfig({rowData: rowData[0], rowId: dataRowId}),
                            rowId: dataRowId
                        };
                    }

                }
            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.number_box = rowCurrent.number_box;
                this.model.attributes.customer_id = rowCurrent.customer_id;


                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.number_invoice = rowCurrent.number_invoice;

                this.model.attributes.address_id_data = {
                    id: rowCurrent.address_id,
                    street_one: rowCurrent.information_address_street_one,
                    street_two: rowCurrent.information_address_street_two,
                    text: rowCurrent.information_address_street_one + " " + "" + "" + rowCurrent.information_address_street_two
                };
                this.model.attributes.phone_id_data = {
                    id: rowCurrent.phone_id,
                    information_phone: rowCurrent.information_phone_value,
                    text: rowCurrent.information_phone_value
                };


                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                entity_id: this.entity_id,
                entity_manager_id: this.entity_manager_id,
                entity_type: this.entity_type,

            };
            var gridInit = $(gridName);
            gridInit.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                ajax: true,
                post: function () {
                    return {
                        grid_id: gridName,
                        filters: paramsFilters
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
                    'description': function (column, row) {

                        var stateRow = [];
                        if (row.status == 'ACTIVE') {
                            stateRow = ['<span class="content-description__value badge badge--size-large badge-info">ACTIVO</span>'];
                        } else if (row.status == 'INACTIVE') {
                            stateRow = ['<span class="content-description__value badge badge--size-large badge-warning">INACTIVO</span>'];

                        } else if (row.status == 'DELIVERED') {
                            stateRow = ['<span class="content-description__value badge badge--size-large badge-success">ENTREGADO</span>'];

                        } else if (row.status == 'DELETED') {
                            stateRow = ['<span class="content-description__value badge badge--size-large badge-warning">ELIMINADO</span>'];

                        } else if (row.status == 'INITIALIZED') {
                            stateRow = ['<span class="content-description__value badge badge--size-large badge-info">POR ENTREGAR</span>'];

                        }

                        stateRow = stateRow.join('');
                        var addressCurrent = row.information_address_street_one + " , " + row.information_address_street_two;
                        var phoneCurrent = row.information_phone_value;

                        var result = [
                            "<div class='content-description'>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span>" + stateRow,
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Direccion:</span><span class='content-description__value'>" + addressCurrent + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Telefono/Celular:</span><span class='content-description__value'>" + phoneCurrent + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Factura #:</span><span class='content-description__value'>" + row.number_invoice + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'># Cajas:</span><span class='content-description__value'>" + row.number_box + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Observaciones:</span><span class='content-description__value'>" + row.description + "</span>",
                            "</div>",

                            "</div>"];

                        return result.join("");

                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.labelsConfig.title = this.getTitleCurrent(0);
                this.showManager = true;
                this.managerMenuConfig.view = false;
                $(this.gridConfig.selectorCurrent + "-header").hide();
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.labelsConfig.title = this.getTitleCurrent(2);

                this.showManager = false;
                $(this.gridConfig.selectorCurrent + "-footer").show();
                $(this.gridConfig.selectorCurrent + "-header").show();
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {//update
                this.labelsConfig.title = this.getTitleCurrent(1);
                this.showManager = true;
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                $(this.gridConfig.selectorCurrent + "-header").hide();
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
        },
//FORM CONFIG
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

                number_box: {
                    id: "number_box",
                    name: "number_box",
                    label: "# Cajas",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                    minLength: {
                        msj: "valores solo positivos",
                    },
                },
                number_invoice: {
                    id: "number_invoice",
                    name: "number_invoice",
                    label: "# Factura",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    unique: {
                        msj: "Ya existe esta factura.!",
                    },
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Observaciones",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                address_id_data: {
                    id: "address_id_data",
                    name: "address_id_data",
                    label: "Direccion",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                phone_id_data: {
                    id: "phone_id_data",
                    name: "phone_id_data",
                    label: "Telefono/Celular",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                status: {
                    id: "status",
                    name: "status",
                    label: "Estado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "INITIALIZED", "text": "Iniciado"}, {
                        "value": "INACTIVE",
                        "text": "INACTIVE"
                    }, {"value": "DELIVERED", "text": "ENTREGADO"}]
                },


            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "number_box": null,
                "description": null,
                "address_id_data": null,
                "phone_id_data": null,
                "status": 'INITIALIZED',
                "user_id": 1,
                "number_invoice": null,
            };
            return result;
        },

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,


        _setValueForm: function (name, value) {
            if (name == "number_invoice") {
                this.managerInitGet[name].allow = true;
            }
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
                DeliveryByBusinessManager:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "customer_id": this.entity_id,
                        "number_box": this.$v.model.attributes.number_box.$model,
                        "description": this.$v.model.attributes.description.$model,
                        "address_id": this.$v.model.attributes.address_id_data.$model.id,
                        "phone_id": this.$v.model.attributes.phone_id_data.$model.id,
                        "status": this.$v.model.attributes.status.$model,
                        "user_id": 1,
                        "number_invoice": this.$v.model.attributes.number_invoice.$model,
                        "business_id": this.entity_manager_id,

                    }

            };
            return result;
        },
        _saveModel: function () {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                vCurrent.submitStatus = 'error';

            } else {
                ajaxRequest(this.formConfig.url, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: vCurrent.tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: vCurrent.formConfig.loadingMessage,
                    error_message: vCurrent.formConfig.errorMessage,
                    success_message: vCurrent.formConfig.successMessage,
                    success_callback: function (response) {

                        if (response.success) {
                            // vCurrent._resetManagerGrid();
                            //  vCurrent.resetForm();
                            vCurrent.model.attributes.id = response.data.id;
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            // vCurrent._viewManager(2);
                        }
                    }
                });
            }
        },
        resetForm: function () {
            this.viewManagerPrint.print = false;
            this.printLabelConfig.numberPrint = 1;
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
//others functions
        _managerS2DeliveryByBusinessManagerAddress: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var keyCurrentManager = "address_id_data";
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes[keyCurrentManager]];
                var textCurrent = this.model.attributes[keyCurrentManager].text;
                var idCurrent = this.model.attributes[keyCurrentManager].id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var currentId = this.entity_id;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-delivery-by-business-manager-getListAddressByCustomer").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,

                            }

                        };
                        var allowCustomer = true;
                        if (allowCustomer) {
                            paramsFilters["filters"]["customer_id"] = currentId;
                        }
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes[keyCurrentManager] = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyCurrentManager] = null;
                _this._setValueForm(keyCurrentManager, null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        _managerS2DeliveryByBusinessManagerPhone: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var keyCurrentManager = "phone_id_data";
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes[keyCurrentManager]];
                var textCurrent = this.model.attributes[keyCurrentManager].text;
                var idCurrent = this.model.attributes[keyCurrentManager].id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;


            var currentId = this.entity_id;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-delivery-by-business-manager-getListPhoneByCustomer").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                            }
                        };
                        var allowCustomer = true;
                        if (allowCustomer) {
                            paramsFilters["filters"]["customer_id"] = currentId;
                        }
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes[keyCurrentManager] = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes[keyCurrentManager] = null;
                _this._setValueForm(keyCurrentManager, null);
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });
        },
        _setValueFormPrintValue: function (name, value) {

            this.printLabelConfig.numberPrint = value;
        },
        _setValueFormPrint: function (name, value) {

            this.viewManagerPrint.print = value;
        },
        getClassViewFormPrint: function (type, view) {
            var result = null;
            if (type == 'manager-content-data-form-print') {
                result = {
                    "not-view": !view,
                    'not-view-print': view
                };

            } else {
                result = {
                    "not-view": view,
                    'not-view-form': false
                };

            }

            return result;
        },
        allowViewPrint:function(){

            var allow=(this.printLabelConfig.numberPrint>0 && this.printLabelConfig.numberPrint <=this.$v.model.attributes.number_box.$model) && this.validateForm();
            console.log(allow);
            return allow;
        },
        _printLabelGenerate: function () {
            $("#print-data").printArea({
                popHt: 500,
                popWd: 400,
                popX: 500,
                popY: 600,
                popTitle: ".",
                popClose: true,
                //una url de donde esta el archivo del nuevo css
                extraCss: $configManagerProcessCurrent.design.css.delivery,
                strict: true
            });
        },
        _initCodeBar: function (params) {
            if (params.code) {
                var paramsCurrent = {element: $(params.objSelector), code: params.code};
                viewCode(paramsCurrent);
            }


        },
        getDataHtmlBody: function (type, numberBox = 0) {
            let result = [];


            var dataFormCurrent = this.$v.model.attributes;
            var pushCurrent = "";
            if (type == 'customerFullName') {
                pushCurrent = '' + "<span id='spanCustomerFullName'>" + (this.configParams.data.rowCurrent.name) + " " + this.configParams.data.rowCurrent.last_name + '-'+(this.configParams.data.rowCurrent.identification_document)+"</span>";
                result.push(
                    pushCurrent
                );
            } else if (type == 'customerIdentificationDocument') {
                pushCurrent = '' + "<h4  id='h4CustomerIdentificationDocument'>" + (this.configParams.data.rowCurrent.identification_document) + "</h4>";
                result.push(
                    pushCurrent
                );
            } else if (type == 'customerAddressIdData') {
                if (dataFormCurrent.address_id_data.$model) {

                    pushCurrent = '' + "" + (dataFormCurrent.address_id_data.$model.street_one) + ",";
                    result.push(
                        pushCurrent
                    );
                    pushCurrent = '' + "" + (dataFormCurrent.address_id_data.$model.street_two) + ".";
                    result.push(
                        pushCurrent
                    );
                }


            } else if (type == 'customerPhoneIdData') {
                if (dataFormCurrent.phone_id_data.$model) {
                    pushCurrent = '' + "" + (dataFormCurrent.phone_id_data.$model.information_phone) + "<br>";
                }
                result.push(
                    pushCurrent
                );
            } else if (type == 'description') {
                if (dataFormCurrent.description.$model) {
                    pushCurrent = '' + "" + (dataFormCurrent.description.$model);
                    result.push(
                        pushCurrent
                    );
                }

            } else if (type == 'numberBox') {
                if (dataFormCurrent.number_box.$model) {

                    pushCurrent = '' + numberBox + "/" + (dataFormCurrent.number_box.$model);
                    result.push(
                        pushCurrent
                    );
                }

            } else if (type == 'numberInvoice') {
                if (dataFormCurrent.number_invoice.$model) {
                    pushCurrent = '' + "" + (dataFormCurrent.number_invoice.$model);
                    result.push(
                        pushCurrent
                    );
                }

            } else if (type == 'id') {
                if (dataFormCurrent.id.$model) {
                    pushCurrent = '' + "" + (dataFormCurrent.id.$model);
                    result.push(
                        pushCurrent
                    );
                }

            }
            return result.join("");
        },
        getLimitIndex: function () {
            let result = 0;
            if (jQuery.type(this.$v.model.attributes.number_box.$model) == 'string') {
                result = parseInt(this.$v.model.attributes.number_box.$model);
            } else {
                result = (this.$v.model.attributes.number_box.$model);
            }
            console.log(result);
            return result;
        }

    }
})
;

function createCode($params) {
    $params.element.html("");
    $params.element.barcode($params.code, $params.type, {
        'barWidth': 4,
        'barHeight': 100,
        'color': '#343a40',
        'bgColor': '#ffffff',
        'fontSize': 30
    });
}

function viewCode(params) {
    $params = {element: params.element, code: params.code, type: "code128"};
    createCode($params);
}



