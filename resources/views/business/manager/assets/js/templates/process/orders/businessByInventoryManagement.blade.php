<script type='text/x-template' id='business-by-inventory-management-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-business-by-inventory-management"
                ref="refBusinessByInventoryManagementModal"
                size="md"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons-not">

                        <button v-if="showManager " type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{model.attributes.id==null?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>

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
                                    <b-col md="6">
                                        <div class="form-group"

                                             :class="getClassErrorForm('type',$v.model.attributes['type'])">
                                            <label
                                                class="form__label " v-html='getLabelForm("type")' ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes['type'].$model"
                                                        v-bind:id="getNameAttribute('type')"
                                                        v-bind:name="getNameAttribute('type')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('type', $v.model.attributes['type'].$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure['type'].options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes['type'].$error">
      <span v-if="!$v.model.attributes['type'].required">
       <?php  echo "{{model.structure['type'].required.msj}}"?>
      </span>


                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>

                                <b-row v-if="$v.model.attributes['type'].$model==1">

                                    <b-col md="6" v-show="false" >
                                        <div class="form-group "

                                             :class="getClassErrorForm('header_content_background_color_subcategories',$v.model.attributes.header_content_background_color_subcategories)">
                                            <label
                                                class="form__label " v-html='getLabelForm("header_content_background_color_subcategories")' ></label>


                                            <div class="content-element-form">

                                                <input
                                                    v-init-data-picker="{initMethod:initDataPicker,data:{}}"
                                                    v-model.trim="$v.model.attributes.header_content_background_color_subcategories.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('header_content_background_color_subcategories')"
                                                    v-bind:name="getNameAttribute('header_content_background_color_subcategories')"
                                                    class="form-control m-input i"
                                                    @change="_setValueForm('header_content_background_color_subcategories', $v.model.attributes.header_content_background_color_subcategories.$model)"
                                                    v-focus-select
                                                >

                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.header_content_background_color_subcategories.$error">
      <span v-if="!$v.model.attributes.header_content_background_color_subcategories.required">
       <?php  echo "{{model.structure.header_content_background_color_subcategories.required.msj}}"?>
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

            </b-modal>


        </div>
    </div>
</script>

