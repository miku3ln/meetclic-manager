<script type='text/x-template' id='business-by-inventory-management-subcategory-template'>
    <div>

        <div class='content-component'>


            <b-modal
                    hide-footer
                    id="modal-business-by-inventory-management-subcategory"
                    ref="refBusinessByInventoryManagementSubcategoryModal"
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
                                    :manager-menu-config="managerMenuConfig" >

                                </menu-admin-grid>

                            </div>
                        </div>
                    </div>
                </b-container>

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="BusinessByInventoryManagementSubcategoryForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class=" content-box-image content-box-preview"
                                              id="manager-source"
                                             :class="getClassErrorForm('source',$v.model.attributes.source)">
                                            <img class="content-box-image__preview" id="preview-source">
                                            <div class="content-element-form">
                                                <input
                                                        v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                                        type="file" id="file-source"
                                                        v-bind:name="getNameAttribute('source')">
                                            </div>
                                            <div class="progress-gallery-image not-view" id="progress-source">
                                                <div class="progress__bar"></div>
                                                <div class="progress__percent">0%</div>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.source.$error">
      <span v-if="!$v.model.attributes.source.required">
       <?php  echo "{{model.structure.source.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group"
                                             :class="getClassErrorForm('product_subcategory_id_data',$v.model.attributes.product_subcategory_id_data)">
                                            <label class="form__label " v-html='getLabelForm("product_subcategory_id_data")' ></label>
                                            <div class="content-element-form">
                                                <input v-model="$v.model.attributes.product_subcategory_id_data.model"
                                                       type="hidden"
                                                       v-bind:id="getNameAttribute('product_subcategory_id_data')"
                                                       v-bind:name="getNameAttribute('product_subcategory_id_data')"
                                                       @change="_setValueForm('product_subcategory_id_data', $v.model.attributes.product_subcategory_id_data.$model)"
                                                >
                                                <select id="product_subcategory_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2="{model:model.attributes.id,initMethod:initSubcategoriesS2}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.product_subcategory_id_data.$error">
      <span v-if="!$v.model.attributes.product_subcategory_id_data.required">
       <?php  echo "{{model.structure.product_subcategory_id_data.required.msj}}"?>
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
                        <table id="business-by-inventory-management-subcategory-grid"
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

