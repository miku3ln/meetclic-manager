<script type='text/x-template' id='template-about-us-by-data-template'>
    <div>

        <div class='content-component'>
            <div v-if="configModalLanguageTemplateAboutUsByData.viewAllow">
                <language-template-about-us-by-data-component
                    ref="refLanguageTemplateAboutUsByData"
                    :params="configModalLanguageTemplateAboutUsByData"
                >
                </language-template-about-us-by-data-component>
            </div>

            <b-modal
                hide-footer
                id="modal-template-about-us-by-data"
                ref="refTemplateAboutUsByDataModal"
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
                        <b-form id="templateAboutUsByDataForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('status',$v.model.attributes.status)">
                                            <label
                                                class="form__label " v-html='getLabelForm("status")' ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.status.$model"
                                                        v-bind:id="getNameAttribute('status')"
                                                        v-bind:name="getNameAttribute('status')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.status.options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php  echo "{{model.structure.status.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('allow_source_data',$v.model.attributes.allow_source_data)">
                                            <label
                                                class="form__label " v-html='getLabelForm("allow_source_data")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.allow_source_data.$model"
                                                    type="checkbox"
                                                    v-bind:id="getNameAttribute('allow_source_data')"
                                                    v-bind:name="getNameAttribute('allow_source_data')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('allow_source_data', $v.model.attributes.allow_source_data.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.allow_source_data.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>
                                    <b-col md="8" v-if="$v.model.attributes.allow_source_data.$model">

                                        <div class="content-box-image content-box-preview" @click="_uploadDataImage"

                                             :class="getClassErrorForm('source',$v.model.attributes.source)"
                                        >
                                            <img class="content-box-image__preview" id="preview-source">
                                            <div>

                                                <input
                                                    v-initEventUploads="{initMethod:_initEventsUpload,paramsInit:getAttributesManagerUpload({nameField:'source'})}"
                                                    type="file"
                                                    id="file_source"
                                                    class="hidden"
                                                    v-bind:name="getNameAttribute('source')"
                                                >
                                            </div>
                                        </div>
                                        <div class="progress-gallery-image not-view">
                                            <div class="progress__bar"></div>
                                            <div class="progress__percent">0%</div>
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.source.$error">
      <span v-if="!$v.model.attributes.source.required">
       <?php  echo "{{model.structure.source.required.msj}}"?>
      </span>
                                                <span v-if="!$v.model.attributes.source.maxLength">
       <?php  echo "{{model.structure.source.maxLength.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>


                                    </b-col>
                                </b-row>
                                <b-row>

                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.title.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('title')"
                                                    v-bind:name="getNameAttribute('title')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('title', $v.model.attributes.title.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.title.$error">
      <span v-if="!$v.model.attributes.title.required">
       <?php  echo "{{model.structure.title.required.msj}}"?>
      </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('description',$v.model.attributes.description)">
                                            <label
                                                class="form__label " v-html='getLabelForm("description")' ></label>
                                            <div class="content-element-form">
<textarea
    style="display: none;"
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                                <div class="description form-control" id="description"
                                                     v-initSummerNote="{initMethod:_initSummerNote}"></div>


                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.description.$error">
      <span v-if="!$v.model.attributes.description.required">
       <?php  echo "{{model.structure.description.required.msj}}"?>
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
                        <table id="template-about-us-by-data-grid"
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

