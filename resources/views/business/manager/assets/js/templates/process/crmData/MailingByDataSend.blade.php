<script type='text/x-template' id='mailing-by-data-send-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-mailing-by-data-send"
                ref="refMailingByDataSendModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="bv-example-row">
                    <div class="content-row-manager-buttons">


                        <button type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success " v-on:click="_saveModel()">
                            <?php echo "{{labelsConfig.buttons.save}}"?>
                        </button>


                    </div>
                </b-container>
                <div class="content-form">
                    <b-row>
                        <b-col md="4">
                            <div class="form-group"

                                 :class="getClassErrorForm('template_id',$v.model.attributes.template_id)">
                                <label
                                    class="form__label " v-html='getLabelForm("template_id")' ></label>
                                <div class="content-element-form">

                                    <select multiple="multiple" id="template_id"
                                            class="form-control m-select2 "
                                            v-initS2Template="{method:_managerS2Templates}"
                                    >
                                    </select>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.template_id.$error">
      <span v-if="!$v.model.attributes.template_id.required">
       <?php  echo "{{model.structure.template_id.required.msj}}"?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="4">
                            <div class="form-group"

                                 :class="getClassErrorForm('all_customers',$v.model.attributes.all_customers)">
                                <label class="form__label " v-html='getLabelForm("all_customers")' ></label>
                                <div class="content-element-form">
                                    <select v-model.trim="$v.model.attributes.all_customers.$model"
                                            v-bind:id="getNameAttribute('all_customers')"
                                            v-bind:name="getNameAttribute('all_customers')"
                                            class="form-control m-input"
                                            @change="_setValueForm('all_customers', $v.model.attributes.all_customers.$model)"
                                    >
                                        <option v-for="(row,index) in model.structure.all_customers.options"
                                                v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.all_customers.$error">
      <span v-if="!$v.model.attributes.all_customers.required">
       <?php  echo "{{model.structure.all_customers.required.msj}}"?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>



                </div>
                <div class="row" v-show="model.attributes.all_customers==0">
                    <div class="col col-md-12">
                        <div class="content-manager-grid">
                            <div class="custom-scroll-admin-grid table-responsive">
                                <table id="mailing-by-data-send-grid"
                                       class="">
                                    <thead>
                                    <tr>
                                        <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                                        <th data-column-id="check-list" data-formatter="check-list-manager"></th>
                                        <th data-column-id="description" data-formatter="description">Descripción</th>


                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </b-modal>


        </div>
    </div>
</script>

