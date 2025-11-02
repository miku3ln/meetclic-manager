var componentThisActions;

Vue.component('actions-component', {

    template: '#actions-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Action({
                    objSelector: el, model: paramsInput.model

                });


            },
            bind: function (el, binding, vnode, vm, arg) {


            }
        },
        resetModel: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
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
        var vmCurrent = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            vmCurrent._managerTypes(emitValue);

        });
    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisActions = this;
        this.initCurrentComponent();
        console.log("mouted");
    },

    validations: function () {
        var attributes = {};

        if (!this.model.attributes.type_item) {

            if (this.model.attributes.type == this.typeMenuMain) {//root
                attributes = {
                    id: {},
                    name: {required},//
                    type_item: {},
                    link: {required},//
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
                    link: {required},//
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
                    link: {required},//
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
                    link: {},
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
                    link: {required},//
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
                    link: {required},//
                    parent_id_data: {required},
                    weight: {required},//
                    icon: {},
                    type: {required},
                    description: {required}

                };
            }
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

//**Modal*

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
            labelsConfig: {},
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-actions',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#actions-form",
                url: $('#action_actions_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar la acción.',
                successMessage: 'La Acción se guardo correctamente.',
                nameModel: "Actions"
            },
            gridConfig: {
                selectorCurrent: "#actions-grid",
                url: $("#action_actions_admin").val()
            },
            submitStatus: "no",
            showManager: false,
            businessId: null,
            managerType: null,
            dataType: [
                {id: 0, text: "Administración"},
                {id: 1, text: "Método"},
            ],
            typeMenuMain: 2,
            typeManager: 0,
            typeMethod: 1,

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
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var business_id = this.businessId;
            var paramsFilters = {
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

                        /*href='$linkCurrent' target='_blank'*/

                        var linkHtml = (row.type != vmCurrent.typeMenuMain && row.type != vmCurrent.typeMethod) ? [
                            "<a href='/" + row.link + "' target='_blank'>",
                            "Link Gestión",
                            "</a>",
                        ] : [row.link];
                        linkHtml = linkHtml.join("");
                        var linkDescription = row.type != vmCurrent.typeMenuMain ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Link:</span><span class='content-description__value'>" + linkHtml + "</span>",
                            "</div>",] : [];
                        var parentData = row.type != vmCurrent.typeMenuMain ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Menu Principal:</span><span class='content-description__value'>" + (row.parent) + "</span>",
                            "</div>",] : [];
                        parentData = parentData.join("");
                        var typeLabel = row.type == vmCurrent.typeMenuMain ? "Menu Principal" : (row.type == vmCurrent.typeManager ? "Sub Menu" : "Metodo del sistema");
                        linkDescription = linkDescription.join("");
                        var description = (row.name !== "null" && row.name) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + (typeLabel) + "</span>",
                            "</div>",
                            parentData,
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre:</span><span class='content-description__value'>" + (row.name) + "</span>",
                            "</div>",
                            linkDescription,
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Peso:</span><span class='content-description__value'>" + (row.weight) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Icono:</span><span class='content-description__value'>" + (row.icon) + "</span>",
                            "</div>",
                        ] : [];
                        description = description.join("");
                        var result = [

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
            var vmCurrent = this;
            elementSelect.find("tbody tr").on("click", function (e) {
                var self = $(this);
                var dataRowId = $(self[0]).attr("data-row-id");
                var selectorRow;
                if (dataRowId) {
                    var instance_data_rows = $(vmCurrent.gridConfig.selectorCurrent).bootgrid("getCurrentRows");
                    var rowData = searchElementJson(instance_data_rows, 'id', dataRowId);//asi s obtiene los valores del registro en funcion d su id
                    elementSelect.find("tr.selected").removeClass("selected");
                    var newEventRow = false;
                    if (vmCurrent.managerMenuConfig.rowId) {//ready selected
                        var removeRowId = vmCurrent.managerMenuConfig.rowId;
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
        _managerMenuGrid: function (index, menu) {
            var params = {managerType: menu.managerType, id: menu.rowId, row: menu.params.rowData};
            this._managerRowGrid(params);
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
                this.model.attributes.name = (rowCurrent.name);
                this.model.attributes.link = (rowCurrent.link);
                this.model.attributes.weight = (rowCurrent.weight);
                this.model.attributes.icon = (rowCurrent.icon);
                this.model.attributes.type = (rowCurrent.type);
                this.model.attributes.type_item = (rowCurrent.type_item == 1 ? true : false);
                this.model.attributes.description = (rowCurrent.description);
                this.model.attributes.parent_id_data = {
                    id: rowCurrent.parent_id,
                    text: rowCurrent.parent
                };
                this._viewManager(3, rowId);
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
                this.onInitEventClickTimerForm();//CHANGE-FORM
                this.managerType = 1;
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
                link: {
                    id: "link",
                    name: "link",
                    label: "Link",
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
                    label: "Menu Principal",
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
            var result = {
                name: null,
                link: null,
                parent_id_data: null,
                weight: null,
                icon: null,
                type: 0,
                type_item: false,
                "description": null
            };

            return result;
        },
        getNameAttributePeople: function (index, name) {
            var result = this.formConfig.nameModel + "[" + index + "][" + name + "]";
            return result;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,
        _typeItem: function (type) {

            var dataTypes = [];
            if (type) {
                this.$v.model.attributes["type"].$model = 2;
                dataTypes = [
                    {id: 2, text: "Menu Principal"},
                    {id: 0, text: "Administración"},
                    {id: 1, text: "Método"},
                ];
            } else {
                this.$v.model.attributes["type"].$model = 0;
                dataTypes = [
                    {id: 0, text: "Administración"},
                    {id: 1, text: "Método"},
                ];
            }
            this.dataType = dataTypes;
            this._setValueForm("type_item", type);
        },
        _setValueForm: function (name, value) {
            var attributeCurrent;
            if (name == "type") {
                this.$v.model.attributes["link"].$model = "";
                this.$v.model.attributes["link"].$reset();
                this.$v.model.attributes["parent_id_data"].$reset();
                if (value == 2) {//root
                    this.$v.model.attributes["link"].$model = "#";
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
                Actions: {
                    id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    name: this.$v.model.attributes.name.$model,
                    parent_id: this.$v.model.attributes.parent_id_data.$model == null ? null : this.$v.model.attributes.parent_id_data.$model.id,
                    weight: this.$v.model.attributes.weight.$model,
                    link: this.$v.model.attributes.link.$model,
                    icon: this.$v.model.attributes.icon.$model,
                    type: this.$v.model.attributes.type.$model,
                    type_item: this.$v.model.attributes.type_item.$model ? 1 : 0,
                    description: this.$v.model.attributes.description.$model,

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
                            if (vCurrent.$v.model.attributes.id.$model) {
                                vCurrent._viewManager(2);
                            }
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent.resetForm();
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
        getViewPeopleProcess: function () {
            var haystack = this.$v.model.attributes.people.$each.$iter;
            var result = Object.keys(haystack).length > 0
            return result;
        },
        allowDisabledPaymentMade: function () {
            var result = false;
            if (this.$v.model.attributes.id.$model != null) {//create

                result = true;
            }
            return result;
        },
        getValidateForm:getValidateForm,
        _resetModel: function (model) {
            model.$reset();

        },
        _managerS2Action: function (params) {
            var el = params.objSelector;
            var valueCurrent = params.model;
            var dataCurrent = [];
            if (valueCurrent) {

                dataCurrent = [this.model.attributes.parent_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Menu Principal",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action_actions_listActionsParent").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {filters: {search_value: term}};
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
                _this.model.attributes.parent_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.parent_id_data = null;
                _this._setValueForm('parent_id_data', null);
            });

        }

    }
})
;

