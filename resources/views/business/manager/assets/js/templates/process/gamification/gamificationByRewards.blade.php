<script type='text/x-template' id='gamification-by-rewards-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-gamification-by-rewards"
                ref="refGamificationByRewardsModal"
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
                        <b-form id="gamificationByRewardsForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
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
       <?php  echo "{{model.structure.state.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('has_source',$v.model.attributes.has_source)">
                                            <label
                                                class="form__label " v-html='getLabelForm("has_source")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.has_source.$model"
                                                    type="checkbox"
                                                    v-bind:id="getNameAttribute('has_source')"
                                                    v-bind:name="getNameAttribute('has_source')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('has_source', $v.model.attributes.has_source.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.has_source.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
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
       <?php  echo "{{model.structure.source.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>


                                </b-row>
                                <b-row>
                                    <b-col md="3">
                                        <div class="form-group"
                                             :class="getClassErrorForm('specific',$v.model.attributes.specific)">
                                            <label
                                                class="form__label " v-html='getLabelForm("specific")'></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.specific.$model"
                                                        v-bind:id="getNameAttribute('specific')"
                                                        v-bind:name="getNameAttribute('specific')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('specific', $v.model.attributes.specific.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.specific.options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.specific.$error">
      <span v-if="!$v.model.attributes.specific.required">
       <?php  echo "{{model.structure.specific.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4" v-if="$v.model.attributes.specific.$model==1">

                                            <div class="form-group"

                                                 :class="getClassErrorForm('entity_id_data',$v.model.attributes.entity_id_data)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("entity_id_data")'></label>
                                                <div class="content-element-form">
                                                    <input
                                                        v-model="$v.model.attributes.entity_id_data.model"
                                                        type="hidden"
                                                        v-bind:id="getNameAttribute('entity_id_data')"
                                                        v-bind:name="getNameAttribute('entity_id_data')"
                                                        @change="_setValueForm('entity_id_data', $v.model.attributes.entity_id_data.$model)"
                                                        v-reset-field="{form:$v.model.attributes,fieldName:'entity_id_data'}"

                                                    >
                                                    <select id="entity_id_data"
                                                            class="form-control m-select2 "
                                                            v-initS2Manager="{rowId:model.attributes.id,_initS2Manager:_managerS2Products}"
                                                    >
                                                    </select>
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.entity_id_data.$error">
      <span v-if="!$v.model.attributes.entity_id_data.required">
       <?php  echo "{{model.structure.entity_id_data.required.msj}}"?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                    </b-col>
                                    <b-col md="4" v-if="$v.model.attributes.specific.$model==3">
                                        <div class="form-group"
                                             :class="getClassErrorForm('entity_id_data',$v.model.attributes.entity_id_data)">
                                            <label
                                                class="form__label " v-html='getLabelForm("entity_id_data")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model="$v.model.attributes.entity_id_data.model"
                                                    type="hidden"
                                                    v-bind:id="getNameAttribute('entity_id_data')"
                                                    v-bind:name="getNameAttribute('entity_id_data')"
                                                    @change="_setValueForm('entity_id_data', $v.model.attributes.entity_id_data.$model)"
                                                    v-reset-field="{form:$v.model.attributes,fieldName:'entity_id_data'}"

                                                >
                                                <select id="entity_id_data"
                                                        class="form-control m-select2 "
                                                        v-initS2Manager="{rowId:model.attributes.id,_initS2Manager:_managerS2Services}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.entity_id_data.$error">
      <span v-if="!$v.model.attributes.entity_id_data.required">
       <?php  echo "{{model.structure.entity_id_data.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>

                                    <b-col md="2">
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
                                <b-row>
                                    <b-col md="3">
                                        <div class="form-group"
                                             :class="getClassErrorForm('entity',$v.model.attributes.entity)">
                                            <label
                                                class="form__label "  v-html='getLabelForm("entity")'></label>
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
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.entity.$error">
      <span v-if="!$v.model.attributes.entity.required">
       <?php  echo "{{model.structure.entity.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="2" v-if="$v.model.attributes.entity.$model==0">
                                        <div class="form-group"
                                             :class="getClassErrorForm('percentage',$v.model.attributes.percentage)">
                                            <label
                                                class="form__label "  v-html='getLabelForm("percentage")'></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.percentage.$model"
                                                    type="number"
                                                    v-bind:id="getNameAttribute('percentage')"
                                                    v-bind:name="getNameAttribute('percentage')"
                                                    min="0" class="form-control m-input"
                                                    max="100"
                                                    @change="_setValueForm('percentage', $v.model.attributes.percentage.$model)"
                                                    v-focus-select

                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.percentage.$error">
      <span v-if="!$v.model.attributes.percentage.required">
       <?php  echo "{{model.structure.percentage.required.msj}}"?>
      </span>
                                                    <br>
                                                    <span v-if="!$v.model.attributes.percentage.between">
       <?php  echo "{{model.structure.percentage.between.msj +model.structure.percentage.between.min +'y' +model.structure.percentage.between.max}}"?>
      </span>


                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group"

                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")'></label>
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
       <?php  echo "{{model.structure.title.required.msj}}"?>
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
                        <table id="gamification-by-rewards-grid"
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

