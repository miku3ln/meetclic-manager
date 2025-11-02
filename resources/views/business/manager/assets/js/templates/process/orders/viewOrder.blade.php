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
                                @include($wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.steps.detailsOrder")

                            </b-container>


                        </b-form>
                    </div>

                </div>


            </b-modal>


        </div>
    </div>
</script>

