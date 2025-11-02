@include('partials.plugins.resourcesJs',['croppie'=>true])
@include('partials.plugins.resourcesJs',['toast'=>true])
@include('partials.plugins.resourcesJs',['blockUi'=>true])
@include('partials.plugins.resourcesJs',['bootgrid'=>true])
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
        crossorigin="anonymous"></script>

<script type='text/x-template' id='order-payments-manager-template'>
    <div>

        <div class='content-component'>


            <div v-if="configModalViewOrder.viewAllow">
                <view-order-component
                    ref="refViewOrder"
                    :params="configModalViewOrder"
                >
                </view-order-component>
            </div>

            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" ng-if="managerMenuConfig.view">
                            <div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">
                                <a v-if="menu.isUrl"
                                   v-bind:href="menu.url+menu.rowId"
                                   v-init-tool-tip
                                   v-bind:id="'a-menu-'+menu.rowId"
                                   class="btn btn-xs content-manager-buttons-grid__a hola" data-toggle="tooltip"
                                   data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                    <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                                </a>
                                <a v-else
                                   v-init-tool-tip
                                   v-bind:id="'a-menu-'+menu.rowId"
                                   v-on:click="_managerMenuGrid(key, menu)"
                                   class="btn btn-xs content-manager-buttons-grid__a " data-toggle="tooltip"
                                   data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                    <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form__label ">Tipo de Pago</label>
                            <div class="content">
                                <select
                                    v-model.trim="filtersGrid.type_payment_customer"
                                    id="manager_state"
                                    name="type_payment_customer"
                                    class="form-control m-input"
                                    @change="_setValueForm('type_payment_customer')"
                                >
                                    <option v-for="(row,index) in type_payment_customer_data"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4" v-if="filtersGrid.type_payment_customer>-1">
                        <div class="form-group">
                            <label class="form__label ">Estado de Envio</label>
                            <div class="content">
                                <select
                                    v-model.trim="filtersGrid.manager_state"
                                    id="manager_state"
                                    name="manager_state"
                                    class="form-control m-input"
                                    @change="_setValueForm('manager_state')"
                                >
                                    <option v-for="(row,index) in manager_state_data"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <div class="search-manager">
                        <div class="row">
                            <div class="col-md-12 search-manager__actions">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="search-manager__needle">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                            <input v-init-grid-filters="{initMethod:_search}" type="text"
                                                   placeholder="Buscar ....."
                                                   v-model="search.needle"/>
                                        </div>
                                    </div>

                                </div>


                            </div>


                        </div>
                    </div>
                    <table id="order-payments-manager-grid"
                           class=""

                    >
                        <thead>
                        <tr>
                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                            <th data-column-id="description" data-formatter="description">Descripción</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>


        </div>
    </div>
</script>
<script type='text/x-template' id='view-order-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-view-order"
                ref="refViewOrderModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="ViewOrderForm" v-on:submit.prevent="_submitForm">


                            <b-container>
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
                                                <strong>
                                                    Estado/Provincia: </strong> <?php echo '{{rowCurrent.state_province}}'?>
                                                <br>
                                                <strong>
                                                    Dirección:</strong> <?php echo '{{rowCurrent.address_main+ " y "+ rowCurrent.address_secondary}}'?>
                                                <br>
                                                <strong> Ciudad/Pueblo: </strong> <?php echo '{{rowCurrent.city}}'?>
                                                <br>
                                                <strong> Codigo Postal:</strong> <?php echo '{{rowCurrent.zipcode}}'?>
                                                <br>
                                                <abbr
                                                    title="Phone">Phone:</abbr> </strong> <?php echo '{{rowCurrent.phone}}'?>
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
                                                <strong>
                                                    Estado/Provincia:</strong> <?php echo '{{rowCurrent.billing.state_province}}'?>
                                                <br>
                                                <strong>
                                                    Dirección:</strong> <?php echo '{{rowCurrent.billing.address_main+ " y "+ rowCurrent.address_secondary}}'?>
                                                <br>
                                                <strong>Ciudad/Pueblo: </strong> <?php echo '{{rowCurrent.billing.city}}'?>
                                                <br>
                                                <strong> Codigo
                                                    Postal:</strong> <?php echo '{{rowCurrent.billing.zipcode}}'?>
                                                <br>
                                                <strong> <abbr
                                                        title="Phone">Phone:</abbr></strong> <?php echo '{{rowCurrent.billing.phone}}'?>
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
                                                <strong>
                                                    Estado/Provincia:</strong> <?php echo '{{rowCurrent.state_province}}'?>
                                                <br>
                                                <strong>
                                                    Dirección:</strong> <?php echo '{{rowCurrent.address_main+ " y "+ rowCurrent.address_secondary}}'?>
                                                <br>
                                                <strong> Ciudad/Pueblo: </strong> <?php echo '{{rowCurrent.city}}'?>
                                                <br>
                                                <strong> Codigo Postal:</strong> <?php echo '{{rowCurrent.zipcode}}'?>
                                                <br>
                                                <abbr
                                                    title="Phone">Phone:</abbr></strong> <?php echo '{{rowCurrent.phone}}'?>
                                                <br>
                                                <abbr
                                                    title="Email">Email:</abbr> </strong> <?php echo '{{rowCurrent.payer_email}}'?>
                                            </address>
                                        </div>

                                    </div>
                                    <div class="management-data">

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
                                    </div>

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


                            </b-container>


                        </b-form>
                    </div>

                </div>


            </b-modal>


        </div>
    </div>
</script>

<script src="{{ asset($resourcePathServer.'js/frontend/account/orders/PaymentsManager.js')}}"
        type='text/javascript'></script>


<script>
    var $profileConfig = <?php echo json_encode($dataManagerPage['profileConfig'])?>;
    var $initLoad = false;
</script>


<script>

    var appThis = null;
    /*https://codepen.io/laylajune/pen/OXzBWg*/
    var appInit = new Vue(
        {

            created: function () {
                var vmCurrent = this;
                this.$root.$on("_updateParentByChildren", function (emitValue) {
                    vmCurrent._managerTypes(emitValue);

                });
            },
            mounted: function () {

                this.initCurrentComponent();
                var vm = this;
                appThis = this;


            },
            el: '#app-management',
            created: function () {


            },
            data: {


                configDataOrderPaymentsManager: {
                    title: "OrderPaymentsManager",
                    data: [],
                    titleEvent: "",
                    business_id: null
                }


            },
            methods: {
                onListenElementsForm:onListenElementsForm,
                initCurrentComponent: function () {

                }
                ,
                setValuesModelBusiness: function (params) {

                },
                /*---EVENTS CHILDREN to Parent COMPONENTS----*/
                _updateParentByChildren: function (params) {
                    console.log(params);
                }
                , initManagement: function () {

                }

            }
        })
    ;
    appInit.initManagement();
</script>


