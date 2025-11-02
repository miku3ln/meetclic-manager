<div id="content-filtres-data">

    <div id="content-filtres-data-aux">
        <div class="row">
            <div class="col-md-4" id="content-filtres-adicionales">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="content-return">
                            <span id="span-return" data-toggle="tooltip" data-original-title="Regresar" class="return"
                                  ng-click="gestionFactura()"><i class="fa fa-arrow-left" id="i-return"></i></span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-8 text-right" id="sad-meet-maldy">

                <div class="row">

                    <div class="col col-md-3" id="row-btn-gestion-factura">
                        <label id="lbl-tipo-de-pago" class="col col-md-12"
                               ng-if="viewProcessAllow.paymentTypeMix"> <?php echo "{{processInvoiceValidation['invoiceSave']?'Opciones':'Formas de Pago'}}"?></label>
                        <div class="col-md-12" id="content-toogle-type-mixto" ng-if="viewProcessAllow.paymentTypeMix">

                            <div toggle-switch class="switch-danger" id="content-all-formas_pago"
                                 html="true"
                                 on-label='Normal'
                                 off-label='Mixto'
                                 ng-show="!processInvoiceValidation['invoiceSave']"
                                 ng-model="toogleElementsConfigView.show_directo_mixto"
                                 ng-change="_paymentBreakdownType(toogleElementsConfigView.show_directo_mixto)">
                            </div>

                        </div>

                        <div class="btn-group btn-gestion-admin not-view" id="btn-gestion">
                            <button type="button" class="btn btn-default" data-toggle="tooltip"
                                    data-original-title="Imprimir" ng-click="printData()">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>

                    </div>

                    <div class="col col-md-3 " id="content-2fpago" ng-if="viewProcessAllow.paymentType"

                    >
                        <label id="lbl-tipo-de-pago" class="col col-md-12"> Tipo de Pago</label>
                        <div class="col-md-12" id="content-toogle-type-2fpago">
                            <div toggle-switch class="switch-danger"
                                 html="true"
                                 on-label='<i class="glyphicon glyphicon-usd"></i>'
                                 off-label='<i class="glyphicon glyphicon-credit-card"></i>'
                                 ng-show="!processInvoiceValidation['invoiceSave']"
                                 ng-model="toogleElementsConfigView.show_efectivo_tarjeta"
                                 ng-change="_paymentCashCard(toogleElementsConfigView.show_efectivo_tarjeta)">
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-6 " id="content-manager-buttons">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-total-btn-result">
                            <button type="button" ng-disabled="processInvoiceValidation['managerSaveAllow']"
                                    class="btn meet-btn-warning" id="btn-factura-gestion-save"
                                    ng-click="saveInvoice(1)">Pagar
                            </button>
                            <button
                                ng-show="toogleElementsConfigView.show_directo_mixto && toogleElementsConfigView.show_efectivo_tarjeta"
                                type="button"
                                ng-disabled="(processInvoiceValidation['invoiceSave']?true:false)"
                                class="btn meet-btn-error" id="btn-factura-pendiente-gestion"
                                ng-click="savePending(0)">Pendiente
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
