<script type='text/x-template' id='treatment-by-indebtedness-paying-init-template'>
    <div>

        <div class='content-component'>

            <b-modal
                hide-footer
                id="modal-treatment-by-indebtedness-paying-init"
                ref="refTreatmentByIndebtednessPayingInitModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <b-card no-body>
                        <b-tabs pills card>
                            <b-tab active @click="_managementProcess(0)">
                                <template v-slot:title>
                                    <i class="fas fa-heartbeat"></i>
                                    <strong> <?php echo '{{process.TreatmentByIndebtednessPayingInit.title}}'?> </strong>
                                </template>
                                <div class="manager-current" v-if="process.TreatmentByIndebtednessPayingInit.active">

                                    <div class="content-row-manager-buttons-process">
                                        <button type="button"
                                                v-if="process.TreatmentByIndebtednessPayingInit.createUpdate"
                                                :disabled="!validateForm()"
                                                class="btn btn-success "
                                                v-on:click="_saveModel()">
                                            <?php echo '{{process.TreatmentByIndebtednessPayingInit.createUpdate?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>


                                    </div>
                                    <div class="content-form">
                                        <div class="d-block ">
                                            <b-form id="TreatmentByIndebtednessPayingInitForm"
                                                    v-on:submit.prevent="_submitForm">
                                                <b-container>
                                                    <input v-model="model.attributes.id" type="hidden"
                                                           v-bind:id="getNameAttribute('id')"
                                                           v-bind:name="getNameAttribute('id')"
                                                    >

                                                    <b-row>
                                                        <b-col md="2">
                                                            <div class="form-group"

                                                                 :class="getClassErrorForm('number_payments',$v.model.attributes.number_payments)">
                                                                <label
                                                                    class="form__label " v-html='getLabelForm("number_payments")' ></label>
                                                                <div class="content-element-form">
                                                                    <input
                                                                        v-model.trim="$v.model.attributes.number_payments.$model"
                                                                        type="number"
                                                                        min="1"
                                                                        v-bind:id="getNameAttribute('number_payments')"
                                                                        v-bind:name="getNameAttribute('number_payments')"
                                                                        class="form-control m-input"
                                                                        @change="_setValueForm('number_payments', $v.model.attributes.number_payments.$model)"
                                                                        v-focus-select
                                                                        :disabled="!process.TreatmentByIndebtednessPayingInit.createUpdate"
                                                                    >
                                                                </div>
                                                                <div class="content-message-errors">
                                                                    <b-form-invalid-feedback
                                                                        :state="!$v.model.attributes.number_payments.$error">
      <span v-if="!$v.model.attributes.number_payments.required">
       <?php  echo "{{model.structure.number_payments.required.msj}}"?>
      </span>

                                                                    </b-form-invalid-feedback>
                                                                </div>
                                                            </div>

                                                        </b-col>
                                                        <div class="management-agreement"
                                                             v-if="process.TreatmentByIndebtednessPayingInit.createUpdate">
                                                            <button type="button"
                                                                    v-if="$v.model.attributes.number_payments.$model>0"
                                                                    class="btn btn-info "
                                                                    v-on:click="_calculate()">
                                                                <?php echo 'Calcular'?>
                                                            </button>


                                                        </div>
                                                    </b-row>

                                                    <b-row
                                                        v-if="process.TreatmentByIndebtednessPayingInit.createUpdate">
                                                        <b-col md="12">
                                                            <table id="treatment-by-breakdown-payment-details"
                                                                   class="xywer-tbl-admin">
                                                                <thead>
                                                                <tr>
                                                                    <th>Fecha Acuerdo</th>
                                                                    <th>Valor Pago</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody v-if="$v.model.attributes.items.$model.length>0">
                                                                <tr v-for="(v, index) in $v.model.attributes.items.$each.$iter"
                                                                    v-bind:class="getFormStateClassRowGridItem({index:index,modelsCurrent:v})">

                                                                    <td class="management-items management-items--description">
                                                                        <div class="management-items__date_agreement">
                                                                            <input
                                                                                @change="_setValueItemForm({'index':index,'keyItem':'date_agreement',model:v.date_agreement.$model})"
                                                                                class="form__input" type="date"
                                                                                v-model.trim="v.date_agreement.$model"/>
                                                                            <div class="error"
                                                                                 v-if="!v.date_agreement.required">
                                                                                <span>Fecha es requerido</span>
                                                                            </div>

                                                                        </div>
                                                                    </td>
                                                                    <td class="management-items management-items--payment_value">
                                                                        <div class="management-items__payment_value">
                                                                            <input
                                                                                @change="_setValueItemForm({'index':index,'keyItem':'payment_value',model:v.payment_value.$model})"
                                                                                class="form__input" type="number"
                                                                                min="1"
                                                                                v-model.trim="v.payment_value.$model"/>
                                                                            <div class="error"
                                                                                 v-if="!v.payment_value.required">
                                                                                <span>Valor es requerido</span>
                                                                            </div>

                                                                        </div>
                                                                    </td>

                                                                </tr>

                                                                </tbody>
                                                                <tbody v-else>
                                                                <tr>
                                                                    <td colspan="2"> Items no Agregados.</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </b-col>
                                                    </b-row>
                                                </b-container>


                                            </b-form>
                                        </div>

                                    </div>

                                    <div class="content-manager-grid"
                                         v-if="!process.TreatmentByIndebtednessPayingInit.createUpdate ">

                                        <div class="custom-scroll-admin-grid table-responsive" >
                                            <table id="treatment-by-indebtedness-paying-init-grid"
                                                   v-init-grid="{initMethod:_initGridCurrent,model:model}"
                                                   class=""

                                            >
                                                <thead>
                                                <tr>
                                                    <th data-visible="false" data-column-id="id" data-identifier="true">
                                                        ID
                                                    </th>
                                                    <th data-column-id="description" data-formatter="description">
                                                        Descripción
                                                    </th>

                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </b-tab>
                            <b-tab @click="_managementProcess(1)" :disabled="process.TreatmentPayment.allow==false">
                                <template v-slot:title>
                                    <span aria-hidden="true" class="fa fa-medkit"></span>
                                    <strong> <?php echo '{{process.TreatmentPayment.title}}'?></strong>
                                </template>
                                <div class="manager-current">
                                    <div v-if="process.TreatmentPayment.active">
                                        <treatment-by-payment-component
                                            ref='refTreatmentByPayment'
                                            :params='process.TreatmentPayment'
                                            v-on:_TreatmentByPayment-emit="_treatmentByIndebtednessPayingInit($event)"
                                        >

                                        </treatment-by-payment-component>
                                    </div>
                                </div>

                            </b-tab>

                        </b-tabs>
                    </b-card>


                </b-container>


            </b-modal>


        </div>
    </div>
</script>


