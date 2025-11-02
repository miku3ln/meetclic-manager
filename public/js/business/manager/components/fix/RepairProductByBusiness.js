var componentThisRepairProductByBusiness;
Vue.component("repair-product-by-business-component", {
    template: "#repair-product-by-business-template",
    props: {
        params: {
            type: Object
        }
    },
    created: function() {
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function(emitValue) {
            vmCurrent._managerTypes(emitValue);
        });
    },
    beforeMount: function() {
        this.configParams = this.params;

        this.business_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function() {
        componentThisRepairProductByBusiness = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function() {
        var attributes = {
            id: {},
            name: { required },
            state: { required },
            description: {},
            business_id_data: {}
        };
        var result = {
            model: {
                //change
                attributes: attributes
            }
        };
        return result;
    },
    data: function() {
        var dataManager = {
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                buttonsManagements: [
                    {
                        title: "Actualizar",
                        "data-placement": "top",
                        "i-class": " fas fa-pencil-alt",
                        managerType: "updateEntity"
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
                buttons: { create: "Crear", update: "Actualizar" }
            },

            //form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            },
            tabCurrentSelector: "#tab-repair-product-by-business",
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#repair-product-by-business-form",
                url: $("#action-repair-product-by-business-saveData").val(),
                loadingMessage: "Guardando...",
                errorMessage: "Error al guardar el RepairProductByBusiness.",
                successMessage:
                    "El RepairProductByBusiness se guardo correctamente.",
                nameModel: "RepairProductByBusiness"
            },
            //Grid config
            gridConfig: {
                selectorCurrent: "#repair-product-by-business-grid",
                url: $("#action-repair-product-by-business-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null
        };

        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        initCurrentComponent: function() {
            this.initGridManager(this);
        },

        //EVENTS OF CHILDREN
        _managerTypes: function(emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");
            }
        },
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: function(params) {
            var $msjCurrent = params.msj;
            var $titleCurrent = params.title;
            var $typeCurrent = params.type;

            this.$notify({
                type: $typeCurrent,
                title: $titleCurrent,
                duration: 0,
                content: $msjCurrent
            }).then(() => {
                // resolve after dismissed
                console.log("dismissed");
            });
        },
        //MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: function(selector) {
            $(selector).tooltip("hide");
        },
        _resetManagerGrid: function() {
            this.managerMenuConfig = {
                view: false,
                menuCurrent: [],
                rowId: null
            };
        },
        _managerMenuGrid: function(index, menu) {
            var params = {
                managerType: menu.managerType,
                id: menu.rowId,
                row: menu.params.rowData
            };
            this._managerRowGrid(params);
        },
        getMenuConfig: function(params) {
            var result = [];
            $.each(this.configModelEntity["buttonsManagements"], function(
                key,
                value
            ) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value,
                    rowId: params.rowId,
                    managerType: value["managerType"],
                    params: params,
                    isUrl: value["isUrl"],
                    url: value["url"]
                };
                result.push(setPush);
            });
            return result;
        },
        _gridManager: function(elementSelect) {
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: vmCurrent,
                elementSelect: elementSelect
            });
        },
        _managerRowGrid: function(params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "updateEntity") {
                var elementDestroy = "#a-menu-" + this.managerMenuConfig.rowId;
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.description = rowCurrent.description;
                this.model.attributes.business_id_data = {
                    id: rowCurrent.business_id,
                    text: rowCurrent.business
                };

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function(vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                business_id: this.business_id
            };
            var structure = vmCurrent.model.structure;

            var formatters = {
                description: function(column, row) {
                    var classStatus = "badge-success";
                    if (row.status == "INACTIVE") {
                        classStatus = "badge-warning";
                    }
                    var result = [
                        "<div class='content-description'>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                            structure.state.label +
                            ":</span><span class='content-description__value'><span class='badge badge--size-large " +
                            classStatus +
                            " '>" +
                            row.state +
                            "</span></span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                            structure.name.label +
                            ":</span><span class='content-description__value'>" +
                            row.name +
                            "</span>",
                        "</div>",
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                            structure.description.label +
                            ":</span><span class='content-description__value'>" +
                            row.description +
                            "</span>",
                        "</div>",
                        "</div>"
                    ];

                    return result.join("");
                }
            };

            let gridInit = initGridManager({
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                urlCurrent: urlCurrent
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function() {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function(typeView, rowId) {
            if (typeView == 1) {
                //create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true
                });
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {
                //admin
                this.showManager = false;

                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: false
                });
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;
                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {
                //update
                this.showManager = true;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true
                });
                this.managerMenuConfig.view = false;
                this.managerType = 3;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            }
        },
        //FORM CONFIG
        getViewErrorForm: function(objValidate) {
            var result = false;
            if (!objValidate.$dirty) {
                result = objValidate.$dirty ? !objValidate.$error : false;
            } else {
                result = objValidate.$error;
            }
            return result;
        },
        _submitForm: function(e) {
            console.log(e);
        },
        getStructureForm: function() {
            var result = {
                name: {
                    id: "name",
                    name: "name",
                    label: "Nombre",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
                },
                state: {
                    id: "state",
                    name: "state",
                    label: "Estado",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [
                        { value: "ACTIVE", text: "ACTIVE" },
                        { value: "INACTIVE", text: "INACTIVE" }
                    ]
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripcion",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    }
                },
                business_id_data: {
                    id: "business_id_data",
                    name: "business_id_data",
                    label: "business id",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    }
                }
            };
            return result;
        },
        getAttributesForm: function() {
            var result = {
                id: null,
                name: null,
                state: "ACTIVE",
                description: null,
                business_id_data: null
            };
            return result;
        },

        getNameAttribute: function(name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,


        _setValueForm: function(name, value) {
            this.model.attributes[name] = value;
            this.$v["model"]["attributes"][name].$model = value;
            this.$v["model"]["attributes"][name].$touch();
        },
        getClassErrorForm: function(nameElement, objValidate) {
            var result = null;
            result = {
                "form-group--error": objValidate.$error,
                "form-group--success": objValidate.$dirty
                    ? !objValidate.$error
                    : false
            };

            return result;
        },
        //Manager Model

        getValuesSave: function() {
            var result = {
                RepairProductByBusiness: {
                    id: this.$v.model.attributes.id.$model
                        ? this.$v.model.attributes.id.$model
                        : -1,
                    name: this.$v.model.attributes.name.$model,
                    state: this.$v.model.attributes.state.$model,
                    description: this.$v.model.attributes.description.$model,
                    business_id: this.business_id
                }
            };

            return result;
        },
        _saveModel: function() {
            var dataSendResult = this.getValuesSave();
            var dataSend = dataSendResult;
            var vCurrent = this;
            vCurrent.$v.$touch();
            var validateCurrent = this.validateForm();
            if (!validateCurrent) {
                vCurrent.submitStatus = "error";
            } else {
                ajaxRequest(this.formConfig.url, {
                    type: "POST",
                    data: dataSend,
                    blockElement: vCurrent.tabCurrentSelector, //opcional: es para bloquear el elemento
                    loading_message: vCurrent.formConfig.loadingMessage,
                    error_message: vCurrent.formConfig.errorMessage,
                    success_message: vCurrent.formConfig.successMessage,
                    success_callback: function(response) {
                        if (response.success) {
                            vCurrent._resetManagerGrid();
                            vCurrent.resetForm();
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid(
                                "reload"
                            );
                            vCurrent._viewManager(2);
                        }
                    }
                });
            }
        },
        resetForm: function() {
            this.$v.$reset();
            this.model = {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm()
            };
            this.model.attributes.id = null;
        },
        _valuesForm: function(event) {
            this.model.init = false;
            this.validateForm();
        },
        validateForm: function() {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },

        getValidateForm:getValidateForm,
        //others functions
        _managerS2Business: function(params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.business_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-business-getListSelect2").val(),
                    type: "get",
                    dataType: "json",
                    data: function(term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function(data, page) {
                        return { results: data };
                    }
                },
                allowClear: true,
                multiple: false,
                width: "100%"
            });

            elementInit
                .on("select2:select", function(e) {
                    var data = e.params.data;
                    _this.model.attributes.business_id_data = data;
                })
                .on("select2:unselecting", function(e) {
                    _this.model.attributes.lodging_room_levels_id_data = null;
                    _this._setValueForm("business_id_data", null);
                });
        }
    }
});
