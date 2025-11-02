<script type='text/x-template' id='business-by-history-template'>
    <div>
        <div v-if="configModalBusinessHistoryByData.viewAllow">
            <business-history-by-data-component
                ref="refTBusinessHistoryByData"
                :params="configModalBusinessHistoryByData"
            >
            </business-history-by-data-component>
        </div>
        <div v-if="configModalLanguageBusinessByHistory.viewAllow">
            <language-business-by-history-component
                ref="refLanguageBusinessByHistory"
                :params="configModalLanguageBusinessByHistory"
                v-on:_businessByHistory-emit="_businessByHistory($event)"
            >
            </language-business-by-history-component>
        </div>
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
                        <?php echo '{{managerType==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>


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
                    <table id="business-by-history-grid"
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
                <b-form id="businessByHistoryForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")'></label>
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
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('main',$v.model.attributes.main)">
                                    <label class="form__label " v-html='getLabelForm("main")'></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.main.$model"
                                                v-bind:id="getNameAttribute('main')"
                                                v-bind:name="getNameAttribute('main')"
                                                class="form-control m-input"
                                                @change="_setValueForm('main', $v.model.attributes.main.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.main.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
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

                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('author',$v.model.attributes.author)">
                                    <label class="form__label " v-html='getLabelForm("author")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.author.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('author')"
                                            v-bind:name="getNameAttribute('author')"
                                            class="form-control m-input"
                                            @change="_setValueForm('author', $v.model.attributes.author.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.author.$error">
      <span v-if="!$v.model.attributes.author.required">
       <?php  echo "{{model.structure.author.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.author.maxLength">
       <?php  echo "{{model.structure.author.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('author_titles',$v.model.attributes.author_titles)">
                                    <label class="form__label " v-html='getLabelForm("author_titles")'></label>
                                    <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.author_titles.$model"
    v-bind:id="getNameAttribute('author_titles')"
    v-bind:name="getNameAttribute('author_titles')"
    @change="_setValueForm('author_titles', $v.model.attributes.author_titles.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.author_titles.$error">
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
                                        class="form__label " v-html='getLabelForm("allow_source_data")'></label>
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
                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label " v-html='getLabelForm("value")'></label>
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
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('subtitle',$v.model.attributes.subtitle)">
                                    <label class="form__label " v-html='getLabelForm("subtitle")'></label>
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
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('description',$v.model.attributes.description)">
                                    <label class="form__label " v-html='getLabelForm("description")'></label>
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
                                        <div class="description" id="description"
                                             v-initSummerNote="{initMethod:_initSummerNote}"></div>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.description.$error">
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

