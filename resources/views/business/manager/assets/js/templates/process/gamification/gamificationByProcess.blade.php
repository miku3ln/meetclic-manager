<script type='text/x-template' id='gamification-by-process-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-gamification-by-process"
                ref="refGamificationByProcessModal"
                size="xl"
                <?php echo '@show="_showModal"' ?><?php echo '@hidden="_hideModal"' ?><?php echo '@ok="_saveModal"' ?>>
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
                            <?php echo "{{showManager?'Regresar':'Nuevo'}}" ?>    </button>
                        <button v-if="showManager" type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}' ?>    </button>

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
                        <b-form id="gamificationByProcessForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <legend
                                    class="h6 mb-2 legend--section">    <?php echo "{{sectionsProcess.one}}" ?></legend>
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('state',$v.model.attributes.state)">
                                            <label class="form__label " v-html='getLabelForm("state")'></label>
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
       <?php echo "{{model.structure.state.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('execution_channel',$v.model.attributes.execution_channel)">
                                            <label class="form__label "
                                                   v-html='getLabelForm("execution_channel")'></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.execution_channel.$model"
                                                        v-bind:id="getNameAttribute('execution_channel')"
                                                        v-bind:name="getNameAttribute('execution_channel')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('execution_channel', $v.model.attributes.execution_channel.$model)"
                                                >
                                                    <option
                                                        v-for="(row,index) in model.structure.execution_channel.options"
                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.execution_channel.$error">
      <span v-if="!$v.model.attributes.execution_channel.required">
       <?php echo "{{model.structure.execution_channel.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>


                                </b-row>
                                <b-row>

                                    <b-col lg="3">

                                        <div class="form-group"
                                             :class="getClassErrorForm('vigencia',$v.model.attributes.vigencia)">
                                            <label class="form__label"
                                                   v-bind:for="getNameAttribute('vigencia')"
                                                   v-html='getLabelForm("vigencia")'></label>
                                            <div class="toggle">
                                                <input
                                                    v-model="$v.model.attributes.vigencia.$model"
                                                    type="checkbox"
                                                    v-bind:id="getNameAttribute('vigencia')"
                                                    v-bind:name="getNameAttribute('vigencia')"
                                                    @change="_setValueForm('vigencia',$v.model.attributes.vigencia.$model)"
                                                    v-focus-select
                                                >
                                                <label v-bind:for="getNameAttribute('vigencia')">
                                                    <div class="toggle__switch"></div>
                                                </label>
                                            </div>

                                        </div>
                                    </b-col>
                                    <b-col lg="4" v-if="$v.model.attributes.vigencia.$model">

                                        <date-time-picker-bs4
                                            v-model="$v.model.attributes.valid_from.$model"
                                            label="Valido desde"
                                            :disablePast="true"
                                            @status-change="onValidFrom"
                                        />
                                    </b-col>
                                    <b-col lg="4" v-if="$v.model.attributes.vigencia.$model">

                                        <date-time-picker-bs4
                                            v-model="$v.model.attributes.valid_until.$model"
                                            label="Válido hasta"
                                            :minDateTime="$v.model.attributes.valid_from.$model"
                                        @status-change="onValidUntil"
                                        />
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col lg="8" v-bind:info="$v.model.attributes.frequency_limit_type.$model">
                                        <frequency-limit-type-bs4
                                            v-model="$v.model.attributes.frequency_limit_type.$model"
                                            :options="model.structure.frequency_limit_type.frequencyOptions"
                                            layout="horizontal"
                                            @status-change="onFreqStatus"
                                        />
                                    </b-col>

                                    <b-col lg="4" v-if="$v.model.attributes.frequency_limit_type.$model=='TOTAL_LIMIT'" >
                                        <div class="form-group"

                                             :class="getClassErrorForm('frequency_limit_value',$v.model.attributes.frequency_limit_value)">
                                            <label
                                                class="form__label "
                                                v-html='getLabelForm("frequency_limit_value")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.frequency_limit_value.$model"
                                                    type="number"
                                                    min="1"

                                                    v-bind:id="getNameAttribute('frequency_limit_value')"
                                                    v-bind:name="getNameAttribute('frequency_limit_value')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('frequency_limit_value', $v.model.attributes.frequency_limit_value.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.frequency_limit_value.$error">
                                                      <span v-if="!$v.model.attributes.frequency_limit_value.required">
       <?php echo "{{model.structure.frequency_limit_value.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                                <legend
                                    class="h6 mb-2 legend--section">    <?php echo "{{sectionsProcess.two}}" ?></legend>
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('unique_code',$v.model.attributes.unique_code)">
                                            <label
                                                class="form__label " v-html='getLabelForm("unique_code")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.unique_code.$model"
                                                    type="text"

                                                    v-bind:id="getNameAttribute('unique_code')"
                                                    v-bind:name="getNameAttribute('unique_code')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('unique_code', $v.model.attributes.unique_code.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.unique_code.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('entity',$v.model.attributes.entity)">
                                            <label
                                                class="form__label " v-html='getLabelForm("entity")'></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.entity.$model"
                                                        v-bind:id="getNameAttribute('entity')"
                                                        v-bind:name="getNameAttribute('entity')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('entity', $v.model.attributes.entity.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.entity.options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>

                                                <div role="alert" aria-live="polite" aria-atomic="true" class="alert "
                                                     v-bind:class="getClassMessage($v.model.attributes)">
                                                    <?php echo '{{messageSectionsActivities[$v.model.attributes.entity.$model].text}}' ?>
                                                </div>

                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.entity.$error">
      <span v-if="!$v.model.attributes.entity.required">
       <?php echo "{{model.structure.entity.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4" v-if="$v.model.attributes.has_source.$model">
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
       <?php echo "{{model.structure.source.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                                <legend
                                    class="h6 mb-2 legend--section">    <?php echo "{{sectionsProcess.three}}" ?></legend>

                                <b-row>
                                    <b-col v-bind:md="$v.model.attributes.entity.$model==1||$v.model.attributes.entity.$model==3||$v.model.attributes.entity.$model==4?'4':'0'"
                                           v-if="$v.model.attributes.entity.$model==1||$v.model.attributes.entity.$model==3||$v.model.attributes.entity.$model==4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('entity_id_data',$v.model.attributes.entity_id_data)">
                                            <label
                                                class="form__label " v-html='getLabelFormByEntity($v.model.attributes.entity.$model)'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.entity_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('entity_id_data')"
                                                    v-bind:name="getNameAttribute('entity_id_data')"
                                                    @change="_setValueForm('entity_id_data', $v.model.attributes.entity_id_data.$model)"
                                                    v-reset-field="{form:$v.model.attributes,fieldName:'entity_id_data'}"

                                                >
                                                <select
                                                    :key="`entity_id_data_${$v.model.attributes.entity.$model}_1`"
                                                    class="form-control m-select2"
                                                    v-if="$v.model.attributes.entity.$model==1"
                                                    v-init-s2-manager="{ rowId:model.attributes.id, _initS2Manager:_managerS2Products }"
                                                ></select>

                                                <select
                                                    :key="`entity_id_data_${$v.model.attributes.entity.$model}_3`"
                                                    class="form-control m-select2"
                                                    v-if="$v.model.attributes.entity.$model==3"
                                                    v-init-s2-manager="{ rowId:model.attributes.id, _initS2Manager:_managerS2Forms }"
                                                ></select>

                                                <select
                                                    :key="`entity_id_data_${$v.model.attributes.entity.$model}_4`"
                                                    class="form-control m-select2"
                                                    v-if="$v.model.attributes.entity.$model==4"
                                                    v-init-s2-manager="{ rowId:model.attributes.id, _initS2Manager:_managerS2Routes }"
                                                ></select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.entity_id_data.$error">
      <span v-if="!$v.model.attributes.entity_id_data.required">
       <?php echo "{{model.structure.entity_id_data.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col v-bind:md="$v.model.attributes.entity.$model==1||$v.model.attributes.entity.$model==3||$v.model.attributes.entity.$model==4?'4':'6'">
                                        <div class="form-group"

                                             :class="getClassErrorForm('gamification_type_activity_id_data',$v.model.attributes.gamification_type_activity_id_data)">
                                            <label
                                                class="form__label "
                                                v-html='getLabelForm("gamification_type_activity_id_data")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.gamification_type_activity_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('gamification_type_activity_id_data')"
                                                    v-bind:name="getNameAttribute('gamification_type_activity_id_data')"
                                                    @change="_setValueForm('gamification_type_activity_id_data', $v.model.attributes.gamification_type_activity_id_data.$model)"
                                                >
                                                <select id="gamification_type_activity_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2GamificationTypeActivity="{rowId:model.attributes.id,_managerS2GamificationTypeActivity:_managerS2GamificationTypeActivity}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.gamification_type_activity_id_data.$error">
      <span v-if="!$v.model.attributes.gamification_type_activity_id_data.required">
       <?php echo "{{model.structure.gamification_type_activity_id_data.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>

                                    <b-col v-bind:md="$v.model.attributes.entity.$model==1||$v.model.attributes.entity.$model==3||$v.model.attributes.entity.$model==4?'4':'6'">
                                        <div class="form-group"

                                             :class="getClassErrorForm('points',$v.model.attributes.points)">
                                            <label
                                                class="form__label " v-html='getLabelForm("points")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.points.$model"
                                                    type="number"
                                                    min="0"
                                                    v-bind:id="getNameAttribute('points')"
                                                    v-bind:name="getNameAttribute('points')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('points', $v.model.attributes.points.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.points.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>

                                </b-row>
                                <legend
                                    class="h6 mb-2 legend--section">    <?php echo "{{sectionsProcess.four}}" ?></legend>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group"

                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")'>
                                            </label>
                                            <div class="content-element-form">
