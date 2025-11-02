function viewInformacion($params) {
    var $object_gestion = $params.object_gestion;
    var $duration = $params.duration ? $params.duration : 700;
    var $view_object = $params.view_object;
    var $function = $params.function;
    if ($view_object) {

        $object_gestion.show($duration, $function);
    } else {
        $object_gestion.hide($duration, $function);

    }
//    if($function)
}

function toDate(dateStr, separate) {

    var parts = dateStr.split(separate);
    return new Date(parts[2], parts[1] - 1, parts[0]);
}


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


var grid_object = [];
var expandibleob = [];
var row_expand = {};
var allow_factura_save = false;


var $configManagerProcessCurrent = {};
var $viewProcessAllow = {};
var $managerResultsProcess = {};
var $procesos_all = {};
var $allowFinalCustomer = {};
var $managementCash = {};
var $data_empresa = null;
var $fecha_emision = null;
var ivaconfiguration = [];
var entityData = null;
var baseUrl = '';
var entidad_id = null;
var $managerRound = null;
var $dataFinalCustomer = null;
var $CashManagementCurrent = null;
var $css_print_factura='';
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
    $configManagerProcessCurrent = $configPartial.resultProcess.data;
    $managerResultsProcess = $configManagerProcessCurrent.managerResultsProcess;
    $viewProcessAllow = $configManagerProcessCurrent.viewProcessAllow;
    $procesos_all = $configManagerProcessCurrent.procesos_all;
    $allowFinalCustomer = $configManagerProcessCurrent.allowFinalCustomer;
    $managementCash = $configManagerProcessCurrent.managementCash;
    $data_empresa = $configManagerProcessCurrent.data_empresa;
    $fecha_emision = $configManagerProcessCurrent.fecha_emision;
    ivaconfiguration = $configManagerProcessCurrent.ivaconfiguration;
    entityData = $configManagerProcessCurrent.data_empresa.empresa;
    entidad_id = entityData.id;
    $managerRound = $configManagerProcessCurrent.managerRound;
    $dataFinalCustomer = $configManagerProcessCurrent.dataFinalCustomer;
    $CashManagementCurrent = $configManagerProcessCurrent.CashManagementCurrent;
    $css_print_factura =  $configManagerProcessCurrent.design.css.invoice;

    $scope.managerViewsProcess = {
        step1: true,
        step2: {
            retention: false
        }
    };
    $('body').addClass('enlarged');
    managerAuthorizationSettings($scope);
    $scope.validManagerStep1 = {
        header: false,//datos dl cliente
        details: false,//productos del cliente
        allReady: false//resultado del cliente

    };
    //CASH AND BANKS
    $scope.allow_cash_and_banks = entityData.allow_cash_and_banks ? true : false;
    $scope.viewTransactionBanks = false;
    $scope.allowAddTransaction = false;
    var bank_reason_id = 4;
    var cash_reason_id = 4;
    $scope.movementData = {
        movement_type: 0,
        details: "",
        transaction_type: 0,
        entity_type: 0,
        bank_reason_id: bank_reason_id,
        cash_reason_id: cash_reason_id,
    };
    $scope.viewProcessAllow = $viewProcessAllow;
    //------------INIT CONFIGURACION S2---
    initS2($scope);
    $scope.totalInvoice = {
        subtotalX: 0,
        subtotal0: 0,
        discount: 0,
        tax: 0,
        total: 0
    };

    $scope.getManagerHeaderRetention = function () {
        var result = {
            fecha_factura: $scope.data_factura_encabezado.fecha_factura

        };
        return result;
    }
    $scope.initValuesRetentions = function () {
        $scope.gridInvoiceOptsRetenciones.data = [];
        $scope.data_retenciones = {};
        $scope.data_retenciones = $scope.getManagerHeaderRetention();
        $scope.gestion_data_frm_retenciones.$setUntouched();
        $scope.gestion_data_frm_retenciones.$setPristine();
        $scope.total_renta = 0;
    }
//    -----------INIT PROCESOS VIEW-----------------
    $scope.viewSubprocesos = function () {
        if ($procesos_all["VENTAS_INVENTARIO"]["establecimiento"] == false) {
            var element_view = $("#content-all-establecimiento");
            element_view.hide();
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["fecha"] == false) {
            var element_view = $("#content-all-fecha");
            element_view.hide();
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["descuento"] == false) {
            var element_view = $("#content-all-descuento");
            element_view.hide();
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["retenciones"] == false) {
            var element_view = $("#content-all-retenciones");
            element_view.hide();
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["formas_pago"] == false) {
            var element_view = $("#content-all-formas_pago");
            element_view.hide();
        }
//content-all-descuento

    };

    $scope.resetSubprocesosValues = function () {

        if ($procesos_all["VENTAS_INVENTARIO"]["fecha"] == false) {
//            data_factura_encabezado.fecha_factura
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["descuento"] == false) {
//            data_factura_encabezado.type_descuento_factura
//data_factura_encabezado.type_descuento
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["retenciones"] == false) {
            $scope.data_factura_encabezado.retencion = false;
        }
        if ($procesos_all["VENTAS_INVENTARIO"]["forma_pago"] == false) {
//            $scope.toogleElementsConfigView.show_directo_mixto
        }
        if ($allowFinalCustomer) {
            $scope.data_factura_encabezado.cliente_data = {
                direccion: $dataFinalCustomer.direccion,
                email: $dataFinalCustomer.email,
                id: $dataFinalCustomer.id,
                identificacion: $dataFinalCustomer.identificacion,
                nombres_cliente: $dataFinalCustomer.nombres_cliente,
                razon_social: $dataFinalCustomer.razon_social,
                telefono: $dataFinalCustomer.telefono,
                text: $dataFinalCustomer.text,
                tipo_identificacion_id: $dataFinalCustomer.tipo_identificacion_id,

            };
        }
        $scope.managerInvoiceConfigOk();


    }
//-----------END VIEW SUBPROCESOS
    $scope.view_developer = true; //para mostrar el proceso
    $scope.data_empresa = $data_empresa;
    $scope.typeProduct = true;//product=true,servicie=false;
//    INIT GESTIONES
    ModalDataProducto($scope);
    initPrintData($scope);
    initPdfGestion($scope);
    var fecha_inicio_server = $fecha_emision;
    //-------CONFIGURACION Y ASIGNACION D IVA CONFIGURADO-*-
    $scope.exist_data = null; //si sta vacio no debe de guardar
    $scope.exist_data_iva_config = ivaconfiguration.length > 0 ? true : false;
    $scope.type_gestion = "FACTURA";
    $scope.processInvoiceValidation = {
        "invoiceSave": false,
        'validation_anexosave': false,
        validation_retencion: false
    };

    $scope.getInitInvoiceData = function () {

        $scope.data_factura_encabezado = {
            fecha_factura: toDate(fecha_inicio_server, "-"),
            type_descuento_factura: true,
            tipo_factura: {id: 1, text: 'FACTURA'},
            retencion: true,
            diferencia: 0,
            cliente_id: 0,
            entidad_id: entidad_id,
            type_descuento: true,
            type_valor_descuento: 0,
            tipo: $scope.type_gestion,
            'sub_total': '0.00',
            'valor_factura': '0.00',
            'valor_impuestos': '0.00',
            valor_descuento: '0.00',
            "observaciones": "",
            pendiente: true,
            estado: "PENDIENTE",
            exist_descuento: false,
            no_autorizacion: $scope.authorizationSettingInvoiceCode
        };
    };

    $scope.getInitInvoiceData();

    $scope.iva_data = {}; //tiene los ids dl iva configurado
    var data_factura = [];
    $scope.data_factura_save = [];
    object_all = $scope.data_factura_encabezado;
    /*$scope.viewSubprocesos();*/
//    ----AGREGA LOS VALORES AL IVA CONFIGURACION---
    $scope.iva_data_config = function () {
        if ($scope.exist_data_iva_config) {
            $scope.iva_data = {id: ivaconfiguration[0].id, value: ivaconfiguration[0].porcentaje};
            $scope.data_factura_encabezado['iva_id'] = $scope.iva_data.id;
            $scope.iva_selected = $scope.iva_data.value; //iva en valor
            $scope.data_factura_encabezado['iva'] = $scope.iva_selected;
        }
    }
    $scope.toogleElementsConfigView = {
        show_directo_mixto: true,
        show_efectivo_tarjeta: true,
        cobro_directo_pendiente: false,
        id_factura: 0,
        showValidRetencion: false,
        showValidationGuia: false,
        showbtnprint: false
    };
    $scope.iva_data_config();
    UtilManagerBilling($scope, $http);
    $scope.min_data = 0;
    $scope.max_data = 100;
    $scope.header_icon = "fa-table";
    $scope.header_typeGestionName = "Administrar";
    $scope.header_typeGestionEntidad = "Formularios";
    $scope.width_style = "8%";
    $scope.width = 8;
    $scope.height = 8;
    $scope.height_style = "8%";
    $scope.gridApiData = [];
    expandibleob = [];
    $scope.expandableRowDataAll;
    grid_data_ob = $scope.gridInvoiceOpts;
    $scope.enabled = true;
    $scope.onOff = true;
    $scope.yesNo = true;
    $scope.disabled = true;
    //---geston para registrar factura--
    $scope.factura_id = 0;
    $scope.view_gestion_factura = false;
    $scope.fecha_emision = $fecha_emision;
    //    ---ADD NEW
    $scope.processInvoiceValidation['managerSaveAllow'] = true; //para validar el formulario
    $scope.processInvoiceValidation['invoiceSave'] = false; //para guardar
    //------FIN DE LA FECHA------------
//    -----fin de proyecto-guia---
    $scope.data_encabezado_guia = {};
    ////------todo para el cobro de la factura---------------------------------------------------
//variable ppara ver si es con pago mixto o efectivo directo
    $scope.show_directo_mixto = true;
    $scope.info_text_normal_page = "Efectivo";
//---- esta varaible es para ver si paga con efectivo o tarjeta en pago directo---
    $scope.show_efectivo_tarjeta = true;
    //esto es la inicializacion de la vista de los tipos de pagos normal o mixto
    var gestion_view = {object_gestion: $("#content-normal-pagos"), view_object: true};
    viewInformacion(gestion_view);
    var gestion_view = {object_gestion: $("#content-pago-mixto"), view_object: false};
    viewInformacion(gestion_view);
    $scope.data_options_pagos = {};
    $scope.init_timer = false;
    var myVar;
//--------INIT FACTURA DETALLE---
    $scope.data_factura_detalle = [];
//    ---OBJETO PRODUCTO---
    $scope.producto_object = [];

    $scope.resetData = function () {
        $scope.resetPayment();

        $scope.totalInvoice = {
            subtotalX: 0,
            subtotal0: 0,
            discount: 0,
            tax: 0,
            total: 0
        };
        var gestion_view = {object_gestion: $("#manager-print"), view_object: false};
        viewInformacion(gestion_view);
        var gestion_view = {object_gestion: $("#content-data-rows"), view_object: true};
        viewInformacion(gestion_view);
        var gestion_view = {object_gestion: $("#content-gestion-procesos-facturas"), view_object: true};
        viewInformacion(gestion_view);
        var gestion_view = {object_gestion: $("#print-data"), view_object: false};
        viewInformacion(gestion_view);
        $scope.gestion_data_frm.$setUntouched();
        $scope.gestion_data_frm.$setPristine();
        $scope.processInvoiceValidation["invoiceSave"] = false;
        $scope.view_gestion_factura = false;
        $scope.gridInvoiceOpts.data = [];
        $scope.gridInvoiceConfigPayments.data = [];
        $scope.getInitInvoiceData();
//        $scope.data_factura_encabezado = {type_descuento_factura: true, tipo_factura: {id: 1, text: 'FACTURA'}, retencion: true, diferencia: 0, cliente_id: 0, entidad_id: entidad_id, type_descuento: true, type_valor_descuento: 0, tipo: $scope.type_gestion, 'sub_total': '0.00', 'valor_factura': '0.00', 'valor_impuestos': '0.00', valor_descuento: '0.00', "observaciones": "", pendiente: true, estado: "PENDIENTE", exist_descuento: false};
        $scope.data_factura_encabezado_pagos = {
            'diferencia': $scope.data_factura_encabezado['valor_factura'],
            total: '0.00'
        };
        $scope.data_entidad = {cuentas: {id: "", text: ""}};
        $scope.toogleElementsConfigView = {
            show_directo_mixto: true,
            show_efectivo_tarjeta: true,
            cobro_directo_pendiente: false,
            showValidRetencion: false,
            id_factura: 0
        };
        $scope.toogleElementsConfigView["showValidRetencion"] = false;
        $scope.gridInvoiceOptsRetenciones.data = [];
        $scope.data_retenciones = {};
        $scope.options = {'hayinformacion': false};
        $scope.save_data_allow();
//--------RESET VALORES---
        $scope.resetSubprocesosValues();
        var gestion_view = {object_gestion: $("#btn-gestion"), view_object: false};
        viewInformacion(gestion_view);
        $scope.validManagerStep1 = {
            header: false,//datos dl cliente
            details: false,//productos del cliente
            allReady: false//resultado del cliente

        };
        $scope.viewInformationCustomer = false;
    }
//    -------TIPOS DE DESCUENTO EN LA FACTURA--
    $scope.type_valor_descuentoChange = function () {
        if ($scope.data_factura_encabezado.type_descuento) {//%
            if ($scope.data_factura_encabezado.type_valor_descuento > 100) {

//                $scope.data_factura_encabezado.type_valor_descuento = 0;

            }
        } else {
            if ($scope.data_factura_encabezado.type_valor_descuento) {
                var valor_data_descuento = parseFloat($scope.data_factura_encabezado.type_valor_descuento);
                if ($scope.data_factura_encabezado.type_valor_descuento > $scope.data_factura_encabezado.sub_total) {

//                    $scope.data_factura_encabezado.type_valor_descuento = 0;
                }

            } else {
//                $scope.data_factura_encabezado.type_valor_descuento = 0;

            }
        }
        $scope.setDataPorcentaje();
        $scope.setResultData();
    }
    $scope._typeDescuento = function () {
        if (!$scope.data_factura_encabezado.type_descuento) {//%

            /* $scope.max_data = $scope.data_factura_encabezado.subtotal_encabezado;*/
        }
        $scope.setResultData();
    }

    $scope._typeDescuentoFactura = function () {

        if ($scope.data_factura_encabezado.type_descuento_factura) {//Discount Invoice
            var gestion_view = {object_gestion: $("#input-value-descuento"), view_object: true};
            viewInformacion(gestion_view);
        } else {//Discount Producto
            var gestion_view = {object_gestion: $("#input-value-descuento"), view_object: false};
            viewInformacion(gestion_view);
            $scope.data_factura_encabezado.type_valor_descuento = 0;
            angular.forEach($scope.gridInvoiceOpts.data, function (value, key) {
                $scope.gridInvoiceOpts.data[key].porcentaje_descuento_unidad = 0;
            });
        }
    }
    $scope.configManagerSetps = {
        step1: true,
        step2: false,
        step3: false,

    }
    $scope.managerStepsView = function (stepNext, stepCurrent) {


        if (stepNext == 1) {

            $scope.configManagerSetps = {
                step1: true,
                step2: false,
                step3: false,

            };
        } else if (stepNext == 2) {
            $scope.configManagerSetps = {
                step1: false,
                step2: true,
                step3: false,

            };
        }
    }


//    ---DESCUENTOS X PRODUCTO---
    $scope.getClassRow = function (data) {
        var result = "anyone";
        if (data.entity.porcentaje_descuento_manager) {
            if ($scope.data_factura_encabezado["type_descuento"]) {
                if (!$scope.data_factura_encabezado["type_descuento_factura"]) {
                    return "precio-venta strike";
                } else {
                    return result;
                }

            } else {
                if (!$scope.data_factura_encabezado["type_descuento_factura"]) {
                    return "precio-venta strike";
                } else {
                    return result;
                }
            }
        }
        return result;
    }
    $scope.getClassLabelSubtotal = function (data) {
        var result = "";
        if (data.entity.porcentaje_descuento_manager) {
            if ($scope.data_factura_encabezado["type_descuento"]) {
                if ($scope.data_factura_encabezado["type_descuento_factura"]) {
                    result = "lbl-descuento";
                } else {
                    result = "";
                }
            } else {
                if (!$scope.data_factura_encabezado["type_descuento_factura"]) {
                    result = "lbl-descuento";
                } else {
                    return result;
                }
            }
        }
        return result;
    }

    $scope.getRowDataDescuento = function (data) {
        var result = "";
        if (data.entity.porcentaje_descuento_manager) {
            if ($scope.data_factura_encabezado["type_descuento"]) {
                if (!$scope.data_factura_encabezado["type_descuento_factura"]) {

                    return $scope.viewDataFixed(data.entity.subtotal_descuento);

                } else {
                    return result;
                }

            } else {
                if (!$scope.data_factura_encabezado["type_descuento_factura"]) {
                    return $scope.viewDataFixed(data.entity.subtotal_descuento);
                } else {
                    return result;
                }
            }


        }
        return result;
    }
