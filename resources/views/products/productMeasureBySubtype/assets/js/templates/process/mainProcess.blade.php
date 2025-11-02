<script type='text/x-template' id='product-measure-by-subtype-template'>
    <div>

        <div class='content-component'>


            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php  echo "{{showManager?'Regresar':'Administrar'}}" ?></button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{"Guardar"}}'?></button>

                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                            <menu-admin-grid
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig" >

                            </menu-admin-grid>


                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="product-measure-by-subtype-grid"
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
                <b-form id="productMeasureBySubtypeForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('product_measure_type_id_data',$v.model.attributes.product_measure_type_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("product_measure_type_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.product_measure_type_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('product_measure_type_id_data')"
                                               v-bind:name="getNameAttribute('product_measure_type_id_data')"
                                               @change="_setValueForm('product_measure_type_id_data', $v.model.attributes.product_measure_type_id_data.$model)"
                                        >
                                        <select id="product_measure_type_id_data"
                                                class="form-control m-select2 "
                                                v-initS2ProductMeasureType="{rowId:model.attributes.id,_managerS2ProductMeasureType:_managerS2ProductMeasureType}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_measure_type_id_data.$error">
      <span v-if="!$v.model.attributes.product_measure_type_id_data.required">
       <?php  echo "{{model.structure.product_measure_type_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6" v-if="$v.model.attributes.product_measure_type_id_data.$model">
                                <div class="form-group"

                                     :class="getClassErrorForm('product_measurement_subtype_id_data',$v.model.attributes.product_measurement_subtype_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("product_measurement_subtype_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.product_measurement_subtype_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('product_measurement_subtype_id_data')"
                                               v-bind:name="getNameAttribute('product_measurement_subtype_id_data')"
                                               @change="_setValueForm('product_measurement_subtype_id_data', $v.model.attributes.product_measurement_subtype_id_data.$model)"
                                        >
                                        <select id="product_measurement_subtype_id_data"
                                                class="form-control m-select2 "
                                                v-initS2ProductMeasurementSubtype="{rowId:model.attributes.id,_managerS2ProductMeasurementSubtype:_managerS2ProductMeasurementSubtype}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_measurement_subtype_id_data.$error">
      <span v-if="!$v.model.attributes.product_measurement_subtype_id_data.required">
       <?php  echo "{{model.structure.product_measurement_subtype_id_data.required.msj}}"?>
      </span>
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

