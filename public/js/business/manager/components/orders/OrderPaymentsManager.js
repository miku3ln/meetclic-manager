var componentThisOrderPaymentsManager;
Vue.component('order-payments-manager-component', {
    template: '#order-payments-manager-template',
    directives: {},
    props: {
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
        this.business_id = $businessManager.id;// this.configParams.business_id;
    },
    mounted: function () {
        componentThisOrderPaymentsManager = this;
        this.initCurrentComponent();
        removeClassNotView();
    },
    computed: {},

    data: function () {

        var dataManager = {
            business_id: null,
            /*  ----MANAGER ENTITY---*/
            configModelEntity: {
                "buttonsManagements": $buttonsManagements,
                "buttonsProcess":$buttonsProcess
            },
            managerMenuConfig: {
                view: false,
                menuCurrent: [],
                rowId: null
            },
            configParams: {},
            labelsConfig: {buttons: {'create': 'Crear', 'update': 'Actualizar'}},
            tabCurrentSelector: '#tab-order-payments-manager',
            processName: "Registro Acción.",
            //Grid config
            gridConfig: {
                selectorCurrent: "#order-payments-manager-grid",
                url: $("#action-order-payments-manager-getAdmin").val()
            },
            submitStatus: "no",
            showManager: false,
            managerType: null,
            manager_state_data: [
                {value: -1, text: 'Todos'},
                {value: 1, text: 'Por Entregar'},
                {value: 2, text: 'Entregado'},

            ],//0=en cola,1=enviado,
            type_payment_customer_data: [
                {value: -1, text: 'Todos'},
                {value: 0, text: 'PayPal'},
                {value: 1, text: 'Tarjetas-Credito'},
                {value: 2, text: 'Depositos Bancarios'}
            ],
            filtersGrid: {
                manager_state: -1,
                type_payment_customer: -1,

            },
            /*  ---components---*/
            configModalDeliverOrder: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalViewOrder: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalBankReviewOrder: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalBusinessByInventoryManagement: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            },
            configModalBusinessByInventoryManagementSubcategory: {
                "title": "Title",
                "viewAllow": false,
                "data": []
            }
        };


        return dataManager;
    },
    methods: {
        ...$methodsFormValid,
        ...$methodsManagerProcess,

        initCurrentComponent: function () {

            this.initGridManager(this);
        },
        _setValueForm: function (type) {
            if (type == 'type_payment_customer') {

                if (this.filtersGrid.type_payment_customer > -1) {
                    this.filtersGrid.manager_state = -1;
                    if (this.filtersGrid.type_payment_customer == 2) {

                        this.manager_state_data = [{value: -1, text: 'Todos'},
                            {value: 0, text: 'Pendiente Documento'},
                            {value: 1, text: 'Por Entregar'},
                            {value: 2, text: 'Entregado'}
                        ];
                    } else {
                        this.manager_state_data = [{value: -1, text: 'Todos'},
                            {value: 1, text: 'Por Entregar'},
                            {value: 2, text: 'Entregado'}];
                    }

                } else {
                    this.filtersGrid.manager_state = -1;
                }
            }
            this._managerTypes({type: 'rebootGrid'});
        },

        //EVENTS OF CHILDREN
        _managerTypes: function (emitValues) {
            if (emitValues.type == "rebootGrid") {
                $(this.gridConfig.selectorCurrent).bootgrid("reload");

            } else if (emitValues.type == "resetComponent") {
                var componentName = emitValues.componentName;
                this[componentName].viewAllow = false;
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
            var rowData = params['rowData'];

            $.each(this.configModelEntity["buttonsManagements"], function (key, value) {
                var allowPush = true;


                if (rowData.type_payment_customer == 0) {//paypal
                    if (rowData.manager_state == 1) {

                        if (value["managerType"] == 'managerEntityBank') {
                            allowPush = false;
                        }
                    } else if (rowData.manager_state == 2) {//delivered

                        if (value["managerType"] == 'managerEntityBank' || value["managerType"] == 'managerEntity') {
                            allowPush = false;
                        }
                    } else if (rowData.manager_state == 3) {//anulado

                        if (value["managerType"] == 'managerEntityBank' || value["managerType"] == 'managerEntity') {
                            allowPush = false;
                        }
                    }
                } else if (rowData.type_payment_customer == 1) {//tarjetas


                } else if (rowData.type_payment_customer == 2) {//deposito
                    if (rowData.manager_state == 0) {

                        if (value["managerType"] == 'managerEntity') {
                            allowPush = false;
                        }
                    } else if (rowData.manager_state == 2) {//delivered

                        if (value["managerType"] == 'managerEntityBank' || value["managerType"] == 'managerEntity') {
                            allowPush = false;
                        }
                    } else if (rowData.manager_state == 1) {//iniciada

                        if (value["managerType"] == 'managerEntityBank') {
                            allowPush = false;
                        }
                    } else if (rowData.manager_state == 3) {//anulado

                        if (value["managerType"] == 'managerEntityBank' || value["managerType"] == 'managerEntity') {
                            allowPush = false;
                        }
                    }
                }

                if (allowPush) {
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
                }
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
            if (params.managerType == "viewEntity") {
                this.configModalViewOrder.data = rowCurrent;
                if (this.configModalViewOrder.viewAllow) {
                    this.$refs.refViewOrder._setValueOfParent(
                        {type: "openModal", data: this.configModalViewOrder}
                    );
                } else {
                    this.configModalViewOrder.viewAllow = true;
                }
            } else if (params.managerType == "managerEntity") {
                this.configModalDeliverOrder.data = rowCurrent;
                if (this.configModalDeliverOrder.viewAllow) {
                    this.$refs.refDeliverOrder._setValueOfParent(
                        {type: "openModal", data: this.configModalDeliverOrder}
                    );
                } else {
                    this.configModalDeliverOrder.viewAllow = true;
                }
            } else if (params.managerType == "managerEntityBank") {
                this.configModalBankReviewOrder.data = rowCurrent;
                if (this.configModalBankReviewOrder.viewAllow) {
                    this.$refs.refBankReviewOrder._setValueOfParent(
                        {type: "openModal", data: this.configModalBankReviewOrder}
                    );
                } else {
                    this.configModalBankReviewOrder.viewAllow = true;
                }
            }
        },

        getFiltersGrid: function () {
            var filters = this.filtersGrid;
            filters.business_id = this.business_id;
            return filters;
        },
        initGridManager: function (vmCurrent) {
            var gridName = this.gridConfig.selectorCurrent;
            var urlCurrent = this.gridConfig.url;
            let gridInit = $(gridName);
            var $this = this;
            gridInit.bootgrid({
                ajaxSettings: {
                    method: "POST"
                },
                ajax: true,
                requestHandler: function (request) {
                    request.filters = $this.getFiltersGrid();
                    return request;
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
                        var managerRefund = [];
                        var classStatus = "badge-success";
                        var statusName = '';
                        var typePaymentName = '';
                        if (row.type_payment_customer == 0) {
                            typePaymentName = 'PayPal';
                        } else if (row.type_payment_customer == 1) {
                            typePaymentName = 'Tarjetas de Credito';
                            managerRefund = [
                                "<div class='content-description__information'>",
                                "   <span class='content-description__title'>Transacción Referencia:</span><span class='content-description__value'><span class='badge badge--size-large badge-warning '>" + row.manager_id + "</span></span>",
                                "</div>",
                            ]
                        } else if (row.type_payment_customer == 2) {
                            typePaymentName = 'Deposito Bancario';
                        }

                        if (row.manager_state == 0) {//create
                            classStatus = "badge-warning";
                            statusName = 'Pendiente';
                        } else if (row.manager_state == 1) {//ejecutada
                            classStatus = "badge-info";
                            statusName = 'Por entregar';

                        } else if (row.manager_state == 2) {//delivered
                            classStatus = "badge-success";
                            statusName = 'Entregada';

                        } else if (row.manager_state == 3) {//delivered
                            classStatus = "badge-danger";
                            statusName = 'Anulado';

                        }
                        managerRefund = managerRefund.join('');
                        var result = [
                            "<div class='content-description'>",

                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Estado:</span><span class='content-description__value'><span class='badge badge--size-large " + classStatus + " '>" + statusName + "</span></span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Fecha Pedido:</span><span class='content-description__value'>" + row.start + "</span>",
                            "</div>",
                            "<div class='content-description__information'>",
                            "   <span class='content-description__title'>Tipo de Pago:</span><span class='content-description__value'>" + typePaymentName + "</span>",
                            "</div>",
                            managerRefund,
                            "</div>"];

                        return result.join("");

                    }

                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                vmCurrent._resetManagerGrid();
                vmCurrent._gridManager(gridInit);
            });
        },
        _managementShopInventoryConfigDesign: function () {
            var $scope = this;
            var business = $modelDataManager['business']['0'];
            var business_id = business['id'];
            var urlCurrent = $('#action-business-by-inventory-management-getDataProfileBusiness').val();
            var dataSend = {
                filters: {
                    business_id: business_id
                }
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

                    var rowCurrent = {business_id: business_id};

                    if(response.data){
                        rowCurrent['id']= response['data'].id;
                        rowCurrent['data']= response.data;

                    }
                    $scope.configModalBusinessByInventoryManagement.data = rowCurrent;
                    if ($scope.configModalBusinessByInventoryManagement.viewAllow) {
                        $scope.$refs.refBusinessByInventoryManagement._setValueOfParent(
                            {type: "openModal", data: $scope.configModalBusinessByInventoryManagement}
                        );
                    } else {
                        $scope.configModalBusinessByInventoryManagement.viewAllow = true;
                    }
                }
            });


        },
        _managementShopInventorySubcategory: function () {
            var $scope = this;
            var business = $modelDataManager['business']['0'];
            var business_id = business['id'];
            var rowCurrent = {business_id: business_id};
            $scope.configModalBusinessByInventoryManagementSubcategory.data = rowCurrent;
            if ($scope.configModalBusinessByInventoryManagementSubcategory.viewAllow) {
                $scope.$refs.refBusinessByInventoryManagementSubcategory._setValueOfParent(
                    {type: "openModal", data: $scope.configModalBusinessByInventoryManagementSubcategory}
                );
            } else {
                $scope.configModalBusinessByInventoryManagementSubcategory.viewAllow = true;
            }

        }
    }
})
;


