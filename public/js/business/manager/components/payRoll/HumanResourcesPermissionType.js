let configProcess = {//CPP-004
    'manager': UtilManagerCustomModel.getManagerData('human_resources_permission_type'),
    'component': null,
};
Vue.component(configProcess.manager.modelProcess + '-component', {

    template: '#' + configProcess.manager.modelProcess + '-template',
    directives: {
        initS2: {},
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
        this.businessId = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        configProcess.component = this;
        this.initCurrentComponent();
        removeClassNotView();

    },

    validations: function () {
        let attributes = {};

        attributes = {
            id: {},
            name: {required},//
            code: {required},//
            description: {},//
            status: {required},
            recoverable_permit: {},
            control_by_hours: {},
            control_by_hours_duration: {},


        };
        if (this.model.attributes.control_by_hours) {//has children

            attributes['control_by_hours_duration'] = {required};
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
            processName: "Registro de Planificacion.",
            formConfig: {
                nameSelector: "#business-by-" + configProcess.manager.modelProcess + "-form",
                url: $("#action-" + configProcess.manager.modelProcess + "-save").val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el ' + configProcess.manager.modelName + '.',
                successMessage: 'El ' + configProcess.manager.modelName + ' se guardo correctamente.',
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

            dataStatus: [
                {id: 'INACTIVE', text: "INACTIVO"},
                {id: 'ACTIVE', text: "ACTIVO"},
            ],

            //MODAL MANAGER
            configModalProjectHeaderByResources: {
                title: "Title",
                viewAllow: false,
                data: []

            },
            statusData: [{id: 'ACTIVE', value: 'ACTIVO'}, {id: 'INACTIVE', value: 'INACTIVO'}],

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

                        let hoursCurrent = row.control_by_hours == 1 ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Horas Máxima:</span><span class='content-description__value'>" + (row.control_by_hours_duration) + "</span>",
                            "</div>",
                        ] : [];

                        let classStatus = "badge-success";
                        if (row.status == "INACTIVE") {
                            classStatus = "badge-warning";
                        }
                        let classRecoverablePermit = "badge-success";
                        if (row.recoverable_permit == 0) {
                            classRecoverablePermit = "badge-warning";
                        }
                        let classControlByHours = "badge-success";
                        if (row.control_by_hours == 0) {
                            classControlByHours = "badge-warning";
                        }
                        let description = (row.name !== "null" && row.name) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span><span class='content-description__value'>" + "<span class='badge badge--size-large " + classStatus + "'>" + (row.status == 'ACTIVE' ? 'ACTIVO' : 'INACTIVO') + "</span>" + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Permiso Recuperable:</span><span class='content-description__value'>" + "<span class='badge badge--size-large " + classRecoverablePermit + "'>" + (row.recoverable_permit == 1 ? 'SI' : 'NO')+ "</span>" + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Control por horas:</span><span class='content-description__value'>" + "<span class='badge badge--size-large " + classControlByHours+ "'>" + (row.control_by_hours == 1 ? 'SI' : 'NO')+ "</span>" + "</span>",
                            "</div>",
                            hoursCurrent.join(''),

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Codigo:</span><span class='content-description__value'>" + (row.code) + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre:</span><span class='content-description__value'>" + (row.name) + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Descripcion:</span><span class='content-description__value'>" + (row.description == null ? '' : row.description) + "</span>",
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
            let $scope = this;
            let rowCurrent = params.row;
            let rowId = params.id;

            if (params.managerType == "updateEntity") {
                let elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.code = rowCurrent.code;
                this.model.attributes.status = (rowCurrent.status);
                this.model.attributes.control_by_hours_duration = rowCurrent.control_by_hours_duration;
                this.model.attributes.control_by_hours = rowCurrent.control_by_hours;
                this.model.attributes.recoverable_permit = rowCurrent.recoverable_permit;


                this._viewManager(3, rowId);
            } else if (params.managerType == "projectHeaderByResources") {

                let nameProcess = 'ProjectHeaderByResources';
                let managerKeys = {
                    ref: 'ref' + nameProcess,
                    config: 'configModal' + nameProcess,

                }
                this[managerKeys.config].data = {
                    businessId: this.businessId,
                    project_header_id: rowCurrent.id,
                    project_headerName: rowCurrent.name
                };


                if ($scope[managerKeys.config].viewAllow) {
                    $scope.$refs[managerKeys.ref]._setValueOfParent(
                        {
                            type: "openModal",
                            data: this[managerKeys.config]
                        }
                    );
                } else {
                    $scope[managerKeys.config].viewAllow = true;
                }

            }

        },
        /*  EVENTS*/
        onListenElementsForm: function (params) {

            params.objectElement.$touch();
        },
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

        _setValueForm: function (name, value) {


            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },

        getStructureForm: function () {
            let result = {
                status: {
                    id: "status",
                    name: "status",
                    label: "Estado",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
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
                code: {
                    id: "code",
                    name: "code",
                    label: "Codigo",
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
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                recoverable_permit: {
                    id: "recoverable_permit",
                    name: "recoverable_permit",
                    label: "Permiso Recuperable",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                control_by_hours: {
                    id: "control_by_hours",
                    name: "control_by_hours",
                    label: "Control por horas",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                control_by_hours_duration: {
                    id: "control_by_hours_duration",
                    name: "control_by_hours_duration",
                    label: "Horas Máxima",
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
                code: null,
                description: '',
                status: "ACTIVE",
                control_by_hours: false,
                control_by_hours_duration: null,
                recoverable_permit: false,


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
            let control_by_hours_duration = this.$v.model.attributes.control_by_hours.$model ? this.$v.model.attributes.control_by_hours_duration.$model : "0";
            let data = {

                id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                name: this.$v.model.attributes.name.$model,
                code: this.$v.model.attributes.code.$model,
                business_id: this.businessId,
                year: 2023,
                status: this.$v.model.attributes.status.$model,
                predetermined: 0,
                description: this.$v.model.attributes.description.$model,
                recoverable_permit: this.$v.model.attributes.recoverable_permit.$model ? 1 : 0,
                control_by_hours: this.$v.model.attributes.control_by_hours.$model ? 1 : 0,
                control_by_hours_duration: control_by_hours_duration,


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
//SELECT2
        onInitAdministrator: function (params) {

            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            if (valueCurrent) {
                dataCurrent = [this.model.attributes.administrator_human_resources_employee_profile_id_data];
            }
            let _this = this;

            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-human-resources-employee-profile-getFullNameListDataAreaAll").val(),
                    type: "get",
                    dataType: 'json',

                    data: function (term, page) {

                        return {
                            filters: {

                                manager_id: -1,
                                search_value: term,
                                businessId: _this.businessId
                            }
                        };
                    },
                    processResults: function (data, page) {

                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%',


            });
            elementInit.on("change", function (e) {
                let dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    _this.model.attributes.administrator_human_resources_employee_profile_id_data = dataCurrent[0];
                } else {
                    _this.model.attributes.administrator_human_resources_employee_profile_id_data = null;
                    _this._setValueForm('administrator_human_resources_employee_profile_id_data', null);

                }
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });


        },
        onInitHelpDesk: function (params) {

            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            if (valueCurrent) {
                dataCurrent = [this.model.attributes.help_desk_human_resources_employee_profile_id_data];
            }
            let _this = this;

            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-human-resources-employee-profile-getFullNameListDataAreaAll").val(),
                    type: "get",
                    dataType: 'json',

                    data: function (term, page) {

                        return {
                            filters: {

                                manager_id: -1,
                                search_value: term,
                                businessId: _this.businessId
                            }
                        };
                    },
                    processResults: function (data, page) {

                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%',


            });
            elementInit.on("change", function (e) {
                let dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    _this.model.attributes.help_desk_human_resources_employee_profile_id_data = dataCurrent[0];
                } else {
                    _this.model.attributes.help_desk_human_resources_employee_profile_id_data = null;
                    _this._setValueForm('help_desk_human_resources_employee_profile_id_data', null);

                }
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });


        },
        onInitCountries: function (params) {

            let el = params.objSelector;
            let valueCurrent = params.model;
            let dataCurrent = [];
            if (valueCurrent) {
                dataCurrent = [this.model.attributes.countries_id_data];
            }
            let _this = this;

            let elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-country-getListS2Countries").val(),
                    type: "get",
                    dataType: 'json',

                    data: function (term, page) {

                        return {
                            filters: {

                                manager_id: _this.manager_id,
                                search_value: term,
                                businessId: _this.businessId
                            }
                        };
                    },
                    processResults: function (data, page) {

                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: false,
                width: '100%',


            });
            elementInit.on("change", function (e) {
                let dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    _this.model.attributes.countries_id_data = dataCurrent[0];
                } else {
                    _this.model.attributes.countries_id_data = null;
                    _this._setValueForm('countries_id_data', null);

                }
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });


        },
    }
})
;