//------------ END CONFIGURACION S2---

//    ----FORMULARIO WIDGET---
    /**
     * header del widget
     */
//    $objeto_total_scope = new MyControlAskwer($scope, $http, ConstEntidadData);

    $scope.maxRow = function (data) {
        var inventario_max = 0;
        inventario_max = data.entity.inventario;
        return parseInt(inventario_max);
    }
    $scope.minRowKardex = function (data) {
        var min = 0;
        min = data.entity.kardex_promedio;
        return (min);
    }
//---------GRIDS--------
//-------INIT CONFIGURACION GRID-----
    $scope.gridApi = [];
    $scope.valorinsert = [];


    $scope.cellClicked = function (row) {
        console.log(row);
        if (!row.isExpanded) {//cuando no esta expandido existe
            $scope.collapseAllRows();
            $scope.expandRow(row.entity);
        } else {
            $scope.collapseRow(row.entity);
        }
    }
    $scope.setExpandRow = function (row) {
        if (row.isExpanded == undefined || row.isExpanded == false) {//cuando no esta expandido existe
            $scope.collapseAllRows();
            $scope.expandRow(row.entity);
            $scope.expandRow(row.entity);
        } else {
            $scope.collapseRow(row.entity);
        }
    }
    $scope.viewInformationCustomer = false;
    $scope.setDataCliente = function () {
        $scope.data_factura_encabezado.cliente_id = 0;
        $scope.viewInformationCustomer = false;
        if ($scope.data_factura_encabezado.cliente_data) {
            $scope.data_factura_encabezado.cliente_id = $scope.data_factura_encabezado.cliente_data.id;
            $scope.viewInformationCustomer = true;

        }
        this.setResultData();
    };
    $scope._saveByModal = function (params) {
        if (params.type = "saveCustomer") {
            var dataResponse = params.response;
            $scope.data_factura_encabezado.cliente_data = {};
            $scope.data_factura_encabezado.cliente_data = {
                direccion: dataResponse.information.address.value,
                email: dataResponse.information.mail.value,
                id: dataResponse.attributes.id,
                identificacion: dataResponse.information.customer.identificacion,
                information: dataResponse.information,
                nombre_clientes: (dataResponse.information.person.value),
                razon_social: dataResponse.information.customer.razon_social,
                telefono: dataResponse.information.phone.value,
                text: (dataResponse.information.customer.identificacion + " " + dataResponse.information.person.value),
                tipo_identificacion_id: dataResponse.information.customer.tipo_identificacion_id

            };
            $scope.setDataCliente();

        }
    };
    $scope._updateCustomer = function () {
        var customerId = $scope.data_factura_encabezado.cliente_id;
        var urlManager = "crm/cliente/updateCliente";
        var typeModal = "lg";
        var option_modal = {
            url: urlManager,
            type: typeModal,
            data: {entidad_id: customerId, "entidad_tipo": "cliente", "type": "sales"}
        };
        getModalInformacion(option_modal);
    }
    $scope.rowTemplate = function () {
        return '<div ng-class="{ \'add-data-element\': grid.appScope.rowFormatter( row ) }">' +
            '  <div ng-if="row.entity.merge">{{row.entity.title}}</div>' +
            '  <div ng-if="!row.entity.merge" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ng-class="{ \'ui-grid-row-header-cell\': col.isRowHeader }"  ui-grid-cell></div>' +
            '</div>';
    }

// Access outside scope functions from row template
    $scope.rowFormatter = function (row) {
        var data_class_return = row.entity.add_data_element_class === true;
        return data_class_return;
    };
    $scope.gestionRowEntidad = function (row) {
//        grid.appScope.perrin
        key_data_id = row.entity.id;
        var key_data = $scope.getDataRowIndex(key_data_id);
        return key_data;
    }
    $scope.expandableRowData = function (row) {

    }
    $scope._rowDataCantidad = function (data, row) {
        var key_search = $scope.gestionRowEntidad(row);
        $scope.gridInvoiceOpts.data[key_search].cantidad = data;
        $scope.setResultData(); //riniciar los resultados

    }
    $scope.allowViewDiscountProduct = function () {
        if ($scope.data_factura_encabezado.type_descuento_factura) {
//            alert("entro 1");
            return true;
        } else {
            return false;
        }
        $scope.setResultData(); //riniciar los resultados
    }
    $scope.getDiscountTotalProduct = function (params) {
        var efectivoValue = params.efectivoValue;
        var dataStack = params.dataStack;

        var subtotal = params.subtotal;
        var sumSubtotal = 0;

        angular.forEach(dataStack, function (value, key) {
            var subtotalCurrent = value.subtotal;
            sumSubtotal += parseFloat(subtotalCurrent);


        });

        var result = (efectivoValue / sumSubtotal) * subtotal;
        return result;

    }
    $scope.changeExpandableRowDataPrecio = function (data, row) {
        var key_search = $scope.gestionRowEntidad(row);
        var porcentaje_descuento = 0;
        var all = false; //para indicar q s hizo un cambio % individual true=no
//        precio_unitario = data;
        if (parseFloat(data) > 0) {//cuando existe valores validos
            precio_unitario = data;
            all = true;
            $scope.gridInvoiceOpts.data[key_search].precio_unitario = precio_unitario;
        }
        $scope.setResultData(); //riniciar los resultados

    }

    $scope.getClassCurrent = function (row, col) {
        var classResult = "ui-grid-cell-focus--success";
        if (!row.entity.typeProduct) {
            if (!row.entity.description) {
                classResult = "ui-grid-cell-focus--warning"
            }
        }
        return classResult;
    }
    $scope._viewElementDetailsGrid = function (entity) {

        return entity.typeProduct;
    }
    $scope.managerValidStep1 = function () {
        var header = true;
        var details = true;
        var allReady = false;

        if (
            !$scope.data_factura_encabezado.cliente_data
            /* || !$scope.data_factura_encabezado.SustenTributario
             /!*|| !$scope.data_factura_encabezado.TipoComprobante*!/
             */
            /*|| !$scope.data_factura_encabezado.no_autorizacion*/
            || !$scope.data_factura_encabezado.fecha_factura
            || !$scope.data_factura_encabezado.establecimiento
            || !$scope.data_factura_encabezado.punto_emision
            || !$scope.data_factura_encabezado.codigo_factura
        ) {

            header = false;

        } else {
            if ($scope.data_factura_encabezado.establecimiento) {
                header = $scope.validateNumberInvoiceType({
                    value: $scope.data_factura_encabezado.establecimiento,
                    "type": "establecimiento"
                });
            }
            if ($scope.data_factura_encabezado.punto_emision) {
                header = $scope.validateNumberInvoiceType({
                    value: $scope.data_factura_encabezado.punto_emision,
                    "type": "punto_emision"
                });
            }
            if ($scope.data_factura_encabezado.codigo_factura) {
                header = $scope.validateDigits({
                    value: $scope.data_factura_encabezado.codigo_factura,
                    "type": "codigo_factura"
                });
            }
        }
        if (!Object.keys($scope.gridInvoiceOpts.data).length) {
            details = false;
        } else {
            $.each($scope.gridInvoiceOpts.data, function (index, value) {
                var $errors = [];
                var allowRow = true;
                var typeProduct = value.typeProduct;
                var cantidad = value.cantidad;
                var precio_unitario = value.precio_unitario;

                if ((!precio_unitario && parseFloat(precio_unitario) <= 0)) {
                    if (!precio_unitario) {
                        $errors["precio_unitario"] = {
                            "msj": "No existe valor",
                            position: index, element: "precio_unitario"
                        };
                    }
                    if (parseFloat(precio_unitario) <= 0) {
                        $errors["precio_unitario"] = {
                            "msj": "Valor de 0",
                            position: index, element: "precio_unitario"
                        };
                    }


                    allowRow = false;
                }
                if ((!cantidad && parseFloat(cantidad) <= 0)) {
                    if (!parseFloat(cantidad)) {
                        $errors["cantidad"] = {
                            "msj": "No existe valor",
                            position: index, element: "cantidad"
                        };
                    }
                    if (parseFloat(cantidad) <= 0) {
                        $errors["cantidad"] = {
                            "msj": "Valor de 0",
                            position: index, element: "cantidad"
                        };
                    }

                    allowRow = false;
                }
                if (typeProduct) {//producto

                } else {//servicio
                    var description = value.description;
                    if (!description) {
                        $errors["description"] = {
                            "msj": "No existe valor",
                            position: index, element: "description"
                        };
                        allowRow = false;
                    }
                }
                $scope.gridInvoiceOpts.data[index]["errors"] = $errors;
                $scope.gridInvoiceOpts.data[index]["allowRow"] = allowRow;


            });
            $.each($scope.gridInvoiceOpts.data, function (index, value) {
                if (!value.allowRow) {
                    details = false;
                }
            });
        }

        if (header && details && !allow_factura_save) {
            allReady = true;
        }

        $scope.validManagerStep1 = {
            header: header,//datos dl cliente
            details: details,//productos del cliente
            allReady: allReady//resultado del cliente

        };
    }
    $scope.view_scroll_y = false;
    /*MANAGER GRID*/
    $scope._viewElementDetailsGrid = function (entity) {

        return entity.typeProduct;
    }
    $scope.getExpandableRowTemplate = function () {
        return '<div class="row-data" >'

            + '<div class="col-md-3 col-lg-3">'
            + ' <div class="row">'
            + '     <label class="col-md-12 control-label lbl-detalle" for="select-">Cantidad*<span class="required"></span></label>'
            + '     <div class="col-md-12">'
            + '         <input   select-value-element name="cantidad-{{row.id}}" class="form-control input-data-manager" type="number" min="1" max="{{grid.appScope.maxRow(row)}}" ng-change="grid.appScope._rowDataCantidad(grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].cantidad, row)" class="form-control " ng-model="grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].cantidad">'
            + '     </div>'
            + ' </div>'
            + '</div>'
            + '<div class="col-md-3 col-lg-3" ng-if="!grid.appScope.data_factura_encabezado.type_descuento_factura">'
            + '    <div id="descuento-unidad" class="row">'
            + '         <label class="col-md-12 control-label lbl-detalle" for="select-"> {{grid.appScope.data_factura_encabezado.type_descuento?"%":"$"}} Descuento <span class="required"></span></label>'
            + '         <div class="col-md-12">'
            + '             <input type="number" select-value-element name="porcentaje_descuento_manager-{{row.id}}" ng-disabled="grid.appScope.allowViewDiscountProduct()"  ng-change="grid.appScope._rowDataPorcentaje(grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].porcentaje_descuento_manager, row)"  class="form-control input-data-manager "  ng-model="grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].porcentaje_descuento_manager">'
            //                + '<input ng-disabled="grid.appScope.allowViewDiscountProduct()"  ng-change="grid.appScope._rowDataPorcentaje(grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].porcentaje_descuento_manager, row)"  class="form-control input-data-manager " type="number" min="0" max="100" ng-model="grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].porcentaje_descuento_manager">'
            + '         </div>'
            + '     </div>'
            + ' </div>'
            + ' <div class="col col-md-12 col-lg-12" ng-if="!grid.appScope._viewElementDetailsGrid(row.entity)">'
            + '             <label class="col-md-12 control-label lbl-detalle" for="select-">Descripción *<span class="required"></span></label>'
            + '              <div class="col-md-12">'
            + '                 <textarea select-value-element required="true" rows="2" name="description-{{row.id}}" class="form-control textarea--manager"  ng-change="grid.appScope.setResultData()" class="form-control " ng-model="grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].description"></textarea>'
            + '              </div>'
            + ' </div>'
            + '</div>';
    }
    $scope._viewChangePrice = function (row, col) {
        if (row.entity.typeProduct) {

            $scope.openManagerModalPrice({
                "templateUrl": "pricesManager.html",
                "data": {row: row, col},
                scopeParent: $scope
            });
        } else {
            $scope.cellClicked(row, col);
        }
    }

    $scope.openManagerModalPrice = function (params) {

        var templateUrl = params.templateUrl;
        var data = params.data;
        var scopeParent = params.scopeParent;
        var modalInstance =
            $uibModal
                .open({
                        windowClass: 'my-modal',
                        size: "md",
                        animation: true,
                        resolve: {
                            paramsCurrent: function () {
                                return params;
                            }
                        },
                        templateUrl: templateUrl,
                        controller: function ($scope, $uibModalInstance) {
                            $scope.row = data.row;
                            $scope.typeProductBoxUnit = $scope.row.entity.isContentBox;
                            $scope.managerDataPrice = null;
                            $scope.modelCurrent = {};
                            //box content
                            $scope.managerTypeContent = false;
                            $scope.pricesCurrent = [];
                            if ($scope.typeProductBoxUnit) {
                                $scope.pricesCurrent = $scope.row.entity.dataPrices;
                                $scope.modelCurrent.managerTypeContent = $scope.row.entity.managerTypeContent == 0 ? true : false;
                            }
                            $scope._managerTypeContent = function (managerTypeContent) {
                                $scope.modelCurrent.managerDataPrice = null;

                                if (managerTypeContent) {
                                    $scope.pricesCurrent = $scope.row.entity.dataPrices;
                                } else {
                                    $scope.pricesCurrent = $scope.getDataDropDown($scope.row.entity.dataBoxContent.prices);
                                }

                            }
                            $scope.getDataDropDown = function (data) {
                                var result = [];
                                if (data) {

                                    $.each(data, function (index, value) {
                                        result.push({
                                            value: parseFloat(value.price),
                                            text: "Precio 1/$" + scopeParent.getValueCustomer(value.price),
                                        })
                                    });
                                }
                                return result;
                            }


                            managerCurrentModal = true;
                            $scope.htmlTitle = !$scope.typeProductBoxUnit ? "Cambiar de precio <span class='span-value label label-warning'>" + $scope.row.entity.precio_unitario_view + "</span>" : "Cambiar de precio <span class='span-value label label-warning'>" + $scope.row.entity.precio_unitario_view + "</span>";
                            $scope.initModal = false;
                            $uibModalInstance.rendered.then(function () {
                                $scope.initModal = true;

                            });
                            scopeModal = $scope;
                            $scope.lblModalSave = "Cambiar";

                            $scope._dismiss = function () {
                                $uibModalInstance.dismiss('cancel');
                            };
                            $scope.selectCurrent = null;
                            $scope._changePrice = function () {

                                var index = scopeParent.gridInvoiceOpts.data.indexOf($scope.row.entity);

                                var currentPrice = $scope.formManagerModal.managerDataPrice.$modelValue;
                                scopeParent.gridInvoiceOpts.data[index]["precio_unitario"] = parseFloat(currentPrice);
                                scopeParent.gridInvoiceOpts.data[index]["precio_unitario_view"] = scopeParent.getValueCustomer(currentPrice);
                                scopeParent.gridInvoiceOpts.data[index]["precio_venta"] = scopeParent.getValueCustomer(currentPrice);
                                if ($scope.typeProductBoxUnit) {
                                    scopeParent.gridInvoiceOpts.data[index]["managerTypeContent"] = $scope.managerTypeContent == true ? 0 : 1;
                                    var details = "";
                                    if ($scope.managerTypeContent) {
                                        details = scopeParent.gridInvoiceOpts.data[index]["detailsAux"];
                                    } else {
                                        details = "(UNIDAD)" + scopeParent.gridInvoiceOpts.data[index]["detalle"];
                                    }
                                    scopeParent.gridInvoiceOpts.data[index]["detalle"] = details;


                                }
                                scopeParent.setResultData();
                                $uibModalInstance.dismiss('cancel');


                            };
                        }
                    }
                )
        ;

        modalInstance.closed.then(function () {
            managerCurrentModal = false;
        });


    };

    var columnsConfigInvoice = [
        {
            name: 'detalle',
            enableCellEdit: false,
            width: '50%',
            cellTemplate: '<div  ng-class="' + "{'ui-grid-cell-focus--warning':grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].description==undefined && grid.appScope.gridInvoiceOpts.data[grid.appScope.gestionRowEntidad(row)].typeProduct==false }" + '"> <div ng-click="grid.appScope.cellClicked(row,col)" class="ui-grid-cell-contents" title="TOOLTIP">{{COL_FIELD CUSTOM_FILTERS}}</div></div>'

        },
        {
            name: 'cantidad',
            enableCellEdit: true,
            enableCellEditOnFocus: true,
            width: '10%',
            type: 'number',
            editableCellTemplate: "<div  class='div-input-data-cantidad'><form name=\"inputForm\"><input class ='form-controll input-data-cantidad' type=\"INPUT_TYPE\" ng-class=\"'input-data-cantidad' + col.uid\" ui-grid-editor ng-model=\"MODEL_COL_FIELD\" ng-change='grid.appScope.change_lat(row,col)'></form></div>"


        },
        {
            name: 'precio_unitario_view',
            displayName: 'P.Uni',
            enableCellEdit: false,
            cellTemplate: '<div class="content-manager-price"  ng-click="grid.appScope._viewChangePrice(row,col)">{{row.entity.precio_unitario_view}}</div>'
            ,
            width: '15%',
        },
        {
            field: 'subtotal',
            name: 'Subtotal',
            /*cellTemplate: '<div><label  class="lbl-data {{grid.appScope.getClassLabelSubtotal(row)}}"><span class="data-span {{grid.appScope.getClassRow(row)}}">{{row.entity.subtotal_sin_descuento}}</span><br><span class="descuento-data" >{{grid.appScope.getRowDataDescuento(row)}}</span></label></div>',*/
            cellTemplate: '<div><label  class="lbl-data {{grid.appScope.getClassLabelSubtotal(row)}}"><span class="data-span {{grid.appScope.getClassRow(row)}}">{{grid.appScope.viewDataFixed(row.entity.subtotal_sin_descuento)}}</span><br><span class="descuento-data" >{{grid.appScope.getRowDataDescuento(row)}}</span></label></div>',

            enableCellEdit: false,
            enableCellEditOnFocus: false,
            width: '15%'
        },

        {
            name: ' ',
            enableCellEdit: false,
            cellTemplate: '<button data-toggle="tooltip" data-placement="top" title="Eliminar" type="button" class="delete-data far fa-trash-alt" ng-click="grid.appScope.deleteRow(row)"></button>'
            , width: '10%',
        }

    ];
    $scope.gridInvoiceOpts = {
        expandableRowTemplate: $scope.getExpandableRowTemplate(),
        expandableRowHeight: 50,
        enableRowSelection: true,
        enableHorizontalScrollbar: uiGridConstants.scrollbars.NEVER,
//        enableVerticalScrollbar: uiGridConstants.scrollbars.NEVER,
        columnDefs: columnsConfigInvoice,
        data: [],
        rowTemplate: $scope.rowTemplate(), //para poder poner las clases d qien esta asgianddo
        enableSorting: false,
        enableFiltering: false,
//        --expander config--
        enableExpandableRowHeader: true,
        enableExpandable: true,

        onRegisterApi: function (gridApi) {
            grid_object = gridApi;
            $scope.gridApi = gridApi;
            expandibleob = gridApi.expandable;
            $scope.gridApiData = gridApi;
//            $scope.$apply();
            $scope.gridApiData.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
                var precio = rowEntity.precio_unitario;
                rowEntity.precio_venta = precio;
                if (!newValue) {//null
                    rowEntity["cantidad"] = oldValue;
                }
                $scope.setResultData(); //riniciar los resultados
            });
            $scope.gridApiData.edit.on.beginCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
            });
            gridApi.expandable.on.rowExpandedStateChanged($scope, function (row) {

//                console.log(row);
                row_expand = row;
            });
            gridApi.expandable.on.rowExpandedStateChanged($scope, function (row) {

            });
            gridApi.expandable.on.rowExpandedBeforeStateChanged($scope, function (row) {
                var entity = row.entity;
                var typeProduct = entity.typeProduct;
                var isExpanded = row.isExpanded;
                var expandableRowHeight = 70;
                if (!typeProduct) {
                    expandableRowHeight = 140;
                }
                if (!isExpanded) {
                    $scope.gridInvoiceOpts.expandableRowHeight = expandableRowHeight;
                }
            });
        },
    };
