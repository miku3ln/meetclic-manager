<script type="text/x-template" id="management-form-share-template">
    <div>
        <b-modal
            hide-footer
            id="modal-management-form-share"
            ref="refManagementFormShareModal"
            size="md"
        <?php echo '@show="_showModal"'; ?>
            <?php echo '@hidden="_hideModal"'; ?>


        >
            <template slot="modal-title">
                <label v-html="labelsConfig.title"></label>
            </template>
            <div class="form-share-content" v-show="managementViews.managementForm">
                <b-form id="ManagementFormEvent" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <b-row>

                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('number_phone',$v.model.attributes.number_phone)">
                                    <label class="form__label "><?php echo '{{ getLabelForm("number_phone") }}'; ?></label>
                                    <div class="content-element-form">
                                        <input
                                                v-model.trim="$v.model.attributes.number_phone.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('number_phone')"
                                                v-bind:name="getNameAttribute('number_phone')"
                                                placeholder='Incluir el codigo del pais 593969143060'
                                                class="form-control m-input"
                                                @change="_setValueForm('number_phone', $v.model.attributes.number_phone.$model)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.number_phone.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>
                        </b-container>

                        <button type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success btn--custom btn--form "
                        v-on:click="_saveModel()">
                    <?php echo '{{ labelsConfig.buttons.manager }}'; ?>    </button>
                    <template #modal-footer>
                        <div class="w-100">
                          <p class="float-left">Modal Footer Content</p>
                          <b-button
                            variant="primary"
                            size="sm"
                            class="float-right"
                            @click="show=false"
                          >
                            Close
                          </b-button>
                        </div>
                      </template>
                </b-form>


            </div>

        </b-modal>


    </div>

</script>
