


<script type='text/x-template' id='treatment-by-patient-template'>
    <div>

        <div class='content-component'>

            <div v-if="configModalTreatmentByIndebtednessPayingInit.viewAllow">
                <treatment-by-indebtedness-paying-init-component
                    ref="refTreatmentByIndebtednessPayingInit"
                    :params="configModalTreatmentByIndebtednessPayingInit"
                >
                </treatment-by-indebtedness-paying-init-component>
            </div>
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
                    <table id="treatment-by-patient-grid" class="">
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
                <b-form id="treatmentByPatientForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <div class="row">
                            <b-col md="4">
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
                                     :class="getClassErrorForm('invoice_date',$v.model.attributes.invoice_date)">
                                    <label
                                        class="form__label " v-html='getLabelForm("invoice_date")' ></label>
                                    <div class="content">
                                        <input type="date" class="form-control input--invoice"
                                               v-model="model.attributes.invoice_date"
                                               @change="_setValueForm('invoice_date', $v.model.attributes.invoice_date.$model)"
                                               v-bind:id="getNameAttribute('invoice_date')"
                                               v-bind:name="getNameAttribute('invoice_date')"/>
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.invoice_date.$error">
                                            <span v-if="!$v.model.attributes.invoice_date.required">
                                <?php  echo "{{model.structure.invoice_date.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </div>
                        <div class="row">
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('product_id_data',$v.model.attributes.product_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("product_id_data")' ></label>
                                    <div class="content">
                                        <select
                                            id="product_id_data"
                                            class="form-control m-select2 product_id_data select2-container-modal"
                                            v-initS2="{model:model.attributes,_manager:_managerS2ProductService}"
                                        >
                                        </select>

                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_id_data.$error">
                                            <span v-if="!$v.model.attributes.product_id_data.required">
                                <?php  echo "{{model.structure.product_id_data.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <table id="treatment-details" class="xywer-tbl-admin">
                                    <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Cant</th>
                                        <th></th>

                                    </tr>
                                    </thead>

                                    <tbody v-if="$v.model.attributes.items.$model.length>0">
                                    <tr v-for="(v, index) in $v.model.attributes.items.$each.$iter"
                                        v-bind:class="getFormStateClassRowGridItem({index:index,modelsCurrent:v})">

                                        <td class="management-items management-items--description">
                                            <div
                                                class="management-items__description">  <?php echo '{{v.description.$model}}'?></div>

                                        </td>
                                        <td class="management-items management-items--quantity">
                                            <div class="management-items__quantity">
                                                <input
                                                    @change="_setValueItemForm({'index':index,'keyItem':'quantity',model:v.quantity.$model})"
                                                    class="form__input" type="number" min="1"
                                                    v-model.trim="v.quantity.$model"/>
                                                <div class="error" v-if="!v.quantity.required">
                                                    <span>Cantidad es requerido</span>
                                                </div>

                                            </div>
                                        </td>
                                        <td class="management-items management-items--delete"
                                            @click="_deleteValueItemForm({'index':index,'keyItem':'quantity',model:v.quantity.$model})">
                                            <div class="management-items__delete">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td colspan="3"> Items no Agregados.</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <div class="row" id="row-manager-invoice">
                                    <div id="div-manager-invoice">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                             id="col-invoice-subtotal-tax">
                                            <label id="lbl-invoice-total" class="col-md-12 lbl-manager-result ">Subtotal
                                                12% </label>
                                            <input class="form-control " id="input-invoice-subtotal-tax" type="number"
                                                   disabled v-model="invoiceDataManagementResults.header.value_taxes">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                             id="col-invoice-subtotal-not-tax">
                                            <label id="lbl-invoice-total" class="col-md-12 lbl-manager-result ">Subtotal
                                                0% </label>
                                            <input class="form-control " id="input-invoice-subtotal-not-tax"
                                                   type="number" disabled
                                                   v-model="invoiceDataManagementResults.header.subtotal">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-invoice-discount">
                                            <label id="lbl-invoice-total" class="col-md-12 lbl-manager-result ">Descuento </label>
                                            <input class="form-control " id="input-invoice-discount" type="number"
                                                   disabled
                                                   v-model="invoiceDataManagementResults.header.discount_value">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                             id="col-invoice-result-tax">
                                            <label id="lbl-invoice-total"
                                                   class="col-md-12 lbl-manager-result ">IVA </label>
                                            <input class="form-control " id="input-invoice-result-tax" type="number"
                                                   disabled v-model="invoiceDataManagementResults.header.value_taxes">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-invoice-total">
                                            <label id="lbl-invoice-total"
                                                   class="col-md-12 lbl-manager-result ">Total </label>
                                            <input class="form-control " id="input-invoice-total" type="number" disabled
                                                   v-model="invoiceDataManagementResults.header.invoice_value">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('observation',$v.model.attributes.observations)">
                                    <label
                                        class="form__label " v-html='getLabelForm("observations")' ></label>
                                    <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.observations.$model"
    v-bind:id="getNameAttribute('observations')"
    v-bind:name="getNameAttribute('observations')"
    @change="_setValueForm('observations', $v.model.attributes.observations.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.observations.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </div>

                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>