function getViewOrderManager(params) {
    var rowCurrent = params['rowCurrent'];
    var details = rowCurrent['details'];
    var detailsOrder = getValuesOrder({
        details: details
    });
    detailsOrder = detailsOrder.join('');
    var result = {
        'detailsOrder': detailsOrder,
    };
    return result;

}

function getValuesOrder(params) {
    var details = params['details'];

    var detailsOrder = [];
    if ($allowRoutes == 1) {
        $.each(details, function (key, value) {

            var setParams = value.data;
            var currentUsers = getDetailsUsersHtml(setParams);

            var setPush = '<tr>';
            detailsOrder.push(setPush);

            setPush = '<td class="text-center"><strong class="ng-binding">' + value.quantity + '</strong></td>';
            detailsOrder.push(setPush);
            var spanDescriptions = '';

            var setDescription = value.name + currentUsers;
            setPush = ' <td><a href="javascript:void(0);" class="ng-binding">' + setDescription + '</a> </td>';
            detailsOrder.push(setPush);

            spanDescriptions = value.allow_discount == 1 ? value.price_discount : value.price;
            setPush = ' <td> $' + spanDescriptions + '</td>';
            detailsOrder.push(setPush);

            spanDescriptions = value.allow_discount == 1 ? parseInt(value.quantity) * parseFloat(value.price_discount) : parseInt(value.quantity) * parseFloat(value.price);

            setPush = ' <td> $' + spanDescriptions + '</td>';
            detailsOrder.push(setPush);


            setPush = '</tr>';
            detailsOrder.push(setPush);
        });
    } else {
        $.each(details, function (key, value) {
            var setPush = '<tr>';
            detailsOrder.push(setPush);

            setPush = '<td class="text-center"><strong class="ng-binding">' + value.quantity + '</strong></td>';
            detailsOrder.push(setPush);
            var spanDescriptions = value.measure_id != -1 ? '<span class="measure-value">Medida:' + value.measure + '</span>' : "";
            spanDescriptions += value.promotion_id != -1 ? '<span class="measure-value">Promocion:' + value.promotion + '</span>' : "";
            spanDescriptions += (value.colour_id != -1 && value.colour_id) ? '<span class="measure-value">Color:' + value.colour + '</span>' : "";
            spanDescriptions = spanDescriptions == '' ? 'No existe caracteristicas de este producto.' : spanDescriptions;

            setPush = ' <td><a href="javascript:void(0);" class="ng-binding">' + value.name + '</a> <br> Caracteristica Producto: <br>' + spanDescriptions + '</td>';
            detailsOrder.push(setPush);

            spanDescriptions = value.allow_discount == 1 ? value.price_discount : value.price;
            setPush = ' <td> $' + spanDescriptions + '</td>';
            detailsOrder.push(setPush);

            spanDescriptions = value.allow_discount == 1 ? parseInt(value.quantity) * parseFloat(value.price_discount) : parseInt(value.quantity) * parseFloat(value.price);

            setPush = ' <td> $' + spanDescriptions + '</td>';
            detailsOrder.push(setPush);


            setPush = '</tr>';
            detailsOrder.push(setPush);
        });
    }


    return detailsOrder;
}

