//BUSINESS-MANAGER-COMPONENT-JS--ProductManager
var componentThisProduct;
var componentThisProductManager;

var componentThisPrices;
var componentThisPackageParams;

var $staticsVariables = {
    TYPE_REGISTER_FORM: 0, TYPE_REGISTER_STEPS: 1,

};
var $paramsComponent = null;
var componentProductParent = null;
Vue.component($configProcess['entity-process'] + '-component', {
    template: '#' + $configProcess['entity-process'] + '-template',
    directives: {
        initFormWizard: {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value
                paramsInput.nameMethod({
                    objSelector: el
                });
            }
        }

    }, props: {
        params: {
            type: Object,
        }
    }, created: function () {
        var $scope = this;
        this.$root.$on("_updateParentByChildren", function (emitValue) {
            $scope._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;
        this.business_id = $businessManager.id;//this.configParams.business_id;
    },
    mounted: function () {

        this.initCurrentComponent();
        removeClassNotView();
        componentThisProduct = this;
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
            ...$staticsVariables,
            business_id: null, /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": [{
                    "title": "Actualizar",
                    "data-placement": "top",
                    "i-class": " fas fa-pencil-alt",
                    "managerType": "updateEntity"
                },
                {
                    "title": "Administracion Productos",
                    "data-placement": "top",
                    "i-class": " fas fa-external-link-alt",
                    "managerType": "adminEntityProducts"
                }
                ]
            }, managerMenuConfig: {
                view: false, menuCurrent: [], rowId: null
            }, configParams: {}, labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},

