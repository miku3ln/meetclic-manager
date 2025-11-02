<div class="tab-pane fade active in factura-data-content" id='factura' ng-show="viewDataOther == true ? false : true">
    <div ng-if="type_disenio == 'autosur'" id="content-data-factura-autosur">
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="row-1-col-1">Cliente:</th>
                            <th class="row-1-col-3"><?php echo '{{print_factura.encabezado.cliente.nombre}}'?></th>
                            <th class="row-1-col-1">R.U.C./C.I.:</th>
                            <th class="row-1-col-2"><?php echo '{{print_factura.encabezado.cliente.ruc_ci}}'?></th>
                        </tr>
                        <tr>
                            <th class="row-1-col-1">Dirección:</th>
                            <th class="row-1-col-3"><?php echo '{{print_factura.encabezado.cliente.direccion}}'?></th>
                            <th class="row-1-col-1">Teléfono:</th>
                            <th class="row-1-col-2"><?php echo '{{print_factura.encabezado.cliente.telefono}}'?></th>
                        </tr>
                        <tr>
                            <th>Fecha:</th>
                            <th><?php echo '{{print_factura.encabezado.cliente.fecha}}'?></th>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="row-1-col-1">Cantidad</th>
                            <th class="row-1-col-4">Descripción</th>
                            <th class="row-1-col-4">Lote Nro</th>
                            <th class="row-1-col-1">P.Unitario</th>
                            <th class="row-1-col-1">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="row in print_factura.detalle" class="tr-detalle-data">
                            <th class="tr-detalle-data-col-1"><?php echo '{{row.cantidad}}'?></th>
                            <th class="tr-detalle-data-col-4"><?php echo '{{row.detalle}}'?></th>
                            <th class="tr-detalle-data-col-2"></th>
                            <th class="tr-detalle-data-col-1"><?php echo '{{row.precio_unitario}}'?></th>
                            <th class="tr-detalle-data-col-1"><?php echo '{{row.total}}'?></th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="row" id="row-content-pie" >

            <div class="col-md-3 not-view " id="col-content-formas-pago" >
                <table  class=" table-print-formas-pago" id="data-table-print-formas-pago">

                    <tbody id="data-table-body-formas-pago">
                        <tr class="tr-formas-pago-data-0">
                            <th class="tr-formas-pago-data-col-1" colspan="2"><label class="lbl-title-gestion"> Formas de Pago</label></th>
                        </tr>
                        <tr class="tr-formas-pago-data-1">
                            <th class="tr-formas-pago-data-col-1"><label class="lbl-title forma-pago"> EFECTIVO</label></th>
                            <th class="tr-formas-pago-data-col-2"><label class="forma-valor"><?php echo '{{print_factura.pie.forma_pagos.efectivo}}'?></label></th>
                        </tr>
                        <tr class="tr-formas-pago-data-2">
                            <th class="tr-formas-pago-data-col-1"><label class="lbl-title forma-pago"> DINERO ELECTRONICO</label></th>
                            <th class="tr-formas-pago-data-col-2"><label class="forma-valor"><?php echo '{{print_factura.pie.forma_pagos.dinero_electronico}}'?></label></th>
                        </tr>
                        <tr class="tr-formas-pago-data-3">
                            <th class="tr-formas-pago-data-col-1"><label class="lbl-title forma-pago"> TARJETA CREDITO/DEBITO</label></th>
                            <th class="tr-formas-pago-data-col-2"><label class="forma-valor"><?php echo '{{print_factura.pie.forma_pagos.tarjeta_credito_debito}}'?></label></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6" id="col-content-desgloce">
                <table  class=" table-print-formas-pago" id="data-table-print-desgloce">

                    <tbody id="data-table-body-desgloce">
                        <tr class="tr-desgloce-data-1">
                            <th class="tr-desgloce-data-col-efectivo"><label class="lbl-efectivo"><?php echo '{{print_factura.pie.forma_pagos.efectivo}}'?> </label></th>
                            <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> SUMAN</label></th>
                            <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{print_factura.pie.desgloce.suman}}'?></label></th>
                        </tr>
                        <tr class="tr-desgloce-data-2">
                            <th class="tr-desgloce-data-col-dinero-electronico"><label class="lbl-dinero-electronico"><?php echo '{{print_factura.pie.forma_pagos.dinero_electronico}} '?></label></th>
                            <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> Descuento</label></th>
                            <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{print_factura.pie.desgloce.descuentos}}'?></label></th>
                        </tr>
                        <tr class="tr-desgloce-data-3">
                            <th class="tr-desgloce-data-col-tarjetas"><label class="lbl-tarjetas"><?php echo '{{print_factura.pie.forma_pagos.tarjeta_credito_debito}}'?> </label></th>
                            <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> Sub Total</label></th>
                            <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{print_factura.pie.desgloce.sub_total}}'?></label></th>
                        </tr>
                        <tr class="tr-desgloce-data-4">
                            <th class="tr-desgloce-data-col-otros"><label class="lbl-tarjetas"><?php echo '{{print_factura.pie.forma_pagos.otros}}'?> </label></th>
                            <th class="tr-desgloce-data-col-1">Iva  <?php echo '{{iva_data.value}}'?> %</th>
                            <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{print_factura.pie.desgloce.iva_config}}'?></label></th>
                        </tr>
                        <tr class="tr-desgloce-data-5">
                            <th class="tr-desgloce-data-col-empty"></th>
                            <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> TOTAL:</label></th>
                            <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{print_factura.pie.desgloce.total}}'?></label></th>
                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <div ng-if="type_disenio == 'disenio2'" id="content-data-disenio2">
        <div class="row">
            <div class="col-md-8">
                <table class="table" id="table-factura-encabezado">
                    <tbody>

                        <tr class="row-1">
                            <td  class="row-1-col-imagen" rowspan="3">
                                <img id='imageid' src='<?php echo $configPartial['resultProcess']['data']['data_empresa']["empresa"]["logo"] ?>'>
                            </td>
                            <td class="row-1-col-2"> Nº Factura <?php echo '{{print_factura.encabezado.factura_no}}'?></td>
                        </tr>
                        <tr class="row-2">
                            <td class="row-2-col-1"><?php echo '{{print_factura.encabezado.cliente.fecha}}'?></td>
                        </tr>
                        <tr class="row-3">
                            <td class="row-3-col-3"><?php echo '{{print_factura.encabezado.cliente.nombre}} '?>  <?php echo '{{print_factura.encabezado.cliente.ruc_ci}}'?></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table" id="tbl-factura-detalle">
                    <thead>
                        <tr class="row-1-head">
                            <th class="row-1-col-1"><div align="center">CANT</div></th>
                            <th class="row-1-col-1"><div align="center">COD</div></th>
                            <th class="row-1-col-3"><div align="center">DETALLE</div></th>
                            <th class="row-1-col-2"><div align="center">P UNI</div></th>
                            <th class="row-1-col-1"><div align="center">P TOT</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="row in print_factura.detalle" class="tr-detalle-data">
                            <th class="tr-detalle-data-col-1"><div align="center"><?php echo '{{row.cantidad}}'?></div></th>
                            <th class="tr-detalle-data-col-1"><div align="center"><?php echo '{{row.codigo}}'?></div></th>
                            <th class="tr-detalle-data-col-3"><div align="justify"><?php echo '{{row.detalle}}'?></div></th>
                            <th class="tr-detalle-data-col-2"><div align="center"><?php echo '{{getValueCustomer(row.precio_unitario)}}'?></div></th>
                            <th class="tr-detalle-data-col-1"><div align="center"><?php echo '{{getValueCustomer(row.total)}}'?></div></th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <br>
        <br>
        <br>

        <div class="row" id="row-content-pie" >
            <table  class=" table-print-formas-pago" id="data-table-print-desgloce">
                <tbody id="data-table-body-desgloce">
                    <tr class="tr-desgloce-data-3">
                        <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> SUBTOTAL</label></th>
                        <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{getValueCustomer(print_factura.pie.desgloce.sub_total)}}'?></label></th>
                    </tr>
                    <tr class="tr-desgloce-data-2">
                        <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> DESCUENTO</label></th>
                        <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{getValueCustomer(print_factura.pie.desgloce.descuentos)}}'?></label></th>
                    </tr>
                    <tr class="tr-desgloce-data-5">
                        <th class="tr-desgloce-data-col-1"><label class="lbl-title desgloce"> TOTAL:</label></th>
                        <th class="tr-desgloce-data-col-2"><label class="desgloce"><?php echo '{{getValueCustomer(print_factura.pie.desgloce.total)}}'?></label></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div  class="tab-pane fade active in factura-data-content"  ng-show="viewDataOther == true ? true : false"  id='factura'>
    <div  ng-show="viewDataPdf">
        <iframe init-pdfelement id="iframe-pdf" class="preview-pane" type="application/pdf" width="100%" height="650" frameborder="0" ></iframe>
    </div>
    <div id="content-data-factura"  ng-show="!viewDataPdf">
        <div class="row" >
            <div class="col-md-12">
                <table  class="table table-print" id="data-table-print">
                    <tbody id="data-table-body" class="data-table-body-print">

                        <tr class="row-init">
                            <td colspan="3" style=""><img id='imageid' src='<?php echo $configPartial['resultProcess']['data']['data_empresa']["empresa"]["logo"] ?>'></td>

                        </tr>
                        <tr class="row-1">
                            <td class="text-left row-1-col-1" style=""><strong>Cliente</strong></td>
                            <td  class="row-1-col-2" style=""><?php echo '{{data_factura_encabezado.cliente_data["nombres_cliente"]}}'?></td>
                            <td class="text-left row-1-col-3" style=""><strong>FECHA:</strong></td>
                            <td class="row-1-col-4" style=""><?php echo $configPartial['resultProcess']['data']['fecha_emision']; ?></td>

                        </tr>
                        <tr class="row-2">
                            <td class="text-left row-2-col-1" style=""><strong>RUC/ID:</strong></td>
                            <td  style="" class="row-2-col-2"><?php echo '{{data_factura_encabezado.cliente_data["identificacion"]}}'?></td>
                            <td class="text-left" style=""></td>
                            <td class="text-left" style=""></td>


                        </tr>

                        <tr class="row-3">
                            <td class="text-left row-3-col-1" style=""><strong>Direccion:</strong></td>
                            <td class="row-3-col-2" style=""><?php echo '{{data_factura_encabezado.cliente_data["direccion"]}}'?></td>
                            <td class="text-left row-2-col-3" style=""><strong>Telf.:</strong></td>
                            <td  class=" row-2-col-4" style=""><?php echo '{{data_factura_encabezado.cliente_data["telefono"]}}'?></td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row" id="informacion-factura-detalle">
            <div class="col col-xs-12 col-sm-12   col-md-12 col-lg-12 ">
                <table  class="table table-print-detalle" id="data-table-print-detalle">
                    <thead class="thead-detalle">
                        <tr class="row-1">
                            <th class="row-1-col-1" >Cantidad</th>
                            <th class="row-1-col-2" >Detalle</th>
                            <th class="row-1-col-3" >Precio</th>
                        </tr>
                    </thead>
                    <tbody id="data-table-body-detalle">
                        <tr ng-repeat="row in gridData.data" class="tr-detalle-data">
                            <th class="tr-detalle-data-col-1"><?php echo '{{row.cantidad}}'?></th>
                            <th class="tr-detalle-data-col-2"><?php echo '{{row.detalle}}'?></th>
                            <th class="tr-detalle-data-col-3"><?php echo '{{getValueCustomer(row.precio_unitario)}}'?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" id="informacion-factura-detalle-descuento">
            <div class="col col-xs-12 col-sm-12   col-md-12 col-lg-12 ">
                <table  class="table-print-descuento" id="data-table-print-encabezado">

                    <tbody id="data-table-body-encabezado">
                        <tr class="row-1">
                            <td  class="row-1-col-1">Subtotal(<?php echo '{{iva_data.value}}'?>%):</td>
                            <td class="row-1-col-2"><?php echo '{{getValueCustomer(data_factura_encabezado.subtotal_iva)}}'?></td>
                        </tr>
                        <tr  class="row-2">
                            <td class="row-2-col-1">Subtotal(0%)</td>
                            <td class="row-2-col-2" ><?php echo '{{getValueCustomer(data_factura_encabezado.subtotal_siniva)}}'?></td>
                        </tr>
                        <tr  class="row-3">
                            <td class="row-3-col-1" >Descuento</td>
                            <td  class="row-3-col-2" ><?php echo '{{getValueCustomer(data_factura_encabezado.valor_descuento)}}'?></td>
                        </tr>
                        <tr  class="row-4">
                            <td class="row-4-col-1" >IVA </td>
                            <td class="row-4-col-2"><?php echo '{{getValueCustomer(data_factura_encabezado.valor_impuestos)}}'?></td>
                        </tr>
                        <tr id="total-encabezado"  class="row-5">
                            <td class="row-5-col-1">TOTAL </td>
                            <td  class="row-5-col-2"><?php echo '{{getValueCustomer(data_factura_encabezado.valor_factura)}}'?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

