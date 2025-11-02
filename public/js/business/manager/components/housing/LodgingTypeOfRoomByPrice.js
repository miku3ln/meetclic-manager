var componentThisLodgingTypeOfRoomByPrice;
Vue.component('lodging-type-of-room-by-price-component', {

    template: '#lodging-type-of-room-by-price-template',
    directives: {
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2TypesOfRoom({
                    objSelector: el, model: paramsInput.model
                });
            }
        },
        initS2Lvl: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Lvl({
                    objSelector: el, model: paramsInput.model

                });


            }
        },
        initS2Features: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._managerS2Features({
                    objSelector: el, model: paramsInput.model

                });


            }
        },
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
        this.business_id =  $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {
        componentThisLodgingTypeOfRoomByPrice = this;
        this.initCurrentComponent();
        removeClassNotView();
    },

    validations: function () {
        var attributes = {
            id: {},
            room_number: {required},
            price: {required},
            name: {required},
            features_id_data: {required},
            description: {},
            lodging_type_of_room_id_data: {required},
            lodging_room_levels_id_data: {required},

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
            tabCurrentSelector: '#tab-lodgingTypeOfRoomByPrice',
            processName: "Registro Habitaciones.",
            formConfig: {
                nameSelector: "#business-by-lodging-type-of-room-by-price-form",
                url: $('#action_lodging_type_of_room_by_price_save').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar la habitación.',
                successMessage: 'Habitación se guardo correctamente.',
                nameModel: "LodgingTypeOfRoomByPrice"
            },
            gridConfig: {
                selectorCurrent: "#lodging-type-of-room-by-price-grid",
                url: $("#action_lodging_type_of_room_by_price_admin").val()
            },
            submitStatus: "no",
            showManager: false,
            business_id: null,
            managerType: null,
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
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var business_id = this.business_id;
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
                        var description = (row.description !== "null" && row.description) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Descripción:</span><span class='content-description__value'>" + (row.description) + "</span>",
                            "</div>",
                        ] : [];
                        description = description.join("");
                        var result = [
                            "<div    class='content-description'>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nivel : </span><span class='content-description__value'>" + (row.lodging_room_levels) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo de Habitación: </span><span class='content-description__value'>" + (row.lodging_type_of_room) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Codigo Habitación:</span><span class='content-description__value'>" + (row.room_number) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre Habitación:</span><span class='content-description__value'>" + (row.name) + "</span>",
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
                this.model.attributes.room_number = (rowCurrent.room_number);
                this.model.attributes.price = parseFloat(rowCurrent.price);
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.description = rowCurrent.description;
                var features_id_data = rowCurrent.features;
                this.model.attributes.features_id_data = features_id_data;
                this.model.attributes.lodging_type_of_room_id_data = {
                    id: rowCurrent.lodging_type_of_room_id,
                    text: rowCurrent.lodging_type_of_room
                };
                this.model.attributes.lodging_room_levels_id_data = {
                    id: rowCurrent.lodging_room_levels_id,
                    text: rowCurrent.lodging_room_levels
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

                room_number: {
                    id: "room_number",
                    name: "room_number",
                    label: "Codigo Habitación",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                price: {
                    id: "price",
                    name: "price",
                    label: "Precio",
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
                name: {
                    id: "name",
                    name: "name",
                    label: "Nombre Habitación",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                features_id_data: {
                    id: "features_id_data",
                    name: "features_id_data",
                    label: "Caracteristicas",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                lodging_type_of_room_id_data: {
                    id: "lodging_type_of_room_id_data",
                    name: "lodging_type_of_room_id_data",
                    label: "Tipo de Habitación",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                lodging_room_levels_id_data: {
                    id: "lodging_room_levels_id_data",
                    name: "lodging_room_levels_id_data",
                    label: "Nivel",
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
                room_number: null,
                lodging_type_of_room_id_data: {},
                lodging_room_levels_id_data: {},
                features_id_data: null,
                price: 0,
                name: null,
                description: null,
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


        _setValueForm: function (name, value) {
            var attributeCurrent;
            console.log("name", name, "value", value);
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
            var features_id_data = [];
            $.each(this.$v.model.attributes.features_id_data.$model, function (key, value) {
                var setPush = value.id;
                features_id_data.push(setPush);
            });
            var result = {
                LodgingTypeOfRoomByPrice: {
                    id: this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    room_number: this.$v.model.attributes.room_number.$model,
                    lodging_type_of_room_id: this.$v.model.attributes.lodging_type_of_room_id_data.$model.id,
                    lodging_room_levels_id: this.$v.model.attributes.lodging_room_levels_id_data.$model.id,
                    price: this.$v.model.attributes.price.$model,
                    description: this.$v.model.attributes.description.$model,
                    name: this.$v.model.attributes.name.$model,
                    business_id: this.business_id,
                    features_id_data: features_id_data,

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
            $('#features_id_data').val(null).trigger('change');
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
        _managerS2TypesOfRoom: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.model;
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.lodging_type_of_room_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione Aplicacion",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action_lodging_type_of_room_getListSelect2").val(),
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
                _this.model.attributes.lodging_type_of_room_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.lodging_type_of_room_id_data = null;
                _this._setValueForm('lodging_type_of_room_id_data', null);
            });

        },
        _managerS2Lvl: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.model;
            var dataCurrent = [];
            if (valueCurrentRowId) {

                dataCurrent = [this.model.attributes.lodging_room_levels_id_data];
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione el Nivel",
                data: dataCurrent,
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action_lodging_room_levels_getListSelect2").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {filters: {search_value: term, business_id: _this.business_id}};
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
                _this.model.attributes.lodging_room_levels_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.lodging_room_levels_id_data = null;
                _this._setValueForm('lodging_room_levels_id_data', null);
            });

        },
        _managerS2Features: function (params) {

            var el = params.objSelector;
            var valueCurrentRowId = params.model;
            var _this = this;
            var business_id = this.business_id;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                ajax: {
                    url: $("#action-lodging-room-features-getListSelect2").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: business_id
                            }
                        };
                        return paramsFilters;
                    },
                    processResults: function (data, page) {
                        return {results: data};
                    }
                },
                allowClear: true,
                multiple: true,
                width: '100%',
            });
            elementInit.on("change", function (e) {
                var dataCurrent = elementInit.select2('data');
                if (dataCurrent.length != 0) {
                    _this.model.attributes.features_id_data = dataCurrent;
                } else {
                    _this.model.attributes.features_id_data = null;
                    _this._setValueForm('features_id_data', null);
                }
            });

            initS2 = elementInit;
            if (valueCurrentRowId) {
                var data = this.model.attributes.features_id_data;
                _this.setValuesS2Multiple({
                    valueCurrentRowId: valueCurrentRowId,
                    elementS2: $(el),
                    'data': data,
                    attribute_name: 'features_id_data'
                });
            }

        },
        setValuesS2Multiple: function (params) {

            var attribute_name = params['attribute_name'];//id
            var elementS2 = params['elementS2'];
            setValuesS2Multiple(params);
            var dataCurrent = elementS2.select2('data');
            this.model.attributes[attribute_name] = dataCurrent;

        }
    }
})
;

