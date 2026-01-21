<script type="text/x-template" id="register-form-template">
    <div>
        <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">
            <h1 class="title-main" v-form-text="'actions.register'" v-if="!$v.model.attributes.id.$model">
            </h1>
            <h1 class="title-main" v-form-text="'actions.update'" v-if="$v.model.attributes.id.$model"></h1>
            <b-container>
                <input v-model="model.attributes.id" type="hidden"
                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')">
                <b-row>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('state',$v.model.attributes.state)">
                            <label class="form__label " v-html='getLabelForm("state")'></label>
                            <div class="content-element-form">
                                <select v-model.trim="$v.model.attributes.state.$model"
                                        v-bind:id="getNameAttribute('state')"
                                        v-bind:name="getNameAttribute('state')"
                                        class="form-control m-input"
                                        @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                >
                                    <option v-for="(row,index) in model.structure.state.options"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php echo "{{model.structure.state.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>

                </b-row>
                <legend class="h6 mb-2 legend--section">DOCUMENTOS TÉCNICOS REQUERIDOS POR LA AUTORIDAD MARÍTIMA
                </legend>

                <b-row>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('technical_info_type',$v.model.attributes.technical_info_type)">
                            <label class="form__label " v-html='getLabelForm("technical_info_type")'></label>
                            <div class="content-element-form">
                                <select v-model.trim="$v.model.attributes.technical_info_type.$model"
                                        v-bind:id="getNameAttribute('technical_info_type')"
                                        v-bind:name="getNameAttribute('technical_info_type')"
                                        class="form-control m-input"
                                        @change="_setValueForm('technical_info_type', $v.model.attributes.technical_info_type.$model)"
                                >
                                    <option v-for="(row,index) in model.structure.technical_info_type.options"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.technical_info_type.$error">
      <span v-if="!$v.model.attributes.technical_info_type.required">
       <?php echo "{{model.structure.technical_info_type.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('maritime_vessel_type_data_id',$v.model.attributes.maritime_vessel_type_data_id)">
                            <label
                                class="form__label " v-html='getLabelForm("maritime_vessel_type_data_id")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.maritime_vessel_type_data_id.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('maritime_vessel_type_data_id')"
                                    v-bind:name="getNameAttribute('maritime_vessel_type_data_id')"
                                    @change="_setValueForm('maritime_vessel_type_data_id', $v.model.attributes.maritime_vessel_type_data_id.$model)"
                                    v-reset-field="{form:$v.model.attributes,fieldName:'maritime_vessel_type_data_id'}"

                                >


                                <select
                                    class="form-control m-select2"
                                    v-init-s2-manager="{  _initS2Manager:_vesselTypes }"
                                ></select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.maritime_vessel_type_data_id.$error">
      <span v-if="!$v.model.attributes.maritime_vessel_type_data_id.required">
       <?php echo "{{model.structure.maritime_vessel_type_data_id.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4" v-if="$v.model.attributes.maritime_vessel_type_data_id">
                        <div class="manager-documents"
                             v-html="getDataManagerDocuments($v.model.attributes.maritime_vessel_type_data_id)"></div>
                    </b-col>

                </b-row>
                <legend class="h6 mb-2 legend--section">INFORMACION EMBARCACION</legend>

                <b-row>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('business_data_id',$v.model.attributes.business_data_id)">
                            <label
                                class="form__label " v-html='getLabelForm("business_data_id")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.business_data_id.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('business_data_id')"
                                    v-bind:name="getNameAttribute('business_data_id')"
                                    @change="_setValueForm('business_data_id', $v.model.attributes.business_data_id.$model)"
                                    v-reset-field="{form:$v.model.attributes,fieldName:'business_data_id'}"

                                >


                                <select
                                    class="form-control m-select2"
                                    v-init-s2-manager="{  _initS2Manager:_businessManager }"
                                ></select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.business_data_id.$error">
      <span v-if="!$v.model.attributes.business_data_id.required">
       <?php echo "{{model.structure.business_data_id.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="6">
                        <div class="form-group"

                             :class="getClassErrorForm('name',$v.model.attributes.name)">
                            <label
                                class="form__label " v-html='getLabelForm("name")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.name.$model"
                                    type="text"
                                    v-bind:id="getNameAttribute('name')"
                                    v-bind:name="getNameAttribute('name')"
                                    class="form-control m-input"
                                    @change="_setValueForm('name', $v.model.attributes.name.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.name.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('owner_customer_data_id',$v.model.attributes.owner_customer_data_id)">
                            <label
                                class="form__label " v-html='getLabelForm("owner_customer_data_id")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.owner_customer_data_id.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('owner_customer_data_id')"
                                    v-bind:name="getNameAttribute('owner_customer_data_id')"
                                    @change="_setValueForm('owner_customer_data_id', $v.model.attributes.owner_customer_data_id.$model)"
                                    v-reset-field="{form:$v.model.attributes,fieldName:'owner_customer_data_id'}"

                                >


                                <select
                                    class="form-control m-select2"
                                    v-init-s2-manager="{  _initS2Manager:_businessCustomer }"
                                ></select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.owner_customer_data_id.$error">
      <span v-if="!$v.model.attributes.owner_customer_data_id.required">
       <?php echo "{{model.structure.owner_customer_data_id.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
                <legend class="h6 mb-2 legend--section">DATOS TECNICOS EMBARCACION</legend>

                <b-row>
                    <b-col md="3">
                        <div class="form-group"

                             :class="getClassErrorForm('length',$v.model.attributes.length)">
                            <label
                                class="form__label " v-html='getLabelForm("length")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.length.$model"
                                    type="number"
                                    v-bind:id="getNameAttribute('length')"
                                    v-bind:name="getNameAttribute('length')"
                                    class="form-control m-input"
                                    @change="_setValueForm('length', $v.model.attributes.length.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.length.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3">
                        <div class="form-group"

                             :class="getClassErrorForm('beam',$v.model.attributes.beam)">
                            <label
                                class="form__label " v-html='getLabelForm("beam")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.beam.$model"
                                    type="number"
                                    v-bind:id="getNameAttribute('beam')"
                                    v-bind:name="getNameAttribute('beam')"
                                    class="form-control m-input"
                                    @change="_setValueForm('beam', $v.model.attributes.beam.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.beam.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="2">
                        <div class="form-group"

                             :class="getClassErrorForm('draft',$v.model.attributes.draft)">
                            <label
                                class="form__label " v-html='getLabelForm("draft")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.draft.$model"
                                    type="number"
                                    v-bind:id="getNameAttribute('draft')"
                                    v-bind:name="getNameAttribute('draft')"
                                    class="form-control m-input"
                                    @change="_setValueForm('draft', $v.model.attributes.draft.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.draft.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('passenger_capacity',$v.model.attributes.passenger_capacity)">
                            <label
                                class="form__label " v-html='getLabelForm("passenger_capacity")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.passenger_capacity.$model"
                                    type="number"
                                    v-bind:id="getNameAttribute('passenger_capacity')"
                                    v-bind:name="getNameAttribute('passenger_capacity')"
                                    class="form-control m-input"
                                    @change="_setValueForm('passenger_capacity', $v.model.attributes.passenger_capacity.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.passenger_capacity.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
            </b-container>


            <!-- ✅ Acciones fijas (abajo derecha) -->
            <div class="embark-actions" role="group" aria-label="Acciones de embarque">

                <button type="button"
                        class="btn btn-warning"
                        :disabled="!validateForm()"
                        v-on:click="_saveModel()"

                >
                    <i class="fa fa-floppy-o embark-actions__icon" aria-hidden="true"></i>
                    <span class="embark-actions__text" v-form-text="'actions.register'"></span>
                </button>
                <button type="button"
                        class="embark-actions__btn btn btn-warning"

                        v-on:click="onReturnMain()"

                >
                    <i class="fa fa-arrow-left embark-actions__icon" aria-hidden="true"></i>
                    <span class="embark-actions__text" v-form-text="'actions.back'"></span>
                </button>
            </div>

        </b-form>

    </div>

</script>

