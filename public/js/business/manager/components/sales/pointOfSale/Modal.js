/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function ModalDataProducto($scope) {
    $scope.init_modal_data = false;
    $scope.modal_title = "Hola";
    $scope.close_modal = false;
    $scope.model_data_modal = {};
    $scope.resetDataModal = function () {

        $scope.model_data_modal = {};

    }
    $scope.close_modal_funtion = function () {
        $scope.close_modal = true;

    };
    $scope.addDataProductoModal = function () {
        if ($scope.model_data_modal)
        {//esto pasa cuando limpia si existe valor
            var producto_data = $scope.model_data_modal;
            $scope.producto_object_modal = producto_data;
            var key_search = $scope.producto_object_modal.id;
            var typeProduct = $scope.typeProduct;
            var accountingSeat = [];
            $scope.new_data = false;
            if (!$scope.verificarAddData(key_search)) {//solo si no existe s agrega
                var precio_venta = $scope.producto_object_modal.precio_venta;
                var array_attributes_producto = [{
                    id: key_search,
                    porcentaje_descuento: 0,
                    precio: parseFloat(precio_venta),
                    valor_descuento: 0,
                    cantidad: 1,
                    all: false
                }];
                var porcentaje_descuento = $scope.producto_object_modal.porcentaje_descuento;//new
                var prices = [];

                if (typeProduct) {
                    prices.push({
                        value: $scope.producto_object_modal.precio_venta1,
                        text: "Precio 1/$" + $scope.getValueCustomer($scope.producto_object.precio_venta1)
                    })
                    prices.push({
                        value: $scope.producto_object_modal.precio_venta2,
                        text: "Precio 2 /$" + $scope.getValueCustomer($scope.producto_object.precio_venta2)
                    });
                    prices.push({
                        value: $scope.producto_object_modal.precio_venta3,
                        text: "Precio 3 /$" + $scope.getValueCustomer($scope.producto_object.precio_venta3)
                    });
                } else {
                    var cuenta_contable = $scope.producto_object_modal.cuenta_contable;
                    var contabilidad_cuenta_id = $scope.producto_object_modal.contabilidad_cuenta_id;
                    var cuenta_contable_codigo = $scope.producto_object_modal.cuenta_contable_codigo;
                    accountingSeat = {
                        id: contabilidad_cuenta_id,
                        cuenta: cuenta_contable,
                        codigo: cuenta_contable_codigo
                    };
                }
                var addOptions = {};
                addOptions = {
                    typeProduct: typeProduct,
                    "id": key_search,
                    "detalle": $scope.producto_object_modal.detalle,
                    "producto_id": $scope.producto_object_modal.id,
                    "cantidad": $scope.producto_object_modal.cantidad, //U
                    "cantidad_unidades": 0, //CU
                    porcentaje_descuento: porcentaje_descuento, //U
                    "descuento": porcentaje_descuento, //U
                    "porcentaje_descuento_unidad": 0, //CU
                    "valor_descuento": 0, //U
                    "valor_descuento_unidad": 0, //CU
                    "precio_unitario": parseFloat($scope.producto_object_modal.precio_venta), //U incluido iva
                    "precio_unitario_view": $scope.getValueCustomer($scope.producto_object_modal.precio_venta), //U incluido iva
                    "precio_unitario_unidad": 0, //CU
//                PARA VERIFICAR SI ES UNIDA/CAJA
//U=UNIDAD VENTA NORMAL
//C=CAJA VENTA CAJA
//CU=CAJA UNIDAD VENTA DE UNIDAD D CAJA.
                    "tipo_gestion": "U",
                    "porcentaje_iva": $scope.producto_object_modal.porcentaje_iva, //ESTO VA PARA CUALQIERA D LOS TIPOS D COMPRA
                    "subtotal": 0,
                    "subtotal_descuento": 0,
                    "subtotal_sin_descuento": 0,
                    "total": 0,
                    "inventario": $scope.producto_object_modal.inventario, //cuanto existe en el inventario tanto sea d tipo caja o unidades lo trabajamos x unidades
                    "row_gestion_id": $scope.producto_object_modal.row_gestion_id, //este es l identificador parent(INVENTARIO)
                    "iva_id": $scope.producto_object_modal.iva_id,
                    "precio_venta": precio_venta,
                    "precio_venta_descuento": 0,
                    "enable_caja": false,
                    "data": array_attributes_producto,
                    "add_data_element_class": true, //para saber qien esta en la gestion,
                    "expandRow": false, //saber si esta expandido,
                    "edit_precio": true,
                    "descuento_unidad": true,
                    "kardex_promedio": $scope.producto_object_modal.valor_kardex_promedio,
                    "ganancia": $scope.producto_object_modal.ganancia,
                    "dataPrices": prices,
                    cccountingSeat: accountingSeat
                };
                $scope.new_data = true;
                $scope.resetDataRow(addOptions, porcentaje_descuento);

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
        $("#modal-gestion").modal('hide');

    }
    $scope.resetDataRow = function (data_row, descuento) {
        data_row.porcentaje_descuento = "96";
        $scope.gridInvoiceOpts.data.push(data_row);
        var key_search = data_row.id;
        $("#codigo_factura").click();
        var row_registro = $scope.getRowData(key_search);
//        console.log(row_registro);
        if (row_registro.key > -1) {
            $scope.gridInvoiceOpts.data[row_registro.key]["porcentaje_descuento"] = descuento;

        }
    }

    $scope.getRowData = function (key_search) {

        var data_detalle = $scope.gridInvoiceOpts.data; //change
        var result = {data: {}, key: -1};
        angular.forEach(data_detalle, function (value, key) {
            var key_producto_id = parseInt(value["id"]);
            if (key_producto_id == parseInt(key_search)) {
                result = {data: value, key: key};
            }

        });
        return result;
    }
    $scope.viewModalProducto = function (data_producto) {//data de l producto

        if (data_producto) {//solo si hay datos al cambiar
//        $scope.model_data_modal.
//                porcentaje_descuento
//cantidad
//precio_unitario precio venta
            $scope.model_data_modal = data_producto;
            $scope.model_data_modal.cantidad = 1;
            $scope.model_data_modal.porcentaje_descuento = 0;
            $scope.modal_title = data_producto.detalle;
            $scope.data_factura_encabezado.producto_data = null;
            $scope.model_data_modal.precio_unitario = parseFloat(data_producto.precio_unitario);
            $scope.model_data_modal.precio_venta = parseFloat(data_producto.precio_venta);
            $("#modal-gestion").modal('show');
        }
    }
    
    
    
}