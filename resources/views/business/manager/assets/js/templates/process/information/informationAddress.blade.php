<script type='text/x-template' id='information-address-template'>
    <div>

        <div class='content-component'>

            <b-modal
                    hide-footer
                    id="modal-information-address"
                    ref="refInformationAddressModal"
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
                            <?php echo '{{labelsConfig.buttons.save}}'?>    </button>

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

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="informationAddressForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >

                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('state',$v.model.attributes.state)">
                                            <label class="form__label " v-html='getLabelForm("state")' ></label>
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
       <?php  echo "{{model.structure.state.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('main',$v.model.attributes.main)">
                                            <label class="form__label " v-html='getLabelForm("main")' ></label>
                                            <div class="content-element-form">


                                                <switch-button
                                                        v-on:toggle="_setValueForm('main', $v.model.attributes.main.$model)"
                                                        v-model="$v.model.attributes.main.$model"
                                                        color="#34bfa3">
                                                </switch-button>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.main.$error">
      <span v-if="!$v.model.attributes.main.required">
       <?php  echo "{{model.structure.main.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group"
                                             :class="getClassErrorForm('information_address_type_id_data',$v.model.attributes.information_address_type_id_data)">
                                            <label class="form__label " v-html='getLabelForm("information_address_type_id_data")' ></label>
                                            <div class="content-element-form">
                                                <input v-model="$v.model.attributes.information_address_type_id_data.model"
                                                       type="hidden"
                                                       v-bind:id="getNameAttribute('information_address_type_id_data')"
                                                       v-bind:name="getNameAttribute('information_address_type_id_data')"
                                                       @change="_setValueForm('information_address_type_id_data', $v.model.attributes.information_address_type_id_data.$model)"
                                                >
                                                <select id="information_address_type_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2InformationAddressType="{rowId:model.attributes.id,_managerS2InformationAddressType:_managerS2InformationAddressType}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.information_address_type_id_data.$error">
      <span v-if="!$v.model.attributes.information_address_type_id_data.required">
       <?php  echo "{{model.structure.information_address_type_id_data.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('street_one',$v.model.attributes.street_one)">
                                            <label class="form__label " v-html='getLabelForm("street_one")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                        v-model.trim="$v.model.attributes.street_one.$model"
                                                        type="text"
                                                        v-bind:id="getNameAttribute('street_one')"
                                                        v-bind:name="getNameAttribute('street_one')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('street_one', $v.model.attributes.street_one.$model)"
                                                        v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.street_one.$error">
      <span v-if="!$v.model.attributes.street_one.required">
       <?php  echo "{{model.structure.street_one.required.msj}}"?>
      </span>
                                                    <span v-if="!$v.model.attributes.street_one.maxLength">
       <?php  echo "{{model.structure.street_one.maxLength.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('street_two',$v.model.attributes.street_two)">
                                            <label class="form__label " v-html='getLabelForm("street_two")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                        v-model.trim="$v.model.attributes.street_two.$model"
                                                        type="text"
                                                        v-bind:id="getNameAttribute('street_two')"
                                                        v-bind:name="getNameAttribute('street_two')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('street_two', $v.model.attributes.street_two.$model)"
                                                        v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.street_two.$error">
      <span v-if="!$v.model.attributes.street_two.required">
       <?php  echo "{{model.structure.street_two.required.msj}}"?>
      </span>
                                                    <span v-if="!$v.model.attributes.street_two.maxLength">
       <?php  echo "{{model.structure.street_two.maxLength.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>

                                </b-row>
                                <b-row>
                                    <b-col md="12">
                                        <div class="floating-panel-manager">
                                            <input id="search-map-current"
                                                   class="floating-panel-manager__search"
                                                   type="textbox"
                                                   value="Ecuador"
                                                   v-on:click="_initClassSearch()"
                                                   v-focus-select
                                            >

                                        </div>
                                        <div class="map-guests"
                                             v-initMapCurrent="{model:$v.model.attributes,_initMap:_initMap}"
                                             id="manager-map">

                                        </div>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('reference',$v.model.attributes.reference)">
                                            <label class="form__label " v-html='getLabelForm("reference")' ></label>
                                            <div class="content-element-form">
<textarea
        rows="10" class="form-control"
        v-model.trim="$v.model.attributes.reference.$model"
        v-bind:id="getNameAttribute('reference')"
        v-bind:name="getNameAttribute('reference')"
        @change="_setValueForm('reference', $v.model.attributes.reference.$model)"
        v-focus-select
></textarea>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.reference.$error">
      <span v-if="!$v.model.attributes.reference.required">
       <?php  echo "{{model.structure.reference.required.msj}}"?>
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
                        <table id="information-address-grid"
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

