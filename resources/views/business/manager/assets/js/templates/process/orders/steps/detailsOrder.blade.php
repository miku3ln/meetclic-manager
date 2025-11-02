<div class="padding-10" v-if="rowCurrent">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-sm-8">

        </div>
        <div class="col-sm-4">
            <div>
                <div>
                    <strong>Codigo Orden :</strong>
                    <span
                        class="pull-right"> #<?php echo '{{rowCurrent.id}}'?> </span>
                </div>
            </div>
            <div>
                <div class="font-md">
                    <strong>Orden Fecha:</strong>
                    <span class="pull-right"> <i
                            class="fa fa-calendar"></i> <?php echo '{{rowCurrent.start}}'?>  </span>
                </div>

            </div>
            <br>

            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4 class="semi-bold">Factura</h4>
            <address>
                <strong
                ><?php echo '{{rowCurrent.name+ " "+ rowCurrent.last_name +" - " +rowCurrent.document }}'?></strong>

                <br>
                <strong> Pais:</strong> <?php echo '{{rowCurrent.country}}'?>
                <br>
                <strong> Estado/Provincia: </strong> <?php echo '{{rowCurrent.state_province}}'?>
                <br>
                <strong>
                    Dirección:</strong> <?php echo '{{rowCurrent.address_main+ " y "+ rowCurrent.address_secondary}}'?>
                <br>
                <strong> Ciudad/Pueblo: </strong> <?php echo '{{rowCurrent.city}}'?>
                <br>
                <strong> Codigo Postal:</strong> <?php echo '{{rowCurrent.zipcode}}'?>
                <br>
                <abbr title="Phone">Phone:</abbr> </strong> <?php echo '{{rowCurrent.phone}}'?>
                <br>
                <abbr
                    title="Email">Email:</abbr> </strong> <?php echo '{{rowCurrent.payer_email}}'?>
            </address>
        </div>
        <div class="col-md-6">
            <h4 class="semi-bold">Direccion de Envio</h4>
            <address v-if="rowCurrent.same_billing_address==0">
                <strong
                ><?php echo '{{rowCurrent.billing.name+ " "+ rowCurrent.billing.last_name + " - "+ rowCurrent.billing.document}}'?></strong>
                <br>

                <strong> Pais:</strong> <?php echo '{{rowCurrent.billing.country}}'?>
                <br>
                <strong> Estado/Provincia:</strong> <?php echo '{{rowCurrent.billing.state_province}}'?>
                <br>
                <strong>
                    Dirección:</strong> <?php echo '{{rowCurrent.billing.address_main+ " y "+ rowCurrent.address_secondary}}'?>
                <br>
                <strong>Ciudad/Pueblo: </strong> <?php echo '{{rowCurrent.billing.city}}'?>
                <br>
                <strong> Codigo Postal:</strong> <?php echo '{{rowCurrent.billing.zipcode}}'?>
                <br>
                <strong> <abbr title="Phone">Phone:</abbr></strong> <?php echo '{{rowCurrent.billing.phone}}'?>
                <br>
                <strong> <abbr
                        title="Email">Email:</abbr></strong> <?php echo '{{rowCurrent.billing.payer_email}}'?>
            </address>
            <address v-else>
                <strong
                ><?php echo '{{rowCurrent.name+ " "+ rowCurrent.last_name + " - "+ rowCurrent.document}}'?></strong>
                <br>

                <strong> Pais:</strong> <?php echo '{{rowCurrent.country}}'?>
                <br>
                <strong> Estado/Provincia:</strong> <?php echo '{{rowCurrent.state_province}}'?>
                <br>
                <strong>
                    Dirección:</strong> <?php echo '{{rowCurrent.address_main+ " y "+ rowCurrent.address_secondary}}'?>
                <br>
                <strong> Ciudad/Pueblo: </strong> <?php echo '{{rowCurrent.city}}'?>
                <br>
                <strong> Codigo Postal:</strong> <?php echo '{{rowCurrent.zipcode}}'?>
                <br>
                <abbr title="Phone">Phone:</abbr></strong> <?php echo '{{rowCurrent.phone}}'?>
                <br>
                <abbr
                    title="Email">Email:</abbr> </strong> <?php echo '{{rowCurrent.payer_email}}'?>
            </address>
        </div>

    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">Cant</th>
            <th>ITEM</th>
            <th>PRICE</th>
            <th>SUBTOTAL</th>
        </tr>
        </thead>
        <tbody v-html="getItems()">

        </tbody>
    </table>

    <div class="invoice-footer">

        <div class="row">

            <div class="col-sm-7">

            </div>
            <div class="col-sm-5">
                <div class="invoice-sum-total pull-right">
                    <h3 class="shipping">
                        <strong>Envio:
                            <span
                                class="">$<?php echo '{{rowCurrent.shipping}}'?></span>
                        </strong>
                    </h3>
                    <h3 class="total">
                        <strong>Total:
                            <span
                                class="text-success"><?php echo '{{rowCurrent.subtotal+rowCurrent.shipping}}'?></span>
                        </strong>
                    </h3>
                </div>
            </div>

        </div>

    </div>
</div>
