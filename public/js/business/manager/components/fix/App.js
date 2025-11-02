var params_api = {
    entidad_id: 1,
    url: "",
    name: "MeetClic",
    function: function () {
        EntidadData: {
        }
    }
};
var entidad_data_params_name = "ConstEntidadData";
var scopeCurrent;
var app = angular
    .module("appModuleConfig", [
        "ui.bootstrap",
        "ngSanitize", //para trasnformar html y utilizar como scope (angular)
        "ngMaterial",
        "ngTouch",
        "ui.grid",
        "ui.grid.edit",
        "ui.grid.cellNav", //para ui grid
        "ui.grid.treeView", //tree
        "ui.grid.expandable", //expandible
        "toggle-switch",
        "ui.select2" //select 2 drop
    ])
    .constant(entidad_data_params_name, params_api);

var control = app.controller("controllerManagement", function (
    $scope,
    $http,
    $log,
    ConstEntidadData,
    $sce,
    $compile,
    $rootScope,
    uiGridConstants,
    $timeout,
    $interval,
    $uibModal
) {
    $scope.tax_data = {
        value: 12
    };
    UtilInvoice({'$scope': $scope});
    UtilManagerModal({'$scope': $scope, '$uibModal': $uibModal});
    ManagerOtherProcess({'$scope': $scope});
    //NEW
    scopeCurrent = $scope;
    $scope.business = $modelDataManager["business"][0];
    $scope.business_id = $scope.business.id;
    $scope.dataInvoiceHeader = {
        subtotal_tax: 0,
        subtotal_not_tax: 0,
        value_discount: 0,
        value_tax: 12,
        total: 0,
    };
    $scope.typeInvoiceData = [
        {id: "0", text: "Orden Reparacion"},
        {id: "1", text: "Factura"}
    ];
    $scope.totalInvoice = {
        subtotalX: $scope.getValueCustomer($scope.dataInvoiceHeader["subtotal_tax"]),
        subtotal0: $scope.getValueCustomer($scope.dataInvoiceHeader["subtotal_not_tax"]),
        discount: $scope.getValueCustomer($scope.dataInvoiceHeader["value_discount"]),
        tax: $scope.getValueCustomer($scope.dataInvoiceHeader["value_tax"]),
        total: $scope.getValueCustomer($scope.dataInvoiceHeader["total"]),
        balance: 0,
        advance: 0,
        invoice: 0
    };
    $scope.statusData = [
        {id: "IN OBSERVATION", text: "En Observacion"},
        {id: "INITIATED", text: "Iniciado"},
        {id: "FINISHED", text: "Finalizado/Entregado"},
        {id: "CANCELLED", text: "Cancelado"}
    ];

    $scope.firstManager = true;
    $scope.getDataModel = function () {
        var register_manager_date = $scope.getDateCurrent();
        var register_manager_date_hours = $scope.getFormatStringDate(register_manager_date).hoursString;
        var result = {
            type_invoice: "0", //orden
            status: "IN OBSERVATION",
            register_manager_date: register_manager_date,
            register_manager_date_hours: register_manager_date_hours
        };
        return result;
    };
    $scope.getFormatStringDate = function (date) {
        var hours = date.getHours();
        var ampm = (hours >= 12) ? "PM" : "AM";
        var hoursString = date.getHours() + ':' + date.getMinutes() + ' ' + ampm;
        var hoursStringDb = date.getHours() + ':' + date.getMinutes();
        var dayString = '';

        var result = {
            dayString: dayString,
            'hoursString': hoursString,
            'hoursStringDb': hoursStringDb,

        };
        return result;
    }
    $scope.model = {
        attributes: {},
        addParts: {}
    };
    /*  ----MANAGER ENTITY---*/
    $scope.configModelEntity = {
        buttonsManagements: [
            {
                title: "Actualizar",
                "data-placement": "top",
                "i-class": " fas fa-pencil-alt",
                managerType: "updateEntity"
            }
        ]
    };
    $scope.managerMenuConfig = {
        view: false,
        menuCurrent: [],
        rowId: null
    };
    $scope.configParams = {};
    $scope.labelsConfig = {
        buttons: {create: "Crear", update: "Actualizar"}
    };
    $scope.managerViews = {
        register: false,
        admin: true,
        type: 2
    };
    $scope.tabCurrentSelector = ".content";
    $scope.processName = "Registro Orden.";
    $scope.formConfig = {
        nameSelector: "#repair-form",
        url: $("#action-repair-saveData").val(),
        loadingMessage: "Guardando...",
        errorMessage: "Error al guardar el Orden.",
        successMessage: "La Orden se guardo correctamente.",
        nameModel: "Repair"
    };
    //Grid config
    $scope.gridConfig = {
        selectorCurrent: "#repair-grid",
        url: $("#action-repair-getAdmin").val()
    };
    $scope._viewManager = function (type) {
        if (type == 1) {
            $scope.managerViews = {
                register: true,
                admin: false,
                type: type
            };
        } else if (type == 2) {
            $scope.managerViews = {
                register: false,
                admin: true,
                type: type
            };
        } else if (type == 3) {
            $scope.managerViews = {
                register: true,
                admin: false,
                type: type
            };
        }
        $scope.resetForm();
        if ($scope.saveRegister) {
            $scope.saveRegister = false;
            $scope._filtersGrid();
        }
    };
    //GRIDS
    initGridCurrent({'$scope': $scope});
    //FORMS
    $scope.getValuesSave = function () {
        var repair_id = $scope.model.attributes.id;
        var RepairByDetailsParts = $scope.getDataGridRepair(repair_id);
        var subtotal = $scope.totalInvoice.total;
        var resultDateString = $scope.getFormatStringDate($scope.getDateCurrent());
        var hoursStringDb = resultDateString.hoursStringDb;
        var register_manager_date = moment($scope.model.attributes.register_manager_date).format("YYYY-MM-DD") + ' ' + hoursStringDb;
        var advance = $scope.totalInvoice.advance;
        var result = {
            Repair: {
                business_id: $scope.business_id,
                id: repair_id,
                register_manager_date: register_manager_date,
                description: $scope.model.attributes.description,
                customer_id: $scope.model.attributes.customer_id_data.id,
                value_taxes: $scope.model.attributes.type_invoice == "1" ? $scope.tax_data.value : 0,
                subtotal: subtotal,
                discount_value: 0,
                advance: advance,
                observations_fix: $scope.model.attributes.observations_fix,
                status: $scope.model.attributes.status,
                advance: $scope.typeInvoiceData.advance,
                total: $scope.totalInvoice.invoice,
                delivery_date: moment($scope.model.attributes.register_manager_date).format("YYYY-MM-DD") + " 00:00:00",
                RepairByDetailsParts: RepairByDetailsParts,
                filtersGrid: $scope.filtersGrid
            }
        };
        result.Repair['advance'] = advance;
        return result;

    };
    $scope.validateForm = function () {
        var gridAllowManager = $scope.getManagerAllowGrid();
        var currentAllow = gridAllowManager.success && !$scope.formManager.$invalid;
        return currentAllow;
    };
    $scope.resetForm = function () {
        $scope.formManager.$setUntouched();
        $scope.formManager.$setPristine();

        $scope.model = {
            attributes: $scope.getDataModel(),
            addParts: {}
        };
        //grid menu
        $scope.resetGridManagerParts();
        $scope.totalInvoice = {
            subtotalX: 0,
            subtotal0: 0,
            discount: 0,
            tax: 0,
            total: 0,
            balance: 0,
            advance: 0,
            invoice: 0
        };
    };
    $scope._resultsTotal = function () {
        var balance = 0;
        var subtotalX = 0;
        var invoice = 0;
        if ($.isNumeric($scope.totalInvoice.total) && $.isNumeric($scope.totalInvoice.advance)) {
            balance = $scope.totalInvoice.total - $scope.totalInvoice.advance;
            $scope.totalInvoice.balance = balance;
            invoice = $scope.totalInvoice.total;
            if ($scope.model.attributes.type_invoice == '1') {
                var subtotalX = $scope.dataInvoiceHeader.value_tax * $scope.totalInvoice.total / 100;
                balance = ($scope.totalInvoice.total + subtotalX) - $scope.totalInvoice.advance;
                $scope.totalInvoice.balance = balance;
                invoice = $scope.totalInvoice.total + subtotalX;
            }


        }
        $scope.totalInvoice.balance = $scope.getValueCustomer(balance);
        $scope.totalInvoice.subtotalX = $scope.getValueCustomer(subtotalX);
        $scope.totalInvoice.invoice = $scope.getValueCustomer(invoice);


    };
    $scope.saveRegister = false;
    $scope._saveModel = function () {
        var dataSendResult = $scope.getValuesSave();
        var dataSend = dataSendResult;
        var validateCurrent = $scope.validateForm();
        if (!validateCurrent) {
            alert('Error al registrar');
        } else {
            ajaxRequest($scope.formConfig.url, {
                type: "POST",
                data: dataSend,
                blockElement: $scope.tabCurrentSelector, //opcional: es para bloquear el elemento
                loading_message: $scope.formConfig.loadingMessage,
                error_message: $scope.formConfig.errorMessage,
                success_message: $scope.formConfig.successMessage,
                success_callback: function (response) {
                    if (response.success) {
                        var filtersGrid = response.data.filtersGrid;
                        $scope._resetManagerGrid();
                        $scope.resetForm();
                        $scope.firstManager = false;
                        $scope.saveRegister = true;
                        if (dataSendResult['Repair'].id) {
                            $scope._managerRowGrid({
                                managerType: "returnEntityReload"
                            });
                        }
                        $scope.initFiltersDataResults({
                            data: filtersGrid
                        });
                        $scope.$apply();
                    }
                }
            });
        }
    };
    initInvoiceManager({
        $scope: $scope,
        uiGridConstants: uiGridConstants
    });
    //DATE CURRENT
    //---------FECHA DE EMISION----------------

    $scope.formats = [
        "dd-MMMM-yyyy",
        "yyyy/MM/dd",
        "dd.MM.yyyy",
        "shortDate",
        "dd/MM/yyyy"
    ];
    $scope.dateOptions = {
        dateDisabled: disabledDateCalendar,
        formatYear: $scope.formats[0],
        customClass: getDayClass
    };

    $scope.openDateInvoice = function () {
        $scope.popupDateInvoice.opened = true;
    };
    $scope._dateInvoice = function (date) {
        var resultDateString = $scope.getFormatStringDate($scope.getDateCurrent());
        var register_manager_date_hours = resultDateString.hoursString;
        $scope.model.attributes.register_manager_date_hours = register_manager_date_hours;

    }
    $scope.popupDateInvoice = {
        opened: false
    };
    $scope.getDateCurrent = function () {
        var result = new Date();
        return result;
    };
    $scope.getErrorForm = function (attribute) {
        var hasError =
            $scope.formManager[attribute].$error.required &&
            $scope.formManager[attribute].$touched;
        if ("register_manager_date" == attribute) {
            hasError =
                $scope.formManager[attribute].$error.required &&
                $scope.popupDateInvoice.opened;
        }
        var result = {
            "has-error": hasError,
            "has-success": !hasError
        };

        return result;
    };
});
app.directive("initGridCurrent", function ($window) {
    return {
        scope: true,
        link: function (scope, element, attrs, controller, transcludeFn) {
            scope.initGridManager(scope);
        }
    };
})


