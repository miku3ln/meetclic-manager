<script type='text/x-template' id='language-template-slider-by-images-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-language-template-slider-by-images"
                ref="refLanguageTemplateSliderByImagesModal"
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
                        <b-form id="languageTemplateServicesForm" v-on:submit.prevent="_submitForm">


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
                                </b-row>
                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"

                                             :class="getClassErrorForm('language_id_data',$v.model.attributes.language_id_data)">
                                            <label
                                                class="form__label " v-html='getLabelForm("language_id_data")' ></label>
                                            <div class="content-element-form">
                                                <input v-model="$v.model.attributes.language_id_data.model"
                                                       type="hidden"
                                                       v-bind:id="getNameAttribute('language_id_data')"
                                                       v-bind:name="getNameAttribute('language_id_data')"
                                                       @change="_setValueForm('language_id_data', $v.model.attributes.language_id_data.$model)"
                                                >
                                                <select id="language_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2Language="{rowId:model.attributes.id,_managerS2Language:_managerS2Language}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.language_id_data.$error">
      <span v-if="!$v.model.attributes.language_id_data.required">
       <?php  echo "{{model.structure.language_id_data.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="12">
                                        <div class="form-group"

                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")' ></label>
                                            <div class="content-element-form">

                                                <textarea

                                                    rows="10" class="form-control"
                                                    v-model.trim="$v.model.attributes.title.$model"
                                                    v-bind:id="getNameAttribute('title')"
                                                    v-bind:name="getNameAttribute('title')"
                                                    @change="_setValueForm('title', $v.model.attributes.title.$model)"
                                                    v-focus-select
                                                ></textarea>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.title.$error">
      <span v-if="!$v.model.attributes.title.required">
       <?php  echo "{{model.structure.title.required.msj}}"?>
      </span>
                                                    <span v-if="!$v.model.attributes.title.maxLength">
       <?php  echo "{{model.structure.title.maxLength.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>


                                    <b-col md="12">
                                        <div class="form-group"

                                             :class="getClassErrorForm('subtitle',$v.model.attributes.subtitle)">
                                            <label
                                                class="form__label " v-html='getLabelForm("subtitle")' ></label>
                                            <div class="content-element-form">

                                                <textarea

                                                    rows="10" class="form-control"
                                                    v-model.trim="$v.model.attributes.subtitle.$model"
                                                    v-bind:id="getNameAttribute('subtitle')"
                                                    v-bind:name="getNameAttribute('subtitle')"
                                                    @change="_setValueForm('subtitle', $v.model.attributes.subtitle.$model)"
                                                    v-focus-select
                                                ></textarea>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.subtitle.$error">
      <span v-if="!$v.model.attributes.subtitle.maxLength">
       <?php  echo "{{model.structure.subtitle.maxLength.msj}}"?>
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
                        <table id="language-template-slider-by-images-grid"
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