//form config
            tabCurrentSelector: '.content', processName: "Registro Acción.",

            gridConfig: {
                selectorCurrent: "#" + $configProcess['entity-process'] + "-grid",
                url: $("#action-" + $configProcess['entity-process'] + "-getAdmin").val()
            }, submitStatus: "no", showManager: false,
            managerSteps: this.getDataManagerSteps(),
            managerType: null,
            managerReload: {
                type: [],
                allow: false
            },
        processInitWizard:'none'
        };
        return dataManager;
    }, methods: {
        ...$methodsFormValid,
        getDataManagerSteps: function () {
            var restult = {
                config: {
                    showManager: false, type: $staticsVariables.TYPE_REGISTER_STEPS
                },
                process: {
                    isCreate: true,
                    parent_id: null,
                    data: null,
                },
                one: {
                    header: {
                        title: 'Producto Principal', number: 1
                    }, messages: {
                        one: {
                            title: 'Informacion General',
                            value: 'Complete toda la informacion del producto principal a continuacion.',
                        },

                    }, footer: {
                        buttonsManager: {
                            one: {
                                title: 'Guardar y Continuar', icon: '->', allow: false, class: 'btn--manager-process',

                            }, two: {
                                title: 'Regresar', icon: '', allow: false, class: 'btn--manager-return',
                            },
                        }
                    }, data: {}


                }, two: {
                    header: {
                        title: 'Precios y Empaques', number: 2
                    }, messages: {
                        one: {
                            title: 'Precios disponibles por unidad en listado y asignacion de paquetes', value: '',
                        }, two: {
                            title: '',
                            value: '<p>Los precios por unidad aplican para la venta directa al publico . Habilitan los pagos con tarjeta de credito, transferencia bancaria o retiro en nuestro local.<br> Los precios por mayor y o docena se ofrecen para clientes que requieren 3 unidades o mas de un producto en<br> especifico. Habilitan los pagos con transferencia bancaria o efectivo al momento de retirar la mercancia en la <br> tienda. Para acceder a estos precios , se debe solicitar una cotizacino y cumplir con los requisitos <br> minimos  de compra </p',
                        },
                    }, body: {
                        tabs: {
                            one: {
                                title: 'Listado', icon: '', allow: false, table: {
                                    colOne: {
                                        title: 'Listado de precios Uni',

                                    }, colTwo: {
                                        title: 'Asignacion',

                                    }, data: []
                                }
                            }, two: {
                                title: 'Listado por paquetes', icon: '', allow: false, table: {
                                    colOne: {
                                        title: 'Nombre del paquete',

                                    }, colTwo: {
                                        title: 'Parametro',

                                    }, colThree: {
                                        title: 'Limitacion',

                                    }, colFour: {
                                        title: 'Precio',

                                    }, data: []
                                }
                            },

                        },
                    }, footer: {
                        buttonsManager: {
                            oneListPrice: {
                                title: 'Guardar y Continuar', icon: '->', allow: false, class: 'btn--manager-process',

                            }, twoListPrice: {
                                title: 'Regresar', icon: '', allow: false, class: 'btn--manager-return',
                            }, threeListPrice: {
                                title: 'Agregar mas precios', icon: '', allow: false, class: 'btn--manager-add',
                            }, oneListPacking: {
                                title: 'Guardar y Continuar', icon: '->', allow: false, class: 'btn--manager-process',

                            }, twoListPacking: {
                                title: 'Regresar', icon: '', allow: false, class: 'btn--manager-return',
                            }, threeListPacking: {
                                title: 'Agregar mas Parametros', icon: '', allow: false, class: 'btn--manager-add',
                            },
                        },
                    },
                }, three: {

                    header: {
                        title: 'Productos', number: 3
                    }, messages: {
                        one: {
                            title: 'Especificaciones', value: '',
                        }, two: {
                            title: 'Listado de precios', value: '',
                        }, three: {
                            title: 'Listado de paquetes', value: '',
                        },
                    }, body: {
                        table: {
                            colOne: {
                                title: 'Imagen',

                            }, colTwo: {
                                title: 'Cod/Nombre del producto',

                            }, colThree: {
                                title: 'Empaque',

                            }, colFour: {
                                title: 'Stock',

                            }, colFive: {
                                title: 'Estado',

                            }
                        }
                    }, footer: {
                        buttonsManager: {

                            two: {
                                title: 'Regresar', icon: '', allow: false, class: 'btn--manager-return',
                            }, one: {
                                title: 'Añadir Productos', icon: '', allow: false, class: 'btn--manager-add-children',
                            },
                        },
                    },
                },

            };
            return restult;
        },
        resetAllProcessData: function () {
            this.managerSteps = this.getDataManagerSteps();
            this.managerReload = {
                type: [],
                allow: false
            };
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
        }, /*---EVENTS CHILDREN to Parent COMPONENTS send values to parent----*/
        makeToast: function (params) {
            var $msjCurrent = params.msj;
            var $titleCurrent = params.title;
            var $typeCurrent = params.type;

            this.$notify({
                type: $typeCurrent, title: $titleCurrent, duration: 0, content: $msjCurrent,

            }).then(() => {
// resolve after dismissed

            });
        }, //MANAGER PROCESS
        /*---------GRID--------*/
        ...$methodsBootgrid,
        getMenuConfig: function (params) {
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
            return result;
        },
        _managerRowGrid: function (params) {
            var rowCurrent = params.row;
            var rowId = params.id;
            var $scope = this;
            if (params.managerType == "updateEntity") {
                var ProductParent = {
                    'ProductParent': rowCurrent,
                    type: 'onClickUpdateRegister',
                };
                this.sendDataToComponents(
                    {
                        type: 'onClickUpdateRegister',
                        data: {
                            'information': ProductParent
                        },

                        'process': 'product-parent'
                    }
                );
                this.setInitDataProcessChildren(ProductParent);
                this._viewManager(3, rowId);
            }else if(params.managerType == "adminEntityProducts"){
                var ProductParent = {
                    'ProductParent': rowCurrent,
                    type: 'onClickUpdateRegister',
                    viewProcess:'products',
                };
                this.sendDataToComponents(
                    {
                        type: 'onClickUpdateRegister',
                        data: {
                            'information': ProductParent
                        },

                        'process': 'product-parent'
                    }
                );
                this.setInitDataProcessChildren(ProductParent);
                this._viewManager(3, rowId);
            }


        },
        initGridManager: function ($scope) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {
                business_id: this.business_id
            };

            var structure = {
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
                },
            };
            var formatters = {
                'check-list-manager': function (column, row) {
                    var key_id = row.id;
                    return '<input class="check-list-manager"  id="checkbox-' + key_id + '" name="select" type="checkbox" class="select-box" value="' + key_id + '">';
                },
                'code_name': function (column, row) {
                    var result = [
                        "<div class='content-description'>",

                        "  <span class='content-description__value content-description__value--bold'>" + row.code + " /" + row.name + "</span>",
                        " </div>"

                    ];
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
                'product_parent_by_prices_data': function (column, row) {

                    var rowsData = row["product_parent_by_prices_data"];
                    var result = ["<div class='content-description'>"];
                    $.each(rowsData, function (key, value) {
                        result.push("  <span class='content-description__value'>* " + value.price + "</span> <br>");
                    });

                    result.push(" </div>");

                    return result.join("");
                },
                'product_parent_by_package_params_data': function (column, row) {

                    var rowsData = row["product_parent_by_package_params_data"];
                    var result = ["<div class='product_parent_by_package_params_data'>"];
                    $.each(rowsData, function (key, value) {
                        result.push("  <span class='content-description__value'>* " + value.name + "</span> <br>");
                    });

                    result.push(" </div>");

                    return result.join("");
                },
                'description': function (column, row) {
                    var classStatus = "badge-success";

                    var classQuantityUnits = "badge-success";
                    var quantity_units = parseFloat(row.quantity_units != null ? row.quantity_units : 0);
                    if (quantity_units == 0) {
                        classQuantityUnits = "badge-danger";
                    } else if (quantity_units > 0 && quantity_units < 20) {
                        classQuantityUnits = "badge-warning";

                    } else if (quantity_units > 20) {
                        classQuantityUnits = "badge-success";

                    }
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

                    shippingFeeAll = shippingFeeAll.join(" ");
                    var variantAll = [];

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
                    var code_provider = row.code_provider != null ? ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code_provider.label + ":</span><span class='content-description__value'>" + row.code_provider + "</span>",
                        "</div>"] : [];
                    code_provider = code_provider.join('');

                    var code_product = row.code_product != null ? [
                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code_product.label + ":</span><span class='content-description__value'>" + row.code_product + "</span>",
                        "</div>"
                    ] : [];
                    code_product = code_product.join('');
                    var unitsCurrent = structure.hasOwnProperty('quantity_units') ? ["   <div class='content-description__information--quantity'>",
                        "        <span class='content-description__title'>" + structure.quantity_units.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classQuantityUnits + " '>" + quantity_units + "</span></span>",
                        "   </div>"] : [];
                    unitsCurrent = unitsCurrent.join('');
                    var result = [
                        "<div class='content-description'>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.state.label + ":</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + row.state + "</span></span>",
                        "</div>",


                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.code.label + ":</span><span class='content-description__value'>" + row.code + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span class='content-description__title'>" + structure.name.label + ":</span><span class='content-description__value'>" + row.name + "</span>",
                        "</div>",


                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_category_id_data.label + ":</span><span class='content-description__value'>" + row.product_category + "</span>",
                        "</div>",

                        "<div class='content-description__information'>",
                        "   <span relation class='content-description__title'>" + structure.product_subcategory_id_data.label + ":</span><span class='content-description__value'>" + row.product_subcategory + "</span>",
                        "</div>",
                        description,

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
                $scope._resetManagerGrid();
                $scope._gridManager(gridInit);
            });
        }, /*Manager FORMS-AND VIEWS*/
        _viewManager: function (typeView, rowId) {

            if (typeView == 1) {//create
                this.resetAllProcessData();
                this.showManager = true;
                this.managerSteps.config.show = true;
                this.managerMenuConfig.view = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent, hide: true,
                });
                this.managerType = 1;


            } else if (typeView == 2) {//admin


                this.showManager = false;
                this.managerSteps.config.show = false;
                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent, hide: false,
                });
                if (this.managerType == 1) {
                    this.managerMenuConfig.view = false;
                    this.managerType = null;

                } else if (this.managerType == 3) {
                    this.managerMenuConfig.view = true;
                    this.managerType = null;

                } else {
                    this.managerMenuConfig.view = true;
                }
                if (this.managerReload.allow) {
                    $(this.gridConfig.selectorCurrent).bootgrid("reload");

                }
                this.resetAllProcessData();
            } else if (typeView == 3) {//update
                this.showManager = true;
                this.managerSteps.config.show = true;

                showHideGridHeaderFooter({
                    selectorGrid: this.gridConfig.selectorCurrent, hide: true,
                });
                this.managerMenuConfig.view = false;
                this.managerType = 3;
            }
        }, //FORM CONFIG
        initFormWizard: function (params) {
            var el = params.objSelector;
            var modelId = params.modelId;
            var dataCurrent = [];
            var $scope = this;
            var businessId = null;
            $(el).bootstrapWizard({
                tabClass: "nav nav-pills nav-justified",
                onInit: function () {

                },
                onNext: function (tab, navigation, index) {
                    // Realizar validaciones antes de avanzar al siguiente paso
                    if (index === 1) {

                    }
                },
                onPrevious: function (tab, navigation, index) {
                    // Realizar acciones antes de retroceder al paso anterior
                    console.log('Retrocediendo al paso ' + (index));
                    // Puedes ejecutar otras acciones aquí antes de retroceder
                },
                onTabClick: function (tab, navigation, index) {


                },
                onTabShow: function (tab, navigation, index) {
                    console.log($scope.managerSteps.process);
                    var progress = ((index + 1) / navigation.find('li').length) * 100;
                    $('#progressBar').css('width', progress + '%').attr('aria-valuenow', progress);
                    var indexGestion = index + 1;
                    navigation.find('li')
                        .each(function (indexLi, element) {
                            if (indexLi == indexGestion - 1) {

                            } else {
                                $(element).removeClass('active');
                                $(element).find('a').removeClass('active');
                            }
                        });
                    if (index == 0) {
                        navigation.find('li')
                            .each(function (indexLi, element) {
                                if (indexLi == 0) {
                                    $(element).removeClass('active');
                                    $(element).find('a').addClass('active');
                                }
                            });
                    }


                    if (indexGestion == 3) {

                        if ($scope.managerSteps.process.parent_id == null) {

                        } else {
                            var allowViewTabsUp = ($scope.managerSteps.two.body.tabs.one.allow && $scope.managerSteps.two.body.tabs.two.allow) ? true : false;
                            if (allowViewTabsUp) {

                                $('.nav-pills').addClass('not-view');
                            }

                        }
                    } else {
                        if ($scope.managerSteps.process.parent_id == null) {

                        } else {
                            $('.nav-pills').removeClass('not-view');
                        }
                    }


                }

            });

            if( $scope.processInitWizard=='products'){
                var allowProducts=$scope.managerSteps.two.body.tabs.one.allow && $scope.managerSteps.two.body.tabs.two.allow;
                if(allowProducts){
                    $('#product_parent_by_product-a').click();
                }
            }
            /*   var quill = new Quill("#snow-editor", {
                   theme: "snow",
                   modules: {toolbar: [[{font: []}, {size: []}], ["bold", "italic", "underline", "strike"], [{color: []}, {background: []}], [{script: "super"}, {script: "sub"}], [{header: [!1, 1, 2, 3, 4, 5, 6]}, "blockquote", "code-block"], [{list: "ordered"}, {list: "bullet"}, {indent: "-1"}, {indent: "+1"}], ["direction", {align: []}], ["link", "image", "video"], ["clean"]]}
               });*/

        },
        setInitDataProcessChildren: function (params) {
            console.log(params);

            this.managerSteps.process.parent_id = params['ProductParent'].id;
            this.managerSteps.process.data = params['ProductParent'];
            this.managerSteps.one.footer.buttonsManager.one.allow = true;
            this.managerSteps.one.data = params['ProductParent'];
            if (params.type == 'onClickUpdateRegister') {
                this.managerSteps.two.body.tabs.one.table.data = [];
                if (params['ProductParent']['product_parent_by_prices_data'].length > 0) {
                    this.managerSteps.two.body.tabs.one.table.data = params['ProductParent']['product_parent_by_prices_data'];
                    this.managerSteps.two.body.tabs.one.allow = true;
                }
                this.managerSteps.two.body.tabs.two.table.data = [];
                if (params['ProductParent']['product_parent_by_package_params_data'].length > 0) {
                    this.managerSteps.two.body.tabs.two.table.data = params['ProductParent']['product_parent_by_package_params_data'];
                    this.managerSteps.two.body.tabs.two.allow = true;

                }
                var allowProducts=this.managerSteps.two.body.tabs.one.allow && this.managerSteps.two.body.tabs.two.allow;

                    if(params.viewProcess=='products'){
                        this.processInitWizard=params.viewProcess;

                    }



            } else if (params.type == 'onSaveModelComponent') {
                //children
                $('#product_parent-a').click();
            } else if (params.type == 'onSaveUpdateModelComponent') {

                $('#product_parent-a').click();
            }

        },
        onSaveModelComponent: function (params) {
            var vCurrent = this;
            if (params.type == 'product_parent') {
                var urlCurrent = $('#action-product-manager-saveData').val();
                var dataSend = this.managerSteps.one.data;
                var blockElement = '#general-info';
                var loading_message = 'Cargando...';
                var error_message = 'Error al cargar.!';
                var success_message = 'Datos cargados con exito!';
                var isCreate = this.managerSteps.one.data.id == -1;
                var typeProcess = isCreate ? 'onSaveModelComponent' : 'onSaveUpdateModelComponent';
                ajaxRequest(urlCurrent, {
                    type: 'POST',
                    data: dataSend,
                    blockElement: blockElement,//opcional: es para bloquear el elemento
                    loading_message: loading_message,
                    error_message: error_message,
                    success_message: success_message,
                    success_callback: function (response) {
                        var dataCurrent = response;//
                        if (dataCurrent.success) {
                            vCurrent.managerSteps.process = {
                                isCreate: false,
                                parent_id: dataCurrent.data.ProductParent.id,
                                data: dataCurrent.data.ProductParent,
                            };

                            vCurrent.setInitDataProcessChildren({
                                'ProductParent': dataCurrent.data.ProductParent,
                                type: typeProcess,
                            });
                            vCurrent.sendDataToComponents(
                                {
                                    type: typeProcess,
                                    data: {
                                        'isCreate': isCreate,
                                        'information': dataCurrent.data
                                    },

                                    'process': 'product-parent'
                                }
                            );
                            vCurrent.sendDataToComponents(
                                {
                                    type: typeProcess,
                                    data: {
                                        'isCreate': false,
                                        'information': dataCurrent.data
                                    },

                                    'process': 'product_parent_by_prices'
                                }
                            );
                            vCurrent.sendDataToComponents(
                                {
                                    type: 'onSaveModelComponent',
                                    data: {
                                        'isCreate': false,
                                        'information': dataCurrent.data
                                    },

                                    'process': 'product_parent_by_package_params'
                                }
                            );


                        }


                    }
                });
            }
        },
        onReturnModelComponent: function (params) {
            if (params.type == 'product_parent' || params.type == "product_by_manager_process" || params.type == "product_parent_by_product") {
                this._viewManager(2);

            }
        },
        sendDataToComponents: function (params) {


            if (params.process == 'product_parent_by_prices') {

                this.$emit('message-to-product_parent_by_prices', params);
            } else if (params.process == 'product_parent_by_package_params') {

                this.$emit('message-to-product_parent_by_package_params', params);
            } else if (params.process == 'product_parent' ||params.process == 'product-parent') {

                this.$emit('message-to-product_parent', params);
            }

            if ((params.type == 'onClickUpdateRegister') === false) {

                this.managerReload.type.push(params.type);
                this.managerReload.allow = true;
            }
        },
        handleMessageFromParent: function (params) {
            console.log('handleMessageFromParent', params);
        },
        onSendEventsByComponentToParent: function (params) {

            if (params.process == 'product_parent') {
                if (params.type == "validateForm") {
                    var validate = params.data.validate;
                    this.managerSteps.one.footer.buttonsManager.one.allow = validate.success;
                    if (validate.success) {
                        this.managerSteps.one.data = params.data.getValuesSave;
                    }
                }
            } else if (params.process == 'product_parent_by_prices') {

                this.managerSteps.two.body.tabs.one.table.data = [];
                var dataManager = [];
                var allowProcess = false;

                if (params.type == "onAddData") {
                    allowProcess = params.data.rows.length > 0;

                    if (allowProcess) {
                        dataManager = params.data.rows;
                    }
                } else if (params.type == "onDeleteData") {
                    allowProcess = params.data.rows.length > 0;
                    if (allowProcess) {
                        dataManager = params.data.rows;
                    }
                } else if (params.type == "onUpdateData") {
                    allowProcess = params.data.rows.length > 0;
                    if (allowProcess) {
                        dataManager = params.data.rows;
                    }
                }
                this.managerSteps.two.body.tabs.one.allow = allowProcess;
                this.managerSteps.two.body.tabs.one.table.data = dataManager;
                this.managerReload.type.push(params.type);
                this.managerReload.allow = true;

            } else if (params.process == 'product_parent_by_package_params') {

                this.managerSteps.two.body.tabs.two.table.data = [];
                var allowProcess = false;
                var dataManager = [];
                if (params.type == "onAddData") {
                    allowProcess = params.data.rows.length > 0;
                    if (allowProcess) {
                        dataManager = params.data.rows;
                    }
                } else if (params.type == "onDeleteData") {
                    allowProcess = params.data.rows.length > 0;
                    if (allowProcess) {
                        dataManager = params.data.rows;
                    }
                } else if (params.type == "onUpdateData") {
                    allowProcess = params.data.rows.length > 0;
                    if (allowProcess) {
                        dataManager = params.data.rows;
                    }
                }
                this.managerSteps.two.body.tabs.two.allow = allowProcess;
                this.managerSteps.two.body.tabs.two.table.data = dataManager;
                this.managerReload.type.push(params.type);
                this.managerReload.allow = true;
            }
        },

    }
});