//    $scope.scrollTo = null;
    $scope.scrollTo = function (rowIndex, colIndex) {
        $scope.gridApiData.core.scrollTo($scope.gridInvoiceOpts.data[rowIndex], $scope.gridInvoiceOpts.columnDefs[colIndex]);
    }
    $scope.scrollToFocus = function (rowIndex, colIndex) {
        $scope.gridApiData.cellNav.scrollToFocus($scope.gridInvoiceOpts.data[rowIndex], $scope.gridInvoiceOpts.columnDefs[colIndex]);
    }
    $scope.data_descuento_rows = [];
    //funcion para añadir el dato a ui-grid
    valorunico = 0;
    $scope.obja = [];
    $scope.addDataProducto = function () {
        if ($scope.init_modal_data == false) {//agregado normal
            if ($scope.data_factura_encabezado.producto_data) {//esto pasa cuando limpia si existe valor
                $scope.producto_object = $scope.data_factura_encabezado.producto_data;
                var key_search = $scope.producto_object.id;

                var typeProduct = $scope.typeProduct;
                var accountingSeat = [];
                if (!$scope.verificarAddData(key_search)) {//solo si no existe s agrega
                    var precio_venta = $scope.producto_object.precio_venta;
                    var array_attributes_producto = [{
                        id: key_search,
                        porcentaje_descuento: 0,
                        precio: parseFloat(precio_venta),
                        valor_descuento: 0,
                        cantidad: 1,
                        all: false
                    }];

                    var prices = [];
                    if (typeProduct) {
                        prices.push({
                            value: $scope.producto_object.precio_venta1,
                            text: "Precio 1/$" + $scope.getValueCustomer($scope.producto_object.precio_venta1)
                        })
                        prices.push({
                            value: $scope.producto_object.precio_venta2,
                            text: "Precio 2 /$" + $scope.getValueCustomer($scope.producto_object.precio_venta2)
                        });
                        prices.push({
                            value: $scope.producto_object.precio_venta3,
                            text: "Precio 3 /$" + $scope.getValueCustomer($scope.producto_object.precio_venta3)
                        });
                    } else {
                        var cuenta_contable = $scope.producto_object.cuenta_contable;
                        var contabilidad_cuenta_id = $scope.producto_object.contabilidad_cuenta_id;
                        var cuenta_contable_codigo = $scope.producto_object.cuenta_contable_codigo;
                        accountingSeat = {
                            id: contabilidad_cuenta_id,
                            cuenta: cuenta_contable,
                            codigo: cuenta_contable_codigo
                        };
                    }


                    valorunico = valorunico + 1;
                    /*    ----CONTENT UNITS---*/
                    var ptm_type_box = $scope.data_factura_encabezado.producto_data["ptm_type_box"];
                    var dataBoxContent = [];
                    var managerTypeContent = 0;
                    var isContentBox = false;
                    var measure_id = $scope.data_factura_encabezado.producto_data["ptm_id"];
                    var measure_type_box = $scope.data_factura_encabezado.producto_data["ptm_type_box"];
                    var measure_box_units = $scope.data_factura_encabezado.producto_data["ptm_type_box_units"];

                    if (ptm_type_box == 0) {
                        dataBoxContent = $scope.data_factura_encabezado.producto_data["dataBoxContent"];
                        dataBoxContent["measure"] = {
                            name: $scope.data_factura_encabezado.producto_data["ptm_name"],
                            units: $scope.data_factura_encabezado.producto_data["ptm_type_box_units"],
                        };
                        isContentBox = true;
                    }
                    var addOptions = {
                        managerTypeContent: managerTypeContent,//0 normal,1=units-content box
                        typeProduct: typeProduct,
                        isContentBox: isContentBox,
                        dataBoxContent: dataBoxContent,
                        measure_id: measure_id,
                        measure_type_box: measure_type_box,
                        measure_box_units: measure_box_units,
                        "id": key_search,
                        "detalle": $scope.producto_object.detalle,
                        "detailsAux": $scope.producto_object.detalle,
                        "codigo": $scope.producto_object.codigo,
                        "producto_id": $scope.producto_object.id,
                        "cantidad": 1, //U
                        "cantidad_unidades": 0, //CU
                        "porcentaje_descuento": 0, //U
                        "porcentaje_descuento_unidad": 0, //CU
                        "porcentaje_descuento_manager": 0, //CU
                        "valor_descuento": 0, //U
                        "valor_descuento_unidad": 0, //CU
                        "precio_unitario": parseFloat($scope.producto_object.precio_venta), //U incluido iva
                        "precio_unitario_view": $scope.getValueCustomer($scope.producto_object.precio_venta), //U incluido iva
                        "precio_unitario_unidad": 0, //CU
//                PARA VERIFICAR SI ES UNIDA/CAJA
//U=UNIDAD VENTA NORMAL
//C=CAJA VENTA CAJA
//CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.
                        "tipo_gestion": "U",
                        "porcentaje_iva": $scope.producto_object.porcentaje_iva, //ESTO VA PARA CUALQIERA D LOS TIPOS D COMPRA
                        "subtotal": 0,
                        "subtotal_descuento": 0,
                        "subtotal_sin_descuento": 0,
                        "total": 0,
                        "inventario": $scope.producto_object.inventario, //cuanto existe en el inventario tanto sea d tipo caja o unidades lo trabajamos x unidades
                        "row_gestion_id": $scope.producto_object.row_gestion_id, //este es l identificador parent(INVENTARIO)
                        "iva_id": $scope.producto_object.iva_id,
                        "precio_venta": parseFloat(precio_venta),
                        "precio_venta_descuento": 0,
                        "enable_caja": false,
                        "data": array_attributes_producto,
                        "add_data_element_class": true, //para saber qien esta en la gestion,
                        "expandRow": false, //saber si esta expandido,
                        "edit_precio": false,
                        "descuento_unidad": false,
                        "kardex_promedio": parseFloat($scope.producto_object.valor_kardex_promedio),
                        "ganancia": $scope.producto_object.ganancia,
                        "dataPrices": prices,
                        cccountingSeat: accountingSeat
                    };
                    $scope.gridInvoiceOpts.data.push(addOptions);
                    $scope.obja = [];
                } else {//s incrementa la cantidad +1
                    $scope.setDataRowIncrement(key_search);
                }
                $scope.data_factura_save = $scope.gridInvoiceOpts.data;
                $scope.data_factura_encabezado.producto_data = null;
                $scope.save_data_allow();
                $scope.setResultData();
                $scope._setRowExpandGridCurrent({key_search: key_search});
            } else {
                $scope.add_data_element_class(null);
            }
        } else {
            $scope.viewModalProducto($scope.data_factura_encabezado.producto_data);
        }

//------ADD  NEW ---

    };
    $scope._setRowExpandGridCurrent = function (params) {
        var key_search = params.key_search;
        $scope.add_data_element_class(key_search);
        var row_index_key = $scope.getDataRowIndex(key_search);
        $scope.scrollTo(row_index_key, 0);
        var data = $scope.gridInvoiceOpts.data[row_index_key];
        var row_data = {entity: data};
        $scope.timerInitExpand(row_data);
    }
    $scope.timerInitExpand = function (row_data) {
        var myVar = setInterval(function () {
            myTimer(row_data);
        }, 100);

        function myTimer() {
            if (!$scope.init_timer) {
                $scope.setExpandRow(row_data);
                $scope.init_timer = true;
            } else {
                myStopFunction();
                $scope.init_timer = false;
            }
        }

        function myStopFunction() {
            clearInterval(myVar);
        }
    }
//-----------ADD class selected-----------
    $scope.add_data_element_class = function (key_search) {
        var data_detalle = $scope.gridInvoiceOpts.data; //change
        angular.forEach(data_detalle, function (value, key) {
            var key_producto_id = parseInt(value["id"]);
            if (key_producto_id == key_search) {
                $scope.gridInvoiceOpts.data[key].add_data_element_class = true;
            } else {
                $scope.gridInvoiceOpts.data[key].add_data_element_class = false;
            }
        });
    }
//--------liminar datos del grid productos---
    $scope.deleteRow = function (row) {
        var index = $scope.gridInvoiceOpts.data.indexOf(row.entity);
        $scope.gridInvoiceOpts.data.splice(index, 1);
        $scope.setResultData();
        $scope.save_data_allow();
    };
    $scope.save_data_allow = function () {//si existe valores permitidos agregar un valor al a ayuuda
        var data_rows = $scope.gridInvoiceOpts.data.length;
        if (data_rows > 0) {//si existe x lo menos un registro realizar gestion
            $scope.exist_data = 1;
        } else {
            $scope.exist_data = null;
        }

    }

//    ----VERIFICA SI EXISTE AQL PRODUCTO YA ESTA AGREGADO AL DETALLE
    $scope.verificarAddData = function (key_search) {
        var data_detalle = $scope.gridInvoiceOpts.data; //change
        var result_exist_key = false;
        angular.forEach(data_detalle, function (value, key) {
            var key_producto_id = parseInt(value["id"]);
            if (key_producto_id == key_search) {
                result_exist_key = true;
                return result_exist_key;
            }

        });
        return result_exist_key;
    }
    $scope.getDataRowIndex = function (key_search) {
        var data_detalle = $scope.gridInvoiceOpts.data; //change
        var result_exist_key = 0;
        angular.forEach(data_detalle, function (value, key) {
            var key_producto_id = parseInt(value["id"]);
            if (parseInt(key_producto_id) == parseInt(key_search)) {
                result_exist_key = key;
                return result_exist_key;
            } else {
            }

        });
        return result_exist_key;
    }
//    ----INCREMENTA LA CANTIDAD ANTERIOR MAS LA NUEVA----
    $scope.setDataRowIncrement = function (key_search) {
        var data_detalle = $scope.gridInvoiceOpts.data; //change
        var cantidad_add = 1;
        angular.forEach(data_detalle, function (value, key) {
//            console.log(value);
            var key_producto_id = parseInt(value["id"]);
            if (key_producto_id == key_search) {
                var cantidad_anterior = parseInt(value["cantidad"]);
                $scope.gridInvoiceOpts.data[key]["cantidad"] = cantidad_anterior + cantidad_add;
                $scope.gridInvoiceOpts.data[key].data[0].cantidad = cantidad_anterior + cantidad_add;
                return true;
            }

        });
    }

    $scope.getConfigDiscountByType = function (data) {
        var result = data;
        /*------------------DISCOUNT $$------------*/
        if ($scope.data_factura_encabezado.type_descuento_factura) {//Discount Invoice
            var data_detalle = data; //change
            var data_detalleAux = [];
            if (!$scope.data_factura_encabezado.type_descuento) {//$$
                angular.forEach(data_detalle, function (value, key) {
                    var efectivoValue = $scope.data_factura_encabezado.type_valor_descuento;
                    var dataStack = data;
                    var subtotal = value.subtotal;
                    var descTotal = $scope.getDiscountTotalProduct({
                        subtotal: subtotal,
                        efectivoValue: efectivoValue,
                        dataStack: dataStack
                    });
                    var porcentaje_descuento = descTotal * 100 / subtotal;
                    var setPush = value;
                    setPush["porcentaje_descuento_unidad"] = porcentaje_descuento.toFixed($managerRound);
                    data_detalleAux.push(setPush);
                });
                result = data_detalleAux;
            } else {
                var data_detalle = data; //change
                var data_detalleAux = [];
                angular.forEach(data_detalle, function (value, key) {
                    var percentageValue = $scope.data_factura_encabezado.type_valor_descuento ? $scope.data_factura_encabezado.type_valor_descuento : 0;
                    var dataStack = data;
                    var subtotal = value.subtotal;
                    var descTotal = subtotal * percentageValue / 100;
                    var setPush = value;
                    setPush["porcentaje_descuento_unidad"] = percentageValue.toFixed($managerRound);
                    data_detalleAux.push(setPush);
                });
                result = data_detalleAux;

            }
        } else {//Discount Producto

            if (!$scope.data_factura_encabezado.type_descuento) {//$$
                var data_detalle = data; //change
                var data_detalleAux = [];
                angular.forEach(data_detalle, function (value, key) {
                    var descTotal = value.porcentaje_descuento_manager;
                    var subtotal = value.subtotal;
                    var percentageValue = 0;
                    if (subtotal) {

                        percentageValue = descTotal * 100 / subtotal;
                    }
                    var setPush = value;
                    setPush["porcentaje_descuento_unidad"] = percentageValue.toFixed($managerRound);
                    data_detalleAux.push(setPush);
                });
                result = data_detalleAux;
            }
        }

        return result;

    }

//    ---MODIFICA LAS FILAS DE CADA UNO D LOS REGISTROS DEL DETALLE
//ASIGNA LOS NUEVOS VALORES DEL ENCABEZADO

//    ----INIT NEW PORCENTAJE ---
    $scope.setDataPorcentaje = function () {
        var valor_porcentaje = $scope.data_factura_encabezado.type_valor_descuento;
        var data_detalle = $scope.gridInvoiceOpts.data; //change
        angular.forEach(data_detalle, function (value, key) {
            var precio_compra = parseFloat(value["precio_unitario"]);
        });
    }
//    ----END NEW PORCENTAJE ---

    $scope.expandAllRows = function () {
        $scope.gridApiData.expandable.expandAllRows();
    }

    $scope.collapseAllRows = function () {
        $scope.gridApiData.expandable.collapseAllRows();
    }
    $scope.expandRow = function (rowEntity) {
//        console.log(rowEntity);
//        ----cerrar todos luego abrir---
        $scope.gridApiData.expandable.expandRow(rowEntity);
    }
    $scope.collapseRow = function (rowEntity) {
        $scope.gridApiData.expandable.collapseRow(rowEntity);
    }
