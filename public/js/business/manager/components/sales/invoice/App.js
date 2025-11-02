$(function () {
    managerLoading();
});

var statusCurrentManager = {
    'PENDIENTE': 'PENDING', 'EMITIDO': 'ISSUED', 'COLLECTED': 'NO SE', 'ANULADO': 'CANCELED'
};
var statusCurrentManagerEnglish = {
    'PENDING': 'PENDIENTE', 'ISSUED': 'EMITIDO', '': 'NO SECOLLECTED', 'CANCELED': 'ANULADO'
};
var $processNameIdentificationData = {};
//------Variables Globales***
//$entidad_name_modulo = declarado en l js principal de la vista
//entidad_id =declarado en la vista principal(ViewGestion)
//$entidad_name_ctrl=nombre como se l asigno en la vista
var $server_node_socketio = "http://192.168.0.104:2521/socket.io/socket.io.js";
var $server_local = "http://192.168.0.104:3500";
var server_restfull = "http://192.168.0.69:6969";
var grid_data_ob;
var params_api = {
    EntidadData: {
        entidad_id: 1, url: server_restfull, name: "MeetClic", function: function () {
            console.log("ss");
        }
    }
};
//----ESTE OBjeto ayudara paara poder manejar en cualqiera de los contralodres
//y asi poder utilizar la informacion
var entidad_data_params_name = "ConstEntidadData";
//---
var grid_object = [];
var expandibleob = [];

//ngSanitize--> sirve para poder retornar html en un scope
var $entidad_id = null;
var $typeOfProofData = {};
var baseUrl = '';
var managerCurrentModal = false;
var $resourcesManager = {};
var $dataDateCurrent = {};
var entidad_id = null;
var app = angular.module('appModuleConfig',
    [

        'ngSanitize', //para trasnformar html y utilizar como scope (angular)
        'ui.bootstrap',
        'ui.select2', //select 2 drop
        'toggle-switch',
        'ngMaterial', //PARA EL MODAL

// para el grid para la selecion
//            'ui.grid.pinning',
    ]).constant(entidad_data_params_name, params_api);
