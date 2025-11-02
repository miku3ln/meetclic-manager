/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var type_producto = false;
function initS2($scope) {
    //----------CLIENTES---
    $scope.select2OptionsClientesId = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: $('#action-customer-getListCustomers').val(),
            dataType: 'json',
            data: function (term, page) {
                params = {
                    search_value: term,
                    search_entidadid: entidad_id,
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        },
    }
//-------PRODUCTO-------
//-------PRODUCTO-------
//    $scope.producto_data={};
    $scope.select2OptionsProductoId = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: $('#action-products-getListProductServicesPointOfSales').val(),
            dataType: 'json',
            data: function (term, page) {
                params = {
                    filters: {search_value: term,
                        entidad_data_id: entidad_id,
                        type_producto: $scope.getType(),
                        typeProduct: $scope.typeProduct
                    }
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        },
    }
    $scope.getType = function () {
        return  type_producto;
    }
    $scope.changetype_producto = function () {
        type_producto = $scope.data_factura_encabezado.type_producto;
    }
//    ---lista de motivos de traslado-----------
    $scope.data_motivoTraslado = [];
    $scope.data_encabezado_guia = {};


    //    ----esto es tipo de pago---
    $scope.select2OptionsTipopago = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: baseUrl + "contabilidad/tiposDePagos/getTipoPagoS2",
            dataType: 'json',
            data: function (term, page) {
                params = {
                    search_value: term,
                    search_entidadid: entidad_id,
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        },
    };
//    ---CUENTAS CON LO QUE SE VA A PAGAR
    $scope.select2OptionsCuentas = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: baseUrl + "contabilidad/typosDePagosHasCuentaEntidad/getContCuePagosS2",
            dataType: 'json',
            data: function (term, page) {
                var tipo_pago = $scope.data_entidad ? (typeof ($scope.data_entidad.tipo_pagos) == "undefined" || $scope.data_entidad.tipo_pagos == null ? -1 : $scope.data_entidad.tipo_pagos.id) : -1;
                var params = {
                    typeProcess:"sales",
                    search_value: term,
                    search_entidadid: entidad_id,
                    tipo_pago: tipo_pago,
                    allow_cash_and_banks: entityData.allow_cash_and_banks,
                    types_payment_data: $scope.data_entidad ? $scope.data_entidad.tipo_pagos : null
                };
                return params;
            },
            results: function (data, page) {

                return {results: data};
            }
        },
    };


    $scope.select2OptionsCuentasRetencion = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: baseUrl + "contabilidad/typosDePagosHasCuentaEntidad/getContCuePagosS2",
            dataType: 'json',
            data: function (term, page) {
                params = {
                    search_value: term,
                    search_entidadid: entidad_id,
                    tipo_pago: $scope.data_retenciones['tipo_pagos']["id"]
//                    search_entidadid: $scope.data_entidad["local1"].lenght > 0 ? $scope.data_entidad["local1"]["id"] : null,
                };
                return params;
            },
            results: function (data, page) {

                return {results: data};
            }
        },
    };

    //------------METODOS DE RETENCIONES------------------


    $scope.data_retenciones = {};
    var gestion_view = {object_gestion: $("#document-renteciones"), view_object: false};
    viewInformacion(gestion_view);
    $scope.select2OptionsTipoRI = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url:$('#action-retention-tax-type-getTypeRetentionsByTaxPointOfSales').val(),
            dataType: 'json',
            data: function (term, page) {
                params = {
                    search_value: term,
                    type: "sales",
                    search_entidadid: entidad_id,
                };
                return params;
            },
            results: function (data, page) {
                return {results: data};
            }
        },
    };
//    ---CUENTAS CON LO QUE SE VA A PAGAR
    $scope.select2OptionsSubTipoRI = {
        allowClear: true,
        delay: 250,
        templateResult: $scope.formatState,
        type: "post",
        ajax: {
            url: $('#action-retention-tax-sub-type-getListSubTRIPointOfSales').val(),
            dataType: 'json',
            data: function (term, page) {
                var data_result = typeof ($scope.data_retenciones.TipoRetencion);
                var data = false;
                if (data_result == "undefined") {
                    data = true;
                }
                if (data_result == "object") {
                    if ($scope.data_retenciones.TipoRetencion == null) {
                        data = true;
                    }
                }
                var tipo_retencion = data ? -1 : $scope.data_retenciones['TipoRetencion']["id"];


                params = {
                    search_value: term,
                    search_entidadid: entidad_id,
                    tipo_retencion: tipo_retencion
                };
                return params;
            },
            results: function (data, page) {

                return {results: data};
            }
        },
    };

}