//-------END CONFIGURACION GRID-----
    $scope.gridOptions = {
        enableSorting: true,
        columnDefs: [
            {name: 'field1', enableSorting: false},
            {name: 'field2'},
            {name: 'field3', visible: false}
        ]
    };

    $scope.changeCallback = function () {
    };
    $scope.formatState = function (state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span><img src="vendor/images/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    }
    ;
//--------SAVE INFORMACION------
    $scope.saveData = function () {
        var dataManager = {
            data_factura_encabezado: $scope.data_factura_encabezado,
            data_factura_detalle: $scope.gridInvoiceOpts.data,
            'CashManagementCurrent': $CashManagementCurrent['data']
        };
        var url_gestion = $('#action-invoice-sales-saveInvoicePointOfSales').val();
        var params_gestion = {
            url: url_gestion, //accion dond vamos a realizar la gestion
            data: dataManager, //paramatros para realizar l proceso
            beforeCall: function () {//funcion antes d ejecutarse el procesos
                //ocultar ,bloquear botones,etc
                //          ----ocultar l contenedor main---
                var gestion_view = {object_gestion: $("#content-data-rows"), view_object: false};
                viewInformacion(gestion_view);
//            ---MOSTRAR EL LOADING---
                var gestion_view = {object_gestion: $("#loading-content"), view_object: true};
                viewInformacion(gestion_view);
//
            },
            successCall: function (response) {
                //            ---ocultar EL LOADING---
                var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                viewInformacion(gestion_view);
                //          ----ocultar l contenedor main---
                var gestion_view = {object_gestion: $("#content-data-rows"), view_object: true};
                viewInformacion(gestion_view);
                if (response.success) {
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: "Realizado Correctamente."
                    };
                    msjSystem($params);
                } else {
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: response.msj
                    };
                    msjSystem($params);
                }
                $scope.resetData();
            },
            errorCall: function (response) {
                var statusText = response.statusText;
                var status = response.status;
                //            ---ocultar EL LOADING---
                var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                viewInformacion(gestion_view);
                //          ----ocultar l contenedor main---
                var gestion_view = {object_gestion: $("#content-data-rows"), view_object: true};
                viewInformacion(gestion_view);
                var $params = {title: "Registro. ", color: "#e7493b", icon: "fa fa-info", content: statusText};
                msjSystem($params);
            },
        };
        gestionInformacion(params_gestion);
    }

//    ---metodo q mostrara u ocultara los diferentes datos---
    $scope.customerValues = {
        take: 0,
    };
    $scope.gestionFactura = function (state) {
        $scope.accountsAddsBuysSales = [];
        $scope.managerViewsProcess.step2.retention = false;
        $scope.managerViewsProcess.step1 = true;

        if (allow_factura_save) {//factura ya existente
            var $params = {title: "Factura ", color: "#e7493b", icon: "fa fa-info", content: "Ya Gestionada"};
            msjSystem($params);
        } else {//realizar gestion de venta
            $scope.data_codigo_factura = $scope.data_factura_encabezado.establecimiento + "-" + $scope.data_factura_encabezado.punto_emision + "-" + $scope.data_factura_encabezado.codigo_factura;
//managerSaveAllow
            if (!$scope.view_gestion_factura && $scope.processInvoiceValidation.invoiceSave == false) {//cuando tiene esto es x q sige realizaond
//el ingreso de datos ala factura
                $scope.view_gestion_factura = true;
//----------mostrar y ocultar los divs---
                $scope.data_pay_efectivo["recibido"] = $scope.data_factura_encabezado.valor_factura;
                var gestion_view = {object_gestion: $("#content-data-rows"), view_object: false};
                viewInformacion(gestion_view);
                var myVar;

                function initViewDatas() {
                    $scope.managerViewsProcess.step2.retention = $scope.data_factura_encabezado["retencion"];
                    myStopFunction(myVar);
                }


                function myStopFunction(stopObject) {
                    clearInterval(stopObject);
                }

                var gestion_view = {
                    object_gestion: $("#print-data"), view_object: true, function: function () {
                        $("#pago-recibido-input").select();
                        $("#pago-recibido-input").click();
                        myVar = setInterval(initViewDatas, 1000);
                    }
                };
                viewInformacion(gestion_view);
                $scope.initValuesRetentions();
                $scope.data_factura_encabezado["totalConRetencion"] = $scope.data_factura_encabezado["valor_factura"];
                $scope.toogleElementsConfigView.show_directo_mixto = true;
                $scope.managerStepsView(2, 1);
                $scope.validateStatePaymentsSalesBuys();


            } else {
//                console.log('-----------------TODO------------');
                if ($scope.view_gestion_factura && $scope.processInvoiceValidation.invoiceSave) {
//                    console.log('-----------------ELSE IF GUARDADO LA FACTURA------------');
//                $scope.$apply(function () {
                    $scope.resetData();
//                })
                    $scope.managerStepsView(1, 2);

                } else {
//                    console.log('------------------REGRESAR ALA GESTION-----------------');
//el ingreso de datos ala factura
                    $scope.view_gestion_factura = false;
//----------mostrar y ocultar los divs---
                    var gestion_view = {object_gestion: $("#content-data-rows"), view_object: true};
                    viewInformacion(gestion_view);
                    var gestion_view = {object_gestion: $("#content-pago-mixto"), view_object: false};
                    viewInformacion(gestion_view);
                    var gestion_view = {object_gestion: $("#content-normal-pagos"), view_object: true};
                    viewInformacion(gestion_view);
                    var gestion_view = {
                        object_gestion: $("#print-data"), view_object: false, function: function () {
                            $("#factura_btn").select()
                            $("#pago-factura").click()
                        }
                    };
                    viewInformacion(gestion_view);
                    $("#content-all").removeClass("class-content-all-gestion");
                    $("#content-all").addClass("class-content-all");
                    $("#factura_btn").select();
                    $scope.managerStepsView(1, 2);
                    $scope.resetPayment();

                }

            }
        }

        $scope.viewOptionsBtnsElements();

    }
//    ----MODAL DE AYUDA PARA BUSQUE DE PRODUCTOS------
    $scope.serchValueInventario = function () {

        if ($scope.typeProduct) {
            var url_set_get = 'productos/productoInventario/searchData';
            var params = {
                url: url_set_get,
                type: "lg",
            };
            getModalInformacion(params);
        } else {
            console.log("activos y gastios")
        }
    }

    //---------FECHA DE EMISION----------------
    function getDayClass(data) {
        var date = data.date,
            mode = data.mode;
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0, 0, 0, 0);
            for (var i = 0; i < eventsDate.length; i++) {
                var currentDay = new Date(eventsDate[i].date).setHours(0, 0, 0, 0);
                if (dayToCheck === currentDay) {
                    return eventsDate[i].status;
                }
            }
        }

        return '';
    }

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate', 'dd/MM/yyyy'];
    $scope.dateOptions = {
        dateDisabled: disabledDateCalendar,
        formatYear: $scope.formats [4],
        customClass: getDayClass,
    };


    $scope.openInicio = function () {
        $scope.popupInicio.opened = true;
    };
    $scope.popupInicio = {
        opened: false
    };
    $scope.openFin = function () {
        $scope.popupFin.opened = true;
    };
    $scope.popupFin = {
        opened: false
    };
    $scope.today = function () {
        $scope.dt = new Date();
    };
    $scope.today();
    $scope.clear = function () {
        $scope.dt = null;
    };
    $scope.NextPagePagos = function () {
        var gestion_view = {object_gestion: $("#documento-guias-remision"), view_object: false};
        viewInformacion(gestion_view);
        var gestion_view = {object_gestion: $("#print-data"), view_object: true};
        viewInformacion(gestion_view);
        $params = {
            url: "gestionSuministros/guiaRemision/saveGRemision",
            data: {
                data_factura_encabezado: $scope.data_factura_encabezado,
                data_factura_detalle: $scope.gridInvoiceOpts.data,
                data_factura_encabezado_pagos: $scope.data_factura_encabezado_pagos,
                data_factura_detalle_pagos: $scope.gridInvoiceConfigPayments.data,
                data_motivo_tras: $scope.data_encabezado_guia
            }
        };
        gestionData($params, function (resultado) {
            if (resultado == "") {
                $scope.toogleElementsConfigView["showValidationGuia"] = true;
            }
        });
        $scope.printData();
    }
    $scope.ClickFactura = function () {
        $scope.toogleElementsConfigView["showbtnprint"] = false;
    }

    $scope._paymentCashCard = function (data) {

        if (data) {
            $scope.toogleElementsConfigView["show_efectivo_tarjeta"] = true;
            $scope.info_text_normal_page = "Efectivo";
        } else {
            $scope.toogleElementsConfigView["show_efectivo_tarjeta"] = false;

            $scope.info_text_normal_page = "Tarjeta de Credito";
        }
    };
    $scope.valueReceived = 0;
    $scope.typeProcessMacro = "sales";
    $scope._valuePayment = function () {
        var total = 0;
        var received = $scope.data_factura_encabezado.valueReceived ? parseFloat($scope.data_factura_encabezado.valueReceived) : 0;
        var valueTotalInvoice = parseFloat($scope.data_factura_encabezado['totalConRetencion']);
        if (received < valueTotalInvoice || (received == "" || received == null)) {
            total = 0;
        } else {
            total = (received - parseFloat(valueTotalInvoice).toFixed($managerRound));
        }
        $scope.data_factura_encabezado["cambio"] = total;
        $scope.data_factura_encabezado["receivedView"] = this.getValueCustomer(total);
        $scope.validateStatePaymentsSalesBuys();

    };
    $scope.resetValuesCustomerReceived = function () {
        $scope.data_factura_encabezado.valueReceived = 0;
        $scope.data_factura_encabezado.receivedView = 0;
    }

    $scope._paymentBreakdownType = function (data) {
        this.resetValuesCustomerReceived();
        if (data) {//normal
            $scope.toogleElementsConfigView["show_efectivo_tarjeta"] = true;
            $scope.gridInvoiceConfigPayments.data = [];
            $scope.data_factura_encabezado_pagos = {'diferencia': '0.00', total: '0.00'};
        } else {//mixto
            $scope.resetPayment();
            $scope.toogleElementsConfigView["show_efectivo_tarjeta"] = true;
            $scope.gridInvoiceConfigPayments.data = [];
            $scope.data_factura_encabezado_pagos = {
                'diferencia': $scope.data_factura_encabezado['totalConRetencion'],
                total: '0.00'
            };
            $scope.data_factura_encabezado["diferencia"] = $scope.data_factura_encabezado['totalConRetencion'];
        }
        $scope.viewOptionsBtnsElements();
        $scope.validateStatePaymentsSalesBuys();

    };
    $scope.savePending = function () {
        $scope.toogleElementsConfigView["cobro_directo_pendiente"] = true;
        $scope.data_factura_encabezado_pagos = {
            'diferencia': $scope.data_factura_encabezado['valor_factura'],
            total: '0.00'
        };
        $scope.data_factura_encabezado["pendiente"] = "t";
        $scope.saveInvoice();
    }


    var gestion_view = {object_gestion: $("#documento-guias-remision"), view_object: false};
    viewInformacion(gestion_view);
    $scope.saveInvoice = function (typeSaveButton) {
        if (typeSaveButton) {
            $scope.toogleElementsConfigView["cobro_directo_pendiente"] = false;
        }
        $scope.data_factura_encabezado["fecha_factura_save"] = moment($scope.data_factura_encabezado["fecha_factura"]).format("YYYY-MM-DD") + " 00:00:00";
        $scope.data_factura_encabezado["tipo_factura"] = {text: "Factura", id: 1};
        $scope.data_factura_encabezado["TipoComprobante"] = {text: "Factura", id: 14};//gestion_sustento_has_comprobante_id
        $scope.data_factura_encabezado["no_autorizacion"] = $scope.authorizationSettingInvoiceCode;
        $scope.data_retenciones["fecha_factura_save"] = moment($scope.data_factura_encabezado["fecha_factura"]).format("YYYY-MM-DD") + " 00:00:00";
        $scope.data_retenciones["establecimiento"] = entidad_id;


        var deuda = 0;
//        -------------INIT GESTION D DEUDAS---
        var now_after_retencion = 1;
        var pago_mixto = 1;
        var has_retencion = 1;
//        1=PAGO REALIZADO CORRECTAMENTE EN UN SOLO PAGO
//0=PAGO REALIZADO DETALLADO CORRECTAMENTEEN VARIOS PAGOS
        if ($scope.toogleElementsConfigView.show_directo_mixto) {//NORMAL
            pago_mixto = 1;
        } else {//MIXTO
            pago_mixto = 0;
        }
//        1= RETENCION AL DIA LEGAL PARA L LIBRO DIARIO
//0= RETENCION NO REALIZADA A LO LEGAL LUEGO DE VARIOS DIAS TOCARA EDITAR
        if ($scope.data_factura_encabezado.retencion) {//existe retencion
            now_after_retencion = 1;
            has_retencion = 1;
        } else {//no hay retencion
            now_after_retencion = 0;
            has_retencion = 0;
        }

//--------------DEUDA---
//--------------RETENCIONES---
////     --------------------   NORMAL
//--------------1--- Deuda
//cobro_directo_pendiente=Al presionar el boton Pendiente
        if (has_retencion == 1 && pago_mixto == 1 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == true) {//prsion boton pendiente
            deuda = 1;
        }
//--------------2--- Sin Deuda
        if (has_retencion == 1 && pago_mixto == 1 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false) {//presion boton pagar
            deuda = 0;
        }
//     --------------------   MIXTA
//     $scope.toogleElementsConfigView["cobro_directo_pendiente"]==siempre ser falso cuando es mixto
        var saldo_pagar = $scope.getValueCustomer($scope.data_factura_encabezado.diferencia);
        var saldo_pagar_bool = false;
        if (saldo_pagar == 0) {//no hay deuda
            saldo_pagar_bool = false;
        } else if (saldo_pagar > 0) {//hay deuda
            saldo_pagar_bool = true;
        }
//--------------3--- Deuda
        if (has_retencion == 1 && pago_mixto == 0 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false && saldo_pagar_bool == true) {
            deuda = 1;
        }
//        -----4 ---Sin Deuda
        if (has_retencion == 1 && pago_mixto == 0 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false && saldo_pagar_bool == false) {
            deuda = 0;
        }
//--------------Sin RETENCIONES---
////     --------------------   NORMAL
//--------------1--- Deuda
//cobro_directo_pendiente=Al presionar el boton Pendiente
        if (has_retencion == 0 && pago_mixto == 1 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == true) {//prsion boton pendiente
            deuda = 1;
        }
//--------------2--- Sin Deuda
        if (has_retencion == 0 && pago_mixto == 1 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false) {//presion boton pagar
            deuda = 0;
        }
//     --------------------   MIXTA
//     $scope.toogleElementsConfigView["cobro_directo_pendiente"]==siempre ser falso cuando es mixto
        var saldo_pagar = parseFloat($scope.data_factura_encabezado.diferencia);
        var saldo_pagar_bool = false;
        if (saldo_pagar == 0) {//no hay deuda
            saldo_pagar_bool = false;
        } else if (saldo_pagar > 0) {//hay deuda
            saldo_pagar_bool = true;
        }
//--------------3--- Deuda
        if (has_retencion == 0 && pago_mixto == 0 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false && saldo_pagar_bool == true) {
            deuda = 1;
        }
//        -----4 ---Sin Deuda
        if (has_retencion == 0 && pago_mixto == 0 && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false && saldo_pagar_bool == false) {
            deuda = 0;
        }
//        -------------END GESTION D DEUDAS---

        var wayToPay = "card";
        if ($scope.toogleElementsConfigView["show_efectivo_tarjeta"] == false) {//TARJETA
            $scope.data_factura_encabezado["por_tarjeta"] = "si";
            $scope.data_factura_encabezado["diferencia"] = "0";
            $scope.data_factura_encabezado["pendiente"] = "f";
            wayToPay = "card";
        } else {
            $scope.data_factura_encabezado["por_tarjeta"] = "no";
            wayToPay = "cash";
        }
//        ---EFECTIVO                                                                 -----DIRECTO
        if ($scope.toogleElementsConfigView["show_efectivo_tarjeta"] == true && $scope.toogleElementsConfigView["cobro_directo_pendiente"] == false) {
            $scope.data_factura_encabezado["pendiente"] = "f";
            if ($scope.gridInvoiceConfigPayments.hasOwnProperty('data') && $scope.gridInvoiceConfigPayments.data.length == 0) {//PAGOS DE DIFERENTES
                $scope.data_factura_encabezado["diferencia"] = "0";
            } else {

            }
        }
        var reload = false;
        $scope.gridInvoiceOpts.data["entidad_id"] = entidad_id;
        $scope.data_factura_encabezado.pago_mixto = pago_mixto;
        $scope.data_factura_encabezado.now_after_retencion = now_after_retencion;
        $scope.data_factura_encabezado.has_retencion = has_retencion;
        $scope.data_factura_encabezado.deuda = deuda;
        if (deuda) {
            if ($scope.data_factura_encabezado["pendiente"] == "t" && has_retencion) {
                var resultInvoice = $scope.data_factura_encabezado["valor_factura"] - $scope.data_retenciones["Valor_retencion"];

                $scope.data_factura_encabezado["valor_factura"] = resultInvoice.toFixed($managerRound);
            }
        }


        var dataManager = {
            allow_cash_and_banks: $scope.allow_cash_and_banks,
            data_factura_encabezado: $scope.data_factura_encabezado,
            data_factura_detalle: $scope.gridInvoiceOpts.data,
            data_factura_encabezado_pagos: $scope.data_factura_encabezado_pagos,
            data_factura_detalle_pagos: $scope.gridInvoiceConfigPayments.data,
            data_retenciones: $scope.data_retenciones,
            data_retenciones_detalle: $scope.gridInvoiceOptsRetenciones.data,
            configPayment: {
                hasIndebtedness: deuda ? true : false,
                hasRetention: has_retencion ? true : false,
                mixed: pago_mixto ? true : false,
                wayToPay: wayToPay
            },
            'CashManagementCurrent': $CashManagementCurrent['data']
        };
        var url_gestion = $('#action-invoice-sales-saveInvoicePointOfSales').val();
        var print_valid = false;
        var params_gestion = {
            async: true,
            url: url_gestion, //accion dond vamos a realizar la gestion
            data: dataManager, //paramatros para realizar l proceso
            beforeCall: function () {//funcion antes d ejecutarse el procesos
                //ocultar ,bloquear botones,etc
                //          ----ocultar l contenedor main---
                var gestion_view = {object_gestion: $("#print-data"), view_object: false};
                viewInformacion(gestion_view);
//            ---MOSTRAR EL LOADING---
                var gestion_view = {object_gestion: $("#loading-content"), view_object: true};
                viewInformacion(gestion_view);
            },
            successCall: function (data) {
                if (data.success) {
//                    ---PARA EL GUARDADO DE INFORMACION OBTENER VALORES
                    $scope.saveFacturaData = {};
                    $scope.saveFacturaData = data;
                    //                    ----MOSTRAR LOS BOTONES
                    var gestion_view = {object_gestion: $("#btn-gestion"), view_object: true};
                    viewInformacion(gestion_view);
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: "Realizado Correctamente."
                    };
                    msjSystem($params);
                    $scope.data_retenciones.no_comprobante = data["id_factura"];
                    $scope.data_retenciones.valor_factura = $scope.data_factura_encabezado["valor_factura"];
                    $scope.data_retenciones.subtotal = $scope.data_factura_encabezado["subtotal_encabezado"];
                    $scope.cobro_directo_pendiente = false;
                    $scope.toogleElementsConfigView["show_retenenciones"] = true;
                    $scope.processInvoiceValidation["invoiceSave_btn"] = true;
                    //            ---ocultar EL LOADING---
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                    viewInformacion(gestion_view);
                    //          ----ocultar l contenedor main---
                    var gestion_view = {object_gestion: $("#print-data"), view_object: true};
                    viewInformacion(gestion_view);
                    $scope.toogleElementsConfigView["id_factura"] = data["id_factura"];
                    //reseteo save
                    $scope.$apply(function () {
                        $scope.processInvoiceValidation['managerSaveAllow'] = true;
                        $scope.processInvoiceValidation['invoiceSave'] = true;
//                        ----add OCULTAR GESTION DE FACTURA---
                        var gestion_view = {
                            object_gestion: $("#content-gestion-procesos-facturas"),
                            view_object: false
                        };
                        viewInformacion(gestion_view);
                        //                        ----add MOSTRAR PAR IMPRIMIR---
                        var gestion_view = {object_gestion: $("#manager-print"), view_object: true};
                        viewInformacion(gestion_view);
                        $scope.getFacturaEstructura(data);
                        print_valid = true;
                    });
                    if (reload) {
                        location.reload();
                    }
                } else {
                    var response = data;
                    var $params = {
                        title: "Registro. ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: response.msj
                    };
                    msjSystem($params);
                    var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                    viewInformacion(gestion_view);
                    //          ----ocultar l contenedor main---
                    var gestion_view = {object_gestion: $("#print-data"), view_object: true};
                    viewInformacion(gestion_view);
                    $scope.processInvoiceValidation["invoiceSave"] = false;
                    $scope.$apply(function () {
                        $scope.processInvoiceValidation['managerSaveAllow'] = true;
                        $scope.processInvoiceValidation['invoiceSave'] = true;
                    });
                    if (reload) {
                        location.reload();
                    }
                }


                if (print_valid) {
                    $scope.printData();
                }
            },
            errorCall: function (data) {
                var statusText = data.statusText;
                var status = data.status;
                //            ---ocultar EL LOADING---
                var gestion_view = {object_gestion: $("#loading-content"), view_object: false};
                viewInformacion(gestion_view);
                //          ----ocultar l contenedor main---
                var gestion_view = {object_gestion: $("#print-data"), view_object: true};
                viewInformacion(gestion_view);
                var $params = {title: "Registro. ", color: "#e7493b", icon: "fa fa-info", content: statusText};
                msjSystem($params);
                $scope.processInvoiceValidation["invoiceSave"] = false;
                if (reload) {
                    location.reload();
                }
            },
        };
        gestionInformacion(params_gestion);
    };
    $scope.CancelGuiasRemision = function () {

        var gestion_view = {object_gestion: $("#documento-guias-remision"), view_object: false};
        viewInformacion(gestion_view);
        var gestion_view = {object_gestion: $("#print-data"), view_object: true};
        viewInformacion(gestion_view);
        $scope.printData();
    }


    $scope.motivos_traslado_validation = {value: ""};
    var contadorCheckMotivos = 0;
    $scope.changeMotivosTraslado = function (bool) {
        if (bool == true) {
            contadorCheckMotivos = parseInt(contadorCheckMotivos) + 1
            $scope.motivos_traslado_validation["value"] = contadorCheckMotivos;
        } else {
            contadorCheckMotivos = parseInt(contadorCheckMotivos) - 1;
            if (contadorCheckMotivos == 0) {
                $scope.motivos_traslado_validation["value"] = "";
            } else {
                $scope.motivos_traslado_validation["value"] = contadorCheckMotivos;
            }
        }
    }
    $scope.total_renta = 0;
    $scope.total_iva = 0;

    $scope.resetS2 = function () {
        $scope.data_retenciones.TipoRetencion = null;
        $scope.data_retenciones.SubTipoRetencion = null;
    }
    $scope.CancelRetencion = function () {
        if ($scope.data_options_pagos["guias"] == true) {
            var gestion_view = {object_gestion: $("#document-renteciones"), view_object: false};
            viewInformacion(gestion_view);
            var gestion_view = {object_gestion: $("#documento-guias-remision"), view_object: true};
            viewInformacion(gestion_view);
        } else {
            var gestion_view = {object_gestion: $("#document-renteciones"), view_object: false};
            viewInformacion(gestion_view);
            var gestion_view = {object_gestion: $("#print-data"), view_object: true};
            viewInformacion(gestion_view);
        }

    }

