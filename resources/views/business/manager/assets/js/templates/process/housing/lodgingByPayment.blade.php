<script type="text/x-template" id="lodging-by-payment-template">
    <div>
        <b-modal
                hide-footer
                id="modal-lodging-by-payment"
                ref="refLodgingByPaymentModal"
              size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>

            <?php echo '@ok="_saveModal"' ?>
        >
            <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
            </template>
            <div class="d-block ">
                <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                    <b-row v-if="hasPayment">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('way_to_pay',$v.model.attributes.way_to_pay)">

                                <b-form-group v-bind:label="getLabelForm('way_to_pay')">
                                    <b-form-checkbox-group
                                            v-model="$v.model.attributes.way_to_pay.$model"
                                            v-bind:id="getNameAttribute('way_to_pay')"
                                            v-bind:name="getNameAttribute('way_to_pay')"
                                            :options="wayToPayOptions"
                                            :disabled="payment_made"
                                            v-on:change="setValueForm('way_to_pay',$v.model.attributes.way_to_pay.$model)"
                                    ></b-form-checkbox-group>
                                </b-form-group>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.way_to_pay.$error">
                                            <span v-if="!$v.model.attributes.way_to_pay.required">
                                <?php  echo "{{model.structure.way_to_pay.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row v-if="hasPayment && getViewTypeCreditCard(hasPayment , $v.model.attributes.way_to_pay)">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('type_credit_card',$v.model.attributes.type_credit_card)">

                                <b-form-group v-bind:label="getLabelForm('type_credit_card')">
                                    <b-form-checkbox-group
                                            v-model="$v.model.attributes.type_credit_card.$model"
                                            v-bind:id="getNameAttribute('type_credit_card')"
                                            v-bind:name="getNameAttribute('type_credit_card')"
                                            :options="typeCreditCardOptions"
                                            :disabled="payment_made"

                                            v-on:change="setValueForm('type_credit_card',$v.model.attributes.type_credit_card.$model)"
                                    ></b-form-checkbox-group>
                                </b-form-group>

                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_credit_card.$error">
                                            <span v-if="!$v.model.attributes.type_credit_card.required">
                                <?php  echo "{{model.structure.type_credit_card.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                </b-form>


                <button type="button"
                        class="btn btn-danger "
                        v-on:click="_cancel()"
                        >
                    <?php echo "{{labelsConfig.buttons.cancel}}"?>
                </button>


                <button v-if="!payment_made" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{labelsConfig.buttons.save}}"?>
                </button>
            </div>

        </b-modal>


    </div>

</script>