function managerLoading(params) {
    if ($("#manager-container").hasClass("not-view")) {
        $("#manager-container").removeClass("not-view");
        $(".manager-loading").addClass("not-view");
    }
}

function initGridCurrent(params) {
    var $scope = params["$scope"];
    $scope.filtersDataResults = {
        'ALL': {
            text: 'Todos',
            total: 0,
            subtotal: 0,
            'value_taxes': 0
        },
        'IN OBSERVATION': {
            text: 'En Observacion',
            total: 0,
            subtotal: 0,
            'value_taxes': 0
        },
        'INITIATED': {
            text: 'Iniciado',
            total: 0,
            subtotal: 0,
            'value_taxes': 0
        },
        'FINISHED': {
            text: 'Finalizado/Entregado ',
            total: 0,
            subtotal: 0,
            'value_taxes': 0
        },
        'CANCELLED': {
            text: 'Anulados',
            total: 0,
            subtotal: 0,
            'value_taxes': 0
        },

    };

    $scope.filtersGrid = {
        status: 'ALL'
    };
    $scope.initFiltersDataResults = function (params) {
        var haystack = params['data'];
        if ($scope.filtersGrid.status == 'ALL') {

        }
        $.each($scope.filtersDataResults, function (key, value) {
            var resultFilters = $scope.searchManagerStatus(
                {
                    haystack: haystack,
                    keySearch: 'status',
                    needle: key,

                }
            );

            $scope.filtersDataResults[key]['value_taxes'] = resultFilters.value_taxes;
            $scope.filtersDataResults[key]['total'] = resultFilters.total;
            $scope.filtersDataResults[key]['registers'] = resultFilters.registers;
            $scope.filtersDataResults[key]['subtotal'] = resultFilters.subtotal;


        });
    };
    $scope.searchManagerStatus = function (params) {

        var resultSearch = $scope.searchTypeStatus(params);

        var registers = resultSearch.length;
        var value_taxes = 0;
        var total = 0;
        var subtotal = 0;
        $.each(resultSearch, function (key, value) {
            var totalCurrent = 0;
            var subtotalCurrent = parseFloat(value['subtotal']);
            var taxPercentage = parseFloat(value['value_taxes']);
            var taxResult = 0;
            if (taxPercentage > 0) {
                taxResult = subtotalCurrent * taxPercentage / 100;
                value_taxes += taxResult;
            }
            subtotal += subtotalCurrent;
        });
        total = subtotal + value_taxes;
        var result = {
            value_taxes: value_taxes,
            total: total,
            registers: registers,
            subtotal: subtotal,
        };
        return result;
    };
    $scope.searchTypeStatus = function (params) {
        var haystack = params['haystack'];
        var needle = params['needle'];
        var keySearch = params['keySearch'];

        var result = [];
        $.each(haystack, function (key, value) {
            if (value[keySearch] == needle) {
                result.push(value);
            }
        });

        return result;
    };
    $scope.initFiltersDataResults({
        data: $configPartial['dataManagerCurrent']
    });
    $scope.statusDataFiltersGrid = [
        {id: "ALL", text: "Todos"},
        {id: "IN OBSERVATION", text: "En Observacion"},
        {id: "INITIATED", text: "Iniciado"},
        {id: "FINISHED", text: "Finalizado/Entregado"},
        {id: "CANCELLED", text: "Cancelado"}
    ];
    $scope.loadingView = false;
    $scope._filtersGrid = function () {
        $($scope.gridConfig.selectorCurrent).bootgrid('reload');
        var dataSendResult = {
            filters: {
                status: $scope.filtersGrid.status,
                business_id: $scope.business_id,
            }
        };
        var dataSend = dataSendResult;
        ajaxRequest($urlBase+'/repair/getResults', {
            type: "POST",
            data: dataSend,
            blockElement: '.grid-manager-filters', //opcional: es para bloquear el elemento
            loading_message: 'Cargando Informacion....',
            error_message: 'Error al obtener informacion.',
            success_message: 'Informacion Obtenida.',
            success_callback: function (response) {
                $scope.initFiltersDataResults({
                    data: response
                });

                $scope.$apply();

            }
        });

    }

    function getFiltersGrid() {
        var status = $scope.filtersGrid.status;
        var result = {
            status: status,
            business_id: $scope.business_id,

        };
        return result;
    };
    $scope.initGridManager = function ($scope) {
        var gridName = $scope.gridConfig.selectorCurrent;
        var urlCurrent = $scope.gridConfig.url;
        var paramsFilters = {
            business_id: $scope.business_id
        };
        var formatters = {
            description: function (column, row) {
                var rowCurrent = row;
                var balance = 0;
                var subtotalX = 0;
                var invoice = 0;
                balance = parseFloat(rowCurrent.total) - parseFloat(rowCurrent.advance);
                invoice = parseFloat(rowCurrent.total);
                var value_taxes = parseFloat(rowCurrent.value_taxes);
                if (value_taxes > 0) {
                    var subtotalX = value_taxes * parseFloat(rowCurrent.subtotal) / 100;
                    invoice = parseFloat(rowCurrent.subtotal) + subtotalX;
                    balance = (invoice) - parseFloat(rowCurrent.advance);
                }
                balance = $scope.getValueCustomer(balance);
                invoice = $scope.getValueCustomer(invoice);
                var advanceView = [];
                var balanceView = [];

                var statusString =
                    '';
                var classStatus = "badge-success";
                if (row.status == "IN OBSERVATION") {
                    classStatus = "badge-warning";
                    statusString = 'En Observacion';
                    advanceView = ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                        'Anticipo' +
                        "     :</span><span class='content-description__value'> ",
                        ('$' + $scope.getValueCustomer(rowCurrent.advance)),
                        "   </span>",
                        "</div>"];

                    balanceView = ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                        'Saldo' +
                        "     :</span><span class='content-description__value'> ",
                        ('$' + balance),
                        "   </span>",
                        "</div>"];
                } else if (row.status == 'INITIATED') {
                    classStatus = "badge-info";
                    statusString = 'Iniciado';
                    advanceView = ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                        'Anticipo' +
                        "     :</span><span class='content-description__value'> ",
                        ('$' + $scope.getValueCustomer(rowCurrent.advance)),
                        "   </span>",
                        "</div>"];

                    balanceView = ["<div class='content-description__information'>",
                        "   <span class='content-description__title'>" +
                        'Saldo' +
                        "     :</span><span class='content-description__value'> ",
                        ('$' + balance),
                        "   </span>",
                        "</div>"];
                } else if (row.status == 'FINISHED') {
                    classStatus = "badge-success";
                    statusString = 'Finalizado/Entregado';

                } else if (row.status == 'CANCELLED') {
                    classStatus = "badge-danger";
                    statusString = 'Cancelado';

                }
                advanceView = advanceView.join('');
                balanceView = balanceView.join('');

                var register_manager_dateData = row.register_manager_date.split(' ');
                var register_manager_dateString = register_manager_dateData[1] + ' ' + register_manager_dateData[0];
                var result = [
                    "<div class='content-description'>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" +
                    'Control de Mantenimiento' +
                    "     :</span><span class='content-description__value'> ",
                    ('#' + row.id),
                    "   </span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" +
                    'Total' +
                    "     :</span><span class='content-description__value'> ",
                    ('$' + invoice),
                    "   </span>",
                    "</div>",
                    advanceView,
                    balanceView,
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" +
                    'Estado' +
                    ":</span><span class='content-description__value'><span class='badge badge--size-large " +
                    classStatus +
                    " '>" +
                    statusString +
                    "</span></span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" +
                    'Cliente' +
                    "     :</span><span class='content-description__value'> ",
                    (row.identification_document + ' - ' + row.name + ' ' + row.last_name),
                    "   </span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" +
                    'Descripcion del Trabajo' +
                    "     :</span><span class='content-description__value'> ",
                    (row.description),
                    "   </span>",
                    "</div>",
                    "<div class='content-description__information'>",
                    "   <span class='content-description__title'>" +
                    'Fecha Ingreso' +
                    "     :</span><span class='content-description__value'> ",
                    (register_manager_dateString),
                    "   </span>",
                    "</div>",
                    "</div>"
                ];

                return result.join("");
            }
        };
        var overWritePost = function (request) {
            request.filters = getFiltersGrid();
            return request;
        };
        let gridInit = initGridManager({
            gridNameSelector: gridName,
            paramsFilters: paramsFilters,
            formatters: formatters,
            urlCurrent: urlCurrent,
            overWritePost: overWritePost
        });

        gridInit.on("loaded.rs.jquery.bootgrid", function () {
            $scope._resetManagerGrid();
            $scope._gridManager(gridInit);
        });
    };
    $scope._resetManagerGrid = function () {
        $scope.managerMenuConfig = {
            view: false,
            menuCurrent: [],
            rowId: null
        };
        $scope.$apply();

    };
    $scope._destroyTooltip = function (selector) {
        $(selector).tooltip("hide");
    };
    $scope._managerMenuGrid = function (index, menu) {
        var params = {
            managerType: menu.managerType,
            id: menu.rowId,
            row: menu.params.rowData
        };
        $scope._managerRowGrid(params);
    };
    $scope.getMenuConfig = function (params) {
        var result = [];
        $.each($scope.configModelEntity["buttonsManagements"], function (
            key,
            value
        ) {
            var setPush = {
                title: value["title"],
                "data-placement": value["data-placement"],
                icon: value["i-class"],
                data: value,
                rowId: params.rowId,
                managerType: value["managerType"],
                params: params,
                isUrl: value["isUrl"],
                url: value["url"]
            };
            result.push(setPush);
        });
        return result;
    };
    $scope._gridManager = function (elementSelect) {
        var selectorGrid = $scope.gridConfig.selectorCurrent;
        _gridManagerRows({
            thisCurrent: $scope,
            elementSelect: elementSelect,
            'isAngular': true
        });

    };
    $scope._managerRowGrid = function (params) {
        if (params.managerType == "updateEntity") {
            var rowId = params.id;
            var rowCurrent = params.row;
            var elementDestroy = "#a-menu-" + $scope.managerMenuConfig.rowId;
            $scope._destroyTooltip(elementDestroy);
            $scope.resetForm();
            $scope._viewManager(3, rowId);
            $scope.managerMenuConfig.view = false;
            $scope.model.attributes.id = rowCurrent.id;
            $scope.model.attributes.name = rowCurrent.name;
            $scope.model.attributes.status = rowCurrent.status;
            $scope.model.attributes.description = rowCurrent.description;

            var value_taxes = $scope.getValueCustomer(rowCurrent.value_taxes)
            var register_manager_dateData = rowCurrent.register_manager_date.split(' ');
            $scope.totalInvoice.advance = $scope.getValueCustomer(rowCurrent.advance);
            $scope.totalInvoice.subtotalX = $scope.getValueCustomer(rowCurrent.value_taxes)
            $scope.totalInvoice.total = $scope.getValueCustomer(rowCurrent.total);
            var resultDateString = $scope.getFormatStringDate(new Date(rowCurrent.register_manager_date));
            var hoursStringDb = resultDateString.hoursStringDb;
            $scope.model.attributes.register_manager_date_hours = hoursStringDb;


            var balance = parseFloat(rowCurrent.total) - parseFloat(rowCurrent.advance);
            var invoice = parseFloat(rowCurrent.total);
            var value_taxes = parseFloat(rowCurrent.value_taxes);
            if (value_taxes > 0) {
                var subtotalX = value_taxes * parseFloat(rowCurrent.subtotal) / 100;
                invoice = parseFloat(rowCurrent.subtotal) + subtotalX;
                balance = (invoice) - parseFloat(rowCurrent.advance);
            }
            balance = $scope.getValueCustomer(balance);
            invoice = $scope.getValueCustomer(invoice);
            $scope.totalInvoice.balance = $scope.getValueCustomer(balance);
            $scope.totalInvoice.subtotalX = $scope.getValueCustomer(subtotalX);
            $scope.totalInvoice.invoice = $scope.getValueCustomer(invoice);
            $scope.model.attributes.customer_id_data = {
                text: (rowCurrent.identification_document + ' - ' + rowCurrent.name + ' ' + rowCurrent.last_name),
                id: rowCurrent.customer_id
            };

            //push data
            var dataCurrent = rowCurrent['detailsParts'];
            var repair_id = rowCurrent.id;
            $.each(dataCurrent, function (key, value) {
                var setPush = {
                    repair_id: repair_id,
                    quantity: value['quantity'],
                    product_color_id: value['product_color_id'],
                    repair_product_by_business_id: value['repair_product_by_business_id'],
                    product_trademark_id: value['product_trademark_id'],
                    repair_product_by_business: value['repair_product_by_business']
                };
                $scope.gridInvoiceOpts.data.push(setPush);

            });


        } else if (params.managerType == "returnEntity") {
            $scope.managerMenuConfig.view = true;
            $scope._viewManager(2, rowId);
        } else if (params.managerType == "returnEntityReload") {
            $scope.managerMenuConfig.view = false;
            $scope._viewManager(2, rowId);

            $($scope.gridConfig.selectorCurrent).bootgrid('reload');
        }

    };

}