//    CHANGE


    //-----FIN DE METODO DE RETENCIONES---------------
//                    ----new print---

//  -----------NEW ADD--
    //    ----VERIFICA SI EXISTE AQL PRODUCTO YA ESTA AGREGADO AL DETALLE
    $scope.changeRetencion = function (bool) {
        $scope.data_factura_encabezado["retencion"] = bool;


    }
//----------ADD NEW ---
//VERIFICA SI ESTA FACTURA EXISTE EN LOS REGISTROS CON LOS VALORES
//Codigo factura,Punto de Emision,Establecimiento, y si existe no permitir la gestion
    $scope.initInvoiceValid = false;
    $scope.checkInvoice = function () {
        allow_factura_save = true;
        $scope.setResultData();
//gestion_data_frm.codigo_factura,punto_emision,establecimiento
        if ($scope.data_factura_encabezado.codigo_factura && $scope.data_factura_encabezado.punto_emision && $scope.data_factura_encabezado.establecimiento) {
            var dataManager = {
                entidad_data_id: entidad_id,
                codigo_factura: $scope.data_factura_encabezado.codigo_factura,
                punto_emision: $scope.data_factura_encabezado.punto_emision,
                establecimiento: $scope.data_factura_encabezado.establecimiento,
            };
            var url_gestion = $('#action-invoice-sales-getValidateInvoiceExistPointOfSales').val();
            $http({
                method: 'POST',
                url: baseUrl + url_gestion,
                params: dataManager,
                statusText: "json"
            }).then(function successCallback(response) {
                allow_factura_save = response.data.success;

                $scope.initInvoiceValid = true;
                if (allow_factura_save) {
                    var $params = {title: "Factura ", color: "#e7493b", icon: "fa fa-info", content: "Ya Gestionada"};
                    msjSystem($params);
                }
                $scope.setResultData();
                // this callback will be called asynchronously
                // when the response is available
            }, function errorCallback(response) {
                allow_factura_save = true;
                $scope.setResultData();
            });

        }


    }
    $scope.verificarGestion = function () {
//$scope.gestion_data_frm.$valid
    }
    $scope.getId = function (row, type) {
        var id_element = "";
        if (type == 1) {//row accordion: amount
            id_element = "amount-data-" + row.entity.id;
        }

        return id_element;
    }
//    ---FUNCTIONS NEWS GRID-
    $scope.selectDataAmountEvent = function (row) {
        var element_id = "#amount-data-" + row.entity.id;
        $(element_id).select();
    }
//-------set values subproceso--
    $scope.resetSubprocesosValues();


    //    ---------------ADD NEW---
//Gestion de Add Productos
    $scope.addProductoServicio = function () {
        if ($scope.typeProduct) {
            var color = "#dfb56c";
            var title = "Informativo";
            var icon = "fa fa-info";
            var content = "No se ha registrado ";
            if (Object.keys($iva_configuracion_data).length == 0 || Object.keys($iva_configuracion_data_0).length == 0) {
                var exist_alguno = false;
                if (Object.keys($iva_configuracion_data).length == 0) {
                    content += "Iva Configurado";
                    exist_alguno = true;
                }
                if (Object.keys($iva_configuracion_data_0).length == 0) {
                    if (exist_alguno) {
                        content += ",Iva con Tarifa 0.";
                    } else {
                        content += "Iva con Tarifa 0.";
                    }
                }
                var $params = {
                    title: title
                    , color: color
                    , icon: icon,
                    content: content
                };
                msjSystem($params);
            } else {

                var url_create = 'productos/producto/createProducto';
                var params = {
                    url: url_create,
                    type: "lg",
                    data: {
                        type: "sales",

                    }
                };
                getModalInformacion(params);
            }
        } else {
            var url_create = "productos/producto/createASS";
            var params = {
                url: url_create,
                type: "md",
            };
            getModalInformacion(params);
        }

    }
//------------GESTION PERFECT---
    var columnDefsView = [];
    columnDefsView = [
        {
            name: 'detalle',
            displayName: 'Detalle',
            enableCellEdit: false,
            width: '45%',
        },
        {
            name: 'cantidad',
            displayName: 'Cantidad',
            enableCellEdit: false,
            enableCellEditOnFocus: false,
            width: '15%',
            type: 'number',
        },
        {
            name: 'precio_unitario',
            displayName: 'P.Uni',
            enableCellEdit: false,
            width: '20%',
        },
        {
            field: 'subtotal',
            name: 'Subtotal',
            displayName: 'Subtotal',
            cellTemplate: '<div><label  class="lbl-data {{grid.appScope.getClassLabelSubtotal(row)}}"><span class="data-span {{grid.appScope.getClassRow(row)}}">{{row.entity.subtotal_sin_descuento}}</span><br><span class="descuento-data" >{{grid.appScope.getRowDataDescuento(row)}}</span></label></div>',

            enableCellEdit: false,
            enableCellEditOnFocus: false,
            width: '20%'
        },
    ];
    $scope.gridInvoiceOptsView = {
        enableSorting: false,
        enableFiltering: false,
//        --expander config--
        enableExpandableRowHeader: false,
        enableHorizontalScrollbar: uiGridConstants.scrollbars.NEVER,
        columnDefs: columnDefsView,
        data: $scope.gridInvoiceOpts.data,
        onRegisterApi: function (gridApi) {

        },
    };

    $scope.viewOptionsBtnsElements = function (end_process) {
        if (typeof (end_process) == "undefined") {
            console.log("viewOptionsBtnsElements not finish");
//{case: null, info_name: ""}
            var case_x = $scope.getTypeCaseGestion().case;
            switch (case_x) {
                case  1://SR-NORMAL-(2FPago-Efectivo):Pagar
                    $scope.toogleElementsConfigView["show_efectivo_tarjeta"] = true;
                    $("#grid-dataView").show();
                    $("#btn-factura-gestion-save").show();
                    $("#btn-factura-pendiente-gestion").show();
                    $("#content-2fpago").show();
//                    ---procesos not view---
                    $("#content-gestion-proceso-retenciones").hide();


                    break;
                case  2://SR-NORMAL-(2FPago-Tarjeta):Pagar
                    $scope.toogleElementsConfigView["show_efectivo_tarjeta"] = false;
                    $("#grid-dataView").show();
                    $("#btn-factura-gestion-save").show();
                    $("#content-2fpago").show();
                    //                    ---procesos not view---
                    $("#content-gestion-proceso-retenciones").hide();
                    $("#btn-factura-pendiente-gestion").hide();

                    break;
                case  3://SR-NORMAL-(2FPago-Efectivo):Pendiente
                    break;
                case  4://CR-Normal-(2Fpago-Efectivo):Pagar
                    $("#content-2fpago").show();
                    $("#content-gestion-proceso-retenciones").show();
                    $("#btn-factura-pendiente-gestion").show();
                    $("#btn-factura-gestion-save").show();
                    //                    ---procesos not view---
                    $("#grid-dataView").hide();


                    break;
                case  5://CR-Normal-(2Fpago-Tarjeta):Pagar
                    $("#content-2fpago").show();
                    $("#content-gestion-proceso-retenciones").show();
                    $("#btn-factura-gestion-save").show();
                    //                    ---procesos not view---
                    $("#grid-dataView").hide();
                    $("#btn-factura-pendiente-gestion").hide();

                    break;
                case  6://CR-Normal-2Fpago-Efectivo:Pendiente
                    break;
                case  7://SR-Mixto-(VariasformasdePago):Pagar

                    $("#btn-factura-gestion-save").show();
                    //                    ---procesos not view---
                    $("#grid-dataView").hide();
                    $("#content-2fpago").hide();
                    $("#btn-factura-pendiente-gestion").hide();
                    $("#content-gestion-proceso-retenciones").hide();

                    break;
                case  8://CR-Mixto-(VariasformasdePago):Pagar


                    $("#btn-factura-gestion-save").show();
                    $("#content-gestion-proceso-retenciones").show();
                    //                    ---procesos not view---
                    $("#grid-dataView").hide();
                    $("#content-2fpago").hide();
                    $("#btn-factura-pendiente-gestion").hide();
                    break;
                case  null:
                    break;
            }

        } else {
            console.log(" viewOptionsBtnsElements finish");

        }
    }
    $scope.getTypeCaseGestion = function () {
        var result = {case: null, info_name: ""};
        //SR-NORMAL-(2FPago-Efectivo):Pagar
        if ($scope.data_factura_encabezado.retencion == false && $scope.toogleElementsConfigView.show_directo_mixto && $scope.toogleElementsConfigView.show_efectivo_tarjeta) {
            result = {case: 1, info_name: "SR-NORMAL-(2FPago-Efectivo):Pagar"};
        }
//SR-NORMAL-(2FPago-Tarjeta):Pagar
        else if ($scope.data_factura_encabezado.retencion == false && $scope.toogleElementsConfigView.show_directo_mixto && $scope.toogleElementsConfigView.show_efectivo_tarjeta == false) {
            result = {case: 2, info_name: "SR-NORMAL-(2FPago-Tarjeta):Pagar"};

        }
//SR-NORMAL-(2FPago-Efectivo):Pendiente
//        else if ($scope.data_factura_encabezado.retencion == false && $scope.toogleElementsConfigView.show_directo_mixto && $scope.toogleElementsConfigView.show_efectivo_tarjeta) {
//            result = 3;

//        }
//CR-Normal-(2Fpago-Efectivo):Pagar
        else if ($scope.data_factura_encabezado.retencion && $scope.toogleElementsConfigView.show_directo_mixto && $scope.toogleElementsConfigView.show_efectivo_tarjeta) {
            result = {case: 4, info_name: "CR-Normal-(2Fpago-Efectivo):Pagar"};

        }
//CR-Normal-(2Fpago-Tarjeta):Pagar
        else if ($scope.data_factura_encabezado.retencion && $scope.toogleElementsConfigView.show_directo_mixto && $scope.toogleElementsConfigView.show_efectivo_tarjeta == false) {
            result = {case: 5, info_name: "CR-Normal-(2Fpago-Tarjeta):Pagar"};

        }
//CR-Normal-2Fpago-Efectivo:Pendiente
//        else if ($scope.data_factura_encabezado.retencion && $scope.toogleElementsConfigView.show_directo_mixto && $scope.toogleElementsConfigView.show_efectivo_tarjeta ) {
//            result = 6;
//        }
//SR-Mixto-(VariasformasdePago):Pagar
//resultado_options_alter=$scope.toogleElementsConfigView.show_efectivo_tarjeta = true,
        else if ($scope.data_factura_encabezado.retencion == false && $scope.toogleElementsConfigView.show_directo_mixto == false) {
            result = {case: 7, info_name: "SR-Mixto-(VariasformasdePago):Pagar"};

        }
//CR-Mixto-(VariasformasdePago):Pagar
        else if ($scope.data_factura_encabezado.retencion && $scope.toogleElementsConfigView.show_directo_mixto == false) {
            result = {case: 8, info_name: "CR-Mixto-(VariasformasdePago):Pagar"};

        }

        return result;
    }
    UtilAdmin($scope);
    UtilHotKey($scope);


});



