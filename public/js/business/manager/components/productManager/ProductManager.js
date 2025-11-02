var CONFIG_PRODUCT_PARENT_BY_PRODUCT = {
    'process': 'product_parent_by_product_manager',
    'model': 'ProductParentByProduct',
    'product': {
        getStructureForm: {
            code: {
                id: "code", name: "code", label: "Codigo", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 64.",
                },
            }, quantity_units: {
                id: "quantity_units", name: "quantity_units", label: "Cantidad Existente", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 64.",
                },
            },

            name: {
                id: "name", name: "name", label: "Nombre", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, state: {
                id: "state", name: "state", label: "Estado", required: {
                    allow: true, msj: "Campo requerido.", error: false
                }, options: [{"value": "ACTIVE", "text": "ACTIVE"}, {"value": "INACTIVE", "text": "INACTIVE"}]
            }, product_trademark_id_data: {
                id: "product_trademark_id_data", name: "product_trademark_id_data", label: "Marca", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, product_category_id_data: {
                id: "product_category_id_data", name: "product_category_id_data", label: "Categoria", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, product_subcategory_id_data: {
                id: "product_subcategory_id_data",
                name: "product_subcategory_id_data",
                label: "Subcategoria",
                required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, source: {
                id: "source", name: "source", label: "Imagen", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, description: {
                id: "description", name: "description", label: "Descripcion", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, code_provider: {
                id: "code_provider", name: "code_provider", label: "Codigo Proveedor", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 80.",
                },
            }, code_product: {
                id: "code_product", name: "code_product", label: "Codigo Producto", required: {
                    allow: false, msj: "Campo requerido.", error: false
                }, maxLength: {
                    msj: "# Carecteres Excedidos a 80.",
                },
            }, has_tax: {
                id: "has_tax", name: "has_tax", label: "Tiene Iva?", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, is_service: {
                id: "is_service", name: "is_service", label: "is service", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, view_online: {
                id: "view_online", name: "view_online", label: "Ver Tienda Online?", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, product_measure_type_id_data: {
                id: "product_measure_type_id_data",
                name: "product_measure_type_id_data",
                label: "Medida",
                required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, sale_price: {
                id: "sale_price", name: "sale_price", label: "Precio Sin Iva", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, product_by_color_data: {
                id: "product_by_color_data", name: "product_by_color_data", label: "Colores", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, product_by_sizes_data: {
                id: "product_by_sizes_data", name: "product_by_sizes_data", label: "Tamaño", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            }, height: {
                id: "height", name: "height", label: "Alto(cm)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, length: {
                id: "length", name: "length", label: "Largo(cm)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, width: {
                id: "width", name: "width", label: "Ancho(cm)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, weight: {
                id: "weight", name: "weight", label: "Peso(kg)", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, title: {
                id: "title", name: "title", label: "Meta titulo", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, keyword: {
                id: "keyword", name: "keyword", label: "Palabras clave Meta", required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }, description_meta: {
                id: "description_meta", name: "description_meta", label: "Meta descripcion", required: {
                    allow: false, msj: "Campo requerido.", error: false
                },
            },
            product_by_package_data: {
                id: "product_by_package_data",
                name: "product_by_package_data",
                label: "Metodos de empaque para venta",
                required: {
                    allow: true, msj: "Campo requerido.", error: false
                },
            }
        }
    }

};
var CONFIG_PRODUCT = {
    'process': 'product_parent_by_product',
    'model': 'ProductParentByProduct'
};
var configProductByLogInventory = {
    'model': 'ProductByLogInventory',
    process: 'product_by_log_inventory'
};
Vue.component(CONFIG_PRODUCT_PARENT_BY_PRODUCT.process + '-component', {
        template: '#' + CONFIG_PRODUCT_PARENT_BY_PRODUCT.process + '-template',
        directives: {}, props: {
            params: {
                type: Object,
            }
        }, created: function () {
            this.configParams = this.params;
            this.business_id = $businessManager.id;
            this.product_parent_id = this.params.managerSteps.process.parent_id;
        },
        beforeMount: function () {


        },
        mounted: function () {
            this.initCurrentComponent();
            componentThisProductManager = this;

        },

        data: function () {
            var dataManager = {
                    ...$staticsVariables, /*  ----MANAGER ENTITY---*/
                configModelEntity
        :
            {
                "buttonsManagements"
            :
                [{
                    "title": "Actualizar",
                    "data-placement": "top",
                    "i-class": " fas fa-pencil-alt",
                    "managerType": "updateEntity"
                }, {
                    "title": "Inventario Administracion",
                    "data-placement": "top",
                    "i-class": " fas fa-tags",
                    "managerType": "productByLogInventory"
                }
                ]
            }
        ,
            managerMenuConfig: {
                view: false, menuCurrent
            :
                [], rowId
            :
                null
            }
        ,
            configParams: {
            }
        ,
            labelsConfig: {
                buttons: {
                    'create'
                :
                    'Crear', 'update'
                :
                    'Actualizar'
                }
            }
        ,

//form config
            model: {
                attributes: this.getAttributesForm(), structure
            :
                this.getStructureForm(),
            }
        ,
            tabCurrentSelector: '.content',
                processName
        :
            "Registro Acción ------------>PRODUCT MANAGER.",
                formConfig
        :
            {
                nameModel: +CONFIG_PRODUCT_PARENT_BY_PRODUCT.model
            }
        , //Grid config
            gridConfig: {
                selectorCurrent: "#" + CONFIG_PRODUCT_PARENT_BY_PRODUCT.process + "-grid",
                    url
            :
                $("#action-" + CONFIG_PRODUCT_PARENT_BY_PRODUCT.process + "-getAdmin").val()
            }
        ,
            submitStatus: "no",
                showManager
        :
            false,
                showManagerReturn
        :
            false,

                managerSteps
        :
            this.getDataManagerSteps(),
                managerType
        :
            null,
                configModalProductByMultimedia
        :
            {
                "title"
            :
                "Title", "viewAllow"
            :
                false, "data"
            :
                []
            }
        ,
            configModalLanguageProduct: {
                "title"
            :
                "Title", "viewAllow"
            :
                false, "data"
            :
                []
            }
        ,
            configModalProductSaveDataInputOutput: {
                "title"
            :
                "Title", "viewAllow"
            :
                false, "data"
            :
                []
            }
        ,
            configModalProductByLogInventory: {
                "title"
            :
                "Title", "viewAllow"
            :
                false, "data"
            :
                []
            }
        ,
            process_table: CONFIG_PRODUCT_PARENT_BY_PRODUCT.process,
                product_parent_id
        :
            null, business_id
        :
            null,
                managerViewProductParent
        :
            {
            }
        }
            ;


            return dataManager;
        },
        methods: {
            ...$methodsFormValid,
        onViewProcessProductParent: function (params) {
            if (params.type == 1) {

                $('#product_parent-a').click();

            } else if (params.type == 8) {

                $('#return-product_parent').click();


            } else if (params.type == 2) {
                $('#product_by_manager_process-a').click();
                $('#product_parent_by_prices-li').children().click();

            } else if (params.type == 3) {
                $('#product_by_manager_process-a').click();
                $('#product_parent_by_package_params-li').children().click();

            }

        },
        getManagerViewProductParent: function () {

        },
        getDataManagerSteps: function () {
            var result = {

                process: {
                    isCreate: true,
                    parent_id: null,
                    data: null,
                    buttonsManager: {
                        one: {
                            title: 'Guardar', icon: '->', allow: false, class: 'btn--manager-process',

                        }, two: {
                            title: 'Regresar', icon: '', allow: false, class: 'btn--manager-return',
                        }
                    },
                },
                config: {
                    showManager: false,
                    show: false,
                    type: $staticsVariables.TYPE_REGISTER_STEPS
                }, one: {
                    header: {
                        title: 'Producto ',
                        number: 1
                    }, messages: {
                        one: {
                            title: 'Informacion General',
                            value: 'Complete toda la informacion del producto principal a continuacion.',
                        }
                    },
                    data: {}

                }, two: {
                    header: {
                        title: 'Detalles del producto',
                        number: 2
                    }, messages: {
                        one: {
                            title: 'Descripcion especifica del producto',
                            value: 'Al completar la informacoin del producto sera la descripcion usada en nuestra pagina web',
                        }
                    }, body: {},
                }, three: {

                    header: {
                        title: 'Imagenes del producto', number: 3
                    }, messages: {
                        one: {
                            title: 'Imagenes del producto',
                            value: 'Subir imagen del producto Max Cantidad 5, la primera imagen siempre sera la principal.',
                        },
                    }, body: {
                        data: []
                    }
                }, four: {

                    header: {
                        title: 'Meta data producto', number: 4
                    }, messages: {
                        one: {
                            title: 'Meta data del producto',
                            value: 'Informacion que sirve para los vinculos internos y se puede editar para el momento de compartir esta informacion',
                        },
                    }, body: {}
                },

            };
            console.log(result);
            return result;
        },
        initEmmitFromComponents: function () {
            this.$parent.$on('message-to-' + this.process_table, this.handleMessageFromParent);
        },
        destroyEmmitFromComponents: function () {
            this.$parent.$off('message-to-' + this.process_table, this.handleMessageFromParent);
        },
        handleMessageFromParent: function (params) {
            if (params.type == 'onSaveModelComponent') {
                this.product_parent_id = params.data.information['ProductParent'].id;
            }
        },
        resetAllProcessData: function () {
            this.managerSteps = this.getDataManagerSteps();
        }, initCurrentComponent: function () {

            this.initGridManager(this);
        },
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
        /*---------GRID--------*/
        ...$methodsBootgrid,
    getMenuConfig
:

function (params) {
    var result = [];
    $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
        var setPush = {
            title: value["title"],
            "data-placement": value["data-placement"],
            icon: value["i-class"],
            data: value,
            rowId: params.rowId,
            managerType: value["managerType"],
            params: params,
            isUrl: value["isUrl"],
            url: value["url"],
        }
        result.push(setPush);

    });
    console.log(params);
    if (!params.newEventRow) {
        this.showManagerReturn = false;
        this.showManager = false;
    } else {

        this.showManagerReturn = false;
        this.showManager = true;
    }

    //puta
    return result;
}

,
_managerRowGrid: function (params) {
    var rowCurrent = params.row;
    var rowId = params.id;
    var $scope = this;
    if (params.managerType == "updateEntity") {
        var elementDestroy = ("#a-menu-" + this.managerMenuConfig.rowId);
        this._destroyTooltip(elementDestroy);
        this.managerMenuConfig.view = false;
        this.managerSteps.one.data = rowCurrent;
        this.managerSteps.process.parent_id = rowCurrent.id;
        this.managerSteps.process.data = rowCurrent;
        this.managerSteps.three.body.data = rowCurrent.images;
        this._viewManager(3, rowId);

    } else if (params.managerType == 'languageEntity') {
        this.configModalLanguageProduct.data = rowCurrent;
        if (this.configModalLanguageProduct.viewAllow) {

        } else {
            this.configModalLanguageProduct.viewAllow = true;
        }
    } else if (params.managerType == 'productByLogInventory') {
        var keyOperation = "configModal" + configProductByLogInventory.model;
        var currentProcess = this[keyOperation];
        currentProcess.data = rowCurrent;
        if (currentProcess.viewAllow) {

        } else {
            currentProcess.viewAllow = true;
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
                    $scope.$refs.refProductByRouteMap._setValueOfParent({
                        type: "openModal",
                        data: this.configModalProductByRouteMap
                    });
                } else {
                    $scope.configModalProductByRouteMap.viewAllow = true;
                }
            }
        });


    } else {
        this.configModalProductByMultimedia.data = rowCurrent;
        if (this.configModalProductByMultimedia.viewAllow) {
            this.$refs.refProductByMultimedia._setValueOfParent({
                type: "openModal",
                data: this.configModalProductByMultimedia
            });
        } else {
            this.configModalProductByMultimedia.viewAllow = true;
        }
    }


}
,
initGridManager: function ($scope) {
    var _this = this;
    var gridName = this.gridConfig.selectorCurrent;
    var urlCurrent = this.gridConfig.url;
    var paramsFilters = {
        business_id: this.business_id,
        product_parent_id: this.product_parent_id
    };
    var structure = $scope.model.structure;
    var formatters = {
        'check-list-manager': function (column, row) {
            var key_id = row.id;
            return '<input class="check-list-manager"  id="checkbox-' + key_id + '" name="select" type="checkbox" class="select-box" value="' + key_id + '">';
        },
        'code_name': function (column, row) {

            var rowsData = row.images;
            var allowViewImage = false;
            var dataViewImage = false;

            $.each(rowsData, function (key, value) {
                if (value.priority == 1) {
                    allowViewImage = true;
                    dataViewImage = value;
                }
            });
            var imageCurrent = '';
            if (allowViewImage) {
                var sourceCurrent = $publicAsset + dataViewImage.source;
                imageCurrent = '<img  class=" content-description__photos--img-row" src="' + sourceCurrent + '" alt="">';
            }
            var result = [
                "<table class='manager-information'>",
                "<tbody>",
                "     <tr class='manager-information__tr'>",
                "          <td  class='manager-information__td-img'>",
                imageCurrent,
                "         </td>",
                "       <td class='manager-information__td-information'>",

                "        <div class='manager-information__td-information-title'>" + row.code + "</div> ",
                "            <div class='manager-information__td-information-description'>" + row.name + "<div>",
                "        </td>",
                "     </tr>",
                "</tbody>",
                "</table>"];

            return result.join("");
        },
        'state': function (column, row) {

            var stateValue = row["state"];
            var stateText = stateValue == 'ACTIVE' ? "Activo" : 'Inactivo';
            var stateClass = stateValue == 'ACTIVE' ? "content-description__value--state-text-success" : 'content-description__value--state-text-warning';

            var result = ["<div class='content-description'>"];

            result.push("  <span class='content-description__value " + stateClass + "'>" + stateText + "</span> <br>");
            result.push(" </div>");

            return result.join("");
        },
        'packages': function (column, row) {

            var rowsData = row["packages"];
            var result = ["<div class='product_parent_by_package_params_data'>"];
            $.each(rowsData, function (key, value) {
                result.push("  <span class='content-description__value'>* " + value.name + "</span> <br>");
            });

            result.push(" </div>");

            return result.join("");
        },
        'description': function (column, row) {
            var classStatus = "badge-success";
            var variantColors = row.colors;
            var variantSizes = row.sizes;
            var dataCurrentGet = variantSizes;
            var variantSizesHtml = [];
            $.each(dataCurrentGet, function (key, value) {
                variantSizesHtml.push(value.text);
            });
            variantSizesHtml = variantSizesHtml.join(",");
            variantSizesHtml = variantSizesHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.product_by_sizes_data.label + '</span>:<span class=\'content-description__value\'>' + variantSizesHtml + ".</span></div>" : "";

            dataCurrentGet = variantColors;
            var variantColorsHtml = [];
            $.each(dataCurrentGet, function (key, value) {
                variantColorsHtml.push(value.text);
            });

            variantColorsHtml = variantColorsHtml.join(",");
            variantColorsHtml = variantColorsHtml != "" ? "<span class='content-description__information'><span class='content-description__title'>" + structure.product_by_color_data.label + '</span>:<span class=\'content-description__value\'>' + variantColorsHtml + ".</span></div>" : "";
            var shippingFeeAll = [];
            if (row.height != null) {
                shippingFeeAll = [
                    '<div class="content-description__details">',
                    "   <h2 class='content-description__title-details'>Configuracion Envios </h2>",
                    " <div class='content-description__information'> <span class='content-description__information'><span class='content-description__title'>" + structure.height.label + '</span>:<span class=\'content-description__value\'>' + row.height + ".</span></div>",
                    "  <div class='content-description__information'> <span class='content-description__information'><span class='content-description__title'>" + structure.length.label + '</span>:<span class=\'content-description__value\'>' + row.length + ".</span></div>",
                    " <div class='content-description__information'>  <span class='content-description__information'><span class='content-description__title'>" + structure.width.label + '</span>:<span class=\'content-description__value\'>' + row.width + ".</span></div>",
                    " <div class='content-description__information'>  <span class='content-description__information'><span class='content-description__title'>" + structure.weight.label + '</span>:<span class=\'content-description__value\'>' + row.width + ".</span></div>",

                    '</div >'

                ];
            }
            var product_by_meta_data = row.product_by_meta_data;
            var rowMeta = product_by_meta_data[0];
            var metaData = [
                '<div class="content-description__details">',
                "   <h2 class='content-description__title-details'>" + _this.managerSteps.four.messages.one.title + "</h2>",
                "  <div class='content-description__information'> <span class='content-description__information'><span class='content-description__title'>" + structure.title.label + '</span>:<span class=\'content-description__value\'>' + rowMeta.title + ".</span></div>",
                " <div class='content-description__information'>  <span class='content-description__information'><span class='content-description__title'>" + structure.keyword.label + '</span>:<span class=\'content-description__value\'>' + rowMeta.keyword + ".</span></div>",
                "  <div class='content-description__information'> <span class='content-description__information'><span class='content-description__title'>" + structure.description_meta.label + '</span>:<span class=\'content-description__value\'>' + rowMeta.description + ".</span></div>",

                '</div >'

            ];
            shippingFeeAll = shippingFeeAll.join(" ");
            var variantAll = [];
            if (variantColorsHtml != '' || variantSizesHtml != '') {
                variantAll = [
                    '<div class="content-description__details">',
                    variantColorsHtml == "" ? "" : variantColorsHtml,
                    variantSizesHtml == "" ? "" : variantSizesHtml,
                    '</div >'

                ];
            }
            variantAll = variantAll.join(" ");
            if (row.status == "INACTIVE") {
                classStatus = "badge-warning";
            }
            var description = row.description != null ? [
                "<div class='content-description__information'>",
                "   <span class='content-description__title'>" + structure.description.label + ":</span><span class='content-description__value'>" + row.description + "</span>",
                "</div>"
            ] : [];
            description = description.join('');


            var result = [
                "<div class='content-description'>",
                "   <h2 class='content-description__title-details'>" + _this.managerSteps.one.messages.one.title + "</h2>",
                "<div class='content-description__information'>",
                "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                "</div>",
                "<div class='content-description__information'>",
                "   <span class='content-description__title'>" + structure.view_online.label + ":</span><span class='content-description__value'>" + "<span class='badge badge--size-large " + (row.view_online ? "badge-success" : "badge-warning") + "'>" + (row.view_online ? "SI" : "NO") + "</span>" + "</span>",
                "</div>",

                "<div class='content-description__information'>",
                "   <span class='content-description__title'>" + structure.code.label + ":</span><span class='content-description__value'>" + row.code + "</span>",
                "</div>",
                "<div class='content-description__information'>",
                "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                "</div>",
                "   <h2 class='content-description__title-details'>" + _this.managerSteps.two.messages.one.title + "</h2>",
                description,
                variantAll,
                metaData.join(''),
                shippingFeeAll,

                "  <div class='content-description__information'>",
                "       <span     class='content-description__title'>" + structure.product_measure_type_id_data.label + ":</span><span class='content-description__value'>" + row.product_measure_type + "</span>",
                "  </div>",
                "</div>"
            ];

            return result.join("");
        }
    };
    var headerTemplate = [
        '<div id="{{ctx.id}}" class="{{css.header}}">',
        '     <div class="row">',
        '         <div class="col-md-4 actionBar">',
        '             <div class="manager-inline-content manager-inline-content--align-left">',
        '                <div class="manager-inline">',
        '                    <span class="manager-inline__title"> Mostrar</span>',
        '                 </div>',
        '                 <div class="manager-inline">',
        '                   <p class="{{css.actions}}"></p>',
        '                </div>',
        '                <div class="manager-inline">',
        '                    <span class="manager-inline__title"> Productos</span>',
        '                 </div>',
        '             </div>',

        '         </div>',
        '         <div class="col-md-8 actionSearch">',
        '           <div class="manager-inline-content manager-inline-content--align-right">',
        '             <div class="manager-inline">',
        '                <span class="manager-inline__title"> Buscar</span>',
        '              </div>',
        '              <div class="manager-inline">',
        '                   <p class="{{css.search}}"></p>',
        '              </div>',
        '            </div>',

        '         </div>',
        '    </div>',
        '</div>'
    ];
    let gridInit = initGridManager({
        gridNameSelector: gridName,
        paramsFilters: paramsFilters,
        formatters: formatters,
        'urlCurrent': urlCurrent,
        templates: {
            header: headerTemplate.join("")
        }
    });

    gridInit.on("loaded.rs.jquery.bootgrid", function () {

        $scope.showManagerReturn = false;
        $scope.showManager = false;

        $scope._resetManagerGrid();
        $scope._gridManager(gridInit);
    });
}
, /*Manager FORMS-AND VIEWS*/
_viewManager: function (typeView, rowId) {

    if (typeView == 1) {//create
        //  this.resetForm();
        this.showManager = true;
        this.managerSteps.config.show = true;
        this.managerMenuConfig.view = false;

        this.showManagerReturn = true;
        showHideGridHeaderFooter({
            selectorGrid: this.gridConfig.selectorCurrent, hide: true,
        });
        this.managerType = 1;
        this.onInitEventClickTimerForm();//CHANGE-FORM

    } else if (typeView == 2) {//admin
        // this.resetForm();
        this.showManager = false;
        this.managerSteps.config.show = false;
        this.showManagerReturn = false;
        showHideGridHeaderFooter({
            selectorGrid: this.gridConfig.selectorCurrent, hide: false,
        });
        if (this.managerType == 1) {
            this.managerMenuConfig.view = false;
            this.managerType = null;

        } else {
            this.managerMenuConfig.view = true;
        }
    } else if (typeView == 3) {//update
        this.showManager = true;
        this.managerSteps.config.show = true;

        showHideGridHeaderFooter({
            selectorGrid: this.gridConfig.selectorCurrent, hide: true,
        });
        this.managerMenuConfig.view = false;
        this.managerType = 3;
        this.onInitEventClickTimerForm();//CHANGE-FORM

        this.showManagerReturn = true;
    }
}
, //FORM CONFIG
getViewErrorForm: function (objValidate) {
    var result = false;
    if (!objValidate.$dirty) {
        result = objValidate.$dirty ? (!objValidate.$error) : false;
    } else {
        result = objValidate.$error;
    }
    return result;
}
,
_submitForm: function (e) {
    console.log(e);
}
,
getStructureForm: function () {

    return CONFIG_PRODUCT_PARENT_BY_PRODUCT.product.getStructureForm;
}
,
getAttributesForm: function () {
    var product_trademark_id_data = null;
    if ($configPartial['valuesDefaultForm']['tradeMark']['success']) {
        var dataCurrent = $configPartial['valuesDefaultForm']['tradeMark']['data'];
        product_trademark_id_data = {
            id: dataCurrent.id, text: dataCurrent.value,
        };
    }

    var product_category_id_data = null;
    if ($configPartial['valuesDefaultForm']['category']['success']) {
        var dataCurrent = $configPartial['valuesDefaultForm']['category']['data'];
        product_category_id_data = {
            id: dataCurrent.id, text: dataCurrent.value,
        };
    }
    var product_subcategory_id_data = null;
    if ($configPartial['valuesDefaultForm']['subcategory']['success']) {
        var dataCurrent = $configPartial['valuesDefaultForm']['subcategory']['data'];
        product_subcategory_id_data = {
            id: dataCurrent.id, text: dataCurrent.value,
        };
    }
    var product_measure_type_id_data = null;

    if ($configPartial['valuesDefaultForm']['measureType']['success']) {
        var dataCurrent = $configPartial['valuesDefaultForm']['measureType']['data'];
        product_measure_type_id_data = {
            id: dataCurrent.id, text: dataCurrent.value,
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
        "product_by_sizes_data": null, //product_details_shipping_fee
        "product_details_shipping_fee_id": null,
        "height": 0,
        "length": 0,
        "width": 0,
        "weight": 0,
        "quantity_units": 0
    };
    return result;
}
,


onSendEventsParent: function (params) {

    this.$emit('on-send-events-by-component-to-parent', params);//BUSINESS-MANAGER-COMPONENT-JS-SEND-PARENT-DATA--ProductParentByPrices
}
,
onSendEventsByComponentToParent: function (params) {

    if (params.process == CONFIG_PRODUCT.process) {
        if (params.type == "_viewManager") {
            if (params.data.typeView == 2) {//ADMIN
                this._viewManager(2);
                this.managerSteps.one.data = null;
                this.managerSteps.process.parent_id = null;
                this.managerSteps.process.data = null;
                this.managerSteps.three.body.data = [];

                if (params.data.managerReload.type.length > 0) {
                    $(this.gridConfig.selectorCurrent).bootgrid("reload");

                }
            }
        } else if (params.type == "_viewManagerUpdate") {//
            if (params.data.typeView == 2) {
                this._viewManager(2);

                this.showManager = true;
                this.managerSteps.one.data = null;
                this.managerSteps.process.parent_id = null;
                this.managerSteps.process.data = null;
                this.managerSteps.three.body.data = [];

                if (params.data.managerReload.type.length > 0) {
                    $(this.gridConfig.selectorCurrent).bootgrid("reload");

                }

            }
        } else if (params.type == "setManagerProcessSave") {
            var rowData = params.data.getValuesSave;
            this.managerSteps.process.parent_id = rowData.id;
        }
    } else if (params.process == configProductByLogInventory.process) {
        var componentName = params.componentName;
        this[componentName].viewAllow = false;
        if (params.allowReload) {
            $(this.gridConfig.selectorCurrent).bootgrid("reload");

        }
    }
}
,
}
})
;
