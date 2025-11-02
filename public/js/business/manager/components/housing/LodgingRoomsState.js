var componentThisLodgingRoomsStates;

var count = 0;
Vue.component('lodging-rooms-state-component', {

    template: '#lodging-rooms-state-template',
    directives: {
        initGridManager: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var thisCurrent = paramsInput.thisCurrent;
                paramsInput.initGridManager(thisCurrent);


            }
        }


    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var vmCurrent = this;

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id = this.configParams.data.business_id;
        this.businessId = this.business_id;

    },
    mounted: function () {
        componentThisLodgingRoomsStates = this;
        this.initCurrentComponent();
        removeClassNotView();
    },

    validations: function () {
        var attributes = {
            id: {},
            number: {},
            price: {},
            room_number: {},
            lodging_type_of_room_id_data: {},
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
                        "title": "Gestión de Limpieza",
                        "data-placement": "top",
                        "i-class": "fa fa-leaf",
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
                title:"Vista General Recepción",
                buttons: {
                    cancel: "Cancelar"
                }
            },
            lblBtnSave: "Guardar",
            lblBtnClose: "Cerrar",
            tabCurrentSelector: '#manager-modal',
            processName: "Registro Habitaciones.",
            formConfig: {
                nameSelector: "#business-by-lodging-type-of-room-by-price-reception-form",
                url: $('#action_lodging_type_of_room_by_price_saveReception').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar la habitación.',
                successMessage: 'Habitación se guardo correctamente.',
                nameModel: "LodgingTypeOfRoomByPrice"
            },
            gridConfig: {
                selectorCurrent: "#lodging-type-of-room-by-price-reception-grid",
                url: $("#action_lodging_type_of_room_by_price_adminReception").val()
            },
            submitStatus: "no",
            showManager: false,
            businessId: null,
            managerType: null,
            data: [{
                name: "hola"
            }],
            busy: false,
            loading: false,
            nextItem: 1,
            items: [],
            loadDataConfig: {
                busy: false,
                data: [],
                current: 1,
                rowCount: 10
            },
            statusManager: [
                {id: "FREE", text: "Libres"},
                {id: "OCCUPIED", text: "Ocupadas"},
                {id: "CLEANING", text: "Limpieza"},
                {id: "ALL", text: "Todas"},

            ],
            filters: {status: "ALL"},
            allowProcess: false,
            lodgingRoomLevelsManager: {
                loading: false,
                lodgingRoomLevelsData: [],
                data: [],
                lodging_room_levels_id: 0
            },
            staticsLodgingRooms: {
                free: {count: 0, label: "Libres"},
                cleaning: {count: 0, label: "Por Limpiar"},
                occupied: {count: 0, label: "Ocupada"},
                total: {count: 0, label: "Total Habitaciones"},

            },
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
        };
        return dataManager;
    },
    methods: {
        ...$methodsFormValid,

        _submitForm: function (e) {
            console.log(e);
        },
        getStructureForm: function () {
            var result = {

                lodging_type_of_room_id_data: {
                    id: "lodging_type_of_room_id_data",
                    name: "lodging_type_of_room_id_data",
                    label: "Fecha Ingreso",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                room_number: {
                    id: "room_number",
                    name: "room_number",
                    label: "Fecha Ingreso",
                    required:
                        {
                            allow: true,
                            msj: "Campo requerido.",
                            error: false
                        }
                },
                number: {
                    id: "number",
                    name: "number",
                    label: "Fecha Ingreso",
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
                    label: "Fecha Ingreso",
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
                lodging_type_of_room_id_data: null,
                id: null,
                room_number: null,
                number: null,
                price: null,

            };

            return result;
        },
        validateForm: function () {
            var currentAllow = this.getValidateForm();
            return currentAllow.success;
        },
        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,

        getValuesSave: function () {
            var result = {
                "LodgingTypeOfRoomByPrice":
                    {id: this.$v.model.attributes.id.$model,status:'FREE'}
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
                            $(vCurrent.gridConfig.selectorCurrent).bootgrid("reload");
                            vCurrent._viewManager(2);
                        }
                    }
                });
            }
        },
        getValidateForm:getValidateForm,
        /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        initCurrentComponent: function () {
            this.allowProcess = $configPartial["dataCatalogue"]["lodgingRoomLevels"].length == 0 ? false : true;
            this.lodgingRoomLevelsManager = {
                loading: false,
                lodgingRoomLevelsData: $configPartial["dataCatalogue"]["lodgingRoomLevels"],
                data: [],
                lodging_room_levels_id: $configPartial["dataCatalogue"]["lodgingRoomLevels"].length == 0 ? null : $configPartial["dataCatalogue"]["lodgingRoomLevels"][0]
            };
            $("#tab-lodgingTypeOfRoomByPriceReception.not-view").removeClass("not-view");



            this.$refs.refLodgingRoomsStateModal.show();
        },
        _setValueOfParent: function (params) {
            if (params.type == "openModal") {
                this.businessId = params.data.data.business_id;
                this.initCurrentComponent();

            }
        },
        /*modal*/
        _showModal: function () {

        },
        _hideModal: function () {

            this._emitToParent({type: "rebootConfig", nameProcess: "configModalLodgingRoomsState"});

        },
        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },
        _saveModal: function (bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        _cancel: function () {
            this.showManager = false;
            this.$refs.refLodgingRoomsStateModal.hide();

        },
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
        getFiltersGrid: function () {
            var business_id = this.businessId;
            var lodging_room_levels_id = this.lodgingRoomLevelsManager.lodging_room_levels_id;
            var result = {
                business_id: business_id,
                status: this.filters.status,
                lodging_room_levels_id: lodging_room_levels_id
            };
            return result;
        },
        _cleaner: function (row) {
            console.log(row);
            this._managerRowGrid({
                row: row,
                managerType: "updateEntity"
            });
        },

        initGridManager: function (vmCurrent) {
            vmCurrent.lodgingRoomLevelsManager.loading = true;
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            this.lodgingRoomLevelsManager.data = [];
            var paramsFilters = vmCurrent.getFiltersGrid();
            let gridInit = $(gridName);
            gridInit.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                rowCount: -1,
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

                        var statusHtml = row.status == "CLEANING" ? [
                            "<div class='content-description__information cleaning'>",
                            "   <span class='content-description__title'>Limpieza</span><span class='badge content-description__value cleaning'> <i class='fa fa-leaf'></i></span>",
                            "</div>",
                        ] : (row.status == "FREE" ? [
                            "<div class='content-description__information free'>",
                            "   <span class='content-description__title'>Disponible</span><span class='badge content-description__value free'> <i class='fa fa-check'></i></span>",
                            "</div>",
                        ] : (row.status == "OCCUPIED" ? [
                            "<div class='content-description__information occupied'>",
                            "   <span class='content-description__title'>Ocupado</span><span class='badge content-description__value occupied'> <i class='fa fa-ban'></i></span>",
                            "</div>",
                        ] : []));
                        statusHtml = statusHtml.join("");
                        var description = (row.room_number !== "null" && row.room_number) ? [
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'># Habitación:</span><span class='content-description__value'>" + (row.room_number) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Precio:</span><span class='content-description__value'>" + (row.price) + "</span>",
                            "</div>",
                        ] : [];
                        description = description.join("");
                        var result = [
                            "<div    class='content-description'>",
                            statusHtml,
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo de Habitación: </span><span class='content-description__value'>" + (row.lodging_type_of_room) + "</span>",
                            "</div>",

                            description,
                            "</div>"
                        ];
                        return result.join("");
                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent.lodgingRoomLevelsManager.loading = false;
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
                $('.nav-tabs').children().children().addClass('nav-link');
            }).on("initialize.rs.jquery.bootgrid", function () {
                console.log("initialize");

            }).on("initialized.rs.jquery.bootgrid", function () {
                console.log("initialized");

            }).on("load.rs.jquery.bootgrid", function () {
                console.log("load");

            })

            ;
        },
        _gridManager: function (elementSelect) {
            $(this.gridConfig.selectorCurrent + " thead").hide();
            $(".actions.btn-group").hide();
            var vmCurrent = this;
            var selectorGrid = vmCurrent.gridConfig.selectorCurrent;
            var instance_data_rows = $(vmCurrent.gridConfig.selectorCurrent).bootgrid("getCurrentRows");
            if (instance_data_rows) {


                this.lodgingRoomLevelsManager.data = [];
                this.lodgingRoomLevelsManager.data = instance_data_rows;
                vmCurrent.staticsLodgingRooms.total.count = instance_data_rows.length;
                vmCurrent.staticsLodgingRooms.cleaning.count = 0;
                vmCurrent.staticsLodgingRooms.free.count = 0;
                vmCurrent.staticsLodgingRooms.occupied.count = 0;
                vmCurrent.staticsLodgingRooms.total.count = instance_data_rows.length;
                $.each(instance_data_rows, function (key, value) {
                    var removeRowId = value.id;
                    selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                    var rowClass = "";
                    if (value.status == "CLEANING") {
                        rowClass = "row-cleaning";
                        vmCurrent.staticsLodgingRooms.cleaning.count++;
                    } else if (value.status == "FREE") {
                        rowClass = "row-free";
                        vmCurrent.staticsLodgingRooms.free.count++;

                    } else if (value.status == "OCCUPIED") {
                        rowClass = "row-occupied";
                        vmCurrent.staticsLodgingRooms.occupied.count++;

                    }
                    selectorRow = selectorGrid + " tr[data-row-id='" + removeRowId + "']";
                    $(selectorRow).addClass(rowClass);


                });
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
            }
        },
        getMenuConfig: function (params) {


            var result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                if (params.rowData.status == "CLEANING") {

                    var setPush = {
                        title: value["title"],
                        "data-placement": value["data-placement"],
                        icon: value["i-class"],
                        data: value, rowId: params.rowId,
                        managerType: value["managerType"],
                        params: params
                    }
                    result.push(setPush);
                }
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
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.room_number = (rowCurrent.room_number);
                this.model.attributes.price = parseFloat(rowCurrent.price);
                this.model.attributes.lodging_type_of_room_id_data = {
                    id: rowCurrent.lodging_type_of_room_id,
                    text: rowCurrent.lodging_type_of_room
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

        _status: function (value) {

            $(this.gridConfig.selectorCurrent).bootgrid("destroy");
            this.initGridManager(this);

        },
        _tapManager: function (indexNeedle) {

            var tapCurrent = this.lodgingRoomLevelsManager.lodgingRoomLevelsData.filter(function (value, index) {
                    return index == indexNeedle;
                }
            );
            if (tapCurrent.length != 0) {
                this.lodgingRoomLevelsManager.lodging_room_levels_id = tapCurrent[0].value;
                $(this.gridConfig.selectorCurrent).bootgrid("destroy");
                this.initGridManager(this);
            }
        },
        cancel: function () {

        }
    }
})
;

