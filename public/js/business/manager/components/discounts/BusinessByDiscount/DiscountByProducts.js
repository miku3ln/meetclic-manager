var componentThisDiscountByProducts;
Vue.component('discount-by-products-component', {
    template: '#discount-by-products-template',
    directives: {}
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {

    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id =  $businessManager.id;//this.configParams.business_id;
        this.business_by_discount_id = this.configParams.business_by_discount_id;
        this.filtersGrid = {
            business_id: this.business_id,
            business_by_discount_id: this.business_by_discount_id
        }
        if (this.business_by_discount_id) {

            var rowsKeysData = this.configParams.managerProcess.rowsKeysData;
            var rowsDataDetailsAll = [];
            this.gridConfig.rowsDataManager['rowsKeysData'] = rowsKeysData;
            this.gridConfig.rowsDataManager['rowsDataDetailsAll'] = rowsDataDetailsAll;
            this.gridConfig.rowsDataManager['rowsData'] = [];
            this.gridConfig.optionsCurrentGrid['card'] = this.resultsGrid(rowsKeysData);

        }
    },
    mounted: function () {
        componentThisDiscountByProducts = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {};
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
            business_by_discount_id: null,
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
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
//form config
            model: {
                attributes: {},
                structure: this.getStructureForm(),
            },
            tabCurrentSelector: '#tab-discount-by-products',
//Grid config
            gridConfig: {
                selectorCurrent: "#discount-by-products-grid",
                url: $("#action-discount-by-products-adminProducts").val(),
                rowsDataManager: {
                    rowsDataDetailsAll: [],
                    rowsKeysData: [],
                    rowsData: [],


                },
                optionsCurrentGrid: {
                    card: {
                        'type': 'warning',
                        title: 'Productos Agregados',
                        data: [
                            {
                                title: 'Total',
                                type: 'warning',
                                'icon-class': 'fa fa-caret-down',
                                'value': '0',

                            }
                        ]
                    }
                }
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            dataManagerProcess: $configPartial['dataManagerProcess'],
            filtersGrid: {},
            configProcess: {
                'inventory': {
                    'title': 'Se aplica a Productos',
                    'msg': 'Agrega por lo menos un producto a los descuentos.',

                },
                'shipping': {
                    'title': 'Envios',
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

        _emitToParent: function (params) {
            this.$root.$emit('_updateParentByChildren', params);
        },
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
        makeToast: makeToast,
//MANAGER PROCESS
        /*---------GRID--------*/
        _destroyTooltip: _destroyTooltip,
        _resetManagerGrid: _resetManagerGrid,
        _managerMenuGrid: _managerMenuGrid,
        getMenuConfig: function (params) {
            var result = [];
            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                var setPush = {
                    title: value["title"],
                    "data-placement": value["data-placement"],
                    icon: value["i-class"],
                    data: value, rowId: params.rowId,
                    managerType: value["managerType"],
                    params: params,
                    isUrl: value["isUrl"],
                    url: value["url"],
                }
                result.push(setPush);
            });
            return result;
        },
        resultsGrid: function (rowsKeysData) {
            var valueTotal = rowsKeysData.length;
            var card = {
                'type': valueTotal == 0 ? 'warning' : 'success',
                title: 'Productos Agregados',
                data: [
                    {
                        title: 'Total',
                        type: valueTotal == 0 ? 'warning' : 'success',
                        'icon-class': valueTotal == 0 ? 'fa fa-caret-down' : 'fa fa-caret-up',
                        'value': valueTotal,

                    }
                ]

            };
            return card;
        }
        ,
        _eventCheckList: function (rowsManager) {

            var rowsKeysData = rowsManager.rowsKeysData;
            var rowsDataDetailsAll = rowsManager['rowsDataDetailsAll'];
            this.gridConfig.rowsDataManager['rowsKeysData'] = rowsKeysData;
            this.gridConfig.rowsDataManager['rowsDataDetailsAll'] = rowsDataDetailsAll;
            this.gridConfig.rowsDataManager['rowsData'] = rowsManager['rowsData'];


            this.gridConfig.optionsCurrentGrid['card'] = this.resultsGrid(rowsKeysData);
            this._emitToParent({
                type: "changeValuesGridProductsDiscount", data: {
                    rowsDataManager: this.gridConfig.rowsDataManager,

                }
            });
        },
        _gridManager: function (params) {

            if (this.model.attributes.id) {

                this.gridConfig.rowsDataManager['rowsKeysData'] = this.model.attributes.products_id_data;
                this.gridConfig.rowsDataManager['rowsDataDetailsAll'] = [];
                this.gridConfig.rowsDataManager['rowsData'] = [];
                $.each(params.elementInit.find("tbody tr"), function (key, value) {

                    console.log(value);
                });
            }

            this._managerCheckGrid(params);
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;

        },
        initGridManager: function (vmCurrent) {
            var selectorCurrent = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {};
            var structure = vmCurrent.model.structure;
            var formatters = getFormatterProcess({
                'structure': structure,
                'vmCurrent': vmCurrent,
                'processName': 'productsDiscounts',

            });

            function getFiltersGrid() {
                var result = vmCurrent.filtersGrid;
                return result;
            };
            var overWritePost = function (request) {
                request.filters = getFiltersGrid();
                return request;
            };
            let gridInit = initGridManager({
                gridNameSelector: selectorCurrent,
                paramsFilters: paramsFilters,
                formatters: formatters,
                'urlCurrent': urlCurrent,
                overWritePost: overWritePost
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {

                var params = {
                    selectorInit: selectorCurrent,
                    elementInit: gridInit,
                    rowsDataManager: vmCurrent.gridConfig.rowsDataManager,
                    managerCustomerFunction: vmCurrent._eventCheckList
                };
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(params);
            });
        },
        /*Manager FORMS-AND VIEWS*/
        _viewManager: function () {

        },
        _managerCheckGrid: _managerCheckGrid,
        getStructureForm: function () {
            var result = {
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
                        allow: false,
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
                    label: "Precio",
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
    }
})
;