function initInvoiceManager(params) {
    processStep1Invoice(params);
}

function ManagerOtherProcess(params) {
    var $scope = params["$scope"];

    $scope._addCustomer = function () {
        var typeManager = "CustomerManager";
        var templateUrl = "CustomerModal.html";
        var dataManager = {
            'filtersGrid': $scope.filtersGrid
        };
        $scope.openManagerModalType({
            modalConfig: {"templateUrl": templateUrl, size: "lg"},
            "typeManager": typeManager,
            data: dataManager,

        });
    }
}

function UtilManagerModal(params) {
    var $scopeCurrent = params['$scope'];
    var $uibModal = params['$uibModal'];
    $scopeCurrent.openManagerModalType = function (params) {
        var typeManager = params.typeManager;
        var templateUrl = params.modalConfig.templateUrl;
        var sizeModal = (params.modalConfig) ? params.modalConfig["size"] : "lg";
        var modalInstance =
            $uibModal
                .open({
                        backdrop: 'static',
                        keyboard: false,
                        windowClass: 'modal-view-angular',
                        size: sizeModal,
                        animation: true,
                        resolve: {
                            paramsCurrent: function () {
                                return params;
                            }
                        },
                        templateUrl: templateUrl,
                        controller: function ($scope, $uibModalInstance) {
                            if (typeManager == "CustomerManager") {
                                CustomerManager($scope, $uibModalInstance, params)
                            }

                        }
                    }
                );

        modalInstance.result.then(function (response) {
            if (response.type == 'CustomerFix') {//is save
                $scopeCurrent.model.attributes.customer_id_data = response.customer_id_data;
            }
        });


    };
}

$(function () {
    managerLoading();
});
