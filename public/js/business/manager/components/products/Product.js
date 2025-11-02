var componentThisProduct;
Vue.component('product-component', {
    template: '#product-template',
    directives: {
        initS2ProductTrademark: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductTrademark({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ProductCategory: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductCategory({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initS2ProductSubcategory: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductSubcategory({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        }, initEventUploadSource: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                var paramsInit = paramsInput['paramsInit'];
                var initMethod = paramsInput['initMethod'];
                initMethod(paramsInit);
            }
        }, initS2ProductMeasureType: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput._managerS2ProductMeasureType({
                    objSelector: el, rowId: paramsInput.rowId
                });
            }
        },
        initS2: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                var nameMethod = paramsInput.nameMethod;
                var rowId = paramsInput.rowId;

                nameMethod({
                    objSelector: el, rowId: paramsInput.rowId, modelId: rowId
                });
            }
        }
    }
    , props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var $scope = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id =  $businessManager.id;//this.configParams.business_id;
        const browserPrint = new ZebraBrowserPrintWrapper.default();
        this.browserPrint = browserPrint;
    },
    mounted: function () {
        componentThisProduct = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    validations: function () {
        var attributes = {
            "id": {}, "change": {},
            "code": {required, maxLength: Validators.maxLength(64)},
            "name": {required},
            "state": {required},
            "product_trademark_id_data": {required},
            "product_category_id_data": {required},
            "product_subcategory_id_data": {required},
            "source": {required},
            "description": {required},
            "code_provider": {maxLength: Validators.maxLength(80)},
            "code_product": {maxLength: Validators.maxLength(80)},
            "has_tax": {},
            "is_service": {},
            "sale_price": {required},
            "view_online": {},
            "product_measure_type_id_data": {required},
            //product_details_shipping_fee
            "product_details_shipping_fee_id": {},
            "height": {required},
            "length": {required},
            "width": {required},
            "weight": {required},
            'quantity_units': {},
            //product_by_stock
            /*   "min": {required},
               "max": {},*/
            "product_by_sizes_data": {},
            "product_by_color_data": {},


        };

        if (this.model.attributes['view_online']) {

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
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements":$buttonsManagements,
                "buttonsProcess":$buttonsProcess

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
            tabCurrentSelector: '.content',
            processName: "Registro Acción.",
            formConfig: {
                nameSelector: "#product-form",
                url: $('#action-product-saveData').val(),
                loadingMessage: 'Guardando...',
                errorMessage: 'Error al guardar el Product.',
                successMessage: 'El Product se guardo correctamente.',
                nameModel: "Product"
            },
//Grid config
            gridConfig: {
                selectorCurrent: "#product-grid",
                url: $("#action-product-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            configModalProductByMultimedia: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalLanguageProduct: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalProductSaveDataInputOutput: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
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

            },
            configModalProductByRouteMap: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            browserPrint: null,
            printManager: {
                allowViewAmount: false,
                amountPrint: 1,
                product: {
                    nombre: "Alex",
                    ubicacion: "Sistemas",
                    cantidad: 22,
                    unidad_medida: "MD",
                    codigo: "ALEX",
                },

            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        ...$methodsManagerProcess,

        calculateFontSize: function (nombre, max) {
            if (nombre.length < 20)
                return max;
            let aux = Math.round(max * (19 / nombre.length))
            if (aux < 12)
                return 12;
            else
                return aux;
        },
        initCurrentComponent: function () {

            this.initGridManager(this);
        },
        getDataApiZPL() {
            var zpl = "^xa^LH0000,0000^FO0060,0115^A0N,80,40^FD99999^FS^cfa,50^fo100,100^fdHello World^fs^xz";
            var url = 'http://api.labelary.com/v1/printers/8dpmm/labels/4x6/0/';

            var formData = new FormData();
            formData.append('file', new Blob([zpl], {type: 'text/plain'}), 'label.zpl');

            fetch(url, {
                method: 'POST',
                body: formData
            })
                .then(response => response.blob())
                .then(blob => {
                    var url = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'label.png';
                    a.click();
                    URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Error al imprimir etiqueta ZPL: ', error));

        },
        onPrintZebra: async function () {
            try {
                let allowViewAmount = this.printManager.allowViewAmount;
                let desplazamientoIzq = 275;
                let desplazamientoDer = 340;
                let cantidadEtiq = this.printManager.amountPrint;
                let producto = this.printManager.product;

                const defaultPrinter = await this.browserPrint.getDefaultPrinter();
                this.browserPrint.setPrinter(defaultPrinter);
                const printerStatus = await this.browserPrint.checkPrinterStatus();
                // Check if the printer is ready
                if (printerStatus.isReadyToPrint) {
                    let zpl = '';
                    let size = this.calculateFontSize(producto.nombre, 30);

                    if (!allowViewAmount) {
                        let size2 = this.calculateFontSize(producto.ubicacion, 30);
                        zpl = `^XA
                          ^CF0,${size}
                          ^BY2,1,80
                          ^FO${desplazamientoIzq},10^FD${producto.nombre}^FS
                          ^FO${desplazamientoIzq},65^BC^FD${producto.codigo}^FS
                          ^CF0,${size2}
                          ^FO${desplazamientoIzq},200^FD${producto.ubicacion}^FS
                          ^XZ`;
                    } else {
                        let size2 = this.calculateFontSize(producto.ubicacion, 27);
                        zpl = `^XA
                          ^CF0,${size}
                          ^BY2,1,80
                          ^FO${desplazamientoIzq},10^FD${producto.nombre}^FS
                          ^FO${desplazamientoIzq},45^BC^FD${producto.codigo}^FS
                          ^CF0,27
                          ^FO${desplazamientoIzq},155^FDCantidad: ${producto.cantidad}^FS
                          ^FO${desplazamientoIzq},180^FDUnidad: ${producto.unidad_medida}^FS
                          ^CF0,${size2}
                          ^FO${desplazamientoIzq},205^FD${producto.ubicacion}^FS
                          ^XZ`;
                    }

                    for (let index = 0; index < cantidadEtiq; index++) {

                        this.browserPrint.print(zpl);
                    }
                } else {
                    alert("Error/s", printerStatus.errors);

                }
            } catch (error) {
                alert(error.msj);
            }


        },
//EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
                if (emitValues.allowReload) {
                    $(this.gridConfig.selectorCurrent).bootgrid("reload");

                }
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
                    params: params,
                    isUrl: value["isUrl"],
                    url: value["url"],
                }
                result.push(setPush);
            });
            return result;
        },
        _gridManager: function (elementSelect) {
            var $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            _gridManagerRows({
                thisCurrent: $scope,
                elementSelect: elementSelect,

            });
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            var $scope = this;
            if (params.managerType == "updateEntity") {
                var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
                this._destroyTooltip(elementDestroy);
                this.managerMenuConfig.view = false;
                this.resetForm();
                this.model.attributes.id = rowCurrent.id;
                this.model.attributes.code = rowCurrent.code;
                this.model.attributes.name = rowCurrent.name;
                this.model.attributes.state = rowCurrent.state;
                this.model.attributes.product_details_shipping_fee_id = rowCurrent.product_details_shipping_fee_id;
                this.model.attributes.height = parseFloat(rowCurrent.height != null ? rowCurrent.height : 0);
                this.model.attributes.length = parseFloat(rowCurrent.length != null ? rowCurrent.length : 0);
                this.model.attributes.width = parseFloat(rowCurrent.width != null ? rowCurrent.width : 0);
                this.model.attributes.weight = parseFloat(rowCurrent.weight != null ? rowCurrent.weight : 0);
                this.model.attributes.quantity_units = parseFloat(rowCurrent.quantity_units != null ? rowCurrent.quantity_units : 0);


                this.model.attributes.product_trademark_id_data = {
                    id: rowCurrent.product_trademark_id,
                    text: rowCurrent.product_trademark
                };
                this.model.attributes.product_category_id_data = {
                    id: rowCurrent.product_category_id,
                    text: rowCurrent.product_category
                };
                this.model.attributes.product_subcategory_id_data = {
                    id: rowCurrent.product_subcategory_id,
                    text: rowCurrent.product_subcategory
                };
                this.model.attributes.source = rowCurrent.source;
                this.model.attributes.description = (rowCurrent.description != null || rowCurrent.description != "null") ? rowCurrent.description : "";
                this.model.attributes.code_provider = (rowCurrent.code_provider != null || rowCurrent.code_provider != "null") ? rowCurrent.code_provider : "";
                this.model.attributes.code_product = (rowCurrent.code_product != null || rowCurrent.code_product != "null") ? rowCurrent.code_product : "";
                this.model.attributes.has_tax = rowCurrent.has_tax == 1 ? true : false;
                this.model.attributes.is_service = rowCurrent.is_service == 1 ? true : false;
                this.model.attributes.view_online = rowCurrent.view_online == 1 ? true : false;

                this.model.attributes.product_measure_type_id_data = {
                    id: rowCurrent.product_measure_type_id,
                    text: rowCurrent.product_measure_type
                };
                this.model.attributes.sale_price = parseFloat(rowCurrent.sale_not_tax);
                this.model.attributes.product_inventory_id = (rowCurrent.product_inventory_id);

                this.model.attributes.product_by_color_data = rowCurrent['colors'];
                this.model.attributes.product_by_sizes_data = rowCurrent['sizes'];


                this._viewManager(3, rowId);
            } else if (params.managerType == 'languageEntity') {
                this.configModalLanguageProduct.data = rowCurrent;
                if (this.configModalLanguageProduct.viewAllow) {

                } else {
                    this.configModalLanguageProduct.viewAllow = true;
                }
            } else if (params.managerType == 'productSaveDataInputOutput') {
                this.configModalProductSaveDataInputOutput.data = rowCurrent;
                if (this.configModalProductSaveDataInputOutput.viewAllow) {

                } else {
                    this.configModalProductSaveDataInputOutput.viewAllow = true;
                }
            } else if (params.managerType == 'managerRouteMap') {
                var urlCurrent = $('#action-product-by-route-map-getRouteProduct').val();
                var dataSend = {
                    product_id: rowCurrent.id
                };
                var blockElement = '.content-page';
                var loading_message = 'Cargando...';
                var error_message = 'Error al cargar.!';
                var success_message = 'Datos cargados con exito!';
                ajaxRequest(urlCurrent, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: blockElement,//opcional: es para bloquear el elemento
                    loading_message: loading_message,
                    error_message: error_message,
                    success_message: success_message,
                    success_callback: function (response) {
                        var dataCurrent = rowCurrent;
                        if (response.data.hasOwnProperty('product_by_route_map_id')) {
                            dataCurrent['product_by_route_map_id'] = response.data.product_by_route_map_id;
                            dataCurrent['management'] = response.data;
                        }
                        $scope.configModalProductByRouteMap.data = dataCurrent;

                        if ($scope.configModalProductByRouteMap.viewAllow) {
                            $scope.$refs.refProductByRouteMap._setValueOfParent(
                                {type: "openModal", data: this.configModalProductByRouteMap}
                            );
                        } else {
                            $scope.configModalProductByRouteMap.viewAllow = true;
                        }
                    }
                });


            } else {
                this.configModalProductByMultimedia.data = rowCurrent;
                if (this.configModalProductByMultimedia.viewAllow) {
                    this.$refs.refProductByMultimedia._setValueOfParent(
                        {type: "openModal", data: this.configModalProductByMultimedia}
                    );
                } else {
                    this.configModalProductByMultimedia.viewAllow = true;
                }
            }


        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                business_id: this.business_id
            };
            var structure = $scope.model.structure;
            var formatters = getFormatterProcess({
                'structure': structure,
                'vmCurrent': $scope,
                'processName': 'products',
                'viewAll': true,

            });

            let gridInit = initGridManager({
                gridNameSelector: gridName,
                paramsFilters: paramsFilters,
                formatters: formatters,
                'urlCurrent': urlCurrent
            });

            gridInit.on("loaded.rs.jquery.bootgrid", function () {
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
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
            var result = false;
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
                quantity_units: {
                    id: "quantity_units",
                    name: "quantity_units",
                    label: "Cantidad Existente",
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
            var product_trademark_id_data = null;
            if ($configPartial['valuesDefaultForm']['tradeMark']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['tradeMark']['data'];
                product_trademark_id_data = {
                    id: dataCurrent.id,
                    text: dataCurrent.value,
                };
            }

            var product_category_id_data = null;
            if ($configPartial['valuesDefaultForm']['category']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['category']['data'];
                product_category_id_data = {
                    id: dataCurrent.id,
                    text: dataCurrent.value,
                };
            }
            var product_subcategory_id_data = null;
            if ($configPartial['valuesDefaultForm']['subcategory']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['subcategory']['data'];
                product_subcategory_id_data = {
                    id: dataCurrent.id,
                    text: dataCurrent.value,
                };
            }
            var product_measure_type_id_data = null;

            if ($configPartial['valuesDefaultForm']['measureType']['success']) {
                var dataCurrent = $configPartial['valuesDefaultForm']['measureType']['data'];
                product_measure_type_id_data = {
                    id: dataCurrent.id,
                    text: dataCurrent.value,
                };
            }
            var result = {
                "id": null,
                "change": false,
                "code": null,
                "name": null,
                "state": "ACTIVE",
                "view_online": false,
                "product_trademark_id_data": product_trademark_id_data,
                "product_category_id_data": product_category_id_data,
                "product_subcategory_id_data": product_subcategory_id_data,
                "source": null,
                "description": null,
                "code_provider": null,
                "code_product": null,
                "has_tax": null,
                "is_service": null,
                "sale_price": 0,
                "product_measure_type_id_data": product_measure_type_id_data,
                "product_by_color_data": null,
                "product_by_sizes_data": null,
                "product_details_shipping_fee_id": null,
                "height": 0,
                "length": 0,
                "width": 0,
                "weight": 0,
                "quantity_units": 0
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
//Manager Model

        getValuesSave: function () {
            var dataCurrentKeys = [];
            var dataCurrentGet = this.$v.model.attributes.product_by_sizes_data.$model;
            $.each(dataCurrentGet, function (key, value) {
                var setPush = value.id;
                dataCurrentKeys.push(setPush);
            });
            dataCurrentKeys = dataCurrentKeys.join(',');
            var product_by_sizes_data = dataCurrentKeys;

            dataCurrentKeys = [];
            dataCurrentGet = this.$v.model.attributes.product_by_color_data.$model;
            $.each(dataCurrentGet, function (key, value) {
                var setPush = value.id;
                dataCurrentKeys.push(setPush);
            });
            dataCurrentKeys = dataCurrentKeys.join(',');
            var product_by_color_data = dataCurrentKeys;
            var taxIdZero = $configPartial.managerProduct.data.taxCurrentZero.id;
            var taxIdCurrent = $configPartial.managerProduct.data.taxCurrent.id;
            var tax_id = this.$v.model.attributes.has_tax.$model == null ? taxIdZero : (this.$v.model.attributes.has_tax.$model == true ? taxIdCurrent : taxIdZero);

            var result = {
                    "id": this.$v.model.attributes.id.$model ? this.$v.model.attributes.id.$model : -1,
                    change: this.$v.model.attributes.change.$model,
                    "code": this.$v.model.attributes.code.$model,
                    "name": this.$v.model.attributes.name.$model,
                    "state": this.$v.model.attributes.state.$model,
                    "product_trademark_id": this.$v.model.attributes.product_trademark_id_data.$model.id,
                    "product_category_id": this.$v.model.attributes.product_category_id_data.$model.id,
                    "product_subcategory_id": this.$v.model.attributes.product_subcategory_id_data.$model.id,
                    "source": this.$v.model.attributes.source.$model,
                    "description": this.$v.model.attributes.description.$model,
                    "code_provider": this.$v.model.attributes.code_provider.$model,
                    "code_product": this.$v.model.attributes.code_product.$model,
                    "has_tax": this.$v.model.attributes.has_tax.$model == null ? 0 : (this.$v.model.attributes.has_tax.$model ? 1 : 0),
                    "is_service": 0,
                    "view_online": this.$v.model.attributes.view_online.$model == null ? 0 : (this.$v.model.attributes.view_online.$model ? 1 : 0),
                    "product_measure_type_id": this.$v.model.attributes.product_measure_type_id_data.$model.id,
                    business_id: this.business_id,
                    tax_id: tax_id,
                    location_details: 'none',
                    stock_control: 0,
                    ice_control: 0,
                    initial_stock_control: 0,
                    "sale_price": this.$v.model.attributes.sale_price.$model,
                    "product_inventory_id": this.model.attributes.product_inventory_id,
                    "product_by_sizes_data": product_by_sizes_data,
                    "product_by_color_data": product_by_color_data,
                    "product_details_shipping_fee_id": this.$v.model.attributes.product_details_shipping_fee_id.$model,
                    "height": this.$v.model.attributes.height.$model,
                    "length": this.$v.model.attributes.length.$model,
                    "width": this.$v.model.attributes.width.$model,
                    "weight": this.$v.model.attributes.weight.$model,
                    "quantity_units": this.$v.model.attributes.quantity_units.$model
                }
            ;

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
                }, true);


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
        _managerS2ProductTrademark: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (this.model.attributes.product_trademark_id_data.hasOwnProperty('id')) {

                dataCurrent = [this.model.attributes.product_trademark_id_data];
            }
            var $scope = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-trademark-getListSelect2").val(),
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
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                $scope.model.attributes.product_trademark_id_data = data;
            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.product_trademark_id_data = null;
                $scope._setValueForm('product_trademark_id_data', null);
            });
        }, _managerS2ProductCategory: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (this.model.attributes.product_category_id_data.hasOwnProperty('id')) {

                dataCurrent = [this.model.attributes.product_category_id_data];
            }
            var $scope = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-category-getListSelect2").val(),
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
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                $scope.model.attributes.product_category_id_data = data;
                $("#product_subcategory_id_data").val('').trigger('change');
                $scope.model.attributes.product_subcategory_id_data = null;
            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.product_category_id_data = null;
                $scope._setValueForm('product_category_id_data', null);
                $scope.model.attributes.product_subcategory_id_data = null;


            });
        }, _managerS2ProductSubcategory: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (this.model.attributes.product_subcategory_id_data.hasOwnProperty('id')) {

                dataCurrent = [this.model.attributes.product_subcategory_id_data];
            }
            var $scope = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-subcategory-getListSelect2").val(),
                    type: 'get',
                    dataType: 'json',
                    data: function (term, page) {

                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                product_category_id: $scope.model.attributes.product_category_id_data.id
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
                var data = e.params.data;
                $scope.model.attributes.product_subcategory_id_data = data;
            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.product_subcategory_id_data = null;
                $scope._setValueForm('product_subcategory_id_data', null);
            });
        }, _managerS2ProductMeasureType: function (params) {
            var el = params.objSelector;
            var valueCurrentRowId = params.rowId;
            var dataCurrent = [];
            if (this.model.attributes.product_measure_type_id_data.hasOwnProperty('id')) {

                dataCurrent = [this.model.attributes.product_measure_type_id_data];
            }
            var $scope = this;
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                data: dataCurrent,
                ajax: {
                    url: $("#action-product-measure-type-getListSelect2").val(),
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
                multiple: false,
                width: '100%'
            });

            elementInit.on('select2:select', function (e) {
                var data = e.params.data;
                $scope.model.attributes.product_measure_type_id_data = data;
            }).on("select2:unselecting", function (e) {
                $scope.model.attributes.product_measure_type_id_data = null;
                $scope._setValueForm('product_measure_type_id_data', null);
            });
        },
        _managerS2Colors: function (params) {
            var el = params.objSelector;
            var modelId = params.modelId;
            var dataCurrent = [];
            var $scope = this;
            var businessId = null;
            var attributeModel = 'product_by_color_data';
            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-product-color-listSelect2").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: businessId
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
                    $scope.model.attributes[attributeModel] = dataCurrent;
                } else {
                    $scope.model.attributes[attributeModel] = null;
                    $scope._setValueForm(attributeModel, null);

                }
            });

            if (modelId) {
                $scope.setValuesS2Multiple({
                    valueCurrent: modelId,
                    elementS2: $(el),
                    attributeModel: attributeModel,
                    'types': 'colors'
                });
            }
        },
        _managerS2Sizes: function (params) {
            var el = params.objSelector;
            var modelId = params.modelId;
            var dataCurrent = [];
            var $scope = this;
            var businessId = null;
            var attributeModel = 'product_by_sizes_data';

            var elementInit = $(el).select2({
                allow: true,
                placeholder: "Seleccione",
                ajax: {// instead of writing the function to execute the request we use Select2's convenient helper
                    url: $("#action-product-sizes-listSelect2").val(),
                    type: "get",
                    dataType: 'json',
                    data: function (term, page) {
                        var paramsFilters = {
                            filters: {
                                search_value: term,
                                business_id: businessId
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
                    $scope.model.attributes[attributeModel] = dataCurrent;
                } else {
                    $scope.model.attributes[attributeModel] = null;
                    $scope._setValueForm(attributeModel, null);
                }
            });

            if (modelId) {
                $scope.setValuesS2Multiple({
                    modelId: modelId,
                    elementS2: $(el),
                    attributeModel: attributeModel,
                    'types': 'sizes'
                });
            }

        },
        setValuesS2Multiple: function (params) {
            var modelId = params['modelId'];//id
            var elementS2 = params['elementS2'];
            var attributeModel = params['attributeModel'];
            var modelData = this.model.attributes[attributeModel];
            if (modelData.length) {
                dataCurrent = modelData;
                $.each(dataCurrent, function (key, value) {
                    var option = new Option(value.text, value.id, true, true);
                    elementS2.append(option).trigger('change');
                });
                var dataCurrent = elementS2.select2('data');
                this.model.attributes[attributeModel] = dataCurrent;
            }

        },
        //uploads methods
        _uploadDataImage: function (eventSelector) {
            var selectorFile = $.UploadUtil.getSelectorElementUploadFile({
                toElement: eventSelector.toElement
            });
            selectorFile = '#file-' + selectorFile;
            $(selectorFile).click();
            eventSelector.stopPropagation();
        },
        getAttributesManagerUpload: function (params) {
            var nameField = params['nameField'];
            var modelCurrent = params['modelCurrent'];

            var result = {};
            if (nameField == 'source') {
                result = {
                    'selectorUpload': '#file-' + nameField,
                    'selectorPreview': '#preview-' + nameField,
                    'modelCurrent': modelCurrent,
                    'modelAttributeName': nameField,
                };
            }
            return result;
        },
        _managerEventsUpload: function (params) {
            var selectorUpload = params['selectorUpload'];
            var selectorPreview = params['selectorPreview'];
            var modelCurrent = params['modelCurrent'];
            $.UploadUtil.managerUploadModel(params);
        }
    }
})
;




