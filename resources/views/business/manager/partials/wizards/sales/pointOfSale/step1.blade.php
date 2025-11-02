@include( $partials . '.wizards.sales.pointOfSale.assets.step1PricesManager',['configPartial'=>$configPartial])

<div class="data-messages-errors" ng-if="!allowViewManagement.allow">
    <span>
         <?php echo '{{allowViewManagement.msg}}' ?>
    </span>
</div>
<div id="content-data-rows" ng-show="allowViewManagement.allow">
    <form name="gestion_data_frm" class="meet-form form-horizontal " id="gestion_data_frm">
        <input id="productos-data-info" class="not-view"
               ng-model="exist_data"
               data-placeholder="VERIFICACION SI EXISTE DATOS"
               ng-required="true"/>

        <div class="row">
            <div class="col-md-6 col-sm-12" id="factura-col-encabezado-cliente">
                <div class="row">
                    <!--change-->
                    <div class="col-md-11" id="content-cliente">
                        <div class="form-group" ng-class="{'has-error': (formManagerModal.proveedor_data.$error.required && formManagerModal.proveedor_data.$touched),
                                                                '': !(formManagerModal.proveedor_data.$error.required && formManagerModal.proveedor_data.$touched)
                                                        }">
                            <div class="col-md-12">
                                <!--change-->
                                <input class="select-style" type="hidden" id="productos-cliente-info"
                                       ui-select2="select2OptionsClientesId"
                                       ng-change="setDataCliente()"
                                       ng-model="data_factura_encabezado.cliente_data"
                                       data-placeholder="Seleccione un Cliente"
                                       ng-required="true" style="width:250px"
                                       name="proveedor_data"/>
                                <span class="messages"
                                      ng-show="formManagerModal.$submitted || formManagerModal.proveedor_data.$touched">
                                <span ng-show="formManagerModal.proveedor_data.$error.required" class="required ">Campo Requerido.</span>
                            </span>

                                <?php
                                $btn_create = "add-cliente-btn";
                                ?>
                                <?php
                                $action_name_gestion = "action_cliente_createCliente";
                                if (true) { ?>
                                <a class="btn btn-xs add-data-row" id="<?php echo "add-cliente-btn"; ?>"
                                   data-toggle="tooltip" data-placement="top" data-original-title="Agregar Cliente"
                                >
                                <span class="fa fa-plus">
                                </span>
                                </a>
                                <?php } ?>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 information-customer" ng-show="viewInformationCustomer">
                        <div class="content-details">
                            <?php
                            $btn_create = "update-customer-btn";
                            ?>
                            <?php
                            $action_name_gestion = "action_cliente_updateCliente";
                            if (true) { ?>
                            <a class="btn btn-xs add-data-row" id="<?php echo $btn_create; ?>"
                               data-toggle="tooltip" data-placement="top" data-original-title="Actualizar Cliente"
                               ng-show="viewInformationCustomer"
                               ng-click="_updateCustomer()"
                            >
                                <span class="far fa-edit">

                                </span>
                            </a>


                            <?php } ?>
                            <div class="content-details__row">
                                <div class="inline  content-details__title">
                                    Dirección:
                                </div>
                                <div class="inline  content-details__value">
                                    <?php echo ' {{data_factura_encabezado.cliente_data.information.address.value}}';?>
                                </div>
                            </div>
                            <div class="content-details__row">
                                <div class="inline  content-details__title">
                                    Teléfono:
                                </div>
                                <div class="inline  content-details__value">
                                    <?php echo '{{data_factura_encabezado.cliente_data.information.phone.value}}';?>
                                </div>
                            </div>
                            <div class="content-details__row">
                                <div class="inline  content-details__title">
                                    Correo Electrónico:
                                </div>
                                <div class="inline  content-details__value">
                                    <?php echo '{{data_factura_encabezado.cliente_data.information.mail.value}}';?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class=" col-md-6 col-sm-12 col-xs-12" id="factura-col-encabezado-informacion">

                <div class="row">
                    <div class="col-lg-5 col-md-5 col-xs-12 col-sm-12 ">
                        <label class="lbl-frm-factura lbl-gestion-info">
                            Fecha de Emisión*
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="content-all-fecha">

                        <p class="input-group" ng-class="{'has-error':(formManagerModal.fecha_factura.$error.required && formManagerModal.fecha_factura.$touched),
                                                            }">
                            <input ng-click="openInicio()" type="text" class="form-control"
                                   select-value-element
                                   placeholder="Fecha Emision *"
                                   uib-datepicker-popup ng-model="data_factura_encabezado.fecha_factura"
                                   is-open="popupInicio.opened" datepicker-options="dateOptions" ng-required="true"
                                   close-text="Close" name="fecha_factura"/>
                            <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openInicio()">
                                        <i class="far fa-calendar-alt"></i></button>
                                </span>

                        </p>
                        <span class="messages"
                              ng-show="formManagerModal.$submitted || formManagerModal.fecha_factura.$touched">
                                <span ng-show="formManagerModal.fecha_factura.$error.required" class="required ">Campo Requerido.</span>
                            </span>
                    </div>
                    <div class="col-md-6"
                         ng-if="managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['view']">
                        <label
                            class="lbl-manager-traffic-light">
                            <?php echo "{{managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['label']}}"?>
                            :
                            <span
                                class="lbl-manager-traffic-light__days">
