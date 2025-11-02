<script type='text/x-template' id='treatment-by-payment-template'>
    <div>

        <div class='content-component'>

            <b-container class="container-manager-buttons-process">

                <div class="content-row-manager-buttons-process">
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?>    </button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>

                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                            <menu-admin-grid
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig">

                            </menu-admin-grid>


                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-form" v-if="showManager">
                <div class="d-block ">
                    <b-form id="treatmentByPaymentForm" v-on:submit.prevent="_submitForm">


                        <b-container>
                            <input v-model="model.attributes.id" type="hidden"
                                   v-bind:id="getNameAttribute('id')"
                                   v-bind:name="getNameAttribute('id')"
                            >
                            <b-row>
                                <b-col md="4">
                                    <div class="form-group"

                                         :class="getClassErrorForm('treatment_by_breakdown_payment_id_data',$v.model.attributes.treatment_by_breakdown_payment_id_data)">
                                        <label
                                            class="form__label " v-html='getLabelForm("treatment_by_breakdown_payment_id_data")' ></label>
                                        <div class="content-element-form">
                                            <input
                                                v-model="$v.model.attributes.treatment_by_breakdown_payment_id_data.model"
                                                type="hidden"
                                                v-bind:id="getNameAttribute('treatment_by_breakdown_payment_id_data')"
                                                v-bind:name="getNameAttribute('treatment_by_breakdown_payment_id_data')"
                                                @change="_setValueForm('treatment_by_breakdown_payment_id_data', $v.model.attributes.treatment_by_breakdown_payment_id_data.$model)"
                                            >
                                            <select id="treatment_by_breakdown_payment_id_data"
                                                    class="form-control m-select2 "
                                                    v-initS2TreatmentByBreakdownPayment="{rowId:model.attributes.id,_managerS2TreatmentByBreakdownPayment:_managerS2TreatmentByBreakdownPayment}"
                                            >
                                            </select>
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.treatment_by_breakdown_payment_id_data.$error">
      <span v-if="!$v.model.attributes.treatment_by_breakdown_payment_id_data.required">
       <?php  echo "{{model.structure.treatment_by_breakdown_payment_id_data.required.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>
                                <b-col md="4">
                                    <div class="form-group"

                                         :class="getClassErrorForm('payment_date_current',$v.model.attributes.payment_date_current)">
                                        <label
                                            class="form__label " v-html='getLabelForm("payment_date_current")' ></label>
                                        <div class="content-element-form">
                                            <input
                                                v-model.trim="$v.model.attributes.payment_date_current.$model"
                                                v-bind:id="getNameAttribute('payment_date_current')"
                                                v-bind:name="getNameAttribute('payment_date_current')"
                                                class="form-control m-input"
                                                @change="_setValueForm('payment_date_current', $v.model.attributes.payment_date_current.$model)"
                                                type="date"
                                                disabled
                                            />
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.payment_date_current.$error">
      <span v-if="!$v.model.attributes.payment_date_current.required">
       <?php  echo "{{model.structure.payment_date_current.required.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="12">
                                    <div class="form-group"

                                         :class="getClassErrorForm('details',$v.model.attributes.details)">
                                        <label class="form__label " v-html='getLabelForm("details")' ></label>
                                        <div class="content-element-form">
<textarea
    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.details.$model"
    v-bind:id="getNameAttribute('details')"
    v-bind:name="getNameAttribute('details')"
    @change="_setValueForm('details', $v.model.attributes.details.$model)"
    v-focus-select
></textarea>
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.details.$error">
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>
                            </b-row>
                        </b-container>


                    </b-form>
                </div>

            </div>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="treatment-by-payment-grid" v-init-grid="{initMethod:_initGridCurrent,model:model}"
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

