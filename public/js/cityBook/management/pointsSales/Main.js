var componentThisEventsTrailsProject;
Vue.component('points-sales-component', {
    components: {},
    template: '#points-sales-template',
    directives: {
        'init-grid-filters': {
            inserted: function (el, binding, vnode, vm, arg) {
                var paramsInput = binding.value;
                paramsInput.initMethod({
                    objSelector: el
                });


            },
        },
    },
    props: {
        params: {
            type: Object,
        }
    },
    created: function () {
        var vmCurrent = this;
        this.$root.$on("_pointsSales", function (emitValue) {
            vmCurrent._managerTypes(emitValue);
        });


    },
    beforeMount: function () {
        this.configParams = this.params;

    },
    mounted: function () {
        componentThisEventsTrailsProject = this;
        this.initCurrentComponent();

    },
    computed: {},
    validations: function () {
        var attributes = {
            "id": {},
            "value": {required, maxLength: Validators.maxLength(250)},
            "description": {},
            "status": {required},
            "date_init_project": {required},
            "date_end_project": {required},
            "events_trails_types_id_data": {required},
            "source": {required},
            "change": {},

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
                        "title": "Participar",
                        "data-placement": "top",
                        "i-class": "fa   fa-calendar",
                        "managerType": "managementTakePart",
                        "isUrl": false,

                    },
                    {
                        "title": "Administracion de Pagos",
                        "data-placement": "top",
                        "i-class": "fa fa-usd",
                        "managerType": "managementGetPayments",
                        "isUrl": false,

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
            processName: "Registro Acción.",

//Grid config
            gridConfig: {
                selectorCurrent: "#points-sales-grid",
                url: $("#action-management-admin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            search: {
                needle: ''
            },
            loadPage: false,
            configModalManagementFormEvent: {
                viewAllow: false
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

            }
            if (emitValues.type == "resetComponent") {
                this.configModalManagementFormEvent.viewAllow = false;
                this.configModalManagementFormEventDetails.viewAllow = false;


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
                    isUrl: value["isUrl"],
                    url: value["url"],
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
        _gridManager: _gridManager,
        _managerRowGrid: function (params) {
            var $scope = this;
            var rowCurrent = params.row;
            var rowId = params.id;
            if (params.managerType == "managementTakePart") {
                console.log(rowCurrent);
                this.configModalManagementFormEvent.data = rowCurrent;
                this.configModalManagementFormEvent.viewAllow = true;
            } else if (params.managerType == "managementGetPayments") {


                var dataSend = {
                    filters: {
                        events_trails_registration_points_id:rowCurrent.events_trails_registration_points_id
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
            }

        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            var paramsFilters = {};
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
                        var data = row;
                        var discountImageHtml = [];

                        var $languageCurrent = null;

                        var nameProduct = $languageCurrent == null ? data['name'] : (data.hasOwnProperty('name_lang') && data['name_lang'] ? data['name_lang'] : data['name']);
                        discountImageHtml = discountImageHtml.join('');
                        var descriptionProduct = $languageCurrent == null ? data['description'] : (data.hasOwnProperty('description_lang') && data['description_lang'] ? data['description_lang'] : data['description']);

                        var currentUrl = $rootUrl + '/eventDetails/' + data.id;

                        var result = [
                            "<div class='content-management-rows'>",
                            "<div class='content-description__information'>",
                            "   <img class='content-description__image' src='" + $publicAsset + row.source + "'> ",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Empresa :</span><span class='content-description__value'>" + (data.business) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Evento :</span><span class='content-description__value'>" + (nameProduct) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Fecha maximo inscripcion  :</span><span class='content-description__value'>" + (data['date_end_project']) + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Descripcion  :</span><span class='content-description__value'>" + (descriptionProduct) + "</span>",
                            "</div>",
                            "</div>",


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
        _viewManager: _viewManager,
//FORM CONFIG
        getViewErrorForm: getViewErrorForm,
        _submitForm: function (e) {
            console.log(e);
        },
        _search: function (params) {
            $scope = this;
            var selectorGrid = $scope.gridConfig.selectorCurrent;
            $(params.objSelector).on('change', function () {

            }).keyup(function () {
                searchData = $(this).val();
                if (searchData.length > 2) {
                    $(selectorGrid).bootgrid("search", searchData);
                } else if (searchData.length == 0) {
                    $(selectorGrid).bootgrid("search", '');

                }
            }).keydown(function () {

            }).keypress(function () {


            });

            $('#sort-by').on('change', function () {
                var sortConfig = new Object;
                var sortCurrent = 'asc';
                var sortId = $('#sort-by').val();
                var selectorCurrent = null;
                var nameKey = '';
                var titleOption = '';
                if (sortId == 0) {
                    selectorCurrent = '#nameSort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    titleOption = 'Empresa ';
                    nameKey = 'title';
                } else if (sortId == 1) {
                    selectorCurrent = '#emailSort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    nameKey = 'email';
                    titleOption = 'Email ';

                } else if (sortId == 2) {
                    selectorCurrent = '#categorySort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    nameKey = 'product_category';
                    titleOption = 'Categoria ';

                } else if (sortId == 3) {
                    selectorCurrent = '#subcategorySort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    nameKey = 'business_subcategory';
                    titleOption = 'Categoria ';

                } else if (sortId == 4) {
                    selectorCurrent = '#stateProvinceSort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    nameKey = 'business_state_province';
                    titleOption = 'Estado/Provincia ';

                } else if (sortId == 5) {
                    selectorCurrent = '#citySort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    nameKey = 'business_city';
                    titleOption = 'Ciudad ';

                } else if (sortId == 6) {
                    selectorCurrent = '#subcategorySort';
                    sortCurrent = $(selectorCurrent).attr('order');
                    nameKey = 'business_subcategory';
                    titleOption = 'Subcategoria ';

                }


                if (sortCurrent == 'asc') {
                    titleOption += ' ASC';
                    $(selectorCurrent).attr('order', 'desc');
                } else {
                    titleOption += ' DESC';
                }
                sortConfig[nameKey] = sortCurrent;
                $(selectorCurrent).html('');
                $(selectorCurrent).html(titleOption);
                if (sortId == -1) {
                    sortConfig = {};
                }
                $(selectorGrid).bootgrid("sort", sortConfig);
                $('.chosen-select').niceSelect('update');
            });
        },
    }
})
;




