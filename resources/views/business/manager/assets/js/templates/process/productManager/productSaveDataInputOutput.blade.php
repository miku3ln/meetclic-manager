<script type='text/x-template' id='product-save-data-input-output-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-product-save-data-input-output"
                ref="refProductSaveDataInputOutputModal"
                size="md"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons-not" v-if="allowViewButton()">

                        <button v-if="showManager " type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>

                    </div>
                </b-container>

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="languageProductForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('type_input',$v.model.attributes['type_input'])">
                                            <label
                                                class="form__label " v-html='getLabelForm("type_input")' ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes['type_input'].$model"
                                                        v-bind:id="getNameAttribute('type_input')"
                                                        v-bind:name="getNameAttribute('type_input')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('type_input', $v.model.attributes['type_input'].$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure['type_input'].options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes['type_input'].$error">
      <span v-if="!$v.model.attributes['type_input'].required">
       <?php  echo "{{model.structure['type_input'].required.msj}}"?>
      </span>


                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group form-group--content">
                                            <label
                                                class="form-group__quantity-units"> <?php echo '{{model.structure["quantity_units"].label}} Actual:'?>
                                                <span
                                                    class="badge badge--size-large badge-info"><?php echo '{{configParams.data.quantity_units}}'?></span>
                                            </label>
                                        </div>
                                    </b-col>

                                </b-row>
                                <b-row>

                                    <b-col md="6">
                                        <div class="form-group "

                                             :class="getClassErrorForm('quantity_units',$v.model.attributes.quantity_units)">
                                            <label
                                                class="form__label " v-html='getLabelForm("quantity_units")' ></label>


                                            <div class="content-element-form">

                                                <input

                                                    v-model.trim="$v.model.attributes.quantity_units.$model"
                                                    type="number"
                                                    min="0"

                                                    v-bind:id="getNameAttribute('quantity_units')"
                                                    v-bind:name="getNameAttribute('quantity_units')"
                                                    class="form-control m-input i"
                                                    @change="_setValueForm('quantity_units', $v.model.attributes.quantity_units.$model)"
                                                    v-focus-select
                                                >

                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.quantity_units.$error">
      <span v-if="!$v.model.attributes.quantity_units.required">
       <?php  echo "{{model.structure.quantity_units.required.msj}}"?>
      </span>
                                                    <span  v-if="!$v.model.attributes.quantity_units.maxValue">
                                               <?php  echo "{{model.structure.quantity_units.maxValue.msj}} {{configParams.data.quantity_units}}"?>
                                                    </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>


                                </b-row>
                                <b-row v-if="validateForm()"
                                >
                                    <b-col md="6">
                                        <div class="form-group form-group--content">
                                            <label
                                                class="form-group__quantity-units"> <?php echo '{{model.structure["quantity_units"].label}} Total:'?>
                                                <span
                                                    class="badge badge--size-large badge-success"><?php echo '{{getResultQuantityUnits()}}'?></span>
                                            </label>
                                        </div>
                                    </b-col>

                                </b-row>
                            </b-container>


                        </b-form>
                    </div>

                </div>

            </b-modal>


        </div>
    </div>
</script>