function getDetailsUsersHtml(params) {
    var currentUsers = getDetailsUsers(params);
    var takeParts = [];
    $.each(currentUsers.people, function (k, v) {
        takeParts.push('<div class="preview-management__people">');
        var setPush = '   <div class="content-row">' + '<label class="preview-management-lbl ">' + '<span class="preview-management__title">' + v.one.label + ' : </span>' + v.one.value + '</label>' + '</div>';
        takeParts.push(setPush);

        setPush = '   <div class="content-row">' + '<label class="preview-management-lbl ">' + '<span class="preview-management__title">' + v.eight.label + ' : </span>' + v.eight.value + '</label>' + '</div>';
        takeParts.push(setPush);
        setPush = '   <div class="content-row">' + '<label class="preview-management-lbl ">' + '<span class="preview-management__title">' + v.nine.label + ' : </span>' + v.nine.value + '</label>' + '</div>';
        takeParts.push(setPush);
        takeParts.push('</div>')

    });
    takeParts = takeParts.join('');
    var informationEvent = '<div class="management-event">';
    informationEvent += '   <div class="content-row">' + '<label class="preview-management-lbl ">' + '<span class="preview-management__title">Equipo*: </span>' + currentUsers.team + '</label>' + '</div>';
    informationEvent += '   <div class="content-row">' + '<label class="preview-management-lbl ">' + '<span class="preview-management__title">Distancia*: </span>' + currentUsers.distance + '</label>' + '</div>';
    informationEvent += takeParts;
    informationEvent += '</div>';


    return informationEvent;
}