$(function () {
    managerLoading();
});

/*
----MANAGER DOCUMENTS ---*/
function managerAuthorizationSettings($scope) {
    $scope.authorizationSettingInvoiceCode = "";
    $scope.managerAutorizationSettingsData = $managerResultsProcess['managerStepsConfig']['processCurrent']['data'];
    $scope.managerInvoiceHeader = {
        'invoice_code': {
            view: true,
            value: ""
        },
        'point_of_emission': {
            view: true,
            value: ""
        },
        'establishment_number': {
            view: true,
            value: "",
            'disabled': false
        },
        'authorizationSettingInvoiceTrafficLight': {
            view: false,
            value: 0,
            label: 'Autorizacion por expirar en'

        },

        'pointEstablishment': {
            view: true,
            value: "",
            'disabled': false
        },
    };
    $scope.allowViewManagement = {
        'allow': false,
        'msg': '',
        'type': null
    };
    $scope.managerInvoiceConfigOk = function () {
        var msg = [];
        if (Object.keys($scope.managerAutorizationSettingsData).length) {
            $scope.data_factura_encabezado.establecimiento = $scope.managerAutorizationSettingsData['establishment_number'];
            $scope.authorizationSettingInvoiceCode = $scope.managerAutorizationSettingsData['value'];
            var invoice_code_view = true;
            var punto_emision = '-1';
            if ($managementCash.hasOwnProperty('cashCurrentUser') && $managementCash['cashCurrentUser'] != null) {
                punto_emision = ($managementCash['cashCurrentUser'].hasOwnProperty('business_by_cash_id') ? $managementCash['cashCurrentUser']['business_by_cash_id'] : '-11');
            }

            if (punto_emision == '-11' || punto_emision == '-1') {
                $scope.allowViewManagement.allow = false;
                msg.push('Error de punto de emision cashCurrentUser-001 ');
            } else {
                $scope.allowViewManagement.allow = true;

            }
            if ($procesos_all["VENTAS_INVENTARIO"]["establecimiento"] == false) {
                $scope.data_factura_encabezado.establecimiento = '001';
                $scope.data_factura_encabezado.codigo_factura = '';
            }
            var caseCode = $scope.managerAutorizationSettingsData['allow_authorization_code'] + $scope.managerAutorizationSettingsData['type_of_document_issuance'] + $scope.managerAutorizationSettingsData['type_process'];
            var caseCurrent = $scope.managerAutorizationSettingsData['case'];

            switch (caseCode) {
                case "100":

                    //1.1
                    //1.3
                    if (caseCurrent == '1.3') {
                        var diffDates = $scope.managerAutorizationSettingsData['diffDates'];
                        var resultConfig = $scope.getTimeLimitDocumentConfig({diffDates: diffDates});
                        $scope.managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['view'] = resultConfig['view'];
                        $scope.managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['value'] = resultConfig['infoTime'];
                    }
                    break;
                case "101":
                    //2.1
                    //2.3
                    invoice_code_view = false;
                    $scope.data_factura_encabezado.codigo_factura = '1';
                    var diffDates = $scope.managerAutorizationSettingsData['diffDates'];
                    if (caseCurrent == '2.3') {
                        var resultConfig = $scope.getTimeLimitDocumentConfig({diffDates: diffDates});
                        $scope.managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['view'] = resultConfig['view'];
                        $scope.managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['value'] = resultConfig['infoTime'];
                    }
                    console.log(101);
                    break;
                case "111":
                    //case 3
                    console.log(111);
                    invoice_code_view = false;
                    $scope.data_factura_encabezado.codigo_factura = '1';
                    break;
                case "000":
                    //case 6
                    console.log("000");

                    break;
                case "001":
                    //case 5
                    console.log("001");
                    invoice_code_view = false;

                    break;


            }

            $scope.data_factura_encabezado.establecimiento = pad($scope.managerAutorizationSettingsData['establishment_number'], 3);
            $scope.managerInvoiceHeader['establishment_number']['disabled'] = true;
            $scope.managerInvoiceHeader['invoice_code']['view'] = invoice_code_view;
            $scope.data_factura_encabezado.punto_emision = pad(punto_emision, 3);
            $scope.allowViewManagement.msg = msg.join('');
        } else {

            if (!$managerResultsProcess ['success']) {
                $scope.allowViewManagement.allow = false;
                var typeError = $managerResultsProcess ['typeError'];
                if (typeError == 'admin') {
                    msg.push($managerResultsProcess ['error']);

                } else {
                    msg.push('Manager not config AutorizationSettingsData ');
                    $scope.data_factura_encabezado.punto_emision = '';
                }
                $scope.allowViewManagement.msg = msg.join('');
            } else {
                $scope.allowViewManagement.allow = false;

                if ($managerResultsProcess ['typeError'] == "notCashAndBank") {
                    $scope.allowViewManagement.allow = true;

                    $scope.allowViewManagement.msg = msg.join('');
                }

            }


        }


    }
    $scope.getTimeLimitDocumentConfig = function (params) {
        var diffDates = params['diffDates'];
        var days = diffDates['days'];
        var view = false;
        var infoTime = '';
        if (days > 0 && days < 20) {
            view = true;
            infoTime = days > 1 ? days + ' dias.' : days + ' dia.';
        } else if (days == 0) {
            infoTime = diffDates.h > 0 ? diffDates.h + ' Horas.' : diffDates.h + ' Hora.';
            view = true;
        }

        var result = {view: view, infoTime: infoTime};
        return result;
    }


}


/*ALL MANAGER INVOICES*/
function UtilPaymentsBuySale($scope) {

    $scope.initValidateByProcessPaymentsSalesBuys = function () {
        $scope.validateStatePaymentsSalesBuys();

    }
    $scope.getClassRowPaymentionErrors = function (rowEntity) {
        var result = "";
        var Valor = rowEntity.Valor;
        if (rowEntity.allow_cash_and_banks) {
            var processName = $scope.typeProcessMacro;
            if (processName == "buys") {
                var amount_current = rowEntity.amount_current;

                if (Valor > amount_current) {
                    result = "ui-grid-cell--error-value-payment";
                } else if (Valor == 0) {
                    result = "ui-grid-cell--warning-value-payment";

                } else if (Valor == undefined) {
                    result = "ui-grid-cell--warning-value-payment";
                }
            } else {
                if (Valor == 0) {
                    result = "ui-grid-cell--warning-value-payment";

                } else if (Valor == undefined) {
                    result = "ui-grid-cell--warning-value-payment";
                }
            }

        } else {
            if (Valor == 0) {
                result = "ui-grid-cell--warning-value-payment";
            } else if (Valor == undefined) {
                result = "ui-grid-cell--warning-value-payment";
            }
        }


        return result;
    };
    $scope.getClassRowPaymentionStructure = function (rowEntity) {
        var result = "";

        if (rowEntity.type_payment == 0) {
            result = "cell-cash";
        } else if (rowEntity.type_payment == 1) {
            result = "cell-bank";
        } else if (rowEntity.type_payment == 2) {
            result = "cell-credit-card";
        }else if (rowEntity.type_payment == 3) {
            result = "cell-credit-card-pay-phone";
        }
        return result;
    };
    var columnsConfigPayments = [

        {
            name: 'Detalle', enableCellEdit: false
            , width: '78%',
            cellTemplate: [
                '<div>',
                "<table class='tbl-details-payments' ng-if='row.entity.type_payment==0'>",
                "<tr><td> <span class='tbl-details-payments__title'> Tipo de Pago :</span><span class='tbl-details-payments__value'>{{row.entity.Tipo_pago}} </span></td></tr> ",
                "<tr><td> <span class='tbl-details-payments__title'> Cuenta Contable :</span><span class='tbl-details-payments__value'> {{row.entity.Cuenta}}</span></td></tr> ",
                "</table>",
                "<table class='tbl-details-payments' ng-if='row.entity.type_payment==1'>",
                "<tr><td> <span class='tbl-details-payments__title'> Tipo de Pago :</span><span class='tbl-details-payments__value'>{{row.entity.Tipo_pago}} </span></td></tr> ",
                "<tr><td> <span class='tbl-details-payments__title'> Cuenta Contable :</span><span class='tbl-details-payments__value'> {{row.entity.Cuenta}}</span></td></tr> ",
                "<tr><td> <span class='tbl-details-payments__title'> Transacción :</span><span class='tbl-details-payments__value'>{{row.entity.transaction_text}} </span></td></tr> ",
                "<tr><td> <span class='tbl-details-payments__title'> # Documento :</span><span class='tbl-details-payments__value'> {{row.entity.document_number}}</span></td></tr> ",
                "<tr><td> <span class='tbl-details-payments__title'> Observaciones :</span><span class='tbl-details-payments__value'>{{row.entity.details}} </span></td></tr> ",
                "</table>",

                "<table class='tbl-details-payments' ng-if='row.entity.type_payment==2'>",
                "<tr><td> <span class='tbl-details-payments__title'> Tipo de Pago :</span><span class='tbl-details-payments__value'>{{row.entity.Tipo_pago}} </span></td></tr> ",
                "<tr><td> <span class='tbl-details-payments__title'> Cuenta Contable :</span><span class='tbl-details-payments__value'> {{row.entity.Cuenta}}</span></td></tr> ",
                "</table>",
                "</div>",

            ].join(""),
            cellClass: function (grid, row, col, rowRenderIndex, colRenderIndex) {

                return $scope.getClassRowPaymentionStructure(row.entity);
            }
        },
        {
            name: 'Valor', enableCellEdit: true, enableCellEditOnFocus: true
            , width: '19%',
            type: 'number', //change data
            editableCellTemplate: "<div  class='div-input-data-valor'><form name=\"inputForm\"><input class ='form-controll input-data-valor' type=\"INPUT_TYPE\" ng-class=\"'input-data-valor' + col.uid\" ui-grid-editor ng-model=\"MODEL_COL_FIELD\"   ></form></div>",
            cellClass: function (grid, row, col, rowRenderIndex, colRenderIndex) {
                return $scope.getClassRowPaymentionStructure(row.entity) + " " + $scope.getClassRowPaymentionErrors(row.entity);
            }
        },
        {
            name: ' ',
            width: '2%',
            cellTemplate: '<button  data-toggle="tooltip" data-placement="top" title="Eliminar" type="button"  class="delete-data delete-data--pagos far fa-trash-alt" ng-click="grid.appScope._deleteRowPagos(row)"></button>',
            cellClass: function (grid, row, col, rowRenderIndex, colRenderIndex) {

                return $scope.getClassRowPaymentionStructure(row.entity);
            }
        }
    ];
    $scope.validateRowPayments = function (params) {
        var colDef = params.colDef;
        var oldValue = params.oldValue;
        var newValue = params.newValue;
        var rowEntity = params.rowEntity;
        var subtotal = 0;
        var totalManager = $scope.getResultFormatValue($scope.data_factura_encabezado['totalConRetencion']);
        if (colDef.name == "Valor") {
            if (!newValue || newValue < 0) {//null
                rowEntity["Valor"] = oldValue;
            } else {
                rowEntity["Valor"] = newValue;
            }
        }
        if (rowEntity.allow_cash_and_banks) {


        } else {


        }
        angular.forEach($scope.gridInvoiceConfigPayments.data, function (value, key) {
            var rowValue = 0;
            var value_type = jQuery.type(value["Valor"]);
            if (value_type != "undefined") {
                rowValue = parseFloat(value["Valor"]);
            }
            subtotal = parseFloat(subtotal) + rowValue;
        });
        subtotal = $scope.getResultFormatValue(subtotal);
        var validateValue = subtotal > totalManager || subtotal == 0;
        if (validateValue) {
            var $params = {
                title: "Registro. ",
                color: "#e7493b",
                icon: "fa fa-info",
                content: "El monto ingreso es mayor a la cantidad a pagar."
            };
            if (subtotal == 0) {
                $params["content"] = "Algunos Valores no se han ingresado correctamente.";
                $params["title"] = "Registros.";

            }

            msjSystem($params);
            $scope.opciones_factura['validate_gestion'] = true;
            $scope.processInvoiceValidation['managerSaveAllow'] = $scope.opciones_factura['validate_gestion'];
        } else {
            $scope.data_factura_encabezado_pagos["total"] = subtotal.toFixed($managerRound);
            var resultManager = (parseFloat($scope.data_factura_encabezado['totalConRetencion']) - parseFloat(subtotal)).toFixed($managerRound);
            $scope.data_factura_encabezado["diferencia"] = resultManager;
        }
        $scope.initValidateByProcessPaymentsSalesBuys();
    };
    $scope.gridInvoiceConfigPayments = {
        columnDefs: columnsConfigPayments,
        enableHorizontalScrollbar: true,
        enableVerticalScrollbar: false,

        onRegisterApi: function (gridApi) {
            $scope.gridApi = gridApi;
            gridObjPayment = gridApi;

            gridApi.edit.on.afterCellEdit($scope, function (rowEntity, colDef, newValue, oldValue) {
                $scope.validateRowPayments({
                    rowEntity: rowEntity, colDef: colDef, newValue: newValue, oldValue: oldValue
                })
            });

        },
    };
    $scope.getViewTransactionPaymentsForms = function (typePaymentModel) {
        var result = -1;
        if ($scope.allow_cash_and_banks) {
            if (typePaymentModel) {
                result = typePaymentModel.type_payment;
            }
        }
        return result;

    };

    $scope.getAllowAddTransactionPayments = function (typePaymentModel) {

        var result = true;

        if (typePaymentModel) {
            if (typePaymentModel.type_payment == 0) {//cash

            } else if (typePaymentModel.type_payment == 1) {//banks
                if ($scope.data_entidad.transaction_type == null || $scope.data_entidad.document_number == null || $scope.data_entidad.details == null) {
                    result = false;
                }

            } else if (typePaymentModel.type_payment == 2) {//credit

            }
        }
        return result;
    };
    $scope._addValuesPayments = function (typePaymentModel) {

        if (typePaymentModel) {
            if (typePaymentModel.type_payment == 0) {//cash
                $scope.movementData.details = "cash";

            } else if (typePaymentModel.type_payment == 1) {//banks

                $scope.movementData.details = $scope.data_entidad.details;
                $scope.movementData.transaction = $scope.data_entidad.transaction_type;
                $scope.movementData.document_number = $scope.data_entidad.document_number;
                $scope.movementData.transaction_text = $('#transaction-options option:selected').text();

            } else if (typePaymentModel.type_payment == 2) {//credit

            }

            $scope._addDataPayments();
        }
    };
    $scope.resetPayment = function () {
        $scope.data_entidad["cuentas"] = null;
        $scope.data_entidad.tipo_pagos = null;
        $scope.data_entidad.details = null;
        $scope.data_entidad.document_number = null;
        $scope.data_entidad.transaction_type = null;
    }

    $scope.accountsAddsBuysSales = [];
    $scope.searchStackBuysSales = function (params) {
        var haystack = params.haystack;
        var needle = params.needle;

        result = {success: false, data: []};
        angular.forEach(haystack, function (value, key) {
            if (value.id == needle.id && value.type_payment == needle.type_payment) {

                result = {success: true, data: {index: key, value: value}};
            }
        });

        return result;
    }
    $scope.resetStackBuysSalesTotal = function (params) {
        var haystack = params.haystack;
        angular.forEach(haystack, function (value, key) {
            haystack[key]["total"] = 0;
        });
        var result = haystack;
        return result;
    }
    $scope._addDataPayments = function () {
        var setPushData = {};
        var allowSet = false;
        var n = $scope.gridInvoiceConfigPayments.data.length + 1;

        if ($scope.data_entidad.tipo_pagos == null) {
            $scope.resetPayment();
        }

        if ($scope.allow_cash_and_banks) {
            if ($scope.data_entidad.tipo_pagos != null) {
                var type_payment = $scope.data_entidad.tipo_pagos["type_payment"];
                var accountData = $scope.data_entidad.cuentas;
                var movement_type = $scope.movementData.movement_type;
                var details = $scope.movementData.details;
                var rode = 0;
                var transaction_type = $scope.movementData.transaction_type;
                var entity_type = $scope.movementData.entity_type;

                var entity_id = 0;
                if ($scope.data_entidad.cuentas) {
                    var accountsData = $scope.data_entidad["cuentas"];
                    var amount_current = $scope.data_entidad["cuentas"].amount_current;
                    setPushData = {
                        "id": n,
                        "Tipo_pago": $scope.data_entidad["tipo_pagos"]["text"],
                        "Cuenta": $scope.data_entidad["cuentas"]["text"],
                        "Tipo_pago_save": $scope.data_entidad["tipo_pagos"]["id"],
                        "Cuenta_save": $scope.data_entidad["cuentas"]["id"],
                        "type_payment_id": $scope.data_entidad["tipo_pagos"]["id"],
                        type_payment: type_payment,
                        amount_current: $scope.data_entidad["cuentas"].amount_current,
                        allow_cash_and_banks: $scope.allow_cash_and_banks,
                    };
                    var setPushAccounts = {
                        id: accountsData.id,
                        type_payment: type_payment,
                        amount_current: amount_current,
                        total: 0
                    };
                    var searchNeedle = $scope.searchStackBuysSales({
                        haystack: $scope.accountsAddsBuysSales,
                        needle: setPushAccounts,

                    });
                    if (!searchNeedle.success) {
                        $scope.accountsAddsBuysSales.push(setPushAccounts);
                    }

                    if (type_payment == 0) {//cash

                        var cash_reason_id = $scope.movementData.cash_reason_id;
                        var cash_id = accountData["cash_id"];
                        var cash = accountData["cash"];
                        setPushData["movement_type"] = movement_type;
                        setPushData["cash_id"] = cash_id;
                        setPushData["cash"] = cash;
                        setPushData["cash_reason_id"] = cash_reason_id;
                        setPushData["details"] = details;
                        setPushData["rode"] = rode;
                        setPushData["transaction_type"] = transaction_type;
                        setPushData["entity_type"] = entity_type;
                        setPushData["entity_id"] = entity_id;
                        allowSet = true;
                        $scope.resetPayment();
                    } else if (type_payment == 1) {//bank

                        var bank_reason_id = $scope.movementData.bank_reason_id;

                        var bank_id = accountData["bank_id"];
                        var bank = accountData["bank"];
                        var document_number = $scope.movementData.document_number;
                        var transaction = $scope.movementData.transaction;
                        var transaction_text = $scope.movementData.transaction_text;
                        setPushData["movement_type"] = movement_type;
                        setPushData["bank_id"] = bank_id;
                        setPushData["bank"] = bank;
                        setPushData["bank_reason_id"] = bank_reason_id;
                        setPushData["details"] = details;
                        setPushData["rode"] = rode;
                        setPushData["transaction_type"] = transaction_type;
                        setPushData["entity_type"] = entity_type;
                        setPushData["entity_id"] = entity_id;
                        setPushData["document_number"] = document_number;
                        setPushData["transaction"] = transaction;
                        setPushData["transaction_text"] = transaction_text;
                        allowSet = true;
                        $scope.resetPayment();

                    } else if (type_payment == 2) {//credit card

                        var bank_id = accountData["bank_id"];
                        var bank = accountData["bank"];
                        movement_type = 0;
                        details = 'Pago con tarjeta de credito.';
                        transaction_type = 0;//know? Significado ?
                        var bank_reason_id = 4;//know? Significado ?
                        var document_number = '999999999';//know? Significado ?
                        var transaction = 4;//know? Significado ?
                        var transaction_text = details;
                        entity_type = 2;
                        setPushData["movement_type"] = movement_type;
                        setPushData["bank_id"] = bank_id;
                        setPushData["bank"] = bank;
                        setPushData["bank_reason_id"] = bank_reason_id;
                        setPushData["details"] = details;
                        setPushData["rode"] = rode;
                        setPushData["transaction_type"] = transaction_type;
                        setPushData["entity_type"] = entity_type;
                        setPushData["entity_id"] = entity_id;
                        setPushData["document_number"] = document_number;
                        setPushData["transaction"] = transaction;
                        setPushData["transaction_text"] = transaction_text;
                        allowSet = true;
                        $scope.resetPayment();

                    }

                }

            }
        } else {

            if ($scope.data_entidad.cuentas) {
                allowSet = true;
                setPushData = {
                    "id": n,
                    "Tipo_pago": $scope.data_entidad["tipo_pagos"]["text"],
                    "Cuenta": $scope.data_entidad["cuentas"]["text"],
                    "Tipo_pago_save": $scope.data_entidad["tipo_pagos"]["id"],
                    "Cuenta_save": $scope.data_entidad["cuentas"]["id"],
                    "type_payment_id": $scope.data_entidad["tipo_pagos"]["id"],
                    allow_cash_and_banks: $scope.allow_cash_and_banks,
                };
                $scope.data_entidad.cuentas = null;
                $scope.data_entidad.tipo_pagos = null;

            }

        }
        if (allowSet) {
            $scope.gridInvoiceConfigPayments.data.push(setPushData);
            $scope.initValidateByProcessPaymentsSalesBuys();
        }
    };
    $scope.validateStatePaymentsSalesBuys = function (params) {
        var managerSaveAllow = false;
        var errors = [];
        var validateParams = params ? (Object.keys(params).length > 0 ? true : false) : false;
        var processName = $scope.typeProcessMacro;
        //wayToPay:show_directo_mixto
// true=normal
// false=desgloce
        if (!$scope.opciones_factura["validate_save"]) {//si esta true es x q ya sta guardado y no debe validar
            var elementPaymentTypeValue = $scope.toogleElementsConfigView ? $scope.toogleElementsConfigView.show_directo_mixto : $scope.toogleElementsConfigView.show_directo_mixto;

            if ($scope.data_factura_encabezado.retencion) {
                var gridRetentionData = $scope.gridOptsRetenciones ? $scope.gridOptsRetenciones.data : $scope.gridInvoiceOptsRetenciones.data;
                if (gridRetentionData.length > 0 && $scope.data_retenciones.establecimiento && $scope.data_retenciones.punto_emision && $scope.data_retenciones.numero_retencion && $scope.data_retenciones.fecha_factura && $scope.data_retenciones.no_autorizacion) {//esta con registros :o
                    managerSaveAllow = false;
                    var validElement = $scope.validateDigits({
                        value: $scope.data_retenciones.numero_retencion,
                        "type": "numero_retencion"
                    });
                    if (!validElement) {
                        managerSaveAllow = true;
                    }
                    if (allowRetention) {
                        managerSaveAllow = true;
                    }

                } else {
                    managerSaveAllow = true;

                }

            } else if ($scope.data_factura_encabezado.retencion == false) {//SIN RETENCION

            }


            if (elementPaymentTypeValue) {
                if (processName == "buys") {
                    $scope.accountsAddsBuysSales = [];
                }
                if (!$scope.data_factura_encabezado.retencion) {//solo si hay retencion y no es mixto anular
                    managerSaveAllow = false;
                }
            } else {//mixed payment

                var gridPaymentData = $scope.gridInvoiceConfigPayments ? $scope.gridInvoiceConfigPayments.data : $scope.gridInvoiceConfigPayments.data;
                if (gridPaymentData.length > 0) {//esta con registros :o
                    managerSaveAllow = false;

                    if (!$scope.allow_cash_and_banks) {

                        angular.forEach(gridPaymentData, function (value, key) {

                            if ((value.Valor) == undefined) {//es agregado y no tiene valor :)
                                managerSaveAllow = true;
                            } else if ((value.Valor) != undefined) {
                                if (value.Valor == 0) {
                                    managerSaveAllow = true;

                                }
                            }
                        });
                    } else {

                        if (processName == "buys") {
                            $scope.accountsAddsBuysSales = $scope.resetStackBuysSalesTotal({haystack: $scope.accountsAddsBuysSales});
                        }
                        angular.forEach(gridPaymentData, function (value, key) {
                            var valueCurrent = value.Valor;
                            var amount_current = parseFloat(value.amount_current);

                            if ((valueCurrent) == undefined) {//es agregado y no tiene valor :)
                                managerSaveAllow = true;
                            } else if ((valueCurrent) != undefined) {
                                if (valueCurrent == 0) {
                                    managerSaveAllow = true;

                                } else {
                                    if (processName == "buys") {

                                        var setPushAccounts = {
                                            id: value.Cuenta_save,
                                            type_payment: value.type_payment
                                        };
                                        var searchNeedle = $scope.searchStackBuysSales({
                                            haystack: $scope.accountsAddsBuysSales,
                                            needle: setPushAccounts,

                                        });

                                        if (searchNeedle.success) {
                                            $scope.accountsAddsBuysSales[searchNeedle.data.index]["total"] = $scope.accountsAddsBuysSales[searchNeedle.data.index]["total"] + valueCurrent;

                                        }
                                        valueCurrent = parseFloat(valueCurrent);
                                        if (valueCurrent > amount_current) {
                                            managerSaveAllow = true;
                                        }

                                    }
                                }
                            }
                        });
                        if (processName == "buys") {

                            /* validation total values of accounts */
                            angular.forEach($scope.accountsAddsBuysSales, function (value, key) {
                                if (value.total > parseFloat(value.amount_current)) {
                                    managerSaveAllow = true;
                                }
                            });
                        }
                    }
                } else {
                    managerSaveAllow = true;

                }
            }

        }
        if (processName == "sales") {
            if ($scope.toogleElementsConfigView.show_directo_mixto) {
                var valueReceived = $scope.data_factura_encabezado.valueReceived;
                if (!valueReceived) {
                    managerSaveAllow = true;
                } else {

                    var valueTotalInvoice = parseFloat($scope.data_factura_encabezado['totalConRetencion']);
                    if (valueReceived == 0) {
                        managerSaveAllow = true;
                    } else {
                        if (valueReceived < $scope.getValueCustomer(valueTotalInvoice)) {
                            managerSaveAllow = true;
                        }
                    }
                }

            }
        }

        $scope.processInvoiceValidation['managerSaveAllow'] = managerSaveAllow;
        $scope.opciones_factura['validate_gestion'] = managerSaveAllow;
    };
}

