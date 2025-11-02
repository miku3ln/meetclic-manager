<div id="print-data" class="not-view">
    <!--INIT TOTAL PAYMENT-->
    <div class="row " id="informativo_gestion">
        <div class="col col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label id="lbl-pago-factura" class="col col-lg-5 col-md-5  col-sm-12 col-xs-12"> Pago Factura</label>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" id="content-toogle-type-2fpago">
                <input id="span-data"
                       value=" <?php  echo '{{getValueCustomer(data_factura_encabezado.totalConRetencion)}}'?>"
                       ng-disabled="true">
            </div>
        </div>

    </div>
    <!--END TOTAL PAYMENT-->
    <!--INIT MANAGER OPTIONS-->
    @include( $partials . '.wizards.sales.pointOfSale.step2Process.managerOptions',['configPartial'=>$configPartial])

    <div id="content-gestion-procesos-facturas">

        <div id="col-content-gestion-procesos">
            <form id="frm-retenciones" name="gestion_data_frm_retenciones">
                <div id="content-gestion-proceso-retenciones" class="not-view other">
                    <h2 class="title-gestion"><strong class="title_left">Retención</strong><i
                            class="title_rigth"></i></h2>
                    <div class="row">
                        <div class="col col-lg-6 col-md-6 col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="col col-md-12">
                                    <label class=" lbl-frm-factura lbl-gestion-info">
                                        Nº Factura*
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="establecimiento-col-all col col-md-12">
                                    <input id="codigo-factura-gestion" class="form-control"
                                           ng-model="data_codigo_factura"
                                           data-placeholder="Código Factura"
                                           ng-required="true"
                                           ng-disabled="true"
                                    />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-6 col-md-6 col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="col col-lg-5 col-md-5 col-xs-12 col-sm-12 ">
                                    <label class="lbl-frm-factura lbl-gestion-info">
                                        Nº Autorización*
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-lg-7 col-md-7 col-xs-12 col-sm-12">
                                    <div class="establecimiento-col-all "

                                         ng-class="{
                                                        'has-error': (gestion_data_frm_retenciones.no_autorizacion.$error.required && gestion_data_frm_retenciones.no_autorizacion.$touched),
                                                                ''
                                                                :  !(gestion_data_frm_retenciones.no_autorizacion.$error.required && gestion_data_frm_retenciones.no_autorizacion.$touched)}"
                                    >
                                        <input
                                            select-value-element
                                            type="number"
                                            min="0"
                                            ng-change="validateStatePaymentsSalesBuys()"
                                            id="codigo-factura-gestion" class="form-control"
                                            ng-model="data_retenciones.no_autorizacion" name="no_autorizacion"
                                            data-placeholder=" Nº Autorización"
                                            ng-required="true"

                                        />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class=" col-md-6">

                            <div class="row">
                                <div class="col col-lg-4 col-md-4 ">
                                    <label class="col lbl-frm-factura lbl-gestion-info">
                                        Fecha Retención*
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-4">
                                    <p class="input-group" ng-class="{'has-error':(gestion_data_frm_retenciones.fecha_factura.$error.required && gestion_data_frm_retenciones.fecha_factura.$touched),
                                                            }">
                                        <input

                                            select-value-element
                                            ng-change="validateStatePaymentsSalesBuys()"
                                            ng-click="openFin()"
                                            type="text"
                                            class="form-control"
                                            uib-datepicker-popup
                                            placeholder="Fecha Emision *"
                                            ng-model="data_retenciones.fecha_factura"
                                            is-open="popupFin.opened"
                                            datepicker-options="dateOptions"
                                            ng-required="true"
                                            close-text="Close"
                                            name="fecha_factura"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="openFin()">
                                                <i class="far fa-calendar-alt"></i></button>
                                        </span>
                                    </p>
                                    <span class="messages"
                                          ng-show="gestion_data_frm_retenciones.$submitted || gestion_data_frm_retenciones.fecha_factura.$touched">
                                        <span ng-show="gestion_data_frm_retenciones.fecha_factura.$error.required"
                                              class="required ">Campo Requerido.</span>
                                    </span>


                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">

                            <label class="lbl-frm-factura lbl-gestion-info">
                                Nº Retencion*
                            </label>

                        </div>
                    </div>

                    <div class="row establecimiento-col-all "
                         ng-class="{
                                                        'has-error': (gestion_data_frm_retenciones.establecimiento.$error.required && gestion_data_frm_retenciones.establecimiento.$touched)
                                            || (gestion_data_frm_retenciones.punto_emision.$error.required && gestion_data_frm_retenciones.punto_emision.$touched)
                                            || (gestion_data_frm_retenciones.codigo_factura.$error.required && gestion_data_frm_retenciones.codigo_factura.$touched),
                                                                ''
                                                                :  !(gestion_data_frm_retenciones.establecimiento.$error.required && gestion_data_frm_retenciones.establecimiento.$touched)
                                                    || !(gestion_data_frm_retenciones.punto_emision.$error.required && gestion_data_frm_retenciones.punto_emision.$touched)
                                                    || !(gestion_data_frm_retenciones.codigo_factura.$error.required && gestion_data_frm_retenciones.codigo_factura.$touched)
                                                        }">
                        <!--change-->
                        <div class="col-md-3">
                            <input
                                select-value-element
                                name="establecimiento"
                                ng-blur="_validateRetention(false)"
                                class="form-control establecimiento-1" type="text"
                                ng-required="true"
                                maxlength="3"
                                ng-model="data_retenciones.establecimiento"
                                name="establecimiento"
                                ng-pattern="regularPhraseNumberInvoice"
                            />

                        </div>
                        <div class="col-md-3">
                            <input
                                select-value-element
                                name="punto_emision"
                                ng-blur="_validateRetention(false)"
                                class="form-control establecimiento-1" type="text"
                                ng-required="true"
                                maxlength="3"
                                ng-model="data_retenciones.punto_emision" name="punto_emision"
                                ng-pattern="regularPhraseNumberInvoice"
                            />

                        </div>
                        <div class="col-md-6   ">
                            <input select-value-element
                                   ng-blur="_validateRetention(false)"
                                   id="codigo_factura" name="numero_retencion" class="form-control"
                                   ng-model="data_retenciones.numero_retencion"
                                   ng-required="true"
                                   ng-pattern="regularDigits"
                            />

                        </div>
                        <span class="messages"
                              ng-show="gestion_data_frm_retenciones.$submitted || gestion_data_frm_retenciones.codigo_factura.$touched">
                                        <span ng-show="gestion_data_frm_retenciones.codigo_factura.$error.required"
                                              class="required ">Código Retención Requerido.</span>
                                    </span>
                        <span class="messages"
                              ng-show="gestion_data_frm_retenciones.$submitted || gestion_data_frm_retenciones.punto_emision.$touched">
                                        <span ng-show="gestion_data_frm_retenciones.punto_emision.$error.required"
                                              class="required ">Emisión Retención Requerido</span>

                                    </span>
                        <span class="messages"
                              ng-show="gestion_data_frm_retenciones.$submitted || gestion_data_frm_retenciones.establecimiento.$touched">
                                        <span ng-show="gestion_data_frm_retenciones.establecimiento.$error.required"
                                              class="required ">Establecimiento Retenciònn Requerido.</span>


                                    </span>
                        <span
                            ng-show="gestion_data_frm_retenciones.punto_emision.$error.pattern"
                            class="required ">Valor no permitido Punto Emision</span>
                        <span
                            ng-show="gestion_data_frm_retenciones.establecimiento.$error.pattern"
                            class="required ">Valor no permitido Establecimiento</span>
                        <span
                            ng-show="gestion_data_frm_retenciones.numero_retencion.$error.pattern"
                            class="required ">Valor no permitido numero retencion</span>
                    </div>
                    <div class="row ">
                        <div class="col col-lg-6 col-md-6 col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="col col col-md-12">
                                    <label class="lbl-frm-factura lbl-gestion-info">
                                        Tipo Retención*
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col col-md-12">
                                    <input class="select-style" type="hidden"
                                           id="productos-data-info-tipo-retencion"
                                           ui-select2="select2OptionsTipoRI"
                                           ng-model="data_retenciones.TipoRetencion"
                                           data-placeholder="Tipo Retencion"
                                           style="width:250px"
                                           ng-disabled="options.validation_retencion"
                                    />
                                </div>
                            </div>

                        </div>
                        <div class="col col-lg-6 col-md-6 col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="col col-md-12">
                                    <label class="lbl-frm-factura lbl-gestion-info">
                                        Subtipo Retención*
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-12">
                                    <input class="select-style" type="hidden"
                                           id="productos-data-info-subtipo-retencion"
                                           ui-select2="select2OptionsSubTipoRI"
                                           ng-model="data_retenciones.SubTipoRetencion"
                                           data-placeholder="Sub Tipo"
                                           ng-change="CalcularRetencion()"
                                           style="width:250px"
                                           ng-disabled="options.validation_retencion"
                                    />
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row" id="content-row-grid-retenciones" ng-if="managerViewsProcess.step2.retention">
                        <div class="col col-sm-12 col-md-12 col-lg-12">

                            <div id="grid-data-producto" class="ui-grid-row--tax-retention"
                                 ui-grid="gridInvoiceOptsRetenciones" ui-grid-pagination
                                 ui-grid-resize-columns ui-grid-edit ui-grid-cellNav ui-grid-resize-columns
                                 ui.grid.autoResize class="grid">

                            </div>
                        </div>
                    </div>
                    <div class="row " id="content-row-total-retenciones">
                        <div class="col col-md-8">
                            <!--data_factura_encabezado.valor_factura-->
                        </div>

                        <div class="col col-md-4" id="col-detalle-retenciones">
                            <table class="tbl-detaller-procesos">
                                <tbody>
                                <tr class="tr-detalle">
                                    <td class="td-titles">Total Renta</td>
                                    <td class="td-values"><?php  echo '{{getValueCustomer(total_renta)}}'?></td>
                                </tr>
                                <tr class="tr-detalle">
                                    <td class="td-titles">Total IVA</td>
                                    <td class="td-values"><?php  echo '{{getValueCustomer(total_iva)}}'?></td>
                                </tr>
                                <tr class="tr-detalle">
                                    <td class="td-titles">Total</td>
                                    <td class="td-values td-result">
                                        <?php  echo '{{getValueCustomer(data_retenciones.Valor_retencion)}}'?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </form>
            <!-- INIT PAYMENT MIXT-->
            <div id="content-gestion-proceso-pagos-mixtos" ng-if="!toogleElementsConfigView.show_directo_mixto">
                <!-- INIT manager-payment-form -->
                <div id="manager-payment-form">
                    <h2 class="title-gestion"><strong class="title_left">Desgloce de Pago</strong><i
                            class="title_rigth"></i>
                    </h2>
                    <!-- INIT ROW MIXT-->
                    <div class="row">
                        <div class='col col-md-12'>
                            <div class="content-gestion-body">

                                <div class="naked-content-row"></div>

                                <div class="content-forms-manager-mixt-payments">

                                    <div class="form-group not-view">
                                        <div class="col col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                                            <label>Pago:</label>
                                        </div>
                                        <div class="col col-xs-8 col-sm-8 col-md-8 col-lg-8 ">
                                            <div class='col col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='col col-md-10'>
                                                    <input ng-disabled="true" type="text"
                                                           class="form-control"
                                                           id="inputValortotal" placeholder="0.00"
                                                           ng-model='data_factura_encabezado.totalConRetencion'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Tipo de Pago
                                                    <span class='required'>*</span>
                                                </label>

                                                <input class="select-style" type="hidden"
                                                       id="productos-data-info"
                                                       ui-select2="select2OptionsTipopago"
                                                       ng-model="data_entidad.tipo_pagos"
                                                       data-placeholder="Tipo de Pago Devolucion"
                                                       ng-required="true" style="width:250px"
                                                       ng-change="_addDataPayments()"
                                                />

                                            </div>
                                        </div>
                                        <div class="col-md-4"
                                             ng-if="0==getViewTransactionPaymentsForms(data_entidad.tipo_pagos)">
                                            <div class="form-group">
                                                <label class="control-label ">Cuenta Contable
                                                    <span class='required'>*</span>
                                                </label>

                                                <input class="select-style" type="hidden"
                                                       id="productos-data-info"
                                                       ui-select2="select2OptionsCuentas"
                                                       ng-model="data_entidad.cuentas"
                                                       data-placeholder="Cuentas"
                                                       ng-required="true" style="width:250px"
                                                       ng-change="_addValuesPayments(data_entidad.tipo_pagos)"/>

                                            </div>
                                        </div>
                                        <div class="col-md-4"
                                             ng-if="1==getViewTransactionPaymentsForms(data_entidad.tipo_pagos)">
                                            <div class="form-group">
                                                <label class="control-label ">Cuenta Contable
                                                    <span class='required'>*</span>
                                                </label>
                                                <input class="select-style" type="hidden"
                                                       id="productos-data-info"
                                                       ui-select2="select2OptionsCuentas"
                                                       ng-model="data_entidad.cuentas"
                                                       data-placeholder="Cuentas"
                                                       ng-required="true" style="width:250px"
                                                />

                                            </div>
                                        </div>
                                        <div class="col-md-4"
                                             ng-if="2==getViewTransactionPaymentsForms(data_entidad.tipo_pagos)">
                                            <div class="form-group">
                                                <label class="control-label ">Cuenta Contable
                                                    <span class='required'>*</span>
                                                </label>

                                                <input class="select-style" type="hidden"
                                                       id="account-seat-credit-card"
                                                       ui-select2="select2OptionsCuentas"
                                                       ng-model="data_entidad.cuentas"
                                                       data-placeholder="Cuentas"
                                                       ng-required="true" style="width:250px"
                                                       ng-change="_addValuesPayments(data_entidad.tipo_pagos)"/>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row "
                                         ng-if="1==getViewTransactionPaymentsForms(data_entidad.tipo_pagos)">
                                        <!-- INIT BANKS-->
                                        <div class="content-button-add-transaction"
                                             ng-if="getAllowAddTransactionPayments(data_entidad.tipo_pagos) ">
                                            <a
                                                init-tooltip
                                                ng-click="_addValuesPayments(data_entidad.tipo_pagos)"
                                                class="btn btn-xs btn--manager-transaction"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-original-title="Agregar">+
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label required">
                                                    Transacción
                                                    <span class='required'>*</span>
                                                </label>
                                                <select class="form-control" name="transaction_type"
                                                        id="transaction-options"
                                                        ng-model="data_entidad.transaction_type" required>
                                                    <option ng-repeat="option in transactionTypeData"
                                                            value="<?php  echo '{{option.id}}'?>">
                                                        <?php  echo '{{option.text}}'?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    # Documento
                                                    <span class='required'>*</span>
                                                </label>

                                                <input
                                                    select-value-element
                                                    class="form-control"
                                                    type="number"
                                                    ng-model="data_entidad.document_number"
                                                    data-placeholder="#Documento"
                                                    required
                                                />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label required">
                                                    Observaciones
                                                    <span class='required'>*</span>
                                                </label>
                                                <textarea
                                                    select-value-element
                                                    cols="50" rows="3" class="form-control custom-scroll"
                                                    name="details" placeholder="Ingrese la Información."
                                                    ng-model="data_entidad['details']"
                                                    required>

                                                </textarea>
                                            </div>
                                        </div>
                                    </div>   <!-- END BANKS-->
                                </div>

                            </div>

                        </div>

                        <div class='col col-md-12'>

                            <div class="row ">
                                <div class="form-group col col-sm-12 col-md-12 col-lg-12">
                                    <div id="grid1" ui-grid="gridInvoiceConfigPayments" ui-grid-edit ui-grid-cellNav
                                         class="grid">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group ">

                                <div class="col col-sm-6 col-md-4 col-lg-4">

                                </div>
                                <div class="col col-sm-6 col-md-8 col-lg-8">
                                    <div class="row form-group">
                                        <div class="col col-sm-6 col-md-6 col-lg-6">
                                            <label for="inputValortotal">Total</label>
                                        </div>
                                        <div class="col col-sm-6 col-md-6 col-lg-6">
                                            <input ng-disabled="true"
                                                   type="text" class="form-control" id="inputValortotal"
                                                   placeholder="0.00"
                                                   value="<?php  echo '{{getValueCustomer(data_factura_encabezado_pagos.total)}}'?>">
                                        </div>
                                    </div>
                                    <div class="row form-group not-view">
                                        <div class="col col-sm-6 col-md-6 col-lg-6">
                                            <label for="inputValortotal">Valor Total</label>
                                        </div>
                                        <div class="col col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" class="form-control" id="inputValortotal"
                                                   placeholder="0.00"
                                                   value="<?php  echo '{{getValueCustomer(data_factura_encabezado.totalConRetencion)}}'?>">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col col-sm-6 col-md-6 col-lg-6">
                                            <label for="inputValortotal">Diferencia</label>
                                        </div>
                                        <div class="col col-sm-6 col-md-6 col-lg-6">
                                            <input type="text" class="form-control" id="inputValortotal"
                                                   placeholder="0.00"
                                                   ng-disabled="true"
                                                   value="<?php  echo ' {{getValueCustomer(data_factura_encabezado.diferencia)}}'?>"
                                            >

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- INIT ROW MIXT-->
                </div>
                <!-- INIT manager-payment-form -->

            </div>
            <!-- END PAYMENT MIXT-->
        </div>
        <div ng-if="toogleElementsConfigView.show_directo_mixto" class="col-lg-3 col-md-3 col-sm-12 col-xs-12"
             id="content-gestion-factura-result"

        >
            <div id="row-gestion-factura-result">
                <div id="div-gestion-factura-result">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-pago-x">
                            <label id="lbl-factura-pago"
                                   class="col-md-12 lbl-gestion-result lbl-frm-factura">Pago</label>
                            <input class="form-control" id="input-factura-pago-x"
                                   value=" <?php  echo '{{getValueCustomer(data_factura_encabezado.totalConRetencion)}}'?>"
                                   ng-disabled="true"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-dinero-x">
                            <label id="lbl-factura-dinero"
                                   class="col-md-12 lbl-gestion-result lbl-frm-factura">Dinero</label>
                            <input
                                select-value-element
                                class="form-control" id="input-factura-dinero-x" placeholder="0.00"
                                ng-model='data_factura_encabezado.valueReceived' type="number"
                                min="0"
                                ng-blur="_valuePayment()"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-cambio-x">
                            <label id="lbl-factura-cambio"
                                   class="col-md-12 lbl-gestion-result lbl-frm-factura">Cambio</label>
                            <input class="form-control" id="input-factura-cambio-x" placeholder="0.00"
                                   ng-model='data_factura_encabezado.receivedView' ng-disabled="true"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-cambio-x"
                             ng-show="toogleElementsConfigView['showValidRetencion']">
                            <label id="lbl-factura-cambio" class="col-md-12 lbl-gestion-result lbl-frm-factura">Pago
                                Total</label>
                            <input class="form-control" id="input-factura-cambio-x" placeholder="0.00"
                                   value=" <?php  echo '{{getValueCustomer(data_factura_encabezado.totalConRetencion)}}'?>"
                                   ng-disabled="true"/>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="row  not-view" id="manager-print">
        <div class="col col-sm-12 col-md-12 col-lg-12" id="content-gestion-facturacion-print">
            @include( $partials . '.wizards.sales.pointOfSale.step2Process.print_data',['configPartial'=>$configPartial])

        </div>
    </div>
</div>
