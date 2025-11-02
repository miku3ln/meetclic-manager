<script type='text/x-template' id='deliver-order-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-deliver-order"
                ref="refDeliverOrderModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="DeliverOrderForm" v-on:submit.prevent="_submitForm">
                            <b-container>

                                @include($wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.steps.detailsOrder")


                                <div class="row">
                                    <button type="button"
                                            class="btn btn-success "
                                            v-on:click="_saveModel()">
                                        Realizar Entrega.
                                    </button>

                                </div>

                            </b-container>

                        </b-form>
                    </div>

                </div>


            </b-modal>


        </div>
    </div>
</script>

