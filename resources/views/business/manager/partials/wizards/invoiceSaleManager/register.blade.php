<div id="content-data-rows content-data-rows--invoice">
    <div class="row">
        <div class=" col-md-4 col-sm-12">
            <div class="form-group" ng-class="getErrorForm('register_manager_date')">
                <label class="lbl-frm-invoice lbl-manager-info">
                    Fecha de Emisión*
                </label>
                <p class="input-group">
                    <input ng-click="openDateInvoice()" type="text" class="form-control input--invoice"
                           select-value-element
                           ng-change="_dateInvoice(model.attributes.register_manager_date)"
                           placeholder="Fecha Emision *"
                           uib-datepicker-popup ng-model="model.attributes.register_manager_date"
                           is-open="popupDateInvoice.opened" datepicker-options="dateOptions" ng-required="true"
                           close-text="Close" name="register_manager_date"/>
                    <span class="input-group-btn input-group-btn--invoice">
                                    <button type="button" class="btn btn-default" ng-click="openDateInvoice()">
                                        <i class="fas fa-calendar-alt"></i></button>
                                </span>
                    <label for=""
                           class="lbl-hours"><?php echo "{{model.attributes.register_manager_date_hours}}"?></label>
                </p>

                <span class="messages"
                      ng-show="formManager.$submitted || formManager.register_manager_date.$touched">
                        <span ng-show="formManager.register_manager_date.$error.required" class="required ">Campo Requerido.</span>

                    </span>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-7 col-sm-12">
            <div class="form-group"
                 ng-class="getErrorForm('customer_id_data')">
                <input
                    class="select-style select-style--customer"
                    type="hidden"
                    id="customer-id-data"
                    ui-select2="s2CustomerIdData"
                    ng-model="model.attributes.customer_id_data"
                    data-placeholder="Seleccione un Cliente"
                    ng-required="true" style="width:250px"
                    name="customer_id_data"/>
                <span class="messages"
                      ng-show="formManager.$submitted || formManager.customer_id_data.$touched">
                  <span ng-show="formManager.customer_id_data.$error.required" class="required ">
                      Campo Requerido.
                  </span>
                </span>
                <a class="btn btn-xs add-data-row"
                   data-toggle="tooltip"
                   data-placement="top"
                   data-original-title="Agregar Cliente"
                   init-tooltip
                   ng-click="_addCustomer()"
                >
                    <span class="fa fa-plus"></span>
                </a>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group"
                 ng-class="getErrorForm('description')">
                <label class="lbl-frm-invoice lbl-manager-info">
                    Descripcion del Trabajo*
                </label>
                <textarea
                    rows="4" class="form-control"
                    ng-model="model.attributes.description"
                    required
                    name="description"
                    select-value-element
                >

         </textarea>
                <span class="messages"
                      ng-show="formManager.$submitted || formManager.description.$touched">
                        <span ng-show="formManager.description.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
            </div>
        </div>
    </div>
    <div id="content-row-filters">
        <div class="row">
            <div class="form-group  col-md-3 col-sm-12">
                <label for="repair_product_by_business_id_data">Partes/Otros *</label>

                <input
                    class="select-style select-style--customer"
                    type="hidden"
                    id="repair-product-by-business-id-data"
                    ui-select2="s2RepairProductByBusinessIdData"
                    ng-model="model.addParts.repair_product_by_business_id_data"
                    data-placeholder="Seleccion Parte/Otros."
                    name="repair_product_by_business_id_data"/>

                <span class="messages"
                      ng-show="formManager.$submitted || formManager.repair_product_by_business_id_data.$touched">
                        <span ng-show="formManager.repair_product_by_business_id_data.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
            </div>

            <div class="form-group col-md-2 col-sm-12">
                <label for="quantity">Cantidad</label>
                <input

                    type="number" class="form-control input--invoice"
                    placeholder="Cantidad"
                    min='1'
                    ng-model="model.addParts.quantity"
                    name="quantity"/>
                <span class="messages"
                      ng-show="formManager.$submitted || formManager.quantity.$touched">
                    <span ng-show="formManager.quantity.$error.required" class="required ">Campo Requerido.</span>

                </span>
            </div>

            <div class="form-group  col-md-3 col-sm-12">
                <label for="product_trademark_id_data">Marca*</label>
                <input
                    class="select-style select-style--trademark"
                    type="hidden"
                    id="product-trademark-id-data"
                    ui-select2="s2ProductTrademarkIdData"
                    ng-model="model.addParts.product_trademark_id_data"
                    data-placeholder="Seleccion Marca."
                    name="product_trademark_id_data"/>

                <span class="messages"
                      ng-show="formManager.$submitted || formManager.product_trademark_id_data.$touched">
                    <span ng-show="formManager.product_trademark_id_data.$error.required" class="required ">Campo Requerido.</span>

                </span>

            </div>
            <div class="form-group  col-md-3 col-sm-12">
                <label for="product_trademark_id_data">Color*</label>

                <input
                    class="select-style select-style--color"
                    type="hidden"
                    id="product-color-id-data"
                    ui-select2="s2ProductColorIdData"
                    ng-model="model.addParts.product_color_id_data"
                    data-placeholder="Seleccion Color."
                    name="product_color_id_data"/>
                <span class="messages"
                      ng-show="formManager.$submitted || formManager.product_color_id_data.$touched">
                    <span ng-show="formManager.product_color_id_data.$error.required"
                          class="required ">Campo Requerido.</span>

                </span>
            </div>
            <div class="data" ng-if='viewAddParts()'>
                <a class="btn btn-xs add-data-row"
                   data-toggle="tooltip"
                   id="add-parts"
                   data-placement="top"
                   data-original-title="Agregar Parte"
                   init-tooltip
                   ng-click="_addParts(true)"
                >
                    <span class="fa fa-plus"></span>
                </a>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-9">
            <div id="grid-data" class="ui-grid-cell--invoice" ui-grid="gridInvoiceOpts" ui-grid-edit ui-grid-cellNav
                 ui-grid-resize-columns
                 ui-grid-pinning
                 ui-grid-expandable class="grid  xywer-tbl-angular">
            </div>
        </div>
        <div class="col-md-3">
            <div class="row" id="row-manager-invoice">
                <div id="div-manager-invoice">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-invoice-subtotal" ng-if="false">
                        <label id="lbl-invoice-subtotal" class="col-md-12 lbl-manager-result lbl-frm-invoice">Subtotal
                            (0%)</label>
                        <input class="form-control" id="input-invoice-subtotal"
                               ng-model="totalInvoice.subtotal0" ng-readonly="true"/>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-invoice-discount" ng-if="false">
                        <label id="lbl-invoice-discount"
                               class="col-md-12 lbl-manager-result lbl-frm-invoice">Descuento</label>
                        <input class="form-control" id="input-invoice-discount"
                               ng-model="totalInvoice.discount" ng-readonly="true"/>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-invoice-total">
                        <label id="lbl-invoice-total"
                               class="col-md-12 lbl-manager-result lbl-frm-invoice">Valor </label>
                        <input class="form-control" id="input-invoice-total" min="1" type="number"
                               ng-blur="_resultsTotal()"
                               ng-model="totalInvoice.total" select-value-element ng-required="true"/>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-invoice-subtotal-x"
                         ng-if="model.attributes.type_invoice == '1'">
                        <label id="lbl-invoice-subtotal-x" class="col-md-12 lbl-manager-result lbl-frm-invoice">Subtotal
                            (<?php echo "{{tax_data.value}}" ?>%)</label>
                        <input class="form-control" id="input-invoice-subtotal-x"
                               ng-model="totalInvoice.subtotalX" ng-readonly="true"/>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-advance-total">
                        <label id="lbl-advance-total"
                               class="col-md-12 lbl-manager-result lbl-frm-invoice">Anticipo </label>
                        <input class="form-control" id="input-advance-total" type="number" ng-blur="_resultsTotal()"
                               select-value-element
                               min="0" max="<?php echo "{{totalInvoice.total}}"?> " ng-model="totalInvoice.advance"
                               ng-required="true"/>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-totalInvoice-total">
                        <label id="lbl-invoice-totalInvoice"
                               class="col-md-12 lbl-manager-result lbl-frm-totalInvoice">Total </label>
                        <input class="form-control" id="input-totalInvoice-total"
                               ng-model="totalInvoice.invoice" ng-readonly="true"/>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-balance-total">
                        <label id="lbl-invoice-balance"
                               class="col-md-12 lbl-manager-result lbl-frm-balance">Saldo </label>
                        <input class="form-control" id="input-invoice-balance"
                               ng-model="totalInvoice.balance" ng-readonly="true"/>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group"
                 ng-class="getErrorForm('observations_fix')">
                <label class="lbl-frm-invoice lbl-manager-info">
                    Observaciones
                </label>
                <textarea
                    rows="4" class="form-control"
                    ng-model="model.attributes.observations_fix"

                    name="observations_fix"
                    select-value-element
                >

         </textarea>
                <span class="messages"
                      ng-show="formManager.$submitted || formManager.observations_fix.$touched">
                        <span ng-show="formManager.observations_fix.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
            </div>
        </div>
    </div>
</div>

