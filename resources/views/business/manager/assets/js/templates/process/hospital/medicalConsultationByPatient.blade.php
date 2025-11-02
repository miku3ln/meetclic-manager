<script type='text/x-template' id='medical-consultation-by-patient-template'>
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
                        <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?></button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?></button>

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

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="medical-consultation-by-patient-grid"
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
            <div class="content-form" v-if="showManager">
                <b-form id="medicalConsultationByPatientForm" v-on:submit.prevent="_submitForm">

                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4" v-if="false">
                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.status.$model"
                                                v-bind:id="getNameAttribute('status')"
                                                v-bind:name="getNameAttribute('status')"
                                                class="form-control m-input"
                                                @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.status.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php  echo "{{model.structure.status.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('payment_state',$v.model.attributes.payment_state)">
                                    <label class="form__label " v-html='getLabelForm("payment_state")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.payment_state.$model"
                                                v-bind:id="getNameAttribute('payment_state')"
                                                v-bind:name="getNameAttribute('payment_state')"
                                                class="form-control m-input"
                                                @change="_setValueForm('payment_state', $v.model.attributes.payment_state.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.payment_state.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.payment_state.$error">
      <span v-if="!$v.model.attributes.payment_state.required">
       <?php  echo "{{model.structure.payment_state.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4" v-if="$v.model.attributes.payment_state.$model==0">
                                <div class="form-group"

                                     :class="getClassErrorForm('prepayment_allow',$v.model.attributes.prepayment_allow)">
                                    <label
                                        class="form__label " v-html='getLabelForm("prepayment_allow")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.prepayment_allow.$model"
                                                v-bind:id="getNameAttribute('prepayment_allow')"
                                                v-bind:name="getNameAttribute('prepayment_allow')"
                                                class="form-control m-input"
                                                @change="_setValueForm('prepayment_allow', $v.model.attributes.prepayment_allow.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.prepayment_allow.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.prepayment_allow.$error">
      <span v-if="!$v.model.attributes.prepayment_allow.required">
       <?php  echo "{{model.structure.prepayment_allow.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('reason_consultation',$v.model.attributes.reason_consultation)">
                                    <label
                                        class="form__label " v-html='getLabelForm("reason_consultation")' ></label>
                                    <div class="content-element-form">
<textarea
    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.reason_consultation.$model"
    v-bind:id="getNameAttribute('reason_consultation')"
    v-bind:name="getNameAttribute('reason_consultation')"
    @change="_setValueForm('reason_consultation', $v.model.attributes.reason_consultation.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.reason_consultation.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>


                        </b-row>
                        <b-row>

                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('price',$v.model.attributes.price)">
                                    <label class="form__label " v-html='getLabelForm("price")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.price.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('price')"
                                            v-bind:name="getNameAttribute('price')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('price', $v.model.attributes.price.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.price.$error">
      <span v-if="!$v.model.attributes.price.required">
       <?php  echo "{{model.structure.price.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4" v-if="$v.model.attributes.prepayment_allow.$model==1">
                                <div class="form-group"

                                     :class="getClassErrorForm('prepayment',$v.model.attributes.prepayment)">
                                    <label class="form__label " v-html='getLabelForm("prepayment")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.prepayment.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('prepayment')"
                                            v-bind:name="getNameAttribute('prepayment')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('prepayment', $v.model.attributes.prepayment.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.prepayment.$error">
      <span v-if="!$v.model.attributes.prepayment.required">
       <?php  echo "{{model.structure.prepayment.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('reason_consultation',$v.model.attributes.description)">
                                    <label
                                        class="form__label " v-html='getLabelForm("description")' ></label>
                                    <div class="content-element-form">
<textarea
    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.description.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>
