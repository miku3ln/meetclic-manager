/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function UtilGridManager($scope,
                         $http,
                         $log,
                         ConstEntidadData,
                         $sce,
                         $compile,
                         $rootScope,
                         $timeout,
                         $interval,
                         $mdDialog, $uibModal) {
    var urlManagerAdmin = $('#action-invoice-sales-getInvoiceSaleAdmin').val();
    $scope.modelFilters = [];
    $scope.modelFilters.typeOfProofData = "-1";
    $scope.modelFilters.stateData = "-1";
    $scope.getFiltersGrid = function () {
        var entidad_data_id = $entidad_id;

        var estado = $scope.modelFilters.stateData ? ($scope.modelFilters.stateData == -1 ? "" : $scope.modelFilters.stateData) : "";
        var fecha_inicio = $scope.modelFilters.dateInit ? moment($scope.modelFilters.dateInit).format("YYYY-MM-DD") : "";
        var fecha_fin = $scope.modelFilters.dateEnd ? moment($scope.modelFilters.dateEnd).format("YYYY-MM-DD") : "";
        var tipo_comprobante_id = $scope.modelFilters.typeOfProofData ? ($scope.modelFilters.typeOfProofData == -1 ? "" : $scope.modelFilters.typeOfProofData) : "";
        var supplyCustomerId = "";
        return {

            entidad_data_id: entidad_data_id,
            estado: estado,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            tipo_comprobante_id: tipo_comprobante_id,
            "supplyCustomerId": supplyCustomerId
        };
    }
    $scope.griDataFilters = $scope.getFiltersGrid();
    //-------BOOTGRID VARIABLES----
    $scope.oldSelected = 0;
    $scope.setPositionMenu = function (rowId) {
        $("#facturas-grid tr").removeClass("select-row-manager");
        var position = $("tr[data-row-id='" + rowId + "']").position();
        var top = position.top - 64;
        $("#content-gestion-menu").css("margin-top", top + "px");
        $("tr[data-row-id='" + rowId + "']").addClass("select-row-manager");
    }
    $scope._managerInvoice = function (params) {
        var key_id = params.id;
        var row = params.row;
        $scope.menu_gestion = [];
        $scope.rowManager = null;
        $scope.rowIdCurrent = key_id;


        if ($scope.oldSelected == 0) {// init grid
            $scope.setPositionMenu(key_id);
            $scope.oldSelected = key_id;
            $scope.menuGenerate(params);
            $scope.rowManager = row;
            $("#check-" + key_id).prop('checked', true);

        } else if ($scope.oldSelected == key_id) {//el mismo
            $("#facturas-grid tr").removeClass("select-row-manager");
            $("#check-" + key_id).prop('checked', false);
            $scope.oldSelected = 0;
        } else {//otros
            $scope.setPositionMenu(key_id);
            $("#check-" + $scope.oldSelected).prop('checked', false);
            $scope.oldSelected = key_id;
            $("#check-" + key_id).prop('checked', true);
            $scope.menuGenerate(params);
            $scope.rowManager = row;
        }
        $scope.$apply();
    }
    $scope.data_row_selected = {};
    var grid_inicializar = "#facturas-grid";
    var formatter_items =
        {
            'razon_social': function (column, row) {
                var htmlRow = "";
                var infoCustomer = "";
                if (row.razon_social) {
                    infoCustomer = row.razon_social;
                } else {
                    infoCustomer = row.nombres ? row.nombres : "Sin Gestionar" + " " + row.apellidos ? row.apellidos : "Sin Gestionar";
                }
                htmlRow = infoCustomer;
                return htmlRow;
            },
            'estado-formatter': function (column, row) {
                var estado_registro = row.solicitud_anticipo;
                var row_registro = row.id;
                var estado = row.estado;
                var exist_deuda = row.exist_deuda;
                var id_pagos_ventas = row.id_pagos_ventas;
                html_info = "";
                html_info = '<div class="col col-md-12 content-check-manager" ><div class="col col-md-2"><input  id="check-' + row_registro + '" type="checkbox" row-id="' + row_registro + '" exist-deuda="' + exist_deuda + '" estado="' + estado + '" id_pagos_ventas="' + id_pagos_ventas + '" class="manager-invoice check-manager"></div></div>';

                return html_info;
            },
            "description": function (colum, row) {
                var estado = row.estado;
                var spanCurrent = "";
                var spanClass = "badge  ";
                if (estado ==statusCurrentManager["EMITIDO"] ) {
                    spanClass += " badge-success";
                } else if (estado == statusCurrentManager["PENDIENTE"]) {
                    spanClass += " badge-warning";

                } else if (estado == statusCurrentManager["ANULADO"]) {
                    spanClass += " badge-danger";

                }
                var htmlRow = "";
                spanCurrent = "<span class='title-span'>Estado:</span><span class='span-value " + spanClass + "'>" + statusCurrentManagerEnglish[estado ]+ "</span> <br>";
                spanClass = "";
                spanCurrent += "<span class='title-span'>Tipo:</span><span class='span-value " + spanClass + "'>" + row.tipo + "</span> <br>";
                var valueCurrent = "";
                if (row.deuda == "1") {
                    spanClass = "badge badge-warning";
                    valueCurrent = "SI";
                }
                if (row.deuda == "0") {
                    spanClass = "badge badge-success";
                    valueCurrent = "NO";

                }
                spanCurrent += "<span class='title-span'>Credito:</span><span class='span-value " + spanClass + "'>" + valueCurrent + " </span> <br>";
                htmlRow += "<div class='content-description'>";
                htmlRow += spanCurrent;
                htmlRow += "</div>";


                return htmlRow;
            },
            "razon_social": function (colum, row) {
                var razon_social = row.razon_social ? row.razon_social : row.nombres + " " + row.apellidos;
                var identificacion = row.identificacion;

                var htmlRow = [
                    '<div class="content-information">',
                    '   <span class="inline-data">',
                    razon_social,
                    " / " + identificacion,

                    '   </span>',
                    '</div>'
                ];


                return htmlRow.join("");

            }

            , "valor_factura": function (colum, row) {
                var valor_factura = $scope.getValueCustomer(row.valor_factura);
                var subtotal = $scope.getValueCustomer(row.subtotal);
                var valor_descuento = $scope.getValueCustomer(row.valor_descuento);
                var now_after_retencion = $scope.getValueCustomer(row.now_after_retencion);
                var manager = row.manager;
                var rowRetention = [];
                if (now_after_retencion) {
                    var retentionsData = manager.retentionsData;
                    var resultRetention = 0;
                    $.each(retentionsData, function (index, value) {
                        resultRetention += parseFloat(value.valor_retenido);
                    });
                    rowRetention = [
                        '   <tr class="values-tr">',
                        '       <th>', 'Retención', '</th>', '<th>', $scope.getValueCustomer(resultRetention), '</th>',
                        '   </tr>'];

                }
                rowRetention = rowRetention.join("");
                var htmlRow = [
                    '<table class="content-information">',

                    '   <tr class="values-tr">',
                    '       <th>', 'Subtotal', '</th>', '<th>', subtotal, '</th>',
                    '   </tr>',
                    '   <tr class="values-tr">',
                    '       <th>', 'Descuentos', '</th>', '<th>', valor_descuento, '</th>',
                    '   </tr>',
                    rowRetention,
                    '   <tr class="values-tr">',
                    '       <th>', 'Total', '</th>', '<th>', valor_factura, '</th>',
                    '   </tr>',
                    '</table>'
                ];


                return htmlRow.join("");

            }
        };
    $scope.$typeOfProofData = [];
    $scope.typeOfProofData = $typeOfProofData;
    $scope.getParamsBootgrid = function () {
        var params =
            {
                init_ajax: true, //permite inicializar o obtener datos via ajax
                filters: $scope.getFiltersGrid(),
                url_get_data: urlManagerAdmin,
                element: grid_inicializar,
//                ---para personalizar los campos de la tabla--
            object_formater: formatter_items,
            "function": function () {
                $scope.resetdata();
                $scope.$apply();
                $(grid_inicializar + "-header").removeClass("ng-hide");
                $(".content-check-manager").addClass("not-view");
            }
        };
        return params;
    }
    $scope.paramsBootGridManager = $scope.getParamsBootgrid();
    initGridEntidad($scope.paramsBootGridManager, $scope);
    $scope.managerGetData = false;
    $scope.resetGridAdmin = function () {

        $(grid_inicializar).bootgrid("destroy");
        $scope.paramsBootGridManager = $scope.getParamsBootgrid();
        initGridEntidad($scope.paramsBootGridManager, $scope);
    }

}
