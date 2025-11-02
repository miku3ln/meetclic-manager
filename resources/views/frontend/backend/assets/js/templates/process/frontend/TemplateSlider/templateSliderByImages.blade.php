<style>
    .content-message-errors.content-message-errors--image {
        position: absolute;
        text-align: left;
    }
</style>
<script type='text/x-template' id='template-slider-by-images-template'>
    <div>

        <div class='content-component'>

            <div v-if="configModalLanguageTemplateSliderByImages.viewAllow">
                <language-template-slider-by-images-component
                    ref="refLanguageTemplateSliderByImages"
                    :params="configModalLanguageTemplateSliderByImages"
                    v-on:_templateSliderByImages-emit="_templateSliderByImages($event)"
                >
                </language-template-slider-by-images-component>
            </div>
            <b-modal
                hide-footer
                id="modal-template-slider-by-images"
                ref="refTemplateSliderByImagesModal"
                size="xl"
            <?php echo '@show="_showModal"'; ?>    <?php echo '@hidden="_hideModal"'; ?>    <?php echo '@ok="_saveModal"'; ?>>
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
                            <?php echo "{{ showManager?'Regresar':'Nuevo' }}"; ?>    </button>
                        <button v-if="showManager" type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{ managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update }}'; ?>    </button>

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
                        <b-form id="templateSliderByImagesForm" v-on:submit.prevent="_submitForm">


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
                                                class="form__label "
                                                v-html='getLabelForm("status")'
                                            ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.status.$model"
                                                        v-bind:id="getNameAttribute('status')"
                                                        v-bind:name="getNameAttribute('status')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.status.options"
                                                            v-bind:value="row.value"><?php echo '{{ row.text }}'; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php echo '{{ model.structure.status.required.msj }}'; ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('type_multimedia',$v.model.attributes.type_multimedia)">
                                            <label class="form__label "    v-html='getLabelForm("type_multimedia")'></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.type_multimedia.$model"
                                                        v-bind:id="getNameAttribute('type_multimedia')"
                                                        v-bind:name="getNameAttribute('type_multimedia')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('type_multimedia', $v.model.attributes.type_multimedia.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.type_multimedia.options"
                                                            v-bind:value="row.value"><?php echo '{{ row.text }}'; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.type_multimedia.$error">
      <span v-if="!$v.model.attributes.type_multimedia.required">
       <?php echo '{{ model.structure.type_multimedia.required.msj }}'; ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('position',$v.model.attributes.position)">
                                            <label
                                                class="form__label " v-html='getLabelForm("position")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.position.$model"
                                                    type="number"
                                                    v-bind:id="getNameAttribute('position')"
                                                    v-bind:name="getNameAttribute('position')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('position', $v.model.attributes.position.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.position.$error">
      <span v-if="!$v.model.attributes.position.required">
       <?php echo '{{ model.structure.position.required.msj }}'; ?>
      </span>
                                                    <span v-if="!$v.model.attributes.position.maxLength">
       <?php echo '{{ model.structure.position.maxLength.msj }}'; ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>

                                </b-row>
                                <b-row>
                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="content-box-image content-box-preview" id="manager-source"

                                             :class="getClassErrorForm('source',$v.model.attributes.source)"
                                        >
                                            <img class="content-box-image__preview" id="preview-source">
                                            <div>

                                                <input
                                                    v-initEventUploads="{initMethod:_initEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                                    type="file"
                                                    id="file-source"
                                                    v-bind:name="getNameAttribute('source')"
                                                >
                                            </div>
                                        </div>
                                        <div class="progress-gallery-image not-view" id="manager-progress-source">
                                            <div class="progress__bar"></div>
                                            <div class="progress__percent">0%</div>
                                        </div>
                                        <div class="content-message-errors content-message-errors--image" >
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.source.$error">
      <span v-if="!$v.model.attributes.source.required">
       <?php echo '{{ model.structure.source.required.msj }}'; ?>
      </span>
                                                <span v-if="!$v.model.attributes.source.maxLength">
       <?php echo '{{ model.structure.source.maxLength.msj }}'; ?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-row>
                                <b-row>
                                    <b-col md="12" v-if="$v.model.attributes.type_multimedia.$model=='1'">
                                        <div class="form-group"
                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")'></label>
                                            <div class="content-element-form">
<textarea
    rows="5" class="form-control"
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
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="12" v-if="$v.model.attributes.type_multimedia.$model=='1'">
                                        <div class="form-group"
                                             :class="getClassErrorForm('subtitle',$v.model.attributes.subtitle)">
                                            <label
                                                class="form__label " v-html='getLabelForm("subtitle")'></label>
                                            <div class="content-element-form">
<textarea
    rows="5" class="form-control"
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
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('type_button',$v.model.attributes.type_button)">
                                            <label class="form__label " v-html='getLabelForm("type_button")'></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.type_button.$model"
                                                        v-bind:id="getNameAttribute('type_button')"
                                                        v-bind:name="getNameAttribute('type_button')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('type_button', $v.model.attributes.type_button.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.type_button.options"
                                                            v-bind:value="row.value"><?php echo '{{ row.text }}'; ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.type_button.$error">
      <span v-if="!$v.model.attributes.type_button.required">
       <?php echo '{{ model.structure.type_button.required.msj }}'; ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>

                                </b-row>
                                <b-row>

                                    <b-col md="4" v-if="$v.model.attributes.type_button.$model">
                                        <div class="form-group"
                                             :class="getClassErrorForm('button_name',$v.model.attributes.button_name)">
                                            <label
                                                class="form__label " v-html='getLabelForm("button_name")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.button_name.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('button_name')"
                                                    v-bind:name="getNameAttribute('button_name')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('button_name', $v.model.attributes.button_name.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.button_name.$error">
      <span v-if="!$v.model.attributes.button_name.required">
       <?php echo '{{ model.structure.button_name.required.msj }}'; ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="8" v-if="$v.model.attributes.type_button.$model">
                                        <div class="form-group"
                                             :class="getClassErrorForm('button_link_manager',$v.model.attributes.button_link_manager)">
                                            <label
                                                class="form__label "  v-html='getLabelForm("button_link_manager")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.button_link_manager.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('button_link_manager')"
                                                    v-bind:name="getNameAttribute('button_link_manager')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('button_link_manager', $v.model.attributes.button_link_manager.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.button_link_manager.$error">
      <span v-if="!$v.model.attributes.button_link_manager.required">
       <?php echo '{{ model.structure.button_link_manager.required.msj }}'; ?>
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
                        <table id="template-slider-by-images-grid"
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
