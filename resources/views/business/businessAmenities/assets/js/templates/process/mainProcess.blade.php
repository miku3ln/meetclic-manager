<script type='text/x-template' id='business-amenities-template'>
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
                    <table id="business-amenities-grid"
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
                <b-form id="businessAmenitiesForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label " v-html='getLabelForm("value")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.value.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('value')"
                                            v-bind:name="getNameAttribute('value')"
                                            class="form-control m-input"
                                            @change="_setValueForm('value', $v.model.attributes.value.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.value.$error">
      <span v-if="!$v.model.attributes.value.required">
       <?php  echo "{{model.structure.value.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.value.maxLength">
       <?php  echo "{{model.structure.value.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('description',$v.model.attributes.description)">
                                    <label class="form__label " v-html='getLabelForm("description")' ></label>
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
                            <b-col md="12">
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
                            <b-col md="12">
                                <div class=" content-box-image content-box-preview"
                                     @click="_uploadDataImage" id="manager-source"
                                     :class="getClassErrorForm('source',$v.model.attributes.source)">
                                    <img class="content-box-image__preview" id="preview-source">
                                    <div class="content-element-form">
                                        <input
                                            v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: model})}"
                                            type="file" id="file-source" class="hidden"
                                            v-bind:name="getNameAttribute('source')">
                                    </div>
                                    <div class="progress-gallery-image not-view" id="progress-source">
                                        <div class="progress__bar"></div>
                                        <div class="progress__percent">0%</div>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.source.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('type_source',$v.model.attributes.type_source)">
                                    <label class="form__label " v-html='getLabelForm("type_source")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.type_source.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('type_source')"
                                            v-bind:name="getNameAttribute('type_source')"
                                            class="form-control m-input"
                                            @change="_setValueForm('type_source', $v.model.attributes.type_source.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_source.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('business_subcategories_id_data',$v.model.attributes.business_subcategories_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("business_subcategories_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.business_subcategories_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('business_subcategories_id_data')"
                                               v-bind:name="getNameAttribute('business_subcategories_id_data')"
                                               @change="_setValueForm('business_subcategories_id_data', $v.model.attributes.business_subcategories_id_data.$model)"
                                        >
                                        <select id="business_subcategories_id_data"
                                                class="form-control m-select2 "
                                                v-initS2BusinessSubcategories="{rowId:model.attributes.id,_managerS2BusinessSubcategories:_managerS2BusinessSubcategories}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.business_subcategories_id_data.$error">
      <span v-if="!$v.model.attributes.business_subcategories_id_data.required">
       <?php  echo "{{model.structure.business_subcategories_id_data.required.msj}}"?>
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

