<script type='text/x-template' id='shipping-rate-business-by-conversion-factor-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-shipping-rate-business-by-conversion-factor"
                ref="refShippingRateBusinessByConversionFactorModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons">
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
                        <b-form id="shippingRateBusinessByConversionFactorForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('type_local',$v.model.attributes.type_local)">
                                            <label
                                                class="form__label " v-html='getLabelForm("type_local")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.type_local.$model"
                                                    type="checkbox"
                                                    v-bind:id="getNameAttribute('type_local')"
                                                    v-bind:name="getNameAttribute('type_local')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('type_local', $v.model.attributes.type_local.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.type_local.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group"

                                             :class="getClassErrorForm('shipping_rate_services_id_data',$v.model.attributes.shipping_rate_services_id_data)">
                                            <label
                                                class="form__label " v-html='getLabelForm("shipping_rate_services_id_data")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.shipping_rate_services_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('shipping_rate_services_id_data')"
                                                    v-bind:name="getNameAttribute('shipping_rate_services_id_data')"
                                                    @change="_setValueForm('shipping_rate_services_id_data', $v.model.attributes.shipping_rate_services_id_data.$model)"
                                                >
                                                <select id="shipping_rate_services_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2ShippingRateServices="{rowId:model.attributes.id,_managerS2ShippingRateServices:_managerS2ShippingRateServices}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.shipping_rate_services_id_data.$error">
      <span v-if="!$v.model.attributes.shipping_rate_services_id_data.required">
       <?php  echo "{{model.structure.shipping_rate_services_id_data.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="6">
                                        <div class="form-group"

                                             :class="getClassErrorForm('shipping_rate_kinds_of_way_id_data',$v.model.attributes.shipping_rate_kinds_of_way_id_data)">
                                            <label
                                                class="form__label " v-html='getLabelForm("shipping_rate_kinds_of_way_id_data")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.shipping_rate_kinds_of_way_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('shipping_rate_kinds_of_way_id_data')"
                                                    v-bind:name="getNameAttribute('shipping_rate_kinds_of_way_id_data')"
                                                    @change="_setValueForm('shipping_rate_kinds_of_way_id_data', $v.model.attributes.shipping_rate_kinds_of_way_id_data.$model)"
                                                >
                                                <select id="shipping_rate_kinds_of_way_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2ShippingRateKindsOfWay="{rowId:model.attributes.id,_managerS2ShippingRateKindsOfWay:_managerS2ShippingRateKindsOfWay}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.shipping_rate_kinds_of_way_id_data.$error">
      <span v-if="!$v.model.attributes.shipping_rate_kinds_of_way_id_data.required">
       <?php  echo "{{model.structure.shipping_rate_kinds_of_way_id_data.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="4">
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
                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('value_factor',$v.model.attributes.value_factor)">
                                            <label
                                                class="form__label " v-html='getLabelForm("value_factor")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.value_factor.$model"
                                                    type="number"
                                                    v-bind:id="getNameAttribute('value_factor')"
                                                    v-bind:name="getNameAttribute('value_factor')"
                                                    min="0" class="form-control m-input"
                                                    @change="_setValueForm('value_factor', $v.model.attributes.value_factor.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.value_factor.$error">
      <span v-if="!$v.model.attributes.value_factor.required">
       <?php  echo "{{model.structure.value_factor.required.msj}}"?>
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

                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                        <table id="shipping-rate-business-by-conversion-factor-grid"
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
            </b-modal>


        </div>
    </div>
</script>

