var componentThisAccountingAccount;
Vue.component('accounting-account-component', {
    template: '#accounting-account-template',
    directives: {
        initS2AccountingAccountType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2AccountingAccountType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2AccountingLevel: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2AccountingLevel({
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
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });
    },
    beforeMount: function () {
        this.configParams = this.params;
    },
    mounted: function () {
        componentThisAccountingAccount = this;
        this.initCurrentComponent();

    },

    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(150)},
            "status": {required},
            "accounting_account_type_id_data": {required},
            "accounting_level_id_data": {required},
            "description": {required},
            "parent_key": {},
            "has_parent": {},
            "is_parent": {},
            "movement": {},
            "rfc": {},
            "cost_center": {},
            "base_amount": {},
            "base_amount_percentage": {},
            "base_amount_value": {}
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
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-accounting-account',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#accounting-account-form",
                url: $('#action-accounting-account-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el AccountingAccount.',
                successMessage: 'El AccountingAccount se guardo correctamente.',
                nameModel: "AccountingAccount"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#accounting-account-grid",
                url: $("#action-accounting-account-getAdmin").val()
            },
            submitStatus: "no",
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
                this.model.attributes.value = rowCurrent.value;
                this.model.attributes.status = rowCurrent.status;
                this.model.attributes.accounting_account_type_id_data = {
                    id: rowCurrent.accounting_account_type_id,
                    text: rowCurrent.accounting_account_type
                };
                this.model.attributes.accounting_level_id_data = {
                    id: rowCurrent.accounting_level_id,
                    text: rowCurrent.accounting_level
                };
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.parent_key = rowCurrent.parent_key;
                this.model.attributes.has_parent = rowCurrent.has_parent == 1 ? true : false;
                this.model.attributes.is_parent = rowCurrent.is_parent == 1 ? true : false;
                this.model.attributes.movement = rowCurrent.movement == 1 ? true : false;
                this.model.attributes.rfc = rowCurrent.rfc == 1 ? true : false;
                this.model.attributes.cost_center = rowCurrent.cost_center == 1 ? true : false;
                this.model.attributes.base_amount = rowCurrent.base_amount == 1 ? true : false;
                this.model.attributes.base_amount_percentage = parseFloat(rowCurrent.base_amount_percentage);
                this.model.attributes.base_amount_value = parseFloat(rowCurrent.base_amount_value);

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {};
            let gridInit = $(gridName);
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
                        var result = [
                            "<div class='content-description'>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>value:</span><span class='content-description__value'>" + row.value + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>status:</span><span class='content-description__value'>" + row.status + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>accounting account type id:</span><span class='content-description__value'>" + row.accounting_account_type + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>accounting level id:</span><span class='content-description__value'>" + row.accounting_level + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>description:</span><span class='content-description__value'>" + row.description + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>parent key:</span><span class='content-description__value'>" + row.parent_key + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>has parent:</span><span class='content-description__value'>" + row.has_parent + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>is parent:</span><span class='content-description__value'>" + row.is_parent + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>movement:</span><span class='content-description__value'>" + row.movement + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>rfc:</span><span class='content-description__value'>" + row.rfc + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>cost center:</span><span class='content-description__value'>" + row.cost_center + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>base amount:</span><span class='content-description__value'>" + row.base_amount + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>base amount percentage:</span><span class='content-description__value'>" + row.base_amount_percentage + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>base amount value:</span><span class='content-description__value'>" + row.base_amount_value + "</span>",
                            "</div>"
                            ,
                            "</div>",
                        ];

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
                this.showManager = true;
                this.managerMenuConfig.view = false;
                $(this.gridConfig.selectorCurrent + "-header").hide();
                $(this.gridConfig.selectorCurrent + "-footer").hide();
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM

            } else if (typeView == 2) {//admin
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
                    value:
                        {
                            id: "value",
                            name: "value",
                            label: "value",
                            required:
                                {
                                    allow: true,
                                    msj: "Campo requerido.",
                                    error: false
                                },
                            maxLength: {
                                msj: "# Carecteres Excedidos a 150.",
                            },
                        }
                    ,
                    status:
                        {
                            id: "status", name: "status", label: "status",
                            required:
                                {
                                    allow: true, msj: "Campo requerido.",
                                    error: false
                                }
                            ,
                            options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                        }
                    ,
                    accounting_account_type_id_data:
                        {
                            id: "accounting_account_type_id_data",
                            name: "accounting_account_type_id_data",
                            label: "accounting account type id",

                            required: {
                                allow: true, msj: "Campo requerido.", error: false
                            }
                            ,
                        }
                    ,
                    accounting_level_id_data: {
                        id: "accounting_level_id_data",
                        name: "accounting_level_id_data",
                        label: "accounting level id",
                        required:
                            {
                                allow: true, msj: "Campo requerido.", error: false
                            }
                    }
                    ,
                    description: {
                        id: "description",
                        name: "description",
                        label: "description",
                        required:
                            {
                                allow: true, msj: "Campo requerido.", error: false
                            }

                    }
                    , parent_key: {
                        id: "parent_key",
                        name: "parent_key", label: "parent key", required:
                            {
                                allow: false, msj: "Campo requerido.", error: false
                            }

                    }
                    ,
                    has_parent: {
                        id: "has_parent",
                        name: "has_parent",
                        label: "has parent",
                        required:
                            {
                                allow: false, msj: "Campo requerido.",
                                error: false
                            }

                    }
                    ,
                    is_parent: {
                        id: "is_parent",
                        name:
                            "is_parent", label: "is parent",
                        required:
                            {
                                allow: false, msj: "Campo requerido.", error: false
                            }

                    }
                    ,
                    movement: {
                        id: "movement",
                        name: "movement",
                        label: "movement",
                        required: {
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                    }
                    , rfc:
                        {
                            id: "rfc",
                            name: "rfc",
                            label: "rfc", required:
                                {
                                    allow: false,
                                    msj: "Campo requerido.", error: false
                                }

                        }
                    ,
                    cost_center:
                        {
                            id: "cost_center", name: "cost_center",
                            label: "cost center",
                            required:
                                {
                                    allow: false,
                                    msj: "Campo requerido.",
                                    error: false
                                }

                        }
                    ,
                    base_amount: {
                        id: "base_amount",
                        name: "base_amount",
                        label: "base amount",
                        required:
                            {
                                allow: false, msj: "Campo requerido.",
                                error: false
                            }

                    }
                    ,
                    base_amount_percentage: {
                        id: "base_amount_percentage",
                        name: "base_amount_percentage",
                        label: "base amount percentage",
                        required:
                            {
                                allow: false, msj: "Campo requerido.",
                                error: false
                            }

                    }
                    ,
                    base_amount_value: {
                        id: "base_amount_value",
                        name: "base_amount_value",
                        label: "base amount value",
                        required:
                            {
                                allow: false,
                                msj: "Campo requerido.", error: false
                            }

                    }

                }
            ;
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "value": null,
                "status": null,
                "accounting_account_type_id_data": null,
                "accounting_level_id_data": null,
                "description": null,
                "parent_key": null,
                "has_parent": null,
                "is_parent": null,
                "movement": null,
                "rfc": null,
                "cost_center": null,
                "base_amount": null,
                "base_amount_percentage": null,
                "base_amount_value": null
            };
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
                AccountingAccount:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "value": this.$v.model.attributes.value.$model,
                        "status": this.$v.model.attributes.status.$model,
                        "accounting_account_type_id": this.$v.model.attributes.accounting_account_type_id_data.$model.id,
                        "accounting_level_id": this.$v.model.attributes.accounting_level_id_data.$model.id,
                        "description": this.$v.model.attributes.description.$model,
                        "parent_key": this.$v.model.attributes.parent_key.$model,
                        "has_parent": this.$v.model.attributes.has_parent.$model == null ? 0 : (this.$v.model.attributes.has_parent.$model ? 1 : 0),
                        "is_parent": this.$v.model.attributes.is_parent.$model == null ? 0 : (this.$v.model.attributes.is_parent.$model ? 1 : 0),
                        "movement": this.$v.model.attributes.movement.$model == null ? 0 : (this.$v.model.attributes.movement.$model ? 1 : 0),
                        "rfc": this.$v.model.attributes.rfc.$model == null ? 0 : (this.$v.model.attributes.rfc.$model ? 1 : 0),
                        "cost_center": this.$v.model.attributes.cost_center.$model == null ? 0 : (this.$v.model.attributes.cost_center.$model ? 1 : 0),
                        "base_amount": this.$v.model.attributes.base_amount.$model == null ? 0 : (this.$v.model.attributes.base_amount.$model ? 1 : 0),
                        "base_amount_percentage": this.$v.model.attributes.base_amount_percentage.$model,
                        "base_amount_value": this.$v.model.attributes.base_amount_value.$model

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
                            vCurrent._resetManagerGrid();
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent._viewManager(2);
                        }
                    }
                });
            }
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
        getValidateForm:getValidateForm,
//others functions
        _managerS2AccountingAccountType: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.accounting_account_type_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-accounting-account-type-getListSelect2").val(),
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
                _this.model.attributes.accounting_account_type_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.lodging_room_levels_id_data = null;
                _this._setValueForm('accounting_account_type_id_data', null);
            });
        }, _managerS2AccountingLevel: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId
            var dataCurrent = [];
            if (valueCurrentRowId) {
                ;
                dataCurrent = [this.model.attributes.accounting_level_id_data];
            }
            var _this = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-accounting-level-getListSelect2").val(),
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
                _this.model.attributes.accounting_level_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.lodging_room_levels_id_data = null;
                _this._setValueForm('accounting_level_id_data', null);
            });
        },
    }
})
;



