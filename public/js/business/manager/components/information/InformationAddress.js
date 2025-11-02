var componentThisInformationAddress;
Vue.component('information-address-component', {
    template: '#information-address-template',
    directives: {
        initS2InformationAddressType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2InformationAddressType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initMapCurrent: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput._initMap({
                    elementSelector: ".map-guests",
                    objSelector: $(el)[0],
                    data: paramsInput
                });

            }
        },
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
        this.labelsConfig.title = this.configParams.data.labelsConfig.title;
        this.entity_type = this.configParams.data.entity_type;

    },
    mounted: function () {
        componentThisInformationAddress = this;
        this.initCurrentComponent();
    },

    validations: function () {
        var attributes = {
            "id": {},
            "street_one": {required, maxLength: Validators.maxLength(150)},
            "street_two": {required, maxLength: Validators.maxLength(150)},
            "reference": {required},
            "state": {required},
            "entity_id": {},
            "main": {required},
            "entity_type": {},
            "information_address_type_id_data": {required},
            "has_location": {required},
            "options_map": {required},
            information_address_location_current: {}
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
            tabCurrentSelector: '#modal-information-address',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#modal-information-address",
                url: $('#action-information-address-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el InformationAddress.',
                successMessage: 'El InformationAddress se guardo correctamente.',
                nameModel: "InformationAddress"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#information-address-grid",
                url: $("#action-information-address-getAdmin").val()
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
            this.initDataModal();
            this.$refs.refInformationAddressModal.show();
        },

        /*modal events*/
        _showModal: function () {
            this.resetForm();

        },
        _hideModal: function () {
            this._emitToParent({
                type: 'resetComponent',
                'componentName': 'configModalInformationAddress'
            });

        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.$refs.refInformationAddressModal.hide();

        },
        initDataModal: function () {
            var rowCurrent = this.configParams.data;
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.configParams = params.data;

                this.initDataModal();
                this.$refs.refInformationAddressModal.show();

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
                this.model.attributes.street_one = rowCurrent.street_one;
                this.model.attributes.street_two = rowCurrent.street_two;
                this.model.attributes.reference = rowCurrent.reference;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.entity_id = rowCurrent.entity_id;
                this.model.attributes.main = rowCurrent.main == 0 ? false : true;
                this.model.attributes.entity_type = rowCurrent.entity_type;
                this.model.attributes.information_address_type_id_data = {
                    id: rowCurrent.information_address_type_id,
                    text: rowCurrent.information_address_type
                };
                this.model.attributes.has_location = rowCurrent.has_location;
                this.model.attributes.options_map = rowCurrent.options_map;

                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;

            var paramsFilters = {
                entity_id: this.entity_id,
                entity_type: this.entity_type,

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

                        var mainRow = [
                            row.main ? '<span class="content-description__value badge badge--size-large badge-success">' : '<span class="content-description__value badge badge--size-large badge-warning">',
                            row.main ? 'SI' : 'NO',
                            '</span>'
                        ];
                        var stateRow = [
                            row.state == 'ACTIVE' ? '<span class="content-description__value badge badge--size-large badge-success">' : '<span class="content-description__value badge badge--size-large badge-warning">',
                            row.state == 'ACTIVE' ? 'ACTIVO' : 'INACTIVO',
                            '</span>'
                        ];
                        mainRow = mainRow.join('');
                        stateRow = stateRow.join('');
                        var result = [
                            "<div class='content-description'>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span>" + stateRow,
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Principal:</span>" + mainRow,
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo:</span><span class='content-description__value'>" + row.information_address_type + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Calle Pincipal:</span><span class='content-description__value'>" + row.street_one + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Calle Secundaria:</span><span class='content-description__value'>" + row.street_two + "</span>",
                            "</div>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Referencia:</span><span class='content-description__value'>" + row.reference + "</span>",
                            "</div>",
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
                street_one: {
                    id: "street_one",
                    name: "street_one",
                    label: "Calle Principal",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                street_two: {
                    id: "street_two",
                    name: "street_two",
                    label: "Calle Secundaria",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 150.",
                    },
                },
                reference: {
                    id: "reference",
                    name: "reference",
                    label: "Referencia",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
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
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },
                entity_id: {
                    id: "entity_id",
                    name: "entity_id",
                    label: "entity id",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                main: {
                    id: "main",
                    name: "main",
                    label: "Principal",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                entity_type: {
                    id: "entity_type",
                    name: "entity_type",
                    label: "entity type",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                information_address_type_id_data: {
                    id: "information_address_type_id_data",
                    name: "information_address_type_id_data",
                    label: "Tipo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                has_location: {
                    id: "has_location",
                    name: "has_location",
                    label: "has location",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                options_map: {
                    id: "options_map",
                    name: "options_map",
                    label: "options map",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                }

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "street_one": null,
                "street_two": null,
                "reference": null,
                "state": 'ACTIVE',
                "entity_id": null,
                "main": false,
                "entity_type": null,
                "information_address_type_id_data": null,
                "has_location": true,
                "options_map": null,
                "information_address_location_current": null,

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
                InformationAddress:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "street_one": this.$v.model.attributes.street_one.$model,
                        "street_two": this.$v.model.attributes.street_two.$model,
                        "reference": this.$v.model.attributes.reference.$model,
                        "state": this.$v.model.attributes.state.$model,
                        "entity_id": this.entity_id,
                        "main": this.$v.model.attributes.main.$model ? 1 : 0,
                        "entity_type": this.entity_type,
                        "information_address_type_id": this.$v.model.attributes.information_address_type_id_data.$model.id,
                        "has_location": 1,
                        "options_map": this.$v.model.attributes.options_map.$model,
                        "information_address_location_current": this.$v.model.attributes.information_address_location_current.$model,

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

        getValidateForm: getValidateForm,
//others functions
        _managerS2InformationAddressType: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.information_address_type_id_data];
                var textCurrent = this.model.attributes.information_address_type_id_data.text;
                var idCurrent = this.model.attributes.information_address_type_id_data.id;
                var option = new Option(textCurrent, idCurrent, true, true);
                $(el).append(option).trigger('change');
            }
            var _this = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-information-address-type-getListSelect2").val(),
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
                multiple: true,
                maximumSelectionLength: 1,

                width: '100%'
            }).on("select2:open", function (e) {
                managerModalSelect2();
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                _this.model.attributes.information_address_type_id_data = data;
            }).on("select2:unselecting", function (e) {
                _this.model.attributes.lodging_room_levels_id_data = null;
                _this._setValueForm('information_address_type_id_data', null);
            });
        },

        /* ----MAPS-----*/
        /*MAP */
        _initClassSearch: function () {
            if (!$('.pac-container').hasClass('pac-container--view-modal')) {

                $('.pac-container').addClass('pac-container--view-modal');
            }
        },
        ...$managerGoogleMaps,


    },


});




