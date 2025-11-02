let configProcess = {//CPP-004
    'manager': UtilManagerCustomModel.getManagerData('human_resources_organizational_chart_area'),
    'nameProcess': 'Area',
    'component': null,
};
Vue.component(configProcess.manager.modelProcess + '-component', {

    template: '#' + configProcess.manager.modelProcess + '-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                paramsInput._managerS2Action({
                    objSelector: el, model: paramsInput.model

                });


            },
            bind: function (el, binding, vnode, vm, arg) {


            }
        },
        resetModel: {
            inserted: function (el, binding, vnode, vm, arg) {
                let paramsInput = binding.value;
                paramsInput._resetModel(paramsInput.model);


            },
        }

    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        let vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);

        });
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.businessId =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        configProcess.component = this;
        this.initCurrentComponent();
        removeClassNotView();

    },

    validations: function () {
        let attributes = {};

        if (!this.model.attributes.type_item) {

            if (this.model.attributes.type == this.typeMenuMain) {//root
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    parent_id_data: {},
                    weight: {required},//
                    icon: {required},//
                    type: {required},
                    description: {required}

                };
            } else if (this.model.attributes.type == this.typeMethod) {
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    parent_id_data: {},
                    weight: {required},//
                    icon: {},
                    type: {required},
                    description: {required}

                };
            } else if (this.model.attributes.type == this.typeManager) {
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    parent_id_data: {},
                    weight: {required},//
                    icon: {required},
                    type: {required},
                    description: {required}

                };
            }
        } else {

            if (this.model.attributes.type == this.typeMenuMain) {//root
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    parent_id_data: {},
                    weight: {required},//
                    icon: {required},//
                    type: {required},
                    description: {required}

                };
            } else if (this.model.attributes.type == this.typeManager) {
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    parent_id_data: {required},
                    weight: {required},//
                    icon: {required},
                    type: {required},
                    description: {required}

                };
            } else if (this.model.attributes.type == this.typeMethod) {
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    parent_id_data: {required},
                    weight: {required},//
                    icon: {},
                    type: {required},
                    description: {required}

                };
            }
        }

        let result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        let dataManager = {

//**Modal*

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
                        "title": "Agregar Responsable",
                        "data-placement": "top",
                        "i-class": " remixicon-account-circle-line",
                        "managerType": "humanResourcesOrganizationalChartAreaByManager"
                    },
                    {
                        "title": "Agregar Departamentos",
                        "data-placement": "top",
                        "i-class": " fa  fa-sitemap",
                        "managerType": "humanResourcesDepartmentByOrganizationalChartArea"
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
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-' + configProcess.manager.modelNameLowerFirst,
            processName: "Registro de departamento.",
            formConfig: {
                nameSelector: "#business-by-" + configProcess.manager.modelProcess + "-form",
                url: $("#action-" + configProcess.manager.modelProcess + "-save").val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + configProcess.nameProcess + '.',
                successMessage: 'El ' + configProcess.nameProcess + ' se guardo correctamente.',
                nameModel: configProcess.manager.modelName
            },
            gridConfig: {
                selectorCurrent: "#" + configProcess.manager.modelProcess + "-grid",
                url: $("#action-" + configProcess.manager.modelProcess + "-admin").val()
            },
            submitStatus: "no",
            showManager: false,
            businessId: null,
            managerType: null,

            dataType: [
                {id: 0, text: "Sin Descendencia"},
                //{id: 1, text: "Método"},
            ],
            typeMenuMain: 2,
            typeManager: 0,
            typeMethod: 1,

            //MODAL MANAGER
            configModalBusinessByEmployeeProfile: {
                title: "Title",
                viewAllow: false,
                data: []

            },
            configModalHumanResourcesDepartmentByOrganizationalChartArea: {
                title: "Title",
                viewAllow: false,
                data: []

            },
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        //EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        initCurrentComponent: function () {
            this.initGridManager(this);

        },
        /*---MODAL CURRENT--*/
        _closeModal: function () {
            closeModal();
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
        initGridManager: function (vmCurrent) {
            let gridName = this.gridConfig.selectorCurrent;
            let urlCurrent = this.gridConfig.url;
            let business_id = this.businessId;
            let paramsFilters = {
                business_id: business_id
            };
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

                        let typeData = [];
                        let parentData = [];
                        let typeLabel = "";
                        if (row.parent_id == null) {
                            typeLabel = row.type == vmCurrent.typeMenuMain ? "Menu Principal" : (row.type == vmCurrent.typeManager ? "Sub Menu" : "Metodo del sistema");
                            if (row.type == 0 && row.type_item == 0) {
                                parentData = [];
                                typeLabel = "Sin Desendencia.";
                                typeData = ["<div class='content-description__information'>",
                                    "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + (typeLabel) + "</span>",
                                    "</div>"];
                            } else if (row.type == vmCurrent.typeMenuMain && row.type_item == 1) {
                                typeLabel = "Con Desendencia.";
                                typeData = ["<div class='content-description__information'>",
                                    "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + (typeLabel) + "</span>",
                                    "</div>"];


                            }
                        } else {
                            if (row.type == 0 && row.type_item == 1) {
                                if (row.parentData) {
                                    parentData = [
                                        "<div class='content-description__information'>",
                                        "   <span class='content-description__title'>Principal:</span><span class='content-description__value'>" + (row.parentData.name) + "</span>",
                                        "</div>"];
                                }
                            }
                        }

                        parentData = parentData.join("");
                        let description = (row.name !== "null" && row.name) ? [
                            typeData.join(""),
                            parentData,
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre:</span><span class='content-description__value'>" + (row.name) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Peso:</span><span class='content-description__value'>" + (row.weight) + "</span>",
                            "</div>",
                        ] : [];
                        description = description.join("");
                        let result = [

                            description,
                            "</div>"
                        ];
                        return result.join("");
                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        _gridManager: function (elementSelect) {
            let vmCurrent = this;
            elementSelect.find("tbody tr").on("click", function (e) {
                let self = $(this);
                let dataRowId = $(self[0]).attr("data-row-id");
                let selectorRow;
                if (dataRowId) {
                    let instance_data_rows = $(vmCurrent.gridConfig.selectorCurrent).bootgrid("getCurrentRows");
                    let rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    elementSelect.find("tr.selected").removeClass("selected");
                    let newEventRow = false;
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        let removeRowId = vmCurrent.managerMenuConfig.rowId;
                        if (dataRowId == removeRowId) {
                            selectorRow = vmCurrent.gridConfig.selectorCurrent + " tr[data-row-id='" + removeRowId + "']";
                            $(selectorRow).removeClass("selected");
                            vmCurrent._resetManagerGrid();
                        } else {

                            newEventRow = true;
                        }
                    } else {
                        newEventRow = true;
                    }
                    if (newEventRow) {
                        selectorRow = vmCurrent.gridConfig.selectorCurrent + " tr[data-row-id='" + dataRowId + "']";
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
        getMenuConfig: function (params) {
            let result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                let setPush = {
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
            let params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
        },
        _managerRowGrid: function (params) {
            let rowCurrent = params.row;
            let rowId = params.id;
            let $scope = this;
            if (params.managerType == "updateEntity") {
                let elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.weight = (rowCurrent.weight);
                this.model.attributes.icon = (rowCurrent.icon);
                this.model.attributes.type = (rowCurrent.type);
                this.model.attributes.type_item = (rowCurrent.type_item == 1 ? true : false);
                if (rowCurrent.parent_id != null) {
                    this.model.attributes.parent_id_data = {
                        id: rowCurrent.parentData.id,
                        text: rowCurrent.parentData.name
                    };
                }
                this.dataType = this.getTypeUpdateItem(rowCurrent);
                this._viewManager(3, rowId);
            } else if (params.managerType == "humanResourcesOrganizationalChartAreaByManager") {
                this.configModalBusinessByEmployeeProfile.data = {
                    businessId: this.businessId,
                    human_resources_organizational_chart_area_id: rowCurrent.id,
                    human_resources_organizational_chart_areaName: rowCurrent.name
                };
                let dataSend = {
                    id: rowCurrent.id
                };
                ajaxRequest($('#action-human-resources-organizational-chart-area-by-manager-getResponsible').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $('.content-manager-grid'),//opcional: es para bloquear el elemento
                    loading_message: 'Gestionando...',
                    error_message: "No se realizo la gestion.!",
                    success_message: 'Realizado correctamente.',
                    success_callback: function (response) {
                        console.log(response);

                        $scope.configModalBusinessByEmployeeProfile.data = {
                            businessId: $scope.businessId,
                            human_resources_organizational_chart_area_id: rowCurrent.id,
                            human_resources_organizational_chart_areaName: rowCurrent.name

                        };
                        if (Object.keys(response).length) {

                            $scope.configModalBusinessByEmployeeProfile.data.id = response.id;
                            $scope.configModalBusinessByEmployeeProfile.data.human_resources_employee_profile_id = response.human_resources_employee_profile_id;
                            $scope.configModalBusinessByEmployeeProfile.data.fullName = response.fullName;
                            $scope.configModalBusinessByEmployeeProfile.data.range = response.range;
                            $scope.configModalBusinessByEmployeeProfile.data.type_manager = response.type_manager;

                        }
                        if ($scope.configModalBusinessByEmployeeProfile.viewAllow) {
                            $scope.$refs.refBusinessByEmployeeProfile._setValueOfParent(
                                {type: "openModal", data: $scope.configModalBusinessByEmployeeProfile}
                            );
                        } else {
                            $scope.configModalBusinessByEmployeeProfile.viewAllow = true;
                        }
                    }
                });

            }else if (params.managerType == "humanResourcesDepartmentByOrganizationalChartArea") {
                this.configModalHumanResourcesDepartmentByOrganizationalChartArea.data = {
                    businessId: this.businessId,
                    human_resources_organizational_chart_area_id: rowCurrent.id,
                    human_resources_organizational_chart_areaName: rowCurrent.name
                };
                let dataSend = {
                    id: rowCurrent.id
                };
                ajaxRequest($('#action-human-resources-department-by-organizational-chart-area-getDataByChartArea').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: $('.content-manager-grid'),//opcional: es para bloquear el elemento
                    loading_message: 'Gestionando...',
                    error_message: "No se realizo la gestion.!",
                    success_message: 'Realizado correctamente.',
                    success_callback: function (response) {
                        $scope.configModalHumanResourcesDepartmentByOrganizationalChartArea.data = {
                            businessId: $scope.businessId,
                            human_resources_organizational_chart_area_id: rowCurrent.id,
                            human_resources_organizational_chart_areaName: rowCurrent.name,
                            departments:[]

                        };
                        if (Object.keys(response).length) {

                            $scope.configModalHumanResourcesDepartmentByOrganizationalChartArea.data.departments = response;


                        }
                        if ($scope.configModalHumanResourcesDepartmentByOrganizationalChartArea.viewAllow) {
                            $scope.$refs.refHumanResourcesDepartmentByOrganizationalChartArea._setValueOfParent(
                                {type: "openModal", data: $scope.configModalHumanResourcesDepartmentByOrganizationalChartArea}
                            );
                        } else {
                            $scope.configModalHumanResourcesDepartmentByOrganizationalChartArea.viewAllow = true;
                        }
                    }
                });

            }

        },
        /*  EVENTS*/
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
        /*FORM*/
        getViewErrorForm: function (objValidate) {
            let result = false
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
        getTypeUpdateItem: function (row) {
            let vmCurrent = this;
            let result = [];
            if (row.parent_id == null) {

                if (row.type == 0 && row.type_item == 0) {

                    result = [
                        {id: 0, text: "Sin Descendencia"},
                        // {id: 1, text: "Método"},
                    ];
                } else if (row.type == vmCurrent.typeMenuMain && row.type_item == 1) {
                    result = [
                        {id: 2, text: "Principal"},
                        {id: 0, text: "Padre Area"},
                        //{id: 1, text: "Método"},
                    ];
                }
            } else {
                if (row.type == 0 && row.type_item == 1) {
                    if (row.parentData) {
                        result = [
                            {id: 2, text: "Principal"},
                            {id: 0, text: "Padre Area"},
                            //{id: 1, text: "Método"},
                        ];
                    }
                }
            }
            return result;
        },
        _typeItem: function (type) {

            let dataTypes = [];
            if (type) {
                this.$v.model.attributes["type"].$model = 2;
                dataTypes = [
                    {id: 2, text: "Principal"},
                    {id: 0, text: "Padre Area"},
                    //{id: 1, text: "Método"},
                ];
            } else {
                this.$v.model.attributes["type"].$model = 0;
                dataTypes = [
                    {id: 0, text: "Sin Descendencia"},
                    // {id: 1, text: "Método"},
                ];
            }
            this.dataType = dataTypes;
            this._setValueForm("type_item", type);
        },
        _setValueForm: function (name, value) {
            let attributeCurrent;
            if (name == "type") {

                this.$v.model.attributes["parent_id_data"].$reset();
                if (value == 2) {//root

                } else if (value == 1) {//sub menu

                } else if (value == 0) {// method
                    this.$v.model.attributes["icon"].$reset();
                    this.$v.model.attributes["icon"].$model = "not-icon";
                }
            }
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        _managerS2Action: function (params) {
            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            if (valueCurrent) {

                dataCurrent = [this.model.attributes.parent_id_data];
            }
            let _this = this;
            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Area Principal",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action_actions_listActionsParent").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        let paramsFilters = {filters: {search_value: term, businessId: _this.businessId}};
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
                let data = e.params.data;
                _this.model.attributes.parent_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.parent_id_data = null;
                _this._setValueForm('parent_id_data', null);
            });

        },
        getStructureForm: function () {
            let result = {

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
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripción",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                parent_id_data: {
                    id: "parent_id_data",
                    name: "parent_id_data",
                    label: "Principal",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                weight: {
                    id: "weight",
                    name: "weight",
                    label: "Posición",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                icon: {
                    id: "icon",
                    name: "icon",
                    label: "Icono Class",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                type: {
                    id: "type",
                    name: "type",
                    label: "Tipo",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

                type_item: {
                    id: "type_item",
                    name: "type_item",
                    label: "Tiene Items",
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
            let result = {
                name: null,
                description: null,
                parent_id_data: null,
                weight: null,
                icon: 'fa fa-developer',
                type: 0,
                type_item: false,
            };

            return result;
        },
        getNameAttributePeople: function (index, name) {
            let result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
            return result;
        },
        getNameAttribute: function (name) {
            let result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, value, position = null, model = null) {
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        setValueForm: function (name, value, position = null, model = null) {
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        getClassErrorForm: function (nameElement, objValidate) {

            let result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        },
        getErrorHas: function (model, type) {
            let result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            let result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {

            let data = {

                id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                name: this.$v.model.attributes.name.$model,
                business_id: this.businessId,
                parent_id: this.$v.model.attributes.parent_id_data.$model == null ? null : this.$v.model.attributes.parent_id_data.$model.id,
                weight: this.$v.model.attributes.weight.$model,
                icon: this.$v.model.attributes.icon.$model,
                type: this.$v.model.attributes.type.$model,
                type_item: this.$v.model.attributes.type_item.$model ? 1 : 0,
                description: this.$v.model.attributes.description.$model,

            };
            let result = {};
            result[configProcess.manager.modelName] = data;
            return result;
        },
        _saveModel: function () {
            let dataSendResult = this.getValuesSave();
            let dataSend = dataSendResult;
            let vCurrent = this;
            vCurrent.$v.$touch();
            let validateCurrent = this.validateForm();
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
            let currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getViewPeopleProcess: function () {
            let haystack = this.$v.model.attributes.people.$each.$iter;
            let result = Object.keys(haystack).length > 0
            return result;
        },
        allowDisabledPaymentMade: function () {
            let result = false;
            if (this.$v.model.attributes.id.$model != null) {//create

                result = true;
            }
            return result;
        },
        getValidateForm: getValidateForm,


    }
})
;