function UtilManagerBilling($scope, $http) {
    $scope.transactionTypeData = [
        {id: 0, text: "Cheques"},
        {id: 1, text: "Transferencias Bancarias"},
        {id: 2, text: "Depositos"},
        {id: 3, text: "Retiros"},
    ];


    /*STEP 2*/
    //------------TODO DE RETENCIONES----------------

//    $scope.data_factura_encabezado = params;
    var start_incializaicion = false;
    $scope.options = {'hayinformacion': false};
    $scope.resetS2 = function () {
        $scope.data_retenciones.TipoRetencion = null;
        $scope.data_retenciones.SubTipoRetencion = null;
    }

    $scope.check = {};
    var columnDefsReten = [
        {
            name: 'Detalle',
            field: 'details',
            enableCellEdit: false,
            cellTemplate: [
                "<table class='details-retention'>",
                "<tr><td> <span class='details-retention-title'>Cuenta Contable</span></td><td> <span class='details-retention-value'>{{row.entity.accountData.code}}</span></td></tr> ",
                "<tr><td> <span class='details-retention-title'>Impuesto</span></td><td> <span class='details-retention-value'>{{row.entity.impuesto}}</span></td></tr> ",
                "<tr><td> <span class='details-retention-title'>Código Impuesto</span></td><td> <span class='details-retention-value'>{{row.entity.codigo_impuesto}}</span></td></tr> ",
                "<tr><td> <span class='details-retention-title'>%</span></td><td><span class='details-retention-value'>{{row.entity.porcentaje}}</span></td> </tr>",


                "</table>"
            ].join("")
            , width: '65%'
        },
        {
            field: 'valor_retenido',
            name: 'Valor Retenido',
            enableCellEdit: false,
            enableCellEditOnFocus: false,
            cellTemplate: '<div class="content-value">{{grid.appScope.getResultFormatValue(row.entity.valor_retenido)}}</div>'
            , width: '25%'

        },
        {
            field: 'delete',
            name: '',
            enableCellEdit: false,
            enableCellEditOnFocus: false,
            cellTemplate: '<button  data-toggle="tooltip" data-placement="top" title="Eliminar" type="button"  class="delete-data delete-data--retention far fa-trash-alt" ng-click="grid.appScope._deleteRetencion(row)"></button>'
            , width: '10%'

        }

    ];

    $scope.data_retenciones = {};
    $scope.gridInvoiceOptsRetenciones = {};
    $scope.gridDataApiR = {};
    $scope.gridInvoiceOptsRetenciones = {
        columnDefs: columnDefsReten,
        enableRowHeaderSelection: false,
        enableRowSelection: true,
        multiSelect: false,
        modifierKeysToMultiSelect: false,
        onRegisterApi: function (gridApi) {
            $scope.gridDataApiR = gridApi;
        },
    }

    UtilPaymentsBuySale($scope);
    $scope._validateRetention = function (type) {
        allowRetention = true;
        $scope.initValidateByProcessPaymentsSalesBuys();
//gestion_data_frm.codigo_factura,punto_emision,establecimiento
        if ($scope.data_retenciones.numero_retencion && $scope.data_retenciones.punto_emision && $scope.data_retenciones.establecimiento) {
            var data_gestion = {
                entidad_data_id: entidad_id,
                numero_retencion: $scope.data_retenciones.numero_retencion,
                punto_emision: $scope.data_retenciones.punto_emision,
                establecimiento: $scope.data_retenciones.establecimiento,
            };
            var url_gestion = type ? $('#action-invoice-sales-getValidateInvoiceRetentionExistPointOfBuys').val() : $('#action-invoice-sales-getValidateInvoiceRetentionExistPointOfSales')
                .val();
            $http({
                method: 'POST',
                url: baseUrl + url_gestion,
                params: data_gestion,
                statusText: "json"
            }).then(function successCallback(response) {
                allowRetention = response.data.success;

                if (allowRetention) {
                    var $params = {
                        title: "N° Retencion ",
                        color: "#e7493b",
                        icon: "fa fa-info",
                        content: "Ya Gestionada"
                    };
                    msjSystem($params);
                }
                $scope.initValidateByProcessPaymentsSalesBuys();


            }, function errorCallback(response) {
                allowRetention = true;
                $scope.initValidateByProcessPaymentsSalesBuys();


            });

        }
    }

    /*----------MANAGER GRID MAIN------------*/
    $scope._rowDataPorcentaje = function (value, row) {
        var key_search = $scope.gestionRowEntidad(row);

        var all = false;//para indicar q s hizo un cambio % individual true=no
        if (!value || value < 0) {//cuando existe valores validos
            all = false;
            value = 0;
        } else {
            all = true;
        }
        $scope.gridInvoiceOpts.data[key_search].porcentaje_descuento_manager = value;
        if ($scope.gridInvoiceOpts.data[key_search].porcentaje_descuento_manager != 0) {
            $scope.gridInvoiceOpts.data[key_search].descuento_unidad = true;
        } else {
            $scope.gridInvoiceOpts.data[key_search].descuento_unidad = false;
        }
        $scope.gridInvoiceOpts.data[key_search].data[0]["all"] = all;//para indicar q s hizo un cambio % individual
        $scope.setResultData(); //riniciar los resultados

    }
    $scope.getResultRow = function (params) {
        var subtotalRow = params.subtotal;
        var cantidad = params.cantidad;
        var iva = params.iva;
        var porcentaje_iva = params.porcentaje_iva;
        var current_price = params.current_price;
        var porcentaje_descuento_unidad = params.porcentaje_descuento_unidad;
        var discountRow;
        if ($scope.data_factura_encabezado.type_descuento_factura) {//Discount Invoice
            if ($scope.data_factura_encabezado.type_descuento) {//percentage

                var percentageDiscount = $scope.data_factura_encabezado.type_valor_descuento;
                if (!percentageDiscount || percentageDiscount == "") {
                    percentageDiscount = "0";
                }
                discountRow = percentageDiscount;
            } else {
                discountRow = porcentaje_descuento_unidad;
            }
        } else {//Discount Producto
            if ($scope.data_factura_encabezado.type_descuento) {//percentage
                var percentageDiscount = params.valueCurrent.porcentaje_descuento_manager;
                if (!percentageDiscount || percentageDiscount == "") {
                    percentageDiscount = 0;
                }
                porcentaje_descuento = percentageDiscount;
                discountRow = porcentaje_descuento;
            } else {
                discountRow = porcentaje_descuento_unidad;

            }
        }

        totalDiscountRow = 0;
        totalDiscountRow = (subtotalRow * parseFloat(discountRow)) / 100;
        valor_descuento = totalDiscountRow;
        var descuento_precio_unitario = (current_price * parseFloat(discountRow)) / 100;
        var precio_unitario_descuento = current_price - descuento_precio_unitario;
        var subtotal = subtotalRow;
        var subtotal_descuento = subtotal - valor_descuento;
        var subtotal_descuento_view = subtotal - valor_descuento;//change

        porcentaje_iva = parseFloat(porcentaje_iva);
        var ivaRow = 0;
        if (porcentaje_iva > 0) {
            ivaRow = (subtotal_descuento * porcentaje_iva) / 100; //aqi puede estar sin o con iva
        }
        //
        var total = ivaRow + subtotal_descuento;
        var totalRow = 0;
        if (porcentaje_iva > 0) {
            totalRow = subtotalRow - totalDiscountRow + ivaRow;
        } else {
            totalRow = subtotalRow - totalDiscountRow;

        }
        var result = {
            subtotalRow: subtotalRow,
            totalRow: totalRow,
            precio_unitario_descuento: precio_unitario_descuento,
            valor_descuento: valor_descuento,
            resultDiscount: totalRow,
            porcentaje_descuento: discountRow,
            ivaRow: ivaRow,
            subtotal_descuento: subtotal_descuento,
            subtotal_descuento_view: subtotal_descuento_view//change

        };
        return result;
    }
    $scope.setResultData = function () {
        var data_detalle = $scope.gridInvoiceOpts.data; //change
        var valor_impuestos_encabezado = 0;
        var subtotal_encabezado = 0;
        var subtotal_iva = 0;
        var subtotal_siniva = 0;
        var total_encabezado = 0;
        var valor_descuento = 0;
        var valor_total_descuento = 0;
        var valor_descuentos_porcentaje = 0;
        var valor_factura = 0;
        var porcentaje_iva = 0
        var porcentaje_descuento = 0

        data_detalle = $scope.getConfigDiscountByType(data_detalle);
        angular.forEach(data_detalle, function (value, key) {
            var discountRow = 0;
            var current_price = parseFloat(value["precio_unitario"]);
            var cantidad = value["cantidad"];
            if (!cantidad) {
                cantidad = parseFloat(1);
            } else {
                cantidad = parseFloat(cantidad);
            }
            var subtotalRow = ($scope.getValueCustomer(current_price) * cantidad); //change
            var percentageDiscount = value["porcentaje_descuento_unidad"];

            var iva = value["porcentaje_iva"];
            var taxPercentage = value.porcentaje_iva;
            var resultRow = $scope.getResultRow({
                subtotal: subtotalRow,
                cantidad: cantidad,
                iva: iva,
                porcentaje_descuento_unidad: percentageDiscount,
                porcentaje_iva: taxPercentage,
                current_price: current_price,
                valueCurrent: value
            });


            var iva_id = parseInt(value["iva_id"]);
            subtotal_encabezado += subtotalRow;
            total_encabezado += resultRow.totalRow;
            valor_descuento += resultRow.valor_descuento;
            if (iva == 0) {
                subtotal_siniva += subtotalRow;
            } else {
                subtotal_iva += subtotalRow;
            }
            valor_impuestos_encabezado += resultRow.ivaRow;
            $scope.gridInvoiceOpts.data[key]["subtotal"] = subtotalRow.toFixed($managerRound);
            $scope.gridInvoiceOpts.data[key]["cantidad"] = cantidad;
            $scope.gridInvoiceOpts.data[key]["total"] = resultRow.totalRow.toFixed($managerRound);
            $scope.gridInvoiceOpts.data[key]["precio_unitario_descuento"] = resultRow.precio_unitario_descuento.toFixed($managerRound);//esto es la variable principale del precio unitario que se va a guardar
            $scope.gridInvoiceOpts.data[key]["valor_descuento"] = resultRow.valor_descuento.toFixed($managerRound);
            $scope.gridInvoiceOpts.data[key]["subtotal_descuento"] = resultRow.subtotal_descuento.toFixed($managerRound);
            $scope.gridInvoiceOpts.data[key]["subtotal_descuento_view"] = resultRow.subtotal_descuento_view.toFixed($managerRound);
            $scope.gridInvoiceOpts.data[key]["porcentaje_descuento"] = resultRow.porcentaje_descuento;
            $scope.gridInvoiceOpts.data[key]["subtotal_sin_descuento"] = subtotalRow.toFixed($managerRound);
            $scope.gridInvoiceOpts.data[key]["iva"] = resultRow.ivaRow.toFixed($managerRound);

        });


        //        ---ASIGNACION ENCABEZADO---
        $scope.data_factura_encabezado.valor_impuestos = valor_impuestos_encabezado.toFixed($managerRound);
        $scope.data_factura_encabezado.subtotal_encabezado = subtotal_encabezado.toFixed($managerRound);
//-------DESCUENTOS---
//        ---verificar si existe descduento--
        var exist_descuento = false;
        if (valor_descuento > 0) {
            exist_descuento = true;
        }

        $scope.data_factura_encabezado["valor_descuento"] = valor_descuento.toFixed($managerRound);
        $scope.data_factura_encabezado["subtotal_encabezado"] = (subtotal_encabezado - valor_descuento).toFixed($managerRound);
        $scope.data_factura_encabezado["subtotal_encabezado_sin_flete"] = (subtotal_encabezado - valor_descuento).toFixed($managerRound);
        $scope.data_factura_encabezado["subtotal_encabezado"] = (parseFloat($scope.data_factura_encabezado["subtotal_encabezado"]) + parseFloat($scope.data_factura_encabezado["flete"] == null || $scope.data_factura_encabezado["flete"] == "" ? 0 : $scope.data_factura_encabezado["flete"])).toFixed($managerRound);
        $scope.data_factura_encabezado["subtotal_iva"] = subtotal_iva.toFixed($managerRound);
        $scope.data_factura_encabezado["subtotal_siniva"] = subtotal_siniva.toFixed($managerRound);
        $scope.data_factura_encabezado.sub_total = subtotal_encabezado.toFixed($managerRound);
        $scope.data_factura_encabezado.valor_impuestos = valor_impuestos_encabezado.toFixed($managerRound);
        valor_factura = valor_impuestos_encabezado + subtotal_encabezado - valor_descuento;
        $scope.data_factura_encabezado.valor_factura = valor_factura.toFixed($managerRound);
        $scope.data_factura_encabezado.valor_factura = (valor_factura + parseFloat($scope.data_factura_encabezado["flete"] == null || $scope.data_factura_encabezado["flete"] == "" ? 0 : $scope.data_factura_encabezado["flete"])).toFixed($managerRound);
        $scope.data_factura_encabezado.exist_descuento = exist_descuento; //variable q avisara si existe descuento
//       --esta variable toca cambiar su valor en los pagoss y mediante esto s sabe si existe deuda o valor pendiente en la facgura
        $scope.data_factura_encabezado.diferencia = valor_factura.toFixed($managerRound); //variable q avisara si existe descuento
        $scope.totalInvoice = {
            subtotalX: $scope.getValueCustomer($scope.data_factura_encabezado["subtotal_iva"]),
            subtotal0: $scope.getValueCustomer($scope.data_factura_encabezado["subtotal_siniva"]),
            discount: $scope.getValueCustomer($scope.data_factura_encabezado["valor_descuento"]),
            tax: $scope.getValueCustomer($scope.data_factura_encabezado["valor_impuestos"]),
            total: $scope.getValueCustomer($scope.data_factura_encabezado["valor_factura"])
        };

        $scope.managerValidStep1();
    }
    $scope.opciones_factura = {
        "validate_save_btn": false,
        "validate_save": false,
        'validation_anexosave': false,
        validation_retencion: false
    };


    /*PAYMENT BREAKDOWN*/
    $scope.data_entidad = {cuentas: {id: "", text: ""}};
    $scope.data_entidad = {};
    $scope.data_factura_encabezado_pagos = {
        'diferencia': $scope.data_factura_encabezado['valor_factura'],
        total: '0.00'
    };
    $scope.data_pay_efectivo = {};

    $scope.setDataPagos = function () {
        $scope.data_entidad["cuentas"] = null;
    }

    $scope._deleteRowPagos = function (row) {

//        ---return
        if ($scope.processInvoiceValidation["invoiceSave"] == false) {//si esta true es x q ya sta guardado y no debe validar

            if (row == "mod_reten") {

            } else {
                var index = $scope.gridInvoiceConfigPayments.data.indexOf(row.entity);
                $scope.gridInvoiceConfigPayments.data.splice(index, 1);
            }
            subtotal = 0;
            angular.forEach($scope.gridInvoiceConfigPayments.data, function (value, key) {
                subtotal = parseFloat(subtotal) + parseFloat(value["Valor"]);
            });
//                $scope.descuento_compra(descuento);
//
            $scope.data_factura_encabezado_pagos["total"] = subtotal.toFixed($managerRound);
            $scope.data_factura_encabezado["diferencia"] = (parseFloat($scope.data_factura_encabezado['totalConRetencion']) - parseFloat(subtotal)).toFixed($managerRound);
            $scope.initValidateByProcessPaymentsSalesBuys();


        }
    };

    /*RETENTION*/
    /*RETENCIONES*/
//    ------------ - eliminar una fila-------------- -
    $scope._deleteRetencion = function (row) {
        if ($scope.processInvoiceValidation["invoiceSave"] == false) {//si esta true es x q ya sta guardado y no debe validar
            var index = $scope.gridInvoiceOptsRetenciones.data.indexOf(row.entity);
            $scope.gridInvoiceOptsRetenciones.data.splice(index, 1);
            subtotal = 0;
            angular.forEach($scope.gridInvoiceOptsRetenciones.data, function (value, key) {
                subtotal = parseFloat(subtotal) + parseFloat(value["valor_retenido"]);
            });
            if (subtotal != 0) {
                $scope.data_retenciones["Valor_retencion"] = subtotal.toFixed($managerRound);

            } else {
                $scope.data_retenciones["Valor_retencion"] = "0";
            }
            $scope.data_factura_encabezado["totalConRetencion"] = parseFloat($scope.data_factura_encabezado["valor_factura"]) - parseFloat($scope.data_retenciones["Valor_retencion"]);
            condicion = "mod_reten";
            $scope._deleteRowPagos(condicion);
            $scope.initValidateByProcessPaymentsSalesBuys();
            $scope.setValuesDetailsRetentions();
        }
    };

    $scope.allowAddRetention = function (params) {
        var result = false;
        var typeRetention = params.typeRetention;
        var countTypeRetention = 0;
        angular.forEach($scope.gridInvoiceOptsRetenciones.data, function (value, key) {
            if (value["typeRetention"] == typeRetention) {
                countTypeRetention++;
            }


        });
        result = countTypeRetention == 0 ? true : false;
        return result;
    }
    $scope.CalcularRetencion = function (event) {
        if ($scope.data_retenciones.SubTipoRetencion) {
            var valor_retencion = 0;
            var base_imponible = 0;
            var typeRetention = $scope.data_retenciones["TipoRetencion"]["type"];
            if ($scope.allowAddRetention({typeRetention: typeRetention})) {
                if (typeRetention == 1) {
                    valor_retencion = (parseFloat($scope.data_factura_encabezado["subtotal_encabezado"]) * parseFloat($scope.data_retenciones['SubTipoRetencion']["porcentaje"])) / 100;
                    base_imponible = $scope.data_factura_encabezado["subtotal_encabezado"];
                } else {
                    valor_retencion = (parseFloat($scope.data_factura_encabezado["valor_impuestos"]) * parseFloat($scope.data_retenciones['SubTipoRetencion']["porcentaje"])) / 100;
                    base_imponible = $scope.data_factura_encabezado["valor_impuestos"];
                }
                valor_total_retencion = 0;
                var setPushRetention = {
                    subtotal: base_imponible,
                    retencion_id: angular.isUndefined($scope.data_retenciones["TipoRetencion"]["id"]) ? null : $scope.data_retenciones["TipoRetencion"]["id"],
                    impuesto: $scope.data_retenciones["TipoRetencion"]["text"],
                    sub_tipo_retencion_id: $scope.data_retenciones["SubTipoRetencion"]["id"],
                    codigo_impuesto: $scope.data_retenciones["SubTipoRetencion"]["value"],
                    porcentaje: $scope.data_retenciones["SubTipoRetencion"]["porcentaje"] + '%',
                    porcentaje_value: $scope.data_retenciones["SubTipoRetencion"]["porcentaje"],
                    tipo_retencion_impuesto_id: $scope.data_retenciones["SubTipoRetencion"]["tipo_retencion_impuesto_id"],
                    contabilidad_cuenta_id: $scope.data_retenciones["SubTipoRetencion"]["contabilidad_cuenta_id"],
                    accountData: $scope.data_retenciones["SubTipoRetencion"].cuenta_contable_data,
                    valor_retenido: valor_retencion.toFixed($managerRound),
                    typeRetention: typeRetention

                }
                $scope.gridInvoiceOptsRetenciones.data.push(setPushRetention);
                var result_get = $scope.getValuesDetailsRetentions();
                var subtotal = result_get.valor_total_retencion;
                valor_total_retencion = subtotal;
                $scope.setValuesDetailsRetentions();
                $scope.data_factura_encabezado["totalConRetencion"] = (parseFloat($scope.data_factura_encabezado["valor_factura"]) - parseFloat($scope.data_retenciones["Valor_retencion"])).toFixed($managerRound);
                $scope.data_retenciones["Valor_retencion"] = valor_total_retencion;
                $scope.data_factura_encabezado.totalConRetencion = $scope.data_factura_encabezado["valor_factura"];
                $scope.data_factura_encabezado["totalConRetencion"] = (parseFloat($scope.data_factura_encabezado["totalConRetencion"]) - parseFloat($scope.data_retenciones["Valor_retencion"])).toFixed($managerRound);
                $scope.initValidateByProcessPaymentsSalesBuys();
            } else {
                var msjType = "";
                if (typeRetention == 1) {//renta
                    msjType = "Renta";
                } else {//iva
                    msjType = "Iva";
                }
                var $params = {
                    title: "Advertencia ",
                    color: "#e7493b",
                    icon: "fa fa-info",
                    content: "Este tipo ya fue agregado(" + msjType + ")."
                };
                msjSystem($params);
            }
            $scope.resetS2();
        }
    };
    $scope.setValuesDetailsRetentions = function () {
        $scope.total_renta = 0;
        $scope.total_iva = 0;
        var result_get = $scope.getValuesDetailsRetentions();
        subtotal = result_get.valor_total_retencion;
        if (subtotal != 0) {
            $scope.data_retenciones["Valor_retencion"] = subtotal;
        } else {
            $scope.data_retenciones["Valor_retencion"] = "0";
        }

        $scope.total_renta = result_get.total_renta;
        $scope.total_iva = result_get.total_iva;
        $scope.data_factura_encabezado["totalConRetencion"] = parseFloat($scope.data_factura_encabezado["valor_factura"]) - parseFloat($scope.data_retenciones["Valor_retencion"]);

    }
    $scope.getValuesDetailsRetentions = function () {
        subtotal = 0;

        var valor_total_retencion = 0;
        var total_renta = 0;
        var total_iva = 0;
//            ---perro--
        angular.forEach($scope.gridInvoiceOptsRetenciones.data, function (value, key) {
            valor_total_retencion = valor_total_retencion + parseFloat(value["valor_retenido"]);
            if (value["typeRetention"] == 1) {//IVA
                total_renta += parseFloat(value["valor_retenido"]);
            } else {//RENTA
                total_iva += parseFloat(value["valor_retenido"]);

            }

        });
        subtotal = valor_total_retencion;
        angular.forEach($scope.gridInvoiceOptsRetenciones.data, function (value, key) {
            subtotal = parseFloat(subtotal) + parseFloat(value["valor_retenido"]);
        });

        result = {
            total_renta: total_renta.toFixed($managerRound),
            total_iva: total_iva.toFixed($managerRound),
            valor_total_retencion: valor_total_retencion.toFixed($managerRound)
        };
        return result;
    }
}