<?php echo "{{managerInvoiceHeader['authorizationSettingInvoiceTrafficLight']['value']}}"?></span></label>
                    </div>
                </div>

                <div id="content-all-establecimiento">
                    <div class="row">
                        <div class=" col-lg-5 col-md-5 col-xs-12 col-sm-12 ">
                            <label class="lbl-frm-factura lbl-gestion-info">
                                Nº de Factura*
                            </label>
                        </div>
                    </div>
                    <div class="row" ng-class="{
                                                        'has-error': (formManagerModal.establecimiento.$error.required && formManagerModal.establecimiento.$touched)
                                    || (formManagerModal.punto_emision.$error.required && formManagerModal.punto_emision.$touched)
                                    || (formManagerModal.codigo_factura.$error.required && formManagerModal.codigo_factura.$touched),
                                                                ''
                                                                :  !(formManagerModal.establecimiento.$error.required && formManagerModal.establecimiento.$touched)
                                            || !(formManagerModal.punto_emision.$error.required && formManagerModal.punto_emision.$touched)
                                            || !(formManagerModal.codigo_factura.$error.required && formManagerModal.codigo_factura.$touched)
                                                        }">
                        <div class="col-md-3 establecimiento-col1">
                            <input ng-blur="checkInvoice()"
                                   select-value-element
                                   class="form-control establecimiento-1" type="text" ng-required="true"
                                   maxlength="3"
                                   ng-model="data_factura_encabezado.establecimiento" name="establecimiento"
                                   ng-pattern="regularPhraseNumberInvoice"
                                   ng-disabled="managerInvoiceHeader['establishment_number']['disabled']"
                            />
                            <span class="messages"
                                  ng-show="formManagerModal.$submitted || formManagerModal.establecimiento.$touched">
                                    <span ng-show="formManagerModal.establecimiento.$error.required" class="required ">Campo Requerido.</span>
                                       <span
                                           ng-show="formManagerModal.establecimiento.$error.pattern"
                                           class="required ">Valor no permitido</span>
                                </span>
                        </div>
                        <div class="col-md-3  establecimiento-col2">
                            <input ng-blur="checkInvoice()"
                                   select-value-element
                                   class="form-control establecimiento-1" type="text" ng-required="true"
                                   maxlength="3"
                                   ng-model="data_factura_encabezado.punto_emision" name="punto_emision"
                                   ng-pattern="regularPhraseNumberInvoice"
                                   ng-disabled="managerInvoiceHeader['pointEstablishment']['disabled']"

                            />
                            <span class="messages"
                                  ng-show="formManagerModal.$submitted || formManagerModal.punto_emision.$touched">
                                    <span ng-show="formManagerModal.punto_emision.$error.required" class="required ">Campo Requerido.</span>
                                    <span
                                        ng-show="formManagerModal.establecimiento.$error.pattern"
                                        class="required ">Valor no permitido</span>
                                </span>
                        </div>
                        <div class="col-md-6 establecimiento-col3"
                             ng-if="managerInvoiceHeader['invoice_code'].view">
                            <input ng-blur="checkInvoice()" id="codigo_factura" name="codigo_factura"
                                   class="form-control"
                                   select-value-element
                                   ng-model="data_factura_encabezado.codigo_factura"
                                   ng-required="true"
                                   ng-pattern="regularDigits"
                            />
                            <span class="messages"
                                  ng-show="formManagerModal.$submitted || formManagerModal.codigo_factura.$touched">
                                    <span ng-show="formManagerModal.codigo_factura.$error.required" class="required ">Campo Requerido.</span>
                                             <span
                                                 ng-show="formManagerModal.codigo_factura.$error.pattern"
                                                 class="required ">Valor no permitido</span>
                                </span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="establecimiento-col-all">
                            <!--change-->

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div id="content-row-filtro">
            @if($configPartial['resultProcess']['data']['allProcess']['salesInventory']['retentions'])
                <div class="row">
                    <div class="col-md-3" id="content-all-retenciones">
                        <div class="row" id="content-retencion-row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 ">
                                <label id="lbl-retencion"
                                       class=" lbl-gestion-info lbl-frm-factura"
                                       for="select-">Retención<span class="required"></span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 ">
                                <input id="has-retencion"
                                       class=" check-factura-retencion" type="checkbox"
                                       ng-change="changeRetencion(data_factura_encabezado.retencion)"
                                       ng-model="data_factura_encabezado.retencion">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row" id="content-data-cliente-producto">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 gestion-productos-servicios">
                    @if($configPartial['resultProcess']['data']['allProcess']['salesInventory']['discount'])

                        <div class="row " id="content-all-descuento">
                            <label id="lbl-descuento"
                                   class="col-lg-3 col-md-3  col-sm-12 col-xs-12 lbl-frm-factura lbl-gestion-info">Descuento</label>
                            <!--change-->
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-6" id="toogle-type-descuento">
                                <div toggle-switch class="switch-danger"
                                     html="true"
                                     on-label="Factura"
                                     off-label='Productos'
                                     ng-model="data_factura_encabezado.type_descuento_factura"
                                     ng-change="_typeDescuentoFactura()">
                                </div>
                            </div>
                            <!--change-->
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6" id="type-descuento-gestion">
                                <div toggle-switch class="switch-danger"
                                     html="true"
                                     on-label="%"
                                     off-label='$'
                                     ng-model="data_factura_encabezado.type_descuento" ng-change="_typeDescuento()">
                                </div>
                            </div>
                            <!--change-->
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6" id="input-value-descuento">
                                <input id="value-descuento-gestion" class="form-control gestion-data"
                                       min="  <?php echo '{{min_data}}'?>"
                                       max="  <?php echo '{{max_data}}'?>"
                                       ng-model="data_factura_encabezado.type_valor_descuento"
                                       type="number"
                                       ng-change="type_valor_descuentoChange()"/>
                            </div>
                        </div>
                    @endif
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 gestion-productos-servicios">
                    <div class="row">

                        <div class="col-md-3">
                            <div toggle-switch class="switch-danger"
                                 html="true"
                                 on-label="P"
                                 off-label='S'
                                 ng-model="typeProduct" ng-change="_typeProduct()">
                            </div>
                        </div>
                        <div class="col-md-9" id="content-all-productos">

                            <div class="col-md-10" id="content-producto-gestion">
                                <input ng-click="addDataProducto()" class=" select-style--invoice" type="hidden"
                                       id="productos-data"
                                       ui-select2="select2OptionsProductoId"
                                       ng-model="data_factura_encabezado.producto_data"
                                       data-placeholder="Seleccione un Producto"
                                       style="width:250px"/>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row" id="table-productos">

            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="col-content-factura-detalle">
                <div id="grid-data" class="ui-grid-cell--invoice" ui-grid="gridInvoiceOpts" ui-grid-edit ui-grid-cellNav
                     ui-grid-resize-columns
                     ui-grid-pinning
                     ui-grid-expandable class="grid  xywer-tbl-angular">
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="content-gestion-factura">
                <div class="row" id="row-gestion-factura">
                    <div id="div-gestion-factura">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-subtotal-x">
                            <label id="lbl-factura-subtotal-x" class="col-md-12 lbl-gestion-result lbl-frm-factura">Subtotal
                                ( <?php echo '{{iva_data.value}}'?>%)</label>
                            <input class="form-control" id="input-factura-subtotal-x"
                                   ng-model="totalInvoice.subtotalX" ng-readonly="true"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-subtotal">
                            <label id="lbl-factura-subtotal" class="col-md-12 lbl-gestion-result lbl-frm-factura">Subtotal
                                (0%)</label>
                            <input class="form-control" id="input-factura-subtotal"
                                   ng-model="totalInvoice.subtotal0" ng-readonly="true"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-descuento">
                            <label id="lbl-factura-descuento"
                                   class="col-md-12 lbl-gestion-result lbl-frm-factura">Descuento</label>
                            <input class="form-control" id="input-factura-descuento"
                                   ng-model="totalInvoice.discount" ng-readonly="true"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-config">
                            <label id="lbl-factura-iva-config" class="col-md-12 lbl-gestion-result lbl-frm-factura">Iva
                                <?php echo '{{iva_data.value}}'?>%</label>
                            <input class="form-control" id="input-factura-config"
                                   ng-model="totalInvoice.tax" ng-readonly="true"/>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-total">
                            <label id="lbl-factura-total"
                                   class="col-md-12 lbl-gestion-result lbl-frm-factura">Total </label>
                            <input class="form-control" id="input-factura-total"
                                   ng-model="totalInvoice.total" ng-readonly="true"/>
                        </div>
                    </div>
                </div>
                <div class="row" id="row-factura-total">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-factura-total-btn">
                        <button
                            id="checkIn"
                            class="btn meet-btn-error" type="button"
                            data-ng-disabled="!validManagerStep1.allReady"

                            ng-click="gestionFactura()">
                            Facturar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
