<script type="text/x-template" id="register-form-responsible-template">
    <div>
        <div class="row">
            <legend class="h6 mb-2 legend--section">Embarcacion</legend>

            <div class="col-md-12">
                <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">
                    <h1 class="title-main" v-form-text="'actions.register'" v-if="!$v.model.attributes.id.$model">
                    </h1>
                    <h1 class="title-main" v-form-text="'actions.update'" v-if="$v.model.attributes.id.$model"></h1>
                    <b-container>

                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('role',$v.model.attributes.role)">
                                    <label class="form__label " v-html='getLabelForm("role")'></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.role.$model"
                                                v-bind:id="getNameAttribute('role')"
                                                v-bind:name="getNameAttribute('role')"
                                                class="form-control m-input"
                                                @change="_setValueForm('role', $v.model.attributes.role.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.role.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.role.$error">
      <span v-if="!$v.model.attributes.role.required">
       <?php echo "{{model.structure.role.required.msj}}" ?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('customer_data_id',$v.model.attributes.customer_data_id)">
                                    <label
                                        class="form__label "
                                        v-html='getLabelForm("customer_data_id")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model="$v.model.attributes.customer_data_id.model"
                                            type="hidden"
                                            v-bind:id="getNameAttribute('customer_data_id')"
                                            v-bind:name="getNameAttribute('customer_data_id')"
                                            @change="_setValueForm('customer_data_id', $v.model.attributes.customer_data_id.$model)"
                                            v-reset-field="{form:$v.model.attributes,fieldName:'customer_data_id'}"
                                        >
                                        <select
                                            class="form-control m-select2"
                                            v-init-s2-manager="{  _initS2Manager:_businessCustomer }"
                                        ></select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.customer_data_id.$error">
      <span v-if="!$v.model.attributes.customer_data_id.required">
       <?php echo "{{model.structure.customer_data_id.required.msj}}" ?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>

                    </b-container>


                    <!-- ✅ Acciones fijas (abajo derecha) -->
                    <div class="embark-actions" role="group" aria-label="Acciones de embarque">

                        <button type="button"
                                class="btn btn-success"
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
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" >

                        <table id="grid-registers-responsible-grid"
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
    </div>

</script>