//-----------INICIALIZACION DE MODULOS en CONTROLADORES------
//para llamar al modulo ConstEntidadData debido a q en l modulo le pusimos d aqlo nombre
var control = app.controller('controllerManagement', function (
    $scope,
    $http,
    $log,
    ConstEntidadData,
    $sce,
    $compile,
    $rootScope,
    $timeout,
    $interval,
    $mdDialog,
    $uibModal
    ) {
        $configManagerProcessCurrent = $configPartial.resultProcess.data;
        $businessInformation = $configManagerProcessCurrent.data_empresa.empresa;
        $entidad_id = $businessInformation.id;
        entidad_id = $businessInformation.id;

        $typeOfProofData = $configManagerProcessCurrent.typeOfProofData;
        scopeCurrent = $scope;
        $scope.statusCurrentManager = statusCurrentManager;
        $data_empresa = $configManagerProcessCurrent.data_empresa;
        $resourcesManager["logoBusiness"] = $data_empresa.empresa.logo;
        $processNameIdentificationData = $configManagerProcessCurrent.processNameIdentificationData;
        $dataDateCurrent = $configManagerProcessCurrent.dataDateCurrent;
        $scope.resetdata = function () {
            if (!managerCurrentModal) {
                $scope.menu_gestion = [];
                $scope.tipo_factura = $scope.tipo_factura;
                $scope.oldSelected = 0;
            } else {
                var key_id = $scope.rowIdCurrent;
                $("#check-" + key_id).prop('checked');
                $("tr[data-row-id='" + key_id + "']").addClass("select-row-manager");
            }

        }
        UtilAdmin($scope);

        $scope.viewTrafficLights = {estimados: 0, pagados: 0, pendientes: 0, retrasados: 0};
        UtilGridManager(
            $scope,
            $http,
            $log,
            ConstEntidadData,
            $sce,
            $compile,
            $rootScope,
            $timeout,
            $interval,
            $mdDialog,
            $uibModal
        );
        UtilMenu($scope);
        UtilTrafficLights($scope);
        InitModalsAccountants($scope, $uibModal);
//            INICIALIZAR TODOS LOS S2initS2 DE LOS DIFERENTES PROCESOS
        initS2($scope,
            $http,
            $log,
            ConstEntidadData,
            $sce,
            $compile,
            $rootScope,
            $timeout,
            $interval,
            $mdDialog);
// INIT configuration contenido portlet
        $scope.header_i_icon = "fa fa-table";
        $scope.header_title_gestion = "Administracion";
        $scope.header_title_gestion_name = "Ventas";
        $scope.width_style = "8%";
        $scope.data_seleccionado = {};
        $scope.rowEntidadGestion = {};
// END configuration contenido portlet
//-----INIT MENU--

        $scope.gridDataConfiguration = {}; //configuracion dl grid
        $scope.dataRowsGestion = {};
        $scope.filters_data = {fecha_ini: "", fecha_fin: ""};
        $scope.tipo_factura = 'ventas';
        $scope.factura_id_old = 0;

        $scope.dateOptions = {
//        dateDisabled: disabled,
            formatYear: 'yyyy/MM/dd',
//        maxDate: new Date(2020, 5, 22),
//        minDate: new Date(),
//        startingDay: 3
        };

        // Disable weekend selection
        function disabled(data) {
            var date = data.date,
                mode = data.mode;
            return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        }

        $scope.openFechaPago = function () {
            $scope.popupFechaPago.opened = true;
        };
        $scope.popupFechaPago = {
            opened: false
        };
        $scope.openFin = function () {
            $scope.popupFin.opened = true;
        };
        $scope.popupFin = {
            opened: false
        };

        $scope.FiltroFInicio = function () {
            $scope.popupFiltroFInicio.opened = true;
        };
        $scope.popupFiltroFInicio = {
            opened: false
        };
        $scope.FiltroFFin = function () {
            $scope.popupFiltroFFin.opened = true;
//        $scope.reiniciarBootgridAdmin();
        };
        $scope.popupFiltroFFin = {
            opened: false
        };


        $scope.today = function () {
            $scope.dt = new Date();
        };
        $scope.today();

        $scope.clear = function () {
            $scope.dt = null;
        };

        $scope.options = {
            customClass: getDayClass,
            minDate: new Date(),
            showWeeks: true
        };

        // Disable weekend selection
        function disabled(data) {
            var date = data.date,
                mode = data.mode;
            return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        }

        $scope.toggleMin = function () {
            $scope.options.minDate = $scope.options.minDate ? null : new Date();
        };

        $scope.toggleMin();

        $scope.setDate = function (year, month, day) {
            $scope.dt = new Date(year, month, day);
        };

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var afterTomorrow = new Date(tomorrow);
        afterTomorrow.setDate(tomorrow.getDate() + 1);
        $scope.events = [
            {
                date: tomorrow,
                status: 'full'
            },
            {
                date: afterTomorrow,
                status: 'partially'
            }
        ];

        function getDayClass(data) {
            var date = data.date,
                mode = data.mode;
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0, 0, 0, 0);

                for (var i = 0; i < $scope.events.length; i++) {
                    var currentDay = new Date($scope.events[i].date).setHours(0, 0, 0, 0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }

            return '';
        }

//*----- fin de la gestion de fecha


    }
).directive("initS2", function () {
    return {
        link: function (scope, element, attrs, controller, transcludeFn) {
            scope.initS2Type(element);

        }
    }
});


