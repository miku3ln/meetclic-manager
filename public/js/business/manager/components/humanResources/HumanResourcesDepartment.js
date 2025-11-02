let  componentThisHumanResourcesDepartment;
Vue.component('human-resources-department-component', {

    template: '#human-resources-department-template',
    directives: {},
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        let  vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);

        });
    },
    beforeMount: function () {
        this.configParams = this.params;
        this.businessId = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        componentThisHumanResourcesDepartment = this;
        this.initCurrentComponent();
        removeClassNotView();

    },

    validations: function () {
        let  attributes = {
            id: {},
            name: {
                required,
            },
            description: {},

        };

        let  result = {
            model: {//change
                attributes: attributes
            },
        };
        return result;

    },
    data: function () {

        let  dataManager = {

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
                        "title": "Agregar Responsble",
                        "data-placement": "top",
                        "i-class": " remixicon-account-circle-line",
                        "managerType": "HumanResourcesDepartmentByManager"
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
            tabCurrentSelector: '#tab-humanResourcesDepartment',
            processName: "Registro de departamento.",
            formConfig: {
                nameSelector: "#business-by-human-resources-department-form",
                url: $('#action-human-resources-department-save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Nivel.',
                successMessage: 'El Departamento se guardo correctamente.',
                nameModel: "HumanResourcesDepartment"
            },
            gridConfig: {
                selectorCurrent: "#human-resources-department-grid",
                url: $("#action-human-resources-department-admin").val()
            },
            submitStatus: "no",
            showManager: false,
            businessId: null,
            managerType: null,
            //MODAL MANAGER
            configModalBusinessByEmployeeProfile: {
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
            let  gridName = this.gridConfig.selectorCurrent;
            let  urlCurrent = this.gridConfig.url;
            let  business_id = this.businessId;
            let  paramsFilters = {
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
                        let  description = (row.description !== "null" && row.description) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Observaciones:</span><span class='content-description__value'>" + (row.description) + "</span>",
                            "</div>",

                        ] : [];
                        description = description.join("");
                        let  result = [
                            "<div    class='content-description'>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre: </span><span class='content-description__value'>" + (row.name) + "</span>",
                            "</div>",

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
            let  vmCurrent = this;
            elementSelect.find("tbody tr").on("click", function (e) {
                let  self = $(this);
                let  dataRowId = $(self[0]).attr("data-row-id");
                let  selectorRow;
                if (dataRowId) {
                    let  instance_data_rows = $(vmCurrent.gridConfig.selectorCurrent).bootgrid("getCurrentRows");
                    let  rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    elementSelect.find("tr.selected").removeClass("selected");
                    let  newEventRow = false;
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        let  removeRowId = vmCurrent.managerMenuConfig.rowId;
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
            let  result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                let  setPush = {
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
            let  params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
        },
        _managerRowGrid: function (params) {
            let  rowCurrent = params.row;
            let  rowId = params.id;
            if (params.managerType == "updateEntity") {
                let  elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.description = rowCurrent.description;
                this._viewManager(3, rowId);
            }else if (params.managerType == "HumanResourcesDepartmentByManager") {
                console.log(rowCurrent);
           let     $scope=this;
                this.configModalBusinessByEmployeeProfile.data = {
                    businessId: this.businessId,
                    human_resources_department_id: rowCurrent.id,
                    human_resources_departmentName: rowCurrent.name
                };
                let dataSend = {
                    id: rowCurrent.id
                };
                ajaxRequest($('#action-human-resources-department-by-manager-getResponsible').val(), {
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
                            human_resources_department_id: rowCurrent.id,
                            human_resources_departmentName: rowCurrent.name

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
            let  result = false
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
            let  result = {

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
                            allow: false,
                            msj: "Campo requerido.",
                            error: false
                        }
                },

            };

            return result;
        },
        getAttributesForm: function () {
            let  result = {
                name: null,
                description: null,
            };

            return result;
        },
        getNameAttributePeople: function (index, name) {
            let  result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
            return result;
        },
        getNameAttribute: function (name) {
            let  result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        _setValueForm: function (name, value, position = null, model = null) {
            let  attributeCurrent;
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        setValueForm: function (name, value, position = null, model = null) {
            let  attributeCurrent;
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        getClassErrorForm: function (nameElement, objValidate) {

            let  result = null;
            result = {
                "form-group--error": objValidate.$error,
                'form-group--success': objValidate.$dirty ? (!objValidate.$error) : false
            };

            return result;
        },
        getErrorHas: function (model, type) {

            let  result = (model.$model == undefined || model.$model == "") ? true : false;
            return result;
        },
        getViewError: function (model) {
            let  result = (model.$dirty == true) ? true : false;
            return result;
        },
//Manager Model
        getValuesSave: function () {

            let  result = {
                HumanResourcesDepartment: {
                    id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    description: this.$v.model.attributes.description.$model,
                    name: this.$v.model.attributes.name.$model,
                    business_id: this.businessId
                }

            };


            return result;
        },
        _saveModel: function () {
            let  dataSendResult = this.getValuesSave();
            let  dataSend = dataSendResult;
            let  vCurrent = this;
            vCurrent.$v.$touch();
            let  validateCurrent = this.validateForm();
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
            let  currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getViewPeopleProcess: function () {
            let  haystack = this.$v.model.attributes.people.$each.$iter;
            let  result = Object.keys(haystack).length > 0
            return result;
        },
        allowDisabledPaymentMade: function () {
            let  result = false;
            if (this.$v.model.attributes.id.$model != null) {//create

                result = true;
            }
            return result;
        },
        getValidateForm: getValidateForm,


    }
})
;