<textarea
    rows="2" class="form-control"
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
       <?php echo "{{model.structure.title.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="6">
                                        <div class="form-group"

                                             :class="getClassErrorForm('subtitle',$v.model.attributes.subtitle)">
                                            <label
                                                class="form__label " v-html='getLabelForm("subtitle")'></label>
                                            <div class="content-element-form">
<textarea
    rows="2" class="form-control"
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
                                            <label
                                                class="form__label " v-html='getLabelForm("description")'></label>
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
      <span v-if="!$v.model.attributes.description.required">
       <?php echo "{{model.structure.description.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <legend
                                    class="h6 mb-2 legend--section">    <?php echo "{{sectionsProcess.five}}" ?></legend>
                                <b-row>
                                    <b-col md="3">
                                        <div class="form-group"

                                             :class="getClassErrorForm('is_url',$v.model.attributes.is_url)">
                                            <label
                                                class="form__label " v-html='getLabelForm("is_url")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.is_url.$model"
                                                    type="checkbox"
                                                    v-bind:id="getNameAttribute('is_url')"
                                                    v-bind:name="getNameAttribute('is_url')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('is_url', $v.model.attributes.is_url.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.is_url.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>


                                    <b-col md="6" v-if="allowManagerUrl.view">
                                        <div class="form-group"

                                             :class="getClassErrorForm('url_manager',$v.model.attributes.url_manager)">
                                            <label>
                                       <span v-bind:class="'link-manager '+allowManagerUrl.class">
                                           <a v-bind:href="<?php echo "allowManagerUrl.url"?>"
                                              target="_blank"><?php echo "{{allowManagerUrl.message}}" ?></a>
                                           </span>

                                            </label>
                                        </div>
                                        <div class="qr__container" v-if="allowManagerUrl.generateAllow">
                                            <button class="btn btn-primary" type="button"
                                                    v-on:click="onDownloadQR">
                                                <i class="fas fa-download"></i></button>
                                            <div id="qrcode" v-initQR="{dataQr:allowManagerUrl.dataQr}"></div>
                                            <div id="label-preview" class="qr__label"></div>
                                        </div>
                                    </b-col>
                                </b-row>

                                <legend
                                    class="h6 mb-2 legend--section">    <?php echo "{{sectionsProcess.six}}" ?></legend>
                                <b-row>
                                    <b-col md="3" v-if="$v.model.attributes.is_url.$model">
                                        <div class="form-group"
                                             :class="getClassErrorForm('url_manager_data',$v.model.attributes.url_manager_data)">
                                            <label
                                                class="form__label " v-html='getLabelForm("url_manager_data")'></label>
                                            <div class="content-element-form">

                                                <input
                                                    v-model="$v.model.attributes.url_manager_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('url_manager_data')"
                                                    v-bind:name="getNameAttribute('url_manager_data')"
                                                    @change="_setValueForm('url_manager_data', $v.model.attributes.url_manager_data.$model)"
                                                    v-reset-field="{form:$v.model.attributes,fieldName:'url_manager_data'}"

                                                >
                                                <select id="url_manager_data"
                                                        class="form-control m-select2 "
                                                        v-initS2Entity="{rowId:model.attributes.id,functionCurrent:_managerS2UrlManager}"
                                                >
                                                </select>

                                            </div>

                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="viewErrorMessage({'attribute':'url_manager_data'})">
      <span v-if="!$v.model.attributes.url_manager_data.required">
       <?php echo "{{model.structure.url_manager_data.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col v-bind:md="$v.model.attributes.is_url.$model?'3':'4'">
                                        <div class="form-group"

                                             :class="getClassErrorForm('campaign_code_template',$v.model.attributes.campaign_code_template)">
                                            <label
                                                class="form__label "
                                                v-html='getLabelForm("campaign_code_template")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.campaign_code_template.$model"
                                                    type="text"

                                                    v-bind:id="getNameAttribute('campaign_code_template')"
                                                    v-bind:name="getNameAttribute('campaign_code_template')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('campaign_code_template', $v.model.attributes.campaign_code_template.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.campaign_code_template.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col v-bind:md="$v.model.attributes.is_url.$model?'3':'4'">
                                        <div class="form-group"

                                             :class="getClassErrorForm('tracking_type_id_data',$v.model.attributes.tracking_type_id_data)">
                                            <label
                                                class="form__label "
                                                v-html='getLabelForm("tracking_type_id_data")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.tracking_type_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('tracking_type_id_data')"
                                                    v-bind:name="getNameAttribute('tracking_type_id_data')"
                                                    @change="_setValueForm('tracking_type_id_data', $v.model.attributes.tracking_type_id_data.$model)"
                                                >
                                                <select id="tracking_type_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2Entity="{rowId:model.attributes.id,functionCurrent:_managerS2TrackingType}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.tracking_type_id_data.$error">
      <span v-if="!$v.model.attributes.tracking_type_id_data.required">
       <?php echo "{{model.structure.tracking_type_id_data.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col v-bind:md="$v.model.attributes.is_url.$model?'3':'4'">
                                        <div class="form-group"

                                             :class="getClassErrorForm('tracking_source_id_data',$v.model.attributes.tracking_source_id_data)">
                                            <label
                                                class="form__label "
                                                v-html='getLabelForm("tracking_source_id_data")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.tracking_source_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('tracking_source_id_data')"
                                                    v-bind:name="getNameAttribute('tracking_source_id_data')"
                                                    @change="_setValueForm('tracking_source_id_data', $v.model.attributes.tracking_source_id_data.$model)"
                                                >
                                                <select id="tracking_source_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2Entity="{rowId:model.attributes.id,functionCurrent:_managerS2TrackingSource}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.tracking_source_id_data.$error">
      <span v-if="!$v.model.attributes.tracking_source_id_data.required">
       <?php echo "{{model.structure.tracking_source_id_data.required.msj}}" ?>




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
                        <table id="gamification-by-process-grid"
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