function UtilHotKey($scope) {

    $scope._configHotKey = function (option) {
        var selector = option.selector;
        if (option.selector == "#checkIn") {
            var selector = option.selector;
            if ($scope.validManagerStep1.allReady) {
                $(selector).click();
            }

        } else if (option.selector == "#productos-data") {
            $(selector).select2('open');
        } else if (option.selector == "#span-return") {
            if ($scope.validManagerStep1.allReady) {

                $(selector).click();
            }
        } else if (option.selector == "#has-retencion") {


            if ($scope.configManagerSetps.step1) {
                $(selector).click();
            }

        }
    }
    $scope.slideHtmlConfig = "";
    $scope.count = 0;

    var dataKeyHots = getHotKey();
    $scope.dataKeyHots = dataKeyHots;
    $scope.getSlideHtml = function () {


        var result = [
            '   <div class="handle"><span class="fa fa-question"></span></div>',
            '   <h3>Atajos del Sistema<br><small><span class="glyphicon glyphicon-info-sign"></span> Presione <kbd>ESC</kbd> para cerrar</small></h3>'];
        angular.forEach(dataKeyHots, function (value, key) {
            var hotKeySelector = value.keyDown;
            var title = value.title;
            var hotKey = '  <span class="label label-warning">' + hotKeySelector + '</span>';
            var htmlPush = '<a key="' + key + '">' + title + hotKey + '</a>';
            result.push(htmlPush);
        });
        return result.join('');
    }
    $scope.slideHtmlConfig = $scope.getSlideHtml();

    $scope.increment = function () {
        $scope.count++;
    }

    $scope.decrement = function () {
        $scope.count--;
    }
}

function getHotKey() {
    return configHotkey = {
        checkIn: {
            keyDown: "shift+a",
            title: "Facturar",
            selector: "#checkIn"
        },
        openProduct: {
            keyDown: "shift+p",
            title: "Buscar Producto",
            selector: "#productos-data"

        },
        "returnStep1": {
            keyDown: "shift+z",
            title: "Regresar a Factura",
            selector: "#span-return"

        }
        ,
        "setRetention": {
            keyDown: "shift+r",
            title: "Agregar/Quitar Retencion",
            selector: "#has-retencion"

        }
    };

}
