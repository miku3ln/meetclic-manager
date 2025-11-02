var componentThisEventsTrailsRegistrationPoints;
Vue.component('events-trails-registration-points-component', {
    template: '#events-trails-registration-points-template',
    directives: {

        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput.method({
                    objSelector: el, model: paramsInput.model
                });
            }
        }
    }, props: {
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
        this.events_trails_project_id = this.configParams.events_trails_project_id;
    },
    mounted: function () {
        componentThisEventsTrailsRegistrationPoints = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    computed: {},
    validations: function () {
        var attributes = {
            "id": {},
            "business_id": {required},

            "status": {required},
            /*Address Information*/

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
                    }, {
                        "title": "Eliminar",
                        "data-placement": "top",
                        "i-class": "fas fa-trash-alt",
                        "managerType": "managementDelete"
                    },
                     {
                        "title": "Administracion Pagos",
                        "data-placement": "top",
                        "i-class": "fas fa-cash-register",
                        "managerType": "managementGetPayments"
                    },
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
            tabCurrentSelector: '#tab-events-trails-registration-points',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#events-trails-registration-points-form",
                url: $('#action-events-trails-registration-points-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el EventsTrailsRegistrationPoints.',
                successMessage: 'El EventsTrailsRegistrationPoints se guardo correctamente.',
                nameModel: "EventsTrailsRegistrationPoints"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#events-trails-registration-points-grid",
                url: $("#action-events-trails-registration-points-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            //PROFILE BUSINESS
            /*-----SUBRPROCESS---*/
            configModalEventsTrailsByProfile: {
                title: "Title",
                viewAllow: false,
                data: []

            },   configModalManagementFormEventDetails: {
                viewAllow: false
            }
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

            } else if (emitValues.type == "resetProcess") {
                var nameCurrent = emitValues.name;
                this[nameCurrent].viewAllow = false;
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
            var $scope=this;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.business_id ={
                    'text': rowCurrent.title,
                    'id': rowCurrent.business_id,

                };
                this.model.attributes.status = rowCurrent.status;

                this._viewManager(3, rowId);
            }  else if (params.managerType == "managementGetPayments") {


                var dataSend = {
                    filters: {
                        events_trails_registration_points_id:rowCurrent.id
                    }
                };
                var tabCurrentSelector = '#modal-management-form-event';
                var loadingMessage = 'Obteniendo Informacion....';
                var errorMessage = 'Error al obtener!';
                ajaxRequestManager($('#action-management-getDataPaymentsManagement').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: loadingMessage,
                    error_message: errorMessage,
                    success_message: 'Se registro correctamente.',
                    success_callback: function (response) {

                        if (response.success) {

                            $scope.configModalManagementFormEventDetails.data = {
                                event: rowCurrent,
                                data: response.data
                            };
                            $scope.configModalManagementFormEventDetails.viewAllow = true;
                        }
                    }
                });
            } else if (params.managerType == "managementDelete") {

                var dataSend = {
                    filters: {
                        id:rowCurrent.id
                    }
                };
                var tabCurrentSelector = '#tab-events-trails-registration-points';
                var loadingMessage = 'Eliminando....';
                var errorMessage = 'Error al eliminar!';
                ajaxRequestManager($('#action-events-trails-registration-points-deletePointSale').val(), {
                    type: 'POST',
                    data: dataSend,
                    blockElement: tabCurrentSelector,//opcional: es para bloquear el elemento
                    loading_message: loadingMessage,
                    error_message: errorMessage,
                    success_message: 'Se elimino correctamente.',
                    success_callback: function (response) {

                        if (response.success) {

                            $($scope.gridConfig.selectorCurrent).bootgrid("reload");

                        }
                    }
                });

            }
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                events_trails_project_id: this.events_trails_project_id
            };
            let gridInit = $(gridName);
            var structure = vmCurrent.model.structure;
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

                        userAddClass = '';
                        var classStatus = "badge-success";
                        if (row.status == "INACTIVE") {
                            classStatus = "badge-warning";
                        }

                        var variantAmenities = row.amenities;
                        var dataCurrentGet = variantAmenities;
                        var variantAmenitiesHtml = [];
                        $.each(dataCurrentGet, function (key, value) {
                            variantAmenitiesHtml.push(value.text);
                        });
                        variantAmenitiesHtml = variantAmenitiesHtml.join(",");
                        variantAmenitiesHtml = variantAmenitiesHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.business_by_amenities_data.label + '</span>:<span class=\'content-description__value\'>' + variantAmenitiesHtml + ".</span></div>" : "";
                        sourceCurrent = row.source ? [
                            "<div class='content-description__information'>",
                            "   <img class='content-description__image' src='" + $publicAsset + row.source + "'> ",
                            "</div>",
                        ] : [];
                        sourceCurrent=sourceCurrent.join('');
                        var description = (row.title !== "null" && row.title) ? [

                            sourceCurrent,
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Nombre:</span><span class='content-description__value'>" + (row.title) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Email:</span><span class='content-description__value'>" + (row.email) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Teléfono:</span><span class='content-description__value'>" + (row.phone_value) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Dirección:</span><span class='content-description__value'>" + (row.street_1 + " y " + row.street_2) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Categoría:</span><span class='content-description__value'>" + (row.business_categories_name) + "</span>",
                            "</div>",
                            variantAmenitiesHtml,
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>País :</span><span class='content-description__value'>" + (row.countries_name) + "</span>",
                            "</div>"
                        ] : [];
                        description = description.join("");
                        var result = [
                            "<div class='content-description " + userAddClass + "'>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>" + structure.status.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.status + "</span></span>",
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
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.showManager = true;
                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
                this.resetForm();
                this.managerType = 1;
                this.onInitEventClickTimerForm();//CHANGE-FORM
            } else if (typeView == 2) {//admin
                this.showManager = false;

                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: false,
                });
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
            } else if (typeView == 3) {//update
                this.showManager = true;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent,
                    hide: true,
                });
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
                business_id: {
                    id: "business_id",
                    name: "business_id",
                    label: "Empresa",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 250.",
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
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },

            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "business_id": null, "status": "ACTIVE",

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
                EventsTrailsRegistrationPoints:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "business_id": this.$v.model.attributes.business_id.$model.id,
                        "status": this.$v.model.attributes.status.$model,
                        "events_trails_project_id": this.events_trails_project_id,

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

        initBusiness: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.model.id;
            var events_trails_project_id = this.events_trails_project_id;
            var business_id = 1;

            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.business_id];
            }
            var $scope = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-business-getManagementBusinessEvents").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                events_trails_project_id: events_trails_project_id,
                                business_id: business_id,


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

            }).on("select2:unselecting", function (e) {

            }).on("change", function (e) {
                var dataCurrent = elementInit.select2('data');
                if (dataCurrent.length == 0) {
                    $scope.$v.model.attributes.business_id = null;
                    $scope._setValueForm('business_id', null);
                } else {
                    $scope.model.attributes.business_id = dataCurrent[0];

                }

            });
        }
    }
})
;




