var imagesManager = [
    "http://www.otavalo.travel/wp-content/uploads/2019/11/taxopamba-4-300x178.jpg",
    "http://www.otavalo.travel/wp-content/uploads/2019/11/taxopamba-4-300x178.jpg",
    "http://www.otavalo.travel/wp-content/uploads/2019/11/taxopamba-4-300x178.jpg",
    "http://www.otavalo.travel/wp-content/uploads/2019/11/taxopamba-4-300x178.jpg",

];
Vue.component('search-manager-component', {
    template: '#search-manager-template',
    created: function () {

    },
    mounted: function () {
        this.initCurrentComponent();
        $vD = this.$v;
        currentValuesR = this;
        this._resizeContent();
    },

    computed: {
        state: function () {
            return true;
        }
        /* state() {
             return this.name.length >= 4 ? true : false
         },
         invalidFeedback() {
             if (this.name.length > 4) {
                 return ''
             } else if (this.name.length > 0) {
                 return 'Enter at least 4 characters'
             } else {
                 return 'Please enter something'
             }
         },
         validFeedback() {
             return this.state === true ? 'Thank you' : ''
         }*/
    },
    data: function () {

        dataManager = {
            message: 'hello!',
            dataCategories: [],
            configParams: {},
            buttonConfig: {
                title: "",
                classConfig: ""
            },
            configDataSearchManager: {
                title: "Chakiñanes y Atractivos Turísticos.",
                button: {
                    open: "fa fa-angle-right",
                    close: "fa fa-angle-right",
                    state: false
                },
                buttonConfigSearch: {

                    close: "",
                    state: false
                },
                contentConfigSearch: {
                    open: "component-demo__config-panel--open",
                    close: "",
                    state: false
                },
                configPanel: {
                    "title": "Filtros",
                    "category": {
                        "title": "Categorias"
                    },
                    "subcategory": {
                        "title": "Subcategorias"
                    }
                },

            },
            allSelectedManager: {},
            selectedManager: [],
            rowCountsConfig: 10,
            gridSelectorCurrent: "#business-grid",
            modelSearch: "",
            initManager: false,
            inputSearchConfig: {
                "placeholder": "Busqueda de rutas y destinos."
            },
            configManager: {
                "loadingText": "Cargando...."
            }
        };
        return dataManager;
    },

    methods: {
        ...$methodsFormValid,

        /*----EVENTS TO PARENT---*/
        _updateChildrenByParent: function (params) {

            if (params.nameComponent == "App") {

                if (params.nameEvent == "_closeMenu") {
                    if (this.configDataSearchManager.button.state) {
                        this.configDataSearchManager.button.state = false;
                        this.setStructureConfig();
                    }
                }
            }
        },
        getCategories: function () {

            var result = [
                {
                    id: 1,
                    name: "Rutas ",
                    subcategories: [
                        {
                            value: 0, text: "Turísticas",
                        },
                        {
                            value: 1, text: "Transito",
                        },
                        {
                            value: 2, text: "Históricas",
                        },
                        {
                            value: 3, text: "Temáticas",
                        },
                        {
                            value: 4, text: "Chakiñanes",
                        },
                    ]
                },
                {
                    id: 0,
                    name: "Atractivos",
                    subcategories: [
                        {
                            value: 5, text: "Sitios Naturales",
                        },
                        {
                            value: 6, text: "Manifestaciones Culturales",
                        },

                    ]
                },

            ];


            return result;
        },
        initDataManager: function () {
            var _this = this;
            var allSelectedManagerData = [];
            var selectedManagerData = [];
            var dataCategories = [];
            var modelGet = [];
            var currentCategories = this.getCategories();
            $.each(currentCategories, function (key, category) {
                var allSelectedManager = new Object;
                var selectedManager = new Object;
                var keyCurrentCategory = category.id;
                allSelectedManager[keyCurrentCategory] = {model: false};
                allSelectedManagerData.push(allSelectedManager);
                selectedManagerData.push(selectedManager);
                var haystackSubcategories = category.subcategories;
                var subcategories = category.subcategories;

                var setPushSubcategoriesModel = new Object;
                $.each(haystackSubcategories, function (keySubcategory, subcategory) {
                    var obj1 = new Object;
                    obj1[subcategory.value] = {model: false}
                    setPushSubcategoriesModel[keySubcategory] = obj1;

                });
                var setPushcategoriesModel = new Object;
                setPushcategoriesModel[category.id] = setPushSubcategoriesModel;
                modelGet[key] = setPushcategoriesModel;
                dataCategories.push({
                    id: category.id,
                    name: category.name,
                    subcategories: subcategories,
                    subcategoriesAfter: category.subcategories,
                    model: false
                });

            });
            this.allSelectedManager = allSelectedManagerData;
            this.selectedManager = modelGet;
            this.dataCategories = dataCategories;
        },
        getCategoriesFiltersBusiness: function () {
            $.each($dataCategories, function (key, category) {
                var allSelectedManager = new Object;
                var selectedManager = new Object;
                var keyCurrentCategory = category.id;
                allSelectedManager[keyCurrentCategory] = {model: false};
                allSelectedManagerData.push(allSelectedManager);
                selectedManagerData.push(selectedManager);
                var haystackSubcategories = category.subcategories;
                var subcategories = _this.getSubcategories(haystackSubcategories);

                var setPushSubcategoriesModel = new Object;
                $.each(haystackSubcategories, function (keySubcategory, subcategory) {
                    var obj1 = new Object;
                    obj1[subcategory.id] = {model: false}
                    setPushSubcategoriesModel[keySubcategory] = obj1;

                });
                var setPushcategoriesModel = new Object;
                setPushcategoriesModel[category.id] = setPushSubcategoriesModel;
                modelGet[key] = setPushcategoriesModel;
                dataCategories.push({
                    id: category.id,
                    name: category.name,
                    subcategories: subcategories,
                    subcategoriesAfter: category.subcategories,
                    model: false
                });

            });
            this.allSelectedManager = allSelectedManagerData;
        },
        getSubcategories: function (haystack) {
            var result = [];
            $.each(haystack, function (key, subcategory) {
                result.push({
                    text: subcategory.name,
                    value: subcategory.id
                });

            });
            return result;
        },
        _selectAllCategory: function (index, categoryId) {
            this.allSelectedManager[index][categoryId].model = this.allSelectedManager[index][categoryId].model ? false : true;
            var params = {
                indexCategory: index,
                categoryId: categoryId,
                valueModel: this.allSelectedManager[index][categoryId].model
            };
            this.setValueModelSubcategories(params);
            this.reloadFilters();
        },
        setValueModelSubcategories: function (params) {
            var indexCategory = params["indexCategory"];
            var categoryId = params["categoryId"];
            var valueModel = params["valueModel"];
            var haystack = this.selectedManager[indexCategory][categoryId];
            $.each(haystack, function (keySubcategory, subcategory) {
                $.each(subcategory, function (key, modelValue) {
                    haystack[keySubcategory][key]["model"] = valueModel;
                });

            });
            this.selectedManager[indexCategory][categoryId] = haystack;
        },
        _selectSubcategory: function (index, categoryId, indexSubcategory, subcategoryId, value) {

            var haystack = this.selectedManager[index][categoryId];
            var selectAll = true;
            $.each(haystack, function (keySubcategory, subcategory) {
                if (keySubcategory == indexSubcategory) {
                    $.each(subcategory, function (key, modelValue) {
                        if (subcategoryId == key) {
                            haystack[keySubcategory][key]["model"] = !value;
                            return;
                        }

                    });
                }
            });

            $.each(haystack, function (keySubcategory, subcategory) {
                $.each(subcategory, function (key, modelValue) {
                    if (!modelValue.model) {
                        selectAll = false;
                        return;
                    }
                });
            });
            this.allSelectedManager[index][categoryId].model = selectAll;
            this.reloadFilters();

        },

        getFiltersCurrent: function () {
            var allCategories = true;
            var keysSubcategories = "";
            var keysSubcategoriesObj = [];

            var keysCategories = "";
            var keysCategoriesObj = [];
            var filtersAllow = false;
            $.each(this.allSelectedManager, function (key, categoryData) {
                $.each(categoryData, function (categoryId, value) {
                    if (!value.model) {
                        allCategories = false;
                    } else {
                        keysCategoriesObj.push(categoryId);
                    }

                });
            });
            $.each(this.selectedManager, function (index, categoryData) {
                $.each(categoryData, function (categoryId, valueSubcategoryData) {
                    $.each(valueSubcategoryData, function (indexsub, valueSubcategory) {
                        $.each(valueSubcategory, function (subCategoryId, value) {
                            if (value.model) {
                                keysSubcategoriesObj.push(subCategoryId);
                            }

                        });
                    });
                });
            });

            keysSubcategories = keysSubcategoriesObj.join(",");
            keysCategories = keysCategoriesObj.join(",");
            var subcategories = {keys: keysSubcategories};
            var categories = {keys: keysCategories, all: allCategories};

            return {
                filtersAllow: filtersAllow,
                categories: categories,
                subcategories: subcategories,
            };
        },
        getClassButtonOpenManager: function () {

            return {
                "fa fa-angle-right": this.configDataSearchManager.button.state,
                "fa fa-angle-left": !this.configDataSearchManager.button.state
            };
        },
        getClassContentManagerState: function () {
            return {
                'active-search': this.configDataSearchManager.button.state,
                'no-active-search': !this.configDataSearchManager.button.state
            };
        },
        getClassContentState: function () {
            return {
                "component-demo--open": this.configDataSearchManager.buttonConfigSearch.state,
                "component-demo--close": !this.configDataSearchManager.buttonConfigSearch.state,
            };
        },
        getClassConfigPanelState: function () {
            return {
                "component-demo__config-panel--open": this.configDataSearchManager.buttonConfigSearch.state,
                "component-demo__config-panel--close": !this.configDataSearchManager.buttonConfigSearch.state,
            };
        },
        initCurrentComponent: function () {
            this.initGridManager();
        },
        _viewConfigSearch: function () {
            this.configDataSearchManager.buttonConfigSearch.state = this.configDataSearchManager.buttonConfigSearch.state ? false : true;

        },
        setStructureConfig: function () {
            var state = this.configDataSearchManager.button.state;
            var widthCurrent = $(window).width();
            var leftCurrent = "";
            if (state) {//open
                if (widthCurrent > 680) {
                    leftCurrent = "45%";

                } else {
                    leftCurrent = "70%";

                }
                $(".container-button-search").css({
                    left: leftCurrent
                });
            } else {
                leftCurrent = "0";

                if (widthCurrent > 680) {

                } else {

                }
                $(".container-button-search").css({
                    left: leftCurrent
                });
            }
        },
        getTypeShortCut: function (type_shortcut) {
            var result = "";
            if (type_shortcut == 0) {
                result = "Ruta Turistica";
            } else if (type_shortcut == 1) {
                result = "Ruta de Transito";


            } else if (type_shortcut == 2) {
                result = "Ruta Histórica";


            } else if (type_shortcut == 3) {
                result = "Ruta Temática";


            } else if (type_shortcut == 4) {
                result = "Chakiñanes";

            } else if (type_shortcut == 5) {
                result = "Atractivo- Sitios Naturales";


            } else if (type_shortcut == 5) {
                result = "Atractivo- Manifestaciones Culturales";


            }
            return result;
        },
        _viewMenu: function () {
            this.configDataSearchManager.button.state = this.configDataSearchManager.button.state ? false : true;
            this.setStructureConfig();
        }, initGridManager: function () {
            var _this = this;
            var gridName = this.gridSelectorCurrent;
            var urlCurrent = $("#action_routes_admin_wulpymes").val();

            gridId = $(gridName);
            gridId.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                ajax: true,
                post: function () {
                    return {
                        grid_id: gridName,
                        filters: _this.getFiltersCurrent()
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
                    'business_row_html': function (column, row) {

                        var urlImg = row.src == 'nothing' ? randomItem(imagesManager) :  $resourceRoot+row.src;
                        var subtitle = _this.getTypeShortCut(row["type_shortcut"]) + ".";
                        var title = row.name + ".";
                        var imgCurrentHtml = "<img class='content-img__img' src='" + urlImg + "'>";
                        var descriptionHtml = [
                            '   <div class="col col-md-12 col-xs-12 col-sm-12">',
                            '     <div class="content-description" id="content-description-' + row.id + '"></div>',
                            '   </div>',
                            '   <div class="col col-md-12 col-xs-12 col-sm-12">',
                            '     <div class="content-img" >' + imgCurrentHtml + '</div>',
                            '   </div>',
                        ].join("");
                        var html = [
                            '<div class="row" data-row-id="' + row.id + '">',
                            '   <div class="col col-md-12 col-xs-12 col-sm-12">',
                            '     <h1 class="content-title" >' + subtitle + '</h1>',
                            '     <h2 class="content-subtitle" >' + title + '</h2>',

                            '   </div>',
                            descriptionHtml,
                            '</div>',

                        ];
                        var result = html.join("");
                        return result;
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                _this._viewManager();
                gridId.find(".tr-manager-information").on("mouseover", function (e) {
                    self = $(this);
                    _this._managerViewMarker({
                        self: self,
                        gridId: gridId,
                        render: false
                    });
                }).end().find(".tr-manager-information").on("click", function (e) {
                    self = $(this);
                    _this._managerViewMarker({
                        self: self,
                        gridId: gridId,
                        render: true
                    });
                }).end();
            });
        },
        _managerViewMarker: function (objectCurrent) {
            var selfCurrent = objectCurrent.self;
            var gridId = objectCurrent.gridId;
            var instance_data_rows = getDataInstanciaBootgrid(gridId);
            var data_row_id = selfCurrent.attr("data-row-id");
            var $row_data_info = searchElementJson(instance_data_rows.currentRows, 'id', data_row_id);//asi s obtiene los valores del registro en funcion d su id
            var rowCurrent = $row_data_info[0];
            if (!objectCurrent.render) {


                var options_map = rowCurrent["options_map"];
                options_map = jQuery.parseJSON(options_map);


                var latCurrent = options_map["center"].lat;
                var lngCurrent = options_map["center"].lng;

                this._centerMarkerMap(
                    {
                        position: {
                            lat: latCurrent,
                            lng: lngCurrent
                        },
                        row: rowCurrent
                    }
                );
            } else {
                var urlCurrent = urlBusiness + data_row_id;
                window.open(urlCurrent);
            }
        },
        _viewManager: function () {

            $(this.gridSelectorCurrent + "-header").hide();
            this.initManager = true;
            $(this.gridSelectorCurrent + " tbody tr").addClass("tr-manager-information");
            var dataRowsCurrent = $(this.gridSelectorCurrent).bootgrid("getCurrentRows");
            this._sendValuesParent({
                nameEvent: "_viewManager",
                nameComponent: "SearchManager",
                response: {
                    data: dataRowsCurrent
                }
            });
            $.each(dataRowsCurrent, function (key, value) {
                var selectorCurrent = ("#content-description-" + value.id);
                var htmlData = value.description;
                htmlData = replaceAll(htmlData, "&lt;", "<");
                htmlData = replaceAll(htmlData, '&gt;', '>');
                $(selectorCurrent).html(htmlData);

            });

        },
        _centerMarkerMap: function (params) {
            var dataCurrent = params;
            this._sendValuesParent({
                nameEvent: "_centerMarkerMap",
                nameComponent: "SearchManager",
                response: {
                    data: dataCurrent
                }
            });
        },
        _sendValuesParent: function (params) {
            this.$emit('_data-components-children', params);
        },
        reloadFilters: function () {
            this._sendValuesParent({
                nameEvent: "_resetValues",
                nameComponent: "SearchManager",
                response: {
                    data: []
                }
            });
            $(this.gridSelectorCurrent).bootgrid("reload");

        },
        //MANAGER PROCESS
        _managerRowGrid: function (params) {
            this._viewManager(1);
            var rowCurrent = params.row;
            var rowId = params.id;


        },
        _searchBusiness: function () {

            this._sendValuesParent({
                nameEvent: "_resetValues",
                nameComponent: "SearchManager",
                response: {
                    data: []
                }
            });

            var modelSearch = this.modelSearch;
            $(this.gridSelectorCurrent).bootgrid("search", modelSearch);

        }, _resizeContent: function () {
            /*size content-*/
            var heightCurrent = $(".preview-demo").height();
            $(".component-demo__stage-content").css(
                {
                    height: (heightCurrent - $(".component-demo__app-bar").height() - 25) + "px"
                }
            );
        }

    },
    props: {
        parentData: {
            type: String,
            default: function () {
                return '';
            }
        },
        title: {
            type: String
        },
        messageParent: {
            type: String
        },
        params: {
            type: Object,
        },
        titleEvent: {
            type: String
        }

    },
    beforeMount: function () {
        this.configParams = this.params;

        this.configDataSearchManager.button.state = this.params.configDataSearchManager.button.state;
        this.initDataManager();
    },
    filters: {
        pretty: function (value) {
            return JSON.stringify(JSON.parse(value), null, 2);
        }
    }
});

