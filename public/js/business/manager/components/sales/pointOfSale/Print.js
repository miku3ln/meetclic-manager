function initPrintData($scope) {
    $scope.saveFacturaData = {};
    //    -------IMPRIMIR---
    $scope.printData = function () {
        $("#" + $scope.print_element).printArea({
            popHt: 500,
            popWd: 400,
            popX: 500,
            popY: 600,
            popTitle: ".",
            popClose: true,
            //una url de donde esta el archivo del nuevo css
            extraCss: $css_print_factura,
            strict: true
        });

    }
//    $scope.resetData
    $scope.printGuia = function () {
        $("#content-data-guias").printArea({
            popTitle: " .",
            popClose: true,
//            extraCss: $css_print_factura,
            strict: true
        });
    }


    $scope.factura_autorizacion = $scope.authorizationSettingInvoiceCode;
    $scope.type_factura_print = false;//false=facturero listo y poner los valores como la factura ,true=diseño exclusivo por nosotros
    $scope.type_disenio = "disenio2";//CONFIG IMPRESIONES DISEÑO
    $scope.viewDataOther = false;//cambia a ingresar valores de factura
    $scope.viewDataPdf = false;//con esto se vera el pdf a generar con l api
    //----variables de contenedores que se va a imprimir
    $scope.print_element = "content-data-factura";
    $scope.getPrintElement = function () {
        if ($scope.type_disenio == "autosur") {
            $scope.print_element = "content-data-factura-autosur";
        }
        if ($scope.type_disenio == "disenio2") {
            $scope.print_element = "content-data-" + $scope.type_disenio;
        }
    }
    $scope.getPrintElement();
    $scope.printFacturaInit = function () {
        var data_init = {
            encabezado: {
                cliente: {
                    nombre: "",
                    ruc_ci: "",
                    fecha: "",
                    direccion: "",
//                    guia_remision: "SIN INFORMACION",
                    guia_remision: "",
                    telefono: ""
                },
                empresa: $scope.data_empresa,
                factura_info: {
                    numero: "",
                    autorizacion: "",
                }
            },
            detalle: [],
            pie: {
                forma_pagos: {
                    efectivo: "",
                    dinero_electronico: "",
                    tarjeta_credito_debito: "",
                    otros: "",
                },
                desgloce: {
                    suman: 0,
                    descuentos: "",
                    sub_total: "",
                    iva_config: "",
                    iva_otros: "",
                    total: ""
                }
            }
        };
        return data_init;
    }
    ;
    $scope.print_factura = $scope.printFacturaInit();
//    MATRIZ RESULTANTE DELA GESTION PARA UNA FACTURA
    $scope.getFacturaEstructura = function (data) {
//        -------INIT encabezado--
//        -------INIT CLIENTES--
        var nombre = $scope.data_factura_encabezado.cliente_data.nombres_cliente;
        var ruc_ci = $scope.data_factura_encabezado.cliente_data.identificacion;
        var fecha = moment($scope.data_factura_encabezado["fecha_factura"]).format("YYYY-MM-DD");
//        var fecha = moment($scope.data_factura_encabezado["fecha_factura"]).format("YYYY-MM-DD") + " 00:00:00";
        var direccion = $scope.data_factura_encabezado.cliente_data.direccion;
        var telefono = $scope.data_factura_encabezado.cliente_data.telefono;
        var email = $scope.data_factura_encabezado.cliente_data.email;
        $scope.print_factura.encabezado.cliente.nombre = nombre;
        $scope.print_factura.encabezado.cliente.ruc_ci = ruc_ci;
        $scope.print_factura.encabezado.cliente.fecha = fecha;
        $scope.print_factura.encabezado.cliente.direccion = direccion;
        $scope.print_factura.encabezado.cliente.telefono = telefono;
        $scope.print_factura.encabezado.cliente.email = email;
        var factura_id_gestion = data.id_factura;

        var invoiceNumberCode = $scope.data_factura_encabezado.establecimiento + "-" + $scope.data_factura_encabezado.punto_emision + "-" +  data['invoiceCurrent']['invoice_code'];
        $scope.print_factura.encabezado.factura_no = invoiceNumberCode;//aux
//                 INIT   FACTURA INFORMACION
        $scope.print_factura.encabezado.factura_info.numero = $scope.data_factura_encabezado.establecimiento + "-" + $scope.data_factura_encabezado.punto_emision + "-" + data['invoiceCurrent']['invoice_code'];
        $scope.print_factura.encabezado.factura_info.autorizacion = $scope.factura_autorizacion;
//                 END   FACTURA INFORMACION
//        -------END CLIENTES--
        //        -------END encabezado--

//        ----INIT DETALLE---
        var data_detalle_factura = [];
        angular.forEach($scope.gridInvoiceOpts.data, function (value, key) {
            row_data = {
                cantidad: value.cantidad,
                codigo: value.codigo,
                detalle: value.detalle,
                precio_unitario: value.precio_unitario,
                total: value.total,
            };
            data_detalle_factura.push(row_data);
        });
        $scope.print_factura.detalle = data_detalle_factura;
//        ----END DETALLE---
//        ----INIT PIE---
        var efectivo = "";
        var dinero_electronico = "";
        var tarjeta_credito_debito = "";
        var otros = "";
//        ---NORMAL--
        if ($scope.toogleElementsConfigView.show_directo_mixto) {//SIN DESGLOCE DE PAGO

            if ($scope.toogleElementsConfigView["cobro_directo_pendiente"] == true) {//PAGO PENDIENTE

            }

            if ($scope.toogleElementsConfigView.show_efectivo_tarjeta) {//efectivo
                efectivo = $scope.data_factura_encabezado.valor_factura;
            } else {//tarjeta
                tarjeta_credito_debito = $scope.data_factura_encabezado.valor_factura;

            }
        } else {//desglozado MIXTO
            var efectivo_id = $getDataPagos[0].id;
            var tarjeta_credito_id = $getDataPagos[1].id;
            var cheque_id = $getDataPagos[2].id;
            var transferencias_bancarias_id = $getDataPagos[3].id;
            var dinero_electronico_id = $getDataPagos[4].id;
            var tarjeta_debito_id = $getDataPagos[5].id;
            var tarjeta_prepago_id = $getDataPagos[6].id;
//            EFECTIVO
            result_data = 0;
            result_data = $scope.typeFormaPagoResult(efectivo_id);
            if (result_data > 0) {
                efectivo = result_data;
            }
//            TARJETAS CREDITO Y DEBITO
            var both = 0;
            result_data = 0;
            result_data = $scope.typeFormaPagoResult(tarjeta_credito_id);
            if (result_data > 0) {
                both = result_data;
            }
            result_data = 0;
            result_data = $scope.typeFormaPagoResult(tarjeta_debito_id);
            if (result_data > 0) {
                both += result_data;
            }
            if (both > 0) {
                tarjeta_credito_debito = both;
            }
//            dinero ELECTRONICO
            result_data = 0;
            result_data = $scope.typeFormaPagoResult(dinero_electronico_id);
            if (result_data > 0) {
                dinero_electronico = result_data;
            }

        }
        $scope.print_factura.pie.forma_pagos.efectivo = efectivo;
        $scope.print_factura.pie.forma_pagos.dinero_electronico = dinero_electronico;
        $scope.print_factura.pie.forma_pagos.tarjeta_credito_debito = tarjeta_credito_debito;
//        desgloce: {
//                        suman: 0,
//                        descuentos: "",
//                        sub_total: "",
//                        iva_config: "",
//                        iva_otros: "",
//                        tota: ""
//                    }

        var suman = parseFloat($scope.data_factura_encabezado.subtotal_iva) + parseFloat($scope.data_factura_encabezado.subtotal_siniva);
        var descuentos = parseFloat($scope.data_factura_encabezado.valor_descuento);
        var sub_total = $scope.data_factura_encabezado.subtotal_iva;
        var iva_config = $scope.data_factura_encabezado.valor_impuestos;
        var iva_otros = $scope.data_factura_encabezado.subtotal_siniva;
        var total = $scope.data_factura_encabezado.valor_factura;
        $scope.print_factura.pie.desgloce.suman = suman;
        $scope.print_factura.pie.desgloce.descuentos = descuentos;
        $scope.print_factura.pie.desgloce.sub_total = suman - descuentos;
        $scope.print_factura.pie.desgloce.iva_config = iva_config;
        $scope.print_factura.pie.desgloce.iva_otros = iva_otros;
        $scope.print_factura.pie.desgloce.total = total;

    }
    $scope.typeFormaPagoResult = function (forma_pago_key) {
        var result_data = 0;
        if ($scope.gridInvoiceConfigPayments) {

            angular.forEach($scope.gridInvoiceConfigPayments.data, function (value, key) {
                var value_comparate = value.Tipo_pago_save;
                var Valor = value.Valor;
                if (forma_pago_key == value_comparate) {
                    result_data += Valor;
                }
            });
        }
        return result_data;

    }
}