function getDetailsUsers(params) {

    var haystack = params['people'];
    var people = [];

    $.each(haystack, function (k, v) {


        var kits = v.data;
        var kitCurrent = [];
        $.each(kits, function (kKit, vKit) {
            var has_size = vKit.size_id;
            var has_color = vKit.color_id;
            var nameKit = vKit.product;
            var kitVariants = [];
            if (has_size) {
                var setPushKit = 'Talla:' + vKit.product_sizes;
                kitVariants.push(setPushKit);
            }
            if (has_color) {
                var setPushKit = 'Color:' + vKit.product_color;
                kitVariants.push(setPushKit);
            }

            if (Object.keys(kitVariants).length > 0) {
                nameKit = nameKit + ' - ' + kitVariants.join(',') + '<br>';
            } else {
                nameKit = nameKit + '<br>';

            }
            kitCurrent.push(nameKit);
        });

        var setPush = {

            'one': {
                'label': 'Participante Nro ' + (k + 1) + ' :',
                'value': v.full_name,
                'id': v.user_id
            },
            'two': {
                'label': 'Tipo Doc :',
                'value': '',
            },
            'three': {
                'label': 'Nro Documento :',
                'value': '',
            },
            'four': {
                'label': 'Fecha de Nacimiento :',
                'value': '',
            },
            'five': {
                'label': 'Telefono :',
                'value': '',
            },
            'six': {
                'label': 'Correo Electronico',
                'value': '',
            },
            'seven': {
                'label': 'Genero',
                'value': '',
            },
            'eight': {
                'label': 'Categoria :',
                'value': v.events_trails_type_of_categories,
            },
            'nine': {
                'label': 'Kit :',
                'value': kitCurrent.join(''),
                'data': kits
            },


        };
        people.push(setPush);


    });
    var team = params.eventConfig.team;
    var distance = params.eventConfig.distance;
    var result = {
        team: team.events_trails_type_teams,
        team_id: team.id,
        distance: distance.events_trails_distances,
        distance_id: distance.id,
        people: people,
    };

    return result;

}



