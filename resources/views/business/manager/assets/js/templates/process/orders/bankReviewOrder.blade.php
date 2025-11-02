<script type='text/x-template' id='bank-review-order-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-bank-review-order"
                ref="refBankReviewOrderModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="BankReviewOrderForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form__label ">Verificar</label>
                                            <div class="content">
                                                <select
                                                    v-model.trim="model.attributes.manager_state"
                                                    id="manager_state"
                                                    name="manager_state"
                                                    class="form-control m-input"
                                                >
                                                    <option v-for="(row,index) in manager_state_data"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @include($wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.orders.steps.detailsOrder")


                                <div class="row">
                                    <button type="button"
                                            class="btn btn-success "
                                            v-on:click="_saveModel()">
                                        Realizar Verificación.
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

