var componentThisEventsTrailsByKit;
Vue.component('events-trails-by-kit-component', {
    template: '#events-trails-by-kit-template',
    directives: {
        initS2PiecesClothes: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._initS2PiecesClothes({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }
    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.events_trails_project_id = this.configParams.events_trails_project_id;
    },
    mounted: function () {
        componentThisEventsTrailsByKit = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    computed: {},
    validations: function () {
        var attributes = {
            "id": {},
            "entity_type": {required},
            "entity_id_data": {required},
            "status": {required}
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
            events_trails_project_id: null,
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
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},

//form config
            model: {
                attributes: this.getAttributesForm(),
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-events-trails-by-kit',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#events-trails-by-kit-form",
                url: $('#action-events-trails-by-kit-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el EventsTrailsByKit.',
                successMessage: 'El EventsTrailsByKit se guardo correctamente.',
                nameModel: "EventsTrailsByKit"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#events-trails-by-kit-grid",
                url: $("#action-events-trails-by-kit-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            configProcess: {
                'inventory': {
                    'title': 'Inventario',
                    'msg': 'Se usa para calcular las tarifas de envío al momento del pago y los precios de las etiquetas de envío durante la preparación.',

                },
                'shipping': {
                    'title': 'Configuracion Envios',
                    'msg': 'Se usa para calcular las tarifas de envío al momento del pago y los precios de las etiquetas de envío durante la preparación.',

                },
                'variants': {
                    'title': 'Variantes',
                    'msg': 'Este producto tiene múltiples opciones, así como diferentes tamaños o colores',
                },

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
                this.model.attributes.entity_type = rowCurrent.entity_type;
                this.model.attributes.entity_id_data = {id: rowCurrent.entity_id, text: rowCurrent.name};
                this.model.attributes.status = rowCurrent.status;


                this._viewManager(3, rowId);
            }
        },
        initGridManager: function (vmCurrent) {
            var structure = vmCurrent.model.structure;
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var business_id = $modelDataManager['model']['business_id'];

            var paramsFilters = {business_id:business_id,events_trails_project_id:this.events_trails_project_id};

            var structure = vmCurrent.model.structure;
            var formatters = getFormatterProcess({
                'structure': structure,
                'vmCurrent': vmCurrent,
                'processName': 'products',
                'viewAll': true,

            });
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
                formatters: formatters
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
                entity_type: {
                    id: "entity_type",
                    name: "entity_type",
                    label: "Tipo",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "1", "text": "Piezas"}, {"value": "0", "text": "Prendas"}]

                },
                entity_id_data: {
                    id: "entity_id_data",
                    name: "entity_id_data",
                    label: "Prenda/Pieza",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                status: {
                    id: "status",
                    name: "status",
                    label: "status",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
                },

                code: {
                    id: "code",
                    name: "code",
                    label: "Codigo",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 64.",
                    },
                },
                name: {
                    id: "name",
                    name: "name",
                    label: "Nombre",
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
                product_trademark_id_data: {
                    id: "product_trademark_id_data",
                    name: "product_trademark_id_data",
                    label: "Marca",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                product_category_id_data: {
                    id: "product_category_id_data",
                    name: "product_category_id_data",
                    label: "Categoria",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                product_subcategory_id_data: {
                    id: "product_subcategory_id_data",
                    name: "product_subcategory_id_data",
                    label: "Subcategoria",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                source: {
                    id: "source",
                    name: "source",
                    label: "Imagen",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                description: {
                    id: "description",
                    name: "description",
                    label: "Descripcion",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                code_provider: {
                    id: "code_provider",
                    name: "code_provider",
                    label: "Codigo Proveedor",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 80.",
                    },
                },
                code_product: {
                    id: "code_product",
                    name: "code_product",
                    label: "Codigo Producto",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                    maxLength: {
                        msj: "# Carecteres Excedidos a 80.",
                    },
                },
                has_tax: {
                    id: "has_tax",
                    name: "has_tax",
                    label: "Tiene Iva?",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                is_service: {
                    id: "is_service",
                    name: "is_service",
                    label: "is service",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                view_online: {
                    id: "view_online",
                    name: "view_online",
                    label: "Ver Tienda Online?",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                product_measure_type_id_data: {
                    id: "product_measure_type_id_data",
                    name: "product_measure_type_id_data",
                    label: "Medida",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                sale_price: {
                    id: "sale_price",
                    name: "sale_price",
                    label: "Precio Sin Iva",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                product_by_color_data: {
                    id: "product_by_color_data",
                    name: "product_by_color_data",
                    label: "Colores",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                product_by_sizes_data: {
                    id: "product_by_sizes_data",
                    name: "product_by_sizes_data",
                    label: "Tamaño",
                    required: {
                        allow: false,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                height: {
                    id: "height",
                    name: "height",
                    label: "Alto(cm)",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                length: {
                    id: "length",
                    name: "length",
                    label: "Largo(cm)",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                width: {
                    id: "width",
                    name: "width",
                    label: "Ancho(cm)",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
                weight: {
                    id: "weight",
                    name: "weight",
                    label: "Peso(kg)",
                    required: {
                        allow: true,
                        msj: "Campo requerido.",
                        error: false
                    },
                },
            };
            return result;
        },
        getAttributesForm: function () {
            var result = {
                "id": null,
                "entity_type": 0, "entity_id_data": null, "status": "ACTIVE"
            };
            return result;
        },

        getNameAttribute: function (name) {
            var result = this.formConfig.nameModel + "[" + name + "]";
            return result;
        },
        getLabelForm: viewGetLabelForm,


        _setValueForm: function (name, value) {
            if (name == 'entity_type') {

                $('#entity_id_data').val(null).trigger('change');

            }
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
                EventsTrailsByKit:
                    {
                        "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                        "entity_type": this.$v.model.attributes.entity_type.$model,
                        "entity_id": this.$v.model.attributes.entity_id_data.$model.id,
                        "status": this.$v.model.attributes.status.$model,
                        "events_trails_project_id": this.events_trails_project_id

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
        _initS2PiecesClothes: function (params) {
            var el = params.objSelector
            var valueCurrentRowId = params.rowId;
            var events_trails_project_id = this.events_trails_project_id;
            var business_id = $modelDataManager['model']['business_id'];
            var is_service = 0;
            var dataCurrent = [];
            if (valueCurrentRowId) {
                dataCurrent = [this.model.attributes.entity_id_data];
            }
            var $scope = this
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-getEventsProductService").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                events_trails_project_id: events_trails_project_id,
                                entity_type: $scope.$v.model.attributes.entity_type.$model,
                                'is_service': is_service,
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
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {

            }).on("select2:unselecting", function (e) {

            }).on("change", function (e) {
                var dataCurrent = elementInit.select2('data');
                if (dataCurrent.length == 0) {
                    $scope.$v.model.attributes.entity_id_data = null;
                    $scope._setValueForm('entity_id_data', null);
                } else {
                    $scope.model.attributes.entity_id_data = dataCurrent[0];

                }

            });
        }
    }
})
;