function UtilMenu($scope) {

    $scope.menu_gestion = [];
    $scope.rowManager = null;
    $scope.menuGenerate = function (params) {
        var menuCurrent = [];
        $scope.rowManager = null;
        var row = params.row;
        var hasIndebtedness = row.deuda;
        var has_retencion = row.has_retencion;
        var estado = row.estado;
        var id = row.id;
        if (hasIndebtedness == 1 && (estado == statusCurrentManager["PENDIENTE"] || estado == statusCurrentManager["EMITIDO"])) {
            menuCurrent.push({class: "fa fa-plane", value: "Gestión de Credito", gestion_key: 1});
        }
        var gestion_key = null;
        if (has_retencion == "0") {//REALIZAR LA RETENCION
            gestion_key = 4;

        } else {//VER LAS RETENCIONES
            gestion_key = 25;
        }

        if (estado == statusCurrentManager["PENDIENTE"] || estado == statusCurrentManager["EMITIDO"]) {
            var allowManager = true;
            if (estado == "PENDIENTE") {
                var managerIndebtedness = row.managerIndebtedness;
                if (managerIndebtedness.indebtednessBreakDown && managerIndebtedness.indebtednessBreakDown.data && Object.keys(managerIndebtedness.indebtednessBreakDown.data).length > 0) {
                    allowManager = false;
                }

            }
            if (allowManager) {

                menuCurrent.push({class: "fas fa-long-arrow-alt-down", value: "Anulación", gestion_key: 6});
            }
        }
        menuCurrent.push({class: "fa fa-folder-open", value: "Factura Información", gestion_key: 5});
        $scope.menu_gestion = menuCurrent;

    }
//-----end MENU--
    $scope._managerRowInvoice = function (gestion_key) {
        var title = "";
        var content = "";
        var typeManager = "";
        switch (gestion_key) {
            case 1:
                title = "Gestion";
                content = "GeSTION  ";
                typeManager = "Indebtedness";
                var templateUrl = "indebtednessModal.html";
                $scope.openManagerModalAccountant({
                    modalConfig: {"templateUrl": templateUrl, size: "lg"},
                    "typeManager": typeManager,
                    data: $scope.rowManager,
                    step1: {
                        url: $('#action-invoice-sales-saveIndebtednessInit').val(),
                        "model": "InvoiceSalesIndebtednessPayingInit",

                    }, step2: {
                        url: $('#action-invoiceSaleByPayment-savePaymentInvoiceDebit').val(),
                        "model": "FacturaVentaPagosDesgloce",
                        "admin": $('#action-invoiceSaleByPayment-getAdminPayments').val(),
                        "urlS2": $('#action-invoiceSaleByBreakDownPayment-getPaymentsCurrentS2').val()
                    },
                });
                break;
            case 3:
                title = "Gestion";
                content = "Guias Remision";

                break;
            case 4://Retenciones
                title = "Retencion";
                content = "Gestion de Retencion";

                break;
            case 5:
                title = "Ver";
                content = "Facturación";
                typeManager = "ViewBilling";
                var templateUrl = "viewBillingModal.html";
                $scope.openManagerModalAccountant({
                    modalConfig: {"templateUrl": templateUrl, size: "lg"},
                    "typeManager": typeManager,
                    "typeBilling": "sales",
                    data: $scope.rowManager,
                    step1: {
                        url: "contabilidad/invoiceSalesIndebtednessPayingInit/saveIndebtedness",
                        "model": "InvoiceSalesIndebtednessPayingInit",

                    }, step2: {
                        url: $('#action-invoiceSaleByPayment-savePaymentInvoiceDebit').val(),
                        "model": "FacturaVentaPagosDesgloce",
                        "admin": $('#action-invoiceSaleByPayment-getAdminPayments').val(),
                        "urlS2": $('#action-invoiceSaleByBreakDownPayment-getPaymentsCurrentS2').val()
                    },
                });
                break;
            case 6:
                title = "Anulación";
                content = "Facturación";
                typeManager = "AnnulmentBilling";
                var templateUrl = "annulmentBillingModal.html";
                $scope.openManagerModalAccountant({
                    modalConfig: {"templateUrl": templateUrl, size: "lg"},
                    "typeManager": typeManager,
                    "typeBilling": "buys",
                    data: $scope.rowManager,
                    step1: {
                        url: $('#action-invoice-sales-saveAnnulmentBilling').val(),
                        "model": "FacturaVenta",
                        "gridSelectorElement": "#facturas-grid"

                    }
                });

                break;
            case 24://DEVOLUCION

                break;
            case 25://RETENCIONES VIEW FACTURAS

                break;

        }
//        var $params = {title: title, color: "#e7493b", icon: "fa fa-info", content: content};
//        msjSystem($params);
    }

    ////------ESTO ES PARA LOS FILTROS QUE HAY EN EL FORM---


}

function UtilTrafficLights($scope) {
    var urlTrafficLight = "gestionfinanciera/pagosVentasHasEntidad/getListPendiente";
    $params = {
        url: urlTrafficLight,
        data: {
            griDataFilters: $scope.griDataFilters,
            filters_data: $scope.filters_data,
            data_filtro: $scope.data_filtro
        }
    };


}
